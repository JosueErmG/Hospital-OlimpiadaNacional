<!DOCTYPE html>

<?php
    include "config/functions.php";
    $_SESSION["lastfile"] = basename(__FILE__);
    if (!CheckSession())
        LogOut();

    if ($_SESSION["is_area"] or !$_SESSION["user"][7]) {
        include "unauthorized.php";
        exit;
    }

    $error = "&nbsp";
    if (!isset($_POST["submit"])) {
        $uFile = ""; $uDNI = "";
        $uName = ""; $uLastname = "";
        $uArea = "";
        $uEmail = ""; $uNumber = "+54 291 ___-____";
        $uPass = ""; $rePass = "";
    }
    else {
        $uFile = $_POST["uFile"]; $uDNI = $_POST["uDNI"];
        $uName = $_POST["uName"]; $uLastname = $_POST["uLastname"];
        $uArea = $_POST["uArea"];
        $uEmail = $_POST["uEmail"]; $uNumber = $_POST["uNumber"];
        $uPass = $_POST["uPass"]; $rePass = $_POST["rePass"];
        
        if (!is_numeric($uFile) or $uFile < 1 or $uFile > 99999999)
            $error = "Número de legajo inválido";
        else if (!is_numeric($uDNI) or $uDNI < 999999)
            $error = "Número de documento inválido";
        else if (!is_numeric($uArea) or $uArea < 1)
            $error = "Código de área inválido";
        else if (CheckPass($uPass, $errorStr))
            $error = $errorStr;
        else if ($uPass != $rePass)
            $error = "Las contraseñas no coinciden";
        else {
            try {
                InsertInTable(
                    "usuarios",
                    "legajo, DNI, pass, nombre, apellido, telefono, email, areaCodigo",
                    "'$uFile', '$uDNI', '" . password_hash($uPass, PASSWORD_DEFAULT) . "', '$uName', '$uLastname', '$uNumber', '$uEmail', '$uArea'"
                );
                $uFile = ""; $uDNI = "";
                $uName = ""; $uLastname = "";
                $uArea = "";
                $uEmail = ""; $uNumber = "+54 291 ___-____";
                $uPass = ""; $rePass = "";
            }
            catch (Exception $ex) {
                $error = "No se ha podido crear el usuario: " . $ex->getMessage();
            }
        }
    }
    
    $search = isset($_POST["dt_search"]) ? $_POST["dt_search"] : "";
    $DTh = GetDTHeight();

    $limit = $DTh != 0 ? max(floor($DTh / GetDTRowHeight()), 1) : 10;
    $totalPages = ceil(TableRowsCount("usuariosview") / $limit);
    $curPage = isset($_POST["dt_curPage"]) ? min(max(1, $_POST["dt_curPage"]), $totalPages) : 1;
    $offset = ($curPage - 1) * $limit;
    $rows = GetTable("usuariosview", $offset, $limit, $search);
?>

<html lang="es" data-theme="<?= $_COOKIE['theme'] ?>">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.svg">

		<title>Hospital</title>

		<link rel="stylesheet" href="styles/users.css"/>
        <link rel="stylesheet" href="styles/fonts.css">

        <script>
            if (window.history.replaceState)
                window.history.replaceState(null, null, window.location.href);
        </script>
	</head>

    <body>
        <header>
            <div class="u_centered">
                <svg id="header_logo" viewBox="0 0 24 24">
                    <path d="
                        M10.5,16.5h3v-3h3v-3h-3v-3h-3v3h-3v3h3V16.5z M12,23c-2.5-0.6-4.7-2.1-6.3-4.4S3.2,
                        13.8,3.2,11V4.3L12,1l8.8,3.3V11c0,2.8-0.8,5.3-2.5,7.6S14.5,22.4,12,23z
                    "/>
                </svg>
                <input type="checkbox" id="inpNavToggle">
                <label id="header_NavToggle" for="inpNavToggle">
                    <i class="material-icons">menu</i>
                </label>
                <nav id="header_nav">
                    <a href="buttons.php">Emergencias</a>
                    <a href="reports.php">Reportes</a>
                    <a href="healthsheets.php">Fichas de salud</a>
                    <a href="users.php" class="selected">Usuarios</a>
                    <a href="areas.php">Áreas</a>
                    <a href="config/logout.php">Log out</a>
                    <input type="checkbox" id="inpTheme" onclick="ChangeTheme();" checked>
                    <label id="header_theme" for="inpTheme">
                        <i class="material-icons">brightness_medium</i>
                    </label>
                </nav>
            </div>
        </header>

        <main class="centered">
            <div class="grid-two">
                <section class="search_datatable">
                    <form class="search card" method="POST" action="#" autocomplete="off">
                        <input type="text" id="dt_search" name="dt_search" placeholder="Buscar" value="<?= $search ?>"
                               oninput="document.getElementById('dt_search_submit').disabled = this.value == '<?= $search ?>';">
                        <button type="submit" id="dt_search_submit" name="dt_search_submit" disabled>Buscar</button>
                    </form>
                    <div class="datatable_controls card">
                        <div id="datatable" class="datatable">
                            <table>
                                <tr class="datatable_hrow">
                                    <?php if (count($rows) > 0) foreach ($rows[0] as $key => $value) { ?>
                                        <th><?= nl2br(htmlspecialchars($key)) ?></th>
                                    <?php } ?>
                                    <th class="datatable_del_button"></th>
                                </tr>
                                <?php foreach ($rows as $row) { ?>
                                    <tr  class="datatable_drow" id="datatable_row_<?= $row['Legajo'] ?>">
                                        <?php foreach ($row as $column) { ?>
                                            <td class="datatable_td"><?= nl2br(htmlspecialchars($column)) ?></td>
                                        <?php } ?>
                                        <td id="database_del_<?= $row['Legajo'] ?>" class="datatable_td datatable_del_button" 
                                            onclick="DtDelete(this, 'usuarios', 'legajo');">delete</td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <?php if (count($rows) >= $limit) { ?>
                        <script>
                            document.getElementById("datatable").getElementsByTagName("table")[0].style.height = "100%";
                        </script>
                        <?php }
                            SetDTHeight("datatable", "table");
                        ?>
                        <form class="controls card" method="POST" action="#" autocomplete="off">
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', 1)">keyboard_double_arrow_left</button>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', '-1', 1, <?= $totalPages ?>)">chevron_left</button>
                            <input type="text" id="dt_curPage" name="dt_curPage" style="text-align: right" maxlength="<?= strlen($totalPages) ?>"
                                   value="<?= $curPage ?>" onchange="this.form.submit();" onkeypress="IntOrSubmit(event, this);">
                            <input type="text" value="<?= "/$totalPages" ?>" onfocus="this.blur();" readonly>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', '+1', 1, <?= $totalPages ?>)">chevron_right</button>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', <?= $totalPages ?>)">keyboard_double_arrow_right</button>
                        </form>
                    </div>
                </section>
                <form class="form-u card" method="POST" action="#" autocomplete="off">
                    <div class="united">
                        <label for="uFile">Legajo</label>
                        <label for="uDNI">DNI</label>
                        <input type="text" id="uFile" name="uFile" placeholder="Ingrese legajo..." value="<?= $uFile ?>" 
                               onkeypress="IntOrSubmit(event, this);" oninput="CheckUsersFormButton();">
                        <input type="text" id="uDNI" name="uDNI" placeholder="Ingrese DNI..." value="<?= $uDNI ?>"
                               onkeypress="IntOrSubmit(event, this);" oninput="CheckUsersFormButton();">
                    </div>
                    <label for="uName">Nombre</label>
                    <input type="text" id="uName" name="uName" placeholder="Ingrese nombre..." value="<?= $uName ?>"
                           oninput="CheckUsersFormButton();">
                    <label for="uLastname">Apellido</label>
                    <input type="text" id="uLastname" name="uLastname" placeholder="Ingrese apellido..." value="<?= $uLastname ?>"
                           oninput="CheckUsersFormButton();">
                    <label for="uArea">Código de área</label>
                    <input type="text" id="uArea" name="uArea" placeholder="Ingrese código de área..." value="<?= $uArea ?>"
                           onkeypress="IntOrSubmit(event, this);" oninput="CheckUsersFormButton();">
                    <div class="united">
                        <label for="uEmail">Email</label>
                        <label for="uNumber">Teléfono</label>
                        <input type="email" id="uEmail" name="uEmail" placeholder="Ingrese email..." value="<?= $uEmail ?>"
                               oninput="CheckUsersFormButton();">
                        <input type="tel" id="uNumber" name="uNumber" placeholder="Ingrese teléfono..." value="<?= $uNumber ?>" 
                               data-mask="+__ ___ ___-____" data-slots="_" 
                               oninput="CheckUsersFormButton();" onkeydown="TelephoneInput(event, this);">
                    </div>
                    <div class="united">
                        <label for="uPass">Contraseña</label>
                        <label for="rePass">Confirmar</label>
                        <input type="password" id="uPass" name="uPass" placeholder="Ingrese contraseña..." value="<?= $uPass ?>"
                               onfocus="CheckUsersPass();" oninput="CheckUsersPass();">
                        <input type="password" id="rePass" name="rePass" placeholder="Ingrese contraseña..." value="<?= $rePass ?>"
                               onfocus="CheckUsersRePass();" oninput="CheckUsersRePass();">
                    </div>

                    <label id="form_error_label" class="error_label"><?= $error ?></label>

                    <button type="submit" id="submit" name="submit" class="form-button-disabled"
                            onclick="UsersFormButton(event, this);" onfocus="CheckUsersForm();" onmouseover="CheckUsersForm();"
                            onfocusout="RestoreUsersForm();" onmouseout="RestoreUsersForm();" <?= $error != "&nbsp" ? "disabled" : "" ?>>Registrar</button>
                </form>
                <span id="bottom-padding">&nbsp</span>
            </div>
        </main>
    </body>

    <script src="scripts/jquery-3.6.0.min.js"></script>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

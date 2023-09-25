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
        $aName = ""; $aNumber = "+54 291 ___-____";
        $nPass = ""; $rePass = "";
    }
    else {
        $aName = $_POST["aName"]; $aNumber = $_POST["aNumber"];
        $nPass = $_POST["nPass"]; $rePass = $_POST["rePass"];

        if (CheckPass($nPass, $errorStr))
            $error = $errorStr;
        else if ($nPass != $rePass)
            $error = "Las contraseñas no coinciden";
        else {
            try {
                InsertInTable(
                    "areas",
                    "nombre, telefono, pass",
                    "'$aName', '$aNumber', '" . password_hash($nPass, PASSWORD_DEFAULT) . "'"
                );
                $aName = ""; $aNumber = "+54 291 ___-____";
                $nPass = ""; $rePass = "";
            }
            catch (Exception $ex) {
                $error = "No se ha podido crear el área: " . $ex->getMessage();
            }
        }
    }

    $search = isset($_POST["dt_search"]) ? $_POST["dt_search"] : "";
    $DTh = GetDTHeight();

    $limit = $DTh != 0 ? max(floor($DTh / GetDTRowHeight()), 1) : 10;
    $totalPages = ceil(TableRowsCount("areasview") / $limit);
    $curPage = isset($_POST["dt_curPage"]) ? min(max(1, $_POST["dt_curPage"]), $totalPages) : 1;
    $offset = ($curPage - 1) * $limit;
    $rows = GetTable("areasview", $offset, $limit, $search);
?>

<html lang="es" data-theme="<?= $_COOKIE['theme'] ?>">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.svg">

		<title>Hospital</title> 

		<link rel="stylesheet" href="styles/areas.css"/>
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
                    <a href="users.php">Usuarios</a>
                    <a href="areas.php" class="selected">Áreas</a>
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
                                    <tr class="datatable_drow" id="datatable_row_<?= $row['Código'] ?>">
                                        <?php foreach ($row as $column) { ?>
                                            <td class="datatable_td"><?= nl2br(htmlspecialchars($column)) ?></td>
                                        <?php } ?>
                                        <td id="database_del_<?= $row['Código'] ?>" class="datatable_td datatable_del_button" 
                                            onclick="DtDelete(this, 'areas', 'codigo');">delete</td>
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
                    <label for="aName">Nombre de área</label>
                    <input type="text" id="aName" name="aName" placeholder="Ingrese nombre..." value="<?= $aName ?>"
                           oninput="CheckAreasFormButton();">
                    <label for="aNumber">Teléfono de área</label>
                    <input type="tel" id="aNumber" name="aNumber" placeholder="Ingrese teléfono..." value="<?= $aNumber ?>" 
                           data-mask="+__ ___ ___-____" data-slots="_" 
                           oninput="CheckAreasFormButton();" onkeydown="TelephoneInput(event, this);">
                    <div class="united">
                        <label for="nPass">Contraseña</label>
                        <label for="rePass">Confirmar</label>
                        <input type="password" id="nPass" name="nPass" placeholder="Ingrese contraseña..." value="<?= $nPass ?>"
                               onfocus="CheckAreasPass();" oninput="CheckAreasPass();">
                        <input type="password" id="rePass" name="rePass" placeholder="Ingrese contraseña..." value="<?= $rePass ?>"
                               onfocus="CheckAreasRePass();" oninput="CheckAreasRePass();">
                    </div>

                    <label id="form_error_label" class="error_label"><?= $error ?></label>

                    <button type="submit" id="submit" name="submit" class="form-button-disabled"
                            onclick="AreasFormButton(event, this);" onfocus="CheckAreasForm();" onmouseover="CheckAreasForm();"
                            onfocusout="RestoreAreasForm();" onmouseout="RestoreAreasForm();" <?= $error != "&nbsp" ? "disabled" : "" ?>>Registrar</button>
                </form>
                <span id="bottom-padding">&nbsp</span>
            </div>
        </main>
    </body>

    <script src="scripts/jquery-3.6.0.min.js"></script>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

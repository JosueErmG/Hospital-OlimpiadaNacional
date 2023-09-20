<!DOCTYPE html>

<?php
    include("config/functions.php");
    $_SESSION["lastfile"] = basename(__FILE__);
    if (!CheckSession())
        LogOut();
?>

<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.png">

		<title>TITLE</title> 

		<link rel="stylesheet" href="styles/users.css"/>
        <link rel="stylesheet" href="styles/fonts.css">
	</head>

    <body>
        <header>
            <div class="u_centered">
                <label><i id="header_logo" class="material-icons">health_and_safety</i></label>
                <input type="checkbox" id="inpNavToggle">
                <label id="header_NavToggle" for="inpNavToggle">
                    <i class="material-icons">menu</i>
                </label>
                <nav id="header_nav">
                    <a href="buttons.php">Emergencias</a>
                    <a href="reports.php">Reportes</a>
                    <a href="healthsheets.php">Fichas de salud</a>
                    <a href="users.php">Usuarios</a>
                    <a href="areas.php">Areas</a>
                    <a href="config/logout.php">Log out</a>
                    <input type="checkbox" id="inpTheme" onclick="ChangeTheme(this.checked);" checked>
                    <label id="header_theme" for="inpTheme">
                        <i class="material-icons">brightness_medium</i>
                    </label>
                </nav>
            </div>
        </header>

        <main class="centered">
            <div class="grid2">
                <section class="search_datatable">
                    <form class="search card" method="POST" action="#" autocomplete="off">
                        <input type="text" id="dt_search" name="dt_search" placeholder="Buscar">
                    </form>
                    <div class="datatable_controls card">
                        <?php
                            $limit = floor(GetDTHeight() / 42);
                            $totalPages = ceil(TableRowsCount("usuariosview") / $limit);
                            $curPage = isset($_POST["dt_curPage"]) ? min(max(1, $_POST["dt_curPage"]), $totalPages) : 1;
                            $offset = ($curPage - 1) * $limit;

                            $rows = GetTable("usuariosview", $offset, $limit);
                        ?>
                        <div class="datatable">
                            <table id="datatable"> <!-- border="1" -->
                                <tr>
                                    <?php foreach($rows[0] as $key => $value) { ?>
                                        <th> <?= htmlspecialchars($key) ?></th>
                                    <?php } ?>
                                </tr>
                                <?php foreach($rows as $row) { ?>
                                    <tr>
                                        <?php foreach($row as $column) { ?>
                                            <td class="datatable_td"><?= htmlspecialchars($column) ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <?php if (count($rows) >= $limit) { ?>
                            <script>
                                document.getElementById("datatable").style.height = "100%";
                            </script>
                        <?php } ?>
                        <form class="controls card" method="POST" action="#" autocomplete="off">
                            <button type="submit" class="prevmost material-icons" onclick="ChangeInpVal(event, 'dt_curPage', 1)">keyboard_double_arrow_left</button>
                            <button type="submit" class="prev material-icons" onclick="ChangeInpVal(event, 'dt_curPage', '-1', 1, <?= $totalPages ?>)">chevron_left</button>
                            <input type="number" id="dt_curPage" name="dt_curPage" class="" style="text-align: right" value="<?= $curPage ?>" onchange="this.form.submit();" onkeypress="IntOrSubmit(event, this);">
                            <!-- onkeypress="IntOrSubmit(event, this);" -->
                            <input type="text" id="totalPages" name="totalPages" class="" value="<?= "/$totalPages" ?>" readonly>
                            <button type="submit" class="next material-icons" onclick="ChangeInpVal(event, 'dt_curPage', '+1', 1, <?= $totalPages ?>)">chevron_right</button>
                            <button type="submit" class="nextmost material-icons" onclick="ChangeInpVal(event, 'dt_curPage', <?= $totalPages ?>)">keyboard_double_arrow_right</button>
                        </form>
                    </div>
                </section>
                <form class="form-u card" autocomplete="off">
                    <div class="united">
                        <label for="uFile">Legajo</label>
                        <label for="uDNI">DNI</label>
                        <input class="textbox" type="number" id="uFile" name="uFile" placeholder="Ingrese legajo...">
                        <input class="textbox" type="number" id="uDNI" name="uDNI" placeholder="Ingrese DNI...">
                    </div>
                    <label for="uName">Nombre</label>
                    <input class="textbox" type="text" id="uName" name="uName" placeholder="Ingrese nombre...">
                    <label for="uLastname">Apellido</label>
                    <input class="textbox" type="text" id="uLastname" name="uLastname" placeholder="Ingrese apellido...">
                    <label for="uArea">Area</label>
                    <input class="textbox" type="text" id="uArea" name="uArea" placeholder="Ingrese area...">
                    <div class="united">
                        <label for="uEmail">Email</label>
                        <label for="uNumber">Telefono</label>
                        <input class="textbox" type="email" id="uEmail" name="uEmail" placeholder="Ingrese email...">
                        <input class="textbox" type="tel" id="uNumber" name="uNumber" placeholder="Ingrese telefono...">
                    </div>
                    <div class="united">
                        <label for="uPass">Contraseña</label>
                        <label for="rePass">Confirmar</label>
                        <input class="textbox" type="password" id="uPass" name="uPass" placeholder="Ingrese contraseña...">
                        <input class="textbox" type="password" id="rePass" name="rePass" placeholder="Ingrese contraseña...">
                    </div>

                    <button type="submit" id="submit" name="submit">Registrar</button>
                </form>
            </div>
        </main>
    </body>

    <script>

    </script>

	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

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

		<link rel="stylesheet" href="styles/buttons.css"/>
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

        <main>
            <div class="grid-container centered">
                <a href="" class="buttons-emergency" id="button-high">Emergencia Alta</a>
                <a href="" class="buttons-emergency" id="button-mid">Emergencia Media</a>
                <a href="" class="buttons-emergency" id="button-low">Emergencia Baja</a>
            </div>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

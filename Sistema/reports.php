<!DOCTYPE html>

<?php
    include("config/sessionhandling.php");
    if (!isset($_SESSION["user"]))
        header("Location: _index.php");
?>

<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.png">

		<title>TITLE</title> 

		<link rel="stylesheet" href="styles/reports.css"/>
        <link rel="stylesheet" href="styles/fonts.css">
	</head>

    <body>
        <header>
            <div class="u_centered">
                <img id="header_logo" src="" alt="">
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
                </nav>
            </div>
        </header>

        <main class="centered">
            <div>
                <h1>asdasd</h1>
            </div>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

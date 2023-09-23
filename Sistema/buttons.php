<!DOCTYPE html>

<?php
    include "config/functions.php";
    $_SESSION["lastfile"] = basename(__FILE__);
    if (!CheckSession())
        LogOut();

    $submitted = isset($_POST["button-high"]) ? 1 : 
                (isset($_POST["button-mid"]) ? 2 :
                (isset($_POST["button-low"]) ? 3 : 0));

    if ($submitted) {
        try {
            InsertInTable(
                "reportes",
                "nivel, fechaCreacion, usuarioLegajo, areaCodigo",
                "'$submitted', '" . date('Y-m-d H:i:s') . "', '" . $_SESSION["user"][0] . "', '" . $_SESSION["user"][8] . "'"
            );
            header("location: /reports.php");
        }
        catch (Exception $ex) {
            echo "<script>alert('No se ha podido crear el reporte: " . $ex->getMessage() . "')</script>";
        }
    }
?>

<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.svg">

		<title>Hospital</title> 

		<link rel="stylesheet" href="styles/buttons.css"/>
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
                    <a href="buttons.php" class="selected">Emergencias</a>
                    <a href="reports.php">Reportes</a>
                    <a href="healthsheets.php">Fichas de salud</a>
                    <?php if ($_SESSION["user"][7]) { ?>
                        <a href="users.php">Usuarios</a>
                        <a href="areas.php">Areas</a>
                    <?php } ?>
                    <a href="config/logout.php">Log out</a>
                    <input type="checkbox" id="inpTheme" onclick="ChangeTheme(this.checked);" checked>
                    <label id="header_theme" for="inpTheme">
                        <i class="material-icons">brightness_medium</i>
                    </label>
                </nav>
            </div>
        </header>

        <main>
            <form class="grid-container centered" method="POST" action="#" autocomplete="off">
                <button type="submit" id="button-high" name="button-high" class="buttons-emergency" id="button-high">Emergencia Alta</button>
                <button type="submit" id="button-mid" name="button-mid" class="buttons-emergency" id="button-mid">Emergencia Media</button>
                <button type="submit" id="button-low" name="button-low" class="buttons-emergency" id="button-low">Emergencia Baja</button>
            </form>


            
            <!-- <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var buttons = document.querySelectorAll(".buttons-emergency");

                    buttons.forEach(function (button) {
                        button.addEventListener("click", function (event) {
                            event.preventDefault();

                            var nivelEmergencia = this.id.replace("button-", "");

                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "buttons.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            var data = "nivelEmergencia=" + nivelEmergencia;

                            xhr.send(data);

                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log("Registro insertado en la base de datos");
                                }
                            };
                        });
                    });
                });
            </script>
            
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $conn = GetConn();
                    $nivelEmergencia = $_POST["nivelEmergencia"];

                    $sql = "INSERT INTO reportes (nivel, atendido, fechaCreacion) VALUES ('$nivelEmergencia', false, NOW())";

                    if ($conn->query($sql) === TRUE) {
                        echo "Registro insertado correctamente en la base de datos";
                    } else {
                        echo "Error al insertar el registro: " . $conn->error;
                    }
                    $conn->close();
                }
            ?> -->
        </main>
    </body>

	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

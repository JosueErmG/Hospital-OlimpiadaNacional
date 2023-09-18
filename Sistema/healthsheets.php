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

		<link rel="stylesheet" href="styles/healthsheets.css"/>
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
            <div class="grid2">
                <section class="search_datatable">
                    <div class="search">

                    </div>
                    <div class="datatable_controls">
                        <div class="datatable">
                            <table> <!-- border="1" -->
                                <?php
                                    include("config/dbconn.php");
                                    $query = mysqli_query($conn, "SELECT * FROM ficha LIMIT 15");
                                    $data = $query->fetch_all(MYSQLI_ASSOC);
                                ?>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Datos medicos</th>
                                    <th>Enfermero/Medico</th>
                                </tr>
                                <?php foreach($data as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["DNI"]) ?></td>
                                        <td><?= htmlspecialchars($row["nombre"]) ?></td>
                                        <td><?= htmlspecialchars($row["apellido"]) ?></td>
                                        <td><?= htmlspecialchars($row["datosMedicos"]) ?></td>
                                        <td><?= htmlspecialchars($row["usuarioLegajo"]) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <div class="controls">
                                
                        </div>
                    </div>
                </section>
                <form class="form-u">
                    <label for="hDNI">DNI</label>
                    <input class="textbox" type="number" id="hDNI" name="hDNI" placeholder="Ingrese DNI...">
                    <label for="hName">Nombre</label>
                    <input class="textbox" type="text" id="hName" name="hName" placeholder="Ingrese nombre...">
                    <label for="hLastname">Apellido</label>
                    <input class="textbox" type="text" id="hLastname" name="hLastname" placeholder="Ingrese apellido...">
                    <label for="hData">Datos medicos</label>
                    <textarea class="textbox" id="hData" name="hData" placeholder="Ingrese datos medicos..."></textarea>
                    <input class="button" type="button" id="submit" name="submit" value="Registrar">
                </form>
            </div>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

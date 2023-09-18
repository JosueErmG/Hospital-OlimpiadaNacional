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

		<link rel="stylesheet" href="styles/users.css"/>
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
                                    $query = mysqli_query($conn, "SELECT * FROM Usuarios LIMIT 15");
                                    $data = $query->fetch_all(MYSQLI_ASSOC);
                                ?>
                                <tr>
                                    <th>Legajo</th>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th> 
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Area</th>
                                </tr>
                                <?php foreach($data as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["legajo"]) ?></td>
                                        <td><?= htmlspecialchars($row["DNI"]) ?></td>
                                        <td><?= htmlspecialchars($row["nombre"]) ?></td>
                                        <td><?= htmlspecialchars($row["apellido"]) ?></td>
                                        <td><?= htmlspecialchars($row["telefono"]) ?></td>
                                        <td><?= htmlspecialchars($row["email"]) ?></td>
                                        <td><?= htmlspecialchars($row["areaCodigo"]) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <div class="controls">
                            <button class="material">keyboard_double_arrow_left</button>
                            <button class="material">chevron_left</button>
                            <input type="text" class="" style="text-align: right" value="n">
                            <input type="text" class="" value="/n" readonly>
                            <button class="material">chevron_right</button>
                            <button class="material">keyboard_double_arrow_right</button>
                        </div>
                    </div>
                </section>
                <form class="form-u">
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
                        <input class="textbox" type="number" id="uNumber" name="uNumber" placeholder="Ingrese telefono...">
                    </div>
                    <div class="united">
                        <label for="uPass">Contraseña</label>
                        <label for="rePass">Confirmar contraseña</label>
                        <input class="textbox" type="text" id="uPass" name="uPass" placeholder="Ingrese contraseña...">
                        <input class="textbox" type="text" id="rePass" name="rePass" placeholder="Ingrese contraseña...">
                    </div>

                    <input class="button" type="button" id="submit" name="submit" value="Registrar">
                </form>
            </div>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

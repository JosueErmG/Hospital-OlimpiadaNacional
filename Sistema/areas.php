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

		<link rel="stylesheet" href="styles/areas.css"/>
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

        <main class="centered grid2">
            <form>
                <label for="aName">Nombre de Area</label>
                <input class="textbox" type="text" id="aName" name="aName" placeholder="Ingrese nombre...">
                <label for="nArea">Telefono de Area</label>
                <input class="textbox" type="text" id="nArea" name="nArea" placeholder="Ingrese telefono...">
                <a href="" id="button">Registrar</a>
            </form>

            <section class="datagrid">
                <table border="1">
                    <?php
                        include("config/dbconn.php");
                        $query = mysqli_query($conn, "SELECT * FROM Usuarios LIMIT 15");
                        $data = $query->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                    </tr>
                    <?php foreach($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["nombre"]) ?></td>
                            <td><?= htmlspecialchars($row["apellido"]) ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </section>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

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

		<link rel="stylesheet" href="styles/areas.css"/>
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
                        <i class="material-icons">cancel</i>
                    </label>
                </nav>
            </div>
        </header>

        <main class="centered">
            <div class="grid2">
                <section class="search_datatable">
                    <div class="search card">

                    <?php
                        if (isset($_POST["submit"])) {
                            $aname = $_POST["aName"];
                            $nnrea = $_POST["nArea"];
                            $pass = $_POST["nPass"];
                    
                            $sql = "INSERT INTO areas (nombre, telefono, pass) VALUES ('$aname', '$nnrea', '$pass')";
                    
                            $conn = GetConn();
                            
                            if ($conn->query($sql)) {
                                echo "Datos guardados correctamente";
                            } else {
                                echo "Error al guardar los datos: " . $conn->error;
                            }
                        }
                    ?>

                    </div>
                    <div class="datatable_controls card">
                        <?php
                            $limit = 15;
                            $totalPages = ceil(TableRowsCount("usuariosview") / $limit);
                            $curPage = isset($_POST["curPage"]) ? min(max(1, $_POST["curPage"]), $totalPages) : 1;
                            $offset = ($curPage - 1) * $limit;

                            $rows = GetTable("usuariosview", $offset, $limit);
                        ?>
                        <div class="datatable">
                            <table> <!-- border="1" -->
                                <?php
                                    include("config/dbconn.php");
                                    $query = mysqli_query($conn, "SELECT * FROM areas LIMIT 15");
                                    $data = $query->fetch_all(MYSQLI_ASSOC);
                                ?>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                </tr>
                                <?php foreach($data as $row) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["codigo"]) ?></td>
                                        <td><?= htmlspecialchars($row["nombre"]) ?></td>
                                        <td><?= htmlspecialchars($row["telefono"]) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="controls card">
                            <button class="material-icons">keyboard_double_arrow_left</button>
                            <button class="material-icons">chevron_left</button>
                            <input type="number" class="" style="text-align: right" value="0" onkeypress="if (isNaN(event.key)) event.preventDefault();">
                            <input type="text" class="" value="/n" readonly>
                            <button class="material-icons">chevron_right</button>
                            <button class="material-icons">keyboard_double_arrow_right</button>
                        </div>
                    </div>
                </section>
                <form class="form-u card" method="POST" action="#">
                    <label for="aName">Nombre de Area</label>
                    <input class="textbox" type="text" id="aName" name="aName" placeholder="Ingrese nombre...">
                    <label for="nArea">Telefono de Area</label>
                    <input class="textbox" type="number" id="nArea" name="nArea" placeholder="Ingrese telefono...">
                    <label for="aName">Contraseña</label>
                    <input class="textbox" type="text" id="nPass" name="nPass" placeholder="Ingrese contraseña...">
                    <button type="submit" id="submit" name="submit">Registrar</button>
                </form>
            </div>
        </main>

    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

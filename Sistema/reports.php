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

		<link rel="stylesheet" href="styles/reports.css"/>
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
                    <div class="search card">

                    </div>
                    <div class="datatable_controls card">
                        <div class="datatable">
                            <table> <!-- border="1" -->
                                <?php
                                    include("config/dbconn.php");
                                    $query = mysqli_query($conn, "SELECT * FROM fichas LIMIT 15");
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
                <!-- <div class="left">
                    <select name="" id="tipo">
                        <option value="circular">
                            Gráfico Circular
                        </option>
                        <option value="columna">
                            Gráfico de Columnas
                        </option>
                    </select>
                    <input type="text" placeholder="Título del Gráfico" id="titulo">
                    <div class="datos" id="datos">
                        <div class="dato">
                            <input type="text" placeholder="Leyenda 1" class="serie">
                            <input type="text" placeholder="Valor 1" class="valor">
                        </div>
                        <div class="dato">
                            <input type="text" placeholder="Leyenda 2" class="serie">
                            <input type="text" placeholder="Valor 2" class="valor">
                        </div>
                    </div>
                    <button onclick="agregarDato()" class="agregar"> + </button>
                    <button onclick="cargarGrafico()" class="crear-grafico">Crear Gráfico</button>
                </div> -->
                <section class="right">
                    <div id="piechart"></div>
                </section>
            </div>
        </main>

    </body>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="scripts/script.js"></script> 
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

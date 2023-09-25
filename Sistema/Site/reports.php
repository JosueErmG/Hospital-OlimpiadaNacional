<!DOCTYPE html>

<?php
    include "config/functions.php";
    $_SESSION["lastfile"] = basename(__FILE__);
    if (!CheckSession())
        LogOut();

    if ($_SESSION["is_area"]) {
        include "unauthorized.php";
        exit;
    }

    $search = isset($_POST["dt_search"]) ? $_POST["dt_search"] : "";
    $DTh = GetDTHeight();

    $limit = $DTh != 0 ? max(floor($DTh / GetDTRowHeight()), 1) : 10;
    $totalPages = ceil(TableRowsCount("reportesview") / $limit);
    $curPage = isset($_POST["dt_curPage"]) ? min(max(1, $_POST["dt_curPage"]), $totalPages) : 1;
    $offset = ($curPage - 1) * $limit;
    $rows = GetTable("reportesview", $offset, $limit, $search, "ID DESC");
?>

<html lang="es" data-theme="<?= $_COOKIE['theme'] ?>">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.svg">

		<title>Hospital</title> 

		<link rel="stylesheet" href="styles/reports.css"/>
        <link rel="stylesheet" href="styles/fonts.css">

        <script>
            if (window.history.replaceState)
                window.history.replaceState(null, null, window.location.href);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="reports.php" class="selected">Reportes</a>
                    <a href="healthsheets.php">Fichas de salud</a>
                    <?php if ($_SESSION["user"][7]) { ?>
                        <a href="users.php">Usuarios</a>
                        <a href="areas.php">Áreas</a>
                    <?php } ?>
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
                                    <?php if (!$_SESSION["is_area"] and $_SESSION["user"][7]) { ?>
                                        <th class="datatable_del_button"></th>
                                    <?php } ?>
                                </tr> 
                                <?php foreach ($rows as $row) { ?>
                                    <tr id="datatable_row_<?= $row['ID'] ?>" class="datatable_drow">
                                        <?php 
                                        foreach ($row as $key => $value) {
                                            if ($key == "Atendido") { ?>
                                                <td class="datatable_td datatable_checkbox">
                                                    <input type="checkbox" id="database_cck_<?= $row['ID'] ?>" class="datatable_input_checkbox"
                                                           onclick="DtReportsCck(event, this)" <?= $value ? "checked" : "" ?>>        
                                                </td>
                                            <?php }
                                            else { ?>
                                                <td class="datatable_td"><?= nl2br(htmlspecialchars($value)) ?></td>
                                            <?php }
                                        } ?>

                                        <?php if (!$_SESSION["is_area"] and $_SESSION["user"][7]) { ?>
                                            <td id="database_del_<?= $row['ID'] ?>" class="datatable_td datatable_del_button" 
                                                onclick="DtDelete(this, 'reportes', 'ID');">delete</td>
                                        <?php } ?>
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
                <div class="form-u grid-two-rows">
                    <div class="form-u card container">
                        <h4>No atendidos: <span id="notattended"></span></h4>
                    </div>
                    <div class="form-u card">
                        <canvas id="grafico"></canvas>
                    </div> 
                    <span id="bottom-padding">&nbsp</span>
                </div>
            </div>
            <?php
                $conn = GetConn();

                $result = $conn->query("
                    SELECT nivel, AVG(TIMESTAMPDIFF(SECOND, fechaCreacion, fechaAtendido)) AS promedio_secs
                    FROM reportes
                    GROUP BY nivel ASC
                ");
                
                $promedios = array();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $promedios[] = array(
                            "nivel" => $row["nivel"],
                            "promedio_secs" => $row["promedio_secs"]
                        );
                    }
                }
                
                function obtenerPromedios() {
                    $promedios = obtenerPromedios();
                }

                $resultado = $conn->query("
                    SELECT COUNT(*) AS contador_no_atendidos FROM reportes
                    WHERE atendido = 0
                ");

                if ($resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    $fila["contador_no_atendidos"];
                }
            ?>

            <script>
                // function obtenerContadorNoAtendidos() {
                //     var xhr = new XMLHttpRequest();
                //     xhr.onreadystatechange = function() {
                //         if (xhr.readyState === 4 && xhr.status === 200) {
                //             var contador = document.getElementById("contador");
                //             contador.innerHTML = xhr.responseText;
                //         }
                //     };
                //     xhr.open("GET", "obtener_contador.php", true);
                //     xhr.send();
                // }
                // window.onload = obtenerContadorNoAtendidos;

                document.getElementById("notattended").innerHTML = "<?= $fila["contador_no_atendidos"] ?>";

                var datos = <?= json_encode($promedios) ?>;

                var niveles = datos.map(function (elemento) {
                    return "Emerg. " + ["Alta", "Media", "Baja"][elemento.nivel - 1];
                });
                var promediosHoras = datos.map(function (elemento) {
                    return elemento.promedio_secs / 60 / 60;
                });

                var ctx = document.getElementById("grafico").getContext("2d");

                var config = {
                    type: "bar",
                    data:  {
                        labels: niveles,
                        datasets: [{
                            label: "Promedio de retraso de atención (horas)",
                            data: promediosHoras,
                            backgroundColor: [
                                "rgba(54, 162, 235, 0.5)",
                                "rgba(255, 99, 132, 0.5)",
                                "rgba(75, 192, 192, 0.5)"
                            ],
                            borderColor: [
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 99, 132, 1)",
                                "rgba(75, 192, 192, 1)"
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                var myChart = new Chart(ctx, config);
            </script>
        </main>
    </body>
    
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <!-- <script type="text/javascript" src="scripts/script.js"></script> -->

    <script src="scripts/jquery-3.6.0.min.js"></script>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

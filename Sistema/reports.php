<!DOCTYPE html>

<?php
    include "config/functions.php";
    $_SESSION["lastfile"] = basename(__FILE__);
    if (!CheckSession())
        LogOut();

    $search = isset($_POST["dt_search"]) ? $_POST["dt_search"] : "";
    $DTh = GetDTHeight();
    if ($DTh == 0) {
        $rows = array();
        $curPage = 0;
        $totalPages = 0;
    }
    else {
        $limit = max(floor($DTh / 42), 1);
        $totalPages = ceil(TableRowsCount("reportesview") / $limit);
        $curPage = isset($_POST["dt_curPage"]) ? min(max(1, $_POST["dt_curPage"]), $totalPages) : 1;
        $offset = ($curPage - 1) * $limit;
        $rows = GetTable("reportesview", $offset, $limit, $search);
    }
?>

<html lang="es">
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
                                    <?php if (count($rows) > 0) foreach($rows[0] as $key => $value) { ?>
                                        <th><?= nl2br(htmlspecialchars($key)) ?></th>
                                    <?php } ?>
                                    <?php if ($_SESSION["user"][7]) { ?>
                                        <th class="datatable_del_button"></th>
                                    <?php } ?>
                                </tr>
                                <?php foreach($rows as $row) { ?>
                                    <tr class="datatable_drow" id="datatable_row_<?= $row['ID'] ?>">
                                        <?php foreach($row as $column) { ?>
                                            <td class="datatable_td"><?= nl2br(htmlspecialchars($column)) ?></td>
                                        <?php } ?>
                                        <?php if ($_SESSION["user"][7]) { ?>
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
                            SetDTHeight("datatable");
                            if ($DTh == 0)
                                header("Refresh: 0");
                        ?>
                        <form class="controls card" method="POST" action="#" autocomplete="off">
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', 1)">keyboard_double_arrow_left</button>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', '-1', 1, <?= $totalPages ?>)">chevron_left</button>
                            <input type="text" id="dt_curPage" name="dt_curPage" style="text-align: right" maxlength="<?= strlen($totalPages) ?>"
                                   value="<?= $curPage ?>" onchange="this.form.submit();" onkeypress="IntOrSubmit(event, this);">
                            <input type="text" value="<?= "/$totalPages" ?>" readonly>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', '+1', 1, <?= $totalPages ?>)">chevron_right</button>
                            <button type="submit" class="material-icons" onclick="ChangeInput(event, 'dt_curPage', <?= $totalPages ?>)">keyboard_double_arrow_right</button>
                        </form>
                    </div>
                </section>
                <div class="form-u">
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
                    <div id="piechart"></div>
                    <div id="columnchart"></div>
                </div>
                <!-- <span id="bottom-padding">&nbsp</span> -->
            </div>
        </main>
    </body>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="scripts/script.js"></script>

    <script src="scripts/jquery-3.6.0.min.js"></script>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

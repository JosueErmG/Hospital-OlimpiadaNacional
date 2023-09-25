<!DOCTYPE html>

<?php
    include_once "config/functions.php";
    if (!CheckSession())
        LogOut();
?>

<html lang="es" data-theme="<?= $_COOKIE['theme'] ?>">
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
                    <a href="buttons.php">Emergencias</a>
                    <a href="reports.php">Reportes</a>
                    <a href="healthsheets.php">Fichas de salud</a>
                    <a href="config/logout.php">Log out</a>
                    <input type="checkbox" id="inpTheme" onclick="ChangeTheme();" checked>
                    <label id="header_theme" for="inpTheme">
                        <i class="material-icons">brightness_medium</i>
                    </label>
                </nav>
            </div>
        </header>

        <main class="centered">
            <form class="form-u card">
                <div style="text-align: center;">
                    <svg class="warning" viewBox="0 0 570.000000 570.000000">
                        <g transform="translate(0.000000,570.000000) scale(0.100000,-0.100000)"
                        fill="#94161d" stroke="none">
                            <path d="
                                M2750 5434 c-149-18-316-80-433-161-38-26-106-87-151-134-88-94-81-83-571-934-51-88-133
                                -230-182-315-91-157-235-406-335-580-92-159-242-419-303-525-32-55-81-140-110-190-46-80
                                -141-245-300-520-290-501-293-507-331-650-52-193-31-419 55-610 94-207 254-367 466-466
                                94-44 165-64 279-79 55-7 712-10 2076-8 l1995 3 78 22 c168 48 325 139 441 257 227 231
                                322 569 243 872-35 135-52 171-199 424-68 118-171 296-228 395-57 99-124 216-150 260-26 
                                44-93 161-150 260-57 99-127 221-156 270-29 50-118 205-199 345-81 140-164 284-185 320-173
                                299-244 421-525 910-257 448-262 455-351 550-115 122-279 217-450 260-75 19-254 32-324 24z
                                m392-1136 c81-24 136-127 125-231-57-511-100-886-112-982-8-66-31-264-50-441-37-341-50-405
                                -92-454-81-97-245-97-326 0-42 49-55 115-92 455-19 176-42 374-50 440-14 113-100 866-112
                                986-10 99 41 198 117 228 37 14 543 14 592-1z m-115-2517 c210-97 290-340 183-558-53-107
                                -162-183-294-205-173-29-354 58-426 205-79 161-57 347 57 468 84 90 186 130 318 126 78-3
                                100-8 162-36z
                            "/>
                        </g>
                    </svg>
                    <H3> LO SIENTO <br> ACCESO DENEGADO </H3>
                </div>
            </form>
        </main>
    </body>

	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

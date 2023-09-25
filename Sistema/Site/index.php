<!DOCTYPE html>

<?php
    include "config/functions.php";
    $error = false;

    $error_label = "&nbsp";
    if (!InSession() and isset($_POST["u_submit"])) {
        if ($error = LogInUser($_POST["u_user"], $_POST["u_pass"]));
            $error_label = "Legajo/DNI o contraseña incorrecta"; 
    }
    else if (isset($_POST["a_submit"])) {
        if ($error = LogInArea($_POST["a_user"], $_POST["a_pass"], $_POST["a_ubi"]));
            $error_label = "Codigo/Nombre o contraseña incorrecta"; 
    }
?>

<html lang="es" data-theme="<?= $_COOKIE['theme'] ?>">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.svg">

		<title>Hospital</title> 

		<link rel="stylesheet" href="styles/index.css"/>
        <link rel="stylesheet" href="styles/fonts.css">

        <?php if ($error) { ?>
            <style>
                .login__input:active,
                .login__input:focus,
                .login__input:hover {
                    border-bottom-color: var(--color-error);
                }

                .login__icon {
                    color: var(--color-error);
                }
            </style>
        <?php } ?>
        
        <style>
            /* Style the tab */
            .tab {
                display: flex;
                overflow: hidden;
                
                width: 100%;

                background-color: var(--color-background);
                border: 1px solid var(--color-primary-darker);
                border-radius: 5px;
            }

            /* Style the buttons that are used to open the tab content */
            .tab button {
                border: none;
                outline: none;
                cursor: pointer;
                
                width: 100%;
                padding: 14px 16px;
                
                transition: 0.3s;

                color: var(--color-font);
                background-color: inherit;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: var(--color-background-darker);
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: var(--color-primary-dark);
            }

            /* Style the tab content */
            .tab_content {
                display: none;
                /* padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none; */
            }

            .area_ubi {
                margin: 10px auto;
                width: 100%;
            }

            .area_ubi input {
                accent-color: var(--color-primary);
                filter: var(--filter-datatable-checkbox);
                outline: 0;
            }

            .area_ubi input:checked {
                filter: unset;
            }

            #a_submit {
                margin-top: 20px;
            }
        </style>
        
        <script>
            if (window.history.replaceState)
                window.history.replaceState(null, null, window.location.href);
        </script>
	</head>

    <body>
        <main class="container">
            <div class="card screen">
                <div class="screen__content">
                    <div class="login">
                        <div class="tab">
                            <button class="tab_links" onclick="ChangeTab(this, 'form_user')">Usuario</button>
                            <button class="tab_links" onclick="ChangeTab(this, 'form_area')">Area</button>
                        </div>

                        <label class="error_label"><?= $error_label ?></label>
                        
                        <form id="form_user" class="tab_content" method="POST" action="#">
                            <div class="login__field">
                                <i class="login__icon fas fa-user"></i>
                                <input type="text" id="u_user" name="u_user" class="login__input" placeholder="Legajo/DNI" onkeypress="IntOrSubmit(event, this);">
                            </div>
                            <div class="login__field">
                                <i class="login__icon fas fa-lock"></i>
                                <input type="password" id="u_pass" name="u_pass" class="login__input" placeholder="Contraseña">
                            </div>
                            <div class="login__button">
                                <button id="u_submit" name="u_submit" class="button login__submit">
                                    <span class="button__text">Log In</span>
                                    <i class="button__icon fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </form>

                        <form id="form_area" class="tab_content" method="POST" action="#">
                            <div class="login__field">
                                <i class="login__icon fas fa-user"></i>
                                <input type="text" id="a_user" name="a_user" class="login__input" placeholder="Código/Nombre">
                            </div>
                            <div class="login__field">
                                <i class="login__icon fas fa-lock"></i>
                                <input type="password" id="a_pass" name="a_pass" class="login__input" placeholder="Contraseña">
                            </div>
                            
                            <div class="area_ubi">
                                <input type="radio" id="bed" value="Cama" name="a_ubi" value="Cama" checked>
                                <label for="bed">Cama</label>
                                <input type="radio" id="bath" value="Baño" name="a_ubi" value="Baño">
                                <label for="bath">Baño</label>
                            </div>
                            
                            <div class="login__button">
                                <button id="a_submit" name="a_submit" class="button login__submit">
                                    <span class="button__text">Log In</span>
                                    <i class="button__icon fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="screen__background">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>		
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div>		
            </div>
        </main>
    </body>

    <script>
        ChangeTab(document.getElementsByClassName("tab_links")[0], "form_user");
        function ChangeTab(oBtn, tab) {
            var i,
//              Get all elements with class="tab_content"
                tabContent = document.getElementsByClassName("tab_content"),
//              Get all elements with class="tab_links"
                tabLinks = document.getElementsByClassName("tab_links");

//          hide all elements with class="tab_content"
            for (i = 0; i < tabContent.length; i++)
                tabContent[i].style.display = "none";

//          Remove the class "active" from all elements with class="tab_content"
            for (i = 0; i < tabLinks.length; i++)
                tabLinks[i].className = tabLinks[i].className.replace(" active", "");

//          Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tab).style.display = "block";
            oBtn.className += " active";
        }
    </script>

	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

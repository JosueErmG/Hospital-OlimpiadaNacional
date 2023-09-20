<!DOCTYPE html>

<?php
    include("config/functions.php");
    $error = false;

    if (!InSession() and isset($_POST["submit"]))
        $error = LogIn($_POST["user"], $_POST["pass"]);
?>

<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/x-icon" href="assets/favicon.png">

		<title>TITLE</title> 

		<link rel="stylesheet" href="styles/index.css"/>
        <link rel="stylesheet" href="styles/fonts.css">
	</head>

    <body>
        <main class="container">
            <div class="card screen">
                <div class="screen__content">
                    <form class="login" method="POST" action="#">
                        <label class="error_label">
                            <?php 
                                if (!$error)
                                    echo "&nbsp";
                                else {
                                    echo "Legajo/DNI o contraseña incorrecta
                                    <style>
                                        .login__input:active,
                                        .login__input:focus,
                                        .login__input:hover {
                                            border-bottom-color: var(--color-error);
                                        }
                                        .login__icon {
                                            color: var(--color-error);
                                        }
                                    </style>"; 
                                }
                            ?>
                        </label>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="number" id="user" name="user" class="login__input" placeholder="Legajo/DNI">
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" id="pass" name="pass" class="login__input" placeholder="Contraseña">
                        </div>
                        <div class="login__button">
                            <button id="submit" name="submit" class="button login__submit">
                                <span class="button__text">Log In</span>
                                <i class="button__icon fas fa-chevron-right"></i>
                            </button>				
                        </div>
                    </form>
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
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

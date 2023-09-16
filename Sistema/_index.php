<!DOCTYPE html>
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
        <main class="u_centered">
            <div class="container">
                <div class="screen">
                    <div class="screen__content">
                        <form class="login" method="POST">
                            <div class="login__field">
                                <i class="login__icon fas fa-user"></i>
                                <input type="text" id="user" name="user" class="login__input" placeholder="Legajo">
                            </div>
                            <div class="login__field">
                                <i class="login__icon fas fa-lock"></i>
                                <input type="password" id="pass" name="pass" class="login__input" placeholder="Contraseña">
                            </div>
                            <button id="login" name="login" class="button login__submit">
                                <span class="button__text">Log In</span>
                                <i class="button__icon fas fa-chevron-right"></i>
                            </button>				
                        </form>
                    </div>
                    <div class="screen__background">
                        <span class="screen__background__shape screen__background__shape4"></span>
                        <span class="screen__background__shape screen__background__shape3"></span>		
                        <span class="screen__background__shape screen__background__shape2"></span>
                        <span class="screen__background__shape screen__background__shape1"></span>
                    </div>		
                </div>
            </div>  
        </main>
    </body>
	<script src="scripts/main.js"></script>
	<script src="scripts/styles.js"></script>
</html>

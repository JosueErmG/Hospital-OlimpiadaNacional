<?php
    session_start();
    if (!isset($_SESSION["started"]))
        $_SESSION["started"] = time();
    else if (time() - $_SESSION["started"] > 21600)  // 21600 = six hours
        logout();

    function login() {
        
    }
    
    function logout() {
        session_unset();  
        session_destroy(); 
        header("Location: ../_index.php");
    }
?>

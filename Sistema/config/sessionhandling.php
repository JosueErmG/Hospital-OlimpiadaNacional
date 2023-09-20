<?php
    session_start();
    if (!isset($_SESSION["started"]))
        $_SESSION["started"] = time();
    else if (time() - $_SESSION["started"] > 21600)  // 21600 = six hours
        LogOut();

    // function login() {
        
    // }
    
    // function LogOut() {
    //     session_unset();  
    //     session_destroy(); 
    //     header("Location: ../_index.php");
    // }
?>

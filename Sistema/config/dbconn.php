<?php
    include("..\..\pass.php");

    $source = "localhost";
    $port = 3306;
    $user = "root";
//  $pass = $pass;
    $database = "hospital";
    $conn = new mysqli($source, $user, $pass, $database, $port);
    if ($conn->connect_error)
        die("Connection failed" . $conn->connect_error);
?>

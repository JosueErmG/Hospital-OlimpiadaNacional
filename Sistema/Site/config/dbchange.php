<?php
    include "functions.php";
    if (!CheckSession())
        LogOut();

    try {
        UpdateInTable($_POST["table"], $_POST["column"], $_POST["value"], $_POST["condition"]);
        echo json_encode(false);
    }
    catch (Exception $ex) {
        echo json_encode($ex->getMessage());
    }
?>

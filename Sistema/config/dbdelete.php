<?php
    include "functions.php";
    if (!CheckSession())
        LogOut();

    try {
        DeleteInTable($_POST["table"], $_POST["condition"]);
        echo json_encode(false);
    }
    catch (Exception $ex) {
        echo json_encode($ex->getMessage());
    }
?>

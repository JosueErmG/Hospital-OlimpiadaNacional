<?php
    session_start();

    function GetDTHeight() {
        if(!isset($_COOKIE['dt_height'])) {
            echo("
                <script type='text/javascript'>
                    document.cookie = 'dt_height=' + 
                                      (window.innerHeight - 
                                      parseInt(getComputedStyle(document.body).getPropertyValue('--bar-height')) -
                                      parseInt(getComputedStyle(document.getElementsByClassName('grid2')[0]).gridGap) * 3 -
                                      parseInt(getComputedStyle(document.getElementsByClassName('search')[0]).height) -
                                      48 - 42);
                                 //   parseInt(getComputedStyle(document.getElementsByClassName('form.controls')[0]).height) * 2);
                </script>
            ");
            header("Refresh:0");
        }
        return $_COOKIE['dt_height'];
    }

//  Checks if the active session is valid, and redirects to the last requested site
    function InSession() {
        if (CheckSession()) {
            header("Location: /" . (isset($_SESSION["lastfile"]) ? $_SESSION["lastfile"] : "buttons.php"));
            return true;
        }
        return false;
    }

//  Checks if the active session is valid
    function CheckSession() {
        return isset($_SESSION["started"]) and time() - $_SESSION["started"] <= 21600 and isset($_SESSION["user"]); // 21600 = six hours
    }

//  Deletes the current session
    function DeleteSession() {
        session_unset();
        session_destroy(); 
    } 
    
    function LogIn($user, $pass) {
        $query = mysqli_query(GetConn(),
            "SELECT legajo, pass FROM usuarios " .
            "WHERE (legajo = '$user' or DNI = '$user') and pass = '$pass'"
        );
        
        $error = mysqli_num_rows($query) <= 0;  // error if no rows retrieved
        if (!$error) {
            $_SESSION["user"] = mysqli_fetch_row($query);
            $_SESSION["started"] = time();
            header("location: /" . (isset($_SESSION["lastfile"]) ? $_SESSION["lastfile"] : "buttons.php"));
        }

        return $error;
    }
    
    function LogOut() {
        unset($_SESSION["user"]);
        header("Location: /_index.php");
    }

    function GetConn() {
        static $conn;

        if (!isset($conn) or $conn->connect_error) {
            include("..\..\pass.php");
            $conn = new mysqli("localhost", "root", $pass, "hospital", 3306);
            if ($conn->connect_error)
                die("Connection failed" . $conn->connect_error);
        }
        return $conn;
    }

    function GetTable($table, $offset = 0, $limit = 15) {
        $query = mysqli_query(GetConn(), "SELECT * FROM $table LIMIT $offset, $limit");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    function TableRowsCount($table) {
        $query = mysqli_query(GetConn(), "SELECT COUNT(*) FROM $table");
        return mysqli_fetch_array($query)[0];
    }
?>

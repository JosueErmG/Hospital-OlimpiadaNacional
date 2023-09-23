<?php
    session_start();

    // function GetDTHeight() {
    //     $wasSetted = isset($_COOKIE['dt_height']);
    //     echo("
    //         <script type='text/javascript'>
    //             // try {
    //                 console.log(document.getElementById('datatable').offsetHeight);
    //                 document.cookie = 'dt_height=' + document.getElementById('datatable').offsetHeight;

    //                 // document.cookie = 'dt_height=' + 
    //                 //                     (window.innerHeight - 
    //                 //                     parseInt(getComputedStyle(document.body).getPropertyValue('--bar-height')) -
    //                 //                     parseInt(getComputedStyle(document.getElementsByClassName('grid-two')[0]).gridGap) * 3 -
    //                 //                     parseInt(getComputedStyle(document.getElementsByClassName('search')[0]).height) -
    //                 //                     48 - 42);
    //                 //                 //   parseInt(getComputedStyle(document.getElementsByClassName('form.controls')[0]).height) * 2);
    //             // }
    //             // catch {
    //                 // document.cookie = 'dt_height=' + (window.innerHeight - 274);
    //             // }
    //         </script>
    //     ");

    //     if (!$wasSetted)
    //         header("Refresh: 0");
        
    //     return $_COOKIE['dt_height'];
    // }

    function GetDTHeight() {
        return isset($_COOKIE["dt_height"]) ? $_COOKIE["dt_height"] : 0;
    }

    function GetDTRowHeight() {
        return isset($_COOKIE["dt_row_height"]) ? $_COOKIE["dt_row_height"] : 0;
    }

    function SetDTHeight($id) {
        echo("<script type='text/javascript'>
            // try {
                oDT = document.getElementById('" . $id . "');

                var rows = oDT.getElementsByClassName('datatable_drow');
                // alert(getComputedStyle(rows[0]).height);
                var maxRow = parseInt(getComputedStyle(rows[0]).height);
                var rowHeight;
                var i;
                for (i = 1; i < rows.length; i++) {
                    rowHeight = parseInt(getComputedStyle(rows[i]).height);
                    if (rowHeight > maxRow)
                        maxRow = rowHeight;
                }
                
                document.cookie = 'dt_height=' + (
                    parseInt(getComputedStyle(oDT).height) - 
                    parseInt(getComputedStyle(oDT.getElementsByClassName('datatable_hrow')[0]).height) -
                    42 - 10
                ) +
                '; dt_row_height=' + maxRow;

            // }
            // catch {
            //     document.cookie = 'dt_height=' + (window.innerHeight - 274) + ';dt_row_height=42';
            // }
        </script>");
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
        $query = GetConn()->query("
            SELECT * FROM usuarios
            WHERE (legajo = '$user' or DNI = '$user')
        ");

        $error = mysqli_num_rows($query) <= 0;  // error if no rows retrieved
        if (!$error) {
            $user = mysqli_fetch_row($query);
            if (!password_verify($pass, $user[2])) 
                $error = true;
            else {
                $_SESSION["user"] = $user;
                $_SESSION["started"] = time();
                header("location: /" . (isset($_SESSION["lastfile"]) ? $_SESSION["lastfile"] : "buttons.php"));
            }
        }

        return $error;
    }
    
    function LogOut() {
        unset($_SESSION["user"]);
        header("Location: /_index.php");
    }
    
    function CheckPass($pass, &$errorStr) {
        $errorStr = "";
        if (strlen($pass) < 8)
            $errorStr = "La contraseña debe contener al menos 8 caracteres";
        if (!preg_match('/[a-z]/', $pass))
            $errorStr .= $errorStr != "" ? ", una minúscula" : "La contraseña debe contener al menos una minúscula";
        if (!preg_match('/[A-Z]/', $pass))
            $errorStr .= $errorStr != "" ? ", una mayúsucula" : "La contraseña debe contener al menos una mayúsucula";
        if (!preg_match('/\d/', $pass))
            $errorStr .= $errorStr != "" ? ", un número" : "La contraseña debe contener al menos un número";
        if ($errorStr != "") {
            if (($pos = strrpos($errorStr, ", ")) > 0)
                $errorStr = substr_replace($errorStr, " y ", $pos, 2);
        }
        
        return $errorStr != "";
    }

    function GetConn() {
        static $conn;

        if (!isset($conn) or $conn->connect_error) {
            $conn = new mysqli(
                $_SERVER["SQL_SOURCE"],
                $_SERVER["SQL_USER"],
                $_SERVER["SQL_PASS"],
                $_SERVER["HO_SQL_DATABASE"],
                $_SERVER["SQL_PORT"]
            );
            if ($conn->connect_error)
                die("Connection failed" . $conn->connect_error);
        }
        return $conn;
    }

    function GetTable($table, $offset = 0, $limit = 10, $searchfor = "") {
        $search = "";
        if ($searchfor != "") {
            $search = " WHERE ";
            $query = GetConn()->query("
                SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = '$table';
            ");
            foreach ($query->fetch_all() as $column) {
                $search .= "`$column[0]`" . " LIKE '%" . $searchfor . "%' OR ";
            }
            $search = substr($search, 0, -4);
        }
        $query = GetConn()->query("
            SELECT * FROM $table
            $search
            LIMIT $offset, $limit
        ");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    function InsertInTable($table, $columns, $values) {
        return GetConn()->query("
            INSERT INTO $table($columns) 
            VALUES ($values)
        ");
    }

    function DeleteInTable($table, $condition) {
        return GetConn()->query("
            DELETE FROM `$table`
            WHERE $condition
        ");
    }

    function TableRowsCount($table) {
        $query = GetConn()->query("SELECT COUNT(*) FROM $table");
        return mysqli_fetch_array($query)[0];
    }

    function GetTableRow($table, $condition) {
        $query = GetConn()->query("
            SELECT * FROM $table
            WHERE $condition
        ");
        return $query->fetch_all(MYSQLI_ASSOC);
    }
?>

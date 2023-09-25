<?php
    session_start();
    if (!isset($_COOKIE["theme"]))
        $_COOKIE["theme"] = "dark";

//  Obtiene la altura una datatable guardado en cookies.
    function GetDTHeight() {
        return isset($_COOKIE["dt_height"]) ? $_COOKIE["dt_height"] : 0;
    }

//  Obtiene la altura de las filas de una datatable guardado en cookies.
    function GetDTRowHeight() {
        return isset($_COOKIE["dt_row_height"]) ? $_COOKIE["dt_row_height"] : 42;
    }

//  Obtiene la altura de la datatable y sus filas en el sitio actual:
//  Primero esperara a que la pagina se termine de cargar, y cuando lo haga, espara a que la pagina 
//  sea recargarda para obtener los tamaños y guardarlos en las cookies antes de que eso pase. Si los
//  valores no estaban guardados en las cookies con aterioridad, significa que probablemente la datatable
//  no se este viendo bien porque cargo con valores por defecto, por lo que recargara la pagina.
    function SetDTHeight($id, $tableid) {
        echo("<script type='text/javascript'>
            window.addEventListener('load', function() {
                var reload = !(document.cookie.split('dt_height').length === 2);
                window.onbeforeunload = function() {
                    try {
                        oDT = document.getElementById('" . $id . "');
                        oDT.getElementsByTagName('" . $tableid . "')[0].style.height = 'unset';

                        document.cookie = 'dt_height=' + (
                            parseInt(getComputedStyle(oDT).height) - 
                            parseInt(getComputedStyle(oDT.getElementsByClassName('datatable_hrow')[0]).height)
                        );

                        try {
                            var rows = oDT.getElementsByClassName('datatable_drow');
                            var maxRow = parseInt(getComputedStyle(rows[0]).height);
                            document.cookie = 'dt_row_height=' + maxRow;
                        }
                        catch {
                            document.cookie = 'dt_row_height=' + 42;
                        }
                    }
                    catch {
                        document.cookie = 'dt_height=' + (window.innerHeight - 330);
                    }
                };
                if (reload)
                    window.location.reload();
            });
        </script>");
    }

//  Comprueba si la sesión activa es válida y redirecciona al último sitio solicitado.
    function InSession() {
        if (CheckSession()) {
            RedirectToLastFile();
            return true;
        }
        return false;
    }

//  Comprueba si la sesión activa es válida.
    function CheckSession() {
        return isset($_SESSION["started"]) and time() - $_SESSION["started"] <= 21600 and isset($_SESSION["user"]); // 21600 = six hours
    }

//  Elimina la sesión actual.
    function DeleteSession() {
        session_unset();
        session_destroy(); 
    } 
    
//  Obtiene el usuario solicitado y comprueba la contraseña, si es correcta,
//  guarda el usuario en la session y redirecciona al último sitio solicitado.
    function LogInUser($user, $pass) {
        $query = GetConn()->query("
            SELECT * FROM usuarios
            WHERE legajo = '$user' OR DNI = '$user'
        ");

        $error = mysqli_num_rows($query) <= 0;  // error if no rows retrieved
        if (!$error) {
            $user = mysqli_fetch_row($query);
            if (!password_verify($pass, $user[2])) 
                $error = true;
            else {
                $_SESSION["user"] = $user;
                $_SESSION["is_area"] = false;
                $_SESSION["started"] = time();
                RedirectToLastFile();
            }
        }

        return $error;
    }

    function LogInArea($user, $pass, $ubi) {
        $query = GetConn()->query("
            SELECT * FROM areas
            WHERE codigo = '$user' OR nombre = '$user'
        ");

        $error = mysqli_num_rows($query) <= 0;  // error if no rows retrieved
        if (!$error) {
            $user = mysqli_fetch_row($query);
            if (!password_verify($pass, $user[1])) 
                $error = true;
            else {
                $_SESSION["user"] = $user;
                $_SESSION["is_area"] = true;
                $_SESSION["area_ubi"] = $ubi;
                $_SESSION["started"] = time();
                RedirectToLastFile();
            }
        }

        return $error;
    }

//  Si el usuario actual tiene acceso al ultimo sitio al que intento acceder, redirecciona a este, 
//  si no tiene acceso, redirecciona a buttons.php.
    function RedirectToLastFile() {
        if (!isset($_SESSION["lastfile"]) or $_SESSION["is_area"] and ($_SESSION["lastfile"] == "reports.php" or $_SESSION["lastfile"] == "healthsheets.php" or 
                                                                       $_SESSION["lastfile"] == "users.php" or $_SESSION["lastfile"] == "areas.php") or
            !$_SESSION["user"][7] and ($_SESSION["lastfile"] == "users.php" or $_SESSION["lastfile"] == "areas.php"))
            $_SESSION["lastfile"] = "buttons.php";
            
        header("location: /" . $_SESSION["lastfile"]);
    }
    
//  Elimina el usuario de la session y redirecciona al inicio de sesión.
    function LogOut() {
        unset($_SESSION["user"]);
        header("Location: /index.php");
    }

//  Comprueba que la contraseña tenga al menos 8 caracteres, una minúscula, una mayúscula, y un número.
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

//  Crea la conexión a la base de datos y obtiene y devuelve el objecto.
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

//  Obtiene una cantidad ($limit) de valores de una tabla empezando por el $offset.
//  Si se especifica un valor en $searchfor se obtendran los registros que contengan
//  dicho valor en algunos de sus campos.
    function GetTable($table, $offset = 0, $limit = 10, $searchfor = "", $orderby = "") {
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
        if ($orderby != "")
            $orderby = "ORDER BY $orderby";

        $query = GetConn()->query("
            SELECT * FROM $table
            $search
            $orderby
            LIMIT $offset, $limit
        ");

        return $query->fetch_all(MYSQLI_ASSOC);
    }

//  Inserta un registro en una tabla.
    function InsertInTable($table, $columns, $values) {
        return GetConn()->query("
            INSERT INTO $table($columns) 
            VALUES ($values)
        ");
    }

//  Inserta un registro en una tabla.
    function UpdateInTable($table, $column, $value, $condition) {
        $value = $value == "NULL" ? $value : "'$value'";
        return GetConn()->query("
            UPDATE `$table`
            SET `$column` = $value
            WHERE $condition
        ");
    }

//  Elimina un registro de una tabla.
    function DeleteInTable($table, $condition) {
        return GetConn()->query("
            DELETE FROM `$table`
            WHERE $condition
        ");
    }

//  Obtiene la cantidad de registros total de una tabla.
    function TableRowsCount($table) {
        $query = GetConn()->query("SELECT COUNT(*) FROM $table");
        return mysqli_fetch_array($query)[0];
    }

//  Obtiene todos los registros completos que coincidan con la condición especificada.
    function GetTableRow($table, $condition) {
        $query = GetConn()->query("
            SELECT * FROM $table
            WHERE $condition
        ");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

//  Obtiene una lista de tipos de datos de las columnas de una tabla.
    function GetColumnsType($table) {
        $query = GetConn()->query("
            SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table';
        ");
        return $query->fetch_all(MYSQLI_ASSOC);
    }
?>

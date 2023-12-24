<?php

$DBHOST = 'localhost';
$DBUSER = 'root';
$DBPASSWORD = '';
$DBNAME = 'desaku';
$DBPORT = 3307;


try {
    $db_connect = mysqli_connect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME, $DBPORT);
} catch (\Throwable $th) {
    $db_connect = null;
    error_log($th->getMessage());
}
/*if(mysqli_connect_errno()){
    echo "failed connect to mysql ".mysqli_connect_error(); 
}*/
?>
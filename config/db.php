<?php

$DBHOST = 'localhost';
$DBUSER = 'root';
$DBPASSWORD = '';
$DBNAME = 'desaku';
$DBPORT = 3307;


$db_connect = mysqli_connect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME, $DBPORT);

if(mysqli_connect_errno()){
    echo "failed connect to mysql ".mysqli_connect_error(); 
}
?>
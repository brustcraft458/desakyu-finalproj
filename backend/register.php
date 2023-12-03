<?php
session_start();

function registerUserFirst() {
    global $db_connect;
    
    // Init
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert data into the 'anggota' table
    $sql = "INSERT INTO user (username, password)
            VALUES ('$username', '$password')";

    // Execute the query
    $query = mysqli_query($db_connect, $sql);
    $_SESSION['user_id'] = $db_connect->insert_id;

    if (!$query) {return retData(false, "fail_query");}

    return retData(true, "success");
}

function registerUserFinal() {
    global $db_connect;

    // init
    $id = $_SESSION['user_id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];

    // Query
    $sql = "UPDATE user SET
            nik = '$nik',
            nama = '$nama',
            umur = $umur
            WHERE id = $id";
    
    $query = mysqli_query($db_connect, $sql);
    if ($query === false) {
        return retData(false, "fail_query");
    }

    // End
    return retData(true, "success");
}

function retData($state, $msg) {
    return [
        'state' => $state,
        'message' => $msg
    ];
}
?>
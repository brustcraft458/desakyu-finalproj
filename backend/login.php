<?php
session_start();

function loginUser() {
    global $db_connect;

    // Check
    if (!isset($_POST['username']) ||
        !isset($_POST['password']))
    {return false;}


    // Query
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = mysqli_query($db_connect,"SELECT * FROM user WHERE username = '$username'");

    // Check
    if(!mysqli_num_rows($user) > 0) {return false;}
    $data = mysqli_fetch_assoc($user);
    
    // Validation
    if($password != $data['password']) {return false;}

    // End
    return true;
}

?>
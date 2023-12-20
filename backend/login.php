<?php
session_start();
$query_state = false;
$query_message = "";

function loginUser() {
    global $query_state, $query_message;

    // Check
    if (!isset($_POST['username']) ||
        !isset($_POST['password']))
    {return false;}


    // Query
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = new Query("SELECT * FROM user WHERE username = ? AND password = ?");
    $query->execute([
        $username,
        $password
    ]);

    // Check
    if (!$query->state) {
        $query_state = false;
        $query_message = $query->message;
        return;
    }

    $data = $query->getData();

    // Session
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password'];

    // End
    $query_state = true;
    $query_message = $query->message;
    return $data;
}

?>
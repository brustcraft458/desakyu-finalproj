<?php
session_start();
$query_state = false;
$query_message = "";

function registerUser() {
    global $query_state, $query_message;
    
    // Init
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Execute the query
    $query = new Query("INSERT INTO user (username, password) VALUES (?, ?)");
    $query->execute([
        $username,
        $password
    ]);

    if(!$query->state) {
        $query_state = false;
        $query_message = $query->message;
        return;
    }

    // End
    $query_state = true;
    $query_message = $query->message;
    return;
}
?>
<?php
$aksi_state = false;
$aksi_message = "";

function addUser() {
    global $aksi_state, $aksi_message;

    // Insert data
    $query = new Query("INSERT INTO user (username, password, role) VALUES (?, ?)");
    $query->checkDuplicate("SELECT count(id_user) as count FROM user WHERE status_deleted = 0 AND username = ?", [
        $_POST['username']
    ]);
    $query->execute([
        $_POST['username'],
        $_POST['password'],
        $_POST['role']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function editUser() {
    global $aksi_state, $aksi_message;

    // Update data
    $query = new Query("UPDATE user SET username = ?, password = ?, role = ? WHERE id_user = ?");
    $query->checkDuplicate("SELECT count(id_user) as count FROM user WHERE status_deleted = 0 AND username = ? AND id_user != ?", [
        $_POST['username'],
        $_POST['id_user']
    ]);
    $query->execute([
        $_POST['username'],
        $_POST['password'],
        $_POST['role'],
        $_POST['id_user']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}

function deleteUser() {
    global $aksi_state, $aksi_message;

    // Delete data
    $query = new Query("UPDATE user SET status_deleted = 1 WHERE id_user = ?");
    $query->execute([
        $_POST['id_user']
    ]);

    if (!$query->state) {
        $aksi_state = false;
        $aksi_message = $query->message;
        return;
    }

    // End
    $aksi_state = true;
    $aksi_message = $query->message;
}
?>
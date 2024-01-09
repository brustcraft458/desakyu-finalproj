<?php
require './config/db.php';
require_once "./backend/function.php";
require_once "./backend/query.php";
require_once "./backend/login.php";

if (isset($_POST['submit'])) {
    loginUser();

    if ($query_state) {
        // Lakukan
        header("Location: dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style/index.css" rel="stylesheet">
    <link href="./style/form.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="background-img mix-white">
        <img src="./img/sukharja-orang.jpg">
    </div>
    <form class="form" action="./login.php" method="post">
        <div class="side">
            <img src="./img/form-fill.jpg">
        </div>
        <div class="content">
            <div class="box title">
                <h2>Login Akun</h2>
                <?php if (!$query_state) : ?>
                    <?php if ($query_message == "fail_nodata") :?>
                        <p class="message error">Email atau password salah.</p>
                    <?php elseif ($query_message == "fail_query") : ?>
                        <p class="message error">Query database gagal</p>
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="box">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="box">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="box">
                <input type="submit" class="button primary" name="submit" value="Login">
            </div>
            <div class="box">
                <label for="register">Tidak punya akun? <a href="./register.php">Daftar disini</a></label>
            </div>
        </div>
    </form>
</body>
</html>
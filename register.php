<?php
require './config/db.php';
require_once "./backend/query.php";
require_once "./backend/register.php";

if (isset($_POST['register'])) {
    registerUser();
    if ($query_state) {
        header("Location: login.php");
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
        <img src="./img/sukharja-orang.png">
    </div>
    <form class="form" action="./register.php" method="post">
        <div class="side">
            <img src="./img/form-fill.jpg">
        </div>

        <div class="content">
            <div class="box title">
                <h2>Register</h2>
                <?php elementMessage() ?>
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
                <input type="submit" class="button primary" name="register" value="Register">
            </div>
        </div>
    </form>
</body>
</html>

<?php function elementMessage() { 
    global $query_state, $query_message;
    ?>
    <?php if (!$query_state) :?>
        <?php if ($query_message == "fail_query") : ?>
            <p class="message error">Query database gagal</p>
        <?php elseif ($query_message == "empty_form") : ?>
            <p class="message error">Data tidak boleh kosong</p>
        <?php endif ?>
    <?php else : ?>
    <?php endif ?>
<?php } ?>
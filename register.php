<?php
require './config/db.php';
require_once "./backend/register.php";

// Init
$page = 0;
$backres = ['state' => true, 'message' => ''];

if (isset($_POST['next_1'])) {
    $backres = registerUserFirst();
    if ($backres['state']) {
        $page = 1;
    }
}

else if (isset($_POST['submit'])) {
    $backres = registerUserFinal();
    if ($backres['state']) {   
        $page = 2;
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

        <?php if ($page == 0) : ?>
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
                    <input type="submit" class="button primary" name="next_1" value="Next">
                </div>
            </div>
        <?php endif ?>
        
        <?php if ($page == 1) : ?>
            <div class="content">
                <div class="box title">
                    <h2>Register</h2>
                    <?php elementMessage() ?>
                </div>
                <div class="box">
                    <label for="nik">Nik:</label><br>
                    <input type="number" id="nik" name="nik" required>
                </div>
                <div class="box">
                    <label for="nama">Nama:</label><br>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="box">
                    <label for="umur">Umur:</label><br>
                    <input type="number" id="umur" name="umur" required>
                </div>
                <div class="box">
                    <input type="submit" class="button primary" name="submit" value="Submit">
                </div>
            </div>
        <?php endif?>

        <?php if ($page == 2 && $backres['state'] && $backres['message'] == "success") : ?>
            <div class="content">
                <div class="box title">
                    <h2>Register</h2>
                    <p class="message success">Data berhasil dikirim</p>
                </div>
                <div class="box">
                    <a class="button primary" href="./login.php">Kembali</a>
                </div>
            </div>
        <?php endif ?>
    </form>
</body>
</html>

<?php function elementMessage() { 
    global $backres;
    ?>
    <?php if (!$backres['state']) :?>
        <?php if ($backres['message'] == "fail_query") : ?>
            <p class="message error">Query database gagal</p>
        <?php elseif ($backres['message'] == "empty_form") : ?>
            <p class="message error">Data tidak boleh kosong</p>
        <?php endif ?>
    <?php else : ?>
    <?php endif ?>
<?php } ?>
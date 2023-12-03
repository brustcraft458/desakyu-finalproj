<?php
require_once "./component/chart.php";
require_once "./component/sidebar.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <main class="d-flex flex-row">
        <!-- Sidebar -->
        <?php Sidebar::selection("dashboard") ?>

        <!-- Dashboard -->
        <div class="container-fluid px-5 py-3">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="d-flex flex-row gap-4">
                <?php Chart::pie(
                    "Hello World",
                    "Kesejahteraan Hati",
                    [
                        "tes" => 20, "tes2" => 20, "tes3" => 50, "tes4" => 20
                    ]
                ) ?>
                <?php Chart::bar(
                    "Hello Dunia",
                    "Hati Hati",
                    [
                        "Wakanda" => 20, "Isekai" => 60, "Konosi" => 50, "Waku" => 20
                    ]
                ) ?>
                <?php Chart::progress(
                    "Tesss",
                    [
                        "Hello" => 20, "Well" => 5
                    ]
                ) ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="./main.js"></script>
</body>

</html>
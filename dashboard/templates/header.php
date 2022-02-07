<?php
$BASE_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/simrs-pelindo/dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/plugins/fontawesome/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $BASE_URL ?>/pt/index.php">PT <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?= $BASE_URL ?>/rs/index.php">
                        RS
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?= $BASE_URL ?>/klinik/index.php">
                        KLINIK
                    </a>
                </li>
            </ul>
        </div>
    </nav>
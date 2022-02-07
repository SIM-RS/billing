<?php
$BASE_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/simrs-pelindo/ppm';
$bulanData = [
    1 => 'Januari',
    2 => 'Pebruari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'Nopember',
    12 => 'Desember',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/plugins/fontawesome/css/all.min.css">
    <script src="<?= $BASE_URL ?>/assets/plugins/Chart.js-master/dist/Chart.bundle.min.js"></script>
    <script src="<?= $BASE_URL ?>/assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= $BASE_URL ?>/assets/js/popper.min.js"></script>
    <script src="<?= $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</head>
<body>

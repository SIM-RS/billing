<?php

include_once 'transaksiPengeluaranFunctions.php';

if(!(isset($_POST['id'])) || $_POST['id'] == '') {
    echo "Failed!"; return false;
}

if(isset($_GET['is_penerimaan'])) {
    $table = TRANSAKSI;
} else {
    $table = TRANSAKSI;
}

$newStatus = 6;
if(is_array($_POST['id'])) {
	foreach ($_POST['id'] as $id) {
		updateTransactionStatus($id, $newStatus, $table);
	}
} else {
	updateTransactionStatus($_POST['id'], $newStatus, $table);
}

echo "Success!";


?>

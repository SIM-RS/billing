<?php

session_start();
include_once 'dbfunctions.php';

if (!defined('TRANSAKSI'))
    define('TRANSAKSI', 'rssh_finance.transaksi');
if (!defined('TRANSAKSI'))
    define("TRANSAKSI", 'rssh_finance.transaksi');

function updateTransactionStatus($id, $newStatus, $table = TRANSAKSI, $additionalValue = array()) {
    $sql = "SELECT `status`, uraian FROM $table WHERE id =" . $id;
    $result = mysql_query($sql);
    $result = mysql_fetch_assoc($result);
    $oldStatus = $result['status'];
    $keterangan = $result['uraian'];

    $additionalValue['status'] = $newStatus;
    $values = '';
    foreach ($additionalValue as $key => $value) {
        $values .= "$key = ";
        if (is_numeric($value)) {
            $values .= $value;
        } else {
            $values .= "'" . $value . "'";
        }

        $values .= ',';
    }

    $values = rtrim($values, ',');

    $sql = "UPDATE $table SET $values WHERE id = $id";
    //echo $sql;
    if (mysql_query($sql)) {
        $sql = buildInsertQuery("{$table}_history_approval", array(
            'user_id' => $_SESSION['id_user'],
            'status_awal' => $oldStatus,
            'status_baru' => $newStatus,
            'transaksi_id' => $id
                ), array(
            'tanggal' => 'now()'
                ));
        ds_insert($sql);

        chdir(dirname(__FILE__));
	   //  ismail hide
       //  include_once('sendEmail.php');

        if($table == TRANSAKSI) {
            $x = 'AR';
        } else {
            $x = 'AP';
        }

        $subject = 'New '.$x.' request need approval';
        $msg = $x.' request "'.$keterangan.'" need your approval.';
        switch ($newStatus) {
            case 1:
                $jabatanId = 22;
                break;
            case 2:
                $jabatanId = 3;
                break;
            case 3:
                $jabatanId = 2;
                break;
            case 4:
                $jabatanId = 1;
                break;
            case 5:
                $jabatanId = 8;
                $subject = 'New '.$x.' request ready to be processed';
                $msg = $x.' request "'.$keterangan.'" has been approved.';
        }

        if($newStatus != 6) {
		//    ismail hide
        //    sendEmail($subject, $msg, $jabatanId);
        }

        return true;
    }
    return false;
}

function getFilterStatusForApproval() {
    $jabatan = getCurrentUserJabatanId();

    foreach($jabatan as $jabatanId) {
        $found = false;
        switch ($jabatanId) {
            case 3:
                $filterStatus = 2;
                $found = true;
                break;
            case 2:
                $filterStatus = 3;
                $found = true;
                break;
            case 1:
                $filterStatus = 4;
                $found = true;
                break;

            default:
                $filterStatus = 99;
                break;
        }

        if($found) break;
    }

    return $filterStatus;
}

function getCurrentUserJabatanId() {
    $sql = "SELECT jbt_id FROM rssh_hcr.pgw_jabatan WHERE pegawai_id = " . $_SESSION['id_user'];
    //echo $sql;
    $query = mysql_query($sql);
    // if (mysql_num_rows($query) <= 0)
    //     return;

    $result = array();
    while($row = mysql_fetch_assoc($query)) {
        $result[] = $row['jbt_id'];
    }
    
    return $result;
}

?>

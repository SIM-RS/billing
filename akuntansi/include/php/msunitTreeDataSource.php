<?php

include_once('koneksi.php');



$response->page = 1;
$response->total = 1;
$response->records = 1;

$type = isset($_POST['type']) ? $_POST['type'] : 0;
if ($type == 1) {
    $sql = "SELECT unit1.idunit, unit1.aktif
            FROM dbkopega_hcr.ms_unit AS unit1
                LEFT JOIN dbkopega_hcr.ms_unit AS unit2 ON unit1.idunit = unit2.parentunit 
            WHERE unit2.idunit IS NULL AND unit1.aktif = 1";
    $resultl = mysql_query($sql);
    $leafNodes = array();
    while ($row = mysql_fetch_assoc($resultl)) {
        $leafnodes[$row['idunit']] = $row['idunit'];
    }

    $node = (integer) $_REQUEST["nodeid"];
    $n_lvl = (integer) $_REQUEST["n_level"];

    $wh = 'AND parentunit=' . $node;
    if ($node > 0) {
        // we ouput the next level
        $n_lvl = $n_lvl + 1;
    }

    $sql = "SELECT * FROM dbkopega_hcr.ms_unit WHERE aktif=1 {$wh} ORDER BY kodeunit";
    $query = mysql_query($sql);

    $i = 0;
    while ($unit = mysql_fetch_assoc($query)) {
        $kode = explode('.', $unit['kodeunit']);
        $level = count($kode) - 1;
        $response->rows[$i]['id'] = $unit['idunit'];

        if ($unit['rc'] !== "0") {
            $namaunit = '<a href="javascript:void(0);">' . $unit['rc'] . ' - ' . $unit['namaunit'] . '</a>';
        } else {
            $namaunit = $unit['namaunit'];
        }

        if ($unit['idunit'] == $leafnodes[$unit['idunit']]) {
            $leaf = 'true'; 
        }
        else {
            $leaf = 'false';
        }
        
        $response->rows[$i]['cell'] = array(
            $unit['idunit'],
            $namaunit,
            $unit['rc'],
            $unit['namaunit'],
            $n_lvl,
            $unit['parentunit'],
            $leaf,
            FALSE
        );
        $i++;
    }
} elseif($type == 4) {
    $sql="SELECT * FROM dbkopega_scm.ms_supplier ORDER BY Supplier_KODE";
	$query = mysql_query($sql);
    
    $i = 0;
    while($supplier = mysql_fetch_assoc($query)) {
        $response->rows[$i]['id'] = $supplier['Supplier_ID'];
        
        $response->rows[$i]['cell'] = array(
            $supplier['Supplier_ID'],
            '<a href="javascript:void(0);">'.$supplier['Supplier_KODE'].' '.$supplier['Supplier_NAMA'].'</a>',
            $supplier['Supplier_KODE'],
            $supplier['Supplier_NAMA'],
            0,
            null,
            true,
            false
        );
        
        $i++;
    }
} else {
    $response->rows[0]['id'] = 0;
    $response->rows[0]['cell'] = array(
        0,
        '',
        '',
        '',
        0,
        null,
        false,
        FALSE
    );
}

echo json_encode($response);
?>

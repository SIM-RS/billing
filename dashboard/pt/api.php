<?php
require_once '../autoload.php';

$act = $_REQUEST['act'];
$dataBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
$pendapatan = new Pendapatan();
$filter = "";
switch ($act) {
    case "getPendapatan":
        $field = " j.tgl,";
        $group = " j.tgl";
        if ($_REQUEST['tipe'] == 1) {
            $where = " AND j.tgl BETWEEN " . "'" . htmlspecialchars($_REQUEST['tanggalAwal']) . "'" . " AND " . "'" . htmlspecialchars($_REQUEST['tanggalAkhir']) . "'";
        } else if ($_REQUEST['tipe'] == 2) {
            $where = " AND YEAR(j.tgl) = {$_REQUEST['tahun']}";
            $group = " MONTH(j.tgl)";
            $field = " MONTH(j.tgl) bulan,";
        } else if ($_REQUEST['tipe'] == 3) {
            $where = " AND MONTH(j.tgl) = {$_REQUEST['bulan']} AND YEAR(j.tgl) = {$_REQUEST['tahun_filter_bulan']}";
        }
        $filter = "SELECT
                        {$field}
                        IFNULL( SUM( j.KREDIT - j.DEBIT ), 0 ) AS jumlah
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '4%' 
                        {$where}
                        AND j.flag = '0'
                    GROUP BY
                        {$group}";
        break;
    case "getBiaya":
        $field = " j.tgl,";
        $group = " j.tgl";
        if ($_REQUEST['tipe'] == 1) {
            $where = " AND j.tgl BETWEEN " . "'" . htmlspecialchars($_REQUEST['tanggalAwal']) . "'" . " AND " . "'" . htmlspecialchars($_REQUEST['tanggalAkhir']) . "'";
        } else if ($_REQUEST['tipe'] == 2) {
            $where = " AND YEAR(j.tgl) = {$_REQUEST['tahun']}";
            $group = " MONTH(j.tgl)";
            $field = " MONTH(j.tgl) bulan,";
        } else if ($_REQUEST['tipe'] == 3) {
            $where = " AND MONTH(j.tgl) = {$_REQUEST['bulan']} AND YEAR(j.tgl) = {$_REQUEST['tahun_filter_bulan']}";
        }
        $filter = "SELECT
                        {$field}
                        IFNULL( SUM(j.DEBIT - j.KREDIT ), 0 ) AS jumlah
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '5%' 
                        {$where}
                        AND j.flag = '0'
                    GROUP BY
                        {$group}";
        break;
    case 'getLaba':
        $field = " MONTH(j.tgl) bulan,";
        $group = " MONTH(j.tgl)";
        if ($_REQUEST['tipe'] == 2) {
            $where = " AND YEAR(j.tgl) = {$_REQUEST['tahun']}";
        } else if ($_REQUEST['tipe'] == 3) {
            $where = " AND MONTH(j.tgl) = {$_REQUEST['bulan']} AND YEAR(j.tgl) = {$_REQUEST['tahun_filter_bulan']}";
        }
        $filter = "SELECT bulan,IFNULL(SUM(jumlah2 - jumlah),0) jumlah FROM (
                    SELECT
                        {$field}
                        IFNULL( SUM(j.DEBIT - j.KREDIT ), 0 ) AS jumlah,
                        '0' AS jumlah2
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '5%' 
                        {$where}
                        AND j.flag = '0'
                    GROUP BY
                        {$group}
                    UNION
                    SELECT
                            {$field}
                            '0' AS jumlah,
                            IFNULL( SUM( j.KREDIT - j.DEBIT ), 0 ) AS jumlah2
                        FROM
                            rspelindo_akuntansi.jurnal j
                            INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                        WHERE
                            ma.MA_KODE LIKE '4%' 
                            {$where}
                            AND j.flag = '0'
                        GROUP BY
                            {$group} ) as q GROUP BY bulan";
        break;
    case 'getAll':
        $field = " j.tgl,";
        $group = " j.tgl";
        $fieldLaba = " MONTH(j.tgl) bulan,";
        $groupLaba = " MONTH(j.tgl)";
        if ($_REQUEST['tipe'] == 1) {
            $where = " AND j.tgl BETWEEN " . "'" . htmlspecialchars($_REQUEST['tanggalAwal']) . "'" . " AND " . "'" . htmlspecialchars($_REQUEST['tanggalAkhir']) . "'";
        } else if ($_REQUEST['tipe'] == 2) {
            $where = " AND YEAR(j.tgl) = {$_REQUEST['tahun']}";
            $group = " MONTH(j.tgl)";
            $field = " MONTH(j.tgl) bulan,";
        } else if ($_REQUEST['tipe'] == 3) {
            $where = " AND MONTH(j.tgl) = {$_REQUEST['bulan']} AND YEAR(j.tgl) = {$_REQUEST['tahun_filter_bulan']}";
        }
        $filterPendapatan = $pendapatan->getDataPendapatan("SELECT
                        IFNULL( SUM( j.KREDIT - j.DEBIT ), 0 ) AS jumlah_pendapatan
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '4%' 
                        {$where}
                        AND j.flag = '0'")->fetch_assoc();
        $filterBiaya = $pendapatan->getDataPendapatan("SELECT
                        {$field}
                        IFNULL( SUM(j.DEBIT - j.KREDIT ), 0 ) AS jumlahBiaya
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '5%' 
                        {$where}
                        AND j.flag = '0'")->fetch_assoc();
        $filterLaba = $pendapatan->getDataPendapatan("SELECT IFNULL(SUM(jumlah2 - jumlah),0) jumlahLaba FROM (
                    SELECT
                        IFNULL( SUM(j.DEBIT - j.KREDIT ), 0 ) AS jumlah,
                        '0' AS jumlah2
                    FROM
                        rspelindo_akuntansi.jurnal j
                        INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                    WHERE
                        ma.MA_KODE LIKE '5%' 
                        {$where}
                        AND j.flag = '0'
                    UNION
                    SELECT  
                            '0' AS jumlah,
                            IFNULL( SUM( j.KREDIT - j.DEBIT ), 0 ) AS jumlah2
                        FROM
                            rspelindo_akuntansi.jurnal j
                            INNER JOIN rspelindo_akuntansi.ma_sak ma ON j.FK_SAK = ma.MA_ID 
                        WHERE
                            ma.MA_KODE LIKE '4%' 
                            {$where}
                            AND j.flag = '0') as q")->fetch_assoc();
    echo json_encode(['pendapatan'=>$filterPendapatan['jumlah_pendapatan'],'biaya'=>$filterBiaya['jumlahBiaya'],'laba'=>$filterLaba['jumlahLaba']]);
    exit;
    break;
}
$data = $pendapatan->getDataPendapatan($filter);
$label = [];
$dataChart = [];
while ($rows = $data->fetch_assoc()) {
    if ($_REQUEST['tipe'] == 1 || ($_REQUEST['tipe'] == 3 && $_REQUEST['act'] != 'getLaba')) {
        array_push($label, $pendapatan->tglIndo($rows['tgl']));
    } else if ($_REQUEST['tipe'] == 2 || ($_REQUEST['tipe'] == 3 && $_REQUEST['act'] == 'getLaba')) {
        array_push($label, $dataBulan[$rows['bulan']]);
    }
    array_push($dataChart, $rows['jumlah']);
}
$dataBalik = ['label' => $label, 'data' => $dataChart];
echo json_encode($dataBalik);

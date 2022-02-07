<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$date_now = gmdate('d-m-Y', mktime(date('H') + 7));
$jam = date("G:i");

$arrBln = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');

$waktu = $_POST['cmbWaktu'];
$cetak = "";
$statusPcr = $_REQUEST['statusPcrPasien'];
$statusPasinSql = "";

if($statusPcr == 1){
    $statusPasinSql = " AND (hp.status_cek_pcr != '-' AND hp.status_cek_pcr is not null)";
}else{
    $statusPasinSql = " AND (hp.status_cek_pcr = '-' or hp.status_cek_pcr is null)";
}

if ($waktu == 'Harian') {
    $tglAwal = explode('-', $_REQUEST['tglAwal2']);
    $tglAwal2 = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
    $waktu = " and pl.tgl = '$tglAwal2' ";
    $Periode = "Tanggal " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2];
    $cetak = $Periode;
} else if ($waktu == 'Bulanan') {
    $bln = $_POST['cmbBln'];
    $thn = $_POST['cmbThn'];
    $waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
    $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    $tanggalAwal = '01/'.$bln.'/'.$thn;
    if($bln == "01" || $bln == "03" || $bln == "05" || $bln == "07" || $bln == "08" || $bln == "10" || $bln == "12"){
        $tanggalAkhir = "31/".$bln.'/'.$thn;
    }else if($bln == "03" || $bln == "04" || $bln == "06" || $bln == "09" || $bln == "11"){
        $tanggalAkhir = "30/".$bln.'/'.$thn;
    }else{
        if($thn % 100 == 0 && $thn % 400 == 0 && $thn % 4 == 0){
            $tanggalAkhir = "29/".$bln.'/'.$thn;
        }else{
            $tanggalAkhir = "28/".$bln.'/'.$thn;
        }
    }
    $cetak = $Periode;

} else {
    $tglAwal = explode('-', $_REQUEST['tglAwal']);
    $tglAwal2 = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
    //echo $arrBln[$tglAwal[1]];
    $tglAkhir = explode('-', $_REQUEST['tglAkhir']);
    $tglAkhir2 = $tglAkhir[2] . '-' . $tglAkhir[1] . '-' . $tglAkhir[0];
    $waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";

    $Periode = "Periode : " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2] . ' s/d ' . $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $tanggalAwal = $tglAwal[0] . ' ' . $arrBln[$tglAwal[1]] . ' ' . $tglAwal[2];
    $tanggalAkhir = $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $cetak = 'Tanggal ' . $tanggalAwal . ' s/d ' . $tanggalAkhir;
}

if ($_REQUEST['JnsLayanan'] == '0') {
    $Jnslay = " ";
} else {
    $Jnslay = "  WHERE id = '" . $_REQUEST['JnsLayanan'] . "' ";
}


$sqlUnit1 = "SELECT id,nama FROM b_ms_unit $Jnslay ";
$rsUnit1 = mysql_query($sqlUnit1);
$rwUnit1 = mysql_fetch_array($rsUnit1);
if ($_REQUEST['TmpLayanan'] != '0') {

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '" . $_REQUEST['TmpLayanan'] . "'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);

    if ($_REQUEST['JnsLayanan'] == '0') {
        $fUnit = " ";
    } else {
        $fUnit = "pl.unit_id=" . $_REQUEST['TmpLayanan'] . " ";
    }
} else {

    if ($_REQUEST['JnsLayanan'] == '0') {
        $fUnit = " ";
    } else {
        $fUnit = " AND u.parent_id=" . $_REQUEST['JnsLayanan'] . " ";
    }
}
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '" . $_REQUEST['user_act'] . "'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);

$stsPas = $_REQUEST['StatusPas'];
if ($stsPas != 0) {
    $fKso = " AND pl.kso_id = $stsPas ";
}
if($_POST['export']=='excel'){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}

function cnvtTanggal($data){
    $tanggal = explode('-',$data);
    return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
}

function wilayah($id){
    $sql = "SELECT nama FROM b_ms_wilayah WHERE id = {$id}";
    $query = mysql_fetch_assoc(mysql_query($sql));
    return $query['nama'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PASIEN COV LAB PCR</title>
    <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
        <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="javascript" src="../loket/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
		<script language="JavaScript" src="../../theme/js/mm_menu.js"></script>

		<link rel="stylesheet" type="text/css" href="../../theme/bs/bootstrap.min.css" />

        <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>
		
        <script type="text/javascript" src="../../theme/prototype.js"></script>
        <script type="text/javascript" src="../../theme/effects.js"></script>
		<script type="text/javascript" src="../../theme/popup.js"></script>
        <script src="../../theme/bs/bootstrap.min.js"></script>
        
        <style>
            table.table-bordered, td, th {
            border: 1px solid black !important;
            vertical-align: middle !important;
            }
        </style>
</head>

<body>
    <table class="table table-sm table-bordered" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
        <tr>
            <td colspan="22">&nbsp</td>
            <td colspan="5">Laporan Lab PCR RS Prima Husada Cipta Medan</td>
        </tr>
        <tr>
            <td colspan="22"></td>
            <td colspan="5"><?= $cetak ?></td>
        </tr>
        <tr class="text-center">
            <th rowspan="3" style="white-space:nowrap">NO URUT(Reg Lab)</th>
            <th rowspan="3" style="white-space:nowrap">NAMA PASIEN</th>
            <th rowspan="3" style="white-space:nowrap">WNI/WNA</th>
            <th rowspan="3" style="white-space:nowrap">NIK/NO.IDENTITAS (KTP/KK/PASPOR)</th>
            <th rowspan="3" style="white-space:nowrap">NO REKAM MEDIS</th>
            <th rowspan="3" style="white-space:nowrap">TANGGAL LAHIR</th>
            <th rowspan="3" style="white-space:nowrap">UMUR (TAHUN)</th>
            <th rowspan="3">JENIS KELAMIN (P/L)</th>
            <th colspan="6" rowspan="2" valign="top">ALAMAT TERDUGA/PASIEN COVID-19 (KTP / DOMISILI)</th>
            <th rowspan="3" style="white-space:nowrap">PETUGAS KESEHATAN (NAKES)</th>
            <th rowspan="3" style="white-space:nowrap">STATUS KEHAMILAN</th>
            <th rowspan="3" style="white-space:nowrap">NO.HP PASIEN / KELUARGA</th>
            <th rowspan="3" style="white-space:nowrap">NO.HP DOKTER PENGIRIM</th>
            <th rowspan="3" style="white-space:nowrap">ASAL RS RUJUKAN COVID</th>
            <th rowspan="3" style="white-space:nowrap">ALASAN PEMERIKSAAN</th>
            <th rowspan="3" style="white-space:nowrap">KRITERIA PASIEN</th>
            <th rowspan="3" style="white-space:nowrap">JENIS SPESIMEN</th>
            <th rowspan="3" style="white-space:nowrap">TANGGAL PENGAMBILAN SPESIMEN</th>
            <th rowspan="3" style="white-space:nowrap">TANGGAL PEMERIKSAAN SPESIMEN</th>
            <th rowspan="3" style="white-space:nowrap">PEMERIKSAAN KE</th>
            <th rowspan="3" style="white-space:nowrap">HASIL LAB (Pemeriksaan TCM COVID-19)</th>
            <th rowspan="3" style="white-space:nowrap">KETERANGAN</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th>KTP/Domisili</th>
            <th>Provinsi</th>
            <th>Kabupaten/Kota</th>
            <th>Kecamatan</th>
            <th>Kelurahan</th>
            <th style="white-space:nowrap">Alamat Lengkap</th>
        </tr>
        <tr class="text-center">
            <?php for($i = 1; $i <= 27; $i++){ ?>
                <td>(<?= $i ?>)</td>
            <?php } ?>
        </tr>
        <?php
            
            $sqlPas = "SELECT
                            hp.id AS id_hasil,
                            p.id AS id_pasien,
                            p.*,
                            k.umur_thn,
                            hp.*,
                            pl.kso_id
                        FROM
                            b_hasil_pcr hp
                            INNER JOIN b_ms_pasien p ON p.id = hp.id_pasien
                            LEFT JOIN b_kunjungan k ON k.id = hp.id_kunjungan
                            LEFT JOIN b_pelayanan pl ON pl.id = hp.id_pelayanan
                            LEFT JOIN b_ms_kso_pasien kp ON kp.pasien_id = hp.id_pasien 
                        WHERE
                    $fUnit $waktu $statusPasinSql
                        ORDER BY p.nama asc";
                // echo $sqlPas;
                $rsPas = mysql_query($sqlPas);
                $no = 1;
                while($rwPas = mysql_fetch_array($rsPas))
                {   
                    $count = mysql_num_rows(mysql_query("SELECT id_pasien FROM b_hasil_pcr WHERE id_pasien = {$rwPas['id_pasien']}"));

                    echo '<tr valign="top">';
                    echo '<td>'.$rwPas['no_registrasi_lab'].'</td>';
                    echo '<td>'.$rwPas['nama'].'</td>';
                    echo '<td>'.($rwPas['id_kw'] == 1 ? 'WNI' : 'WNA').'</td>';
                    echo '<td>'.$rwPas['no_ktp'].'</td>';
                    echo '<td>'.$rwPas['no_rm'].'</td>';
                    echo '<td>'.cnvtTanggal($rwPas['tgl_lahir']).'</td>';
                    echo '<td>'.$rwPas['umur_thn'].'</td>';
                    echo '<td>'.$rwPas['sex'].'</td>';
                    echo '<td>'.$rwPas['ktp_domisili'].'</td>';
                    echo '<td>'.wilayah($rwPas['prop_id']).'</td>';
                    echo '<td>'.wilayah($rwPas['kab_id']).'</td>';
                    echo '<td>'.wilayah($rwPas['kec_id']).'</td>';
                    echo '<td>'.wilayah($rwPas['desa_id']).'</td>';
                    echo '<td>'.$rwPas['alamat'].'</td>';
                    echo '<td>'.$rwPas['petugas_kesehatan'].'</td>';
                    echo '<td>'.$rwPas['status_hamil'].'</td>';
                    echo '<td>'.$rwPas['telp'].'</td>';
                    echo '<td>'.$rwPas['dokter_pengirim'].'('.$rwPas['no_hp_dokter_pengirim'].')</td>';
                    echo '<td>'.($rwPas['kso_id'] == 63 ? "KLINIK PRATAMA KRAKATAU" : "RS PHCM").'</td>';
                    echo '<td>'.$rwPas['alasan_pemeriksaan'].'</td>';
                    echo '<td>'.$rwPas['kriteria_pasien'].'</td>';
                    echo '<td>'.$rwPas['jenis_spesimen'].'</td>';
                    echo '<td>'.cnvtTanggal($rwPas['tanggal_swab']).'</td>';
                    echo '<td>'.cnvtTanggal($rwPas['tanggal_pemeriksaan']).'</td>';
                    echo '<td>'.$count.'</td>';
                    if($rwPas['status_cek_pcr'] == '' or $rwPas['status_cek_pcr'] == '-'){
                        echo '<td></td>';

                    }else{
                        echo '<td>'.($rwPas['status_cek_pcr'] == 'POSITIF SARS-COV-2' ? "POSITIF" : "NEGATIF").'</td>';                    
                    }
                    echo '<td>'.$rwPas['keterangan'].'</td>';
                    echo '</tr>';
                    
                }
                
        ?>
    </table>
</body>

</html>
<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
function tanggalC($tgl)
{
    $tanggal = explode('-', $tgl);
    return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
}

$date_now = gmdate('d-m-Y', mktime(date('H') + 7));
$jam = date("G:i");

$arrBln = array('01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER');

$waktu = $_POST['cmbWaktu'];
if ($waktu == 'Harian') {
    $tglAwal = explode('-', $_REQUEST['tglAwal2']);
    $tglAwal2 = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
    $waktu = " AND t.tgl = '$tglAwal2' ";
    $Periode = "TANGGAL " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2];
    $cetak = $Periode;
} else if ($waktu == 'Bulanan') {
    $bln = $_POST['cmbBln'];
    $thn = $_POST['cmbThn'];
    $waktu = " AND month(t.tgl) = '$bln' and year(t.tgl) = '$thn' ";
    $Periode = "BULAN $arrBln[$bln] TAHUN $thn";
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
    $waktu = " and t.tgl between '$tglAwal2' and '$tglAkhir2' ";

    $Periode = "Periode : " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2] . ' s/d ' . $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $tanggalAwal = $tglAwal[0] . ' ' . $arrBln[$tglAwal[1]] . ' ' . $tglAwal[2];
    $tanggalAkhir = $tglAkhir[0] . " " . $arrBln[$tglAkhir[1]] . " " . $tglAkhir[2];
    $cetak = 'TANGGAL ' . $tanggalAwal . ' s/d ' . $tanggalAkhir;
}

if ($_REQUEST['JnsLayananBaru'] == '0') {
    $Jnslay = " ";
} else {
    $Jnslay = "  WHERE id = '" . $_REQUEST['JnsLayananBaru'] . "' ";
}


$sqlUnit1 = "SELECT id,nama FROM b_ms_unit $Jnslay ";
$rsUnit1 = mysql_query($sqlUnit1);
if($_REQUEST['JnsLayananBaru'] == 0){
    $rwUnit1 = ['nama' => 'SEMUA'];
}else{
    $rwUnit1 = mysql_fetch_array($rsUnit1);
}
if ($_REQUEST['TmpLayananBaru'] != '0') {

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '" . $_REQUEST['TmpLayananBaru'] . "'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);

    if ($_REQUEST['JnsLayananBaru'] == '0') {
        $fUnit = " ";
    } else {
        $fUnit = "AND t.ms_tindakan_unit_id =" . $_REQUEST['TmpLayananBaru'] . " ";
    }
} else {

    if ($_REQUEST['JnsLayananBaru'] == '0') {
        $fUnit = " ";
    } else {
        // $fUnit = " AND u.parent_id=" . $_REQUEST['JnsLayananBaru'] . " ";
    }
}
$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '" . $_REQUEST['user_act'] . "'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);

$stsPas = $_REQUEST['StatusPas'];
if ($stsPas != 0) {
    $fKso = " AND t.kso_id = $stsPas ";
}
if($_POST['export']=='Export Excell'){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="Lap Guarantee Dokter.xls"');
}
$sqlPencetak = mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$_REQUEST['user_act']}"));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php if($_REQUEST['export'] != 'Export Excell'){ ?>
    <link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />        
    <link rel="stylesheet" type="text/css" href="../../theme/bs/bootstrap.min.css" />
    <?php } ?>
    <script type="text/javascript" src="../../theme/js/tab-view.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" language="javascript" src="../loket/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
    <script language="JavaScript" src="../../theme/js/mm_menu.js"></script>


    <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
    <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>

    <script type="text/javascript" src="../../theme/prototype.js"></script>
    <script type="text/javascript" src="../../theme/effects.js"></script>
    <script type="text/javascript" src="../../theme/popup.js"></script>
    <script src="../../theme/bs/bootstrap.min.js"></script>
</head>

<body>
<?php
$queryDokter = mysql_query("SELECT td.id_dokter,p.nama,td.id_tindakan_kelas FROM b_ms_tarif_dokter td LEFT JOIN b_ms_pegawai p ON p.id = td.id_dokter WHERE td.stat_guarantee IS NOT NULL AND td.id_dokter = {$_REQUEST['cmbDokSemua']} GROUP BY td.id_dokter,p.nama");
    $sqlPelaksana = mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$_REQUEST['cmbDokSemua']}"));
?>
<div class="container p-2">
        <p style="font-weight: bold;">
            RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN<br>
            JL. Stasiun No. 92<br>
            Telepon (061) 6941927 - 6940120<br>
            Medan<br>
        </p>
        <table class="table table-borderless table-sm">
            <tr>
                <td colspan="5" align="center" style="font-weight: bold;text-transform: uppercase;border: none;">REKAPITULASI PENDAPATAN GUARANTEE DOKTER<br><?= $cetak?></td>
            </tr>
            <tr>
                <td style="border: none;" colspan="3">Pelaksana : <?= $sqlPelaksana['nama'] ?></td>
                <td style="border: none;" colspan="2" align="right">Jenis Layanan : <?= $rwUnit1['nama'] ?></td>
            </tr>
        </table>
        <table border="1" class="table table-bordered table-sm">
            <thead>
                <th>Uraian</th>
                <th>Jumlah Tindakan</th>
                <th>Nominal Gurantee / Jumlah</th>
                <th>Guarantee</th>
            </thead>
            <tbody>
                 <?php

                while ($rows = mysql_fetch_assoc($queryDokter)) {
                     $sql = mysql_query("SELECT
                                ms_tindakan_kelas_id,
                                nama,
                                tgl,
                                count(*) jumlah,
                                sum( tarip ) total,
                                nominal_guarantee,
                                stat_guarantee,
                                jumlah_tindakan_guarantee,
                                nilai_guarantee,
                                tarip 
                            FROM
                                (
                                SELECT
                                    q.*,
                                    td.nominal_guarantee,
                                    td.stat_guarantee,
                                    td.jumlah_tindakan_guarantee,
                                    td.nilai_guarantee
                                FROM
                                    (
                                    SELECT
                                        t.kunjungan_id,
                                        t.tgl,
                                        t.tgl_act,
                                        mt.nama,
                                        tk.tarip,
                                        t.ms_tindakan_kelas_id 
                                    FROM
                                        b_tindakan t
                                        LEFT JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
                                        LEFT JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id 
                                    WHERE
                                        t.user_id = {$rows['id_dokter']}
                                        {$waktu} {$fUnit} {$fKso}
                                    ) AS q
                                    INNER JOIN ( SELECT * FROM b_ms_tarif_dokter WHERE id_dokter = {$rows['id_dokter']}  AND nominal_guarantee != 0) td ON td.id_tindakan_kelas = q.ms_tindakan_kelas_id 
                                ) AS t 
                            GROUP BY
                                ms_tindakan_kelas_id,MONTH(tgl)");
                    if(mysql_num_rows($sql) > 0){
                        echo "<tr>";
                        echo "<td colspan='4' class='font-weight-bold'>" . $rows['nama'] . "</td>";
                        echo "</tr>";
                    }
                    while ($data = mysql_fetch_assoc($sql)) {
                        $guarantee = 0;
                        echo '<td>'.$data['nama'].'</td>';
                        echo '<td class="text-right">'.$data['jumlah'].'</td>';
                        echo '<td class="text-right">'.number_format($data['nominal_guarantee'],0,",",",").'</td>';
                        if($data['stat_guarantee'] == 1){
                            if($data['jumlah'] <= $data['jumlah_tindakan_guarantee']){
                                $guarantee = $data['nominal_guarantee'];
                            }else{
                                //nominal + (jumlah tindakan - jumlah pasien guarantee perbulan) * tarif tindakan / persentase nya
                                $guarantee = $data['nominal_guarantee'] + (($data['jumlah'] - $data['jumlah_tindakan_guarantee']) * ($data['tarip'] * ($data['nilai_guarantee'] / 100)));                                
                            }
                        }else{
                            if($data['jumlah'] <= $data['jumlah_tindakan_guarantee']){
                                $guarantee = $data['nominal_guarantee'];
                            }else{
                                $guarantee = $data['nominal_guarantee'] + (($data['jumlah'] - $data['jumlah_tindakan_guarantee']) * $data['nilai_guarantee']);
                            }
                        }
                        echo '<td class="text-right">'.number_format($guarantee, 0, ",", ",").'</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        <table class="table table-borderless table-sm">
        <tr>
            <td height="70" align="right" valign="top" colspan="5">
                Tanggal Cetak  : <?= date('d-m-Y') . ' Jam : ' . date('H:i')?><br>
                Yang Mencetak
            </td>
        </tr>
        <tr>
            <td align="right" colspan="5">
                <br>
                <br>
                <b><?= $sqlPencetak['nama'] ?></b>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="table table-borderless table-sm">
        <tr id="trTombol">
            <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
        </tr>
    </table>
    </div>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
        window.print();
        window.close();
        }
    }
</script>
</body>

</html>
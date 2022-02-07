<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
date_default_timezone_set('Asia/Jakarta');
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
    $waktu = " t.tgl = '$tglAwal2' ";
    $Periode = "TANGGAL " . $tglAwal[0] . " " . $arrBln[$tglAwal[1]] . " " . $tglAwal[2];
    $cetak = $Periode;
} else if ($waktu == 'Bulanan') {
    $bln = $_POST['cmbBln'];
    $thn = $_POST['cmbThn'];
    $waktu = " month(t.tgl) = '$bln' and year(t.tgl) = '$thn' ";
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
    $waktu = " t.tgl between '$tglAwal2' and '$tglAkhir2' ";

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
if($_POST['export']=='excel'){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="Lap Konsultasi/Visite Dokter Terbanyak.xls"');
}
$sqlPencetak = mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$_REQUEST['user_act']}"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.:Laporan Pendapatan Dokter dan RS Tindakan</title>
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
    $sqlBagi = "SELECT b_ms_kso.id,b_ms_kso.nama FROM b_ms_kso INNER JOIN
(SELECT
	* 
FROM
	(
	SELECT
		td.nama,
		td.kelas,
		kso.id,
		kso.nama AS nama_kso,
		t.ms_tindakan_unit_id,
		u.nama as nama_unit,
		count(*) terbanyak 
	FROM
		b_tindakan t
		INNER JOIN (
		SELECT
			tk.id tindakan_kelas,
			t2.id tindakan,
			t2.nama,
			k.nama AS kelas 
		FROM
			b_ms_tindakan_kelas tk
			INNER JOIN ( SELECT id, nama FROM b_ms_tindakan WHERE nama LIKE 'konsultasi%' ) t2 ON tk.ms_tindakan_id = t2.id
			LEFT JOIN b_ms_kelas k ON k.id = tk.ms_kelas_id 
		) td ON td.tindakan_kelas = t.ms_tindakan_kelas_id
		LEFT JOIN b_ms_kso kso ON kso.id = t.kso_id
	  LEFT JOIN b_ms_unit u ON u.id = t.ms_tindakan_unit_id
	WHERE
      	{$waktu}
        {$fKso} 
	GROUP BY
		t.ms_tindakan_unit_id,
		t.ms_tindakan_kelas_id,
		t.kso_id 
	ORDER BY
		ms_tindakan_kelas_id 
	) AS dataKonsultasiTerbanyak 
ORDER BY
	nama_kso DESC,
	terbanyak DESC) td ON td.id = b_ms_kso.id
GROUP BY
	td.id
	";
	$queryBagi = mysql_query($sqlBagi);
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
                <td colspan="2" align="center" style="font-weight: bold;text-transform: uppercase;border: none;">LAPORAN KONSULTASI DOKTER TERBANYAK<br><?= $cetak?></td>
            </tr>
        </table>
        <table border="1" class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Nama Tindakan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowsCari = mysql_fetch_array($queryBagi)) {
	                echo '<tr><td colspan="2" style="font-weight:bold">'.$rowsCari['nama'].'</td>';

      				 $sql = "SELECT * FROM(SELECT
									td.nama,
									td.kelas,
									kso.id,
									kso.nama AS nama_kso,
									t.ms_tindakan_unit_id,
									u.nama as nama_unit,
									count(*) terbanyak 
								FROM
									b_tindakan t
									INNER JOIN (
									SELECT
										tk.id tindakan_kelas,
										t2.id tindakan,
										t2.nama,
										k.nama AS kelas 
									FROM
										b_ms_tindakan_kelas tk
										INNER JOIN ( SELECT id, nama FROM b_ms_tindakan WHERE nama LIKE 'konsultasi%' ) t2 ON tk.ms_tindakan_id = t2.id
										LEFT JOIN b_ms_kelas k ON k.id = tk.ms_kelas_id 
									) td ON td.tindakan_kelas = t.ms_tindakan_kelas_id
									LEFT JOIN b_ms_kso kso ON kso.id = t.kso_id
								  LEFT JOIN b_ms_unit u ON u.id = t.ms_tindakan_unit_id
								WHERE
							      	{$waktu}
							        {$fKso} 
								GROUP BY
									t.ms_tindakan_unit_id,
									t.ms_tindakan_kelas_id,
									t.kso_id 
								ORDER BY
									ms_tindakan_kelas_id 
								) AS dataKonsultasiTerbanyak
							WHERE
								id = {$rowsCari['id']} 
							ORDER BY
								nama_kso DESC,
								terbanyak DESC";
					    $queryDokter = mysql_query($sql);         		
               		while ($rows = mysql_fetch_assoc($queryDokter)) {
	                    echo '<tr><td colspan="2" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rows['nama_unit'].'</td>';
	                    echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rows['nama'].'</td>';
	                    echo '<td align="right">'.$rows['terbanyak'].'</td><tr>';
	                }   
                }
                ?>
            </tbody>
        </table>
    <table class="table table-borderless table-sm">
        <tr>
            <td height="70" align="right" valign="top" colspan="2">
                Tanggal Cetak  : <?= date('d-m-Y') . ' Jam : ' . date('H:i')?><br>
                Yang Mencetak
            </td>
        </tr>
        <tr>
            <td align="right" colspan="2">
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

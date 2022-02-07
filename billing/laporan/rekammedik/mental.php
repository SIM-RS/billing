<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="mental.xls"');
}

?>
<?php
	include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$semester = $_POST['cmbTri'];
	$thn = $_POST['cmbThnTri'];
	if($_POST['cmbTri']=='1'){
		$bln = "TRIBULAN I: JANUARI - MARET";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '01' AND '03'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}elseif($_POST['cmbTri']=='2'){
		$bln = "TRIBULAN II: APRIL - JUNI";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '04' AND '06'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}elseif($_POST['cmbTri']=='3'){
		$bln = "TRIBULAN III: JULI - SEPTEMBER";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '07' AND '09'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	}else{
		$bln = "TRIBULAN IV: OKTOBER - DESEMBER";
		$waktu = "AND MONTH(b_diagnosa_rm.tgl) BETWEEN '10' AND '12'";
		$tahun = "AND YEAR(b_diagnosa_rm.tgl)='".$thn."'";
	} 
    
    $sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
    $rsUnit1 = mysql_query($sqlUnit1);
    $rwUnit1 = mysql_fetch_array($rsUnit1);

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);
    
    $sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
    $rsKso = mysql_query($sqlKso);
    $rwKso = mysql_fetch_array($rsKso);
    
    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
?>
<style>
    .jdl{
        font-size:12px;
        font-weight:bold;
        border-top:1px solid;
        border-bottom:1px solid;
        border-left:1px solid;
        background-color:#00FF00;
        height:30;
        text-align:center;
    }
    .jdlKn{
        font-size:12px;
        font-weight:bold;
        border-top:1px solid;
        border-bottom:1px solid;
        border-left:1px solid;
        border-right:1px solid;
        height:30;
        text-align:center;
        background-color:#00FF00;
    }
    .jdldlm{
        border-left:1px solid;
        border-bottom:1px solid;
        height:30;
        text-align:center;
        font-weight:bold;
    }
    .isi{
        border-left:1px solid;
        border-bottom:1px solid;
    }
    .isiKn{
        border-left:1px solid;
        border-bottom:1px solid;
        border-right:1px solid;
    }
</style>
<title>.: Data Pasien Gangguan Mental dan Perilaku Akibat Penggunaan Napza :.</title>

<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td valign="top" height="70" style="text-transform:uppercase; font-weight:bold; font-size:14px; text-align:center;">data pasien rawat jalan gangguan mental dan<br>prilaku akibat penggunaan napza<br><?php echo $bln.'&nbsp;'.$thn;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                    <td rowspan=3 class=jdl>Kode</td>
                    <td rowspan=3 class=jdl>Golongan Sebab Sakit</td>
                    <td colspan=5 class=jdl>Kasus Baru</td>
                    <td rowspan=2 colspan=2 class=jdl>Sex</td>
                    <td rowspan=3 class=jdl>Jumlah<br>Pasien<br>Keluar</td>
                    <td rowspan=3 class=jdlKn>Jumlah<br>Pasien<br>Mati</td>
                </tr>
                <tr>
                    <td colspan=5 class=jdldlm style="background-color:#00FF00;">Menurut Golongan Umur</td>
                </tr>
                <tr>
                    <td class=jdldlm style="background-color:#FFFF00;">< 15 th</td>
                    <td class=jdldlm style="background-color:#FFFF00;">15-24 th</td>
                    <td class=jdldlm style="background-color:#FFFF00;">25-44 th</td>
                    <td class=jdldlm style="background-color:#FFFF00;">45-64 th</td>
                    <td class=jdldlm style="background-color:#FFFF00;">65+ th</td>
                    <td class=jdldlm style="background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="background-color:#FFFF00;">P</td>
                </tr>
                <tr>
                    <td class=isi width=5% style="text-align:center;">F10</td>
                    <td class=isi width=25% style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan alkohol</td>
                    <?php
                        $sql10 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F10%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs10 = mysql_query($sql10);
                        $rw10 = mysql_fetch_array($rs10);
                    ?>
                    <td class=isi width=8% style="text-align:center;"><?php if($rw10['satu']=="" || $rw10['satu']==0) echo "&nbsp;"; else echo $rw10['satu'];?></td>
                    <td class=isi width=8% style="text-align:center;"><?php if($rw10['dua']=="" || $rw10['dua']==0) echo "&nbsp;"; else echo $rw10['dua'];?></td>
                    <td class=isi width=8% style="text-align:center;"><?php if($rw10['tiga']=="" || $rw10['tiga']==0) echo "&nbsp;"; else echo $rw10['tiga'];?></td>
                    <td class=isi width=8% style="text-align:center;"><?php if($rw10['empat']=="" || $rw10['empat']==0) echo "&nbsp;"; else echo $rw10['empat'];?></td>
                    <td class=isi width=8% style="text-align:center;"><?php if($rw10['lima']=="" || $rw10['lima']==0) echo "&nbsp;"; else echo $rw10['lima'];?></td>
                    <td class=isi width=5% style="text-align:center;"><?php if($rw10['L']=="" || $rw10['L']==0) echo "&nbsp;"; else echo $rw10['L'];?></td>
                    <td class=isi width=5% style="text-align:center;"><?php if($rw10['P']=="" || $rw10['P']==0) echo "&nbsp;"; else echo $rw10['P'];?></td>
                    <td class=isi width=10% style="text-align:center;"><?php if($rw10['hidup']=="" || $rw10['hidup']==0) echo "&nbsp;"; else echo $rw10['hidup'];?></td>
                    <td class=isiKn width=10% style="text-align:center;"><?php if($rw10['mati']=="" || $rw10['mati']==0) echo "&nbsp;"; else echo $rw10['mati'];?></td>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F11</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Oplolda</td>
                    <?php
                        $sql11 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F11%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs11 = mysql_query($sql11);
                        $rw11 = mysql_fetch_array($rs11);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw11['satu']=="" || $rw11['satu']==0) echo "&nbsp;"; else echo $rw11['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['dua']=="" || $rw11['dua']==0) echo "&nbsp;"; else echo $rw11['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['tiga']=="" || $rw11['tiga']==0) echo "&nbsp;"; else echo $rw11['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['empat']=="" || $rw11['empat']==0) echo "&nbsp;"; else echo $rw11['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['lima']=="" || $rw11['lima']==0) echo "&nbsp;"; else echo $rw11['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['L']=="" || $rw11['L']==0) echo "&nbsp;"; else echo $rw11['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['P']=="" || $rw11['P']==0) echo "&nbsp;"; else echo $rw11['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw11['hidup']=="" || $rw11['hidup']==0) echo "&nbsp;"; else echo $rw11['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw11['mati']=="" || $rw11['mati']==0) echo "&nbsp;"; else echo $rw11['mati'];?></td>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F12</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Kanabinoida</td>
                    <?php
                        $sql12 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F12%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs12 = mysql_query($sql12);
                        $rw12 = mysql_fetch_array($rs12);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw12['satu']=="" || $rw12['satu']==0) echo "&nbsp;"; else echo $rw12['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['dua']=="" || $rw12['dua']==0) echo "&nbsp;"; else echo $rw12['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['tiga']=="" || $rw12['tiga']==0) echo "&nbsp;"; else echo $rw12['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['empat']=="" || $rw12['empat']==0) echo "&nbsp;"; else echo $rw12['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['lima']=="" || $rw12['lima']==0) echo "&nbsp;"; else echo $rw12['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['L']=="" || $rw12['L']==0) echo "&nbsp;"; else echo $rw12['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['P']=="" || $rw12['P']==0) echo "&nbsp;"; else echo $rw12['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw12['hidup']=="" || $rw12['hidup']==0) echo "&nbsp;"; else echo $rw12['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw12['mati']=="" || $rw12['mati']==0) echo "&nbsp;"; else echo $rw12['mati'];?></td>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F13</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Sedativa atau Hipnotika</td>
                    <?php
                        $sql13 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F13%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs13 = mysql_query($sql13);
                        $rw13 = mysql_fetch_array($rs13);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw13['satu']=="" || $rw13['satu']==0) echo "&nbsp;"; else echo $rw13['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['dua']=="" || $rw13['dua']==0) echo "&nbsp;"; else echo $rw13['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['tiga']=="" || $rw13['tiga']==0) echo "&nbsp;"; else echo $rw13['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['empat']=="" || $rw13['empat']==0) echo "&nbsp;"; else echo $rw13['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['lima']=="" || $rw13['lima']==0) echo "&nbsp;"; else echo $rw13['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['L']=="" || $rw13['L']==0) echo "&nbsp;"; else echo $rw13['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['P']=="" || $rw13['P']==0) echo "&nbsp;"; else echo $rw13['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw13['hidup']=="" || $rw13['hidup']==0) echo "&nbsp;"; else echo $rw13['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw13['mati']=="" || $rw13['mati']==0) echo "&nbsp;"; else echo $rw13['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F14</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Kokain</td>
                    <?php
                        $sql14 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F14%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs14 = mysql_query($sql14);
                        $rw14 = mysql_fetch_array($rs14);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw14['satu']=="" || $rw14['satu']==0) echo "&nbsp;"; else echo $rw14['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['dua']=="" || $rw14['dua']==0) echo "&nbsp;"; else echo $rw14['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['tiga']=="" || $rw14['tiga']==0) echo "&nbsp;"; else echo $rw14['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['empat']=="" || $rw14['empat']==0) echo "&nbsp;"; else echo $rw14['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['lima']=="" || $rw14['lima']==0) echo "&nbsp;"; else echo $rw14['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['L']=="" || $rw14['L']==0) echo "&nbsp;"; else echo $rw14['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['P']=="" || $rw14['P']==0) echo "&nbsp;"; else echo $rw14['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw14['hidup']=="" || $rw14['hidup']==0) echo "&nbsp;"; else echo $rw14['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw14['mati']=="" || $rw14['mati']==0) echo "&nbsp;"; else echo $rw14['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F15</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Stimulansia lain termasuk Kafein</td>
                    <?php
                        $sql15 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F15%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs15 = mysql_query($sql15);
                        $rw15 = mysql_fetch_array($rs15);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw15['satu']=="" || $rw15['satu']==0) echo "&nbsp;"; else echo $rw15['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['dua']=="" || $rw15['dua']==0) echo "&nbsp;"; else echo $rw15['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['tiga']=="" || $rw15['tiga']==0) echo "&nbsp;"; else echo $rw15['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['empat']=="" || $rw15['empat']==0) echo "&nbsp;"; else echo $rw15['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['lima']=="" || $rw15['lima']==0) echo "&nbsp;"; else echo $rw15['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['L']=="" || $rw15['L']==0) echo "&nbsp;"; else echo $rw15['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['P']=="" || $rw15['P']==0) echo "&nbsp;"; else echo $rw15['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw15['hidup']=="" || $rw15['hidup']==0) echo "&nbsp;"; else echo $rw15['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw15['mati']=="" || $rw15['mati']==0) echo "&nbsp;"; else echo $rw15['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F16</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akiubat penggunaan Halusinogenika</td>
                    <?php
                        $sql16 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F16%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs16 = mysql_query($sql16);
                        $rw16 = mysql_fetch_array($rs16);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw16['satu']=="" || $rw16['satu']==0) echo "&nbsp;"; else echo $rw16['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['dua']=="" || $rw16['dua']==0) echo "&nbsp;"; else echo $rw16['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['tiga']=="" || $rw16['tiga']==0) echo "&nbsp;"; else echo $rw16['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['empat']=="" || $rw16['empat']==0) echo "&nbsp;"; else echo $rw16['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['lima']=="" || $rw16['lima']==0) echo "&nbsp;"; else echo $rw16['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['L']=="" || $rw16['L']==0) echo "&nbsp;"; else echo $rw16['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['P']=="" || $rw16['P']==0) echo "&nbsp;"; else echo $rw16['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw16['hidup']=="" || $rw16['hidup']==0) echo "&nbsp;"; else echo $rw16['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw16['mati']=="" || $rw16['mati']==0) echo "&nbsp;"; else echo $rw16['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F17</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan Tembakau</td>
                    <?php
                        $sql17 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F17%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs17 = mysql_query($sql17);
                        $rw17 = mysql_fetch_array($rs17);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw17['satu']=="" || $rw17['satu']==0) echo "&nbsp;"; else echo $rw17['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['dua']=="" || $rw17['dua']==0) echo "&nbsp;"; else echo $rw17['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['tiga']=="" || $rw17['tiga']==0) echo "&nbsp;"; else echo $rw17['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['empat']=="" || $rw17['empat']==0) echo "&nbsp;"; else echo $rw17['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['lima']=="" || $rw17['lima']==0) echo "&nbsp;"; else echo $rw17['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['L']=="" || $rw17['L']==0) echo "&nbsp;"; else echo $rw17['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['P']=="" || $rw17['P']==0) echo "&nbsp;"; else echo $rw17['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw17['hidup']=="" || $rw17['hidup']==0) echo "&nbsp;"; else echo $rw17['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw17['mati']=="" || $rw17['mati']==0) echo "&nbsp;"; else echo $rw17['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F18</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan pelarut yang mudah menguap</td>
                    <?php
                        $sql18 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F18%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs18 = mysql_query($sql18);
                        $rw18 = mysql_fetch_array($rs18);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw18['satu']=="" || $rw18['satu']==0) echo "&nbsp;"; else echo $rw18['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['dua']=="" || $rw18['dua']==0) echo "&nbsp;"; else echo $rw18['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['tiga']=="" || $rw18['tiga']==0) echo "&nbsp;"; else echo $rw18['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['empat']=="" || $rw18['empat']==0) echo "&nbsp;"; else echo $rw18['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['lima']=="" || $rw18['lima']==0) echo "&nbsp;"; else echo $rw18['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['L']=="" || $rw18['L']==0) echo "&nbsp;"; else echo $rw18['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['P']=="" || $rw18['P']==0) echo "&nbsp;"; else echo $rw18['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw18['hidup']=="" || $rw18['hidup']==0) echo "&nbsp;"; else echo $rw18['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw18['mati']=="" || $rw18['mati']==0) echo "&nbsp;"; else echo $rw18['mati'];?></td>
                </tr>
                </tr>
                <tr>
                    <td class=isi style="text-align:center;">F19</td>
                    <td class=isi style="padding-left:5px;" height=50>Gangguan mental dan prilaku akibat penggunaan zat Multipel dan penggunaan zat Psikoaktif lainnya</td>
                    <?php
                        $sql19 = "SELECT SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=24,1,0)) AS dua,
                                SUM(IF(b_kunjungan.umur_thn>=25 AND b_kunjungan.umur_thn<=44,1,0)) AS tiga,
                                SUM(IF(b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=64,1,0)) AS empat, SUM(IF(b_kunjungan.umur_thn>=65,1,0)) AS lima,
                                SUM(IF(b_ms_pasien.sex='L',1,0)) AS L, SUM(IF(b_ms_pasien.sex='P',1,0)) AS P,
                                SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS hidup, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
                                FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id 
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE b_ms_diagnosa.kode LIKE 'F19%' $waktu $tahun AND b_pelayanan.unit_id='12'";
                        $rs19 = mysql_query($sql19);
                        $rw19 = mysql_fetch_array($rs19);
                    ?>
                    <td class=isi style="text-align:center;"><?php if($rw19['satu']=="" || $rw19['satu']==0) echo "&nbsp;"; else echo $rw19['satu'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['dua']=="" || $rw19['dua']==0) echo "&nbsp;"; else echo $rw19['dua'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['tiga']=="" || $rw19['tiga']==0) echo "&nbsp;"; else echo $rw19['tiga'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['empat']=="" || $rw19['empat']==0) echo "&nbsp;"; else echo $rw19['empat'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['lima']=="" || $rw19['lima']==0) echo "&nbsp;"; else echo $rw19['lima'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['L']=="" || $rw19['L']==0) echo "&nbsp;"; else echo $rw19['L'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['P']=="" || $rw19['P']==0) echo "&nbsp;"; else echo $rw19['P'];?></td>
                    <td class=isi style="text-align:center;"><?php if($rw19['hidup']=="" || $rw19['hidup']==0) echo "&nbsp;"; else echo $rw19['hidup'];?></td>
                    <td class=isiKn style="text-align:center;"><?php if($rw19['mati']=="" || $rw19['mati']==0) echo "&nbsp;"; else echo $rw19['mati'];?></td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>
		<td style="padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
</table>
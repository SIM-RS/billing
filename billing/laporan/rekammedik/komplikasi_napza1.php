<?
include("../../sesi.php");
?>
<?php
	include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
    $tribulan = $_POST['cmbTri'];
	$thn = $_POST['cmbThnTri'];
	if($tribulan==1){
		$tri = "januari - maret $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '01' AND '03') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==2){
		$tri = "april - juni $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '04' AND '06') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==3){
		$tri = "juli - september $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '07' AND '09') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}else if($tribulan==4){
		$tri = "oktober - desember $thn";
		$waktu = "AND (MONTH(b_diagnosa_rm.tgl) BETWEEN '10' AND '12') AND YEAR(b_diagnosa_rm.tgl)='$thn'";
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
    $rsUnit1 = mysql_query($sqlUnit1);
    $rwUnit1 = mysql_fetch_array($rsUnit1);

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);
?>
<style>
	.jdl{
		border-right:1px solid #FFFFFF;
		border-bottom:1px solid #FFFFFF;
		text-align:center;
		font-size:12px;
		font-weight:bold;
		height:30;
		text-transform:uppercase;
	}
	.isi{
		border-right:1px solid #FFCCFF;
		border-bottom:1px solid #FFCCFF;
	}
	.isiKn{
		border-bottom:1px solid #FFCCFF;
	}
</style>
<title>.: Komplikasi Akibat Penggunaan Napza :.</title>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td valign="top" height="70" style="text-transform:uppercase; font-weight:bold; font-size:14px; text-align:center;">komplikasi akibat penggunaan napza<br>penderita rawat jalan - <?php echo $rwUnit2['nama'];?><br><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
      <tr>
        <td rowspan="3" class="jdl" bgcolor="#00FF00">kode</td>
        <td rowspan="3" class="jdl" bgcolor="#00FF00">golongan<br>sebab sakit</td>
        <td colspan="5" class="jdl" bgcolor="#00FF00">kasus baru</td>
        <td class="jdl" bgcolor="#00FF00">sex</td>
        <td rowspan="3" class="jdl" bgcolor="#00FF00">jumlah<br>pasien</td>
        <td rowspan="3" class="jdl" bgcolor="#00FF00">jumlah<br>pasien<br>keluar</td>
        <td rowspan="3" class="jdl" bgcolor="#00FF00">jumlah<br>pasien<br>keluar mati</td>
      </tr>
      <tr>
        <td colspan="5" class="jdl" bgcolor="#00FF00">menurut golongan umur</td>
        <td rowspan="2" class="jdl" bgcolor="#FFCCFF">L<br>P</td>
        </tr>
      <tr>
        <td class="jdl" bgcolor="#FFCCFF">< 15 th</td>
        <td class="jdl" bgcolor="#FFCCFF">15-24 th</td>
        <td class="jdl" bgcolor="#FFCCFF">25-44 th</td>
        <td class="jdl" bgcolor="#FFCCFF">45-65 th</td>
        <td class="jdl" bgcolor="#FFCCFF">> 65 th</td>
        </tr>
		<?php
				$sql1 = "SELECT 
SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
WHERE b_pelayanan.unit_id_asal='12' $waktu
AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '148' AND '189') AND b_pasien_keluar.kasus='1'";
				$rs1 = mysql_query($sql1);
				$rw1 = mysql_fetch_array($rs1);
		?>
      <tr>
        <td width="6%" style="padding-left:10px;" height="30" class="isi">A.15 -<br>A.16</td>
        <td width="26%" style="padding-left:10px;" class="isi">Tuberkulosis</td>
        <td width="6%" class="isi" align="center"><?php if($rw1['satu']=="" || $rw1['satu']==0) echo "&nbsp;"; else echo $rw1['satu'];?></td>
        <td width="6%" class="isi" align="center"><?php if($rw1['dua']=="" || $rw1['dua']==0) echo "&nbsp;"; else echo $rw1['dua'];?></td>
        <td width="6%" class="isi" align="center"><?php if($rw1['tiga']=="" || $rw1['tiga']==0) echo "&nbsp;"; else echo $rw1['tiga'];?></td>
        <td width="6%" class="isi" align="center"><?php if($rw1['empat']=="" || $rw1['empat']==0) echo "&nbsp;"; else echo $rw1['empat'];?></td>
        <td width="6%" class="isi" align="center"><?php if($rw1['lima']=="" || $rw1['lima']==0) echo "&nbsp;"; else echo $rw1['lima'];?></td>
        <td width="8%" class="isi" align="center"><?php if($rw1['sex']=="" || $rw1['sex']==0) echo "&nbsp;"; else echo $rw1['sex'];?></td>
        <td width="10%" class="isi" align="center"><?php if($rw1['jml']=="" || $rw1['jml']==0) echo "&nbsp;"; else echo $rw1['jml'];?></td>
        <td width="10%" class="isi" align="center"><?php if($rw1['keluar']=="" || $rw1['keluar']==0) echo "&nbsp;"; else echo $rw1['keluar'];?></td>
        <td width="10%" class="isiKn" align="center"><?php if($rw1['mati']=="" || $rw1['mati']==0) echo "&nbsp;"; else echo $rw1['mati'];?></td>
      </tr>
		<?php
				$sql2 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '7280' AND '7285') AND b_pasien_keluar.kasus='1'";
				$rs2 = mysql_query($sql2);
				$rw2 = mysql_fetch_array($rs2);
		?>
      <tr>
        <td style="padding-left:10px;" height="30" class="isi">I.26</td>
        <td style="padding-left:10px;" class="isi">Emboli Paru</td>
        <td class="isi" align="center"><?php if($rw2['satu']=="" || $rw2['satu']==0) echo "&nbsp;"; else echo $rw2['satu'];?></td>
        <td class="isi" align="center"><?php if($rw2['dua']=="" || $rw2['dua']==0) echo "&nbsp;"; else echo $rw2['dua'];?></td>
        <td class="isi" align="center"><?php if($rw2['tiga']=="" || $rw2['tiga']==0) echo "&nbsp;"; else echo $rw2['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw2['empat']=="" || $rw2['empat']==0) echo "&nbsp;"; else echo $rw2['empat'];?></td>
        <td class="isi" align="center"><?php if($rw2['lima']=="" || $rw2['lima']==0) echo "&nbsp;"; else echo $rw2['lima'];?></td>
        <td class="isi" align="center"><?php if($rw2['sex']=="" || $rw2['sex']==0) echo "&nbsp;"; else echo $rw2['sex'];?></td>
        <td class="isi" align="center"><?php if($rw2['jml']=="" || $rw2['jml']==0) echo "&nbsp;"; else echo $rw2['jml'];?></td>
        <td class="isi" align="center"><?php if($rw2['keluar']=="" || $rw2['keluar']==0) echo "&nbsp;"; else echo $rw2['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw2['mati']=="" || $rw2['mati']==0) echo "&nbsp;"; else echo $rw2['mati'];?></td>
      </tr>
		<?php
				$sql3 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '8067' AND '8134') AND b_pasien_keluar.kasus='1'";
				$rs3 = mysql_query($sql3);
				$rw3 = mysql_fetch_array($rs3);
		?>
      <tr>
        <td style="padding-left:10px;" height="30" class="isi">J.12 -<br>J.18</td>
        <td style="padding-left:10px;" class="isi">Pneumonia</td>
        <td class="isi" align="center"><?php if($rw3['satu']=="" || $rw3['satu']==0) echo "&nbsp;"; else echo $rw3['satu'];?></td>
        <td class="isi" align="center"><?php if($rw3['dua']=="" || $rw3['dua']==0) echo "&nbsp;"; else echo $rw3['dua'];?></td>
        <td class="isi" align="center"><?php if($rw3['tiga']=="" || $rw3['tiga']==0) echo "&nbsp;"; else echo $rw3['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw3['empat']=="" || $rw3['empat']==0) echo "&nbsp;"; else echo $rw3['empat'];?></td>
        <td class="isi" align="center"><?php if($rw3['lima']=="" || $rw3['lima']==0) echo "&nbsp;"; else echo $rw3['lima'];?></td>
        <td class="isi" align="center"><?php if($rw3['sex']=="" || $rw3['sex']==0) echo "&nbsp;"; else echo $rw3['sex'];?></td>
        <td class="isi" align="center"><?php if($rw3['jml']=="" || $rw3['jml']==0) echo "&nbsp;"; else echo $rw3['jml'];?></td>
        <td class="isi" align="center"><?php if($rw3['keluar']=="" || $rw3['keluar']==0) echo "&nbsp;"; else echo $rw3['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw3['mati']=="" || $rw3['mati']==0) echo "&nbsp;"; else echo $rw3['mati'];?></td>
      </tr>
		<?php
				$sql4 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '8288' AND '8321') AND b_pasien_keluar.kasus='1'";
				$rs4 = mysql_query($sql4);
				$rw4 = mysql_fetch_array($rs4);
		?>
      <tr>
        <td style="padding-left:10px;" height="30" class="isi">J.40 -<br>J.44</td>
        <td style="padding-left:10px;" class="isi">Bronkitis, emfisema,<br>penyakit obstruksi kronik lainnya</td>
        <td class="isi" align="center"><?php if($rw4['satu']=="" || $rw4['satu']==0) echo "&nbsp;"; else echo $rw4['satu'];?></td>
        <td class="isi" align="center"><?php if($rw4['dua']=="" || $rw4['dua']==0) echo "&nbsp;"; else echo $rw4['dua'];?></td>
        <td class="isi" align="center"><?php if($rw4['tiga']=="" || $rw4['tiga']==0) echo "&nbsp;"; else echo $rw4['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw4['empat']=="" || $rw4['empat']==0) echo "&nbsp;"; else echo $rw4['empat'];?></td>
        <td class="isi" align="center"><?php if($rw4['lima']=="" || $rw4['lima']==0) echo "&nbsp;"; else echo $rw4['lima'];?></td>
        <td class="isi" align="center"><?php if($rw4['sex']=="" || $rw4['sex']==0) echo "&nbsp;"; else echo $rw4['sex'];?></td>
        <td class="isi" align="center"><?php if($rw4['jml']=="" || $rw4['jml']==0) echo "&nbsp;"; else echo $rw4['jml'];?></td>
        <td class="isi" align="center"><?php if($rw4['keluar']=="" || $rw4['keluar']==0) echo "&nbsp;"; else echo $rw4['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw4['mati']=="" || $rw4['mati']==0) echo "&nbsp;"; else echo $rw4['mati'];?></td>
      </tr>
		<?php
				$sql5 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '8322' AND '8333') AND b_pasien_keluar.kasus='1'";
				$rs5 = mysql_query($sql5);
				$rw5 = mysql_fetch_array($rs5);
		?>
      <tr>
        <td height="30" style="padding-left:10px" class="isi">J.45 -<br>J.46</td>
        <td style="padding-left:10px;" class="isi">Asma</td>
        <td class="isi" align="center"><?php if($rw5['satu']=="" || $rw5['satu']==0) echo "&nbsp;"; else echo $rw5['satu'];?></td>
        <td class="isi" align="center"><?php if($rw5['dua']=="" || $rw5['dua']==0) echo "&nbsp;"; else echo $rw5['dua'];?></td>
        <td class="isi" align="center"><?php if($rw5['tiga']=="" || $rw5['tiga']==0) echo "&nbsp;"; else echo $rw5['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw5['empat']=="" || $rw5['empat']==0) echo "&nbsp;"; else echo $rw5['empat'];?></td>
        <td class="isi" align="center"><?php if($rw5['lima']=="" || $rw5['lima']==0) echo "&nbsp;"; else echo $rw5['lima'];?></td>
        <td class="isi" align="center"><?php if($rw5['sex']=="" || $rw5['sex']==0) echo "&nbsp;"; else echo $rw5['sex'];?></td>
        <td class="isi" align="center"><?php if($rw5['jml']=="" || $rw5['jml']==0) echo "&nbsp;"; else echo $rw5['jml'];?></td>
        <td class="isi" align="center"><?php if($rw5['keluar']=="" || $rw5['keluar']==0) echo "&nbsp;"; else echo $rw5['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw5['mati']=="" || $rw5['mati']==0) echo "&nbsp;"; else echo $rw5['mati'];?></td>
      </tr>
		<?php
				$sql6 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '1043' AND '1086') AND b_pasien_keluar.kasus='1'";
				$rs6 = mysql_query($sql6);
				$rw6 = mysql_fetch_array($rs6);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">B.16<br>B.17<br>B.18<br>B.19</td>
        <td style="padding-left:10px;" class="isi">Hepatitis</td>
        <td class="isi" align="center"><?php if($rw6['satu']=="" || $rw6['satu']==0) echo "&nbsp;"; else echo $rw6['satu'];?></td>
        <td class="isi" align="center"><?php if($rw6['dua']=="" || $rw6['dua']==0) echo "&nbsp;"; else echo $rw6['dua'];?></td>
        <td class="isi" align="center"><?php if($rw6['tiga']=="" || $rw6['tiga']==0) echo "&nbsp;"; else echo $rw6['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw6['empat']=="" || $rw6['empat']==0) echo "&nbsp;"; else echo $rw6['empat'];?></td>
        <td class="isi" align="center"><?php if($rw6['lima']=="" || $rw6['lima']==0) echo "&nbsp;"; else echo $rw6['lima'];?></td>
        <td class="isi" align="center"><?php if($rw6['sex']=="" || $rw6['sex']==0) echo "&nbsp;"; else echo $rw6['sex'];?></td>
        <td class="isi" align="center"><?php if($rw6['jml']=="" || $rw6['jml']==0) echo "&nbsp;"; else echo $rw6['jml'];?></td>
        <td class="isi" align="center"><?php if($rw6['keluar']=="" || $rw6['keluar']==0) echo "&nbsp;"; else echo $rw6['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw6['mati']=="" || $rw6['mati']==0) echo "&nbsp;"; else echo $rw6['mati'];?></td>
      </tr>
		<?php
				$sql7 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '1087' AND '1146') AND b_pasien_keluar.kasus='1'";
				$rs7 = mysql_query($sql7);
				$rw7 = mysql_fetch_array($rs7);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">B.20<br>B.24</td>
        <td style="padding-left:10px;" class="isi">HIV/AIDS</td>
        <td class="isi" align="center"><?php if($rw7['satu']=="" || $rw7['satu']==0) echo "&nbsp;"; else echo $rw7['satu'];?></td>
        <td class="isi" align="center"><?php if($rw7['dua']=="" || $rw7['dua']==0) echo "&nbsp;"; else echo $rw7['dua'];?></td>
        <td class="isi" align="center"><?php if($rw7['tiga']=="" || $rw7['tiga']==0) echo "&nbsp;"; else echo $rw7['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw7['empat']=="" || $rw7['empat']==0) echo "&nbsp;"; else echo $rw7['empat'];?></td>
        <td class="isi" align="center"><?php if($rw7['lima']=="" || $rw7['lima']==0) echo "&nbsp;"; else echo $rw7['lima'];?></td>
        <td class="isi" align="center"><?php if($rw7['sex']=="" || $rw7['sex']==0) echo "&nbsp;"; else echo $rw7['sex'];?></td>
        <td class="isi" align="center"><?php if($rw7['jml']=="" || $rw7['jml']==0) echo "&nbsp;"; else echo $rw7['jml'];?></td>
        <td class="isi" align="center"><?php if($rw7['keluar']=="" || $rw7['keluar']==0) echo "&nbsp;"; else echo $rw7['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw7['mati']=="" || $rw7['mati']==0) echo "&nbsp;"; else echo $rw7['mati'];?></td>
      </tr>
		<?php
				$sql8 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '12403' AND '12454') AND b_pasien_keluar.kasus='1'";
				$rs8 = mysql_query($sql8);
				$rw8 = mysql_fetch_array($rs8);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">O.03</td>
        <td style="padding-left:10px;" class="isi">Abortus</td>
        <td class="isi" align="center"><?php if($rw8['satu']=="" || $rw8['satu']==0) echo "&nbsp;"; else echo $rw8['satu'];?></td>
        <td class="isi" align="center"><?php if($rw8['dua']=="" || $rw8['dua']==0) echo "&nbsp;"; else echo $rw8['dua'];?></td>
        <td class="isi" align="center"><?php if($rw8['tiga']=="" || $rw8['tiga']==0) echo "&nbsp;"; else echo $rw8['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw8['empat']=="" || $rw8['empat']==0) echo "&nbsp;"; else echo $rw8['empat'];?></td>
        <td class="isi" align="center"><?php if($rw8['lima']=="" || $rw8['lima']==0) echo "&nbsp;"; else echo $rw8['lima'];?></td>
        <td class="isi" align="center"><?php if($rw8['sex']=="" || $rw8['sex']==0) echo "&nbsp;"; else echo $rw8['sex'];?></td>
        <td class="isi" align="center"><?php if($rw8['jml']=="" || $rw8['jml']==0) echo "&nbsp;"; else echo $rw8['jml'];?></td>
        <td class="isi" align="center"><?php if($rw8['keluar']=="" || $rw8['keluar']==0) echo "&nbsp;"; else echo $rw8['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw8['mati']=="" || $rw8['mati']==0) echo "&nbsp;"; else echo $rw8['mati'];?></td>
      </tr>
		<?php
				$sql9 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '12834' AND '12835') AND b_pasien_keluar.kasus='1'";
				$rs9 = mysql_query($sql9);
				$rw9 = mysql_fetch_array($rs9);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">O.60</td>
        <td style="padding-left:10px;" class="isi">Prematuritas</td>
        <td class="isi" align="center"><?php if($rw9['satu']=="" || $rw9['satu']==0) echo "&nbsp;"; else echo $rw9['satu'];?></td>
        <td class="isi" align="center"><?php if($rw9['dua']=="" || $rw9['dua']==0) echo "&nbsp;"; else echo $rw9['dua'];?></td>
        <td class="isi" align="center"><?php if($rw9['tiga']=="" || $rw9['tiga']==0) echo "&nbsp;"; else echo $rw9['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw9['empat']=="" || $rw9['empat']==0) echo "&nbsp;"; else echo $rw9['empat'];?></td>
        <td class="isi" align="center"><?php if($rw9['lima']=="" || $rw9['lima']==0) echo "&nbsp;"; else echo $rw9['lima'];?></td>
        <td class="isi" align="center"><?php if($rw9['sex']=="" || $rw9['sex']==0) echo "&nbsp;"; else echo $rw9['sex'];?></td>
        <td class="isi" align="center"><?php if($rw9['jml']=="" || $rw9['jml']==0) echo "&nbsp;"; else echo $rw9['jml'];?></td>
        <td class="isi" align="center"><?php if($rw9['keluar']=="" || $rw9['keluar']==0) echo "&nbsp;"; else echo $rw9['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw9['mati']=="" || $rw9['mati']==0) echo "&nbsp;"; else echo $rw9['mati'];?></td>
      </tr>
		<?php
				$sql10 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '12493' AND '12502') AND b_pasien_keluar.kasus='1'";
				$rs10 = mysql_query($sql10);
				$rw10 = mysql_fetch_array($rs10);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">O.15</td>
        <td style="padding-left:10px;" class="isi">Eklamsia</td>
        <td class="isi" align="center"><?php if($rw10['satu']=="" || $rw10['satu']==0) echo "&nbsp;"; else echo $rw10['satu'];?></td>
        <td class="isi" align="center"><?php if($rw10['dua']=="" || $rw10['dua']==0) echo "&nbsp;"; else echo $rw10['dua'];?></td>
        <td class="isi" align="center"><?php if($rw10['tiga']=="" || $rw10['tiga']==0) echo "&nbsp;"; else echo $rw10['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw10['empat']=="" || $rw10['empat']==0) echo "&nbsp;"; else echo $rw10['empat'];?></td>
        <td class="isi" align="center"><?php if($rw10['lima']=="" || $rw10['lima']==0) echo "&nbsp;"; else echo $rw10['lima'];?></td>
        <td class="isi" align="center"><?php if($rw10['sex']=="" || $rw10['sex']==0) echo "&nbsp;"; else echo $rw10['sex'];?></td>
        <td class="isi" align="center"><?php if($rw10['jml']=="" || $rw10['jml']==0) echo "&nbsp;"; else echo $rw10['jml'];?></td>
        <td class="isi" align="center"><?php if($rw10['keluar']=="" || $rw10['keluar']==0) echo "&nbsp;"; else echo $rw10['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw10['mati']=="" || $rw10['mati']==0) echo "&nbsp;"; else echo $rw10['mati'];?></td>
      </tr>
		<?php
				$sql11 = "SELECT 
	SUM(IF(b_kunjungan.umur_thn<15,1,0)) AS satu, SUM(IF(b_kunjungan.umur_thn BETWEEN '15' AND '24',1,0)) AS dua,
	SUM(IF(b_kunjungan.umur_thn BETWEEN '25' AND '44',1,0)) AS tiga, SUM(IF(b_kunjungan.umur_thn BETWEEN '45' AND '65',1,0)) AS empat,
	SUM(IF(b_kunjungan.umur_thn>65,1,0)) AS lima, COUNT(b_pelayanan.id) AS sex, COUNT(b_diagnosa_rm.pelayanan_id) AS jml,
	SUM(IF(b_pasien_keluar.cara_keluar<>'Meninggal',1,0)) AS keluar, SUM(IF(b_pasien_keluar.cara_keluar='Meninggal',1,0)) AS mati
	FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
	INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
	WHERE b_pelayanan.unit_id_asal='12' $waktu
	AND (b_diagnosa_rm.ms_diagnosa_id BETWEEN '13380' AND '13399') AND b_pasien_keluar.kasus='1'";
				$rs11 = mysql_query($sql11);
				$rw11 = mysql_fetch_array($rs11);
		?>
      <tr>
        <td height="30" style="padding-left:10px;" class="isi">P.05 -<br>P.07</td>
        <td style="padding-left:10px;" class="isi">Pertumbuhan janin terhambat <br>dan bayi berat lahir < 2500 gr</td>
        <td class="isi" align="center"><?php if($rw11['satu']=="" || $rw11['satu']==0) echo "&nbsp;"; else echo $rw11['satu'];?></td>
        <td class="isi" align="center"><?php if($rw11['dua']=="" || $rw11['dua']==0) echo "&nbsp;"; else echo $rw11['dua'];?></td>
        <td class="isi" align="center"><?php if($rw11['tiga']=="" || $rw11['tiga']==0) echo "&nbsp;"; else echo $rw11['tiga'];?></td>
        <td class="isi" align="center"><?php if($rw11['empat']=="" || $rw11['empat']==0) echo "&nbsp;"; else echo $rw11['empat'];?></td>
        <td class="isi" align="center"><?php if($rw11['lima']=="" || $rw11['lima']==0) echo "&nbsp;"; else echo $rw11['lima'];?></td>
        <td class="isi" align="center"><?php if($rw11['sex']=="" || $rw11['sex']==0) echo "&nbsp;"; else echo $rw11['sex'];?></td>
        <td class="isi" align="center"><?php if($rw11['jml']=="" || $rw11['jml']==0) echo "&nbsp;"; else echo $rw11['jml'];?></td>
        <td class="isi" align="center"><?php if($rw11['keluar']=="" || $rw11['keluar']==0) echo "&nbsp;"; else echo $rw11['keluar'];?></td>
        <td class="isiKn" align="center"><?php if($rw11['mati']=="" || $rw11['mati']==0) echo "&nbsp;"; else echo $rw11['mati'];?></td>      </tr>
      <tr>
        <td colspan="2" style="text-align:center;" height="28" class="isi"><b>JUMLAH</b></td>
        <td class="isi" align="center"><?php echo $rw1['satu']+$rw2['satu']+$rw3['satu']+$rw4['satu']+$rw5['satu']+$rw6['satu']+$rw7['satu']+$rw8['satu']+$rw9['satu']+$rw10['satu']+$rw11['satu'];?></td>
        <td class="isi" align="center"><?php echo $rw1['dua']+$rw2['dua']+$rw3['dua']+$rw4['dua']+$rw5['dua']+$rw6['dua']+$rw7['dua']+$rw8['dua']+$rw9['dua']+$rw10['dua']+$rw11['dua'];?></td>
        <td class="isi" align="center"><?php echo $rw1['tiga']+$rw2['tiga']+$rw3['tiga']+$rw4['tiga']+$rw5['tiga']+$rw6['tiga']+$rw7['tiga']+$rw8['tiga']+$rw9['tiga']+$rw10['tiga']+$rw11['tiga'];?></td>
        <td class="isi" align="center"><?php echo $rw1['empat']+$rw2['empat']+$rw3['empat']+$rw4['empat']+$rw5['empat']+$rw6['empat']+$rw7['empat']+$rw8['empat']+$rw9['empat']+$rw10['empat']+$rw11['empat'];?></td>
        <td class="isi" align="center"><?php echo $rw1['lima']+$rw2['lima']+$rw3['lima']+$rw4['lima']+$rw5['lima']+$rw6['lima']+$rw7['lima']+$rw8['lima']+$rw9['lima']+$rw10['lima']+$rw11['lima'];?></td>
        <td class="isi" align="center"><?php echo $rw1['sex']+$rw2['sex']+$rw3['sex']+$rw4['sex']+$rw5['sex']+$rw6['sex']+$rw7['sex']+$rw8['sex']+$rw9['sex']+$rw10['sex']+$rw11['sex'];?></td>
        <td class="isi" align="center"><?php echo $rw1['jml']+$rw2['jml']+$rw3['jml']+$rw4['jml']+$rw5['jml']+$rw6['jml']+$rw7['jml']+$rw8['jml']+$rw9['jml']+$rw10['jml']+$rw11['jml'];?></td>
        <td class="isi" align="center"><?php echo $rw1['keluar']+$rw2['keluar']+$rw3['keluar']+$rw4['keluar']+$rw5['keluar']+$rw6['keluar']+$rw7['keluar']+$rw8['keluar']+$rw9['keluar']+$rw10['keluar']+$rw11['keluar'];?></td>
        <td class="isiKn" align="center"><?php echo $rw1['mati']+$rw2['mati']+$rw3['mati']+$rw4['mati']+$rw5['mati']+$rw6['mati']+$rw7['mati']+$rw8['mati']+$rw9['mati']+$rw10['mati']+$rw11['mati'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

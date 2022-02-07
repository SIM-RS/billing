<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
//$idUser=$_REQUEST['idUser'];
$dokter_id = $_REQUEST['dokter_id'];
$sqlPas="SELECT mp.nama nmPas,no_rm,mp.sex,k.umur_thn,k.umur_bln,ma.agama,mp.alamat,mk.nama pekerjaan,mp.alamat_ortu,mp.nama_ortu,bmk.nama,mp.telp,bmp.nama pend FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_kamar bmk ON tk.kamar_id=bmk.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_ms_pendidikan bmp ON k.pendidikan_id=bmp.id INNER JOIN b_ms_pekerjaan mk ON mp.pekerjaan_id=mk.id INNER JOIN b_ms_agama ma ON mp.agama=ma.id WHERE k.id=$idKunj group by k.id";
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rwPas=mysql_fetch_array($qPas);
$qUser=mysql_query("SELECT nama from b_ms_pegawai where id='$dokter_id'");
$rwUser=mysql_fetch_array($qUser);
$dokter=$rwUser['nama'];
if ($dokter=="") $dokter="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$sql="SELECT md.kode,md.nama FROM b_diagnosa d INNER JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id WHERE d.kunjungan_id=$idKunj";
$rs=mysql_query($sql);
$diag="";
while ($rwDiag=mysql_fetch_array($rs)){
	$diag .=$rwDiag['kode']." - ".$rwDiag['nama']."<br>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Surat Perintah Rawat Inap :.</title>
</head>

<body>
<table align="left" width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="70" colspan="3" align="center" style="font-weight:bold; font-size:20px; border-bottom:#000000 2px solid">SURAT PERINTAH RAWAT INAP<br/><?=$namaRS?></td>
  </tr>
  <tr>
    <td width="250">Nama Pasien</td>
    <td width="319">:&nbsp;<?php echo $rwPas['nmPas'];?> </td>
    <td width="351">No. RM&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $rwPas['no_rm'];?></td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td>:&nbsp;<?php echo $rwPas['sex'];?></td>
    <td>Umur&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $rwPas['umur_thn']." Th ".$rwPas['umur_bln']." Bln";?></td>
  </tr>
  <tr>
    <td>Agama</td>
    <td colspan="2">:&nbsp;<?php echo $rwPas['agama'];?><span style="margin-left:140px">Pendidikan&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $rwPas['pend']?></span><span style="margin-left:140px">Pekerjaan&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $rwPas['pekerjaan']?></span></td>
  </tr>
  <tr>
  	<td>Alamat</td>
  	<td colspan="2">:&nbsp;<?php echo $rwPas['alamat'];?></td>
  </tr>
  <tr>
  	<td>Diagnose</td>
  	<td colspan="2">:&nbsp;<?php echo $diag;?></td>
  </tr>
  <tr>
  	<td>Ruang</td>
  	<td colspan="2">:&nbsp;<?php echo $rwPas['nama'];?></td>
  </tr>
  <tr>
  	<td>Nama Penanggung Jawab / Keluarga</td>
  	<td colspan="2">:&nbsp;<?php echo $rwPas['nama_ortu'];?></td>
  </tr>
  <tr>
  	<td>Alamat</td>
  	<td colspan="2">:&nbsp;<?php echo $rwPas['alamat_ortu'];?></td>
  </tr>
  <tr>
  	<td>No Telp</td>
  	<td colspan="2">:&nbsp;<?php echo $rwPas['telp'];?></td>
  </tr>
  <tr>
  	<td colspan="3" align="right"><?=$kotaRS?>, <?php echo gmdate('d-m-Y',mktime(date('H')+7));?><br/>Dokter Pengirim<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $dokter;?> )</td>
  </tr>
<tr id="trTombol">
    <td colspan="3" class="noline" align="center">
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
    </td>
</tr>
</table>
<script type="text/JavaScript">

	function cetak(tombol){
		tombol.style.visibility='collapse';
		if(tombol.style.visibility=='collapse'){
			if(confirm('Anda Yakin Mau Mencetak Surat Perintah Inap ?')){
				setTimeout('window.print()','1000');
				setTimeout('window.close()','2000');
			}
			else{
				tombol.style.visibility='visible';
			}

		}
	}
</script>
</body>
</html>
<?php 
mysql_close($konek);
?>
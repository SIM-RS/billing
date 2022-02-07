<?php
session_start();
include("../sesi.php");
?>
<?php
include("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
//$idUser=$_REQUEST['idUser'];
$dokter_id = $_REQUEST['dokter_id'];
$getIdPel = $_REQUEST['getIdPel'];
$sqlPas="SELECT mp.nama nmPas,no_rm,mp.sex,k.umur_thn,k.umur_bln,ma.agama,mp.alamat,mk.nama pekerjaan,mp.alamat_ortu,mp.nama_ortu,bmk.nama,mp.telp,bmp.nama pend,li.nama pj,li.alamat almtpj,
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) kec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kab_id) kab, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.prop_id) prop
FROM
  b_pelayanan p 
  INNER JOIN b_kunjungan k 
    ON p.kunjungan_id = k.id 
  LEFT JOIN b_tindakan_kamar tk 
    ON p.id = tk.pelayanan_id 
  LEFT JOIN b_ms_kamar bmk 
    ON tk.kamar_id = bmk.id 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pendidikan bmp 
    ON k.pendidikan_id = bmp.id 
  LEFT JOIN b_ms_pekerjaan mk 
    ON mp.pekerjaan_id = mk.id 
  LEFT JOIN b_ms_agama ma 
    ON mp.agama = ma.id 
  LEFT JOIN lap_inform_konsen li
  	ON li.pelayanan_id = p.id and li.kunjungan_id = p.kunjungan_id
WHERE k.id=$idKunj group by k.id";
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
	//$diag .=$rwDiag['kode']." - ".$rwDiag['nama']."<br>";
	$diag .=$rwDiag['nama']."<br>";
}

$sql="SELECT d.diagnosa_manual as nama FROM b_diagnosa d WHERE d.kunjungan_id=$idKunj AND d.diagnosa_manual IS NOT NULL";
$rs=mysql_query($sql);
//$diag="";
while ($rwDiag=mysql_fetch_array($rs)){
	//$diag .=$rwDiag['kode']." - ".$rwDiag['nama']."<br>";
	$diag .=$rwDiag['nama']."<br>";
}
$qinfkon = "SELECT * FROM lap_inform_konsen WHERE kunjungan_id = $idKunj ORDER BY id DESC LIMIT 1";
$dqinfkon = mysql_fetch_array(mysql_query($qinfkon));

$queryK = "SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='$getIdPel'";
$dqueryK = mysql_fetch_array(mysql_query($queryK));

$qnmK = "SELECT * FROM b_ms_kamar WHERE id = $dqueryK[kamar_id]";
$dqnmK = mysql_fetch_array(mysql_query($qnmK));
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
    <td height="70" colspan="7" align="center" style="font-weight:bold; font-size:20px; border-bottom:#000000 2px solid">SURAT PERINTAH RAWAT INAP<br/><?=$namaRS?></td>
  </tr>
  <tr>
    <td width="243">Nama Pasien</td>
    <td colspan="3">:&nbsp;<?php echo $rwPas['nmPas'];?> </td>
    <td width="87"><span style="margin-left:10px">No. RM&nbsp;&nbsp;</span></td>
    <td width="141"><span style="margin-left:10px">:&nbsp;&nbsp;<?php echo $rwPas['no_rm'];?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td colspan="3">:&nbsp;<?php echo $rwPas['sex'];?></td>
    <td><span style="margin-left:10px">Umur&nbsp;</span></td>
    <td><span style="margin-left:10px">:&nbsp;&nbsp;<?php echo $rwPas['umur_thn']." Th ".$rwPas['umur_bln']." Bln";?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Agama</td>
    <td colspan="2">:&nbsp;<?php echo $rwPas['agama'];?></td>
    <td width="192">&nbsp;</td>
    <td valign="middle"><span style="margin-left:0px"><span style="margin-left:10px">Pendidikan&nbsp;&nbsp;</span></span></td>
    <td colspan="2" valign="middle"><span style="margin-left:10px">:&nbsp;&nbsp;<?php echo $rwPas['pend']?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="12">&nbsp;</td>
    <td>&nbsp;</td>
    <td><span style="margin-left:10px">Pekerjaan&nbsp;&nbsp;</span></td>
    <td colspan="2"><span style="margin-left:10px">:&nbsp;&nbsp;<?php echo $rwPas['pekerjaan']?></span></td>
  </tr>
  <tr>
  	<td>Alamat</td>
  	<td colspan="6">:&nbsp;<?php echo $rwPas['alamat']." desa ".strtolower($rwPas["desa"])." kec. ".strtolower($rwPas["kec"])." kab. ".strtolower($rwPas["kab"]);?></td>
  </tr>
  <tr>
  	<td valign="top">Diagnose</td>
  	<td width="15" valign="top">:&nbsp;</td>
  	<td colspan="3"><?php echo $diag;?></td>
  	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<td>Ruang</td>
  	<td colspan="6">:&nbsp;<?php echo $dqnmK['nama'];?></td>
  </tr>
  <tr>
  	<td>Nama Penanggung Jawab / Keluarga</td>
  	<td colspan="6">:&nbsp;<?php echo $dqinfkon['nama'];?></td>
  </tr>
  <tr>
  	<td>Alamat</td>
  	<td colspan="6">:&nbsp;<?php echo $dqinfkon['alamat'];?></td>
  </tr>
  <tr>
  	<td>No Telp</td>
  	<td colspan="6">:&nbsp;<?php echo $dqinfkon['telp'];?></td>
  </tr>
  <tr>
  	<td align="right">&nbsp;</td>
  	<td align="right">&nbsp;</td>
  	<td colspan="4" align="right">&nbsp;</td>
  	<td width="210" align="center"><?=$kotaRS?>
  	  , <?php echo gmdate('d-m-Y',mktime(date('H')+7));?><br/>
  	  Dokter Pengirim<br/>
  &nbsp;<br/>
  &nbsp;<br/>
  &nbsp;<br/>
    ( <?php echo $dokter;?> )</td>
  </tr>
<tr id="trTombol">
    <td colspan="7" class="noline" align="center">
        <!--input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/-->
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
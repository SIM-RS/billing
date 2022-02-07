<?php 
include '../sesi.php';
include '../koneksi/konek.php'; 
 session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
?>
<?php  include("../header.php"); 
$act = $_POST['act'];
$id = $_GET["id"];
$unit=$_POST['unit'];
$seri=$_POST['seri'];
$brg=$_POST['brg'];
$lokasi=$_POST['lokasi'];
$kode_tanah=$_POST['kode_tanah'];
$kons=$_POST['kons'];
$panjang=$_POST['panjang'];
$lebar=$_POST['lebar'];
$luas=$_POST['luas'];
$alamat=$_POST['alamat'];
$tglsert=$_POST['tglsert'];
$tglsert=explode('-',$tglsert);
$tglsert=$tglsert[2]."-".$tglsert[1]."-".$tglsert['0'];
$no=$_POST['no'];
$ket=$_POST['ket'];
$stt=$_POST['stt'];
$kond=$_POST['kond'];
switch($act) {
    case 'edit':
      $sql = "INSERT INTO as_seri2 (idbarang,ms_idunit,ms_idlokasi,noseri,kondisi)VALUES()";
	  $sql = "";
		mysql_query($sql);
		echo "<script>location='anggota.php';</script>";
		//echo $sql;
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<title>.: Janalan Irigasi :.</title>
</head>

<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<script language="javascript">
   var arrRange=depRange=[];
</script>
<div align="center">
<table width="1000" align="center" bgcolor="#FFFBF0">
<tr>
	<td colspan="2" align="center" style="font-size:large">.: Form Insert :.</td>
</tr>
<tr>
	<td colspan="2"  align="center"><input name="act" id="act" type="hidden" value="add"></td>
</tr>
<tr>
<td align="center">
<table width="700" align="center" cellpadding="3" cellspacing="0" class="tabel" >
 <tr>
	<td colspan="2" class="header">.: Kartu Inventaris Barang : Tanah - Detail :.</td>
</tr>
<tr>
	<td width="180" class="label">Unit</td>
	<td width="484" class="label"><select id="unit" name="unit" class="txt">
		<?php 
		$query=mysql_query("SELECT idunit, namaunit FROM as_ms_unit ORDER BY namaunit");
		while($rw=mysql_fetch_array($query)){
		?>
		<option value="<?php echo $rw['idunit'] ?>"<?php if($unit==$rw['idunit']) echo 'selected' ?>><?php echo $rw['namaunit'] ?></option>
		<?php } ?>
		</select>
	</td>
</tr>
<tr>
	<td class="label">Kode Barang - Seri</td>
	<td class="label"><input type="text" id="seri" name="seri" class="txt" size="10"/></td>
</tr>
<tr>
	<td class="label">Nama Barang</td>
	<td class="label"><select id="brg" name="brg" class="txt">
	<?php 
	$sql="select idbarang, namabarang from as_ms_barang where kodebarang like '%04%' order by namabarang";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
	?>
	<option value="<?php echo $row['idbarang'] ?>"<?php if($brg==$row['idbarang']) echo'selected' ?>><?php echo $row['namabarang'] ?></option>
	<?php
	}
	?>
	</select>
	</td>
</tr>
<tr>
	<td class="label">Lokasi</td>
	<td class="label"><select id="lokasi" name="lokasi" class="txt">
		<?php 
		$sql="select idlokasi,namalokasi from as_lokasi order by namalokasi";
		$rs=mysql_query($sql);
		while($row=mysql_fetch_array($rs)){
		?>
		<option value="<?php echo $row['idlokasi'] ?>"<?php if($lokasi==$row['idlokasi']) echo 'selected'?>><?php echo $row['namalokasi'] ?></option>
		<?php } ?>
		</select></td>
</tr>
<tr>
	<td class="label">Kode Tanah</td>
	<td class="label"><input type="text" id="kode_tanah" name="kode_tanah" size="20" class="txt" /></td>
</tr>
<tr>
	<td class="label">Kontruksi</td>
	<td class="label"><input type="text" id="kons" name="kons" class="txt" size="30" /></td>
</tr>
<tr>
	<td class="label">Panjang</td>
	<td class="label"><input type="text" id="panjang" name="panjang" size="20" class="txt" /></td>
</tr>
<tr>
	<td class="label">Lebar</td>
	<td class="label"><input type="text" id="lebar" name="lebar" size="20" class="txt" /></td>
</tr>
<tr>
	<td class="label">Luas</td>
	<td class="label"><input type="text" id="luas" name="luas" size="20" class="txt"></td>
</tr>
<tr>
	<td class="label">Alamat</td>
	<td class="label"><input type="text" id="alamat" name="alamat" size="50" class="txt" /></td>
</tr>
<tr>
	<td class="label">Tanggal Document</td>
	<td class="label">
	<input type="text" id="tglsert" name="tglsert" class="txt" size="20" value="<?php echo date("d-m-Y"); ?>">
	<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglsert'),depRange);" />	
	<font color="#666666"><em>(dd-mm-yyyy)</em></font> 
	</td>
</tr>
<tr>
	<td class="label">No Document</td>
	<td class="label"><input type="text" id="no" name="no" class="txt" size="20" /></td>
</tr>
<tr>
	<td class="label">Keterangan</td>
	<td class="label"><input type="text" id="ket" name="ket" size="50" class="txt" /></td>
</tr>
<tr>
	<td class="label">Status Tanah</td>
	<td class="label"><select id="stt" name="stt" class="txt">
	
	</select></td>
</tr>
<tr>
	<td class="label" colspan="2" align="center"><input type="submit" id="simpan" name="simpan" value="Simpan"/>&nbsp;<input type="submit" id="batal" name="batal" value="Batal" /> </td>
</tr>
</table>
</td>
</tr>
<tr>
<td><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
</tr>
</table><br />

</div>

</body>
</html>

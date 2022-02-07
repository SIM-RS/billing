<?php 
include '../sesi.php';
include '../koneksi/konek.php'; 
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
?>
<?php  include("../header.php"); 
//=============================================================
$id=$_GET['id'];
$act=$_POST['act'];
$brg=$_POST['idbarang'];
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
$seri=$_POST['noseri'];
$kond=$_POST['kond'];
//=====================Aksi Update====================================
switch($act) {
   case 'edit':
   $sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Jalan,Irigasi & Jaringan','UPDATE as_seri2 SET idbarang=$brg, noseri=$seri, kondisi=$kond WHERE idseri=$id','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
  $sql1="UPDATE as_seri2 SET idbarang='$brg', noseri='$seri', kondisi='$kond' WHERE idseri='$id' ";
  $rs=mysql_query($sql1);
  
   $sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Jalan,Irigasi & Jaringan','UPDATE kib04 SET idseri=$id,konstruksi=$kons, panjang=$panjang, lebar=$lebar, luas=$luas, alamat=$alamat, dok_tgl=$tglsert, dok_no=$no, status_tanah=$stt, kode_tanah=$kode_tanah, ket=$ket WHERE idseri=$id','".$_SERVER['REMOTE_ADDR']."')";
   mysql_query($sqlIns1);
   
  $sql2="UPDATE kib04 SET idseri='$id',konstruksi='$kons', panjang='$panjang', lebar='$lebar', luas='$luas', alamat='$alamat', dok_tgl='$tglsert', dok_no='$no', status_tanah='$stt', kode_tanah='$kode_tanah', ket='$ket' WHERE idseri='$id'"; 
  $rs=mysql_query($sql2);
		if($rs!=mysql_error()){
        
        echo "<script>alert('Data Telah Diubah');</script>";
		echo "<script>location='jln_irigasi_data.php'</script>";
	}else{
		echo "<script>alert('Terdapat Kesalahan Dalam Mengubah Data Silahkan Ulangi Lagi');</script>";
	}
        break;
}
$sqlselect="SELECT s.idseri,namabarang,kodebarang,ms_idunit,kodeunit,namaunit,ms_idlokasi,s.idbarang,noseri,kode_tanah,panjang,lebar,k.luas,alamat,konstruksi,dok_tgl,dok_no,kondisi,ket,status_tanah FROM as_seri2 s
  LEFT JOIN kib04 k
    ON s.idseri = k.idseri
  INNER JOIN as_ms_barang b
    ON s.idbarang = b.idbarang
  LEFT JOIN as_lokasi l
    ON s.ms_idlokasi = l.idlokasi
  LEFT JOIN as_ms_unit u
    ON s.ms_idunit = u.idunit
   WHERE s.idseri=$id ";
   $rs=mysql_query($sqlselect);
   $row=mysql_fetch_array($rs);
  	$id=$row['idseri'];
	$unit=$row['ms_idunit'];
	$kodeunit=$row['kodeunit'];
	$namaunit=$row['namaunit'];
	$lokasi=$row['ms_idlokasi'];
	$nmbrg=$row['namabarang'];
	$brg=$row['idbarang'];
	$seri=$row['noseri'];
	 $kodeBrg=$row['kodebarang'];
	$kode_tanah=$row['kode_tanah'];
	$panjang=$row['panjang'];
	$lebar=$row['lebar'];
	$luas=$row['luas'];
	$alamat=$row['alamat'];
	$kons=$row['konstruksi'];
	$tgl=$row['dok_tgl'];
	$no=$row['dok_no'];
	$kond=$row['kondisi'];
	$ket=$row['ket'];
	$stt=$row['status_tanah'];
	$noseri=$row['noseri'];
//======================================================
if(isset($_GET['batal'])){
echo "<script>document.location='jln_irigasi_data.php';</script>";
}	
//==================================================================================
?>
<?php
$barang_opener="par=idbarang*kodebarang*namabarang";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<title>.: Update Data :.</title>
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
<form action="" method="post" name="form1" >
<table width="1000" align="center" bgcolor="#FFFBF0">
<tr>
	<td colspan="2" align="center" style="font-size:large">.: Form Update :.</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="hidden" id="act" name="act" value="edit" /><input type="hidden" id="id" name="id" value="<?php echo $id ?>" /></td>
</tr>
<tr>
<td align="center">
<table width="700" align="center" cellpadding="6" cellspacing="0" class="tabel" >
 <tr>
	<td colspan="2" class="header">.: Kartu Inventaris Barang : Jalan, Irigasi &amp; Jaringan :.</td>
</tr>
<tr>
	<td width="180" class="label">Unit</td>
	<td width="484" class="label"><input type="text" id="unit" name="unit" class="txt" size="15" readonly value="<?php echo $kodeunit ?>">&nbsp;- &nbsp;<input type="text" id="namaunit" name="namaunit" class="txt" readonly size="30" value="<?php echo $namaunit ?>" /></td>
</tr>
<tr>
	<td class="label">Kode Barang</td>
	<td class="label"><input type="text" id="kodebarang" name="kodebarang" class="txt" size="20" value="<?php echo $kodeBrg ?>"/></td>
</tr>
<tr>
	<td class="label">Nama Barang</td>
	<td class="label"><input type="hidden" id="idbarang" name="idbarang"  value="<?php echo $brg ?>"/><input type="text" id="namabarang" name="namabarang" class="txt" size="35" readonly value="<?php echo $nmbrg ?>">&nbsp;<img alt="tree" title='Struktur tree kode barang'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('jln_barang_tree.php?<?php echo $barang_opener; ?>',800,500,'msma',true)"> </td>
</tr>
<tr>
	<td class="label">No Seri</td>
	<td class="label"><input type="text" id="noseri" name="noseri" class="txt" size="20" maxlength="4" value="<?php echo str_pad($noseri,4,"0",STR_PAD_LEFT); ?>"></td>
</tr>
<tr>
	<td class="label">Lokasi</td>
	<td class="label"><input type="text" id="alamat" name="alamat" class="txt" size="50" value="<?php echo $alamat ?>"></td>
</tr>
<tr>
	<td class="label">Kode Tanah</td>
	<td class="label"><input type="text" id="kode_tanah" name="kode_tanah" size="20" class="txt" value="<?php echo $kode_tanah ?>" /></td>
</tr>
<tr>
	<td class="label">Kontruksi</td>
	<td class="label"><input type="text" id="kons" name="kons" class="txt" size="30" value="<?php echo $kons ?>" /></td>
</tr>
<tr>
	<td class="label">Panjang (KM) </td>
	<td class="label"><input type="text" id="panjang" name="panjang" size="20" class="txt" value="<?php echo $panjang ?>" /></td>
</tr>
<tr>
	<td class="label">Lebar (M) </td>
	<td class="label"><input type="text" id="lebar" name="lebar" size="20" class="txt" value="<?php echo $lebar ?>"/></td>
</tr>
<tr>
	<td class="label">Luas (M2) </td>
	<td class="label"><input type="text" id="luas" name="luas" size="20" class="txt" value="<?php echo $luas ?>"></td>
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
	<td class="label"><input type="text" id="no" name="no" class="txt" size="20" value="<?php echo $no ?>" /></td>
</tr>
<tr>
	<td class="label">Kondisi</td>
	<td class="label"><select id="kond" name="kond" class="txt">
	<option value="B"  <?php if($kond=='B')  echo 'selected'?>>Baik</option>
	<option value="KB" <?php if($kond=='KB') echo 'selected'?>>Kurang Baik</option>
	<option value="RB" <?php if($kond=='RB') echo 'selected'?>>Rusak Berat</option>
	</select></td>
</tr>
<tr>
	<td class="label">Keterangan</td>
	<td class="label"><input type="text" id="ket" name="ket" size="50" class="txt" value="<?php echo $ket ?>" /></td>
</tr>
<tr>
	<td class="label">Status Tanah</td>
	<td class="label"><select id="stt" name="stt" class="txt">
	<?php 
	$query=mysql_query("select st from status_tanah order by st");
	while($rwst=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $rwst['st'] ?>"<?php if($stt==$rwst['st']) echo'selected' ?>><?php echo $rwst['st'] ?></option>
	<?php 
	}
	?>
	</select></td>
</tr>
<tr>
	<td class="label" colspan="2" align="center" valign="middle"><button type="submit" id="simpan" name="simapan"><img src="../icon/save.gif" width="20" height="20" />&nbsp;Simpan</button>&nbsp;
	  <button type="button" id="batal" name="batal" value="Batal" onclick="Batal();"><img src="../icon/back.png" width="20" height="20" />&nbsp;Batal</button> </td>
</tr>
</table>
</td>
</tr>
<tr>
<td><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
</tr>
</table><br />


</form></div>
</body>
<script language="javascript">
function Batal(){
location='jln_irigasi_data.php';
}
</script>
</html>

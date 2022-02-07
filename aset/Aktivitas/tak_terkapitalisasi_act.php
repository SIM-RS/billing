<?php 
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 
include '../header.php';

$barang="par=idBrg*kode*nmBrg";
?>
<?php 
	$kode=$_POST['kode'];
	$nilai=$_POST['nilai'];
	$tgl=$_POST['tgl'];
	$tgl=explode("-",$tgl);
	$tgl=$tgl[2]."-".$tgl[1]."-".$tgl[0];
	if(isset($_POST['save'])){
		if($_GET['act']=='edit'){
			$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Update Aset Tak Terkpitalisais','update as_kapitalisasi set kode=".$kode.", nilai=".$nilai.",tgl_berlaku=".$tgl." where id=".$_GET['id']."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
			$sqlUp="update as_kapitalisasi set kode='".$kode."', nilai='".$nilai."',tgl_berlaku='".$tgl."' where id='".$_GET['id']."'";
			mysql_query($sqlUp);
			$cekUp=mysql_affected_rows();
			if($cekUp>0){
				echo "<script>alert('Data berhasil diubah...')</script>";
				echo "<script>window.location='../Aktivitas/tak_terkapitalisasi.php'</script>";
			}else if($cekUp==0){
				echo "<script>alert('Data tidak ada yang berubah...')</script>";
				echo "<script>window.location='../Aktivitas/tak_terkapitalisasi.php'</script>";
			}
		}else{
			$sqlIns2="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Aset Tak Terkpitalisais','insert into as_kapitalisasi (kode,nilai,tgl_berlaku)values(".$kode.",".$nilai.",".$tgl.")','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns2);
			$sqlIns="insert into as_kapitalisasi (kode,nilai,tgl_berlaku)values('".$kode."','".$nilai."','".$tgl."')";
			mysql_query($sqlIns);
			$cekIns=mysql_affected_rows();
			if($cekIns>0){
				echo "<script>alert('Data berhasil ditambah...')</script>";
				echo "<script>window.location='../Aktivitas/tak_terkapitalisasi.php'</script>";
			}
		}
	}
	if($_GET['act']=='edit'){
		$sql="SELECT * FROM as_kapitalisasi k INNER JOIN as_ms_barang b ON k.kode=b.kodebarang where k.id='".$_GET['id']."'";
		$rs=mysql_query($sql);
		$row=mysql_fetch_array($rs);
		$tglber=$row['tgl_berlaku'];
		$tgl1=explode("-",$tglber);
		$tglo=$tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>From Data Tak Terkapitalisasi</title>
</head>

<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<form action="" method="post" id="from1" name="from1">
<input type="hidden" id="idBrg" name="idBrg" />
<table width="1000" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
		<table width="700" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td colspan="2" align="center" class="header">.: Form Data Tak Terkapitalisasi :.</td>
		</tr>
		<tr>
			<td class="label">Nama Barang</td>
			<td class="content">&nbsp;<input type="text" id="nmBrg" name="nmBrg" readonly="true" size="50" value="<?php echo $row['namabarang'] ?>" />&nbsp;&nbsp;<img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('tak_terkapitalisasi_tree.php?<?php echo $barang; ?>',800,500,'Tree Unit',true)" /></td>
		</tr>
		<tr>
			<td class="label">Kode</td>
			<td class="content">&nbsp;<input type="text" id="kode" name="kode" readonly="true" size="20" value="<?php echo $row['kode'] ?>" /></td>
		</tr>
		<tr>
			<td class="label">Nilai</td>
			<td class="content">&nbsp;<input type="text" id="nilai" name="nilai" size="20" onkeyup="cekNl()" value="<?php echo $row['nilai'] ?>" /></td>
		</tr>
		<tr>
			<td class="label">Tgl Diberlakukan</td>
			<td class="content">&nbsp;<input type="text" id="tgl" readonly="true" name="tgl" size="20" value="<?php if($tglo!='') echo $tglo; else echo date("d-m-Y") ?>" />&nbsp;&nbsp;<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
		</tr>
		<tr>
			<td class="label" colspan="2" align="center"><button type="submit" id="save" name="save" onclick="return simpen()"><img src="../icon/save.gif" style="vertical-align:middle" width="20" height="20" />&nbsp;Simpan</button>&nbsp;&nbsp;<button type="button" id="tutup" name="tutup" onclick="window.location='../Aktivitas/tak_terkapitalisasi.php'"><img src="../icon/undo.gif" style="vertical-align:middle" width="20" height="20" />&nbsp;Batal</button></td>
		</tr>	
		</table>
	</td>
</tr>
<tr>
	<td><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
</tr>
</table>
</form>
</div>
</body>
<script language="javascript">
var arrRange=depRange=[];
function simpen(){
	if(document.forms[0].nmBrg.value=='' || document.forms[0].nilai.value==''){
		alert('Pengisian form belum lengkap');
		return false;
	}else{
		document.forms[0].submit();
	}
}
function cekNl(){
	if(isNaN(document.forms[0].nilai.value)){
		alert('Harus diisi numeric !');
		document.forms[0].nilai.value='';
	}
}
</script>
</html>

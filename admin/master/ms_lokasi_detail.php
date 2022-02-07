<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$id 		= $_GET['id'];
$back_addr 	= "ms_lokasi.php";
if(isset($_GET['origin']) && $_GET['origin'] != '') 
{
    $back_addr = "ms_lokasi_tree.php";
}
$kode_lokasi	= $_POST['kode_lokasi'];
$nama_lokasi	= $_POST['nama_lokasi'];
$aktif			= $_POST['aktif'];
if($aktif!=true){
	$aktif=0;
}else{
	$aktif=1;
}
$parent_kode=$_POST['kode_parent'];

if(isset($_POST["btnSimpan"]))
{
	if($_GET['act']=='edit')
	{
		$up="UPDATE ms_lokasi SET kodelokasi='$kode_lokasi',namalokasi='$nama_lokasi',statuslokasi='$aktif' WHERE idlokasi='".$_GET['id']."'"; //echo $up;
		$u=mysql_query($up);
		if($parent_kode!='')
		{
			$kode_parent = substr($kode_lokasi, 0, -3);//menghilangkan 3 character terakhir
			$sel = "SELECT * FROM ms_lokasi WHERE kodelokasi = '$kode_parent'"; //echo $sel;
			$rs=mysql_query($sel);
			$rows=mysql_fetch_array($rs);
			$up2="UPDATE ms_lokasi SET islast='0' WHERE kodelokasi='".$rows['kodelokasi']."'"; //echo $up2;
			mysql_query($up2);
		}
		if($u)
		{
			echo "<script>alert('Berhasil Diubah....');location='ms_lokasi.php';</script>";
		}else{
			echo "<script>alert('Gagal..')</script>";
		}
	}
	else
	{
		$ins="INSERT INTO ms_lokasi (kodelokasi,namalokasi,islast,statuslokasi) VALUES ('$kode_lokasi','$nama_lokasi','1','$aktif')"; //echo $ins;
		$i=mysql_query($ins);
		if($parent_kode!='')
		{
			$kode_parent = substr($kode_lokasi, 0, -3);
			$sel = "SELECT * FROM ms_lokasi WHERE kodelokasi = '$kode_parent'"; //echo $sel;
			$rs=mysql_query($sel);
			$rows=mysql_fetch_array($rs);
			$up2="UPDATE ms_lokasi SET islast='0' WHERE kodelokasi='".$rows['kodelokasi']."'"; //echo $up2;
			mysql_query($up2);
		}
		if($i)
		{
			echo "<script>alert('Berhasil Ditambah....');location='ms_lokasi.php';</script>";
		}
		else
		{
			echo "<script>alert('Gagal..')</script>";
		}
		
	}
}

if($_GET['act']=='edit'){
	$sql="SELECT * FROM ms_lokasi WHERE idlokasi='".$_GET['id']."'"; //echo $sql;
	$rs2=mysql_query($sql);
	$data=mysql_fetch_array($rs2);
	$aktif=$data['statuslokasi'];
}
?>


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<link type="text/css" rel="stylesheet" href="../default.css"/>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<title>.: Data Unit :.</title>
</head>

<body>
<div id="wrapper">
        <div id="header">
			<?php include("../inc/header.php");?>
        </div>
            
		<div id="topmenu">
            <?php include("../inc/menu/menu.php"); ?>
        </div>
            
<div id="content">
						<?php
						//include("../header.php");
						$act = $_GET['act'];
						$par = "act=$act";
						if($act == 'edit') 
						{
							$par .= "&idlokasi=$id";
							$query = "SELECT * FROM ms_lokasi WHERE idlokasi = '$id'";//echo $query;
							$rs = mysql_query($query);
							$rows = mysql_fetch_array($rs);
							
							
							$kode_parent = substr($data["kodelokasi"], 0, -3);
							$query1 = "SELECT *	FROM ms_lokasi WHERE kodelokasi = '$kode_parent'"; //echo $query1;
							$rs1 = mysql_query($query1);
							$rows1 = mysql_fetch_array($rs1);
						}
						?>
<form action="" method="post" id="form1" name="form1">
<table align="center" bgcolor="#FFFFFF" width="1000" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" height="300">
		<table width="538"  border="0" cellspacing="0" cellpadding="2" align="center">
		<tr>
			<td height="30" colspan="2" valign="bottom" align="right">
				<button type="button" class="Enabledbutton" id="backbutton" onClick="location='<?php echo $back_addr ?>'" title="Back" style="cursor:pointer"><img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />Back to List</button>
				<button class="Enabledbutton" type="submit" id="btnSimpan" name="btnSimpan" onClick="return simpan()" title="Save" style="cursor:pointer"><img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />Save Record</button>
				<button class="Disabledbutton" id="undobutton" onClick="location='<?php echo $_SERVER['REQUEST_URI'];?>'" title="Cancel / Refresh" style="cursor:pointer"><img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />Undo/Refresh</button>
			</td>
		</tr>
		<tr>
				<td colspan="2" height="28" class="header">.: Data Lokasi :.</td>
		</tr>
		<tr>
			<td width="27%" height="20" class="label">&nbsp;Induk Lokasi</td>
			<td width="73%" class="content">&nbsp;
			<input id="induk" name="induk" type="hidden" value="<?php echo $rows1['idlokasi']; ?>" size="20" maxlength="30" />
			<input type="text" id="kode_parent" name="kode_parent" readonly="readonly" value="<?php echo $rows1['kodelokasi'] ?>">
			<input type="text" id="nama_parent" name="nama_parent" readonly="readonly" value="<?php echo $rows1['namalokasi']; ?>" size="30" maxlength="75" />
            <input type="hidden" >
			<img alt="tree" title='Struktur tree kode lokasi' style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom"onClick="OpenWnd('ms_lokasi_treeup.php?act=<?=$act; ?>&par=induk*kode_parent*nama_parent*kode_lokasi',800,500,'msma',true);">                                              
			</td>
		</tr>
			<!--input type="hidden" id="lvl" name="lvl"  readonly="readonly" size="50"/-->
 		<tr>
			<td height="20" class="label">&nbsp;Kode Lokasi</td>
			<td class="content">&nbsp;
				<input type="text" id="kode_lokasi" name="kode_lokasi" value="<?php echo $data['kodelokasi']; ?>" maxlength="50" onKeyUp="riz()"/>
			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Nama Lokasi</td>
			<td class="content">&nbsp;
				<input type="text" id="nama_lokasi" name="nama_lokasi"  value="<?php echo $data['namalokasi']; ?>" size="54" maxlength="75" />
			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Aktif</td>
			<td class="content">&nbsp;
				<input type="checkbox" id="aktif" name="aktif" <?php if($aktif==1) echo "checked=checked"; ?> />
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="headerBawah">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
			  
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
</tr>
</table>
<div id="footer">
		<?php
			$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
				pgw_jabatan.id, pgw_jabatan.jbt_id,
				ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
				FROM rspelindo_hcr.pegawai
				INNER JOIN rspelindo_hcr.pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
				LEFT JOIN rspelindo_hcr.ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
				WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
			$i=0;
			$pegawai='';
			$jabatan='';
			while($row = mysql_fetch_array($query)){
				if($i==0)
					$pegawai = $row['nama'];
				if($i>0)
					$jabatan .= ", ";
				$jabatan .= $row['nama_jabatan'];	
				$i++; 
			}
		?>
		<div style="float:left;">Nama: <span style="color:yellow"><?php echo $pegawai;?></span></div>
		<div style="float:right;"> <span style="color:yellow;"><?=$jabatan?></span> : Jabatan</div>
	</div>    
</form>
</div>
</body>
<script type="text/javascript">	
/*
function simpan(){
	if(document.getElementById('kode_parent').value=='' || document.getElementById('eselon_kode').value=='' || document.getElementById('eselon').value=='') {
		alert('Form belum lengkap');
		return false;
	}
	else {
		//alert('masuk');
		document.forms[0].submit();
	}
}*/

riz();

function simpan(){
	if(document.getElementById('kode_lokasi').value==''){
		if(document.getElementById('kode_lokasi').value=='' || document.getElementById('nama_lokasi').value==''){
			alert('Form belum lengkap');return false;
		}
		if(document.getElementById('kode_lokasi').maxLength=2)
		{
			document.forms[0].submit;
		}
	}
}

function riz(){
		//alert('aaaaaa');
		var jml='';
		if(document.getElementById('kode_lokasi').value!='')
		{
			var cek=document.getElementById('kode_lokasi').value.split('.');
			jml=cek.length;
			if(document.getElementById('kode_lokasi').value=='')
			jml='';
			document.getElementById('lvl').value=jml;
		}
}

/* function belur(){
	document.getElementById('kode_parent').value='';
	document.getElementById('nama_parent').value='';
}  */
</script>
</html>

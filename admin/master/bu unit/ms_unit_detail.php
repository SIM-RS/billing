<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$id 		= $_GET['id'];
$back_addr 	= "ms_unit.php";
if(isset($_GET['origin']) && $_GET['origin'] != '') {
    $back_addr = "ms_unit_tree.php";
}
$parent			=$_POST["parent"];
$kode_unit		=$_POST['kode_unit'];
$nama_unit		=$_POST['nama_unit'];
$lvl			=$_POST['lvl'];
$nama_panjang	=$_POST['nama_panjang'];
//$jbt_jns	=$_POST['esjen'];
$aktif		=$_POST['aktif'];
if($aktif!=true){
	$aktif=0;
}else{
	$aktif=1;
}
$parent_unit=$_POST['kode_unit1'];

if(isset($_POST["btnSimpan"])){
	if($_GET['act']=='edit'){
		$up="UPDATE ms_unit SET kodeunit='$kode_unit',namaunit='$nama_unit',namapanjang='$nama_panjang',level='$lvl',isunit_aktif='$aktif' WHERE idunit='".$_GET['id']."'";
		$u=mysql_query($up);
		if($parent_unit!=''){
			$sel="SELECT parentunit FROM as_ms_unit WHERE parentunit='$parent_unit'";
			$rs=mysql_query($sel);
			$rows=mysql_fetch_array($rs);
			$up2="UPDATE ms_unit SET islast='0' WHERE kodeunit='".$rows['parentunit']."'";
			mysql_query($up2);
		}
		if($u){
			echo "<script>alert('Berhasil Diubah....');location='master_unit.php';</script>";
		}else{
			echo "<script>alert('Gagal..')</script>";
		}
	}else{
		$ins="INSERT INTO ms_unit (kodeunit,namaunit,namapanjang,parentunit,level,isunit_aktif) VALUES ('$kode_unit','$nama_unit','$nama_panjang','$parent_unit','$lvl','$aktif','1')";
		$i=mysql_query($ins);
		if($parent_unit!=''){
			$sel="SELECT parentunit FROM ms_unit WHERE parentunit='$parent_unit'";
			$rs=mysql_query($sel);
			$rows=mysql_fetch_array($rs);
			$up2="UPDATE ms_unit SET islast='0' WHERE kodeunit='".$rows['parentunit']."'";
			mysql_query($up2);
		}
		if($nama_unit=''){
		echo "<script>alert('FORM MASIH KOSONG');location='master_unit.php';</script>";
		}
		if($i){
			echo "<script>alert('Berhasil Ditambah....');location='ms_unit.php';</script>";
		}else{
			echo "<script>alert('Gagal..')</script>";
		}
		
	}
}

if($_GET['act']=='edit'){
	$sql="SELECT kodeunit,namaunit,namapanjang,parentunit,level,isunit_aktif FROM ms_unit WHERE idunit='".$_GET['id']."'";
	$rs2=mysql_query($sql);
	$data=mysql_fetch_array($rs2);
	$aktif=$data['isunit_aktif'];
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
						if($act == 'edit') {
						$par .= "&idunit=$id";
						$query = "SELECT idunit,kodeunit,namaunit,namapanjang,parentunit,level,kodeupb,nippetugas,namapetugas,
									jabatanpetugas,nippetugas2,namapetugas2,jabatanpetugas2,isunit_aktif
									FROM ms_unit
									WHERE idunit = '$id'";//echo $query;
						$rs = mysql_query($query);
						$rows = mysql_fetch_array($rs);
						$query1 = "SELECT idunit,kodeunit,namaunit
								FROM ms_unit
								WHERE idunit = '".$data["parentunit"]."'";
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
				<td colspan="2" height="28" class="header">.: Data Unit :.</td>
		</tr>
		<tr>
			<td width="27%" height="20" class="label">&nbsp;Induk Unit</td>
			<td width="73%" class="content">&nbsp;
			<input id="induk" name="induk" type="hidden" value="<?php echo $rows1['idunit']; ?>" size="20" maxlength="30" />
			<input type="text" id="kode_unit1" name="kode_unit1" readonly="readonly" value="<?php echo $rows1['kodeunit'] ?>">
			<input type="text" id="nama_unit1" name="nama_unit1" readonly="readonly" value="<?php echo $rows1['namaunit']; ?>" size="30" maxlength="75" />
            <input type="hidden" >
			<img alt="tree" title='Struktur tree kode unit' style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom"onClick="OpenWnd('ms_unit_treeup.php?act=<?=$act; ?>&par=induk*kode_unit1*nama_unit1*lvl*kode_unit',800,500,'msma',true);">                                              
			</td>
		</tr>
			<!--input type="hidden" id="lvl" name="lvl"  readonly="readonly" size="50"/-->
 		<tr>
			<td height="20" class="label">&nbsp;Kode Unit</td>
			<td class="content">&nbsp;
				<input type="text" id="kode_unit" name="kode_unit" value="<?php echo $data['kodeunit']; ?>" maxlength="50" onKeyUp="riz()"/>
			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Nama Unit</td>
			<td class="content">&nbsp;
				<input type="text" id="nama_unit" name="nama_unit"  value="<?php echo $data['namaunit']; ?>" size="54" maxlength="75" />
			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Nama Panjang</td>
			<td class="content">&nbsp;
				<input type="text" id="nama_panjang" name="nama_panjang" value="<?php echo $data['namapanjang'] ?>" size="54" maxlength="75"/>
			<td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Level</td>
			<td class="content">&nbsp;
				<input type="text" id="lvl" name="lvl" value="<?php echo $data ['level']; ?>" size="10" maxlength="10"/>
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
	if(document.getElementById('kode_unit').value==''){
		if(document.getElementById('kode_unit').value=='' || document.getElementById('nama_unit').value==''){
			alert('Form belum lengkap');return false;
		}
		if(document.getElementById('kode_unit').maxLength=2)
		{
			document.forms[0].submit;
		}
	}
}

function riz(){
		//alert('aaaaaa');
		var jml='';
		if(document.getElementById('kode_unit').value!=''){
			var cek=document.getElementById('kode_unit').value.split('.');
			jml=cek.length;
			if(document.getElementById('kode_unit').value=='')
			jml='';
			document.getElementById('lvl').value=jml;
			}
		}

/* function belur(){
	document.getElementById('kode_unit1').value='';
	document.getElementById('nama_unit1').value='';
}  */
</script>
</html>

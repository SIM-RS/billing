<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />

</head>

<body>
	
        <div id="wrapper">
            <div id="header">
				<?php include("../inc/header.php");?>
				<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../inc/menu/menu.js"></script> 
            </div>
            
          <div id="topmenu">
                 <?php include("../inc/menu/menu.php"); ?>
          </div>
            
            <div id="content">
			
<center>




<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
    <table width="1000" border="0" cellpadding="0" cellspacing="1" class="tabel" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3" style="color:#660000" height="30"><b>Data Wilayah (Propinsi)</b></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
	<td width="35%" align="right">Kode Wilayah&nbsp;&nbsp;&nbsp;</td>
    <td width="40%"><input id="txtId" type="hidden" name="txtId" /><input id="txtKode" name="txtKode" type="text" size="20" class="txtinput"/>
	</td>
    <td width="15%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align="right">Nama Wilayah&nbsp;&nbsp;&nbsp;</td>
    <td><input id="txtNama" name="txtNama" size="32" class="txtinput"/></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Level&nbsp;&nbsp;&nbsp;</td>
	<td><input id="txtLevel" name="txtLevel" size="5" class="txtinput"/>&nbsp;&nbsp;
		Parent Id&nbsp;<input id="txtParentId" name="txtParentId" size="5" class="txtinput"/>&nbsp;&nbsp;
		Parent Kode&nbsp;<input id="txtParentKode" name="txtParentKode" size="6" class="txtinput"/>&nbsp;
	<input type="button" class="txtcenter" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('ms_wilayah_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">    
		<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" /></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Status&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;<input type="checkbox" id="isAktif" name="isAktif" class="txtinput"/>&nbsp;&nbsp;Aktif</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td height="30">
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="window.location='ms_wilayah_tree.php'" class="tblViewTree">Tampilan Tree</button></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3">
		<div id="gridbox"></div>
	</td>
	<td>&nbsp;</td>
  </tr>
  </table>



		      </center>   
            </div>
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
            
        </div>
<div id="tempor" style="display:none"></div>
</body>
</html>
<script language="javascript">

function simpan(action)
{
	var id = document.getElementById("txtId").value;
	var kode = document.getElementById("txtKode").value;
	var nama = document.getElementById("txtNama").value;
	var level = document.getElementById("txtLevel").value;
	var parentId = document.getElementById("txtParentId").value;
	var parentKode = document.getElementById("txtParentKode").value;
	if(document.getElementById("isAktif").checked == true)
	{
		var aktif = 1;
	}
	else
	{
		var aktif = 0;
	}
	
	//alert("diag_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif);
	a.loadURL("ms_wilayah_utils.php?grd=true&act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&aktif="+aktif,"","GET");
	
	document.getElementById("txtKode").value = '';
	document.getElementById("txtNama").value = '';
	document.getElementById("txtLevel").value = '';
	document.getElementById("txtParentId").value = '';
	document.getElementById("txtParentKode").value = '';
	document.getElementById("isAktif").checked = false;
}

function ambilData()
{
	var z = a.getSelRowId();
	var data = z.split("|");

	var p="txtId*-*"+data[0]+"*|*txtKode*-*"+data[1]+"*|*txtNama*-*"+data[2]+"*|*txtLevel*-*"+data[3]+"*|*txtParentLvl*-**|*txtParentId*-*"+data[4]+"*|*txtParentKode*-*"+data[5]+"*|*isAktif*-*"+((data[6]=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
	fSetValue(window,p);
}

function hapus()
{
	var rowid = document.getElementById("txtId").value;
	
	var z = a.getSelRowId();
	var data = z.split("|");
	
	if(confirm("Anda yakin menghapus Propinsi "+data[2]))
	{
		a.loadURL("ms_wilayah_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
	}
	
	document.getElementById("txtKode").value = '';
	document.getElementById("txtNama").value = '';
	document.getElementById("txtLevel").value = '';
	document.getElementById("txtParentId").value = '';
	document.getElementById("txtParentKode").value = '';
	document.getElementById("isAktif").checked = false;
}

function batal()
{
	var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*txtLevel*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
	fSetValue(window,p);		
}


a = new extGrid("gridbox");
a.setTitle(".: Master Wilayah :.");
a.setHeader("NO,KODE,NAMA PROPINSI,LEVEL,PARENT ID,PARENT KODE,AKTIF");
a.setColId("no,kode,nama,level,parent_id,parent_kode,aktif");
a.setColType("string,string,string,string,string,string,string");
a.setColWidth("50,100,250,75,75,100,75");
a.setColAlign("center,left,left,center,center,left,center");
a.setWidthHeight('100%',300);
a.setClickEvent(ambilData);
a.baseURL("ms_wilayah_utils.php?grd=true");                                    
a.init(); 

</script>


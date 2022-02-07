<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

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
<iframe height="72" width="130" name="sort" id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<style>
input,select,textarea{
padding:3px 4px;
border:1px solid #999999;
font:11px Verdana, Arial, Helvetica, sans-serif;
}
</style>
		
<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tbl" style="font:11px Verdana, Arial, Helvetica, sans-serif;">
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><b>Master Principle</b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
	<div id="div_form">
	<table width="412" align="center" cellpadding="2" cellspacing="2" style="font:11px Verdana, Arial, Helvetica, sans-serif;">
	<tr>
	<td width="131" align="right">Kode Principle&nbsp;</td>
    <td width="265">&nbsp;:  
      <input name="kode_pabrik" type="text" id="kode_pabrik" class="txtinput" size="25" ></td>
    </tr>
  <tr>
	<td align="right">Nama Principle&nbsp;</td>
    <td>&nbsp;: <input name="pabrik" type="text" id="pabrik" class="txtinput" size="25" ></td>
    </tr>
  <tr>
	<td align="right">Status&nbsp;</td>
    <td>:
      &nbsp;
      <input id="isaktif" name="isaktif" type="checkbox" checked="checked" /></td>
    </tr>
  <tr>
    <td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
    <td height="30">
		&nbsp;&nbsp;
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>	</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
  </table>
	</div>	</td>
  </tr>
  <tr>
    <td align="left" style="padding-left:225px;">Status : 
	<select name="status" id="status" onchange="ganti(this.value)">
	<option value="1">Aktif</option>
	<option value="0">Tidak Aktif</option>
	</select></td>
  </tr>
  <tr>
	<td align="center">
	<div style="width:850px; margin:auto; text-align:right; display:none;">
	<img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="tambah" />&nbsp;&nbsp;
	<img alt="edit" style="cursor: pointer" src="../images/edit.png" onClick="ubah();" />&nbsp;&nbsp;
	<img alt="hapus" style="cursor: pointer" src="../images/hapus.png" id="btnHapusUnit" name="btnHapusUnit" onClick="if($('#txtId').val() == '' || $('#txtId').val() == null){alert('Pilih Master Unit terlebih dahulu.');return;}hapus();" />&nbsp;	</div>
	<div id="gridboxext" style="width:100%"></div>	</td>
</tr>
  <tr>
    <td align="center"></td>
  </tr>
<tr>
				<td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
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
Ext.onReady(function (){
 function ambilid(){  	
	var z = ri.getSelRowId();
	var data = z.split("|");//alert(data[0]);
	$("#txtId").val(data[0]);
	$("#kode_pabrik").val(data[1]);
	$("#pabrik").val(data[2]);
	if(data[3]==1)
	{
		$("#isaktif").attr("checked",true);
	}
	else
	{
		$("#isaktif").attr("checked",false);
	}
	$("#btnSimpan").val('Simpan');
	$("#btnHapus").attr('disabled',false);
	
}
ri = new extGrid("gridboxext");        
ri.setTitle(".: Master Principle :.");
ri.setHeader("No,Kode Principle,Nama Principle,Aktif");
ri.setColId("NO,KODE_PABRIK,PABRIK,ISAKTIF");
ri.setColType("string,string,string,string");
ri.setColWidth("50,150,250,70");
ri.setColAlign("center,left,left,center");
ri.setWidthHeight(550,300);
ri.setClickEvent(ambilid);
ri.baseURL("ms_pabrik_util.php?status="+$("#status").val());                                    
ri.init(); 

});	

function simpan(action)
	{
		if(ValidateForm('kode_pabrik,pabrik','ind'))
		{
			var status = $("#status").val();
			var pabrik_id = $("#txtId").val();
			var kode_pabrik = $("#kode_pabrik").val();
			var pabrik = $("#pabrik").val();
			var isaktif=1;
			
			
			if($("#isaktif").prop('checked')==false) 
			{
				isaktif=0;
			}
			var url = "ms_pabrik_util.php?status="+status+"&act="+action+"&pabrik_id="+pabrik_id+"&kode_pabrik="+kode_pabrik+"&pabrik="+pabrik+"&isaktif="+isaktif;
			//alert(url);
			ri.loadURL(url);
			//ganti(status);
			//ri.loadURL("ms_pabrik_util.php?status="+$("#status").val());  
			batal();
		}
}
function hapus(a)
{
	//alert(a);
	var status = $("#status").val();
	var pabrik_id = $("#txtId").val();
	var nama = $("#pabrik").val();
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	
	if(confirm("Anda yakin menghapus Principle "+nama+" ?"))
	{
		ri.loadURL("ms_pabrik_util.php?status="+status+"&act=Hapus&pabrik_id="+pabrik_id);
		batal();
	}
	
	
}

function batal()
{
	$("#txtId").val('');
	$("#kode_pabrik").val('');
	$("#pabrik").val('');
	
	$("#btnSimpan").val('Tambah');
	$("#btnHapus").attr('disabled',true);
	$("#isaktif").prop('checked')==true;
}

function ganti(val)
{
	var status = $("#status").val();
	ri.reload("ms_pabrik_util.php?status="+status);
}
</script>


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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>

  
<style>
input,select,textarea{
padding:3px 4px;
border:1px solid #999999;
font:11px Verdana, Arial, Helvetica, sans-serif;
}
#tabs{font:11px Verdana, Arial, Helvetica, sans-serif;
}
</style>

</head>

<body>
<div id="wrapper">
            <div id="header">
				<?php include("../inc/header.php");?>
				<link type="text/css" href="../../include/jquery/themes/base/ui.all.css" rel="stylesheet" />
				<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
				<script type="text/javascript" src="../inc/menu/menu.js"></script> 
				<script type="text/javascript" src="../../include/jquery/ui/jquery.ui.core.js"></script>
				<script type="text/javascript" src="../../include/jquery/ui/jquery.ui.widget.js"></script>
  				<script type="text/javascript" src="../../include/jquery/ui/jquery.ui.tabs.js"></script>
  
  <script type="text/javascript">
  $(document).ready(function(){
    $("#tabs").tabs();
  });
  </script>
            </div>
            
          <div id="topmenu">
                 <?php include("../inc/menu/menu.php"); ?>
          </div>
            
            <div id="content">
<table width="990" border="0" align="center">
  <tr>
    <td colspan="2" align="center" style="font:bold 14px Verdana, Arial, Helvetica, sans-serif;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="font:bold 16px Verdana, Arial, Helvetica, sans-serif;">.: Master Barang Farmasi:.</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>
<div id="tabs">
    <ul>
        <!--<li><a href="#fragment-1"><span>Umum</span></a></li>-->
        <li><a href="#fragment-1"><span>Farmasi</span></a></li>
    </ul>
    <div id="fragment-1">
		<div id="div_obat" style="display:none;"><? include "ms_barang_formObat.php";?></div>
		<div id="div_obat2">
		<div style="width:400px; float:left;"> Status : 
		<select id="status_obat" name="status_obat" class="txt" onChange="filter_obat(this.value)">
			<option value="1">Aktif</option>
			<option value="0">Tidak Aktif</option>
		</select>
		</div>
		
        <div style="width:450px; float:right; text-align:right; display:block; margin-bottom:10px;">
		<img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="tambah2()" />&nbsp;&nbsp;
		<img alt="edit" style="cursor: pointer" src="../images/edit.png" onClick="ubah2();" />&nbsp;&nbsp;
		<img alt="hapus" style="cursor: pointer" src="../images/hapus.png" id="btnHapusUnit" name="btnHapusUnit" onClick="hapus2();" />&nbsp;		
		</div><div style="clear:both"></div>
		<div id="gridboxext2" style="width:100%;"></div>   
		</div>
		 
	</div>
</div>	</td>
    <td>&nbsp;</td>
  </tr>
</table>
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

</body>
</html>
<script>
/*Ext.onReady(function (){*/


function ambilid3()
{  	
	var y = ri2.getSelRowId("idextabc"); //alert(y);
	fSetValue(window,y);
	//var data = y.split("|");//alert(data[0]);
}

ri2 = new extGrid("gridboxext2");        
ri2.setTitle(".: Master Barang Farmasi :.");
ri2.setHeader("No,Kode Obat,Nama Obat,Satuan Kecil,Bentuk,Kelas,Kategori,Jenis,Gol,Habis Pakai");
ri2.setColId("NO,kodebarang,namabarang,satuan,bentuk,kelas,kategori,jenis,gol,pakai");
ri2.setColType("string,string,string,string,string,string,string,string,string,string");
ri2.setColWidth("50,120,200,150,150,150,150,150,150,100");
ri2.setColAlign("center,left,left,left,left,left,center,left,left,center");
ri2.setWidthHeight(950,300);
ri2.setClickEvent(ambilid3);
ri2.baseURL("ms_barangF_util.php?tipe=3&status_obat="+$("#status_obat").val());                                    
ri2.init(); 




function filter_obat(tipe)
{	
	ri2.reload("ms_barangF_util.php?tipe=3&status_obat="+$("#status_obat").val());
}


$(function(){
	$('#formBarangAset').submit(function(){
		ri.loadURL('ms_barang_util.php?' + $(this).serialize() + '&tipe=' + $("#tipe").val());
		$('#formBarangAset').slideUp();
		return false;
	});
});

function tambahBarangAset()
{
	setTipeBarang();
	
	$('#formBarangAset').slideDown();
}

function ubahBarangAset()
{
	setTipeBarang();
	
	$('#formBarangAset').slideDown();
	$('#act').val('simpan');
}

function batalBarangAset()
{
	$('#formBarangAset')[0].reset();
	$('#idbarang').val('');
	$('#act').val('tambah');
	$('#formBarangAset').slideUp();
}

function hapusBarangAset()
{
	if (confirm('Apakah anda yakin?'))
	{
		ri.loadURL('ms_barang_util.php?act=hapus&idbarang=' + $('#idbarang').val() + '&tipe=' + $("#tipe").val());
		batalBarangAset();
	}
}

function setTipeBarang()
{
	$('#tipebarang option').hide();

	if ($('#tipe').val() == '1')
	{
		$('tr.aset_tetap').show();
		
		$('#tipebarang option[value=TT]').show();
		
		$('#tipebarang').val('TT');
	}
	else
	{
		$('tr.aset_tetap').hide();
		
		$('#tipebarang option[value=HP]').show();
		
		$('#tipebarang').val('HP');
	}
}

</script>
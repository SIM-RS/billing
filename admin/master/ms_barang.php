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
    <td colspan="2" align="center" style="font:bold 16px Verdana, Arial, Helvetica, sans-serif;">.: Master Barang Umum:.</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>Umum</span></a></li>
    </ul>
	
	
    <div id="fragment-1">
		
		<form id="formBarangAset" style="display: none;">
		<input type="hidden" id="idbarang" name="idbarang" />
		<input type="hidden" id="act" name="act" value="tambah"/>
		<table width="625" cellspacing="1" cellpadding="2" align="center">
			<tr>
				<td width="40%" height="20" class="label">&nbsp;Kode Barang</td>
				<td width="60%" class="content">&nbsp;<input id="kodebarang" name="barangAset[kodebarang]" size="24" style="background-color:#99FFFF;" />&nbsp;<i>(contoh 01.01.02.03.05)</i></td>
			</tr>
			<tr>
				<td height="20" class="label">&nbsp;Nama Barang</td>
				<td class="content">&nbsp;<input id="namabarang" name="barangAset[namabarang]" size="40" /></td>
			</tr>
			<tr>
				<td height="20" class="label">&nbsp;Satuan</td>
				<td class="content">&nbsp;<select name="barangAset[idsatuan]" id="idsatuan">
										<?php
										  $sqlSatuan=mysql_query("SELECT idsatuan FROM ms_satuan");
										  while($showSatuan=mysql_fetch_array($sqlSatuan)){
										  ?>
										<option value="<?=$showSatuan['idsatuan'];?>"><?=$showSatuan['idsatuan'];?></option>
										<?php } ?>
										</select>
				</td>
			</tr>
			<tr>
			  <td height="20" class="label">&nbsp;Kemasan</td>
			  <td class="content">&nbsp;<select name="barangAset[kemasan]" id="kemasan" class="txt">
				  <?php
						$query = "select idsatuan from ms_satuan";
						$rs = mysql_query($query);
						while($row = mysql_fetch_array($rs)) {
							?>
				  <option value="<?php echo $row['idsatuan']; ?>" <?php if($row['idsatuan'] == $rows['kemasan']) echo 'selected';?> ><?php echo $row['idsatuan']; ?></option>
				  <?php
						}
						?>
			  </select></td>
			</tr>
			<tr>
				<td height="20" class="label">&nbsp;Tipe Barang</td>
				<td class="content">&nbsp;<select id="tipebarang" name="barangAset[tipebarang]">
											<option value="TT">TT - Tetap</option>
											<option value="BG">BG - Bergerak</option>
											<option value="HP">HP - Habis Pakai</option>
											<option value="IT">Intangible</option>
											<option value="BH">BH - Hidup</option>
										</select>
				</td>
			</tr>
			<tr>
				<td height="20" class="label">&nbsp;Level</td>
				<td class="content">&nbsp;<input type="text" id="level" name="barangAset[level]" value="" />
				</td>
			</tr>
			<tr class="aset_tetap">
				<td height="28" colspan="2" class="header2">&nbsp;Informasi Depresiasi / Penyusutan</td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;Metode Depresiasi</td>
				<td class="content">&nbsp;<select id="metodedepresiasi" name="barangAset[metodedepresiasi]">
												<option value="NN">NN - Tidak Susut</option>
												<option value="SL">SL - Garis Lurus</option>
												<option value="RB">RB - Saldo Menurun</option>
												<option value="DD">DD - Double Declining</option>
												<option value="SY">SY - Sum Of Years</option>
											</select>
				</td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;A. Prosentase Dep.</td>
				<td class="content">&nbsp;<input id="stddepamt" name="barangAset[stddepamt]" size="16" />&nbsp;%</td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;C. Life Time</td>
				<td class="content">&nbsp;<input id="lifetime" name="barangAset[lifetime]" size="16" />&nbsp;bulan</td>
			</tr>
			<tr class="aset_tetap">
				<td height="28" colspan="2" class="header2">&nbsp;Kode Rekening Keuangan</td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;Akun. Persediaan</td>
				<td class="content">&nbsp;<input id="akunaset" name="barangAset[akunaset]" size="50" /></td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;Akun. Pengadaan</td>
				<td class="content">&nbsp;<input id="akunpengadaan" name="barangAset[akunpengadaan]" size="50" /></td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;Akun. Pemakaian</td>
				<td class="content">&nbsp;<input id="akunpemakaian" name="barangAset[akunpemakaian]" size="50" /></td>
			</tr>
			<tr class="aset_tetap">
				<td height="20" class="label">&nbsp;Akun. Penghapusan</td>
				<td class="content">&nbsp;<input id="akunhapus" name="barangAset[akunhapus]" size="50" /></td>
			</tr>
			<tr>
				<td height="28" colspan="2" class="header2">&nbsp;Aktif /Non Aktif</td>
			</tr>
			<tr>
			  <td height="20" class="label">&nbsp;Aktif</td>
			  <td class="content">&nbsp;<input type="checkbox" name="barangAset[isbrg_aktif]" id="isbrg_aktif" value="1" /></td>
			</tr>
			<!--<tr>
				<td height="20" class="label">&nbsp;Akun Biaya</td>
				<td class="content">&nbsp;<input type="text" id="biaya" class="text" readonly onClick="">
					<input type="hidden" name="kode_sak" id="barangAset[kode_sak]" class="text" readonly onClick="">                                     
					<img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 
						src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('ms_barang_tree.php?<?php echo $unit_opener; ?>',800,500,'msma',true)" />
				</td>
			</tr>-->
			<tr>
				<td height="20" class="label">&nbsp;</td>
				<td class="content">&nbsp;</td>
			</tr>
			<tr>
				<td height="20" class="label">&nbsp;</td>
				<td class="content">
					&nbsp;&nbsp;
					<input type="submit" name="btnSimpan" value="Simpan" class="tblTambah"/>
					<input type="reset" name="btnBatal" value="Batal" onclick="batalBarangAset()" class="tblBatal"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="header2">&nbsp;</td>
			</tr>
		</table>
		</form>
	
        <div style="width:400px; float:left;"> Kategori : 
		<select id="tipe" name="tipe" class="txt" onChange="filter(this.value)">
			<option value="1" <?php echo ($_GET['tipe']=="1")? "selected" : "";?>>Aset Tetap</option>
			<option value="2" <?php echo ($_GET['tipe']=="2")? "selected" : "";?>>Aset Lancar</option>
		</select>
		</div>		
		<div style="width:450px; float:right; text-align:right; display:block; margin-bottom:10px;">
		<img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="tambahBarangAset()" />&nbsp;&nbsp;
		<img alt="edit" style="cursor: pointer" src="../images/edit.png" onClick="ubahBarangAset();" />&nbsp;&nbsp;
		<img alt="hapus" style="cursor: pointer" src="../images/hapus.png" id="btnHapusUnit" name="btnHapusUnit" onClick="hapusBarangAset();" />&nbsp;		
		</div><div style="clear:both"></div>
		<div id="gridboxext" style="width:100%"></div>
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
function ambilid(){  	
	var z = ri.getSelRowId();
	var data = z.split("|");
	
	$('#act').val('hapus');
	
	$('#idbarang').val(data[0]);
	$('#kodebarang').val(data[1]);
	$('#namabarang').val(data[2]);
	$('#idsatuan').val(data[3]);
	$('#kemasan').val(data[4]);
	$('#tipebarang').val(data[5]);
	$('#level').val(data[6]);
	$('#metodedepresiasi').val(data[7]);
	$('#stddepamt').val(data[8]);
	$('#lifetime').val(data[9]);
	$('#akunaset').val(data[10]);
	$('#akunpengadaan').val(data[11]);
	$('#akunpemakaian').val(data[12]);
	$('#akunhapus').val(data[13]);
	$('#isbrg_aktif').val(data[14]);
}

ri = new extGrid("gridboxext");        
ri.setTitle(".: Master Barang Umum :.");
ri.setHeader("No,Kode Barang,Nama Barang,Satuan Kecil,Satuan Besar,Level,Aktif");
ri.setColId("NO,kodebarang,namabarang,kemasan,idsatuan,level,aktif");
ri.setColType("string,string,string,string,string,string,string");
ri.setColWidth("50,150,250,150,150,100,60");
ri.setColAlign("center,left,left,left,left,left,center");
ri.setWidthHeight(950,300);
ri.setClickEvent(ambilid);
ri.baseURL("ms_barang_util.php?tipe="+$("#tipe").val());                                    
ri.init(); 


function filter(tipe)
{	
	ri.reload("ms_barang_util.php?tipe="+tipe);
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
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
		
<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tbl">
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><b>Master KSO</b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
	<div id="div_form">
	<table width="775" align="center" cellpadding="2" cellspacing="2" style="font:11px Verdana, Arial, Helvetica, sans-serif;">
	<tr>
	<td width="160" align="right">Nama Penjamin&nbsp;</td>
    <td width="599">:&nbsp;  
      <input size="32" id="txtPenjamin" name="txtPenjamin" /></td>
    </tr>
  <tr>
	<td align="right">Kepemilikan Resep&nbsp;</td>
    <td>:&nbsp;
      <select id="idKepemilikan" name="idKepemilikan" class="txtinput">
    	<?php 
		$sql="SELECT * FROM $rspelindo_db_apotek.a_kepemilikan WHERE AKTIF=1";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
    	<option value="<?php echo $rw['ID']; ?>"><?php echo $rw['NAMA']; ?></option>
        <?php 
		}
		?>
    </select></td>
    </tr>
	<tr>
		<td align="right">Tipe&nbsp;</td>
		<td>:&nbsp;
			<select id="tipe" name="tipe" class="txtinput">
				<option value="0">REGULER</option>
				<option value="1">GESEK</option>
				<option value="2">NON REGULER/GESEK</option>
			</select>		</td>
    </tr>
  <tr>
	<td align="right">Alamat&nbsp;</td>
    <td>:&nbsp;
      <input size="32" id="txtAlmt" name="txtAlmt" /></td>
    </tr>
  <tr>
	<td align="right">Telepon&nbsp;</td>
    <td>: &nbsp;<input id="txtTlp" name="txtTlp" size="24" /></td>
    </tr>
  <tr>
	<td align="right">Fax&nbsp;</td>
    <td>:&nbsp;
      <input id="txtFax" name="txtFax" size="24" /></td>
    </tr>
  <tr>
	<td align="right">Kontak&nbsp;</td>
    <td>:&nbsp;
      <input id="txtKontak" name="txtKontak" size="32" /></td>
    </tr>
	
  <tr>
	<td align="right">Kelompok Pasien&nbsp;</td>
    <td>:&nbsp;
		<select name="kel_pasien" id="kel_pasien" class="txtinput">
		<?php
		$qry="select * from rspelindo_apotek.a_kelompok_pasien";
		$exe=mysql_query($qry);
		while($show=mysql_fetch_array($exe)){
		?>
		<option value="<?php echo $show['a_kpid']; ?>"><?php echo $show['kp_nama']; ?></option>
		<? }?>
		</select>    </tr>
  <tr>
	<td align="right">Diskon&nbsp;</td>
    <td>:&nbsp;
      <input id="txtDiskon" name="txtDiskon" size="5" /> %</td>
    </tr>
	
  <tr>
    <td align="right" valign="top">Keterangan&nbsp;</td>
    <td valign="top">:&nbsp; 
      <textarea cols="70" rows="10" id="keterangan"></textarea></td>
  </tr>
  <tr>
    <td align="right">Farmasi dijamin </td>
    <td>: &nbsp;
      <input id="chkDijamin" name="chkDijamin" type="checkbox"/></td>
  </tr>
  <tr>
	<td align="right">Aktif&nbsp;</td>
    <td>:
      &nbsp;
      <input id="chkAktif" name="chkAktif" type="checkbox" checked="checked" /></td>
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
	</div>
	</td>
  </tr>
  <tr>
	<td align="center">
	<div style="width:850px; margin:auto; text-align:right; display:none;">
	<img alt="tambah" style="cursor: pointer" src="../images/tambah.png" onClick="tambah" />&nbsp;&nbsp;
	<img alt="edit" style="cursor: pointer" src="../images/edit.png" onClick="ubah();" />&nbsp;&nbsp;
	<img alt="hapus" style="cursor: pointer" src="../images/hapus.png" id="btnHapusUnit" name="btnHapusUnit" onClick="if($('#txtId').val() == '' || $('#txtId').val() == null){alert('Pilih Master Unit terlebih dahulu.');return;}hapus();" />&nbsp;	
	</div>
	<div id="gridboxext" style="width:100%"></div>
	</td>
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
	var z = ri.getSelRowId();  //alert(z);
	var data = z.split("|");//alert(data[0]);
	$("#txtId").val(data[0]);
	$("#txtPenjamin").val(data[2]);
	$("#idKepemilikan").val(data[1]);
	$("#txtAlmt").val(data[3]);
	$("#txtTlp").val(data[4]);
	$("#txtFax").val(data[5]);
	$("#txtKontak").val(data[6]);
	$("#kel_pasien").val(data[7]);
	$("#txtDiskon").val(data[8]);
	$("#tipe").val(data[11]);
	
	$("#keterangan").val(data[13]);
	if(data[9]==1)
	{
		$("#chkAktif").attr("checked",true);
	}
	else
	{
		$("#chkAktif").attr("checked",false);
	}
	if(data[12]==1)
	{
		$("#chkDijamin").attr("checked",true);
	}
	else
	{
		$("#chkDijamin").attr("checked",false);
	}
	$("#btnSimpan").val('Simpan');
	$("#btnHapus").attr('disabled',false);
	
}
ri = new extGrid("gridboxext");        
ri.setTitle(".: Master KSO :.");
ri.setHeader("No,Kode,Nama Penjamin,Kepemilikan,Tipe,Kelompok Pasien,Alamat,Telepon,Fax,Kontak,Diskon,Aktif,Farmasi Dijamin");
ri.setColId("NO,kode,nama,kepemilikan,tipe,kelompok_pasien,alamat,telp,fax,kontak,diskon,aktif,jamin_obat");
ri.setColType("string,string,string,string,string,string,string,string,string,string,string,string,string");
ri.setColWidth("50,100,250,100,100,120,200,100,100,100,50,50,120");
ri.setColAlign("center,left,left,left,center,left,left,left,left,left,center,center,center");
ri.setWidthHeight(850,300);
ri.setClickEvent(ambilid);
ri.baseURL("ms_kso_util.php?grd=1");                                    
ri.init(); 

});	

function simpan(action)
	{
		if(ValidateForm('txtPenjamin,txtAlmt','ind'))
		{
			var id = $("#txtId").val();
			var nama = $("#txtPenjamin").val();
			var kpid = $("#idKepemilikan").val();
			var almt = $("#txtAlmt").val();
			var telp = $("#txtTlp").val();
			var fax = $("#txtFax").val();
			var kontak = $("#txtKontak").val();
			var kel_pasien = $("#kel_pasien").val();
			var diskon = $("#txtDiskon").val();
			var tipe = $("#tipe").val();
			var keterangan = $("#keterangan").val();
			var caktif=1;
			var cjamin=1;
			
			//if ($("#chkAktif").checked==false) caktif=0;
				if($("#chkAktif").prop('checked')==false) 
				{
					caktif=0;
				}
				if($("#chkDijamin").prop('checked')==false) 
				{
					cjamin=0;
				}
			
			
			//alert("penjamin_utils.php?grd=true&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak);
			var datane = "act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&kpid="+kpid+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak+"&caktif="+caktif+"&kel_pasien="+kel_pasien+"&diskon="+diskon+"&tipe="+tipe+"&cjamin="+cjamin+"&keterangan="+encodeURIComponent(keterangan);
			//alert(url);
			jQuery.ajax({
						  url: 'ms_kso_util.php',
						  data: datane,
						  type: 'POST',
						  success: function() {
						  
						  },
						  complete: function (data) {
						 // alert('sukses');
						  ri.loadURL("ms_kso_util.php","","GET");
						 }
					   });
			
			
			
			batal();
		}
}
function hapus()
{
	var rowid = $("#txtId").val();
	var nama = $("#txtPenjamin").val();
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	
	if(confirm("Anda yakin menghapus Penjamin "+nama+" ?"))
	{
		ri.loadURL("ms_kso_util.php?act=hapus&rowid="+rowid);
		batal();
	}
	
	
}

function batal()
{
	$("#txtId").val('');
	$("#txtPenjamin").val('');
	$("#txtAlmt").val('');
	$("#txtTlp").val('');
	$("#txtFax").val('');
	$("#txtKontak").val('');
	$("#txtDiskon").val('');
	$("#keterangan").val('');
	$("#tipe").val(0);
	$("#btnSimpan").val('Tambah');
	$("#btnHapus").attr('disabled',true);
	$("#chkAktif").prop('checked')==true;
}
</script>


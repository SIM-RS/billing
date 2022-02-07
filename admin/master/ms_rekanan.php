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
		
<table width="1000" align="center" cellpadding="0" cellspacing="1" class="tbl" style="font:11px Verdana, Arial, Helvetica, sans-serif">
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><b>Master Rekanan </b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
	<div id="div_form">
	<table width="569" align="center" cellpadding="2" cellspacing="2" style="font:11px Verdana, Arial, Helvetica, sans-serif;">
	<tr>
	  <td align="left">Kategori Rekanan</td>
	  <td>&nbsp;: <span id="tipex"></span></td>
	  </tr>
	<tr>
	  <td align="left">Kode Rekanan </td>
	  <td>&nbsp;:
        <input size="15" id="koderekanan" name="koderekanan" /></td>
	  </tr>
	<tr>
	<td width="158" align="left">Nama Rekanan &nbsp;</td>
    <td width="395">&nbsp;:  <input size="32" id="namarekanan" name="namarekanan" /></td>
    </tr>
  <tr>
	<td align="left">Tipe Supplier &nbsp;</td>
    <td>&nbsp;:
      <select id="idtipesupplier" name="idtipesupplier" class="txtinput">
    	<?php 
		$sql="SELECT * FROM ms_rekanan_tipe";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
    	<option value="<?php echo $rw['idtipesupplier']; ?>"><?php echo $rw['keterangan']; ?></option>
        <?php 
		}
		?>
    </select></td>
    </tr>
  
  
  
  <tr>
	<td align="left">Alamat&nbsp;</td>
    <td>&nbsp;:
      <input size="32" id="alamat" name="alamat" /></td>
    </tr>
  <tr>
	<td align="left">Telepon&nbsp;</td>
    <td>&nbsp;:
      <input id="telp" name="telp" size="24" /></td>
    </tr>
  <tr>
	<td align="left">HP&nbsp;</td>
    <td>&nbsp;:
      <input id="hp" name="hp" size="hp" /></td>
    </tr>
  <tr>
	<td align="left">Email&nbsp;</td>
    <td>&nbsp;:
      <input id="email" name="email" size="24" /></td>
    </tr>
  <tr>
	<td align="left">Fax&nbsp;</td>
    <td>&nbsp;:
      <input id="fax" name="fax" size="24" /></td>
    </tr>
  <tr>
    <td align="left">Kode Pos </td>
    <td>&nbsp;: <span class="content">
      <input name="kodepos" type="text" class="txt" id="kodepos" size="10"  />
    </span></td>
  </tr>
  <tr>
    <td align="left">Kota, Negara </td>
    <td>&nbsp;: <span class="content">
      <input name="kota" type="text" class="txt" id="kota" size="20"  />
      ,&nbsp;
      <input name="negara" type="text" class="txt" id="negara" size="20" />
    </span></td>
  </tr>
  <tr>
	<td align="left">Contact Person&nbsp;</td>
    <td>&nbsp;:<span class="content">
      <input name="contactperson" type="text" class="txt" id="contactperson" size="30"  />
    </span></td>
    </tr>
  <tr>
    <td>Aktif</td>
    <td height="30">&nbsp;:&nbsp;
      <input id="status" name="status" type="checkbox" checked="checked" /></td>
    </tr>
  <tr>
    <td height="30" colspan="2" align="center">&nbsp;<input id="txtId" type="hidden" name="txtId" />
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
    <td align="left" style="padding-left:75px;">Kategori Rekanan : 
	<select name="kategori" id="kategori" onchange="ganti_tipe()">
	<option value="1">Umum</option>
	<option value="2">Farmasi</option>
	</select> </td>
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
$(function(){
var kategori = $("#kategori option:selected").text(); //alert(tipe);
$("#tipex").html(kategori);
});

function ganti_tipe(){
var kategori = $("#kategori option:selected").text(); //alert(tipe);
$("#tipex").html(kategori);
ri.reload("ms_rekanan_util.php?kategori="+$("#kategori").val()); 
batal();  
}
Ext.onReady(function (){
 function ambilid(){  	
	var z = ri.getSelRowId(); //alert(z)
	var data = z.split("|");//alert(data[0]);
	$("#txtId").val(data[0]);
	$("#koderekanan").val(data[1]);
	$("#namarekanan").val(data[2]);
	$("#idtipesupplier").val(data[3]);
	$("#alamat").val(data[4]);
	$("#telp").val(data[5]);
	$("#kodepos").val(data[6]);
	$("#hp").val(data[7]);
	$("#fax").val(data[8]);
	$("#email").val(data[9]);
	$("#kota").val(data[10]);
	$("#negara").val(data[11]);
	$("#contactperson").val(data[12]);
	
	if(data[13]==1)
	{
		$("#status").attr("checked",true);
	}
	else
	{
		$("#status").attr("checked",false);
	}
	$("#btnSimpan").val('Simpan');
	$("#btnHapus").attr('disabled',false);
	
}
ri = new extGrid("gridboxext");        
ri.setTitle(".: Master Rekanan :.");
ri.setHeader("No,Kode,Nama Rekanan,Tipe,Alamat,Telepon,Fax,Kontak,Aktif");
ri.setColId("NO,koderekanan,namarekanan,keterangan,alamat,telp,fax,contactperson,status");
ri.setColType("string,string,string,string,string,string,string,string,string");
ri.setColWidth("50,100,250,100,200,100,100,100,50");
ri.setColAlign("center,left,left,left,left,left,left,left,center");
ri.setWidthHeight(850,300);
ri.setClickEvent(ambilid);
ri.baseURL("ms_rekanan_util.php?kategori="+$("#kategori").val());                                    
ri.init(); 

});	

function simpan(action)
	{
		if(ValidateForm('koderekanan,namarekanan','ind'))
		{
			var id = $("#txtId").val();
			var kategori = $("#kategori").val();
			var kode = $("#koderekanan").val();
			var nama = $("#namarekanan").val();
			var tipe = $("#idtipesupplier").val();
			var alamat = $("#alamat").val();
			var telp = $("#telp").val();
			var hp = $("#hp").val();
			var email = $("#email").val();
			var fax = $("#fax").val();
			var kodepos = $("#kodepos").val();
			var kota = $("#kota").val();
			var negara = $("#negara").val();
			var kontak = $("#contactperson").val();
			var caktif=1;
			
			//if ($("#chkAktif").checked==false) caktif=0;
				if($("#status").prop('checked')==false) 
				{
					caktif=0;
				}
			
			
			//alert("penjamin_utils.php?grd=true&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak);
			var url = "ms_rekanan_util.php?act="+action+"&id="+id+"&kategori="+kategori+"&kode="+kode+"&nama="+nama+"&tipe="+tipe+"&alamat="+alamat+"&telp="+telp+"&hp="+hp+"&email="+email+"&fax="+fax+"&kodepos="+kodepos+"&kota="+kota+"&negara="+negara+"&kontak="+kontak+"&status="+caktif;
			//alert(url);
			ri.loadURL(url);
			
			/*isiCombo('StatusPas','',idKso,'cmbKso',loadLayananTdkJamin);
			isiCombo('StatusPas','',idKso,'cmbKsoHP',loadPaketHP);
			isiCombo('StatusPas','',idKso,'cmbKsoDataPaket',loadDataPaket);
			isiCombo('StatusPas','',idKso,'cmbKsoPaket');
			isiCombo('StatusPas','',idKso,'cmbKsoLuarPaket');*/
			
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
	$("#koderekanan").val('');
	$("#namarekanan").val('');
	$("#alamat").val('');
	$("#telp").val('');
	$("#hp").val('');
	$("#email").val('');
	$("#fax").val('');
	$("#kodepos").val('');
	$("#kota").val('');
	$("#negara").val('');
	$("#contactperson").val('');
	
	$("#btnSimpan").val('Tambah');
	$("#btnHapus").attr('disabled',true);
	$("#status").prop('checked')==true;
}
</script>


<?
include '../sesi.php';
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../default.css"/>
    <link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<title>Edit Kode Barang</title>
</head>

<body>
<div align="center">
<?php
	include("../header.php");
	include("../koneksi/konek.php");
	$idrekanan = $_REQUEST['idrekanan'];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_ms_rekanan SET koderekanan='".$_REQUEST["txtkoderekanan"]."',namarekanan='".$_REQUEST["txtnamarekanan"]."',idtipesupplier='".$_REQUEST["cmbidtipesupplier"]."',alamat='".$_REQUEST["txtalamat"]."',alamat2='".$_REQUEST["txtalamat2"]."',telp='".$_REQUEST["txttelp"]."',telp2='".$_REQUEST["txttelp2"]."',kodepos='".$_REQUEST["txtkodepos"]."',kota='".$_REQUEST["txtkota"]."',negara='".$_REQUEST["txtnegara"]."',hp='".$_REQUEST["txthp"]."',fax='".$_REQUEST["txtfax"]."',email='".$_REQUEST["txtemail"]."',contactperson='".$_REQUEST["txtcontactperson"]."',deskripsi='".$_REQUEST["txtdeskripsi"]."',status='".$_REQUEST["cmbstatus"]."',npwp='".$_REQUEST["txtnpwp"]."',fp='".$_REQUEST["txtfp"]."',siupp='".$_REQUEST["txtsiupp"]."' WHERE idrekanan=$idrekanan";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{ 
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'rekanan.php';
			</script>";
		}
   }
	
	$sqlRek = "SELECT idrekanan,koderekanan,namarekanan,idtipesupplier,STATUS,alamat,alamat2,telp,telp2,kodepos,kota,negara,hp,fax,email,contactperson,deskripsi,npwp,fp,siupp FROM as_ms_rekanan WHERE idrekanan = '".$idrekanan."'";
	$dtRek = mysql_query($sqlRek);
	$rwRek = mysql_fetch_array($dtRek);
	
?>
<form name="form1" id="form1" action="" method="post">
    <input name="act" id="act" type="hidden" />
    <div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>

  </tr>
  <tr>
<td align="center">
<table width="625" bordercolor="#000000" border="0" cellspacing="0" cellpadding="2" align="center">
	<tr>
		<td height="30" colspan="2" valign="bottom" align="right">
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='rekanan.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editRekanan.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>
	<tr>
		<td colspan="2" height="28" class="header">.: Data Rekanan / Supplier :. (Edit Mode)</td>
	</tr>
	<tr>
		<td width="40%" height="20" class="label">&nbsp;ID Rekanan</td>
		<td width="60%" class="content">&nbsp;<input id="txtkoderekanan" name="txtkoderekanan" size="24" value="<?php echo $rwRek['koderekanan']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Nama Rekanan</td>
		<td class="content">&nbsp;<input id="txtnamarekanan" name="txtnamarekanan" size="50" value="<?php echo $rwRek['namarekanan']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Tipe Supplier</td>
		<td class="content">&nbsp;<select name="cmbidtipesupplier" id="cmbidtipesupplier">
								<?php
								  $sqlSup=mysql_query("SELECT idtipesupplier,keterangan FROM as_tiperekanan");
								  while($showSup=mysql_fetch_array($sqlSup)){
								  ?>
								<option <?php if($rwRek['idtipesupplier'] == $showSup['idtipesupplier']) echo 'selected';?> value="<?=$showSup['idtipesupplier'];?>"><?=$showSup['keterangan'];?></option>
								<?php } ?>
								</select>
		</td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Status</td>
		<td class="content">&nbsp;<select id="cmbstatus" name="cmbstatus">
									<option <?php if($rwRek['cmbstatus'] == 0) echo 'selected'; ?> value="0">Non Aktif</option>
									<option <?php if($rwRek['cmbstatus'] == 1) echo 'selected'; ?> value="1">Aktif</option>
								</select>
		</td>
	</tr>
	<tr>
		<td height="28" colspan="2" class="header2">&nbsp;Kontak</td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Alamat</td>
		<td class="content">&nbsp;<input id="txtalamat" name="txtalamat" size="55" value="<?php echo $rwRek['alamat']; ?>" /><br />&nbsp;<input id="txtalamat2" name="txtalamat2" size="55" value="<?php echo $rwRek['alamat2']; ?>"/>
		</td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Telp</td>
		<td class="content">&nbsp;<input id="txttelp" name="txttelp" size="24" value="<?php echo $rwRek['telp']; ?>"/><br />&nbsp;<input id="txttelp2" name="txttelp2" size="24" value="<?php echo $rwRek['telp2']; ?>" /></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;HP</td>
		<td class="content">&nbsp;<input id="txthp" name="txthp" size="24" value="<?php echo $rwRek['hp']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Email</td>
		<td class="content">&nbsp;<input id="txtemail" name="txtemail" size="45" value="<?php echo $rwRek['email']; ?>" /></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Fax</td>
		<td class="content">&nbsp;<input id="txtfax" name="txtfax" size="24" value="<?php echo $rwRek['fax']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Kode Pos</td>
		<td class="content">&nbsp;<input id="txtkodepos" name="txtkodepos" size="16" value="<?php echo $rwRek['kodepos']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Kota, Negara</td>
		<td class="content">&nbsp;<input id="txtkota" name="txtkota" size="24" value="<?php echo $rwRek['kota']; ?>"/>&nbsp;,&nbsp;<input id="txtnegara" name="txtnegara" size="24" value="<?php echo $rwRek['negara']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Contact Person</td>
		<td class="content">&nbsp;<input id="txtcontactperson" name="txtcontactperson" size="50" value="<?php echo $rwRek['contactperson']; ?>"/></td>
	</tr>
	<tr>
		<td height="28" colspan="2" class="header2">&nbsp;Keterangan Tambahan</td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;N.P.W.P</td>
		<td class="content">&nbsp;<input id="txtnpwp" name="txtnpwp" size="50" value="<?php echo $rwRek['npwp']; ?>"/></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;No Faktur Pajak</td>
		<td class="content">&nbsp;<input id="txtfp" name="txtfp" size="50" value="<?php echo $rwRek['fp']; ?>" /></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;S.I.U.P.P</td>
		<td class="content">&nbsp;<input id="txtsiupp" name="txtsiupp" size="50" value="<?php echo $rwRek['siupp']; ?>" /></td>
	</tr>
	<tr>
		<td height="20" class="label">&nbsp;Catatan Khusus</td>
		<td class="content">&nbsp;<textarea id="txtdeskripsi" name="txtdeskripsi" cols="50" ><?php echo $rwRek['deskripsi']; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" class="header2">&nbsp;</td>
	</tr>
</table>
<table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
</form>
</div>
</body>
</html>

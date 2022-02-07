<?
include '../sesi.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<title>.: Edit Unit Kerja :.</title>
</head>

<body>
<div align="center">
<?php
	include("../header.php");
	include("../koneksi/konek.php");
	$idunit = $_REQUEST['idunit'];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_ms_unit SET kodeunit='".$_REQUEST["txtKdUnt"]."',namaunit='".$_REQUEST["txtNm"]."',namapanjang='".$_REQUEST["txtNmPjg"]."',parentunit='".$_REQUEST["cmbInduk"]."',level='".$_REQUEST["cmbLvl"]."',kodeupb='".$_REQUEST["txtKdUpb"]."',nippetugas='".$_REQUEST["txtNip"]."',namapetugas='".$_REQUEST["txtNama"]."',jabatanpetugas='".$_REQUEST["txtJbtn"]."',nippetugas2='".$_REQUEST["txtNip2"]."',namapetugas2='".$_REQUEST["txtNama2"]."',jabatanpetugas2='".$_REQUEST["txtJbtn2"]."' WHERE idunit=$idunit";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'unit.php';
			</script>";
		}
   }
   
	$idunit = $_REQUEST['idunit'];
	
	$sqUnt = "SELECT idunit,kodeunit,namaunit,namapanjang,parentunit FROM as_ms_unit WHERE idunit = '".$idunit."'";
	$rsUnt = mysql_query($sqUnt);
	$rowUnt = mysql_fetch_array($rsUnt);
	
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
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='kode_brg.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editUnit.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>
	<tr>
		<td colspan="2" height="28" class="header">.: Data Unit / Satuan Kerja :. (Edit Mode)</td>
	</tr>
	 <tr>
		<td width="40%" height="20" class="label">&nbsp;Kode Unit / Sat Ker</td>
		<td width="60%" class="content">&nbsp;<input id="txtKdUnt" name="txtKdUnt" value="<?php echo $rowUnt['kodeunit']; ?>" size="24" style="background-color:#99FFFF;"/></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Nama Singkat</td>
		<td class="content">&nbsp;<input id="txtNm" name="txtNm" value="<?php echo $rowUnt['namaunit'];?>" size="32"/></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Nama Panjang</td>
		<td class="content">&nbsp;<input id="txtNmPjg" name="txtNmPjg" value="<?php echo $rowUnt['namapanjang'];?>" size="32" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Induk Unit</td>
		<td class="content">&nbsp;<select name="cmbInduk" id="cmbInduk">
								<?php
								  $sqlInduk=mysql_query("SELECT idunit,kodeunit,namaunit FROM as_ms_unit ORDER BY kodeunit");
								  while($showInduk=mysql_fetch_array($sqlInduk)){
								  ?>
								<option <?php if($rowUnt['parentunit'] == $showInduk['idunit']) echo 'selected';?> value="<?=$showInduk['idunit'];?>"><?=$showInduk['kodeunit'];?> - <?=$showInduk['namaunit'];?></option>
								<?php } ?>
								</select></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Level</td>
		<td class="content">&nbsp;<select id="cmbLvl" name="cmbLvl">
								<option <?php if($rowUnt['level'] == 1) echo 'selected'; ?> value="1">1 - Bidang</option>
								<option <?php if($rowUnt['level'] == 2) echo 'selected'; ?> value="2">2 - Unit Bidang</option>
								<option <?php if($rowUnt['level'] == 3) echo 'selected'; ?> value="3">3 - Sub Unit/Satuan Kerja</option>
							</select></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Kode UPB / Lokasi</td>
		<td class="content">&nbsp;<input id="txtKdUpb" name="txtKdUpb" size="42" value="<?php echo $rowUnt['kodeupb'];?>" /></td>
	  </tr>
	  <tr>
		<td height="28" colspan="2" class="header2">&nbsp;Petugas Pengesahan 1</td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;NIP</td>
		<td class="content">&nbsp;<input id="txtNip" name="txtNip" size="24" value="<?php echo $rowUnt['nippetugas'];?>" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Nama</td>
		<td class="content">&nbsp;<input id="txtNama" name="txtNama" size="42" value="<?php echo $rowUnt['namapetugas'];?>"/></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Jabatan</td>
		<td class="content">&nbsp;<input id="txtJbtn" name="txtJbtn" size="42" value="<?php echo $rowUnt['jabatanpetugas'];?>" /></td>
	  </tr>
	  <tr>
		<td height="28" colspan="2" class="header2">&nbsp;Petugas Pengesahan 2</td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;NIP</td>
		<td class="content">&nbsp;<input id="txtNip2" name="txtNip2" size="24" value="<?php echo $rowUnt['nippetugas2'];?>" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Nama</td>
		<td class="content">&nbsp;<input id="txtNama2" name="txtNama2" size="42" value="<?php echo $rowUnt['namapetugas2'];?>" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;Jabatan</td>
		<td class="content">&nbsp;<input id="txtJbtn2" name="txtJbtn2" size="42" value="<?php echo $rowUnt['jabatanpetugas2'];?>" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;</td>
	  </tr>
	  </table>
	  <table width="625" align="center">
	  	<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><fieldset style="background-color:#FFFFCC">
					<b><u>Keterangan</u></b><br>
					<b>Level</b>&nbsp;( 1 = Bidang | 2 = Unit Bidang | 3 = Sub Unit/Satuan Kerja )
				</fieldset></td>
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

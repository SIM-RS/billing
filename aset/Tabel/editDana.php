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
	$idsumberdana = $_REQUEST['idsumberdana'];
	if($_REQUEST["act"]=="save")
	{
        $sql_update="UPDATE as_ms_sumberdana SET keterangan='".$_REQUEST["txtSmbrDana"]."', nourut='".$_REQUEST["txtNo"]."' WHERE idsumberdana = $idsumberdana";
        $exe_update=mysql_query($sql_update);
        if($exe_update>0)
		{ 
			echo "<script>alert('Data Telah Berhasil Tersimpan..');
			window.location= 'smbrDana.php';
			</script>";
		}
   }
   
	$idsumberdana = $_REQUEST['idsumberdana'];
	
	$sqDana = "SELECT idsumberdana,keterangan,nourut FROM as_ms_sumberdana WHERE idsumberdana = '".$idsumberdana."'";
	$rsDana = mysql_query($sqDana);
	$rowDana = mysql_fetch_array($rsDana);
	
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
			<button class="Enabledbutton" id="backbutton" type="button" onClick="location='smbrDana.php'" title="Back" style="cursor:pointer">
        			<img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
                		Back to List
            </button>
	  		<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
            <button class="Disabledbutton" id="undobutton" disabled="true" onClick="location='editDana.php'" title="Cancel / Refresh" style="cursor:pointer">
                	<img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      					Undo/Refresh
            </button></td>
	</tr>
	  <tr>
		<td colspan="2" height="28" class="header">.: Data Sumber Dana :.</td>
	  </tr>
	  <tr>
		<td height="20" class="label" width="40%">&nbsp;Sumber Dana</td>
		<td class="content" width="60%">&nbsp;<input id="txtSmbrDana" name="txtSmbrDana" size="45" value="<?php echo $rowDana['keterangan'];?>" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;nourut</td>
		<td class="content">&nbsp;<input id="txtNo" name="txtNo" size="24" value="<?php echo $rowDana['nourut'];?>" /></td>
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

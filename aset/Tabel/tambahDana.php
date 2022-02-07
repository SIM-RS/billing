<?
include '../sesi.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<title>Tambah Sumber Dana</title>
</head>

<body>
<div align="center">
<?php
	include("../header.php");
	include("../koneksi/konek.php");
	if($_REQUEST["act"]=="save")
	{
        $sql_insert="INSERT INTO as_ms_sumberdana (keterangan,nourut) values ('".$_REQUEST["txtSmbrDana"]."','".$_REQUEST["txtNo"]."')";
        $exe_insert=mysql_query($sql_insert);
        if($exe_insert>0) echo "<script>alert('Data Telah Berhasil Tersimpan..');</script>";
   }
?>
<div>
            <table align="center" bgcolor="#FFFBF0" width="1000" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>

  </tr>
  <tr>
<td align="center">
<table width="100" border=0 cellspacing=0 cellpadding="0" class="GridStyle" bgcolor="#999999">
	<tr> 
    	<td width="20%" height="29" align="left" nowrap>
			<button class="Enabledbutton" id="backbutton" onClick="location='smbrDana.php'" title="Back" style="cursor:pointer">
				<img  src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />
					Back to List
			</button>
		</td>
    	<td width="20%" align="left" nowrap>
			<button class="Disabledbutton" disabled=true id="editbutton" name="editbutton" onClick="goEdit()" title="Edit" style="cursor:pointer">
				<img src="../images/editsmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Edit Record
			</button>
		</td>
    	<td width="20%" align="left" nowrap>
			<button class="Enabledbutton" id="btnSimpan" name="btnSimpan" onClick="document.getElementById('act').value='save';form1.submit()" title="Save" style="cursor:pointer">
      			<img  src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Save Record
			</button>
		</td>
    	<td width="20%" align="left" nowrap>
			<button class="Disabledbutton" id="undobutton" disabled=true onClick="goUndo()" title="Cancel / Refresh" style="cursor:pointer">
      			<img src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Undo/Refresh
			</button>
		</td>
    	<td width="20%" align="left" nowrap>
	 		<button class="Disabledbutton" id="deletebutton" disabled=true onClick="goDelete()" title="Delete" style="cursor:pointer">
      			<img  src="../images/deletesmall.gif" width="22" height="22" border="0" align="absmiddle" />
      				Delete
			</button>
		</td>
	  	<td width="20%" align="left" nowrap>
	 		<button class="Enabledbutton" id="helpbutton" onClick="goHelp()" title="Help" style="cursor:pointer">
      			<img  src="../images/help_book.gif" width="22" height="22" border="0" align="absmiddle" /> 
					?
      		</button>
		</td>
	</tr>
</table>
	<br />
<form name="form1" id="form1" action="" method="post">
    <input name="act" id="act" type="hidden" />
<table width="625" bordercolor="#000000" border="1" cellspacing="0" cellpadding="2" align="center">
	  <tr>
		<td colspan="2" height="28" class="header">.: Data Sumber Dana :.</td>
	  </tr>
	  <tr>
		<td height="20" class="label" width="40%">&nbsp;Sumber Dana</td>
		<td class="content" width="60%">&nbsp;<input id="txtSmbrDana" name="txtSmbrDana" size="45" /></td>
	  </tr>
	  <tr>
		<td height="20" class="label">&nbsp;nourut</td>
		<td class="content">&nbsp;<input id="txtNo" name="txtNo" size="24" /></td>
	  </tr>
	  <tr>
		<td colspan="2" class="header2">&nbsp;</td>
	  </tr>
	</table>
</form>
<table><tr><td height="10"></td></tr></table>
            <div><img src="../images/foot.gif" width="1000" height="45"></div>
            </td>

  </tr>
</table>
            </div>
</div>
</body>
</html>

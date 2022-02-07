<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit User</title>
</head>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
<body>
<table width="99%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td id="listjurnal" class="dltable" style="font-weight:bold; text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td id="listjurnal" class="dltable" style="font-weight:bold; text-align:center"> Edit Jenis Transaksi Khusus </td>
  </tr>
</table>
<?
$qry = "select * from JENIS_TRANSAKSI where JTRANS_ID=$_POST[JTRANS_ID]";
$exe = mysql_query($qry);
$show = mysql_fetch_array ($exe);
?>
<table width="618" border="0" align="center">
<form name="formJnsTrans" action="?f=../master/ms_trans_khusus" method="post">
  <tr>
    <td width="253">Nama Jenis Transaksi Khusus </td>
    <td colspan="2">:<input name="JTRANS_NAMA" id="JTRANS_NAMA" size="40" type="text" value="<?=$show[JTRANS_NAMA]?>" /></td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td width="355" align="center" valign="middle">
	<input type="hidden" name="update" value="1" />
	<input type="hidden" name="JTRANS_ID" value="<?=$show[JTRANS_ID]?>"  />
	<BUTTON type="reset" name="UpdateJenis Transaksi" value="UpdateJenis Transaksi" onClick="if (ValidateForm('JTRANS_NAMA','ind')){document.formJnsTrans.submit();}"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">Update</BUTTON>
	 
    <BUTTON type="reset" onClick="location='?f=../master/ms_trans_khusus'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </td>
  </tr>
</form>
</table>
<p>&nbsp;</p>
</body>
</html>

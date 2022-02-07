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
    <td id="listjurnal" class="dltable" style="font-weight:bold; text-align:center"> Tambah Jenis Transaksi Khusus </td>
  </tr>
</table>
<table width="579" border="0" align="center">
<form name="formJnsTrans" action="?f=../master/ms_trans_khusus" method="post">
  <tr>
    <td width="263">Nama Jenis Transaksi Khusus </td>
    <td colspan="2">:<input name="JTRANS_NAMA" id="JTRANS_NAMA" size="40" type="text" value="" /></td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td width="306" align="center" valign="middle">
	<input type="hidden" name="tambah" value="1" />
	<BUTTON type="reset" name="Tambah Jenis Transaksi" value="Tambah Jenis Transaksi" onClick="if (ValidateForm('JTRANS_NAMA','ind')){document.formJnsTrans.submit();}"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">Tambah</BUTTON>&nbsp;
    <BUTTON type="reset" onClick="location='?f=../master/ms_trans_khusus'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</td>
  </tr>
 </form>
</table>
<p>&nbsp;</p>
</body>
</html>

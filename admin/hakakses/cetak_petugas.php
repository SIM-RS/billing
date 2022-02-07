<?
$modul_nama = $_REQUEST['modul_nama'];
$group_nama = $_REQUEST['group_nama'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Petugas di Group Apikasi</title>
</head>
<style>
table
{
	font:12px Verdana, Arial, Helvetica, sans-serif;
}
</style>

<body>
<table width="685" border="0" align="center">
  <tr>
    <td colspan="3" align="center" style="font:bold 14px Verdana, Arial, Helvetica, sans-serif"><b>DAFTAR PETUGAS</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="97">Modul</td>
    <td width="9">:</td>
    <td width="565"><b><?=$modul_nama;?></b></td>
  </tr>
  <tr>
    <td>Group</td>
    <td>:</td>
    <td><b><?=$group_nama;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="690" border="1" bordercolor="#000000" align="center" style="border-collapse:collapse;">
  <tr style="font-weight:bold; background:#CCCCCC">
    <td width="43" height="28" align="center">No</td>
    <td width="133" align="center">Username</td>
    <td width="492" align="center">Nama Petugas </td>
  </tr>
  <?
  $no = 1;
  include("../inc/koneksi.php");
  $q = "select * from (SELECT 
		  p.PEGAWAI_ID,
		  p.user_name,
		  p.NAMA 
		FROM
		  $rspelindo_db_hcr.pegawai p 
		  INNER JOIN ms_group_petugas mgp 
			ON p.PEGAWAI_ID = mgp.ms_pegawai_id 
		WHERE mgp.ms_group_id='".$_REQUEST['group_id']."') as tbl2 ORDER BY tbl2.NAMA";
  $s = mysql_query($q);
  while($d = mysql_fetch_array($s))
  {
  ?>
  <tr>
    <td align="center" height="25"><?=$no++;?>.</td>
    <td>&nbsp;      <?=$d['user_name'];?></td>
    <td>&nbsp;      <?=$d['NAMA'];?></td>
  </tr>
  <?
  }
  ?>
</table>
<br />
<table width="500" border="0" align="center">
  <tr>
    <td align="center"><button onclick="window.print()">Print</button></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="748" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#006699" style="font:12px Verdana, Arial, Helvetica, sans-serif; border-collapse:collapse" bgcolor="#EAF0F0">
  <tr style=" text-align:center; font-weight:bold; background:#6699CC; padding:3px; color:#FFFFFF">
    <td width="63" height="24">No</td>
    <td width="56" align="center"><input type="checkbox" name="chkall" id="chkall" onclick="cek_semua(this.checked)" /></td>
    <td width="261">Kode</td>
    <td width="332">Menu</td>
  </tr>
<?
	$no = 1;
	include "../koneksi/konek.php";
	$kode_user = $_REQUEST['kode_user'];
	$q = "SELECT a.*,b.user_id FROM a_menu AS a LEFT JOIN (SELECT * FROM a_menu_akses  WHERE `user_id`='$kode_user')AS b ON b.`menu_id`=a.`id` ORDER BY a.mn_kode";
	$s = mysqli_query($konek,$q);
	while($d = mysqli_fetch_array($s))
	{
		 if($d['user_id']==""){$checked = "";}else{$checked = "checked='checked'";}
?>
  <tr>
    <td align="center"><?=$no;?></td>
    <td align="center"><input type="checkbox" name="id_menu[]" class="chk" <?=$checked;?> value="<?=$d['id'];?>"/></td>
    <td><?=$d['mn_kode'];?></td>
    <td><?=$d['mn_menu'];?></td>
  </tr>
  <?
  $no++;
  }
  ?>
</table>

</body>
</html>
<script>
function cek_semua(status)
{
	//alert(status)
	$(".chk").attr("checked",status);
}
</script>
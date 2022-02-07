<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<script src="jquery-1.8.2.js"></script>
<script src="jquery.form.js"></script>
<?

?>

<body onload="setTimeout('get_list()',500)">

<form id="form_akses" method="post">
<div style="width:900px; margin:auto;padding:30px;">
<div style="font:bold 16px Verdana, Arial, Helvetica, sans-serif; text-align:center; margin-bottom:15px;">Menu Akses</div>
<div style="font:12px Verdana, Arial, Helvetica, sans-serif; margin:auto; margin-bottom:15px; width:770px;"><b>User</b> : 
<select name="kode_user" id="kode_user" style="font:12px Verdana, Arial, Helvetica, sans-serif; padding:2px;" onchange="get_list()">
<?
$q = "select kode_user,username from a_user ORDER BY username";
$s = mysqli_query($konek,$q);
while($d = mysqli_fetch_array($s))
{
	if(isset($_REQUEST['kode_user']))
	{
		if($d['kode_user']==$_REQUEST['kode_user'])
		{
			$selected = "selected='selected'";
		}
		else
		{
			$selected = "";
		}
	}
	else
	{
		$selected = "";
	}
	$usernya = strtoupper($d['username']);
	echo "<option value='$d[kode_user]' $selected>$usernya</option>";
}
?>
</select>
</div>

<div id="list_menu" style="text-align:center; width:770px; margin:auto; margin-bottom:15px; max-height:400px; overflow-y:scroll; padding:10px; border:5px solid #336699; border-radius:5px; background:#FFFFCC">&nbsp;</div>
<div style="text-align:center; width:770px; margin:auto;">
<button type="button" style="font:bold 12px Verdana, Arial, Helvetica, sans-serif; background:#336699; color:#FFFFFF; border:1px solid #003366; padding:2px 3px; cursor:pointer;" onclick="proses()">Simpan</button>
</div>
</div>
</form>
</body>
</html>
<script>
function get_list()
{
	var kode_user = jQuery('#kode_user').val();
	//$('#list_menu').load('get_menu.php?kode_user='+kode_user);
	jQuery('#list_menu').load('../admin/get_menu.php?kode_user='+kode_user);
	//alert(kode_user);
}
function proses()
{	
	jQuery("#form_akses").submit();
}

jQuery(function(){
	jQuery("#form_akses").submit(function(){
		jQuery.ajax({
			type: 'post',
			data: jQuery(this).serialize(),
			url: '../admin/setting_akses_act.php',
			success: function(){
				window.location = "?f=../admin/setting_akses&kode_user="+jQuery('#kode_user').val();;
			}
		});
		return false;
	});
});
</script>
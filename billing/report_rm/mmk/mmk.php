<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<!--<script src="js/jquery.timeentry.js"></script>-->
<script src="jquery.table.addrow.js"></script>
<body>
<div id="formx" style="margin:auto; margin-bottom:20px; width:1000px; display:block;">
<div  style="margin:auto; margin-bottom:20px; width:990px; display:block; text-align:center; font:bold 14px Verdana, Arial, Helvetica, sans-serif">FORM PERMINTAAN BAHAN MAKANAN KERING <BR />
INSTALASI GIZI RS PELINDO I
</div>
<div id="tabel_mmk" style="margin:auto; margin-bottom:20px; width:990px;">
<table width="990" border="1" style="border-collapse:collapse; font:12px Verdana, Arial, Helvetica, sans-serif;" bordercolor="#336699">
  <tr align="center" bgcolor="#6699CC" style="font-weight:bold; color:#FFFFFF;">
    <td width="49" rowspan="2">NO</td>
    <td width="236" rowspan="2">BAHAN MAKANAN </td>
    <td width="196" rowspan="2">UKURAN</td>
    <td width="176" rowspan="2">SATUAN</td>
    <td colspan="2">KESESUAIAN SPESIFIKASI </td>
    <td width="62" rowspan="2"><input name="button" type="button" class="alternativeRow" value="(+)" style="cursor:pointer; background:#FFFF66; border:1px solid #FFCC33; padding:2px 3px;"/></td>
  </tr>
  <tr align="center" bgcolor="#6699CC" style="font-weight:bold; color:#FFFFFF;">
    <td width="123">YA</td>
    <td width="102">TIDAK</td>
    </tr>
  <tr>
    <td align="center"><span class="no" style="color:#336699"></span></td>
    <td align="center"><input type="text" name="bhm_mmk[]" id="bhm_mmk" class="bhm_mmk" /></td>
    <td align="center"><input type="text" name="ukn_mmk[]" id="ukn_mmk" class="ukn_mmk" /></td>
    <td align="center"><input type="text" name="stn_mmk[]" id="stn_mmk" class="stn_mmk" /></td>
    <td colspan="2" align="center">
	<select name="ses_mmk[]">
	<option value="ya">Ya</option>
	<option value="tidak">Tidak</option>
	</select>
	</td>
    <td align="center"><img src="cross.png" class="delRow" border="0" style="cursor:pointer;" /></td>
  </tr>
</table>

</div>
</div>
</body>
</html>
<script>
$("document").ready(function(){
	$(".alternativeRow").btnAddRow({oddRowCSS:"oddRow",evenRowCSS:"evenRow",rowNumColumn: 'no'},function(barisBaru){
	});
	$(".delRow").btnDelRow();
});
</script>
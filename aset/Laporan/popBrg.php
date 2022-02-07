
<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<body>
 <div id="popList" style="display:none; border:5px solid #009933; background-color:white;width:900; height:300" align="center"><br />
<div id="close" align="right" style="padding-right:20px"><img src="../icon/cancel.gif" width="25" onClick="Popup.hide('popList');" style="cursor:pointer" /></div>
<table width="800" align="center" cellpadding="4" cellspacing="0">
<tr>
	<td align="center" colspan="2">
	<select id="CmbStt" name="CmbStt">
	 <option value="1">Iventaris</option>
	 <option value="2">Pakai Habis</option>
	</select>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><strong>Nama Barang</strong></td>
	<td>
    <input type="hidden" id="txtIdBrg" name="txtIdBrg" />
    <input type="hidden" id="kdBarang" name="kdBarang" />
    <input type="hidden" id="satuanBarang" name="satuanBarang"/>
    <input type="text" id="nmBarang" name="nmBarang" size="80" onKeyUp="list1(event,this);" autocomplete="off" onClick="this.value=''"  /> </td>
	
</tr>
<tr>
	<td>&nbsp;</td>
	<td><center><div id="divobat" align="center" style="z-index:1; width: 751px; left: 419px; top: 588px; height: 300px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div></center></td>
</tr>
</table>
</div>
</body>
<script language="javascript">
function nol(){
document.getElementById("nmBarang").value=''
}
</script>

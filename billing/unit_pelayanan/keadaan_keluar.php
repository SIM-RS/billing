<?php
include("../sesi.php");
?>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />
<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeKK()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">KEADAAN KELUAR</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="left">Cara Keluar</td>
      <td align="left">:</td>
      <td align="left"><select id="cara_keluar" name="cara_keluar" class="txtinput" onchange="ganti111()"><?php
      $rs = mysql_query("SELECT * FROM b_ms_cara_keluar WHERE aktif=1");
            	while($rows=mysql_fetch_array($rs)):
		?>
			<option id="<?=$rows["id"]?>" value="<?=$rows["id"]?>" ><?=$rows["nama"]?></option>
            <?	endwhile;
	  ?></select>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="left">Keadaan Keluar</td>
      <td align="left">:</td>
      <td align="left">
        <input name="txtKeadaanKeluar" type="text" id="txtKeadaanKeluar" size="40" />
      </td>
    </tr>
    <!-- <tr>
      <td colspan="2" align="left">Flag</td>
      <td align="left">:</td>
      <td align="left"> -->
      <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" tabindex="3" value="<?php echo $flag; ?>"/>
      <!-- </td>
    </tr> -->
    <tr> 
        <td colspan="2" align="left">Status</td>
        <td align="left">:</td>
        <td align="left"><input id="status_keadaan" name="status_keadaan" type="checkbox" value="1"/></td>
    </tr>
    <tr>
    	<td colspan="4" align="center"><input type="hidden" id="id_keadaan_keluar" name="id_keadaan_keluar" />
                <button type="button" id="btnSimpanKK" name="btnSimpanKK" value="tambah" onClick="saveKK(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteKK" name="btnDeleteKK" onClick="deleteKK()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalKK" name="btnBatalKK" onClick="batalKK()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button></td>
    </tr>
	<tr>
    	<td colspan="4" align="center"><div id="gbKK" style="width:450px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pgKK" style="width:450px;"></div></td>
    </tr>
</table>


<script>
gKK=new DSGridObject("gbKK");
gKK.setHeader("DAFTAR KEADAAN KELUAR");
gKK.setColHeader("NO,CARA KELUAR,KEADAAN KELUAR,STATUS");
gKK.setIDColHeader(",,");
gKK.setColWidth("30,100,150,80");
gKK.setCellAlign("center,left,left,center");
gKK.setCellHeight(20);
gKK.setImgPath("../icon");
gKK.setIDPaging("pgKK");
gKK.attachEvent("onRowClick","ambilKK");
gKK.baseURL("keadaan_keluar_util.php");
gKK.Init();


</script>
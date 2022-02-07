<?php
include("../sesi.php");
?>
<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeCK()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">CARA KELUAR</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr> 
		<td colspan="2" align="left">Cara Keluar</td>
        <td align="left">:</td>
        <td align="left"><textarea id="txtCaraKeluar" name="txtCaraKeluar" cols="40"></textarea></td>
    </tr>
	<tr> 
        <td colspan="2" align="left">Status</td>
        <td align="left">:</td>
        <td align="left"><input id="status" name="status" type="checkbox" value="1"/></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">Flag</td>
        <td align="left">:</td>
        <td align="left"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" tabindex="3" value="<?php echo $flag; ?>"/></td>
    </tr>
    <tr>
    	<td colspan="4" align="center"><input type="hidden" id="id_cara_keluar" name="id_cara_keluar" />
                <button type="button" id="btnSimpanCK" name="btnSimpanCK" value="tambah" onClick="saveCK(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteCK" name="btnDeleteCK" onClick="deleteCK()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalCK" name="btnBatalCK" onClick="batalCK()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button></td>
    </tr>
	<tr>
    	<td colspan="4" align="center"><div id="gbCK" style="width:450px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pgCK" style="width:450px;"></div></td>
    </tr>
</table>


<script>
gCK=new DSGridObject("gbCK");
gCK.setHeader("DAFTAR CARA KELUAR");
gCK.setColHeader("NO,NAMA,STATUS");
gCK.setIDColHeader(",,");
gCK.setColWidth("30,150,80");
gCK.setCellAlign("center,left,left");
gCK.setCellHeight(20);
gCK.setImgPath("../icon");
gCK.setIDPaging("pgCK");
gCK.attachEvent("onRowClick","ambilCK");
gCK.baseURL("cara_keluar_util.php");
gCK.Init();


</script>
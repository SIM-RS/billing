<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeRA()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">KLASIFIKASI</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="left">Kode</td>
      <td align="left">:</td>
      <td align="left"><input width="100px" type="text" id="kode_klasifikasi" name="kode_klasifikasi" /></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">Klasifikasi</td>
        <td align="left">:</td>
        <td align="left"><textarea id="txtRiwayatAlergi" name="txtRiwayatAlergi" cols="40"></textarea></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">Status</td>
        <td align="left">:</td>
        <td align="left"><input id="status" name="status" type="checkbox" value="1"/></td>
    </tr>
    <tr>
    	<td colspan="4" align="center"><input type="hidden" id="id_klasifikasi" name="id_klasifikasi" />
                <button type="button" id="btnSimpanRA" name="btnSimpanRA" value="tambah" onClick="saveRA(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteRA" name="btnDeleteRA" onClick="deleteRA()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalRA" name="btnBatalRA" onClick="batalRA()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button></td>
    </tr>
	<tr>
    	<td colspan="4" align="center"><div id="gbRA" style="width:450px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pgRA" style="width:450px;"></div></td>
    </tr>
</table>


<script>
gRA=new DSGridObject("gbRA");
gRA.setHeader("DAFTAR KLASIFIKASI");
gRA.setColHeader("NO,KODE,NAMA,STATUS");
gRA.setIDColHeader(",kode,nama,");
gRA.setColWidth("30,50,150,80");
gRA.setCellAlign("center,left,left,left");
gRA.setCellHeight(20);
gRA.setImgPath("../icon");
gRA.setIDPaging("pgRA");
gRA.attachEvent("onRowClick","ambilRA");
gRA.baseURL("klasifikasi_util.php");
gRA.Init();


</script>
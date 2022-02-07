<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeRA()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">RIWAYAT ALERGI PASIEN</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr> 
        <td colspan="4" align="center"><textarea id="txtRiwayatAlergi" name="txtRiwayatAlergi" cols="40"></textarea></td>
    </tr>
    <tr>
    	<td colspan="4" align="center"><input type="hidden" id="id_riwayat_alergi" name="id_riwayat_alergi" />
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
gRA.setHeader("DAFTAR RIWAYAT ALERGI");
gRA.setColHeader("NO,TGL,RIWAYAT ALERGI");
gRA.setIDColHeader(",,");
gRA.setColWidth("30,70,150");
gRA.setCellAlign("center,center,left");
gRA.setCellHeight(20);
gRA.setImgPath("../icon");
gRA.setIDPaging("pgRA");
gRA.onLoaded(konfirmasi12);
gRA.attachEvent("onRowClick","ambilRA");
gRA.baseURL("riwayat_alergi_util.php?idpasien=0");
gRA.Init();

function konfirmasi12(key,val){
	//alert(gRA.getMaxRow());
	jQuery("#loadGambar").load("gambar1.php?id_pasien="+getIdPasien);
}
</script>
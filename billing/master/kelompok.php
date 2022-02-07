<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeRB()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">KELOMPOK TINDAKAN</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="left">Klasifikasi</td>
      <td align="left">:</td>
      <td align="left"><select id="klasi" name="klasi" class="txtinput" onchange="ganti111()"><?php
      $rs = mysql_query("SELECT * FROM b_ms_klasifikasi WHERE aktif=1");
            	while($rows=mysql_fetch_array($rs)):
		?>
			<option id="<?=$rows["id"]?>" value="<?=$rows["id"]?>" ><?=$rows["nama"]?></option>
            <?	endwhile;
	  ?></select></td>
    </tr>
    <tr>
      <td colspan="2" align="left">Kode</td>
      <td align="left">:</td>
      <td align="left"><input width="100px" type="text" id="kode_kelompok" name="kode_kelompok" /></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">Kelompok Tindakan</td>
        <td align="left">:</td>
        <td align="left"><textarea id="kelompok_tindakan" name="kelompok_tindakan" cols="40"></textarea></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">Status</td>
        <td align="left">:</td>
        <td align="left"><input id="status_tindakan" name="status_tindakan" type="checkbox" value="1"/></td>
    </tr>
    <tr>
    	<td colspan="4" align="center"><input type="hidden" id="id_kelompok" name="id_kelompok" />
                <button type="button" id="btnSimpanRB" name="btnSimpanRB" value="tambah" onClick="saveRB(this.value)" style="cursor:pointer">
                    <img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Add</span>
                </button>
                <button type="button" id="btnDeleteRB" name="btnDeleteRB" onClick="deleteRB()" style="cursor:pointer">
                    <img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Delete</span>
                </button>
                <button type="button" id="btnBatalRB" name="btnBatalRB" onClick="batalRB()" style="cursor:pointer">
                    <img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
                    <span style="margin-left:20px;">Cancel</span>
                </button></td>
    </tr>
	<tr>
    	<td colspan="4" align="center"><div id="gbRB" style="width:450px; height:150px; padding-bottom:20px; background-color:white;"></div>
                <div id="pgRB" style="width:450px;"></div></td>
    </tr>
</table>


<script>
gRB=new DSGridObject("gbRB");
gRB.setHeader("DAFTAR KELOMPOK TINDAKAN");
gRB.setColHeader("NO,KLASIFIKASI,KODE,NAMA,STATUS");
gRB.setIDColHeader(",,kode,nama,");
gRB.setColWidth("30,100,100,150,80");
gRB.setCellAlign("center,left,left,left,left");
gRB.setCellHeight(20);
gRB.setImgPath("../icon");
gRB.setIDPaging("pgRB");
gRB.attachEvent("onRowClick","ambilRB");
gRB.baseURL("kelompok_util.php?klasifikasi="+document.getElementById("klasi").value);
gRB.Init();


</script>
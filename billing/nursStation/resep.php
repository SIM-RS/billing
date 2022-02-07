<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr class="resep1">
		<td align="right"><button id="btnTmbh" disabled="disabled" name="btnTmbh" type="button" onclick="tambahResep()"><img src="../icon/add.gif" width="16" height="16" />&nbsp;Tambah</button>&nbsp;<button id="btnEditResep" name="btnEditResep" type="button" onclick="editResep()"><img src="../icon/edit.gif" width="16" height="16" />&nbsp;Ubah</button>&nbsp;<BUTTON id="btnDosis" type="button" onClick="OpenDosis();"><IMG SRC="../icon/printer.png" width="16" height="16">&nbsp;Cetak 
                  Resep</BUTTON></td>
	</tr>
	<tr>
		<td><div id="gridboxResepAwal" style="width:850px; height:100px; background-color:white;"></div>
            <br>
            <!--div id="pagingResepAwal" style="width:850px;"></div></td-->
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
    <tr class="resep1" style="visibility:collapse">
    	<td align="right"><button id="btnSave" name="btnSave" type="button" onclick="saveResep()"><img src="../icon/save.gif" width="16" height="16" />&nbsp;Simpan</button></td>
    </tr>
	<tr>
		<td>
			<div id="detail_resep" style="display:none">
				<div id="gridboxResepDetail" style="width:850px; height:130px; background-color:white;"></div>
				<!--br>
				<div id="pagingResepDetail" style="width:850px;"></div-->
			</div>
            <input name="tot_harga" type="hidden" id="tot_harga" size="17" value="0" class="txtright" readonly="true" />
		</td>
	</tr>
</table>
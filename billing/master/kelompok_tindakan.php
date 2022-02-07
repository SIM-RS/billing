<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="display:none;" />

<table>
	<tr>
    	<td colspan="4"><img alt="close" src="../icon/x.png" width="32" onClick="closeRA()" style="float:right; cursor: pointer" /></td>
    </tr>
	<tr>
        <td colspan="4" align="center" style="font-size:16px; font-weight:bold; text-decoration:underline">KELOMPOK PEMERIKSAAN</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <!--<tr> 
        <td colspan="4" align="center"><textarea id="txtRiwayatAlergi" name="txtRiwayatAlergi" cols="40"></textarea></td>
    </tr>-->
    <tr> 
        <td colspan="2" align="left">&nbsp;Klasifikasi</td>
        <td colspan="2" align="left">&nbsp;:
        <select id="kelompok" class="txtinput" name="kelompok">
        <?
			$sqlK = "SELECT * FROM b_ms_klasifikasi WHERE aktif = 1";
			$rsqlK = mysql_query($sqlK);
			while($dsqlK = mysql_fetch_array($rsqlK))
			{
				?>
                	<option id="<? echo $dsqlK['id'];?>" value="<? echo $dsqlK['id'];?>"><? echo $dsqlK['nama'];?></option>
                <?
			}
		?>
        </select>
        <input type="hidden" id="idKlasifikasi" class="idKlasifikasi" />
        </td>
    </tr>
    <tr> 
        <td colspan="2" align="left">&nbsp;Kode</td>
        <td colspan="2" align="left">&nbsp;:&nbsp;<input type="text" id="kode" name="nama" class="txtinput" size="10" /></td>
    </tr>
    <tr> 
        <td colspan="2" align="left">&nbsp;Nama</td>
        <td colspan="2" align="left">&nbsp;:&nbsp;<input type="text" id="nama" name="nama" class="txtinput" size="40" />&nbsp;
        <input type="checkbox" id="aktif" class="txtInput" name="aktif" value="1" /> Aktif
        </td>
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

</script>
<?php
//include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
?><table width="800" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td width="40%">&nbsp;</td>
  	<td height="30" width="70%">&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Nama Pemeriksaan&nbsp;</td>
	<td>&nbsp;<input id="txtTind" name="txtTind" size="50" onKeyUp="suggest1(event,this);" class="txtinput" />
			<input name="tindakan_id" id="tindakan_id" type="hidden" />
			<div id="divtindakan" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
	  
			</td>
  </tr>
  <tr>
    <td align="right">Jenis Kelamin&nbsp;</td>
  	<td>&nbsp;<select id="lp" class="txtinput" style="width:120px"><option value="l">Laki-laki</option><option value="p">Perempuan</option></select></td>
  </tr>
  <tr>
  	<td align="right">Satuan&nbsp;</td>
	<td>&nbsp;<select id="satid" class="txtinput" style="width:120px">
	<?
	
	$sql = "select * from b_ms_satuan_lab where aktif = 1 order by nama_satuan";
	$r = mysql_query($sql);
	while($t = mysql_fetch_array($r))
	{
		echo "<option value='$t[id]'>$t[nama_satuan]</option>";
	}
	?>
	</select></td>
  </tr>
  <tr>
  	<td align="right">Metode&nbsp;</td>
	<td>&nbsp;<input type="text" class="txtinput" id="metode" size="20" /></td>
  </tr>
  <tr>
  	<td align="right">Nilai Normal&nbsp;</td>
	<td>&nbsp;<input type="text" class="txtinput" id="normal1" size="10" /> s/d <input type="text" class="txtinput" id="normal2" size="10" /></td>
  </tr>
  
  <tr>
    <td height="30" colspan="2" align="center">
		<input type="hidden" name="id_normal" id="id_normal" />
		<input type="button" id="btnSimpanTrf" name="btnSimpanTrf" value="Tambah" onclick="simpan(this.value,this.id,'tindakan_id');" class="tblTambah"/>
		<input type="button" id="btnHapusTrf" name="btnHapusTrf" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
	<input type="button" id="btnBatalTrf" name="btnBatalTrf" value="Batal" onclick="batal(this.id)" class="tblBatal"/>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="2">
		<div id="gridboxtab2" style="width:750px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab2" style="width:750px;"></div>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
include("../koneksi/konek.php");
?>
<?php
session_start();
include("../sesi.php");
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7" align="center">
		<br/>
		<input type="hidden" id="id"/>
		<table width="500" cellpadding="5">
			<tr>
				<td width="50">Dokter</td>
				<td>: 
					<select id="dokter_id" class="txtinput">
						<?php
						$sql = "select id, nama from b_ms_pegawai where aktif = 1 and spesialisasi_id != 0";
						$query = mysql_query($sql);
						while($rows = mysql_fetch_assoc($query)){
							?>
							<option value="<?php echo $rows['id']; ?>"><?php echo $rows['nama']; ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Hari</td>
				<td>: 
					<select id="hari" class="txtinput">
						<option value="1">Senin</option>
						<option value="2">Selasa</option>
						<option value="3">Rabu</option>
						<option value="4">Kamis</option>
						<option value="5">Jum'at</option>
						<option value="6">Sabtu</option>
						<option value="7">Minggu</option>
					</select>
				</td>
			</tr>
			<!-- <tr>
				<td>Flag</td>
				<td>:  -->
				<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="35" tabindex="3" value="<?php echo $flag; ?>"/>
				<!-- </td>
			</tr> -->
			<tr>
				<td>Waktu</td>
				<td>: 
					<input type="text" id="mulai" class="txtinput" style="width: 50px;"/> - 
					<input type="text" id="selesai" class="txtinput" style="width: 50px;"/> <em>format 24:00</em>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="button" value="Tambah" id="btnTambah" class="tblTambah" onclick="simpan()"/>
					<input type="button" value="Hapus" id="btnHapus" disabled="disabled" class="tblHapus" onclick="hapus()"/>
					<input type="button" value="Batal" class="tblBatal" onclick="batal()"/>
				</td>
			</tr>
		</table>
		<br/><br/>
	</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan</td>
    <td width="25%">&nbsp;<select id="cmbJnsLay" class="txtinput" onchange="isiTmpLay();">			 
		  </select></td>
    <td width="10%">&nbsp;</td>
    <td width="20%" align="right">Tempat Layanan</td>
    <td width="20%">&nbsp;<select id="TmpLayanan" class="txtinput" lang="" onchange="ubahUnit();"></select></td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridboxtab1" style="width:900px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab1" style="width:900px;"></div>
		</td>
  	<td>&nbsp;</td>
  </tr>
  </table>
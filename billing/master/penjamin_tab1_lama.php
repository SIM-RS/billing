<?php
//session_start();
include_once("../koneksi/konek.php");
?><table width="900" border="0" cellspacing="1" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kode Penjamin </td>
    <td>&nbsp;<input size="32" id="txtKodePenjamin" name="txtKodePenjamin" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Nama Penjamin&nbsp;</td>
    <td>&nbsp;<input size="32" id="txtPenjamin" name="txtPenjamin" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Kepemilikan Resep&nbsp;</td>
    <td>&nbsp;<select id="idKepemilikan" name="idKepemilikan" class="txtinput">
    	<?php 
		$sql="SELECT * FROM $dbapotek.a_kepemilikan WHERE AKTIF=1";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
    	<option class="txtinput" value="<?php echo $rw['ID']; ?>"><?php echo $rw['NAMA']; ?></option>
        <?php 
		}
		?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Alamat&nbsp;</td>
    <td>&nbsp;<input size="32" id="txtAlmt" name="txtAlmt" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Telepon&nbsp;</td>
    <td>&nbsp;<input id="txtTlp" name="txtTlp" size="24" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Fax&nbsp;</td>
    <td>&nbsp;<input id="txtFax" name="txtFax" size="24" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Kontak&nbsp;</td>
    <td>&nbsp;<input id="txtKontak" name="txtKontak" size="32" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Aktif&nbsp;</td>
    <td>&nbsp;<input id="chkAktif" name="chkAktif" type="checkbox" checked="checked" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
    <td height="30">
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" style="padding-right:50px;" height="28"><button id="btnDet" name="btnDet" onclick="detKso()" style="display:none;"><img src="../icon/next.gif" width="12" height="12" />&nbsp;Daftar Pasien</button></td>
  </tr>
  <tr>
	<td width="5%">&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:900px; height:200px; background-color:white;"></div>
		<div id="paging" style="width:900px;"></div>	</td>
    <td width="5%">&nbsp;</td>
  </tr>  
 
  </table>
  
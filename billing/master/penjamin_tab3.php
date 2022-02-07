<?php
//session_start();
session_start();
include("../sesi.php");
include_once("../koneksi/konek.php");
?><table width="850" border="0">
   <tr>
      <td width="10%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
      <td width="60%">&nbsp;</td>
      <td width="10%">&nbsp;</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
      <td align="right">Penjamin : </td>
      <td align="left"><select id="cmbKsoHP" class="txtinput" onchange="loadPaketHP()"></select></td>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td></td>
      <td align="right">Kelas : </td>
      <td align="left">
         <select id="cmbKelasHP" class="txtinput"></select>
      </td>
      <td></td>
   </tr>
   <tr>
      <td></td>
      <td align="right">Nilai Jaminan : </td>
      <td align="left">
         <input type="text" id="txtNilaiJamin" class="txtinput"/>
      </td>
      <td></td>
   </tr>
   <!-- <tr>
      <td></td>
      <td align="right">Flag : </td>
      <td align="left"> -->
      <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="10" tabindex="3" value="<?php echo $flag; ?>"/>
      <!-- </td>
      <td></td>
   </tr> -->
    <tr>
    <td></td>
    <td>&nbsp;</td>	
    <td>
      <input id="txtIdHP" type="hidden" name="txtIdHP" />
		<input type="button" id="btnSimpanHP" name="btnSimpanHP" value="Tambah" onclick="simpanHP(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapusHP" name="btnHapusHP" value="Hapus" onclick="hapusHP();" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatalHP" name="btnBatalHP" value="Batal" onclick="batalHP()" class="tblBatal"/>
	</td>
    <td>&nbsp;</td>
  </tr>
   <tr>     
      <td></td>
      <td align="center" colspan="2">
         <fieldset><legend>Kelas</legend>
          <div id="gridbox5" style="width:600px; height:250px;"></div>
		<div id="paging5" style="width:600px;"></div>
            </fieldset>
      </td>
      <td></td>
   </tr>
</table>
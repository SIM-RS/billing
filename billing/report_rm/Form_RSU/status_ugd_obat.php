<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_ms_status_ugd_obat WHERE ugd_id='$id'");




//====================================================================
//$type=$_REQUEST['type'];

?><table width="1061" height="122" border="1" align="center" class="tanggal" id="tblObat" style="border-collapse:collapse">
  <tr bgcolor="#ababab">
    <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF"><input name="button2" type="button"  value="Tambah" class="tblTambah" onclick="addRowToTable();return false;"/></td>
  </tr>
  <tr bgcolor="#ababab">
    <td width="159" align="center" bgcolor="#CCFF33">Tanggal</td>
    <td width="144" align="center" bgcolor="#CCFF33">Jam</td>
    <td width="144" align="center" bgcolor="#CCFF33">Nama Obat </td>
    <td width="144" align="center" bgcolor="#CCFF33">Dosis</td>
    <td width="136" align="center" bgcolor="#CCFF33">Cara Pemberian </td>
    <td width="151" align="center" bgcolor="#CCFF33">Nama Dokter</td>
    <td width="60" align="center" bgcolor="#CCFF33">&nbsp;</td>
  </tr>
  
  <?
if(empty($id)){
?>
  <tr>
    <td><div align="center">
      <input name='tgll[]' type='text' class="tgl" id='tgll[]' size="20" onclick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);" />
    </div></td>
    <td><div align="center">
      <input name="jam2[]" type='text' class="jam" id="jam2[]" size="20" />
    </div></td>
    <td><div align="center">
      <input name="obat[]" type='text' id="obat[]"/>
    </div></td>
    <td><div align="center">
      <input name="dosis[]" type='text' id="dosis[]" size="20"/>
    </div></td>
    <td><div align="center">
      <input name="pemberian[]" type='text' id="pemberian[]" size="20"/>
    </div></td>
    <td><div align="center">
      <input name='nama2[]' type="text" id="nama2[]" size="20" />
    </div></td>
    <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
 
 
  </tr>
      <?
}else{ while($dt=mysql_fetch_array($sql)){
?>
      <tr>
        <td><div align="center">
      <input name='tgll[]' type='text' class="tgl" id='tgll[]' size="20" onclick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);"  value="<?=$dt['tanggal']?>"/>
    </div></td>
    <td><div align="center">
      <input name="jam2[]" type='text' class="jam" id="jam2[]" size="20"  value="<?=$dt['jam']?>"/>
    </div></td>
    <td><div align="center">
      <input name="obat[]" type='text' id="obat[]" value="<?=$dt['obat']?>"/>
    </div></td>
    <td><div align="center">
      <input name="dosis[]" type='text' id="dosis[]" size="20"  value="<?=$dt['dosis']?>"/>
    </div></td>
    <td><div align="center">
      <input name="pemberian[]" type='text' id="pemberian[]" size="20"  value="<?=$dt['pemberian']?>"/>
    </div></td>
    <td><div align="center">
      <input name='nama2[]' type="text" id="nama2[]" size="20"  value="<?=$dt['paraf_nama']?>"/>
    </div></td>
		
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
         </tr> 
    <?
}}
?>
    </table>
	
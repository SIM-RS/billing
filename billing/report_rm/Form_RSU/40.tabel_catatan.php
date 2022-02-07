<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_form_catatan_penghitung_detail WHERE id_form_catatan_penghitung='$id'");
//====================================================================
//$type=$_REQUEST['type'];

?>

<table width="1060" border="1" id="tblkegiatan" cellpadding="2" style="border-collapse:collapse;">
<tr style="background:#338FC1">
  <td colspan="12" align="right"><input type="button" name="button" id="button" value="Tambah" onclick="addRowToTable();return false;"/></td>
</tr>
<tr style="background:#6CF">
  <td width="228" align="center"><strong>JENIS</strong></td>
  <td width="163" align="center"><strong>JUMLAH AWAL</strong></td>
  <td colspan="5" align="center"><strong>TAMBAHAN</strong></td>
  <td width="149" align="center"><strong>JUMLAH<BR />SEMENTARA*</strong></td>
  <td width="64" align="center"><strong>TAMBAHAN</strong></td>
  <td width="44" align="center"><strong>JUMLAH<BR />AKHIR</strong></td>
  <td width="210" align="center"><strong>KETERANGAN</strong></td>
  <td width="16">&nbsp;</td>
</tr>

<?
if(empty($id)){
?>
<tr>
  <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="35" /></td>
  <td align="center"><input name="j_awal[]" type="text" id="j_awal[]" size="3" /></td>
  <td width="18" align="center"><input name="tambahan1[]" type="text" id="tambahan1[]" size="3" /></td>
  <td width="18" align="center"><input name="tambahan2[]" type="text" id="tambahan2[]" size="3" /></td>
  <td width="18" align="center"><input name="tambahan3[]" type="text" id="tambahan3[]" size="3" /></td>
  <td width="18" align="center"><input name="tambahan4[]" type="text" id="tambahan4[]" size="3" /></td>
  <td width="18" align="center"><input name="tambahan5[]" type="text" id="tambahan5[]" size="3" /></td>
  <td align="center"><input name="j_sementara[]" type="text" id="j_sementara[]" size="7" /></td>
  <td align="center"><input name="tambahan[]" type="text" id="tambahan[]" size="3" /></td>
  <td align="center"><input name="j_akhir[]" type="text" id="j_akhir[]" size="7" /></td>
  <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="50" /></td>
  <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
</tr>
<?
}else{ while($dt=mysql_fetch_array($sql)){
?>
<tr>
  <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="35" value=<?=$dt['jenis'];?> /></td>
  <td align="center"><input name="j_awal[]" type="text" id="j_awal[]" size="3" value=<?=$dt['jumlah_awal'];?> /></td>
  <td width="18" align="center"><input name="tambahan1[]" type="text" id="tambahan1[]" size="3" value=<?=$dt['tambahan1'];?> /></td>
  <td width="18" align="center"><input name="tambahan2[]" type="text" id="tambahan2[]" size="3" value=<?=$dt['tambahan2'];?> /></td>
  <td width="18" align="center"><input name="tambahan3[]" type="text" id="tambahan3[]" size="3" value=<?=$dt['tambahan3'];?> /></td>
  <td width="18" align="center"><input name="tambahan4[]" type="text" id="tambahan4[]" size="3" value=<?=$dt['tambahan4'];?> /></td>
  <td width="18" align="center"><input name="tambahan5[]" type="text" id="tambahan5[]" size="3" value=<?=$dt['tambahan5'];?> /></td>
  <td align="center"><input name="j_sementara[]" type="text" id="j_sementara[]" size="7" value=<?=$dt['jumlah_sementara'];?> /></td>
  <td align="center"><input name="tambahan[]" type="text" id="tambahan[]" size="3" value=<?=$dt['tambahanx'];?> /></td>
  <td align="center"><input name="j_akhir[]" type="text" id="j_akhir[]" size="7" value=<?=$dt['jumlah_akhir'];?> /></td>
  <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="50" value=<?=$dt['keterangan'];?> /></td>
  <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
</tr>

<?
}}
?>
</table>
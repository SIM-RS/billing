<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
//echo $qB="SELECT * FROM lap_travelling_detail WHERE id_traveling = '$id'";
$sql=mysql_query("SELECT DISTINCT id_traveling,terapi FROM b_detil_traveling WHERE id_traveling = '$id'");
//====================================================================
$type=$_REQUEST['type'];

?>

<table width="850" border="1" align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
  <tr bgcolor="#0099FF">
    <td align="right" valign="middle" bgcolor="#0099FF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
    <td align="right" valign="middle" bgcolor="#0099FF">&nbsp;</td>
  </tr>
  <tr bgcolor="#0099FF">
    <td align="center" bgcolor="#33CCFF">Terapi</td>
    <td align="center" bgcolor="#33CCFF">&nbsp;</td>
    </tr>
<?
if(empty($id)){
?>
  <tr>
      <td><input type='text' name="terapi[]" id="terapi[]" size="130"></td>
      <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
        <img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
    </tr>
<?
}else{ while($dt=mysql_fetch_array($sql)){
?>
    <tr>
        <td><input type='text' name="terapi[]" id="terapi[]" size="130" value="<?=$dt['terapi']?>"></td>
        <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
          <img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
    </tr>

<?
}}
?>
</table>
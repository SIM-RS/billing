<?php
include("../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_ms_hemodialisis_detail WHERE id_hemodialisis='$id'");
//====================================================================
$type=$_REQUEST['type'];

?>
<script type="text/JavaScript">
 		
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
</script>

<table border="1" align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
  <tr bgcolor="#0099FF">
    <td colspan="14" align="right" valign="middle" bgcolor="#0099FF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
  </tr>
  <tr bgcolor="#0099FF">
    <td align="center" bgcolor="#33CCFF">Jam</td>
    <td align="center" bgcolor="#33CCFF">TD</td>
    <td align="center" bgcolor="#33CCFF">Nadi</td>
    <td align="center" bgcolor="#33CCFF">RR</td>
    <td align="center" bgcolor="#33CCFF">Suhu</td>
    <td align="center" bgcolor="#33CCFF">QB</td>
    <td align="center" bgcolor="#33CCFF">UF Goal</td>
    <td align="center" bgcolor="#33CCFF">UFR</td>
    <td align="center" bgcolor="#33CCFF">UF</td>
    <td align="center" bgcolor="#33CCFF">Tek Vena</td>
    <td align="center" bgcolor="#33CCFF">TMP</td>
    <td align="center" bgcolor="#33CCFF">Heparin</td>
    <td align="center" bgcolor="#33CCFF">Keterangan</td> 
    <td align="center" bgcolor="#33CCFF">&nbsp;</td>
    </tr>
  <tr>
<?
if(empty($id)){
?>
    <tr>
        <td><input type='text' class="jam" name="jam[]" id="jam[]"></td>
        <td><input type='text' name='td[]' id='td[]' size="3"></td>
        <td><input type='text' name='nadi[]' id='nadi[]' size="3"></td>
        <td><input type='text' name='rr[]' id='rr[]' size="3"></td>
        <td><input type='text' name='suhu[]' id='suhu[]' size="3"></td>
        <td><input type='text' name='qb[]' id='qb[]' size="3"></td>
        <td><input type='text' name='ufg[]' id='ufg[]' size="3"></td>
        <td><input type='text' name='ufr[]' id='ufr[]' size="3"></td>
        <td><input type='text' name='uf[]' id='uf[]' size="3"></td>
        <td><input type='text' name='tek[]' id='tek[]' size="3"></td>
        <td><input type='text' name='tmp[]' id='tmp[]' size="3"></td>
        <td><input type='text' name='heparin[]' id='heparin[]' size="3"></td>
        <td>
        <!--<input type='text' name='keterangan[]' id='keterangan[]' size="25">-->
        <textarea id="keterangan[]" name="keterangan[]" cols="25" rows="1"></textarea>
        </td>
        <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
          <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
    </tr>
<?
}else{ while($dt=mysql_fetch_array($sql)){
?>
    <tr>
        <td><input type='text' class="jam" name="jam[]" id="jam[]" value="<?=$dt['t_jam']?>"></td>
        <td><input type='text' name='td[]' id='td[]' size="3" value="<?=$dt['t_td']?>"></td>
        <td><input type='text' name='nadi[]' id='nadi[]' size="3" value="<?=$dt['t_nadi']?>"></td>
        <td><input type='text' name='rr[]' id='rr[]' size="3" value="<?=$dt['t_rr']?>"></td>
        <td><input type='text' name='suhu[]' id='suhu[]' size="3" value="<?=$dt['t_suhu']?>"></td>
        <td><input type='text' name='qb[]' id='qb[]' size="3" value="<?=$dt['t_qb']?>"></td>
        <td><input type='text' name='ufg[]' id='ufg[]' size="3" value="<?=$dt['t_ufg']?>"></td>
        <td><input type='text' name='ufr[]' id='ufr[]' size="3" value="<?=$dt['t_ufr']?>"></td>
        <td><input type='text' name='uf[]' id='uf[]' size="3" value="<?=$dt['t_uf']?>"></td>
        <td><input type='text' name='tek[]' id='tek[]' size="3" value="<?=$dt['t_tekvena']?>"></td>
        <td><input type='text' name='tmp[]' id='tmp[]' size="3" value="<?=$dt['t_tmp']?>"></td>
        <td><input type='text' name='heparin[]' id='heparin[]' size="3" value="<?=$dt['t_heparin']?>"></td>
        <td>
        <!--<input type='text' name='keterangan[]' id='keterangan[]' size="25" value="<?=$dt['t_keterangan']?>">-->
        <textarea id="keterangan[]" name="keterangan[]" cols="25" rows="1" value="<?=$dt['t_keterangan']?>"><?=$dt['t_keterangan']?></textarea>
        </td>
        <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
          <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
    </tr>

<?
}}
?>
</table>
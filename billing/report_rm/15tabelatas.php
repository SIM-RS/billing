<?php
include("../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_fom_rekam_medis_hd_t1 WHERE rekam_medis_id='$id' order by id");
//====================================================================
$type=$_REQUEST['type'];
$no=1;?>
<script type="text/JavaScript">
/*function jam2(){*/			
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
//}
</script>
<?php
if(empty($type)){
?>
<table width="781" border="1" id="datatable" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="tambahrow();return false;"/></td>
    </tr>
    <tr>
        <td width="158" align="center">Jam</td>
          <td width="38" align="center">TD</td>
          <td width="61" align="center">Nadi</td>
          <td width="54" align="center">Respirasi</td>
          <td width="30" align="center"> Suhu</td>
          <td width="46" align="center">Heparin</td>
          <td width="33" align="center">TMP</td>
          <td width="39" align="center">AP/VP</td>
          <td width="33" align="center">QB</td>
          <td width="33" align="center">UFR</td>
          <td width="33" align="center">UFG</td>
          <td width="89" align="center">Keterangan</td>
          <td width="26">&nbsp;</td>
     </tr>
      <tr>
        <td>
          <input name="jam[]" type="text" class="jam" id="jam[]" size="10"/></td>
          <td align="center"><input name="tdd[]" type="text" id="tdd[]" size="5" /></td>
          <td align="center"><input name="nadi_t1[]" type="text" id="nadi_t1[]" size="5" /></td>
          <td align="center"><input name="respirasi_t1[]" type="text" id="respirasi_t1[]" size="5" /></td>
          <td align="center"><input name="suhu_t1[]" type="text" id="suhu_t1[]" size="5" /></td>
          <td align="center"><input name="heparin[]" type="text" id="heparin[]" size="5" /></td>
          <td align="center"><input name="tmp[]" type="text" id="tmp[]" size="5" /></td>
          <td align="center"><input name="ap[]" type="text" id="ap[]" size="5" /></td>
          <td align="center"><input name="qb[]" type="text" id="qb[]" size="5" /></td>
          <td align="center"><input name="ufr[]" type="text" id="ufr[]" size="5" /></td>
          <td align="center"><input name="ufg[]" type="text" id="ufg[]" size="5" /></td>
          <td align="center"><input name="keterangan[]" type="text" class="inputan" id="keterangan[]" /></td>
          <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang(this);" /></td>
      </tr>
</table>
<?php 	}
	if($type=="ESO"){
		//$sql=mysql_query("SELECT * FROM b_fom_resume_kep_terapi_pulang WHERE resume_kep_id='$id'");
	?>
<table width="781" border="1" id="datatable" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="tambahrow();return false;"/></td>
    </tr>
    <tr>
        <td width="158" align="center">Jam</td>
          <td width="38" align="center">TD</td>
          <td width="61" align="center">Nadi</td>
          <td width="54" align="center">Respirasi</td>
          <td width="30" align="center"> Suhu</td>
          <td width="46" align="center">Heparin</td>
          <td width="33" align="center">TMP</td>
          <td width="39" align="center">AP/VP</td>
          <td width="33" align="center">QB</td>
          <td width="33" align="center">UFR</td>
          <td width="33" align="center">UFG</td>
          <td width="89" align="center">Keterangan</td>
          <td width="26">&nbsp;</td>
     </tr>
      <tr>
           <?php if(empty($id)){ ?>
        <td>
          <input name="jam[]" type="text" class="jam" id="jam[]" size="10"/></td>
          <td align="center"><input name="tdd[]" type="text" id="tdd[]" size="5" /></td>
          <td align="center"><input name="nadi_t1[]" type="text" id="nadi_t1[]" size="5" /></td>
          <td align="center"><input name="respirasi_t1[]" type="text" id="respirasi_t1[]" size="5" /></td>
          <td align="center"><input name="suhu_t1[]" type="text" id="suhu_t1[]" size="5" /></td>
          <td align="center"><input name="heparin[]" type="text" id="heparin[]" size="5" /></td>
          <td align="center"><input name="tmp[]" type="text" id="tmp[]" size="5" /></td>
          <td align="center"><input name="ap[]" type="text" id="ap[]" size="5" /></td>
          <td align="center"><input name="qb[]" type="text" id="qb[]" size="5" /></td>
          <td align="center"><input name="ufr[]" type="text" id="ufr[]" size="5" /></td>
          <td align="center"><input name="ufg[]" type="text" id="ufg[]" size="5" /></td>
          <td align="center"><input name="keterangan[]" type="text" class="inputan" id="keterangan[]" /></td>
          <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang(this);" /></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				//$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <tr>
        <td>
          <input name="jam[]" type="text" class="jam" id="jam[]" size="10" value="<?=$dt['jam']?>"/></td>
        <td align="center"><input name="tdd[]" type="text" id="tdd[]" size="5" value="<?=$dt['tdd']?>"/></td>
        <td align="center"><input name="nadi_t1[]" type="text" id="nadi_t1[]" size="5" value="<?=$dt['nadi_t1']?>"/></td>
        <td align="center"><input name="respirasi_t1[]" type="text" id="respirasi_t1[]" size="5" value="<?=$dt['respirasi_t1']?>"/></td>
        <td align="center"><input name="suhu_t1[]" type="text" id="suhu_t1[]" size="5" value="<?=$dt['suhu_t1']?>"/></td>
        <td align="center"><input name="heparin[]" type="text" id="heparin[]" size="5" value="<?=$dt['heparin']?>"/></td>
        <td align="center"><input name="tmp[]" type="text" id="tmp[]" size="5" value="<?=$dt['tmp']?>"/></td>
        <td align="center"><input name="ap[]" type="text" id="ap[]" size="5" value="<?=$dt['ap']?>"/></td>
        <td align="center"><input name="qb[]" type="text" id="qb[]" size="5" value="<?=$dt['qb']?>"/></td>
        <td align="center"><input name="ufr[]" type="text" id="ufr[]" size="5" value="<?=$dt['ufr']?>"/></td>
        <td align="center"><input name="ufg[]" type="text" id="ufg[]" size="5" value="<?=$dt['ufg']?>"/></td>
        <td align="center"><input name="keterangan[]" type="text" class="inputan" id="keterangan[]" value="<?=$dt['keterangan']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang(this);" /></td>
      </tr> 
      <?php }
		$no++;
	  }
	  ?>
    </table>
    <?php 
	}?>

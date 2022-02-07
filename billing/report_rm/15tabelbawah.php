<?php
include("../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_fom_rekam_medis_hd_t2 WHERE rekam_medis_id='$id' order by id");
//====================================================================
$type=$_REQUEST['type'];
$no=1;?>
<script type="text/JavaScript">
/*function jam2(){*/			
	$(function () {
	$('.jam2').timeEntry({show24Hours: true, showSeconds: true});
});
//}
</script>
<?php
if(empty($type)){
?>
<table width="781" border="1" id="datatable2" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="4" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="tambahrow2();return false;"/></td>
    </tr>
    <tr>
        <td width="63" align="center">Jam</td>
            <td width="471" align="center">Saran Dokter</td>
            <td width="178" align="center">TTD/Nama Perawat</td>
            <td width="33">&nbsp;</td>
     </tr>
      <tr>
        <td valign="middle"><input name="jam2[]" type="text" class="jam2" id="jam2[]" size="10"/></td>
            <td align="center"><textarea name="saran[]" cols="70" rows="3" id="saran[]"></textarea></td>
            <td align="center">&nbsp;</td>
            <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang2(this);" /></td>
      </tr>
</table>
<?php 	}
	if($type=="ESO"){
		//$sql=mysql_query("SELECT * FROM b_fom_resume_kep_terapi_pulang WHERE resume_kep_id='$id'");
	?>
<table width="781" border="1" id="datatable2" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="4" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="tambahrow2();return false;"/></td>
    </tr>
    <tr>
        <td width="63" align="center">Jam</td>
            <td width="471" align="center">Saran Dokter</td>
            <td width="178" align="center">TTD/Nama Perawat</td>
            <td width="33">&nbsp;</td>
     </tr>
      <tr>
           <?php if(empty($id)){ ?>
        <td valign="middle"><input name="jam2[]" type="text" class="jam2" id="jam2[]" size="10"/></td>
            <td align="center"><textarea name="saran[]" cols="70" rows="3" id="saran[]"></textarea></td>
            <td align="center">&nbsp;</td>
            <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang2(this);" /></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				//$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <tr>
        <td valign="middle"><input name="jam2[]" type="text" class="jam2" id="jam2[]" size="10" value="<?=$dt['jam2']?>"/></td>
            <td align="center"><textarea name="saran[]" cols="70" rows="3" id="saran[]"><?=$dt['saran']?></textarea></td>
            <td align="center">&nbsp;</td>
            <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="hilang2(this);" /></td>
      </tr> 
      <?php }
		$no++;
	  }
	  ?>
    </table>
    <?php 
	}?>

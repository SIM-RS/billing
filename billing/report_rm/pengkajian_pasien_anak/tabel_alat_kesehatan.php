<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_ms_pengkajian_pasien_anak1 WHERE pengkajian_id='$id'");
//====================================================================
$type=$_REQUEST['type'];
$no=1;
if(empty($type)){
?>
<table width="554" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
    </tr>
    <tr>
        <td align="center">Jenis</td>
        <td align="center">Keterangan</td>
        <td align="center">Jenis</td>
        <td align="center">Keterangan</td>
        <td>&nbsp;</td>
     </tr>
     <tr>
          <?php if(empty($id)){ ?>
       <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="15" /></td>
       <td align="center"><input name="keterangan1[]" type="text" id="keterangan1[]" size="25" /></td>
       <td align="center"><input name="jenis2[]" type="text" id="jenis2[]" size="15" /></td>
       <td align="center"><input name="keterangan2[]" type="text" id="keterangan2[]" size="25" /></td>
       <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				
			 ?>
      <tr>
        <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="15" value="<?=$dt['jenis']?>"/></td>
        <td align="center"><input name="keterangan1[]" type="text" id="keterangan1[]" size="25" value="<?=$dt['keterangan1']?>"/></td>
        <td align="center"><input name="jenis2[]" type="text" id="jenis2[]" size="15" value="<?=$dt['jenis2']?>" /></td>
        <td align="center"><input name="keterangan2[]" type="text" id="keterangan2[]" value="<?=$dt['keterangan2']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		
	  }
	  ?>
    </table>
    <?php }
	
	if($type=="ESO"){
		$sql=mysql_query("SELECT * FROM b_ms_pengkajian_pasien_anak1 WHERE pengkajian_id='$id'");
	?>
<table width="554" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
    </tr>
    <tr>
        <td align="center">Jenis</td>
        <td align="center">Keterangan</td>
        <td align="center">Jenis</td>
        <td align="center">Keterangan</td>
        <td>&nbsp;</td>
     </tr>
     <tr>
          <?php if(empty($id)){ ?>
       <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="15" /></td>
       <td align="center"><input name="keterangan1[]" type="text" id="keterangan1[]" size="25" /></td>
       <td align="center"><input name="jenis2[]" type="text" id="jenis2[]" size="15" /></td>
       <td align="center"><input name="keterangan2[]" type="text" id="keterangan2[]" size="25" /></td>
       <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				
			 ?>
      <tr>
        <td align="center"><input name="jenis[]" type="text" id="jenis[]" size="15" value="<?=$dt['jenis']?>"/></td>
        <td align="center"><input name="keterangan1[]" type="text" id="keterangan1[]" size="25" value="<?=$dt['keterangan1']?>"/></td>
        <td align="center"><input name="jenis2[]" type="text" id="jenis2[]" size="15" value="<?=$dt['jenis2']?>" /></td>
        <td align="center"><input name="keterangan2[]" type="text" id="keterangan2[]" size="25" value="<?=$dt['keterangan2']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		$no++;
	  }
	  ?>
    </table>
    <?php 

	
	}?>

<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_ms_pengkajian_pasien_anak2 WHERE pengkajian_id='$id'");
//====================================================================
$type=$_REQUEST['type'];
$no=1;
if(empty($type)){
?>
<table width="554" border="1" id="tblObat2" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable2();return false;"/></td>
    </tr>
    <tr>
        <td align="center">Jenis Pemeriksaan</td>
        <td align="center">Bagian Yang Diperiksa</td>
        <td align="center">&sum; Lembar</td>
        <td align="center">Keterangan</td>
        <td>&nbsp;</td>
     </tr>
     <tr>
          <?php if(empty($id)){ ?>
       <td align="center"><input name="jenis_pemeriksaan[]" type="text" id="jenis_pemeriksaan[]" size="15" /></td>
       <td align="center"><input name="bagian[]" type="text" id="bagian[]" size="25" /></td>
       <td align="center"><input name="lembar[]" type="text" id="lembar[]" size="15" /></td>
       <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
       <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				
			 ?>
      <tr>
        <td align="center"><input name="jenis_pemeriksaan[]" type="text" id="jenis_pemeriksaan[]" size="15" value="<?=$dt['jenis_pemeriksaan']?>"/></td>
        <td align="center"><input name="bagian[]" type="text" id="bagian[]" size="25" value="<?=$dt['bagian']?>"/></td>
        <td align="center"><input name="lembar[]" type="text" id="lembar[]" size="15" value="<?=$dt['lembar']?>" /></td>
        <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" value="<?=$dt['keterangan']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		
	  }
	  ?>
    </table>
    <?php }
	
	if($type=="ESO2"){
		$sql=mysql_query("SELECT * FROM b_ms_pengkajian_pasien_anak2 WHERE pengkajian_id='$id'");
	?>
<table width="554" border="1" id="tblObat2" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable2();return false;"/></td>
    </tr>
    <tr>
        <td align="center">Jenis Pemeriksaan</td>
        <td align="center">Bagian Yang Diperiksa</td>
        <td align="center">&sum; Lembar</td>
        <td align="center">Keterangan</td>
        <td>&nbsp;</td>
     </tr>
     <tr>
          <?php if(empty($id)){ ?>
       <td align="center"><input name="jenis_pemeriksaan[]" type="text" id="jenis_pemeriksaan[]" size="15" /></td>
       <td align="center"><input name="bagian[]" type="text" id="bagian[]" size="25" /></td>
       <td align="center"><input name="lembar[]" type="text" id="lembar[]" size="15" /></td>
       <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
       <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				
			 ?>
      <tr>
        <td align="center"><input name="jenis_pemeriksaan[]" type="text" id="jenis_pemeriksaan[]" size="15" value="<?=$dt['jenis_pemeriksaan']?>"/></td>
        <td align="center"><input name="bagian[]" type="text" id="bagian[]" size="25" value="<?=$dt['bagian']?>"/></td>
        <td align="center"><input name="lembar[]" type="text" id="lembar[]" size="15" value="<?=$dt['lembar']?>" /></td>
        <td align="center"><input name="keterangan[]" type="text" id="keterangan[]" size="25" value="<?=$dt['keterangan']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="del.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		$no++;
	  }
	  ?>
    </table>
    <?php 

	
	}?>

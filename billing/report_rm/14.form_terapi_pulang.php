<?php
include("../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_fom_resume_kep_terapi_pulang WHERE resume_kep_id='$id'");
//====================================================================
$type=$_REQUEST['type'];
$no=1;
if(empty($type)){
?>
<table width="781" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
    </tr>
    <tr>
        <td rowspan="2" align="center">Nama Obat</td>
        <td rowspan="2" align="center">Jumlah</td>
        <td rowspan="2" align="center">Dosis</td>
        <td rowspan="2" align="center">Frekuensi</td>
        <td rowspan="2" align="center">Cara Pemberian</td>
        <td colspan="6" align="center">Jam Pemberian</td>
        <td rowspan="2" align="center">Petunjuk Khusus</td>
        <td rowspan="2">&nbsp;</td>
     </tr>
     <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
           <?php if(empty($id)){ ?>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" /></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" /></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" /></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" /></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" /></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <tr>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" value="<?=$dt['nama_obat']?>"/></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" value="<?=$dt['jml']?>" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" value="<?=$dt['dosis']?>"/></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" value="<?=$dt['frekuensi']?>"/></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" value="<?=$dt['cara_beri']?>" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" value="<?=$txt_jam[0]?>"/></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" value="<?=$txt_jam[1]?>"/></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" value="<?=$txt_jam[2]?>"/></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" value="<?=$txt_jam[3]?>"/></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" value="<?=$txt_jam[4]?>"/></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" value="<?=$txt_jam[5]?>"/></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" value="<?=$dt['petunjuk']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		
	  }
	  ?>
    </table>
    <?php }
	
	if($type=="ESO"){
		$sql=mysql_query("SELECT * FROM b_fom_resume_kep_terapi_pulang WHERE resume_kep_id='$id'");
	?>
<table width="781" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
	<tr>
    	<td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
    </tr>
    <tr>
        <td rowspan="2" align="center">Nama Obat</td>
        <td rowspan="2" align="center">Jumlah</td>
        <td rowspan="2" align="center">Dosis</td>
        <td rowspan="2" align="center">Frekuensi</td>
        <td rowspan="2" align="center">Cara Pemberian</td>
        <td colspan="6" align="center">Jam Pemberian</td>
        <td rowspan="2" align="center">Petunjuk Khusus</td>
        <td rowspan="2">&nbsp;</td>
     </tr>
     <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
           <?php if(empty($id)){ ?>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" /></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" /></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" /></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" /></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" /></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
      
        <?php }else{ while($dt=mysql_fetch_array($sql)){
				$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <tr>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" value="<?=$dt['nama_obat']?>"/></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" value="<?=$dt['jml']?>" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" value="<?=$dt['dosis']?>"/></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" value="<?=$dt['frekuensi']?>"/></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" value="<?=$dt['cara_beri']?>" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" value="<?=$txt_jam[0]?>"/></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" value="<?=$txt_jam[1]?>"/></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" value="<?=$txt_jam[2]?>"/></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" value="<?=$txt_jam[3]?>"/></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" value="<?=$txt_jam[4]?>"/></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" value="<?=$txt_jam[5]?>"/></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" value="<?=$dt['petunjuk']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr> 
      <?php }
		$no++;
	  }
	  ?>
    </table>
    <?php 

	
	}?>

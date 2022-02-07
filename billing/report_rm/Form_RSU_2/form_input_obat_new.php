<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_fom_resum_medis_detail_new WHERE resum_medis_id='$id'");
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
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
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
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
      <?php }
		
	  }
	  ?>
    </table>
    <?php }
	
	if($type=="ESO"){
		$sql=mysql_query("SELECT * FROM b_fom_monitoring_eso_detail WHERE monitoring_eso_id='$id'");
	?>
    <table width="869" border="1" cellpadding="3" style="border-collapse:collapse;" id="tblObat">
    <tr><td colspan="10" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="addRowToTable();return false;"/></td>
      </tr>
    <tr>
      <td width="20" rowspan="2" align="center">No</td>
      <td width="213" rowspan="2" align="center">Nama Obat </td>
      <td width="105" rowspan="2" align="center">Bentuk Sedian</td>
      <td width="126" rowspan="2" align="center">Obat Yang dicurigai</td>
      <td colspan="4" align="center">Pemberian</td>
      <td width="136" rowspan="2" align="center">Indikasi Penggunaan</td>
      <td width="16" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="33">&nbsp;</td>
      <td width="37">&nbsp;</td>
      <td width="40">&nbsp;</td>
      <td width="39">&nbsp;</td>
      </tr>
      <?php if(empty($id)){ ?>
    <tr>
      <td align="center">1</td>
      <td align="center"><input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
      <td align="center"><input name="txt_sedia[]" type="text" class="inputan" id="txt_sedia[]" /></td>
      <td align="center"><input name="txt_curiga[]" type="text" class="inputan" id="txt_curiga[]" /></td>
      <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
      <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
      <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
      <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
      <td align="center"><input name="txt_indikasi[]" type="text" class="inputan" id="txt_indikasi[]" /></td>
      <td><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
    </tr>
     <?php }else{ while($dt=mysql_fetch_array($sql)){
				$txt_jam=explode('|',$dt['pemberian']);
			 ?>
    <tr>
      <td align="center"><?=$no?>&nbsp;</td>
      <td align="center"><input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" value="<?=$dt['nama_obat']?>" /></td>
      <td align="center"><input name="txt_sedia[]" type="text" class="inputan" id="txt_sedia[]" value="<?=$dt['bentuk']?>" /></td>
      <td align="center"><input name="txt_curiga[]" type="text" class="inputan" id="txt_curiga[]" value="<?=$dt['obat_curigai']?>" /></td>
      <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" value="<?=$txt_jam[0]?>" size="5" /></td>
      <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" value="<?=$txt_jam[1]?>" size="5" /></td>
      <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" value="<?=$txt_jam[2]?>" size="5" /></td>
      <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" value="<?=$txt_jam[3]?>" size="5" /></td>
      <td align="center"><input name="txt_indikasi[]" type="text" class="inputan" id="txt_indikasi[]" value="<?=$dt['indikasi']?>" /></td>
      <td><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}" /></td>
    </tr>
    <?php 	$no++;
	} 
		
	}
	?>
    </table>
    <?php 

	
	}?>

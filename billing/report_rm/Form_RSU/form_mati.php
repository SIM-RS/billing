<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
//====================================================================
$type=$_REQUEST['type'];
$no=1;
	
	if($type=="MATI"){
		$zz="SELECT * FROM sertifikat_kematian_detail WHERE s_mati_id='$id'";
		//echo $zz;
		$sql=mysql_query($zz);
	?>
    <table border="1" style="width:100%;border-collapse:collapse;" id="tblMati">
  <tr>
    <td colspan="6" align="right"><input type="button" name="button2" id="button2" value="Tambah" onclick="addRowToTable();return false;"/></td>
    </tr>
  <tr>
    <td colspan="4" align="center">Selang waktu terjadinya penyakit sampai	meninggal</td>
    <td colspan="2" rowspan="2" align="center">ICD 10 (Diisi oleh petugas kode)</td>
    </tr>
  <tr>
    <td width="17%" align="center">Tahun</td>
    <td width="16%" align="center">Bulan</td>
    <td width="16%" align="center">Hari</td>
    <td width="20%" align="center">Jam</td>
    </tr>
      <?php if(empty($id)){ ?>
    <tr>
    <td align="center"><input name="thnICD[]" type="text" class="inputan" id="thnICD[]" style="width:30px;"/></td>
    <td align="center"><input name="blnICD[]" type="text" class="inputan" id="blnICD[]" style="width:30px;"/></td>
    <td align="center"><input name="hariICD[]" type="text" class="inputan" id="hariICD[]" style="width:30px;"/></td>
    <td align="center"><input name="jamICD[]" type="text" class="inputan" id="jamICD[]" style="width:50px;"/></td>
    <td width="23%" align="center"><input name="ICD[]" type="text" class="inputan" id="ICD[]" style="width:50px;"/></td>
    <td width="8%" align="center"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}" /></td>
  </tr>
     <?php }else{ while($dt=mysql_fetch_array($sql)){

			 ?>
    <tr>
    <td align="center"><input name="thnICD[]" type="text" class="inputan" id="thnICD[]" style="width:30px;" value="<?=$dt["tahun"]?>"/></td>
    <td align="center"><input name="blnICD[]" type="text" class="inputan" id="blnICD[]" style="width:30px;" value="<?=$dt["bulan"]?>"/></td>
    <td align="center"><input name="hariICD[]" type="text" class="inputan" id="hariICD[]" style="width:30px;" value="<?=$dt["hari"]?>"/></td>
    <td align="center"><input name="jamICD[]" type="text" class="inputan" id="jamICD[]" style="width:50px;" value="<?=$dt["jam"]?>"/></td>
    <td width="23%" align="center"><input name="ICD[]" type="text" class="inputan" id="ICD[]" style="width:50px;" value="<?=$dt["icd"]?>"/></td>
    <td width="8%" align="center"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}" /></td>
  </tr>
    <?php 	$no++;
	} 
		
	}
	?>
    </table>
    <?php 

	
	}?>
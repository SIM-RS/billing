<?php
include("../../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_ms_status_ugd_infus WHERE ugd_id='$id'");




//====================================================================
//$type=$_REQUEST['type'];

?><table width="1061" height="122" border="1" align="center" class="tanggal" id="tblInfus" style="border-collapse:collapse">
  <tr bgcolor="#ababab">
    <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF"><input name="button2" type="button"  value="Tambah" class="tblTambah" onclick="addRowToTable2();return false;"/></td>
  </tr>
  <tr bgcolor="#ababab">
   <td width="159" align="center" bgcolor="#00FF66">Tanggal</td>
              <td width="144" align="center" bgcolor="#00FF66">Jam</td>
              <td width="136" align="center" bgcolor="#00FF66">Jenis Infus / Transfusi </td>
              <td width="151" align="center" bgcolor="#00FF66">Nama Dokter</td>
              <td width="60" align="center" bgcolor="#00FF66">&nbsp;</td>
  </tr>
  
  <?
if(empty($id)){
?>
  <tr>
 <td><div align="center">
                <input type='text' class="tgl" name='tgla[]' id="tgla[]" />
                
              </div></td>
              <td><div align="center">
                <input type='text' class="jam" name="jam[]" id="jam[]" />
              </div></td>
              <td><div align="center">
                <input type='text' name="infus[]" id="infus[]"/>
              </div></td>
              <td><div align="center">
                <input type="text" id="nama" name='nama[]' />
                <?php /*?><?php
          $sql="select * from b_ms_pegawai where spesialisasi_id<>0";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
          <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
          <?php
    	  }
	      ?><?php */?>
              </div></td>
              <td><div align="center"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}" /></div></td>
 
 
  </tr>
      <?
}else{ while($dt=mysql_fetch_array($sql)){
?>
      <tr>
        <td><div align="center">
      <input name='tgla[]' type='text' class="tgl" id='tgla[]' size="20" onclick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);"  value="<?=$dt['tanggal']?>"/>
    </div></td>
    <td><div align="center">
      <input name="jam[]" type='text' class="jam" id="jam[]" size="20"  value="<?=$dt['jam']?>"/>
    </div></td>
    <td><div align="center">
      <input name="infus[]" type='text' id="infus[]" value="<?=$dt['infus']?>"/>
    </div></td>
    <td><div align="center">
      <input name="nama[]" type='text' id="nama[]" size="20"  value="<?=$dt['paraf_nama']?>"/>
    </div></td>

		
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}" /></td>
  </tr> 
    <?
}}
?>
    </table>
	
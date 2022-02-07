<?php
include("../koneksi/konek.php");
$id=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM b_fom_resume_kep_kontrol WHERE resume_kep_id='$id'");
//====================================================================
$type=$_REQUEST['type'];
$no=1;
?>
        
<script type="text/JavaScript">
 
/*function tanggalan2(){*/			
	$(function() {
		$( ".tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../images/cal.gif",
			buttonImageOnly: true
		});	
	});
//}

/*function jam2(){*/			
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
//}
</script>
<!--<body onLoad="tanggalan2();jam2();">--> 
<?php
if(empty($type)){
?>
<table border=1 align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="tambahrow();return false;"/></td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF">Tanggal</td>
        <td align="center" bgcolor="#FFFFFF">Hari</td>
        <td align="center" bgcolor="#FFFFFF">Jam</td>
        <td align="center" bgcolor="#FFFFFF">Nama Dokter</td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
     </tr>
     <tr>
          <?php //if(empty($id)){ ?>
       <td align="center"><label for="txt_obat[]"></label>
         <input name="tgl[]" type="text" class="tgl" id="tgl0" /></td>
       <td align="center"><select id="hari" name='hari[]'><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></td>
       <td align="center"><input class="jam" name="jam[]" type="text" id="jam0" /></td>
       <td align="center"><input name="dokter[]" type="text" id="dokter" /></td>
       <td align="center" valign="middle"><input type=button value=Delete onclick=del() /></td>
      </tr>
      
        <?php //}else{ while($dt=mysql_fetch_array($sql)){
				//$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <!--<tr>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="tgl[]" type="text" class="inputan" id="tgl[]" value="<?=$dt['tgl']?>"/></td>
        <td align="center"><input name="hari[]" type="text" id="hari[]2" value="<?=$dt['hari']?>" /></td>
        <td align="center"><input name="jam2" type="text" id="jam2" value="<?=$dt['jam']?>"/></td>
        <td align="center"><input name="dokter2" type="text" id="dokter2" value="<?=$dt['dokter']?>"/></td>
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>--> 
      <?php // }
		
	  //}
	  ?>
    </table>
    <?php }
	
	if($type=="ESO"){
		$sql=mysql_query("SELECT * FROM b_fom_resume_kep_kontrol WHERE resume_kep_id='$id'");
		$cek=mysql_num_rows($sql)
	?>
<table border=1 align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
	<tr>
    	<td colspan="5" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="tambahrow();"/></td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF">Tanggal</td>
        <td align="center" bgcolor="#FFFFFF">Hari</td>
        <td align="center" bgcolor="#FFFFFF">Jam</td>
        <td align="center" bgcolor="#FFFFFF">Nama Dokter</td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
     </tr>
     <tr>
          <?php if(empty($cek)){ ?>
       <td><label for="txt_obat[]"></label>
         <input name="tgl[]" type="text" class="tgl" id="tgl0" /></td>
       <td><select id="hari" name="hari[]"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></td>
       <td><input class="jam" name="jam[]" type="text" id="jam0"  /></td>
       <td><input name="dokter[]" type="text" id="dokter"  /></td>
       <td><input type=button value=Delete onclick=del() /></td>
      </tr>
      
        <?php }else{ $no=0; while($dt=mysql_fetch_array($sql)){
				$txt_jam=explode('|',$dt['jam_pemberian']);
			 ?>
      <tr>
        <td><label for="txt_obat[]"></label>
          <input name="tgl[]" type="text" class="tgl" id="tgl<?=$no;?>" value="<?=tglSQL($dt['tgl'])?>"/></td>
        <td><select id="hari" name="hari[]"><option <?php if ($dt['hari'] == 'Senin'){echo "selected='selected'";} ?>>Senin</option><option <?php if ($dt['hari'] == 'Selasa'){echo "selected='selected'";} ?>>Selasa</option><option <?php if ($dt['hari'] == 'Rabu'){echo "selected='selected'";} ?>>Rabu</option><option <?php if ($dt['hari'] == 'Kamis'){echo "selected='selected'";} ?>>Kamis</option><option <?php if ($dt['hari'] == 'Jumat'){echo "selected='selected'";} ?>>Jumat</option><option <?php if ($dt['hari'] == 'Sabtu'){echo "selected='selected'";} ?>>Sabtu</option><option <?php if ($dt['hari'] == 'Minggu'){echo "selected='selected'";} ?>>Minggu</option></select><!--<input name="hari[]" type="text" id="hari" value="<?=$dt['hari']?>"/> --></td>
        <td><input class="jam" name="jam[]" type="text" id="jam<?=$no;?>" value="<?=$dt['jam']?>"/></td>
        <td><input name="dokter[]" type="text" id="dokter" value="<?=$dt['dokter']?>"/></td>
        <td><input type=button value=Delete onclick=del() /></td>
      </tr> 
      <?php $no++;}
		
	  }
	  ?>
    </table>
    <!--</body>-->
    <?php 

	
	}?>

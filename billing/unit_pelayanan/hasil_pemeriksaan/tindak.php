<?php
include("../../koneksi/konek.php");

if($_REQUEST['labrad']==1){
	$styl="disabled=''";
}else{
	$styl="";
}

?>
<img alt="close" src="../icon/x.png" width="32" onclick="menutup();" style="float:right; cursor: pointer" />
<input name="terima_labrad" id="terima_labrad" type="button" size="10" class="txtinput" value="Terima" onclick="LabRadAmbil()" style="width:100px;height:30px; text-align:center;" <?=$styl?>>
<br />
<div align="left">
Nama Dokter :
<select id="cmbDokHslD" name="cmbDokHslD" class="txtinput" onkeypress="setDok('btnSimpanHsl',event);">
	<option value="">-Dokter-</option>
</select>
</div> 
<fieldset>
    <legend >
	<?php if($_REQUEST['cek']==1){?>
    	DATA PEMERIKSAAN RADIOLOGI
	<?php 
	}
	else if($_REQUEST['cek']==2)
	{
	?>
    	DATA PEMERIKSAAN LAB
	<?php 
	}else{
	?>
		DATA PERMINTAAN DARAH
    <?php
	}
	?></legend>
<?php
if($_REQUEST['cek']==1){
?>
</div>
<?php
}
?>
<table width="950" align="center" border="0" cellpadding="1" cellspacing="0">
	<?php
	if($_REQUEST['cek']==3){
	?>
    <tr class="headtable">
		<td width="200" class="tblheader"> KODE </td>
        <td width="500" class="tblheader"> DARAH </td>
        <td width="200" class="tblheader"> QTY </td>
	</tr>
    <?php
	}elseif($_REQUEST['cek']==2){
		?>
     <tr class="headtable">
		<td width="400" class="tblheader"> NAMA KELOMPOK </td>
        <td width="500" class="tblheader"> TINDAKAN </td>
        <td width="200" class="tblheader"> Pilih<br /><input type="checkbox" id="LPemIDAll" onclick="ambilLabAll()" class="LPemIDAll" checked="checked" /> </td>
	</tr>
        <?
	}
	else{
	?>
	<tr class="headtable">
		<td width="400" class="tblheader"> NAMA KELOMPOK </td>
        <td width="500" class="tblheader"> TINDAKAN </td>
        <td width="200" class="tblheader"> Pilih<br /><input type="checkbox" id="LPemIDAll" onclick="ambilLabAll()" class="LPemIDAll" checked="checked" /> </td>
	</tr>
    <?php
	}
	
	$id_pelay = $_REQUEST['idPel'];

	if($_REQUEST['cek']==1){
		$quew = "SELECT mt.id,mkt.nama AS namakelompok, mt.nama AS tindakan 
				FROM
				  b_tindakan_rad t 
				  INNER JOIN b_ms_tindakan mt 
					ON mt.id = t.pemeriksaan_id 
				  INNER JOIN b_ms_kelompok_tindakan mkt 
					ON mkt.id = mt.kel_tindakan_id
				WHERE t.pelayanan_id='$id_pelay' AND klasifikasi_id = 6 and mt.aktif = 1";
	
	}else if($_REQUEST['cek']==2){
			$quew = "SELECT DISTINCT t.tipe 
					FROM
					  b_tindakan_lab t 
					WHERE t.pelayanan_id='$id_pelay'";
			//echo $quew."<br>";
			$rsCLab=mysql_query($quew);
			$rwCLab=mysql_fetch_array($rsCLab);
			$ctipe=$rwCLab["tipe"];
			
			if ($ctipe==0){
				$quew = "SELECT 
						  t.tindakan_lab_id,k.nama_kelompok AS namakelompok, p.nama AS tindakan 
						FROM
						  b_tindakan_lab t 
						  INNER JOIN b_ms_pemeriksaan_lab p 
							ON p.id = SUBSTRING_INDEX(t.pemeriksaan_id, '|', 1) AND SUBSTRING_INDEX(t.pemeriksaan_id, '|', -1) <> 1
						  INNER JOIN b_ms_kelompok_lab k 
							ON k.id = p.kelompok_lab_id
						WHERE t.pelayanan_id='$id_pelay'";
			}
			elseif ($ctipe==1){
				$quew = "SELECT mt.id AS tindakan_lab_id,mkt.nama AS namakelompok,mt.nama AS tindakan 
						FROM b_tindakan_lab t 
						INNER JOIN b_ms_tindakan mt ON (mt.id = SUBSTRING_INDEX(t.pemeriksaan_id, '|', 1) 
						AND SUBSTRING_INDEX(t.pemeriksaan_id, '|', -1) <> 1)
						INNER JOIN b_ms_kelompok_tindakan mkt ON mt.kel_tindakan_id=mkt.id
						WHERE t.pelayanan_id='$id_pelay'";
			}
			else{
				$quew = "SELECT mt.id AS tindakan_lab_id,mktpl.nama_kelompok AS namakelompok,mt.nama AS tindakan 
						FROM b_tindakan_lab t 
						INNER JOIN b_ms_tindakan mt ON (mt.id = SUBSTRING_INDEX(t.pemeriksaan_id, '|', 1) 
						AND SUBSTRING_INDEX(t.pemeriksaan_id, '|', -1) <> 1)
						INNER JOIN b_ms_kelompok_tindakan_pemeriksaan_lab_tind mktplt ON mt.id=mktplt.ms_tind_id
						INNER JOIN b_ms_kelompok_tindakan_pemeriksaan_lab mktpl ON mktpl.id=mktplt.ms_kel_tind_lab_id
						WHERE t.pelayanan_id='$id_pelay'";
			}
	}else if($_REQUEST['cek']==3){
		$quew = "SELECT
				  d.kode,
				  d.darah,
				  pu.qty
				FROM db_simrs_bank_darah.bd_permintaan_unit pu
				  INNER JOIN db_simrs_bank_darah.bd_ms_darah d
					ON d.id = pu.ms_darah_id
				WHERE pu.pelayanan_id_bd = '$id_pelay'";
	}

	//echo $quew;
	$xw=mysql_query($quew);
	$jum=mysql_num_rows($xw);
	?>
	<input name="jml_tind_labrad" id="jml_tind_labrad" type="hidden" value="<?=$jum?>">
	<?php
	while($queTind = mysql_fetch_array($xw)){
		if($_REQUEST['cek']==3){
		?>
    	<tr class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        	<td class="tdisi" width="200" align="left">&nbsp;<?php echo $queTind['kode']; ?></td>
        	<td class="tdisi" width="500" align="left">&nbsp;<?php echo $queTind['darah']; ?></td>
            <td class="tdisi" width="200" align="center">&nbsp;<?php echo $queTind['qty']; ?></td>
		</tr>
    	<?php
		}elseif($_REQUEST['cek']==2){
			?>
        <tr class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        	<td class="tdisi" width="400" align="left">&nbsp;<?php echo $queTind['namakelompok']; ?></td>
        	<td class="tdisi" width="500" align="left">&nbsp;<?php echo $queTind['tindakan']; ?></td>
            <td class="tdisi" width="200" align="center">&nbsp;<input type="checkbox" id="LPemID" value="<?php echo $queTind['tindakan_lab_id']; ?>" onclick="" class="LPemID" checked="checked" /></td>
		</tr>
            <?php
		}
		else{
		?>
        <tr class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        	<td class="tdisi" width="400" align="left">&nbsp;<?php echo $queTind['namakelompok']; ?></td>
        	<td class="tdisi" width="500" align="left">&nbsp;<?php echo $queTind['tindakan']; ?></td>
            <td class="tdisi" width="200" align="center">&nbsp;<input type="checkbox" id="LPemID" value="<?php echo $queTind['id']; ?>" onclick="" class="LPemID" checked="checked" /></td>
		</tr>
    <?php 
		}
	}
	?>
</table>
</fieldset>
<?php 
//mysql_close($konek);
?>
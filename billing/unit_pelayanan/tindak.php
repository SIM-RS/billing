<?php
include("../koneksi/konek.php");
?>
<img alt="close" src="../icon/x.png" width="32" onclick="menutup();" style="float:right; cursor: pointer" />

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
<div align="right">
<button style="cursor:pointer;" onclick="window.open('keterangan_usg_rad.php?idPel=<?php echo $_REQUEST['idPel']; ?>','_blank');">Cetak Persiapan USG Abdomen</button>
<button style="cursor:pointer;" onclick="window.open('keterangan_pernyataan_rad.php?idPel=<?php echo $_REQUEST['idPel']; ?>','_blank');">Cetak Keterangan Pernyataan</button>
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
	}
	else{
	?>
	<tr class="headtable">
		<td width="400" class="tblheader"> NAMA KELOMPOK </td>
        <td width="500" class="tblheader"> TINDAKAN </td>
	</tr>
    <?php
	}
	
	$id_pelay = $_REQUEST['idPel'];

	if($_REQUEST['cek']==1){
		$quew = "SELECT mkt.nama AS namakelompok, mt.nama AS tindakan 
		FROM
		  b_tindakan_rad t 
		  INNER JOIN b_ms_tindakan mt 
			ON mt.id = t.pemeriksaan_id 
		  INNER JOIN b_ms_kelompok_tindakan mkt 
			ON mkt.id = mt.kel_tindakan_id
		WHERE t.pelayanan_id='$id_pelay' AND klasifikasi_id = 6";
	
	}else if($_REQUEST['cek']==2){
		$quew = "SELECT 
		  k.nama_kelompok AS namakelompok, p.nama AS tindakan 
		FROM
		  b_tindakan_lab t 
		  INNER JOIN b_ms_pemeriksaan_lab p 
			ON p.id = SUBSTRING_INDEX(t.pemeriksaan_id, '|', 1) AND SUBSTRING_INDEX(t.pemeriksaan_id, '|', -1) <> 1
		  INNER JOIN b_ms_kelompok_lab k 
			ON k.id = p.kelompok_lab_id
		WHERE t.pelayanan_id='$id_pelay'";				
	
	}else if($_REQUEST['cek']==3){
		$quew = "SELECT
				  d.kode,
				  d.darah,
				  pu.qty
				FROM {$dbbank_darah}.bd_permintaan_unit pu
				  INNER JOIN {$dbbank_darah}.bd_ms_darah d
					ON d.id = pu.ms_darah_id
				WHERE pu.pelayanan_id_bd = '$id_pelay'";				
	
	}

	//echo $quew;
	$xw=mysql_query($quew);
	
	while($queTind = mysql_fetch_array($xw)){
		if($_REQUEST['cek']==3){
		?>
    	<tr class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        	<td class="tdisi" width="200" align="left">&nbsp;<?php echo $queTind['kode']; ?></td>
        	<td class="tdisi" width="500" align="left">&nbsp;<?php echo $queTind['darah']; ?></td>
            <td class="tdisi" width="200" align="center">&nbsp;<?php echo $queTind['qty']; ?></td>
		</tr>
    	<?php
		}
		else{
		?>
        <tr class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'">
        	<td class="tdisi" width="400" align="left">&nbsp;<?php echo $queTind['namakelompok']; ?></td>
        	<td class="tdisi" width="500" align="left">&nbsp;<?php echo $queTind['tindakan']; ?></td>
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
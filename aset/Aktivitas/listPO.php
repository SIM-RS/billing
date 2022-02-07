<?php
	include "../koneksi/konek.php";
	if($_REQUEST['tahun']!=''){
		$tahun = $_REQUEST['tahun'];
	} else {
		$tahun = date('Y');
	}
	
	if($_REQUEST['bulan']!=0){
		$bulan = $_REQUEST['bulan'];
	} else {
		$bulan = date('m');
	}
	$noPO = $_REQUEST['no_po'];
	
	$qry="SELECT distinct po.no_po, vendor_id, rek.namarekanan,po.exp_kirim,po.tgl_po
				FROM as_po po INNER JOIN as_ms_rekanan rek ON rek.idrekanan = po.vendor_id
				inner join as_ms_barang b on b.idbarang = po.ms_barang_id
				where po.status = 0
					AND YEAR(po.tgl_po) = '$tahun'
					AND MONTH(po.tgl_po) = '$bulan'
					AND po.ms_barang_id not in 
				(select idbarang from as_ms_barang where kodebarang like '01%' or kodebarang like '03%' 
				or kodebarang like '04%' or kodebarang like '06%' and tipe='1')order by po.tgl_po desc,po.no_po desc";
	//echo $qry;
	$exe=mysql_query($qry);	
?>
<select name='cmbNoPo' class='txtcenter' id='cmbNoPo' onchange='set()'>
	<option value=''>Pilih PO</option>
	<?php
		while($show=mysql_fetch_array($exe)){
			echo "<option value='".$show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po']."' ";
			/* if($show['no_po'].'|'.$show['vendor_id'].'|'.$show['namarekanan'].'|'.$show['exp_kirim'].'|'.$show['tgl_po'] == $no_po)
				echo 'selected'; */
			if($noPO == $show['no_po']){ echo 'selected'; }

			echo " >".$show['no_po'].' - '.$show['namarekanan']."</option>";
		}
	?>
</select>
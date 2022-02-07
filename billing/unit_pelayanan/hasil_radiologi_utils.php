<?php
	include('../koneksi/konek.php');
	$idPel = $_REQUEST['idPel'];
	$idHRad = $_REQUEST['idHRad'];
	$par = $_REQUEST['par'];
	switch($par){
		case "cekH":
			$sql = "SELECT hr.id, CONCAT(mp.nama,DATE_FORMAT(hr.tgl_act, ' [%d-%m-%Y / %H:%i]')) ket
					FROM b_hasil_rad hr
					INNER JOIN b_ms_pegawai mp
					ON mp.id = hr.user_id
					WHERE pelayanan_id = {$idPel}";
			$query = mysql_query($sql);
			$jml = mysql_num_rows($query);
			if($jml > 0){
				while($data = mysql_fetch_object($query)){
					echo "<option value='".$data->id."'>".$data->ket."</option>";
				}
			} else {
				echo "<option value='0'> - </option>";
			}
		break;
		case "getH":
			$sql ="SELECT hr.*,mp.nama
					FROM b_hasil_rad hr
					left JOIN b_ms_pegawai mp 
						ON mp.id = hr.user_id
					WHERE hr.id = '".$idHRad."'";
			$rs=mysql_query($sql);
			$dt = mysql_fetch_array($rs);
			echo $dt['hasil'];
			?>
			<script type="text/javascript">
				document.getElementById('nmDokter').innerHTML = '<?php echo strtolower($dt['nama']); ?>';
				document.getElementById('normpacs').value = '<?php echo $dt['norm']; ?>';
				document.getElementById('idpacs').value = '<?php echo $dt['pacsid']; ?>';
			</script>
			<?php
		break;
		case "getTgl":
			$sql ="SELECT 
				DATE_FORMAT(hr.tgl_act,'%d-%m-%Y / %H:%i') as tgl_baca 
				from b_hasil_rad hr 
				WHERE hr.id = '".$idHRad."'";
			$rs=mysql_query($sql);
			$dt = mysql_fetch_array($rs);
			echo $dt['tgl_baca'];
		break;
		case "getKetPeng":
			$sql ="SELECT 
					p.ket, peng.nama,
					DATE_FORMAT(p.tgl,'%d-%m-%Y') tgljam, 
					DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP,
					un.nama nmUnit
				from b_pelayanan p
				left join b_ms_pegawai peng 
					on peng.id = p.dokter_id
				left join b_ms_unit un 
					on un.id=p.unit_id_asal
				WHERE p.id = '".$idPel."'";
			$rs=mysql_query($sql);
			$dt = mysql_fetch_array($rs);
?>
			<script type="text/javascript">
				document.getElementById('pengirim').innerHTML = '<?php echo strtolower($dt['nama']); ?>';
				document.getElementById('ket').innerHTML = '<?php echo $dt['ket']; ?>';
				document.getElementById('tgljam2').innerHTML = '<?php echo $dt['tgljam']; ?>';
				document.getElementById('nmUnit2').innerHTML = '<?php echo $dt['nmUnit']; ?>';
			</script>
<?
		break;
	}
?>
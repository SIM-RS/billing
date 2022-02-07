<?php
	session_start();
	include("../koneksi/konek.php");
	$act = $_REQUEST['act'];
	$jnsid = $_REQUEST['jnsid'];
	switch($act){
		case 'tmpLay':
			$hasil = "";
			$jnsLay = $_REQUEST['jnsLay'];
			$hasil .= "<option value='all'>-- SEMUA --</option>";
			if($jnsLay != 'all'){				
				$sql = "SELECT id,nama FROM $dbbilling.b_ms_unit WHERE parent_id = {$jnsid} AND aktif = 1;";
				$query = mysqli_query($konek,$sql);
				while($data = mysqli_fetch_array($query)){
					$hasil .= "<option value='".$data['id']."'>".$data['nama']."</option>";
				}
			}
			break;
		case 'data':
			$hasil = "";
			$norm = $_REQUEST['norm'];
			$panjang = 8 - strlen($norm);
			$depan = '';
			if($panjang != 0){
				for($i=1;$i<=$panjang;$i++){
					$depan .= 0;
				}
			}
			$norm = $depan.$norm;
			$jnsLay = $_REQUEST['jnsLay'];
			$tmpLay = $_REQUEST['tmpLay'];
			if($jnsLay != 'all'){
				if($tmpLay != 'all'){
					$ftmpLay = "AND p.unit_id = {$tmpLay}";
				} else {
					$ftmpLay = "AND mu.parent_id = {$jnsLay}";
				}
			} else {
				$ftmpLay = '';
			}
			
			$sql = "SELECT mp.nama, p.id, mu.nama tmpLay, mp.no_rm, DATE_FORMAT(p.tgl_act,'%d-%m-%Y') tgl
					FROM $dbbilling.b_ms_pasien mp
					INNER JOIN $dbbilling.b_kunjungan k
					ON k.pasien_id = mp.id
					INNER JOIN $dbbilling.b_pelayanan p
					ON p.kunjungan_id = k.id
					INNER JOIN $dbbilling.b_ms_unit mu
					ON mu.id = p.unit_id
					WHERE mp.no_rm = '{$norm}' {$ftmpLay}";
			$query = mysqli_query($konek,$sql);
			$hasil .= "<table id='datPas'>";
			$namaTmp = "";
			while($data = mysqli_fetch_object($query)){
				if($data->nama!=$namaTmp){
					$hasil .= "<tr><td class='noborder' align='right'>NAMA : </td><td colspan='2' class='noborder'>".$data->nama."</td></tr>";
					$hasil .= "<tr><td class='noborder' align='right'>NORM : </td><td colspan='2' class='noborder'>".$data->no_rm."</td></tr>";
					$hasil .= "<tr><th>Tempat Layanan</th><th>Tanggal</th><th>Kartu Kendali</th></tr>";
				}
				$hasil .= "<tr>
					<td>".$data->tmpLay."</td>
					<td>".$data->tgl."</td>
					<td>"."<a target='_blank' href='../transaksi/kartukendali.php?idPel=".$data->id."&norm=".$data->no_rm."'>Detail</a></td>
				</tr>";
				$namaTmp = $data->nama;
			}
			$hasil .= "</table>";
			break;
	}
	echo $hasil;
?>
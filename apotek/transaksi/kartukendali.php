<?php
	include("../koneksi/konek.php");
	$idPel = $_GET['idPel'];
	$norm = $_GET['norm'];
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Kartu Kendali Resep Pasien</title>
	<style type="text/css">
		body{
			font-family:Arial;
			font-size:12px;
			line-height:1.5em;
		}
		table {
			border-collapse:collapse;
		}
		table td, table th { border:1px solid #000; padding:5px; }
		.noborder { border:0px; }
	</style>
</head>
<body>
	<div id="detailPas" style="margin-bottom:15px; border:1px solid #000; width:300px; padding:10px;">
		<?php
			$sql = "SELECT mp.nama, mk.nama kso, mu.nama unit, mua.nama unit_asal, mup.nama jnsLay
					FROM $dbbilling.b_pelayanan p
					INNER JOIN $dbbilling.b_ms_pasien mp
					  ON mp.id = p.pasien_id
					INNER JOIN $dbbilling.b_ms_kso mk
					  ON mk.id = p.kso_id
					INNER JOIN $dbbilling.b_ms_unit mu
					  ON mu.id = p.unit_id
					INNER JOIN $dbbilling.b_ms_unit mua
					  ON mua.id = p.unit_id_asal
					INNER JOIN $dbbilling.b_ms_unit mup
					  ON mup.id = mu.parent_id
					WHERE p.id = '{$idPel}'";
			$query = mysqli_query($konek,$sql);
			$pass = mysqli_fetch_object($query);
		?>
		NO RM : <?php echo $norm; ?>
		<br />
		Nama : <?php echo $pass->nama; ?>
		<br />
		Status : <?php echo $pass->kso; ?>
		<br />
		Jenis Layanan : <?php echo $pass->jnsLay; ?>
		<br />
		Tempat Layanan : <?php echo $pass->unit; ?>
		<br />
	</div>
	<?php
		$sDiag = "SELECT GROUP_CONCAT(IFNULL(d.diagnosa_manual,md.nama) SEPARATOR '</li><li>') AS nama
					FROM $dbbilling.b_diagnosa d 
					INNER JOIN $dbbilling.b_kunjungan k
					ON k.id = d.kunjungan_id
					INNER JOIN $dbbilling.b_pelayanan p
					ON p.kunjungan_id = k.id
					LEFT JOIN $dbbilling.b_ms_diagnosa md
					ON md.id = d.ms_diagnosa_id
					WHERE p.id = '{$idPel}'
					GROUP BY p.id";
		$qDiag = mysqli_query($konek,$sDiag) or die (mysqli_error($konek));
		$diag = mysqli_fetch_array($qDiag);
		$diagnosa = $diag['nama'];
	?>
	<div id="diagnosa" style="border:1px solid #000; padding:10px; width:500px;">
		<b>Diagnosa Pasien : </b><br />
		<ol>
			<li><?php echo $diagnosa; ?></li>
		</ol>
	</div>
	<div id="resep" style="float:left; width:45%; max-width:45%; margin-right:20px;">
		<h2>Daftar Resep Pasien</h2>
		<?php
			$sql = "SELECT r.no_resep, IF(ISNULL(o.OBAT_NAMA),r.obat_manual,o.OBAT_NAMA) nama, r.apotek_id, 
						u.UNIT_NAME, r.qty, r.qty_bahan, r.satuan, r.racikan, r.status, DATE_FORMAT(r.tgl, '%d-%m-%Y') tgl
					FROM $dbbilling.b_resep r 
					LEFT JOIN a_obat o
						ON o.OBAT_ID = r.obat_id
					INNER JOIN a_unit u
						ON u.UNIT_ID = r.apotek_id
					WHERE r.id_pelayanan = '{$idPel}'
						AND r.no_rm = '{$norm}'
					ORDER BY r.tgl DESC, r.no_resep DESC, r.obat_id ASC";
			$query = mysqli_query($konek,$sql);
			$jum = mysqli_num_rows($query);
		?>
		<table>
			<thead>
				<tr>
					<th>NO</th>
					<th>Tanggal</th>
					<th>No Resep</th>
					<th>Apotek</th>
					<th>Nama Obat</th>
					<th>Racikan</th>
					<th>QTY</th>
				</tr>
			</thead>
			<tbody>
		<?
			if($jum>0){
				$tmp = "";
				$tmpno = "";
				$no = 1;
				while($data = mysqli_fetch_object($query)){
					echo "<tr>";
					if($tmp != $data->tgl){
						echo "<td align='center'>".$no++."</td>";
						echo "<td align='center'>".$data->tgl."</td>";
						echo "<td align='center'>".$data->no_resep."</td>";
						echo "<td>".$data->UNIT_NAME."</td>";
					} else {
						if($tmpno != $data->no_resep){
							echo "<td align='center'>".$no++."</td>";
							echo "<td align='center'>".$data->tgl."</td>";
							echo "<td align='center'>".$data->no_resep."</td>";
							echo "<td>".$data->UNIT_NAME."</td>";
						} else {
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
					}
					$racikan = 'Tidak';
					if($data->racikan == 1){
						$racikan = 'Ya';
					}
					echo "<td>".$data->nama."</td>";
					echo "<td align='center'>".$racikan."</td>";
					echo "<td align='center'>".$data->qty."</td>";
					echo "</tr>";
					$tmp = $data->tgl;
					$tmpno = $data->no_resep;
				}
			}
			$tmp = "";
		?>
			</tbody>
		</table>
	</div>
	<div id="dilayani" style="float:left; width:52%; max-width:52%;">
		<h2>Daftar Obat Pasien yang Telah Dilayani</h2>
		<?php
			$sql_ = "SELECT p.NO_RESEP no_resep, DATE_FORMAT(p.TGL, '%d-%m-%Y') tgl, o.OBAT_ID, o.OBAT_NAMA nama, p.QTY, p.QTY_JUAL, p.QTY_RETUR, (p.QTY_JUAL - p.QTY_RETUR) qty_a, p.RACIKAN, u.UNIT_NAME apotek
					FROM a_penjualan p
					INNER JOIN a_penerimaan pe
						ON pe.ID = p.PENERIMAAN_ID
					INNER JOIN a_obat o
						ON o.OBAT_ID = pe.OBAT_ID
					INNER JOIN a_unit u
						ON u.UNIT_ID = p.UNIT_ID
					WHERE p.NO_KUNJUNGAN = '{$idPel}'
						AND p.NO_PASIEN = '{$norm}'
					GROUP BY p.NO_RESEP, o.OBAT_ID
					ORDER BY p.TGL DESC, p.NO_RESEP ASC, o.OBAT_ID ASC";
			
			$sql = "SELECT 
					  p.NO_PENJUALAN, p.NO_RESEP no_resep, DATE_FORMAT(p.TGL, '%d-%m-%Y') tgl, o.OBAT_ID,
					  o.OBAT_NAMA nama, SUM(p.QTY) QTY, SUM(p.QTY_JUAL) QTY_JUAL, SUM(p.QTY_RETUR) QTY_RETUR,
					  SUM(p.QTY_JUAL - p.QTY_RETUR) qty_a, p.RACIKAN, u.UNIT_NAME apotek 
					FROM
					  a_penjualan p 
					  INNER JOIN a_penerimaan pe 
						ON pe.ID = p.PENERIMAAN_ID 
					  INNER JOIN a_obat o 
						ON o.OBAT_ID = pe.OBAT_ID 
					  INNER JOIN a_unit u 
						ON u.UNIT_ID = p.UNIT_ID 
					WHERE p.NO_KUNJUNGAN = '{$idPel}'
						AND p.NO_PASIEN = '{$norm}'
					GROUP BY p.NO_RESEP, p.NO_PENJUALAN,
					  o.OBAT_ID 
					ORDER BY p.TGL DESC,
					  p.NO_RESEP ASC,
					  o.OBAT_ID ASC";
			$query = mysqli_query($konek,$sql);
			$jum = mysqli_num_rows($query);
		?>
		<table>
			<thead>
				<tr>
					<th>NO</th>
					<th>No Resep</th>
					<th>Apotek</th>
					<th>Tanggal</th>
					<th>Nama Obat</th>
					<th>Racikan</th>
					<th>Qty Jual</th>
					<th>Qty Retur</th>
				</tr>
			</thead>
			<tbody>
		<?
			if($jum>0){
				$tmp2 = "";
				$tmp2tgl = "";
				$no = 1;
				while($data = mysqli_fetch_object($query)){
					echo "<tr>";
					if($tmp2 != $data->no_resep){
						echo "<td align='center'>".$no++."</td>";
						echo "<td align='center'>".$data->no_resep."</td>";
						echo "<td>".$data->apotek."</td>";
					} else {
						if($tmp2tgl != $data->tgl){
							echo "<td align='center'>".$no++."</td>";
							echo "<td align='center'>".$data->no_resep."</td>";
							echo "<td>".$data->apotek."</td>";
						} else {
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
					}
					$racikan = 'Tidak';
					if($data->racikan == 1){
						$racikan = 'Ya';
					}
					echo "<td>".$data->tgl."</td>";
					echo "<td>".$data->nama."</td>";
					echo "<td align='center'>".$racikan."</td>";
					echo "<td align='center'>".$data->QTY_JUAL."</td>";
					echo "<td align='center'>".$data->QTY_RETUR."</td>";
					echo "</tr>";
					$tmp2 = $data->no_resep;
					$tmp2tgl = $data->tgl;
				}
			}
			$tmp2 = "";
		?>
			</tbody>
		</table>
	</div>
</body>
</html>
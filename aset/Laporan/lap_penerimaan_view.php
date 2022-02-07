<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}

isset($_POST['submit']) 
	or die('Sistem error');
	
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$format = $_POST['format'];

if($format == 'XLS')
	header('Location: '.$def_loc.'/Laporan/lap_penerimaan_excel.php?tahun='.$tahun.'&bulan='.$bulan);

$arr_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>.: Laporan Penerimaan Barang :.</title>
	<style>
	body, table {
		font-family: arial;
		font-size: 10px;
	}
	.table {
		border-top: 1px solid #000;
	}
	.table th {
		background-color: #eee;
	}
	.table th, .table td {
		border-right: 1px solid #000;
		border-bottom: 1px solid #000;
	}
	.table th:first-child, .table td:first-child {
		border-left: 1px solid #000;
	}
	</style>
</head>

<body>
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th><h2>LAPORAN PENERIMAAN BARANG</h2></th>
		</tr>
		<tr>
			<th><h2><?php echo strtoupper($arr_bulan[(integer) $bulan]).' '.$tahun; ?></h2></th>
		</tr>
	</table>
	<table class="table" cellpadding="5" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="20">No</th>
				<th width="60">Tgl Terima</th>
				<th width="150">No PO</th>
				<th width="130">No Terima</th>
				<th width="120">No Faktur</th>
				<th>Nama Barang</th>
				<th width="20">Qty</th>
				<th width="50">Satuan</th>
				<th width="80">Hrg Satuan</th>
				<th width="100">Sub Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = 0;
			$sql = 'select 
				  idrekanan,
				  namarekanan 
				from
				  as_ms_rekanan 
				order by namarekanan asc';
			$query = mysql_query($sql);
			while($rows = mysql_fetch_array($query)){
				$sql2 = "select 
					  date_format(tgl_terima, '%d/%m/%Y') tgl_terima,
					  no_po,
					  no_gudang,
					  no_faktur,
					  namabarang,
					  jml_msk,
					  satuan_unit,
					  harga_unit 
					from
					  as_po po 
					  inner join as_masuk m 
						on po.id = m.po_id 
					  inner join as_ms_barang b 
						on m.barang_id = b.idbarang 
					where 
					  date_format(tgl_terima, '%Y%m') = '".$tahun.$bulan."'
					  and vendor_id = ".$rows['idrekanan']."
					order by 
					  tgl_terima,
					  no_po,
					  no_gudang";
				$query2 = mysql_query($sql2);
				if(mysql_num_rows($query2)>0){
					?>
					<tr>
						<td colspan="10"><strong><?php echo $rows['namarekanan']; ?></strong></td>
					</tr>
					<?php
					$no = 1;
					$tgl_terima = NULL;
					$no_gudang = NULL;
					$subtotal_gudang = 0;
					$subtotal_po = 0;
					$subtotal_rekanan = 0;
					while($rows2 = mysql_fetch_array($query2)){
						if($no > 1 && ($no_gudang != $rows2['no_gudang'] || $tgl_terima != $rows2['tgl_terima'])){
							?>
							<tr>
								<td colspan="9" align="right"><strong>Total Terima <?php echo $no_gudang; ?> pada tanggal <?php echo $tgl_terima; ?></strong></td>
								<td align="right"><strong><?php echo number_format($subtotal_gudang,2,',','.'); ?></strong></td>
							</tr>
							<?php
							$subtotal_gudang = 0;
						}
						if($no > 1 && $tgl_terima != $rows2['tgl_terima']){
							?>
							<tr>
								<td colspan="9" align="right"><strong>Total PO <?php echo $no_po; ?> pada tanggal <?php echo $tgl_terima; ?></strong></td>
								<td align="right"><strong><?php echo number_format($subtotal_po,2,',','.'); ?></strong></td>
							</tr>
							<?php
							$subtotal_po = 0;
						}
						?>
						<tr>
							<td align="center"><?php echo $tgl_terima != $rows2['tgl_terima'] ? $no : '&nbsp;'; ?></td>
							<td align="center"><?php echo $tgl_terima != $rows2['tgl_terima'] ? $rows2['tgl_terima'] : '&nbsp;'; ?></td>
							<td align="center"><?php echo $tgl_terima != $rows2['tgl_terima'] ? $rows2['no_po'] : '&nbsp;'; ?></td>
							<td align="center"><?php echo ($no_gudang != $rows2['no_gudang'] || $tgl_terima != $rows2['tgl_terima']) ? $rows2['no_gudang'] : '&nbsp;'; ?></td>
							<td align="center"><?php echo $rows2['no_faktur']; ?></td>
							<td><?php echo $rows2['namabarang']; ?></td>
							<td align="center"><?php echo number_format($rows2['jml_msk'],0,',','.'); ?></td>
							<td align="center"><?php echo $rows2['satuan_unit']; ?></td>
							<td align="right"><?php echo number_format($rows2['harga_unit'],2,',','.'); ?></td>
							<td align="right"><?php echo number_format($rows2['jml_msk'] * $rows2['harga_unit'],2,',','.'); ?></td>
						</tr>
						<?php
						$subtotal_gudang += $rows2['jml_msk'] * $rows2['harga_unit'];
						$subtotal_po += $rows2['jml_msk'] * $rows2['harga_unit'];
						$subtotal_rekanan += $rows2['jml_msk'] * $rows2['harga_unit'];
						$total += $rows2['jml_msk'] * $rows2['harga_unit'];
						
						if($tgl_terima != $rows2['tgl_terima'])
							$no++;
							
						$tgl_terima = $rows2['tgl_terima'];
						$no_gudang = $rows2['no_gudang'];
						$no_po = $rows2['no_po'];
					}
					?>
					<tr>
						<td colspan="9" align="right"><strong>Total Terima <?php echo $no_gudang; ?> pada tanggal <?php echo $tgl_terima; ?></strong></td>
						<td align="right"><strong><?php echo number_format($subtotal_gudang,2,',','.'); ?></strong></td>
					</tr>
					<tr>
						<td colspan="9" align="right"><strong>Total PO <?php echo $no_po; ?> pada tanggal <?php echo $tgl_terima; ?></strong></td>
						<td align="right"><strong><?php echo number_format($subtotal_po,2,',','.'); ?></strong></td>
					</tr>
					<tr>
						<td colspan="9" align="right"><strong>Total <?php echo $rows['namarekanan']; ?></strong></td>
						<td align="right"><strong><?php echo number_format($subtotal_rekanan,2,',','.'); ?></strong></td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td colspan="10">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="9" align="right"><strong>Total</strong></td>
				<td align="right"><strong><?php echo number_format($total,2,',','.'); ?></strong></td>
			</tr>
		</tbody>
	</table>
</body>
</html>

<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}

isset($_GET['no_po']) 
	or die('Sistem error');
	
$no_po = $_GET['no_po'];
$tanggal_po = explode('-', $_GET['tanggal_po']);
$tanggal_po = $tanggal_po[2].'-'.$tanggal_po[1].'-'.$tanggal_po[0];

$arr_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>.: Detail PO <?php echo $no_po; ?> :.</title>
	<style>
	body, table {
		font-family: arial;
		font-size: 11px;
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
			<th><h2>DETAIL PO <?php echo $no_po; ?></h2></th>
		</tr>
	</table>
	<table class="table" cellpadding="5" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th width="20">No</th>
				<th width="150">Kode Barang</th>
				<th>Nama Barang</th>
				<th>Uraian</th>
				<th width="50">Jumlah</th>
				<th width="50">Jumlah Diterima</th>
				<th width="50">Selisih</th>
				<th width="80">Satuan</th>
				<th width="80">Harga</th>
				<th width="100">Total</th>
				<th>Peruntukan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$sql = "select 
				  ap.*,
				  id,
				  ms_barang_id,
				  uraian,
				  kodebarang,
				  ap.peruntukan,
				  namabarang,
				  vendor_id,
				  namarekanan,
				  no_po,
				  date_format(tgl_po, '%d-%m-%Y') as tgl,
				  satuan,
				  qty_satuan,
				  qty_terima,
				  lain2,
				  harga_satuan,
				  unit_id,
				  ab.idsatuan 
				from
				  as_po ap 
				  inner join as_ms_barang ab 
					on ap.ms_barang_id = ab.idbarang 
				  left join as_ms_rekanan ar 
					on ap.vendor_id = ar.idrekanan 
				where no_po = '".$no_po."' 
				  and tgl_po = '".$tanggal_po."' 
				order by id asc ";
			$query = mysql_query($sql);
			while($rows = mysql_fetch_array($query)){
				?>
				<tr>
					<td align="center"><?php echo $no; ?></td>
					<td align="center"><?php echo $rows['kodebarang']; ?></td>
					<td><?php echo $rows['namabarang']; ?></td>
					<td>&nbsp;<?php echo $rows['uraian']; ?></td>
					<td align="center"><?php echo $rows['qty_satuan']; ?></td>
					<td align="center"><?php echo $rows['qty_terima']; ?></td>
					<td align="center"><?php echo $rows['qty_satuan'] - $rows['qty_terima']; ?></td>
					<td align="center"><?php echo ($rows['satuan']!='')?$rows['satuan']:'&nbsp;'; ?></td>
					<td align="right"><?php echo number_format($rows['harga_satuan'],0,',','.'); ?></td>
					<td align="right"><?php echo number_format(round($rows['qty_satuan'] * $rows['harga_satuan']),0,',','.'); ?></td>
					<td>&nbsp;<?php echo $rows["peruntukan"]; ?></td>
				</tr>
				<?php
				$no++;
			}
			?>
		</tbody>
	</table>
</body>
</html>

<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}

isset($_GET['nopo']) 
	or die('Sistem error');
	
$no_po = $_GET['nopo'];
$tanggal_po = explode('-', $_GET['tgl']);
$tanggal_po = $tanggal_po[2].'-'.$tanggal_po[1].'-'.$tanggal_po[0];

$arr_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$sql = "select vendor_id, namarekanan
		from
		  as_po ap 
		  inner join as_ms_barang ab 
			on ap.ms_barang_id = ab.idbarang 
		  left join as_ms_rekanan ar 
			on ap.vendor_id = ar.idrekanan 
		where no_po = '".$no_po."' 
		  and tgl_po = '".$tanggal_po."' 
		order by id asc ";
//echo $sql;
$rekanan = mysql_fetch_array(mysql_query($sql));
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
	table{
		border-collapse: collapse; border-spacing: 0;
		letter-spacing: 1.2px;
	}
	table th{
		background:#ececec;
		border:1px solid #000;
	}
	thead td{
		margin:2;
		padding:2;
	}
	td{
		border:1px solid #000;
	}
	.noborder{
		border:0px;
	}
	.title{
		font-size:12px;
	}
	.judul{
		width:100px;
		display:inline-block;
	}
	</style>
</head>

<body>
	<table class="table" cellpadding="5" cellspacing="0" width="auto" style="margin:5px auto;">
		<thead>
			<tr><td class="noborder" style="text-align:center; font-size:18px; font-weight:bold;" colspan="7">DAFTAR PENERIMAAN PO <br /><br /></td></tr>
			<tr><td class="title noborder" colspan="7"><span class="judul">NO PO</span> : <?php echo $no_po; ?></td></tr>
			<tr><td class="title noborder" colspan="7"><span class="judul">TGL PO</span> : <?php echo $_REQUEST['tgl']; ?></td></tr>
			<tr><td class="title noborder" colspan="7"><span class="judul">REKANAN</span> : <?php echo $rekanan['namarekanan']; ?><br /><br /></td></tr>
			<tr>
				<th width="30">No</th>
				<th width="150">Kode Barang</th>
				<th width="200">Nama Barang</th>
				<th width="250">Uraian</th>
				<th width="100">Satuan</th>
				<th width="50">Jumlah Pesan</th>
				<th width="50">Jumlah Diterima</th>
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
					<td align="center"><?php echo ($rows['satuan']!='')?$rows['satuan']:'&nbsp;'; ?></td>
					<td align="center"><?php echo $rows['qty_satuan']; ?></td>
					<td align="center"><?php echo $rows['qty_terima']; ?></td>
				</tr>
				<?php
				$no++;
			}
			?>
		</tbody>
	</table>
</body>
</html>

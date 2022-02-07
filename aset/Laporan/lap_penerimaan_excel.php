<?php
session_start();
include '../koneksi/konek.php';
include '../include/Excell/Writer.php';

$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];

$arr_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');


$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Laporan Penerimaan Barang.xls');

$worksheet=&$workbook->addWorksheet('...');
$worksheet->setPaper("A4");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

$worksheet->setColumn (0, 0, 5);
$worksheet->setColumn (1, 1, 15);
$worksheet->setColumn (2, 2, 30);
$worksheet->setColumn (3, 3, 30);
$worksheet->setColumn (4, 4, 25);
$worksheet->setColumn (5, 5, 40);
$worksheet->setColumn (6, 6, 5);
$worksheet->setColumn (7, 7, 10);
$worksheet->setColumn (8, 8, 15);
$worksheet->setColumn (9, 9, 20);

$title =& $workbook->addFormat(array('bold'=>1,'size'=>13,'align'=>'center'));
$thead =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1));
$tbody =& $workbook->addFormat(array('size'=>10,'align'=>'left','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1));
$tbody_bold =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1));
$tbody_center =& $workbook->addFormat(array('size'=>10,'align'=>'center','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1));
$tbody_right_bold =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1));
$tbody_numeric =& $workbook->addFormat(array('size'=>10,'align'=>'center','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'numFormat'=>'#,##0'));
$tbody_currency =& $workbook->addFormat(array('size'=>10,'align'=>'right','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'numFormat'=>'#,##0.00'));
$tbody_currency_bold =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','textWrap'=>1,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'numFormat'=>'#,##0.00'));

$row = 0;

$worksheet->write($row, 0, "LAPORAN PENERIMAAN BARANG", $title);
$worksheet->setMerge($row, 0, $row, 9);

$row++;

$worksheet->write($row, 0, strtoupper($arr_bulan[(integer) $bulan]).' '.$tahun, $title);
$worksheet->setMerge($row, 0, $row, 9);

$row += 2;

$worksheet->write($row, 0, "No", $thead);
$worksheet->write($row, 1, "Tgl Terima", $thead);
$worksheet->write($row, 2, "No PO", $thead);
$worksheet->write($row, 3, "No Terima", $thead);
$worksheet->write($row, 4, "N0 Faktur", $thead);
$worksheet->write($row, 5, "Nama Barang", $thead);
$worksheet->write($row, 6, "Qty", $thead);
$worksheet->write($row, 7, "Satuan", $thead);
$worksheet->write($row, 8, "Hrg Satuan", $thead);
$worksheet->write($row, 9, "Sub Total", $thead);

$row++;

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
	
		$worksheet->write($row, 0, $rows['namarekanan'], $tbody_bold);
		$worksheet->write($row, 1, '', $tbody);
		$worksheet->write($row, 2, '', $tbody);
		$worksheet->write($row, 3, '', $tbody);
		$worksheet->write($row, 4, '', $tbody);
		$worksheet->write($row, 5, '', $tbody);
		$worksheet->write($row, 6, '', $tbody);
		$worksheet->write($row, 7, '', $tbody);
		$worksheet->write($row, 8, '', $tbody);
		$worksheet->write($row, 9, '', $tbody);
		$worksheet->setMerge($row, 0, $row, 9);
		
		$row++;
		
		$no = 1;
		$tgl_terima = NULL;
		$no_gudang = NULL;
		$subtotal_gudang = 0;
		$subtotal_po = 0;
		$subtotal_rekanan = 0;
		while($rows2 = mysql_fetch_array($query2)){
			if($no > 1 && ($no_gudang != $rows2['no_gudang'] || $tgl_terima != $rows2['tgl_terima'])){
			
				$worksheet->write($row, 0, 'Total Terima '.$no_gudang.' pada tanggal '.$tgl_terima, $tbody_right_bold);
				$worksheet->write($row, 1, '', $tbody);
				$worksheet->write($row, 2, '', $tbody);
				$worksheet->write($row, 3, '', $tbody);
				$worksheet->write($row, 4, '', $tbody);
				$worksheet->write($row, 5, '', $tbody);
				$worksheet->write($row, 6, '', $tbody);
				$worksheet->write($row, 7, '', $tbody);
				$worksheet->write($row, 8, '', $tbody);
				$worksheet->write($row, 9, $subtotal_gudang, $tbody_currency_bold);
				$worksheet->setMerge($row, 0, $row, 8);
				
				$row++;
				
				$subtotal_gudang = 0;
			}
			if($no > 1 && $tgl_terima != $rows2['tgl_terima']){
			
				$worksheet->write($row, 0, 'Total PO '.$no_po.' pada tanggal '.$tgl_terima, $tbody_right_bold);
				$worksheet->write($row, 1, '', $tbody);
				$worksheet->write($row, 2, '', $tbody);
				$worksheet->write($row, 3, '', $tbody);
				$worksheet->write($row, 4, '', $tbody);
				$worksheet->write($row, 5, '', $tbody);
				$worksheet->write($row, 6, '', $tbody);
				$worksheet->write($row, 7, '', $tbody);
				$worksheet->write($row, 8, '', $tbody);
				$worksheet->write($row, 9, $subtotal_po, $tbody_currency_bold);
				$worksheet->setMerge($row, 0, $row, 8);
				
				$row++;
				
				$subtotal_po = 0;
			}
			
			$worksheet->write($row, 0, $tgl_terima != $rows2['tgl_terima'] ? $no : '', $tbody_center);
			$worksheet->write($row, 1, $tgl_terima != $rows2['tgl_terima'] ? $rows2['tgl_terima'] : '', $tbody_center);
			$worksheet->write($row, 2, $tgl_terima != $rows2['tgl_terima'] ? $rows2['no_po'] : '', $tbody_center);
			$worksheet->write($row, 3, ($no_gudang != $rows2['no_gudang'] || $tgl_terima != $rows2['tgl_terima']) ? $rows2['no_gudang'] : '', $tbody_center);
			$worksheet->write($row, 4, $rows2['no_faktur'], $tbody_center);
			$worksheet->write($row, 5, $rows2['namabarang'], $tbody);
			$worksheet->write($row, 6, $rows2['jml_msk'], $tbody_numeric);
			$worksheet->write($row, 7, $rows2['satuan_unit'], $tbody_center);
			$worksheet->write($row, 8, $rows2['harga_unit'], $tbody_currency);
			$worksheet->write($row, 9, $rows2['jml_msk'] * $rows2['harga_unit'], $tbody_currency);
			
			$row++;
			
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
		
		$worksheet->write($row, 0, 'Total Terima '.$no_gudang.' pada tanggal '.$tgl_terima, $tbody_right_bold);
		$worksheet->write($row, 1, '', $tbody);
		$worksheet->write($row, 2, '', $tbody);
		$worksheet->write($row, 3, '', $tbody);
		$worksheet->write($row, 4, '', $tbody);
		$worksheet->write($row, 5, '', $tbody);
		$worksheet->write($row, 6, '', $tbody);
		$worksheet->write($row, 7, '', $tbody);
		$worksheet->write($row, 8, '', $tbody);
		$worksheet->write($row, 9, $subtotal_gudang, $tbody_currency_bold);
		$worksheet->setMerge($row, 0, $row, 8);
		
		$row++;
		
		$worksheet->write($row, 0, 'Total PO '.$no_po.' pada tanggal '.$tgl_terima, $tbody_right_bold);
		$worksheet->write($row, 1, '', $tbody);
		$worksheet->write($row, 2, '', $tbody);
		$worksheet->write($row, 3, '', $tbody);
		$worksheet->write($row, 4, '', $tbody);
		$worksheet->write($row, 5, '', $tbody);
		$worksheet->write($row, 6, '', $tbody);
		$worksheet->write($row, 7, '', $tbody);
		$worksheet->write($row, 8, '', $tbody);
		$worksheet->write($row, 9, $subtotal_po, $tbody_currency_bold);
		$worksheet->setMerge($row, 0, $row, 8);
		
		$row++;
		
		$worksheet->write($row, 0, 'Total '.$rows['namarekanan'], $tbody_right_bold);
		$worksheet->write($row, 1, '', $tbody);
		$worksheet->write($row, 2, '', $tbody);
		$worksheet->write($row, 3, '', $tbody);
		$worksheet->write($row, 4, '', $tbody);
		$worksheet->write($row, 5, '', $tbody);
		$worksheet->write($row, 6, '', $tbody);
		$worksheet->write($row, 7, '', $tbody);
		$worksheet->write($row, 8, '', $tbody);
		$worksheet->write($row, 9, $subtotal_rekanan, $tbody_currency_bold);
		$worksheet->setMerge($row, 0, $row, 8);
		
		$row++;
	}
}

$worksheet->write($row, 1, '', $tbody);
$worksheet->write($row, 2, '', $tbody);
$worksheet->write($row, 3, '', $tbody);
$worksheet->write($row, 4, '', $tbody);
$worksheet->write($row, 5, '', $tbody);
$worksheet->write($row, 6, '', $tbody);
$worksheet->write($row, 7, '', $tbody);
$worksheet->write($row, 8, '', $tbody);
$worksheet->write($row, 9, '', $tbody);
$worksheet->setMerge($row, 0, $row, 9);

$row++;

$worksheet->write($row, 0, 'Total', $tbody_right_bold);
$worksheet->write($row, 1, '', $tbody);
$worksheet->write($row, 2, '', $tbody);
$worksheet->write($row, 3, '', $tbody);
$worksheet->write($row, 4, '', $tbody);
$worksheet->write($row, 5, '', $tbody);
$worksheet->write($row, 6, '', $tbody);
$worksheet->write($row, 7, '', $tbody);
$worksheet->write($row, 8, '', $tbody);
$worksheet->write($row, 9, $total, $tbody_currency_bold);
$worksheet->setMerge($row, 0, $row, 8);

$workbook->close();
?>

<?php
include "../sesi.php";
include("../koneksi/konek.php");
require_once('../Excell/Writer.php');

$tipe_trans=$_REQUEST['tipe_trans'];

if($tipe_trans=='0'){
	$ftipe="";	
}
else{
	if($tipe_trans=='1'){
		$ftipe="AND k_t.tipe_trans=".$tipe_trans."";
	}
	else if($tipe_trans=='2'){
		$ftipe="AND k_t.tipe_trans<>'1'";	
	}
}

$tglAwal=$_REQUEST["tglAwal"];
$t1 = explode('-',$tglAwal);
$tgl1 = $t1[2]."-".$t1[1]."-".$t1[0];

$tglAkhir=$_REQUEST["tglAkhir"];
$t2 = explode('-',$tglAkhir);
$tgl2 = $t2[2]."-".$t2[1]."-".$t2[0];
$btw = "WHERE k_t.tgl BETWEEN '$tgl1' AND '$tgl2'";

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Laporan BKU.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Laporan BKU');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 15;
$worksheet->setColumn (0, 1, 15);
$worksheet->setColumn (2, 3, 20);
$worksheet->setColumn (4, 4, 40);
$worksheet->setColumn (5, 6, 25);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>12,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0.00'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
$regularFormatI =& $workbook->addFormat(array('italic'=>1,'size'=>9,'align'=>'left','textWrap'=>1));
$sTotTitleL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left'));
$sTotTitleC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center'));
$sTotTitleR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','numFormat'=>'#,##0.00'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

$title4="( $tglAwal  s/d  $tglAkhir )";
//Write sheet title in upper left cell
$worksheet->write($row, 3, $pemkabRS, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 3, "RUMAH SAKIT UMUM DAERAH", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 3, "LAPORAN BKU", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 3, "$title4", $sheetTitleFormatC);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO.URUT", $columnTitleFormat);
$worksheet->write($row, $column+1, "TANGGAL", $columnTitleFormat);
$worksheet->write($row, $column+2, "NO BUKTI", $columnTitleFormat);
$worksheet->write($row, $column+3, "KODE REKENING", $columnTitleFormat);
$worksheet->write($row, $column+4, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+5, "PENERIMAAN (Rp.)", $columnTitleFormat);
$worksheet->write($row, $column+6, "PENGELUARAN (Rp.)", $columnTitleFormat);
$row += 1;

$worksheet->write($row, $column, "1", $columnTitleFormat);
$worksheet->write($row, $column+1, "2", $columnTitleFormat);
$worksheet->write($row, $column+2, "3", $columnTitleFormat);
$worksheet->write($row, $column+3, "4", $columnTitleFormat);
$worksheet->write($row, $column+4, "5", $columnTitleFormat);
$worksheet->write($row, $column+5, "6", $columnTitleFormat);
$worksheet->write($row, $column+6, "7", $columnTitleFormat);
$row += 1;

$i=1;
/*$sql = "SELECT k_t.id_trans,
k_t.tgl, 
DATE_FORMAT(k_t.tgl,'%d-%m-%Y')AS tgl2,k_t.no_bukti, 
ma.ma_kode, k_t.id_ma_dpa,m_tr.nama,k_t.ket,
m_tr.tipe, 
k_t.nilai,

IF(k_t.tipe_trans='1',k_t.nilai,0) AS pen,
IF(k_t.tipe_trans<>'1',k_t.nilai,0) AS peng, 

CASE m_tr.tipe 
WHEN '1' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai)
WHEN '3' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai)
ELSE NULL END AS PENERIMAAN, 

CASE m_tr.tipe 
WHEN '2' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai) 
ELSE NULL END AS PENGELUARAN,

IFNULL(k_td.unit_id,0) unit_id,
k_td.nilai,
k_td.pajak_id,

IF(k_td.unit_id='0',(SELECT MA_NAMA FROM $dbakuntansi.ma_sak WHERE MA_ID=k_td.pajak_id),(SELECT nama FROM $dbakuntansi.ak_ms_unit WHERE id=k_td.unit_id)) AS ket2,
IF(k_td.unit_id IS NULL,CONCAT(IFNULL(m_tr.nama,''),' (',k_t.ket,')'),CONCAT(IFNULL(m_tr.nama,k_t.ket),' - ',(SELECT nama FROM $dbakuntansi.ak_ms_unit WHERE id=k_td.unit_id))) AS URAIAN3

FROM $dbkeuangan.k_transaksi AS k_t LEFT JOIN 
$dbkeuangan.k_ms_transaksi m_tr ON m_tr.id=k_t.id_trans LEFT JOIN 
$dbanggaran.ms_ma AS ma ON ma.ma_id=k_t.id_ma_dpa LEFT JOIN 
$dbkeuangan.k_transaksi_detail AS k_td ON k_td.transaksi_id=k_t.id $btw $ftipe ORDER BY k_t.tgl";
*/
$sql = "SELECT k_t.id_trans, k_t.tgl, DATE_FORMAT(k_t.tgl,'%d-%m-%Y')AS tgl2,k_t.no_bukti, ma.ma_kode, 
k_t.id_ma_dpa,IFNULL(m_tr.nama,jt.JTRANS_NAMA) nama,k_t.ket, m_tr.tipe, k_t.nilai, IF(k_t.tipe_trans='1',k_t.nilai,0) AS pen, 
IF(k_t.tipe_trans<>'1',k_t.nilai,0) AS peng, 
CONCAT(m_tr.nama,k_t.ket) AS URAIAN3,jt.JTRANS_NAMA 
FROM $dbkeuangan.k_transaksi AS k_t LEFT JOIN $dbkeuangan.k_ms_transaksi m_tr ON m_tr.id=k_t.id_trans 
LEFT JOIN $dbanggaran.ms_ma AS ma ON ma.ma_id=k_t.id_ma_dpa 
LEFT JOIN $dbakuntansi.jenis_transaksi jt ON k_t.id_trans=jt.JTRANS_ID
$btw $ftipe ORDER BY k_t.tgl";
//echo $sql;
$q = mysql_query($sql);
while($d = mysql_fetch_array($q))
{
	$namaTrans=$d['nama']." (".$d['ket'].")";
	if (($d['tipe']==1 || $d['tipe']==3) && $d['URAIAN3']!=""){
		$namaTrans=$d['URAIAN3'];
	}elseif ($d['unit_id']>0){
		$namaTrans=$d['URAIAN3'];
	}

	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $d['tgl2'], $regularFormatC);
	$worksheet->write($row, 2, $d['no_bukti'], $regularFormatC);
	$worksheet->write($row, 3, $d['ma_kode'], $regularFormatC);
	$worksheet->write($row, 4, $namaTrans, $regularFormatL);
	$worksheet->write($row, 5, $d['pen'], $regularFormatR);
	$worksheet->write($row, 6, $d['peng'], $regularFormatR);
	$i++;
	$row += 1;
}

$workbook->close();
?>
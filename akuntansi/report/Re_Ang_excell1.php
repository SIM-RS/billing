<?php
include "../sesi.php";
include("../koneksi/konek.php");
require_once('../Excell/Writer.php');

  $mon = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
  $mon2 = array("","01","02","03","04","05","06","07","08","09","10","11","12");
  $bln = $_REQUEST['cmbBln'];
  $bulan = $mon[$bln]; $bulan_u = strtoupper($bulan);
  $bulan2 = $mon2[$bln]; $bulan2_u = strtoupper($bulan2);
  $thn = $_REQUEST['cmbThn'];

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Laporan Realisasi Anggaran.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Laporan Realisasi Anggaran');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 15;
$worksheet->setColumn (0, 1, 35);
$worksheet->setColumn (2, 2, 45);
$worksheet->setColumn (3, 3, 40);
$worksheet->setColumn (4, 5, 40);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>11));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>11,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
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

$title4="BULAN $bulan_u $thn";
//Write sheet title in upper left cell
$worksheet->write($row, 0, $pemkabRS, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 0, "REALISASI ANGGARAN PENDAPATAN DAN BELANJA SKPD", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 0, "$title4", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 2;

$worksheet->write($row, $column, "Urusan Pemerintahan", $regularFormat);
$worksheet->write($row, $column+1, ": 102 Kesehatan", $regularFormat);
$row += 1;
$worksheet->write($row, $column, "Organisasi", $regularFormat);
$worksheet->write($row, $column+1, ": 102.02 Rumah Sakit Umum Daerah", $regularFormat);
$row += 1;

$worksheet->write($row, $column, "KODE REKENING", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+2, "JUMLAH ANGGARAN TAHUN ".$thn, $columnTitleFormat);
$worksheet->write($row, $column+3, "REALISASI BULAN ".$bulan_u, $columnTitleFormat);
$worksheet->write($row, $column+4, "SISA TARGET/ANGGARAN", $columnTitleFormat);
$worksheet->write($row, $column+5, "PROSENTASE %", $columnTitleFormat);
$row += 1;

$worksheet->write($row, $column, "1", $columnTitleFormat);
$worksheet->write($row, $column+1, "2", $columnTitleFormat);
$worksheet->write($row, $column+2, "3", $columnTitleFormat);
$worksheet->write($row, $column+3, "4", $columnTitleFormat);
$worksheet->write($row, $column+4, "5", $columnTitleFormat);
$worksheet->write($row, $column+5, "6", $columnTitleFormat);
$row += 1;


$i=1;
$sql = "SELECT ma_id,ma_kode,ma_nama FROM dbanggaran.ms_ma";
$q = mysql_query($sql);
while($d=mysql_fetch_array($q))
{
  $sql2 = "SELECT SUM(rba_nilai)AS nilai FROM dbanggaran.rba WHERE ma_id='$d[ma_id]' AND rba_tahun='$thn'";
  $q2 = mysql_query($sql2);
  $d2=mysql_fetch_array($q2);
  
  $like = $thn."-".$bulan2;
  $sql3 = "SELECT SUM(nilai)AS nilai FROM keuangan.k_transaksi WHERE id_ma_dpa='$d[ma_id]' AND tgl LIKE '$like%'";
  $q3 = mysql_query($sql3);
  $d3=mysql_fetch_array($q3);
  
  $selisih = $d2['nilai']-$d3['nilai'];
  if($d2['nilai']==0)
  {
  	$prosentase="";
  }
  else
  {
  	$prosentase = ($selisih/$d2['nilai'])*100;
	}
//echo $sql;
$worksheet->write($row, 0, $d['ma_kode'], $regularFormatL);
$worksheet->write($row, 1, $d['ma_nama'], $regularFormatL);
$worksheet->write($row, 2, $d2['nilai'], $regularFormatR);
$worksheet->write($row, 3, $d3['nilai'], $regularFormatR);
$worksheet->write($row, 4, $selisih, $regularFormatR);
$worksheet->write($row, 5, $prosentase, $regularFormatR);
$i++;
$row += 1;
}

$workbook->close();
?>
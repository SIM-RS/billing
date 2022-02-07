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
$columnWidth = 40;
$worksheet->setColumn (0, 0, 35);
$worksheet->setColumn (1, 1, 60);
$worksheet->setColumn (2, 2, 40);
for($i=1;$i<$bln;$i++){
	$worksheet->setColumn (2+$i, 2+$i, 40);	
}
$worksheet->setColumn (2+$i, 2+$i, 40);
$worksheet->setColumn (3+$i, 3+$i, 40);
$worksheet->setColumn (4+$i, 4+$i, 40);
$worksheet->setColumn (5+$i, 5+$i, 40);
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
for($i=1;$i<$bln;$i++){
	$worksheet->write($row, $column+2+$i, "REALISASI S/D BULAN ".$mon[$i], $columnTitleFormat);
}
$worksheet->write($row, $column+2+$i, "REALISASI BULAN ".$bulan_u, $columnTitleFormat);
$worksheet->write($row, $column+3+$i, "REALISASI S/D BULAN ".$bulan_u, $columnTitleFormat);
$worksheet->write($row, $column+4+$i, "SISA TARGET/ANGGARAN", $columnTitleFormat);
$worksheet->write($row, $column+5+$i, "PROSENTASE %", $columnTitleFormat);
$row += 1;

$worksheet->write($row, $column, "1", $columnTitleFormat);
$worksheet->write($row, $column+1, "2", $columnTitleFormat);
$worksheet->write($row, $column+2, "3", $columnTitleFormat);
for($i=1;$i<$bln;$i++){
	$worksheet->write($row, $column+2+$i, 3+$i, $columnTitleFormat);
}
$worksheet->write($row, $column+2+$i, 3+$i, $columnTitleFormat);
$worksheet->write($row, $column+3+$i, 4+$i, $columnTitleFormat);
$worksheet->write($row, $column+4+$i, 5+$i, $columnTitleFormat);
$worksheet->write($row, $column+5+$i, 6+$i, $columnTitleFormat);
$row += 1;


$i=1;
$sql = "SELECT ma_id,ma_kode,ma_nama,ma_kode2 FROM $dbanggaran.ms_ma order by ma_kode2";
$q = mysql_query($sql);
while($d=mysql_fetch_array($q))
{
  $sql2 = "SELECT IFNULL(SUM(rba.rba_nilai),0) AS nilai FROM $dbanggaran.rba rba INNER JOIN $dbanggaran.ms_ma ma 
  			ON rba.ma_id=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND rba.rba_tahun='$thn'";
  $q2 = mysql_query($sql2);
  $d2=mysql_fetch_array($q2);
  
  $like = $thn."-".$bulan2;
  $sql3 = "SELECT IFNULL(SUM(t.nilai),0) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
  			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND t.tgl LIKE '$like%'";
  $q3 = mysql_query($sql3);
  $d3=mysql_fetch_array($q3);
  
  
//echo $sql;
$worksheet->write($row, 0, $d['ma_kode'], $regularFormatL);
$worksheet->write($row, 1, $d['ma_nama'], $regularFormatL);
$worksheet->write($row, 2, $d2['nilai'], $regularFormatR);
for($i=1;$i<$bln;$i++){
	$sNil="SELECT IFNULL(SUM(t.nilai),0) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND MONTH(t.tgl) BETWEEN '1' AND '".$i."' AND YEAR(t.tgl)='".$thn."'";
	$qNil=mysql_query($sNil);
	$rwNil=mysql_fetch_array($qNil);
	
	$worksheet->write($row, 2+$i, $rwNil['nilai'], $regularFormatR);
}
$worksheet->write($row, 2+$i, $d3['nilai'], $regularFormatR);
	$sCNil="SELECT IFNULL(SUM(t.nilai),0) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND MONTH(t.tgl) BETWEEN '1' AND '".$bln."' AND YEAR(t.tgl)='".$thn."'";
	$qCNil=mysql_query($sCNil);
	$rwCNil=mysql_fetch_array($qCNil);
$worksheet->write($row, 3+$i, $rwCNil['nilai'], $regularFormatR);
	$selisih = $d2['nilai']-$rwCNil['nilai'];
  	if($d2['nilai']==0)
  	{
  		$prosentase="";
  	}
  	else
  	{
  		$prosentase = ($selisih/$d2['nilai'])*100;
	}
$worksheet->write($row, 4+$i, $selisih, $regularFormatR);
$worksheet->write($row, 5+$i, $prosentase, $regularFormatR);
$i++;
$row += 1;
}

$workbook->close();
?>
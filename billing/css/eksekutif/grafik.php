<?php
session_start();
include "../sesi.php";
?>
<?php
   /*
     Example1 : A simple line chart
 */

 // Standard inclusions
if (!extension_loaded('gd')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        dl('gd.dll');
    } else {
        dl('gd.so');
    }
}
 include("../pChart/pData.class");   
 include("../pChart/pChart.class");
 include("../koneksi/konek.php");
  
$periode = $_REQUEST['periode'];
$thn = $_REQUEST['thn'];
$tmp = $_REQUEST['tmp'];
$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$tmpLay = $_REQUEST['tmpLay'];
$jnsLay = $_REQUEST['jnsLay'];
if($tmpLay==0){
	$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
}else{
	$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
}

 // Dataset definition     
 $DataSet = new pData;   
 
switch($periode){
   case 'bulanan':
   $Requete = "SELECT MONTH(b_pelayanan.tgl) AS bulan, SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru, SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama
   FROM b_kunjungan 
   INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
   WHERE $fTmp  AND YEAR(b_pelayanan.tgl)='$thn'
   GROUP BY MONTH(b_pelayanan.tgl)";
   
   $result  = mysql_query($Requete);
   while ($row = mysql_fetch_array($result))
   {
    $DataSet->AddPoint($row["baru"],"Serie1");
    $DataSet->AddPoint($row["lama"],"Serie2");
    $DataSet->AddPoint($arrBln[$row["bulan"]],"XLabel"); 
   }
    $DataSet->SetAbsciseLabelSerie("XLabel");
    //$DataSet->AddAllSeries();
    $DataSet->AddSerie("Serie1");
   $DataSet->AddSerie("Serie2");
    //$DataSet->SetAbsciseLabelSerie();   
    $DataSet->SetSerieName("KUNJUNGAN BARU","Serie1");
    $DataSet->SetSerieName("KUNJUNGAN LAMA","Serie2");
    $DataSet->SetYAxisName("JUMLAH PASIEN");
   break;
   case 'tahunan':
      $Requete = "SELECT YEAR(b_pelayanan.tgl) AS tahun,
SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru, 
SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama
FROM b_kunjungan 
INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
WHERE $fTmp AND YEAR(b_pelayanan.tgl) BETWEEN '".($thn-1)."' AND '$thn' 
GROUP BY YEAR(b_pelayanan.tgl);";
   
   $result  = mysql_query($Requete);
   while ($row = mysql_fetch_array($result))
   {
    $DataSet->AddPoint($row["baru"],"Serie1");
    $DataSet->AddPoint($row["lama"],"Serie2");
    $DataSet->AddPoint($row["tahun"],"XLabel"); 
   }
    $DataSet->SetAbsciseLabelSerie("XLabel");
    //$DataSet->AddAllSeries();
    $DataSet->AddSerie("Serie1");
   $DataSet->AddSerie("Serie2");
    //$DataSet->SetAbsciseLabelSerie();   
    $DataSet->SetSerieName("KUNJUNGAN BARU","Serie1");
    $DataSet->SetSerieName("KUNJUNGAN LAMA","Serie2");
    $DataSet->SetYAxisName("JUMLAH PASIEN");
      break;
}
 
 //$DataSet->SetYAxisUnit("µs");

  // Initialise the graph
  $Test = new pChart(1000,450); //ukuran grafik
  $Test->setFontProperties("Fonts/tahoma.ttf",8);
  $Test->setGraphArea(200,30,900,400); //ngeset ukuran grafik dalem
  $Test->drawFilledRoundedRectangle(7,7,973,423,5,240,240,240);
  $Test->drawRoundedRectangle(5,5,975,425,5,230,230,230);
  $Test->drawGraphArea(255,255,255,TRUE);
  $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);   
  $Test->drawGrid(4,TRUE,230,230,230,50);

  // Draw the 0 line
  $Test->setFontProperties("Fonts/tahoma.ttf",6);
  $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

  // Draw the bar graph
  $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);

  // Finish the graph
  $Test->setFontProperties("Fonts/tahoma.ttf",8);
  $Test->drawLegend(10,30,$DataSet->GetDataDescription(),255,255,255);
  $Test->setFontProperties("Fonts/tahoma.ttf",12);
  $Test->drawTitle(500,20,"DATA KUNJUNGAN ".$tmp." ".$thn,50,50,50,585);
  
 $Test->Stroke("example1.png");
  
?>
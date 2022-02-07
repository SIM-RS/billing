<?php
session_start();
include "../sesi.php";
?>
<?php
/*
Example1 : A simple line chart
*/

// Standard inclusions      
include("../pChart/pData.class");   
include("../pChart/pChart.class");
include("../koneksi/konek.php");
$periode = $_REQUEST['periode'];
$tmp = $_REQUEST['tmp'];
$thn = $_REQUEST['thn'];
$tmpLay = $_REQUEST['tmpLay'];
$jnsLay = $_REQUEST['jnsLay'];
if($tmpLay==0){
	$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
}else{
	$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
}
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

// Dataset definition     
$DataSet = new pData;   


$Requete = "SELECT YEAR(b_pelayanan.tgl) AS tahun, b_ms_unit.nama, COUNT(b_pelayanan.id) AS jml
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
WHERE $fTmp AND YEAR(b_pelayanan.tgl) BETWEEN '".($thn-1)."' AND '$thn'
GROUP BY YEAR(b_pelayanan.tgl), b_ms_unit.id";
$result  = mysql_query($Requete);
while ($row = mysql_fetch_array($result))
{
	$DataSet->AddPoint($row["satu"],"Serie1");
	$DataSet->AddPoint($row["dua"],"Serie2");
	$DataSet->AddPoint($row["tiga"],"Serie3");
	$DataSet->AddPoint($row["empat"],"Serie4");
	$DataSet->AddPoint($row["lima"],"Serie5");
	$DataSet->AddPoint($row["enam"],"Serie6");
	$DataSet->AddPoint($row["tahun"],"XLabel"); 
}
$DataSet->SetAbsciseLabelSerie("XLabel");
//$DataSet->AddAllSeries();
$DataSet->AddSerie("Serie1");
$DataSet->AddSerie("Serie2");
$DataSet->AddSerie("Serie3");
$DataSet->AddSerie("Serie4");
$DataSet->AddSerie("Serie5");
$DataSet->AddSerie("Serie6");
//$DataSet->SetAbsciseLabelSerie();   
$DataSet->SetSerieName("APS","Serie1");
$DataSet->SetSerieName("ATAS IJIN DOKTER","Serie2");
$DataSet->SetSerieName("DIRUJUK","Serie3");
$DataSet->SetSerieName("MELARIKAN DIRI","Serie4");
$DataSet->SetSerieName("MENINGGAL","Serie5");
$DataSet->SetSerieName("MRS","Serie6");
$DataSet->SetYAxisName("JUMLAH PASIEN");
	
//$DataSet->SetYAxisUnit("µs");

// Initialise the graph
$Test = new pChart(1000,450);
$Test->setFontProperties("Fonts/tahoma.ttf",8);
$Test->setGraphArea(200,30,900,400);
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
$Test->drawTitle(500,20,"DATA PASKA KUNJUNGAN ".$tmp." ".$thn,50,50,50,585);

$Test->Stroke("example1.png");
?>
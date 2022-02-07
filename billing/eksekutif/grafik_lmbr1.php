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

$thn = $_REQUEST['thn'];
$tmp = $_REQUEST['tmp'];
$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$tmpLay = $_REQUEST['tmpLay'];
$jnsLay = $_REQUEST['jnsLay'];
if($tmpLay==0) {
    $fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
}else {
    $fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
}

// Dataset definition     
$DataSet = new pData;   


$Requete = "SELECT MONTH(b_pelayanan.tgl) AS bulan, b_ms_unit.nama, COUNT(b_pelayanan.id) AS jml
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' AND b_kunjungan.isbaru=0
GROUP BY MONTH(b_pelayanan.tgl), b_ms_unit.id";


$result  = mysql_query($Requete);
$i=0;
$tmp_nama = array();
$tmp_jml = array();
$tmp_bln = array();
while ($row = mysql_fetch_array($result)) {
    //untuk menentukan array bulan
    $point_bln = 0;
    if(count($tmp_bln) == 0){
        $tmp_bln[$point_bln] = $arrBln[$row['bulan']];// untuk menampung bulan sekarang
    }
    else{
        $ada = false;
        for($i=0; $i<=count($tmp_bln); $i++){
            if($tmp_bln[$i] == $arrBln[$row['bulan']]){
                $ada = true;
                $point_bln = $i;
            }
        }
        if($ada == false){
            $point_bln = count($tmp_bln);
            $tmp_bln[$point_bln] = $arrBln[$row['bulan']];
        }
    }
    //echo $arrBln[$row['bulan']].'<br>';
    
    //untuk menentukan array nama unit
    $point_nama = 0;
    if(count($tmp_nama) == 0){
        $tmp_nama[$point_bln] = $row['nama'];
    }
    else{
        $ada = false;
        for($i=0; $i<=count($tmp_nama); $i++){
            if($tmp_nama[$i] == $row['nama']){
                $ada = true;
                $point_nama = $i;
            }
        }
        if($ada == false){
            $point_nama = count($tmp_nama);
            $tmp_nama[$point_nama] = $row['nama'];
        }
    }

    //untuk menentukan array jumlah
    $tmp_jml[$point_bln] [$point_nama] = $row['jml'];

    //untuk menentukan legenda sumbu X
  if($namaBulan!=$row['bulan']){
        $DataSet->AddPoint($arrBln[$row["bulan"]],"XLabel");
        $namaBulan = $row['bulan'];
    }
}
/*for($i=0; $i<count($tmp_bln); $i++){
    echo 'bln='.$tmp_bln[$i].'<br>';
}*/
//echo 'jml bln='.count($tmp_bln).', jml nama='.count($tmp_nama).'</br>';
for($i=0; $i<count($tmp_bln); $i++){
    for($j=0; $j<count($tmp_nama); $j++){
        /*echo 'bln='.$tmp_bln[$i].',unit='.$tmp_nama[$j].',jml='.$tmp_jml[$i][$j].'</br>';
        
        /*}else {
            $DataSet->AddPoint($row["jml"],"Serie".$i);
        }*/
           // $i++;
        //echo $i.' ';
        $jmlnya = $tmp_jml[$i][$j];
        if($jmlnya == ''){
            $jmlnya = 0;
        }
        $DataSet->AddSerie("Serie".$j);
        $DataSet->AddPoint($jmlnya,"Serie".$j);
        //$DataSet->AddPoint($row['nama'],"XLabel");
        $DataSet->SetSerieName($tmp_nama[$j],"Serie".$j);
    }
}

$DataSet->SetAbsciseLabelSerie("XLabel");
//$DataSet->AddAllSeries();
//$DataSet->AddSerie("Serie2");
//$DataSet->SetAbsciseLabelSerie();


//$DataSet->SetSerieName("XLabel","Serie1");
//$DataSet->SetSerieName("LAMA","Serie2");
$DataSet->SetYAxisName("Jumlah Pasien");


//$DataSet->SetYAxisUnit("�s");

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
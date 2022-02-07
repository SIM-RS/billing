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


$Requete = "SELECT t.bulan,u.nama,COUNT(t.id) AS jml
FROM (SELECT b_pelayanan.id, b_pelayanan.tgl,MONTH(b_pasien_keluar.tgl_act) as bulan, b_pelayanan.unit_id,b_pelayanan.tgl_krs, 
b_tindakan_kamar.tgl_in, b_tindakan_kamar.tgl_out, 
IF(b_tindakan_kamar.status_out=0, 
(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,1, 
DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))), 
(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0, 
DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS qtyHari 
FROM b_pelayanan 
INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id 
WHERE b_pasien_keluar.keadaan_keluar LIKE '%meninggal' 
AND YEAR(b_pasien_keluar.tgl_act)='$thn' 
AND $fTmp ) AS t 
INNER JOIN b_ms_unit u on u.id=t.unit_id
WHERE t.qtyHari>2 GROUP BY t.unit_id,t.bulan order by bulan";


$result  = mysql_query($Requete);
$i=0;
$tmp_nama = array();
$tmp_jml = array();
$tmp_bln = array();
while ($row = mysql_fetch_array($result)) {
    //untuk menentukan array bulan
    $point_bln = 0;
    if(count($tmp_bln) == 0){
        $tmp_bln[$i] = $arrBln[$row['bulan']];
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
        $tmp_nama[$i] = $row['nama'];
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
$Test = new pChart(900,230);
$Test->setFontProperties("Fonts/tahoma.ttf",8);
$Test->setGraphArea(180,30,680,200);
$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
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
$Test->setFontProperties("Fonts/tahoma.ttf",10);
$Test->drawTitle(50,22,"DATA KUNJUNGAN ".$tmp." ".$thn,50,50,50,585);

$Test->Stroke("example1.png");
?>
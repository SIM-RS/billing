<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$bln1=$_REQUEST["bln1"];
$bln1=explode("|",$bln1);
//$ta1="2009";
$ta1=$_REQUEST["ta1"];
$day1 = cal_days_in_month(CAL_GREGORIAN, $bln1[0], $ta1);
//$tgl2="1";
$tgl2=$_REQUEST["tgl2"];
if ($tgl2=="1"){
	//$bln2="12|DESEMBER";
	$bln2=$_REQUEST["bln2"];
	$bln2=explode("|",$bln2);
	//$ta2="2008";
	$ta2=$_REQUEST["ta2"];
	$day2 = cal_days_in_month(CAL_GREGORIAN, $bln2[0], $ta2);
}

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Neraca.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Neraca');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
if ($tgl2=="1"){
$worksheet->setColumn (0, 0, 5);
$worksheet->setColumn (1, 1, 65);
$worksheet->setColumn (2, 2, 20);
$worksheet->setColumn (3, 3, 20);
$worksheet->setColumn (4, 4, 5);
$worksheet->setColumn (5, 5, 65);
$worksheet->setColumn (6, 6, 20);
$worksheet->setColumn (7, 7, 20);
}else{
$worksheet->setColumn (0, 0, 5);
$worksheet->setColumn (1, 1, 65);
$worksheet->setColumn (2, 2, 20);
$worksheet->setColumn (3, 3, 5);
$worksheet->setColumn (4, 4, 65);
$worksheet->setColumn (5, 5, 20);
}
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12,'align'=>'center'));
$sheetTitleFormat2 =& $workbook->addFormat(array('size'=>11,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'blue','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0.00'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatB =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
$regularFormatRB =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

if ($tgl2=="1") $title4="PER $day1 $bln1[1] $ta1 DAN PER $day2 $bln2[1] $ta2"; else $title4="PER $day1 $bln1[1] $ta1";
$row += 1;
$worksheet->write($row, 2, "PT. PELABUHAN INDONESIA I (Persero) RS. PELABUHAN MEDAN ", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 2, "N E R A C A", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 2, "$title4", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 2, "(DALAM RUPIAH)", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 2;



if ($tgl2=="1"){
	$worksheet->write($row, $column, "KR", $columnTitleFormat);
	$worksheet->write($row, $column+1, "U R A I A N", $columnTitleFormat);
	$worksheet->write($row, $column+2, "$bln1[1] $ta1", $columnTitleFormat);
	$worksheet->write($row, $column+3, "$bln2[1] $ta2", $columnTitleFormat);
	$worksheet->write($row, $column+4, "KR", $columnTitleFormat);
	$worksheet->write($row, $column+5, "U R A I A N", $columnTitleFormat);
	$worksheet->write($row, $column+6, "$bln1[1] $ta1", $columnTitleFormat);
	$worksheet->write($row, $column+7, "$bln2[1] $ta2", $columnTitleFormat);

}else{
	$worksheet->write($row, $column, "KR", $columnTitleFormat);
	$worksheet->write($row, $column+1, "U R A I A N", $columnTitleFormat);
	$worksheet->write($row, $column+2, "NILAI", $columnTitleFormat);
	$worksheet->write($row, $column+3, "KR", $columnTitleFormat);
	$worksheet->write($row, $column+4, "U R A I A N", $columnTitleFormat);
	$worksheet->write($row, $column+5, "NILAI", $columnTitleFormat);
	
}


$row++;
//$sql="select * from ma_sak where MA_LEVEL<=3 and MA_AKTIF=1 and left(MA_KODE,1)<4 order by MA_KODE";
$sql="select * from lap_neraca where isaktif=1 and aktiva_passiva=0 order by id + 0";
$rs=mysql_query($sql);
while ($t=mysql_fetch_array($rs)){

$ikode=$t["kode_ma_sak"];
						$tipe=$t["tipe"];
						$klmpk=$t["klmpk"];
						$cdk=$t["d_k"];
						$cformula=str_replace(" ","",$t["formula"]);
						$cnilai=0;
						$cnilai2=0;
						
						if ($ikode!=""){
						
							//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita1' AND s.BULAN='$ibulan1' AND sak.MA_KODE LIKE '$ikode%'";
							
							$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)=$bln1[0]  AND YEAR(j.TGL)='$ta1'";
							
							$rs1=mysql_query($sql);
							$rw1=mysql_fetch_array($rs1);
							if($cdk=='D'){
							$cnilai=$rw1["D"]-$rw1["K"];
							}else{
							$cnilai=$rw1["K"]-$rw1["D"];
							}
							//$cnilai=$rw1["nilai"];
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							
							}else{
							$strnilai="(".number_format($cnilai,0,",",".").")";
							
							}
							
						
							if ($tgl2=="1"){
								//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita2' AND s.BULAN='$ibulan2' AND sak.MA_KODE LIKE '$ikode%'";
								$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)=$bln2[0] AND YEAR(j.TGL)='$ta2'";
								$rs2=mysql_query($sql);
								$rw2=mysql_fetch_array($rs2);
								if($cdk=='D'){
									$cnilai2=$rw2["D"]-$rw2["K"];
									}else{
									$cnilai2=$rw2["K"]-$rw2["D"];
									}
								if($cnilai2>=0){
								$strnilai2=number_format($cnilai2,0,",",".");
								}else{
								$strnilai2="(".number_format($cnilai2,0,",",".").")";
								}
							}
						}
						
						
						if ($tipe==0){
							$strnilai="";
							$strnilai2="";
							$cnilai=0;
							$cnilai2=0;
						}elseif ($tipe==2){
							$cform=array();
							$j=0;
							for ($i=0;$i<strlen($cformula);$i++){
								if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
									$cform[$j]=substr($cformula,$i,1);
									$j++;
								}
							}
						//echo "count=".count($cform)."<br>";
							$cdata=str_replace("-",",",$cformula);
							$cdata=str_replace("+",",",$cdata);
							$cdata=explode(",",$cdata);
							$cnilai=$subtot[$cdata[0]];
							$cnilai2=$subtot2[$cdata[0]];
							//echo $cnilai."<br>";
							for ($i=1;$i<count($cdata);$i++){
								$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]]):($cnilai+$subtot[$cdata[$i]]);
								$cnilai2=($cform[$i-1]=="-")?($cnilai2-$subtot2[$cdata[$i]]):($cnilai2+$subtot2[$cdata[$i]]);
								//echo $subtot[$cdata[$i]-1]."<br>";
							}
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							//$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							$strnilai="(".number_format($cnilai,0,",",".").")";
							//$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							if($cnilai2>=0){
							//$strnilai=number_format($cnilai,0,",",".");
							$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							//$strnilai="(".number_format($cnilai,0,",",".").")";
							$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							
							$cnilai=0;
							$cnilai2=0;
						
						}
						
						if ($klmpk>0){
							$subtot[$klmpk] +=$cnilai;
							$subtot2[$klmpk] +=$cnilai2;
						}
						
						if($t['klmpk']=='0'){

						$worksheet->write($row, 0, $t['kode'], $regularFormatCB);
						$worksheet->write($row, 1, $t['nama'], $regularFormatB);
						$worksheet->write($row, 2, $strnilai, $regularFormatRB);
						if ($tgl2=="1"){
						$worksheet->write($row, 3, $strnilai2, $regularFormatRB);
						}
					
					
						}else{
					
						$worksheet->write($row, 0, $t['kode'], $regularFormatC);
						$worksheet->write($row, 1, $t['nama'], $regularFormat);
						$worksheet->write($row, 2, $strnilai, $regularFormatR);
						if ($tgl2=="1"){
						$worksheet->write($row, 3, $strnilai2, $regularFormatR);
						}
					
					
					    }
						
			
					
					
	$row++;
}
$row = 7;
$sql="select * from lap_neraca where isaktif=1 and aktiva_passiva=1 order by id + 0";
$rs=mysql_query($sql);
while ($t=mysql_fetch_array($rs)){

$ikode=$t["kode_ma_sak"];
						$tipe=$t["tipe"];
						$klmpk=$t["klmpk"];
						$cdk=$t["d_k"];
						$cformula=str_replace(" ","",$t["formula"]);
						$cnilai=0;
						$cnilai2=0;
						
						if ($ikode!=""){
						
							//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita1' AND s.BULAN='$ibulan1' AND sak.MA_KODE LIKE '$ikode%'";
							
							$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)=$bln1[0]  AND YEAR(j.TGL)='$ta1'";
							
							$rs1=mysql_query($sql);
							$rw1=mysql_fetch_array($rs1);
							if($cdk=='D'){
							$cnilai=$rw1["D"]-$rw1["K"];
							}else{
							$cnilai=$rw1["K"]-$rw1["D"];
							}
							//$cnilai=$rw1["nilai"];
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							
							}else{
							$strnilai="(".number_format($cnilai,0,",",".").")";
							
							}
							
						
							if ($tgl2=="1"){
								//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita2' AND s.BULAN='$ibulan2' AND sak.MA_KODE LIKE '$ikode%'";
								$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)=$bln2[0] AND YEAR(j.TGL)='$ta2'";
								$rs2=mysql_query($sql);
								$rw2=mysql_fetch_array($rs2);
								if($cdk=='D'){
									$cnilai2=$rw2["D"]-$rw2["K"];
									}else{
									$cnilai2=$rw2["K"]-$rw2["D"];
									}
								if($cnilai2>=0){
								$strnilai2=number_format($cnilai2,0,",",".");
								}else{
								$strnilai2="(".number_format($cnilai2,0,",",".").")";
								}
							}
						}
						
						
						if ($tipe==0){
							$strnilai="";
							$strnilai2="";
							$cnilai=0;
							$cnilai2=0;
						}elseif ($tipe==2){
							$cform=array();
							$j=0;
							for ($i=0;$i<strlen($cformula);$i++){
								if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
									$cform[$j]=substr($cformula,$i,1);
									$j++;
								}
							}
						//echo "count=".count($cform)."<br>";
							$cdata=str_replace("-",",",$cformula);
							$cdata=str_replace("+",",",$cdata);
							$cdata=explode(",",$cdata);
							$cnilai=$subtot[$cdata[0]];
							$cnilai2=$subtot2[$cdata[0]];
							//echo $cnilai."<br>";
							for ($i=1;$i<count($cdata);$i++){
								$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]]):($cnilai+$subtot[$cdata[$i]]);
								$cnilai2=($cform[$i-1]=="-")?($cnilai2-$subtot2[$cdata[$i]]):($cnilai2+$subtot2[$cdata[$i]]);
								//echo $subtot[$cdata[$i]-1]."<br>";
							}
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							//$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							$strnilai="(".number_format($cnilai,0,",",".").")";
							//$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							if($cnilai2>=0){
							//$strnilai=number_format($cnilai,0,",",".");
							$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							//$strnilai="(".number_format($cnilai,0,",",".").")";
							$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							
							$cnilai=0;
							$cnilai2=0;
						
						}
						
						if ($klmpk>0){
							$subtot[$klmpk] +=$cnilai;
							$subtot2[$klmpk] +=$cnilai2;
						}
					
						if ($tgl2=="1"){
							if($t['klmpk']=='0'){
						
								$worksheet->write($row, 4, $t['kode'], $regularFormatCB);
								$worksheet->write($row, 5, $t['nama'], $regularFormatB);
								$worksheet->write($row, 6, $strnilai, $regularFormatRB);
								$worksheet->write($row, 7, $strnilai2, $regularFormatRB);
							}else{
								$worksheet->write($row, 4, $t['kode'], $regularFormatC);
								$worksheet->write($row, 5, $t['nama'], $regularFormat);
								$worksheet->write($row, 6, $strnilai, $regularFormatR);
								$worksheet->write($row, 7, $strnilai2, $regularFormatR);
									
							}
						}else{
							if($t['klmpk']=='0'){
						
								$worksheet->write($row, 3, $t['kode'], $regularFormatCB);
								$worksheet->write($row, 4, $t['nama'], $regularFormatB);
								$worksheet->write($row, 5, $strnilai, $regularFormatRB);
								
								
								}else{
							
								$worksheet->write($row, 3, $t['kode'], $regularFormatC);
								$worksheet->write($row, 4, $t['nama'], $regularFormat);
								$worksheet->write($row, 5, $strnilai, $regularFormatR);
							}
						
						}
					
					
	$row++;
}
$row += 2;
$worksheet->write($row, 2, "Belawan, ", $sheetTitleFormat2);
$row += 1;
$worksheet->write($row, 2, "RUMAH SAKIT PELABUHAN MEDAN", $sheetTitleFormat2);
$row += 1;
$worksheet->write($row, 2, "Plt. KEPALA", $sheetTitleFormat2);
$row += 3;
$worksheet->write($row, 2, "Dr. AUSVIN GENIUSMAN KOMAINI, M.H.Kes ", $sheetTitleFormat2);

$workbook->close();
mysql_close($konek);
?>
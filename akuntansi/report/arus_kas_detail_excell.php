<?php 
include "../sesi.php";
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$sak_sap=$_REQUEST["sak_sap"];
if ($sak_sap=="") $sak_sap="1";
if ($sak_sap=="1"){
	$jdl_lap="ARUS KAS SAK";
}else{
	$jdl_lap="ARUS KAS SAP";
}

$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s="01".substr($th,2,8);
$cbln=(substr($tgl_s,3,1)=="0")?substr($tgl_s,4,1):substr($tgl_s,3,2);
$cthn=substr($tgl_s,6,4);
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$th;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$th=explode("-",$th);
$ckel=$_REQUEST["ckel"];
$kodema=$_REQUEST["kodema"];
$kelompok=$_REQUEST["kelompok"];
$cdk=$_REQUEST["cdk"];
$type=$_REQUEST["type"];
$cinduk=$_REQUEST["cinduk"];
$ccrvksopbfumum=$_REQUEST["ccrvksopbfumum"];
if ($ccrvksopbfumum=="") $ccrvksopbfumum=0;

$ckodema=explode(",",$kodema);
$pkode="";
if (($cinduk==9) && ($sak_sap=="1")){
	for ($i=0;$i<count($ckodema);$i++){
		if ($ckodema[$i]=='2110102'){
			$pkode .="(MA_KODE LIKE '$ckodema[$i]%' AND FK_LAST_TRANS=357) OR ";
		}else{
			$pkode .="MA_KODE LIKE '$ckodema[$i]%' OR ";
		}
	}
}elseif(($cinduk==10) && ($sak_sap=="1")){
	for ($i=0;$i<count($ckodema);$i++){
		if ($ckodema[$i]=='2110102'){
			$pkode .="(MA_KODE LIKE '$ckodema[$i]%' AND FK_LAST_TRANS<>357) OR ";
		}else{
			$pkode .="MA_KODE LIKE '$ckodema[$i]%' OR ";
		}
	}
}else{
	for ($i=0;$i<count($ckodema);$i++){
		$pkode .="MA_KODE LIKE '$ckodema[$i]%' OR ";
	}
}
$pkode=substr($pkode,0,strlen($pkode)-4);

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Arus_Kas_Detail.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Arus_Kas_Detail');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 17);
$worksheet->setColumn (2, 2, 65);
$worksheet->setColumn (3, 3, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0.00'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$regularFormatText =& $workbook->addFormat(array('size'=>9,'align'=>'left','numFormat'=>'###0'));
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

$title4="( $tgl_s  s/d  $tgl_d )";
//Write sheet title in upper left cell
$worksheet->write($row, 2, $pemkabRS, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 2, "RUMAH SAKIT UMUM DAERAH", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 2, $jdl_lap, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 2, "$title4", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 2, "($ckel)", $sheetTitleFormatC);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "KODE SAK", $columnTitleFormat);
$worksheet->write($row, $column+2, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+3, "NILAI", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;
$row += 1;
	if ($ccrvksopbfumum==0){
		if ($cdk=="K"){
			if ($type=="0"){
				$sql="SELECT t4.MA_KODE,t4.MA_NAMA,t4.CC_RV_KSO_PBF_UMUM,SUM(t4.DEBIT),SUM(t4.KREDIT),SUM(t4.NILAI) NILAI FROM (SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT-t3.DEBIT AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)) AS t4
GROUP BY t4.MA_KODE";
			}else{
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,SUM(t3.DEBIT),SUM(t3.KREDIT),SUM(t3.KREDIT) AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)) AS t4
GROUP BY t4.MA_KODE";
			}
		}else{
			if ($type=="0"){
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,SUM(t3.DEBIT),SUM(t3.KREDIT),SUM(t3.DEBIT-t3.KREDIT) AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)) AS t4
GROUP BY t4.MA_KODE";
			}else{
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,SUM(t3.DEBIT),SUM(t3.KREDIT),SUM(t3.DEBIT) AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)) AS t4
GROUP BY t4.MA_KODE";
			}
		}
	}else{
		if ($cdk=="K"){
			if ($type=="0"){
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT-t3.DEBIT AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)";
			}else{
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)";
			}
		}else{
			if ($type=="0"){
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT-t3.KREDIT AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)";
			}else{
				$sql="SELECT t3.MA_KODE,t3.MA_NAMA,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT AS NILAI FROM 
(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '111%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'111' AND ($pkode)";
			}
		}
	}
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$i=0;
		$subtot=0;
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$subtot +=$rows["NILAI"];
			$nilai=$rows["NILAI"];
			$kodema=$rows["MA_KODE"];
			$ma=$rows["MA_NAMA"];
			if ($ccrvksopbfumum!=0){
				switch($rows["CC_RV_KSO_PBF_UMUM"]){
					case 1:
						$sql="SELECT * FROM ak_ms_unit WHERE tipe=1 AND id=".$rows["CC_RV_KSO_PBF_UMUM_ID"];
						$rsCC=mysql_query($sql);
						$rwCC=mysql_fetch_array($rsCC);
						$kodema.=$rwCC["kode"];
						$ma=$rwCC["nama"];
						break;
					case 2:
						$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id=".$rows["CC_RV_KSO_PBF_UMUM_ID"];
						$rsCC=mysql_query($sql);
						$rwCC=mysql_fetch_array($rsCC);
						$kodema.=$rwCC["kode_ak"];
						$ma=$rwCC["nama"];
						break;
					case 3:
						$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=".$rows["CC_RV_KSO_PBF_UMUM_ID"];
						$rsCC=mysql_query($sql);
						$rwCC=mysql_fetch_array($rsCC);
						$kodema.=$rwCC["PBF_KODE_AK"];
						$ma=$rwCC["PBF_NAMA"];
						break;
					case 4:
						$sql="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=".$rows["CC_RV_KSO_PBF_UMUM_ID"];
						$rsCC=mysql_query($sql);
						$rwCC=mysql_fetch_array($rsCC);
						$kodema.=$rwCC["koderekanan"];
						$ma=$rwCC["namarekanan"];
						break;
				}
				//echo $sql."<br>";
			}
			$worksheet->write($row, 0, $i, $regularFormatC);
			$worksheet->write($row, 1, $kodema, $regularFormatText);
			$worksheet->write($row, 2, $ma, $regularFormat);
			$worksheet->write($row, 3, $nilai, $regularFormatR);
			$row++;
		}
		$worksheet->write($row, 0, "", $regularFormat);
		$worksheet->write($row, 1, "", $regularFormat);
		$worksheet->write($row, 2, "Sub Total : ", $regularFormatC);
		$worksheet->write($row, 3, $subtot, $regularFormatR);

$workbook->close();
mysql_close($konek);
?>
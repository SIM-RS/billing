<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
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

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Arus_Kas.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Arus_Kas');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 65);
$worksheet->setColumn (2, 4, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
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

$title4="( $tgl_s  s/d  $tgl_d )";
//Write sheet title in upper left cell
$worksheet->write($row, 1, $pemkabRS, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "RS Prima Husada Cipta Medan", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, $jdl_lap, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "$title4", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "(DALAM RUPIAH)", $sheetTitleFormatC);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
// $worksheet->write($row, $column+2, "DEBET", $columnTitleFormat);
// $worksheet->write($row, $column+3, "KREDIT", $columnTitleFormat);
$worksheet->write($row, $column+2, "NILAI", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;
$row += 1;
$subtot=array(15);
for ($i=0;$i<14;$i++) $subtot[$i]=0;
// $sql="SELECT * FROM lap_arus_kas ORDER BY kode";
// $rs=mysql_query($sql);
// $tmpkel=0;$tmpkat=0;
// while ($rows=mysql_fetch_array($rs)){
// 	$ckode=$rows["kode_ma_sak"];
// 	$cformula=str_replace(" ","",$rows["formula"]);
// 	$ckelompok=$rows["kelompok"];
// 	$cdk=$rows["d_k"];
// 	$ckategori=$rows["kategori"];
// 	$ctype=$rows["type"];
// 	$nilai=($ckelompok==0)?"":"-";
// 	if ($ckode!=""){
// 		$ckodear=explode(",",$ckode);
// 		$cstr="";
// 		if (($rows["id"]==9) && ($sak_sap=="1")){
// 			for ($i=0;$i<count($ckodear);$i++){
// 				if ($ckodear[$i]=='2110102'){
// 					$cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
// 				}else{
// 					$cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
// 				}
// 			}
// 		}elseif(($rows["id"]==10) && ($sak_sap=="1")){
// 			for ($i=0;$i<count($ckodear);$i++){
// 				if ($ckodear[$i]=='2110102'){
// 					$cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
// 				}else{
// 					$cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
// 				}
// 			}
// 		}else{
// 			for ($i=0;$i<count($ckodear);$i++){
// 				$cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
// 			}
// 		}
// 		$cstr=substr($cstr,0,strlen($cstr)-4);
// 		//echo $cstr."<br>";
// 		if ($cdk=='K'){
// 			if ($ctype==0){
// 				$sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
// (SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
// (SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
// WHERE b.MA_KODE LIKE '1.1.01%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
// WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
// WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";
// 			}else{
// 				$sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
// (SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
// (SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
// WHERE b.MA_KODE LIKE '1.1.01%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
// WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
// WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";
// 			}
// 		}else{
// 			if ($ctype==0){
// 				$sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
// (SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
// (SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
// WHERE b.MA_KODE LIKE '1.1.01%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
// WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
// WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";
// 			}else{
// 				$sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
// (SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
// (SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
// WHERE b.MA_KODE LIKE '1.1.01%' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
// WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
// WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";
// 			}
// 		}
// 		//echo $sql."<br>";
// 		$rs1=mysql_query($sql);
// 		if ($rows1=mysql_fetch_array($rs1)){
// 			$nilai=($rows1["NILAI"]=="-")?"-":$rows1["NILAI"];
// 			if ($nilai!="-"){
// 				$subtot[$ckelompok-1] +=$rows1["NILAI"];
// 			}
// 		}
// 	}else{
// 		if ($ckategori==2){
// 			$cform=array();
// 			$j=0;
// 			for ($i=0;$i<strlen($cformula);$i++){
// 				if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
// 					$cform[$j]=substr($cformula,$i,1);
// 					$j++;
// 				}
// 			}
// 			//echo "count=".count($cform)."<br>";
// 			$cdata=str_replace("-",",",$cformula);
// 			$cdata=str_replace("+",",",$cdata);
// 			$cdata=explode(",",$cdata);
// 			$cnilai=$subtot[$cdata[0]-1];
// 			//echo $cnilai."<br>";
// 			for ($i=1;$i<count($cdata);$i++){
// 				$cnilai=($cform[$i-1]=="-")?($cnilai-$subtot[$cdata[$i]-1]):($cnilai+$subtot[$cdata[$i]-1]);
// 				//echo $subtot[$cdata[$i]-1]."<br>";
// 			}
// 			// $nilai=$cnilai;
// 			if ($cnilai<0) 
// 	            $nilai="(".number_format(abs($cnilai),0,",",".").")";
// 	          else
// 	            $nilai=number_format($cnilai,0,",",".");
// 		}elseif ($ckategori==3){
// 			$sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM (SELECT * FROM saldo WHERE BULAN=$cbln AND TAHUN=$cthn) AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '1.1.01%'";
// 			//echo $sql."<br>";
// 			$rs1=mysql_query($sql);
// 			if ($rows1=mysql_fetch_array($rs1)){
// 				$nilai=$rows1["NILAI"];
// 				$subtot[$ckelompok-1] +=$rows1["NILAI"];
// 			}
// 		}
// 	}



//Format Baru


		$sql="SELECT * FROM lap_arus_kas ORDER BY kode";
    $rs=mysql_query($sql);
    $tmpkel=0;$tmpkat=0;
    $cno_urut1=0;$cno_urut2=0;
    while ($rows=mysql_fetch_array($rs)){
      // $ckode=$rows["kode_ma_sak"];
      $ckodeDebit=$rows["debit"];
      $ckodeKredit=$rows["kredit"];
      $ckode_label=$rows["kode_label"];
      $cbr=$rows["br"];
      $cinduk=$rows["id"];
      $cformula=str_replace(" ","",$rows["formula"]);
      $ckelompok=$rows["kelompok"];
      $cdk=$rows["d_k"];
      $ckategori=$rows["kategori"];
      $ctype=$rows["type"];
      $nilaiDebit=($ckelompok==0)?"":"-"; //untuk nilai debit
      $nilaiKredit=($ckelompok==0)?"":"-"; //untuk nilai kredit
      $nilaiTotal=($ckelompok==0)?"":"-"; //untuk nilai kredit
      $clevel=$rows["level"];
      
      //$cbr=0;
      //if ($ckategori==2 && $clevel==3){
      //  $cbr=1;
      //}
      
      if ($clevel==1){
        $cno_urut1++;
        $clblNoUrut=$no_urut_lvl1[$cno_urut1-1];
        $cno_urut2=0;
        $cno_urut3=96;
      }elseif ($clevel==2){
        $cno_urut2++;
        $clblNoUrut=$cno_urut2;
        $cno_urut3=96;
      }else{
        if ($ckategori==1 || $ckategori==3){
          $cno_urut3++;
          $clblNoUrut=chr($cno_urut3);
        }else{
          $clblNoUrut="";
          //$cbr=1;
        }
      }

      if ($ckodeDebit!="" || $ckodeKredit!=""){
      if ($ckodeDebit!=""){
        $ckodear=explode(",",$ckodeDebit);
        $cstr="";
        if (($rows["id"]==9) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodear);$i++){
            if ($ckodear[$i]=='2110102'){
              $cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS=357) OR ";
            }else{
              $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
            }
          }
        }elseif(($rows["id"]==10) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodear);$i++){
            if ($ckodear[$i]=='2110102'){
              $cstr .="(MA_KODE LIKE '".$ckodear[$i]."%' AND FK_LAST_TRANS<>357) OR ";
            }else{
              $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
            }
          }
        }else{
          for ($i=0;$i<count($ckodear);$i++){
            $cstr .="MA_KODE LIKE '".$ckodear[$i]."%' OR ";
          }
        }
        $cstr=substr($cstr,0,strlen($cstr)-4);
        //echo $cstr."<br>";
        //if ($ckelompok==1 or $ckelompok==4){
          if ($ctype==0){
            $sql="SELECT IFNULL(SUM(t4.DEBIT-t4.KREDIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag='$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4"; //decyber_arus_kas
          }else{
            $sql="SELECT IFNULL(SUM(t4.DEBIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag='$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstr)) AS t4";//decyber_arus_kas
          }
        // }
        // echo $sql."<br>";
        /*if ($ckode=='411'){
          echo $sql."<br>";
        }*/
        $rs1=mysql_query($sql);
        if ($rows1=mysql_fetch_array($rs1)){
          $nilaiD = $rows1["NILAI"];
          $nilaiDebit=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],0,",",".");
          if ($nilaiDebit!="-"){
            $subtotD[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }
        
        // PERHITUNGAN NILAI KREDIT

        if ($ckodeKredit!=""){

        $ckodearK=explode(",",$ckodeKredit);
        $cstrK="";
        if (($rows["id"]==9) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodearK);$i++){
            if ($ckodearK[$i]=='2110102'){
              $cstrK .="(MA_KODE LIKE '".$ckodearK[$i]."%' AND FK_LAST_TRANS=357) OR ";
            }else{
              $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
            }
          }
        }elseif(($rows["id"]==10) && ($sak_sap=="1")){
          for ($i=0;$i<count($ckodearK);$i++){
            if ($ckodearK[$i]=='2110102'){
              $cstrK .="(MA_KODE LIKE '".$ckodearK[$i]."%' AND FK_LAST_TRANS<>357) OR ";
            }else{
              $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
            }
          }
        }else{
          for ($i=0;$i<count($ckodearK);$i++){
            $cstrK .="MA_KODE LIKE '".$ckodearK[$i]."%' OR ";
          }
        }
        $cstrK=substr($cstrK,0,strlen($cstrK)-4);
        //echo $cstrK."<br>";
        //if ($ckelompok==1 or $ckelompok==4){
        // if ($cdk=='K'){
          if ($ctype==0){
            $sql="SELECT IFNULL(SUM(t4.KREDIT-t4.DEBIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.DEBIT,a.KREDIT,a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag='$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstrK)) AS t4"; //decyber_arus_kas
          }else{
            $sql="SELECT IFNULL(SUM(t4.KREDIT),'-') AS NILAI FROM 
(SELECT DISTINCT t3.* FROM (SELECT t2.*,c.MA_KODE FROM 
(SELECT j.NO_TRANS,j.FK_SAK,j.DEBIT,j.KREDIT,j.FK_LAST_TRANS,j.CC_RV_KSO_PBF_UMUM_ID FROM (SELECT a.NO_TRANS,a.TGL,a.FK_LAST_TRANS FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag='$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1' ) AS t1,jurnal j 
WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($cstrK)) AS t4"; //decyber_jurnal
          }
              // }
        // echo $sql."<br>";
        /*if ($ckode=='411'){
          echo $sql."<br>";
        }*/
        $rs1=mysql_query($sql);
        if ($rows1=mysql_fetch_array($rs1)){
          $nilaiK = $rows1["NILAI"];
          $nilaiKredit=($rows1["NILAI"]=="-")?"-":number_format($rows1["NILAI"],0,",",".");
          if ($nilaiKredit!="-"){
            $subtotK[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }        
          // $nilaiTotal=($nilaiDebit=="-" && $nilaiKredit=="-")?"-":number_format($nilaiDebit-$nilaiKredit,0,",",".");
          // echo $nilaiDebit;
        // if($nilaiDebit=="-" && $nilaiKredit=="-"){
                  if ($cdk=='K'){
      if ($ckodeDebit!="" && $ckodeKredit!=""){
          $nilaiTotal = ($nilaiD=="-" && $nilaiK=="-")?"-":number_format($nilaiK-$nilaiD,0,",",".");
                    $subtotT[$ckelompok-1] +=$nilaiK-$nilaiD;

        }elseif($ckodeDebit!="" && $ckodeKredit==""){
          $nilaiTotal = ($nilaiD=="-")?"-":number_format($nilaiD,0,",",".");
                    $subtotT[$ckelompok-1] +=$nilaiD;

        }elseif($ckodeDebit=="" && $ckodeKredit!=""){
          // echo $nilaiK;
          $nilaiTotal = ($nilaiK=="-")?"-":number_format($nilaiK,0,",",".");
                    $subtotT[$ckelompok-1] +=$nilaiK;

      }
    }else{
          if ($ckodeDebit!="" && $ckodeKredit!=""){
          $nilaiTotal = ($nilaiD=="-" && $nilaiK=="-")?"-":number_format($nilaiD-$nilaiK,0,",",".");
                    $subtotT[$ckelompok-1] +=$nilaiD-$nilaiK;

        }elseif($ckodeDebit!="" && $ckodeKredit==""){
          $nilaiTotal = ($nilaiD=="-")?"-":number_format($nilaiD,0,",",".");
                    $subtotT[$ckelompok-1] +=$nilaiD;

        }elseif($ckodeDebit=="" && $ckodeKredit!=""){
          // echo $nilaiK;
                    $subtotT[$ckelompok-1] +=$nilaiK;

          $nilaiTotal = ($nilaiK=="-")?"-":number_format($nilaiK,0,",",".");
      }
    }

        // }else{
        //   $nilaiTotal = "-";
        // }

      }else{
        if ($ckategori==2){
          $cform=array();
          $j=0;
          for ($i=0;$i<strlen($cformula);$i++){
            if (substr($cformula,$i,1)=="-" or substr($cformula,$i,1)=="+"){
              $cform[$j]=substr($cformula,$i,1);
              $j++;
            }
          }
          // var_dump($cform);
          // echo "count=".count($cform)."<br>";
          $cdata=str_replace("-",",",$cformula);
          $cdata=str_replace("+",",",$cdata);
          $cdata=explode(",",$cdata);
          $cnilaiD=$subtotD[$cdata[0]-1];
          $cnilaiK=$subtotK[$cdata[0]-1];
            $cnilaiT=$subtotT[$cdata[0]-1];
          // echo $cnilaiT."<br>";
          for ($i=1;$i<count($cdata);$i++){
            $cnilaiD=($cform[$i-1]=="-")?($cnilaiD-$subtotD[$cdata[$i]-1]):($cnilaiD+$subtotD[$cdata[$i]-1]);
            $cnilaiK=($cform[$i-1]=="-")?($cnilaiK-$subtotK[$cdata[$i]-1]):($cnilaiK+$subtotK[$cdata[$i]-1]);
            $cnilaiT=($cform[$i-1]=="-")?($cnilaiT-$subtotT[$cdata[$i]-1]):($cnilaiT+$subtotT[$cdata[$i]-1]);

            // echo $cnilaiT;
            // echo $subtotT[$cdata[$i]-1]."<br>";
            if($subtot[$cdata[$i]-1]>0){
              $total_saldo_awal = $subtot[$cdata[$i]-1];
            }
          }
                            

              if ($cdk=='K'){

              if ($cnilaiD<0 && $cnilaiK<0){
                // $nilaiDebit="(".number_format(abs($cnilaiD),0,",",".").")";
                // $nilaiKredit="(".number_format(abs($cnilaiK),0,",",".").")";
                $nilaiTotal = "(".number_format(abs(($cnilaiK-$cnilaiD)+$total_saldo_awal),0,",",".").")";
              }else{
                // $nilaiDebit=number_format($cnilaiD,0,",",".");
                // $nilaiKredit=number_format($cnilaiK,0,",",".");
                $nilaiTotal=number_format(($cnilaiK-$cnilaiD)+$total_saldo_awal,0,",",".");
              }
            }else if($cdk=='D'){
              if ($cnilaiD<0 && $cnilaiK<0){
                // $nilaiDebit="(".number_format(abs($cnilaiD),0,",",".").")";
                // $nilaiKredit="(".number_format(abs($cnilaiK),0,",",".").")";
                $nilaiTotal = "(".number_format(abs(($cnilaiD-$cnilaiK)+$total_saldo_awal),0,",",".").")";
              }else{
                // $nilaiDebit=number_format($cnilaiD,0,",",".");
                // $nilaiKredit=number_format($cnilaiK,0,",",".");
                $nilaiTotal=number_format(($cnilaiD-$cnilaiK)+$total_saldo_awal,0,",",".");
              }
            }else{
               if ($cnilaiD<0 && $cnilaiK<0){
                // $nilaiDebit="(".number_format(abs($cnilaiD),0,",",".").")";
                // $nilaiKredit="(".number_format(abs($cnilaiK),0,",",".").")";
                $nilaiTotal = "(".number_format(abs(($cnilaiT)+$total_saldo_awal),0,",",".").")";
              }else{
                // $nilaiDebit=number_format($cnilaiD,0,",",".");
                // $nilaiKredit=number_format($cnilaiK,0,",",".");
                $nilaiTotal=number_format(($cnilaiT)+$total_saldo_awal,0,",",".");
              }
            }
         
          // echo $total_saldo_awal;
          //  if ($cnilaiD<0 && $cnilaiK<0){
          //     $nilaiDebit="(".number_format(abs($cnilaiD),0,",",".").")";
          //     $nilaiKredit="(".number_format(abs($cnilaiK),0,",",".").")";
          //     $nilaiTotal = "(".number_format(abs($cnilaiD+$cnilaiK+$subtot[$cdata[$i]-1]),0,",",".").")";
          //   }else{
          //     $nilaiDebit=number_format($cnilaiD,0,",",".");
          //     $nilaiKredit=number_format($cnilaiK,0,",",".");
          //     $nilaiTotal=number_format($cnilaiD+$cnilaiK+$subtot[$cdata[$i]-1],0,",",".");
          //   }
          // $nilaiTotal=number_format($cnilaiD-$cnilaiK,0,",",".");
        }elseif ($ckategori==3){
          $sql="SELECT IF (SUM(s.SALDO_AWAL) IS NULL,0,SUM(s.SALDO_AWAL)) AS NILAI FROM saldo AS s INNER JOIN ma_sak m ON s.FK_MAID=m.MA_ID WHERE m.MA_KODE LIKE '1.1.01' AND BULAN=$cbln AND TAHUN=$cthn";//decyber_arus_kas
          // echo $sql."<br>";
          $rs1=mysql_query($sql);
          if ($rows1=mysql_fetch_array($rs1)){
            // $rows1["NILAI"] = 1000;
            if ($rows1["NILAI"]<0)
              $nilaiTotal="(".number_format(abs($rows1["NILAI"]),0,",",".").")";
            else
              $nilaiTotal=number_format($rows1["NILAI"],0,",",".");
            $subtot[$ckelompok-1] +=$rows1["NILAI"];
          }
        }
      }

	//echo $ckategori."<br>";
	/*if ($ckelompok==0 && $tmpkel>0 && $tmpkat<>3){
		$worksheet->write($row, 0, "", $regularFormat);
		$worksheet->write($row, 1, "Sub Total : ", $regularFormatC);
		$worksheet->write($row, 2, $subtot[$tmpkel-1], $regularFormatR);
		$row++;
	}
	$tmpkel=$ckelompok;
	$tmpkat=$ckategori;*/
	$worksheet->write($row, 0, $ckode_label, $regularFormat);
	$worksheet->write($row, 1, $rows['uraian'], $regularFormat);
	// $worksheet->write($row, 2, $nilaiDebit, $regularFormat);
	// $worksheet->write($row, 3, $nilaiKredit, $regularFormat);
	$worksheet->write($row, 2, $nilaiTotal, $regularFormatR);
	$row++;
}
/*
$row +=2;
$worksheet->write($row, $column, "5", $sTotTitleC);
$worksheet->write($row, $column+1, "Saldo akhir kas dan setara kas", $sTotTitleL);
$worksheet->write($row, 2, $tot1-$tot2-$tot3+$tot4+$tot5, $sTotTitleR);
*/
$workbook->close();
mysql_close($konek);
?>
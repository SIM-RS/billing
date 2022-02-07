<?php
 include("../koneksi/konek.php");
 $urlServis=$url_pacs;
 $remoteAE=$_REQUEST["remoteAE"];
 $QueryLevel=$_REQUEST['QueryLevel'];
 $act=$_REQUEST["act"];
 $PatientId=$_REQUEST['PatientId'];
 $PatientName=$_REQUEST["PatientName"];
 $Modality=$_REQUEST['Modality'];
 $StudyIuid=$_REQUEST['StudyIuid'];
 $StudyId=$_REQUEST["StudyId"];
 $SeriesIuid=$_REQUEST["SeriesIuid"];
 $SOPIuid=$_REQUEST["SOPIuid"];
 $tipe=$_REQUEST["tipe"];
 $urlServis .="remoteAE=$remoteAE&act=$act&QueryLevel=$QueryLevel&PatientName=$PatientName&PatientId=$PatientId&Modality=$Modality&StudyId=$StudyId&StudyIuid=$StudyIuid&SeriesIuid=$SeriesIuid&SOPIuid=$SOPIuid&tipe=$tipe";
 $cparam="";
 //echo $urlServis.$cparam."<br>";
 $ch = curl_init($urlServis);
 //$ch = curl_init('172.127.11.15:8080/wsAskesRS/askesWSService?tester');
 curl_setopt ($ch, CURLOPT_POST, 0);
 //curl_setopt ($ch, CURLOPT_POSTFIELDS, $cparam);
 //curl_setopt ($ch, CURLOPT_POSTFIELDS, "");
 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $data=curl_exec ($ch);
 curl_close ($ch);
 //echo $data;
 //======================== code utk memproses data ======================
 $perpage=100;
 $page=$_REQUEST["page"];
 $sorting=$_REQUEST["sorting"];
 $filter=$_REQUEST["filter"];
 
 $arrdata=explode(chr(5),$data);
 $jmldata=count($arrdata)-1;
 //echo "jumlah=".$jmldata;
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    //$sql=$sql." limit $tpage,$perpage";
    //echo $sql;

    //$rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);
 
 //$arrdata=explode(chr(5),$data);
 for ($i=0;$i<$jmldata;$i++){
 	//echo $arrdatacol[$i]." | ";
	$arrdatacol=explode(chr(3),$arrdata[$i]);
	
	$thn=substr($arrdatacol[5],0,4);
	$bln=substr($arrdatacol[5],4,2);
	$hr=substr($arrdatacol[5],6,2);
	$tgl=$hr."/".$bln."/".$thn;
	
	if($_REQUEST['grd']=='SERIES'){
		$sisip = $arrdatacol[13]."|".$arrdatacol[12];
		$dt.=$sisip.chr(3).number_format($i+1,0,",","").chr(3).$tgl.chr(3).$arrdatacol[0].chr(3).$arrdatacol[1].chr(3).$arrdatacol[3].chr(3).$arrdatacol[10].chr(3).$arrdatacol[17].chr(3).$arrdatacol[18].chr(6);
	}
	else if($_REQUEST['grd']=='IMAGE'){
		$sisip = $PatientId."|".$arrdatacol[12]."|".$arrdatacol[13]."|".$arrdatacol[20]."|".$arrdatacol[10]."|".$arrdatacol[19];
		$view_images="<img src='../icon/zoom_in.png' title='Lihat detil' style='cursor:pointer' onclick='view_pacs($i+1)' />";
		$dt.=$sisip.chr(3).number_format($i+1,0,",","").chr(3).$tgl.chr(3).$arrdatacol[8].chr(3).$arrdatacol[19].chr(3).$arrdatacol[21].chr(3).$view_images.chr(6);	
	}
	//$dt.=chr(6);
 }
 //echo $dt;
 
 if ($dt!=$totpage.chr(5)) {
 	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$msg;
    $dt=str_replace('"','\"',$dt);
 }
 header("Cache-Control: no-cache, must-revalidate" );
 header("Pragma: no-cache" );
 if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
 }else {
    header("Content-type: text/xml");
 }
 echo $dt;
  //======================== code utk memproses data ======================
 exit;
?>
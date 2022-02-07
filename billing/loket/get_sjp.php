<?php
include '../koneksi/konek.php'; //include("../sesi.php");

function GetSignature($consId,$secretKey,$timestamp){
	$tdata="$consId&$timestamp";
    // Computes the signature by hashing the salt with the secret key as the key
    $sign = hash_hmac('sha256', $tdata, $secretKey, true);

    // base64 encode…
    $encodedSignature = base64_encode($sign);
	return $encodedSignature;
}

function GetTimeStamp($tglJam){
	$tdata=explode(" ",$tglJam);
	$ctgl=explode("-",$tdata[0]);
	$cjam=explode(":",$tdata[1]);
	$ctgl[1]=(substr($ctgl[1],0,1)=="0")?substr($ctgl[1],1,1):$ctgl[1];
	$ctgl[2]=(substr($ctgl[2],0,1)=="0")?substr($ctgl[2],1,1):$ctgl[2];
	$cjam[0]=(substr($cjam[0],0,1)=="0")?substr($cjam[0],1,1):$cjam[0];
	$cjam[1]=(substr($cjam[1],0,1)=="0")?substr($cjam[1],1,1):$cjam[1];
	$cjam[2]=(substr($cjam[2],0,1)=="0")?substr($cjam[2],1,1):$cjam[2];
	$tStamp=mktime(($cjam[0]), $cjam[1]-20, $cjam[2], $ctgl[1], $ctgl[2], $ctgl[0]);
	return $tStamp;
}

$sql = "select nama from b_ms_reference where stref = 23";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$urlServis=$row['nama'];
//$urlServis='http://localhost/simrs-tangerang/billing/askesWSServiceByNIP.htm?tester';
mysql_free_result($rs);
//$urlServis='http://tikr0707:8080/wsAskesRS/askesWSService?tester';
//'http://172.187.11.11:8080/wsAskesRS/askesWSService?tester';
$act=$_REQUEST["act"];
$noKa=$_REQUEST["noKa"];//"0000097990119";
//$noKa="0000142495694";
$nip=$_REQUEST["nip"];
//$nip="140223225";
$nik=$_REQUEST["nik"];
//$nik="5171041305790006";
$pisa=$_REQUEST["pisa"];
//$pisa="S";
$namaPeserta=$_REQUEST["namaPeserta"];
//$namaPeserta="MUJADID ANWAR HASAN";
$tglLahirPeserta=$_REQUEST["tglLahirPeserta"]." 00:00:00.0";
//$tglLahirPeserta="1979-05-13 00:00:00.0";
$sexPeserta=$_REQUEST["sexPeserta"];
//$sexPeserta="L";
$norm=$_REQUEST['norm'];
//$norm="1374343";
$tglSJPPeserta=$_REQUEST['tglSJP']." ".gmdate('H:i:s',mktime(date('H')+7));
//$tglSJPPeserta=$_REQUEST['tglSJP']." 00:00:00.0";
//$tglSJPPeserta="2011-01-20 00:00:00.0";
if ($act!="generateSJP"){
	$tglSJPPeserta=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
}
//echo $tglSJPPeserta."<br>";
$tglRujukan=$tglSJPPeserta;
$noRujukan=$norm;
$kdPPKRujukan=$_REQUEST['kodePPK'];
$noSEP=$_REQUEST['noSEP'];
//$kdPPKRujukan="1301U085";
//$kdPoliAskes="GIG";
$kdDiagnosa=$_REQUEST['kd_diag'];//"J06";
$unit = $_REQUEST['unit'];
$inap = $_REQUEST['inap'];
$idKunj = $_REQUEST['idKunj'];
$userId = $_REQUEST['userId'];
$jnsPelayanan = 2;
if ($inap==1){
	$jnsPelayanan=1;
}else{
	$sqlUnit="SELECT * FROM b_ms_unit WHERE id='$unit'";
	//echo $sqlUnit."<br>";
	$rsUnit=mysql_query($sqlUnit);
	if (mysql_num_rows($rsUnit)>0){
		$rwUnit=mysql_fetch_array($rsUnit);
		if ($rwUnit["inap"]==1) $jnsPelayanan=1; 
	}
}
//$jnsPelayanan = $_REQUEST['jnsPelayanan'];//1=Rawat Inap, 2=Rawat Jalan
$kelasRawat = $_REQUEST['kelasRawat'];//kelas rawat tanggungan peserta

$catatan="Bridging ".$namaRS;
//$iduserAskes="00000";
$iduserAskes=$userId;
$kdPPKRS="1303R001";
$xcons_id="1575";
$xsecretKey="rsud198sdrjo715";
//$x_timestamp="1403768072";
$x_timestamp=GetTimeStamp($tglSJPPeserta);
//$x_signature="GGvRV1GZgenJj42eAGALgKjS+a+CPGBM9W5W1APDx8o=";
$x_signature=GetSignature($xcons_id,$xsecretKey,$x_timestamp);

//$url="act=getListPesertaByNIK&tglSJP=2014-06-26&noKa=0000142495694&nik=5171041305790006&kodePPK=1301U007&kd_diag=J06&jnsPelayanan=2&kelasRawat=1&unit=2&norm=1374343";

//echo "cons_id : ".$xcons_id."<br>secretKey : ".$xsecretKey."<br>tglSJPPeserta : ".$tglSJPPeserta."<br>timestamp : ".$x_timestamp."<br>signature : ".$x_signature."<br>act : ".$act."<br>";

//$urlServis='http://tikr0707:8080/wsAskesRS/askesWSService?tester';
$urlServisAct=$urlServis.'sep/';
$req_methode=0;

switch($act){
 case "getListPesertaByNoKa":
	$urlServisAct=$urlServis.'peserta/'.$noKa;
    //$cparam="&action=$act&PARAMgetListPesertaByNoKa0=$noKa";
  break;
 case "getListPesertaByNIP":
	$urlServisAct=$urlServis.'peserta/nik/'.$nip;
    //$cparam="&action=$act&PARAMgetListPesertaByNIP0=$nip";
  break;
 case "getListPesertaByNIK":
	$urlServisAct=$urlServis.'peserta/nik/'.$nik;
	//$urlServisAct="http://localhost/simrs/billing/loket/respon_NIK.html";
    $cparam="";
  break;
 case "generateSJP":
	if ($inap==1){
		$kdPoliAskes="-";
	}else{
		$sql = "select kodeAskes from b_ms_unit where id = $unit";
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		$kdPoliAskes=$row['kodeAskes'];
		mysql_free_result($rs);
	}
	
	$req_methode=1;
    $sql = "select kodeAskes from b_ms_unit where id = $unit";
	$cparam="<request>
			 <data>
			  <t_sep>
			   <noKartu>$noKa</noKartu>
			   <tglSep>$tglSJPPeserta</tglSep>
			   <tglRujukan>$tglRujukan</tglRujukan>
			   <noRujukan>$noRujukan</noRujukan>
			   <ppkRujukan>$kdPPKRujukan</ppkRujukan>
			   <ppkPelayanan>$kdPPKRS</ppkPelayanan>
			   <jnsPelayanan>$jnsPelayanan</jnsPelayanan>
			   <catatan>$catatan</catatan>
			   <diagAwal>$kdDiagnosa</diagAwal>
			   <poliTujuan>$kdPoliAskes</poliTujuan>
			   <klsRawat>$kelasRawat</klsRawat>
			   <user>$iduserAskes</user>
			   <noMr>$norm</noMr>
			  </t_sep>
			 </data>
			</request>";
    //$cparam="&action=$act&PARAMgenerateSJP0=3&PARAMgenerateSJP1=0&PARAMgenerateSJP2=$noKa&PARAMgenerateSJP3=1&PARAMgenerateSJP4=$pisa&PARAMgenerateSJP5=$namaPeserta&PARAMgenerateSJP6=$tglLahirPeserta&PARAMgenerateSJP7=$sexPeserta&PARAMgenerateSJP8=$norm&PARAMgenerateSJP9=$tglSJPPeserta&PARAMgenerateSJP10=$tglRujukan&PARAMgenerateSJP11=$noRujukan&PARAMgenerateSJP12=$kdPPKRujukan&PARAMgenerateSJP13=$kdPoliAskes&PARAMgenerateSJP14=$kdDiagnosa&PARAMgenerateSJP15=&PARAMgenerateSJP16=&PARAMgenerateSJP17=$catatan&PARAMgenerateSJP18=$iduserAskes&PARAMgenerateSJP19=$kdPPKRS";
  break;
 case "UpdateTglPlgSJP":
 	$urlServisAct.='updtglplg/';
	$req_methode=1;
    $cparam="<request>
			 <data>
			  <t_sep>
			   <noSep>$noSEP</noSep>
			   <tglPlg>$tglSJPPeserta</tglPlg>
			   <ppkPelayanan>$kdPPKRS</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>";
  break;
 case "HapusSEP":
	$req_methode=1;
    $cparam="<request>
			 <data>
			  <t_sep>
			   <noSep>$noSEP</noSep>
			   <ppkPelayanan>$kdPPKRS</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>";
  break;
 case "MappingSEP":
 	$isMRS=$_REQUEST["isMRS"];
	$isBedaTglSJP=$_REQUEST["isBedaTglSJP"];
	$tglSJP=$_REQUEST["tglSJP"];
	if ($isMRS==1){
		if ($isBedaTglSJP==1){
			$sqlUpdtSEP="UPDATE b_kunjungan SET tgl_sjp_inap='$tglSJP',no_sjp_inap='$noSEP' WHERE id='$idKunj'";
		}else{
			$sqlUpdtSEP="UPDATE b_kunjungan SET no_sjp='$noSEP',tgl_sjp_inap='$tglSJP',no_sjp_inap='$noSEP' WHERE id='$idKunj'";
		}
		$rsUpdtSEP=mysql_query($sqlUpdtSEP);
	}
 	$urlServisAct.='map/trans/';
	$req_methode=1;
    $cparam="<request>
 <data>
  <t_map_sep>
   <noSep>$noSEP</noSep>
   <noTrans>$idKunj</noTrans>
   <ppkPelayanan>$kdPPKRS</ppkPelayanan>
  </t_map_sep>
 </data>
</request>";
  break;
}
	//echo $urlServis.$cparam."<br>";
/*  $ch = curl_init($urlServis);
 //$ch = curl_init('172.127.11.15:8080/wsAskesRS/askesWSService?tester');
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt ($ch, CURLOPT_POSTFIELDS, $cparam);
 //curl_setopt ($ch, CURLOPT_POSTFIELDS, "");
 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $data=curl_exec ($ch);
 curl_close ($ch);
 //echo "ORI:<br>".$data; */
 
 $ch = curl_init();
 curl_setopt ($ch, CURLOPT_URL, $urlServisAct);
 if ($act=="UpdateTglPlgSJP"){
 	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
 }elseif ($act=="HapusSEP"){
 	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
 }elseif ($act=="MappingSEP"){
 	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");
 }else{
 	curl_setopt ($ch, CURLOPT_POST, $req_methode);
 }
 curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Accept: application/xml','x-cons-id: '.$xcons_id,'x-timestamp: '.$x_timestamp,'x-signature: '.$x_signature,'Content-Type: application/xml','Accept-Encoding: gzip,deflate,sdch','Accept-Language: en-US,en;q=0.8'));
 //curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_HEADER, false);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 999);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);  // RETURN THE CONTENTS OF THE CALL
 if ($act=="generateSJP" || $act=="UpdateTglPlgSJP" || $act=="HapusSEP" || $act=="MappingSEP"){
	 curl_setopt ($ch, CURLOPT_POSTFIELDS, $cparam);
	 //curl_setopt ($ch, CURLOPT_POSTFIELDS, "");
 }
 $data=curl_exec ($ch);
 //echo $data."<br>";
 //echo strpos($data,"<code>200</code>")."<br>";
 //$xml = simplexml_load_string($data);
 curl_close ($ch);
 //print_r($xml);
 
 $ada_data=1;
 switch ($act){
   case "getListPesertaByNoKa":
	/* $cdata=substr($data,strpos($data,"SOAP Response"),strlen($data)-strpos($data,"SOAP Response"));
	$cdata=substr($cdata,strpos($cdata,"ns2"),strpos($cdata,"/ns2")-strpos($cdata,"ns2"))."/ns2>";
	$cdata=str_replace("&lt;","<",$cdata);
	$cdata=str_replace("&gt;",">",$cdata);
	$cdata='<?xml version="1.0" encoding="UTF-8"?>'.substr($cdata,strpos($cdata,">")+1,strpos($cdata,"</ns2")-(strpos($cdata,">")+1));
	$xml = simplexml_load_string($cdata); */
	
	if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>$msgOk</message>")>0)){
			//echo "getListPesertaByNoKa --> Masuk";
			$cdata=$data;
			$xml = simplexml_load_string($cdata);
			//echo $xml;
			//========ByNoKa=============
			$response=$xml->response;
			$peserta=$response->peserta;
		    
			$jenisPeserta=$peserta->jenisPeserta;
			$kdJenisPeserta=$jenisPeserta->kdJenisPeserta;
			$nmJenisPeserta=$jenisPeserta->nmJenisPeserta;
			
			$kelasTanggungan=$peserta->kelasTanggungan;
			$kdKelas=$kelasTanggungan->kdKelas;
			$nmKelas=$kelasTanggungan->nmKelas;
			
			$nama=$peserta->nama;
			$nik=$peserta->nik;
			$noKartu=$peserta->noKartu;
			$pisa=$peserta->pisa;
			
			$provUmum=$peserta->provUmum;
			$kdProvider=$provUmum->kdProvider;
			$nmProvider=$provUmum->nmProvider;
			
			$sex=$peserta->sex;
			$tglCetakKartu=$peserta->tglCetakKartu;
			$tglLahir=$peserta->tglLahir;
/*			
			echo "kdJenisPeserta : ".$kdJenisPeserta."<br>";
			echo "nmJenisPeserta : ".$nmJenisPeserta."<br>";
			echo "kdKelas : ".$kdKelas."<br>";
			echo "nmKelas : ".$nmKelas."<br>";
			echo "Nama : ".$nama."<br>";
			echo "nik : ".$nik."<br>";
			echo "noKartu : ".$noKartu."<br>";
			echo "pisa : ".$pisa."<br>";
			echo "kdProvider : ".$kdProvider."<br>";
			echo "nmProvider : ".$nmProvider."<br>";
			echo "sex : ".$sex."<br>";
			echo "tglCetakKartu : ".$tglCetakKartu."<br>";
			echo "tglLahir : ".$tglLahir."<br>";*/
			//========ByNoKa=============
		}else{
			$ada_data=0;
		}
	
    break;
   case "getListPesertaByNIP":
   case "getListPesertaByNIK":
	/* $cdata=substr($data,strpos($data,"SOAP Response"),strlen($data)-strpos($data,"SOAP Response"));
	$cdata=substr($cdata,strpos($cdata,"ns2"),strpos($cdata,"/ns2")-strpos($cdata,"ns2"))."/ns2>";
	$cdata=str_replace("&lt;","<",$cdata);
	$cdata=str_replace("&gt;",">",$cdata);
	$cdata='<?xml version="1.0" encoding="UTF-8"?><ns2>'.substr($cdata,strpos($cdata,">")+1,strpos($cdata,"</ns2")-(strpos($cdata,">")+1)).'</ns2>';
	$xml = simplexml_load_string($cdata); */
	if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>OK</message>")>0) && (strpos($data,'count="1"')>0)){
			$cdata=$data;
			$xml = simplexml_load_string($cdata);
			//========ByNIK=============
			$response=$xml->response;
			$list=$response->list;
			$peserta=$list->peserta;
		 
			$jenisPeserta=$peserta->jenisPeserta;
			$kdJenisPeserta=$jenisPeserta->kdJenisPeserta;
			$nmJenisPeserta=$jenisPeserta->nmJenisPeserta;
			 
			$kelasTanggungan=$peserta->kelasTanggungan;
			$kdKelas=$kelasTanggungan->kdKelas;
			$nmKelas=$kelasTanggungan->nmKelas;
			
			$nama=$peserta->nama;
			$nik=$peserta->nik;
			$noKartu=$peserta->noKartu;
			$pisa=$peserta->pisa;
			 
			$provUmum=$peserta->provUmum;
			$kdProvider=$provUmum->kdProvider;
			$nmProvider=$provUmum->nmProvider;
			
			$sex=$peserta->sex;
			$tglCetakKartu=$peserta->tglCetakKartu;
			$tglLahir=$peserta->tglLahir;
	/*		
			echo "kdJenisPeserta : ".$kdJenisPeserta."<br>";
			echo "nmJenisPeserta : ".$nmJenisPeserta."<br>";
			echo "kdKelas : ".$kdKelas."<br>";
			echo "nmKelas : ".$nmKelas."<br>";
			echo "Nama : ".$nama."<br>";
			echo "nik : ".$nik."<br>";
			echo "noKartu : ".$noKartu."<br>";
			echo "pisa : ".$pisa."<br>";
			echo "kdProvider : ".$kdProvider."<br>";
			echo "nmProvider : ".$nmProvider."<br>";
			echo "sex : ".$sex."<br>";
			echo "tglCetakKartu : ".$tglCetakKartu."<br>";
			echo "tglLahir : ".$tglLahir."<br>";*/
			//========ByNIK=============
		}else{
			$ada_data=0;
		}
    break;
   case "generateSJP":
       /* $cdata=substr($data,strpos($data,"[")+1,strpos($data,"]")-(strpos($data,"[")+1)); */
	   
	   //echo $data."<br>";
		if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>OK</message>")>0)){
			$cdata=$data;
			$xml = simplexml_load_string($cdata);
			$response=$xml->response;
			$cdata=$response;
		}elseif ((strpos($data,"<code>400</code>")>0) && (strpos($data,"Masih Menginap")>0)){
			$cdata=$data;
			if (strpos($data,"[")>0) {
				$cdata="Error|INAP|".substr($cdata,strpos($cdata,"[")+1,19);
			}else{
				$cdata="Error|INAP|".substr($cdata,strpos($cdata,"- ")+2,19);
			}
		}else{
			//$cdata="Error";
			$cdata=$data;
			$xml = simplexml_load_string($cdata);
			$response=$xml->response;
			$cdata="Error|".$response;
		}
    break;
	case "UpdateTglPlgSJP":
		$cdata=$data;
		if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>OK</message>")>0)){
			$cdata="PULANG-OK";
		}else{
			$cdata="PULANG-ERROR";
		}
		break;
	case "HapusSEP":
		$cdata=$data;
		/*if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>OK</message>")>0)){
			$cdata="PULANG-OK";
		}else{
			$cdata="PULANG-ERROR";
		}*/
		break;
	case "MappingSEP":
		$cdata=$data;
		/*if ((strpos($data,"<code>200</code>")>0) && (strpos($data,"<message>OK</message>")>0)){
			$cdata="PULANG-OK";
		}else{
			$cdata="PULANG-ERROR";
		}*/
		break;
 }
 $i = 0;
 //echo $cdata."<br>";
 switch ($act){
 case "getListPesertaByNoKa":
    $tmp = '';
    //========ByNoKa=============
    /* foreach($xml->item as $items){
        $tmp .= trim($items).'*-*';
//       echo trim($items) . "<br />";
       
    }
    $tmp = substr($tmp,0,strlen($tmp)-3);
    echo $tmp; */
	
	$tmp = $noKartu.'*-*'.$pisa.'*-*'.$nama.'*-*'.$sex.'*-*'.$tglLahir.'*-*'.$kdProvider.'*-*'.$nmProvider.'*-*'.$kdKelas.'*-*'.$nmKelas."*-*".$nik;
	echo $tmp;
    //========ByNoKa=============
  break;
 case "getListPesertaByNIP":
 case "getListPesertaByNIK":
	?>
 
<table id="tblPas" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="40" class="tblheaderkiri"> No </td>
		<td width="80" class="tblheaderkiri"> No Peserta</td>
		<td width="50" class="tblheader"> PISA </td>
		<td width="200" class="tblheader"> Nama </td>
		<td width="50" class="tblheader"> Kelamin </td>
		<td width="100" class="tblheader"> Tgl Lahir </td>
		<td width="50" class="tblheader"> Kode PPK </td>
		<td width="150" class="tblheader"> Nama PPK </td>
		<td width="30" class="tblheader"> Nomor MR </td>
		<td width="30" class="tblheader"> Kelas </td>
	</tr>
    <tr id="lstPas" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPas(this);">
        <td class="tdisikiri" align="center">&nbsp;1</td>
		<td class="tdisi" align="center"><?php echo $noKartu; ?></td>
        <td class="tdisi" align="center"><?php echo $pisa; ?></td>
		<td class="tdisi" align="center"><?php echo $nama; ?></td>
        <td class="tdisi" align="center"><?php echo $sex; ?></td>
		<td class="tdisi" align="center"><?php echo $tglLahir; ?></td>
        <td class="tdisi" align="center"><?php echo $kdProvider; ?></td>
		<td class="tdisi" align="center"><?php echo $nmProvider; ?></td>
        <td class="tdisi" align="center"><?php echo $norm; ?></td>
        <td class="tdisi" align="center"><?php echo $nmKelas; ?></td>
    </tr>
</table>
<?php
 
/* <table id="tblPas" border="0" cellpadding="1" cellspacing="0">
	<tr class="headtable">
		<td width="40" class="tblheaderkiri"> No </td>
		<td width="80" class="tblheaderkiri"> No Peserta</td>
		<td width="50" class="tblheader"> PISA </td>
		<td width="200" class="tblheader"> Nama </td>
		<td width="50" class="tblheader"> Kelamin </td>
		<td width="100" class="tblheader"> Tgl Lahir </td>
		<td width="50" class="tblheader"> Kode PPK </td>
		<td width="150" class="tblheader"> Nama PPK </td>
		<td width="30" class="tblheader"> Nomor MR </td>
		<td width="30" class="tblheader"> Gol </td>
	</tr>
 
 $i=0;
    //========ByNIP=============
    foreach($xml->return as $returns){
		$j = 0;
        ?>
        <tr id="lstPas<?php echo $i; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetPas(this);">
        <td class="tdisikiri" align="center">&nbsp;<?php echo $i+1; ?></td>
        <?php
       foreach($returns->item as $items){
	      //echo trim($items) . "<br />";
		 if($j == 4){
		  $tgl_lhr = explode(' ',trim($items));
		  $tgl_lhr = tglSQL($tgl_lhr[0]);
		  ?>
		  <td class="tdisi" align="center"><?php echo $tgl_lhr; ?></td>
		  <?php
		 }
		 else{
        ?>
            <td class="tdisi" align="center"><?php echo trim($items); ?></td>
        <?php
		 }
        //echo trim($items);
	   	$j++;
       }
       $i++;
       echo "</tr>";
    } */
    //========ByNIP / ByNIK=============
//</table>

    /*foreach($xml->return as $returns){
       foreach($returns->item as $items){
	      echo trim($items) . "<br />";
       }
    }*/
  break;
 case "generateSJP":
    echo $cdata;// . "<br />";
    // $crespon=explode(",",$cdata);
 break;
 case "UpdateTglPlgSJP":
    echo $cdata;// . "<br />";
    //$crespon=explode(",",$cdata);
 break;
 case "HapusSEP":
    echo $cdata;// . "<br />";
    //$crespon=explode(",",$cdata);
 break;
 case "MappingSEP":
    echo $cdata;// . "<br />";
    //$crespon=explode(",",$cdata);
 break;
}

 exit;
?>
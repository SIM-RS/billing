<?php
$urlServis='http://192.168.1.6/simrs-tangerang/billing/loket/get_sjp.php';
$act=$_REQUEST["act"];
$noKa=$_REQUEST["noKa"];//"0000097990119";
//$noKa="0000142495694";
$nip=$_REQUEST["nip"];
//$nip="140223225";
$pisa=$_REQUEST["pisa"];
//$pisa="S";
$namaPeserta=$_REQUEST["namaPeserta"];
//$namaPeserta="MUJADID ANWAR HASAN";
$tglLahirPeserta=$_REQUEST["tglLahirPeserta"];
//$tglLahirPeserta="1979-05-13 00:00:00.0";
$sexPeserta=$_REQUEST["sexPeserta"];
//$sexPeserta="L";
$norm=$_REQUEST['norm'];
//$norm="1374343";
$tglSJP=$_REQUEST['tglSJP'];
//$tglSJPPeserta="2011-01-20 00:00:00.0";
//$tglRujukan=$tglSJPPeserta;
//$noRujukan=$norm;
$kodePPK=$_REQUEST['kodePPK'];
//$kdPPKRujukan="1301U085";
//$kdPoliAskes="GIG";
$kd_diag=$_REQUEST['kd_diag'];//"J06";
$unit = $_REQUEST['unit'];

switch($act){
 case "getListPesertaByNoKa":
    $cparam="act=getListPesertaByNoKa&noKa=$noKa&nip=$nip";
  break;
 case "getListPesertaByNIP":
    $cparam="act=getListPesertaByNIP&noKa=$noKa&nip=$nip";
  break;
 case "generateSJP":
    $cparam="act=generateSJP&noKa=".$noKa."&pisa=".$pisa."&namaPeserta=".$namaPeserta."&tglLahirPeserta=".$tglLahirPeserta."&sexPeserta=".$sexPeserta."&norm=".$norm."&tglSJP=".$tglSJP."&kodePPK=".$kodePPK."&kd_diag=".$kd_diag."&unit=".$unit;
  break;
}
	//echo $urlServis.$cparam."<br>";
 $ch = curl_init($urlServis);
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt ($ch, CURLOPT_POSTFIELDS, $cparam);
 //curl_setopt ($ch, CURLOPT_POSTFIELDS, "");
 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $data=curl_exec ($ch);
 curl_close ($ch);
 echo $data;
/* switch ($act){
   case "getListPesertaByNoKa":
	$cdata=substr($data,strpos($data,"SOAP Response"),strlen($data)-strpos($data,"SOAP Response"));
	$cdata=substr($cdata,strpos($cdata,"ns2"),strpos($cdata,"/ns2")-strpos($cdata,"ns2"))."/ns2>";
	$cdata=str_replace("&lt;","<",$cdata);
	$cdata=str_replace("&gt;",">",$cdata);
	$cdata='<?xml version="1.0" encoding="UTF-8"?>'.substr($cdata,strpos($cdata,">")+1,strpos($cdata,"")+1));
	$xml = simplexml_load_string($cdata);
    break;
   case "getListPesertaByNIP":
	$cdata=substr($data,strpos($data,"SOAP Response"),strlen($data)-strpos($data,"SOAP Response"));
	$cdata=substr($cdata,strpos($cdata,"ns2"),strpos($cdata,"/ns2")-strpos($cdata,"ns2"))."/ns2>";
	$cdata=str_replace("&lt;","<",$cdata);
	$cdata=str_replace("&gt;",">",$cdata);
	$cdata='<?xml version="1.0" encoding="UTF-8"?><ns2>'.substr($cdata,strpos($cdata,">")+1,strpos($cdata,"")+1)).'</ns2>';
	$xml = simplexml_load_string($cdata);
    break;
    case "generateSJP":
       $cdata=substr($data,strpos($data,"[")+1,strpos($data,"]")-(strpos($data,"[")+1));
     break;
 }
 $i = 0;
 //echo $cdata."<br>";
 switch ($act){
 case "getListPesertaByNoKa":
    $tmp = '';
    //========ByNoKa=============
    foreach($xml->item as $items){
        $tmp .= trim($items).'*-*';
//       echo trim($items) . "<br />";
       
    }
    $tmp = substr($tmp,0,strlen($tmp)-3);
    echo $tmp;
    //========ByNoKa=============
  break;
 case "getListPesertaByNIP":
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
		<td width="30" class="tblheader"> Gol </td>
	</tr>
 <?php
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
    }
    //========ByNIP=============
?>
</table>
<?php
  break;
 case "generateSJP":
    echo $cdata;// . "<br />";
    $crespon=explode(",",$cdata);
 break;
}
*/
 exit;
?>
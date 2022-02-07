<?php
include "../sesi.php";
include('../koneksi/konek.php');

$sak_sap=$_REQUEST["sak_sap"];
$bln1=$_REQUEST["bln1"];
$ta1=$_REQUEST["ta1"];
//$bln1="5|MEI";$ta1="2014";
$bln1=explode("|",$bln1);

$ibulan1=$bln1[0]+1;
$ita1=$ta1;
if ($ibulan1==13){
	$ibulan1=1;
	$ita1+=1;
}
$day1 = cal_days_in_month(CAL_GREGORIAN, $bln1[0], $ta1);
$title_tgl="PER $day1 $bln1[1] $ta1";
$col_tgl1="$day1-".(($bln1[0]<10)?"0".$bln1[0]:$bln1[0])."-$ta1";

$tgl2=$_REQUEST["tgl2"];
//$tgl2="1";
if ($tgl2=="1"){
	$bln2=$_REQUEST["bln2"];
	$ta2=$_REQUEST["ta2"];
	//$bln2="5|MEI";$ta2="2013";
	$bln2=explode("|",$bln2);
	$day2 = cal_days_in_month(CAL_GREGORIAN, $bln2[0], $ta2);
	$title_tgl .=" DAN $day2 $bln2[1] $ta2";
	$col_tgl2="$day2-".(($bln2[0]<10)?"0".$bln2[0]:$bln2[0])."-$ta2";
}

if ($sak_sap==1){
	$jdl="NERACA SAP";
}else{
	$jdl="NERACA SAK";
}
?>
<!--!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:NERACA:.</title>
</head>

<body>
<form-->
  <table width="77%" align="center">
      <tr>
      	<td align="center" width="1016" style="font-weight:bold;"><?=$namaRS;?></td>
      </tr>
      <!--tr>
        <td align="center" width="1016" style="font-weight:bold;">...........................................</td>
      </tr-->
      <tr>
        <td height="30" colspan="3" align="center" style="font-size:16px;font-weight:bold;"><?php echo $jdl; ?></td>
      </tr>
      <tr>  
        <td colspan="3" align="center" style="font-size:16px;font-weight:bold;"><?php echo $title_tgl; ?></td>
      </tr>
      <tr>
        <td align="center" style="font-size:12px; font-weight:bold;">(Dinyatakan dalam rupiah)</td>
      </tr>
  </table>
	<!--thead-->
  <table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" align="center">
     <tr>
        <td align="center" width="370" style="border-bottom:double; font-weight:bold;">Uraian</td>
        <td align="center" width="243" style="border-bottom:double; font-weight:bold;">Catatan Nomor</td>
        <td align="center" width="221" style="border-bottom:double; font-weight:bold;"><?php echo $col_tgl1; ?></td>
        <?php if ($tgl2=="1"){?>
        <td align="center" width="233" style="border-bottom:double; font-weight:bold;"><?php echo $col_tgl2; ?></td>
        <?php }?>
     </tr>
	<!--/thead> 
	<tbody-->
<?php
	$subtot=array(15);
	$subtot2=array(15);
	for ($i=0;$i<14;$i++){
		$subtot[$i]=0;
		$subtot2[$i]=0;
	}
	
	if ($sak_sap==1){
    	$sql = "select * from lap_neraca_sap where isaktif=1 order by kode";
	}else{
		$sql = "select * from lap_neraca_sak where isaktif=1 order by kode";
	}
    $hasil = mysql_query($sql);
   	while ($t = mysql_fetch_array($hasil)){
		$ikode=$t["kode_ma_sak"];
		$tipe=$t["tipe"];
		$klmpk=$t["klmpk"];
		$cdk=$t["d_k"];
		$cformula=str_replace(" ","",$t["formula"]);
		$cnilai=0;
		$cnilai2=0;
		if ($ikode!=""){
			$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita1' AND s.BULAN='$ibulan1' AND sak.MA_KODE LIKE '$ikode%'";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$cnilai=$rw1["nilai"];
			$strnilai=number_format($cnilai,0,",",".");
			
			if ($tgl2=="1"){
				$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita2' AND s.BULAN='$ibulan2' AND sak.MA_KODE LIKE '$ikode%'";
				$rs2=mysql_query($sql);
				$rw2=mysql_fetch_array($rs2);
				$cnilai2=$rw2["nilai"];
				$strnilai2=number_format($cnilai2,0,",",".");
			}
		}
		
		$font_weight="normal";
		if ($tipe==0){
			$font_weight="bold";
			$strnilai="";
			$strnilai2="";
			$cnilai=0;
			$cnilai2=0;
		}elseif ($tipe==2){
			$font_weight="bold";
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
			$strnilai=number_format($cnilai,0,",",".");
			$strnilai2=number_format($cnilai2,0,",",".");
			$cnilai=0;
			$cnilai2=0;
		}
		
		if ($klmpk>0){
			$subtot[$klmpk] +=$cnilai;
			$subtot2[$klmpk] +=$cnilai2;
		}
?>
      <tr>
        <td style="font-weight:<?php echo $font_weight; ?>; padding-left:<?php echo(25*($t['level']-3))."px"?>" align="left"><?php echo $t['nama'];?></td>
        <td align="center">&nbsp;</td>
        <td align="right"><?php echo $strnilai; ?></td>
        <?php if ($tgl2=="1"){?>
        <td align="right"><?php echo $strnilai2; ?></td>
        <?php }?>
      </tr>
<?php
   	}
?>
      <tr>
        <td align="left" style="border-bottom:double; border-top:#000 solid 1px;">&nbsp;</td>
        <td align="center" style="border-bottom:double; border-top:#000 solid 1px;">&nbsp;</td>
        <td align="center" style="border-bottom:double; border-top:#000 solid 1px;">&nbsp;</td>
        <?php if ($tgl2=="1"){?>
        <td align="right" style="border-bottom:double; border-top:#000 solid 1px;">&nbsp;</td>
        <?php }?>
      </tr>
	<!--/tbody-->    
</table>
<p id="p_print" align="center"><button type="button" onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Cetak</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="window.close();"><img src="../icon/back.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Tutup</button></p>
<!--/form>
</body>
</html-->
<?php
include "../sesi.php";
include('../koneksi/konek.php');
$bln1=$_REQUEST["bln1"];
$ta1=$_REQUEST["ta1"];
//$bln1="5|MEI";$ta1="2014";
$bln1=explode("|",$bln1);

$ibulan1=$bln1[0];
$ita1=$ta1;
if ($ibulan1==13){
	$ibulan1=1;
	$ita1+=1;
}



$bln2=$_REQUEST["bln2"];
$ta2=$_REQUEST["ta2"];
//$bln1="5|MEI";$ta1="2014";
$bln2=explode("|",$bln2);

$ibulan2=$bln2[0];
$ita2=$ta2;
if ($ibulan2==13){
	$ibulan2=1;
	$ita2+=1;
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Neraca</title>
</head>
<body>
<style>

tr a{
text-decoration:none;
color:#000000;
}

.tblheaderkiri {
	border: 1px solid #003520;
	background-color: #CCCCCC;
}

.tblheader {
	border-top: 1px solid #003520;
	border-right: 1px solid #003520;
	border-bottom: 1px solid #003520;
	border-left: none;
	background-color: #CCCCCC;
}

.tblfooterkiri {
	border: 1px solid #003520;
}

.tblfooter{
	border-top: 1px solid #003520;
	border-right: 1px solid #003520;
	border-bottom: 1px solid #003520;
	border-left: none;
}
.jumlah {
	border-top: 1px dashed #003520;

	border-bottom: 1px dashed #003520;
	border-right: 1px solid #203C42;

}

.tdisi {
	border-top: none;
	border-right: 1px solid #203C42;
	border-left: none;
	/*font-size: 11px;
	/*text-align: left;*/
}
.tdisikiri {
	border-top: none;
	border-right: 1px solid #203C42;
	border-left: 1px solid #203C42;
}
.tdisibawah{
	border-top: 1px solid #003520;
	border-bottom: 1px solid #003520;
	border-right: 1px solid #003520;
}


</style>
<table width="1038" height="258" border="0" align="center" cellpadding="0" cellspacing="0" >
	<tr align="center">
		<td colspan="2"><p style="font-size:12px">Rumah Sakit Prima Husada Cipta Medan </p>
		<p style="font-size:16px; font-weight:bold" >N E R A C A </p>
		<p style="font-size:16px; font-weight:bold" ><?php echo $title_tgl; ?></td>
	</tr>
<!-- aaa<?=$flag;?> -->
	<tr>
		<td width="513" align="left">&nbsp;Aktiva</td>
		<td width="515" align="right">Pasiva &nbsp;</td>
	</tr>
	<tr style="vertical-align:top" >
		<td height="40">
		<!-- ---TABLE AKTIVE --------- -->		
			<table width="515" height="53"  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="right">
			
				<tr height="17" align="center" style="font-weight:bold">
					<td height="17" width="40" class="tblheaderkiri">KR</td>
					<td width="271" class="tblheader" >U R A I A N</td>
					<td width="89" class="tblheader" ><?php echo $col_tgl1; ?></td>
					<?php if ($tgl2=="1"){?>
					<td width="103" class="tblheader" ><?php echo $col_tgl2; ?></td>
					<? }?>
				</tr>
				
				<?php
					$subtot=array(15);
					$subtot2=array(15);
					
					for ($i=0;$i<14;$i++){
						$subtot[$i]=0;
						$subtot2[$i]=0;
					}
					
					
					$sql = "select * from lap_neraca where isaktif=1 and aktiva_passiva=0 order by id + 0";
					//echo $sql;
					
					$hasil = mysql_query($sql);
					while ($t = mysql_fetch_array($hasil)){
					
						$ikode=$t["kode_ma_sak"];
						$tipe=$t["tipe"];
						$klmpk=$t["klmpk"];
						$cdk=$t["d_k"];
						$cformula=str_replace(" ","",$t["formula"]);
						$cnilai=0;
						$cnilai2=0;
						
						//-----------
							$sql_ma = "select ma_id from ma_sak where ma_kode='$ikode'";
							$ma = mysql_query($sql_ma);
							$ma2 = mysql_fetch_array($ma);
							$id_ma = $ma2['ma_id'];
							
							
						//-----------
						
						
						
						
						if ($ikode!=""){
						
							//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita1' AND s.BULAN='$ibulan1' AND sak.MA_KODE LIKE '$ikode%'";
							
							$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K, j.CC_RV_KSO_PBF_UMUM_ID  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)='$ibulan1' AND YEAR(j.TGL)='$ita1' AND j.flag = '$flag'"; //decyber_jurnal
							
							$rs1=mysql_query($sql);
							$rw1=mysql_fetch_array($rs1);
							$idccrvpbfumum = $rw1["CC_RV_KSO_PBF_UMUM_ID"];
							$cid = $rw1["FK_SAK"];
							if($cdk=='D'){
							$cnilai=$rw1["D"]-$rw1["K"];
							}else{
							$cnilai=$rw1["K"]-$rw1["D"];
							}
							//$cnilai=$rw1["nilai"];
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							
							}else{
							// $strnilai="(".number_format($cnilai*(-1),0,",",".").")";//decyber_Edit
							$strnilai="".number_format($cnilai*(-1),0,",",".")."";

							
							}
							
						
							if ($tgl2=="1"){
								//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita2' AND s.BULAN='$ibulan2' AND sak.MA_KODE LIKE '$ikode%'";
								$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K, j.CC_RV_KSO_PBF_UMUM_ID  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)='$ibulan2' AND YEAR(j.TGL)='$ita2' AND j.flag = '$flag'"; //decyber_jurnal
								$rs2=mysql_query($sql);
								$rw2=mysql_fetch_array($rs2);
								$idccrvpbfumum2 = $rw2["CC_RV_KSO_PBF_UMUM_ID"];
								if($cdk=='D'){
									$cnilai2=$rw2["D"]-$rw2["K"];
									}else{
									$cnilai2=$rw2["K"]-$rw2["D"];
									}
								if($cnilai2>=0){
								$strnilai2=number_format($cnilai2,0,",",".");
								}else{
								$strnilai2="".number_format($cnilai2*(-1),0,",",".")."";
								// $strnilai2="(".number_format($cnilai2*(-1),0,",",".").")";//decyber edit

								

								}
							}
						}
						
						// echo $sql;
						$kelas = "tdisi";
						$kelasf = "tdisi";
						$kelask = "tdisikiri";
						if($t['klmpk']==0 && $t['level']!=0 && $t['level']!=4 ){
							$kelas = "jumlah";
						
						}if($t['level']==4){
						
						$kelasf = "tblfooter";
						$kelas = "tblfooter";
						$kelask = "tblfooterkiri";
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
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							//$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							// $strnilai="(".number_format($cnilai*(-1),0,",",".").")";//hidden *decyber
							$strnilai="".number_format($cnilai*(-1),0,",",".")."";

							//$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							if($cnilai2>=0){
							//$strnilai=number_format($cnilai,0,",",".");
							$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							//$strnilai="(".number_format($cnilai,0,",",".").")";
							// $strnilai2="(".number_format($cnilai2*(-1),0,",",".").")";//hidden decyber
							$strnilai2="".number_format($cnilai2*(-1),0,",",".")."";
							}
							
							$cnilai=0;
							$cnilai2=0;
						
						}
						
						if ($klmpk>0){
							$subtot[$klmpk] +=$cnilai;
							$subtot2[$klmpk] +=$cnilai2;
						}
				?>
				
				<tr height="17" style="font-weight:<?php echo $font_weight; ?>; " align="left">
					<td height="17" align="center" class="<?php echo $kelask; ?>"><?php echo $t['kode'];?></td>
					<?php if($cnilai==0 || $cnilai=='' ){ ?>
					<td class="<?php echo $kelasf; ?>" style="padding-left:<?php echo(($t['level']-1)*15)."px"?>">&nbsp;<?php echo $t['nama'];?></td> <? }else{ ?>
					<td class="<?php echo $kelasf; ?>" style="padding-left:<?php echo(($t['level']-1)*15)."px"?>">
					
					<a href="../unit/main.php?f=bukubesar_neraca&idma=<?php echo $id_ma; ?>&ccrvpbfumum=<?php echo $tccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&cc_islast=<?php echo $cc_islast; ?>&kode_ma=<?php echo $ikode; ?>&bulan=<?php echo $ibulan1; ?>&ta=<?php echo $ita1; ?>&islast=0&detail=true">
					&nbsp;<?php echo $t['nama'];?></a></td>					
					<? } ?>
					<td class="<?php echo $kelas; ?>" align="right"> <?php echo $strnilai; ?>&nbsp;</td>
					<?php if ($tgl2=="1"){?>
					<td class="<?php echo $kelas; ?>" align="right"  ><?php echo $strnilai2; ?>&nbsp;</td>
					<? } ?>
					
				<? } ?>
		
			</table>
		</td>
		<td>
			<!-- -------------TABLE PASIVA -------------->	
					
			<table width="515" height="53"  cellpadding="0" cellspacing="0"  style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="left">
				<tr height="17" align="center" style="font-weight:bold">
					<td height="17" width="40" class="tblheader">KR</td>
					<td width="271" class="tblheader" >U R A I A N</td>
					<td width="89" class="tblheader" ><?php echo $col_tgl1; ?></td>
					<?php if ($tgl2=="1"){?>
					<td width="103" class="tblheader" ><?php echo $col_tgl2; ?></td>
					<? } ?>
				</tr> 
					<?php
					$subtot=array(15);
					$subtot2=array(15);
					
					for ($i=0;$i<14;$i++){
						$subtot[$i]=0;
						$subtot2[$i]=0;
					}
					
					
					$sql = "select * from lap_neraca where isaktif=1 and aktiva_passiva=1 order by id + 0";
					
					
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
						
							//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita1' AND s.BULAN='$ibulan1' AND sak.MA_KODE LIKE '$ikode%'";
							
							$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)='$ibulan1' AND YEAR(j.TGL)='$ita1' AND j.flag = '$flag'"; //decyber_jurnal
							
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
							// $strnilai="(".number_format($cnilai*(-1),0,",",".").")"; //edit decyber
							$strnilai="".number_format($cnilai*(-1),0,",",".")."";
							
							}
							
						
							if ($tgl2=="1"){
								//$sql="SELECT ABS(IFNULL(SUM(s.SALDO_AWAL),0)) nilai FROM saldo s INNER JOIN ma_sak sak ON s.FK_MAID=sak.MA_ID WHERE s.TAHUN='$ita2' AND s.BULAN='$ibulan2' AND sak.MA_KODE LIKE '$ikode%'";
								$sql= "select IFNULL(SUM(j.DEBIT),'-') D, IFNULL(SUM(j.KREDIT),'-') K  from jurnal j
							inner join ma_sak ms ON j.FK_SAK = ms.MA_ID  WHERE ms.MA_KODE LIKE '$ikode%' AND MONTH(j.TGL)='$ibulan2' AND YEAR(j.TGL)='$ita2'  AND j.flag = '$flag'"; //decyber_jurnal
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
								// $strnilai2="(".number_format($cnilai2*(-1),0,",",".").")";//decyber
								$strnilai2="".number_format($cnilai2*(-1),0,",",".")."";
								}
							}
						}
						
						$kelas = "tdisi";
						$kelasf = "tdisi";
						$kelask = "tdisikiri";
						if($t['klmpk']==0 && $t['level']!=0 && $t['level']!=4 ){
							$kelas = "jumlah";
						
						}if($t['level']==4){
						
						$kelasf = "tblfooter";
						$kelas = "tblfooter";
						$kelask = "tblfooterkiri";
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
							
							if($cnilai>=0){
							$strnilai=number_format($cnilai,0,",",".");
							//$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							// $strnilai="(".number_format($cnilai*(-1),0,",",".").")";//decyber
							$strnilai="".number_format($cnilai*(-1),0,",",".")."";
							//$strnilai2="(".number_format($cnilai2,0,",",".").")";
							}
							if($cnilai2>=0){
							//$strnilai=number_format($cnilai,0,",",".");
							$strnilai2=number_format($cnilai2,0,",",".");
							}else{
							//$strnilai="(".number_format($cnilai,0,",",".").")";
							// $strnilai2="(".number_format($cnilai2*(-1),0,",",".").")";//decyber
							$strnilai2="".number_format($cnilai2*(-1),0,",",".")."";
							}
							
							$cnilai=0;
							$cnilai2=0;
						
						}
						
						if ($klmpk>0){
							$subtot[$klmpk] +=$cnilai;
							$subtot2[$klmpk] +=$cnilai2;
						}
				?>
				
					
					
					     
				<tr height="17" style="font-weight:<?php echo $font_weight; ?>; " align="left">
					<td height="17" align="center" class="<?php echo $kelasf; ?>"><?php echo $t['kode'];?></td>
					<?php if($cnilai==0 || $cnilai=='' ){ ?>
					<td class="<?php echo $kelasf; ?>" style="padding-left:<?php echo(($t['level']-1)*15)."px"?>">&nbsp;<?php echo $t['nama'];?></td><? }else{ ?>
					<td class="<?php echo $kelasf; ?>" style="padding-left:<?php echo(($t['level']-1)*15)."px"?>">
					
					<a href="../unit/main.php?f=bukubesar_neraca&idma=<?php echo $id_ma; ?>&ccrvpbfumum=<?php echo $tccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&cc_islast=<?php echo $cc_islast; ?>&kode_ma=<?php echo $ikode; ?>&bulan=<?php echo $ibulan1; ?>&ta=<?php echo $ita1; ?>&islast=0&detail=true">
					&nbsp;<?php echo $t['nama'];?></a>
					
					</td>					
					<? } ?>
					<td class="<?php echo $kelas; ?>" align="right"> <?php echo $strnilai; ?>&nbsp;</td>
					<?php if ($tgl2=="1"){?>
					<td class="<?php echo $kelas; ?>" align="right"> <?php echo $strnilai2; ?>&nbsp;</td>
					<? } ?>
				</tr>
				<?php } ?>
		
			</table>
		</td>
	</tr>
	<tr align="center" style="font-size:12px">
		  <td colspan="2" ><br>Belawan,<br>
	      RUMAH SAKIT PELABUHAN MEDAN<br>
	      Plt. KEPALA<br>
	      <br>
	      <br>
	      Dr. AUSVIN GENIUSMAN KOMAINI, M.H.Kes
		  </td>
	</tr>
</table>

<p id="p_print" align="center"><button type="button" onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Cetak</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="window.close();"><img src="../icon/back.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Tutup</button></p>
</body>
</html>

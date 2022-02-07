<?php
session_start();
if($_REQUEST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
include "../sesi.php";
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s="01-01-".substr($th,6,4);
$cbln=(substr($tgl_s,3,1)=="0")?substr($tgl_s,4,1):substr($tgl_s,3,2);
$cthn=substr($tgl_s,6,4);
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$th;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$th=explode("-",$th);
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];

if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}

$id=$_REQUEST["id"];
$it=$_REQUEST["it"];
$iunit=$_REQUEST["iunit"];
if ($iunit==""){
	$iunit=$idunit."|".$usrname;
}else{
	$usrname=explode("|",$iunit);
	$usrname=$usrname[1];
}

$dsp_view="none";
$dsp_export="table-row";
$tampilback=0;

//laba rugi

$ta_lr=$_REQUEST['ta_lr'];

if ($ta_lr=="") $ta_lr=$th[2];

$bulan_l=$_REQUEST["bulan_lr"];
$bulan_ll=explode("|",$bulan_l);



$bulan_lr=$bulan_ll[0];
$nm_bulan=$bulan_ll[1];
$title_tgl =" BULAN $nm_bulan $ta_lr";
if ($bulan_lr==""){
	$bulan_lr=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$a=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rugi Laba</title>
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
table, td {
   padding-right:2px;
}

</style>
	<?php 
		$sak_sap=$_REQUEST["sak_sap"];
		if ($sak_sap=="") $sak_sap="1";
		if ($sak_sap=="1"){
			$jdl_lap="Laporan Rincian Laba/Rugi";
			$tbl_lap="lap_arus_kas";
		}else{
			$jdl_lap="Laporan Rincian Laba/Rugi";
			$tbl_lap="lap_lak_sap";
			
		}
		
		$jbeban=$_REQUEST["jbeban"];
		
		$tipe=$_REQUEST["tipe"];
		$ma_kode=$_REQUEST["ma_kode"];

	?>	
<p align="center" style="font-size:17px;font-weight:bold">LAPORAN DETAIL RUGI/LABA
<br/>
<?php echo $title_tgl; ?>	</p>
		
<div>
 <table width="1500" cellspacing="0" cellpadding="0" border="1" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse; padding-right:">
      <tr style="font-weight:bold" bgcolor="#E6E6E6">
	  <td align="center">&nbsp;</td>
	  <td width="194" align="center">&nbsp;</td>
	  <td colspan="6" align="center">ANGGARAN</td>
	  <td colspan="3" align="center">REALISASI</td>
	  <td width="89" rowspan="3" align="center">DEVASI (11-8) </td>
	  <td colspan="4" align="center">RASIO</td>
	</tr>
	<tr style="font-weight:bold" bgcolor="#E6E6E6">
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td width="93" rowspan="2" align="center">TAHUN <?php echo $ta_lr ?></td>
	  <td width="99" rowspan="2" align="center">S/D TRIWULAN LALU </td>
	  <td colspan="3" align="center">TRIWULAN NERJALAN </td>
	  <td width="90" rowspan="2" align="center">S/D TRIWULAN INI </td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td width="96" rowspan="2" align="center">12/8</td>
	  <td width="82" rowspan="2" align="center">10/6</td>
	  <td width="82" rowspan="2" align="center">11/8</td>
	  <td width="78" rowspan="2" align="center">11/3</td>
	</tr >
	<tr style="font-weight:bold" bgcolor="#E6E6E6">
	  <td width="29" align="center">No</td>
	  <td align="center">Uraian</td>
	  <td width="87" align="center">S/D BULAN LALU</td>
	  <td width="83" align="center">BULAN INI</td>
	  <td width="93" align="center">S/D BULAN INI</td>
	  <td width="85" align="center">S/D BULAN LALU</td>
	  <td width="94" align="center">BULAN INI</td>
	  <td width="92" align="center">S/D BULAN INI</td>
	</tr>
	<tr>
	  <td align="center">1</td>
	  <td align="center">2</td>
	  <td align="center">3</td>
	  <td align="center">4</td>
	  <td align="center">5</td>
	  <td align="center">6</td>
	  <td align="center">7</td>
	  <td align="center">8</td>
	  <td align="center">9</td>
	  <td align="center">10</td>
	  <td align="center">11</td>
	  <td align="center">12</td>
	  <td align="center">13</td>
	  <td align="center">14</td>
	  <td align="center">15</td>
	  <td align="center">16</td>
    </tr>
	<tr>
	  <td align="center">4.1.00.00.00.00</td> <!-- decyber , mengganti ke coa baru -->
	  <td align="left">&nbsp;Pendapatan Pelayanan RS PHCM</td> <!-- decyber , mengganti ke RS PHCM -->
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_LEVEL>2 AND MA_KODE LIKE '4.%' ORDER BY MA_KODE"; //dirubah sesuai COA baru *decyber
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$i=0;
	$subtotOp=$subtotOp2=$subtotOp3=0;
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotAngOp3=0;
	$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lblRasio1=$stotRasio1=$lblRasio2=$stotRasio2=$lblRasio3=$stotRasio3=$lblRasio4=$stotRasio4=0;
	$stotOp=$stotOp2=$stotOp3=$totDeviasi=$totRasio1=$totRasio2=$totRasio3=$totRasio4=0;
	
	$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
	$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
	$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=$stotAngThOp=0;
	$isSub=0;
	
	while ($rw=mysql_fetch_array($rs)){
		$i++;
		$clvl=$rw["MA_LEVEL"];
		$cislast=$rw["MA_ISLAST"];
		$ckode=explode(".",$rw["MA_KODE"]);
		$lblkodenew=$rw["MA_KODE_VIEW"]; //decyber
		$lblnama=$rw["MA_NAMA"];

		// var_dump($ckode);
		
		if (($cislast==0) && ($isSub==1)){
			$isSub=0;
	
	?>
	

	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<?php
			$subtotOp=$subtotOp2=$subtotOp3=$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lbltotRasio1=$stotRasio1=$lbltotRasio2=$stotRasio2=$lbltotRasio3=$stotRasio3=$lbltotRasio4=$stotRasio4=0;
		}
		
		if ($clvl==3){
			$lblkode=$ckode[1];
			$lblkodeJml=$ckode[1];
		}else{
			$lblkode="";
			$lblnama=$ckode[2].". ".$rw["MA_NAMA"];
		}
		$lblN=$lblN2=$lblN3=$nilaiAngTh=$nilaiAng=$nilaiAng2=$nilaiAngOp3=$Deviasi=$lblDeviasi=$Rasio1=$lblRasio1=$Rasio2=$lblRasio2=$Rasio3=$lblRasio3=$Rasio4=$lblRasio4="";
		
		if ($cislast==1){
			$isSub=1;
			
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
			UNION
			SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			
			$subtotOp +=$rw1["nilai"];
			$subtotOp2 +=$rw1["nilai2"];
			
			$subtotOp3 +=$rw1["nilai"]+$rw1["nilai2"];
			
			$stotOp+=$rw1["nilai"];
			$stotOp2+=$rw1["nilai2"];
			$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
			
			$lblN=number_format($rw1["nilai"],0,",",".");
			$lblN2=number_format($rw1["nilai2"],0,",",".");
			$lblN3=number_format(($rw1["nilai"]+$rw1["nilai2"]),0,",",".");
			
			 
		
				//tambahan
		$sql="SELECT
			   IFNULL(SUM(j.NILAI), 0) AS nilai
			 FROM anggaran j
			   INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
			 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
	
		$stotAngThOp+=$rwAngTh1["nilai"];
		$subtotAngThOp+=$rwAngTh1["nilai"];
		$nilaiAngTh=number_format($rwAngTh1["nilai"],0,",",".");

		$sql="SELECT
				  SUM(t.nilai) AS nilai,
				  SUM(t.nilai2) AS nilai2
				FROM (SELECT
						IFNULL(SUM(j.NILAI), 0) AS nilai,
						'0' AS nilai2
					  FROM anggaran j
						INNER JOIN ma_sak ma
						  ON j.FK_MAID = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						  AND j.BULAN < $bulan_lr
						  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
					  UNION 
					  SELECT
					   '0'  AS nilai,
					   IFNULL(SUM(j.NILAI), 0) AS nilai2
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						 AND j.BULAN = $bulan_lr
						 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
		$rsAng1=mysql_query($sql);
		$rwAng1=mysql_fetch_array($rsAng1);
		
		
		$stotAngOp+=$rwAng1["nilai"];
		$subtotAngOp+=$rwAng1["nilai"];
		
		$stotAngOp2+=$rwAng1["nilai2"];
		$subtotAngOp2+=$rwAng1["nilai2"];
		
		
		$stotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		$subtotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		
		$nilaiAng=number_format($rwAng1["nilai"],0,",",".");
		$nilaiAng2=number_format($rwAng1["nilai2"],0,",",".");
		$nilaiAngOp3=number_format($rwAng1["nilai"]+$rwAng1["nilai2"],0,",",".");
		
		
		$Deviasi=($rw1["nilai"]+$rw1["nilai2"])-($rwAng1["nilai"]+$rwAng1["nilai2"]);
					
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$totDeviasi +=$Deviasi;
		
		
		$Rasio1=($nilaiAngOp3==0)?0:$Deviasi/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		
		$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
		$Rasio3=(($rwAng1["nilai"]+$rwAng1["nilai2"])==0)?0:($rw1["nilai"]+$rw1["nilai2"])/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		$Rasio4=($rwAngTh1["nilai"]==0)?0:($rw1["nilai"]+$rw1["nilai2"])/$rwAngTh1["nilai"] * 100;
					
		

		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		$lbltotResio1 = ($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
		$lbltotResio2 = ($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
		$lbltotResio3 = ($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
		$lbltotResio4 = ($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
		$totRasio1 +=$Rasio1;
		$totRasio2 +=$Rasio2;
		$totRasio3 +=$Rasio3;
		$totRasio4 +=$Rasio4;
		
			
		}
	?>
	
	<tr>
	  <td align="center"><?php echo $lblkodenew; ?></td>
	  <td>&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td> 
	  <td align="right"><?php echo $nilaiAngTh; ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo $nilaiAng; ?></td>
	  <td align="right"><?php echo $nilaiAng2; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	   <td align="right"> <?php echo $lblN; ?></td>
	   <td align="right"> <?php echo $lblN2; ?></td>
	   <td align="right"><?php echo $lblN3; ?></td>
	   <td align="right"><?php echo $lblDeviasi; ?></td>
	   <td align="right"><?php echo $lblRasio1; ?></td>
	   <td align="right"><?php echo $lblRasio2; ?></td>
	   <td align="right"><?php echo $lblRasio3; ?></td>
	   <td align="right"><?php echo $lblRasio4; ?></td>
	</tr>
	<?php 
	}				
	?>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;JUMLAH PENDAPATAN PELAYANAN : </td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totDeviasi,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio4,0,",","."); ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<?php 
	if ($jbeban=="0" || $jbeban==""){
	$kodeMaOp="5";
	$sql="SELECT * FROM ma_sak WHERE MA_KODE LIKE '$kodeMaOp%'";
	// echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$cma_id=$rwB["MA_KODE"];
	?>
	<tr>
	  <td align="center">5.0.00.00.00.00</td>
	  <td align="left">&nbsp;Biaya Pelayanan RS PHCM</td><!--//decyber, diubah ke PHCM-->
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<?php 
	$kodeMaUmum="4"; //decyber
	$kodeMaBPOKawaka="831";
	$kodeMaBPOUmum="832";
	$kodeMaBPOKeu="833";
	$kodeMaBPOTeknik="834";
	$isSub=0;
	$subtotBOp=$subtotBOp2=$subtotBOp3=0;
	
	$sqln="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id' ORDER BY MA_KODE"; //*decyber penambahan untuk memunculkan semua beban anak kedua
	$rsBn=mysql_query($sqln); //decyber
	// echo $sqln;
	while ($rwBn=mysql_fetch_array($rsBn)){//decyber
		$nama_MA_BPO=$rwBn["MA_NAMA"];
		$cma_id_new=$rwBn['MA_KODE'];
		// var_dump($rwBn);
	$sql="SELECT * FROM ma_sak WHERE MA_PARENT_KODE = '$cma_id_new' OR MA_KODE = '$cma_id_new' ORDER BY MA_KODE";
	// echo $sql."<br>";
	$rsB=mysql_query($sql);
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
	$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
	
	
	while ($rwB=mysql_fetch_array($rsB)){
	
		$kode_MA_BPO=$rwB["MA_KODE"];
		$kode_MA_BPO_V=$rwB["MA_KODE_VIEW"];
		$kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
		$arkode_MA_BPO=explode(".",$kode_MA_BPO);
		$nama_MA_BPO=$rwB["MA_NAMA"];
		
		 $sql="SELECT
				IFNULL(SUM(j.NILAI), 0) AS nilai
				FROM anggaran j
				INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
				WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				 
				 
				 
				 
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
		if($rwB['MA_KODE'] == $cma_id_new){//ksih kondisi
			//decyber, ksih kondisi biar agak tebal
		}else{
			$stotAngThOp+=$rwAngTh1["nilai"];
		}
		
		
		 $sql="SELECT
				SUM(t.nilai) AS nilai,
				SUM(t.nilai2) AS nilai2
				FROM (SELECT
					IFNULL(SUM(j.NILAI), 0) AS nilai,
					'0' AS nilai2
				  FROM anggaran j
					INNER JOIN ma_sak ma
					  ON j.FK_MAID = ma.MA_ID
				  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
					  AND j.BULAN < $bulan_lr
					  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
				  UNION 
				  SELECT
				   '0'  AS nilai,
				   IFNULL(SUM(j.NILAI), 0) AS nilai2
				 FROM anggaran j
				   INNER JOIN ma_sak ma
					 ON j.FK_MAID = ma.MA_ID
				 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
					 AND j.BULAN = $bulan_lr
					 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
			$rsAng1=mysql_query($sql);
			$rwAng1=mysql_fetch_array($rsAng1);
			$stotAngOp +=$rwAng1["nilai"];
			$stotAngOp2 +=$rwAng1["nilai2"];
			
			$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
			$stotAngOp3 +=$AngOp3;
			

			$sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rsBPOSub=mysql_query($sqlBPOSub);
			$rwBPOSub=mysql_fetch_array($rsBPOSub);
			$biayaBPO=$rwBPOSub["nilai"];
			$biayaBPO2=$rwBPOSub["nilai2"];
			$biayaBPO3=$biayaBPO+$biayaBPO2;

			$stotBiayaOp +=$biayaBPO;
			$stotBiayaOp2 +=$biayaBPO2;
			
			$Deviasi=$biayaBPO3-$AngOp3;
			$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
			
			$stotDeviasi +=$Deviasi;
			$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
			
			$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
			$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
			$Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
			$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
			
			$stotRasio1 +=$Rasio1;
			$stotRasio2 +=$Rasio2;
			$stotRasio3 +=$Rasio3;
			$stotRasio4 +=$Rasio4;
			
			$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
			$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
			$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
			$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
	
			
		
	?>
	<tr>
	  <td align="center"><?php 
									if($rwB['MA_KODE'] == $cma_id_new){
										echo "<b>".$kode_MA_BPO_V."</b>";//decyber, ksih kondisi biar agak tebal
									}else{
									echo $kode_MA_BPO_V;
									} ?></td>

	   <?php 
	  
	  ?>
	  <!-- <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Detail.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td> -->
	  <?php 
	  //}else{
	  ?>
		<?php 	
									if($rwB['MA_KODE'] == $cma_id_new){//decyber
										?>
	  <td align="left">&nbsp;&nbsp;&nbsp;
		<?php
										echo "<b><font size=1.5>".$nama_MA_BPO."</font></b>";//decyber, ksih kondisi biar agak tebal
										?></td>
										<td align="right"></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
	  <?php 
	  //}
	  ?>
	  <td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
		<td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
	  <td align="right"></td>
										<?php

									}else{
										?>
										<td align="left">&nbsp;&nbsp;&nbsp;<?php echo $nama_MA_BPO;
									 ?></td>
	  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
	  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
	  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
	  <?php 
	  //}
	  ?>
	  <td align="right"><?php echo number_format($biayaBPO,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($biayaBPO2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($biayaBPO3,0,",","."); ?></td>
		<td align="right"><?php echo $lblDeviasi; // *decyber awalnya menggunakan number_format?></td>
	  <td align="right"><?php echo  number_format($lblstotRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo  number_format($lblstotRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo  number_format($lblstotRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo  number_format($lblstotRasio4,0,",","."); ?></td>
	</tr>
	<?php 
									}
	}
}
	$stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
	$stotRasio2=$stotRasio2/$i;
	$stotRasio3=$stotRasio3/$i;
	$stotRasio4=$stotRasio4/$i;
	
	$lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
	$lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
	$lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
	$lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
	?>

	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;JUMLAH BIAYA PELAYANAN : </td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotBiayaOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotBiayaOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotBiayaOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lblstotRasio1; ?></td>
	  <td align="right"><?php echo $lblstotRasio2; ?></td>
	  <td align="right"><?php echo $lblstotRasio3; ?></td>
	  <td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>

	<!--  *decyber start_line-->
	<tr>
	  <td align="center">6.0.00.00.00.00</td> <!-- decyber , mengganti ke coa baru -->
	  <td align="left">&nbsp;PENDAPATAN (BEBAN) NON USAHA</td> <!-- decyber , mengganti ke RS PHCM -->
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_LEVEL>2 AND MA_KODE LIKE '6.%' ORDER BY MA_KODE"; //dirubah sesuai COA baru *decyber
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$i=0;
	$subtotOp=$subtotOp2=$subtotOp3=0;
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotAngOp3=0;
	$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lblRasio1=$stotRasio1=$lblRasio2=$stotRasio2=$lblRasio3=$stotRasio3=$lblRasio4=$stotRasio4=0;
	$stotOp=$stotOp2=$stotOp3=$totDeviasi=$totRasio1=$totRasio2=$totRasio3=$totRasio4=0;
	
	$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
	$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
	$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=$stotAngThOp=0;
	$isSub=0;
	
	while ($rw=mysql_fetch_array($rs)){
		$i++;
		$clvl=$rw["MA_LEVEL"];
		$cislast=$rw["MA_ISLAST"];
		$ckode=explode(".",$rw["MA_KODE"]);
		$lblkodenew=$rw["MA_KODE_VIEW"]; //decyber
		$lblnama=$rw["MA_NAMA"];

		// var_dump($ckode);
		
		if (($cislast==0) && ($isSub==1)){
			$isSub=0;
	
	?>
	

	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<?php
			$subtotOp=$subtotOp2=$subtotOp3=$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lbltotRasio1=$stotRasio1=$lbltotRasio2=$stotRasio2=$lbltotRasio3=$stotRasio3=$lbltotRasio4=$stotRasio4=0;
		}
		
		if ($clvl==3){
			$lblkode=$ckode[1];
			$lblkodeJml=$ckode[1];
		}else{
			$lblkode="";
			$lblnama=$ckode[2].". ".$rw["MA_NAMA"];
		}
		$lblN=$lblN2=$lblN3=$nilaiAngTh=$nilaiAng=$nilaiAng2=$nilaiAngOp3=$Deviasi=$lblDeviasi=$Rasio1=$lblRasio1=$Rasio2=$lblRasio2=$Rasio3=$lblRasio3=$Rasio4=$lblRasio4="";
		
		if ($cislast==1){
			$isSub=1;
			
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
			UNION
			SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			
			$subtotOp +=$rw1["nilai"];
			$subtotOp2 +=$rw1["nilai2"];
			
			$subtotOp3 +=$rw1["nilai"]+$rw1["nilai2"];
			
			$stotOp+=$rw1["nilai"];
			$stotOp2+=$rw1["nilai2"];
			$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
			
			$lblN=number_format($rw1["nilai"],0,",",".");
			$lblN2=number_format($rw1["nilai2"],0,",",".");
			$lblN3=number_format(($rw1["nilai"]+$rw1["nilai2"]),0,",",".");
			
			 
		
				//tambahan
		$sql="SELECT
			   IFNULL(SUM(j.NILAI), 0) AS nilai
			 FROM anggaran j
			   INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
			 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
	
		$stotAngThOp+=$rwAngTh1["nilai"];
		$subtotAngThOp+=$rwAngTh1["nilai"];
		$nilaiAngTh=number_format($rwAngTh1["nilai"],0,",",".");

		$sql="SELECT
				  SUM(t.nilai) AS nilai,
				  SUM(t.nilai2) AS nilai2
				FROM (SELECT
						IFNULL(SUM(j.NILAI), 0) AS nilai,
						'0' AS nilai2
					  FROM anggaran j
						INNER JOIN ma_sak ma
						  ON j.FK_MAID = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						  AND j.BULAN < $bulan_lr
						  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
					  UNION 
					  SELECT
					   '0'  AS nilai,
					   IFNULL(SUM(j.NILAI), 0) AS nilai2
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						 AND j.BULAN = $bulan_lr
						 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
		$rsAng1=mysql_query($sql);
		$rwAng1=mysql_fetch_array($rsAng1);
		
		
		$stotAngOp+=$rwAng1["nilai"];
		$subtotAngOp+=$rwAng1["nilai"];
		
		$stotAngOp2+=$rwAng1["nilai2"];
		$subtotAngOp2+=$rwAng1["nilai2"];
		
		
		$stotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		$subtotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		
		$nilaiAng=number_format($rwAng1["nilai"],0,",",".");
		$nilaiAng2=number_format($rwAng1["nilai2"],0,",",".");
		$nilaiAngOp3=number_format($rwAng1["nilai"]+$rwAng1["nilai2"],0,",",".");
		
		
		$Deviasi=($rw1["nilai"]+$rw1["nilai2"])-($rwAng1["nilai"]+$rwAng1["nilai2"]);
					
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$totDeviasi +=$Deviasi;

		$lblstotDeviasiJm=($totDeviasi<0)?"(".number_format(abs($totDeviasi),0,",",".").")":number_format($totDeviasi,0,",",".");
		
		
		$Rasio1=($nilaiAngOp3==0)?0:$Deviasi/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		
		$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
		$Rasio3=(($rwAng1["nilai"]+$rwAng1["nilai2"])==0)?0:($rw1["nilai"]+$rw1["nilai2"])/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		$Rasio4=($rwAngTh1["nilai"]==0)?0:($rw1["nilai"]+$rw1["nilai2"])/$rwAngTh1["nilai"] * 100;
					
		

		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		$lbltotResio1 = ($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
		$lbltotResio2 = ($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
		$lbltotResio3 = ($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
		$lbltotResio4 = ($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
		$totRasio1 +=$Rasio1;
		$totRasio2 +=$Rasio2;
		$totRasio3 +=$Rasio3;
		$totRasio4 +=$Rasio4;
		
			
		}
	?>
	
	<tr>
	  <td align="center"><?php echo $lblkodenew; ?></td>
	  <td>&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td> 
	  <td align="right"><?php echo $nilaiAngTh; ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo $nilaiAng; ?></td>
	  <td align="right"><?php echo $nilaiAng2; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	   <td align="right"> <?php echo $lblN; ?></td>
	   <td align="right"> <?php echo $lblN2; ?></td>
	   <td align="right"><?php echo $lblN3; ?></td>
	   <td align="right"><?php echo $lblDeviasi; ?></td>
	   <td align="right"><?php echo $lblRasio1; ?></td>
	   <td align="right"><?php echo $lblRasio2; ?></td>
	   <td align="right"><?php echo $lblRasio3; ?></td>
	   <td align="right"><?php echo $lblRasio4; ?></td>
	</tr>
	<?php 
	}				
	?>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;JUMLAH PENDAPATAN (BEBAN) NON USAHA : </td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lblstotDeviasiJm; ?></td>
	  <td align="right"><?php echo number_format($totRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio4,0,",","."); ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<!-- *decyber end_line -->

	

	<!--  *decyber start_line 7.0-->
	<tr>
	  <td align="center">7.0.00.00.00.00</td> <!-- decyber , mengganti ke coa baru -->
	  <td align="left">&nbsp;(BEBAN) PENGHASILAN PAJAK</td> <!-- decyber , mengganti ke RS PHCM -->
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_LEVEL>2 AND MA_KODE LIKE '7.%' ORDER BY MA_KODE"; //dirubah sesuai COA baru *decyber
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$i=0;
	$subtotOp=$subtotOp2=$subtotOp3=0;
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotAngOp3=0;
	$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lblRasio1=$stotRasio1=$lblRasio2=$stotRasio2=$lblRasio3=$stotRasio3=$lblRasio4=$stotRasio4=0;
	$stotOp=$stotOp2=$stotOp3=$totDeviasi=$totRasio1=$totRasio2=$totRasio3=$totRasio4=0;
	
	$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
	$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
	$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=$stotAngThOp=0;
	$isSub=0;
	
	while ($rw=mysql_fetch_array($rs)){
		$i++;
		$clvl=$rw["MA_LEVEL"];
		$cislast=$rw["MA_ISLAST"];
		$ckode=explode(".",$rw["MA_KODE"]);
		$lblkodenew=$rw["MA_KODE_VIEW"]; //decyber
		$lblnama=$rw["MA_NAMA"];

		// var_dump($ckode);
		
		if (($cislast==0) && ($isSub==1)){
			$isSub=0;
	
	?>
	

	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<?php
			$subtotOp=$subtotOp2=$subtotOp3=$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lbltotRasio1=$stotRasio1=$lbltotRasio2=$stotRasio2=$lbltotRasio3=$stotRasio3=$lbltotRasio4=$stotRasio4=0;
		}
		
		if ($clvl==3){
			$lblkode=$ckode[1];
			$lblkodeJml=$ckode[1];
		}else{
			$lblkode="";
			$lblnama=$ckode[2].". ".$rw["MA_NAMA"];
		}
		$lblN=$lblN2=$lblN3=$nilaiAngTh=$nilaiAng=$nilaiAng2=$nilaiAngOp3=$Deviasi=$lblDeviasi=$Rasio1=$lblRasio1=$Rasio2=$lblRasio2=$Rasio3=$lblRasio3=$Rasio4=$lblRasio4="";
		
		if ($cislast==1){
			$isSub=1;
			
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
			UNION
			SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			
			$subtotOp +=$rw1["nilai"];
			$subtotOp2 +=$rw1["nilai2"];
			
			$subtotOp3 +=$rw1["nilai"]+$rw1["nilai2"];
			
			$stotOp+=$rw1["nilai"];
			$stotOp2+=$rw1["nilai2"];
			$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
			
			$lblN=number_format($rw1["nilai"],0,",",".");
			$lblN2=number_format($rw1["nilai2"],0,",",".");
			$lblN3=number_format(($rw1["nilai"]+$rw1["nilai2"]),0,",",".");
			
			 
		
				//tambahan
		$sql="SELECT
			   IFNULL(SUM(j.NILAI), 0) AS nilai
			 FROM anggaran j
			   INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
			 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
	
		$stotAngThOp+=$rwAngTh1["nilai"];
		$subtotAngThOp+=$rwAngTh1["nilai"];
		$nilaiAngTh=number_format($rwAngTh1["nilai"],0,",",".");

		$sql="SELECT
				  SUM(t.nilai) AS nilai,
				  SUM(t.nilai2) AS nilai2
				FROM (SELECT
						IFNULL(SUM(j.NILAI), 0) AS nilai,
						'0' AS nilai2
					  FROM anggaran j
						INNER JOIN ma_sak ma
						  ON j.FK_MAID = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						  AND j.BULAN < $bulan_lr
						  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
					  UNION 
					  SELECT
					   '0'  AS nilai,
					   IFNULL(SUM(j.NILAI), 0) AS nilai2
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						 AND j.BULAN = $bulan_lr
						 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
		$rsAng1=mysql_query($sql);
		$rwAng1=mysql_fetch_array($rsAng1);
		
		
		$stotAngOp+=$rwAng1["nilai"];
		$subtotAngOp+=$rwAng1["nilai"];
		
		$stotAngOp2+=$rwAng1["nilai2"];
		$subtotAngOp2+=$rwAng1["nilai2"];
		
		
		$stotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		$subtotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		
		$nilaiAng=number_format($rwAng1["nilai"],0,",",".");
		$nilaiAng2=number_format($rwAng1["nilai2"],0,",",".");
		$nilaiAngOp3=number_format($rwAng1["nilai"]+$rwAng1["nilai2"],0,",",".");
		
		
		$Deviasi=($rw1["nilai"]+$rw1["nilai2"])-($rwAng1["nilai"]+$rwAng1["nilai2"]);
					
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$totDeviasi +=$Deviasi;

		$lblstotDeviasi=($totDeviasi<0)?"(".number_format(abs($totDeviasi),0,",",".").")":number_format($totDeviasi,0,",",".");
		
		
		
		$Rasio1=($nilaiAngOp3==0)?0:$Deviasi/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		
		$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
		$Rasio3=(($rwAng1["nilai"]+$rwAng1["nilai2"])==0)?0:($rw1["nilai"]+$rw1["nilai2"])/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		$Rasio4=($rwAngTh1["nilai"]==0)?0:($rw1["nilai"]+$rw1["nilai2"])/$rwAngTh1["nilai"] * 100;
					
		

		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		$lbltotResio1 = ($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
		$lbltotResio2 = ($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
		$lbltotResio3 = ($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
		$lbltotResio4 = ($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
		$totRasio1 +=$Rasio1;
		$totRasio2 +=$Rasio2;
		$totRasio3 +=$Rasio3;
		$totRasio4 +=$Rasio4;
		
			
		}
	?>
	
	<tr>
	  <td align="center"><?php echo $lblkodenew; ?></td>
	  <td>&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td> 
	  <td align="right"><?php echo $nilaiAngTh; ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo $nilaiAng; ?></td>
	  <td align="right"><?php echo $nilaiAng2; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	   <td align="right"> <?php echo $lblN; ?></td>
	   <td align="right"> <?php echo $lblN2; ?></td>
	   <td align="right"><?php echo $lblN3; ?></td>
	   <td align="right"><?php echo $lblDeviasi; ?></td>
	   <td align="right"><?php echo $lblRasio1; ?></td>
	   <td align="right"><?php echo $lblRasio2; ?></td>
	   <td align="right"><?php echo $lblRasio3; ?></td>
	   <td align="right"><?php echo $lblRasio4; ?></td>
	</tr>
	<?php 
	}				
	?>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah (<?php echo $lblkodeJml; ?>) :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($subtotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotAngOp3,0,",","."); ?></td>
	  
	  <td align="right"><?php echo number_format($subtotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($subtotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lbltotRasio1; ?></td>
	  <td align="right"><?php echo $lbltotRasio2; ?></td>
	  <td align="right"><?php echo $lbltotRasio3; ?></td>
	  <td align="right"><?php echo $lbltotRasio4; ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;JUMLAH (BEBAN) PENGHASILAN PAJAK : </td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format(0,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotOp3,0,",","."); ?></td>
	  <td align="right"><?php echo $lblstotDeviasi; ?></td>
	  <td align="right"><?php echo number_format($totRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($totRasio4,0,",","."); ?></td>
	</tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<!-- *decyber end_line 7.0-->
	
	<!--  *decyber start_line 8.0-->

	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE LIKE '8%' ORDER BY MA_KODE"; //dirubah sesuai COA baru *decyber
	// echo $sql."<br>";
	$rs=mysql_query($sql);
	$i=0;
	$subtotOp=$subtotOp2=$subtotOp3=0;
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotAngOp3=0;
	$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lblRasio1=$stotRasio1=$lblRasio2=$stotRasio2=$lblRasio3=$stotRasio3=$lblRasio4=$stotRasio4=0;
	$stotOp=$stotOp2=$stotOp3=$totDeviasi=$totRasio1=$totRasio2=$totRasio3=$totRasio4=0;
	
	$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
	$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
	$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=$stotAngThOp=0;
	$isSub=0;
	
	while ($rw=mysql_fetch_array($rs)){
		$i++;
		$clvl=$rw["MA_LEVEL"];
		$cislast=$rw["MA_ISLAST"];
		$ckode=explode(".",$rw["MA_KODE"]);
		$lblkodenew=$rw["MA_KODE_VIEW"]; //decyber
		$lblnama=$rw["MA_NAMA"];

		// var_dump($rw);
		
		if (($cislast==0) && ($isSub==1)){
			$isSub=0;
	
	?>
	


	<?php
			$subtotOp=$subtotOp2=$subtotOp3=$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lbltotRasio1=$stotRasio1=$lbltotRasio2=$stotRasio2=$lbltotRasio3=$stotRasio3=$lbltotRasio4=$stotRasio4=0;
		}
		
		if ($clvl==3){
			$lblkode=$ckode[1];
			$lblkodeJml=$ckode[1];
		}else{
			$lblkode="";
			$lblnama=$ckode[2].". ".$rw["MA_NAMA"];
		}
		$lblN=$lblN2=$lblN3=$nilaiAngTh=$nilaiAng=$nilaiAng2=$nilaiAngOp3=$Deviasi=$lblDeviasi=$Rasio1=$lblRasio1=$Rasio2=$lblRasio2=$Rasio3=$lblRasio3=$Rasio4=$lblRasio4="";
		
		if ($cislast==1){
			$isSub=1;
			
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
			UNION
			SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			
			$subtotOp +=$rw1["nilai"];
			$subtotOp2 +=$rw1["nilai2"];
			
			$subtotOp3 +=$rw1["nilai"]+$rw1["nilai2"];
			
			$stotOp+=$rw1["nilai"];
			$stotOp2+=$rw1["nilai2"];
			$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
			
			$lblN=number_format($rw1["nilai"],0,",",".");
			$lblN2=number_format($rw1["nilai2"],0,",",".");
			$lblN3=number_format(($rw1["nilai"]+$rw1["nilai2"]),0,",",".");
			
			 
		
				//tambahan
		$sql="SELECT
			   IFNULL(SUM(j.NILAI), 0) AS nilai
			 FROM anggaran j
			   INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
			 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
	
		$stotAngThOp+=$rwAngTh1["nilai"];
		$subtotAngThOp+=$rwAngTh1["nilai"];
		$nilaiAngTh=number_format($rwAngTh1["nilai"],0,",",".");

		$sql="SELECT
				  SUM(t.nilai) AS nilai,
				  SUM(t.nilai2) AS nilai2
				FROM (SELECT
						IFNULL(SUM(j.NILAI), 0) AS nilai,
						'0' AS nilai2
					  FROM anggaran j
						INNER JOIN ma_sak ma
						  ON j.FK_MAID = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						  AND j.BULAN < $bulan_lr
						  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
					  UNION 
					  SELECT
					   '0'  AS nilai,
					   IFNULL(SUM(j.NILAI), 0) AS nilai2
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						 AND j.BULAN = $bulan_lr
						 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
		$rsAng1=mysql_query($sql);
		$rwAng1=mysql_fetch_array($rsAng1);
		
		
		$stotAngOp+=$rwAng1["nilai"];
		$subtotAngOp+=$rwAng1["nilai"];
		
		$stotAngOp2+=$rwAng1["nilai2"];
		$subtotAngOp2+=$rwAng1["nilai2"];
		
		
		$stotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		$subtotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		
		$nilaiAng=number_format($rwAng1["nilai"],0,",",".");
		$nilaiAng2=number_format($rwAng1["nilai2"],0,",",".");
		$nilaiAngOp3=number_format($rwAng1["nilai"]+$rwAng1["nilai2"],0,",",".");
		
		
		$Deviasi=($rw1["nilai"]+$rw1["nilai2"])-($rwAng1["nilai"]+$rwAng1["nilai2"]);
					
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$totDeviasi +=$Deviasi;
		
		
		$Rasio1=($nilaiAngOp3==0)?0:$Deviasi/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		
		$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
		$Rasio3=(($rwAng1["nilai"]+$rwAng1["nilai2"])==0)?0:($rw1["nilai"]+$rw1["nilai2"])/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		$Rasio4=($rwAngTh1["nilai"]==0)?0:($rw1["nilai"]+$rw1["nilai2"])/$rwAngTh1["nilai"] * 100;
					
		

		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		$lbltotResio1 = ($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
		$lbltotResio2 = ($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
		$lbltotResio3 = ($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
		$lbltotResio4 = ($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
		$totRasio1 +=$Rasio1;
		$totRasio2 +=$Rasio2;
		$totRasio3 +=$Rasio3;
		$totRasio4 +=$Rasio4;
		
			
		}
	?>
	
	<tr>
	  <td align="center"><?php echo $lblkodenew; ?></td>
	  <td>&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td> 
	  <td align="right"><?php echo $nilaiAngTh; ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo $nilaiAng; ?></td>
	  <td align="right"><?php echo $nilaiAng2; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	   <td align="right"> <?php echo $lblN; ?></td>
	   <td align="right"> <?php echo $lblN2; ?></td>
	   <td align="right"><?php echo $lblN3; ?></td>
	   <td align="right"><?php echo $lblDeviasi; ?></td>
	   <td align="right"><?php echo $lblRasio1; ?></td>
	   <td align="right"><?php echo $lblRasio2; ?></td>
	   <td align="right"><?php echo $lblRasio3; ?></td>
	   <td align="right"><?php echo $lblRasio4; ?></td>
	</tr>
	<?php 
	}				
	?>

<!-- *decyber end_line 8.0 -->
<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>


	<!--  *decyber start_line 9.0-->

	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE LIKE '9%' ORDER BY MA_KODE"; //dirubah sesuai COA baru *decyber
	// echo $sql."<br>";
	$rs=mysql_query($sql);
	$i=0;
	$subtotOp=$subtotOp2=$subtotOp3=0;
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotAngOp3=0;
	$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lblRasio1=$stotRasio1=$lblRasio2=$stotRasio2=$lblRasio3=$stotRasio3=$lblRasio4=$stotRasio4=0;
	$stotOp=$stotOp2=$stotOp3=$totDeviasi=$totRasio1=$totRasio2=$totRasio3=$totRasio4=0;
	
	$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
	$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
	$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=$stotAngThOp=0;
	$isSub=0;
	
	while ($rw=mysql_fetch_array($rs)){
		$i++;
		$clvl=$rw["MA_LEVEL"];
		$cislast=$rw["MA_ISLAST"];
		$ckode=explode(".",$rw["MA_KODE"]);
		$lblkodenew=$rw["MA_KODE_VIEW"]; //decyber
		$lblnama=$rw["MA_NAMA"];

		// var_dump($rw);
		
		if (($cislast==0) && ($isSub==1)){
			$isSub=0;
	
	?>
	


	<?php
			$subtotOp=$subtotOp2=$subtotOp3=$subtotAngThOp=$subtotAngOp=$subtotAngOp2=$subtotAngOp3=$lbltotDeviasi=$stotDeviasi=$lbltotRasio1=$stotRasio1=$lbltotRasio2=$stotRasio2=$lbltotRasio3=$stotRasio3=$lbltotRasio4=$stotRasio4=0;
		}
		
		if ($clvl==3){
			$lblkode=$ckode[1];
			$lblkodeJml=$ckode[1];
		}else{
			$lblkode="";
			$lblnama=$ckode[2].". ".$rw["MA_NAMA"];
		}
		$lblN=$lblN2=$lblN3=$nilaiAngTh=$nilaiAng=$nilaiAng2=$nilaiAngOp3=$Deviasi=$lblDeviasi=$Rasio1=$lblRasio1=$Rasio2=$lblRasio2=$Rasio3=$lblRasio3=$Rasio4=$lblRasio4="";
		
		if ($cislast==1){
			$isSub=1;
			
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
			UNION
			SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t";
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			
			$subtotOp +=$rw1["nilai"];
			$subtotOp2 +=$rw1["nilai2"];
			
			$subtotOp3 +=$rw1["nilai"]+$rw1["nilai2"];
			
			$stotOp+=$rw1["nilai"];
			$stotOp2+=$rw1["nilai2"];
			$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
			
			$lblN=number_format($rw1["nilai"],0,",",".");
			$lblN2=number_format($rw1["nilai2"],0,",",".");
			$lblN3=number_format(($rw1["nilai"]+$rw1["nilai2"]),0,",",".");
			
			 
		
				//tambahan
		$sql="SELECT
			   IFNULL(SUM(j.NILAI), 0) AS nilai
			 FROM anggaran j
			   INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
			 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
				 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
		$rsAngTh1=mysql_query($sql);
		$rwAngTh1=mysql_fetch_array($rsAngTh1);
	
		$stotAngThOp+=$rwAngTh1["nilai"];
		$subtotAngThOp+=$rwAngTh1["nilai"];
		$nilaiAngTh=number_format($rwAngTh1["nilai"],0,",",".");

		$sql="SELECT
				  SUM(t.nilai) AS nilai,
				  SUM(t.nilai2) AS nilai2
				FROM (SELECT
						IFNULL(SUM(j.NILAI), 0) AS nilai,
						'0' AS nilai2
					  FROM anggaran j
						INNER JOIN ma_sak ma
						  ON j.FK_MAID = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						  AND j.BULAN < $bulan_lr
						  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
					  UNION 
					  SELECT
					   '0'  AS nilai,
					   IFNULL(SUM(j.NILAI), 0) AS nilai2
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
						 AND j.BULAN = $bulan_lr
						 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
		$rsAng1=mysql_query($sql);
		$rwAng1=mysql_fetch_array($rsAng1);
		
		
		$stotAngOp+=$rwAng1["nilai"];
		$subtotAngOp+=$rwAng1["nilai"];
		
		$stotAngOp2+=$rwAng1["nilai2"];
		$subtotAngOp2+=$rwAng1["nilai2"];
		
		
		$stotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		$subtotAngOp3+=$rwAng1["nilai"]+$rwAng1["nilai2"];
		
		$nilaiAng=number_format($rwAng1["nilai"],0,",",".");
		$nilaiAng2=number_format($rwAng1["nilai2"],0,",",".");
		$nilaiAngOp3=number_format($rwAng1["nilai"]+$rwAng1["nilai2"],0,",",".");
		
		
		$Deviasi=($rw1["nilai"]+$rw1["nilai2"])-($rwAng1["nilai"]+$rwAng1["nilai2"]);
					
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$totDeviasi +=$Deviasi;
		
		
		$Rasio1=($nilaiAngOp3==0)?0:$Deviasi/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		
		$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
		$Rasio3=(($rwAng1["nilai"]+$rwAng1["nilai2"])==0)?0:($rw1["nilai"]+$rw1["nilai2"])/($rwAng1["nilai"]+$rwAng1["nilai2"]) * 100;
		$Rasio4=($rwAngTh1["nilai"]==0)?0:($rw1["nilai"]+$rw1["nilai2"])/$rwAngTh1["nilai"] * 100;
					
		

		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		$lbltotResio1 = ($stotRasio1<0)?"(".number_format(abs($stotRasio1),0,",",".").")":number_format($stotRasio1,0,",",".");
		$lbltotResio2 = ($stotRasio2<0)?"(".number_format(abs($stotRasio2),0,",",".").")":number_format($stotRasio2,0,",",".");
		$lbltotResio3 = ($stotRasio3<0)?"(".number_format(abs($stotRasio3),0,",",".").")":number_format($stotRasio3,0,",",".");
		$lbltotResio4 = ($stotRasio4<0)?"(".number_format(abs($stotRasio4),0,",",".").")":number_format($stotRasio4,0,",",".");
		$totRasio1 +=$Rasio1;
		$totRasio2 +=$Rasio2;
		$totRasio3 +=$Rasio3;
		$totRasio4 +=$Rasio4;
		
			
		}
	?>
	
	<tr>
	  <td align="center"><?php echo $lblkodenew; ?></td>
	  <td>&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td> 
	  <td align="right"><?php echo $nilaiAngTh; ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo $nilaiAng; ?></td>
	  <td align="right"><?php echo $nilaiAng2; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	  <td align="right"><?php echo $nilaiAngOp3; ?></td>
	   <td align="right"> <?php echo $lblN; ?></td>
	   <td align="right"> <?php echo $lblN2; ?></td>
	   <td align="right"><?php echo $lblN3; ?></td>
	   <td align="right"><?php echo $lblDeviasi; ?></td>
	   <td align="right"><?php echo $lblRasio1; ?></td>
	   <td align="right"><?php echo $lblRasio2; ?></td>
	   <td align="right"><?php echo $lblRasio3; ?></td>
	   <td align="right"><?php echo $lblRasio4; ?></td>
	</tr>
	<?php 
	}				
	?>

<!-- *decyber end_line 9.0 -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BOp=$rwB["MA_KODE_KP"];
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaUmum'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BUmum=$rwB["MA_KODE_KP"];
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKawaka'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BKaWaka=$rwB["MA_KODE_KP"];
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOUmum'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BPOUmum=$rwB["MA_KODE_KP"];
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKeu'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BPOKeu=$rwB["MA_KODE_KP"];
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOTeknik'";
	//echo $sql."<br>";
	$rsB=mysql_query($sql);
	$rwB=mysql_fetch_array($rsB);
	$kode_MA_BPOTeknik=$rwB["MA_KODE_KP"];
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$biayaUmum=$rw1["nilai"];
	$biayaUmum2=$rw1["nilai2"];
	$biayaUmum3=$biayaUmum+$biayaUmum2;
	
	
	
	//
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=$stotAngOp3=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
				
				$stotAngThBOTL_BPO=$stotAngBOTL_BPO=$stotAngBOTL_BPO2=$stotAngBOTL_BPO3=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
				$stotAngBOTL_BPO +=$rwAng1["nilai"];
				$stotAngBOTL_BPO2 +=$rwAng1["nilai2"];
				$stotAngBOTL_BPO3 +=$AngOp3;
					
				$Deviasi=$biayaUmum3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaUmum3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaUmum3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
                
	//
	
	
	
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$biayaBPOKaWaka=$rw1["nilai"];
	$biayaBPOKaWaka2=$rw1["nilai2"];
	$biayaBPOKaWaka3=$biayaBPOKaWaka+$biayaBPOKaWaka2;
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$biayaBPOUmum=$rw1["nilai"];
	$biayaBPOUmum2=$rw1["nilai2"];
	$biayaBPOUmum3=$biayaBPOUmum+$biayaBPOUmum2;
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$biayaBPOKeu=$rw1["nilai"];
	$biayaBPOKeu2=$rw1["nilai2"];
	$biayaBPOKeu3=$biayaBPOKeu+$biayaBPOKeu2;
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$biayaBPOTeknik=$rw1["nilai"];
	$biayaBPOTeknik2=$rw1["nilai2"];
	$biayaBPOTeknik3=$biayaBPOTeknik+$biayaBPOTeknik2;
	
	$stotBiayaOTL +=$biayaUmum;
	$stotBiayaOTL2 +=$biayaUmum2;
	$stotBiayaOTL3 +=$biayaUmum3;
	
	$stotBiayaPO=$biayaBPOKaWaka+$biayaBPOUmum+$biayaBPOKeu+$biayaBPOTeknik;
	$stotBiayaPO2=$biayaBPOKaWaka2+$biayaBPOUmum2+$biayaBPOKeu2+$biayaBPOTeknik2;
	$stotBiayaPO3=$stotBiayaPO+$stotBiayaPO2;
	
	$stotBOTL_BPO=$stotBiayaOTL+$stotBiayaPO;
	$stotBOTL_BPO2=$stotBiayaOTL2+$stotBiayaPO2;
	$stotBOTL_BPO3=$stotBOTL_BPO+$stotBOTL_BPO2;
	
	$totalBiayaOp=$stotBiayaOp+$stotBOTL_BPO;
	$totalBiayaOp2=$stotBiayaOp2+$stotBOTL_BPO2;
	$totalBiayaOp3=$totalBiayaOp+$totalBiayaOp2;
	
	$LB_Op=$stotOp-$totalBiayaOp;
	$LB_Op2=$stotOp2-$totalBiayaOp2;
	$LB_Op3=$LB_Op+$LB_Op2;
	
	$lblLB_Op=($LB_Op<0)?"(".number_format(abs($LB_Op),0,",",".").")":number_format($LB_Op,2,",",".");
	$lblLB_Op2=($LB_Op2<0)?"(".number_format(abs($LB_Op2),0,",",".").")":number_format($LB_Op2,2,",",".");
	$lblLB_Op3=($LB_Op3<0)?"(".number_format(abs($LB_Op3),0,",",".").")":number_format($LB_Op3,2,",",".");
	
	
	?>
	<!-- <tr>
	  <td align="center"><?php echo $kode_MA_BUmum; ?></td>
	  <td align="left">&nbsp;Biaya OTL</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kodeMaUmum' AND MA_KODE LIKE '$kodeMaUmum%' ORDER BY MA_KODE";
	$rsBOTL=mysql_query($sql);
	while ($rwBOTL=mysql_fetch_array($rsBOTL)){
		$ckode=$rwBOTL["MA_KODE"];
		$arckode=explode(".",$ckode);
		$cislast=$rwBOTL["MA_ISLAST"];
		
		$lblBOTL=$lblBOTL2=$lblBOTL3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$BOTL=$rw1["nilai"];
			$BOTL2=$rw1["nilai2"];
			$BOTL3=$BOTL+$BOTL2;
			
			$lblBOTL=number_format($BOTL,0,",",".");
			$lblBOTL2=number_format($BOTL2,0,",",".");
			$lblBOTL3=number_format($BOTL3,0,",",".");
		}
	?>
	<!-- <tr>
	  <td align="center"><?php echo $arckode[1]; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $rwBOTL["MA_NAMA"]; ?></td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right"><?php echo $lblBOTL; ?></td>
	   <td align="right"><?php echo $lblBOTL2; ?></td>
	   <td align="right"><?php echo $lblBOTL3; ?></td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   
	   
	   
	   
	</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	 
	  <td align="left">&nbsp;JUMLAH Biaya OTL :</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	   <td align="right"><?php echo number_format($biayaUmum,0,",","."); ?></td>
	   <td align="right"><?php echo number_format($biayaUmum2,0,",","."); ?></td>
	   <td align="right"><?php echo number_format($biayaUmum3,0,",","."); ?></td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	   <td align="right">&nbsp;</td>
	</tr> -->
	<!-- <tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr> -->
	
	    <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=$stotAngOp3=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
				$stotAngBOTL_BPO +=$rwAng1["nilai"];
				$stotAngBOTL_BPO2 +=$rwAng1["nilai2"];
				$stotAngBOTL_BPO3 +=$AngOp3;
					
				$Deviasi=$biayaBPOKaWaka3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOKaWaka2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOKaWaka3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOKaWaka3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
<!-- 	
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;Biaya Penunjang Operasi (BPO)</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr>
	<tr>
	  <td align="center"><?php echo $kode_MA_BKaWaka; ?></td>
	 
	  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Ka/Waka RS PHCM/td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kode_MA_BKaWaka' AND MA_KODE LIKE '$kode_MA_BKaWaka%' ORDER BY MA_KODE";
	// echo $sql;
	$rsBKaWaka=mysql_query($sql);
	while ($rwBKaWaka=mysql_fetch_array($rsBKaWaka)){
		$ckode=$rwBKaWaka["MA_KODE"];
		$ckodev=$rwBKaWaka["MA_KODE_VIEW"];//decyber
		$arckode=explode(".",$ckode);
		$cislast=$rwBKaWaka["MA_ISLAST"];
		
		$lblBKaWaka=$lblBKaWaka2=$lblBKaWaka3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$BKaWaka=$rw1["nilai"];
			$BKaWaka2=$rw1["nilai2"];
			$BKaWaka3=$BKaWaka+$BKaWaka2;
			
			$lblBKaWaka=number_format($BKaWaka,0,",",".");
			$lblBKaWaka2=number_format($BKaWaka2,0,",",".");
			$lblBKaWaka3=number_format($BKaWaka3,0,",",".");
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $ckodev; ?></td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwBKaWaka["MA_NAMA"]; ?></td>
		<td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblBKaWaka; ?></td>
		<td align="right"><?php echo $lblBKaWaka2; ?></td>
		<td align="right"><?php echo $lblBKaWaka3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;&nbsp;&nbsp;Jumlah Biaya Ka/Waka RS PHCM :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($biayaBPOKaWaka,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($biayaBPOKaWaka2,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($biayaBPOKaWaka3,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
	 <td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr>
	 -->
	
	<?php  		
			
	$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=$stotAngOp3=0 ;
	$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0 ;
		
	$sql="SELECT
		   IFNULL(SUM(j.NILAI), 0) AS nilai
		 FROM anggaran j
		   INNER JOIN ma_sak ma
			 ON j.FK_MAID = ma.MA_ID
		 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
			 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
	$rsAngTh1=mysql_query($sql);
	$rwAngTh1=mysql_fetch_array($rsAngTh1);
	$stotAngThOp+=$rwAngTh1["nilai"];
	
	$sql="SELECT
			  SUM(t.nilai) AS nilai,
			  SUM(t.nilai2) AS nilai2
			FROM (SELECT
					IFNULL(SUM(j.NILAI), 0) AS nilai,
					'0' AS nilai2
				  FROM anggaran j
					INNER JOIN ma_sak ma
					  ON j.FK_MAID = ma.MA_ID
				  WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
					  AND j.BULAN < $bulan_lr
					  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
				  UNION 
				  SELECT
				   '0'  AS nilai,
				   IFNULL(SUM(j.NILAI), 0) AS nilai2
				 FROM anggaran j
				   INNER JOIN ma_sak ma
					 ON j.FK_MAID = ma.MA_ID
				 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
					 AND j.BULAN = $bulan_lr
					 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
	$rsAng1=mysql_query($sql);
	$rwAng1=mysql_fetch_array($rsAng1);
	$stotAngOp +=$rwAng1["nilai"];
	$stotAngOp2 +=$rwAng1["nilai2"];
	$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
	$stotAngOp3 +=$AngOp3;
	
	$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
	$stotAngBOTL_BPO +=$rwAng1["nilai"];
	$stotAngBOTL_BPO2 +=$rwAng1["nilai2"];
	$stotAngBOTL_BPO3 +=$AngOp3;
		
	$Deviasi=$biayaBPOUmum3-$AngOp3;
	$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
	
	$stotDeviasi +=$Deviasi;
	$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
	
	$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
	$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOUmum2/$rwAng1["nilai2"] * 100;
	$Rasio3=($AngOp3==0)?0:$biayaBPOUmum3/$AngOp3 * 100;
	$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOUmum3/$rwAngTh1["nilai"] * 100;
	
	$stotRasio1 +=$Rasio1;
	$stotRasio2 +=$Rasio2;
	$stotRasio3 +=$Rasio3;
	$stotRasio4 +=$Rasio4;
	
	$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,2,",",".");
	$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,2,",",".");
	$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,2,",",".");
	$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,2,",",".");
	?>

	<!-- <tr>
	  <td align="center"><?php echo $kode_MA_BPOUmum; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Umum</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kode_MA_BPOUmum' AND MA_KODE LIKE '$kode_MA_BPOUmum%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	while ($rwB=mysql_fetch_array($rsB)){
		$ckode=$rwB["MA_KODE"];
		$ckodev=$rwB["MA_KODE_VIEW"];//decyber
		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<tr>
	  <!-- <td align="center"><?php echo $ckodev; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwB["MA_NAMA"]; ?></td>
	  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
	  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
	  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
		<td align="right"><?php echo $lblB2; ?></td>
		<td align="right"><?php echo $lblB3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lblstotRasio1; ?></td>
	  <td align="right"><?php echo $lblstotRasio2; ?></td>
	  <td align="right"><?php echo $lblstotRasio3; ?></td>
	  <td align="right"><?php echo $lblstotRasio4; ?></td> -->
	</tr>
	<?php 
	}
	?>
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="right">&nbsp;&nbsp;&nbsp;Jumlah Biaya Dinas Umum :&nbsp;&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOUmum,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOUmum2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOUmum3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr> -->
	
	 <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=$stotAngOp3 =0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
				$stotAngBOTL_BPO +=$rwAng1["nilai"];
				$stotAngBOTL_BPO2 +=$rwAng1["nilai2"];
				$stotAngBOTL_BPO3 +=$AngOp3;
					
				$Deviasi=$biayaBPOKeu3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOKeu2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOKeu3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOKeu3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
	?>
	<!-- <tr>
	  <td align="center"><?php echo $kode_MA_BPOKeu; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Keuangan</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td> 
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kode_MA_BPOKeu' AND MA_KODE LIKE '$kode_MA_BPOKeu%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	while ($rwB=mysql_fetch_array($rsB)){
		$ckode=$rwB["MA_KODE"];
		$ckodev=$rwB["MA_KODE_VIEW"];//decyber

		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $ckodev; ?></td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwB["MA_NAMA"]; ?></td>
		<td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
		<td align="right"><?php echo $lblB2; ?></td>
		<td align="right"><?php echo $lblB3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
		</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="right">&nbsp;&nbsp;&nbsp;Jumlah Biaya Dinas Keuangan :&nbsp;&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOKeu,0,",","."); ?></td> 
		<td align="right"><?php echo number_format($biayaBPOKeu2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOKeu3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr>
	 -->
	<?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=$stotAngOp3=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];
				$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngBOTL_BPO +=$rwAng1["nilai"];
				$stotAngBOTL_BPO2 +=$rwAng1["nilai2"];
				$stotAngBOTL_BPO3 +=$AngOp3;
					
				$Deviasi=$biayaBPOTeknik3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOTeknik2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOTeknik3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOTeknik3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
	
	<!-- <tr>
	  <td align="center"><?php echo $kode_MA_BPOTeknik; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Teknik</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>     
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	 <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kode_MA_BPOTeknik' AND MA_KODE LIKE '$kode_MA_BPOTeknik%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	while ($rwB=mysql_fetch_array($rsB)){
		$ckode=$rwB["MA_KODE"];
		$ckodev=$rwB["MA_KODE_VIEW"];//decyber

		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $ckodev; ?></td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwB["MA_NAMA"]; ?></td>
		<td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
		<td align="right"><?php echo $lblB2; ?></td>
		<td align="right"><?php echo $lblB3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="right">&nbsp;&nbsp;&nbsp;Jumlah Biaya Dinas Teknik :&nbsp;&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOTeknik,0,",","."); ?></td>     
		<td align="right"><?php echo number_format($biayaBPOTeknik2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($biayaBPOTeknik3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr> -->
	<?php 
	
		$stotDeviasi=0;
		
		$Deviasi=$stotBOTL_BPO3-$stotAngBOTL_BPO3;
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$Rasio1=($stotAngBOTL_BPO3==0)?0:$Deviasi/$stotAngBOTL_BPO3 * 100;
		$Rasio2=($stotAngBOTL_BPO2==0)?0:$biayaBPOTeknik2/$stotAngBOTL_BPO2 * 100;
		$Rasio3=($stotAngBOTL_BPO3==0)?0:$biayaBPOTeknik3/$stotAngBOTL_BPO3 * 100;
		$Rasio4=($stotAngThBOTL_BPO==0)?0:$biayaBPOTeknik3/$stotAngThBOTL_BPO * 100;
		
		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
	?>
	
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="left">&nbsp;JUMLAH (BOTL + BPO) : </td>
		<td align="right"><?php echo number_format($stotAngThBOTL_BPO,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngThBOTL_BPO,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngBOTL_BPO2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngBOTL_BPO3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngBOTL_BPO3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotBOTL_BPO,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotBOTL_BPO2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotBOTL_BPO3,0,",","."); ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr> -->
	<?php 
		$stotAngThOp=$stotAngThOp+$stotAngThBOTL_BPO;
		$stotAngOp=$stotAngOp+$stotAngBOTL_BPO;
		$stotAngOp2=$stotAngOp2+$stotAngBOTL_BPO2;
		$stotAngOp3=$stotAngOp3+$stotAngBOTL_BPO3;
		
		$AngThLB_Op=$stotAngThPOp-$stotAngThOp;
		$AngLB_Op=$stotAngPOp-$stotAngOp;
		$AngLB_Op2=$stotAngPOp2-$stotAngOp2;
		$AngLB_Op3=$stotAngPOp3-$stotAngOp3;
	?>
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="left">&nbsp;JUMLAH BIAYA OPERASI : </td>
		<td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($totalBiayaOp,0,",","."); ?></td>
		<td align="right"><?php echo number_format($totalBiayaOp2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($totalBiayaOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr> -->
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="left">&nbsp;LABA / RUGI OPERASI : </td>
		<td align="right"><?php echo number_format($AngThLB_Op,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($AngLB_Op,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngLB_Op2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngLB_Op3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngLB_Op3,0,",","."); ?></td>
		<td align="right"><?php echo $lblLB_Op; ?></td>
		<td align="right"><?php echo $lblLB_Op2; ?></td>
		<td align="right"><?php echo $lblLB_Op3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr> -->
	<!-- <tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>-->
	<?php  
	}elseif($jbeban=="1"){
	?>
	<!-- <tr>
	  <td align="center">III</td>
	  <td align="left" style="text-transform:uppercase;">&nbsp;Beban Usaha Menurut Jenis</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	<?php
		$stotbJneis=$stotbJneisb=$stotbJneisa=$stotAngThBJenis=$stotAngBJenis=$stotAngBJenis=$stotAngBJenis3=$stotDeviasi=$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
		
		
		$sql="SELECT * FROM ak_ms_beban_jenis WHERE aktif=1 ORDER BY kode";
		$rsBJenis=mysql_query($sql);
		$cstart=0;
		while ($rwBJenis=mysql_fetch_array($rsBJenis)){
		
			$cidbJenis=$rwBJenis["id"];
			$ckode=explode(".",$rwBJenis["kode"]);
			$clvl=$rwBJenis["level"];
			$lblnama=$rwBJenis["nama"];
			$cislast=$rwBJenis["islast"];
			
			$skode=$ckode[0];
			$lblkode=$ckode[0];
			
			$stotAngThBJenis=$stotAngBJenis=$stotAngBJenis2=$stotAngBJenis3=$stotDeviasi=0;
			$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
			
			$cnilaibJenis=$cnilaibJenisb=$cnilaibJenisa=0;
			$cnilaiAngThBJenis=$cnilaiAngBJenis=$cnilaiAngBJenis2=0;
			$AngBJenis3=0;
			
			$lblbJenis=$lblbJenisb=$lblbJenisa="";
			$lblAngThBJenis=$lblAngBJenis=$lblAngBJenis2="";
			
			$AngBJenis33="";
			
			$sql="SELECT
			IFNULL(SUM(j.NILAI), 0) AS nilai
			FROM anggaran j
			INNER JOIN ma_sak ma
			ON j.FK_MAID = ma.MA_ID
			WHERE ma.MA_KODE LIKE '".$lblkode."%'
			AND j.TAHUN = $ta_lr and j.flag = '$flag'";
			$rsAngTh1=mysql_query($sql);
			$rwAngTh1=mysql_fetch_array($rsAngTh1);
			$cnilaiAngThBJenis = $rwAngTh1["nilai"];
			$lblAngThBJenis=number_format($cnilaiAngThBJenis,0,",",".");
			$stotAngThBJenis+=$rwAngTh1["nilai"];
			
							
			if ($clvl==2){
				$skode=$ckode[1];
				$lblkode="";
				$lblnama=$skode.". ".$lblnama;
			}elseif($clvl==3){
				$skode=$ckode[2];
				$lblkode="";
				$lblnama="&nbsp;&nbsp;&nbsp;&nbsp;".$skode.". ".$lblnama;
			}
			
			
			
			
				$sql="SELECT
				SUM(t.nilai) AS nilai,
				SUM(t.nilai2) AS nilai2
				FROM (SELECT
				IFNULL(SUM(j.NILAI), 0) AS nilai,
				'0' AS nilai2
				FROM anggaran j
				INNER JOIN ma_sak ma
				  ON j.FK_MAID = ma.MA_ID
				WHERE ma.MA_KODE LIKE '".$lblkode."%'
				  AND j.BULAN < $bulan_lr
				  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
				UNION 
				SELECT
				'0'  AS nilai,
				IFNULL(SUM(j.NILAI), 0) AS nilai2
				FROM anggaran j
				INNER JOIN ma_sak ma
				 ON j.FK_MAID = ma.MA_ID
				WHERE ma.MA_KODE LIKE '".$lblkode."%'
				 AND j.BULAN = $bulan_lr
				 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngBJenis +=$rwAng1["nilai"];
				$stotAngBJenis2 +=$rwAng1["nilai2"];
				$AngBJenis3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngBJenis3 +=$AngBJenis3;
				
				$AngBJenis33 = number_format($AngBJenis3,0,",",".");
				
				
				$cnilaiAngBJenis = $rwAng1["nilai"];
				$cnilaiAngBJenis2 = $rwAng1["nilai2"];
				
				$lblAngBJenis=number_format($cnilaiAngBJenis,0,",",".");
				$lblAngBJenis2=number_format($cnilaiAngBJenis2,0,",",".");
				
				
				
				$cnilaibJenisb=$rwnilaibJenis["nilaib"];
				$cnilaibJenis=$rwnilaibJenis["nilai"];
				$cnilaibJenisa=$cnilaibJenisb+$cnilaibJenis;
			
			
			if ($cislast==1){
				$cstart=1;
				$sqlbJenis="SELECT *
							FROM ((SELECT
									 IFNULL(SUM(DEBIT),0) AS nilaib
								   FROM jurnal
								   WHERE MS_BEBAN_JENIS_ID = '$cidbJenis'
									   AND MONTH(TGL) < $bulan_lr
									   AND YEAR(TGL) = $ta_lr and j.flag = '$flag') AS nilaib,
							   (SELECT
								  IFNULL(SUM(DEBIT),0) AS nilai
								FROM jurnal
								WHERE MS_BEBAN_JENIS_ID = '$cidbJenis'
									AND MONTH(TGL) = $bulan_lr
									AND YEAR(TGL) = $ta_lr and j.flag = '$flag') AS nilai)";
				$rsnilaibJenis=mysql_query($sqlbJenis);
				$rwnilaibJenis=mysql_fetch_array($rsnilaibJenis);
				
				$cnilaibJenisb=$rwnilaibJenis["nilaib"];
				$cnilaibJenis=$rwnilaibJenis["nilai"];
				$cnilaibJenisa=$cnilaibJenisb+$cnilaibJenis;
				
				$stotbJneisb +=$cnilaibJenisb;
				$stotbJneis +=$cnilaibJenis;
				$stotbJneisa +=$cnilaibJenisa;
				
				$lblbJenis=number_format($cnilaibJenis,0,",",".");
				$lblbJenisb=number_format($cnilaibJenisb,0,",",".");
				$lblbJenisa=number_format($cnilaibJenisa,0,",",".");
				
				$Deviasi=$cnilaibJenisa-$AngBJenis3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngBJenis3==0)?0:$Deviasi/$AngBJenis3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$cnilaibJenis/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngBJenis3==0)?0:$cnilaibJenisa/$AngBJenis3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$cnilaibJenisa/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		
			}else{
				if ($cstart==1){
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="right">&nbsp;Jumlah&nbsp;&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngThBJenis,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngBJenis,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngBJenis2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngBJenis3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngBJenis3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotbJneisb,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotbJneis,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotbJneisa,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr> -->
	<?php
		}
		$stotbJneisb=$stotbJneis=$stotbJneisa=0;
		$stotAngBJenis=$stotAngThBJenis=$stotAngBJenis3=$stotDeviasi=$stotRasio1=$stotRasio12=$stotRasio3=$stotRasio4=0;
		$cstart=0;
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $lblkode; ?></td>
		<td align="left">&nbsp;<?php echo $lblnama; ?></td>
		<td align="right"><?php echo $lblAngThBJenis; ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo $lblAngBJenis; ?></td>
		<td align="right"><?php echo $lblAngBJenis2; ?></td>
		<td align="right"><?php echo $AngBJenis33; ?></td>
		<td align="right"><?php echo $AngBJenis33;; ?></td>
		<td align="right"><?php echo $lblbJenisb; ?></td>
		<td align="right"><?php echo $lblbJenis; ?></td>
		<td align="right"><?php echo $lblbJenisa; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblRasio1; ?></td>
		<td align="right"><?php echo $lblRasio2; ?></td>
		<td align="right"><?php echo $lblRasio3; ?></td>
		<td align="right"><?php echo $lblRasio4; ?></td>
	</tr> -->
	<?php
		}
	}	
	$kodePend_Dluar="791";
	$kodeBiaya_Dluar="891";
	$kodePos_Dluar="901";
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$Pend_DLuarUsaha=$rw1["nilai"];
	$Pend_DLuarUsaha2=$rw1["nilai2"];
	$Pend_DLuarUsaha3=$Pend_DLuarUsaha+$Pend_DLuarUsaha2;
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	
	
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$Biaya_DLuarUsaha=$rw1["nilai"];
	$Biaya_DLuarUsaha2=$rw1["nilai2"];
	$Biaya_DLuarUsaha3=$Biaya_DLuarUsaha+$Biaya_DLuarUsaha2;
	
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
		  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag'
		  UNION
		  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
		  WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$Pos_DLuarUsaha=$rw1["nilai"];
	$Pos_DLuarUsaha2=$rw1["nilai2"];
	$Pos_DLuarUsaha3=$Pos_DLuarUsaha+$Pos_DLuarUsaha2;
	
	$SelPendBiaya_DLuar = $Pend_DLuarUsaha - $Biaya_DLuarUsaha;
	$SelPendBiaya_DLuar2 = $Pend_DLuarUsaha2 - $Biaya_DLuarUsaha2;
	$SelPendBiaya_DLuar3 = $SelPendBiaya_DLuar + $SelPendBiaya_DLuar2;
	
	$LR_SblmPajak = $LB_Op + $SelPendBiaya_DLuar - $Pos_DLuarUsaha;
	$LR_SblmPajak2 = $LB_Op2 + $SelPendBiaya_DLuar2 - $Pos_DLuarUsaha2;
	$LR_SblmPajak3 = $LR_SblmPajak + $LR_SblmPajak2;
	
	$lblSelPendBiaya_DLuar=($SelPendBiaya_DLuar<0)?"(".number_format(abs($SelPendBiaya_DLuar),0,",",".").")":number_format($SelPendBiaya_DLuar,0,",",".");
	$lblSelPendBiaya_DLuar2=($SelPendBiaya_DLuar2<0)?"(".number_format(abs($SelPendBiaya_DLuar2),0,",",".").")":number_format($SelPendBiaya_DLuar2,0,",",".");
	$lblSelPendBiaya_DLuar3=($SelPendBiaya_DLuar3<0)?"(".number_format(abs($SelPendBiaya_DLuar3),0,",",".").")":number_format($SelPendBiaya_DLuar3,0,",",".");
	
	$lblLR_SblmPajak=($LR_SblmPajak<0)?"(".number_format(abs($LR_SblmPajak),0,",",".").")":number_format($LR_SblmPajak,0,",",".");
	$lblLR_SblmPajak2=($LR_SblmPajak2<0)?"(".number_format(abs($LR_SblmPajak2),0,",",".").")":number_format($LR_SblmPajak2,0,",",".");
	$lblLR_SblmPajak3=($LR_SblmPajak3<0)?"(".number_format(abs($LR_SblmPajak3),0,",",".").")":number_format($LR_SblmPajak3,0,",",".");
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;PENDAPATAN / BIAYA DILUAR USAHA</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	
	<?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotAngPend_DLuarUsaha=$stotAngPend_DLuarUsaha2=$stotAngPend_DLuarUsaha3=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];
				//$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
				$stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
				$stotAngPend_DLuarUsaha3 +=$AngOp3;
					
				$Deviasi=$Pend_DLuarUsaha3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Pend_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Pend_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Pend_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
	
	
	<!-- <tr>
	  <td align="center"><?php echo $kodePend_Dluar; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN DILUAR USAHA</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kodePend_Dluar' AND MA_KODE LIKE '$kodePend_Dluar%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	while ($rwB=mysql_fetch_array($rsB)){
		$ckode=$rwB["MA_KODE"];
		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $arckode[1]; ?></td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwB["MA_NAMA"]; ?></td>
		<td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
		<td align="right"><?php echo $lblB2; ?></td>
		<td align="right"><?php echo $lblB3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
		</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;&nbsp;&nbsp;JUMLAH PENDAPATAN DILUAR USAHA :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pend_DLuarUsaha,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pend_DLuarUsaha2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pend_DLuarUsaha3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>

	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	 -->
	  <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotAngPend_DLuarUsaha=$stotAngPend_DLuarUsaha2=$stotAngPend_DLuarUsaha3=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];
				//$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
				$stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
				$stotAngPend_DLuarUsaha3 +=$AngOp3;
					
				$Deviasi=$Pend_DLuarUsaha3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Pend_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Pend_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Pend_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
                <!-- <tr>
                  <td align="center"><?php echo $kodePend_Dluar; ?></td>
                  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha,0,",","."); ?></td>
				  <td align="right"><?php echo number_format($Pend_DLuarUsaha2,0,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha3,0,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr> -->
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];
				//$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
					
				$Deviasi=$Biaya_DLuarUsaha3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Biaya_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Biaya_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Biaya_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
	
	<!-- <tr>
	  <td align="center"><?php echo $kodeBiaya_Dluar; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;BIAYA DILUAR USAHA</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kodeBiaya_Dluar' AND MA_KODE LIKE '$kodeBiaya_Dluar%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	while ($rwB=mysql_fetch_array($rsB)){
		$ckode=$rwB["MA_KODE"];
		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<!-- <tr>
		<td align="center"><?php echo $arckode[1]; ?></td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwB["MA_NAMA"]; ?></td>
		<td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
		<td align="right"><?php echo $lblB2; ?></td>
		<td align="right"><?php echo $lblB3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
		</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;&nbsp;&nbsp;JUMLAH BIAYA DILUAR USAHA :&nbsp;&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Biaya_DLuarUsaha,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Biaya_DLuarUsaha2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Biaya_DLuarUsaha3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr> -->
	
	
	   <?php 
		$SelAngThPendBiaya_DLuar=$SelAngThPendBiaya_DLuar-$AngThBiaya_DLuarUsaha;
		$SelAngPendBiaya_DLuar=$SelAngPendBiaya_DLuar-$Biaya_DLuarUsaha;
		$SelAngPendBiaya_DLuar2=$SelAngPendBiaya_DLuar2-$Biaya_DLuarUsaha2;
		$SelAngPendBiaya_DLuar3=$SelAngPendBiaya_DLuar3-$Biaya_DLuarUsaha3;

		$SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha;
		$SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2;
		$SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3;
			
		$Deviasi=$SelPendBiaya_DLuar3-$SelAngPendBiaya_DLuar3;
		$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
		
		$stotDeviasi +=$Deviasi;
		$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
		
		$Rasio1=($Biaya_DLuarUsaha3==0)?0:$Deviasi/$Biaya_DLuarUsaha3 * 100;
		$Rasio2=($SelAngPendBiaya_DLuar2==0)?0:$SelPendBiaya_DLuar2/$SelAngPendBiaya_DLuar2 * 100;
		$Rasio3=($SelAngPendBiaya_DLuar3==0)?0:$SelPendBiaya_DLuar3/$SelAngPendBiaya_DLuar3 * 100;
		$Rasio4=($SelAngThPendBiaya_DLuar==0)?0:$SelPendBiaya_DLuar3/$SelAngThPendBiaya_DLuar * 100;
		
		$stotRasio1 +=$Rasio1;
		$stotRasio2 +=$Rasio2;
		$stotRasio3 +=$Rasio3;
		$stotRasio4 +=$Rasio4;
		
		$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
		$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
		$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
		$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
		?>
	
	
	
	<!-- <tr>
		<td align="center">&nbsp;</td>
		<td align="left">&nbsp;SELISIH PEND / BIAYA DILUAR USAHA : </td>
		<td align="right"><?php echo number_format($SelAngThPendBiaya_DLuar,0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($SelAngPendBiaya_DLuar,0,",","."); ?></td>
		<td align="right"><?php echo number_format($SelAngPendBiaya_DLuar2,0,",","."); ?></td>
		<td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,0,",","."); ?></td>
		<td align="right"><?php echo $lblSelPendBiaya_DLuar; ?></td>
		<td align="right"><?php echo $lblSelPendBiaya_DLuar2; ?></td>
		<td align="right"><?php echo $lblSelPendBiaya_DLuar3; ?></td>
		<td align="right"><?php echo $lbltotDeviasi; ?></td>
		<td align="right"><?php echo $lblstotRasio1; ?></td>
		<td align="right"><?php echo $lblstotRasio2; ?></td>
		<td align="right"><?php echo $lblstotRasio3; ?></td>
		<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	 -->
	 <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
						 AND j.TAHUN = $ta_lr and j.flag = '$flag'";
				$rsAngTh1=mysql_query($sql);
				$rwAngTh1=mysql_fetch_array($rsAngTh1);
				$stotAngThOp+=$rwAngTh1["nilai"];
				$stotAngThBOTL_BPO +=$rwAngTh1["nilai"];
				$AngThPos_DLuarUsaha=$rwAngTh1["nilai"];

				$sql="SELECT
						  SUM(t.nilai) AS nilai,
						  SUM(t.nilai2) AS nilai2
						FROM (SELECT
								IFNULL(SUM(j.NILAI), 0) AS nilai,
								'0' AS nilai2
							  FROM anggaran j
								INNER JOIN ma_sak ma
								  ON j.FK_MAID = ma.MA_ID
							  WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
								  AND j.BULAN < $bulan_lr
								  AND j.TAHUN = $ta_lr and j.flag = '$flag' 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr and j.flag = '$flag') t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
				
				$AngPos_DLuarUsaha=$rwAng1["nilai"];
				$AngPos_DLuarUsaha2=$rwAng1["nilai2"];
				$AngPos_DLuarUsaha3=$AngPos_DLuarUsaha+$AngPos_DLuarUsaha2;
				
				$stotAngPend_DLuarUsaha +=$rwAng1["nilai"];
				$stotAngPend_DLuarUsaha2 +=$rwAng1["nilai2"];
				$stotAngPend_DLuarUsaha3 +=$AngOp3;
					
				$Deviasi=$Pos_DLuarUsaha3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Pos_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Pos_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Pos_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
	
	<!-- <tr>
	  <td align="center"><?php echo $kodePos_Dluar; ?></td>
	  <td align="left">&nbsp;POS-POS DILUAR USAHA</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	</tr> -->
	<?php 
	$sql="SELECT * FROM ma_sak WHERE MA_KODE<>'$kodePos_Dluar' AND MA_KODE LIKE '$kodePos_Dluar%' ORDER BY MA_KODE";
	$rsB=mysql_query($sql);
	$treelvl=0;
	$j=0;
	while ($rwB=mysql_fetch_array($rsB)){
		$j++;
		$ckode=$rwB["MA_KODE"];
		$arckode=explode(".",$ckode);
		$cislast=$rwB["MA_ISLAST"];
		$clvl=$rwB["MA_LEVEL"];
		
		if ($j==1) $treelvl=$clvl;
		
		$lblkode="";
		$lblnama=$rwB["MA_NAMA"];
		if ($treelvl==$clvl){
			$lblkode=$arckode[1];
		}else{
			$lblnama=$arckode[$clvl-1].". ".$rwB["MA_NAMA"];
		}
		
		$lblB=$lblB2=$lblB3="";
		
		if ($cislast==1){
			$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag' UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$ckode%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr and j.flag = '$flag') t ";
			
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$B=$rw1["nilai"];
			$B2=$rw1["nilai2"];
			$B3=$B+$B2;
			
			$lblB=number_format($B,0,",",".");
			$lblB2=number_format($B2,0,",",".");
			$lblB3=number_format($B3,0,",",".");
		}
	?>
	<!-- <tr>
	  <td align="center"><?php echo $lblkode; ?></td>
	  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lblnama; ?></td>
	  <td align="right"><?php echo number_format($rwAngTh1["nilai"],0,",","."); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right"><?php echo number_format($rwAng1["nilai"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($rwAng1["nilai2"],0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo number_format($AngOp3,0,",","."); ?></td>
		<td align="right"><?php echo $lblB; ?></td>
	   <td align="right"><?php echo $lblB2; ?></td>
	   <td align="right"><?php echo $lblB3; ?></td>
	    <td align="right"><?php echo $lbltotDeviasi; ?></td>
	  <td align="right"><?php echo $lblstotRasio1; ?></td>
	  <td align="right"><?php echo $lblstotRasio2; ?></td>
	  <td align="right"><?php echo $lblstotRasio3; ?></td>
	  <td align="right"><?php echo $lblstotRasio4; ?></td>
</tr> -->
	<?php 
	}
	?>
	<!-- <tr>
	  <td align="center">&nbsp;</td>
	  <td align="left">&nbsp;JUMLAH POS-POS DILUAR USAHA :&nbsp;&nbsp;</td>
	 <td align="right"><?php echo number_format($stotAngThOp,0,",","."); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo number_format($stotAngOp,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotAngOp3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pos_DLuarUsaha,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pos_DLuarUsaha2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($Pos_DLuarUsaha3,0,",","."); ?></td>
	   <td align="right"><?php echo number_format($stotDeviasi,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio1,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio2,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio3,0,",","."); ?></td>
	  <td align="right"><?php echo number_format($stotRasio4,0,",","."); ?></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr> -->
	
	     <?php 
				$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
				
				$AngThLB_SblmPajak=$AngThLB_Op+$SelAngThPendBiaya_DLuar-$AngThPos_DLuarUsaha;
				$AngLB_SblmPajak=$AngLB_Op+$SelAngThPendBiaya_DLuar-$AngPos_DLuarUsaha;
				$AngLB_SblmPajak2=$AngLB_Op2+$SelAngThPendBiaya_DLuar2-$AngPos_DLuarUsaha2;
				$AngLB_SblmPajak3=$AngLB_Op3+$SelAngThPendBiaya_DLuar3-$AngPos_DLuarUsaha3;
				
				
				$Deviasi=$LR_SblmPajak3-$AngLB_SblmPajak3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),0,",",".").")":number_format($Deviasi,0,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),0,",",".").")":number_format($stotDeviasi,0,",",".");
				
				$Rasio1=($AngLB_SblmPajak3==0)?0:$Deviasi/$AngLB_SblmPajak3 * 100;
				$Rasio2=($AngLB_Op2==0)?0:$Pos_DLuarUsaha2/$AngLB_Op2 * 100;
				$Rasio3=($AngLB_SblmPajak3==0)?0:$LR_SblmPajak3/$AngLB_SblmPajak3 * 100;
				$Rasio4=($AngThLB_Op==0)?0:$LR_SblmPajak3/$AngThLB_Op * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),0,",",".").")":number_format($Rasio1,0,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),0,",",".").")":number_format($Rasio2,0,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),0,",",".").")":number_format($Rasio3,0,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),0,",",".").")":number_format($Rasio4,0,",",".");
				?>
	
	
	<!-- <tr>
			<td align="center">&nbsp;</td>
			<td align="left">&nbsp;LABA / RUGI SEBELUM PAJAK : </td>

			<td align="right"><?php echo number_format($AngThLB_SblmPajak,0,",","."); ?></td>
			<td align="right">&nbsp;</td>
			<td align="right"><?php echo number_format($AngLB_SblmPajak,0,",","."); ?></td>
			<td align="right"><?php echo number_format($AngLB_SblmPajak2,0,",","."); ?></td>
			<td align="right"><?php echo number_format($AngLB_SblmPajak3,0,",","."); ?></td>
			<td align="right"><?php echo number_format($AngLB_SblmPajak3,0,",","."); ?></td>
			<td align="right"><?php echo $lblLR_SblmPajak; ?></td>
			<td align="right"><?php echo $lblLR_SblmPajak2; ?></td>
			<td align="right"><?php echo $lblLR_SblmPajak3; ?></td>
			<td align="right"><?php echo $lbltotDeviasi; ?></td>
			<td align="right"><?php echo $lblstotRasio1; ?></td>
			<td align="right"><?php echo $lblstotRasio2; ?></td>
			<td align="right"><?php echo $lblstotRasio3; ?></td>
			<td align="right"><?php echo $lblstotRasio4; ?></td>
	</tr> -->
  </table>
</div>
		<?php 
		if($_REQUEST['excel']!='excel'){
		?>		
					<p id="p_print" align="center"><button type="button" onclick="document.getElementById('p_print').style.display='none';window.print();window.close();"><img src="../icon/printer.png" height="16" width="16" border="0" align="absmiddle" />&nbsp; Cetak</button><button type="button" onclick="window.close();">Keluar</button>
		<? } ?>
</body>
</html>
<?php 
mysql_close($konek);
?>
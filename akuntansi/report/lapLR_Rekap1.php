<?php 
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
$bulan_lr=explode("|",$bulan_l);
$bulan_lr=$bulan_lr[0];
$nama_bulan=$bulan_lr[1];
if ($bulan_lr==""){
	$bulan_lr=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$a=1;
// end laba rugi

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Transaksi Jurnal</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>

<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<div align="center">
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
  	<input name="idma" id="idma" type="hidden" value="">
  	<input name="parent_lvl" id="parent_lvl" type="hidden" value="">
  	<input name="ccrvpbfumum" id="ccrvpbfumum" type="hidden" value="">
  	<input name="idccrvpbfumum" id="idccrvpbfumum" type="hidden" value="">
  	<input name="cc_islast" id="cc_islast" type="hidden" value="">
  	<input name="islast" id="islast" type="hidden" value="1">
    <input name="all_unit" id="all_unit" type="hidden" value="0">
	<input name="tgl2" id="tgl2" type="hidden" value="0">
<div id="input" style="display:block">
	<?php 
		$sak_sap=$_REQUEST["sak_sap"];
		if ($sak_sap=="") $sak_sap="1";
		if ($sak_sap=="1"){
			$jdl_lap="Laporan Rekapitulasi Laba/Rugi";
			$tbl_lap="lap_arus_kas";
		}else{
			$jdl_lap="Laporan Rekapitulasi Laba/Rugi";
			$tbl_lap="lap_lak_sap";
			
		}
		
		$jbeban=$_REQUEST["jbeban"];
		
		$tipe=$_REQUEST["tipe"];
		$ma_kode=$_REQUEST["ma_kode"];
	?>
      	<?php 
			if ($tipe=="detail"){
				$lnk="'../report/operasional_excell_detail.php?sak_sap=".$sak_sap."&tipe=detail&ma_kode=$ma_kode&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value";
			
				$tampilback=1;
				$sql="SELECT * FROM ma_sak WHERE MA_KODE='$ma_kode'";
				//echo $sql."<br>";
				$rsMa=mysql_query($sql);
				$rwMa=mysql_fetch_array($rsMa);
				$clvl=$rwMa["MA_LEVEL"]+1;
	  	?>
      		<p class="jdltable">Laporan Laba/Rugi : <?php echo $rwMa["MA_NAMA"]; ?></p>
          	<table width="500" border="0" cellspacing="0" cellpadding="0" class="txtinput">
			<tr>
              <td colspan="3" align="center">Bulan :
                <select name="bulan_lr" id="bulan_lr">
                <option value="1|Januari"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                              </select>&nbsp;&nbsp;
			  
			  <select name="ta_lr" id="ta_lr">
                <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
                <option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
                <?php }?>
                </select>
&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
              </tr>
            <tr style="display:none"> 
              <td width="60">Periode</td>
              <td width="12">:</td>
              <td valign="middle"> 
                <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                &nbsp;&nbsp;s/d&nbsp;&nbsp;
                <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                Lihat</button> 
              </td>
            </tr>
          	</table><br />
              <table width="980" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                <tr>
                  <td width="50" align="center">No</td>
                  <td align="center">Uraian</td>
                  <td width="140" align="center"><?php if($bulan_lr < 3){ echo '01'."-".$ta_lr; }else{ echo '01'."-".$ta_lr." s/d ".((($bulan_lr-1)<10)?"0".($bulan_lr-1):($bulan_lr-1))."-".$ta_lr ;} ?></td>
				  <td width="140" align="center"><?php echo (($bulan_lr<10)?"0".$bulan_lr:$bulan_lr)."-".$ta_lr;?></td>
                  <td width="140" align="center"><?php if($bulan_lr < 3){ echo '01'."-".$ta_lr; }else{ echo '01'."-".$ta_lr." s/d ".(($bulan_lr<10)?"0".$bulan_lr:$bulan_lr)."-".$ta_lr ;} ?></td>
                </tr>
                <?php 
					$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=$clvl AND MA_KODE like '$ma_kode%'";
					$rsMa=mysql_query($sql);
					$j=1;
					$stot=$stot2=$stot3=0;
					while ($rwMa=mysql_fetch_array($rsMa)){
					
					$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
						
						$rsNilai=mysql_query($sql);
						$rwNilai=mysql_fetch_array($rsNilai);
						$stot+=$rwNilai["nilai"];
						$stot2+=$rwNilai["nilai2"];
				?>
                <tr>
                  <td align="center"><?php echo $rwMa["MA_KODE"]; ?></td>
				  
                  <?php 
				  		if (($rwNilai["nilai"]>0) && ($rwMa["MA_ISLAST"]==0)){
				  ?>
                  <td align="left">&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rwMa["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail"><?php echo $rwMa["MA_NAMA"]; ?></a></td>
                  <?php 
				  		}else{
				  ?>
                  <td align="left">&nbsp;<?php echo $rwMa["MA_NAMA"]; ?></td>
                  <?php 
				  	}
				  ?>
                  <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai"],2,",","."); ?></td>
				  <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai2"],2,",","."); ?></td>
                  <td align="right">&nbsp;<?php echo number_format($rwNilai["nilai"]+$rwNilai["nilai2"],2,",","."); ?></td>
                </tr>
                <?php 
					}
					$stot3=$stot+$stot2;
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;Subtotal :</td>
                  <td align="right">&nbsp;<?php echo number_format($stot,2,",","."); ?></td>
				  <td align="right">&nbsp;<?php echo number_format($stot2,2,",","."); ?></td>
                  <td align="right">&nbsp;<?php echo number_format($stot3,2,",","."); ?></td>
                </tr>
              </table>
      	<?php 
			}else{
				$lnk="'../report/operasional_excell.php?sak_sap=".$sak_sap."&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value";
	  	?>
	  		<p class="jdltable">Laporan Rekapitulasi Laba/Rugi</p>
          	<table width="599" border="0" cellspacing="0" cellpadding="0" class="txtinput">
            <tr>
              <td colspan="3" align="center">Jenis Beban :
                <select name="jbeban" id="jbeban">
                <option value="0"<?php if ($jbeban=="0") echo " selected";?>>Menurut Pusat Pelayanan</option>
                <option value="1"<?php if ($jbeban=="1") echo " selected";?>>Menurut Jenis</option>
                </select>&nbsp;&nbsp;
              </td>
            </tr>
            <tr>
              <td colspan="3" align="center">Bulan :
                <select name="bulan_lr" id="bulan_lr">
                <option value="1|Januari"<?php if ($bulan_lr=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan_lr=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan_lr=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan_lr=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan_lr=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan_lr=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan_lr=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan_lr=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan_lr=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan_lr=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan_lr=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan_lr=="12") echo " selected";?>>Desember</option>
                              </select>&nbsp;&nbsp;
			  
			  <select name="ta_lr" id="ta_lr">
                <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
                <option value="<?php echo $i; ?>"<?php if ($i==$ta_lr) echo " selected";?>><?php echo $i; ?></option>
                <?php }?>
                            </select>
&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
              </tr>
            <tr style="display:none">
              <td width="112">Periode</td>
              <td width="22">:</td>
              <td width="366" valign="middle"> 
                <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /> 
                <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
                &nbsp;&nbsp;s/d&nbsp;&nbsp;
                <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /> 
                <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&bulan_lr='+bulan_lr.value+'&ta_lr='+ta_lr.value+'&jbeban='+jbeban.value"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
                Lihat</button> </td>
            </tr>
          	</table>
          	<br />
          	<div style="width:970px;overflow:scroll;">
              <table width="2000" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
                <tr>
                  <td rowspan="3" align="center">No</td>
                  <td rowspan="3" align="center">Uraian</td>
                  <td colspan="6" align="center">ANGGARAN</td>
                  <td colspan="3" align="center">REALISASI</td>
                  <td rowspan="3" align="center">DEVIASI (11-8)</td>
                  <td colspan="4" align="center">RASIO</td>
                </tr>
                
                <tr>
                  <td rowspan="2" align="center">TAHUN <?php echo $ta_lr; ?></td>
                  <td rowspan="2" align="center">S/D TRIWULAN LALU</td>
                  <td colspan="3" align="center">TRIWULAN BERJALAN</td>
                  <td rowspan="2" align="center">S/D TRIWULAN INI</td>
                  <td colspan="3" align="center">TRIWULAN BERJALAN</td>
                  <td rowspan="2" align="center">12/8</td>
                  <td rowspan="2" align="center">10/6</td>
                  <td rowspan="2" align="center">11/8</td>
                  <td rowspan="2" align="center">11/3</td>
                </tr>
                
                <tr>
                  <td align="center">S/D BULAN LALU</td>
                  <td align="center">BULAN INI</td>
                  <td align="center">S/D BULAN INI</td>
                  <td align="center">S/D BULAN LALU</td>
				  <td align="center">BULAN INI</td>
                  <td align="center">S/D BULAN INI</td>
                </tr>
                <tr>
                  <td width="60" align="center">1</td>
                  <td width="250" align="center">2</td>
                  <td width="120" align="center">3</td>
                  <td width="120" align="center">4</td>
                  <td width="120" align="center">5</td>
                  <td width="120" align="center">6</td>
                  <td width="120" align="center">7</td>
                  <td width="120" align="center">8</td>
                  <td width="120" align="center">9</td>
                  <td width="120" align="center">10</td>
                  <td width="120" align="center">11</td>
                  <td width="120" align="center">12</td>
                  <td width="120" align="center">13</td>
                  <td width="120" align="center">14</td>
                  <td width="120" align="center">15</td>
                  <td width="120" align="center">16</td>
                </tr>
                <tr>
                  <td align="center">710</td>
                  <td align="left">&nbsp;Pendapatan Pelayanan RSPM</td>
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
                $sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '710%'";
				//echo $sql."<br>";
                $rs=mysql_query($sql);
                $i=0;
                $stotOp=$stotOp2=$stotOp3=0;
                $stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
				$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
				$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=0;
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
                while ($rw=mysql_fetch_array($rs)){
                    $i++;
                    $sql="SELECT
						   IFNULL(SUM(j.NILAI), 0) AS nilai
						 FROM anggaran j
						   INNER JOIN ma_sak ma
							 ON j.FK_MAID = ma.MA_ID
						 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
							 AND j.TAHUN = $ta_lr";
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
								  WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
									  AND j.BULAN < $bulan_lr
									  AND j.TAHUN = $ta_lr 
								  UNION 
								  SELECT
								   '0'  AS nilai,
								   IFNULL(SUM(j.NILAI), 0) AS nilai2
								 FROM anggaran j
								   INNER JOIN ma_sak ma
									 ON j.FK_MAID = ma.MA_ID
								 WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%'
									 AND j.BULAN = $bulan_lr
									 AND j.TAHUN = $ta_lr) t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
					$stotAngOp2 +=$rwAng1["nilai2"];
					$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
					$stotAngOp3 +=$AngOp3;

                    $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					UNION
					SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
                    $rs1=mysql_query($sql);
                    $rw1=mysql_fetch_array($rs1);
                    $stotOp+=$rw1["nilai"];
					$stotOp2+=$rw1["nilai2"];
					$Op3=$rw1["nilai"]+$rw1["nilai2"];
					//$stotOp3+=$rw1["nilai"]+$rw1["nilai2"];
					$Deviasi=$Op3-$AngOp3;
					$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
					
					$stotDeviasi +=$Deviasi;
					$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
					
					$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
					$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
					$Rasio3=($AngOp3==0)?0:$Op3/$AngOp3 * 100;
					$Rasio4=($rwAngTh1["nilai"]==0)?0:$Op3/$rwAngTh1["nilai"] * 100;
					
					$stotRasio1 +=$Rasio1;
					$stotRasio2 +=$Rasio2;
					$stotRasio3 +=$Rasio3;
					$stotRasio4 +=$Rasio4;
					
					$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
					$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
					$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
					$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
                ?>
                <tr>
                  <td align="center"><?php echo $rw["MA_KODE"]; ?></td>
				   <?php 
                  /*if ( (($rw1["nilai"]>0) && ($rw["MA_ISLAST"]==0)) or (($rw1["nilai2"]>0) && ($rw["MA_ISLAST"]==0)) ){
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $rw["MA_KODE"]; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $rw["MA_NAMA"]; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td>&nbsp;&nbsp;&nbsp;<?php echo $rw["MA_NAMA"]; ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
				   <td align="right"> <?php echo number_format($rw1["nilai"],2,",","."); ?></td>
				   <td align="right"> <?php echo number_format($rw1["nilai2"],2,",","."); ?></td>
				   <td align="right"><?php echo number_format($Op3,2,",","."); ?></td>
				   <td align="right"><?php echo $lblDeviasi; ?></td>
				   <td align="right"><?php echo $lblRasio1; ?></td>
				   <td align="right"><?php echo $lblRasio2; ?></td>
				   <td align="right"><?php echo $lblRasio3; ?></td>
				   <td align="right"><?php echo $lblRasio4; ?></td>
                </tr>
                <?php 
                }
				
				$stotOp3=$stotOp+$stotOp2;
				
				$stotRasio2=$stotRasio2/$i;
				$stotRasio3=$stotRasio3/$i;
				$stotRasio4=$stotRasio4/$i;
				
				$lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),2,",",".").")":number_format($stotRasio1,2,",",".");
				$lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),2,",",".").")":number_format($stotRasio2,2,",",".");
				$lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),2,",",".").")":number_format($stotRasio3,2,",",".");
				$lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),2,",",".").")":number_format($stotRasio4,2,",",".");
				
				$stotAngThPOp=$stotAngThOp;
				$stotAngPOp=$stotAngOp;
				$stotAngPOp2=$stotAngOp2;
				$stotAngPOp3=$stotAngOp3;
                ?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH : </td>
                  <td align="right"><?php echo number_format($stotAngThOp,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($stotOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotOp3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
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
				$kodeMaOp="810";
                $sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				$rwB=mysql_fetch_array($rsB);
				$cma_id=$rwB["MA_ID"];
				?>
                <tr>
                  <td align="center"><?php echo $kodeMaOp; ?></td>
                  <td align="left">&nbsp;Biaya Pelayanan RSPM</td>
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
				$kodeMaUmum="826";
				$kodeMaBPOKawaka="831";
				$kodeMaBPOUmum="832";
				$kodeMaBPOKeu="833";
				$kodeMaBPOTeknik="834";
				
				$i=0;
                $sql="SELECT * FROM ma_sak WHERE MA_PARENT = '$cma_id' ORDER BY MA_KODE";
				//echo $sql."<br>";
                $rsB=mysql_query($sql);
				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
				while ($rwB=mysql_fetch_array($rsB)){
					$i++;
					$kode_MA_BPO=$rwB["MA_KODE"];
					$kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
					$nama_MA_BPO=$rwB["MA_NAMA"];
					
                    $sql="SELECT
						   IFNULL(SUM(j.NILAI), 0) AS nilai
						 FROM anggaran j
						   INNER JOIN ma_sak ma
							 ON j.FK_MAID = ma.MA_ID
						 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
							 AND j.TAHUN = $ta_lr";
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
								  WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
									  AND j.BULAN < $bulan_lr
									  AND j.TAHUN = $ta_lr 
								  UNION 
								  SELECT
								   '0'  AS nilai,
								   IFNULL(SUM(j.NILAI), 0) AS nilai2
								 FROM anggaran j
								   INNER JOIN ma_sak ma
									 ON j.FK_MAID = ma.MA_ID
								 WHERE ma.MA_KODE LIKE '".$rwB["MA_KODE"]."%'
									 AND j.BULAN = $bulan_lr
									 AND j.TAHUN = $ta_lr) t";
                    $rsAng1=mysql_query($sql);
                    $rwAng1=mysql_fetch_array($rsAng1);
                    $stotAngOp +=$rwAng1["nilai"];
					$stotAngOp2 +=$rwAng1["nilai2"];
					$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
					$stotAngOp3 +=$AngOp3;
					
					$sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
					
					
					$rsBPOSub=mysql_query($sqlBPOSub);
					$rwBPOSub=mysql_fetch_array($rsBPOSub);
					$biayaBPO=$rwBPOSub["nilai"];
					$biayaBPO2=$rwBPOSub["nilai2"];
					$biayaBPO3=$biayaBPO+$biayaBPO2;
					
					$stotBiayaOp +=$biayaBPO;
					$stotBiayaOp2 +=$biayaBPO2;
					
					$Deviasi=$biayaBPO3-$AngOp3;
					$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
					
					$stotDeviasi +=$Deviasi;
					$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
					
					$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
					$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
					$Rasio3=($AngOp3==0)?0:$biayaBPO3/$AngOp3 * 100;
					$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPO3/$rwAngTh1["nilai"] * 100;
					
					$stotRasio1 +=$Rasio1;
					$stotRasio2 +=$Rasio2;
					$stotRasio3 +=$Rasio3;
					$stotRasio4 +=$Rasio4;
					
					$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
					$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
					$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
					$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kode_MA_BPO; ?></td>
				   <?php 
                  /*if ($biayaBPO>0 || $biayaBPO2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kode_MA_BPO; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>"><?php echo $nama_MA_BPO; ?></a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp<?php echo $nama_MA_BPO; ?></td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPO3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
				}
				$stotBiayaOp3=$stotBiayaOp+$stotBiayaOp2;
				
				$stotRasio2=$stotRasio2/$i;
				$stotRasio3=$stotRasio3/$i;
				$stotRasio4=$stotRasio4/$i;
				
				$lblstotRasio1=($stotRasio1<0)?"(".number_format(abs($stotRasio1),2,",",".").")":number_format($stotRasio1,2,",",".");
				$lblstotRasio2=($stotRasio2<0)?"(".number_format(abs($stotRasio2),2,",",".").")":number_format($stotRasio2,2,",",".");
				$lblstotRasio3=($stotRasio3<0)?"(".number_format(abs($stotRasio3),2,",",".").")":number_format($stotRasio3,2,",",".");
				$lblstotRasio4=($stotRasio4<0)?"(".number_format(abs($stotRasio4),2,",",".").")":number_format($stotRasio4,2,",",".");
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH : </td>
                  <td align="right"><?php echo number_format($stotAngThOp,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($stotBiayaOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBiayaOp3,2,",","."); ?></td>
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
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
				
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaUmum=$rw1["nilai"];
				$biayaUmum2=$rw1["nilai2"];
				$biayaUmum3=$biayaUmum+$biayaUmum2;
				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
				
				$stotAngThBOTL_BPO=$stotAngBOTL_BPO=$stotAngBOTL_BPO2=$stotAngBOTL_BPO3=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$rw1["nilai2"]/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaUmum3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaUmum3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOKaWaka=$rw1["nilai"];
				$biayaBPOKaWaka2=$rw1["nilai2"];
				$biayaBPOKaWaka3=$biayaBPOKaWaka+$biayaBPOKaWaka2;
               
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOUmum=$rw1["nilai"];
				$biayaBPOUmum2=$rw1["nilai2"];
				$biayaBPOUmum3=$biayaBPOUmum+$biayaBPOUmum2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
                $biayaBPOKeu=$rw1["nilai"];
				$biayaBPOKeu2=$rw1["nilai2"];
				$biayaBPOKeu3=$biayaBPOKeu+$biayaBPOKeu2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
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
				
				$lblLB_Op=($LB_Op<0)?"(".number_format(abs($LB_Op),2,",",".").")":number_format($LB_Op,2,",",".");
				$lblLB_Op2=($LB_Op2<0)?"(".number_format(abs($LB_Op2),2,",",".").")":number_format($LB_Op2,2,",",".");
				$lblLB_Op3=($LB_Op3<0)?"(".number_format(abs($LB_Op3),2,",",".").")":number_format($LB_Op3,2,",",".");
                ?>
                <tr>
                  <td align="center"><?php echo $kode_MA_BUmum; ?></td>
				 
				   <?php 
                  /*if ($biayaUmum>0 || $biayaUmum2>0){
                  ?>
                  <td align="left">&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaUmum; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya OTL</a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;Biaya OTL</td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                   <td align="right"><?php echo number_format($biayaUmum,2,",","."); ?></td>
                   <td align="right"><?php echo number_format($biayaUmum2,2,",","."); ?></td>
                   <td align="right"><?php echo number_format($biayaUmum3,2,",","."); ?></td>
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
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOKaWaka2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOKaWaka3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOKaWaka3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
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
				
				  <?php 
                  /*if ($biayaBPOKaWaka>0 || $biayaBPOKaWaka2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOKawaka; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Ka/Waka RSPM</a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Ka/Waka RSPM</td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOKaWaka,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOKaWaka2,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOKaWaka3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOUmum2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOUmum3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOUmum3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kode_MA_BPOUmum; ?></td>
				 
				   <?php 
                  /*if ($biayaBPOUmum>0 || $biayaBPOUmum2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOUmum; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Umum</a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Umum</td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOUmum,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOUmum2,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOUmum3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOKeu2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOKeu3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOKeu3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kode_MA_BPOKeu; ?></td>
				  
				   <?php 
                  /*if ($biayaBPOKeu>0 || $biayaBPOKeu2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOKeu; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Keuangan</a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Keuangan</td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPOKeu,2,",","."); ?></td> 
                  <td align="right"><?php echo number_format($biayaBPOKeu2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($biayaBPOKeu3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeMaUmum."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$biayaBPOTeknik2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$biayaBPOTeknik3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$biayaBPOTeknik3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kode_MA_BPOTeknik; ?></td>
				   <?php 
                  /*if ($biayaBPOTeknik>0 || $biayaBPOTeknik2>0){
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;<a href="?f=../report/lapLR_Rekap.php&sak_sap=<?php echo $sak_sap; ?>&ma_kode=<?php echo $kodeMaBPOTeknik; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&tipe=detail&bulan_lr=<?php echo $bulan_lr; ?>&ta_lr=<?php echo $ta_lr; ?>">Biaya Dinas Teknik</a></td>
                  <?php 
                  }else{*/
                  ?>
                  <td align="left">&nbsp;&nbsp;&nbsp;Biaya Dinas Teknik</td>
                  <?php 
                  //}
                  ?>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOTeknik,2,",","."); ?></td>     
                 <td align="right"><?php echo number_format($biayaBPOTeknik2,2,",","."); ?></td>
                 <td align="right"><?php echo number_format($biayaBPOTeknik3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php 
				
				$stotDeviasi=0;
				
				$Deviasi=$stotBOTL_BPO3-$stotAngBOTL_BPO3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($stotAngBOTL_BPO3==0)?0:$Deviasi/$stotAngBOTL_BPO3 * 100;
				$Rasio2=($stotAngBOTL_BPO2==0)?0:$biayaBPOTeknik2/$stotAngBOTL_BPO2 * 100;
				$Rasio3=($stotAngBOTL_BPO3==0)?0:$biayaBPOTeknik3/$stotAngBOTL_BPO3 * 100;
				$Rasio4=($stotAngThBOTL_BPO==0)?0:$biayaBPOTeknik3/$stotAngThBOTL_BPO * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH (BOTL + BPO) : </td>
                  <td align="right"><?php echo number_format($stotAngThBOTL_BPO,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngThBOTL_BPO,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngBOTL_BPO2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngBOTL_BPO3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngBOTL_BPO3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBOTL_BPO,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($stotBOTL_BPO2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotBOTL_BPO3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
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
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH BIAYA OPERASI : </td>
                  <td align="right"><?php echo number_format($stotAngThOp,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotAngOp,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotAngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($totalBiayaOp,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($totalBiayaOp2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($totalBiayaOp3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI OPERASI : </td>
                  <td align="right"><?php echo number_format($AngThLB_Op,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($AngLB_Op,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_Op2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_Op3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_Op3,2,",","."); ?></td>
                  <td align="right"><?php echo $lblLB_Op; ?></td>
				  <td align="right"><?php echo $lblLB_Op2; ?></td>
                  <td align="right"><?php echo $lblLB_Op3; ?></td>
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
                <?php 
				}elseif($jbeban=="1"){
				?>
                <tr>
                  <td align="center">&nbsp;</td>
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
                </tr>
				<?php
					$stotbJneis=$stotbJneisb=$stotbJneisa=0;
					$sql="SELECT * FROM ak_ms_beban_jenis WHERE level=1 AND aktif=1 ORDER BY kode";
					$rsBJenis=mysql_query($sql);
					while ($rwBJenis=mysql_fetch_array($rsBJenis)){
						$cidbJenis=$rwBJenis["id"];
						$ckode=explode(".",$rwBJenis["kode"]);
						$clvl=$rwBJenis["level"];
						$lblnama=$rwBJenis["nama"];
						$cislast=$rwBJenis["islast"];
						
						$skode=$ckode[0];
						$lblkode=$ckode[0];
						
						$sqlbJenis="SELECT *
									FROM ((SELECT
											 IFNULL(SUM(j.DEBIT),0) AS nilaib
										   FROM jurnal j
											 INNER JOIN ak_ms_beban_jenis mbj
											   ON j.MS_BEBAN_JENIS_ID = mbj.id
										   WHERE mbj.kode LIKE '$lblkode%'
											   AND MONTH(j.TGL) < $bulan_lr
											   AND YEAR(j.TGL) = $ta_lr) AS nilaib,
									   (SELECT
										  IFNULL(SUM(j.DEBIT),0) AS nilai
										FROM jurnal j
										  INNER JOIN ak_ms_beban_jenis mbj
											ON j.MS_BEBAN_JENIS_ID = mbj.id
										WHERE mbj.kode LIKE '$lblkode%'
											AND MONTH(j.TGL) = $bulan_lr
											AND YEAR(j.TGL) = $ta_lr) AS nilai)";
						$rsnilaibJenis=mysql_query($sqlbJenis);
						$rwnilaibJenis=mysql_fetch_array($rsnilaibJenis);
						$cnilaibJenisb=$rwnilaibJenis["nilaib"];
						$cnilaibJenis=$rwnilaibJenis["nilai"];
						$cnilaibJenisa=$cnilaibJenisb+$cnilaibJenis;
						$stotbJneisb +=$cnilaibJenisb;
						$stotbJneis +=$cnilaibJenis;
						$stotbJneisa +=$cnilaibJenisa;
				?>
                <tr>
                  <td align="center"><?php echo $lblkode; ?></td>
                  <td align="left">&nbsp;<?php echo $lblnama; ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($cnilaibJenisb,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($cnilaibJenis,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($cnilaibJenisa,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
				<?php
					}
					
					$LB_Op=$stotOp-$stotbJneisb;
					$LB_Op2=$stotOp2-$stotbJneis;
					$LB_Op3=$LB_Op+$LB_Op2;
					
					$lblLB_Op=($LB_Op<0)?"(".number_format(abs($LB_Op),2,",",".").")":number_format($LB_Op,2,",",".");
					$lblLB_Op2=($LB_Op2<0)?"(".number_format(abs($LB_Op2),2,",",".").")":number_format($LB_Op2,2,",",".");
					$lblLB_Op3=($LB_Op3<0)?"(".number_format(abs($LB_Op3),2,",",".").")":number_format($LB_Op3,2,",",".");
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;JUMLAH BEBAN MENURUT JENIS : </td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($stotbJneisb,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($stotbJneis,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($stotbJneisa,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI MENURUT JENIS : </td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo $lblLB_Op; ?></td>
				  <td align="right"><?php echo $lblLB_Op2; ?></td>
                  <td align="right"><?php echo $lblLB_Op3; ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
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
				<?php
				}	
				$kodePend_Dluar="791";
				$kodeBiaya_Dluar="891";
				$kodePos_Dluar="901";
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
				
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
				$Pend_DLuarUsaha=$rw1["nilai"];
				$Pend_DLuarUsaha2=$rw1["nilai2"];
				$Pend_DLuarUsaha3=$Pend_DLuarUsaha+$Pend_DLuarUsaha2;
                
                $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
				
				
                $rs1=mysql_query($sql);
                $rw1=mysql_fetch_array($rs1);
				$Biaya_DLuarUsaha=$rw1["nilai"];
				$Biaya_DLuarUsaha2=$rw1["nilai2"];
				$Biaya_DLuarUsaha3=$Biaya_DLuarUsaha+$Biaya_DLuarUsaha2;
                
               	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
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
				
				$lblSelPendBiaya_DLuar=($SelPendBiaya_DLuar<0)?"(".number_format(abs($SelPendBiaya_DLuar),2,",",".").")":number_format($SelPendBiaya_DLuar,2,",",".");
				$lblSelPendBiaya_DLuar2=($SelPendBiaya_DLuar2<0)?"(".number_format(abs($SelPendBiaya_DLuar2),2,",",".").")":number_format($SelPendBiaya_DLuar2,2,",",".");
				$lblSelPendBiaya_DLuar3=($SelPendBiaya_DLuar3<0)?"(".number_format(abs($SelPendBiaya_DLuar3),2,",",".").")":number_format($SelPendBiaya_DLuar3,2,",",".");
				
				$lblLR_SblmPajak=($LR_SblmPajak<0)?"(".number_format(abs($LR_SblmPajak),2,",",".").")":number_format($LR_SblmPajak,2,",",".");
				$lblLR_SblmPajak2=($LR_SblmPajak2<0)?"(".number_format(abs($LR_SblmPajak2),2,",",".").")":number_format($LR_SblmPajak2,2,",",".");
				$lblLR_SblmPajak3=($LR_SblmPajak3<0)?"(".number_format(abs($LR_SblmPajak3),2,",",".").")":number_format($LR_SblmPajak3,2,",",".");
                ?>
                <tr>
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
                </tr>
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
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodePend_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Pend_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Pend_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Pend_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kodePend_Dluar; ?></td>
                  <td align="left">&nbsp;&nbsp;&nbsp;PENDAPATAN DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($Pend_DLuarUsaha2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pend_DLuarUsaha3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodeBiaya_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
				$rsAng1=mysql_query($sql);
				$rwAng1=mysql_fetch_array($rsAng1);
				$stotAngOp +=$rwAng1["nilai"];
				$stotAngOp2 +=$rwAng1["nilai2"];
				$AngOp3=$rwAng1["nilai"]+$rwAng1["nilai2"];
				$stotAngOp3 +=$AngOp3;
					
				$Deviasi=$Biaya_DLuarUsaha3-$AngOp3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Biaya_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Biaya_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Biaya_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kodeBiaya_Dluar; ?></td>
                  <td align="left">&nbsp;&nbsp;&nbsp;BIAYA DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($Biaya_DLuarUsaha2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Biaya_DLuarUsaha3,2,",","."); ?></td>
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
                <?php 
				$SelAngThPendBiaya_DLuar=$SelAngThPendBiaya_DLuar-$AngThBiaya_DLuarUsaha;
				$SelAngPendBiaya_DLuar=$SelAngPendBiaya_DLuar-$Biaya_DLuarUsaha;
				$SelAngPendBiaya_DLuar2=$SelAngPendBiaya_DLuar2-$Biaya_DLuarUsaha2;
				$SelAngPendBiaya_DLuar3=$SelAngPendBiaya_DLuar3-$Biaya_DLuarUsaha3;

				$SelPendBiaya_DLuar=$Pend_DLuarUsaha-$Biaya_DLuarUsaha;
				$SelPendBiaya_DLuar2=$Pend_DLuarUsaha2-$Biaya_DLuarUsaha2;
				$SelPendBiaya_DLuar3=$Pend_DLuarUsaha3-$Biaya_DLuarUsaha3;
					
				$Deviasi=$SelPendBiaya_DLuar3-$SelAngPendBiaya_DLuar3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($Biaya_DLuarUsaha3==0)?0:$Deviasi/$Biaya_DLuarUsaha3 * 100;
				$Rasio2=($SelAngPendBiaya_DLuar2==0)?0:$SelPendBiaya_DLuar2/$SelAngPendBiaya_DLuar2 * 100;
				$Rasio3=($SelAngPendBiaya_DLuar3==0)?0:$SelPendBiaya_DLuar3/$SelAngPendBiaya_DLuar3 * 100;
				$Rasio4=($SelAngThPendBiaya_DLuar==0)?0:$SelPendBiaya_DLuar3/$SelAngThPendBiaya_DLuar * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;SELISIH PEND / BIAYA DILUAR USAHA : </td>
                  <td align="right"><?php echo number_format($SelAngThPendBiaya_DLuar,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelAngPendBiaya_DLuar3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($SelPendBiaya_DLuar3,2,",","."); ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
                <?php  				
				$stotAngThOp=$stotAngOp=$stotAngOp2=$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
					
				$sql="SELECT
					   IFNULL(SUM(j.NILAI), 0) AS nilai
					 FROM anggaran j
					   INNER JOIN ma_sak ma
						 ON j.FK_MAID = ma.MA_ID
					 WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
						 AND j.TAHUN = $ta_lr";
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
								  AND j.TAHUN = $ta_lr 
							  UNION 
							  SELECT
							   '0'  AS nilai,
							   IFNULL(SUM(j.NILAI), 0) AS nilai2
							 FROM anggaran j
							   INNER JOIN ma_sak ma
								 ON j.FK_MAID = ma.MA_ID
							 WHERE ma.MA_KODE LIKE '".$kodePos_Dluar."%'
								 AND j.BULAN = $bulan_lr
								 AND j.TAHUN = $ta_lr) t";
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
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngOp3==0)?0:$Deviasi/$AngOp3 * 100;
				$Rasio2=($rwAng1["nilai2"]==0)?0:$Pos_DLuarUsaha2/$rwAng1["nilai2"] * 100;
				$Rasio3=($AngOp3==0)?0:$Pos_DLuarUsaha3/$AngOp3 * 100;
				$Rasio4=($rwAngTh1["nilai"]==0)?0:$Pos_DLuarUsaha3/$rwAngTh1["nilai"] * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center"><?php echo $kodePos_Dluar; ?></td>
                  <td align="left">&nbsp;POS-POS DILUAR USAHA</td>
                  <td align="right"><?php echo number_format($rwAngTh1["nilai"],2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($rwAng1["nilai"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($rwAng1["nilai2"],2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngOp3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha,2,",","."); ?></td>
				  <td align="right"><?php echo number_format($Pos_DLuarUsaha2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($Pos_DLuarUsaha3,2,",","."); ?></td>
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
                <?php 
				$stotDeviasi=0;
				$stotRasio1=$stotRasio2=$stotRasio3=$stotRasio4=0;
				
				$AngThLB_SblmPajak=$AngThLB_Op+$SelAngThPendBiaya_DLuar-$AngThPos_DLuarUsaha;
				$AngLB_SblmPajak=$AngLB_Op+$SelAngThPendBiaya_DLuar-$AngPos_DLuarUsaha;
				$AngLB_SblmPajak2=$AngLB_Op2+$SelAngThPendBiaya_DLuar2-$AngPos_DLuarUsaha2;
				$AngLB_SblmPajak3=$AngLB_Op3+$SelAngThPendBiaya_DLuar3-$AngPos_DLuarUsaha3;
				
				
				$Deviasi=$LR_SblmPajak3-$AngLB_SblmPajak3;
				$lblDeviasi=($Deviasi<0)?"(".number_format(abs($Deviasi),2,",",".").")":number_format($Deviasi,2,",",".");
				
				$stotDeviasi +=$Deviasi;
				$lbltotDeviasi=($stotDeviasi<0)?"(".number_format(abs($stotDeviasi),2,",",".").")":number_format($stotDeviasi,2,",",".");
				
				$Rasio1=($AngLB_SblmPajak3==0)?0:$Deviasi/$AngLB_SblmPajak3 * 100;
				$Rasio2=($AngLB_Op2==0)?0:$Pos_DLuarUsaha2/$AngLB_Op2 * 100;
				$Rasio3=($AngLB_SblmPajak3==0)?0:$LR_SblmPajak3/$AngLB_SblmPajak3 * 100;
				$Rasio4=($AngThLB_Op==0)?0:$LR_SblmPajak3/$AngThLB_Op * 100;
				
				$stotRasio1 +=$Rasio1;
				$stotRasio2 +=$Rasio2;
				$stotRasio3 +=$Rasio3;
				$stotRasio4 +=$Rasio4;
				
				$lblRasio1=($Rasio1<0)?"(".number_format(abs($Rasio1),2,",",".").")":number_format($Rasio1,2,",",".");
				$lblRasio2=($Rasio2<0)?"(".number_format(abs($Rasio2),2,",",".").")":number_format($Rasio2,2,",",".");
				$lblRasio3=($Rasio3<0)?"(".number_format(abs($Rasio3),2,",",".").")":number_format($Rasio3,2,",",".");
				$lblRasio4=($Rasio4<0)?"(".number_format(abs($Rasio4),2,",",".").")":number_format($Rasio4,2,",",".");
				?>
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;LABA / RUGI SEBELUM PAJAK : </td>
                  <td align="right"><?php echo number_format($AngThLB_SblmPajak,2,",","."); ?></td>
                  <td align="right">&nbsp;</td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak2,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak3,2,",","."); ?></td>
                  <td align="right"><?php echo number_format($AngLB_SblmPajak3,2,",","."); ?></td>
                  <td align="right"><?php echo $lblLR_SblmPajak; ?></td>
				  <td align="right"><?php echo $lblLR_SblmPajak2; ?></td>
                  <td align="right"><?php echo $lblLR_SblmPajak3; ?></td>
                  <td align="right"><?php echo $lbltotDeviasi; ?></td>
                  <td align="right"><?php echo $lblstotRasio1; ?></td>
                  <td align="right"><?php echo $lblstotRasio2; ?></td>
                  <td align="right"><?php echo $lblstotRasio3; ?></td>
                  <td align="right"><?php echo $lblstotRasio4; ?></td>
                </tr>
              </table>
    </div>
		<?php
			}
		?>
<p>
        <!--BUTTON style="display:<?php echo $dsp_export; ?>" type="button" onClick="window.open(<?php echo $lnk; ?>);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Export ke File Excell</strong></BUTTON--> &nbsp;&nbsp;&nbsp;<button style="display:<?php echo $dsp_view; ?>" type="button" onclick="window.open(<?php echo $lnk_view; ?>)"> 
                <img src="../icon/lihat.gif" height="16" width="16" border="0" align="absmiddle" />&nbsp; 
                Lihat</button>
        <?php 
		if ($tampilback==1){
		?>
        <BUTTON type="button" onClick="history.back();"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Kembali</strong></BUTTON>
        <?php 
		}
		?>
</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
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
$sak_sap=$_REQUEST["sak_sap"];
if ($sak_sap=="") $sak_sap="1";
if ($sak_sap=="1"){
	$jdl_lap="Laporan Arus Kas SAK";
}else{
	$jdl_lap="Laporan Arus Kas SAP";
}

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
$lnk="'../report/arus_kas_detail_excell.php?sak_sap=".$sak_sap."&tgl_d=$tgl_d&tgl_s=$tgl_s&kodema=$kodema&kelompok=$kelompok&type=$type&cinduk=$cinduk&ckel=$ckel&cdk=$cdk&ccrvksopbfumum=$ccrvksopbfumum'";
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
<div align="center">
<form name="form1" method="get">
<div id="input" style="display:block">
	  <p class="jdltable"><?php echo $jdl_lap; ?></p>
      <table border="0" cellspacing="0" cellpadding="0" class="bodyText12">
        <tr>
          <td>Kelompok : <?php echo $ckel; ?></td>
        </tr>
        <tr> 
          <td align="center">Periode : <?php echo $tgl_s; ?>&nbsp;&nbsp;s/d&nbsp;&nbsp;<?php echo $tgl_d; ?></td>
        </tr>
      </table>
      <br />
      <div>
      <!--table width="700" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr> 
          <td width="100%" colspan="3" align="center"><?=$pemkabRS;?></td>
        </tr>
        <tr> 
          <td width="100%" colspan="3" align="center">RUMAH SAKIT UMUM DAERAH</td>
        </tr>
        <tr> 
          <td width="100%" colspan="3" align="center">LAPORAN ARUS KAS</td>
        </tr>
        <tr> 
          <td width="100%" colspan="3" align="center">PERIODE <?php //echo $tgl_s."  s/d  ".$tgl_d; ?></td>
        </tr>
      </table-->
      <table width="850" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
        <tr>
          <td width="30" align="center">No</td>
          <td width="120" align="center">Kode SAK</td>
          <td align="center">Uraian</td>
          <td width="160" align="center">Nilai</td>
        </tr>
        <?php 
		if ($ccrvksopbfumum==0){
			if ($cdk=="K"){
				if ($type=="0"){
					$sql="SELECT t4.MA_KODE,t4.MA_NAMA,t4.CC_RV_KSO_PBF_UMUM,SUM(t4.DEBIT),SUM(t4.KREDIT),SUM(t4.NILAI) NILAI FROM (SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT-t3.DEBIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)) AS t4 
	GROUP BY t4.MA_KODE";
				}else{
					$sql="SELECT t4.MA_KODE,t4.MA_NAMA,t4.CC_RV_KSO_PBF_UMUM,SUM(t4.DEBIT),SUM(t4.KREDIT),SUM(t4.NILAI) NILAI FROM (SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)) AS t4 
	GROUP BY t4.MA_KODE";
				}
			}else{
				if ($type=="0"){
					$sql="SELECT t4.MA_KODE,t4.MA_NAMA,t4.CC_RV_KSO_PBF_UMUM,SUM(t4.DEBIT),SUM(t4.KREDIT),SUM(t4.NILAI) NILAI FROM (SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT-t3.KREDIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)) AS t4 
	GROUP BY t4.MA_KODE";
				}else{
					$sql="SELECT t4.MA_KODE,t4.MA_NAMA,t4.CC_RV_KSO_PBF_UMUM,SUM(t4.DEBIT),SUM(t4.KREDIT),SUM(t4.NILAI) NILAI FROM (SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)) AS t4 
	GROUP BY t4.MA_KODE";
				}
			}
		}else{
			if ($cdk=="K"){
				if ($type=="0"){
					$sql="SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT-t3.DEBIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)";
				}else{
					$sql="SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.KREDIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)";
				}
			}else{
				if ($type=="0"){
					$sql="SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT-t3.KREDIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)";
				}else{
					$sql="SELECT DISTINCT t3.MA_KODE,t3.MA_NAMA,t3.NO_TRANS,t3.CC_RV_KSO_PBF_UMUM,t3.CC_RV_KSO_PBF_UMUM_ID,t3.DEBIT,t3.KREDIT,t3.DEBIT AS NILAI FROM 
	(SELECT c.MA_KODE,c.MA_NAMA,c.CC_RV_KSO_PBF_UMUM,t2.* FROM 
	(SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID 
	WHERE b.MA_KODE LIKE '1.1.01%' AND a.flag = '$flag' AND a.TGL BETWEEN '$tgl_s1' AND '$tgl_d1') AS t1,jurnal j 
	WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 
	WHERE LEFT(t3.MA_KODE,3)<>'1.1.01' AND ($pkode)";
				}
			}
		}
		// echo $sql."<br>";
		$rs=mysql_query($sql);
		$i=0;
		$subtot=0;
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$subtot +=$rows["NILAI"];
			if ($rows["NILAI"]<0)
				$nilai="(".number_format(abs($rows["NILAI"]),2,",",".").")";
			else
				$nilai=number_format($rows["NILAI"],2,",",".");
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
		?>
        <tr>
          <td width="30" align="center"><?php echo $i; ?></td>
          <?php if ($rows["CC_RV_KSO_PBF_UMUM"]!=0 && $ccrvksopbfumum==0){?>
          <td width="30" align="left">&nbsp;<a href="?f=../report/arus_kas_detail.php&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&kodema=<?php echo $rows["MA_KODE"]; ?>&kelompok=<?php echo $kelompok; ?>&type=<?php echo $type; ?>&cinduk=<?php echo $cinduk; ?>&ckel=<?php echo $rows["MA_NAMA"]; ?>&cdk=<?php echo $cdk; ?>&ccrvksopbfumum=<?php echo $rows['CC_RV_KSO_PBF_UMUM']; ?>"><?php echo $kodema; ?></a></td>
          <td align="left">&nbsp;<a href="?f=../report/arus_kas_detail.php&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&kodema=<?php echo $rows["MA_KODE"]; ?>&kelompok=<?php echo $kelompok; ?>&type=<?php echo $type; ?>&cinduk=<?php echo $cinduk; ?>&ckel=<?php echo $rows["MA_NAMA"]; ?>&cdk=<?php echo $cdk; ?>&ccrvksopbfumum=<?php echo $rows['CC_RV_KSO_PBF_UMUM']; ?>"><?php echo $ma; ?></a></td>
          <?php }else{?>
          <td width="30" align="left">&nbsp;<?php echo $kodema; ?></td>
          <td align="left">&nbsp;<?php echo $ma; ?></td>
          <?php }?>
          <td width="160" align="right"><?php echo $nilai; ?></td>
        </tr>
        <?php }
		if ($subtot<0)
			$strsubTot="(".number_format(abs($subtot),2,",",".").")";
		else
			$strsubTot=number_format($subtot,2,",",".");
		?>
        <tr>
          <td width="30" align="center">&nbsp;</td>
          <td width="30" align="center">&nbsp;</td>
          <td align="right">Sub Total&nbsp;</td>
          <td width="160" align="right"><?php echo $strsubTot; ?></td>
        </tr>
      </table>
      </div>
<p>
        <!--BUTTON type="button" onClick="window.open(<?php //echo $lnk; ?>);"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak Laporan</strong></BUTTON-->&nbsp;
        <BUTTON type="button" onClick="window.open(<?php echo $lnk; ?>);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Export ke File Excell</strong></BUTTON>
        <BUTTON type="button" onClick="history.back();"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Kembali</strong></BUTTON>
</div>
<!--input name="ddd" type="button" value="dddd" onclick="alert(tgl2.value)" /-->
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
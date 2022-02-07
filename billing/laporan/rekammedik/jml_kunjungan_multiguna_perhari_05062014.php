<?php
	if($_POST['isExcel']=='yes'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="W2.xls"');
	}

	include("../../koneksi/konek.php");
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];//'Bulanan';

	$tgla="";
	$tglb=""; $batas=array();
		
	if($waktu == 'Harian'){
		echo '<script type="text/javascript">alert("Anda Hanya Dapat Memilih Laporan Bulanan!");window.close();</script>';
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//$waktu = "AND DATE(p.tgl) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
		
		$tgla= $tglAwal[0];
		$tglb= $tglAwal[0]+1;
	}else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];//'05';
		$thn = $_POST['cmbThn'];//'2014';
		//$waktu = "AND month(p.tgl) = '$bln' AND year(p.tgl) = '$thn' ";        
		$Periode = "Bulan : $arrBln[$bln]";
		$taun = "TAHUN $thn";
	
		if($bln=='01' || $bln=='03' || $bln=='05' || $bln=='07' || $bln=='08' || $bln=='10' || $bln=='12'){
			$tgl = 31;
		}else if($bln == '02'){
			if(($thn==0) && ($thn%100 !=0)){
				$tgl = 29;
			}else{
				$tgl = 28;
			}
		}else{
			$tgl = 30;
		}
		
		$tgla=1;
		$tglb=$tgl;
	}else{
		echo '<script type="text/javascript">alert("Anda Hanya Dapat Memilih Laporan Bulanan!");window.close();</script>';
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		//$waktu = "AND DATE(p.tgl) between '$tglAwal2' and '$tglAkhir2' ";
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	
		$bln;
		$tglAwal[0]='29';$tglAwal[1]='03';$tglAwal[2]='2014';$tglAkhir[0]='21';$tglAkhir[1]='05';$tglAkhir[2]='2014';
		if($tglAwal[1]==$tglAkhir[1]){
			$tgla = $tglAwal[0];
			$tglb = $tglAkhir[0];
			
		}else if($tglAwal[1]<$tglAkhir[1]){
			$tgla=$tglAwal[0];$tglb=0;
			$jml;$awal=$tglAwal[0];$akhir=$tglAkhir[0];
			
			for($i=$tglAwal[1];$i<=$tglAkhir[1];$i++){
				$bln=$i;
				
				if($bln=='01' || $bln=='03' || $bln=='05' || $bln=='07' || $bln=='08' || $bln=='10' || $bln=='12'){
					$tgl = 31;
				}else if($bln == '02'){
					if(($thn==0) && ($thn%100 !=0)){
						$tgl = 29;
					}else{
						$tgl = 28;
					}
				}else{
					$tgl = 30;
				}
				
				if($i!=$tglAkhir[1]){
					$jml=$tgl-$awal;
					$tglb+=$tgl;
				}
				else{
					$jml=$akhir-$tgl;
					$tglb+=$akhir;
				}
				
				$awal=1;
				array_push($batas, $tgl);
			}
		}
	}
	//echo  count($batas);
	$jml=$tglb-$tgla+1;//echo $jml;

	$JnsLayanan = $_REQUEST['JnsLayanan'];
	$TmpLayanan = $_REQUEST['TmpLayanan'];

	if($TmpLayanan==0){
		if($JnsLayanan==1){
			$fUnit = "AND p.jenis_kunjungan<>3 ";
			$txtTmpt = "RAWAT JALAN - SEMUA";
			$txtJudul = "Rawat Jalan";
		}
		else{
			$fUnit = "AND p.jenis_kunjungan=3 ";
			$txtTmpt = "RAWAT INAP - SEMUA";
			$txtJudul = "Rawat Inap";
		}
	}
	else{
		$sTmp = "SELECT nama FROM b_ms_unit WHERE id=".$TmpLayanan;
		$qTmp = mysql_query($sTmp);
		$rwTmp = mysql_fetch_array($qTmp);
		$txtTmp = $rwTmp['nama'];
		$fUnit = " AND p.unit_id = ".$TmpLayanan;
		
		if($JnsLayanan==1){
			$txtTmpt = "RAWAT JALAN - ".$txtTmp;
		}
		else{
			$txtTmpt = "RAWAT INAP - ".$txtTmp;
		}
	}

		$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
		$rsPeg = mysql_query($sqlPeg);
		$rwPeg = mysql_fetch_array($rsPeg);

	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$stat = "SELECT nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPas']."' ";
	$statP = mysql_fetch_array(mysql_query($stat));
	$ksoP = $_REQUEST['StatusPas'];
	
	if($ksoP!=0){
		$ksoPa = " AND p.kso_id = '".$ksoP."'";
	}
?>

<html>
<head>
	<title>Jumlah Kunjungan Rawat Jalan Multiguna</title>
</head>

<body>
<table width="100%" border="0">
  <tr align="center">
    <td colspan="2"><strong>RS PELINDO I<br />JUMLAH KUNJUNGAN <?php echo $txtTmpt." PASIEN ".$statP['nama'];?> PER HARI<br /><?=$taun?></strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><!--Bulan : April--><?=$Periode?></td>
  </tr>
  
  <tr>
	<td colspan="2">
	  <table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
	    <tr>
		  <td align="center" width="3%" rowspan="2">NO</td>
		  <td align="center" width="10%" rowspan="2">NAMA</td>
		  <td align="center" colspan="<?=$tglb-$tgla+1?>">TANGGAL</td>
		  <td align="center" width="6%" rowspan="2">TOTAL</td>
		  <td align="center" width="6%" rowspan="2">Av/hr</td>
		</tr>
		<tr>
		<?php 
		  $cek=0;$j=$tgla;
		  
		  for($i=$tgla;$i<=$tglb;$i++){
			if($j!=$batas[$cek]){
		?>
		      <td><?=$j?></td>
		<?php 
			  $j++;
			}else{
		?>
		      <td><?=$j?></td>
		<?php 
			  $j=1;
			  $cek++;
			}
		  }
		?>
		</tr>
		<?php
function Romawi($n){
$hasil = "";
$iromawi =

array("","I","II","III","IV","V","VI","VII","VIII","IX","X",
20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",
90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",
600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
2000=>"MM",3000=>"MMM");

if(array_key_exists($n,$iromawi)){
$hasil = $iromawi[$n];
}elseif($n >= 11 && $n <= 99){
$i = $n % 10;
$hasil = $iromawi[$n-$i] . Romawi($n % 10);
}elseif($n >= 101 && $n <= 999){
$i = $n % 100;
$hasil = $iromawi[$n-$i] . Romawi($n % 100);
}else{
$i = $n % 1000;
$hasil = $iromawi[$n-$i] . Romawi($n % 1000);
}

return $hasil;
}

		  $sId="SELECT spesialisasi_id, spesialisasi, COUNT(*) jmlId
				FROM b_ms_pegawai
				WHERE spesialisasi_id <> 0 AND spesialisasi <> ''
				GROUP BY spesialisasi_id
				ORDER BY spesialisasi";
		  $qId=mysql_query($sId);
		  $n=1;
		  while($rwId=mysql_fetch_array($qId)){
		  
		 /* //function Romawi($no){
			$hasil = "";
			$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
			60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
			800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
			if(array_key_exists($n,$iromawi)){
				$hasil = $iromawi[$n];
			}elseif($n >= 11 && $n <= 99){
				echo $i = $n % 10;
				echo $hasil = $iromawi[$n-$i] . ($n % 10);
			}elseif($n >= 101 && $n <= 999){
				$i = $n % 100;
				$hasil = $iromawi[$n-$i] . ($n % 100);
			}else{
				$i = $n % 1000;
				$hasil = $iromawi[$n-$i] . ($n % 1000);
			}*/
		?>
		<tr>
		  <td align="center" valign="top" rowspan="<?=$rwId['jmlId']+2?>"><?=Romawi($n)?></td>
		  <td colspan="<?=$jml+3?>">&nbsp;<b><?=$rwId['spesialisasi']?></b></td>		  
		</tr>
		  
		  <?php
		    $sDokter="SELECT nama, id
					FROM b_ms_pegawai
					WHERE spesialisasi_id = '".$rwId['spesialisasi_id']."' AND spesialisasi <> '' ";
		    $qDokter=mysql_query($sDokter);
			$totLah = 0;
		    while($rwDokter=mysql_fetch_array($qDokter)){
		  ?>
		      <tr>
			  <td><?=$rwDokter['nama']?></td>
			  <?php
			  $totLah = 0;
			  $tot = 0;
			   for($i=$tgla;$i<=$tglb;$i++){
/*$que="SELECT COUNT(p.id) jml FROM b_pelayanan p
 INNER JOIN b_ms_pegawai mp
 ON mp.id = p.dokter_tujuan_id
 WHERE p.dokter_tujuan_id = '".$rwDokter['id']."'
 AND YEAR(p.tgl) = '".$thn."'
 AND MONTH(p.tgl) = '".$bln."'
 AND DAY(p.tgl) = '".$i."';";*/
/*$que = "SELECT 
 p.id,  
 COUNT(p.id) jml,
 COUNT((SELECT COUNT(d.diagnosa_id) jml FROM b_diagnosa d INNER JOIN b_ms_pegawai mp ON mp.id = d.user_id WHERE d.user_id = '".$rwDokter['id']."' AND YEAR(d.tgl) = '".$thn."' AND MONTH(d.tgl) = '".$bln."' AND DAY(d.tgl) = '".$i."' AND d.pelayanan_id = p.id GROUP BY d.pelayanan_id)) diag,
 COUNT((SELECT COUNT(t.id) jml FROM b_tindakan t INNER JOIN b_ms_pegawai mp ON mp.id = t.user_id WHERE t.user_id = '".$rwDokter['id']."' AND YEAR(t.tgl) = '".$thn."' AND MONTH(t.tgl) = '".$bln."' AND DAY(t.tgl) = '".$i."' AND t.pelayanan_id = p.id GROUP BY t.pelayanan_id)) jml
 FROM b_pelayanan p
 WHERE p.batal = '0'
 $fUnit
 $ksoPa
 and p.dokter_tujuan_id = '857'
 AND YEAR(p.tgl) = '".$thn."'
 AND MONTH(p.tgl) = '".$bln."'
 $waktu
 AND DAY(p.tgl) = '".$i."';";*/
 /*$que = "SELECT 
 p.id,
 COUNT((SELECT COUNT(d.diagnosa_id) jml FROM b_diagnosa d INNER JOIN b_ms_pegawai mp ON mp.id = d.user_id WHERE d.user_id = '".$rwDokter['id']."' AND d.tgl = '".$thn."-".$bln."-".$i."' AND d.pelayanan_id = p.id GROUP BY d.pelayanan_id)) diag,
 COUNT((SELECT COUNT(t.id) jml FROM b_tindakan t INNER JOIN b_ms_pegawai mp ON mp.id = t.user_id WHERE t.user_id = '".$rwDokter['id']."' AND t.tgl = '".$thn."-".$bln."-".$i."' AND t.pelayanan_id = p.id GROUP BY t.pelayanan_id)) jml
 FROM b_pelayanan p
 WHERE p.batal = '0'
 $fUnit
 $ksoPa
 AND p.tgl = '".$thn."-".$bln."-".$i."';";*/
 
 /*$que = "SELECT 
  IFNULL(SUM(jml),0) tot 
FROM
  (SELECT 
  pas.no_rm,
  pas.nama,
  t.
    COUNT(t.id) jml 
  FROM
    b_pelayanan p 
    INNER JOIN b_tindakan t 
      ON t.pelayanan_id = p.id 
    INNER JOIN b_ms_pasien pas 
      ON pas.id = p.pasien_id 
  WHERE t.user_id = '".$rwDokter['id']."' 
    $fUnit
 	$ksoPa 
    AND p.batal = '0' 
    AND p.tgl = '".$thn."-".$bln."-".$i."' 
  GROUP BY t.pelayanan_id) AS gab ;";*/
  
  $que = "SELECT COUNT(te) jml FROM (
	SELECT 
	  p.id te,t.id,d.diagnosa_id
	  FROM
		b_pelayanan p 
		LEFT JOIN b_tindakan t 
		  ON t.pelayanan_id = p.id
		LEFT JOIN b_diagnosa d 
		  ON d.pelayanan_id = p.id 
	  WHERE (t.user_id = '".$rwDokter['id']."' or d.user_id = '".$rwDokter['id']."') 
		$fUnit
 		$ksoPa 
		AND p.batal = '0' 
		AND p.tgl = '".$thn."-".$bln."-".$i."' 
	  GROUP BY p.id) AS tes;";
 //echo $que."<br/>";
$queH = mysql_query($que);
$quew = mysql_fetch_array($queH);

/*$queIsi = 0;
while($quew = mysql_fetch_array($queH)){
//echo $quew['id'];
  $que1="SELECT 
	 IF(t.id=NULL,'0','1') jml 
	FROM
	  b_tindakan t
	WHERE 
	t.user_id = '".$rwDokter['id']."' 
	AND YEAR(t.tgl) = '".$thn."' 
	AND MONTH(t.tgl) = '".$bln."' 
	AND DAY(t.tgl) = '".$i."'
	AND t.pelayanan_id = '".$quew['id']."' 
	GROUP BY t.pelayanan_id";
//echo $que1;
  $que1x = mysql_query($que1);
  $que = mysql_fetch_array($que1x);
  $queIsi = $que['jml'];
	
	if($queIsi==NULL){
	  $que2="SELECT 
		 COUNT(d.diagnosa_id) jml 
		FROM
		  b_diagnosa d
		WHERE 
		d.user_id = '".$rwDokter['id']."' 
		AND YEAR(d.tgl) = '".$thn."' 
		AND MONTH(d.tgl) = '".$bln."' 
		AND DAY(d.tgl) = '".$i."'
		AND d.pelayanan_id = '".$quew['id']."' ";
	  $que2x = mysql_query($que2);
	  $que2 = mysql_fetch_array($que2x);
	  $queIsi = $que2['jml'];
	}
	
	$queTotIsi += $queIsi;
}*/
	$tot = $quew['jml'];
				  ?>
				<td><?=$tot?></td>
			  <?php
			  $totLah += $tot;
			   }?>
			  <td><?=$totLah?></td>
			  <td><?=number_format($totLah/$tglb,2)?></td>
			  </tr>	
		  <?php 
		    }
		  ?>			
		<tr>
		  <td align="right"><b><i>TOTAL</i></b></td>
		  <?php for($i=$tgla;$i<=$tglb;$i++){?>
		    <td>&nbsp;</td>
		  <?php }?>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<?php
		   $n++;
		  }
		?>
		
	  </table>
	</td>
  </tr>
  
  <!--<tr height="20"><tr>-->
  <tr>
    <td width="80%"></td>
	<td align="center">Ka. Instalasi Rekam Medis<br /><br /><br /><b><u>Romaden Marbun, SKM, MAP</u></b><br />NIP:197511292006041008</td>
  </tr>
</table>
</body>
</html>
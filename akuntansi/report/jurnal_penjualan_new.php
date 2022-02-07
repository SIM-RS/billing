<?php
	session_start();
	include("../sesi.php");
	include("../koneksi/konek.php");
	// include("konek.php");
	// if($_POST['export']=='excel'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Buku Jurnal Penjualan.xls"');
	// }
	$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
	$wktnow=gmdate('H:i:s',mktime(date('H')+7));
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	$kso = $_REQUEST['cmbKsoRep'];
	$cwaktu = $waktu;
	$waktu = "Bulanan";
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND j.TGL = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $tmpBln = explode('|',$_REQUEST['cmbBln']);
		$bln = $tmpBln['0'];
        $thn = $_REQUEST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		// $tglAwal2 = "$thn-$cbln-01";
		// $tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND MONTH(j.TGL) = '$bln' AND YEAR(j.TGL) = '$thn' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND j.TGL between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Buku Jurnal Penjualan</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:11px; font-family:arial;}
		table{margin:0; padding:0;}
		table{ border-collapse:collapse; width:100%; text-align:left; }
		th{ text-align:center; }
		th, td { padding:5px; border:1px solid #000; }
		.borderfull{ border:1px solid #000; }
		.noborder{ border:0px; }
		.borderbottom{ border-bottom:1px solid #000; }
		.kanan{ text-align:right; }
		#container{ text-align:center; margin:20px; }
		#judul{ text-align:center; width:100%; font-size:18px; }
		.topbottom{ border-top:1px solid #000; border-bottom:1px solid #000; border-left:0px; border-right:0px; }
	</style>
</head>
<body>
	<div id="container">
		<header id="judul">
			<div style="width:100%; text-align:left; font-size:12px;">
				PT. PELABUHAN INDONESIA I (PERSERO)<br />
				<?php echo $namaRS; ?>
			</div>
			<div>
				<b style="font-size:20px;" >BUKU JURNAL PENJUALAN<br /></b>
				<?php echo $Periode; ?>
				<br />
				<br />
			</div>
		</header>
		<table id="dataNilai">
			<?php
				$sqlCol = "SELECT * FROM ak_ms_unit WHERE tipe = 2 AND islast = 1";
				$qCol = mysql_query($sqlCol);
				$jml = mysql_num_rows($qCol);
				$thDetail['103'] = "P. USAHA";
				while($qCol && $dCol = mysql_fetch_object($qCol)){
					$number = str_replace($dCol->parent_kode, "", $dCol->kode);
					$thDetail[$number] = $dCol->nama;
					$caseQuery[] = "IFNULL(SUM(CASE WHEN jj.CC_RV_ID = '".$dCol->id."' THEN jj.KREDIT END),0) AS `".$dCol->kode."`";
				}
				$thDetail['710'] = "JUMLAH";
				$thDetail['423'] = "UTANG PPN";
				$caseQuery[] = "IFNULL(SUM(CASE WHEN jj.CC_RV_ID = 0 THEN jj.KREDIT END),0) AS `423`";
			?>
			<tr>
				<th rowspan="2">TANGGAL</th>
				<th rowspan="2">NO</th>
				<th rowspan="2" width="300">NAMA PERUSAHAAN</th>
				<th>DEBET</th>
				<th colspan="<?php echo ($jml+2); ?>">KREDIT</th>
			</tr>
			<tr>
				<?php
					foreach($thDetail as $key => $val){
						echo "<th>".$val."<br />( ".$key." )&nbsp;</th>";
					}
				?>
			</tr>
			<tr style="background:#F6F6F6;">
				<?php
					for($i=0; $i <= (count($thDetail)+2); $i++){
						echo "<th>".($i+1)."</th>";
					}
				?>
			</tr>
			<?php
				$sData = "SELECT jj.TGL, kso.nama penjamin, jj.TGL_ACT, t1.`103`,
							   ".implode(',',$caseQuery)."
							FROM (
								SELECT j.NO_TRANS, j.TR_ID, j.FK_SAK, j.DEBIT AS `103`
								FROM jurnal j
								INNER JOIN ma_sak sak ON sak.MA_ID = j.FK_SAK AND sak.MA_KODE LIKE '103%'
								WHERE 0=0 {$waktu}
								GROUP BY j.NO_TRANS
							) t1
							INNER JOIN jurnal jj ON jj.NO_TRANS = t1.NO_TRANS AND jj.TR_ID <> t1.TR_ID
							INNER JOIN rspelindo_billing.b_ms_kso kso ON kso.id = jj.CC_RV_KSO_PBF_UMUM_ID
							LEFT JOIN ak_ms_unit u ON u.id = jj.CC_RV_ID
							GROUP BY jj.NO_TRANS
							ORDER BY jj.TGL ASC";
				// echo $sData."<br />";
				$no = 1;
				$qData = mysql_query($sData);
				$tmpTgl = "";
				$grandTotal = array();
				$notCOunt = array('103', '710', '423');
				if($qData && mysql_num_rows($qData) > 0){
					while($data = mysql_fetch_object($qData)){
						echo "<tr>";
						if($tmpTgl != $data->TGL)
							echo "<td>".tglSQL($data->TGL)."</td>";
						else
							echo "<td></td>";
						echo "<td align='center'>".$no++.".</td>";
						echo "<td>".$data->penjamin."</td>";
						$subTotalRow = 0; 
						foreach($thDetail as $key => $val){
							if(!in_array($key, $notCOunt))
								$subTotalRow += ($data->$key);
							
							if($val != 'JUMLAH'){
								echo "<td align='right'>".number_format($data->$key,0,",",".")."&nbsp;</td>";
							} else {
								echo "<td align='right'>".number_format($subTotalRow,0,",",".")."&nbsp;</td>";
							}
							
							if($key != "710")
								$grandTotal[$key] += $data->$key;
							else
								$grandTotal[$key] += $subTotalRow;
						}
						echo "</tr>";
						$tmpTgl = $data->TGL;
					}
				} else {
					echo "<td colspan=".($jml+6)." align='center' style='font-size:18px;' >Tidak Ada Data</td>";
				}
			?>
			<tr style="background:#DDDDDD;">
				<td colspan="3" align='right'><b>JUMLAH SELURUHNYA</b></td>
				<?php
					if(count($grandTotal) > 0)
						foreach($grandTotal as $val){
							echo "<td align='right' style='font-weight:bold;'>".number_format($val,0,",",".")."&nbsp;</td>";
						}
					else
						foreach($thDetail as $val){
							echo "<td align='right' style='font-weight:bold;'>".number_format(0,0,",",".")."&nbsp;</td>";
						}
				?>
			</tr>
		</table>
	</div>
	<?php 
		// print_r($subTotal);
	?>
</body>
</html>
<?php
	session_start();
	include("../sesi.php");
	include("../koneksi/konek.php");
	// include("konek.php");
	// if($_POST['export']=='excel'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Keterangan Saldo Uang Muka.xls"');//decyber
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
	<title>Keterangan Saldo Uang Muka</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:11px; font-family:arial;}
		table{margin:0; padding:0;}
		table{ border-collapse:collapse; width:60%; text-align:left; }
		th{ text-align:center; }
		th, td { padding:5px; border:1px solid #000; }
		.borderfull{ border:1px solid #000; }
		.noborder{ border:0px; }
		.borderbottom{ border-bottom:1px solid #000; }
		.kanan{ text-align:right; }
		#container{ text-align:center; margin:20px; }
		#judul{ text-align:center; width:60%; font-size:18px; }
		.topbottom{ border-top:1px solid #000; border-bottom:1px solid #000; border-left:0px; border-right:0px; }
	</style>
</head>
<body>
	<div id="container">
		<header id="judul">
			<div style="width:100%; text-align:left; font-size:12px; margin-bottom:20px;">
				PT. PELABUHAN INDONESIA I (PERSERO)<br />
				<?php echo $namaRS; ?>
			</div>
			<div>
				<b style="font-size:20px;" >KETERANGAN SALDO UANG MUKA<br /></b>
				<?php echo $Periode; ?>
				<br />
				<br />
			</div>
		</header>
		<table id="dataNilai">
			<tr style="background:#ECECEC;">
				<th>No</th>
				<th>Nama Pengambil<br />Uang Muka</th>
				<th width='120'>Jumlah</th>
				<th width='100'>Tgl.<br />Pengambilan</th>
				<th width='100'>Tgl. Jatuh<br />Tempo</th>
			</tr>
			<?php
				$sql = "SELECT s.MA_ID, s.MA_KODE, s.MA_NAMA, j.TR_ID, j.TGL, j.TGL_ACT, j.URAIAN, j.DEBIT, j.KREDIT
						FROM ma_sak s
						LEFT JOIN jurnal j ON j.FK_SAK = s.MA_ID {$waktu}
						WHERE s.MA_PARENT_KODE = '1.1.20'
						ORDER BY s.MA_ID, j.TGL";
						// echo $sql."<br>".$flag;
				$query = mysql_query($sql);
				if($query && mysql_num_rows($query) > 0){
					$kode = $tmpHead = "";
					$subTotal = 0;
					$no = 1;
					while($data = mysql_fetch_object($query)){
						$kode = str_replace(".00.00", "", $data->MA_KODE);
						$kode = str_replace(".00", "", $kode);
						
						if($tmpHead != "" && $tmpHead != $kode){
							$no = 1;
							if($subTotal > 0){
								echo "<tr>";
								echo "<td colspan='2' style='font-weight:bold;' align='right'>Jumlah {$tmpHead}</td>";
								echo "<td align='right'>".number_format($subTotal,0,",",".")."&nbsp;</td>";
								echo "<td></td><td></td>";
								echo "</tr>";
							}
							
							echo "<tr>";
							echo "<td align='center' style='font-weight:bold;'>{$kode}</td>";
							echo "<td style='font-weight:bold;'>".$data->MA_NAMA."</td>";
							echo "<td></td><td></td><td></td>";
							echo "</tr>";
							
							if($data->TR_ID != ""){
								echo "<tr>";
								echo "<td align='center'>".$no++."</td>";
								echo "<td>".$data->URAIAN."</td>";
								echo "<td align='right'>".number_format($data->DEBIT,0,",",".")."&nbsp;</td>";
								echo "<td align='center'>".tglSQL($data->TGL)."</td>";
								echo "<td align='center'></td>";
								echo "</tr>";
							}
							
							$grandTotal += $subTotal;
							$subTotal = 0;
						} else {
							if($tmpHead == ''){
								echo "<tr>";
								echo "<td align='center' style='font-weight:bold;'>{$kode}</td>";
								echo "<td style='font-weight:bold;'>".$data->MA_NAMA."</td>";
								echo "<td></td><td></td><td></td>";
								echo "</tr>";
								echo "<tr>";
								$no = 1;
							}
							
							if($data->TR_ID != ""){
								echo "<td align='center'>".$no++."</td>";
								echo "<td>".$data->URAIAN."</td>";
								echo "<td align='right'>".number_format($data->DEBIT,0,",",".")."&nbsp;</td>";
								echo "<td align='center'>".tglSQL($data->TGL)."</td>";
								echo "<td align='center'></td>";
								echo "</tr>";
							}
						}						
						$subTotal += $data->DEBIT;
						$tmpHead = $kode;
					}
				}
			?>
			<tr style="background:#F6F6F6;">
				<td colspan="2" align='right'><b>JUMLAH</b></td>
				<td align='right' style='font-weight:bold;'><?php echo number_format($grandTotal,0,",","."); ?></td>
			</tr>
		</table>
	</div>
	<?php 
		// print_r($subTotal);
	?>
</body>
</html>
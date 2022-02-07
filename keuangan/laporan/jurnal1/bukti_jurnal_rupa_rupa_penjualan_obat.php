<?php
	session_start();
	include("../../sesi.php");
	include("../../koneksi/konek.php");
	// include("konek.php");
	// if($_POST['export']=='excel'){
		// header("Content-type: application/vnd.ms-excel");
		// header('Content-Disposition: attachment; filename="Bukti Jurnal Rupa - Rupa.xls"');
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
	<title>Bukti Jurnal Rupa - Rupa</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:12px; font-family:arial;}
		table{ margin:0; padding:0; border-collapse:collapse; width:100%; text-align:left; border:1px solid #000; }
		th{ text-align:center; background:#ececec; border-bottom:1px solid #000; }
		th, td { padding:5px; }
		.borderfull{ border:1px solid #000; }
		.noborder{ border:0px; }
		.bordertop{ border-top:1px solid #000; }
		.borderbottom{ border-bottom:1px solid #000; }
		.borderright{ border-right:1px solid #000; }
		.borderleft{ border-left:1px solid #000; }
		.kanan{ text-align:right; }
		#container{ text-align:center; margin:20px auto; width:70%; }
		#judul{ text-align:center; width:60%; font-size:18px; font-weight:bold; background:#ececec; }
		.topbottom{ border-top:1px solid #000; border-bottom:1px solid #000; border-left:0px; border-right:0px; }
		#paraf td { border:1px solid #000; }
		#paraf table {}
	</style>
</head>
<body>
	<!--font style="font-size:20px; text-align:left; font-weight:bold; color:red;">WARNING : DATA MASIH DUMMIE, INI CUMA CONTOH FORMAT LAPORAN</font-->
	<div id="container">
		<?php
			$id_posting = $_REQUEST['id_posting'];
			$tanggal_posting = $_REQUEST['tanggal'];
			$notrans_kw = $_REQUEST['notrans_kw'];
			
			if (isset($id_posting)){
				$sql = "SELECT j.*, s.MA_ID, s.MA_KODE, s.MA_KODE_KP, s.MA_PARENT_KODE, s.MA_PARENT, 
							s.MA_NAMA, bj.id, bj.kode, bj.parent_kode, bj.nama, 
							CONCAT(s.MA_KODE, ' .',IFNULL(bj.kode,'00.00.00'),'.04') fullkode
						FROM $dbakuntansi.jurnal j
						INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
						LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj ON bj.id = j.MS_BEBAN_JENIS_ID
						WHERE j.FK_ID_POSTING = '{$id_posting}' 
						  /*AND j.TGL_ACT = '{$tanggal_posting}'
						  AND j.POSTING = 1*/
						ORDER BY j.D_K, j.TR_ID";
			}else{
				$tmp_notrans_kw=explode("|",$notrans_kw);
				$sql = "SELECT
						  j.*,
						  s.MA_ID,
						  s.MA_KODE,
						  s.MA_KODE_KP,
						  s.MA_PARENT_KODE,
						  s.MA_PARENT,
						  s.MA_NAMA,
						  bj.id,
						  bj.kode,
						  bj.parent_kode,
						  bj.nama,
						  CONCAT(s.MA_KODE_KP, ' .',IFNULL(bj.kode,'00.00.00'),'.04')    fullkode
						FROM $dbakuntansi.jurnal j
						  INNER JOIN $dbakuntansi.ma_sak s
							ON s.MA_ID = j.FK_SAK
						  LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj
							ON bj.id = j.MS_BEBAN_JENIS_ID
						WHERE j.NO_TRANS = '{$tmp_notrans_kw[0]}'
						AND j.NO_KW = '{$tmp_notrans_kw[1]}'
						/*AND j.TGL = '{$tanggal_posting}' AND j.POSTING = 1*/
						ORDER BY j.D_K ASC, s.MA_KODE ASC";
			}
			//echo $sql.";<br>";
			$query = mysql_query($sql);
			$dataKosong = true;
			$alamat = "Medan";
			$kepada = "Dr. YUSMARDIANNIE, M. Kes";
			$uraian = $nobukti = "";
			$total = array();
			$arrData = array();
			if($query && mysql_num_rows($query) > 0){
				$i=0;
				while($data = mysql_fetch_object($query)){
					$i++;
					$arrData[$data->D_K][$data->fullkode ."|$i"] += ($data->D_K == 'D' ? $data->DEBIT : $data->KREDIT);
					//echo $data->fullkode."<br>";
					if($data->D_K == 'D'){
						$total['debit'] += $data->DEBIT;
					} else {
						$total['kredit'] += $data->KREDIT;
					}
					
					$uraian = $data->URAIAN;
					$nobukti = $data->NO_BUKTI;
					$tgl_Post = tglSQL($data->TGL_ACT);
				}
				$dataKosong = false;
				//print_r($arrData);
			}
		?>
		<table id="dataNilai" align="center">
			<tr>
				<td colspan="8" >
				<!--	PT. PELABUHAN INDONESIA I (PERSERO)<br />
				<?php echo $namaRS; ?>-->
				<img src="../../../inc/images/logo_br.png" width="250"/>
				<br />
				<div align="right">NO. <?php echo $nobukti; ?></div>
				
				</td>
			</tr>
			
			<tr><td colspan="8"></td></tr>
			<tr><td colspan="8" id="judul">BUKTI JURNAL RUPA - RUPA</td></tr>
			<tr><td colspan="8" class="borderbottom" align="right">CURRENCY : IDR</td></tr>
			<tr><td colspan="8"></td></tr>
			<tr>
				<td width='20' align='center'>1.</td>
				<td colspan="8">Harap dibukukan pemakaian persedian obat atas transaksi penjualan sebagai berikut &nbsp; : </td>
			</tr>
			<tr>
				<td align='center'>2.</td>
				<td width="170">Nilai</td>
				<td align='center' width="5">:</td>
				<td colspan="5">Rp <?php echo number_format($total['debit'],0,",","."); ?>,-</td>
			</tr>
			<tr>
				<td align='center'>3.</td>
				<td>Terbilang</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo ucwords(terbilang($total['debit'])); ?></td>
			</tr>
			<tr>
				<td align='center'>4.</td>
				<td>Uraian</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo $uraian; ?></td>
			</tr>
			<tr>
				<td align='center'>5.</td>
				<td>Bukti Pendukung</td>
				<td align='center'>:</td>
				<td colspan="5">Terlampir</td>
			</tr>
			<tr class='borderbottom'><td colspan="8"></td></tr>
			<tr class='borderbottom'><td colspan="8" align="center"><h3 style="margin:3px;">KODE DAN NAMA REKENING</h3></td></tr>
			<tr>
				<th width="20">No</th>
				<th colspan="3">Kode Rekening</th>
				<th colspan="2" class="borderright">Debit Buku Jurnal</th>
				<th colspan="2">Kredit Buku Jurnal</th>
			</tr>
			<tr><td colspan="6" class="borderright"></td><td colspan="2"></td></tr>
			<?php
				$subTotal = 0;
				$cekJenis = "";
				if($dataKosong == false){
					$no = 1;
					foreach($arrData as $DK => $val){
						foreach($val as $kode => $data){
							$debit = ($DK == 'D' ? number_format($data,0,",",".") : '-');
							$kredit = ($DK == 'K' ? number_format($data,0,",",".") : '-');
							
							$tmpKode = explode('|',$kode);
							$kodeRek = $tmpKode[0];
							
/*							if($cekJenis != "" && $cekJenis != $tmpKode[1]){
								echo "<tr>";
								echo "<td align='center'></td>";
								echo "<td align='left' colspan='3'></td>";
								echo "<td width='20' class='borderbottom bordertop'>Rp</td>";
								echo "<td align='right' class='borderright borderbottom bordertop'>".($tmpDK == 'D' ? number_format($subTotal,0,",",".") : '-')."</td>";
								echo "<td width='20' class='borderbottom bordertop'>Rp</td>";
								echo "<td align='right' class='borderbottom bordertop'>".($tmpDK == 'K' ? number_format($subTotal,0,",",".") : '-')."</td>";
								echo "</tr>";
								
								
								echo "<tr>";
								echo "<td align='center'>&nbsp;</td>";
								echo "<td align='left' colspan='3'></td>"; //."."." ".$data->nama
								echo "<td width='20'></td>";
								echo "<td align='right' class='borderright'></td>";
								echo "<td width='20'></td>";
								echo "<td align='right'></td>";
								echo "</tr>";
							
								$subTotal = 0;
								$no = 1;
							}*/
							
							echo "<tr>";
							echo "<td align='center'>".$no++.".</td>";
							echo "<td align='left' colspan='3'>".$kodeRek."</td>"; //."."." ".$data->nama
							echo "<td width='20'>Rp</td>";
							echo "<td align='right' class='borderright'>".$debit."</td>";
							echo "<td width='20'>Rp</td>";
							echo "<td align='right'>".$kredit."</td>";
							echo "</tr>";
							
							$subTotal += $data;
							//$cekJenis = $tmpKode[1];
							$tmpDK = $DK;
						}
					}
				}
			?>
			<tr style="font-weight:bold">
				<td colspan="4" align="right">Jumlah</td>
				<td width="20" class="bordertop">Rp</td>
				<td width="150" align="right" class="borderright bordertop"><?php echo number_format($total['debit'],0,",","."); ?></td>
				<td width="20" class="bordertop">Rp</td>
				<td width="150" align="right" class="bordertop"><?php echo number_format($total['debit'],0,",","."); ?></td>
			</tr>
			<tr class='bordertop'><td colspan="8">&nbsp;</td></tr>
		</table>
		<table id="paraf">
			<tr>
				<td style="background:#ececec; font-weight:bold;" width="100" rowspan="2" align="center" >Tahapan</td>
				<td style="background:#ececec; font-weight:bold;" colspan="2" align="center">Masuk</td>
				<td style="background:#ececec; font-weight:bold;" colspan="2" align="center">Keluar</td>
				<td rowspan="6" colspan="3" align="center">
					<br />
					BELAWAN, <?php echo $tgl_Post; ?>
					<br />
					<?php echo $namaRS; ?>
					<br />
					<?php echo $pejabat_ttd; ?>
					<br />
					<br />
					<br />
					<br />
					<br />
					<?php echo $pejabat_ttd_nama; ?>
				</td>
			</tr>
			<tr style="background:#ececec; font-weight:bold;">
				<td width="100" align="center">Tgl</td>
				<td width="100" align="center">Paraf</td>
				<td width="100" align="center">Tgl</td>
				<td width="100" align="center">Paraf</td>
			</tr>
			<tr>
				<td>Pembuat</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Verifikasi</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>D1</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>D2</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>D3</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td rowspan="3" colspan="3" align="center">
					
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="8" align="center">K E T E R A N G A N</td>
			</tr>
			<tr>
				<td colspan="2">a. &nbsp; Status Posting</td>
				<td colspan="3"></td>
				<td rowspan="2" colspan="3" align="center">
					c. &nbsp; Paraf Petugas Posting
					<br />
					( ......................................................................... )
				</td>
			</tr>
			<tr>
				<td colspan="2">b. &nbsp; Tanggal Posting</td>
				<td colspan="3"></td>
			</tr>
		</table>
	</div>
	<?php 
		// print_r($subTotal);
	?>
</body>
</html>
<?php
	session_start();
	include("../../sesi.php");
	include("../../koneksi/konek.php");
	// include("konek.php");
	// if($_POST['export']=='excel'){
		// header("Content-type: application/vnd.ms-excel");
		// header('Content-Disposition: attachment; filename="Bukti Jurnal Pembelian.xls"');
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
	<title>Bukti Jurnal Pembelian</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:12px; font-family:arial;}
		table{margin:0; padding:0;}
		table{ border-collapse:collapse; width:100%; text-align:left;}
		th{ text-align:center; }
		th { padding:5px; border:1px solid #000; }
		td { padding:5px; }
		.borderfull{ border:1px solid #000; }
		.noborder{ border:0px; }
		.bordertop{ border-top:1px solid #000; }
		.borderbottom{ border-bottom:1px solid #000; }
		.borderright{ border-right:1px solid #000; }
		.borderleft{ border-left:1px solid #000; }
		.kanan{ text-align:right; }
		#container{ text-align:center; margin:20px auto; width:70%; border:1px solid #000; }
		#judul{ text-align:center; width:60%; font-size:18px; font-weight:bold; background:#ececec; }
		.topbottom{ border-top:1px solid #000; border-bottom:1px solid #000; border-left:0px; border-right:0px; }
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
				$sql = "SELECT j.*,s.*,pbf.PBF_NAMA  
						FROM $dbakuntansi.jurnal j
						INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
						  LEFT JOIN $dbapotek.a_pbf pbf
							ON j.PBF_ID = pbf.PBF_ID
						WHERE j.FK_ID_AK_POSTING = '{$id_posting}' 
						  /*AND j.TGL_ACT = '{$tanggal_posting}'
						  AND j.POSTING = 1*/
						ORDER BY D_K, TR_ID";
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
			$uraian = $nokwi = "";
			if($query && mysql_num_rows($query) > 0){				
				$kredit = $debit = array();
				$pbf_nama="";
				while($data = mysql_fetch_object($query)){
					if($data->D_K == "D"){
						$debit['jurnal'][$data->MA_PARENT_KODE] += $data->DEBIT;
						$debit['bantu'][$data->MA_KODE_KP] += $data->DEBIT;
					} else {
						$kredit['jurnal'][$data->MA_PARENT_KODE] += $data->KREDIT;
						$kredit['bantu'][$data->MA_KODE_KP] += $data->KREDIT;
						$kredit['rek_nama'][$data->MA_NAMA] += $data->PBF_NAMA;
						if ($data->PBF_NAMA !="") $pbf_nama = $data->PBF_NAMA;
					}
					$uraian = $data->URAIAN;
					$nokwi = $data->NO_KW;
					$tgl_verif = tglSQL($data->TGL_ACT);
					$no_spk = $data->NO_BUKTI;
				}
				$dataKosong = false;
			}
			
		  	//=====Bilangan setelah koma=====
			$htot = array_sum($debit['jurnal']);
		  	$sakKomane=explode(".",$htot);
		  	$koma=$sakKomane[1];
		  	$koma=terbilang($koma,3);
		  	if($sakKomane[1]<>"") $koma= " Koma ".$koma; else $koma= "";
			
			//$keys = array_keys($kredit['jurnal']);
			$keys = array_keys($kredit['bantu']);
			$rek_nama = array_keys($kredit['rek_nama']);
		?>
		<table id="dataNilai" align="center">
			<tr>
				<td colspan="8" >
				<!--	PT. PELABUHAN INDONESIA I (PERSERO)<br />
				<?php echo $namaRS; ?>-->
				<img src="../../../inc/images/logo_br.gif" width="250"/>
				<br />
				<div align="right">NO. <?php echo $nokwi; ?></div></td>
			</tr>
			
			<tr><td colspan="8"></td></tr>
			<tr><td colspan="8" id="judul">BUKTI JURNAL PEMBELIAN / PEMBORONGAN</td></tr>
			<tr><td colspan="8"></td></tr>
			<tr>
				<td width='5' align='center'>1.</td>
				<td width='170' >Harap dibukukan hutang sebesar</td>
				<td width='5' align='center'>:</td>
				<td colspan="5">Rp <?php echo number_format($htot,2,",","."); ?>,-</td>
			</tr>
			<tr>
				<td align='center'>2.</td>
				<td>Terbilang</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo ucwords(terbilang($htot)).$koma." Rupiah"; ?></td>
			</tr>
			<tr>
				<td align='center'>3.</td>
				<td>Nama Rekening</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo $rek_nama[0]." (".$pbf_nama.")"; ?></td>
			</tr>
			<tr>
				<td align='center'>4.</td>
				<td>Nomor Buku Hutang</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo $keys[0]; ?></td>
			</tr>
			<tr>
				<td align='center'>5.</td>
				<td>Uraian</td>
				<td align='center'>:</td>
				<td colspan="5"><?php echo $uraian; ?></td>
			</tr>
			<tr class='borderbottom'><td colspan="8"></td></tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td width="90"></td>
				<td width="90" class='borderright'></td>
				<td colspan="3" rowspan="12" valign="top" style="width:10%">
					<?php if($dataKosong == false){ ?>
						<table id="detail_data">
							<tr><td colspan="4" align="center">Nomor & Nama Rekening</td></tr>
							<tr><td colspan="4">DEBET Buku Jurnal</td></tr>
							<?php
								//foreach($debit['jurnal'] as $key => $val){
								foreach($debit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='20'>Rp</td>";
									echo "<td width='100' align='right'>".number_format($val,2,",",".")."</td>";
									echo "<td></td>";
									echo "</tr>";
								}
							?>
							<tr><td colspan="4">&nbsp;</td></tr>
                            <!--tr><td colspan="4">DEBET Buku Bantu</td></tr-->
							<?php
								/*foreach($debit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='20'>Rp</td>";
									echo "<td width='100' align='right'>".number_format($val,2,",",".")."</td>";
									echo "<td></td>";
									echo "</tr>";
								}*/
							?>
							<tr><td colspan="4">KREDIT Buku Hutang</td></tr>
							<?php
								//foreach($kredit['jurnal'] as $key => $val){
								foreach($kredit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='20'>Rp</td>";
									echo "<td width='100' align='right'>".number_format($val,2,",",".")."</td>";
									echo "<td></td>";
									echo "</tr>";
								}
							?>
							<tr><td colspan="4">&nbsp;</td></tr>
                            <!--tr><td colspan="4">KREDIT Buku Bantu</td></tr-->
							<?php
								/*foreach($kredit['bantu'] as $key => $val){
									echo "<tr>";
									echo "<td width='200'>- &nbsp; ".$key."</td>";
									echo "<td width='20'>Rp</td>";
									echo "<td width='100' align='right'>".number_format($val,2,",",".")."</td>";
									echo "<td></td>";
									echo "</tr>";
								}*/
							?>
						</table>
					<?php } else { echo "<h4>Tidak Ada Data!</h4>"; } ?>				</td>
			</tr>
			<tr><td colspan="5" class='borderright'>Bukti Pendukung</td></tr>
			<tr>
				<td colspan="3"></td>
				<td align="center">Nomor</td>
				<td align="center" class='borderright'>Tanggal</td>
			</tr>
			<tr>
				<td colspan="2">Faktur / Kwitansi</td>
				<td align='center'>:</td>
				<td align="center" style='padding:0px' ><?php echo $nokwi; ?></td>
				<td align="center" style='padding:0px' class='borderright'>............................</td>
			</tr>
			<tr>
				<td colspan="2">SP / SPK</td>
				<td align='center'>:</td>
				<td align="center" style='padding:0px'><?php echo $no_spk; ?></td>
				<td align="center" style='padding:0px' class='borderright'>............................</td>
			</tr>
			<tr>
				<td colspan="2">Kontrak</td>
				<td align='center'>:</td>
				<td align="center" style='padding:0px'>............................</td>
				<td align="center" style='padding:0px' class='borderright'>............................</td>
			</tr>
			<tr>
				<td colspan="2">Bukti Lain-Lain</td>
				<td align='center'>:</td>
				<td align="center" style='padding:0px'>............................</td>
				<td align="center" style='padding:0px' class='borderright'>............................</td>
			</tr>
			<tr><td class='borderright' colspan="5"></td></tr>
			<tr><td class='borderright borderbottom' colspan="5"></td></tr>
			<tr>
				<td class="borderright" colspan="3" rowspan="2" valign="bottom">Telah Dibukukan</td>
				<td class="borderright" align="center" >Buku</td>
				<td class="borderright" align="center" >Buku</td>
			</tr>
			<tr>
				<td class="borderright borderbottom" align="center" >Jurnal</td>
				<td class="borderright borderbottom" align="center" >Bantu</td>
			</tr>
			<tr>
				<td class="borderright" colspan="3">Tanggal </td>
				<td class="borderright borderbottom" align="center" ></td>
				<td class="borderright borderbottom" align="center" class='borderright' ></td>
			</tr>
			<tr>
				<td class="borderright borderbottom" colspan="3">Paraf</td>
				<td class="borderright borderbottom" align="center" ></td>
				<td class="borderright borderbottom" align="center" class='borderright' ></td>
			</tr>
			<tr><td colspan="5" align="center" valign="middle" class="borderbottom borderright">BUKTI PROSES KEUANGAN</td></tr>
			<tr>
				<td class="borderright" colspan="3">Tahapan</td>
				<td class="borderright borderbottom"></td>
				<td class="borderright borderbottom"></td>
			</tr>
			<tr>
				<td class="borderright" colspan="3">Pembuat</td>
				<td class="borderright borderbottom"></td>
				<td class="borderright borderbottom"></td>
			</tr>
			<tr>
				<td class="borderright" colspan="3">D.I</td>
				<td class="borderright borderbottom"></td>
				<td class="borderright borderbottom"></td>
				<td colspan="3" rowspan="8" align="center" class="bordertop">
					<br />
					BELAWAN, <?php echo "..................................."; //$tgl_verif; ?>
					<br />
					<?php echo $namaRS?>
					<br />
					<?php echo $pejabat_ttd_jrr; ?>
					<br />
					<br />
					<br />
					<br />
					<br />
					<?php echo $pejabat_ttd_nama_jrr; ?>
					<br />
					<br />				</td>
			</tr>
			<tr>
				<td class="borderright" colspan="3">D.II</td>
				<td class="borderright borderbottom"></td>
				<td class="borderright borderbottom"></td>
			</tr>
			<tr>
				<td class="borderright borderbottom" colspan="3">Verifikasi</td>
				<td class="borderright borderbottom"><?php echo $tgl_verif; ?></td>
				<td class="borderright borderbottom"><?php echo $tgl_verif; ?></td>
			</tr>
			<tr>
				<td class="borderright" colspan="5">&nbsp;</td>
			</tr>
		</table>
	</div>
	<?php 
		// print_r($subTotal);
	?>
</body>
</html>
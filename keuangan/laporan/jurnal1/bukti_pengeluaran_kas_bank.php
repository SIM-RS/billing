<?php
	session_start();
	include("../../sesi.php");
	include("../../koneksi/konek.php");
	// include("konek.php");
	// if($_POST['export']=='excel'){
		// header("Content-type: application/vnd.ms-excel");
		// header('Content-Disposition: attachment; filename="Bukti Pengeluaran Kas - Bank.xls"');
	// }
	$wkttgl=gmdate('d M Y',mktime(date('H')+7));
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
	<title>Bukti Pengeluaran Kas Bank</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:12px; font-family:arial;}
		table{margin:0; padding:0;}
		table{ border-collapse:collapse; width:100%; text-align:left; }
		th{ text-align:center; backgound:#ececec; }
		th, td { padding:5px; }
		.borderfull{ border:1px solid #000; }
		.noborder{ border:0px; }
		.bordertop{ border-top:1px solid #000; }
		.borderbottom{ border-bottom:1px solid #000; }
		.borderright{ border-right:1px solid #000; }
		.kanan{ text-align:right; }
		#container{ text-align:center; margin:20px auto; width:70%; }
		#judul{ text-align:center; width:100%; font-size:18px; }
		.topbottom{ border-top:1px solid #000; border-bottom:1px solid #000; border-left:0px; border-right:0px; }
		.nodata{ font-size:18px; font-weight:bold; }
		#paraf td{ border:1px solid #000; }
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
						CONCAT(s.MA_KODE_KP, ' .',IFNULL(bj.kode,'00.00.00'),'.04') fullkode
						FROM $dbakuntansi.jurnal j
						INNER JOIN $dbakuntansi.ma_sak s ON s.MA_ID = j.FK_SAK
						LEFT JOIN $dbakuntansi.ak_ms_beban_jenis bj ON bj.id = j.MS_BEBAN_JENIS_ID
						WHERE j.FK_ID_POSTING = '{$id_posting}' 
						  /*AND j.TGL = '{$tanggal_posting}'*/
						  AND j.POSTING = 1
						ORDER BY j.D_K ASC, s.MA_KODE ASC";
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
			$alamat = $kepada = $uraian = $nobukti = "";
			$total = array();
			$arrData = array();
			if($query && mysql_num_rows($query) > 0){
				while($data = mysql_fetch_object($query)){
					$arrData[$data->D_K][$data->fullkode] += ($data->D_K == 'D' ? $data->DEBIT : $data->KREDIT);
					
					if($data->D_K == 'D'){
						$total['debit'] += $data->DEBIT;
					} else {
						$total['kredit'] += $data->KREDIT;
					}
					
					$uraian = $data->URAIAN;
					$kepada = $data->KEPADA;
					$alamat = $data->ALAMAT;
					$nobukti = $data->NO_KW;
					$tgl_Post = tglSQL($data->TGL_ACT);
				}
				$dataKosong = false;
			}
		?>
		<header id="judul">
			<div style="width:100%; text-align:left; font-size:12px; margin-bottom:20px;">
				<!--PT. PELABUHAN INDONESIA I (PERSERO)<br />
				<?php echo $namaRS; ?> -->
				<img src="../../../inc/images/logo_br.png" width="250"/>
				<br />
				<div align="right">NO BUKTI : <?php echo $nobukti; ?></div>
		  </div>
			<div>
				<b style="font-size:20px;" >BUKTI PENGELUARAN KAS - BANK<br /></b>
			</div>
			<div align="right" style="font-size:14px;">CURRENCY : IDR</div>
		</header>
		<table id="detail" class="borderfull">
			<tr>
				<td width="10">1.</td>
				<td colspan="3">Pemegang Kas Harap Mengeluarkan Uang Sebesar &nbsp; : &nbsp; <b>Rp <?php echo number_format($total['debit'],0,",","."); ?>,-</b></td>
			</tr>
			<tr>
				<td valign="top">2.</td>
				<td width="200" valign="top">Terbilang</td>
				<td valign="top">:</td>
				<td valign="top"><?php echo ucwords(terbilang($total['debit'])." Rupiah."); ?></td>
			</tr>
			<tr>
				<td>3.</td>
				<td>Kepada</td>
				<td>:</td>
				<td><?php echo $kepada; ?></td>
			</tr>
			<tr>
				<td>4.</td>
				<td>Alamat</td>
				<td>:</td>
				<td><?php echo $alamat; ?></td>
			</tr>
			<tr>
				<td valign="top">5.</td>
				<td valign="top">Uraian</td>
				<td valign="top">:</td>
				<td valign="top"><?php echo $uraian; ?></td>
			</tr>
			<tr>
				<td>6.</td>
				<td>Bukti Pendukung</td>
				<td>:</td>
				<td>Daftar Pembayaran</td>
			</tr>
		</table>
		<h3>KODE DAN NAMA REKENING</h3>
		<table id="dataNilai" class="borderfull">
			<tr style="background:#ECECEC;" class="borderbottom">
				<th width="20">No</th>
				<th>Kode Rekening</th>
				<th width="50" colspan="2">Debit Buku Jurnal</th>
				<th width="50" colspan="2">Kredit Buku Jurnal</th>
			</tr>
			<?php
				if($dataKosong == false){
					$no = 1;
					// while($data = mysql_fetch_object($query)){
					foreach($arrData as $DK => $val){
						foreach($val as $key => $data){
							$debit = ($DK == 'D' ? number_format($data,0,",",".") : '-');
							$kredit = ($DK == 'K' ? number_format($data,0,",",".") : '-');
							
							echo "<tr>";
							echo "<td align='center'>".$no++.".</td>";
							echo "<td align='left'>".$key."</td>"; //."."." ".$data->nama
							echo "<td width='20'>Rp</td>";
							echo "<td align='right' class='borderright'>".$debit."</td>";
							echo "<td width='20'>Rp</td>";
							echo "<td align='right'>".$kredit."</td>";
							echo "</tr>";
						}
					}
				} else {
					echo "<tr><td colspan='6' class='nodata' align='center'></td></tr>";
				}
			?>
			<?php ?>
			<tr style="background:#F6F6F6;">
				<td colspan="2" align='right'><b>JUMLAH</b></td>
				<td class="bordertop">Rp</td>
				<td class="bordertop" align='right' style='font-weight:bold;'><?php echo number_format($total['debit'],0,",","."); ?></td>
				<td class="bordertop">Rp</td>
				<td class="bordertop" align='right' style='font-weight:bold;'><?php echo number_format($total['kredit'],0,",","."); ?></td>
			</tr>
		</table>
		<br />
		<table id="paraf">
			<tr>
				<td width="100" rowspan="2" align="center" >Tahapan</td>
				<td colspan="2" align="center">Masuk</td>
				<td colspan="2" align="center">Keluar</td>
				<td rowspan="6" align="center">
					<br />
					BELAWAN, <?php echo $wkttgl; ?>
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
			<tr>
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
			<tr><td colspan="5" align="center">PEMBUKUAN</td></tr>
			<tr>
				<td>Kasir</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td rowspan="3" align="center">
					UANG TELAH DITERIMA OLEH
					<br />
					<br />
					<br />
					( ..................................................................................................... )
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
				<td colspan="6" align="center">K E T E R A N G A N</td>
			</tr>
			<tr>
				<td colspan="2">a. &nbsp; Status Posting</td>
				<td colspan="3"></td>
				<td rowspan="2" align="center">
					c. &nbsp; Paraf Petugas Posting
					<br />
					( ..................................................................................................... )
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
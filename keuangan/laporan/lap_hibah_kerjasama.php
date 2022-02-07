<?php
	include("../sesi.php");
	include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
	
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND t.tgl = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$tglAwal2 = "$thn-$cbln-01";
		$tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND t.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND t.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$jenisPend = $_REQUEST['jenisPend'];
	$tipe = $_REQUEST['tipe'];
	
	$title = "Penerimaan ";
	if($tipe == 1){
		$title = "Pendapatan ";
	}
	
	$titlejenis = $title."Hibah";
	if($jenisPend == 3){
		$titlejenis = $title."Kerjasama";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titlejenis; ?></title>
	<style type="text/css">
		#tableMain{
			border-collapse:collapse;
		}
		#tableMain td{
			border:1px solid #000;
			padding:3px;
		}
	</style>
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
		<tr>
			<td><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
		</tr>
		<tr>
			<td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top"><?php echo $titlejenis;?><br /><?php echo $Periode;?></td>
		</tr>
		<tr>
			<td>
				<table id="tableMain" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
					<tr style="text-align:center; font-weight:bold">
						<td width="30" >NO</td>
						<td width="80">TANGGAL SETOR</td>
						<td width="100" >NO BUKTI</td>
						<td width="250" >JENIS PENDAPATAN</td>
						<td width="120" >NILAI</td>
						<td width="200" >KETERANGAN</td>
					</tr>
					<?php
						$sql = "SELECT t.*, mt.nama
								FROM k_transaksi t
								INNER JOIN k_ms_transaksi mt
								   ON mt.id = t.id_trans
								WHERE mt.jenisPendapatan = {$jenisPend}
								  {$waktu} AND t.flag = '$flag'
								ORDER BY t.tgl ASC";
						//echo $sql;
						$query = mysql_query($sql);
						if(mysql_num_rows($query) > 0){
							$no = 1;
							$total = 0;
							while($data = mysql_fetch_array($query)){
								echo "<tr>
									<td align='center'>".$no++."</td>
									<td align='center'>".tglSQL($data['tgl'])."</td>
									<td align='center'>".$data['no_bukti']."</td>
									<td>".$data['nama']."</td>
									<td align='right'>".number_format($data['nilai'], 0, ',', '.')."</td>
									<td>".$data['ket']."</td>
								</tr>";
								$total += $data['nilai'];
							}
						} else {
							echo "<tr>
								<td colspan='6' align='center' >Maaf Data Tidak Ditemukan</td>
							</tr>";
						}
						echo "<tr>
							<td colspan='4' align='right' >Total</td>
							<td align='right'>".number_format($total, 0, ',', '.')."</td>
							<td>&nbsp;</td>
						</tr>";
					?>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
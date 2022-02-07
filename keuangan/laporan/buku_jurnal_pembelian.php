<?php
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Buku Jurnal Pembelian.xls"');		
	}
	
	
	include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
	
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND a_p.TANGGAL = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		$tglAwal2 = "$thn-$cbln-01";
		$tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND a_p.TANGGAL between '$tglAwal2' and '$tglAkhir2' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND a_p.TANGGAL between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo 'Buku jurnal Pembelian'; ?></title>
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
	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="center">
		<tr>
			<td>PT. Prima Husada Cipta Medan</td>
		</tr>
		<tr>
			<td><i> <u> <b> RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN </b> </u> </i></td>
		</tr>
		<tr>
			<td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">
			<u>BUKU JURNAL PEMBELIAN / BORONGAN </u>
			<br />
			<?php echo $Periode;?></td>
		</tr>
		<tr>
			<td>
			
			  <table id="tableMain" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
               
                <tr height="20" style="text-align:center; font-weight:bold" bgcolor="#99FF66">
                  <td rowspan="2" height="68" width="68">TANGGAL</td>
                  <td rowspan="2" width="73">NOMOR BUKTI</td>
                  <td rowspan="2" width="81">NOMOR PENERIMAAN </td>
                  <td rowspan="2" width="112">U   R   A      I   A   N</td>
                  <td colspan="8">D        E     B     E        T</td>
                  <td colspan="2">KREDIT</td>
                  <td rowspan="2" width="102">KETERANGAN</td>
                </tr>
                <tr height="22" align="center" bgcolor="#99FF99">
                  <td width="75">PERSEDIAAN (108)</td>
                  <td width="99">PPN Masukan Yg Dpt Dikreditkan (110)</td>
                  <td width="89">Peralatan (223)</td>
                  <td width="91">Asset Tetap Dalam Konstruksi (331)</td>
                  <td width="106">PERALATAN (214.02)</td>
                  <td width="91">BY. LANGSUNG (810)</td>
                  <td width="95">BY.Ka.RSPM (831)</td>
                  <td width="77">JUMLAH</td>
                  <td width="79">HUTANG USAHA(401)</td>
                  <td width="79">HUTANG PPN (424.04)</td>
                </tr>
                
                <tr height="20" align="center" bgcolor="#CCFF66">
                  <td height="20">1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>9</td>
                  <td>10</td>
                  <td>11</td>
                  <td>12</td>
                  <td>13</td>
                  <td>14</td>
                  <td>15</td>
                </tr>
				
			<?php 
			
				 $sql="select '1' tipe, t1.*, (t1.dpp + t1.ppn) as total,date_format(TANGGAL,'%d-%m-%Y') TANGGAL1 from(SELECT a_p.*,ok.kategori,ab.BENTUK,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,apo.cara_bayar_po,
				SUM(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN) AS subtotal,
				SUM(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)) AS dpp,
				SUM((IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS ppn,
				SUM((((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)))) AS dpp_ppn,
				o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, a_pbf.PBF_NAMA, sd.nama sumberdana, sum(a_p.diskon_rp) total_diskon
				FROM  $dbapotek.a_penerimaan a_p 
				INNER JOIN $dbapotek.a_obat o ON a_p.OBAT_ID=o.OBAT_ID 
				INNER JOIN $dbapotek.a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
				INNER JOIN  $dbapotek.a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID 
				LEFT JOIN (SELECT id, nama FROM $dbapotek.a_sumber_dana) sd ON sd.id = a_p.SUMBER_DANA
				LEFT JOIN  $dbapotek.a_obat_kategori ok ON ok.id = o.OBAT_KATEGORI
				LEFT JOIN  $dbapotek.a_bentuk ab ON ab.BENTUK = o.OBAT_BENTUK
				inner join  $dbapotek.a_po apo ON a_p.FK_MINTA_ID = apo.ID where 0=0 $waktu /*$fkso*/ AND  a_p.TIPE_TRANS=0 group by a_p.NOTERIMA) t1
				";
				
				$query = mysql_query($sql);
				while ($rows=mysql_fetch_array($query)){
				$tanggal = $rows['TANGGAL1'];
				$no_bukti = $rows['NOBUKTI'];
				$no_terima = $rows['NOTERIMA'];
				$uraian = $rows['PBF_NAMA'];
				$persediaan = $rows['subtotal'] - $rows['total_diskon'];
				$ppn = $rows['ppn'];
				$jumlah = $persediaan + $ppn;
				$hutang_usaha = $persediaan;
				$hutang_ppn = $ppn;
				if( $rows['tipe']==1 ){
					$keterangan = 'Pengadaan Obat-obatan';
				}
				
				
				
			
			?>
                <tr height="18">
                  <td align="center" ><?php echo  $tanggal; ?></td>
                  <td align="center"><?php echo  $no_bukti; ?></td>
                  <td align="center"><?php echo  $no_terima; ?></td>
                  <td align="center"><?php echo  $uraian; ?></td>
                  <td align="right"><?php echo number_format($persediaan,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($ppn,0,",","."); ?>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right"><?php echo number_format($jumlah,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($hutang_usaha,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($hutang_ppn,0,",","."); ?>&nbsp;</td>
                  <td align="center"><?php echo $keterangan; ?>&nbsp;</td>
                </tr>
				
			<?php
				$tot_persediaan +=$persediaan;
				$tot_ppn +=$ppn;
				$tot_jumlah +=$jumlah;
				$tot_hutang_usaha +=$hutang_usaha;
				$tot_hutang_ppn +=$hutang_ppn;
			 
				} 
			
			?>
                <tr height="18">
                  <td align="right" colspan="4">Total : </td>
                  <td align="right"><?php echo number_format($tot_persediaan,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($tot_ppn,0,",","."); ?>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right"><?php echo number_format($tot_jumlah,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($tot_hutang_usaha,0,",","."); ?>&nbsp;</td>
                  <td align="right"><?php echo number_format($tot_hutang_ppn,0,",","."); ?>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
			  
			  <!--
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
								  {$waktu}
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
			  </table> -->
		  </td>
		</tr>
	</table>
</body>
</html>
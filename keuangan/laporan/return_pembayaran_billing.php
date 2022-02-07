<?php
	session_start();
	include('../sesi.php');
	include('../koneksi/konek.php');
	$iduser = $_SESSION['id'];
	$tglact=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
	
	/* $tglAwal = $_REQUEST['tglAwal']; $t1 = explode('-',$tglAwal);
	$tgl1 = $t1[2]."-".$t1[1]."-".$t1[0];

	$tglAkhir = $_REQUEST['tglAkhir']; $t2 = explode('-',$tglAkhir);
	$tgl2 = $t2[2]."-".$t2[1]."-".$t2[0]; */
	
	$tipetrans=$_REQUEST['cmbTipeTransObat'];
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
	
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND r.tgl_return = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(r.tgl_return) = '$bln' AND year(r.tgl_return) = '$thn' ";
		$tglAwal2 = "$thn-$cbln-01";
		$tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND r.tgl_return between '$tglAwal2' and '$tglAkhir2' ";
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND r.tgl_return between '$tglAwal2' and '$tglAkhir2' ";
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$sUser = "select nama from k_ms_user ku where ku.id = {$iduser}";
	$qUser = mysql_query($sUser);
	$dUser = mysql_fetch_array($qUser);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Pengembalian Uang Obat</title>
	<style type="text/css">
		body{
			font-family:Arial,Helvetica,sans-serif;
			font-size:11px;
		}
		#content{
			width:1200px;
		}
		#dataIsi {
			border-collapse:collapse;
			width:100%;
		}
		#dataIsi td, #dataIsi th{
			border:1px solid #000;
			padding:5px;
		}
		.tebal{
			font-weight:bold;
		}
		.judul{
			font-size:15px;
		}
	</style>
</head>
<body>
	<div id="content">
		<p class="tebal"><b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></p>
		<p align="center" class="tebal judul">
			LAPORAN PENGEMBALIAN PEMBAYARAN BILLING<br />
			<?php echo $Periode; ?>
		</p>
		<?php			
			$sql = "SELECT
					  p.no_rm, p.nama, p.alamat, p.rt, p.rw, DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl_kunj,
					  DATE_FORMAT(r.tgl_return,'%d-%m-%Y') AS tgl_return, r.id, r.bayar_id, r.no_return,
					  r.nilai_retur, DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tgl_bayar, b.no_kwitansi, b.nilai,
					  mu.nama userAct
					FROM $dbbilling.b_return_pembayaran r
					  INNER JOIN $dbbilling.b_bayar b
						ON b.id = r.bayar_id
					  INNER JOIN $dbbilling.b_kunjungan k
						ON k.id = b.kunjungan_id
					  INNER JOIN $dbbilling.b_ms_pasien p
						ON p.id = k.pasien_id
					  INNER JOIN k_ms_user mu
					     ON mu.id = r.user_act
					WHERE 0 = 0 {$waktu} AND b.flag = '$flag'
					ORDER BY r.no_return, r.tgl_return ASC";
			$no = 1;
			//echo $sql;
			$query = mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($query) > 0){
		?>
		<table id='dataIsi'>
			<tr>
				<th>No.</th>
				<th width="110">Tgl Pengembalian</th>
				<th width="110">No Pengembalian</th>
				<th width="110">Tgl Kunjungan</th>
				<th width="110">Tgl Bayar</th>
				<th width="110">No Bayar</th>
				<th width="80">NoRM</th>
				<th width="160">Nama Pasien</th>
				<th width="80">Nilai Pengembalian</th>
				<th>Petugas</th>
			</tr>
			<?php
				$tmp = '';
				$globTotal = $jml = 0;
				$nodalam = 1;
				while($data = mysql_fetch_object($query)){
			?>
			<tr>
				<td align="center"><?php echo $nodalam++; ?></td>
				<td align="center"><?php echo $data->tgl_return; ?></td>
				<td align="center"><?php echo $data->no_return; ?></td>
				<td align="center"><?php echo $data->tgl_kunj; ?></td>
				<td align="center"><?php echo $data->tgl_bayar; ?></td>
				<td align="center"><?php echo $data->no_kwitansi; ?></td>
				<td align="center"><?php echo $data->no_rm; ?></td>
				<td align="left"><?php echo $data->nama; ?></td>
				<td align="right"><?php echo number_format($data->nilai_retur,2,',','.'); ?></td>
				<td align="center"><?php echo $data->userAct; ?></td>
			</tr>
			<?php
					$no++;
					$jml += $data->nilai_retur;
				}
			?>
			<tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?php echo number_format($jml,2,',','.'); ?></td>
				<td>&nbsp;</td>
				<!--td>&nbsp;</td-->
			</tr>
			<tr>
				<td colspan="7" style='border:0px;' ></td>
				<td colspan="3" style='border:0px;' align="center">
					Tgl Cetak, <?php echo $tglact; ?><br />
					Petugas Cetak<br />
					<br />
					<br />
					<br />
					(<?php echo $dUser['nama']; ?>)
				</td>
			</tr>
		</table>
		<?php
			} else {
			echo "<p align='center' class='judul'><br />Tidak Ada Data Pengembalian Retur Obat Pada {$Periode}</p>";
			}
		?>
	</div>
</body>
</html>
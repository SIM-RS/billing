<?php
	session_start();
	include_once('../koneksi/konek.php');
	$tglact=gmdate('d/m/Y H:i:s',mktime(date('H')+7));
	
	/* Parameter */
	$idunit = $_REQUEST['idunit'];
	$tgl_s = $_REQUEST['tgl_s'];
	$tgl_d = $_REQUEST['tgl_d'];
	$filter = $_REQUEST['filter'];
	$sorting = $_REQUEST['sorting'];
	$jenis_penerimaan = ($_REQUEST["jenis_penerimaan"] != "")? $_REQUEST["jenis_penerimaan"] : '0';
	
	/* get unit */
	$sUnit = "select UNIT_NAME from a_unit where UNIT_ID = {$idunit}";
	$qUnit = mysqli_query($konek,$sUnit);
	$dUnit = mysqli_fetch_array($qUnit);

	/* get user cetak */
	$sUser = "select username from a_user where kode_user = ".$_SESSION['iduser'];
	$qUser =  mysqli_query($konek,$sUser);
	$dUser = mysqli_fetch_array($qUser);
	$username = $dUser['username'];
	
	/* cek param unit */
	if ($idunit=="0"){
		$tmpunit="";
		$tmpunit2="";
	}else{
		$tmpunit=" ap.UNIT_ID = '{$idunit}' AND ";
		$tmpunit2="AND ap.UNIT_ID = '{$idunit}' ";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Penerimaan Apotek</title>
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
	</script>
	<style type="text/css">
		body{
			font-family:Verdana,Arial,Helvetica,sans-serif;
		}
		table{
			border-collapse:collapse;
			font-size:12px;
		}
		#isian td, #isian th{
			padding:3px 5px;
			border:1px solid #000;
		}
		#isian th{
			
		}
		#headi{
			background:#F0F0F0;
		}
	</style>
</head>
<body>
<center>
	<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" name="btCetak" onclick="cetak()">Cetak Penerimaan</button></span>
	<b>LAPORAN PENERIMAAN</b>
	<br />
	<b>RS PELINDO</b>
	<br />
	<b>UNIT <?php echo $dUnit['UNIT_NAME']; ?></b>
	<br />
	<span>PERIODE : <?php echo $tgl_d." s/d ".$tgl_s?></span>
	<br /><br />
	<table id="isian">
		<tr>
			<th>No.</th>
			<th width='150'>Tgl. Transaksi</th>
			<th width='150'>No. Transaksi</th>
			<th width='100'>No. RM</th>
			<th width="300">Nama Pasien</th>
			<th>Status Pasien</th>
			<th width="100">Total</th>
			<th width="80">Petugas</th>
			<!--td>Keterangan</td-->
		</tr>
	<?php		
		/* $sql_pembayaran = "SELECT t1.* 
							  FROM (SELECT 
								  ap.NO_PENJUALAN, ap.TGL, ap.USER_ID, ap.NAMA_PASIEN,
								  ap.NO_PASIEN, ap.NO_PENJUALAN no_trans,
								  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_transaksi,
								  IFNULL(IFNULL(ku.TOTAL_HARGA, ku.BAYAR_UTANG),IF(ap.CARA_BAYAR = 1,ap.HARGA_TOTAL,0)) nilai,
								  ap.CARA_BAYAR,
								  IFNULL(IF(IFNULL(ku.BAYAR, 0) <> 0,IFNULL(ku.BAYAR, 0),
								  IF(ap.CARA_BAYAR = 1,ap.HARGA_TOTAL,SUM(ku.BAYAR_UTANG))),0) bayar,
								  IFNULL(ku.KEMBALI, 0) kembali, 'pembayaran' ket, IFNULL(u.UNIT_NAME, '-') UNIT_NAME, 
								  DATE_FORMAT(IFNULL(ku.TGL_BAYAR, ap.TGL_ACT), '%d-%m-%Y %H:%i:%s') tgl_trans,
								  m.NAMA, us.username,
								  IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) tgl_trans2, ap.UNIT_ID, ap.KSO_ID
								FROM a_penjualan ap 
								LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
										ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
									FROM a_kredit_utang ku2
									GROUP BY ku2.FK_NO_PENJUALAN) ku
								   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN 
								LEFT JOIN a_unit u 
								   ON u.UNIT_ID = ap.RUANGAN 
								INNER JOIN a_mitra m
								   ON m.IDMITRA = ap.KSO_ID
								INNER JOIN a_user us
								   ON us.kode_user = ku.USER_ID
								   OR us.kode_user = ap.USER_ID
								WHERE {$tmpunit2}
								GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_PASIEN) t1 
							  WHERE t1.bayar <> 0 
								AND t1.CARA_BAYAR IN (2,4) 
								AND t1.KSO_ID <> 88 
								AND DATE(t1.tgl_trans2) BETWEEN '$tgl_d' AND '$tgl_s'
							  UNION
							  SELECT t1.* 
							  FROM (SELECT 
								  ap.NO_PENJUALAN, ap.TGL, ap.USER_ID, ap.NAMA_PASIEN,
								  ap.NO_PASIEN, ap.NO_PENJUALAN no_trans,
								  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_transaksi,
								  IFNULL(IFNULL(ku.TOTAL_HARGA, ku.BAYAR_UTANG),IF(ap.CARA_BAYAR = 1,ap.HARGA_TOTAL,0)) nilai,
								  ap.CARA_BAYAR,
								  IFNULL(IF(IFNULL(ku.BAYAR, 0) <> 0,IFNULL(ku.BAYAR, 0),
								  IF(ap.CARA_BAYAR = 1,ap.HARGA_TOTAL,SUM(ku.BAYAR_UTANG))),0) bayar,
								  IFNULL(ku.KEMBALI, 0) kembali, 'pembayaran' ket, IFNULL(u.UNIT_NAME, '-') UNIT_NAME, 
								  DATE_FORMAT(IFNULL(ku.TGL_BAYAR, ap.TGL_ACT), '%d-%m-%Y %H:%i:%s') tgl_trans,
								  m.NAMA, us.username, IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) tgl_trans2, ap.UNIT_ID, ap.KSO_ID
								FROM a_penjualan ap 
								LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
										ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
									FROM a_kredit_utang ku2
									GROUP BY ku2.FK_NO_PENJUALAN) ku
								   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN 
								LEFT JOIN a_unit u 
								   ON u.UNIT_ID = ap.RUANGAN 
								INNER JOIN a_mitra m
								   ON m.IDMITRA = ap.KSO_ID
								INNER JOIN a_user us
								   ON us.kode_user = ku.USER_ID
								   OR us.kode_user = ap.USER_ID
								WHERE {$tmpunit2}
								GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_PASIEN) t1 
							  WHERE t1.bayar <> 0 AND t1.CARA_BAYAR NOT IN (2,4) AND DATE(t1.tgl_trans2) BETWEEN '$tgl_d' AND '$tgl_s'"; */
		if ($filter!=""){
			$jfilter=$filter;
			$tfilter=explode("*-*",$filter);
			$filter="";
			for ($k=0;$k<count($tfilter);$k++){
				$ifilter=explode("|",$tfilter[$k]);
				$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
				//echo $filter."<br>";
			}
		}
		$sql_pembayaran = "SELECT *
							FROM (
								SELECT ap1.NO_PENJUALAN, ap1.TGL, IFNULL(ku.USER_ID, ap1.USER_ID) USER_ID, 
								  ap1.NAMA_PASIEN, ap1.NO_PASIEN, ap1.NO_PENJUALAN no_trans, IFNULL(ku.NO_BAYAR, ap1.NO_PENJUALAN) no_transaksi, 
								  IFNULL(IF(ap1.HARGA_TOTAL2 <> ku.TOTAL_HARGA, ap1.HARGA_TOTAL2, ku.TOTAL_HARGA), ap1.HARGA_TOTAL2) nilai, ap1.CARA_BAYAR, IFNULL(IF(ku.BAYAR <> 0, ku.BAYAR, ap1.HARGA_TOTAL),0) bayar, 
								  IFNULL(ku.KEMBALI,0) kembali, 'pembayaran' ket, IFNULL(un.UNIT_NAME, '-') UNIT_NAME,
								  DATE_FORMAT(IFNULL(ku.TGL_BAYAR, ap1.TGL_ACT), '%d-%m-%Y %H:%i:%s') tgl_trans,
								  m.NAMA, u.username, IFNULL(ku.TGL_BAYAR, ap1.TGL_ACT) tgl_trans2, 
								  IFNULL(ku.UNIT_ID,ap1.UNIT_ID) UNIT_ID, ap1.KSO_ID, ku.SHIFT
								FROM (SELECT ap.NO_PENJUALAN, ap.NO_KUNJUNGAN, ap.NO_PASIEN, ap.NAMA_PASIEN, ap.HARGA_TOTAL, ap.CARA_BAYAR, 
								  ap.USER_ID, ap.UNIT_ID, ap.TGL, ap.TGL_ACT, ap.USER_ID_BAYAR, ap.TGL_BAYAR_ACT, ap.TGL_BAYAR, ap.RENC_BPJS, 
								  ap.RUANGAN, ap.SHIFT, ap.KSO_ID, SUM(ap.HARGA_SATUAN*ap.QTY_JUAL) HARGA_TOTAL2
								FROM a_penjualan ap 
								WHERE ap.TGL BETWEEN '$tgl_d' AND '$tgl_s'
								  {$tmpunit2}
								  AND ap.CARA_BAYAR = '1'
								GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID) ap1
								LEFT JOIN a_kredit_utang ku
								   ON ku.FK_NO_PENJUALAN = ap1.NO_PENJUALAN
								  AND ku.NO_PELAYANAN = ap1.NO_KUNJUNGAN
								  AND ku.UNIT_ID = ap1.UNIT_ID
								  AND ku.NORM = ap1.NO_PASIEN 
								  AND ku.UNIT_ID = ap1.UNIT_ID 
								  AND DATE(ku.TGL_BAYAR) = DATE(ap1.TGL_BAYAR_ACT)
								INNER JOIN a_mitra m
								   ON m.IDMITRA = ap1.KSO_ID
								INNER JOIN a_user u
								   ON u.kode_user = IFNULL(ku.USER_ID, ap1.USER_ID)
								LEFT JOIN a_unit un
								   ON un.UNIT_ID = IFNULL(ku.UNIT_ID, ap1.UNIT_ID)
								ORDER BY ap1.TGL_ACT DESC
							) t1
							WHERE t1.tgl_trans2 BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							UNION
							SELECT ap.NO_PENJUALAN, ap.TGL, ku.USER_ID, ap.NAMA_PASIEN, ap.NO_PASIEN, ap.NO_PENJUALAN no_trans, 
							  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_transaksi, ku.BAYAR_UTANG nilai, ap.CARA_BAYAR,
							  ku.BAYAR_UTANG bayar, ku.KEMBALI kembali, 'pembayaran' ket, IFNULL(un.UNIT_NAME,'-') UNIT_NAME,
							  DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') tgl_trans,
							  m.NAMA, IF(ku.IS_AKTIF = 1, u.username, peg.nama) username, ku.TGL_BAYAR tgl_trans2, ku.UNIT_ID, 
							  ap.KSO_ID, if(ku.SHIFT = 0, '-', ku.SHIFT) SHIFT
							FROM a_kredit_utang ku
							INNER JOIN a_penjualan ap
							   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
							  AND ap.NO_PASIEN = ku.NORM
							  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
							  AND ap.UNIT_ID = ku.UNIT_ID
							  AND DATE(ap.TGL_BAYAR_ACT) = DATE(ku.TGL_BAYAR)
							INNER JOIN a_mitra m
							   ON m.IDMITRA = ap.KSO_ID
							LEFT JOIN a_user u 
							   ON u.kode_user = ku.USER_ID 
							LEFT JOIN $dbbilling.b_ms_pegawai peg
							   ON peg.id = ku.USER_ID
							LEFT JOIN a_unit un
							   ON un.UNIT_ID = ku.UNIT_ID
							WHERE ku.NO_PELAYANAN IS NOT NULL
							  AND ap.CARA_BAYAR IN (2,4)
							  {$tmpunit2}
							  AND ku.TGL_BAYAR BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							GROUP BY ku.FK_NO_PENJUALAN, ku.UNIT_ID, ku.NO_PELAYANAN, ku.NORM
							UNION
							SELECT ap.NO_PENJUALAN, ap.TGL, ku.USER_ID, ap.NAMA_PASIEN, ap.NO_PASIEN, ap.NO_PENJUALAN no_trans, 
							  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_transaksi, ku.BAYAR_UTANG nilai, ap.CARA_BAYAR,
							  ku.BAYAR_UTANG bayar, ku.KEMBALI kembali, 'pembayaran' ket, IFNULL(un.UNIT_NAME,'-') UNIT_NAME,
							  DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') tgl_trans,
							  m.NAMA, u.username, ku.TGL_BAYAR tgl_trans2, ku.UNIT_ID, ap.KSO_ID, ku.SHIFT
							FROM a_kredit_utang ku
							INNER JOIN a_penjualan ap
							   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
							  AND ap.NO_PASIEN = ku.NORM
							  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
							  AND ap.UNIT_ID = ku.UNIT_ID
							  AND DATE(ap.TGL_BAYAR_ACT) = DATE(ku.TGL_BAYAR)
							INNER JOIN a_mitra m
							   ON m.IDMITRA = ap.KSO_ID
							INNER JOIN a_user u
							   ON u.kode_user = ku.USER_ID
							LEFT JOIN a_unit un
							   ON un.UNIT_ID = ku.UNIT_ID
							WHERE ku.NO_PELAYANAN IS NULL
							  {$tmpunit2}
							  AND ku.TGL_BAYAR BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							  AND ap.CARA_BAYAR IN (2, 4)
							GROUP BY ku.FK_NO_PENJUALAN, ku.UNIT_ID, YEAR(ku.TGL_BAYAR)";
							
		$sql_pengembalian_ = "SELECT t3.* 
							  FROM (SELECT 
								  ap.NO_PENJUALAN, ap.TGL, ap.USER_ID, ap.NAMA_PASIEN, ap.NO_PASIEN,
								  rp.no_retur no_trans, IF(rp.bayar <> 0 /* OR pu.no_pengembalian IS NOT NULL */, pu.no_pengembalian, pu.no_retur ) no_transaksi,
								  IFNULL(pu.nilai, rp.nilai) nilai, ap.CARA_BAYAR, 0 bayar, 0 kembali, 'pengembalian' ket,
								  IFNULL(u.UNIT_NAME, '-') UNIT_NAME, DATE_FORMAT(IFNULL(pu.tgl_act, rp.tgl_retur), '%d-%m-%Y %H:%i:%s') tgl_trans,
								  m.NAMA, us.username, IFNULL(pu.tgl_act, rp.tgl_retur) tgl_trans2, ap.UNIT_ID, ap.KSO_ID, NULL SHIFT
								FROM a_penjualan ap 
								  INNER JOIN a_return_penjualan rp 
									ON rp.idpenjualan = ap.ID 
								  LEFT JOIN a_pengembalian_uang pu 
									ON pu.no_penjualan = ap.NO_PENJUALAN 
									AND pu.no_retur = ap.NO_RETUR 
									OR pu.no_retur = rp.no_retur 
								  LEFT JOIN a_unit u 
									ON u.UNIT_ID = ap.RUANGAN 
								  INNER JOIN a_mitra m
									ON m.IDMITRA = ap.KSO_ID
								  INNER JOIN a_user us
									ON us.kode_user = pu.user_act
								WHERE rp.bayar = 2
								  /* OR pu.no_pengembalian IS NOT NULL  */
								  {$tmpunit2}) t3
							  WHERE t3.tgl_trans2 BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							  GROUP BY t3.no_transaksi";
							  
		$sql_pengembalian = "SELECT t3.*
							FROM (SELECT ap.NO_PENJUALAN, ap.TGL, ap.USER_ID, ap.NAMA_PASIEN, ap.NO_PASIEN,
							  rp.no_retur no_trans, pu.no_pengembalian no_transaksi, pu.nilai nilai, ap.CARA_BAYAR, 0 bayar, 0 kembali, 'pengembalian' ket,
							  IFNULL(u.UNIT_NAME, '-') UNIT_NAME, DATE_FORMAT(pu.tgl_act, '%d-%m-%Y %H:%i:%s') tgl_trans,
							  m.NAMA, us.username, pu.tgl_act tgl_trans2, ap.UNIT_ID, ap.KSO_ID, pu.shift SHIFT
							FROM a_return_penjualan rp
							INNER JOIN a_penjualan ap
							   ON ap.ID = rp.idpenjualan
							INNER JOIN a_pengembalian_uang pu
							   ON pu.no_retur = rp.no_retur
							  AND pu.no_penjualan = ap.NO_PENJUALAN
							LEFT JOIN a_unit u 
							   ON u.UNIT_ID = ap.RUANGAN 
							INNER JOIN a_mitra m
							   ON m.IDMITRA = ap.KSO_ID
							INNER JOIN a_user us
							  ON us.kode_user = pu.user_act
							WHERE rp.bayar = 2
							  AND pu.status <> 1
							  {$tmpunit2}) t3 
							WHERE t3.tgl_trans2 BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							GROUP BY t3.no_transaksi ";
		if($jenis_penerimaan == '0'){
			$sql_all = $sql_pembayaran." UNION ".$sql_pengembalian;
		} else if($jenis_penerimaan == '1'){
			$sql_all = $sql_pembayaran;
		} else if($jenis_penerimaan == '2'){
			$sql_all = $sql_pengembalian;
		}
		
		$sql = "SELECT * FROM({$sql_all}) t2 where 0 = 0 {$filter} ORDER BY t2.ket, {$sorting}";
		//echo $sql;
		$query = mysqli_query($konek,$sql);
		$no = 1;
		$tmpHead = "";
		$total = 0;
		$totalAkhir = array();
		while($data = mysqli_fetch_array($query)){
			if($data['ket'] != $tmpHead && $no != 1){
				echo "
					<tr>
						<td align='right' colspan='6'>Total</td>
						<td align='right' style='border-top:1px dashed #000;'><b>".number_format($total,0,",",".")."</b></td>
						<td>&nbsp;</td>
					</tr>
				";
				$totalAkhir[$tmpHead] = $total;
				$total = 0;
				$no = 1;
			}
			if($data['ket'] != $tmpHead){
				if($tmpHead != ""){
					echo "<tr><td colspan='9'>&nbsp;</td></tr>";
				}
				echo "<tr id='headi'><td colspan='9'>".ucwords($data['ket'])."</td></tr>";
			}
			echo"
				<tr>
					<td align='center'>$no.</td>
					<td align='center'>".$data['tgl_trans']."</td>
					<td align='center'>".$data['no_transaksi']."</td>
					<td align='center'>".$data['NO_PASIEN']."</td>
					<td>".$data['NAMA_PASIEN']."</td>
					<td align='center'>".$data['NAMA']."</td>
					<td align='right'>".number_format($data['nilai'],0,",",".")."</td>
					<td align='center'>".$data['username']."</td>
					<!--td>".$data['ket']."</td-->
				</tr>";
			$total += $data['nilai'];
			$no++;
			$tmpHead = $data['ket'];
		}
		$totalAkhir[$tmpHead] = $total;
	?>
		<tr>
			<td align='right' colspan='6'>Total</td>
			<td align='right' style='border-top:1px dashed #000;'><b><?php echo number_format($total,0,",","."); ?></b></td>
			<td>&nbsp;</td>
		</tr>
		<?php if($jenis_penerimaan == '0'){ ?>
		<tr>
			<td align='right' colspan='6'><b>Total Pembayaran - Pengembalian</b></td>
			<td align='right' style='border-top:1px dashed #000;'><b><?php echo number_format(($totalAkhir['pembayaran']-$totalAkhir['pengembalian']),0,",","."); ?></b></td>
			<td>&nbsp;</td>
		</tr>
	<?php
		}
		//print_r($totalAkhir);
	?>
		<tr>
			<td colspan="8" align='right'>
				<br /><?php echo "Tgl/Jam Cetak : ".$tglact; ?>
				<br />User Cetak : <?php echo $username; ?>
			</td>
		</tr>
	</table>
</center>
</body>
</html>
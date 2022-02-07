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
	$jenis_pendapatan = ($_REQUEST["jenis_pendapatan"] != "")? $_REQUEST["jenis_pendapatan"] : '0';
	
	/* get unit */
	$sUnit = "select UNIT_NAME from a_unit where UNIT_ID = {$idunit}";
	$qUnit = mysqli_query($konek,$sUnit);
	$dUnit = mysqli_fetch_array($qUnit);

	/* get user cetak */
	$sUser = "select username from a_user where kode_user = ".$_SESSION['iduser'];
	$qUser =  mysqli_query($konek,$sUser);
	$dUser = mysqli_fetch_array($qUser);
	$username = $dUser['username'];
	
	/* cek param */
	if ($idunit=="0"){
		$tmpunit="";
	}else{
		$tmpunit=" ap.UNIT_ID = '{$idunit}' AND ";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Pendapatan Apotek</title>
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
	<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" name="btCetak" onclick="cetak()">Cetak Pendapatan</button></span>
	<b>LAPORAN PENDAPATAN</b>
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
			<th width='100'>No. Transaksi</th>
			<th width='100'>No. RM</th>
			<th width="300">Nama Pasien</th>
			<th>Status Pasien</th>
			<th width="100">Total</th>
			<th width="80">Petugas</th>
			<!--td>Keterangan</td-->
		</tr>
	<?php
		$sql_ = "SELECT * FROM
				(SELECT DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl_act, ap.NO_PENJUALAN no_transaksi, ap.NAMA_PASIEN, 
				  ap.NO_PASIEN, u.UNIT_NAME, ap.HARGA_TOTAL nilai, 
				  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'penjualan' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, ap.TGL_ACT tgl_asli
				FROM a_penjualan ap
				INNER JOIN a_unit u
				   ON u.UNIT_ID = ap.RUANGAN
				INNER JOIN a_user us
				   ON us.kode_user = ap.USER_ID
				INNER JOIN a_mitra m
				   ON m.IDMITRA = ap.KSO_ID
				WHERE {$tmpunit} DATE_FORMAT(ap.TGL_ACT,'%Y-%m-%d') BETWEEN '$tgl_d' AND '$tgl_s'
				   {$filter}
				GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID
				UNION
				SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_act, rp.no_retur, ap.NAMA_PASIEN, 
				  ap.NO_PASIEN, u.UNIT_NAME, SUM(rp.nilai) nilai,
				  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'retur' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, rp.tgl_retur
				FROM a_penjualan ap
				INNER JOIN a_return_penjualan rp
				   ON rp.idpenjualan = ap.ID
				INNER JOIN a_unit u
				   ON u.UNIT_ID = ap.RUANGAN
				INNER JOIN a_user us
				   ON us.kode_user = rp.userid_retur
				INNER JOIN a_mitra m
				   ON m.IDMITRA = ap.KSO_ID
				WHERE {$tmpunit} DATE_FORMAT(rp.tgl_retur,'%Y-%m-%d') BETWEEN '$tgl_d' AND '$tgl_s'
				   {$filter}
				GROUP BY rp.no_retur) t1
				ORDER BY {$sorting}";
		
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
		
		$sql_penjualan = "SELECT DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl_act, ap.NO_PENJUALAN no_transaksi, ap.NAMA_PASIEN, 
							  ap.NO_PASIEN, IFNULL(u.UNIT_NAME,'-') UNIT_NAME, SUM((ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))*ap.QTY_JUAL) nilai, 
							  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'penjualan' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, ap.TGL_ACT tgl_asli, ap.SHIFT shift
							FROM a_penjualan ap
							LEFT JOIN a_unit u
							   ON u.UNIT_ID = ap.RUANGAN
							INNER JOIN a_user us
							   ON us.kode_user = ap.USER_ID
							INNER JOIN a_mitra m
							   ON m.IDMITRA = ap.KSO_ID
							WHERE {$tmpunit} ap.TGL_ACT BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
							GROUP BY ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_PASIEN";
		$sql_retur = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_act, rp.no_retur no_transaksi, ap.NAMA_PASIEN, 
						  ap.NO_PASIEN, IFNULL(u.UNIT_NAME,'-') UNIT_NAME, SUM(rp.nilai) nilai,
						  ap.KSO_ID, m.NAMA, ap.USER_ID, us.username, 'retur' ket, ap.UNIT_ID, ap.TGL, ap.NO_PENJUALAN, rp.tgl_retur tgl_asli, rp.shift_retur shift
						FROM a_penjualan ap
						INNER JOIN a_return_penjualan rp
						   ON rp.idpenjualan = ap.ID
						INNER JOIN a_unit u
						   ON u.UNIT_ID = ap.RUANGAN
						INNER JOIN a_user us
						   ON us.kode_user = rp.userid_retur
						INNER JOIN a_mitra m
						   ON m.IDMITRA = ap.KSO_ID
						WHERE {$tmpunit} rp.tgl_retur BETWEEN '$tgl_d 00:00:00' AND '$tgl_s 23:59:59'
						GROUP BY rp.no_retur";
		
		if($jenis_pendapatan == '0'){
			$sql_all = $sql_penjualan." UNION ".$sql_retur;
		} else if($jenis_pendapatan == '1'){
			$sql_all = $sql_penjualan;
		} else if($jenis_pendapatan == '2'){
			$sql_all = $sql_retur;
		} 
		$sql = "SELECT t1.* FROM({$sql_all}) t1 where 0 = 0 {$filter} ORDER BY t1.ket, {$sorting}";
		//echo $sql;
		$query = mysqli_query($konek,$sql);
		$no = 1;
		$tmpHead = "";
		$total = 0;
		while($data = mysqli_fetch_array($query)){
			if($data['ket'] != $tmpHead && $no != 1){
				echo "
					<tr>
						<td align='right' colspan='6'>Total</td>
						<td align='right' style='border-top:1px dashed #000;'><b>".number_format($total,0,",",".")."</b></td>
						<td>&nbsp;</td>
					</tr>
				";
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
					<td align='center'>".$data['tgl_act']."</td>
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
	?>
		<tr>
			<td align='right' colspan='6'>Total</td>
			<td align='right' style='border-top:1px dashed #000;'><b><?php echo number_format($total,0,",","."); ?></b></td>
			<td>&nbsp;</td>
		</tr>
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
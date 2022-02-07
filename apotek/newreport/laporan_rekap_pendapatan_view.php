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
	$penerima = (empty($_REQUEST['cmb_tipe']))?'1':$_REQUEST['cmb_tipe'];
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
	}else{
		$tmpunit=" AND t1.UNIT_ID = '{$idunit}' ";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Rekap Penerimaan Farmasi</title>
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
	<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" name="btCetak" onclick="cetak()">Cetak Rekap Pendapatan</button></span>
	<b>REKAP PENERIMAAN FARMASI</b>
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
			<th width='150'>Penerima</th>
			<th width='150'>Penjualan</th>
			<th width='150'>Retur</th>
			<th width="150">Total</th>
		</tr>
	<?php		
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
		
		if ($penerima=="1"){
			$select = "ap.UNIT_ID, u.UNIT_NAME nama,";
			$grp = "ap.UNIT_ID";
			$join = "INNER JOIN a_unit u
					    ON u.UNIT_ID = ap.UNIT_ID";
		}else{
			$select = "ap.USER_ID, u.username nama,";
			$grp="ap.USER_ID";
			$join = "INNER JOIN a_user u
					    ON u.kode_user = ap.USER_ID";
		}

		$sql = "SELECT *
				FROM(SELECT {$select} SUM(ap.QTY_JUAL*(ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))) totalJual, 
					SUM(ap.QTY_RETUR*(ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))) totalRetur, 
				   (SUM(ap.QTY_JUAL*(ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))) - SUM(ap.QTY_RETUR*(ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100))))) AS total
				FROM a_penjualan ap
				{$join}
				WHERE ap.TGL_ACT BETWEEN '{$tgl_d} 00:00:00' 
				  AND '{$tgl_s} 23:59:59'
				GROUP BY {$grp}) t1
				WHERE 0 = 0 {$filter}
				ORDER BY {$sorting}";
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
					<td align='left'>".$data['nama']."</td>
					<td align='right'>".number_format($data['totalJual'],0,",",".")."</td>
					<td align='right'>".number_format($data['totalRetur'],0,",",".")."</td>
					<td align='right'>".number_format($data['total'],0,",",".")."</td>
				</tr>";
			$total += $data['total'];
			$no++;
		}
		$totalAkhir[$tmpHead] = $total;
	?>
		<tr>
			<td align='right' colspan='4'>Grand Total</td>
			<td align='right' style='border-top:1px dashed #000;'>
				<b><?php echo number_format($total,0,",","."); ?></b>
			</td>
		</tr>
		<tr>
			<td colspan="5" align='right'>
				<br /><?php echo "Tgl/Jam Cetak : ".$tglact; ?>
				<br />User Cetak : <?php echo $username; ?>
			</td>
		</tr>
	</table>
</center>
</body>
</html>
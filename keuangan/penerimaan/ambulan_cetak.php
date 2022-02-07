<?php
	include('../sesi.php');
	include("../koneksi/konek.php");
	$bln = $_REQUEST['bln'];
	$thn = $_REQUEST['thn'];
	$defaultsort = "a.tgl ASC";
	$sorting = $_REQUEST["sorting"];
	$filter = $_REQUEST["filter"];
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Penerimaan Ambulan</title>
	<style type="text/css">
		#tabelIsi{
			border-collapse:collapse;
			font-size:12px;
		}
		#tabelIsi th{
			font-weight:bold;
		}
		#tabelIsi td, #tabelIsi th{
			border:1px solid #000;
			padding:5px;
		}
	</style>
</head>
<body>
	<p style="font-weight:bold; font-size:16px; text-transform: uppercase;">
		Penerimaan Ambulan Bulan <?php echo $arrBln[$bln]." ".$thn; ?>
		<br />
		<?php echo $namaRS; ?>
	</p>
	<table id="tabelIsi">
		<tr>
			<th align="center" width="20px" >No.</th>
			<th align="center" width="100" >Tgl Pelayanan</th>
			<th align="center" width="100" >Tgl Setor</th>
			<th align="center" width="80" >Jam</th>
			<th align="center" width="120" >Tipe Ambulan</th>
			<th align="center" width="100" >No Bukti</th>
			<th align="center" width="100" >Nilai</th>
			<th align="center" width="100" >Petugas</th>
		</tr>
		<?php 
			$sql = "SELECT DATE_FORMAT(a.tgl,'%d-%m-%Y') tgl, DATE_FORMAT(a.tgl_setor,'%d-%m-%Y') tgl_setor, DATE_FORMAT(a.tgl_setor,'%H:%i') jam_setor,
						   IF(a.ambulan_tipe = 0, 'Jenazah', 'Rescue') nama, a.no_bukti, a.nilai, u.username
					FROM k_ambulan a
					INNER JOIN k_ms_user u
					   ON u.id = a.user_act
					WHERE 0 = 0 $filter
					ORDER BY $sorting";
			$query = mysql_query($sql);
			$i = 1;
			$total = 0;
			while($data = mysql_fetch_array($query)){
				echo "
					<tr>
						<td align='center'>".$i++."</td>
						<td align='center'>".$data['tgl']."</td>
						<td align='center'>".$data['tgl_setor']."</td>
						<td align='center'>".$data['jam_setor']."</td>
						<td >".$data['nama']."</td>
						<td align='center'>".$data['no_bukti']."</td>
						<td align='right'>".$data['nilai']."</td>
						<td align='center'>".$data['username']."</td>
					</tr>
				";
				$total += $data['nilai'];
			}
		?>
		<tr>
			<td colspan="6" align="right">Total</td>
			<td align="right"><?php echo $total; ?></td>
			<td></td>
		</tr>
	</table>
</body>
</html>
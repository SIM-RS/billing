<?php
	session_start();
	include("../koneksi/konek.php");
	/* Parameter */
	//echo $_REQUEST['cmbBln'];
	$bln = ($_REQUEST['bln']!='')?$_REQUEST['bln']:$_REQUEST['cmbBln'];
	$thn = ($_REQUEST['thn']!='')?$_REQUEST['thn']:$_REQUEST['cmbThn'];
	$defaultsort = "t1.id";
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
	$sql = "SELECT p.tgl, DATE_FORMAT(p.tgl_setor,'%d-%m-%Y') tgl_setor, DATE_FORMAT(p.tgl_setor,'%H:%i') jam_setor,
					   k.nama, p.no_bukti, p.nilai, p.shift
				FROM k_parkir p
				INNER JOIN k_ms_kendaraan k
				   ON k.id = p.ms_kendaraan_id
				WHERE MONTH(p.tgl) = $bln
				  AND YEAR(p.tgl) = $thn
				ORDER BY p.tgl, p.shift ASC, p.tgl_setor ASC";
	$query = mysql_query($sql);
	$arr = array();
	while($data = mysql_fetch_array($query)){
		$arr[$data['tgl']][$data['shift']][] = $data['tgl']."|".$data['tgl_setor']."|".$data['jam_setor']."|".$data['nama']."|".$data['no_bukti']."|".$data['nilai']."|".$data['shift'];
	}
	//print_r($arr);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan Penerimaan Parkir</title>
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
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
	</script>
</head>
<body>
	<span id="cetakID" style="float:left; text-align:center; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" name="btCetak" onclick="cetak()">Cetak Penerimaan</button></span>
	<p style="font-weight:bold; font-size:16px; text-transform: uppercase;">
		Penerimaan Parkir Bulan <?php echo $arrBln[$bln]." ".$thn; ?>
		<br />
		RSUD SIDOARJO
	</p>
	<table id="tabelIsi">
		<tr>
			<th rowspan="2" >Tgl Parkir</th>
			<th colspan="7" >SHIFT 1</th>
			<th colspan="7" >SHIFT 2</th>
			<th colspan="7" >SHIFT 3</th>
		</tr>
		<tr>
			<th>Tgl Setor</th>
			<th>Jam</th>
			<th>No</th>
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
			<th>Tgl Setor</th>
			<th>Jam</th>
			<th>No</th>
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
			<th>Tgl Setor</th>
			<th>Jam</th>
			<th>No</th>
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
		</tr>
		<?php
			$no1 = $no2 = $no3 = 1;
			foreach($arr as $key => $val){
				echo "<tr>";
				echo "<td>".tglSQL($key)."</td>";
				
				$maxi = array(count($val[1]),count($val[2]),count($val[3]));
				for($i=0;$i<max($maxi);$i++){
					if(count($val[1]) == 0){
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
					} else {
						//echo count($shift1)."|$i<br />";
						$shift1 = explode('|',$val[1][$i]);
						//$no1 = 1;
						if(count($shift1) > 1){
							foreach($shift1 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											echo "<td>".$val2."</td>";
											echo "<td>".$no1++."</td>";
											break;
										case '5':
											echo "<td>".$val2."</td>";
											echo "<td></td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
						} else {
							echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
						}
					}
					if(count($val[2]) == 0){
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
					} else {
						//echo "<td colspan='7'>".$val[2][$i]."</td>";
						$shift2 = explode('|',$val[2][$i]);
						//$no2 = 1;
						if(count($shift2) > 1){
							foreach($shift2 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											echo "<td>".$val2."</td>";
											echo "<td>".$no2++."</td>";
											break;
										case '5':
											echo "<td>".$val2."</td>";
											echo "<td></td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
						} else {
							echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
						}
					}
					if(count($val[3]) == 0){
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
						if($i != (max($maxi)-1)){
							echo "<tr><td></td>";
						}
					} else {
						//echo "<td colspan='7'>".$val[3][$i]."</td>";
						$shift3 = explode('|',$val[3][$i]);
						//$no3 = 1;
						if(count($shift3) > 1){
							foreach($shift3 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											echo "<td>".$val2."</td>";
											echo "<td>".$no3++."</td>";
											break;
										case '5':
											echo "<td>".$val2."</td>";
											echo "<td></td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
							echo "</tr>";
							if($i != (max($maxi)-1)){
								echo "<tr><td></td>";
							}
						} else {
							echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
						}
					}
				}
				//echo "</tr>";
			}
		?>
	</table>
</body>
</html>
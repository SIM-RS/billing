<?php
	session_start();
	include('../sesi.php');
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	if($_REQUEST['isExcel'] == '1'){
		//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-type: application/ms-excel');
		header("Content-Disposition: attachment; filename=\"Penerimaan_Parkir_{$tgl}.xls\"");
	}
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
				  AND YEAR(p.tgl) = $thn AND p.flag = '$flag'
				ORDER BY p.tgl ASC, p.tgl_setor ASC, k.id ASC";
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
			//width:2000px;
		}
		#tabelIsi th{
			font-weight:bold;
			background:#e1e1e1;
		}
		#tabelIsi td, #tabelIsi th{
			border:1px solid #000;
			padding:3px;
		}
		#container{
			width:100%;
		}
	</style>
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
		
		function cetakExcell(){
			window.location.href = 'cetak_parkir.php?tipe=1&isExcel=1&bln=<?php echo $bln; ?>&thn=<?php echo $thn; ?>';
		}
	</script>
</head>
<body>
	<?php if($_REQUEST['isExcel'] != '1'){ ?>
	<span id="cetakID" style="float:left; text-align:center; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;">
		<button id="btCetak" name="btCetak" onclick="cetak()">Cetak Penerimaan</button>
		<button id="btCetakExcell" name="btCetakExcell" type="button" onclick="cetakExcell()">Export Excell</button>
	</span>
	<?php } ?>
	<div id="container">
	<p style="font-weight:bold; font-size:16px; text-transform: uppercase;">
		Laporan Penerimaan Parkir
		<br />
		<?=$namaRS;?>
		<br />
		Bulan <?php echo $arrBln[$bln]." ".$thn; ?>
	</p>
	<table id="tabelIsi">
		<thead>
		<tr>
			<th rowspan="2" >Tgl Parkir</th>
			<th colspan="5" >SHIFT 1</th>
			<th colspan="5" >SHIFT 2</th>
			<th colspan="5" >SHIFT 3</th>
			<th colspan="5" >BERLANGGANAN</th>
			<th rowspan="2" >Total</th>
		</tr>
		<tr>
			<th>Tgl Setor</th>
			<!--th>Jam</th>
			<th>No</th-->
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
			<th>Tgl Setor</th>
			<!--th>Jam</th>
			<th>No</th-->
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
			<th>Tgl Setor</th>
			<!--th>Jam</th>
			<th>No</th-->
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
			<th>Tgl Setor</th>
			<!--th>Jam</th>
			<th>No</th-->
			<th>Jenis Kendaraan</th>
			<th>Nomor Seri</th>
			<th>Setoran</th>
			<th>Jumlah</th>
		</tr>
		</thead>
		<tbody>
		<?php
			$no1 = $no2 = $no3 = $no4 = 1;
			$totalAll = 0;
			foreach($arr as $key => $val){
				echo "<tr style='border-top:3px solid #000;'>";
				echo "<td>".tglSQL($key)."</td>";
				
				$maxi = array(count($val[1]),count($val[2]),count($val[3]),count($val[0]));
				//print_r($maxi);
				//echo max($maxi)."<br />";
				$jmlPR1 = $jmlPR2 = $jmlPR3 = $jmlPR4 = 0;
				for($i=0;$i<max($maxi);$i++){
					if($maxi[0] == 0){
						echo "<td></td><!--td></td><td></td--><td></td><td></td><td></td><td></td>";
					} else {
						//echo count($shift1)."|$i<br />";
						$shift1 = explode('|',$val[1][$i]);
						//$no1 = 1;
						if(count($shift1) > 1){
							
							foreach($shift1 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											//echo "<td>".$val2."</td>";
											//echo "<td>".$no1++."</td>";
											break;
										case '5':
											$jmlPR1 += $val2;
											echo "<td align='right'>".number_format($val2,0,",",".")."</td>";
											if(($i+1) == $maxi[0]){
												echo "<td align='right'>".number_format($jmlPR1,0,",",".")."</td>";
											} else {
												echo "<td></td>";
											}
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
								$jmlR++;
							}
						} else {
							echo "<td><!--td></td><td></td--></td><td></td><td></td><td></td><td></td>";
						}
					}
					if($maxi[1] == 0){
						echo "<td style='border-left:3px solid #000;'></td><td></td><!--td></td><td></td--><td></td><td></td><td></td>";
					} else {
						//echo "<td colspan='7'>".$val[2][$i]."</td>";
						$shift2 = explode('|',$val[2][$i]);
						//$no2 = 1;
						if(count($shift2) > 1){
							foreach($shift2 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											//echo "<td>".$val2."</td>";
											//echo "<td>".$no2++."</td>";
											break;
										case '5':
											$jmlPR2 += $val2;
											echo "<td align='right'>".number_format($val2,0,",",".")."</td>";
											if(($i+1) == $maxi[1]){
												echo "<td align='right'>".number_format($jmlPR2,0,",",".")."</td>";
											} else {
												echo "<td></td>";
											}
											break;
										case '1':
											echo "<td style='border-left:3px solid #000;'>".$val2."</td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
						} else {
							echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td>";
						}
					}
					if($maxi[2] == 0){
						echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td>";
					} else {
						//echo "<td colspan='7'>".$val[2][$i]."</td>";
						$shift3 = explode('|',$val[3][$i]);
						//$no2 = 1;
						if(count($shift3) > 1){
							foreach($shift3 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											//echo "<td>".$val2."</td>";
											//echo "<td>".$no3++."</td>";
											break;
										case '5':
											$jmlPR3 += $val2;
											echo "<td align='right'>".number_format($val2,0,",",".")."</td>";
											if(($i+1) == $maxi[2]){
												echo "<td align='right'>".number_format($jmlPR3,0,",",".")."</td>";
											} else {
												echo "<td></td>";
											}
											break;
										case '1':
											echo "<td style='border-left:3px solid #000;'>".$val2."</td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
						} else {
							echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td>";
						}
					}
					if($maxi[3] == 0){
						if($i == (max($maxi)-1)){
							echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td><td align='right'>".number_format(($jmlPR1+$jmlPR2+$jmlPR3+$jmlPR4),0,",",".")."</td></tr>";
						} else {
							echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td><td align='right'></td></tr>";
						}
						if($i != (max($maxi)-1)){
							echo "<tr><td></td>";
						}	
					} else {
						//echo "<td colspan='7'>".$val[3][$i]."</td>";
						$shift4 = explode('|',$val[0][$i]);
						//$no3 = 1;
						if(count($shift4) > 1){
							foreach($shift4 as $key2 => $val2){
								if($key2 != 0 && $key2 != 6){
									switch($key2){
										case '2':
											//echo "<td>".$val2."</td>";
											//echo "<td>".$no4++."</td>";
											break;
										case '5':
											$jmlPR4 += $val2;
											echo "<td align='right'>".number_format($val2,0,",",".")."</td>";
											if(($i+1) == $maxi[3]){
												echo "<td align='right'>".number_format($jmlPR4,0,",",".")."</td>";
											} else {
												echo "<td></td>";
											}
											break;
										case '1':
											echo "<td style='border-left:3px solid #000;'>".$val2."</td>";
											break;
										default:
											echo "<td>".$val2."</td>";
											break;
									}
								}
							}
							//echo $i."|-|".max($maxi)."<br />";
							if($i == (max($maxi)-1)){
								echo "<td align='right'>".number_format(($jmlPR1+$jmlPR2+$jmlPR3+$jmlPR4),0,",",".")."</td></tr>";
							} else {
								//echo "dohkaha <br />";
								echo "<td></td></tr>";
							}
							if($i != (max($maxi)-1)){
								//echo "dohkah <br />";
								echo "<tr><td></td>";
							}
							//echo $i."|-|".max($maxi)."<br />";
						} else {
							//echo $i."|||".max($maxi)."<br />";
							if($i == (max($maxi)-1)){
								//echo "dohkah --- <br />";
								echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td><td align='right'>".number_format(($jmlPR1+$jmlPR2+$jmlPR3+$jmlPR4),0,",",".")."</td>";
							} else {
								//echo "--- dohkah <br />";
								echo "<td style='border-left:3px solid #000;'></td><!--td></td><td></td--><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td>";
							}
						}
					}
				}
				$totalAll += $jmlPR1+$jmlPR2+$jmlPR3+$jmlPR4;
				//echo "</tr>";
			}
		?>
		<tr>
			<td colspan="21" align="right" style="background:#e1e1e1; font-weight:bold;">Total</td>
			<td align='right' style="background:#e1e1e1; font-weight:bold;"><?php echo number_format($totalAll,0,",","."); ?></td>
		</tr>
		</tbody>
	</table>
	</div>
	<span style="width:100%; height:30px; display:block;"></span>
</body>
</html>
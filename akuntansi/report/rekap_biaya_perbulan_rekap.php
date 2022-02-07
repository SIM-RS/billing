<?php
	session_start();
	include("../sesi.php");
	include("../koneksi/konek.php");
	//// if($_POST['export']=='excel'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
	// }
	$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
	$wktnow=gmdate('H:i:s',mktime(date('H')+7));
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	$kso = $_REQUEST['cmbKsoRep'];
	$cwaktu = $waktu;
	$waktu = "Bulanan";
	if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
        $waktu = " AND j2.TGL = '$tglAwal2' ";
        
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $tmpBln = explode('|',$_REQUEST['cmbBln']);
		$bln = $tmpBln['0'];
        $thn = $_REQUEST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
        //$waktu = "month(t.tgl) = '$bln' AND year(t.tgl) = '$thn' ";
		// $tglAwal2 = "$thn-$cbln-01";
		// $tglAkhir2 = "$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$waktu = " AND MONTH(j2.TGL) = '$bln' AND YEAR(j2.TGL) = '$thn' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		//$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		//$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND j2.TGL between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Rekap Biaya Perbulan</title>
	<style type="text/css">
		body{margin:0; padding:0; font-size:11px; font-family:arial;}
		table{margin:0; padding:0;}
		table{
			border-collapse:collapse;
			width:200%;
			text-align:left;
		}
		th{ text-align:center; }
		th, td {
			padding:5px;
		}
		th {
			border:1px solid #000;
		}
		.borderfull{
			border:1px solid #000;
		}
		.noborder{
			border:0px;
		}
		.borderbottom{
			border-bottom:1px solid #000;
		}
		.kanan{
			text-align:right;
		}
		#container{ text-align:center; margin:20px; }
		#judul{ text-align:center; width:200%; font-size:22px; }
	</style>
</head>
<body>
	<div id="container">
		<header id="judul">
			<b>
				REKAP PENERIMAAN BERDASARKAN JENIS TRANSAKSI<br />
				<?php echo $namaRS; ?><br />
				<?php echo $Periode; ?>
			</b>
		</header>
		<table id="dataNilai">
			<tr>
				<th rowspan="2">No Rek</th>
				<th rowspan="2" width="600">Uraian</th>
				<?php 
					$caseQuery = array();
					function getChild( $param = array() ){
						global $caseQuery;
						$result = array("count" => 0);
						switch($param['type']){
							case "coloum-head":
								$sChild = "SELECT id, kode, nama, `level`, parent_id, parent_kode, islast, tipe, aktif 
											FROM ak_ms_unit WHERE parent_id = ".$param['parent_id']." AND aktif = 1";
								$qChild = mysql_query($sChild);
								if($qChild && mysql_num_rows($qChild) > 0){
									$result["count"] = mysql_num_rows($qChild)+1;
									$parentKode = "";
									while($dChild = mysql_fetch_object($qChild))
									{
										if($dChild->islast != 0){
											$result["value"] .= "<th width='200px' >".ucwords(strtolower($dChild->nama))."<br />".str_replace($dChild->parent_kode, $dChild->parent_kode.".", $dChild->kode)."</th>";
											$caseQuery["c".$dChild->kode] = "SUM(CASE WHEN j.CC_RV_ID = '".$dChild->id."' THEN j.nilai ELSE 0 END) AS "."c". $dChild->kode ."";
										} else {
											$param = array("parent_id" => $dChild->id, "type" => "coloum-head");
											$data = getChild($param);
											$result["count"] += $data["count"];
											$result["value"] .= $data["value"];
										}
										$childKode = $dChild->kode;
										$parentKode = $dChild->parent_kode;
									}
									$caseQuery[$childKode."_jumlah"] = "'jumlah' as `jumlah`";
									$result["value"] .= "<th width='200px' >Jumlah<br />".$parentKode."</th>";
								}
								break;
							case "coloum-row":
								break;
						}
						return $result;
					}
					
					$cHead = "SELECT id, kode, nama, `level`, parent_id, parent_kode, islast, tipe, aktif 
								FROM ak_ms_unit WHERE parent_id = 0 AND level = 1";
					$qHead = mysql_query($cHead);
					$result = array();
					while($qHead && $dHead = mysql_fetch_object($qHead))
					{
						$param = array("parent_id" => $dHead->id, "type" => "coloum-head");
						$data = getChild($param);
						$colspan = ($data["count"] > 0 ? "colspan='".$data["count"]."'" : "");
						echo "<th $colspan >".ucwords(strtolower($dHead->nama))."</th>";
						$result[] = $data;
					}
				?>
			</tr>
			<tr><?php foreach($result as $val) echo $val['value']; ?></tr>
			<tr style="background:#F6F6F6;">
				<?php
					echo "<th>1</th>";
					echo "<th>2</th>";
					$col = 1;
					for($i=0; $i < count($caseQuery); $i++){
						echo "<th>".(3+$i)."</th>";
					}
				?>
			</tr>
			<?php
				$sql = "SELECT bj.kode, bj.nama, bj.level, bj.islast, bj.parent_id, bj.parent_kode, bj.aktif, ".implode(',',$caseQuery)."
						FROM ak_ms_beban_jenis bj
						LEFT JOIN (
							SELECT j2.*, (SUM(j2.DEBIT) - SUM(j2.KREDIT)) nilai
							FROM jurnal j2
							INNER JOIN ak_ms_unit n
							   ON n.id = j2.CC_RV_ID
							WHERE 0=0 {$waktu}
							GROUP BY j2.MS_BEBAN_JENIS_ID, j2.CC_RV_ID
							) j
						   ON j.MS_BEBAN_JENIS_ID = bj.id
						GROUP BY left(bj.kode,2)
						ORDER BY bj.kode";
			//	echo $sql."<br>";
				$query = mysql_query($sql);
				$no = 1;
				$parent_kode = "kosong";
				$subTotal = $globalTotal = array();
				$subTotalHead = array();
				while($query && $data = mysql_fetch_object($query)){
					if($parent_kode != "kosong" && strlen($parent_kode) > 2){
						// echo $parent_kode."<br />";
						if($parent_kode == '01.02'){
							// echo $subTotal[$parent_kode]['jml']."<br />";
							// print_r($subTotal['01.02']['nilai']);
							// echo $parent_kode.' != '.$data->parent_kode."<br />";
							// echo $data->islast."<br />";
						}
						if($parent_kode != $data->parent_kode && $subTotal[$parent_kode]['jml'] > 1){ // && $data->islast != 0
							echo "<tr><td class='borderbottom'></td><td class='borderbottom kanan'>Jumlah {$parent_kode}</td>";
							foreach($subTotal[$parent_kode]['nilai'] as $key => $val){
								echo "<td class='borderbottom kanan'>".number_format($val,0,",",".")."</td>";
							}
							echo "</tr><tr>";
							$subTotal = array();
						}
					}
					
					//if($data->level == 1 && $data->islast == 0){
					
						echo "<td class='borderbottom' style='font-weight:bold;' align='center'>".$no++.".</td>";
						echo "<td class='borderbottom' style='font-weight:bold;'>".$data->nama."</td>";
				
					
					$subTotalRow = 0;
					$subTotal[$data->parent_kode]['jml'] += 1;
					//print_r($caseQuery);
					foreach($caseQuery as $key => $val){
						//echo "data_key=".$key . "<br>";
						if(strpos($key, 'jumlah') === false){
							echo "<td class='borderbottom' align='right'>".number_format($data->$key,0,",",".")."</td>";
							$subTotalRow  += $data->$key;
							$subTotalHead[$key] += $data->$key;
							$subTotal[$data->parent_kode]['nilai'][$key] += $data->$key;
						} else if(strpos($key, 'jumlah') !== false){
							echo "<td class='borderbottom' align='right'>".number_format($subTotalRow,0,",",".")."</td>";
							$subTotal[$data->parent_kode]['nilai'][$key] += $subTotalRow;
							// $subTotal[$data->parent_kode]['nilai']['jumlah'] = $subTotalRow;
							$subTotalHead[$key] += $subTotalRow;
							$subTotalRow = 0;
						} else {
							echo "<td class='borderbottom'></td>";
						}
						
					}
						
					$parent_kode = $data->parent_kode;
					echo "</tr>";
				}
			?>
			<tr>
				<?php 
					echo "<td class='borderbottom' style='font-weight:bold;' align='center'></td>";
					echo "<td class='borderbottom' style='font-weight:bold;' align='right'>Jumlah {$head}</td>";
					foreach($subTotalHead as $key => $val){
						echo "<td class='borderbottom kanan' style='font-weight:bold;' >".number_format($val,0,",",".")."</td>";
						$globalTotal[$key] += $val;
					}
				?>
			</tr>
			<tr>
				<?php 
					echo "<td class='borderbottom kanan' style='font-weight:bold;'></td>
						<td class='borderbottom kanan' style='font-weight:bold;'>TOTAL BIAYA</td>";
					foreach($globalTotal as $val){
						echo "<td class='borderbottom kanan' style='font-weight:bold;'>".number_format($val,0,",",".")."</td>";
					}
				?>
			</tr>
		</table>
	</div>
	<?php 
		// print_r($subTotal);
	?>
</body>
</html>
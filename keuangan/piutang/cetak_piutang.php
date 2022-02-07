<?php
	include('../sesi.php');
	include('../koneksi/konek.php');
	include '../secured_sess.php';
	
	$defaultsort="tglK";
	$sorting= $_REQUEST["sorting"];
	$filter	= $_REQUEST["filter"];
	
	$wkttgl	= gmdate('d/m/Y',mktime(date('H')+7));
	$wktnow	= gmdate('H:i:s',mktime(date('H')+7));
	$file 	= $_REQUEST['file'];
	$waktu 	= $_REQUEST["waktu"];
	$kso 	= $_REQUEST['kso'];
	$userId	= $_SESSION['id'];
	$tgl 	= tglSQL($_REQUEST['txtTgl']);
	$tgl2 	= tglSQL($_REQUEST['txtTgl2']);
	$data 	= $_REQUEST['data'];
	$lunas 	= $_REQUEST['tipePelunasan'];
	$tipelunas = ($lunas == '1')? 'KSO/Penjamin' : 'Pasien';
	$tipedata = ($data == '1')? 'Piutang' : 'Pelunasan_'.$tipelunas;
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
	
	if($file == 'excel'){
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=cetak_{$tipedata}_{$wkttgl}.xls");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
	}
	
	function forNumber($num){
		global $file;
		if($file == 'excel')
			return $num;
		else 
			return number_format($num,0,",",".");
	}
	
	$fkso="";
	if ($kso!="0"){
		$fkso=" AND p.kso_id='{$kso}'";
		$qKso = "SELECT {$dbbilling}.b_ms_kso.id, billing.b_ms_kso.nama FROM billing.b_ms_kso
			WHERE billing.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
		$dKso = mysql_fetch_array($sKso);
		$nKso = "PENJAMIN : ".$dKso['nama']."<br />";
	} else {
		$nKso = "PENJAMIN : SEMUA";
		$fkso = "";
	}
	
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
	switch($waktu){
		case "harian":
			if($data == '1'){
				$fwaktu = " AND tglP <= '{$tgl}'";
			} else if($data == '2'){
				$fwaktu = " AND tgl_lunasPx <= '{$tgl}'";
				if($lunas == 1){
					$fwaktu = " AND tgl_lunasKSO <= '{$tgl}'";
				}
			}
			$tmpgl = explode('-',$tgl);
			$Periode = "Tanggal : ".$tmpgl[2]." ".$arrBln[$tmpgl[1]]." ".$tmpgl[0];
			break;
		case "periode":
			if($data == '1'){
				$fwaktu = " AND tglP BETWEEN '{$tgl}' AND '{$tgl2}'";
			} else if($data == '2'){			
				$fwaktu = " AND tgl_lunasPx BETWEEN '{$tgl}' AND '{$tgl2}'";
				if($lunas == 1){
					$fwaktu = " AND tgl_lunasKSO BETWEEN '{$tgl}' AND '{$tgl2}'";
				}
			}
			
			$tglAwal = explode('-',$tgl);
			$tglAkhir = explode('-',$tgl2);
			$Periode = "Periode : ".$tglAwal[2]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[0].' s/d '.$tglAkhir[2]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[0];
			break;
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Rekap Biaya Perawatan dan Piutang</title>
	<style type="text/css">
		body{ margin:0px; padding:0px; font-family:Arial; font-size:12px; line-height:1.3em; }
		#container{ width:1280px; margin:10px auto; padding:0px; display:block; }
		#title{ width:100%; display:block; margin-bottom:3px; text-align:left; font-weight:bold; font-size:14px; }
		.isian{ border-collapse: collapse; margin-bottom: 10px; }
		.isian td, .isian th{ padding:5px; border:1px solid #000; }
		.isian th{ background:#E1E1E1; }
		.isian .noborder{ border:0px; }
		#des{ font-size:12px; }
		#signature{ float:right; width:300px; display:block; text-align:center; margin-bottom: 40px; }
	</style>
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
		
		function cetakExcell(){
			//window.location.href = 'lap_bkm.php?id=<?php echo $idBKM; ?>&isExcel=1';
		}
	</script>
</head>
<body>
	<?php if($file != 'excel'){ ?>
	<center>
		<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" type="button" name="btCetak" onclick="cetak()">Cetak <?=$tipedata?></button></span>
	</center>
	<?php } ?>
	<div id="container">	
		<section style="margin-bottom:20px;">
			<b><?php echo $namaRS; ?><br><?php echo $alamatRS; ?><br>Telepon <?php echo $tlpRS; ?></b>
		</section>
		<header id="title">
			<center style="text-transform:uppercase; line-height:1.25em;">
				Laporan <?=$tipedata?><br />
				<?php echo $nKso; ?><br />
				<?php echo $Periode; ?><br />
				<br />
			</center>
			<span id="des"></span>
		</header>
		<section id="detail">
			<table class="isian" width="100%">
				<thead>
					<tr>
						<th width="10px">NO</th>
						<th width="80px">TANGGAL KUNJUNGAN</th>
						<th width="80px">TANGGAL PULANG</th>
						<th width="80px">TANGGAL LUNAS KSO</th>
						<th width="80px">TANGGAL LUNAS Px</th>
						<th width="80px">NO RM</th>
						<th >NAMA</th>
						<th width="120">KSO</th>
						<th width="80px">BIAYA RS</th>
						<th width="80px">BIAYA KSO</th>
						<th width="80px">BIAYA KSO KLAIM</th>
						<th width="80px">BIAYA PASIEN</th>
						<th width="80px">BAYAR KSO</th>
						<th width="80px">BAYAR Px</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "select * from 
									(SELECT p.kunjungan_id, pas.no_rm, pas.nama, p.kso_id, kso.nama nkso, p.tglK, p.tglP, IFNULL(p.tgl_lunasKSO, 
										DATE(ktd.tgl_act)) tgl_lunasKSO, DATE(p.tgl_lunasPx), p.biayaRS, p.biayaKSO, p.biayaKSO_Klaim, p.biayaPasien, 
										p.bayarKSO, IFNULL(SUM(ktd.nilai_terima), 0) bayarKSO2, p.bayarPasien, p.piutangPasien
									FROM k_piutang p
									LEFT JOIN billing.b_kunjungan k ON k.id = p.kunjungan_id
									LEFT JOIN billing.b_ms_pasien pas ON pas.id = k.pasien_id
									INNER JOIN billing.b_ms_kso kso ON kso.id = p.kso_id
									LEFT JOIN k_klaim_detail kd ON kd.fk_id = p.id
									LEFT JOIN k_klaim_terima_detail ktd ON ktd.klaim_detail_id = kd.id
									WHERE 0=0 {$fkso}
									GROUP BY p.kunjungan_id) as gab
									WHERE 0 = 0 {$filter} {$fwaktu}
									ORDER BY kso_id, {$sorting}";
						$query = mysql_query($sql);
						$no = 1;
						$totPer = null;
						while($rows = mysql_fetch_object($query)){
							$tPerda	= $rows->biayaRS;
							$tKSO	= $rows->biayaKSO;
							$tPx	= $rows->biayaPasien;
							$tBayarPx	= $rows->bayarPasien;
							$tBayarKSO	= ($rows->bayarKSO == 0 && $rows->bayarKSO2 > 0) ? $rows->bayarKSO2 : $rows->bayarKSO;
							$tKlaimKSO 	= $rows->biayaKSO_Klaim;
							
							echo "<tr>";
							echo "<td align='center'>".$no++."</td>
									<td align='center'>".$rows->tglK."</td>
									<td align='center'>".$rows->tglP."</td>
									<td align='center'>".$rows->tgl_lunasKSO."</td>
									<td align='center'>".$rows->tgl_lunasPx."</td>
									<td align='center'>".$rows->no_rm."</td>
									<td align='left'>".$rows->nama."</td>
									<td align='center'>".$rows->nkso."</td>
									<td align='right'>".forNumber($tPerda)."</td>
									<td align='right'>".forNumber($tKSO)."</td>
									<td align='right'>".forNumber($tKlaimKSO)."</td>
									<td align='right'>".forNumber($tPx)."</td>
									<td align='right'>".forNumber($tBayarKSO)."</td>
									<td align='right'>".forNumber($tBayarPx)."</td>";
							echo "</tr>";
							
							$totPer += $tPerda;
							$totKso += $KSO;
							$totPas += $tPx;
							$totKlaimKso += $tKlaimKSO;
							$totbayarKso += $tBayarKSO;
							$totbayarPas += $tBayarPx;
						}
					?>
				</tbody>
				<tfoot>
					<?php
						if($totPer!=null){
							echo "<tr>";
							echo "<td align='right' colspan='8'>Total</td>
									<td align='right'>".forNumber($totPer)."</td>
									<td align='right'>".forNumber($totKso)."</td>
									<td align='right'>".forNumber($totKlaimKso)."</td>
									<td align='right'>".forNumber($totPas)."</td>
									<td align='right'>".forNumber($totbayarKso)."</td>
									<td align='right'>".forNumber($totbayarPas)."</td>";
							echo "</tr>";
						}
					?>
				</tfoot>
			</table>
			<div id="signature">
				<p><?php echo $kotaRS; ?>, <?=$wkttgl.' '.$wktnow;?></p>
				<br />
				<br />
				<br />
				<!--b><?=$userId?></b-->
			</div>
		</section>
		<br />
		<br />
		<br />
		<br />
</body>
</html>
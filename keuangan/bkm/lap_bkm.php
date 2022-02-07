<?php
	include('../sesi.php');
	include('../koneksi/konek.php');
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	if($_REQUEST['isExcel'] == '1'){
		//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-type: application/ms-excel');
		header("Content-Disposition: attachment; filename=\"Laporan_BKM_{$tgl}.xls\"");
	}
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	// parameter
	$idBKM = $_REQUEST['id'];
	// get BKM Info
	$sBKM = "SELECT b.*, rek.nama_bank, rek.no_rek
			FROM k_bkm b 
			INNER JOIN k_bkm_detail bd
			   ON b.id = bd.bkm_id
			INNER JOIN k_ms_rek_bank rek
			   ON rek.id = b.ms_rek_bank_id
			WHERE b.id = {$idBKM}";
	$qBKM = mysql_query($sBKM);
	$dBKM = mysql_fetch_array($qBKM);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Laporan BKM</title>
	<style type="text/css">
		body{ font-family:Arial, Tahoma; font-size:12px; }
		#container{ width:960px; margin:10px auto; display:block; margin-bottom:50px;}
		.left{ float:left; width:30%; }
		.right{ float:right; width:30%; }
		.bold{ font-weight:bold; }
		#tbluar{ width:100%; border:1px solid #000; border-collapse:collapse;}
		#tbluar td, #tbluar th{ padding:3px; }
		#tbluar th{ border:1px solid #000; background:#9BD0FF;}
		#tbluar tr.border > td{ border:1px solid #000; }
		#tbluar th.noborder, #tbluar tr.border > td.noborder{ border:0px; background:#fff; }
		#kotakNilai{ border:1px solid #000; width:300px; padding:3px; font-size:12px; letter-spacing:2px; }
		#kotakNilai span{ float:right; }
		#kotakNilai:before{ content:'Rp'; }
		.kotak{ border:1px solid #000; min-width:30px; display:inline-block; padding:3px; }
		.dotted{ border-bottom:1px dotted #1597FA; }
		.title{ background:#9BD0FF; padding:3px; margin:0; font-weight:bold; }
		.judul{ width:50px; display:inline-block; margin-right:10px; }
	</style>
	<script type="text/javascript">
		function cetak(id){
			document.getElementById('cetakID').style.display="none";
			if(!window.print()){
				document.getElementById('cetakID').style.display="inline";
			}
		}
		
		function cetakExcell(){
			window.location.href = 'lap_bkm.php?id=<?php echo $idBKM; ?>&isExcel=1';
		}
	</script>
</head>
<body>
	<?php if($_REQUEST['isExcel'] != '1'){ ?>
	<span id="cetakID" style="float:left; text-align:center; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;">
		<button id="btCetak" name="btCetak" onClick="cetak()"><img src="../icon/printer.png" alt="Cetak Laporan BKM" style="vertical-align:middle;" width="20" />&nbsp;&nbsp;Cetak BKM</button>
		<!--button id="btCetakExcell" name="btCetakExcell" type="button" onClick="cetakExcell()">Export Excell</button-->
	</span>
	<?php } ?>
	<div id="container">
		<table id="tbluar">
			<tbody>
				<tr>
					<td colspan="6">
						<div class="left bold">
							<table>
								<tr><td><?php echo $namaRS; ?></td></tr>
								<tr><td><?php echo $alamatRS; ?></td></tr>
							</table>
						</div>
						<div class="right">
							<table>
								<tr><td>Nomor</td><td>:</td><td><?php echo $dBKM['no_bkm']; ?></td></tr>
								<tr><td>Tanggal</td><td>:</td><td><?php echo tglSQL($dBKM['tgl']); ?></td></tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<div class="left bold">
							<table><tr><td class="bold">BUKTI KAS MASUK</td></tr></table>
						</div>
						<div class="right">
							<table>
								<tr><td>Nama Bank</td><td>:</td><td><?php echo strtoupper($dBKM['nama_bank']); ?></td></tr>
								<tr><td>Nomor Rekening</td><td>:</td><td><?php echo $dBKM['no_rek']; ?></td></tr>
							</table>
						</div>
					</td>
				</tr>
				<tr><td colspan="6">&nbsp;</td></tr>
				<tr>
					<td colspan="5">
						<table id="info" style="width:100%">
							<tr>
								<td width="120px">Diterima dari</td>
								<td>:</td>
								<td class="dotted"><?php echo $dBKM['terima_dari']; ?></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td><div id="kotakNilai"><span><?php echo number_format($dBKM['nilai'],2,',','.'); ?></span></div></td>
							</tr>
							<tr>
								<td>Terbilang</td>
								<td>:</td>
								<td class="dotted"><?php echo ucwords(terbilang($dBKM['nilai'])); ?> Rupiah</td>
							</tr>
							<tr>
								<td>Uraian</td>
								<td>:</td>
								<td class="dotted"><?php echo $dBKM['uraian']; ?></td>
							</tr>
						</table>
					</td>
					<td width="130px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<th width="50px" >No</th>
					<th width="" >No Bukti</th>
					<th width="" >Keterangan</th>
					<th width="150px" >Debet</th>
					<th width="150px" >Kredit</th>
					<th class="noborder"></th>
				</tr>
				<tr class="border">
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="noborder"></td>
				</tr>
				<tr class="border">
					<td>&nbsp;</td>
					<td></td>
					<td>BANK BLUD</td>
					<td align="right"><?php echo number_format($dBKM['nilai'],2,',','.'); ?></td>
					<td align="right"></td>
					<td class="noborder"></td>
				</tr>
				<?php 
					$arrQ = array(
								"billing" 	=> "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, IF(bd.no_bukti <> '', bd.no_bukti, '-') no_bukti, CONCAT(IFNULL(u.nama, 'BILLING'),' - ',mp.nama) ket
												FROM k_bkm_detail bd
												INNER JOIN k_transaksi t
												   ON t.bkm_detail_id = bd.id
												LEFT JOIN {$dbbilling}.b_ms_unit u
												   ON u.id = t.unit_id_billing
												INNER JOIN $dbbilling.b_ms_pegawai mp 
												   ON mp.id = t.kasir_id 
												WHERE bd.bkm_id = {$idBKM}
												  AND t.id_trans = 38
												  AND (t.bkm_detail_id IS NOT NULL 
												   OR t.bkm_detail_id <> 0)
												GROUP BY t.no_bukti, t.kasir_id",
								"farmasi" 	=> "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, bd.no_bukti, GROUP_CONCAT(DISTINCT(u.UNIT_NAME) SEPARATOR ', ') ket 
												FROM k_bkm_detail bd
												INNER JOIN k_transaksi t
												   ON t.bkm_detail_id = bd.id
												INNER JOIN {$dbapotek}.a_unit u
												   ON u.UNIT_ID = t.unit_id
												WHERE bd.bkm_id = {$idBKM}
												  AND t.id_trans = 39
												  AND (t.bkm_detail_id IS NOT NULL 
												   OR t.bkm_detail_id <> 0)
												GROUP BY t.no_bukti",
								"parkir" 	=> "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, bd.no_bukti, 'Parkir' ket
												FROM k_bkm_detail bd
												INNER JOIN k_parkir p
												   ON p.bkm_detail_id = bd.id
												WHERE bd.bkm_id = {$idBKM}
												  AND bd.id_trans = 6
												  AND (p.bkm_detail_id IS NOT NULL 
												   OR p.bkm_detail_id <> 0)
												GROUP BY p.no_bukti, DATE(p.tgl_setor)",
								"ambulan"	=> "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, bd.no_bukti, 'Ambulan' ket
												FROM k_bkm_detail bd
												INNER JOIN k_ambulan a
												   ON a.bkm_detail_id = bd.id
												WHERE bd.bkm_id = {$idBKM}
												  AND bd.id_trans = 30
												  AND (a.bkm_detail_id IS NOT NULL 
												   OR a.bkm_detail_id <> 0)
												GROUP BY a.no_bukti, DATE(a.tgl_setor)",
								"diklit"	=> "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, bd.no_bukti, 'Penerimaan Diklit' ket
												FROM k_bkm_detail bd
												INNER JOIN db_rspendidikan.ku_bayar b
												   ON b.bkm_detail_id = bd.id
												WHERE bd.bkm_id = {$idBKM}
												  AND bd.id_trans = 64
												  AND (b.bkm_detail_id IS NOT NULL 
												   OR b.bkm_detail_id <> 0)
												GROUP BY b.byr_kode, b.petugas_id",
								'lain2'	  => "SELECT bd.bkm_id, bd.id, bd.id_trans, bd.kasir_id, bd.nilai, bd.no_bukti, 
													CONCAT('Penerimaan ', mt.nama) ket
											FROM k_bkm_detail bd
											INNER JOIN k_transaksi t
											   ON t.bkm_detail_id = bd.id
											INNER JOIN k_ms_transaksi mt
											   ON mt.id = t.id_trans
											INNER JOIN k_ms_user u
											   ON u.id = t.user_act
											WHERE bd.bkm_id = {$idBKM}
											  AND (t.bkm_detail_id IS NOT NULL 
											   OR t.bkm_detail_id <> 0)
											  AND mt.tipe = '1'
											  AND mt.isManual = '1'
											GROUP BY t.id_trans, t.no_bukti, t.user_act"
							);
							
					$sql = "SELECT t1.* FROM (".implode(' UNION ',$arrQ).") as t1";
					//echo $sql;
					$query = mysql_query($sql);
					$no = 1;
					$total = 0;
					while($data = mysql_fetch_array($query)){
						echo '<tr class="border">';
						echo "<td align='center'>{$no}</td>
							<td align='center'>".$data['no_bukti']."</td>
							<td>".$data['ket']."</td>
							<td align='right'></td>
							<td align='right'>".number_format($data['nilai'],2,",",".")."</td>
							<td class='noborder'></td>";
						echo '</tr>';
						$total += $data['nilai'];
						$no++;
					}
				?>
				<tr class="border">
					<td class="noborder" colspan="2"></td>
					<td align="center">&nbsp;</td>
					<td align="right"></td>
					<td align="right"></td>
					<td class="noborder"></td>
				</tr>
				<tr class="border">
					<td class="noborder" colspan="2"></td>
					<td align="center">JUMLAH</td>
					<td align="right"><?php echo number_format($dBKM['nilai'],2,',','.'); ?></td>
					<td align="right"><?php echo number_format($total,2,",","."); ?></td>
					<td class="noborder"></td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">
						Bukti : <span class="kotak">&nbsp;</span>&nbsp;Terlampir &nbsp; <span class="kotak">&nbsp;</span>&nbsp;Tidak Ada
					</td>
				</tr>
				<tr class="border">
					<td class="noborder" style="padding:0;" colspan="2"></td>
					<td align="center" style="padding:0;">
						<div class="title">Dibukukan</div>
						<br /><br /><br /><br />
						Akuntansi
					</td>
					<td align="center" style="padding:0;">
						<div class="title">Mengetahui</div>
						Kabag Keuangan
						<br /><br /><br /><br />
						Dra. Ec Retno Utari, MM
					</td>
					<td align="center" style="padding:0;">
						<div class="title">Diperiksa</div>
						Kasubag Pendapatan
						<br /><br /><br /><br />
						Lucky Budi S
					</td>
					<td align="center" style="padding:0;">
						<div class="title">&nbsp;</div>
						Bendahara Penerima
						<br /><br /><br /><br />
						Siwi Dharmi Rahayu
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
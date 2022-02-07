<?php
	session_start();
	include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
	include('../koneksi/konek.php');
	$iduser = $_SESSION['id'];
	$tglact=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
	
	$tglAwal = $_REQUEST['tglAwal']; $t1 = explode('-',$tglAwal);
	$tgl1 = $t1[2]."-".$t1[1]."-".$t1[0];

	$tglAkhir = $_REQUEST['tglAkhir']; $t2 = explode('-',$tglAkhir);
	$tgl2 = $t2[2]."-".$t2[1]."-".$t2[0];
	
	$tipetrans=$_REQUEST['cmbTipeTransObat'];
	
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
			LAPORAN PENGEMBALIAN UANG RETUR FARMASI<br />
			PERIODE TGL RETUR: <?php echo "{$tglAwal} s/d {$tglAkhir}"; ?>
		</p>
		<?php
			$ftipe="";
			if($tipetrans != '0'){
				$ftipe = " AND t1.tipe = {$tipetrans}";
			}
			
			$fwheree = "AND rp.tgl_retur BETWEEN '{$tgl1} 00:00:00' AND '{$tgl2} 23:59:59'";
			switch($tipetrans){
				case '1':
					$fwheree = "AND pu.tgl_act BETWEEN '{$tgl1} 00:00:00' AND '{$tgl2} 23:59:59'";
					break;
				case '2':
					$fwheree = "AND rp.tgl_retur BETWEEN '{$tgl1} 00:00:00' AND '{$tgl2} 23:59:59'";
					break;
			}
			$sql = "SELECT t1.*, ku.nama petugas
					FROM (SELECT IF(ap.NO_PASIEN <> '',ap.NO_PASIEN, '-') norm, ap.NAMA_PASIEN, ap.NO_KUNJUNGAN, ap.NO_PENJUALAN, 
							u.UNIT_ID, u.UNIT_NAME, IFNULL(uu.UNIT_NAME,'-') ruangan, rp.no_retur, pu.no_pengembalian, 
							IFNULL(pu.nilai, IF(rp.nilai_balik_px = 0, rp.nilai, rp.nilai_balik_px)) nilai, pu.user_act, 
							DATE_FORMAT(rp.tgl_retur, '%d-%m-%Y %H:%i:%s') tglretur,
							DATE_FORMAT(pu.tgl_act, '%d-%m-%Y %H:%i:%s') tglbalik,
							pu.tgl_act tgl_balik, rp.tgl_retur, ap.TGL_ACT tgl_jual,
							IF(pu.no_pengembalian IS NULL, 2, 1) tipe, pu.unit_id unit_balik
						FROM {$dbapotek}.a_return_penjualan rp
						INNER JOIN {$dbapotek}.a_penjualan ap
						   ON ap.ID = rp.idpenjualan
						INNER JOIN {$dbapotek}.a_unit u
						   ON u.UNIT_ID = ap.UNIT_ID
						LEFT JOIN {$dbapotek}.a_unit uu
						   ON uu.UNIT_ID = ap.RUANGAN
						LEFT JOIN {$dbapotek}.a_pengembalian_uang pu
						   ON rp.no_retur = pu.no_retur
						  AND ap.NO_PENJUALAN = pu.no_penjualan
						  AND ap.NO_PASIEN = pu.no_rm
						  AND ap.NO_KUNJUNGAN = pu.no_pelayanan
						WHERE rp.balik_uang = 1
						  {$fwheree}
						GROUP BY rp.no_retur) AS t1
					left JOIN k_ms_user ku
					   ON ku.id = t1.user_act
					WHERE (t1.unit_balik IS NULL OR t1.unit_balik = 0)
						{$ftipe}
					ORDER BY t1.tipe ASC, t1.ruangan, t1.tgl_retur DESC, t1.tgl_balik DESC";
			$no = 1;
			//echo $sql;
			$query = mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($query) > 0){
		?>
		<table id='dataIsi'>
			<tr>
				<th>No.</th>
				<th width="110">No Pengembalian</th>
				<th width="110">Tgl Pengembalian</th>
				<th width="80">NoRM</th>
				<th width="160">Nama Pasien</th>
				<th>Unit Farmasi</th>
				<th>Ruangan</th>
				<th width="60">No Retur</th>
				<th width="110">Tgl Retur</th>
				<th width="80">Nilai</th>
				<th>Petugas</th>
				<!--th>Status</th-->
			</tr>
			<?php
				$tmp = '';
				$globTotal = $jml = 0;
				$nodalam = 1;
				while($data = mysql_fetch_object($query)){
					$status = '<font color="red" style="font-weight:bold;">BELUM DIKEMBALIKAN</font>';
					if($data->tipe == '1'){
						$status = '<font color="blue" style="font-weight:bold;">SUDAH DIKEMBALIKAN</font>';
					}
					if($tmp != $data->tipe && $no <> 1){
			?>
			<tr>
				<td colspan="9" align="right">Total Dikembalikan</td>
				<td align="right"><?php echo number_format($jml,2,',','.'); ?></td>
				<td>&nbsp;</td>
				<!--td>&nbsp;</td-->
			</tr>
				<?php
						$globTotal += $jml;
						$nodalam = 1;
						$jml = 0;
					}
					if($no == 1 || $tmp != $data->tipe){
			?>
			<tr>
				<td colspan="11"><?php echo $status; ?></td>
			</tr>
			<?php
					}
			?>
			<tr>
				<td align="center"><?php echo $nodalam++; ?></td>
				<td align="center"><?php echo $data->no_pengembalian; ?></td>
				<td align="center"><?php echo $data->tglbalik; ?></td>
				<td align="center"><?php echo $data->norm; ?></td>
				<td align="left"><?php echo $data->NAMA_PASIEN; ?></td>
				<td align="center"><?php echo $data->UNIT_NAME; ?></td>
				<td align="center"><?php echo $data->ruangan; ?></td>
				<td align="center"><?php echo $data->no_retur; ?></td>
				<td align="center"><?php echo $data->tglretur; ?></td>
				<td align="right"><?php echo number_format($data->nilai,2,',','.'); ?></td>
				<td align="center"><?php echo $data->petugas; ?></td>
				<!--td align="center"><?php echo $status; ?></td-->
			</tr>
			<?php
					$no++;
					$jml += $data->nilai;
					$tmp = $data->tipe;
				}
			?>
			<tr>
				<td colspan="9" align="right">Total Belum Dikembalikan</td>
				<td align="right"><?php echo number_format($jml,2,',','.'); ?></td>
				<td>&nbsp;</td>
				<!--td>&nbsp;</td-->
			</tr>
			<!--tr>
				<td colspan="9" align="right"><b>Total Global</b></td>
				<td align="right"><b><?php echo number_format($globTotal+$jml,2,',','.'); ?></b></td>
				<td>&nbsp;</td>
			</tr-->
			<tr>
				<td colspan="8" style='border:0px;' ></td>
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
			echo "<p align='center' class='judul'><br />Tidak Ada Data Pengembalian Retur Obat Pada Periode {$tglAwal} s/d {$tglAkhir}</p>";
			}
		?>
	</div>
</body>
</html>
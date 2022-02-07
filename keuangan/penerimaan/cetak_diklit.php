<?php
	include('../sesi.php');
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	if($_REQUEST['isExcel'] == '1'){
		//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-type: application/ms-excel');
		header("Content-Disposition: attachment; filename=\"Penerimaan_Diklit_{$tgl}.xls\"");
	}
	include("../koneksi/konek.php");
	$bln = ($_REQUEST['bln']!='')?$_REQUEST['bln']:$_REQUEST['cmbBln'];
	$thn = ($_REQUEST['thn']!='')?$_REQUEST['thn']:$_REQUEST['cmbThn'];
	$tgl_s = $_REQUEST['tgl_s'];
	$tgl_d = $_REQUEST['tgl_d'];
	$no_slip = $_REQUEST['no_slip'];
	$defaultsort = "b.byr_tgl ASC";
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
	<title>Laporan Penerimaan Diklit</title>
	<style type="text/css">
		#tabelIsi{
			border-collapse:collapse;
			font-size:12px;
		}
		#tabelIsi th{
			font-weight:bold;
			background:#E1E1E1;
		}
		#tabelIsi td, #tabelIsi th{
			border:1px solid #000;
			padding:5px;
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
			window.location.href = 'cetak_diklit.php?tipe=1&isExcel=1&bln=<?php echo $bln; ?>&thn=<?php echo $thn; ?>';
		}
	</script>
</head>
<body>
	<?php if($_REQUEST['isExcel'] != '1'){ ?>
	<span id="cetakID" style="float:left; text-align:center; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;">
		<button id="btCetak" name="btCetak" onClick="cetak()">Cetak Penerimaan</button>
		<button id="btCetakExcell" name="btCetakExcell" type="button" onClick="cetakExcell()">Export Excell</button>
	</span>
	<?php } ?>
	<div id="container">
	<p style="font-weight:bold; font-size:16px; text-transform: uppercase;">
		Penerimaan Diklit <?php echo $arrBln[$bln]." ".$thn; ?>
		<br />
		<?php echo $namaRS; ?>
	</p>
	<table id="tabelIsi">
		<thead>
		<tr>
			<th align="center" width="20px" >No.</th>
			<th align="center" width="80" >Tgl Bayar</th>
			<th align="center" width="80" >No Induk</th>
			<th align="center" width="200" >Nama</th>
			<th align="center" width="80" >No Kwitansi</th>
			<th align="center" width="200" >Jenis Bayar</th>
			<th align="center" width="80" >Periode Bayar</th>
			<th align="center" width="80" >Nilai</th>
			<th align="center" width="80" >Pendanaan</th>
			<th align="center" width="100" >Penerima</th>
			<th align="center" width="80" >Tgl Verifikasi</th>
			<th align="center" width="80" >Petugas<br />Verifikasi</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			if($tgl_s != ""){
				$fwaktu = "AND b.tgl_verifikasi BETWEEN '".tglSQL($tgl_s)." 00:00:00' AND '".tglSQL($tgl_d)." 23:59:59'";
			} else {
				$fwaktu = "AND MONTH(b.tgl_verifikasi) = '$bln' AND YEAR(b.tgl_verifikasi) = '$thn'";
			}
			$fnoslip = "";
			if($no_slip!=""){
				$fnoslip = "AND b.byr_kode = '{$no_slip}'";
			}
			$sql = "SELECT DISTINCT b.byr_id,b.byr_tgl,date(b.byr_tgl) tglByar, b.byr_kode, b.siswa_id, b.byr_thn, b.byr_bln, 
						j.byrjns, b.byrjns_id, b.nilai, s.siswa_nama, s.siswa_npm, ks.sbdana, mu.user_nama, b.verifikasi, DATE(b.tgl_verifikasi) tgl_verifikasi, u.nama
					FROM db_rspendidikan.ku_bayar  b 
					INNER JOIN db_rspendidikan.siswa s ON b.siswa_id = s.siswa_id 
					INNER JOIN db_rspendidikan.ku_jenisbayar j ON b.byrjns_id = j.byrjns_id 
					LEFT JOIN db_rspendidikan.ku_sbdana ks ON b.sbdana_id = ks.sbdana_id
					LEFT JOIN db_rspendidikan.ms_user mu ON b.petugas_id = mu.user_id
					INNER JOIN keuangan.k_ms_user u ON u.id = b.user_verifikasi
					WHERE 0=0 {$filter} {$fwaktu} {$fnoslip} AND b.verifikasi <> 0
					ORDER BY {$sorting}";
			$query = mysql_query($sql);
			$i = 1;
			$total = 0;
			while($data = mysql_fetch_array($query)){
				echo "
					<tr>
						<td align='center'>".$i++."</td>
						<td align='center'>".tglSQL($data['tglByar'])."</td>
						<td align='center'>".$data['siswa_npm']."</td>
						<td >".$data['siswa_nama']."</td>
						<td align='center'>".$data['byr_kode']."</td>
						<td align='left'>".$data['byrjns']."</td>
						<td align='center'>".$data['byr_thn']."</td>
						<td align='right'>".number_format($data['nilai'],0,",",".")."</td>
						<td align='center'>".$data['sbdana']."</td>
						<td align='center'>".$data['user_nama']."</td>
						<td align='center'>".tglSQL($data['tgl_verifikasi'])."</td>
						<td align='center'>".$data['nama']."</td>
					</tr>
				";
				$total += $data['nilai'];
			}
		?>
		<tr>
			<td colspan="7" align="right">Total</td>
			<td align="right"><?php echo number_format($total,0,",","."); ?></td>
			<td colspan="4">&nbsp;</td>
		</tr>
		</tbody>
	</table>
	</div>
	<span style="width:100%; height:30px; display:block;"></span>
</body>
</html>
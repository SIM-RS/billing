<?php
	session_start();
	include('../sesi.php');
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	if($_REQUEST['isExcel'] == '1'){
		//header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-type: application/ms-excel');
		header("Content-Disposition: attachment; filename=\"Penerimaan_Ambulan_{$tgl}.xls\"");
	}
	include("../koneksi/konek.php");
	$bln = ($_REQUEST['bln']!='')?$_REQUEST['bln']:$_REQUEST['cmbBln'];
	$thn = ($_REQUEST['thn']!='')?$_REQUEST['thn']:$_REQUEST['cmbThn'];
	$defaultsort = "tgl ASC";
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
			background:#e1e1e1;
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
			window.location.href = 'cetak_ambulan.php?tipe=1&isExcel=1&bln=<?php echo $bln; ?>&thn=<?php echo $thn; ?>';
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
		Penerimaan Ambulan 
		<br />
		<?=$namaRS;?>
		<br />
		Bulan <?php echo $arrBln[$bln]." ".$thn; ?>
	</p>
	<table id="tabelIsi">
		<tr>
			<th align="center" width="20px" >No.</th>
			<th align="center" width="100" >Tgl Pelayanan</th>
			<th align="center" width="100" >Tgl Setor</th>
			<th align="center" width="80" >Jam</th>
			<th align="center" width="100" >Layanan</th>
			<th align="center" width="120" >Tipe Ambulan</th>
			<th align="center" width="100" >No Bukti</th>
			<th align="center" width="100" >Nilai</th>
			<th align="center" width="200" >Keterangan</th>
			<th align="center" width="100" >Petugas</th>
		</tr>
		<?php 
			$fwaktu = "AND MONTH(tgl_act) = $bln AND YEAR(tgl_act) = $thn ";
			$sql = "select *
					FROM (SELECT DATE_FORMAT(a.tgl,'%d-%m-%Y') tgl, DATE_FORMAT(a.tgl_setor,'%d-%m-%Y') tgl_setor, 
								DATE_FORMAT(a.tgl_setor,'%H:%i') jam_setor,
								IF(a.ambulan_tipe = 0, 'Jenazah', 'Rescue') nama, a.no_bukti, a.nilai, u.nama username,
								IF(a.is_pavilyun = 0, 'RSPM', 'Pavilyun') tipePeng, a.tgl_setor tgl_act, a.ket
							FROM k_ambulan a
							INNER JOIN k_ms_user u
							   ON u.id = a.user_act  WHERE a.flag = '$flag') t1
					WHERE 0 = 0 $filter $fwaktu
					ORDER BY $sorting";
			//echo $sql;
			$query = mysql_query($sql);
			if($query == FALSE){
				echo mysql_error();
			}
			$i = 1;
			$total = 0;
			while($data = mysql_fetch_array($query)){
				echo "
					<tr>
						<td align='center'>".$i++."</td>
						<td align='center'>".$data['tgl']."</td>
						<td align='center'>".$data['tgl_setor']."</td>
						<td align='center'>".$data['jam_setor']."</td>
						<td align='center'>".$data['tipePeng']."</td>
						<td >".$data['nama']."</td>
						<td align='center'>".$data['no_bukti']."</td>
						<td align='right'>".number_format($data['nilai'],0,",",".")."</td>
						<td align='right'>".$data['ket']."</td>
						<td align='center'>".$data['username']."</td>
					</tr>
				";
				$total += $data['nilai'];
			}
		?>
		<tr>
			<td colspan="7" align="right">Total</td>
			<td align="right"><?php echo number_format($total,0,",","."); ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	</div>
	<span style="width:100%; height:30px; display:block;"></span>
</body>
</html>
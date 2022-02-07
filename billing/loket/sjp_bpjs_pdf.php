<?php
ob_start();
session_start();
$sessionId = $_SESSION['userId'];
if(!isset($sessionId)){ header('Location: ../../index.php'); }

include("../koneksi/konek.php");
$date_now = gmdate('d-m-Y',mktime(date('H')+7));
$kunjungan_id = $_REQUEST['hid_kunjungan_id'];
$jenis_kunjungan = $_REQUEST['jenis_kunjungan'];

$sql = "SELECT k.no_sjp, DATE_FORMAT(k.tgl_sjp, '%d/%m/%Y') AS tgl_sjp, 
			   k.no_sjp_inap, DATE_FORMAT(k.tgl_sjp_inap, '%d/%m/%Y') AS tgl_sjp_inap, k.no_anggota,
			   pas.no_rm, pas.nama AS pasien, pas.nama_panggilan, pas.sex, DATE_FORMAT(pas.tgl_lahir, '%d/%m/%Y') AS tgl_lahir, pek.nama AS pekerjaan,
			   jns.nama AS jnsRawat, tmp.nama AS tmpLayanan, kelas.nama AS hakKelas,
			   d.nama AS diagnosa
			FROM b_kunjungan k
			INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
			INNER JOIN b_ms_pekerjaan pek ON pek.id = k.pekerjaan_id
			INNER JOIN b_ms_unit tmp ON tmp.id = k.unit_id
			INNER JOIN b_ms_unit jns ON jns.id = k.jenis_layanan
			INNER JOIN b_ms_kelas kelas ON kelas.id = k.kso_kelas_id
			LEFT JOIN b_ms_diagnosa d ON d.id = k.diag_awal
		WHERE k.id = '{$kunjungan_id}'";
$query = mysql_query($sql);
$rows = mysql_fetch_array($query);
$jnsRawat = $rows['jnsRawat'];
$poli = $rows['tmpLayanan'];
$no_sjp = $rows['no_sjp'];
$tgl_sjp = $rows['tgl_sjp'];
if ($jenis_kunjungan==1){
	$jnsRawat = "RAWAT INAP";
	$poli = "";
	$no_sjp = $rows['no_sjp_inap'];
	$tgl_sjp = $rows['tgl_sjp_inap'];
}

?>
<style type="text/css">
<!--
	.container {
		width: 850px;
		height: auto;
		font-family: Arial, Helvetica, Sans-Serif;
		font-size: 14px;
	}
	.logo {
		position: absolute;
		margin-top: 30px; 
		margin-left: 3px;
	}
	.header {
		position: absolute;
		width: 230px;
		text-align: center;
		font-weight: bold;
		margin-top: 30px;
		margin-left: 250px;
	}
	.footer {
		font-size: 10px;
		font-style: italic;
	}
	.isi {
		margin-top: 55px;
	}
	table {
		border-spacing: 0;
		border-collapse: collapse;
	}
	.table-isi td {
		padding-top: 4px;
		padding-left: 2px;
		padding-right: 2px;
		padding-bottom: 4px;
	}
	.ttdPas {
		width: 200px;
		font-size: 12px;
		margin-top:
	}
-->
</style>
<div class="container">
	<div class="logo"><!--img src="../images/bpjs_logo.png" alt="" height="35" /--></div>
	<div class="header">SURAT ELEGIBILITAS PESERTA RS PELABUHAN MEDAN </div>
	<div class="isi">
		<table class="table-isi">
			<tr>
				<td width="90">No. SEP</td>
				<td width="5" align="center">:</td>
				<td colspan="4">
					<?php echo $no_sjp; ?>
				</td>
			</tr>
			<tr>
				<td>Tgl. SEP</td>
				<td align="center">:</td>
				<td>
					<?php echo $tgl_sjp; ?>
				</td>
				<td width="65">No RM</td>
				<td align="center" width="5">:</td>
				<td>
					<?php echo $rows['no_rm']; ?>
				</td>
			</tr>
			<tr>
				<td>No. Kartu</td>
				<td align="center">:</td>
				<td width="270">
					<?php echo $rows['no_anggota']; ?>
				</td>
				<td>Peserta</td>
				<td align="center" width="5">:</td>
				<td>PESERTA BPJS
					<?php //echo $rows['pekerjaan']; ?>
				</td>
			</tr>
			<tr>
				<td>Nama Peserta</td>
				<td align="center">:</td>
				<td width="330">
					<?php echo $rows['nama_panggilan']; ?>
				</td>
			</tr>
			<tr>
				<td>Tgl. Lahir</td>
				<td align="center">:</td>
				<td>
					<?php echo $rows['tgl_lahir']; ?>
				</td>
				<td>COB</td>
				<td align="center">:</td>
				<td></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td align="center">:</td>
				<td>
					<?php echo $rows['sex']; ?>
				</td>
				<td>Jenis Rawat</td>
				<td align="center">:</td>
				<td>
					<?php echo $jnsRawat; ?>
				</td>
			</tr>
			<tr>
				<td valign="top">Poli Tujuan</td>
				<td valign="top" align="center">:</td>
				<td valign="top" width="330">
					<?php echo $poli; ?>
				</td>
				<td>Hak Kelas Pasien</td>
				<td align="center">:</td>
				<td>
					<?php echo $rows['hakKelas']; ?>
				</td>
			</tr>
			<tr>
				<td valign="top">Asal Faskes Tk. I</td>
				<td valign="top" align="center">:</td>
				<td width="330" valign="top"></td>
			</tr>
			<tr>
				<td valign="top">Diagnosa Awal</td>
				<td valign="top" align="center">:</td>
				<td width="330">
					<?php echo $rows['diagnosa']; ?>
				</td>
				<td colspan="3">
					<table style="font-size:11px;">
						<tr>
							<td>Pasien / Keluarga Pasien</td>
							<td style="padding-left:30px;">Petugas BPJS Kesehatan</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top" style="padding-bottom:8px;">Catatan</td>
				<td valign="top" align="center">:</td>
				<td width="330"></td>
			</tr>
			<tr>
				<td colspan="3" class="footer">
					* Saya menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.
				</td>
			</tr>
			<tr>
				<td colspan="3" class="footer">
					* SEP bukan sebagai bukti per jaminan peserta
				</td>
				<td colspan="3">
					<table style="font-size:11px;">
						<tr>
							<td>_____________________</td>
							<td style="padding-left:30px;">_____________________</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../include/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('L', 'A5', 'en', true, 'UTF-8', array(3, 4, 3, 4));
		//$html2pdf = new HTML2PDF('L', 'A5', 'en', true, 'UTF-8');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('Surat_Elegibilitas_Peserta_'.$rows['no_rm'].'.pdf','D');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
?>
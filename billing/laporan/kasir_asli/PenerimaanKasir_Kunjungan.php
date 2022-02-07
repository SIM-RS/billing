<?php 
session_start();
include("../../sesi.php");
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Rekapitulasi Penerimaan Kasir Berdasarkan Kunjungan Pasien :.</title>
</head>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	$kasir = $_REQUEST['cmbKasir2'];
	$nmKasir = $_REQUEST['nmKsr'];
	
	$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
	$rsKsr = mysql_query($qKsr);
	$rwKsr = mysql_fetch_array($rsKsr);
	
?>
<style>
	.tblatas
	{
		font-weight:bold;
		text-transform:uppercase;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		background-color:#00FFFF;
		text-align:center;
	}
</style>
<body>
<table id="tblPrint" width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?php echo $namaRS; ?><br /><?php echo $alamatRS; ?><br />Telepon <?php echo $tlpRS;?><br /><?php echo $kotaRS;?></b></td>
	</tr>
	<tr>
		<td align="center" height="70" valign="middle" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan <?php echo $rwKsr['nama'];?><br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;<?php echo $rwKsr['nama']?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td width="3%" class="tblatas" height="30">no</td>
					<td width="6%" class="tblatas">no rm</td>
					<td width="8%" class="tblatas">nama</td>
					<td width="4%" class="tblatas">ruang</td>
					<td width="6%" class="tblatas">mrs</td>
					<td width="6%" class="tblatas">krs</td>
					<td width="6%" class="tblatas">retribusi/<br />kamar</td>
					<td width="6%" class="tblatas">tindakan</td>
					<td width="6%" class="tblatas">pk</td>
					<td width="6%" class="tblatas">pa</td>
					<td width="6%" class="tblatas">rad</td>
					<td width="6%" class="tblatas">hd</td>
					<td width="6%" class="tblatas">end</td>
					<td width="6%" class="tblatas">ok /<br />ok igd</td>
					<td width="6%" class="tblatas">OBAT</td>
					<td width="7%" class="tblatas">total</td>
					<td width="12%" class="tblatas">status</td>
				</tr>
				<?php
						if($nmKasir!=0){
							$fKasir = "b_bayar.user_act = '".$nmKasir."'";
						}else{
							$fKasir = "b_ms_pegawai_unit.unit_id = '".$kasir."'";
						}
						$sqlNm = "SELECT 
						b_ms_pegawai.id, 
						b_ms_pegawai.nama 
						FROM b_bayar 
						INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act 
						INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id 
						WHERE $fKasir 
						AND b_bayar.kasir_id = '".$kasir."'
						AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' 
						GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
						//echo $sqlNm."<br>";
						$rsNm = mysql_query($sqlNm);
						while($rwNm = mysql_fetch_array($rsNm))
						{
				?>
				<tr>
					<td colspan="17" style="padding-left:20px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="25" valign="bottom"><?php echo $rwNm['nama'];?></td>
				</tr>
				<?php
						$sqlPas = "SELECT t.no_rm, t.pasien, t.kunjungan_id FROM (SELECT b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_kunjungan.id AS kunjungan_id FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'
UNION
SELECT b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_kunjungan.id AS kunjungan_id FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=1 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') AS t GROUP BY t.kunjungan_id";
						//echo $sqlPas."<br>";
						$rsPas = mysql_query($sqlPas);
						$no=1;
						$tot=0;
						$tret = 0;
						$ttin = 0;
						$tpk = 0;
						$tpa = 0;
						$trad = 0;
						$thd = 0;
						$tend = 0;
						$tok = 0;
						$tobat = 0;
						while($rwPas = mysql_fetch_array($rsPas))
						{
				?>
				<tr valign="bottom">
					<td style="text-align:center;"><?php echo $no;?></td>
					<td style="text-align:center;"><?php echo $rwPas['no_rm']?></td>
					<td colspan="3" height="25" style="padding-left:5px; text-transform:uppercase;"><?php echo $rwPas['pasien']?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php
						$qcek = "SELECT b_ms_unit.nama, b_ms_unit.penunjang FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' LIMIT 1";
						$scek = mysql_query($qcek);
						$wcek = mysql_fetch_array($scek);
						/*if($wcek['penunjang']==1){
							$sql = "SELECT t.id, t.nama, t.inap, t.pelayanan_id, t.status FROM (SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS status FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id_asal INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan.kso_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND u.penunjang=0 AND b_bayar_tindakan.tipe=0 UNION SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS status FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id_asal INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan.kso_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND u.penunjang=0 AND b_bayar_tindakan.tipe=1 ) AS t GROUP BY t.pelayanan_id";
						}else{*/
							$sql = "SELECT t.id, t.nama, t.inap, t.penunjang, t.pelayanan_id, t.status FROM (SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_ms_unit.penunjang, b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS status FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan.kso_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_ms_unit.penunjang=0 AND b_bayar_tindakan.tipe=0 UNION SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_ms_unit.penunjang, IFNULL(b_pelayanan.id,0) AS pelayanan_id, b_ms_kso.nama AS STATUS FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id_asal INNER JOIN b_ms_unit mu ON mu.id=b_pelayanan.unit_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan.kso_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_ms_unit.penunjang=1 AND mu.penunjang=1 AND b_bayar_tindakan.tipe=0 UNION SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap, b_ms_unit.penunjang, b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS status FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso ON b_ms_kso.id=b_tindakan.kso_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_ms_unit.penunjang=0 AND b_bayar_tindakan.tipe=1 ) AS t GROUP BY t.id ORDER BY t.pelayanan_id";
						//}
						//echo $sql."<br>";
						//if ($no==2) echo $sql."<br>";
						$rs = mysql_query($sql);
						$jml = 0;
						$ret = 0;
						$tin = 0;
						$pk = 0;
						$pa = 0;
						$rad = 0;
						$hd = 0;
						$end = 0;
						$ok = 0;
						$obat = 0;
						while($rw = mysql_fetch_array($rs))
						{
							$qTgl = "SELECT DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS masuk, DATE_FORMAT(b_pelayanan.tgl_krs,'%d-%m-%Y') AS keluar, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d-%m-%Y') AS krs FROM b_pelayanan LEFT JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id WHERE b_pelayanan.id='".$rw['pelayanan_id']."'";
							$sTgl = mysql_query($qTgl);
							$wTgl = mysql_fetch_array($sTgl);
							
							if($rw['inap']==1){
								//$qRet = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.id='".$rw['pelayanan_id']."' AND b_bayar_tindakan.tipe=1 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' ";
								$qRet = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_pelayanan.unit_id='".$rw['id']."' AND b_bayar_tindakan.tipe=1 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' ";
							}else{
								//$qRet = "SELECT b_bayar_tindakan.nilai FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.id='".$rw['pelayanan_id']."' AND b_ms_tindakan.klasifikasi_id=11 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
								$qRet = "SELECT SUM(b_bayar_tindakan.nilai) nilai FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_pelayanan.unit_id='".$rw['id']."' AND b_ms_tindakan.klasifikasi_id=11 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							}
							//echo '<br>'.$qRet;
							$sRet = mysql_query($qRet);
							$wRet = mysql_fetch_array($sRet);
							
							if ($rw['penunjang']==1){
								$qTin = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id_asal=b_ms_unit.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_ms_unit.kategori=1 AND b_bayar_tindakan.tipe=0 AND b_ms_tindakan.klasifikasi_id<>11 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id='".$rw['id']."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							}else{
								$qTin = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id WHERE b_pelayanan.kunjungan_id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_ms_tindakan.klasifikasi_id<>11 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id='".$rw['id']."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							}
							$sTin = mysql_query($qTin);
							$wTin = mysql_fetch_array($sTin);
							
							$qPk = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND b_pelayanan.unit_id='58' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sPk = mysql_query($qPk);
							$wPk = mysql_fetch_array($sPk);
							
							$qPa = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND b_pelayanan.unit_id='59' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sPa = mysql_query($qPa);
							$wPa = mysql_fetch_array($sPa);
							
							$qRad = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND b_pelayanan.unit_id='61' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							//echo $qRad."<br>";
							$sRad = mysql_query($qRad);
							$wRad = mysql_fetch_array($sRad);
							
							$qHd = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND b_pelayanan.unit_id='65' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sHd = mysql_query($qHd);
							$wHd = mysql_fetch_array($sHd);
							
							$qEnd = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND b_pelayanan.unit_id='67' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sEnd = mysql_query($qEnd);
							$wEnd = mysql_fetch_array($sEnd);
							
							$qOk = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.user_act='".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_pelayanan.unit_id_asal='".$rw['id']."' AND (b_pelayanan.unit_id='63' OR b_pelayanan.unit_id='47') AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sOk = mysql_query($qOk);
							$wOk = mysql_fetch_array($sOk);
							
							$qObat = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN $dbapotek.a_penjualan ap ON ap.NO_KUNJUNGAN = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = ap.ID INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_pelayanan.kunjungan_id = '".$rwPas['kunjungan_id']."' AND b_bayar_tindakan.tipe = 2 AND b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
							$sObat = mysql_query($qObat);
							$wObat = mysql_fetch_array($sObat);

				?>
				<tr>
					<td colspan="4" style="text-align:right; padding-right:5px; text-transform:uppercase; text-decoration:underline;"><?php echo $rw['nama']?></td>
					<td style="text-align:center;"><?php if($rw['inap']==0) echo $wTgl['masuk']; else echo $wTgl['mrs']?></td>
					<td style="text-align:center;"><?php if($rw['inap']==0) echo $wTgl['keluar']; else echo $wTgl['krs']?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wRet['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wTin['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wPk['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wPa['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wRad['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wHd['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wEnd['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wOk['nilai'],0,",",".")?></td>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($wObat['nilai'],0,",",".")?></td>
					<?php 
							$total = $wRet['nilai']+$wTin['nilai']+$wPk['nilai']+$wPa['nilai']+$wRad['nilai']+$wHd['nilai']+$wEnd['nilai']+$wOk['nilai']+$wObat['nilai'];
						
					?>
					<td style="text-align:right; padding-right:5px;"><?php echo number_format($total,0,",",".")?></td>
					<td style="text-align:center;"><?php echo $rw['status']?></td>
				</tr>
				<?php
						$ret = $ret + $wRet['nilai'];
						$tin = $tin + $wTin['nilai'];
						$pk = $pk + $wPk['nilai'];
						$pa = $pa + $wPa['nilai'];
						$rad = $rad + $wRad['nilai'];
						$hd = $hd + $wHd['nilai'];
						$end = $end + $wEnd['nilai'];
						$ok = $ok + $wOk['nilai'];
						$obat += $wObat['nilai'];
						$jml = $jml + $total;
						}
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($ret,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($tin,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($pk,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($pa,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($rad,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($hd,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($end,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($ok,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($obat,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; border-top:1px solid;"><?php echo number_format($jml,0,",",".")?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
						$no++;
						$tret = $tret + $ret;
						$ttin = $ttin + $tin;
						$tpk = $tpk + $pk;
						$tpa = $tpa + $pa;
						$trad = $trad + $rad;
						$thd = $thd + $hd;
						$tend = $tend + $end;
						$tok = $tok + $ok;
						$tobat += $obat;
						$tot = $tot + $jml;
						}
				?>
				<tr style="background-color:#FFFF99">
					<td height="25" colspan="6" style="text-align:center; font-weight:bold; border-top:1px solid; border-bottom:1px solid;">TOTAL</td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tret,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($ttin,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tpk,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tpa,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($trad,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($thd,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tend,0,",",".")?></td>
					<td height="25" style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tok,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;"><?php echo number_format($tobat,0,",",".")?></td>
					<td style="text-align:right; padding-right:5px; font-weight:bold; border-top:1px solid; border-bottom:1px solid;" height="25"><?php echo number_format($tot,0,",",".")?></td>
					<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				</tr>
				<?php
						}
				?>
			</table>
	  </td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak: <?=$date_now;?>&nbsp;Jam: <?=$jam;?></td>
	</tr>
	 <tr>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td  height="50">&nbsp;</td>
  </tr>
  <tr>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
	<tr id="trTombol">
        <td class="noline" align="center">
			<?php 
			if($_POST['excel']!='excel'){
			?>
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
              <option value="0">Printer non-Kretekan</option>
              <option value="1">Printer Kretekan</option>
            </select>
			<br />
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
			<?php } ?>
            </td>
    </tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsPeg);
	mysql_free_result($rsKsr);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
	function changeSize(par){
		if(par == 1){
			document.getElementById('tblPrint').width = 1200;
		}
		else{
			document.getElementById('tblPrint').width = 800;
		}
	}

    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>
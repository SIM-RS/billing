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
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>.: Laporan Penerimaan Kasir :.</title>
</head>

<body>
<?php
	//session_start();
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
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " WHERE p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " WHERE p.jenis_layanan=".$_REQUEST['JnsLayanan'];
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

if($_REQUEST['cmbKsr']!=0){
	$fKsr = " AND b.user_act=".$_REQUEST['cmbKsr'];
}

if($_REQUEST['StatusPas']!=0){
	$sqlKso = "SELECT id,nama from b_ms_kso where id = ".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
}
$kasir = $_REQUEST['cmbKasir2'];
$nmKasir = $_REQUEST['nmKsr'];

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);

$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";
?>
<table id="tblPrint" width="1000" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan Rawat Jalan<br />Secara Keseluruhan<br />Tanggal : <?php echo $periode; ?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%">&nbsp;Tempat Layanan : <span style="text-transform:uppercase; font-weight:bold; padding-left:10px;"><?php if($nmKasir==0) echo 'semua'; else echo $rwUnit2['nama'];?></span></td>
	<td align="right"><!--Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>--></td>	
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Status Pasien</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunjungan</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">No. RM</td>
				<td width="20%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Nama</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Pendaftaran</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Konsul</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Tindakan</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Resume Medik</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">KK4</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Iur Bayar</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Lab PA</td>
                
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Lab PK</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Radiologi</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Farmasi</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Total</td>
			</tr>
            <?php 
			$qunit="SELECT DISTINCT p.unit_id,mu.nama 
FROM (SELECT * FROM b_bayar WHERE tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id $fTmpLay ORDER BY mu.id";
			$rsUnit=mysql_query($qunit);
			while ($rwUnit=mysql_fetch_array($rsUnit)){
			?>
            <tr>
              <td colspan="15">&nbsp;<b><?php echo strtoupper($rwUnit['nama']); ?></b></td>
            </tr>
            <?php
				$total_p=0;
				$total_k=0;
				$total_t=0;
				$total_i=0;
				$total_pa=0;
				$total_pk=0;
				$total_r=0;
				$total_f=0;
				$total=0;
				/*$sql="SELECT DISTINCT kso.id,kso.nama 
FROM (SELECT * FROM b_bayar WHERE tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
INNER JOIN b_ms_kso kso ON t.kso_id=kso.id WHERE p.unit_id='".$rwUnit['unit_id']."' AND bt.nilai>0 AND bt.tipe=0 ORDER BY kso.id";*/
				$sql="SELECT DISTINCT kso.id,kso.nama 
FROM (SELECT * FROM b_bayar WHERE tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id = t.b_tindakan_id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
INNER JOIN b_ms_kso kso ON t.kso_id=kso.id WHERE p.unit_id='".$rwUnit['unit_id']."' AND bt.nilai>0 AND bt.tipe=0
AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl))
ORDER BY kso.id";
				$kueri=mysql_query($sql);
				while($data=mysql_fetch_array($kueri)){
			?>
            <tr>
            	<td colspan="15">&nbsp;<b><?php echo $data['nama']; ?></b></td>
            </tr>
            <?php
					$no=1;
					$tot_p=0;
					$tot_k=0;
					$tot_t=0;
					$tot_i=0;
					$tot_pa=0;
					$tot_pk=0;
					$tot_r=0;
					$tot_f=0;
					$tot=0;
					/*$sql2="SELECT p.tgl tanggal,mp.no_rm,mp.nama pasien,p.id pelayanan_id,p.kunjungan_id,
SUM(IF((mt.klasifikasi_id=11 AND mt.id<>2363),bt.nilai,0)) ret,SUM(IF((mt.id=2363),bt.nilai,0)) konsul,
SUM(IF((mt.id=10),bt.nilai,0)) resum,SUM(IF((mt.id=12),bt.nilai,0)) kk4,
SUM(IF((mt.klasifikasi_id<>11 AND mt.id<>10 AND mt.id<>12),bt.nilai,0)) tind
FROM (SELECT * FROM b_bayar WHERE tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE p.unit_id='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND bt.tipe=0
GROUP BY mp.id,p.id,t.kso_id ORDER BY p.id";*/
					$sql2="SELECT p.tgl tanggal,mp.no_rm,mp.nama pasien,p.id pelayanan_id,p.kunjungan_id,
SUM(IF((mt.klasifikasi_id=11 AND mt.id<>2363),bt.nilai,0)) ret,SUM(IF((mt.id=2363),bt.nilai,0)) konsul,
SUM(IF((mt.id=10),bt.nilai,0)) resum,SUM(IF((mt.id=12),bt.nilai,0)) kk4,
SUM(IF((mt.klasifikasi_id<>11 AND mt.id<>10 AND mt.id<>12),bt.nilai,0)) tind
FROM (SELECT * FROM b_bayar WHERE tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id=t.b_tindakan_id
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE p.unit_id='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND bt.tipe=0
AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl))
GROUP BY mp.id,p.id,t.kso_id ORDER BY p.id";
					$kueri2=mysql_query($sql2);
					while($data2=mysql_fetch_array($kueri2)){
						/*$qPa = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=59 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0";*/
						$qPa = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id = t.b_tindakan_id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=59 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0 AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl))";
						
						$sPa = mysql_query($qPa);
						$wPa = mysql_fetch_array($sPa);
						
						/*$qPk = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=58 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0";*/
						$qPk = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id = t.b_tindakan_id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=58 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0 AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl))";
						$sPk = mysql_query($qPk);
						$wPk = mysql_fetch_array($sPk);
						
						/*$qRad = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=61 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0";*/
						$qRad = "SELECT IFNULL(SUM(bt.nilai),0) nilai FROM (SELECT * FROM b_bayar WHERE tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id = t.b_tindakan_id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
WHERE p.unit_id=61 AND p.unit_id_asal='".$rwUnit["unit_id"]."' AND t.kso_id='".$data['id']."' AND p.kunjungan_id='".$data2['kunjungan_id']."' AND bt.tipe=0 AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl))";
						$sRad = mysql_query($qRad);
						$wRad = mysql_fetch_array($sRad);
						
						/*$qFar = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id  INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id  WHERE b_kunjungan.id='".$data2['kunjungan_id']."' AND b_pelayanan.unit_id='126' AND b_bayar.tgl $period";
						$sFar = mysql_query($qFar);
						$wFar = mysql_fetch_array($sFar);
						$tot_f=$tot_f+$wFar['nilai'];*/
						
						$p=$data2['ret'];
						$k=$data2['konsul'];
						$tind=$data2['tind'];
						$rm=$data2['resum'];
						$kk4=$data2['kk4'];
						$iur=0;
						$pa=$wPa['nilai'];
						$pk=$wPk['nilai'];
						$rad=$wRad['nilai'];
						$farm=0;
						
						$tot_p=$tot_p+$p;
						$tot_k=$tot_k+$k;
						$tot_t=$tot_t+$tind;
						$tot_rm=$tot_rm+$rm;
						$tot_kk4=$tot_kk4+$kk4;
						$tot_i=$tot_i+$iur;
						$tot_pa=$tot_pa+$pa;
						$tot_pk=$tot_pk+$pk;
						$tot_r=$tot_r+$rad;
						$tot_f=$tot_f+$farm;
						
						$t = $p+$k+$tind+$rm+$kk4+$iur+$pa+$pk+$rad+$farm;
						$tot=$tot_p+$tot_k+$tot_t+$tot_rm+$tot_kk4+$tot_i+$tot_pa+$tot_pk+$tot_r+$tot_f;
			?>
            <tr style="text-align:center;">
            	<td width="5%" style="" align="center"><?php echo $no; ?></td>
				<td width="10%" style=""><?php echo tglSQL($data2['tanggal']); ?></td>
				<td width="8%" style=""><?php echo $data2['no_rm']; ?></td>
				<td width="10%" style="" align="left">&nbsp;<?php echo $data2['pasien']; ?></td>
                <td width="10%" style="" align="right"><?php echo number_format($p,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($k,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($tind,'0',',','.');?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($rm,'0',',','.'); ?></td>
                <td width="10%" style="" align="right"><?php echo number_format($kk4,'0',',','.'); ?></td>
                <td width="10%" style="" align="right"><?php echo number_format($iur,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($pa,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($pk,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($rad,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($farm,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($t,'0',',','.'); ?>&nbsp;</td>
			</tr>
            <?php
						$no++;
					}
			//$total_t=$_total
			?>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="">&nbsp;</td>
				<td width="10%" style="">&nbsp;</td>
				<td width="8%" style="">&nbsp;</td>
				<td width="20%" style="" align="right">Sub Total :&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_p,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_k,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_t,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_rm,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_kk4,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_i,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_pa,'0',',','.'); ?>&nbsp;</td>
                
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_pk,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_r,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot_f,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tot,'0',',','.'); ?>&nbsp;</td>
			</tr>
            <?php
				$total_p=$total_p+$tot_p;
				$total_k=$total_k+$tot_k;
				$total_t=$total_t+$tot_t;
				$total_rm=$total_rm+$tot_rm;
				$total_kk4=$total_kk4+$tot_kk4;
				$total_i=$total_i+$tot_i;
				$total_pa=$total_pa+$tot_pa;
				$total_pk=$total_pk+$tot_pk;
				$total_r=$total_r+$tot_r;
				$total_f=$total_f+$tot_f;
				$total=$total+$tot;
				}
			}
			?>
            <tr>
            	<td colspan="15">&nbsp;</td>
            </tr>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="">&nbsp;</td>
				<td width="10%" style="">&nbsp;</td>
				<td width="8%" style="">&nbsp;</td>
				<td width="20%" style="" align="right">Total :&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_p,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_k,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_t,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_rm,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_kk4,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_i,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_pa,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_pk,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_r,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_f,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total,'0',',','.'); ?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="2" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="2" height="50">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
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
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

/*try{	
formatF4Portrait();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
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
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>
</html>

<?php 
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
<title>.: Laporan Pasien KRS :.</title>
</head>

<body>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$txtJam1=$_REQUEST['txtJam1'];
	$txtJam2=$_REQUEST['txtJam2'];
	
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
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
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
$nmKasir = $_REQUEST['cmbKsrAll'];

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);
?>
<table id="tblPrint" width="1000" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Pasien KRS<br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
	<td align="right">Yang Mencetak&nbsp;:&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="3%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="9%" style="border-top:1px solid; border-bottom:1px solid;">Tgl KRS</td>
                <td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunj</td>
				<td width="17%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Tempat Layanan</td>
				<td width="9%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="21%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="21%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Status</td>
				<td width="18%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Jumlah Yang Diterima</td>
			</tr>
            <?php
            if($nmKasir==0){
				$fKasir = "";
			}else{
				$fKasir = "AND k.user_act_pulang = '".$nmKasir."'";
			}
			
            $sPetugas="SELECT 
						pg.id,
						pg.nama
					  FROM
						(SELECT 
						  * 
						FROM
						  b_kunjungan 
						WHERE pulang = 1 AND DATE(tgl_pulang) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(tgl_pulang,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2') k 
						INNER JOIN b_ms_kso kso ON kso.id=k.kso_id
						INNER JOIN b_ms_pegawai pg ON pg.id = k.user_act_pulang 
					  WHERE 
						0=0
						$fKasir
						$fKso 
					  GROUP BY pg.id 
					  ORDER BY pg.nama";
			$qPetugas=mysql_query($sPetugas);
			while($rwPetugas=mysql_fetch_array($qPetugas)){
            ?>
            <tr>
            	<td colspan="8" style="font-weight:bold;"><?php echo $rwPetugas['nama']; ?></td>
            </tr>
			<?php
			$sql = "SELECT
					*
					FROM
					(SELECT
					k.id,
					p.jenis_kunjungan,
					DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y %H:%i') AS tgl_krs,
					k.tgl_pulang AS x_tgl_krs,
					ps.no_rm,
					ps.nama,
					kso.nama AS kso,
					pg.nama AS petugas
					FROM 
					(SELECT * FROM b_kunjungan WHERE pulang=1 AND DATE(tgl_pulang) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(tgl_pulang,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2') k
					INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id
					INNER JOIN b_ms_pasien ps ON ps.id=k.pasien_id
					INNER JOIN b_ms_kso kso ON kso.id=k.kso_id
					LEFT JOIN b_ms_pegawai pg ON pg.id=k.user_act_pulang
					LEFT JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = pg.id 
					WHERE
					k.user_act_pulang='".$rwPetugas['id']."'
					$fKso
					GROUP BY k.id) AS gab ORDER BY x_tgl_krs";
			//echo $sql."<br/>";
			$rs = mysql_query($sql);
			$no=0;
			while($rows = mysql_fetch_array($rs))
			{
				$no++;
				
				$sTgl="SELECT 
						DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') AS tgl
						FROM b_pelayanan p
						INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
						WHERE p.kunjungan_id='".$rows['id']."'
						ORDER BY p.id,tk.id LIMIT 1";
				$qTgl=mysql_query($sTgl);
				$rwTgl=mysql_fetch_array($qTgl);
						
				$sUnit="SELECT
						p.id AS pelayanan_id,
						u.id,
						u.nama
						FROM b_pelayanan p
						INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
						INNER JOIN b_ms_unit u ON u.id=p.unit_id
						WHERE p.kunjungan_id='".$rows['id']."' AND u.inap=1
						ORDER BY tk.tgl_in DESC LIMIT 1";
				$qUnit=mysql_query($sUnit);
				$rwUnit=mysql_fetch_array($qUnit);
				
				$sByr="SELECT b.nilai FROM b_bayar b WHERE b.kunjungan_id = '".$rows['id']."' AND jenis_kunjungan = 3 ORDER BY b.id DESC LIMIT 1";
				$qByr=mysql_query($sByr);
				$rwByr=mysql_fetch_array($qByr);
				
				$tgl=$rwTgl['tgl'];
				$unit=$rwUnit['nama'];
				$nilai=$rwByr['nilai'];
			?>
			<tr>
				<td style="text-align:center;"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rows['tgl_krs'];?></td>
                <td style="text-align:center"><?php echo $tgl;?></td>
				<td style="text-align:left"><?php echo $unit;?></td>
				<td style="text-align:center"><?php echo $rows['no_rm'];?></td>
				<td style="text-transform:uppercase;"><?php echo $rows['nama'];?></td>
				<td style="text-align:left"><?php echo $rows['kso'];?></td>
				<td style="text-align:right"><?php echo number_format($nilai,0,",",".");?></td>
			</tr>
            <?php
			}
			
			}
			?>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="2" style="border-top:1px solid;">&nbsp;</td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="2">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
			<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
            </td>
    </tr>
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
	}
}
</script>
</html>

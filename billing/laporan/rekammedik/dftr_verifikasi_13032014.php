<?php
session_start();
include("../../sesi.php");
if($_REQUEST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="dftr_verifikasi.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daftar Verifikasi Diagnosis PP</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_REQUEST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_REQUEST['cmbBln'];
		$thn = $_REQUEST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama,kode FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
	<tr>
		<td colspan="13"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td colspan="13" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Daftar Verifikasi Diagnosis Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br /><?php echo $Periode;?></b></td>
	</tr>
	<tr style="font-weight:bold">
		<td colspan="3" height="30">&nbsp;Jenis Layanan :&nbsp;<?php echo $rwUnit1['nama'];?></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td colspan="4" align="right">Yang Mencetak :&nbsp;<?php echo $rwPeg['nama'];?>&nbsp;</td>
	</tr>
	<tr height="30">
		<td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">TL</td>
		<td width="6%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Tgl Kunjungan</td>
		<td width="6%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">No. RM</td>
		<td width="15%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">Nama Pasien ICD X - Diagnosis</td>
		<td width="7%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Dokter</td>
		<td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Kasus</td>
		<td width="9%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="left">Diagnosa Akhir</td>
		<td width="13%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Tindakan</td>
        <td width="3%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">JK</td>
        <td width="8%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Umur</td>
		<td width="12%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">Alamat</td>
        <td width="7%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">Kecamatan</td>
		<td width="6%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">Tgl Selesai</td>
	</tr>
	<?php
			$fKso = '';
			if($_REQUEST['StatusPas']!=0) {
				$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
			}
			if($_REQUEST['TmpLayanan']==0) {
				$fTmp = " b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."' ";
			}
			else {
				$fTmp = " b_ms_unit.id = '".$_REQUEST['TmpLayanan']."' ";
			}
			
			$qU = "SELECT b_ms_unit.nama AS unit, b_kunjungan.unit_id, b_ms_unit.id
				FROM 
				b_kunjungan 
  				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
  				INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
				WHERE $fTmp $fKso $waktu
				GROUP BY b_ms_unit.id";
			//echo $qU."<br>";
			$rsU = mysql_query($qU);
			while($rwU = mysql_fetch_array($rsU))
			{
	?>
	<tr>	
		<td colspan="12" style="text-transform:uppercase">&nbsp;<b><?php echo $rwU['unit'];?></b></td>
	</tr>
	<?php
			//if($_REQUEST['TmpLayanan']==0)
			//{ 
				/*$qUnit = "SELECT b_ms_unit.nama AS unit, b_kunjungan.unit_id,
						DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') AS tgl, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.sex, b_ms_pasien.alamat, DATE_FORMAT(b_kunjungan.tgl_pulang,'%d-%m-%Y') AS tgl_pulang
						FROM b_ms_unit
						INNER JOIN b_kunjungan ON b_kunjungan.unit_id = b_ms_unit.id
						INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
						WHERE b_ms_unit.id = '".$rwU['id']."'
						$fKso $waktu
						GROUP BY b_kunjungan.id";*/
				$qUnit = "SELECT 
				b_pelayanan.id AS pelayanan_id, 
				DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS tgl,
				DATE_FORMAT(b_pelayanan.tgl_keluar,'%d-%m-%Y') AS tgl_selesai, 
				b_ms_pasien.no_rm, 
				b_ms_pasien.nama, 
				b_ms_pasien.sex, 
				b_ms_pasien.alamat, 
				DATE_FORMAT(b_kunjungan.tgl_pulang,'%d-%m-%Y') AS tgl_pulang,
				b_kunjungan.umur_thn, 
				b_kunjungan.umur_bln, 
				b_kunjungan.umur_hr,
				desa.nama as nama_desa,
				kec.nama as nama_kec,
				kab.nama as nama_kab 
FROM b_pelayanan 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
INNER JOIN b_ms_wilayah desa ON desa.id=b_ms_pasien.desa_id
INNER JOIN b_ms_wilayah kec ON kec.id=b_ms_pasien.kec_id
INNER JOIN b_ms_wilayah kab ON kab.id=b_ms_pasien.kab_id 
WHERE b_pelayanan.unit_id = '".$rwU['id']."' $fKso $waktu GROUP BY b_pelayanan.id";
				$rsUnit = mysql_query($qUnit);
			//}
			//else
			/*{
				$qUnit = "SELECT b_ms_unit.nama AS unit, b_kunjungan.unit_id,
						DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') AS tgl, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.sex, b_ms_pasien.alamat, DATE_FORMAT(b_kunjungan.tgl_pulang,'%d-%m-%Y') AS tgl_pulang
						FROM b_ms_unit
						INNER JOIN b_kunjungan ON b_kunjungan.unit_id = b_ms_unit.id
						INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
						WHERE b_ms_unit.id = '".$rwU['id']."'
						$fKso $waktu
						GROUP BY b_kunjungan.id";
				$rsUnit = mysql_query($qUnit);
			}*/
			$no = 1;
			while($rwUnit = mysql_fetch_array($rsUnit))
			{
	?>
	<tr valign="top" style="padding-left:5px;">
		<td style="text-align:right; padding-right:20px;"><?php echo $no; ?></td>
		<td style="text-transform:uppercase" align="center"><?php echo $rwUnit['tgl'];?></td>
		<td style="text-transform:uppercase" align="center"><?php echo $rwUnit['no_rm'];?></td>
		<td style="text-transform:uppercase"><?php echo $rwUnit['nama'];?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <?php
		$qDiag = "SELECT 
				b_ms_diagnosa.*,
				IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
				b_ms_pegawai.nama as dokter,
				if(b_diagnosa_rm.kasus_baru=1,'Baru',if(b_diagnosa_rm.kasus_baru=0,'Lama','-')) as kasus_baru
				FROM b_diagnosa_rm 
				INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
				INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
				inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
				left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
				WHERE b_diagnosa_rm.pelayanan_id = '".$rwUnit['pelayanan_id']."' ";
				$rsDiag = mysql_query($qDiag);
				$nDiag=mysql_num_rows($rsDiag);
		
		$qDiagAkhir = "SELECT GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama))) as diagnosa
				FROM b_diagnosa_rm 
				INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
				INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
				inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
				left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
				WHERE 
				b_diagnosa_rm.pelayanan_id = '".$rwUnit['pelayanan_id']."' 
				AND b_diagnosa_rm.akhir=1
				GROUP BY b_diagnosa_rm.pelayanan_id";
		$rsDiagAkhir = mysql_query($qDiagAkhir);
		$rwDiagAkhir = mysql_fetch_array($rsDiagAkhir);
		?>
        <td align="left" rowspan="<?php echo ($nDiag+1) ?>" style="text-transform:uppercase"><?php echo $rwDiagAkhir['diagnosa'];?></td>
        <?php
		$sTind="select CONCAT('-&nbsp;',GROUP_CONCAT(distinct mt.nama SEPARATOR '<br>-&nbsp;')) as tindakan
		from b_ms_tindakan mt
		inner join b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
		inner join b_tindakan t ON t.ms_tindakan_kelas_id=mtk.id
		where t.pelayanan_id='".$rwUnit['pelayanan_id']."' GROUP BY t.pelayanan_id";
		$qTind=mysql_query($sTind);
		$rwTind=mysql_fetch_array($qTind);
		?>
        <td align="left" rowspan="<?php echo ($nDiag+1) ?>" style="text-transform:uppercase"><?php echo $rwTind['tindakan']; ?></td>
		<td align="center" style="text-transform:uppercase"><?php echo $rwUnit['sex'];?></td>
		<td align="center" style="text-transform:uppercase"><?php echo $rwUnit['umur_thn']." Th ".$rwUnit['umur_bln']." Bln ".$rwUnit['umur_hr']." hr";?></td>
        <td style="text-transform:uppercase"><?php echo $rwUnit['alamat'];?></td>
        <td style="text-transform:uppercase"><?php echo $rwUnit['nama_kec'];?></td>
		<td align="center" style="text-transform:uppercase"><?php echo $rwUnit['tgl_selesai'];?></td>
	</tr>
	<?php
				
				while($rwDiag = mysql_fetch_array($rsDiag))
				{
				?>
	<tr valign="top" style="padding-left:5px;">
		<td style="text-align:right; padding-right:20px;">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="1" style="text-transform:uppercase"><?php echo $rwDiag['kode']?>&nbsp;&nbsp;&nbsp;<?php echo $rwDiag['diagnosa'];?></td>
		<td align="left" style="text-transform:uppercase"><?php echo $rwDiag['dokter']?></td>
        <td align="center" style="text-transform:uppercase"><?php echo $rwDiag['kasus_baru']; ?></td>
	</tr>
				<?php
				}
			$no++;
			}mysql_free_result($rsUnit);
		}mysql_free_result($rsU);
	?>
	<tr>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
        <td style="border-bottom:1px solid;">&nbsp;</td>
        <td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
	</tr>
	<tr>
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
        <td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="4" align="right"><?php echo 'Tgl Cetak:&nbsp;'.$date_now.'&nbsp;Jam&nbsp;'.$jam?></td>
	</tr>
	<tr>
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
		<td colspan="3" align="right">Yang Mencetak</td>
	</tr>
	<tr>
		<td colspan="13" height="50">&nbsp;</td>
	</tr>
	<tr>
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
		<td colspan="3" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>	
	</tr>
	<tr height="30"><td colspan="13">&nbsp;</td></tr>
	<tr id="trTombol">
        <td colspan="13" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Export Excel" onClick="toExcel();"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
    </tr>
	<tr height="30"><td colspan="13">&nbsp;</td></tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
	window.print();
	window.close();
	}
}
function toExcel()
{
	var cmbWaktu = "<? echo $_REQUEST['cmbWaktu']?>";
	var cmbBln = "<? echo $_REQUEST['cmbBln']?>";
	var cmbThn = "<? echo $_REQUEST['cmbThn']?>";
	var tglAwal = "<? echo $_REQUEST['tglAwal']?>";
	var tglAkhir = "<? echo $_REQUEST['tglAkhir']?>";
	var JnsLayanan = "<? echo $_REQUEST['JnsLayanan']?>";
	var TmpLayanan = "<? echo $_REQUEST['TmpLayanan']?>";
	var StatusPas = "<? echo $_REQUEST['StatusPas']?>";
	var user_act = "<? echo $_REQUEST['user_act']?>";
	var tglAwal2 = "<? echo $_REQUEST['tglAwal2']?>";
	
	location = 'dftr_verifikasi.php?isExcel=yes&cmbWaktu='+cmbWaktu+'&cmbBln='+cmbBln+'&cmbThn='+cmbThn+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&JnsLayanan='+JnsLayanan+'&TmpLayanan='+TmpLayanan+'&StatusPas='+StatusPas+'&user_act='+user_act+'&tglAwal2='+tglAwal2;
}
</script>
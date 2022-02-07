<?php
session_start();
include("../../sesi.php");
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="dftr_verifikasi.xls"');
}

include("../../koneksi/konek.php");

$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = "AND DATE(p.tgl) = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = "AND month(p.tgl) = '$bln' AND year(p.tgl) = '$thn' ";        
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = "AND DATE(p.tgl) between '$tglAwal2' and '$tglAkhir2' ";
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

//$waktu = $_REQUEST['waktu'];
//$Periode = $_REQUEST['periode'];

$JnsLayanan = $_REQUEST['cmbJenisLayanan'];
$TmpLayanan = $_REQUEST['cmbTempatLayanan'];

if($TmpLayanan==0){
	if($JnsLayanan==1){
		$fUnit = "AND p.jenis_kunjungan=3";
		$txtTmpt = "RAWAT INAP - SEMUA";
		$txtJudul = "Rawat Inap";
	}
	else{
		$fUnit = "AND p.jenis_kunjungan<>3";
		$txtTmpt = "RAWAT JALAN - SEMUA";
		$txtJudul = "Rawat Jalan";
	}
}
else{
	$sTmp = "SELECT nama FROM b_ms_unit WHERE id=".$TmpLayanan;
	$qTmp = mysql_query($sTmp);
	$rwTmp = mysql_fetch_array($qTmp);
	$txtTmp = $rwTmp['nama'];
	$fUnit = " AND p.unit_id = ".$TmpLayanan;
	
	if($JnsLayanan==1){
		$txtTmpt = "RAWAT INAP - ".$txtTmp;
	}
	else{
		$txtTmpt = "RAWAT JALAN - ".$txtTmp;
	}
}

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rincian Wabah</title>
</head>
<body>
<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
	<tr>
		<td colspan="12"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td colspan="12" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>RINCIAN WABAH<br /><?php echo $Periode;?><br /><?php echo $txtTmpt; ?></b></td>
	</tr>
	<tr style="font-weight:bold">
		<td colspan="3" height="30">&nbsp;</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td colspan="3" align="right">&nbsp;</td>
	</tr>
	<tr height="30">
		<td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;No</td>
		<td width="9%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;Tgl Kunjungan</td>
		<td width="5%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;No. RM</td>
		<td width="18%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama Pasien ICD X - Diagnosis</td>
		<td width="11%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;Dokter</td>
		<td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;Kasus</td>
		<!--<td width="17%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;Tindakan</td>-->
        <td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;JK</td>
        <td width="4%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;Umur</td>
		<td width="9%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;Alamat</td>
        <td width="8%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;Kecamatan</td>
		<td width="7%" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="right">Tgl Selesai&nbsp;</td>
	</tr>
	<?php
	if($_REQUEST['kec']=='0'){
		$fKota="WHERE kec.parent_id<>'51506'";	
	}
	else{
		$fKota="WHERE kec.id='".$_REQUEST['kec']."'";
	}
	
	/*if($_REQUEST['kolom']=='3') $fKode="AND mdg.DG_KODE = '005' AND k.umur_hr < 5";
	else if($_REQUEST['kolom']=='4') $fKode="AND mdg.DG_KODE = '005' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='5') $fKode="AND mdg.DG_KODE = '005' AND k.umur_hr > 5";
	else if($_REQUEST['kolom']=='6') $fKode="AND mdg.DG_KODE = '005' AND k.umur_hr > 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='7') $fKode="AND mdg.DG_KODE = '032.1'";
	else if($_REQUEST['kolom']=='8') $fKode="AND mdg.DG_KODE = '032.1' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='9') $fKode="AND mdg.DG_KODE = '028'";
	else if($_REQUEST['kolom']=='10') $fKode="AND mdg.DG_KODE = '028' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='11') $fKode="AND mdg.DG_KODE = '014'";
	else if($_REQUEST['kolom']=='12') $fKode="AND mdg.DG_KODE = '014' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='13') $fKode="AND mdg.DG_KODE = '035' AND k.umur_hr < 5";
	else if($_REQUEST['kolom']=='14') $fKode="AND mdg.DG_KODE = '035' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='15') $fKode="AND mdg.DG_KODE = '035' AND k.umur_hr > 5";
	else if($_REQUEST['kolom']=='16') $fKode="AND mdg.DG_KODE = '035' AND k.umur_hr > 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='17') $fKode="AND mdg.DG_KODE = 'I69' AND k.umur_hr < 5";
	else if($_REQUEST['kolom']=='18') $fKode="AND mdg.DG_KODE = 'I69' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='19') $fKode="AND mdg.DG_KODE = '012'";
	else if($_REQUEST['kolom']=='20') $fKode="AND mdg.DG_KODE = '012' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='21') $fKode="AND mdg.DG_KODE = 'I08'";
	else if($_REQUEST['kolom']=='22') $fKode="AND mdg.DG_KODE = 'I08' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='23') $fKode="AND mdg.DG_KODE = '007.0'";
	else if($_REQUEST['kolom']=='24') $fKode="AND mdg.DG_KODE = '007.0' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='25') $fKode="AND k.umur_hr >= 0 AND k.umur_hr <= 28 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='26') $fKode="AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='27') $fKode="AND mdg.DG_KODE IN ('I68','I68.0')";*/
	
	if($_REQUEST['kolom']=='3') $fKode="AND md.kode LIKE 'A09%' AND k.umur_thn < 5";
	else if($_REQUEST['kolom']=='4') $fKode="AND md.kode LIKE 'A09%' AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='5') $fKode="AND md.kode LIKE 'A09%' AND k.umur_thn > 5";
	else if($_REQUEST['kolom']=='6') $fKode="AND md.kode LIKE 'A09%' AND k.umur_thn > 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='7') $fKode="AND md.kode LIKE 'A91%'";
	else if($_REQUEST['kolom']=='8') $fKode="AND md.kode LIKE 'A91%' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='9') $fKode="AND md.kode LIKE 'A80.9%'";
	else if($_REQUEST['kolom']=='10') $fKode="AND md.kode LIKE 'A80.9%' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='11') $fKode="AND md.kode LIKE 'A36%'";
	else if($_REQUEST['kolom']=='12') $fKode="AND md.kode LIKE 'A36%' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='13') $fKode="AND md.kode LIKE 'B05%' AND k.umur_thn < 5";
	else if($_REQUEST['kolom']=='14') $fKode="AND md.kode LIKE 'B05%' AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='15') $fKode="AND md.kode LIKE 'B05%' AND k.umur_thn >= 5";
	else if($_REQUEST['kolom']=='16') $fKode="AND md.kode LIKE 'B05%' AND k.umur_thn >= 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='17') $fKode="AND md.kode LIKE 'J18%' AND k.umur_thn < 5";
	else if($_REQUEST['kolom']=='18') $fKode="AND md.kode LIKE 'J18%' AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='19') $fKode="AND md.kode LIKE 'A33%'";
	else if($_REQUEST['kolom']=='20') $fKode="AND md.kode LIKE 'A33%' AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='21') $fKode="AND ((md.kode BETWEEN 'E40' AND 'E46') OR md.kode LIKE 'E40%')";
	else if($_REQUEST['kolom']=='22') $fKode="AND ((md.kode BETWEEN 'E40' AND 'E46') OR md.kode LIKE 'E40%') AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='23') $fKode="AND ((md.kode = 'A15') OR (md.kode = 'A15.0'))";
	else if($_REQUEST['kolom']=='24') $fKode="AND ((md.kode = 'A15') OR (md.kode = 'A15.0')) AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='25') $fKode="AND k.umur_thn >= 0 AND k.umur_thn <= 28 AND pk.cara_keluar = 'Meninggal'";
	else if($_REQUEST['kolom']=='26') $fKode="AND pk.cara_keluar = 'Meninggal'";
	/*else if($_REQUEST['kolom']=='27') $fKode="AND mdg.DG_KODE IN ('I68','I68.0')";*/
		
	$sql = "SELECT
			p.id AS pelayanan_id, 
			DATE_FORMAT(p.tgl,'%d-%m-%Y') AS tgl, 
			ps.no_rm, 
			ps.nama, 
			ps.sex, 
			ps.alamat, 
			DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_pulang,
			k.umur_thn,
			kec.nama AS nama_kec
			FROM
			b_pelayanan p
			INNER JOIN b_ms_pasien ps ON ps.id=p.pasien_id
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			INNER JOIN b_diagnosa_rm d ON d.pelayanan_id=p.id
			INNER JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
			/*INNER JOIN b_ms_diagnosa_gol mdg ON mdg.DG_KODE=md.dg_kode*/ 
			INNER JOIN b_ms_wilayah kec ON kec.id=ps.kec_id
			LEFT JOIN b_pasien_keluar pk ON pk.pelayanan_id = p.id
			$fKota $waktu $fKode $fUnit AND d.kasus_baru = 1";
	//echo $sql."<br>";
	$no=1;
	$queri = mysql_query($sql);
	while($rows = mysql_fetch_array($queri))
	{
	?>
	<tr valign="top" style="padding-left:5px;">
		<td style="text-align:center;"><?php echo $no; ?></td>
		<td><?php echo $rows['tgl'];?></td>
		<td><?php echo $rows['no_rm'];?></td>
		<td style="text-transform:uppercase"><?php echo $rows['nama'];?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <!--<td align="center">&nbsp;</td>-->
		<td align="center"><?php echo $rows['sex'];?></td>
		<td align="center"><?php echo $rows['umur_thn']." Th";?></td>
        <td style="text-transform:uppercase"><?php echo $rows['alamat'];?></td>
        <td style="text-transform:uppercase"><?php echo $rows['nama_kec'];?></td>
		<td align="right"><?php echo $rows['tgl_pulang'];?></td>
	</tr>
	<?php
		$qDiag = "SELECT 
		b_ms_diagnosa.*,
		b_ms_pegawai.nama as dokter,
		if(b_diagnosa_rm.kasus_baru=1,'Baru','Lama') as kasus_baru
		FROM b_diagnosa_rm 
		INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
		INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
		WHERE b_diagnosa_rm.pelayanan_id = '".$rows['pelayanan_id']."' and b_diagnosa_rm.kasus_baru=1 ";
		//echo $qDiag."<br>";
		$rsDiag = mysql_query($qDiag);
		$nDiag=mysql_num_rows($rsDiag);
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
				?>
	<tr valign="top" style="padding-left:5px;">
		<td style="text-align:right; padding-right:20px;">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="1" style="text-transform:uppercase"><?php echo $rwDiag['kode']?>&nbsp;&nbsp;&nbsp;<?php echo $rwDiag['nama'];?></td>
		<td align="left"><?php echo $rwDiag['dokter']?></td>
        <td align="center"><?php echo $rwDiag['kasus_baru']; ?></td>
        <?php
		$sTind="select CONCAT('-&nbsp;',GROUP_CONCAT(distinct mt.nama SEPARATOR '<br>-&nbsp;')) as tindakan
		from b_ms_tindakan mt
		inner join b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
		inner join b_tindakan t ON t.ms_tindakan_kelas_id=mtk.id
		where t.pelayanan_id='".$rows['pelayanan_id']."' GROUP BY t.pelayanan_id";
		$qTind=mysql_query($sTind);
		$rwTind=mysql_fetch_array($qTind);
		?>
        <!--<td><?php echo $rwTind['tindakan']; ?></td>-->
	</tr>
		<?php
        }
		$no++;
	}
	?>
	<tr>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<!--<td style="border-bottom:1px solid;">&nbsp;</td>-->
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
		<!--<td>&nbsp;</td>-->
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
        <!--<td>&nbsp;</td>-->
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
      <td>&nbsp;</td>
		<td colspan="3" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<!--<td>&nbsp;</td>-->
		<td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
		<td colspan="2" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="11" height="50">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<!--<td>&nbsp;</td>-->
		<td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="right">&nbsp;</td>	
	</tr>
	<tr height="30"><td colspan="11">&nbsp;</td></tr>
	<tr id="trTombol">
        <td colspan="12" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
	<tr height="30"><td colspan="11">&nbsp;</td></tr>
</table>
</body>
<?php
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
</script>
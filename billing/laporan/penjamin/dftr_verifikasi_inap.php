<?php
session_start();
include("../../sesi.php");
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="dftr_verifikasi.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daftar Verifikasi</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and p.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(p.tgl) = '$bln' and year(p.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and p.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	if($_REQUEST['cmbJenisLayananM']=='1'){
		$txtJenis="RAWAT JALAN";	
	}
	else if($_REQUEST['cmbJenisLayananM']=='2'){
		$txtJenis="RAWAT DARURAT";
	}
	else{
		$txtJenis="RAWAT INAP";
	}
	
	if($_REQUEST['cmbTempatLayananM']=='0'){
		$txtTempat="SEMUA";
		$fUnit="AND p.jenis_kunjungan=".$_REQUEST['cmbJenisLayananM'];
	}
	else{
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayananM']."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);	
		$txtTempat = $rwUnit2['nama'];
		$fUnit="AND p.unit_id=".$_REQUEST['cmbTempatLayananM'];
	}
	
	
	$fKso = '';
	if($_REQUEST['StatusPas0']!=0) {
		$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas0']."'";
		$rsKso = mysql_query($sqlKso);
		$rwKso = mysql_fetch_array($rsKso);
	
		$fKso = "AND p.kso_id = ".$_REQUEST['StatusPas0'];
		$txtKso = $rwKso['nama'];
	}
	else{
		$fKso = "";
		$txtKso = "SEMUA";
	}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
	<tr>
		<td colspan="13"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td colspan="13" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>PELAKSANAAN PELAYANAN KESEHATAN MASYARAKAT KOTA MEDAN<br /><?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br /><?php echo $Periode;?></b></td>
	</tr>
	<tr style="font-weight:bold">
		<td colspan="5" height="30">&nbsp;JENIS LAYANAN :&nbsp;<?php echo $txtJenis;?></td>
		<td width="5%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td colspan="3" align="right">YANG MENCETAK :&nbsp;<?php echo $rwPeg['nama'];?>&nbsp;</td>
	</tr>
	<tr height="30">
		<td width="2%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;NO</td>
		<td width="6%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;NO RM</td>
		<td width="16%" align="left" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;NAMA PASIEN</td>
		<td width="3%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;UMUR</td>
		<td width="3%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;JK</td>
		<td align="center" colspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;TGL RAWAT</td>
		<td width="4%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;LOS</td>
		<td width="17%" align="left" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;DIAGNOSA</td>
        <td width="5%" align="right" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">BIAYA&nbsp;</td>
        <td width="17%" align="left" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;ALAMAT</td>
        <td width="8%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;KELURAHAN</td>
		<td width="9%" align="center" rowspan="2" style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;">&nbsp;KECAMATAN</td>
	</tr>
	<tr height="30">
	  <td style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;TGL MASUK</td>
	  <td style="font-weight:bold; border-bottom:1px solid; border-top:1px solid;" align="center">&nbsp;TGL KELUAR</td>
	</tr>
	<?php
			
	$sql="SELECT 
		k.id,
		ps.no_rm,
		ps.nama,
		ps.alamat,
		ps.sex,
		k.umur_thn,
		DATE_FORMAT(k.tgl,'%d-%m-%Y') tgl_masuk,
		DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') tgl_keluar,
		SUM(t.biaya_kso) AS biaya_kso,
		kel.nama kelurahan,
		kec.nama kecamatan
		FROM b_kunjungan k
		INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id
		INNER JOIN b_ms_pasien ps ON ps.id=k.pasien_id
		INNER JOIN b_ms_kso kso ON kso.id=p.kso_id
		INNER JOIN b_tindakan t ON t.pelayanan_id=p.id
		INNER JOIN b_ms_wilayah kel ON kel.id=k.desa_id
		INNER JOIN b_ms_wilayah kec ON kec.id=k.kec_id
		WHERE 0=0
		$waktu
		$fUnit
		$fKso
		GROUP BY k.id
		ORDER BY p.tgl";
	$queri=mysql_query($sql);
	$no=0;
	$total=0;
	while($rw = mysql_fetch_array($queri))
	{
		$no++;
		$total=$total+$rw['biaya_kso'];
	?>
	<tr valign="top" style="padding-left:5px;">
		<td style="text-align:center;"><?php echo $no; ?></td>
		<td align="center"><?php echo $rw['no_rm'];?></td>
		<td><?php echo strtoupper($rw['nama']);?></td>
		<td style="text-align:center;"><?php echo $rw['umur_thn']." THN";?></td>
		<td style="text-align:center;"><?php echo $rw['sex'];?></td>
      <?php
        $sqlIn="SELECT DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl),'%d-%m-%Y') tgl FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON 				p.id=tk.pelayanan_id
		WHERE p.kunjungan_id='".$rw['id']."' AND mu.inap=1 ORDER BY p.id LIMIT 1";
		$rsIn=mysql_query($sqlIn);
		$rwIn=mysql_fetch_array($rsIn);
		$tglIn=$rwIn['tgl'];
		
		$sqlOut="SELECT DATE_FORMAT(IFNULL(tk.tgl_out,NOW()),'%d-%m-%Y') tgl FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id LEFT JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
	WHERE p.kunjungan_id='".$rw['id']."' AND mu.inap=1 ORDER BY tk.id DESC LIMIT 1";
		$rsOut=mysql_query($sqlOut);
		$rwOut=mysql_fetch_array($rsOut);
		$tglOut=$rwOut['tgl'];
		
		$sLOS="SELECT DATEDIFF('".tglSQL($tglOut)."','".tglSQL($tglIn)."') AS los";
		$qLOS=mysql_query($sLOS);
		$rwLOS=mysql_fetch_array($qLOS);
		$LOS=$rwLOS['los'];
		?>
		<td style="text-align:center;"><?php echo $tglIn; ?></td>
        <td style="text-align:center;"><?php echo $tglOut; ?></td>
        <td align="center"><?php echo $LOS; ?></td>
        <?php
        $qDiag = "SELECT 
			b_ms_diagnosa.*,
			b_ms_pegawai.nama as dokter,
			if(b_diagnosa_rm.kasus_baru=1,'Baru','Lama') as kasus_baru
			FROM b_diagnosa_rm 
			INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
			INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id 
			WHERE b_diagnosa_rm.kunjungan_id = '".$rw['id']."' ";
		$rsDiag = mysql_query($qDiag);
		?>
        <td align="left">&nbsp;<?php
			while($rwDiag=mysql_fetch_array($rsDiag)){
				echo strtoupper($rwDiag['nama']).";&nbsp;";	
			}
		?>
        </td>
		<td align="right"><?php echo number_format($rw['biaya_kso'],0,',','.');?>&nbsp;&nbsp;</td>
		<td align="left">&nbsp;<?php echo strtoupper($rw['alamat']);?></td>
		<td align="center"><?php echo strtoupper($rw['kelurahan']);?></td>
        <td style="text-align:center;"><?php echo strtoupper($rw['kecamatan']);?></td>
	</tr>
	<?php	
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
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
		<td style="border-bottom:1px solid;">&nbsp;</td>
        <td style="border-bottom:1px solid;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="9" align="center" style="font-weight:bold">TOTAL&nbsp;</td>
		<td align="right" style="font-weight:bold"><?php echo number_format($total,0,',','.'); ?>&nbsp;</td>
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
		<td>&nbsp;</td>
		<td colspan="3" align="right"><?php echo 'Tgl Cetak:&nbsp;'.$date_now.'&nbsp;Jam&nbsp;'.$jam?></td>
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
		<td align="right">Yang Mencetak</td>
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
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>	
	</tr>
	<tr height="30"><td colspan="13">&nbsp;</td></tr>
	<tr id="trTombol">
        <td colspan="13" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
	<tr height="30"><td colspan="13">&nbsp;</td></tr>
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
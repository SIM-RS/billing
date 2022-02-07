<?php 
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
//session_start();
//==========Menangkap filter data====
$jam = date("G:i");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$stsPas=$_REQUEST['StatusPas'];
$tmpLayanan=$_REQUEST['TmpLayananInapSaja'];
$user_act=$_REQUEST['user_act'];
$rsUser=mysql_query("SELECT nip,nama FROM b_ms_pegawai WHERE id=$user_act");
$rwUser=mysql_fetch_array($rsUser);
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
	$rsPenjamin = mysql_query($sqlPenjamin);
	$hsPenjamin = mysql_fetch_array($rsPenjamin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Pengajuan Klaim Pasien :.</title>
</head>

<body>
<table align="left" width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-weight:bold; font-size:14px; text-transform:uppercase"">LAPORAN PENGAJUAN KLAIM PASIEN INAP ( 
      <?php if($tmpLayanan=='0') echo 'SEMUA'; else echo $rwUnit2['nama']?> )<br/>
      <?php echo $Periode;?>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" style="font-weight:bold">Penjamin Pasien&nbsp;:&nbsp;<?php echo $hsPenjamin['nama'];?></td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="30" width="3%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">No</td>
			<td width="8%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Tgl. Kunjungan</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">No.&nbsp;RM</td>
			<td width="17%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Nama&nbsp;Pasien</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Retribusi</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Tindakan</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">PA</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">PK</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">RAD</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">HD</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">OK Central</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Endoscopy</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Konsul Poli</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Obat</td>
			<td width="6%" align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Total</td>
		</tr>
		<?php
			if($tmpLayanan != 0){
				$fUnit = "AND b_ms_unit.id = '".$_REQUEST['TmpLayananInapSaja']."'";
			}else{
				$fUnit = "AND b_ms_unit.parent_id = '".$_REQUEST['JnsLayananDenganInap']."'";
			}
			
			$qUn = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
				INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.unit_id
				WHERE b_kunjungan.kso_id = '".$stsPas."' $fUnit $waktu 
				AND b_ms_unit.parent_id <> '76' GROUP BY b_ms_unit.id ";
			//echo $qUn."<br>";
			$rsUn = mysql_query($qUn);
			while($rwUn = mysql_fetch_array($rsUn))
			{
		?>
		<tr>
			<td colspan="15">&nbsp;<b><?php echo $rwUn['nama'];?></b></td>
		</tr>
		<?php 
		/*$Pas = "SELECT b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id, 
			DATE_FORMAT(b_kunjungan.tgl,'%d/%m/%Y') AS tgl, b_pelayanan.id AS pelayanan_id,
			b_pelayanan.unit_id_asal 
			FROM b_ms_pasien
			INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id
			INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id
			INNER JOIN b_bayar ON b_bayar_tindakan.bayar_id = b_bayar.id
			WHERE b_tindakan.kso_id = '".$stsPas."' 
			AND b_kunjungan.unit_id = '".$rwUn['id']."' $waktu
			GROUP BY b_ms_pasien.nama
			ORDER BY b_kunjungan.tgl";*/
		$Pas ="SELECT b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id, 
	DATE_FORMAT(b_pelayanan.tgl,'%d/%m/%Y') AS tgl, b_pelayanan.id AS pelayanan_id, 
	b_pelayanan.unit_id_asal FROM b_ms_pasien 
	INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id 
	INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
	INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
	INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
	WHERE b_tindakan.kso_id = '".$stsPas."' AND b_kunjungan.unit_id = '".$rwUn['id']."' 
	$waktu AND b_ms_unit.parent_id = '76'
	GROUP BY b_ms_pasien.nama,b_kunjungan.id
	ORDER BY b_pelayanan.tgl,b_ms_pasien.nama";
		//echo $Pas."<br>";
		$qPas=mysql_query($Pas);
		$no=0;
		$subtotal=0;
		$subtotTin=0;
		$subtotLab=0;
		$subtotRad=0;
		$subtotOk=0;
		$subtotEnd=0;
		while($rwPas=mysql_fetch_array($qPas)){
		$i++;
		$no++;
		$tgl = $rwPas['tgl'];
		
		$sqlRet ="SELECT SUM(b_tindakan.biaya_kso) AS retribusi 
		FROM b_pelayanan
		INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_tindakan_kelas 
	ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id  
	WHERE b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'
	AND b_ms_tindakan.klasifikasi_id = '11' AND b_pelayanan.unit_id = '".$rwUn['id']."'";
		//echo $sqlRet."<br>";
		$rsRet = mysql_query($sqlRet);
		$rowRet = mysql_fetch_array($rsRet);
		
		$sqlTin = "SELECT SUM(b_tindakan.biaya_kso) AS tindakan 
			FROM b_tindakan
			INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
			WHERE b_ms_tindakan.klasifikasi_id <> '11'
			AND b_tindakan.pelayanan_id = '".$rwPas['pelayanan_id']."'";
		//echo $sqlTin."<br>";
		$rsTin = mysql_query($sqlTin);
		$rowTin = mysql_fetch_array($rsTin);
		
		$sqlLabA = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS PA
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '59'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		//echo $sqlLabA."<br>";
		$rsLabA = mysql_query($sqlLabA);
		$rowLabA = mysql_fetch_array($rsLabA);
		
		$sqlLabK = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS PA
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.unit_id = '58'
			AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		//echo $sqlLabA."<br>";
		/*$sqlLabK = "SELECT IFNULL(SUM(b_bayar_tindakan.nilai),0) AS PK FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id
			INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id
			WHERE b_pelayanan.unit_id = '59' AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";*/
		$rsLabK = mysql_query($sqlLabK);
		$rowLabK = mysql_fetch_array($rsLabK);
			
		$sqlRad = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS rad FROM b_tindakan INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
	WHERE b_pelayanan.unit_id = '61' AND b_pelayanan.unit_id_asal = '".$rwUn['id']."' AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		/*$sqlRad = "SELECT IFNULL(SUM(b_bayar_tindakan.nilai),0) AS rad				 
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id
			INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id
			WHERE b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_pelayanan.jenis_layanan = '60' 
			AND b_pelayanan.kunjungan_id = '".$rwPas['kunjungan_id']."'";*/
		$rsRad = mysql_query($sqlRad);
		$rowRad = mysql_fetch_array($rsRad);
			
		$sqlHD = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS hd
		FROM b_tindakan
		INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
		WHERE b_pelayanan.unit_id = '65'
		AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
		AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		/*$sqlRad = "SELECT IFNULL(SUM(b_bayar_tindakan.nilai),0) AS rad				 
			FROM b_tindakan
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id
			INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id
			WHERE b_pelayanan.unit_id_asal = '".$rwUn['id']."'
			AND b_pelayanan.jenis_layanan = '60' 
			AND b_pelayanan.kunjungan_id = '".$rwPas['kunjungan_id']."'";*/
		$rsHD = mysql_query($sqlHD);
		$rowHD = mysql_fetch_array($rsHD);
		
		$sqlOk = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS ok
		FROM b_tindakan
		INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
		WHERE b_pelayanan.unit_id = '63'
		AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
		AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		$rsOk = mysql_query($sqlOk);
		$rowOk = mysql_fetch_array($rsOk);
		
		$sqlEnd = "SELECT IFNULL(SUM(b_tindakan.biaya_kso),0) AS end
		FROM b_tindakan
		INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id 
		WHERE b_pelayanan.unit_id = '67'
		AND b_pelayanan.unit_id_asal = '".$rwUn['id']."'
		AND b_tindakan.kunjungan_id = '".$rwPas['kunjungan_id']."'";
		$rsEnd = mysql_query($sqlEnd);
		$rowEnd = mysql_fetch_array($rsEnd);
		
		$sqlKon = "SELECT SUM(b_tindakan.biaya_kso) AS jml FROM b_kunjungan 
	INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
	INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
	INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
	WHERE b_kunjungan.id = '".$rwPas['kunjungan_id']."'";
		/* SELECT SUM(b_tindakan.biaya_kso) AS konsul FROM b_tindakan INNER JOIN b_ms_tindakan_unit ON b_ms_tindakan_unit.id = b_tindakan.ms_tindakan_unit_id
	INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_unit.ms_tindakan_kelas_id = b_ms_tindakan_kelas.id 
	INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
	INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan.ms_tindakan_unit_id
	WHERE b_tindakan.pelayanan_id = '".$rwPas['pelayanan_id']."' AND b_ms_unit.inap <> 1"; */
		$rsKon = mysql_query($sqlKon);
		$rowKon = mysql_fetch_array($rsKon);
		
		
		?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td align="center"><?php echo $rwPas['tgl']?></td>
			<td align="center"><?php echo $rwPas['no_rm']?></td>
			<td style="text-transform:uppercase"><?php echo $rwPas['nama']?></td>
			<td align="right"><?php echo number_format($rowRet['retribusi'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowTin['tindakan'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowLabA['PA'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowLabK['PK'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowRad['rad'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowHD['hd'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowOk['ok'],0,",",".")?>&nbsp;</td>
			<td align="right"><?php echo number_format($rowEnd['end'],0,",",".")?>&nbsp;</td>
			<?php
					$konsul = $rowKon['jml']-$rowRet['retribusi']-$rowTin['tindakan']-$rowLabA['PA']-$rowLabK['PK']-$rowRad['rad']-$rowHD['hd']-$rowOk['ok']-$rowEnd['end'];
					$biayaTotal = $rowRet['retribusi']+$rowTin['tindakan']+$rowLabA['PA']+$rowLabK['PK']+$rowRad['rad']+$rowHD['hd']+$rowOk['ok']+$rowEnd['end']+$konsul;
			?>
			<td align="right"><?php echo number_format($konsul,0,",",".")?>&nbsp;</td>
			<td align="right">0&nbsp;</td>
			<td align="right"><?php echo number_format($biayaTotal,0,",",".")?>&nbsp;</td>
		</tr>
		<?php 
			$sRet+=$rowRet['retribusi'];
			$sTind+=$rowTin['tindakan'];
			$sPA+=$rowLabA['PA'];
			$sPK+=$rowLabK['PK'];
			$sRAD+=$rowRad['rad'];
			$sHD+=$rowHD['hd'];
			$sOk+=$rowOk['ok'];
			$sEnd+=$rowEnd['end'];
			$sKonsul+=$konsul;
			$sTot+=$biayaTotal;
			}
			//mysql_free_result($qNilai);
			//mysql_free_result($qPas);
		}
		mysql_free_result($rsUn);
		?>
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr height="30">
			<td>&nbsp;</td>
			<td colspan="3" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold">Jumlah Pasien&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $i?></td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sRet,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sTind,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sPA,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sPK,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sRAD,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sHD,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sOk,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sEnd,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sKonsul,0,",",".")?>&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold">&nbsp;</td>
			<td align="right" style="border-bottom:#000000 1px solid; border-top:#000000 1px solid; font-weight:bold"><?php echo number_format($sTot,0,",",".")?>&nbsp;</td>
		</tr>
	</table>
	</td>
  </tr>
  <tr>
  	<td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="font-size:12px">Tgl Cetak: <?php echo $date_now;?>&nbsp;Jam: <?php echo $jam;?></td>
  </tr>
  <tr>
    <td align="right" style="font-size:12px">Yang Mencetak,&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><b><?php echo $rwUser['nama']?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
</body>
<?php
	//mysql_free_result($qPenjamin);
	//mysql_free_result($qUser);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
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

<?php 
session_start();
include("../../sesi.php");
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Rincian Japel.xls"');
}
?>
<title>.: Laporan Rincian Penghitungan Jasa Pelaksana :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " b_tindakan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " month(b_tindakan.tgl) = '$bln' and year(b_tindakan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " b_tindakan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayananBaru']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);

	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayananBaru']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$sqlDok = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$_REQUEST['cmbDokSemua']."'";
	$rsDok = mysql_query($sqlDok);
	$rwDok = mysql_fetch_array($rsDok);
	
	$jnsLayanan = $_REQUEST['JnsLayananBaru'];
	$tmpLayanan = $_REQUEST['TmpLayananBaru'];
	$stsPas = $_REQUEST['StatusPas'];

?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?php echo $namaRS;?><br /><?php echo $alamatRS; ?><br />Telepon <?php echo $tlpRS; ?><br /><?php echo $kotaRS; ?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-transform:uppercase; text-align:center">rincian penghitungan jasa pelaksana tempat layanan<br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="font-weight:bold;">
				<td width="50%">&nbsp;Pelaksana:&nbsp;<?php echo $rwDok['nama']; ?></td>
				<td width="50%" align="right">Jenis Layanan:&nbsp;<?php if($jnsLayanan==0) echo "SEMUA"; else echo $rwUnit1['nama'] ?>&nbsp;</td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-weight:bold;">
				  <td height="30" width="15%" style="border-top:1px solid; border-bottom:1px solid; text-align:center">Tanggal</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No. RM</td>
					<td width="25%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
					<td width="35%" style="border-top:1px solid; border-bottom:1px solid; text-align:left" colspan="3">Nama Tindakan</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px;">Tarif</td>
				    <td width="10%" style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px;">Jasa Pelayanan</td>
				</tr>
				<?php
						if($jnsLayanan==0 && $tmpLayanan==0){
							$fJns = "";
						}else if($jnsLayanan==0 && $tmpLayanan!=0){
							$fJns = "WHERE b_pelayanan.unit_id = '".$tmpLayanan."'";
						}else if($jnsLayanan!=0 && $tmpLayanan==0){
							$fJns = "WHERE b_pelayanan.jenis_layanan = '".$jnsLayanan."'";
						}else{
							$fJns = "WHERE b_pelayanan.unit_id = '".$tmpLayanan."'";
						}
						if($stsPas!=0) $fKso = " AND b_tindakan.kso_id = '".$stsPas."'";
						
						/*$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM (SELECT b_tindakan.pelayanan_id FROM b_tindakan WHERE $waktu AND b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' $fKso) AS g
INNER JOIN b_pelayanan ON b_pelayanan.id=g.pelayanan_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id $fJns
GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama";*/
						/*$qTmp = "SELECT DISTINCT b_ms_unit.id, b_ms_unit.nama FROM (SELECT b_tindakan.pelayanan_id FROM b_tindakan WHERE $waktu AND b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' $fKso) AS g
INNER JOIN b_pelayanan ON b_pelayanan.id=g.pelayanan_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id $fJns
ORDER BY b_ms_unit.nama";*/
						$qTmp = "SELECT DISTINCT b_ms_unit.id, b_ms_unit.nama FROM (SELECT b_tindakan.pelayanan_id FROM b_tindakan LEFT JOIN b_tindakan_dokter_anastesi tda ON b_tindakan.id=tda.tindakan_id WHERE $waktu AND (b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' OR tda.dokter_id='".$_REQUEST['cmbDokSemua']."') $fKso) AS g
INNER JOIN b_pelayanan ON b_pelayanan.id=g.pelayanan_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id $fJns
ORDER BY b_ms_unit.nama";
						//echo $qTmp."<br>";
						$rsTmp = mysql_query($qTmp);
						$total = 0;
						$total_japel = 0;
						/*$totalRet = 0;
						$totalVis = 0;
						$totalTin = 0;*/
						while($rwTmp = mysql_fetch_array($rsTmp))
						{
				?>
				<tr>
					<td colspan="8" height="30" valign="bottom" style="font-weight:bold; text-transform:uppercase; text-decoration:underline; padding-left:10px;"><?php echo $rwTmp['nama'];?></td>
				</tr>
				<?php
						/*$qSts = "SELECT b_ms_kso.id, b_ms_kso.nama FROM (SELECT b_tindakan.pelayanan_id, b_tindakan.kso_id 
FROM b_tindakan WHERE b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' AND $waktu $fKso) AS g
INNER JOIN b_pelayanan ON b_pelayanan.id=g.pelayanan_id INNER JOIN b_ms_kso ON b_ms_kso.id=g.kso_id WHERE b_pelayanan.unit_id = '".$rwTmp['id']."' GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";*/
						$qSts = "SELECT DISTINCT b_ms_kso.id, b_ms_kso.nama FROM (SELECT b_tindakan.pelayanan_id, b_tindakan.kso_id 
FROM b_tindakan LEFT JOIN b_tindakan_dokter_anastesi tda ON b_tindakan.id=tda.tindakan_id WHERE (b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' OR tda.dokter_id='".$_REQUEST['cmbDokSemua']."') AND $waktu $fKso) AS g
INNER JOIN b_pelayanan ON b_pelayanan.id=g.pelayanan_id INNER JOIN b_ms_kso ON b_ms_kso.id=g.kso_id WHERE b_pelayanan.unit_id = '".$rwTmp['id']."' ORDER BY b_ms_kso.nama";
						//echo $qSts."<br>";
						$rsSts = mysql_query($qSts);
						while($rwSts = mysql_fetch_array($rsSts))
						{
				?>
				<tr>
				  <td colspan="3" style="padding-left:30px; font-weight:bold; text-transform:uppercase; text-decoration:underline"><?php echo $rwSts['nama']?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
			      <td>&nbsp;</td>
			  </tr>
				<?php
						/*$qTgl = "SELECT DISTINCT DATE_FORMAT(b_tindakan.tgl,'%d-%m-%Y') AS tgl
FROM b_tindakan INNER JOIN b_pelayanan ON b_pelayanan.id=b_tindakan.pelayanan_id 
WHERE $waktu AND b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' 
AND b_tindakan.kso_id='".$rwSts['id']."' AND b_pelayanan.unit_id='".$rwTmp['id']."' ORDER BY b_tindakan.tgl";*/
						$qTgl = "SELECT DISTINCT DATE_FORMAT(b_tindakan.tgl,'%d-%m-%Y') AS tgl
FROM (SELECT b_tindakan.pelayanan_id,b_tindakan.tgl FROM b_tindakan 
LEFT JOIN b_tindakan_dokter_anastesi tda ON b_tindakan.id=tda.tindakan_id 
WHERE (b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' OR tda.dokter_id='".$_REQUEST['cmbDokSemua']."') AND $waktu AND b_tindakan.kso_id='".$rwSts['id']."') b_tindakan 
INNER JOIN b_pelayanan ON b_pelayanan.id=b_tindakan.pelayanan_id 
WHERE b_pelayanan.unit_id='".$rwTmp['id']."' ORDER BY b_tindakan.tgl";
						//echo $qTgl."<br>";
						$rsTgl = mysql_query($qTgl);
						while($rwTgl = mysql_fetch_array($rsTgl))
						{
							
				?>
				<tr>
				  <td colspan="2" style="padding-left:50px; font-weight:bold;"><?php echo $rwTgl['tgl']?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				    <td>&nbsp;</td>
				</tr>
				<?php
					$tgl = tglSQL($rwTgl['tgl']);
					/*$sql = "SELECT DISTINCT b_ms_pasien.id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id
FROM (SELECT DISTINCT pelayanan_id FROM b_tindakan 
WHERE b_tindakan.user_id = '".$_REQUEST['cmbDokSemua']."' AND b_tindakan.kso_id = '".$rwSts['id']."' AND b_tindakan.tgl = '".$tgl."') b_tindakan 
INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_kunjungan ON b_pelayanan.kunjungan_id = b_kunjungan.id
INNER JOIN b_ms_pasien ON b_kunjungan.pasien_id = b_ms_pasien.id
WHERE b_pelayanan.unit_id= '".$rwTmp['id']."'";*/
					$sql = "SELECT DISTINCT b_ms_pasien.id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_kunjungan.id AS kunjungan_id
FROM (SELECT DISTINCT pelayanan_id FROM b_tindakan LEFT JOIN b_tindakan_dokter_anastesi tda ON b_tindakan.id=tda.tindakan_id 
WHERE (b_tindakan.user_id = '".$_REQUEST['cmbDokSemua']."' OR tda.dokter_id='".$_REQUEST['cmbDokSemua']."') AND b_tindakan.kso_id = '".$rwSts['id']."' AND b_tindakan.tgl = '".$tgl."') b_tindakan 
INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_kunjungan ON b_pelayanan.kunjungan_id = b_kunjungan.id
INNER JOIN b_ms_pasien ON b_kunjungan.pasien_id = b_ms_pasien.id
WHERE b_pelayanan.unit_id= '".$rwTmp['id']."'";
					//echo $sql."<br>";
					$rs = mysql_query($sql);
					$no = 1;
					$sub = 0;
					$subjapel = 0;
					/*$subRet = 0;
					$subVis = 0;
					$subTin = 0;*/
					while($rw = mysql_fetch_array($rs))
					{
				?>
				<tr style="vertical-align:top">
				  <td style="padding-right:20px; text-align:right"><?php echo $no;?></td>
					<td>&nbsp;<?php echo $rw['no_rm']?></td>
					<td style="text-transform:uppercase"><?php echo $rw['nama']?></td>
					<td style="padding-right:10px; text-align:left; vertical-align:top;" colspan="3">
					<?php 
					/*$sqlJml1 = "SELECT b_ms_tindakan.nama,(b_tindakan.qty*b_tindakan.biaya) AS nilai,b_tindakan.ms_tindakan_kelas_id
FROM b_tindakan 
INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id
INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id=b_ms_tindakan.id
WHERE b_tindakan.kunjungan_id='".$rw['kunjungan_id']."' AND b_tindakan.tgl='".$tgl."'
AND b_tindakan.user_id='".$_REQUEST['cmbDokSemua']."' AND b_pelayanan.unit_id='".$rwTmp['id']."' AND b_tindakan.kso_id='".$rwSts['id']."'";*/
					$sqlJml1 = "SELECT b_ms_tindakan.nama,(b_tindakan.qty*b_tindakan.biaya) AS nilai,b_tindakan.ms_tindakan_kelas_id,IFNULL(b_tindakan.tda_id,0) tda_id
FROM (SELECT DISTINCT b_tindakan.*,tda.id tda_id FROM b_tindakan LEFT JOIN b_tindakan_dokter_anastesi tda ON b_tindakan.id=tda.tindakan_id 
WHERE (b_tindakan.user_id = '".$_REQUEST['cmbDokSemua']."' OR tda.dokter_id='".$_REQUEST['cmbDokSemua']."') AND b_tindakan.kso_id = '".$rwSts['id']."' AND b_tindakan.tgl = '".$tgl."') b_tindakan 
INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id
INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id=b_ms_tindakan.id
WHERE b_tindakan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.unit_id='".$rwTmp['id']."'";
					//echo $sqlJml1."<br>";
					$rsJml1 = mysql_query($sqlJml1);
					$i=1;
					$rmn_kat=1;
					$strnilai="";
					$strjapel="";
					while($rwJml1 = mysql_fetch_array($rsJml1)){
						echo $i.". ".$rwJml1['nama']."<br>";
						$strnilai.=number_format($rwJml1['nilai'],0,',','.')."<br>";
						$sub = $sub + $rwJml1['nilai'];
						$i++;
						
						if ($rwJml1['tda_id']>0) $rmn_kat=2;
						$sql="SELECT rm.rmn_kode,rmn_tipe,(SELECT rm1.rmn_value FROM dbpayroll.remunerasi_master rm1 
WHERE rm1.rmn_tipe=rm.rmn_tipe AND rm1.rmn_kategori=".$rmn_kat." AND rm1.rmn_kode LIKE CONCAT(rm.rmn_kode,'%')) rmn_value 
FROM b_ms_tindakan_kel_japel mtkj INNER JOIN dbpayroll.remunerasi_master rm ON mtkj.ms_japel_id=rm.rmn_id
WHERE mtkj.ms_tindakan_kelas_id='".$rwJml1['ms_tindakan_kelas_id']."'";
						$rsjapel=mysql_query($sql);
						$rwjapel=mysql_fetch_array($rsjapel);
						$japel=$rwJml1['nilai']*$rwjapel['rmn_value'];
						$strjapel.=number_format($japel,0,',','.')."<br>";
						$subjapel = $subjapel + $japel;
					}
					?>                    </td>
					<td style="padding-right:10px; text-align:right">
                    <?php 
						echo $strnilai;
					?>                    </td>
				    <td style="padding-right:10px; text-align:right"><?php echo $strjapel; ?></td>
				</tr>
				<?php
					$no++;
					} mysql_free_result($rs);
					
				?>
				<tr style="font-weight:bold">
				  <td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-align:right;">&nbsp;</td>
					<td style="text-align:right; padding-right:10px; border-top:1px solid;">&nbsp;</td>
					<td style="text-align:right; padding-right:10px; border-top:1px solid;">&nbsp;</td>
					<td style="text-align:right; border-top:1px solid;">Subtotal</td>
					<td style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub,0,",",".")?></td>
				    <td style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($subjapel,0,",",".")?></td>
				</tr>
				<?php
						$total = $total + $sub;
						$total_japel = $total_japel + $subjapel;
					} mysql_free_result($rsTgl);
					} mysql_free_result($rsSts);
					} mysql_free_result($rsTmp);
				?>
				<tr height="30">
				  	<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; font-weight:bold;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px; font-weight:bold;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:10px; font-weight:bold;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; font-weight:bold;">Total</td>
					<td style="text-align:right; font-weight:bold; padding-right:10px; border-top:1px solid;; border-bottom:1px solid;"><?php echo number_format($total,0,",",".")?></td>
				    <td style="text-align:right; font-weight:bold; padding-right:10px; border-top:1px solid;; border-bottom:1px solid;"><?php echo number_format($total_japel,0,",",".")?></td>
				</tr>
			</table>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right" height="70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;<br>Yang Mencetak,&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsDok);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
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
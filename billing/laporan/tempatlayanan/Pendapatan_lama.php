<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}
?>
<title>Laporan Pendapatan</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	$waktuAsli = $waktu;
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and t.tgl = '$tglAwal2' ";
		$waktu2 = " and date(t.tgl_in) <= '$tglAwal2' AND (date(t.tgl_out) >= '$tglAwal2' OR t.tgl_out IS NULL) ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu3=$thn."-".$bln."-01";
		if ($bln<10){
			$waktu3=$thn."-0".$bln."-01";
		}
		$waktu = " and month(t.tgl) = '$bln' and year(t.tgl) = '$thn' ";
		//$waktu2 = " and month(pl.tgl_krs) = '$bln' and year(pl.tgl_krs) = '$thn' ";
		$waktu2 = " AND DATE(t.tgl_in) <= LAST_DAY('$waktu3') AND (DATE(t.tgl_out) >= '$waktu3' OR t.tgl_out IS NULL) ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and t.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = " AND date(t.tgl_in) <= '$tglAkhir2' AND (date(t.tgl_out) >= '$tglAwal2' OR t.tgl_out IS NULL) ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
if($_REQUEST['TmpLayanan']!='0'){	
	$sqlUnit2 = "SELECT id,nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit=" pl.unit_id='".$_REQUEST['TmpLayanan']."' ";
}
else{
	$fUnit=" u.parent_id=".$_REQUEST['JnsLayanan']." ";
}
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$fKso = "";
	$fKso1 = "";
	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND t.kso_id = '$stsPas' ";
		$fKso1 = " AND pl.kso_id = '$stsPas' ";
	}
?>
<table width="750" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center; font-size:14px; text-transform:uppercase; font-weight:bold;" height="70" valign="top">laporan pendapatan <?php echo $rwUnit1['nama']?> - <?php echo $rwUnit2['nama']?><br><?php echo $Periode;?></td>
	</tr>
	<tr height="30">
		<td width="50%">&nbsp;<b>Tempat Layanan: <?php echo $rwUnit2['nama']?></b></td>
		<td width="50%" align="right">Yang Mencetak: <b><?php echo $rwPeg['nama']?></b>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php if($rwUnit2['inap']==0){?>
			<div id="jalan">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr height="30" style="font-weight:bold;">
					<td width="12%" style="padding-left:10px; border-bottom:1px solid; border-top:1px solid;">Status Pasien</td>
					<td width="13%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tgl Kunjungan</td>
					<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;No. RM</td>
					<td width="29%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama</td>
					<td width="12%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Retribusi&nbsp;</td>
					<td width="12%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Tindakan&nbsp;</td>
					<td width="12%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
				</tr>
				<?php
						$qKso="SELECT t.kso_id, kso.nama FROM b_kunjungan k INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id INNER JOIN b_ms_kso kso ON kso.id = t.kso_id 
WHERE $fUnit $waktu $fKso GROUP BY kso.id";
						//echo $qKso."<br>";
						$rsKso = mysql_query($qKso);
						$tot = 0;
						while($rwKso = mysql_fetch_array($rsKso))
						{
				?>
				<tr>
					<td colspan="7" style="font-weight:bold; padding-left:10px;"><?php echo $rwKso['nama'];?></td>
				</tr>
				<?php
						$sql="SELECT DATE_FORMAT(pl.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama, pl.id AS pelayanan_id, k.id AS kunjungan_id 
FROM b_ms_pasien p INNER JOIN b_kunjungan k ON k.pasien_id = p.id INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id 
WHERE $fUnit $waktu AND t.kso_id = '".$rwKso['kso_id']."' GROUP BY pl.id ORDER BY pl.tgl,p.nama";
						$rs = mysql_query($sql);
						$no = 1;
						$sub = 0;
						$jml = 0;
						while($rw = mysql_fetch_array($rs))
						{
							$qRet="SELECT SUM(t.qty*t.biaya) AS jml FROM b_kunjungan k
INNER JOIN b_pelayanan p ON p.kunjungan_id = k.id
INNER JOIN b_tindakan t ON t.pelayanan_id = p.id
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
WHERE p.id = '".$rw['pelayanan_id']."' $waktu AND mt.klasifikasi_id = '11' AND t.kso_id='".$rwKso['kso_id']."'";
							$rsRet = mysql_query($qRet);
							$rwRet = mysql_fetch_array($rsRet);
							
							$qTin = "SELECT SUM(t.qty*t.biaya) AS jml FROM b_kunjungan k
INNER JOIN b_pelayanan p ON p.kunjungan_id = k.id
INNER JOIN b_tindakan t ON t.pelayanan_id = p.id
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
WHERE p.id = '".$rw['pelayanan_id']."' $waktu AND mt.klasifikasi_id <> '11' AND t.kso_id='".$rwKso['kso_id']."'";
							$rsTin = mysql_query($qTin);
							$rwTin = mysql_fetch_array($rsTin);
							
							mysql_free_result($rsRet);
							mysql_free_result($rsTin);
				?>
				<tr>
					<td style="text-align:right; padding-right:30px;"><?php echo $no;?></td>
					<td>&nbsp;<?php echo $rw['tgl']?></td>
					<td>&nbsp;<?php echo $rw['no_rm']?></td>
					<td style="text-transform:uppercase">&nbsp;<?php echo $rw['nama']?></td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwRet['jml'],0,",",".");?>&nbsp;</td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwTin['jml'],0,",",".");?>&nbsp;</td>
					<?php $jml = $rwRet['jml'] + $rwTin['jml']?>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($jml,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
							$no++;
							$sub = $sub + $jml;
						}
						mysql_free_result($rs);
						
				?>
				<tr height="30" style="font-weight:bold">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top" style="border-top:1px solid;">&nbsp;</td>
					<td valign="top" style="text-align:right; border-top:1px solid;">Subtotal&nbsp;</td>
					<td valign="top" style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub,0,",",".");?>&nbsp;</td>
				</tr>
				<?php 
							$tot = $tot + $sub;
						}
						mysql_free_result($rsKso);
				?>
				<tr height="30" style="font-weight:bold;">
					<td colspan="4" style="border-bottom:1px solid; border-top:1px solid">&nbsp;</td>
					<td style="border-bottom:1px solid; border-top:1px solid">&nbsp;</td>
					<td style="border-bottom:1px solid; border-top:1px solid; text-align:right">Total&nbsp;</td>
					<td style="border-bottom:1px solid; border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($tot,0,",",".");?>&nbsp;</td>
				</tr>
			</table>
			</div>
			<?php }
			else{?>
			<div id="inap">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr height="30" style="font-weight:bold;">
					<td width="12%" style="padding-left:10px; border-bottom:1px solid; border-top:1px solid;">Status Pasien</td>
					<td width="13%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tgl MRS</td>
					<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;No. RM</td>
					<td width="25%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama</td>
					<td width="10%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Retribusi&nbsp;</td>
					<td width="10%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Tindakan&nbsp;</td>
					<td width="10%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Kamar&nbsp;</td>
					<td width="10%" style="padding-right:10px; text-align:right; border-bottom:1px solid; border-top:1px solid;">Total&nbsp;</td>
				</tr>
				<?php
						$qKso="SELECT t.kso_id, kso.nama FROM b_pelayanan pl INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id 
INNER JOIN b_ms_kso kso ON kso.id = t.kso_id WHERE $fUnit $waktu $fKso 
UNION
SELECT pl.kso_id, kso.nama FROM b_pelayanan pl INNER JOIN b_tindakan_kamar t ON t.pelayanan_id = pl.id 
INNER JOIN b_ms_kso kso ON kso.id = pl.kso_id 
WHERE $fUnit $waktu2 $fKso1 
GROUP BY kso.id ORDER BY kso_id";
						//echo $qKso."<br>";
						$rsKso = mysql_query($qKso);
						$tot = 0;
						while($rwKso = mysql_fetch_array($rsKso))
						{
				?>
				<tr>
					<td colspan="8" style="font-weight:bold; padding-left:10px;"><?php echo $rwKso['nama'];?></td>
				</tr>
				<?php
						$sql="SELECT DATE_FORMAT(pl.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama, pl.id AS pelayanan_id, k.id AS kunjungan_id 
FROM b_ms_pasien p INNER JOIN b_kunjungan k ON k.pasien_id = p.id INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id
INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id 
WHERE $fUnit $waktu AND t.kso_id='".$rwKso['kso_id']."'
UNION
SELECT DATE_FORMAT(pl.tgl,'%d/%m/%Y') AS tgl, p.no_rm, p.nama, pl.id AS pelayanan_id, k.id AS kunjungan_id 
FROM b_ms_pasien p INNER JOIN b_kunjungan k ON k.pasien_id = p.id INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id 
INNER JOIN b_tindakan_kamar t ON t.pelayanan_id = pl.id 
WHERE $fUnit $waktu2 AND pl.kso_id='".$rwKso['kso_id']."'
GROUP BY pl.id ORDER BY tgl,nama";
						$rs = mysql_query($sql);
						$no = 1;
						$sub = 0;
						$jml = 0;
						while($rw = mysql_fetch_array($rs))
						{
							$qRet="SELECT IFNULL(SUM(t.qty*t.biaya),0) AS jml FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
WHERE t.pelayanan_id = '".$rw['pelayanan_id']."' $waktu AND mt.klasifikasi_id = '11' AND t.kso_id='".$rwKso['kso_id']."'";
							$rsRet = mysql_query($qRet);
							$rwRet = mysql_fetch_array($rsRet);
							
							$qTin = "SELECT IFNULL(SUM(t.qty*t.biaya),0) AS jml FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
WHERE t.pelayanan_id = '".$rw['pelayanan_id']."' $waktu AND mt.klasifikasi_id <> '11' AND t.kso_id='".$rwKso['kso_id']."'";
							$rsTin = mysql_query($qTin);
							$rwTin = mysql_fetch_array($rsTin);
							
							if($waktuAsli == 'Harian'){
								/*$qKmr="SELECT IFNULL(SUM(IF(t.tgl_out IS NULL,1,IF(((t.status_out=1 AND DATE(t.tgl_in)='$tglAwal2' AND DATE(t.tgl_out)='$tglAwal2') OR (DATE(t.tgl_in)<>'$tglAwal2' AND DATE(t.tgl_out)='$tglAwal2')),0,1)) * t.tarip),0) total
FROM b_tindakan_kamar t WHERE t.pelayanan_id='".$rw['pelayanan_id']."' $waktu2";*/
								$qKmr="SELECT IFNULL(SUM(IF(t.tgl_out IS NULL,1,IF(((t.status_out=1 AND DATE(t.tgl_in)='$tglAwal2' AND DATE(t.tgl_out)='$tglAwal2') OR (DATE(t.tgl_in)<>'$tglAwal2' AND DATE(t.tgl_out)='$tglAwal2')),0,1)) * t.tarip),0) total 
FROM (SELECT t.id,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out,t.tarip,t.status_out FROM b_tindakan_kamar t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id 
WHERE t.pelayanan_id='".$rw['pelayanan_id']."' $waktu2) AS t";
							}elseif(strtolower($waktuAsli) == 'rentang waktu'){
								$qKmr="SELECT IFNULL(SUM(IF((t1.tgl_out>'$tglAkhir2' OR t1.tgl_outAsli IS NULL),DATEDIFF(t1.tgl_out,t1.tgl_in),IF(((t1.tgl_inAsli<'$tglAwal2' AND t1.tgl_out='$tglAwal2') OR (t1.tgl_inAsli=t1.tgl_outAsli AND t1.status_out=1)),0,IF((t1.tgl_inAsli=t1.tgl_outAsli AND t1.status_out=0),1,DATEDIFF(t1.tgl_out,t1.tgl_in)))) * t1.tarip),0) total 
FROM (SELECT id,pelayanan_id,tarip,status_out,aktif,IF(DATE(t.tgl_in)<'$tglAwal2','$tglAwal2',DATE(t.tgl_in)) AS tgl_in,IF((DATE(t.tgl_out) > '$tglAkhir2' OR t.tgl_out IS NULL),DATE_ADD('$tglAkhir2',INTERVAL 1 DAY),DATE(t.tgl_out)) AS tgl_out,
DATE(t.tgl_in) AS tgl_inAsli,DATE(t.tgl_out) AS tgl_outAsli
FROM b_tindakan_kamar t WHERE t.pelayanan_id='".$rw['pelayanan_id']."' AND DATE(t.tgl_in) <= '$tglAkhir2' AND (DATE(t.tgl_out) >= '$tglAwal2' OR t.tgl_out IS NULL)) AS t1";
							}else{
								$qKmr="SELECT IFNULL(SUM(IF((t1.tgl_out>LAST_DAY('$waktu3') OR t1.tgl_outAsli IS NULL),DATEDIFF(t1.tgl_out,t1.tgl_in),IF(((t1.tgl_inAsli<'$waktu3' AND t1.tgl_out='$waktu3') OR (t1.tgl_inAsli=t1.tgl_outAsli AND t1.status_out=1)),0,IF((t1.tgl_inAsli=t1.tgl_outAsli AND t1.status_out=0),1,DATEDIFF(t1.tgl_out,t1.tgl_in)))) * t1.tarip),0) total 
FROM (SELECT id,pelayanan_id,tarip,status_out,aktif,IF(DATE(t.tgl_in)<'$waktu3','$waktu3',DATE(t.tgl_in)) AS tgl_in,IF((DATE(t.tgl_out) > LAST_DAY('$waktu3') OR t.tgl_out IS NULL),DATE_ADD(LAST_DAY('$waktu3'),INTERVAL 1 DAY),DATE(t.tgl_out)) AS tgl_out,
DATE(t.tgl_in) AS tgl_inAsli,DATE(t.tgl_out) AS tgl_outAsli
FROM b_tindakan_kamar t WHERE t.pelayanan_id='".$rw['pelayanan_id']."' AND DATE(t.tgl_in) <= LAST_DAY('$waktu3') AND (DATE(t.tgl_out) >= '$waktu3' OR t.tgl_out IS NULL)) AS t1";
							}
							//echo $qKmr."<br>";
							$rsKmr = mysql_query($qKmr);
							$rwKmr = mysql_fetch_array($rsKmr);
							
							$jml = $rwRet['jml'] + $rwTin['jml'] + $rwKmr['total'];
							//$jml = $rwRet['jml'] + $rwTin['jml'];
							
							mysql_free_result($rsRet);
							mysql_free_result($rsTin);
							mysql_free_result($rsKmr);
							
							if ($jml>0){
				?>
				<tr>
					<td style="text-align:right; padding-right:30px;"><?php echo $no;?></td>
					<td>&nbsp;<?php echo $rw['tgl']?></td>
					<td>&nbsp;<?php echo $rw['no_rm']?></td>
					<td style="text-transform:uppercase">&nbsp;<?php echo $rw['nama']?></td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwRet['jml'],0,",",".");?>&nbsp;</td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwTin['jml'],0,",",".");?>&nbsp;</td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rwKmr['total'],0,",",".");?>&nbsp;</td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($jml,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
								$no++;
								$sub = $sub + $jml;
							}
						} 
						mysql_free_result($rs);
						
				?>
				<tr height="30" style="font-weight:bold">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top" style="border-top:1px solid;">&nbsp;</td>
					<td colspan="2" valign="top" style="text-align:right; border-top:1px solid;">Subtotal&nbsp;</td>
					<td valign="top" style="text-align:right; padding-right:10px; border-top:1px solid;"><?php echo number_format($sub,0,",",".");?>&nbsp;</td>
				</tr>
				<?php 
						$tot = $tot + $sub;
						} mysql_free_result($rsKso);
				?>
				<tr height="30" style="font-weight:bold;">
					<td colspan="4" style="border-bottom:1px solid; border-top:1px solid">&nbsp;</td>
					<td style="border-bottom:1px solid; border-top:1px solid">&nbsp;</td>
					<td colspan="2" style="border-bottom:1px solid; border-top:1px solid; text-align:right">Total&nbsp;</td>
					<td style="border-bottom:1px solid; border-top:1px solid; text-align:right; padding-right:10px;"><?php echo number_format($tot,0,",",".");?>&nbsp;</td>
				</tr>
			</table>
			</div>
			<?php
			}?>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr><td colspan="10" style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td></tr>
  <tr><td colspan="10" height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td></tr>
  <tr><td colspan="10" style="text-align:right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td></tr>
  <tr id="trTombol">
        <td colspan="10" class="noline" align="center">
			<?php 
            if($_POST['export']!='excel'){
            ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
			<?php 
            }
            ?>
    </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
<script type="text/JavaScript">
	
	function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
	window.print();
	window.close();
	}
}
    
</script>
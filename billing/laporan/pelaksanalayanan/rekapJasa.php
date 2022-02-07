<?php
session_start();
if ($_POST['export']) {
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="lap_pendapatan_jasa-pelaksana_tempat-layanan.xls"');
}
include("../../sesi.php");
?>
<title>.: Rekap Pembagian Jasa Konsul/Visite Dokter :.</title>
<?php
		include("../../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
		$jam = date("G:i");
		
		$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_tindakan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }
    else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_tindakan.tgl) = '$bln' and year(b_tindakan.tgl) = '$thn' ";
		$Periode = " $arrBln[$bln] $thn";
    }
    else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_tindakan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$kso = $_REQUEST['StatusPas'];
	if($kso==0){
		$fKso = "";
	}else{
		$fKso = " AND b_pelayanan.kso_id = '".$kso."'";
	}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<style>
	.jdl{
		text-align:center;
		font-weight:bold;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		border-left:1px solid #000000;
	}
	.jdlkn{
		text-align:center;
		font-weight:bold;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
	}
	.isi{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
	}
	.isikn{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
	}
</style>
<table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td height="70" valign="top" style="font-weight:bold; text-transform:uppercase; text-align:center; font-size:14px;">rekap pembagian jasa konsul/visite dokter<br>PERIODE PEMBAYARAN : <?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td width="5%" height="30" class="jdl">NO</td>
					<td width="29%" class="jdl">NAMA DOKTER</td>
					<td width="11%" class="jdl">JUMLAH<br>PASIEN</td>
					<td width="11%" class="jdl">JUMLAH<br>KUNJUNGAN</td>
					<td width="11%" class="jdl">JUMLAH<br>JASA VISITE</td>
					<td width="11%" class="jdl">FEE FOR<br>SERVICE</td>
					<td width="11%" class="jdl">Pph. Ps. 21<br>2,5%</td>
					<td width="11%" class="jdlkn">DITERIMA<br>BERSIH</td>
				</tr>
				<tr>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">1</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">2</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">3</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">4</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">5</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">6</td>
					<td class="isi" style="text-align:center; background-color:#CCFFFF;">7</td>
					<td class="isikn" style="text-align:center; background-color:#CCFFFF;">8</td>
				</tr>
				<?php
						$qDok = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_ms_pegawai INNER JOIN b_tindakan ON b_tindakan.user_id = b_ms_pegawai.id INNER JOIN b_pelayanan ON b_pelayanan.id = b_tindakan.pelayanan_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id WHERE b_ms_pegawai.spesialisasi_id <> 0 AND b_ms_unit.parent_id = '50' AND b_ms_tindakan.klasifikasi_id = '13' $waktu $fKso GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
						$rsDok = mysql_query($qDok);
						$no = 1;
						$tot1 = 0;
						$tot2 = 0;
						$tot3 = 0;
						$tot4 = 0;
						$tot5 = 0;
						$tot6 = 0;
						while($rwDok = mysql_fetch_array($rsDok))
						{
							$sql = "SELECT t2.jml, t2.jmlKunj, t2.jasa, (t2.jasa*84/100) AS fee, ((t2.jasa*84/100)*2.5/100) AS pph, ((t2.jasa*84/100)-((t2.jasa*84/100)*2.5/100)) AS diterima FROM (SELECT COUNT(t.pasien_id) AS jml, SUM(t.jmlTind) AS jmlKunj, SUM(t.biaya) AS jasa FROM (SELECT b_pelayanan.pasien_id, COUNT(b_tindakan.id) AS jmlTind, SUM(b_tindakan.biaya) AS biaya FROM b_tindakan INNER JOIN b_pelayanan ON b_pelayanan.id = b_tindakan.pelayanan_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id WHERE b_ms_unit.parent_id = '50' AND b_ms_tindakan.klasifikasi_id = '13' AND b_tindakan.user_id = '".$rwDok['id']."' $waktu $fKso GROUP BY b_pelayanan.pasien_id) AS t) AS t2";
							$rs = mysql_query($sql);
							$rw = mysql_fetch_array($rs);
							mysql_free_result($rs);
				?>
				<tr>
					<td class="isi" style="text-align:center"><?php echo $no;?></td>
					<td class="isi">&nbsp;<?php echo $rwDok['nama'];?></td>
					<td class="isi" style="text-align:right; padding-right:30px;"><?php if($rw['jml']=='') echo 0; else echo $rw['jml'];?></td>
					<td class="isi" style="text-align:right; padding-right:30px;"><?php if($rw['jmlKunj']=='') echo 0; else  echo $rw['jmlKunj']?></td>
					<td class="isi" style="text-align:right; padding-right:10px;"><?php echo number_format($rw['jasa'],0,",",".")?></td>
					<td class="isi" style="text-align:right; padding-right:10px;"><?php echo number_format($rw['fee'],0,",",".")?></td>
					<td class="isi" style="text-align:right; padding-right:10px;"><?php echo number_format($rw['pph'],0,",",".")?></td>
					<td class="isikn" style="text-align:right; padding-right:10px;"><?php echo number_format($rw['diterima'],0,",",".")?></td>
				</tr>
				<?php
						$no++;
						$tot1 = $tot1 + $rw['jml'];
						$tot2 = $tot2 + $rw['jmlKunj'];
						$tot3 = $tot3 + $rw['jasa'];
						$tot4 = $tot4 + $rw['fee'];
						$tot5 = $tot5 + $rw['pph'];
						$tot6 = $tot6 + $rw['diterima'];
						}mysql_free_result($rsDok);
				?>
				<tr>
					<td height="28" colspan="2" class="isi" style="text-align:center; font-weight:bold; background-color:#CCFFFF;">TOTAL&nbsp;</td>
					<td class="isi" style="background-color:#CCFFFF; text-align:right; padding-right:30px; font-weight:bold;"><?php echo $tot1;?></td>
					<td class="isi" style="background-color:#CCFFFF; text-align:right; padding-right:30px; font-weight:bold;"><?php echo $tot2;?></td>
					<td class="isi" style="background-color:#CCFFFF; text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($tot3,0,",",".");?></td>
					<td class="isi" style="background-color:#CCFFFF; text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($tot4,0,",",".");?></td>
					<td class="isi" style="background-color:#CCFFFF; text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($tot5,0,",",".");?></td>
					<td class="isikn" style="background-color:#CCFFFF; text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($tot6,0,",",".");?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" height="70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?><br>Yang Mencetak,</td>
	</tr>
	<tr>
		<td style="text-align:right; text-transform:uppercase"><b><?php echo $rwPeg['nama'];?></b></td>
	</tr>
	<tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<?php
	mysql_free_result($rsPeg);
	mysql_close($konek);?>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }
</script>
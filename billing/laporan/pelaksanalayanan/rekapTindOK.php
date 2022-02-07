<?php
session_start();
if ($_POST['export']) {
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="lap_pendapatan_jasa-pelaksana_tempat-layanan.xls"');
}
include("../../sesi.php");
?>
<title>.: Rekap Tindakan Pasien OK :.</title>
<?php
include("../../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
		$jam = date("G:i");
		
		$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }
    else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(tgl) = '$bln' and year(tgl) = '$thn' ";
		$Periode = "Bulan : $arrBln[$bln] $thn";
    }
    else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and tgl between '$tglAwal2' and '$tglAkhir2' ";
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$inap = $_REQUEST['cmbPel'];
	$kso = $_REQUEST['StatusPas'];
	if($kso==0){
		$fKso = "";
	}else{
		$fKso = " AND pl.kso_id = '".$kso."'";
	}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_SESSION['userId']."'";
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
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
</table>
<?php
$sUnit="select * from b_ms_unit where id=".$_REQUEST['TmpLayananOK'];
$qUnit=mysql_query($sUnit);
$rUnit=mysql_fetch_array($qUnit);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td height="70" valign="top" style="font-weight:bold; text-transform:uppercase; text-align:center; font-size:14px;">rekap tindakan pasien<br />jenis layanan OK - <?php echo $rUnit['nama']; ?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td width="4%" height="30" class="jdl">NO</td>
					<td width="6%" class="jdl">NO RM</td>
					<td width="20%" class="jdl">NAMA PASIEN</td>
                    <td width="9%" class="jdl">PENJAMIN</td>
					<td width="9%" class="jdl">TANGGAL</td>
					<td class="jdl">TINDAKAN</td>
					<td width="9%" class="jdl">BIAYA OPERASI</td>
					<td width="12%" class="jdl">DOKTER OP.</td>
					<td width="12%" class="jdlkn">DOKTER AN.</td>
				</tr>
				<tr>
					<td class="isi" style="text-align:center; background-color:#999">1</td>
					<td class="isi" style="text-align:center; background-color:#999;">2</td>
					<td class="isi" style="text-align:center; background-color:#999;">3</td>
                    <td class="isi" style="text-align:center; background-color:#999;">4</td>
					<td class="isi" style="text-align:center; background-color:#999;">5</td>
					<td class="isi" style="text-align:center; background-color:#999;">6</td>
					<td class="isi" style="text-align:center; background-color:#999;">7</td>
					<td class="isi" style="text-align:center; background-color:#999;">8</td>
					<td class="isikn" style="text-align:center; background-color:#999;">9</td>
				</tr>
                <?php
				$sql="SELECT 
				  t.id,
				  ps.no_rm,
				  ps.nama,
				  t.tgl,
				  tin.nama AS tindakan,
				  t.biaya,
				  p.nama AS dokter_op,
				  kso.nama kso 
				FROM
				  (SELECT * FROM b_tindakan WHERE 0=0 $waktu) t 
				  INNER JOIN b_pelayanan pl 
					ON pl.id = t.pelayanan_id 
				  INNER JOIN b_ms_tindakan_kelas tk 
					ON tk.id = t.ms_tindakan_kelas_id 
				  INNER JOIN b_ms_kelas k 
					ON tk.ms_kelas_id = k.id 
				  INNER JOIN b_ms_tindakan tin 
					ON tin.id = tk.ms_tindakan_id 
				  INNER JOIN b_ms_pasien ps 
					ON ps.id = pl.pasien_id 
				  LEFT JOIN b_ms_pegawai p 
					ON p.id = t.user_id
				  INNER JOIN b_ms_kso kso
    				ON kso.id = pl.kso_id 
				WHERE pl.unit_id='".$_REQUEST['TmpLayananOK']."' $fKso ORDER BY kso.nama,ps.no_rm";
				$kueri=mysql_query($sql);
				$no=0;
				$totBiaya=0;
				while($rows=mysql_fetch_array($kueri)){
				$no++;
				?>
				<tr>
					<td class="isi" style="text-align:center"><?php echo $no; ?></td>
					<td class="isi"b style="text-align:center"><?php echo $rows['no_rm']; ?></td>
					<td class="isi" style="text-align:left; padding-left:10px;"><?php echo $rows['nama']; ?></td>
                    <td class="isi" style="text-align:center;"><?php echo $rows['kso']; ?></td>
					<td class="isi" style="text-align:center;"><?php echo tglSQL($rows['tgl']); ?></td>
					<td class="isi" style="text-align:left; padding-left:10px;"><?php echo $rows['tindakan']; ?></td>
					<td class="isi" style="text-align:right; padding-right:10px;"><?php echo number_format($rows['biaya'],0,',','.'); ?></td>
					<td class="isi" style="text-align:left; padding-left:10px;"><?php echo $rows['dokter_op']; ?></td>
					<?php
					$sqlAn="SELECT 
					  b.nama 
					FROM
					  b_tindakan_dokter_anastesi a 
					  INNER JOIN b_ms_pegawai b 
						ON a.dokter_id = b.id 
					WHERE a.tindakan_id = '".$rows['id']."'";
					$query=mysql_query($sqlAn);
					$dokAn=mysql_fetch_array($query);
					?>
                    <td class="isikn" style="text-align:left; padding-left:10px;"><?php echo $dokAn[0]; ?>&nbsp;</td>
				</tr>
                <?php
				$totBiaya=$totBiaya+$rows['biaya'];
				}
				?>
				<tr>
					<td height="28" colspan="2" class="isi" style="text-align:center; font-weight:bold; background-color:#999;">TOTAL&nbsp;</td>
					<td class="isi" style="background-color:#999; text-align:right; padding-right:60px; font-weight:bold;">&nbsp;</td>
                    <td class="isi" style="background-color:#999; text-align:right; padding-right:60px; font-weight:bold;">&nbsp;</td>
					<td class="isi" style="background-color:#999; text-align:right; padding-right:60px; font-weight:bold;">&nbsp;</td>
					<td class="isi" style="background-color:#999; text-align:right; padding-right:10px; font-weight:bold;">&nbsp;</td>
					<td class="isi" style="background-color:#999; text-align:right; padding-right:10px; font-weight:bold;"><?php echo number_format($totBiaya,0,',','.'); ?></td>
					<td class="isi" style="background-color:#999; text-align:right; padding-right:10px; font-weight:bold;">&nbsp;</td>
					<td class="isikn" style="background-color:#999; text-align:right; padding-right:10px; font-weight:bold;">&nbsp;</td>
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
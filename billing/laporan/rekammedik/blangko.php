<?php
session_start();
include("../../sesi.php");
include ("../../koneksi/konek.php");
//session_start();
//=====================================
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " and k.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " and month(k.tgl) = '$bln' and year(k.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " and k.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

$jnsLayanan = $_REQUEST['JnsLayanan'];
$tmpLayanan = $_REQUEST['TmpLayanan'];
$qT = "SELECT id, nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
$rsT = mysql_query($qT);
$rwT = mysql_fetch_array($rsT);

	$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND k.kso_id = $stsPas ";
	}
?>
<title>Rekap Kunjungan Pasien</title>
<body>
<table width="925" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td style="font-weight:bold"><?=$pemkabRS?>
		<br />
		<?=$namaRS?>
		<br />
		<?=$alamatRS?>
		<br />
		Telepon <?=$tlpRS?></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="text-transform:uppercase; font-size:14px; font-weight:bold">kunjungan pasien <?php echo $rwT['nama']; ?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td>&nbsp;<i>Petunjuk Pengisian</i>: Isilah dengan tanda (x) di kolom yang tersedia sesuai dengan kelengkapan berkas yang diterima</td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td rowspan="2" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">NO</td>
				<td rowspan="2" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;NO. RM</td>
				<td rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;NAMA PASIEN</td>
				<td colspan="10" align="center" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">KELENGKAPAN BERKAS</td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">RUJUKAN AWAL</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">FC SJP</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">FC KARTU JAMKESMAS</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">FC KARTU PKH/DINAS SOSIAL</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">FC SKTM</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">PENDAFTARAN</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">KONSUL</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">PENUNJANG</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">OBAT</td>
				<td style="border-bottom:1px solid; border-right:1px solid; text-align:center;">KETERANGAN</td>
			</tr>
			<?php
					$qKso = "SELECT kso.nama, kso.id FROM b_ms_pasien p
							INNER JOIN b_kunjungan k ON k.pasien_id = p.id
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
							INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
							WHERE pl.unit_id = '".$tmpLayanan."' $waktu $fKso
							GROUP BY kso.nama";
					$rsKso = mysql_query($qKso);
					while($rwKso = mysql_fetch_array($rsKso))
					{
			?>
			<tr>
				<td height="20" valign="bottom" colspan="3" style="border-left:1px solid; font-size:12px; font-weight:bold;">&nbsp;<u><?php echo $rwKso['nama'];?></u></td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid; border-right:1px solid;">&nbsp;</td>
			</tr>
			<?php
					$qPas = "SELECT p.no_rm, p.nama FROM b_ms_pasien p
							INNER JOIN b_kunjungan k ON k.pasien_id = p.id
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
							INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
							WHERE pl.unit_id = '".$tmpLayanan."' AND k.kso_id = '".$rwKso['id']."'
							GROUP BY p.nama";
					$rsPas = mysql_query($qPas);
					$no = 1;
					while($rwPas = mysql_fetch_array($rsPas))
					{
			?>
			<tr>
				<td width="3%" style="border-left:1px solid; border-bottom:1px dashed; text-align:center"><?php echo $no;?></td>
				<td width="7%" style="border-bottom:1px dashed;">&nbsp;<?php echo $rwPas['no_rm'];?></td>
				<td width="20%" style="border-bottom:1px dashed;">&nbsp;<?php echo $rwPas['nama'];?></td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed;">&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px dashed; border-right:1px solid;">&nbsp;</td>
			</tr>
			
			<?php 
					$no++;
					}
					} 
			?>
			<tr>
				<td colspan="13">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="13">
					<table align="center" width="50%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td align="center" width="40%">PENGELOLA DATA,</td>
							<td align="center" width="10%">&nbsp;</td>
							<td align="center" width="50%">VERIFIKATOR PENDAFTARAN,</td>
						</tr>
						<tr>
							<td colspan="3" height="50">&nbsp;</td>
						</tr>
						<tr>
							<td style="border-bottom:1px solid;">&nbsp;</td>
							<td>&nbsp;</td>
							<td style="border-bottom:1px solid;">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td height="30">&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
</body>
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
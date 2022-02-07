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
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = " AND DATE(b_pasien_keluar.tgl_act) = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = " AND MONTH(b_pasien_keluar.tgl_act) = '$bln' AND YEAR(b_pasien_keluar.tgl_act) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND DATE(b_pasien_keluar.tgl_act) BETWEEN '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }

    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
	
	$jnsLay = $_REQUEST['JnsLayananInapSaja'];
	$tmpLay = $_REQUEST['TmpLayananInapSaja'];
	
	$qJns = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id='".$jnsLay."'");
	$wJns = mysql_fetch_array($qJns);
	
	$qTmp = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id='".$tmpLay."'");
	$wTmp = mysql_fetch_array($qTmp);

?>
<title>.: Laporan TT :.</title>
<style>
	.jdl{
		border-left:1px solid #FFFFFF;
		background-color:#FF99FF;
		font-weight:bold;
		text-transform:uppercase;
		text-align:center;
		height:25;
		font-size:12px;
	}
</style>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td style="text-transform:uppercase; font-size:14px; font-weight:bold; text-align:center;" height="100" valign="top">reklapitulasi tempat tidur<br>jenis layanan <?php echo $wJns['nama'];?><br>tempat layanan <?php if($tmpLay==0) echo "SEMUA"; else echo $wTmp['nama'];?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td class="jdl" width="5%">no</td>
					<td class="jdl" width="50%">kamar</td>
					<td class="jdl" width="15%">jumlah tt</td>
					<td class="jdl" width="15%">dipakai</td>
					<td class="jdl" width="15%">kosong</td>
				</tr>
				<?php
						if($tmpLay==0){
							$fUnit = "b_ms_unit.parent_id = '".$jnsLay."'";
						}else{
							$fUnit = "b_ms_unit.id = '".$tmpLay."'";
						}
						$qUn = mysql_query("SELECT * FROM b_ms_unit WHERE $fUnit AND aktif=1 ORDER BY nama");
						while($wUn = mysql_fetch_array($qUn))
						{
				?>
				<tr>
					<td colspan="5" style="padding-left:20px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="28"><?php echo $wUn['nama']?></td>
				</tr>
				<?php
						$qKmr = mysql_query("SELECT id, nama, jumlah_tt FROM b_ms_kamar WHERE unit_id='".$wUn['id']."' AND aktif=1 ORDER BY kode");
						$no=1;
						while($wKmr = mysql_fetch_array($qKmr))
						{
								$qJml = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
										FROM b_tindakan_kamar INNER JOIN b_pelayanan ON b_pelayanan.id=b_tindakan_kamar.pelayanan_id 
										WHERE b_tindakan_kamar.kamar_id='".$wKmr['id']."'
										AND DATE(b_tindakan_kamar.tgl_in)<='$tglAwal2' 
										AND (b_tindakan_kamar.tgl_out IS NULL AND b_pelayanan.tgl_krs IS NULL)";
								$sJml = mysql_query($qJml);
								$wJml = mysql_fetch_array($sJml);
				?>
				<tr>
					<td style="text-align:center;"><?php echo $no;?></td>
					<td style="padding-left:10px; text-transform:uppercase;" height="20"><?php echo $wKmr['nama'];?></td>
					<td style="text-align:center;"><?php echo $wKmr['jumlah_tt'];?></td>
					<td style="text-align:center;"><?php echo $wJml['jml'];?></td>
					<?php $kosong = $wKmr['jumlah_tt']-$wJml['jml'];?>
					<td style="text-align:center;"><?php if($wJml['jml']>$wKmr['jumlah_tt']) echo 0; else echo $kosong;?></td>
				</tr>
				<?php
						$no++;
						}
						}
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
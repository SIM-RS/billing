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
<title>Buku Transaksi Tindakan</title>
<?php
include("../../koneksi/konek.php");
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");

$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND pl.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}
	
	$sqlJnsLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsJnsLay = mysql_query($sqlJnsLay);
	$rwJnsLay = mysql_fetch_array($rsJnsLay);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlTmpLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsTmpLay = mysql_query($sqlTmpLay);
	$rwTmpLay = mysql_fetch_array($rsTmpLay);
	$fUnit = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND k.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="925" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; font-size:14px; font-weight:bold; text-transform:uppercase">Buku Tindakan Pasien <br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td style="text-align:right; font-size:11px; font-weight:bold">Yang Mencetak: <?php echo $rwPeg['nama'];?>&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;<b>Tempat Layanan: <?php echo $rwTmpLay['nama'];?></b></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-weight:bold; font-size:12px">
					<td height="30" width="3%" style="border-top:1px solid; border-bottom:1px solid; text-align:center">No.</td>
					<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Tgl. Kunjungan</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Asal Pasien</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Keterangan</td>
					<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No RM</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Nama Pasien</td>
					<td width="4%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;JK</td>
					<td width="4%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Umur</td>
					<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Alamat</td>
					<td width="20%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Tgl. Transaksi - Layanan</td>
					<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Biaya</td>
				</tr>
				<?php
						$sql1 = "SELECT kso.id, kso.nama FROM b_ms_kso kso
								INNER JOIN b_kunjungan k ON k.kso_id = kso.id
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' 
								$waktu $fKso GROUP BY kso.nama";
						$rs1 = mysql_query($sql1);
						while($rw1 = mysql_fetch_array($rs1))
						{
				?>
				<tr>
					<td colspan="3">&nbsp;<b><?php echo $rw1['nama'];?></b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?php
						$sql2 = "SELECT pl.id, DATE_FORMAT(k.tgl_act, '%d/%m/%Y %H:%i:%s') AS tgl, 
								u.nama AS asalpasien, pl.ket, p.no_rm,
								k.umur_thn, p.alamat, p.nama, p.sex,
								(SELECT nama FROM b_ms_wilayah WHERE id = p.kec_id) AS kec
								FROM b_ms_pasien p
								INNER JOIN b_kunjungan k ON k.pasien_id = p.id
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_ms_unit u ON u.id = pl.unit_id_asal
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."' $waktu
								AND k.kso_id = '".$rw1['id']."'";
						$rs2 = mysql_query($sql2);
						$no = 1;
						while($rw2 = mysql_fetch_array($rs2))
						{
				?>
				<tr>
					<td align="center"><?php echo $no;?></td>
					<td>&nbsp;<?php echo $rw2['tgl'];?></td>
					<td>&nbsp;<?php echo $rw2['asalpasien'];?></td>
					<td>&nbsp;<?php echo $rw2['ket'];?></td>
					<td>&nbsp;<?php echo $rw2['no_rm'];?></td>
					<td>&nbsp;<?php echo $rw2['nama'];?></td>
					<td style="text-align:center"><?php echo $rw2['sex'];?></td>
					<td style="text-align:center"><?php echo $rw2['umur_thn'];?></td>
					<td colspan="3">&nbsp;<?php echo $rw2['alamat'].',&nbsp;'.$rw2['kec'];?></td>
				</tr>
				<?php
						$sql3 = "SELECT DATE_FORMAT(pl.tgl,'%d/%m/%Y') AS tgl, mt.nama, t.biaya  
								FROM b_kunjungan k 
								INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
								INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
								INNER JOIN b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
								INNER JOIN b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
								WHERE pl.id = '".$rw2['id']."'";
						$rs3 = mysql_query($sql3);
						while($rw3 = mysql_fetch_array($rs3))
						{
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
					<td colspan="2">&nbsp;<?php echo $rw3['tgl'].'&nbsp;'.$rw3['nama'];?></td>
					<td style="text-align:right; font-size:10px"><?php echo number_format($rw3['biaya'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<?php
						}
						$no++;
						}
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
				</tr>
				<?php
						}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right">Tgl Cetak: <?php echo $date_now .'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right">Yang Mencetak,&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td height="50">&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right"><?php echo $rwPeg['nama']?>&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr id="trTombol">
  		<td align="center" class="noline">
        <?php 
            if($_POST['export']!='excel'){
        ?>
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        <?php 
            }
        ?>
        </td>
  </tr>
</table>
<?php
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
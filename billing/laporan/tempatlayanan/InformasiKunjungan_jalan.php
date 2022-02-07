<?php
session_start();
include("../../sesi.php");
?>
<title>.: Laporan Informasi Kunjungan Pasien Rawat Jalan :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['JnsLayanan'];
	$tmpLayanan = $_REQUEST['TmpLayanan'];
	$stsPas = $_REQUEST['StatusPas'];
	$dilayani = $_REQUEST['stsDilayani'];
	
	if($dilayani==2)
	{
		$fdilayani = "SEMUA";
	}else if($dilayani==1){
		$fdilayani = "SUDAH";
	}else{
		$fdilayani = "BELUM";
	}
	
	if($stsPas!=0){
		$fKso = "AND b_kunjungan.kso_id = '".$stsPas."'";
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLayanan."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$stsPas."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td style="text-align:center; font-size:14px; text-transform:uppercase; font-weight:bold;" height="70" valign="top">Rekapitulasi Kunjungan Pasien - <?php echo $rwUnit1['nama']?><br>tempat Layanan <?php if($tmpLayanan==0) echo "SEMUA"; else echo $rwUnit2['nama']?><br>Penjamin Pasien <?php if($stsPas==0) echo "SEMUA"; else echo $rwKso['nama'];?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;Status Dilayani : <?php echo $fdilayani?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			  <tr style="font-weight:bold; text-align:center;">
				<td width="3%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunjungan</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
				<td width="25%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
				<td width="23%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
				<td width="20%" style="border-top:1px solid; border-bottom:1px solid;">Tempat Layanan Asal</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Status<br>Dilayani</td>
			  </tr>
			  <?php
			  		if($tmpLayanan==0){ 
						$fUnit = "b_ms_unit.parent_id = '".$jnsLayanan."'";
					}else{
						$fUnit = "b_ms_unit.id = '".$tmpLayanan."'";
					}
					if($dilayani==0 OR $dilayani==1) $fYani = "AND b_pelayanan.dilayani = '".$dilayani."'";
					$qUn = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit
							INNER JOIN b_pelayanan ON b_pelayanan.unit_id = b_ms_unit.id 
							INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
							WHERE $fUnit $waktu $fYani $fKso GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama";
					$rsUn = mysql_query($qUn);
					while($rwUn = mysql_fetch_array($rsUn))
					{
			  ?>
			  <tr>
				<td colspan="7" height="28" style="padding-left:10px; text-decoration:underline; text-transform:uppercase; font-weight:bold;"><?php echo $rwUn['nama'];?></td>
			  </tr>
			  <?php
			  		$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_ms_kso
							INNER JOIN b_kunjungan ON b_kunjungan.kso_id = b_ms_kso.id
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $fKso $waktu $fYani 
							GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama ";
					$rsK = mysql_query($qK);
					while($rwK = mysql_fetch_array($rsK))
					{
			  ?>
			  <tr>
				<td colspan="7" height="20" style="padding-left:20px; font-weight:bold; text-transform:uppercase;"><?php echo $rwK['nama']?></td>
			  </tr>
			  <?php
			  		$sql = "SELECT DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') AS tgl,
							b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat,
							IF(b_pelayanan.dilayani=1,'SUDAH','BELUM') AS dilayani,
							b_pelayanan.id AS pl_id
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
							WHERE b_pelayanan.unit_id = '".$rwUn['id']."' 
							AND b_kunjungan.kso_id = '".$rwK['id']."' $waktu $fYani $fKso GROUP BY b_pelayanan.id";
					$rs = mysql_query($sql);
					$no = 1;
					while($rw = mysql_fetch_array($rs))
					{
						$qAs = "SELECT b_ms_unit.nama AS asal FROM b_pelayanan
								INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
								WHERE b_pelayanan.id = '".$rw['pl_id']."'";
						$rsAs = mysql_query($qAs);
						$rwAs = mysql_fetch_array($rsAs);
						mysql_free_result($rsAs);
			  ?>
			  <tr>
				<td style="text-align:center;" valign="top"><?php echo $no.'.';?></td>
				<td style="text-align:center" valign="top"><?php echo $rw['tgl']?></td>
				<td style="text-align:center" valign="top"><?php echo $rw['no_rm'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rw['nama'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rw['alamat'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rwAs['asal']?></td>
				<td style="text-align:center; padding-left:5px;" valign="top"><?php echo $rw['dilayani'];?></td>
			  </tr>
			  <?php
			  		$no++;
					}mysql_free_result($rs);
					}mysql_free_result($rsK);
					}mysql_free_result($rsUn);
			  ?>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border-top:1px solid;">&nbsp;</td>
	</tr>
	<tr>
        <td style="text-align:right; height:70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
    </tr>
    <tr>
        <td style="text-align:right; font-weight:bold;"><?php echo $rwPeg['nama']?>&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
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
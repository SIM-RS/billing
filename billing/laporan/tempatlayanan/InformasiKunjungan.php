<?php
session_start();
include("../../sesi.php");
?>
<?php
	include("../../koneksi/konek.php");
	session_start();
	$userId = $_SESSION['userId'];
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
	
	$jnsLayanan = $_REQUEST['cmbJenisLayanan'];
	$tmpLayanan = $_REQUEST['cmbTempatLayanan'];
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
	
	$sVer="SELECT p.id ,g.nama AS grup FROM b_ms_group_petugas gp
		INNER JOIN b_ms_group g ON g.id=gp.ms_group_id
		INNER JOIN b_ms_pegawai p ON p.id=gp.ms_pegawai_id
		WHERE (g.nama LIKE '%VERIFIKATOR%' OR g.nama LIKE '%CIO%' OR g.ket LIKE '%VERIFIKATOR%')
		AND p.id='$userId'";
	$rsVer=mysql_query($sVer);
	$hidden="none";
	if(mysql_num_rows($rsVer)>0){
		$rwVer=mysql_fetch_array($rsVer);				
		$vid=$rwVer['id'];
		$hidden="table-cell";
	}
?>
<title>.: Laporan Informasi Kunjungan Pasien Rawat Jalan :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td style="text-align:center; font-size:14px; text-transform:uppercase; font-weight:bold;" height="70" valign="top">Rekapitulasi Kunjungan Pasien - <?php if($jnsLayanan==0){ echo "RAWAT JALAN"; }else if($jnsLayanan==1){ echo "RAWAT INAP";} else { echo "PENUNJANG"; } ?><br>tempat Layanan <?php if($tmpLayanan==0) echo "SEMUA"; else echo $rwUnit2['nama']?><br>Penjamin Pasien <?php if($stsPas==0) echo "SEMUA"; else echo $rwKso['nama'];?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;Status Dilayani : <?php echo $fdilayani?></td>
	</tr>
	<tr>
		<td><?php if($jnsLayanan==0 || $jnsLayanan==2) {?>
			<div id="jalan">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			  <tr style="font-weight:bold; text-align:center;">
				<td width="3%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunjungan</td>
				<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
				<td width="20%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
				<td width="18%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
				<td width="18%" style="border-top:1px solid; border-bottom:1px solid;">Asal Kunjungan</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Status<br>Dilayani</td>
			    <td width="8%" style="border-top:1px solid; border-bottom:1px solid; display:<?php echo $hidden;?>;">Status<br />Verifikasi</td>
			    <td width="10%" style="border-top:1px solid; border-bottom:1px solid; display:<?php echo $hidden;?>;">Verifikator</td>
			  </tr>
			  <?php
					if($tmpLayanan==0){ 
						if($jnsLayanan==0){
							$fUnit = "b_ms_unit.inap = 0 AND b_ms_unit.penunjang = 0";
						}else{
							$fUnit = "b_ms_unit.inap = 0 AND b_ms_unit.penunjang = 1";
						}
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
						$qJml = "SELECT COUNT(t.jml) AS jml FROM (SELECT b_pelayanan.pasien_id AS jml
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu GROUP BY b_pelayanan.id ) AS t ";
						$rsJml = mysql_query($qJml);
						$rwJml = mysql_fetch_array($rsJml);
						mysql_free_result($rsJml);
						
						$qSdh = "SELECT COUNT(t.sudah) AS jml
FROM (SELECT b_pelayanan.pasien_id AS sudah
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu AND b_pelayanan.dilayani = '1'
GROUP BY b_pelayanan.id ) AS t";
						$rsSdh = mysql_query($qSdh);
						$rwSdh = mysql_fetch_array($rsSdh);
						mysql_free_result($rsSdh);
						
						$qBlm = "SELECT COUNT(t.belum) AS jml
FROM (SELECT b_pelayanan.pasien_id AS belum
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu AND b_pelayanan.dilayani = '0'
GROUP BY b_pelayanan.id ) AS t";
						$rsBlm = mysql_query($qBlm);
						$rwBlm = mysql_fetch_array($rsBlm);
						mysql_free_result($rsBlm);
			  ?>
			  <tr>
				<td colspan="9" height="28" style="padding-left:10px; text-decoration:underline; text-transform:uppercase; font-weight:bold;"><?php echo $rwUn['nama'];?></td>
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
				<td colspan="9" height="20" style="padding-left:20px; font-weight:bold; text-transform:uppercase;"><?php echo $rwK['nama']?></td>
			  </tr>
			  <?php
			  		$sql = "SELECT DATE_FORMAT(b_pelayanan.tgl_act,'%d-%m-%Y %H:%i') AS tgl,
							b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat,
							IF(b_pelayanan.dilayani=1,'SUDAH','BELUM') AS dilayani,
							IF(b_pelayanan.verifikasi=0,'BELUM','SUDAH') AS verifikasi, b_ms_pegawai.nama AS verifikator,
							b_pelayanan.id AS pl_id
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
							LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator
							WHERE b_pelayanan.unit_id = '".$rwUn['id']."' 
							AND b_kunjungan.kso_id = '".$rwK['id']."' $waktu $fYani GROUP BY b_pelayanan.id";
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
			    <td style="text-align:center; padding-left:5px; display:<?php echo $hidden;?>;" valign="top"><?php echo $rw['verifikasi'];?></td>
			    <td style="text-align:center; padding-left:5px; display:<?php echo $hidden;?>;" valign="top"><?php if($rw['verifikator']=="") echo "-"; else echo $rw['verifikator'];?></td>
			  </tr>
			  <?php
			  		$no++;
					}mysql_free_result($rs);
					}mysql_free_result($rsK);
				?>
			<tr>
			  	<td height="28" colspan="3" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold;">&nbsp;Total Pasien : <?php echo $rwJml['jml'];?></td>
		  	    <td height="28" colspan="2" style="border-bottom:1px solid; border-top:1px solid; padding-left:50px; font-weight:bold;">Total Pasien Belum Dilayani : <?php echo $rwBlm['jml'];?></td>
		  	    <td height="28" colspan="4" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold;">Total Pasien Sudah Dilayani : <?php echo $rwSdh['jml'];?></td>
	  	      </tr>
			  <?php 
					}mysql_free_result($rsUn);
			  ?>
			</table>
			</div>
			<?php } else { ?>
			<div id="inap">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			  <tr style="font-weight:bold; text-align:center;">
				<td width="3%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunjungan</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
				<td width="25%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
				<td width="21%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Asal Kunjungan</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Status<br>Dilayani</td>
			    <td width="10%" style="border-top:1px solid; border-bottom:1px solid; display:<?php echo $hidden;?>;">Status<br />Verifikasi</td>
			    <td width="10%" style="border-top:1px solid; border-bottom:1px solid; display:<?php echo $hidden;?>;">Verifikator</td>
			  </tr>
			  <?php
			  		if($tmpLayanan==0){ 
						$fUnit = "b_ms_unit.inap = '".$jnsLayanan."'";
					}else{
						$fUnit = "b_ms_unit.id = '".$tmpLayanan."'";
					}
					if($dilayani==0 OR $dilayani==1) $fYani = "AND b_pelayanan.dilayani = '".$dilayani."'";
					$qUn = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit
							INNER JOIN b_pelayanan ON b_pelayanan.unit_id = b_ms_unit.id 
							INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE $fUnit $waktu $fYani $fKso GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama";
					$rsUn = mysql_query($qUn);
					while($rwUn = mysql_fetch_array($rsUn))
					{
						$qJml = "SELECT COUNT(t.jml) AS jml FROM (SELECT b_pelayanan.pasien_id AS jml
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu GROUP BY b_pelayanan.id ) AS t ";
						$rsJml = mysql_query($qJml);
						$rwJml = mysql_fetch_array($rsJml);
						mysql_free_result($rsJml);
						
						$qSdh = "SELECT COUNT(t.sudah) AS jml
FROM (SELECT b_pelayanan.pasien_id AS sudah
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu AND (b_pelayanan.dilayani = '1' OR b_pelayanan.dilayani = '2')
GROUP BY b_pelayanan.id ) AS t";
						$rsSdh = mysql_query($qSdh);
						$rwSdh = mysql_fetch_array($rsSdh);
						mysql_free_result($rsSdh);
						
						$qBlm = "SELECT COUNT(t.belum) AS jml
FROM (SELECT b_pelayanan.pasien_id AS belum
FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $waktu AND b_pelayanan.dilayani = '0'
GROUP BY b_pelayanan.id ) AS t";
						$rsBlm = mysql_query($qBlm);
						$rwBlm = mysql_fetch_array($rsBlm);
						mysql_free_result($rsBlm);
			  ?>
			  <tr>
				<td colspan="10" height="28" style="padding-left:10px; text-decoration:underline; text-transform:uppercase; font-weight:bold;"><?php echo $rwUn['nama'];?></td>
			  </tr>
			  <?php
			  		$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_ms_kso
							INNER JOIN b_kunjungan ON b_kunjungan.kso_id = b_ms_kso.id
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$rwUn['id']."' $fKso $waktu $fYani 
							GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama ";
					$rsK = mysql_query($qK);
					while($rwK = mysql_fetch_array($rsK))
					{
			  ?>
			  <tr>
				<td colspan="10" height="20" style="padding-left:20px; font-weight:bold; text-transform:uppercase;"><?php echo $rwK['nama']?></td>
			  </tr>
			  <?php
			  		$sql = "SELECT DATE_FORMAT(b_kunjungan.tgl_act,'%d-%m-%Y %H:%i') AS tgl,
							b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, b_pelayanan.id AS pl_id,
							IF(b_pelayanan.dilayani=0,'BELUM','SUDAH') AS dilayani,
							DATE_FORMAT(b_tindakan_kamar.tgl_in, '%d-%m-%Y') AS mrs,
							IF(b_pelayanan.verifikasi=0,'BELUM','SUDAH') AS verifikasi, b_ms_pegawai.nama AS verifikator
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator
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
				<td style="text-align:center" valign="top"><?php echo $rw['mrs']?></td>
				<td style="text-align:center" valign="top"><?php echo $rw['no_rm'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rw['nama'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rw['alamat'];?></td>
				<td style="text-transform:uppercase; padding-left:5px;" valign="top"><?php echo $rwAs['asal']?></td>
				<td style="text-align:center; padding-left:5px;" valign="top"><?php echo $rw['dilayani'];?></td>
			    <td style="text-align:center; padding-left:5px; display:<?php echo $hidden;?>;" valign="top"><?php echo $rw['verifikasi'];?></td>
			    <td style="text-align:center; padding-left:5px; display:<?php echo $hidden;?>;" valign="top"><?php if($rw['verifikator']=="") echo "-"; else echo $rw['verifikator'];?></td>
			  </tr>
			  <?php
			  		$no++;
					}mysql_free_result($rs);
					}mysql_free_result($rsK);
			  ?>
			<tr>
			  	<td height="28" colspan="3" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold;">&nbsp;Total Pasien : <?php echo $rwJml['jml'];?></td>
		  	    <td height="28" colspan="3" style="border-bottom:1px solid; border-top:1px solid; padding-left:50px; font-weight:bold;">Total Pasien Belum Dilayani : <?php echo $rwBlm['jml'];?></td>
		  	    <td height="28" colspan="4" style="border-bottom:1px solid; border-top:1px solid; font-weight:bold; padding-left:30px;">Total Pasien Sudah Dilayani : <?php echo $rwSdh['jml'];?></td>
	  	      </tr>
			  <?php 
					}mysql_free_result($rsUn);
			  ?>
			</table>
			</div>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
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
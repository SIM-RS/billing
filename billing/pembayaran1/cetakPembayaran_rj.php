<?php
	include("../sesi.php");
	include("../koneksi/konek.php");
	$date_now = gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	$userId = $_REQUEST['idUser'];
	$idKunj=$_REQUEST['kunjungan_id'];

$qwe="SELECT t.id FROM b_tindakan t WHERE t.biaya_pasien > 0 AND t.kunjungan_id = '".$idKunj."';";
$rsQwe=mysql_query($qwe);
$cekIurKRS=0;
if(mysql_num_rows($rsQwe)>0){
	$cekIurKRS=1;
}

$umum_stlh_krs = " ";
$umum_stlh_krs2 = " ";	
if($cekIurKRS==1){
	$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
	$umum_stlh_krs2 = " AND t._krs<>1 ";
}
	
	$jeniskasir = $_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	$idbayar=$_REQUEST['idbayar'];
	/*$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);*/
	$sql = "SELECT mp.nama FROM b_ms_pegawai mp WHERE mp.id = '$userId'";
	$rs = mysql_query($sql);
	$rows = mysql_fetch_array($rs);
	$sqlNamaKasir = "SELECT mp.nama FROM b_bayar b INNER JOIN b_ms_pegawai mp ON mp.id = b.user_act WHERE b.id = '$idbayar'";
	$rsNamaKasir = mysql_query($sqlNamaKasir);
	$rowsNamaKasir = mysql_fetch_array($rsNamaKasir);
	$kasir = $rowsNamaKasir['nama'];
	$pencetak = $rows["nama"];
	$dibayar=0;
	$titipan=0;
	$keringanan=0;
	$jaminan=0;
	$sql = "SELECT b.*,DATE_FORMAT(b.tgl_act,'%d-%m-%Y %H:%i:%s') AS tglBayar FROM b_bayar b WHERE b.id = '$idbayar'";
	$rs = mysql_query($sql);
	if (mysql_num_rows($rs)>0){
		$rows=mysql_fetch_array($rs);
		$dibayar=$rows["nilai"];
		$titipan=$rows["titipan"];
		$keringanan=$rows["keringanan"];
		$tglBayar=$rows["tglBayar"];
		$nokwitansi=$rows["no_kwitansi"];
	}
	$idKasir = $_REQUEST['idKasir'];
	
	if ($idbayar == '' && $idPel == '') { 
		/* KASIR RAWAT INAP PASIEN KSO */
		$sqlCount = "SELECT MAX(count)+1 AS count FROM b_bayar_cetak WHERE kunjungan_id = '{$idKunj}' AND kasir_id = '{$idKasir}'";
	} else if ($idbayar == '' && $idPel != '') {
		/* KASIR RAWAT JALAN PASIEN KSO */
		$sqlCount = "SELECT MAX(count)+1 AS count FROM b_bayar_cetak WHERE kunjungan_id = '{$idKunj}' AND pelayanan_id = '{$idPel}' AND kasir_id = '{$idKasir}'";
	} else {
		/* SEMUA KASIR PASIEN UMUM */
		$sqlCount = "SELECT MAX(count)+1 AS count FROM b_bayar_cetak WHERE bayar_id = '{$idbayar}' AND kasir_id = '{$idKasir}'";
	}
	$queryCount = mysql_query($sqlCount);
	$rowsCount = mysql_fetch_array($queryCount);
	if($rowsCount['count'] == 0){
		$count = "Asli";
	}else{
		$count = "Copy ".$rowsCount['count'];
	}
?>
<title>Loket</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
<script type="text/javascript" src="../theme/js/ajax.js"></script>
 <script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
 <span id="cetak_count" style="display:none;"></span>
        <table width="580" border="0" cellpadding="0" cellspacing="2" align="left" class="kwi">
	<tr>
		<td width="92">&nbsp;</td>
		<td width="303">&nbsp;</td>
		<td width="84">&nbsp;</td>
		<td width="95">&nbsp;</td>
	</tr>
	<?php
		$sql1 = "SELECT 
		p.no_rm, 
		k.no_billing, 
		p.nama, 
		p.alamat, 
		p.rt,
		p.rw, 
		k.unit_id, 
		u.nama AS namaunit, 
		k.tgl, 
		k.kso_id, 
		kso.nama AS STATUS, 
		k.id,
		p.id AS pasien_id, 
		pl.no_lab,
		DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_ms_unit u ON u.id = k.unit_id
INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
WHERE k.id = '".$_REQUEST['kunjungan_id']."'";
		$rs1 = mysql_query($sql1);
		$rw1 = mysql_fetch_array($rs1);
		$ksoid=$rw1['kso_id'];
		$idKSOnew=$rw1['kso_id'];
		//$nL = "SELECT no_lab FROM b_pelayanan WHERE pasien_id = '".$rw1['pasien_id']."' AND jenis_layanan = '".$idKasir."'";
		$nL = "SELECT no_lab FROM b_pelayanan WHERE id = '".$idPel."'";
		$rsL = mysql_query($nL);
		$rwL = mysql_fetch_array($rsL);
	?>
	<tr>
		<td colspan="3" style="text-align:left;">
			<b><!--PEMERINTAH <?php echo strtoupper($kotaRS);?> <br>-->
			<?=$namaRS?><br>
			<?php echo strtoupper($alamatRS." ".$kotaRS);?><br>
			<?php echo strtoupper($tlpRS);?></b>
		</td>
		<td style="text-align:right;" valign="bottom">
			<div style="float:right; margin-bottom:10px; padding-left:5px; padding-right:5px; color:#808080; font-weight:bold; text-decoration:underline">
				<?php echo $count; ?>
			</div>
			<div style="float:right; clear:both; font-size:26px; font-weight:bold; padding-right:30px;">
				&nbsp;<?php if($idKasir=='57') echo $rwL['no_lab'];?>
			</div>
		</td>
	</tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">&nbsp;</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;" colspan="3">&nbsp;</td>
		
	</tr>
    <?php
	$fDisK="visibility:hidden";
	if($_REQUEST['kasir']==127){
		$fDisK="visibility:visible";	
	}
	?>
    <tr class="kwi">
		<td style="font-size:16px; font-weight: bold; font-family: verdana;">NRM</td>
		<td style="font-size:16px; font-weight: bold; font-family: verdana;">:&nbsp;<?php echo $rw1['no_rm'];?></td>
		<td style="font-size:12px">No. Billing</td>
		<td style="font-size:12px;">:&nbsp;<?php echo $rw1['no_billing'];?></td>
	</tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">Nama</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">:&nbsp;<?php echo strtolower($rw1['nama']);?></td>
        <td style="font-size:12px; <?php echo $fDisK; ?>">No. Bukti</td>
		<td style="font-size:12px; <?php echo $fDisK; ?>">:&nbsp;<?php echo $nokwitansi;?></td>
	    </tr>
	<tr class="kwi">
		<td style="font-size:12px">Tgl Lahir</td>
		<td style="font-size:12px" colspan="3">:&nbsp;<?php echo $rw1['tgl_lahir']; ?></td>
	</tr>
    <tr class="kwi">
		<td style="font-size:12px">Alamat</td>
		<td style="font-size:12px" colspan="3">:&nbsp;<?php echo strtolower($rw1['alamat']).' RT.'.$rw1['rt'].' RW.'.$rw1['rw'];?></td>
	</tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">Kunjungan</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;" colspan="3">:&nbsp;<?php echo $rw1['namaunit'];?></td>
	</tr>
	<tr class="kwi">
		<td style="font-size:10px">Tgl</td>
		<td style="font-size:10px">:&nbsp;<?php echo tglSQL($rw1['tgl']);?></td>
		<td style="font-size:10px">Status Ps</td>
		<td style="font-size:10px">:&nbsp;<?php echo strtolower($rw1['STATUS']);?></td>
	</tr>
    <tr class="kwi">
		<td style="border-bottom:1px solid;font-size:10px">&nbsp;</td>
		<td style="border-bottom:1px solid;font-size:10px">&nbsp;</td>
		<td style="border-bottom:1px solid;font-size:10px">&nbsp;</td>
		<td style="border-bottom:1px solid;font-size:10px">&nbsp;</td>
	</tr>
    <tr class="kwi">
		<td colspan="4">
			<table width="580" border="0" cellpadding="0" cellspacing="0" style="font-size:10px" class="kwi">
				<tr>
					<td width="43" height="28" align="center" style="font-weight:bold;font-size:10px; border-bottom:1px solid">No</td>
					<td width="351" style="font-weight:bold;font-size:10px; border-bottom:1px solid">&nbsp;Uraian</td>
					<td width="85" align="right" style="font-weight:bold;font-size:10px; border-bottom:1px solid">Qty</td>
					<td width="101" style="font-weight:bold;font-size:10px; border-bottom:1px solid;padding-right:20px" align="right">Jumlah&nbsp;</td>
				</tr>
				<?php
				$i=0;
				
				$sLoket="select * from b_bayar where kunjungan_id='".$_REQUEST['kunjungan_id']."' and jenis_kunjungan='".$_REQUEST['jenisKunj']."' and kasir_id=127";
				$qLoket=mysql_query($sLoket);
				$adaloket=0;
				if(mysql_num_rows($qLoket)>0){
					$adaloket=1;
				}
				
				$fTind='';
				if($adaloket==1){
					$fTind="AND t.ms_tindakan_kelas_id NOT IN (7513)";	
				}
				
				if($_REQUEST['kasir']==127){
					$sql="SELECT * 
					FROM (
					SELECT 
					DISTINCT p.id,
					mu.nama,
					mu.id idUnit 
					FROM 
					b_pelayanan p			  
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
					WHERE 
					p.kunjungan_id='$idKunj' 
					AND t.ms_tindakan_kelas_id IN (7513)) AS t ORDER BY id";
				}
				else{
					$sql="SELECT * 
					FROM (
					SELECT 
					DISTINCT p.id,
					mu.nama,
					mu.id idUnit 
					FROM 
					b_pelayanan p			  
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
					WHERE 
					p.kunjungan_id='$idKunj' 
					AND p.jenis_kunjungan='".$_REQUEST['jenisKunj']."'
					$fTind
					) AS t ORDER BY id";
				}
					//echo $sql."<br/>";
					$rs = mysql_query($sql);
					$sBayar=0;
					$sBiaya=0;
					$bKmr=0;
					while($row = mysql_fetch_array($rs)){
				?>
				<tr>
                    <td colspan="4" style="font-size:10px; font-weight:bold; padding-left:18px;" height="28" align="left"><?php echo $row['nama'];?></td>
				</tr>
				<?php
				
				if($_REQUEST['kasir']==127){	
					$sTind="SELECT 
							DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,
							mt.nama,
							(t.biaya_kso+t.biaya_pasien)*t.qty as biaya,
							t.biaya_kso*t.qty as biaya_kso,
							t.qty cTind
							FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
							WHERE t.pelayanan_id='".$row['id']."'
							AND t.ms_tindakan_kelas_id IN (7513) $umum_stlh_krs2
							ORDER BY t.id";
				}
				else{
					$sTind="SELECT 
							DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,
							mt.nama,
							(t.biaya_kso+t.biaya_pasien)*t.qty as biaya,
							t.biaya_kso*t.qty as biaya_kso,
							t.qty cTind
							FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
							WHERE t.pelayanan_id='".$row['id']."'
							$fTind $umum_stlh_krs2
							ORDER BY t.id";
				}
					//echo $sTind."<br>";
					$qTind=mysql_query($sTind);
					
					while($rwTind=mysql_fetch_array($qTind)){
						$i++;
				?>
				<tr>
					<td align="center" style="font-size:10px"><?php echo $i?></td>
					<td style="font-size:10px"><?php echo strtolower($rwTind['nama']);?></td>
					<td style="font-size:10px" align="right"><?php echo $rwTind['cTind'];?></td>
					<td style="font-size:10px;padding-right:20px" align="right"><?php echo number_format($rwTind['biaya'],0,",",".");?>&nbsp;</td>
				</tr>
				<?php 
						$sBiaya+=$rwTind['biaya'];
						$jaminan+=$rwTind['biaya_kso'];
					}
					//echo "---JamTind".$jaminan."<br/>";
				//Awal Obat
				if($_REQUEST['kasir']!=127){
				
					$fCaraBayar="AND ap.CARA_BAYAR=2";
							
					$sKonsul="SELECT 
					DISTINCT ap.NO_PENJUALAN,ap.DOKTER,au.UNIT_NAME 
					FROM $dbapotek.a_penjualan ap
					inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN 
					inner join b_ms_kso kso on kso.id=p.kso_id
					inner join $dbapotek.a_unit au on au.UNIT_ID=ap.UNIT_ID  
					WHERE 
					ap.NO_PASIEN='".$rw1['no_rm']."' 
					AND ap.NO_KUNJUNGAN='".$row['id']."'
					AND kso.id='".$ksoid."'
					$fCaraBayar
					";
					//echo $sKonsul."<br>";
					/*
					$sKonsul2="SELECT DISTINCT ap.NO_PENJUALAN,ap.DOKTER,ap.CARA_BAYAR,ac.nama FROM $dbapotek.a_penjualan ap inner join $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.NO_KUNJUNGAN='".$rwUnit['id']."' AND ap.CARA_BAYAR=2";*/
					//echo $sKonsul."<br><br><br>";
					$tObat=0;
					$tObatJamin=0;
					$qKonsul=mysql_query($sKonsul);
					while($rwKonsul=mysql_fetch_array($qKonsul)) {
					$i++;
				?>
				<tr>
                    <td colspan="4" style="font-size:10px; font-weight:bold; padding-left:18px;" align="left"><?php echo $i."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nota Resep ".$rwKonsul['NO_PENJUALAN']." - ".$rwKonsul['UNIT_NAME'];?></td>
				</tr>
				<?php
					
						/* $sObat="SELECT *, 
							  IF(RETUR=0,'',CONCAT('(',RETUR,')')) AS nretur
							  FROM 
							  (SELECT
							  ao.OBAT_NAMA,
							  ap.DOKTER,
							  ap.NO_PENJUALAN,
							  ac.id AS CARA_BAYAR_ID,
							  ac.nama AS CARA_BAYAR,
							  SUM(ap.QTY_JUAL) QTY_JUAL, 
							  SUM(ap.QTY_RETUR) QTY_RETUR,
							  SUM(ap.QTY_JUAL - ap.QTY_RETUR) QTY, 
							  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS TGL,
							  am.NAMA KSO, 
							  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL,
							  IF(ap.DIJAMIN=1,SUM(IF(ap.CARA_BAYAR=2,((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN),0)),'0') AS DIJAMIN,
							  SUM(ap.QTY_RETUR * ap.HARGA_SATUAN) AS RETUR,
							  k.nama AS kelas,
							  if(hk.id=1,'-',hk.nama) AS hakkelas,
							  k.level AS kelas_level,
							  k.tipe AS kelas_tipe,
							  hk.level AS hakkelas_level,
							  ap.TGL_ACT,
							  b_pelayanan.is_paviliun,
							  ap.KRONIS,
							  ap.DIJAMIN AS STAT_DIJAMIN,
							  ap.ID AS idpenjualan
							FROM
							  (SELECT 
								* 
							  FROM
								dbapotek.a_penjualan 
							  WHERE NO_KUNJUNGAN = '".$row['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."' AND DOKTER='".$rwKonsul['DOKTER']."') AS ap 
							  INNER JOIN $dbapotek.a_penerimaan pn 
								ON ap.PENERIMAAN_ID = pn.ID 
							  INNER JOIN $dbapotek.a_obat ao 
								ON pn.OBAT_ID = ao.OBAT_ID 
							  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
							  INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
							  INNER JOIN b_pelayanan 
								ON ap.NO_KUNJUNGAN = b_pelayanan.id
							  inner join b_ms_kso kso on kso.id=b_pelayanan.kso_id
							  INNER JOIN b_kunjungan
								ON b_kunjungan.id = b_pelayanan.kunjungan_id
							  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
							  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id
							  where kso.id='".$ksoid."'
							  $fCaraBayar
							GROUP BY ao.OBAT_ID) AS tbl ORDER BY OBAT_NAMA"; */
							
							$sObat="SELECT *, 
							  IF(RETUR=0,'',CONCAT('(',RETUR,')')) AS nretur
							  FROM 
							  (SELECT
							  ao.OBAT_NAMA,
							  ap.DOKTER,
							  ap.NO_PENJUALAN,
							  ac.id AS CARA_BAYAR_ID,
							  ac.nama AS CARA_BAYAR,
							  SUM(ap.QTY_JUAL) QTY_JUAL, 
							  SUM(ap.QTY_RETUR) QTY_RETUR,
							  /* SUM(ap.QTY_JUAL - ap.QTY_RETUR) QTY, */
							  SUM(ap.QTY_JUAL) QTY,
							  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS TGL,
							  am.NAMA KSO, 
							  /* SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL, */
							  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN) AS SUBTOTAL,
							  /* IF(ap.DIJAMIN=1,SUM(IF(ap.CARA_BAYAR=2,((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN),0)),'0') AS DIJAMIN, */
							  IF(ap.DIJAMIN=1,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0') AS DIJAMIN,
							  SUM(ap.QTY_RETUR * ap.HARGA_SATUAN) AS RETUR,
							  k.nama AS kelas,
							  if(hk.id=1,'-',hk.nama) AS hakkelas,
							  k.level AS kelas_level,
							  k.tipe AS kelas_tipe,
							  hk.level AS hakkelas_level,
							  ap.TGL_ACT,
							  b_pelayanan.is_paviliun,
							  ap.KRONIS,
							  ap.DIJAMIN AS STAT_DIJAMIN,
							  ap.ID AS idpenjualan
							FROM
							  (SELECT 
								* 
							  FROM
								dbapotek.a_penjualan 
							  WHERE NO_KUNJUNGAN = '".$row['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."' AND DOKTER='".$rwKonsul['DOKTER']."') AS ap 
							  INNER JOIN $dbapotek.a_penerimaan pn 
								ON ap.PENERIMAAN_ID = pn.ID 
							  INNER JOIN $dbapotek.a_obat ao 
								ON pn.OBAT_ID = ao.OBAT_ID 
							  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
							  INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
							  INNER JOIN b_pelayanan 
								ON ap.NO_KUNJUNGAN = b_pelayanan.id
							  inner join b_ms_kso kso on kso.id=b_pelayanan.kso_id
							  INNER JOIN b_kunjungan
								ON b_kunjungan.id = b_pelayanan.kunjungan_id
							  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
							  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id
							  where kso.id='".$ksoid."'
							  $fCaraBayar
							GROUP BY ao.OBAT_ID) AS tbl ORDER BY OBAT_NAMA";
							
						//echo $sObat."|||<br><br>";
						$qObat=mysql_query($sObat);
						$j=0;
						while($rwObat=mysql_fetch_array($qObat)){
						$j++;
							
							$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' AND b.jenis_kunjungan = '".$_REQUEST['jenisKunj']."' ORDER BY b.id DESC";
							//echo $queByr."<br/><br/>";
							$dByr = mysql_fetch_array(mysql_query($queByr));
							
							//awal query cek retur
							$sRetur="SELECT SUM(a.QTY_RETUR) QTY, SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,
								b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
								FROM $dbapotek.a_penjualan a
								INNER JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
								LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
								WHERE a.ID = '".$rwObat['idpenjualan']."' ";
							//echo $sRetur."<br/><br/>";
							$qRetur=mysql_query($sRetur);
							$rwRetur=mysql_fetch_array($qRetur);
								if($rwRetur['DiffDate']==0){
									$subtotObat=$rwObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
									$dijaminObt=$rwObat['DIJAMIN']-$rwRetur['DIJAMIN'];
									$qtyObt=$rwObat['QTY']-$rwRetur['QTY'];
									$rrr=0;
								}else{
									$subtotObat=$rwObat['SUBTOTAL'];
									$dijaminObt=$rwObat['DIJAMIN'];
									$qtyObt=$rwObat['QTY'];
									$rrr=1;
								}
							//akhir query cek retur
						
							$jaminan2=$dijaminObt;
							
							$nBiayaJaminanObat=$dijaminObt;//$rwObat['DIJAMIN'];
							
							$bObat=$subtotObat;//$rwObat['SUBTOTAL'];
							$txtKetObat="";
							if($rwObat['KRONIS']=='2'){ // OBAT PAKET
								$bObat=0;
								$nBiayaJaminanObat=0;
								$jaminan2=0;
								$txtKetObat="PAKET";	
							}
							
							if($ksoid!=1){
								if($rwObat['STAT_DIJAMIN']=='0'){ // KET  OBAT TIDAK DIJAMIN
									$txtKetObat="Tidak Dijamin";	
								}
							}
							
							if($ksoid==6){
								$nBiayaJaminanObat=0;
								$jaminan2=0;
								
								/*
								if(($rwObat['hakkelas_level']>=$rwObat['kelas_level']) || ($isVIP_UMUM==1 && $rwObat['kelas_tipe']=='1') || ($rwObat['kelas_tipe']=='1' && $rwObat['is_paviliun']=='0') || ($isNaikKelas==0 && $rwObat['kelas_tipe']=='1'))
									$txtKetObat="Paket BPJS";
								*/
							}
							else if($ksoid==73){
								$nBiayaJaminanObat=0;
								//$jaminan2=0;		//jaminan JASA RAHARJA
								$subBiayaKSO+=$bObat;	
							}
							else{
								if($ksoid==1){
									$nBiayaJaminanObat=0;
									$jaminan2=0;
									$totBiaya_umum+=$bObat;	
								}
								else{
									$subBiayaKSO+=$bObat;		
								}
							}
							
							//echo "---JMN".$jaminan2."|||".$dijaminObt."|=|KSO".$ksoid."<br/>";
							//echo "---KSO".$rwKSO['id']."|=|";
							$jaminan+=$jaminan2; //untuk retur OBAT
				?>
				<tr>
					<td align="right" style="font-size:10px"><?php echo $j?>&nbsp;&nbsp;</td>
					<td style="font-size:10px"><?php echo strtolower($rwObat['OBAT_NAMA']);?></td>
					<td style="font-size:10px" align="right"><?php echo $qtyObt;//$rwObat['QTY'];?></td>
					<td style="font-size:10px;padding-right:20px" align="right"><?php echo number_format($bObat,0,",",".");?>&nbsp;</td>
				</tr>
				<?php
						$sBiaya+=$bObat;
						
						}
					}
					
				}
				//Akhir Obat
				
				}
				
				?>
				<tr>
				 	<td style="border-bottom:1px solid;">&nbsp;</td>
					<td style="border-bottom:1px solid;">&nbsp;</td>
					<td style="border-bottom:1px solid;">&nbsp;</td>
					<td style="border-bottom:1px solid;">&nbsp;</td>
				</tr>
	  </table></td>
	</tr>
    <tr class="kwi">
    	<td colspan="4">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>

            	<td width="68%" valign="top" style="padding-top:5px;">
                	<?php
					$fDis="";
					if($_REQUEST['kasir']==127){
						$fDis='style="display:none"';	
					}
					?>
                	<table cellpadding="0" cellspacing="0" border="0" width="100%" <?php echo $fDis; ?>>
                    <tr>
                        <td width="26%" align="center" style="font-weight:bold;font-size:9px;">Tgl Bayar</td>
                        <td width="26%" align="center" style="font-weight:bold;font-size:9px;">No Kwitansi</td>
                        <td width="17%" align="right" style="font-weight:bold;font-size:9px;">Pembayaran&nbsp;</td>
                        <td width="31%" align="center" style="font-weight:bold;font-size:9px;">Kasir</td>
                        
                    </tr>
                    <?php
                    $sPembayaran="select 
                                    concat(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,
                                    b.no_kwitansi as nokwi,
                                    pg.username as kasir,
                                    if(b.tipe=1,b.titipan,b.nilai) as nominal
                                    from 
                                    (select * from b_bayar where kasir_id<>127) b 
                                    inner join b_ms_pegawai pg on pg.id=b.user_act
                                    where 
                                    b.kunjungan_id='$idKunj'
                                    and b.jenis_kunjungan = '".$_REQUEST['jenisKunj']."' 
                                    order by b.id";
					//echo $sPembayaran."<br/>";
                    $qPembayaran=mysql_query($sPembayaran);
                    $no=0;
                    while($rwPembayaran=mysql_fetch_array($qPembayaran)){
                        $no++;
                    ?>
                    <tr>
                        <td width="26%" align="center" style="font-size:9px;"><?php echo $rwPembayaran['tgl']; ?></td>
                        <td width="26%" align="center" style="font-size:9px;"><?php echo $rwPembayaran['nokwi']; ?></td>
                        <td align="right" style="font-size:9px;"><?php echo number_format($rwPembayaran['nominal'],0,",","."); ?>&nbsp;</td>
                        <td width="31%" align="center" style="font-size:9px;"><?php echo $rwPembayaran['kasir']; ?></td>
                        
                    </tr>
                    <?php
                    }
                    ?>
                    </table>
                </td>
                <td width="32%" valign="top" style="padding-top:5px;">
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                        	<td width="44%" style="font-size:10px; font-weight:bold;" align="right">Total</td>
                            <td width="56%" style="font-size:10px; font-weight:bold;padding-right:20px" align="right"><?php echo number_format($sBiaya,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php 
						if ($jaminan>0){
				 		?>
                   		<tr>
                        	<td style="font-size:10px; font-weight:bold;" align="right">Dijamin</td>
                            <td style="font-size:10px; font-weight:bold;padding-right:20px;" align="right"><?php echo number_format($jaminan,0,",",".");?>&nbsp;</td>
                        </tr>
                        <?php
						}
						?>
                        <tr>
                        	<td style="font-size:10px; font-weight:bold;" align="right">Dibayar</td>
                            <?php

							if($_REQUEST['kasir']==127){
							}
							else{
								$byr=0;
								if($adaloket=='1'){
									$sBayar="select sum(nilai) as nilai from b_bayar 
										where 
										kunjungan_id='".$idKunj."' 
										and jenis_kunjungan='".$_REQUEST['jenisKunj']."'
										and kasir_id not in (127)";		
								}
								else{
									$sBayar="select sum(nilai) as nilai from b_bayar 
											where 
											kunjungan_id='".$idKunj."' 
											and jenis_kunjungan='".$_REQUEST['jenisKunj']."'";
								}
								$qBayar=mysql_query($sBayar);
								if(mysql_num_rows($qBayar)>0){
									$rwBayar=mysql_fetch_array($qBayar);
									$byr=$rwBayar['nilai'];
								}
								$dibayar=$byr;
							}
							
							?>
                            <td style="font-size:10px; font-weight:bold;padding-right:20px" align="right"><?php echo number_format($dibayar,0,",",".");?>&nbsp;</td>
                        </tr>
						<?php
							$krg_byr = $sBiaya-($jaminan+$titipan+$keringanan+$dibayar);	//-50000;
							
							//echo "KRG".$krg_byr."---BIAY".$sBiaya."---JAMIN".$jaminan."---TITIP".$titipan."---RINGAN".$keringanan."---DBYR".$dibayar;
							
							$bayare = $krg_byr;
							$krgbyrnya = "Kurang Bayar";
							if($krg_byr<0){
								//$bayare = $krg_byr * (-1);	//lebih bayar pasiennya
								$bayare = abs($krg_byr);	//lebih bayar pasiennya
								$krgbyrnya = "Lebih Bayar";
							}
						?>
                        <tr>
                        	<td style="font-size:10px; font-weight:bold;" align="right"><?php echo $krgbyrnya;?></td>
                            <td style="font-size:10px; font-weight:bold;padding-right:20px" align="right"><?php echo number_format($bayare,0,",",".");?>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </td>
    </tr>
	<tr class="kwi">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="center" style="font-size:10px;">
			Medan,
			<?php 
				if ($idbayar != '') { 
					echo $tglBayar; 
				} else { 
					echo $date_now.' '.$jam;
				}
			?>
		</td>
	</tr>
	<tr class="kwi">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="kwi">
		<td style="font-size:10px; padding-left:5px">
		<?php if ($idbayar != '') { ?>
			Tgl. Cetak
		<?php } ?>
		</td>
        <td style="font-size:10px; padding-left:5px">: <?php echo $date_now; ?></td>
		<td colspan="2" align="center" style="font-size:10px;">
		<?php 
			if ($idbayar != '') {
				echo '( '.$kasir.' )';
			} 
		?>
		</td>
	</tr>
	<tr class="kwi">
		<td style="font-size:10px; padding-left:5px">Yang Mencetak</td>
		<td style="font-size:10px; padding-left:5px">: <?php echo $pencetak; ?></td>
        <td colspan="2" align="center" style="font-size:10px;">Kasir</td>
	</tr>
    <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<script type="text/JavaScript">
	try{
		formatKuitansi();
	}catch(e){
		window.location='../addon/jsprintsetup.xpi';
	}
    function cetak(tombol){
		tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
			/* idbayar=&idKunj=43&idPel=&idUser=609&jenisKasir=0 */
			var idbayar = '<?php echo $idbayar; ?>';
			var idKunj = '<?php echo $idKunj; ?>';
			var idPel = '<?php echo $idPel; ?>';
			var idUser = '<?php echo $userId; ?>';
			var idKasir = '<?php echo $_REQUEST['idKasir']; ?>';
			var jnsKasir = '<?php echo $jeniskasir; ?>';
			var total = '<?php echo $sBiaya; ?>';
			var jaminan = '<?php echo $jaminan; ?>';
			var variable = '?action=getCount&idbayar='+idbayar+'&idKunj='+idKunj+'&idPel='+idPel+
						   '&idUser='+idUser+'&idKasir='+idKasir+'&jnsKasir='+jnsKasir+
						   '&total='+total+'&jaminan='+jaminan;
			Request("bayar_action.php"+variable,'cetak_count','','GET',function(){
				//alert(document.getElementById('cetak_count').innerHTML);
				try{
					mulaiPrint();
				}
				catch(e){
					window.print();
					window.close();
				}
			});
		}
		//});
    }
</script>
<?php 
mysql_close($konek);
?>
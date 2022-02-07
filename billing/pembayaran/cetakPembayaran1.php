<?php
//session_start();
include("../sesi.php");
?>
<?php
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	$userId = $_REQUEST['idUser'];
	$idKunj=$_REQUEST['kunjungan_id'];
	$jeniskasir=$_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	$idbayar=$_REQUEST['idbayar'];
	/*$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);*/
	$sql = "SELECT mp.nama FROM b_ms_pegawai mp WHERE mp.id = '$userId'";
	$rs = mysql_query($sql);
	$rows=mysql_fetch_array($rs);
	$kasir=$rows["nama"];
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
	}
	$idKasir = $_REQUEST['jenisKasir'];
?>
<title>Loket</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
 <script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
        <table width="580" border="0" cellpadding="0" cellspacing="2" align="left" class="kwi">
	<tr>
		<td width="67">&nbsp;</td>
		<td width="220">&nbsp;</td>
		<td width="86">&nbsp;</td>
		<td width="189">&nbsp;</td>
	</tr>
	<?php
		$sql1 = "SELECT p.no_rm, k.no_billing, p.nama, p.alamat, p.rt,p.rw, k.unit_id, u.nama AS namaunit, k.tgl, k.kso_id, kso.nama AS STATUS, k.id,
p.id AS pasien_id, pl.no_lab
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_ms_unit u ON u.id = k.unit_id
INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
WHERE k.id = '".$idKunj."'";
		$rs1 = mysql_query($sql1);
		$rw1 = mysql_fetch_array($rs1);
		$ksoid=$rw1['kso_id'];
		//$nL = "SELECT no_lab FROM b_pelayanan WHERE pasien_id = '".$rw1['pasien_id']."' AND jenis_layanan = '".$idKasir."'";
		$nL = "SELECT no_lab FROM b_pelayanan WHERE id = '".$idPel."'";
		$rsL = mysql_query($nL);
		$rwL = mysql_fetch_array($rsL);
	?>
	<tr>
		<td colspan="3" style="border-bottom:1px solid;text-align:left;">
		<b><!--<?=$pemkabRS?><br>-->
			<?=$namaRS?><br>
			<?=$alamatRS." ".$kotaRS;?><br>
			Telepon <?=$tlpRS?></b>		</td>
		<td style="font-size:26px; font-weight:bold; border-bottom:1px solid; padding-right:30px;" valign="bottom" align="right">&nbsp;<?php if($idKasir=='57') echo $rwL['no_lab'];?></td>
	</tr>
    <tr>
    	<td colspan="4" align="center" style="font-weight:bold; font-size:14px">K U I T A N S I</td>
    </tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">NRM</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">:&nbsp;<?php echo $rw1['no_rm'];?></td>
		<td style="font-size:10px">No. Billing</td>
		<td style="font-size:10px;">:&nbsp;<?php echo $rw1['no_billing'];?></td>
	</tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">Nama</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">:&nbsp;<?php echo strtolower($rw1['nama']);?></td>
	    <td>&nbsp;</td>
	    </tr>
	<tr class="kwi">
		<td style="font-size:10px">Alamat</td>
		<td style="font-size:10px" colspan="3">:&nbsp;<?php echo strtolower($rw1['alamat']).' RT.'.$rw1['rt'].' RW.'.$rw1['rw'];?></td>
	</tr>
	<tr class="kwi">
		<td style="font-size:14px; font-weight: bold; font-family: verdana;">Kunjungan</td>
		<td style="font-size:14px; font-weight: bold; font-family: verdana;" colspan="2">:&nbsp;<?php echo $rw1['namaunit'];?></td>
		<td>&nbsp;</td>
	</tr>
    
	<tr class="kwi">
		<td style="border-bottom:1px solid;font-size:10px">Tgl</td>
		<td style="border-bottom:1px solid;font-size:10px">:&nbsp;<?php echo tglSQL($rw1['tgl']);?></td>
		<td style="border-bottom:1px solid;font-size:10px">Status Ps</td>
		<td style="border-bottom:1px solid;font-size:10px">:&nbsp;<?php echo strtolower($rw1['STATUS']);?></td>
	</tr>
	<tr class="kwi">
		<td colspan="4">
			<table width="580" border="0" cellpadding="0" cellspacing="0" style="font-size:10px" class="kwi">
				<tr>
					<td width="58" height="28" align="center" style="font-weight:bold;font-size:10px; border-bottom:1px solid">No</td>
					<td width="442" style="font-weight:bold;font-size:10px; border-bottom:1px solid">&nbsp;Uraian</td>
					<td width="58" align="center" style="font-weight:bold;font-size:10px; border-bottom:1px solid">Qty</td>
					<td width="242" style="font-weight:bold;font-size:10px; border-bottom:1px solid" align="center">Subtotal&nbsp;</td>
				</tr>
				<?php
				$i=0;
				if ($ksoid!=1){
					if ($idbayar!=""){
						$sql="SELECT * FROM (SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=0
						UNION
						SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN b_tindakan_kamar t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=1
						UNION
						SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN $dbapotek.a_penjualan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.NO_KUNJUNGAN=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=2) AS t1 ORDER BY id";
					}else{
						if($idPel!=''){
							$sql="SELECT p.id,mu.nama ,mu.id idUnit FROM b_pelayanan p			  
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
							WHERE p.id='$idPel'";
						}else{
							if($jeniskasir=='0'){
								$sql="SELECT * FROM (SELECT DISTINCT p.id,mu.nama,mu.id idUnit FROM b_pelayanan p			  
	INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
	WHERE p.kunjungan_id='$idKunj' AND t.lunas=0
	UNION
	SELECT DISTINCT p.id,mu.nama,mu.id idUnit FROM b_tindakan_kamar tk 
	INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id
	INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
	WHERE p.kunjungan_id='$idKunj' AND tk.lunas=0) AS t ORDER BY id";
							}else{			    
								$sql="SELECT p.id,mu.nama ,mu.id idUnit FROM b_pelayanan p			  
								INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
								WHERE mu.parent_id in ($jeniskasir) AND p.kunjungan_id='$idKunj'";			  
							}
						}
					}
				}else{
					if ($idbayar!=""){
						$sql="SELECT * FROM (SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=0
						UNION
						SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN b_tindakan_kamar t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=1
						UNION
						SELECT DISTINCT p.id,mu.id idUnit,mu.nama FROM b_bayar_tindakan bt 
						INNER JOIN $dbapotek.a_penjualan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.NO_KUNJUNGAN=p.id 
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE bt.bayar_id='$idbayar' AND bt.tipe=2) AS t1 ORDER BY id";
					}else{
						if($idPel!=''){
							$sql="SELECT distinct p.id,mu.nama ,mu.id idUnit FROM b_pelayanan p			  
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
							WHERE p.id='$idPel'";
						}else{
							if($jeniskasir=='0'){
								$sql="SELECT * FROM (SELECT DISTINCT p.id,mu.nama,mu.id idUnit FROM b_pelayanan p			  
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
WHERE p.kunjungan_id='$idKunj' AND t.lunas=0
UNION
SELECT DISTINCT p.id,mu.nama,mu.id idUnit FROM b_tindakan_kamar tk 
INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
WHERE p.kunjungan_id='$idKunj' AND tk.lunas=0 AND tk.aktif=1) AS t ORDER BY id";
							}else{
								$sql="SELECT distinct p.id,mu.nama ,mu.id idUnit FROM b_pelayanan p			  
								INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
								WHERE mu.parent_id in ($jeniskasir) AND p.kunjungan_id='$idKunj' AND t.lunas=0";			  
							}
						}
					}
				}
					//echo $sql."<br/>";
					$rs = mysql_query($sql);
					$sBayar=0;
					$sBiaya=0;
					$bKmr=0;
					while($row = mysql_fetch_array($rs)){
				?>
				<tr>
					<td align="left">&nbsp;</td>
                    <td colspan="3" style="font-size:10px" height="28" align="left">[ <?php echo $row['nama'];?> ]</td>
				</tr>
				<?php
			$sKmr="SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr, mKls.nama nmKls,DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in, 
IF(tk.status_out=0,(IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)))*(tk.beban_kso+tk.beban_pasien), 
(IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)))*(tk.beban_kso+tk.beban_pasien)) biaya,tk.bayar byrkmr, 
IF(tk.status_out=0,(IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)))*tk.beban_kso, 
(IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)))*tk.beban_kso) biaya_kso, 
IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)),
IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))) cHari 
FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id 
WHERE kunjungan_id='$idKunj' AND mk.unit_id='".$row['idUnit']."' AND tk.aktif=1";
			//echo $sKmr."<br/>";
			$qKmr=mysql_query($sKmr);
			while($rwKmr=mysql_fetch_array($qKmr)){
				$sBiaya+=$rwKmr['biaya'];
				$sBayar+=$rwKmr['byrkmr'];
				$jaminan+=$rwKmr['biaya_kso'];
			?>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="left" style="font-size:10px" height="28">Kamar :&nbsp;<?php echo strtolower($rwKmr['nmKmr']);?></td>
					<td align="center" style="font-size:10px"><?php echo $rwKmr['cHari'];?></td>
					<td align="right" style="font-size:10px;padding-right:20px"><?php echo number_format($rwKmr['biaya'],0,",",".");?>&nbsp;</td>
				</tr>
				
			<?php
			}
			//$dibayar=$sBayar;
			if ($ksoid!=1){
				if ($idbayar!=""){
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama,(t.biaya_kso+t.biaya_pasien)*t.qty biaya,t.biaya_kso*t.qty biaya_kso,t.bayar,t.qty cTind 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE b.id=$idbayar AND p.id='".$row['id']."' ORDER BY t.id";
				}else{
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama,
							(t.biaya_kso+t.biaya_pasien)*t.qty as biaya,t.biaya_kso*t.qty as biaya_kso,t.bayar,t.qty cTind
							FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
							WHERE t.pelayanan_id='".$row['id']."' AND t.lunas=0 ORDER BY t.id";
				}
			}else{
				if ($idbayar!=""){
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama,t.biaya*t.qty biaya,0 as biaya_kso,t.bayar,t.qty cTind 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE b.id=$idbayar AND p.id='".$row['id']."' ORDER BY t.id";
				}else{
					$sTind="SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama,
							t.biaya*t.qty as biaya,0 as biaya_kso,t.bayar,t.qty cTind
							FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
							WHERE t.pelayanan_id='".$row['id']."' AND t.lunas=0 ORDER BY t.id";
				}
			}
					//echo $sTind."<br>";
					$qTind=mysql_query($sTind);
					
					while($rwTind=mysql_fetch_array($qTind)){
						$i++;
				?>
				<tr>
					<td align="center" style="font-size:10px"><?php echo $i?></td>
					<td style="font-size:10px"><?php echo strtolower($rwTind['nama']);?></td>
					<td style="font-size:10px" align="center"><?php echo $rwTind['cTind'];?></td>
					<td style="font-size:10px;padding-right:20px" align="right"><?php echo number_format($rwTind['biaya'],0,",",".");?>&nbsp;</td>
				</tr>
				<?php 
						$sBiaya+=$rwTind['biaya'];
						$sBayar+=$rwTind['bayar'];
						$jaminan+=$rwTind['biaya_kso'];
					}
					//$dibayar+=$sBayar;
					
				/*$sNilai="SELECT (SELECT nilai FROM b_bayar b
				WHERE kunjungan_id=".$_REQUEST['idKunj']."
				ORDER BY id DESC LIMIT 1) nilai,
				(SELECT SUM(nilai) FROM b_bayar
				WHERE kunjungan_id=".$_REQUEST['idKunj']." AND tipe=0) bayar,
				(SELECT SUM(nilai) FROM b_bayar
				WHERE kunjungan_id=".$_REQUEST['idKunj']." AND tipe=1) jaminan";
				$qNilai=mysql_query($sNilai);
				$rwNilai=mysql_fetch_array($qNilai);*/
				?>
                
                <?php
				if ($idbayar != ""){
					$sObatDetil = "SELECT 
									IFNULL(SUM(IF(t2.CARA_BAYAR=2,t2.SUB_TOTAL,0)),0) AS dijamin, 
									IFNULL(SUM(t2.BAYAR_PASIEN),0) AS dibayar
									FROM
									(SELECT * FROM ".$dbapotek.".a_penjualan 
									WHERE NO_KUNJUNGAN = '".$row['id']."') AS t2 
									INNER JOIN ".$dbapotek.".a_penerimaan ap ON t2.PENERIMAAN_ID = ap.ID 
									INNER JOIN ".$dbapotek.".a_obat ao ON ap.OBAT_ID = ao.OBAT_ID
									INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id=t2.ID 
									WHERE bt.bayar_id=$idbayar";
					$qObatDetil =mysql_query($sObatDetil);
					$rwObatDetil = mysql_fetch_array($qObatDetil);		
					$jaminan += $rwObatDetil['dijamin'];
					$sBayar += $rwObatDetil['dibayar'];
					
					$sObat = "SELECT *,
								SUM((QTY_JUAL - QTY_RETUR) * HARGA_SATUAN) AS SUBTOTAL 
								FROM (
									SELECT 
									SUM(t2.QTY) QTY, 
									SUM(t2.QTY_JUAL) QTY_JUAL, 
									SUM(t2.QTY_RETUR) QTY_RETUR, 
									ao.OBAT_ID, 
									ao.OBAT_NAMA,
									DATE_FORMAT(t2.TGL,'%d-%m-%Y') AS TGL,
									t2.HARGA_SATUAN
									FROM (SELECT * FROM ".$dbapotek.".a_penjualan WHERE NO_KUNJUNGAN='".$row['id']."') AS t2 
									INNER JOIN ".$dbapotek.".a_penerimaan ap ON t2.PENERIMAAN_ID=ap.ID 
									INNER JOIN ".$dbapotek.".a_obat ao ON ap.OBAT_ID=ao.OBAT_ID
									INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id=t2.ID WHERE bt.bayar_id=$idbayar 
									GROUP BY ao.OBAT_ID) AS gab GROUP BY OBAT_ID";
				}else{
					$sObatDetil = "SELECT 
									IFNULL(SUM(IF(t2.CARA_BAYAR=2,t2.SUB_TOTAL,0)),0) AS dijamin, 
									IFNULL(SUM(t2.BAYAR_PASIEN),0) AS dibayar 
									FROM
									(SELECT * FROM ".$dbapotek.".a_penjualan WHERE NO_KUNJUNGAN = '".$row['id']."') AS t2 
									INNER JOIN ".$dbapotek.".a_penerimaan ap ON t2.PENERIMAAN_ID = ap.ID 
									INNER JOIN ".$dbapotek.".a_obat ao ON ap.OBAT_ID = ao.OBAT_ID";
					$qObatDetil = mysql_query($sObatDetil);
					$rwObatDetil = mysql_fetch_array($qObatDetil);		
					$jaminan += $rwObatDetil['dijamin'];
					$sBayar += $rwObatDetil['dibayar'];
					
					$sObat = "SELECT *,
								SUM((QTY_JUAL - QTY_RETUR) * HARGA_SATUAN) AS SUBTOTAL 
								FROM (
									SELECT SUM(t2.QTY) QTY, 
									SUM(t2.QTY_JUAL) QTY_JUAL, 
									SUM(t2.QTY_RETUR) QTY_RETUR, 
									ao.OBAT_ID, 
									ao.OBAT_NAMA,
									DATE_FORMAT(t2.TGL,'%d-%m-%Y') AS TGL,
									t2.HARGA_SATUAN
									FROM (SELECT * FROM ".$dbapotek.".a_penjualan WHERE NO_KUNJUNGAN='".$row['id']."') AS t2 
									INNER JOIN ".$dbapotek.".a_penerimaan ap ON t2.PENERIMAAN_ID=ap.ID 
									INNER JOIN ".$dbapotek.".a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
									GROUP BY ao.OBAT_ID) AS gab GROUP BY OBAT_ID";
				}
				//echo $sObat."<br>";
				$qObat = mysql_query($sObat);
				$jmlObat = mysql_num_rows($qObat);
				if($jmlObat>0){
			?>
			<tr>
				<td style="text-align:center; font-size:12px;"></td>
				<td style="font-size:12px; font-weight:bold;">Obat :</td>
				<td style="text-align:center; font-size:12px;"></td>
				<td style="text-align:right; font-size:12px; padding-right:20px;"></td>
			</tr>
			<? 
					while($rwObat=mysql_fetch_array($qObat)){
			?>
			<tr>
				<td style="text-align:center; font-size:12px;"></td>
				<td width="365" style="font-size:12px; padding-left:15px; white-space:warp;"><?=ucwords(strtolower($rwObat['OBAT_NAMA']))?></td>
				<td style="text-align:center; font-size:12px;"><?php if ($rwObat['QTY_RETUR']>0) echo $rwObat['QTY_JUAL'] - $rwObat['QTY_RETUR']; else echo $rwObat['QTY_JUAL'];?></td>
				<td style="text-align:right; font-size:12px; padding-right:20px;"><?=number_format($rwObat['SUBTOTAL'],0,",",".")?></td>
			</tr>
			<?
						$sBiaya+=$rwObat['SUBTOTAL'];
					}
				}
			}
		?>
				 <tr>
				 	<td style="border-top:2px groove;font-size:10px">&nbsp;</td>
					<td style="border-top:2px groove;font-size:10px" align="right">Total&nbsp;</td>
					<td style="border-top:2px groove;font-size:10px" align="right">&nbsp;</td>
					<td style="border-top:2px groove;font-size:10px;padding-right:20px" align="right"><b><?php echo number_format($sBiaya,0,",",".");?></b>&nbsp;</td>
				 </tr>
				 <!--tr>
				 	<td>&nbsp;</td>
					<td align="right">Sudah dibayar </td>
					<td align="right"><b><?php /*echo number_format($rwNilai['bayar']-$rwNilai['nilai'],2,",",".");*/?></b>&nbsp;</td>
				 </tr>
				 <tr>
				 	<td>&nbsp;</td>
					<td align="right">Jaminan </td>
					<td align="right"><b><?php //echo number_format($rwNilai['jaminan'],2,",",".");?></b>&nbsp;</td>
				 </tr-->
                 <?php 
					if ($jaminan>0){
				 ?>
				 <tr>
                   <td>&nbsp;</td>
				   <td align="right" style="font-size:10px">Dijamin KSO</td>
				   <td align="right" style="font-size:10px">&nbsp;</td>
				   <td align="right" style="font-size:10px;padding-right:20px"><b><?php echo number_format($jaminan,0,",",".");?></b>&nbsp;</td>
		      </tr>
              <?php 
			  		}
			  ?>
                 <?php if ($titipan>0){?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right" style="font-size:10px">Titipan</td>
				   <td align="right">&nbsp;</td>
				   <td align="right" style="font-size:10px;padding-right:20px"><b><?php echo number_format($titipan,0,",",".");?></b>&nbsp;</td>
		      </tr>
              <?php }?>
                 <?php if ($keringanan>0){?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right" style="font-size:10px">Keringanan</td>
				   <td align="right">&nbsp;</td>
				   <td align="right" style="font-size:10px;padding-right:20px"><b><?php echo number_format($keringanan,0,",",".");?></b>&nbsp;</td>
		      </tr>
              <?php }?>
				 <tr>
				 	<td>&nbsp;</td>
					<td align="right" style="font-size:10px">Dibayar </td>
					<td align="right">&nbsp;</td>
					<td align="right" style="font-size:10px;padding-right:20px"><b><?php echo number_format($dibayar,0,",",".");?></b>&nbsp;</td>
				 </tr>
				 <tr>
				 	<td>&nbsp;</td>
					<td align="right" style="font-size:10px">Kurang Bayar </td>
					<td align="right" style="font-size:10px">&nbsp;</td>
					<td align="right" style="font-size:10px;padding-right:20px"><b><?php echo number_format($sBiaya-($jaminan+$titipan+$keringanan+$dibayar),0,",",".");?></b>&nbsp;</td>
				 </tr>
				 <tr>
				 	<td colspan="4" style="font-weight:bold">&nbsp;Terbilang : <span style="font-style:italic"><?php echo terbilang($dibayar); ?> Rupiah</span></td>
				 </tr>
                 <tr>
				 	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				 </tr>
	  </table>		</td>
	</tr>
	<tr class="kwi">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="center" style="font-size:10px;padding-right:30px"><?=$kotaRS?>,&nbsp;&nbsp;<?php echo $tglBayar;?></td>
	</tr>
	<tr class="kwi">
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<?php
		/*$sqlKasir = "SELECT b_ms_group_petugas.id, b_ms_group_petugas.ms_group_id, b_ms_group_petugas.ms_pegawai_id,
					b_ms_pegawai.nama, b_kunjungan.pasien_id, b_kunjungan.id
					FROM b_ms_group_petugas 
					INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_ms_group_petugas.ms_pegawai_id
					INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id
					LEFT JOIN b_kunjungan ON b_kunjungan.unit_id = b_ms_pegawai_unit.unit_id
					WHERE (ms_group_id = 6 OR ms_group_id = 9 OR ms_group_id = 11
					OR ms_group_id = 19 OR ms_group_id = 31)
					AND b_kunjungan.id = '".$rw1['id']."'
					GROUP BY b_ms_pegawai.nama
					ORDER BY b_ms_pegawai.nama";
		$rsKasir = mysql_query($sqlKasir);
		$rwKasir = mysql_fetch_array($rsKasir);*/
	?>
	<tr class="kwi">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="center" style="font-size:10px;padding-right:20px">(<?php echo $kasir; ?>)</td>
	</tr>
	<tr class="kwi">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="center" style="font-size:10px;padding-right:70px">Kasir</td>
	</tr>
	<!--tr class="kwi">
		<td>&nbsp;<?php //echo $jam;?></td>
		<td colspan="3" align="right">&nbsp;Operator&nbsp;&nbsp;&nbsp;<?php //echo $rwPeg['nama'];?></td>
	</tr-->
	<tr class="kwi" style="display:none">
		<td colspan="4" style="font-weight:bold;font-size:10px" align="center">"Bukti pembayaran ini juga berlaku sebagai kuitansi"</td>
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
		try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}
		
	}
    }
</script>
<?php 
mysql_close($konek);
?>
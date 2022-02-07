<?php 
	include("../../koneksi/konek.php");
	include("../../sesi.php");
	//==========Menangkap filter data====
	$stsPas = $_REQUEST['StatusPas0'];
	//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
	$jnsLay = $_REQUEST['JnsLayananDenganInap'];
	$tmpLay = $_REQUEST['TmpLayananInapSaja'];
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	//$stsPas,$jnsLay,$tmpLay,$waktu,$tglAwal,$tglAhkir,$bln,$thn
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
	$rsPenjamin = mysql_query($sqlPenjamin);
	$hsPenjamin = mysql_fetch_array($rsPenjamin);
	
	$sqlTmp = "SELECT nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
	$rsTmp = mysql_query($sqlTmp);
	$rwTmp = mysql_fetch_array($rsTmp);
	
	$sqlJns = "SELECT nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
	$rsJns = mysql_query($sqlJns);
	$rwJns = mysql_fetch_array($rsJns);
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="../../theme/tab-view.css" />
	<script type="text/javascript" src="../../theme/js/tab-view.js"></script>
	<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
	<script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
	<!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
	<script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
	<script language="JavaScript" src="../../theme/js/mm_menu.js"></script>
	<script language="JavaScript" src="../../theme/js/dropdown.js"></script>

	<!--dibawah ini diperlukan untuk menampilkan popup-->
	<link rel="stylesheet" type="text/css" href="../../theme/popup.css" />
	<script type="text/javascript" src="../../theme/prototype.js"></script>
	<script type="text/javascript" src="../../theme/effects.js"></script>
	<script type="text/javascript" src="../../theme/popup.js"></script>
	<!--diatas ini diperlukan untuk menampilkan popup-->

<title>Rekap Tagihan</title>
<style>
   .withline{
   border:1px solid #000000;
   }
   .isi{
   font-family:Arial, Helvetica, sans-serif; font-size:9px;}
   .jdl
   { 	border-top:1px solid #000000;
   		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
		text-align:center;
		font-weight:bold;
		text-transform:uppercase;
	}
	.right
	{ 	
		border-right:1px solid #000000;
		text-align:center;
		font-weight:bold;
		text-transform:uppercase;
		
	}
	.tbl
	{
		border-left:1px solid;
		border-bottom:1px solid;
	}
</style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" class="tabel" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" width="2300">
  <tr>
    <td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" height="70" style="font-weight:bold; font-size:14px; text-transform:uppercase">rekapitulasi pengajuan klaim pasien <?php if($stsPas==0) echo "SEMUA"; else echo $hsPenjamin['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
      <td style="font-weight:bold;" height="30">Jenis Layanan : <?php echo $rwJns['nama'];?><br />Tempat Layanan : <?php if($tmpLay==0) echo "SEMUA"; else echo $rwTmp['nama'];?></td>
   </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
			<tr valign="top">
				<td width="1%" class="jdl">No</td>
				<td width="3%" class="jdl">No MR</td>
				<td width="8%" class="jdl">Nama Penderita<br />No Peserta<br />Nama Peserta<br></td>
				<td width="8%" class="jdl">Nama Perusahaan</td>
				<td width="80%" class="jdl">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="text-align:center; font-weight:bold;">
							<td width="8%" class="right">Diagnosa</td>
							<td width="4%" class="right">MRS</td>
							<td width="4%" class="right">KRS</td>
							<td width="2%" class="right">Hari<br />RWT</td>
							<td width="4%" class="right">Ruang<br />Rawat</td>
							<td width="4%" class="right">Kelas</td>
							<td width="4%" class="right">Kamar</td>
							<td width="4%" class="right">Makan</td>
							<td width="4%" class="right">Tindakan Non Operatif</td>
							<td width="4%" class="right">Jasa Visite</td>
							<td width="3%" class="right">Konsul Gizi</td>
							<td width="4%" class="right">Tindakan Operatif</td>
							<td width="4%" class="right">PK</td>
							<td width="4%" class="right">PA</td>
							<td width="3%" class="right">Rad</td>
							<td width="3%" class="right">HD</td>
							<td width="3%" class="right">Ends</td>
							<td width="4%" class="right">Jumlah Tindakan</td>
							<td width="3%" class="right">Obat</td>
							<td width="4%" class="right">Jumlah Tindakan<br />+ Obat</td>
							<td width="3%" class="right">PMI</td>
							<td width="4%" class="right">Jumlah</td>
							<td width="4%" class="right">Bayar Tunai</td>
							<td width="4%" class="right">Total<br />Biaya Px</td>
							<td width="4%" class="right">Status<br />Verifikasi</td>
						    <td width="4%" class="right">Penjamin<br />Px</td>
						</tr>
				  </table>
			  </td>
			</tr>
			<form>
			<?php
				 $igd = $kamar = $makan = $tindakanNO = $visite = $gizi = $tindakanO = $lab = $rad = $pa = $jmlTindakan = $obat
					= $jumlahTindakanObat = $pmi = $jumlahBayar = $totalBiaya = 0; 
                    if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'"; else $fKso = "";
                    //if($tmpLay==0){ 
						$tmb = "INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id";
						/*$fUnit = "b_pelayanan.jenis_layanan = '".$jnsLay."' AND b_ms_unit.inap='1'";*/
						$fUnit = "b_pelayanan.jenis_kunjungan = '3' AND b_ms_unit.inap='1'";
                    //}else{ $fUnit = "b_pelayanan.unit_id = '".$tmpLay."'";}
					
					/*$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id,
                    	b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_ms_pasien.id,
						IF(b_ms_kso_pasien.no_anggota='','-',b_ms_kso_pasien.no_anggota) AS no_anggota, 
						IF(b_ms_kso_pasien.nama_peserta='','-',b_ms_kso_pasien.nama_peserta) AS nama_peserta, 
						IF(b_ms_kso_pasien.instansi_id=0,'-', b_ms_instansi.nama) AS instansi, b_ms_kso_pasien.instansi_id AS inst_id
                    	FROM b_ms_pasien
                    	INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
                    	INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
                    	INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
						LEFT JOIN b_ms_kso_pasien ON b_ms_kso_pasien.pasien_id=b_ms_pasien.id
  						LEFT JOIN b_ms_instansi ON b_ms_instansi.id=b_ms_kso_pasien.instansi_id
                    	WHERE $fUnit $waktu $fKso AND b_ms_kso.id <> 1 GROUP BY b_pelayanan.id ORDER BY b_tindakan_kamar.tgl_out";*/
					/*$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id,
                    	b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_ms_pasien.id,
						IF(b_ms_kso_pasien.no_anggota='','-',b_ms_kso_pasien.no_anggota) AS no_anggota, 
						IF(b_ms_kso_pasien.nama_peserta='','-',b_ms_kso_pasien.nama_peserta) AS nama_peserta, 
						IF(b_ms_kso_pasien.instansi_id=0,'-', b_ms_instansi.nama) AS instansi, b_ms_kso_pasien.instansi_id AS inst_id
                    	FROM b_ms_pasien
                    	INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
                    	INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
                    	INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
						LEFT JOIN b_ms_kso_pasien ON b_ms_kso_pasien.pasien_id=b_ms_pasien.id
  						LEFT JOIN b_ms_instansi ON b_ms_instansi.id=b_ms_kso_pasien.instansi_id
                    	WHERE $fUnit $waktu $fKso AND b_ms_kso.id <> 1 GROUP BY b_kunjungan.id ORDER BY b_tindakan_kamar.tgl_out";*/
					$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id, b_pelayanan.kso_id AS kso_id,
                    	b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_ms_pasien.id,
						IF(b_ms_kso_pasien.no_anggota='','-',b_ms_kso_pasien.no_anggota) AS no_anggota, 
						IF(b_ms_kso_pasien.nama_peserta='','-',b_ms_kso_pasien.nama_peserta) AS nama_peserta, 
						IF(b_ms_kso_pasien.instansi_id=0,'-', b_ms_instansi.nama) AS instansi, b_ms_kso_pasien.instansi_id AS inst_id
                    	FROM b_ms_pasien
                    	INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
                    	INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
                    	INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
						LEFT JOIN b_ms_kso_pasien ON b_ms_kso_pasien.pasien_id=b_ms_pasien.id
  						LEFT JOIN b_ms_instansi ON b_ms_instansi.id=b_ms_kso_pasien.instansi_id
                    	WHERE $fUnit $waktu $fKso GROUP BY b_kunjungan.id ORDER BY b_ms_pasien.nama";
					//echo $qry."<br>";
                    $rs = mysql_query($qry);
					$i=0;
					$j=0;
                    while($rw = mysql_fetch_array($rs)){					
                    $i++;
					$tglKunj = $rw["tglKunj"];
			?>
			<tr valign="top">
				<td width="1%" style="text-align:center;" class="tbl"><?php echo $i;?></td>
				<td width="3%" class="tbl" style="text-align:center;"><?php echo $rw['no_rm'];?></td>
				<td width="8%" class="tbl" style="padding-left:5px; text-transform:uppercase"><?php echo $rw['pasien'];?><br>
				<span id="txtNoP<?php echo $i;?>"><?php echo $rw['no_anggota'];?></span><br />
				<span id="NamaP<?php echo $i;?>"><?php echo $rw['nama_peserta'];?></span></td>
				<td width="8%" class="tbl" style="padding-left:5px; text-transform:uppercase;"><span id="txtPerusahaan<?php echo $i;?>" onclick="popUpKantor('<?php echo $rw['no_rm']."||".$rw['pasien']."||".$rw['no_anggota']."||".$rw['nama_peserta']."||".$rw['inst_id']."||".$rw['id']."||".$i;?>')" style="cursor:pointer;"><?php echo $rw['instansi'];?></span></td>
				<td width="80%" class="tbl"> 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td colspan="8">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
								<?php
									$qLop = "SELECT DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS masuk,
									DATE_FORMAT(b_pelayanan.tgl_krs,'%d-%m-%Y') AS keluar, SUM(IF(b_tindakan_kamar.status_out=0, 
	IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
	DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
	IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
	DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS jHr, b_ms_kso.nama AS penjamin, 
									b_ms_unit.nama AS kamar, b_ms_kelas.nama AS kelas, b_pelayanan.unit_id, b_pelayanan.id AS pelayanan_id FROM b_pelayanan
									INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id OR (b_pelayanan.unit_id=47 OR b_pelayanan.unit_id=63)
									INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
									INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
									WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_ms_unit.inap='1' GROUP BY b_pelayanan.id";
									$rsLop = mysql_query($qLop);
									$jmlKmr = 0; $jmlMkn=0;
									while($rwLop = mysql_fetch_array($rsLop))
									{							 
										 $qKamar = "SELECT SUM(cH.hari*cH.beban_kso) AS jml,SUM(cH.hari*cH.beban_pasien) AS jml_umum FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
													IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
													IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.beban_kso,b_tindakan_kamar.beban_pasien
													FROM b_pelayanan 
													INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
													WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
										 $rsKamar = mysql_query($qKamar);
										 $rwKamar = mysql_fetch_array($rsKamar);
										 
										 $qMakan = "SELECT SUM(b_tindakan.qty*b_tindakan.biaya_kso) AS jml,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS jml_umum 
													 FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id 
													 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
													 INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id 
													 WHERE b_pelayanan.id='".$rwLop['pelayanan_id']."' 
													 AND b_ms_tindakan.id IN (742,746,747,748,749)";
										 $rsMakan = mysql_query($qMakan);
										 $rwMakan = mysql_fetch_array($rsMakan);
										 
										if ($rw['kso_id']=="1"){
											$bkamar = $rwKamar['jml_umum'];
											$bmakan = $rwMakan['jml_umum'];
										}else{
											$bkamar = $rwKamar['jml'];
											$bmakan = $rwMakan['jml'];
										}
										
										$jmlKmr = $jmlKmr + $bkamar;
										$jmlMkn = $jmlMkn + $bmakan;
							 	?>
									<tr>
										<td width="24%" style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:left; font-size:9px; padding-left:5px;"><input id="pelId" name="pelId" value="<?php echo $rwLop['pelayanan_id'];?>" type="hidden" />
										<span id="txtDiagnosa<?php echo $rwLop['pelayanan_id'];?>" style="cursor:pointer" onclick="popUpDiag('<?php echo $rwLop['pelayanan_id']."||".$rw['kunjungan_id']."||".$rw['id']."||".$rwLop['pelayanan_id'];?>')">&nbsp;
										<?php								
											$qDiag = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_diagnosa_rm
											INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
											WHERE b_diagnosa_rm.pelayanan_id = '".$rwLop['pelayanan_id']."'";
											$rsDiag = mysql_query($qDiag);
											while($rwDiag = mysql_fetch_array($rsDiag))
											{
												echo $rwDiag['nama'].',';
											}	
										?>				
										</span></td>
										<td width="12%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['masuk']?></td>
										<td width="12%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['keluar']?></td>
										<td width="5%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['jHr']?></td>
										<td width="12%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['kamar']?><input id="txtUnitId" name="txtUnitId" type="hidden" value="<?php echo $rwLop['unit_id'];?>" /></td>
										<td width="12%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['kelas']?></td>
										<td width="12%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bkamar,0,",",".");?></td>
										<td width="11%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bmakan,0,",","."); ?></td>
									</tr>
				  					<?php 	
											$j++;
											/*if ($rw['kso_id']=="1"){
												$jmlKmr = $jmlKmr + $rwKamar['jml_umum'];
												$jmlMkn = $jmlMkn + $rwMakan['jml_umum'];
											}else{
												$jmlKmr = $jmlKmr + $rwKamar['jml'];
												$jmlMkn = $jmlMkn + $rwMakan['jml'];
											}*/
									}	?>
								</table>
							</td>
							<?php
								 $qTin = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
										 b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_kso AS total,b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum, 
										 b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
										 INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
										 INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
										 WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND b_ms_unit.inap='1'
										 AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
										 AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
								 //echo $qTin."<br>";
								 $rsTin = mysql_query($qTin);
								 $rwTin = mysql_fetch_array($rsTin);
										 
								 $qVisite = "SELECT SUM(t.biaya) AS jml,SUM(t.biaya_umum) AS jml_umum FROM (SELECT SUM(b_tindakan.qty*b_tindakan.biaya_kso) AS biaya,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS biaya_umum 
											 FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
											 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
											 INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
											 WHERE (b_ms_tindakan.klasifikasi_id = '13' OR b_ms_tindakan.klasifikasi_id = '14' AND b_ms_tindakan.id<>'2378') 
											 AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3 GROUP BY b_tindakan.id) AS t";
								 //echo $qVisite."<br>";
								 $rsVisite = mysql_query($qVisite);
								 $rwVisite = mysql_fetch_array($rsVisite);
										 
								 $qGizi = "SELECT SUM(t.biaya) AS jml,SUM(t.biaya_umum) AS jml_umum FROM (SELECT SUM(b_tindakan.qty*b_tindakan.biaya_kso) AS biaya,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS biaya_umum FROM b_pelayanan 
											INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
											INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
											INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
											WHERE (b_ms_tindakan.id = '2387' OR b_ms_tindakan.id='2378') 
											AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3) as t";
								 //echo $qGizi."<br>";
								 $rsGizi = mysql_query($qGizi);
								 $rwGizi = mysql_fetch_array($rsGizi);
										 
								 $qOp = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty,
										b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum FROM b_pelayanan
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'
										AND b_pelayanan.jenis_kunjungan=3 AND b_pelayanan.unit_id IN (47,63)) AS t";
								 $rsOp = mysql_query($qOp);
								 $rwOp = mysql_fetch_array($rsOp);
										 
								 $qPk = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='58') AS t";
								 $rsPk = mysql_query($qPk);
								 $rwPk = mysql_fetch_array($rsPk);
										 
								 $qRad = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='61') AS t";
								 $rsRad = mysql_query($qRad);
								 $rwRad = mysql_fetch_array($rsRad);
										 
								$qPa = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='59') AS t";
								 $rsPa = mysql_query($qPa);
								 $rwPa = mysql_fetch_array($rsPa);
										 
								 $qHd = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='65') AS t";
								 $rsHd = mysql_query($qHd);
								 $rwHd = mysql_fetch_array($rsHd);
										 
								 $qEnd = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='67') AS t";
								 $rsEnd = mysql_query($qEnd);
								 $rwEnd = mysql_fetch_array($rsEnd);
								if ($rw['kso_id']=="1"){
									$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml
										FROM (SELECT $dbbilling.b_pelayanan.id FROM $dbbilling.b_pelayanan
										INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
										WHERE $dbbilling.b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND $dbbilling.b_pelayanan.jenis_kunjungan = '3') AS t2
										INNER JOIN $dbapotek.a_penjualan ap ON t2.id = ap.NO_KUNJUNGAN
										WHERE ap.NO_PASIEN = '".$rw['no_rm']."'";
								}else{
									$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml
										FROM (SELECT $dbbilling.b_pelayanan.id FROM $dbbilling.b_pelayanan
										INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
										WHERE $dbbilling.b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND $dbbilling.b_pelayanan.jenis_kunjungan = '3') AS t2
										INNER JOIN $dbapotek.a_penjualan ap ON t2.id = ap.NO_KUNJUNGAN
										WHERE ap.NO_PASIEN = '".$rw['no_rm']."' AND ap.CARA_BAYAR=2";
								}
										//echo $qObat."<br>";
								$rsObat = mysql_query($qObat);
								$rwObat = mysql_fetch_array($rsObat);
								$bObat = $rwObat['jml'];
								
								if ($rw['kso_id']=="1"){
									$bOp= $rwOp['jml_umum'];
									$bVisite= $rwVisite['jml_umum'];
									$bGizi= $rwGizi['jml_umum'];
									$bPk= $rwPk['jml_umum'];
									$bRad= $rwRad['jml_umum'];
									$bHd= $rwHd['jml_umum'];
									$bEnd= $rwEnd['jml_umum'];
									$bPa= $rwPa['jml_umum'];
									$bTin= $rwTin['jml_umum'];
								}else{
									$bOp= $rwOp['jml'];
									$bVisite= $rwVisite['jml'];
									$bGizi= $rwGizi['jml'];
									$bPk= $rwPk['jml'];
									$bRad= $rwRad['jml'];
									$bHd= $rwHd['jml'];
									$bEnd= $rwEnd['jml'];
									$bPa= $rwPa['jml'];
									$bTin= $rwTin['jml'];
								}
								
								$jmlTin = $bOp + $jmlMkn + $jmlKmr + $bVisite +
										$bGizi + $bPk + $bRad +
										$bHd + $bEnd + $bPa + $bTin;
											
								$jmlTind = $jmlTin;
										
								$qByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
										FROM b_pelayanan 
										INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
										INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id
										INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
										WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3'
										GROUP BY b_bayar_tindakan.id 
										ORDER BY b_bayar_tindakan.id) AS t";
								$rsByr = mysql_query($qByr);
								$rwByr = mysql_fetch_array($rsByr);
								
								/*$qKamarByr = "SELECT SUM(cH.hari*cH.bayar_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
											IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
											DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
											IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
											DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.bayar_pasien
											FROM b_pelayanan 
											INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
											WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";*/
								
								$qKamarByr = "SELECT SUM(cH.bayar_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
											IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
											DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
											IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
											DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.bayar_pasien
											FROM b_pelayanan 
											INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
											WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
								$rsKamarByr = mysql_query($qKamarByr);
								$rwKamarByr = mysql_fetch_array($rsKamarByr);
								$Bayar = $rwByr['jml'] + $rwKamarByr['jml'];
								// $igd += $rwIgd['jml'];
								//if ($rw['kso_id']=="1"){
									$makan += $jmlMkn;
									$kamar += $jmlKmr;
									$tindakanNO += $bTin;
									$visite += $bVisite;
									$gizi += $bGizi;
									$tindakanO += $bOp;
									$tin += $bTin;
									$lab += $bPk;
									$rad += $bRad;
									$hd += $bHd;
									$end += $bEnd;
									$pa += $bPa;
									$jmlTindakan += $jmlTind;
									$obat += $bObat;
									$jumlahTindakanObat += $jmlTind+$bObat;
									$jumlahTindakanPmi += $jmlTind+$bObat;
									$jumlahBayar += $Bayar;
									$totalBiaya += $jmlTind+$Bayar+$bObat;
								/*}else{
									$makan += $jmlMkn;
									$kamar += $jmlKmr;
									$tindakanNO += $rwTin['jml'];
									$visite += $rwVisite['jml'];
									$gizi += $rwGizi['jml'];
									$tindakanO += $rwOp['jml'];
									$tin += $rwTin['jml'];
									$lab += $rwPk['jml'];
									$rad += $rwRad['jml'];
									$hd += $rwHd['jml'];
									$end += $rwEnd['jml'];
									$pa += $rwPa['jml'];
									$jmlTindakan += $jmlTind;
									$obat += $bObat;
									$jumlahTindakanObat += $jmlTind+$rwObat['jml'];
									$jumlahTindakanPmi += $jmlTind+$rwObat['jml'];
									$jumlahBayar += $Bayar;
									$totalBiaya += $jmlTind+$Bayar+$rwObat['jml'];
								}*/
								
								/*$sqlver = "SELECT p.id FROM b_pelayanan p
											LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
											LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
											WHERE (p.verifikasi = 0 OR t.verifikasi = 0 OR tk.verifikasi = 0) AND p.id = '".$rw['pelayanan_id']."'";*/
								
								$sqlver = "SELECT p.id FROM b_pelayanan p
											LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
											LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
											WHERE (p.verifikasi = 0 OR t.verifikasi = 0 OR tk.verifikasi = 0) AND p.kunjungan_id = '".$rw['kunjungan_id']."'";
								$rsver = mysql_query($sqlver);
								if(mysql_num_rows($rsver) > 0){
									$verifikasi = 0;
								}else{
									$verifikasi = 1;
								}
								?>			
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63') echo "-"; else echo number_format($bTin,0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bVisite,0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bGizi,0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php if($bOp!="") echo number_format($rwOp['jml'],0,",","."); else echo "-";?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bPk,0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bPa,0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bRad,0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bHd,0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($bEnd,0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($jmlTind,0,",","."); ?>
								<input type="text" id="jml_tind" value="<?php echo $jmlTind;?>" style="display:none" /></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php if($bObat=="") echo "0"; else echo number_format($bObat,0,",",".");?></td>
							<?php $jumlahTindakan = $jmlTind+$bObat;?>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="jml_to" class="isi" value="<?php echo $jumlahTindakan;?>" readonly style="text-align:right" /></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="4" id="pmi" onkeyup="summary(this,<?php echo $j;?>)" class="isi" style="text-align:right" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="jml" class="isi" value="<?php echo $jumlahTindakan;?>" readonly style="text-align:right" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="bayar" class="isi" readonly style="text-align:right" value="<?php echo $Bayar;?>" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="total" class="isi" value="<?php echo $jumlahTindakan+$Bayar;?>" readonly style="text-align:right" /></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;color:<?php echo ($verifikasi==0 || $verifikasi=='')?'#990000':'#000099';?>"><?php echo ($verifikasi==0 || $verifikasi=='')?'belum':'sudah';?></td>
						    <td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;"><?php echo $rwLop['penjamin'];?></td>
						</tr>
				  </table>
			  </td>
			</tr>
			<?php
					
					}
			?>
			</form>
			<tr valign="top">
				<td width="1%" style="text-align:center;" class="tbl">&nbsp;</td>
				<td width="3%" class="tbl" style="text-align:center;">&nbsp;</td>
				<td width="8%" class="tbl" style="padding-left:5px; text-transform:uppercase">&nbsp;</td>
				<td width="8%" class="tbl" style="padding-left:5px;">&nbsp;</td>
				<td width="80%" class="tbl">		 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td height="25" style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:left; text-align:center; font-weight:bold;">TOTAL</td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_kamar" style="text-align:right"><?php echo number_format($kamar,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_makan" style="text-align:right"><?php echo number_format($makan,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_nonOperatif" style="text-align:right"><?php echo number_format($tindakanNO,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_visite" style="text-align:right"><?php echo number_format($visite,0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_gizi" style="text-align:right"><?php echo number_format($gizi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_operatif" style="text-align:right"><?php echo number_format($tindakanO,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_lab" style="text-align:right"><?php echo number_format($lab,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_pa" style="text-align:right"><?php echo number_format($pa,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($rad,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($hd,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($end,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_jumlahTindakan" style="text-align:right"><?php echo number_format($jmlTindakan,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_obat" style="text-align:right"><?php echo number_format($obat,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_tindakanObat" style="text-align:right"><?php echo number_format($jumlahTindakanObat,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_pmi" style="text-align:right"><?php echo number_format($pmi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_jumlahPmi" style="text-align:right"><?php echo number_format($jumlahTindakanPmi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_bayar" style="text-align:right"><?php echo number_format($jumlahBayar,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_totalBiaya" style="text-align:right"><?php echo number_format($totalBiaya,0,",",".");?></span></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
						    <td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
						</tr>
				  </table>
			  </td>
			</tr>
	  </table>	
	</td>
  </tr><tr id="trTombol">
        <td class="noline" align="center" height="30">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" width="10%">&nbsp;</td>
				<td width="50%" height="150" valign="bottom"></td>
				<td align="center" valign="top" width="40%"><?=$kotaRS?>,&nbsp;<?php echo $date_now;?>&nbsp;<br /><br/>Pengaju Klaim<br/>Kasubbag Pendapatan</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center"><u><?php 
				$qVal=mysql_query("SELECT nama,nip from validasi where id=2");
				$hsVal1=mysql_fetch_array($qVal);
				echo $hsVal1['nama'];
				?></u>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td></td>
				<td align="center">NIP: <?php echo $hsVal1['nip']?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<div id="divKantor" class="popup" style="width:550px;display:none;">
	<img alt="close" src="../../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer"/>            
	<fieldset><legend>Edit Data Pasien</legend>
        <input type="hidden" value="edit" id="act" name="act" />
        <div id="tmpUpdate" style="display: none;"></div>
		<input type="hidden" id="StatusPas0" name="StatusPas0" />
		<input type="hidden" id="JnsLayananDenganInap" name="JnsLayananDenganInap" />
		<input type="hidden" id="TmpLayananInapSaja" name="TmpLayananInapSaja" />
		<input type="hidden" id="tglAwal" name="tglAwal" />
		<input type="hidden" id="tglAkhir" name="tglAkhir" />
		<input type="hidden" id="pasienId" name="pasienId" />
		<table width="500" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">
			<tr height="28">
				<td width="30%">No.RM</td>
				<td width="10%" align="center">:</td>
				<td width="60%"><input id="norm" name="norm" style="border:0;" value=""/></td>
			</tr>
			<tr height="28">
				<td>Nama Pasien</td>
				<td align="center">:</td>
				<td><input id="namapasien" name="namapasien" style="border:0;" /></td>
			</tr>
			<tr height="28">
				<td>Nama Perusahaan</td>
				<td align="center">:</td>
				<td><select id="namaperusahaan" name="namaperusahaan" class="txtinputreg">
					<option value="0"> - </option>
					<?php
							$qIns = "SELECT id, nama FROM b_ms_instansi";
							$sIns = mysql_query($qIns);
							while($wIns = mysql_fetch_array($sIns)){
					?>
					<option value="<?php echo $wIns['id'];?>"><?php echo $wIns['nama'];?></option>
					<?php
							}
					?>
				</select>&nbsp;<img src="../../icon/add.gif" width="24" height="24" title="Klik Untuk Menambah Instansi" style="cursor:pointer;" onclick="openIsi()" /></td>
			</tr>
			<tr height="28">
				<td>Nama Peserta</td>
				<td align="center">:</td>
				<td><input id="namapeserta" name="namapeserta" size="40" /></td>
			</tr>
			<tr height="28">
				<td>No Peserta</td>
				<td align="center">:</td>
				<td><input id="nopeserta" name="nopeserta" size="30" /></td>
			</tr>
			<tr>
				<td colspan="3" align="center" height="30"><button  onclick="upKantor()"><img src="../../icon/bottom.GIF" width="16" height="16" />&nbsp;Update</button>&nbsp;&nbsp;&nbsp;<button onclick="batal()"><img src="../../icon/back.png" width="16" height="16" />&nbsp;Batal</button></td>
			</tr>
		</table>
	</fieldset>
</div>
<div id="divInst" class="popup" style="width:925px; display:none;">
	<img alt="close" src="../../icon/x.png" width="32" class="popup_closebox" onclick="batalInst()" style="float:right; cursor: pointer"/>         
	<fieldset>
		<legend>Data Instansi</legend>
		<table width="875" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td>
					<table width="500" align="center" border="0" cellpadding="0" cellspacing="4" class="tabel">
						<tr>
							<td width="30%">Kode</td>
							<td align="center" width="5%">:</td>
							<td width="65%"><input id="instansiId" name="instansiId" type="hidden" value="<?php echo $instansiId;?>" /><input type="hidden" id="txtId" name="txtId" /><input id="txtKode" name="txtKode" size="16" class="txtinputreg"  /></td>
						</tr>
						<tr>
							<td>Nama Instansi</td>
							<td align="center">:</td>
							<td><input id="txtNama" name="txtNama" size="50" class="txtinputreg" /></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td align="center">:</td>
							<td><input id="txtAlamat" name="txtAlamat" size="50" style="height:50;" class="txtinputreg"></td>
						</tr>
						<tr>
							<td>Kota</td>
							<td align="center">:</td>
							<td><input id="txtKota" name="txtKota" size="50" class="txtinputreg"></td>
						</tr>
						<tr>
							<td>No Telepon</td>
							<td align="center">:</td>
							<td><input id="txtTlp" name="txtTlp" size="24" class="txtinputreg" /></td>
						</tr>
						<tr>
							<td>Status</td>
							<td align="center">:</td>
							<td><input id="rd1" name="rd" type="radio" value="1">&nbsp;Aktif&nbsp;&nbsp;&nbsp;<input id="rd0" name="rd" type="radio" value="0" checked="checked">&nbsp;Tidak</td>
						</tr>
						<tr>
							<td colspan="3" height="30" align="center">
								<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpanLg(this.value);" class="tblTambah"/>
								<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapusLg(this.title);" disabled="disabled" class="tblHapus"/>
								<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batalLg()" class="tblBatal"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<div id="gridbox" style="width:850px; height:200px; background-color:white;"></div><br />
					<div id="paging" style="width:850px;"></div>
				</td>
			</tr>
		</table>
	</fieldset>
</div>
<div id="divDiag" class="popup" style="width:925px;display:none;">
	<img alt="close" src="../../icon/x.png" width="32" class="popup_closebox" onclick="upDiag()" style="float:right; cursor: pointer"/>            
	<fieldset><legend>Edit Diagnosa Pasien</legend>
        <input type="hidden" value="diag" id="act" name="act" />
        <div id="tmpUpdateD" style="display: none;"></div>
		<input type="hidden" id="txtPel" name="txtPel" />
		<input type="hidden" id="txtKunj" name="txtKunj" />
		<input type="hidden" id="pasienIdD" name="pasienIdD" />
		<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="5%">&nbsp;</td>
				<td width="10%">&nbsp;</td>
				<td width="40%">&nbsp;</td>
				<td width="30%">&nbsp;</td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Diagnosa :&nbsp;</td>
				<td colspan="2">
				<input name="diagnosa_id" id="diagnosa_id" type="hidden">
				<input id="txtDiag" name="txtDiag" size="100" onKeyUp="suggest(event,this);" autocomplete="off" class="txtinput">
				<input type="button" value="cari" onclick="suggest('cariDiag',this)" class="txtinput" />
				<div id="divdiagnosa" align="left" style="position:absolute; z-index:1; height: 230px; width:400px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>		</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Prioritas :&nbsp;</td>
				<td><label><input type="checkbox" id="chkUtama" name="chkUtama" checked="checked"/> Utama</label></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">Dokter :&nbsp;</td>
				<td>
					<select id="cmbDokDiag" name="cmbDokDiag" class="txtinput" onkeypress="setDok('btnSimpanDiag',event);">
				<option value="">-Dokter-</option>
				</select>
				<label><input type="checkbox" id="chkDokterPenggantiDiag" value="1" onchange="gantiDokter('cmbDokDiag',this.checked);"/>Dokter Pengganti</label>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>	
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center" height="28">
					<input type="hidden" id="id_diag" name="id_diag" />
					<input type="button" id="btnSimpanDiag" name="btnSimpanDiag" value="Tambah" onclick="simpan(this.value,this.id,'txtDiag');" class="tblTambah"/>
					<input type="button" id="btnHapusDiag" name="btnHapusDiag" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
					<input type="button" id="btnBatalDiag" name="btnBatalDiag" value="Batal" onclick="batalD(this.id)" class="tblBatal"/></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3">
					<div id="gridbox1" style="width:850px; height:200px; background-color:white; overflow:hidden;"></div>
					<div id="paging1" style="width:850px;"></div>		</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</fieldset>
</div>
</body>
<?php
      mysql_free_result($rsPenjamin);
      mysql_free_result($rsTmp);
      mysql_close($konek);
?>
<script type="text/JavaScript">
function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	if(document.getElementById(targetId)==undefined){
		alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
	}else{
		Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
}
var par;
function popUpKantor(p){
   par=p.split("||");
    //alert(par);//$stsPas,$jnsLay,$tmpLay,$waktu,$tglAwal,$tglAhkir,$bln,$thn
    document.getElementById("norm").value=par[0];
	document.getElementById("namapasien").value=par[1];
	document.getElementById("namaperusahaan").value=par[4];
	document.getElementById("namapeserta").value=par[3];
	document.getElementById("nopeserta").value=par[2];
	document.getElementById("StatusPas0").value=<?php echo $stsPas ?>;
	document.getElementById("JnsLayananDenganInap").value=<?php echo $jnsLay ?>;
	document.getElementById("TmpLayananInapSaja").value=<?php echo $tmpLay ?>;
	document.getElementById("tglAwal").value='<?php echo $_REQUEST['tglAwal'] ?>';
	document.getElementById("tglAkhir").value='<?php echo $_REQUEST['tglAkhir'] ?>';
	document.getElementById("pasienId").value=par[5];
	new Popup('divKantor',null,{modal:true,position:'center',duration:1});
	document.getElementById('divKantor').popup.show();
}

function openIsi(){
	new Popup('divInst',null,{modal:true,position:'center',duration:1});
	document.getElementById('divInst').popup.show();
}

var dg;
function popUpDiag(d){
	dg = d.split("||");
	document.getElementById('txtPel').value = dg[0];
	document.getElementById('txtKunj').value = dg[1];
	document.getElementById('pasienIdD').value = dg[2];
	//alert(document.getElementById('txtPel').value);
	new Popup('divDiag',null,{modal:true,position:'center',duration:1});
	document.getElementById('divDiag').popup.show();
	//alert("tindiag_utils.php?grd1=true&pelayanan_id="+document.getElementById('txtPel').value);
	b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id="+document.getElementById('txtPel').value);
	b.Init();
}

function batal(){
	document.getElementById('divKantor').popup.hide();
}

function batalInst(){
	document.getElementById('divInst').popup.hide();
	Request('isiCmb.php', 'namaperusahaan', '', 'GET' );
}

function batalD(){
	var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
	fSetValue(window,p);
	//document.getElementById('divDiag').popup.hide();
}

function hapus(id){
	var rowidDiag = document.getElementById("id_diag").value;
	switch(id)
	{
		case 'btnHapusDiag':
		if(confirm("Anda yakin menghapus Diagnosa "+b.cellsGetValue(b.getSelRow(),3))){
			document.getElementById(id).disabled = true;
			//alert("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&pelayanan_id="+document.getElementById('txtPel').value+"&rowid="+rowidDiag);
			b.loadURL("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&pelayanan_id="+document.getElementById('txtPel').value+"&rowid="+rowidDiag,"","GET");
		}
		document.getElementById("txtDiag").value = '';
		break;
	}
}

function upKantor(){
	Request('klaimInapReq2.php?act=edit&namaperusahaan='+document.getElementById("namaperusahaan").value+'&nopeserta='+document.getElementById("nopeserta").value+'&pasienId='+document.getElementById("pasienId").value+'&namapeserta='+document.getElementById("namapeserta").value,'tmpUpdate','','GET',setUpdate);
    return false;  
}

function upDiag(){
	Request('klaimInapReq2.php?act=diag&pelayananId='+document.getElementById('txtPel').value+'&pasienId='+document.getElementById("pasienIdD").value,'tmpUpdateD','','GET',setUpdateD);
    return false;  
}

function setUpdate(){
    var p = document.getElementById('tmpUpdate').innerHTML;
    //alert(p);
    p = p.split("||");
    document.getElementById('txtPerusahaan'+par[6]).innerHTML=p[1];
    document.getElementById('txtNoP'+par[6]).innerHTML=p[0];
    document.getElementById('NamaP'+par[6]).innerHTML=p[2];
	document.getElementById('divKantor').popup.hide();
}

function setUpdateD(){
    var dd = document.getElementById('tmpUpdateD').innerHTML;
	//alert(dg[3]);
    dd = dd.split("||");
    document.getElementById('txtDiagnosa'+dg[3]).innerHTML=dd[0];
}

var unitId = document.getElementById('txtUnitId').value;
var RowIdx;
var fKeyEnt;
isiCombo('cmbDok',unitId,'','cmbDokDiag');
function suggest(e,par){
	var keywords=par.value;//alert(keywords);
	if(e == 'cariDiag'){
		if(document.getElementById('divdiagnosa').style.display == 'block'){
			document.getElementById('divdiagnosa').style.display='none';
		}
		else{
			Request('diagnosalist.php?findAll=true&aKeyword='+keywords+'&unitId='+unitId , 'divdiagnosa', '', 'GET' );
			if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
			document.getElementById('divdiagnosa').style.display='block';
		}
	}
	else{
		if(keywords==""){
			document.getElementById('divdiagnosa').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblDiagnosa').rows.length;
				if (tblRow>0){
					//alert(RowIdx);
					if (key==38 && RowIdx>0){
						RowIdx=RowIdx-1;
						document.getElementById('lstDiag'+(RowIdx+1)).className='itemtableReq';
						if (RowIdx>0) document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
					}else if (key == 40 && RowIdx < tblRow){
						RowIdx=RowIdx+1;
						if (RowIdx>1) document.getElementById('lstDiag'+(RowIdx-1)).className='itemtableReq';
						document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
					}
				}
			}
			else if (key==13){
				if (RowIdx>0){
					if (fKeyEnt==false){
						fSetPenyakit(document.getElementById('lstDiag'+RowIdx).lang);
					}else{
						fKeyEnt=false;
					}
				}
			}
			else if (key!=27 && key!=37 && key!=39){
				RowIdx=0;
				fKeyEnt=false;
				Request('diagnosalist.php?aKeyword='+keywords+'&unitId='+unitId , 'divdiagnosa', '', 'GET' );
				if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
				document.getElementById('divdiagnosa').style.display='block';
			}
		}
	}
}

function fSetPenyakit(par){
	var cdata=par.split("*|*");
	document.getElementById("diagnosa_id").value=cdata[0];
	document.getElementById("txtDiag").value=cdata[1]+" - "+cdata[2];
	document.getElementById('divdiagnosa').style.display='none';
	document.getElementById('cmbDokDiag').focus();
}

function ambilDataDiag(){
	var sisip=b.getRowId(b.getSelRow()).split("|");
	var p ="diagnosa_id*-*"+sisip[2]+"*|*id_diag*-*"+sisip[0]+"*|*txtDiag*-*"+b.cellsGetValue(b.getSelRow(),3)+"*|*chkUtama*-*"+((b.cellsGetValue(b.getSelRow(),5)=='Utama')?'true':'false')+"*|*btnSimpanDiag*-*Simpan*|*btnHapusDiag*-*false";
	fSetValue(window,p);
	//+"*|*cmbDokDiag*-*"+sisip[1]
	//alert(sisip[3]);
	//alert("tindiag_utils.php?grd1=true&pelayanan_id="+document.getElementById('txtPel').value);
	if(sisip[3] == 0){
		isiCombo('cmbDok','',sisip[1],'cmbDokDiag');    
	}
	else{
		isiCombo('cmbDokPengganti','',sisip[1],'cmbDokDiag');
	}
	document.getElementById('chkDokterPenggantiDiag').checked = sisip[3];
}

function gantiDokter(comboDokter,statusCek){
	if(statusCek==true){
		isiCombo('cmbDokPengganti',document.getElementById('txtUnitId').value,'','cmbDokDiag');
	}
	else{
		isiCombo('cmbDok',document.getElementById('txtUnitId').value,'','cmbDokDiag');
	}
	document.getElementById('chkDokterPenggantiDiag').checked = statusCek;
}

function setDok(ke,ev){
	fSetValue(window,"cmbDokDiag*-*"+ke);
	if(ev.which==13) document.getElementById(ke).focus();
}

function simpan(action,id,cek)
{
	var userId='<?php echo $_REQUEST['user_act']?>';
	var idDokDiag = document.getElementById("cmbDokDiag").value;
	var isDokPengganti = 0;
	var idDiag = document.getElementById("id_diag").value;
	var diag = document.getElementById("txtDiag").value;
	var diag_id = document.getElementById("diagnosa_id").value;
	var isPrimer = 1;
	if(document.getElementById("chkUtama").checked == false){
		isPrimer = 0;
	}
	
	switch(id){
		case 'btnSimpanDiag':
		if(ValidateForm("diagnosa_id",'ind')){
			if(document.getElementById("chkDokterPenggantiDiag").checked == true){
				isDokPengganti = 1;
			}
			document.getElementById(id).disabled = true;
			url = "tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idDiag+"&pasienId="+document.getElementById('pasienIdD').value+"&pelayanan_id="+document.getElementById('txtPel').value+"&kunjungan_id="+document.getElementById('txtKunj').value+"&idDiag="+diag_id+"&diagnosa="+diag+"&idDok="+idDokDiag+"&isDokPengganti="+isDokPengganti+"&userId="+userId+"&isPrimer="+isPrimer;
			//alert(url);
			b.loadURL(url,"","GET");
			document.getElementById("txtDiag").value = '';
			batalD();
		}

		break;
	
	}
}

	var b = new DSGridObject("gridbox1");
	b.setHeader("DATA DIAGNOSA PASIEN");
	b.setColHeader("NO,KODE,DIAGNOSA,DOKTER,PRIORITAS");
	b.setIDColHeader(",kode,nama,dokter,");
	b.setColWidth("30,60,300,200,100");
	b.setCellAlign("center,center,left,left,center");
	b.setCellHeight(20);
	b.setImgPath("../../icon");
	b.setIDPaging("paging1");
	b.attachEvent("onRowClick","ambilDataDiag");
	b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id="+document.getElementById('txtPel').value);
	b.Init();

function summary(par,line){
	var tmp_o = tmp_pmi = tmp_jml_tot = tmp_jml_o = tmp_jml_pmi = 0, i = 0;
	if(document.forms[0].pmi.length > 0){
		/* if(par.id == 'obat'){
		//alert(line);
			document.forms[0].jml_to[line].value = (document.forms[0].obat[line].value*1)+(document.forms[0].jml_tind[line].value*1);
			document.forms[0].jml[line].value = (document.forms[0].jml_to[line].value*1)+(document.forms[0].pmi[line].value*1);
			document.forms[0].total[line].value = (document.forms[0].jml[line].value*1)-(document.forms[0].bayar[line].value*1);
			while(i<document.forms[0].obat.length){
				tmp_o += (document.forms[0].obat[i].value*1);
				tmp_jml_o += (document.forms[0].jml_to[i].value*1);
				tmp_jml_pmi += (document.forms[0].jml[i].value*1);
				tmp_jml_tot += (document.forms[0].total[i].value*1);
				i++;
			}
			document.getElementById('span_obat').innerHTML = FormatNumberFloor(tmp_o,'.');//FormatNum(tmp_o,0);
			document.getElementById('span_tindakanObat').innerHTML = FormatNumberFloor(tmp_jml_o,'.');
			document.getElementById('span_jumlahPmi').innerHTML = FormatNumberFloor(tmp_jml_pmi,'.');
			document.getElementById('span_totalBiaya').innerHTML = FormatNumberFloor(tmp_jml_tot,'.');
		}
		else  */
		if(par.id == 'pmi'){
			document.forms[0].jml[line].value = (document.forms[0].jml_to[line].value*1)+(document.forms[0].pmi[line].value*1);
			document.forms[0].total[line].value = (document.forms[0].jml[line].value*1)-(document.forms[0].bayar[line].value*1);
			while(i<document.forms[0].pmi.length){
				//tmp_o += (document.forms[0].obat[i].value*1);
				//tmp_jml_o += (document.forms[0].jml_to[i].value*1);
				tmp_pmi += (document.forms[0].pmi[i].value*1);
				tmp_jml_pmi += (document.forms[0].jml[i].value*1);
				tmp_jml_tot += (document.forms[0].total[i].value*1);
				i++;
			}
			//document.getElementById('span_obat').innerHTML = tmp_o;
			//document.getElementById('span_tindakanObat').innerHTML = tmp_jml_o;
			document.getElementById('span_pmi').innerHTML = FormatNumberFloor(tmp_pmi,'.');
			document.getElementById('span_jumlahPmi').innerHTML = FormatNumberFloor(tmp_jml_pmi,'.');
			document.getElementById('span_totalBiaya').innerHTML = FormatNumberFloor(tmp_jml_tot,'.');
		}
	}
	else{
		/* if(par.id == 'obat'){
			document.getElementById('jml_to').value = (document.getElementById('obat').value*1)+(document.getElementById('jml_tind').value*1);
			document.getElementById('jml').value = (document.getElementById('jml_to').value*1)+(document.getElementById('pmi').value*1);
			document.getElementById('total').value = (document.getElementById('jml').value*1)-(document.getElementById('bayar').value*1);
		}
		else  */
		if(par.id == 'pmi'){
			document.getElementById('jml').value = (document.getElementById('jml_to').value*1)+(document.getElementById('pmi').value*1);
			document.getElementById('total').value = (document.getElementById('jml').value*1)-(document.getElementById('bayar').value*1);
		}
	}
}
/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		if(document.forms[0].obat.length > 1){
			for(var i=0; i<document.forms[0].obat.length; i++){
				document.forms[0].obat[i].style.border = '0px';
				document.forms[0].jml_to[i].style.border = '0px';
				document.forms[0].jml[i].style.border = '0px';
				document.forms[0].pmi[i].style.border = '0px';
				document.forms[0].bayar[i].style.border = '0px';
				document.forms[0].total[i].style.border = '0px';
				document.forms[0].txtNo[i].style.border = '0px';
				document.forms[0].txtNm[i].style.border = '0px';
				document.forms[0].txtKntr[i].style.border = '0px';
			}
		}
		else{
			document.getElementById('obat').style.border = '0px';
			document.getElementById('pmi').style.border = '0px';
			document.getElementById('bayar').style.border = '0px';
			document.getElementById('jml_to').style.border = '0px';
			document.getElementById('jml').style.border = '0px';
			document.getElementById('total').style.border = '0px';
			document.getElementById('txtNo').style.border = '0px';
			document.getElementById('txtNm').style.border = '0px';
			document.getElementById('txtKntr').style.border = '0px';
		}
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
	
	/* popup instansi */
	
	function simpanLg(action)
	{
		if(ValidateForm('txtKode,txtNama,txtAlamat,txtKota,txtTlp','ind'))
		{
			var instansiId = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtNama").value;
			var alamat = document.getElementById("txtAlamat").value;
			var kota = document.getElementById("txtKota").value;
			var telp = document.getElementById("txtTlp").value;
			if(document.getElementById("rd1").checked==true && document.getElementById("rd0").checked==false){
				var aktif=document.getElementById("rd1").value;
			}
			else if(document.getElementById("rd0").checked==true && document.getElementById("rd1").checked==false){
				var aktif=document.getElementById("rd0").value;
			}
			
			//alert("penjamin_utils.php?grd=21&act="+action+"&instansiId="+instansiId+"&kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kota="+kota+"&telp="+telp+"&aktif="+aktif);
			aGrid.loadURL("../../master/penjamin_utils.php?grd=21&act="+action+"&instansiId="+instansiId+"&kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kota="+kota+"&telp="+telp+"&aktif="+aktif,"","GET");
						
			batalLg()
		}
	}
	
	function hapusLg()
	{
		var instansiId = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Penjamin "+aGrid.cellsGetValue(aGrid.getSelRow(),3)))
		{
			//alert("penjamin_utils.php?grd=21&act=hapus&instansiId="+instansiId);
			aGrid.loadURL("../../master/penjamin_utils.php?grd=21&act=hapus&instansiId="+instansiId,"","GET");
		}
		
			batalLg()
	}
	
	function ambilData(){
		var sisip2=aGrid.getRowId(aGrid.getSelRow()).split("|");
		//alert(sisip[0]);
		//alert(aGrid.getRowId(aGrid.getSelRow()));
		var p ="txtId*-*"+sisip2[0]+"*|*txtKode*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),2)+"*|*txtNama*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),3)+"*|*txtAlamat*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),4)+"*|*txtKota*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),5)+"*|*txtTlp*-*"+aGrid.cellsGetValue(aGrid.getSelRow(),6)+"*|*rd0*-*"+((sisip2[1]=='1')?'false':'true')+"*|*rd1*-*"+((sisip2[1]=='1')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
		//document.getElementById('btnHapusInstansi').disabled = false;
		//document.getElementById('btnSimpanInstansi').value = "Simpan";
	}
	
	function batalLg()
	{
		var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtAlamat*-**|*txtKota*-**|*txtTlp*-**|*rd0*-*true*|*rd1*-*false*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	
    var instansiId = document.getElementById('instansiId').value;
    var aGrid=new DSGridObject("gridbox");
	aGrid.setHeader("DATA PENJAMIN");	
	aGrid.setColHeader("NO,KODE,NAMA,ALAMAT,KOTA,NO TELEPON,STATUS");
	aGrid.setIDColHeader(",,nama,,,,");
	aGrid.setColWidth("50,75,250,250,150,100,75");
	aGrid.setCellAlign("center,center,left,left,left,left,center");
	aGrid.setCellHeight(20);
	aGrid.setImgPath("../../icon");
	aGrid.setIDPaging("paging");
	aGrid.attachEvent("onRowClick","ambilData");
	//alert("../../master/penjamin_utils.php?grd=21");
	aGrid.baseURL("../../master/penjamin_utils.php?grd=21");
    //alert("penjamin_utils.php?grd=20&ksoId="+idKso);
	aGrid.Init();
</script>
</html>

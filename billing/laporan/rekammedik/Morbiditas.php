<?php
include("../../sesi.php");
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Morbiditas.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Keadaan Morbiditas Pasien</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_diagnosa_rm.tgl = '$tglAwal2' ";
		$waktu2 = " and DATE(b_pasien_keluar.tgl_act) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_diagnosa_rm.tgl) = '$bln' and year(b_diagnosa_rm.tgl) = '$thn' ";
		$waktu2 = " and month(b_pasien_keluar.tgl_act) = '$bln' and year(b_pasien_keluar.tgl_act) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_diagnosa_rm.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = " and DATE(b_pasien_keluar.tgl_act) between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
		
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayananM']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Keadaan Morbiditas Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Jenis Layanan <?php if($_REQUEST['cmbJenisLayananM']==1){echo "RAWAT JALAN";} else if($_REQUEST['cmbJenisLayananM']==2){ echo "RAWAT DARURAT"; } else{ echo "RAWAT INAP";} ?> - Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</b></td>
  </tr>
  <tr>
  	
    <td align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td><?php if($_REQUEST['cmbJenisLayananM']==1 || $_REQUEST['cmbJenisLayananM']==2){?>
	<div id="jalan">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td width="3%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;" align="center">&nbsp;No</td>
		<td width="5%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;ICD X</td>
		<td width="32%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;Diagnosis</td>
		<td height="28" colspan="8" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">Jumlah Kasus Baru dalam Rentang Umur&nbsp;</td>
		<td colspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">Menurut Sex&nbsp;</td>
		<td colspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">Jumlah&nbsp;</td>
  </tr>
	  <tr>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">0-28 hr&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">28hr-<1th &nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">1-4 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">5-14 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">15-24 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">25-44 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">45-64 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">65 th +&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">Lk&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">Pr&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">Kasus Baru&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;">Kunjungan&nbsp;</td>
	  </tr>
	  <?php
			if($_REQUEST['StatusPas']!=0)
				$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
			if($_REQUEST['cmbTempatLayananM']!=0){
				$fUnit = " b_ms_unit.id = '".$_REQUEST['cmbTempatLayananM']."'";
			}else{
				$fUnit = " b_pelayanan.jenis_kunjungan=".$_REQUEST['cmbJenisLayananM'];
			}
			 
			/* $sql = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.kode, b_ms_diagnosa.nama, COUNT(b_ms_pasien.id) AS jml FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.primer=1 GROUP BY b_ms_diagnosa.id ORDER BY b_ms_diagnosa.kode"; */
			
			$sql = "SELECT t1.m_d_rm id, t1.kode_rm kode, UPPER(GROUP_CONCAT(nama SEPARATOR '<br/>- ')) nama, SUM(jml) jml FROM
					(SELECT 
					  b_diagnosa_rm.ms_diagnosa_id m_d_rm,
					  d.diagnosa_id id_d_dokter,
					  d.ms_diagnosa_id m_d_dokter,
					  md_rm.kode kode_rm,
					  IFNULL(md_dokter.nama,d.diagnosa_manual) nama,
					  COUNT(DISTINCT b_pelayanan.pasien_id) jml
					FROM
					  b_diagnosa_rm 
					  INNER JOIN b_diagnosa d 
						ON d.diagnosa_id = b_diagnosa_rm.diagnosa_id 
					  LEFT JOIN b_ms_diagnosa md_rm 
						ON md_rm.id = b_diagnosa_rm.ms_diagnosa_id 
					  LEFT JOIN b_ms_diagnosa md_dokter 
						ON md_dokter.id = d.ms_diagnosa_id
					  INNER JOIN b_pelayanan
						ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
					  INNER JOIN b_kunjungan
						ON b_kunjungan.id = b_pelayanan.kunjungan_id
					  LEFT JOIN b_ms_pasien mp
						ON mp.id = b_kunjungan.pasien_id
					  INNER JOIN b_ms_unit
						ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE $fUnit $fKso $waktu
					  AND b_diagnosa_rm.primer = 1 
					GROUP BY b_diagnosa_rm.ms_diagnosa_id,
					  d.diagnosa_manual,
					  md_dokter.nama) t1
					GROUP BY t1.m_d_rm";
			/* p.jenis_kunjungan = 1 
					  AND MONTH(b_diagnosa_rm.tgl) = '02' 
					  AND YEAR(b_diagnosa_rm.tgl) = '2014'  */
			
			/* $sql = "SELECT 
					  t2.m_d_rm id,
					  t2.kode_rm kode,
					  UPPER(GROUP_CONCAT(t2.nama SEPARATOR '<br/>- ')) nama,
					  SUM(t2.jml) jml 
					FROM
					  (SELECT 
						t1.m_d_rm,
						t1.kode_rm,
						IFNULL(t1.nama_dokter, t1.m_dokter) nama,
						COUNT(t1.m_d_rm) jml 
					  FROM
						(SELECT 
						  b_diagnosa_rm.ms_diagnosa_id m_d_rm,
						  d.diagnosa_id id_d_dokter,
						  d.ms_diagnosa_id m_d_dokter,
						  md_rm.kode kode_rm,
						  d.diagnosa_manual m_dokter,
						  md_dokter.nama nama_dokter 
						FROM
						  b_diagnosa_rm 
						  INNER JOIN b_diagnosa d 
							ON d.diagnosa_id = b_diagnosa_rm.diagnosa_id 
						  LEFT JOIN b_ms_diagnosa md_rm 
							ON md_rm.id = b_diagnosa_rm.ms_diagnosa_id 
						  LEFT JOIN b_ms_diagnosa md_dokter 
							ON md_dokter.id = d.ms_diagnosa_id 
						  INNER JOIN b_pelayanan 
							ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id 
						  INNER JOIN b_kunjungan 
							ON b_kunjungan.id = b_pelayanan.kunjungan_id 
						  LEFT JOIN b_ms_pasien mp 
							ON mp.id = b_kunjungan.pasien_id 
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id 
						WHERE $fUnit $fKso $waktu 
						  AND b_diagnosa_rm.primer = 1 
						GROUP BY b_diagnosa_rm.ms_diagnosa_id,
						  b_pelayanan.pasien_id) t1 
					  GROUP BY t1.m_d_rm,
						t1.m_dokter,
						t1.nama_dokter) t2 
					GROUP BY t2.m_d_rm"; */
			$rs = mysql_query($sql);
			$no = 1;
			$jmlu1 = 0;
			$jmlu2 = 0;
			$jmlu3 = 0;
			$jmlu4 = 0;
			$jmlu5 = 0;
			$jmlu6 = 0;
			$jmlu7 = 0;
			$jmlu8 = 0;
			$jmll = 0;
			$jmlp = 0;
			$jmlBr = 0;
			$jmltot = 0;
			while($rw = mysql_fetch_array($rs))
			{
				$u1 = 0;
				$u2 = 0;
				$u3 = 0;
				$u4 = 0;
				$u5 = 0;
				$u6 = 0;
				$u7 = 0;
				$u8 = 0;
				$l = 0;
				$p = 0;
				$jml = 0;
				$kunj = 0;
				
				$sql2 = "SELECT COUNT(b_ms_pasien.id) AS jml, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_kunjungan.isbaru, b_ms_pasien.sex, b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.kasus_baru='1' AND b_ms_diagnosa.id = '".$rw['id']."'  AND b_diagnosa_rm.primer=1 GROUP BY b_kunjungan.umur_thn";
				$rs2 = mysql_query($sql2);
				while($rw2 = mysql_fetch_array($rs2))
				{
					if($rw2['umur_bln']<>0 && $rw2['umur_thn']==0)
					{
						$u1 = $u1 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u1 = 0;
						}
					}
					else if($rw2['umur_thn']<1)
					{
						$u2 = $u2 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u2 = 0;
						}
					}
					else if($rw2['umur_thn']>=1 && $rw2['umur_thn']<=4)
					{
						$u3 = $u3 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u3 = 0;
						}
					}
					else if($rw2['umur_thn']>=5 && $rw2['umur_thn']<=14)
					{
						$u4 = $u4 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u4 = 0;
						}
					}
					else if($rw2['umur_thn']>=15 && $rw2['umur_thn']<=24)
					{
						$u5 = $u5 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u5 = 0;
						}
					}
					else if($rw2['umur_thn']>=25 && $rw2['umur_thn']<=44)
					{
						$u6 = $u6 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u6 = 0;
						}
					}
					else if($rw2['umur_thn']>=45 && $rw2['umur_thn']<=64)
					{
						$u7 = $u7 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u7 = 0;
						}
					}
					else if($rw2['umur_thn']>=65)
					{
						$u8 = $u8 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u8 = 0;
						}
					}
					
					//$jml = $jml + $u1 + $u2 + $u3 + $u4 + $u5 + $u6 + $u7 + $u8;
				}mysql_free_result($rs2);
				
				$qSex = "SELECT COUNT(b_ms_pasien.id) AS jml, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_kunjungan.isbaru, b_ms_pasien.sex, b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.kasus_baru='1' AND b_ms_diagnosa.id = '".$rw['id']."'  AND b_diagnosa_rm.primer=1 GROUP BY b_ms_pasien.sex";
					$rsSex = mysql_query($qSex);
					while($rwSex = mysql_fetch_array($rsSex))
					{				
						if($rwSex['sex']=='L')
						{
							$l = $l + $rwSex['jml'];
							if($rwSex['jml'] == "")
							{
								$l = 0;
							}
						}
						else if($rwSex['sex']=='P')
						{
							$p = $p + $rwSex['jml'];
							if($rwSex['jml'] == "")
							{
								$p = 0;
							}
						}
					}mysql_free_result($rsSex);
					
					$qBaru = "SELECT COUNT(b_ms_pasien.id) AS jml, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_kunjungan.isbaru, b_ms_pasien.sex, b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_ms_diagnosa.id = '".$rw['id']."' AND b_diagnosa_rm.kasus_baru='1' AND b_diagnosa_rm.primer=1";
					$rsBaru = mysql_query($qBaru);
					$rwBaru = mysql_fetch_array($rsBaru);
					mysql_free_result($rsBaru);
	  ?>
	  <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;<?php echo $no; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px;"><?php echo $rw['kode']; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase;"><?php echo "- ".$rw['nama']; ?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u1==0) echo ""; else echo $u1;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u2==0) echo ""; else echo $u2;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u3==0) echo ""; else echo $u3;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u4==0) echo ""; else echo $u4;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u5==0) echo ""; else echo $u5;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u6==0) echo ""; else echo $u6;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u7==0) echo ""; else echo $u7;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u8==0) echo ""; else echo $u8;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($l==0) echo ""; else echo $l;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($p==0) echo ""; else echo $p;?></td>
		<td align="right" style="border-left:1px solid; border-bottom:1px solid; padding-right:20px;"><?php echo $rwBaru['jml'];?></td>
		<td align="right" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; padding-right:20px;"><?php echo $rw['jml'];?></td>
	  </tr>
	  <?
				$no++;
				$jmlu1 = $jmlu1 + $u1;
				$jmlu2 = $jmlu2 + $u2;
				$jmlu3 = $jmlu3 + $u3;
				$jmlu4 = $jmlu4 + $u4;
				$jmlu5 = $jmlu5 + $u5;
				$jmlu6 = $jmlu6 + $u6;
				$jmlu7 = $jmlu7 + $u7;
				$jmlu8 = $jmlu8 + $u8;
				$jmll = $jmll + $l;
				$jmlp = $jmlp + $p;
				$jmlBr = $jmlBr + $rwBaru['jml'];
				$jmltot = $jmltot + $rw['jml'];
			}mysql_free_result($rs);
	  ?>
	  <tr>
	  	<td colspan="3" style="text-align:center; border-bottom:1px solid; border-left:1px solid; font-weight:bold;" height="28">TOTAL</td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu1==0) echo ""; else echo $jmlu1;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu2==0) echo ""; else echo $jmlu2;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu3==0) echo ""; else echo $jmlu3;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu4==0) echo ""; else echo $jmlu4;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu5==0) echo ""; else echo $jmlu5;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu6==0) echo ""; else echo $jmlu6;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu7==0) echo ""; else echo $jmlu7;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu8==0) echo ""; else echo $jmlu8;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmll==0) echo ""; else echo $jmll;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlp==0) echo ""; else echo $jmlp;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:right; padding-right:20px; font-weight:bold;"><?php if($jmlBr==0) echo ""; else echo $jmlBr;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:right; border-right:1px solid; padding-right:20px; font-weight:bold;"><?php if($jmltot==0) echo ""; else echo $jmltot;?></td>
	  </tr>
</table>
</div>
<?php
}else{ ?>
	<div id="inap">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td width="3%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;" align="center">&nbsp;No</td>
		<td width="5%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;ICD X</td>
		<td width="32%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;Diagnosis</td>
		<td height="28" colspan="8" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">Jumlah Kasus Baru dalam Rentang Umur&nbsp;</td>
		<td colspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">Menurut Sex&nbsp;</td>
		<td rowspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">Jumlah Pasien<br />Keluar (H+M)</td>
        <td rowspan="2" align="center" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">Jumlah Pasien<br />Meninggal</td>
	</tr>
	  <tr>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">0-28 hr&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">28hr-<1th &nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">1-4 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">5-14 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">15-24 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">25-44 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">45-64 th&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">65 th +&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">Lk&nbsp;</td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;">Pr&nbsp;</td>
		</tr>
	  <?php
			if($_REQUEST['StatusPas']!=0)
				$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
			if($_REQUEST['cmbTempatLayananM']!=0){
				$fUnit = " b_ms_unit.id = '".$_REQUEST['cmbTempatLayananM']."'";
			}else{
				$fUnit = " b_pelayanan.jenis_kunjungan=3";
			}
			 
			/* $sql = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.kode, b_ms_diagnosa.nama, COUNT(b_ms_pasien.id) AS jml FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.primer=1 GROUP BY b_ms_diagnosa.id ORDER BY b_ms_diagnosa.kode"; */
			
			$sql = "SELECT t1.m_d_rm id, t1.kode_rm kode, UPPER(GROUP_CONCAT(nama SEPARATOR '<br/>- ')) nama, SUM(jml) jml FROM
					(SELECT 
					  b_diagnosa_rm.ms_diagnosa_id m_d_rm,
					  d.diagnosa_id id_d_dokter,
					  d.ms_diagnosa_id m_d_dokter,
					  md_rm.kode kode_rm,
					  IFNULL(md_dokter.nama,d.diagnosa_manual) nama,
					  COUNT(DISTINCT b_pelayanan.pasien_id) jml
					FROM
					  b_diagnosa_rm 
					  INNER JOIN b_diagnosa d 
						ON d.diagnosa_id = b_diagnosa_rm.diagnosa_id 
					  LEFT JOIN b_ms_diagnosa md_rm 
						ON md_rm.id = b_diagnosa_rm.ms_diagnosa_id 
					  LEFT JOIN b_ms_diagnosa md_dokter 
						ON md_dokter.id = d.ms_diagnosa_id
					  INNER JOIN b_pelayanan
						ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
					  INNER JOIN b_kunjungan
						ON b_kunjungan.id = b_pelayanan.kunjungan_id
					  LEFT JOIN b_ms_pasien mp
						ON mp.id = b_kunjungan.pasien_id
					  INNER JOIN b_ms_unit
						ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE $fUnit $fKso $waktu
					  AND b_diagnosa_rm.primer = 1 
					GROUP BY b_diagnosa_rm.ms_diagnosa_id,
					  d.diagnosa_manual,
					  md_dokter.nama) t1
					GROUP BY t1.m_d_rm";
			$rs = mysql_query($sql);
			$no = 1;
			$jmlu1 = 0;
			$jmlu2 = 0;
			$jmlu3 = 0;
			$jmlu4 = 0;
			$jmlu5 = 0;
			$jmlu6 = 0;
			$jmlu7 = 0;
			$jmlu8 = 0;
			$jmll = 0;
			$jmlp = 0;
			$jmlBr = 0;
			$jmltot = 0;
			while($rw = mysql_fetch_array($rs))
			{
				$u1 = 0;
				$u2 = 0;
				$u3 = 0;
				$u4 = 0;
				$u5 = 0;
				$u6 = 0;
				$u7 = 0;
				$u8 = 0;
				$l = 0;
				$p = 0;
				$jml = 0;
				$kunj = 0;
				
				$sql2 = "SELECT COUNT(b_ms_pasien.id) AS jml, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_kunjungan.isbaru, b_ms_pasien.sex, b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.kasus_baru='1' AND b_ms_diagnosa.id = '".$rw['id']."' AND b_diagnosa_rm.primer=1 GROUP BY b_kunjungan.umur_thn";
				$rs2 = mysql_query($sql2);
				while($rw2 = mysql_fetch_array($rs2))
				{
					if($rw2['umur_bln']<>0 && $rw2['umur_thn']==0)
					{
						$u1 = $u1 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u1 = 0;
						}
					}
					else if($rw2['umur_thn']<1)
					{
						$u2 = $u2 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u2 = 0;
						}
					}
					else if($rw2['umur_thn']>=1 && $rw2['umur_thn']<=4)
					{
						$u3 = $u3 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u3 = 0;
						}
					}
					else if($rw2['umur_thn']>=5 && $rw2['umur_thn']<=14)
					{
						$u4 = $u4 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u4 = 0;
						}
					}
					else if($rw2['umur_thn']>=15 && $rw2['umur_thn']<=24)
					{
						$u5 = $u5 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u5 = 0;
						}
					}
					else if($rw2['umur_thn']>=25 && $rw2['umur_thn']<=44)
					{
						$u6 = $u6 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u6 = 0;
						}
					}
					else if($rw2['umur_thn']>=45 && $rw2['umur_thn']<=64)
					{
						$u7 = $u7 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u7 = 0;
						}
					}
					else if($rw2['umur_thn']>=65)
					{
						$u8 = $u8 + $rw2['jml'];
						if($rw2['jml'] == "")
						{
							$u8 = 0;
						}
					}
					
					//$jml = $jml + $u1 + $u2 + $u3 + $u4 + $u5 + $u6 + $u7 + $u8;
				}mysql_free_result($rs2);
				
				$qSex = "SELECT COUNT(b_ms_pasien.id) AS jml, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_kunjungan.isbaru, b_ms_pasien.sex, b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fUnit $fKso $waktu AND b_diagnosa_rm.kasus_baru='1' AND b_ms_diagnosa.id = '".$rw['id']."' AND b_diagnosa_rm.primer=1 GROUP BY b_ms_pasien.sex";
					$rsSex = mysql_query($qSex);
					while($rwSex = mysql_fetch_array($rsSex))
					{				
						if($rwSex['sex']=='L')
						{
							$l = $l + $rwSex['jml'];
							if($rwSex['jml'] == "")
							{
								$l = 0;
							}
						}
						else if($rwSex['sex']=='P')
						{
							$p = $p + $rwSex['jml'];
							if($rwSex['jml'] == "")
							{
								$p = 0;
							}
						}
					}mysql_free_result($rsSex);
					
					$qKeluar = "SELECT COUNT(b_ms_pasien.id) AS jml FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE $fUnit $fKso $waktu2 AND b_ms_diagnosa.id = '".$rw['id']."' AND b_diagnosa_rm.primer=1";
					$rsKeluar = mysql_query($qKeluar);
					$rwKeluar = mysql_fetch_array($rsKeluar);
					mysql_free_result($rsKeluar);
					
					$qMati = "SELECT COUNT(b_ms_pasien.id) AS jml FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE $fUnit $fKso $waktu2 AND b_ms_diagnosa.id = '".$rw['id']."' AND b_pasien_keluar.cara_keluar = 'Meninggal' AND b_diagnosa_rm.primer=1";
					$rsMati = mysql_query($qMati);
					$rwMati = mysql_fetch_array($rsMati);
					mysql_free_result($rsMati);
	  ?>
	  <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;<?php echo $no; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px;"><?php echo $rw['kode']; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase;"><?php echo "- ".$rw['nama']; ?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u1==0) echo ""; else echo $u1;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u2==0) echo ""; else echo $u2;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u3==0) echo ""; else echo $u3;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u4==0) echo ""; else echo $u4;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u5==0) echo ""; else echo $u5;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u6==0) echo ""; else echo $u6;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u7==0) echo ""; else echo $u7;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($u8==0) echo ""; else echo $u8;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($l==0) echo ""; else echo $l;?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($p==0) echo ""; else echo $p;?></td>
		<td align="right" style="border-left:1px solid; border-bottom:1px solid; padding-right:20px;"><?php if($l+$p==0) echo ""; else echo $l+$p;?></td>
		<td align="right" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; padding-right:20px;"><?php if($rwMati['jml']==0) echo ""; else echo $rwMati['jml'];?></td>
	  </tr>
	  <?
				$no++;
				$jmlu1 = $jmlu1 + $u1;
				$jmlu2 = $jmlu2 + $u2;
				$jmlu3 = $jmlu3 + $u3;
				$jmlu4 = $jmlu4 + $u4;
				$jmlu5 = $jmlu5 + $u5;
				$jmlu6 = $jmlu6 + $u6;
				$jmlu7 = $jmlu7 + $u7;
				$jmlu8 = $jmlu8 + $u8;
				$jmll = $jmll + $l;
				$jmlp = $jmlp + $p;
				//$jmlBr = $jmlBr + $rwKeluar['jml'];
				$jmlBr = $jmlBr + ($l+$p);
				$jmltot = $jmltot +  $rwMati['jml'];
			}mysql_free_result($rs);
	  ?>
	  <tr>
	  	<td colspan="3" style="text-align:center; border-bottom:1px solid; border-left:1px solid; font-weight:bold;" height="28">TOTAL</td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu1==0) echo ""; else echo $jmlu1;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu2==0) echo ""; else echo $jmlu2;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu3==0) echo ""; else echo $jmlu3;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu4==0) echo ""; else echo $jmlu4;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu5==0) echo ""; else echo $jmlu5;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu6==0) echo ""; else echo $jmlu6;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu7==0) echo ""; else echo $jmlu7;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlu8==0) echo ""; else echo $jmlu8;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmll==0) echo ""; else echo $jmll;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($jmlp==0) echo ""; else echo $jmlp;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:right; padding-right:20px; font-weight:bold;"><?php if($jmlBr==0) echo ""; else echo $jmlBr;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:right; border-right:1px solid; padding-right:20px; font-weight:bold;"><?php if($jmltot==0) echo ""; else echo $jmltot;?></td>
	  </tr>
</table>
</div>
<?php } ?>
	</td>
  </tr>
  <tr>
  	<td id="isi">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Tgl Cetak: <?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Yang Mencetak&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr id="trTombol" class="noline">
  	<td height="50" align="center" valign="bottom"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
  </tr>
  <tr>
  	<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_free_result($rsKso);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }
</script>

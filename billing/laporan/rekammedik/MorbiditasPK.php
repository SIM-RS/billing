<?php
session_start();
include("../../sesi.php");
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
	
	if($_REQUEST['chkKecelakaan']=='on'){
  		$fKecelakaan = " AND (b_ms_diagnosa.kode LIKE '%v%' OR b_ms_diagnosa.kode LIKE '%w%' OR b_ms_diagnosa.kode LIKE '%x%' OR b_ms_diagnosa.kode LIKE '%y%')";
		$txtKecelakaan = "PENYEBAB KECELAKAAN";
    }
    else{
  		$fKecelakaan = " AND b_ms_diagnosa.kode NOT LIKE '%v%' AND b_ms_diagnosa.kode NOT LIKE '%w%' AND b_ms_diagnosa.kode NOT LIKE '%x%' AND b_ms_diagnosa.kode NOT LIKE '%y%'";
		$txtKecelakaan = "";
    }
	
	//$fKecelakaan = "";
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Keadaan Morbiditas Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Jenis Layanan <?php if($_REQUEST['cmbJenisLayananM']==1){echo "RAWAT JALAN";} else if($_REQUEST['cmbJenisLayananM']==2){ echo "RAWAT DARURAT"; } else{ echo "RAWAT INAP";} ?> - Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;<b><?php echo $txtKecelakaan; ?></b></td>
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
		<td colspan="2" width="32%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;" align="center">Diagnosis</td>
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
			 
			$sql = "select dg_kode,dg_group,dg_nama from b_ms_diagnosa_gol where dg_tipe=1 order by dg_kode";
			$rs = mysql_query($sql);
			$no = 1;
			
			$tot1=0;
			$tot2=0;
			$tot3=0;
			$tot4=0;
			$tot5=0;
			$tot6=0;
			$tot7=0;
			$tot8=0;
			$tot9=0;
			$tot10=0;
			$tot11=0;
			$tot12=0;
			while($rw = mysql_fetch_array($rs))
			{	
				
	  ?>
	  <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;<?php echo $no; ?></td>
		<td colspan="2" style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase; font-weight:bold"><?php echo $rw['dg_nama']; ?></td>
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
	  		$diag = "SELECT 
			            b_ms_diagnosa.id,
						b_ms_diagnosa.kode,
						b_ms_diagnosa.nama,
						SUM(IF(b_kunjungan.kel_umur = 206, 1, 0)) AS jml1,
						SUM(IF(b_kunjungan.kel_umur = 207, 1, 0)) AS jml2,
						SUM(IF(b_kunjungan.kel_umur = 208, 1, 0)) AS jml3,
						SUM(IF(b_kunjungan.kel_umur = 209, 1, 0)) AS jml4,
						SUM(IF(b_kunjungan.kel_umur = 210, 1, 0)) AS jml5,
						SUM(IF(b_kunjungan.kel_umur = 211, 1, 0)) AS jml6,
						SUM(IF(b_kunjungan.kel_umur = 212, 1, 0)) AS jml7,
						SUM(IF(b_kunjungan.kel_umur = 213, 1, 0)) AS jml8,
						SUM(IF(b_ms_pasien.sex = 'L', 1, 0)) AS lk,
						SUM(IF(b_ms_pasien.sex = 'P', 1, 0)) AS pr 
						FROM
						b_ms_pasien 
						INNER JOIN b_kunjungan 
						ON b_kunjungan.pasien_id = b_ms_pasien.id 
						INNER JOIN b_pelayanan 
						ON b_pelayanan.kunjungan_id = b_kunjungan.id 
						INNER JOIN b_diagnosa_rm 
						ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
						INNER JOIN b_ms_diagnosa 
						ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						INNER JOIN b_ms_unit 
						ON b_ms_unit.id = b_pelayanan.unit_id 
						WHERE 
						$fUnit
						$waktu
						$fKso
						AND b_diagnosa_rm.kasus_baru = '1'
						AND b_ms_diagnosa.dg_kode = '".$rw['dg_kode']."' 
						GROUP BY b_ms_diagnosa.id";
				$queri = mysql_query($diag);
				while($rDiag = mysql_fetch_array($queri)){
					
					$sKunj = "SELECT 
							  COUNT(b_ms_pasien.id) jml 
							FROM
							  b_ms_pasien 
							  INNER JOIN b_kunjungan 
								ON b_kunjungan.pasien_id = b_ms_pasien.id 
							  INNER JOIN b_pelayanan 
								ON b_pelayanan.kunjungan_id = b_kunjungan.id 
							  INNER JOIN b_diagnosa_rm 
								ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
							  INNER JOIN b_ms_diagnosa 
								ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
							  INNER JOIN b_ms_unit 
								ON b_ms_unit.id = b_pelayanan.unit_id 
							WHERE $fUnit 
							  $waktu
							  $fKso
							  AND b_ms_diagnosa.id = '".$rDiag['id']."'
							GROUP BY b_ms_diagnosa.id";
					$qKunj = mysql_query($sKunj);
					$rkunj = mysql_fetch_array($qKunj);
	  			?>
	  <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;</td>
		<td width="5%" style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; font-style:italic"><?php echo $rDiag['kode']; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase; font-style:italic"><?php echo $rDiag['nama']; ?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml1']==0) echo ""; else echo $rDiag['jml1'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml2']==0) echo ""; else echo $rDiag['jml2'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml3']==0) echo ""; else echo $rDiag['jml3'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml4']==0) echo ""; else echo $rDiag['jml4'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml5']==0) echo ""; else echo $rDiag['jml5'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml6']==0) echo ""; else echo $rDiag['jml6'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml7']==0) echo ""; else echo $rDiag['jml7'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml8']==0) echo ""; else echo $rDiag['jml8'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['lk']==0) echo ""; else echo $rDiag['lk'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['pr']==0) echo ""; else echo $rDiag['pr'];?></td>
        <?php 
		$baru = $rDiag['lk'] + $rDiag['pr'];
		?>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php echo $baru; ?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;"><?php echo $rkunj['jml'];?></td>
	  </tr>
	  
	  			<?php
				
				$tot1 = $tot1 + $rDiag['jml1'];
				$tot2 = $tot2 + $rDiag['jml2'];
				$tot3 = $tot3 + $rDiag['jml3'];
				$tot4 = $tot4 + $rDiag['jml4'];
				$tot5 = $tot5 + $rDiag['jml5'];
				$tot6 = $tot6 + $rDiag['jml6'];
				$tot7 = $tot7 + $rDiag['jml7'];
				$tot8 = $tot8 + $rDiag['jml8'];
				$tot9 = $tot9 + $rDiag['lk'];
				$tot10 = $tot10 + $rDiag['pr'];
				$tot11 = $tot11 + $baru;
				$tot12 = $tot12 + $rkunj['jml'];
				
				
				}
				$no++;
			}
	  ?>
	  <tr>
	  	<td colspan="3" style="text-align:center; border-bottom:1px solid; border-left:1px solid; font-weight:bold;" height="28">TOTAL</td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot1==0) echo ""; else echo $tot1;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot2==0) echo ""; else echo $tot2;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot3==0) echo ""; else echo $tot3;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot4==0) echo ""; else echo $tot4;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot5==0) echo ""; else echo $tot5;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot6==0) echo ""; else echo $tot6;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot7==0) echo ""; else echo $tot7;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot8==0) echo ""; else echo $tot8;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot9==0) echo ""; else echo $tot9;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot10==0) echo ""; else echo $tot10;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot11==0) echo ""; else echo $tot11;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; border-right:1px solid; font-weight:bold;"><?php if($tot12==0) echo ""; else echo $tot12;?></td>
	  </tr>
</table>
</div>
<?php
}else{ ?>
	<div id="inap">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td width="3%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;" align="center">&nbsp;No</td>
		<td colspan="2" width="32%" rowspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;" align="center">Diagnosis</td>
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
			 
			$sql = "select dg_kode,dg_group,dg_nama from b_ms_diagnosa_gol where dg_tipe=1 order by dg_kode";
			$rs = mysql_query($sql);
			$no = 1;
			
			$tot1=0;
			$tot2=0;
			$tot3=0;
			$tot4=0;
			$tot5=0;
			$tot6=0;
			$tot7=0;
			$tot8=0;
			$tot9=0;
			$tot10=0;
			$tot11=0;
			$tot12=0;
			
			while($rw = mysql_fetch_array($rs))
			{
				
				
				
	  ?>
	  <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;<?php echo $no; ?></td>
		<td colspan="2" style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase; font-weight:bold"><?php echo $rw['dg_nama']; ?></td>
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
	  
	  		$diag = "SELECT 
			            b_ms_diagnosa.id,
						b_ms_diagnosa.kode,
						b_ms_diagnosa.nama,
						SUM(IF(b_kunjungan.kel_umur = 206, 1, 0)) AS jml1,
						SUM(IF(b_kunjungan.kel_umur = 207, 1, 0)) AS jml2,
						SUM(IF(b_kunjungan.kel_umur = 208, 1, 0)) AS jml3,
						SUM(IF(b_kunjungan.kel_umur = 209, 1, 0)) AS jml4,
						SUM(IF(b_kunjungan.kel_umur = 210, 1, 0)) AS jml5,
						SUM(IF(b_kunjungan.kel_umur = 211, 1, 0)) AS jml6,
						SUM(IF(b_kunjungan.kel_umur = 212, 1, 0)) AS jml7,
						SUM(IF(b_kunjungan.kel_umur = 213, 1, 0)) AS jml8,
						SUM(IF(b_ms_pasien.sex = 'L', 1, 0)) AS lk,
						SUM(IF(b_ms_pasien.sex = 'P', 1, 0)) AS pr 
						FROM
						b_ms_pasien 
						INNER JOIN b_kunjungan 
						ON b_kunjungan.pasien_id = b_ms_pasien.id 
						INNER JOIN b_pelayanan 
						ON b_pelayanan.kunjungan_id = b_kunjungan.id 
						INNER JOIN b_diagnosa_rm 
						ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
						INNER JOIN b_ms_diagnosa 
						ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						INNER JOIN b_ms_unit 
						ON b_ms_unit.id = b_pelayanan.unit_id 
						WHERE 
						$fUnit
						$waktu
						$fKso
						AND b_diagnosa_rm.kasus_baru = '1'
						AND b_ms_diagnosa.dg_kode = '".$rw['dg_kode']."' 
						GROUP BY b_ms_diagnosa.id";
				$queri = mysql_query($diag);
				while($rDiag = mysql_fetch_array($queri)){
					
					$sMati = "SELECT 
						  COUNT(b_ms_pasien.id) jml 
						FROM
						  b_ms_pasien 
						  INNER JOIN b_kunjungan 
							ON b_kunjungan.pasien_id = b_ms_pasien.id 
						  INNER JOIN b_pelayanan 
							ON b_pelayanan.kunjungan_id = b_kunjungan.id 
						  INNER JOIN b_diagnosa_rm 
							ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
						  INNER JOIN b_ms_diagnosa 
							ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
						  INNER JOIN b_ms_diagnosa_gol 
							ON b_ms_diagnosa.dg_kode = b_ms_diagnosa_gol.DG_KODE 
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id 
						  INNER JOIN b_pasien_keluar 
							ON b_pasien_keluar.pelayanan_id = b_pelayanan.id 
						WHERE $fUnit 
						  $waktu 
						  AND b_ms_diagnosa.id = '".$rDiag['id']."' 
						  AND b_pasien_keluar.cara_keluar = 'Meninggal' 
						GROUP BY b_ms_diagnosa.id";
					$qMati = mysql_query($sMati);
					$rMati = mysql_fetch_array($qMati);
					
				?>	
	    <tr>
		<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;</td>
		<td width="5%" style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; font-style:italic"><?php echo $rDiag['kode']; ?></td>
		<td style="border-left:1px solid; border-bottom:1px solid; padding-left:5px; text-transform:uppercase; font-style:italic"><?php echo $rDiag['nama']; ?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml1']==0) echo ""; else echo $rDiag['jml1'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml2']==0) echo ""; else echo $rDiag['jml2'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml3']==0) echo ""; else echo $rDiag['jml3'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml4']==0) echo ""; else echo $rDiag['jml4'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml5']==0) echo ""; else echo $rDiag['jml5'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml6']==0) echo ""; else echo $rDiag['jml6'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml7']==0) echo ""; else echo $rDiag['jml7'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['jml8']==0) echo ""; else echo $rDiag['jml8'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['lk']==0) echo ""; else echo $rDiag['lk'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['pr']==0) echo ""; else echo $rDiag['pr'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php if($rDiag['lk']+$rDiag['pr']==0) echo ""; else echo $rDiag['lk']+$rDiag['pr'];?></td>
		<td align="center" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;"><?php echo $rMati['jml']; ?></td>
	  </tr>		
				
				<?php
				
				$tot1 = $tot1 + $rDiag['jml1'];
				$tot2 = $tot2 + $rDiag['jml2'];
				$tot3 = $tot3 + $rDiag['jml3'];
				$tot4 = $tot4 + $rDiag['jml4'];
				$tot5 = $tot5 + $rDiag['jml5'];
				$tot6 = $tot6 + $rDiag['jml6'];
				$tot7 = $tot7 + $rDiag['jml7'];
				$tot8 = $tot8 + $rDiag['jml8'];
				$tot9 = $tot9 + $rDiag['lk'];
				$tot10 = $tot10 + $rDiag['pr'];
				$tot11 = $tot11 + ($rDiag['lk']+$rDiag['pr']);
				$tot12 = $tot12 + $rMati['jml'];
				
				}
	  
	  		$no++;
			}
	  ?>
	  <tr>
	  	<td colspan="3" style="text-align:center; border-bottom:1px solid; border-left:1px solid; font-weight:bold;" height="28">TOTAL</td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot1==0) echo ""; else echo $tot1;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot2==0) echo ""; else echo $tot2;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot3==0) echo ""; else echo $tot3;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot4==0) echo ""; else echo $tot4;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot5==0) echo ""; else echo $tot5;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot6==0) echo ""; else echo $tot6;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot7==0) echo ""; else echo $tot7;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot8==0) echo ""; else echo $tot8;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot9==0) echo ""; else echo $tot9;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot10==0) echo ""; else echo $tot10;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; font-weight:bold;"><?php if($tot11==0) echo ""; else echo $tot11;?></td>
	  	<td style="border-bottom:1px solid; border-left:1px solid; text-align:center; border-right:1px solid; font-weight:bold;"><?php if($tot12==0) echo ""; else echo $tot12;?></td>
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

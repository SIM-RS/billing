<?php
include("../../sesi.php");
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="pulpak.xls"');
}

?>
<?php
include ("../../koneksi/konek.php");
//====================================
	$tmpLayanan=$_REQUEST['cmbTempatLayananM'];
	$jnsLayanan=$_REQUEST['cmbJenisLayananM'];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	//$waktu = $_POST['cmbWaktu'];
	$waktu = 'Bulanan';
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND k.tgl_pulang = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(k.tgl_pulang) = '$bln' and year(k.tgl_pulang) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND k.tgl_pulang between '$tglAwal2' and '$tglAkhir2' ";
		
		$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
		$selisih=$tgl2-$tgl1;
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	if($tmpLayanan==0){
		if($jnsLayanan==1){
			$txtUnit = "RAWAT JALAN (SEMUA)";
		}
		else if($jnsLayanan==2){
			$txtUnit = "RAWAT DARURAT (SEMUA)";
		}
		else if($jnsLayanan==3){
			$txtUnit = "RAWAT INAP (SEMUA)";
		}
		$fUnit = "AND pl.jenis_kunjungan=".$jnsLayanan;
	}
	else{
		$sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
		$rsUnit = mysql_query($sqlUnit);
		$rwUnit = mysql_fetch_array($rsUnit);
		$txtUnit = $rwUnit['nama'];
		
		$fUnit = "AND u.id = '".trim($tmpLayanan)."'";
	}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Pulang Paksa :.</title>
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
  	<td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4" align="center" style="font-weight:bold; font-size:14px;" height="70">Alasan Pulang Paksa&nbsp;</td>
  </tr>
  <tr>
    <td width="5%" style="font-weight:bold">Ruang</td>
    <td width="67%" style="font-weight:bold">:&nbsp;<? echo $txtUnit;?></td>
    <td colspan="2" width="14%" style="font-weight:bold"><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr>
				<td height="30" align="center" style="border:#FFFFFF 1px solid; font-weight:bold; background-color:#999;">Tgl</td>
				<td align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#999;">Biaya</td>
				<td align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#999;">Keluarga</td>
				<td align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#999;">Keadaan <br /> Pasien</td>
				<td align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#999;">Pelayanan</td>
				<td align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#999;">Jumlah</td>
	      </tr>
		  <?php
				$bln = $_POST['cmbBln'];
				$thn = $_POST['cmbThn'];
				if($bln=='01' || $bln=='03' || $bln=='05' || $bln=='07' || $bln=='08' || $bln=='10' || $bln=='12'){
					$tgl = 31;
				}else if($bln == '02'){
					if(($thn54==0) && ($thn%100 !=0)){
						$tgl = 29;
					}else{
						$tgl = 28;
					}
				}else{
					$tgl = 30;
				}
				
				//$tgl=10;
				//echo $tmpLayanan;	
				$tot2=$tot3=$tot4=$tot5=$tot6=$tot7=$tot8=$tot9=$tot10=$tot11=$tot12=$tot13=$tot14=$tot15=$tot16=$tot17=$tot18=0;
				for($i=1;$i<=$tgl;$i++)
				{
		  			$tglAwal=$thn."-".$bln."-".$i;

					/* Pasien Awal */
				    $q2 = "SELECT u.nama,
							SUM(CASE WHEN DAY(k.tgl_pulang) = '$i' AND pk.keadaan_keluar = 'Karena Biaya'  THEN 1 ELSE 0 END) AS 'Biaya',
							SUM(CASE WHEN DAY(k.tgl_pulang) = '$i' AND pk.keadaan_keluar = 'karena keluarga'  THEN 1 ELSE 0 END) AS 'keluarga',
							SUM(CASE WHEN DAY(k.tgl_pulang) = '$i' AND pk.keadaan_keluar = 'Karena Keadaan Pasien'  THEN 1 ELSE 0 END) AS 'KPasien',
							SUM(CASE WHEN DAY(k.tgl_pulang) = '$i' AND pk.keadaan_keluar = 'Karena Pelayanan'  THEN 1 ELSE 0 END) AS 'Pelayanan',
							SUM(CASE WHEN DAY(k.tgl_pulang) = '$i' THEN 1 ELSE 0 END) AS 'Jumlah'
						  FROM
							b_ms_pasien p 
							INNER JOIN b_kunjungan k 
							  ON p.id = k.pasien_id
							INNER JOIN b_pelayanan pl
							  ON pl.kunjungan_id=k.id
							INNER JOIN b_pasien_keluar pk 
							  ON pl.id = pk.pelayanan_id
							INNER JOIN b_ms_unit u
							  ON u.id = pl.unit_id
						  WHERE pk.cara_keluar = 'Pulang Paksa' 
							$waktu
							$fUnit ";
							
							//echo $q2."<br>";
					$rs2 = mysql_query($q2);
					$rw2 = mysql_fetch_array($rs2);
					
			?>
		  <tr>
		  	<td height="25" align="center" style="border:#8080ff 1px solid; border-top:none"><?php echo $i?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['Biaya']=='0') echo '&nbsp;'; else echo $rw2['Biaya']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['keluarga']=='0') echo '&nbsp;'; else echo $rw2['keluarga']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['KPasien']=='0') echo '&nbsp;'; else echo $rw2['KPasien']?></td>
			<?php  $rw5 = $rw2['jml'] + $rw3['jml'] + $rw4['jml']; ?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['Pelayanan']=='0') echo '&nbsp;'; else echo $rw2['Pelayanan']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['Jumlah']=='0') echo '&nbsp;'; else echo $rw2['Jumlah']?></td>
		  </tr>
          <?php
          $tot2 = $tot2 + $rw2['Biaya'];
		  $tot3 = $tot3 + $rw2['keluarga'];
		  $tot4 = $tot4 + $rw2['KPasien'];
		  $tot5 = $tot5 + $rw2['Pelayanan'];
		  $tot6 = $tot6 + $rw2['Jumlah'];
		   }
		   ?>
          <tr>
		  	<td height="25" align="center" style="border:#8080ff 1px solid; border-top:none; font-weight:bold">Total</td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot2=='0') echo '&nbsp;'; else echo $tot2?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot3=='0') echo '&nbsp;'; else echo $tot3?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot4=='0') echo '&nbsp;'; else echo $tot4?></td>
			<?php  $rw5 = $rw2['jml'] + $rw3['jml'] + $rw4['jml']; ?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot5=='0') echo '&nbsp;'; else echo $tot5?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot6=='0') echo '&nbsp;'; else echo $tot6?></td>
		  </tr>
	</table>	</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
		<td colspan="4" style="padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
 </body>
</html>

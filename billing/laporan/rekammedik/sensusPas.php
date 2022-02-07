<?php
session_start();
include("../../sesi.php");
?>
<?php
include ("../../koneksi/konek.php");
//====================================
$tmpLayanan=$_REQUEST['TmpLayanan'];
$tglAwal1=explode('-',$_REQUEST['tglAwal']);
$tglAwal=$tglAwal1[2]."-".$tglAwal1[1]."-".$tglAwal1[0];
$tglAkhir1=explode('-',$_REQUEST['tglAkhir']);
$tglAkhir=$tglAkhir1[2]."-".$tglAkhir1[1]."-".$tglAkhir1[0];
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
//======Pengambilan Ruang================
$sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
$rsUnit = mysql_query($sqlUnit);
$rwUnit = mysql_fetch_array($rsUnit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Sensus Harian Paien :.</title>
</head>

<body>
<table width="1149" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="5"><b><br/><?=$prmkabRS?><br>
							<?=$namaRS?><br>
							<?=$alamatRS?><br>
							Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="5" align="center" style="font-weight:bold; font-size:18px"><u>SENSUS HARIAN PASIEN RAWAT INAP DAN JENIS KASUS</u></td>
  </tr>
  <tr>
    <td colspan="5" align="center" style="font-weight:bold">PERIODE <?php echo $tglAwal1[0]." ".$arrBln[$tglAwal1[1]]." ".$tglAwal1[2]." s/d ".$tglAkhir1[0]." ".$arrBln[$tglAkhir1[1]]." ".$tglAkhir1[2]?>&nbsp;SAMPAI JAM  24:00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RUANG&nbsp;:&nbsp;<?php echo $rwUnit['nama']?></td>
  </tr>
  <tr>
    <td colspan="5" style="font-weight:bold; font-style:italic">&nbsp;I. PASIEN KELUAR</td>
  </tr>
  <tr>
    <td colspan="5">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="2%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid">No</td>
				<td width="4%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">No RM</td>
				<td width="7%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;Pasien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="4%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="5%" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Umur</td>
				<td width="2%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Kls</td>
				<td width="6%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Tgl Masuk</td>
				<td width="6%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Lma DiRwt </td>
				<td colspan="3" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Keluar Hidup</td>
				<td colspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Mati</td>
				<td width="6%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diagnose&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="3%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">No DTD</td>
				<td colspan="8" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Pembayaran</td>
				<td width="6%" rowspan="2" align="center" style="font-weight:bold; border:#000000 1px solid; border-left:none">Jns Kasus / Spesialis </td>
			</tr>
			<tr>
			  <td align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">L/P(Th)</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;PS&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;RJ&nbsp;</td>
		      <td width="4%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;PP&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;>48&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;<48&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;UM&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;PNS&nbsp;</td>
		      <td width="5%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;SWAS&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;DB&nbsp;</td>
		      <td width="4%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;NDB&nbsp;</td>
		      <td width="3%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;TC&nbsp;</td>
		      <td width="6%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;JPKM&nbsp;</td>
		      <td width="6%" align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;KSO&nbsp;</td>
		  </tr>
		  <?php $qPas=mysql_query("SELECT p.id idPel,p.kunjungan_id,p.pasien_id,mp.nama,mp.alamat,k.umur_thn,mp.sex,mk.nama nmKls,DATE_FORMAT(p.tgl,'%d-%m-%Y') tgl,IF(tk.tgl_out IS NULL,DATEDIFF(NOW(),tk.tgl_in),DATEDIFF(tk.tgl_out,tk.tgl_in)) lama,pk.tgl_act,TIMEDIFF(p.tgl_act,pk.tgl_act) jam,pk.cara_keluar,kso.nama nmKso,IF(pk.cara_keluar LIKE 'meninggal',1,0) mati FROM b_pasien_keluar pk INNER JOIN b_kunjungan k ON pk.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id INNER JOIN b_ms_kso kso ON kso.id=k.kso_id WHERE p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND p.unit_id=$tmpLayanan GROUP BY p.kunjungan_id");
		  while($rwPas=mysql_fetch_array($qPas)){
		  	$i++;
		  	$qDiag=mysql_query("SELECT md.nama FROM b_diagnosa_rm d INNER JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id WHERE d.pelayanan_id=".$rwPas['idPel']);
			$diag='';
			while($rwDiag=mysql_fetch_array($qDiag)){
			$diag.="- ".$rwDiag['nama']."<br/>";
			}
			?>
		  <tr>
		  	<td align="center" style="border:#000000 1px solid; border-top:none"><?php echo $i?></td>
			<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $rwPas['no_rm']?></td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $rwPas['nama']?>&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $rwPas['alamat']?></td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $rwPas['sex']." (".$rwPas['umur_thn'].")"?></td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $rwPas['nmKls']?></td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $rwPas['tgl']?>&nbsp;</td>
			<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $rwPas['lama']?></td>
			<?php 
			$ps=''; $rj=''; $pp=''; $k48=''; $l48='';
			if($rwPas['mati']==0){
				if($rwPas['cara_keluar']=="Dirujuk")
					$rj=1;
				elseif($rwPas['cara_keluar']=="Atas Ijin Dokter")
					$ps=1;
				else
					$pp=1;
			}else{
				if($rwPas['keadaan_keluar']=="Meninggal < 48 jam")
					$k48=1;
				elseif($rwPas['keadaan_keluar']=="Meninggal > 48 jam")
					$l48=1;
			}
			?>
		  	<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $ps?>&nbsp;</td>
			<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $rj?>&nbsp;</td>
		  	<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $pp?>&nbsp;</td>
			<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $l48?>&nbsp;</td>
		  	<td align="center" style="border:#000000 1px solid; border-top:none; border-left:none"><?php echo $k48?>&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;<?php echo $diag?>&nbsp;</td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
		  	<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
			<td style="border:#000000 1px solid; border-top:none; border-left:none">&nbsp;</td>
		  </tr>
		  <?php }?>
		</table>	</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="32%" style="font-weight:bold; font-style:italic">II. PASIEN MASUK</td>
    <td width="3%" style="font-weight:bold; font-style:italic">&nbsp;&nbsp;</td>
    <td width="32%" style="font-weight:bold; font-style:italic">III. PASIEN PINDAHAN</td>
    <td width="3%" style="font-weight:bold; font-style:italic">&nbsp;&nbsp;</td>
    <td width="32%" style="font-weight:bold; font-style:italic">IV. PASIEN DIPINDAHKAN</td>
  </tr>
  <tr>
    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="7%" align="center" style="border:#000000 1px solid">No</td>
				<td width="14%" align="center" style="border:#000000 1px solid; border-left:none">No RM</td>
				<td width="35%" align="center" style="border:#000000 1px solid; border-left:none">Nama Pasien</td>
				<td width="44%" align="center" style="border:#000000 1px solid; border-left:none">Alamat</td>
			</tr>
			<?php 
			$qMsk=mysql_query("SELECT no_rm,b_ms_pasien.nama nmPas,alamat FROM b_pelayanan INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id=b_ms_pasien.id WHERE b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id=$tmpLayanan AND unit_id_asal=0 GROUP BY kunjungan_id");
			while($rwMsk=mysql_fetch_array($qMsk)){
			$i++;?>
			<tr>
				<td align="center" style="border:#000000 1px solid; border-top:none"><?php echo $i?></td>
				<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwMsk['no_rm']?>&nbsp;</td>
				<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwMsk['nmPas']?>&nbsp;</td>
				<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwMsk['alamat']?>&nbsp;</td>
			</tr>
			<?php }?>
		</table>	</td>
    <td>&nbsp;</td>
    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="7%" align="center" style="border:#000000 1px solid">No</td>
			<td width="15%" align="center" style="border:#000000 1px solid; border-left:none">No RM</td>
			<td width="34%" align="center" style="border:#000000 1px solid; border-left:none">Nama Pasien</td>
			<td width="44%" align="center" style="border:#000000 1px solid; border-left:none">Alamat</td>
		  </tr>
				<?php 
				$qPindah=mysql_query("SELECT no_rm,b_ms_pasien.nama nmPas,alamat FROM b_pelayanan INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id=b_ms_pasien.id WHERE b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id=$tmpLayanan AND unit_id_asal>0 GROUP BY kunjungan_id");
				$i=0;
				while($rwPindah=mysql_fetch_array($qPindah)){
				$i++;?>
		  <tr>
			<td align="center" style="border:#000000 1px solid; border-top:none"><?php echo $i?></td>
			<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwPindah['no_rm']?>&nbsp;</td>
			<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwPindah['nmPas']?>&nbsp;</td>
			<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwPindah['alamat']?>&nbsp;</td>
		  </tr>
		  <?php }?>
		</table>	</td>
    <td>&nbsp;</td>
    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
				<td width="8%" align="center" style="border:#000000 1px solid">No</td>
				<td width="16%" align="center" style="border:#000000 1px solid; border-left:none">No RM</td>
				<td width="31%" align="center" style="border:#000000 1px solid; border-left:none">Nama Pasien</td>
				<td width="45%" align="center" style="border:#000000 1px solid; border-left:none">Alamat</td>
			</tr>
			<?php 
			$qdPindah=mysql_query("SELECT no_rm,b_ms_pasien.nama nmPas,alamat FROM b_pelayanan INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id=b_ms_pasien.id WHERE b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id>0 AND unit_id_asal=$tmpLayanan GROUP BY kunjungan_id");
			$i=0;
			while($rwdPindah=mysql_fetch_array($qdPindah)){
			$i++;?>
			<tr>
				<td align="center" style="border:#000000 1px solid; border-top:none"><?php echo $i?></td>
				<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwdPindah['no_rm']?>&nbsp;</td>
				<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwdPindah['nmPas']?>&nbsp;</td>
				<td style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $rwdPindah['alamat']?>&nbsp;</td>
			</tr>
			<?php }?>
		</table>	</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-style:italic; font-weight:bold">V. RESUME</td>
  </tr>
  <tr>
    <td colspan="2">
		<table border="0" width="95%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="7%">&nbsp;</td>
				<td width="61%">&nbsp;</td>
				<td width="8%" align="center" style="font-weight:bold">VIP</td>
				<td width="8%" align="center" style="font-weight:bold">I</td>
				<td width="8%" align="center" style="font-weight:bold">II</td>
				<td width="8%" align="center" style="font-weight:bold">III</td>
			</tr>
			<?php $qLama=mysql_query("SELECT COUNT(pasien_id) jmlPas,mk.nama,mk.id FROM b_pelayanan p INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id LEFT JOIN b_pasien_keluar pk ON p.kunjungan_id=pk.kunjungan_id WHERE unit_id=$tmpLayanan AND p.tgl<'$tglAwal' AND pk.id IS NULL GROUP BY mk.id");
			while($rwLama=mysql_fetch_array($qLama)){
				$pasLama[$rwLama['id']]=$rwLama['jmlPas'];
			}?>
			<tr>
				<td width="7%" style="font-weight:bold">1.</td>
				<td width="61%" style="font-weight:bold">Pasien Lama / Awal </td>
				<td width="8%" style="border:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border:#000000 1px solid; border-left:none"><?php echo $pasLama[2]?>&nbsp;</td>
				<td width="8%" align="center" style="border:#000000 1px solid; border-left:none"><?php echo $pasLama[3]?>&nbsp;</td>
				<td width="8%" align="center" style="border:#000000 1px solid; border-left:none"><?php echo $pasLama[4]?>&nbsp;</td>
			</tr>
			<?php $qMsk=mysql_query("SELECT COUNT(pasien_id) jmlPas,kelas_id FROM b_pelayanan p WHERE p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id=$tmpLayanan AND unit_id_asal=0 GROUP BY kelas_id");
			while($rwMsk=mysql_fetch_array($qMsk)){
				$pasMsk[$rwMsk['kelas_id']]=$rwMsk['jmlPas'];
			}?>
			<tr>
				<td width="7%" style="font-weight:bold">2.</td>
				<td width="61%" style="font-weight:bold">Pasien Masuk</td>
				<td width="8%" align="center" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasMsk[2]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasMsk[3]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasMsk[4]?>&nbsp;</td>
			</tr>
			<?php $qPin=mysql_query("SELECT COUNT(pasien_id) jmlPas,kelas_id FROM b_pelayanan p WHERE p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id=$tmpLayanan AND unit_id_asal>0 GROUP BY kelas_id");
			while($rwPin=mysql_fetch_array($qPin)){
				$pasPin[$rwPin['kelas_id']]=$rwPin['jmlPas'];
			}?>
			<tr>
				<td width="7%" style="font-weight:bold">3.</td>
				<td width="61%" style="font-weight:bold">Pasien Pindahan</td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasPin[2]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasPin[3]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasPin[4]?>&nbsp;</td>
			</tr>
			<tr>
				<td width="7%" style="font-weight:bold">4.</td>
				<td width="61%" style="font-weight:bold">Total Pasien Dirawat ( 1+2+3 ) </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $totPas[2]=$pasMsk[2]+$pasPin[2]+$pasLama[2]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $totPas[3]=$pasMsk[3]+$pasPin[3]+$pasLama[3]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $totPas[4]=$pasMsk[4]+$pasPin[4]+$pasLama[4]?>&nbsp;</td>
			</tr>
			<?php $qPs=mysql_query("SELECT COUNT(DISTINCT p.kunjungan_id) jml_pas,mk.nama,mk.id FROM b_pelayanan p INNER JOIN b_pasien_keluar pk ON p.kunjungan_id=pk.kunjungan_id INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id WHERE p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND p.unit_id = $tmpLayanan GROUP BY p.kelas_id");
			while($rwPs=mysql_fetch_array($qPs)){
				$ps1[$rwPs['id']]=$rwPs['jml_pas'];
			}?>
			<tr>
				<td width="7%" style="font-weight:bold">5.</td>
				<td width="61%" style="font-weight:bold">Di Ijinkan Pulang </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $ps1[2]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $ps1[3]?>&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $ps1[4]?>&nbsp;</td>
			</tr>
			<?php $qdPin=mysql_query("SELECT COUNT(pasien_id) jmlPas,kelas_id FROM b_pelayanan p WHERE p.tgl BETWEEN '$tglAwal' AND '$tglAkhir' AND unit_id_asal=$tmpLayanan AND unit_id>0 GROUP BY kelas_id");
			while($rwdPin=mysql_fetch_array($qdPin)){
				$pasdPin[$rwdPin['kelas_id']]=$rwdPin['jmlPas'];
			}?>
			<tr>
				<td width="7%" style="font-weight:bold">6.</td>
				<td width="61%" style="font-weight:bold">Dirujuk</td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasdPin[2]?></td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasdPin[3]?></td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $pasdPin[4]?></td>
			</tr>
			<?php
					
					$sqlKu = "SELECT COUNT(pl.pasien_id) AS jml, pk.cara_keluar, pl.kelas_id
								FROM b_pelayanan pl
								INNER JOIN b_pasien_keluar pk ON pk.kunjungan_id = pl.kunjungan_id
								WHERE pl.tgl BETWEEN '$tglAwal' AND '$tglAkhir'
								AND pl.unit_id = $tmpLayanan";
					$rsKu = mysql_query($sqlKu);
					$v9 = 0;
					while($rwKu = mysql_fetch_array($rsKu))
					{
						if($rwKu['cara_keluar'] == 'Melarikan Diri')
						{
							$v9 = $v9 + $rwKu['jml'];
							$jml[$rwKu['kelas_id']] == $v9;
						}
					}
			?>
			<tr>
				<td width="7%" style="font-weight:bold">7.</td>
				<td width="61%" style="font-weight:bold">Pindah ke RS Lain </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="7%" style="font-weight:bold">8.</td>
				<td width="61%" style="font-weight:bold">Pulang Paksa </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="7%" style="font-weight:bold">9.</td>
				<td width="61%" style="font-weight:bold">Melarikan diri </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $jml[1];?></td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid"><?php echo $jml[2];?></td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="7%" style="font-weight:bold">10.</td>
				<td width="61%" style="font-weight:bold">Total Pasien Keluar Hidup </td>
				<td width="8%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="8%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
		</table>
	</td>
    <td colspan="3">
		<table border="0" width="70%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="14%">&nbsp;</td>
				<td width="60%">&nbsp;</td>
				<td width="7%" align="center" style="font-weight:bold">VIP</td>
				<td width="7%" align="center" style="font-weight:bold">I</td>
				<td width="6%" align="center" style="font-weight:bold">II</td>
				<td width="6%" align="center" style="font-weight:bold">III</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">11.</td>
				<td width="60%" style="font-weight:bold">Pasien Dipindahkan </td>
				<td width="7%" style="border:#000000 1px solid">&nbsp;</td>
				<td width="7%" align="center" style="border:#000000 1px solid; border-left:none">&nbsp;</td>
				<td width="6%" align="center" style="border:#000000 1px solid; border-left:none">&nbsp;</td>
				<td width="6%" align="center" style="border:#000000 1px solid; border-left:none">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">12.</td>
				<td width="60%" style="font-weight:bold">Pasien Mati &gt; 48 Jam </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">13.</td>
				<td width="60%" style="font-weight:bold">Pasien Mati &lt; 48 Jam </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">14.</td>
				<td width="60%" style="font-weight:bold">Total Pasien Keluar ( 10+11+12+13 ) </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">15.</td>
				<td width="60%" style="font-weight:bold">Sisa Pasien ( 4 - 14 )  </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">16.</td>
				<td width="60%" style="font-weight:bold">Pasien Masuk dan Keluar pada Hari yang Sama </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" align="center" style="font-weight:bold">17.</td>
				<td width="60%" style="font-weight:bold">Total Lama Dirawat </td>
				<td width="7%" style="border:#000000 1px solid; border-top:none">&nbsp;</td>
				<td width="7%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
				<td width="6%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" style="font-weight:bold">&nbsp;</td>
				<td width="60%" style="font-weight:bold">&nbsp;</td>
				<td width="7%">&nbsp;</td>
				<td width="7%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" style="font-weight:bold">&nbsp;</td>
				<td width="60%" style="font-weight:bold">Mengetahui</td>
				<td width="7%">&nbsp;</td>
				<td width="7%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
			</tr>
			<tr>
				<td width="14%" style="font-weight:bold">&nbsp;</td>
				<td width="60%" style="font-weight:bold">Kepala Ruang </td>
				<td width="7%">&nbsp;</td>
				<td width="7%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
				<td width="6%">&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>

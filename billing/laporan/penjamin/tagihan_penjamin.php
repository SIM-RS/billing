<?php 
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
//==========Menangkap filter data====
$stsPas=$_REQUEST['StatusPas'];
if($stsPas>0) $fKso=" b_tindakan.kso_id=$stsPas AND ";
$tglAwal1=explode('-',$_REQUEST['tglAwal']);
$tglAwal=$tglAwal1[2]."-".$tglAwal1[1]."-".$tglAwal1[0];
$tglAkhir1=explode('-',$_REQUEST['tglAkhir']);
$tglAkhir=$tglAkhir1[2]."-".$tglAkhir1[1]."-".$tglAkhir1[0];
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
$hsJnsLay=mysql_fetch_array($qJnsLay);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rekap Tagihan</title>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td align="center" style="font-weight:bold">REKAP TAGIHAN<br/>
    BAGI PENDERITA <?php if($stsPas!="") echo "PESERTA ".$hsJnsLay['nama']; else echo "SEMUA PESERTA";?><br/>
    PADA <?php echo strtoupper($namaRS); ?><br />PERIODE <?php echo $tglAwal1[0]." ".$arrBln[$tglAwal1[1]]." ".$tglAwal1[2]." s/d ".$tglAkhir1[0]." ".$arrBln[$tglAkhir1[1]]." ".$tglAkhir1[2]?></td>
  </tr>
  <tr>
    <td align="center" height="50">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td style="font-weight:bold; border:solid 1px #000000" align="center">&nbsp;No&nbsp;</td>
				<td style="font-weight:bold; border:solid 1px #000000; border-left:none" align="center">&nbsp;Nama Yayasan&nbsp;</td>
				<?php
					$qJns="select t.* from (SELECT b_pelayanan.jenis_layanan,b_ms_unit.nama nama_jnsLay,SUM(biaya) biaya,SUM(bayar) bayar FROM b_tindakan INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_unit ON b_pelayanan.jenis_layanan=b_ms_unit.id WHERE ".$fKso." b_tindakan.tgl BETWEEN '$tglAwal' AND '$tglAkhir') as t where biaya>bayar GROUP BY t.jenis_layanan";
					$rsJns=mysql_query($qJns);
					while($colJns=mysql_fetch_array($rsJns)){
				?>
				<td style="font-weight:bold; border:solid 1px #000000; border-left:none" align="center">&nbsp;<?php echo $colJns['nama_jnsLay']?>&nbsp;<br />Rp.&nbsp;</td>
				<?php }?>
				<td style="font-weight:bold; border:solid 1px #000000; border-left:none" align="center">Total Tagihan Rp.</td>
			</tr>
			<?php
				$qKso=mysql_query("SELECT * from (SELECT kso_id,nama,SUM(biaya) biaya,SUM(bayar) bayar FROM b_tindakan INNER JOIN b_ms_kso ON b_tindakan.kso_id=b_ms_kso.id WHERE ".$fKso." b_tindakan.tgl BETWEEN '$tglAwal' AND '$tglAkhir') as t where biaya>bayar GROUP BY kso_id");
				while($rwKso=mysql_fetch_array($qKso)){
				$i++;
			?>
			<tr>
				<td align="center" style="border:#000000 solid 1px; border-top:none"><?php echo $i?></td>
				<td style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000">&nbsp;<?php echo $rwKso['nama']?></td>
				<?php
					$rsJns=mysql_query($qJns);
					$nTagihan=0;
					while($colJns=mysql_fetch_array($rsJns)){
						$qNilai=mysql_query("SELECT SUM(biaya-bayar) nilai FROM b_tindakan INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id WHERE jenis_layanan =".$colJns['jenis_layanan']." AND kso_id=".$rwKso['kso_id']." AND b_tindakan.tgl BETWEEN '$tglAwal' AND '$tglAkhir'");
						$colNilai=mysql_fetch_array($qNilai);
				?>
				<td align="right" style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000"><?php echo number_format($colNilai['nilai'],2,",",".")?>&nbsp;</td>
				<?php 
					$nTagihan=$nTagihan+$colNilai['nilai'];
					$jNilai[$colJns['jenis_layanan']]=$jNilai[$colJns['jenis_layanan']]+$colNilai['nilai'];
				}?>
				<td align="right" style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000"><?php echo number_format($nTagihan,2,",",".")?>&nbsp;</td>	
			</tr>
			<?php }?>
			<tr>
				<td style="border:#000000 solid 1px; border-top:none">&nbsp;</td>
				<td style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000">&nbsp;</td>
				<?php 
					$rsJns=mysql_query($qJns);
					while($colJns=mysql_fetch_array($rsJns)){
				?>
				<td align="right" style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000"><?php echo number_format($jNilai[$colJns['jenis_layanan']],2,",",".")?>&nbsp;</td>
				<?php 
					$jTagihan=$jTagihan+$jNilai[$colJns['jenis_layanan']];
					}?>
				<td align="right" style="border-bottom:#000000 solid 1px; border-right:solid 1px #000000"><?php echo number_format($jTagihan,2,",",".")?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td align="right" height="50"><?=$kotaRS?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo gmdate('F Y',mktime(date('H')+7))?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center">Mengetahui<br/>An. Direktur <?=$namaRS?><br/>Wadir Umum dan Keuangan<br/>u.b. Kabag Kauangan<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;</td>
				<td width="250"></td>
				<td align="center" valign="top"><br/>Pengaju Klaim<br/>Kasubbag Pendapatan</td>
			</tr>
			<tr>
				<td align="center"><u><?php 
				$qVal=mysql_query("SELECT nama,nip from validasi where id=1");
				$hsVal=mysql_fetch_array($qVal);
				echo $hsVal['nama'];
				?></u>&nbsp;</td>
				<td></td>
				<td align="center"><u><?php 
				$qVal=mysql_query("SELECT nama,nip from validasi where id=2");
				$hsVal1=mysql_fetch_array($qVal);
				echo $hsVal1['nama'];
				?></u></td>
			</tr>
			<tr>
				<td align="center">NIP: <?php echo $hsVal['nip']?>&nbsp;</td>
				<td></td>
				<td align="center">NIP: <?php echo $hsVal1['nip']?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>

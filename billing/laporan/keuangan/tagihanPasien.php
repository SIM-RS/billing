<?php
session_start();
include ("../koneksi/konek.php");
include("../../sesi.php");
$idKunj=$_REQUEST['idKunj'];
//session_start();

//----------------------------------

$qPas=mysql_query("SELECT no_rm,b_ms_pasien.nama nmPas,b_ms_pasien.alamat,b_ms_pasien.rt,b_ms_pasien.rw,b_ms_pasien.sex,b_ms_kelas.nama kelas,b_ms_kso.nama nmKso,DATE_FORMAT(b_kunjungan.tgl,'%d %M %Y') tglM,DATE_FORMAT(b_kunjungan.tgl_pulang,'%d %M %Y') tglP,b_ms_pasien.desa_id,b_ms_pasien.kec_id,(SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.kec_id) nmKec,(SELECT nama FROM b_ms_wilayah WHERE id=b_ms_pasien.desa_id) nmDesa,b_kunjungan.kso_id,b_kunjungan.kso_kelas_id FROM b_kunjungan INNER JOIN b_ms_pasien ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_ms_kelas ON b_kunjungan.kelas_id=b_ms_kelas.id INNER JOIN b_ms_kso ON b_kunjungan.kso_id=b_ms_kso.id WHERE b_kunjungan.id=$idKunj");
$rw=mysql_fetch_array($qPas);
$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Rekap Tagihan Pasien :.</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2"><b><br/><?=$pemkabRS?><br>
							<?=$namaRS?><br>
							<?=$alamatRS?><br>
							Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center" style="font-weight:bold"><u>&nbsp;Laporan Rincian Tagihan Pasien&nbsp;</u></td>
  </tr>
  <tr>
    <td colspan="2">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="11%">No RM</td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo $rw['no_rm']?></td>
				<td width="10%">Tgl Mulai</td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['tglM']?></td>
			</tr>
			<tr>
				<td width="11%">Nama Pasien </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo $rw['nmPas']?></td>
				<td width="10%">Tgl Selesai </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['tglP']?></td>
			</tr>
			<tr>
				<td width="11%">Alamat</td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo $rw['alamat']?></td>
				<td width="10%">Kelas</td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['kelas']?></td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>
				<td width="2%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="8%">Kel. / Desa </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;<?php echo $rw['nmDesa'];?></td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>
			</tr>
			<tr>
				<td width="11%">&nbsp;</td>
				<td width="2%" align="center" style="font-weight:bold"></td>
				<td width="8%">RT / RW </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td width="36%">&nbsp;<?php echo $rw['rt']." / ".$rw['rw'];?></td>
				<td width="10%">&nbsp;</td>
				<td width="1%" align="center" style="font-weight:bold">&nbsp;</td>
				<td width="30%"></td>
			</tr>
			<tr>
				<td width="11%">Jenis Kelamin </td>
				<td width="2%" align="center" style="font-weight:bold">:</td>
				<td colspan="3">&nbsp;<?php echo $rw['sex']?></td>
				<td width="10%">Status Pasien </td>
				<td width="1%" align="center" style="font-weight:bold">:</td>
				<td width="30%">&nbsp;<?php echo $rw['nmKso']?></td>
			</tr>
		</table>	</td>
  </tr>
  <tr>
    <td height="30" colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="border:#000000 solid 1px; font-weight:bold">Tindakan</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Tanggal</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Jumlah</td>
				<td align="center" style="border:#000000 solid 1px; border-left:none; font-weight:bold">Biaya</td>
			</tr>
			<?php 
			$qUnit=mysql_query("SELECT kunjungan_id,b_tindakan.id tindakan_id,mu.nama nmUnit,mu.id idUnit FROM b_tindakan INNER JOIN b_kunjungan ON b_tindakan.kunjungan_id=b_kunjungan.id INNER JOIN b_ms_unit mu ON b_tindakan.ms_tindakan_unit_id=mu.id WHERE b_tindakan.kunjungan_id=$idKunj group by mu.id");
			while($rwUnit=mysql_fetch_array($qUnit)){?>
			<tr>
				<td align="left" style="padding-left:25px"><?php echo $rwUnit['nmUnit']?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php $qKmr=mysql_query("SELECT tk.id,mk.id idKmr,mk.kode kdKmr,mk.nama nmKmr,mKls.nama nmKls,DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in,tk.tarip*IF(tgl_out IS NULL,DATEDIFF(NOW(),tgl_in),DATEDIFF(tgl_out,tgl_in)) biaya,IF(tgl_out IS NULL,DATEDIFF(NOW(),tgl_in),DATEDIFF(tgl_out,tgl_in)) cHari FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id=$idKunj AND mk.unit_id=".$rwUnit['idUnit']);
			while($rwKmr=mysql_fetch_array($qKmr)){
			$bKmr=$rwKmr['biaya'];
			$jKmr+=1;
			$cHari+=$rwKmr['cHari']?>
			<tr>
			  <td align="left" style="padding-left:50px">-<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rwKmr['nmKmr']?></td>
				<td align="center"><?php echo $rwKmr['tgl_in']?></td>
				<td align="center"><?php echo $rwKmr['cHari']?></td>
				<td align="right"><?php echo number_format($rwKmr['biaya'],2,",",".")?>&nbsp;</td>
			</tr>
			<?php }
			 $qKonsul=mysql_query("SELECT user_id,b_ms_pegawai.nama konsul FROM b_tindakan INNER JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id WHERE kunjungan_id=$idKunj AND b_tindakan.ms_tindakan_unit_id=".$rwUnit['idUnit']." GROUP BY b_tindakan.user_id");
			while($rwKonsul=mysql_fetch_array($qKonsul)){?>
			<tr>
				<td align="left" style="padding-left:50px"><?php echo $rwKonsul['konsul']?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php $qTind=mysql_query("SELECT DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,mt.nama nmTind,SUM(t.biaya) biaya,sum(t.bayar) bayar,COUNT(t.id) cTind FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE t.kunjungan_id=$idKunj AND t.ms_tindakan_unit_id=".$rwUnit['idUnit']." AND user_id=".$rwKonsul['user_id']." GROUP BY mtk.ms_tindakan_id");
			$sTot=0;
			while($rwTind=mysql_fetch_array($qTind)){?>
			<tr>
				<td align="left" style="padding-left:85px"><?php echo $rwTind['nmTind']?></td>
				<td align="center">&nbsp;<?php echo $rwTind['tgl']?></td>
				<td align="center">&nbsp;<?php echo $rwTind['cTind']?></td>
				<td align="right"><?php echo number_format($rwTind['biaya'],2,",",".")?>&nbsp;</td>
			</tr>
			<?php 
					$sTot+=$rwTind['biaya'];
					$sByr+=$rwTind['bayar'];
					}
			?>
			<tr>
				<td align="left" style="padding-left:60px">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Sub Total&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php echo number_format($bTot=$sTot+$bKmr,2,",",".")?>&nbsp;</td>
			</tr>
			<?php
				$sBiaya+=$bTot;
				}
				$sBayar=$sByr;
			}?>
			<tr>
				<td align="left" style="padding-left:60px; border-top:#000000 dotted 1px">&nbsp;</td>
				<td align="center" style="border-top:dotted #000000 1px">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Biaya&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php echo number_format($sBiaya,2,",",".")?>&nbsp;</td>
			</tr>
			<?php $qJam=mysql_query("SELECT jaminan FROM b_ms_kso_paket_hp WHERE b_ms_kso_id=".$rw['kso_id']." AND b_ms_kelas_id=".$rw['kso_kelas_id']);
			$rwJam= mysql_fetch_array($qJam);
			if($cHari=="" or $chari=='0')
				$cHari=1;
			else
				$cHari=$cHari-$jKmr+1?>
			<tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold">Jaminan&nbsp;</td>
				<td align="right" style="font-weight:bold"><?php echo number_format($jaminan=$cHari*$rwJam['jaminan'],2,",",".")?>&nbsp;</td>
			</tr>
			<tr>
				<td height="19" align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold">Bayar&nbsp;</td>
				<td align="right" style="font-weight:bold"><?php echo number_format($sBayar,2,",",".")?>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" style="padding-left:60px;" height="2"></td>
				<td align="center"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"></td>
			<tr>
				<td align="left" style="padding-left:60px;">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px">Kurang&nbsp;</td>
				<td align="right" style="font-weight:bold; border-top:dotted #000000 1px"><?php if($sBiaya<$jaminan) echo '0'; else echo number_format($sBiaya-$jaminan-$sBayar,2,",",".")?>&nbsp;</td>
			</tr>
		</table>	</td>
  </tr>
  <tr>
    <td height="5" colspan="2" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="653">&nbsp;</td>
    <td width="247" style="font-weight:bold"><?=$kotaRS;?>, <?php echo gmdate('d F Y',mktime(date('H')+7));?><br/>Petugas,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><?php echo $rwUsr['nama']?></td>
  </tr>
</table>
</body>
</html>

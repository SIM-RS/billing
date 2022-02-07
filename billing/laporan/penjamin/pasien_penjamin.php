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
<style>
   .withline{
   border:1px solid #000000;
   }
</style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td align="center" style="font-weight:bold">REKAPITULASI PASIEN  
      <?php if($hsJnsLay['nama']!="") echo "PESERTA ".$hsJnsLay['nama']; else echo "SEMUA PESERTA";?><br />
    PERIODE <?php echo $tglAwal1[0]." ".$arrBln[$tglAwal1[1]]." ".$tglAwal1[2]." s/d ".$tglAkhir1[0]." ".$arrBln[$tglAkhir1[1]]." ".$tglAkhir1[2]?></td>
  </tr>
  <tr>
    <td align="center" height="50">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		<table width="103%" border="0" cellpadding="0" cellspacing="0" class="withline" style="font-size:12px">
			<tr>
				<td width="4%" align="center" style="font-weight:bold; border:solid 1px #000000">No</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">No MR</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Nama&nbsp;Penderita<br/>
			  No Peserta<br/>Nama Peserta</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Nama&nbsp;Perusahaan</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Diagnosa</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">MRS</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">KRS</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Hari RWT</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Ruang RWT</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">KLS</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Kamar</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Makan</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Tindakan Non Operatif</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Jasa Visite</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Konsul Gizi</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Tindakan Operatif</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Lab.</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Rad.</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">PA</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Jumlah Tindakan</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Obat</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Jumlah Tindakan + Obat</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">PMI</td>
				<td width="13%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Jumlah</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Bayar Tunai</td>
				<td width="83%" align="center" style="font-weight:bold; border:solid 1px #000000; border-left:none">Total Biaya PX</td>
			</tr>
			<?php $qry="SELECT b_ms_pasien.no_rm,b_ms_pasien.id idPas,b_ms_pasien.nama,mkp.nama_peserta,mkp.no_anggota,md.nama nmDiag
,DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') tglM,DATE_FORMAT(b_kunjungan.tgl_pulang,'%d-%m-%Y') tglK,
DATEDIFF(b_kunjungan.tgl_pulang,b_kunjungan.tgl) hari,mk.nama kelas,mt.nama Tind,mKmr.nama kamar,b_tindakan_kamar.tarip tarifKmr,b_tindakan_kamar.bayar bayarKmr FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_diagnosa_rm ON b_pelayanan.id=b_diagnosa_rm.pelayanan_id INNER JOIN b_tindakan ON b_pelayanan.id=b_tindakan.pelayanan_id INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id=b_ms_pasien.id INNER JOIN b_ms_kso_pasien mkp ON b_pelayanan.pasien_id=mkp.pasien_id INNER JOIN b_ms_kelas mk ON mkp.kelas_id=mk.id INNER JOIN b_ms_diagnosa md ON b_diagnosa_rm.ms_diagnosa_id=md.id INNER JOIN b_ms_tindakan_kelas mtk ON b_tindakan.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id LEFT JOIN b_tindakan_kamar ON b_pelayanan.id=b_tindakan_kamar.pelayanan_id LEFT JOIN b_ms_kamar mKmr ON b_tindakan_kamar.kamar_id=mKmr.id WHERE $fKso b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' GROUP BY b_pelayanan.pasien_id";
			$rs=mysql_query($qry);
			while($rw=mysql_fetch_array($rs)){
				$i++;
				$qNilai=mysql_query("SELECT SUM(biaya) biaya,SUM(bayar) bayar,klasifikasi_id FROM b_tindakan INNER JOIN b_ms_tindakan_kelas ON b_tindakan.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id=b_ms_tindakan.id INNER JOIN b_pelayanan ON b_pelayanan.id=b_tindakan.pelayanan_id WHERE b_pelayanan.pasien_id=".$rw['idPas']." AND b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' GROUP BY klasifikasi_id");
				while($colNilai=mysql_fetch_array($qNilai)){
					$biaya[$colNilai['klasifikasi_id']]=$colNilai['biaya'];
					$bayar[$colNilai['klasifikasi_id']]=$colNilai['bayar'];
				}
			?>
			<tr>
				<td align="center" valign="top" style="border-left:1px solid #000000; border-right:1px solid #000000"><?php echo $i?></td>
				<td align="center" style="border-right:1px solid #000000" valign="top"><?php echo $rw['no_rm']?></td>
				<td align="center" style="border-right:1px solid #000000"><?php echo $rw['nama']."<br/>".$rw['no_anggota']."<br/>".$rw['nama_peserta']?>&nbsp;</td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;<?php echo $rw['nmDiag']?></td>
				<td align="center" style="border-right:1px solid #000000"><?php echo $rw['tglM']?></td>
				<td align="center" style="border-right:1px solid #000000"><?php echo $rw['tglS']?></td>
				<td align="center" style="border-right:1px solid #000000"><?php echo $rw['hari']?></td>
				<td align="left" style="border-right:1px solid #000000">&nbsp;<?php echo $rw['kamar']?></td>
				<td align="center" style="border-right:1px solid #000000"><?php echo $rw['kelas']?></td>
				<td align="right" style="border-right:1px solid #000000"><?php echo number_format($rw['tarifKmr'],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="right" style="border-right:1px solid #000000"><?php echo number_format($biaya[13],2,",",".")?></td>
				<td align="right" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($biaya[14],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($biaya[5],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($biaya[6],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="right" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($jml=$rw['tarifKmr']+$biaya[13]+$biaya[14]+$biaya[5]+$biaya[6],2,",",".")?></td>
				<td align="right" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($biaya[7],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($jml+$biaya[7],2,",",".")?></td>
				<td align="center" style="border-right:1px solid #000000">&nbsp;</td>
				<td align="right" style="border-right:1px solid #000000"><?php echo number_format($jmlBiaya=$jml+$biaya[7],2,",",".")?></td>
				<td align="right" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($jmlBayar=$rw['bayarKmr']+$bayar[13]+$bayar[14]+$bayar[5]+$bayar[6]+$bayar[7],2,",",".")?></td>
				<td align="right" style="border-right:1px solid #000000">&nbsp;<?php echo number_format($jmlBiaya-$jmlBayar,2,",",".")?></td>
			</tr>
			<?php }?>
			<tr>
				<td style="border:1px solid #000000">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
				<td style="border:1px solid #000000; border-left:none">&nbsp;</td>
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
				<td align="center" width="600">&nbsp;</td>
				<td width="350" height="250"></td>
				<td align="center" valign="top"><br/>Pengaju Klaim<br/>Kasubbag Pendapatan</td>
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
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>

<?php
session_start();
include "../sesi.php";
include ("../koneksi/konek.php");
//session_start();
//=====================================
$stsPas=$_REQUEST['stsPas'];
if($stsPas>0) $fKso=" kso_id=$stsPas AND ";
$tglAwal1=explode('-',$_REQUEST['tglAwal']);
$tglAwal=$tglAwal1[2]."-".$tglAwal1[1]."-".$tglAwal1[0];
$tglAkhir1=explode('-',$_REQUEST['tglAkhir']);
$tglAkhir=$tglAkhir1[2]."-".$tglAkhir1[1]."-".$tglAkhir1[0];
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
$hsJnsLay=mysql_fetch_array($qJnsLay);
$qUsr = mysql_query("select nama from b_ms_pegawai where id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rekap Kunjungan LAB PK</title>
</head>

<body><table width="800" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><b><br/>
      <?=$pemkabRS?><br />
      <?=$namaRS?><br>
							<?=$alamatRS?><br>
							Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td height="80" colspan="2" align="center" style="font-weight:bold">LAPORAN KUNJUNGAN LAB PK<br/>PERIODE <?php echo $tglAwal1[0]." ".$arrBln[$tglAwal1[1]]." ".$tglAwal1[2]." s/d ".$tglAkhir1[0]." ".$arrBln[$tglAkhir1[1]]." ".$tglAkhir1[2]?>&nbsp;</td>
  </tr>
  <tr>
    <td width="399" align="left" style="font-weight:bold">&nbsp;Penjamin Pasien&nbsp;:&nbsp;<?php if($stsPas==0) echo 'Semua'; else echo $rwJnsLay['nama']?></td>
    <td width="401" align="right" style="font-weight:bold">Yang Mencetak&nbsp;:&nbsp;<?php echo $rwUsr['nama']?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Jenis Layanan</td>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Tmp Layanan Asal</td>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Jml Pasien</td>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Tarif RS</td>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Bayar/Jaminan</td>
				<td align="center" style="border-bottom:#000000 solid 1px; border-top:#000000 1px solid; font-weight:bold">Piutang</td>
			</tr>
			<?php $qInd = mysql_query("SELECT parent_id parUnit,(SELECT nama FROM b_ms_unit WHERE id=parUnit) nmUnit FROM (SELECT b_pelayanan.id idPel,b_pelayanan.unit_id,IF(unit_id_asal=0,58,unit_id_asal) unit_id_asal FROM b_pelayanan INNER JOIN b_kunjungan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fKso b_pelayanan.unit_id=58 AND b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' GROUP BY unit_id_asal) tab INNER JOIN b_ms_unit ON tab.unit_id_asal=id group by parent_id");
			while($rwInd=mysql_fetch_array($qInd)){?>
			<tr>
				<td style="font-weight:bold">&nbsp;<?php echo $rwInd['nmUnit']?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php $qAsal = mysql_query("SELECT tab.*,b_ms_unit.nama,(SELECT nilai FROM b_bayar WHERE kunjungan_id=kunjId) jaminan FROM (SELECT b_pelayanan.id idPel,b_pelayanan.kunjungan_id kunjId,unit_id,IF(unit_id_asal=0,58,unit_id_asal) unit_id_asal,COUNT(pasien_id) cPas,SUM(biaya) biaya,SUM(bayar) bayar FROM b_pelayanan INNER JOIN b_tindakan ON b_pelayanan.id=b_tindakan.pelayanan_id WHERE $fKso unit_id=58 AND b_pelayanan.tgl BETWEEN '$tglAwal' AND '$tglAkhir' GROUP BY unit_id_asal) tab INNER JOIN b_ms_unit ON tab.unit_id_asal=id WHERE parent_id=".$rwInd['parUnit']);
			$sTotPas=0;
			$sTotBiaya=0;
			$sTotBayar=0;
			$sTotUtang=0;
			while($rwAsal = mysql_fetch_array($qAsal)){
			$bayar=$rwAsal['bayar']+$rwAsal['jaminan'];
			$utang=$rwAsal['biaya']-$bayar;
			?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;<?php echo $rwAsal['nama']?></td>
				<td align="center"><?php echo $rwAsal['cPas']?></td>
				<td align="right"><?php echo number_format($rwAsal['biaya'],2,",",".")?>&nbsp;</td>
				<td align="right"><?php echo number_format($bayar,2,",",".")?>&nbsp;</td>
				<td align="right"><?php echo number_format($utang,2,",",".")?>&nbsp;</td>
			</tr>
			<?php 
				$sTotPas+=$rwAsal['cPas'];
				$sTotBiaya+=$rwAsal['biaya'];
				$sTotBayar+=$bayar;
				$sTotUtang+=$utang;
			}?>
			<tr>
				<td>&nbsp;</td>
				<td style="border-top:#000000 solid 1px">Subtotal</td>
				<td align="center" style="border-top:#000000 solid 1px"><?php echo $sTotPas?></td>
				<td align="right" style="border-top:#000000 solid 1px"><?php echo number_format($sTotBiaya,2,",",".")?>&nbsp;</td>
				<td align="right" style="border-top:#000000 solid 1px"><?php echo number_format($sTotBayar,2,",",".")?>&nbsp;</td>
				<td align="right" style="border-top:#000000 solid 1px"><?php echo number_format($sTotutang,2,",",".")?>&nbsp;</td>
			</tr>
			<?php 
					$totPas+=$sTotPas;
					$totBiaya+=$sTotBiaya;
					$totBayar+=$sTotBayar;
					$totUtang+=$sTotUtang;
				}
			?>
			<tr>
				<td style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid">&nbsp;</td>
				<td style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid">Total&nbsp;</td>
				<td align="center" style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid; font-weight:bold"><?php echo $totPas?></td>
				<td align="right" style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid; font-weight:bold"><?php echo number_format($totBiaya,2,",",".")?>&nbsp;</td>
				<td align="right" style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid; font-weight:bold"><?php echo number_format($totBayar,2,",",".")?>&nbsp;</td>
				<td align="right" style="border-top:#000000 solid 1px; border-bottom:#000000 1px solid; font-weight:bold"><?php echo number_format($totUtang,2,",",".")?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

</body>
</html>
<?php 
mysql_close($konek);
?>
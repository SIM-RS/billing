<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kasus Penyakit Pasien Berdasarkan Tempat Layanan</title>
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
		$waktu = " and pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama,kode FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$tmpLayanan=$_REQUEST['TmpLayanan'];
	if($tmpLayanan != 0) {
    	$fKso = " AND un.id = $tmpLayanan ";
	}
?>
<table width="750" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="5"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="5" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Kasus Penyakit Pasien Berdasarkan Tempat Layanan</b><br /><b><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
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
    <td colspan="2">&nbsp;JUMLAH/DETIL ASAL RUJUKAN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="40%" height="28">&nbsp;TEMPAT LAYANAN</td>
    <td width="15%" style="border-left:1px solid; border-top:1px solid; text-align:right;">BARU&nbsp;</td>
    <td width="15%" style="border-left:1px solid; border-top:1px solid; text-align:right;">BELUM DIISI&nbsp;</td>
    <td width="15%" style="border-left:1px solid; border-top:1px solid; text-align:right;">LAMA&nbsp;</td>
    <td width="15%" style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;">TOTAL&nbsp;</td>
  </tr>
  <?php
		$qTmp = "SELECT un.id, un.nama
				FROM b_kunjungan k 
				INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
				INNER JOIN b_pasien_keluar pk ON pk.pelayanan_id = pl.id 
				INNER JOIN b_ms_unit un ON un.id = pl.unit_id 
				WHERE un.parent_id = '".$rwUnit1['id']."'
				$fKso $waktu 
				GROUP BY un.nama";
		$rsTmp = mysql_query($qTmp);
		$jml1 = 0;
		$jml2 = 0;
		$jml3 = 0;
		$jml4 = 0;
		while($rwTmp = mysql_fetch_array($rsTmp))
		{
			$qBaru = "SELECT COUNT(k.pasien_id) AS jml
					FROM b_kunjungan k 
					INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
					INNER JOIN b_pasien_keluar pk ON pk.pelayanan_id = pl.id 
					WHERE pk.kasus = '1' AND pl.unit_id = '".$rwTmp[id]."' $waktu ";
			$rsBaru = mysql_query($qBaru);
			$rwBaru = mysql_fetch_array($rsBaru);
			
			$qLama = "SELECT COUNT(k.pasien_id) AS jml
					FROM b_kunjungan k 
					INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
					INNER JOIN b_pasien_keluar pk ON pk.pelayanan_id = pl.id 
					WHERE pk.kasus = '0' AND pl.unit_id = '".$rwTmp[id]."' $waktu ";
			$rsLama = mysql_query($qLama);
			$rwLama = mysql_fetch_array($rsLama);
			
			$qK = "SELECT COUNT(k.pasien_id) AS jml
					FROM b_kunjungan k 
					INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
					WHERE pl.unit_id = '".$rwTmp['id']."' $waktu ";
			$rsK = mysql_query($qK);
			$rwK = mysql_fetch_array($rsK);
			
			//$jml = $jml + $rwBaru['jml'] + $rwLama['jml'];
			$tot =   $rwK['jml'] - $rwBaru['jml'] - $rwLama['jml'] ;
			
  ?>
  <tr>
    <td style="border-left:1px solid; border-top:1px solid;" height="20">&nbsp;<?php echo $rwTmp['nama'];?></td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php echo $rwBaru['jml'];?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php echo $tot;?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php echo $rwLama['jml'];?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;"><?php echo $rwK['jml']?>&nbsp;</td>
  </tr>
  <?php 
  		$jml1 = $jml1 + $rwBaru['jml'];
		$jml2 = $jml2 + $tot;
		$jml3 = $jml3 + $rwLama['jml'];
		$jml4 = $jml4 + $rwK['jml'];
		mysql_free_result($rsBaru);
		mysql_free_result($rsLama);
		mysql_free_result($rsK);
  		}
		mysql_free_result($rsTmp);
  ?>
  <tr>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;" height="20">Total&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $jml1;?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $jml2;?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $jml3;?>&nbsp;</td>
    <td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;  border-right:1px solid;"><?php echo $jml4;?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="5" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</body>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
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
</script>
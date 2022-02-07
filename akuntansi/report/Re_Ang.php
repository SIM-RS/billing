<?php
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Realisasi Anggaran</title>
</head>
<?

  include("../koneksi/konek.php");
  $mon = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
  $mon2 = array("","01","02","03","04","05","06","07","08","09","10","11","12");
  $bln = $_REQUEST['cmbBln'];$bulan = $mon[$bln]; $bulan2 = $mon2[$bln];
  $thn = $_REQUEST['cmbThn'];
?>
<body>
<table width="1200" border="0" align="center" cellpadding="2" cellspacing="0" style="font:bold 12px tahoma; text-transform:uppercase;">
  <tr>
    <td><?=$pemkabRS;?> </td>
  </tr>
  <tr>
    <td>REALISASI ANGGARAN PENDAPATAN DAN BELANJA SKPD </td>
  </tr>
  <tr>
    <td>BULAN <?=$bulan;?> <?=$thn;?></td>
  </tr>
</table>
<table width="1200" border="0" align="center" cellpadding="2" cellspacing="0" style="font:12px tahoma;">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="184">Urusan Pemerintahan </td>
    <td width="31">:</td>
    <td width="48">102 </td>
    <td width="921">Kesehatan </td>
  </tr>
  <tr>
    <td>Organisasi</td>
    <td>:</td>
    <td>102.02  </td>
    <td>Rumah Sakit Umum Daerah</td>
  </tr>
</table>
<br />
<table width="1200" border="1" align="center" cellpadding="2" cellspacing="1" style="border:1px solid #000000; border-collapse:collapse; font:12px tahoma; padding:2px;">
  <tr align="center" style="font:bold 12px tahoma; background-color:#CCCCCC;">
    <td width="124" height="36">Kode Rekening </td>
    <td width="268">Uraian</td>
    <td width="231">Jumlah Anggaran <br />
    Tahun <?=$thn;?></td>
    <?php
	for($i=1;$i<$bln;$i++){
	?>
    <td width="72">Realisasi s/d bulan <?php echo $mon[$i]." ".$thn; ?></td>
    <?php
	}
	?>
    <td width="74">Realisasi Bulan <br /><?=$bulan;?> <?=$thn;?></td>
    <td width="70">Realisasi s/d bulan <?=$bulan;?> <?=$thn;?></td>
    <td width="220">Sisa Target/<br /> Anggaran </td>
    <td width="82">Prosentase % </td>
  </tr>
  <tr align="center" style="font:12px tahoma; background-color:#DDDDDD;"> 
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <?php
	for($i=1;$i<$bln;$i++){
	?>
    <td><?php echo $i+3; ?></td>
    <?php
	}
	?>
    <td><?php echo $i+3; ?></td>
    <td><?php echo $i+4; ?></td>
    <td><?php echo $i+5; ?></td>
    <td><?php echo $i+6; ?></td>
  </tr>
  
  <?php 
  $sql = "SELECT ma_id,ma_kode,ma_nama,ma_kode2 FROM $dbanggaran.ms_ma order by ma_kode2";
  $q = mysql_query($sql);
  while($d=mysql_fetch_array($q))
  {
  $sql2 = "SELECT SUM(rba.rba_nilai)AS nilai FROM $dbanggaran.rba rba INNER JOIN $dbanggaran.ms_ma ma 
  			ON rba.ma_id=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND rba.rba_tahun='$thn'";
  $q2 = mysql_query($sql2);
  $d2=mysql_fetch_array($q2);
  
  $like = $thn."-".$bulan2;
  $sql3 = "SELECT SUM(t.nilai) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
  			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND t.tgl LIKE '$like%'";
  $q3 = mysql_query($sql3);
  $d3=mysql_fetch_array($q3);
  
  ?>
  <tr>
    <td><?=$d['ma_kode'];?></td>
    <td><?=$d['ma_nama'];?></td>
    <td align="right"><?=number_format($d2['nilai'],2,",",".");?></td>
    <?php
	for($i=1;$i<$bln;$i++){
	$sNil="SELECT SUM(t.nilai) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND MONTH(t.tgl) BETWEEN '1' AND '".$i."' AND YEAR(t.tgl)='".$thn."'";
	$qNil=mysql_query($sNil);
	$rwNil=mysql_fetch_array($qNil);
	?>
    <td align="right"><?=number_format($rwNil['nilai'],2,",",".");?></td>
    <?php
	}
	?>
    <td align="right"><?=number_format($d3['nilai'],2,",",".");?></td>
    <?php
    $sCNil="SELECT SUM(t.nilai) AS nilai FROM $dbkeuangan.k_transaksi t inner join $dbanggaran.ms_ma ma 
			ON t.id_ma_dpa=ma.ma_id WHERE ma.ma_kode2 like '$d[ma_kode2]%' AND MONTH(t.tgl) BETWEEN '1' AND '".$bln."' AND YEAR(t.tgl)='".$thn."'";
	$qCNil=mysql_query($sCNil);
	$rwCNil=mysql_fetch_array($qCNil);
	?>
    <td align="right"><?=number_format($rwCNil['nilai'],2,",",".");?></td>
    <?php
	  $selisih = $d2['nilai']-$rwCNil['nilai'];
	  if($d2['nilai']==0)
	  {
		$prosentase="0";
	  }
	  else
	  {
		$prosentase = ($selisih/$d2['nilai'])*100;
	  }
	?>
    <td align="right"><?=number_format($selisih,2,",",".");?></td>
    <td align="right"><? printf("%.2f",$prosentase);?></td>
  </tr>
  <?
  }
  ?>
</table>
<br />
<table width="695" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td><div align="center"><button onclick="window.open('../report/Re_Ang_excell.php?cmbBln=<?=$bln?>&cmbThn=<?=$thn;?>')"><img src="../icon/addcommentButton.jpg" width="17" height="17" align="left" />&nbsp;EXPORT ke EXCELL</button></div>
	</td>
  </tr>
</table>
</body>
</html>

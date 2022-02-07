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
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0" style="font:bold 12px tahoma; text-transform:uppercase;">
  <tr>
    <td width="1012"><?=$pemkabRS;?> </td>
  </tr>
  <tr>
    <td>REALISASI ANGGARAN PENDAPATAN DAN BELANJA SKPD </td>
  </tr>
  <tr>
    <td>BULAN <?=$bulan;?> <?=$thn;?></td>
  </tr>
</table>
<table width="989" border="0" align="center" cellpadding="2" cellspacing="0" style="font:12px tahoma;">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="184">Urusan Pemerintahan </td>
    <td width="31">:</td>
    <td width="48">102 </td>
    <td width="734">Kesehatan </td>
  </tr>
  <tr>
    <td>Organisasi</td>
    <td>:</td>
    <td>102.02  </td>
    <td>Rumah Sakit Umum Daerah</td>
  </tr>
</table>
<br />
<table width="989" border="1" align="center" cellpadding="2" cellspacing="1" style="border:1px solid #000000; border-collapse:collapse; font:12px tahoma; padding:2px;">
  <tr align="center" style="font:bold 12px tahoma;" class="headtable">
    <td width="150" height="36" class="tblheaderkiri">Kode Rekening </td>
    <td width="363" class="tblheader">Uraian</td>
    <td width="190" class="tblheader">Jumlah Anggaran <br />
    Tahun <?=$thn;?></td>
    <td width="190" class="tblheader">Realisasi Bulan <br />
    <?=$bulan;?> <?=$thn;?></td>
    <td width="190" class="tblheader">Sisa Target/<br />
    Anggaran </td>
    <td width="74" class="tblheader">Prosentase % </td>
  </tr>
  <tr align="center" style="font:12px tahoma;"> 
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
  </tr>
  
  <? 
  $sql = "SELECT ma_id,ma_kode,ma_nama FROM dbanggaran.ms_ma";
  $q = mysql_query($sql);
  while($d=mysql_fetch_array($q))
  {
  $sql2 = "SELECT SUM(rba_nilai)AS nilai FROM dbanggaran.rba WHERE ma_id='$d[ma_id]' AND rba_tahun='$thn'";
  $q2 = mysql_query($sql2);
  $d2=mysql_fetch_array($q2);
  
  $like = $thn."-".$bulan2;
  $sql3 = "SELECT SUM(nilai)AS nilai FROM keuangan.k_transaksi WHERE id_ma_dpa='$d[ma_id]' AND tgl LIKE '$like%'";
  $q3 = mysql_query($sql3);
  $d3=mysql_fetch_array($q3);
  
  $selisih = $d2['nilai']-$d3['nilai'];
  if($d2['nilai']==0)
  {
  	$prosentase="0";
  }
  else
  {
  	$prosentase = ($selisih/$d2['nilai'])*100;
	}
  ?>
  <tr>
    <td><?=$d['ma_kode'];?></td>
    <td><?=$d['ma_nama'];?></td>
    <td align="right"><?=number_format($d2['nilai'],0,",",".");?></td>
    <td align="right"><?=number_format($d3['nilai'],0,",",".");?></td>
    <td><?=number_format($selisih,0,",",".");?></td>
    <td><? printf("%.2f",$prosentase);?></td>
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

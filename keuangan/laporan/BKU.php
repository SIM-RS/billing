<?php 
include("../sesi.php");
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Laporan BKU :.</title>
</head>

<body>
<?
include("../koneksi/konek.php");
$tglAwal = $_REQUEST['tglAwal']; $t1 = explode('-',$tglAwal);
$tgl1 = $t1[2]."-".$t1[1]."-".$t1[0];

$tglAkhir = $_REQUEST['tglAkhir']; $t2 = explode('-',$tglAkhir);
$tgl2 = $t2[2]."-".$t2[1]."-".$t2[0];

$btw = "WHERE k_t.tgl BETWEEN '$tgl1' AND '$tgl2'";

$tipe_trans=$_REQUEST['cmbTipeTrans'];
if($tipe_trans=='0'){
	$ftipe="";	
}
else{
	if($tipe_trans=='1'){
		$ftipe="AND k_t.tipe_trans=".$tipe_trans."";
	}
	else if($tipe_trans=='2'){
		$ftipe="AND k_t.tipe_trans<>'1'";	
	}
}
?>
<br />
<div align="center" style="font:bold 14px tahoma; text-transform:uppercase">LAPORAN BKU <br />
PERIODE <?=$tglAwal;?> s/d <?=$tglAkhir;?></div>
<br />
<table width="1382" border="1" align="center" cellpadding="2" cellspacing="0" style="border:1px solid #000000; border-collapse:collapse; font:12px tahoma;">
  <tr style="font:bold 12px tahoma; text-align:center; background-color:#66FFCC; padding:5px;">
    <td width="50" height="30">No.<br />
    Urut</td>
    <td width="111">Tanggal</td>
    <td width="176">No Bukti</td>
    <td width="176">Kode Rekening </td>
    <td width="525">Uraian</td>
    <td width="150">Penerimaan<br />
    (Rp.)</td>
    <td width="150">Pengeluaran<br />
    (Rp.)</td>
  </tr>
  <tr style="font:bold 12px tahoma; text-align:center; padding:5px; background:#EEEEEE;">
    <td>1</td>
    <td>2</td>
    <td>&nbsp;</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
  </tr>
  <?
$i=1;
$sql = "SELECT k_t.id_trans,
k_t.tgl, 
DATE_FORMAT(k_t.tgl,'%d-%m-%Y')AS tgl2,k_t.no_bukti, 
ma.ma_kode, k_t.id_ma_dpa,m_tr.nama,k_t.ket,
m_tr.tipe, 
k_t.nilai,

IF(k_t.tipe_trans='1',k_t.nilai,0) AS pen,
IF(k_t.tipe_trans<>'1',k_t.nilai,0) AS peng, 

CASE m_tr.tipe 
WHEN '1' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai)
WHEN '3' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai)
ELSE NULL END AS PENERIMAAN, 

CASE m_tr.tipe 
WHEN '2' THEN IF(k_td.unit_id IS NULL,k_t.nilai,k_td.nilai) 
ELSE NULL END AS PENGELUARAN,

IFNULL(k_td.unit_id,0) unit_id,
k_td.nilai,
k_td.pajak_id,

IF(k_td.unit_id='0',(SELECT MA_NAMA FROM $dbakuntansi.ma_sak WHERE MA_ID=k_td.pajak_id),(SELECT nama FROM $dbakuntansi.ak_ms_unit WHERE id=k_td.unit_id)) AS ket2,
IF(k_td.unit_id IS NULL,CONCAT(IFNULL(m_tr.nama,''),' (',k_t.ket,')'),CONCAT(IFNULL(m_tr.nama,k_t.ket),' - ',(SELECT nama FROM $dbakuntansi.ak_ms_unit WHERE id=k_td.unit_id))) AS URAIAN3

FROM $dbkeuangan.k_transaksi AS k_t LEFT JOIN 
$dbkeuangan.k_ms_transaksi m_tr ON m_tr.id=k_t.id_trans LEFT JOIN 
$dbanggaran.ms_ma AS ma ON ma.ma_id=k_t.id_ma_dpa LEFT JOIN 
$dbkeuangan.k_transaksi_detail AS k_td ON k_td.transaksi_id=k_t.id $btw $ftipe AND k_t.flag = '$flag' ORDER BY k_t.tgl";
//echo $sql;
$q = mysql_query($sql);
while($d = mysql_fetch_array($q))
{
	$namaTrans=$d['nama']." (".$d['ket'].")";
	if (($d['tipe']==1 || $d['tipe']==3) && $d['URAIAN3']!=""){
		$namaTrans=$d['URAIAN3'];
	}elseif ($d['unit_id']>0){
		$namaTrans=$d['URAIAN3'];
	}
  ?>
  <tr style="padding:2px;">
    <td align="center"><?=$i;?></td>
    <td align="center"><?=$d['tgl2'];?></td>
    <td align="center"><?=$d['no_bukti'];?></td>
    <td><?=$d['ma_kode'];?></td>
    <td><?=$namaTrans;?></td>
    <td align="right"><?=number_format($d['pen'],0,",",".");?></td>
    <td align="right"><?=number_format($d['peng'],0,",",".");?></td>
  </tr>
<?
$i++;
}
?>
</table>
<br /><br /><div align="center"><button onclick="window.open('BKU_excell.php?tglAwal=<?=$tglAwal;?>&tglAkhir=<?=$tglAkhir;?>&tipe_trans=<?=$tipe_trans;?>')"><img src="../icon/addcommentButton.jpg" width="17" height="17" align="left" />&nbsp;EXPORT ke EXCELL</button>
</div>
<br />
</body>
</html>

<?php
include("../sesi.php");
if($_REQUEST['expor']=='excel'){
	header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Penerimaan Klaim KSO.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Penerimaan Klaim KSO</title>
</head>

<body>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="3"><b>
		  <?=$pemkabRS;?>
          <br />
          <?=$namaRS;?>
          <br />
          <?=$alamatRS;?>
          <br />
Telepon
<?=$tlpRS;?>
        </b></td>
	</tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<table width="1000" cellspacing="0" cellpadding="0">
  <tr>
	<td colspan="8" align="center" style="font-weight:bold; font-size:14px">LAPORAN PENERIMAAN KLAIM KSO</td>
  </tr>
   <tr>
	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td width="30" style="border-left:1px solid; border-bottom:1px solid; border-top:1px solid; border-right:1px solid; text-align:center">No</td>
    <td width="100" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">Tgl Penerimaan</td>
    <td width="100" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">Tgl Klaim</td>
    <td width="120" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">No Pengajuan Klaim</td>
    <td width="120" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">No Penerimaan klaim</td>
    <td style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">KSO</td>
    <td width="100" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">Nilai</td>
    <td width="150" style=" border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center">Ket</td>
  </tr>
  <?php
  include("../koneksi/konek.php");
$sql="SELECT 
  * 
FROM
  (SELECT 
    t.id,
    kso.id ksoId,
    DATE_FORMAT(t.tgl, '%d-%m-%Y') tgl,
    DATE_FORMAT(t.tgl_klaim, '%d-%m-%Y') tglKlaim,
    t.no_faktur noKlaim,
    t.no_bukti,
    kso.nama,
    t.nilai,
    t.ket 
  FROM
    k_transaksi t 
    INNER JOIN k_ms_transaksi mt 
      ON mt.id = t.id_trans 
    INNER JOIN $dbbilling.b_ms_kso kso 
      ON t.kso_id = kso.id 
  WHERE mt.tipe = '3' 
    AND MONTH(t.tgl) = '".$_REQUEST['bln']."' 
    AND YEAR(t.tgl) = '".$_REQUEST['thn']."') t1
";
$kueri=mysql_query($sql);
$no=1;
$total=0;
while($row=mysql_fetch_array($kueri)){
?>
  <tr>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:12px;"><?php echo $no; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:12px;"><?php echo $row['tgl']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:12px;"><?php echo $row['tglKlaim']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:12px;"><?php echo $row['noKlaim']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:center; font-size:12px;"><?php echo $row['no_bukti']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:left; font-size:12px;">&nbsp;<?php echo $row['nama']; ?></td>
    <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; font-size:12px;"><?php echo number_format($row['nilai'],2,',','.'); ?>&nbsp;</td>
    <td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left; font-size:12px;"><?php echo $row['ket']; ?></td>
  </tr>
  
  <?php
  $no++;
  $total=$total+$row['nilai'];
}
  ?>
  <tr>
    <td colspan="6" align="right">Total :&nbsp;</td>
	<td align="right" style="font-weight:bold; font-size:12px;"><?php echo number_format($total,2,',','.'); ?>&nbsp;</td>
    <td></td>
  </tr>
</table>
</body>
</html>
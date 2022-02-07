<?php
include '../sesi.php';
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];

switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_GET['bln'] and $_GET['thn']<>'')$filter2=" where MONTH(msk.tgl_terima)=".$_GET['bln']." AND YEAR(msk.tgl_terima)=".$_GET['thn']; else $filter2="where MONTH(msk.tgl_terima)=$bln AND YEAR(msk.tgl_terima)=$thn";

$title="Rekap Penerimaan Gudang";

function ifBlankNbsp($value){
    return ($value=='')?'&nbsp':$value;
    //return $value;
}

$bln = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
$bulan = $bln[$_GET['bln']];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<style>

@media print
{
	.noprint
	{
		display: none;
	}
}

</style>
<body>
<table width="940" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="center" style="font:bold 14px tahoma; text-transform:uppercase;">
		REKAP PENERIMAAN GUDANG<br />
     	BULAN <?=$bulan;?> <?=$_REQUEST['thn'];?><p>&nbsp; </p>
    </div></td>
  </tr>
</table>
<br />
<table width="940" border="1" cellpadding="1" cellspacing="0" align="center" style="font:12px tahoma; border-collapse:collapse;">
  
  <tr style="background-color:#DDDDDD; font-weight:bold;">
    <td width="40" height="24"><div align="center">NO</div></td>
    <td width="106"><div align="center">TANGGAL</div></td>
    <td width="169"><div align="center">NO.GUDANG</div></td>
    <td width="217"><div align="center">NO PO </div></td>
    <td width="86"><div align="center">NO FAKTUR </div></td>
    <td width="168"><div align="center">REKANAN</div></td>
    <td width="124"><div align="center">NILAI</div></td>
  </tr>
  <?php
  $sData = "select date_format(msk.tgl_terima,'%d-%m-%Y')as tgl_terima,msk.no_gudang, po.no_po,msk.no_faktur,rek.namarekanan,SUM(msk.jml_msk * msk.harga_unit) AS nilai
	from as_masuk msk left join as_po po on msk.po_id=po.id left join as_ms_rekanan rek on rek.idrekanan=po.vendor_id 
	$filter2 group by msk.tgl_terima,msk.no_gudang,po.no_po,msk.no_faktur
	order by msk.tgl_terima,msk.no_gudang";

//echo $sData;
$rsData = mysql_query($sData);
$i=0;
$total=0;
while($rwData=mysql_fetch_array($rsData)){
    
    $total+=$rwData['nilai'];
    $i++;
    ?>

  <tr>
    <td><span style="text-align:center; padding-left:3px;"><?php echo $i;?>.</span></td>
    <td><span style="text-align:left; padding-left:3px;"><?php echo $rwData['tgl_terima'];?></span></td>
    <td><div align="center"><span style="text-align:left; padding-left:3px;"><?php echo $rwData['no_gudang'];?></span></div></td>
    <td><span style="text-align:left; padding-left:3px;"><?php echo $rwData['no_po'];?></span></td>
    <td><div align="center"><span style="text-align:left; padding-left:3px;"><?php echo $rwData['no_faktur'];?></span></div></td>
    <td><span style="text-align:left; padding-left:3px;"><?php echo $rwData['namarekanan'];?></span></td>
    <td><div align="right"><span style="text-align:left; padding-left:3px;"><?php echo number_format($rwData['nilai'],0,",",".").'&nbsp';?></span></div></td>
  </tr>
  <?php
  }
  ?>
  <tr style="font-weight:bold;">
    <td style="border-bottom:0px; border-left:0px;" colspan="6"><div align="right">TOTAL</div></td>
    <td><div align="right"><span style="text-align:left; padding-left:3px;"><?php echo number_format($total,0,",",".").'&nbsp';?></span></div></td>
  </tr>
</table>
<br />
<table width="940" border="0" align="center" class="noprint">
  <tr>
    <td align="center">
	<button type="reset" class="Enabledbutton" id="backbutton" onClick="window.print()" title="Print" style="cursor:pointer">
    <img alt="cancel" src="../icon/printButton.jpg" width="22" height="22" border="0" align="absmiddle" />Print</button>
	</td>
  </tr>
</table>
</body>
</html>

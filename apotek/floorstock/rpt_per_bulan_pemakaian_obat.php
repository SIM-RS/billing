<?php
include("../sesi.php"); 
include("../koneksi/konek.php"); 

function getBulan($bln){
	if($bln=='01'){
		$bl='Januari';
	}else if($bln=='02'){
		$bl='Februari';
	}else if($bln=='03'){
		$bl='Maret';
	}else if($bln=='04'){
		$bl='April';
	}else if($bln=='05'){
		$bl='Mei';
	}else if($bln=='06'){
		$bl='Juni';
	}else if($bln=='07'){
		$bl='Juli';
	}else if($bln=='08'){
		$bl='Agustus';
	}else if($bln=='09'){
		$bl='September';
	}else if($bln=='10'){
		$bl='Oktober';
	}else if($bln=='11'){
		$bl='November';
	}else if($bln=='12'){
		$bl='Desember';
	}
	return $bl;
}

if($_REQUEST['tipe_lap']==2){
	$bln1 = $_REQUEST['bln1'];
	$thn1 = $_REQUEST['thn1'];
	$bln2 = $_REQUEST['bln2'];
	$thn2 = $_REQUEST['thn2'];

	$periode = "Bulan : ".getBulan($bln1)." ".$thn1." s/d ".getBulan($bln2)." ".$thn2." "; 	
	$fperiode = "AND DATE_FORMAT(ap.TANGGAL,'%Y-%m') BETWEEN '$thn1-$bln1' AND '$thn2-$bln2'";
}

	

/////////////////////
?>
<?php
$kepemilikan_id = $_REQUEST['kepemilikan_id'];
if($kepemilikan_id==""){
$kepemilikan = "SEMUA";
$fKep="";
}
else{
$sKep = "SELECT * FROM a_kepemilikan WHERE ID=".$kepemilikan_id;
$qKep = mysqli_query($konek,$sKep);
$rKep = mysqli_fetch_array($qKep);
$kepemilikan = $rKep['NAMA'];
$fKep=" AND ap.KEPEMILIKAN_ID = $kepemilikan_id";
}

$unit_id = $_REQUEST['idunit'];
if($unit_id==""){
$ruangan = "SEMUA";
$fUnit="";
}
else{
$sUnit = "SELECT * FROM a_unit WHERE UNIT_ID=".$unit_id;
$qUnit = mysqli_query($konek,$sUnit);
$rUnit = mysqli_fetch_array($qUnit);
$ruangan = $rUnit['UNIT_NAME'];
$fUnit=" AND a_unit.UNIT_ID = $unit_id";
}

$golongan_id = $_REQUEST['golongan_id'];
if($golongan_id==""){
$golongan = "SEMUA";
$fGol="";
}
else{
$sGol = "SELECT * FROM a_obat_golongan WHERE kode='".$golongan_id."'";
$qGol = mysqli_query($konek,$sGol);
$rGol = mysqli_fetch_array($qGol);
$golongan = $rGol['golongan'];
$fGol=" AND ao.OBAT_GOLONGAN = '$golongan_id'";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style.css" type="text/css" />
<title>Ruangan <?php echo $ruangan; ?></title>
</head>

<body>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td class="textJdl1">DATA TOTAL PEMAKAIAN OBAT / ALKES RUANGAN</td>
</tr>
<tr>
	<td class="textJdl1">KEPEMILIKAN : <?php echo $kepemilikan; ?></td>
</tr>
<tr>
	<td class="textJdl1">UNIT : <?php echo $ruangan; ?></td>
</tr>
<tr>
	<td class="textJdl1">GOLONGAN : <?php echo $golongan; ?></td>
</tr>
<tr>
	<td class="textJdl1"><?=$periode ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<?php
$arrBln = array();

$sql = "SELECT PERIOD_DIFF($thn2$bln2,$thn1$bln1)";
$kueri = mysqli_query($konek,$sql);
$jbln = mysqli_fetch_array($kueri);

$jum_bln = $jbln[0];
$jum_bln = $jum_bln+1;

$bulan = $bln1;
$tahun = $thn1;

$b = strtoupper(getBulan($bulan));
$alias = substr("$b",0,3)."_".$tahun;
$ct = "SUM(IF(DATE_FORMAT(ap.TANGGAL,'%m-%Y')='$bulan-$tahun',ap.QTY_SATUAN,'0')) AS ".$alias;
array_push($arrBln,$alias);

for($i=1;$i<$jum_bln;$i++){
	$Add = "SELECT PERIOD_ADD($tahun$bulan,1)";
	$qAdd = mysqli_query($konek,$Add);
	$rAdd = mysqli_fetch_array($qAdd);
	$result = $rAdd[0];
	
	$bulan = substr($result,4,2);
	$tahun = substr($result,0,4);

	$b = strtoupper(getBulan($bulan));
	$alias = substr("$b",0,3)."_".$tahun;
	$ct = $ct.",SUM(IF(DATE_FORMAT(ap.TANGGAL,'%m-%Y')='$bulan-$tahun',ap.QTY_SATUAN,'0')) AS ".$alias;
	array_push($arrBln,$alias); 
}
//echo $ct;
//print_r($arrBln);

$sql = "SELECT 
  a_unit.UNIT_ID,
  a_unit.UNIT_NAME,
  ao.OBAT_ID,
  ao.OBAT_NAMA,
  $ct
FROM
  a_penerimaan ap 
  INNER JOIN a_obat ao 
    ON ap.obat_id = ao.OBAT_ID 
  INNER JOIN a_unit 
    ON ap.UNIT_ID_TERIMA = a_unit.UNIT_ID 
  INNER JOIN a_penjualan p 
    ON ap.ID = p.PENERIMAAN_ID 
WHERE ap.UNIT_ID_KIRIM = 20 
  AND ap.TIPE_TRANS = 1 
  AND a_unit.UNIT_TIPE = 3
  $fKep
  $fGol
  $fUnit 
  $fperiode 
GROUP BY ap.OBAT_ID
ORDER BY ao.OBAT_NAMA";
$queri = mysqli_query($konek,$sql);
?>
<tr bgcolor="#CCCCCC">
	<td width="52" class="headerKiri" align="center">NO</td>
	<td width="350" class="header" align="center">OBAT</td>
    <?php
	for($b=0;$b<count($arrBln);$b++){
	?>
	<td class="header" align="center"><?php echo $arrBln[$b]; ?></td>
    <?php
	}
	?>
	<td width="60" class="header" align="center">TOTAL</td>
</tr>
<?php
$no=0;
while($rows=mysqli_fetch_array($queri)){
$no++;
?>
<tr>
	<td class="jdlkiri" align="center"><?php echo $no; ?></td>
	<td class="jdl" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
	<?php
	$tot=0;
	for($b=0;$b<count($arrBln);$b++){
	$arrB =  $arrBln[$b];
	?>
	<td width="109" class="jdl" align="center"><?php echo $rows[$arrB]; ?></td>
    <?php
	$tot = $tot + $rows[$arrB];
	}
	?>
	<td class="jdl" align="right"><?php echo number_format($tot,0,',','.'); ?>&nbsp;</td>
</tr>
<?php
}
?>
</table>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="right" style="padding-right:35px"><?=$kotaRS;?>, <?php echo date('d-m-Y'); ?></td>
</tr>
<tr>
	<td align="right" style="padding-right:60px">Mengetahui,</td>
</tr>
<tr>
	<td align="right" style="padding-right:60px">Ka. Ruangan</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="right" style="padding-right:10px">( ....................................... )</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center"><button onclick="goExcell()">Export ke Excell</button></td>
</tr>

</table>
</body>
</html>
<script>
function goExcell()
{
	window.open('rpt_per_bulan_pemakaian_obat_XLS.php?bln1=<?=$bln1;?>&thn1=<?=$thn1;?>&bln2=<?=$bln2;?>&thn2=<?=$thn2;?>&idunit=<?=$unit_id;?>&tipe_lap=<?=$_REQUEST['tipe_lap'];?>&kepemilikan_id=<?php echo $_REQUEST['kepemilikan_id']; ?>&golongan_id=<?php echo $_REQUEST['golongan_id']; ?>');
}
</script>
<?php
include("../sesi.php"); 
include("../koneksi/konek.php"); 

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

function tgl2Text($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[0].' '.getBulan($t[1]).' '.$t[2];
   return $t;
}

function tgl2As($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'_'.strtoupper(substr(getBulan($t[1]),0,3));
   //$t=$t[2].'/'.$t[1].'/'.$t[0];
   return $t;
}

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

if($_REQUEST['tipe_lap']==1){
	$tgl_1 = $_REQUEST['tgl_d'];
	$tgl_2 = $_REQUEST['tgl_s'];

	$periode = "Tanggal : ".tgl2Text($tgl_1)." s/d ".tgl2Text($tgl_2)." "; 	
}

/////////////////////
?>
<?php
$unit_farmasi = $_REQUEST['unit_farmasi'];
if($unit_farmasi==""){
$farmasi="ALL UNIT";
$fFarmasi="";	
}
else{
$sFarmasi = "SELECT * FROM a_unit WHERE UNIT_ID=".$unit_farmasi;
$qFarmasi = mysqli_query($konek,$sFarmasi);
$rFarmasi = mysqli_fetch_array($qFarmasi);
$farmasi = $rFarmasi['UNIT_NAME'];
$fFarmasi=" AND p.UNIT_ID = $unit_farmasi";		
}

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
$fUnit=" AND p.RUANGAN = $unit_id";
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
	<td class="textJdl1">UNIT FARMASI : <?php echo $farmasi; ?></td>
</tr>
<tr>
	<td class="textJdl1">KEPEMILIKAN : <?php echo $kepemilikan; ?></td>
</tr>
<tr style="display:none">
	<td class="textJdl1">RUANGAN : <?php echo $ruangan; ?></td>
</tr>
<tr>
	<td class="textJdl1">GOLONGAN : <?php echo $golongan; ?></td>
</tr>
<tr>
	<td class="textJdl1"><?=$periode ?></td>
</tr>
<tr>
	<td class="textJdl1">&nbsp;</td>
</tr>
</table>
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<?php
$arrHari = array();

$tgl1=tglSQL($tgl_1);
$tgl2=tglSQL($tgl_2);

$fperiode = "AND p.TGL BETWEEN '$tgl1' AND '$tgl2'";

$sql = "SELECT DATEDIFF('$tgl2','$tgl1')";
$fTGL = " WHERE TGL BETWEEN '$tgl1' AND '$tgl2' ";
$kueri = mysqli_query($konek,$sql);
$jhari = mysqli_fetch_array($kueri);

$jum_hari = $jhari[0];
$jum_hari = $jum_hari+1;

$ct = "SUM(IF(p.TGL='$tgl1',p.QTY_JUAL,'0')) AS ".tgl2As($tgl1);
array_push($arrHari,tgl2As($tgl1));

for($i=1;$i<$jum_hari;$i++){
	$Add = "SELECT DATE_ADD('$tgl1',INTERVAL 1 DAY)";
	$qAdd = mysqli_query($konek,$Add);
	$rAdd = mysqli_fetch_array($qAdd);
	$result = $rAdd[0];
	
	$tgl1 = $result;
	
	$ct = $ct.",SUM(IF(p.TGL='$tgl1',p.QTY_JUAL,'0')) AS ".tgl2As($tgl1);
	array_push($arrHari,tgl2As($tgl1));
}

//echo $ct;
$sql="SELECT 
  u.UNIT_ID,
  u.UNIT_NAME,
  au.UNIT_ID AS ID_RUANGAN,
  au.UNIT_NAME AS RUANGAN,
  ao.OBAT_ID,
  ao.OBAT_NAMA,
  $ct
FROM
  (SELECT * FROM a_penjualan $fTGL) p 
  INNER JOIN a_penerimaan ap 
    ON ap.ID = p.PENERIMAAN_ID 
  INNER JOIN a_obat ao 
    ON ap.obat_id = ao.OBAT_ID 
  left JOIN a_unit au 
    ON p.RUANGAN = au.UNIT_ID 
  INNER JOIN a_unit u 
    ON u.UNIT_ID = p.UNIT_ID 
WHERE 0=0
  $fFarmasi
  $fKep
  $fGol
  $fUnit   
GROUP BY ao.OBAT_ID 
ORDER BY ao.OBAT_NAMA";
//echo $sql;
$query=mysqli_query($konek,$sql);
?>
<tr bgcolor="#CCCCCC">
	<td width="52" class="headerKiri" align="center">NO</td>
	<td width="123" class="header" align="center">OBAT</td>
    <?php
	for($h=0;$h<count($arrHari);$h++){
	?>
	<td width="109" class="header" align="center"><?php echo $arrHari[$h]; ?></td>
	<?php
	}
	?>
    <td width="60" class="header" align="center">TOTAL</td>
</tr>
<?php
$no=0;
while($rows=mysqli_fetch_array($query)){
$no++;
?>
<tr>
	<td class="jdlkiri" align="center"><?php echo $no; ?></td>
	<td class="jdl" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
    <?php
	$tot = 0;
	for($h=0;$h<count($arrHari);$h++){
	?>
	<td class="jdl" align="center"><?php echo $rows[$arrHari[$h]]; ?></td>
	<?php
	$tot = $tot + $rows[$arrHari[$h]];
	}
	?>
    <td class="jdl" align="right"><?php echo number_format($tot,0,',','.'); ?>&nbsp;</td>
</tr>
<?php
}
?>
</table>
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
	<td align="center"><button onclick="goExcell()">Export ke Excell</button></td>
</tr>

</table>
</body>
</html>
<script>
function goExcell()
{
	window.open('rpt_per_tanggal_pemakaian_obat_XLS.php?tgl_d=<?=$tgl_1;?>&tgl_s=<?=$tgl_2;?>&idunit=<?=$unit_id;?>&tipe_lap=<?=$_REQUEST['tipe_lap'];?>&kepemilikan_id=<?php echo $_REQUEST['kepemilikan_id']; ?>&golongan_id=<?php echo $_REQUEST['golongan_id']; ?>&unit_farmasi=<?php echo $unit_farmasi; ?>');
}
</script>
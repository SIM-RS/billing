<body bgcolor="transparance">
<script>
//jQuery("#smeninggal").val("0");
document.getElementById("btnMRS").disabled = false;
document.getElementById("btnSetKamar").disabled = false;
document.getElementById("btnRujukUnit").disabled = false
</script>
<?
include("../koneksi/konek.php");
$id = $_REQUEST['id_pasien'];

$qdarah = "SELECT * FROM b_ms_pasien where id = '$id'";
$rdarah = mysql_query($qdarah);
$ddarah = mysql_fetch_array($rdarah);


$qiddarah = "SELECT * FROM $dbbank_darah.bd_ms_gol_darah WHERE golongan = '$ddarah[gol_darah]'";
$riddarah = mysql_query($qiddarah);
while($diddarah = mysql_fetch_array($riddarah))
{
	?>
    <script>
		jQuery("#golongan").val('<? echo $diddarah['id'];?>');
	</script>
    <?
}

$query12 = "SELECT DISTINCT ab.kdg_id FROM b_diagnosa a INNER JOIN b_kunjungan b ON a.kunjungan_id = b.id
INNER JOIN b_ms_diagnosa ab ON a.ms_diagnosa_id = ab.id 
INNER JOIN b_ms_pasien ac ON b.pasien_id = ac.id
WHERE b.pasien_id = '$id' AND ab.kdg_id <> 0
ORDER BY ab.kdg_id";
$rquery12=mysql_query($query12);

while($dquery12 = mysql_fetch_array($rquery12))
{
	$quert = "SELECT * FROM b_ms_diagnosa_gambar WHERE kdg_id = $dquery12[kdg_id]";
	$rquert = mysql_query($quert);
	$dquert = mysql_fetch_array($rquert);
	?>
	<img style="cursor:pointer;" title="<? echo $dquert['kdg_nama'];?>" class='makezoom' <?php echo "width='30' height='30'"; ?> src='foto_diagnosa.php?id=<?=$dquery12['kdg_id'];?>' >
	<?
}
$query122 = "SELECT * FROM b_ms_pasien WHERE meninggal = 1 AND id = '$id'";
$rquery122 = mysql_query($query122);
while($dquery122 = mysql_fetch_array($rquery122))
{
	?>
     <script>
	 	document.getElementById("btnMRS").disabled = true;
		document.getElementById("btnSetKamar").disabled = true;
		if(document.getElementById("cmbJnsLay").options[document.getElementById("cmbJnsLay").options.selectedIndex].lang==0)
		{
			document.getElementById("btnRujukUnit").disabled = true;
		}else{
			document.getElementById("btnRujukUnit").disabled = false;
		}
		document.getElementById("btnRujukUnit").disabled = true;
		jQuery("#smeninggal").val("1");
	</script>
	<img style="cursor:pointer;" title="Meninggal" class='makezoom' <?php echo "width='30' height='30'"; ?> src='foto_diagnosa.php?id=5' >
	<?
}
$query1222 = "SELECT * FROM b_riwayat_alergi WHERE pasien_id = '$id' LIMIT 1";
$rquery1222 = mysql_query($query1222);
while($dquery1222 = mysql_fetch_array($rquery1222))
{
	?>
	<img style="cursor:pointer;" title="Alergi" class='makezoom' <?php echo "width='60' height='30'"; ?> src='foto_diagnosa.php?id=4' >
	<?
}
$qstatus = "SELECT * FROM b_ms_pasien WHERE id = '$id'";
$dqstatus = mysql_fetch_array(mysql_query($qstatus));
$spasien = $dqstatus['p_khusus'];
$spasien=explode(",",$spasien);
//echo "<br>".$spasien[0]."<br>".$spasien[1]."<br>".$spasien[2]."<br>".count($spasien);
if($spasien[0] != 0)
{
	?>
	<img style="cursor:pointer;" title="K : Pasien Potensial Komplain" class='makezoom' <?php echo "width='30' height='30'"; ?> src='foto_diagnosa.php?id=2' >
	<?
}
if($spasien[1] != 0)
{
	?>
	<img style="cursor:pointer;" title="W : Pasien adalah Pemilik RS" class='makezoom' <?php echo "width='30' height='30'"; ?> src='foto_diagnosa.php?id=3' >
	<?
}
if($spasien[2] != 0)
{
	?>
	<img style="cursor:pointer;" title="P : Pasien adalah Pejabat" class='makezoom' <?php echo "width='30' height='30'"; ?> src='foto_diagnosa.php?id=10' >
	<?
}

?>
	<script>
		//alert(jQuery("#smeninggal").val());
	</script>
</body>
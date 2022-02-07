<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
if($_REQUEST['cek']=='true'){
	$nol = '';
	for($i=1;$i<=(6-strlen($_REQUEST['res']));$i++){
		$nol .= 0;
	}
	$que = "select 
	ap.textH,ap.textT,ap.textK,ap.textP
	from $dbapotek.a_penjualan ap
	INNER JOIN $dbbilling.b_ms_pasien p
	 ON ap.NO_PASIEN = p.no_rm 
	where ap.NO_KUNJUNGAN='".$_REQUEST['kunj']."' AND ap.NO_PENJUALAN='".$nol.$_REQUEST['res']."'";
	$queLab = mysqli_fetch_array(mysqli_query($konek,$que));
	//echo $que;							
?>
<script>
	//jQuery("#namapatient").val("<?php echo $queLab['nama'];?>");
	document.getElementById('isiH').value="<?php echo $queLab['textH'];?>";
	document.getElementById('isiT').value="<?php echo $queLab['textT'];?>";
	document.getElementById('isiK').value="<?php echo $queLab['textK'];?>";
	document.getElementById('isiP').value="<?php echo $queLab['textP'];?>";
	document.getElementById('txtH').value="<?php echo $queLab['textH'];?>";
	document.getElementById('txtT').value="<?php echo $queLab['textT'];?>";
	document.getElementById('txtK').value="<?php echo $queLab['textK'];?>";
	document.getElementById('txtP').value="<?php echo $queLab['textP'];?>";
	//jQuery("#btnIsiDataRM19").show();
</script>
<?php
}
?>

</body>
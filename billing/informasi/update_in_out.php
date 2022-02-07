<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$getIdPasien = $_REQUEST['getIdPasien'];
$in = $_REQUEST['in'];
$kh = $_REQUEST['kh'];
$valLab = $_REQUEST['valLab'];
$kon1 = $_REQUEST['kon1'];
$userId = $_REQUEST['userId'];
$anamnes = $_REQUEST['anamnes'];
$checkout = $_REQUEST['checkout'];
$parent_id = $_REQUEST['parent_id'];
$tglMsk = tglSQL($_REQUEST['tglMsk']);
$tglSls = tglSQL($_REQUEST['tglSls']);

$query = "SELECT SUM(IF(k.kso_id = 1,1,0)) AS total1, SUM(IF(k.kso_id = 2,1,0)) AS total2, SUM(IF(k.kso_id = 4 OR k.kso_id = 6,1,0)) AS total3, SUM(IF(k.isbaru = 1, 1, 0)) AS total4, SUM(IF(k.isbaru = 0, 1, 0)) AS total5
FROM b_pelayanan pel INNER JOIN b_ms_unit u ON pel.unit_id_asal = u.id
		INNER JOIN b_kunjungan k ON pel.kunjungan_id= k.id
		INNER JOIN b_ms_pasien p ON k.pasien_id = p.id
		INNER JOIN b_ms_unit ut ON ut.id = pel.unit_id
		WHERE   ut.parent_id=$parent_id AND  k.tgl BETWEEN '$tglMsk' AND '$tglSls'";
$dquery =mysql_fetch_array(mysql_query($query));
?>
<script>
	jQuery("#umum").text("<?= $dquery['total1'];?>");
	jQuery("#multi").text("<?= $dquery['total2'];?>");
	jQuery("#bpjs").text("<?= $dquery['total3'];?>");
	jQuery("#spanBar").text("<?= $dquery['total4'];?>");
	jQuery("#spanLam").text("<?= $dquery['total5'];?>");
</script>
<?
?>
<!--<span style="color:#F00"></span>-->
</body>
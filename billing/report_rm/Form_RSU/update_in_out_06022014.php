<body bgcolor="transparance">
<?
include("../../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$getIdPasien = $_REQUEST['getIdPasien'];
$in = $_REQUEST['in'];
$kh = $_REQUEST['kh'];
$valLab = $_REQUEST['valLab'];
$kon1 = $_REQUEST['kon1'];
$userId = $_REQUEST['userId'];
$idPel = $_REQUEST['idPel'];
$idKunj = $_REQUEST['idKunj'];


$sql = "SELECT DISTINCT p.nama,
		CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_,
		p.sex, DATE_FORMAT(p.`tgl_lahir`, '%d-%m-%Y') lahir, p.no_ktp,
		YEAR(CURDATE()) - YEAR(p.tgl_lahir) AS umur, md.nama AS diag, IFNULL(peg.nama,'-') AS dokter, 
		p.`no_rm`, u.nama AS ruang_rawat, kel.nama AS kelas, u.nama AS unit,
  DATE_FORMAT(kun.tgl_act, '%d-%m-%Y') tglawal, DATE_FORMAT(kun.tgl_act, '%H:%i:%s') jamawal, btt.nama tindakan, bmk.nama klasifikasi,IFNULL(peg2.nama,'-') AS dr_rujuk,kk.no_reg as no_reg2
	FROM b_pelayanan k
	INNER JOIN b_kunjungan kun
		ON k.kunjungan_id = kun.id
	INNER JOIN b_ms_pasien p
		ON p.id = k.`pasien_id`
	LEFT JOIN b_diagnosa diag 
    	ON diag.kunjungan_id = kun.id 
  	LEFT JOIN b_ms_diagnosa md 
    	ON md.id = diag.ms_diagnosa_id
	LEFT JOIN b_ms_unit u
		ON k.unit_id = u.id 
	LEFT JOIN b_ms_kelas kel
		ON kel.id = kun.kelas_id
	LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
	LEFT JOIN b_ms_wilayah wii
		ON p.kab_id = wii.id
	LEFT JOIN b_tindakan bmt 
    	ON kun.id = bmt.kunjungan_id 
    	AND k.id = bmt.pelayanan_id
	LEFT JOIN b_ms_tindakan_kelas bmtk 
    	ON bmtk.id = bmt.ms_tindakan_kelas_id 
  	LEFT JOIN b_ms_tindakan btt 
    	ON btt.id = bmtk.ms_tindakan_id
	LEFT JOIN b_ms_klasifikasi bmk
    	ON bmk.id = btt.klasifikasi_id 
	LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
    LEFT JOIN b_ms_pegawai peg2
    	ON peg2.id=k.dokter_id
	LEFT JOIN b_kunjungan kk 
		ON kk.id=k.kunjungan_id
	WHERE k.id = '$idPel' AND kun.id = '$idKunj'";
	//echo $sql;
$identitas = mysql_fetch_array(mysql_query($sql));

?>
<script>
jQuery("#kpd").text("<?=$identitas["dr_rujuk"]?>");
jQuery("#dr").text("<?=$identitas["dokter"]?>");
</script>
<?
?>
<!--<span style="color:#F00"></span>-->
</body>
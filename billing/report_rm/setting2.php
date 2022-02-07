<?
include "../koneksi/konek.php";
//include("../sesi.php");

$kelas_id = $_REQUEST["kelas_id"];
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$all = $_REQUEST['all'];
$idUser2=$_REQUEST['idUser'];
$idUser=$_REQUEST['idUsr'];

$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser2'"));


/* $q = "SELECT nama FROM b_ms_kelas WHERE id='$kelas_id'"; //echo $q;
$s = mysql_query($q);
$d = mysql_fetch_array($s);
$kelas = $d["nama"];  */

$sqlUser = "SELECT nama FROM b_ms_pegawai WHERE `id` = '$idUser'";
$isian = mysql_fetch_array(mysql_query($sqlUser));

$namaUser = $isian['nama'];

/*$sql = "SELECT DISTINCT p.nama,
		CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
		p.sex, p.telp, DATE_FORMAT(p.`tgl_lahir`, '%d-%m-%Y') lahir, p.no_ktp,
		YEAR(CURDATE()) - YEAR(p.tgl_lahir) AS umur, md.nama AS diag, peg.nama AS dokter, 
		p.`no_rm`, u.nama AS ruang_rawat, kel.nama AS kelas, u.nama AS unit,
  DATE_FORMAT(kun.tgl_act, '%d-%m-%Y') tglawal, DATE_FORMAT(kun.tgl_act, '%H:%i:%s') jamawal,kk.no_reg as no_reg2
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
	LEFT JOIN b_tindakan bmt 
    	ON kun.id = bmt.kunjungan_id 
    	AND k.id = bmt.pelayanan_id 
	LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
	LEFT JOIN b_kunjungan kk 
		ON kk.id=k.kunjungan_id
	WHERE k.id = '$idPel' AND kun.id = '$idKunj'";*/
$sql = "SELECT DISTINCT p.nama,
		CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_,
		p.sex, p.telp, DATE_FORMAT(p.`tgl_lahir`, '%d-%m-%Y') lahir, p.no_ktp,
		YEAR(CURDATE()) - YEAR(p.tgl_lahir) AS umur, md.nama AS diag, peg.nama AS dokter, 
		p.`no_rm`, u.nama AS ruang_rawat, kel.nama AS kelas, u.nama AS unit,
  DATE_FORMAT(kun.tgl_act, '%d-%m-%Y') tglawal, DATE_FORMAT(kun.tgl_act, '%H:%i:%s') jamawal,kk.no_reg AS no_reg2,
  CONCAT(DATE_FORMAT(CURDATE(),'%m-%Y'),'.',kk.no_reg,'.', p.`no_rm`,'.',k.id) AS no_formulir
  ,anam.*
	FROM b_pelayanan k
	INNER JOIN b_kunjungan kun
		ON k.kunjungan_id = kun.id
	LEFT JOIN (SELECT z.KUNJ_ID, z.KU, z.SOS, z.RPS, z.RPD, z.RPK, z.RA, z.KUM, z.GCS, z.KESADARAN, z.TENSI, z.TENSI_DIASTOLIK, z.RR, z.NADI, z.SUHU, z.TB, z.BB, z.GIZI, z.KL, z.LEHER, z.ABDOMEN, z.GENITALIA, z.COR, z.PULMO, z.INSPEKSI, z.PALPASI, z.AUSKULTASI, z.PERKUSI, z.EXT, z.THORAX FROM anamnese z ORDER BY z.ANAMNESE_ID DESC) anam
		ON anam.KUNJ_ID = kun.id
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
	LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
	LEFT JOIN b_kunjungan kk 
		ON kk.id=k.kunjungan_id
	WHERE k.id = '$idPel' AND kun.id = '$idKunj'";
	//echo $sql;
$identitas = mysql_fetch_array(mysql_query($sql));

$noRM = $identitas["no_rm"];
$nama = $identitas["nama"];
$no_reg = $identitas["no_reg2"];
$umur = $identitas["umur"];
$sex = $identitas["sex"];
$noKTP = $identitas["no_ktp"];
$alamat = $identitas["alamat_"];
$telp = $identitas["telp"];
$tgl = $identitas["lahir"];
$kamar = $identitas["ruang_rawat"];
$kelas = $identitas["kelas"];
$unit = $identitas["unit"];
$diag = $identitas["diag"];
$dokter = $identitas["dokter"];
$tglawalKunj = $identitas["tglawal"];
$jamawalKunj = $identitas["jamawal"];
$noreg = $identitas["no_reg2"];
$no_formulir = $identitas['no_formulir'];
?>

<?
include "../../koneksi/konek.php";
include("../../sesi.php");

$noRM = $_REQUEST["noRM"];
$nama = $_REQUEST["nama"];
$umur = $_REQUEST["umur"];
$sex = $_REQUEST["sex"];
$alamat = $_REQUEST["alamat"];
$tgl = $_REQUEST["tgl"];
$kamar = $_REQUEST["kamar"];
$kelas_id = $_REQUEST["kelas_id"];

$q = "SELECT nama FROM b_ms_kelas WHERE id='$kelas_id'"; //echo $q;
$s = mysql_query($q);
$d = mysql_fetch_array($s);
$kelas = $d["nama"]; 

//setting mulai

$kelas_id = $_REQUEST["kelas_id"];
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$all = $_REQUEST['all'];
$idUser=$_REQUEST['idUsr'];

$user="select nama from b_ms_pegawai where id='$idUser'";
$usr=mysql_fetch_array(mysql_query($user));
//echo $user."<br/>";

/* $q = "SELECT nama FROM b_ms_kelas WHERE id='$kelas_id'"; //echo $q;
$s = mysql_query($q);
$d = mysql_fetch_array($s);
$kelas = $d["nama"];  */

$sqlUser = "SELECT nama FROM b_ms_pegawai WHERE `id` = '$idUser'";
$isian = mysql_fetch_array(mysql_query($sqlUser));

$namaUser = $isian['nama'];

$sql = "SELECT DISTINCT p.nama, p.no_ktp, p.alamat, p.rt, p.rw, w.nama desa, wi.nama kecamatan, w2.nama kota, p.telp, agm.agama, p.sex,
		DATE_FORMAT(p.tgl_lahir,'%d') tgllahir,
		DATE_FORMAT(p.tgl_lahir,'%M') blnlahir,
		DATE_FORMAT(p.tgl_lahir,'%Y') thnlahir,
		DATE_FORMAT(bk.tgl_act, '%d') tglmati,
		DATE_FORMAT(bk.tgl_act, '%M') blnmati,
		DATE_FORMAT(bk.tgl_act, '%Y') thnmati,
		YEAR(bk.tgl_act) - YEAR(p.tgl_lahir) AS umurmati,
		CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
		p.sex, DATE_FORMAT(p.`tgl_lahir`, '%d-%m-%Y') lahir, p.no_ktp,
		YEAR(CURDATE()) - YEAR(p.tgl_lahir) AS umur, md.nama AS diag, peg.nama AS dokter, 
		p.`no_rm`, u.nama AS ruang_rawat, kel.nama AS kelas, u.nama AS unit,
  DATE_FORMAT(kun.tgl_act, '%d-%m-%Y') tglawal, DATE_FORMAT(kun.tgl_act, '%H:%i:%s') jamawal
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
	LEFT JOIN b_ms_wilayah w2
		ON p.kab_id = w2.id
	LEFT JOIN b_tindakan bmt 
    	ON kun.id = bmt.kunjungan_id 
    	AND k.id = bmt.pelayanan_id 
	LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
	LEFT JOIN b_ms_agama agm
		ON agm.id = p.agama
	LEFT JOIN (SELECT * FROM b_pasien_keluar WHERE cara_keluar LIKE '%Meninggal%') bk
	ON kun.id = bk.kunjungan_id 
    	AND k.id = bk.pelayanan_id
	WHERE k.id = '$idPel' AND kun.id = '$idKunj'";
	//echo $sql;
$identitas = mysql_fetch_array(mysql_query($sql));

$noRM = $identitas["no_rm"];
$nama = $identitas["nama"];
$ktp = $identitas["no_ktp"];
$umur = $identitas["umur"];
$umurmati = $identitas["umurmati"];
$sex = $identitas["sex"];
$noKTP = $identitas["no_ktp"];
$alamat = $identitas["alamat_"];
$alamat2 = $identitas["alamat"];
$rt = $identitas["rt"];
$rw = $identitas["rw"];
$desa = $identitas["desa"];
$kec = $identitas["kecamatan"];
$kota = $identitas["kota"];
$tgllahir = $identitas["tgllahir"];
$blnlahir = $identitas["blnlahir"];
$thnlahir = $identitas["thnlahir"];
$tglmati = $identitas["tglmati"];
$blnmati = $identitas["blnmati"];
$thnmati = $identitas["thnmati"];
$telp = $identitas["telp"];
$sex = $identitas["sex"];
$agama = $identitas["agama"];
$tgl = $identitas["lahir"];
$kamar = $identitas["ruang_rawat"];
$kelas = $identitas["kelas"];
$unit = $identitas["unit"];
$diag = $identitas["diag"];
$dokter = $identitas["dokter"];
$tglawalKunj = $identitas["tglawal"];
$jamawalKunj = $identitas["jamawal"];
?>
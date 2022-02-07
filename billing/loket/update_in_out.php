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
$idDok = $_REQUEST['idDok'];
$idUnit1 = $_REQUEST['idUnit1'];

if($in == "cDokterG")
{
	$queryDok = "SELECT * FROM b_ms_pegawai WHERE id = '".$idDok."'";
	$execQD = mysql_query($queryDok);
}
?>
<!--<span style="color:#F00"></span>-->
</body>
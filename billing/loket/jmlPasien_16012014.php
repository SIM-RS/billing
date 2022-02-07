<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$idDok12 = $_REQUEST['idDok12'];
$TmpLayanan12 = $_REQUEST['TmpLayanan12'];
$TglKunj12 = tglSQL($_REQUEST['TglKunj12']);

$queryJ = "SELECT COUNT(*) AS jml FROM b_pelayanan WHERE tgl = '$TglKunj12' AND dokter_tujuan_id = $idDok12 AND unit_id = $TmpLayanan12";
$execqueryJ = mysql_query($queryJ);
$dqueryJ = mysql_fetch_array($execqueryJ);
echo $dqueryJ['jml'];
?>
<!--<span style="color:#F00"></span>-->
</body>
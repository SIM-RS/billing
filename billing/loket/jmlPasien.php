<body bgcolor="transparance">
<?
error_reporting(0);
include("../koneksi/konek.php");
$idDok12 = $_REQUEST['idDok12'];
$TmpLayanan12 = $_REQUEST['TmpLayanan12'];
$TglKunj12 = tglSQL($_REQUEST['TglKunj12']);

$queryJ = "SELECT COUNT(*) AS jml,SUM(dilayani) AS jml_dilayani FROM b_pelayanan WHERE tgl = '$TglKunj12' AND dokter_tujuan_id = $idDok12 AND unit_id = $TmpLayanan12";
//echo $queryJ."<br>";
$execqueryJ = mysql_query($queryJ);
$dqueryJ = mysql_fetch_array($execqueryJ);
echo $dqueryJ['jml']." / ".($dqueryJ['jml']-$dqueryJ['jml_dilayani']);
?>
<!--<span style="color:#F00"></span>-->
</body>
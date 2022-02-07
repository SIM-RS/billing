<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
$dt="..........";
switch(strtolower($_REQUEST['act'])) {
    case 'updatespk':
        $sql = "UPDATE dbaset.as_po SET no_spk='".$_REQUEST['noSPK']."' WHERE no_po='".$_REQUEST['noPO']."'";
        mysql_query($sql);
		if (mysql_errno()==0){
			$dt=$_REQUEST['noSPK'];
		}
        break;
}
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>
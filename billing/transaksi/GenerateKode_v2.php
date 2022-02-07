<?php
include "../koneksi/konek.php";
$q="SELECT MAX(IF(no_wo IS NULL,0,no_wo))+1 AS no_wo FROM $dbcssd.cssd_job_order";
$s=mysql_query($q);
$cmkode=1;
if ($rows=mysql_fetch_array($s))
{
	$cmkode=$rows["no_wo"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++)
{
	$mkode="0".$mkode;
}
echo $mkode;
?>
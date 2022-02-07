<?php
include "../koneksi/konek.php";
$q="SELECT MAX(IF(no_jo IS NULL,0,no_jo))+1 AS no_jo FROM $dbcssd.cssd_job_order";
$s=mysql_query($q);
$cmkode=1;
if ($rows=mysql_fetch_array($s))
{
	$cmkode=$rows["no_jo"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++)
{
	$mkode="0".$mkode;
}
echo $mkode;
?>
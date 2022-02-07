<?php //include("koneksi/konekserver.php");?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php 
$konek2=odbc_connect("billing2","sa","ytsejam");
// _db($database_conn2,$konek2);
$sql="select top 20 * from TMPersonel";
$rs=odbc_exec($konek2,$sql);
while (odbc_fetch_row($rs)){
	echo odbc_result($rs,"Nama")."<br>";
}
/*
$rs=mssql_query($sql);
$i=0;
while ($rows=mssql_fetch_array($rs)){
	$i++;
	echo $i.") ".$rows['KD_UNIT']." - ".$rows['NAMA_UNIT']."<br>";
}
*/
?>
</body>
</html>
<?php //mssql_close($konek1);?>
<?php
$hostname_conn = "localhost";
//$hostname_conn = "192.168.1.2";
$database_conn = "dbgrid";
$username_conn = "root";
$password_conn = "ubuntu";
//$password_conn = "rsud2010";

$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
mysql_select_db($database_conn,$konek);

$perpage=100;
?>
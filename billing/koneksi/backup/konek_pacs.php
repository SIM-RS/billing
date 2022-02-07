<?php
$koneksi_billing = mysql_connect('localhost','admindb_kadal','mysqlk4d4lt9rk0t4');
$koneksi_pacs = mysql_connect('localhost','admindb_kadal','mysqlk4d4lt9rk0t4',true);

mysql_select_db('rspelindo_billing',$koneksi_billing);
mysql_select_db('iqwebx',$koneksi_pacs);
?>
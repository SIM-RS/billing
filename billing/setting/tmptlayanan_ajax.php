<?php
   include("../koneksi/konek.php");
   $sql = "SELECT * FROM b_ms_pegawai where id = '".$_GET['hsl']."'";
   $rs = mysql_query($sql);
   $rw = mysql_fetch_array($rs);
   echo $rw['id'];
?>
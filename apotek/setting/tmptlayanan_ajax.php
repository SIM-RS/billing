<?php
   include("../koneksi/konek.php");
   $sql = "SELECT * FROM b_ms_pegawai where id = '".$_GET['hsl']."'";
   $rs = mysqli_query($konek,$sql);
   $rw = mysqli_fetch_array($rs);
   echo $rw['id'];
?>
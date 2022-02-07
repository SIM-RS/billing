<?php
include("koneksi/konek.php");
switch($_REQUEST['id']){
      case 'retribusi':         
         $sql="SELECT tarip FROM b_ms_tindakan_kelas b where ms_tindakan_id='".$_REQUEST['idTind']."' and ms_kelas_id='".$_REQUEST['idKls']."'";
         break;
     case 'tarifKamar':
         $sql = "select tarip from b_ms_kamar mk inner join b_ms_kamar_tarip kt on mk.id = kt.kamar_id where mk.id = '".$_GET['idKamar']."'";
         break;
}
$rs = mysql_query($sql);
if(mysql_num_rows($rs) == 0){
   $sql = "select 0 as tarip";
}
$rs=mysql_query($sql);
$rw=mysql_fetch_array($rs);
echo $rw['tarip'];
?>
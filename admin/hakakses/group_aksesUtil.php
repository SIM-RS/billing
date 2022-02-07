<?php
include("../inc/koneksi.php");
$gid=$_REQUEST['gid'];
$id=$_REQUEST['id'];

$sql="select id from ms_group_akses where ms_group_id=$gid and ms_menu_id=$id";
$rs=mysql_query($sql);


if(mysql_affected_rows()>0){
   $rw=mysql_fetch_array($rs);
   $remove="delete from ms_group_akses where id=".$rw['id'];
   mysql_query($remove);
   if(mysql_affected_rows()>0){
      echo ' removed success!';
   }
}
else{
   $add="insert into ms_group_akses (ms_group_id,ms_menu_id) values ($gid,$id)";
    mysql_query($add);
   if(mysql_affected_rows()>0){
      echo ' added success!';
   }
}
mysql_free_result($rs);
mysql_close($conn);
?>
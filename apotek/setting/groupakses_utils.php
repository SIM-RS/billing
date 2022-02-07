<?php
include("../koneksi/konek.php");
$gid=$_REQUEST['gid'];
$id=$_REQUEST['id'];

$sql="select id from a_group_akses where group_id=$gid and menu_id=$id";
$rs=mysqli_query($konek,$sql);


if(mysqli_affected_rows($konek)>0){
   $rw=mysqli_fetch_array($rs);
   $remove="delete from a_group_akses where id=".$rw['id'];
   mysqli_query($konek,$remove);
   if(mysqli_affected_rows($konek)>0){
      echo ' removed success!';
   }
}
else{
   $add="insert into a_group_akses (group_id,menu_id) values ($gid,$id)";
    mysqli_query($konek,$add);
   if(mysqli_affected_rows($konek)>0){
      echo ' added success!';
   }
}
mysqli_free_result($rs);
mysqli_close($konek);

?>
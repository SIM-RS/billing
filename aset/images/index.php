<?php
session_start();
if(isset($_SESSION['userid']) && $_SESSION['userid'] != ''){
    header("location:info_user.php");
}
else{
    header("location:/simrs-tangerang/aset");
}
?>
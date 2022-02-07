<?php
function cekSql($query){
	/*
	untuk mengecek apakah query sql benar atau tidak
	*/
	if(!mysql_query($query)){
		echo "<font color=#ff0000>MySQL error: ".mysql_error()."</font><br>";
		echo $query;
		exit;
	}
}

function tampil($query){
    echo "<font color=#ff0000>".$query."</font><br>";
}
?>
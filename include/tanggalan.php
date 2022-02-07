<?php 
	//Fungsi Tanggalan Indonesia==
function ShowDate($str_date,$type=1){
	$T['Day']=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	$T['Month']=array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$T['S_Month']=array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");
	
	// Keterangan Format Tanggalan==
	$longday=$T['Day'][date("w",strtotime($str_date))]; // NAMA HARI
	$day=date("d",strtotime($str_date)); // TANGGAL
	$month=$T['Month'][date("n",strtotime($str_date))]; // NAMA BULAN
	$s_month=$T['S_Month'][date("n",strtotime($str_date))]; // NAMA BULAN
	$year=date("Y",strtotime($str_date)); // TAHUN
	$hour=date("H",strtotime($str_date)); // JAM
	$minute=date("i",strtotime($str_date)); // MENIT
	$second=date("s",strtotime($str_date)); // DETIK
	//===============================
	
	if ($type==1){
		return $longday.", ".$day." ".$month." ".$year."  ".$hour.":".$minute.":".$second;
	}
	else if ($type==2){
		return $longday.", ".$day." ".$month." ".$year." - ".$hour.":".$minute." ";
	}
	else if ($type==3){
		return $longday.", ".$day." ".$month." ".$year;
	}
	else if ($type==4){
		return $day." ".$month." ".$year." - ".$hour.":".$minute." ";
	}
	else if ($type==5){
		return $day." ".$month." ".$year;
	}
	else if ($type==6){
		return $day." ".$s_month." ".$year;
	}else if($type==7){
		return $longday." ".$hour.":".$minute;
	}
	
}
	//Fungsi Tanggalan Indonesia Berakhir==
?>

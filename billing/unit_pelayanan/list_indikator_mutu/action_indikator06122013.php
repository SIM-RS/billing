<?php
	include("../../koneksi/konek.php");
	function satu($a,$b){
		switch($a){
			case 'ugdlengkap': $n = 5;
						break;
			case 'obatjalan': $n = 2;
						break;
			case 'dokterrawat': $n = 5;
						break;
			case 'dekubitus': $n = 6;
						break;
			case 'pascaopera': $n = 3;
						break;
		}
		for($i=1;$i<=$n;$i++){
			if($b[$i] == 1){
				if($i != $n){
					$result .= $b[$i].",";
				} else {
					if($a == 'dekubitus'){
						$result .= $b[$i]."_".$_REQUEST['laindeku'];
					} elseif($a == 'pascaopera') {
						$result .= $b[$i]."_".$_REQUEST['Lpascaopera'];
					} else {
						$result .= $b[$i];
					}
				}
			} else {
				if($i != $n){
					$result .= "0,";
				} else {
					if($a == 'dekubitus'){
						$result .= "0_";
					} elseif($a == 'pascaopera') {
						$result .= "0_";
					} else {
						$result .= "0";
					}
				}
			}
		}
		return $result;
	}
	$datetime = date("Y-m-d H:i:s");
	$idKunj = $_REQUEST['idKunjMutu'];
	$idPel = $_REQUEST['idPelMutu'];
	$inap = $_REQUEST['inapMutu'];
	$idUser = $_REQUEST['idUserMutu'];
	$idMutu = $_REQUEST['idMutu'];
	$act = $_REQUEST['actMutu'];
	
	$sql = "select mutu_id from b_form_indikatormutu where pelayanan_id = '$idPel' AND kunjungan_id = '$idKunj' AND mutu_id = $idMutu";
	$cek = mysql_num_rows(mysql_query($sql));
	
	switch($act){
	case 'Save':
		if($cek != 1){
			$ugdlengkap = $_REQUEST['ugdlengkap'];
			if($ugdlengkap == '1'){
				$ugdlengkap .= "||0,0,0,0,0";
			} elseif($ugdlengkap == ''){
				$ugdlengkap = "-";
			} else {
				$ugdlengkap .= "||".satu('ugdlengkap',$_REQUEST['cekugdleng']);
			}
			//echo "UGD Lengkap = ".$ugdlengkap."<br />";
			
			$obatjalan = $_REQUEST['obatjalan'];
			if($obatjalan == ''){
				$obatjalan = "-";
			} elseif($obatjalan == 0){
				$obatjalan .= "||0,0";
			} else {
				$obatjalan .= "||".satu('obatjalan',$_REQUEST['cekOjalan']);
			}
			//echo "Obat Jalan = ".$obatjalan."<br />";
			
			$dokterrawat = $_REQUEST['dokterrawat'];
			if($dokterrawat == '1'){
				$dokterrawat .= "||0,0,0,0,0";
			} elseif($dokterrawat == ''){
				$dokterrawat = "-";
			} else {
				$dokterrawat .= "||".satu('dokterrawat',$_REQUEST['cekdokraw']);
			}
			//echo "Dokter Rawat = ".$dokterrawat."<br />";
			
			$tirahbaring = $_REQUEST['tirahbaring'];
			if($tirahbaring == ""){
				$tirahbaring = "-";
			} elseif($tirahbaring == 0){
				$tirahbaring .= "||-";
			} else {
				$tirahbaring .= "||".$_REQUEST['tirah'];
			}
			//echo "Tirah Baring = ".$tirahbaring."<br />";
			
			$lukadeku = $_REQUEST['lukadeku'];
			if($lukadeku == ''){
				$lukadeku = '-';
			} elseif($lukadeku == 0){ 
				$lukadeku .= "||-||0,0,0,0,0,0";
			} else {
				$lukadeku .= "||".$_REQUEST['dekubi']."||".satu('dekubitus',$_REQUEST['dekubitus']);
			}
			//echo "Dekubitus = ".$lukadeku."<br />";
			
			$tranfus = $_REQUEST['tranfus'];
			if($tranfus == ''){
				$tranfus = "-";
			} elseif($tranfus == '0'){
				$tranfus .= "||-||-";
			} else {
				$tranfusi = $_REQUEST['tranfusi'];
				if($tranfusi == '0'){
					$tranfus .= "||".$_REQUEST['tranfusi']."||-";
				} else {
					$tranfus .= "||".$_REQUEST['tranfusi']."||".$_REQUEST['transfusi'];
				}
			}
			//echo "Transfusi = ".$tranfus."<br />";
			
			$ICU = $_REQUEST['ICU'];
			if($ICU == ''){
				$ICU = '-';
			} elseif($ICU == 0){
				$ICU .= "||-";
			} else {
				$ICU .= "||".$_REQUEST['ICCU'];
			}
			//echo "ICU = ".$ICU."<br />";
			
			$ope = $_REQUEST['ope'];
			if($ope == '1'){
				$opera = $_REQUEST['opera'];
				if($opera == 1){
					$ope .= "||".$opera."_".$_REQUEST['iopera'];
				} else {
					$ope .= "||".$opera."_";
				}
				
				$pasca = $_REQUEST['pasca'];
				if($pasca == 1){
					$ope .= "||".$pasca."&".satu('pascaopera',$_REQUEST['pascaopera']);
				} else {
					$ope .= "||".$pasca."&";
				}
				
				$tinoper = $_REQUEST['tinoper'];
				if($tinoper == 1){
					$ope .= "||".$tinoper."&".$_REQUEST['Ltinnoper']."-".$_REQUEST['jenisope'];
				} else {
					$ope .= "||".$tinoper."&";
				}
			} elseif($ope == "") {
				$ope = '-';
			} elseif($ope == "0") {
				$ope .= '||';
			}
			//echo "Operasi = ".$ope."<br />";
			
			$apendik = $_REQUEST['apendik'];
			if($apendik == 1){
				$Yapendik = $_REQUEST['Yapendik'];
				if($Yapendik == 1){
					$apendik .= "||".$Yapendik."_".$_REQUEST['IYapendik'];
				} else {
					$apendik .= "||".$Yapendik."_".$_REQUEST['ITapendik'];
				}
			} elseif($apendik == ""){
				$apendik = '-';
			} elseif($apendik == "0"){
				$apendik .= '||';
			}
			//echo "Apendik = ".$apendik."<br />";
			
			$sql = "insert into b_form_indikatormutu values (NULL,'$idPel','$idKunj','$ugdlengkap','$obatjalan','$dokterrawat','$tirahbaring','$lukadeku','$tranfus','$ICU','$ope','$apendik','$datetime','$idUser')";
			$hasil = mysql_query($sql);
		}
	break;
	case 'Update':
		$ugdlengkap = $_REQUEST['ugdlengkap'];
		if($ugdlengkap == '1'){
			$ugdlengkap .= "||0,0,0,0,0";
		} elseif($ugdlengkap == ''){
			$ugdlengkap = "-";
		} else {
			$ugdlengkap .= "||".satu('ugdlengkap',$_REQUEST['cekugdleng']);
		}
		//echo "UGD Lengkap = ".$ugdlengkap."<br />";
		
		$obatjalan = $_REQUEST['obatjalan'];
		if($obatjalan == ''){
			$obatjalan = "-";
		} elseif($obatjalan == 0){
			$obatjalan .= "||0,0";
		} else {
			$obatjalan .= "||".satu('obatjalan',$_REQUEST['cekOjalan']);
		}
		//echo "Obat Jalan = ".$obatjalan."<br />";
		
		$dokterrawat = $_REQUEST['dokterrawat'];
		if($dokterrawat == '1'){
			$dokterrawat .= "||0,0,0,0,0";
		} elseif($dokterrawat == ''){
			$dokterrawat = "-";
		} else {
			$dokterrawat .= "||".satu('dokterrawat',$_REQUEST['cekdokraw']);
		}
		//echo "Dokter Rawat = ".$dokterrawat."<br />";
		
		$tirahbaring = $_REQUEST['tirahbaring'];
		if($tirahbaring == ""){
			$tirahbaring = "-";
		} elseif($tirahbaring == 0){
			$tirahbaring .= "||-";
		} else {
			$tirahbaring .= "||".$_REQUEST['tirah'];
		}
		//echo "Tirah Baring = ".$tirahbaring."<br />";
		
		$lukadeku = $_REQUEST['lukadeku'];
		if($lukadeku == ''){
			$lukadeku = '-';
		} elseif($lukadeku == 0){ 
			$lukadeku .= "||-||0,0,0,0,0,0";
		} else {
			$lukadeku .= "||".$_REQUEST['dekubi']."||".satu('dekubitus',$_REQUEST['dekubitus']);
		}
		//echo "Dekubitus = ".$lukadeku."<br />";
		
		$tranfus = $_REQUEST['tranfus'];
		if($tranfus == ''){
			$tranfus = "-";
		} elseif($tranfus == 0){
			$tranfus .= "||-||-";
		} else {
			$tranfusi = $_REQUEST['tranfusi'];
			if($tranfusi == 0){
				$tranfus .= "||".$_REQUEST['tranfusi']."||-";
			} else {
				$tranfus .= "||".$_REQUEST['tranfusi']."||".$_REQUEST['transfusi'];
			}
		}
		//echo "Transfusi = ".$tranfus."<br />";
		
		$ICU = $_REQUEST['ICU'];
		if($ICU == ''){
			$ICU = '-';
		} elseif($ICU == 0){
			$ICU .= "||-";
		} else {
			$ICU .= "||".$_REQUEST['ICCU'];
		}
		//echo "ICU = ".$ICU."<br />";
		
		$ope = $_REQUEST['ope'];
		if($ope == 1){
			$opera = $_REQUEST['opera'];
			if($opera == 1){
				$ope .= "||".$opera."_".$_REQUEST['iopera'];
			} else {
				$ope .= "||".$opera."_";
			}
			
			$pasca = $_REQUEST['pasca'];
			if($pasca == 1){
				$ope .= "||".$pasca."&".satu('pascaopera',$_REQUEST['pascaopera']);
			} else {
				$ope .= "||".$pasca."&";
			}
			
			$tinoper = $_REQUEST['tinoper'];
			if($tinoper == 1){
				$ope .= "||".$tinoper."&".$_REQUEST['Ltinnoper']."-".$_REQUEST['jenisope'];
			} else {
				$ope .= "||".$tinoper."&";
			}
		} elseif($ope == "") {
			$ope = '-';
		} elseif($ope == "0") {
			$ope .= '||';
		}
		//echo "Operasi = ".$ope."<br />";
		
		$apendik = $_REQUEST['apendik'];
		if($apendik == 1){
			$Yapendik = $_REQUEST['Yapendik'];
			if($Yapendik == '1'){
				$apendik .= "||".$Yapendik."_".$_REQUEST['IYapendik'];
			} else {
				$apendik .= "||".$Yapendik."_".$_REQUEST['ITapendik'];
			}
		} elseif($apendik == ""){
			$apendik = '-';
		} elseif($apendik == "0"){
			$apendik .= '||';
		}
		//echo "Apendik = ".$apendik."<br />";
		
		$sql = "update b_form_indikatormutu set
			ugd = '$ugdlengkap',
			obatjalan = '$obatjalan',
			dokterrawat = '$dokterrawat',
			tirahbaring = '$tirahbaring',
			dekubitus = '$lukadeku',
			transfusi = '$tranfus',
			icu ='$ICU',
			operasi = '$ope',
			apendik = '$apendik',
			tanggal_act = '$datetime',
			user_act = '$idUser'
			where mutu_id = '$idMutu'";
		$hasil = mysql_query($sql);		
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>
<?php
	// ini_set('memory_limit', '1024M');
	include '../secured_sess.php';
	include("../koneksi/konek.php");
	
	$userId = $_POST['user_id'];
	$ksoid = ($_REQUEST['kso_id']!="") ? $_REQUEST['kso_id'] : 0;
	$klaim_id = ($_POST['klaim_id']!="") ? $_POST['klaim_id'] : 0;
	$klaim_terima_id = ($_POST['klaim_terima_id']!="") ? $_POST['klaim_terima_id'] : 0;
	
	// function for change base date format from excel to database format
	function formatDate($tgl){
		return date("Y-m-d", strtotime($tgl));
	}

	// replace
	function _repALL($dval, $param = TRUE, $look = NULL, $change = NULL ){
		if($look != NULL || $change != NULL || $param == FALSE){
			$dval = str_replace($look, $change, $dval);
		} else {
			$dval = str_replace("'",'', $dval);
			$dval = str_replace('"','', $dval);
			$dval = str_replace(",",'', $dval);
			$dval = str_replace(".",'', $dval);
		}
		
		return $dval;
	}
	
	function insert($data){
		global $userId, $klaim_id, $klaim_terima_id;
		global $dbbilling, $dbapotek, $dbpendidikan, $dbkeuangan;
		
		$column = array();
		$value = array();
		foreach($data as $key => $val){
			$column[] = $key;
			$value[] = $val;
		}
		
		$sql = "SELECT k.id, k.kso_id FROM $dbbilling.b_kunjungan k
				WHERE k.no_sjp = '".$data['sep']."'";
		$query = mysql_query($sql);
		$dataQ = mysql_fetch_array($query);
		//$param = array($dataQ['id'], $data['kso_id'], $data['totaltarif']);
		$idKunj = ($dataQ['id']!="") ? $dataQ['id'] : 0;
		
		$kosong = false;
		$nilai_terima = $data['totaltarif'];
		$tarifRS = $tarifPasien = 0;
		if ($idKunj != "" | $idKunj != 0){
			$sPiutang = "SELECT biayaRS, biayaPasien
						 FROM k_piutang 
						 WHERE kunjungan_id = {$idKunj}";
			$qPiutang = mysql_query($sPiutang);
			if (mysql_num_rows($qPiutang)>0){
				$dPiutang = mysql_fetch_array($qPiutang);
				$tarifRS = $dPiutang['biayaRS'];
				$tarifPasien = $dPiutang['biayaPasien'];
			}
			
			$sqlVer = "SELECT id FROM k_klaim_detail
						WHERE kunjungan_id = '{$idKunj}' 
						  AND tglmsk = '".$data['tglmsk']."'
						  AND tstatus<2";
			//echo $sqlVer."<br>";
			$rsVer2 = mysql_query($sqlVer);
			if (mysql_num_rows($rsVer2)>0){
				$detVer =  mysql_fetch_array($rsVer2);
				$klaim_detail_id = $detVer['id'];
				$sqlVer="UPDATE k_klaim_detail
						SET tstatus = '2'
						WHERE id = '$klaim_detail_id' AND tstatus<2";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				
				/* Query Lama */
				/* $sqlVer="INSERT INTO k_klaim_terima_detail
							(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
						VALUES ('.$klaim_terima_id.', '.$klaim_detail_id.', '.$nilai_terima.', "'.$idKunj.'", "'.$ksoid.'", "'.implode('", "',$value).'", NOW(), "'.$userId.'")'; */
				
				/* Query Baru */
				$sqlVer = "INSERT INTO k_klaim_terima_detail 
							(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, nilai_pengajuan, sep, tgl_verif, tariffrs, tarifPasien, tgl_act, user_act)
						VALUES ('{$klaim_terima_id}', '{$klaim_detail_id}', '{$nilai_terima}', '{$idKunj}', '{$ksoid}', '".$data['nilai_pengajuan']."', '".$data['sep']."', '".$data['tgl_verif']."', '{$tarifRS}', '{$tarifPasien}', NOW(), '{$userId}')";
				//echo $sqlVer."<br>";
				$hasil=mysql_query($sqlVer);
				if (mysql_errno()>0){
					$sqlVer="UPDATE k_klaim_detail
							SET tstatus = '0'
							WHERE id = '$klaim_detail_id'";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					
					$statusProses='Error';
					//=======update gagal --> batalkan Verifikasi Selisih Piutang KSO======
				}
			} else {
				$kosong = true;
			}
		} else {
			$kosong = true;
		}
		
		if($kosong == true){
			/* Query Lama */
			/* $sqlVer = "INSERT INTO k_klaim_terima_detail
							(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
						VALUES ('.$klaim_terima_id.', 0, '.$nilai_terima.', "'.$idKunj.'", "'.$ksoid.'", "'.implode('", "',$value).'", NOW(), "'.$userId.'")'; */
						
			/* Query Baru */
			$sqlVer = "INSERT INTO k_klaim_terima_detail 
							(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, nilai_pengajuan, sep, tgl_verif, tariffrs, tarifPasien, tgl_act, user_act)
						VALUES ('{$klaim_terima_id}', 0, '{$nilai_terima}', '{$idKunj}', '{$ksoid}', '".$data['nilai_pengajuan']."', '".$data['sep']."', '".$data['tgl_verif']."', '{$tarifRS}', '{$tarifPasien}', NOW(), '{$userId}')";
			//echo "2. ".$sqlVer."<br />";
			$hasil = mysql_query($sqlVer);
		}
	}
	
	$data = $_POST['data'];
	foreach($data as $row){
		$tmp = explode(chr(9),$row);
		$sep = explode('^',$tmp[1]);
		$array[] = array(
					'sep' 				=> $tmp[1],
					'tgl_verif' 		=> formatDate(str_replace('/','-',$tmp[2])),
					'nilai_pengajuan' 	=> _repALL($tmp[3]),
					'totaltarif' 		=> _repALL($tmp[4])
				);
	}
	$baris = count($array);
	for($j=0; $j < $baris; $j++){
		$hasil = insert($array[$j]);
		/* if($hasil) {
			$sukses++;
		} else {
			$gagal++;
		} */
	}
	
	echo count($data);
?>
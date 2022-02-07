<?php
ini_set('memory_limit', '1024M');
include '../secured_sess.php';
include("../koneksi/konek.php");
require_once '../theme/Excel/oleread.inc';
require('../theme/Excel/reader.php');
require('../theme/Excel/SpreadsheetReader.php');

$dbbilling = "billing";
$dbapotek = "dbapotek";
$dbpendidikan = "db_rspendidikan";
$dbkeuangan = "keuangan";

$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);

$userId = $_POST['user_id'];
$tipe_imp = $_POST['tipe_imp'];
$klaim_id = ($_POST['klaim_id']!="") ? $_POST['klaim_id'] : 0;
$klaim_terima_id = ($_POST['klaim_terima_id']!="") ? $_POST['klaim_terima_id'] : 0;

// function for change base date format from excel to database format
function formatDate($tgl){
	return date("Y-m-d", strtotime($tgl));
}

// function for inserting data to database
function insert($data){
	global $userId, $tipe_imp, $klaim_id, $klaim_terima_id;
	global $dbbilling, $dbapotek, $dbpendidikan, $dbkeuangan;
	
	$column = array();
	$value = array();
	foreach($data as $key => $val){
		$column[] = $key;
		$value[] = $val;
	}
	
	$sql = "SELECT k.id, k.kso_id FROM $dbbilling.b_kunjungan k
			WHERE k.no_sjp = '".$data['sep']."' AND k.tgl = '".$data['tglmsk']."'";
	$query = mysql_query($sql);
	$dataQ = mysql_fetch_array($query);
	//$param = array($dataQ['id'], $data['kso_id'], $data['totaltarif']);
	$idKunj = ($dataQ['id']!="") ? $dataQ['id'] : 0;
			
	switch($tipe_imp){
		case "pengajuan":
			$tipeUpdt=0;
			$ksoid = ($_REQUEST['kso_id']!="") ? $_REQUEST['kso_id'] : 0;
			$nilaiklaim = $data['totaltarif'];
			
			$sqlVer="SELECT id FROM k_piutang
				 WHERE kunjungan_id = '$idKunj' 
				   AND kso_id='$ksoid'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			if (mysql_num_rows($rsVer)>0){
				$dVer = mysql_fetch_array($rsVer);
				$idPiutang = $dVer['id'];
			} else {
				$idPiutang = 0;
			}
					
			$sqlVer = "INSERT INTO k_klaim_detail
							(klaim_id, fk_id, nilai_klaim, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
						VALUES ('.$klaim_id.', '.$idPiutang.', '.$nilaiklaim.', "'.$idKunj.'", "'.$ksoid.'", 
								"'.implode('", "',$value).'", NOW(), "'.$userId.'")';
			//echo "1. ".$sqlVer."<br>";
			$hasil = mysql_query($sqlVer);
			
			/* $sqlVer="SELECT id FROM k_piutang
					 WHERE kunjungan_id = '$idKunj' 
					   AND kso_id='$ksoid' AND tipe=0";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			if (mysql_num_rows($rsVer)>0){
				$rwVer=mysql_fetch_array($rsVer);
				$k_piutang_id=$rwVer["id"];
				$sqlVer="UPDATE k_piutang
						SET biayaKSO_Klaim = '$selisihTarip'
						WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid' AND tipe=0";
				//echo $sqlVer."<br>";
			}else{
				$tipeUpdt=1;
				$sqlVer="SELECT id FROM k_piutang
						WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid' AND tipe=1";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				$rwVer=mysql_fetch_array($rsVer);
				$k_piutang_id=$rwVer["id"];
				$sqlVer="UPDATE k_piutang
						SET biayaKSO_Klaim = '$selisihTarip'
						WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid' AND tipe=1";
				//echo $sqlVer."<br>";
			}
			$rsVer=mysql_query($sqlVer);
			if (mysql_affected_rows()>0){
				$sqlVer="UPDATE k_piutang
						SET status = 2,user_posting_bKlaim='$userId',tgl_posting_bKlaim=NOW()
						WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid'";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_affected_rows()>0){
					$sqlVer = "INSERT INTO k_klaim_detail
									(klaim_id, fk_id, nilai_klaim, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
								VALUES ('.$klaim_id.', '.$k_piutang_id.', '.$selisihTarip.', "'.$idKunj.'", "'.$ksoid.'", 
										"'.implode('", "',$value).'", NOW(), "'.$userId.'")';
					//echo "1. ".$sqlVer."<br>";
					$hasil = mysql_query($sqlVer);
					if (mysql_affected_rows()==0){
						$sqlVer="UPDATE k_piutang
								SET status = 0,user_posting_bKlaim='0',tgl_posting_bKlaim=NULL,biayaKSO_Klaim = '0'
								WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid' AND tipe='$tipeUpdt'";
						//echo $sqlVer."<br>";
						//$rsVer1=mysql_query($sqlVer);
					}
				}else{
					$kosong = true;
					
					$sqlVer="UPDATE k_piutang
							SET biayaKSO_Klaim = '0'
							WHERE kunjungan_id = '$idKunj' AND kso_id='$ksoid' AND tipe='$tipeUpdt'";
					//echo $sqlVer."<br>";
					//$rsVer=mysql_query($sqlVer);
				}
			}else{
				$kosong = true;
			} */
			
			/* if($kosong == true){
				$sqlVer="INSERT INTO k_klaim_detail
							(klaim_id, fk_id, nilai_klaim, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
						VALUES ('.$klaim_id.', 0, '.$nilaiklaim.', "'.$idKunj.'", "'.$ksoid.'", "'.implode('", "',$value).'", NOW(), "'.$userId.'")';
				//echo "2. ".$sqlVer."<br>";
				$hasil=mysql_query($sqlVer);
			} */
			break;
		case "penerimaan":
			$kosong = false;
			$nilai_terima = $data['totaltarif'];
			$ksoid = ($_REQUEST['kso_id']!="") ? $_REQUEST['kso_id'] : 0;
			if ($idKunj != "" | $idKunj != 0){
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
					
					$sqlVer="INSERT INTO k_klaim_terima_detail
								(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
							VALUES ('.$klaim_terima_id.', '.$klaim_detail_id.', '.$nilai_terima.', "'.$idKunj.'", "'.$ksoid.'", "'.implode('", "',$value).'", NOW(), "'.$userId.'")';
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
				$sqlVer = "INSERT INTO k_klaim_terima_detail
								(klaim_terima_id, klaim_detail_id, nilai_terima, kunjungan_id, kso_id, ".implode(', ',$column).', tgl_act, user_act)
							VALUES ('.$klaim_terima_id.', 0, '.$nilai_terima.', "'.$idKunj.'", "'.$ksoid.'", "'.implode('", "',$value).'", NOW(), "'.$userId.'")';
				//echo "2. ".$sqlVer."<br />";
				$hasil = mysql_query($sqlVer);
			}
			break;
	}
	
	/* $sql = "insert into k_import_klaim(".implode(', ',$column).', tgl_act, user_act) value ("'.implode('", "',$value).'", NOW(), "'.$userId.'")';
	$hasil = mysql_query($sql); */
	
	return $hasil;
}
							
if(!empty($_FILES)) {
	if(is_uploaded_file($_FILES['fileU']['tmp_name'])) {
		$fileName = $_FILES["fileU"]["name"]; // The file name
		$fileTmpLoc = $_FILES["fileU"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["fileU"]["type"]; // The type of file it is
		$fileSize = $_FILES["fileU"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["fileU"]["error"]; // 0 for false... and 1 for true
		$target = 'tmp/'.basename($_FILES['fileU']['name']);
		if (!$fileTmpLoc) { // if file not chosen
			echo "ERROR: Please browse for a file before clicking the upload button.";
			exit();
		}
		if(move_uploaded_file($fileTmpLoc, $target)){
			$file = realpath($target);
			try{
				switch($fileType){
					case "text/plain":
						$fh = fopen($file, "r");
						$i = $sukses = $gagal = 0;
						$array = array();
						while (!feof($fh)) {
							$line = fgets($fh);
							if($i > 0 && str_replace(';','',$line) != ""){
								$data = explode(';',$line);
								$sep = explode('^',$data[97]);
								$array[] = array(
											'kdrs' 			=> $data[0],
											'klsrs' 		=> $data[1],
											'norm' 			=> $data[2],
											'klsrawat' 		=> $data[3],
											'tariffrs' 		=> $data[4],
											'jnsrawat' 		=> $data[5],
											'tglmsk' 		=> formatDate(str_replace('/','-',$data[6])),
											'tglklr' 		=> formatDate(str_replace('/','-',$data[7])),
											'los' 			=> $data[8],
											'tgllhr' 		=> formatDate(str_replace('/','-',$data[9])),
											'umurthn' 		=> $data[10],
											'umurhari' 		=> $data[12],
											'jk' 			=> $data[13],
											'dutama' 		=> $data[15],
											'recid' 		=> $data[76],
											'inacbg' 		=> $data[77],
											'deskripsi' 	=> $data[78],
											'tarif' 		=> $data[79],
											'totaltarif' 	=> $data[94],
											'namapasien' 	=> $data[95],
											'dpjp' 			=> $data[96],
											'sep' 			=> $sep[0],
											'c3' 			=> $data[103]
										);
							}
							$i++;
						}
						
						$baris = count($array);
						for($j=0; $j < $baris; $j++){
							// procentase prograss bar
							/* $k = $j+1;
							$perc = intval($k/$baris * 100);
							$percent = intval($k/$baris * 100)."%"; */
							/* echo ($j+1)." : ";
							print_r($array[$j]);
							echo "<br /><br />"; */
							$hasil = insert($array[$j]);
							//echo "<br /><br />";
							if($hasil) {
								$sukses++;
							} else {
								//print_r($array[$j]);
								$gagal++;
							}
						}
						echo '------------------------------------------------------------------ <br />';
						echo "Data yang berhasil disimpan : ".$sukses."<br />";
						echo "Data yang gagal disimpan : ".$gagal."<br />";
						echo '------------------------------------------------------------------ <br />';
						fclose($fh);
						break;
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
					case 'application/vnd.openxmlformats-officedocument.spreadsheetml.template':
					case 'application/xlsx':
					case 'application/xltx':
						$Spreadsheet = new SpreadsheetReader($file);
						$Sheets = $Spreadsheet -> Sheets();

						$Spreadsheet -> ChangeSheet(0);
						$i = $kosong = 0;
						$sukses = $gagal = 0;
						$array = array();
						foreach ($Spreadsheet as $Key => $Row){
							if (implode('',$Row) != '' && $i > 0){
								$array[] = array(
											'kdrs' 			=> $Row[0],
											'klsrs' 		=> $Row[1],
											'norm' 			=> $Row[2],
											'klsrawat' 		=> $Row[3],
											'tariffrs' 		=> $Row[4],
											'jnsrawat' 		=> $Row[5],
											'tglmsk' 		=> formatDate($Row[6]),
											'tglklr' 		=> formatDate($Row[7]),
											'los' 			=> $Row[8],
											'tgllhr' 		=> formatDate($Row[9]),
											'umurthn' 		=> $Row[10],
											'umurhari' 		=> $Row[12],
											'jk' 			=> $Row[13],
											'dutama' 		=> $Row[15],
											'recid' 		=> $Row[76],
											'inacbg' 		=> $Row[77],
											'deskripsi' 	=> $Row[78],
											'tarif' 		=> $Row[79],
											'totaltarif' 	=> $Row[94],
											'namapasien' 	=> $Row[95],
											'dpjp' 			=> $Row[96],
											'sep' 			=> $Row[97],
											'c3' 			=> $Row[103]
										);
							} else { $kosong++; }
							if($kosong > 5){ break; }
							$i++;
						}
						
						$baris = count($array);
						for($j=0; $j < $baris; $j++){
							// procentase prograss bar
							/* $k = $j+1;
							$perc = intval($k/$baris * 100);
							$percent = intval($k/$baris * 100)."%"; */
							/* echo ($j+1)." : ";
							print_r($array[$j]);
							echo "<br /><br />"; */
							$hasil = insert($array[$j]);
							
							if($hasil) { $sukses++;} 
							else { $gagal++; }
						}
						echo '------------------------------------------------------------------ <br />';
						echo "Data yang berhasil disimpan : ".$sukses."<br />";
						echo "Data yang gagal disimpan : ".$gagal."<br />";
						echo '------------------------------------------------------------------ <br />';
						break;
					default:
						// ExcelFile($filename, $encoding);
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						
						$data->read($file);
						$baris = count($data->sheets[0]["cells"]);
						
						// Proses inserting data
						$sukses = $gagal = 0;
						$array = array();
						for($i = 2; $i <= $baris; $i++){
							// procentase prograss bar
							/* $barisreal = $baris-1;
							$k = $i-1;
							$perc = intval($k/$barisreal * 100);
							$percent = intval($k/$barisreal * 100)."%"; */
							
							$array = array(
										'kdrs' 			=> $data->sheets[0]['cells'][$i][1],
										'klsrs' 		=> $data->sheets[0]['cells'][$i][2],
										'norm' 			=> $data->sheets[0]['cells'][$i][3],
										'klsrawat' 		=> $data->sheets[0]['cells'][$i][4],
										'tariffrs' 		=> $data->sheets[0]['cells'][$i][5],
										'jnsrawat' 		=> $data->sheets[0]['cells'][$i][6],
										'tglmsk' 		=> formatDate($data->sheets[0]['cells'][$i][7]),
										'tglklr' 		=> formatDate($data->sheets[0]['cells'][$i][8]),
										'los' 			=> $data->sheets[0]['cells'][$i][9],
										'tgllhr' 		=> formatDate($data->sheets[0]['cells'][$i][10]),
										'umurthn' 		=> $data->sheets[0]['cells'][$i][11],
										'umurhari' 		=> $data->sheets[0]['cells'][$i][12],
										'jk' 			=> $data->sheets[0]['cells'][$i][13],
										'dutama' 		=> $data->sheets[0]['cells'][$i][16],
										'recid' 		=> $data->sheets[0]['cells'][$i][77],
										'inacbg' 		=> $data->sheets[0]['cells'][$i][78],
										'deskripsi' 	=> $data->sheets[0]['cells'][$i][79],
										'tarif' 		=> $data->sheets[0]['cells'][$i][80],
										'totaltarif' 	=> $data->sheets[0]['cells'][$i][95],
										'namapasien' 	=> $data->sheets[0]['cells'][$i][96],
										'dpjp' 			=> $data->sheets[0]['cells'][$i][97],
										'sep' 			=> $data->sheets[0]['cells'][$i][98],
										'c3' 			=> $data->sheets[0]['cells'][$i][104],
									);
							/* echo ($i-1)." : ";
							print_r($array);
							echo "<br /><br />"; */
							$hasil = insert($array);
							
							if($hasil) { $sukses++; } 
							else { $gagal++; }
						}
						echo '------------------------------------------------------------------ <br />';
						echo "Data yang berhasil disimpan : ".$sukses."<br />";
						echo "Data yang gagal disimpan : ".$gagal."<br />";
						echo '------------------------------------------------------------------ <br />';
						break;
				}
				echo "$fileName import 100% complete";
				unlink($target);
			} catch (Exception $E) {
				echo $E -> getMessage()." - error";
			}
		} else {
			echo "move_uploaded_file function failed";
		}
	} else {
		echo "Please browse for a file before clicking the upload button!";
	}
}
?>
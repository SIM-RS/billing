<?php
	session_start();
	include("billing/koneksi/konek.php");
	$username = $_REQUEST['username'];
	$password = $_REQUEST['key'];
	
	
	
	/* $sql = "SELECT t1.*, u.kode_user, u.kategori, un.UNIT_TIPE, u.unit, un.UNIT_NAME, un.UNIT_KODE
			FROM (SELECT peg.id, peg.username, peg.spesialisasi_id, peg.user_id_inacbg, peg.nama, GROUP_CONCAT(DISTINCT(pm.modul_id)) modul_id, peg.sex
					FROM b_ms_pegawai peg
					LEFT JOIN b_ms_pegawai_modul pm
					   ON pm.pegawai_id = peg.id
					WHERE peg.username = '$username'
					AND peg.pwd = PASSWORD('$password')) t1
			LEFT JOIN $dbapotek.a_user u
			   ON u.kode_user = t1.id
			LEFT JOIN $dbapotek.a_unit un
			   ON un.UNIT_ID = u.unit"; */
	$sql = "SELECT peg.id id, peg.flag, peg.username, peg.spesialisasi_id, peg.user_id_inacbg, peg.nama, GROUP_CONCAT(DISTINCT(mg.modul_id)) modul_id, peg.sex,
				peg.id kode_user, peg.staplikasi AS kategori, pu.unit_id
			FROM b_ms_pegawai peg
			LEFT JOIN $dbadmin.ms_group_petugas gp
			   ON gp.ms_pegawai_id = peg.id
			LEFT JOIN $dbadmin.ms_group mg
			   ON mg.id = gp.ms_group_id
			LEFT JOIN b_ms_pegawai_unit pu
			   ON pu.ms_pegawai_id = peg.id
			WHERE peg.username = '{$username}'
			AND peg.pwd = PASSWORD('{$password}') AND (peg.flag = '1' or peg.flag = '0')";
	// echo $sql."<br>";
	$rs=mysql_query($sql);
	if($rs && mysql_num_rows($rs)>0){
		$rw=mysql_fetch_array($rs);
		if(empty($rw['id']) == true){
			echo "<script type='text/javascript'>
				alert('Maaf Username/Pasword Tidak Tepat!');
				window.location = 'index.php';
			</script>";
		} else {
		
			$hakmodul = explode(',',$rw['modul_id']);
			$_SESSION['modul'] 		= $hakmodul;
			$_SESSION['logon'] 		= 1;
			$_SESSION['pegawai_id'] = $rw['id'];
			$_SESSION['uname']		= $userName;
			$_SESSION['sex']		= $rw['sex'];
			$_SESSION['pegawai_nama'] = $rw['nama'];
			$_SESSION['flag'] 		= $rw['flag'];
			
			foreach($hakmodul as $val){
				switch($val){
					case "1":
						/* SESSION BILLING */
						$_SESSION['userId']			= $rw['id'];
						$_SESSION['userName']		= $rw['username'];
						$_SESSION['unitId']			= $rw['unit_id'];
						$_SESSION['spesialis']		= $rw['spesialisasi_id'];
						$_SESSION['user_id_inacbg']	= $rw['user_id_inacbg'];
						$_SESSION['nm_pegawai']		= $rw['nama'];
						$_SESSION['flag'] 			= $rw['flag'];
						
						$sql1="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id = $rw[id]";
						//echo $sql."<br>";
						$rs1=mysql_query($sql1);
						$rw1=mysql_fetch_array($rs1);
						$_SESSION['group']=$rw1['ms_group_id'];
						
						$sql2="SELECT * FROM b_ms_pegawai_unit WHERE ms_pegawai_id = $rw[id]";
						$rs2=mysql_query($sql2);
						$ii = 0;
						while($rw2=mysql_fetch_array($rs2))
						{
							$_SESSION['unit_tmp'][$ii] = $rw2['unit_id'];
							$ii++;
						}
						
						break;
					case "2":
						/* SESSION APOTEK */
						$sql = "select * from $dbapotek.a_unit where UNIT_TIPE=1 and UNIT_ISAKTIF=1";
						$rs1 = mysql_query($sql);
						if ($rows1=mysql_fetch_array($rs1)) $id_gudang=$rows1["UNIT_ID"];
						//echo "shift=".$shift."<br>";
						
						$sqlUnit = "SELECT u.UNIT_ID, u.UNIT_TIPE, u.UNIT_NAME, u.UNIT_KODE
									FROM b_ms_pegawai peg
									INNER JOIN b_ms_pegawai_unit pu
									   ON pu.ms_pegawai_id = peg.id
									INNER JOIN $dbapotek.a_unit u
									   ON u.UNIT_ID = pu.unit_id
									WHERE peg.id = '".$rw['kode_user']."'";
						$qUnit = mysql_query($sqlUnit);
						$unitID = $unitTipe = $unitName = $unitKode = '';
						if($qUnit && mysql_num_rows($qUnit) > 0){
							$dUnit = mysql_fetch_array($qUnit);
							$unitID   = $dUnit['UNIT_ID'];
							$unitTipe = $dUnit['UNIT_TIPE'];
							$unitName = $dUnit['UNIT_NAME'];
							$unitKode = $dUnit['UNIT_KODE'];
						}
						
						$_SESSION["username"] 		= $username;
						$_SESSION["password"] 		= $password;
						// $_SESSION["shift"]		= $shift;
						$_SESSION["iduser"] 		= $rw['kode_user'];
						$_SESSION["kategori"] 		= $rw['kategori'];
						$_SESSION["ses_unit_tipe"] 	= $unitTipe;
						$_SESSION["ses_idunit"]		= $unitID; // $rw['unit_id'];
						$_SESSION["ses_namaunit"]	= $unitName;
						$_SESSION["ses_kodeunit"]	= $unitKode;
						$_SESSION["ses_id_gudang"]	= $id_gudang;
						break;
						
					case "3":
						/* SESSION KEUANGAN */
						/* $sKeu = "SELECT hak_akses FROM $dbkeuangan.k_ms_user_hak WHERE pegawai_id = ".$rw['id'];
						$qKeu = mysql_query($sKeu);
						if($qKeu)
						{ */
							// $dKeu = mysql_fetch_array($qKeu);
							$_SESSION['user']	= $username;
							$_SESSION['id'] 	= $rw['id'];
							$_SESSION['hak'] 	= $rw['kategori']; // $dKeu['hak_akses'];
						// }
						break;
					
					case "4":
						/* SESSION AKUNTANSI */
						$sAku = "select kategori from $dbakuntansi.user_master where kode_user = ".$rw['id'];
						$qAku = mysql_query($sAku) or die (mysql_error());
						if($qAku)
						{
							$dAku = mysql_fetch_array($qAku);
							$_SESSION["akun_username"]	= $username;
							$_SESSION["akun_password"]	= $password;
							$_SESSION["akun_iduser"]	= $rw['id'];
							$_SESSION["akun_kategori"]	= $dAku['kategori'];
							$_SESSION["akun_ses_idunit"]= "1";
						}
						break;
					case "5":
						/* SESSION ADMINISTRATOR */
						$_SESSION['user_id'] 	= $rw['id'];
						$_SESSION['userid'] 	= $rw['id'];
						break;
					case "6":
						/* SESSION ADMINISTRATOR */
						$_SESSION['user_id'] 	= $rw['id'];
						$_SESSION['userid'] 	= $rw['id'];
						break;
					case "7":
						/* SESSION ADMINISTRATOR */
						$_SESSION['user_id'] 	= $rw['id'];
						$_SESSION['userid'] 	= $rw['id'];
						break;
				}
			}
			
			$q = "select * from b_profil order by id ASC"; 
			$s = mysql_query($q);
			$d = mysql_fetch_array($s);
			$_SESSION['namaP'] = $d['nama']; 
			$_SESSION['alamatP'] = $d['alamat']; 
			$_SESSION['kode_posP'] = $d['kode_pos']; 
			$_SESSION['tlpP'] = $d['no_tlp']; 
			$_SESSION['faxP'] = $d['fax']; 
			$_SESSION['emailP'] = $d['email']; 
			$_SESSION['pemkabP'] = $d['pemkab']; 
			$_SESSION['kotaP'] = $d['kota']; 
			$_SESSION['tipe_kotaP'] = $d['tipe_kota']; 
			$_SESSION['propinsiP'] = $d['propinsi']; 
			$_SESSION['kecP'] = $d['kecamatan']; 
			
			/*for($jj=0;$jj<=count($_SESSION['unit_tmp']);$jj++)
			{
				echo $_SESSION['unit_tmp'][$jj]."<br>";
			}*/
			
			header("location:portal.php");
		}
	} else {
		echo "<script type='text/javascript'>
				alert('Maaf Username/Pasword Tidak Tepat!');
				window.location = 'index.php';
			</script>";
	}
?>
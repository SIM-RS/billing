<?php
include("../koneksi/konek_billing_inacbg.php");
//====================================================================
$dilayani = $_REQUEST['dilayani'];
$no_rm = $_REQUEST['no_rm'];
$tgl = tglSQL($_REQUEST['tgl']);
$tmpLay = $_REQUEST['tmpLay'];
$grd = strtolower($_REQUEST["grd"]);
//=======Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$act = $_GET['act'];
$fdata = $_REQUEST['fdata'];
$user_act=$_REQUEST['user_act'];
$user_id = $_REQUEST['user_id_inacbg'];
//===============================
$statusProses='';
$msg="";

switch(strtolower($_REQUEST['act'])) {
	case 'updatenosjp':
		$sUp="update b_kunjungan set no_sjp='".$_REQUEST['no_sjp']."' where id='".$_REQUEST['kunj_id']."'";
		$qUp=mysql_query($sUp,$koneksi_billing);
		if(mysql_affected_rows($koneksi_billing)>0){
			$res="ok";	
		}
		else{
			$res="error";	
		}
		echo $res;
		return;
		break;
    case 'transfer':
		//$user_id=1631; // user inacbg -> ima
		$sql="SELECT p.person_nm FROM inacbg.xocp_users u INNER JOIN inacbg.xocp_persons p ON u.person_id=p.person_id WHERE u.user_id='$user_id'";
		$rsUserCBG=mysql_query($sql);
		$rwUserCBG=mysql_fetch_array($rsUserCBG);
		$usernmcbg=$rwUserCBG["person_nm"];

		$sqlPlg="SELECT * FROM $dbbilling.b_kunjungan WHERE id='$kunjungan_id'";
		$rsPlg=mysql_query($sqlPlg,$koneksi_billing);
		$rwPlg=mysql_fetch_array($rsPlg);
		$tgl_keluarK=$rwPlg["tgl_pulang"];
		$tgl_waktu_keluarK=$rwPlg["tgl_pulang"];
		
		$arfdata=explode(chr(6),$fdata);
		if ($dilayani==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$norm=$cdata[0];
				$nm_pas=$cdata[1];
				$gender=$cdata[2];
				if($gender=='L'){
					$gender_cd='m';
				}
				else{
					$gender_cd='f';
				}
				$tgl_lhr=tglSQL($cdata[3]);
				$alamat=$cdata[4];
				$nm_ortu=$cdata[5];
				$no_anggota=$cdata[6];
				$no_sjp=$cdata[7];
				$kunjungan_id=$cdata[8];
				$pelayanan_id=$cdata[9];
				
				$sKeluar="SELECT cara_keluar,keadaan_keluar,tgl_act,DATE_FORMAT(tgl_act,'%Y-%m-%d') tgl FROM b_pasien_keluar WHERE kunjungan_id=".$kunjungan_id;
				$qKeluar=mysql_query($sKeluar,$koneksi_billing);
				$rKeluar=mysql_fetch_array($qKeluar);
				
				$cara_keluar='home';
				if($rKeluar['cara_keluar']=='Atas Ijin Dokter'){
					$cara_keluar='home';
				}
				else if($rKeluar['cara_keluar']=='Dirujuk'){
					$cara_keluar='transfer';
				}
				else if($rKeluar['cara_keluar']=='Pulang Paksa'){
					$cara_keluar='refuse';
				}
				else if($rKeluar['cara_keluar']=='Meninggal'){
					$cara_keluar='deceased';
				}
				$tgl_keluar=$rKeluar['tgl'];
				$tgl_waktu_keluar=$rKeluar['tgl_act'];
				
				if($tmpLay==0){
					$stay_ind='n';
					$tgl_keluar=$tgl;
				}
				else{
					$stay_ind='y';
					$tgl_keluar=$tgl_keluarK;
					$tgl_waktu_keluar=$tgl_waktu_keluarK;
				}
				
				// tarif tindakan
				if($tmpLay==0){
					$sBiaya="SELECT 
							  IF(SUM(b_tindakan.biaya) IS NULL,0,SUM(b_tindakan.biaya)) AS total_nilai 
							FROM
							  b_pelayanan 
							  INNER JOIN b_tindakan 
								ON b_tindakan.pelayanan_id = b_pelayanan.id 
							  INNER JOIN b_ms_tindakan_kelas 
								ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
							  INNER JOIN b_ms_tindakan 
								ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
							WHERE b_pelayanan.kunjungan_id = '".$kunjungan_id."' 
							  AND b_pelayanan.jenis_kunjungan <> 3";
				}
				else{
					$sBiaya="SELECT 
							  SUM(nilai) AS total_nilai 
							FROM
							  (SELECT 
								SUM(tbl_tindakan.biaya) AS nilai 
							  FROM
								(SELECT 
								  b_ms_unit.nama unit,
								  b_ms_tindakan.nama,
								  b_tindakan.biaya 
								FROM
								  b_pelayanan 
								  INNER JOIN b_ms_unit 
									ON b_ms_unit.id = b_pelayanan.unit_id 
								  INNER JOIN b_tindakan 
									ON b_tindakan.pelayanan_id = b_pelayanan.id 
								  INNER JOIN b_ms_tindakan_kelas 
									ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
								  INNER JOIN b_ms_tindakan 
									ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
								WHERE b_pelayanan.kunjungan_id = '".$kunjungan_id."' 
								  AND b_pelayanan.jenis_kunjungan = 3
								  ) AS tbl_tindakan 
							  UNION
							  SELECT 
								SUM(kmr.biaya) AS nilai 
							  FROM
								(SELECT 
								  tk.id,
								  mk.id idKmr,
								  mk.kode kdKmr,
								  mk.nama nmKmr,
								  mKls.nama nmKls,
								  DATE_FORMAT(tk.tgl_in, '%d-%m-%Y') tgl_in,
								  IF(
									tk.status_out = 0,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  1,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * (tk.tarip),
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  0,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * (tk.tarip)
								  ) biaya,
								  IF(
									tk.status_out = 0,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  1,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * tk.beban_kso,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  0,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * tk.beban_kso
								  ) biaya_kso,
								  IF(
									tk.status_out = 0,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  1,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * tk.beban_pasien,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  0,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									) * tk.beban_pasien
								  ) biaya_pasien,
								  tk.bayar,
								  IF(
									tk.status_out = 0,
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  1,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									),
									IF(
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in) = 0,
									  0,
									  DATEDIFF(IFNULL(tk.tgl_out, NOW()), tk.tgl_in)
									)
								  ) cHari 
								FROM
								  b_tindakan_kamar tk 
								  INNER JOIN b_pelayanan p 
									ON tk.pelayanan_id = p.id 
								  LEFT JOIN b_ms_kamar mk 
									ON tk.kamar_id = mk.id 
								  LEFT JOIN b_ms_kelas mKls 
									ON tk.kelas_id = mKls.id 
								WHERE kunjungan_id = '".$kunjungan_id."') AS kmr) AS gab";
				}
				//echo $sBiaya."<br><br>";
				$qBiaya=mysql_query($sBiaya,$koneksi_billing);
				$rwBiaya=mysql_fetch_array($qBiaya);
				$tot_biaya_RS=$rwBiaya['total_nilai'];
				
				if($tmpLay==0){
					$sDok="SELECT DISTINCT 
						  pg.nama 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_tindakan t 
							ON t.kunjungan_id = k.id 
						  LEFT JOIN b_ms_pegawai pg 
							ON pg.id = t.user_id
						WHERE k.id='".$kunjungan_id."' 
						  AND p.jenis_kunjungan<>3 
						  AND pg.pegawai_jenis = 8";	
				}
				else{
					$sDok="SELECT DISTINCT 
						  pg.nama 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_tindakan t 
							ON t.kunjungan_id = k.id 
						  LEFT JOIN b_ms_pegawai pg 
							ON pg.id = t.user_id 
						WHERE p.id = '".$pelayanan_id."' 
						  AND p.jenis_kunjungan = 3 
						  AND pg.pegawai_jenis = 8";
				}
				//echo $sDok."<br><br>";
				$qDok=mysql_query($sDok,$koneksi_billing);
				$rwDok=mysql_fetch_array($qDok);
				$dokter=$rwDok['nama'];
				
				$scek="SELECT * FROM mpi.patients WHERE mrn='".$cdata[0]."'";
				//echo $scek."<br><br>";
				$qcek=mysql_query($scek,$koneksi_inacbg);
				$rwCek=mysql_fetch_array($qcek);
				$patien_id=$rwCek['patient_id'];
				
				if(mysql_num_rows($qcek)==0){
					
					// insert ke mpi.persons
					$insert1="INSERT INTO mpi.persons (person_nm,gender_cd,date_of_birth,created_dttm,updated_dttm,updated_user_id,address_txt,father_nm) VALUES ('$nm_pas','$gender_cd','$tgl_lhr',now(),now(),'$user_id','$alamat','$nm_ortu')";
					//echo $insert1."<br><br>";
					mysql_query($insert1,$koneksi_inacbg);
					$person_id=mysql_insert_id($koneksi_inacbg);
					
					// insert ke mpi.patients
					$insert2="INSERT INTO mpi.patients (person_id,mrn,created_dttm,created_user_id,updated_dttm,updated_user_id) VALUES ('$person_id','$norm',now(),'$user_id',now(),'$user_id')";
					//echo $insert2."<br><br>";
					mysql_query($insert2,$koneksi_inacbg);
					$patien_id=mysql_insert_id($koneksi_inacbg);
					
					// insert ke inacbg.xocp_persons
					$insert3="INSERT INTO inacbg.xocp_persons (person_nm,parent_nm,birth_dttm,adm_gender_cd,addr_txt,created_dttm) VALUES ('$nm_pas','$nm_ortu','$tgl_lhr','$gender_cd','$alamat',now())";
					//echo $insert3."<br><br>";
					mysql_query($insert3,$koneksi_inacbg);
					$person_id_inacbg=mysql_insert_id($koneksi_inacbg);
					
					// insert ke inacbg.xocp_ehr_patient
					$insert4="INSERT INTO inacbg.xocp_ehr_patient (patient_id,patient_ext_id,status_cd,person_id,created_dttm) VALUES ('$patien_id','$norm','active','$person_id_inacbg',now())";
					//echo $insert4."<br><br>";
					mysql_query($insert4,$koneksi_inacbg);
				}
				
				$scek2="SELECT * FROM mpi.patient_payplan WHERE patient_id='".$patien_id."' AND payplan_object='2' AND payplan_id='5'";
				//echo $scek2."<br><br>";
				$qcek2=mysql_query($scek2,$koneksi_inacbg);
				if(mysql_num_rows($qcek2)==0){
					// insert ke mpi.patient_payplan
					$insert5="INSERT INTO mpi.patient_payplan (patient_id,payplan_object,payplan_id,member_no,default_payplan,created_dttm,created_user_id,updated_dttm,updated_user_id) VALUES ('$patien_id','2','5','$no_anggota','$tmpLay',now(),'$user_id',now(),'$user_id')";
					//echo $insert5."<br><br>";
					mysql_query($insert5,$koneksi_inacbg);
					if (mysql_errno()>0){
						$statusProses='Error';
					}
				}
				
				$sCek62="SELECT * FROM mpi.patient_sjp WHERE patient_id='".$patien_id."' AND sjp_no='".$no_sjp."'";
				//echo $sCek62."<br><br>";
				$kCek62=mysql_query($sCek62,$koneksi_inacbg);
				if(mysql_num_rows($kCek62)>0){
					$rwCek62=mysql_fetch_array($kCek62);
					$sjp_id=$rwCek62['sjp_id'];
					$admission_id=$rwCek62['admission_id'];
				}
				else{
					// insert ke mpi.patient_sjp
					$sCek6="SELECT IF(MAX(sjp_id) IS NULL,1,(MAX(sjp_id)+1)) sjp_id FROM mpi.patient_sjp WHERE patient_id='".$patien_id."'";
					//echo $sCek6."<br><br>";
					$kCek6=mysql_query($sCek6,$koneksi_inacbg);
					$rwCek6=mysql_fetch_array($kCek6);
					$sjp_id=$rwCek6['sjp_id'];
					$admission_id=$sjp_id;
					
					$insert6="INSERT INTO mpi.patient_sjp (patient_id,sjp_id,sjp_no,payplan_id,payplan_object,admission_id,statement_dttm,created_dttm,created_user_id,created_system_id) VALUES ('$patien_id','$sjp_id','$no_sjp','5','2','$admission_id',now(),now(),'$user_id|$usernmcbg','$tmpLay')";
					//echo $insert6."<br><br>";
					mysql_query($insert6,$koneksi_inacbg);
					if (mysql_errno()>0){
						$statusProses='Error';
					}
				}
				
				
				$sCek7="SELECT * FROM mpi.admissions WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
				//echo $sCek7."<br><br>";
				$kCek7=mysql_query($sCek7,$koneksi_inacbg);
				if(mysql_num_rows($kCek7)==0){
					
					// insert ke mpi.admissions
					$insert7="INSERT INTO mpi.admissions (patient_id,admission_id,admission_dttm,inpatient_ind,discharge,discharge_dttm,discharge_user_id,discharge_system_id,payplan_object,payplan_id,created_dttm,created_user_id,created_system_id,updated_dttm,updated_user_id,updated_system_id) VALUES ('$patien_id','$admission_id','$tgl','$tmpLay','$cara_keluar','$tgl_keluar','$user_id','0','2','5',now(),'$user_id|$usernmcbg',0,now(),'$user_id|$usernmcbg','0')";
					//echo $insert7."<br><br>";
					mysql_query($insert7,$koneksi_inacbg);
					if (mysql_errno()>0){
						$statusProses='Error';
					}
				}
				
				$sCek8="SELECT * FROM inacbg.xocp_ehr_patient_admission WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
				//echo $sCek8."<br><br>";
				$kCek8=mysql_query($sCek8,$koneksi_inacbg);
				if(mysql_num_rows($kCek8)==0){
					// insert ke inacbg.xocp_ehr_patient_admission
					$insert8="INSERT INTO inacbg.xocp_ehr_patient_admission (patient_id,admission_id,org_id,admission_dttm,discharge,discharge_dttm,discharge_dt,payplan_id,payplan_attr,payplan_attr2,payplan_dttm,sjp_dttm,stay_ind,kelas_rawat,real_cost,dpjp_nm) VALUES ('$patien_id','$admission_id','0','$tgl','$cara_keluar','$tgl_waktu_keluar','$tgl_keluar','5','$no_anggota','$no_sjp',now(),now(),'$stay_ind','3','$tot_biaya_RS','$dokter')";
					//echo $insert8."<br><br>";
					mysql_query($insert8,$koneksi_inacbg);
					if (mysql_errno()>0){
						$statusProses='Error';
					}
				}
				
				
				$sCek91="SELECT * FROM inacbg.xocp_ehr_discharge_diag WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
				//echo $sCek91."<br><br>";
				$kCek91=mysql_query($sCek91,$koneksi_inacbg);
				if(mysql_num_rows($kCek91)==0){
				
					if($tmpLay==0){
						$sDiag="SELECT md.kode,md.nama,d.primer 
FROM b_diagnosa d INNER JOIN b_ms_diagnosa md ON d.ms_diagnosa_id = md.id 
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
WHERE d.kunjungan_id = ".$kunjungan_id." AND p.jenis_kunjungan<>3  ORDER BY d.primer DESC";
					}
					else{
						$sDiag="SELECT 
							  md.kode,md.nama,d.primer 
							FROM
							  b_diagnosa d
							  INNER JOIN b_ms_diagnosa md
							  ON d.ms_diagnosa_id = md.id 
							WHERE d.kunjungan_id = ".$kunjungan_id." ORDER BY d.primer DESC";
					}
					//echo $sDiag."<br><br>";
					$qDiag=mysql_query($sDiag,$koneksi_billing);
					//$admission_id=1;
					while($rwDiag=mysql_fetch_array($qDiag)){
						$kode_icd=$rwDiag['kode'];
						if($rwDiag['primer']==1){
							$diag_st='primary';
						}
						else{
							$diag_st='secondary';
						}
						
						// insert ke inacbg.xocp_ehr_discharge_diag
						$sCek9="SELECT IF(MAX(diag_id) IS NULL,1,(MAX(diag_id)+1)) diag_id FROM inacbg.xocp_ehr_discharge_diag 
								WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
						//echo $sCek9."<br><br>";
						$kCek9=mysql_query($sCek9);
						$rwCek9=mysql_fetch_array($kCek9);
						$diag_id=$rwCek9['diag_id'];
						
						$insert9="INSERT INTO inacbg.xocp_ehr_discharge_diag (patient_id,admission_id,diag_id,code,created_dttm,created_user_id,diag_st) VALUES ('$patien_id','$admission_id','$diag_id','$kode_icd',now(),'$user_id','$diag_st')";
						//echo $insert9."<br><br>";
						mysql_query($insert9,$koneksi_inacbg);
						if (mysql_errno()>0){
							$statusProses='Error';
						}
					}
				}
				
				
				// ********************** insert tindakan -> hanya yang tindakan icd9cm ***********************
				$sCek10="SELECT * FROM inacbg.xocp_ehr_discharge_proc WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
				//echo $sCek91."<br><br>";
				$kCek10=mysql_query($sCek10,$koneksi_inacbg);
				if(mysql_num_rows($kCek10)==0){
				
					if($tmpLay==0){
						$fJns="AND b_pelayanan.jenis_kunjungan <> 3";
					}
					else{
						$fJns="AND b_pelayanan.jenis_kunjungan = 3";
					}
					$sTind="SELECT 
							  b_ms_unit.nama unit,
							  b_ms_tindakan.id,
							  b_ms_tindakan.kode_icd9cm,
							  b_ms_tindakan.nama,
							  b_tindakan.biaya 
							FROM
							  b_pelayanan 
							  INNER JOIN b_ms_unit 
								ON b_ms_unit.id = b_pelayanan.unit_id 
							  INNER JOIN b_tindakan 
								ON b_tindakan.pelayanan_id = b_pelayanan.id 
							  INNER JOIN b_ms_tindakan_kelas 
								ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
							  INNER JOIN b_ms_tindakan 
								ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
							WHERE b_pelayanan.kunjungan_id = '".$kunjungan_id."' 
							  $fJns 
							  AND (
								b_ms_tindakan.kode_icd9cm IS NOT NULL 
								OR b_ms_tindakan.kode_icd9cm = ''
							  ) 
							ORDER BY b_ms_tindakan.kode_icd9cm";
					//echo $sTind."<br><br>";
					$qTind=mysql_query($sTind,$koneksi_billing);
					while($rwTind=mysql_fetch_array($qTind)){
						$kode_icd9cm=$rwTind['kode_icd9cm'];
						// insert ke inacbg.xocp_ehr_discharge_proc
						$sCek101="SELECT IF(MAX(proc_id) IS NULL,1,(MAX(proc_id)+1)) proc_id FROM inacbg.xocp_ehr_discharge_proc 
								WHERE patient_id='".$patien_id."' AND admission_id='".$admission_id."'";
						//echo $sCek101."<br><br>";
						$kCek101=mysql_query($sCek101);
						$rwCek101=mysql_fetch_array($kCek101);
						$proc_id=$rwCek101['proc_id'];
						
						$insert10="INSERT INTO inacbg.xocp_ehr_discharge_proc (patient_id,admission_id,proc_id,code,created_dttm,created_user_id) VALUES ('$patien_id','$admission_id','$proc_id','$kode_icd9cm',now(),'$user_id')";
						//echo $insert10."<br><br>";
						mysql_query($insert10,$koneksi_inacbg);
						if (mysql_errno()>0){
							$statusProses='Error';
						}
					}
				}				
				// =====================================
				
				if($statusProses!='Error'){
					$sql="insert into transfer_inacbg (tgl,jenis_rawat,pelayanan_id,kunjungan_id,no_rm,nama,tgl_act,user_act) values ('$tgl','$tmpLay','$pelayanan_id','$kunjungan_id','$norm','$nm_pas',now(),'$user_act')";
					//echo $sql."<br><br>";
					mysql_query($sql,$koneksi_billing);
				}
			}
		}
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {	
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
	
    if ($sorting=="") {
        $sorting="id"; //default sort
    }
    
    if($no_rm != ""){
		$filter = " and no_rm = '$no_rm' ";
    }

    if($grd == "true") {
		if($dilayani==0){
			if ($tmpLay==0){
				$sql="SELECT * FROM (SELECT gab.* FROM (SELECT k.id,k.pasien_id,k.kso_id,k.unit_id,mp.no_rm,mp.nama,mp.sex,kso.nama namakso,mu.nama unit,mp.alamat,
	DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tgl_lahir,mp.nama_ortu,k.no_anggota,k.no_sjp 
	FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
	INNER JOIN b_ms_unit mu ON k.unit_id=mu.id
	WHERE k.tgl='$tgl' AND mu.inap=0 AND k.kso_id IN ($id_kso_inacbg)) gab LEFT JOIN transfer_inacbg ti ON ti.kunjungan_id=gab.id
	WHERE ti.id IS NULL) tbl ".$filter." ORDER BY ".$sorting;
			}else{
				$sql="SELECT * FROM (SELECT gab.* FROM (SELECT k.id,k.pasien_id,p.kso_id,p.unit_id,mp.no_rm,mp.nama,mp.sex,kso.nama namakso,mu.nama unit,mp.alamat,
	DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tgl_lahir,mp.nama_ortu,k.no_anggota,k.no_sjp,p.id pelayanan_id 
	FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
	INNER JOIN b_ms_kso kso ON p.kso_id=kso.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
	WHERE p.tgl='$tgl' AND mu.inap=1 AND p.kso_id IN ($id_kso_inacbg)) gab LEFT JOIN transfer_inacbg ti ON ti.pelayanan_id=gab.pelayanan_id
	WHERE ti.id IS NULL) tbl ".$filter." ORDER BY ".$sorting;
			}
		}
		else{
			if ($tmpLay==0){
				$sql="SELECT * FROM (SELECT gab.* FROM (SELECT k.id,k.pasien_id,k.kso_id,k.unit_id,mp.no_rm,mp.nama,mp.sex,kso.nama namakso,mu.nama unit,mp.alamat,
	DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tgl_lahir,mp.nama_ortu,k.no_anggota,k.no_sjp 
	FROM b_kunjungan k INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
	INNER JOIN b_ms_unit mu ON k.unit_id=mu.id
	WHERE k.tgl='$tgl' AND mu.inap=0 AND k.kso_id IN ($id_kso_inacbg)) gab INNER JOIN transfer_inacbg ti ON ti.kunjungan_id=gab.id) tbl ".$filter." ORDER BY ".$sorting;
			}else{
				$sql="SELECT * FROM (SELECT gab.* FROM (SELECT k.id,k.pasien_id,p.kso_id,p.unit_id,mp.no_rm,mp.nama,mp.sex,kso.nama namakso,mu.nama unit,mp.alamat,
	DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tgl_lahir,mp.nama_ortu,k.no_anggota,k.no_sjp,p.id pelayanan_id 
	FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
	INNER JOIN b_ms_kso kso ON p.kso_id=kso.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
	WHERE p.tgl='$tgl' AND mu.inap=1 AND p.kso_id IN ($id_kso_inacbg)) gab INNER JOIN transfer_inacbg ti ON ti.pelayanan_id=gab.pelayanan_id) tbl ".$filter." ORDER BY ".$sorting;
			}
		}
	}
	//echo $sql;
    $rs=mysql_query($sql,$koneksi_billing);
    
	$jmldata=mysql_num_rows($rs);
	
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	
	$sql=$sql." limit $tpage,$perpage";
	$rs=mysql_query($sql,$koneksi_billing);
	
		
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$sisip=$rows["no_rm"]."|".$rows["nama"]."|".$rows["no_anggota"]."|".$rows["no_sjp"]."|".$rows["id"]."|".$rows["pelayanan_id"];
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3)."0".chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rows["namakso"].chr(3).$rows['no_sjp'].chr(3).$rows['unit'].chr(3).$rows["alamat"].chr(3).$rows["tgl_lahir"].chr(3).$rows["nama_ortu"].chr(6);
        }
    }
  
    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
	else{
		$dt="0".chr(5).chr(5).$_REQUEST['act'];
	}
	
	
    mysql_free_result($rs);
}
mysql_close($koneksi_billing);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>
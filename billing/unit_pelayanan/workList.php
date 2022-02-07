<body bgcolor="transparance">
<?
include("../koneksi/konek_pacs.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$id_kunjungan = $_REQUEST['id_kunjungan'];
$studyuid = $_REQUEST['studyuid'];
$no_rm = $_REQUEST['no_rm'];
$sex = $_REQUEST['sex'];
$tipe = $_REQUEST['tipe'];
$nama = $_REQUEST['nama'];
$data12 = $_GET['data12'];
$tgl12 = tglSQL($_GET['tgl12']);
$dokRad = $_GET['dokRad'];
$txtKetR = $_GET['txtKetR'];
//$data22 = explode('|',$data12);
//$data12 = "A|B|C|D";
$data22 = explode('|', $data12);
//$pieces = explode(" ", $pizza);
//echo $data12;
//echo count($data22);

if($tipe == 1)
{
	$query1="delete from b_modality_worklist where id_pelayanan = $id_pelayanan and transfer = 0";
	$execQuery1 = mysql_query($query1,$koneksi_billing);

//$data22 = explode('|',$data12);

//echo count($data22);

	for($i = 0;$i <= count($data22)-2;$i++)
	{
		$Spass = "select nama from b_ms_pasien where no_rm = '{$no_rm}'";
		$Qpass = mysql_query($Spass);
		$dPass = mysql_fetch_array($Qpass);
		$nama = $dPass['nama'];
		
		$queryI = "insert into b_modality_worklist(id_pelayanan,no_rm,studyuid,kelamin,nm_pasien,status,modality,tgl_periksa,dok_pemeriksa,ket_pemeriksaan) 		values($id_pelayanan,'$no_rm',CONCAT('$studyuid','','$i','.',DATE_FORMAT(NOW(),'%Y'),'.',DATE_FORMAT(NOW(),'%m'),'.',DATE_FORMAT(NOW(),'%d'),'.',DATE_FORMAT(NOW(),'%H'),'.',DATE_FORMAT(NOW(),'%i'),'.',DATE_FORMAT(NOW(),'%s')),'$sex','$nama',1,'$data22[$i]','$tgl12','$dokRad','$txtKetR')";
		$rqueryI = mysql_query($queryI,$koneksi_billing);
	}
}elseif($tipe == 0)
{
	$query1="SELECT * FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
	$execQuery1 = mysql_query($query1,$koneksi_billing);
	while($dquery1 = mysql_fetch_array($execQuery1))
	{
		$queryD1 = "delete from worklist where studyuid = '$dquery1[studyuid]'";
		$execqueryD1 = mysql_query($queryD1,$koneksi_pacs);
		
		$queryD2 = "delete from scheduledps where studyuid = '$dquery1[studyuid]'";
		$execqueryD2 = mysql_query($queryD2,$koneksi_pacs);
		
		$queryD3 = "delete from requestedprocedure where studyuid = '$dquery1[studyuid]'";
		$execqueryD3 = mysql_query($queryD3,$koneksi_pacs);
	}
	
		$query12 ="SELECT DISTINCT * FROM b_ms_pasien WHERE no_rm = '$no_rm'";
		$execQuery2 = mysql_query($query12,$koneksi_billing);
		$dquery2 = mysql_fetch_array($execQuery2);
		
		/*
		$queryI1 = "insert into worklist(studyuid,patientname,patientid,birthdate,sex,accessionnum)
		SELECT DISTINCT studyuid,nm_pasien,no_rm,'$dquery2[tgl_lahir]',kelamin,CONCAT(DATE_FORMAT(CURDATE(),'%Y%m%d'),'-',no_rm) AS accessionnum 
FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$execqueryI1 = mysql_query($queryI1,$koneksi_pacs);
		*/
		$sql1="SELECT DISTINCT studyuid,nm_pasien,no_rm,'$dquery2[tgl_lahir]' as tgl_lahir,kelamin,CONCAT(DATE_FORMAT(CURDATE(),'%Y%m%d'),'-',no_rm) AS accessionnum 
FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$queri1=mysql_query($sql1,$koneksi_billing);
		while($rw1=mysql_fetch_array($queri1)){
			$ins1="insert into worklist(studyuid,patientname,patientid,birthdate,sex,accessionnum) values ('".$rw1['studyuid']."','".$rw1['nm_pasien']."','".$rw1['no_rm']."','".$rw1['tgl_lahir']."','".$rw1['kelamin']."','".$rw1['accessionnum']."')";
			mysql_query($ins1,$koneksi_pacs);
		}
		
		/*
		$queryI2 = "insert into scheduledps(studyuid,aetitle,startdate,starttime,modality)
		SELECT studyuid, 'WORKLIST', CURDATE() AS startdate, DATE_FORMAT(now(), '%T') AS starttime, modality 
FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$execqueryI2 = mysql_query($queryI2,$koneksi_pacs);
		*/
		
		$sql2="SELECT studyuid, 'WORKLIST' as worklist, CURDATE() AS startdate, DATE_FORMAT(now(), '%T') AS starttime, modality 
FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$queri2=mysql_query($sql2,$koneksi_billing);
		while($rw2=mysql_fetch_array($queri2)){
			$ins2="insert into scheduledps(studyuid,aetitle,startdate,starttime,modality) values ('".$rw2['studyuid']."','".$rw2['worklist']."','".$rw2['startdate']."','".$rw2['starttime']."','".$rw2['modality']."')";
			mysql_query($ins2,$koneksi_pacs);
		}
		
		/*
		$queryI3 = "insert into requestedprocedure(studyuid,id)
		SELECT studyuid, CONCAT(DATE_FORMAT(CURDATE(),'%Y%m%d'),'-',no_rm) AS id FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$execqueryI3 = mysql_query($queryI3,$koneksi_pacs);
		*/
		
		$sql3="SELECT studyuid, CONCAT(DATE_FORMAT(CURDATE(),'%Y%m%d'),'-',no_rm) AS id FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan and transfer = 0";
		$queri3=mysql_query($sql3,$koneksi_billing);
		while($rw3=mysql_fetch_array($queri3)){
			$ins3="insert into requestedprocedure(studyuid,id) values ('".$rw3['studyuid']."','".$rw3['id']."')";
			mysql_query($ins3,$koneksi_pacs);
		}
		
	$queryBD = "DELETE FROM dicomworklist WHERE accessionN REGEXP '$id_pelayanan.'";
	$execqueryBD = mysql_query($queryBD,$koneksi_pacs);
	
	$queryBN = "SELECT DISTINCT b.nama
FROM b_modality_worklist a LEFT JOIN b_ms_pegawai b ON a.dok_pemeriksa = b.id
WHERE a.id_pelayanan = $id_pelayanan AND a.transfer = 0";
	$exqueryBN = mysql_query($queryBN,$koneksi_billing);
	$dqueryBN = mysql_fetch_array($exqueryBN);
	
	$queryBN1 = "SELECT b.nama
FROM b_pelayanan a LEFT JOIN b_ms_pegawai b ON a.dokter_id = b.id
WHERE a.id = $id_pelayanan";
	$exqueryBN1 = mysql_query($queryBN1,$koneksi_billing);
	$dqueryBN1 = mysql_fetch_array($exqueryBN1);
	
	$jj = 1;
	
	$queryBN2="SELECT id_pelayanan, no_rm, nm_pasien, '$dquery2[tgl_lahir]' as tgl_lahir, kelamin, '$dqueryBN1[nama]' as dok_rujuk, modality, tgl_periksa, '$dqueryBN[nama]' as dok_pelaksana, ket_pemeriksaan  
FROM b_modality_worklist
WHERE id_pelayanan = $id_pelayanan and transfer = 0";
	$execqueryBN2 = mysql_query($queryBN2,$koneksi_billing);
	while($dqueryBN2 = mysql_fetch_array($execqueryBN2))
	{
		$insB="insert into $worklistDB.dicomworklist(AccessionN,PatientID,PatientNam,PatientBir,PatientSex,ReqPhysici,Modality,StartDate,PerfPhysic,SchedPSDes) values ('".$dqueryBN2['id_pelayanan']."".$jj."','".$dqueryBN2['no_rm']."','".$dqueryBN2['nm_pasien']."',DATE_FORMAT('".$dqueryBN2['tgl_lahir']."','%Y%m%d'),'".$dqueryBN2['kelamin']."','".$dqueryBN2['dok_rujuk']."','".$dqueryBN2['modality']."',DATE_FORMAT('".$dqueryBN2['tgl_periksa']."','%Y%m%d'),'".$dqueryBN2['dok_pelaksana']."','".$dqueryBN2['ket_pemeriksaan']."')";
			mysql_query($insB,$koneksi_pacs);
			$jj++;
	}
	
	$query1="SELECT * FROM b_modality_worklist WHERE id_pelayanan = $id_pelayanan";
	$execQuery1 = mysql_query($query1,$koneksi_billing);
	
	while($dquery1 = mysql_fetch_array($execQuery1))
	{
		$queryU1 = "update b_modality_worklist set transfer = 1 where id = $dquery1[id]";
		$execqueryU1 = mysql_query($queryU1,$koneksi_billing);
	}
}

?>
<!--<span style="color:#F00"></span>-->
</body>
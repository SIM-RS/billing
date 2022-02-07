<?php 
$userId = $_REQUEST['userId'];
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="mp.nama";
$defaultsort1="mp.nama";
$sorting=$_REQUEST["sorting"];
$sorting1=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$filter1=$_REQUEST["filter"];
//===============================
//nipR,namaR,tmpLahirR,tglLahirR,almtR,noTlpR,sexR,agamaR,status,SpeR,cmbjnsR,cmbstsR,cmbgroup2R,userNameR,passR

$idGroup=$_GET['idGroup'];
$data=$_GET['data'];
$nipR=$_GET['niP'];
$namaR=$_GET['namaR'];
$tmpLahirR=$_GET["tmpLahirR"];
$tglLahirR=tglSQL($_GET["tglLahirR"]);
$almtR=$_GET['almtR'];
$noTlpR=$_GET['noTlpR'];
$sexR=$_GET["sexR"];
$agamaR=$_GET["agamaR"];
$status=$_GET['statusR'];
$SpeR=$_GET['SpeR'];
$cmbjnsR=$_GET["cmbjnsR"];
$cmbstsR=$_GET["cmbstsR"];
$cmbgroup2R=$_GET['cmbgroup2R'];
$userNameR=$_GET['userNameR'];
$passR=$_GET["passR"];
$tlpR=$_REQUEST['tlpR'];
$flag=$_REQUEST['flag'];
$txtId=$_REQUEST['txtId'];
$user_id_inacbg=$_REQUEST['user_id_inacbg'];
$msg="";
//===============================
 switch(strtolower($_REQUEST['act'])){
	case 'kanan':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql1="INSERT INTO b_ms_group_petugas(ms_group_id,ms_pegawai_id) VALUES('$idGroup','$dt[$i]')";
				mysql_query($sql1);
			}
		}
		break;
	case 'kiri':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql2="DELETE FROM b_ms_group_petugas WHERE ms_pegawai_id='$dt[$i]'";
				mysql_query($sql2);
			}
		}
		break;
}

switch($_REQUEST['act']){
	case "simpan":
		$tmpPasswd=($passR=="")?"":",PASSWORD('$passR')";
		$sql="SELECT * FROM b_ms_pegawai WHERE username='$userNameR'";
		$rsCek=mysql_query($sql);
		if (mysql_num_rows($rsCek)<=0){
			$sql="INSERT INTO b_ms_pegawai (user_id_inacbg,username,pwd,nip,nama,sex,agama,tmpt_lahir,tgl_lahir,alamat,telp,hp,pegawai_jenis,pegawai_status_id,spesialisasi_id,staplikasi,tgl_act,user_act,flag) VALUES ('$user_id_inacbg','$userNameR'".$tmpPasswd.",'$nipR','$namaR','$sexR','$agamaR','$tmpLahirR','$tglLahirR','$almtR','$tlpR','$noTlpR','$cmbjnsR','$cmbstsR','$SpeR','$status',now(),'$userId','$flag')";
			mysql_query($sql);
			if (mysql_errno()==0){
				$msg="Data Berhasil Disimpan !";
			}else{
				$msg="Data Gagal Disimpan !";
			}
		}else{
			$msg="Username Sudah Ada !";
		}
		break;
	case "update":
		$tmpPasswd=($passR=="")?"":",pwd=PASSWORD('$passR')";
		$sql="SELECT * FROM b_ms_pegawai WHERE username='$userNameR'";
		$rsCek=mysql_query($sql);
		if (mysql_num_rows($rsCek)<=0){
			$sql1="UPDATE b_ms_pegawai SET user_id_inacbg='$user_id_inacbg', username='$userNameR'".$tmpPasswd.", nip='$nipR', nama='$namaR', sex='$sexR', agama='$agamaR', tmpt_lahir='$tmpLahirR', tgl_lahir='$tglLahirR', alamat='$almtR', telp='$tlpR', hp='$noTlpR', pegawai_jenis='$cmbjnsR', pegawai_status_id='$cmbstsR', staplikasi='$status', tgl_act=now(), user_act='$userId', flag='$flag' WHERE id='$txtId'";
			mysql_query($sql1);
			$msg="Update Berhasil !";
		}else{
			$rwCek=mysql_fetch_array($rsCek);
			$idPeg=$rwCek["id"];
			if ($idPeg==$txtId){
				$sql1="UPDATE b_ms_pegawai SET user_id_inacbg='$user_id_inacbg', username='$userNameR'".$tmpPasswd.", nip='$nipR', nama='$namaR', sex='$sexR', agama='$agamaR', tmpt_lahir='$tmpLahirR', tgl_lahir='$tglLahirR', alamat='$almtR', telp='$tlpR', hp='$noTlpR', pegawai_jenis='$cmbjnsR', pegawai_status_id='$cmbstsR', staplikasi='$status', tgl_act=now(), user_act='$userId', flag='$flag' WHERE id='$txtId'";
				mysql_query($sql1);
				$msg="Update Berhasil !";
			}else{
				$msg="Username Sudah Ada !";
			}
		}
		break;
	case "hapus":
		$sqlHapus="SELECT t.id FROM b_tindakan t WHERE (t.user_id='$txtId' OR t.user_act='$txtId') LIMIT 1";
		$rsHapus=mysql_query($sqlHapus);
		if (mysql_num_rows($rsHapus)>0){
			$msg="User Tersebut Sudah Pernah Digunakan Untuk Transaksi, Jadi Tidak Boleh Dihapus !";
		}else{
			$sqlHapus="SELECT tda.id FROM b_tindakan_dokter_anastesi tda WHERE tda.dokter_id='$txtId' LIMIT 1";
			$rsHapus=mysql_query($sqlHapus);
			if (mysql_num_rows($rsHapus)>0){
				$msg="User Tersebut Sudah Pernah Digunakan Untuk Transaksi, Jadi Tidak Boleh Dihapus !";
			}else{
				$sqlHapus="delete from b_ms_pegawai where id='$txtId'";
				mysql_query($sqlHapus);
				$msg="Data Berhasil Dihapus !";
			}
		}
		break;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($filter1!=""){
	$filter1=explode("|",$filter1);
	$filter1=" AND ".$filter1[0]." like '%".$filter1[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if ($sorting1==""){
	$sorting1=$defaultsort1;
}

switch($grd){
	case "1":
	$sql="SELECT mp.id,mp.kode,mp.nama,mp.username,mp.pwd,mp.nip,mp.agama,mp.hp,mp.telp,mp.pegawai_jenis,
mp.pegawai_status_id,mp.sex,mp.spesialisasi_id,mp.staplikasi,mp.telp,mp.tgl_act,mp.tgl_lahir,mp.tmpt_lahir,mp.alamat,mp.user_id_inacbg,pj.Nama nama_jenis
FROM b_ms_pegawai mp LEFT JOIN `b_ms_pegawai_jenis` pj ON mp.`pegawai_jenis`=pj.`id` LEFT JOIN (SELECT * FROM b_ms_group_petugas WHERE ms_group_id='".$_REQUEST['idGroup']."') a ON mp.id=a.ms_pegawai_id 
WHERE a.ms_pegawai_id IS NULL ".$filter1." ORDER BY ".$sorting;
	break;
	case "2":
	$sql="SELECT mp.id,mp.kode,mp.nama,mp.username,mp.pwd,mp.nip,mp.agama,mp.hp,mp.telp,mp.pegawai_jenis,
mp.pegawai_status_id,mp.sex,mp.spesialisasi_id,mp.staplikasi,mp.telp,mp.tgl_act,mp.tgl_lahir,mp.tmpt_lahir,mp.alamat,mp.user_id_inacbg FROM b_ms_group_petugas a INNER JOIN b_ms_pegawai mp ON a.ms_pegawai_id=mp.id WHERE a.ms_group_id='".$_REQUEST['idGroup']."'".$filter1." order by ".$sorting1;
	break;
}
echo $sql."<br>";
//$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
//$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['id']."|".$rows['pwd']."|".$rows['username']."|".$rows['nip']."|".$rows['agama']."|".$rows['hp']."|".$rows['telp']."|".$rows['pegawai_jenis']."|".$rows['pegawai_status_id']."|".$rows['spesialisasi_id']."|".$rows['sex']."|".$rows['tmpt_lahir']."|".$rows['tgl_lahir']."|".$rows['alamat']."|".$rows['staplikasi']."|".$rows['user_id_inacbg'];
		$chk1="<input type='checkbox' id='cekbok$i' name='cekbok$i' value='$rows[id]' />";
		$i++;
		$dt.=$id.chr(3).$chk1.chr(3).$i.chr(3).$rows["username"].chr(3).$rows["nama"].chr(3).$rows["nama_jenis"].chr(6);
	}
	break;
	case "2":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['id']."|".$rows['pwd']."|".$rows['username']."|".$rows['nip']."|".$rows['agama']."|".$rows['hp']."|".$rows['telp']."|".$rows['pegawai_jenis']."|".$rows['pegawai_status_id']."|".$rows['spesialisasi_id']."|".$rows['sex']."|".$rows['tmpt_lahir']."|".$rows['tgl_lahir']."|".$rows['alamat']."|".$rows['staplikasi']."|".$rows['user_id_inacbg'];
		$chk2="<input type='checkbox' id='ngecek$i' name='ngecek$i' value='$rows[id]' />";
		$i++;
		$dt.=$id.chr(3).$chk2.chr(3).$i.chr(3).$rows["username"].chr(3).$rows["nama"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$msg;
	$dt=str_replace('"','\"',$dt);
}else{
	$dt.=chr(5).$msg;
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
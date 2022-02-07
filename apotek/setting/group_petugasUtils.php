<?php 
$userId = $_REQUEST['userId'];
include("../koneksi/konek.php");
$perpage=100;
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="mp.username";
$defaultsort1="mp.username";
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
//$tglLahirR=tglSQL($_GET["tglLahirR"]);
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
$txtId=$_REQUEST['txtId'];
$user_id_inacbg=$_REQUEST['user_id_inacbg'];

$kode_user=$_REQUEST['kode_user'];
$nama_user=$_REQUEST['nama_user'];
$pegawai_id=0;
$kata_kunci=$_REQUEST['kata_kunci'];
$unit=$_REQUEST['unit'];
$kategori_user=$_REQUEST['kategori_user'];
$isaktif=$_REQUEST['isaktif'];
//===============================
 switch(strtolower($_REQUEST['act'])){
	case 'kanan':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql1="INSERT INTO a_group_user(group_id,user_id) VALUES('$idGroup','$dt[$i]')";
				mysqli_query($konek,$sql1);
			}
		}
		break;
	case 'kiri':
		$dt=explode("|",$data);
		for($i=0;$i<count($dt); $i++){
			if($dt[$i]!=''){
				$sql2="DELETE FROM a_group_user WHERE user_id='$dt[$i]'";
				mysqli_query($konek,$sql2);
			}
		}
		break;
}
switch($_REQUEST['act']){
	case "simpan":
		$tmpPasswd=($passR=="")?"":",PASSWORD('$passR')";
		echo $sql="insert into a_user(kode_user,pegawai_id,username,password,unit,kategori,isaktif) values('','$pegawai_id','$nama_user',password('$kata_kunci'),$unit,$kategori_user,$isaktif)";
		mysqli_query($konek,$sql);
		break;
	case "update":
		//$tmpPasswd=($passR=="")?"":",pwd=PASSWORD('$passR')";
		//$sql1="UPDATE b_ms_pegawai SET user_id_inacbg='$user_id_inacbg', username='$userNameR'".$tmpPasswd.", nip='$nipR', nama='$namaR', sex='$sexR', agama='$agamaR', tmpt_lahir='$tmpLahirR', tgl_lahir='$tglLahirR', alamat='$almtR', telp='$tlpR', hp='$noTlpR', pegawai_jenis='$cmbjnsR', pegawai_status_id='$cmbstsR', staplikasi='$status', tgl_act=now(), user_act='$userId' WHERE id='$txtId'";
		if ($kata_kunci==""){
				$sql1="update a_user set username='$nama_user',unit='$unit',kategori='$kategori_user',isaktif='$isaktif' where kode_user=$txtId";
			}else{
				$sql1="update a_user set username='$nama_user',password=password('$kata_kunci'),unit='$unit',kategori='$kategori_user',isaktif='$isaktif' where kode_user=$txtId";
			}
		mysqli_query($konek,$sql1);
		break;
	case "hapus":
		$sql="delete from a_user where kode_user=$txtId";
		$rs=mysqli_query($konek,$sql);
		break;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
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
	echo $sql="SELECT * FROM a_user mp LEFT JOIN (SELECT * FROM a_group_user WHERE group_id='".$_REQUEST['idGroup']."') a ON mp.kode_user=a.user_id 
WHERE a.user_id IS NULL ".$filter." ORDER BY ".$sorting;
	break;
	case "2":
	$sql="SELECT * FROM a_group_user a INNER JOIN a_user mp ON a.user_id=mp.kode_user WHERE a.group_id='".$_REQUEST['idGroup']."'".$filter1." ORDER BY ".$sorting1;;
	break;
}
//echo $sql."<br>";
//$perpage=100;
$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
//$rs=mysqli_query($konek,$sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

switch($grd){
	case "1":
	while ($rows=mysqli_fetch_array($rs)){
		$id=$rows['kode_user']."|".$rows['pwd']."|".$rows['username']."|".$rows['unit']."|".$rows['kategori']."|".$rows['isaktif']."|".$rows['telp']."|".$rows['pegawai_jenis']."|".$rows['pegawai_status_id']."|".$rows['spesialisasi_id']."|".$rows['sex']."|".$rows['tmpt_lahir']."|".$rows['tgl_lahir']."|".$rows['alamat']."|".$rows['staplikasi']."|".$rows['user_id_inacbg'];
		$chk1="<input type='checkbox' id='cekbok$i' name='cekbok$i' value='$rows[kode_user]' />";
		$i++;
		$dt.=$id.chr(3).$chk1.chr(3).$i.chr(3).$rows["username"].chr(3).$rows["nama"].chr(6);
	}
	break;
	case "2":
	while ($rows=mysqli_fetch_array($rs)){
		$id=$rows['kode_user']."|".$rows['pwd']."|".$rows['username']."|".$rows['nip']."|".$rows['agama']."|".$rows['hp']."|".$rows['telp']."|".$rows['pegawai_jenis']."|".$rows['pegawai_status_id']."|".$rows['spesialisasi_id']."|".$rows['sex']."|".$rows['tmpt_lahir']."|".$rows['tgl_lahir']."|".$rows['alamat']."|".$rows['staplikasi']."|".$rows['user_id_inacbg'];
		$chk2="<input type='checkbox' id='ngecek$i' name='ngecek$i' value='$rows[kode_user]' />";
		$i++;
		$dt.=$id.chr(3).$chk2.chr(3).$i.chr(3).$rows["username"].chr(3).$rows["nama"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysqli_free_result($rs);
mysqli_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
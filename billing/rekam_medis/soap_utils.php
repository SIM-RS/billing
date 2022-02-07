<?php 
//session_start();
//$userId=$_SESSION['userIdAskep'];
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl desc";
$sorting=$_REQUEST["sorting"];
$sorting1=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$tglMaster=$_REQUEST['tglMaster'];
$alasan=$_REQUEST['alasan'];
$t=explode("-",$tglMaster);
$t=$t[2]."-".$t[1]."-".$t[0];
$mnt=$_REQUEST['mnt'];
$t=$t." ".$mnt;
//===============================
$idPel=$_GET['idPel'];
$subs=explode(',',$_GET['subs']);
$id=$_GET['id'];
$cmbDok=$_GET['cmbDok'];
if($cmbDok!=0){
	$dok=$cmbDok;
	$tipe=1;
}else{
	$tipe=0;
}
$jenis=$_REQUEST['jenis'];

$grd=$_GET['grd'];
$j=1;
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'ins':
	$sql1="INSERT INTO $dbaskep.ask_soap (pelayanan_id,tgl,ket_S,ket_O,ket_A,ket_P,ket_I,ket_E,ket_R,user_id,user_act,tgl_act,jenis) VALUES ('$idPel','$t','$subs[0]','$subs[1]','$subs[2]','$subs[3]','$subs[4]','$subs[5]','$subs[6]','$dok','$userId',now(),'$jenis')";
		mysql_query($sql1);
		break;
	case 'up':
		/*$sql2="UPDATE $dbaskep.ask_soap SET pelayanan_id='$idPel',ket_S='$subs[0]',ket_O='$subs[1]',ket_A='$subs[2]',ket_P='$subs[3]',ket_I='$subs[4]',ket_E='$subs[5]',ket_R='$subs[6]',tgl='$t',user_id='$dok', jenis='$jenis', user_act='$userId', tgl_act=now() WHERE id='$id'";*/
		$sql2="UPDATE $dbaskep.ask_soap SET status_soap=0 WHERE id='$id'";
		$upd=mysql_query($sql2);
		//echo mysql_error();
			if($upd){
					$sql2in="INSERT INTO $dbaskep.ask_soap (pelayanan_id,tgl,ket_S,ket_O,ket_A,ket_P,ket_I,ket_E,ket_R,user_id,user_act,tgl_act,jenis,id_lama,alasan,status_soap) VALUES ('$idPel','$t','$subs[0]','$subs[1]','$subs[2]','$subs[3]','$subs[4]','$subs[5]','$subs[6]','$dok','$userId',now(),'$jenis','$id','$alasan',1)";
					mysql_query($sql2in);
				}
		break;
	case 'del':
		$sql3="UPDATE $dbaskep.ask_soap SET status_soap=0 WHERE id='$id'";
		mysql_query($sql3);
		break;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
$cmbDokter=$_REQUEST['cmbDokter'];
if($cmbDokter!=''){
	$cmbDokter="AND user_id='$cmbDokter'";
}else{
	$cmbDokter="AND user_id='0'";
}

$sql="SELECT * FROM $dbaskep.ask_soap WHERE pelayanan_id='$idPel' AND status_soap='1' $filter ORDER BY $sorting";


/*$sql="SELECT 
GROUP_CONCAT(id SEPARATOR ',') AS id,
nama,
GROUP_CONCAT(s SEPARATOR '') AS s,
GROUP_CONCAT(o SEPARATOR '') AS o,
GROUP_CONCAT(a SEPARATOR '') AS a,
GROUP_CONCAT(p SEPARATOR '') AS p,
DATE_FORMAT(tgl,'%d-%m-%Y %h:%i') AS tgl
FROM(
SELECT
pg.nama,
s.user_id,
s.tgl,
s.id,
IF(s.tipe=1,s.keterangan,'') AS s,
IF(s.tipe=2,s.keterangan,'') AS o,
IF(s.tipe=3,s.keterangan,'') AS a,
IF(s.tipe=4,s.keterangan,'') AS p
FROM
$dbaskep.ask_soap s
INNER JOIN b_ms_pegawai pg ON pg.id = s.user_id
WHERE s.pelayanan_id='$idPel' ORDER BY s.id) AS tbl GROUP BY user_id,tgl";*/

//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
$kat=array(1=>'S',2=>'O',3=>'A',4=>'P',5=>'I',6=>'E',7=>'R');
while ($rows=mysql_fetch_array($rs)){
	//$dokter="SELECT nama FROM $dbbilling.b_ms_pegawai a INNER JOIN $dbbilling.b_ms_pegawai_unit b ON a.id=b.ms_pegawai_id WHERE a.id='$rows[user_id]' GROUP BY nama";
	$dokter="SELECT nama FROM b_ms_pegawai WHERE id='$rows[user_id]'";
	$u=mysql_query($dokter);
	$data=mysql_fetch_array($u);
	$data=$data['nama'];
	$id=$rows['id']."|".$_REQUEST['idPel']."|".$rows['tipe'];
	$i++;
	$dt.=$id.chr(3).$i.chr(3).$rows["tgl"].chr(3).$data.chr(3).$rows["ket_S"].chr(3).$rows["ket_O"].chr(3).$rows["ket_A"].chr(3).$rows["ket_P"].chr(3).$rows["ket_I"].chr(3).$rows["ket_E"].chr(3).$rows["ket_R"].chr(6);
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
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
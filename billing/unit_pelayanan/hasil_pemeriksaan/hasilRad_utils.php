<?php 
include("../../koneksi/konek.php");
$grd=$_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$pelayanan_id=$_REQUEST['pelayanan_id'];
$isDokPengganti=$_REQUEST['isDokPengganti'];
$id=$_REQUEST['id'];
$txtHslRad=addslashes($_REQUEST['txtHslRad']);
//$txtHslRad=addslashes($_REQUEST['txtHslRad_Tmp']);
$txtKesimpulan=$_POST['txtKesimpulan'];
$cmbDokHsl=$_REQUEST['cmbDokHsl'];
$judul=$_REQUEST['judul'];
$ket_klinis=$_REQUEST['ket_klinis'];
$userId=$_REQUEST['userId'];

switch(strtolower($_REQUEST['act']))
{
	case 'ambil_hasil':
		$sql="select hasil from b_hasil_rad where id='".$_REQUEST['hasil_id']."'";
		$queri=mysql_query($sql);
		$rw=mysql_fetch_array($queri);
		echo stripslashes($rw['hasil']);
		return;
		break;
	case 'view':
		$sql1="SELECT template FROM b_ms_hasil_radiologi_template WHERE id=$id";
		$rsview=mysql_query($sql1);
		if ($rowView=mysql_fetch_array($rsview)){
			echo stripslashes($rowView["template"]);
		}else{
			echo "";
		}
		return;
		break;
	case 'tambah':
		//$query="insert into b_hasil_rad (tgl,pelayanan_id,hasil,user_id,tgl_act,user_act) values (now(),'$pelayanan_id','$txtHslRad','$cmbDokHsl',now(),'$userId')";
		//$result = mysql_query ($query);
		$sql="SELECT p.id,p.unit_id,p.jenis_kunjungan,p.kunjungan_id,k.kelas_id kunj_kelas_id,
			p.is_paviliun,p.kso_id,k.kso_kelas_id,p.kelas_id
			FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id WHERE p.id='".$_REQUEST['pelayanan_id']."'";
		//echo $sql."<br>";
		$rsPel=mysql_query($sql);
		$rwPel=mysql_fetch_array($rsPel);
		$unitId=$rwPel["unit_id"];
		$jenisKunj=$rwPel["jenis_kunjungan"];
		$kunjId=$rwPel["kunjungan_id"];
		$kelasId=$rwPel["kelas_id"];
		$kunj_kelas_id=$rwPel["kunj_kelas_id"];
		$is_paviliun=$rwPel["is_paviliun"];
		$kso_id=$rwPel["kso_id"];
		$kso_kelas_id=$rwPel["kso_kelas_id"];
		
		$sCek="SELECT id,mtk.tarip,IF($kso_id<>1,mtk.tarip,0) biayaKSO,IF($kso_id=1,mtk.tarip,0) biayaPx
			FROM b_ms_tindakan_kelas mtk 
			WHERE mtk.ms_tindakan_id IN (".$_REQUEST['idSimpan'].") AND mtk.ms_kelas_id='$kelasId'";
		//echo $sCek."<br>";
		$rsCek=mysql_query($sCek);
		while ($rwCek=mysql_fetch_array($rsCek)){
			$mtkId=$rwCek["id"];
			$biaya=$rwCek["tarip"];
			$biayaKSO=$rwCek["biayaKSO"];
			$biayaPx=$rwCek["biayaPx"];
			
			$sCek="INSERT INTO b_tindakan(ms_tindakan_kelas_id,ms_tindakan_unit_id,jenis_kunjungan,
				kunjungan_id,kunjungan_kelas_id,is_paviliun,pelayanan_id,kso_id,kso_kelas_id,
				kelas_id,tgl,qty,biaya,biaya_kso,biaya_pasien,user_id,tgl_act,user_act,unit_act)
				VALUES($mtkId,$unitId,$jenisKunj,$kunjId,'$kunj_kelas_id','$is_paviliun','".$_REQUEST['pelayanan_id']."',
				$kso_id,$kso_kelas_id,$kelasId,CURDATE(),1,$biaya,$biayaKSO,$biayaPx,
				'".$_REQUEST['user_actD']."',NOW(),'".$_REQUEST['user_act']."',$unitId)";
			//echo $sCek."<br>";
			$rsIn=mysql_query($sCek);
			if (mysql_errno()==0){
				$idTind=mysql_insert_id();
				$sCek="INSERT INTO b_hasil_rad(tgl,tindakan_id,user_id,type_user,tgl_act,user_act)
					VALUES(CURDATE(),$idTind,'".$_REQUEST['user_actD']."',0,NOW(),'".$_REQUEST['user_act']."')";
				//echo $sCek."<br>";
				$rsIn2=mysql_query($sCek);				
			}else{
				$statusProses='Error';
				$msg='Data Gagal Ditambah !';	
			}
		}
		if (mysql_errno()==0){
			$sUpdt="UPDATE b_pelayanan SET dilayani=1, sudah_labrad = '1' WHERE id='".$_REQUEST['pelayanan_id']."'";
			//echo $sCek."<br>";
			$rsUpdt=mysql_query($sUpdt);
		}
		break;
	case 'simpan':
		$queri="update b_hasil_rad set hasil='$txtHslRad',kesimpulan='$txtKesimpulan',user_id='$cmbDokHsl',type_user='$isDokPengganti',tgl_act=now(),user_act='$userId', judul='$judul', ket_klinis='$ket_klinis' where id='$id'";
		//echo $queri."<br>";
		$result = mysql_query($queri);
		if (mysql_errno()==0){
			echo 'Simpan Berhasil !';
		}else{
			echo 'Simpan Gagal !';
		}
		return;
		break;
	case 'hapus':
		$sqlHapus="update b_hasil_rad set hasil='',kesimpulan='',user_id='0',type_user='0',tgl_act=NULL,user_act='0', judul='', ket_klinis='' where id='$id'";
		mysql_query($sqlHapus);
		return;
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

if($sorting==''){
	if($grd=="true" || $grd1=="true"){		
		$defaultsort="id";
	}
	else{
		$defaultsort="nama";
	}
	$sorting=$defaultsort;
}

/*if($_REQUEST['act']=='ambil_hasil'){
	$sql="select hasil from b_hasil_rad where id='".$_REQUEST['hasil_id']."'";
	$queri=mysql_query($sql);
	$rw=mysql_fetch_array($queri);
	echo stripslashes($rw['hasil']);
	return;
}*/

if($grd == "true")
{
	if($_REQUEST['pelayanan_id']==''){
		$_REQUEST['pelayanan_id']=0;
	}
	
	$sql="SELECT * FROM
			(SELECT 
			r.id,
			r.tindakan_id,
			r.judul,
			r.ket_klinis,
			mt.nama,
			r.hasil,
			r.kesimpulan,
			r.type_user,
			r.user_id,
			DATE_FORMAT(r.tgl_act,'%d-%m-%Y %H:%i') AS tgl,
			pg.nama AS dokter 
			FROM b_hasil_rad r
			INNER JOIN b_tindakan t ON t.id=r.tindakan_id
			INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
			INNER JOIN b_ms_tindakan mt ON mt.id=mtk.ms_tindakan_id
			INNER JOIN b_ms_pegawai pg ON pg.id=r.user_id
			WHERE t.pelayanan_id='".$_REQUEST['pelayanan_id']."') AS gab";
}

//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dtx = $rows["id"]."|".$rows["tindakan_id"]."|".$rows["hasil_x"]."|".$rows["kesimpulan"]."|".$rows["type_user"]."|".$rows["user_id"]."|".$rows["nama"]."|".$rows["judul"]."|".$rows["ket_klinis"];
		$dt.=$dtx.chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["nama"].chr(3).$rows["dokter"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;	
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
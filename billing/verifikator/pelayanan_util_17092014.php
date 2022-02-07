<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$id=$_GET['id'];
$IdUser=$_REQUEST['IdUser'];
$idPasien=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$jnsRwt=$_REQUEST['jnsRwt'];
$pid=$_REQUEST['pid'];
$pKsoId=$_REQUEST['pKsoId'];
$pKelasId=$_REQUEST['pKelasId'];
$pTgl=$_REQUEST['pTgl'];
$pTglKRS=$_REQUEST['pTglKRS'];
$dilayani=$_REQUEST['dilayani'];
$sCout=$_REQUEST['sCout'];
$sBtl=$_REQUEST['sBtl'];
$usrIdN=$_REQUEST['usrId'];
//===============================
$notice="";
if($_REQUEST['act']=='save'){
	$sqlUpdate="update b_pelayanan set kso_id='$pKsoId',kelas_id='$pKelasId',tgl=".(($pTgl=='00-00-0000'||$pTgl==''||$pTgl=='--')?"(NULL)":"'".tglSQL($pTgl)."'").",tgl_krs=".(($pTglKRS=='00-00-0000'||$pTglKRS==''||$pTglKRS=='--')?"(NULL)":"'".tglSQL($pTglKRS)."'").",dilayani='$dilayani' where id='$pid'";
	if(mysql_query($sqlUpdate)){ 
		if($sCout==1)
		{
			$sqlUpdate2="update b_pelayanan set checkout=1, checkoutact=now(), checkoutuserid='".$usrIdN."' where id='$pid'";
			mysql_query($sqlUpdate2);	
		}else{
			$sqlUpdate2="update b_pelayanan set checkout=0 where id='$pid'";
			mysql_query($sqlUpdate2);
		}
		
		if($sBtl==1)
		{
			$sqlUpdate2="update b_pelayanan set batal=1 where id='$pid'";
			mysql_query($sqlUpdate2);	
		}else{
			$sqlUpdate2="update b_pelayanan set batal=0 where id='$pid'";
			mysql_query($sqlUpdate2);
		}
		
		$notice='Simpan Berhasil!';
	}
	else{
		$notice='Simpan Gagal!';
	}   
}
else if($_REQUEST['act']=='delete'){
	$sqldTind="SELECT * FROM b_tindakan WHERE pelayanan_id='$pid'";
	$rsdTind=mysql_query($sqldTind);
	if (mysql_num_rows($rsdTind)>0){
		$notice='Data Pelayanan Tdk Boleh Dihapus Karena Sudah Ada Data Tindakan !';
	}else{
		$sqlDelete="delete from b_pelayanan where id='$pid'";
		mysql_query($sqlDelete);
		$sqlUpdate=str_replace("'","''",$sqlDelete);
		$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Pelayanan','$sqlUpdate',now(),'$IdUser')";
		mysql_query($sql);
		$notice='Data Pelayanan Berhasil Dihapus !';
	}
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($jnsRwt=='0'){
	$jnsKunj='1';
	/*$cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
	WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
	$rsCek=mysql_query($cek);
	if(mysql_num_rows($rsCek)>0){
		$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
		l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
		FROM b_pelayanan l
		INNER JOIN b_ms_unit u ON u.id=l.unit_id
		INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
		INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
		WHERE ( m.parent_id <> 44 AND n.inap = 0 
		AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
		WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$idKunj')
		AND l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
		WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
	}
	else{
		 $sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
		l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
		FROM b_pelayanan l
		INNER JOIN b_ms_unit u ON u.id=l.unit_id
		INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
		INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
		WHERE ( m.parent_id <> 44 AND n.inap = 0 
		AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
		WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$idKunj')";
	}*/
	/*$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
		l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
		FROM b_pelayanan l
		INNER JOIN b_ms_unit u ON u.id=l.unit_id
		INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
		INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
		WHERE l.jenis_kunjungan='$jnsKunj' AND l.kunjungan_id='$idKunj'";*/
}
else if($jnsRwt=='1'){
	$jnsKunj='3';
	/*$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
	l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
	FROM b_pelayanan l
	INNER JOIN b_ms_unit u ON u.id=l.unit_id
	INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
	INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
	WHERE l.kunjungan_id='$idKunj' 
	AND l.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
	WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";*/
	/*$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
	l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
	FROM b_pelayanan l
	INNER JOIN b_ms_unit u ON u.id=l.unit_id
	INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
	INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
	WHERE l.kunjungan_id='$idKunj' AND l.jenis_kunjungan='$jnsKunj'";*/
}
else if($jnsRwt=='2'){
	$jnsKunj='2';
	/*$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
	l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
	FROM b_pelayanan l
	INNER JOIN b_ms_unit u ON u.id=l.unit_id
	INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
	INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
	WHERE ( m.parent_id = 44 AND n.inap = 0 
	AND l.unit_id NOT IN( SELECT mu.id FROM b_ms_unit mu WHERE mu.inap = 1)
	OR l.unit_id IN (SELECT u.id FROM b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND l.kunjungan_id='$idKunj'";*/
	/*$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
	l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator
	FROM b_pelayanan l
	INNER JOIN b_ms_unit u ON u.id=l.unit_id
	INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
	INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
	WHERE l.jenis_kunjungan='$jnsKunj' AND l.kunjungan_id='$idKunj'";*/
}

$sql="SELECT l.id,l.jenis_layanan,n.nama AS jenis,l.unit_id,u.nama AS unit,u.inap,l.unit_id_asal,m.nama AS asal,
	l.kso_id,l.kelas_id,l.tgl,l.tgl_krs,l.dilayani,l.dokter_id,l.no_lab,l.verifikasi,l.verifikator,u.penunjang,l.batal,l.checkout
	FROM b_pelayanan l
	INNER JOIN b_ms_unit u ON u.id=l.unit_id
	INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
	INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
	WHERE l.jenis_kunjungan='$jnsKunj' AND l.kunjungan_id='$idKunj'";

echo $sql."<br>";
$perpage=100;
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

while ($rows=mysql_fetch_array($rs)){
	    $sqlKKSO="SELECT id,nama FROM b_ms_kso WHERE id=".$rows["kso_id"];
        $rsKKSO=mysql_query($sqlKKSO);
        $rwKKSO=mysql_fetch_array($rsKKSO);
		$sqlKelas="SELECT id,nama FROM b_ms_kelas WHERE id=".$rows["kelas_id"];
        $rsKelas=mysql_query($sqlKelas);
        $rwKelas=mysql_fetch_array($rsKelas);
		$ckelasId=$rows['kelas_id'];
		$ckelas=$rwKelas["nama"];
		$isPenunjang=$rows['penunjang'];
		if ($isPenunjang==1){
			$sqlTind="SELECT DISTINCT mtk.ms_kelas_id,mk.nama FROM (SELECT id,ms_tindakan_kelas_id FROM b_tindakan WHERE pelayanan_id='".$rows["id"]."') t 
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id=mk.id";
			$rsTind=mysql_query($sqlTind);
			if (mysql_num_rows($rsTind)==1){
				$rwTind=mysql_fetch_array($rsTind);
				$ckelasId=$rwTind["ms_kelas_id"];
				$ckelas=$rwTind["nama"];
			}
		}
		$idPel=$rows['id'];
		$proses = "<img src='../icon/edit.gif' onClick='popupPelayanan($rows[batal],$rows[checkout])' width='20' style='cursor:pointer' />&nbsp;&nbsp;&nbsp;<img src='../icon/erase.png' width='20' onClick='hapusPelayanan($idPel);' style='cursor:pointer' />";
		if($rows["dilayani"]==0){
			$dilayani = 'Belum';
		}
		else if($rows["dilayani"]==1){
			$dilayani = 'Sudah';
		}
		else{
			$dilayani = 'Pindah/Keluar';
		}
		$id=$rows['id']."|".$rows['dilayani']."|".$rows['unit_id']."|".$rows['jenis_layanan']."|".$ckelasId."|".$rows['inap']."|".$rows['kso_id'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows["jenis"].chr(3).$rows["unit"].chr(3).$rows["asal"].chr(3).$rwKKSO["nama"].chr(3).$ckelas.chr(3).tglSQL($rows["tgl"]).chr(3).tglSQL($rows["tgl_krs"]).chr(3).$dilayani.chr(3).$proses.chr(6);
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$notice;
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
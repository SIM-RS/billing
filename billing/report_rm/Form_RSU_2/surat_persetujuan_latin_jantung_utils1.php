<?php
include("../../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$unit=$_REQUEST['unit'];
$defaultsort="z.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];

	
$sqlP="SELECT 
  p.*,
  TIMESTAMPDIFF(YEAR, p.tgl_lahir, CURDATE()) AS usia,
  mk.nama AS nm_kls,
  u.nama AS nm_unit,
  bk.no_reg,
  IF(
    p.alamat <> '',
    CONCAT(
      p.alamat,
      ' RT. ',
      p.rt,
      ' RW. ',
      p.rw,
      ' Desa ',
      bw.nama,
      ' Kecamatan ',
      wi.nama, ' ', wil.nama
    ),
    '-'
  ) AS alamat_lengkap,
  bp.nama AS nama_pegawai, lik.`saksi` 
FROM
  b_pelayanan pl 
  INNER JOIN b_kunjungan bk 
    ON pl.kunjungan_id = bk.id 
  LEFT JOIN b_ms_pasien p 
    ON p.id = pl.pasien_id 
  INNER JOIN b_ms_wilayah bw 
    ON p.desa_id = bw.id 
  INNER JOIN b_ms_wilayah wi 
    ON p.kec_id = wi.id 
  LEFT JOIN b_ms_kelas mk 
    ON mk.id = pl.kelas_id 
  LEFT JOIN b_ms_unit u 
    ON u.id = pl.unit_id
  LEFT JOIN b_ms_wilayah wil
  ON wil.id = p.kab_id
  LEFT JOIN b_ms_pegawai bp
  ON bp.id = pl.user_act
  LEFT JOIN lap_inform_konsen lik
  ON pl.id = lik.pelayanan_id
WHERE pl.id = '$idPel'";
$pasien=mysql_fetch_array(mysql_query($sqlP));
$saksix = explode('*|*',$pasien['saksi']);
$saksi= $saksix[0];	
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="INSERT INTO b_ms_latih_jantung  VALUES ('', '$idKunj', '$idPel', '$saksi', NOW(), '$idUser')";
		$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_latih_jantung where id='".$_REQUEST['txtId']."'";
		mysql_query($sqlHapus);
		break;
	case 'edit':
		$sqlSimpan="update b_ms_latih_jantung set
kunjungan_id='$idKunj', 
pelayanan_id='$idPel', 
saksi='$saksi', 
tgl_act=NOW(), 
user_act='$idUser'		
where id='".$_REQUEST['txtId']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{	
	$sql="SELECT DISTINCT 
  md.nama AS diag, mp.nama AS pasien, peg.nama AS dokter,
  z.*
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act
  INNER JOIN b_ms_latih_jantung z
  	ON z.pelayanan_id = p.id
WHERE k.id='$idKunj' AND p.id='$idPel' $filter GROUP BY z.id order by ".$sorting;
	//$sql="select * from b_ms_latih_jantung where pelayanan_id='$idPel'";
}


//echo $sql."<br>";
$rs=mysql_query($sql);
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
$info=array(1=>'dengan kacamata',2=>'tanpa kacamata',0=>'-');

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		/*$sisipan=$rows["periksa_id"]."|".$rows["kunjungan_id"]."|".$rows["pelayanan_id"]."|".$rows["tajamlihat"]."|".$rows["mata_kanan"]."|".$rows["kanan_kcmt"]."|".$rows["mata_kiri"]."|".$rows["kiri_kcmt"]."|".$rows["anterior_kanan"]."|".$rows["anterior_kiri"]."|".$rows["posterior_kanan"]."|".$rows["posterior_kiri"]."|".$rows["wrn_test"]."|".$rows["catatan"];*/
		$sisipan=$rows["id"];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["pasien"].chr(3).$rows["saksi"].chr(3).$rows["dokter"].chr(6);
	}
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
<?php 
include('../../koneksi/konek.php');
$kode = $_REQUEST["kode"];
//======================================================================
$page=$_REQUEST["page"];
$defaultsort="id";
$sort=$_REQUEST["sorting"];
$saring='';
$filter=$_REQUEST["filter"];
//======================================================================
//Parameter Harus sama dengan simpan()
$tipe=$_GET['tipe'];
$id=$_GET['id'];
$id_pasien=$_GET['id_pasien'];
$id_pelayanan=$_GET['id_pelayanan'];
$id_user=$_GET['id_user'];
$no=$_GET['no'];
$nama=$_GET['nama'];
$alamat=$_GET['alamat'];
$noktp=$_GET['noktp'];
$hubungan=$_GET['hubungan'];
$lingkungan=$_GET['lingkungan'];
//=======================================================================
// Rumus Sql=============================================================
switch($_REQUEST['act']){ 
case'simpan': 
	$sql1= "INSERT INTO b_ms_sk_informasi_medis VALUES ('','$id_pasien','$id_pelayanan','$nama','$alamat','$noktp','$hubungan','$lingkungan',NOW(),'$id_user','$no')";
	
	$kuery1=mysql_query($sql1);
	//echo $sql1;
break;

case 'update': 
	$sql2="UPDATE b_ms_sk_informasi_medis SET nama_penanggung='$nama', alamat='$alamat',no_ktp='$noktp',hubungan='$hubungan',lingkungan='$lingkungan' WHERE id='$id'";
	$kuery2=mysql_query($sql2);
break;

case 'hapus':
 $sql3="DELETE FROM b_ms_sk_informasi_medis where id=$id";
	mysql_query($sql3);
}
//echo $sql2;
//============================================================================
if ($filter != ''){
	$filter = explode('|',$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

	if ($sort == ''){
	$sort = $defaultsort;
	}
if ($kode == "true"){
	 $sql="SELECT 
  p.*,
  TIMESTAMPDIFF(YEAR, p.tgl_lahir, CURDATE()) AS usia,
  mk.nama AS nm_kls,
  u.nama AS nm_unit,
  IFNULL(pg.nama, '-') AS dr_rujuk,
  an.`BB`,
  an.`TB`,
  pg.`id` AS id_user,
  a.`tgl_act` AS tgl_lab,
  b.`tgl_act` AS tgl_radiologi,
  c.`tgl_act` AS tgl_rm,
  d.*
FROM
  b_pelayanan pl 
  LEFT JOIN b_ms_pasien p 
    ON p.id = pl.pasien_id 
  LEFT JOIN b_ms_kelas mk 
    ON mk.id = pl.kelas_id 
  LEFT JOIN b_ms_unit u 
    ON u.id = pl.unit_id 
  LEFT JOIN b_ms_pegawai pg 
    ON pg.id = pl.user_act 
  LEFT JOIN `anamnese` an 
    ON an.`KUNJ_ID` = pl.`kunjungan_id` 
  LEFT JOIN `b_hasil_lab` a 
    ON a.`id_pelayanan` = pl.`id` 
  LEFT JOIN `b_hasil_rad` b 
    ON b.`pelayanan_id` = pl.`id` 
  LEFT JOIN `b_fom_resum_medis` c 
    ON c.`pelayanan_id` = pl.`id` 
  LEFT JOIN `b_ms_sk_informasi_medis` d 
    ON d.`id_pelayanan` = pl.`id` 
WHERE pl.id = '$id_pelayanan' 
GROUP BY p.`id`" ;
	/* $sql="SELECT TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`, pg.`id` AS id_user, p.`nama`, p.`sex`, had.`saran`, had.`id`,had.`saran`,DATE_FORMAT(had.`tanggal`,'%d-%m-%Y') as tanggal
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
LEFT JOIN `b_hasil_anamnesa_diet` had ON had.`id_pasien`=p.`id`
WHERE pl.id='$id_pelayanan' ".$filter." order by ".$sort."";
	}*/
	}
	//echo $sql;
	
	$query=mysql_query($sql);
    $jmldata=mysql_num_rows($query);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";
	$i=($page-1)*$perpage;
    $data=$totpage.chr(5);
	if ($kode == "true"){
	while ($rows=mysql_fetch_array($query)){
	$id=$rows['id'].'|'.$rows['no_ktp'].'|'.$rows['lingkungan'].'|'.$rows['no']; // kode yg mempunyai sifat hidden di tampung dalam Id susuai Type HTML
	$i++; // no akan melakukan perulangan berkali2 dengan berurutan

	$data.=$id.chr(3).$i.chr(3).$rows['nama'].chr(3).$rows['nama_penanggung'].chr(3).$rows['hubungan'].chr(3).$rows['alamat'].chr(3).$rows['tgl_act'].chr(3).$rows['dr_rujuk'].chr(6);
	}
}

    if ($data!=$totpage.chr(5)) {
        $data=substr($data,0,strlen($data)-1).chr(5);
        $data=str_replace('"','\"',$data);
    }
	mysql_free_result($query);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $data;
?>
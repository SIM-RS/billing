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
$penyakit=$_GET['penyakit'];
$id_hasil_lab=$_GET['id_hasil_lab'];
//=======================================================================
// Rumus Sql=============================================================
switch($_REQUEST['act']){ 
case'simpan': 
	$sql1= "INSERT INTO b_ms_permintaan_konsultasi_gizi VALUES ('','$id_pelayanan','$id_pasien','$penyakit','$id_hasil_lab','$id_user',NOW())";
	$kuery1=mysql_query($sql1);
	echo $sql1;
break;

case 'update': 
	$sql2="UPDATE b_ms_permintaan_konsultasi_gizi SET penyakit='$penyakit' WHERE id='$id'";
	$kuery2=mysql_query($sql2);
break;

case 'hapus':
 $sql3="DELETE FROM b_ms_permintaan_konsultasi_gizi where id=$id";
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
	 //$sql="select * from b_permintaan_pelayanan_gizi ".$filter." order by ".$sort."";
	 $sql="SELECT p.`nama`,p.`sex`,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`,  an.`TENSI`, pg.`id` AS id_user, a.`hasil`,d.`penyakit`,d.`id`,DATE_FORMAT(d.`tgl_act`,'%d-%m-%Y') AS tanggal
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
INNER JOIN `b_hasil_lab` a ON a.`id_pelayanan`=pl.id 
INNER JOIN `b_ms_normal_lab` b ON a.`id_normal`=b.`id`
INNER JOIN `b_ms_pemeriksaan_lab` c ON c.`id`=b.`id_pemeriksaan_lab`
INNER JOIN `b_ms_permintaan_konsultasi_gizi` d ON d.`id_pelayanan`=pl.`id` 
WHERE pl.id='$id_pelayanan' ".$filter." order by ".$sort."";
	 
	}
	
	echo $sql;
	
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
	$id=$rows['id']; // kode yg mempunyai sifat hidden di tampung dalam Id susuai Type HTML
	$i++; // no akan melakukan perulangan berkali2 dengan berurutan
	if($rows['sex']=='L'){
		$jk = 'Laki - laki';
	}else{
		$jk = 'Perempuan';
	}
	$data.=$id.chr(3).$i.chr(3).$rows['nama'].chr(3).$jk.chr(3).$rows['hasil'].chr(3).$rows['penyakit'].chr(3).$rows['dr_rujuk'].chr(3).$rows['tanggal'].chr(6);
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
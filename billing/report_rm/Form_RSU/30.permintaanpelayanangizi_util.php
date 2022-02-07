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
$pantangan=$_GET['pantangan'];
$permintaan=$_GET['permintaan'];
$biasa=$_GET['biasa'];
$tim=$_GET['tim'];
$lunak=$_GET['lunak'];
$saring=$_GET['saring'];
$cair=$_GET['cair'];
$puasa=$_GET['puasa'];
$penunggu=$_GET['penunggu'];
$keterangan=$_GET['keterangan'];
$id_pelayanan=$_GET['id_pelayanan'];
$id_user=$_GET['id_user'];
$bbN=$_GET['bbN'];
$tbN=$_GET['tbN'];
//=======================================================================
// Rumus Sql=============================================================
switch($_REQUEST['act']){ 
case'simpan': 
	$sql1= "INSERT INTO b_permintaan_pelayanan_gizi VALUES ('','$pantangan','$permintaan','$biasa','$tim','$lunak','$saring','$cair','$puasa','$penunggu','$keterangan','$id_pelayanan',NOW(),'$id_user','$bbN','$tbN')";
	$kuery1=mysql_query($sql1);
	//echo $sql1;
break;

case 'update': 
	$sql2="UPDATE b_permintaan_pelayanan_gizi SET pantangan='$pantangan', permintaan='$permintaan',d_biasa='$biasa',d_tim='$tim',d_lunak='$lunak',d_saring='$saring',d_cair='$cair',d_puasa='$puasa',d_penunggu='$penunggu', keterangan ='$keterangan', bb ='$bbN', tb ='$tbN' WHERE id='$id'";
	$kuery2=mysql_query($sql2);
break;

case 'hapus':
 $sql3="DELETE FROM b_permintaan_pelayanan_gizi where id=$id";
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
	$sql="SELECT ppg.*,p.`nama`,ppg.`pantangan`,ppg.`permintaan`, IFNULL(pg.nama,'-') AS dr_rujuk, mk.nama AS nm_kls,pg.`id` AS id_user, ppg.`keterangan`, DATE_FORMAT(ppg.`tanggal`,'%d-%m-%Y') as tanggal
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
inner JOIN `b_permintaan_pelayanan_gizi` ppg ON ppg.`id_pelayanan`=pl.`id`
WHERE pl.id='$id_pelayanan' ".$filter."  group by ppg.id order by ".$sort."";
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
	$id=$rows['id'].'|'.$rows['d_biasa'].'|'.$rows['d_tim'].'|'.$rows['d_lunak'].'|'.$rows['d_saring'].'|'.$rows['d_cair'].'|'.$rows['d_puasa'].'|'.$rows['d_penunggu'].'|'.$rows['keterangan'].'|'.$rows['bb'].'|'.$rows['tb']; // kode yg mempunyai sifat hidden di tampung dalam Id susuai Type HTML
	$i++; // no akan melakukan perulangan berkali2 dengan berurutan 
	$data.=$id.chr(3).$i.chr(3).$rows['nama'].chr(3).$rows['pantangan'].chr(3).$rows['permintaan'].chr(3).$rows['keterangan'].chr(3).$rows['tanggal'].chr(3).$rows['dr_rujuk'].chr(6);
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
<?php
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tanggal";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}

$id=$_REQUEST['id'];
$tgl=tglSQL($_REQUEST['tgl']);
$kwi=$_REQUEST['kwi'];
$kso=$_REQUEST['kso'];
$no=$_REQUEST['no'];
$tanggalt=tglSQL($_REQUEST['tanggal']);
$nilai=$_REQUEST['nilai'];
$nilaiB=$_REQUEST['nilaiB'];
$penerima=$_SESSION['userId'];
$ket=$_REQUEST['ket'];


//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sqlTambah="insert into b_bayar_kso (id,no_kwitansi,tanggal,kso_id,no_tagihan,tgl_tagihan,nilai_tagihan,nilai_dibayar,penerima,ket_bayar)
				values('','$kwi','$tgl','$kso','$no','$tanggalt','$nilai','$nilaiB','$penerima','$ket')";
		$rs=mysql_query($sqlTambah);
		if($rs){
			echo "<script>alert('Berhasil dihapus...')</script>";
		}
		else{
			echo "<script>alert('Gagal...')</script>";
		}
		break;
	case 'hapus':
		$sqldel="DELETE FROM b_bayar_kso where id=".$id;	
		$rs=mysql_query($sqldel);
		break;
	case 'simpan':
		$sqlEdit="UPDATE b_bayar_kso SET no_kwitansi='$kwi',kso_id=$kso,no_tagihan=$no,tgl_tagihan=$tanggalt,nilai_tagihan=$nilai,nilai_dibayar=$nilaiB,ket_bayar='$ket' WHERE id='$id'";
		$rs=mysql_query($sqlEdit);
		break;
}

if($statusProses=='Error'){	
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else{

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	$sql="SELECT
  b.id,
  b.no_kwitansi,
  b.tanggal,
  a.nama,
  b.no_tagihan,
  b.tgl_tagihan,
  b.nilai_tagihan,
  b.nilai_dibayar,
  b.penerima,
  c.username AS petugas,
  b.ket_bayar
FROM b_bayar_kso b
  INNER JOIN b_ms_kso a
    ON b.kso_id = a.id
  INNER JOIN b_ms_pegawai c
    ON b.penerima = c.id ".$filter." order by ".$sorting;
	
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
	
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['id'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows['no_kwitansi'].chr(3).tglSQL($rows['tanggal']).chr(3).$rows["nama"].chr(3).$rows["no_tagihan"].chr(3).tglSQL($rows["tgl_tagihan"]).chr(3).number_format($rows["nilai_tagihan"],0,',','.').chr(3).number_format($rows["nilai_dibayar"],0,',','.').chr(3).$rows["petugas"].chr(3).$rows["ket_bayar"].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);
}
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
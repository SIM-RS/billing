<?php
include '../sesi.php';
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
include("../koneksi/konek.php");
$kode = $_REQUEST["kode"];
$act=$_REQUEST['act'];
//============================================
//============================================	
$page=$_REQUEST["page"];
$defaultsort="idseri";
$sort=$_REQUEST["sorting"];
$saring='';
$filter=$_REQUEST["filter"];
//====================================================
 $idseri=$_GET['idseri'];
 $idunitlama=$_GET['idunitlama'];
 $idunitbaru=$_GET['idunitbaru'];
 $namapetugas=$_GET['namaperugas'];
 $jbtpetugas=$_GET['jbtpetugas'];
 $catpetugas=$_GET['catpetugas'];
 $tglmutasi=$_GET['tglmutasi'];
 $tglmutasi=explode('-',$tglmutasi);
 $tglmutasi=$tglmutasi[2]."-".$tglmutasi[1]."-".$tglmutasi[0];
//================================
$t_updatetime = date("Y-m-d H:i:s");
$t_ipaddress = $_SERVER['REMOTE_ADDR'];
$t_userid = $_SESSION['userid'];
//========Update Mutasi==================================
if($act=='berubah'){
	 $sqlinsert="insert into as_mutasi (idunitasal,idunittujuan,idseri,tglmutasi,catpetugas,namapetugas,jabatanpetugas,t_userid,t_updatetime,t_ipaddress) values('$idunitlama','$idunitbaru','$idseri','$tglmutasi','$catpetugas','$namapetugas','$jbtpetugas','$t_userid','$t_updatetime','$t_ipaddress')";
	 $kueri1=mysql_query($sqlinsert);
	
	$sqlupdate="update as_seri2 set ms_idunit='$idunitbaru' where idseri='$idseri'";
	$kueri2=mysql_query($sqlupdate);
	
	
}
if ($filter != ''){
	$filter = explode('|',$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

	if ($sort == ''){
	$sort = $defaultsort;
	}
if ($kode == "true"){
	$sql1="SELECT s.idseri,u.kodeunit,u.namaunit,s.ms_idunit,l.kodelokasi,s.ms_idlokasi,
			s.asalusul,s.idbarang,b.kodebarang,b.namabarang,s.noseri,l.namalokasi,
			k.alamat,k.luas,s.thn_pengadaan
		  FROM as_seri2 s INNER JOIN as_ms_barang b ON s.idbarang = b.idbarang
		  left JOIN as_ms_unit u ON s.ms_idunit = u.idunit
		  LEFT JOIN as_lokasi l ON s.ms_idlokasi = l.idlokasi
		  INNER JOIN kib01 k ON s.idseri = k.idseri
		WHERE b.tipe=1 and LEFT(b.kodebarang,2) = '01'
			AND s.isaktif = 1".$filter." order by ".$sort."";
	}
	
	$perpage=100;
	$query=mysql_query($sql1);
	$jmldata=mysql_num_rows($query);
	if ($page=="" || $page=="0") $page=1;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	$sql1=$sql1." limit $tpage,$perpage"; 
	$query=mysql_query($sql1);
	$i=($page-1)*$perpage;
    $data=$totpage.chr(5);
	if ($kode == "true"){
	while ($rows=mysql_fetch_array($query)){
	$id=$rows['idseri']."|".$rows['idbarang']."|".$rows['ms_idunit']."|".$rows['namaunit']."|".$rows['ms_idlokasi']."|".$rows['kodeunit']."|".$rows['kodelokasi']; 
	$i++;
	$data.=$id.chr(3).$i.chr(3).$rows['kodeunit'].chr(3).$rows['kodebarang'].chr(3).str_pad($rows['noseri'],4, "0", STR_PAD_LEFT).chr(3).$rows['namabarang'].chr(3).$rows['luas'].chr(3).$rows['thn_pengadaan'].chr(3).$rows['asalusul'].chr(3).$rows['alamat'].chr(6);
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
}	
?>
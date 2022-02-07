<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));
$pilihan = $_REQUEST['pil'];
$defaultsort = 'a.id';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);


switch(strtolower($_REQUEST['pop'])) {
   
	case 'hps':
	$id =$_GET['id'];
	//echo $a = $_GET['pop'];
	$sqlIns1="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Nilai Buku','delete from as_nilai where id = $id','".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sqlIns1);
	$sql = "delete from as_nilai where id = '$id'";
	//mysql_query($sql);
	mysql_query($sql);
		break;
	
}

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" where ".$filter[0]." like '%".$filter[1]."%'";
}



//p.unit_id_terima = '$idunit' AND
//.$filter." ORDER BY ".$sorting
switch($pilihan) {
  
	case'jo';
	if ($sorting=="") {
    $sorting=$defaultsort;
	}
		$sql = "select * from as_nilai a 
inner join as_seri2 b on b.idseri = a.idseri
inner join as_ms_barang c on c.idbarang = b.idbarang  $filter order by $sorting";
		//echo $sql;
		break;
	case 'seri':
		if ($sorting=="") {
    $sorting='a.idseri';
	}
	$sql = "select a.idbarang,namabarang,kodebarang,idseri,thn_pengadaan from as_seri2 a 
	inner join as_ms_barang b on a.idbarang=b.idbarang $filter group by a.thn_pengadaan order by $sorting ";
	break;

	
		
   
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

switch($pilihan) {
   
   case 'jo':
		while($rows = mysql_fetch_array($rs)){
			$i++;
			if($rows['jenis']==1){
			$jns = "Perbaikan";
			}else if($rows['jenis']==2){
			$jns = "Penyusutan";
			}else if($rows['jenis']==3){
			$jns = "Penghapusan";
			}
			$dt .= $rows['id']
			.chr(3).$i.chr(3).$rows['namabarang'].chr(3).number_format($rows['nilai_awal'],0,'.','.').chr(3).
			number_format($rows['nilai_perubahan'],0,'.','.').chr(3).number_format($rows['nilai_akhir'],0,'.','.').chr(3).
			tglSQL($rows['tgl_perubahan']).chr(3).$rows['TK'].chr(3).$jns.chr(3).$rows['dokumen'].chr(3).$rows['keterangan'].chr(6);
		}
		break;
	case 'seri':
		while($rows = mysql_fetch_array($rs)){
			$i++;
			
			$dt .= $rows['idseri']."|".$rows['kodebarang']."|".$rows['namabarang']."|".chr(3).$i.chr(3).$rows["thn_pengadaan"].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(6);
		}
	
	break;	
   
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);


echo $dt;
?>
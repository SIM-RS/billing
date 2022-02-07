<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$filter1=$_REQUEST["filter"];
//===============================
$tgl_a=tglSQL($_GET['tgl_a']);
$tgl_b=tglSQL($_GET['tgl_b']);
$kasir=$_GET['kasir'];
$user_act=$_GET['user_setor'];
$tgl_setor=tglSQL($_GET['tgl_setor']);
$user_setor=$_GET['user_setor'];
$data=$_REQUEST['data'];
$nss=$_REQUEST['nss']; // No Slip Setor ke
$jam = date("G:i:s");
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'kiri':
		$dt = explode("|",$data);
		for($t=0;$t<count($dt);$t++){
			if($dt[$t]!=''){
				$sql = mysql_query("update b_bayar set 
										disetor_tgl='$tgl_setor $jam',
										disetor_oleh='$user_setor',
										disetor=1,
										slip_ke = '{$nss}', flag='$flag'
									where id='$dt[$t]'");
			}
		}
		break;
	case 'kanan':
		$dt = explode("|",$data);
		for($t=0;$t<count($dt);$t++){
			if($dt[$t]!=''){
				$sCek="select disetor_oleh,verifikasi_setor from b_bayar where id='$dt[$t]'";
				$qCek=mysql_query($sCek);
				$rwCek=mysql_fetch_array($qCek);
				
				$sCek2="select DATEDIFF(CURDATE(),DATE(disetor_tgl)) AS hari from b_bayar where id='$dt[$t]'";
				$qCek2=mysql_query($sCek2);
				$rwCek2=mysql_fetch_array($qCek2);
				// && $rwCek2['hari']=='0'
				if($rwCek['disetor_oleh']==$user_setor && $rwCek['verifikasi_setor']=='0'){
					$sql = mysql_query("update b_bayar set disetor_tgl=NULL,disetor_oleh=NULL,disetor=0,slip_ke=0, flag='$flag' where id='$dt[$t]'");	
				}
			}
		}
		break;
		
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if($tgl_a!='--'&&$tgl_b!='--'){
	$tgl_d = "AND a.tgl BETWEEN '$tgl_a' AND '$tgl_b'";
}

if($user_act!='0'){
	$user_d = "and a.user_act = '$user_act'";
}
switch($grd){
	case "kiri":
	$sql="SELECT * FROM (select a.id,a.kunjungan_id,a.kasir_id,c.no_rm,c.nama,a.no_kwitansi,CONCAT(DATE_FORMAT(a.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(a.tgl_act,'%H:%i')) as tgl,a.tagihan,a.nilai from b_bayar a 
inner join b_kunjungan b on b.id=a.kunjungan_id
inner join b_ms_pasien c on b.pasien_id=c.id 
WHERE a.disetor = 0 $tgl_d $user_d AND b.flag = '$flag') AS tbl ".$filter." order by ".$sorting;
	break;
	case "kanan":
	$sql="SELECT * FROM (select a.id,a.kunjungan_id,d.nama as nm_pegawai,a.disetor_tgl,a.kasir_id,c.no_rm,c.nama,a.no_kwitansi,CONCAT(DATE_FORMAT(a.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(a.tgl_act,'%H:%i')) as tgl,a.tagihan,a.nilai, a.slip_ke from b_bayar a 
inner join b_kunjungan b on b.id=a.kunjungan_id
inner join b_ms_pasien c on b.pasien_id=c.id 
inner join b_ms_pegawai d on d.id=a.disetor_oleh
WHERE a.disetor = 1 AND a.flag = '$flag' AND DATE(a.disetor_tgl)='$tgl_setor' $user_d) AS tbl ".$filter." order by ".$sorting;
	break;
}

$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$xsql=$sql;
$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
$no = 1;

$subTotal=0;
switch($grd){
	case "kiri":
	while ($rows=mysql_fetch_array($rs)){
		$sTot="select IFNULL(SUM(nilai),0) AS total FROM (".$xsql.") AS tbl";
		$qTot=mysql_query($sTot);
		$rwTot=mysql_fetch_array($qTot);
		$subTotal=$rwTot['total'];
		
		$id=$rows["id"];
		$ch = "<input type='checkbox' id='nb_kiri$i' name='nb_kiri$i' value='$rows[id]' />";
		$dt.=$id.chr(3).$no.chr(3)."0".chr(3).$rows['tgl'].chr(3).$rows['no_kwitansi'].chr(3).$rows['no_rm'].chr(3).$rows['nama'].chr(3).number_format($rows['nilai'],0,',','.').chr(6);
		$i++;
		$no++;
	}
	break;
	case "kanan":
	while ($rows=mysql_fetch_array($rs)){
		$sTot="select IFNULL(SUM(nilai),0) AS total FROM (".$xsql.") AS tbl";
		$qTot=mysql_query($sTot);
		$rwTot=mysql_fetch_array($qTot);
		$subTotal=$rwTot['total'];
		
		$id=$rows["id"];
		$ch = "<input type='checkbox' id='nb_kanan$i' name='nb_kanan$i' value='$rows[id]' />";
		$dt.=$id.chr(3).$no.chr(3)."0".chr(3).$rows['tgl'].chr(3).$rows['no_kwitansi'].chr(3).tglSQL($rows['disetor_tgl']).chr(3).$rows['no_rm'].
		chr(3).$rows['nama'].chr(3).$rows['slip_ke'].chr(3).number_format($rows['nilai'],0,',','.').chr(3).$rows['nm_pegawai'].chr(6);
		$i++;
		$no++;
	}
	break;
}


if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$grd.chr(1).number_format($subTotal,0,',','.').chr(1).$msg;
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).$grd.chr(1).number_format($subTotal,0,',','.').chr(1).$msg;	
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
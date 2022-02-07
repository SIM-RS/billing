<?php
$user_id = $_GET['user_id'];
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$tind_id=$_REQUEST['tindId'];
$penjamin=$_REQUEST['penjamin'];
// echo 'Kode Penjamin'.$penjamin;
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

if(strtolower($_REQUEST['act'])=='simpankomponen'){
	$sqlUK="update b_ms_komponen set tarip_default='".$_REQUEST['harga']."',tarip_prosen='".$_REQUEST['prosen']."', flag='".$_REQUEST['flag']."' where id=".$_REQUEST['id'];
	$rsUK=mysql_query($sqlUK);
	echo mysql_affected_rows();
}else{

$par=explode("-",$_REQUEST['param']);
//echo count($par)."<br/>";
switch(strtolower($_REQUEST['act']))
{
	case 'tambah':
		echo $sqlTambah="insert into b_ms_tindakan_kelas (ms_tindakan_id,ms_kelas_id,tarip,user_act,aktif,kategori,kso_id,flag) values('".$tind_id."','".$_REQUEST['kls']."','".$_REQUEST['tarif']."',$user_id,'".$_REQUEST['aktif']."','".$_REQUEST['retribusi']."',$penjamin,'".$_REQUEST['flag']."')";
                //,tarip_askes,'".$_REQUEST['tarifAskes']."'
		$rs=mysql_query($sqlTambah);
		//echo $sqlTambah."<br/>";
		$sqlId="select max(id) as id from b_ms_tindakan_kelas where user_act=$user_id";
		//echo $sqlId."<br/>";
		$rsId=mysql_query($sqlId);
		$rwId=mysql_fetch_array($rsId);		
		for($i=0;$i<count($par);$i++){
			$parvalue=explode("|",$par[$i]);
			$sqlKom="insert into b_ms_tindakan_komponen (ms_tindakan_kelas_id,ms_komponen_id,tarip,tarip_prosen,flag) values(".$rwId['id'].",".$parvalue[0].",".$parvalue[1].",".$parvalue[2].",'".$_REQUEST['flag']."')";	
			//echo $sqlKom."<br/>";
			$rsKom=mysql_query($sqlKom);
		}
		break;
		
	case 'hapus':
		$sqlHapus="delete from b_ms_tindakan_kelas where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		$sqlDel = "delete from b_ms_tindakan_komponen where ms_tindakan_kelas_id='".$_REQUEST['rowid']."'";
		$rsDel=mysql_query($sqlDel);
		
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_tindakan_kelas set ms_kelas_id='".$_REQUEST['kls']."',tarip='".$_REQUEST['tarif']."',aktif='".$_REQUEST['aktif']."',manual	='".$_REQUEST['manual']."',kategori='".$_REQUEST['retribusi']."',flag='".$_REQUEST['flag']."',kso_id=$penjamin where id='".$_REQUEST['id']."'";
                //,tarip_askes='".$_REQUEST['tarifAskes']."'
		$rsSimpan=mysql_query($sqlSimpan);
		//echo $sqlSimpan;
		$sqlDel = "delete from b_ms_tindakan_komponen where ms_tindakan_kelas_id='".$_REQUEST['id']."'";
		$rsDel=mysql_query($sqlDel);
		
		for($i=0;$i<count($par);$i++){
			$parvalue=explode("|",$par[$i]);
			$sqlKom="insert into b_ms_tindakan_komponen (ms_tindakan_kelas_id,ms_komponen_id,tarip,tarip_prosen,flag) values(".$_REQUEST['id'].",".$parvalue[0].",".$parvalue[1].",".$parvalue[2].",'".$_REQUEST['flag']."')";
			//echo $sqlKom."<br/>";
			$rsKom=mysql_query($sqlKom);
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

if($grd == "true")
{
	$sql="select * from (SELECT tk.id,tk.ms_kelas_id,p.nama as nama_penjamin, tk.kso_id ,tk.ms_tindakan_id,tk.tarip,tk.tarip_askes,IF(tk.aktif=1,'Aktif','Tidak') AS aktif,t.nama AS tind,k.nama AS kls,tk.kategori, IF(tk.manual=1,'Aktif','Tidak') AS manu
FROM b_ms_tindakan_kelas tk
INNER JOIN b_ms_tindakan t ON t.id=tk.ms_tindakan_id
LEFT JOIN b_ms_kso p ON p.id=tk.kso_id
INNER JOIN b_ms_kelas k ON k.id=tk.ms_kelas_id where tk.ms_tindakan_id=$tind_id) as t1".$filter." order by ".$sorting;
}


echo $sql."<br>";
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

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$sqlGet="select * from b_ms_tindakan_komponen where ms_tindakan_kelas_id=".$rows['id'];
		//echo $sqlGet."<br/>";
		$rsGet=mysql_query($sqlGet);
		$var='';
		while($rwGet=mysql_fetch_array($rsGet)){
			$var.=$rwGet['id']."|".$rwGet['ms_komponen_id']."|".$rwGet['tarip']."|".$rwGet['tarip_prosen']."#";
		}
		$var=substr($var,0,strlen($var)-1);
		$dt.=$rows["id"]."#".$rows['ms_kelas_id']."#".$rows['kategori']."#".$rows['kso_id']."#".$var.chr(3).number_format($i,0,",","").chr(3).$rows["nama_penjamin"].chr(3).$rows["tind"].chr(3).$rows["kls"].chr(3).$rows["tarip"].chr(3).$rows["aktif"].chr(3).$rows["manu"].chr(6);
				//.$rows["tarip_askes"].chr(3)
				// echo $dt;
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

}
?>
<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tindakan";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idrm=$_REQUEST['idrm'];
//===============================

switch(strtolower($grd)){
	case '2':
		$id=explode(",",$_REQUEST['id']);            
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
                    /*    $sqlGetUnit="select kode from b_ms_unit where id='".$unitId."'";
                        $rsGetUnit=mysql_query($sqlGetUnit);
                        $rwGetUnit=mysql_fetch_array($rsGetUnit);*/
				for($i=0;$i<(sizeof($id)-1);$i++){
                           /*  echo $sqlCek="select * from b_ms_tindakan_kel_japel where b_ms_tindakan_kelas='".$id[$i]."'";                              
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){*/
						$sqlTambah="insert into b_ms_tindakan_kel_japel (ms_tindakan_kelas_id,ms_japel_id)
							values('".$id[$i]."','".$idrm."')";
						$rs=mysql_query($sqlTambah);
					//}
				}
				break;
			case 'hapus':
                        for($i=0;$i<(sizeof($id)-1);$i++){
                           $sqlHapus="delete from b_ms_tindakan_kel_japel where id='".$id[$i]."'";
                           mysql_query($sqlHapus);
                        }
				break;
			
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if($idrm==''){
	$idxRm='0';
}else{
	$idxRm=$idrm;
}
switch($grd){
	case "1":
	$sql="SELECT * from (SELECT tk1.kode as kodetk,tk1.id,tk1.ms_tindakan_id,tk1.ms_kelas_id,t.nama as tindakan,k.nama as kelas,
	kt.nama as kelompok,kl.nama as klasifikasi,tk1.kode_tindakan,tk1.tarip
FROM (select * from (select * from b_ms_tindakan_kelas tk left join
(SELECT tu.ms_tindakan_kelas_id
FROM b_ms_tindakan_kel_japel tu
where tu.ms_japel_id='".$idxRm."') as tmptu on tk.id=tmptu.ms_tindakan_kelas_id) as t1 
where ms_tindakan_kelas_id is null) tk1
inner join b_ms_tindakan t on tk1.ms_tindakan_id=t.id
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
inner join b_ms_kelas k on tk1.ms_kelas_id=k.id) as t2".$filter." order by ".$sorting;
	break;
   case "2":
	$sql="SELECT * FROM (SELECT tu.id,tu.ms_tindakan_kelas_id,tk.ms_tindakan_id,tk.ms_kelas_id,t.nama AS tindakan,kt.nama AS kelompok,kl.nama AS klasifikasi,k.nama AS kelas,tk.tarip
FROM b_ms_tindakan_kel_japel tu
INNER JOIN b_ms_tindakan_kelas tk ON tu.ms_tindakan_kelas_id=tk.id
INNER JOIN b_ms_tindakan t ON tk.ms_tindakan_id=t.id
INNER JOIN b_ms_kelompok_tindakan kt ON t.kel_tindakan_id=kt.id
INNER JOIN b_ms_klasifikasi kl ON t.klasifikasi_id=kl.id
INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id WHERE tu.ms_japel_id='$idxRm') as1 ".$filter." order by ".$sorting;
	break;
}

//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
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

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
            $sisipan=$rows["id"]."|".$rows["ms_tindakan_id"]."|".$rows["kode_tindakan"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
   case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
            $sisipan=$rows["id"]."|".$rows["ms_tindakan_kelas_id"]."|".$rows["ms_kelas_id"]."|".$rows["ms_tindakan_id"]."|".$rows["ms_unit_id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
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
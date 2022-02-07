<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tindakan";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$unitId=$_REQUEST['unitId'];
$kodeTin=$_REQUEST['kode_tindakan'];
//===============================

switch(strtolower($grd)){
	case '2':
		$id=explode(",",$_REQUEST['id']);            
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
                        $sqlGetUnit="select kode from b_ms_unit where id='".$unitId."'";
                        $rsGetUnit=mysql_query($sqlGetUnit);
                        $rwGetUnit=mysql_fetch_array($rsGetUnit);
				for($i=0;$i<(sizeof($id)-1);$i++){
                              $sqlCek="select * from b_ms_tindakan_unit where b_ms_tindakan_kelas='".$id[$i]."'";                              
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_tindakan_unit (ms_tindakan_kelas_id,kode_tindakan,ms_unit_id,kode_unit,aktif,flag)
							values('".$id[$i]."','".$kodeTin."','".$unitId."','".$rwGetUnit['kode']."','1','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
                        for($i=0;$i<(sizeof($id)-1);$i++){
                           $sqlHapus="delete from b_ms_tindakan_unit where id='".$id[$i]."'";
                           mysql_query($sqlHapus);
                        }
				break;
			
		}
		break;
	case '4':
		$id=explode(",",$_REQUEST['id']);            
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(count($id)-1);$i++){
                    $sqlCek="select * from b_ms_tindakan_icd9_unit where ms_icd9='".$id[$i]."' AND ms_unit_id='$unitId'";    
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_tindakan_icd9_unit (ms_icd9,ms_unit_id,flag)
							values('".$id[$i]."','".$unitId."','".$_REQUEST['flag']."')";
						//echo $sqlTambah."<br />";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){
				   $sqlHapus="delete from b_ms_tindakan_icd9_unit where id='".$id[$i]."'";
				   //echo $sqlHapus."<br />";
				   $rs=mysql_query($sqlHapus);
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

switch($grd){
	case "1":
   $sql="SELECT * from (SELECT tk1.kode as kodetk,tk1.id,tk1.nama_penjamin,tk1.ms_tindakan_id,tk1.ms_kelas_id,t.nama as tindakan,k.nama as kelas,
	kt.nama as kelompok,kl.nama as klasifikasi,tk1.kode_tindakan,tk1.tarip
FROM (select * from (select tk.*,
				tmptu.*,
				p.nama as nama_penjamin from b_ms_tindakan_kelas tk 
LEFT JOIN b_ms_kso p ON p.id=tk.kso_id 
left join
(SELECT tu.ms_tindakan_kelas_id
FROM b_ms_tindakan_unit tu
where tu.ms_unit_id='".$unitId."') as tmptu on tk.id=tmptu.ms_tindakan_kelas_id) as t1 
where ms_tindakan_kelas_id is null) tk1
inner join b_ms_tindakan t on tk1.ms_tindakan_id=t.id
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
inner join b_ms_kelas k on tk1.ms_kelas_id=k.id) as t2".$filter." order by ".$sorting;

	break;
   case "2":
$sql="select * from (SELECT tu.kode as kodetk,tu.id,tu.ms_tindakan_kelas_id,tu.ms_unit_id,tk.ms_tindakan_id,tk.ms_kelas_id,t.nama as tindakan,kt.nama as kelompok,kl.nama as klasifikasi,k.nama as kelas,tk.tarip, tk.nama_penjamin
FROM b_ms_tindakan_unit tu
INNER JOIN ( SELECT mtk.*, k.nama AS nama_penjamin FROM b_ms_tindakan_kelas mtk LEFT JOIN b_ms_kso k ON mtk.kso_id = k.id ) AS tk ON tu.ms_tindakan_kelas_id = tk.id
inner join b_ms_tindakan t on tk.ms_tindakan_id=t.id
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
inner join b_ms_kelas k on tk.ms_kelas_id=k.id where tu.ms_unit_id='".$unitId."') as t1".$filter." order by ".$sorting;
	break;
	case "3":
	if($sorting==$defaultsort){
		$sorting = 'STR ASC';
	}
	if($filter == ""){
		$filter = "WHERE SAB = 'ICD9CM_2005' AND TTY='PT' AND t1.id IS NULL ";
	} else {
		$filter .= " AND SAB = 'ICD9CM_2005' AND TTY='PT' AND t1.id IS NULL ";
	}
	/* $sql = "SELECT AUI id, TTY, STR FROM mrconso 
		{$filter} 
		AND AUI NOT IN (
		SELECT ms_icd9 FROM b_ms_tindakan_icd9_unit
		WHERE ms_unit_id = '{$unitId}')
		order by ".$sorting; */
	$sql = "SELECT m.CODE, m.AUI id, m.TTY, m.STR
			FROM mrconso m
			LEFT JOIN (
			  SELECT * FROM b_ms_tindakan_icd9_unit c
			  WHERE c.ms_unit_id = '{$unitId}'
			) AS t1
			  ON t1.ms_icd9 = m.AUI
			{$filter} order by {$sorting}";
	break;
   case "4":
	/* $sql="select * from (SELECT tu.kode as kodetk,tu.id,tu.ms_tindakan_kelas_id,tu.ms_unit_id,tk.ms_tindakan_id,tk.ms_kelas_id,t.nama as tindakan,kt.nama as kelompok,kl.nama as klasifikasi,k.nama as kelas,tk.tarip
FROM b_ms_tindakan_unit tu
inner join b_ms_tindakan_kelas tk on tu.ms_tindakan_kelas_id=tk.id
inner join b_ms_tindakan t on tk.ms_tindakan_id=t.id
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
inner join b_ms_kelas k on tk.ms_kelas_id=k.id where tu.ms_unit_id='".$unitId."') as t1".$filter." order by ".$sorting; */
	if($sorting==$defaultsort){
		$sorting = 'STR ASC';
	}
	if($filter == ""){
		$filter = "WHERE ";
	} else {
		$filter .= " AND ";
	}
	/*$sql = "SELECT icd.id id, m.CODE, m.AUI, m.STR
			FROM b_ms_tindakan_icd9_unit icd
				INNER JOIN mrconso m
				ON m.AUI = icd.ms_icd9
			{$filter} order by {$sorting}";*/
	$sql = "SELECT icd.id id, m.CODE, m.AUI, m.STR 
FROM b_ms_tindakan_icd9_unit icd INNER JOIN mrconso m ON m.AUI = icd.ms_icd9 
".$filter." m.SAB='ICD9CM_2005' AND TTY='PT' AND icd.ms_unit_id='$unitId' ORDER BY ".$sorting;
	break;
}

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

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
            $sisipan=$rows["id"]."|".$rows["ms_tindakan_id"]."|".$rows["kode_tindakan"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["nama_penjamin"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
            $sisipan=$rows["id"]."|".$rows["ms_tindakan_kelas_id"]."|".$rows["ms_kelas_id"]."|".$rows["ms_tindakan_id"]."|".$rows["ms_unit_id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["nama_penjamin"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "3":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$sisipan=$rows["id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["CODE"].chr(3).$rows["STR"].chr(6);
	}
	break;
    case "4":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
        $sisipan=$rows["id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["CODE"].chr(3).$rows["STR"].chr(6);
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
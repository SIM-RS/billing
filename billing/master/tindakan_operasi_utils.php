<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($grd)) {
    case '2':
        $id=explode(",",$_REQUEST['id']);
        switch(strtolower($_REQUEST['act'])) {
            case 'tambah':
                for($i=0;$i<(sizeof($id)-1);$i++) {
                    $sqlCek="select * from b_ms_tindakan_operasi where b_ms_tindakan_id = '".$id[$i]."'";
                    $rsCek=mysql_query($sqlCek);
                    if(mysql_num_rows($rsCek)==0) {
                        echo '<br>'.$sqlTambah="insert into b_ms_tindakan_operasi (ms_tindakan_id) values ('".$id[$i]."')";
                        $rs=mysql_query($sqlTambah);
                    }
                }
                break;
            case 'hapus':
                for($i=0;$i<(sizeof($id)-1);$i++) {
                    $sqlHapus="delete from b_ms_tindakan_operasi where id='".$id[$i]."'";
                    mysql_query($sqlHapus);
                }
                break;

        }
        break;
}

if ($filter!="") {
    $filter=explode("|",$filter);
    if($grd == '1') {
        $filter=" and ".$filter[0]." like '%".$filter[1]."%'";
    }
    else {
        $filter=" where ".$filter[0]." like '%".$filter[1]."%'";
    }
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

switch($grd) {
    case "1":
        $sql="select mt.id, mt.nama, kt.nama as kelompok,kl.nama as klasifikasi
from b_ms_tindakan mt
inner join b_ms_kelompok_tindakan kt on mt.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on mt.klasifikasi_id=kl.id
where mt.id not in (select ms_tindakan_id from b_ms_tindakan_operasi) $filter order by $sorting";
        break;
    case "2":
        $sql="select mt.id as ms_tindakan_id, mt.nama, mt.kode, mto.id, kt.nama as kelompok,kl.nama as klasifikasi
            from b_ms_tindakan_operasi mto inner join b_ms_tindakan mt on mto.ms_tindakan_id = mt.id
            inner join b_ms_kelompok_tindakan kt on mt.kel_tindakan_id=kt.id
            inner join b_ms_klasifikasi kl on mt.klasifikasi_id=kl.id
            ".$filter." order by $sorting";
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

switch($grd) {
    case "1":
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $sisipan=$rows["id"];
            $dt.=$sisipan.chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
        }
        break;
    case "2":
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $sisipan=$rows["id"]."|".$rows["ms_tindakan_id"];
            $dt.=$sisipan.chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
        }
        break;
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>
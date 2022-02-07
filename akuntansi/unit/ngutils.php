<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];
//===============================

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="tipenya"; //default sort
    }

	$sql = "select * from (SELECT 
	  u.id,
	  u.kode,
	  u.nama,
	  u.parent_id,
	  (SELECT 
		nama 
	  FROM
		$dbakuntansi.ak_ms_unit 
	  WHERE id = u.parent_id) AS parent 
	FROM
	  $dbakuntansi.ak_ms_unit u 
	WHERE islast = 1 
	ORDER BY u.kode) as tbl $filter";

    //echo $sql."<br>";
    $rs=mysql_query($sql);    
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    //$sql=$sql." limit $tpage,$perpage";

    //$rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

	while ($rows=mysql_fetch_array($rs)) {
		$sisip = $rows['id'];
		$i++;
		$nilai = "<input type='text' id='nilai_$rows[id]' lang='$rows[parent_id]*$rows[id]' size='20' readonly style='text-align:right' />";
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['parent'].chr(3).$rows['kode'].chr(3).$rows['nama'].chr(3).$nilai.chr(6);
	}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
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

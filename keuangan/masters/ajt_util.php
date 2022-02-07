<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];

$ms_transaksi_id = $_REQUEST['id_transaksi'];
$ms_ma_sak_id = $_REQUEST['id_ma_sak'];
$d_k = $_REQUEST['dk'];
$id = $_REQUEST['id'];
//===============================
$act = strtolower(($_REQUEST['act']));
switch($act){
    case 'add':
		  $sql = "insert into k_ms_transaksi_ma_sak (ms_transaksi_id,ms_ma_sak_id,d_k)
				values ('$ms_transaksi_id', '$ms_ma_sak_id', '$d_k')";
		  //echo $sql.";<br>";
		  $rs = mysql_query($sql);
	   //}
        break;
    case 'edit':
	   $sql = "update k_ms_transaksi_ma_sak set ms_transaksi_id = '$ms_transaksi_id', ms_ma_sak_id = '$ms_ma_sak_id', d_k = '$d_k'
		  where id = '$id'";
	   $rs = mysql_query($sql);
        break;
    case 'del':
	   $sql = "delete from k_ms_transaksi_ma_sak where id = '$id'";
	   $rs = mysql_query($sql);
	   break;
}

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="tipenya"; //default sort
    }

    $sql = "SELECT 
		  keu.id,
		  aku.MA_ID,
		  aku.MA_KODE,
		  aku.MA_NAMA,
		  keu.d_k,
		  IF(keu.d_k = 'D', 'Debet', 'Kredit') AS dk,
		  t.tipe,
		  IF(
			t.tipe = '1',
			'Pendapatan',
			'Pengeluaran'
		  ) AS nama_tipe,
		  t.id AS id_transaksi,
		  t.nama 
		FROM
		  k_ms_transaksi_ma_sak keu 
		  INNER JOIN $dbakuntansi.ma_sak aku 
			ON keu.ms_ma_sak_id = aku.MA_ID 
		  INNER JOIN k_ms_transaksi t 
			ON t.id = keu.ms_transaksi_id";

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

	while ($rows=mysql_fetch_array($rs)) {
		$sisip = $rows['id'].'|'.$rows['d_k'].'|'.$rows['MA_ID'];
		$i++;
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['MA_KODE'].chr(3).$rows['MA_NAMA'].chr(3).$rows["nama_tipe"].chr(3).$rows["nama"].chr(3).$rows["dk"].chr(6);
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
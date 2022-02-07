<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];

$kode = $_REQUEST['kode'];
$nama = $_REQUEST['nama'];
$tipe = $_REQUEST['tipe'];
$idma = $_REQUEST['idma'];
$id = $_REQUEST['id'];
//===============================
$statusProses='';
$pilihan = strtolower($_REQUEST["pilihan"]);
$act = strtolower(($_REQUEST['act']));
switch($act){
    case 'add':
		  $sql = "insert into k_ms_transaksi (kode,nama,tipe,id_ma_dpa)
				values ('$kode', '$nama', '$tipe', '$idma')";
		  $rs = mysql_query($sql);
	   //}
        break;
    case 'edit':
	   $sql = "update k_ms_transaksi set nama = '$nama', kode = '$kode', tipe = '$tipe', id_ma_dpa = '$idma'
		  where id = '$id'";
		  //, tgl_act = , user_act =
	   $rs = mysql_query($sql);
        break;
    case 'hapus':
	   $sql = "delete from k_ms_transaksi where id = '$id'";
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

    if($pilihan == "ms_transaksi") {
        $sql = "select * from (SELECT id, kode, ma.ma_id, ma.ma_kode, ma.ma_nama , nama, tipe, IF(tipe=1,'Pendapatan','Pengeluaran') AS tipenya
                FROM k_ms_transaksi
                LEFT JOIN $dbanggaran.ms_ma ma
                ON ma.ma_id = id_ma_dpa) a1 $filter";
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

    if($pilihan == "ms_transaksi") {
        while ($rows=mysql_fetch_array($rs)) {
            $sisip = $rows['id'].'|'.$rows['tipe'].'|'.$rows['ma_id'].'|'.$rows['ma_kode'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['kode'].chr(3).$rows['nama'].chr(3).$rows['ma_nama'].chr(3).$rows["tipenya"].chr(6);
            //(($rows["asalunit"]!='')?"Rujuk dari: ".$rows["asalunit"]:"Loket")tglJamSQL($rows["tgl_act"])
        }
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
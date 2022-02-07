<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t1.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$id = $_REQUEST['rowid'];
$tipeKenda=$_REQUEST['tipeKenda'];
$txtTglPar=tglSQL($_REQUEST['txtTglPar']);
$txtTglSet=tglSQL($_REQUEST['txtTglSet']);
//echo $tgl."<br>";
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$jamSet=$_REQUEST['jamSet'];
$userId=$_REQUEST['userId'];
$grid = $_REQUEST['grid'];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];

//===============================
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
        $sqlIns = "INSERT INTO k_ambulan(tgl, tgl_setor, no_bukti, ambulan_tipe, nilai, ket, petugas_id, user_act, tgl_act)
								VALUES ('{$txtTglPar}','{$txtTglSet} {$jamSet}:00','{$noBukti}','{$tipeKenda}','{$nilai}','{$ket}',NULL,'{$userId}',NOW());";
		$qIns = mysql_query($sqlIns) or die (mysql_error());
        break;
    case 'hapus':
        $sqlTrans="select id from k_ambulan where id='$id'";
        $rsTrans=mysql_query($sqlTrans);
        if(mysql_num_rows($rsTrans)>0) {
			$sqlHapus="delete from k_ambulan where id='$id'";
			mysql_query($sqlHapus);
        }else {
            $statusProses="Error";
            $alasan="Data tidak ditemukan!";
        }
        break;
    case 'simpan':
        $sqlTrans="select * from k_ambulan where id='$id'";
        $rsTrans=mysql_query($sqlTrans);
        if(mysql_num_rows($rsTrans)>0) {
            $sqlSimpan="update k_ambulan 
						set 
							tgl = '{$txtTglPar}',
							tgl_setor = '{$txtTglSet} {$jamSet}:00',
							no_bukti = '{$noBukti}',
							ambulan_tipe = '{$tipeKenda}',
							nilai = '{$nilai}',
							ket = '{$ket}',
							petugas_id = NULL,
							user_act = '{$userId}',
							tgl_act = NOW()
						where id='$id'";                
            $rs=mysql_query($sqlSimpan);
        }
        else {
            $statusProses="Error";
            $alasan="Data tidak ditemukan!";
        }
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
	$waktu = " AND YEAR(t1.tgl_setor) = '{$thn}'
			   AND MONTH(t1.tgl_setor) = '{$bln}'";
			   
    if($grid == 'grid1'){
		$sql = "SELECT *
				FROM (SELECT p.*, if(p.ambulan_tipe = 0,'Jenazah','Rescue') nama, u.username, DATE_FORMAT(p.tgl_setor,'%d-%m-%Y') tglSetor, 
						DATE_FORMAT(p.tgl_setor,'%H:%i') jamSetor
						FROM k_ambulan p
						INNER JOIN k_ms_user u
						   ON u.id = p.user_act) t1
				WHERE 0=0 $filter $waktu
				ORDER BY $sorting";
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
    $unit_asal = '';

    if($grid == 'grid1') {
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$dt.=$rows["id"]."|".$rows['ambulan_tipe'].chr(3).number_format($i,0,",",".").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tglSetor"].chr(3).$rows["jamSetor"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["ket"].chr(3).$rows["username"].chr(6);
		}
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
//*/
?>
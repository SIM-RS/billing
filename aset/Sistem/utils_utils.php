<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$defaultsort="userId";
$pilihan = $_REQUEST['pilihan'];
//===============================

switch(strtolower($_REQUEST['act'])) {
    case 'hapus_user':
		$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master User','delete from as_ms_user where userid =".$_GET['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns);
        $sqlHapus = "delete from as_ms_user where id = '".$_GET['rowid']."'";
        mysql_query($sqlHapus);
        break;
}

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}
switch($pilihan) {
    case 'm_user':
        $sql = "SELECT id,userid,username,usertype,address,telp,email,status,namaunit FROM as_ms_user LEFT JOIN as_ms_unit ON as_ms_unit.idunit=as_ms_user.refidunit $filter ORDER BY $sorting ";
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
    case 'm_user':
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$aktif = 'Non Aktif';
			if($rows["status"]==1){
			$aktif = 'Aktif';
			}
            $dt.=$rows["id"].chr(3).$i.chr(3).'&nbsp;'.$rows["userid"].chr(3).'&nbsp;'.$rows["username"].chr(3).$rows["usertype"].chr(3).'&nbsp;'.$rows["namaunit"].chr(3).$rows["address"].chr(3).$rows["telp"].chr(3).$rows["email"].chr(3).'&nbsp;'.$aktif.chr(6);
        }
        break;
}
/*
if($grd == "true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["id"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["tipebarang"].chr(3).$rows["level"].chr(3).$rows[""].chr(3).$rows["statuskode"].chr(6);
    }
}
elseif($grdUnit == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["id"].chr(3).$rows["kodeunit"].chr(3).$rows["nama"].chr(3).$rows["namapanjang"].chr(3).$rows["induk"].chr(3).$rows["level"].chr(6);
    }
}
else if($gedung == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["idgedung"].chr(3).$rows["kodegedung"].chr(3).$rows["namagedung"].chr(3).$rows["tahunbangun"].chr(3).$rows["nourut"].chr(6);
        //.'|'.$rows['t_userid,t_updatetime,t_ipaddress']
    }
}
elseif($grdDana == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["idsumberdana"].chr(3).$rows["keterangan"].chr(3).$rows["nourut"].chr(6);
    }
}
elseif($ruangan == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["idlokasi"].chr(3).$rows["idunit"].chr(3).$rows["kodelokasi"].chr(3).$rows["namalokasi"].chr(3).$rows["idtipelokasi"]
                .chr(3).$rows["idgedung"].chr(3).$rows["luas"].chr(3).$rows["kapasitas"].chr(6);
        //.'|'.$rows['t_userid,t_updatetime,t_ipaddress']
    }
}
elseif($grdRek == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["idrekanan"].chr(3).$rows["koderekanan"].chr(3).$rows["namarekanan"].chr(3).$rows["ket"].chr(3).$rows["alamat"].chr(3).$rows["contactperson"].chr(3).$rows["status"].chr(6);
    }
}
*/
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
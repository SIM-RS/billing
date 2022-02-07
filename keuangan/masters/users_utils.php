<?php
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];
//===============================
$statusProses='';
$act = strtolower($_REQUEST['act']);
switch($act){
    case 'btn_save':
        $id = $_REQUEST['id'];
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];
        $name = $_REQUEST['name'];
        $chk = $_REQUEST['chk'];
        $which = $_REQUEST['which'];
        $hak_akses = $_REQUEST['hak_akses'];
        if($which == 'add'){
            $sql = "insert into k_ms_user (username,pwd,nama,hak_akses,flag)
                    values ('$user', password('$pass'), '$name', '$hak_akses','$flag')";
        }
        else if($which == 'edit'){
            if($chk == 'true'){
                $pass = ", pwd = password('$pass') ";
            }
            $sql = "update k_ms_user set username = '$user', nama = '$name', hak_akses = '$hak_akses', flag = '$flag' $pass where id = $id";
        }
        $rs = mysql_query($sql);
        break;
    case 'btn_del':
        $id = $_REQUEST['id'];
        $sql = "delete from k_ms_user where id = '$id'";
        $rs = mysql_query($sql);
        break;
    case 'cekuser':
        $id = $_REQUEST['id'];
        $user = $_REQUEST['user'];
        if($id != ''){
            $edit = " and id <> $id";
        }
        $sql = "select id from k_ms_user where username = '$user' $edit";
        $rs = mysql_query($sql);
        echo mysql_num_rows($rs);
        mysql_free_result($rs);
        mysql_close($konek);
        return false;
        break;
}
$pilihan = strtolower($_REQUEST["pilihan"]);
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="id"; //default sort
    }

    if($pilihan == "view_user") {
	$sql = "SELECT id,username,nama,hak_akses,pwd,if(hak_akses=0,'Keuangan','Admin') as haknya from k_ms_user WHERE flag = '$flag' $filter order by $sorting";
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

    if($pilihan == "view_user") {
        while ($rows=mysql_fetch_array($rs)) {
            $sisip = $rows['id']."|".$rows['hak_akses'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['username'].chr(3).$rows["nama"].chr(3).$rows["haknya"].chr(6);
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
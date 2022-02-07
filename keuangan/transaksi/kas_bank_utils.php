<?php
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];
$bln_in = $_REQUEST['bln_in'];
$thn_in = $_REQUEST['thn_in'];
$tgl = tglSQL($_REQUEST['tgl']);
$id_trans = $_REQUEST['id_trans'];
$nobukti = $_REQUEST['nobukti'];
$ket = $_REQUEST['ket'];
$nilai = $_REQUEST['nilai'];
$tgl_act = 'now()';
$user_act = $_REQUEST['user_act'];
$id = $_REQUEST['id'];
$idma= $_REQUEST['idMa'];
$id_ma_sak = $_REQUEST['id_ma_sak'];
//===============================
$statusProses='';
$pilihan = strtolower($_REQUEST["pilihan"]);
$act = strtolower(($_REQUEST['act']));
switch($act){
    case 'add':
		  $sql = "insert into ".$dbkeuangan.".k_transaksi (id_trans,tgl,no_bukti,nilai_sim,nilai
				,ket,tgl_act,user_act, tipe_trans , flag)
				values ('$id_trans', '$tgl', '$nobukti', '$nilai', '$nilai'
				, '$ket', $tgl_act, '$user_act', 4, '$flag')";
		  $rs = mysql_query($sql);
        break;
    case 'edit':
	   $sql = "update ".$dbkeuangan.".k_transaksi set id_trans = '$id_trans', tgl = '$tgl', no_bukti = '$nobukti', nilai_sim = '$nilai', nilai = '$nilai'
		  , ket = '$ket', flag = '$flag' where id = '$id'";
	   $rs = mysql_query($sql);
        break;
    case 'hapus':
	   $sql = "delete from ".$dbkeuangan.".k_transaksi where id = '$id'";
	   $rs = mysql_query($sql);
	   break;
}

if ($filter!="") {
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
	$sorting="tgl"; //default sort
}

$sql = "SELECT * FROM (SELECT t.id,t.id_trans,DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,t.ket,t.no_bukti,t.nilai,jt.JTRANS_NAMA nama_trans FROM k_transaksi t INNER JOIN $dbakuntansi.jenis_transaksi jt ON t.id_trans=jt.JTRANS_ID
WHERE t.tipe_trans=4  AND t.flag='$flag' AND MONTH(t.tgl)=$bln AND YEAR(t.tgl)=$thn) AS gab".$filter;
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
	$sisip = $rows['id'].'|'.$rows['id_trans'].'|'.$rows['ket'].'|'.$rows['no_bukti'].'|'.$rows['nilai'];
	$i++;
	$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows['ket'].chr(6);
}

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
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
?>
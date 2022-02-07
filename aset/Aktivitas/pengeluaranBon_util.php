<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_GET['bln'] and $_GET['thn']<>'')$filter2=" where MONTH(k.tgl_gd)=".$_GET['bln']." AND YEAR(k.tgl_gd)=".$_GET['thn']; else $filter2=" where MONTH(k.tgl_gd)=$bln AND YEAR(k.tgl_gd)=$thn";
$defaultsort = ' k.tgl_gd desc,k.no_gd desc';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$bln=$_REQUEST['bln'];
if ($bln=="")
    $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$thn=$_REQUEST['thn'];
if ($thn=="")
    $thn=$th[2];

//===============================

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

$sql = "SELECT k.klr_id,k.tgl_gd AS tglkel,k.no_gd AS no_kel,k.tgl_transaksi AS tgl_transaksi,
        k.kode_transaksi AS kode_transaksi,k.nilai,l.namalokasi,u.namaunit, k.petugas_gudang, k.petugas_unit 
        FROM as_keluar k 
        INNER JOIN as_operasi o ON k.klr_id=o.klr_id 
        LEFT JOIN as_lokasi l ON l.idlokasi=k.lokasi_id 
        INNER JOIN as_ms_unit u ON u.idunit=k.unit_id
	$filter2 $filter GROUP BY k.tgl_gd,k.no_gd,k.lokasi_id
	ORDER BY $sorting";

$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while($rows = mysql_fetch_array($rs)) {
    $i++;
    $dt.=$rows['klr_id']."*|*".$rows['petugas_gudang']."*|*".$rows['petugas_unit'].chr(3).$i.chr(3).tglSQL($rows["tglkel"]).chr(3).$rows["no_kel"].chr(3).tglSQL($rows["tgl_transaksi"]).chr(3).$rows["kode_transaksi"].chr(3).$rows["namaunit"]." - ".$rows["namalokasi"].chr(3).number_format($rows["nilai"],0,'.','.').chr(6);
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

echo $dt;
?>
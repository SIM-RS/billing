<?php
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_REQUEST['act']=='batalkan'){
	$kk = $_REQUEST['kodeT'];
	$sql = "update as_keluar set stt=2 where kode_transaksi = '$kk'";
	mysql_query($sql);
	echo mysql_error();
}

if($_GET['bln'] and $_GET['thn']<>'')$filter2=" where MONTH(k.tgl_transaksi)=".$_GET['bln']." AND YEAR(k.tgl_transaksi)=".$_GET['thn']; else $filter2=" where MONTH(k.tgl_gd)=$bln AND YEAR(k.tgl_gd)=$thn";
$defaultsort = ' k.tgl_transaksi desc,k.kode_transaksi desc';
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

$sorting_bon="k.tgl_transaksi desc,k.kode_transaksi desc"; if ($sorting!="") $sorting_bon=$sorting;
             $sql = "SELECT k.klr_id, k.tgl_transaksi,k.kode_transaksi,namaunit,k.petugas_rtp,k.petugas_unit, k.stt,b.tipe
                    FROM as_keluar k 
					INNER JOIN as_ms_barang b ON k.barang_id=b.idbarang 
                    LEFT JOIN as_ms_unit u ON k.unit_id=u.idunit              
                    $filter2 $filter and (k.stt = '0' or k.stt='2')
                    GROUP BY k.tgl_transaksi,k.kode_transaksi ORDER BY $sorting_bon";

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
	if($rows["stt"]==2){
	$batal = " - ";
	$stt = "dibatalkan";
	}else{
	$batal = '<a href=# onclick=batalKan(\''.$rows["kode_transaksi"].'\'); > Batal </a>';
    $stt = "belum terkirim";
	}
	$dt.=$rows['klr_id']."*|*".$rows['petugas_gudang']."*|*".$rows['petugas_unit'].chr(3).$i.
	chr(3).tglSQL($rows["tgl_transaksi"]).chr(3).$rows["kode_transaksi"].
	chr(3).$rows["namaunit"].chr(3).$stt.chr(3).$batal.chr(6);
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

echo $dt;
?>
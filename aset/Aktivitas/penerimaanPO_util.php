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

if($_GET['bln'] and $_GET['thn']<>'')$filter2=" where MONTH(msk.tgl_terima)=".$_GET['bln']." AND YEAR(msk.tgl_terima)=".$_GET['thn']; else $filter2="where MONTH(msk.tgl_terima)=$bln AND YEAR(msk.tgl_terima)=$thn";

$defaultsort = 'tgl_terima desc,no_gudang desc';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);

$bln=$_REQUEST['bln'];
if ($bln=="") $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$thn=$_REQUEST['thn'];
if ($thn=="") $thn=$th[2];

//===============================
if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

$sql = "select 0 as id,msk.tgl_terima,msk.no_gudang, po.no_po,msk.no_faktur,po.no_ba,po.tgl_ba,rek.namarekanan,SUM(msk.jml_msk * msk.harga_unit) AS nilai
	from as_masuk msk left join as_po po on msk.po_id=po.id
	left join as_ms_rekanan rek on rek.idrekanan=po.vendor_id
	$filter2 $filter group by msk.tgl_terima,msk.no_gudang,msk.no_faktur
	order by $sorting";

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

while($rows = mysql_fetch_array($rs)) {
        $i++;
        //$dt .= $rows['poid'].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows['tgl_terima']).chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['no_faktur'].chr(3).$rows['namarekanan'].chr(6);
		//$nospk=$rows['no_spk'];
		//if ($nospk=="") $nospk="..........";
		//$tnospk="<span id='spk_$i' title='Klik Untuk Mengubah No SPK' onClick='IsiNoSPK(this)'>".$nospk."</span>";
        $dt .= $rows['id'].chr(3).$i.chr(3).tglSQL($rows['tgl_terima']).chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['no_faktur'].chr(3).$rows['no_ba'].chr(3).$rows['tgl_ba'].chr(3).$rows['namarekanan'].chr(3).number_format($rows['nilai'],0,",",".").'&nbsp;'.chr(6);
}
 
if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

echo $dt;
?>
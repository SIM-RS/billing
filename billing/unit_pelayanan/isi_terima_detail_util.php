<?php 
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$grd = $_REQUEST['grd'];
$no_kirim = $_REQUEST['no_kirim'];
$id_terima = $_REQUEST['id_terima'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
if(empty($bulan) && empty($tahun)){
	$tahun=date('Y');
	$bulan=date('m');
}
if(empty($unit_id)){
	$unit_id = $_REQUEST['tmpLay'];
}

$sUnit="select * from $dbapotek.a_unit where unit_billing='".$unit_id."'";
$qUnit=mysql_query($sUnit);
$unitId=0;
if(mysql_num_rows($qUnit)>0){
	$rwUnit=mysql_fetch_array($qUnit);
	$unitId=$rwUnit['UNIT_ID'];
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
} else {
	$filter=" WHERE ";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

//$sql="select distinct date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,date_format(ap.TGL_TERIMA,'%d/%m/%Y') as tgl2,ap.NOKIRIM,ap.NOTERIMA,ap.status,apo.no_bukti,au.UNIT_NAME,au.UNIT_ID from $dbapotek.a_penerimaan ap inner join $dbapotek.a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id inner join $dbapotek.a_unit au on ap.UNIT_ID_KIRIM=au.UNIT_ID INNER JOIN dbapotek_tangerang.a_obat ao ON apo.OBAT_ID = ao.OBAT_ID where month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$tahun and ap.TIPE_TRANS=2 and ap.UNIT_ID_TERIMA=$unitId".$filter." order by ".$sorting;

if($grd == 1){
	  $sql="select sum(ap.QTY_SATUAN) as qty_kirim,apo.qty,apo.qty_terima,ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,ake.NAMA as NAMA1
	  from $dbapotek.a_penerimaan ap inner join $dbapotek.a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id 
	  inner join $dbapotek.a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join $dbapotek.a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID 
	  inner join $dbapotek.a_kepemilikan ake on apo.kepemilikan_id_asal=ake.ID 
	  $filter month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$tahun and ap.TIPE_TRANS=2 and ap.UNIT_ID_TERIMA=$id_terima and ap.NOKIRIM='$no_kirim' group by ap.OBAT_ID order by ".$sorting;
} elseif($grd == 2) {
	$sql="select ao.OBAT_ID, ao.OBAT_KODE, ao.OBAT_NAMA, ao.OBAT_SATUAN_KECIL, ak.ID,ak.NAMA, ake.NAMA as NAMA1, ap.peminjaman_id, ap.unit_id, ap.kepemilikan_id, ap.qty, ap.qty_terima, ap.qty-ap.qty_terima as qty_kirim
	from $dbapotek.a_pinjam_obat ap
	inner join $dbapotek.a_obat ao on ap.OBAT_ID=ao.OBAT_ID
	inner join $dbapotek.a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID
	inner join $dbapotek.a_kepemilikan ake on ap.kepemilikan_id_asal=ake.ID
	$filter ap.no_bukti='$no_kirim' order by ".$sorting;
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


while ($rows=mysql_fetch_array($rs))
{	
	$i++;
	if($grd == 1){
		$input = "<input name='qty_kirim' type='hidden' size='4' maxlength='4' class='txtcenter' value='".$rows['OBAT_ID']."|".$rows['qty_kirim']."'><input type='text' size='4' maxlength='4' id='qty_terima' name='qty_terima' value='".$rows['qty_kirim']."' class='txtcenter'/>";
		$dt.=$id.chr(3).number_format($i,0,",","").chr(3).$rows['OBAT_KODE'].chr(3).$rows['OBAT_NAMA'].chr(3).$rows['OBAT_SATUAN_KECIL'].chr(3).$rows['NAMA'].chr(3).$rows['NAMA1'].chr(3).$rows['qty'].chr(3).$rows['qty_kirim'].chr(3).$input.chr(6);
	} elseif($grd == 2) {
		$cidobat=$rows['OBAT_ID'];
		$ckp=$rows['kepemilikan_id'];
		$pid=$rows['peminjaman_id'];
		/* $sql2="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok from a_penerimaan where OBAT_ID=$cidobat and QTY_STOK>0 and KEPEMILIKAN_ID=$ckp and UNIT_ID_TERIMA=$id_terima";
	  	echo $sql2;	
		$rs1=mysql_query($sql2);
		$cstok=0;
		if ($rows1=mysql_fetch_array($rs1)) {
			$cstok=$rows1['cstok'];
		} */
		
		$dt.=$id.chr(3).number_format($i,0,",","").chr(3).$rows['OBAT_KODE'].chr(3).$rows['OBAT_NAMA'].chr(3).$rows['OBAT_SATUAN_KECIL'].chr(3).$rows['NAMA'].chr(3).$rows['NAMA1'].chr(3).$rows['qty'].chr(3).$rows['qty_terima'].chr(6);
	}
}


if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;

?>

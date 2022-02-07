<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$tgl1=gmdate('Y-m-d',mktime(date('H')+7));
$tgl2=gmdate('Y-m-d',mktime(date('H')+7));
$tg1 = explode('-', $_GET['tgl1']);
$tg1 = $tg1[2].'-'.$tg1[1].'-'.$tg1[0];
$tg2 = explode('-', $_GET['tgl2']);
$tg2 = $tg2[2].'-'.$tg2[1].'-'.$tg2[0];
$tglPo = $_GET['tglPo'];
if($_GET['tgl1'] and $_GET['tgl2']<>'')$filter2=" where tgl_po between '".$tg1."' AND '".$tg2."'"; 
else $filter2=" where tgl_po between '".$tgl1."' AND '".$tgl2."'";

$defaultsort = 'date(po.tgl_po),po.no_po,po.po_akhir';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);

$bln=$_REQUEST['bln'];
if ($bln=="")
    $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
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

if ($_REQUEST['act']=='hapus_po'){
    $sqlCekDel="SELECT id FROM as_po po INNER JOIN as_masuk msk ON po.id=msk.po_id
		WHERE po.no_po='".$_REQUEST["no_po"]."' and tgl_po='".tglSQL($tglPo)."'";
    //echo $sqlCekDel;
    $rsDel=mysql_query($sqlCekDel);
    $AdaData=mysql_num_rows($rsDel);
    if ($AdaData==0) 
	{
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete PO','delete from as_po where no_po=".$_REQUEST["no_po"]." and tgl_po=".tglSQL($_REQUEST["tglPo"])."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
	mysql_query("delete from as_po where no_po='".$_REQUEST["no_po"]."' and tgl_po='".tglSQL($tglPo)."'");
    }
}

/*$sql = "SELECT
  po.id,  DATE_FORMAT(tgl_po,'%d-%m-%Y') AS tgl_po,  judul,  no_po,  b.tipe,  namarekanan,  vendor_id,
  DATE_FORMAT(exp_kirim,'%d-%m-%Y')    exp_kirim,  SUM(total)  AS biaya,jenis_surat
FROM as_po po  INNER JOIN as_ms_rekanan rek    ON po.vendor_id = rek.idrekanan 
	INNER JOIN as_ms_barang b ON po.ms_barang_id=b.idbarang                  
        $filter2 $filter group by tgl_po,no_po
        ORDER BY $sorting";*/

$sql = "SELECT
  po.id,  DATE_FORMAT(tgl_po,'%d-%m-%Y') AS tgl_po,  judul,  no_po, no_spk,  namarekanan,  vendor_id, pembuat,verifikator,
  DATE_FORMAT(exp_kirim,'%d-%m-%Y')    exp_kirim,  SUM(total)  AS biaya,jenis_surat,po.status,po.po_akhir,SUM(po.status) AS terima_full,count(po.no_po)as total_record
FROM as_po po  INNER JOIN as_ms_rekanan rek    ON po.vendor_id = rek.idrekanan                  
        $filter2 $filter group by tgl_po,no_po
        ORDER BY $sorting";
		
//echo $sql;
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
		$data=$rows['id']."|".$rows['tipe']."|".$rows['vendor_id']."|".$rows['pembuat']."|".$rows['verifikator']."|".$rows['tgl_po']."|".$rows['exp_kirim']."|".$rows['no_spk']."|".$rows['terima_full']."|".$rows['total_record'];
        $i++;
        $st = "Belum Terima";
        if($rows['status']==1){
			        	$st = "Diterima";
        	}
        	$tp = "Tidak Langsung";
        	if($rows['po_akhir']==1){
			        	$tp = "Langsung";
        	}
        $dt .=$data.chr(3).$i.chr(3).$rows['tgl_po'].chr(3).$rows['no_po'].chr(3).$rows['judul'].chr(3).'&nbsp;'.$rows['namarekanan'].chr(3).$rows['no_spk'].chr(3).$rows['exp_kirim'].chr(3).number_format($rows['biaya'],0,",",".").'&nbsp;'.chr(3).$tp.chr(3).$st.chr(6);
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}

if ($AdaData>0){
    $dt=$dt.chr(5)."ErrDel";
}
mysql_free_result($rs);
mysql_close($konek);
echo $dt;
?>
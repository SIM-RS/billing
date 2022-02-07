<?php
include '../sesi.php';
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$sorting1=$_REQUEST["sorting"];
$filter1=$_REQUEST["filter"];
$sorting3=$_REQUEST["sorting"];
$filter3=$_REQUEST["filter"];
$bln=gmdate('m',mktime(date('H')+7));
$thn=gmdate('Y',mktime(date('H')+7));

if($_GET['bln'] and $_GET['ta']<>'')$filter2="where MONTH(tgl_po)=".$_GET['bln']." AND YEAR(tgl_po)=".$_GET['ta']; else $filter2="where MONTH(tgl_po)=$bln AND YEAR(tgl_po)=$thn";
$filter_bon="where MONTH(k.tgl_transaksi)=".$_GET['bln']." AND YEAR(k.tgl_transaksi)=".$_GET['ta']; if($_GET['bln'] and $_GET['ta']=='') $filter_bon="where MONTH(k.tgl_transaksi)=$bln AND YEAR(k.tgl_transaksi)=$thn";
$pilihan = $_REQUEST['pilihan'];
$defaultsort = 'tglPo, no_po, tglFaktur,no_faktur';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$idunit=$_SESSION["userid"];
$bln=$_REQUEST['bln'];
if ($bln=="")
    $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$thn=$_REQUEST['thn'];
if ($thn=="")
    $thn=$th[2];
$minta_id=$_REQUEST['minta_id'];
$idRekanan = $_REQUEST['idRekanan'];
$tglFilter = tglSQL($_REQUEST['tglTagihan']);
//utils.php?pilihan=opname&tglTagihan=03-03-2011&act=Tambah_opname&id=&qty=10&harga=50002154&barang_id=4499&usr_id=1
$usr_id = $_REQUEST['usr_id'];
$barang_id = $_REQUEST['barang_id'];
$qty = $_REQUEST['qty'];
$harga = $_REQUEST['harga'];
$id = $_REQUEST['id'];
$satuan = $_REQUEST['satuan'];
$tgl1=$_REQUEST['tgl'];
$tgl1=explode("-",$tgl1);
$tgl1=$tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
/*$tanah = $_REQUEST["tanah"];
$perolehan = $_REQUEST["perolehan"];*/

//===============================
//echo strtolower($_REQUEST['act']);

switch(strtolower($_REQUEST['act'])) {
   	case 'tagihan':
		$sqlCek = "SELECT kwi FROM as_po WHERE no_po = '".$_REQUEST['noPo']."' ";
		$rsCek=mysql_query($sqlCek);
			if(mysql_num_rows($rsCek['kwi'])==0){
				$sqlTambah="UPDATE as_po SET kwi = '1' WHERE no_po = '".$_REQUEST['noPo']."'";
				$rs=mysql_query($sqlTambah);
			}
			echo $sqlCek;
			echo $sqlTambah;
		break;
	
}

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

switch($pilihan) {

	 case 'tagihan':
	 $filternm=$_REQUEST['filternm'];
	 if ($filternm!="") {
		$filternm=explode("|",$filternm);
		$filternm=" WHERE ".$filternm[0]." like '%".$filternm[1]."%'";
		}
	 if ($sorting=="") {
            $sorting='id';
        }
	 	if($_REQUEST['idRekanan']!=0) $fRekan = "as_ms_rekanan.idrekanan = '".$idRekanan."' AND";
		 $sql = "SELECT t.id, t.namarekanan, t.tglPo, t.no_po, t.tglFaktur, 
		 t.no_faktur, t.tglTerima, t.no_gudang, t.tglExp, t.jml, t.harga, 
		 t.aharga, sum((100/110)*t.aharga) AS dpp, sum((10/110)*t.aharga) AS ppn, t.kwi 
		 FROM (SELECT as_masuk.po_id as id, as_ms_rekanan.namarekanan, 
		 DATE_FORMAT(as_po.tgl_po,'%d-%m-%Y') AS tglPo, as_po.no_po, 
		 DATE_FORMAT(as_masuk.tgl_faktur,'%d-%m-%Y') AS tglFaktur, as_masuk.no_faktur, 
		 DATE_FORMAT(as_masuk.tgl_terima,'%d-%m-%Y') AS tglTerima, as_masuk.no_gudang,  
		 DATE_FORMAT(as_masuk.exp_bayar,'%d-%m-%Y') AS tglExp, as_masuk.jml_msk AS jml, 
		 as_masuk.harga_unit AS harga, as_masuk.jml_msk*as_masuk.harga_unit AS aharga, 
		 as_po.kwi FROM as_masuk 
		 INNER JOIN as_po ON as_masuk.po_id = as_po.id 
		 INNER JOIN as_ms_rekanan ON as_ms_rekanan.idrekanan = as_po.vendor_id 
		 WHERE $fRekan as_masuk.exp_bayar <= '".$tglFilter."') AS t $filternm 
		 GROUP BY t.no_po,t.no_gudang,t.no_faktur order by $sorting ";
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
    case 'tagihan':
		while($rows = mysql_fetch_array($rs)){
			$i++;
			$dt .= $rows['id'].chr(3).$i.chr(3).$rows['namarekanan'].chr(3).$rows['tglPo'].chr(3).$rows['no_po'].chr(3).$rows['tglFaktur'].chr(3).$rows['no_faktur'].chr(3).$rows['no_gudang'].chr(3).$rows['tglTerima'].chr(3).number_format($rows['dpp'],0,",",".").chr(3).number_format($rows['ppn'],0,",",".").chr(3).$rows['tglExp'].chr(3).$rows[''].chr(3).$rows['kwi'].chr(6);
		}
		break;
}

if ($dt!=$totpage.chr(5)) {
    $dt=substr($dt,0,strlen($dt)-1);
    $dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);
echo $dt;
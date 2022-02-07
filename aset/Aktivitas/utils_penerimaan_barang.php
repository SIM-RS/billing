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

if($_GET['bln'] and $_GET['ta']<>'')$filter2="where MONTH(tgl_po)=".$_GET['bln']." AND YEAR(tgl_po)=".$_GET['ta']; else $filter2="where MONTH(tgl_po)=$bln AND YEAR(tgl_po)=$thn";
$filter_bon="where MONTH(k.tgl_transaksi)=".$_GET['bln']." AND YEAR(k.tgl_transaksi)=".$_GET['ta']; if($_GET['bln'] and $_GET['ta']=='') $filter_bon="where MONTH(k.tgl_transaksi)=$bln AND YEAR(k.tgl_transaksi)=$thn";
$pilihan = $_REQUEST['pilihan'];
$defaultsort = 'a.tgl_transaksi,a.no_gd,a.klr_id';
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

$tgl_awal=$_REQUEST['tglAwal'];
$tgl_akhir=$_REQUEST['tglAkhir'];

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
    $sorting=$defaultsort;
}

//p.unit_id_terima = '$idunit' AND
//.$filter." ORDER BY ".$sorting
switch($pilihan) {
        case 'penerimaan';
        $sql = "select petugas_gudang,date_format(a.tgl_gd,'%d-%m-%Y') as tglt, a.klr_id, a.kode_transaksi,b.kodebarang, b.namabarang, a.satuan, a.jml_klr,a.no_gd, 
                c.namaunit, d.namalokasi 
                from as_keluar a 
                inner join as_ms_barang b on a.barang_id=b.idbarang
                inner join as_ms_unit c on a.unit_id=c.idunit
                left join as_lokasi d on a.lokasi_id=d.idlokasi
                where a.jml_klr>0 AND NOT ISNULL(a.no_gd) AND DATE(a.tgl_gd) BETWEEN '".tglSQL($tgl_awal)."' AND '".tglSQL($tgl_akhir)."' ".$filter." order by ".$sorting."";
        //echo $sql;
        break;
}
//echo $sql."<br>";
$rs=mysql_query($sql);
echo mysql_error();
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
        case 'pengeluaran':
		while($rows = mysql_fetch_array($rs)){
			$i++;
			$dt .= $rows['id'].chr(3).$i.chr(3).$rows['tglt'].chr(3).$rows['no_gd'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['satuan'].chr(3).$rows['jml_klr'].chr(3).$rows['namaunit'].chr(3).$rows['namalokasi'].chr(3).$rows['petugas_gudang'].chr(6);
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

?>
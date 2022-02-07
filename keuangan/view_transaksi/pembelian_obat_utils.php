<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
$idTrans=$_REQUEST['cmbPend'];
$ksoId=$_REQUEST['ksoId'];
$tgl=tglSQL($_REQUEST['txtTgl']);
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$txtBayar=explode("|",$_REQUEST['txtBayar']);
$txtTin=explode("*",$_REQUEST['txtTin']);
$kunjId=explode("|",$_REQUEST['kunjId']);
$kso = $_REQUEST['kso'];
$grid = $_REQUEST['grid'];
$no_penjualan = $_REQUEST['no_penjualan'];
$unit_id = $_REQUEST['unit_id'];
//===============================
$statusProses='';
$alasan='';
$fkso="";
if ($kso!="0") $fkso=" and a_p.PBF_ID = '$kso' ";
$waktu = $_REQUEST['waktu'];
switch($waktu) {
    case 'harian':
        $waktu = " a_p.TANGGAL = '$tgl' ";
        break;
    case 'periode':
        $tglAwal = tglSQL($_REQUEST['tglAwal']);
        $tglAkhir = tglSQL($_REQUEST['tglAkhir']);
        $waktu = " a_p.TANGGAL between '$tglAwal' and '$tglAkhir' ";
        //'".$tglAkhir."'
        break;
    case 'bulan':
        $waktu = " MONTH(a_p.TANGGAL) = '".$bln."' AND YEAR(a_p.TANGGAL) = '".$thn."' ";
        //last_day('$thn-$bln-01')
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" where ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    if($grid == 3) {
        $sql="select t1.* from(
                select ap.id,no_penjualan,no_pasien,nama_pasien,dokter,ap.HARGA_TOTAL_PPN as sub_tot,u.unit_name as unit
                ,au.unit_name,ap.unit_id,ap.kso_id
                 from $dbapotek.a_penjualan ap
                left join $dbapotek.a_unit u on u.unit_id = ap.ruangan
                inner join $dbapotek.a_mitra am on ap.kso_id = am.idmitra
                left join $dbapotek.a_unit au on au.unit_id = ap.unit_id
                where $waktu $fkso group by SHIFT,NO_PENJUALAN,TGL,ap.KSO_ID,ap.UNIT_ID,ap.JENIS_PASIEN_ID,ap.CARA_BAYAR) t1 $filter order by $sorting";
    }
    else if($grid == 2) {
            //detil
        $sql = "select * from(
                select ap.id,ao.obat_nama,sum(ap.qty_jual) as qty_jual, ap.HARGA_SATUAN, sum(ap.qty_jual*(ap.HARGA_SATUAN+(ap.HARGA_SATUAN*(ap.PPN/100)))) as sub_tot
                 from $dbapotek.a_penjualan ap
                 inner join $dbapotek.a_penerimaan pe on ap.penerimaan_id = pe.id
                 inner join $dbapotek.a_obat ao on ao.obat_id = pe.obat_id
                where ap.no_penjualan = '$no_penjualan' and ap.unit_id = '$unit_id' group by ao.obat_id) t1
            $filter order by $sorting";
    } else if($grid==1) {
	
		 $sql="select t1.*, (t1.dpp + t1.ppn) as total,date_format(TANGGAL,'%d-%m-%Y') TANGGAL1 from(SELECT a_p.*,ok.kategori,ab.BENTUK,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,apo.cara_bayar_po,
			SUM(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN) AS subtotal,
			SUM(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)) AS dpp,
			SUM((IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS ppn,
			SUM((((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)))) AS dpp_ppn,
			o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, a_pbf.PBF_NAMA, sd.nama sumberdana, sum(a_p.diskon_rp) total_diskon
			FROM  $dbapotek.a_penerimaan a_p 
			INNER JOIN $dbapotek.a_obat o ON a_p.OBAT_ID=o.OBAT_ID 
			INNER JOIN $dbapotek.a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
			INNER JOIN  $dbapotek.a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID 
			LEFT JOIN (SELECT id, nama FROM $dbapotek.a_sumber_dana) sd ON sd.id = a_p.SUMBER_DANA
			LEFT JOIN  $dbapotek.a_obat_kategori ok ON ok.id = o.OBAT_KATEGORI
			LEFT JOIN  $dbapotek.a_bentuk ab ON ab.BENTUK = o.OBAT_BENTUK
			inner join  $dbapotek.a_po apo ON a_p.FK_MINTA_ID = apo.ID where $waktu $fkso AND  a_p.TIPE_TRANS=0 group by a_p.NOTERIMA) t1
            $filter order by $sorting";
	
	}
    
    if($grid == 1){
	   $sqlPlus = "select sum(subtotal) as sub_tot from (".$sql.") sql36";
	   $rsPlus = mysql_query($sqlPlus);
    }
	
	 // echo $sql."<br>";
   
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

    if($grid == 1) {
	
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["TANGGAL1"].chr(3).$rows["PBF_NAMA"].chr(3).$rows["NOTERIMA"].chr(3).$rows["NOBUKTI"].chr(3).number_format($rows["subtotal"],0,",",".").chr(3).number_format($rows["total_diskon"],0,",",".").chr(3).number_format($rows["ppn"],0,",",".").chr(3).number_format($rows["total"],0,",",".").chr(6);
        }
    }
   

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
    
    if($grid == 1){
	   if(mysql_num_rows($rsPlus) > 0){
		  $rowPlus = mysql_fetch_array($rsPlus);
		  //if($rowPlus['bayar']!=0 && $grid == 1){
			 $dt = $dt.number_format($rowPlus['total'],0,",",".");
		  //}
		  mysql_free_result($rsPlus);
	   }
    }
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
//    header("Content-type: application/xhtml+xml");
}else {
//    header("Content-type: text/xml");
}
echo $dt;
//*/
?>
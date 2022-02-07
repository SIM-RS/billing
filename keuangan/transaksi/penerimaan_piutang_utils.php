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
$tglKlaim=tglSQL($_REQUEST['txtTglKlaim']);
//echo $tgl."<br>";
$noKlaim=$_REQUEST['txtNoKlaim'];
$noBukti=$_REQUEST['txtNoBu'];
$txtBayar=$_REQUEST['txtBayar'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$userId=$_REQUEST['userId'];
$ckso = $kso;
$grid = $_REQUEST['grid'];
//===============================
$statusProses='';
$alasan='';
$waktu = $_REQUEST['waktu'];
switch($waktu) {
    case 'harian':
        $waktu = " and t.tgl = '$tgl' ";
        $tgl_k = "if(tk.tgl_out>='".$tgl."',1,0)";
        break;
    case 'periode':
        $tglAwal = tglSQL($_REQUEST['tglAwal']);
        $tglAkhir = tglSQL($_REQUEST['tglAkhir']);
        $waktu = " and t.tgl between '$tglAwal' and '$tglAkhir' ";
        $tgl_k = "if(tk.tgl_out>='$tglAwal' and tk.tgl_out<='$tglAkhir',1,0)";
        //'".$tglAkhir."'
        break;
    case 'bulan':
        $waktu = " AND (MONTH(t.tgl) = '".$bln."' AND YEAR(t.tgl) = '".$thn."') ";
        $tgl_k = "if(month(tk.tgl_out)>$bln,1,if(month(tk.tgl_out)=$bln,1,0))";
        //last_day('$thn-$bln-01')
        break;
}
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$sqlTambah="INSERT INTO k_transaksi(id_trans,tgl,tgl_klaim,no_bukti,no_faktur,kso_id,nilai,ket,tgl_act,user_act) VALUES('$idTrans','$tgl','$tglKlaim','$noBukti','$noKlaim','$ksoId','$txtBayar','$ket',now(),'$userId')";
		//echo $sqlTambah."<br/>";
		$rs=mysql_query($sqlTambah);
        break;
    case 'hapus':
		$sqlHapus="delete from k_transaksi where id='$id'";
		$rs=mysql_query($sqlHapus);
        break;
    case 'simpan':
        $sqlSimpan="update k_transaksi set id_trans='$idTrans',tgl='$tgl',tgl_klaim='$tglKlaim',no_bukti='$noBukti',no_faktur='$noKlaim',kso_id='$ksoId',nilai='$txtBayar',ket='$ket' where id='$id'";
        $rs=mysql_query($sqlSimpan);
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    if($grid == 1) {
		$sql="SELECT * FROM (SELECT t.id,kso.id ksoId,DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,DATE_FORMAT(t.tgl_klaim,'%d-%m-%Y') tglKlaim,t.no_faktur noKlaim,t.no_bukti,kso.nama,t.nilai,t.ket 
FROM k_transaksi t INNER JOIN k_ms_transaksi mt ON mt.id=t.id_trans 
INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id=kso.id
WHERE mt.tipe='3' AND MONTH(t.tgl)='$bln' AND YEAR(t.tgl)='$thn') t1 ".$filter." ORDER BY ".$sorting;
		
		$sqlPlus = "select IFNULL(SUM(nilai),0) as totNilai from (".$sql.") sql36";
		$rsPlus = mysql_query($sqlPlus);
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

    if($grid == 1) {
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$dt.=$rows["id"]."|".$rows["ksoId"].chr(3).number_format($i,0,",",".").chr(3).$rows["tgl"].chr(3).$rows["tglKlaim"].chr(3).$rows["noKlaim"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["ket"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }
    
    if($grid == 1){
	   if(mysql_num_rows($rsPlus) > 0){
		  $rowPlus = mysql_fetch_array($rsPlus);
		  if($rowPlus['totNilai']!=0){
		  	$totTerima=$rowPlus['totNilai'];
			$dt = $dt.$_REQUEST['act']."*|*".number_format($totTerima,0,",",".");
		  }
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
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
//*/
?>
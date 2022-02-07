<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl desc,id desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//====================================================================
$id = $_REQUEST['rowid'];
$idTrans=$_REQUEST['cmbPend'];
$ksoId=$_REQUEST['ksoId'];
$tgl=tglSQL($_REQUEST['txtTgl']);
//echo $tgl."<br>";
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$userId=$_REQUEST['userId'];
$grid = $_REQUEST['grid'];
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,kso_id,nilai,ket,tgl_act,user_act)
			values('$idTrans','$tgl','$noBukti','$ksoId','$nilai','$ket',now(),'$userId')";
		//echo $sqlTambah."<br/>";
		$rs=mysql_query($sqlTambah);
		if (mysql_errno()>0){
			$statusProses='Error';
			$alasan="Gagal Memasukkan Data";
		}
        break;
    case 'hapus':
		$sqlHapus="delete from k_transaksi where id='$id'";
		mysql_query($sqlHapus);
		if (mysql_errno()>0){
			$statusProses='Error';
			$alasan="Gagal Menghapus Data";
		}
        break;
    case 'simpan':
		$sqlSimpan="update k_transaksi set tgl='$tgl',no_bukti='$noBukti',kso_id='$ksoId',nilai='$nilai',ket='$ket',tgl_act=now() 
					where id='$id'";              
		$rs=mysql_query($sqlSimpan);
		if (mysql_errno()>0){
			$statusProses='Error';
			$alasan="Gagal Mengubah Data";
		}
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

	$sql="SELECT * FROM (SELECT t.id,t.tgl,t.no_bukti,t.id_trans,kso.nama AS kso,t.nilai,t.ket FROM k_transaksi t 
		 INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id=kso.id
		 WHERE MONTH(t.tgl)='$bln' AND YEAR(t.tgl)='$thn' and t.id_trans = 0) as gab ".$filter." order by ".$sorting;
    
    /*if($grid == 1){
	   $sqlPlus = "select sum(biayaRS) as totPer,sum(biaya_kso) as totKso,sum(biaya_pasien) as totPas from (".$sql.") sql36";
	   $rsPlus = mysql_query($sqlPlus);
    }*/
    
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
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_bukti"].chr(3).$rows["kso"].chr(3).$rows["nilai"].chr(3).$rows["ket"].chr(6);
	}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
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
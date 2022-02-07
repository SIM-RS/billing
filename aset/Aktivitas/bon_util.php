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
$aksi = $_REQUEST['act'];
$defaultsort = 'kode_transaksi desc';
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$idunit=$_SESSION["userid"];
$bln=$_REQUEST['bln'];
if ($bln=="")
    $bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$thn=$_REQUEST['thn'];
if ($thn=="") $thn=$th[2];
$usr_id = $_REQUEST['usr_id'];
$id = $_REQUEST['id'];


    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    echo $aksi;
    switch($aksi){
        case 'hapus':
            $sqlCek="select stt from as_keluar where kode_transaksi='".$_GET['kode']."' and stt='1'";
            $rsCek=mysql_query($sqlCek);
            $isAdaData=mysql_num_rows($rsCek);
            if ($isAdaData<=0){
				$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete BON','DELETE FROM AS_KELUAR WHERE kode_transaksi=".$_GET['kode']."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
                $sqlHapus="DELETE FROM AS_KELUAR WHERE kode_transaksi='".$_GET['kode']."'";
                mysql_query($sqlHapus);
            }
            break;
    }
    
 //   switch($pilihan) {
       // case 'tampil':
            $sorting_bon="k.tgl_transaksi desc,k.kode_transaksi desc"; if ($sorting!="") $sorting_bon=$sorting;
             $sql = "SELECT k.klr_id, k.tgl_transaksi,k.kode_transaksi,namaunit,k.petugas_rtp,k.petugas_unit,stt,b.tipe
                    FROM as_keluar k INNER JOIN as_ms_barang b ON k.barang_id=b.idbarang 
                    LEFT JOIN as_ms_unit u ON k.unit_id=u.idunit              
                    $filter_bon $filter
                    GROUP BY k.tgl_transaksi,k.kode_transaksi ORDER BY $sorting_bon";
        //    break;
 //  }

   $rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
    //echo $sql."<br >";
    
    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    switch($pilihan) {
        case 'tampil':
            while($rows = mysql_fetch_array($rs)) {
				$data=$rows['klr_id']."|".$rows['tipe'];
                $i++;
				if($rows['stt']==1) $stt = "Sudah Diterima";
				if($rows['stt']==2) $stt = "Dibatalkan";
				if($rows['stt']==0) $stt = "Belum Diterima";
                $dt .= $data.chr(3).$i.chr(3).tglSQL($rows['tgl_transaksi']).chr(3).$rows['kode_transaksi'].chr(3).'&nbsp;'.$rows['namaunit'].chr(3).$rows['petugas_rtp'].chr(3).$rows['petugas_unit'].chr(3).$stt.chr(6);
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
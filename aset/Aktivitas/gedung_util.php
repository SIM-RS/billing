<?php
session_start();
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
    $page=$_REQUEST["page"];
    $sorting=$_REQUEST["sorting"];
    $filter=$_REQUEST["filter"];
    $id_kib_seri = explode('|', $_GET['rowid']);
    $alasan = $_REQUEST['alasan'];
    $defaultsort = 'kodebarang';

    if(isset($_GET['act']) && $_GET['act'] != '' ) {
        $t_updatetime = date("Y-m-d H:i:s");
        $t_ipaddress = $_SERVER['REMOTE_ADDR'];
        $t_userid = $_SESSION['userid'];
        $act = $_GET['act'];

        $act = explode('_', $act);
        switch($act[0]) {
            case 'hapus':
                $sql_del = "update as_seri set isaktif = 0, tgl_hapus = date_format(now(),'%Y-%m-%d'), t_userid = '$t_userid'
                        , t_updatetime = '$t_updatetime', ket_hapus='$alasan'
                        where idseri = ".$id_kib_seri[1];
                $rs = mysql_query($sql_del);
                $res = mysql_affected_rows();
                break;
            case 'mutasi':
                $idtransaksi = $_GET['idtransaksi'];
                $idunit = $_GET['idunit'];
                $idlokasi = $_GET['idlokasi'];
                $tglmutasi = tglSQL($_GET['tglmutasi']);
                $catpetugas = $_GET['catpetugas'];
                $namapetugas = $_GET['namapetugas'];
                $jabatanpetugas = $_GET['jabatanpetugas'];
         
                //insert ke tabel mutasi
                $query = "insert into as_mutasi (idseri,idunitasal,idlokasi_asal,idunittujuan,idlokasi_tujuan,
				tglmutasi,catpetugas,namapetugas,jabatanpetugas,t_userid,t_updatetime,t_ipaddress)  
				select '".$id_kib_seri[1]."', ms_idunit, ms_idlokasi,'$idunit','$idlokasi','$tglmutasi','$catpetugas',
				'$namapetugas','$jabatanpetugas', '$t_userid', '$t_updatetime', '$t_ipaddress' from as_seri where idseri = ".$id_kib_seri[1];
                $rs = mysql_query($query);
				
				//update as_seri2
                $query = "update as_seri2 set ms_idunit='$idunit' ,ms_idlokasi='$idlokasi' where idseri = ".$id_kib_seri[1];
                $rs = mysql_query($query);
 
                break;
        }
    }

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }

   
    $sql="SELECT mu.kodeunit, br.idbarang,br.kodebarang,sr.noseri,br.namabarang,sr.kondisi,sr.thn_pengadaan,
					sr.harga_perolehan,sr.asalusul,kib.bertingkat,kib.beton,kib.luas_lantai,kib.alamat,
					kib.dok_tgl,kib.dok_no,kib.luas_tanah,kib.kode_tanah,kib.ket
					FROM as_ms_barang br INNER JOIN 
					(SELECT * FROM as_seri2 WHERE isaktif=1 AND jenis_kib='03') sr ON br.idbarang=sr.idbarang
					LEFT JOIN kib03 kib ON sr.idseri=kib.idseri
					LEFT JOIN as_ms_unit mu ON mu.idunit=sr.ms_idunit";

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
                //$dt.=$rows["id_kib"].'|'.$rows['idseri'].chr(36).$rows['ms_idunit'].chr(36).$rows['namaunit'].chr(36).$rows['ms_idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$rows["tipe"].chr(3).$rows["golbang"].chr(3).$rows["tahunperolehan"].chr(3).$rows["jumlahlantai"].chr(3).$rows["luasbangunan"].chr(6);
                $dt.=$rows['kodeunit'].chr(3).$rows['kodebarang'].chr(3).$rows['noseri'].chr(3).$rows['namabarang'].chr(3).$rows['kondisi'].chr(6);
            }


    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1);
        $dt=str_replace('"','\"',$dt);
    }
    mysql_free_result($rs);
    mysql_close($konek);
    header("Cache-Control: no-cache, must-revalidate" );
    header("Pragma: no-cache" );
    if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
        header("Content-type: application/xhtml+xml");
    }else {
        header("Content-type: text/xml");
    }
    echo $dt;
}
?>
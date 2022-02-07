<?php
include '../sesi.php';
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '') {
    include("../koneksi/konek.php");
//====================================================================
$idseri=$_GET['idseri'];
$idunitlama=$_GET['idunitlama'];
$idunitbaru=$_GET['idunitbaru'];
$namapetugas=$_GET['namaperugas'];
$jbtpetugas=$_GET['jbtpetugas'];
$catpetugas=$_GET['catpetugas'];
$tglmutasi=$_GET['tgl'];
$tglmutasi=explode('-',$tglmutasi);
$tglmutasi=$tglmutasi[2]."-".$tglmutasi[1]."-".$tglmutasi[0];
//================================
$t_updatetime = date("Y-m-d H:i:s");
$t_ipaddress = $_SERVER['REMOTE_ADDR'];
$t_userid = $_SESSION['userid'];
//========Update Mutasi==================================
if($_GET['act']=='berubah'){
	 $sqlupdate="update as_seri2 set ms_idunit='$idunitbaru' where idseri='$idseri'";
	mysql_query($sqlupdate);
	
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Mutasi','insert into as_mutasi (idunitasal,idunittujuan,idseri,tglmutasi,catpetugas,namapetugas,jabatanpetugas,t_userid,t_updatetime,t_ipaddress) values($idunitlama,$idunitbaru,$idseri,$tglmutasi,$catpetugas,$namapetugas,$jbtpetugas,$t_userid,$t_updatetime,$t_ipaddress)','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns);
	
	 $sqlinsert="insert into as_mutasi (idunitasal,idunittujuan,idseri,tglmutasi,catpetugas,namapetugas,jabatanpetugas,t_userid,t_updatetime,t_ipaddress) values('$idunitlama','$idunitbaru','$idseri','$tglmutasi','$catpetugas','$namapetugas','$jbtpetugas','$t_userid','$t_updatetime','$t_ipaddress')";
	mysql_query($sqlinsert);
	
}
//Paging,Sorting dan Filter======
    $page=$_REQUEST["page"];
    $sorting=$_REQUEST["sorting"];
    $filter=$_REQUEST["filter"];
    
    $sorting1=$_REQUEST["sorting"];
    $filter1=$_REQUEST["filter"];
    
    $pilihan = $_REQUEST['pilihan'];
	$tglhapus = $_REQUEST['tglhps'];
    $id_kib_seri = explode('|', $_GET['rowid']);
    $alasan = $_REQUEST['alasan'];
    $defaultsort = 'kodebarang,noseri';
    /*$tanah = $_REQUEST["tanah"];
$perolehan = $_REQUEST["perolehan"];*/
//===============================

    if(isset($_GET['act']) && $_GET['act'] != '' ) {
        /* $t_updatetime = date("Y-m-d H:i:s");
        $t_ipaddress = $_SERVER['REMOTE_ADDR'];
        $t_userid = $_SESSION['userid']; */
        $act = $_GET['act'];

        $act = explode('_', $act);
        switch($act[0]) {
            case 'hapus':
                $sql_del = "update as_seri2 set isaktif = 1, tglhapus = date_format(now(),'%Y-%m-%d'), t_userid = '$t_userid'
                        , t_updatetime = '$t_updatetime', t_ipaddress = '$t_ipaddress', catperlengkapan='$alasan'
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
                $query = "insert into as_mutasi select null, '".$id_kib_seri[1]."', ms_idunit, ms_idlokasi,'$idunit','$idlokasi','$tglmutasi','$catpetugas','$namapetugas','$jabatanpetugas'
                    , '$t_userid', '$t_updatetime', '$t_ipaddress' from as_seri2 where idseri = ".$id_kib_seri[1];
                $rs = mysql_query($query);
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
    
    if ($filter1!="") {
        $filter1=explode("|",$filter1);
        $filter1=" and ".$filter1[0]." like '%".$filter1[1]."%'";
    }

    if ($sorting1=="") {
        $sorting1='kodebarang,noseri';
    }

    switch($pilihan) {
        case 'tanah':
           $sql ="SELECT * FROM (SELECT
		   		  s.idseri,u.kodeunit,u.namaunit,s.ms_idunit,l.kodelokasi,s.ms_idlokasi,s.asalusul,
				  s.idbarang,b.kodebarang,b.namabarang,s.noseri,l.namalokasi,k.alamat,k.luas,s.thn_pengadaan
				FROM as_seri2 s INNER JOIN as_ms_barang b ON s.idbarang = b.idbarang
				  LEFT JOIN as_ms_unit u ON s.ms_idunit = u.idunit
				  LEFT JOIN as_lokasi l ON s.ms_idlokasi = l.idlokasi
				  INNER JOIN kib01 k ON s.idseri = k.idseri
				WHERE LEFT(b.kodebarang,2) = '01'
					and b.tipe=1 AND s.isaktif = 1) AS kueri $filter ORDER BY $sorting,noseri"; 
					
            break;
        case 'mesin':
                $sql = "SELECT
        seri.idseri,
        seri.ms_idunit,
        unit.kodeunit,
        barang.kodebarang,
        seri.noseri,
        barang.namabarang,
        unit.namaunit,
        seri.jenis_kib,
        kib.merk,
        seri.thn_pengadaan,
        seri.asalusul
      FROM as_seri2 seri
        INNER JOIN as_ms_barang barang
          ON barang.idbarang = seri.idbarang
        LEFT JOIN as_ms_unit unit
          ON unit.idunit = seri.ms_idunit
        INNER JOIN kib02 kib
          ON seri.idseri = kib.idseri
      WHERE LEFT(barang.kodebarang,2) = '02'
          AND barang.tipe = 1
          AND seri.isaktif = 1 $filter1 ORDER BY $sorting1";
            break;
        case 'gedung':
            $sql = "select * from (SELECT ms_idunit,namaunit,kodeunit,ms_idlokasi,kodelokasi,namalokasi,kodebarang,namabarang,id_kib,idseri,noseri,tipebang,golbang,t.tgltransaksi,tahunperolehan,jumlahlantai,luasbangunan
                FROM as_kib k
                INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                inner join as_seri s on s.idtransaksi = t.idtransaksi
                INNER JOIN as_ms_unit u ON u.idunit = s.ms_idunit
		left join as_lokasi l on l.idlokasi = s.ms_idlokasi
                WHERE LEFT(b.kodebarang,2) = '03' and b.tipe=1 and s.void = 0) as q1 $filter
                ORDER BY $sorting,noseri";
            //u.kodeunit,b.kodebarang,b.namabarang,k.id_kib,k.tipebang,k.golbang,k.tahunalat,k.luaslantai,k.luasbangunan,noseri
            break;
        case 'jalan':
            $sql = "select * from (SELECT id_kib,ms_idunit,namaunit,ms_idlokasi,kodelokasi,namalokasi,kodebarang,idseri,noseri,namabarang,keadaanalat,panjang,lebar,kodeunit
                FROM as_kib k
                INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                inner join as_seri s on s.idtransaksi = t.idtransaksi
                INNER JOIN as_ms_unit u ON u.idunit = s.ms_idunit
		left join as_lokasi l on l.idlokasi = s.ms_idlokasi
                WHERE LEFT(b.kodebarang,2) = '04' and b.tipe=1 and s.void = 0) as q1 $filter
                ORDER BY $sorting,noseri";
            //u.kodeunit,b.kodebarang,b.namabarang,k.id_kib,k.panjang,k.lebar,noseri
            break;
        case 'aset':
            $sql = " SELECT * FROM (SELECT buku_judul,t.thn_pengadaan,l.namalokasi,l.kodelokasi,l.idlokasi,u.idunit,
 u.namaunit,t.harga_perolehan, buku_pengarang, buku_spek, seni_asal, seni_pencipta, seni_bahan, 
 jenis, ukuran,t.noseri, t.idseri, b.kodebarang,b.namabarang, u.kodeunit 
 FROM as_seri2 t INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang 
 INNER JOIN as_ms_unit u ON u.idunit = t.ms_idunit 
 LEFT JOIN kib05 k ON t.idseri = k.idseri 
 LEFT JOIN as_lokasi l ON l.idlokasi = t.ms_idlokasi 
 WHERE LEFT( b.kodebarang, 2 ) = '05' AND (b.tipe=1) AND t.isaktif = 1 ) AS q1 $filter";
            break;
        case 'konstruksi':
           $sql = "select * from (SELECT ms_idunit,namaunit,u.kodeunit,ms_idlokasi,kodelokasi,namalokasi,b.kodebarang,b.namabarang,k.id_kib,k.luasbangunan,k.tglbangun,noseri,konskategori,idseri
                FROM as_kib k
                INNER JOIN as_transaksi t ON t.idtransaksi = k.idtransaksi
                INNER JOIN as_ms_barang b ON b.idbarang = t.idbarang
                inner join as_seri s on s.idtransaksi = t.idtransaksi
                INNER JOIN as_ms_unit u ON u.idunit = s.ms_idunit
		left join as_lokasi l on l.idlokasi = s.ms_idlokasi
                WHERE LEFT(b.kodebarang,2) = '06' and b.tipe=1 and s.void = 0) as q1 $filter
                ORDER BY $sorting,noseri";
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
        case 'tanah':
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
                $dt.=$rows['idseri'].chr(36).$rows['ms_idunit'].chr(36).$rows['namaunit'].chr(36).$rows['ms_idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$rows["luas"].chr(3).$rows["thn_pengadaan"].chr(3).$rows["asalusul"].chr(3).$rows["alamat"].chr(6);
            }
            break;
        case 'mesin':
            while ($rows=mysql_fetch_array($rs)) {
               	$id=$rows['idseri']."|".$rows['idbarang']."|".$rows['ms_idunit']."|".$rows['namaunit']."|".$rows['ms_idlokasi']."|".$rows['kodeunit']; 
			    $i++;			
                $dt.=$id.chr(3).$i.chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).str_pad($rows["noseri"],4,"0",STR_PAD_LEFT).chr(3).$rows["namabarang"].chr(3).$rows["merk"].chr(3).$rows["thn_pengadaan"].chr(3).$rows["asalusul"].chr(6);
            }
            break;
        case 'gedung':
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
				
                $dt.=$rows["id_kib"].'|'.$rows['idseri'].chr(36).$rows['ms_idunit'].chr(36).$rows['namaunit'].chr(36).$rows['ms_idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$rows["tipe"].chr(3).$rows["golbang"].chr(3).$rows["tahunperolehan"].chr(3).$rows["jumlahlantai"].chr(3).$rows["luasbangunan"].chr(6);
                //echo $dt;
				//$rows["id_kib"].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$rows["tipe"].chr(3).$rows["golbang"].chr(3).$rows["tahunalat"].chr(3).$rows["luaslantai"].chr(3).$rows["luasbangunan"].chr(6);
            }
            break;
        case 'jalan':
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
                switch ($rows["keadaanalat"]) {
                    case 1 : $keadaanalat = "B";
                        break;
                    case 2 : $keadaanalat = "KB";
                        break;
                    case 3 : $keadaanalat = "RB";
                        break;
                    case 4 : $keadaanalat = "TB";
                        break;
                    default : $keadaanalat = '';
                        break;
                }
                $dt.=$rows["id_kib"].'|'.$rows['idseri'].chr(36).$rows['ms_idunit'].chr(36).$rows['namaunit'].chr(36).$rows['ms_idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$rows["panjang"].chr(3).$rows["lebar"].chr(3).$keadaanalat.chr(6);
            }
            break;
        case 'aset':
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
                $dt.=$rows["id_kib"].'|'.$rows['idseri'].chr(36).$rows['idunit'].chr(36).$rows['namaunit'].chr(36).$rows['idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).str_pad($rows["noseri"], 4, "0", STR_PAD_LEFT).chr(3).$rows["namabarang"].chr(3).$rows["thn_pengadaan"].chr(3).number_format($rows["harga_perolehan"]).chr(6);
            }
            break;
        case 'konstruksi':
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
                switch ($rows["konskategori"]) {
                    case 1 : $kat = "P";
                        break;
                    case 2 : $kat = "SP";
                        break;
                    case 3 : $kat = "D";
                        break;
                }
                $dt.=$rows["id_kib"].'|'.$rows['idseri'].chr(36).$rows['ms_idunit'].chr(36).$rows['namaunit'].chr(36).$rows['ms_idlokasi'].chr(36).$rows['kodelokasi'].chr(36).$rows['namalokasi'].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows["noseri"].chr(3).$rows["namabarang"].chr(3).$kat.chr(3).$rows["luasbangunan"].chr(3).$rows["tglbangun"].chr(3).$rows["noseri"].chr(6);
            }
            break;
    }

    /*if($tanah == "true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["id_kib"].chr(3).$rows["kodeunit"].chr(3).$rows["kodebarang"].chr(3).$rows[""].chr(3).$rows["namabarang"].chr(3).$rows["luastanah"].chr(3).$rows["tglperolehan"].chr(6);
    }
}
else if($perolehan == "true") {
    while($rows = mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows[""].chr(3).$rows["kodeunit"].chr(3).$rows["tgltransaksi"].chr(3).$rows["tok"].chr(3).$rows["idjenistrans"].chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["totalamount"].chr(3).$rows["noref"].chr(3).$rows["namalokasi"].chr(6);
    }
}*/

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
<?php
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$pilihan = $_REQUEST['pilihan'];

switch($_REQUEST['act']) {
	case 'hapus_lokasi':
	$sqlInsL="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master Lokasi','delete from as_lokasi where idlokasi=".$_REQUEST['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
	 mysql_query($sqlInsL);
	 $sqlHapus="delete from as_lokasi where idlokasi='".$_REQUEST['rowid']."'";
        mysql_query($sqlHapus);
        break;
    case 'hapus_rekanan':
	$sqlInsR="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master Rekanan','delete from as_ms_rekanan where idrekanan=".$_REQUEST['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlInsR);
        $sqlHapus="delete from as_ms_rekanan where idrekanan='".$_REQUEST['rowid']."'";
        mysql_query($sqlHapus);
        break;
    case 'hapus_dana':
		$sqlInsD="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master Sumber Dana','delete from as_ms_sumberdana where idsumberdana=".$_REQUEST['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlInsD);
        $sqlHapus="delete from as_ms_sumberdana where idsumberdana='".$_REQUEST['rowid']."'";
        mysql_query($sqlHapus);
        break;
    case 'hapus_unit':
	$sqlInsU="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master Unit','delete from as_ms_unit where idunit=".$_REQUEST['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlInsU);
        $sqlHapus="delete from as_ms_unit where idunit='".$_REQUEST['rowid']."'";
        mysql_query($sqlHapus);
        break;
    case 'hapus_barang':
	$sqlInsB="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Delete Master Barang','delete from as_ms_barang where idbarang=".$_REQUEST['rowid']."','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlInsB);
        $sqlHapus="delete from as_ms_barang where idbarang='".$_REQUEST['rowid']."'";
        mysql_query($sqlHapus);
        break;

    case 'hapus_gedung':
        $sqlHapus = "delete from as_ms_gedung where idgedung = '".$_GET['idgedung']."'";
        mysql_query($sqlHapus);
        break;

    case 'hapus_ruangan':
        $sqlHapus = "delete from as_lokasi where idlokasi = '".$_GET['idruangan']."'";
        mysql_query($sqlHapus);
        break;
}

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

switch($pilihan) {
	case 'lokasi':
	if ($sorting=="") {
            $sorting='kodelokasi';
        }
	 $sql = "select * from as_lokasi $filter order by $sorting";
	break;
    case 'grd':
        if ($sorting=="") {
            $sorting='kodebarang';
        }
        $sql = "select * from (SELECT idbarang id,kodebarang,namabarang,tipebarang,level,idsatuan,mru,isbrg_aktif,kemasan
            FROM as_ms_barang where tipe = '".$_GET['tipe']."') as q1 $filter
                ORDER BY $sorting";
        break;
    case 'grdUnit':
        if ($sorting=="") {
            $sorting='kodeunit';
        }
        $sql = "SELECT idunit id,kodeunit,namaunit nama,namapanjang,level,isunit_aktif
            FROM as_ms_unit $filter
            ORDER BY $sorting ";
        break;
    case 'gedung':
        if ($sorting=="") {
            $sorting='kodegedung';
        }
        $sql = "select idgedung,kodegedung,namagedung,tahunbangun,nourut,t_userid,t_updatetime,t_ipaddress
            from as_ms_gedung $filter order by $sorting";
        break;
    case 'grdDana':
        if ($sorting=="") {
            $sorting='nourut';
        }
        $sql = "SELECT idsumberdana, keterangan, nourut
            FROM as_ms_sumberdana $filter
            ORDER BY $sorting";
        break;
    case 'ruangan':
        if ($sorting=="") {
            $sorting='kodeunit,kodelokasi';
        }
        $sql = "select idlokasi,l.idunit,u.namaunit,kodelokasi,namalokasi,idtipelokasi,l.idgedung,luas,kapasitas,jumlahkursi,deskripsi
                ,penanggungnip,penanggungnama,penanggungnip2,penanggungnama2,l.t_userid,l.t_updatetime,g.namagedung
                from as_lokasi l left join as_ms_unit u on u.idunit=l.idunit
                left join as_ms_gedung g on l.idgedung=g.idgedung
                $filter order by $sorting";
        break;
    case 'grdRek':
        if ($sorting=="") {
            $sorting='koderekanan';
        }
        $sql = "SELECT idrekanan,koderekanan,namarekanan,as_ms_rekanan.idtipesupplier,t.keterangan AS ket,alamat,alamat2,telp,telp2,kodepos,kota,negara,hp,fax,email,contactperson,deskripsi,if(status=1,'Aktif','Tidak Aktif') status,npwp,fp,siupp
                FROM as_ms_rekanan
                INNER JOIN as_tiperekanan t ON t.idtipesupplier=as_ms_rekanan.idtipesupplier
                $filter order by $sorting";
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
	case 'lokasi':
		while ($rows=mysql_fetch_array($rs)) {
				$i++;
				if($rows["statuslokasi"]==1){
						$stt = "Aktif";					
					}else{
						$stt = "Tidak Aktif";						
						}
				$dt .= $rows["idlokasi"].chr(3).$i.chr(3).$rows["kodelokasi"].chr(3).$rows["namalokasi"].chr(3).$stt.chr(6);			
			}	
	break;
    case 'grd':
        while ($rows=mysql_fetch_array($rs)) {
			if($rows["isbrg_aktif"]==1){$stt = "<input type='checkbox' checked='true' onclick='return false'>";}else{$stt = "<input type='checkbox' onclick='return false'>"; }
            $i++;
            $dt.=$rows["id"].chr(3).$i.chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(3).$rows["idsatuan"].chr(3).$rows["kemasan"].chr(3).$rows["level"].chr(3).$stt.chr(6);
        }
        break;
    case 'grdUnit':
        while($rows = mysql_fetch_array($rs)) {
		if($rows["isunit_aktif"]==1){$stt = "<input type='checkbox' checked='true' onclick='return false'>";}else{$stt = "<input type='checkbox' onclick='return false'>"; }
			
            $i++;
            $dt.=$rows["id"].chr(3).$i.chr(3).$rows["kodeunit"].chr(3).$rows["nama"].chr(3).$rows["namapanjang"].chr(3).$rows["level"].chr(3).$stt.chr(6);
        }
        break;
    case 'gedung':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idgedung"].chr(3).$i.chr(3).$rows["kodegedung"].chr(3).$rows["namagedung"].chr(3).$rows["tahunbangun"].chr(6);
            //.'|'.$rows['t_userid,t_updatetime,t_ipaddress']
        }
        break;
    case 'grdDana':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idsumberdana"].chr(3).$rows["nourut"].chr(3).$rows["keterangan"].chr(6);
        }
        break;
    case 'ruangan':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            /*jumlahkursi,deskripsi
                ,penanggungnip,penanggungnama,penanggungnip2,penanggungnama2,t_userid,t_updatetime*/
            $dt.=$rows["idlokasi"].chr(3).$i.chr(3).$rows["namaunit"].chr(3).$rows["kodelokasi"].chr(3).$rows["namalokasi"].chr(3).$rows["idtipelokasi"]
                    .chr(3).$rows["namagedung"].chr(6);
            //.'|'.$rows['t_userid,t_updatetime,t_ipaddress']
        }
        break;
    case 'grdRek':
        while($rows = mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["idrekanan"].chr(3).$i.chr(3).$rows["namarekanan"].chr(3).$rows["idtipesupplier"].chr(3).$rows["alamat"].chr(3).$rows["telp"].chr(3).$rows["contactperson"].chr(3).$rows["status"].chr(6);
        }
        break;
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
?>
<?php 
include("../koneksi/konek.php");
$grd1=$_REQUEST["grd1"];
$grd2=$_REQUEST["grd2"];
$grd3=$_REQUEST["grd3"];
$grd4=$_REQUEST["grd4"];
$grdRiw1 = $_REQUEST["grdRiw1"];
$grdRiw2 = $_REQUEST["grdRiw2"];
$grdRiw3 = $_REQUEST["grdRiw3"];
$grdPel = $_REQUEST["grdPel"];
$grdKmr = $_GET['grdkmr'];
$jns = $_GET['jns'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgldesc desc";
$defaultsort1="Nama1";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

if ($filter!="") {
    $filter=explode("|",$filter);
    $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") {
    if ($grd1=="true") {
        $sorting=$defaultsort;
    }elseif ($grd2=="true") {
        $sorting=$defaultsort1;
    }elseif ($grdPel=="true") {
        $sorting="nama";
    }elseif ($grdRiw1=="true" || $grdRiw2=="true" || $grdRiw3=="true") {
        $sorting="tgl DESC";
    }elseif ($grdKmr == 'true'){
		$sorting="kamar";
	}
}

switch($_GET['act']){
    case 'accessVerify':
	   $sql = "select id from b_ms_pegawai_unit where ms_pegawai_id = '".$_GET['user_id']."' and unit_id = '".$_GET['unit_id']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   echo $res;
	   return;
	   break;
    case 'getAkses':
	   //mengambil data untuk keperluan akses hapus kunjungan dan tindakan, jika ada pada salah satu group_id (10,45,46),maka akses dibuka
	   //10 = team IT, 45 = koor Verifikator, 46 = KOR.DATA MNGMEN CIO
	    $sql = "select id from b_ms_group_petugas WHERE ms_group_id in (10,45,46) AND ms_pegawai_id = '".$_GET['user_id']."'";
	    $rs = mysql_query($sql);
	    $res = mysql_num_rows($rs);
	    echo $res;
	    mysql_free_result($rs);
	   return;
	   break;
    case 'cekPelayanan':
	   $sql = "select p.id from b_pelayanan p where p.kunjungan_id = '".$_GET['kunjungan_id']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   echo $res;
	   return;
    break;
    case 'cekTindakan':
	   $sql = "select t.id from b_tindakan t where t.pelayanan_id = '".$_GET['pelayanan_id']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   echo $res;
	   return;
    break;
    case 'cekBayar':
	   $sql = "select b.id from b_bayar b inner join b_bayar_tindakan bt on b.id = bt.bayar_id where bt.tindakan_id = '".$_GET['tindakan_id']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   echo $res;
	   return;
	   break;
    case 'hapusTin':
	   $sql = "delete from b_tindakan where id = '".$_GET['tindakan_id']."'";
	   mysql_query($sql);
	   break;
    case 'hapusPel':
	   $sql = "select id from b_tindakan where pelayanan_id = '".$_GET['idPel']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   if($res <= 0){
		  $sql = "select inap from b_ms_unit u inner join b_pelayanan p on u.id = p.unit_id where p.id = '".$_GET['idPel']."'";
		  $rs = mysql_query($sql);
		  $row = mysql_fetch_array($rs);
		  if($row['inap'] == '1'){
			 $sql = "delete from b_tindakan_kamar where pelayanan_id = '".$_GET['idPel']."'";
			 mysql_query($sql);
		  }
		  
		  //menghapus data diagnosa
		  $sql = "delete from b_diagnosa where pelayanan_id = '".$_GET['idPel']."'";
		  mysql_query($sql);
		  
		  //menghapus data resep
		  $sql = "delete from b_resep where id_pelayanan = '".$_GET['idPel']."'";
		  mysql_query($sql);
		  
		  //menghapus data pelayanan
		  $sql = "select * from b_pelayanan where id = '".$_GET['idPel']."' AND tgl=CURDATE()";
		  //echo $sql."<br>";
		  $rs = mysql_query($sql);
		  $res = mysql_num_rows($rs);
		  if ($res>0){
		  	$sql = "delete from b_pelayanan where id = '".$_GET['idPel']."'";
		  }else{
		  	$sql = "update b_pelayanan set hapus=1 where id = '".$_GET['idPel']."'";
		  }
		  //echo $sql."<br>";
		  mysql_query($sql);
		  
		  /*//cek kunjungan masih memiliki pelayanan atau tidak
		  $sql = "select id from b_pelayanan where kunjungan_id = '".$_GET['idKunj']."'";
		  $rs = mysql_query($sql);
		  $res = mysql_num_rows($rs);
		  //jika tidak memiliki data pelayanan lagi,hapus kunjungan pasien tersebut
		  if($res <= 0){
			 
		  }*/
	   }
	   break;
    case 'hapusKun':
	   $sql = "select id from b_pelayanan where kunjungan_id = '".$_GET['idKunj']."'";
	   $rs = mysql_query($sql);
	   $res = mysql_num_rows($rs);
	   if($res <= 0){
		  $sql = "delete from b_kunjungan where id = '".$_GET['idKunj']."'";
		  mysql_query($sql);
	   }else{
		   $sql = "select id from b_pelayanan where kunjungan_id = '".$_GET['idKunj']."' AND hapus=0";
		   $rs1 = mysql_query($sql);
		   $res1 = mysql_num_rows($rs1);
		   if($res1 <= 0){
			  $sql = "update b_kunjungan set hapus=1 where id = '".$_GET['idKunj']."'";
			  mysql_query($sql);
		   }
	   }
	   break;
    default:
	   break;
}

if ($grd1=="true") {
    $tglM=explode('-',$_REQUEST['tglMsk']);
    $tglM=$tglM[2]."-".$tglM[1]."-".$tglM[0];
    $tglS=explode('-',$_REQUEST['tglSls']);
    $tglS=$tglS[2]."-".$tglS[1]."-".$tglS[0];
    if($_REQUEST['stsPul']!="")
        $stsPul=" pulang=".$_REQUEST['stsPul']." AND";
	if($_REQUEST['sts']!=0 && $_REQUEST['sts']!="")
		$fSts = " k.kso_id=".$_REQUEST['sts']." AND ";
	if($_REQUEST['tmp']!='0' && $_REQUEST['tmp']!=''){
	    $fUnit=" pel.unit_id=".$_REQUEST['tmp']." and ";
	}
	else{
		if($_REQUEST['jns']!=0 && $_REQUEST['jns']!="")
	   		$fUnit=" ut.parent_id=".$_REQUEST['jns']." and ";
	}

	if($jns <> 27)
	{
		$sql = "select * from(select concat(date_format(k.tgl, '%Y-%m-%d '),date_format(k.tgl_act, '%H:%i:%s')) tgldesc, pel.id AS id_pelayanan,k.id,date_format(pel.tgl, '%d-%m-%Y') as tgl, p.no_rm, p.nama, p.sex
		, p.alamat, if(k.isbaru = 0, 'Lama', 'Baru') as kunjungan, kso.nama as statuspas
		, uj.nama as jns_layanan, ut.nama as tmp_layanan, concat(date_format(k.tgl, '%d-%m-%Y '),date_format(k.tgl_act, '%H:%i')) as tgl_masuk
		, date_format(pel.checkoutact, '%d-%m-%Y') as tgl_pulang, if(pulang=1,'Sudah','Belum') as status_pulang,
		IF(pel.dilayani=1,'Sudah',IF(pel.batal=1,'Batal','Belum')) AS status_dilayani
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_pasien p on k.pasien_id = p.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $stsPul $fUnit $fSts k.tgl between '$tglM' and '$tglS') as tab1 $filter order by $sorting";	
	}else{
		$sql = "select * from(select concat(date_format(k.tgl, '%Y-%m-%d '),date_format(k.tgl_act, '%H:%i:%s')) tgldesc, pel.id AS id_pelayanan,k.id,date_format(pel.tgl, '%d-%m-%Y') as tgl, p.no_rm, p.nama, p.sex
		, p.alamat, if(k.isbaru = 0, 'Lama', 'Baru') as kunjungan, kso.nama as statuspas
		, uj.nama as jns_layanan, ut.nama as tmp_layanan, concat(date_format(k.tgl, '%d-%m-%Y '),date_format(k.tgl_act, '%H:%i')) as tgl_masuk
		, date_format(tgl_pulang, '%d-%m-%Y') as tgl_pulang, if(pulang=1,'Sudah','Belum') as status_pulang,
		IF(pel.dilayani=1,'Sudah',IF(pel.batal=1,'Batal','Belum')) AS status_dilayani
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_pasien p on k.pasien_id = p.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $stsPul $fUnit $fSts k.tgl between '$tglM' and '$tglS') as tab1 $filter order by $sorting";	
	}
}
else if($grd1 == 'getVal'){
    
    $tglM=explode('-',$_REQUEST['tglMsk']);
    $tglM=$tglM[2]."-".$tglM[1]."-".$tglM[0];
    $tglS=explode('-',$_REQUEST['tglSls']);
    $tglS=$tglS[2]."-".$tglS[1]."-".$tglS[0];
	if($_REQUEST['sts']!=0 && $_REQUEST['sts']!="")
		$fSts = " and k.kso_id=".$_REQUEST['sts'];
	if($_REQUEST['tmp']!='0' && $_REQUEST['tmp']!=''){
	    $fUnit=" pel.unit_id=".$_REQUEST['tmp']." ";
	}
	else{
	    $fUnit=" ut.parent_id=".$_REQUEST['jns']." ";
	}
	if($jns == 27)
	{
		$sql = "select (select count(k.id) as jml
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $fUnit and k.tgl between '$tglM' and '$tglS' $fSts) as jml
		, (select count(k.id) as jml
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $fUnit and k.tgl between '$tglM' and '$tglS' $fSts and k.pulang = 1) as sudah";
	}else{
		$sql = "select (select count(k.id) as jml
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $fUnit and k.tgl between '$tglM' and '$tglS' $fSts) as jml
		, (select count(k.id) as jml
		from b_pelayanan pel inner join b_ms_unit u on pel.unit_id_asal = u.id
		inner join b_kunjungan k on pel.kunjungan_id= k.id
		inner join b_ms_unit ut on ut.id = pel.unit_id
		inner join b_ms_unit uj on uj.id = ut.parent_id
		inner join b_ms_kso kso on k.kso_id = kso.id
		where $fUnit and k.tgl between '$tglM' and '$tglS' $fSts AND pel.checkoutact IS NOT NULL) as sudah";
	}
	//echo $sql."<br>";
    $rs = mysql_query($sql);
    $row = mysql_fetch_array($rs);
    $total = $row['jml'];
    $sudah = $row['sudah'];
    $belum = $total-$sudah;
    echo $total.'|'.$sudah.'|'.$belum;
    mysql_free_result($rs);
    mysql_close($konek);
    return;
}
else if ($grdRiw1=="true") {
    $sql = "select * from (SELECT k.id AS idkunj, k.pasien_id, k.unit_id, u.nama AS tmptlay, k.tgl, k.kso_id, kso.nama AS penjamin, date_format(k.tgl_pulang,'%Y-%m-%d') tgl_pulang
            FROM b_kunjungan k
            INNER JOIN b_ms_unit u ON u.id = k.unit_id
            LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
            WHERE k.pasien_id = '".$_REQUEST['idPas']."' AND k.hapus=0) as gab $filter order by $sorting";
}
else if($grd3=="true") {
    $sql = "SELECT b_ms_tindakan.kode, b_ms_kelompok_tindakan.nama AS kelompok, b_ms_tindakan.nama AS tindakan,
b_ms_kelas.nama, b_ms_tindakan_kelas.tarip AS tarip FROM b_ms_tindakan_kelas 
INNER JOIN b_ms_kelas ON b_ms_kelas.id=b_ms_tindakan_kelas.ms_kelas_id
INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id=b_ms_tindakan.id
INNER JOIN b_ms_kelompok_tindakan ON b_ms_kelompok_tindakan.id=b_ms_tindakan.kel_tindakan_id
INNER JOIN b_ms_tindakan_unit ON b_ms_tindakan_unit.ms_tindakan_kelas_id=b_ms_tindakan_kelas.id
$filter and b_ms_tindakan.klasifikasi_id='".$_REQUEST['cmbKlasi']."' AND b_ms_tindakan_unit.ms_unit_id='".$_REQUEST['tmp']."' ORDER BY b_ms_tindakan.nama ";
}
else if($grdRiw2=="true") {
   $sql = "select * from (SELECT pl.id AS pelId, pl.kunjungan_id, k.pulang, pl.pasien_id, pl.jenis_layanan, pl.unit_id, pl.dilayani, u.inap, u.nama AS tmptlay, pl.tgl, pl.dokter_id, p.nama AS dokter, pl.kelas_id, kl.nama, date_format(k.tgl_pulang,'%d-%m-%Y') as tgl_pulang
            FROM b_pelayanan pl
            INNER JOIN b_ms_unit u ON u.id = pl.unit_id
            LEFT JOIN b_ms_pegawai p ON p.id = pl.dokter_id
            LEFT JOIN b_ms_kelas kl ON kl.id = pl.kelas_id
		  inner join b_kunjungan k on pl.kunjungan_id = k.id
            WHERE pl.kunjungan_id = '".$_REQUEST['idKunj']."' AND pl.hapus=0) as gab $filter order by $sorting";
}
else if($grdRiw3=="true") {
   $sql = "select * from (SELECT pl.kunjungan_id, t.id AS tindakan_id, pl.id AS pelayanan_id, mt.nama AS tind, mk.nama AS kelas, mp.nama AS dokter, t.qty, t.biaya*t.qty AS biaya, t.bayar, t.lunas AS STATUS, t.ket, pl.no_lab, t.tgl FROM b_pelayanan pl INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id = t.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan mt ON mt.id = mtk.ms_tindakan_id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id = mk.id LEFT JOIN b_ms_pegawai mp ON mp.id = t.user_id WHERE t.pelayanan_id = '".$_REQUEST['idPel']."') as gab $filter order by $sorting";
}
else if($grdPel=="true") {
    $sql = "select * from (SELECT p.id, p.nama, p.alamat, p.telp, p.spesialisasi, pu.unit_id, u.nama AS namaunit
            FROM b_ms_pegawai p
            INNER JOIN b_ms_pegawai_unit pu ON pu.ms_pegawai_id = p.id
            INNER JOIN b_ms_unit u ON u.id = pu.unit_id
            WHERE u.id = '".$_REQUEST['unitId']."' ) as gab $filter order by $sorting";
}
else if($grdKmr == 'true'){
    /*$sql = "SELECT bk.id, bk.unit_id, bu.nama AS namaunit, bk.kode, bk.nama AS namakamar, bkt.tarip, bkt.kelas_id
            , bke.kode AS kodekelas, bke.nama AS namakelas, bk.jumlah_tt, bk.jumlah_tt_b, bk.jumlah_tt - (
            SELECT count( id ) AS dipakai
            FROM b_tindakan_kamar t
            WHERE t.kamar_id = bk.id
            AND t.kelas_id = bkt.kelas_id
            AND tgl_out IS NULL
            ) AS jumlah_kosong
            FROM b_ms_kamar bk
            INNER JOIN b_ms_unit bu ON bk.unit_id = bu.id
            INNER JOIN b_ms_kamar_tarip bkt ON bkt.kamar_id = bk.id
            INNER JOIN b_ms_kelas bke ON bkt.kelas_id = bke.id
            WHERE bk.aktif =1 and bk.unit_id = '".$_GET['unit_id']."' 
            ORDER BY bk.id";*/
	$sql = "SELECT * FROM (SELECT 
			  tbl.*,
			  (total_tt - terpakai) AS kosong 
			FROM
			  (SELECT 
				kmr.id,
				kmr.nama AS kamar,
				kls.nama AS kelas,
				kt.tarip,
				kmr.jumlah_tt,
				kmr.jumlah_tt_b,
				(kmr.jumlah_tt + kmr.jumlah_tt_b) AS total_tt,
				(SELECT 
				  COUNT(tk.id) AS jml 
				FROM
				  b_tindakan_kamar tk 
				  INNER JOIN b_pelayanan p 
					ON p.id = tk.pelayanan_id 
				  INNER JOIN b_kunjungan k 
					ON k.id = p.kunjungan_id 
				WHERE tk.aktif = 1 
				  AND k.pulang = 0 
				  AND tk.tgl_out IS NULL 
				  AND p.dilayani = 1 
				  AND tk.kamar_id = kmr.id) AS terpakai 
			  FROM
				b_ms_kamar kmr 
				INNER JOIN b_ms_kamar_tarip kt 
				  ON kmr.id = kt.kamar_id 
				INNER JOIN b_ms_kelas kls 
				  ON kls.id = kt.kelas_id 
			  WHERE kmr.aktif = 1 
				AND kt.unit_id = '".$_REQUEST['unit_id']."' 
			  ORDER BY kmr.nama) AS tbl) AS gab $filter order by $sorting";
}

//echo $sql."<br>";
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=(intval($page)-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $tpage;
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
if ($grd1=="true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        if($rows['pulang']==0) $pul='Belum Pulang'; else $pul='Sudah Pulang';
		
		if($_REQUEST['inap']=='1'){
			$sKmr="SELECT mk.* FROM b_ms_kamar mk INNER JOIN b_tindakan_kamar tk ON tk.kamar_id=mk.id WHERE tk.pelayanan_id='".$rows['id_pelayanan']."'";
			$qKmr=mysql_query($sKmr);
			$rKmr=mysql_fetch_array($qKmr);
			$dt.=$rows["id"].chr(3).$i.chr(3).$rows['jns_layanan'].chr(3).$rows["tmp_layanan"].chr(3).$rKmr["nama"]."&nbsp;".chr(3).$rows["tgl_masuk"].chr(3).$rows["tgl_pulang"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["alamat"].chr(3).$rows["statuspas"].chr(3).$rows['status_pulang'].chr(3).$rows['kunjungan'].chr(6);
		}
		else{
        	$dt.=$rows["id"].chr(3).$i.chr(3).$rows['jns_layanan'].chr(3).$rows["tmp_layanan"].chr(3).$rows["tgl_masuk"].chr(3).$rows["tgl_pulang"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["alamat"].chr(3).$rows["statuspas"].chr(3).$rows['status_dilayani'].chr(3).$rows['kunjungan'].chr(6);
		}
    }
}
elseif ($grdRiw1=="true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $sisip = $rows['pasien_id']."|".$rows['idkunj']."|".$rows['kso_id'];
        $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).tglSQL($rows["tgl_pulang"]).chr(3).$rows["tmptlay"].chr(3).$rows["penjamin"].chr(6);
    }
}
elseif($grd3=="true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["kelompok"].chr(3).$rows["tindakan"].chr(3).$rows["nama"].chr(3).number_format($rows["tarip"],0,",",".").chr(6);
    }
}
elseif ($grdRiw2=="true") {
    while ($rows=mysql_fetch_array($rs)) {
        $i++;
        $sisipan = $rows['pasien_id']."|".$rows['kunjungan_id']."|".$rows['pelId']."|".$rows['unit_id']."|".$rows['jenis_layanan']."|".$rows['dilayani']."|".$rows['inap']."|".$rows['pulang']."|".$rows['tgl_pulang'];
        $dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tmptlay"].chr(3).$rows["dokter"].chr(3).$rows["nama"].chr(6);
    }
}
elseif ($grdRiw3=="true") {
    while($rows=mysql_fetch_array($rs)) {
        $i++;
		if($_REQUEST['unit']==58){
		$dt.=$rows["kunjungan_id"]."|".$rows['pelayanan_id']."|".$rows['tindakan_id'].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tind"].chr(3).$rows["kelas"].chr(3).$rows["dokter"].chr(3).$rows["qty"].chr(3).$rows["biaya"].chr(3).$rows["bayar"].chr(3).$rows["status"].chr(3).$rows["no_lab"].chr(6);
		}else{
        $dt.=$rows["kunjungan_id"]."|".$rows['pelayanan_id']."|".$rows['tindakan_id'].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tind"].chr(3).$rows["kelas"].chr(3).$rows["dokter"].chr(3).$rows["qty"].chr(3).$rows["biaya"].chr(3).$rows["bayar"].chr(3).$rows["status"].chr(3).$rows["ket"].chr(6);
		}
    }
}
elseif($grdPel=="true") {
    while($rows=mysql_fetch_array($rs)) {
        $dt.=$rows["id"].chr(3).$rows["nama"].chr(3).$rows["spesialisasi"].chr(3).$rows["alamat"].chr(3).$rows["telp"].chr(6);
    }
}
elseif($grdKmr == 'true'){
    while($rows = mysql_fetch_array($rs)){
		$i++;
        $dt .= $rows['id'].'|'.$rows['unit_id'].'|'.$rows['kelas_id'].chr(3).$i.chr(3).$rows['kamar'].chr(3).$rows['kelas'].chr(3).number_format($rows['tarip'],0,',','.').chr(3).$rows['jumlah_tt'].chr(3).$rows['jumlah_tt_b'].chr(3).$rows['total_tt'].chr(3).$rows['terpakai'].chr(3).$rows['kosong'].chr(6);
    }
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
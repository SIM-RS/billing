<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"]; 
$sorting=$_REQUEST["sorting"];
$saringan='';
$dilayani="";
$no_rm = $_REQUEST['no_rm'];
$filter=$_REQUEST["filter"];
$act = $_GET['act'];
//===============================
$statusProses='';
$msg="";
$grd = strtolower($_REQUEST["grd"]);
$no_bad=$_REQUEST["no_bad"];

switch(strtolower($_REQUEST['act'])) {
    case 'simpan':
        $sqlUpdateUnit = "update b_pelayanan set unit_id='".$_REQUEST['unitBaru']."' where id='".$_REQUEST['id']."'";
        mysql_query($sqlUpdateUnit);
        $sqlUpdateUnit = "update b_tindakan set ms_tindakan_unit_id = '".$_GET['unitBaru']."' where pelayanan_id = '".$_GET['id']."'";
        mysql_query($sqlUpdateUnit);
        $sqlUpdateUnit = "update b_kunjungan set unit_id = '".$_GET['unitBaru']."' where id = '".$_GET['kunjungan_id']."'";
        mysql_query($sqlUpdateUnit);
        $sqlCekUnit = "select id from b_mutasi where pelayanan_id = '".$_GET['id']."' and unit_id = '".$_GET['unitBaru']."'";
        mysql_query($sqlCekUnit);
        if(mysql_affected_rows() == 0) {
            $sqlUpdateUnit = "insert into b_mutasi (pelayanan_id, unit_id, tgl_act, user_act) values ('".$_GET['id']."', '".$_GET['unitLama']."', now(), '".$_GET['userId']."')";
            mysql_query($sqlUpdateUnit);
        }
        break;
	case 'gettglinap':
		$sql="SELECT DATE_FORMAT(tgl,'%d-%m-%Y') tgl FROM b_pelayanan WHERE kunjungan_id='".$_GET['idKunj']."' AND jenis_kunjungan=3 ORDER BY id LIMIT 1";
		$rs=mysql_query($sql);
		$rw=mysql_fetch_array($rs);
		echo $rw['tgl'];
		return;
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    if($_REQUEST['saring']=='true') {
        if($_REQUEST['inap']=='1') {
			if($_REQUEST['dilayani']=='-1'){
				$saringan=" where (k.pulang=1 and date(k.tgl_pulang) = '".tglSQL($_REQUEST['saringan'])."' or (pl.dilayani = 2 and date(pl.tgl_krs)='".tglSQL($_REQUEST['saringan'])."')) and pl.unit_id='".$_REQUEST['tmpLay']."'";
			// or (pl.dilayani=2 and date(tk.tgl_out) = '".tglSQL($_REQUEST['saringan'])."')
			}
			else{
				$saringan=" where k.pulang=0 and pl.unit_id='".$_REQUEST['tmpLay']."'";
				if($_REQUEST['dilayani']=='1') {
					$dilayani=" and pl.dilayani=1 AND tk.tgl_out IS NULL "; //sudah dilayani
				}
				elseif($_REQUEST['dilayani']=='0') {
					$dilayani=" and pl.dilayani=0 AND tk.tgl_out IS NULL "; //belum dilayani
				}
				else {
					$dilayani=" and (pl.dilayani=0 OR pl.dilayani=1) AND tk.tgl_out IS NULL "; //belum+sudah dilayani
				}
	    	}
        }
        else {
            $saringan=" where pl.tgl = '".tglSQL($_REQUEST['saringan'])."' and pl.unit_id='".$_REQUEST['tmpLay']."' ";
            if($_REQUEST['dilayani']=='1') {
                $dilayani=" and pl.dilayani=1 "; //sudah dilayani
            }
            elseif($_REQUEST['dilayani']=='0') {
                $dilayani=" and pl.dilayani=0 "; //belum dilayani
            }
            else {
                $dilayani="";
            }
        }
    }
	
	$penuh=0;
    if($_REQUEST['act']=='update') {
		if($_REQUEST['inap']=='1'){
			if ($_REQUEST["pilihKamar"]!="" && $_REQUEST["pilihKamar"]!="undefined"){
				$kmr="SELECT * FROM b_ms_kamar WHERE id=".$_REQUEST["pilihKamar"];
				$rskmr=mysql_query($kmr);
				$rwkmr=mysql_fetch_array($rskmr);
				$jumlah_tt=$rwkmr["jumlah_tt"]+$rwkmr["jumlah_tt_b"];
				//======cek penghuni kamar=========
				$sql="SELECT COUNT(tk.id) AS jml FROM b_tindakan_kamar tk 
					INNER JOIN b_pelayanan p 
					ON p.id = tk.pelayanan_id 
				    INNER JOIN b_kunjungan k 
					ON k.id = p.kunjungan_id
					WHERE tk.kamar_id=".$_REQUEST["pilihKamar"]." AND tk.aktif=1 AND tk.tgl_out IS NULL AND k.pulang=0 AND p.dilayani=1";
				$rs=mysql_query($sql);
				$rw=mysql_fetch_array($rs);
				$penghuni=$rw["jml"];
				if ($penghuni>=$jumlah_tt){
					$penuh=1;
					$msg="Maaf, Kamar Sudah Penuh, Silahkan Pilih Kamar Yang Lain !";
				}
				if ($_REQUEST["pilihKamar"]==0){
					$penuh=1;
					$msg="Maaf, Tidak Ada Kamar Yang Kosong !";
				}
				//=================================
				if ($penuh==0){
					$aktivasi="update b_tindakan_kamar set aktif=1,no_bed=$no_bad,kamar_id='".$rwkmr['id']."',nama='".$rwkmr['nama']."' where pelayanan_id='".$_REQUEST['pelayanan_id']."' and tgl_out is null";
					mysql_query($aktivasi);
				}
			}else{
				$aktivasi="update b_tindakan_kamar set aktif=1 where pelayanan_id='".$_REQUEST['pelayanan_id']."' and tgl_out is null";
				mysql_query($aktivasi);
			}
		}
		
		if ($penuh==0){
        	$sqlDilayani="update b_pelayanan set dilayani=1 where id='".$_REQUEST['pelayanan_id']."' and dilayani=0";
        	$rsDilayani=mysql_query($sqlDilayani);
		}
    }
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="pl.tgl_act"; //default sort
    }
    
    if($no_rm != ""){
		$filter = " WHERE no_rm = '$no_rm' ";
    }

    if($grd == "true") {
		if($_REQUEST['dokterUnit']=='' || $_REQUEST['dokterUnit']=='0'){
			$fDokterUnit='';	
		}
		else{
			$fDokterUnit='AND pl.dokter_tujuan_id='.$_REQUEST['dokterUnit'];
		}
		
		if ($_REQUEST['inap']=='1'){
			$sql="select distinct * from (SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,mk.nama as kamar,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama,IF(pl.dokter_id=0,'',CONCAT(' Oleh: ',mp.nama)))) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT if(kategori=1,'loket','unit') FROM b_ms_unit WHERE id=pl.unit_id_asal) asalmasuk,pl.dokter_id,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, k.umur_bln, k.umur_hr, pl.unit_id, pl.kelas_id,pl.verifikasi,pl.verifikator, k.tgl,k.pasien_id, m.KEPEMILIKAN_ID,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso
		, inap, penunjang,date_format(k.tgl_sjp,'%d-%m-%Y') as tgl_sjp,k.no_sjp,k.no_anggota,k.status_penj,k.nama_peserta, pl.checkout as sRujuk
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		LEFT JOIN b_ms_pegawai mp ON pl.dokter_id = mp.id
		LEFT JOIN b_ms_pegawai dok ON pl.dokter_tujuan_id = dok.id
		inner join b_ms_unit u on pl.unit_id = u.id INNER JOIN b_tindakan_kamar tk ON pl.id=tk.pelayanan_id 
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN b_ms_kamar mk ON mk.id = tk.kamar_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id ".$saringan." ".$dilayani." ".$fDokterUnit."order by ".$sorting.") as gab ".$filter;
		}else{
			$sql="select distinct * from (SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama,IF(pl.dokter_id=0,'',CONCAT(' Oleh: ',mp.nama)))) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT if(kategori=1,'loket','unit') FROM b_ms_unit WHERE id=pl.unit_id_asal) asalmasuk,pl.dokter_id,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, k.umur_bln, k.umur_hr, pl.unit_id, pl.kelas_id,pl.verifikasi,pl.verifikator, k.tgl,k.pasien_id, m.KEPEMILIKAN_ID,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso
		, inap, penunjang,date_format(k.tgl_sjp,'%d-%m-%Y') as tgl_sjp,k.no_sjp,k.no_anggota,k.status_penj,k.nama_peserta, pl.cito, pl.tgl_keluar, pl.accLab, pl.checkout as sRujuk
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		LEFT JOIN b_ms_pegawai mp ON pl.dokter_id = mp.id
		LEFT JOIN b_ms_pegawai dok ON pl.dokter_tujuan_id = dok.id
		inner join b_ms_unit u on pl.unit_id = u.id
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id ".$saringan." ".$dilayani." ".$fDokterUnit." order by ".$sorting.") as gab ".$filter;
		}
    }
    else if($grd == 'tarik'){
		$sql = "select k.id
		from b_kunjungan k inner join b_ms_pasien p on k.pasien_id = p.id
		where no_rm = '$no_rm' order by k.id desc limit 1";
		$rsk=mysql_query($sql);
		$kfilter="";
		if ($rwk=mysql_fetch_array($rsk)){
			$kfilter=" and k.id=".$rwk['id'];
		}
        /*$sql="SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, (SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, (SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama)) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, pl.unit_id, pl.kelas_id, k.tgl,k.pasien_id,u.penunjang
		,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso, inap,penunjang
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		inner join b_ms_unit u on pl.unit_id = u.id
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		where no_rm = '$no_rm' and k.pulang = 0 order by pl.tgl_act desc";*/
		
        $sql="SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, (SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, (SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama)) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, pl.unit_id, pl.kelas_id, k.tgl,k.pasien_id,u.penunjang
		,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso, inap,penunjang, pl.cito, pl.tgl_keluar, pl.accLab
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		inner join b_ms_unit u on pl.unit_id = u.id
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		where no_rm = '$no_rm'".$kfilter." and (u.id=45 or u.inap=1) order by pl.id desc limit 1";
    }
    
    if($act == 'tarikMang'){
		$rs = mysql_query($sql);
		$res = mysql_num_rows($rs);
		echo $res;
		mysql_free_result($rs);
		mysql_close($konek);
		return;
    }
	
	if($act == 'cmbDokterUnit'){
		if ($_REQUEST['inap']=='1'){
			$sDok="select distinct * from (SELECT dok.id, dok.nama AS nama
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		LEFT JOIN b_ms_pegawai mp ON pl.dokter_id = mp.id
		LEFT JOIN b_ms_pegawai dok ON pl.dokter_tujuan_id = dok.id
		inner join b_ms_unit u on pl.unit_id = u.id INNER JOIN b_tindakan_kamar tk ON pl.id=tk.pelayanan_id 
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN b_ms_kamar mk ON mk.id = tk.kamar_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id ".$saringan." ".$dilayani."order by ".$sorting.") as gab ".$filter;
		}else{
			$sDok="select distinct * from (SELECT dok.id, dok.nama AS nama 
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		LEFT JOIN b_ms_pegawai mp ON pl.dokter_id = mp.id
		LEFT JOIN b_ms_pegawai dok ON pl.dokter_tujuan_id = dok.id
		inner join b_ms_unit u on pl.unit_id = u.id
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id ".$saringan." ".$dilayani." order by ".$sorting.") as gab ".$filter;
		}
		$qDok = mysql_query($sDok);
		$cmbDok='<option value="0">SEMUA</option>';
		while($rwDok = mysql_fetch_array($qDok)){
			$cmbDok.='<option value="'.$rwDok['id'].'">'.$rwDok['nama'].'</option>';
		}
		echo $cmbDok;
		return;
    }
	
    //echo $sql."<br>";
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	
	if ($grd == "true"){
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql;
		$rs=mysql_query($sql);
	}
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
		  /*if($_REQUEST['dilayani']=='-1'){
			 $saringannya=" and date(tk.tgl_out) = '".tglSQL($_REQUEST['saringan'])."' ";
		  }$saringannya */
		  $sqlK = "select tk.kamar_id, mk.nama as nama_kamar, tk.kelas_id as kelas_kamar from 
				b_tindakan_kamar tk inner join b_ms_kamar mk on tk.kamar_id = mk.id
				where tk.pelayanan_id = '".$rows['idp']."' order by tk.id desc limit 1";
		  $rsK = mysql_query($sqlK);
		  $rowK = mysql_fetch_array($rsK);
		  
            $sisip = $rows['id']."|".$rows['idp']."|".$rows['idk']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['umur_thn']." th, ".$rows['umur_bln']." bl, ".$rows['umur_hr']." hr"."|".$rows['kso_id']."|".$rows['kso_kelas_id']."|".$rows['KEPEMILIKAN_ID']."|".$rows['unit']."|".$rows['id_kelas_kunjungan']."|".$rows['dilayani'].'|'.$rows['pelayanan_kelas_id'].'|'.$rows['inap'].'|'.$rows['no_lab'].'|'.$rowK['kamar_id'].'|'.$rowK['nama_kamar'].'|'.$rowK['kelas_kamar'].'|'.$rows['penunjang'].'|'.tglSQL($rows['tgl']).'|'.$rows['no_sjp'].'|'.$rows['no_anggota'].'|'.$rows['status_penj'].'|'.$rows['nama_peserta'].'|'.$rows['verifikasi'].'|'.$rows['verifikator'].'|'.$rows['tgl_keluar'].'|'.$rows['asalmasuk'].'|'.$rows['dokter_id'].'|'.$rows['sRujuk'];
            $i++;
		if ($_REQUEST['inap']=='1' && $_REQUEST['dilayani']=='1'){
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl_act'].chr(3).$rows["ket"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rowK['nama_kamar'].chr(3).$rows["namakso"].chr(3).$rows['asalunit'].chr(3).$rows["alamat"]." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"].chr(3).$rows["tgl_lahir"].chr(3).$rows["nama_ortu"].chr(6);
		}
		else if($_REQUEST['jnsLay'] == '57'){
			if($rows["ket"] == ""){ $ket = "detail"; }
			else{ $ket = $rows["ket"]; }
			$ketSisip = "<a href='javascript:void(0)' onclick=lihatPemeriksaan('".$rows['idp']."'); >".$ket."</a>";
			$asal_baru = $rows['asalunit'];
			$asal_baru = str_replace("Dirujuk", "Dikonsul", $asal_baru);
			if($rows['cito']=='1')
			{
				$no = "<span style='color:#F00'>".number_format($i,0,",","")."</span>";
				$nm = "<span style='color:#F00'>".$rows["nama"]."</span>";
				$rm = "<span style='color:#F00'>".$rows["no_rm"]."</span>";
				$tgl_act = "<span style='color:#F00'>".$rows['tgl_act']."</span>";
				$sex = "<span style='color:#F00'>".$rows['sex']."</span>";
				$namakso = "<span style='color:#F00'>".$rows['namakso']."</span>";
				$asalunit = "<span style='color:#F00'>".$asal_baru."</span>";
				$alamat = "<span style='color:#F00'>".$rows['alamat']." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"]."</span>";
				$tgl_lahir = "<span style='color:#F00'>".$rows['tgl_lahir']."</span>";
				$nama_ortu = "<span style='color:#F00'>".$rows['nama_ortu']."</span>";
				$ketSisip1 = "<span style='color:#F00'>".$ketSisip."</span>";
			}else{
				$color = "style='color:#000'";
				if($rows['accLab'] == 1)
				{
					$color = "style='color:#FF0'";	
				}elseif($rows['accLab'] == 2){
					$color = "style='color:#063'";	
				}elseif($rows['accLab'] == 3){
					$color = "style='color:#00F'";	
				}
				
				$no = "<span $color>".number_format($i,0,",","")."</span>";
				$nm = "<span $color>".$rows["nama"]."</span>";
				$rm = "<span $color>".$rows["no_rm"]."</span>";
				$tgl_act = "<span $color>".$rows['tgl_act']."</span>";
				$sex = "<span $color>".$rows['sex']."</span>";
				$namakso = "<span $color>".$rows['namakso']."</span>";
				$asalunit = "<span $color>".$asal_baru."</span>";
				$alamat = "<span $color>".$rows['alamat']." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"]."</span>";
				$tgl_lahir = "<span $color>".$rows['tgl_lahir']."</span>";
				$nama_ortu = "<span $color>".$rows['nama_ortu']."</span>";
				$ketSisip1 = "<span $color>".$ketSisip."</span>";
				/*$no = number_format($i,0,",","");
				$nm = $rows["nama"];
				$rm = $rows["no_rm"];
				$tgl_act = $rows['tgl_act'];
				$sex = $rows['sex'];
				$namakso = $rows['namakso'];
				$asalunit = $rows['asalunit'];
				$alamat = $rows['alamat']." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"];
				$tgl_lahir = $rows['tgl_lahir'];
				$nama_ortu = $rows['nama_ortu'];
				$ketSisip1 = $ketSisip;*/
			}
			$dt.=$sisip.chr(3).$no.chr(3).$tgl_act.chr(3).$ketSisip1.chr(3).$rm.chr(3).$nm.chr(3).$sex.chr(3).$namakso.chr(3).$asalunit.chr(3).$alamat.chr(3).$tgl_lahir.chr(3).$nama_ortu.chr(6);
		}else if($_REQUEST['jnsLay'] == '60'){
			if($rows["ket"] == ""){ $ket = "detail"; }
			else{ $ket = $rows["ket"]; }
			$ketSisip = "<a href='javascript:void(0)' onclick=lihatPemeriksaan('".$rows['idp']."'); >".$ket."</a>";
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl_act'].chr(3).$ketSisip.chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rows["namakso"].chr(3).$rows['asalunit'].chr(3).$rows["alamat"]." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"].chr(3).$rows["tgl_lahir"].chr(3).$rows["nama_ortu"].chr(6);
		}else{			
			 $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl_act'].chr(3).$rows["ket"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rows["namakso"].chr(3).$rows['asalunit'].chr(3).$rows["alamat"]." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"].chr(3).$rows["tgl_lahir"].chr(3).$rows["nama_ortu"].chr(6);
		}
            //(($rows["asalunit"]!='')?"Rujuk dari: ".$rows["asalunit"]:"Loket")tglJamSQL($rows["tgl_act"])
        }
    }
    else if($grd == "tarik"){
        while ($rows=mysql_fetch_array($rs)) {
		  $sqlK = "select tk.kamar_id,tgl_out from 
				b_tindakan_kamar tk
				where tk.pelayanan_id = '".$rows['idp']."' order by tk.id desc limit 1";
		  $rsK = mysql_query($sqlK);
		  $rowK = mysql_fetch_array($rsK);
            $sisip = $rows['id']."|".$rows['idp']."|".$rows['idk']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['umur_thn']."|".$rows['kso_id']."|".$rows['kso_kelas_id']."|".$rows['KEPEMILIKAN_ID']."|".$rows['unit']."|".$rows['id_kelas_kunjungan']."|".$rows['dilayani'].'|'.$rows['pelayanan_kelas_id'].'|'.$rows['inap'].'|'.$rows['no_lab'].'|'.$rowK['kamar_id'].'|'.$rows['penunjang'].'|'.$rows['tgl_keluar'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl_act'].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rows["namakso"].chr(3).$rows['asalunit'].chr(3).$rows['unit'].chr(6);
            //(($rows["asalunit"]!='')?"Rujuk dari: ".$rows["asalunit"]:"Loket")tglJamSQL($rows["tgl_act"])
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$msg;
        $dt=str_replace('"','\"',$dt);
    }
    mysql_free_result($rs);
}
//echo $sql;
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
<?php
include("../koneksi/konek.php");
//====================================================================
$dilayani = $_REQUEST['dilayani'];
$no_rm = $_REQUEST['no_rm'];
$pasien_id = $_REQUEST['pasien_id'];
$tgl = tglSQL($_REQUEST['tgl']);
$tmpLay = $_REQUEST['tmpLay'];
$grd = strtolower($_REQUEST["grd"]);
$kunjungan_id=$_REQUEST['kunjungan_id'];
$status_medik=$_REQUEST['status_medik'];
//=======Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$act = $_GET['act'];
$fdata = $_REQUEST['fdata'];
$userId=$_REQUEST['userId'];
$statusKeluar=$_REQUEST['statusKeluar'];
$jnsLayanan = $tmpLayanan = $dokterId = '';
$pengganti = '';
//echo $_REQUEST['dokterL'];
if($statusKeluar != 3){
	$jnsLayanan=$_REQUEST['jnsLayanan'];
	$tmpLayanan=$_REQUEST['tmpLayanan'];
	if($_REQUEST['dokcek']=='true'){
		$dokterId=$_REQUEST['dokterId'];
		$pengganti=$_REQUEST['pengganti'];
	}
}

if($statusKeluar == 1){
	$dokterId = $pengganti = '';
}
//===============================
$statusProses='';
$msg="";

switch(strtolower($_REQUEST['act'])) {
	case 'save':
		//if($statusKeluar=='1' || $statusKeluar=='2')
		$sIns="insert into b_status_medik (kunjungan_id,pasien_id,tgl_act,user_act,status,jnsLayanan,tmpLayanan,sm_dokter,sm_dokter_pengganti) values ('".$kunjungan_id."','".$pasien_id."',now(),'".$userId."','".$statusKeluar."','{$jnsLayanan}','{$tmpLayanan}','{$dokterId}','{$pengganti}')";
		$qIns=mysql_query($sIns);
		
		if(mysql_affected_rows()){
			$sSave="update b_ms_pasien set 
						status_medik='".$statusKeluar."'
					where id='".$pasien_id."'";
			mysql_query($sSave);
		}
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {	
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
	
    if ($sorting=="") {
        $sorting="id"; //default sort
    }
    
    if($no_rm != ""){
		$filter = " AND no_rm = '$no_rm' ";
    }

    if($grd == "true") {
		$sql="SELECT * FROM (SELECT DISTINCT * 
			FROM 
			(SELECT 
			k.id,
			p.id AS pasien_id,
			p.no_rm, 
			p.nama, 
			p.sex, 
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir, 
			p.nama_ortu, 
			p.alamat,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			(SELECT nama FROM b_ms_unit WHERE id=k.unit_id) unit,
			p.status_medik,
			IF((SELECT b_kunjungan.id
			FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
			WHERE b_kunjungan.pulang=0 AND b_tindakan_kamar.tgl_out IS NULL AND b_kunjungan.id=k.id LIMIT 1) IS NULL,'1','0') AS aktif
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id 
			WHERE k.tgl = '".tglSQL($_REQUEST['tgl'])."' ORDER BY k.id) AS gab
			UNION
			SELECT DISTINCT * 
			FROM 
			(SELECT 
			k.id,
			p.id AS pasien_id,
			p.no_rm, 
			p.nama, 
			p.sex, 
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir, 
			p.nama_ortu, 
			p.alamat,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,
			p.status_medik,
			'1' AS aktif
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
			INNER JOIN b_tindakan_kamar tk ON pl.id=tk.pelayanan_id
			INNER JOIN b_ms_unit u ON pl.unit_id = u.id
			LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id 
			WHERE k.pulang=0 AND tk.tgl_out IS NULL ORDER BY id) AS gab
			UNION
			SELECT 
			0 AS id,
			p.id AS pasien_id,
			p.no_rm, 
			p.nama, 
			p.sex, 
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir, 
			p.nama_ortu, 
			p.alamat,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			'' AS unit,
			p.status_medik,
			IF((SELECT b_kunjungan.id
			FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
			LEFT JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
			WHERE (b_kunjungan.tgl='".tglSQL($_REQUEST['tgl'])."') OR (b_kunjungan.pulang=0 AND b_tindakan_kamar.tgl_out IS NULL) AND b_kunjungan.pasien_id=p.id LIMIT 1) IS NULL,'1','0') AS aktif
			FROM b_ms_pasien p 
			WHERE p.status_medik IN (1,2)
			) AS tbl WHERE aktif=1 ".$filter." order by ".$sorting;
	}
	
	//echo $sql."<br>";
    $rs=mysql_query($sql);
	$jmldata=mysql_num_rows($rs);
	
	if($jmldata==0 && $no_rm != ""){
		$sql="SELECT 
				0 AS id,
				p.id AS pasien_id,
				p.no_rm, 
				p.nama, 
				p.sex, 
				DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir, 
				p.nama_ortu, 
				p.alamat,
				(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
				(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
				p.status_medik
				FROM b_ms_pasien p 
				WHERE p.no_rm = '".$no_rm."'";
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
	}
	
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	
	$sql=$sql." limit $tpage,$perpage";
	$rs=mysql_query($sql);
	
		
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
			if($rows['status_medik']=='0'){ //normal
				$warna="#000";
			}
			else if($rows['status_medik']=='1'){ //hijau keluar
				$warna="#00FF00";
			}
			else if($rows['status_medik']=='2'){ //biru pinjam
				$warna="#00F";
			}
			else if($rows['status_medik']=='3'){ //kuning masuk
				$warna="#963";
			}
			$tempat='';
			if($rows['jnsLay']!='' && $rows['tmpLay']!=''){
				$tempat = $rows["jnsLay"]." (".$rows['tmpLay'].")";
			}
			
			$sJns="SELECT mu.nama
					FROM (SELECT * FROM b_status_medik WHERE pasien_id='".$rows["pasien_id"]."' ORDER BY id DESC LIMIT 1) sm
					INNER JOIN b_ms_unit mu ON sm.jnsLayanan=mu.id";
			$qJns=mysql_query($sJns);
			$rwJns=mysql_fetch_array($qJns);
			
			$sTmp="SELECT CONCAT('(',mu.nama,')') AS nama
					FROM (SELECT * FROM b_status_medik WHERE pasien_id='".$rows["pasien_id"]."' ORDER BY id DESC LIMIT 1) sm
					INNER JOIN b_ms_unit mu ON sm.tmpLayanan=mu.id";
			$qTmp=mysql_query($sTmp);
			$rwTmp=mysql_fetch_array($qTmp);
			
			$sDok="SELECT pg.nama
					FROM (SELECT * FROM b_status_medik WHERE pasien_id='".$rows["pasien_id"]."' ORDER BY id DESC LIMIT 1) sm
					INNER JOIN b_ms_pegawai pg ON pg.id=sm.sm_dokter";
			$qDok=mysql_query($sDok);
			$rwDok=mysql_fetch_array($qDok);
			
			$tempat = $rwJns["nama"]." ".$rwTmp['nama']."";
			$dokter = $rwDok["nama"];
			
			$sisip=$rows["id"]."|".$rows['status_medik']."|".$rows['pasien_id'];
            $dt.=$sisip.chr(3)."<font color='$warna'>".number_format($i,0,",","")."</font>".chr(3)."<font color='$warna' style='font-weight:bold'>".$rows["no_rm"]."</font>".chr(3)."<font color='$warna' style='font-weight:bold'>".$rows["nama"]."</font>".chr(3)."<font color='$warna'>".$rows["sex"]."</font>".chr(3)."<font color='$warna'>".$rows["namakso"]."</font>".chr(3)."<font color='$warna'>".$rows["alamat"]."</font>".chr(3)."<font color='$warna'>".$rows["tgl_lahir"]."</font>".chr(3)."<font color='$warna'>".$rows["nama_ortu"]."</font>".chr(3)."<font color='$warna'>".$tempat."</font>".chr(3)."<font color='$warna'>".$dokter."</font>".chr(6);
        }
    }
  
    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
	else{
		$dt="0".chr(5).chr(5).$_REQUEST['act'];
	}
	
    mysql_free_result($rs);
}
mysql_close();
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>

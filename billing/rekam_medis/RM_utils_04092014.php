<?php
include("../koneksi/konek.php");
include("classRM.php");
//====================================================================
$dilayani = $_REQUEST['dilayani'];
$no_rm = $_REQUEST['no_rm'];
$tgl = tglSQL($_REQUEST['tgl']);
$cmbKunjungan = $_REQUEST['cmbKunjungan'];
$tmpLay = $_REQUEST['tmpLay'];
$grd = strtolower($_REQUEST["grd"]);
$grd2 = strtolower($_REQUEST["grd2"]);
$grd3 = strtolower($_REQUEST["grd3"]);
$grd4 = strtolower($_REQUEST["grd4"]);
$grdH = strtolower($_REQUEST["grdH"]);
$kunjungan_id=$_REQUEST['kunjungan_id'];
$status_medik=$_REQUEST['status_medik'];
//=======Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$act = $_GET['act'];
$fdata = $_REQUEST['fdata'];
$user_act=$_REQUEST['userId'];
$statusKeluar=$_REQUEST['statusKeluar'];
$baris=$_REQUEST['baris'];
//===============================
$statusProses='';
$msg="";

switch(strtolower($_REQUEST['act'])) {
	case 'getresumemedis':
		$sRes="select distinct jenis_kunjungan from b_pelayanan where kunjungan_id='".$_REQUEST['kunjungan_id']."' order by jenis_kunjungan";
		$qRes=mysql_query($sRes);
		if(mysql_num_rows($qRes)>0){
			while($rwRes=mysql_fetch_array($qRes)){
			?>
            	<option value="<?php echo $rwRes['jenis_kunjungan']; ?>"><?php if($rwRes['jenis_kunjungan']=='3'){ echo "RAWAT INAP"; } else if($rwRes['jenis_kunjungan']=='2'){ echo "IGD"; } else { echo "RAWAT JALAN"; }  ?></option>
            <?php
			}
		}
		else{
			?>
            	<option value="">-</option>
            <?php	
		}
		return;
	break;
	case 'save':
		$sSave="update b_kunjungan set status_medik='".$statusKeluar."' where id='".$kunjungan_id."'";
		mysql_query($sSave);
		//echo $sSave."<br>";
	break;
	case 'tambah':
	    $sqlCek = "select * from b_ms_menu_report_rm_ceklist where report_rm_id='".$_REQUEST['id']."' and pelayanan_id='".$_REQUEST['pelayanan_id']."'";
	    $rsCek = mysql_query($sqlCek);
	    if(mysql_num_rows($rsCek)==0)
	    {
		  $sqlTambah = "INSERT INTO b_ms_menu_report_rm_ceklist (pelayanan_id,report_rm_id,tgl_act,user_act) values('".$_REQUEST['pelayanan_id']."','".$_REQUEST['id']."',now(),'$user_act')";
		  $rs=mysql_query($sqlTambah);
		  $res = mysql_affected_rows();
	    }
		
		$sel="select * from b_ms_menu_report_rm_ceklist where report_rm_id='".$_REQUEST['id']."' and pelayanan_id='".$_REQUEST['pelayanan_id']."'";
		$kur=mysql_query($sel);
		$rw=mysql_fetch_array($kur);
		$ceklist_id=$rw['id'];
		
	  echo $res."|".$_REQUEST['baris']."|".$_REQUEST['act']."|".$ceklist_id;
	  return;
      break;   
     case 'hapus':
      $sqlHapus="delete from b_ms_menu_report_rm_ceklist where pelayanan_id='".$_REQUEST['pelayanan_id']."' and report_rm_id = '".$_REQUEST['id']."'";
      $rs=mysql_query($sqlHapus);
      $res = mysql_affected_rows();
	  echo $res."|".$_REQUEST['baris']."|".$_REQUEST['act'];
	  return;
      break;
	 case 'tambah_analisa':
	  $sqlTambah = "UPDATE b_ms_menu_report_rm_ceklist SET analisa=1, analisa_tgl=now(), analisa_user='$user_act' WHERE id='".$_REQUEST['id']."'";
	  $rs=mysql_query($sqlTambah);
	  $res = mysql_affected_rows();
	  echo $res."|".$_REQUEST['baris']."|".$_REQUEST['act'];
	  return;
      break;   
     case 'hapus_analisa':
      $sqlHapus = "UPDATE b_ms_menu_report_rm_ceklist SET analisa=0, analisa_tgl=now(), analisa_user='$user_act' WHERE id='".$_REQUEST['id']."'";
      $rs=mysql_query($sqlHapus);
      $res = mysql_affected_rows();
      echo $res."|".$_REQUEST['baris']."|".$_REQUEST['act'];
	  return;
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
		if($cmbKunjungan=='0'){
			$sql="SELECT * FROM (SELECT 
			* 
			FROM 
			(SELECT
			k.id,
			p.id as pasien_id, 
			DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
			p.no_rm,
			IF(t2.tPrint IS NOT NULL,CONCAT(p.nama,' (',t2.tPrint,')'),CONCAT(p.nama,'(0)')) AS nama,
			kso.nama AS penjamin,
			p.alamat,
			p.status_medik,
			IF((SELECT b_kunjungan.id
			FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
			WHERE b_pelayanan.jenis_kunjungan=3 AND b_kunjungan.id=k.id LIMIT 1) IS NULL,'1','0') AS aktif,
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
			CONCAT(k.umur_thn,' Th,',k.umur_thn,' bln,',k.umur_hr,' hr') AS umur,
			p.nama_ortu,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			p.sex,
			k.unit_id
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id 
			LEFT JOIN (SELECT id_kunjungan, SUM(jml) AS tPrint FROM b_print_res_rm GROUP BY id_kunjungan) AS t2 ON t2.id_kunjungan = k.id
			WHERE k.tgl = '".tglSQL($_REQUEST['tgl'])."') AS gab
			) AS tbl WHERE aktif=1  
			".$filter." order by ".$sorting;
		}
		else{
			$sql="SELECT * FROM (SELECT 
			* 
			FROM 
			(SELECT
			k.id,
			p.id as pasien_id, 
			DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
			p.no_rm,
			IF(t2.tPrint IS NOT NULL,CONCAT(p.nama,' (',t2.tPrint,')'),CONCAT(p.nama,'(0)')) AS nama,
			kso.nama AS penjamin,
			p.alamat,
			p.status_medik,
			'1' AS aktif,
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
			CONCAT(k.umur_thn,' Th,',k.umur_thn,' bln,',k.umur_hr,' hr') AS umur,
			p.nama_ortu,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			p.sex,
			k.unit_id 
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
			INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = pl.id
			LEFT JOIN (SELECT id_kunjungan, SUM(jml) AS tPrint FROM b_print_res_rm GROUP BY id_kunjungan) AS t2 ON t2.id_kunjungan = k.id 
			WHERE k.pulang=0 AND tk.tgl_out IS NULL) AS gab ) AS tbl WHERE aktif=1  
			".$filter." order by ".$sorting;
		}
		
		/*
		$sql="SELECT * FROM (SELECT 
			* 
			FROM 
			(SELECT
			k.id,
			p.id as pasien_id, 
			DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
			p.no_rm,
			p.nama,
			kso.nama AS penjamin,
			p.alamat,
			p.status_medik,
			IF((SELECT b_kunjungan.id
			FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
			WHERE b_kunjungan.pulang=0 AND b_tindakan_kamar.tgl_out IS NULL AND b_kunjungan.id=k.id LIMIT 1) IS NULL,'1','0') AS aktif,
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
			CONCAT(k.umur_thn,' Th,',k.umur_thn,' bln,',k.umur_hr,' hr') AS umur,
			p.nama_ortu,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			p.sex
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id 
			WHERE k.tgl = '".tglSQL($_REQUEST['tgl'])."') AS gab
			UNION
			SELECT 
			* 
			FROM 
			(SELECT
			k.id,
			p.id as pasien_id, 
			DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
			p.no_rm,
			p.nama,
			kso.nama AS penjamin,
			p.alamat,
			p.status_medik,
			'1' AS aktif,
			DATE_FORMAT(p.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
			CONCAT(k.umur_thn,' Th,',k.umur_thn,' bln,',k.umur_hr,' hr') AS umur,
			p.nama_ortu,
			(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
			(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
			p.sex 
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
			INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = pl.id 
			WHERE k.pulang=0 AND tk.tgl_out IS NULL) AS gab ) AS tbl WHERE aktif=1  
			".$filter." order by ".$sorting;
			*/
	}
	else if($grdH == "true"){
		$sql="SELECT
			k.id,
			p.id as pasien_id, 
			DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
			p.no_rm,
			p.nama,
			kso.nama AS penjamin,
			p.alamat,
			p.status_medik,
			k.unit_id
			FROM b_ms_pasien p 
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			WHERE p.no_rm='".$no_rm."' ORDER BY k.id DESC";	
	}
	else if($grd4 == "true"){
		$sql="SELECT
			pl.id, 
			DATE_FORMAT(pl.tgl,'%d-%m-%Y') AS tgl,
			mu.id AS unit_id,
			pl.jenis_layanan,
			mu.nama AS unit,
			pg.nama AS dokter,
			ma.nama AS asal,
			pl.batal
			FROM b_pelayanan pl
			INNER JOIN b_ms_unit mu ON mu.id=pl.unit_id
			INNER JOIN b_ms_unit ma ON ma.id=pl.unit_id_asal
			LEFT JOIN b_ms_pegawai pg ON pg.id=pl.dokter_tujuan_id
			WHERE pl.kunjungan_id='".$_REQUEST['kunjungan_id']."' AND pl.batal = 0";	
	}
	else if($grd2 == "true"){
		if($_REQUEST['pelayanan_id']==0){
			$fzxc="AND 0=1";
		}
		$sql="SELECT * 
				FROM b_ms_menu_report_rm
				WHERE LEVEL=1 $fzxc ORDER BY id";	
	}
	else if($grd3 == "true"){
		$sql="SELECT
				u.id, 
				u.nama,
				u.nomor_dokumen, 
				IF( t1.id IS NULL , 0, 1 ) AS pil,
				t1.id AS ceklist_id,
				IFNULL(t1.analisa,0) AS analisa		 
				FROM b_ms_menu_report_rm u
				LEFT JOIN (
				SELECT *
				FROM b_ms_menu_report_rm_ceklist
				WHERE pelayanan_id ='".$_REQUEST['pelayanan_id']."'
				) AS t1 ON u.id = t1.report_rm_id
				WHERE LEVEL=2 AND parent_id='".$_REQUEST['parent_id']."' ORDER BY nomor_dokumen,nama";	
		//echo $sql."<br>";
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
	$rs=mysql_query($sql);
	
		
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
			/*if($rows['status_medik']=='0'){ //normal
				$warna="#000";
			}
			else if($rows['status_medik']=='1'){ //hijau
				$warna="#00FF00";
			}
			else if($rows['status_medik']=='2'){ //biru
				$warna="#00F";
			}
			else if($rows['status_medik']=='3'){ //kuning
				$warna="#FF0";
			}
			$warna="#000";*/
			
			$cek = new rekam_medis($rows['id'],NULL);
			$warna = $cek->setKunj2();
			$anam = $cek->setAnam($rows['pasien_id']);
			$anamnesa = '';
			if($anam > 0){
				$anamnesa = "({$anam})";
			}
			//echo $cek->setKunj();
			
			$sisip=
			$rows["id"]."|".
			$rows['status_medik']."|".
			$rows["no_rm"]."|".
			$rows['pasien_id']."|".
			$rows["alamat"]." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"]."|".
			$rows["umur"]."|".
			$rows["nama_ortu"]."|".
			$rows["nama"]."|".
			$rows["tgl_lahir"]."|".
			$rows["sex"]."|".
			$rows["unit_id"]."|".
			$cmbKunjungan;
			
            $dt.=$sisip.chr(3)."<font color='$warna'>".number_format($i,0,",","")."</font>".chr(3)."<font color='$warna'>".$rows["tgl"]."</font>".chr(3)."<font color='$warna'>".$rows["no_rm"]."</font>".chr(3)."<font color='$warna'>".$rows["nama"]." {$anamnesa}</font>".chr(3)."<font color='$warna'>".$rows["penjamin"]."</font>".chr(3)."<font color='$warna'>".$rows['alamat']."</font>".chr(6);
        }
    }
	else if($grdH == "true") {
		while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
			$v_inap=0;
			$sCekInap="select id from b_pelayanan where jenis_kunjungan=3 and kunjungan_id='".$rows["id"]."' limit 1";
			$qCekInap=mysql_query($sCekInap);
			if(mysql_num_rows($qCekInap)>0){
				$v_inap=1;	
			}
			
			$sisip=$rows["id"]."|".
			$rows['status_medik']."|".
			$rows["no_rm"]."|".
			$rows['pasien_id']."|".
			$rows["alamat"]." Desa ".$rows["desa"]." Kec. ".$rows["kec"]." Kab. ".$rows["kab"]."|".
			$rows["umur"]."|".
			$rows["nama_ortu"]."|".
			$rows["nama"]."|".
			$rows["tgl_lahir"]."|".
			$rows["sex"]."|".
			$rows["unit_id"]."|".
			$v_inap;
			
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["penjamin"].chr(3).$rows['alamat'].chr(6);
        }
	}
	else if($grd4 == "true") {
		while ($rows=mysql_fetch_array($rs)) {
			$check = new rekam_medis($_REQUEST['kunjungan_id'],$rows["id"]);
			//echo $check->cekdiagnosa();
			$css = "style='color:".$check->setWarna()."'";
			
            $i++;
			$icd="<img src='../icon/edit_find.png' width='24' height='24' title='Klik untuk menginput kode ICD' style='cursor:pointer;' onclick='detail($i);' />";
			
			//$jmlh=1;
			$jmlh=mysql_num_rows(mysql_query("SELECT 
  * 
FROM
  (SELECT 
    d.diagnosa_id AS id 
  FROM b_diagnosa d 
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
INNER JOIN b_ms_pegawai p ON p.id = d.user_id
INNER JOIN b_ms_unit mu ON pl.unit_id = mu.id
WHERE d.kunjungan_id = '".$_REQUEST['kunjungan_id']."') AS gab"));
			$sisip=$rows["id"]."|".$rows["unit_id"]."|".$rows['jenis_layanan']."|".$rows['batal']."|".$rows["unit"]."|".$jmlh;
			
			$sD1="select * from b_diagnosa where pelayanan_id='".$rows["id"]."'";
			$qD1=mysql_query($sD1);
			$nD1=mysql_num_rows($qD1);
			
			$sD2="SELECT
			*
			FROM b_diagnosa d 
			INNER JOIN b_diagnosa_rm drm ON drm.diagnosa_id=d.diagnosa_id
			WHERE d.pelayanan_id = '".$rows["id"]."'";
			$qD2=mysql_query($sD2);
			$nD2=mysql_num_rows($qD2);
			
			$sT1="select * from b_tindakan where pelayanan_id='".$rows["id"]."'";
			$qT1=mysql_query($sT1);
			$nT1=mysql_num_rows($qT1);
			
			$sT2="SELECT
			*
			FROM b_tindakan t 
			INNER JOIN b_tindakan_icd9cm t9 ON t9.b_tindakan_id=t.id
			WHERE t.pelayanan_id = '".$rows["id"]."'";
			$qT2=mysql_query($sT2);
			$nT2=mysql_num_rows($qT2);
			
			$stsKoding="";
			if($nD2!=0){
				$stsKoding="SUDAH";
			}
			else{
				$stsKoding="BELUM";
			}
			
        	$dt.=$sisip.chr(3)."<span $css>".number_format($i,0,",","")."</span>".chr(3)."<span $css>".$rows["tgl"]."</span>".chr(3)."<span $css>".$rows["unit"]."</span>".chr(3)."<span $css>".$rows["dokter"]."</span>".chr(3)."<span $css>".$rows["asal"]."</span>".chr(3)."<span $css>".$stsKoding."</span>".chr(6);
		}	
	}
	else if($grd2 == "true") {
		while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$sisip=$rows["id"];
        	$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(6);
		}
	}
	else if($grd3 == "true") {
		while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$sisip=$rows["id"]."|".$rows["pil"]."|".$rows["analisa"]."|".$rows["ceklist_id"];
        	$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["pil"].chr(3).$rows["analisa"].chr(3).$rows["nomor_dokumen"].chr(3).$rows["nama"].chr(6);
		}
	}
  
    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."|".$baris;
        $dt=str_replace('"','\"',$dt);
    }
	else{
		$dt="0".chr(5).chr(5).$_REQUEST['act']."|".$baris;
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
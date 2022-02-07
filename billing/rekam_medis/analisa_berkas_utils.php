<?php
include("../koneksi/konek.php");
//====================================================================
$dilayani = $_REQUEST['dilayani'];
$no_rm = $_REQUEST['no_rm'];
$tgl = tglSQL($_REQUEST['tgl']);
$tmpLay = $_REQUEST['tmpLay'];
$grd = strtolower($_REQUEST["grd"]);
$grd2 = strtolower($_REQUEST["grd2"]);
$grd3 = strtolower($_REQUEST["grd3"]);
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
//===============================
$statusProses='';
$msg="";

switch(strtolower($_REQUEST['act'])) {
	case 'save':
		if($status_medik==0 || $status_medik==3){
			if($statusKeluar==1){
				$sSave="update b_kunjungan set status_medik='1' where id='".$kunjungan_id."'";
				mysql_query($sSave);		
			}
			else if($statusKeluar==2){
				$sSave="update b_kunjungan set status_medik='2' where id='".$kunjungan_id."'";
				mysql_query($sSave);
			}
				
		}
		else if($status_medik==1 || $status_medik==2){
			$sSave="update b_kunjungan set status_medik='3' where id='".$kunjungan_id."'";
			mysql_query($sSave);
		}
		//echo $sSave."<br>";
	break;
	case 'tambah':
	    $sqlCek = "select * from b_ms_menu_report_rm_analisa where ceklist_report_rm_id='".$_REQUEST['id']."' and pelayanan_id='".$_REQUEST['pelayanan_id']."'";
	    $rsCek = mysql_query($sqlCek);
	    if(mysql_num_rows($rsCek)==0)
	    {
		  $sqlTambah = "INSERT INTO b_ms_menu_report_rm_analisa (pelayanan_id,ceklist_report_rm_id,tgl_act,user_act) values('".$_REQUEST['pelayanan_id']."','".$_REQUEST['id']."',now(),'$user_act')";
		  $rs=mysql_query($sqlTambah);
		  $res = mysql_affected_rows();
	    }
      break;   
     case 'hapus':
      $sqlHapus="delete from b_ms_menu_report_rm_analisa where pelayanan_id='".$_REQUEST['pelayanan_id']."' and ceklist_report_rm_id = '".$_REQUEST['id']."'";
      $rs=mysql_query($sqlHapus);
      $res = mysql_affected_rows();
      break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {	
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
	
    if ($sorting=="") {
        $sorting="id"; //default sort
    }
    
    if($no_rm != ""){
		$filter = " where no_rm = '$no_rm' ";
    }

    if($grd == "true") {
		if ($_REQUEST['tmpLay']=='1'){
			$sql="select distinct * from (SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,mk.nama as kamar,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama)) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, pl.unit_id, pl.kelas_id,pl.verifikasi,pl.verifikator, k.tgl,k.pasien_id, m.KEPEMILIKAN_ID,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso
		, inap, penunjang,date_format(k.tgl_sjp,'%d-%m-%Y') as tgl_sjp,k.no_sjp,k.no_anggota,k.status_penj,k.nama_peserta,
		k.status_medik,
		pl.kunjungan_id
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		inner join b_ms_unit u on pl.unit_id = u.id 
		INNER JOIN b_tindakan_kamar tk ON pl.id=tk.pelayanan_id 
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN b_ms_kamar mk ON mk.id = tk.kamar_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id 
		WHERE k.pulang=0 AND tk.tgl_out IS NULL) as gab ".$filter." order by ".$sorting;
		}else{
			$sql="select distinct * from (SELECT p.id, pl.id AS idp, pl.kelas_id as pelayanan_kelas_id, k.id AS idk,k.kso_id,k.kso_kelas_id,k.kelas_id as id_kelas_kunjungan, p.no_rm, p.nama, p.sex, date_format(p.tgl_lahir,'%d-%m-%Y') as tgl_lahir, p.nama_ortu, p.alamat, pl.no_lab,
		(SELECT nama FROM b_ms_wilayah WHERE id=p.desa_id) desa, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kec_id) kec, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.kab_id) kab, 
		(SELECT nama FROM b_ms_wilayah WHERE id=p.prop_id) prop,
		(SELECT if(kategori=1,nama,concat('Dirujuk dari: ',nama)) FROM b_ms_unit WHERE id=pl.unit_id_asal) asalunit,
		(SELECT nama FROM b_ms_unit WHERE id=pl.unit_id) unit,pl.ket,
		k.umur_thn, pl.unit_id, pl.kelas_id,pl.verifikasi,pl.verifikator, k.tgl,k.pasien_id, m.KEPEMILIKAN_ID,date_format(pl.tgl_act,'%d-%m-%Y %H:%i') as tgl_act,pl.dilayani,ifnull(kso.nama,'UMUM') as namakso
		, inap, penunjang,date_format(k.tgl_sjp,'%d-%m-%Y') as tgl_sjp,k.no_sjp,k.no_anggota,k.status_penj,k.nama_peserta,
		k.status_medik,
		pl.kunjungan_id
		FROM b_ms_pasien p 
		INNER JOIN b_kunjungan k ON k.pasien_id = p.id
		INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
		inner join b_ms_unit u on pl.unit_id = u.id
		LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
		LEFT JOIN $dbapotek.a_mitra m ON m.kso_id_billing = kso.id 
		WHERE pl.tgl = '".tglSQL($_REQUEST['tgl'])."') as gab ".$filter." order by ".$sorting;
		}
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
IF( t1.id IS NULL , 0, 1 ) AS pil		 
FROM b_ms_menu_report_rm u
INNER JOIN b_ms_menu_report_rm_ceklist c
ON c.report_rm_id=u.id
LEFT JOIN (
SELECT *
FROM b_ms_menu_report_rm_analisa
WHERE pelayanan_id ='".$_REQUEST['pelayanan_id']."'
) AS t1 ON u.id = t1.ceklist_report_rm_id
WHERE LEVEL=2 AND parent_id='".$_REQUEST['parent_id']."' ORDER BY nomor_dokumen,nama";	
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
			
			if($rows['status_medik']=='0'){ //normal
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
			
			$sisip=$rows["kunjungan_id"]."|".$rows['status_medik']."|".$rows['idp'];
            $dt.=$sisip.chr(3)."<font color='$warna'>".number_format($i,0,",","")."</font>".chr(3)."<font color='$warna'>".$rows["no_rm"]."</font>".chr(3)."<font color='$warna'>".$rows["nama"]."</font>".chr(3)."<font color='$warna'>".$rows["sex"]."</font>".chr(3)."<font color='$warna'>".$rows["namakso"]."</font>".chr(3)."<font color='$warna'>".$rows['no_sjp']."</font>".chr(3)."<font color='$warna'>".$rows['unit']."</font>".chr(3)."<font color='$warna'>".$rows["alamat"]."</font>".chr(3)."<font color='$warna'>".$rows["tgl_lahir"]."</font>".chr(3)."<font color='$warna'>".$rows["nama_ortu"]."</font>".chr(6);
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
			$sisip=$rows["id"];
        	$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["pil"].chr(3).$rows["nomor_dokumen"].chr(3).$rows["nama"].chr(6);
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

<?php
include("../../koneksi/konek.php");
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$grd3 = $_REQUEST["grd3"];
$userId=$_REQUEST['userId'];
$msg = "";
/* ================================= */
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
        switch($_REQUEST["smpn"]){
            case 'btnSimpanRujukRS':
				/*-----Rujuk RS-----*/
				$unitIdKontrol=$_REQUEST['unitIdKontrol'];
				$tgl_kontrol=$_REQUEST['tgl_kontrol'];
				if ($tgl_kontrol!="NULL"){
					$tgl_kontrol=tglSQL($tgl_kontrol);
				}
                $sqlCek = "select id from b_pasien_keluar where pelayanan_id='$pelayanan_id'";
                $rs = mysql_query($sqlCek);
                if(mysql_num_rows($rs) <= 0) {
					/*
					if($_REQUEST['isManual']=="true") {
						$tgljam=" '".tglSQL($_REQUEST['tglKrs'])." ".$_REQUEST['jamKrs']."' ";
					}
					else {
						$tgljam=' now() ';
					}
					*/
                    $sqlTambah="insert into b_pasien_keluar (kunjungan_id,pelayanan_id,cara_keluar,keadaan_keluar,kasus,emergency,kondisi,rs_id,ket,dokter_id,tgl_kontrol,unit_id_kontrol,tgl_act,user_act)
                                    values('".$kunjungan_id."','".$pelayanan_id."','".$_REQUEST['caraKeluar']."','".$_REQUEST['keadaanKeluar']."','".$_REQUEST['kasus']."','".$_REQUEST['emergency']."','".$_REQUEST['kondisi']."','".$_REQUEST['idRS']."','".$_REQUEST['ket']."','".$_REQUEST['idDok']."','$tgl_kontrol','$unitIdKontrol',NOW(),$userId)";
                    //echo $sqlTambah."<br/>";
                    $rs=mysql_query($sqlTambah);
		    
					/*$sqlCek = "SELECT inap FROM b_pelayanan p INNER JOIN b_ms_unit u ON p.unit_id = u.id WHERE p.id = '$pelayanan_id'";
					$rsCek = mysql_query($sqlCek);
					$rowCek = mysql_fetch_array($rsCek);
					
					if($rowCek['inap'] == 1){
						$sqlKunj = "update b_tindakan_kamar set tgl_out = $tgljam where pelayanan_id = '$pelayanan_id'";
						$rsKunj = mysql_query($sqlKunj);
					}
		    		mysql_free_result($rsCek);*/

                    //$sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."'";
                    //$rsDilayani=mysql_query($sqlDilayani);
		    
					/*$sqlSel = "select tgl_pulang,$tgljam as tgl_home from b_kunjungan where id = '$kunjungan_id'";
					$rsSel = mysql_query($sqlSel);
					$rowSel = mysql_fetch_array($rsSel);
					if(!isset($rowSel['tgl_pulang']) || $rowSel['tgl_pulang'] == '' || $rowSel['tgl_pulang'] < $rowSel['tgl_home']){
						$sqlSel = "update b_kunjungan set tgl_pulang = '".$rowSel['tgl_home']."' where id = '$kunjungan_id'";
						mysql_query($sqlSel);
					}*/
                }
                else {
                    $statusProses = 'Error';
                }
				mysql_free_result($rs);
				break;
		}
		break;
    case 'hapus':
		$msg="";
        switch($_REQUEST["hps"]) {
            case 'btnHapusRujukRS':
				$sqlCek = "SELECT inap,tgl_krs,tgl_pulang,pulang,k.id
					   FROM b_pelayanan p
					   inner join b_kunjungan k on p.kunjungan_id = k.id
					   INNER JOIN b_ms_unit u ON p.unit_id = u.id
					   WHERE p.id = '$pelayanan_id'";
				$rsCek = mysql_query($sqlCek);
				$rowCek = mysql_fetch_array($rsCek);
				$tgl_krs = $rowCek['tgl_krs'];
				$tgl_pul = $rowCek['tgl_pulang'];
				$pulang = $rowCek['pulang'];
				$kunjungan_id = $rowCek['id'];
				/*if($rowCek['inap'] == 1){
					$sqlKunj = "update b_tindakan_kamar set tgl_out = null,status_out = 0, trace_id=7 where pelayanan_id = '$pelayanan_id'";
					$rsKunj = mysql_query($sqlKunj);
				}
				mysql_free_result($rsCek);
		
				if($tgl_krs == $tgl_pul && $pulang == 0){
					$sqlKunj = "update b_kunjungan set tgl_pulang = null where id = '$pelayanan_id'";
					$rsKunj = mysql_query($sqlKunj);
				}
				$sqlDilayani="update b_pelayanan set dilayani=1,sudah_krs=0 where id='".$pelayanan_id."'";
							//echo $sqlDilayani."<br>";
				$rsDilayani=mysql_query($sqlDilayani);*/
		
				$sqlHapus="delete from b_pasien_keluar where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
                break;
		}
		break;
}
//echo $q;
if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id';
    }
	
    if($grd3 == "true") {
        $sql="select * from (SELECT date_format(b.tgl_act, '%d-%m-%Y %H:%i:%s') as tgl, b.id,b.cara_keluar,b.keadaan_keluar,if(b.kasus=1,'Baru','Lama') as kasus,r.nama as emergency,f.nama as kondisi,t.nama as rs,b.rs_id,b.dokter_id,p.nama as dokter,b.unit_id_kontrol,IF(b.unit_id_kontrol=0,b.ket,CONCAT('Tgl : ',date_format(b.tgl_kontrol, '%d-%m-%Y'),', ',mu.nama)) as ket
	FROM b_pasien_keluar b
	left join b_ms_tujuan_rujukan t on b.rs_id=t.id
	inner join b_ms_pegawai p on b.dokter_id=p.id
	left join b_ms_reference r on b.emergency=r.id
	left join b_ms_reference f on b.kondisi=f.id	
	left join b_ms_unit mu on b.unit_id_kontrol=mu.id	
	WHERE b.kunjungan_id = '".$kunjungan_id."' and pelayanan_id='".$pelayanan_id."') as gab $filter order by $sorting ";
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
	
	if($grd3 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["id"]."|".$rows['rs_id']."|".$rows['dokter_id']."|".$rows['type_dokter']."|".$rows['unit_id_kontrol'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["cara_keluar"].chr(3).$rows["keadaan_keluar"].chr(3).$rows["kasus"].chr(3).$rows["rs"].chr(3).$rows["dokter"].chr(3).$rows["emergency"].chr(3).$rows["kondisi"].chr(3).$rows["ket"].chr(6);
        }
	}
	
	if ($dt!=$totpage.chr(5)) {
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
		$dt=str_replace('"','\"',$dt);
	}else{
		$dt="0".chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
	}
}

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
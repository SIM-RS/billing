<?php 
include("../../koneksi/konek.php");
$grdListKonsul = $_REQUEST["grdListKonsul"];
$grdListKonsulRad = $_REQUEST["grdListKonsulRad"];
//====================================================================
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$statusProses='';

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5);
}
else{
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id';
    }

	if($grdListKonsul =="true"){ //Hasil Lab
		$sql="select * from (SELECT distinct CONCAT(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,b.id,u.nama as unit,ua.nama as unitasal,b.jenis_layanan,b.unit_id,b.dokter_id,p.nama as dokter,b.ket, b.type_dokter, pg.nama as penginput, if(b.dilayani=1,'Sudah dilayani','Belum dilayani') as status_dilayani
		FROM b_pelayanan b
		inner join b_ms_unit u on b.unit_id=u.id
		inner join b_ms_unit ua on ua.id=b.unit_id_asal
		left join b_ms_pegawai p on b.dokter_id=p.id
		left join b_ms_pegawai pg on b.user_act=pg.id
		WHERE b.jenis_layanan='".$_REQUEST['UnitKonsul']."' and b.kunjungan_id = '$kunjungan_id') as gab $filter order by $sorting";
	}
	elseif($grdListKonsulRad =="true"){ //Hasil Rad
		$sql="select * from 
		(SELECT distinct CONCAT(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,b.id,u.nama as unit,ua.nama as unitasal,b.jenis_layanan,b.unit_id,b.dokter_id,p.nama as dokter,b.ket, b.type_dokter, pg.nama as penginput, if(b.dilayani=1,'Sudah dilayani','Belum dilayani') as status_dilayani,
		mt.nama as pemeriksaan,
		r.id as hasil_rad_id
		FROM b_pelayanan b 
		inner join b_ms_unit u on b.unit_id=u.id
		inner join b_ms_unit ua on ua.id=b.unit_id_asal
		left join b_ms_pegawai p on b.dokter_id=p.id
		left join b_ms_pegawai pg on b.user_act=pg.id
		left join b_tindakan t on t.pelayanan_id=b.id
		left join b_hasil_rad r on r.tindakan_id=t.id
		left join b_ms_tindakan_kelas mtk on mtk.id=t.ms_tindakan_kelas_id
		left join b_ms_tindakan mt on mt.id=mtk.ms_tindakan_id
		WHERE b.jenis_layanan='".$_REQUEST['UnitKonsul']."' and b.kunjungan_id = '$kunjungan_id') as gab $filter order by $sorting";
	}

	//echo $sql."<br>";
	$rs=mysql_query($sql);
	//echo mysql_error();
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

    if($grdListKonsul == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$tSelesai="Hasil Belum Diverifikasi";
			$sqlVerif="SELECT verifikasi2 FROM b_hasil_lab WHERE id_pelayanan='".$rows["id"]."' AND id_tpa=0 ORDER BY verifikasi2 DESC LIMIT 1";
			$rsVerif=mysql_query($sqlVerif);
			if (mysql_num_rows($rsVerif)>0){
				$rwVerif=mysql_fetch_array($rsVerif);
				$cVerif=$rwVerif["verifikasi2"];
				if ($cVerif==1){
					$tSelesai="Hasil Sudah Diverifikasi";
				}
			}
			//$txtStatus=$rows["status_dilayani"].", ".$rows["hasil_selesai"];
			$txtStatus=$rows["status_dilayani"].", ".$tSelesai;
			//if ($rows['accLab']==1){
			if ($cVerif==1){
				$txtStatus="<span style='color:blue;font-weight:bold'>".$txtStatus."</span>";
			}
            $dt.=$rows["id"]."|".$rows['jenis_layanan']."|".$rows['unit_id']."|".$rows['dokter_id']."|".$rows['type_dokter'].'|'.$rows['kelas_id'].'|'.$rows['kamar_id'].'|'.$rows['accLab'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["unit"].chr(3).$rows["unitasal"].chr(3).$rows["dokter"].chr(3).$txtStatus.chr(3).$rows["penginput"].chr(3).$rows["ket"].chr(6);
            /* $dt.=$rows["id"]."|".$rows['jenis_layanan']."|".$rows['unit_id']."|".$rows['dokter_id']."|".$rows['type_dokter'].'|'.$rows['kelas_id'].'|'.$rows['kamar_id'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["unit"].chr(3).$rows["unitasal"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(3).$rows["penginput"].chr(3).$rows["status_dilayani"].chr(6); */
        }
    }
	elseif($grdListKonsulRad == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["id"]."|".$rows['jenis_layanan']."|".$rows['unit_id']."|".$rows['dokter_id']."|".$rows['type_dokter'].'|'.$rows['kelas_id'].'|'.$rows['kamar_id']."|".$rows["hasil_rad_id"].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["unit"].chr(3).$rows["unitasal"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(3).$rows["penginput"].chr(3).$rows["pemeriksaan"].chr(3).$rows["status_dilayani"].chr(6);
        }
    }

	if ($dt!=$totpage.chr(5))
	{
		$dt=substr($dt,0,strlen($dt)-1).chr(5);
		$dt=str_replace('"','\"',$dt);
	}else{
		$dt=$totpage.chr(5).chr(5);
	}
	
	mysql_free_result($rs);
	mysql_close($konek);
}
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
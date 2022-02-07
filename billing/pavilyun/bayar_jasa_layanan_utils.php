<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="pasien,t3.tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$dokter = $_REQUEST['dokter'];
$tglAwal = $_REQUEST['tglAwal'];
$tglAkhir = $_REQUEST['tglAkhir'];
switch(strtolower($grd)){
	
	case '1':
		$id=explode(",",$_REQUEST['id']);
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(sizeof($id)-1);$i++){                                   
                                    $sqlUpdate="UPDATE b_tindakan bt,
                                    (SELECT t.id FROM b_tindakan t
                                   INNER JOIN b_pelayanan p ON p.id=t.pelayanan_id
                                   INNER JOIN b_ms_unit u ON u.id=p.unit_id 
                                   INNER JOIN b_ms_unit n ON n.id=p.unit_id_asal
								   INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
								   INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
								   INNER JOIN b_ms_unit u ON u.id=l.unit_id
								   INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
								   WHERE (u.parent_id=50 OR n.parent_id=50)
								   AND (l.tgl BETWEEN '".tglSQL($tglAwal)."'
								   AND '".tglSQL($tglAkhir)."') AND k.id='".$id[$i]."') AS c ON c.id=p.kunjungan_id
                                   WHERE p.kunjungan_id='".$id[$i]."' AND t.user_id='$dokter' AND (c.jml>0)
								   AND (t.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."')) AS t1
                                   SET bt.tgl_bayar_pav = '".tglSQL($tglAkhir)."' WHERE bt.id = t1.id";
                                    mysql_query($sqlUpdate);					                                    
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){				   
                                    $sqlUpdate="UPDATE b_tindakan bt,
                                    (SELECT t.id FROM b_tindakan t
                                   INNER JOIN b_pelayanan p ON p.id=t.pelayanan_id
                                   INNER JOIN b_ms_unit u ON u.id=p.unit_id 
                                   INNER JOIN b_ms_unit n ON n.id=p.unit_id_asal
								   INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
								   INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
								   INNER JOIN b_ms_unit u ON u.id=l.unit_id
								   INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
								   WHERE (u.parent_id=50 OR n.parent_id=50)
								   AND (l.tgl BETWEEN '".tglSQL($tglAwal)."'
								   AND '".tglSQL($tglAkhir)."') AND k.id='".$id[$i]."') AS c ON c.id=p.kunjungan_id
                                   WHERE p.kunjungan_id='".$id[$i]."' AND t.user_id='$dokter' AND (c.jml>0)
								   AND (t.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."')) AS t1
                                   SET bt.tgl_bayar_pav = (NULL) WHERE bt.id = t1.id";
                                    mysql_query($sqlUpdate);	
				}
				break;			
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){	
	$sorting=$defaultsort;
}

switch($grd){
	
	case "1":
	$sql="SELECT * FROM (
	 SELECT t2.id,p.id AS id_pasien,p.no_rm,p.nama AS pasien,t2.tgl,t2.tgl_pulang,t2.ms_tindakan_id,o.nama AS kso,
	 SUM(t2.poli_pav) AS poli_pav,SUM(t2.visite) AS visite,SUM(t2.tindakan) AS tindakan
	 FROM (SELECT t1.id,t1.pasien_id,t1.tgl,t1.tgl_pulang,t1.ms_tindakan_kelas_id,t1.kso_id,tk.ms_tindakan_id,
	 SUM(IF(mt.klasifikasi_id='11',t1.biaya,0)) AS poli_pav,
	 SUM(IF(mt.klasifikasi_id='13' OR mt.klasifikasi_id='14',t1.biaya,0)) AS visite,
	 SUM(IF(mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'14' 
	 AND (u.id<>58 AND u.id<>59 AND u.id<>61 AND u.id<>19 AND u.parent_id<>27),t1.biaya,0)) AS tindakan
	 FROM (SELECT k.id,l.unit_id,l.unit_id_asal, k.pasien_id,k.tgl,
	 DATE(k.tgl_pulang) AS tgl_pulang,SUM(t.biaya_pasien+t.biaya_kso) AS biaya,t.kso_id,t.ms_tindakan_kelas_id
	 FROM b_kunjungan k
	 INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
	 INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
	 INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
	 INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
	 INNER JOIN b_ms_unit u ON u.id=l.unit_id
	 INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
	 WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
	 LEFT JOIN b_tindakan_dokter_anastesi da ON da.tindakan_id=t.id
	 WHERE (t.user_id = '$dokter' OR da.dokter_id='$dokter') AND (t.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."')
	 AND (c.jml>0) AND t.tgl_bayar_pav IS NULL ".$filter." GROUP BY t.id) AS t1 
	 INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
	 INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
	 INNER JOIN b_ms_unit u ON u.id=t1.unit_id
	 INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal
	 GROUP BY t1.ms_tindakan_kelas_id,t1.pasien_id) AS t2
	 INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id 
	 INNER JOIN b_ms_kso o ON o.id=t2.kso_id
	 GROUP BY t2.id) AS t3  ORDER BY ".$sorting;	
	
	break;
    case "2":
	$sql="SELECT * FROM (
	 SELECT t2.id,p.id AS id_pasien,p.no_rm,p.nama AS pasien,t2.tgl,t2.tgl_pulang,t2.ms_tindakan_id,o.nama AS kso,
	 SUM(t2.poli_pav) AS poli_pav,SUM(t2.visite) AS visite,SUM(t2.tindakan) AS tindakan
	 FROM (SELECT t1.id,t1.pasien_id,t1.tgl,t1.tgl_pulang,t1.ms_tindakan_kelas_id,t1.kso_id,tk.ms_tindakan_id,
	 SUM(IF(mt.klasifikasi_id='11',t1.biaya,0)) AS poli_pav,
	 SUM(IF(mt.klasifikasi_id='13' OR mt.klasifikasi_id='14',t1.biaya,0)) AS visite,
	 SUM(IF(mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'14' 
	 AND (u.id<>58 AND u.id<>59 AND u.id<>61 AND u.id<>19 AND u.parent_id<>27),t1.biaya,0)) AS tindakan
	 FROM (SELECT k.id,l.unit_id,l.unit_id_asal, k.pasien_id,k.tgl,
	 DATE(k.tgl_pulang) AS tgl_pulang,SUM(t.biaya_pasien+t.biaya_kso) AS biaya,t.kso_id,t.ms_tindakan_kelas_id
	 FROM b_kunjungan k
	 INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
	 INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
	 INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
	 INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
	 INNER JOIN b_ms_unit u ON u.id=l.unit_id
	 INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
	 WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
	 LEFT JOIN b_tindakan_dokter_anastesi da ON da.tindakan_id=t.id
	 WHERE (t.user_id = '$dokter' OR da.dokter_id='$dokter') AND t.tgl_bayar_pav = '".tglSQL($tglAkhir)."' 
	 AND (c.jml>0) AND t.tgl_bayar_pav IS NOT NULL ".$filter." GROUP BY t.id) AS t1 
	 INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
	 INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
	 INNER JOIN b_ms_unit u ON u.id=t1.unit_id
	 INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal
	 GROUP BY t1.ms_tindakan_kelas_id,t1.pasien_id) AS t2
	 INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id 
	 INNER JOIN b_ms_kso o ON o.id=t2.kso_id
	 GROUP BY t2.id) AS t3 ORDER BY ".$sorting;	
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

switch($grd){
	
	case "1":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$rows["kso"].chr(3).tglSQL($rows["tgl"]).chr(3).tglSQL($rows["tgl_pulang"]).chr(3).number_format($rows["poli_pav"],0,"",".").chr(3).number_format($rows["visite"],0,"",".").chr(3).number_format($rows["tindakan"],0,"",".").chr(6);
	}
        break;
    case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$rows["kso"].chr(3).tglSQL($rows["tgl"]).chr(3).tglSQL($rows["tgl_pulang"]).chr(3).number_format($rows["poli_pav"],0,"",".").chr(3).number_format($rows["visite"],0,"",".").chr(3).number_format($rows["tindakan"],0,"",".").chr(6);
	}
        break;
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
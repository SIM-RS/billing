<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.id DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================



if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}


	//$sql="SELECT b.*, peg.nama AS user_log FROM lap_travelling b LEFT JOIN b_ms_pegawai peg ON peg.id = b.user_act WHERE b.pelayanan_id='".$_REQUEST['pelayanan_id']."' ".$filter." order by ".$sorting;
	$sql="SELECT 
  b.*, p.nama,
  CONCAT(
    (
      CONCAT(
        (
          CONCAT(
            (CONCAT(p.alamat, ' RT.', p.rt)),
            ' RW.',
            p.rw
          )
        ),
        ', Desa ',
        w.nama
      )
    ),
    ', Kecamatan ',
    wi.nama
  ) alamat, DATE_FORMAT(p.`tgl_lahir`, '%d-%m-%Y') lahir, GROUP_CONCAT(md.nama) AS diag,
  peg.nama AS user_log 
FROM
  lap_travelling b 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = b.user_act 
  inner join b_pelayanan k 
    on k.id = b.`pelayanan_id` 
  INNER JOIN b_ms_pasien p 
    ON p.id = k.`pasien_id` 
  LEFT JOIN b_diagnosa diag 
    ON diag.pelayanan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_wilayah w 
    ON p.desa_id = w.id 
  LEFT JOIN b_ms_wilayah wi 
    ON p.kec_id = wi.id
WHERE b.pelayanan_id='".$_REQUEST['pelayanan_id']."' ".$filter." GROUP BY b.id order by ".$sorting;



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


	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["lahir"].chr(3).$rows["alamat"].chr(3).$rows["diag"].chr(3).$rows["tindakan_perminggu"].chr(3).$rows["lama_hd"].chr(3).$rows["cairan_konsentrat"].chr(3).$rows["bb_kering"].chr(3).$rows["sarana_hubungan"].chr(3).$rows["kenaikan"].chr(3).$rows["tkn_drh_sblm"].chr(3).$rows["tkn_drh_ssdh"].chr(3).$rows["jns_dialiser"].chr(3).$rows["kec_aliran"].chr(3).$rows["heparinasi"].chr(3).$rows["dosis_awal"].chr(3).$rows["rhesusu"].chr(3).$rows["trans_darah_trkhr"].chr(3).tglSQL($rows["tgl_hasil_lab"]).chr(3).$rows["hb"].chr(3).$rows["ureum"].chr(3).$rows["creatinin"].chr(3).$rows["kalium"].chr(3).$rows["phospor"].chr(3).$rows["hbsag"].chr(3).$rows["anti_hcv"].chr(3).$rows["anti_hiv"].chr(3).$rows["terapi1"].chr(3).$rows["terapi2"].chr(3).$rows["terapi3"].chr(3).$rows["terapi4"].chr(3).$rows["terapi5"].chr(3).$rows["user_log"].chr(6);
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
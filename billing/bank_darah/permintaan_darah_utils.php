<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="pm.id DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$tahun=$_REQUEST['tahun'];
$bulan=$_REQUEST['bulan'];
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter="AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($_REQUEST['status']==0){
$sql="SELECT
  pu.id,
  pu.tgl,
  pu.no_minta,
  pm.no_bukti,
  ps.nama        nama_pasien,
  pg.nama        nama_dokter,
  u.nama         nama_unit,
  kso.nama       nama_kso,
  d.kode,
  d.darah,
  gd.golongan,
  r.rhesus,
  pu.qty
FROM $dbbank_darah.bd_permintaan_unit pu
  INNER JOIN $dbbilling.b_kunjungan k
    ON k.id = pu.kunjungan_id
  INNER JOIN $dbbilling.b_pelayanan p
    ON p.id = pu.pelayanan_id
  INNER JOIN $dbbilling.b_ms_pasien ps
    ON ps.id = p.pasien_id
  INNER JOIN $dbbilling.b_ms_unit u
    ON u.id = p.unit_id
  INNER JOIN $dbbilling.b_ms_pegawai pg
    ON pg.id = pu.dokter_id
  INNER JOIN $dbbilling.b_ms_kso kso
    ON kso.id = p.kso_id
  LEFT JOIN $dbbank_darah.bd_pemakaian pm
    ON pm.no_minta = pu.no_minta
  INNER JOIN $dbbank_darah.bd_ms_darah d
    ON d.id = pu.ms_darah_id
  LEFT JOIN $dbbank_darah.bd_ms_gol_darah gd
    ON gd.id = pu.gol_darah_id
  LEFT JOIN $dbbank_darah.bd_ms_rhesus r
    ON r.id = pu.rhesus_id
WHERE MONTH(pu.tgl) = $bulan
    AND YEAR(pu.tgl) = $tahun
    AND pm.no_minta IS NULL ".$filter."
GROUP BY pu.no_minta";
}
if($_REQUEST['status']==1){
$sql="SELECT
  pu.id,
  pu.tgl,
  pu.no_minta,
  pm.no_bukti,
  ps.nama        nama_pasien,
  pg.nama        nama_dokter,
  u.nama         nama_unit,
  kso.nama       nama_kso,
  d.kode,
  d.darah,
  gd.golongan,
  r.rhesus,
  pu.qty
FROM $dbbank_darah.bd_permintaan_unit pu
  INNER JOIN $dbbilling.b_kunjungan k
    ON k.id = pu.kunjungan_id
  INNER JOIN $dbbilling.b_pelayanan p
    ON p.id = pu.pelayanan_id
  INNER JOIN $dbbilling.b_ms_pasien ps
    ON ps.id = p.pasien_id
  INNER JOIN $dbbilling.b_ms_unit u
    ON u.id = p.unit_id
  INNER JOIN $dbbilling.b_ms_pegawai pg
    ON pg.id = pu.dokter_id
  INNER JOIN $dbbilling.b_ms_kso kso
    ON kso.id = p.kso_id
  LEFT JOIN $dbbank_darah.bd_pemakaian pm
    ON pm.no_minta = pu.no_minta
  INNER JOIN $dbbank_darah.bd_ms_darah d
    ON d.id = pu.ms_darah_id
  LEFT JOIN $dbbank_darah.bd_ms_gol_darah gd
    ON gd.id = pu.gol_darah_id
  LEFT JOIN $dbbank_darah.bd_ms_rhesus r
    ON r.id = pu.rhesus_id
WHERE MONTH(pu.tgl) = $bulan
    AND YEAR(pu.tgl) = $tahun
    AND pm.no_minta IS NOT NULL ".$filter."
GROUP BY pu.no_minta";
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


while ($rows=mysql_fetch_array($rs)){
	$id=$rows['id'];
	$i++;
	$dt.=$id.chr(3).$i.chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_minta"].chr(3).$rows["no_bukti"].chr(3).$rows["nama_pasien"].chr(3).$rows["nama_dokter"].chr(3).$rows["nama_unit"].chr(3).$rows["nama_kso"].chr(3).$rows["kode"].chr(3).$rows["darah"].chr(3).$rows["qty"].chr(6);
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
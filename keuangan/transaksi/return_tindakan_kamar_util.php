<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$id=$_GET['id'];
$idPasien=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$jnsRwt=$_REQUEST['jnsRwt'];
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}


/*
$sql="SELECT tk.id,n.nama AS jenis,p.unit_id,mu.nama AS unit,mkls.nama AS kelas,tk.kelas_id,tk.kamar_id,mk.nama AS kamar ,mk.nama,tk.tgl_in,tk.tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.status_out,tk.verifikasi
FROM b_pelayanan p 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
LEFT JOIN b_ms_unit n ON n.id=mu.parent_id
LEFT JOIN b_ms_kamar mk ON mk.id=tk.kamar_id
LEFT JOIN b_ms_kelas mkls ON tk.kelas_id=mkls.id
WHERE p.kunjungan_id='$idKunj' 
AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY tk.id";
*/

$sql="SELECT 
 tbl1.* 
FROM
  (SELECT 
    p.jenis_kunjungan,
    t.id,
    bt.id AS bayar_tindakan_id,
    t.pelayanan_id,
    n.nama AS jenis,
    p.unit_id,
    mu.parent_id,
    mu.nama AS unit,
    tk.nama AS kamar,
    DATE(t.tgl_in) AS tgl,
    t.qty AS jumlah,
    t.tarip AS biaya,
    t.beban_kso AS biaya_kso,
    t.beban_pasien AS biaya_pasien,
    t.bayar_pasien,
    bt.nilai AS bayar_tindakan,
	mt.nama AS tindakan,
    mk.nama AS kelas  
  FROM
    $dbbilling.b_pelayanan p 
    INNER JOIN $dbbilling.b_ms_unit mu 
      ON p.unit_id = mu.id 
    INNER JOIN $dbbilling.b_tindakan_kamar t 
      ON p.id = t.pelayanan_id 
    LEFT JOIN $dbbilling.b_ms_unit n 
      ON n.id = mu.parent_id 
    INNER JOIN $dbbilling.b_ms_kamar tk 
      ON tk.id = t.kamar_id 
    INNER JOIN $dbbilling.b_bayar_tindakan bt 
      ON bt.tindakan_id = t.id
	INNER JOIN $dbbilling.b_tindakan ti 
      ON ti.id = bt.tindakan_id 
    INNER JOIN $dbbilling.b_ms_tindakan_kelas btk 
      ON btk.id = ti.ms_tindakan_kelas_id 
    INNER JOIN $dbbilling.b_ms_tindakan mt 
      ON mt.id = btk.ms_tindakan_id 
  INNER JOIN $dbbilling.b_ms_kelas mk 
    ON mk.id = btk.ms_kelas_id 
  WHERE p.kunjungan_id = '$idKunj' 
    AND p.jenis_kunjungan = 3 
    AND bt.tipe = 1) AS tbl1 
  LEFT JOIN 
    (SELECT 
      bayar_tindakan_id 
    FROM
      $dbbilling.b_return) AS tbl2 
    ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
WHERE tbl2.bayar_tindakan_id IS NULL";

//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
//$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while ($rows=mysql_fetch_array($rs)){
		$proses = "<img src='../icon/edit.gif' onClick='popupTindakanKamar()' title='edit tindakan' width='20' style='cursor:pointer' />&nbsp;&nbsp;&nbsp;<img src='../icon/erase.png' width='20' onClick='hapusTindakanKamar()' title='hapus tindakan' style='cursor:pointer' />";
		//$id=$rows['id']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['kamar_id']."|".$rows['status_out']."|".$rows['verifikasi']."|".$rows['bayar_tindakan_id'];
		$edit = "<img src='../icon/edit.gif' onClick='popupTindakanKamar()' title='edit tindakan' width='20' style='cursor:pointer' />";
		$hapus = "<img src='../icon/erase.png' width='20' onClick='hapusTindakanKamar()' title='hapus tindakan' style='cursor:pointer' />";
		if($rows['status_out']==0){
			$out = 'Pulang';
		}
		if($rows['status_out']==1){
			$out = 'Pindah';
		}
		if($rows['verifikasi']==='1'){
			$verif = 'checked';
		}
		if($rows['verifikasi']==='0'){
			$verif = '';
		}
		$verifikasi_tindakan_kamar = "<input type='checkbox' id='chkVerKamarNew_$rows[id]' onClick='VerifikasiTindakanKamar($rows[id])' $verif/>";
		$i++;
		$id=$rows['bayar_tindakan_id'];
		$cek = "<input type='checkbox' id='chktk_$rows[bayar_tindakan_id]' />";
		$dt.=$id.chr(3).$cek.chr(3).$rows["jenis"].chr(3).$rows["unit"].chr(3).$rows["kamar"].chr(3).tglJamSQL($rows["tgl"]).chr(3).$rows["tindakan"].chr(3).$rows["kelas"].chr(3).$rows["biaya"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(6);
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
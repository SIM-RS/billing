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
		$id=$rows['id']."|".$rows['unit_id']."|".$rows['kelas_id']."|".$rows['kamar_id']."|".$rows['status_out']."|".$rows['verifikasi'];
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
		$dt.=$id.chr(3).$i.chr(3).$rows["jenis"].chr(3).$rows["unit"].chr(3).$rows["kamar"].chr(3).$rows["kelas"].chr(3).tglJamSQL($rows["tgl_in"]).chr(3).tglJamSQL($rows["tgl_out"]).chr(3).$out.chr(3).$rows["tarip"].chr(3).$rows["beban_kso"].chr(3).$rows["beban_pasien"].chr(3).$verifikasi_tindakan_kamar.chr(3).$edit.chr(3).$hapus.chr(6);
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
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

if($jnsRwt=='0'){
	$jnsR = '';
}
else{
	$jnsR = " AND p.jenis_kunjungan = '".$jnsRwt."' ";
}

$sql = "SELECT
		  b.*,
		  DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tgl_bayar,
		  DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl_disetor,
		  mp.nama AS namaKasir
		FROM $dbbilling.b_bayar b
		  INNER JOIN $dbbilling.b_ms_pegawai mp
			ON b.user_act = mp.id
		  LEFT JOIN $dbbilling.b_return_pembayaran rp
			ON b.id = rp.bayar_id
		WHERE b.kunjungan_id = '$idKunj' AND rp.id IS NULL";
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
		$sdhBayar=0;
		/*if ($rows["bayar_pasien"]>0) $sdhBayar=1;
		$proses = "<img src='../icon/edit.gif' onClick='popupTindakan($sdhBayar)' title='edit tindakan' width='20' style='cursor:pointer' />&nbsp;&nbsp;&nbsp;<img src='../icon/erase.png' width='20' onClick='hapusTindakan($sdhBayar)' title='hapus tindakan' style='cursor:pointer' />";
		$id=$rows['ms_kelas_id']."|".$rows['unit_id']."|".$rows['parent_id']."|".$rows['pelayanan_id']."|".$rows['id']."|".$rows['ms_tindakan_kelas_id']."|".$rows['bayar_tindakan_id'];*/
		$i++;
		
		/*$cek = "SELECT * FROM $dbbilling.b_return WHERE bayar_tindakan_id=".$rows['bayar_tindakan_id'];
		$kueri = mysql_query($cek);
		$jml = mysql_num_rows($kueri);
		if($jml>0){
			$return = 'checked';
			$val = '1';
		}
		else{
			$return = '';
			$val = '0';
		}*/
		$id=$rows['id'];
		$return_tindakan = "<input type='checkbox' id='chkReturn_$rows[id]' value='0' onclick='prosesReturn($rows[id])' />";
		$chk = "<input type='checkbox' id='chk_$rows[id]' />";
		$hidden = "<input type='hidden' id='ids' />";
		$treturBayar="<input type='text' id='nilai_$i' class='txtinput' value='".number_format($rows["nilai"],0,",",".")."' style='width:100px; font:12px tahoma; padding:2px; text-align:right' onkeyup='returKeyUp(this);' />";
		$dt.=$id.chr(3).$chk.$hidden.chr(3).$rows["no_kwitansi"].chr(3).$rows["tgl_bayar"].chr(3).$rows["tgl_disetor"].chr(3).$rows["namaKasir"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$treturBayar.chr(6);
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
<?php
include("../../koneksi/konek.php");
//====================================================================
$user_act = $_REQUEST['user_act'];

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a.id DESC";
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


	$sql="SELECT a.*,b.id as id_dokter1,b.nama as nama_dokter1,c.id as id_dokter2,c.nama as nama_dokter2 from b_form_serahterima as a inner join b_ms_pegawai as b on b.id=a.dokter1 inner join b_ms_pegawai as c on c.id=a.dokter2 where 0=0 ".$filter." order by ".$sorting;



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
		$tgl_rawat = tglSQL($rows["tgl_rawat"]);
		$tgl_pindah = tglSQL($rows['tgl_pindah']);
		
		//$datanya = "$rows[id]|$rows[id_pelayanan]|$rows[id_kunjungan]|$rows[nama]|$rows[no_rm]|$tgl_lahir|$rows[umur]|$rows[sex]|$rows[alamat]|$tgl_mati|$rows[jam_mati]";
		$datanya = "$rows[id]|$tgl_rawat|$tgl_pindah|$rows[id_dokter1]|$rows[id_dokter2]|$rows[indikasi]|$rows[kesadaran]|$rows[diagnosa]|$rows[tekanan]|$rows[pernafasan]|$rows[nadi]|$rows[suhu]|$rows[berat_badan]|$rows[tinggi_badan]|$rows[alat_bantu]|$rows[alat_bantu_ket]|$rows[tindakan_operasi]|$rows[kemampuan]|$rows[kemampuan_ket]|$rows[tingkat]|$rows[radiologi]|$rows[thorax]|$rows[thorax_jum]|$rows[ct]|$rows[ct_jum]|$rows[lain]|$rows[lain_ket]|$rows[echo]|$rows[echo_jum]|$rows[eeg]|$rows[eeg_jum]|$rows[usg]|$rows[usg_jum]|$rows[lab]|$rows[lab_jum]|$rows[barang_pribadi]|$rows[tanda_bukti]|$rows[tanda_bukti_ket]|$rows[perawat_terima]|$rows[pj_shift]|$rows[perawat_serah]";
		$dt.=$datanya.chr(3).number_format($i,0,",","").chr(3).$tgl_rawat.chr(3).$tgl_pindah.chr(3).$rows["nama_dokter1"].chr(3).$rows["nama_dokter2"].chr(3).$rows["indikasi"].chr(6);
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
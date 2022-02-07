<?php
include '../../koneksi/konek.php';

function tanggal($a){
	if($a != ''){
		$tglA = explode('-',$a);
		$tglH = $tglA[2].'-'.$tglA[1].'-'.$tglA[0];
	}
	return $tglH;
}

$page=$_REQUEST["page"];
$defaultsort="idBedah";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	$sorting=$defaultsort;
}

$sql = "SELECT * FROM b_form_prosedur_bedah";

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
	$sisip = "<img src='../../icon/edit.gif' width='16' height='16' alt='Klik Untuk Mengedit Data' onclick=editData(".$rows['idBedah'].") />
				&nbsp;&nbsp;
			  <img src='../../icon/del16.gif' width='16' height='16' alt='Klik Untuk Menghapus Data' onclick=deleteData(".$rows['idBedah'].") />
				&nbsp;&nbsp;
			  <img src='../../icon/printer.png' width='16' height='16' alt='Klik Untuk Mencetak Data' onclick=cetakData(".$rows['idBedah'].") />";
	$i++;
	$PreOperasi = 'Tidak Cukur';	
	if($rows["PreOperasi"] == '1'){ $PreOperasi = 'Cukur'; }
	
	$jnsOperasi = explode('|',$rows["JenisOperasi"]);
	$jenis1 = ($jnsOperasi[0] == '1' )?'Bersih':'Kotor';
	$jenis2 = ($jnsOperasi[1] == '1' )?'Besar':'Kecil';
	$JenisOpe = $jenis1.' dan '.$jenis2;
	
	$dt .= $rows['idBedah'].chr(3).number_format($i,0,",","").chr(3).$rows["operasi"].chr(3).tanggal($rows["tglOperasi"]).chr(3).
			$JenisOpe.chr(3).$PreOperasi.chr(3).$rows["LamaOperasi"]." jam".chr(3).$sisip.chr(6);
}
if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
	header("Content-type: application/xhtml+xml");
}else {
	header("Content-type: text/xml");
}
echo $dt;
?>
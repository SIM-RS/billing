<?php
include("../koneksi/konek.php");
$act = strtolower($_REQUEST['act']);
$id_bhp = $_REQUEST['id_bhp'];
$penerimaan_id_bhp = $_REQUEST['penerimaan_id_bhp'];
$obat_id_bhp = $_REQUEST['obat_id_bhp'];
$kepemilikan_id_bhp = $_REQUEST['kepemilikan_id_bhp'];
$unit_id_bhp  = $_REQUEST['unit_id_bhp'];
$kso_id_bhp  = $_REQUEST['kso_id_bhp'];
$tggl_bhp = $_REQUEST['tggl_bhp'];
$skrg = date("Y-m-d h:i:s", time());
$pelayanan_id_bhp = $_REQUEST['pelayanan_id_bhp'];
$no_pas  = $_REQUEST['no_pas'];
$nama_pas = $_REQUEST['nama_pas'];
$alamat_pas	= $_REQUEST['alamat_pas'];
$jumlah_bhp = $_REQUEST['jumlah_bhp'];
$h_satuan = $_REQUEST['h_satuan'];
$h_total = $jumlah_bhp*$h_satuan;
$keterangan_bhp = $_REQUEST['keterangan_bhp'];
$user_act_bhp = $_REQUEST['user_act_bhp'];
$status = 1;
   

switch($act){
case 'tambah':
	$c = mysql_query("SELECT IDMITRA FROM $dbapotek.a_mitra AS am 
	INNER JOIN $dbbilling.b_ms_kso AS bk ON am.KODE_MITRA=bk.kode WHERE bk.id='$kso_id_bhp'");
	$cc = mysql_fetch_array($c);
	//insert data
	$q = "INSERT INTO $dbapotek.a_pemakaian_bhp(PENERIMAAN_ID,OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,KSO_ID,TGL,TGL_ACT,PELAYANAN_ID,NO_PASIEN,NAMA_PASIEN,ALAMAT,QTY,HARGA_SATUAN,HARGA_TOTAL,KET,USER_ACT,STATUS) values('$penerimaan_id_bhp','$obat_id_bhp','$kepemilikan_id_bhp','$unit_id_bhp','$cc[IDMITRA]','','$skrg','$pelayanan_id_bhp','$no_pas','$nama_pas','$alamat_pas','$jumlah_bhp','$h_satuan','$h_total','$keterangan_bhp','$user_act_bhp','$status')";//echo $q;
	$s = mysql_query($q);
	break;

	case 'update':
	$q = "UPDATE $dbapotek.a_pemakaian_bhp SET 
PENERIMAAN_ID='$penerimaan_id_bhp',OBAT_ID='$obat_id_bhp',KEPEMILIKAN_ID='$kepemilikan_id_bhp',TGL_ACT='$skrg',QTY='$jumlah_bhp',HARGA_SATUAN='$h_satuan',HARGA_TOTAL='$h_total',KET='$keterangan_bhp' WHERE ID='$id_bhp'";
	$s = mysql_query($q);
	break;

}
//echo $q;

$sql = "SELECT 
apb.ID,
apb.PENERIMAAN_ID,
apb.OBAT_ID,
apb.KEPEMILIKAN_ID,
apb.USER_ACT,
DATE_FORMAT(apb.TGL_ACT,'%d-%m-%Y %H:%i')AS TGL_ACT,
aob.OBAT_NAMA,
akp.NAMA,
apb.QTY,
apb.HARGA_SATUAN,
apb.HARGA_TOTAL,
apb.KET,
apb.STATUS FROM $dbapotek.a_pemakaian_bhp AS apb
INNER JOIN $dbapotek.a_obat AS aob ON aob.OBAT_ID=apb.OBAT_ID
INNER JOIN $dbapotek.a_kepemilikan akp ON akp.ID=apb.KEPEMILIKAN_ID;";


 	$rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	
	if ($grd == "true"){
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql;
		$rs=mysql_query($sql);
	}
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

$query = mysql_query($sql);
 while ($rows=mysql_fetch_array($query)) 
 {		
 		
		//$qq = mysql_query("select OBAT_NAMA from $dbapotek.a_obat where OBAT_ID='$rows['OBAT_ID']'");
//		$d = mysql_fetch_array($qq);$d['NAMA_OBAT']
		
		     $sisip = $rows['ID']."|".$rows['PENERIMAAN_ID']."|".$rows['OBAT_ID']."|".$rows['KEPEMILIKAN_ID']."|".$rows['USER_ACT']."|".$rows['STATUS'];//."|".$rows['UNIT_ID']."|".$rows['KSO_ID']."|".$rows['TGL']."|".$rows['TGL_ACT']."|".$rows['PELAYANAN_ID']."|".$rows['NO_PASIEN']."|".$rows['NAMA_PASIEN'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['TGL_ACT'].chr(3).$rows['OBAT_NAMA'].chr(3).$rows['NAMA'].chr(3).$rows['QTY'].chr(3).$rows['HARGA_SATUAN'].chr(3).$rows['HARGA_TOTAL'].chr(3).$rows['KET'].chr(6);  
   
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
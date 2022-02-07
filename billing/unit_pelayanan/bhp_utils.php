<?php
include("../koneksi/konek.php");
$act = strtolower($_REQUEST['act']);
$id_bhp = $_REQUEST['id_bhp'];
$penerimaan_id_bhp = $_REQUEST['penerimaan_id_bhp'];
$obat_id_bhp = $_REQUEST['obat_id_bhp'];
$unit_id_terima_bhp = $_REQUEST['unit_id_terima_bhp'];
$kepemilikan_id_bhp = $_REQUEST['kepemilikan_id_bhp'];
$unit_id_bhp  = $_REQUEST['unit_id_bhp'];
$kso_id_bhp  = $_REQUEST['kso_id_bhp'];
$tggl_bhp = date("Y-m-d");
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
$status_bhp = $_REQUEST['status_bhp'];
$jmlbu = $_REQUEST['jmlbu'];

if(!isset($_REQUEST['unit_id_terima_bhp'])){
	$q = "SELECT au.UNIT_ID,au.UNIT_NAME,au.kdunitfar FROM $dbapotek.a_unit AS au
	INNER JOIN $dbbilling.b_ms_unit AS bu ON bu.kode=au.kdunitfar WHERE bu.id='$unit_id_bhp'";
	$s = mysql_query($q);
	$d = mysql_fetch_array($s);
	$unit_id_terima_bhp = $d['UNIT_ID'];
	//echo $unit_id_terima_bhp."<br><br>";
}

//request buat view grid   
$pelayanan_id_bhp = $_REQUEST['pelayanan_id_bhp'];
//

switch($act){
case 'tambah':
	$c = mysql_query("SELECT IDMITRA FROM $dbapotek.a_mitra AS am 
	INNER JOIN $dbbilling.b_ms_kso AS bk ON am.KODE_MITRA=bk.kode WHERE bk.id='$kso_id_bhp'");
	$cc = mysql_fetch_array($c);

	$sql="select SQL_NO_CACHE * from $dbapotek.a_penerimaan ap where OBAT_ID='$obat_id_bhp' and UNIT_ID_TERIMA=$unit_id_terima_bhp and KEPEMILIKAN_ID=$kepemilikan_id_bhp and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$done="false";
	$jml=$jumlah_bhp;
	while (($rows=mysql_fetch_array($rs))&&($done=="false"))
	{
		$cstok=$rows['QTY_STOK'];
		$cid=$rows['ID'];
		if ($cstok>=$jml)
		{
			$done="true";
			$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			
			$sql = "INSERT INTO $dbapotek.a_pemakaian_bhp(PENERIMAAN_ID,OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,KSO_ID,TGL,TGL_ACT,PELAYANAN_ID,NO_PASIEN,NAMA_PASIEN,ALAMAT,QTY,HARGA_SATUAN,HARGA_TOTAL,KET,USER_ACT,STATUS) values('$penerimaan_id_bhp','$obat_id_bhp','$kepemilikan_id_bhp','$unit_id_bhp','$cc[IDMITRA]','$tggl_bhp','$skrg','$pelayanan_id_bhp','$no_pas','$nama_pas','$alamat_pas','$jumlah_bhp','$h_satuan','$h_total','$keterangan_bhp','$user_act_bhp','$status_bhp')";
			
			//$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if (mysql_errno()>0)
			{
				$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
			}
		}
		else
		{
			$jml=$jml-$cstok;
			$sql="update $dbapotek.a_penerimaan set QTY_STOK=0 where ID=$cid";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			$sql = "INSERT INTO $dbapotek.a_pemakaian_bhp(PENERIMAAN_ID,OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,KSO_ID,TGL,TGL_ACT,PELAYANAN_ID,NO_PASIEN,NAMA_PASIEN,ALAMAT,QTY,HARGA_SATUAN,HARGA_TOTAL,KET,USER_ACT,STATUS) values('$penerimaan_id_bhp','$obat_id_bhp','$kepemilikan_id_bhp','$unit_id_bhp','$cc[IDMITRA]','$tggl_bhp','$skrg','$pelayanan_id_bhp','$no_pas','$nama_pas','$alamat_pas','$jumlah_bhp','$h_satuan','$h_total','$keterangan_bhp','$user_act_bhp','$status_bhp')";
			
			//$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
			//echo $sql."<br>";
			$rs1=mysql_query($sql);
			if (mysql_errno()>0)
			{
				$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
			}
		}
	}
	break;

	case 'update':
	$qq = "select QTY from $dbapotek.a_pemakaian_bhp where ID='$id_bhp'";
	$rr = mysql_fetch_array(mysql_query($qq));
	//echo $rr['QTY'];
	
	$sql="select SQL_NO_CACHE * from $dbapotek.a_penerimaan ap where OBAT_ID='$obat_id_bhp' and UNIT_ID_TERIMA=$unit_id_terima_bhp and KEPEMILIKAN_ID=$kepemilikan_id_bhp and QTY_STOK>=0 and ap.STATUS=1 order by TANGGAL,ID";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$done="false";
	$jml=$jmlbu;
	$jmlbr = $jumlah_bhp;;
	
	while (($rows=mysql_fetch_array($rs))&&($done=="false"))
	{
		$cstok=$rows['QTY_STOK'];
		$cid=$rows['ID'];
		
		$done="true";
		$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
		$rs1=mysql_query($sql);
		
		$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$jmlbr where ID=$cid";
		$rs1=mysql_query($sql);
		
		$q = "UPDATE $dbapotek.a_pemakaian_bhp SET 
PENERIMAAN_ID='$penerimaan_id_bhp',OBAT_ID='$obat_id_bhp',KEPEMILIKAN_ID='$kepemilikan_id_bhp',TGL_ACT='$skrg',QTY='$jumlah_bhp',HARGA_SATUAN='$h_satuan',HARGA_TOTAL='$h_total',KET='$keterangan_bhp',STATUS='$status_bhp' WHERE ID='$id_bhp'";
	$s = mysql_query($q);
	}
	break;
	
	case 'hapus':
	
	$sql="select SQL_NO_CACHE * from $dbapotek.a_penerimaan ap where OBAT_ID='$obat_id_bhp' and UNIT_ID_TERIMA=$unit_id_terima_bhp and KEPEMILIKAN_ID=$kepemilikan_id_bhp and QTY_STOK>=0 and ap.STATUS=1 order by TANGGAL,ID";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$done="false";
	$jml=$jumlah_bhp;
	
	while (($rows=mysql_fetch_array($rs))&&($done=="false"))
	{
		$cstok=$rows['QTY_STOK'];
		$cid=$rows['ID'];
		
		$done="true";
		$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
		$rs1=mysql_query($sql);
		
		$q = "DELETE FROM $dbapotek.a_pemakaian_bhp WHERE ID='$id_bhp'";
		$s = mysql_query($q);
		
		//echo $sql."<br>";
	}
	break;
}
//echo $q;

$filter = $_REQUEST['filter'];
if ($filter!="") 
{
   $filter=explode("|",$filter);
   $filter=" WHERE ".$filter[0]." LIKE '%".$filter[1]."%'";
}
$sorting = $_REQUEST['sorting'];
if ($sorting!="") 
{	
	$sorting = "ORDER BY $sorting";
}

$sql = "SELECT * FROM (
SELECT 
apb.ID,
apb.PENERIMAAN_ID,
apb.OBAT_ID,
apb.KEPEMILIKAN_ID,
apb.USER_ACT,
DATE_FORMAT(apb.TGL,'%d-%m-%Y')AS TGL,
DATE_FORMAT(apb.TGL_ACT,'%d-%m-%Y %H:%i')AS TGL_ACT,
aob.OBAT_NAMA,
akp.NAMA,
apb.QTY,
apb.HARGA_SATUAN,
apb.HARGA_TOTAL,
apb.KET,
apb.STATUS FROM $dbapotek.a_pemakaian_bhp AS apb
INNER JOIN $dbapotek.a_obat AS aob ON aob.OBAT_ID=apb.OBAT_ID
INNER JOIN $dbapotek.a_kepemilikan akp ON akp.ID=apb.KEPEMILIKAN_ID
WHERE apb.PELAYANAN_ID='$pelayanan_id_bhp') AS tt $filter $sorting";
//echo $sql;

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
		
		     $sisip = $rows['ID']."|".$rows['PENERIMAAN_ID']."|".$rows['OBAT_ID']."|".$rows['KEPEMILIKAN_ID']."|".$rows['USER_ACT']."|".$rows['STATUS']."|".$rows['HARGA_SATUAN'];//."|".$rows['UNIT_ID']."|".$rows['KSO_ID']."|".$rows['TGL']."|".$rows['TGL_ACT']."|".$rows['PELAYANAN_ID']."|".$rows['NO_PASIEN']."|".$rows['NAMA_PASIEN'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['TGL'].chr(3).$rows['OBAT_NAMA'].chr(3).$rows['NAMA'].chr(3).$rows['QTY'].chr(3).$rows['KET'].chr(6);  
   
 }

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
	$dt=str_replace('"','\"',$dt);
}else{
	$dt.=chr(5).strtolower($_REQUEST['act']);
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
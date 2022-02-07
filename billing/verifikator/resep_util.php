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
$no_kunjungan = $_REQUEST['no_kunjungan'];
$no_penjualan = $_REQUEST['no_penjualan'];
$user_id = $_REQUEST['user_id'];
$no_pasien = $_REQUEST['no_pasien'];
$unit_id = $_REQUEST['unit_id'];

$tgl1 = tglSQL($_REQUEST['tgl1']);
$tgl2 = tglSQL($_REQUEST['tgl2']);

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($jnsRwt==0){
	$jenisKunj = 1;
}
if($jnsRwt==2){
	$jenisKunj = 2;
}
if($jnsRwt==1){
	$jenisKunj = 3;
}

if($_REQUEST['grid']==1){
	if($_REQUEST['act']=='tambah'){
		 $dt=explode("|",$_REQUEST['data']);
		 for($i=0;$i<count($dt)-1; $i++){
			$isi = explode("**",$dt[$i]);
			$sqll = "UPDATE ".$dbapotek.".a_penjualan SET NO_KUNJUNGAN='$isi[0]' WHERE NO_PENJUALAN = '$isi[1]' AND UNIT_ID='$isi[2]' AND USER_ID='$isi[3]' AND NO_PASIEN='$isi[4]'";
			mysql_query($sqll);
		}
	}
	elseif($_REQUEST['act']=='hapus'){
		$edit = "UPDATE ".$dbapotek.".a_penjualan SET NO_KUNJUNGAN=0 WHERE NO_KUNJUNGAN = '$no_kunjungan' AND UNIT_ID='$unit_id' AND NO_PENJUALAN = '$no_penjualan' AND USER_ID='$user_id' AND NO_PASIEN='$no_pasien'";
		mysql_query($edit);
	}
}


if($_REQUEST['grid']==1){
$sql = "SELECT
  ap.ID,
  ap.NO_KUNJUNGAN,
  DATE_FORMAT(ap.TGL,'%d/%m/%Y') AS tgl1,
  ap.TGL,
  ap.UNIT_ID,
  ap.NO_PENJUALAN,
  am.NAMA         AS KSO,
  ap.NO_RESEP,
  ap.NO_PASIEN,
  ap.NAMA_PASIEN,
  ap.USER_ID,
  ak.NAMA,
  au1.UNIT_NAME,
  ap.DOKTER,
  ap.SHIFT,
  ap.CARA_BAYAR,
  ac.nama AS cbayar,
  ap.UTANG,
  SUM(FLOOR((ap.QTY_JUAL-ap.QTY_RETUR)*ap.HARGA_NETTO)) AS HARGA_NETTO,
  (ap.HARGA_TOTAL-SUM(FLOOR(ap.QTY_RETUR*ap.HARGA_SATUAN*((100-ap.BIAYA_RETUR)/100)))) AS HARGA_TOTAL,
  SUM(ap.QTY_RETUR) AS jRetur,
  ap.VERIFIKASI
FROM (SELECT
        ap1.*
      FROM (SELECT
              distinct id
            FROM b_pelayanan
            WHERE kunjungan_id = '$idKunj'
                AND jenis_kunjungan = $jenisKunj) AS p
        INNER JOIN ".$dbapotek.".a_penjualan ap1
          ON p.id = ap1.NO_KUNJUNGAN) ap
  LEFT JOIN ".$dbapotek.".a_unit au1
    ON (ap.RUANGAN = au1.UNIT_ID)
  INNER JOIN ".$dbapotek.".a_kepemilikan ak
    ON (ap.JENIS_PASIEN_ID = ak.ID)
  INNER JOIN ".$dbapotek.".a_unit au
    ON ap.UNIT_ID = au.UNIT_ID
  INNER JOIN ".$dbapotek.".a_cara_bayar ac
    ON ap.CARA_BAYAR = ac.id
  LEFT JOIN ".$dbapotek.".a_mitra am
    ON ap.KSO_ID = am.IDMITRA
GROUP BY ap.NO_PENJUALAN,ap.UNIT_ID,ap.NAMA_PASIEN,ap.USER_ID 
ORDER BY ap.NO_PENJUALAN";
}
elseif($_REQUEST['grid']==2){
$sql = "select * from(
                select ap.id,ao.obat_nama,sum(ap.qty_jual) as qty_jual,ap.harga_satuan,sum(ap.qty_jual*ap.harga_satuan) as sub_tot
                 from ".$dbapotek.".a_penjualan ap
                 inner join ".$dbapotek.".a_penerimaan pe on ap.penerimaan_id = pe.id
                 inner join ".$dbapotek.".a_obat ao on ao.obat_id = pe.obat_id
                where ap.no_penjualan = '$no_penjualan' and ap.unit_id = '$unit_id' group by ao.obat_id) t1";	
}
elseif($_REQUEST['grid']==3){
$sql = "SELECT
  DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,
  a_penjualan.USER_ID,
  a_penjualan.TGL,
  a_penjualan.UNIT_ID,
  a_penjualan.NO_PENJUALAN,
  a_penjualan.NO_RESEP,
  a_penjualan.NO_PASIEN,
  a_penjualan.NAMA_PASIEN,
  a_kepemilikan.NAMA,
  a_unit.UNIT_NAME,
  au.UNIT_NAME             AS UNIT_NAME1,
  a_penjualan.DOKTER,
  a_penjualan.SHIFT,
  ac.nama                  AS cara_bayar,
  (a_penjualan.HARGA_TOTAL-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL
FROM ".$dbapotek.".a_penjualan
  LEFT JOIN ".$dbapotek.".a_unit
    ON (a_penjualan.RUANGAN = a_unit.UNIT_ID)
  INNER JOIN ".$dbapotek.".a_kepemilikan
    ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID)
  INNER JOIN ".$dbapotek.".a_unit au
    ON a_penjualan.UNIT_ID = au.UNIT_ID
  INNER JOIN ".$dbapotek.".a_cara_bayar ac
    ON a_penjualan.CARA_BAYAR = ac.id
  INNER JOIN ".$dbapotek.".a_mitra am
    ON a_penjualan.KSO_ID = am.IDMITRA
WHERE (a_penjualan.TGL = '$tgl1')
    AND (au.UNIT_TIPE <> 5) ".$filter."
GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN,a_penjualan.USER_ID";	
}

//echo $sql."<br>";
$perpage=100;
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

if($_REQUEST['grid']==1){
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['UNIT_ID']."|".$rows['USER_ID']."|".$rows['NO_KUNJUNGAN']."|".$rows['NO_PASIEN']."|".$rows['NO_PENJUALAN'];
		
		$par = tglSQL($rows["TGL"])."|".$rows['NO_KUNJUNGAN']."|".$rows['NO_PENJUALAN'].'|'.$rows["CARA_BAYAR"];
		$par2 = $rows['NO_KUNJUNGAN']."_".$rows['NO_PENJUALAN'];
		$edit = "<img src='../icon/edit.gif' onClick=popupResep('$par') title='edit resep' width='20' style='cursor:pointer; display:inline-block;' />&nbsp;&nbsp;&nbsp;";
		$hapus = "<img src='../icon/erase.png' width='20' onClick='hapusResep($i);' title='hapus resep' style='cursor:pointer; display:inline-block;' />";
		$lihat="<a onclick=window.open('../../apotek/report/kwi_retur.php?no_penjualan=$rows[NO_PENJUALAN]&sunit=$rows[UNIT_ID]&no_pasien=$rows[NO_PASIEN]&tgl=$rows[TGL]&iduser_jual=$rows[USER_ID]');><img src='../icon/lihat.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Melihat Detail Penjualan'></a>";
		
		$cek = "";
		if($rows['VERIFIKASI']==1){
			$cek = "checked";
		}
		$verifikasi_resep = "<input type='checkbox' onclick=VerifikasiResep('{$par2}') id='chkVerResep_{$par2}' $cek />";
		$i++;
		$dt.=$id.chr(3).$i.chr(3).tglSQL($rows["TGL"]).chr(3).$rows["NO_PENJUALAN"].chr(3).$rows["KSO"].chr(3).$rows["NO_RESEP"].chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).$rows["NAMA"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["DOKTER"].chr(3).$rows["SHIFT"].chr(3).$rows["CARA_BAYAR"].chr(3).$rows["cbayar"].chr(3).$rows["UTANG"].chr(3).$rows["HARGA_NETTO"].chr(3).$rows["HARGA_TOTAL"].chr(3).$verifikasi_resep.chr(3).$edit." ".$hapus.chr(3).$lihat.chr(6);
	}
}
if($_REQUEST['grid']==2){
	while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["obat_nama"].chr(3).$rows["qty_jual"].chr(3).number_format($rows["harga_satuan"],2,",",".").chr(3).number_format($rows["sub_tot"],2,",",".").chr(6);        
	}
}
if($_REQUEST['grid']==3){
	while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$chk1="<input type='checkbox' id='cekbok$i' name='cekbok$i' value='$rows[NO_PENJUALAN]**$rows[UNIT_ID]**$rows[USER_ID]**$rows[NO_PASIEN]' />";
			$lihat="<a onclick=window.open('../../apotek/report/kwi_retur.php?no_penjualan=$rows[NO_PENJUALAN]&sunit=$rows[UNIT_ID]&no_pasien=$rows[NO_PASIEN]&tgl=$rows[TGL]&iduser_jual=$rows[USER_ID]');><img src='../icon/lihat.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Melihat Detail Penjualan'></a>";
            $dt .= $rows["USER_ID"].chr(3).$chk1.chr(3).number_format($i,0,",","").chr(3).$rows["tgl1"].chr(3).$rows["NO_PENJUALAN"].chr(3).$rows["NO_RESEP"].chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).$rows["cara_bayar"].chr(3).$rows["UNIT_NAME1"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["DOKTER"].chr(3).$rows["SHIFT"].chr(3).number_format($rows['HARGA_TOTAL'],0,",",".").chr(3).$lihat.chr(6);        
	}
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
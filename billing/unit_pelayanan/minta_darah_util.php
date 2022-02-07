<?php
session_start();
include("../koneksi/konek.php");
include("../sesi.php");

//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$id = $_REQUEST["id"];

$idkunjungan = $_REQUEST["idkunjungan"];
$idpelayanan = $_REQUEST["idpelayanan"];
$idpelayanan_inserted = $_REQUEST['idpelayanan_inserted'];
$idkso = $_REQUEST["idkso"];
$id_darah = $_REQUEST["id_darah"];
$id_golongan = $_REQUEST["id_golongan"];
$id_resus = $_REQUEST["id_resus"];
$id_kemasan = $_REQUEST["id_kemasan"];
$no_minta = $_REQUEST["no_minta"];
$sifat = $_REQUEST["sifat"];
$tgl = tglSQL($_REQUEST["tgl"]);
$jumlah = $_REQUEST["jumlah"];
$fdata = $_REQUEST['fdata'];
$id_dokter = $_REQUEST['id_dokter'];

$biayaRS = $_REQUEST["biayaRS"];
$biayaKSO = $_REQUEST["biayaKSO"];
$biayaPx = $_REQUEST["biayaPx"];
$alasan1 = $_REQUEST["alasan1"];
$petugas1 = $_REQUEST["petugas1"];
$rhesus = $_REQUEST["rhesus"];
$tgl_act = gmdate('Y-m-d H:i:s');
$user_act = $_SESSION['userId'];

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		if($sifat==3){
			$tgl_op=tglSQL($_REQUEST['tggl'])." ".$_REQUEST['jam'];;
		}
		$ardata=explode("**",$fdata);
		for ($i=0;$i<count($ardata)-1;$i++){
			$data=explode("|",$ardata[$i]);
			if($idkso==4 || $idkso==6){
				$biayaRS = $data[5] * $data[4];
				$biayaKSO = $data[3];
			}
			else{
				$biayaRS = $data[5] * $data[4];
				$biayaKSO = 0;
			}
			$biayaPx = $biayaRS - $biayaKSO;
			$sql="INSERT INTO $dbbank_darah.bd_permintaan_unit (kunjungan_id,pelayanan_id,pelayanan_id_bd,ms_darah_id,gol_darah_id,rhesus_id,kemasan_id,no_minta,sifat_minta,tgl_op,tgl,qty,biayaRS,biayaKSO,biayaPx,dokter_id,user_act,tgl_act,alasan,petugas,rhesus) VALUES ('$idkunjungan','$idpelayanan','$idpelayanan_inserted','$data[0]','$data[1]','$data[2]','$id_kemasan','$no_minta','$sifat','$tgl_op','$tgl','$data[4]','$biayaRS','$biayaKSO','$biayaPx','$id_dokter','$user_act',now(),'$alasan1','$petugas1','$rhesus')";
			$rs=mysql_query($sql);
			if($rs)
			{
				$sql1="INSERT INTO b_ms_formulir_permintaan_darah (
					pelayanan_id,
  					tgl,
  					alasan_transfusi,
  					petugas,
 					tgl_act,
  					user_act,
					no_minta,
					rhesus
					) 
					VALUES
  					(
					'$idpelayanan',
 					'$tgl',
  					'$alasan1',
 					'$petugas1',
 					 CURDATE(),
  					'$user_act',
					'$no_minta',
					'$rhesus'
  					) ;";
					$ex=mysql_query($sql1);
			}
			//if (mysql_errno()<=0){
				//$sql="UPDATE bd_penerimaan SET qty_stok=0 WHERE id='$data[0]'";
				//$rs1=mysql_query($sql);
			//}
		}
		if($rs){
			echo "<script>alert('Data Berhasil Ditambah');</script>";
		}else{
			echo "<script>alert('Gagal')</script>";
		}
    	break;
	case 'update':
		$ardata=explode("**",$fdata);
		for ($i=0;$i<count($ardata)-1;$i++){
			$data=explode("|",$ardata[$i]);
			if($idkso==4 || $idkso==6){
				$biayaRS = $data[5] * $data[4];
				$biayaKSO = $data[3];
			}
			else{
				$biayaRS = $data[5] * $data[4];
				$biayaKSO = 0;
			}
			$biayaPx = $biayaRS - $biayaKSO;
			if($data[6]==''){
				$sqlu="INSERT INTO $dbbank_darah.bd_permintaan_unit (kunjungan_id,pelayanan_id,pelayanan_id_bd,ms_darah_id,gol_darah_id,rhesus_id,kemasan_id,no_minta,sifat_minta,tgl_op,tgl,qty,biayaRS,biayaKSO,biayaPx,dokter_id,user_act,tgl_act,alasan,petugas,rhesus) VALUES ('$idkunjungan','$idpelayanan','$idpelayanan_inserted','$data[0]','$data[1]','$data[2]','$id_kemasan','$no_minta','$sifat','$tgl_op','$tgl','$data[4]','$biayaRS','$biayaKSO','$biayaPx','$id_dokter','$user_act',now(),'$alasan1','$petugas1','$rhesus')";
			}
			else{
				$sqlu="UPDATE $dbbank_darah.bd_permintaan_unit SET kunjungan_id='$idkunjungan',pelayanan_id='$idpelayanan',ms_darah_id='$data[0]',gol_darah_id='$data[1]',rhesus_id='$data[2]',kemasan_id='$id_kemasan',sifat_minta='$sifat',tgl_op='$tgl_op',tgl='$tgl',qty='$data[4]',biayaRS='$biayaRS',biayaKSO='$biayaKSO',biayaPx='$biayaPx',dokter_id='$id_dokter',user_act='$user_act',tgl_act=now(),alasan='$alasan1',petugas='$petugas1',rhesus='$rhesus' WHERE id='$data[6]'";
			}
			$rsu=mysql_query($sqlu);
			if($rsu)
			{
				$sql="UPDATE b_ms_formulir_permintaan_darah SET pelayanan_id='$idPel', 
		  		tgl='$tgl',
		  		alasan_transfusi='$alasan1',
		  		petugas='$petugas1',
		  		tgl_act= CURDATE(),
		  		user_act='$user_act',
				rhesus='$rhesus'
		  		WHERE no_minta='".$no_minta."'";
		echo $sql;
		$ex=mysql_query($sql);
			}
		}
		if($rsu){
			echo "<script>alert('Data Berhasil Diubah')</script>";
		}else{
			echo "<script>alert('Gagal')</script>";
		}
		break;
	case 'hapus':
		$sql3="DELETE FROM $dbbank_darah.bd_permintaan_unit WHERE id='".$id."'";
		$ex1 = mysql_query($sql3);
		if($ex1){
			$sql="DELETE FROM b_ms_formulir_permintaan_darah WHERE no_minta='$no_minta'";
			$ex=mysql_query($sql);
		}
		break;
}

if ($filter!="") {
$filter=explode("|",$filter);
$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") {
$sorting='id';
}

$sql="SELECT
  pu.id,
  pu.tgl,
  pu.dokter_id,
  pu.no_minta,
  pu.sifat_minta,
  pu.tgl_op,
  pu.qty,
  d.id              id_darah,
  d.kode,
  d.darah,
  d.biaya,
  d.biaya_askes,
  pu.alasan,
  pu.petugas,
  pu.rhesus
FROM $dbbank_darah.bd_permintaan_unit pu
  INNER JOIN $dbbank_darah.bd_ms_darah d
    ON pu.ms_darah_id = d.id
   WHERE pu.pelayanan_id='".$idpelayanan."' AND pu.pelayanan_id_bd='".$idpelayanan_inserted."'";

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

while ($rows=mysql_fetch_array($rs)) {
    $sisip=$rows["id"]."|".$rows["id_darah"]."|".$rows["id_goldar"]."|".$rows["id_resus"]."|".$rows["dokter_id"]."|".$rows["biaya"]."|".$rows["biaya_askes"]."|".$rows["sifat_minta"]."|".$rows["dokter_id"]."|".$rows["alasan"]."|".$rows["petugas"]."|".$rows["rhesus"];
    $i++;
    $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_minta"].chr(3).$rows["kode"].chr(3).$rows["darah"].chr(3).$rows["qty"].chr(6);
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
}else {
    header("Content-type: text/xml");
}

echo $dt;
?>

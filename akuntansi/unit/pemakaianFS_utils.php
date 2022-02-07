<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort=$dbbilling.".b_ms_unit.kode";
$defaultsortObat="TANGGAL";
$statusProses='Fine';
//===============================
$id_sak_Bank_BLUD=33;

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$tahun = $_REQUEST["tahun"];
$bulan = $_REQUEST["bulan"];
$tipe = $_REQUEST["tipe"];
$cmbSupplier = $_REQUEST["cmbSupplier"];
$kso = $_REQUEST["kso"];
$ksoAsli = $kso;
$tempat = $_REQUEST["tempat"];
$kasir = $_REQUEST["kasir"];
$posting = $_REQUEST["posting"];
$cmbFarmasi = $_REQUEST["cmbFarmasi"];
$noSlip = $_REQUEST["noSlip"];
$bayar = $_REQUEST["bayar"];
$act = $_REQUEST["act"];
$fdata = $_REQUEST["fdata"];
$tanggalAsli=$_REQUEST['tanggal'];
$tanggalan = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggalan[2].'-'.$tanggalan[1].'-'.$tanggalan[0];
$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tanggalAwal = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tanggalAkhir = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];

switch ($act){
	case "postingObatFS":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$tanggal=$cdata[1];
				$nokw="AK.FS.OBAT/".$tanggalAsli;
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,biayaRS_DPP_PPN,tgl_act,user_act) VALUES($id_cc_rv,'$tanggal',10,'$nokw',$cdata[2],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$id_cc_rv";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					
					$uraian="Pemakaian Floor Stock : ".$unit;
					
					$id_sak_biaya=562;
					//$id_sak_stok=68; // Persediaan Tindakan
					$id_sak_stok=67; // Persediaan Obat & Alkes
					$jenistrans_fs=78;
					
					//====insert pemakaian bahan====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_biaya,'$tanggal','$nokw','$uraian',$cdata[2],0,now(),$idUser,'D',0,$jenistrans_fs,$jenistrans_fs,1,'',$idunit,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$cdata[2],now(),$idUser,'K',0,$jenistrans_fs,$jenistrans_fs,1,'',0,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tipe=10 AND tgl_trans='$cdata[1]' AND id_cc_rv=$cdata[0]";
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$uraian="Pemakaian Floor Stock : ".$unit;				
				
				$sJ = "DELETE FROM jurnal WHERE TGL='$cdata[1]' AND URAIAN = '$uraian'";
				mysql_query($sJ);
				
			}
			$actPosting="Unposting";
		}
		break;
}

if($tempat==0){
	$fUnit = "";
}else{
	$fUnit = "AND ".$dbbilling.".b_ms_unit.parent_id = '".$tempat."'";
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else {
	switch ($grd){
		case "PemakaianFS":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 ORDER BY $sorting";
			break;
	}
	
    //echo $sql."<br>";
    $perpage = 100;
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql2=$sql." limit $tpage,$perpage";

    $rs=mysql_query($sql2);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    switch($grd){
		case "PemakaianFS":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$sql="SELECT * FROM ak_posting WHERE tipe=10 AND id_cc_rv='".$rows["id"]."' AND tgl_trans='$tanggal'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)<=0){
						$sqlJual="SELECT SUM(ap.QTY_SATUAN * IF(ap.NILAI_PAJAK=0,(ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))),1.1 * (ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))))) nBahan 
	FROM ".$dbapotek.".a_penerimaan ap INNER JOIN ".$dbapotek.".a_unit u ON ap.UNIT_ID_TERIMA=u.UNIT_ID WHERE u.kdunitfar='".$rows["kode"]."' AND ap.TIPE_TRANS=1 AND ap.TANGGAL = '$tanggal'";
						//echo $sqlJual."<br>";
						$rsJual=mysql_query($sqlJual);
						$rwJual=mysql_fetch_array($rsJual);
						$nBahan=$rwJual["nBahan"];
						if ($nBahan>0){
							$i++;
							$dt.=$rows["id"]."|".$tanggal.chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nBahan,0,",",".").chr(3)."0".chr(6);
						}
					}
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$sql="SELECT * FROM ak_posting WHERE tipe=10 AND id_cc_rv='".$rows["id"]."' AND tgl_trans='$tanggal'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)>0){
						$rwJual=mysql_fetch_array($rsCek);
						$nBahan=$rwJual["biayaRS_DPP_PPN"];
						if ($nBahan>0){
							$i++;
							$dt.=$rwJual["id_cc_rv"]."|".$rwJual["tgl_trans"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nBahan,0,",",".").chr(3)."0".chr(6);
						}
					}
				}
			}
			break;
    }

    //DARI FOLDER akuntansi_
	if ($dt!=$totpage.chr(5)) {
		if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
		}
		else if($actPosting=='Unverifikasi'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unverifikasi";
		}
		else{
			$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
		}
        $dt=str_replace('"','\"',$dt);
    }else{
		if($actPosting=='Unposting'){
			$dt="0".chr(5).chr(5)."Unposting";
		}
		else if($actPosting=='Unverifikasi'){
			$dt="0".chr(5).chr(5)."Unverifikasi";
		}
		else{
			$dt="0".chr(5).chr(5).$_REQUEST['act'];
		}
	}

	if ($grd=="penerimaanBillingKasir"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntotSlip,0,",",".").chr(3).number_format($ntot1,0,",",".");
	}elseif($grd=="pembelianObat"){
		$dt=$dt.chr(3).number_format($totdpp,2,",",".").chr(3).number_format($totppn,2,",",".").chr(3).number_format($totdppppn,2,",",".");
	}elseif($grd=="pengeluaranLain"){
		$dt=$dt.chr(3).number_format($totnilai,2,",",".");
	}

    mysql_free_result($rs);
}
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
 	header("Content-type: application/xhtml+xml");
}else{
 	header("Content-type: text/xml");
}

echo $dt;
?>
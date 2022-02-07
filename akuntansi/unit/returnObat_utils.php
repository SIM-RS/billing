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
	case "postingReturnJual":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$tanggal=$cdata[1];
				$nokw="AK.RET.OBAT/".$tanggalAsli;
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,tgl_act,user_act) VALUES($id_cc_rv,'$tanggal',5,'$nokw',$kso,$cdata[3],$cdata[2],now(),$idUser)";
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
					
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					//echo $sql."<br>";
					$rsCek=mysql_query($sql);
					$rwCek=mysql_fetch_array($rsCek);
					$uraian="Return Obat : ".$unit." - ".$rwCek["nama"];
					
					$id_sak_biaya=562;
					$id_sak_stok=67;
					$jenistrans_return=333;
					if ($kso==1){
						$id_sak=8;	//kas bendahara penerimaan
						$id_sak_pend=488;	//pendapatan pasien umum
						$jenistrans=5;	//pengurang pendapatan pasien umum sdh terbayar
					}elseif($kso==38 || $kso==39 || $kso==46 || $kso==53){
						$id_sak=46;	//piutang pasien ditanggung pemerintah
						$id_sak_pend=490;	//pendapatan pasien ditanggung pemerintah
						$jenistrans=17;
					}else{
						$id_sak=46;	//piutang pasien kso
						$id_sak_pend=490;	//pendapatan pasien kso
						$jenistrans=12;
					}
					
					//====insert pengurang pendapatan dr penjualan====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[2],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_pend,'$tanggal','$nokw','$uraian',$cdata[2],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					//====insert return pemakaian bahan====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_biaya,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans_return,$jenistrans_return,1,'',$idunit,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans_return,$jenistrans_return,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					/*if ($kso==1){
						$jenistrans_byr=74;
						//====insert pembayaran Obat====
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];

						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,8,'$tanggal','$nokw','$uraian',$cdata[2],0,now(),$idUser,'D',0,$jenistrans_byr,$jenistrans_byr,1,'',0,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[2],now(),$idUser,'K',0,$jenistrans_byr,$jenistrans_byr,1,'',$kso,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
					}*/
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tipe=5 AND id_kso_pbf_umum=$kso AND tgl_trans='$cdata[1]' AND id_cc_rv=$cdata[0]";
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
				//echo $sql."<br>";
				$rsCek=mysql_query($sql);
				$rwCek=mysql_fetch_array($rsCek);
				$uraian="Return Obat : ".$unit." - ".$rwCek["nama"];
				
				$sJ = "DELETE FROM jurnal WHERE TGL='$cdata[1]' AND URAIAN LIKE '$uraian%'";
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
		case "ReturnJualObat":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 $fUnit ORDER BY $sorting";
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
		case "ReturnJualObat":
			if ($posting==0){
				$fKso = "SELECT DISTINCT m.IDMITRA id,mkso.nama FROM ".$dbapotek.".a_mitra m INNER JOIN ".$dbbilling.".b_ms_kso mkso ON m.KODE_MITRA=mkso.kode WHERE mkso.id='".$kso."'";
				//echo $fKso."<br>";
				$rsKsoF=mysql_query($fKso);
				$rwKsoF=mysql_fetch_array($rsKsoF);
				
				while($rows=mysql_fetch_array($rs)){
					$sql="SELECT * FROM ak_posting WHERE tipe=5 AND id_cc_rv='".$rows["id"]."' AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)<=0){
						$sqlReturn="SELECT IFNULL(SUM(rp.nilai),0) AS nReturn,IFNULL(SUM(IF(ap.NILAI_PAJAK>0,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)) * 1.1,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)))),0) nHPP FROM (SELECT * FROM ".$dbapotek.".a_return_penjualan WHERE DATE(tgl_retur)='$tanggal') rp INNER JOIN ".$dbapotek.".a_penjualan p ON rp.idpenjualan=p.ID INNER JOIN ".$dbapotek.".a_unit u ON p.RUANGAN=u.UNIT_ID	INNER JOIN ".$dbapotek.".a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID WHERE u.kdunitfar='".$rows["kode"]."' AND p.KSO_ID='".$rwKsoF["id"]."'";
						//echo $sqlReturn."<br>";
						$rsReturn=mysql_query($sqlReturn);
						$rwReturn=mysql_fetch_array($rsReturn);
						$nReturn=$rwReturn["nReturn"];
						$nHPP=$rwReturn["nHPP"];
						if ($nReturn>0){
							//echo $sqlReturn."<br>";
							$i++;
							$dt.=$rows["id"]."|".$tanggal.chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nReturn,0,",",".").chr(3).number_format($nHPP,0,",",".").chr(3)."0".chr(6);
						}
					}
				}
			}else{
				while($rows=mysql_fetch_array($rs)){
					$sqlReturn="SELECT * FROM ak_posting WHERE tipe=5 AND id_cc_rv='".$rows["id"]."' AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
					$rsReturn=mysql_query($sqlReturn);
					if (mysql_num_rows($rsReturn)>0){
						$rwReturn=mysql_fetch_array($rsReturn);
						$nReturn=$rwReturn["biayaPx_PPN"];
						$nHPP=$rwReturn["biayaRS_DPP_PPN"];
						if ($nReturn>0){
							$i++;
							$dt.=$rwReturn["id_cc_rv"]."|".$rwReturn["tgl_trans"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nReturn,0,",",".").chr(3).number_format($nHPP,0,",",".").chr(3)."0".chr(6);
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
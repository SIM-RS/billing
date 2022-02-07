<?php
include("../koneksi/konek.php");
include('../sesi.php');
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
	case "postingKlaimKSO":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[4];
				$kso=$cdata[0];
				$nokw=$cdata[1];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,no_faktur,id_kso_pbf_umum,biayaKSO_DPP,tgl_act,user_act) VALUES($cdata[6],'$cdata[4]',14,'$cdata[1]','$cdata[2]',$cdata[0],$cdata[3],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======update keuangan.k_transaksi set posting=1========
					$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=1 WHERE id=$cdata[6]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
						//======insert into jurnal========						
						$sql="SELECT mt.* FROM ".$dbkeuangan.".k_ms_transaksi mt WHERE mt.id=$cdata[5]";
						//echo $sql."<br>";
						$rsTrans=mysql_query($sql);
						$rwTrans=mysql_fetch_array($rsTrans);
						
						$id_sak=$rwTrans["id_sak"];
						$jenistrans=$rwTrans["id_jenis_trans"];
						$uraian="Penerimaan Klaim KSO";
						
						$sql="SELECT kso.* FROM ".$dbbilling.".b_ms_kso kso WHERE kso.id=$cdata[0]";
						//echo $sql."<br>";
						$rsTrans=mysql_query($sql);

						if (mysql_num_rows($rsTrans)>0){
							$rwTrans=mysql_fetch_array($rsTrans);
							$uraian="Penerimaan Klaim KSO : ".$rwTrans["nama"];
						}
						
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						$no_psg=$rwPost["no_psg"];
						//=====insert into Kas==========
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$no_psg,8,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0,1)";
						$rsPost=mysql_query($sql);
							
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,1)";
						$rsPost=mysql_query($sql);
						//=====insert into bank==========
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0,1)";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$no_psg,8,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',0,1)";
						$rsPost=mysql_query($sql);
					}else{
						$statusProses='Error';
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);	
				$sDel="DELETE FROM
					   ak_posting 
					WHERE id_cc_rv = '$cdata[5]' 
					  AND tgl_trans = '$cdata[4]' 
					  AND no_bukti = '$cdata[1]' 
					  AND no_faktur = '$cdata[2]' 
					  AND id_kso_pbf_umum = '$cdata[0]' 
					  AND biayaKSO_DPP = '$cdata[3]'";
				mysql_query($sDel);
				
				$sUp="UPDATE ".$dbkeuangan.".k_transaksi SET posting=0 WHERE id=$cdata[5]";
				mysql_query($sUp);
				
				$sDel2="DELETE
					FROM
					  jurnal 
					WHERE TGL = '$cdata[4]' 
					  AND NO_KW = '$cdata[1]' 
					  AND (DEBIT = '$cdata[3]' OR KREDIT = '$cdata[3]')";
				mysql_query($sDel2);
			}
			$actPosting='Unposting';
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
		case "KlaimKSO":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$sql="SELECT t.*,DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tglk,kso.nama FROM ".$dbkeuangan.".k_transaksi t INNER JOIN ".$dbbilling.".b_ms_kso kso ON t.kso_id=kso.id WHERE t.id_trans=1 AND MONTH(t.tgl)=$bulan AND YEAR(t.tgl)=$tahun AND posting=0";
			}else{
				$sql="SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') AS tglk,kso.nama FROM ak_posting p INNER JOIN ".$dbbilling.".b_ms_kso kso ON p.id_kso_pbf_umum=kso.id WHERE p.tipe=14 AND MONTH(p.tgl_trans)=$bulan AND YEAR(p.tgl_trans)=$tahun";
			}
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
		case "ReturnPelayanan":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$dt.=$rows["tgl"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai"]."|".$rows["id"]."|".$rows["no_return"].chr(3).$i.chr(3).$rows["unit_nama"].chr(3).$rows["kso_nama"].chr(3).number_format($rows["nilai"],0,',','.').chr(3)."0".chr(6);
			}
			break;
		case "pendBilling":
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
						$biayaRS=$rows["biayaRS"];
						if ($kso==1){
							$biayaKSO=0;
							$biayaPx=$biayaRS;
							$biayaPx1=0;
						}else{
							$biayaKSO=$rows["biayaKSO"];
							$biayaPx1=$rows["biayaPx"];
							$biayaPx=0;
						}
						if ($rows["inap"]==1){
							$qInap="SELECT IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.tarip),0) biayaRS,IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.beban_kso),0) biayaKSO,
	IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.beban_pasien),0) biayaPx 
	FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,IF(DATE(t1.tgl_in)<'$tanggal','$tanggal',t1.tgl_in) tgl_in, 
	IF((DATE(t1.tgl_out)>'$tanggal' OR t1.tgl_out IS NULL),DATE_ADD('$tanggal',INTERVAL 1 DAY), 
	IF((DATEDIFF(t1.tgl_out,t1.tgl_in)=0 AND t1.status_out=0),DATE_ADD(t1.tgl_out,INTERVAL 1 DAY),t1.tgl_out)) AS tgl_out, 
	t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien,t1.status_out 
	FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out, t.tarip,t.beban_kso,
	t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
	FROM ".$dbbilling.".b_tindakan_kamar_ak t INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id 
	INNER JOIN ".$dbbilling.".b_kunjungan k ON k.id=p.kunjungan_id 
	WHERE p.unit_id='".$rows['id']."' AND t.tipe_pendapatan=0 AND DATE(t.tgl_in)<='$tanggal' AND (DATE(t.tgl_out) >='$tanggal' OR t.tgl_out IS NULL) 
	AND t.kso_id = '".$kso."' AND t.aktif=1) AS t1) AS t2";
							//echo $qInap."<br>";
							$sInap=mysql_query($qInap);
							$wInap=mysql_fetch_array($sInap);
							$biayaRS+=$wInap["biayaRS"];
							if ($kso==1){
								$biayaPx+=$wInap["biayaRS"];
							}else{
								$biayaKSO+=$wInap["biayaKSO"];
								$biayaPx1+=$wInap["biayaPx"];
							}
						}
						
						if ($biayaRS>0){
							$i++;
							$selisih=$biayaRS-($biayaKSO+$biayaPx+$biayaPx1);
							$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($biayaRS,0,",",".").chr(3).number_format($biayaPx,0,",",".").chr(3).number_format($biayaKSO,0,",",".").chr(3).number_format($biayaPx1,0,",",".").chr(3).number_format($selisih,0,",",".").chr(3)."0".chr(6);
						}
					//}
				}else{
						$biayaRS=$rows["biayaRS_DPP_PPN"];
						$biayaKSO=$rows["biayaKSO_DPP"];
						if ($kso==1){
							$biayaPx=$rows["biayaPx_PPN"];
							$biayaPx1=0;
						}else{
							$biayaPx1=$rows["biayaPx_PPN"];
							$biayaPx=0;
						}
						
						$i++;
						$selisih=$biayaRS-($biayaKSO+$biayaPx+$biayaPx1);
						$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($biayaRS,0,",",".").chr(3).number_format($biayaPx,0,",",".").chr(3).number_format($biayaKSO,0,",",".").chr(3).number_format($biayaPx1,0,",",".").chr(3).number_format($selisih,0,",",".").chr(3)."0".chr(6);
					//}
				}
			}
			break;
		case "pembelianObat":
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
					$i++;
					$dt.=$rows["PBF_ID"]."|".$rows["TANGGAL"]."|".$rows["noterima"]."|".$rows["nobukti"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["noterima"].chr(3).$rows["nobukti"].chr(3).$rows["no_spk"].chr(3).$rows["pbf_nama"].chr(3).number_format($rows['dpp'],2,",",".").chr(3).number_format($rows['ppn'],2,",",".").chr(3).number_format($rows['dppppn'],2,",",".").chr(3)."0".chr(6);
				}else{
					$i++;
					$dt.=$rows["id_kso_pbf_umum"]."|".$rows["tgl_trans"]."|".$rows["no_terima"]."|".$rows["no_faktur"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["no_terima"].chr(3).$rows["no_faktur"].chr(3).$rows["no_spk"].chr(3).$rows["pbf_nama"].chr(3).number_format($rows['biayaKSO_DPP'],2,",",".").chr(3).number_format($rows['biayaPx_PPN'],2,",",".").chr(3).number_format($rows['biayaRS_DPP_PPN'],2,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "penjualanObat":
			$sqlTot="SELECT IFNULL(SUM(tot.nJual),0) totJual,IFNULL(SUM(tot.nSlip),0) totSlip,IFNULL(SUM(tot.nBahan),0) totBahan FROM (".$sql.") AS tot";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$ntot=$rwTot["totJual"];
			$ntot1=$rwTot["totBahan"];
			$ntotSlip=$rwTot["totSlip"];
			
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$nJual=$rows["nJual"];
				$bJual=$rows["nBahan"];
				$nSlip=$rows["nSlip"];
				$cidBilling=$rows["unit_billing"];
				//if ($cidBilling==0) $cidBilling=126;
				$cid=$cidBilling."|".$rows["kso_id_billing"]."|".$rows["CARABAYAR_ID"]."|".$rows["id"]."|".$rows["SHIFT"]."|".$rows["tgl_klaim"]."|".$rows["no_slip"]."|".$nJual."|".$bJual."|".$nSlip;
				$dt.=$cid.chr(3).$i.chr(3).$rows["tgl_slip"].chr(3).$rows["no_slip"].chr(3).$rows["KSO_NAMA"].chr(3).$rows["cara_bayar"].chr(3).$rows["nama"].chr(3).$rows["SHIFT"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($nSlip,0,",",".").chr(3).number_format($bJual,0,",",".").chr(3)."0".chr(6);
			}
			break;
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
						$rsReturn=mysql_query($sqlReturn);
						$rwReturn=mysql_fetch_array($rsReturn);
						$nReturn=$rwReturn["nReturn"];
						$nHPP=$rwReturn["nHPP"];
						if ($nReturn>0){
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
		case "ReturnPBF":
			while($rows=mysql_fetch_array($rs)){
				$i++;
				$dt.=$rows["id"]."|".$rows["TGL_TRANS"]."|".$rows["PBF_ID"]."|".$rows["KEPEMILIKAN_ID"].chr(3).$i.chr(3).$rows["PBF_NAMA"].chr(3).$rows["TGL"].chr(3).$rows["NO_RETUR"].chr(3).$rows["tglfaktur"].chr(3).$rows["NOBUKTI"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["QTY"].chr(3).number_format($rows["aharga"],0,",",".").chr(3).number_format(floor($rows["QTY"]*$rows["aharga"]),0,",",".").chr(3).$rows["KET"].chr(3)."0".chr(6);
			}
			break;
		case "penerimaanBilling":
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
					$sql="SELECT * FROM ak_posting WHERE tipe=2 AND id_cc_rv=".$rows["id"]." AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)<=0){
						$qJml="SELECT IFNULL(SUM(bbt.nilai),0) AS nilai 
	FROM (SELECT * FROM ".$dbbilling.".b_bayar WHERE tgl='$tanggal') bb INNER JOIN ".$dbbilling.".b_bayar_tindakan bbt ON bb.id=bbt.bayar_id 
	INNER JOIN ".$dbbilling.".b_tindakan_ak btak ON bbt.tindakan_id=btak.b_tindakan_id
	INNER JOIN ".$dbbilling.".b_pelayanan bp ON btak.pelayanan_id=bp.id
	WHERE btak.kso_id='".$kso."' AND bbt.tipe=0 AND btak.tipe_pendapatan=0 AND bp.unit_id='".$rows["id"]."'";
						$sJml=mysql_query($qJml);
						$wJml=mysql_fetch_array($sJml);
						$nilai=$wJml["nilai"];
						if ($rows["inap"]==1){
							$qInap="SELECT IFNULL(SUM(bbt.nilai),0) AS nilai 
	FROM (SELECT * FROM ".$dbbilling.".b_bayar WHERE tgl='$tanggal') bb INNER JOIN ".$dbbilling.".b_bayar_tindakan bbt ON bb.id=bbt.bayar_id 
	INNER JOIN ".$dbbilling.".b_tindakan_kamar_ak btak ON bbt.tindakan_id=btak.b_tindakan_kamar_id
	INNER JOIN ".$dbbilling.".b_pelayanan bp ON btak.pelayanan_id=bp.id
	WHERE btak.kso_id='".$kso."' AND bbt.tipe=1 AND btak.tipe_pendapatan=0 AND bp.unit_id='".$rows["id"]."'";
							//echo $qInap."<br>";
							$sInap=mysql_query($qInap);
							$wInap=mysql_fetch_array($sInap);
							$nilai+=$wInap["nilai"];
						}
						
						if ($nilai>0){
							$i++;
							$dt.=$rows["id"]."|".$tanggal.chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
						}
					}
				}else{
					$nilai=$rows["biayaPx_PPN"];
					
					$i++;
					$dt.=$rows["id_cc_rv"]."|".$rows["tgl_trans"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "penerimaanBillingKasir":
			$ntot=0;
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
					$sql="SELECT * FROM ak_posting WHERE tipe=17 AND id_cc_rv=".$rows["unit_id"]." AND id_kso_pbf_umum=".$rows["kso_id"]." AND tgl_trans='$tanggal' AND no_terima='".$rows["user_act"]."'";
					$rs1=mysql_query($sql);
					if (mysql_num_rows($rs1)<=0){
						$i++;
						$nilai=$rows["nilai"];
						$ntot+=$nilai;
						$dt.=$rows["user_act"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai"].chr(3).$i.chr(3).$rows["unit"].chr(3).$rows["kso"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
					}
				}else{
					$nilai=$rows["biayaPx_PPN"];
					$ntot+=$nilai;
					$i++;
					$dt.=$rows["no_terima"]."|".$rows["id_cc_rv"]."|".$rows["id_kso_pbf_umum"]."|".$nilai.chr(3).$i.chr(3).$rows["unit"].chr(3).$rows["kso"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "PenerimaanBillingManual":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					//if ($tipe=="") $idkso=$rows["kso_id"];
					$dt.=$rows["id"]."|".$rows["tgl"]."|".$rows["kso_id"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["biayaPx_PPN"];
					
					$i++;
					$dt.=$rows["id"]."|".$rows["id_cc_rv"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "KlaimKSO":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					
					/*$sql="SELECT * FROM ak_posting WHERE tipe=14 AND no_bukti='".$rows["no_bukti"]."' AND no_faktur='".$rows["no_faktur"]."' AND id_kso_pbf_umum='".$rows["kso_id"]."' AND tgl_trans='".$rows["tgl"]."'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)<=0){*/
						$i++;
						$dt.=$rows["kso_id"]."|".$rows["tgl"]."|".$rows["id_trans"]."|".$rows["id"]."|".$rows["no_bukti"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["no_faktur"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
					//}
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["biayaKSO_DPP"];
					
					$i++;
					$dt.=$rows["id_kso_pbf_umum"]."|".$rows["tgl_trans"]."|".$rows["id_cc_rv"]."|".$rows["no_bukti"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["no_faktur"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "PenerimaanLain":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					//if ($tipe=="") $idkso=$rows["kso_id"];
					$dt.=$rows["id"]."|".$rows["tgl"]."|".$rows["id_trans"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["biayaRS_DPP_PPN"];
					
					$i++;
					$dt.=$rows["id_kt"]."|".$rows["tgl_trans"]."|".$rows["id_trans"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "HapusObat":
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$dt.=$rows['TGL_HAPUS']."|".$rows['OBAT_ID']."|".$rows['nilai']."|".$rows['ID_HAPUS'].chr(3).$i.chr(3).date("d/m/Y",strtotime($rows['TGL_HAPUS'])).chr(3).$rows["NO_HAPUS"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["NAMA"].chr(3).$rows["QTY"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows["ALASAN"].chr(3)."0".chr(6);
			}
			break;
		case "PengurangPendBilling":
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
					$sql="SELECT * FROM ak_posting WHERE $ftipeByr AND id_cc_rv=".$rows["id"]." AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
					$rsCek=mysql_query($sql);
					if (mysql_num_rows($rsCek)<=0){
						$qJml="SELECT IFNULL(SUM(t.qty*t.biaya),0) AS biayaRS,IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO,IFNULL(SUM(t.qty*t.biaya_pasien),0) AS biayaPx 
			FROM ".$dbbilling.".b_tindakan_ak t INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id WHERE t.kso_id='".$kso."' AND t.tipe_pendapatan='1' $fbayar AND t.tgl='$tanggal' AND p.unit_id='".$rows["id"]."'";
						$sJml=mysql_query($qJml);
						$wJml=mysql_fetch_array($sJml);
						$biayaRS=$wJml["biayaRS"];
						if ($kso==1){
							$biayaKSO=0;
							$biayaPx=$biayaRS;
							$biayaPx1=0;
						}else{
							$biayaKSO=$wJml["biayaKSO"];
							$biayaPx1=$wJml["biayaPx"];
							$biayaPx=0;
						}
						if ($rows["inap"]==1){
							$qInap="SELECT IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.tarip),0) biayaRS,IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.beban_kso),0) biayaKSO,
	IFNULL(SUM(IF(DATEDIFF(t2.tgl_out,t2.tgl_in)<0,0,DATEDIFF(t2.tgl_out,t2.tgl_in))*t2.beban_pasien),0) biayaPx 
	FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,IF(DATE(t1.tgl_in)<'$tanggal','$tanggal',t1.tgl_in) tgl_in, 
	IF((DATE(t1.tgl_out)>'$tanggal' OR t1.tgl_out IS NULL),DATE_ADD('$tanggal',INTERVAL 1 DAY), 
	IF((DATEDIFF(t1.tgl_out,t1.tgl_in)=0 AND t1.status_out=0),DATE_ADD(t1.tgl_out,INTERVAL 1 DAY),t1.tgl_out)) AS tgl_out, 
	t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien,t1.status_out 
	FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out, t.tarip,t.beban_kso,
	t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
	FROM ".$dbbilling.".b_tindakan_kamar_ak t INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id 
	INNER JOIN ".$dbbilling.".b_kunjungan k ON k.id=p.kunjungan_id 
	WHERE p.unit_id='".$rows['id']."' AND t.tipe_pendapatan='1' $fbayar AND DATE(t.tgl_in)<='$tanggal' AND (DATE(t.tgl_out) >='$tanggal' OR t.tgl_out IS NULL) 
	AND t.kso_id = '".$kso."' AND t.aktif=1) AS t1) AS t2";
							//echo $qInap."<br>";
							$sInap=mysql_query($qInap);
							$wInap=mysql_fetch_array($sInap);
							$biayaRS+=$wInap["biayaRS"];
							if ($kso==1){
								$biayaPx+=$wInap["biayaRS"];
							}else{
								$biayaKSO+=$wInap["biayaKSO"];
								$biayaPx1+=$wInap["biayaPx"];
							}
						}
						
						if ($biayaRS>0){
							$i++;
							$selisih=$biayaRS-($biayaKSO+$biayaPx+$biayaPx1);
							$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($biayaRS,0,",",".").chr(3).number_format($biayaPx,0,",",".").chr(3).number_format($biayaKSO,0,",",".").chr(3).number_format($biayaPx1,0,",",".").chr(3).number_format($selisih,0,",",".").chr(3)."0".chr(6);
						}
					}
				}else{
					$biayaRS=$rows["biayaRS_DPP_PPN"];
					$biayaKSO=$rows["biayaKSO_DPP"];
					if ($kso==1){
						$biayaPx=$rows["biayaPx_PPN"];
						$biayaPx1=0;
					}else{
						$biayaPx1=$rows["biayaPx_PPN"];
						$biayaPx=0;
					}
					
					$i++;
					$selisih=$biayaRS-($biayaKSO+$biayaPx+$biayaPx1);
					$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($biayaRS,0,",",".").chr(3).number_format($biayaPx,0,",",".").chr(3).number_format($biayaKSO,0,",",".").chr(3).number_format($biayaPx1,0,",",".").chr(3).number_format($selisih,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "pengeluaranLain":
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$cket="";
				if ($rows['unit_id']!=0) $cket=" - ".$rows['nama_tl'];
				
				$detail="";
				$ntot=0;
				//if ($rows["id_trans"]==8 || $rows["id_trans"]==9 || $rows["id_trans"]==10 || $rows["id_trans"]==15){
					$sql2="SELECT * FROM $dbkeuangan.k_transaksi_detail td WHERE td.transaksi_id=".$rows["id"]." AND pajak_id=0";
					$rsdetail=mysql_query($sql2);
					while ($rwdetail=mysql_fetch_array($rsdetail)){
						$detail .="#".$rwdetail["unit_id"]."*".number_format($rwdetail["nilai"],0,",",".");
						$ntot +=$rwdetail["nilai"];
					}
				//}
				
				$dt.=$rows["id"]."|".$rows["id_trans"]."|".$detail."|".number_format($ntot,0,",",".")."|".$rows['no_bukti']."|".$rows['tgl'].chr(3).$i.chr(3).date("d/m/Y",strtotime($rows['tgl'])).chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows["ket"].$cket.chr(3)."0".chr(6);
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

/*
//LAWAS
    if ($dt!=$totpage.chr(5)) {
		if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
		}
		else{
        	$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
		}
        $dt=str_replace('"','\"',$dt);
    }else{
		if($actPosting=='Unposting'){
			$dt="0".chr(5).chr(5)."Unposting";
		}
		else{
			$dt="0".chr(5).chr(5).$_REQUEST['act'];
		}
	}
*/	
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
<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort="$dbbilling.b_ms_unit.kode";
$defaultsortObat="TANGGAL";
$statusProses='Fine';
//===============================

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$grd1 = $_REQUEST["grd1"];
$grd2 = $_REQUEST["grd2"];
$grd3 = $_REQUEST["grd3"];
$grd4 = $_REQUEST["grd4"];
$kso = $_REQUEST["kso"];
$tempat = $_REQUEST["tempat"];
$posting = $_REQUEST["posting"];
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
	case "postingBilling":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$biayaPx=($kso==1)?$cdata[2]:$cdata[4];
				$sql="INSERT INTO ak_posting(tgl_trans,tipe,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act) VALUES('$tanggal',1,$cdata[0],$kso,$cdata[1],$biayaPx,$cdata[3],now(),$idUser)";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM $dbbilling.b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Pendapatan ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$nokw="$kdunit/$tanggalAsli/$kdkso";
					
					$iurPx=($kso==1)?$cdata[2]:$cdata[4];
					
					$selisih=$cdata[1]-($cdata[2]+$cdata[3]+$cdata[4]);
					if ($selisih>=0){
						$jenistrans=10;
						$cselisih=$selisih;
						$cselisihD=$cselisih;
						$cselisihK=0;
						$dk='D';
					}else{
						$jenistrans=11;
						$cselisih = -1 * $selisih;
						$cselisihD=0;
						$cselisihK=$cselisih;
						$dk='K';
					}
					
					$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,490,'$tanggal','$nokw','$uraian',0,$cdata[1],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit)";
					$rsPost=mysql_query($sql);
					if ($cdata[3]>0){
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,46,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso)";
						$rsPost=mysql_query($sql);
					}
					if ($iurPx>0){
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,45,'$tanggal','$nokw','$uraian',$iurPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso)";
						$rsPost=mysql_query($sql);
					}
					if ($cselisih>0){
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,491,'$tanggal','$nokw','$uraian',$cselisihD,$cselisihK,now(),$idUser,'$dk',0,$jenistrans,$jenistrans,1,'',$cdata[0])";
						$rsPost=mysql_query($sql);
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
		}
		break;
	case "postingBeliObat":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$sql="SELECT data.KEPEMILIKAN_ID,SUM(data.dpp) AS dpp, SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn FROM (SELECT ((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,a_p.KEPEMILIKAN_ID FROM (SELECT * FROM $dbapotek.a_penerimaan WHERE TIPE_TRANS=0 AND PBF_ID=$cdata[0] AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]') AS a_p) AS data";
				//echo $sql."<br>";
				$rsBeli=mysql_query($sql);
				if ($rwBeli=mysql_fetch_array($rsBeli)){
					$biayaRS=$rwBeli["dppppn"];
					$biayaPx=$rwBeli["ppn"];
					$biayaKSO=$rwBeli["dpp"];
					$kpid=$rwBeli["KEPEMILIKAN_ID"];
					$sql="INSERT INTO ak_posting(tgl_trans,no_terima,no_faktur,tipe,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act) VALUES('$cdata[1]','$cdata[2]','$cdata[3]',3,0,$cdata[0],$biayaRS,$biayaPx,$biayaKSO,now(),$idUser)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
						$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=$cdata[0]";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$pbfNama=$rwPost["PBF_NAMA"];
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						
						$fksak=67;
						$jenistrans=23;
						if ($kpid==5){
							$fksak=68;
							$jenistrans=29;
						}
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,$fksak,'$cdata[1]','$cdata[3]','$pbfNama',$biayaRS,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$sql="INSERT INTO jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
	VALUES($notrans,378,'$cdata[1]','$cdata[3]','$pbfNama',0,$biayaRS,now(),$idUser,'K',0,23,23,1,'',$cdata[0])";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
					}else{
						$statusProses='Error';
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
		}
		break;
}

if($tempat==0){
	$fUnit = "";
}else{
	$fUnit = "AND $dbbilling.b_ms_unit.parent_id = '".$tempat."'";
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else {
    if($grd == "true") {
		if ($filter!="") {
			$filter=explode("|",$filter);
			$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
		}
		if ($sorting=="") {
			$sorting=$defaultsort;
		}
		if ($posting==0){
        	$sql="SELECT $dbbilling.b_ms_unit.* FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.aktif=1 and $dbbilling.b_ms_unit.kategori=2 and $dbbilling.b_ms_unit.level=2 ".$fUnit.$filter." ORDER BY $sorting";
		}else{
        	$sql="SELECT p.*,mu.nama FROM ak_posting p INNER JOIN $dbbilling.b_ms_unit mu ON p.id_cc_rv=mu.id WHERE tipe=1 AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
		}
    }elseif($grd1 == "true"){
		if ($filter!="") {
			$filter=explode("|",$filter);
			$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
		}
		if ($sorting=="") {
			$sorting=$defaultsortObat;
		}
		if ($posting==0){
			$sql="SELECT b.*,c.id FROM (SELECT data.PBF_ID,data.TANGGAL,data.tgl1, data.noterima, data.nobukti, data.pbf_nama, SUM(data.dpp) AS dpp, 
SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn 
FROM (SELECT a_p.*,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,
a_p.HARGA_KEMASAN*QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA 
FROM $dbapotek.a_penerimaan a_p INNER JOIN $dbapotek.a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN $dbapotek.a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
INNER JOIN $dbapotek.a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID 
WHERE a_p.TIPE_TRANS=0 AND a_p.TANGGAL BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS data GROUP BY data.nobukti, data.noterima) AS b
LEFT JOIN (SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d/%m/%Y') AS tgl1,pbf.PBF_NAMA 
FROM ak_posting p INNER JOIN $dbapotek.a_pbf pbf ON p.id_kso_pbf_umum=pbf.PBF_ID 
WHERE p.tipe=3 AND p.tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS c ON (b.noterima=c.no_terima AND b.nobukti=c.no_faktur AND b.TANGGAL=c.tgl_trans)
WHERE id IS NULL".$filter." ORDER BY ".$sorting;
		}else{
			$sql="SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d/%m/%Y') as tgl1,pbf.PBF_NAMA FROM ak_posting p INNER JOIN $dbapotek.a_pbf pbf ON p.id_kso_pbf_umum=pbf.PBF_ID WHERE p.tipe=3 AND p.tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
		}
    }elseif($grd2 == "true"){
        $sql = "SELECT $dbbilling.b_ms_unit.* FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.aktif=1 and $dbbilling.b_ms_unit.kategori=2 and $dbbilling.b_ms_unit.level=2 $fUnit ORDER BY $sorting";
    }elseif($grd3 == "true"){
        $sql = "SELECT $dbbilling.b_ms_unit.* FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.aktif=1 and $dbbilling.b_ms_unit.kategori=2 and $dbbilling.b_ms_unit.level=2 $fUnit ORDER BY $sorting";
    }elseif($grd4 == "true"){
        $sql = "SELECT DATE_FORMAT(ar.TGL,'%d-%m-%Y') AS TGL, ar.NO_RETUR, ar.NO_FAKTUR, ar.QTY, ar.KET, DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tglfaktur,FLOOR(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,
        ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI 
FROM $dbapotek.a_penerimaan_retur ar INNER JOIN $dbapotek.a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
INNER JOIN $dbapotek.a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN $dbapotek.a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
INNER JOIN $dbapotek.a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN $dbapotek.a_kepemilikan k 
ON ar.KEPEMILIKAN_ID = k.ID 
WHERE ar.TGL BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
    } 

    //echo $sql."<br>";
    $perpage = 100;
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs).'<br>';
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";


    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            
			if ($posting==0){
				$sql="SELECT * FROM ak_posting WHERE tipe=1 AND id_cc_rv=".$rows["id"]." AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
				$rsCek=mysql_query($sql);
				if (mysql_num_rows($rsCek)<=0){
					$qJml="SELECT IFNULL(SUM(t.qty*t.biaya),0) AS biayaRS,IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO,IFNULL(SUM(t.qty*t.biaya_pasien),0) AS biayaPx 
		FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id WHERE t.kso_id='".$kso."' AND t.tgl='$tanggal' AND p.unit_id='".$rows["id"]."'";
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
FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id 
WHERE p.unit_id='".$rows['id']."' AND DATE(t.tgl_in)<='$tanggal' AND (DATE(t.tgl_out) >='$tanggal' OR t.tgl_out IS NULL) 
AND p.kso_id = '".$kso."' AND t.aktif=1) AS t1) AS t2";
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
    }elseif($grd1 == "true"){
        while ($rows=mysql_fetch_array($rs)) {
			if ($posting==0){
            	$i++;
            	$dt.=$rows["PBF_ID"]."|".$rows["TANGGAL"]."|".$rows["noterima"]."|".$rows["nobukti"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["noterima"].chr(3).$rows["nobukti"].chr(3).$rows["pbf_nama"].chr(3).number_format($rows['dpp'],2,",",".").chr(3).number_format($rows['ppn'],2,",",".").chr(3).number_format($rows['dppppn'],2,",",".").chr(3)."0".chr(6);
			}else{
            	$i++;
            	$dt.=$rows["id"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["no_terima"].chr(3).$rows["no_faktur"].chr(3).$rows["PBF_NAMA"].chr(3).number_format($rows['biayaKSO_DPP'],2,",",".").chr(3).number_format($rows['biayaPx_PPN'],2,",",".").chr(3).number_format($rows['biayaRS_DPP_PPN'],2,",",".").chr(3)."0".chr(6);
			}
        }
    }elseif($grd2 == "true"){
		$fKso = "SELECT DISTINCT m.IDMITRA id,mkso.nama FROM $dbapotek.a_mitra m INNER JOIN $dbbilling.b_ms_kso mkso ON m.KODE_MITRA=mkso.kode WHERE mkso.id='".$kso."'";
		$rsKsoF=mysql_query($fKso);
		$rwKsoF=mysql_fetch_array($rsKsoF);
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $sqlJual="SELECT SUM(p.SUB_TOTAL) AS nJual,SUM(p.QTY_JUAL * IF(ap.NILAI_PAJAK=0,(ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))),1.1 * (ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))))) nBahan 
            FROM $dbapotek.a_penjualan p INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID WHERE u.kdunitfar='".$rows["kode"]."' AND p.KSO_ID='".$rwKsoF["id"]."' AND p.TGL = '$tanggal'";
			//echo $sqlJual."<br>";
			$rsJual=mysql_query($sqlJual);
			$rwJual=mysql_fetch_array($rsJual);
			$nJual=$rwJual["nJual"];
			$bJual=$rwJual["nBahan"];

			$sqlRet="SELECT IFNULL(SUM(ar.qty_retur * ar.nilai),0) AS nReturn,IFNULL(SUM(ar.qty_retur * IF(ap.NILAI_PAJAK=0,(ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))),1.1 * (ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100))))),0) nBahan 
FROM $dbapotek.a_penjualan p INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID 
INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID INNER JOIN $dbapotek.a_return_penjualan ar ON p.ID=ar.idpenjualan
WHERE u.kdunitfar='".$rows["kode"]."' AND p.KSO_ID='".$rwKsoF["id"]."' AND DATE(ar.tgl_retur)='$tanggal'";
			//echo $sqlRet."<br>";
			$rsRet=mysql_query($sqlRet);
			$rwRet=mysql_fetch_array($rsRet);
			$nRet=$rwRet["nReturn"];
			$bRet=$rwRet["nBahan"];
            $selisihN=$nJual-$nRet;
            $selisihB=$bJual-$bRet;
            $dt.=chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($bJual,0,",",".").chr(3).number_format($nReturn,0,",",".").chr(3).number_format($bReturn,0,",",".").chr(3).number_format($selisihN,0,",",".").chr(3).number_format($selisihB,0,",",".").chr(3)."0".chr(6);
        }
    }elseif($grd3 == "true"){
        while($rows=mysql_fetch_array($rs)){
            $i++;
            $sqlReturn="SELECT IFNULL(SUM(rp.nilai),0) AS nReturn,
            IFNULL(SUM(IF(ap.NILAI_PAJAK>0,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)) * 1.1,rp.qty_retur*ap.HARGA_BELI_SATUAN * (1-(ap.DISKON/100)))),0) nHPP FROM (SELECT * FROM $dbapotek.a_return_penjualan WHERE DATE(tgl_retur)='$tanggal') rp 
            INNER JOIN $dbapotek.a_penjualan p ON rp.idpenjualan=p.ID INNER JOIN $dbapotek.a_unit u ON p.RUANGAN=u.UNIT_ID
            INNER JOIN $dbapotek.a_penerimaan ap ON p.PENERIMAAN_ID=ap.ID
            WHERE u.kdunitfar='".$rows["kode"]."'";
			$rsReturn=mysql_query($sqlReturn);
			$rwReturn=mysql_fetch_array($rsReturn);
			$nReturn=$rwReturn["nReturn"];
			$nHPP=$rwReturn["nHPP"];
            $dt.=chr(3).$i.chr(3).$rows["nama"].chr(3).number_format($nReturn,0,",",".").chr(3).number_format($nHPP,0,",",".").chr(3)."0".chr(6);
        }
    }elseif($grd4 == "true"){
        while($rows=mysql_fetch_array($rs)){
            $i++;
            $dt.=chr(3).$i.chr(3).$rows["PBF_NAMA"].chr(3).$rows["TGL"].chr(3).$rows["NO_RETUR"].chr(3).$rows["tglfaktur"].chr(3).$rows["NOBUKTI"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["QTY"].chr(3).number_format($rows["aharga"],0,",",".").chr(3).number_format(floor($rows["QTY"]*$rows["aharga"]),0,",",".").chr(3).$rows["KET"].chr(3)."0".chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
        $dt=str_replace('"','\"',$dt);
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
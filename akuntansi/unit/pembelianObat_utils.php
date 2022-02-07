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
	case "postingBeliObat":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$sql="SELECT data.KEPEMILIKAN_ID,data.NOKIRIM,data.BATCH,SUM(data.dpp) AS dpp, SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn FROM (SELECT ((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,a_p.KEPEMILIKAN_ID,a_p.NOKIRIM,a_p.BATCH FROM (SELECT * FROM ".$dbapotek.".a_penerimaan WHERE TIPE_TRANS=0 AND PBF_ID=$cdata[0] AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]') AS a_p) AS data";
				//echo $sql."<br>";
				$rsBeli=mysql_query($sql);
				if ($rwBeli=mysql_fetch_array($rsBeli)){
					$biayaRS=$rwBeli["dppppn"];
					$biayaPx=$rwBeli["ppn"];
					$biayaKSO=$rwBeli["dpp"];
					$kpid=$rwBeli["KEPEMILIKAN_ID"];
					$no_spk=$rwBeli["BATCH"];
					$no_faktur=$rwBeli["NOKIRIM"];

					$sql="UPDATE ".$dbapotek.".a_penerimaan SET BAYAR=1 WHERE TIPE_TRANS=0 AND PBF_ID='$cdata[0]' AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]'";
					//echo $sql."<br>";
					$rsUpdate=mysql_query($sql);
					
					$fjenis=0;
					if ($tipe==2){
						$fjenis=2;
					}
					$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,no_bukti,no_terima,no_faktur,tipe,jenis,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act,flag) VALUES('$cdata[1]','$no_spk','$cdata[2]','$cdata[3]',3,$fjenis,0,$cdata[0],$biayaRS,$biayaPx,$biayaKSO,now(),$idUser,$flag)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
						$ak_posting_id=mysql_insert_id();
						$sql="SELECT * FROM ".$dbapotek.".a_pbf WHERE PBF_ID=$cdata[0]";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$pbfNama=$rwPost["PBF_NAMA"];
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						//$no_psg=$rwPost["no_psg"];
						$no_psg=1;
						$no_psg2=$no_psg;
						
						$fksak=238;	//108.03.00.00 - Persediaan - Obat dan Alat Medis/RSP
						$fksak_ppn_masukan=256;	//110.01.00.00 - PPN Masukan yg dpt Dikreditkan - Pembelian
						$fksak_hutang_ppn=1243;	//424.04.01.00 - Hutang Pajak Lainnya - PPN Masukan / WAPU Dapat Dikreditkan
						$jenistrans=20;
						$k_sak=1071;	//401.01.11.01 - Hutang Usaha - Swasta - Eksploitasi IDR
						/*if ($kpid==5){
							$fksak=238;
							$jenistrans=20;
						}*/
						
						$uraian="Pembelian Obat : $no_faktur/$no_spk - $pbfNama";
						//=========Obat Hibah blm disesuaikan dgn COA==========
						if ($tipe==2){
							$jenistrans=20;
							$k_sak=378;
							if ($pbfNama!=""){
								$uraian="Penerimaan Hibah : ".$pbfNama;
							}else{
								$uraian="Penerimaan Hibah";
							}
						}
						
						if ($biayaPx<=0){
							$biayaKSO=$biayaRS*10/11;
							$biayaKSO_Str=number_format($biayaKSO,2,".","");
							$biayaKSO=floatval($biayaKSO_Str);
							$biayaPx=$biayaRS-$biayaKSO;
						}
						
						$nHutang=$biayaRS;
						if ($biayaRS > 10000000){
							$nHutang=$biayaKSO;
							$no_psg2=$no_psg+1;
						}
						
						//==========Posting Persediaan===========
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING,flag) 
	VALUES($ak_posting_id,$notrans,$no_psg,$fksak,'$cdata[1]','$cdata[3]','$uraian',$biayaKSO,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_spk',$cdata[0],1,$flag)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						//==========Posting PPN Masukan===========
						//if ($biayaPx>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING,flag) 
		VALUES($ak_posting_id,$notrans,$no_psg2,$fksak_ppn_masukan,'$cdata[1]','$cdata[3]','$uraian',$biayaPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_spk',$cdata[0],1,$flag)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						//}
						
						//==========Posting Hutang Usaha===========
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,PBF_ID,POSTING,flag) 
	VALUES($ak_posting_id,$notrans,$no_psg,$k_sak,'$cdata[1]','$cdata[3]','$uraian',0,$nHutang,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_spk',$cdata[0],$cdata[0],1,$flag)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						if ($biayaRS > 10000000){
							//==========Posting Hutang PPN===========
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING,flag) 
		VALUES($ak_posting_id,$notrans,$no_psg2,$fksak_hutang_ppn,'$cdata[1]','$cdata[3]','$uraian',0,$biayaPx,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_spk',$cdata[0],1,$flag)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}
					}else{
						$statusProses='Error';
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				
				$sDel = "DELETE 
						FROM
						  $dbakuntansi.ak_posting 
						WHERE tgl_trans = '".$cdata[1]."' 
						  AND no_terima = '".$cdata[2]."' 
						  AND no_faktur = '".$cdata[3]."'
						  AND id_kso_pbf_umum = '".$cdata[0]."'";
				mysql_query($sDel);
				
				$sJ = "UPDATE ".$dbapotek.".a_penerimaan SET BAYAR=0 WHERE TIPE_TRANS=0 AND PBF_ID='$cdata[0]' AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]'";
				mysql_query($sJ);
				
				$sJ = "DELETE FROM $dbakuntansi.jurnal WHERE TGL = '".$cdata[1]."' AND NO_KW='".$cdata[3]."'";
				mysql_query($sJ);
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
		case "pembelianObat":
			if ($sorting=="") {
				$sorting=$defaultsortObat;
			}
			if ($posting==0){
				if ($filter!="") {
					$filter=explode("|",$filter);
					$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
				}
				
				$ftipe=" AND a_p.JENIS=0";
				if ($tipe!=0){
					$ftipe=" AND a_p.JENIS=$tipe";
					$sql2="SELECT DISTINCT * FROM (SELECT b.*,c.id FROM (SELECT data.PBF_ID,data.TANGGAL,data.tgl1, data.noterima, data.nobukti, data.nobukti no_faktur, data.KET no_spk, data.pbf_nama, SUM(data.dpp) AS dpp, 
		SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn 
		FROM (SELECT a_p.*,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,
		a_p.HARGA_KEMASAN*QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
		(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
		(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
		o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA 
		FROM ".$dbapotek.".a_penerimaan a_p INNER JOIN ".$dbapotek.".a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
		LEFT JOIN ".$dbapotek.".a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID 
		WHERE a_p.TIPE_TRANS=0".$ftipe." AND a_p.TANGGAL BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS data GROUP BY data.nobukti, data.noterima) AS b
		LEFT JOIN (SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d/%m/%Y') AS tgl1,pbf.PBF_NAMA 
		FROM ak_posting p INNER JOIN ".$dbapotek.".a_pbf pbf ON p.id_kso_pbf_umum=pbf.PBF_ID 
		WHERE p.tipe=3 AND p.tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS c ON (b.noterima=c.no_terima AND b.nobukti=c.no_faktur AND b.TANGGAL=c.tgl_trans)
		WHERE id IS NULL) as t1 ".$filter;
				}else{
					$sql2="SELECT DISTINCT * FROM (SELECT b.*,c.id FROM (SELECT data.PBF_ID,data.TANGGAL,data.tgl1, data.noterima, data.nobukti, data.nobukti no_faktur, data.BATCH no_spk, data.pbf_nama, SUM(data.dpp) AS dpp, 
		SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn 
		FROM (SELECT a_p.*,DATE_FORMAT(a_p.TANGGAL,'%d/%m/%Y') AS tgl1,DATE_FORMAT(a_p.EXPIRED,'%d/%m/%Y') AS tgl2,
		a_p.HARGA_KEMASAN*QTY_KEMASAN AS subtotal,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,
		(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,
		(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,
		o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA 
		FROM ".$dbapotek.".a_penerimaan a_p INNER JOIN ".$dbapotek.".a_obat o ON a_p.OBAT_ID=o.OBAT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k ON a_p.KEPEMILIKAN_ID=k.ID 
		INNER JOIN ".$dbapotek.".a_pbf ON a_p.PBF_ID=a_pbf.PBF_ID 
		WHERE a_p.TIPE_TRANS=0".$ftipe." AND a_p.TANGGAL BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS data GROUP BY data.nobukti, data.noterima) AS b
		LEFT JOIN (SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d/%m/%Y') AS tgl1,pbf.PBF_NAMA 
		FROM ak_posting p INNER JOIN ".$dbapotek.".a_pbf pbf ON p.id_kso_pbf_umum=pbf.PBF_ID 
		WHERE p.tipe=3 AND p.tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') AS c ON (b.noterima=c.no_terima AND b.nobukti=c.no_faktur AND b.TANGGAL=c.tgl_trans)
		WHERE id IS NULL) as t1 ".$filter;
				}
				
				$sql=$sql2." ORDER BY ".$sorting;
				$sqlTot="SELECT SUM(dpp) AS jmldpp,SUM(ppn) AS jmlppn,SUM(dppppn) AS jmldppppn FROM (".$sql2.") AS ttot";
				$rsTot=mysql_query($sqlTot);
				$rwTot=mysql_fetch_array($rsTot);
				$totdpp=$rwTot["jmldpp"];
				$totppn=$rwTot["jmlppn"];
				$totdppppn=$rwTot["jmldppppn"];
			}else{
				if ($filter!="") {
					$filter=explode("|",$filter);
					$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
				}
				
				$ftipe=" AND p.jenis=0";
				if ($tipe!=0 && $tipe!=""){
					$ftipe=" AND p.jenis=$tipe";
				}
				
				$sql2="SELECT DISTINCT * FROM (SELECT p.*,p.no_terima noterima,p.no_bukti no_spk,DATE_FORMAT(p.tgl_trans,'%d/%m/%Y') as tgl1,p.tgl_trans AS TANGGAL,pbf.pbf_nama FROM ak_posting p INNER JOIN ".$dbapotek.".a_pbf pbf ON p.id_kso_pbf_umum=pbf.PBF_ID WHERE p.tipe=3".$ftipe." AND p.tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') as t1 $filter";
				
				$sql=$sql2." ORDER BY ".$sorting;
				$sqlTot="SELECT SUM(biayaKSO_DPP) AS jmldpp,SUM(biayaPx_PPN) AS jmlppn,SUM(biayaRS_DPP_PPN) AS jmldppppn FROM (".$sql2.") AS ttot";
				$rsTot=mysql_query($sqlTot);
				$rwTot=mysql_fetch_array($rsTot);
				$totdpp=$rwTot["jmldpp"];
				$totppn=$rwTot["jmlppn"];
				$totdppppn=$rwTot["jmldppppn"];
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
		case "pembelianObat":
			while ($rows=mysql_fetch_array($rs)) {
				if ($posting==0){
					$i++;
					$dt.=$rows["PBF_ID"]."|".$rows["TANGGAL"]."|".$rows["noterima"]."|".$rows["nobukti"]."|".$rows["id"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["noterima"].chr(3).$rows["nobukti"].chr(3).$rows["no_spk"].chr(3).$rows["pbf_nama"].chr(3).number_format($rows['dpp'],2,",",".").chr(3).number_format($rows['ppn'],2,",",".").chr(3).number_format($rows['dppppn'],2,",",".").chr(3)."0".chr(6);
				}else{
					$i++;
					$dt.=$rows["id_kso_pbf_umum"]."|".$rows["tgl_trans"]."|".$rows["no_terima"]."|".$rows["no_faktur"]."|".$rows["id"].chr(3).$i.chr(3).$rows["tgl1"].chr(3).$rows["no_terima"].chr(3).$rows["no_faktur"].chr(3).$rows["no_spk"].chr(3).$rows["pbf_nama"].chr(3).number_format($rows['biayaKSO_DPP'],2,",",".").chr(3).number_format($rows['biayaPx_PPN'],2,",",".").chr(3).number_format($rows['biayaRS_DPP_PPN'],2,",",".").chr(3)."0".chr(6);
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
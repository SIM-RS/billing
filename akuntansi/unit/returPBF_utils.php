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
	case "postingReturnPBF":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$tanggal=$cdata[1];
				$tipePost=$cdata[2];
				$kpid=$cdata[6];
				$nokw=$cdata[3];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,biayaRS_DPP_PPN,tgl_act,user_act) VALUES($id_cc_rv,'$tanggal',6,'$nokw',$cdata[4],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT * FROM ".$dbapotek.".a_pbf WHERE PBF_ID=$cdata[5]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					
					$uraian="Return PBF : ".$rwPost["PBF_NAMA"];
					
					if ($tipePost==0){
						$id_kso_pbf_umum=$cdata[5];
						if ($kpid==5){
							$id_sak=378;	//Hutang Usaha ke Suplier Obat
							$id_sak_stok=68;	//Persediaan Tindakan
							$jenistrans=30;	//Pengurang Pembelian blm terbayar
						}else{
							$id_sak=378;	//Hutang Usaha ke Suplier Obat
							$id_sak_stok=67;	//Persediaan Obat
							$jenistrans=24;	//Pengurang Pembelian sdh terbayar
						}
					}else{
						$id_kso_pbf_umum=0;
						if ($kpid==5){
							$id_sak=8;	//Kas di Bendahara Peneriaan
							$id_sak_stok=68;	//Persediaan Tindakan
							$jenistrans=31;	//Pengurang Pembelian blm terbayar
						}else{
							$id_sak=8;	//Kas di Bendahara Peneriaan
							$id_sak_stok=67;	//Persediaan Tindakan
							$jenistrans=25;	//Pengurang Pembelian sdh terbayar
						}
					}
					
					//====insert return ke PBF====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING,flag) 
	VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[4],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$id_kso_pbf_umum,1,'$flag')";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING,flag) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$cdata[4],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',0,1,'$flag')";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tipe=6 AND tgl_trans='$cdata[1]' AND id_cc_rv=$cdata[0] AND no_bukti='$cdata[3]'";
				mysql_query($sDel);
				
				$sql="SELECT * FROM ".$dbapotek.".a_pbf WHERE PBF_ID=$cdata[5]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				
				$uraian="Return PBF : ".$rwPost["PBF_NAMA"];
								
				$sJ = "DELETE FROM jurnal WHERE TGL='$cdata[1]' AND URAIAN = '$uraian' AND NO_KW='$cdata[3]'";
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
		case "ReturnPBF":
			if ($posting==0){
				$sql = "SELECT ar.RETUR_ID id,a_pbf.PBF_ID,ap.KEPEMILIKAN_ID,DATE_FORMAT(ar.TGL,'%d-%m-%Y') AS TGL,ar.TGL AS TGL_TRANS, ar.NO_RETUR, ar.NO_FAKTUR, ar.QTY, ar.KET, DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tglfaktur,(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,
			ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI 
	FROM ".$dbapotek.".a_penerimaan_retur ar INNER JOIN ".$dbapotek.".a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
	INNER JOIN ".$dbapotek.".a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN ".$dbapotek.".a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
	INNER JOIN ".$dbapotek.".a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k 
	ON ar.KEPEMILIKAN_ID = k.ID LEFT JOIN (SELECT * FROM ak_posting WHERE tipe=6 AND tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') akp ON ar.RETUR_ID=akp.id_cc_rv 
	WHERE ar.TGL BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND id_cc_rv IS NULL";
			}else{
				$sql = "SELECT akp.id,a_pbf.PBF_ID,ap.KEPEMILIKAN_ID,DATE_FORMAT(ar.TGL,'%d-%m-%Y') AS TGL,ar.TGL AS TGL_TRANS, ar.NO_RETUR, ar.NO_FAKTUR, ar.QTY, ar.KET, DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tglfaktur,(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,
			ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI, ar.RETUR_ID id 
	FROM (SELECT * FROM ak_posting WHERE tipe=6 AND tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') akp INNER JOIN ".$dbapotek.".a_penerimaan_retur ar ON akp.id_cc_rv=ar.RETUR_ID INNER JOIN ".$dbapotek.".a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
	INNER JOIN ".$dbapotek.".a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN ".$dbapotek.".a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
	INNER JOIN ".$dbapotek.".a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k 
	ON ar.KEPEMILIKAN_ID = k.ID 
	WHERE ar.TGL BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
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
		case "ReturnPBF":
			while($rows=mysql_fetch_array($rs)){
				$i++;
				$dt.=$rows["id"]."|".$rows["TGL_TRANS"]."|".$rows["PBF_ID"]."|".$rows["KEPEMILIKAN_ID"].chr(3).$i.chr(3).$rows["PBF_NAMA"].chr(3).$rows["TGL"].chr(3).$rows["NO_RETUR"].chr(3).$rows["tglfaktur"].chr(3).$rows["NOBUKTI"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["QTY"].chr(3).number_format($rows["aharga"],2,",",".").chr(3).number_format(($rows["QTY"]*$rows["aharga"]),2,",",".").chr(3).$rows["KET"].chr(3)."0".chr(6);
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
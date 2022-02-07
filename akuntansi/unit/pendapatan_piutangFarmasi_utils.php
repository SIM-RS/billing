<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort=$dbbilling.".b_ms_unit.kode";
$defaultsortObat="TANGGAL";
$statusProses='';
$alasan='';
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
	case "postingPiutangFarmasi":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				
				$sql="UPDATE $dbkeuangan.k_piutang SET posting=1,user_posting='$idUser',tgl_posting=NOW() WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_affected_rows()>0){
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$sql="SELECT mp.no_rm FROM $dbbilling.b_kunjungan k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id WHERE k.id='$cdata[1]'";
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$no_rm=$rw1["no_rm"];
					$sql="SELECT * FROM $dbkeuangan.k_transaksi WHERE fk_id=$cdata[0]";
					//echo $sql."<br>";
					$rsTrans=mysql_query($sql);
					while ($rwTrans=mysql_fetch_array($rsTrans)){
						$id_k_trans=$rwTrans["id"];
						$idunitFarmasi=$rwTrans["unit_id"];
						$unit_id_billing=$rwTrans["unit_id_billing"];
						$kso_id=$rwTrans["kso_id"];
						$biayaRS=$rwTrans["nilai_sim"];
						$biayaKSO=$rwTrans["nilai"];
						$biayaPx=$rwTrans["nilai_hpp"];
						$selisih=$biayaRS-($biayaKSO+$biayaPx);
						if ($selisih>0){
							$cselisih = $selisih;
						}
						else{
							$cselisih = -1 * $selisih;
						}
						//======insert into jurnal========
						$sql="SELECT UNIT_KODE,UNIT_NAME FROM ".$dbapotek.".a_unit WHERE UNIT_ID=$idunitFarmasi";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$kdFarmasi=$rwPost["UNIT_KODE"];
						$unitFarmasi=$rwPost["UNIT_NAME"];
						
						$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id_billing";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$idunit=$rwPost["id"];
						$unitBilling=$rwPost["nama"];
						$kdunit=$rwPost["kode"];
						$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso_id";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$ksoNama=$rwPost["nama"];
						$uraian="Pelayanan Resep : ".$unitFarmasi." ".$tanggalAsli." - ".$unitBilling." - ".$ksoNama." - NoRM : ".$no_rm;
						$kdkso=$rwPost["kode_ak"];
						$ckso_type=$rwPost["type"];
						
						$nokw="$kdFarmasi/$kdunit/$tanggalAsli/$kdkso/$no_rm";
					
						/* //===============================
						$IdTransUmum=3;///===1111a - Terjadinya Transaksi Pendapatan
						$IdTransKSO=9;///===1121a - Terjadinya Transaksi Pendapatan
						$IdTransKSO_Lebih=10;///===1121b - Terjadinya Transaksi Pendapatan Selisih Lebih (Tarif Pemda - Tarif KSO)
						$IdTransKSO_Kurang=11;///===1121c - Terjadinya Transaksi Pendapatan Selisih Kurang (Tarif Pemda - Tarif KSO)
						$IdTransPemda=16;///===	113a - Terjadinya Transaksi Pendapatan
						$Idma_sak_d_umum=44;//===113010101 - Piutang Pasien Umum
						$Idma_sak_d_kso_px=45;//===113010102 - Piutang Pasien Kerjasama dengan pihak ke III beban pasien
						$Idma_sak_d_kso_kso=46;//===113010103 - Piutang Pasien Kerjasama dengan pihak ke III beban pihak ke III
						$Idma_sak_d_kso_pemda=47;//===113010104 - Piutang Pasien Subsidi Pemda
						$Idma_sak_d=$Idma_sak_d_kso_kso;
						$Idma_sak_k_umum=488;//===41101 - Pendapatan Jasa Layanan Pasien Umum
						$Idma_sak_k_kso=490;//===41103 - Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
						$Idma_sak_k_pemda=493;//===41106 - Pendapatan Jasa Layanan Pasien Subsidi Pemerintah
						$Idma_sak_selisih_tarip_d_k_kso=491;//===41104 - Selisih Tarif Jasa Layanan Pasien Kerja Sama dengan KSO
						$Idma_sak_selisih_tarip_d_k_pemda=902;//===41108 - Selisih Tarif Jasa Layanan Pasien Subsidi Pemerintah
						$Idma_sak_k=$Idma_sak_k_kso;
						
						$Idma_sak=$Idma_sak_k_kso;
						$Idma_dpa=6;
						//=============================== */
						$id_sak_biaya=562;//51203 - Biaya Obat-obatan
						$id_sak_stok=67;//1140101 - Persediaan Obat & Alkes
						$jenistrans_jual=73;//131b - Terjadi Penjualan Obat di Apotek
						$id_sak_kas=8;//Kas Bendahara Penerimaan
						//$nilaiDK = $cdata[3];
						if ($kso_id==1){
							$id_sak=44;//113010101 - Piutang Pasien Umum
							$id_sak_pend=488;//41101 - Pendapatan Jasa Layanan Pasien Umum
							$jenistrans=3;//1111a - Terjadinya Transaksi Pendapatan
						}elseif($kso_id==2){
							$id_sak=47;	//113010104 - Piutang Pasien Subsidi Pemda
							$id_sak_pend=493;//41106 - Pendapatan Jasa Layanan Pasien Subsidi Pemerintah							
							$id_sak_selisih=902;//===41108 - Selisih Tarif Jasa Layanan Pasien Subsidi Pemerintah
							$jenistrans=16;//113a - Terjadinya Transaksi Pendapatan
						}else{
							$id_sak=46;//113010103 - Piutang Pasien Kerjasama dengan pihak ke III beban pihak ke III
							$id_sak_px=45;//===113010102 - Piutang Pasien Kerjasama dengan pihak ke III beban pasien
							$id_sak_pend=490;//41103 - Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
							$id_sak_selisih=491;//===41104 - Selisih Tarif Jasa Layanan Pasien Kerja Sama dengan KSO
							$jenistrans=9;//1121a - Terjadinya Transaksi Pendapatan
							$jenistransKSO_Lebih=10;///===1121b - Terjadinya Transaksi Pendapatan Selisih Lebih (Tarif Pemda - Tarif KSO)
							$jenistransKSO_Kurang=11;///===1121c - Terjadinya Transaksi Pendapatan Selisih Kurang (Tarif Pemda - Tarif KSO)
						}
												
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];
						
						//====insert pendapatan dr pelayanan resep====
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_k_trans,$notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$biayaKSO,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						if ($biayaPx>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_k_trans,$notrans,$no_psg,$id_sak_px,'$tanggal','$nokw','$uraian',$biayaPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_k_trans,$notrans,$no_psg,$id_sak_pend,'$tanggal','$nokw','$uraian',0,$biayaRS,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						if ($cselisih>0){
							if ($selisih>0){
								//$jenistrans=$jenistransKSO_Lebih;
								$cselisihD=$cselisih;
								$cselisihK=0;
								$dk='D';
							}
							else{
								//$jenistrans=$jenistransKSO_Kurang;
								$cselisihD=0;
								$cselisihK=$cselisih;
								$dk='K';
							}
							
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_k_trans,$notrans,$no_psg,$id_sak_selisih,'$tanggal','$nokw','$uraian',$cselisihD,$cselisihK,now(),$idUser,'$dk',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}
					
						//====insert biaya pemakaian bahan obat2an====
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];
	
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_k_trans,$notrans,$no_psg,$id_sak_biaya,'$tanggal','$nokw','$uraian',$biayaRS,0,now(),$idUser,'D',0,$jenistrans_jual,$jenistrans_jual,1,'',$idunit,'$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_k_trans,$notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$biayaRS,now(),$idUser,'K',0,$jenistrans_jual,$jenistrans_jual,1,'','$kso','$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
					}
				}else{
					$statusProses='Error';
					$alasan='Posting Gagal';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				
				$sql = "UPDATE $dbkeuangan.k_piutang SET posting=0 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$kueri = mysql_query($sql);
				if (mysql_affected_rows()>0){
					$sql = "SELECT * FROM $dbkeuangan.k_transaksi WHERE fk_id=$cdata[0]";
					//echo $sql."<br>";
					$kueri = mysql_query($sql);
					while ($row = mysql_fetch_array($kueri)){
						$fk_id=$row["id"];
						$sJ = "DELETE 
							FROM
							  $dbakuntansi.jurnal 
							WHERE FK_ID_POSTING=$fk_id";
						//echo $sJ."<br>";
						$qJ = mysql_query($sJ);
						if (mysql_errno()>0){
							$statusProses='Error';
							$alasan='UnPosting Gagal';
						}
						/* else{
							$sJ = "DELETE 
								FROM
								  $dbkeuangan.k_transaksi 
								WHERE id=$fk_id";
							//echo $sJ."<br>";
							$qJ = mysql_query($sJ);
						} */
					}
				}else{
					$statusProses='Error';
					$alasan='UnPosting Gagal';
				}
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

if(($statusProses=='') && ($act=='postingPiutangFarmasi')) {
    //$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
	if ($posting==0){
		$alasan='Posting Data Berhasil !';
	}else{
		$alasan='UnPosting Data Berhasil !';
	}
}
//else {
	switch ($grd){
		case "loadkasir":
			$dt='<option value="0">SEMUA</option>';
			$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
            while($wTmp = mysql_fetch_array($qTmp)){
				$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
			}
			echo $dt;
			return;
			break;
		case "pend_piutangFarmasi":
			$defaultsort="kode";
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			
			$fkso=" AND kp.kso_id=$kso";
			
			$fposting=" AND kp.posting=$posting";
			//if ($posting==0){
				$sql = "SELECT
						  kp.id,
						  k.id AS fk_id,
						  pas.no_rm,
						  pas.nama AS pasien,
						  kso.nama     kso,
						  mu.nama      unit,
						  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
						  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
						  kp.biayaRS,
						  kp.biayaPasien,
						  kp.biayaKSO,
						  kp.bayarPasien,
						  kp.piutangPasien
						FROM $dbkeuangan.k_piutang kp
						  INNER JOIN $dbbilling.b_kunjungan k
							ON kp.fk_id = k.id
						  INNER JOIN $dbbilling.b_ms_pasien pas
							ON k.pasien_id = pas.id
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON k.kso_id = kso.id
						  INNER JOIN $dbbilling.b_ms_unit mu
							ON k.unit_id = mu.id
						WHERE kp.tglP = '$tanggal' AND kp.tipe=1 $filter $fkso $fposting";
			/* }else{
				$sql = "SELECT
						  k.id,  
						  pas.no_rm,
						  pas.nama AS pasien,
						  kso.nama     kso,
						  mu.nama      unit,
						  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
						  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
						  kp.biayaRS,
						  kp.biayaPasien,
						  kp.biayaKSO,
						  kp.bayarPasien,
						  kp.piutangPasien
						FROM $dbkeuangan.k_piutang kp
						  INNER JOIN $dbbilling.b_kunjungan k
							ON kp.fk_id = k.id
						  INNER JOIN $dbbilling.b_ms_pasien pas
							ON k.pasien_id = pas.id
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON k.kso_id = kso.id
						  INNER JOIN $dbbilling.b_ms_unit mu
							ON k.unit_id = mu.id
						WHERE kp.tglP = $tanggal' AND kp.tipe=0";
			} */
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(bayarPasien),0) as totbayarPas,
						IFNULL(sum(piutangPasien),0) as totpiutangPas
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totbayarPas = $rowPlus['totbayarPas'];
			$totPiutangPx = $rowPlus['totpiutangPas'];
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
		case "pend_piutangFarmasi":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$tmpLay = $rows["unit"];
				$kso = $rows["kso"];
				$tPerda=$rows["biayaRS"]+$rows["kamarRS"];
				$tKSO=$rows["biayaKSO"]+$rows["kamarKSO"];
				$tPx=$rows["biayaPasien"]+$rows["kamarPasien"];
				$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
				$tPiutangPx=$tPx-$tBayarPx;
				$sisip=$rows["id"]."|".$rows["fk_id"]."|".$rows["tgl"]."|".$rows["tgl_p"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx;
				$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).number_format($tPiutangPx,0,",",".").chr(3)."0".chr(6);
				$tmpLay = '';
			}
			break;
    }

    //DARI FOLDER akuntansi_
	if ($dt!=$totpage.chr(5)) {
		/* if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
		}
		else if($actPosting=='Unverifikasi'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unverifikasi";
		}
		else{
			$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
		} */
		$dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
    }
	/* else{
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
 */
	/*if ($grd=="penerimaanBillingKasir"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntotSlip,0,",",".").chr(3).number_format($ntot1,0,",",".");
	}elseif($grd=="pembelianObat"){
		$dt=$dt.chr(3).number_format($totdpp,2,",",".").chr(3).number_format($totppn,2,",",".").chr(3).number_format($totdppppn,2,",",".");
	}elseif($grd=="pengeluaranLain"){
		$dt=$dt.chr(3).number_format($totnilai,2,",",".");
	}*/

    mysql_free_result($rs);
//}
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
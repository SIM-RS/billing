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
//===============================
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
//===============================

switch ($act){
	case "postingSelisihPiutang":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				$ksoid=$cdata[1];
				$id_k_trans=$idKunj;
				$idunit=0;
				$sql="UPDATE $dbkeuangan.k_piutang SET posting_bKlaim=1,status=2 WHERE fk_id=$idKunj AND kso_id='$ksoid' AND status=1";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_affected_rows()>0){
					/* $sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"]; */
					
					$sql="SELECT mp.no_rm FROM $dbbilling.b_kunjungan k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id WHERE k.id='$idKunj'";
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$no_rm=$rw1["no_rm"];
					$sql="SELECT 
							IFNULL(SUM(kp.biayaKSO),0) AS biayaKSO,
							IFNULL(SUM(kp.biayaKSO_Klaim),0) AS biayaKSO_Klaim
						  FROM $dbkeuangan.k_piutang kp
						  WHERE kp.fk_id=$idKunj AND kp.kso_id='$ksoid' AND kp.status=2";
					//echo $sql."<br>";
					$rsTrans=mysql_query($sql);
					$rwTrans=mysql_fetch_array($rsTrans);
					$biayaKSO=$rwTrans["biayaKSO"];
					$biayaKSO_Klaim=$rwTrans["biayaKSO_Klaim"];
					$selisih=$biayaKSO-$biayaKSO_Klaim;
					//======insert into jurnal========
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$ksoid";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Selisih Tarip KSO ".$tanggalAsli." - ".$ksoNama." - NoRM : ".$no_rm;
					$kdkso=$rwPost["kode_ak"];
					$ckso_type=$rwPost["type"];
					
					$nokw="$tanggalAsli/$kdkso/$no_rm";
					
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
						
					if ($ckso_type==1){
						//$Idma_sak=$Idma_sak_d_kso_pemda;
						//$cfksak_pendptn=$Idma_sak_k_pemda;
						//$cfksak_bkso=$Idma_sak_d_kso_pemda;
						$cfksak_selisih_pend=$Idma_sak_selisih_tarip_d_k_pemda;
						$cfksak_selisih_piutang=$Idma_sak_d_kso_pemda;
					}else{
						//$Idma_sak=$Idma_sak_d_kso_kso;
						//$cfksak_pendptn=$Idma_sak_k_kso;
						//$cfksak_bpasien=$Idma_sak_d_kso_px;
						//$cfksak_bkso=$Idma_sak_d_kso_kso;
						$cfksak_selisih_pend=$Idma_sak_selisih_tarip_d_k_kso;
						$cfksak_selisih_piutang=$Idma_sak_d_kso_kso;
					}
							
					if ($selisih>0){
						if ($ckso_type==1){
							//$jenistrans=10;
							$jenistrans=$IdTransKSO_Lebih;
						}else{
							//$jenistrans=10;
							$jenistrans=$IdTransKSO_Lebih;
						}
						$cselisih=$selisih;
						$cselisihD_pend=$cselisih;
						$cselisihK_pend=0;
						$dk_pend='D';
						$cselisihD_piutang=0;
						$cselisihK_piutang=$cselisih;
						$dk_piutang='K';
					}else{
						if ($ckso_type==1){
							//$jenistrans=11;
							$jenistrans=$IdTransKSO_Kurang;
						}else{
							//$jenistrans=11;
							$jenistrans=$IdTransKSO_Kurang;
						}
						$cselisih = -1 * $selisih;
						$cselisihD_pend=0;
						$cselisihK_pend=$cselisih;
						$dk_pend='K';
						$cselisihD_piutang=$cselisih;
						$cselisihK_piutang=0;
						$dk_piutang='D';
					}
					
					if ($cselisih>0){
						//======piutang======
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($id_k_trans,$notrans,$no_psg,$cfksak_selisih_piutang,'$tanggal','$nokw','$uraian',$cselisihD_piutang,$cselisihK_piutang,now(),$idUser,'$dk_piutang',0,$jenistrans,$jenistrans,1,'',$ksoid,$idunit,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						//=======selisih tarip pendapatan======
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($id_k_trans,$notrans,$no_psg,$cfksak_selisih_pend,'$tanggal','$nokw','$uraian',$cselisihD_pend,$cselisihK_pend,now(),$idUser,'$dk_pend',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
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
				$idKunj=$cdata[0];
				$ksoid=$cdata[1];
				
				$sql = "UPDATE $dbkeuangan.k_piutang SET posting_bKlaim=0,status=1 WHERE fk_id=$idKunj AND kso_id='$ksoid' AND status=2";
				//echo $sql."<br>";
				$kueri = mysql_query($sql);
				if (mysql_affected_rows()>0){//======berhasil=======
					$sJ = "DELETE 
						FROM
						  $dbakuntansi.jurnal 
						WHERE FK_ID_POSTING=$idKunj";
					//echo $sJ."<br>";
					$qJ = mysql_query($sJ);
					if (mysql_errno()>0){//======gagal -->kembalikan data yg sdh diupdate=======
						$sql = "UPDATE $dbkeuangan.k_piutang SET posting_bKlaim=1,status=2 WHERE fk_id=$idKunj AND kso_id='$ksoid' AND status=1";
						//echo $sql."<br>";
						$kueri = mysql_query($sql);
						$statusProses='Error';
						$alasan='UnPosting Gagal';
					}
				}
				else{
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

if(($statusProses=='') && ($act=='postingSelisihPiutang')) {
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
		case "selisihPiutang":
			$defaultsort="id";
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			
			$fkso=" AND kp.kso_id=$kso";
			if ($posting==0){
				$fposting=" AND kp.status=1";
			}
			else{
				$fposting=" AND kp.status>1";
			}
			//if ($posting==0){
			$sql = "SELECT * FROM (SELECT
					  k.id,
					  pas.no_rm,
					  pas.nama AS pasien,
					  kso.id AS kso_id,
					  kso.nama AS kso,
					  mu.nama AS unit,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  IFNULL(SUM(kp.biayaRS),0) AS biayaRS,
					  IFNULL(SUM(kp.biayaKSO),0) AS biayaKSO,
					  IFNULL(SUM(kp.biayaKSO_Klaim),0) AS biayaKSO_Klaim,
					  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
					  IFNULL(SUM(kp.bayarKSO),0) AS bayarKSO,
					  IFNULL(SUM(kp.bayarPasien),0) AS bayarPasien,
					  IFNULL(SUM(kp.piutangPasien),0) AS piutangPasien
					FROM $dbkeuangan.k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.fk_id = k.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON kp.kso_id = kso.id
					WHERE kp.tglP = '$tanggal'
						$fposting $fkso $filter
					GROUP BY kp.fk_id,kp.kso_id) as gab
					WHERE gab.biayaKSO<>gab.biayaKSO_Klaim
					ORDER BY $sorting";
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
						IFNULL(sum(biayaKSO_Klaim),0) as totKsoKlaim
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = $rowPlus['totKsoKlaim'];
			$totSelisih = $totKso-$totKsoKlaim;
			/* if ($totSelisih<0){
				$itotSelisih="(".number_format(abs($totSelisih),0,",",".").")";
			}else{ */
				$itotSelisih=number_format($totSelisih,0,",",".");
			//}
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
		case "selisihPiutang":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$tmpLay = $rows["unit"];
				$kso = $rows["kso"];
				$kso_id = $rows["kso_id"];
				$tPerda=$rows["biayaRS"];
				$tKSO=$rows["biayaKSO"];
				$tPx=$rows["biayaPasien"];
				$tKSO_Klaim=$rows["biayaKSO_Klaim"];
				$tSelisih=$tKSO-$tKSO_Klaim;
				$itSelisih=number_format($tSelisih,0,",",".");
				$sisip=$rows["id"]."|".$kso_id;
				$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tKSO_Klaim,0,",",".").chr(3).$itSelisih.chr(3)."0".chr(6);
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
		$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totKsoKlaim,0,",",".").chr(3).$itotSelisih.chr(3).$alasan;
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
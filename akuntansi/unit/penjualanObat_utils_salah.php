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
	case "postingPenjObat":
		$unitFarm="All Farmasi";
		if ($cmbFarmasi!="0"){
			$sql="SELECT * FROM ".$dbapotek.".a_unit WHERE UNIT_ID='$cmbFarmasi'";
			$rsFarmasi=mysql_query($sql);
			$rwFarmasi=mysql_fetch_array($rsFarmasi);
			$unitFarm=$rwFarmasi["UNIT_NAME"];
		}
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$kso=$cdata[1];
				$carabayar=$cdata[2];
				$id_transaksi=$cdata[6];
				$shift=$cdata[7];
				$tgl_slip=$cdata[8];
				//$noSlip=$cdata[9];
				$nokw="AK.OBAT : $noSlip";
				//$sql2="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,no_terima,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act,jenis) VALUES($id_cc_rv,'$tanggal',4,'$nokw','$noSlip',$kso,$cdata[3],$cdata[4],$cdata[5],now(),$idUser,'$carabayar')";
				//echo $sql."<br>";
				$sql="UPDATE $dbkeuangan.k_transaksi SET no_bukti='$noSlip',posting=1 WHERE id=".$id_transaksi;
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
					$uraian="Penjualan Obat : ".$unit." - ".$rwCek["nama"]." - ".$unitFarm. " - Shift ".$shift;
					
					$id_sak_biaya=562;
					$id_sak_stok=67;
					$jenistrans_jual=73;
					$id_sak_kas=8;	//Kas Bendahara Penerimaan
					if ($carabayar==1){
						//$cdata[3] = $cdata[5];
						if ($kso==1){
							/* ======== Jika di piutangkan ===============*/
							$id_sak=44;	//piutang pasien umum
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=3;	//terjadi transaksi pendapatan pasien umum
							//$jenistrans_bayar=7;	//Saat Pasien Umum bayar
							/* ======== Jika langsung bayar u/ px umum, tanpa di piutangkan ===============*/
							//$id_sak=8;	//Kas di Bendahara Penerimaan
							//$id_sak_pend=488;	//pendapatan pasien umum
							//$jenistrans=258;	//terjadi transaksi pendapatan pasien umum (Tunai)
						}elseif($kso==38 || $kso==39 || $kso==46 || $kso==53){
							/* ======== Jika di piutangkan ===============*/
							$id_sak=47;	//piutang pasien ditanggung pemerintah
							$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
							$jenistrans=16;
						}else{
							/* ======== Jika di piutangkan ===============*/
							$id_sak=45;	//Piutang Pasien Kerjasama dengan pihak ke III beban pasien
							$id_sak_pend=490;	//Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
							$jenistrans=9;	//Terjadinya Transaksi Pendapatan Pasien Kerjasama dengan Pihak ke III
							/* ======== Jika langsung bayar u/ Kerjasama dengan Pihak ke III, tanpa di piutangkan ===============*/
							/* ========= Saat Pasien Kerjasama dengan Pihak ke III Bayar (Beban Pasien) =======*/
							/*$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_sak_pend=490;	//Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
							$jenistrans=14;*/
						}
					}else{
						//$nilaiDK = $cdata[3];
						if ($kso==1){
							$id_sak=44;	//piutang pasien umum
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=3;
						}elseif($kso==38 || $kso==39 || $kso==46 || $kso==53){
							$id_sak=47;	//piutang pasien ditanggung pemerintah
							$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
							$jenistrans=16;
						}else{
							$id_sak=46;	//piutang pasien kso
							$id_sak_pend=490;	//pendapatan pasien kso
							$jenistrans=9;
						}
					}
					
					//====insert pendapatan dr penjualan====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_pend,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					//if ($id_sak==8){
					if ($carabayar==1){
						/* ======== Jika di piutangkan ===============*/
						//=====insert into kas==========
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_kas,'$tgl_slip','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'','$kso','$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tgl_slip','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'','$kso','$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						/* ======== Jika di piutangkan ===============*/
						
						//=====insert into bank==========
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];

						$uraian_setor=$uraian. "(setor Bank)";

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tgl_slip','$nokw','$uraian_setor',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'','$kso','$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_kas,'$tgl_slip','$nokw','$uraian_setor',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'','$kso','$idunit',1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
					}
					
					//====insert pemakaian bahan====
					$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$no_psg=$rwPost["no_psg"];

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_biaya,'$tanggal','$nokw','$uraian',$cdata[4],0,now(),$idUser,'D',0,$jenistrans_jual,$jenistrans_jual,1,'',$idunit,'$idunit',1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$cdata[4],now(),$idUser,'K',0,$jenistrans_jual,$jenistrans_jual,1,'','$kso','$idunit',1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					/* ======== Jika di piutangkan ===============*/
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
				$id_cc_rv=$cdata[0];
				$kso=$cdata[1];
				$carabayar=$cdata[2];
				$id_transaksi=$cdata[6];
				$shift=$cdata[7];
				$tgl_slip=$cdata[8];
				$noSlip=$cdata[9];
				$nokw="AK.OBAT : $noSlip";
				
				/*
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,no_terima,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,tgl_act,user_act,jenis) VALUES($id_cc_rv,'$tanggal',4,'$nokw','$noSlip',$kso,$cdata[3],$cdata[4],now(),$idUser,'$carabayar')";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				*/
				
				//$sDel = "DELETE FROM ak_posting WHERE tipe=4 AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal' AND id_cc_rv=$cdata[0] AND jenis='$carabayar'";
				$sDel = "UPDATE $dbkeuangan.k_transaksi SET posting=0 WHERE id=".$id_transaksi;
				mysql_query($sDel);
				
				
				// delete from jurnal
				
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
				$uraian="Penjualan Obat : ".$unit." - ".$rwCek["nama"]." - ".$unitFarm. " - Shift ".$shift;
				
					$id_sak_biaya=562;
					$id_sak_stok=67;
					$id_sak_kas=8;	//Kas Bendahara Penerimaan
					$jenistrans_jual=73;
					if ($carabayar==1){
						//$cdata[3]=$cdata[5];
						if ($kso==1){
							/* ======== Jika di piutangkan ===============*/
							$id_sak=44;	//piutang pasien umum
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=3;
							/* ======== Jika langsung bayar u/ px umum, tanpa di piutangkan ===============*/
							/*$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=258;	//terjadi transaksi pendapatan pasien umum (Tunai)
							*/
						}elseif($kso==38 || $kso==39 || $kso==46 || $kso==53){
							$id_sak=47;	//piutang pasien ditanggung pemerintah
							$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
							$jenistrans=16;
						}else{
							/* ========= Saat Pasien Kerjasama dengan Pihak ke III Bayar (Beban Pasien) =======*/
							$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_sak_pend=490;	//Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
							$jenistrans=14;
						}
					}else{
						if ($kso==1){
							/* ======== Jika di piutangkan ===============*/
							$id_sak=44;	//piutang pasien umum
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=3;
							/* ======== Jika langsung bayar u/ px umum, tanpa di piutangkan ===============*/
							/*$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_sak_pend=488;	//pendapatan pasien umum
							$jenistrans=258;	//terjadi transaksi pendapatan pasien umum (Tunai)*/
						}elseif($kso==38 || $kso==39 || $kso==46 || $kso==53){
							$id_sak=47;	//piutang pasien ditanggung pemerintah
							$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
							$jenistrans=16;
						}else{
							$id_sak=46;	//piutang pasien kso
							$id_sak_pend=490;	//pendapatan pasien kso
							$jenistrans=9;
						}
					}
				
				$sel = "SELECT NO_TRANS FROM jurnal WHERE (TGL = '$tanggal' OR TGL = 'tgl_slip') AND FK_SAK IN ($id_sak,$id_sak_pend,$id_sak_kas,$id_sak_Bank_BLUD) AND FK_TRANS = $jenistrans AND (DEBIT='$cdata[3]' OR KREDIT='$cdata[3]') AND URAIAN LIKE '$uraian%'";
				$qur = mysql_query($sel);
				$rou = mysql_fetch_array($qur);
				$del_notrans = $rou['NO_TRANS'];
				
				$sJ = "DELETE FROM jurnal WHERE (TGL = '$tanggal' OR TGL = 'tgl_slip') AND FK_SAK IN ($id_sak,$id_sak_pend,$id_sak_kas,$id_sak_Bank_BLUD) AND FK_TRANS = $jenistrans AND (DEBIT='$cdata[3]' OR KREDIT='$cdata[3]') AND URAIAN LIKE '$uraian%'";
				mysql_query($sJ);
				//echo $sJ."<br>";
				
				$sJ2 = "DELETE FROM jurnal WHERE TGL = '$tanggal' AND FK_SAK IN ($id_sak_biaya,$id_sak_stok) AND FK_TRANS = $jenistrans_jual AND (DEBIT='$cdata[4]' OR KREDIT='$cdata[4]') AND URAIAN LIKE '$uraian%'";
				mysql_query($sJ2);
				//echo $sJ2."<br>";
				
				mysql_query("delete from jurnal where NO_TRANS='".$del_notrans."'");
			
				}
				
			$actPosting="Unposting";
			
			/*for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tipe=4 AND id_kso_pbf_umum=$kso AND tgl_trans='$cdata[1]' AND id_cc_rv=$cdata[0]";
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
				$uraian="Pemakaian Obat : ".$unit." - ".$rwCek["nama"]."%";
				
				$sJ = "DELETE FROM jurnal WHERE TGL='$cdata[1]' AND URAIAN LIKE '$uraian'";
				mysql_query($sJ);
				
			}
			$actPosting="Unposting";*/
		}
		$kso=$ksoAsli;
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
		case "penjualanObat":
			if ($sorting=="") {
				$sorting="KSO_ID,CARABAYAR_ID";
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			$fkso="";
			if ($_REQUEST['kso']!=0){
				//if ($posting==0){
					$fkso=" AND am.IDMITRA='".$_REQUEST['kso']."'";
				//}else{
				//	$fkso=" AND ap.id_kso_pbf_umum='".$_REQUEST['kso']."'";
				//}
			}
			//if ($posting==0){
				//$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 $fUnit ORDER BY $sorting";
				
				
				$sql="SELECT 
					  * 
					FROM
					  (SELECT 
						m.IDMITRA AS KSO_ID,
						cb.id AS CARABAYAR_ID,
						cb.nama AS cara_bayar,
						k.unit_id_billing AS unit_billing,
						m.nama AS KSO_NAMA,
						u.nama,
						k.nilai_sim AS nJual,
						k.nilai AS nSlip,
						k.nilai_hpp AS nBahan,
						m.kso_id_billing,
						k.id,
						k.kasir_id as SHIFT,
						k.tgl_klaim,
						DATE_FORMAT(k.tgl_klaim,'%d-%m-%Y') as tgl_slip,
						k.no_bukti 
					  FROM
						$dbkeuangan.k_transaksi k 
						INNER JOIN $dbapotek.a_mitra m 
						  ON m.IDMITRA = k.kso_id 
						INNER JOIN $dbbilling.b_ms_unit u 
						  ON u.id = k.unit_id_billing 
						INNER JOIN $dbapotek.a_cara_bayar cb 
						  ON cb.id = k.cara_bayar 
					  WHERE k.id_trans = 39 
						AND k.tgl = '$tanggal' AND k.unit_id = '$cmbFarmasi' $fkso AND k.posting = '$posting') AS tbl $filter ORDER BY $sorting";
						
			$sql = "SELECT * FROM (SELECT 
						am.IDMITRA KSO_ID,
						cb.id AS CARABAYAR_ID,
						cb.nama AS cara_bayar,
						u.unit_billing,
						am.NAMA KSO_NAMA,
						u.UNIT_NAME nama,
						SUM(p.HARGA_SATUAN*p.QTY_JUAL) nJual, 
						SUM(p.HARGA_SATUAN*p.QTY_JUAL) nSlip, 
						SUM(p.HARGA_NETTO*p.QTY) nBahan, 
						p.NO_PASIEN, 
						p.NO_KUNJUNGAN, 
						p.NAMA_PASIEN, 
						u.UNIT_ID unit_id,
						p.USER_ID as SHIFT,
						DATE_FORMAT(p.TGL,'%d-%m-%Y') as tgl_slip, 
						p.NO_PENJUALAN no_slip
					FROM $dbapotek.a_penjualan p
					INNER JOIN $dbapotek.a_unit u ON u.UNIT_ID = p.UNIT_ID
					INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA = p.KSO_ID
					INNER JOIN $dbapotek.a_cara_bayar cb ON cb.id = p.CARA_BAYAR
					WHERE 0 = 0 AND p.TGL = '{$tanggal}'
						AND p.UNIT_ID = '{$cmbFarmasi}'
						AND p.POSTING = '{$posting}'
						{$fkso}
					GROUP BY p.NO_PENJUALAN, p.UNIT_ID, p.NO_PASIEN, p.NAMA_PASIEN, p.NO_KUNJUNGAN, p.KSO_ID) gab
					WHERE 0 = 0 {$filter} 
					ORDER BY {$sorting}";
			//echo $sql."<br>";
			break;
	}
	
    // echo $sql."<br>";
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
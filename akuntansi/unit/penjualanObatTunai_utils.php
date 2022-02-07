<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort="t.no_bukti";
$defaultsortObat="ap.NO_PENJUALAN";
$statusProses='Fine';
//===============================
$idpost=gmdate('YmdHis',mktime(date('H')+7));
$id_transaksi=$idpost;

$id_sak_Bank_BLUD=33;
$idTrans_Penerimaan_Kasir_Farmasi=39;

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
		$tglP=$tanggal;
		$arfdata=explode(chr(6),$fdata);
		
		if ($posting==0){
			//$id_transaksi=$idpost;
			$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
			//echo $sql."<br>";
			$rsPost=mysql_query($sql);
			$rwPost=mysql_fetch_array($rsPost);
			$notrans=$rwPost["notrans"];
			
			for ($i=0;$i<count($arfdata);$i++){
				//$cdata=explode(chr(5),$arfdata[$i]);$rows["unit_id"]."|".$rows["no_bukti"];
				$cdata=explode("|",$arfdata[$i]);
				$cunit_id=$cdata[0];
				$cno_bukti=$cdata[1];
				$id_transaksi++;
				
				$sql="SELECT * FROM ".$dbapotek.".a_unit WHERE UNIT_ID='$cunit_id'";
				//echo $sql.";<br>";
				$rsFarmasi=mysql_query($sql);
				$rwFarmasi=mysql_fetch_array($rsFarmasi);
				$unitFarm=$rwFarmasi["UNIT_NAME"];
				
				if ($noSlip=="") $noSlip=$cno_bukti;
				$nokw="AK.OBAT : $noSlip";
				$sql="UPDATE $dbkeuangan.k_transaksi
						SET no_post = '$id_transaksi',
						  posting = 1
						WHERE unit_id = '$cunit_id'
							AND no_bukti = '$cno_bukti'
							AND id_trans = '$idTrans_Penerimaan_Kasir_Farmasi'
							AND tgl_klaim = '$tanggal'
							AND posting = 0";
				//echo $sql.";<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()==0 && mysql_affected_rows()>0){
					$sql="SELECT
							  t.tgl,
							  t.unit_id_billing,
							  t.kso_id,
							  t.cara_bayar,
							  IFNULL(SUM(t.nilai_sim),0) AS biayaRS,
							  IFNULL(SUM(t.nilai),0) AS biayaPx,
							  IFNULL(SUM(t.nilai_hpp),0) AS biayaHPP
							FROM $dbkeuangan.k_transaksi t
							WHERE t.unit_id = '$cunit_id'
								AND t.no_bukti='$cno_bukti'
								AND t.id_trans = '$idTrans_Penerimaan_Kasir_Farmasi'
								AND t.tgl_klaim = '$tanggal'
							GROUP BY t.kso_id,t.unit_id_billing,t.tgl,t.cara_bayar";
					//echo $sql.";<br>";
					$rsQ=mysql_query($sql);
					$jTransSetor=345;	// 2005 - Kas Bendahara Penerimaan - Bank BLUD
					$nTotalSetor=0;
					while ($rwQ=mysql_fetch_array($rsQ)){
						
						$id_cc_rv=$rwQ["unit_id_billing"];
						//$tglP=$rwQ["tgl"];
						$ckso_id=$rwQ["kso_id"];
						$carabayar=$rwQ["cara_bayar"];
						$nilai=$rwQ["biayaPx"];
						$nilaiHPP=$rwQ["biayaHPP"];
						$nTotalSetor +=$nilai;
						
						//======insert into jurnal========					
						$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$id_cc_rv";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$idunit=$rwPost["id"];
						$unit=$rwPost["nama"];
						
						$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$ckso_id";
						//$sql="SELECT * FROM $dbapotek.a_mitra WHERE IDMITRA=$ckso_id";
						//echo $sql."<br>";
						$rsCek=mysql_query($sql);
						$rwCek=mysql_fetch_array($rsCek);
						//$ckso_id_billing=$rwCek["kso_id_billing"];
						$ckso_id_billing=$ckso_id;
						$ditanggung_pemda=$rwCek["type"];
						//$uraian="Penjualan Obat : ".$unit." - ".$rwCek["NAMA"]." - ".$unitFarm. " - Shift ".$shift;
						$uraian="Penerimaan Kasir Farmasi : ".$unit." - ".$rwCek["nama"]." - ".$unitFarm;
						
						$id_sak_biaya=562;
						$id_sak_stok=67;
						$jenistrans_jual=73;
						$id_sak_kas=8;	//Kas Bendahara Penerimaan
						$id_sak_bank=33; //Bank BLUD --> Bank Jatim - R/K 0261019205
						//if ($carabayar==1){
							//$cdata[3] = $cdata[5];
							if ($ckso_id_billing==1){
								/* ======== Jika di piutangkan ===============*/
								//$id_sak=44;	//piutang pasien umum
								//$id_sak_pend=488;	//pendapatan pasien umum
								//$jenistrans=3;	//terjadi transaksi pendapatan pasien umum
								//$jenistrans_bayar=7;	//Saat Pasien Umum bayar
								/* ======== Jika langsung bayar u/ px umum, tanpa di piutangkan ===============*/
								$id_sak=$id_sak_kas;	//Kas di Bendahara Penerimaan
								//$id_sak=$id_sak_Bank_BLUD; //Bank BLUD --> Bank Jatim - R/K 0261019205
								$id_sak_pend=488;	//pendapatan pasien umum
								$jenistrans=258;	//terjadi transaksi pendapatan pasien umum (Tunai)
							}elseif($ditanggung_pemda==1){
								/* ======== Jika di piutangkan ===============*/
								//$id_sak=47;	//piutang pasien ditanggung pemerintah
								$id_sak=$id_sak_kas;	//Kas di Bendahara Penerimaan
								$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
								$jenistrans=16;
							}else{
								/* ======== Jika di piutangkan ===============*/
								/*$id_sak=45;	//Piutang Pasien Kerjasama dengan pihak ke III beban pasien
								$id_sak_pend=490;	//Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
								$jenistrans=9;	//Terjadinya Transaksi Pendapatan Pasien Kerjasama dengan Pihak ke III*/
								/* ======== Jika langsung bayar u/ Kerjasama dengan Pihak ke III, tanpa di piutangkan ===============*/
								/* ========= Saat Pasien Kerjasama dengan Pihak ke III Bayar (Beban Pasien) =======*/
								$id_sak=$id_sak_kas;	//Kas di Bendahara Penerimaan
								$id_sak_pend=490;	//Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
								$jenistrans=14;
							}
						/*}else{
							//$nilaiDK = $cdata[3];
							if ($ckso_id_billing==1){
								$id_sak=44;	//piutang pasien umum
								$id_sak_pend=488;	//pendapatan pasien umum
								$jenistrans=3;
							}elseif($ckso_id_billing==2){
								$id_sak=47;	//piutang pasien ditanggung pemerintah
								$id_sak_pend=493;	//pendapatan pasien ditanggung pemerintah
								$jenistrans=16;
							}else{
								$id_sak=46;	//piutang pasien kso
								$id_sak_pend=490;	//pendapatan pasien kso
								$jenistrans=9;
							}
						}*/
						
						//====insert pendapatan dr penjualan====
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_transaksi,$notrans,$no_psg,$id_sak,'$tglP','$nokw','$uraian',$nilai,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$cno_bukti',$ckso_id_billing,$idunit,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
	
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_transaksi,$notrans,$no_psg,$id_sak_pend,'$tglP','$nokw','$uraian',0,$nilai,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$cno_bukti',$ckso_id_billing,$idunit,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql); 
						
						/*if ($carabayar==1){
							//====insert pemakaian bahan====
							$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
							$rwPost=mysql_fetch_array($rsPost);
							$no_psg=$rwPost["no_psg"];
		
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_transaksi,$notrans,$no_psg,$id_sak_biaya,'$tglP','$nokw','$uraian','$nilaiHPP',0,now(),$idUser,'D',0,$jenistrans_jual,$jenistrans_jual,1,'$cno_bukti',$ckso_id_billing,'$idunit',1)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_transaksi,$notrans,$no_psg,$id_sak_stok,'$tglP','$nokw','$uraian',0,'$nilaiHPP',now(),$idUser,'K',0,$jenistrans_jual,$jenistrans_jual,1,'$cno_bukti','$ckso_id_billing','$idunit',1)";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}*/
					}
					
					//=====insert into bank==========
					$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$no_psg=$rwPost["no_psg"];
					
					$uraian="Penerimaan Kasir Farmasi : Setor ke Bank";
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES('$id_transaksi','0',$notrans,$no_psg,$id_sak_bank,'$tanggal','$nokw','$uraian',$nTotalSetor,0,now(),$idUser,'D',0,$jTransSetor,$jTransSetor,1,'$cno_bukti',0,0,1)";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES('$id_transaksi','0',$notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$nTotalSetor,now(),$idUser,'K',0,$jTransSetor,$jTransSetor,1,'$cno_bukti',0,0,1)";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$cunit_id=$cdata[0];
				$cno_bukti=$cdata[1];
				$no_post=$cdata[2];
				
				$sDel = "update ".$dbkeuangan.".k_transaksi set posting='0', no_post='0'
					where tgl_klaim='$tanggal' AND no_post='$no_post' AND id_trans='$idTrans_Penerimaan_Kasir_Farmasi' AND no_bukti = '$cno_bukti'";
				//echo $sDel."<br>";
				$rsDel=mysql_query($sDel);
				if (mysql_affected_rows()>0){//======berhasil===========
					$sDel = "DELETE FROM jurnal WHERE FK_ID_POSTING=$no_post AND NO_BUKTI='$cno_bukti'";
					//echo $sDel."<br>";
					$rsDel=mysql_query($sDel);
					if (mysql_affected_rows()==0){//======Gagal===========
						$statusProses='Error';
						$sDel = "UPDATE $dbkeuangan.k_transaksi SET posting=1,no_post='$no_post' WHERE tgl_klaim='$tanggal' AND no_post='0' AND id_trans='$idTrans_Penerimaan_Kasir_Farmasi' AND no_bukti = '$cno_bukti' AND posting=0";
						$rsDel=mysql_query($sDel);
					}
				}
				else{
					$statusProses='Error';
				}
			}
				
			$actPosting="Unposting";
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
				$sorting=$defaultsort;
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($cmbFarmasi!=0){
				$fFarmasi=" AND t.unit_id = '$cmbFarmasi'";
			}
			
			$fkso="";
			if ($kso!=0){
				$fkso=" AND am.kso_id_billing='$kso'";
			}
			
			$fposting=" AND t.posting = $posting";
			//if ($posting==0){
				//$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 $fUnit ORDER BY $sorting";
							
			$sql = "SELECT
					  t.no_bukti,
					  t.unit_id,
					  t.no_post,
					  au.UNIT_NAME,
					  IFNULL(SUM(t.nilai_sim),0) AS biayaRS,
					  IFNULL(SUM(t.nilai),0) AS biayaPx,
					  IFNULL(SUM(t.nilai_hpp),0) AS biayaHPP
					FROM $dbkeuangan.k_transaksi t
					  INNER JOIN $dbapotek.a_unit au
						ON t.unit_id = au.UNIT_ID
					WHERE t.tgl_klaim = '$tanggal'
						AND t.id_trans = '$idTrans_Penerimaan_Kasir_Farmasi'
						$fFarmasi
						$fposting
						$filter
					GROUP BY t.unit_id,t.no_bukti
					ORDER BY $sorting";
			//echo $sql."<br>";
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
		case "penjualanObat":
			$sqlTot="SELECT IFNULL(SUM(tot.biayaPx),0) totJual,IFNULL(SUM(tot.biayaHPP),0) totBahan FROM (".$sql.") AS tot";
			//echo $sqlTot."<br>";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$ntot=$rwTot["totJual"];
			$ntot2=$rwTot["totBahan"];
			while ($rows=mysql_fetch_array($rs)) 
			{
				$i++;
				$nilai=$rows["biayaPx"];
				$netto=$rows["biayaHPP"];
				$sisip=$rows["unit_id"]."|".$rows["no_bukti"]."|".$rows["no_post"];
				$dt.=$sisip.chr(3).$i.chr(3).$rows["no_bukti"].chr(3).$rows["UNIT_NAME"].chr(3).number_format($nilai,0,",",".").chr(3).number_format($netto,0,",",".").chr(3)."0".chr(6);
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

	$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntot2,0,",",".");

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
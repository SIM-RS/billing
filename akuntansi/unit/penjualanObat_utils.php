<?php
include("../koneksi/konek.php");
include('../sesi.php');
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort="t.no_bukti";
$defaultsortObat="ap.NO_PENJUALAN";
$statusProses='Fine';
//===============================
//$idpost=gmdate('YmdHis',mktime(date('H')+7));
//$id_transaksi=$idpost;

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
			$actMsg="Proses Posting Berhasil !";
			//$idcnt=$idUser * 100;
			$sql="SELECT * FROM ".$dbapotek.".a_unit WHERE UNIT_ID='$cmbFarmasi'";
			//echo $sql.";<br>";
			$rsFarmasi=mysql_query($sql);
			$rwFarmasi=mysql_fetch_array($rsFarmasi);
			$unitFarm=$rwFarmasi["UNIT_NAME"];
			
			//$id_transaksi=$idpost;
			$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
			//echo $sql.";<br>";
			$rsPost=mysql_query($sql);
			$rwPost=mysql_fetch_array($rsPost);
			$notrans=$rwPost["notrans"];
			
			//$id_sak_biaya=562;
			$id_sak_stok=238;		//108.03.00.00 - Persediaan - Obat dan Alat Medis/RSP
			$jenistrans_jual=33;	//130101 - Terjadi Penjualan Obat di Apotek
			
			$idpost=gmdate('YmdHis',mktime(date('H')+7)).rand(1,1000);
			$no_psg=1;
				
			$sql="SELECT * FROM $dbakuntansi.ak_posting p WHERE p.no_bukti='$noSlip' AND p.tgl_trans='$tanggal' AND p.tipe=20";
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)>0){
				$statusProses='Error';
				$actMsg="No Bukti Sudah Ada !";
			}else{
				$ntotal=0;
				for ($i=0;$i<count($arfdata);$i++){
					//$cdata=explode(chr(5),$arfdata[$i]);$rows["unit_id"]."|".$rows["no_bukti"];
					$cdata=explode("|",$arfdata[$i]);
					$id_cc_rv=$cdata[0];
					$ckso_id_billing=$cdata[1];
					$nilai=$cdata[2];
					$nilaiHPP=$cdata[3];
					$ckso_id_farmasi=$cdata[4];
					$cruangan_farmasi=$cdata[5];
					//$idunit=$cmbFarmasi;
					//$sisip=$cidBilling."|".$rows["kso_id_billing"]."|".$nJual."|".$bJual."|".$rows["KSO_ID"]."|".$rows["UNIT_ID"];
					//$idcnt++;
					//$id_transaksi=$idpost;
					
					$sql="SELECT nama FROM $dbbilling.b_ms_unit mu WHERE mu.id='$id_cc_rv'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$nUnitBilling=$rwPost["nama"];
					
					$sql="SELECT nama,tipe_kso FROM $dbbilling.b_ms_kso kso WHERE kso.id='$ckso_id_billing'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$nKsoBilling=$rwPost["nama"];
					$tipe_kso=$rwPost["tipe_kso"];
					
					$uraian="Pemakaian Persediaan Obat (Resep) : ".$unitFarm." - ".$nKsoBilling;
					$uraian_persediaan="Pemakaian Persediaan Obat (Resep) : ".$unitFarm;
					//if ($noSlip=="") $noSlip=$cno_bukti;
					$nokw="$noSlip";
					$sql="INSERT INTO ak_posting
										(no_post,
										 tgl_trans,
										 no_bukti,
										 tipe,
										 id_unit_farmasi,
										 id_cc_rv,
										 id_kso_pbf_umum,
										 biayaRS_DPP_PPN,
										 biayaPx_PPN,
										 tgl_act,
										 user_act)
							VALUES ('$idpost',
									'$tanggal',
									'$noSlip',
									20,
									$cmbFarmasi,
									$id_cc_rv,
									$ckso_id_billing,
									$nilai,
									$nilaiHPP,
									NOW(),
									'$idUser')";
					//echo $sql.";<br>";
					$rsIns=mysql_query($sql);
					if (mysql_errno()==0 && mysql_affected_rows()>0){
						$id_ak_posting=mysql_insert_id();
						//====insert pemakaian bahan====
						/*$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];*/
						
						$id_sak_biaya=239;		//810.07.01.00 - Beban. PPL RSP/UKES - Sub PPL Farmasi (Obat-Obatan) - Pelanggan Internal
						if ($tipe_kso==0){
							$id_sak_biaya=240;		//810.07.01.00 - Beban. PPL RSP/UKES - Sub PPL Farmasi (Obat-Obatan) - Pelanggan Eksternal
						}
						
						$id_cc_rv_farmasi=8;
						$id_beban_jenis_obat=59;
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,MS_BEBAN_JENIS_ID,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,KSO_ID,POSTING,VERIFIKASI,flag) 
		VALUES($id_ak_posting,$idpost,$notrans,$no_psg,$id_sak_biaya,'$tglP','$nokw','$uraian','$nilaiHPP',0,now(),$idUser,'D',0,$jenistrans_jual,$jenistrans_jual,1,'$noSlip','$id_beban_jenis_obat','$id_cc_rv_farmasi','$id_cc_rv_farmasi','$ckso_id_billing',1,1, '$flag')";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
						
						if (mysql_errno()==0){
							$id_jurnal_biaya=mysql_insert_id();
							$ntotal +=$nilaiHPP;
							
							/*$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,KSO_ID,CC_RV_ID,POSTING,VERIFIKASI) 
			VALUES($id_ak_posting,$idpost,$notrans,$no_psg,$id_sak_stok,'$tglP','$nokw','$uraian',0,'$nilaiHPP',now(),$idUser,'K',0,$jenistrans_jual,$jenistrans_jual,1,'$noSlip','0','0','$id_cc_rv_farmasi',1,1)";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							
							if (mysql_errno()==0){
								$id_jurnal_stok=mysql_insert_id();*/
							//=====Berhasil -> Update dbapotek.a_penjualan====
								$sql="UPDATE $dbapotek.a_penjualan SET POSTING=1,NO_POST='$idpost' 
									WHERE UNIT_ID='$cmbFarmasi' AND KSO_ID='$ckso_id_farmasi' AND TGL='$tglP' 
										AND POSTING=0";
								//echo $sql.";<br>";
								$rsPost=mysql_query($sql);
								if (mysql_errno()>0){
									$statusProses='Error';
									$actMsg="Terjadi Error dlm Proses Posting !";
									/*$sql="DELETE FROM jurnal WHERE TR_ID='$id_jurnal_stok'";
									//echo $sql.";<br>";
									$rsPost=mysql_query($sql);*/
									
									$sql="DELETE FROM jurnal WHERE TR_ID='$id_jurnal_biaya'";
									//echo $sql.";<br>";
									$rsPost=mysql_query($sql);
									
									$sql="DELETE FROM ak_posting WHERE id='$id_ak_posting'";
									//echo $sql.";<br>";
									$rsPost=mysql_query($sql);
								}
							/*}else{
								$statusProses='Error';
								
								$sql="DELETE FROM jurnal WHERE TR_ID='$id_jurnal_biaya'";
								//echo $sql.";<br>";
								$rsPost=mysql_query($sql);
								
								$sql="DELETE FROM ak_posting WHERE id='$id_ak_posting'";
								//echo $sql.";<br>";
								$rsPost=mysql_query($sql);
							}*/
						}else{
							$statusProses='Error';
							$actMsg="Terjadi Error dlm Proses Posting !";
							
							$sql="DELETE FROM ak_posting WHERE id='$id_ak_posting'";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
						}
					}else{
						$statusProses='Error';
						$actMsg="Terjadi Error dlm Proses Posting !";
					}
				}
				
				if ($statusProses != 'Error'){
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_AK_POSTING,FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,KSO_ID,CC_RV_ID,POSTING,VERIFIKASI,flag) 
		VALUES($id_ak_posting,$idpost,$notrans,$no_psg,$id_sak_stok,'$tglP','$nokw','$uraian_persediaan',0,'$ntotal',now(),$idUser,'K',0,$jenistrans_jual,$jenistrans_jual,1,'$noSlip','0','0','$id_cc_rv_farmasi',1,1,'$flag')";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
				}
			}
		}else{
			$actMsg="Proses UnPosting Berhasil !";
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$cid_ak_posting=$cdata[1];
				
				//$sDel = "SELECT * FROM jurnal WHERE FK_ID_AK_POSTING='$cid_ak_posting'";
				//echo $sDel.";<br>";
				//$rsDel=mysql_query($sDel);
				//if (mysql_num_rows($rsDel)>0){//======berhasil===========
					//$rsDel=mysql_fetch_array($rsDel);
					//$id_no_post=$rsDel["FK_ID_POSTING"];
					$id_no_post=$cdata[1];
					
					$sUpdt = "UPDATE $dbapotek.a_penjualan SET POSTING=0,NO_POST=0 WHERE UNIT_ID='$cmbFarmasi' AND NO_POST='$id_no_post'";
					//echo $sUpdt.";<br>";
					$rsUpdt=mysql_query($sUpdt);
					if (mysql_affected_rows()>0){
						$sDel = "DELETE FROM jurnal WHERE FK_ID_POSTING=$id_no_post";
						//echo $sDel.";<br>";
						$rsDel=mysql_query($sDel);
						if (mysql_errno()==0 && mysql_affected_rows()>0){
							$sDel = "DELETE FROM ak_posting WHERE no_post=$id_no_post";
							//echo $sDel.";<br>";
							$rsDel=mysql_query($sDel);
						}else{					
							//$sUpdt = "UPDATE $dbapotek.a_penjualan SET POSTING=1,NO_POST=$id_no_post WHERE UNIT_ID='$cmbFarmasi' AND NO_POST=$id_no_post";
							//echo $sUpdt."<br>";
							//$rsUpdt=mysql_query($sUpdt);
						}
					}else{
						$statusProses='Error';
						$actMsg="Terjadi Error dlm Proses UnPosting !";
					}
				//}
				//else{
				//	$statusProses='Error';
				//}
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
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act']."|".$actMsg;
}
else {
	switch ($grd){
		case "penjualanObatRkp":
			if ($sorting=="") {
				$sorting="nFarmasi";
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			$fkso="";
			if ($_REQUEST['kso']!=0){
				//if ($posting==0){
					$fkso=" AND m.IDMITRA='".$_REQUEST['kso']."'";
				//}else{
				//	$fkso=" AND ap.id_kso_pbf_umum='".$_REQUEST['kso']."'";
				//}
			}
			
			if ($posting==0){
				$sql="SELECT 
						KSO_ID,
						UNIT_ID,
						RUANGAN,
						IFNULL(SUM(hJual),0) AS hJual,
						IFNULL(SUM(hNetto),0) AS hNetto,
						kso_id_billing,
						nFarmasi,
						nKso,
						unit_id_billing,
						nUnit
					FROM (SELECT
					  ap.KSO_ID,
					  ap.UNIT_ID,
					  ap.RUANGAN,
					  IFNULL(SUM(ap.QTY_JUAL*ap.HARGA_SATUAN),0) + ap.PPN_NILAI AS hJual,
					  IFNULL(SUM(ap.QTY_JUAL*ap.HARGA_NETTO),0) AS hNetto,
					  /*acb.nama        as cBayar,*/
					  IFNULL(am.kso_id_billing,0) AS kso_id_billing,
					  au1.UNIT_NAME    AS nFarmasi,
					  am.NAMA         AS nKso,
					  IFNULL(mu.id,0) AS unit_id_billing,
					  mu.nama AS nUnit
					FROM $dbapotek.a_penjualan ap
					  INNER JOIN $dbapotek.a_mitra am
						ON ap.KSO_ID = am.IDMITRA
					  /*INNER JOIN $dbapotek.a_cara_bayar acb
						ON ap.CARA_BAYAR = acb.id*/
					  INNER JOIN $dbapotek.a_unit au1
						ON ap.UNIT_ID = au1.UNIT_ID
					  LEFT JOIN $dbapotek.a_unit au
						ON ap.RUANGAN = au.UNIT_ID
					  LEFT JOIN $dbbilling.b_ms_unit mu
						ON au.unit_billing = mu.id
					WHERE ap.UNIT_ID = '$cmbFarmasi'
						AND ap.TGL = '$tanggal' AND ap.POSTING='$posting'
					GROUP BY ap.KSO_ID,ap.UNIT_ID,ap.TGL,ap.NO_PENJUALAN,ap.NO_PASIEN,ap.RUANGAN) AS t 
					GROUP BY t.UNIT_ID,t.KSO_ID".$filter." ORDER BY ".$sorting;
			}else{
				$sql="SELECT * FROM (SELECT
						  akp.id,
						  akp.no_post,
						  akp.id_unit_farmasi,
						  akp.id_kso_pbf_umum,
						  akp.no_bukti,
						  u.UNIT_NAME    AS nFarmasi,
						  GROUP_CONCAT(kso.nama SEPARATOR ', ')     AS nKso,
						  mu.nama AS nUnit,
						  IFNULL(SUM(akp.biayaRS_DPP_PPN),0) AS hJual,
						  IFNULL(SUM(akp.biayaPx_PPN),0) AS hNetto
						FROM ak_posting akp
						  INNER JOIN $dbapotek.a_unit u
							ON akp.id_unit_farmasi = u.UNIT_ID
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON akp.id_kso_pbf_umum = kso.id
						  LEFT JOIN $dbbilling.b_ms_unit mu
							ON akp.id_cc_rv = mu.id
						WHERE akp.tipe = 20
							AND akp.tgl_trans = '$tanggal'
							AND akp.id_unit_farmasi = '$cmbFarmasi' GROUP BY no_post) AS t
						".$filter." ORDER BY ".$sorting;
			}
			// echo 'flag : '. $flag.'<br>';
			// echo 'Query nya : '.$sql.' ###BATAS SQL';
			break;
		case "penjualanObat":
			if ($sorting=="") {
				$sorting="nFarmasi";
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			$fkso="";
			if ($_REQUEST['kso']!=0){
				if ($posting==0){
					$fkso=" AND am.kso_id_billing='".$_REQUEST['kso']."'";
				}else{
					$fkso=" AND ap.NO_POST='".$_REQUEST['kso']."'";
				}
			}
			
			//if ($posting==0){
				$sql="SELECT * FROM (SELECT
					  ap.KSO_ID,
					  ap.NO_PASIEN,
					  ap.NAMA_PASIEN,
					  ap.RUANGAN,
					  IFNULL(SUM(ap.QTY_JUAL*ap.HARGA_SATUAN),0) + ap.PPN_NILAI AS hJual,
					  IFNULL(SUM(ap.QTY_JUAL*ap.HARGA_NETTO),0) AS hNetto,
					  /*acb.nama        as cBayar,*/
					  IFNULL(am.kso_id_billing,0) AS kso_id_billing,
					  au1.UNIT_NAME    AS nFarmasi,
					  am.NAMA         AS nKso,
					  IFNULL(mu.id,0) AS unit_id_billing,
					  mu.nama AS nUnit
					FROM $dbapotek.a_penjualan ap
					  INNER JOIN $dbapotek.a_mitra am
						ON ap.KSO_ID = am.IDMITRA
					  INNER JOIN $dbapotek.a_unit au1
						ON ap.UNIT_ID = au1.UNIT_ID
					  LEFT JOIN $dbapotek.a_unit au
						ON ap.RUANGAN = au.UNIT_ID
					  LEFT JOIN $dbbilling.b_ms_unit mu
						ON au.unit_billing = mu.id
					WHERE ap.UNIT_ID = '$cmbFarmasi' 
						$fkso
						AND ap.TGL = '$tanggal' 
					GROUP BY ap.KSO_ID,ap.UNIT_ID,ap.TGL,ap.NO_PENJUALAN,ap.NO_PASIEN,ap.RUANGAN) AS t".$filter." ORDER BY ".$sorting;
			/*}else{
				$sql="SELECT * FROM (SELECT
						  akp.id,
						  akp.no_bukti,
						  u.UNIT_NAME    AS nFarmasi,
						  kso.nama     AS nKso,
						  mu.nama AS nUnit,
						  akp.biayaRS_DPP_PPN AS hJual,
						  akp.biayaPx_PPN AS hNetto
						FROM ak_posting akp
						  INNER JOIN $dbapotek.a_unit u
							ON akp.id_unit_farmasi = u.UNIT_ID
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON akp.id_kso_pbf_umum = kso.id
						  LEFT JOIN $dbbilling.b_ms_unit mu
							ON akp.id_cc_rv = mu.id
						WHERE akp.tipe = 20
							AND akp.tgl_trans = '$tanggal'
							AND akp.id_unit_farmasi = '$cmbFarmasi') AS t".$filter." ORDER BY ".$sorting;
			}*/
			break;
	}
	
	$sqlTot="SELECT IFNULL(SUM(gab.hJual),0) AS totJual,IFNULL(SUM(gab.hNetto),0) AS totNetto FROM (".$sql.") AS gab";
	$rsTot=mysql_query($sqlTot);
	$rwTot=mysql_fetch_array($rsTot);
	$totJual=$rwTot["totJual"];
	$totNetto=$rwTot["totNetto"];
	
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
		case "penjualanObatRkp":
			if ($posting==0){
				$no_bukti="";
				while ($rows=mysql_fetch_array($rs)) {
					$i++;
					$nJual=$rows["hJual"];
					$bJual=$rows["hNetto"];
					$cidBilling=$rows["unit_id_billing"];
					//if ($cidBilling==0) $cidBilling=126;
					//$sisip=$rows["KSO_ID"]."|".$rows["RUANGAN"]."|".$cidBilling."|".$rows["kso_id_billing"]."|".$nJual."|".$bJual;
					$sisip=$cidBilling."|".$rows["kso_id_billing"]."|".$nJual."|".$bJual."|".$rows["KSO_ID"]."|".$rows["UNIT_ID"];
					$dt.=$sisip.chr(3).$i.chr(3).$tanggalAsli.chr(3).$no_bukti.chr(3).$rows["nFarmasi"].chr(3).$rows["nKso"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($bJual,0,",",".").chr(3)."0".chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$i++;
					$cid_ak_posting=$rows["id"];
					$nJual=$rows["hJual"];
					$bJual=$rows["hNetto"];
					$no_bukti=$rows["no_bukti"];
					//if ($cidBilling==0) $cidBilling=126;
					$sisip=$cid_ak_posting."|".$rows["no_post"]."|".$nJual."|".$bJual."|".$rows["id_kso_pbf_umum"]."|".$rows["id_unit_farmasi"];
					$dt.=$sisip.chr(3).$i.chr(3).$tanggalAsli.chr(3).$no_bukti.chr(3).$rows["nFarmasi"].chr(3).$rows["nKso"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($bJual,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "penjualanObat":
			if ($posting==0){
				$no_bukti="";
				while ($rows=mysql_fetch_array($rs)) {
					$i++;
					$nJual=$rows["hJual"];
					$bJual=$rows["hNetto"];
					$cidBilling=$rows["unit_id_billing"];
					//if ($cidBilling==0) $cidBilling=126;
					//$sisip=$rows["KSO_ID"]."|".$rows["RUANGAN"]."|".$cidBilling."|".$rows["kso_id_billing"]."|".$nJual."|".$bJual;
					$sisip=$cidBilling."|".$rows["kso_id_billing"]."|".$nJual."|".$bJual."|".$rows["KSO_ID"]."|".$rows["RUANGAN"];
					$dt.=$sisip.chr(3).$i.chr(3).$tanggalAsli.chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).$rows["nKso"].chr(3).$rows["nUnit"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($bJual,0,",",".").chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$i++;
					$cid_ak_posting=$rows["id"];
					$nJual=$rows["hJual"];
					$bJual=$rows["hNetto"];
					$no_bukti=$rows["no_bukti"];
					//if ($cidBilling==0) $cidBilling=126;
					$sisip=$cid_ak_posting;
					$dt.=$sisip.chr(3).$i.chr(3).$tanggalAsli.chr(3).$no_bukti.chr(3).$rows["nFarmasi"].chr(3).$rows["nKso"].chr(3).$rows["nUnit"].chr(3).number_format($nJual,0,",",".").chr(3).number_format($bJual,0,",",".").chr(6);
				}
			}
			break;
    }
	
	if ($dt!=$totpage.chr(5)) {
		if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting|$grd";
		}
		else if($actPosting=='Unverifikasi'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unverifikasi|$grd";
		}
		else{
			$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act']."|$grd";
		}
        $dt=str_replace('"','\"',$dt);
    }else{
		if($actPosting=='Unposting'){
			$dt="0".chr(5).chr(5)."Unposting|$grd";
		}
		else if($actPosting=='Unverifikasi'){
			$dt="0".chr(5).chr(5)."Unverifikasi|$grd";
		}
		else{
			$dt="0".chr(5).chr(5).$_REQUEST['act']."|$grd";
		}
	}

	$dt=$dt.chr(3).number_format($totJual,0,",",".").chr(3).number_format($totNetto,0,",",".");

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
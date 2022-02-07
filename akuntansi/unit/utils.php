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
	case 'postingHapusObat':
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[0];
				$no_bukti=$cdata[1];
				$id_obat=$cdata[2];
				$obat=$cdata[3];
				$qty=$cdata[4];
				$nilai=$cdata[5];
				$alasan=$cdata[6];
				$id_hapus=$cdata[7];
				
				$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$notrans=$rwPost["notrans"];
				$no_psg=$rwPost["no_psg"];
				
				$no_kw='AK.HPS.OBAT/'.tglSQL($tanggal);
				
				/*
				$cek="SELECT jt.JTRANS_ID,ma.MA_ID,jt.JTRANS_NAMA,ma.MA_NAMA,dt.dk
FROM detil_transaksi dt INNER JOIN jenis_transaksi jt ON dt.fk_jenis_trans = jt.JTRANS_ID 
INNER JOIN ma_sak ma ON dt.fk_ma_sak = ma.MA_ID WHERE jt.JTRANS_ID = ".$id_trans."";
				*/
				
				$cek="SELECT 
					  a.JTRANS_ID,
					  a.JTRANS_NAMA,
					  b.dk,
					  c.* 
					FROM
					  jenis_transaksi a 
					  INNER JOIN detil_transaksi b 
						ON a.JTRANS_ID = b.fk_jenis_trans 
					  INNER JOIN ma_sak c 
						ON b.fk_ma_sak = c.MA_ID 
					WHERE a.JTRANS_KODE LIKE '18101%'";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = "Hapus Obat : ".$obat." (".$qty.") - $alasan";
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$no_psg,$id_sak,'$tanggal','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti',0,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}
				
				$s_upd = "UPDATE $dbapotek.a_obat_hapus SET POSTING=1 WHERE ID_HAPUS = '$id_hapus'";
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[0];
				$no_bukti=$cdata[1];
				$id_obat=$cdata[2];
				$obat=$cdata[3];
				$qty=$cdata[4];
				$nilai=$cdata[5];
				$alasan=$cdata[6];
				$id_hapus=$cdata[7];
				
				$cek="SELECT 
					  a.JTRANS_ID,
					  a.JTRANS_NAMA,
					  b.dk,
					  c.* 
					FROM
					  jenis_transaksi a 
					  INNER JOIN detil_transaksi b 
						ON a.JTRANS_ID = b.fk_jenis_trans 
					  INNER JOIN ma_sak c 
						ON b.fk_ma_sak = c.MA_ID 
					WHERE a.JTRANS_KODE LIKE '18101%'";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = "Hapus Obat : ".$obat." (".$qty.") - $alasan";
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
					
					$sDel="DELETE FROM jurnal WHERE FK_SAK='$id_sak' AND TGL='$tanggal' AND NO_BUKTI='$no_bukti' AND FK_TRANS='$jenistrans'";
					//echo $sql."<br>";
					mysql_query($sDel);
				}
				
				$s_upd = "UPDATE $dbapotek.a_obat_hapus SET POSTING=0 WHERE ID_HAPUS = '$id_hapus'";
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
			$actPosting='Unposting';
		}
		break;
	case "postingBilling":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$biayaPx=($kso==1)?$cdata[2]:$cdata[4];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,tipe,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act) VALUES('$tanggal',1,$cdata[0],$kso,$cdata[1],$biayaPx,$cdata[3],now(),$idUser)";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Pendapatan ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$ckso_type=$rwPost["type"];
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$nokw="$kdunit/$tanggalAsli/$kdkso";
					
					$iurPx=($kso==1)?$cdata[2]:$cdata[4];
					
					$selisih=$cdata[1]-($cdata[2]+$cdata[3]+$cdata[4]);
					
					if ($kso==1){
						$jenistrans=3;					
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,44,'$tanggal','$nokw','$uraian',$cdata[1],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
						$rsPost=mysql_query($sql);

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,488,'$tanggal','$nokw','$uraian',0,$cdata[1],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
						$rsPost=mysql_query($sql);
					}else{						
						if ($ckso_type==1){
							$cfksak_pendptn=493;
							$cfksak_bpasien=856;	//di set data ma_sak yg baru diinsert pasien pemda beban pasien
							$cfksak_bkso=47;
							$cfksak_selisih=491;
						}else{
							$cfksak_pendptn=490;
							$cfksak_bpasien=45;
							$cfksak_bkso=46;
							$cfksak_selisih=491;
						}
						
						if ($selisih==0){
							if ($ckso_type==1){
								$jenistrans=16;
							}else{
								$jenistrans=9;
							}
							$cselisih=$selisih;
							$cselisihD=$cselisih;
							$cselisihK=0;
							$dk='D';
						}elseif ($selisih>0){
							if ($ckso_type==1){
								$jenistrans=10;
							}else{
								$jenistrans=10;
							}
							$cselisih=$selisih;
							$cselisihD=$cselisih;
							$cselisihK=0;
							$dk='D';
						}else{
							if ($ckso_type==1){
								$jenistrans=11;
							}else{
								$jenistrans=11;
							}
							$cselisih = -1 * $selisih;
							$cselisihD=0;
							$cselisihK=$cselisih;
							$dk='K';
						}
						if ($cdata[3]>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$cfksak_bkso,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
							$rsPost=mysql_query($sql);
						}
						if ($iurPx>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$cfksak_bpasien,'$tanggal','$nokw','$uraian',$iurPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
							$rsPost=mysql_query($sql);
						}

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$cfksak_pendptn,'$tanggal','$nokw','$uraian',0,$cdata[1],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
						$rsPost=mysql_query($sql);
					
						if ($cselisih>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$cfksak_selisih,'$tanggal','$nokw','$uraian',$cselisihD,$cselisihK,now(),$idUser,'$dk',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
							$rsPost=mysql_query($sql);
						}
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
					
				$sql = "SELECT 
					  p.*,
					  rv.id 
					FROM
					  $dbakuntansi.ak_posting p 
					  INNER JOIN ".$dbbilling.".b_ms_unit mu 
						ON mu.id = p.id_cc_rv 
					  INNER JOIN $dbakuntansi.ak_ms_unit rv 
						ON rv.kode = mu.kode_ak 
					WHERE p.id = '".$cdata[0]."'";
				$kueri = mysql_query($sql);
				$row = mysql_fetch_array($kueri);
				$tgl_trans = $row['tgl_trans'];
				$id_unit = $row['id_cc_rv'];
				
				$sUnit = "SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN $dbakuntansi.ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id='".$id_unit."'";
				$qUnit = mysql_query($sUnit);
				$rUnit = mysql_fetch_array($qUnit);
				$unit = $rUnit['nama'];
					
				$sDel = "DELETE FROM $dbakuntansi.ak_posting WHERE id=".$cdata[0];
				mysql_query($sDel);
			
				$sJ = "DELETE 
					FROM
					  $dbakuntansi.jurnal 
					WHERE TGL = '".$tgl_trans."' 
					  AND (DEBIT = '".$cdata[2]."' OR KREDIT = '".$cdata[2]."' ) 
					  AND URAIAN LIKE 'Pendapatan $unit%'";
				$qJ = mysql_query($sJ);
			}
			$actPosting='Unposting';
		}
		break;
	case "postingPengurangBilling":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			if ($bayar==1){
				$postTipe=9;
			}else{
				$postTipe=8;
			}
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$biayaPx=($kso==1)?$cdata[2]:$cdata[4];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,tipe,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act) VALUES('$tanggal',$postTipe,$cdata[0],$kso,$cdata[1],$biayaPx,$cdata[3],now(),$idUser)";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Pengurang Pendapatan ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$nokw="$kdunit/$tanggalAsli/$kdkso";
					
					$iurPx=($kso==1)?$cdata[2]:$cdata[4];
					
					$selisih=$cdata[1]-($cdata[2]+$cdata[3]+$cdata[4]);
					if ($selisih>=0){
						//$jenistrans=10;
						$cselisih=$selisih;
						$cselisihK=$cselisih;
						$cselisihD=0;
						$dk='K';
					}else{
						//$jenistrans=11;
						$cselisih = -1 * $selisih;
						$cselisihK=0;
						$cselisihD=$cselisih;
						$dk='D';
					}
						
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					if ($kso==1){
						if ($bayar==1){
							$id_sak=8;
							$id_pend=488;
							$jenistrans=5;
						}else{
							$id_sak=44;
							$id_pend=488;
							$jenistrans=4;
						}
						
						/*$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						$no_psg=$rwPost["no_psg"];*/

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_pend,'$tanggal','$nokw','$uraian',$iurPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[1],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
						$rsPost=mysql_query($sql);
					}else{
						if ($bayar==1){
							$id_sak=8;
							$id_pend_kso=490;
							$jenistrans=13;
							
							//if ($iurPx>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_pend_kso,'$tanggal','$nokw','$uraian',$iurPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
								$rsPost=mysql_query($sql);
							//}
							
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$iurPx,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
							$rsPost=mysql_query($sql);
						}else{
							$id_sak=45;
							$id_sak_kso=46;
							$id_pend_kso=490;
							$jenistrans=12;
						
							/*$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
							$rsPost=mysql_query($sql);
							$rwPost=mysql_fetch_array($rsPost);
							$notrans=$rwPost["notrans"];*/
							
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_pend_kso,'$tanggal','$nokw','$uraian',$cdata[1],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
							$rsPost=mysql_query($sql);
							if ($cdata[3]>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_sak_kso,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
								$rsPost=mysql_query($sql);
							}
							if ($iurPx>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$iurPx,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
								$rsPost=mysql_query($sql);
							}
							if ($cselisih>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,491,'$tanggal','$nokw','$uraian',$cselisihD,$cselisihK,now(),$idUser,'$dk',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
								$rsPost=mysql_query($sql);
							}
						}
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
			if ($bayar==1){
				$postTipe=9;
			}else{
				$postTipe=8;
			}
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sql = "SELECT * FROM $dbakuntansi.ak_posting WHERE id=".$cdata[0];
				$kueri = mysql_query($sql);
				$row = mysql_fetch_array($kueri);
				$unit_id = $row['id_cc_rv'];
				
				$sDel = "DELETE FROM $dbakuntansi.ak_posting WHERE id=".$cdata[0];
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				$kdunit=$rwPost["kode"];
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ksoNama=$rwPost["nama"];
				$uraian="Pengurang Pendapatan ".$unit." ".$tanggalAsli." - ".$ksoNama;
				$kdkso=$rwPost["kode_ak"];
				$nokw="$kdunit/$tanggalAsli/$kdkso";
				
				$sJ = "DELETE FROM jurnal WHERE TGL = '$tanggal' AND NO_KW = '$nokw' AND URAIAN = '$uraian'";
				mysql_query($sJ);
			}
			$actPosting='Unposting';
		}
		break;
	case "postingPenerimaanBilling":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,tipe,id_cc_rv,id_kso_pbf_umum,biayaPx_PPN,tgl_act,user_act) VALUES('$tanggal',2,$cdata[0],$kso,$cdata[2],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Penerimaan ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$nokw="$kdunit/$tanggalAsli/$kdkso";
										
					if ($kso==1){
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=44;	//Piutang Px Umum
						$jenistrans=7;	//Saat Px Umum Bayar
					}else{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=45;	//Piutang KSO beban Px
						$jenistrans=14;	//Saat Px KSO Bayar
					}

					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					//=====insert into Kas==========
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[2],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_piutang,'$tanggal','$nokw','$uraian',0,$cdata[2],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					//=====insert into bank==========
					$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$no_psg=$rwPost["no_psg"];
					
					$uraianSetor=$uraian." (setor Bank)";

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tanggal','$nokw','$uraianSetor',$cdata[2],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraianSetor',0,$cdata[2],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tgl_trans='$cdata[1]' AND id_kso_pbf_umum=$kso AND id_cc_rv=$cdata[0] AND tipe=2";
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				$kdunit=$rwPost["kode"];
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ksoNama=$rwPost["nama"];
				$uraian="Penerimaan ".$unit." ".$tanggalAsli." - ".$ksoNama;
				$kdkso=$rwPost["kode_ak"];
				$nokw="$kdunit/$tanggalAsli/$kdkso";
				
				$sJ = "DELETE FROM jurnal WHERE TGL = '$tanggal' AND NO_KW = '$nokw' AND URAIAN = '$uraian'";
				mysql_query($sJ);
			}
			
			$actPosting='Unposting';
		}
		break;
	case "postingPenerimaanBillingKasir":
		//$noSlip=$_REQUEST["noSlip"];
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$kso=$cdata[2];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,no_bukti,tipe,id_cc_rv,id_kso_pbf_umum,no_terima,biayaPx_PPN,tgl_act,user_act) VALUES('$tanggal','$noSlip',17,$cdata[1],$kso,'$cdata[0]',$cdata[3],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[1]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ckasir=$rwPost["nama"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Penerimaan Kasir : ".$ckasir.", ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$nokw="$kdunit/$kdkso : $noSlip";
										
					if ($kso==1){
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=44;	//Piutang Px Umum
						$jenistrans=7;	//Saat Px Umum Bayar
					}else{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=45;	//Piutang KSO beban Px
						$jenistrans=14;	//Saat Px KSO Bayar
					}

					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					//=====insert into Kas==========
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_piutang,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					//=====insert into bank==========
					$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$no_psg=$rwPost["no_psg"];

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tgl_trans='$tanggal' AND id_kso_pbf_umum=$cdata[2] AND id_cc_rv=$cdata[1] AND tipe=17 AND no_terima=$cdata[0]";
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[1]";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				$kdunit=$rwPost["kode"];
				$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$cdata[0]";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ckasir=$rwPost["nama"];
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$cdata[2]";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ksoNama=$rwPost["nama"];
				$uraian="Penerimaan Kasir : ".$ckasir.", ".$unit." ".$tanggalAsli." - ".$ksoNama;
				$kdkso=$rwPost["kode_ak"];
				$nokw="$kdunit/$kdkso : $noSlip";
				
				$sJ = "DELETE FROM jurnal WHERE TGL = '$tanggal' AND URAIAN = '$uraian'";
				mysql_query($sJ);
			}
			
			$actPosting='Unposting';
		}
		break;
	case "postingPenerimaanBillingManual":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[1];
				$kso=$cdata[4];
				$tanggalAsli=explode("-",$cdata[1]);
				$tanggalAsli=$tanggalAsli[2]."-".$tanggalAsli[1]."-".$tanggalAsli[0];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,tipe,no_bukti,id_cc_rv,id_kso_pbf_umum,biayaPx_PPN,tgl_act,user_act) VALUES('$tanggal',16,'$cdata[2]',$cdata[0],$kso,$cdata[3],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======update keuangan.k_transaksi set posting=1========
					$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=1 WHERE id=$cdata[0]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
						//======insert into jurnal========
						/*$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$idunit=$rwPost["id"];
						$unit=$rwPost["nama"];
						$kdunit=$rwPost["kode"];*/
						$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$ksoNama=$rwPost["nama"];
						$uraian="Penerimaan Setor Manual ".$tanggalAsli." - ".$ksoNama;
						$kdkso=$rwPost["kode_ak"];
						$nokw="$tanggalAsli/$kdkso";
						
						if ($kso==1){
							$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_piutang=44;	//Piutang Px Umum
							$jenistrans=7;	//Saat Px Umum Bayar
						}else{
							$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_piutang=45;	//Piutang KSO beban Px
							$jenistrans=14;	//Saat Px KSO Bayar
						}
	
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						$no_psg=$rwPost["no_psg"];
						//=====insert into Kas==========
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
	
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_piutang,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						//=====insert into bank==========
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',0,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
					}
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[1];
				$kso=$cdata[4];
				$tanggalAsli=explode("-",$cdata[1]);
				$tanggalAsli=$tanggalAsli[2]."-".$tanggalAsli[1]."-".$tanggalAsli[0];
				
				$sql="DELETE FROM ".$dbakuntansi.".ak_posting where tgl_trans = '$tanggal' and tipe = 16 and no_bukti = '$cdata[2]' and id_cc_rv = $cdata[0] and id_kso_pbf_umum = $kso";
				//echo "$sql";
				$rsPost=mysql_query($sql);
				
				if (mysql_errno()<=0){
					$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=0 WHERE id=$cdata[0]";
					//echo $sql;
					$rsPost=mysql_query($sql);
					
					if (mysql_errno()<=0){
						
						$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$ksoNama=$rwPost["nama"];
						$uraian="Penerimaan Setor Manual ".$tanggalAsli." - ".$ksoNama;
						$kdkso=$rwPost["kode_ak"];
						$nokw="$tanggalAsli/$kdkso";
						
						if ($kso==1){
							$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_piutang=44;	//Piutang Px Umum
							$jenistrans=7;	//Saat Px Umum Bayar
						}else{
							$id_sak=8;	//Kas di Bendahara Penerimaan
							$id_piutang=45;	//Piutang KSO beban Px
							$jenistrans=14;	//Saat Px KSO Bayar
						}
						
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						
						$sql="DELETE FROM ".$dbakuntansi.".jurnal where FK_TRANS = $jenistrans and TGL = '$tanggal' and NO_KW = '$nokw' and URAIAN = '$uraian'";
						//echo $sql;
						$rsPost=mysql_query($sql);
					}
				}else{
					$statusProses='Error';
				}
			}

			$actPosting='Unposting';




		}
		break;
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
	case "postingPenLain":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[1];
				$nokw=$cdata[2];
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,biayaRS_DPP_PPN,tgl_act,user_act) VALUES($cdata[0],'$cdata[1]',15,'$cdata[2]',$cdata[3],now(),$idUser)";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					//======update keuangan.k_transaksi set posting=1========
					$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=1 WHERE id=$cdata[0]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
						//======insert into jurnal========
						$sql="SELECT mt.*,mu.nama unit FROM ".$dbkeuangan.".k_ms_transaksi mt LEFT JOIN ak_ms_unit mu ON mt.id_cc_rv=mu.id WHERE mt.id=$cdata[4]";
						//echo $sql."<br>";
						$rsTrans=mysql_query($sql);
						$rwTrans=mysql_fetch_array($rsTrans);
						
						$id_sak=$rwTrans["id_sak"];
						$id_cc_rv=$rwTrans["id_cc_rv"];
						$jenistrans=$rwTrans["id_jenis_trans"];
						$uraian="Penerimaan : ".$rwTrans["nama"];
						
						if ($rwTrans["id_cc_rv"]>0){
							$uraian="Penerimaan : ".$rwTrans["unit"];
						}
						
						$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$notrans=$rwPost["notrans"];
						$no_psg=$rwPost["no_psg"];
						//=====insert into Kas==========
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,8,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$id_cc_rv,$id_cc_rv,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$id_cc_rv,$id_cc_rv,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						//=====insert into bank==========
						$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];

						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_Bank_BLUD,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$id_cc_rv,$id_cc_rv,1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,8,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$id_cc_rv,$id_cc_rv,1)";
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
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tgl_trans='".$cdata[1]."' AND id_cc_rv='".$cdata[0]."' AND no_bukti='".$cdata[2]."' AND tipe='15'";
				mysql_query($sDel);
				
				$sUp = "UPDATE ".$dbkeuangan.".k_transaksi SET posting=0 WHERE id=$cdata[0]";
				mysql_query($sUp);
				
				$sql="SELECT mt.*,mu.nama unit FROM ".$dbkeuangan.".k_ms_transaksi mt LEFT JOIN ak_ms_unit mu ON mt.id_cc_rv=mu.id WHERE mt.id=$cdata[4]";
				$rsTrans=mysql_query($sql);
				$rwTrans=mysql_fetch_array($rsTrans);
						
				$id_sak=$rwTrans["id_sak"];
				$id_cc_rv=$rwTrans["id_cc_rv"];
				$jenistrans=$rwTrans["id_jenis_trans"];
				$uraian="Penerimaan : ".$rwTrans["nama"];
				
				$sJ = "DELETE FROM jurnal WHERE TGL='".$cdata[1]."' AND NO_KW='".$cdata[2]."' AND (DEBIT='".$cdata[3]."' OR KREDIT='".$cdata[3]."') AND URAIAN LIKE 'Penerimaan%' AND FK_TRANS=$jenistrans AND FK_LAST_TRANS=$jenistrans";
				mysql_query($sJ);
			}
			$actPosting='Unposting';
		}
		break;
	case "postingBeliObat":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$sql="SELECT data.KEPEMILIKAN_ID,SUM(data.dpp) AS dpp, SUM(data.ppn) AS ppn, SUM(data.dpp_ppn) AS dppppn FROM (SELECT ((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100) AS dpp,(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0)) AS ppn,(((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100)+(IF (a_p.NILAI_PAJAK>0,((100-a_p.DISKON)*(a_p.HARGA_KEMASAN*a_p.QTY_KEMASAN)/100*10/100),0))) AS dpp_ppn,a_p.KEPEMILIKAN_ID FROM (SELECT * FROM ".$dbapotek.".a_penerimaan WHERE TIPE_TRANS=0 AND PBF_ID=$cdata[0] AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]') AS a_p) AS data";
				//echo $sql."<br>";
				$rsBeli=mysql_query($sql);
				if ($rwBeli=mysql_fetch_array($rsBeli)){
					$biayaRS=$rwBeli["dppppn"];
					$biayaPx=$rwBeli["ppn"];
					$biayaKSO=$rwBeli["dpp"];
					$kpid=$rwBeli["KEPEMILIKAN_ID"];

					$sql="UPDATE ".$dbapotek.".a_penerimaan SET BAYAR=1 WHERE TIPE_TRANS=0 AND PBF_ID='$cdata[0]' AND NOTERIMA='$cdata[2]' AND NOBUKTI='$cdata[3]'";
					//echo $sql."<br>";
					$rsUpdate=mysql_query($sql);
					
					$fjenis=0;
					if ($tipe==2){
						$fjenis=2;
					}
					$sql="INSERT INTO ".$dbakuntansi.".ak_posting(tgl_trans,no_terima,no_faktur,tipe,jenis,id_cc_rv,id_kso_pbf_umum,biayaRS_DPP_PPN,biayaPx_PPN,biayaKSO_DPP,tgl_act,user_act) VALUES('$cdata[1]','$cdata[2]','$cdata[3]',3,$fjenis,0,$cdata[0],$biayaRS,$biayaPx,$biayaKSO,now(),$idUser)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()<=0){
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
						$no_psg=$rwPost["no_psg"];
						
						$fksak=67;
						$jenistrans=23;
						$k_sak=378;
						if ($kpid==5){
							$fksak=68;
							$jenistrans=29;
						}
						
						if ($tipe==2){
							$jenistrans=122;
							$k_sak=500;
							if ($pbfNama!=""){
								$pbfNama="Penerimaan Hibah : ".$pbfNama;
							}else{
								$pbfNama="Penerimaan Hibah";
							}
						}
						
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES($notrans,$no_psg,$fksak,'$cdata[1]','$cdata[3]','$pbfNama',$biayaRS,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$cdata[0],1)";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES($notrans,$no_psg,$k_sak,'$cdata[1]','$cdata[3]','$pbfNama',0,$biayaRS,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$cdata[0],1)";
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
	case "postingObatFS":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$tanggal=$cdata[1];
				$nokw="AK.FS.OBAT/".$tanggalAsli;
				$sql="INSERT INTO ".$dbakuntansi.".ak_posting(id_cc_rv,tgl_trans,tipe,no_bukti,biayaRS_DPP_PPN,tgl_act,user_act) VALUES($id_cc_rv,'$tanggal',10,'$nokw',$cdata[2],now(),$idUser)";
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
					
					$uraian="Pemakaian Floor Stock : ".$unit;
					
					$id_sak_biaya=562;
					$id_sak_stok=68;
					$jenistrans_fs=78;
					
					//====insert pemakaian bahan====
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_biaya,'$tanggal','$nokw','$uraian',$cdata[2],0,now(),$idUser,'D',0,$jenistrans_fs,$jenistrans_fs,1,'',$idunit,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$cdata[2],now(),$idUser,'K',0,$jenistrans_fs,$jenistrans_fs,1,'',0,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$sDel = "DELETE FROM ak_posting WHERE tipe=10 AND tgl_trans='$cdata[1]' AND id_cc_rv=$cdata[0]";
				mysql_query($sDel);
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$uraian="Pemakaian Floor Stock : ".$unit;				
				
				$sJ = "DELETE FROM jurnal WHERE TGL='$cdata[1]' AND URAIAN = '$uraian'";
				mysql_query($sJ);
				
			}
			$actPosting="Unposting";
		}
		break;
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

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak,'$tanggal','$nokw','$uraian',$cdata[4],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$id_kso_pbf_umum,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_sak_stok,'$tanggal','$nokw','$uraian',0,$cdata[4],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',0,1)";
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
	case "VerifikasiPengeluaranLain":
		//DARI FOLDER akuntansi_
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="UPDATE ".$dbkeuangan.".k_transaksi SET verifikasi=1 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()>0){
					$statusProses='Error';
				}
			}
		}else if($posting==1){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="UPDATE ".$dbkeuangan.".k_transaksi SET verifikasi=0 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()>0){
					$statusProses='Error';
				}
			}
			$actPosting='Unverifikasi';
		}else if($posting==2){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sel = "select * from $dbkeuangan.k_transaksi where id='$cdata[0]'";
				//echo $sel."<br>";
				$qu = mysql_query($sel);
				$row = mysql_fetch_array($qu);
				$noBukti=$row['no_bukti'];
				$TglBayar=$row['tgl'];
				$TglBayarPajak = $row['tgl_klaim'];
				//echo $TglBayar."<br>";
				$sql = "update ".$dbkeuangan.".k_transaksi set no_bukti='',posting=0 where id = '$cdata[0]'";
				//echo $sql."<br>";
				mysql_query($sql);
								
				$sql="delete from $dbkeuangan.k_transaksi_detail where transaksi_id='$cdata[0]' AND pajak_id>0";
				//echo $sql."<br>";
				mysql_query($sql);
				//******************************
				
					/*$sql="SELECT t.*,IFNULL(td.unit_id,0) td_unit_id,IFNULL(td.nilai_sim,0) td_nilai_sim,IFNULL(td.nilai,0) td_nilai 
FROM $dbkeuangan.k_transaksi t LEFT JOIN $dbkeuangan.k_transaksi_detail td ON t.id=td.transaksi_id 
WHERE t.id='$cdata[0]' AND (td.pajak_id=0 OR td.pajak_id IS NULL)";
					echo $sql."<br>";
					$rs2=mysql_query($sql);
					while ($rw2=mysql_fetch_array($rs2)){
						if ($rw2["td_nilai"]>0){
							$nilai=$rw2["td_nilai"];
							$selisih=0;
						}else{
							$nilai=$rw2["nilai"];
							$selisih=$rw2["nilai_sim"]-$nilai;
						}
						
						$nilai2=$rw2["nilai"];
						
						$tgl=$TglBayar;
						//echo $tgl."<br>";
						$nokw=$noBukti;
						$cc_pbf_umumId=0;
						if ($rw2["jenis_supplier"]>0){
							$cc_pbf_umumId=$rw2["supplier_id"];
						}elseif ($rw2["unit_id"]>0){
							$cc_pbf_umumId=$rw2["unit_id"];
						}elseif ($rw2["td_unit_id"]>0){
							$cc_pbf_umumId=$rw2["td_unit_id"];
						}
						
						$uraian=$rw2["ket"];
						
						if ($selisih<>0){
							// jtrans = 24 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar (Supplier Obat)
							// jtrans = 23 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar (Supplier Obat)
							// jtrans = 289 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar (Supplier Umum)
							// jtrans = 290 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar (Supplier Umum)
							// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
							// ma_d = 379 = Hutang Usaha Kpd Supplier Umum
							// ma_k = 67 = Persediaan Obat & Alkes
							
							$cc_pbf_umumId_SelD=$cc_pbf_umumId;
							$cc_pbf_umumId_SelK=0;
							
							if ($rw2["jenis_supplier"]==1){
								$jtrans=24;
								$ma_d=378;
								$ma_k=67;
								if ($selisih<0){
									$jtrans=23;
									$ma_k=378;
									$ma_d=67;
									$selisih=$selisih * -1;
									$cc_pbf_umumId_SelK=$cc_pbf_umumId;
									$cc_pbf_umumId_SelD=0;
								}
							}else{
								$jtrans=289;
								$ma_d=379;
								$ma_k=80;
								if ($selisih<0){
									$jtrans=290;
									$ma_k=379;
									$ma_d=80;
									$selisih=$selisih * -1;
									$cc_pbf_umumId_SelK=$cc_pbf_umumId;
									$cc_pbf_umumId_SelD=0;
								}
							}
							
							$uraian_selisih = $uraian." : Selisih (SIM - SPK)";							
							
							$sDel = "DELETE FROM jurnal WHERE fk_sak=$ma_d AND tgl='$tgl' AND no_kw='$nokw' AND uraian='$uraian_selisih' AND FK_TRANS='$jtrans' AND CC_RV_KSO_PBF_UMUM_ID='$cc_pbf_umumId_SelD' AND d_k='D'";
							echo $sDel."<br>";
							mysql_query($sDel);
							$sDel2 = "DELETE FROM jurnal WHERE fk_sak=$ma_k AND tgl='$tgl' AND no_kw='$nokw' AND uraian='$uraian_selisih' AND FK_TRANS='$jtrans' AND CC_RV_KSO_PBF_UMUM_ID='$cc_pbf_umumId_SelK' AND d_k='K'";
							echo $sDel2."<br>";
							mysql_query($sDel2);
						}
						
						// jtrans = 26 = Pembayaran Pembelian Obat
						// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
						// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
						$jtrans=$rw2["id_trans"];
						$ma_d=$rw2["id_ma_sak"];
						$ma_k=10;
						if ($tcaraBayar==2){
							$ma_k=31;
						}elseif ($tcaraBayar==3){
							$ma_k=33;
						}
												
						$sD = "delete from jurnal where tgl='$tgl' and no_kw='$nokw' and uraian='$uraian' and FK_TRANS='$jtrans' and CC_RV_KSO_PBF_UMUM_ID='$cc_pbf_umumId'";
						echo $sD."<br>";
						mysql_query($sD);
					}
						
					$sql="delete from jurnal where tgl='$tgl' and no_kw='$nokw' and uraian='$uraian' and fk_trans='$jtrans'";
					echo $sql."<br>";
					mysql_query($sql);
					
					if ($arfdata[0]!=""){
						// jtrans = 27 = Penerimaan PPN & PPH
						// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
						// ma_k2 = 389 = Pajak penghasilan pasal 22
						// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
						$jtrans=27;
						$ma_d=10;
						$ma_dPajak=10;
						if ($tcaraBayar==2) $ma_d=31;
						$ma_k1=394;
						$ma_k2=389;
						
						$arpajak=explode(chr(6),$arfdata[0]);
						
						$nilai2=0;
						for ($i=0;$i<count($arpajak);$i++){
							$dataPajak=explode("|",$arpajak[$i]);
							$nilai1=$dataPajak[1];
							
							$sql="delete from jurnal where fk_sak='$dataPajak[0]' and tgl='$tgl' and no_kw='$nokw' and uraian='$uraian' and fk_trans='$jtrans'";
							echo $sql."<br>";			
							mysql_query($sql);
							
							$sql="delete from $dbkeuangan.k_transaksi_detail where transaksi_id='$cdata[0]'";
							echo $sql."<br>";
							mysql_query($sql);
							$nilai2 +=$nilai1;
						}
						
						$sql="delete from jurnal where tgl='$tgl' and no_kw='$nokw' and fk_trans='$jtrans'";
						echo $sql."<br>";
						mysql_query($sql);
						
						if ($TglBayarPajak!=""){
							// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
							// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
							// ma_d2 = 389 = Pajak penghasilan pasal 22
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
							$jtrans=94;
							$ma_k=10;
							$ma_kPajak=10;
							if ($tcaraBayar==2) $ma_k=31;
							$ma_d1=394;
							$ma_d2=389;
							
							$nilai2=0;
							for ($i=0;$i<count($arpajak);$i++){
								$dataPajak=explode("|",$arpajak[$i]);
								$nilai1=$dataPajak[1];
								$sql="delete from jurnal where fk_sak='$dataPajak[0]' and tgl='TglBayarPajak' and no_kw='$nokw' and uraian='$uraian' and fk_trans='$jtrans'";
								echo $sql."<br>";
								mysql_query($sql);
							}
							
							$sql="delete from jurnal where tgl='$TglBayarPajak' and no_kw='$nokw' and fk_trans='$jtrans'";
							echo $sql."<br>";
							mysql_query($sql);
						}
					}*/
						
					$sql="delete from jurnal where tgl='$TglBayar' and no_kw='$noBukti'";
					//echo $sql."<br>";
					mysql_query($sql);
					
					if ($TglBayarPajak!="" && $TglBayarPajak!=$TglBayar){
						$sql="delete from jurnal where tgl='$TglBayarPajak' and no_kw='$noBukti'";
						//echo $sql."<br>";
						mysql_query($sql);
					}
				
				//******************************
			}
			$actPosting='Unposting';
		}
		break;

	/*
		//LAWAS
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="UPDATE ".$dbkeuangan.".k_transaksi SET verifikasi=1 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()>0){
					$statusProses='Error';
				}
			}
		}else{
		}
		break;
	*/
	case "postingReturnPelayanan":
		$tanggal=$_REQUEST['tanggal'];
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tgl = $cdata[0];
				$unit_id = $cdata[1];
				$kso_id = $cdata[2];
				$nilai = $cdata[3];
				$retur_id = $cdata[4];
				$no_bukti = $cdata[5];
				
				$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$notrans=$rwPost["notrans"];
				$no_psg=$rwPost["no_psg"];
				
				$no_kw='AK.RET.PLYN/'.$tanggal;
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso_id";
				$rsCek=mysql_query($sql);
				$rwCek=mysql_fetch_array($rsCek);
				$uraian="Return Pelayanan : ".$unit." - ".$rwCek["nama"];
							
				$cek="SELECT 
				  a.JTRANS_KODE,
				  a.JTRANS_ID,
				  a.JTRANS_NAMA,
				  b.dk,
				  c.* 
				FROM
				  jenis_transaksi a 
				  INNER JOIN detil_transaksi b 
					ON a.JTRANS_ID = b.fk_jenis_trans 
				  INNER JOIN ma_sak c 
					ON b.fk_ma_sak = c.MA_ID 
				WHERE a.JTRANS_KODE LIKE '1111c%'";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
						
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$no_psg,$id_sak,'$tgl','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti','$kso_id',1)";
					mysql_query($sql);
				}
				$s_upd = "UPDATE ".$dbbilling.".b_return SET posting=1 WHERE id IN($retur_id)";
				mysql_query($s_upd);
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tgl = $cdata[0];
				$unit_id = $cdata[1];
				$kso_id = $cdata[2];
				$nilai = $cdata[3];
				$retur_id = $cdata[4];
				$no_bukti = $cdata[5];
				
				$no_kw='AK.RET.PLYN/'.$tanggal;
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso_id";
				$rsCek=mysql_query($sql);
				$rwCek=mysql_fetch_array($rsCek);
				$uraian="Return Pelayanan : ".$unit." - ".$rwCek["nama"];
							
				$cek="SELECT 
				  a.JTRANS_KODE,
				  a.JTRANS_ID,
				  a.JTRANS_NAMA,
				  b.dk,
				  c.* 
				FROM
				  jenis_transaksi a 
				  INNER JOIN detil_transaksi b 
					ON a.JTRANS_ID = b.fk_jenis_trans 
				  INNER JOIN ma_sak c 
					ON b.fk_ma_sak = c.MA_ID 
				WHERE a.JTRANS_KODE LIKE '1111c%'";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
						
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$id_sak,'$tgl','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti','$kso_id',1)";
					$sDel="DELETE FROM jurnal WHERE FK_SAK=$id_sak AND TGL='$tgl' AND URAIAN='$uraian' AND FK_TRANS=$jenistrans";
					mysql_query($sDel);
				}
				$s_upd = "UPDATE ".$dbbilling.".b_return SET posting=0 WHERE id IN($retur_id)";
				mysql_query($s_upd);
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
		// edit raga
		case "ReturnPelayanan":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if($tempat==0){
				$ftempat1 = "";
				$ftempat2 = "";
			}else{
				$ftempat1 = "AND ".$dbbilling.".u.parent_id = '".$tempat."'";
				$ftempat2 = "AND ".$dbbilling.".mu.parent_id = '".$tempat."'";
			}
			$fposting = "AND r.posting=".$_REQUEST['posting'];

			$fkso = " and kso.id=".$_REQUEST['kso'];
			$ftgl = " and r.tgl_return='".tglSQL($_REQUEST['tanggal'])."'";
			$sql="SELECT 
				  * 
				FROM
				  (SELECT
				    GROUP_CONCAT(r.id) AS id,
					r.no_return,
				    r.tgl_return AS tgl,
					u.id AS unit_id,
					u.nama AS unit_nama,
					kso.id AS kso_id,
					kso.nama AS kso_nama,
					SUM(bt.nilai) AS nilai 
				  FROM
					$dbbilling.b_return r 
					INNER JOIN $dbbilling.b_bayar_tindakan bt 
					  ON bt.id = r.bayar_tindakan_id 
					INNER JOIN $dbbilling.b_tindakan t 
					  ON t.id = bt.tindakan_id 
					INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk 
					  ON mtk.id = t.ms_tindakan_kelas_id 
					INNER JOIN $dbbilling.b_ms_tindakan mt 
					  ON mt.id = mtk.ms_tindakan_id 
					INNER JOIN $dbbilling.b_pelayanan pl 
					  ON pl.id = t.pelayanan_id 
					INNER JOIN $dbbilling.b_ms_pasien ps 
					  ON ps.id = pl.pasien_id 
					INNER JOIN $dbbilling.b_ms_unit u 
					  ON u.id = pl.unit_id 
					INNER JOIN $dbbilling.b_ms_kso kso 
					  ON kso.id = pl.kso_id 
				  WHERE bt.tipe = 0 
					$ftgl
					$fkso
					$ftempat1
					$fposting
				  GROUP BY u.nama 
				  UNION
				  ALL 
				  SELECT
				    GROUP_CONCAT(r.id) AS id,
					r.no_return,
				    r.tgl_return AS tgl,
					mu.id AS unit_id,
					mu.nama AS unit_nama,
					kso.id AS kso_id,
					kso.nama AS kso_nama,
					SUM(bt.nilai) AS nilai 
				  FROM
					$dbbilling.b_pelayanan p 
					INNER JOIN $dbbilling.b_ms_unit mu 
					  ON p.unit_id = mu.id 
					INNER JOIN $dbbilling.b_tindakan_kamar t 
					  ON p.id = t.pelayanan_id 
					LEFT JOIN $dbbilling.b_ms_unit n 
					  ON n.id = mu.parent_id 
					INNER JOIN $dbbilling.b_ms_kamar tk 
					  ON tk.id = t.kamar_id 
					INNER JOIN $dbbilling.b_bayar_tindakan bt 
					  ON bt.tindakan_id = t.id 
					INNER JOIN $dbbilling.b_tindakan ti 
					  ON ti.id = bt.tindakan_id 
					INNER JOIN $dbbilling.b_ms_tindakan_kelas btk 
					  ON btk.id = ti.ms_tindakan_kelas_id 
					INNER JOIN $dbbilling.b_ms_tindakan mt 
					  ON mt.id = btk.ms_tindakan_id 
					INNER JOIN $dbbilling.b_ms_kelas mk 
					  ON mk.id = btk.ms_kelas_id 
					INNER JOIN $dbbilling.b_return r 
					  ON r.bayar_tindakan_id = bt.id 
					INNER JOIN $dbbilling.b_ms_pasien ps 
					  ON ps.id = p.pasien_id 
					INNER JOIN $dbbilling.b_ms_kso kso 
					  ON kso.id = p.kso_id 
				  WHERE bt.tipe = 1 
					AND p.jenis_kunjungan = 3 
					$ftgl
					$fkso
					$ftempat2
					$fposting
				  GROUP BY mu.nama) AS tbl1";
			break;
		case "loadkasir":
			$dt='<option value="0">SEMUA</option>';
			$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
            while($wTmp = mysql_fetch_array($qTmp)){
				$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
			}
			echo $dt;
			return;
			break;
		case "pendBilling":
			$defaultsort="kode";
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$sql="SELECT t3.*,t4.* FROM (SELECT t1.* FROM 
(SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit 
WHERE ".$dbbilling.".b_ms_unit.aktif=1 AND ".$dbbilling.".b_ms_unit.kategori=2 AND ".$dbbilling.".b_ms_unit.level=2 $fUnit 
ORDER BY ".$dbbilling.".b_ms_unit.kode) AS t1 
LEFT JOIN (SELECT * FROM ak_posting WHERE tipe=1 AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal') AS t2 ON t1.id=t2.id_cc_rv
WHERE t2.id IS NULL) AS t3 INNER JOIN (SELECT p.unit_id,IFNULL(SUM(t.qty*t.biaya),0) AS biayaRS,IFNULL(SUM(t.qty*t.biaya_kso),0) AS biayaKSO,IFNULL(SUM(t.qty*t.biaya_pasien),0) AS biayaPx 
FROM ".$dbbilling.".b_tindakan_ak t INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id 
WHERE t.kso_id='$kso' AND t.tgl='$tanggal' AND t.tipe_pendapatan=0 GROUP BY p.unit_id) AS t4 ON t3.id=t4.unit_id ".$filter." ORDER BY $sorting";
			}else{
				$sql="SELECT p.*,mu.nama FROM ak_posting p INNER JOIN ".$dbbilling.".b_ms_unit mu ON p.id_cc_rv=mu.id WHERE tipe=1 AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal' ".$fUnit.$filter." ORDER BY $sorting";
			}
			break;
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
					$fkso=" AND m.IDMITRA='".$_REQUEST['kso']."'";
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
						k.no_bukti no_slip
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
			//echo $sql."<br>";
			break;
		case "ReturnJualObat":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 $fUnit ORDER BY $sorting";
			break;
		case "PemakaianFS":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			$sql = "SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 ORDER BY $sorting";
			break;
		case "ReturnPBF":
			if ($posting==0){
				$sql = "SELECT ar.RETUR_ID id,a_pbf.PBF_ID,ap.KEPEMILIKAN_ID,DATE_FORMAT(ar.TGL,'%d-%m-%Y') AS TGL,ar.TGL AS TGL_TRANS, ar.NO_RETUR, ar.NO_FAKTUR, ar.QTY, ar.KET, DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tglfaktur,FLOOR(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,
			ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI 
	FROM ".$dbapotek.".a_penerimaan_retur ar INNER JOIN ".$dbapotek.".a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
	INNER JOIN ".$dbapotek.".a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN ".$dbapotek.".a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
	INNER JOIN ".$dbapotek.".a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k 
	ON ar.KEPEMILIKAN_ID = k.ID LEFT JOIN (SELECT * FROM ak_posting WHERE tipe=6 AND tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') akp ON ar.RETUR_ID=akp.id_cc_rv 
	WHERE ar.TGL BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND id_cc_rv IS NULL";
			}else{
				$sql = "SELECT akp.id,a_pbf.PBF_ID,ap.KEPEMILIKAN_ID,DATE_FORMAT(ar.TGL,'%d-%m-%Y') AS TGL,ar.TGL AS TGL_TRANS, ar.NO_RETUR, ar.NO_FAKTUR, ar.QTY, ar.KET, DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tglfaktur,FLOOR(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,
			ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI, ar.RETUR_ID id 
	FROM (SELECT * FROM ak_posting WHERE tipe=6 AND tgl_trans BETWEEN '$tanggalAwal' AND '$tanggalAkhir') akp INNER JOIN ".$dbapotek.".a_penerimaan_retur ar ON akp.id_cc_rv=ar.RETUR_ID INNER JOIN ".$dbapotek.".a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
	INNER JOIN ".$dbapotek.".a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN ".$dbapotek.".a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
	INNER JOIN ".$dbapotek.".a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN ".$dbapotek.".a_kepemilikan k 
	ON ar.KEPEMILIKAN_ID = k.ID 
	WHERE ar.TGL BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
			}
			break;
		case "penerimaanBilling":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$sql="SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 ".$fUnit.$filter." ORDER BY $sorting";
			}else{
				$sql="SELECT p.*,mu.nama FROM ak_posting p INNER JOIN ".$dbbilling.".b_ms_unit mu ON p.id_cc_rv=mu.id WHERE tipe=2 AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
			}
			break;
		case "penerimaanBillingKasir":			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($sorting=="") {
				$sorting="nama,unit";
			}
			
			if ($posting==0){
				if ($kasir=="0"){
					$fkasir="";
				}else{
					$fkasir=" AND b.user_act=".$kasir;
				}
				$sql="SELECT * FROM (SELECT t1.*,mu.nama unit,kso.nama kso,mp.nama FROM
(SELECT gab.unit_id,gab.kso_id,gab.user_act,SUM(nilai) nilai FROM 
(SELECT bbt.*,p.unit_id FROM (SELECT bt.*,b.user_act FROM ".$dbbilling.".b_bayar b INNER JOIN ".$dbbilling.".b_bayar_tindakan bt ON b.id=bt.bayar_id 
WHERE b.tgl='$tanggal'".$fkasir." AND bt.nilai>0 AND bt.tipe=0) AS bbt 
INNER JOIN ".$dbbilling.".b_tindakan t ON bbt.tindakan_id=t.id INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id
UNION
SELECT bbt.*,p.unit_id FROM (SELECT bt.*,b.user_act FROM ".$dbbilling.".b_bayar b INNER JOIN ".$dbbilling.".b_bayar_tindakan bt ON b.id=bt.bayar_id 
WHERE b.tgl='$tanggal'".$fkasir." AND bt.nilai>0 AND bt.tipe=1) AS bbt 
INNER JOIN ".$dbbilling.".b_tindakan_kamar t ON bbt.tindakan_id=t.id INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id) AS gab 
GROUP BY gab.kso_id,gab.unit_id,gab.user_act) AS t1 INNER JOIN ".$dbbilling.".b_ms_unit mu ON t1.unit_id=mu.id
INNER JOIN ".$dbbilling.".b_ms_kso kso ON t1.kso_id=kso.id INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON t1.user_act=mp.id) as t2".$filter." ORDER BY ".$sorting;
			}else{
				if ($kasir=="0"){
					$fkasir="";
				}else{
					$fkasir=" AND p.no_terima='".$kasir."'";
				}
				$sql="SELECT * FROM (SELECT p.*,mu.nama unit,kso.nama kso,mp.nama FROM ak_posting p INNER JOIN ".$dbbilling.".b_ms_unit mu ON p.id_cc_rv=mu.id INNER JOIN ".$dbbilling.".b_ms_kso kso ON p.id_kso_pbf_umum=kso.id INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON p.no_terima=mp.id WHERE p.tipe=17".$fkasir." AND p.tgl_trans='$tanggal') as gab".$filter." ORDER BY ".$sorting;
			}
			break;
		case "PenerimaanBillingManual":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$sql="SELECT t.*,DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tglk,kso.nama 
FROM ".$dbkeuangan.".k_transaksi t INNER JOIN ".$dbbilling.".b_ms_kso kso ON t.kso_id=kso.id 
WHERE t.id_trans=0 AND MONTH(t.tgl)=$bulan AND YEAR(t.tgl)=$tahun AND posting=0";
			}else{
				$sql="SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') AS tglk,kso.nama 
FROM ak_posting p INNER JOIN ".$dbkeuangan.".k_transaksi t ON p.id_cc_rv=t.id INNER JOIN ".$dbbilling.".b_ms_kso kso ON t.kso_id=kso.id 
WHERE p.tipe=16 AND MONTH(p.tgl_trans)=$bulan AND YEAR(p.tgl_trans)=$tahun";
			}
			break;
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
		case "PenerimaanLain":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$sql="SELECT t.*,DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tglk,mt.nama 
FROM ".$dbkeuangan.".k_transaksi t INNER JOIN ".$dbkeuangan.".k_ms_transaksi mt ON t.id_trans=mt.id 
WHERE mt.tipe=1 AND MONTH(t.tgl)=$bulan AND YEAR(t.tgl)=$tahun AND posting=0 AND mt.id<>38";
			}else{
				/*$sql="SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') AS tglk,mt.nama FROM ak_posting p INNER JOIN ".$dbkeuangan.".k_ms_transaksi mt ON p.id_cc_rv=mt.id WHERE p.tipe=15 AND MONTH(p.tgl_trans)=$bulan AND YEAR(p.tgl_trans)=$tahun";*/
				$sql="SELECT p.*,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') AS tglk,mt.nama,t.id id_kt,t.id_trans 
FROM ak_posting p INNER JOIN ".$dbkeuangan.".k_transaksi t ON p.id_cc_rv=t.id INNER JOIN ".$dbkeuangan.".k_ms_transaksi mt ON t.id_trans=mt.id 
WHERE p.tipe=15 AND MONTH(p.tgl_trans)=$bulan AND YEAR(p.tgl_trans)=$tahun";
			}
			break;
		case "HapusObat":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
				$sql = "SELECT ".$dbapotek.".a_obat_hapus.ID_HAPUS,".$dbapotek.".a_obat_hapus.TGL_HAPUS, ".$dbapotek.".a_obat_hapus.NO_HAPUS, ".$dbapotek.".a_unit.UNIT_NAME, ".$dbapotek.".a_obat.OBAT_ID, ".$dbapotek.".a_obat.OBAT_NAMA, ".$dbapotek.".a_kepemilikan.NAMA, SUM(".$dbapotek.".a_obat_hapus.QTY) AS QTY, SUM(".$dbapotek.".a_obat_hapus.QTY*p.HARGA_BELI_SATUAN * (1-(p.DISKON/100) * 1.1)) AS nilai, ".$dbapotek.".a_obat_hapus.ALASAN
				FROM  ".$dbapotek.".a_obat INNER JOIN ".$dbapotek.".a_obat_hapus ON (".$dbapotek.".a_obat.OBAT_ID = ".$dbapotek.".a_obat_hapus.OBAT_ID) 
				INNER JOIN ".$dbapotek.".a_kepemilikan ON (".$dbapotek.".a_kepemilikan.ID = ".$dbapotek.".a_obat_hapus.KEPEMILIKAN_ID) 
				INNER JOIN ".$dbapotek.".a_unit ON (".$dbapotek.".a_unit.UNIT_ID = ".$dbapotek.".a_obat_hapus.UNIT_ID) 
				INNER JOIN ".$dbapotek.".a_penerimaan p ON p.ID=".$dbapotek.".a_obat_hapus.PENERIMAAN_ID
				WHERE ".$dbapotek.".a_obat_hapus.POSTING=$posting AND (MONTH(".$dbapotek.".a_obat_hapus.TGL_HAPUS)=$bulan AND YEAR(".$dbapotek.".a_obat_hapus.TGL_HAPUS)=$tahun) ".$filter."
				GROUP BY ".$dbapotek.".a_obat_hapus.NO_HAPUS, ".$dbapotek.".a_unit.UNIT_NAME, ".$dbapotek.".a_obat.OBAT_NAMA, ".$dbapotek.".a_kepemilikan.NAMA";
			break;
		case "PengurangPendBilling":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			
			if ($bayar==1){
				$fbayar="AND t.bayar_pasien>0";
				$ftipeByr="tipe=9";
			}else{
				$fbayar="AND t.bayar_pasien=0";
				$ftipeByr="tipe=8";
			}
			
			if ($posting==0){
				$sql="SELECT ".$dbbilling.".b_ms_unit.* FROM ".$dbbilling.".b_ms_unit WHERE ".$dbbilling.".b_ms_unit.aktif=1 and ".$dbbilling.".b_ms_unit.kategori=2 and ".$dbbilling.".b_ms_unit.level=2 ".$fUnit.$filter." ORDER BY $sorting";
			}else{
				$sql="SELECT p.*,mu.nama FROM ak_posting p INNER JOIN ".$dbbilling.".b_ms_unit mu ON p.id_cc_rv=mu.id WHERE $ftipeByr AND id_kso_pbf_umum=$kso AND tgl_trans='$tanggal'";
			}
			break;
		case "pengeluaranLain":
			if ($sorting=="") {
				$sorting="id";
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($tipe==1){
				//$strTipe=" and t.jenis_supplier>0";
				$strSupplier=" AND t.jenis_supplier=$cmbSupplier";
			}else{
				//$strTipe=" and t.jenis_supplier=0";
				$strSupplier=" and t.jenis_supplier=0";
			}
			
			$strPosting=" and t.verifikasi='0'";
			if ($posting==1){
				$strPosting=" and t.verifikasi='1' and t.posting='0'";
			}elseif($posting==2){
				$strPosting=" and t.verifikasi='1' and t.posting='1'";
			}
			
			$sql2 = "select * from (select t.id, id_trans, jt.JTRANS_NAMA as nama_trans, date_format(tgl,'%d-%m-%Y') as tgl, no_bukti,t.no_faktur, t.jenis_layanan
		 , uj.nama as nama_jl, unit_id, ut.nama as nama_tl, nilai_sim, nilai, IF((t.no_faktur='' OR t.no_faktur IS NULL),t.ket,CONCAT(t.ket,' (',t.no_faktur,')')) ket,t.ket ket1, IF(t.verifikasi=1,'Sudah','Belum') verifikasi,t.verifikasi verifikasiId, jenis_supplier,IF(jenis_supplier='1','(Supplier Obat)',IF(jenis_supplier='2','(Supplier Barang)','')) as nama_jenis_supplier, supplier_id
			from ".$dbkeuangan.".k_transaksi t
			left join ".$dbakuntansi.".ak_ms_unit uj on t.jenis_layanan = uj.id
			left join ".$dbakuntansi.".ak_ms_unit ut on t.unit_id = ut.id
			INNER JOIN ".$dbakuntansi.".jenis_transaksi jt ON t.id_trans = jt.JTRANS_ID
			where tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND t.tipe_trans='2'".$strSupplier.$strPosting.") a1 $filter";
			//echo $sql2."<br>";
			$sql=$sql2." ORDER BY ".$sorting;
			$sqlTot="SELECT SUM(nilai) AS jmldppppn FROM (".$sql2.") AS ttot";
			//echo $sqlTot."<br>";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$totnilai=$rwTot["jmldppppn"];
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
						$dt.=$rows["kso_id"]."|".$rows["tgl"]."|".$rows["id_trans"]."|".$rows["id"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["no_faktur"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
					//}
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["biayaKSO_DPP"];
					
					$i++;
					$dt.=$rows["id_kso_pbf_umum"]."|".$rows["tgl_trans"]."|".$rows["id_cc_rv"].chr(3).$i.chr(3).$rows["tglk"].chr(3).$rows["no_bukti"].chr(3).$rows["no_faktur"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
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
				
				$dt.=$rows["id"]."|".$rows["id_trans"]."|".$detail."|".number_format($ntot,0,",",".").chr(3).$i.chr(3).date("d/m/Y",strtotime($rows['tgl'])).chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows["ket"].$cket.chr(3)."0".chr(6);
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
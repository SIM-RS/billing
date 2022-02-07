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
$statusProses='';
$alasan='';
//===============================
$id_sak_Bank_BLUD=33;
$IdTrans=36;

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
$useProgress = $_REQUEST['useProgress'];
$tanggalAsli=$_REQUEST['tanggal'];
$tanggalan = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggalan[2].'-'.$tanggalan[1].'-'.$tanggalan[0];
$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tanggalAwal = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tanggalAkhir = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
//===============================
$IdTransUmum=3;///===1101 - Terjadinya Transaksi Pendapatan
$IdTransKSO=3;///===1101 - Terjadinya Transaksi Pendapatan
$IdTransKSO_Lebih=10;///===1121b - Terjadinya Transaksi Pendapatan Selisih Lebih (Tarif Pemda - Tarif KSO)
$IdTransKSO_Kurang=11;///===1121c - Terjadinya Transaksi Pendapatan Selisih Kurang (Tarif Pemda - Tarif KSO)
$IdTransPemda=16;///===	113a - Terjadinya Transaksi Pendapatan
$Idma_sak_d_umum=375;//===113010101 - Piutang Pasien Umum
$Idma_sak_d_kso_px=375;//===113010102 - Piutang Pasien Kerjasama dengan pihak ke III beban pasien
$Idma_sak_d_kso_kso=375;//===113010103 - Piutang Pasien Kerjasama dengan pihak ke III beban pihak ke III
$Idma_sak_d_kso_pemda=375;//===113010104 - Piutang Pasien Subsidi Pemda
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
	case "postingBilling":
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$ckso_id=$cdata[9];
				$idUserKasir=$cdata[10];
				$no_bukti=$cdata[11];
				
				$idpost=gmdate('YmdHis',mktime(date('H')+7)).rand(1,1000);
				
				//$sql="UPDATE $dbkeuangan.k_piutang SET posting=1,user_posting='$idUser',tgl_posting=NOW() WHERE id=$cdata[0]";
				$sql="UPDATE $dbkeuangan.k_piutang,
						  $dbbilling.b_kunjungan
						SET fk_id = '$idpost',
						  posting = 1,
						  user_posting = '$idUser',
						  tgl_posting = NOW()
						WHERE $dbkeuangan.k_piutang.kunjungan_id = $dbbilling.b_kunjungan.id
							AND $dbkeuangan.k_piutang.tglP = '$tanggal'
							AND $dbkeuangan.k_piutang.kso_id = '$ckso_id'
							AND $dbbilling.b_kunjungan.user_act_pulang = '$idUserKasir'";
				//echo $sql.";<br>";
				$rsPost=mysql_query($sql);
				if (mysql_affected_rows()>0){
					/*$sql="UPDATE $dbkeuangan.k_transaksi
							SET $dbkeuangan.k_transaksi.no_post = '$idpost'
							WHERE $dbkeuangan.k_transaksi.tgl_klaim = '$tanggal' 
								AND $dbkeuangan.k_transaksi.id_trans = '$IdTrans'
								AND $dbkeuangan.k_transaksi.fk_id IN
								(SELECT id FROM k_piutang WHERE fk_id='$idpost' AND kso_id='$ckso_id' AND tglP='$tanggal')";*/
					$sql="UPDATE $dbkeuangan.k_transaksi
							SET $dbkeuangan.k_transaksi.no_post = '$idpost'
							WHERE $dbkeuangan.k_transaksi.tgl_klaim = '$tanggal' 
								AND $dbkeuangan.k_transaksi.id_trans = '$IdTrans'
								AND $dbkeuangan.k_transaksi.fk_id IN
								(SELECT DISTINCT
								  kp.id
								FROM $dbkeuangan.k_piutang kp
								  INNER JOIN $dbbilling.b_kunjungan k
									ON kp.kunjungan_id = k.id
								WHERE kp.fk_id = '$idpost'
									AND kp.kso_id = '$ckso_id'
									AND kp.tglP = '$tanggal'
									AND k.user_act_pulang = '$idUserKasir')";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					/*$sql="SELECT mp.no_rm FROM $dbbilling.b_kunjungan k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id WHERE k.id='$cdata[1]'";
					echo $sql.";<br>";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$no_rm=$rw1["no_rm"];*/
					
					$sql="SELECT nama FROM $dbbilling.b_ms_pegawai where id = '$idUserKasir' ";
					//echo $sql.";<br>";
					$rs1=mysql_query($sql);
					$rw1=mysql_fetch_array($rs1);
					$nama_user=$rw1["nama"];
					
					//$sql="SELECT IFNULL(SUM(nilai),0) as nilai,kso_id FROM $dbkeuangan.k_transaksi WHERE fk_id=$cdata[0]";
					$sql="SELECT
							  IFNULL(SUM(kt.nilai_sim),0) AS nilai_sim,
							  IFNULL(SUM(kt.nilai),0) AS nilai,
							  IFNULL(SUM(kt.nilai_hpp),0) AS nilai_hpp,
							  kt.kso_id
							FROM $dbkeuangan.k_transaksi kt
							  INNER JOIN $dbkeuangan.k_piutang kp
								ON kt.fk_id = kp.id
							  INNER JOIN $dbbilling.b_kunjungan k
								ON kp.kunjungan_id = k.id
							WHERE k.user_act_pulang = '$idUserKasir'
								AND kp.tglP = '$tanggal'
								AND kt.id_trans = '36'
								AND kp.kso_id = '$ckso_id'";
					//echo $sql.";<br>";
					$rsTrans=mysql_query($sql);
					$rwTrans=mysql_fetch_array($rsTrans);
					// $npymad=$rwTrans["nilai"];
					$npymad=$rwTrans["nilai_sim"];
					// NILAI YANG DIAMBIL ADALAH BIAYA RS BUKAN BIAYA KSO, DARI NILAI KE NILAI_SIM
					//MELLY

					//$kso_id=$rwTrans["kso_id"];
					$kso_id=$ckso_id;
					
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id='$kso_id'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];

					//PERUBAHAN PROSES BISNIS COA UNTUK PENDAPATAN NON TUNAI
					// decyber
					$status_rekanan = $rwPost['status_rekanan'];

					//status kso dari b_ms_kso di BPJS - DINAS
					if($status_rekanan == 1){ 
						// $pymad=375;	//112.04.10.11 - PYMAD - Pers. Swasta Rumah Sakit IDR
						$pymad=2242;	//1.1.07.02.00.00 - Piutang yang belum difakturkan
						// == permintaan kantor pusat (20/12/2019)
						// $pymad = 2310; //1.1.05.03.06.00 - ENTITAS LAINNYA YANG DI KENDALIKAN PEMERINTAH RI
						// == PPN dialihkan ke farmasi
						$akunppn=1415; // 4.1.40.07.01 - Pelayanan Farmasi - Pelanggan Eksternal
						$flag_sementara = $flag;


					//status kso dari b_ms_kso di PERUSAHAAN SWASTA
					}else if($status_rekanan == 2){ 
						$pymad=13;	//1.1.05.01.01 - Piutang Swasta
						$akunppn=1415; // 4.1.40.07.01 - Pelayanan Farmasi - Pelanggan Eksternal
						$flag_sementara = $flag;


					//status kso dari b_ms_kso di PERUSAHAAN BUMN
					}else if($status_rekanan == 3){ 
						$pymad=2310;	//1.1.05.03.06.00 - ENTITAS LAINNYA YANG DI KENDALIKAN PEMERINTAH RI
						$akunppn=1415; // 4.1.40.07.01 - Pelayanan Farmasi - Pelanggan Eksternal
						$flag_sementara = $flag;


					//status kso dari b_ms_kso di PEGAWAI PELINDO
					}else if($status_rekanan == 4){ 
						$pymad=1430;	//4.1.40.23 - HEALTH CARE
						$akunppn=1414; // 4.1.40.07.01 - Pelayanan Farmasi - Pelanggan Internal
						$flag_sementara = 0;

					}

					// $akunppn=1226;	//423.01.00.11 - Hutang PPN  - PPN Keluaran IDR
					//$akunppn=2234;	//2.1.11.02.01 - PPN Keluaran
					// $akun_utip=4134;	//414.99.00.00 - Utip - Lainnya
					$akun_utip=2274;	//2.1.25.02 - Uang Titipan (UTIP)
				
					$jenistrans=3;
					
					//$nokw="$tanggalAsli/$no_rm";
					$nokw=$no_bukti;
					$uraian="Pendapatan ".':'." ".$tanggalAsli." - ".$ksoNama." - KASIR : ".$nama_user;
					//$uraian="Pendapatan ".$unit." ".$tanggalAsli." - ".$ksoNama." - KASIR : ".$nama_user;
					//$idpost=gmdate('YmdHis',mktime(date('H')+7)).rand(1,1000);
					
						//if ($kso_id==1){
							//$jenistrans=3;
							//$jenistrans=$IdTransUmum;
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
		VALUES('$idpost',$notrans,1,'$pymad','$tanggal','$nokw','$uraian','$npymad',0,now(),$idUser,'D',3,0,$jenistrans,$jenistrans,1,'',$kso_id,'0',1,'$flag_sementara')";
						// echo $sql.";<br>";
						$rsPost=mysql_query($sql);
					
					//$sql="SELECT * FROM $dbkeuangan.k_transaksi WHERE fk_id=$cdata[0]";
					$sql="SELECT
							  kt.unit_id_billing,
							  kt.isFarmasi,  
							  IFNULL(SUM(kt.nilai_sim),0) AS nilai_sim,
							  IFNULL(SUM(kt.nilai),0) AS nilai,
							  IFNULL(SUM(kt.nilai_hpp),0) AS nilai_hpp,
							  kt.kso_id
							FROM rspelindo_keuangan.k_transaksi kt
							  INNER JOIN rspelindo_keuangan.k_piutang kp
								ON kt.fk_id = kp.id
							  INNER JOIN rspelindo_billing.b_kunjungan k
								ON kp.kunjungan_id = k.id
							WHERE k.user_act_pulang = '$idUserKasir'
								AND kp.tglP = '$tanggal'
								AND kt.id_trans = '36'
								AND kp.kso_id = '$kso_id'
							GROUP BY kt.unit_id_billing,kt.isFarmasi";
					//echo $sql.";<br>";
					$rsTrans=mysql_query($sql);
					while ($rwTrans=mysql_fetch_array($rsTrans)){
						//$id_k_trans=$rwTrans["id"];
						$unit_id_billing=$rwTrans["unit_id_billing"];
						$kso_id=$rwTrans["kso_id"];
						$cisFarmasi=$rwTrans["isFarmasi"];
						$biayaRS=$rwTrans["nilai_sim"];
						$biayaKSO=$rwTrans["nilai"];
						$biayaPx=$rwTrans["nilai_hpp"];
						$iurPx=$biayaPx;
						$selisih=$biayaRS-($biayaKSO+$biayaPx);
						//echo "perda=".$biayaRS.", kso=".$biayaKSO.", px=".$biayaPx."<br>";
						//======insert into jurnal========
						//$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id_billing";
						$sql="SELECT rv.* FROM ak_ms_unit rv WHERE id=$unit_id_billing";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$idunit=$rwPost["id"];
						$unit=$rwPost["nama"];
						$kdunit=$rwPost["kode"];
						$akunPendInternal=$rwPost["akun_pend_internal"];
						$akunPendEksternal=$rwPost["akun_pend_eksternal"];
						
						$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id='$kso_id'";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$ksoNama=$rwPost["nama"];
						
						$kdkso=$rwPost["kode_ak"];
						$ckso_type=$rwPost["tipe_kso"];
						if ($ckso_type==1){
							$ma_pend=$akunPendInternal;
						}else{
							$ma_pend=$akunPendEksternal;
						}
						
						// $nilaiPend=$biayaKSO;
						$nilaiPend=$biayaRS;
						// DATA BILLING YANG MASUK KE DALAM JURNAL ADALAH SESUAI DENGAN BIAYA RS, BUKAN BIAYA KSO
						//MELLY 20 APRIL 2020
						
						/*$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
						$rsPost=mysql_query($sql);
						$rwPost=mysql_fetch_array($rsPost);
						$no_psg=$rwPost["no_psg"];*/
						$no_psg=1;

						if ($unit_id_billing>0){
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
		VALUES('$idpost',$notrans,$no_psg,'$ma_pend','$tanggal','$nokw','$uraian',0,$nilaiPend,now(),$idUser,'K',3,0,$jenistrans,$jenistrans,1,'','$unit_id_billing','$unit_id_billing',1,'$flag')";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							/*if ($biayaKSO>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_k_trans,$notrans,$no_psg,$cfksak_bkso,'$tanggal','$nokw','$uraian',$biayaKSO,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso_id,$idunit,1)";
								echo $sql.";<br>";
								$rsPost=mysql_query($sql);
							//}*/
							/*if ($biayaPx>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_k_trans,$notrans,$no_psg,$cfksak_bpasien,'$tanggal','$nokw','$uraian',$biayaPx,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',$kso_id,$idunit,1)";
								//echo $sql."<br>";
								$rsPost=mysql_query($sql);
							}*/
						}else{
							if ($cisFarmasi==3){
								//============ PPN =============
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			VALUES('$idpost',$notrans,$no_psg,'$akunppn','$tanggal','$nokw','$uraian',0,$biayaRS,now(),$idUser,'K',3,0,$jenistrans,$jenistrans,1,'','0','0',1,'$flag')";

								//DIGANTI MENJADI BIAYA RS BUKAN BIAYA KSO LAGI
								//MELLY

			// 					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// VALUES('$idpost',$notrans,$no_psg,'$akunppn','$tanggal','$nokw','$uraian',0,$biayaKSO,now(),$idUser,'K',3,0,$jenistrans,$jenistrans,1,'','0','0',1,'$flag')";
								//echo $sql.";<br>";
								$rsPost=mysql_query($sql);
							}else{
								//============ UTIP =============
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			VALUES('$idpost',$notrans,$no_psg,'$akun_utip','$tanggal','$nokw','$uraian',0,$biayaKSO,now(),$idUser,'K',3,0,$jenistrans,$jenistrans,1,'','0','0',1,'$flag')";
					//DIGANTI MENJADI BIAYA RS BUKAN BIAYA KSO LAGI
													//MELLY
			// 					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,TIPE_JURNAL,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// VALUES('$idpost',$notrans,$no_psg,'$akun_utip','$tanggal','$nokw','$uraian',0,$biayaKSO,now(),$idUser,'K',3,0,$jenistrans,$jenistrans,1,'','0','0',1,'$flag')";
								//echo $sql.";<br>";
								$rsPost=mysql_query($sql);
							}
						}
							/*$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($id_k_trans,$notrans,$no_psg,$cfksak_pendptn,'$tanggal','$nokw','$uraian',0,$biayaRS,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
							echo $sql.";<br>";
							$rsPost=mysql_query($sql);*/
						
							/*if ($cselisih>0){
								$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
			VALUES($id_k_trans,$notrans,$no_psg,$cfksak_selisih,'$tanggal','$nokw','$uraian',$cselisihD,$cselisihK,now(),$idUser,'$dk',0,$jenistrans,$jenistrans,1,'',$idunit,$idunit,1)";
								//echo $sql."<br>";
								$rsPost=mysql_query($sql);
							}*/
						//}
					}
				}else{
					$statusProses='Error';
					$alasan='Posting Gagal';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode("|",$arfdata[$i]);
				$ckso_id=$cdata[9];
				$idUserKasir=$cdata[10];
				$no_bukti=$cdata[11];
				$idpost=$cdata[12];
				
				//$sql = "UPDATE $dbkeuangan.k_piutang SET posting=0,user_posting=0 WHERE id=$cdata[0]";
				$sql="UPDATE $dbkeuangan.k_piutang,
						  $dbbilling.b_kunjungan
						SET fk_id = '0',
						  posting = 0,
						  user_posting = '0'
						WHERE $dbkeuangan.k_piutang.kunjungan_id = $dbbilling.b_kunjungan.id
							AND $dbkeuangan.k_piutang.tglP = '$tanggal'
							AND $dbkeuangan.k_piutang.kso_id = '$ckso_id'
							AND $dbbilling.b_kunjungan.user_act_pulang = '$idUserKasir'";
				//echo $sql."<br>";
				$kueri = mysql_query($sql);
				if (mysql_affected_rows()>0){
					/*$sql = "SELECT * FROM $dbkeuangan.k_transaksi WHERE fk_id=$cdata[0]";
					//echo $sql."<br>";
					$kueri = mysql_query($sql);
					while ($row = mysql_fetch_array($kueri)){
						$fk_id=$row["id"];*/
						$sJ = "DELETE 
							FROM
							  $dbakuntansi.jurnal 
							WHERE FK_ID_POSTING='$idpost' AND FK_ID_POSTING<>0";
						//echo $sJ."<br>";
						$qJ = mysql_query($sJ);
						if (mysql_errno()>0){
							$statusProses='Error';
							$alasan='UnPosting Gagal';
						}
					//}
				}else{
					$statusProses='Error';
					$alasan='UnPosting Gagal';
				}
			}
			$actPosting='Unposting';
		}
	
		if ($useProgress==1){
			echo $statusProses;
			return;
		}
		break;
}

if($tempat==0){
	$fUnit = "";
}else{
	$fUnit = "AND ".$dbbilling.".b_ms_unit.parent_id = '".$tempat."'";
}

if(($statusProses=='') && ($act=='postingBilling')) {
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
		case "pendBilling":
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
			$sql = "SELECT
					  kp.id,
					  kp.fk_id AS fk_id_post,
					  k.id AS fk_id,
					  kp.no_bukti,
					  pas.no_rm,
					  pas.nama AS pasien,
					  k.kso_id,
					  kso.nama     kso,
					  mu.nama      unit,
					  k.user_act_pulang,
					  mp.nama           AS namaKasir,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  SUM(kp.biayaRS)   AS biayaRS,
					  SUM(kp.biayaPasien) AS biayaPasien,
					  SUM(kp.biayaKSO)  AS biayaKSO,
					  SUM(kp.bayarPasien) AS bayarPasien,
					  SUM(kp.piutangPasien) AS piutangPasien
					FROM $dbkeuangan.k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON k.kso_id = kso.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON k.user_act_pulang = mp.id
					WHERE kp.flag = '$flag' AND kp.tglP = '$tanggal' AND kp.tipe=0 /*$fkso*/ $fposting $filter
					GROUP BY k.user_act_pulang,kp.kso_id";

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
			
		case "pendBillingDetail":
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
			$sql = "SELECT
					  kp.id,
					  kp.fk_id AS fk_id_post,
					  k.id AS fk_id,
					  pas.no_rm,
					  pas.nama AS pasien,
					  k.kso_id,
					  kso.nama     kso,
					  mu.nama      unit,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  SUM(kp.biayaRS)   AS biayaRS,
					  SUM(kp.biayaPasien) AS biayaPasien,
					  SUM(kp.biayaKSO)  AS biayaKSO,
					  SUM(kp.bayarPasien) AS bayarPasien,
					  SUM(kp.piutangPasien) AS piutangPasien
					FROM $dbkeuangan.k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON k.kso_id = kso.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON k.user_act_pulang = mp.id
					WHERE kp.tglP = '$tanggal' AND kp.tipe=0 /*$fkso*/ $fposting
					GROUP BY k.user_act_pulang";

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
		case "pendBilling":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$tmpLay = $rows["unit"];
				//$kso = $rows["kso"];
				$tPerda=$rows["biayaRS"]+$rows["kamarRS"];
				$tKSO=$rows["biayaKSO"]+$rows["kamarKSO"];
				$tPx=$rows["biayaPasien"]+$rows["kamarPasien"];
				$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
				$tPiutangPx=$tPx-$tBayarPx;
				$sisip=$rows["id"]."|".$rows["fk_id"]."|".$rows["tgl"]."|".$rows["tgl_p"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx."|".$rows["kso_id"]."|".$rows["user_act_pulang"]."|".$rows["no_bukti"]."|".$rows["fk_id_post"];
				$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_p"].chr(3).$rows["namaKasir"].chr(3).$rows["kso"].chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).number_format($tPiutangPx,0,",",".").chr(3)."0".chr(6);
				$tmpLay = '';
			}
			break;
			
		case "pendBillingDetail":
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
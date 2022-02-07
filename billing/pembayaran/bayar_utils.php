<?php 
include("../koneksi/konek.php");
include("../sesi.php");
$grd = strtolower($_REQUEST["grd"]);
$grd1 = strtolower($_REQUEST["grd1"]);
$grd2 = strtolower($_REQUEST["grd2"]);
$msg = "";
$versi=$_REQUEST["versi"];
if($versi!='4'){
	$msg="Maaf, Sistem Pembayaran Telah Mengalami Perubahan, Silahkan Melakukan Pembayaran Ulang dengan Menekan tombol F5!";
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']).chr(1).$msg;
	die($dt);
}
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
if($grd=="true")
	$defaultsort="nobukti";
else
	$defaultsort="kunjungan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$userId = $_REQUEST['userId'];
$sql = "SELECT kode_user, unit FROM $dbapotek.a_user WHERE pegawai_id = '{$userId}' ";
	//echo $sql."<br /><br />";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
	//$iuser = $data['kode_user'];	//diabaikan
	//$idunit = $data['unit'];		//diabaikan
	
$iuser = $userId;
$idunit = 0;
$ishift = 0;
$norm = $_REQUEST['norm'];
$no_pasien = $norm;
if(strlen($no_pasien) < 8 && $no_pasien != ""){
	$p = strlen($no_pasien);
	$nol = "";
	for($i=0; $i < (8-$p); $i++){
		$nol .= "0";
	}
	$no_pasien = $nol.$no_pasien;
}

$ksoId = $_REQUEST['ksoId'];
$bayarIGD = $_REQUEST['bayarIGD'];
//$selisih = $_REQUEST['selisih'];
$selisih = 0;
$bObat = $_REQUEST['bObat'];
$jenisKunj = $_REQUEST['jenisKunj'];
$jaminan_kso = $_REQUEST['jaminan_kso'];
if ($jaminan_kso=="") $jaminan_kso=0;
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl = tglSQL($_REQUEST['tgl']);

$statpembyrn = $_REQUEST['statpembyrn'];
if($statpembyrn=="") $statpembyrn=1;

$jmlresep = $_REQUEST['jmlresep'];
//if($jmlresep=="") $jmlresep=0;

$bykresep = $_REQUEST['bykresep'];
//if($bykresep=="") $bykresep=0;

$detresep = $_REQUEST['detresep'];

$tes = $_REQUEST['tes'];
$otomasi = $_REQUEST['otomasi'];
$cekbilling = $_REQUEST['cekbilling'];
$masukbilling = $_REQUEST['masukbilling'];
//===============================
if($_REQUEST['getIdPelayanan'] == 'true'){
	$unit_id = $_REQUEST['unit_id'];
	$sql = "SELECT id,CONCAT(DATE_FORMAT(tgl,'%d-%m-%Y'),' ',DATE_FORMAT(tgl_act,'%H:%i')) as tgl FROM b_pelayanan WHERE kunjungan_id='".$_REQUEST['idKunj']."' and unit_id = '".$unit_id."' order by id";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num>0){
		while($row=mysql_fetch_array($query)){
			?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['tgl']; ?></option>
			<?php
		}
	}
	else{
		?>
			<option value="0">&nbsp;-&nbsp;</option>
        <?php
	}
	return;
}
if($_REQUEST['getCount'] == 'true'){
	$sql = "SELECT MAX(cetak_count)+1 AS cetak_count FROM b_bayar WHERE id = '".$_REQUEST['idbayar']."'";
	$query = mysql_query($sql);
	$rows = mysql_fetch_array($query);
	$sUpCount = "UPDATE b_bayar SET cetak_count = '".$rows['cetak_count']."',flag = '$flag' WHERE id = '".$_REQUEST['idbayar']."'";
	mysql_query($sUpCount);
}
if ($_REQUEST['act'] == 'up_paviliun'){
	$sUp = "UPDATE b_kunjungan SET bpjs_tipe_bayar = '".$_REQUEST['tipe_bayar_paviliun']."',flag = '$flag' WHERE id = '".$_REQUEST['idKunj']."'";
	$scs = mysql_query($sUp) or die (mysql_error());
	if($scs) { echo "Sukses"; }
	else { echo "Gagal"; }
	return;
}
elseif($_REQUEST['act'] == 'hapuspel'){
	$sDel="DELETE FROM b_pelayanan WHERE id='".$_REQUEST['id']."'";
	mysql_query($sDel);
	if(mysql_error()<=0){
		echo "Hapus Konsul Berhasil !";	
	}
	else{
		echo "Hapus Konsul Gagal !";
	}
	return;	
}
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$datetime_now = explode(' ',$tglact);
		$date_now = explode('-',$datetime_now[0]);
		$yearKwi = $date_now[0];
		$monthKwi = $date_now[1];
		
		$result = mysql_fetch_array(mysql_query("SELECT fGetMaxNoKwitansi('{$yearKwi}', '{$monthKwi}')"));
		
		$no_kwi_tmp = str_pad($result[0], 7, '0', STR_PAD_LEFT);
		$no_kwitansi = substr($yearKwi,-2).".".$monthKwi.".".$no_kwi_tmp;

		$statusProses='Fine';
		//echo "req tipe = ".$_REQUEST['tipe'].";<br>";
		// Pembayaran Titipan
		if ($_REQUEST['tipe']=="1"){
			 if ($statpembyrn=="1"){
				$sqlTambah="insert into b_bayar (kunjungan_id,jenis_kunjungan,kso_id,unit_id,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,tgl_act,user_act,tipe,stat_byr,flag)
					values('".$_REQUEST['idKunj']."','".$_REQUEST['jenisKunj']."','".$_REQUEST['ksoId']."','".$_REQUEST['unitId']."','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."',CURDATE(),'".$_REQUEST['dibayaroleh']."',0,0,0,0,'".$_REQUEST['nilai']."',NOW(),'$userId',".$_REQUEST['tipe'].",".$statpembyrn.",'$flag')";
				$rs=mysql_query($sqlTambah);
				// echo "Query 1: ".$sqlTambah."<br>";
				$idBayar = mysql_insert_id();
				// == 2019-11-07 # hafiz - update status bayar_ulang menjadi 0, jika yg nginput admin
				if ($userId == 732) {
					mysql_query("UPDATE b_bayar SET bayar_ulang = '0' WHERE id = '$idBayar'");
				}
			 }else if ($statpembyrn=="2"){
			 
			 }else if ($statpembyrn=="3"){
			 
			 }
		}
		// Pembayaran Bukan Titipan
		elseif ($_REQUEST['tipe']=="0"){
			$idUnitAmbulan=0;
			$idUnitJenazah=0;
			$sql="SELECT * FROM b_ms_reference WHERE stref=26";
			$rsRef=mysql_query($sql);
			if ($rwRef=mysql_fetch_array($rsRef)){
				$idUnitAmbulan=$rwRef["nama"];
			}
			
			$sql="SELECT * FROM b_ms_reference WHERE stref=27";
			$rsRef=mysql_query($sql);
			if ($rwRef=mysql_fetch_array($rsRef)){
				$idUnitJenazah=$rwRef["nama"];
			}
			
			$sqlC="SELECT IF(tgl>'2015-05-31',1,0) AS tgl30,pulang,DATE(tgl_pulang) AS tgl_pulang,CURDATE() AS tglNow 
					FROM b_kunjungan WHERE id='".$_REQUEST['idKunj']."'";
			//echo $sqlC.";<br>";
			$rwCekKunj=mysql_query($sqlC);
			$rwCekKunj=mysql_fetch_array($rwCekKunj);
			$tglCekKunj=$rwCekKunj["tgl30"];
			$isPlg=$rwCekKunj["pulang"];
			$cTglPlg=$rwCekKunj["tgl_pulang"];
			$cTglNow=$rwCekKunj["tglNow"];
			
			$jBayar=0;
			$tBayarPxNonPiutang="";
			if ($isPlg==1){
				if (($cTglPlg!="") && ($cTglNow>$cTglPlg)){
					$jBayar=1;
				}
			}
			// Cek Pembayaran Kasir Loket RJ
			$nByr=0;
			if($_REQUEST['idKasir']==127){
				$sCek="select * from b_bayar where kunjungan_id='".$_REQUEST['idKunj']."' /*and jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/";
				$qCek=mysql_query($sCek);
				$nByr=mysql_num_rows($qCek);
			}
			
			if($nByr>0){
				$statusProses='Error';
				$SError='Error1';
				$msg="Sudah ada pembayaran !";
			}
			// Pembayaran Selain Kasir Loket RJ
			else{
				 //hanya billing
				 if ($statpembyrn=="1"){
					$sqlTambah="insert into b_bayar (no_kwi_urutan, no_kwitansi, kunjungan_id,jenis_kunjungan,kso_id,unit_id,jenis_bayar,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,selisih_lebih_kurang,tgl_act,user_act,tipe,stat_byr,flag,nilai_diskon,nilai_diskon_dokter,dokter_diskon)
						values('".$result[0]."', '{$no_kwitansi}', '".$_REQUEST['idKunj']."','".$_REQUEST['jenisKunj']."','".$_REQUEST['ksoId']."','".$_REQUEST['unitId']."','$jBayar','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."',CURDATE(),'".$_REQUEST['dibayaroleh']."','".$_REQUEST['tagihan']."','".$_REQUEST['nilai']."','".$jaminan_kso."','".$_REQUEST['keringanan']."','".$_REQUEST['titipan']."','$selisih',NOW(),'$userId',".$_REQUEST['tipe'].",".$statpembyrn.",'$flag',{$_REQUEST['diskonBilling']},{$_REQUEST['diskonDokter']},'{$_REQUEST['dokterPemberiDiskon']}') ";
					//echo $sqlTambah.";<br>";
					$rs=mysql_query($sqlTambah);
					// echo "Query 2: ".$sqlTambah."<br>";
					if (mysql_errno()==0){
						$idBayar = mysql_insert_id();
						//echo "req titipan = ".$_REQUEST['titipan'].";<br>";
						if ($_REQUEST['titipan']>0){
							$sql="SELECT * FROM b_bayar WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND kasir_id='".$_REQUEST['idKasir']."' AND titipan_terpakai<titipan AND tipe=1 order by id";
							//echo $sql.";<br>";
							$rs=mysql_query($sql);
							$titipan=$_REQUEST['titipan'];
							$ok="false";
							
							while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
								$cid=$rows['id'];
								$ctitip=$rows['titipan']-$rows['titipan_terpakai'];
								//echo "titipan = ".$titipan.", ctitip = ".$ctitip.";<br>";
								if ($titipan<=$ctitip){
									$ok="true";
									$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$titipan WHERE id=$cid";
								}else{
									$titipan=$titipan-$ctitip;
									$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$ctitip WHERE id=$cid";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								// echo "Query 3: ".$sql."<br>";
							}
						}
						//echo $sqlBayar;
						if ($tglCekKunj==1){
							//=============Untuk Px BPJS yg ada iur bayar===================
							//echo "ksoId = ".$ksoId.", idKsoBPJS = ".$idKsoBPJS.";<br>";
							if ($ksoId==$idKsoBPJS){
								//echo "req jenisKasir = ".$_REQUEST['jenisKasir'].";<br>";								
								$ok = 'true';
								$nilai = $_REQUEST['nilai']+$_REQUEST['titipan'];
								$keringanan=($_REQUEST['keringanan']=="")?0:$_REQUEST['keringanan'];
								//==============Update b_inacbg_grouper --> lunas ==================
								//if ($_REQUEST['jenisKunj']=="3"){
									$sqlUpdtCbg="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='".$_REQUEST['idKunj']."' AND status=0";
									//echo $sqlUpdtCbg.";<br>";
									$rsUpdtCbg=mysql_query($sqlUpdtCbg);
									if (mysql_num_rows($rsUpdtCbg)>0){
										$rwUpdtCbg=mysql_fetch_array($rsUpdtCbg);
										$IurBPJS=$rwUpdtCbg["biaya_px"];
										$statusLunas="";
										if ($nilai>=$IurBPJS){
											$statusLunas=",status=1";
										}
										$sqlUpdtCbg="UPDATE b_inacbg_grouper SET bayar_px='$nilai'".$statusLunas.",flag = '$flag' WHERE kunjungan_id_group='".$_REQUEST['idKunj']."'";
										//echo $sqlUpdtCbg.";<br>";
										$rsUpdtCbg=mysql_query($sqlUpdtCbg);
										// echo "Query 4: ".$sqlUpdtCbg."<br>";
									}
		
									// Bayar Kamar
									$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
		/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
		DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
		DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
		FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
		AND beban_pasien>0 AND b.aktif=1 AND b.kso_id='$ksoId') AS t WHERE (t.biaya+t.biaya_retribusi)>0";
									//echo $sqlkamar.";<br>";
									$rsKamar=mysql_query($sqlkamar);
									if (mysql_num_rows($rsKamar)>0){
										while (($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
											$tindId = $rwKamar['id'];
											$kso_id = $rwKamar['kso_id'];
											$biaya=$rwKamar["biaya"];
											$biaya_retribusi=$rwKamar["biaya_retribusi"];
											//$nilai = $nilai - $biaya;
											$nilai = $nilai - ($biaya+$biaya_retribusi);
											//echo "nilai = ".$nilai.";<br>";
											if($nilai >= 0 )
											{
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 5: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1,flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 6: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 7: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 8: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													$keringanan=$keringanan+$nilai;
												}
												//$nilai = $nilai + $biaya;
												$nilai = $nilai + ($biaya+$biaya_retribusi);
												//echo "nilai = ".$nilai.";<br>";
												if (($nilai - $biaya)<=0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',1,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 9: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$ok = 'false';
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas,flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 10: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
													$nilai=0;
												}else{
													$nilai = $nilai - $biaya;
													
													if ($biaya>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 11: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$ok = 'false';
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1,flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 12: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
															
													if ($biaya_retribusi>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 13: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$ok = 'false';
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
															}
															
															$sqlUp = "UPDATE b_tindakan_kamar SET biaya_retribusi = biaya_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 14: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												}
												$nilai=0;												
											}
										}
									}
								
									if ($ok == 'true'){
										//insert b_tindakan_kamar dijamin
										$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,b.flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='$ksoId' AND b.aktif=1 AND b.id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan WHERE bayar_id='$idBayar' AND tipe=1)";
										//echo $sql.";<br>";
										$rsIn = mysql_query($sql);
										// echo "Query 15: ".$sql."<br>";
										// Bayar Tindakan
										if ($nilai>0){
											$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
														FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
														WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='$ksoId'";
											//echo $sqlTotTind.";<br>";
											$rsTotTind = mysql_query($sqlTotTind);
											$rwTotTind=mysql_fetch_array($rsTotTind);
											$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
											$jmltindKSO=$rwTotTind["jmltindKSO"];
											
											$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' ORDER BY t.tgl_act";
											//echo $sqlTind.";<br>";
											$rsTind = mysql_query($sqlTind);
											$iKso=0;
											if (mysql_num_rows($rsTind)>0){
												$ok = 'true';
												$nilaiAwalKso = $nilai;
												while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
												{
													$tindId = $rwTind['id'];
													$kso_id = $rwTind['kso_id'];
													$biayaRS = $rwTind['biaya'];
													$biayaKSO = $rwTind['biaya_kso'];
													$iKso++;
													if ($iKso==$jmltindKSO){
														$biaya = $nilai;
													}else{
														$biaya = ($rwTind['biaya'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
														//echo "biaya=".$biaya."<br>";
														$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
														if (abs($biayaRS-($biayaKSO+$biaya))<6){
															$biaya = $biayaRS-$biayaKSO;
														}
													}
		
													$nilai = $nilai - $biaya;
													//echo "nilai = ".$nilai.";<br>";
													if($nilai >= 0 )
													{
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 16: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan SET biaya_pasien=$biaya, bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1,flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 17: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
													else
													{
														$lunas=1;
														if (($nilai+$keringanan)>=0){
															$lunas=1;
															$keringanan=$keringanan+$nilai;
														}
														$nilai = $nilai + $biaya;
														//echo "nilai = ".$nilai.";<br>";
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 18: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$ok = 'false';
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
															}
															$sqlUp = "UPDATE b_tindakan SET biaya_pasien=$biaya, bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas,flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 19: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
														$nilai=0;
													}
												}
												//echo "ok = ".$ok.";<br>";
												//insert tindakan dijamin
												if ($ok == 'true'){
													$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
															SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
															AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."' */
															AND kso_id='".$ksoId."' ORDER BY tgl_act";
													$rsTind = mysql_query($sqlTind);
													// echo "Query 20: ".$sqlTind."<br>";
												}
											}
										}
										else{
											//insert b_tindakan dijamin
											$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
													SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
													AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."' */
													AND kso_id='".$ksoId."' ORDER BY tgl_act";
											$rsTind = mysql_query($sqlTind);
											// echo "Query 21: ".$sqlTind."<br>";
										}
									}
								//}
								//else{
								//}
							}
							//=============End Untuk Px BPJS yg ada iur bayar===================
							//=============Untuk Px Jasa Raharja yg ada iur bayar===================
							else if($ksoId==$idKsoJR){ //=============End Untuk Px Jasa Raharja yg ada iur bayar===================
								//===Bayar Tindakan===
								$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' /*AND t.jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/  AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								//echo $sqlTind.";<br>";
								$rsTind = mysql_query($sqlTind);
								$ok = 'true';
								$nilai = $_REQUEST['nilai']+$_REQUEST['titipan'];
								$keringanan=($_REQUEST['keringanan']=="")?0:$_REQUEST['keringanan'];
		
								while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
								{
									$tindId = $rwTind['id'];
									$kso_id = $rwTind['kso_id'];
									$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
									$nilai = $nilai - $biaya;
									//echo "nilai = ".$nilai.";<br>";
									if($nilai >= 0 )
									{
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 22: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1,flag = '$flag' WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
											// echo "Query 23: ".$sqlUp."<br>";
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
									}
									else
									{
										$lunas=0;
										if (($nilai+$keringanan)>=0){
											$lunas=1;
											$keringanan=$keringanan+$nilai;
										}
										$nilai = $nilai + $biaya;
										//echo "nilai = ".$nilai.";<br>";
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 24: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas,flag = '$flag' WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
											// echo "Query 25: ".$sqlUp."<br>";
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
										$nilai=0;
									}
								}
								//echo "ok = ".$ok.";<br>";
								if ($ok == 'true' && $_REQUEST['idKasir']<>127){
									//===Tindakan Tdk Dijamin===
									$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
											SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
											AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/	
											AND kso_id='".$ksoId."' ORDER BY tgl_act";
									//echo $sqlTind.";<br>";
									$rsTind = mysql_query($sqlTind);
									// echo "Query 100: ".$sqlTind."<br>";
									//===Pembayaran Kamar===
									if($_REQUEST['jenisKunj']==3){
										
										$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
			/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
			IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
			FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
			AND beban_pasien>0 AND b.kso_id='".$ksoId."' AND b.aktif=1) AS t WHERE (t.biaya+t.biaya_retribusi)>0";
										echo "sql kamar: ".$sqlkamar.";<br>";
										$rsKamar=mysql_query($sqlkamar);
										echo "nilai=".$nilai."<br>";
										$isInap=1;
										while(($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
											$isInap=1;
											$tglout="";
											$tindId = $rwKamar['id'];
											$kso_id = $rwKamar['kso_id'];
											$biaya = $rwKamar['biaya'];
											$biaya_retribusi = $rwKamar['biaya_retribusi'];
											//$nilai = $nilai - $biaya;
											$nilai = $nilai - ($biaya+$biaya_retribusi);
											//echo "nilai = ".$nilai.";<br>";
											if($nilai >= 0 )
											{
												//echo "tgl_out = ".$rwKamar['tgl_out'].";<br>";
												if ($rwKamar['tgl_out']==0){
													//$tglout=",tgl_out=now()";
												}
												
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 102: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1".$tglout.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 26: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 103: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 27: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													//$tglout=",tgl_out=now()";
													$keringanan=$keringanan+$nilai;
												}
												//$nilai = $nilai + $biaya;
												$nilai = $nilai + ($biaya+$biaya_retribusi);
												//echo "nilai = ".$nilai.";<br>";
												if (($nilai - $biaya)<=0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 103: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas".$tglout.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 28: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}else{
													$nilai = $nilai - $biaya;
													
													if ($biaya>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','1','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 104: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = $lunas".$tglout.",flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 29: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
											
													if ($biaya_retribusi>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 105: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 30: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												}
												$nilai = 0;
											}
										}
										
										if ($ok == 'true'){
											//if ($ksoId!="1"){
												$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,b.flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='".$ksoId."' AND b.beban_pasien=0";
												//echo $sql.";<br>";
												$rsIn = mysql_query($sql);
												// echo "Query 31: ".$sql."<br>";
											//}
										}
									}
								}
							}
							//=============End Untuk Px Jasa Raharja yg ada iur bayar===================
							//=============Start Untuk Px Selain BPJS & Jasa Raharja===================
							else{								
								$fBayarKarcis="";
								//===Kasir Loket RJ===
								if($_REQUEST['idKasir']==127){
									$fBayarKarcis=" AND t.ms_tindakan_kelas_id=7513 ";
								}
								//===Bayar Tindakan===
								$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' /*AND t.jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/ ".$fBayarKarcis." AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								//echo $sqlTind.";<br>";
								$rsTind = mysql_query($sqlTind);
								$ok = 'true';
								$nilai = $_REQUEST['nilai']+$_REQUEST['titipan'];
								$keringanan=($_REQUEST['keringanan']=="")?0:$_REQUEST['keringanan'];
		
								while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
								{
									$tindId = $rwTind['id'];
									$kso_id = $rwTind['kso_id'];
									$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
									/*if ($ksoId=="1"){
										$biaya = ($rwTind['biaya'] * $rwTind['qty']) - $rwTind['bayar'];
									}*/
									
									$nilai = $nilai - $biaya;
									//echo "nilai = ".$nilai.";<br>";
									if($nilai >= 0 )
									{
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 106: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1,flag = '$flag' WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
									}
									else
									{
										$lunas=0;
										if (($nilai+$keringanan)>=0){
											$lunas=1;
											$keringanan=$keringanan+$nilai;
										}
										$nilai = $nilai + $biaya;
										//echo "nilai = ".$nilai.";<br>";
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 107: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas,flag = '$flag' WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
										$nilai=0;
									}
								}
								//echo "ok = ".$ok.";<br>";
								//====Selain Kasir Loket RJ===
								if ($ok == 'true' && $_REQUEST['idKasir']<>127){
									$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
											SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
											AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/	
											AND kso_id='".$ksoId."' ORDER BY tgl_act";
									//echo $sqlTind.";<br>";
									$rsTind = mysql_query($sqlTind);
									// echo "Query 108: ".$sqlTind."<br>";
									//echo "req jenisKasir = ".$_REQUEST['jenisKasir'].";<br>";
									//echo "req jenisKasir = ".$_REQUEST['jenisKasir'].", bayarIGD = ".$bayarIGD.";<br>";
									//if(($_REQUEST['jenisKasir']=='0') && ($bayarIGD=="1")){
									//if(($_REQUEST['jenisKasir']=='0') && ($bayarIGD=="1") && ($_REQUEST['jenisKunj']==3)){
									//===Bayar Kamar===
									if($_REQUEST['jenisKunj']==3){
										
										$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
			/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
			IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
			FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
			AND beban_pasien>0 AND b.kso_id='".$ksoId."' AND b.aktif=1) AS t WHERE (t.biaya+t.biaya_retribusi)>0";
										//echo $sqlkamar.";<br>";
										$rsKamar=mysql_query($sqlkamar);
										//echo "nilai=".$nilai."<br>";
										$isInap=1;
										while(($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
											$isInap=1;
											$tglout="";
											$tindId = $rwKamar['id'];
											$kso_id = $rwKamar['kso_id'];
											$biaya = $rwKamar['biaya'];
											$biaya_retribusi = $rwKamar['biaya_retribusi'];
											//$nilai = $nilai - $biaya;
											$nilai = $nilai - ($biaya+$biaya_retribusi);
											//echo "nilai = ".$nilai.";<br>";
											if($nilai >= 0 )
											{
												//echo "tgl_out = ".$rwKamar['tgl_out'].";<br>";
												if ($rwKamar['tgl_out']==0){
													//$tglout=",tgl_out=now()";
												}
												
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 109: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1".$tglout.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 32: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 110: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 33: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													//$tglout=",tgl_out=now()";
													$keringanan=$keringanan+$nilai;
												}
												//$nilai = $nilai + $biaya;
												$nilai = $nilai + ($biaya+$biaya_retribusi);
												//echo "nilai = ".$nilai.";<br>";
												if (($nilai - $biaya)<=0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 111: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas".$tglout.",flag = '$flag' WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 34: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}else{
													$nilai = $nilai - $biaya;
													
													if ($biaya>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','1','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 112: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = $lunas".$tglout.",flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 35: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
															
													if ($biaya_retribusi>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 113: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang.",flag = '$flag' WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 36: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												}
												$nilai = 0;
											}
										}
										
										if ($ok == 'true'){
											//if ($ksoId!="1"){
												//===Kamar Tidak Dijamin===
												$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,b.flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='".$ksoId."' AND b.beban_pasien=0";
												//echo $sql.";<br>";
												$rsIn = mysql_query($sql);
												// echo "Query 37: ".$sql."<br>";
											//}
										}
									}
								}
							}
						}
					}else{
						$statusProses='Error';
						$SError='Error2';
					}
				 }
				 //billing+obat global
				 else if ($statpembyrn=="2"){
					$sqlTambah="insert into b_bayar (no_kwi_urutan, no_kwitansi, kunjungan_id,jenis_kunjungan,kso_id,unit_id,jenis_bayar,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,selisih_lebih_kurang,tgl_act,user_act,tipe,stat_byr,flag,nilai_diskon,nilai_diskon_dokter,dokter_diskon)
						values('".$result[0]."', '{$no_kwitansi}', '".$_REQUEST['idKunj']."','".$_REQUEST['jenisKunj']."','".$_REQUEST['ksoId']."','".$_REQUEST['unitId']."','$jBayar','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."',CURDATE(),'".$_REQUEST['dibayaroleh']."','".$_REQUEST['tagihan']."','".$_REQUEST['nilai']."','".$jaminan_kso."','".$_REQUEST['keringanan']."','".$_REQUEST['titipan']."','$selisih',NOW(),'$userId',".$_REQUEST['tipe'].",".$statpembyrn.",'{$flag}',{$_REQUEST['diskonBilling']},{$_REQUEST['diskonDokter']},'{$_REQUEST['dokterPemberiDiskon']}')";
					//echo $sqlTambah.";<br>";
					$rs=mysql_query($sqlTambah);
					if (mysql_errno()==0){
						$billingId = mysql_insert_id();
						$idBayar=$billingId;
						//echo "req titipan = ".$_REQUEST['titipan'].";<br>";
						if ($_REQUEST['titipan']>0){
							$sql="SELECT * FROM b_bayar WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND kasir_id='".$_REQUEST['idKasir']."' AND titipan_terpakai<titipan AND tipe=1 order by id";
							//echo $sql.";<br>";
							$rs=mysql_query($sql);
							$titipan=$_REQUEST['titipan'];
							$ok="false";
							
							while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
								$cid=$rows['id'];
								$ctitip=$rows['titipan']-$rows['titipan_terpakai'];
								//echo "titipan = ".$titipan.", ctitip = ".$ctitip.";<br>";
								if ($titipan<=$ctitip){
									$ok="true";
									$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$titipan,flag = '$flag' WHERE id=$cid";
								}else{
									$titipan=$titipan-$ctitip;
									$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$ctitip,flag = '$flag' WHERE id=$cid";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
							}
						}
						// Pembayaran Resep
						$bykresep = $bykresep;
						$detilresep = $detresep;
						$nilai=$_REQUEST['nilai']+$_REQUEST['titipan'];
						for($i=0;$i<$bykresep;$i++){
							//echo $i;
							$pieces = explode("**", $detilresep);
							$isi = explode("|", $pieces[$i]);
							
							$no_penjualan = $isi[0];
							$totalTagihan = $isi[2];
							$no_pel_id = $isi[3];					
					
							$sql_get = "SELECT DISTINCT NO_KUNJUNGAN, CARA_BAYAR, UNIT_ID 
										FROM $dbapotek.a_penjualan 
										where NO_PENJUALAN = '{$no_penjualan}' 
										  /*AND UNIT_ID = '{$idunit}'*/ 
										  AND NO_PASIEN = '{$no_pasien}'
										  AND NO_KUNJUNGAN = '{$no_pel_id}'
										  GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
							//echo $sql_get."<br /><br />";
							$query_get = mysql_query($sql_get);
							$data_get = mysql_fetch_array($query_get);
							$no_pelayanan = $data_get['NO_KUNJUNGAN'];
							$cara_bayar = $data_get['CARA_BAYAR'];
							$idunit = $data_get['UNIT_ID'];
											
							$queTambah="INSERT INTO $dbapotek.a_kredit_utang(BILLING_BAYAR_OBAT_ID, IS_AKTIF, NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN,FLAG)
										VALUES ('{$billingId}', '0', '{$no_kwitansi}', '{$idunit}', '{$iuser}', '{$ishift}', NOW(), '{$no_penjualan}', '{$totalTagihan}', '{$totalTagihan}', '{$totalTagihan}', '0', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','$flag');";
							//echo $queTambah.";<br>";
							$rs2=mysql_query($queTambah);
								
							if (mysql_errno()==0){
								$queTambah2="INSERT INTO $dbapotek.a_penjualan_log_billing (ID_PENJUALAN, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, USER_ACT, TGL_ACT, FLAG)
											SELECT ID, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, '{$iuser}', NOW(), FLAG FROM
											$dbapotek.a_penjualan 
											WHERE NO_PENJUALAN = '{$no_penjualan}' 
											  /*AND UNIT_ID = '{$idunit}'*/ 
											  AND NO_PASIEN = '{$no_pasien}'
											  AND NO_KUNJUNGAN = '{$no_pel_id}'
											GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
							//	echo $queTambah2.";<br>";
								$rs3=mysql_query($queTambah2);
								
								if (mysql_errno()==0){
									$sql="UPDATE $dbapotek.a_penjualan 
										  SET /* CARA_BAYAR=1, */
											  UTANG=0,
											  SUDAH_BAYAR = 1,
											  TGL_BAYAR = DATE(NOW()),
											  TGL_BAYAR_ACT = NOW(),
											  USER_ID_BAYAR = '{$iuser}'
										  WHERE /*UNIT_ID='{$idunit}'
											AND*/ NO_PENJUALAN='{$no_penjualan}' 
											AND NO_PASIEN='{$no_pasien}'
											AND NO_KUNJUNGAN = '{$no_pel_id}';";
									//echo $sql."<br/>";
									$rs=mysql_query($sql);
									
									if ($tglCekKunj==1){
										//  Distribusi Pembayaran Obat --> b_bayar_tindakan : tipe=2
										$sql_bObat = "SELECT
														  ap.*,
														  am.kso_id_billing
														FROM $dbapotek.a_penjualan ap
														  INNER JOIN $dbapotek.a_mitra am
															ON ap.KSO_ID = am.IDMITRA
														WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
															AND ap.NO_PASIEN = '{$no_pasien}'
															AND ap.NO_KUNJUNGAN = '{$no_pel_id}'";
										//echo $sql_bObat."<br /><br />";
										$ok = 'true';
										$rsbObat = mysql_query($sql_bObat);
										while (($rwbObat = mysql_fetch_array($rsbObat)) && ($ok == 'true')){
											// Insert ke b_bayar_tindakan
											$tindId = $rwbObat['ID'];
											$kso_id = $rwbObat['kso_id_billing'];
											if ($kso_id==0) $kso_id=$ksoId;
											$biaya = ($rwbObat['QTY_JUAL'] - $rwbObat['QTY_RETUR']) * $rwbObat['HARGA_SATUAN'];
											
											$nilai = $nilai - $biaya;
											//echo "nilai = ".$nilai.";<br>";
											if($nilai >= 0 )
											{
												$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',2,'$flag')";
												//echo $sqlIn.";<br>";
												$rsIn = mysql_query($sqlIn);
												// echo "Query 114: ".$sqlIn."<br>";
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													$keringanan=$keringanan+$nilai;
												}
												$nilai = $nilai + $biaya;
												//echo "nilai = ".$nilai.";<br>";
												$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',2,'$flag')";
												//echo $sqlIn.";<br>";
												$rsIn = mysql_query($sqlIn);
												// echo "Query 115: ".$sqlIn."<br>";
												$nilai=0;
											}
										}
									}
								}else{
									$statusProses='Error';
									$SError='Error3';
								}
							}else{
								$statusProses='Error';
								$SError='Error4';
							}
						}
						
						if ($tglCekKunj==1){
							// Pembayaran Billing
							//=============Start Untuk Px BPJS yg ada iur bayar===================
							if ($ksoId==$idKsoBPJS){
								//echo "req jenisKasir = ".$_REQUEST['jenisKasir'].";<br>";
								//==============Update b_inacbg_grouper --> lunas ==================
								if ($_REQUEST['jenisKunj']=="3"){
									$sqlUpdtCbg="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='".$_REQUEST['idKunj']."' AND status=0";
									//echo $sqlUpdtCbg.";<br>";
									$rsUpdtCbg=mysql_query($sqlUpdtCbg);
									if (mysql_num_rows($rsUpdtCbg)>0){
										$rwUpdtCbg=mysql_fetch_array($rsUpdtCbg);
										$IurBPJS=$rwUpdtCbg["biaya_px"];
										$statusLunas="";
										if ($nilai>=$IurBPJS){
											$statusLunas=",status=1";
										}
										$sqlUpdtCbg="UPDATE b_inacbg_grouper SET bayar_px='$nilai'".$statusLunas." WHERE kunjungan_id_group='".$_REQUEST['idKunj']."'";
										//echo $sqlUpdtCbg.";<br>";
										$rsUpdtCbg=mysql_query($sqlUpdtCbg);
									}
		
									// Bayar Kamar
									$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
		/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
		DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
		DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
		(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
		FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
		AND beban_pasien>0 AND b.aktif=1 AND b.kso_id='$ksoId') AS t WHERE (t.biaya+t.biaya_retribusi)>0";
									//echo $sqlkamar.";<br>";
									// echo "Query 38: ".$sqlkamar."<br>";
									$rsKamar=mysql_query($sqlkamar);
									$ok = 'true';
									if (mysql_num_rows($rsKamar)>0){
										while (($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
											$tindId = $rwKamar['id'];
											$kso_id = $rwKamar['kso_id'];
											$biaya=$rwKamar["biaya"];
											$biaya_retribusi=$rwKamar["biaya_retribusi"];
											//$nilai = $nilai - $biaya;
											$nilai = $nilai - ($biaya+$biaya_retribusi);
											//echo "nilai = ".$nilai.";<br>";
											if($nilai >= 0 )
											{
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 116: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1 WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 39: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 117: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang." WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 40: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													$keringanan=$keringanan+$nilai;
												}
												//$nilai = $nilai + $biaya;
												$nilai = $nilai + ($biaya+$biaya_retribusi);
												//echo "nilai = ".$nilai.";<br>";
												if (($nilai - $biaya)<=0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',1,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 116: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$ok = 'false';
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 41: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}else{
													$nilai = $nilai - $biaya;
													
													if ($biaya>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 116s: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$ok = 'false';
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 42: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
															
													if ($biaya_retribusi>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 120: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang." WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 43: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												}
												$nilai=0;
											}
										}
									}
									
									if ($ok == 'true'){
										//insert b_tindakan_kamar dijamin
										$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,b.flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='$ksoId' AND b.aktif=1 AND b.id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan WHERE bayar_id='$idBayar' AND tipe=1)";
										//echo $sql.";<br>";
										$rsIn = mysql_query($sql);
										// echo "Query 44: ".$sql."<br>";
										// Bayar Tindakan
										if ($nilai>0){
											$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
														FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
														WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='$ksoId'";
											//echo $sqlTotTind.";<br>";
											$rsTotTind = mysql_query($sqlTotTind);
											$rwTotTind=mysql_fetch_array($rsTotTind);
											$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
											$jmltindKSO=$rwTotTind["jmltindKSO"];
											
											$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' ORDER BY t.tgl_act";
											//echo $sqlTind.";<br>";
											$rsTind = mysql_query($sqlTind);
											$iKso=0;
											if (mysql_num_rows($rsTind)>0){
												$ok = 'true';
												$nilaiAwalKso = $nilai;
												while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
												{
													$tindId = $rwTind['id'];
													$kso_id = $rwTind['kso_id'];
													$biayaRS = $rwTind['biaya'];
													$biayaKSO = $rwTind['biaya_kso'];
													$iKso++;
													if ($iKso==$jmltindKSO){
														$biaya = $nilai;
													}else{
														$biaya = ($rwTind['biaya'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
														//echo "biaya=".$biaya."<br>";
														$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
														if (abs($biayaRS-($biayaKSO+$biaya))<6){
															$biaya = $biayaRS-$biayaKSO;
														}
													}
		
													$nilai = $nilai - $biaya;
													//echo "nilai = ".$nilai.";<br>";
													if($nilai >= 0 )
													{
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 121: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
															}
															$sqlUp = "UPDATE b_tindakan SET biaya_pasien=$biaya, bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1 WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
													else
													{
														$lunas=1;
														if (($nilai+$keringanan)>=0){
															$lunas=1;
															$keringanan=$keringanan+$nilai;
														}
														$nilai = $nilai + $biaya;
														//echo "nilai = ".$nilai.";<br>";
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 122: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$ok = 'false';
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
															}
															$sqlUp = "UPDATE b_tindakan SET biaya_pasien=$biaya, bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
														$nilai=0;
													}
												}
												//echo "ok = ".$ok.";<br>";
												//insert tindakan yg dijamin
												if ($ok == 'true'){
													$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
															SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
															AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/	
															AND kso_id='".$ksoId."' AND id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan bt 
															INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$_REQUEST['idKunj']."' 
															AND bt.kso_id='".$ksoId."' AND bt.tipe=0) ORDER BY tgl_act";
													//echo $sqlTind.";<br>";
													$rsTind = mysql_query($sqlTind);
													// echo "Query 123: ".$sqlTind."<br>";
												}
											}
										}
										else{
											//insert tindakan yg dijamin
											$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
													SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
													AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/
													AND kso_id='".$ksoId."' AND id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan bt 
													INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$_REQUEST['idKunj']."' 
													AND bt.kso_id='".$ksoId."' AND bt.tipe=0) ORDER BY tgl_act";
											//echo $sqlTind.";<br>";
											$rsTind = mysql_query($sqlTind);
											// echo "Query 124: ".$sqlTind."<br>";
										}
									}
								}
								//else{
								//}
							}
							//=============End Untuk Px BPJS yg ada iur bayar===================
							//=============Untuk Px Jasa Raharja yg ada iur bayar===============
							else if($ksoId==$idKsoJR){
								//===Cek Jaminan / Plafon
								$sqlUpdtCbg="SELECT * FROM b_jaminan_kso WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND status=0";
								//echo $sqlUpdtCbg.";<br>";
								$rsUpdtCbg=mysql_query($sqlUpdtCbg);
								if (mysql_num_rows($rsUpdtCbg)>0){
									$rwUpdtCbg=mysql_fetch_array($rsUpdtCbg);
									$IurJR=$rwUpdtCbg["biaya_px"];
									$statusLunas="";
									if ($nilai>=$IurJR){
										$statusLunas=",status=1";
									}
									$sqlUpdtCbg="UPDATE b_jaminan_kso SET bayar_px='$nilai'".$statusLunas." WHERE kunjungan_id='".$_REQUEST['idKunj']."'";
									//echo $sqlUpdtCbg.";<br>";
									$rsUpdtCbg=mysql_query($sqlUpdtCbg);
								}

								// Bayar Kamar
								$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
	/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
	DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
	DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
	IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
	FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
	AND beban_pasien>0 AND b.aktif=1 AND b.kso_id='$ksoId') AS t WHERE (t.biaya+t.biaya_retribusi)>0";
								//echo $sqlkamar.";<br>";
								$rsKamar=mysql_query($sqlkamar);
								// echo "Query 45: ".$sqlkamar."<br>";
								$ok = 'true';
								if (mysql_num_rows($rsKamar)>0){
									while (($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
										$tindId = $rwKamar['id'];
										$kso_id = $rwKamar['kso_id'];
										$biaya=$rwKamar["biaya"];
										$biaya_retribusi=$rwKamar["biaya_retribusi"];
										//$nilai = $nilai - $biaya;
										$nilai = $nilai - ($biaya+$biaya_retribusi);
										//echo "nilai = ".$nilai.";<br>";
										if($nilai >= 0 )
										{
											if ($biaya>0){
												$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
												//echo $sqlIn.";<br>";
												$rsIn = mysql_query($sqlIn);
												// echo "Query 117: ".$sqlIn."<br>";
												
												if (mysql_errno()==0){
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
													}
													$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1 WHERE id = $tindId";
													//echo $sqlUp.";<br>";
													$rsUp = mysql_query($sqlUp);
													// echo "Query 46: ".$sqlUp."<br>";
												}else{
													$ok = 'false';
													$statusProses='Error';
												}
											}
												
											if ($biaya_retribusi>0){
												$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
												//echo $sqlIn.";<br>";
												$rsIn = mysql_query($sqlIn);
												// echo "Query 125: ".$sqlIn."<br>";
												
												if (mysql_errno()==0){
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
													}
													$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang." WHERE id = $tindId";
													//echo $sqlUp.";<br>";
													$rsUp = mysql_query($sqlUp);
													// echo "Query 47: ".$sqlUp."<br>";
												}else{
													$ok = 'false';
													$statusProses='Error';
												}
											}
										}
										else
										{
											$lunas=0;
											if (($nilai+$keringanan)>=0){
												$lunas=1;
												$keringanan=$keringanan+$nilai;
											}
											//$nilai = $nilai + $biaya;
											$nilai = $nilai + ($biaya+$biaya_retribusi);
											//echo "nilai = ".$nilai.";<br>";
											if (($nilai - $biaya)<=0){
												$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',1,'$flag')";
												//echo $sqlIn.";<br>";
												$rsIn = mysql_query($sqlIn);
												// echo "Query 118: ".$sqlIn."<br>";
												
												if (mysql_errno()==0){
													$ok = 'false';
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
													}
													$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
													//echo $sqlUp.";<br>";
													$rsUp = mysql_query($sqlUp);
													// echo "Query 48: ".$sqlUp."<br>";
												}else{
													$ok = 'false';
													$statusProses='Error';
												}
											}else{
												$nilai = $nilai - $biaya;
												
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya',1,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 119: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$ok = 'false';
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 50: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 126: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang." WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 51: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											$nilai=0;
										}
									}
								}
								
								if ($ok == 'true'){
									//insert b_tindakan_kamar dijamin
									$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='$ksoId' AND b.aktif=1 AND b.id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan WHERE bayar_id='$idBayar' AND tipe=1)";
									//echo $sql.";<br>";
									$rsIn = mysql_query($sql);
									// echo "Query 52: ".$sql."<br>";
									// Bayar Tindakan
									if ($nilai>0){
										$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
													FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
													WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='$ksoId'";
										//echo $sqlTotTind.";<br>";
										$rsTotTind = mysql_query($sqlTotTind);
										$rwTotTind=mysql_fetch_array($rsTotTind);
										$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
										$jmltindKSO=$rwTotTind["jmltindKSO"];
										
										$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' ORDER BY t.tgl_act";
										//echo $sqlTind.";<br>";
										$rsTind = mysql_query($sqlTind);
										$iKso=0;
										if (mysql_num_rows($rsTind)>0){
											$ok = 'true';
											$nilaiAwalKso = $nilai;
											while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
											{
												$tindId = $rwTind['id'];
												$kso_id = $rwTind['kso_id'];
												$biayaRS = $rwTind['biaya'];
												$biayaKSO = $rwTind['biaya_kso'];
												$iKso++;

												$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
	
												$nilai = $nilai - $biaya;
												//echo "nilai = ".$nilai.";<br>";
												if($nilai >= 0 )
												{
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 127: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1 WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												else
												{
													$lunas=1;
													if (($nilai+$keringanan)>=0){
														$lunas=1;
														$keringanan=$keringanan+$nilai;
													}
													$nilai = $nilai + $biaya;
													//echo "nilai = ".$nilai.";<br>";
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 128: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$ok = 'false';
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
													$nilai=0;
												}
											}
											//echo "ok = ".$ok.";<br>";
											//insert tindakan yg dijamin
											if ($ok == 'true'){
												$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
														SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
														AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/	
														AND kso_id='".$ksoId."' AND id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan bt 
														INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$_REQUEST['idKunj']."' 
														AND bt.kso_id='".$ksoId."' AND bt.tipe=0) ORDER BY tgl_act";
												//echo $sqlTind.";<br>";
												$rsTind = mysql_query($sqlTind);
												// echo "Query 128: ".$sqlTind."<br>";
											}
										}
									}
									else{
										//insert tindakan yg dijamin
										$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
												SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
												AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/
												AND kso_id='".$ksoId."' AND id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan bt 
												INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$_REQUEST['idKunj']."' 
												AND bt.kso_id='".$ksoId."' AND bt.tipe=0) ORDER BY tgl_act";
										//echo $sqlTind.";<br>";
										$rsTind = mysql_query($sqlTind);
										// echo "Query 129: ".$sqlTind."<br>";
									}
								}
							}
							//=============End Untuk Px Jasa Raharja yg ada iur bayar===================
							//=============Start Untuk Px Selain BPJS & Jasa Raharja===================
							else{
								//Bayar Tindakan
								$fBayarKarcis="";
								if($_REQUEST['idKasir']==127){
									$fBayarKarcis=" AND t.ms_tindakan_kelas_id=7513 ";
								}
								$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND t.kso_id='".$ksoId."' /*AND t.jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/ ".$fBayarKarcis." AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								//echo $sqlTind.";<br>";
								$rsTind = mysql_query($sqlTind);
								$ok = 'true';
		
								while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
								{
									$tindId = $rwTind['id'];
									$kso_id = $rwTind['kso_id'];
									$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
									
									$nilai = $nilai - $biaya;
									//echo "nilai = ".$nilai.", tindId=".$tindId.", biaya=".$biaya.";<br>";
									if($nilai >= 0 )
									{
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 130: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1 WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
									}
									else
									{
										$lunas=0;
										if (($nilai+$keringanan)>=0){
											$lunas=1;
											$keringanan=$keringanan+$nilai;
										}
										$nilai = $nilai + $biaya;
										//echo "nilai = ".$nilai.";<br>";
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','$flag')";
										//echo $sqlIn.";<br>";
										$rsIn = mysql_query($sqlIn);
										// echo "Query 131: ".$sqlIn."<br>";
										
										if (mysql_errno()==0){
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
											}
											$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas WHERE id = $tindId";
											//echo $sqlUp.";<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
										$nilai=0;
									}
								}
								//echo "ok = ".$ok.";<br>";
								if ($ok == 'true' && $_REQUEST['idKasir']<>127){
									//insert b_tindakan dijamin
									$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) 
											SELECT $idBayar,id,kso_id,0,0,flag FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' 
											AND biaya_pasien=0 /*AND jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/	
											AND kso_id='".$ksoId."' ORDER BY tgl_act";
									//echo $sqlTind.";<br>";
									$rsTind = mysql_query($sqlTind);
									// echo "Query 131: ".$sqlTind."<br>";
									//echo "req jenisKasir = ".$_REQUEST['jenisKasir'].", bayarIGD = ".$bayarIGD.";<br>";
									//Bayar Kamar
									if($_REQUEST['jenisKunj']==3){
										$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*beban_pasien-bayar) AS biaya,
			/*IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*retribusi_pasien-bayar_retribusi_pasien,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,
			DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*/(retribusi_pasien-bayar_retribusi_pasien) AS biaya_retribusi,
			IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1)),
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))) AS qty_hari 
			FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
			AND beban_pasien>0 AND b.kso_id='".$ksoId."' AND b.aktif=1) AS t WHERE (t.biaya+t.biaya_retribusi)>0";
										// echo "Query 132 Kamar: ".$sqlkamar.";<br>";
										$rsKamar=mysql_query($sqlkamar);
										//echo "nilai=".$nilai."<br>";
										$isInap=1;
										while(($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
											$isInap=1;
											$tglout="";
											$tindId = $rwKamar['id'];
											$kso_id = $rwKamar['kso_id'];
											$biaya = $rwKamar['biaya'];
											$biaya_retribusi=$rwKamar["biaya_retribusi"];
											//$nilai = $nilai - $biaya;
											//echo "Queryx: nilai = ".$nilai.";<br>";
											//echo "Queryx: biaya = ".$biaya.";<br>";
											//echo "Queryx: biaya_retribusi = ".$biaya_retribusi.";<br>";
											$nilai = $nilai - ($biaya+$biaya_retribusi);
											if($nilai >= 0 )
											{
												//echo "tgl_out = ".$rwKamar['tgl_out'].";<br>";
												if ($rwKamar['tgl_out']==0){
													//$tglout=",tgl_out=now()";
												}
												
												if ($biaya>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 132: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$biaya,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya,".$tBayarPxNonPiutang." lunas = 1".$tglout." WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 53: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
												
												if ($biaya_retribusi>0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$biaya_retribusi',4,'$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 133: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														$tBayarPxNonPiutang="";
														if ($jBayar==0){
															$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$biaya_retribusi";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $biaya_retribusi,bayar_retribusi_pasien=bayar_retribusi_pasien+$biaya_retribusi".$tBayarPxNonPiutang." WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 54: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}
											}
											else
											{
												$lunas=0;
												if (($nilai+$keringanan)>=0){
													$lunas=1;
													//$tglout=",tgl_out=now()";
													$keringanan=$keringanan+$nilai;
												}
												//$nilai = $nilai + $biaya;
												$nilai = $nilai + ($biaya+$biaya_retribusi);
												//echo "nilai = ".$nilai.";<br>";
												if (($nilai - $biaya)<=0){
													$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','1','$flag')";
													//echo $sqlIn.";<br>";
													$rsIn = mysql_query($sqlIn);
													// echo "Query 134: ".$sqlIn."<br>";
													
													if (mysql_errno()==0){
														if ($jBayar==0){
															$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
														}
														$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas".$tglout." WHERE id = $tindId";
														//echo $sqlUp.";<br>";
														$rsUp = mysql_query($sqlUp);
														// echo "Query 55: ".$sqlUp."<br>";
													}else{
														$ok = 'false';
														$statusProses='Error';
													}
												}else{
													$nilai = $nilai - $biaya;
													
													if ($biaya>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai','1','$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 135: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															if ($jBayar==0){
																$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$nilai,";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai,".$tBayarPxNonPiutang." lunas = $lunas".$tglout." WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 56: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												
													if ($biaya_retribusi>0){
														$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) VALUES('$idBayar','$tindId','$kso_id','$nilai',4,'$flag')";
														//echo $sqlIn.";<br>";
														$rsIn = mysql_query($sqlIn);
														// echo "Query 136: ".$sqlIn."<br>";
														
														if (mysql_errno()==0){
															$tBayarPxNonPiutang="";
															if ($jBayar==0){
																$tBayarPxNonPiutang=",bayar_retribusi_pasien_non_piutang=bayar_retribusi_pasien_non_piutang+$nilai";
															}
															$sqlUp = "UPDATE b_tindakan_kamar SET bayar_retribusi = bayar_retribusi + $nilai,bayar_retribusi_pasien=bayar_retribusi_pasien+$nilai".$tBayarPxNonPiutang." WHERE id = $tindId";
															//echo $sqlUp.";<br>";
															$rsUp = mysql_query($sqlUp);
															// echo "Query 56: ".$sqlUp."<br>";
														}else{
															$ok = 'false';
															$statusProses='Error';
														}
													}
												}
												$nilai = 0;
											}
										}
										
										if ($ok == 'true'){
											//if ($ksoId!="1"){
												$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe,flag) SELECT $idBayar,b.id,b.kso_id,0,1,b.flag FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND b.kso_id='".$ksoId."' AND b.beban_pasien=0";
												//echo $sql.";<br>";
												$rsIn = mysql_query($sql);
												// echo "Query 57: ".$sql."<br>";
											//}
										}
									}
								}
							}
						}
					}else{
						$statusProses='Error';
						$SError='Error6';
					}
				 }
				 //billing+obat beberapa resep
				 else if ($statpembyrn=="3"){
					$sqlTambah="insert into b_bayar (no_kwi_urutan, no_kwitansi, kunjungan_id,jenis_kunjungan,kso_id,unit_id,jenis_bayar,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,selisih_lebih_kurang,tgl_act,user_act,tipe,stat_byr,flag)
						values('".$result[0]."', '{$no_kwitansi}', '".$_REQUEST['idKunj']."','".$_REQUEST['jenisKunj']."','".$_REQUEST['ksoId']."','".$_REQUEST['unitId']."','$jBayar','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."',CURDATE(),'".$_REQUEST['dibayaroleh']."','".$_REQUEST['tagihan']."','".$_REQUEST['nilai']."','".$jaminan_kso."','".$_REQUEST['keringanan']."','".$_REQUEST['titipan']."','$selisih',NOW(),'$userId','".$_REQUEST['tipe']."','".$statpembyrn."','$flag')";
					//echo $sqlTambah.";<br>";
					$rs=mysql_query($sqlTambah);
					//echo mysql_error();
					$billingId = mysql_insert_id();
				 
					if($otomasi==1){
					/* $sql="select hari from b_bayar";
					mysql_query($sql); */				
						if (mysql_errno()==0){
							$bykresep = $bykresep;
							$detilresep = $detresep;
							
							for($i=0;$i<$bykresep;$i++){
								//echo $i;
								$pieces = explode("**", $detilresep);
								$isi = explode("|", $pieces[$i]);
								
								$no_penjualan = $isi[0];
								$kondisinya = $isi[1];
								$totalTagihan = $isi[2];
								$no_pel_id = $isi[3];
						 
								if($kondisinya==1){
									$sql_get = "SELECT DISTINCT NO_KUNJUNGAN, CARA_BAYAR, UNIT_ID 
												FROM $dbapotek.a_penjualan 
												where NO_PENJUALAN = '{$no_penjualan}' 
												  /*AND UNIT_ID = '{$idunit}'*/ 
												  AND NO_PASIEN = '{$no_pasien}'
												  AND NO_KUNJUNGAN = '{$no_pel_id}'
												  GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
									//echo $sql_get."<br /><br />";
									$query_get = mysql_query($sql_get);
									//echo mysql_error();
									$data_get = mysql_fetch_array($query_get);
									$no_pelayanan = $data_get['NO_KUNJUNGAN'];
									$cara_bayar = $data_get['CARA_BAYAR'];
									$idunit = $data_get['UNIT_ID'];
												
									$queTambah="INSERT INTO $dbapotek.a_kredit_utang(BILLING_BAYAR_OBAT_ID, IS_AKTIF, NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN,FLAG)
												VALUES ('{$billingId}', '0', '{$no_kwitansi}', '{$idunit}', '{$iuser}', '{$ishift}', NOW(), '{$no_penjualan}', '{$totalTagihan}', '{$totalTagihan}', '{$totalTagihan}', '0', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','$flag');";
									//echo $queTambah.";<br>";
									$rs2=mysql_query($queTambah);
									//echo mysql_error();
									
									if (mysql_errno()==0){
										$queTambah2="INSERT INTO $dbapotek.a_penjualan_log_billing (ID_PENJUALAN, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, USER_ACT, TGL_ACT, FLAG)
													SELECT ID, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, '{$iuser}', NOW(), FLAG FROM
													$dbapotek.a_penjualan 
													WHERE NO_PENJUALAN = '{$no_penjualan}' 
													  /*AND UNIT_ID = '{$idunit}'*/ 
													  AND NO_PASIEN = '{$no_pasien}'
													  AND NO_KUNJUNGAN = '{$no_pel_id}'
													GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
										//echo $queTambah2.";<br>";
										$rs3=mysql_query($queTambah2);
										//echo mysql_error();
									
										if (mysql_errno()==0){
											$sql="UPDATE $dbapotek.a_penjualan 
												  SET /* CARA_BAYAR=1, */
													  UTANG=0,
													  SUDAH_BAYAR = 1,
													  TGL_BAYAR = DATE(NOW()),
													  TGL_BAYAR_ACT = NOW(),
													  USER_ID_BAYAR = '{$iuser}'
												  WHERE /*UNIT_ID='{$idunit}'
													AND*/ NO_PENJUALAN='{$no_penjualan}' 
													AND NO_PASIEN='{$no_pasien}'
													AND NO_KUNJUNGAN = '{$no_pel_id}'";
											//echo $sql."<br/>";
											$rs=mysql_query($sql);
											//echo mysql_error();
										}else{
											$statusProses='Error';
											$SError='Error7';
										}
									}else{
										$statusProses='Error';
										$SError='Error8';
									}
								}
							}
							//echo mysql_errno();mysql_error();
							if (mysql_errno()==0){		
								//echo "req titipan = ".$_REQUEST['titipan'].";<br>";
								if ($_REQUEST['titipan']>0){
									$sql="SELECT * FROM b_bayar WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND kasir_id='".$_REQUEST['idKasir']."' AND titipan_terpakai<titipan AND tipe=1 order by id";
									//echo $sql.";<br>";
									$rs=mysql_query($sql);
									//echo mysql_error();
									$titipan=$_REQUEST['titipan'];
									$ok="false";
									
									while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
										$cid=$rows['id'];
										$ctitip=$rows['titipan']-$rows['titipan_terpakai'];
										//echo "titipan = ".$titipan.", ctitip = ".$ctitip.";<br>";
										if ($titipan<=$ctitip){
											$ok="true";
											$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$titipan WHERE id=$cid";
										}else{
											$titipan=$titipan-$ctitip;
											$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$ctitip WHERE id=$cid";
										}
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										//echo mysql_error();
									}
								}
							}else{
								$statusProses='Error';
								$SError='Error9';
							}
						}else{
							$statusProses='Error';
							$SError='Error10';
						}
					}
					else{
						if (mysql_errno()==0){
							$tagihan = $_REQUEST['tagihan'];
							$nilai = $_REQUEST['nilai'];
							
							$bykresep = $bykresep;
							$detilresep = $tes;
							//$jmlresep = $jmlresep;
							
							$billing = $tagihan - $jmlresep;
							
							//echo $tagihan."<tagihan>";
							$sisa=0;
							for($i=0;$i<$bykresep;$i++){
								//echo $i;
								$pieces = explode("***", $detilresep);
								$isi = explode("-**-", $pieces[$i]);
								
								$no_penjualan = $isi[0];
								$totalTagihan = $isi[1];
								$no_pel_id = $isi[3];
						
								//echo $totalTagihan."<res>";
								if($sisa==0){
									if($nilai>=$totalTagihan){
										$z = $nilai - $totalTagihan;
										$sisa = $z;
										//echo $sisa."<awl>";
										$sql_get = "SELECT DISTINCT NO_KUNJUNGAN, CARA_BAYAR, UNIT_ID 
												FROM $dbapotek.a_penjualan 
												where NO_PENJUALAN = '{$no_penjualan}' 
												  /*AND UNIT_ID = '{$idunit}'*/ 
												  AND NO_PASIEN = '{$no_pasien}'
												  AND NO_KUNJUNGAN = '{$no_pel_id}'
												GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
										//echo $sql_get."<br /><br />";
										$query_get = mysql_query($sql_get);
										$data_get = mysql_fetch_array($query_get);
										$no_pelayanan = $data_get['NO_KUNJUNGAN'];
										$cara_bayar = $data_get['CARA_BAYAR'];
										$idunit = $data_get['UNIT_ID'];
															
										$queTambah="INSERT INTO $dbapotek.a_kredit_utang(BILLING_BAYAR_OBAT_ID, IS_AKTIF, NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN,FLAG)
													VALUES ('{$billingId}', '0', '{$no_kwitansi}', '{$idunit}', '{$iuser}', '{$ishift}', NOW(), '{$no_penjualan}', '{$totalTagihan}', '{$totalTagihan}', '{$totalTagihan}', '0', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','$flag');";
										//echo $queTambah.";<br>";
										$rs2=mysql_query($queTambah);
											
										if (mysql_errno()==0){
											$queTambah2="INSERT INTO $dbapotek.a_penjualan_log_billing (ID_PENJUALAN, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, USER_ACT, TGL_ACT, FLAG)
														SELECT ID, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, '{$iuser}', NOW(), FLAG FROM
														$dbapotek.a_penjualan 
														WHERE NO_PENJUALAN = '{$no_penjualan}' 
														  /*AND UNIT_ID = '{$idunit}'*/ 
														  AND NO_PASIEN = '{$no_pasien}'
														  AND NO_KUNJUNGAN = '{$no_pel_id}'
														GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
											//echo $queTambah2.";<br>";
											$rs3=mysql_query($queTambah2);
												
											if (mysql_errno()==0){
												$sql="UPDATE $dbapotek.a_penjualan 
													  SET /* CARA_BAYAR=1, */
														  UTANG=0,
														  SUDAH_BAYAR = 1,
														  TGL_BAYAR = DATE(NOW()),
														  TGL_BAYAR_ACT = NOW(),
														  USER_ID_BAYAR = '{$iuser}'
													  WHERE /*UNIT_ID='{$idunit}'
														AND*/ NO_PENJUALAN='{$no_penjualan}' 
														AND NO_PASIEN='{$no_pasien}'
														AND NO_KUNJUNGAN = '{$no_pel_id}'";
												//echo $sql."<br/>";
												$rs=mysql_query($sql);
											}else{
												$statusProses='Error';
												$SError='Error11';
											}
										}else{
											$statusProses='Error';
											$SError='Error12';
										}
									}
								}
								else{
									if($sisa>=$totalTagihan){
										$z = $sisa - $totalTagihan;
										$sisa = $z;
										//echo $sisa."<brkt>";
										$sql_get = "SELECT DISTINCT NO_KUNJUNGAN, CARA_BAYAR, UNIT_ID 
												FROM $dbapotek.a_penjualan 
												where NO_PENJUALAN = '{$no_penjualan}' 
												  /*AND UNIT_ID = '{$idunit}'*/ 
												  AND NO_PASIEN = '{$no_pasien}'
												  AND NO_KUNJUNGAN = '{$no_pel_id}'
												GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
										//echo $sql_get."<br /><br />";
										$query_get = mysql_query($sql_get);
										$data_get = mysql_fetch_array($query_get);
										$no_pelayanan = $data_get['NO_KUNJUNGAN'];
										$cara_bayar = $data_get['CARA_BAYAR'];
										$idunit = $data_get['UNIT_ID'];
															
										$queTambah="INSERT INTO $dbapotek.a_kredit_utang(BILLING_BAYAR_OBAT_ID, IS_AKTIF, NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN,FLAG)
													VALUES ('{$billingId}', '0', '{$no_kwitansi}', '{$idunit}', '{$iuser}', '{$ishift}', NOW(), '{$no_penjualan}', '{$totalTagihan}', '{$totalTagihan}', '{$totalTagihan}', '0', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','$flag');";
										//echo $queTambah.";<br>";
										$rs2=mysql_query($queTambah);
											
										if (mysql_errno()==0){
											$queTambah2="INSERT INTO $dbapotek.a_penjualan_log_billing (ID_PENJUALAN, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, USER_ACT, TGL_ACT, FLAG)
														SELECT ID, UTANG, TGL_BAYAR, TGL_BAYAR_ACT, USER_ID_BAYAR, '{$iuser}', NOW(), FLAG FROM
														$dbapotek.a_penjualan 
														WHERE NO_PENJUALAN = '{$no_penjualan}' 
														  /*AND UNIT_ID = '{$idunit}'*/ 
														  AND NO_PASIEN = '{$no_pasien}'
														  AND NO_KUNJUNGAN = '{$no_pel_id}'
														GROUP BY NO_PENJUALAN, UNIT_ID, NO_PASIEN, TGL";
											//echo $queTambah2.";<br>";
											$rs3=mysql_query($queTambah2);
												
											if (mysql_errno()==0){
												$sql="UPDATE $dbapotek.a_penjualan 
													  SET /* CARA_BAYAR=1, */
														  UTANG=0,
														  SUDAH_BAYAR = 1,
														  TGL_BAYAR = DATE(NOW()),
														  TGL_BAYAR_ACT = NOW(),
														  USER_ID_BAYAR = '{$iuser}'
													  WHERE /*UNIT_ID='{$idunit}'
														AND*/ NO_PENJUALAN='{$no_penjualan}' 
														AND NO_PASIEN='{$no_pasien}'
														AND NO_KUNJUNGAN = '{$no_pel_id}'";
												//echo $sql."<br/>";
												$rs=mysql_query($sql);
											}else{
												$statusProses='Error';
												$SError='Error13';
											}
										}else{
											$statusProses='Error';
											$SError='Error14';
										}
									}
								}
							}
						
							if (mysql_errno()==0){		
								//echo "req titipan = ".$_REQUEST['titipan'].";<br>";
								if ($_REQUEST['titipan']>0){
									$sql="SELECT * FROM b_bayar WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND kasir_id='".$_REQUEST['idKasir']."' AND titipan_terpakai<titipan AND tipe=1 order by id";
									//echo $sql.";<br>";
									$rs=mysql_query($sql);
									$titipan=$_REQUEST['titipan'];
									$ok="false";
									
									while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
										$cid=$rows['id'];
										$ctitip=$rows['titipan']-$rows['titipan_terpakai'];
										//echo "titipan = ".$titipan.", ctitip = ".$ctitip.";<br>";
										if ($titipan<=$ctitip){
											$ok="true";
											$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$titipan WHERE id=$cid";
										}else{
											$titipan=$titipan-$ctitip;
											$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$ctitip WHERE id=$cid";
										}
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
									}
								}
							}
							else{
								$statusProses='Error';
								$SError='Error15';
							}
						
							//echo $billing."<billing>";
							//echo $sisa."<sisa>";
							if($billing>=$sisa){
								$fix = $nilai;
							}else if($billing<$sisa){
								$fix = $nilai;
							}
							//echo $fix."<fix>";
						
							if (mysql_errno()==0){
								$sqlUpdate="update b_bayar set nilai = '".$fix."'
											where id = '".$billingId."'";
								//echo $sqlUpdate.";<br>";
								$rs=mysql_query($sqlUpdate);
							}else{
								$statusProses='Error';
								$SError='Error16';
							}
						}else{
							$statusProses='Error';
							$SError='Error17';
						}
					}  //entek e
				}
			}
		}
		break;
	case 'hapus':
		$sqlCekUser="SELECT id,kunjungan_id,kso_id FROM b_bayar WHERE id='".$_REQUEST['rowid']."' AND user_act = '".$userId."'";
		$queCekUser=mysql_query($sqlCekUser);
		if(mysql_num_rows($queCekUser)==0){
			$statusProses='Error';
			$SError='Error18';
			$msg="Anda Bukan yang melakukan pembayaran ini, pembayaran tidak bisa dihapus !";
		}else{
			$rwCekUser=mysql_fetch_array($queCekUser);
			$kso_id=$rwCekUser["kso_id"];
			$kunjungan_id=$rwCekUser["kunjungan_id"];
			$sqlCek="SELECT a.id, b.ID idkredit
					FROM b_bayar a 
					INNER JOIN $dbapotek.a_kredit_utang b ON a.id = b.BILLING_BAYAR_OBAT_ID
					WHERE a.id='".$_REQUEST['rowid']."'";
			$queCek=mysql_query($sqlCek);
			$cek=mysql_num_rows($queCek);
			//hanya billing saja
			if($cek==0){
				$sqlUp="UPDATE b_bayar SET user_delete='".$userId."' WHERE id='".$_REQUEST['rowid']."'";
				mysql_query($sqlUp);
				$sqlHapus="delete from b_bayar where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				$sqlHapus="UPDATE b_tindakan t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=0 AND bt.nilai>0";
				mysql_query($sqlHapus);
				if ($kso_id==$idKsoBPJS){
					$sqlHapus="UPDATE b_inacbg_grouper SET bayar_px=0,status=0 WHERE kunjungan_id_group='$kunjungan_id'";
					mysql_query($sqlHapus);					
				}
				$sqlHapus="UPDATE b_tindakan_kamar t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=1 AND bt.nilai>0";
				mysql_query($sqlHapus);
				$sqlHapus="delete from b_bayar_tindakan where bayar_id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
			}
			//billing + obat
			else if($cek>0){
				 $que="SELECT * FROM(
					SELECT b.TGL_BAYAR, d.tgl_retur, a.id FROM b_bayar a
					INNER JOIN $dbapotek.a_kredit_utang b ON b.NO_BAYAR = a.no_kwitansi AND a.id = b.BILLING_BAYAR_OBAT_ID
					INNER JOIN $dbapotek.a_penjualan c ON c.NO_PENJUALAN = b.FK_NO_PENJUALAN AND c.UNIT_ID = b.UNIT_ID AND c.NO_KUNJUNGAN = b.NO_PELAYANAN AND c.NO_PASIEN = b.NORM
					INNER JOIN $dbapotek.a_return_penjualan d ON d.idpenjualan = c.ID) cek
					WHERE DATE_FORMAT(cek.TGL_BAYAR,'%Y-%d-%m %h:%i:%s') < DATE_FORMAT(cek.tgl_retur,'%Y-%d-%m %h:%i:%s') and cek.id='".$_REQUEST['rowid']."'";
				 //echo $que."<br/>";
				 $rw=mysql_query($que);
				 $rwcek=mysql_num_rows($rw);
				 //$tgl_bayar = strtotime($rwcek['TGL_BAYAR']); 
				 //$tgl_retur = strtotime($rwcek['tgl_retur']);
				 //sudah ada obat yg di retur
				  if($rwcek>0){
						$statusProses='Error';
						$SError='Error18';
						$msg="Sudah ada retur obat, pembayaran tidak bisa dihapus !";
				  }
				  //hapus aman
				  else{
						$sql="SELECT b.FK_NO_PENJUALAN, b.TOTAL_HARGA, b.UNIT_ID, b.NORM
							FROM b_bayar a
							INNER JOIN $dbapotek.a_kredit_utang b ON b.NO_BAYAR = a.no_kwitansi
							WHERE a.id = '".$_REQUEST['rowid']."'";
						//echo $sql."<br/>";
						$rs=mysql_query($sql);
						while ($rows=mysql_fetch_array($rs)){
							$que="UPDATE $dbapotek.a_penjualan SET UTANG='".$rows['TOTAL_HARGA']."', SUDAH_BAYAR = 0 WHERE NO_PENJUALAN='".$rows['FK_NO_PENJUALAN']."' AND UNIT_ID='".$rows['UNIT_ID']."' AND NO_PASIEN='".$rows['NORM']."'";
							//echo $que."<br/>";
							$rw=mysql_query($que);
						}
						
						if (mysql_errno()==0){
							$sql2="select b.ID
							FROM b_bayar a
							INNER JOIN $dbapotek.a_kredit_utang b ON b.NO_BAYAR = a.no_kwitansi
							WHERE a.id = '".$_REQUEST['rowid']."'";
							//echo $sql2."<br/>";
							$rs2=mysql_query($sql2);
							while ($rows2=mysql_fetch_array($rs2)){
								$sqlUp="UPDATE $dbapotek.a_kredit_utang SET USER_DELETE='".$iuser."' WHERE ID='".$rows2['ID']."'";
								//echo $sqlUp."<br/>";
								mysql_query($sqlUp);
								$sqlHapus="delete from $dbapotek.a_kredit_utang where ID='".$rows2['ID']."'";
								//echo $sqlHapus."<br/>";
								mysql_query($sqlHapus);
							}
							
							if (mysql_errno()==0){
								$sqlUp="UPDATE b_bayar SET user_delete='".$userId."' WHERE id='".$_REQUEST['rowid']."'";
								//echo $sqlUp."<br/>";
								mysql_query($sqlUp);
								$sqlHapus="delete from b_bayar where id='".$_REQUEST['rowid']."'";
								//echo $sqlHapus."<br/>";
								mysql_query($sqlHapus);
								$sqlHapus="UPDATE b_tindakan t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=0 AND bt.nilai>0";
								//echo $sqlHapus."<br/>";
								mysql_query($sqlHapus);
								$sqlHapus="UPDATE b_tindakan_kamar t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=1 AND bt.nilai>0";
								//echo $sqlHapus."<br/>";
								mysql_query($sqlHapus);
								$sqlHapus="delete from b_bayar_tindakan where bayar_id='".$_REQUEST['rowid']."'";
								//echo $sqlHapus."<br/>";
								mysql_query($sqlHapus);
							}else{
								$statusProses='Error';
								$SError='Error18';
							}
						}else{
							$statusProses='Error';
							$SError='Error19';
						}
		  		  }
		 	}
		}
		break;
	case 'simpan':
		$sqlSimpan="update b_bayar set kunjungan_id='".$_REQUEST['idKunj']."',kasir_id='".$_REQUEST['idKasir']."',tgl='".$tgl."',dibayaroleh='".$_REQUEST['dibayaroleh']."',nobukti='".$_REQUEST['nobukti']."',nilai='".$_REQUEST['nilai']."',tgl_act='$tglact',user_act='$userId' where id='".$_REQUEST['idBayar']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if($statusProses=='Error') {
//$dt="0".chr(5).chr(4).chr(5).strtolower($SError).chr(1).$msg;
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']).chr(1).$msg;
}
/* if($statusProses=='Error1') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']).strtolower($_REQUEST['act']).strtolower($_REQUEST['act']).chr(1).$msg;
} */
else {
	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	if(strtolower($grd) == "true")
	{
		$sql="select * from (
		SELECT 
		b.id,
		b.kunjungan_id,
		b.jenis_kunjungan,
		b.kasir_id,
		u.nama,
		DATE(b.tgl) as tgl,
		CONCAT(DATE_FORMAT(b.tgl,'%d-%m-%Y'),' ',DATE_FORMAT(b.tgl_act,'%H:%i')) as tgl_act_x,
		b.dibayaroleh,
		b.tagihan,
		b.nilai,
		b.jaminan_kso,
		b.keringanan,
		b.titipan,
		b.tgl_act,
		b.user_act,
		b.tipe,
		b.no_kwitansi as nobukti,
		kso.nama as kso,
		mu.nama as jenis_kasir,
		b.nilai_diskon,
		b.nilai_diskon_dokter,
		b.dokter_diskon
		FROM b_bayar b
		inner join b_ms_pegawai u on b.user_act=u.id 
		inner join b_ms_kso kso on kso.id=b.kso_id
		left join b_ms_unit mu on mu.id=b.kasir_id 
		WHERE 
		b.kunjungan_id = '".$_REQUEST['idKunj']."' 
		/*AND b.jenis_kunjungan='".$_REQUEST['jenisKunj']."'*/) as gab order by gab.id desc";
	}
	elseif(strtolower($grd1)=="true")
	{
		if ($_REQUEST['idPel']==""){
			$sql="SELECT * FROM (SELECT t.id,kunjungan_id,mt.kode kdTind,mt.nama nmTind,mk.nama nmKls,biaya*qty subTot,biaya,
	qty cTind,ket,mp.nama konsul FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id=mk.id 
	LEFT JOIN b_ms_pegawai mp ON t.user_id=mp.id WHERE kunjungan_id=".$_REQUEST['idKunj']." 
	UNION 
	SELECT tk.id,p.kunjungan_id,mk.kode kdTind,mk.nama nmTind,mKls.nama nmKls,
	IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1)*tk.tarip,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1)*tk.tarip) subTot,
	tk.tarip biaya,IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1),(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1)) cTind,'','' 
	FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
	INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id=".$_REQUEST['idKunj']." AND tk.aktif=1) AS gab $filter order by $sorting";
		}else{
			$sql="SELECT t.id,t.kunjungan_id,mt.kode kdTind,mt.nama nmTind,mk.nama nmKls,biaya*qty subTot,biaya,
	qty cTind,t.ket,mp.nama konsul FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id=mk.id 
	LEFT JOIN b_ms_pegawai mp ON t.user_id=mp.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id WHERE t.pelayanan_id=".$_REQUEST['idPel']." ORDER BY t.id";
		}
	}
	else if(strtolower($grd2)=="true"){
		$sql="SELECT * FROM(
SELECT p.id, p.id AS pelayanan_id,p.tgl AS tgl_pelayanan, p.kunjungan_id, DATE_FORMAT(p.tgl, '%d-%m-%Y') tgl, u.id AS unit_id, u.nama AS unit, u2.nama AS unitasal FROM b_pelayanan p
INNER JOIN b_ms_unit u ON u.id = p.unit_id
INNER JOIN b_ms_unit u2 ON u2.id = p.unit_id_asal
LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
WHERE p.kunjungan_id = '".$_REQUEST['idKunj']."' AND p.unit_id NOT IN (122,123) AND t.user_id IS NULL ) AS tbl
WHERE (SELECT COUNT(d.diagnosa_id) FROM b_diagnosa d WHERE d.pelayanan_id = tbl.pelayanan_id) <= 0
  AND (SELECT COUNT(t.id) FROM b_tindakan t WHERE t.pelayanan_id = tbl.pelayanan_id AND t.user_id <> 0) <= 0
  AND (SELECT COUNT(ap.ID) FROM $dbapotek.a_penjualan ap WHERE ap.NO_KUNJUNGAN = tbl.pelayanan_id) <= 0 
  AND (SELECT COUNT(p2.id) FROM b_pelayanan p2 INNER JOIN b_ms_unit u2 ON u2.id = p2.unit_id
		WHERE p2.kunjungan_id = tbl.kunjungan_id AND p2.unit_id_asal = tbl.unit_id AND u2.inap = 0) <= 0
  AND (SELECT COUNT(p3.id) FROM b_pelayanan p3 INNER JOIN b_ms_unit u3 ON u3.id = p3.unit_id
		WHERE p3.kunjungan_id = tbl.kunjungan_id AND p3.unit_id_asal = tbl.unit_id AND u3.inap = 1) <= 0
  AND DATEDIFF(NOW(), tbl.tgl_pelayanan) <= 0
GROUP BY tbl.pelayanan_id";
	}
	
	//echo $sql.";<br>";
	$rs=mysql_query($sql);
	$jmldata=mysql_num_rows($rs);
	if ($page=="" || $page=="0") $page=1;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	$sql=$sql." limit $tpage,$perpage";
	//echo $sql;
	
	$rs=mysql_query($sql);
	$i=($page-1)*$perpage;
	$dt=$totpage.chr(5);
	$pulang=$_REQUEST['pulang'];
	if(strtolower($grd) == "true")
	{
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			$sisipan = $rows["id"]."|".
						$rows["kunjungan_id"]."|".
						$rows["tagihan"]."|".
						$rows["keringanan"]."|".
						$rows["titipan"]."|".
						$rows["tipe"]."|".
						$rows["nilai"]."|".
						$rows["jaminan_kso"]."|".
						$rows["nobukti"]."|".
						tglSQL($rows["tgl"])."|".
						(($rows["tipe"]==0)?($rows["nilai"] - $rows["nilai_diskon"]  - $rows["nilai_diskon_dokter"]):$rows["titipan"])."|".
						$rows["dibayaroleh"]."|".
						$rows["kasir_id"]."|".
						$rows["jenis_kunjungan"]."|".
						$rows['nilai_diskon']."|".
						$rows['dokter_diskon']."|".
						$rows['nilai_diskon_dokter'];
			
			$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_act_x"].chr(3).$rows["nobukti"].chr(3).(($rows["tipe"]==0)?$rows["nilai"] - $rows["nilai_diskon"] - $rows['nilai_diskon_dokter']:$rows["titipan"]).chr(3).$rows["kso"].chr(3).$rows["dibayaroleh"].chr(3).$rows["nama"].chr(3).$rows["jenis_kasir"].chr(6);
		}
	}elseif($grd1=="true")
	{
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			$dt.=$rows['id'].chr(3).number_format($i,0,",","").chr(3).$rows["kdTind"].chr(3).$rows["nmTind"].chr(3).$rows["nmKls"].chr(3).$rows["biaya"].chr(3).$rows["cTind"].chr(3).$rows["subTot"].chr(3).$rows["konsul"].chr(3).$rows["ket"].chr(6);
		}
	}
	elseif($grd2=="true")
	{
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			/* if($rows['cekbnr']==0){
				$txt="<a href='javascript:void(0)' onclick='hapusKonsul($rows[id])'>Hapus</a>";
			}else if($rows['cekbnr']==1){
				$txt="<a href='javascript:void(0)' onclick='masih_progres()'>Hapus</a>";
			} */
			
			//if($rows['tipe']=='konsul'){
				$txt="<a href='javascript:void(0)' onclick='hapusKonsul($rows[id],$pulang)'>Hapus</a>";
			/* }else if($rows['tipe']=='mrs'){
				$txt="<a href='javascript:void(0)' onclick='masih_progres($rows[id])'>Hapus</a>";
			} */ 
			
			$dt .= $rows['pelayanan_id'].chr(3).
				   $i.chr(3).
				   $rows['tgl'].chr(3).
				   $rows['unit'].chr(3).
				   $rows['unitasal'].chr(3).
				   $txt.chr(6);
		}
	}
	
	//echo $dt."--||--".$totpage.chr(5);
	if ($dt!=$totpage.chr(5)){
			$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']).chr(1).$msg;
			$dt=str_replace('"','\"',$dt);
		}
	
		mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>
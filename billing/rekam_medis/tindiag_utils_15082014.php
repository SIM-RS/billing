<?php
include("../koneksi/konek.php");
//include '../loket/forAkun.php';
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$keyTindLab = explode(',',$_REQUEST["keyTindLab"]);
$grd = $_REQUEST["grd"];
$grd1 = $_REQUEST["grd1"];
$grd2 = $_REQUEST["grd2"];
$grd3 = $_REQUEST["grd3"];
$grd4 = $_REQUEST["grd4"];
$grdRsp1 = $_REQUEST["grdRsp1"];
$grdRsp2 = $_REQUEST["grdRsp2"];
$grdResep = $_REQUEST["grdResep"];
$grdINACBG = $_REQUEST["grdINACBG"];
$grdAnamnesa = $_REQUEST["grdAnamnesa"];
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$isDokPengganti=$_REQUEST['isDokPengganti'];
$userId=$_REQUEST['userId'];
$unitId=$_REQUEST['unitId'];
$inap = $_GET['inap'];
$biayaRS = $_REQUEST['biaya'];
$act = $_REQUEST['pullMR'];
$no_resep=$_REQUEST['noResep'];
$tgl_resep = $_REQUEST['tgl_resep'];
$dt_temp = "";

$sqlUn = "SELECT unit_id FROM b_pelayanan WHERE id = '".$_REQUEST['pelayanan_id']."'";
$rsUn = mysql_query($sqlUn);
$rwUn = mysql_fetch_array($rsUn);

$sqlDok = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$_REQUEST['dokter']."'";
$rsDok = mysql_query($sqlDok);
$rwDok = mysql_fetch_array($rsDok);

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'data_anamnesa':
		if($_REQUEST['action']=='tambah'){	
			$sql = "INSERT INTO anamnese (
				   KUNJ_ID, TGL, PEL_ID, PASIEN_ID, PEGAWAI_ID, KU, SOS, RPS, RPD, RPK, KUM, GCS, KESADARAN, TENSI, RR,
				   NADI, SUHU, BB, GIZI, KL, COR, PULMO, INSPEKSI, PALPASI, AUSKULTASI, PERKUSI, EXT) 
				   values (
				   '".$_REQUEST['KUNJ_ID']."',
				   NOW(),
				   '".$_REQUEST['PEL_ID']."',
				   '".$_REQUEST['PASIEN_ID']."',
				   '".$_REQUEST['PEGAWAI_ID']."',
				   '".$_REQUEST['KU']."',
				   '".$_REQUEST['SOS']."',
				   '".$_REQUEST['RPS']."',
				   '".$_REQUEST['RPD']."',
				   '".$_REQUEST['RPK']."',
				   '".$_REQUEST['KUM']."',
				   '".$_REQUEST['GCS']."',
				   '".$_REQUEST['KESADARAN']."',
				   '".$_REQUEST['TENSI']."',
				   '".$_REQUEST['RR']."',
				   '".$_REQUEST['NADI']."',
				   '".$_REQUEST['SUHU']."',
				   '".$_REQUEST['BB']."',
				   '".$_REQUEST['GIZI']."',
				   '".$_REQUEST['KL']."',
				   '".$_REQUEST['COR']."',
				   '".$_REQUEST['PULMO']."',
				   '".$_REQUEST['INSPEKSI']."',
				   '".$_REQUEST['PALPASI']."',
				   '".$_REQUEST['AUSKULTASI']."',
				   '".$_REQUEST['PERKUSI']."',
				   '".$_REQUEST['EXT']."'
					)";
					mysql_query($sql);
		}
		else if($_REQUEST['action']=='simpan'){	
				$sUp="update anamnese set 
			   TGL=NOW(),
			   PEGAWAI_ID='".$_REQUEST['PEGAWAI_ID']."',			   
			   KU='".$_REQUEST['KU']."',
			   SOS='".$_REQUEST['SOS']."',
			   RPS='".$_REQUEST['RPS']."',
			   RPD='".$_REQUEST['RPD']."',
			   RPK='".$_REQUEST['RPK']."',
			   KUM='".$_REQUEST['KUM']."',
			   GCS='".$_REQUEST['GCS']."',
			   KESADARAN='".$_REQUEST['KESADARAN']."',
			   TENSI='".$_REQUEST['TENSI']."',
			   RR='".$_REQUEST['RR']."',
			   NADI='".$_REQUEST['NADI']."',
			   SUHU='".$_REQUEST['SUHU']."',
			   BB='".$_REQUEST['BB']."',
			   GIZI='".$_REQUEST['GIZI']."',
			   KL='".$_REQUEST['KL']."',
			   COR='".$_REQUEST['COR']."',
			   PULMO='".$_REQUEST['PULMO']."',
			   INSPEKSI='".$_REQUEST['INSPEKSI']."',
			   PALPASI='".$_REQUEST['PALPASI']."',
			   AUSKULTASI='".$_REQUEST['AUSKULTASI']."',
			   PERKUSI='".$_REQUEST['PERKUSI']."',
			   EXT='".$_REQUEST['EXT']."' WHERE ANAMNESE_ID='".$_REQUEST['id_anamnesa']."'";
			   mysql_query($sUp);
	   }
	   else if($_REQUEST['action']=='hapus'){
		   mysql_query("delete from anamnese where ANAMNESE_ID='".$_REQUEST['id_anamnesa']."'");
	   }
	   break;
	case 'dok_an':
	   $sql = "SELECT id,nama FROM b_ms_pegawai WHERE spesialisasi_id=42";
	   $rs_an = mysql_query($sql);
	   while($row_an = mysql_fetch_array($rs_an)){
		  ?>
		  <input type="hidden" id="hid_id_an" name="hid_id_an" value="<?php echo $row_an['id'];?>" />
		  <label>
			 <input type="checkbox" id="chk_an_<?php echo $row_an['id'];?>" name="chk_an" /> <?php echo $row_an['nama'];?>
		  </label><br>
		  <?php
	   }
	   return;
	   break;
    case 'tambah':
        switch($_REQUEST["smpn"]) {
			case 'btnSimpanResepObat':
				$tgl2=$_REQUEST['tanggal'];
				$no_kunj = $_REQUEST['idPel'];
				$NoRM = $_REQUEST['no_rm'];
				$NoResep = $_REQUEST['no_resep'];
				$subtotal = $_REQUEST['subtotal'];
				$iduser=$_REQUEST['iduser'];
				
				$sUnit="select UNIT_ID from $dbapotek.a_unit u where u.unit_billing=".$_REQUEST['idunit'];
				$qUnit=mysql_query($sUnit);
				$rUnit=mysql_fetch_array($qUnit);
				$idunit=$rUnit['UNIT_ID']; 
				
				$sql="SELECT DISTINCT r.no_resep,r.no_rm,IFNULL(m.IDMITRA,2) kso_id,r.cara_bayar,r.kepemilikan_id,r.dokter_nama,
					r.nama_pasien,r.alamat,u.unit_billing,IFNULL(u.UNIT_ID,0) UNIT_ID,CURDATE() tgl,NOW() tgl_act 
					FROM $dbbilling.b_resep r INNER JOIN $dbbilling.b_pelayanan p ON r.id_pelayanan=p.id
					LEFT JOIN $dbapotek.a_unit u ON p.unit_id=u.unit_billing
					LEFT JOIN $dbapotek.a_mitra m ON r.kso_id=m.kso_id_billing 
					WHERE r.apotek_id=$idunit AND r.id_pelayanan=$no_kunj AND r.no_rm='$NoRM' 
					AND r.no_resep='$NoResep' AND r.tgl='$tgl2' AND u.UNIT_ISAKTIF=1";
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
				$rw1=mysql_fetch_array($rs1);
				$kso_id=$rw1["kso_id"];
				$kso=1;
				//if ($kso_id<>2) $kso=1;
				$kp_id=$rw1["kepemilikan_id"];
				$tgltrans=$rw1["tgl"];
				$tgl_act=date('d-m-Y');
				$artgl_act=explode("-",$tgltrans);
				$cara_bayar=$rw1["cara_bayar"];
				$nm_pasien=str_replace("'","''",$rw1["nama_pasien"]);
				$nm_pasien=str_replace('"','""',$nm_pasien);
				$txtalamat=str_replace("'","''",$rw1["alamat"]);
				$txtalamat=str_replace('"','""',$txtalamat);
				$ruangan=$rw1["UNIT_ID"];
				$dokter=str_replace("'","''",$rw1["dokter_nama"]);
				$dokter=str_replace('"','""',$dokter);
				$shft=0;
				
				$embalage=0;
				$jasa_resep=0;
				$tot_harga=$subtotal+$embalage+$jasa_resep;
				$nutang=0;
				$biaya_retur=0;
						
				//$sql="select MAX(NO_PENJUALAN) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$thtr";
				$sql="select NO_PENJUALAN from $dbapotek.a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$artgl_act[0] ORDER BY ID DESC LIMIT 1";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$nokw="000001";
				//$no_kunj="0";
				//$shft=1;
				if ($rows=mysql_fetch_array($rs)){
					//$shft=$rows["SHIFT"];
					$nokw=(int)$rows["NO_PENJUALAN"]+1;
					$nokwstr=(string)$nokw;
					if (strlen($nokwstr)<6){
						for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
					}else{
						$nokw=$nokwstr;
					}
				}
				$no_penjualan=$nokw;
				$nokwPrint=$no_penjualan;
				//echo "no_kw=".$no_penjualan."<br>";
			
				$val=$no_penjualan."|".$NoRM."|".$tgltrans;
			
				$fdata = $_REQUEST['fdata'];
				$arfdata=explode("*|*",$fdata);
				for ($j=0;$j<count($arfdata);$j++){
					$data=explode("|",$arfdata[$j]);
					
						$hSatuan=$data[1];
						$hNetto=$data[2];
						$qty=$data[3];
						$obat_id=$data[5];
						$isRacikan=$data[6];
						
						$sql="select * from $dbbilling.b_resep WHERE id = '".$data[0]."'";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$rw=mysql_fetch_array($rs);
						$ketDosis=str_replace("'","''",$rw["ket_dosis"]);
						$ketDosis=str_replace('"','""',$ketDosis);
						
						if ($kp_id!=$data[4]){
							$sql="call $dbapotek.gd_mutasi($idunit,$idunit,0,'$no_penjualan',$obat_id,$data[4],$kp_id,$qty,2,$iduser,1,'$tgltrans','$tgl_act')";
							//echo $sql."<br>";
							$rs=mysql_query($sql);
						}
			
						$sql="select SQL_NO_CACHE * from $dbapotek.a_penerimaan ap where OBAT_ID=".$obat_id." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=".$kp_id." and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
						//$sql."<br>";
						$rs=mysql_query($sql);
						$done="false";
						$jml=$qty;
						$success=1;
						$cid=0;
						//echo "Jenis_Pasien=".$kp_id."<br>";
						while (($rows=mysql_fetch_array($rs))&&($done=="false"))
						{
							$cstok=$rows['QTY_STOK'];
							$cid=$rows['ID'];
							if ($cstok>=$jml)
							{
								$done="true";
								$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$sql="insert into $dbapotek.a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,KET_DOSIS,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kp_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$hNetto,$hSatuan,$jml*$hSatuan,$subtotal,$embalage,$jasa_resep,$tot_harga,'$ketDosis',1,'$nm_pasien','$txtalamat',$nutang,$isRacikan)";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$success=0;
									$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
								}
							}else{
								$jml=$jml-$cstok;
								$sql="update $dbapotek.a_penerimaan set QTY_STOK=0 where ID=$cid";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$sql="insert into $dbapotek.a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,KET_DOSIS,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kp_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$hNetto,$hSatuan,$cstok*$hSatuan,$subtotal,$embalage,$jasa_resep,$tot_harga,'$ketDosis',1,'$nm_pasien','$txtalamat',$nutang,$isRacikan)";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$success=0;
									$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
								}
							}
						}
						
						if ($success==1){
							$sqlTambah = "SELECT ID FROM $dbapotek.a_penjualan WHERE USER_ID=$iduser AND UNIT_ID=$idunit AND PENERIMAAN_ID=$cid";
							//echo $sqlTambah."<br>";
							$rs1=mysql_query($sqlTambah);
							$rw1=mysql_fetch_array($rs1);
							$IdPenjualan=$rw1['ID'];
							$sqlTambah = "UPDATE $dbbilling.b_resep SET status = '2', penjualan_id='$IdPenjualan' WHERE id = '".$data[0]."'";
							//echo $sqlTambah."<br>";
							$rs1=mysql_query($sqlTambah);
						}
				}
			  break;
            case 'btnSimpanTindINACBG':
				/*-----Tambah Tindakan-----*/
				$sql="SELECT * FROM b_kunjungan WHERE id='$kunjungan_id'";
				$rsCekPlg=mysql_query($sql);
				$rwCekPlg=mysql_fetch_array($rsCekPlg);
				if ($rwCekPlg["pulang"]==1){
					$statusProses='Error';
					$msg='Pasien Sudah Pulang, Jadi Tidak Boleh Memasukkan Tindakan Lagi !';
				}else{
					$cekDokter="select bt.* from b_tindakan_inacbg bt
					where bt.pelayanan_id='".$pelayanan_id."' and bt.user_id=0";
					$rsCekDokter=mysql_query($cekDokter);
					if(mysql_num_rows($rsCekDokter)>0) {
						$statusProses='Error';
					}
					else {
						$sql="SELECT * FROM b_ms_unit WHERE id='".$unitId."'";
						$rsUnit=mysql_query($sql);
						$rwUnit=mysql_fetch_array($rsUnit);
						$idParent=$rwUnit['parent_id'];
						$biaya_pasien = 0;
						$biaya_kso = 0;
	
						//$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
						$sqlCekStat="SELECT k.kso_id,k.kso_kelas_id,k.jenis_layanan,p.unit_id_asal,p.jenis_kunjungan,mu.inap,mu.parent_id,mu.kategori 
	FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id LEFT JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
	WHERE k.id = '$kunjungan_id' AND p.id='$pelayanan_id'";
						$rsCekStat = mysql_query($sqlCekStat);
						$rowCekStat = mysql_fetch_array($rsCekStat);
						$cUnitAsalIsInap = $rowCekStat["inap"];
						$cUnitAsal = $rowCekStat["unit_id_asal"];
						$cJenisKunj = $rowCekStat["jenis_kunjungan"];
						$cStatPas = $rowCekStat['kso_id'];
						$cJenisLayAwalKunj = $rowCekStat['jenis_layanan'];
						
						if($inap == 1){
							$sqlIsAktif="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='$pelayanan_id' AND aktif=0";
							$rsIsAktif=mysql_query($sqlIsAktif);
							if (mysql_num_rows($rsIsAktif) > 0){
								$sqlUpdtAktif="UPDATE b_tindakan_kamar SET aktif=1 WHERE pelayanan_id='$pelayanan_id' AND aktif=0";
								$rsUpdtAktif=mysql_query($sqlUpdtAktif);
							}
						}
						//jika status kso pasien umum
						//echo $rowCekStat['kso_id'].'tes<br>';
						if($rowCekStat['kso_id'] == 1 || $rowCekStat['kso_id'] == 2) {
							//seluruh biaya ditanggung pasien sendiri
							//$biaya_pasien = $biayaRS;
							$biaya_kso = $biayaRS;
						}
						else {
							/*$sqlCek = "select * from b_ms_kso_paket_nonbiaya where kso_id = '".$rowCekStat['kso_id']."' and ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
							//echo $sqlCek."<br>";
							$rsCek = mysql_query($sqlCek);
							if(mysql_num_rows($rsCek) > 0) {
								$rowCek = mysql_fetch_array($rsCek);
								$biaya_kso = 0;
							}else{*/
								if($inap == 1) {
									if($rowCekStat['kso_id'] == 4) {
										//askes sosial
										$sqlCek = "select * from b_ms_kso_pakomodasi where ms_kso_id = '4' and ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
										//echo $sqlCek."<br>";
										$rsCek = mysql_query($sqlCek);
										//jika hasil lebih dari 0 -> termasuk akomodasi
										if(mysql_num_rows($rsCek) > 0) {
											// Jika hak kelas != kelas + !=non kelas + != ipit + != icu igd/roi igd
											if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
												$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '4'";
												//echo "<br>".$sqlHp."<br>";
												$rsHp = mysql_query($sqlHp);
												$paket_hp = 0;
												if(mysql_num_rows($rsHp) > 0) {
													$rowHp = mysql_fetch_array($rsHp);
													$paket_hp = $rowHp['jaminan'];
													mysql_free_result($rsHp);
												}
		
												//paket hp dibandingkan dengan tindakan akomodasi perharinya ditambah biaya kamar
											   $sqlCekAkomodasi = "select ifnull(sum(biaya * qty),0) as jumlah,ifnull(sum(biaya_pasien * qty),0) as biaya_pasien from b_tindakan_inacbg t 
												where t.ms_tindakan_id in (select ms_tindakan_id from b_ms_kso_pakomodasi where ms_kso_id = '4') and t.pelayanan_id = '$pelayanan_id'";
												//echo $sqlCekAkomodasi."<br>";
												$rsAkomodasi = mysql_query($sqlCekAkomodasi);
												$rowAkomodasi = mysql_fetch_array($rsAkomodasi);
							
												$biayaKamar="SELECT id,kamar_id,IF (DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)) AS qtyHari,
		tarip,beban_kso,beban_pasien
		FROM b_tindakan_kamar WHERE pelayanan_id='".$pelayanan_id."'";
												//echo $biayaKamar."<br>";
												$rsBiayaKamar=mysql_query($biayaKamar);
												$rowBiayaKamar=0;
												$rowBiayaKamarHP=0;
												$rowBiayaKamarPasien=0;
												while ($rwBiayaKamar=mysql_fetch_array($rsBiayaKamar)){
													if ($rwBiayaKamar['tarip']==0 || $rwBiayaKamar['beban_kso']==0){
														if ($rwBiayaKamar['kamar_id']!=0){
															$sql="SELECT * FROM b_ms_kamar_tarip WHERE kamar_id='".$rwBiayaKamar['kamar_id']."' AND kelas_id='".$_GET['kelas_id']."'";
															$rsKmr=mysql_query($sql);
															$rwKmr=mysql_fetch_array($rsKmr);
															
															$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
															$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
															$bPx=0;
															//===jika hak_kelas=kelas 2, naik ke kelas 1=====
															if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){
																$bPx=100000;
															}elseif ($rwKmr['tarip']>$paket_hp){
																$bPx=$rwKmr['tarip']-$paket_hp;
															}
															$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
															$sql="UPDATE b_tindakan_kamar SET tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
															$rsKmr=mysql_query($sql);											
														}else{
															$sql="SELECT mkt.*,mk.kode,mk.nama FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_kamar mk ON mkt.kamar_id=mk.id WHERE mkt.unit_id='".$unitId."' AND mkt.kelas_id='".$_GET['kelas_id']."' LIMIT 1";
															//echo $sql."<br>";
															$rsKmr=mysql_query($sql);
															$rwKmr=mysql_fetch_array($rsKmr);
															
															$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
															$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
															$bPx=0;
															//===jika hak_kelas=kelas 2, naik ke kelas 1=====
															if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){
																$bPx=100000;
															}elseif ($rwKmr['tarip']>$paket_hp){
																$bPx=$rwKmr['tarip']-$paket_hp;
															}
															$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
															$sql="UPDATE b_tindakan_kamar SET kamar_id='".$rwKmr['kamar_id']."',kode='".$rwKmr['kode']."',nama='".$rwKmr['nama']."',tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
															//echo $sql."<br>";
															$rsKmr=mysql_query($sql);
														}
													}else{
														$rowBiayaKamar += $rwBiayaKamar['tarip'] * $rwBiayaKamar['qtyHari'];
														$rowBiayaKamarHP += $rwBiayaKamar['beban_kso'] * $rwBiayaKamar['qtyHari'];
														$bPx=$rwBiayaKamar['beban_pasien'];
														//===jika hak_kelas=kelas 2, naik ke kelas 1=====
														if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){
															$bPx=100000;
														}elseif ($rwBiayaKamar['tarip']>$rwBiayaKamar['beban_kso']){
															$bPx=$rwBiayaKamar['tarip']-$rwBiayaKamar['beban_kso'];
														}
														$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
														
														if ($bPx>0 && $rwBiayaKamar['beban_pasien']==0){
															$sql="UPDATE b_tindakan_kamar SET beban_pasien='".$bPx."' WHERE id='".$rwBiayaKamar['id']."'";
															//echo $sql."<br>";
															$rsKmr=mysql_query($sql);
														}
													}
												}
												
												if(($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) < ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien)) {
													$biaya_kso = 0;
													$biaya_pasien = 0;
												}
												else {
													if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
														$biaya_pasien = 0;
														$biaya_kso = 0;
													}else{
														$biaya_pasien = ($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) - ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien);
														$biaya_kso = 0;
													}
												}
												mysql_free_result($rsAkomodasi);
											}
										}
										else {
											$sqlASos = "select nilai,kp.id
													from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
													inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
													where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
											//echo $sqlASos."<br>";
											$rsASos = mysql_query($sqlASos);
											$res = mysql_num_rows($rsASos);
											if($res > 0) {
												$rowASos = mysql_fetch_array($rsASos);
												$biaya_kso = $rowASos['nilai'];
												$idpaket = $rowASos['id'];
												//echo "bkso=".$biaya_kso."<br>";
												if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
													$biaya_pasien = 0;
												}elseif(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
													if ($idpaket==3 || $idpaket==4 || $idpaket==5){
														$biaya_kso = 0;
														$biaya_pasien = $biayaRS;
													}elseif($biayaRS > $biaya_kso){
														$biaya_pasien = $biayaRS - $biaya_kso;
													}
												}elseif ($idpaket==3){
													$biaya_kso = 0;
													$biaya_pasien = 0;
												}elseif ($idpaket==4 || $idpaket==5){
													/*----paket II 1 hari 1 klaim-----*/
													$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan_inacbg t WHERE t.kunjungan_id='$kunjungan_id') AS t1 
			INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
			INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
			WHERE pd.kso_paket_id=$idpaket AND t1.tgl=CURRENT_DATE()";
													//echo $sqlCPaket."<br>";
													$rsCPaket=mysql_query($sqlCPaket);
													if (mysql_num_rows($rsCPaket)>0){
														$biaya_kso = 0;
														$biaya_pasien = 0;
													}
												}
												mysql_free_result($rsASos);
											}
											else {
												$sqlASos = "SELECT lp.nilai
														FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id
														where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
												//echo $sqlASos."<br>";
												$rsASos = mysql_query($sqlASos);
												//echo "numrows=".mysql_num_rows($rsASos)."<br>";
												if(mysql_num_rows($rsASos) > 0) {
													$rowASos = mysql_fetch_array($rsASos);
													$biaya_kso = $rowASos['nilai'];
													//echo "bkso=".$biaya_kso."<br>";
													if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
														$biaya_pasien = 0;
													}elseif(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
														$biaya_pasien = $biayaRS - $biaya_kso;
													}
													mysql_free_result($rsASos);
												}
												else {
													$biaya_pasien = $biayaRS;
												}
											}
										}
									}
									else {
										//non askes sosial
										$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
										$rsTdkDijamin=mysql_query($sql);
										if (mysql_num_rows($rsTdkDijamin)>0){
											$biaya_kso = 0;
											$biaya_pasien = $biayaRS;
										}else{
											if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
												$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
												$rsCek = mysql_query($sqlCek);
												$biaya_kso = $biayaRS ;
												if (mysql_num_rows($rsCek)>0){
													$rowCek = mysql_fetch_array($rsCek);
													if($biayaRS > $rowCek['tarip']) {
														$biaya_kso = $rowCek['tarip'];
														$biaya_pasien = $biayaRS - $biaya_kso;
													}
												}
												mysql_free_result($rsCek);
											}
											else {
												$biaya_kso = $biayaRS;
											}
										}
									}
								}
								else {
									//biaya di bawah jika kso pindah kelas dan bukan non kelas dan bukan Askes Sosial dan Non Inap
									if($rowCekStat['kso_id'] != 4) {
										$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
										//echo $sql."<br>";
										$rsTdkDijamin=mysql_query($sql);
										if (mysql_num_rows($rsTdkDijamin)>0){
											$biaya_kso = 0;
											$biaya_pasien = $biayaRS;
										}else{
											$sql = "SELECT lp.nilai FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id where lp.kso_id = ".$rowCekStat['kso_id']." and tk.id = '".$_GET['idTind']."'";
											//echo $sql."<br>";
											$rsLuarPaket = mysql_query($sql);
											if (mysql_num_rows($rsLuarPaket)>0){
												$rwLuarPaket=mysql_fetch_array($rsLuarPaket);
												$biaya_kso = $rwLuarPaket['nilai'];
												if ($biayaRS>$biaya_kso) $biaya_pasien = $biayaRS-$biaya_kso;
											}else{
												if (($rowCekStat['kso_id'] == 3) && ($unitId == 47 || $unitId == 63) && ($biayaRS>3050000)){
												//===========Unit OK dan kso = jamsostek======
													$biaya_kso = 3050000;
													$biaya_pasien = $biayaRS - $biaya_kso;
												}else{
													if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
														$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
														$rsCek = mysql_query($sqlCek);
														$biaya_kso = $biayaRS;
														if (mysql_num_rows($rsCek)>0){
															$rowCek = mysql_fetch_array($rsCek);
														
															if($biayaRS > $rowCek['tarip']) {
																$biaya_kso = $rowCek['tarip'];
																$biaya_pasien = $biayaRS - $biaya_kso;
															}
														}
														mysql_free_result($rsCek);
													}
													else {
														$biaya_kso = $biayaRS ;
													}
												}
											}
										}
									}
									else {
										// Jika Askes Sosial
										if ($cJenisKunj==1 && $cJenisLayAwalKunj==50){
											$biaya_pasien = $biayaRS;
										}elseif($unitId == 14 || $unitId == 22){
											$biaya_pasien = $biayaRS;
										}else{
											$sqlASos = "select nilai,kp.id
													from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
													inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
													where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
											//echo $sqlASos."<br>";
											$rsASos = mysql_query($sqlASos);
											$res = mysql_num_rows($rsASos);
											if($res > 0) {
												$rowASos = mysql_fetch_array($rsASos);
												$biaya_kso = $rowASos['nilai'];
												$idpaket = $rowASos['id'];
												if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
													$biaya_pasien = 0;
												}elseif(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
													if ($cJenisKunj==3){
														if($biayaRS > $biaya_kso){
															$biaya_pasien = $biayaRS - $biaya_kso;
														}
													}
													/*----paket IIA / IIB / IIC & RI naik kelas-----*/
													/*if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
														if($biayaRS > $biaya_kso){
															$biaya_pasien = $biayaRS - $biaya_kso;
														}
													}*/
													/*if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
														$biaya_kso = 0;
														$biaya_pasien = $biayaRS;
													}elseif($biayaRS > $biaya_kso){
														$biaya_pasien = $biayaRS - $biaya_kso;
													}*/
												}elseif (($idpaket==3) && ($cJenisKunj==3)){
													/*----paket IIA ikut akomodasi-----*/
													$biaya_kso = 0;
													$biaya_pasien = 0;
												}elseif ($idpaket==3 || $idpaket==4 || $idpaket==5){
													/*----paket IIA / IIB / IIC 1 hari 1 klaim-----*/
													$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan_inacbg t WHERE t.kunjungan_id='$kunjungan_id') AS t1 
			INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
			INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
			WHERE pd.kso_paket_id=$idpaket AND t1.tgl=CURRENT_DATE()";
													//echo $sqlCPaket."<br>";
													$rsCPaket=mysql_query($sqlCPaket);
													if (mysql_num_rows($rsCPaket)>0){
														$biaya_kso = 0;
														$biaya_pasien = 0;
													}
												}
												mysql_free_result($rsASos);
											}
											else {
												$sqlASos = "SELECT lp.nilai
													FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id
													where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
												//echo $sqlASos."<br>";
												$rsASos = mysql_query($sqlASos);
												if (mysql_num_rows($rsASos) > 0) {
													$rowASos = mysql_fetch_array($rsASos);
													$biaya_kso = $rowASos['nilai'];
													if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
														$biaya_pasien = 0;
													}elseif (($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
														$biaya_pasien = $biayaRS - $biaya_kso;
													}
													mysql_free_result($rsASos);
												}
												else {
													if ($_GET['kelas_id']==2 && $_REQUEST['ksoKelasId']==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
														$biaya_pasien = 0;
													}else{
														$biaya_pasien = $biayaRS;
													}
												}
											}
										}
									}
								}
							//}
						}
						mysql_free_result($rsCekStat);
	
						$sqlTind="insert into b_tindakan_inacbg (ms_tindakan_id,ms_tindakan_unit_id,jenis_kunjungan,pelayanan_id,kunjungan_id,kunjungan_kelas_id,kso_id,kso_kelas_id,tgl,ket,qty,biaya,biaya_kso,biaya_pasien,tgl_act,user_act,user_id,type_dokter,unit_act) values('".$_REQUEST['idTind']."','".$_REQUEST['unitId']."','".$cJenisKunj."','".$pelayanan_id."','".$kunjungan_id."','".$_REQUEST['kunjungan_kelas_id']."','".$_REQUEST['ksoId']."','".$_REQUEST['ksoKelasId']."',CURDATE(),'".$_REQUEST['ket']."',".$_REQUEST['qty'].",'".$biayaRS."','$biaya_kso','$biaya_pasien',now(),$userId,".$_REQUEST['idDok'].",'".$isDokPengganti."','".$_GET['unit_pelaksana']."')";
						//echo $sqlTind."<br/>";
						mysql_query($sqlTind);
						$id_tindakan_radiologi = mysql_insert_id();
						$getIdTind="select max(id) as id from b_tindakan_inacbg where pelayanan_id='$pelayanan_id' and kunjungan_id='$kunjungan_id' and user_act=$userId";
						//echo $getIdTind."<br/>";
						$rsIdTind=mysql_query($getIdTind);
						$rwIdTind=mysql_fetch_array($rsIdTind);
	
						$sqlCek="SELECT nama FROM b_ms_reference b where stref=22";
						$rsCek=mysql_query($sqlCek);
						$rwCek=mysql_fetch_array($rsCek);
	
						if($rwCek['nama']=='1') {
							$tarif=",b.tarip_prosen*".($biayaRS/100);
						}
						else {
							$tarif=",b.tarip";
						}
						$sqlKomponen="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind['id']."',k.id,k.nama
								$tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b
							inner join b_ms_komponen k on b.ms_komponen_id=k.id
							where b.ms_tindakan_kelas_id='".$_REQUEST['idTind']."'";
						//echo $sqlKomponen."<br/>";
						$rsKomponen=mysql_query($sqlKomponen);
	
						$sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."' and dilayani=0";
						$rsDilayani=mysql_query($sqlDilayani);
					
						if(isset($_REQUEST['anastesi']) && $_REQUEST['anastesi'] != ''){
							$anastesi = explode(',',$_REQUEST['anastesi']);
							for($i=0; $i<count($anastesi); $i++){
							   $sql_an = "insert into b_tindakan_dokter_anastesi (tindakan_id,dokter_id,user_act)
									 values ('".$rwIdTind['id']."','".$anastesi[$i]."','$userId')";
							   mysql_query($sql_an);
							}
						}
						$statusProses='Fine';
						//forAkun('add',$biayaRS.'|'.$biaya_kso.'|'.$biaya_pasien,'tind',$unitId,$rwIdTind['id'].'.'.$unitId,$idParent,$unitId,$_REQUEST['ksoId']);
					}
					mysql_free_result($rsCekDokter);
				}
                break;
            case 'btnSimpanDiag':
				/*-----Simpan Diagnosa-----*/
                $cekKasus="SELECT k.pasien_id,d.ms_diagnosa_id FROM b_diagnosa d
						inner join b_kunjungan k on k.id=d.kunjungan_id
						where k.pasien_id='".$_REQUEST['pasienId']."' and d.ms_diagnosa_id='".$_REQUEST['idDiag']."'";
                $rsKasus=mysql_query($cekKasus);
                if(mysql_num_rows($rsKasus)>0) {
                    $kasusBaru='0';
                }
                else {
                    $kasusBaru='1';
                }
				if($_REQUEST['isManual']=='1'){
					$sqlTambah="insert into b_diagnosa (ms_diagnosa_id,diagnosa_manual,kunjungan_id,pelayanan_id,tgl,primer,kasus_baru,akhir,tgl_act,user_act,user_id,type_dokter) values('0','".$_REQUEST['diagnosa']."','".$kunjungan_id."','".$pelayanan_id."',CURDATE(),'".$_REQUEST['isPrimer']."','".$kasusBaru."','".$_REQUEST['isAkhir']."',now(),$userId,".$_REQUEST['idDok'].",$isDokPengganti)";
				}
				else{
                	$sqlTambah="insert into b_diagnosa (ms_diagnosa_id,kunjungan_id,pelayanan_id,tgl,primer,kasus_baru,akhir,tgl_act,user_act,user_id,type_dokter) values('".$_REQUEST['idDiag']."','".$kunjungan_id."','".$pelayanan_id."',CURDATE(),'".$_REQUEST['isPrimer']."','".$kasusBaru."','".$_REQUEST['isAkhir']."',now(),$userId,".$_REQUEST['idDok'].",$isDokPengganti)";
				}
                //echo $sqlTambah."<br/>";
                $rs=mysql_query($sqlTambah);
                $statusProses='Fine';
                $sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."' and dilayani=0";
                $rsDilayani=mysql_query($sqlDilayani);
                break;
            case 'btnSimpanResep':
				/*-----Simpan Resep-----*/
				$sqlPas = "SELECT $dbbilling.b_ms_pasien.id AS pasien_id, $dbbilling.b_ms_pasien.nama,
				$dbbilling.b_ms_pasien.no_rm, $dbbilling.b_ms_pasien.alamat,
				$dbbilling.b_pelayanan.kso_id,$dbbilling.b_ms_kso.kode, $dbbilling.b_ms_kso.nama AS ksonama, $dbapotek.a_mitra.KEPEMILIKAN_ID
				FROM $dbbilling.b_ms_pasien
				INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.pasien_id = $dbbilling.b_ms_pasien.id
				LEFT JOIN $dbbilling.b_ms_kso ON $dbbilling.b_ms_kso.id = $dbbilling.b_pelayanan.kso_id
				LEFT JOIN $dbapotek.a_mitra ON $dbapotek.a_mitra.kso_id_billing = $dbbilling.b_ms_kso.id
				WHERE $dbbilling.b_ms_pasien.id = '".$_REQUEST['idPas']."' AND $dbbilling.b_pelayanan.id='".$_REQUEST['pelayanan_id']."'";
				//echo $sqlPas."<br>";
				$rsPas = mysql_query($sqlPas);
				$rwPas = mysql_fetch_array($rsPas);
				
				if($_REQUEST['resep_baru']=='1'){
					$sql="SELECT CURDATE() tgl_resep";
					$rs=mysql_query($sql);
					$rw=mysql_fetch_array($rs);
					$tgl_resep=$rw["tgl_resep"];
					//$sNo="SELECT IFNULL(MAX(no_resep),0) no_resep FROM b_resep WHERE tgl=CURDATE()";
					$sNo="SELECT IFNULL(MAX(r.no_resep),0) no_resep FROM b_resep r INNER JOIN b_pelayanan p ON r.id_pelayanan=p.id WHERE p.unit_id=(SELECT unit_id FROM b_pelayanan WHERE id='".$_REQUEST['pelayanan_id']."') AND r.tgl=CURDATE()";
					//echo $sNo."<br>";
					$qNo=mysql_query($sNo);
					$rNo=mysql_fetch_array($qNo);
					
					$dtmp=$rNo[0]+1;
					$ctmp=$dtmp;
					for ($i=0;$i<(5-strlen($dtmp));$i++) 
						$ctmp="0".$ctmp;
				
					$no_resep=$ctmp;
				}
				
				$caraBayar=2;
				//$caraBayar=1;
				//if ($_REQUEST['ksoId']!="1") $caraBayar=2;
				
                $sqlTambah="INSERT INTO b_resep (apotek_id,id_pelayanan,obat_id,kepemilikan_id,kso_id,tgl,no_resep,cara_bayar,kunjungan_id,pasien_id,no_rm,nama_pasien,alamat,qty,qty_bahan,satuan,racikan,KET_DOSIS,dokter_id,dokter_nama,type_dokter) values('".$_REQUEST['apotek']."','".$_GET['pelayanan_id']."','".$_REQUEST['idObat']."','".$rwPas['KEPEMILIKAN_ID']."','".$_REQUEST['ksoId']."','$tgl_resep','".$no_resep."','$caraBayar','".$_REQUEST['kunjungan_id']."','".$rwPas['pasien_id']."','".$rwPas['no_rm']."','".$rwPas['nama']."','".$rwPas['alamat']."','".$_REQUEST['jumlah']."','".$_REQUEST['jmlBahan']."','".$_REQUEST['satRacikan']."','".$_REQUEST['isracikan']."','".$_REQUEST['txtDosis']."','".$_REQUEST['dokter']."','".$rwDok['nama']."','$isDokPengganti')";
                //echo $sqlTambah."<br/>";
                $rs=mysql_query($sqlTambah);
				if (mysql_errno()==0){
					$dt_temp = $no_resep;
					$sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."'";
					$rsDilayani=mysql_query($sqlDilayani);
					$statusProses='Fine';
                }else{
                    $statusProses='Error';
                }
                break;
            case 'btnSimpanRujukUnit':
				/*-----Inap=1 --> MRS, Inap=0 --> Konsul-----*/
				if($_REQUEST['isInap']=='1'){
					$sqlCek = "SELECT p.id FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id 
WHERE p.pasien_id='".$_GET['pasienId']."' AND p.unit_id='".$_GET['tmpLay']."' AND k.pulang=0";
				}else{
					$sqlCek = "SELECT p.id FROM b_pelayanan p INNER JOIN b_ms_unit u ON p.unit_id = u.id 
WHERE p.pasien_id='".$_GET['pasienId']."' AND p.unit_id='".$_GET['tmpLay']."' AND p.tgl=CURDATE() AND u.penunjang=0 AND u.kategori!=5";
				}
				$rsCek = mysql_query($sqlCek);
				$numCek = mysql_num_rows($rsCek);
				if($numCek == 0){
					 /*$kso_id = $_REQUEST['ksoId'];
					 if($kso_id == '' || $kso_id == '0'){*/
						$sql = "select kso_id from b_kunjungan where id = '$kunjungan_id'";
						$rs = mysql_query($sql);
						$row = mysql_fetch_array($rs);
						$kso_id = $row['kso_id'];
					 //}
					
					$pl_id = 3;
					$plKelas=$_REQUEST['kelas'];
					if($_REQUEST['isInap']!='1'){
						$sql = "SELECT * FROM b_pelayanan WHERE id='".$_REQUEST['pelayanan_id']."'";
						$rs = mysql_query($sql);
						$row = mysql_fetch_array($rs);
						$pl_id = $row['jenis_kunjungan'];
						if ($plKelas=="" || $plKelas=="0" || $plKelas=="undefined"){
							if ($_REQUEST['jnsLay']=="1"){
								$plKelas="1";
							}else{
								$plKelas=$row['kelas_id'];
							}
						}
					}
			 
                    $sqlTambah1="insert into b_pelayanan(no_antrian,jenis_kunjungan,pasien_id,kunjungan_id,jenis_layanan,unit_id,kso_id,unit_id_asal,kelas_id,ket,dokter_id,type_dokter,tgl,tgl_act,user_act) values((fGetMaxNo_Antrian(".$_REQUEST['tmpLay'].",CURDATE())),'".$pl_id."','".$_REQUEST['pasienId']."','".$kunjungan_id."','".$_REQUEST['jnsLay']."','".$_REQUEST['tmpLay']."','$kso_id','".$_REQUEST['unitAsal']."','".$plKelas."','".$_REQUEST['ket']."','".$_REQUEST['idDok']."','$isDokPengganti',CURDATE(),now(),$userId)";
					//echo $sqlTambah1."<br>";
                    $cekKey = mysql_query($sqlTambah1);
					$idPelKey = mysql_insert_id();
					if($cekKey){
						foreach($keyTindLab as $val){
						//echo $val;
							$sql = "INSERT INTO b_tindakan_lab (pemeriksaan_id, pelayanan_id, kunjungan_id, tgl_act, user_act) 
									VALUES ('{$val}', '{$idPelKey}', '{$kunjungan_id}', NOW(), '{$userId}')";
							$hasil = mysql_query($sql);
						}
					}
                    $tgljam='now()';

                    $newPel="select max(id) as idpel from b_pelayanan where kunjungan_id='".$kunjungan_id."' and user_act='".$userId."'";
                    $rsNewPel=mysql_query($newPel);
                    $rwNewPel=mysql_fetch_array($rsNewPel);
		    		/*isInap = 1 adalah MRS | isInap = 0 adalah konsul*/
                    if($_REQUEST['isInap']=='1') {
						$sqlCekInap="SELECT mu.inap FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.id=".$rwNewPel["idpel"];
						$rsCekIsInap=mysql_query($sqlCekInap);
						$rwCekIsInap=mysql_fetch_array($rsCekIsInap);
						if ($rwCekIsInap["inap"]==1){
							$getKamar="select kode,nama from b_ms_kamar where id='".$_REQUEST['kamar']."'";
							//echo $getKamar."<br>";
							$rsKamar=mysql_query($getKamar);
							$rwKamar=mysql_fetch_array($rsKamar);
	
							$biaya = $_GET['tarip'];
							$kelasnya = $_GET['kelas'];
	
							$beban_kso = 0;
							$beban_pasien = 0;
	
							$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
							$rsCekStat = mysql_query($sqlCekStat);
							$rowCekStat = mysql_fetch_array($rsCekStat);
							//echo $rowCekStat['kso_id']."<br>";
							$cStatPas=$rowCekStat['kso_id'];
							if($rowCekStat['kso_id'] == 1) {
								//$beban_pasien = $biaya;
								$beban_kso = $biaya;
							}else if ($rowCekStat['kso_id'] == 2){
								$beban_pasien = $biaya;
							}
							else {
								$beban_kso = $biaya;
	
								if($_GET['jnsLay'] != '94' && $_REQUEST['tmpLay']!='48' && $_REQUEST['tmpLay']!='112') {
									$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
									$rsHp = mysql_query($sqlHp);
									if(mysql_num_rows($rsHp) > 0) {
										$rowHp = mysql_fetch_array($rsHp);
										$beban_kso = $rowHp['jaminan'];
									}else{
										$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$_REQUEST['tmpLay']."' AND kelas_id = '".$rowCekStat['kso_kelas_id']."'";
										$rsBKso = mysql_query($sqlBKso);
										if (mysql_num_rows($rsBKso) > 0){
											$rowBKso = mysql_fetch_array($rsBKso);
											if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
												$beban_kso = $rowBKso['tarip'];
											}
										}else{
											$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$rowCekStat['kso_kelas_id']."'";
											$rsBKso = mysql_query($sqlBKso);
											if (mysql_num_rows($rsBKso) > 0){
												$rowBKso = mysql_fetch_array($rsBKso);
												if ($rowCekStat['kso_id']!=4 && $rowBKso['tarip']<$biaya){
													$beban_kso = $rowBKso['tarip'];
												}
											}
										}
										mysql_free_result($rsBKso);
									}
									//echo "kso=".$rowCekStat['kso_id'].",hak_kelas=".$rowCekStat['kso_kelas_id'].",kelas=".$kelasnya;
									if (($rowCekStat['kso_id']==4) && ($rowCekStat['kso_kelas_id']==3) && ($kelasnya==2)){
										$beban_pasien = 100000;
									}elseif(($biaya > $beban_kso) && ($rowCekStat['kso_kelas_id'] != $kelasnya)) {
										$beban_pasien = $biaya-$beban_kso;
									}
								}
								else {
									$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '10' and b_ms_kso_id = '".$rowCekStat['kso_id']."'";
									$rsHp = mysql_query($sqlHp);
									if(mysql_num_rows($rsHp) > 0) {
										$rowHp = mysql_fetch_array($rsHp);
										$beban_kso = $rowHp['jaminan'];
									}
								}
							}
	
							$sqlTambah="insert into b_tindakan_kamar (pelayanan_id,unit_id_asal,kso_id,tgl_in,kamar_id,kode,nama,tarip,beban_kso,beban_pasien,kelas_id,aktif)
						values('".$rwNewPel['idpel']."','".$_REQUEST['unitAsal']."','$cStatPas',".$tgljam.",'".$_REQUEST['kamar']."','".$rwKamar['kode']."','".$rwKamar['nama']."','".$biaya."','$beban_kso','$beban_pasien','$kelasnya','0')";
	
							//echo $sqlTambah."<br/>";
							$rs=mysql_query($sqlTambah);
						}
                    }
                    else {
                        //mengambil data tindakan_kelas_id, tarip, tarip_askes untuk konsul antar poli (2363)
                        $sqlTindKonsul = "SELECT tu.ms_tindakan_kelas_id,tarip,tarip_askes
                                    FROM b_ms_tindakan_unit tu inner join b_ms_tindakan_kelas tk on tu.ms_tindakan_kelas_id = tk.id
                                    inner join b_ms_tindakan mt on tk.ms_tindakan_id = mt.id
                                    where mt.id = 2363 and tu.ms_unit_id = '".$_REQUEST['tmpLay']."' and tk.ms_kelas_id = '".$_REQUEST['kelas']."'";
						//echo $sqlTindKonsul."<br>";
                        $rsTindKonsul = mysql_query($sqlTindKonsul);
                        $res = mysql_num_rows($rsTindKonsul);
                        if($res != 0 && $res != '' && isset($res)) {
                            $rwTindKonsul = mysql_fetch_array($rsTindKonsul);

                            $biaya_pasien = 0;
                            $biaya_kso = 0;

                            $sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
							//echo $sqlCekStat."<br>";
                            $rsCekStat = mysql_query($sqlCekStat);
                            $rowCekStat = mysql_fetch_array($rsCekStat);
                            if($rowCekStat['kso_id'] == 1) {
                                //$biaya_pasien = $rwTindKonsul['tarip'];
								$biaya_kso = $rwTindKonsul['tarip'];
                            }
                            else {
                                $biaya_kso = $rwTindKonsul['tarip'];
								if ($rowCekStat['kso_id']==4){
									if ($_REQUEST['tmpLay']==14 && $_REQUEST['tmpLay']==22){
										$biaya_pasien = $rwTindKonsul['tarip'];
										$biaya_kso = 0;
									}else{
										$sqlASos = "select nilai,kp.id from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id where tk.id = '".$rwTindKonsul['ms_tindakan_kelas_id']."' and kp.kso_id = 4";
										//echo $sqlASos."<br>";
										$rsASos = mysql_query($sqlASos);
										if (mysql_num_rows($rsASos)>0){
											$rwASos=mysql_fetch_array($rsASos);
											$biaya_kso = $rwASos['nilai'];
										}
									}
								}
                            }

                            $sqlBTin = "insert into b_tindakan (ms_tindakan_kelas_id,ms_tindakan_unit_id,jenis_kunjungan,pelayanan_id,kunjungan_id,kunjungan_kelas_id,kso_id,kso_kelas_id,tgl,ket,biaya,biaya_pasien,biaya_kso,tgl_act,user_act,user_id,unit_act) values('".$rwTindKonsul['ms_tindakan_kelas_id']."','".$_REQUEST['tmpLay']."','".$pl_id."','".$rwNewPel['idpel']."','".$kunjungan_id."','".$_REQUEST['kunjungan_kelas_id']."','".$_REQUEST['ksoId']."','".$_REQUEST['ksoKelasId']."',CURDATE(),'".$_REQUEST['ket']."','".$rwTindKonsul['tarip']."','$biaya_pasien','".$biaya_kso."',now(),'$userId',0,'".$_REQUEST['unitAsal']."')";
							//echo $sqlBTin."<br/>";
                            mysql_query($sqlBTin);
                            //".$_REQUEST['idDok']."

                            $getIdTind="select max(id) as id from b_tindakan where pelayanan_id='".$rwNewPel['idpel']."' and kunjungan_id='$kunjungan_id' and user_act='$userId'";
                            //echo $getIdTind."<br/>";
                            $rsIdTind=mysql_query($getIdTind);
                            $rwIdTind=mysql_fetch_array($rsIdTind);


                            $sqlCek="SELECT nama FROM b_ms_reference b where stref=22";
                            $rsCek=mysql_query($sqlCek);
                            $rwCek=mysql_fetch_array($rsCek);
			    			mysql_free_result($rsCek);
                            if($rwCek['nama']=='1') {
                                $tarif=",b.tarip_prosen*".($rwTindKonsul['tarip']/100);
                            }
                            else {
                                $tarif=",b.tarip";
                            }
                            $sqlKomponen="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$rwIdTind['id']."',k.id,k.nama $tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b
						inner join b_ms_komponen k on b.ms_komponen_id=k.id
						where b.ms_tindakan_kelas_id='".$rwTindKonsul['ms_tindakan_kelas_id']."'";
                            //echo $sqlKomponen."<br/>";
                            $rsKomponen=mysql_query($sqlKomponen);
                        }
                    }
					
                    $sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."'";
                    $rsDilayani=mysql_query($sqlDilayani);
                }
                else {
                    $statusProses='Error';
                }
                break;
            case 'btnSimpanRujukRS':
				/*-----Rujuk RS-----*/
                $sqlCek = "select id from b_pasien_keluar where pelayanan_id='$pelayanan_id'";
                $rs = mysql_query($sqlCek);
                if(mysql_num_rows($rs) <= 0) {
					if($_REQUEST['isManual']=="true") {
						$tgljam=" '".tglSQL($_REQUEST['tglKrs'])." ".$_REQUEST['jamKrs']."' ";
					}
					else {
						$tgljam=' now() ';
					}
                    $sqlTambah="insert into b_pasien_keluar (kunjungan_id,pelayanan_id,cara_keluar,keadaan_keluar,kasus,emergency,kondisi,rs_id,ket,dokter_id,tgl_act,user_act)
                                    values('".$kunjungan_id."','".$pelayanan_id."','".$_REQUEST['caraKeluar']."','".$_REQUEST['keadaanKeluar']."','".$_REQUEST['kasus']."','".$_REQUEST['emergency']."','".$_REQUEST['kondisi']."','".$_REQUEST['idRS']."','".$_REQUEST['ket']."','".$_REQUEST['idDok']."',$tgljam,$userId)";
                    //echo $sqlTambah."<br/>";
                    $rs=mysql_query($sqlTambah);
		    
					/*$sqlCek = "SELECT inap FROM b_pelayanan p INNER JOIN b_ms_unit u ON p.unit_id = u.id WHERE p.id = '$pelayanan_id'";
					$rsCek = mysql_query($sqlCek);
					$rowCek = mysql_fetch_array($rsCek);
					
					if($rowCek['inap'] == 1){
						$sqlKunj = "update b_tindakan_kamar set tgl_out = $tgljam where pelayanan_id = '$pelayanan_id'";
						$rsKunj = mysql_query($sqlKunj);
					}
		    		mysql_free_result($rsCek);*/

                    $sqlDilayani="update b_pelayanan set dilayani=1,tgl_krs=$tgljam where id='".$pelayanan_id."'";
                    $rsDilayani=mysql_query($sqlDilayani);
		    
					/*$sqlSel = "select tgl_pulang,$tgljam as tgl_home from b_kunjungan where id = '$kunjungan_id'";
					$rsSel = mysql_query($sqlSel);
					$rowSel = mysql_fetch_array($rsSel);
					if(!isset($rowSel['tgl_pulang']) || $rowSel['tgl_pulang'] == '' || $rowSel['tgl_pulang'] < $rowSel['tgl_home']){
						$sqlSel = "update b_kunjungan set tgl_pulang = '".$rowSel['tgl_home']."' where id = '$kunjungan_id'";
						mysql_query($sqlSel);
					}*/
                }
                else {
                    $statusProses = 'Error';
                }
				mysql_free_result($rs);
                break;
	    case 'btnPasienPulang':
			/*-----Pasien Pulang-----*/
			$sqlCek = "SELECT inap FROM b_pelayanan p INNER JOIN b_ms_unit u ON p.unit_id = u.id WHERE p.id = '$pelayanan_id'";
			$rsCek = mysql_query($sqlCek);
			$rowCek = mysql_fetch_array($rsCek);
			
			$tglPul = "now()";
			if($rowCek['inap'] == 1){
				/*$sqlCek = "SELECT p.tgl_krs FROM b_pelayanan p WHERE p.id = '$pelayanan_id' and p.tgl_krs is not null order by p.tgl_krs desc limit 1";
				$rsCek = mysql_query($sqlCek);
				if(mysql_num_rows($rsCek) > 0){
					$rowCek = mysql_fetch_array($rsCek);
					$tglPul = "'".$rowCek['tgl_krs']."'";
				}*/
				
				$sqlKunj = "UPDATE b_tindakan_kamar SET tgl_out=$tglPul WHERE pelayanan_id='$pelayanan_id' AND tgl_out IS NULL";
				$rsKunj = mysql_query($sqlKunj);
				
				$sqlKunj = "update b_kunjungan set tgl_pulang = $tglPul, pulang = 1 where id = '$kunjungan_id'";
				$rsKunj = mysql_query($sqlKunj);
			}
			mysql_free_result($rsCek);
			echo 'Berhasil dipulangkan';
			return;
			break;
		case 'btnSimpanKamar':
			/*-----Pindah Kamar-----*/
			$cekUnitSama="select * from b_pelayanan p inner join b_tindakan_kamar tk on p.id = tk.pelayanan_id where p.kunjungan_id='".$kunjungan_id."' and p.unit_id='".$_REQUEST['tmpLayKamar']."' and tk.tgl_out is null";
			//echo $cekUnitSama."<br>";
			$rsUnitSama=mysql_query($cekUnitSama);
			$jmlKamarSama=mysql_num_rows($rsUnitSama);
			if(($jmlKamarSama<=0) || ($_REQUEST['tmpLayKamar'] == $_REQUEST['unitAsal'])) {
				if($_REQUEST['isManual']=="true") {
					$tgljam="'".tglSQL($_REQUEST['tglMasuk'])." ".$_REQUEST['jamMasuk']."'";
				}
				else {
					$tgljam='now() ';
				}
    
				$biaya = $_GET['tarip'];
				$kelasnya = $_GET['kelasId'];
				$caktif=0;
				
				$getKamar="select kode,nama from b_ms_kamar where id='".$_REQUEST['kamar_id']."'";
				$rsKamar=mysql_query($getKamar);
				$rwKamar=mysql_fetch_array($rsKamar);
		
				$sql = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
				$rs = mysql_query($sql);
				$row = mysql_fetch_array($rs);
				$kso_id = $row['kso_id'];
				$HakKlsPx = $row['kso_kelas_id'];
				
				//kelas kamar tujuan = kelas kamar asal dan unit asal = unit tujuan, maka hanya update data kamar di b_tindakan_kamar
				//(pindah kamar tidak pindah unit,tidak ganti kelas)
				if($_REQUEST['tmpLayKamar'] == $_REQUEST['unitAsal']){
					if ($_GET['kelas_lama'] == $kelasnya){
						$sql = "update b_tindakan_kamar set kamar_id = '".$_GET['kamar_id']."', nama = '".$rwKamar['nama']."' where pelayanan_id='".$pelayanan_id."' and tgl_out is null";
						mysql_query($sql);
					}else{
						$beban_kso = 0;
						$beban_pasien = 0;
				
						if($kso_id == 1) {
							//$beban_pasien = $biaya;
							$beban_kso = $biaya;
						}
						else {
							$beban_kso = $biaya;
							if($_GET['jnsLayKamar'] != '94' && $_REQUEST['tmpLayKamar']!='48' && $_REQUEST['tmpLayKamar']!='112') {
								$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$HakKlsPx."' and b_ms_kso_id = '".$kso_id."'";
								$rsHp = mysql_query($sqlHp);
								if(mysql_num_rows($rsHp) > 0) {
									$rowHp = mysql_fetch_array($rsHp);
									$beban_kso = $rowHp['jaminan'];
									mysql_free_result($rsHp);
								}else{
									$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$_REQUEST['tmpLayKamar']."' AND kelas_id = '".$HakKlsPx."'";
									$rsBKso = mysql_query($sqlBKso);
									if (mysql_num_rows($rsBKso) > 0){
										$rowBKso = mysql_fetch_array($rsBKso);
										$beban_kso = $rowBKso['tarip'];
									}else{
										$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$HakKlsPx."'";
										$rsBKso = mysql_query($sqlBKso);
										if (mysql_num_rows($rsBKso) > 0){
											$rowBKso = mysql_fetch_array($rsBKso);
											$beban_kso = $rowBKso['tarip'];
										}
									}
									mysql_free_result($rsBKso);
								}
								
								if (($kso_id==4) && ($HakKlsPx==3) && ($kelasnya==2)){
									$beban_pasien = 100000;
								}else if(($biaya > $beban_kso) && ($HakKlsPx != $kelasnya)) {
									$beban_pasien = $biaya-$beban_kso;
								}
							}else{
								$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '$kelasnya' and b_ms_kso_id = '".$kso_id."'";
								$rsHp = mysql_query($sqlHp);
								if(mysql_num_rows($rsHp) > 0) {
									$rowHp = mysql_fetch_array($rsHp);
									$beban_kso = $rowHp['jaminan'];
									mysql_free_result($rsHp);
								}
							}
						}

						$sql = "SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='".$pelayanan_id."' AND DATEDIFF(".$tgljam.",tgl_in)=0 AND tgl_out IS NULL";
						$rs = mysql_query($sql);
						if (mysql_num_rows($rs) > 0){
							$sql = "update b_tindakan_kamar set kamar_id = '".$_GET['kamar_id']."', nama = '".$rwKamar['nama']."',tarip='".$biaya."',beban_kso='".$beban_kso."',beban_pasien='".$beban_pasien."',kelas_id='".$kelasnya."' where pelayanan_id='".$pelayanan_id."' and tgl_out is null and aktif=1";
							mysql_query($sql);
						}else{
							$sql = "update b_tindakan_kamar set tgl_out=".$tgljam." where pelayanan_id='".$pelayanan_id."' and tgl_out is null and aktif=1";
							mysql_query($sql);
						
							$sql = "insert into b_tindakan_kamar (pelayanan_id,unit_id_asal,kso_id,tgl_in,kamar_id,kode,nama,tarip,beban_kso,beban_pasien,kelas_id,aktif) values('".$pelayanan_id."','".$_REQUEST['unitAsal']."','$kso_id',".$tgljam.",'".$_REQUEST['kamar_id']."','".$rwKamar['kode']."','".$rwKamar['nama']."','".$biaya."','".$beban_kso."','".$beban_pasien."','$kelasnya','1')";
							mysql_query($sql);
						}
					}
				}
				else{
					//data inap di kamar sebelumnya ditutup jika jenis layanan tujuan bukan ROI / IPIT --> kmr lama ttp jalan, blm difungsikan
					$sqlParentAsal="SELECT * FROM b_ms_unit WHERE id='".$_REQUEST['unitAsal']."'";
					$rsParentAsal=mysql_query($sqlParentAsal);
					$rwParentAsal=mysql_fetch_array($rsParentAsal);
					$parentAsal=$rwParentAsal["parent_id"];
					$cStatOut=1;
					if (($parentAsal==94 && $_GET['jnsLayKamar']!=94) || $_REQUEST['unitAsal']=='48' || $_REQUEST['unitAsal']=='112') $cStatOut=0;
					//if($_GET['tmpLayKamar'] != '112' && $_GET['jnsLayKamar'] != '94'){
						$updt="update b_tindakan_kamar set tgl_out=".$tgljam.", status_out = $cStatOut where pelayanan_id='".$pelayanan_id."' and tgl_out is null and aktif=1";
						//echo $updt."<br/>";
						mysql_query($updt);
					//}
			
					//----Cek apakah sdh pernah di unit tujuan? jika sdh cukup insert kamar aja, tdk perlu insert pelayanan
					$cek="SELECT l.id as idpel FROM b_pelayanan l WHERE l.kunjungan_id='".$kunjungan_id."' AND l.unit_id='".$_REQUEST['tmpLayKamar']."'";
					//echo $cek."<br/>";
					$rsCek=mysql_query($cek);
					//added by wsw36
					$move = true;
					$cekOut = true;
					//finished
					if(mysql_num_rows($rsCek)>0){
						//by wsw36
						/*if($_REQUEST['tmpLayKamar'] == $_REQUEST['unitAsal']){
							$move = false;
						}*/
						//finished
						$caktif=1;
						$rwNewPel = mysql_fetch_array($rsCek);
						//by wsw36
						/*$sqlCekKam = "select tgl_out from b_tindakan_kamar where pelayanan_id = '".$rwNewPel['idpel']."'";
						$rsCekKam = mysql_query($sqlCekKam);
						$rowCekKam = mysql_fetch_array($rsCekKam);
						if($rowCekKam['tgl_out'] == null || $rowCekKam['tgl_out'] == ''){
							//kalo masuk sini berarti pasien di kamar sebelumnya tidak terhitung keluar
							$cekOut = false;
						}
			    		mysql_free_result($rsCekKam);*/
						//finished
						$sqlDilayani="update b_pelayanan set dilayani=1, tgl_krs = null where id='".$rwNewPel['idpel']."'";
						$rsDilayani=mysql_query($sqlDilayani);
					}else{
						/*$sql = "SELECT * FROM b_pelayanan WHERE id='".$_REQUEST['pelayanan_id']."'";
						$rs = mysql_query($sql);
						$row = mysql_fetch_array($rs);
						$jenisKunj = $row['jenis_kunjungan'];*/
						$jenisKunj = 3;
						
			    		$sqlTambah1="insert into b_pelayanan(no_antrian,jenis_kunjungan,pasien_id,kunjungan_id,jenis_layanan,unit_id,kso_id,unit_id_asal,kelas_id,dokter_id,tgl,tgl_act,user_act) values((fGetMaxNo_Antrian(".$_REQUEST['tmpLayKamar'].",CURDATE())),'".$jenisKunj."','".$_REQUEST['pasienId']."','".$kunjungan_id."','".$_REQUEST['jnsLayKamar']."','".$_REQUEST['tmpLayKamar']."','$kso_id','".$_REQUEST['unitAsal']."','".$_REQUEST['kelasId']."','0',CURDATE(),now(),$userId)";
			    		mysql_query($sqlTambah1);
			    		
						$newPel="select max(id) as idpel from b_pelayanan where user_act='".$userId."' and pasien_id = '".$_REQUEST['pasienId']."' and kunjungan_id='".$kunjungan_id."'";
						$rsNewPel=mysql_query($newPel);
						$rwNewPel=mysql_fetch_array($rsNewPel);
					}
					$beban_kso = 0;
					$beban_pasien = 0;
			
					/*$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
					$rsCekStat = mysql_query($sqlCekStat);
					$rowCekStat = mysql_fetch_array($rsCekStat);
    
					if($rowCekStat['kso_id'] == 1) {*/
					if($kso_id == 1) {
						//$beban_pasien = $biaya;
						$beban_kso = $biaya;
					}
					else {
						$beban_kso = $biaya;
    					
			    		if($_GET['jnsLayKamar'] != '94' && $_REQUEST['tmpLayKamar']!='48' && $_REQUEST['tmpLayKamar']!='112') {
							$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b WHERE b_ms_kelas_id = '".$HakKlsPx."' AND b_ms_kso_id = '".$kso_id."'";
							//echo $sqlHp."<br/>";
							$rsHp = mysql_query($sqlHp);
							if(mysql_num_rows($rsHp) > 0) {
								$rowHp = mysql_fetch_array($rsHp);
								$beban_kso = $rowHp['jaminan'];
								mysql_free_result($rsHp);
							}else{
								if ($HakKlsPx != $kelasnya){
									$sqlBKso = "select DISTINCT tarip from b_ms_kamar_tarip WHERE unit_id = '".$_REQUEST['tmpLayKamar']."' AND kelas_id = '".$HakKlsPx."'";
									//echo $sqlBKso."<br>";
									$rsBKso = mysql_query($sqlBKso);
									if (mysql_num_rows($rsBKso) > 0){
										$rowBKso = mysql_fetch_array($rsBKso);
										if ($beban_kso>$rowBKso['tarip']){
											$beban_kso = $rowBKso['tarip'];
										}
									}else{
										$sqlBKso = "SELECT DISTINCT tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id<>68 AND mkt.kelas_id = '".$HakKlsPx."'";
										//echo $sqlBKso."<br>";
										$rsBKso = mysql_query($sqlBKso);
										if (mysql_num_rows($rsBKso) > 0){
											$rowBKso = mysql_fetch_array($rsBKso);
											if ($beban_kso>$rowBKso['tarip']){
												$beban_kso = $rowBKso['tarip'];
											}
										}
									}
									mysql_free_result($rsBKso);
								}
							}
							
							if (($rowCekStat['kso_id']==4) && ($rowCekStat['kso_kelas_id']==3) && ($kelasnya==2)){
									$beban_pasien = 100000;
							}elseif(($biaya > $beban_kso) && ($HakKlsPx != $kelasnya)) {
								$beban_pasien = $biaya-$beban_kso;
							}
			    		}
			    		else {
							$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '$kelasnya' and b_ms_kso_id = '".$kso_id."'";
							//echo $sqlHp."<br>";
							$rsHp = mysql_query($sqlHp);
							if(mysql_num_rows($rsHp) > 0) {
								$rowHp = mysql_fetch_array($rsHp);
								$beban_kso = $rowHp['jaminan'];
								mysql_free_result($rsHp);
							}
						}
					}
    
					$sqlTambah="insert into b_tindakan_kamar (pelayanan_id,unit_id_asal,kso_id,tgl_in,kamar_id,kode,nama,tarip,beban_kso,beban_pasien,kelas_id,aktif) values('".$rwNewPel['idpel']."','".$_REQUEST['unitAsal']."','$kso_id',".$tgljam.",'".$_REQUEST['kamar_id']."','".$rwKamar['kode']."','".$rwKamar['nama']."','".$biaya."','".$beban_kso."','".$beban_pasien."','$kelasnya','$caktif')";
					////////////////////////////////////////////////////////////////
					//echo $sqlTambah."<br>";
					$rs=mysql_query($sqlTambah);
					//mysql_free_result($rsCekStat);
					mysql_free_result($rsCek);
					//mysql_free_result($rsNewPel);
               		//data inap di pelayanan tidak diset menjadi 2 (pindah kamar) jika jenis layanan tujuan ROI IGD / IPIT --> blm diaktifkan
               		//if($_GET['tmpLayKamar'] != '112' && $move == true){
						$sqlDilayani="update b_pelayanan set dilayani=2, tgl_krs = $tgljam where id='".$pelayanan_id."'";
						$rsDilayani=mysql_query($sqlDilayani);
               		//}
					$statusProses='Fine';
					mysql_free_result($rsKamar);
					mysql_free_result($rsUnitSama);
					/*============ Tambahan Cek Tindakan Operatif, Jika Pindah Kelas Lebih Tinggi maka tarif ikut kelas yg baru ===*/
					$sqlOp="SELECT t.*,mtk.ms_tindakan_id FROM b_pelayanan p INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
WHERE p.kunjungan_id='$kunjungan_id' AND (p.unit_id=63 OR p.unit_id=47)";
					//echo $sqlOp."<br>";
					$rsOp=mysql_query($sqlOp);
					if (mysql_num_rows($rsOp)>0){
						while ($rwOp=mysql_fetch_array($rsOp)){
							$sqlTindOp="SELECT * FROM b_ms_tindakan_kelas WHERE ms_tindakan_id='".$rwOp["ms_tindakan_id"]."' AND ms_kelas_id='$kelasnya'";
							//echo $sqlTindOp."<br>";
							$rsTindOp=mysql_query($sqlTindOp);
							if (mysql_num_rows($rsTindOp)>0){
								$rwTindOp=mysql_fetch_array($rsTindOp);
								if ($rwTindOp["tarip"]>$rwOp["biaya"]){
									if ($kso_id == 1){
										$sqlUpdtTind="UPDATE b_tindakan SET ms_tindakan_kelas_id=".$rwTindOp["id"].",biaya=".$rwTindOp["tarip"].",biaya_kso=0,biaya_pasien=".$rwTindOp["tarip"]." WHERE id=".$rwOp["id"];
										$rsUpdtTind=mysql_query($sqlUpdtTind);
									}elseif ($kso_id == 4){
										$sqlUpdtTind="SELECT nilai,kp.id FROM b_ms_kso_paket_detail pd INNER JOIN b_ms_tindakan_kelas tk ON pd.ms_tindakan_id = tk.ms_tindakan_id 
INNER JOIN b_ms_kso_paket kp ON pd.kso_paket_id = kp.id WHERE tk.id = '".$rwOp["ms_tindakan_kelas_id"]."' AND kp.kso_id = 4 ORDER BY nilai DESC";
										//echo $sqlUpdtTind."<br>";
										$rsUpdtTind=mysql_query($sqlUpdtTind);
										if (mysql_num_rows($rsUpdtTind)>0){
											$rwUpdtTind=mysql_fetch_array($rsUpdtTind);
											$biayaKSO=$rwUpdtTind["nilai"];
											$biayaPx=0;
											if ($HakKlsPx != $kelasnya && $rwTindOp["tarip"]>$biayaKSO) $biayaPx=$rwTindOp["tarip"]-$biayaKSO;
											$sqlUpdtTind="UPDATE b_tindakan SET ms_tindakan_kelas_id=".$rwTindOp["id"].",biaya=".$rwTindOp["tarip"].",biaya_kso=$biayaKSO,biaya_pasien=$biayaPx WHERE id=".$rwOp["id"];
											$rsUpdtTind2=mysql_query($sqlUpdtTind);
										}else{
											$sqlUpdtTind="SELECT lp.nilai FROM b_ms_kso_luar_paket lp INNER JOIN b_ms_tindakan_kelas tk ON lp.ms_tindakan_id = tk.ms_tindakan_id WHERE lp.kso_id = 4 AND tk.id = '".$rwOp["ms_tindakan_kelas_id"]."' ORDER BY nilai DESC";
											//echo $sqlUpdtTind."<br>";
											$rsUpdtTind=mysql_query($sqlUpdtTind);
											if (mysql_num_rows($rsUpdtTind)>0){
												$rwUpdtTind=mysql_fetch_array($rsUpdtTind);
												$biayaKSO=$rwUpdtTind["nilai"];
												$biayaPx=0;
												if ($HakKlsPx != $kelasnya && $rwTindOp["tarip"]>$biayaKSO) $biayaPx=$rwTindOp["tarip"]-$biayaKSO;
												$sqlUpdtTind="UPDATE b_tindakan SET ms_tindakan_kelas_id=".$rwTindOp["id"].",biaya=".$rwTindOp["tarip"].",biaya_kso=$biayaKSO,biaya_pasien=$biayaPx WHERE id=".$rwOp["id"];
												$rsUpdtTind2=mysql_query($sqlUpdtTind);
											}
										}
									}else{
										$sqlUpdtTind="SELECT * FROM b_ms_tindakan_kelas WHERE ms_tindakan_id='".$rwOp["ms_tindakan_id"]."' AND ms_kelas_id='$HakKlsPx'";
										$rsUpdtTind=mysql_query($sqlUpdtTind);
										if (mysql_num_rows($rsUpdtTind)>0){
											$rwUpdtTind=mysql_fetch_array($rsUpdtTind);
											$biayaKSO=$rwUpdtTind["tarip"];
											$biayaPx=0;
											if ($rwTindOp["tarip"]>$biayaKSO) $biayaPx=$rwTindOp["tarip"]-$biayaKSO;
											$sqlUpdtTind="UPDATE b_tindakan SET ms_tindakan_kelas_id=".$rwTindOp["id"].",biaya=".$rwTindOp["tarip"].",biaya_kso=$biayaKSO,biaya_pasien=$biayaPx WHERE id=".$rwOp["id"];
											$rsUpdtTind2=mysql_query($sqlUpdtTind);
										}
									}
								}
							}
						}
					}
		    	}
			}
			else {
            	$statusProses='Error';
        	}
            break;
        }
        break;

    case 'simpan':
    //echo "update";
        switch($_REQUEST["smpn"]) {
            case 'btnSimpanTindINACBG':
			    $id_tindakan_radiologi=$_REQUEST['id'];
				$biaya_pasien = 0;
				$biaya_kso = 0;
				
				$cekTindAsli="SELECT * FROM b_tindakan t WHERE id='".$_REQUEST['id']."'";
				//echo $cekTindAsli;
				$rscekTindAsli=mysql_query($cekTindAsli);
				$rwcekTindAsli=mysql_fetch_array($rscekTindAsli);

/*				$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
				$rsCekStat = mysql_query($sqlCekStat);
				$rowCekStat = mysql_fetch_array($rsCekStat);
				//jika status kso pasien umum
				//echo $rowCekStat['kso_id'].'tes';
				if($rowCekStat['kso_id'] == 1) {
					//seluruh biaya ditanggung pasien sendiri
					$biaya_pasien = $biayaRS;
				}
				else {
					$sql="SELECT * FROM b_ms_unit WHERE id='".$unitId."'";
					$rsUnit=mysql_query($sql);
					$rwUnit=mysql_fetch_array($rsUnit);
					$idParent=$rwUnit['parent_id'];
					if($inap == 1) {
						if($rowCekStat['kso_id'] == 4) {
							//askes sosial
							$sqlCek = "select * from b_ms_kso_pakomodasi where ms_kso_id = '4' and ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
							$rsCek = mysql_query($sqlCek);
							//jika hasil lebih dari 0 -> termasuk akomodasi
							if(mysql_num_rows($rsCek) > 0) {
								if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
									$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '4'";
									$rsHp = mysql_query($sqlHp);
									$paket_hp = 0;
									if(mysql_num_rows($rsHp) > 0) {
										$rowHp = mysql_fetch_array($rsHp);
										$paket_hp = $rowHp['jaminan'];
									}
									mysql_free_result($rsHp);

									//paket hp dibandingkan dengan tindakan akomodasi perharinya ditambah biaya kamar
								   $sqlCekAkomodasi = "select ifnull(sum(biaya * qty),0) as jumlah,ifnull(sum(biaya_pasien * qty),0) as biaya_pasien from b_tindakan t inner join  b_ms_tindakan_kelas kt on t.ms_tindakan_kelas_id = kt.id where kt.ms_tindakan_id in (select ms_tindakan_id from b_ms_kso_pakomodasi where ms_kso_id = '4') and t.pelayanan_id = '$pelayanan_id' and t.id<>".$_REQUEST['id'];
									//echo $sqlCekAkomodasi."<br>";
									$rsAkomodasi = mysql_query($sqlCekAkomodasi);
									$rowAkomodasi = mysql_fetch_array($rsAkomodasi);
				
									$biayaKamar="SELECT id,kamar_id,IF (DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)) AS qtyHari,
tarip,beban_kso,beban_pasien
FROM b_tindakan_kamar WHERE pelayanan_id='".$pelayanan_id."'";
									//echo $biayaKamar."<br>";
									$rsBiayaKamar=mysql_query($biayaKamar);
									$rowBiayaKamar=0;
									$rowBiayaKamarHP=0;
									$rowBiayaKamarPasien=0;
									while ($rwBiayaKamar=mysql_fetch_array($rsBiayaKamar)){
										if ($rwBiayaKamar['tarip']==0 || $rwBiayaKamar['beban_kso']==0){
											if ($rwBiayaKamar['kamar_id']!=0){
												$sql="SELECT * FROM b_ms_kamar_tarip WHERE kamar_id='".$rwBiayaKamar['kamar_id']."' AND kelas_id='".$_GET['kelas_id']."'";
												$rsKmr=mysql_query($sql);
												$rwKmr=mysql_fetch_array($rsKmr);
												
												$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
												$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
												$bPx=0;
												if ($rwKmr['tarip']>$paket_hp){
													$bPx=$rwKmr['tarip']-$paket_hp;
												}
												$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
												$sql="UPDATE b_tindakan_kamar SET tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
												$rsKmr=mysql_query($sql);											
											}else{
												$sql="SELECT mkt.*,mk.kode,mk.nama FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_kamar mk ON mkt.kamar_id=mk.id WHERE mkt.unit_id='".$unitId."' AND mkt.kelas_id='".$_GET['kelas_id']."' LIMIT 1";
												//echo $sql."<br>";
												$rsKmr=mysql_query($sql);
												$rwKmr=mysql_fetch_array($rsKmr);
												
												$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
												$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
												$bPx=0;
												if ($rwKmr['tarip']>$paket_hp){
													$bPx=$rwKmr['tarip']-$paket_hp;
												}
												$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
												$sql="UPDATE b_tindakan_kamar SET kamar_id='".$rwKmr['kamar_id']."',kode='".$rwKmr['kode']."',nama='".$rwKmr['nama']."',tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
												//echo $sql."<br>";
												$rsKmr=mysql_query($sql);
											}
										}else{
											$rowBiayaKamar += $rwBiayaKamar['tarip'] * $rwBiayaKamar['qtyHari'];
											$rowBiayaKamarHP += $rwBiayaKamar['beban_kso'] * $rwBiayaKamar['qtyHari'];
											$bPx=0;
											if ($rwBiayaKamar['tarip']>$rwBiayaKamar['beban_kso']){
												$bPx=$rwBiayaKamar['tarip']-$rwBiayaKamar['beban_kso'];
											}
											$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
											
											if ($bPx>0 && $rwBiayaKamar['beban_pasien']==0){
												$sql="UPDATE b_tindakan_kamar SET beban_pasien='".$bPx."' WHERE id='".$rwBiayaKamar['id']."'";
												//echo $sql."<br>";
												$rsKmr=mysql_query($sql);
											}
										}
									}
									
									if(($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) < ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien)) {
										$biaya_kso = 0;
										$biaya_pasien = 0;
									}
									else {
										$biaya_pasien = ($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) - ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien);
										$biaya_kso = 0;
									}
									mysql_free_result($rsAkomodasi);
								}
							}
							else {
								$sqlASos = "select nilai,kp.id
										from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
										inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
										where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
								$rsASos = mysql_query($sqlASos);
								$res = mysql_num_rows($rsASos);
								if($res > 0) {
									$rowASos = mysql_fetch_array($rsASos);
									$biaya_kso = $rowASos['nilai'];
									$idpaket = $rowASos['id'];
									if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
										//$biaya_pasien = $biayaRS - $biaya_kso;
										if ($idpaket==3 || $idpaket==4 || $idpaket==5){
											$biaya_kso = 0;
											$biaya_pasien = $biayaRS;
										}elseif($biayaRS > $biaya_kso){
											$biaya_pasien = $biayaRS - $biaya_kso;
										}
									}elseif ($idpaket==3){
										$biaya_kso = 0;
										$biaya_pasien = 0;
									}elseif ($idpaket==4 || $idpaket==5){
										//----paket II 1 hari 1 klaim-----
										$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan t WHERE t.kunjungan_id='$kunjungan_id') AS t1 
INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
WHERE pd.kso_paket_id=$idpaket AND t1.tgl='".$rwcekTindAsli['tgl']."'";
										//echo $sqlCPaket."<br>";
										$rsCPaket=mysql_query($sqlCPaket);
										if (mysql_num_rows($rsCPaket)>0){
											$biaya_kso = 0;
											$biaya_pasien = 0;
										}
									}
								}
								else {
									$sqlASos = "SELECT lp.nilai
											FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id
											where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
									$rsASos = mysql_query($sqlASos);
									if(mysql_num_rows($rsASos) > 0) {
										$rowASos = mysql_fetch_array($rsASos);
										$biaya_kso = $rowASos['nilai'];
										if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
											$biaya_pasien = $biayaRS - $biaya_kso;
										}
									}
									else {
										$biaya_pasien = $biayaRS;
									}
								}
								mysql_free_result($rsASos);
							}
						}
						else {
							//non askes sosial
							$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
							$rsTdkDijamin=mysql_query($sql);
							if (mysql_num_rows($rsTdkDijamin)>0){
								$biaya_kso = 0;
								$biaya_pasien = $biayaRS;
							}else{
								if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)){
									$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
									$rsCek = mysql_query($sqlCek);
									$rowCek = mysql_fetch_array($rsCek);
									if($biayaRS > $rowCek['tarip']) {
										$biaya_kso = $rowCek['tarip'];
										$biaya_pasien = $biayaRS - $biaya_kso;
									}
									else {
										$biaya_kso = $biayaRS;
									}
									mysql_free_result($rsCek);
								}
								else {
									$biaya_kso = $biayaRS;
								}
							}
							mysql_free_result($rsTdkDijamin);
						}
					}
					else {
						//echo $rowCekStat['kso_id']."<br>";
						//$biaya_kso = (($rowCekStat['kso_id'] != 4)?$biayaRS:$_REQUEST['biayaAskes']);
						//biaya di bawah jika kso pindah kelas dan bukan non kelas
						if($rowCekStat['kso_id'] != 4) {
							$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
							$rsTdkDijamin=mysql_query($sql);
							if (mysql_num_rows($rsTdkDijamin)>0){
								$biaya_kso = 0;
								$biaya_pasien = $biayaRS;
							}else{
								if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
									$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
									$rsCek = mysql_query($sqlCek);
									$rowCek = mysql_fetch_array($rsCek);
									if($biayaRS > $rowCek['tarip']) {
										$biaya_kso = $rowCek['tarip'];
										$biaya_pasien = $biayaRS - $biaya_kso;
									}
									else {
										$biaya_kso = $biayaRS ;
									}
									mysql_free_result($rsCek);
								}
								else {
									$biaya_kso = $biayaRS ;
								}
							}
							mysql_free_result($rsTdkDijamin);
						}
						else {
							$cekRetribusi="SELECT * FROM b_tindakan t WHERE user_id=0 and id='".$_REQUEST['id']."'";
							//echo $cekRetribusi;
							$rsCekRetribusi=mysql_query($cekRetribusi);
							if(mysql_num_rows($rsCekRetribusi)>0){
								$rwCekRetribusi=mysql_fetch_array($rsCekRetribusi);
								$biaya_pasien = $rwCekRetribusi['biaya_pasien'];
								$biaya_kso = $rwCekRetribusi['biaya_kso'];
								mysql_free_result($rsCekRetribusi);
							}
							else{
								$sqlASos = "select nilai,kp.id
									from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
									inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
									where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
								$rsASos = mysql_query($sqlASos);
								$res = mysql_num_rows($rsASos);
								if($res > 0) {
									$rowASos = mysql_fetch_array($rsASos);
									$biaya_kso = $rowASos['nilai'];
									$idpaket = $rowASos['id'];
									if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
										//$biaya_pasien = $biayaRS - $biaya_kso;
										if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
											$biaya_kso = 0;
											$biaya_pasien = $biayaRS;
										}elseif($biayaRS > $biaya_kso){
											$biaya_pasien = $biayaRS - $biaya_kso;
										}
									}elseif (($idpaket==3) && ($cJenisKunj==3)){
										//----paket IIA ikut akomodasi-----
										$biaya_kso = 0;
										$biaya_pasien = 0;
									}elseif ($idpaket==3 || $idpaket==4 || $idpaket==5){
										//----paket II 1 hari 1 klaim-----
										$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan t WHERE t.kunjungan_id='$kunjungan_id') AS t1 
INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
WHERE pd.kso_paket_id=$idpaket AND t1.tgl='".$rwcekTindAsli['tgl']."'";
										//echo $sqlCPaket."<br>";
										$rsCPaket=mysql_query($sqlCPaket);
										if (mysql_num_rows($rsCPaket)>0){
											$biaya_kso = 0;
											$biaya_pasien = 0;
										}
									}
								}
								else {
									$sqlASos = "SELECT lp.nilai FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
									$rsASos = mysql_query($sqlASos);
									if(mysql_num_rows($rsASos) > 0) {
										$rowASos = mysql_fetch_array($rsASos);
										$biaya_kso = $rowASos['nilai'];
										if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
											$biaya_pasien = $biayaRS - $biaya_kso;
										}
									}
									else {
										$biaya_pasien = $biayaRS;
									}
								}
								mysql_free_result($rsASos);
							}
						}
					}
				}
				mysql_free_result($rsCekStat);*/
				
				$sql="SELECT * FROM b_ms_unit WHERE id='".$unitId."'";
				$rsUnit=mysql_query($sql);
				$rwUnit=mysql_fetch_array($rsUnit);
				$idParent=$rwUnit['parent_id'];
				$biaya_pasien = 0;
				$biaya_kso = 0;

				//$sqlCekStat = "select kso_id,kso_kelas_id from b_kunjungan where id = '$kunjungan_id'";
				$sqlCekStat="SELECT k.kso_id,k.kso_kelas_id,k.jenis_layanan,p.unit_id_asal,p.jenis_kunjungan,mu.inap,mu.parent_id,mu.kategori 
FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id LEFT JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
WHERE k.id = '$kunjungan_id' AND p.id='$pelayanan_id'";
				$rsCekStat = mysql_query($sqlCekStat);
				$rowCekStat = mysql_fetch_array($rsCekStat);
				$cUnitAsalIsInap = $rowCekStat["inap"];
				$cUnitAsal = $rowCekStat["unit_id_asal"];
				$cJenisKunj = $rowCekStat["jenis_kunjungan"];
				$cStatPas = $rowCekStat['kso_id'];
				$cJenisLayAwalKunj = $rowCekStat['jenis_layanan'];
				
				if($inap == 1){
					$sqlIsAktif="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='$pelayanan_id' AND aktif=0";
					$rsIsAktif=mysql_query($sqlIsAktif);
					if (mysql_num_rows($rsIsAktif) > 0){
						$sqlUpdtAktif="UPDATE b_tindakan_kamar SET aktif=1 WHERE pelayanan_id='$pelayanan_id' AND aktif=0";
						$rsUpdtAktif=mysql_query($sqlUpdtAktif);
					}
				}
				//jika status kso pasien umum
				//echo $rowCekStat['kso_id'].'tes<br>';
				if($rowCekStat['kso_id'] == 1 || $rowCekStat['kso_id'] == 2) {
					//seluruh biaya ditanggung pasien sendiri
					//$biaya_pasien = $biayaRS;
					$biaya_kso = $biayaRS;
				}
				else {
					/*$sqlCek = "select * from b_ms_kso_paket_nonbiaya where kso_id = '".$rowCekStat['kso_id']."' and ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
					//echo $sqlCek."<br>";
					$rsCek = mysql_query($sqlCek);
					if(mysql_num_rows($rsCek) > 0) {
						$rowCek = mysql_fetch_array($rsCek);
						$biaya_kso = 0;
					}else{*/
						if($inap == 1) {
							if($rowCekStat['kso_id'] == 4) {
								//askes sosial
								$sqlCek = "select * from b_ms_kso_pakomodasi where ms_kso_id = '4' and ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
								//echo $sqlCek."<br>";
								$rsCek = mysql_query($sqlCek);
								//jika hasil lebih dari 0 -> termasuk akomodasi
								if(mysql_num_rows($rsCek) > 0) {
									// Jika hak kelas != kelas + !=non kelas + != ipit + != icu igd/roi igd
									if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
										$sqlHp = "SELECT * FROM b_ms_kso_paket_hp b where b_ms_kelas_id = '".$rowCekStat['kso_kelas_id']."' and b_ms_kso_id = '4'";
										//echo "<br>".$sqlHp."<br>";
										$rsHp = mysql_query($sqlHp);
										$paket_hp = 0;
										if(mysql_num_rows($rsHp) > 0) {
											$rowHp = mysql_fetch_array($rsHp);
											$paket_hp = $rowHp['jaminan'];
											mysql_free_result($rsHp);
										}

										//paket hp dibandingkan dengan tindakan akomodasi perharinya ditambah biaya kamar
									   $sqlCekAkomodasi = "select ifnull(sum(biaya * qty),0) as jumlah,ifnull(sum(biaya_pasien * qty),0) as biaya_pasien from b_tindakan t inner join  b_ms_tindakan_kelas kt on t.ms_tindakan_kelas_id = kt.id where kt.ms_tindakan_id in (select ms_tindakan_id from b_ms_kso_pakomodasi where ms_kso_id = '4') and t.pelayanan_id = '$pelayanan_id' and t.id<>'".$_REQUEST['id']."'";
										//echo $sqlCekAkomodasi."<br>";
										$rsAkomodasi = mysql_query($sqlCekAkomodasi);
										$rowAkomodasi = mysql_fetch_array($rsAkomodasi);
					
										$biayaKamar="SELECT id,kamar_id,IF (DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)) AS qtyHari,
tarip,beban_kso,beban_pasien
FROM b_tindakan_kamar WHERE pelayanan_id='".$pelayanan_id."'";
										//echo $biayaKamar."<br>";
										$rsBiayaKamar=mysql_query($biayaKamar);
										$rowBiayaKamar=0;
										$rowBiayaKamarHP=0;
										$rowBiayaKamarPasien=0;
										while ($rwBiayaKamar=mysql_fetch_array($rsBiayaKamar)){
											if ($rwBiayaKamar['tarip']==0 || $rwBiayaKamar['beban_kso']==0){
												if ($rwBiayaKamar['kamar_id']!=0){
													$sql="SELECT * FROM b_ms_kamar_tarip WHERE kamar_id='".$rwBiayaKamar['kamar_id']."' AND kelas_id='".$_GET['kelas_id']."'";
													$rsKmr=mysql_query($sql);
													$rwKmr=mysql_fetch_array($rsKmr);
													
													$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
													$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
													$bPx=0;
													if ($rwKmr['tarip']>$paket_hp){
														$bPx=$rwKmr['tarip']-$paket_hp;
													}
													$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
													$sql="UPDATE b_tindakan_kamar SET tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
													$rsKmr=mysql_query($sql);											
												}else{
													$sql="SELECT mkt.*,mk.kode,mk.nama FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_kamar mk ON mkt.kamar_id=mk.id WHERE mkt.unit_id='".$unitId."' AND mkt.kelas_id='".$_GET['kelas_id']."' LIMIT 1";
													//echo $sql."<br>";
													$rsKmr=mysql_query($sql);
													$rwKmr=mysql_fetch_array($rsKmr);
													
													$rowBiayaKamar += $rwKmr['tarip'] * $rwBiayaKamar['qtyHari'];
													$rowBiayaKamarHP += $paket_hp * $rwBiayaKamar['qtyHari'];
													$bPx=0;
													if ($rwKmr['tarip']>$paket_hp){
														$bPx=$rwKmr['tarip']-$paket_hp;
													}
													$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
													$sql="UPDATE b_tindakan_kamar SET kamar_id='".$rwKmr['kamar_id']."',kode='".$rwKmr['kode']."',nama='".$rwKmr['nama']."',tarip='".$rwKmr['tarip']."',beban_kso='".$paket_hp."',beban_pasien='".$bPx."',kelas_id='".$_GET['kelas_id']."' WHERE id='".$rwBiayaKamar['id']."'";
													//echo $sql."<br>";
													$rsKmr=mysql_query($sql);
												}
											}else{
												$rowBiayaKamar += $rwBiayaKamar['tarip'] * $rwBiayaKamar['qtyHari'];
												$rowBiayaKamarHP += $rwBiayaKamar['beban_kso'] * $rwBiayaKamar['qtyHari'];
												$bPx=0;
												if ($rwBiayaKamar['tarip']>$rwBiayaKamar['beban_kso']){
													$bPx=$rwBiayaKamar['tarip']-$rwBiayaKamar['beban_kso'];
												}
												$rowBiayaKamarPasien +=$bPx * $rwBiayaKamar['qtyHari'];
												
												if ($bPx>0 && $rwBiayaKamar['beban_pasien']==0){
													$sql="UPDATE b_tindakan_kamar SET beban_pasien='".$bPx."' WHERE id='".$rwBiayaKamar['id']."'";
													//echo $sql."<br>";
													$rsKmr=mysql_query($sql);
												}
											}
										}
										
										if(($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) < ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien)) {
											$biaya_kso = 0;
											$biaya_pasien = 0;
										}
										else {
											$biaya_pasien = ($rowAkomodasi['jumlah']+$biayaRS+$rowBiayaKamar) - ($rowAkomodasi['biaya_pasien']+$rowBiayaKamarHP+$rowBiayaKamarPasien);
											$biaya_kso = 0;
										}
										mysql_free_result($rsAkomodasi);
									}
								}
								else {
									$sqlASos = "select nilai,kp.id
											from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
											inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
											where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
									//echo $sqlASos."<br>";
									$rsASos = mysql_query($sqlASos);
									$res = mysql_num_rows($rsASos);
									if($res > 0) {
										$rowASos = mysql_fetch_array($rsASos);
										$biaya_kso = $rowASos['nilai'];
										$idpaket = $rowASos['id'];
										//echo "bkso=".$biaya_kso."<br>";
										if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
											if ($idpaket==3 || $idpaket==4 || $idpaket==5){
												$biaya_kso = 0;
												$biaya_pasien = $biayaRS;
											}elseif($biayaRS > $biaya_kso){
												$biaya_pasien = $biayaRS - $biaya_kso;
											}
										}elseif ($idpaket==3){
											$biaya_kso = 0;
											$biaya_pasien = 0;
										}elseif ($idpaket==4 || $idpaket==5){
											/*----paket II 1 hari 1 klaim-----*/
											$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan t WHERE t.kunjungan_id='$kunjungan_id') AS t1 
	INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
	WHERE pd.kso_paket_id=$idpaket AND t1.tgl='".$rwcekTindAsli["tgl"]."'";
											//echo $sqlCPaket."<br>";
											$rsCPaket=mysql_query($sqlCPaket);
											if (mysql_num_rows($rsCPaket)>0){
												$biaya_kso = 0;
												$biaya_pasien = 0;
											}
										}
										mysql_free_result($rsASos);
									}
									else {
										$sqlASos = "SELECT lp.nilai
												FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id
												where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
										//echo $sqlASos."<br>";
										$rsASos = mysql_query($sqlASos);
										//echo "numrows=".mysql_num_rows($rsASos)."<br>";
										if(mysql_num_rows($rsASos) > 0) {
											$rowASos = mysql_fetch_array($rsASos);
											$biaya_kso = $rowASos['nilai'];
											//echo "bkso=".$biaya_kso."<br>";
											if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
												$biaya_pasien = $biayaRS - $biaya_kso;
											}
											mysql_free_result($rsASos);
										}
										else {
											$biaya_pasien = $biayaRS;
										}
									}
								}
							}
							else {
								//non askes sosial
								$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
								$rsTdkDijamin=mysql_query($sql);
								if (mysql_num_rows($rsTdkDijamin)>0){
									$biaya_kso = 0;
									$biaya_pasien = $biayaRS;
								}else{
									if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
										$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
										$rsCek = mysql_query($sqlCek);
										$biaya_kso = $biayaRS ;
										if (mysql_num_rows($rsCek)>0){
											$rowCek = mysql_fetch_array($rsCek);
											if($biayaRS > $rowCek['tarip']) {
												$biaya_kso = $rowCek['tarip'];
												$biaya_pasien = $biayaRS - $biaya_kso;
											}
										}
										mysql_free_result($rsCek);
									}
									else {
										$biaya_kso = $biayaRS;
									}
								}
							}
						}
						else {
							//biaya di bawah jika kso pindah kelas dan bukan non kelas dan bukan Askes Sosial dan Non Inap
							if($rowCekStat['kso_id'] != 4) {
								$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='".$rowCekStat['kso_id']."' AND b_ms_tindakan_id=(select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."')";
								$rsTdkDijamin=mysql_query($sql);
								if (mysql_num_rows($rsTdkDijamin)>0){
									$biaya_kso = 0;
									$biaya_pasien = $biayaRS;
								}else{
									$sql = "SELECT lp.nilai FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id where lp.kso_id = ".$rowCekStat['kso_id']." and tk.id = '".$_GET['idTind']."'";
									//echo $sql."<br>";
									$rsLuarPaket = mysql_query($sql);
									if (mysql_num_rows($rsLuarPaket)>0){
										$rwLuarPaket=mysql_fetch_array($rsLuarPaket);
										$biaya_kso = $rwLuarPaket['nilai'];
										if ($biayaRS>$biaya_kso) $biaya_pasien = $biayaRS-$biaya_kso;
									}else{
										if (($rowCekStat['kso_id'] == 2) && ($unitId == 47 || $unitId == 63) && ($biayaRS>3050000)){
										//===========Unit OK dan kso = jamsostek======
											$biaya_kso = 3050000;
											$biaya_pasien = $biayaRS - $biaya_kso;
										}else{
											if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
												$sqlCek = "SELECT * FROM b_ms_tindakan_kelas b where ms_tindakan_id = (select ms_tindakan_id from b_ms_tindakan_kelas where id = '".$_REQUEST['idTind']."') and ms_kelas_id = '".$_REQUEST['ksoKelasId']."'";
												$rsCek = mysql_query($sqlCek);
												$biaya_kso = $biayaRS;
												if (mysql_num_rows($rsCek)>0){
													$rowCek = mysql_fetch_array($rsCek);
												
													if($biayaRS > $rowCek['tarip']) {
														$biaya_kso = $rowCek['tarip'];
														$biaya_pasien = $biayaRS - $biaya_kso;
													}
												}
												mysql_free_result($rsCek);
											}
											else {
												$biaya_kso = $biayaRS ;
											}
										}
									}
								}
							}
							else {
								// Jika Askes Sosial
								if ($cJenisKunj==1 && $cJenisLayAwalKunj==50){
									$biaya_pasien = $biayaRS;
								}elseif($unitId == 14 || $unitId == 22){
									$biaya_pasien = $biayaRS;
								}else{
									$sqlASos = "select nilai,kp.id
											from b_ms_kso_paket_detail pd inner join b_ms_tindakan_kelas tk on pd.ms_tindakan_id = tk.ms_tindakan_id
											inner join b_ms_kso_paket kp on pd.kso_paket_id = kp.id
											where tk.id = '".$_GET['idTind']."' and kp.kso_id = 4";
									//echo $sqlASos."<br>";
									$rsASos = mysql_query($sqlASos);
									$res = mysql_num_rows($rsASos);
									if($res > 0) {
										$rowASos = mysql_fetch_array($rsASos);
										$biaya_kso = $rowASos['nilai'];
										$idpaket = $rowASos['id'];
										if(($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112)) {
											/*----paket IIA / IIB / IIC & RI naik kelas-----*/
											if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
												if($biayaRS > $biaya_kso){
													$biaya_pasien = $biayaRS - $biaya_kso;
												}
											}
											/*if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
												$biaya_kso = 0;
												$biaya_pasien = $biayaRS;
											}elseif($biayaRS > $biaya_kso){
												$biaya_pasien = $biayaRS - $biaya_kso;
											}*/
										}elseif (($idpaket==3) && ($cJenisKunj==3)){
											/*----paket IIA ikut akomodasi-----*/
											$biaya_kso = 0;
											$biaya_pasien = 0;
										}elseif ($idpaket==3 || $idpaket==4 || $idpaket==5){
											/*----paket IIA / IIB / IIC 1 hari 1 klaim-----*/
											$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan t WHERE t.kunjungan_id='$kunjungan_id' and t.id<>'".$_REQUEST['id']."') AS t1 
	INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
	WHERE pd.kso_paket_id=$idpaket AND t1.tgl='".$rwcekTindAsli["tgl"]."'";
											//echo $sqlCPaket."<br>";
											$rsCPaket=mysql_query($sqlCPaket);
											if (mysql_num_rows($rsCPaket)>0){
												$biaya_kso = 0;
												$biaya_pasien = 0;
											}
										}
										mysql_free_result($rsASos);
									}
									else {
										$sqlASos = "SELECT lp.nilai
											FROM b_ms_kso_luar_paket lp inner join b_ms_tindakan_kelas tk on lp.ms_tindakan_id = tk.ms_tindakan_id
											where lp.kso_id = 4 and tk.id = '".$_GET['idTind']."'";
										//echo $sqlASos."<br>";
										$rsASos = mysql_query($sqlASos);
										if (mysql_num_rows($rsASos) > 0) {
											$rowASos = mysql_fetch_array($rsASos);
											$biaya_kso = $rowASos['nilai'];
											if (($_REQUEST['ksoKelasId'] != $_GET['kelas_id']) && ($_GET['kelas_id'] != 1) && ($idParent != 94) && ($unitId != 48) && ($unitId != 112) && ($biayaRS > $biaya_kso)) {
												$biaya_pasien = $biayaRS - $biaya_kso;
											}
											mysql_free_result($rsASos);
										}
										else {
											/*if ($cUnitAsalIsInap==1 || $cUnitAsal==63 || $cUnitAsal==47 || $unitId==2){
												$biaya_pasien = $biayaRS;
											}else{
												$biaya_kso = $biayaRS;
											}*/
											$biaya_pasien = $biayaRS;
										}
									}
								}
							}
						}
					//}
				}
				mysql_free_result($rsCekStat);

				$sqlUpdate="UPDATE b_tindakan_inacbg SET ms_tindakan_id = '".$_REQUEST['idTind']."',ms_tindakan_unit_id='".$_REQUEST['unitId']."', ket = '".$_REQUEST['ket']."', qty=".$_REQUEST['qty'].", biaya = '".$biayaRS."', user_act = $userId, user_id=".$_REQUEST['idDok'].",type_dokter='".$isDokPengganti."', biaya_pasien = '$biaya_pasien', biaya_kso = '$biaya_kso' WHERE id = '".$_REQUEST['id']."'";
				$sqlHapusKomponen="delete from b_tindakan_komponen where tindakan_id='".$_REQUEST['id']."'";
				mysql_query($sqlHapusKomponen);


				$sqlCek="SELECT nama FROM b_ms_reference b where stref=22";
				$rsCek=mysql_query($sqlCek);
				$rwCek=mysql_fetch_array($rsCek);

				if($rwCek['nama']=='1') {
					$tarif=",b.tarip_prosen*".($biayaRS/100);
				}
				else {
					$tarif=",b.tarip";
				}

				$sqlTambah="insert into b_tindakan_komponen (tindakan_id,ms_komponen_id,nama,tarip,tarip_prosen) SELECT '".$_REQUEST['id']."',k.id,k.nama
						$tarif,b.tarip_prosen FROM b_ms_tindakan_komponen b
								inner join b_ms_komponen k on b.ms_komponen_id=k.id
								where b.ms_tindakan_kelas_id='".$_REQUEST['idTind']."'";
				//echo $sqlTambah."<br/>";
				$rs=mysql_query($sqlTambah);
				$sql_an = "delete from b_tindakan_dokter_anastesi where tindakan_id = '".$_REQUEST['id']."'";
				mysql_query($sql_an);
				
				if(isset($_REQUEST['anastesi']) && $_REQUEST['anastesi'] != ''){
				    $anastesi = explode(',',$_REQUEST['anastesi']);
				    for($i=0; $i<count($anastesi); $i++){
					   $sql_an = "insert into b_tindakan_dokter_anastesi (tindakan_id,dokter_id,user_act)
							 values ('".$_REQUEST['id']."','".$anastesi[$i]."','$userId')";
					   mysql_query($sql_an);
				    }
				}

				$sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."' and dilayani=0";
				$rsDilayani=mysql_query($sqlDilayani);
				$statusProses='Fine';
				mysql_free_result($rsCek);
                break;

            case 'btnSimpanDiag':
				if($_REQUEST['isManual']=='1'){
					$sqlUpdate="update b_diagnosa set ms_diagnosa_id='0',diagnosa_manual='".$_REQUEST['diagnosa']."',primer='".$_REQUEST['isPrimer']."',akhir='".$_REQUEST['isAkhir']."',user_act=$userId, user_id=".$_REQUEST['idDok'].",type_dokter='".$isDokPengganti."' where diagnosa_id='".$_REQUEST['id']."'";
				}
				else{
					$sqlUpdate="update b_diagnosa set ms_diagnosa_id='".$_REQUEST['idDiag']."',primer='".$_REQUEST['isPrimer']."',akhir='".$_REQUEST['isAkhir']."',user_act=$userId, user_id=".$_REQUEST['idDok'].",type_dokter='".$isDokPengganti."' where diagnosa_id='".$_REQUEST['id']."'";	
				}
                
		//pelayanan_id='".$pelayanan_id."',tgl=CURDATE(),tgl_act=now(),
                break;

            case 'btnSimpanResep':	//resep
                $sqlUpdate="UPDATE b_resep SET apotek_id = '".$_REQUEST['apotek']."', obat_id = '".$_REQUEST['idObat']."', qty = '".$_REQUEST['jumlah']."', qty_bahan = '".$_REQUEST['jmlBahan']."', satuan = '".$_REQUEST['satRacikan']."', racikan = '".$_REQUEST['isracikan']."', dokter_id = '".$_REQUEST['dokter']."', dokter_nama = '".$rwDok['nama']."', type_dokter = '$isDokPengganti' WHERE id = '".$_REQUEST['id']."' ";
                break;	    
        }
        //echo $sqlUpdate."<br/>";
        $rs=mysql_query($sqlUpdate);
        break;

    case 'hapus':
		$msg="";
        switch($_REQUEST["hps"]) {
            case 'btnHapusTindINACBG':
			    $id_tindakan_radiologi = $_REQUEST['rowid'];
            	$sql="SELECT * FROM b_tindakan_inacbg WHERE id='".$_REQUEST['rowid']."'";
            	$rs=mysql_query($sql);
				$rw=mysql_fetch_array($rs);
				if ($rw['bayar']>0){
					$statusProses='Error';
					$msg="Data Tindakan Sudah Dibayar Oleh Pasien, Jadi Tidak Boleh Dihapus !";
					$sqlHapus = "select now()";
				}else{
					$sql="SELECT t.kunjungan_id,t.pelayanan_id,mu.nama unit,t.biaya,t.biaya_kso,t.biaya_pasien 
	FROM b_tindakan_inacbg t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
	INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE t.id='".$_REQUEST['rowid']."'";
					$rs=mysql_query($sql);
					$rw=mysql_fetch_array($rs);
					$cket="kunjungan_id=".$rw["kunjungan_id"].",pelayanan_id=".$rw["pelayanan_id"].",unit=".$rw["unit"].",tindakan=".$rw["nama"].",biaya=".$rw["biaya"].",biaya_kso=".$rw["biaya_kso"].",biaya_pasien=".$rw["biaya_pasien"];
					
					$sqlHapus="delete from b_tindakan_inacbg where id='".$_REQUEST['rowid']."'";
					//echo $sqlHapus."<br>";
					$sqlHapusKomponen="delete from b_tindakan_komponen where tindakan_id='".$_REQUEST['rowid']."'";
					mysql_query($sqlHapusKomponen);
					
					$sql_an = "delete from b_tindakan_dokter_anastesi where tindakan_id = '".$_REQUEST['rowid']."'";
					mysql_query($sql_an);
					//forAkun('del','','tind','',$_REQUEST['rowid'].'.'.$_REQUEST['unit_id']);
				}
				break;
            case 'btnHapusDiag':
                $sqlHapus="delete from b_diagnosa where diagnosa_id='".$_REQUEST['rowid']."'";
                break;

            case 'btnHapusResep':	//resep
                $sqlHapus = "DELETE FROM b_resep WHERE id = '".$_REQUEST['rowid']."'";
                break;
	    
			case 'btnBatalPulang':
				$sqlKunj = "SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='".$_REQUEST['pelayanan_id']."' ORDER BY id DESC LIMIT 1";
				$rsKunj = mysql_query($sqlKunj);
				$rwKunj = mysql_fetch_array($rsKunj);
				$sqlKunj = "UPDATE b_tindakan_kamar SET tgl_out=NULL WHERE id='".$rwKunj['id']."'";
				$rsKunj = mysql_query($sqlKunj);
				
				$sqlKunj = "update b_kunjungan set tgl_pulang = null, pulang = 0 where id = '$kunjungan_id'";
				$rsKunj = mysql_query($sqlKunj);
				echo 'Batal dipulangkan';
				return;
				break;
        	case 'btnHapusRujukUnit':
                $cekLay="select * from b_pelayanan p inner join b_tindakan t on p.id = t.pelayanan_id where p.id='".$_REQUEST['rowid']."' and dilayani=1";
                $rs=mysql_query($cekLay);
                if(mysql_num_rows($rs)>0) {
                    $statusProses='Error';
                }
                else {
                    if($_GET['isInap'] == 0) {
                        $sqlCekHapus = "select max(id) as id
                            from b_tindakan
                            where pelayanan_id = '".$_GET['rowid']."'
                                and ms_tindakan_unit_id = '".$_GET['tmpLay']."'";
                        $rsCek = mysql_query($sqlCekHapus);
                        $rowCek = mysql_fetch_array($rsCek);

                        $sqlHapus = "delete from b_tindakan_komponen where tindakan_id = '".$rowCek['id']."'";
                        mysql_query($sqlHapus);

                        $sqlHapus = "delete from b_tindakan where pelayanan_id = '".$_GET['rowid']."' and ms_tindakan_unit_id = '".$_GET['tmpLay']."'";
			mysql_free_result($rsCek);
                    }
                    else {
                        $sqlHapus = "delete from b_tindakan_kamar where pelayanan_id = '".$_GET['rowid']."'";
						//echo $sqlHapus."<br>";
                    }
                    mysql_query($sqlHapus);
					$sqlDel = "DELETE FROM b_tindakan_lab WHERE pelayanan_id = '".$_REQUEST['rowid']."'";
					$hasil = mysql_query($sqlDel);
                    $sqlHapus = "delete from b_pelayanan where id='".$_REQUEST['rowid']."'";					
					//echo $sqlHapus."<br>";
                }
                break;
            case 'btnHapusRujukRS':
				$sqlCek = "SELECT inap,tgl_krs,tgl_pulang,pulang,k.id
					   FROM b_pelayanan p
					   inner join b_kunjungan k on p.kunjungan_id = k.id
					   INNER JOIN b_ms_unit u ON p.unit_id = u.id
					   WHERE p.id = '$pelayanan_id'";
				$rsCek = mysql_query($sqlCek);
				$rowCek = mysql_fetch_array($rsCek);
				$tgl_krs = $rowCek['tgl_krs'];
				$tgl_pul = $rowCek['tgl_pulang'];
				$pulang = $rowCek['pulang'];
				$kunjungan_id = $rowCek['id'];
				if($rowCek['inap'] == 1){
					$sqlKunj = "update b_tindakan_kamar set tgl_out = null,status_out = 0 where pelayanan_id = '$pelayanan_id'";
					$rsKunj = mysql_query($sqlKunj);
				}
				mysql_free_result($rsCek);
		
				if($tgl_krs == $tgl_pul && $pulang == 0){
					$sqlKunj = "update b_kunjungan set tgl_pulang = null where id = '$pelayanan_id'";
					$rsKunj = mysql_query($sqlKunj);
				}
				$sqlDilayani="update b_pelayanan set dilayani=1,tgl_krs=null where id='".$pelayanan_id."'";
							//echo $sqlDilayani."<br>";
				$rsDilayani=mysql_query($sqlDilayani);
		
						$sqlHapus="delete from b_pasien_keluar where id='".$_REQUEST['rowid']."'";
						//}
                break;
            case 'btnHapusKamar':
				//mengambil pelayanan_id dari data pindah kamar dengan id = $_REQUEST['rowid']
				$sqlSe = "select pelayanan_id from b_tindakan_kamar where id = '".$_REQUEST['rowid']."'";
				//echo $sqlSe."<br>";
				$rsSe = mysql_query($sqlSe);
				$rowSe = mysql_fetch_array($rsSe);
				$sqlSel = "select dilayani from b_pelayanan where id = '".$rowSe['pelayanan_id']."'";
				//echo $sqlSel."<br>";
				$rsSel = mysql_query($sqlSel);
				$rowSel = mysql_fetch_array($rsSel);
				if($rowSel['dilayani'] == '0'){
					//menghapus data pindah kamar di b_tindakan_kamar dengan id = $_REQUEST['rowid']
					$sqlHapus="delete from b_tindakan_kamar where id='".$_REQUEST['rowid']."'";
					//echo $sqlHapus."<br>";
					mysql_query($sqlHapus);
					//mengembalikan status pindah (2) menjadi dilayani (1) pada b_pelayanan.dilayani
					$sqlUpdateStat = "update b_pelayanan set dilayani = 1, tgl_krs = null where id = '$pelayanan_id'";
					//echo $sqlUpdateStat."<br>";
					mysql_query($sqlUpdateStat);
					
					$sqlUpdateStat = "SELECT MAX(id) id FROM b_tindakan_kamar WHERE pelayanan_id='$pelayanan_id'";
					//echo $sqlUpdateStat."<br>";
					$rsA=mysql_query($sqlUpdateStat);
					$rwA=mysql_fetch_array($rsA);
					$sqlUpdateStat = "update b_tindakan_kamar set tgl_out = null, status_out = 0 where pelayanan_id='$pelayanan_id' and id = '".$rwA["id"]."'";
					//echo $sqlUpdateStat."<br>";
					mysql_query($sqlUpdateStat);
					//menghapus data b_pelayanan dengan id = pelayanan_id dari b_tindakan_kamar yang diambil di atas.
					$sqlHapus = "delete from b_pelayanan where id='".$rowSe['pelayanan_id']."'";
					//echo $sqlHapus."<br>";
				}
				else{
					$sqlHapus = "select now()";
				}
                break;
        }
        mysql_query($sqlHapus);
		if (mysql_errno()==0){
			if ($_REQUEST["hps"]=='btnHapusTind' && $msg==""){
				$sqlHapus.=";ket -> ".$cket;
				$sqlDelete=str_replace("'","''",$sqlHapus);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Tindakan','$sqlDelete',now(),'$userId')";
				mysql_query($sql);
			}
		}
	//INSYA ALLAH
        break;    
}
mysql_free_result($rsDok);
mysql_free_result($rsUn);
    
if($act == 'tarikMang'){
    echo 'Masuk';
    return;
}
	    
if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id';

        /*switch(strtolower($_REQUEST['grd'])){
			case 'tab1':
				$sorting="kode"; //default sort
			break;
			case 'tab2':
				$sorting="nama"; //default sort
			break;
		}*/
    }

    if($grd == "true") {
        $sql="select *, 0 act from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas,IFNULL((SELECT kode_icd_9cm FROM b_tindakan_icd9cm WHERE b_tindakan_id=t.id),'-') icd9cm
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$pelayanan_id."') as gab $filter 
	
	UNION
	
	select *, 1 act from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas,IFNULL((SELECT kode_icd_9cm FROM b_tindakan_icd9cm WHERE b_tindakan_id=t.id),'-') icd9cm
	FROM b_tindakan_act t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$pelayanan_id."') as gab $filter 
	order by act ASC, $sorting";
    }
    elseif($grd1 == "true"){
        /*$sql="select * from (SELECT d.diagnosa_id as id,d.ms_diagnosa_id,md.kode,md.nama,d.pelayanan_id,d.user_id,p.nama as dokter,d.primer,if(d.primer=1,'Utama','Sekunder') as utama,d.akhir,if(d.akhir=1,'Ya','Tidak') as d_akhir, d.type_dokter, md.dg_kode
	FROM b_diagnosa d 
	INNER JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
	INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
	INNER JOIN b_ms_pegawai p ON p.id = d.user_id
	WHERE d.pelayanan_id = '".$pelayanan_id."') as gab $filter order by $sorting ";*/
		$sql="SELECT 
		*, 0 act,
		IF(var_kasus_baru=0,'Lama',IF(var_kasus_baru=1,'Baru','-')) AS d_kasus 
		FROM (SELECT d.diagnosa_id AS id,d.ms_diagnosa_id,md.kode,md.nama as nama1,IF(d.diagnosa_manual IS NULL,md.nama,d.diagnosa_manual) AS nama,
IFNULL((SELECT mdrm.kode FROM b_diagnosa_rm drm INNER JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id WHERE drm.diagnosa_id=d.diagnosa_id),'-') icdrm,
d.pelayanan_id,d.user_id,
p.nama AS dokter,d.primer,IF(d.primer=1,'Utama','Sekunder') AS utama,d.akhir,
IF(d.kasus_baru=0,'Lama',IF(d.kasus_baru=1,'Baru','-')) AS d_kasus,
IF(d.akhir=1,'Ya','Tidak') AS d_akhir,IF(d.klinis=1,'Ya','Tidak') AS klinis,IF(d.banding=1,'Ya','Tidak') AS banding, d.type_dokter, md.dg_kode,mu.nama unit,
(SELECT drm.kasus_baru FROM b_diagnosa_rm drm INNER JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id WHERE drm.diagnosa_id=d.diagnosa_id) AS var_kasus_baru,
DATE_FORMAT(d.tgl_act, '%d-%m-%Y %H:%i:%s') AS tgldiag
FROM b_diagnosa d 
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
INNER JOIN b_ms_pegawai p ON p.id = d.user_id
INNER JOIN b_ms_unit mu ON pl.unit_id = mu.id
WHERE d.kunjungan_id = '".$kunjungan_id."') AS gab $filter

UNION

SELECT 
		*, 1 act,
		IF(var_kasus_baru=0,'Lama',IF(var_kasus_baru=1,'Baru','-')) AS d_kasus 
		FROM (SELECT d.b_diagnosa_id AS id,d.ms_diagnosa_id,md.kode,md.nama as nama1,IF(d.diagnosa_manual IS NULL,md.nama,d.diagnosa_manual) AS nama,
IFNULL((SELECT mdrm.kode FROM b_diagnosa_rm drm INNER JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id WHERE drm.diagnosa_id=d.b_diagnosa_id),'-') icdrm,
d.pelayanan_id,d.user_id,
p.nama AS dokter,d.primer,IF(d.primer=1,'Utama','Sekunder') AS utama,d.akhir,
IF(d.kasus_baru=0,'Lama',IF(d.kasus_baru=1,'Baru','-')) AS d_kasus,
IF(d.akhir=1,'Ya','Tidak') AS d_akhir,IF(d.klinis=1,'Ya','Tidak') AS klinis,IF(d.banding=1,'Ya','Tidak') AS banding, d.type_dokter, md.dg_kode,mu.nama unit,
(SELECT drm.kasus_baru FROM b_diagnosa_rm drm INNER JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id WHERE drm.diagnosa_id=d.b_diagnosa_id) AS var_kasus_baru,
DATE_FORMAT(d.tgl_act, '%d-%m-%Y %H:%i:%s') AS tgldiag
FROM b_diagnosa_act d 
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
INNER JOIN b_ms_pegawai p ON p.id = d.user_id
INNER JOIN b_ms_unit mu ON pl.unit_id = mu.id
WHERE d.kunjungan_id = '".$kunjungan_id."') AS gab $filter
order by act ASC, $sorting";
    }
	elseif($grdINACBG == "true") {
        $sql="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_id, t.pelayanan_id, t.ket, t.unit_act, tin.STR nama
        , tin.CODE kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id, t.type_dokter,t.tgl_act as tanggal, '' klasifikasi_id, peg.nama AS petugas
	FROM b_tindakan_inacbg t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	left JOIN mrconso tin ON tin.CODE = t.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$pelayanan_id."') as gab $filter order by $sorting";
    }
    elseif($grd2 == "true") {
        if($_REQUEST['isInap']=='1') {
	    $sql="select * from (SELECT distinct date_format(tk.tgl_in,'%d-%m-%Y') as tgl,b.id,u.nama as unit
	    ,b.jenis_layanan,b.unit_id,b.dokter_id,p.nama as dokter,b.ket, b.type_dokter, tk.kamar_id, tk.kelas_id
	    FROM b_pelayanan b
	    inner join b_ms_unit u on b.unit_id=u.id
	    left join b_ms_pegawai p on b.dokter_id=p.id
	    left join b_tindakan_kamar tk on b.id = tk.pelayanan_id
	    WHERE u.inap = 1 and b.kunjungan_id = '$kunjungan_id' and b.unit_id_asal='".$_REQUEST['unitAsal']."'
          and tk.unit_id_asal='".$_REQUEST['unitAsal']."') as gab $filter order by $sorting";
		//$inap=' and u.inap=1 ';
        }
        else {
	    $sql="select * from (SELECT distinct date_format(b.tgl,'%d-%m-%Y') as tgl,b.id,u.nama as unit,b.jenis_layanan,b.unit_id,b.dokter_id,p.nama as dokter,b.ket, b.type_dokter
	    FROM b_pelayanan b
	    inner join b_ms_unit u on b.unit_id=u.id
	    left join b_ms_pegawai p on b.dokter_id=p.id
	    WHERE u.inap = 0 and b.kunjungan_id = '$kunjungan_id' and b.unit_id_asal='".$_REQUEST['unitAsal']."') as gab $filter order by $sorting";
            //$inap=' and u.inap=0 ';
        }
        
    }
    elseif($grd3 == "true") {
        $sql="select * from (SELECT date_format(b.tgl_act, '%d-%m-%Y %H:%i:%s') as tgl, b.id,b.cara_keluar,b.keadaan_keluar,if(b.kasus=1,'Baru','Lama') as kasus,r.nama as emergency,f.nama as kondisi,t.nama as rs,b.rs_id,b.dokter_id,p.nama as dokter,b.ket
	FROM b_pasien_keluar b
	left join b_ms_tujuan_rujukan t on b.rs_id=t.id
	left join b_ms_pegawai p on b.dokter_id=p.id
	left join b_ms_reference r on b.emergency=r.id
	left join b_ms_reference f on b.kondisi=f.id	
	WHERE b.kunjungan_id = '".$kunjungan_id."' and pelayanan_id='".$pelayanan_id."') as gab $filter order by $sorting ";
    }
    elseif($grd4 == "true") {
         $sql="select * from
            (select b.id,b.tgl_in,b.tgl_out,b.kamar_id,b.nama,b.tarip,b.kelas_id,p.unit_id, u.parent_id
            from b_tindakan_kamar b inner join b_pelayanan p on b.pelayanan_id = p.id
            inner join b_ms_unit u on p.unit_id = u.id
            where p.kunjungan_id = '".$kunjungan_id."' and b.unit_id_asal = '".$_GET['unit_id']."') as gab $filter order by $sorting";
    }
    elseif($grdAnamnesa == "true") {	//Anamnese
         $sql = "SELECT a.*, DATE_FORMAT(a.TGL,'%d-%m-%Y %H:%i') AS tgltok, p.nama AS dokter
					FROM anamnese a 
				LEFT JOIN b_ms_pegawai p ON p.id = a.PEGAWAI_ID 
				WHERE a.PASIEN_ID = '".$_REQUEST['pasien_id']."' ORDER BY a.anamnese_id DESC";
    }
	elseif($grdResep == "true") {	//resep
        $sql = "select r.id,r.apotek_id,r.dokter_id,IF(r.racikan=0,'Bukan',CONCAT('Racikan',' ',r.racikan,' (',r.qty_bahan,' ',r.satuan,')')) as racikan,r.qty,r.ket_dosis,r.obat_id,r.dokter_nama,o.OBAT_NAMA,r.type_dokter,r.tgl
            from $dbbilling.b_resep r inner join $dbapotek.a_obat o on r.obat_id = o.obat_id
            where r.id_pelayanan = '".$_GET['pelayanan_id']."' AND r.no_resep = '".$no_resep."' AND r.apotek_id = '".$_REQUEST['apotek']."' AND r.tgl = '".$tgl_resep."'";
    }
	elseif($grdRsp1 =="true"){	//resep
		$sql = "SELECT b_resep.id, b_resep.no_resep, b_resep.tgl, DATE_FORMAT(b_resep.tgl,'%d-%m-%Y') AS tanggal, 
$dbapotek.a_unit.UNIT_ID,$dbapotek.a_unit.UNIT_NAME, IF(b_resep.status=0,'Belum Dilayani','Sudah Dilayani') STATUS, UNIT_TIPE, b_resep.status as status_id
FROM b_resep
INNER JOIN $dbapotek.a_unit ON $dbapotek.a_unit.UNIT_ID=$dbbilling.b_resep.apotek_id
WHERE b_resep.id_pelayanan = '".$pelayanan_id."' GROUP BY no_resep,tgl,apotek_id ORDER BY tgl DESC,no_resep DESC";
	}
	elseif($grdRsp2 =="true"){	//resep
		/*
		$sql = "SELECT b_resep.id, $dbapotek.a_obat.OBAT_NAMA, b_resep.qty, b_resep.ket_dosis, IF(b_resep.racikan=0,'Bukan',CONCAT('Racikan',' ',b_resep.racikan,' (',b_resep.qty_bahan,' ',b_resep.satuan,')')) AS racikan_nama, b_resep.dokter_nama, b_resep.kepemilikan_id, b_resep.apotek_id, b_resep.obat_id, b_resep.racikan, b_resep.status 
FROM b_resep
INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
WHERE b_resep.id_pelayanan = '".$pelayanan_id."' AND b_resep.no_resep='".$_REQUEST['no_resep']."' AND b_resep.apotek_id='".$_REQUEST['apotek_id']."' AND b_resep.tgl='".$_REQUEST['tgl_resep']."' ORDER BY $dbapotek.a_obat.OBAT_ID";
		*/
		$sql = "SELECT b_resep.id, IFNULL($dbapotek.a_obat.OBAT_NAMA,b_resep.obat_manual) OBAT_NAMA, b_resep.qty, b_resep.ket_dosis, IF(b_resep.racikan=0,'Bukan',IF(b_resep.obat_id=0,'Racikan',CONCAT('Racikan',' ',b_resep.racikan,' (',b_resep.qty_bahan,' ',b_resep.satuan,')'))) AS racikan_nama, b_resep.dokter_nama, b_resep.kepemilikan_id, b_resep.apotek_id, b_resep.obat_id, b_resep.racikan, b_resep.status 
FROM b_resep
LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
WHERE b_resep.id_pelayanan = '".$pelayanan_id."' AND b_resep.no_resep='".$_REQUEST['no_resep']."' AND b_resep.apotek_id='".$_REQUEST['apotek_id']."' AND b_resep.tgl='".$_REQUEST['tgl_resep']."'";
	}

    //echo $sql."<br>";
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

	$j=0;
    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $jnsLay="select * from b_ms_unit where id='".$rows['ms_tindakan_unit_id']."'";
            $rsJns=mysql_query($jnsLay);
            $rwJns=mysql_fetch_array($rsJns);
		  
		  $dokter = $rows["dokter"];
		  $dokter_an = '';
		  $sql_an = "select dokter_id,nama from b_tindakan_dokter_anastesi da inner join b_ms_pegawai pg on da.dokter_id = pg.id where tindakan_id = '".$rows['id']."'";
		  $rs_an = mysql_query($sql_an);
		  if(mysql_num_rows($rs_an) > 0){
			 $dokter .= "<br>Dokter Anastesi:";
			 while($row_an = mysql_fetch_array($rs_an)){
				$dokter .= '<br> - '.$row_an["nama"];
				$dokter_an .= $row_an['dokter_id'].',';
			 }
			 $dokter_an = substr($dokter_an,0,strlen($dokter_an)-1);
		  }
		  
			$dataicd9cm=$rows["icd9cm"];
			$sudah=1;
			if ($dataicd9cm=="-" || $dataicd9cm==""){ 
				$dataicd9cm="[          -          ]";
				$sudah=0;
			}
			$css="style='text-decoration:none'";
			if($rows["act"]=='1'){
				$css="style='text-decoration:line-through'";
			}
			$xxxicd9cm = "";
			$icd9rm=$dataicd9cm;
			if($rows["act"]=='0'){
				$xxxicd9cm="<input type='hidden' id='xxxicd9cm_$rows[id]' value='".$sudah."'>";
				$icd9rm="<span style='color:#0000FF' title='Klik Untuk Mengubah ICD-9CM' onclick='fSetICD_9CM(".$rows["id"].");'>".$dataicd9cm."</span>";
			}

            $sisip = $rows['id']."|".$rows['ms_tindakan_kelas_id']."|".$rows['ms_tindakan_unit_id']."|".$rwJns['parent_id']."|".$rows['user_id']."|".$rows['kunjungan_id']."|".$rows['unit_act']."|".$rows['type_dokter']."|".$rows['klasifikasi_id'].'|'.$dokter_an;
            $i++;
            $dt.=$sisip.chr(3)."<span $css>".number_format($i,0,",","")."</span>".chr(3)."<span $css>".tglJamSQL($rows["tanggal"])."</span>".chr(3)."<span $css>".$rows["nama"]."</span>".chr(3)."<span $css>".$xxxicd9cm.$icd9rm."</span>".chr(3)."<span $css>".$rows["kelas"]."</span>".chr(3)."<span $css>".$rows["biaya"]."</span>".chr(3)."<span $css>".$rows["qty"]."</span>".chr(3)."<span $css>".$rows["subtotal"]."</span>".chr(3)."<span $css>".$dokter."</span>".chr(3)."<span $css>".$rows["petugas"]."</span>".chr(3)."<span $css>".$rows["ket"]."</span>".chr(6);
        }
    }
	elseif($grdINACBG == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $jnsLay="select * from b_ms_unit where id='".$rows['ms_tindakan_unit_id']."'";
            $rsJns=mysql_query($jnsLay);
            $rwJns=mysql_fetch_array($rsJns);
		  
		  $dokter = $rows["dokter"];
		  $dokter_an = '';
		  $sql_an = "select dokter_id,nama from b_tindakan_dokter_anastesi da inner join b_ms_pegawai pg on da.dokter_id = pg.id where tindakan_id = '".$rows['id']."'";
		  $rs_an = mysql_query($sql_an);
		  if(mysql_num_rows($rs_an) > 0){
			 $dokter .= "<br>Dokter Anastesi:";
			 while($row_an = mysql_fetch_array($rs_an)){
				$dokter .= '<br> - '.$row_an["nama"];
				$dokter_an .= $row_an['dokter_id'].',';
			 }
			 $dokter_an = substr($dokter_an,0,strlen($dokter_an)-1);
		  }

            $sisip = $rows['id']."|".$rows['ms_tindakan_id']."|".$rows['ms_tindakan_unit_id']."|".$rwJns['parent_id']."|".$rows['user_id']."|".$rows['kunjungan_id']."|".$rows['unit_act']."|".$rows['type_dokter']."|".$rows['klasifikasi_id'].'|'.$dokter_an;
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglJamSQL($rows["tanggal"]).chr(3).$rows["nama"].chr(3).$rows["qty"].chr(3).$dokter.chr(3).$rows["petugas"].chr(3).$rows["ket"].chr(6);
        }
    }
    elseif($grd1 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
			$cek="SELECT * FROM b_ms_diagnosa_gol WHERE DG_TIPE=1 AND DG_KODE='".$rows['dg_kode']."'";
			$qCek=mysql_query($cek);
			$rCek=mysql_fetch_array($qCek);
			$isPK = 0;
			if(mysql_num_rows($qCek)>0){
				$gol_id = $rCek['DG_KODE']; 
				$gol = $rCek['DG_NAMA'];
				$isPK = 1;
			}
			$dataicdrm=$rows["icdrm"];
			$sudah=1;
			if ($dataicdrm=="-"){ 
				$dataicdrm="[          -          ]";
				$sudah=0;
			}
			
			$css="style='text-decoration:none'";
			if($rows["act"]=='1'){
				$css="style='text-decoration:line-through'";
			}
			
			$datakasusicdrm=$rows["d_kasus"];
			if ($datakasusicdrm=="-") $datakasusicdrm="[          -          ]";
			$icdrm=$dataicdrm;
			$xxxicdrm="";
			$kasusicdrm=$datakasusicdrm;
			if($rows["act"]=='0'){
				$icdrm="<span style='color:#0000FF' title='Klik Untuk Mengubah ICD-10' onclick='fSetICD_RM(".$rows["id"].");'>".$dataicdrm."</span>";
				$xxxicdrm="<input type='hidden' id='xxxicdrm_$rows[id]' value='".$sudah."'>";
				$kasusicdrm="<span style='color:#0000FF' title='Klik Untuk Mengubah Kasus ICD-10' onclick='fSetKasusICD_RM(".$rows["id"].");'>".$datakasusicdrm."</span>";
			}
            $sisip=$rows["id"]."|".$rows['user_id']."|".$rows['ms_diagnosa_id']."|".$rows['type_dokter']."|".$rows['primer']."|".$rows['akhir']."|".$gol_id."|".$gol."|".$isPK;
            $i++;
			
            $dt.=$sisip.chr(3)."<span $css>".number_format($i,0,",","")."</span>".chr(3)."<span $css>".$rows["tgldiag"]."</span>".chr(3)."<span $css>".$rows["nama"]."</span>".chr(3)."<span $css>".$xxxicdrm.$icdrm."</span>".chr(3)."<span $css>".$rows["dokter"]."</span>".chr(3)."<span $css>".$rows["utama"]."</span>".chr(3)."<span $css>".$kasusicdrm."</span>".chr(3)."<span $css>".$rows['d_akhir']."</span>".chr(3)."<span $css>".$rows['klinis']."</span>".chr(3)."<span $css>".$rows['banding']."</span>".chr(3)."<span $css>".$rows['unit']."</span>".chr(6);
        }
    }
    elseif($grd2 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["id"]."|".$rows['jenis_layanan']."|".$rows['unit_id']."|".$rows['dokter_id']."|".$rows['type_dokter'].'|'.$rows['kelas_id'].'|'.$rows['kamar_id'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["unit"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(6);
        }
    }
    elseif($grd3 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows["id"]."|".$rows['rs_id']."|".$rows['dokter_id']."|".$rows['type_dokter'].chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["cara_keluar"].chr(3).$rows["keadaan_keluar"].chr(3).$rows["kasus"].chr(3).$rows["rs"].chr(3).$rows["dokter"].chr(3).$rows["emergency"].chr(3).$rows["kondisi"].chr(3).$rows["ket"].chr(6);
        }
    }
    elseif($grd4 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $sisip=$rows["id"]."|".$rows['kamar_id']."|".$rows['kelas_id']."|".$rows['type_dokter'].'|'.$rows['unit_id'].'|'.$rows['parent_id'];
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_in"].chr(3).$rows["tgl_out"].chr(3).$rows["nama"].chr(3).$rows["tarip"].chr(6);
        }
    }
    elseif($grdAnamnesa == "true") {	//Anamnese
        while($rows=mysql_fetch_array($rs)) {
            $sisipan = $rows["ANAMNESE_ID"]."|".$rows['KUNJ_ID']."|".$rows['PEL_ID']."|".$rows['PASIEN_ID']."|".$rows['PEGAWAI_ID']."|".
			$rows['KU']."|".$rows['SOS']."|".$rows['RPS']."|".$rows['RPD']."|".$rows['RPK']."|".$rows['RA']."|".$rows['KUM']."|".$rows['GCS']."|".$rows['KESADARAN']."|".$rows['TENSI']."|".$rows['RR']."|".$rows['NADI']."|".$rows['SUHU']."|".$rows['BB']."|".$rows['GIZI']."|".$rows['KL']."|".$rows['COR']."|".$rows['PULMO']."|".$rows['INSPEKSI']."|".$rows['PALPASI']."|".$rows['AUSKULTASI']."|".$rows['PERKUSI']."|".$rows['EXT'];
            $i++;
            $dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["tgltok"].chr(3).$rows['dokter'].chr(6);
        }
    }elseif($grdResep == "true") {	//resep
        while($rows=mysql_fetch_array($rs)) {
            $sisipan=$rows["id"]."|".$rows['qty']."|".$rows['obat_id']."|".$rows['harga_jual']."|".$rows['stok']."|".$rows['apotek_id']."|".$rows["dokter_id"]."|".$rows['type_dokter']."|".$rows['tgl'];
            $i++;
            $dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["OBAT_NAMA"].chr(3).$rows['qty'].chr(3).$rows["racikan"].chr(3).$rows['ket_dosis'].chr(3).$rows["dokter_nama"].chr(6);
        }
    }elseif($grdRsp1 == "true") {	//resep
        while($rows=mysql_fetch_array($rs)) {
            $i++;
			$id=$rows["UNIT_ID"]."|".$rows['tgl']."|".$rows['no_resep']."|".$rows['UNIT_TIPE']."|".$rows['status_id'];
            $dt.=$id.chr(3).number_format($i,0,",","").chr(3).$rows["no_resep"].chr(3).$rows['tanggal'].chr(3).$rows["UNIT_NAME"].chr(3).$rows["STATUS"].chr(6);
        }
    }elseif($grdRsp2 == "true") {	//resep
        while($rows=mysql_fetch_array($rs)) {
            $i++;
			$j++;
			
			$sqlHarga="SELECT IFNULL(SUM(qty_stok),0) stok FROM $dbapotek.a_stok WHERE unit_id=".$rows["apotek_id"]." AND obat_id=".$rows["obat_id"]." AND kepemilikan_id=".$rows["kepemilikan_id"];
			$rsHarga=mysql_query($sqlHarga);
			$rwHarga=mysql_fetch_array($rsHarga);
			$hStok=$rwHarga["stok"];
			
			
			if($rows['status']!=0){
				$dis="disabled='disabled'";
				$ch="checked='checked'";	
			}else{
				$dis="";
				$ch="";
			}
			
			$cedit="&nbsp;|&nbsp;<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Mengubah Resep' onclick=EditObat('".$rows["id"]."|".$rows["kepemilikan_id"]."|".$rows["qty"]."|".$i."') />";
			$d="<input type='checkbox' id='ch".$rows["id"]."'".$dis.$ch." title='Centang Untuk Melayani Resep' onclick='CheckedObat($j);' />".$cedit;
			
			$sqlHarga2="SELECT FLOOR(HARGA_JUAL_SATUAN) HARGA_JUAL_SATUAN,FLOOR(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN FROM $dbapotek.a_harga WHERE OBAT_ID=".$rows["obat_id"]." AND KEPEMILIKAN_ID=".$rows["kepemilikan_id"]." ORDER BY HARGA_JUAL_SATUAN DESC LIMIT 1";
			$rsHarga2=mysql_query($sqlHarga2);
			$rwHarga2=mysql_fetch_array($rsHarga2);
			$hSatuan=$rwHarga2["HARGA_JUAL_SATUAN"];
			$hNetto=$rwHarga2["HARGA_BELI_SATUAN"];
			
			$sisip=$rows["id"]."|".$hSatuan."|".$hNetto."|".$rows["qty"]."|".$rows["kepemilikan_id"]."|".$rows["obat_id"]."|".$rows["racikan"]."|".($hSatuan*$rows["qty"]);
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["OBAT_NAMA"].chr(3).$rows['qty'].chr(3).$rows['racikan_nama'].chr(3).$rows['ket_dosis'].chr(3).$rows['dokter_nama'].chr(3).$hStok.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp."*|*".$id_tindakan_radiologi."*|*".$tgl_resep;
        $dt=str_replace('"','\"',$dt);
    }

    mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>

<?php
include("../koneksi/konek.php");
//====================================================================
$idKunj=$_REQUEST['idKunj'];
$cstatusPx=$_REQUEST['cstatusPx'];
$cTglSJP=tglSQL($_REQUEST['cTglSJP']);
$ccmbHakKelas=$_REQUEST['ccmbHakKelas'];
$cNoSJP=$_REQUEST['cNoSJP'];
$cNoJaminan=$_REQUEST['cNoJaminan'];
$cStatusPenj=$_REQUEST['cStatusPenj'];
$cnmPeserta=$_REQUEST['cnmPeserta'];
$cJenisKunj=$_REQUEST['cJenisKunj'];
$strcNoSJP="'$cNoSJP'";
if ($cstatusPx=="1"){
	$ccmbHakKelas="1";
	$cNoSJP="";
	$cNoJaminan="";
	$cStatusPenj="";
	$cnmPeserta="";
	$strcNoSJP="''";
}elseif($cstatusPx=="53"){
	$strcNoSJP="fGetMaxNoJPersal('$cTglSJP')";
}
$IdPasien=$_REQUEST['IdPasien'];
//===============================
$dt="Proses Update Berhasil !";
$sql="SELECT * FROM b_kunjungan WHERE id=$idKunj";
//echo $sql."<br>";
$rs=mysql_query($sql);
$rwK=mysql_fetch_array($rs);
$sqlSimpan="update b_kunjungan set kso_id=$cstatusPx,kso_kelas_id='$ccmbHakKelas',tgl_sjp='$cTglSJP',no_sjp=$strcNoSJP,no_anggota='$cNoJaminan',status_penj='$cStatusPenj',nama_peserta='$cnmPeserta' where id=$idKunj";
/*$sqlSimpan="update b_kunjungan set kso_id=$cstatusPx,kso_kelas_id='$ccmbHakKelas',tgl_sjp='$cTglSJP',no_sjp='$cNoSJP',no_anggota='$cNoJaminan',status_penj='$cStatusPenj',nama_peserta='$cnmPeserta' where id=$idKunj";*/
//echo $sqlSimpan."<br>";
$rs=mysql_query($sqlSimpan);
if (mysql_errno()>0){
	$dt="Proses Update Gagal !";
}
if ($cstatusPx!="1"){
	$sql="SELECT * FROM b_ms_kso_pasien WHERE pasien_id=$IdPasien";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	if (mysql_errno()>0){
		$dt="Proses Update Gagal !";
	}
	if (mysql_num_rows($rs)>0){
		$rw=mysql_fetch_array($rs);
		
			$sqlInsertKso="update b_ms_kso_pasien set kso_id=$cstatusPx,kelas_id=$ccmbHakKelas,no_anggota='$cNoJaminan',st_anggota='$cStatusPenj',nama_peserta='$cnmPeserta' where pasien_id=$IdPasien";
			//echo $sqlInsertKso."<br>";
			$rsInsertKso=mysql_query($sqlInsertKso);			
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
	}
}

//$sql="SELECT * FROM b_pelayanan WHERE kunjungan_id=$idKunj AND tgl>='$cTglSJP'";
//$sql="SELECT DISTINCT p.* FROM b_pelayanan p INNER JOIN b_tindakan t ON p.id=t.pelayanan_id WHERE p.kunjungan_id=$idKunj AND t.tgl>='$cTglSJP'";
$fJenisKunj=" AND p.jenis_kunjungan='3'";
if ($cJenisKunj==2) $fJenisKunj="";
$sql="SELECT DISTINCT p.* FROM b_pelayanan p INNER JOIN b_tindakan t ON p.id=t.pelayanan_id WHERE p.kunjungan_id=$idKunj".$fJenisKunj." AND t.tgl>='$cTglSJP'";
//echo $sql."<br>";
$rs=mysql_query($sql);
if (mysql_errno()>0){
	$dt="Proses Update Gagal !";
}
while ($rw=mysql_fetch_array($rs)){
	$unitId=$rw['unit_id'];
	$ckelas=$rw['kelas_id'];

	if ($cstatusPx=="1"){//UMUM
		//echo "Umum"."<br>";
		$sql="UPDATE b_pelayanan SET kso_id=$cstatusPx WHERE id='".$rw['id']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		$sql="SELECT * FROM b_tindakan WHERE pelayanan_id='".$rw['id']."' AND lunas=0";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		while ($rw1=mysql_fetch_array($rs1)){
			$sql="UPDATE b_tindakan SET kso_id=$cstatusPx,kso_kelas_id=1,biaya_kso=0,biaya_pasien=biaya WHERE id='".$rw1['id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
		}
		$sql="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='".$rw['id']."'";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		while ($rw1=mysql_fetch_array($rs1)){
			$sql="UPDATE b_tindakan_kamar SET kso_id='$cstatusPx',beban_kso=0,beban_pasien=tarip WHERE id='".$rw1['id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
		}
	}elseif ($cstatusPx!="4"){//SELAIN UMUM + ASKES SOSIAL
		//echo "Non Askes Non Umum"."<br>";
		$sql="UPDATE b_pelayanan SET kso_id=$cstatusPx WHERE id='".$rw['id']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
			//echo $dt."<br>";
		}
		$sql="SELECT t.*,mtk.ms_kelas_id,mtk.ms_tindakan_id FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id WHERE t.pelayanan_id='".$rw['id']."' and t.tgl>='$cTglSJP'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
			//echo $dt."<br>";
		}
		while ($rw1=mysql_fetch_array($rs1)){
			$biaya_kso=$rw1['biaya'];
			$biaya_RS=$rw1['biaya'];
			$biaya_pasien=0;
			
			$sql="SELECT * FROM b_ms_tindakan_tdk_jamin WHERE b_ms_kso_id='$cstatusPx' AND b_ms_tindakan_id=(SELECT ms_tindakan_id FROM b_ms_tindakan_kelas WHERE id = '".$rw1['ms_tindakan_kelas_id']."')";
			//echo $sql."<br>";
			$rs3=mysql_query($sql);
			if (mysql_num_rows($rs3)>0){
				$biaya_kso=0;
				$biaya_pasien=$biaya_RS;
			}else{
				$sql="SELECT parent_id FROM b_ms_unit WHERE id='".$rw['unit_id']."'";
				//echo $sql."<br>";
				$rs2=mysql_query($sql);
				$rw2=mysql_fetch_array($rs2);
				$parentId=$rw2["parent_id"];
				
				if ($parentId != 94 && $rw['unit_id'] != 112 && $rw['unit_id'] != 48){
					$sql="SELECT * FROM b_ms_tindakan_kelas WHERE ms_tindakan_id=".$rw1['ms_tindakan_id']." AND ms_kelas_id='$ccmbHakKelas'";
					//echo $sql."<br>";
					$rs2=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal !";
						//echo $dt."<br>";
					}
					if (mysql_num_rows($rs2)>0){
						$idTindKls=$rw1['ms_tindakan_kelas_id'];
						$sql="SELECT * FROM b_ms_tindakan_kelas WHERE id = $idTindKls";
						//echo $sql."<br>";
						$rs3=mysql_query($sql);
						if (mysql_errno()>0){
							$dt="Proses Update Gagal !";
						}
						$rw3=mysql_fetch_array($rs3);
						$biayaRs=$rw3['tarip'];
						$idTind=$rw3['ms_tindakan_id'];
						
						$sql="SELECT nilai,kp.id FROM b_ms_kso_paket_detail pd INNER JOIN b_ms_kso_paket kp ON pd.kso_paket_id = kp.id WHERE pd.ms_tindakan_id = '".$idTind."' AND kp.kso_id = '$cstatusPx'";
						$rs3=mysql_query($sql);
						if (mysql_num_rows($rs3)>0){
							$rw3=mysql_fetch_array($rs3);
							//$biaya_kso = 3050000;
							$biaya_kso = $rw3['nilai'];
						}else{
							$sqlASos = "SELECT lp.nilai
								FROM b_ms_kso_luar_paket lp where lp.kso_id = '$cstatusPx' and lp.ms_tindakan_id = '".$idTind."'";
							//echo $sqlASos."<br>";
							$rsASos = mysql_query($sqlASos);
							if (mysql_errno()>0){
								$dt="Proses Update Gagal !";
							}
							if(mysql_num_rows($rsASos) > 0) {
								$rowASos = mysql_fetch_array($rsASos);
								$biaya_kso = $rowASos['nilai'];
								mysql_free_result($rsASos);
							}else{
								$rw2=mysql_fetch_array($rs2);
								$biaya_kso=$rw2['tarip'];
							}
						}
					}
				}
			}
			
			if (($biaya_RS>$biaya_kso) && ($cstatusPx!=38) && ($cstatusPx!=39) && ($cstatusPx!=46) && ($cstatusPx!=53) && ($cstatusPx!=64)){
				$biaya_pasien=$biaya_RS-$biaya_kso;
			}
			$sql="UPDATE b_tindakan SET kso_id=$cstatusPx,kso_kelas_id=$ccmbHakKelas,biaya_kso=$biaya_kso,biaya_pasien=$biaya_pasien,bayar=0,bayar_pasien=0,lunas=0 WHERE id='".$rw1['id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
				//echo $dt."<br>";
			}
		}
		
		$sql="SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='".$rw['id']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
			//echo $dt."<br>";
		}
		while ($rw1=mysql_fetch_array($rs1)){
			$biaya_kso=$rw1['tarip'];
			$biaya_RS=$rw1['tarip'];
			$biaya_pasien=0;
			
			$sql="SELECT parent_id FROM b_ms_unit WHERE id='".$rw['unit_id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			$rw2=mysql_fetch_array($rs2);
			$parentId=$rw2["parent_id"];
			
			if ($parentId != 94 && $rw['unit_id'] != 112 && $rw['unit_id'] != 48){
				if ($parentId == 50){
					$sql="SELECT DISTINCT mkt.tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id=27 AND kelas_id='$ccmbHakKelas'";
				}else{
					$sql="SELECT DISTINCT mkt.tarip FROM b_ms_kamar_tarip mkt INNER JOIN b_ms_unit mu ON mkt.unit_id=mu.id WHERE mu.parent_id=(SELECT parent_id FROM b_ms_unit WHERE id='".$rw['unit_id']."') AND kelas_id='$ccmbHakKelas'";
				}
				//echo $sql."<br>";
				$rs2=mysql_query($sql);
				if (mysql_errno()>0){
					$dt="Proses Update Gagal !";
					//echo $dt."<br>";
				}
				if (mysql_num_rows($rs2)>0){
					$rw2=mysql_fetch_array($rs2);
					$biaya_kso=$rw2['tarip'];
				}
			}
			
			if (($biaya_RS>$biaya_kso) && ($cstatusPx!=38) && ($cstatusPx!=39) && ($cstatusPx!=46) && ($cstatusPx!=53)){
				$biaya_pasien=$biaya_RS-$biaya_kso;
			}
			$sql="UPDATE b_tindakan_kamar SET kso_id='$cstatusPx',beban_kso=$biaya_kso,beban_pasien=$biaya_pasien,bayar=0,bayar_pasien=0,lunas=0 WHERE id='".$rw1['id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
				//echo $dt."<br>";
			}
		}
	}else{//ASKES SOSIAL
		//echo "Askes"."<br>";
		$sql="UPDATE b_pelayanan SET kso_id=$cstatusPx WHERE id='".$rw['id']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		$sql="SELECT *,IF(status_out=0,IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)),IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))) AS qtyHari,tgl_in FROM b_tindakan_kamar WHERE pelayanan_id='".$rw['id']."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		$paketHp=0;
		$kamarRs=0;
		$kamarRsPerHari=0;
		$bbnKmrPasien=0;
		while ($rw1=mysql_fetch_array($rs1)){
			if ($rw1['tarip']==0){
				$sql="SELECT mkt.kamar_id,mkt.tarip FROM b_ms_kamar_tarip mkt WHERE mkt.unit_id='".$rw['unit_id']."' AND mkt.kelas_id='".$rw['kelas_id']."' LIMIT 1";
				//echo $sql."<br>";
				$rs2=mysql_query($sql);
				if (mysql_errno()>0){
					$dt="Proses Update Gagal !";
				}
				if ($rw2=mysql_fetch_array($rs2)){
					$kamarRs+=$rw1['qtyHari'] * $rw2['tarip'];
					$kamarRsPerHari=$rw2['tarip'];
					$sql="UPDATE b_tindakan_kamar SET kso_id='$cstatusPx',tarip='".$rw2['tarip']."' WHERE id='".$rw1['id']."'";
					//echo $sql."<br>";
					$rs2=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal !";
					}
				}
			}else{
				$kamarRs+=$rw1['qtyHari'] * $rw1['tarip'];
				$kamarRsPerHari=$rw1['tarip'];
			}
			//====IPIT/ROI IGD/ICU IGD========
			if ($rw['jenis_layanan']=="94" || $rw['unit_id'] == 112 || $rw['unit_id'] == 48){
				$sql="SELECT * FROM b_ms_kso_paket_hp WHERE b_ms_kelas_id = 10 AND b_ms_kso_id=4";
			}else{
				$sql="SELECT * FROM b_ms_kso_paket_hp WHERE b_ms_kelas_id = $ccmbHakKelas AND b_ms_kso_id=4";
			}
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
			if (mysql_num_rows($rs2)>0){
				$rw2=mysql_fetch_array($rs2);
				$paketHp+=$rw2['jaminan'] * $rw1['qtyHari'];
				$biaya_pasien = 0;
				if ($kamarRsPerHari>$rw2['jaminan']){
					$biaya_pasien = $kamarRsPerHari - $rw2['jaminan'];
				}
				//===jika hak_kelas=kelas 2, naik ke kelas 1=====
				if ($rw1['kelas_id']==2 && $ccmbHakKelas==3){
					$biaya_pasien = 100000;
				}
				
				if ($rw1['tgl_in']<$cTglSJP && $rw1['kso_id']==1){
					if (substr($rw1['tgl_out'],0,10)>$cTglSJP || $rw1['tgl_out']==""){
						$sql="INSERT INTO b_tindakan_kamar(pelayanan_id,unit_id_asal,kso_id,tgl_in,tgl_out,kamar_id,kode,nama,tarip,beban_kso,beban_pasien,kelas_id,status_out,aktif) 
	SELECT pelayanan_id,unit_id_asal,kso_id,tgl_in,'$cTglSJP',kamar_id,kode,nama,tarip,0,beban_pasien,kelas_id,1,1
	FROM b_tindakan_kamar WHERE id='".$rw1['id']."'";
						//echo $sql."<br>";
						$rs2=mysql_query($sql);
						
						$bbnKmrPasien=$biaya_pasien * $rw1['qtyHari'];
						$sql="UPDATE b_tindakan_kamar SET kso_id='$cstatusPx',tgl_in='$cTglSJP',beban_kso='".$rw2['jaminan']."',beban_pasien=$biaya_pasien WHERE id='".$rw1['id']."'";
						//echo $sql."<br>";
						$rs2=mysql_query($sql);
					}
				}else{
					$bbnKmrPasien=$biaya_pasien * $rw1['qtyHari'];
					$sql="UPDATE b_tindakan_kamar SET kso_id='$cstatusPx',beban_kso='".$rw2['jaminan']."',beban_pasien=$biaya_pasien WHERE id='".$rw1['id']."'";
					//echo $sql."<br>";
					$rs2=mysql_query($sql);
				}
				if (mysql_errno()>0){
					$dt="Proses Update Gagal !";
				}
			}
		}
		$iurPas=0;
		$sql="SELECT t.*,mtk.ms_kelas_id FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id WHERE t.pelayanan_id='".$rw['id']."' order by t.id";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal !";
		}
		while ($rw1=mysql_fetch_array($rs1)){
			$biaya_kso = 0;
			$biaya_pasien = 0;
			$biaya_RS = $rw1['biaya'];
			$bayar_kso = 0;
			//$ckelas=$rw1['ms_kelas_id'];
			$cqtyTind=$rw1['qty'];
			$cJenisKunj=$rw1['jenis_kunjungan'];
			
			$id=$rw1['id'];
			//echo "rw1=".$id."<br>";
			
			$idTindKls=$rw1['ms_tindakan_kelas_id'];
			$sql="SELECT * FROM b_ms_tindakan_kelas WHERE id = $idTindKls";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
			$rw2=mysql_fetch_array($rs2);
			$biayaRs=$rw2['tarip'];
			$idTind=$rw2['ms_tindakan_id'];
//=======================================================================================
			$sqlCek = "select * from b_ms_kso_pakomodasi where ms_kso_id = '4' and ms_tindakan_id = $idTind";
			//echo $sqlCek."<br>";
			$rsCek = mysql_query($sqlCek);
			//jika hasil lebih dari 0 -> termasuk akomodasi
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
			if(mysql_num_rows($rsCek) <= 0) {
				$sqlASos = "SELECT nilai,kp.id FROM b_ms_kso_paket_detail pd INNER JOIN b_ms_kso_paket kp ON pd.kso_paket_id = kp.id WHERE pd.ms_tindakan_id = '".$idTind."' AND kp.kso_id = 4";
				//echo $sqlASos."<br>";
				$rsASos = mysql_query($sqlASos);
				if (mysql_errno()>0){
					$dt="Proses Update Gagal !";
				}
				$res = mysql_num_rows($rsASos);
				if($res > 0) {
					$rowASos = mysql_fetch_array($rsASos);
					$biaya_kso = $rowASos['nilai'];
					$idpaket = $rowASos['id'];
					//===================pindah kelas======================
					//echo "hak kelas : ".$ccmbHakKelas.", kelas : ".$ckelas."<br>";
					if(((($ccmbHakKelas > $ckelas) && ($ckelas<4)) || (($ccmbHakKelas != $ckelas) && ($ckelas>4))) && ($ckelas != 1)) {
						if ($cJenisKunj==3){
							if ($ckelas==2 && $ccmbHakKelas==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
								$biaya_pasien = 0;
							}elseif(($biaya_RS > $biaya_kso)){	//===jika kelas pavilyun=====
								$biaya_pasien = $biaya_RS - $biaya_kso;
							}
						}
						/*----paket IIA / IIB / IIC & RI naik kelas-----*/
						/*if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
							if($biaya_RS > $biaya_kso){
								$biaya_pasien = $biaya_RS - $biaya_kso;
							}
						}*/
						/*if (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj==3)){
							$biaya_kso = 0;
							$biaya_pasien = $biaya_RS;
						}elseif($biaya_RS > $biaya_kso){
							$biaya_pasien = $biaya_RS - $biaya_kso;
						}*/
						//$biaya_pasien = $biaya_RS - $biaya_kso;
					}elseif (($idpaket==3) && ($cJenisKunj==3)){
						/*----RI paket IIA ikut akomodasi-----*/
						$biaya_kso = 0;
						$biaya_pasien = 0;
					}elseif (($idpaket==3 || $idpaket==4 || $idpaket==5) && ($cJenisKunj!=3)){
						/*----RJ paket II 1 hari 1 klaim-----*/
						$sqlCPaket="SELECT t1.* FROM (SELECT t.id,t.ms_tindakan_kelas_id,t.tgl FROM b_tindakan t WHERE t.kunjungan_id='$idKunj') AS t1 
INNER JOIN b_ms_tindakan_kelas mtk ON t1.ms_tindakan_kelas_id=mtk.id 
INNER JOIN b_ms_kso_paket_detail pd ON mtk.ms_tindakan_id=pd.ms_tindakan_id 
WHERE pd.kso_paket_id=$idpaket AND t1.id<$id AND t1.tgl='".$rw1['tgl']."'";
						//echo $sqlCPaket."<br>";
						$rsCPaket=mysql_query($sqlCPaket);
						if (mysql_num_rows($rsCPaket)>0){
							$biaya_kso = 0;
							$biaya_pasien = 0;
						}
					}
					//=====================================================
					mysql_free_result($rsASos);
				}
				else {
					$sqlASos = "SELECT lp.nilai
						FROM b_ms_kso_luar_paket lp where lp.kso_id = 4 and lp.ms_tindakan_id = '".$idTind."'";
					//echo $sqlASos."<br>";
					$rsASos = mysql_query($sqlASos);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal !";
					}
					if(mysql_num_rows($rsASos) > 0) {
						$rowASos = mysql_fetch_array($rsASos);
						$biaya_kso = $rowASos['nilai'];
						//===================pindah kelas======================
						if(($ccmbHakKelas != $ckelas) && ($ckelas != 1) && ($biaya_RS > $biaya_kso)) {
							if ($ckelas==2 && $ccmbHakKelas==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
								$biaya_pasien = 0;
							}else{	//===jika kelas pavilyun=====
								$biaya_pasien = $biaya_RS - $biaya_kso;
							}
						}
						//=====================================================
						mysql_free_result($rsASos);
					}
					else {
						$biaya_pasien = $biaya_RS;
					}
				}
			}else{
				if(($ccmbHakKelas != $ckelas) && ($ckelas != 1) && ($rw['jenis_layanan']!=94) && ($rw['unit_id'] != 112) && ($rw['unit_id'] != 48)) {
					//============paket akomodasi tp pindah kelas==================
					$sql="SELECT SUM(t.biaya*t.qty) AS paketSos FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
WHERE t.pelayanan_id='".$rw['id']."' AND mtk.ms_tindakan_id IN (SELECT ms_tindakan_id FROM b_ms_kso_pakomodasi WHERE ms_kso_id=4) AND t.id<=$id";
					//echo $sql."<br>";
					$rs2=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal !";
					}
					if ($rw2=mysql_fetch_array($rs2)){
						if ($ckelas==2 && $ccmbHakKelas==3){	//===jika hak_kelas=kelas 2, naik ke kelas 1=====
							$biaya_pasien = 0;
						}elseif (($rw2['paketSos']+$kamarRs)>($paketHp+$bbnKmrPasien)){
							$biaya_pasien = ($rw2['paketSos']+$kamarRs) - ($iurPas+$paketHp+$bbnKmrPasien);
							$iurPas+=$biaya_pasien;
							$biaya_pasien = $biaya_pasien/$cqtyTind;
						}
					}
				}
			}
//====================================================
			
			$sql="UPDATE b_tindakan SET kso_id=$cstatusPx,kso_kelas_id=$ccmbHakKelas,biaya_kso=$biaya_kso,biaya_pasien=$biaya_pasien,bayar=0,bayar_pasien=0,lunas=0 WHERE id='".$rw1['id']."'";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal !";
			}
		}
	}
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
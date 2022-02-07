<?php
include("../koneksi/konek.php");
include("distribusiBiayaKsoPx.php");
//====================================================================
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$kode_grouper=$_REQUEST['kode_grouper'];
$jenis_lay_IPIT=94;
$jenis_lay_Pav=50;
//===============================
$dt="Proses Update Berhasil !"."|".$kode_grouper;
$sql="SELECT * FROM b_kunjungan WHERE id=$idKunj";
//echo $sql."<br>";
$rs=mysql_query($sql) or die( mysql_error()." - 14" );
$rwK=mysql_fetch_array($rs);
$sql="SELECT k.kso_id,k.kso_kelas_id,p.kelas_id,p.jenis_layanan FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE k.id='$idKunj' AND mu.inap=1 AND p.jenis_layanan<>$jenis_lay_IPIT AND p.kelas_id>=2 AND p.kelas_id<=9 ORDER BY p.id DESC LIMIT 1";
//echo $sql.";<br>";
$rs=mysql_query($sql) or die( mysql_error()." - 18" );
if (mysql_errno()>0){
	$dt="Proses Update Gagal ! 1";
}else{
	if (mysql_num_rows($rs)>0){
		$rw=mysql_fetch_array($rs);
		//$kso_kelas_id=$rw["kso_kelas_id"];
		//$kelas_id=$rw["kelas_id"];
		
		/* ======================= HAK KELAS ======================== */
		$sHakKelas="SELECT id,level,nama FROM (
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				inner join b_ms_kelas mk ON mk.id=t.kso_kelas_id
				WHERE p.kunjungan_id='$idKunj' 
				AND kso.id={$idKsoBPJS}
				AND mk.tipe=0
				UNION
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				inner join b_ms_kelas mk ON mk.id=tk.kso_kelas_id
				WHERE p.kunjungan_id='$idKunj'
				AND kso.id={$idKsoBPJS}
				AND mk.tipe=0) AS tblhakkelas ORDER BY level DESC LIMIT 1";
		$qHakKelas=mysql_query($sHakKelas);
		$rwHakKelas=mysql_fetch_array($qHakKelas);
		$kso_kelas_id=$rwHakKelas['id'];
		/* ======================= END HAK KELAS ======================== */
		
		/* ======================= KELAS TERTINGGI KECUALI PAVILIUN ======================== */
		$sKelasTertinggi="SELECT id,level,nama FROM (
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				inner join b_ms_kelas mk ON mk.id=t.kelas_id
				WHERE p.kunjungan_id='$idKunj' 
				AND kso.id={$idKsoBPJS}
				AND mk.tipe=0
				UNION
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				inner join b_ms_kelas mk ON mk.id=tk.kelas_id
				WHERE p.kunjungan_id='$idKunj'
				AND kso.id={$idKsoBPJS}
				AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
		$qKelasTertinggi=mysql_query($sKelasTertinggi);
		$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
		$kelas_id=$rwKelasTertinggi['id'];
		/* ======================= END KELAS TERTINGGI KECUALI PAVILIUN ======================== */
		
		/* ======================= CEK PERNAH KE PAVILIUN ??? ======================== */
		$sVIP="SELECT * FROM (
				SELECT  
				p.id
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				INNER JOIN b_ms_kelas mk ON mk.id=t.kelas_id
				WHERE p.kunjungan_id='$idKunj' 
				AND kso.id={$idKsoBPJS}
				AND mk.tipe=2
				UNION
				SELECT  
				p.id
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
				WHERE p.kunjungan_id='$idKunj'
				AND mk.tipe=2
				AND kso.id={$idKsoBPJS}) AS tblhakkelas LIMIT 1";
		$qVIP=mysql_query($sVIP);
		
		$isVIP=0;
		if(mysql_num_rows($qVIP)>0){
			$isVIP=1;
		}
		/* ======================= END CEK PERNAH KE PAVILIUN ??? ======================== */
		
		/* ======================= JIKA PAVILIUN ========================= */
		if($isVIP==1){
			$sPavU="SELECT 
					  SUM(nilai) AS total 
					FROM
					  (SELECT
						1,  
						SUM(tbl_tindakan.biaya) AS nilai 
					  FROM
						(SELECT 
						(b_tindakan.qty*b_tindakan.biaya) AS biaya 
						FROM
						  b_pelayanan  
						  INNER JOIN b_tindakan 
							ON b_tindakan.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN b_ms_kelas mk 
							ON mk.id = b_pelayanan.kelas_id
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan.kso_id = {$idKsoBPJS}
						AND mk.tipe = 2
						) AS tbl_tindakan 
					  UNION
					  SELECT
						2,  
						SUM(kmr.biaya) AS nilai 
					  FROM
						(SELECT
						  IF(b_tindakan_kamar.status_out = 0, 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso+b_tindakan_kamar.beban_pasien), 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso+b_tindakan_kamar.beban_pasien)) biaya 
						FROM
						  b_tindakan_kamar 
						  INNER JOIN b_pelayanan 
							ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN b_ms_kelas mk 
							ON mk.id = b_pelayanan.kelas_id 
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan_kamar.kso_id = {$idKsoBPJS} 
						AND b_tindakan_kamar.aktif = 1
						AND mk.tipe = 2 
						) AS kmr) AS gab";
			$qPavU=mysql_query($sPavU);
			$rwPavU=mysql_fetch_array($qPavU);
			$biaya_pav=$rwPavU['total'];
			
			$sPavObatU="SELECT
						  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
						FROM
						  $dbapotek.a_penjualan ap 
						  INNER JOIN b_pelayanan 
							ON ap.NO_KUNJUNGAN = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN $dbapotek.a_mitra am 
							ON am.IDMITRA=ap.KSO_ID
						  INNER JOIN b_ms_kso kso 
							ON kso.id=b_pelayanan.kso_id
						  INNER JOIN b_kunjungan
							ON b_kunjungan.id = b_pelayanan.kunjungan_id
						  INNER JOIN b_ms_kelas k 
							ON k.id=b_pelayanan.kelas_id
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND kso.id = {$idKsoBPJS}
						AND k.tipe=2
						AND ap.CARA_BAYAR=2
						AND ap.KRONIS<>2";
			$qPavObatU=mysql_query($sPavObatU);
			$rwPavObatU=mysql_fetch_array($qPavObatU);
			$biaya_pav_obat=$rwPavObatU['SUBTOTAL'];
			$biaya_pav_px=$biaya_pav+$biaya_pav_obat;
		}
		/* ======================= END JIKA PAVILIUN ========================= */
		
		$kelas_id_jaminan=$kso_kelas_id;
		$jenis_layanan=$rw["jenis_layanan"];
		$biaya_px=0;
		$biaya_rs=0;
		$biaya_kso=0;
		
		$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
inner join b_pelayanan p on t.pelayanan_id=p.id
where p.kunjungan_id='$idKunj' AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
WHERE b.kunjungan_id='".$idKunj."' AND bt.tipe=0 AND t.lunas=1)";
		//echo $sqlTin.";<br/>";
		$rsTin=mysql_query($sqlTin);
		$rwTin=mysql_fetch_array($rsTin);

		$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
WHERE p.kunjungan_id='".$idKunj."' AND b.aktif=1";
		//echo $sqlKamar.";<br/>";
		$rsKamar=mysql_query($sqlKamar);
		$rwKamar=mysql_fetch_array($rsKamar);
		
		$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
WHERE p.kunjungan_id='".$idKunj."' AND ap.CARA_BAYAR=2) AS t2";
		//echo $sqlObat.";<br/>";
		$rsObat=mysql_query($sqlObat);
		$rwObat=mysql_fetch_array($rsObat);
		$bObat=$rwObat['SUBTOTAL'];
		
		$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
		$biaya_rs=$nilai;
		
		if (($jenis_layanan==$jenis_lay_Pav) || ($kelas_id==5) || ($kelas_id==6) || ($kelas_id==7) || ($kelas_id==8) || ($kelas_id==9) || ($isVIP==1)){	//=======Px BPJS ke Pavilyun========			
			$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kso_kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
			//echo $sql.";<br>";
			$rs1=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal ! 2";
			}else{
				if (mysql_num_rows($rs1)>0){
					$rw1=mysql_fetch_array($rs1);
					/* ===================== BIAYA PAVILIUN =================== */
					$totBiayaPaviliun_BPJS=0;
					$sPav="SELECT 
							  SUM(nilai) AS total 
							FROM
							  (SELECT
								1,  
								SUM(tbl_tindakan.biaya) AS nilai 
							  FROM
								(SELECT 
								(b_tindakan.qty*b_tindakan.biaya) AS biaya 
								FROM
								  b_pelayanan  
								  INNER JOIN b_tindakan 
									ON b_tindakan.pelayanan_id = b_pelayanan.id
								  INNER JOIN b_ms_unit 
									ON b_ms_unit.id = b_pelayanan.unit_id
								  INNER JOIN b_ms_unit b_ms_unit_asal 
									ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
								  LEFT JOIN b_ms_kelas mk 
									ON mk.id = b_tindakan.kelas_id
								  INNER JOIN b_ms_kelas hk 
									ON hk.id = b_tindakan.kso_kelas_id
								WHERE 
								b_pelayanan.kunjungan_id = '$idKunj'
								AND b_tindakan.kso_id = {$idKsoBPJS}
								) AS tbl_tindakan 
							  UNION
							  SELECT
								2,  
								SUM(kmr.biaya) AS nilai 
							  FROM
								(SELECT
								  IF(b_tindakan_kamar.status_out = 0, 
								  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso+b_tindakan_kamar.beban_pasien), 
								  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso+b_tindakan_kamar.beban_pasien)) biaya 
								FROM
								  b_tindakan_kamar 
								  INNER JOIN b_pelayanan 
									ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
								  INNER JOIN b_ms_unit 
									ON b_ms_unit.id = b_pelayanan.unit_id
								  INNER JOIN b_ms_unit b_ms_unit_asal 
									ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
								  INNER JOIN b_ms_kelas mk 
									ON mk.id = b_tindakan_kamar.kelas_id
								  INNER JOIN b_ms_kelas hk 
									ON hk.id = b_tindakan_kamar.kso_kelas_id  
								WHERE 
								b_pelayanan.kunjungan_id = '$idKunj'
								AND b_tindakan_kamar.kso_id = {$idKsoBPJS} 
								AND b_tindakan_kamar.aktif = 1 
								) AS kmr) AS gab";
					$qPav=mysql_query($sPav);
					$rwPav=mysql_fetch_array($qPav);
					$totBiayaPaviliun_BPJS += $rwPav['total'];
					
					
					$sPavObat="SELECT
							  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
							FROM
							  $dbapotek.a_penjualan ap 
							  INNER JOIN b_pelayanan 
								ON ap.NO_KUNJUNGAN = b_pelayanan.id
							  INNER JOIN b_ms_unit 
								ON b_ms_unit.id = b_pelayanan.unit_id
							  INNER JOIN b_ms_unit b_ms_unit_asal 
								ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
							  INNER JOIN $dbapotek.a_mitra am 
								ON am.IDMITRA=ap.KSO_ID
							  INNER JOIN b_ms_kso kso 
								ON kso.id=b_pelayanan.kso_id
							  INNER JOIN b_kunjungan
								ON b_kunjungan.id = b_pelayanan.kunjungan_id
							  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
							  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
							WHERE 
							b_pelayanan.kunjungan_id = '$idKunj'
							AND kso.id = {$idKsoBPJS}
							AND ap.CARA_BAYAR=2
							AND ap.KRONIS<>2";
					$qPavObat=mysql_query($sPavObat);
					$rwPavObat=mysql_fetch_array($qPavObat);
					$totBiayaPaviliun_BPJS += $rwPavObat['SUBTOTAL'];
					$nilai=$totBiayaPaviliun_BPJS;
					/* ===================== END BIAYA PAVILIUN =================== */
					
					$biaya_kso=$rw1["nilai"];
					if ($nilai>$biaya_kso){
						$biaya_px=$nilai-$biaya_kso;
					//}else{
					//	$biaya_kso=$nilai;
					}
					
					$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
					//echo $sql.";<br>";
					$rs1=mysql_query($sql);
					if (mysql_num_rows($rs1)>0){
						$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px',biaya_pav_px='$biaya_pav_px' WHERE kunjungan_id='$idKunj'";
					}else{
						$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px,biaya_pav_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px','$biaya_pav_px')";
					}
					//echo $sql.";<br>";
					$rs1=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal ! 3";
					}else{
						distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
						distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
					}
				}else{
					//echo "Numrows=0<br>";
					$dt="Proses Update Gagal ! 4";
				}
			}
		}else{
			$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
			//echo $sql.";<br>";
			$rs=mysql_query($sql);
			if (mysql_errno()>0){
				$dt="Proses Update Gagal ! 5";
			}else{
				if (mysql_num_rows($rs)>0){
					$rw=mysql_fetch_array($rs);
					$nilai=$rw["nilai"];
					if ($kelas_id!=$kso_kelas_id){
						$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kso_kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
						//echo $sql.";<br>";
						$rs1=mysql_query($sql);
						if (mysql_errno()>0){
							$dt="Proses Update Gagal ! 6";
						}else{
							if (mysql_num_rows($rs1)>0){
								$rw1=mysql_fetch_array($rs1);
								$biaya_kso=$rw1["nilai"];
								if ($nilai>$biaya_kso){
									$biaya_px=$nilai-$biaya_kso;
								}else{
									$biaya_kso=$nilai;
									$kelas_id_jaminan=$kelas_id;
								}
								$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_num_rows($rs1)>0){
									$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
								}else{
									$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 7";
								}else{
									distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
									distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
								}
							}else{
								$dt="Proses Update Gagal ! 8";
							}
						}
					}else{
						$biaya_kso=$nilai;
						$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
						//echo $sql.";<br>";
						$rs1=mysql_query($sql);
						if (mysql_num_rows($rs1)>0){
							$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
						}else{
							$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
						}
						//echo $sql.";<br>";
						$rs1=mysql_query($sql);
						if (mysql_errno()>0){
							$dt="Proses Update Gagal ! 9";
						}else{
							distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
							distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
						}
					}
				}else{
					$dt="Proses Update Gagal ! 10";
				}
			}
		}
	}else{
		$sql="SELECT p.jenis_kunjungan,p.jenis_layanan,p.unit_id,p.unit_id_asal,k.kso_id,p.kelas_id,k.kso_kelas_id,mu.inap 
FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE k.id=$idKunj AND mu.inap=1 AND p.jenis_layanan<>$jenis_lay_IPIT ORDER BY p.id DESC";
		//echo $sql.";<br>";
		$rs=mysql_query($sql);
		if (mysql_errno()>0){
			$dt="Proses Update Gagal ! 11";
		}else{
			if (mysql_num_rows($rs)>0){
				$rw=mysql_fetch_array($rs);
				$kso_kelas_id=$rw["kso_kelas_id"];
				$kelas_id=$rw["kelas_id"];
				$kelas_id_jaminan=$kso_kelas_id;
				$jenis_layanan=$rw["jenis_layanan"];
				$biaya_px=0;
				$biaya_rs=0;
				$biaya_kso=0;
				
				$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
inner join b_pelayanan p on t.pelayanan_id=p.id
where p.kunjungan_id='".$rw['kunj_id']."' AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
WHERE b.kunjungan_id='".$idKunj."' AND bt.tipe=0 AND t.lunas=1)";
				//echo $sqlTin.";<br/>";
				$rsTin=mysql_query($sqlTin);
				$rwTin=mysql_fetch_array($rsTin);
		
				$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
WHERE p.kunjungan_id='".$idKunj."' AND b.aktif=1";
				//echo $sqlKamar.";<br/>";
				$rsKamar=mysql_query($sqlKamar);
				$rwKamar=mysql_fetch_array($rsKamar);
				
				$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
WHERE p.kunjungan_id='".$idKunj."' AND ap.CARA_BAYAR=2) AS t2";
				//echo $sqlKamar.";<br/>";
				$rsObat=mysql_query($sqlObat);
				$rwObat=mysql_fetch_array($rsObat);
				$bObat=$rwObat['SUBTOTAL'];
				
				$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
				$biaya_rs=$nilai;

				if ($jenis_layanan==$jenis_lay_Pav){					
					$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kso_kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
					//echo $sql.";<br>";
					$rs1=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal ! 12";
					}else{
						if (mysql_num_rows($rs1)>0){
							$rw1=mysql_fetch_array($rs1);
							$biaya_kso=$rw1["nilai"];
							if ($nilai>$biaya_kso){
								$biaya_px=$nilai-$biaya_kso;
							//}else{
							//	$biaya_kso=$nilai;
							}
							$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
							//echo $sql.";<br>";
							$rs1=mysql_query($sql);
							if (mysql_num_rows($rs1)>0){
								$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
							}else{
								$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
							}
							//echo $sql.";<br>";
							$rs1=mysql_query($sql);
							if (mysql_errno()>0){
								$dt="Proses Update Gagal ! 13";
							}else{
								distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
								distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
							}
						}else{
							$dt="Proses Update Gagal ! 14";
						}
					}
				}else{
					$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
					//echo $sql.";<br>";
					$rs=mysql_query($sql);
					if (mysql_errno()>0){
						$dt="Proses Update Gagal ! 15";
					}else{
						if (mysql_num_rows($rs)>0){
							$rw=mysql_fetch_array($rs);
							$nilai=$rw["nilai"];
							if ($kelas_id!=$kso_kelas_id){
								$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kso_kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 16";
								}else{
									if (mysql_num_rows($rs1)>0){
										$rw1=mysql_fetch_array($rs1);
										$biaya_kso=$rw1["nilai"];
										if ($nilai>$biaya_kso){
											$biaya_px=$nilai-$biaya_kso;
										}else{
											$biaya_kso=$nilai;
											$kelas_id_jaminan=$kelas_id;
										}
										$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_num_rows($rs1)>0){
											$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
										}else{
											$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
										}
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_errno()>0){
											$dt="Proses Update Gagal ! 17";
										}else{
											distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
											distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
										}
									}else{
										$dt="Proses Update Gagal ! 18";
									}
								}
							}else{
								$biaya_kso=$nilai;
								$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_num_rows($rs1)>0){
									$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
								}else{
									$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 19";
								}else{
									distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
									distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
								}
							}
						}else{
							$kelas_id=$kso_kelas_id;
							$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
							//echo $sql.";<br>";
							$rs=mysql_query($sql);
							if (mysql_errno()>0){
								$dt="Proses Update Gagal ! 20";
							}else{
								$rw=mysql_fetch_array($rs);
								$nilai=$rw["nilai"];
								$biaya_kso=$nilai;
								$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_num_rows($rs1)>0){
									$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
								}else{
									$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 21";
								}else{
									distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
									distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
								}
							}
						}
					}
				}
			}else{
				$sql="SELECT p.jenis_kunjungan,p.jenis_layanan,p.unit_id,p.unit_id_asal,k.kso_id,p.kelas_id,k.kso_kelas_id,mu.inap 
					FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					WHERE k.id=$idKunj AND mu.inap=1 ORDER BY p.id DESC";
				//echo $sql.";<br>";
				$rs=mysql_query($sql);
				if (mysql_errno()>0){
					$dt="Proses Update Gagal ! 22";
				}else{
					if (mysql_num_rows($rs)>0){
						$rw=mysql_fetch_array($rs);
						$kso_kelas_id=$rw["kso_kelas_id"];
						$kelas_id=$kso_kelas_id;
						$kelas_id_jaminan=$kso_kelas_id;
						$jenis_layanan=$rw["jenis_layanan"];
						$biaya_px=0;
						$biaya_rs=0;
						$biaya_kso=0;
						
						$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
			inner join b_pelayanan p on t.pelayanan_id=p.id
			where p.kunjungan_id='$idKunj' AND t.lunas=0 AND t.id NOT IN 
			(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
			INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
			WHERE b.kunjungan_id='".$idKunj."' AND bt.tipe=0 AND t.lunas=1)";
						//echo $sqlTin.";<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
			
						$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
			IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
			IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
			(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
			FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
			WHERE p.kunjungan_id='".$idKunj."' AND b.aktif=1";
						//echo $sqlKamar.";<br/>";
						$rsKamar=mysql_query($sqlKamar);
						$rwKamar=mysql_fetch_array($rsKamar);
						
						$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
			IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
			FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
			WHERE p.kunjungan_id='".$idKunj."' AND ap.CARA_BAYAR=2) AS t2";
						//echo $sqlObat.";<br/>";
						$rsObat=mysql_query($sqlObat);
						$rwObat=mysql_fetch_array($rsObat);
						$bObat=$rwObat['SUBTOTAL'];
						
						$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
						$biaya_rs=$nilai;
						
						$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
						//echo $sql.";<br>";
						$rs=mysql_query($sql);
						if (mysql_errno()>0){
							$dt="Proses Update Gagal ! 23";
						}else{
							if (mysql_num_rows($rs)>0){
								$rw=mysql_fetch_array($rs);
								$nilai=$rw["nilai"];
								$biaya_kso=$nilai;
								$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_num_rows($rs1)>0){
									$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
								}else{
									$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
								}
								//echo $sql.";<br>";
								$rs1=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 24";
								}else{
									distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
									distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
								}
							}else{
								$dt="Proses Update Gagal ! 25";
							}
						}
					}else{	//==========RJ/IGD --> BPJS = Kelas 3============
						$sql="SELECT p.jenis_kunjungan,p.jenis_layanan,p.unit_id,p.unit_id_asal,k.kso_id,p.kelas_id,k.kso_kelas_id,mu.inap 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
							WHERE k.id=$idKunj AND mu.inap=0 AND mu.penunjang=0 AND mu.kategori=2 ORDER BY p.id DESC";
						//echo $sql.";<br>";
						$rs=mysql_query($sql);
						if (mysql_errno()>0){
							$dt="Proses Update Gagal ! 26";
						}else{
							if (mysql_num_rows($rs)>0){
								$rw=mysql_fetch_array($rs);
								$kso_kelas_id=$rw["kso_kelas_id"];
								$kelas_id=4;	//==========RJ/IGD --> BPJS = Kelas 3============
								$kelas_id_jaminan=$kelas_id;
								$jenis_layanan=$rw["jenis_layanan"];
								$biaya_px=0;
								$biaya_rs=0;
								$biaya_kso=0;
								
								$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
					inner join b_pelayanan p on t.pelayanan_id=p.id
					where p.kunjungan_id='$idKunj' AND t.lunas=0 AND t.id NOT IN 
					(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
					INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
					WHERE b.kunjungan_id='".$idKunj."' AND bt.tipe=0 AND t.lunas=1)";
								//echo $sqlTin.";<br/>";
								$rsTin=mysql_query($sqlTin);
								$rwTin=mysql_fetch_array($rsTin);
					
								$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
					(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
					IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
					(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
					IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
					(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
					FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
					WHERE p.kunjungan_id='".$idKunj."' AND b.aktif=1";
								//echo $sqlKamar.";<br/>";
								$rsKamar=mysql_query($sqlKamar);
								$rwKamar=mysql_fetch_array($rsKamar);
								
								$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
					IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
					FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
					WHERE p.kunjungan_id='".$idKunj."' AND ap.CARA_BAYAR=2) AS t2";
								//echo $sqlObat.";<br/>";
								$rsObat=mysql_query($sqlObat);
								$rwObat=mysql_fetch_array($rsObat);
								$bObat=$rwObat['SUBTOTAL'];
								
								$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
								$biaya_rs=$nilai;
								
								$sql="SELECT * FROM b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
								//echo $sql.";<br>";
								$rs=mysql_query($sql);
								if (mysql_errno()>0){
									$dt="Proses Update Gagal ! 27";
								}else{
									if (mysql_num_rows($rs)>0){
										$rw=mysql_fetch_array($rs);
										$nilai=$rw["nilai"];
										$biaya_kso=$nilai;
										$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id='$idKunj'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_num_rows($rs1)>0){
											$sql="UPDATE b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$idKunj'";
										}else{
											$sql="INSERT INTO b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$idKunj','$idKunj','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
										}
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_errno()>0){
											$dt="Proses Update Gagal ! 28";
										}else{
											distribusiBiaya($idKsoBPJS,$idKunj,0,$biaya_kso,0);
											distribusiBiayaPx($idKsoBPJS,$idKunj,0,$biaya_px,0);
										}
									}else{
										$dt="Proses Update Gagal ! 29";
									}
								}
							}else{
								$dt="Proses Update Gagal ! 30";
							}
						}
					}
				}
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
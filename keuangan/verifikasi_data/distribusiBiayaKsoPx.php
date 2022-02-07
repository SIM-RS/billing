<?php
include_once("../koneksi/konek.php");
function distribusiBiaya($ksoId,$kunjId,$jenisKunj,$plafon,$tipe,$dbbilling,$dbapotek){
	$nilai = $plafon;
	$jenisKunj="";
	if ($jenisKunj<>0) $jenisKunj=" AND p.jenis_kunjungan = '$jenisKunj'";
	$fKronis="";
	if ($ksoId==72) $fKronis="AND ap.KRONIS<>2";
	$sql="SELECT IFNULL(SUM((ap.QTY_JUAL-ap.QTY_RETUR)*ap.HARGA_SATUAN),0) AS biaya
		FROM $dbapotek.a_penjualan ap
		  INNER JOIN $dbapotek.a_mitra am
			ON ap.KSO_ID = am.IDMITRA
		  INNER JOIN $dbbilling.b_pelayanan p
			ON ap.NO_KUNJUNGAN = p.id
		WHERE p.kunjungan_id = '$kunjId'
			$jenisKunj
			AND ap.CARA_BAYAR=2
			AND ap.DIJAMIN=1
			$fKronis
			AND am.kso_id_billing = '$ksoId'";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rwObat=mysql_fetch_array($rs);
	// Tidak Cukup
	if ($nilai<$rwObat["biaya"]){
		//echo "Tidak Cukup<br>";
		$sql="SELECT ap.*
			FROM $dbapotek.a_penjualan ap
			  INNER JOIN $dbapotek.a_mitra am
				ON ap.KSO_ID = am.IDMITRA
			  INNER JOIN $dbbilling.b_pelayanan p
				ON ap.NO_KUNJUNGAN = p.id
			WHERE p.kunjungan_id = '$kunjId'
				$jenisKunj
				AND ap.CARA_BAYAR=2
				AND ap.DIJAMIN=1
				$fKronis
				AND am.kso_id_billing = '$ksoId'";
		$rs=mysql_query($sql);
		
		while ($rwObat=mysql_fetch_array($rs)){
			$tindId = $rwObat['ID'];
			$kso_id = $rwObat['KSO_ID'];
			$biaya = ($rwObat["QTY_JUAL"]-$rwObat["QTY_RETUR"])*$rwObat["HARGA_SATUAN"];
			$biayaRS=$rwObat['HARGA_SATUAN'];
			$biayaKSO=$rwObat['HARGA_KSO'];
			
			if($nilai >= $biaya)
			{
				$nilai = $nilai - $biaya;
				//echo "nilai = ".$nilai.";<br>";
				if ($biayaRS<>$biayaKSO){
					$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=HARGA_SATUAN WHERE ID='$tindId'";
					//echo $sqlIn.";<br>";
					$rsIn = mysql_query($sqlIn);
				}
			}
			elseif($nilai > 0)
			{
				//echo "nilai = ".$nilai.";<br>";
				$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=HARGA_SATUAN WHERE ID='$tindId'";
				//echo $sqlIn.";<br>";
				$rsIn = mysql_query($sqlIn);
				$nilai = 0;
			}else{
				//echo "nilai = ".$nilai.";<br>";
				$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=0 WHERE ID='$tindId'";
				//echo $sqlIn.";<br>";
				$rsIn = mysql_query($sqlIn);
			}		
		}
		// Update Biaya Kso Kamar = 0
		$sqlKamar="UPDATE $dbbilling.b_tindakan_kamar, $dbbilling.b_pelayanan SET $dbbilling.b_tindakan_kamar.beban_kso=0
					WHERE $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
						AND $dbbilling.b_pelayanan.kunjungan_id = '$kunjId'
						AND $dbbilling.b_tindakan_kamar.kso_id = '$ksoId'";
		$rsKamar=mysql_query($sqlKamar);
		// Update Biaya Kso Tindakan = 0
		$sqlKamar="UPDATE $dbbilling.b_tindakan, $dbbilling.b_pelayanan SET $dbbilling.b_tindakan.beban_kso=0
					WHERE $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
						AND $dbbilling.b_pelayanan.kunjungan_id = '$kunjId'
						AND $dbbilling.b_tindakan.kso_id = '$ksoId'";
		$rsKamar=mysql_query($sqlKamar);
	// Cukup
	}else{
		$nilai=$nilai-$rwObat["biaya"];
		$sql="SELECT IFNULL(SUM(gab.biaya),0) AS biaya,
		IFNULL(SUM(gab.biayaKSO),0) AS biayaKSO,
		IFNULL(SUM(gab.biayaPx),0) AS biayaPx 
		FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS biaya,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS biayaKSO,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS biayaPx,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId') AS gab";
		$rs=mysql_query($sql);
		$rwKamar=mysql_fetch_array($rs);
		// Tidak Cukup
		if ($nilai<$rwKamar["biayaKSO"]){	
			$sql="SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS tarip,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS beban_kso,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS beban_pasien,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId'";
			$rs=mysql_query($sql);
			$nilaiSisa=0;
			while ($rwKamar=mysql_fetch_array($rs)){
				$idKamar=$rwKamar["id"];
				$biaya=$rwKamar["beban_kso"];
				$qty=$rwKamar["qty_hari"];
				if ($nilai>=$biaya){
					$nilai=$nilai-$biaya;
				}elseif ($nilai>0){
					$biaya=floor($nilai/$qty);
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_kso='$biaya' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
					$nilaiSisa=$nilai%$qty;
					$nilai=0;
				}else{
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_kso='0' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
				}
			}
			
			if ($nilai>0 || $nilaiSisa>0){
				if ($nilaiSisa>0) $nilai=$nilaiSisa;
				
				$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
							FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
							WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
				//echo $sqlTotTind.";<br>";
				$rsTotTind = mysql_query($sqlTotTind);
				$rwTotTind=mysql_fetch_array($rsTotTind);
				$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
				$jmltindKSO=$rwTotTind["jmltindKSO"];
				$nilaiAwalKso=$nilai;
				
				$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
				//echo $sqlTind.";<br>";
				$rsTind = mysql_query($sqlTind);
				$iKso=0;
				while($rwTind = mysql_fetch_array($rsTind))
				{
					$tindId = $rwTind['id'];
					$kso_id = $rwTind['kso_id'];
					$iKso++;
					if ($iKso==$jmltindKSO){
						$biaya = $nilai;
					}else{
						$biaya = $rwTind['biaya'];
						//echo "biaya=".$biaya."<br>";
						$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
					}
					
					$nilai = $nilai - $biaya*$rwTind['qty'];
					
					$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso=$biaya WHERE id = $tindId";
					//echo $sqlUp.";<br>";
					$rsUp = mysql_query($sqlUp);
				}
			}else{
				$sql="UPDATE $dbbilling.b_tindakan SET biaya_kso='0' WHERE kunjungan_id='$kunjId' AND kso_id='$ksoId'";
				$rsUpdt=mysql_query($sql);
			}
		}
		// Cukup Biaya Kamar
		else{
			$nilai=$nilai-$rwKamar["biayaKSO"];
			$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
						FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
			//echo $sqlTotTind.";<br>";
			$rsTotTind = mysql_query($sqlTotTind);
			$rwTotTind=mysql_fetch_array($rsTotTind);
			$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
			$jmltindKSO=$rwTotTind["jmltindKSO"];
			$nilaiAwalKso=$nilai;
			
			$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
					WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
			//echo $sqlTind.";<br>";
			$rsTind = mysql_query($sqlTind);
			$iKso=0;
			while($rwTind = mysql_fetch_array($rsTind))
			{
				$tindId = $rwTind['id'];
				$kso_id = $rwTind['kso_id'];
				$iKso++;
				if ($iKso==$jmltindKSO){
					$biaya = $nilai;
				}else{
					$biaya = $rwTind['biaya'];
					//echo "biaya=".$biaya."<br>";
					$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
				}
				
				$nilai = $nilai - $biaya*$rwTind['qty'];
				
				$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso=$biaya WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}
		}
	}
}

function distribusiBiayaPx($ksoId,$kunjId,$jenisKunj,$plafon,$tipe,$dbbilling,$dbapotek){
	$nilai = $plafon;
	$jenisKunj="";
	if ($jenisKunj<>0) $jenisKunj=" AND p.jenis_kunjungan = '$jenisKunj'";
	// Dialokasikan dulu u/ Kamar	
	//echo "Dialokasikan dulu u/ Kamar<br>";
	$sql="SELECT IFNULL(SUM(gab.biaya),0) AS biaya,
	IFNULL(SUM(gab.biayaKSO),0) AS biayaKSO,
	IFNULL(SUM(gab.biayaPx),0) AS biayaPx 
	FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
	IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS biaya,
	IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS biayaKSO,
	IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS biayaPx,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId') AS gab";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rwKamar=mysql_fetch_array($rs);
	if ($nilai>$rwKamar["biayaPx"]){
		$nilai=$nilai-$rwKamar["biayaPx"];
		$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
					FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
					WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
		//echo $sqlTotTind.";<br>";
		$rsTotTind = mysql_query($sqlTotTind);
		$rwTotTind=mysql_fetch_array($rsTotTind);
		$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
		$jmltindKSO=$rwTotTind["jmltindKSO"];
		$nilaiAwalKso=$nilai;
		
		$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
				WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
		//echo $sqlTind.";<br>";
		$rsTind = mysql_query($sqlTind);
		$iKso=0;
		while($rwTind = mysql_fetch_array($rsTind))
		{
			$tindId = $rwTind['id'];
			$kso_id = $rwTind['kso_id'];
			$biayaRS = $rwTind['biaya'];
			$biayaKSO = $rwTind['biaya_kso'];
			$iKso++;
			if ($iKso==$jmltindKSO){
				$biaya = $nilai;
			}else{
				$biaya = $rwTind['biaya'];
				//echo "biaya=".$biaya."<br>";
				$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
				if (abs($biayaRS-($biayaKSO+$biaya))<6){
					$biaya = $biayaRS-$biayaKSO;
				}
			}
			
			$nilai = $nilai - $biaya*$rwTind['qty'];
			
			$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_pasien=$biaya WHERE id = $tindId";
			//echo $sqlUp.";<br>";
			$rsUp = mysql_query($sqlUp);
		}
	}else{
		if ($nilai>0){
			$sql="SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS tarip,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS beban_kso,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS beban_pasien,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId'";
			$rs=mysql_query($sql);
			$nilaiSisa=0;
			while ($rwKamar=mysql_fetch_array($rs)){
				$idKamar=$rwKamar["id"];
				$biaya=$rwKamar["beban_pasien"];
				$qty=$rwKamar["qty_hari"];
				if ($nilai>=$biaya){
					$nilai=$nilai-$biaya;
				}elseif ($nilai>0){
					$biaya=floor($nilai/$qty);
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_pasien='$biaya' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
					$nilaiSisa=$nilai%$qty;
					$nilai=0;
				}else{
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_pasien='0' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
				}
			}
			
			if ($nilai>0 || $nilaiSisa>0){
				if ($nilaiSisa>0) $nilai=$nilaiSisa;
				$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
							FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
							WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
				//echo $sqlTotTind.";<br>";
				$rsTotTind = mysql_query($sqlTotTind);
				$rwTotTind=mysql_fetch_array($rsTotTind);
				$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
				$jmltindKSO=$rwTotTind["jmltindKSO"];
				$nilaiAwalKso=$nilai;
				
				$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
				//echo $sqlTind.";<br>";
				$rsTind = mysql_query($sqlTind);
				$iKso=0;
				while($rwTind = mysql_fetch_array($rsTind))
				{
					$tindId = $rwTind['id'];
					$kso_id = $rwTind['kso_id'];
					$iKso++;
					if ($iKso==$jmltindKSO){
						$biaya = $nilai;
					}else{
						$biaya = $rwTind['biaya'];
						//echo "biaya=".$biaya."<br>";
						$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
					}
					
					$nilai = $nilai - $biaya*$rwTind['qty'];
					
					$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_pasien=$biaya WHERE id = $tindId";
					//echo $sqlUp.";<br>";
					$rsUp = mysql_query($sqlUp);
				}
			}else{
				$sql="UPDATE $dbbilling.b_tindakan,$dbbilling.b_pelayanan SET $dbbilling.b_tindakan.biaya_pasien=0 
					WHERE $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id 
					AND $dbbilling.b_pelayanan.kunjungan_id='$kunjId' AND $dbbilling.b_tindakan.kso_id='$ksoId'";
				$rsUpdt=mysql_query($sql);
			}
		}else{
			$sql="UPDATE $dbbilling.b_tindakan_kamar,$dbbilling.b_pelayanan SET $dbbilling.b_tindakan_kamar.beban_pasien=0 
				WHERE $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id 
				AND $dbbilling.b_pelayanan.kunjungan_id='$kunjId' AND $dbbilling.b_tindakan_kamar.kso_id='$ksoId'";
			$rsUpdt=mysql_query($sql);
		}
		$sqlUp = "UPDATE $dbbilling.b_tindakan,b_pelayanan SET $dbbilling.b_tindakan.biaya_pasien=0 
				WHERE $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id 
				AND $dbbilling.b_pelayanan.kunjungan_id='$kunjId' AND $dbbilling.b_tindakan.kso_id='$ksoId'";
		//echo $sqlUp.";<br>";
		$rsUp = mysql_query($sqlUp);
	}
}

function distribusiBiayaPx1($ksoId,$kunjId,$jenisKunj,$plafon,$tipe,$dbbilling,$dbapotek){
	$nilai = $plafon;
	$jenisKunj="";
	if ($jenisKunj<>0) $jenisKunj=" AND p.jenis_kunjungan = '$jenisKunj'";
	$sql="SELECT IFNULL(SUM((ap.QTY_JUAL-ap.QTY_RETUR)*ap.HARGA_SATUAN),0) AS biaya
		FROM $dbapotek.a_penjualan ap
		  INNER JOIN $dbapotek.a_mitra am
			ON ap.KSO_ID = am.IDMITRA
		  INNER JOIN $dbbilling.b_pelayanan p
			ON ap.NO_KUNJUNGAN = p.id
		WHERE p.kunjungan_id = '$kunjId'
			$jenisKunj
			AND ap.CARA_BAYAR=2
			AND ap.DIJAMIN=0
			AND am.kso_id_billing = '$ksoId'";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rwObat=mysql_fetch_array($rs);
	// Tidak Cukup
	if ($nilai<$rwObat["biaya"]){	
		$sql="SELECT ap.*
			FROM $dbapotek.a_penjualan ap
			  INNER JOIN $dbapotek.a_mitra am
				ON ap.KSO_ID = am.IDMITRA
			  INNER JOIN $dbbilling.b_pelayanan p
				ON ap.NO_KUNJUNGAN = p.id
			WHERE p.kunjungan_id = '$kunjId'
				$jenisKunj
				AND ap.CARA_BAYAR=2
				AND ap.DIJAMIN=1
				$fKronis
				AND am.kso_id_billing = '$ksoId'";
		$rs=mysql_query($sql);
		
		while ($rwObat=mysql_fetch_array($rs)){
			$tindId = $rwObat['ID'];
			$kso_id = $rwObat['KSO_ID'];
			$biaya = ($rwObat["QTY_JUAL"]-$rwObat["QTY_RETUR"])*$rwObat["HARGA_SATUAN"];
			$biayaRS=$rwObat['HARGA_SATUAN'];
			$biayaKSO=$rwObat['HARGA_KSO'];
			
			if($nilai >= $biaya)
			{
				$nilai = $nilai - $biaya;
				//echo "nilai = ".$nilai.";<br>";
				if ($biayaRS<>$biayaKSO){
					$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=HARGA_SATUAN WHERE ID='$tindId'";
					//echo $sqlIn.";<br>";
					$rsIn = mysql_query($sqlIn);
				}
			}
			elseif($nilai > 0)
			{
				//echo "nilai = ".$nilai.";<br>";
				$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=HARGA_SATUAN WHERE ID='$tindId'";
				//echo $sqlIn.";<br>";
				$rsIn = mysql_query($sqlIn);
				$nilai = 0;
			}else{
				//echo "nilai = ".$nilai.";<br>";
				$sqlIn = "UPDATE $dbapotek.a_penjualan SET HARGA_KSO=0 WHERE ID='$tindId'";
				//echo $sqlIn.";<br>";
				$rsIn = mysql_query($sqlIn);
			}		
		}
		// Update Biaya Kso Kamar = 0
		$sqlKamar="UPDATE $dbbilling.b_tindakan_kamar, $dbbilling.b_pelayanan SET $dbbilling.b_tindakan_kamar.beban_kso=0
					WHERE $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
						AND $dbbilling.b_pelayanan.kunjungan_id = '$kunjId'
						AND $dbbilling.b_tindakan_kamar.kso_id = '$ksoId'";
		$rsKamar=mysql_query($sqlKamar);
		// Update Biaya Kso Tindakan = 0
		$sqlKamar="UPDATE $dbbilling.b_tindakan, $dbbilling.b_pelayanan SET $dbbilling.b_tindakan.beban_kso=0
					WHERE $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
						AND $dbbilling.b_pelayanan.kunjungan_id = '$kunjId'
						AND $dbbilling.b_tindakan.kso_id = '$ksoId'";
		$rsKamar=mysql_query($sqlKamar);
	// Cukup
	}else{
		$nilai=$nilai-$rwObat["biaya"];
		$sql="SELECT IFNULL(SUM(gab.biaya),0) AS biaya,
		IFNULL(SUM(gab.biayaKSO),0) AS biayaKSO,
		IFNULL(SUM(gab.biayaPx),0) AS biayaPx 
		FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS biaya,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS biayaKSO,
		IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS biayaPx,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId') AS gab";
		$rs=mysql_query($sql);
		$rwKamar=mysql_fetch_array($rs);
		// Tidak Cukup
		if ($nilai<$rwKamar["biayaPx"]){	
			$sql="SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*tarip) AS tarip,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_kso) AS beban_kso,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien,
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien) AS beban_pasien,
IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='$kunjId' 
AND b.aktif=1 AND b.kso_id='$ksoId'";
			$rs=mysql_query($sql);
			$nilaiSisa=0;
			while ($rwKamar=mysql_fetch_array($rs)){
				$idKamar=$rwKamar["id"];
				$biaya=$rwKamar["beban_pasien"];
				$qty=$rwKamar["qty_hari"];
				if ($nilai>=$biaya){
					$nilai=$nilai-$biaya;
				}elseif ($nilai>0){
					$biaya=floor($nilai/$qty);
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_pasien='$biaya' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
					$nilaiSisa=$nilai%$qty;
					$nilai=0;
				}else{
					$sql="UPDATE $dbbilling.b_tindakan_kamar SET beban_pasien='0' WHERE id='$idKamar'";
					$rsUpdt=mysql_query($sql);
				}
			}
			
			if ($nilai>0 || $nilaiSisa>0){
				if ($nilaiSisa>0) $nilai=$nilaiSisa;
				$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
							FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
							WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
				//echo $sqlTotTind.";<br>";
				$rsTotTind = mysql_query($sqlTotTind);
				$rwTotTind=mysql_fetch_array($rsTotTind);
				$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
				$jmltindKSO=$rwTotTind["jmltindKSO"];
				$nilaiAwalKso=$nilai;
				
				$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
				//echo $sqlTind.";<br>";
				$rsTind = mysql_query($sqlTind);
				$iKso=0;
				while($rwTind = mysql_fetch_array($rsTind))
				{
					$tindId = $rwTind['id'];
					$kso_id = $rwTind['kso_id'];
					$iKso++;
					if ($iKso==$jmltindKSO){
						$biaya = $nilai;
					}else{
						$biaya = $rwTind['biaya'];
						//echo "biaya=".$biaya."<br>";
						$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
					}
					
					$nilai = $nilai - $biaya*$rwTind['qty'];
					
					$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_pasien=$biaya WHERE id = $tindId";
					//echo $sqlUp.";<br>";
					$rsUp = mysql_query($sqlUp);
				}
			}else{
				$sql="UPDATE $dbbilling.b_tindakan SET biaya_pasien='0' WHERE kunjungan_id='$kunjId' AND kso_id='$ksoId'";
				$rsUpdt=mysql_query($sql);
			}
		}
		// Cukup Biaya Kamar
		else{
			$nilai=$nilai-$rwKamar["biayaPx"];
			$sqlTotTind = "SELECT IFNULL(SUM((t.biaya*t.qty)),0) AS pxTotal,COUNT(t.id) jmltindKSO 
						FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId'";
			//echo $sqlTotTind.";<br>";
			$rsTotTind = mysql_query($sqlTotTind);
			$rwTotTind=mysql_fetch_array($rsTotTind);
			$jmlTotTindPxKSO=$rwTotTind["pxTotal"];
			$jmltindKSO=$rwTotTind["jmltindKSO"];
			$nilaiAwalKso=$nilai;
			
			$sqlTind = "SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
					WHERE p.kunjungan_id='$kunjId' AND t.kso_id='$ksoId' ORDER BY t.tgl_act";
			//echo $sqlTind.";<br>";
			$rsTind = mysql_query($sqlTind);
			$iKso=0;
			while($rwTind = mysql_fetch_array($rsTind))
			{
				$tindId = $rwTind['id'];
				$kso_id = $rwTind['kso_id'];
				$iKso++;
				if ($iKso==$jmltindKSO){
					$biaya = $nilai;
				}else{
					$biaya = $rwTind['biaya'];
					//echo "biaya=".$biaya."<br>";
					$biaya = floor($nilaiAwalKso/$jmlTotTindPxKSO * $biaya);
				}
				
				$nilai = $nilai - $biaya*$rwTind['qty'];
				
				$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_pasien=$biaya WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}
		}
	}
}
?>
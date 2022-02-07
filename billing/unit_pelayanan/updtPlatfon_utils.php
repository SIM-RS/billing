<?php
include("../koneksi/konek.php");
//===============================
$idKunj=$_REQUEST['idKunj'];
$user_act=$_REQUEST['user_act'];
$biaya_kso=$_REQUEST['biaya_kso'];
//===============================

switch(strtolower($_REQUEST['act'])) {
	case 'update':
		$biaya_px=0;
		$biaya_rs=0;
		$biaya_kso=$_REQUEST['biaya_kso'];
		$sql="SELECT * FROM b_kunjungan WHERE id='$idKunj'";
		$rs=mysql_query($sql);
		$rw=mysql_fetch_array($rs);
		$kso_id=$rw["kso_id"];
		
		$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from b_tindakan t
inner join b_pelayanan p on t.pelayanan_id=p.id
where p.kunjungan_id='$idKunj' AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
WHERE b.kunjungan_id='".$idKunj."' AND bt.tipe=0 AND t.lunas=1)";
		//echo $sqlTin.";<br/>";
		$rsTin=mysql_query($sqlTin);
		$rwTin=mysql_fetch_array($rsTin);
		$bTin=$rwTin['total'];

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
		$bKamar=$rwKamar['kamar'];
		
		$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
WHERE p.kunjungan_id='".$idKunj."' AND ap.CARA_BAYAR=2 AND ap.DIJAMIN=1 and ap.KRONIS<>2) AS t2";
		//echo $sqlObat.";<br/>";
		$rsObat=mysql_query($sqlObat);
		$rwObat=mysql_fetch_array($rsObat);
		$bObat=$rwObat['SUBTOTAL'];
		
		$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
		$biaya_rs=$nilai;
		
		if ($nilai>$biaya_kso){
			$biaya_px=$nilai-$biaya_kso;
		}
	
		$sCek="select * from b_jaminan_kso where kunjungan_id='".$idKunj."'";
		$qCek=mysql_query($sCek);
		if(mysql_num_rows($qCek)==0){
			$sIns="insert into b_jaminan_kso(kunjungan_id,biaya_rs,biaya_kso,biaya_px,user_act,tgl_act) values ('$idKunj','$biaya_rs','$biaya_kso','$biaya_px','$user_act', NOW())";
			mysql_query($sIns);
		}
		else{
			$sUp="update b_jaminan_kso set biaya_rs='$biaya_rs', biaya_kso='$biaya_kso', biaya_px='$biaya_px',user_act = '$user_act',tgl_act = NOW() where kunjungan_id='$idKunj'";
			mysql_query($sUp);
		}
		
		//====Distribusi Jaminan KSO====
		$nilai = $biaya_kso - $bObat;
		if ($nilai<0) $nilai=0; 
		//$nilai = $biaya_kso;
		//echo "nilai=$nilai"."<br>";
		$sqlKamar="SELECT
					  b.id,
					  tarip,
					  beban_kso,
					  beban_pasien,
					  IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
					  (IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS jml,
					  b.bayar_pasien,
					  b.lunas
					FROM b_tindakan_kamar b
					  INNER JOIN b_pelayanan p
						ON b.pelayanan_id = p.id
					WHERE p.kunjungan_id = '$idKunj'
						AND b.kso_id = '$kso_id'
						AND b.aktif = 1";
		//echo $sqlKamar.";<br/>";
		$rsKamar=mysql_query($sqlKamar);
		$ok = 'true';
		while ($rwKamar = mysql_fetch_array($rsKamar)){
			$tindId = $rwKamar['id'];
			$taripRS = $rwKamar['tarip'];
			$beban_pasien = $rwKamar['beban_pasien'];
			$bayar_pasien = $rwKamar['bayar_pasien'];
			$qtyHari = $rwKamar['jml'];
			if (($biaya_px == 0) && ($bayar_pasien == 0)){
				$biaya = $taripRS;
				$beban_pasien = 0;
			}elseif ($ok == 'true'){
				if (($biaya_kso>=$bKamar)){
					$biaya = $taripRS;
					$beban_pasien = 0;
				}else{
					$biaya = $taripRS - $beban_pasien;
				}
			}else{
				$biaya = 0;
				$beban_pasien = $taripRS;
			}
			
			if($nilai >= ($biaya * $qtyHari)){
				$nilai = $nilai - ($biaya * $qtyHari);
				if ($nilai == 0){
					$ok = 'false';
				}
				
				$sqlUp = "UPDATE b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}else{
				$biaya = floor($nilai/$qtyHari);
				$beban_pasien = $taripRS - $biaya;
				$nilai = $nilai - ($biaya * $qtyHari);
				$ok = 'false';
				
				$sqlUp = "UPDATE b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}
		}
		//echo "nilai=$nilai"."<br>";
		$sqlTin="select t.* from b_tindakan t
inner join b_pelayanan p on t.pelayanan_id=p.id
where p.kunjungan_id='$idKunj' AND t.kso_id='$kso_id' AND t.lunas=0 AND t.id NOT IN 
(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
WHERE b.kunjungan_id='".$idKunj."' AND b.kso_id='$kso_id' AND bt.tipe=0 AND t.lunas=1)";
		//echo $sqlTin.";<br/>";
		$rsTin=mysql_query($sqlTin);
		$ok = 'true';
		while ($rwTind = mysql_fetch_array($rsTin)){
			$tindId = $rwTind['id'];
			$biaya = $rwTind['biaya'];
			$qty = $rwTind['qty'];
			$biayaNilai = $biaya * $qty;
			$biaya_Pasien = $rwTind['biaya_pasien'];
			$bayar_pasien = $rwTind['bayar_pasien'];
			
			if ($biaya_px == 0){
				$biaya_Pasien = 0;
			}elseif (($nilai >= $biayaNilai) && ($bayar_pasien == 0)){
				$biaya_Pasien = 0;
			}elseif ($ok == 'false'){
				if ($nilai > 0){
					$biaya_Pasien = $biaya - $nilai;
					$biaya = $nilai;
					$nilai = 0;
				}else{
					$biaya_Pasien = $biaya;
					$biaya = 0;
				}
			}
			
			if($nilai >= $biayaNilai){
				$nilai = $nilai - $biayaNilai;
				if ($nilai == 0){
					$ok = 'false';
				}
				//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
				$sqlUp = "UPDATE b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}else{
				if ($ok == 'true'){
					$taripRS = $biaya;
					$biaya = floor($nilai/$qty);
					$biaya_Pasien = $taripRS - $biaya;
					$nilai = $nilai - ($biaya * $qty);
				}/*else{
					$biaya_Pasien = $biaya;
					$biaya = 0;
				}*/
				
				$ok = 'false';
				//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
				$sqlUp = "UPDATE b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
			}
		}
		//====Distribusi Jaminan KSO End====
		
		$sql="SELECT IFNULL((SELECT biaya_kso FROM b_jaminan_kso WHERE kunjungan_id='$idKunj' LIMIT 1),0) AS nilai";
		$queri=mysql_query($sql);
		$rw=mysql_fetch_array($queri);
		$nilai=$rw['nilai'];
		echo $nilai;
		return;
		break;
	case 'view':
		$sql="SELECT IFNULL((SELECT biaya_kso FROM b_jaminan_kso WHERE kunjungan_id='$idKunj' LIMIT 1),0) AS nilai";
		$queri=mysql_query($sql);
		$rw=mysql_fetch_array($queri);
		$nilai=$rw['nilai'];
		echo $nilai;
		return;
		break;
}
?>
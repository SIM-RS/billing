<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl,id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$ksoId=$_REQUEST['ksoId'];
$tgl=tglSQL($_REQUEST['txtTgl']);
$tglPlgP=tglSQL($_REQUEST['tglPlgP']);
$tipeNotif = $_REQUEST['tipeNotif'];
$tgl=tglSQL($_REQUEST['txtTgl']);
$tglA=tglSQL($_REQUEST['tglA']);
$tglZ=tglSQL($_REQUEST['tglZ']);
//echo $tgl."<br>";
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunj_id'];
$pel_id = $_REQUEST['pelayanan_id'];
$grid = $_REQUEST['grid'];
$act = $_REQUEST['act'];
//===============================
$statusProses='';
$alasan='';

switch ($act){
	case "setTglPlgP":
		$sql="SELECT IF(DATEDIFF(NOW(),'$tgl')<=3,IF(DATEDIFF('$tglPlgP','$tgl')>=0,1,0),IF(DATEDIFF(NOW(),'$tglPlgP')<=3,1,0)) AS valid";
		$rsCekTglPlg=mysql_query($sql);
		$rwCekTglPlg=mysql_fetch_array($rsCekTglPlg);
		echo $rwCekTglPlg["valid"];
		return;
		break;
	case "saveTglPlg":
		$tglPlg=$_REQUEST["tglPlg"];
		$jPlg=$_REQUEST["jPlg"];
		$tglPlg=tglSQL($tglPlg)." ".$jPlg;
		$sql="UPDATE $dbbilling.b_tindakan_kamar
				  INNER JOIN $dbbilling.b_pelayanan
				SET $dbbilling.b_tindakan_kamar.tgl_out = '$tglPlg', 
					$dbbilling.b_pelayanan.sudah_krs = '1'
				    $dbbilling.b_pelayanan.tgl_krs = '$tglPlg',
				  ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
				WHERE $dbbilling.b_pelayanan.kunjungan_id = '$kunj_id' AND $dbbilling.b_tindakan_kamar.tgl_out IS NULL";
		$rs=mysql_query($sql);
		$sql="UPDATE $dbbilling.b_pelayanan
				SET $dbbilling.b_pelayanan.sudah_krs = '1',
				  $dbbilling.b_pelayanan.tgl_krs = '$tglPlg'
				WHERE $dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
					AND (($dbbilling.b_pelayanan.sudah_krs = '0') OR ($dbbilling.b_pelayanan.tgl_krs IS NULL))";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$sql="UPDATE $dbbilling.b_kunjungan
				SET $dbbilling.b_kunjungan.pulang = '1',
				  $dbbilling.b_kunjungan.tgl_pulang = '$tglPlg'
				WHERE $dbbilling.b_kunjungan.id = '$kunj_id'";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {
    if ($filter!=""){
        $filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    if($grid == 1){
		$fkso = "";
		//echo "kso=".$ksoId."<br>";
		if($ksoId != "0"){
			//$fkso = " AND kso_id='$ksoId' ";
			$fkso = " AND INSTR(gab3.kso_id,',$ksoId')>0";
		}
		
		$tgll = " AND tgl  BETWEEN '$tglA' and '$tglZ'";
		
		$fNotif="$dbbilling.b_kunjungan";
		
		if ($tipeNotif=="1"){
			$fNotif="(SELECT
						  *
						FROM (SELECT
								$dbbilling.b_kunjungan.*,
								DATEDIFF(NOW(),$dbbilling.b_tindakan.tgl_act) AS diffHari
							  FROM $dbbilling.b_kunjungan
								INNER JOIN $dbbilling.b_tindakan
								  ON $dbbilling.b_kunjungan.id = $dbbilling.b_tindakan.kunjungan_id
							  WHERE ($dbbilling.b_kunjungan.pulang = 0
									  OR $dbbilling.b_kunjungan.tgl_pulang IS NULL)
							  ORDER BY $dbbilling.b_kunjungan.id,$dbbilling.b_tindakan.tgl_act DESC) AS gab
						WHERE gab.diffHari>0
						GROUP BY gab.id) ";
		}
		//echo $fNotif."<br>";
		$sql="SELECT * FROM (SELECT id,pasien_id,tgl,tgl1,no_rm,nama, unit_awal,
				CONCAT(',',GROUP_CONCAT(kso_id SEPARATOR ',')) kso_id, GROUP_CONCAT(nmkso SEPARATOR ',') nmkso,
				SUM(biaya) AS biaya,SUM(biaya_kso) AS biaya_kso,SUM(biaya_pasien) AS biaya_pasien,
				SUM(iur_pasien) iur_pasien, SUM(bayar) AS bayar,SUM(bayar_kso) AS bayar_kso,SUM(bayar_pasien) AS bayar_pasien
				FROM
				(SELECT id,pasien_id,tgl,DATE_FORMAT(tgl,'%d-%m-%Y') AS tgl1, no_rm,nama, unit_awal,kso_id, nmkso, 
				SUM(biaya) biaya, SUM(biaya_kso) biaya_kso, SUM(biaya_pasien) biaya_pasien, 
				SUM(iur_pasien) iur_pasien, SUM(bayar) bayar, 
				SUM(bayar_kso) bayar_kso, SUM(bayar_pasien) bayar_pasien 
				FROM (SELECT k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, 
				t.id idTind, t.kso_id, kso.nama AS nmkso, t.qty*t.biaya biaya, t.qty*t.biaya_kso biaya_kso, 
				IF(t.kso_id=1,t.qty*t.biaya_pasien,0) biaya_pasien, 
				IF(t.kso_id=1,0,t.qty*t.biaya_pasien) iur_pasien,
				t.bayar, t.bayar_kso, t.bayar_pasien 
				FROM $fNotif k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id 
				INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id 
				INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id 
				INNER JOIN $dbbilling.b_tindakan t ON p.id = t.pelayanan_id 
				INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id = kso.id 
				WHERE k.pulang = 0 
				UNION 
				SELECT k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, 
				t.id idTind, t.kso_id, kso.nama AS nmkso, 
				IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip) biaya, 
				IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso) biaya_kso, 
				IF(t.kso_id=1,IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien),0) biaya_pasien, 
				IF(t.kso_id=1,0,IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien)) iur_pasien, 
				t.bayar, t.bayar_kso, t.bayar_pasien 
				FROM $fNotif k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id 
				INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id 
				INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id 
				INNER JOIN $dbbilling.b_tindakan_kamar t ON p.id = t.pelayanan_id 
				INNER JOIN $dbbilling.b_ms_kso kso ON t.kso_id = kso.id 
				WHERE k.pulang = 0 
				UNION 
				SELECT k.id, k.pasien_id, k.tgl, mp.no_rm, mp.nama, mu.nama AS unit_awal, t.id idTind, 
				kso.id AS kso_id, kso.nama AS nmkso, 
				SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN) biaya, 
				SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO) biaya_kso, 
				IF(m.kso_id_billing=1,SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX),0) biaya_pasien, 
				IF(m.kso_id_billing=1,0,SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)) iur_pasien, 
				(SELECT IFNULL(SUM(TOTAL_HARGA),0) 
				FROM $dbapotek.a_kredit_utang 
				WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN AND UNIT_ID=t.UNIT_ID) bayar, 0 bayarKso, 
				(SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN AND UNIT_ID=t.UNIT_ID) bayar_pasien 
				FROM $fNotif k INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id = mp.id 
				INNER JOIN $dbbilling.b_ms_unit mu ON k.unit_id = mu.id 
				INNER JOIN $dbbilling.b_pelayanan p ON k.id = p.kunjungan_id 
				INNER JOIN $dbapotek.a_penjualan t ON p.id = t.NO_KUNJUNGAN 
				INNER JOIN $dbapotek.a_mitra m ON t.KSO_ID = m.IDMITRA 
				INNER JOIN $dbbilling.b_ms_kso kso ON m.kso_id_billing = kso.id 
				WHERE k.pulang = 0 
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab 
				GROUP BY gab.id,gab.kso_id) AS gab2 
				GROUP BY gab2.id) AS gab3
				WHERE 1=1 $fkso $tgll $filter
				ORDER BY tgl,id";
    }
    else if($grid == 2) {
		$sql="SELECT
				  DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,
				  mu.nama AS unit,
				  t.id idTind,
				  mt.nama nmTind,
				  mtk.ms_kelas_id,
				  mk.nama AS kelas,
				  peg.nama	       AS dokter,
				  t.kso_id,
				  kso.nama       AS nmkso,
				  t.qty,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  t.bayar,
				  t.bayar_kso,
				  t.bayar_pasien
				FROM $dbbilling.b_tindakan t
				  INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk
					ON mtk.id = t.ms_tindakan_kelas_id
				  INNER JOIN $dbbilling.b_ms_tindakan mt
					ON mt.id = mtk.ms_tindakan_id
				  INNER JOIN $dbbilling.b_ms_kelas mk
					ON mk.id = mtk.ms_kelas_id
				  LEFT JOIN $dbbilling.b_ms_pegawai peg
					ON peg.id = t.user_id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON p.id = t.pelayanan_id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON t.kso_id = kso.id
				WHERE p.kunjungan_id = '$kunj_id' /*AND t.kso_id = '$ksoId'*/
				UNION
				SELECT
				  DATE_FORMAT(t.tgl_in,'%d-%m-%Y') AS tgl,
				  mu.nama        AS unit,
				  t.id idTind,
				  mkmr.nama AS nmTind,
				  t.kelas_id AS ms_kelas_id,
				  mk.nama AS kelas,
				  'RUMAH SAKIT'	       AS dokter,
				  t.kso_id,
				  kso.nama       AS nmkso,
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in))))    qty,
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip)    biaya,
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso)    biaya_kso,
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien)    biaya_pasien,
				  t.bayar,  
				  t.bayar_kso,
				  t.bayar_pasien
				FROM $dbbilling.b_tindakan_kamar t
				  LEFT JOIN $dbbilling.b_ms_kamar mkmr
					ON mkmr.id = t.kamar_id
				  LEFT JOIN $dbbilling.b_ms_kelas mk
					ON mk.id = t.kelas_id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON p.id = t.pelayanan_id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON t.kso_id = kso.id
				WHERE p.kunjungan_id = '$kunj_id' /*AND t.kso_id = '$ksoId'*/
				UNION
				SELECT
				  DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,
				  CONCAT(au.UNIT_NAME,' : ',mu.nama)        AS unit,
				  t.id idTind,
				  ao.OBAT_NAMA AS nmTind,
				  0 AS ms_kelas_id,
				  '' AS kelas,
				  t.DOKTER	AS dokter,
				  kso.id 	 AS kso_id,
				  kso.nama       AS nmkso,
				  SUM(t.QTY_JUAL-t.QTY_RETUR) AS qty,
				  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)    biaya,
				  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)    biaya_kso,
				  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)    biaya_pasien,
				  SUM(IF (t.SUDAH_BAYAR=1,((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX),0)) AS bayar,  
				  0 AS bayarKso,
				  SUM(IF (t.SUDAH_BAYAR=1,((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX),0)) AS bayar_pasien
				FROM $dbapotek.a_penjualan t
				  INNER JOIN $dbapotek.a_penerimaan ap
					ON ap.ID = t.PENERIMAAN_ID
				  INNER JOIN $dbapotek.a_obat ao
					ON ap.OBAT_ID = ao.OBAT_ID
				  INNER JOIN $dbapotek.a_unit au
					ON t.UNIT_ID = au.UNIT_ID
				  INNER JOIN $dbbilling.b_pelayanan p
					ON p.id = t.NO_KUNJUNGAN
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				  INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON m.kso_id_billing = kso.id
				WHERE p.kunjungan_id = '$kunj_id' /*AND kso.id = '$ksoId'*/
				GROUP BY t.NO_KUNJUNGAN,t.KSO_ID,t.NO_PENJUALAN,ao.OBAT_ID";
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
    $unit_asal = '';

    if($grid == 1) {
		$totPer = 0;
		$totKso = 0;
		$totPas = 0;
		$totIur = 0;
		$totBayarPx = 0;
    	while ($rows=mysql_fetch_array($rs)) {
        	$i++;
			$unit_asal = $rows['unit_awal'];
			$tPerda=$rows["biaya"];
			$tKSO=$rows["biaya_kso"];
			$tPx=$rows["biaya_pasien"];
			$tIur=$rows["iur_pasien"];
			$tBayarPx=$rows["bayar_pasien"];
			/*if ($rows["kso_id"]==1){
				$tPx=$rows["biaya_pasien"];
				$tIur=0;
			}else{
				$tPx=0;
				$tIur=$rows["biaya_pasien"];
			}*/
			$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
			$stSelisih=number_format($tSelisih,0,",",".");
			if ($tSelisih<0){
				$stSelisih="(".number_format(abs($tSelisih),0,",",".").")";
			}
			
			$totPer +=$tPerda;
			$totKso +=$tKSO;
			$totPas +=$tPx;
			$totIur +=$tIur;
			$totBayarPx +=$tBayarPx;

			$dt.=$rows["id"].'|'.$rows['kso_id'].'|'.$rows['pasien_id'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl1"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["nmkso"].chr(3).$unit_asal.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tIur,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).$stSelisih.chr(6);
			$tmpLay = '';
		}
    }
    else if($grid == 2) {
		$totPer = 0;
		$totKso = 0;
		$totPas = 0;
		$totIur = 0;
		$totBayarPx = 0;
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
			$tPerda=$rows["biaya"];
			$tKSO=$rows["biaya_kso"];
			$tBayarPx=$rows["bayar_pasien"];
			if ($rows["kso_id"]==1){
				$tPx=$tPerda;
				$tIur=0;
			}else{
				$tPx=0;
				$tIur=$rows["biaya_pasien"];
			}
			$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
			$stSelisih=number_format($tSelisih,0,",",".");
			if ($tSelisih<0){
				$stSelisih="(".number_format(abs($tSelisih),0,",",".").")";
			}
			
			$totPer +=$tPerda;
			$totKso +=$tKSO;
			$totPas +=$tPx;
			$totIur +=$tIur;
			$totBayarPx +=$tBayarPx;
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",",".").chr(3).$rows["tgl"].chr(3).$rows["unit"].chr(3).$rows["nmkso"].chr(3).$rows["nmTind"].chr(3).$rows["dokter"].chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tIur,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).$stSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }else{
		$dt=$dt.chr(5);
	}
    
    //if($grid == 1){
		 $totSel=$totPer-($totKso+$totPas+$totIur);
		 $StotSel=number_format($totSel,0,",",".");
		 if ($totSel<0){
			$StotSel="(".number_format(abs($totSel),0,",",".").")";
		 }
		 $dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totIur,0,",",".").chr(3).number_format($totBayarPx,0,",",".").chr(3).$StotSel;
    //}
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
//*/
?>
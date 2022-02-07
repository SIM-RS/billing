<?php
include("../koneksi/konek.php");
include("../include/variable.inc.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
//echo $tgl."<br>";
$grd = $_REQUEST['grd'];
$kasir = $_REQUEST['kasir'];
$tanggal = $_REQUEST['tanggal'];
$tanggalSlip = $_REQUEST['tanggalSlip'];
$no_slip = $_REQUEST['no_slip'];
$posting = $_REQUEST['posting'];
$idUser = $_REQUEST['idUser'];

$bayar_id = $_REQUEST['bayar_id'];
//===============================
$IdTrans=38;
$Idma_sak_d=8;
$Idma_sak_k_umum=488;//===pendapatan px umum
$Idma_sak_k_kso=490;//===pendapatan px kso
$Idma_sak_k=$Idma_sak_k_umum;
$Idma_dpa=6;
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'verifikasi':
		//$noSlip=$_REQUEST["noSlip"];
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$idBayar=$cdata[0];
				$kasirId=$cdata[2];
				
				$sql="SELECT posting FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=0";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_num_rows($rsPost)>0){
					$sql="UPDATE $dbbilling.b_bayar SET posting=1 WHERE id='$idBayar'";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()==0){
						$sql="SELECT
								  IFNULL(SUM(nilai),0)    nilai,
								  unitId,
								  ksoId
								FROM (SELECT
										bt.id,
										bt.nilai,
										bt.tipe,
										mu.id       unitId,
										kso.id      ksoId
									  FROM $dbbilling.b_bayar_tindakan bt
										INNER JOIN $dbbilling.b_ms_kso kso
										  ON bt.kso_id = kso.id
										INNER JOIN $dbbilling.b_tindakan t
										  ON bt.tindakan_id = t.id
										INNER JOIN $dbbilling.b_ms_pegawai mp
										  ON t.user_id = mp.id
										INNER JOIN $dbbilling.b_pelayanan p
										  ON t.pelayanan_id = p.id
										INNER JOIN $dbbilling.b_ms_unit mu
										  ON p.unit_id = mu.id
										INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk
										  ON t.ms_tindakan_kelas_id = mtk.id
										INNER JOIN $dbbilling.b_ms_tindakan mt
										  ON mtk.ms_tindakan_id = mt.id
									  WHERE bt.bayar_id = '$idBayar'
										  AND bt.nilai > 0
										  AND bt.tipe = 0
									  UNION
									  SELECT
									  bt.id,
									  bt.nilai,
									  bt.tipe,
									  mu.id        unitId,
									  kso.id       ksoId
									FROM $dbbilling.b_bayar b
									  INNER JOIN $dbbilling.b_bayar_tindakan bt
										ON b.id = bt.bayar_id
									  INNER JOIN $dbbilling.b_ms_kso kso
										ON bt.kso_id = kso.id
									  INNER JOIN $dbbilling.b_tindakan_kamar t
										ON bt.tindakan_id = t.id
									  INNER JOIN $dbbilling.b_pelayanan p
										ON t.pelayanan_id = p.id
									  INNER JOIN $dbbilling.b_ms_unit mu
										ON p.unit_id = mu.id
									WHERE bt.bayar_id = '$idBayar'
										AND bt.nilai > 0
										AND bt.tipe = 1 
									  UNION 
									  SELECT
										bt.id,
										bt.nilai,
										bt.tipe,
										bmu.id        unitId,
										kso_b.id      ksoId
									  FROM $dbbilling.b_bayar b
										INNER JOIN $dbbilling.b_bayar_tindakan bt
										  ON b.id = bt.bayar_id
										INNER JOIN $dbapotek.a_mitra kso
										  ON bt.kso_id = kso.IDMITRA
										LEFT JOIN $dbbilling.b_ms_kso kso_b
										  ON kso.kso_id_billing = kso_b.id
										INNER JOIN $dbapotek.a_penjualan t
										  ON bt.tindakan_id = t.ID
										INNER JOIN $dbapotek.a_penerimaan ap
										  ON t.PENERIMAAN_ID = ap.ID
										INNER JOIN $dbapotek.a_obat ao
										  ON ap.OBAT_ID = ao.OBAT_ID
										LEFT JOIN $dbapotek.a_unit p
										  ON t.RUANGAN = p.UNIT_ID
										LEFT JOIN $dbbilling.b_ms_unit bmu
										  ON p.unit_billing = bmu.id
										INNER JOIN $dbapotek.a_unit mu
										  ON t.UNIT_ID = mu.UNIT_ID
									  WHERE bt.bayar_id = '$idBayar'
										  AND bt.nilai > 0
										  AND bt.tipe = 2) AS gab
								GROUP BY gab.unitId,gab.ksoId";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						if (mysql_errno()==0){
							while ($rwPost=mysql_fetch_array($rsPost)){
								$ksoId=$rwPost["ksoId"];
								$unitId=$rwPost["unitId"];
								$nilai=$rwPost["nilai"];
								
								$sql="INSERT INTO k_transaksi(fk_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,verifikasi,posting,user_act,tgl_act) VALUES('$idBayar','$IdTrans','".tglSQL($tanggal)."','".tglSQL($tanggalSlip)."','$no_slip','$unitId','$ksoId','$kasirId','$nilai','$nilai',1,0,'$idUser',NOW())";
								//echo $sql."<br>";
								$rsIns=mysql_query($sql);
								if (mysql_errno()>0)
								{
									$statusProses='Error';
								}
							}
						}else{
							$statusProses='Error';
							$alasan='Posting Gagal';
							$sql="UPDATE $dbbilling.b_bayar SET posting=0 WHERE id='$idBayar'";
							//echo $sql."<br>";
							$rsBatalPost=mysql_query($sql);
						}
					}else{
						$statusProses='Error';
						$alasan='Posting Gagal';
					}
				}
			}
		}
		else
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$idBayar=$cdata[0];
				$nilai=$cdata[1];
				$kasirId=$cdata[2];
				
				//$sql="SELECT * FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=1";
				$sql="SELECT
						  b.*
						FROM $dbbilling.b_bayar b
						  INNER JOIN k_transaksi t
							ON b.id = t.fk_id
						WHERE b.id = '$idBayar'
							AND t.posting = '0'
							AND t.id_trans = '$IdTrans'";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_num_rows($rsPost)>0){
					$sql="UPDATE $dbbilling.b_bayar SET posting=0 WHERE id='$idBayar' AND posting=1";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()==0){
						$sql="DELETE FROM k_transaksi WHERE fk_id='$idBayar' AND id_trans='$IdTrans' AND posting=0";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						if (mysql_errno()>0){
							$statusProses='Error';
							$alasan='UnPosting Gagal';
							//========== b_bayar --> dikembalikan posting=1 ==============
							$sql="UPDATE $dbbilling.b_bayar SET posting=1 WHERE id='$idBayar'";
							$rsBatalPost=mysql_query($sql);
							//========== End b_bayar --> dikembalikan posting=1 ==============
						}
					}else{
						$statusProses='Error';
						$alasan='UnPosting Gagal';
					}
				//}else{
				//	$statusProses='Error';
				//	$alasan='UnPosting Gagal';
				}
			}			
		}
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."|".$alasan;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
    if ($grd == "penerimaanBillingKasir") {
		$fkasir=" AND mp.id = '$kasir' ";
		if ($kasir==0){
			$fkasir="";
		}
		
		$fposting=" AND b.posting=$posting ";
		
		//if ($posting==0){
			$sql="SELECT
					  b.id,
					  b.user_act,
					  b.nobukti,
					  b.nilai,
					  b.ket,
					  k.no_billing,
					  pas.no_rm,
					  pas.nama,
					  mu.nama kasir,
					  mp.nama petugas
					FROM $dbbilling.b_bayar b
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON b.user_act = mp.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON b.kasir_id = mu.id
					  INNER JOIN $dbbilling.b_kunjungan k
						ON b.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					WHERE 1=1 $fkasir $fposting
						AND b.tgl = '".tglSQL($tanggal)."'";
		/*}else{
			$sql="SELECT
					  b.id,
					  b.nobukti,
					  b.nilai,
					  b.ket,
					  k.no_billing,
					  pas.no_rm,
					  pas.nama,
					  mp.nama petugas
					FROM $dbbilling.b_bayar b
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON b.user_act = mp.id
					  INNER JOIN $dbbilling.b_kunjungan k
						ON b.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					WHERE 1=1 $fkasir
						AND b.tgl = '".tglSQL($tanggal)."'";		
		}*/
		
		$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$stot = $rwSum["totnilai"];
    }else if ($grd == "penerimaanBillingKasirDetail"){
		$sql="SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl_tind,
				  mu.id unitId,
				  mu.nama unitName,
  				  ''	      ket,
				  kso.nama kso,
				  mt.nama namaTind,
				  t.qty		jml,
				  mp.nama dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON bt.kso_id = kso.id
				  INNER JOIN $dbbilling.b_tindakan t
					ON bt.tindakan_id = t.id
				  INNER JOIN $dbbilling.b_ms_pegawai mp
					ON t.user_id = mp.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON t.pelayanan_id = p.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				  INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk
					ON t.ms_tindakan_kelas_id = mtk.id
				  INNER JOIN $dbbilling.b_ms_tindakan mt
					ON mtk.ms_tindakan_id = mt.id
				WHERE bt.bayar_id = '$bayar_id' AND bt.nilai>0 AND bt.tipe=0
				UNION
				SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(b.tgl,'%d-%m-%Y') tgl_tind,
				  mu.id unitId,
				  mu.nama unitName,
				  ''	      ket,
				  kso.nama kso,
				  'Kamar' namaTind,
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,1,
				  DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in))), 
				  (IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,0,
				  DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in))))    jml,
				  '' dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON bt.kso_id = kso.id
				  INNER JOIN $dbbilling.b_tindakan_kamar t
					ON bt.tindakan_id = t.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON t.pelayanan_id = p.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				WHERE bt.bayar_id = '$bayar_id' AND bt.nilai>0 AND bt.tipe=1
				UNION
				SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(t.TGL,'%d-%m-%Y')    tgl_tind,
				  bmu.id       unitId,
                  bmu.nama     unitName,
				  mu.UNIT_NAME	ket,
				  kso.nama    kso,
				  ao.OBAT_NAMA      namaTind,
				  t.QTY_JUAL	jml,
				  t.DOKTER    dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbapotek.a_mitra kso
					ON bt.kso_id = kso.IDMITRA
				  INNER JOIN $dbapotek.a_penjualan t
					ON bt.tindakan_id = t.ID
				  INNER JOIN $dbapotek.a_penerimaan ap
					ON t.PENERIMAAN_ID = ap.ID
				  INNER JOIN $dbapotek.a_obat ao
					ON ap.OBAT_ID = ao.OBAT_ID
				  LEFT JOIN $dbapotek.a_unit p
					ON t.RUANGAN = p.UNIT_ID
				  LEFT JOIN $dbbilling.b_ms_unit bmu
					ON p.unit_billing = bmu.id
				  INNER JOIN $dbapotek.a_unit mu
					ON t.UNIT_ID = mu.UNIT_ID
				WHERE bt.bayar_id = '$bayar_id'
					AND bt.nilai > 0
					AND bt.tipe = 2";
		
		$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$stot = $rwSum["totnilai"];
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

    if ($grd == "penerimaanBillingKasir") {
		if ($posting==0){
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$dt.=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"].chr(3).number_format($i,0,",",".").chr(3).$rows["no_billing"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["kasir"].chr(3).$rows["petugas"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["ket"].chr(6);
			}
		}else{
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$dt.=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"].chr(3).number_format($i,0,",",".").chr(3).$rows["no_billing"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["kasir"].chr(3).$rows["petugas"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["ket"].chr(6);
			}
		}
    }
    else if ($grd == "penerimaanBillingKasirDetail") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows["id"]."|".$rows["tipe"]."|".$rows["nilai"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl_tind"].chr(3).$rows["unitName"].chr(3).$rows["kso"].chr(3).$rows["namaTind"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(3).number_format($rows["nilai"],0,",",".").chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
    }else{
        $dt=$dt.chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
	}
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
?>
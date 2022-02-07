<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$filter1=$_REQUEST["filter"];
//===============================
$tgl_a=tglSQL($_GET['tgl_a']);
$tgl_b=tglSQL($_GET['tgl_b']);
$kasir=$_GET['kasir'];
$user_act=$_GET['user_setor'];
$tgl_setor=tglSQL($_GET['tgl_setor']);
$user_setor=$_GET['user_setor'];
$data=$_REQUEST['data'];
$nss=$_REQUEST['nss']; // No Slip Setor ke
$jam = date("G:i:s");
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'kiri':
		$dt = explode("|",$data);
		for($t=0;$t<count($dt);$t++){
			if($dt[$t]!=''){
				$sql = mysql_query("update b_kunjungan set 
										disetor_tgl='$tgl_setor $jam',
										disetor_oleh='$user_setor',
										disetor=1,
										slip_ke = '{$nss}'
									where id='$dt[$t]'");
			}
		}
		break;
	case 'kanan':
		$dt = explode("|",$data);
		//echo $dt;
		for($t=0;$t<count($dt);$t++){
			if($dt[$t]!=''){
				$sCek="select disetor_oleh from b_kunjungan where id='$dt[$t]'";
				$qCek=mysql_query($sCek);
				$rwCek=mysql_fetch_array($qCek);
				
				$sCek2="select DATEDIFF(CURDATE(),DATE(disetor_tgl)) AS hari from b_kunjungan where id='$dt[$t]'";
				$qCek2=mysql_query($sCek2);
				$rwCek2=mysql_fetch_array($qCek2);
				// && $rwCek2['hari']=='0'
				if($rwCek['disetor_oleh']==$user_setor){
					echo $sql = mysql_query("update b_kunjungan set disetor_tgl=NULL,disetor_oleh=NULL,disetor=0,slip_ke=0 where id='$dt[$t]'");	
				}
			}
		}
		break;
		
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if($tgl_a!='--'&&$tgl_b!='--'){
	$tgl_d = "AND k.tgl_pulang_ak BETWEEN '$tgl_a' AND '$tgl_b'"; //k.tgl_pulang_ak BETWEEN '$tgl' AND '$tgl2'
}

if($user_act!='0'){
	$user_d = "and k.user_act_pulang = '$user_act'";
	$user_s = "and k.disetor_oleh = '$user_act'";
}
switch($grd){
	case "kiri":


   $sql="SELECT id,pasien_id,DATE_FORMAT(tgl,'%d-%m-%Y') AS tgl,
				  DATE_FORMAT(tgl_pulang,'%d-%m-%Y') AS tgl_p,
				  no_rm,nama AS pasien,
				  unit,kso_id,
				  kso,
				  SUM(biaya) biayaRS,
				  SUM(biaya_kso) biayaKSO,
				  SUM(biaya_pasien) biayaPasien,
				  SUM(retribusi) retribusi,
				  SUM(bayar) bayar,
				  SUM(bayar_kso) bayarKso,
				  SUM(bayar_pasien) bayarPasien
				FROM
				(SELECT ttind.* FROM
				(SELECT
				  k.id,
				  k.pasien_id,
				  k.tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit,
				  t.id idTind,
				  t.kso_id,
				  kso.nama AS kso,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  0 retribusi,
				  t.bayar,
				  t.bayar_kso,
				  /*t.bayar_pasien*/
				  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN b_tindakan t
					ON p.id = t.pelayanan_id
				  INNER JOIN b_ms_kso kso
					ON t.kso_id = kso.id
				  LEFT JOIN b_bayar_tindakan bt 
					ON t.id = bt.tindakan_id
				WHERE k.pulang = 1 
				$tgl_d  AND k.kso_id<>1
					AND k.disetor=0 $user_d
				GROUP BY t.id) AS ttind
				WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
				UNION
				SELECT tk.* FROM 
					(SELECT
					  k.id,
					  k.pasien_id,
					  k.tgl,
					  k.tgl_pulang,
					  mp.no_rm,
					  mp.nama,
					  mu.nama        AS unit_awal,
					  t.id idTind,
					  t.kso_id,
					  kso.nama       AS nmkso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip)    biaya,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
					  
IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi)    retribusi,
					  t.bayar,  
					  t.bayar_kso,
					  /*t.bayar_pasien*/
					  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien
					FROM b_kunjungan k
					  INNER JOIN b_ms_pasien mp
						ON k.pasien_id = mp.id
					  INNER JOIN b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN b_pelayanan p
						ON k.id = p.kunjungan_id
					  INNER JOIN b_tindakan_kamar t
						ON p.id = t.pelayanan_id
					  INNER JOIN b_ms_kso kso
						ON t.kso_id = kso.id
					  LEFT JOIN b_bayar_tindakan bt 
						ON t.id = bt.tindakan_id
					WHERE k.pulang = 1 /*{$fkso} AND DATE(k.tgl_pulang) = '$tgl'*/ 
						$tgl_d AND k.kso_id<>1
						AND t.aktif = 1 AND k.disetor=0 $user_d
					GROUP BY t.id) AS tk 
				WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
				UNION
				SELECT
				  k.id,
				  k.pasien_id,
				  k.tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit_awal,
				  t.id idTind,
				  kso.id AS kso_id,
				  kso.nama AS nmkso,
				SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
					  ) biaya,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
					  ) biaya_kso,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
					  ) biaya_pasien,
				  0 retribusi,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
				  0 AS bayarKso,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbapotek.a_penjualan t
					ON p.id = t.NO_KUNJUNGAN
				  INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN b_ms_kso kso
					ON m.kso_id_billing = kso.id
				WHERE k.pulang = 1 /*{$fkso_obat} AND DATE(k.tgl_pulang) = '$tgl'*/ 
					$tgl_d AND k.disetor=0 AND k.kso_id<>1 $user_d
					AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = 0
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
				 /* WHERE 1=1 AND ((SUM(biaya_kso)>0) OR (SUM(biaya_pasien)>SUM(bayar_pasien)))*/ 
				  {$filter}
				GROUP BY gab.id,gab.kso_id
				ORDER BY $sorting";
				
				
				echo $sql;

	break;
	case "kanan":
 $sql="SELECT id,pasien_id,DATE_FORMAT(disetor_tgl,'%d-%m-%Y') AS tgl,
				  DATE_FORMAT(tgl_pulang,'%d-%m-%Y') AS tgl_p,
				  no_rm,nama AS pasien,
				  unit,kso_id,
				  kso,
				  SUM(biaya) biayaRS,
				  SUM(biaya_kso) biayaKSO,
				  SUM(biaya_pasien) biayaPasien,
				  SUM(retribusi) retribusi,
				  SUM(bayar) bayar,
				  SUM(bayar_kso) bayarKso,
				  SUM(bayar_pasien) bayarPasien,
				  namapeg,
				  slip_ke
				FROM
				(SELECT ttind.* FROM
				(SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit,
				  t.id idTind,
				  t.kso_id,
				  kso.nama AS kso,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  0 retribusi,
				  t.bayar,
				  t.bayar_kso,
				  /*t.bayar_pasien*/
				  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
				  g.nama namapeg,
				  k.slip_ke
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN b_tindakan t
					ON p.id = t.pelayanan_id
				  INNER JOIN b_ms_kso kso
					ON t.kso_id = kso.id
				  LEFT JOIN b_bayar_tindakan bt 
					ON t.id = bt.tindakan_id
				  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
				WHERE k.pulang = 1 
				 AND k.kso_id<>1
					AND k.disetor=1 AND DATE(k.disetor_tgl)='$tgl_setor' $user_s
				GROUP BY t.id) AS ttind
				WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
				UNION
				SELECT tk.* FROM 
					(SELECT
					  k.id,
					  k.pasien_id,
					  k.disetor_tgl,
					  k.tgl_pulang,
					  mp.no_rm,
					  mp.nama,
					  mu.nama        AS unit_awal,
					  t.id idTind,
					  t.kso_id,
					  kso.nama       AS nmkso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.tarip)    biaya,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
					  
IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)+1))*t.retribusi)    retribusi,
					  t.bayar,  
					  t.bayar_kso,
					  /*t.bayar_pasien*/
					  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
					  g.nama namapeg,
					  k.slip_ke
					FROM b_kunjungan k
					  INNER JOIN b_ms_pasien mp
						ON k.pasien_id = mp.id
					  INNER JOIN b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN b_pelayanan p
						ON k.id = p.kunjungan_id
					  INNER JOIN b_tindakan_kamar t
						ON p.id = t.pelayanan_id
					  INNER JOIN b_ms_kso kso
						ON t.kso_id = kso.id
					  LEFT JOIN b_bayar_tindakan bt 
						ON t.id = bt.tindakan_id
					  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
					WHERE k.pulang = 1 /*{$fkso} AND DATE(k.tgl_pulang) = '$tgl'*/ 
						 AND k.kso_id<>1
						AND t.aktif = 1 AND k.disetor=1 AND DATE(k.disetor_tgl)='$tgl_setor' $user_s
					GROUP BY t.id) AS tk 
				WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
				UNION
				SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit_awal,
				  t.id idTind,
				  kso.id AS kso_id,
				  kso.nama AS nmkso,
				SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
					  ) biaya,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
					  ) biaya_kso,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
					  ) biaya_pasien,
				  0 retribusi,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
				  0 AS bayarKso,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien,
				  g.nama namapeg,
				  k.slip_ke
				FROM b_kunjungan k
				  INNER JOIN b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbapotek.a_penjualan t
					ON p.id = t.NO_KUNJUNGAN
				  INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN b_ms_kso kso
					ON m.kso_id_billing = kso.id
				  INNER JOIN b_ms_pegawai g ON g.id=k.disetor_oleh
				WHERE k.pulang = 1 AND k.disetor=1 /*{$fkso_obat} AND DATE(k.tgl_pulang) = '$tgl'*/ 
					/*$tgl_d*/ AND k.disetor=1  AND k.kso_id<>1 AND DATE(k.disetor_tgl)='$tgl_setor' $user_s
					AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = 0
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
				/* WHERE 1=1 AND ((SUM(biaya_kso)>0) OR (SUM(biaya_pasien)>SUM(bayar_pasien)))*/ 
				  {$filter}
				GROUP BY gab.id,gab.kso_id
				ORDER BY $sorting";
	break;
}


//echo $sql."<br>";
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$xsql=$sql;
$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
$no = 1;

$subTotal=0;
switch($grd){
	case "kiri":
	while ($rows=mysql_fetch_array($rs)){
		$sTot="select IFNULL(SUM(biayaKSO+retribusi),0) AS total FROM (".$xsql.") AS tbl";
		$qTot=mysql_query($sTot);
		$rwTot=mysql_fetch_array($qTot);
		$subTotal=$rwTot['total'];
		
		$id=$rows["id"];
		$ch = "<input type='checkbox' id='nb_kiri$i' name='nb_kiri$i' value='$rows[id]' />";
		$dt.=$id.chr(3).$no.chr(3)."0".chr(3).$rows['tgl_p'].chr(3).$rows['no_kwitansi'].chr(3).$rows['no_rm'].chr(3).$rows['pasien'].chr(3).number_format(($rows['biayaKSO']+$rows['retribusi']),0,',','.').chr(6);
		$i++;
		$no++;
	}
	break;
	case "kanan":
	while ($rows=mysql_fetch_array($rs)){
		$sTot="select IFNULL(SUM(biayaKSO+retribusi),0) AS total FROM (".$xsql.") AS tbl";
		$qTot=mysql_query($sTot);
		$rwTot=mysql_fetch_array($qTot);
		$subTotal=$rwTot['total'];
		
		$id=$rows["id"];
		$ch = "<input type='checkbox' id='nb_kanan$i' name='nb_kanan$i' value='$rows[id]' />";
		$dt.=$id.chr(3).$no.chr(3)."0".chr(3).$rows['tgl_p'].chr(3).$rows['no_kwitansi'].chr(3).tglSQL($rows['tgl']).chr(3).$rows['no_rm'].
		chr(3).$rows['pasien'].chr(3).$rows['slip_ke'].chr(3).number_format(($rows['biayaKSO']+$rows['retribusi']),0,',','.').chr(3).$rows['namapeg'].chr(6);
		$i++;
		$no++;
	}
	break;
}


if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$grd.chr(1).number_format($subTotal,0,',','.').chr(1).$msg;
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).$grd.chr(1).number_format($subTotal,0,',','.').chr(1).$msg;	
}

mysql_free_result($rs);
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
<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort="no_bukti ASC, tgl_setor DESC";
$statusProses='Fine';
//===============================
$id_sak_Bank_BLUD=33;

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$tahun = $_REQUEST["tahun"];
$bulan = $_REQUEST["bulan"];
$tipe = $_REQUEST["tipe"];
$posting = $_REQUEST["posting"];
$noSlip = $_REQUEST["noSlip"];
$act = $_REQUEST["act"];
$fdata = $_REQUEST["fdata"];
$tanggalAsli=$_REQUEST['tanggal'];
$tanggalan = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggalan[2].'-'.$tanggalan[1].'-'.$tanggalan[0];
$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tanggalAwal = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tanggalAkhir = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];

switch ($act){
	case "postPenerimaanParkir":
		$arfdata=explode(chr(6),$fdata);
		$id_sak_kas = 8;
		$id_sak_par = 853;
		$id_sak_bank = 33;
		$jenistrans = 306;
		
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				echo $arfdata[$i];
				$cdata=explode(chr(5),$arfdata[$i]);	
				print_r($cdata);
				$id = explode(',',$cdata[0]);
				if(count($id) > 1){
					$fwhere = " id in (".$cdata[0].")";
				} else {
					$fwhere = " id = ".$cdata[0];
				}
				$sql="UPDATE {$dbkeuangan}.k_parkir SET verifikasi = 2, user_posting = $idUser, tgl_posting = NOW() WHERE {$fwhere}";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql) or die (mysql_error());
				if (mysql_errno()<=0){
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$nokw = $cdata[1];
					$tanggal = $cdata[2];
					$nilai = $cdata[3];
					$uraian = "Penerimaan Parkir [{$nokw}]";
					
					$id_cc_rv = "";
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI/* , CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID */, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_kas, '$tanggal', '$nokw', '$uraian', $nilai, 0, now(), $idUser, 'D', 0, $jenistrans, $jenistrans, 1, ''/* , $id_cc_rv, $id_cc_rv */, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI/* , CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID */, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_par, '$tanggal', '$nokw', '$uraian', 0, $nilai, now(), $idUser, 'K', 0, $jenistrans, $jenistrans, 1, ''/* , $id_cc_rv, $id_cc_rv */, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI/* , CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID */, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_bank, '$tanggal', '$nokw', '$uraian', $nilai, 0, now(), $idUser, 'D', 0, $jenistrans, $jenistrans, 1, ''/* , $id_cc_rv, $id_cc_rv */, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
						
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI/* , CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID */, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_kas, '$tanggal', '$nokw', '$uraian', 0, $nilai, now(), $idUser, 'K', 0, $jenistrans, $jenistrans, 1, ''/* , $id_cc_rv, $id_cc_rv */, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					
					$statusProses='Berhasil';
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);				
				$id = explode(',',$cdata[0]);
				$nokw = $cdata[1];
				$tanggal = $cdata[2];
				$nilai = $cdata[3];
				if(count($id) > 1){
					$fwhere = " id in (".$cdata[0].")";
				} else {
					$fwhere = " id = ".$cdata[0];
				}
				$sUp = "UPDATE ".$dbkeuangan.".k_parkir SET verifikasi = 0 WHERE {$fwhere}";
				mysql_query($sUp);
				
				$sJ = "DELETE FROM jurnal WHERE TGL='{$tanggal}' AND NO_KW='{$nokw}' AND (DEBIT='{$nilai}' OR KREDIT='{$nilai}') AND URAIAN LIKE 'Penerimaan Parkir%' AND FK_TRANS=$jenistrans AND FK_LAST_TRANS=$jenistrans";
				mysql_query($sJ);
			}
			$actPosting='Unposting';
		}
		break;
	case "postPenerimaanAmbulan":
		$arfdata=explode(chr(6),$fdata);
		$id_sak_kas = 8;
		$id_sak_ambu = 488;
		$id_sak_bank = 33;
		$jenistrans = 258;
		
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);			
				$id = explode(',',$cdata[0]);
				if(count($id) > 1){
					$fwhere = " id in (".$cdata[0].")";
				} else {
					$fwhere = " id = ".$cdata[0];
				}
				$sql="UPDATE ".$dbkeuangan.".k_ambulan SET verifikasi = 2, user_posting = $idUser, tgl_posting = NOW() WHERE {$fwhere}";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0){
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					
					$nokw = $cdata[1];
					$tanggal = $cdata[2];
					$nilai = $cdata[3];
					$uraian = "Penerimaan Ambulan [{$nokw}]";
					
					$CC_RV_KSO_PBF_UMUM_ID = '1';
					$id_cc_rv = "62";
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI, CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_kas, '$tanggal', '$nokw', '$uraian', $nilai, 0, now(), $idUser, 'D', 0, $jenistrans, $jenistrans, 1, '', $CC_RV_KSO_PBF_UMUM_ID, $id_cc_rv, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql) or die( " 1 | ".mysql_error() );
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI, CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_ambu, '$tanggal', '$nokw', '$uraian', 0, $nilai, now(), $idUser, 'K', 0, $jenistrans, $jenistrans, 1, '', $CC_RV_KSO_PBF_UMUM_ID, $id_cc_rv, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql) or die( " 2 | ".mysql_error() );
					
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI, CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_bank, '$tanggal', '$nokw', '$uraian', $nilai, 0, now(), $idUser, 'D', 0, $jenistrans, $jenistrans, 1, '', $CC_RV_KSO_PBF_UMUM_ID, $id_cc_rv, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql) or die( " 3 | ".mysql_error() );
						
					$sql="INSERT INTO {$dbakuntansi}.jurnal(NO_TRANS, NO_PASANGAN, FK_SAK, TGL, NO_KW, URAIAN, DEBIT, KREDIT, TGL_ACT, FK_IDUSER, D_K, JENIS, FK_TRANS, FK_LAST_TRANS, STATUS, NO_BUKTI, CC_RV_KSO_PBF_UMUM_ID, CC_RV_ID, POSTING) 
					VALUES($notrans, $no_psg, $id_sak_kas, '$tanggal', '$nokw', '$uraian', 0, $nilai, now(), $idUser, 'K', 0, $jenistrans, $jenistrans, 1, '', $CC_RV_KSO_PBF_UMUM_ID, $id_cc_rv, 1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql) or die( " 4 | ".mysql_error() );
					
					$statusProses='Berhasil';
				}else{
					$statusProses='Error';
				}
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);				
				$id = explode(',',$cdata[0]);
				$nokw = $cdata[1];
				$tanggal = $cdata[2];
				$nilai = $cdata[3];
				if(count($id) > 1){
					$fwhere = " id in (".$cdata[0].")";
				} else {
					$fwhere = " id = ".$cdata[0];
				}
				$sUp = "UPDATE ".$dbkeuangan.".k_ambulan SET verifikasi = 0 WHERE {$fwhere}";
				mysql_query($sUp);
				
				$sJ = "DELETE FROM jurnal WHERE TGL='{$tanggal}' AND NO_KW='{$nokw}' AND (DEBIT='{$nilai}' OR KREDIT='{$nilai}') AND URAIAN LIKE 'Penerimaan Ambulan%' AND FK_TRANS=$jenistrans AND FK_LAST_TRANS=$jenistrans";
				mysql_query($sJ);
			}
			$actPosting='Unposting';
		}
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else {
	switch ($grd){
		// edit raga
		case "PenerimaanParkir":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$fposting = " AND p.verifikasi = 0";
			}else{
				$fposting = " AND p.verifikasi = 2";
			}
			
			$sql="SELECT p.no_bukti, SUM(p.nilai) nilai, p.user_act, p.shift, 6 AS id, p.tgl_setor, u.nama, p.bkm_detail_id, 
						GROUP_CONCAT(p.id) idTrans, p.tgl_posting, p.user_posting, date(p.tgl_posting) tglPosting, date(p.tgl_setor) tglSetor
					FROM
					{$dbkeuangan}.k_parkir p 
					  INNER JOIN {$dbkeuangan}.k_ms_user u 
						ON u.id = p.user_act
					WHERE MONTH(p.tgl_setor) = '{$bulan}'
					  AND YEAR(p.tgl_setor) = '{$tahun}'
					  {$fposting}
					GROUP BY p.no_bukti, DATE(p.tgl_setor)
					ORDER BY {$sorting}";
			break;
		case "PenerimaanAmbulan":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if ($posting==0){
				$fposting = " AND a.verifikasi = 0";
			}else{
				$fposting = " AND a.verifikasi = 2";
			}
			
			$sql = "SELECT a.no_bukti, SUM(a.nilai) nilai, a.user_act, '', 30 AS id, a.tgl_setor, u.nama, a.bkm_detail_id,
						GROUP_CONCAT(a.id) idTrans, a.tgl_posting, a.user_posting, date(a.tgl_posting) tglPosting, date(a.tgl_setor) tglSetor
					FROM {$dbkeuangan}.k_ambulan a
					INNER JOIN {$dbkeuangan}.k_ms_user u
					   ON u.id = a.user_act
					WHERE MONTH(a.tgl_setor) = '{$bulan}'
					  AND YEAR(a.tgl_setor) = '{$tahun}'
					  {$fposting}
					GROUP BY a.no_bukti, DATE(a.tgl_setor)
					ORDER BY {$sorting}";
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
		case "PenerimaanParkir":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					$dt.=$rows["idTrans"]."|".$rows["no_bukti"]."|".$rows["tglSetor"]."|".$rows["nilai"].chr(3).$i.chr(3).tglSQL($rows["tglSetor"]).chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					$dt.=$rows["idTrans"]."|".$rows["no_bukti"]."|".$rows["tglSetor"]."|".$rows["nilai"].chr(3).$i.chr(3).tglSQL($rows["tglSetor"]).chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
		case "PenerimaanAmbulan":
			if ($posting==0){
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					$dt.=$rows["idTrans"]."|".$rows["no_bukti"]."|".$rows["tglSetor"]."|".$rows["nilai"].chr(3).$i.chr(3).tglSQL($rows["tglSetor"]).chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}else{
				while ($rows=mysql_fetch_array($rs)) {
					$nilai=$rows["nilai"];
					$i++;
					$dt.=$rows["idTrans"]."|".$rows["no_bukti"]."|".$rows["tglSetor"]."|".$rows["nilai"].chr(3).$i.chr(3).tglSQL($rows["tglSetor"]).chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."0".chr(6);
				}
			}
			break;
    }

    //DARI FOLDER akuntansi_
	if ($dt!=$totpage.chr(5)) {
		if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
		}
		else if($actPosting=='Unverifikasi'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unverifikasi";
		}
		else{
			$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
		}
        $dt=str_replace('"','\"',$dt);
    }else{
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

/*
//LAWAS
    if ($dt!=$totpage.chr(5)) {
		if($actPosting=='Unposting'){
			$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
		}
		else{
        	$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
		}
        $dt=str_replace('"','\"',$dt);
    }else{
		if($actPosting=='Unposting'){
			$dt="0".chr(5).chr(5)."Unposting";
		}
		else{
			$dt="0".chr(5).chr(5).$_REQUEST['act'];
		}
	}
*/	
/* 	if ($grd=="penerimaanBillingKasir"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntotSlip,0,",",".").chr(3).number_format($ntot1,0,",",".");
	}elseif($grd=="pembelianObat"){
		$dt=$dt.chr(3).number_format($totdpp,2,",",".").chr(3).number_format($totppn,2,",",".").chr(3).number_format($totdppppn,2,",",".");
	}elseif($grd=="pengeluaranLain"){
		$dt=$dt.chr(3).number_format($totnilai,2,",",".");
	} */

    mysql_free_result($rs);
}
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
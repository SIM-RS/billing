<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];
$bln_in = $_REQUEST['bln_in'];
$thn_in = $_REQUEST['thn_in'];
$tgl = tglSQL($_REQUEST['tgl']);
$id_trans = $_REQUEST['id_trans'];
$nobukti = $_REQUEST['nobukti'];
$ket = $_REQUEST['ket'];
$nilai = $_REQUEST['nilai'];
$tgl_act = 'now()';
$user_act = $_REQUEST['user_act'];
$id = $_REQUEST['id'];
$idma= $_REQUEST['idMa'];
$id_ma_sak = $_REQUEST['id_ma_sak'];
$posting = $_REQUEST['posting'];
//===============================
$act = $_REQUEST['act'];
$fdata = $_REQUEST['fdata'];
$idUser = $_REQUEST['idUser'];
$actPosting = '';
switch($act){
    case 'postingKasBank':
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$id_cc_rv=$cdata[0];
				$tanggal=tglSQL($cdata[5]);
				$no_bukti=$cdata[3];
				$id_trans=$cdata[1];
				$nilai=$cdata[4];
				
				$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM jurnal";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$notrans=$rwPost["notrans"];
				
				$cek="SELECT jt.JTRANS_ID,ma.MA_ID,jt.JTRANS_NAMA,ma.MA_NAMA,dt.dk
FROM detil_transaksi dt INNER JOIN jenis_transaksi jt ON dt.fk_jenis_trans = jt.JTRANS_ID 
INNER JOIN ma_sak ma ON dt.fk_ma_sak = ma.MA_ID WHERE jt.JTRANS_ID = ".$id_trans."";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = $rw['JTRANS_NAMA']." -> ".$rw['MA_NAMA'];
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$id_sak,'$tanggal','$no_bukti','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'',0,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}
				
				$s_upd = "UPDATE $dbkeuangan.k_transaksi SET verifikasi=1, posting=1 WHERE id = ".$id_cc_rv;
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
		}
		else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				
				$id_cc_rv=$cdata[0];
				$tanggal=tglSQL($cdata[5]);
				$no_bukti=$cdata[3];
				$id_trans=$cdata[1];
				$nilai=$cdata[4];
				
				$cek="SELECT jt.JTRANS_ID,ma.MA_ID,jt.JTRANS_NAMA,ma.MA_NAMA,dt.dk
FROM detil_transaksi dt INNER JOIN jenis_transaksi jt ON dt.fk_jenis_trans = jt.JTRANS_ID 
INNER JOIN ma_sak ma ON dt.fk_ma_sak = ma.MA_ID WHERE jt.JTRANS_ID = ".$id_trans."";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = $rw['JTRANS_NAMA']." -> ".$rw['MA_NAMA'];
					$d_k = $rw['dk'];
					$jenistrans = $rw['JTRANS_ID'];
					
					if($rw['dk']=='D'){
						$debet = $nilai;
						$kredit = 0;
					}
					else{
						$debet = 0;
						$kredit = $nilai;
					}
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$id_sak,'$tanggal','$no_bukti','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'',0,1)";
					$sDel ="DELETE FROM jurnal WHERE TGL='$tanggal' AND NO_KW='$no_bukti' AND URAIAN='$uraian'";
					//echo $sql."<br>";
					$rsPost=mysql_query($sDel);
				}
				
				$s_upd = "UPDATE $dbkeuangan.k_transaksi SET verifikasi=0, posting=0 WHERE id = ".$id_cc_rv;
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
			$actPosting = "Unposting";
		}
        break;
}

if ($filter!="") {
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
	$sorting="tgl"; //default sort
}

$sql = "SELECT * FROM (SELECT t.id,t.id_trans,DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,t.ket,t.no_bukti,t.nilai,jt.JTRANS_NAMA nama_trans FROM ".$dbkeuangan.".k_transaksi t INNER JOIN jenis_transaksi jt ON t.id_trans=jt.JTRANS_ID
WHERE t.tipe_trans=4 AND MONTH(t.tgl)=$bln AND YEAR(t.tgl)=$thn AND t.posting=$posting) AS gab".$filter;
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

while ($rows=mysql_fetch_array($rs)) {
	$sisip = $rows['id'].'|'.$rows['id_trans'].'|'.$rows['ket'].'|'.$rows['no_bukti'].'|'.$rows['nilai'].'|'.$rows['tgl'];
	$i++;
	$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows['ket'].chr(3).'0'.chr(6);
}

if ($dt!=$totpage.chr(5)) {
	if($actPosting=="Unposting"){
		$dt=substr($dt,0,strlen($dt)-1).chr(5)."Unposting";
	}
	else{
		$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
	}
	$dt=str_replace('"','\"',$dt);
}
else{
	if($actPosting=='Unposting'){
		$dt="0".chr(5).chr(5)."Unposting";
	}
	else{
		$dt="0".chr(5).chr(5).$_REQUEST['act'];
	}
}

mysql_free_result($rs);
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
<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort=$dbbilling.".b_ms_unit.kode";
$defaultsortObat="TANGGAL";
$statusProses='Fine';
//===============================
$id_sak_Bank_BLUD=33;

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$tahun = $_REQUEST["tahun"];
$bulan = $_REQUEST["bulan"];
$tipe = $_REQUEST["tipe"];
$cmbSupplier = $_REQUEST["cmbSupplier"];
$kso = $_REQUEST["kso"];
$ksoAsli = $kso;
$tempat = $_REQUEST["tempat"];
$kasir = $_REQUEST["kasir"];
$posting = $_REQUEST["posting"];
$cmbFarmasi = $_REQUEST["cmbFarmasi"];
$noSlip = $_REQUEST["noSlip"];
$bayar = $_REQUEST["bayar"];
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
	case 'postingHapusObat':
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[0];
				$no_bukti=$cdata[1];
				$id_obat=$cdata[2];
				$obat=$cdata[3];
				$qty=$cdata[4];
				$nilai=$cdata[5];
				$alasan=$cdata[6];
				$id_hapus=$cdata[7];
				
				$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$notrans=$rwPost["notrans"];
				$no_psg=$rwPost["no_psg"];
				
				$no_kw='AK.HPS.OBAT/'.tglSQL($tanggal);
				
				/*
				$cek="SELECT jt.JTRANS_ID,ma.MA_ID,jt.JTRANS_NAMA,ma.MA_NAMA,dt.dk
FROM detil_transaksi dt INNER JOIN jenis_transaksi jt ON dt.fk_jenis_trans = jt.JTRANS_ID 
INNER JOIN ma_sak ma ON dt.fk_ma_sak = ma.MA_ID WHERE jt.JTRANS_ID = ".$id_trans."";
				*/
				
				$cek="SELECT 
					  a.JTRANS_ID,
					  a.JTRANS_NAMA,
					  b.dk,
					  c.* 
					FROM
					  jenis_transaksi a 
					  INNER JOIN detil_transaksi b 
						ON a.JTRANS_ID = b.fk_jenis_trans 
					  INNER JOIN ma_sak c 
						ON b.fk_ma_sak = c.MA_ID 
					WHERE a.JTRANS_KODE LIKE '18101%'";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = "Hapus Obat : ".$obat." (".$qty.") - $alasan";
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
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$no_psg,$id_sak,'$tanggal','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti',0,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}
				
				$s_upd = "UPDATE $dbapotek.a_obat_hapus SET POSTING=1 WHERE ID_HAPUS = '$id_hapus'";
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tanggal=$cdata[0];
				$no_bukti=$cdata[1];
				$id_obat=$cdata[2];
				$obat=$cdata[3];
				$qty=$cdata[4];
				$nilai=$cdata[5];
				$alasan=$cdata[6];
				$id_hapus=$cdata[7];
				
				$cek="SELECT 
					  a.JTRANS_ID,
					  a.JTRANS_NAMA,
					  b.dk,
					  c.* 
					FROM
					  jenis_transaksi a 
					  INNER JOIN detil_transaksi b 
						ON a.JTRANS_ID = b.fk_jenis_trans 
					  INNER JOIN ma_sak c 
						ON b.fk_ma_sak = c.MA_ID 
					WHERE a.JTRANS_KODE LIKE '18101%'";
				//echo $cek."<br>";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
					$uraian = "Hapus Obat : ".$obat." (".$qty.") - $alasan";
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
					
					$sDel="DELETE FROM jurnal WHERE FK_SAK='$id_sak' AND TGL='$tanggal' AND NO_BUKTI='$no_bukti' AND FK_TRANS='$jenistrans'";
					//echo $sql."<br>";
					mysql_query($sDel);
				}
				
				$s_upd = "UPDATE $dbapotek.a_obat_hapus SET POSTING=0 WHERE ID_HAPUS = '$id_hapus'";
				//echo $s_upd."<br>";
				mysql_query($s_upd);
			}
			$actPosting='Unposting';
		}
		break;
}

if($tempat==0){
	$fUnit = "";
}else{
	$fUnit = "AND ".$dbbilling.".b_ms_unit.parent_id = '".$tempat."'";
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else {
	switch ($grd){
		case "HapusObat":
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
				$sql = "SELECT ".$dbapotek.".a_obat_hapus.ID_HAPUS,".$dbapotek.".a_obat_hapus.TGL_HAPUS, ".$dbapotek.".a_obat_hapus.NO_HAPUS, ".$dbapotek.".a_unit.UNIT_NAME, ".$dbapotek.".a_obat.OBAT_ID, ".$dbapotek.".a_obat.OBAT_NAMA, ".$dbapotek.".a_kepemilikan.NAMA, SUM(".$dbapotek.".a_obat_hapus.QTY) AS QTY, SUM(".$dbapotek.".a_obat_hapus.QTY*p.HARGA_BELI_SATUAN * (1-(p.DISKON/100) * 1.1)) AS nilai, ".$dbapotek.".a_obat_hapus.ALASAN
				FROM  ".$dbapotek.".a_obat INNER JOIN ".$dbapotek.".a_obat_hapus ON (".$dbapotek.".a_obat.OBAT_ID = ".$dbapotek.".a_obat_hapus.OBAT_ID) 
				INNER JOIN ".$dbapotek.".a_kepemilikan ON (".$dbapotek.".a_kepemilikan.ID = ".$dbapotek.".a_obat_hapus.KEPEMILIKAN_ID) 
				INNER JOIN ".$dbapotek.".a_unit ON (".$dbapotek.".a_unit.UNIT_ID = ".$dbapotek.".a_obat_hapus.UNIT_ID) 
				INNER JOIN ".$dbapotek.".a_penerimaan p ON p.ID=".$dbapotek.".a_obat_hapus.PENERIMAAN_ID
				WHERE ".$dbapotek.".a_obat_hapus.POSTING=$posting AND (MONTH(".$dbapotek.".a_obat_hapus.TGL_HAPUS)=$bulan AND YEAR(".$dbapotek.".a_obat_hapus.TGL_HAPUS)=$tahun) ".$filter."
				GROUP BY ".$dbapotek.".a_obat_hapus.NO_HAPUS, ".$dbapotek.".a_unit.UNIT_NAME, ".$dbapotek.".a_obat.OBAT_NAMA, ".$dbapotek.".a_kepemilikan.NAMA";
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
		case "HapusObat":
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$dt.=$rows['TGL_HAPUS']."|".$rows['OBAT_ID']."|".$rows['nilai']."|".$rows['ID_HAPUS'].chr(3).$i.chr(3).date("d/m/Y",strtotime($rows['TGL_HAPUS'])).chr(3).$rows["NO_HAPUS"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["NAMA"].chr(3).$rows["QTY"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows["ALASAN"].chr(3)."0".chr(6);
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

	if ($grd=="penerimaanBillingKasir"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntotSlip,0,",",".").chr(3).number_format($ntot1,0,",",".");
	}elseif($grd=="pembelianObat"){
		$dt=$dt.chr(3).number_format($totdpp,2,",",".").chr(3).number_format($totppn,2,",",".").chr(3).number_format($totdppppn,2,",",".");
	}elseif($grd=="pengeluaranLain"){
		$dt=$dt.chr(3).number_format($totnilai,2,",",".");
	}

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
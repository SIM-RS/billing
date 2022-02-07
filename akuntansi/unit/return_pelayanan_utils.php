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
	case "postingReturnPelayanan":
		$tanggal=$_REQUEST['tanggal'];
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tgl = $cdata[0];
				$unit_id = $cdata[1];
				$kso_id = $cdata[2];
				$nilai = $cdata[3];
				$retur_id = $cdata[4];
				$no_bukti = $cdata[5];
				
				$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$notrans=$rwPost["notrans"];
				$no_psg=$rwPost["no_psg"];
				
				$no_kw='AK.RET.PLYN/'.$tanggal;
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso_id";
				$rsCek=mysql_query($sql);
				$rwCek=mysql_fetch_array($rsCek);
				$uraian="Return Pelayanan : ".$unit." - ".$rwCek["nama"];
							
				$cek="SELECT 
				  a.JTRANS_KODE,
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
				WHERE a.JTRANS_KODE LIKE '1111c%'";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
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
						
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$no_psg,$id_sak,'$tgl','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti','$kso_id',1)";
					mysql_query($sql);
				}
				$s_upd = "UPDATE ".$dbbilling.".b_return SET posting=1 WHERE id IN($retur_id)";
				mysql_query($s_upd);
			}
		}else{
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$tgl = $cdata[0];
				$unit_id = $cdata[1];
				$kso_id = $cdata[2];
				$nilai = $cdata[3];
				$retur_id = $cdata[4];
				$no_bukti = $cdata[5];
				
				$no_kw='AK.RET.PLYN/'.$tanggal;
				
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$unit_id";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso_id";
				$rsCek=mysql_query($sql);
				$rwCek=mysql_fetch_array($rsCek);
				$uraian="Return Pelayanan : ".$unit." - ".$rwCek["nama"];
							
				$cek="SELECT 
				  a.JTRANS_KODE,
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
				WHERE a.JTRANS_KODE LIKE '1111c%'";
				$q=mysql_query($cek);
				while($rw=mysql_fetch_array($q)){
					$id_sak=$rw['MA_ID'];
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
						
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) VALUES($notrans,$id_sak,'$tgl','$no_kw','$uraian','$debet','$kredit',now(),$idUser,'$d_k',0,'$jenistrans','$jenistrans',1,'$no_bukti','$kso_id',1)";
					$sDel="DELETE FROM jurnal WHERE FK_SAK=$id_sak AND TGL='$tgl' AND URAIAN='$uraian' AND FK_TRANS=$jenistrans";
					mysql_query($sDel);
				}
				$s_upd = "UPDATE ".$dbbilling.".b_return SET posting=0 WHERE id IN($retur_id)";
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
		case "ReturnPelayanan":
			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			if($tempat==0){
				$ftempat1 = "";
				$ftempat2 = "";
			}else{
				$ftempat1 = "AND ".$dbbilling.".u.parent_id = '".$tempat."'";
				$ftempat2 = "AND ".$dbbilling.".mu.parent_id = '".$tempat."'";
			}
			$fposting = "AND r.posting=".$_REQUEST['posting'];

			$fkso = " and kso.id=".$_REQUEST['kso'];
			$ftgl = " and r.tgl_return='".tglSQL($_REQUEST['tanggal'])."'";
			$sql="SELECT 
				  * 
				FROM
				  (SELECT
				    GROUP_CONCAT(r.id) AS id,
					r.no_return,
				    r.tgl_return AS tgl,
					u.id AS unit_id,
					u.nama AS unit_nama,
					kso.id AS kso_id,
					kso.nama AS kso_nama,
					SUM(bt.nilai) AS nilai 
				  FROM
					$dbbilling.b_return r 
					INNER JOIN $dbbilling.b_bayar_tindakan bt 
					  ON bt.id = r.bayar_tindakan_id 
					INNER JOIN $dbbilling.b_tindakan t 
					  ON t.id = bt.tindakan_id 
					INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk 
					  ON mtk.id = t.ms_tindakan_kelas_id 
					INNER JOIN $dbbilling.b_ms_tindakan mt 
					  ON mt.id = mtk.ms_tindakan_id 
					INNER JOIN $dbbilling.b_pelayanan pl 
					  ON pl.id = t.pelayanan_id 
					INNER JOIN $dbbilling.b_ms_pasien ps 
					  ON ps.id = pl.pasien_id 
					INNER JOIN $dbbilling.b_ms_unit u 
					  ON u.id = pl.unit_id 
					INNER JOIN $dbbilling.b_ms_kso kso 
					  ON kso.id = pl.kso_id 
				  WHERE bt.tipe = 0 
					$ftgl
					$fkso
					$ftempat1
					$fposting
				  GROUP BY u.nama 
				  UNION
				  ALL 
				  SELECT
				    GROUP_CONCAT(r.id) AS id,
					r.no_return,
				    r.tgl_return AS tgl,
					mu.id AS unit_id,
					mu.nama AS unit_nama,
					kso.id AS kso_id,
					kso.nama AS kso_nama,
					SUM(bt.nilai) AS nilai 
				  FROM
					$dbbilling.b_pelayanan p 
					INNER JOIN $dbbilling.b_ms_unit mu 
					  ON p.unit_id = mu.id 
					INNER JOIN $dbbilling.b_tindakan_kamar t 
					  ON p.id = t.pelayanan_id 
					LEFT JOIN $dbbilling.b_ms_unit n 
					  ON n.id = mu.parent_id 
					INNER JOIN $dbbilling.b_ms_kamar tk 
					  ON tk.id = t.kamar_id 
					INNER JOIN $dbbilling.b_bayar_tindakan bt 
					  ON bt.tindakan_id = t.id 
					INNER JOIN $dbbilling.b_tindakan ti 
					  ON ti.id = bt.tindakan_id 
					INNER JOIN $dbbilling.b_ms_tindakan_kelas btk 
					  ON btk.id = ti.ms_tindakan_kelas_id 
					INNER JOIN $dbbilling.b_ms_tindakan mt 
					  ON mt.id = btk.ms_tindakan_id 
					INNER JOIN $dbbilling.b_ms_kelas mk 
					  ON mk.id = btk.ms_kelas_id 
					INNER JOIN $dbbilling.b_return r 
					  ON r.bayar_tindakan_id = bt.id 
					INNER JOIN $dbbilling.b_ms_pasien ps 
					  ON ps.id = p.pasien_id 
					INNER JOIN $dbbilling.b_ms_kso kso 
					  ON kso.id = p.kso_id 
				  WHERE bt.tipe = 1 
					AND p.jenis_kunjungan = 3 
					$ftgl
					$fkso
					$ftempat2
					$fposting
				  GROUP BY mu.nama) AS tbl1";
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
		case "ReturnPelayanan":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$dt.=$rows["tgl"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai"]."|".$rows["id"]."|".$rows["no_return"].chr(3).$i.chr(3).$rows["unit_nama"].chr(3).$rows["kso_nama"].chr(3).number_format($rows["nilai"],0,',','.').chr(3)."0".chr(6);
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
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
	case "VerifikasiPengeluaranLain":
		//DARI FOLDER akuntansi_
		$arfdata=explode(chr(6),$fdata);
		if ($posting==0){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=1 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()>0){
					$statusProses='Error';
				}
			}
		}else if($posting==1){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="UPDATE ".$dbkeuangan.".k_transaksi SET posting=1 WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()>0){
					$statusProses='Error';
				}else{
					$sel = "select * from $dbkeuangan.k_transaksi where id='$cdata[0]'";
					//echo $sel."<br>";
					$qu = mysql_query($sel);
					$row = mysql_fetch_array($qu);
					$noBukti=$row['no_bukti'];
					$no_post=$row['no_post'];

					$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans,1 AS no_psg FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
					$no_trans=1;$no_psg=1;
					if ($rows=mysql_fetch_array($rs1)){
						$no_trans=$rows["no_trans"];
						$no_psg=$rows["no_psg"];
					}
					$sql="UPDATE jurnal SET no_trans='$no_trans' where FK_ID_POSTING='$no_post'";
					//echo $sql."<br>";
					mysql_query($sql);
				}
			}
			$actPosting='Unverifikasi';
		}else if($posting==2){
			for ($i=0;$i<count($arfdata);$i++){
				$cdata=explode(chr(5),$arfdata[$i]);
				$sel = "select * from $dbkeuangan.k_transaksi where id='$cdata[0]'";
				//echo $sel."<br>";
				$qu = mysql_query($sel);
				$row = mysql_fetch_array($qu);
				$noBukti=$row['no_bukti'];
				$no_post=$row['no_post'];
				$TglBayar=$row['tgl'];
				$TglBayarPajak = $row['tgl_klaim'];
				//echo $TglBayar."<br>";
				$sql = "update ".$dbkeuangan.".k_transaksi set posting=0 where id = '$cdata[0]'";
				//echo $sql."<br>";
				mysql_query($sql);
				
				$sql="UPDATE jurnal SET no_trans='0' where FK_ID_POSTING='$no_post'";
				//echo $sql."<br>";
				mysql_query($sql);
				
				/*$sql="delete from $dbkeuangan.k_transaksi_detail where transaksi_id='$cdata[0]' AND pajak_id>0";
				//echo $sql."<br>";
				mysql_query($sql);
				//******************************						
				$sql="delete from jurnal where tgl='$TglBayar' and no_kw='$noBukti'";
				//echo $sql."<br>";
				mysql_query($sql);
				
				if ($TglBayarPajak!="" && $TglBayarPajak!=$TglBayar){
					$sql="delete from jurnal where tgl='$TglBayarPajak' and no_kw='$noBukti'";
					//echo $sql."<br>";
					mysql_query($sql);
				}*/
				//******************************
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
		case "pengeluaranLain":
			if ($sorting=="") {
				$sorting="id";
			}
			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($tipe==1){
				//$strTipe=" and t.jenis_supplier>0";
				$strSupplier=" AND t.jenis_supplier=$cmbSupplier";
			}else{
				//$strTipe=" and t.jenis_supplier=0";
				$strSupplier=" and t.jenis_supplier=0";
			}
			
			$strPosting=" and t.verifikasi='1'";
			if ($posting==1){
				$strPosting=" and t.verifikasi='1' and t.posting='0'";
			}elseif($posting==2){
				$strPosting=" and t.verifikasi='1' and t.posting='1'";
			}
			
			$sql2 = "select * from (select t.id, id_trans, jt.JTRANS_NAMA as nama_trans, date_format(tgl,'%d-%m-%Y') as tgl, no_bukti,t.no_faktur, t.jenis_layanan
		 , uj.nama as nama_jl, unit_id, ut.nama as nama_tl, nilai_sim, nilai, IF((t.no_faktur='' OR t.no_faktur IS NULL),t.ket,CONCAT(t.ket,' (',t.no_faktur,')')) ket,t.ket ket1, IF(t.verifikasi=1,'Sudah','Belum') verifikasi,t.verifikasi verifikasiId, jenis_supplier,IF(jenis_supplier='1','(Supplier Obat)',IF(jenis_supplier='2','(Supplier Barang)','')) as nama_jenis_supplier, supplier_id
			from ".$dbkeuangan.".k_transaksi t
			left join ".$dbakuntansi.".ak_ms_unit uj on t.jenis_layanan = uj.id
			left join ".$dbakuntansi.".ak_ms_unit ut on t.unit_id = ut.id
			INNER JOIN ".$dbakuntansi.".jenis_transaksi jt ON t.id_trans = jt.JTRANS_ID
			where tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir' AND t.tipe_trans='2'".$strSupplier.$strPosting.") a1 $filter";
			//echo $sql2."<br>";
			$sql=$sql2." ORDER BY ".$sorting;
			$sqlTot="SELECT SUM(nilai) AS jmldppppn FROM (".$sql2.") AS ttot";
			//echo $sqlTot."<br>";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$totnilai=$rwTot["jmldppppn"];
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
		case "pengeluaranLain":
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$cket="";
				if ($rows['unit_id']!=0) $cket=" - ".$rows['nama_tl'];
				
				$detail="";
				$ntot=0;
				//if ($rows["id_trans"]==8 || $rows["id_trans"]==9 || $rows["id_trans"]==10 || $rows["id_trans"]==15){
					$sql2="SELECT * FROM $dbkeuangan.k_transaksi_detail td WHERE td.transaksi_id=".$rows["id"]." AND pajak_id=0";
					$rsdetail=mysql_query($sql2);
					while ($rwdetail=mysql_fetch_array($rsdetail)){
						$detail .="#".$rwdetail["unit_id"]."*".number_format($rwdetail["nilai"],2,",",".");
						$ntot +=$rwdetail["nilai"];
					}
				//}
				
				$dt.=$rows["id"]."|".$rows["id_trans"]."|".$detail."|".number_format($ntot,2,",",".")."|".$rows['no_bukti']."|".$rows['tgl'].chr(3).$i.chr(3).date("d/m/Y",strtotime($rows['tgl'])).chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows["ket"].$cket.chr(3)."0".chr(6);
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
		$dt=$dt.chr(3).number_format($ntot,2,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,2,",",".").chr(3).number_format($ntotSlip,2,",",".").chr(3).number_format($ntot1,2,",",".");
	}elseif($grd=="pembelianObat"){
		$dt=$dt.chr(3).number_format($totdpp,0,",",".").chr(3).number_format($totppn,0,",",".").chr(3).number_format($totdppppn,0,",",".");
	}elseif($grd=="pengeluaranLain"){
		$dt=$dt.chr(3).number_format($totnilai,0,",",".");
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
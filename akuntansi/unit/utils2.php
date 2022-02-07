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

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$tahun = $_REQUEST["tahun"];
$bulan = $_REQUEST["bulan"];
$tipe = $_REQUEST["tipe"];
$cmbSupplier = $_REQUEST["cmbSupplier"];
$kso = $_REQUEST["kso"];
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
	case "posting":
		//$noSlip=$_REQUEST["noSlip"];
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$kso=$cdata[2];
				$tanggalSlip=tglSQL($cdata[9]);
				
				$sql="update ".$dbkeuangan.".k_transaksi set posting='1' where id='$cdata[8]'";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0)
				{
					//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ".$dbakuntansi.".ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[1]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					
					$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$cdata[0]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ckasir=$rwPost["nama"];
					
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Penerimaan Kasir : ".$ckasir.", ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$nokw=$cdata[5];
					$no_bukti=$cdata[5];
										
					if ($kso==1)
					{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_sak_bank=33;	//Bank Jatim - R/K 0261019205 (Bank BLUD)
						$id_piutang=44;	//Piutang Px Umum
						$jenistrans=7;	//Saat Px Umum Bayar
					}
					else
					{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_sak_bank=33;	//Bank Jatim - R/K 0261019205 (Bank BLUD)
						$id_piutang=45;	//Piutang KSO beban Px
						$jenistrans=14;	//Saat Px KSO Bayar
					}

					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
					$no_psg=$rwPost["no_psg"];
					//=====insert into Kas==========
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggalSlip','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
	VALUES($notrans,$no_psg,$id_piutang,'$tanggalSlip','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					//=====insert into bank==========
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak_bank,'$tanggalSlip','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) 
		VALUES($notrans,$no_psg,$id_sak,'$tanggalSlip','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				}
				else
				{
					$statusProses='Error';
				}
			}
		}
		else
		{

			//DIAMBIL DARI FOLDER AKUNTANSI_ (*BUKA)
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$kso=$cdata[2];
				
				$sql="update ".$dbkeuangan.".k_transaksi set posting='0' where id='$cdata[8]'";
				mysql_query($sql);
				
				//======delete from jurnal========
				$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ".$dbakuntansi.".ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[1]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$idunit=$rwPost["id"];
				$unit=$rwPost["nama"];
				$kdunit=$rwPost["kode"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$cdata[0]";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ckasir=$rwPost["nama"];
				
				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$ksoNama=$rwPost["nama"];
				$uraian="Penerimaan Kasir : ".$ckasir.", ".$unit." ".$tanggalAsli." - ".$ksoNama;
				$kdkso=$rwPost["kode_ak"];
				$nokw=$cdata[5];
				$no_bukti=$cdata[5];
									
				if ($kso==1)
				{
					$id_sak=8;	//Kas di Bendahara Penerimaan
					$id_sak_bank=33;	//Bank Jatim - R/K 0261019205 (Bank BLUD)
					$id_piutang=44;	//Piutang Px Umum
					$jenistrans=7;	//Saat Px Umum Bayar
				}
				else
				{
					$id_sak=8;	//Kas di Bendahara Penerimaan
					$id_sak_bank=33;	//Bank Jatim - R/K 0261019205 (Bank BLUD)
					$id_piutang=45;	//Piutang KSO beban Px
					$jenistrans=14;	//Saat Px KSO Bayar
				}
				
				$sDel = "DELETE FROM jurnal WHERE TGL='$tanggal' AND NO_KW='$nokw' AND URAIAN='$uraian' AND FK_TRANS=$jenistrans AND NO_BUKTI='$no_bukti'";
				mysql_query($sDel);
			}
			$actPosting='Unposting';
			//DIAMBIL DARI FOLDER AKUNTANSI_ (*TUTUP)
		}
		break;
}


if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else {
	switch ($grd){
		case "loadkasir":
			$dt='<option value="0">SEMUA</option>';
			$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
            while($wTmp = mysql_fetch_array($qTmp)){
				$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
			}
			echo $dt;
			return;
			break;
		
		case "penerimaanBillingKasir":			
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($sorting=="") {
				$sorting="";
			}
			else
			{
				$sorting="ORDER BY t2.".$sorting;
			}
			
			
			if ($kasir=="0")
			{
				$fkasir="";
			}
			else
			{
				$fkasir=" AND t2.user_act='".$kasir."'";
			}
			$sql = "SELECT * FROM (
					SELECT 
					  k.id,
					  k.unit_id_billing AS unit_id,
					  k.kso_id,
					  k.kasir_id AS user_act,
					  k.nilai_sim,
					  k.nilai AS nilai_slip,
					  k.tgl,
					  DATE_FORMAT(k.tgl_klaim,'%d-%m-%Y') tgl_klaim,
					  k.posting,
					  k.no_bukti,
      				  k.id_trans,
					  u.nama AS unit,
					  kso.nama AS kso,
					  pg.nama 
					FROM
					  $dbkeuangan.k_transaksi k 
					  INNER JOIN $dbbilling.b_bayar b 
						ON k.fk_id = b.id 
					  INNER JOIN $dbbilling.b_ms_pasien b 
						ON k.fk_id = b.id 
					  INNER JOIN $dbbilling.b_ms_unit u 
						ON k.unit_id_billing = u.id 
					  INNER JOIN $dbbilling.b_ms_kso kso 
						ON kso.id = k.kso_id 
					  INNER JOIN $dbbilling.b_ms_pegawai pg 
						ON pg.id = k.kasir_id 
					 ) as t2 WHERE t2.posting='$posting' AND t2.tgl = '$tanggal'  AND t2.id_trans = '38' $fkasir $filter $sorting"; //echo $sql;
			
			break;
		
	}
	
    //echo $sql."<br>";
    $perpage = 100;
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs).'<br>';
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";


    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    switch($grd){
		
		case "penerimaanBillingKasir":
			$ntot_sim=0;
			$ntot_slip=0;
			while ($rows=mysql_fetch_array($rs)) 
			{		
				if($posting==0)
				{
					$nn = "0";
				}
				else
				{
					$nn = "<img src='../icon/ok.png' width='20px' height='20px;'>";
				}
				$i++;
				$nilai_sim=$rows["nilai_sim"];
				$nilai_slip=$rows["nilai_slip"];
				$ntot_sim+=$nilai_sim;
				$ntot_slip+=$nilai_slip;
				$dt.=$rows["user_act"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai_sim"]."|".$rows["nilai_slip"]."|".$rows["no_bukti"]."|".$rows["tgl"]."|".$rows["id"]."|".$rows["tgl_klaim"].chr(3).$i.chr(3).$rows["tgl_klaim"].chr(3).$rows["unit"].chr(3).$rows["kso"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai_sim"],0,",",".").chr(3).number_format($rows["nilai_slip"],0,",",".").chr(3).$nn.chr(6);
				
			}
			break;
		
    }

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
	
	if ($grd=="penerimaanBillingKasir"){
		$dt=$dt.chr(3).number_format($ntot_sim,0,",",".").chr(3).number_format($ntot_slip,0,",",".");
	}elseif($grd=="penjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntot1,0,",",".");
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
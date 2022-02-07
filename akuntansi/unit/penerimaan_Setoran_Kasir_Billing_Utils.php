<?php
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort="tgl_klaim1,no_bukti";
$defaultsortObat="TANGGAL";
$statusProses='Fine';
//===============================
$idpost=gmdate('YmdHis',mktime(date('H')+7));
$id_k_trans=$idpost;

$IdTrans=38;
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
$no_bukti = $_REQUEST["no_bukti"];
$nokw=$no_bukti;
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

//echo "Act=".$act."<br>";
switch ($act){
	case "posting":
		//$noSlip=$_REQUEST["noSlip"];
		//echo $fdata."<br>";
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				//$fk_id=$cdata[7];
				//$kso=$cdata[2];
				$user_kasir=$cdata[0];
				$nslip=$cdata[1];
				$tanggalSlip=$cdata[2];
				$tglP=$tanggalSlip;
				$no_bukti=$nslip;
				$no_post=$cdata[3];
				//$id_k_trans++;
				if ($nokw=="") $nokw=$no_bukti;
				
				$sql="update ".$dbkeuangan.".k_transaksi set posting='1' 
					where kasir_id='$user_kasir' AND tgl_klaim='$tanggalSlip' AND id_trans='$IdTrans' AND no_bukti = '$nslip'";
				//echo $sql.";<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()==0 && mysql_affected_rows()>0)
				{						
					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];
				
					$sql="update ".$dbakuntansi.".jurnal set NO_TRANS='$notrans',TGL_VERIFIKASI=NOW(),FK_IDUSER='$idUser',VERIFIKASI='1' 
						WHERE FK_ID_USER_APP='$user_kasir' AND FK_ID_POSTING='$no_post' AND NO_BUKTI='$nslip'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
							
			// 		$sql="SELECT
			// 				  t.id,
			// 				  t.unit_id_billing,
			// 				  t.kso_id,
			// 				  t.tgl,
  		// 					  SUM(t.nilai_sim)      AS nilai_sim,
			// 				  SUM(t.nilai)      AS nilai,
			// 				  kso.tipe_kso,
			// 				  IF (kso.tipe_kso=0,mu.akun_pend_eksternal,mu.akun_pend_internal) AS akun_pend,
			// 				  mu.akun_pend_internal,
			// 				  mu.akun_pend_eksternal
			// 				FROM $dbkeuangan.k_transaksi t
			// 					INNER JOIN $dbbilling.b_ms_kso kso
    	// 							ON t.kso_id = kso.id
			// 					LEFT JOIN $dbakuntansi.ak_ms_unit mu
    	// 							ON t.unit_id_billing = mu.id
			// 				WHERE t.kasir_id = '$user_kasir'
			// 					AND t.no_bukti = '$nslip'
			// 					AND t.tgl_klaim = '$tanggalSlip'
			// 					AND t.id_trans = '$IdTrans'
			// 				GROUP BY t.unit_id_billing,t.kso_id,t.tgl 
			// 				ORDER BY t.id";
			// 		//echo $sql.";<br>";
			// 		$rsData=mysql_query($sql);
			// 		$ntotal=0;
			// 		$jTransSetor=345;	// 2005 - Kas Bendahara Penerimaan - Bank BLUD
			// 		while ($rwData=mysql_fetch_array($rsData)){
			// 			//$id_k_trans=0;
			// 			//$tglP=$rwData["tgl"];
			// 			$kso=$rwData["kso_id"];
			// 			$unit_id=$rwData["unit_id_billing"];
			// 			$idunit=$unit_id;
			// 			$akun_pend=$rwData["akun_pend"];
			// 			$nilai_sim=$rwData["nilai_sim"];
			// 			$nilai_slip=$rwData["nilai"];
			// 			$ntotal +=$nilai_slip;
						
			// 			if ($unit_id<>0){
			// 				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id='$kso'";
			// 				//echo $sql.";<br>";
			// 				$rsKso=mysql_query($sql);
			// 				$rwKso=mysql_fetch_array($rsKso);
			// 				$ctipeKso=$rwKso["type"];
	
			// 				$sql="SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
			// 				//echo $sql."<br>";
			// 				$rsPost=mysql_query($sql);
			// 				$rwPost=mysql_fetch_array($rsPost);
			// 				$no_psg=$rwPost["no_psg"];
			// 				//======insert into jurnal========
			// 				$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$user_kasir";
			// 				//echo $sql.";<br>";
			// 				$rsPost=mysql_query($sql);
			// 				$rwPost=mysql_fetch_array($rsPost);
			// 				$ckasir=$rwPost["nama"];
							
			// 				$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
			// 				//echo $sql.";<br>";
			// 				$rsPost=mysql_query($sql);
			// 				$rwPost=mysql_fetch_array($rsPost);
			// 				$ksoNama=$rwPost["nama"];
			// 				$uraian="Penerimaan Kasir : ".$ckasir.", Slip : $nslip, ".$tanggalAsli." - ".$ksoNama;
			// 				$kdkso=$rwPost["kode_ak"];
							
			// 				$id_sak=4;	//Kas *decyber awalnya 5 kas pendapatan
			// 				$id_pendapatan=$akun_pend;	//Pendapatan Kl.. Eks/Inter (Tunai)
			// 				$jenistrans=9;	//1112a - Terjadinya Transaksi Pendapatan (Tunai) - Tipe: Normal
							
			// 				//=====insert into Kas==========Diganti Bank========
			// 				$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// 	VALUES('$id_k_trans','$user_kasir',$notrans,$no_psg,$id_sak,'$tglP','$nokw','$uraian',$nilai_slip,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1,'$flag')";
			// 				// echo $sql."<br>4";
			// 				$rsPost=mysql_query($sql);
							
			// 				$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// VALUES('$id_k_trans','$user_kasir',$notrans,$no_psg,$id_pendapatan,'$tglP','$nokw','$uraian',0,$nilai_slip,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1,'$flag')";
			// 				// echo $sql."<br> 1";
			// 				$rsPost=mysql_query($sql);
			// 			}else{
			// 				$id_sak=5;	//Kas di Bendahara Penerimaan
			// 				$id_sak_ppn=2234;	//Hutang PPN Keluaran, COA baru *decyber
			// 				$jenistrans=9;	//1112a - Terjadinya Transaksi Pendapatan (Tunai) - Tipe: Normal
			// 				//=====insert into Hutang PPN==========
			// 				$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// 	VALUES('$id_k_trans','$user_kasir',$notrans,$no_psg,$id_sak,'$tglP','$nokw','$uraian',$nilai_slip,0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1,'$flag')";
			// 				// echo $sql."<br> 2";
			// 				$rsPost=mysql_query($sql);
							
			// 				$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,flag) 
			// VALUES('$id_k_trans','$user_kasir',$notrans,$no_psg,$id_sak_ppn,'$tglP','$nokw','$uraian',0,$nilai_slip,now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,1,'$flag')";
			// 				// echo $sql."<br> 3";
			// 				$rsPost=mysql_query($sql);
						
			// 			}
			// 		}
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
				$cdata=explode("|",$arfdata[$i]);
				$user_kasir=$cdata[0];
				$nslip=$cdata[1];
				$tanggalSlip=$cdata[2];
				$no_post=$cdata[3];
				
				$sql="update ".$dbkeuangan.".k_transaksi set posting='0'
					where kasir_id='$user_kasir' AND tgl_klaim='$tanggalSlip' AND no_post='$no_post' AND id_trans='$IdTrans' AND no_bukti = '$nslip'";
				echo $sql."<br>ini keuangan";

				$rs=mysql_query($sql);
				$sDel1 = "DELETE FROM jurnal WHERE FK_ID_USER_APP='$user_kasir' AND NO_BUKTI='$nslip'";
				mysql_query($sDel1);// decyber
				echo $sDel1."<br>ini jurnal";

				if (mysql_errno()==0 && mysql_affected_rows()>0){
				

					$sDel = "UPDATE jurnal SET NO_TRANS='0',TGL_VERIFIKASI=NULL,FK_IDUSER='0',VERIFIKASI='0' 
							WHERE FK_ID_USER_APP='$user_kasir' AND FK_ID_POSTING='$no_post' AND NO_BUKTI='$nslip'";
					//echo $sDel."<br>";
					mysql_query($sDel);
				}
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
		case "loadkasir":
			$dt='<option value="0">SEMUA</option>';
			//$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
			$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE DATE(b.disetor_tgl)='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
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
				$sorting=$defaultsort;
			}
			
			
			if ($kasir=="0")
			{
				$fkasir="";
			}
			else
			{
				$fkasir=" AND t.kasir_id='".$kasir."'";
			}
			
			//$fTgl=" AND t.tgl = '$tanggal' ";
			$fTgl=" AND t.tgl_klaim = '$tanggal' ";
						
			$sql="SELECT gab.*
					FROM (SELECT
							t.no_bukti,
							t.no_post,
							t.kasir_id  AS user_act,
							pg.nama,
							SUM(t.nilai_sim) AS nilai_sim,
							SUM(t.nilai) AS nilai_slip,
							DATE_FORMAT(t.tgl,'%d-%m-%Y')    tgl,
							DATE_FORMAT(t.tgl_klaim,'%d-%m-%Y')    tgl_klaim,
							t.tgl_klaim    tgl_klaim1,
							t.posting,
							t.id_trans
						  FROM $dbkeuangan.k_transaksi t
							INNER JOIN $dbbilling.b_bayar b
							  ON t.fk_id = b.id
							INNER JOIN $dbbilling.b_kunjungan k
							  ON b.kunjungan_id = k.id
							INNER JOIN $dbbilling.b_ms_pasien mp
							  ON k.pasien_id = mp.id
							/*INNER JOIN $dbbilling.b_ms_unit u
							  ON t.unit_id_billing = u.id*/
							INNER JOIN $dbbilling.b_ms_kso kso
							  ON kso.id = t.kso_id
							INNER JOIN $dbbilling.b_ms_pegawai pg
							  ON pg.id = t.kasir_id
						  WHERE t.posting = '$posting'
							  $fTgl
							  AND t.id_trans = '$IdTrans'
							  $fkasir
						  GROUP BY t.kasir_id,t.no_bukti) AS gab
					WHERE 1 = 1 $filter 
					ORDER BY ".$sorting;
				//  echo $sql;
		
				$sqlSum = "select ifnull(sum(nilai_sim),0) as totnilai_sim,ifnull(sum(nilai_slip),0) as totnilai_slip from (".$sql.") sql36";
				$rsSum = mysql_query($sqlSum);
				$rwSum = mysql_fetch_array($rsSum);
				$stotnilai_sim = $rwSum["totnilai_sim"];
				$stotnilai_slip = $rwSum["totnilai_slip"];
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
				//if($posting==0)
				//{
					$nn = "0";
				/*}
				else
				{
					$nn = "<img src='../icon/ok.png' width='20px' height='20px;'>";
				}*/
				$i++;
				$nilai_sim=$rows["nilai_sim"];
				$nilai_slip=$rows["nilai_slip"];
				$sisip=$rows["user_act"]."|".$rows["no_bukti"]."|".$rows["tgl_klaim1"]."|".$rows["no_post"]."|".$rows["nama"];
				$dt.=$sisip.chr(3).$i.chr(3).$rows["tgl_klaim"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai_slip"],0,",",".").chr(3).$nn.chr(6);
				
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
		$dt=$dt.chr(3).number_format($stotnilai_sim,0,",",".").chr(3).number_format($stotnilai_slip,0,",",".");
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
<?php 
//session_start();
//$user = $_SESSION['akun_iduser'];
$iduser = $_REQUEST["user"];
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page = $_REQUEST["page"];
$sorting = $_REQUEST["sorting"];
$filter = $_REQUEST["filter"];
//====================================
$pilihan = $_REQUEST["pilihan"];
$tgl1 = explode("-",$_REQUEST["tgl1"]);
$tgl1 = $tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
$tgl2 = explode("-",$_REQUEST["tgl2"]);
$tgl2 = $tgl2[2]."-".$tgl2[1]."-".$tgl2[0];
$defaultsort = "vendor_id";
$q = $_REQUEST["jnsbrg"];
$cmb = $_REQUEST["cmb"];
$data = $_REQUEST["data"];

if ($filter!=""){
    $filter=explode("|",$filter);
    $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
    $sorting=$defaultsort;
}
//echo $cmb."<br>";
switch(strtolower($_REQUEST['act'])) {
	case 'posting':
		$data = explode("*", $data);
		$x = count($data)-1;
		switch ($cmb){
			case '0':
				for($v=0;$v<$x;$v++){
					$d = explode("|",$data[$v]);
					$tgltrans=tglSQL($d[4]);
					$sql="select * from ".$dbakuntansi.".ak_posting where tipe=13 and no_bukti='".$d[0]."|".$d[8]."' and no_terima='".$d[1]."' and no_faktur='".$d[9]."' AND no_po='".$d[7]."' and id_kso_pbf_umum = '".$d[2]."' and biayaRS_DPP_PPN = '".$d[3]."' and tgl_trans = '".$tgltrans."'";
					//echo $sql."<br>";
					$d1 = mysql_query($sql);
					$ro = mysql_num_rows($d1);
					if($ro==0){
						//============Update Penerimaan Gudang Umum, bayar=1===========================
						$ma_HU_Suplier_Umum=379;
						$ijenis=0;
						if ($q == 1) $ijenis=1;
						$sql1 = "insert into ".$dbakuntansi.".ak_posting(no_bukti,no_terima,no_faktur,no_po,id_kso_pbf_umum,tipe,jenis,biayaRS_DPP_PPN,tgl_trans,tgl_act,user_act)
						values('".$d[0]."|".$d[8]."','$d[1]','$d[9]','$d[7]','$d[2]','13','$ijenis','$d[3]','".$tgltrans."',sysdate(),'$iduser')";
						//echo $sql1."<br>";
						$r = mysql_query($sql1);
						if($q == 2){
							//$pil = substr($d[0],0,2);
							//$pil = explode("|",$d[0]);
							switch($d[8]){
								case '11402':
									$pil = 288;
									break;
								case '11403':
									$pil = 282;
									break;
								case '11404':
									$pil = 294;
									break;
								case '11405':
									$pil = 41;
									break;
								case '11406':
									$pil = 53;
									break;
								case '11407':
									$pil = 300;
									break;
								case '11408':
									$pil = 47;									
									break;								
								case '1140901':
								case '1140902':
								case '1140903':
								case '1140904':
								case '1140905':
									$pil = 35;
									break;
								case '11410':
									$pil = 65;
									break;
								case '11411':
									$pil = 390;
									break;
								case '11412':
									$pil = 336;
									break;
								default:
									$pil = 336;
									break;
							}
							
							//$ma_HU_Suplier_Umum=379;
							
							$no = mysql_query("SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal");
							$data_no = mysql_fetch_array($no);
							$notrans = $data_no["notrans"];
							$no_psg=$data_no["no_psg"];
							
							$uraian = " Pembelian : ".$d[0]."-".$d[6];
							
							$inj1 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
			D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
			VALUES ('$notrans','$no_psg','$d[5]','$tgltrans','$d[1]','$uraian','$d[3]',0,sysdate(),'$iduser','D','0','$pil','$pil','$d[7]|$d[8]','$d[2]',1)";
							//echo $inj1."<br>";
							mysql_query($inj1);
							$inj2 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
			D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
			VALUES ('$notrans','$no_psg','$ma_HU_Suplier_Umum','$tgltrans','$d[1]','$uraian',0,'$d[3]',sysdate(),'$iduser','K','0','$pil','$pil','$d[7]|$d[8]','$d[2]',1)";
							//echo $inj2."<br>";
							mysql_query($inj2);
							
							if ($d[8]=='1140905'){
								$ma_Biaya_Makan_Basah=563;
								$uraian .= " --> Langsung Dipakai";
								
								$no = mysql_query("SELECT IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal");
								$data_no = mysql_fetch_array($no);
								$no_psg=$data_no["no_psg"];
								 
								$inj2 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
				D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
				VALUES ('$notrans','$no_psg','$ma_Biaya_Makan_Basah','$tgltrans','$d[1]','$uraian','$d[3]',0,sysdate(),'$iduser','D','0','$pil','$pil','$d[7]|$d[8]','108',1)";
								//echo $inj2."<br>";
								mysql_query($inj2);
								$inj1 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
				D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
				VALUES ('$notrans','$no_psg','$d[5]','$tgltrans','$d[1]','$uraian',0,'$d[3]',sysdate(),'$iduser','K','0','$pil','$pil','$d[7]|$d[8]','0',1)";
								//echo $inj1."<br>";
								mysql_query($inj1);
							}
						}else if($q==1){
							$no = mysql_query("SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM jurnal");
							$data_no = mysql_fetch_array($no);
							$notrans = $data_no["notrans"];
							$no_psg=$data_no["no_psg"];
							
							$uraian = $d[0]."-".$d[6];
							
							$inj1 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
				D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
				VALUES ('$notrans','$no_psg','$d[5]','$tgltrans','$d[1]','$uraian','$d[3]',0,sysdate(),'$iduser','D','0','59','59','$d[7]|$d[8]','$d[2]')";
							$inj2 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,
				D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
				VALUES ('$notrans','$no_psg','$ma_HU_Suplier_Umum','$tgltrans','$d[1]','$uraian',0,'$d[3]',sysdate(),'$iduser','K','0','59','59','$d[7]|$d[8]','$d[2]')";
							//echo $inj1."<br>";
							//echo $inj2."<br>";
							mysql_query($inj1);
							mysql_query($inj2);
						}
						
						if(!$r){
							$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];	
						}else{
							if ($q==2){
								$sql="UPDATE ".$dbaset.".as_masuk m INNER JOIN ".$dbaset.".as_ms_barang b ON m.barang_id=b.idbarang
									INNER JOIN ".$dbaset.".as_po PO ON m.po_id=PO.id SET m.posted=1,m.posted_tgl=NOW()
									WHERE DATE(m.tgl_terima)='$tgltrans' AND PO.vendor_id='$d[2]' AND m.no_gudang='$d[1]'
									AND b.kode_sak='".$d[8]."' AND m.no_faktur='$d[9]' AND PO.no_po='$d[7]'";
							}else{
								$sql="UPDATE ".$dbaset.".as_masuk m INNER JOIN ".$dbaset.".as_ms_barang b ON m.barang_id=b.idbarang
									INNER JOIN ".$dbaset.".as_po PO ON m.po_id=PO.id SET m.posted=1,m.posted_tgl=NOW()
									WHERE DATE(m.tgl_terima)='$tgltrans' AND PO.vendor_id='$d[2]' AND m.no_gudang='$d[1]'
									AND LEFT(b.kodebarang,8)='".$d[8]."' AND m.no_faktur='$d[9]' AND PO.no_po='$d[7]'";
							}
							//echo $sql."<br>";
							mysql_query($sql);
						}
					}else{
						$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
					}
				}
				break;
			case '1':
				for($v=0;$v<$x;$v++){
					$d = explode("||",$data[$v]);
					$tgltrans=tglSQL($d[4]);
					$del=false;
					//============Delete jurnal + Update Penerimaan Gudang Umum, posted=0===========================
					if($q == 2){
						$kdbrg=$d[0];
						if (strpos($kdbrg,"|")>0){
							$arkdbrg=explode("|",$kdbrg);
							
							$inj1 = "SELECT * FROM ".$dbakuntansi.".jurnal WHERE TGL='$tgltrans' AND NO_KW='$d[1]' 
									AND NO_BUKTI='$d[5]|$arkdbrg[1]' AND CC_RV_KSO_PBF_UMUM_ID='$d[2]'"; 
							//echo $inj1."<br>";
							$rs1=mysql_query($inj1);
							if (mysql_num_rows($rs1)>0){
								$rw1=mysql_fetch_array($rs1);
								$notrans=$rw1["NO_TRANS"];
							
								$inj1 = "DELETE FROM ".$dbakuntansi.".jurnal WHERE NO_TRANS='$notrans'"; 
								//echo $inj1."<br>";
								$rs1=mysql_query($inj1);
								if (mysql_affected_rows()>0){
									$sql="UPDATE ".$dbaset.".as_masuk m INNER JOIN ".$dbaset.".as_ms_barang b ON 
										m.barang_id=b.idbarang
										INNER JOIN ".$dbaset.".as_po PO ON m.po_id=PO.id SET m.posted=0,m.posted_tgl=NULL
										WHERE DATE(m.tgl_terima)='$tgltrans' AND PO.vendor_id='$d[2]' AND m.no_gudang='$d[1]'
										AND b.kode_sak='".$arkdbrg[1]."'";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									if (mysql_affected_rows()>0){
										$del=true;
									}
								}
							}
						}else{
						}
						
						if ($del==true){
							//============Delete ak_posting===========================
							/*$sql1 = "DELETE FROM ".$dbakuntansi.".ak_posting WHERE no_bukti='".$d[0]."' AND no_terima='$d[1]' 
									AND id_kso_pbf_umum='".$d[2]."' AND no_faktur='$d[5]' AND tgl_trans='$tgltrans' 
									AND biayaRS_DPP_PPN='$d[3]'";*/
							$sql1 = "DELETE FROM ".$dbakuntansi.".ak_posting WHERE no_bukti='".$d[0]."' AND no_terima='$d[1]' 
									AND id_kso_pbf_umum='".$d[2]."' AND tipe=13 AND jenis=0 AND no_faktur='$d[6]' AND tgl_trans='$tgltrans' 
									AND biayaRS_DPP_PPN='$d[3]'";
							//echo $sql1."<br>";
							$r = mysql_query($sql1);
						}
					}else{
						$kdbrg=$d[0];
						if (strpos($kdbrg,"|")>0){
							$arkdbrg=explode("|",$kdbrg);
							
							$inj1 = "SELECT * FROM ".$dbakuntansi.".jurnal WHERE TGL='$tgltrans' AND NO_KW='$d[1]' 
									AND NO_BUKTI='$d[5]|$arkdbrg[0]' AND CC_RV_KSO_PBF_UMUM_ID='$d[2]'"; 
							//echo $inj1."<br>";
							$rs1=mysql_query($inj1);
							if (mysql_num_rows($rs1)>0){
								$rw1=mysql_fetch_array($rs1);
								$notrans=$rw1["NO_TRANS"];
							
								$inj1 = "DELETE FROM ".$dbakuntansi.".jurnal WHERE NO_TRANS='$notrans'"; 
								//echo $inj1."<br>";
								$rs1=mysql_query($inj1);
								if (mysql_affected_rows()>0){
									$sql="UPDATE ".$dbaset.".as_masuk m INNER JOIN ".$dbaset.".as_ms_barang b ON 
										m.barang_id=b.idbarang
										INNER JOIN ".$dbaset.".as_po PO ON m.po_id=PO.id SET m.posted=0,m.posted_tgl=NULL
										WHERE DATE(m.tgl_terima)='$tgltrans' AND PO.vendor_id='$d[2]' AND m.no_gudang='$d[1]'
										AND LEFT(b.kodebarang,8)='".$arkdbrg[0]."'";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									if (mysql_affected_rows()>0){
										$del=true;
									}
								}
							}
						}else{
						}
						
						if ($del==true){
							//============Delete ak_posting===========================
							/*$sql1 = "DELETE FROM ".$dbakuntansi.".ak_posting WHERE no_bukti='".$d[0]."' AND no_terima='$d[1]' 
									AND id_kso_pbf_umum='".$d[2]."' AND no_faktur='$d[5]' AND tgl_trans='$tgltrans' 
									AND biayaRS_DPP_PPN='$d[3]'";*/
							$sql1 = "DELETE FROM ".$dbakuntansi.".ak_posting WHERE no_bukti='".$d[0]."' AND no_terima='$d[1]' 
									AND id_kso_pbf_umum='".$d[2]."' AND tipe=13 AND jenis=1 AND no_faktur='$d[6]' AND tgl_trans='$tgltrans' 
									AND biayaRS_DPP_PPN='$d[3]'";
							//echo $sql1."<br>";
							$r = mysql_query($sql1);
						}
					}
				}
				break;
		}
		//echo "hh";
		break;
}

switch(strtolower($pilihan)){
	case "terima":
		$cmb=$_REQUEST["cmb"];
		if($cmb == 0){
			$pt = "AND m.posted=0";
		}else if($cmb == 1){
			$pt = "AND m.posted=1";
		}else{
			$pt="";
		}
		
		if ($q == 2){
			if ($cmb == 0){
				$sql="SELECT * FROM (SELECT vendor_id,namarekanan,tgl_terima tgl,DATE_FORMAT(tgl_terima,'%d-%m-%Y') tgl_terima,no_gudang,no_faktur,no_po,T3.kdbrg,T3.kodebarang,REPLACE(UPPER(A.MA_NAMA),'PERSEDIAAN ','') namabarang,T3.NL,A.MA_KODE kode_sak 
FROM (SELECT vendor_id,tgl_terima,no_gudang,no_faktur,no_po,brg.kodebarang,brg.tipe, 
IFNULL(brg.kode_sak,'') AS kdbrg,SUM(T2.nilaiBrg) NL 
FROM $dbaset.as_ms_barang brg 
INNER JOIN (SELECT PO.vendor_id,PO.no_po,PO.judul,T1.* FROM ".$dbaset.".as_po PO INNER JOIN 
(SELECT m.po_id, tgl_terima,no_gudang,no_faktur,m.barang_id, (m.jml_msk*m.harga_unit) AS nilaiBrg 
FROM ".$dbaset.".as_masuk m WHERE NOT ISNULL(m.po_id) AND (m.jml_msk*m.harga_unit)>0 $pt 
AND (DATE(m.tgl_terima) BETWEEN '$tgl1' AND '$tgl2')) AS T1 ON PO.id=T1.po_id ) AS T2 ON brg.idbarang=T2.barang_id 
WHERE brg.tipe='2' GROUP BY kdbrg,no_gudang,vendor_id,no_po,no_faktur,tgl_terima) AS T3 LEFT JOIN ma_sak A ON (T3.kdbrg=A.MA_KODE) 
INNER JOIN ".$dbaset.".as_ms_rekanan R ON T3.vendor_id=R.idrekanan) AS gab WHERE 1=1 ".$filter." 
ORDER BY tgl,no_gudang,kodebarang,$sorting";
			}elseif($cmb == 1){
				$sql="SELECT * FROM (SELECT mr.idrekanan vendor_id,mr.namarekanan,p.tgl_trans tgl,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') tgl_terima,p.no_faktur,p.no_po,p.no_terima no_gudang,p.no_bukti kodebarang,p.biayaRS_DPP_PPN NL FROM $dbakuntansi.ak_posting p INNER JOIN $dbaset.as_ms_rekanan mr ON p.id_kso_pbf_umum=mr.idrekanan 
WHERE p.tipe=13 AND p.jenis=0 AND p.tgl_trans BETWEEN '$tgl1' AND '$tgl2') AS gab WHERE NL>0 ".$filter." ORDER BY tgl,no_gudang,kodebarang,$sorting";
			}
		}else{
			if ($cmb == 0){
		 		$sql = "SELECT vendor_id,namarekanan,tgl_terima tgl,DATE_FORMAT(tgl_terima,'%d-%m-%Y') tgl_terima,no_gudang,no_faktur,no_po,A.kodebarang,A.namabarang,T3.kdbrg,T3.NL,A.kode_sak FROM ".$dbaset.".as_ms_barang A INNER JOIN
(SELECT vendor_id,tgl_terima,no_gudang,no_faktur,no_po,brg.tipe, LEFT(brg.kodebarang,8) AS kdbrg,SUM(T2.nilaiBrg) NL FROM ".$dbaset.".as_ms_barang brg INNER JOIN 
(SELECT PO.vendor_id,PO.no_po,PO.judul,T1.* FROM ".$dbaset.".as_po PO INNER JOIN 
(SELECT m.po_id, tgl_terima,no_gudang,no_faktur,m.barang_id, (m.jml_msk*m.harga_unit) AS nilaiBrg FROM ".$dbaset.".as_masuk m 
WHERE NOT ISNULL(m.po_id) $pt AND (DATE(m.tgl_terima) BETWEEN '$tgl1' AND '$tgl2')) AS T1
ON PO.id=T1.po_id ) AS T2
ON brg.idbarang=T2.barang_id WHERE brg.tipe='1' GROUP BY kdbrg,no_gudang,vendor_id,tgl_terima) AS T3
ON (A.kodebarang=T3.kdbrg) AND (A.tipe=T3.tipe)
INNER JOIN ".$dbaset.".as_ms_rekanan R ON T3.vendor_id=R.idrekanan WHERE T3.NL>0 ".$filter." ORDER BY tgl,no_gudang,A.kodebarang,$sorting";
			}else{
				$sql="SELECT * FROM (SELECT mr.idrekanan vendor_id,mr.namarekanan,p.tgl_trans tgl,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') tgl_terima,p.no_faktur,p.no_po,p.no_terima no_gudang,p.no_bukti kodebarang,p.biayaRS_DPP_PPN NL FROM $dbakuntansi.ak_posting p INNER JOIN $dbaset.as_ms_rekanan mr ON p.id_kso_pbf_umum=mr.idrekanan 
WHERE p.tipe=13 AND p.jenis=1 AND p.tgl_trans BETWEEN '$tgl1' AND '$tgl2') AS gab WHERE NL>0 ".$filter." ORDER BY tgl,no_gudang,kodebarang,$sorting";
			}
		}
	break;
}

//echo $sql;
$rs=mysql_query($sql);
//echo mysql_error();
$jmldata=mysql_num_rows($rs);
$perpage = 100;
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

$ntot=0;
switch($pilihan) {
    case 'terima':
    //$i = 1;
    $cmb=$_REQUEST["cmb"];
    if($cmb == 0){
    	while($rows = mysql_fetch_array($rs)){
			if($rows['NL']=='') $rows['NL']=0;
			$d = mysql_query("select * from ".$dbakuntansi.".ak_posting where no_terima = '".$rows["no_gudang"]."' and no_bukti='".$rows["kodebarang"]."' and tipe=13 and id_kso_pbf_umum = '".$rows["vendor_id"]."' and biayaRS_DPP_PPN = '".$rows['NL']."' and tgl_trans = '".tglSQL($rows["tgl_terima"])."'"); 
			$ro = mysql_num_rows($d);
			if($ro==0){
				$i++;
				$k = mysql_query("select ma_sak.ma_id from ".$dbakuntansi.".ma_sak where ma_sak.ma_kode = '".$rows['kode_sak']."'");
				$dta = mysql_fetch_array($k);
				$ntot+=$rows['NL'];
				$kdbrg=$rows["kdbrg"];
				//if ($q == 1) $kdbrg=$rows["kode_sak"];
				$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$dta["ma_id"]."|".$rows["namabarang"]."|".$rows["no_po"]."|".$kdbrg."|".$rows["no_faktur"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).number_format($rows['NL'],2,",",".").chr(3)."0".chr(6);
			}
		}
	}else if($cmb==1){
    	while($rows = mysql_fetch_array($rs)){
			$i++;
			$kdbrg=$rows["kodebarang"];
			//echo "kdbrg=".$kdbrg."<br>";
			//echo "strcmp_|=".strpos($kdbrg,"|")."<br>";
			//echo "strcmp_.=".strpos($kdbrg,".")."<br>";
			if (strpos($kdbrg,"|")>0){
				$arkdbrg=explode("|",$rows["kodebarang"]);
				$kdbrg=$arkdbrg[0];
				if ($q == 2){
					if ($arkdbrg[1]==''){
						$nmbrg="BAHAN MAKANAN BASAH";
					}else{
						$d=mysql_query("SELECT REPLACE(UPPER(MA_NAMA),'PERSEDIAAN ','') namabarang FROM ".$dbakuntansi.".ma_sak WHERE MA_KODE='".$arkdbrg[1]."'");
						$dta = mysql_fetch_array($d);
						$nmbrg=$dta['namabarang'];
					}
				}else{
					$d=mysql_query("SELECT namabarang FROM ".$dbaset.".as_ms_barang WHERE kodebarang='".$kdbrg."'");
					$dta = mysql_fetch_array($d);
					$nmbrg=$dta['namabarang'];
				}
			}elseif(strpos($kdbrg,".")>0){
				$d=mysql_query("SELECT namabarang FROM ".$dbaset.".as_ms_barang WHERE kodebarang='".$kdbrg."'");
				$dta = mysql_fetch_array($d);
				$nmbrg=$dta['namabarang'];
			}elseif($kdbrg==""){
				//$kdbrg="1140703";
				$nmbrg="BAHAN MAKANAN BASAH";
			}else{
				//echo "kdbrg=".$kdbrg."<br>";
				$d=mysql_query("SELECT REPLACE(UPPER(MA_NAMA),'PERSEDIAAN ','') namabarang FROM ".$dbakuntansi.".ma_sak WHERE MA_KODE='".$kdbrg."'");
				$dta = mysql_fetch_array($d);
				$nmbrg=$dta['namabarang'];
			}
			
			$ntot+=$rows['NL'];
			$dt .=$rows["kodebarang"]."||".$rows["no_gudang"]."||".$rows["vendor_id"]."||".$rows["NL"]."||".$rows["tgl_terima"]."||".$rows["no_po"]."||".$rows["no_faktur"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['namarekanan'].chr(3).$kdbrg.chr(3).$nmbrg.chr(3).number_format($rows['NL'],2,",",".").chr(3)."0".chr(6);
		}
	}
	else if($cmb==2){
		while($rows = mysql_fetch_array($rs)){
			$i++;
			if($rows['NL']=='')$rows['NL']=0;
			$d = mysql_query("select * from ".$dbakuntansi.".ak_posting where no_terima = '".$rows["no_gudang"]."' and no_bukti='".$rows["kodebarang"]."' and tipe=13 and id_kso_pbf_umum = '".$rows["vendor_id"]."' and biayaRS_DPP_PPN = '".$rows['NL']."' and tgl_trans = '".$rows["tgl_terima"]."'"); 
			$ro = mysql_num_rows($d);
			$k = mysql_query("select ma_sak.ma_id from ".$dbakuntansi.".ma_sak where ma_sak.ma_kode = '".$rows['kode_sak']."'");
			$dta = mysql_fetch_array($k);
			$ntot+=$rows['NL'];
			$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$dta["ma_id"]."|".$rows["namabarang"]."|".$rows["no_faktur"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['no_po'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).number_format($rows['NL'],2,",",".").chr(3).$ro.chr(6);
		}
	}
		break;		
}

//$dt="0".chr(5).chr(4).chr(5)."bb";

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'].chr(3).number_format($ntot,2,",",".");
	$dt=str_replace('"','\"',$dt);
}else{
	$dt="0".chr(5).chr(5).$_REQUEST['act'].chr(3).number_format($ntot,2,",",".");
}
	
mysql_free_result($rs);
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;

?>
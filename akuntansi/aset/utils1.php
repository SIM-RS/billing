<?php 
//session_start();
//$user = $_SESSION['akun_iduser'];
$iduser = $_REQUEST["user"];
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//====================================
$pilihan = $_REQUEST["pilihan"];
$tgl1 = explode("-",$_REQUEST["tgl1"]);
$tgl1 = $tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
$tgl2 = explode("-",$_REQUEST["tgl2"]);
$tgl2 = $tgl2[2]."-".$tgl2[1]."-".$tgl2[0];
$defaultsort = "vendor_id";
$q = $_REQUEST["jnsbrg"];
$data = $_REQUEST["data"];
if ($filter!=""){
    $filter=explode("|",$filter);
    $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
    $sorting=$defaultsort;
}

switch(strtolower($_REQUEST['act'])) {
	case 'posting':
		$data = explode("*", $data);
		$x = count($data)-1;
		for($v=0;$v<$x;$v++){
			$d = explode("|",$data[$v]);
			$tgltrans=tglSQL($d[4]);
			$sql="select * from ".$dbakuntansi.".ak_posting where tipe=13 and no_bukti='".$d[0]."' and no_terima='".$d[1]."' and id_kso_pbf_umum = '".$d[2]."' and biayaRS_DPP_PPN = '".$d[3]."' and tgl_trans = '".$tgltrans."'";
			//echo $sql."<br>";
			$d1 = mysql_query($sql);
			$ro = mysql_num_rows($d1);
			if($ro==0){
				$sql1 = "insert into ".$dbakuntansi.".ak_posting(no_bukti,no_terima,id_kso_pbf_umum,tipe,biayaRS_DPP_PPN,tgl_trans,tgl_act,user_act)
				values('$d[0]','$d[1]','$d[2]','13','$d[3]','".$tgltrans."',sysdate(),'$iduser')";
				//echo $sql1."<br>";
				$r = mysql_query($sql1);
				if($q == 2){
					$pil = substr($d[0],0,2);
					switch($pil){
						case '01':
							$pil = 282;
							break;
						case '02':
							$pil = 288;
							break;
						case '03':
							$pil = 294;
							break;
						case '04':
							$pil = 300;
							break;
						case '05':
							$pil = 53;
							break;
						case '06':
							$pil = 35;
							break;
						case '07':
							$pil = 47;
							break;
						case '08':
							$pil = 41;									
							break;								
					}
					
					$ma_HU_Suplier_Umum=379;
							
					$no = mysql_query("select NO_TRANS from ".$dbakuntansi.".jurnal order by NO_TRANS DESC limit 1");
					$data_no = mysql_fetch_array($no);
					$notrans = $data_no["NO_TRANS"]+1;
					$uraian = $d[0]."-".$d[6];
					$inj1 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,TGL_ACT,FK_IDUSER,
	D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES ('$notrans','$d[5]','$tgltrans','$d[1]','$uraian','$d[3]',sysdate(),'$iduser','D','0','$pil','$pil','$d[1]','$d[2]',1)";
					//echo $inj1."<br>";
					mysql_query($inj1);
					$inj2 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,KREDIT,TGL_ACT,FK_IDUSER,
	D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES ('$notrans','$ma_HU_Suplier_Umum','$tgltrans','$d[1]','$uraian','$d[3]',sysdate(),'$iduser','K','0','$pil','$pil','$d[1]','$d[2]',1)";
					//echo $inj2."<br>";
					mysql_query($inj2);						
				}else if($q==1){
					$no = mysql_query("select NO_TRANS from ".$dbakuntansi.".NO_TRANS order by NO_TRANS DESC limit 1");
					$data_no = mysql_fetch_array($no);
					$notrans = $data_no["NO_TRANS"]+1;
					$uraian = $d[0]."-".$d[6];
					$inj1 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,FK_SAK,TGL,URAIAN,DEBIT,TGL_ACT,FK_IDUSER,
		D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
		VALUES ('$notrans','$d[5]','$tgltrans','$uraian','$d[3]',sysdate(),'$iduser','D','0','59','59','$d[1]','$d[2]')";
					$inj2 = "INSERT INTO ".$dbakuntansi.".jurnal (NO_TRANS,FK_SAK,TGL,URAIAN,KREDIT,TGL_ACT,FK_IDUSER,
		D_K,JENIS,FK_TRANS,FK_LAST_TRANS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID) 
		VALUES ('$notrans','$d[5]','$tgltrans','$uraian','$d[3]',sysdate(),'$iduser','K','0','59','59','$d[1]','$d[2]')";
					//echo $inj1."<br>";
					//echo $inj2."<br>";
					mysql_query($inj1);
					mysql_query($inj2);
				}
				
				if(!$r){
					$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];	
				}else{
					$sql="UPDATE ".$dbaset.".as_masuk m INNER JOIN ".$dbaset.".as_ms_barang b ON m.barang_id=b.idbarang
	INNER JOIN ".$dbaset.".as_po PO ON m.po_id=PO.id SET m.posted=1,m.posted_tgl=NOW()
	WHERE DATE(m.tgl_terima)='$tgltrans' AND PO.vendor_id='$d[2]' AND m.no_gudang='$d[1]'
	AND b.kodebarang LIKE '".$d[0]."%'";
					//echo $sql."<br>";
					mysql_query($sql);							
				}
			}else{
				$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
			}
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
				$sql="SELECT * FROM (SELECT vendor_id,namarekanan,DATE_FORMAT(tgl_terima,'%d-%m-%Y') tgl_terima,no_gudang,A.kodebarang,A.namabarang,T3.NL,A.kode_sak 
FROM ".$dbaset.".as_ms_barang A 
INNER JOIN (SELECT vendor_id,tgl_terima,no_gudang,brg.tipe, 
IF(LEFT(brg.kodebarang,2)='06',LEFT(brg.kodebarang,5),LEFT(brg.kodebarang,2)) AS kdbrg,SUM(T2.nilaiBrg) NL 
FROM ".$dbaset.".as_ms_barang brg INNER JOIN 
(SELECT PO.vendor_id,PO.judul,T1.* FROM ".$dbaset.".as_po PO INNER JOIN 
(SELECT m.po_id, tgl_terima,no_gudang,m.barang_id, (m.jml_msk*m.harga_unit) AS nilaiBrg 
FROM ".$dbaset.".as_masuk m WHERE NOT ISNULL(m.po_id) $pt 
AND (DATE(m.tgl_terima) BETWEEN '$tgl1' AND '$tgl2')) AS T1 ON PO.id=T1.po_id ) AS T2 ON brg.idbarang=T2.barang_id 
WHERE brg.tipe='2' GROUP BY kdbrg,no_gudang,vendor_id,tgl_terima) AS T3 ON (A.kodebarang=T3.KDBRG) AND (A.tipe=T3.tipe) 
INNER JOIN ".$dbaset.".as_ms_rekanan R ON T3.vendor_id=R.idrekanan) AS gab ".$filter." 
ORDER BY tgl_terima,no_gudang,kodebarang,$sorting";
			}elseif($cmb == 1){
				$sql="SELECT * FROM (SELECT mr.idrekanan vendor_id,mr.namarekanan,DATE_FORMAT(p.tgl_trans,'%d-%m-%Y') tgl_terima,p.no_terima no_gudang,p.no_bukti kodebarang,p.biayaRS_DPP_PPN NL FROM akuntansi.ak_posting p INNER JOIN dbaset.as_ms_rekanan mr ON p.id_kso_pbf_umum=mr.idrekanan 
WHERE p.tipe=13 AND p.tgl_trans BETWEEN '$tgl1' AND '$tgl2') AS gab ".$filter." ORDER BY tgl_terima,no_gudang,kodebarang,$sorting";
			}
		}else{
		 	$sql = "SELECT vendor_id,namarekanan,tgl_terima,no_gudang,A.kodebarang,A.namabarang,T3.NL,A.kode_sak FROM ".$dbaset.".as_ms_barang A INNER JOIN
(SELECT vendor_id,tgl_terima,no_gudang,brg.tipe, LEFT(brg.kodebarang,8) AS kdbrg,SUM(T2.nilaiBrg) NL FROM ".$dbaset.".as_ms_barang brg INNER JOIN 
(SELECT PO.vendor_id,PO.judul,T1.* FROM ".$dbaset.".as_po PO INNER JOIN 
(SELECT m.po_id, tgl_terima,no_gudang,m.barang_id, (m.jml_msk*m.harga_unit) AS nilaiBrg FROM ".$dbaset.".as_masuk m 
WHERE NOT ISNULL(m.po_id) $pt AND (DATE(m.tgl_terima) BETWEEN '$tgl1' AND '$tgl2')) AS T1
ON PO.id=T1.po_id ) AS T2
ON brg.idbarang=T2.barang_id WHERE brg.tipe='1' GROUP BY kdbrg,no_gudang,vendor_id,tgl_terima) AS T3
ON (A.kodebarang=T3.KDBRG) AND (A.tipe=T3.tipe)
INNER JOIN ".$dbaset.".as_ms_rekanan R ON T3.vendor_id=R.idrekanan ".$filter." ORDER BY tgl_terima,no_gudang,A.kodebarang,$sorting";
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

switch($pilihan) {
    case 'terima':
    $i = 1;
    $cmb=$_REQUEST["cmb"];
    if($cmb == 0){
    	while($rows = mysql_fetch_array($rs)){
			if($rows['NL']=='')$rows['NL']=0;
			$d = mysql_query("select * from ".$dbakuntansi.".ak_posting where no_terima = '".$rows["no_gudang"]."' and no_bukti='".$rows["kodebarang"]."' and tipe=13 and id_kso_pbf_umum = '".$rows["vendor_id"]."' and biayaRS_DPP_PPN = '".$rows['NL']."' and tgl_trans = '".$rows["tgl_terima"]."'"); 
			$ro = mysql_num_rows($d);
			if($ro==0){		
				$k = mysql_query("select ma_sak.ma_id from ".$dbakuntansi.".ma_sak where ma_sak.ma_kode = '".$rows['kode_sak']."'");
				$dta = mysql_fetch_array($k);
				$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$dta["ma_id"]."|".$rows["namabarang"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).number_format($rows['NL'],2,",",".").chr(3)."0".chr(6);
				$i++;
			}
		}
	}else if($cmb==1){
    	while($rows = mysql_fetch_array($rs)){
			/*if ($cmb == 0){
				if($rows['nilaibuku']=='')$rows['nilaibuku']=0;
				$d = mysql_query("select * from ".$dbakuntansi.".ak_posting where no_terima = '".$rows["no_gudang"]."' and no_bukti='".$rows["kodebarang"]."' and tipe=13 and id_kso_pbf_umum = '".$rows["vendor_id"]."' and biayaRS_DPP_PPN = '".$rows['NL']."' and tgl_trans = '".$rows["tgl_terima"]."'"); 
				$ro = mysql_num_rows($d);
				if($ro>0){		
					$k = mysql_query("select ma_sak.ma_id from ".$dbakuntansi.".ma_sak where ma_sak.ma_kode = '".$rows['kode_sak']."'");
					$dta = mysql_fetch_array($k);
					$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$rows["namabarang"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).$rows['NL'].chr(3)."1".chr(6);
				}
			}else{*/
				$d=mysql_query("SELECT * FROM dbaset.as_ms_barang WHERE kodebarang='".$rows["kodebarang"]."' AND tipe='".$q."'");
				$dta = mysql_fetch_array($d);
				$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$rows["namabarang"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$dta['namabarang'].chr(3).number_format($rows['NL'],2,",",".").chr(3)."1".chr(6);
			//}
			$i++;
		}
	}
	else if($cmb==2){
		while($rows = mysql_fetch_array($rs)){
			if($rows['NL']=='')$rows['NL']=0;
			$d = mysql_query("select * from ".$dbakuntansi.".ak_posting where no_terima = '".$rows["no_gudang"]."' and no_bukti='".$rows["kodebarang"]."' and tipe=13 and id_kso_pbf_umum = '".$rows["vendor_id"]."' and biayaRS_DPP_PPN = '".$rows['NL']."' and tgl_trans = '".$rows["tgl_terima"]."'"); 
			$ro = mysql_num_rows($d);
			$k = mysql_query("select ma_sak.ma_id from ".$dbakuntansi.".ma_sak where ma_sak.ma_kode = '".$rows['kode_sak']."'");
			$dta = mysql_fetch_array($k);
			$dt .=$rows["kodebarang"]."|".$rows["no_gudang"]."|".$rows["vendor_id"]."|".$rows["NL"]."|".$rows["tgl_terima"]."|".$dta["ma_id"]."|".$rows["namabarang"].chr(3).$i.chr(3).$rows["tgl_terima"].chr(3).$rows['no_gudang'].chr(3).$rows['namarekanan'].chr(3).$rows['kodebarang'].chr(3).$rows['namabarang'].chr(3).number_format($rows['NL'],2,",",".").chr(3).$ro.chr(6);
			$i++;
		}
							
	}
		break;		
}
		
//$dt="0".chr(5).chr(4).chr(5)."bb";

 if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
        $dt=str_replace('"','\"',$dt);
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
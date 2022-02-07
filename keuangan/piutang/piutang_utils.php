<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tglK";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$waktu = $_REQUEST["waktu"];
//===============================
$IdTrans=36;
$Idma_sak_d_umum=44;//===113010101 - Piutang Pasien Umum
$Idma_sak_d_kso_px=45;//===113010102 - Piutang Pasien Kerjasama dengan pihak ke III beban pasien
$Idma_sak_d_kso_kso=46;//===113010103 - Piutang Pasien Kerjasama dengan pihak ke III beban pihak ke III
$Idma_sak_d=$Idma_sak_d_kso_kso;
$Idma_sak_k_umum=488;//===41101 - Pendapatan Jasa Layanan Pasien Umum
$Idma_sak_k_kso=490;//===41103 - Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
$Idma_sak_k_pemda=493;//===41106 - Pendapatan Jasa Layanan Pasien Subsidi Pemerintah
$Idma_sak_selisih_tarip_d_k=491;//===41104 - Selisih Tarif Jasa Layanan Pasien Kerja Sama dengan KSO
$Idma_sak_k=$Idma_sak_k_kso;

$Idma_sak=$Idma_sak_k_kso;
$Idma_dpa=6;
//===============================
$posting=$_REQUEST['posting'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$kso = $_REQUEST['kso'];
$grid = $_REQUEST['grid'];
$tgl = tglSQL($_REQUEST['txtTgl']);
$tgl2 = tglSQL($_REQUEST['txtTgl2']);
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'verifikasi':
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
        break;
}

if (($statusProses=='') && (strtolower($_REQUEST['act'])=='verifikasi')){
	if ($posting==0){
		$alasan='Verifikasi Data Berhasil !';
	}else{
		$alasan='UnVerifikasi Data Berhasil !';
	}
}

/* if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else { */
	$fkso="";
	if ($kso!="0"){
		$fkso=" AND p.kso_id='$kso'";
	}
	
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
	$data = $_REQUEST['data'];
	$lunas = $_REQUEST['tipePelunasan'];
	switch($waktu){
		case "harian":
			if($data == '1'){
				$fwaktu = " AND tglP <= '{$tgl}'";
			} else if($data == '2'){
				$fwaktu = " AND tgl_lunasPx <= '{$tgl}'";
				if($lunas == 1){
					$fwaktu = " AND tgl_lunasKSO <= '{$tgl}'";
				}
			}
			break;
		case "periode":
			if($data == '1'){
				$fwaktu = " AND tglP BETWEEN '{$tgl}' AND '{$tgl2}'";
			} else if($data == '2'){			
				$fwaktu = " AND tgl_lunasPx BETWEEN '{$tgl}' AND '{$tgl2}'";
				if($lunas == 1){
					$fwaktu = " AND tgl_lunasKSO BETWEEN '{$tgl}' AND '{$tgl2}'";
				}
			}
			break;
	}
    if($grid == 1) {
		$sql = "select * from (SELECT p.kunjungan_id, pas.no_rm, pas.nama, p.kso_id, kso.nama nkso, p.tglK, p.tglP, IFNULL(p.tgl_lunasKSO, DATE(ktd.tgl_act)) tgl_lunasKSO, 
					DATE(p.tgl_lunasPx), p.biayaRS, p.biayaKSO, p.biayaKSO_Klaim, p.biayaPasien, p.bayarKSO, IFNULL(SUM(ktd.nilai_terima), 0) bayarKSO2,
					p.bayarPasien, p.piutangPasien
				FROM k_piutang p
				LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = p.kunjungan_id
				LEFT JOIN rspelindo_billing.b_ms_pasien pas ON pas.id = k.pasien_id
				INNER JOIN rspelindo_billing.b_ms_kso kso ON kso.id = p.kso_id
				LEFT JOIN k_klaim_detail kd ON kd.fk_id = p.id
				LEFT JOIN k_klaim_terima_detail ktd ON ktd.klaim_detail_id = kd.id
				WHERE 0=0 {$fkso}
				GROUP BY p.kunjungan_id) as gab
				WHERE 0 = 0 {$filter} {$fwaktu}
				ORDER BY {$sorting}";
    } else if($grid == 2) {
    }
    
echo $sql;
	
    /* if($grid == 1){
		if ($posting==0){
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(bayarPasien),0) as totbayarPas
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totbayarPas = $rowPlus['totbayarPas'];
			$totPiutangPx = $totPas-$totbayarPas;
		}else{
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(bayarPasien),0) as totbayarPas,
						IFNULL(sum(piutangPasien),0) as totpiutangPas
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totbayarPas = $rowPlus['totbayarPas'];
			$totPiutangPx = $rowPlus['totpiutangPas'];
		}
    } */
    
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
    $unit_asal = '';

    if($grid == 1) {
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$tmpLay = $rows["unit"];
			$kso = $rows["nkso"];
			$tPerda=$rows["biayaRS"];
			$tKSO=$rows["biayaKSO"];
			$tPx=$rows["biayaPasien"];
			$tBayarPx=$rows["bayarPasien"];
			$tBayarKSO=($rows["bayarKSO"] == 0 && $rows["bayarKSO2"] > 0) ? $rows["bayarKSO2"] : $rows["bayarKSO"];
			$tKlaimKSO = $rows["biayaKSO_Klaim"];
			
			$tPiutangPx=$tPx-$tBayarPx;
			
			$sisip=$rows["id"]."|".$rows["tglK"]."|".$rows["tglP"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx;
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tglK"]).chr(3).tglSQL($rows["tglP"]).chr(3).tglSQL($rows["tgl_lunasKSO"]).chr(3).tglSQL($rows["tgl_lunasPx"]).chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$kso.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tKlaimKSO,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tBayarKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(6);
			$tmpLay = '';
			
			$totPer += $tPerda;
			$totKso += $KSO;
			$totPas += $tPx;
			$totKlaimKso += $tKlaimKSO;
			$totbayarKso += $tBayarKSO;
			$totbayarPas += $tBayarPx;
		}
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			
			$tPerda=$rows["biayaRS"];
			if ($ckso=="1"){
				$tKSO=0;
				$tPx=$tPerda;
				$tIur=0;
			}else{
				$tKSO=$rows["biaya_kso"];
				$tPx=0;
				$tIur=$rows["biaya_pasien"];
			}
			$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).$tPerda.chr(3).$tPx.chr(3).$tKSO.chr(3).$tIur.chr(3).$tSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		
		if($grid == 1){
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totKlaimKso,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totbayarKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).$alasan;
		}
    }else{
		$dt = $dt.chr(5).number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
	}
    
    mysql_free_result($rs);
//}
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
//*/
?>
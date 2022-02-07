<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
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
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'verifikasi':
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		//echo "Count Data : ".count($arfdata)."<br>";
		//echo "posting : ".$posting."<br>";
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				$selisihTarip=$cdata[2];
				$ksoid=$cdata[1];
				//tipe=0 --> Billing, tipe=1 --> Farmasi
				$sqlVer="SELECT id FROM k_piutang
						WHERE fk_id = '$idKunj' AND kso_id='$ksoid' AND tipe=0";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_num_rows($rsVer)>0){
					$sqlVer="UPDATE k_piutang
							SET biayaKSO_Klaim = '$selisihTarip'
							WHERE fk_id = '$idKunj' AND kso_id='$ksoid' AND tipe=0";
					//echo $sqlVer."<br>";
				}else{
					$sqlVer="UPDATE k_piutang
							SET biayaKSO_Klaim = '$selisihTarip'
							WHERE fk_id = '$idKunj' AND kso_id='$ksoid' AND tipe=1";
					//echo $sqlVer."<br>";
				}
				$rsVer=mysql_query($sqlVer);
				$sqlVer="UPDATE k_piutang
						SET status = 1,user_posting_bKlaim='$userId',tgl_posting_bKlaim=NOW()
						WHERE fk_id = '$idKunj' AND kso_id='$ksoid'";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_affected_rows()>0){
					//insert ke k_verif_selisih_tarip
					$sqlVer="";
					$rsVer=mysql_query($sqlVer);
					if (mysql_affected_rows()>0){
						$k_verif_selisih_id=mysql_insert_id();
						$sqlVer="";
						$rsVer=mysql_query($sqlVer);
					}else{
						$statusProses='Error';
						$alasan='Verifikasi Gagal';
					}
				}else{
					$statusProses='Error';
					$alasan='Verifikasi Gagal';
					//=======update gagal --> batalkan Verifikasi Selisih Piutang KSO======
				}
			}
		}
		else
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				$ksoid=$cdata[1];
				//========cek sudah posting/belum=========
				$sqlCek="SELECT id FROM k_piutang WHERE fk_id='$idKunj' AND kso_id='$ksoid' AND status=1";
				//echo $sqlCek."<br>";
				$rsCek=mysql_query($sqlCek);
				if (mysql_num_rows($rsCek)>0){
					//========uposting selisih tarip=========
					$sqlVer="UPDATE k_piutang
							SET biayaKSO_Klaim = 0, status=0
							WHERE fk_id = '$idKunj' AND kso_id='$ksoid'";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					if (mysql_affected_rows()==0){
						//=======unposting gagal======
						$statusProses='Error';
						$alasan='UnPosting Gagal';
					}
				}else{
					//=======sudah diposting======
					$statusProses='Error';
					$alasan='Data Tidak Boleh DiUnVerifikasi Karena Sudah Diposting Ke Jurnal Akuntansi';
				}
				//========cek sudah posting/belum END=========
			}
		}
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
		$fkso=" AND kso.id='$kso'";
	}
    
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    if($grid == 1) {
		if ($posting==0){
			$sql = "SELECT
					  k.id,
					  pas.no_rm,
					  pas.nama AS pasien,
					  kso.id AS kso_id,
					  kso.nama AS kso,
					  mu.nama AS unit,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  IFNULL(SUM(kp.biayaRS),0) AS biayaRS,
					  IFNULL(SUM(kp.biayaKSO),0) AS biayaKSO,
					  IFNULL(SUM(kp.biayaKSO_Klaim),0) AS biayaKSO_Klaim,
					  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
					  IFNULL(SUM(kp.bayarKSO),0) AS bayarKSO,
					  IFNULL(SUM(kp.bayarPasien),0) AS bayarPasien,
					  IFNULL(SUM(kp.piutangPasien),0) AS piutangPasien
					FROM k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON kp.kso_id = kso.id
					WHERE kp.tglP = '$tgl' AND kp.status=0
						$fkso $filter
					GROUP BY kp.kunjungan_id,kp.kso_id
					ORDER BY $sorting";
		}else{
			$sql = "SELECT
					  k.id,
					  pas.no_rm,
					  pas.nama AS pasien,
					  kso.id AS kso_id,
					  kso.nama AS kso,
					  mu.nama AS unit,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  IFNULL(SUM(kp.biayaRS),0) AS biayaRS,
					  IFNULL(SUM(kp.biayaKSO),0) AS biayaKSO,
					  IFNULL(SUM(kp.biayaKSO_Klaim),0) AS biayaKSO_Klaim,
					  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
					  IFNULL(SUM(kp.bayarKSO),0) AS bayarKSO,
					  IFNULL(SUM(kp.bayarPasien),0) AS bayarPasien,
					  IFNULL(SUM(kp.piutangPasien),0) AS piutangPasien
					FROM k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.kunjungan_id = k.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON kp.kso_id = kso.id
					WHERE kp.tglP = '$tgl' AND kp.status>0
						$fkso $filter
					GROUP BY kp.kunjungan_id,kp.kso_id
					ORDER BY $sorting";
		}
    }
    else if($grid == 2) {
            //rawat jalan
            $sql = "select * from (select k.id,u.nama as unit,ps.no_rm,ps.nama as pasien,t1.*
				from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,gab.dokter,gab.tindakan
				,SUM(gab.biaya_pasien) AS biaya_pasien,SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien,tgl
				FROM ( SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien,pg.nama AS dokter,t.qty,mt.nama AS tindakan,date_format(t.tgl,'%d-%m-%Y') as tgl
                    FROM $dbbilling.b_tindakan t
				INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				left JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal = mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
				AND t.kso_id='$kso' AND t.tgl='$tgl' and p.kunjungan_id = '$kunj_id') AS gab GROUP BY gab.id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
    }
    
    if($grid == 1){
		if ($posting==0){
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaKSO_Klaim),0) as totKsoKlaim
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = '';
		}else{
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(biayaKSO_Klaim),0) as totKsoKlaim
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totKso = $rowPlus['totKso'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = number_format($rowPlus['totKsoKlaim'],0,",",".");
		}
    }
    
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
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$tmpLay = $rows["unit"];
			$kso = $rows["kso"];
			$tPerda=$rows["biayaRS"];
			$tKSO=$rows["biayaKSO"];
			$nilai=$rows["biayaKSO_Klaim"];
			$tPx=$rows["biayaPasien"];
			$tBayarPx=$rows["bayarPasien"];
			$tPiutangPx=$tPx-$tBayarPx;
			if ($posting==0){
				if ($rows["kso_id"]<>6){
					$nilai=$tKSO;
				}
				$tKSO_Klaim="<input type='text' id='nilai_$i' class='txtinput' value='".number_format($nilai,0,",",".")."' style='width:70px; font:12px tahoma; padding:2px; text-align:right' onkeyup='zxc(this);' />";
			}else{
				$tKSO_Klaim=number_format($nilai,0,",",".");
			}
			$sisip=$rows["id"]."|".$rows["kso_id"];
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).$tKSO_Klaim.chr(3)."0".chr(6);
			$tmpLay = '';
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
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).$tPerda.chr(3).$tPx.chr(3).$tKSO.chr(3).$totKsoKlaim.chr(3).$tSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		
		if($grid == 1){
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).$totKsoKlaim.chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
		}
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
<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t1.id";
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
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				$tglK=tglSQL($cdata[1]);
				$tglP=tglSQL($cdata[2]);
				$biayaRS=$cdata[3];
				$biayaPasien=$cdata[4];
				$biayaKSO=$cdata[5];
				$bayarPasien=$cdata[6];
				$piutangPasien=$cdata[7];
				$sqlVer="UPDATE $dbbilling.b_tindakan
						  INNER JOIN $dbbilling.b_pelayanan
							ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
						SET $dbbilling.b_tindakan.posting = 1
						WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idKunj'";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_affected_rows()>0){
					$sqlVerIns="INSERT INTO k_piutang(fk_id,kso_id,tglK,tglP,biayaRS,biayaKSO,biayaPasien,
													bayarKSO,bayarPasien,piutangPasien,tipe,user_act,tgl_act)
							VALUES ($idKunj,$kso,'$tglK','$tglP',$biayaRS,$biayaKSO,$biayaPasien,0,$bayarPasien,$piutangPasien,0,'$userId',NOW())";
					//echo $sqlVerIns."<br>";
					$rsVerIns=mysql_query($sqlVerIns);
					if (mysql_errno()==0){
						//=======insert berhasil======
						$fkId=mysql_insert_id();
						//=======split data piutang (b_tindakan yg blm lunas) --> kso_id + unit_id=======
						$cUnitIdBilling=0;
						$sqlPiutang="SELECT
										  gab.unit_id,
										  gab.kso_id,
										  IFNULL(SUM(gab.biayaRS),0)    biayaRS,
										  IFNULL(SUM(gab.biayaKso),0)    biayaKso,
										  IFNULL(SUM(gab.biayaPasien),0)    biayaPasien,
										  IFNULL(SUM(gab.bayarKso),0)    bayarKso,
										  IFNULL(SUM(gab.bayarPasien),0)    bayarPasien
										FROM (SELECT
											t.id,
											p.unit_id,
											t.kso_id,
											t.qty*t.biaya	        biayaRS,
											t.qty*t.biaya_kso       biayaKso,
											t.qty*t.biaya_pasien    biayaPasien,
											t.bayar_kso             bayarKso,
											t.bayar_pasien          bayarPasien
										FROM $dbbilling.b_tindakan t
										INNER JOIN $dbbilling.b_pelayanan p
										  ON t.pelayanan_id = p.id
										WHERE p.kunjungan_id = '$idKunj'
										  AND ((t.qty * t.biaya_kso > t.bayar_kso)
											OR (t.qty * t.biaya_pasien > t.bayar_pasien))
										UNION 
										SELECT DISTINCT *
										   FROM (SELECT
											   t.id,
											   p.unit_id,
											   t.kso_id,
											   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip)    biayaRS,
											   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso)    biayaKso,
											   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien)    biayaPasien,
											   t.bayar_kso              bayarKso,
											   t.bayar_pasien           bayarPasien
											 FROM $dbbilling.b_tindakan_kamar t
											   INNER JOIN $dbbilling.b_pelayanan p
												 ON t.pelayanan_id = p.id
											 WHERE p.kunjungan_id = '$idKunj') AS tKamar
										   WHERE ((tKamar.biayaPasien > tKamar.bayarPasien)
											   OR (tKamar.biayaKso > tKamar.bayarKso))) AS gab
										GROUP BY gab.unit_id, gab.kso_id";
						//echo $sqlPiutang."<br>";
						$rsPiutang=mysql_query($sqlPiutang);
						while ($rwPiutang=mysql_fetch_array($rsPiutang)){
							$cUnitIdBilling=$rwPiutang["unit_id"];
							$cKso=$rwPiutang["kso_id"];
							$cBiayaRS=$rwPiutang["biayaRS"];
							$cBiayaKso=$rwPiutang["biayaKso"];
							$cBiayaPasien=$rwPiutang["biayaPasien"];
							$cBayarKso=$rwPiutang["bayarKso"];
							$cBayarPasien=$rwPiutang["bayarPasien"];
							$piutangKso=$cBiayaKso-$cBayarKso;
							$piutangPasien=$cBiayaPasien-$cBayarPasien;
							$piutangRS=$piutangKso+$piutangPasien;
							//======= nilai_sim = piutangKso+piutangPasien =========
							//======= nilai = piutangKso =========
							//======= nilai_hpp = piutangPasien =========
							
							$sqlKTrans="INSERT INTO k_transaksi
													(fk_id,
													 id_trans,
													 tipe_trans,
													 id_ma_sak,
													 id_ma_dpa,
													 tgl,
													 unit_id_billing,
													 kso_id,
													 kunjungan_id,
													 nilai_sim,
													 nilai,
													 nilai_hpp,
													 tgl_act,
													 user_act,
													 verifikasi)
										VALUES ($fkId,
												$IdTrans,
												1,
												$Idma_sak,
												$Idma_dpa,
												'$tgl',
												$cUnitIdBilling,
												$cKso,
												$idKunj,
												$cBiayaRS,
												$piutangKso,
												$piutangPasien,
												NOW(),
												'$userId',
												1)";
							//echo $sqlKTrans."<br>";
							$rsKTrans=mysql_query($sqlKTrans);
						}
					}else{
						$statusProses='Error';
						$alasan='Posting Gagal';
						//=======insert gagal --> batalkan posting tindakan======
						$sqlVer="UPDATE $dbbilling.b_tindakan
								  INNER JOIN $dbbilling.b_pelayanan
									ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
								SET $dbbilling.b_tindakan.posting = 0
								WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idKunj'";
						//echo $sqlVer."<br>";
						$rsVer=mysql_query($sqlVer);
					}
				}else{
					$statusProses='Error';
					$alasan='Verifikasi Gagal';
					//=======update gagal --> batalkan Verifikasi Piutang tindakan======
				}
			}
		}
		else
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				//========cek sudah posting/belum=========
				$sqlCek="SELECT id FROM k_piutang WHERE fk_id='$idKunj' AND tipe=0 AND posting=0";
				//echo $sqlVer."<br>";
				$rsCek=mysql_query($sqlCek);
				if (mysql_num_rows($rsCek)>0){
					//========uposting tindakan=========
					$sqlVer="UPDATE $dbbilling.b_tindakan
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
							SET $dbbilling.b_tindakan.posting = 0
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idKunj' AND $dbbilling.b_tindakan.posting = 1";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					if (mysql_affected_rows()>0){
						//=========unposting tindakan berhasil========
						//========= hapus k_transaksi =========
						$sqlVer="DELETE FROM k_transaksi WHERE fk_id IN (SELECT id FROM k_piutang WHERE fk_id='$idKunj' AND tipe=0)";
						//echo $sqlVer."<br>";
						$rsVer=mysql_query($sqlVer);
						
						$sqlVerDel="DELETE FROM k_piutang WHERE fk_id=$idKunj AND tipe=0";
						//echo $sqlVerDel."<br>";
						$rsVerDel=mysql_query($sqlVerDel);
						if (mysql_errno()>0){
							//========delete gagal --> batalkan unposting tindakan=========
							$statusProses='Error';
							$alasan='UnPosting Gagal';
	
							$sqlVer="UPDATE $dbbilling.b_tindakan
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
									SET $dbbilling.b_tindakan.posting = 1
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idKunj' AND $dbbilling.b_tindakan.posting = 0";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
						}
					}else{
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
	
	$fposting="tin.posting='$posting'";
	if ($posting>0){
		$fposting="tin.posting>'$posting'";
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
			$sql = "SELECT mp.no_rm,mp.nama AS pasien,kso.nama kso,mu.nama unit,t1.* FROM
					(SELECT
					  gab.id,gab.pasien_id,gab.unit_id,gab.kso_id,
					  DATE_FORMAT(gab.tgl,'%d-%m-%Y') AS tgl,
					  IFNULL(DATE_FORMAT(gab.tgl_pulang,'%d-%m-%Y'),DATE_FORMAT(gab.tgl,'%d-%m-%Y')) AS tgl_p,
					  gab.alamat,gab.rt,gab.rw,
					  (SELECT nama FROM $dbbilling.b_ms_wilayah WHERE id=gab.desa_id) AS desa,
					  (SELECT nama FROM $dbbilling.b_ms_wilayah WHERE id=gab.kec_id) AS kec,
					  (SELECT nama FROM $dbbilling.b_ms_wilayah WHERE id=gab.kab_id) AS kab,
					  (SELECT nama FROM $dbbilling.b_ms_wilayah WHERE id=gab.prop_id) AS prop,
					  IFNULL(SUM(tin.qty * tin.biaya),0)    biayaRS,
					  IFNULL(SUM(tin.qty * tin.biaya_kso),0)    biayaKSO,
					  IFNULL(SUM(tin.qty * tin.biaya_pasien),0)    biayaPasien,
					  IFNULL(SUM(tin.bayar_pasien),0)    bayarPasien,
					  (SELECT IFNULL(SUM(IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip, 
					  (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.tarip)),0)
					  FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan bpel ON t.pelayanan_id=bpel.id 
					  WHERE bpel.kunjungan_id=gab.id) AS kamarRS,
					  (SELECT IFNULL(SUM(IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso, 
					  (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_kso)),0)
					  FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan bpel ON t.pelayanan_id=bpel.id 
					  WHERE bpel.kunjungan_id=gab.id) AS kamarKSO,
					  (SELECT IFNULL(SUM(IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien, 
					  (IF(DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,NOW()),t.tgl_in)))*t.beban_pasien)),0)
					  FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan bpel ON t.pelayanan_id=bpel.id 
					  WHERE bpel.kunjungan_id=gab.id) AS kamarPasien,
					  (SELECT IFNULL(SUM(t.bayar_pasien),0) 
					  FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan bpel ON t.pelayanan_id=bpel.id 
					  WHERE bpel.kunjungan_id=gab.id) AS bayarKamarPasien
					FROM (SELECT DISTINCT *
						  FROM (SELECT
								  k.*
								FROM $dbbilling.b_kunjungan k
								  INNER JOIN $dbbilling.b_pelayanan p
									ON k.id = p.kunjungan_id
								  LEFT JOIN $dbbilling.b_tindakan_kamar tk
									ON p.id = tk.pelayanan_id
								WHERE tk.id IS NULL
									AND k.tgl = '$tgl' AND k.pulang=0 UNION SELECT
																	k.*
																  FROM $dbbilling.b_kunjungan k
																  WHERE DATE(k.tgl_pulang) = '$tgl') AS un) AS gab
					  INNER JOIN $dbbilling.b_pelayanan pel
						ON gab.id = pel.kunjungan_id
					  INNER JOIN $dbbilling.b_tindakan tin
						ON pel.id = tin.pelayanan_id
					WHERE tin.posting='$posting' /*AND ((tin.qty * tin.biaya_kso > tin.bayar_kso)
							OR (tin.qty * tin.biaya_pasien > tin.bayar_pasien))*/
					GROUP BY gab.id) AS t1
					INNER JOIN $dbbilling.b_ms_pasien mp ON t1.pasien_id=mp.id
					INNER JOIN $dbbilling.b_ms_kso kso ON t1.kso_id=kso.id
					INNER JOIN $dbbilling.b_ms_unit mu ON t1.unit_id=mu.id
					WHERE ((t1.biayaKSO+t1.biayaPasien+t1.kamarKSO+t1.kamarPasien) > (t1.bayarPasien+t1.bayarKamarPasien))
					$fkso $filter ORDER BY $sorting";
		}else{
			$sql = "SELECT
					  k.id,  
					  pas.no_rm,
					  pas.nama AS pasien,
					  kso.nama     kso,
					  mu.nama      unit,
					  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
					  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
					  kp.biayaRS,
					  kp.biayaPasien,
					  kp.biayaKSO,
					  kp.bayarPasien,
					  kp.piutangPasien
					FROM k_piutang kp
					  INNER JOIN $dbbilling.b_kunjungan k
						ON kp.fk_id = k.id
					  INNER JOIN $dbbilling.b_ms_pasien pas
						ON k.pasien_id = pas.id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON k.kso_id = kso.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					WHERE kp.tglP = '$tgl' AND kp.tipe=0";
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
						IFNULL(sum(bayarPasien),0) as totbayarPas,
						IFNULL(sum(kamarRS),0) as totkamarRS,
						IFNULL(sum(kamarKSO),0) as totkamarKSO,
						IFNULL(sum(kamarPasien),0) as totkamarPas,
						IFNULL(sum(bayarKamarPasien),0) as totbayarKamarPas 
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer']+$rowPlus['totkamarRS'];
			$totKso = $rowPlus['totKso']+$rowPlus['totkamarKSO'];
			$totPas = $rowPlus['totPas']+$rowPlus['totkamarPas'];
			$totbayarPas = $rowPlus['totbayarPas']+$rowPlus['totbayarKamarPas'];
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
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$tmpLay = $rows["unit"];
			$kso = $rows["kso"];
			$tPerda=$rows["biayaRS"]+$rows["kamarRS"];
			$tKSO=$rows["biayaKSO"]+$rows["kamarKSO"];
			$tPx=$rows["biayaPasien"]+$rows["kamarPasien"];
			$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
			$tPiutangPx=$tPx-$tBayarPx;
			$sisip=$rows["id"]."|".$rows["tgl"]."|".$rows["tgl_p"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx;
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).number_format($tPiutangPx,0,",",".").chr(3)."0".chr(6);
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
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).$tPerda.chr(3).$tPx.chr(3).$tKSO.chr(3).$tIur.chr(3).$tSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		
		if($grid == 1){
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
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
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
$klaim_id=$_REQUEST['klaim_id'];
$klaim_terima_id=$_REQUEST['klaim_terima_id'];
$grid = $_REQUEST['grid'];
$thn = $_REQUEST['thn'];
$tgl = tglSQL($_REQUEST['txtTgl']);
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
	case 'buat_klaim_terima':
		$klaim_terima_id = 0;
		$tglKlaimTerima = tglSQL($_REQUEST['tglKlaimTerima']);
		$no_buktiTerima = $_REQUEST['no_buktiTerima'];
		$kso_id = $_REQUEST['kso'];
		$sql="INSERT INTO k_klaim_terima
            (klaim_id,
			 tgl,
             no_bukti,
			 kso_id,
             nilai,
             user_act,
             tgl_act)
			VALUES ('$klaim_id',
			 '$tglKlaimTerima',
			 '$no_buktiTerima',
			 '$kso_id',
			 0,
			 '$userId',
			 NOW())";
		$rs=mysql_query($sql);
		if (mysql_affected_rows()>0){
			$klaim_terima_id=mysql_insert_id();
		}
		echo $klaim_terima_id;
		return;
		break;
	case 'verif_klaim_terima':
		$tipeVerif=($_REQUEST['tipeVerif']=="1")?"0":"1";
		$sql="UPDATE k_klaim_terima SET verifikasi='$tipeVerif',tgl_verifikasi=NOW(),user_verifikasi='$userId' WHERE id='".$klaim_terima_id."'";
		$rs=mysql_query($sql);
		break;
	case 'hapus_klaim_terima':
		$sql="DELETE FROM k_klaim_terima WHERE id='".$klaim_terima_id."' and nilai = 0";
		$rs=mysql_query($sql);
		break;
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
				$klaim_detail_id=$cdata[0];
				$nilai_terima=$cdata[1];
				
				$sqlVer="SELECT id FROM k_klaim_detail
						WHERE id = '$klaim_detail_id' AND tstatus<2";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_num_rows($rsVer)>0){
					$sqlVer="UPDATE k_klaim_detail
							SET tstatus = '2'
							WHERE id = '$klaim_detail_id' AND tstatus<2";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					
					$sqlVer="INSERT INTO k_klaim_terima_detail
										(klaim_terima_id,
										 klaim_detail_id,
										 nilai_terima)
							VALUES ($klaim_terima_id,
									$klaim_detail_id,
									$nilai_terima)";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					if (mysql_errno()>0){
						$sqlVer="UPDATE k_klaim_detail
								SET tstatus = '0'
								WHERE id = '$klaim_detail_id'";
						//echo $sqlVer."<br>";
						$rsVer=mysql_query($sqlVer);
						
						$statusProses='Error';
						$alasan='Verifikasi Gagal';
						//=======update gagal --> batalkan Verifikasi Selisih Piutang KSO======
					}
				}
			}
			
			$sqlVer="SELECT id FROM k_klaim_detail WHERE klaim_id=$klaim_id AND tstatus<2 LIMIT 1";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			if (mysql_num_rows($rsVer)==0){
				$sqlVer="UPDATE k_klaim SET tstatus = 1 WHERE id = '$klaim_id'";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
			}
			
			$sqlVer="SELECT IFNULL(SUM(nilai_terima),0) ntot FROM k_klaim_terima_detail WHERE klaim_terima_id='$klaim_terima_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			$rwVer=mysql_fetch_array($rsVer);
			$ntot=$rwVer["ntot"];
			$sqlVer="UPDATE k_klaim_terima SET nilai = '$ntot' WHERE id = '$klaim_terima_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
		}
		else if ($posting==1)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$id=$cdata[0];
				
				//========cek sudah posting/belum=========
				$sqlVer="SELECT id,klaim_detail_id FROM k_klaim_terima_detail
						WHERE id = '$id' AND tstatus=0";
				//echo $sqlCek."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_num_rows($rsVer)>0){
					$rwVer=mysql_fetch_array($rsVer);
					$klaim_detail_id=$rwVer["klaim_detail_id"];
					//========uposting selisih tarip=========
					$sqlVer="UPDATE k_klaim_detail
							SET tstatus = '0'
							WHERE id = '$klaim_detail_id'";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					if (mysql_affected_rows()>0){
						$sqlVer="DELETE FROM k_klaim_terima_detail
								WHERE id = '$id'";
						//echo $sqlVer."<br>";
						$rsVer=mysql_query($sqlVer);
						if (mysql_affected_rows()==0){
							$sqlVer="UPDATE k_klaim_detail
									SET tstatus = '2'
									WHERE id = '$klaim_detail_id'";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							
							//=======unposting gagal======
							$statusProses='Error';
							$alasan='UnPosting Gagal';
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
			
			$sqlVer="UPDATE k_klaim SET tstatus = 0 WHERE id = '$klaim_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);

			$sqlVer="SELECT IFNULL(SUM(nilai_terima),0) ntot FROM k_klaim_terima_detail WHERE klaim_terima_id='$klaim_terima_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			$rwVer=mysql_fetch_array($rsVer);
			$ntot=$rwVer["ntot"];
			$sqlVer="UPDATE k_klaim_terima SET nilai = '$ntot' WHERE id = '$klaim_terima_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
		} else {
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$klaim_terima_detail_id=$cdata[0];
				$nilai_terima=$cdata[1];
				
				/* $sqlCKlaim = "select * from k_klaim_detail kd
								where kd.norm = "; */
				
				$sqlVer="SELECT id FROM k_klaim_terima_detail
						WHERE id = '$klaim_terima_detail_id' AND tstatus<2";
				//echo $sqlVer."<br>";
				$rsVer=mysql_query($sqlVer);
				if (mysql_num_rows($rsVer)>0){
					$sqlVer = "UPDATE k_klaim_terima_detail
								SET tstatus = 2
								WHERE id = '{$klaim_terima_detail_id}'";
					$rsVer = mysql_query($sqlVer);
				} else {
					$statusProses='Error';
					$alasan='Verifikasi Gagal';
				}
			}
			
			$sqlVer="SELECT IFNULL(SUM(nilai_terima),0) ntot FROM k_klaim_terima_detail WHERE klaim_terima_id='$klaim_terima_id' AND tstatus = 2";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
			$rwVer=mysql_fetch_array($rsVer);
			$ntot=$rwVer["ntot"];
			$sqlVer="UPDATE k_klaim_terima SET nilai = '$ntot' WHERE id = '$klaim_terima_id'";
			//echo $sqlVer."<br>";
			$rsVer=mysql_query($sqlVer);
		}
        break;
	case "setkunjungan":
		$klaim_terima_detail_id = $_REQUEST['klaim_terima_detail_id'];
		$kunjungan_id = $_REQUEST['kunjungan_id'];
		$kso_id = $_REQUEST['kso_id'];
		
		//$sqlVer = "SELECT id FROM k_klaim_terima_detail WHERE id = {$klaim_terima_detail_id}";
		$sqlVer = "SELECT ktd.id, kt.klaim_id, IFNULL(kt.kso_id,0) kso_id
					FROM k_klaim_terima_detail ktd
					INNER JOIN k_klaim_terima kt
					   ON kt.id = ktd.klaim_terima_id
					WHERE ktd.id = {$klaim_terima_detail_id}";
		$rsVer=mysql_query($sqlVer);
		if (mysql_num_rows($rsVer)>0){
			$dVer = mysql_fetch_array($rsVer);
			if($dVer['kso_id'] != '0'){
				$kso_id = $dVer['kso_id'];
			} else {
				$kso_id = $_REQUEST['kso_id'];
			}
			$sqlVer = "UPDATE k_klaim_terima_detail
						SET kunjungan_id = {$kunjungan_id}/* ,
							kso_id = {$kso_id} */
						WHERE id = {$klaim_terima_detail_id}";
			$rsVer=mysql_query($sqlVer);
			if (mysql_affected_rows()==0){
				$statusProses='Error';
				$alasan='Pemilihan Kunjungan Pasien Gagal!';
			}
		} else {
			$statusProses='Error';
			$alasan='Pemilihan Kunjungan Pasien Gagal!';
		}
		break;
	case "hapusimport":
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		$jml = count($arfdata);
		if(count($arfdata) > 0){
			if($jml > 1){
				$whapus = "AND id IN ('".implode("','",$arfdata)."')";
			} else {
				$whapus = "AND id = ".$fdata;
			}
			
			$shapus = "DELETE FROM k_klaim_terima_detail WHERE tstatus = 0 {$whapus} ";
			$qhapus = mysql_query($shapus);
			if (mysql_affected_rows()==0){
				$statusProses='Error';
				$alasan='Penghapusan Data Import Gagal!';
			}
		} else {
			$statusProses='Error';
			$alasan='Pilih Data Import yang Ingin di Hapus!';
		}
		/* for ($i=0;$i<count($arfdata);$i++){
		} */
		break;
}

if (($statusProses=='') && (strtolower($_REQUEST['act'])=='verifikasi')){
	if ($posting==0 || $posting==2){
		$alasan='Verifikasi Data Berhasil !';
	}else{
		$alasan='UnVerifikasi Data Berhasil !';
	}
} else if (($statusProses=='') && (strtolower($_REQUEST['act'])=='setkunjungan')){
	$alasan = "Kunjungan Pasien Berhasil Di Pilih!";
} else if (($statusProses=='') && (strtolower($_REQUEST['act'])=='hapusimport')){
	$alasan = "Data Import Berhasil di Hapus!";
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
	
	if($grid == "klaimTerima") {
		$sql = "SELECT *
				FROM (SELECT
						  kt.id,
						  kt.klaim_id,
						  kt.verifikasi,
						  kt.posting,
						  IF(ifnull(k.kso_id,0) <> 0, k.kso_id, ifnull(kt.kso_id,0)) AS kso_id,
						  DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl_klaim,
						  DATE_FORMAT(kt.tgl,'%d-%m-%Y') AS tgl_terima,
						  k.no_bukti,
						  kt.no_bukti   AS no_terima,
						  kso.nama,
						  k.nilai,
						  kt.nilai 		AS nilai_terima
						FROM k_klaim_terima kt
						  LEFT JOIN k_klaim k
							ON kt.klaim_id = k.id
						  LEFT JOIN $dbbilling.b_ms_kso kso
							ON IF(ifnull(k.kso_id,0) <> 0, k.kso_id, ifnull(kt.kso_id,0)) = kso.id
						WHERE YEAR(kt.tgl) = '$thn') t1";
    }
	elseif($grid == 1) {
		if ($posting=="0"){
			$sql = "SELECT *
					FROM (SELECT
							  kd.id,
							  pas.no_rm,
							  pas.nama AS pasien,
							  kso.id AS kso_id,
							  kso.nama AS kso,
							  mu.nama AS unit,
							  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
							  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
							  IFNULL(SUM(kp.biayaRS),0) AS biayaRS,
							  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
							  IFNULL(SUM(kd.nilai_klaim),0) AS nilai_klaim
							FROM k_klaim_detail kd
							  INNER JOIN k_piutang kp
								ON kd.fk_id = kp.id
							  INNER JOIN $dbbilling.b_kunjungan k
								ON kp.kunjungan_id = k.id
							  INNER JOIN $dbbilling.b_ms_unit mu
								ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_ms_pasien pas
								ON k.pasien_id = pas.id
							  INNER JOIN $dbbilling.b_ms_kso kso
								ON kp.kso_id = kso.id
							WHERE kd.klaim_id='$klaim_id' AND kd.tstatus<2
							GROUP BY kp.kunjungan_id,kp.kso_id) t1
					WHERE 0 = 0 $filter
					ORDER BY $sorting";
		}else if ($posting=="1"){
			$sql = "SELECT *
					FROM (SELECT
							  ktd.id,
							  ktd.klaim_detail_id,
							  pas.no_rm,
							  pas.nama AS pasien,
							  kso.id AS kso_id,
							  kso.nama AS kso,
							  mu.nama AS unit,
							  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
							  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
							  IFNULL(SUM(kp.biayaRS),0) AS biayaRS,
							  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
							  IFNULL(SUM(kd.nilai_klaim),0) AS nilai_klaim,
							  IFNULL(SUM(ktd.nilai_terima),0) AS nilai_terima
							FROM k_klaim_terima kt
							  INNER JOIN k_klaim_terima_detail ktd
								ON kt.id = ktd.klaim_terima_id
							  INNER JOIN k_klaim_detail kd
								ON ktd.klaim_detail_id = kd.id
							  INNER JOIN k_piutang kp
								ON kd.fk_id = kp.id
							  INNER JOIN $dbbilling.b_kunjungan k
								ON kp.kunjungan_id = k.id
							  INNER JOIN $dbbilling.b_ms_unit mu
								ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_ms_pasien pas
								ON k.pasien_id = pas.id
							  INNER JOIN $dbbilling.b_ms_kso kso
								ON kp.kso_id = kso.id
							WHERE ktd.klaim_terima_id='$klaim_terima_id'
							GROUP BY kp.kunjungan_id,kp.kso_id) t1
					WHERE 0 = 0 $filter
					ORDER BY $sorting";
		} else {
			$sql = "SElECT *
					FROM (SELECT ktd.id,
							  ktd.klaim_detail_id,
							  ifnull(pas.no_rm, ktd.norm) no_rm,
							  ifnull(pas.nama, ktd.namapasien) AS pasien,
							  kso.id AS kso_id, kso.nama AS kso, mu.nama AS unit,
							  DATE_FORMAT(IFNULL(kp.tglK, ktd.tglmsk), '%d-%m-%Y') AS tgl,
							  DATE_FORMAT(IFNULL(kp.tglP, ktd.tglklr), '%d-%m-%Y') AS tgl_p,
							  IFNULL(SUM(IFNULL(kp.biayaRS, ktd.tariffrs)),0) AS biayaRS,
							  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
							  IFNULL(SUM(IFNULL(kd.nilai_klaim, ktd.tarif)),0) AS nilai_klaim,
							  IFNULL(SUM(ktd.nilai_terima),0) AS nilai_terima, ktd.sep,
							  IFNULL(ktd.kunjungan_id,0) kunjungan_id
							FROM k_klaim_terima kt
							INNER JOIN k_klaim_terima_detail ktd
							   ON ktd.klaim_terima_id = kt.id
							LEFT JOIN k_klaim_detail kd
							   ON kd.id = ktd.klaim_detail_id
							LEFT JOIN k_piutang kp
							   ON kp.id = kd.fk_id
							LEFT JOIN $dbbilling.b_kunjungan k
							   ON k.id = IFNULL(kp.kunjungan_id, ktd.kunjungan_id)
							LEFT JOIN $dbbilling.b_ms_unit mu
							   ON mu.id = k.unit_id
							LEFT JOIN $dbbilling.b_ms_pasien pas
							   ON pas.id = k.pasien_id
							LEFT JOIN $dbbilling.b_ms_kso kso
							   ON kso.id = IFNULL(kp.kso_id, ktd.kso_id)
							WHERE ktd.klaim_terima_id = '$klaim_terima_id'
							  AND ktd.tstatus < 2 AND ktd.sep IS NOT NULL
							GROUP BY kp.kunjungan_id, kp.kso_id, ktd.norm, ktd.sep) t1
					WHERE 0 = 0 $filter
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
    } else if($grid == 3){
		if ($sorting=="") {
			$sorting = 't1.tgl DESC';
		}
		$norm = $_REQUEST['norm'];
		$tglmsk = $_REQUEST['tglmsk'];
		
		$ftgl = "AND k.tgl = '{$tglmsk}'";
		if($tglmsk == '-'){
			$tgl_a = tglSQL($_REQUEST['tgl_a']);
			$tgl_b = tglSQL($_REQUEST['tgl_b']);
			$ftgl = "AND k.tgl BETWEEN '{$tgl_a} 00:00:00' AND '{$tgl_b} 23:59:59'";
		}
		$sql = "SELECT *
				FROM (SELECT pas.no_rm norm, pas.nama, k.no_sjp sep, k.unit_id, u.nama unit, 
					k.kso_id, kso.nama kso, DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl, k.id
				FROM $dbbilling.b_kunjungan k
				INNER JOIN $dbbilling.b_ms_pasien pas
				   ON pas.id = k.pasien_id
				INNER JOIN $dbbilling.b_ms_unit u
				   ON u.id = k.unit_id
				INNER JOIN $dbbilling.b_ms_kso kso
				   ON kso.id = k.kso_id
				WHERE pas.no_rm = '{$norm}'
				  {$ftgl}
				  {$fkso}) t1
				WHERE 0 = 0 {$filter}
				ORDER BY {$sorting}";
	}
    
    if($grid == 1){
		if ($posting==0){
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(nilai_klaim),0) as totKsoKlaim,
						0 as totKsoTerima
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = $rowPlus['totKsoKlaim'];
			$totKlaimTerima=$rowPlus['totKsoTerima'];
		}else if ($posting==1){
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(nilai_klaim),0) as totKsoKlaim,
						IFNULL(sum(nilai_terima),0) as totKsoTerima
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = $rowPlus['totKsoKlaim'];
			$totKlaimTerima=$rowPlus['totKsoTerima'];
		} else {
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(nilai_klaim),0) as totKsoKlaim,
						IFNULL(sum(nilai_terima),0) as totKsoTerima
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer'];
			$totPas = $rowPlus['totPas'];
			$totKsoKlaim = $rowPlus['totKsoKlaim'];
			$totKlaimTerima=$rowPlus['totKsoTerima'];
		}
    }
    
    //echo $sql."<br>";
    $rs=mysql_query($sql) or die;
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
	//$i=0;
    $dt=$totpage.chr(5);
    $unit_asal = '';
	$baris = 0;
	if($grid == "klaimTerima") {
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$baris++;
			$tedit="<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Mengubah' onClick='fEditKlaimTerima({$baris})'>";
			$thapus="<img src='../icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick='fHapusKlaimTerima({$baris});'>";
			$tverif="<img src='../icon/go.png' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Verifikasi Penerimaan Klaim' onClick='fVerifKlaimTerima(".$rows["id"].",".$rows["verifikasi"].");'>";
			switch ($rows["verifikasi"]){
				case 1:
					$tstatus="Penerimaan Klaim";
					$tverif="<img src='../icon/save.ico' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Membatalkan Penerimaan Klaim' onClick='fVerifKlaimTerima(".$rows["id"].",".$rows["verifikasi"].");'>";
					break;
			}
			$tproses=$tedit."      |     ".$thapus."      |     ".$tverif;
			$sisip=$rows["id"]."|".$rows["klaim_id"]."|".$rows["kso_id"]."|".$rows["kso_id"]."|".$rows["no_bukti"]."|".$rows["no_terima"]."|".$rows["verifikasi"]."|".$rows["posting"]."|".$rows['nilai_terima'];
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_terima"].chr(3).$rows["no_terima"].chr(3).$rows["tgl_klaim"].chr(3).$rows["no_bukti"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).number_format($rows["nilai_terima"],0,",",".").chr(3).$tproses.chr(6);
		}
    }
	elseif($grid == 1) {
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$baris++;
			$tmpLay = $rows["unit"];
			$kso = $rows["kso"];
			$tPerda=$rows["biayaRS"];
			$tPx=$rows["biayaPasien"];
			$tKSO_Klaim=$rows["nilai_klaim"];
			if ($posting==0|| $posting==2){
				if($posting==2){
					$readonly = "readonly";
				} else { $readonly = ""; }
				$tKSO_Terima="<input type='text' id='nilai_$i' class='txtinput' {$readonly} value='".number_format($tKSO_Klaim,0,",",".")."' style='width:70px; font:12px tahoma; padding:2px; text-align:right' onkeyup='zxc(this);' />";
			}else{
				$tKSO_Terima=number_format($rows["nilai_terima"],0,",",".");
			}
			if($posting != 2){
				$sisip=$rows["id"];
			} else {
				if($rows['kunjungan_id'] == '0'){
					$tmpLay = "<a href='javascript:void(0)' onclick='getKunjungan({$baris})'>Search...</a>"; 
				}
				$sisip=$rows["id"]."|".$rows["no_rm"]."|".tglSQL($rows["tgl"])."|".$rows["sep"]; //."|".$rows["pasien"];
			}
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO_Klaim,0,",",".").chr(3).$tKSO_Terima.chr(3)."0".chr(6);
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
    } else if($grid == 3){
		$klaim_terima_detail_id = $_REQUEST['klaim_terima_detail_id'];
		while ($rows=mysql_fetch_array($rs)) {
            $i++;
			$baris++;
			$sisip = $rows['id']."|".$rows['unit_id']."|".$rows['kso_id']."|".$klaim_terima_detail_id;
			$pilih = "<img src='../icon/go.png' alt='Pilih Kunjungan' onclick='setKunjungan({$baris})' class='proses' width='16px' align='absmiddle'/>";
			$dt .= $sisip.chr(3).$i.chr(3).$rows['tgl'].chr(3).$rows['norm'].chr(3).$rows['nama'].chr(3).$rows['kso'].chr(3).$rows['unit'].chr(3).$rows['sep'].chr(3).$pilih.chr(6);
		}
	}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		
		if($grid == 1){
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKsoKlaim,0,",",".").chr(3).number_format($totKlaimTerima,0,",",".").chr(3).$alasan;
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
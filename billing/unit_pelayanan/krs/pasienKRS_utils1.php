<?php
include("../../koneksi/konek.php");
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$grd3 = $_REQUEST["grd3"];
$userId=$_REQUEST['userId'];
$msg = "";
/* ================================= */
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
        switch($_REQUEST["smpn"]){
            case 'btnPasienPulang':
				$sCekDilayani="SELECT * FROM(
	SELECT p.id, p.id AS pelayanan_id,p.tgl AS tgl_pelayanan, p.kunjungan_id, DATE_FORMAT(p.tgl, '%d-%m-%Y') tgl, u.id AS unit_id, u.nama AS unit, u2.nama AS unitasal FROM b_pelayanan p
	INNER JOIN b_ms_unit u ON u.id = p.unit_id
	INNER JOIN b_ms_unit u2 ON u2.id = p.unit_id_asal
	LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
	WHERE p.kunjungan_id = '".$kunjungan_id."' AND p.unit_id NOT IN (122,123) AND t.user_id IS NULL ) AS tbl
	WHERE (SELECT COUNT(d.diagnosa_id) FROM b_diagnosa d WHERE d.pelayanan_id = tbl.pelayanan_id) <= 0
	  AND (SELECT COUNT(t.id) FROM b_tindakan t WHERE t.pelayanan_id = tbl.pelayanan_id AND t.user_id <> 0) <= 0
	  AND (SELECT COUNT(ap.ID) FROM $dbapotek.a_penjualan ap WHERE ap.NO_KUNJUNGAN = tbl.pelayanan_id) <= 0 
	  AND (SELECT COUNT(p2.id) FROM b_pelayanan p2 INNER JOIN b_ms_unit u2 ON u2.id = p2.unit_id
			WHERE p2.kunjungan_id = tbl.kunjungan_id AND p2.unit_id_asal = tbl.unit_id AND u2.inap = 0) <= 0
	  AND (SELECT COUNT(p3.id) FROM b_pelayanan p3 INNER JOIN b_ms_unit u3 ON u3.id = p3.unit_id
			WHERE p3.kunjungan_id = tbl.kunjungan_id AND p3.unit_id_asal = tbl.unit_id AND u3.inap = 1) <= 0
	  AND DATEDIFF(NOW(), tbl.tgl_pelayanan) <= 0
	GROUP BY tbl.pelayanan_id";
				//echo $sCekDilayani."<br>";
				$qCekDilayani=mysql_query($sCekDilayani);
				$rwCekDilayani=mysql_fetch_array($qCekDilayani);
				if($rwCekDilayani['belum_dilayani']>0){
					echo 'Tidak bisa di KRS-kan. Masih ada konsul yang belum terlayani. Batalkan konsul melalui tombol Hapus Konsul.';
				}
				else{
					$sqlCek = "SELECT u.id, u.inap FROM b_pelayanan p INNER JOIN b_ms_unit u ON p.unit_id = u.id WHERE p.id = '$pelayanan_id'";
					//echo $sqlCek."<br>";
					$rsCek = mysql_query($sqlCek);
					$rowCek = mysql_fetch_array($rsCek);
		
					$tglPul = "now()";
					
					$sKRS="update b_pelayanan set sudah_krs=1, tgl_krs=$tglPul where id='".$pelayanan_id."'";
					//echo $sKRS."<br>";
					mysql_query($sKRS);
					
					/*$sKRS="UPDATE 
							b_pelayanan p 
							INNER JOIN b_ms_unit u ON u.id = p.unit_id
							SET
							p.sudah_krs=1,
							p.tgl_krs=IF(p.tgl_krs IS NULL,$tglPul,p.tgl_krs)
							WHERE 
							p.kunjungan_id='$kunjungan_id' 
							AND p.jenis_kunjungan=3
							AND u.inap=0
							AND p.hapus = 0
							AND p.unit_id NOT IN (122,123)
							AND p.sudah_krs=0";*/
					$sKRS="UPDATE 
							b_pelayanan p 
							INNER JOIN b_ms_unit u ON u.id = p.unit_id
							SET
							p.sudah_krs=1,
							p.tgl_krs=$tglPul
							WHERE 
							p.kunjungan_id='$kunjungan_id' 
							AND p.jenis_kunjungan=3
							AND u.inap=0
							AND p.hapus = 0
							AND p.unit_id NOT IN (122,123)
							AND p.sudah_krs=0";
					//echo $sKRS."<br>";
					mysql_query($sKRS);
					
					if($rowCek['inap'] == 1){
						/*$sqlCek = "SELECT p.tgl_krs FROM b_pelayanan p WHERE p.id = '$pelayanan_id' and p.tgl_krs is not null order by p.tgl_krs desc limit 1";
						$rsCek = mysql_query($sqlCek);
						if(mysql_num_rows($rsCek) > 0){
							$rowCek = mysql_fetch_array($rsCek);
							$tglPul = "'".$rowCek['tgl_krs']."'";
						}*/
						
						$sqlKunj = "UPDATE b_tindakan_kamar SET tgl_out=$tglPul, trace_id=3 WHERE pelayanan_id='$pelayanan_id' AND tgl_out IS NULL";
						//echo $sqlKunj."<br>";
						$rsKunj = mysql_query($sqlKunj);
						
						$sqlKunj = "update b_kunjungan set tgl_pulang = $tglPul, tgl_pulang_ak = $tglPul, pulang = 1, user_act_pulang = '".$userId."', unit_pulang = '".$rowCek['id']."' where id = '$kunjungan_id'";
						//echo $sqlKunj."<br>";
						$rsKunj = mysql_query($sqlKunj);
					}
					else{
						$sqlKunj = "update b_kunjungan set tgl_pulang = $tglPul, tgl_pulang_ak = $tglPul, pulang = 1, user_act_pulang = '".$userId."', unit_pulang = '".$rowCek['id']."' where id = '$kunjungan_id'";
						//echo $sqlKunj."<br>";
						$rsKunj = mysql_query($sqlKunj);
					}
					mysql_free_result($rsCek);
					echo 'Berhasil dipulangkan';
				}
				return;
				break;
		}
		break;
    case 'hapus':
		$msg="";
        switch($_REQUEST["hps"]) {
			case 'btnBatalPulang':
				$sTglKRS="SELECT IF(hari<0,0,hari) AS hari FROM (SELECT DATEDIFF(DATE(NOW()),IFNULL(DATE(tgl_krs),DATE(NOW()))) AS hari FROM b_pelayanan WHERE id = '".$_REQUEST['pelayanan_id']."') AS tbl";
				//echo $sTglKRS.";<br>";
				$qTglKRS=mysql_query($sTglKRS);
				$wTglKRS=mysql_fetch_array($qTglKRS);
				$btsJamKRS="SELECT TIMESTAMPDIFF(HOUR,tgl_krs,NOW()) AS selisih FROM b_pelayanan WHERE id = '".$_REQUEST['pelayanan_id']."'";
				//echo $btsJamKRS.";<br>";
				$qJamKRS=mysql_query($btsJamKRS);
				$wJamKRS=mysql_fetch_array($qJamKRS);
				if($wJamKRS['selisih']<=12)
				{
					/*if($wTglKRS['hari']>$xHari){
					
					}
					else{*/
						$sqlKRS = "update b_pelayanan set sudah_krs = 0, tgl_krs = NULL where id='".$_REQUEST['pelayanan_id']."'";
						//echo $sqlKRS.";<br>";
						$rsKRS = mysql_query($sqlKRS);
						
						$sBatalKRS="UPDATE 
								b_pelayanan p 
								INNER JOIN b_ms_unit u ON u.id = p.unit_id
								SET
								p.sudah_krs=0, tgl_krs = NULL
								WHERE 
								p.kunjungan_id='$kunjungan_id' 
								AND p.jenis_kunjungan=3
								AND u.inap=0
								AND p.sudah_krs=1";
						//echo $sBatalKRS.";<br>";
						mysql_query($sBatalKRS);
						
						$qUpdte = "INSERT INTO `b_pelayanan_updt` (
							  `id_pelayanan`,
							  `no_antrian`,
							  `jenis_kunjungan`,
							  `is_baru`,
							  `pasien_id`,
							  `kunjungan_id`,
							  `is_paviliun`,
							  `jenis_layanan`,
							  `unit_id`,
							  `unit_id_asal`,
							  `kso_id`,
							  `kelas_id`,
							  `tgl`,
							  `tgl_kunjung`,
							  `tgl_krs`,
							  `sudah_krs`,
							  `pending_krs`,
							  `dilayani`,
							  `ket`,
							  `dokter_id`,
							  `type_dokter`,
							  `tgl_act`,
							  `user_act`,
							  `no_lab`,
							  `verifikasi`,
							  `verifikator`,
							  `hapus`,
							  `no_sample`,
							  `resep_kronis`,
							  `user_update`,
							  `tgl_update`
							) 
							SELECT 
							  `id`,
							  `no_antrian`,
							  `jenis_kunjungan`,
							  `is_baru`,
							  `pasien_id`,
							  `kunjungan_id`,
							  `is_paviliun`,
							  `jenis_layanan`,
							  `unit_id`,
							  `unit_id_asal`,
							  `kso_id`,
							  `kelas_id`,
							  `tgl`,
							  `tgl_kunjung`,
							  `tgl_krs`,
							  `sudah_krs`,
							  `pending_krs`,
							  `dilayani`,
							  `ket`,
							  `dokter_id`,
							  `type_dokter`,
							  `tgl_act`,
							  `user_act`,
							  `no_lab`,
							  `verifikasi`,
							  `verifikator`,
							  `hapus`,
							  `no_sample`,
							  `resep_kronis`,
							  '{$userId}',
							  NOW() 
							FROM
							  `b_pelayanan`
							 WHERE id='".$_REQUEST['pelayanan_id']."'";
						//echo $qUpdte.";<br>";
						$rsKunj = mysql_query($qUpdte);
						
						$sqlKunj = "SELECT * FROM b_tindakan_kamar WHERE pelayanan_id='".$_REQUEST['pelayanan_id']."' ORDER BY id DESC LIMIT 1";
						//echo $sqlKunj.";<br>";
						$rsKunj = mysql_query($sqlKunj);
						$rwKunj = mysql_fetch_array($rsKunj);
						
						$sqlKunj = "UPDATE b_tindakan_kamar SET tgl_out=NULL, trace_id=6 WHERE id='".$rwKunj['id']."'";
						//echo $sqlKunj.";<br>";
						$rsKunj = mysql_query($sqlKunj);
					
						$sqlKunj = "update b_kunjungan set tgl_pulang = NULL, tgl_pulang_ak=NULL ,pulang = 0, user_act_batal_pulang = '".$userId."' where id = '$kunjungan_id'";
						//echo $sqlKunj.";<br>";
						$rsKunj = mysql_query($sqlKunj);
						echo 'Batal dipulangkan';
						return;
					//}
				}else{
					echo 'Waktu Pembatalan Telah Habis!!!';
					return;
				}
				break;
		}
		break;
}
?>
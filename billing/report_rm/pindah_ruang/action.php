<?php
include '../../koneksi/konek.php';
function getValue($a,$b){
	switch($a){
		case 'alatbantu': $n = 6; break;
		case 'mobilisasi': $n = 4; break;
		case 'radiologi': $n = 4; break;
		case 'diagnostik': $n = 4; break;
		case 'barang': $n = 2; break;
		case 'bukti': $n = 3; break;
	}
	for($i=1;$i<=$n;$i++){
		if($b[$i] == 1){
			if($i != $n){
				$result .= $b[$i].",";
			} else {
				$result .= $b[$i];
			}
		} else {
			if($i != $n){
				$result .= "0,";
			} else {
				$result .= "0";
			}
		}
	}
	return $result;
}
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
$idUser = $_REQUEST['idUsr'];
$act = $_REQUEST['actSerahTerima'];
$tglRawat = explode('-',$_REQUEST['tgl_rawat']);
$tgl_rawat = $tglRawat[2]."-".$tglRawat[1]."-".$tglRawat[0]." ".$_REQUEST['jam_rawat'].":00";

$tglPindah = explode('-',$_REQUEST['tgl_pindah']);
$tgl_pindah = $tglPindah[2]."-".$tglPindah[1]."-".$tglPindah[0]." ".$_REQUEST['jam_pindah'].":00";

$dokter_dpjp = $_REQUEST['dokter_dpjp'];
$dokter_konsul = $_REQUEST['dokter_konsul'];
$indikasi = $_REQUEST['indikasi'];
$kesadaran = $_REQUEST['kesadaran'];
$diagnosa = $_REQUEST['diagnosa'];
$tekdarah = $_REQUEST['tekdarah']; 
$pernafasan = $_REQUEST['pernafasan'];
$nadi = $_REQUEST['nadi'];
$suhu = $_REQUEST['suhu'];
$beratbadan = $_REQUEST['beratbadan'];
$tinggibadan = $_REQUEST['tinggibadan'];

$alatbantu = getValue('alatbantu',$_REQUEST['alatbantu']);
$pecahAlatBantu = explode(',',$alatbantu);
$alat_bantu_lain = ($pecahAlatBantu[5] == 1)?$_REQUEST['alat_bantu_lain']:'';

$tindakan_operasi = $_REQUEST['tindakan_operasi'];

$mobilisasi = getValue('mobilisasi',$_REQUEST['mobilisasi']);
$pecahMobilisasi = explode(',',$mobilisasi);
$mobilisasi_lain = ($pecahMobilisasi[3] == 1)?$_REQUEST['mobilisasi_lain']:'';

$tingkat_ketergantungan = $_REQUEST['tingkat_ketergantungan'];

$radiologi = getValue('radiologi',$_REQUEST['radiologi']);
$pecahRadiologi = explode(',',$radiologi);
$thorax_input = ($pecahRadiologi[1] == 1)?$_REQUEST['thorax_input']:'';
$ctscan_input = ($pecahRadiologi[2] == 1)?$_REQUEST['ctscan_input']:'';
$radiologi_lain = ($pecahRadiologi[3] == 1)?$_REQUEST['radiologi_lain']:'';

$diagnostik = getValue('diagnostik',$_REQUEST['diagnostik']);
$pecahDiagnostik = explode(',',$diagnostik);
$echo_input = ($pecahDiagnostik[1] == 1)?$_REQUEST['echo_input']:'';
$eeg_input = ($pecahDiagnostik[2] == 1)?$_REQUEST['eeg_input']:'';
$usg_input = ($pecahDiagnostik[3] == 1)?$_REQUEST['usg_input']:'';

$laboratorium = $_REQUEST['laboratorium'];
$lab_input = ($laboratorium == 1)?$_REQUEST['lab_input']:'';

$barang = getValue('barang',$_REQUEST['barang']);
$pecahBarang = explode(',',$barang);
$barang_lain = ($pecahBarang[1] == 1)?$_REQUEST['barang_lain']:'';

$bukti = getValue('bukti',$_REQUEST['bukti']);
$pecahBukti = explode(',',$bukti);
$bukti_lain = ($pecahBukti[2] == 1)?$_REQUEST['bukti_lain']:'';

$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$tgl_act = $_REQUEST['tgl_act'];
$user_act = $_REQUEST['user_act'];
$serah_terima_id = $_REQUEST['serah_terima_id'];

$rawID = $_REQUEST['rawID'];
$catatID = $_REQUEST['catatID'];
$pesanan = $_REQUEST['pesanan'];
$keterangan = $_REQUEST['keterangan'];
$instruksi = $_REQUEST['instruksi'];
$catatanDelete = substr($_REQUEST['deleteCatatan'],0,strlen($_REQUEST['deleteCatatan'])-1);;

$rawID2 = $_REQUEST['rawID2'];
$obatID = $_REQUEST['obatID'];
$nama_obat = $_REQUEST['nama_obat'];
$dosis = $_REQUEST['dosis'];
$jumlah_obat = $_REQUEST['jumlah_obat'];
$sisa_obat = $_REQUEST['sisa_obat'];
$obatDelete = substr($_REQUEST['deleteObat'],0,strlen($_REQUEST['deleteObat'])-1);;


switch($act){
	case 'save':
		$sqlInsert = "INSERT INTO b_serah_terima_pindah_ruang
						(
							tgl_rawat, tgl_pindah, dokter_dpjp, dokter_konsul, indikasi, kesadaran, diagnosa, 
							tekdarah, pernafasan, nadi, suhu, beratbadan, tinggibadan, alatbantu, alatbantu_lain, 
							tindakan_operasi, mobilisasi, mobilisasi_lain, tingkat_ketergantungan, radiologi, thorax, 
							ctscan, radiologi_lain, diagnostik, echo, eeg, usg, laboratorium,
							barang, barang_lain, bukti, bukti_lain, pelayanan_id, kunjungan_id, tgl_act, user_act
						) VALUES 
						(
							'{$tgl_rawat}', '{$tgl_pindah}', '{$dokter_dpjp}', '{$dokter_konsul}', '{$indikasi}', '{$kesadaran}', '{$diagnosa}', 
							'{$tekdarah}', '{$pernafasan}', '{$nadi}', '{$suhu}', '{$beratbadan}', '{$tinggibadan}', '{$alatbantu}', '{$alat_bantu_lain}', 
							'{$tindakan_operasi}', '{$mobilisasi}', '{$mobilisasi_lain}', '{$tingkat_ketergantungan}', '{$radiologi}', '{$thorax_input}',
							'{$ctscan_input}', '{$radiologi_lain}', '{$diagnostik}', '{$echo_input}', '{$eeg_input}', '{$usg_input}', '{$lab_input}',
							'{$barang}', '{$barang_lain}', '{$bukti}', '{$bukti_lain}', '{$idPel}', '{$idKunj}', NOW(), '{$idUser}'
						) ";
		$queryInsert = mysql_query($sqlInsert);
		if($queryInsert){
			$idSerahTerima = mysql_insert_id();
			for($a = 0; $a < count($rawID); $a++){
				if($a != (count($rawID))-1){
					$sqlCatatan .= " ('{$pesanan[$a]}', '{$keterangan[$a]}', '{$instruksi[$a]}', '{$idSerahTerima}' ),";
				} else {
					$sqlCatatan .= " ('{$pesanan[$a]}', '{$keterangan[$a]}', '{$instruksi[$a]}', '{$idSerahTerima}' )";
				}
				
			}
			$sqlawal = 'INSERT INTO b_catatan_pindah_ruang ( pesanan, keterangan, instruksi, serah_terima_id ) VALUES';			
			$sqlAkhir = $sqlawal.$sqlCatatan;			
			$hasil = mysql_query($sqlAkhir);
			/*---------------------------------------------------------------*/
			//$idSerahTerima2 = mysql_insert_id();
			for($a2 = 0; $a2 < count($rawID2); $a2++){
				if($a2 != (count($rawID2))-1){
					$sqlCatatan2 .= " ('{$nama_obat[$a2]}', '{$dosis[$a2]}', '{$jumlah_obat[$a2]}', '{$sisa_obat[$a2]}', '{$idSerahTerima}' ),";
				} else {
					$sqlCatatan2 .= " ('{$nama_obat[$a2]}', '{$dosis[$a2]}', '{$jumlah_obat[$a2]}', '{$sisa_obat[$a2]}', '{$idSerahTerima}' )";
				}
				
			}
			$sqlawal2 = 'INSERT INTO b_obat_pindah_ruang ( nama_obat, dosis, jumlah_obat, sisa_obat, serah_terima_id ) VALUES';			
			$sqlAkhir2 = $sqlawal2.$sqlCatatan2;			
			$hasil2 = mysql_query($sqlAkhir2);
			/*---------------------------------------------------------------*/
		}
		
	break;
	case 'edit':
		$sqlUpdate = "UPDATE b_serah_terima_pindah_ruang SET 
						tgl_rawat = '{$tgl_rawat}', tgl_pindah = '{$tgl_pindah}', dokter_dpjp = '{$dokter_dpjp}', indikasi = '{$indikasi}', 
						kesadaran = '{$kesadaran}', diagnosa = '{$diagnosa}', tekdarah = '{$tekdarah}', pernafasan = '{$pernafasan}', nadi = '{$nadi}',
						suhu = '{$suhu}', beratbadan = '{$beratbadan}', tinggibadan = '{$tinggibadan}', alatbantu = '{$alatbantu}', 
						alatbantu_lain = '{$alat_bantu_lain}', tindakan_operasi = '{$tindakan_operasi}', mobilisasi = '{$mobilisasi}', 
						mobilisasi_lain = '{$mobilisasi_lain}', tingkat_ketergantungan = '{$tingkat_ketergantungan}', radiologi = '{$radiologi}', 
						thorax = '{$thorax_input}', ctscan = '{$ctscan_input}', radiologi_lain = '{$radiologi_lain}', diagnostik = '{$diagnostik}',
						echo = '{$echo_input}', eeg = '{$eeg_input}', usg = '{$usg_input}', laboratorium = '{$lab_input}', barang = '{$barang}',
						barang_lain = '{$barang_lain}', bukti = '{$bukti}', bukti_lain = '{$bukti_lain}', tgl_act = NOW()
					  WHERE serah_terima_id = '{$serah_terima_id}' ";
					  
		$queryUpdate = mysql_query($sqlUpdate);
		//echo '$sqlUpdate';	
		if($queryUpdate){
			if($catatanDelete != ''){
				$rsDelete = mysql_query("DELETE FROM b_catatan_pindah_ruang WHERE catatan_id IN ({$catatanDelete})") or die (mysql_error());
			}else{
				
			}			
			for($a = 0; $a < count($rawID); $a++){
				if($catatID[$a] != ''){
					$catatUpdate = "UPDATE b_catatan_pindah_ruang 
									SET pesanan = '{$pesanan[$a]}', keterangan = '{$keterangan[$a]}', instruksi = '{$instruksi[$a]}'
									WHERE catatan_id = '{$catatID[$a]}' ";
					$queryUpdate = mysql_query($catatUpdate);
				}else{
					$catatInsert = "INSERT INTO b_catatan_pindah_ruang ( pesanan, keterangan, instruksi, serah_terima_id )
									VALUES ('{$pesanan[$a]}', '{$keterangan[$a]}', '{$instruksi[$a]}', '{$serah_terima_id}' )";
					$queryInsert = mysql_query($catatInsert);
				}
			}
			if($obatDelete != ''){
				$rsDelete2 = mysql_query("DELETE FROM b_obat_pindah_ruang WHERE obat_id IN ({$obatDelete})") or die (mysql_error());
			}else{
				
			}			
			for($a2 = 0; $a2 < count($rawID2); $a2++){
				if($obatID[$a2] != ''){
					$catatUpdate2 = "UPDATE b_obat_pindah_ruang
									SET nama_obat = '{$nama_obat[$a2]}', 
									dosis = '{$dosis[$a2]}',
									jumlah_obat = '{$jumlah_obat[$a2]}',
									sisa_obat = '{$sisa_obat[$a2]}'
									WHERE obat_id = '{$obatID[$a2]}' ";
					$queryUpdate2 = mysql_query($catatUpdate2);
				}else{
					$catatInsert2 = "INSERT INTO b_obat_pindah_ruang ( nama_obat, dosis, jumlah_obat,sisa_obat, serah_terima_id )
									VALUES ('{$nama_obat[$a2]}', '{$dosis[$a2]}', '{$jumlah_obat[$a2]}','{$sisa_obat[$a2]}', '{$serah_terima_id}' )";
					$queryInsert2 = mysql_query($catatInsert2);
				}
			}		
			
			$hasil = 1;
		}
	break;
}
if($hasil){
	echo "Sukses";
}else{
	echo "Gagal";
}
?>
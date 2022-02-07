<?php
include '../../koneksi/konek.php';
function getValue($a,$b){
	switch($a){
		case 'route': $n = 6; break;
		case 'sumber': $n = 5; break;
		case 'alat': $n = 3; break;
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
$act = $_REQUEST['actPajan'];

$tgl_pajan = explode('-',$_REQUEST['tgl_pajan']);
$tglPajan = $tgl_pajan[2]."-".$tgl_pajan[1]."-".$tgl_pajan[0]." ".$_REQUEST['jam_pajan'].":00";

$tgl_lap = explode('-',$_REQUEST['tgl_lap']);
$tglLap = $tgl_lap[2]."-".$tgl_lap[1]."-".$tgl_lap[0]." ".$_REQUEST['jam_lap'].":00";
$namaKorban = $_REQUEST['namaKorban'];
$kerjaKorban = $_REQUEST['kerjaKorban'];
$atasanKorban = $_REQUEST['atasanKorban'];
$tlpKorban = $_REQUEST['tlpKorban'];
$tempatKorban = $_REQUEST['tempatKorban'];
$tlpAtasan = $_REQUEST['tlpAtasan'];

$route = getValue('route',$_REQUEST['route']);

$sumber = getValue('sumber',$_REQUEST['sumber']);
$pecahSumber = explode(',',$sumber);
$textSumber = ($pecahSumber[4] == 1)?$_REQUEST['sumberTextLain']:'';

$textBagianTubuh = $_REQUEST['textBagianTubuh'];
$textKronologi = $_REQUEST['textKronologi'];
$imunisasi = $_REQUEST['imunisasi'];

$alat = getValue('alat',$_REQUEST['alat']);
$pecahAlat = explode(',',$alat);
$textAlat = ($pecahAlat[4] == 1)?$_REQUEST['pecahAlat']:'';

$tolong = $_REQUEST['tolong'];
$bahanInfeksi = $_REQUEST['bahanInfeksius'];
$antiHIV = $_REQUEST['textHIV'];
$hbsag = $_REQUEST['textHbsag'];
$antiHCV = $_REQUEST['textHCV'];

switch($act){
	case 'save':
		$sqlInsert = "INSERT INTO b_insiden_pajan 
					  (
						tgl_pajan, tgl_lap, 
						nama_korban, pekerjaan_korban, atasan_langsung, tlp_korban, tempat_kejadian, tlp_atasan,
						route_pajan, sumber_pajan, sumber_pajan_text,
						ket_pajan, kronologi_pajan,
						imun_pajan, pelindung, pelindung_text, tolong,
						bahan_infeksi, antiHIV, hbsag, antiHCV,
						pelayanan_id, kunjungan_id, tgl_act, user_act
					  ) VALUES (
						'{$tglPajan}', '{$tglLap}', 
						'{$namaKorban}', '{$kerjaKorban}', '{$atasanKorban}', '{$tlpKorban}', '{$tempatKorban}', '{$tlpAtasan}',
						'{$route}', '{$sumber}', '{$textSumber}', 
						'{$textBagianTubuh}', '{$textKronologi}',
						'{$imunisasi}', '{$alat}', '{$textAlat}', '{$tolong}',
						'{$bahanInfeksi}', '{$antiHIV}', '{$hbsag}', '{$antiHCV}',
						'{$idPel}', '{$idKunj}', NOW(), '{$idUser}'
					  )";
		$hasil = mysql_query($sqlInsert);
	break;
	case 'edit':
		
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>
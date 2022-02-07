<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_nama=addslashes($_REQUEST['txt_nama']);
	$rd_lp=addslashes($_REQUEST['rad_lp']);
	$txt_gpa=addslashes($_REQUEST['txt_gpa']);
	$txt_ditolong=addslashes($_REQUEST['txt_ditolong']);
	$tgl_ditolong=tglSQL($_REQUEST['tgl_ditolong']);
	$txt_berat=addslashes($_REQUEST['txt_berat']);
	$txt_panjang=addslashes($_REQUEST['txt_panjang']);
	$txt_kepala=addslashes($_REQUEST['txt_kepala']);
	$txt_dada=addslashes($_REQUEST['txt_dada']);
	$txt_apgar=addslashes($_REQUEST['txt_apgar']);
	$txt_kuning=addslashes($_REQUEST['txt_kuning']);
	$txt_lab=addslashes($_REQUEST['txt_lab']);
	$txt_golDarah=addslashes($_REQUEST['txt_golDarah']);
	$txt_hg=addslashes($_REQUEST['txt_hg']);
	$txt_g6pd=addslashes($_REQUEST['txt_g6pd']);
	$txt_t4=addslashes($_REQUEST['txt_t4']);
	$txt_xray=addslashes($_REQUEST['txt_xray']);
	$txt_terapi=addslashes($_REQUEST['txt_terapi']);
	$txt_susu=addslashes($_REQUEST['txt_susu']);
	$txt_berat_plg=addslashes($_REQUEST['txt_berat_plg']);
	$txt_rawat=addslashes($_REQUEST['txt_rawat']);
	$txt_terapi_lanjut=addslashes($_REQUEST['txt_terapi_lanjut']);
	$txt_diagnosa=addslashes($_REQUEST['txt_diagnosa']);
	$tgl_kontrol_kembali=tglSQL($_REQUEST['tgl_kontrol_kembali']);
	$idUsr=$_REQUEST['idUsr'];	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_neonatus_discharge (
  pelayanan_id,
  kunjungan_id,
  nama,
  sex,
  gpa,
  ditolong,
  tgl_ditolong,
  berat,
  panjang,
  lingkaran_kpl,
  lingkar_dada,
  apgar,
  kuning,
  data_lab,
  gol_darah,
  hg,
  g6pd,
  t4,
  xray,
  terapi,
  susu,
  berat_pulang,
  perawatan,
  terapi_lanjut,
  diagnosa,
  tgl_kembali,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$idKunj',
  '$txt_nama',
  '$rd_lp',
  '$txt_gpa',
  '$txt_ditolong',
  '$tgl_ditolong',
  '$txt_berat',
  '$txt_panjang',
  '$txt_kepala',
  '$txt_dada',
  '$txt_apgar',
  '$txt_kuning',
  '$txt_lab',
  '$txt_golDarah',
  '$txt_hg',
  '$txt_g6pd',
  '$txt_t4',
  '$txt_xray',
  '$txt_terapi',
  '$txt_susu',
  '$txt_berat_plg',
  '$txt_rawat',
  '$txt_terapi_lanjut',
  '$txt_diagnosa',
  '$tgl_kontrol_kembali',
  CURDATE(),
  '$idUsr') ;";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_neonatus_discharge SET pelayanan_id='$idPel',
  kunjungan_id= '$idKunj',
  nama='$txt_nama',
  sex='$rd_lp',
  gpa='$txt_gpa',
  ditolong='$txt_ditolong',
  tgl_ditolong='$tgl_ditolong',
  berat='$txt_berat',
  panjang='$txt_panjang',
  lingkaran_kpl='$txt_kepala',
  lingkar_dada='$txt_dada',
  apgar='$txt_apgar',
  kuning='$txt_kuning',
  data_lab='$txt_lab',
  gol_darah='$txt_golDarah',
  hg='$txt_hg',
  g6pd='$txt_g6pd',
  t4='$txt_t4',
  xray='$txt_xray',
  terapi='$txt_terapi',
  susu='$txt_susu',
  berat_pulang='$txt_berat_plg',
  perawatan='$txt_rawat',
  terapi_lanjut='$txt_terapi_lanjut',
  diagnosa='$txt_diagnosa',
  tgl_kembali='$tgl_kontrol_kembali',
  tgl_act= CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_fom_neonatus_discharge WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>
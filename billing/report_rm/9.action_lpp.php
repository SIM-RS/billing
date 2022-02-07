<?php
	include '../koneksi/konek.php';
	function satu($a,$b){
		switch($a){
			case 'PIRI': $n = 5;
						break;
			case 'KRK': $n = 5;
						break;
			case 'tatib': $n = 6;
						break;
			case 'fasilitas': $n = 3;
						break;
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
	
	$datetime = date("Y-m-d H:i:s");
	$act = $_REQUEST['act'];
	$idKunj = $_REQUEST['idKunj'];
	$idPel = $_REQUEST['idPel'];
	$inap = $_REQUEST['inap'];
	$idUser = $_REQUEST['idUser'];
	$idlist = $_REQUEST['idlist'];
	
	$sqlcek = "select * from b_list_terima_pasien where kunjungan_id = '$idKunj' AND pelayanan_id = '$idPel' AND id = $idlist";
	$cek = mysql_num_rows(mysql_query($sqlcek));
	
	$piri="";
	$tatib="";
	$KRK="";
	$fasilitas="";
	$piri = satu('PIRI',$_REQUEST['PIRI']);
	$tatib = satu('tatib',$_REQUEST['tatib']);
	$KRK = satu('KRK',$_REQUEST['KRK']);
	$houseping = ($_REQUEST['houseping']!=0)?'1':'0';
	$fasilitas = satu('fasilitas',$_REQUEST['fasilitas']);
	$jdw_mkn = ($_REQUEST['jdw_mkn']!=0)?'1':'0';

switch($act){
	case 'Save':
		if($cek != 1){
			$sql = "insert into b_list_terima_pasien values(NULL,'$idPel','$idKunj','$piri','$KRK','$tatib','$fasilitas','$houseping','$jdw_mkn','$datetime','$idUser')";
			$hasil = mysql_query($sql);
		}
	break;
	case 'Update':
		$sql = "update b_list_terima_pasien 
				set PIRI = '$piri',
					KRK = '$KRK',
					tatib = '$tatib',
					fasilitas = '$fasilitas',
					houseping = '$houseping',
					jdw_mkn = '$jdw_mkn',
					tgl_act = '$datetime',
					user_act = '$idUser'
				where id = $idlist AND pelayanan_id = '$idPel' AND kunjungan_id = '$idKunj'";
		$hasil = mysql_query($sql);		
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>
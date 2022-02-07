<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_noForm=addslashes($_REQUEST['txt_noForm']);
//	$penyakit='';
	
	$isi_chk=$_REQUEST['isi_chk'];	
	
	$idUsr=$_REQUEST['idUsr'];
	
/*	for($i=0;$i<=5;$i++){
		$penyakit.=$isi_chk[$i].',';
		}*/

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql="INSERT INTO b_form_radiologi_2 (
  pelayanan_id,
  kunjungan_id,
  no_formulir,
  isi,
  tgl_act,
  user_act
) 
VALUES
  (
    '$idPel',
    '$idKunj',
	'$txt_noForm',
	'$isi_chk[0],$isi_chk[1],$isi_chk[2],$isi_chk[3],$isi_chk[4],$isi_chk[5],$isi_chk[6],$isi_chk[7],$isi_chk[8],$isi_chk[9],$isi_chk[10],$isi_chk[11],$isi_chk[12],$isi_chk[13],$isi_chk[14],$isi_chk[15],$isi_chk[16],$isi_chk[17],$isi_chk[18],$isi_chk[19],$isi_chk[20],$isi_chk[21],$isi_chk[22],$isi_chk[23],$isi_chk[24],$isi_chk[25],$isi_chk[26],$isi_chk[27],$isi_chk[28],$isi_chk[29],$isi_chk[30],$isi_chk[31],$isi_chk[32],$isi_chk[33],$isi_chk[34],$isi_chk[35],$isi_chk[36],$isi_chk[37],$isi_chk[38],$isi_chk[39],$isi_chk[40],$isi_chk[41],$isi_chk[42],$isi_chk[43],$isi_chk[44],$isi_chk[45],$isi_chk[46],$isi_chk[47],$isi_chk[48],$isi_chk[49],$isi_chk[50]',
    CURDATE(),
    '$idUsr'
  );
";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				echo mysql_error();
				}
	break;
	case 'edit':
		$sql="UPDATE b_form_radiologi_2 SET
	pelayanan_id='$idPel',
  kunjungan_id='$idKunj', 
  no_formulir='$txt_noForm',
  isi='$isi_chk[0],$isi_chk[1],$isi_chk[2],$isi_chk[3],$isi_chk[4],$isi_chk[5],$isi_chk[6],$isi_chk[7],$isi_chk[8],$isi_chk[9],$isi_chk[10],$isi_chk[11],$isi_chk[12],$isi_chk[13],$isi_chk[14],$isi_chk[15],$isi_chk[16],$isi_chk[17],$isi_chk[18],$isi_chk[19],$isi_chk[20],$isi_chk[21],$isi_chk[22],$isi_chk[23],$isi_chk[24],$isi_chk[25],$isi_chk[26],$isi_chk[27],$isi_chk[28],$isi_chk[29],$isi_chk[30],$isi_chk[31],$isi_chk[32],$isi_chk[33],$isi_chk[34],$isi_chk[35],$isi_chk[36],$isi_chk[37],$isi_chk[38],$isi_chk[39],$isi_chk[40],$isi_chk[41],$isi_chk[42],$isi_chk[43],$isi_chk[44],$isi_chk[45],$isi_chk[46],$isi_chk[47],$isi_chk[48],$isi_chk[49],$isi_chk[50]',
  tgl_act=CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_form_radiologi_2 WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>
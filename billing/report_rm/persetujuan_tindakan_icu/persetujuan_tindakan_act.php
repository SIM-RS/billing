<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$name=$_REQUEST['name'];
	$age=$_REQUEST['age'];
	$adress=$_REQUEST['adress'];
	$tindakan=$_REQUEST['tindakan'];
	$terhadap=$_REQUEST['terhadap'];
	$alternatif1=$_REQUEST['alternatif1'];
	$alternatif2=$_REQUEST['alternatif2'];
	$alternatif3=$_REQUEST['alternatif3'];
	$idUser=$_REQUEST['idUser'];	
	//echo count();
	$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_persetujuan_tind_icu (
  pelayanan_id,
  name,
  age,
  jenis_kelamin,
  adress,
  tindakan,
  terhadap,
  alternatif1,
  alternatif2,
  alternatif3,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$name',
  '$age',
  '$radio[0]',
  '$adress',
  '$tindakan',
  '$terhadap',
  '$alternatif1',
  '$alternatif2',
  '$alternatif3',
  CURDATE(),
  '$idUser') ;";
  //echo $sql;
		$ex=mysql_query($sql);
		
		if($ex){	
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_persetujuan_tind_icu SET pelayanan_id='$idPel',
  name='$name',
  age='$age',
  jenis_kelamin='$radio[0]',
  adress='$adress',
  tindakan='$tindakan',
  terhadap='$terhadap',
  alternatif1='$alternatif1',
  alternatif2='$alternatif2',
  alternatif3='$alternatif3',
  tgl_act= CURDATE(),
  user_act='$idUser' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil diupdate !";
		}
		else
		{
			echo "Data gagal diupdate !";
		}
	break;
	case 'hapus':
		$sql="DELETE FROM b_persetujuan_tind_icu WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil dihapus !";
		}
		else
		{
			echo "Data gagal dihapus !";
		}
	break;
		
}
?>
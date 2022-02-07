<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$hari=$_REQUEST['hari'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$istirahat=$_REQUEST['istirahat'];
	$tgl_mulai=tglSQL($_REQUEST['tgl_mulai']);
	$tgl_akhir=tglSQL($_REQUEST['tgl_akhir']);
	$inap=$_REQUEST['inap'];
	$tgl_mulai2=tglSQL($_REQUEST['tgl_mulai2']);
	$tgl_akhir2=tglSQL($_REQUEST['tgl_akhir2']);
	$tgl_per=tglSQL($_REQUEST['tgl_per']);
	$note=$_REQUEST['note'];
	$idUser=$_REQUEST['idUser'];	
	//echo count();
	//$radio=$_REQUEST['radio'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_surat_ket_dokter (
  pelayanan_id,
  hari,
  tgl,
  istirahat,
  tgl_mulai,
  tgl_akhir,
  inap,
  tgl_mulai2,
  tgl_akhir2,
  tgl_per,
  note,
  pilihan,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$hari',
  '$tgl',
  '$istirahat',
  '$tgl_mulai',
  '$tgl_akhir',
  '$inap',
  '$tgl_mulai2',
  '$tgl_akhir2',
  '$tgl_per',
  '$note',
  '".substr($pilihan,0,-1)."',
  CURDATE(),
  '$idUser') ;";
		$ex=mysql_query($sql);
		if($ex){	
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_surat_ket_dokter SET pelayanan_id='$idPel',
  hari='$hari',
  tgl='$tgl',
  istirahat='$istirahat',
  tgl_mulai='$tgl_mulai',
  tgl_akhir='$tgl_akhir',
  inap='$inap',
  tgl_mulai2='$tgl_akhir2',
  tgl_akhir2='$tgl_akhir2',
  tgl_per='$tgl_per',
  note='$note',
  pilihan='$pilihan',
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
		$sql="DELETE FROM b_surat_ket_dokter WHERE id='".$_REQUEST['id']."'";
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
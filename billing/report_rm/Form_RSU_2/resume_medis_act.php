<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_anjuran=addslashes($_REQUEST['txt_anjuran']);
	$txt_obat=$_REQUEST['txt_obat'];
	$txt_jumlah=$_REQUEST['txt_jumlah'];
	$txt_dosis=$_REQUEST['txt_dosis'];
	$txt_frek=$_REQUEST['txt_frek'];
	$txt_beri=$_REQUEST['txt_beri'];
	$txt_jam1=$_REQUEST['txt_jam1'];
	$txt_jam2=$_REQUEST['txt_jam2'];
	$txt_jam3=$_REQUEST['txt_jam3'];
	$txt_jam4=$_REQUEST['txt_jam4'];
	$txt_jam5=$_REQUEST['txt_jam5'];
	$txt_jam6=$_REQUEST['txt_jam6'];
	$txt_petunjuk=$_REQUEST['txt_petunjuk'];
	$idUsr=$_REQUEST['idUsr'];
	$jns=$_REQUEST['jns'];	
	//echo count();
	
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_resum_medis (
  pelayanan_id,
  kunjungan_id,
  anjuran,
  tgl_act,
  user_act,
  jns
) 
VALUES
  (
  '$idPel',
  '$idKunj',
  '$txt_anjuran',
  CURDATE(),
  '$idUsr',
  '$jns') ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($txt_obat as $key){
				 $sqlD="INSERT INTO b_fom_resum_medis_detail(resum_medis_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('$idx','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
				mysql_query($sqlD);
				$i++;
				}
			//echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_resum_medis SET pelayanan_id='$idPel',
  kunjungan_id= '$idKunj',
  anjuran='$txt_anjuran',
  tgl_act= CURDATE(),
  user_act='$idUsr',
  jns='$jns' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_fom_resum_medis_detail where resum_medis_id='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($txt_obat as $key){
				$sqlD="INSERT INTO b_fom_resum_medis_detail(resum_medis_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('".$_REQUEST['txtId']."','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from b_fom_resum_medis_detail where resum_medis_id='".$_REQUEST['txtId']."'");
		
		if($exx){
			$sql="DELETE FROM b_fom_resum_medis WHERE id='".$_REQUEST['txtId']."'";
			$ex=mysql_query($sql);
			if($ex){
				echo "Data berhasil dihapus !";
				
				}else{
				echo "Data gagal dihapus !";
				}
			
			}else{
				
				}
	break;
		
}
?>
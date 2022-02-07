<?php
include("../inc/koneksi.php");
switch(strtolower($_REQUEST['act']))
{
  case 'tambah':
	$sqlCek = "select * from rspelindo_billing.b_ms_pegawai_unit where unit_id='".$_REQUEST['id']."' and ms_pegawai_id='".$_REQUEST['idPeg']."'";
	$rsCek = mysql_query($sqlCek);
	if(mysql_num_rows($rsCek)==0)
	{
	  $sqlTambah = "INSERT INTO rspelindo_billing.b_ms_pegawai_unit (ms_pegawai_id,unit_id) values('".$_REQUEST['idPeg']."','".$_REQUEST['id']."')";
	  $rs=mysql_query($sqlTambah);
	  $res = mysql_affected_rows();
	  echo "Data sukses ditambah";
	}
  break;
	   
  case 'hapus':
  $sqlHapus="delete from rspelindo_billing.b_ms_pegawai_unit where ms_pegawai_id='".$_REQUEST['idPeg']."' and unit_id = '".$_REQUEST['id']."'";
  $rs=mysql_query($sqlHapus);
  $res = mysql_affected_rows();
  echo "Data sukses dihapus";
  break;   
}
?>
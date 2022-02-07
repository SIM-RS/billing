<?
include "../inc/koneksi.php";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$obat_id=$_REQUEST['obat_id'];
$obat_kode=$_REQUEST['obat_kode'];
$obat_nama=$_REQUEST['obat_nama'];
$pabrik_id=$_REQUEST['pabrik_id'];
$obat_dosis=$_REQUEST['obat_dosis'];
$obat_satuan_besar=$_REQUEST['obat_satuan_besar'];
$obat_satuan_kecil=$_REQUEST['obat_satuan_kecil'];
$isi_satuan_kecil=$_REQUEST['isi_satuan_kecil'];
$obat_bentuk=$_REQUEST['obat_bentuk'];
$kls_id=$_REQUEST['kls_id'];
$obat_kategori=$_REQUEST['obat_kategori'];
$obat_golongan=$_REQUEST['obat_golongan'];
$habis_pakai=$_REQUEST['habis_pakai'];
$jenis_obat=$_REQUEST['jenis_obat'];
$kode_paten=$_REQUEST['kode_paten'];
$id_paten=$_REQUEST['id_paten'];if ($id_paten=="") $id_paten="0";
$obat_isaktif=$_REQUEST['obat_isaktif'];

$act=$_REQUEST['act2']; // Jenis Aksi ==================================
//echo $act;
switch ($act){
	case "save":
			$sql="insert into ms_barang (kodebarang,namabarang,tipebarang,tipe,PABRIK_ID,OBAT_DOSIS,OBAT_SATUAN_BESAR,OBAT_SATUAN_KECIL,ISI_SATUAN_KECIL,OBAT_BENTUK,KLS_ID,OBAT_KATEGORI,OBAT_KELOMPOK,OBAT_GOLONGAN,HABIS_PAKAI,ID_PATEN,KODE_PATEN,isbrg_aktif) values('$obat_kode','$obat_nama','F','3','$pabrik_id','$obat_dosis','$obat_satuan_besar','$obat_satuan_kecil','$isi_satuan_kecil','$obat_bentuk',$kls_id,$obat_kategori,$jenis_obat,'$obat_golongan',$habis_pakai,'$id_paten','$kode_paten',$obat_isaktif)";
			//echo $sql;
			$rs=mysql_query($sql);
		break;
	case "edit":
			$sql="update ms_barang set kodebarang='$obat_kode',namabarang='$obat_nama',PABRIK_ID='$pabrik_id',OBAT_DOSIS='$obat_dosis',OBAT_SATUAN_BESAR='$obat_satuan_besar',OBAT_SATUAN_KECIL='$obat_satuan_kecil',ISI_SATUAN_KECIL='$isi_satuan_kecil',OBAT_BENTUK='$obat_bentuk',KLS_ID=$kls_id,OBAT_KATEGORI=$obat_kategori,OBAT_KELOMPOK=$jenis_obat, OBAT_GOLONGAN='$obat_golongan',HABIS_PAKAI=$habis_pakai,ID_PATEN='$id_paten',KODE_PATEN='$kode_paten',isbrg_aktif=$obat_isaktif where idbarang=$obat_id";
			//echo $sql;
			$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="delete from ms_barang where idbarang=$obat_id";
		$rs=mysql_query($sql);
		//echo $sql;
		break;
}
?>
<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
       

  $nama = mysql_real_escape_string($_POST['nama']);
  $jenis_kelamin = mysql_real_escape_string($_POST['jenis_kelamin']);
  $umur = mysql_real_escape_string($_POST['umur']);
  $ruangan = mysql_real_escape_string($_POST['ruangan']);
    $nama_penasihat = mysql_real_escape_string($_POST['nama_penasihat']);
      $nama_organisasi = mysql_real_escape_string($_POST['nama_organisasi']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_pelayanan_kegiatan_rohani VALUES('','$nama','$jenis_kelamin','$umur','$ruangan','$nama_penasihat','$nama_organisasi','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);

    if ($querytambah) {
        # code redicet setelah insert ke index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");

    }
    else{
        echo "ERROR, tidak berhasil". mysql_error($koneksi);
    }
}
elseif($_GET['act']=='update'){
  $id = mysql_real_escape_string($_POST['id']);
  $barang = mysql_real_escape_string($_POST['barang']);
  $jumlah = mysql_real_escape_string($_POST['jumlah']);
  $kondisi = mysql_real_escape_string($_POST['kondisi']);
  $tgl_titip = mysql_real_escape_string($_POST['tgl_titip']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
  $tgl_serah = date('m/d/yy');
  var_dump($_POST);
    //query update
    $queryupdate = mysql_query("UPDATE rm_pelayanan_kegiatan_rohani SET barang='$barang',jumlah='$jumlah',kondisi_barang='$kondisi' WHERE id='$id' AND id_pasien='$idPasien'",$konek);

    if ($queryupdate) {
        # credirect ke page index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien"); 
    }
    else{
        echo "ERROR, data gagal diupdate". mysql_error($koneksi);
    }
}
elseif ($_GET['act'] == 'delete'){
    $id = mysql_real_escape_string($_GET['id']);
  $idKunj = mysql_real_escape_string($_GET['idKunj']);
  $idPel = mysql_real_escape_string($_GET['idPel']);
  $idPasien = mysql_real_escape_string($_GET['idPasien']);
    //query hapus
    $querydelete = mysql_query("DELETE FROM rm_pelayanan_kegiatan_rohani  WHERE id='$id'",$konek);

    if ($querydelete) {
        # redirect ke index.php
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($koneksi);
    }

    mysqli_close($koneksi);
}

?>
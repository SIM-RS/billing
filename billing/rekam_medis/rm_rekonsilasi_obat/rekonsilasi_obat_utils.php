<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
     

  $tanggal = mysql_real_escape_string($_POST['tanggal']);
  $nama_obat = mysql_real_escape_string($_POST['nama_obat']);
  $jumlah = mysql_real_escape_string($_POST['jumlah']);
  $dosis = mysql_real_escape_string($_POST['dosis']);
  $rute = mysql_real_escape_string($_POST['rute']);
  $nama_pengguna = mysql_real_escape_string($_POST['nama_pengguna']);
  $tindak_lanjut = mysql_real_escape_string($_POST['tindak_lanjut']);
    $perubahan_aturan_pakai = mysql_real_escape_string($_POST['perubahan_aturan_pakai']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_rekonsilasi_obat VALUES('','$tanggal','$nama_obat','$jumlah','$dosis','$rute','$nama_pengguna','$tindak_lanjut','$perubahan_aturan_pakai','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);

    if ($querytambah) {
        # code redicet setelah insert ke index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");

    }
    else{
        echo "ERROR, tidak berhasil". mysql_error($konek);
    }
}
elseif($_GET['act']=='update'){

  $id = mysql_real_escape_string($_POST['id']);
  $tanggal = mysql_real_escape_string($_POST['tanggal']);
  $nama_obat = mysql_real_escape_string($_POST['nama_obat']);
  $jumlah = mysql_real_escape_string($_POST['jumlah']);
  $dosis = mysql_real_escape_string($_POST['dosis']);
  $rute = mysql_real_escape_string($_POST['rute']);
  $nama_pengguna = mysql_real_escape_string($_POST['nama_pengguna']);
  $tindak_lanjut = mysql_real_escape_string($_POST['tindak_lanjut']);
    $perubahan_aturan_pakai = mysql_real_escape_string($_POST['perubahan_aturan_pakai']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
    //query update
    $queryupdate = mysql_query("UPDATE rm_rekonsilasi_obat  SET 
      tanggal='$tanggal',
      nama_obat='$nama_obat',
      jumlah='$jumlah',
      dosis='$dosis',
      rute='$rute',
      nama_pengguna='$nama_pengguna',
      tindak_lanjut='$tindak_lanjut',
      perubahan_aturan_pakai='$perubahan_aturan_pakai' WHERE id='$id' AND id_pasien='$idPasien'",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_rekonsilasi_obat   WHERE id='$id'",$konek);

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
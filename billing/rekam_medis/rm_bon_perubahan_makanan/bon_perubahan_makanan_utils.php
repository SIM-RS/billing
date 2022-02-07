<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
       
  $nama_pasien = mysql_real_escape_string($_POST['nama_pasien']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);
  $ruang = mysql_real_escape_string($_POST['ruang']);
  $jenis_diet = mysql_real_escape_string($_POST['jenis_diet']);
   $diagnosa = mysql_real_escape_string($_POST['diagnosa']);
    $dpjp = mysql_real_escape_string($_POST['dpjp']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
   $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_bon_perubahan_makanan VALUES('','$nama_pasien','$no_rm','$ruang','$jenis_diet','$diagnosa','$dpjp','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);
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
  $nama_pasien = mysql_real_escape_string($_POST['nama_pasien']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);
  $ruang = mysql_real_escape_string($_POST['ruang']);
  $jenis_diet = mysql_real_escape_string($_POST['jenis_diet']);
   $diagnosa = mysql_real_escape_string($_POST['diagnosa']);
    $dpjp = mysql_real_escape_string($_POST['dpjp']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
   $idpegawai = mysql_real_escape_string($_POST['userId']);
    //query update
    $queryupdate = mysql_query("UPDATE rm_bon_perubahan_makanan SET nama_pasien='$nama_pasien',no_rm='$no_rm',ruang='$ruang',jenis_diet='$jenis_diet',diagnosa='$diagnosa',dpjp='$dpjp' WHERE id='$id'",$konek);

    if ($queryupdate) {
        # credirect ke page index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien"); 
    }
    else{
        echo "ERROR, data gagal diupdate". mysql_error($koneksi);
    }
}
elseif ($_GET['act'] == 'delete'){
    $id = $_GET['id'];
  $idKunj = $_GET['idKunj'];
  $idPel = $_GET['idPel'];
  $idPasien = $_GET['idPasien'];
    //query hapus
    $querydelete = mysql_query("DELETE FROM rm_bon_perubahan_makanan  WHERE id='$id'",$konek);

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
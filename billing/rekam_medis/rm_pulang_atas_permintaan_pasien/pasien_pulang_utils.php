<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
      
 
  $nama = mysql_real_escape_string($_POST['nama']);
  $tgl_lahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);
  $ruang = mysql_real_escape_string($_POST['ruang']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_pasien_pulang VALUES('','$nama','$tgl_lahir','$no_rm','$ruang','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);

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
  $nama = mysql_real_escape_string($_POST['nama']);
  $tgl_lahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);
  $ruang = mysql_real_escape_string($_POST['ruang']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
    //query update
    $queryupdate = mysql_query("UPDATE rm_pasien_pulang SET nama='$nama',tgl_lahir='$tgl_lahir',no_rm='$no_rm',ruang='$ruang' WHERE id='$id' ",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_pasien_pulang  WHERE id='$id'",$konek);

    if ($querydelete) {
        # redirect ke index.php
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($koneksi);
    }

    mysqli_close($koneksi);
}
elseif ($_GET['act'] == 'serah'){
    $id = $_REQUEST['id'];
  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $tgl_serah = date('m/d/yy');
    //query hapus
    $querydelete = mysql_query("UPDATE rm_pasien_pulang SET tgl_serah='$tgl_serah'  WHERE id='$id' AND id_kunjungan='$idKunj' AND id_pelayanan='$idPel' AND id_pasien='$idPasien' ",$konek);

    if ($querydelete) {
        # redirect ke index.php
         header("location:cetakBarang_pasien.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
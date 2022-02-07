<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
      

  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $tanggal = date('d-m-yy');
  $asuhan = mysql_real_escape_string($_POST['asuhan']);
  $hasil_asesmen = mysql_real_escape_string($_POST['hasil_asesmen']);
  $instruksi = mysql_real_escape_string($_POST['instruksi']);
  $verifikasi_dpjp = mysql_real_escape_string($_POST['verifikasi_dpjp']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
 
 
      $querytambah = mysql_query("INSERT INTO rm_catatan_pasien_terintegrasi VALUES('','$ruangan','$tanggal','$asuhan','$hasil_asesmen','$instruksi','$verifikasi_dpjp','$idKunj','$idPel','$idPasien')",$konek);

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
  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $tanggal = date('d-m-yy');
  $asuhan = mysql_real_escape_string($_POST['asuhan']);
  $hasil_asesmen = mysql_real_escape_string($_POST['hasil_asesmen']);
  $instruksi = mysql_real_escape_string($_POST['instruksi']);
  $verifikasi_dpjp = mysql_real_escape_string($_POST['verifikasi_dpjp']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
 
  
    //query update
    $queryupdate = mysql_query("UPDATE rm_catatan_pasien_terintegrasi SET ruangan='$ruangan',asuhan='$asuhan',hasil_asesmen='$hasil_asesmen',instruksi='$instruksi',verifikasi_dpjp='$verifikasi_dpjp' WHERE id='$id'",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_catatan_pasien_terintegrasi  WHERE id='$id'",$konek);

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
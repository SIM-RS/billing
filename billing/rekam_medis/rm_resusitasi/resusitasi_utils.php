<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
       

  $namaPasien = mysql_real_escape_string($_POST['nama_pasien']);
  $tglLahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $umur = mysql_real_escape_string($_POST['umur']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
   $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_resusitasi VALUES('','$namaPasien','$tglLahir','$umur','$no_rm','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);

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
  $namaPasien = mysql_real_escape_string($_POST['nama_pasien']);
  $tglLahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $umur = mysql_real_escape_string($_POST['umur']);
  $no_rm = mysql_real_escape_string($_POST['no_rm']);

  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
   $idpegawai = mysql_real_escape_string($_POST['userId']);
    //query update
    $queryupdate = mysql_query("UPDATE rm_resusitasi SET nama_pasien='$namaPasien',tgl_lahir='$tglLahir',umur='$umur',no_rm='$no_rm' WHERE id='$id'",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_resusitasi  WHERE id='$id'",$konek);

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
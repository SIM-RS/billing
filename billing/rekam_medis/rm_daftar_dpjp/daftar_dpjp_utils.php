<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
     

  $diagnosa = mysql_real_escape_string($_POST['diagnosa']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $tgl_mulai = mysql_real_escape_string($_POST['tgl_mulai']);
  $tgl_akhir = mysql_real_escape_string($_POST['tgl_akhir']);
  $keterangan = mysql_real_escape_string($_POST['keterangan']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
 
 
      $querytambah = mysql_query("INSERT INTO rm_dpjp VALUES('','$diagnosa','$nama_dokter','$tgl_mulai','$tgl_akhir','$keterangan','$idKunj','$idPel','$idPasien', NULL)",$konek);

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
  $diagnosa = mysql_real_escape_string($_POST['diagnosa']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $tgl_mulai = mysql_real_escape_string($_POST['tgl_mulai']);
  $tgl_akhir = mysql_real_escape_string($_POST['tgl_akhir']);
  $keterangan = mysql_real_escape_string($_POST['keterangan']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  var_dump($_POST);
    //query update
    $queryupdate = mysql_query("UPDATE rm_dpjp SET diagnosa='$diagnosa',nama_dokter='$nama_dokter',tgl_mulai='$tgl_mulai',tgl_akhir='$tgl_akhir' WHERE id='$id'",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_dpjp  WHERE id='$id'",$konek);

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
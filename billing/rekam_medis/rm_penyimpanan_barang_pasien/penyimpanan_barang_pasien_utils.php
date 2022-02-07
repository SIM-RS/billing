<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
  
  $barang = mysql_real_escape_string($_POST['barang']);
  $jumlah = mysql_real_escape_string($_POST['jumlah']);
  $kondisi = mysql_real_escape_string($_POST['kondisi']);
  $tgl_titip = mysql_real_escape_string($_POST['tgl_titip']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_barang_pasien VALUES('','$barang','$jumlah','$kondisi','$tgl_titip','','$idKunj','$idPel','$idPasien','$idpegawai', NULL)",$konek);

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
    $queryupdate = mysql_query("UPDATE rm_barang_pasien SET barang='$barang',jumlah='$jumlah',kondisi_barang='$kondisi' WHERE id='$id' AND id_pasien='$idPasien'",$konek);

    if ($queryupdate) {
        # credirect ke page index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien"); 
    }
    else{
        echo "ERROR, data gagal diupdate". mysql_error($konek);
    }
}
elseif ($_GET['act'] == 'delete'){
    $id = mysql_real_escape_string($_GET['id']);
  $idKunj = mysql_real_escape_string($_GET['idKunj']);
  $idPel = mysql_real_escape_string($_GET['idPel']);
  $idPasien = mysql_real_escape_string($_GET['idPasien']);
    //query hapus
    $querydelete = mysql_query("DELETE FROM rm_barang_pasien  WHERE id='$id'",$konek);

    if ($querydelete) {
        # redirect ke index.php
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($konek);
    }

    mysqli_close($konek);
}
elseif ($_GET['act'] == 'serah'){
    $id = mysql_real_escape_string($_REQUEST['id']);
  $idKunj = mysql_real_escape_string($_REQUEST['idKunj']);
  $idPel = mysql_real_escape_string($_REQUEST['idPel']);
  $idPasien = mysql_real_escape_string($_REQUEST['idPasien']);
  $tgl_serah = date('m/d/yy');
    //query hapus
    $querydelete = mysql_query("UPDATE rm_barang_pasien SET tgl_serah='$tgl_serah'  WHERE id='$id' AND id_kunjungan='$idKunj' AND id_pelayanan='$idPel' AND id_pasien='$idPasien' ",$konek);

    if ($querydelete) {
        # redirect ke index.php
         header("location:cetakBarang_pasien.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($konek);
    }

    mysqli_close($konek);
}
?>
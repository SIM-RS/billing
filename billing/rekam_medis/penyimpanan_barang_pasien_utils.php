<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambahuser'){
        $aksi = $_REQUEST['aksi'];
  $id = $_GET['id'];
  $barang = $_POST['barang'];
  $jumlah = $_POST['jumlah'];
  $kondisi = $_POST['kondisi'];
  $tgl_titip = $_POST['tgl_titip'];
  $idKunj = $_POST['idKunj'];
  $idPel = $_POST['idPel'];
  $idPasien = $_POST['idPasien'];
  $idpegawai = $_SESSION['userId'];
  $tgl_serah = date('mm/dd/yy');
      $querytambah = mysql_query("INSERT INTO rm_barang_pasien VALUES('','$barang','$jumlah','$kondisi','$tgl_titip','$tgl_serah','$idKunj','$idPel','$idPasien','$idpegawai')",$konek);

    if ($querytambah) {
        # code redicet setelah insert ke index
        header("location:RM_penyimpanan_barang_pasien_31.php");
    }
    else{
        echo "ERROR, tidak berhasil". mysql_error($koneksi);
    }
}
elseif($_GET['act']=='updateuser'){
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    //query update
    $queryupdate = mysqli_query("UPDATE tb_user SET username='$username' , password='$password' , user_role='$role' WHERE id_user='$id_user' ",$konek);

    if ($queryupdate) {
        # credirect ke page index
        header("location:RM_penyimpanan_barang_pasien_31.php");    
    }
    else{
        echo "ERROR, data gagal diupdate". mysql_error($koneksi);
    }
}
elseif ($_GET['act'] == 'deleteuser'){
    $id_user = $_GET['id'];

    //query hapus
    $querydelete = mysql_query("DELETE FROM rm_barang_pasien  WHERE id='$id_user'",$konek);

    if ($querydelete) {
        # redirect ke index.php
        header("location:RM_penyimpanan_barang_pasien_31.php");
    }
    else{
        echo "ERROR, data gagal dihapus". mysql_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
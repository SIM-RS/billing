<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
   $tanggal = date('m/d/yy');
  $namaPasien = mysql_real_escape_string($_POST['nama_pasien']);
  $tgl_lahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $medicalRecord = mysql_real_escape_string($_POST['medical_record']);
  $nomorKamar = mysql_real_escape_string($_POST['no_kamar']);
  $jenisDiet = mysql_real_escape_string($_POST['jenis_diet']);
  $keteranganDiet = mysql_real_escape_string($_POST['keterangan_diet']);
  $waktuMakan = mysql_real_escape_string($_POST['waktu_makan']);
  $menu = mysql_real_escape_string($_POST['menu']);
  $buah = mysql_real_escape_string($_POST['buah']);
  $keterangan = mysql_real_escape_string($_POST['keterangan']);
  $accnutrisionis = mysql_real_escape_string($_POST['accnutrisionis']);
  // GET DATA ID KUNJUNGAN,PELAYANAN DAN PASIEN
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_pesanan_menu_harian VALUES(
        '',
        '$tanggal',
        '$namaPasien',
        '$tgl_lahir',
        '$medicalRecord',
        '$nomorKamar',
        '$jenisDiet',
        '$keteranganDiet',
        '$waktuMakan',
        '$menu',
        '$buah',
        '$keterangan',
        '$accnutrisionis',
        '$idKunj',
        '$idPel',
        '$idPasien',
        NULL)",$konek);

    if ($querytambah) {
        # code redicet setelah insert ke index
     header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");

    }
    else{
        echo "ERROR, tidak berhasil". mysql_error($koneksi);
    }
}
elseif($_GET['act']=='update'){
  $id = $_POST['id'];
  $tanggal = date('m/d/yy');
  $namaPasien = mysql_real_escape_string($_POST['nama_pasien']);
  $tgl_lahir = mysql_real_escape_string($_POST['tgl_lahir']);
  $medicalRecord = mysql_real_escape_string($_POST['medical_record']);
  $nomorKamar = mysql_real_escape_string($_POST['no_kamar']);
  $jenisDiet = mysql_real_escape_string($_POST['jenis_diet']);
  $keteranganDiet = mysql_real_escape_string($_POST['keterangan_diet']);
  $waktuMakan = mysql_real_escape_string($_POST['waktu_makan']);
  $menu = mysql_real_escape_string($_POST['menu']);
  $buah = mysql_real_escape_string($_POST['buah']);
  $keterangan = mysql_real_escape_string($_POST['keterangan']);
  $accnutrisionis = mysql_real_escape_string($_POST['accnutrisionis']);
  // GET DATA ID KUNJUNGAN,PELAYANAN DAN PASIEN
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
  
    //query update
    $queryupdate = mysql_query("UPDATE rm_pesanan_menu_harian SET 
     nama_pasien='$namaPasien',
    tgl_lahir='$tgl_lahir',
    medical_record='$medicalRecord',
     no_kamar='$nomorKamar',
     jenis_diet='$jenisDiet',
     keterangan_diet='$keteranganDiet',
     waktu_makan='$waktuMakan',
     menu='$menu',
     buah='$buah',
     keterangan='$keterangan',
     accnutrisionis='$accnutrisionis'
     WHERE id='$id' AND id_pasien='$idPasien'
      ",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_pesanan_menu_harian  WHERE id='$id'",$konek);

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
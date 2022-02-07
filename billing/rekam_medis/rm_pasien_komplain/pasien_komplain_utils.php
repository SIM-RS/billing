<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
       
  $id = mysql_real_escape_string($_GET['id']);
  $nama = mysql_real_escape_string($_POST['nama']);
  $unit_rawat = mysql_real_escape_string($_POST['unit_rawat']);
  $hal = mysql_real_escape_string($_POST['hal']);
  $keluhan = mysql_real_escape_string($_POST['keluhan']);
    $pertanyaan= mysql_real_escape_string($_POST['pertanyaan']);
      $saran = mysql_real_escape_string($_POST['saran']);
         $tanggal = date('d-m-yy');
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
 
      $querytambah = mysql_query("INSERT INTO rm_pasien_komplain VALUES('','$nama','$unit_rawat','$hal','$keluhan','$pertanyaan','$saran','$tanggal','$idKunj','$idPel','$idPasien','$idpegawai', NULL)");

    if ($querytambah) {
        # code redicet setelah insert ke index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");

    }
    else{
        echo "ERROR, tidak berhasil";
    }
}
elseif($_GET['act']=='update'){
   
  $id = mysql_real_escape_string($_POST['id']);
  $nama = mysql_real_escape_string($_POST['nama']);
  $unit_rawat = mysql_real_escape_string($_POST['unit_rawat']);
  $hal = mysql_real_escape_string($_POST['hal']);
  $keluhan = mysql_real_escape_string($_POST['keluhan']);
    $pertanyaan= mysql_real_escape_string($_POST['pertanyaan']);
      $saran = mysql_real_escape_string($_POST['saran']);
         $tanggal = date('d-m-yy');
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
  $idpegawai = mysql_real_escape_string($_POST['userId']);
    //query update
    $queryupdate = mysql_query("UPDATE rm_pasien_komplain SET 
      nama='$nama',
      unit_rawat='$unit_rawat',
      hal='$hal',
      keluhan='$keluhan',
      pertanyaan='$pertanyaan',
      saran='$saran'
     WHERE id='$id' ",$konek);


    if ($queryupdate) {
        # credirect ke page index
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien"); 
    }
    else{
        echo "ERROR, data gagal diupdate";
    }
}
elseif ($_GET['act'] == 'delete'){
    $id = mysql_real_escape_string($_GET['id']);
  $idKunj = mysql_real_escape_string($_GET['idKunj']);
  $idPel = mysql_real_escape_string($_GET['idPel']);
  $idPasien = mysql_real_escape_string($_GET['idPasien']);
    //query hapus
    $querydelete = mysql_query("DELETE FROM rm_pasien_komplain  WHERE id='$id'",$konek);

    if ($querydelete) {
        # redirect ke index.php
          header("location:index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien");
    }
    else{
        echo "ERROR, data gagal dihapus";
    }

    mysqli_close($koneksi);
}

?>
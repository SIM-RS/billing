<?php
         $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);


if($_GET['act']== 'tambah'){
     

  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $tanggal = date('d-m-yy h:i:s:a');
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $timming_tindakan = mysql_real_escape_string($_POST['timming_tindakan']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $rencana_tindakan = mysql_real_escape_string($_POST['rencana_tindakan']);
  $prosedur_tindakan = mysql_real_escape_string($_POST['prosedur_tindakan']);
  $alternatif_lain = mysql_real_escape_string($_POST['alternatif_lain']);
  $kompilasi = mysql_real_escape_string($_POST['kompilasi']);
  $pemantauan_tindakan = mysql_real_escape_string($_POST['pemantauan_tindakan']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
     $idpegawai = mysql_real_escape_string($_POST['userId']);
 
 
      $querytambah = mysql_query("INSERT INTO rm_asesmen_pra_operasi VALUES(
        '',
        '$ruangan',
        '$diagnosis',
        '$timming_tindakan',
        '$indikasi_tindakan',
        '$rencana_tindakan',
        '$prosedur_tindakan',
        '$alternatif_lain',
        '$kompilasi',
        '$pemantauan_tindakan',
        '$tanggal',
        '$idKunj',
        '$idPel',
        '$idPasien',
        '$idpegawai')",$konek);

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
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $timming_tindakan = mysql_real_escape_string($_POST['timming_tindakan']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $rencana_tindakan = mysql_real_escape_string($_POST['rencana_tindakan']);
  $prosedur_tindakan = mysql_real_escape_string($_POST['prosedur_tindakan']);
  $alternatif_lain = mysql_real_escape_string($_POST['alternatif_lain']);
  $kompilasi = mysql_real_escape_string($_POST['kompilasi']);
  $pemantauan_tindakan = mysql_real_escape_string($_POST['pemantauan_tindakan']);
  $idKunj = mysql_real_escape_string($_POST['idKunj']);
  $idPel = mysql_real_escape_string($_POST['idPel']);
  $idPasien = mysql_real_escape_string($_POST['idPasien']);
     $idpegawai = mysql_real_escape_string($_POST['userId']);
  
    //query update
    $queryupdate = mysql_query("UPDATE rm_asesmen_pra_operasi SET 
      ruangan='$ruangan',
      diagnosis='$diagnosis',
      timming_tindakan='$timming_tindakan',
      indikasi_tindakan='$indikasi_tindakan',
        rencana_tindakan='$rencana_tindakan',
          prosedur_tindakan='$prosedur_tindakan',
            alternatif_lain='$alternatif_lain',
              kompilasi='$kompilasi',
                pemantauan_tindakan='$pemantauan_tindakan'
      
       WHERE id='$id'",$konek);

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
    $querydelete = mysql_query("DELETE FROM rm_asesmen_pra_operasi  WHERE id='$id'",$konek);

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
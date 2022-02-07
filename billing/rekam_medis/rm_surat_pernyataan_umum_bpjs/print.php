<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> SURAT PERYATAAN UMUM</title>
  <link rel="icon" href="../favicon.png">
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
  <script src="../js/jquery-3.5.1.slim.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>
  <link rel="icon" href="../favicon.png">
  <script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
  <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
  <style type="text/css">
    @media print {
      #print {
        display: none;
      }
    }
  </style>
    <script src="../html2pdf/ppdf.js"></script>
</head>


<body>
  <div id="pdf-area" style=" width: 920px;  margin: auto;">


    <?php

    $qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='" . $idPasien . "' ";
    $rsPasien = mysql_query($qPasien);
    $rwPasien = mysql_fetch_array($rsPasien);
    ?>
    <img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


    <div class="box-pasien" style="float: right; padding-right: 0px;">
      <p align='right' style="margin: 0px;">RM3/PHCM</p>
      <table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="2">

        <tr>
          <td class="noline" style="font:12 sans-serif bolder;">
            <b> NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $rwPasien['nama']; ?></b>
          </td>
          <td class="noline"></td>
          <td class="noline">&nbsp;</td>
          <td class="noline">&nbsp;</td>
        </tr>
        <tr>
          <td class="noline" style="font:12 sans-serif bolder;">
            <b>Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwPasien['sex']; ?> </b>
          </td>
          <td class="noline"></td>
          <td class="noline">&nbsp;</td>
          <td class="noline">&nbsp;</td>
        </tr>
        <tr>
          <td class="noline" style="font:12 sans-serif bolder;">
            <b> No.RM &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $rwPasien['no_rm']; ?></b>
          </td>
          <td class="noline"></td>
          <td class="noline">&nbsp;</td>
          <td class="noline">&nbsp;</td>
        </tr>

      </table>
    </div>
    <br>

    <hr style=" margin:0px; padding:0px; margin-top:17px;">
    <hr style="border: 1px solid black; margin:0px; padding:0px; margin-top:2px;">

    <br>
    <center>
      <h5>SURAT PERYATAAN UMUM</h5>
    </center>

    <div class='container'>

      <p>
        Saya yang bertandatangan di bawah ini :
      </p>
      <p>
        Nama : <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['nama'];
                  }
                }
                ?>
      </p>
      <p>
        Umur : <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['umur'];
                  }
                }
                ?>
      </p>
      <p>
        Alamat : <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['alamat'];
                    }
                  }
                  ?>
      </p>
      <p>
        No. HP :
        <?php
        $getone = GetOne($_REQUEST['id']);
        if (isset($getone)) {
          foreach ($getone as $data) {

            echo $data['no_hp'];
          }
        }
        ?>
      </p>
      <p>
        Hubungan :
        <?php
        $getone = GetOne($_REQUEST['id']);
        if (isset($getone)) {
          foreach ($getone as $data) {

            echo $data['hubungan'];
          }
        }
        ?>
      </p>
      <p>
        Benar menyatakan pasien yang beridentitas sebagai berikut :
      </p>
      <p>
        Nama :<?php echo $rwPasien['nama']; ?>
      </p>
      <p>
        Umur :<?php $lahir    = new DateTime($rwPasien['tgl_lahir']);
              $today        = new DateTime();
              $umur = $today->diff($lahir);
              echo $umur->y;
              echo " Tahun"
              ?>
      </p>
      <p>
        Alamat : <?php echo $rwPasien['alamat']; ?>
      </p>
      <p>
        Diagnosa : <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['diagnosa_pasien'];
                      }
                    }
                    ?>
      </p>
      <p>
        Adalah
      </p>
      <p>
        1. Benar pasien umum
      </p>
      <p>
        2. Bersedia menanggung seluruh biaya perobatan selama dirawat di Rumah
        Sakit PHCM.
      </p>
      <p>
        3. Tidak akan beralih biaya penanggungan kepada Asuransi lain baik itu
        BPJS/KIS selama masih dalam perawatan.
      </p>
      <p>
        Demikian surat pernytaan ini saya perbuat dengan benar dan tanpa paksaan.
      </p>
      <div style="float: right; margin-right: 50px;">
        Belawan,<?= date('d/m/yy'); ?>
      </div>
      <br>
      <center>
        <table cellpadding="10">
          <tr align="center">
            <td> Petugas Registrasi</td>
            <td> Case Manager</td>
            <td>Yang Membuat Pernyataan,</td>
          </tr>

          <tr align="center">
            <td>(<?= $_SESSION['pegawai_nama'] ?>)</td>
            <td>( <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['case_manager'];
                    }
                  }
                  ?> )</td>
            <td>(<?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['nama'];
                    }
                  }
                  ?> )</td>
          </tr>
        </table>
      </center>
      <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR> <BR>

      <p>
        Saya yang bertandatangan di bawah ini :
      </p>
      <p>
        Nama : <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['nama'];
                  }
                }
                ?>
      </p>
      <p>
        Umur : <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['umur'];
                  }
                }
                ?>
      </p>
      <p>
        Alamat : <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['alamat'];
                    }
                  }
                  ?>
      </p>
      <p>
        No. HP :
        <?php
        $getone = GetOne($_REQUEST['id']);
        if (isset($getone)) {
          foreach ($getone as $data) {

            echo $data['no_hp'];
          }
        }
        ?>
      </p>
      <p>
        Hubungan :
        <?php
        $getone = GetOne($_REQUEST['id']);
        if (isset($getone)) {
          foreach ($getone as $data) {

            echo $data['hubungan'];
          }
        }
        ?>
      </p>
      <p>
        Benar menyatakan pasien yang beridentitas sebagai berikut :
      </p>
      <p>
        Nama :<?php echo $rwPasien['nama']; ?>
      </p>
      <p>
        Umur : <?php $lahir    = new DateTime($rwPasien['tgl_lahir']);
                $today        = new DateTime();
                $umur = $today->diff($lahir);
                echo $umur->y;
                echo " Tahun"
                ?>
      </p>
      <p>
        Alamat : <?php echo $rwPasien['alamat']; ?>
      </p>
      <p>
        Diagnosa : <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['diagnosa_pasien'];
                      }
                    }
                    ?>
      </p>
      <p>
        Adalah
      </p>

      <p>1. Berencana untuk mengurus kelengkapan berkas peserta BPJS Kesehatan ( ASKES, Jamkesmas, BPJS Mandiri, ASABRI, KIS ) .</p>
      <p>2. Apabila dalam kurun waktu 3x24 jam tidak dapat menunjukkan kelengkapan BPJS kesehatan yang aktif atau dirujuk kerumah sakit yang lain atau meninggal dunia atau dinyatakan boleh pulang oleh dokter yang merawat. Maka pasien tersebut diatas bersedia untuk menjadi pasien umum . </p>
      <p>3. Saat beralih menjadi pasien umum maka kami bersedia menanggung seluruh biaya pengobatan sesuai dengan ketentuan Rumah Sakit Prima Husada Cipta Medan.</p>

      <div style="float: right; margin-right: 50px;">
        Belawan,<?= date('d/m/yy'); ?>
      </div>
      <br>
      <center>
        <table cellpadding="10">
          <tr align="center">
            <td> Petugas Registrasi</td>
            <td> Case Manager</td>
            <td>Yang Membuat Pernyataan,</td>
          </tr>

          <tr align="center">
            <td>(<?= $_SESSION['pegawai_nama'] ?>)</td>
            <td>( <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['case_manager'];
                    }
                  }
                  ?> )</td>
            <td>(<?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['nama'];
                    }
                  }
                  ?> )</td>
          </tr>
        </table>
      </center>
    </div>
    </div>

      <center>
        <div class='btn-group'>
        <button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
          <a id='print' href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
        </div>
      </center>
    </div>


<script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 3 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
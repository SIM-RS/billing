<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PERSETUJUAN UMUM (GENERAL CONSENT)</title>
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
  <div id="pdf-area" style=" width: 1000px;  margin: auto;">


    <?php

    $qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.telp,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
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
      <p align='right' style="margin: 0px;">RM2/PHCM</p>
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


    <hr style="border: 2px solid black; margin:0px; padding:0px; margin-top:17px;">
    <hr style=" margin:0px; padding:0px; margin-top:2px;">


    <p align="center">

      <strong><u>PERSETUJUAN UMUM (<em>GENERAL CONSENT</em>)</u></strong>
      <strong></strong>
    </p>

    <center>
      <div style="text-align:justify; margin-left: 200px; margin-right: 200px;">

        <p>
          <strong>INDETITAS PASIEN</strong>
        </p>
        <p>
          <strong>NamaPasien :<?php echo $rwPasien['nama']; ?></strong>
        </p>
        <p>
          <strong>Nomor Rekam Medik : <?php echo $rwPasien['no_rm']; ?></strong>
        </p>
        <p>
          <strong>TanggaLahir : <?php echo $rwPasien['tgl_lahir']; ?></strong>
        </p>
        <p>
          <strong>Alamat : <?php echo $rwPasien['alamat']; ?></strong>
        </p>

        <p>
          <strong>No Telp : <?php echo $rwPasien['telp']; ?></strong>
          <strong></strong>
        </p>
        <p>
          <strong>PASIEN DAN/ATAU WALI HUKUM HARUS MEMBACA, MEMAHAMI, </strong>
        </p>
        <p>
          <strong>DAN MENGISI INFORMASI BERIKUT :</strong>
        </p>
        <p>
          Yang bertandatangan dibawah ini :
        </p>
        <p>
          Nama : <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {
                      echo  $data['nama'];
                    }
                  }
                  ?>
        </p>
        <p>
          Alamat : <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {
                        echo  $data['alamat'];
                      }
                    }
                    ?>
        </p>
        <p>
          Hubungan pasien : <?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {
                                echo  $data['hubungan_pasien'];
                              }
                            }
                            ?>
        </p>
        <p>
          walihukum yang sah, ……………) *<sup>coret yang tidakperlu</sup>
        </p>
        <p>
          No Telp : <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {
                        echo  $data['no_telp'];
                      }
                    }
                    ?>
        </p>
        <p>
          No Identitas : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {
                              echo  $data['no_identitas'];
                            }
                          }
                          ?>
        </p>
        <p>
          Selaku pasien/walihukum di RS Prima Husada Cipta Medan dengan ini
          menyatakan persetujuannya :
        </p>
        <p>
          <strong>I. </strong>
          <strong>PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</strong>
        </p>
        <p>
          <em><u>Saya/keluarga menyetujui </u></em>
          untuk perawatan di Rumah Sakit Prima Husada Cipta Medan sebagai pasien
          rawat jalan atau rawat inap tergantung kepada kebutuhan medis. Pengobatan
          dapat meliputi atau salah satunya saja pemeriksaan konsultasi dokter,
          pemeriksaan x-ray/radiologi, tes laboratorium, dan pengobatan lainnya
          tergantung kepada kebutuhan medis.
        </p>
        <p>
          Persetujuan yang saya/keluarga berikan tidak termasuk persetujuan untuk
          prosedur / tindakan invasive (misalnya operasi) atau tindakan yang
          mempunyai resiko tinggi.
        </p>
        <p>
          Jika saya/keluarga memutuskan untuk menghentikan pengobatan medis untuk
          diri saya sendiri,
          <em>
            <u>
              saya/keluarga memahami dan menyadari bahwa Rumah Sakit Prima Husada
              Cipta Medan atau dokter tidak bertanggung jawab atas hasil yang
              merugikan saya/keluarga.
            </u>
          </em>
          <em><u></u></em>
        </p>
        <p>
          <strong>II. </strong>
          <strong>PERSETUJUAN PELEPASAN INFORMASI</strong>
        </p>
        <p>
          Saya/keluarga memahami informasi yang ada didalam diri saya, termasuk
          Diagnosis, hasil Laboratorium, dan hasil tes Diagnostik lainnya yang akan
          digunakan untuk perawatan dan pengobatan medis, akan dijamin kerahasiaannya
          oleh Rumah Sakit Prima Husada Cipta Medan.
        </p>
        <p>
          Saya/keluarga memberi wewenang kepada rumah sakit untuk memberikan
          informasi tentang diagnosis, hasil pelayanan dan pengobatan bila diperlukan
          untuk memperoses klaim asuransi/ perusahaan/ dan atau lembaga pemerintah.
        </p>
        <p>
          Saya/keluarga memberi wewenang kepada rumah sakit untuk memberikan
          informasi tentang diagnosis, hasil pelayanan dan pengobatan kepada anggota
          keluarga kandung saya dan keadaan:
        </p>
        <p>
          <?php
          $getone = GetOne($_REQUEST['id']);
          if (isset($getone)) {
            foreach ($getone as $data) {
              echo  $data['hasil_diagnosis'];
            }
          }
          ?>
        </p>

        <p>
          <strong>III. </strong>
          <strong>HAK DAN TANGGUNG JAWAB PASIEN</strong>
        </p>
        <p>
          Saya/keluarga memiliki hak untuk mengambil bagian dalam keputusan mengenai
          penyakit saya dan dalam hal perawatan medis dan rencana pengobatan.
        </p>
        <p>
          Saya/keluarga telah mendapat informasi tentang “Hak danTanggung Jawab
          Pasien” di Rumah Sakit Prima Husada Cipta Medan melalui lembaran double
          print/ leaflet dan banner yang disediakan oleh rumah sakit.
        </p>
        <p>
          Saya/keluarga memahami bahwa Rumah Sakit Prima Husada Cipta Medan tidak
          bertanggung jawab atas kehilangan barang – barang pribadi dan barang
          berharga yang dibawa ke Rumah Sakit.
        </p>
        <p>
          <strong>IV. </strong>
          <strong>INFORMASI RAWAT INAP</strong>
        </p>
        <p>
          1. Saya/keluarga tidak diperkenankan untuk membawa barang – barang berharga
          keruang rawat inap.
        </p>
        <p>
          2. Saya/keluarga telah menerima informasi tentang peraturan yang
          diberlakukan oleh rumah sakit dan saya beserta keluarga bersedia
          mematuhinya.
        </p>
        <p>
          3. Mematuhi jam kunjungan yang telah ditetapkan oleh pihak rumah sakit.
        </p>
        <p>
          4. Saya/keluarga saya yang mengantar tidak akan merokok di area lingkungan
          rumah sakit.
        </p>
        <p>
          5. Setiap keluarga saya berkunjung bersedia untuk diminta diperiksa oleh
          pihak rumah sakit.
        </p>
        <p>
          <strong>V. </strong>
          <strong>PRIVASI</strong>
        </p>
        <p>
          Saya/keluarga mengijinkan / tidak mengijinkan<sup>*coretsalahsatu</sup>
          memberi akses kepada keluarga dan handai taulan beserta orang – orang yang
          akan menengok saya (sebutkan namanya jika ada permintaan khusus):
          <br>
          <br>
          ……………………………………………………………………………
        </p>
        <p>
          <strong>VI. </strong>
          <strong>INFORMASI BIAYA</strong>
        </p>
        <p>
          Saya/keluarga memahami tentang informasi biaya pengobatan atau biaya
          tindakan yang dijelaskan oleh petugas Rumah Sakit Prima HusadaCipta Medan
        </p>
        <p align="center">
          TANDA TANGAN
        </p>
        <p>
          Dengan tanda tangan saya/keluarga dibawah ini saya/keluarga menyatakan
          bahwa saya/keluarga telah membaca dan memahami point – point pada
          Persetujuan Umum (<em>General Consent</em>).
        </p>
        <p>
          Medan, <?= date('d/m/yy') ?>
        </p>
        <br><br><br><br>
        <p style="float:left;">
          ( <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {
                      echo  $data['nama'];
                    }
                  }
                  ?> )
          <br> <br>
          Nama dan Tanda Tangan<br>&nbsp;&nbsp;&nbsp;&nbsp;Pasien/Keluarga
        </p>

        <p style="float:right;">
          ( <?= $_SESSION['pegawai_nama']?> )
          <br> <br>
          Nama dan Tanda Tangan<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Petugas Admisi
        </p>



      </div>
    </center>
    
  </div>
  </div>
<BR>
    <BR>
    <BR>
    <BR>
    <BR>
    <BR>
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
            filename: "RM 2 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>

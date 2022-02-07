<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> CHECK LIST KESIAPAN ANESTESI</title>
  <link rel="icon" href="../favicon.png">
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
  <script src="../js/jquery-3.5.1.slim.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>

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
  <div id="pdf-area" style=" width: 210mm;  margin: auto;">

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
      <p align='right' style="margin: 0px;;">RM 21.11/PHCM</p>
      <table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="4">

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
            <b>Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
              <?php echo $rwPasien['sex']; ?> </b>
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

    <hr style=" margin:0px; padding:0px; margin-top:23px;">
    <hr style="border: 1px solid black; margin:0px; padding:0px; margin-top:2px;">
    <br>
    <center>
      <table border="1" cellspacing="0" cellpadding="0" width="820">
        <tbody>
          <tr>
            <td width="633" colspan="2" valign="top">
              <p align="center">
                <strong>CHECK LIST KESIAPAN ANESTESI</strong>
              </p>
            </td>
          </tr>
          <tr>
            <td width="302" valign="top">
              <p>
                <strong>Ruangan : </strong>
                <?php


                $getone = GetOne($_REQUEST['id']);

                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['ruangan'];
                  }
                }
                ?>

              </p>
            </td>
            <td width="331" valign="top">
              <p>
                <strong>Tgl : </strong><?= date('d/m/yy'); ?>&nbsp;&nbsp;
                <strong>Jam :</strong><?= date('h:i:s'); ?>

              </p>

            </td>
          </tr>
          <tr>
            <td width="302" valign="top">
              <p>
                <strong>Diagnosis :</strong>
                <?php


                $getone = GetOne($_REQUEST['id']);

                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['diagnosis'];
                  }
                }
                ?>
              </p>

            </td>
            <td width="331" valign="top">
              <p>
                <strong>Jenis Operasi :</strong>
                <?php


                $getone = GetOne($_REQUEST['id']);

                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['jenis_operasi'];
                  }
                }
                ?>
              </p>
            </td>
          </tr>
          <tr>
            <td width="302" valign="top">
              <p>
                <strong>Teknik Anesthesi :</strong>
                <?php


                $getone = GetOne($_REQUEST['id']);

                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['teknik_anesthesi'];
                  }
                }
                ?>
              </p>

            </td>
            <td width="331" valign="top">
              <p>
                <strong>Tgl. Tindakan :</strong>
                <?php


                $getone = GetOne($_REQUEST['id']);

                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['tgl_tindakan'];
                  }
                }
                ?>
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </center>
    <center>
      <div style="text-align: left; margin-left : %;">
        <p>
          <strong>Listrik</strong>
        </p>
        <p>

          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' name='listrik' checked readonly>
" . $data['listrik'];
            }
          }
          ?>
        </p>
        <p>
          <strong>Gas Medis</strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' name='gas_medis' checked readonly>
 " . $data['gas_medis'];
            }
          }
          ?>
        </p>


        <p>
          <strong>Mesin Anestesia</strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' name='mesin_anestesia' checked readonly>
 " . $data['mesin_anestesia'];
            }
          }
          ?>
        </p>

        <p>
          <strong>Manajemen Jalan Nafas</strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' name='manajemen_jalan_nafas' checked readonly>
 " . $data['manajemen_jalan_nafas'];
            }
          }
          ?>
        </p>

        <p>
          <strong>Pemantauan </strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' checked readonly>
 " . $data['pemantauan'];
            }
          }
          ?>
        </p>

        <p>
          <strong>Lain-lain </strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox'  checked readonly>
 " . $data['lain_lain'];
            }
          }
          ?>
        </p>

        <p>
          <strong>Obat-obat</strong>
        </p>
        <p>
          <?php


          $getone = GetOne($_REQUEST['id']);

          if (isset($getone)) {
            foreach ($getone as $data) {

              echo "<input type='checkbox' name='listrik' checked readonly>
 " . $data['obat_obat'];
            }
          }
          ?>
        </p>

        <p>
          <input type="checkbox">Lain-lain :.................................................
          ................................................
        </p>

        <div style="margin-right: 55%;">

          <p align="right">
            .................................................
            ................................................
          </p>
          <p align="right">
            .................................................
            ................................................
          </p>
          <p align="right">
            .................................................
            ................................................
          </p>
          <p align="right">
            .................................................
            ................................................
          </p>
          <p align="right">
            .................................................
            ................................................
          </p>
        </div>
        <p>
          Pemeriksa
        </p>
        <p>
          Penata Anasthesi &nbsp;&nbsp;&nbsp;&nbsp; : <?php


                                                      $getone = GetOne($_REQUEST['id']);

                                                      if (isset($getone)) {
                                                        foreach ($getone as $data) {

                                                          echo $data['penata_anesthesi'];
                                                        }
                                                      }
                                                      ?>&nbsp;&nbsp;&nbsp;&nbsp;Tanda
          tangan.................................
        </p>
        <p>
          Dr. Ahli Anesthesi &nbsp;&nbsp;&nbsp;&nbsp; : <?php


                                                        $getone = GetOne($_REQUEST['id']);

                                                        if (isset($getone)) {
                                                          foreach ($getone as $data) {

                                                            echo $data['dr_ahli_anesthesi'];
                                                          }
                                                        }
                                                        ?>&nbsp;&nbsp;&nbsp;&nbsp;Tanda
          tangan...............................
        </p>
      </div>
      <br clear="all" />
  </div>
  </div>
  </div>

  <div class='container'>

    <BR>
    <center>
      <div class='' btn-group'>
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
            filename: "RM 21.11 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
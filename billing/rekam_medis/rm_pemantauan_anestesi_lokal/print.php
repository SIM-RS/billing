<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    PEMANTAUAN ANESTESI LOKAL
  </title>
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
      <p align='right' style="margin: 0px;">RM21.7/PHCM</p>
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
    <center>
      <br>
      <center>
        <h5>PEMANTAUAN ANESTESI LOKAL</h5>
      </center>

      <div class='container'>




        <table border="1" cellspacing="0" cellpadding="5" width="680">
          <tbody>
            <div style="border: 1px solid black; max-width: 680px; text-align: left; padding-left: 25px; padding: 5px;">


              <strong>
                PRA BEDAH
              </strong>

            </div>

            <tr>
              <td width="680" colspan="2" valign="top">
                <p>
                  Tanggal tindakan: <?php
                                    $getone = GetOne($_REQUEST['id']);
                                    if (isset($getone)) {
                                      foreach ($getone as $data) {

                                        echo $data['tanggal_tindakan'];
                                      }
                                    }
                                    ?>


                </p>
                <p>
                  Diagnosa :
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['diagnosa'];
                    }
                  }
                  ?>

                </p>
                <p>
                  Nama tindakan:
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['nama_tindakan'];
                    }
                  }
                  ?>

                </p>
                <p>
                  Pembedah :
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['pembedah'];
                    }
                  }
                  ?>

                </p>
                <p>
                  Ruangan / Poli :
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['ruang_poli'];
                    }
                  }
                  ?>

                </p>
              </td>
            </tr>
            <tr>
              <td width="338" valign="top">
                <p>
                  RIWAYAT PENYAKIT/ OPERASI
                </p>
                <ul>
                  <li>
                    <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['riwayat_penyakit'];
                      }
                    }
                    ?>

                  </li>


                </ul>


              </td>
              <td width="342" valign="top">

                RIWAYAT ALERGI: Ada/tidak ada (jika ada sebutkan)

                <ul>
                  <li>
                    <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['riwayat_alergi'];
                      }
                    }
                    ?>
                  </li>

                </ul>
              </td>
            </tr>
          </tbody>
        </table>
        <table border="1" cellspacing="0" cellpadding="5" width="680">
          <tbody>
            <div style="border: 1px solid black; max-width: 680px; text-align: left; padding-left: 25px; padding: 5px;">


              <strong>
                PEMANTAUAN STATUS
                FISIOLOGIS
              </strong>

            </div>
            <tr>
              <td width="47">
                <p>
                  Tgl/ Jam
                </p>
              </td>
              <td width="96">
                <p>
                  Kesadaran
                </p>
              </td>
              <td width="55">
                <p>
                  TD
                </p>
              </td>
              <td width="57">
                <p>
                  Nadi
                </p>
              </td>
              <td width="81" colspan="2">
                <p>
                  Respirasi
                </p>
              </td>
              <td width="57">
                <p>
                  Suhu
                </p>
              </td>
              <td width="86">
                <p>
                  Obat-obatan
                </p>
              </td>
              <td width="81">
                <p>
                  Cairan
                </p>
              </td>
              <td width="121" colspan="2">
                <p>
                  Keterangan
                </p>
              </td>
            </tr>
            <tr>
              <td width="47" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {
                    echo $data['tanggal'] . "<br>";
                    echo $data['jam'];
                  }
                }
                ?>
              </td>
              <td width="96" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['kesadaran'];
                  }
                }
                ?>
              </td>
              <td width="55" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['td'];
                  }
                }
                ?>
              </td>
              <td width="57" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['nadi'];
                  }
                }
                ?>
              </td>
              <td width="81" colspan="2" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['respirasi'];
                  }
                }
                ?>
              </td>
              <td width="57" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['suhu'];
                  }
                }
                ?>
              </td>
              <td width="86" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['obat_obatan'];
                  }
                }
                ?>
              </td>
              <td width="81" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['cairan'];
                  }
                }
                ?>
              </td>
              <td width="121" colspan="2" valign="top">
                <?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['keterangan'];
                  }
                }
                ?>
              </td>
            </tr>

            <tr>
              <td width="680" colspan="11">
                <p>
                  <strong>PASKAH BEDAH</strong>

                </p>
              </td>
            </tr>
            <tr>
              <td width="329" colspan="5" valign="top">

                <ul>

                  <li>
                    Kesadaran : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo $data['paska_bedah_kesadaran'];
                                  }
                                }
                                ?>
                  </li>

                  <li>
                    Tekanan darah :
                    <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['paska_bedah_tekanan_darah'];
                      }
                    }
                    ?>
                  </li>

                  <li>
                    Nadi : <?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo $data['paska_bedah_kesadaran'];
                              }
                            }
                            ?>
                  </li>
                  <li>
                    Respirasi :
                    <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['paska_bedah_respirasi'];
                      }
                    }
                    ?>
                  </li>

                  <li>
                    Suhu : <?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo $data['paska_bedah_suhu'];
                              }
                            }
                            ?>

                  </li>



                </ul>


              </td>
              <td width="30" colspan="5" valign="top">
                <ul>
                  <li>
                    Reaksi alergi :
                    <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo $data['paska_bedah_reaksi_alergi'];
                      }
                    }
                    ?>
                  </li>
                  <li>
                    Komplikasi lain (jika ada): <?php
                                                $getone = GetOne($_REQUEST['id']);
                                                if (isset($getone)) {
                                                  foreach ($getone as $data) {

                                                    echo $data['komplikasi_lain'];
                                                  }
                                                }
                                                ?>
                  </li>
                </ul>
              </td>
              <td width="2">
              </td>
            </tr>

          </tbody>
        </table>
        <table cellpadding="20" width="500">
          <tr align="center">
            <td style=""> Pembuat Laporan </td>


            <td> Pembedah </td>
          </tr>
          <tr align="center">
            <td>(<?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo $data['pembuat_laporan'];
                    }
                  }
                  ?>)
            </td>



            <td>
              (<?php
                $getone = GetOne($_REQUEST['id']);
                if (isset($getone)) {
                  foreach ($getone as $data) {

                    echo $data['pembedah'];
                  }
                }
                ?>)
            </td>
          </tr>
        </table>
      </div>
      </div>



        <BR> <BR>
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
            filename: "RM 21.7 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
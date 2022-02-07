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
    LAPORAN OPERASI
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
      <p align='right' style="margin: 0px;">RM21.14/PHCM</p>
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
        <h5>
          LAPORAN OPERASI
        </h5>
        <br>
      </center>

      <div class='container'>





        <table border="1" cellspacing="0" cellpadding="4" width="896">
          <tbody>
            <tr>
              <td width="716" colspan="5" valign="top">
                <p>
                  Ruang Operasi : <?php
                                  $getone = GetOne($_REQUEST['id']);
                                  if (isset($getone)) {
                                    foreach ($getone as $data) {

                                      echo  $data['ruang_operasi'];
                                    }
                                  }
                                  ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Kamar : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {

                              echo  $data['kamar'];
                            }
                          }
                          ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="716" colspan="5" valign="top">
                <p>
                  Akut / Terencana : <?php
                                      $getone = GetOne($_REQUEST['id']);
                                      if (isset($getone)) {
                                        foreach ($getone as $data) {

                                          echo  $data['akut_terencana'];
                                        }
                                      }
                                      ?>
                  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Tanggal : <?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo  $data['tanggal'];
                              }
                            }
                            ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Pukul : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {

                              echo  $data['pukul'];
                            }
                          }
                          ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="283" valign="top">
                <p>
                  Pembedah : <?php
                              $getone = GetOne($_REQUEST['id']);
                              if (isset($getone)) {
                                foreach ($getone as $data) {

                                  echo  $data['pembedah'];
                                }
                              }
                              ?>
                </p>
                <p>
                  Ahli Anestesi : <?php
                                  $getone = GetOne($_REQUEST['id']);
                                  if (isset($getone)) {
                                    foreach ($getone as $data) {

                                      echo  $data['ahli_anestesi'];
                                    }
                                  }
                                  ?>
                </p>
              </td>
              <td width="172" colspan="2" valign="top">
                <p>
                  Asisten I : <?php
                              $getone = GetOne($_REQUEST['id']);
                              if (isset($getone)) {
                                foreach ($getone as $data) {

                                  echo  $data['asisten_1'];
                                }
                              }
                              ?>
                </p>
                <p>
                  Asisten II : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['asisten_2'];
                                  }
                                }
                                ?>
                </p>
                <p>
                  Perawat instrument :
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['perawat_instrument'];
                    }
                  }
                  ?>
                </p>
              </td>
              <td width="261" colspan="2" valign="top">
                <p>
                  Jenis Anestesi :
                </p>
                <p>
                  <input type="checkbox" required checked>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['jenis_anestesi'];
                    }
                  }
                  ?>
                </p>

              </td>
            </tr>
            <tr>
              <td width="342" colspan="2" valign="top">
                <p>
                  Diagnosa Pra-bedah : <?php
                                        $getone = GetOne($_REQUEST['id']);
                                        if (isset($getone)) {
                                          foreach ($getone as $data) {

                                            echo  $data['diagnosa_pra_bedah'];
                                          }
                                        }
                                        ?>
                </p>
              </td>
              <td width="374" colspan="3" valign="top">
                <p>
                  Indikasi operasi : <?php
                                      $getone = GetOne($_REQUEST['id']);
                                      if (isset($getone)) {
                                        foreach ($getone as $data) {

                                          echo  $data['indikasi_operasi'];
                                        }
                                      }
                                      ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="342" colspan="2" valign="top">
                <p>
                  Diagnosa Pasca-bedah : <?php
                                          $getone = GetOne($_REQUEST['id']);
                                          if (isset($getone)) {
                                            foreach ($getone as $data) {

                                              echo  $data['diagnosa_pasca_bedah'];
                                            }
                                          }
                                          ?>
                </p>
              </td>
              <td width="374" colspan="3" valign="top">
                <p>
                  Nama Operasi : <?php
                                  $getone = GetOne($_REQUEST['id']);
                                  if (isset($getone)) {
                                    foreach ($getone as $data) {

                                      echo  $data['nama_operasi'];
                                    }
                                  }
                                  ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="342" colspan="2" valign="top">
                <p>
                  Desinfeksi kulit dengan :
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['desinfeksi_kulit_dengan'];
                    }
                  }
                  ?>
                </p>
              </td>
              <td width="374" colspan="3" valign="top">
                <p>
                  Jaringan yang dieksisi : <?php
                                            $getone = GetOne($_REQUEST['id']);
                                            if (isset($getone)) {
                                              foreach ($getone as $data) {

                                                echo  $data['jaringan_dieksisi'];
                                              }
                                            }
                                            ?>
                </p>
                <p>

                  Dikirim ke Bagian Patologi Anatomi: <input type="checkbox" required checked> <?php
                                                                                                $getone = GetOne($_REQUEST['id']);
                                                                                                if (isset($getone)) {
                                                                                                  foreach ($getone as $data) {

                                                                                                    echo  $data['dikirim_patologi_anatomi'];
                                                                                                  }
                                                                                                }
                                                                                                ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="342" colspan="2" valign="top">
                <p>
                  Jam Operasi Jam Operasi
                </p>
                <p>
                  Dimulai : <?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo  $data['jam_operasi_dimulai'];
                              }
                            }
                            ?> Selesai : <?php
                                          $getone = GetOne($_REQUEST['id']);
                                          if (isset($getone)) {
                                            foreach ($getone as $data) {

                                              echo  $data['jam_operasi_selesai'];
                                            }
                                          }
                                          ?>
                </p>
              </td>
              <td width="119" colspan="2" valign="top">
                <p>
                  Lama operasi
                </p>
                <p>
                  berlangsung : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['lama_operasi_langsung'];
                                  }
                                }
                                ?>
                </p>
              </td>
              <td width="254" valign="top">
                <p>
                  Jenis bahan : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['jenis_bahan'];
                                  }
                                }
                                ?>
                </p>
                <p>
                  Yang dikirim ke laboratorium
                </p>
                <p>
                  Untuk pemeriksaan :
                </p>
                <p>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['pemeriksaan_laboratorium'];
                    }
                  }
                  ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="342" colspan="2" valign="top">
                <p>
                  Macam sayatan (bila perlu dengan gambar)
                </p>
                <p> <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo  $data['macam_sayatan'];
                      }
                    }
                    ?></p>
              </td>
              <td width="374" colspan="3" valign="top">
                <p>
                  Posisi Penderita (bila perlu dengan gambar)
                </p>
                <p> <?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo  $data['posisi_penderita'];
                      }
                    }
                    ?></p>
              </td>
            </tr>
            <tr>
              <td width="716" colspan="5" valign="top">
                <p>
                  Teknik Operasi dan Temuan Intra-Operasi
                </p>
                <p>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['teknik_operasi'];
                    }
                  }
                  ?>
                </p>
                <p>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['temuan_intra_operasi'];
                    }
                  }
                  ?>
                </p>

              </td>
            </tr>
          </tbody>
        </table>
        <table border="1" cellspacing="0" cellpadding="4" width="896">
          <tbody>
            <tr>
              <td width="716" colspan="3" valign="top">
                <p>
                  Penggunaan AMHP Khusus : <input type="checkbox" required checked> <?php
                                                                                    $getone = GetOne($_REQUEST['id']);
                                                                                    if (isset($getone)) {
                                                                                      foreach ($getone as $data) {

                                                                                        echo  $data['penggunaan_amhp_khusus'];
                                                                                      }
                                                                                    }
                                                                                    ?>
                </p>
                <p>
                  Jenis dan jumlah (AMHP Khusus) : <?php
                                                    $getone = GetOne($_REQUEST['id']);
                                                    if (isset($getone)) {
                                                      foreach ($getone as $data) {

                                                        echo  $data['jenis_amhp_khusus'];
                                                      }
                                                    }
                                                    ?>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['jumlah_amhp_khusus'];
                    }
                  }
                  ?>
                </p>
              </td>
            </tr>
            <tr>
              <td width="245" valign="top">
                <p>
                  Komplikasi Intra-operasi :
                </p>
                <p>
                  <input type="checkbox" required checked>
                  <?php
                  $getone = GetOne($_REQUEST['id']);
                  if (isset($getone)) {
                    foreach ($getone as $data) {

                      echo  $data['komplikasi_intra_operasi'];
                    }
                  }
                  ?>
                </p>
              </td>
              <td width="471" colspan="2" rowspan="2" valign="top">
                <p>
                  Penjabaran Komplikasi Intra-operasi :
                </p>
                <p><?php
                    $getone = GetOne($_REQUEST['id']);
                    if (isset($getone)) {
                      foreach ($getone as $data) {

                        echo  $data['penjabaran_komplikasi_intra_operasi'];
                      }
                    }
                    ?></p>
              </td>
            </tr>
            <tr>
              <td width="245" valign="top">
                <p>
                  Perdarahan : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['perdarahan'];
                                  }
                                }
                                ?> cc
                </p>
              </td>
            </tr>
            <tr>
              <td width="388" colspan="2" valign="top">
                <p>
                  Instruksi pasca-bedah :
                </p>
                <p>
                  1. Kontrol nadi/tensi/pernafasan/suhu :
                  <br>
                  Nadi : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {

                              echo  $data['kontrol_nadi'];
                            }
                          }
                          ?>

                  tensi : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {

                              echo  $data['kontrol_tensi'];
                            }
                          }
                          ?>
                  <br>
                  pernafasan : <?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['kontrol_pernafasan'];
                                  }
                                }
                                ?>

                  suhu : <?php
                          $getone = GetOne($_REQUEST['id']);
                          if (isset($getone)) {
                            foreach ($getone as $data) {

                              echo  $data['kontrol_suhu'];
                            }
                          }
                          ?>
                </p>
                <p>
                  2. Puasa :<?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo  $data['puasa'];
                              }
                            }
                            ?>
                </p>

                <p>
                  3. Drain :<?php
                            $getone = GetOne($_REQUEST['id']);
                            if (isset($getone)) {
                              foreach ($getone as $data) {

                                echo  $data['drain'];
                              }
                            }
                            ?>
                </p>


                <p>
                  4. Infus : <?php
                              $getone = GetOne($_REQUEST['id']);
                              if (isset($getone)) {
                                foreach ($getone as $data) {

                                  echo  $data['infus'];
                                }
                              }
                              ?>
                </p>


              </td>
              <td width="328" valign="top">
                <p>
                  5. Obat-obatan : <?php
                                    $getone = GetOne($_REQUEST['id']);
                                    if (isset($getone)) {
                                      foreach ($getone as $data) {

                                        echo  $data['obat_obatan'];
                                      }
                                    }
                                    ?>
                </p>

                <p>
                  6. Ganti Balut : <?php
                                    $getone = GetOne($_REQUEST['id']);
                                    if (isset($getone)) {
                                      foreach ($getone as $data) {

                                        echo  $data['ganti_balut'];
                                      }
                                    }
                                    ?>
                </p>
                <p>
                  7. Lain-lain :<?php
                                $getone = GetOne($_REQUEST['id']);
                                if (isset($getone)) {
                                  foreach ($getone as $data) {

                                    echo  $data['lain_lain'];
                                  }
                                }
                                ?>
                </p>

                <p>
                  Belawan,<?= date('d/m/yy') ?>.Pukul : <?= date('h:i:s') ?>
                </p>
                <p>
                  Operator Bedah
                </p>
                <p align="center">
                  (<?= $_SESSION['pegawai_nama'] ?>)
                </p>
                <p align="center">
                  Tanda Tangan dan Nama Jelas
                </p>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
      </div>


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
            filename: "RM 21.14 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
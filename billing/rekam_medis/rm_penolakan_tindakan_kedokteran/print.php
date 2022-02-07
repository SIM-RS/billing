<?php
require_once 'func.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> PENOLAKAN TINDAKAN KEDOKTERAN / OPERASI</title>
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
            <p align='right' style="margin: 0px;;">RM21.1/PHCM</p>
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

            <div class='container'>
                <h5>
                    <p>
                        <strong> </strong>
                        <strong>PENOLAKAN </strong>
                        <strong>TINDAKAN KEDOKTERAN</strong>
                        <strong>/OPERASI</strong>
                    </p>
                </h5>
                <table border="1" align="center" cellpadding="7" style="width: 240mm; font-size: 18px;">
                    <tbody>
                        <tr>
                            <td colspan="4" width="659" valign="top">
                                <center>
                                    <p>
                                        <strong> </strong>
                                        <strong> PEMBERIAN INFORMASI</strong>
                                        <strong>TINDAKAN KEDOKTERAN</strong>
                                        <strong>/OPERASI…………………… </strong>
                                    </p>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" width="192" valign="top">
                                <p>
                                    Dokter pelaksana Tindakan
                                </p>
                            </td>
                            <td colspan="2" width="467" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['dokter_pelaksana_tindakan'];
                                    }
                                }     ?>


                            </td>

                        </tr>
                        <tr>
                            <td colspan="2" width="192" valign="top">
                                <p>
                                    Pemberi informasi
                                </p>
                            </td>
                            <td colspan="2" width="467" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['pemberi_informasi'];
                                    }
                                }     ?>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" width="192" valign="top">
                                <p>
                                    Penerima Informasi
                                </p>
                            </td>
                            <td colspan="2" width="467" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['penerima_informasi'];
                                    }
                                }     ?>

                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p align="center">
                                    <strong>NO</strong>
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p align="center">
                                    <strong>JENIS INFORMASI</strong>
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <p align="center">
                                    <strong>ISI INFORMASI</strong>
                                </p>
                            </td>
                            <td width="94" valign="top">
                                <p align="center">
                                    <strong>TANDAI</strong>
                                    <strong> ( √)</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    1
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Diagnosis ( WD&amp;DD)
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['diagnosis_wd_dan_dd'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    2
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Dasar Diagnosis
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);
                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['dasar_diagnosis'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    3
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Tindakan Kedokteran
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['tindakan_kedokteran'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    4
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Indikasi tindakan
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['indikasi_tindakan'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    5
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Tata Cara
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['tata_cara'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    6
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Tujuan
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['tujuan'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    7
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Risiko
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['risiko'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    8
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Komplikasi
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['komplikasi'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    9
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Prognosis
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php
                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['prognosis'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    10
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Alternatif Risiko
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['alternatif_risiko'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="37" valign="top">
                                <p>
                                    11
                                </p>
                            </td>
                            <td width="155" valign="top">
                                <p>
                                    Lain-lain
                                </p>
                            </td>
                            <td width="373" valign="top">
                                <?php

                                $getall = GetOne($_REQUEST['id']);

                                if (isset($getall)) {

                                    foreach ($getall as $data) {

                                        echo $data['lain_lain'];
                                    }
                                }     ?>

                            </td>
                            <td width="94" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="565" valign="top">
                                <p>
                                    Dengan ini menyatakan bahwa saya telah menerangkan hal-hal
                                    di atas secara benar dan jujur dan memberikan kesempatan
                                    untuk bertanya dan / atau berdiskusi
                                </p>
                            </td>
                            <td width="100" valign="top">
                                <p>
                                    Nama &amp; TTD dokter.
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" width="565" valign="top">
                                <p>
                                    Dengan ini menyatakan bahwa saya telah menerima informasi
                                    sebagaimana di atas yang saya beri tanda / paraf di kolom
                                    kanannya, dan telah memahaminya
                                </p>
                            </td>
                            <td width="100" valign="top">
                                <p>
                                    Nama &amp; TTD pasien/ kel
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" width="644" valign="top">
                                <p>
                                    <strong>
                                        *Bila pasien tidak kompeten atau tidak mau menerima
                                        informasi,maka penerima informasi adalah wali atau
                                        keluarga terdekat
                                    </strong>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </center>
        <BR>
        <BR>
        <?php
        $pasien = mysql_fetch_assoc(mysql_query("SELECT * FROM b_ms_pasien WHERE id = '$idPasien'"));
        $tanggal = new DateTime($pasien['tgl_lahir']);

        // tanggal hari ini
        $today = new DateTime('today');

        // tahun
        $y = $today->diff($tanggal)->y;
        ?>
        <center>
            <table border="1" align="center" cellpadding="7" style="width: 240mm; font-size: 18px;">

                <tbody>
                    <tr>
                        <td>
                            <div>
                                <p align="center">
                                    <strong>PENOLAKAN TINDAKAN KEDOKTERAN / OPERASI </strong>

                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="678" valign="top">
                            <p>
                                Yang bertanda tangan diba<em>w</em>ah ini :
                            </p>
                            <p>
                                I. Nama :
                                _______________________________________________________________________
                            </p>
                            <p>
                                Hubungan dengan pasien : pasien sendiri / suami/istri/anak
                                /ayah /ibu*, lain-lain __________________________
                            </p>
                            <p>
                                Tgl lahir/ umur : ____________/ _________ tahun, jenis
                                kelamin : Laki-laki / Perempuan *
                            </p>
                            <p>
                                Alamat :
                                _______________________________________________________________________
                            </p>

                            <p>
                                <strong>Dengan Ini Menyatakan MENOLAK / TIDAK SETUJU Dilakukan Tindakan Kedokteran/ Operasi </strong>

                                <strong> ________________</strong>

                            </p>

                            <table cellspacing="0" cellpadding="0" align="left">
                                <tbody>
                                    <tr>
                                        <td>
                                            Terhadap :
                                            <br><br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br clear="ALL" />
                            <p>
                                II. Nama Pasien : <?= $pasien['nama'] ?> , No. RM :<?= $pasien['no_rm'] ?>
                            </p>
                            <p>
                                Tanggal lahir/Umur : <?= $pasien['tgl_lahir'] ?>/ <?= $y ?>
                                tahun, Jenis Kelamin : <?php
                                                        if ($pasien['sex'] == 'L') {
                                                            echo "Laki-Laki";
                                                        } else {
                                                            echo "Perempuan";
                                                        }
                                                        ?>
                            </p>
                            <p>
                                Alamat :
                                <?= $pasien['alamat'] ?>
                            </p>

                            <p>

                                <strong>
                                    Telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi yang mungkin timbul apabila tindakan tersebut tidak dilakukan .
                                </strong>
                            </p>
                            <p>
                                <strong>
                                    Saya bertanggungjawab secara penuh atas segala akibat yang mungkin timbul sebagai akibat tidak dilakukannya tindakan/ pengobatan tersebut
                                </strong>
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                            <p>
                                Hari : <?= hari_ini() ?>, Tanggal : <?= date('d/m/yy') ?> Pukul :
                                <?= date('h:i:s') ?>
                            </p>
                            <table>
                                <tr>
                                    <td>
                                        <strong>
                                            <p>
                                                Yang menyatakan *

                                                <br><br><br><br>
                                                ( ______________________)
                                            </p>
                                        </strong>
                                    </td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <strong>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saksi <br><br><br><br>
                                                ( ______________________) ( ______________________)
                                            </p>
                                        </strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
            </div>
            </div>
        <BR>
        <center>
            <div class='' btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
                <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
                <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
            </div>
        </center>
    </div>

 <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 21.1 <?=$rwPasien['nama'];?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
</body>

</html>
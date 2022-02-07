<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checklist Rencana Pulang </title>
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
  <center>
        <BR>
        <div class='btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
          <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
        </div>
      </center>

    <div id="pdf-area" style=" width: 240mm;  margin: auto;">

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
            <p align='right' style="margin: 0px;;">RM28/PHCM</p>
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

                <?php

                $no = 1;
                $getall = GetOne($_REQUEST['id']);
                $no = 1;
                if (isset($getall)) {
                    foreach ($getall as $data) { ?>
                        <p align="center">
                            <strong>CHEKLIST RENCANA PULANG (<em>DISCHARGE PLANNING</em>)</strong>
                        </p>
                        <table width="690" cellspacing="0" cellpadding="4" border="1">
                            <tbody>
                                <tr>
                                    <td width="510" valign="top">
                                        <p align="center">
                                            <strong>KEGIATAN</strong>
                                        </p>
                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <strong>CATATAN</strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>AKTIFITAS</strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['aktifitas']; ?>
                                        </p>

                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_aktifitas']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>PEMBERIAN OBAT DIRUMAH</strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['pemberian_obat_dirumah']; ?>
                                        </p>

                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_pemberian_obat_dirumah']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>FASILITAS KESEHATAN YANG </strong>
                                            <strong>BISA DIHUBUNGI JIKA TERJADI KEDARURATAN</strong>
                                            <strong></strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['fasilitas_kesehatan']; ?>
                                        </p>

                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_fasilitas_kesehatan']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>HASIL PEMERIKSAAN PENUNJANG</strong>
                                        </p>
                                        <p>
                                            <strong>Berikan edukasi tentang :</strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['hasil_pemeriksaan_penunjang']; ?>
                                        </p>
                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_hasil_pemeriksaan_penunjang']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>KONTROL SELANJUTNYA</strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['kontrol_selanjutnya']; ?>
                                        </p>

                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_kontrol_selanjutnya']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>DIET</strong>
                                        </p>
                                        <?= " <input type='checkbox'  checked disabled> " . $data['diet']; ?>

                                        <p>
                                            <strong> </strong>
                                        </p>
                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_diet']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <table width="497" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td width="497" valign="bottom" nowrap="">
                                                        <p>
                                                            <strong>EDUKASI DAN LATIHAN</strong>
                                                        </p>
                                                        <p>
                                                            <?= " <input type='checkbox'  checked disabled> " . $data['edukasi_dan_latihan']; ?>
                                                        </p>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p>

                                        </p>
                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_edukasi_dan_latihan']; ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="510" valign="top">
                                        <p>
                                            <strong>RINCIAN PEMULANGAN</strong>
                                        </p>
                                        <p>
                                            <?= " <input type='checkbox'  checked disabled> " . $data['rincian_pemulangan']; ?>
                                        </p>

                                    </td>
                                    <td width="180" valign="top">
                                        <p align="center">
                                            <?= $data['catatan_rincian_pemulangan']; ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <p>

                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <strong> </strong>



                <?php
                    }
                }
                ?>
            </div>

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 28 <?=$rwPasien['nama']?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
</body>

</html>
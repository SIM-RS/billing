<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> DUGAAN REAKSI TRANSFUSI </title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>

    <style type="text/css">
        @media print {
            #print {
                display: none;
            }

        }

        p {
            font-size: 11pt;
        }

        * {
            font-size: 11pt;
        }
    </style>
    <script src="../html2pdf/ppdf.js"></script>
</head>


<body>
<center>
        <div class='' btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
            <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
            <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
        </div>
    </center>
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
            <p align='right' style="margin: 0px;;">RM 24.3/PHCM</p>
            <table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="2">

                <tr>
                    <td class="noline" style="font:12 sans-serif bolder;">
                        NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $rwPasien['nama']; ?>
                    </td>
                    <td class="noline"></td>
                    <td class="noline">&nbsp;</td>
                    <td class="noline">&nbsp;</td>
                </tr>
                <tr>
                    <td class="noline" style="font:12 sans-serif bolder;">
                        Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwPasien['sex']; ?>
                    </td>
                    <td class="noline"></td>
                    <td class="noline">&nbsp;</td>
                    <td class="noline">&nbsp;</td>
                </tr>
                <tr>
                    <td class="noline" style="font:12 sans-serif bolder;">
                        No.RM &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $rwPasien['no_rm']; ?>
                    </td>
                    <td class="noline"></td>
                    <td class="noline">&nbsp;</td>
                    <td class="noline">&nbsp;</td>
                </tr>

            </table>
        </div>
        <br>

        <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:10px;">
        <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:2px;">

        <center>
            <br>
            <p align="center">
                <strong>DUGAAN REAKSI TRANSFUSI</strong>
                <strong></strong>
            </p>

            <table width="679" cellspacing="0" cellpadding="0" border="1">
                <tbody>
                    <tr>
                        <td width="679" valign="top">
                            <p>
                                Kepada Yth : Kepala Unit Laboratorium Sentral / Pelayanan
                                Darah
                            </p>
                            <p>
                                Di
                            </p>
                            <p>
                                Tempat
                            </p>
                            <p>
                                Dengan ini kami laporkan DUGAAN REAKSI TRANSFUSI pada
                                pasien :
                            </p>
                            <p>
                                Nama :
                                <?php echo $rwPasien['nama']; ?>
                                * <?php echo $rwPasien['sex']; ?>
                            </p>
                            <p>
                                Umur /Tmp Tgl Lahir : .................. Tahun /
                                <?php echo $rwPasien['tgl_lahir']; ?>
                            </p>
                            <p>
                                No. RM :
                                <?php echo $rwPasien['no_rm']; ?>
                            </p>
                            <?php

                            $no = 1;
                            $getall = GetOne($_REQUEST['id']);
                            $no = 1;
                            if (isset($getall)) {
                                foreach ($getall as $data) { ?>
                                    <p>
                                        Diagnosa :<?= $data['diagnosa'] ?>

                                    </p>
                                    <p>
                                        Bagian :<?= $data['bagian'] ?>

                                    </p>
                                    <p>
                                        Ruangan :
                                        <?= $data['ruangan'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Kelas : <?= $data['kelas'] ?>
                                    </p>
                                    <p>
                                        Hari, tanggal &amp; jam transfusi :<?= $data['hari_tanggal_jam_transfusi'] ?>

                                    </p>
                                    <p>
                                        Jam terjadinya rekasi : <?= $data['jam_reaksi'] ?>

                                    </p>
                                    <p>
                                        Jenis komponen darah :<?= $data['jenis_komponen_darah'] ?>

                                    </p>
                                    <p>
                                        Gol. Darah-Rhesus /No. Kantong darah :<?= $data['golongan_darah'] ?>

                                    </p>
                                    <p>
                                        Perkiraan vol yang sudah ditransfusikan : <?= $data['perkiraan_vol_transfusi'] ?>

                                    </p>
                                    <p>
                                        Pra-transfusi : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pasca Transfusi :
                                    </p>
                                    <p>
                                        Kesadaran : <?= $data['pratransfusi_kesadaran'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Kesadaran : <?= $data['pascatransfusi_kesadaran'] ?>
                                    </p>
                                    <p>
                                        Tekanan darah :
                                        <?= $data['pratransfusi_tekanan_darah'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tekanan darah
                                        : <?= $data['pascatransfusi_tekanan_darah'] ?>
                                    </p>
                                    <p>
                                        Frekuensi nadi :
                                        <?= $data['pratransfusi_frekunensi_nadi'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Frekuensi
                                        nadi : <?= $data['pascatransfusi_frekunensi'] ?>
                                    </p>
                                    <p>
                                        Suhu : <?= $data['pratransfusi_suhu'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Suhu :
                                        <?= $data['pascatransfusi_suhu'] ?>
                                    </p>
                                    <p>
                                        <div style="float: right;">
                                            <table width="340" cellspacing="0" cellpadding="2" border="1" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td>

                                                            <p align="center">
                                                                Tatalaksana pada reaksi transfusi
                                                            </p>
                                                            <p align="center">
                                                                (bagi paramedis)
                                                            </p>
                                                            <p>
                                                                1. Stop transfusi
                                                            </p>
                                                            <p>
                                                                2. Hubungi dokter
                                                            </p>
                                                            <p>
                                                                3. Observasi tanda vital setiap 30
                                                                menit
                                                            </p>
                                                            <p>
                                                                4. Siapkan contoh darah pasca transfusi
                                                                :
                                                            </p>
                                                            <p>
                                                                · Dewasa : darah beku 7-8 ml,
                                                            </p>
                                                            <p>
                                                                darah sitras 3-4 ml
                                                            </p>
                                                            <p>
                                                                · Bayi : darah beku 3-4 ml,
                                                            </p>
                                                            <p>
                                                                darah sitras 2-3 ml
                                                            </p>
                                                            <p>
                                                                5. Cocokkan kembali instruksi dokter,
                                                                permintaan darah, label dan no kantong.
                                                            </p>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        Gejala dan tanda klinis :
                                        Urtikaria
                                        <ul>
                                            <li>
                                                Gatal
                                            </li>
                                            <li>
                                                Frekuensi nadi meningkat
                                            </li>
                                            <li>
                                                Takikardia / aritmia
                                            </li>
                                            <li>
                                                Menggigil
                                            </li>
                                            <li>
                                                Suhu meningkat &gt; 1 C
                                            </li>
                                            <li>
                                                Flushing
                                            </li>
                                            <li>
                                                Nyeri otot
                                            </li>
                                            <li>
                                                Urin berwarna gelap/merah
                                            </li>
                                            <li>
                                                Oliguria/Anuria
                                            </li>
                                            <li>
                                                Petekia
                                            </li>
                                            <li>
                                                Gangguan pembekuan darah/DIC
                                            </li>
                                            <li>
                                                Ikterus
                                            </li>
                                            <li>
                                                Hipotensi
                                            </li>
                                            <li>
                                                Anafilaksia
                                            </li>
                                            <li>
                                                Dispenia
                                            </li>
                                            <li>
                                                <?= $data['gejala_tanda_klinis'] ?>
                                            </li>
                                            <li>
                                                ............................................
                                            </li>
                                        </ul>

                                    </p>
                                    <ul>

                                        <li>

                                        </li>
                                    </ul>
                                    <p> <?= $data['nama_dokter'] ?></p>
                                    <p>

                                        (
                                        ..................................................................
                                        )
                                    </p>
                                    <p>
                                        Nama jelas dokter, tanda tangan
                                    </p>
                                    <p>
                                        &amp; sampel ruangan
                                    </p>
                                    <p>
                                        *Coret yang tidak perlu
                                    </p>
                        </td>
                    </tr>
                </tbody>
            </table>

    <?php
                                }
                            }
    ?>

    </div>
    <BR>
    
    </div>
    </div>
    </div>

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 24.3 <?=$rwPasien['nama']?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
</body>

</html>
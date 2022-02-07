<?php
require_once 'func.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Pemberian Transfusi Darah </title>
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
            #rupiah {
                border: 0px;
            }
        }
    </style>
    <script src="../html2pdf/ppdf.js"></script>
</head>


<body>

    <div id="pdf-area" style=" width: 1000px;  margin: auto;">

        <?php
        include("../../koneksi/konek.php");
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
            <p align='right' style="margin: 0px;;">RM24/PHCM</p>
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

                <form action="" method="" onsubmit="window.print()">
                    <br>
                    <p align="center">
                        <strong>PERMINTAAN TRANSFUSI DARAH</strong>
                    </p>
                    <table border="1" align="center" cellpadding="7" style="width: 210mm; font-size: 12.5px;">
                        <tbody>
                            <tr>
                                <td colspan="3" width="682" valign="top">
                                    <p align="center">
                                        <strong>
                                            PEMBERIAN INFORMASI TINDAKAN TRANSFUSI DARAH
                                        </strong>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Dokter pelaksana tindakan
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <?php

                                    $getall = GetOne($_REQUEST['id']);

                                    if (isset($getall)) {

                                        foreach ($getall as $data) {

                                            echo $data['dokter_pelaksana_tindakan'];
                                        }
                                    }     ?>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Pemberi Informasi
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <?php

                                    $getall = GetOne($_REQUEST['id']);

                                    if (isset($getall)) {

                                        foreach ($getall as $data) {

                                            echo $data['pemberi_informasi'];
                                        }
                                    }     ?>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Penerima informasi
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <?php

                                    $getall = GetOne($_REQUEST['id']);

                                    if (isset($getall)) {

                                        foreach ($getall as $data) {

                                            echo $data['penerima_informasi'];
                                        }
                                    }     ?>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p align="center">
                                        <strong>JENIS INFORMASI</strong>
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p align="center">
                                        <strong>ISI INFORMASI</strong>
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                    <p align="center">
                                        <strong>TANDA(√)</strong>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Dasar diagnosis
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" id="gridCheck" checked>
                                                    <label class="form-check-label" for="gridCheck">
                                                        <?php

                                                        $getall = GetOne($_REQUEST['id']);

                                                        if (isset($getall)) {

                                                            foreach ($getall as $data) {

                                                                echo $data['dasar_diagnosis'];
                                                            }
                                                        }     ?>
                                                    </label>
                                                </div>
                                            </div>


                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Tindakan Kedokteran
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Transfusi darah adalah: proses transfer darah atau komponen
                                        darah dari donor ke resipien
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Indikasi Tindakan
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>

                                        <div class="row">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" name="indikasi_tindakan" id="gridCheck" checked>
                                                    <label class="form-check-label" for="gridCheck">
                                                        <?php

                                                        $getall = GetOne($_REQUEST['id']);

                                                        if (isset($getall)) {

                                                            foreach ($getall as $data) {

                                                                echo $data['indikasi_tindakan'];
                                                            }
                                                        }     ?>
                                                    </label>
                                                </div>
                                            </div>


                                        </div>

                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>
                                        Tata Cara
                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Pemberian transfusi darah melalui vena perifer / vena besar
                                        disalurkan menggunakan selang infus yang disambungkan pada
                                        pembuluh darah pasien dan juga dapat menggunakan alat
                                        khusus untuk pemberian transfusi.
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>

                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Memberikan pengobatan dan pemulihan kondisi pasien dengan
                                        menaikan komponen darah sesuai dengan kebutuhan
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>

                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Timbulnya reaksi-reaksi transfuse, yang dapat dibagi
                                        menjadi 3 ( tiga ) tingkatan, yaitu:
                                    </p>
                                    <p>
                                        1. Reaksi demam
                                    </p>
                                    <p>
                                        2. Reaksi alergi
                                    </p>
                                    <p>
                                        3. Reaksi hemolitik, bisa terjadi secara intravaskuler
                                        maupun ekstravaskuler
                                    </p>
                                    <p>
                                        ( sumber buku pedoman pelayanan transfuse darah modul 3 )
                                    </p>
                                    <p>
                                        Dapat tertular penyakit HIV-AIDS, Hepatitis B, Hepatitis C
                                        dan sifilis
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>

                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Jika terjadi ketidakcocokan antara darah pasien dan
                                        komponen darah donor maka akan timbul reaksi hemolisis atau
                                        terjadi kerusakan sel darah merah pasien.
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td width="153" valign="top">
                                    <p>

                                    </p>
                                </td>
                                <td width="465" valign="top">
                                    <p>
                                        Biaya komponen darah yang dipesan atau diberikan kepada
                                        pasien antara lain : pengolahan darah di PMI ,
                                        <strong>
                                            biaya screening ( screening meliputi : HbsAg,Anti HIV ,
                                            Anti HCV , darah yang telah dipesan digunakan atau
                                            tidak digunakan biaya tetap dibebankan kepada pasien /
                                            keluarga .
                                        </strong>
                                    </p>
                                    <p>
                                        Biaya pengolahan darah dan screening setiap kantong : <br> <?php

                                                                                                    $getall = GetOne($_REQUEST['id']);

                                                                                                    if (isset($getall)) {

                                                                                                        foreach ($getall as $data) {

                                                                                                            echo "Rp." . $data['biaya_pengelolaan'];
                                                                                                        }
                                                                                                    }     ?>
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" width="618" valign="top">
                                    <p>
                                        Dengan ini menyatakan bahwa saya Dokter telah menerangkan
                                        hal-hal di atas secara benar dan jelas dan memberikan
                                        kesempatan untuk bertanya dan/atau berdiskusi
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                    <p>
                                        Nama &amp;
                                    </p>
                                    <p>
                                        TTD dr.
                                    </p>
                                    <br><br>
                                    <?php

                                    $getall = GetOne($_REQUEST['id']);

                                    if (isset($getall)) {

                                        foreach ($getall as $data) {

                                            echo $data['nama_dokter'];
                                        }
                                    }     ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" width="618" valign="top">
                                    <p>
                                        Dengan ini menyatakan bahwa saya / keluarga pasien telah
                                        menerima informasi dari dokter ,sebagaimana di atas yang
                                        saya beri tanda/paraf di kolom kanannya serta telah diberi
                                        kesempatan untuk bertanya / berdiskusi, dan telah
                                        memahaminya
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                    <p>
                                        Nama &amp; TTD ps/kel
                                    </p>
                                    <br><br>
                                    <?php echo $rwPasien['nama']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" width="618" valign="top">
                                    <p>
                                        <strong>
                                            * Bila pasien tidak kompeten atau tidak mau menerima
                                            informasi, maka penerima informasi adalah wali /
                                            keluarga terdekat
                                        </strong>
                                        <strong></strong>
                                    </p>
                                </td>
                                <td width="64" valign="top">
                                </td>
                            </tr>
                        </tbody>
                    </table>

        </center>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
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
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <BR>
        <br>
        <center>

            <table border="1" align="center" cellpadding="7" style="width: 220mm; font-size: 18px;">

                <tbody>
                    <tr>
                        <td>
                            <div>
                                <p align="center">
                                    <strong>PEMBERIAN INFORMASI TINDAKAN TRANSFUSI DARAH </strong>

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
                                <strong>Dengan Ini Menyatakan SETUJU Dilakukan Tindakan TRANSFUSI DARAH DAN SCREENING</strong> (Ya/Tidak)*



                            </p>

                            <table cellspacing="0" cellpadding="0" align="left">
                                <tbody>
                                    <tr>
                                        <td>

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
                                    Saya memahami perlunya dan manfaat tindakan TRANSFUSI DARAH DAN SCREENING sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi yang mungkin timbul.
                                </strong>
                            </p>
                            <p>
                                <strong>
                                    Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.
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
                <div id='print' class='btn btn-info' onclick="pdf()">Cetak PDF</div>
                <button type="submit" id='print' class='btn btn-info' onclick="return confirm('Anda Yakin Formulir yang di isi sudah benar ?')">Cetak</button>
                <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
            </div>
        </center>
    </div>
    <script type="text/javascript">
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value);
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    function pdf() {
        const pdf = document.getElementById("pdf-area");
            var opt = {
                margin: 0,
                filename: "RM 24 <?=$rwPasien['nama']?>.pdf",
                image: { type: "JPEG", quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
            };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
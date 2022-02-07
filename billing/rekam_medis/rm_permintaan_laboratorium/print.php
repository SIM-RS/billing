<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> FORMULIR PERMINTAAN PEMERIKSAAN LABORATORIUM PATOLOGI</title>
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
    <p align='right' style="margin: 0px;;">RM17/PHCM</p>
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
      <h5>FORMULIR PERMINTAAN PEMERIKSAAN LABORATORIUM PATOLOGI</h5>
      
    </center>
    <br>
    <div class='container'>
    <center>
    <table border="1" cellspacing="0" cellpadding="2" width="800">
    <tbody>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>KLINIS</strong>
                </p>
            </td>
            <td width="469" valign="top">
            <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['klinis'];
    }
}     ?>


            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>DIAGNOSIS</strong>
                </p>
            </td>
            <td width="469" valign="top">
            <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['diagnosis'];
    }
}     ?>


            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>I. </strong>
                    <strong>HAEMATOLOGY</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                    1. DARAH RUTIN ( <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['darah_rutin'];
    }
}     ?>

)
                </p>
                <p>
                    2. ANEMIA PROFILE
                </p>
                <p>
                   <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['anemia_profile'];
    }
}     ?>


                </p>
               
                <p>
                    3. HAEMORRHAGIC TEST
                </p>
              <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['haemorrhagic_test'];
    }
}     ?>
              </p>

                <p>
                    4. FAAL HATI
                </p>
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['faal_hati'];
    }
}     ?>
                </p>
           
                <p>
                    5. FAAL GINJAL
                </p>
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['faal_ginjal'];
    }
}     ?>
                </p>
              
                <p>
                    6. METABOLISME KARBOHIDRA
                </p>
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['metabolisme_karbohidra'];
    }
}     ?>
                </p>
              
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>II. </strong>
                    <strong>URINE</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['urine'];
    }
}     ?>
                </p>
              
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>III. </strong>
                    <strong>THYROID :</strong>
                </p>
                <p>
                    <strong></strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['thyroid'];
    }
}     ?>
                </p>
               
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>IV. </strong>
                    <strong>LIPID PROFILE</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['lipid_profile'];
    }
}     ?>
                </p>
            
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>V. </strong>
                    <strong>ARTHRITIS PROFILE</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['arthritis_profile'];
    }
}     ?>
                </p>
               
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>VI. </strong>
                    <strong>ELEKTROLIT</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['elektrolit'];
    }
}     ?>
                </p>
              
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>VII. </strong>
                    <strong>FECES</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['feces'];
    }
}     ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>VIII. </strong>
                    <strong>PANCREAS</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['pancreas'];
    }
}     ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>IX. </strong>
                    <strong>MYOCARD INFARCT</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['myocard_infarct'];
    }
}     ?>
                </p>
          
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>X. </strong>
                    <strong>V.D. PROFILE</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['vd_profile'];
    }
}     ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="246" valign="top">
                <p>
                    <strong>XI. </strong>
                    <strong>LAIN-LAIN</strong>
                </p>
            </td>
            <td width="469" valign="top">
                <p>
                <input  type="checkbox" required checked> <?php

$getall = GetOne($_REQUEST['id']);

if (isset($getall)) {

    foreach ($getall as $data) {

        echo $data['lain_lain'];
    }
}     ?>
                </p>
               
            </td>
        </tr>
    </tbody>
</table>
<div class="box-dokter" style="float: right; padding-right: 150px">
Belawan, .....................
<br>
Dokter yang mengirim :
<br>
(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
    </div>
    </div>

    </div>
    </center>
      <BR>   <BR>   <BR>
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
            filename: "RM 17 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>

</html>
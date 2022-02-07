<?php
require_once 'func.php';
session_start();
$qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='" . $idPasien . "'";
$rsPasien = mysql_query($qPasien);
$rwPasien = mysql_fetch_array($rsPasien);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> REASSESMEN / PENGKAJIAN ULANG MANAJEMEN NYERI FARMAKOLOGI </title>
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
  <script src="../js/jquery-3.5.1.slim.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>
  <script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
  <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
  <link rel="icon" href="../favicon.png">
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

    <img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


    <div class="box-pasien" style="float: right; padding-right: 0px;">
      <p align='right' style="margin: 0px;;">RM 12.4/PHCM</p>
      <table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="2">

        <tr>
          <td class="noline" style="font:12 sans-serif bolder;">
            <b>NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $rwPasien['nama']; ?></b>
          </td>
          <td class="noline"></td>
          <td class="noline">&nbsp;</td>
          <td class="noline">&nbsp;</td>
        </tr>
        <tr>
          <td class="noline" style="font:12 sans-serif bolder;">
            <b>Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwPasien['sex']; ?></b>
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
    <hr style="margin:0px; padding:0px; margin-top:18px;">
    <hr style="border: 1px solid black; margin:0px; padding:0px; margin-top:2px;">
    <br>
    <center>
      <h5>REASSESMEN / PENGKAJIAN ULANG MANAJEMEN NYERI FARMAKOLOGI</h5>
    </center>
    <CENTER>
      <?php

      $no = 1;
      $id = $_REQUEST['id'];
      $one = GetOne($id);
      if (isset($one)) {
        foreach ($one as $data) { ?>
          <table cellpadding="10" cellspacing="10">
            <tr>
              <td>
                Ruangan
              </td>
              <td>:</td>
              <td>
                <?= $data['ruangan']  ?>
              </td>
            </tr>
          </table>

      <?php }
      } ?>
      <img src="skala_nyeri.png">
      <br>
      <br>
      <table border="1" cellpadding="4" width="900">
        <thead>
          <tr align="center">
            <th>No</th>
            <th>Hari / Tanggal</th>
            <th>Skala <br>Nyeri</th>
            <th>Waktu /<br> Jam</th>
            <th>Intervensi yang diberikan</th>
            <th>Waktu /<br> Jam</th>
            <th>Skala<br> Nyeri</th>
            <th>Paraf</th>



          </tr>
        </thead>
        <tbody>
          <?php

          $no = 1;
          $id = $_REQUEST['id'];
          $one = GetOne($id);
          if (isset($one)) {
            foreach ($one as $data) {
              echo "<tr align='center'>";
              echo "<td>" . $no++ . "</td>";
              echo "<td>" . $data['hari_tanggal'] . "</td>";
              echo "<td>" . $data['skala_nyeri_pertama'] . "</td>";
              echo "<td>" . $data['waktu_jam_pertama'] . "</td>";
              echo "<td>" . $data['intervensi_yang_diberikan'] . "</td>";
              echo "<td>" . $data['waktu_jam_kedua'] . "</td>";
              echo "<td>" . $data['skala_nyeri_kedua'] . "</td>";
              echo "<td>" . $data['paraf'] . "</td>";
            }
          }
          ?>


        </tbody>
      </table>
    </CENTER>
    <br>
    <div class="box-pasien" style="float: right; padding-right: 0px; margin-right: 25px;">
      Setelah Pemberian<BR>
      <br>
      Analgetik oral = observasi 60 menit<BR><br>
      Analgetik Injeksi = observasi 30 menit<BR>
    </div>
    </div>

    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
      <center>
        <div class='btn-group'>
  <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
          <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
        </div>
      </center>
    </div>
  </div>

<script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 12.4 <?=$rwPasien['nama']?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
</body>

</html>
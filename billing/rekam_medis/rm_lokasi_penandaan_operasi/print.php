<?php
require_once 'func.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lokasi Penandaan Operasi </title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>

  <link rel="icon" href="../favicon.png">


  <style type="text/css">
    @media print {
      #print {
        display: none;
      }
    }

    * {
      font-size: 12pt;
    }

    p {
      font-size: 12pt;
    }
  </style>
    <script src="../html2pdf/ppdf.js"></script>
</head>


<body>
  <div id="pdf-area" style="width: 1000px; margin:auto;">

    <?php

    $qPasien = "select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='" . $idPasien . "'";
    $rsPasien = mysql_query($qPasien);
    $rwPasien = mysql_fetch_array($rsPasien);
    ?>

    <img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


    <div class="box-pasien" style="float: right; padding-right: 0px;">
      <p align='right' style="margin: 0px;;">RM21.2/PHCM</p>
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

    <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:17px;">
    <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:2px;">
    <center>
      <br>
      <h5>FORMULIR PENANDAAN LOKASI OPERASI</h5>
      <br>
    </center>

    <div class='container'>

      <?php

      $no = 1;
      $id = $_REQUEST['id'];
      $where = GetWhere($idKunj, $idPasien);
      if (isset($where)) {
        foreach ($where as $data) {

      ?>
          <center>
            <table>
              <tr>
                <td>Prosedur : <?= $data['prosedur'] ?></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>Tanggal prosedur : <?= $data['tanggal_prosedur'] ?></td>

              </tr>
            </table>
            <br>
            <img src="sitemark.png">
            <p>Saya menyatakan bahwa lokasi operasi yang telah ditetapkan pada gambar diatas adalah benar

              <table cellpadding="20" cellspacing="20">
                <tr>
                  <td>
                    <hr style="border-color: black; margin: 0px; padding:0px;">
                  </td>
                  <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                  <td>
                    <hr style="border-color: black; margin: 0px; padding:0px;">
                  </td>
                </tr>
                <tr>
                  <td>
                    <table>
                      <tr>
                        <td>Nama Pasien </td>
                        <td>:</td>
                        <td><?php echo $rwPasien['nama']; ?></td>
                      </tr>
                      <tr>
                        <td>Tanggal </td>
                        <td>:</td>
                        <td><?= date('d-m-yy'); ?></td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                  <td>
                    <table>
                      <tr>
                        <td>Nama Dokter </td>
                        <td>:</td>
                        <td><?= $data['nama_dokter'] ?></td>
                      </tr>
                      <tr>
                        <td>Tanggal </td>
                        <td>:</td>
                        <td><?= date('d-m-yy'); ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </p>
          </center>
      <?php }
      } ?>
        </div>
        </div>

      <center>
        <div class='' btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>

          <a id="print" href="javascript:history.back()" class="btn btn-primary ">Kembali</a>
        </div>
      </center>

    </div>

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 21.2 <?=$rwPasien['nama']?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
</body>

</html>
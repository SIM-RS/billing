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
  <title> REASSESMEN / PENGKAJIAN ULANG NYERI NON FARMAKOLOGI</title>
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
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

    p {
      font-size: 12pt;
    }

    * {
      font-size: 12pt;
    }
  </style>
    <script src="../html2pdf/ppdf.js"></script>
</head>


<body>
<center>
      <div class='btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
        <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
        <a id="print" href="javascript:history.back()" class="btn btn-primary ">Kembali</a>
      </div>
    </center>
  <div id="pdf-area" style=" width: 1000px;  margin: auto;">


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
      <p align='right' style="margin: 0px;;">RM 12.4/PHCM</p>
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

    <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:17px;">
    <hr style="border: 1px solid #06060687; margin:0px; padding:0px; margin-top:2px;">
    <br>
    <center>
      <h5>REASSESMEN / PENGKAJIAN ULANG NYERI NON FARMAKOLOGI</h5>
    </center>

    <Center>





      <table>
        <tr>
          <td>
            <P>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3>Nama Pasien : <?php echo $rwPasien['nama']; ?> </FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3><SPAN LANG="en-US">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3> Tanggal</FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3><SPAN LANG="en-US">
                  </SPAN></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3>
                  Lahir/Umur : <?php echo $rwPasien['tgl_lahir']; ?></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3><SPAN LANG="en-US"><?= $data['umur'] ?></SPAN></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
              </FONT>
              <FONT SIZE=3>&nbsp;&nbsp;&nbsp;<?php echo $rwPasien['sex']; ?></FONT>
              </FONT>
            </P>
            </P>

        </tr>
        </td>
        <tr>
          <td>

            <P>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3>No.RM : <?php echo $rwPasien['no_rm']; ?> </FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3><SPAN LANG="en-US">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</SPAN></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruangan : <?php

                                                                                        $no = 1;

                                                                                        $id = $_REQUEST['id'];
                                                                                        $one = GetOne($id);
                                                                                        if (isset($one)) {
                                                                                          foreach ($one as $data) {
                                                                                            echo $data['ruangan'];
                                                                                          }
                                                                                        } ?></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3><SPAN LANG="en-US"></SPAN></FONT>
              </FONT>
              <FONT FACE="Times New Roman, serif">
                <FONT SIZE=3>.</FONT>
              </FONT>
            </P>
        </tr>
        </td>
      </table>


      <img src="skala_nyeri.png">

      <br><br>
      <table width="728" cellspacing="0" cellpadding="7">
        <colgroup>
          <col width="61">
          <col width="90">
          <col width="71">
          <col width="71">
          <col width="52">
          <col width="71">
          <col width="128">
          <col width="70">
        </colgroup>
        <tbody>
          <tr valign="TOP">
            <td rowspan="2" style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="61">
              <p align="CENTER">
                <font face="Times New Roman, serif">
                  <font size="3">Tgl/Jam</font>
                </font>
              </p>
            </td>
            <td colspan="5" style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="411">
              <p style="margin-bottom: 0in" align="CENTER"><br>
              </p>
              <p align="CENTER">
                <font face="Times New Roman, serif">
                  <font size="3">PQRST
                    Nyeri</font>
                </font>
              </p>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="128">
              <p align="CENTER">
                <font face="Times New Roman, serif">
                  <font size="3">Tindak
                    lanjut / Intervensi Non Farmakologi</font>
                </font>
              </p>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="70">
              <p align="CENTER">
                <font face="Times New Roman, serif">
                  <font size="3">Paraf/
                    Nama</font>
                </font>
              </p>
            </td>
          </tr>
          <tr valign="TOP" align="">
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="90">
              <p style="margin-left: -0.11in; text-indent: 0.11in; margin-bottom: 0in">
                <font face="Times New Roman, serif">
                  <font size="3">Provokatif</font>
                </font>
              </p>
              <ol>
                <li>
                  <p style="margin-bottom: 0in">
                    <font face="Times New Roman, serif">
                      <font size="3">Luka</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in">
                    <font face="Times New Roman, serif">
                      <font size="3">Trauma</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p>
                    <font face="Times New Roman, serif">
                      <font size="3">Lainnya
                        sebutkan</font>
                    </font>
                  </p>
                </li>
              </ol>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
              <p style="margin-left: -0.07in; margin-bottom: 0in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">Quality</font>
                </font>
              </p>
              <ol>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Terbakar</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Tertusuk</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Tertekan</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Kram</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Berat</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Lainnya
                        sebutkan</font>
                    </font>
                  </p>
                </li>
              </ol>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
              <p style="text-indent: -0.08in; margin-bottom: 0in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">Regio</font>
                </font>
              </p>
              <p style="margin-left: -0.08in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">Sebutkan
                    tempatnya</font>
                </font>
              </p>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="52">
              <p style="margin-left: -0.08in; margin-bottom: 0in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">Severity</font>
                </font>
              </p>
              <p style="margin-left: -0.08in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">0-10</font>
                </font>
              </p>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
              <p style="margin-left: -0.06in; margin-bottom: 0in" align="JUSTIFY">
                <font face="Times New Roman, serif">
                  <font size="3">Tempo</font>
                </font>
              </p>
              <ol>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Jarang</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Hilang
                        timbul</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Terus
                        menerus</font>
                    </font>
                  </p>
                </li>
              </ol>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="128">
              <ol>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Distraksi</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Relaksasi</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Terapi
                        Musik</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p style="margin-bottom: 0in" align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Massage/Pijatan</font>
                    </font>
                  </p>
                </li>
                <li>
                  <p align="JUSTIFY">
                    <font face="Times New Roman, serif">
                      <font size="3">Guided
                        Imaginary</font>
                    </font>
                  </p>
                </li>
              </ol>
            </td>
            <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="70">
              <p align="CENTER"><br>
              </p>
            </td>
          </tr>
          <?php

          $no = 1;

          $id = $_POST['id'];
          $one = GetOne($id);
          if (isset($one)) {
            foreach ($one as $data) { ?>
              <!--echo "<tr>";
        echo "<td>".$no++."</td>"; 
echo "<td>".$data['nama_pasien']."</td>"; 
echo "<td>".$data['tgl_lahir']."</td>"; 
echo "<td>".$data['umur']."</td>"; 
echo "<td>".$data['no_rm']."</td>"; 
echo "<td>".$data['ruangan']."</td>"; 
echo "<td>".$data['tgl_jam']."</td>"; 
echo "<td>".$data['provokatif']."</td>"; 
echo "<td>".$data['quality']."</td>"; 
echo "<td>".$data['regio']."</td>"; 
echo "<td>".$data['severity']."</td>"; 
echo "<td>".$data['tempo']."</td>"; 
echo "<td>".$data['tindakan_lanjut']."</td>"; 
echo "<td>".$data['paraf_nama']."</td>"; 
echo "<td>".$data['id_kunjungan']."</td>"; 
echo "<td>".$data['id_pelayanan']."</td>"; 
echo "<td>".$data['id_pasien']."</td>"; -->
              <tr align="center">
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="61">
                  <?= $data['tgl_jam'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="90">
                  <?= $data['provokatif'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
                  <?= $data['quality'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
                  <?= $data['regio'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="52">
                  <?= $data['severity'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="71">
                  <?= $data['tempo'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="128">
                  <?= $data['tindakan_lanjut'] ?>
                </td>
                <td style="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in" width="70">
                  <p><br>
                  </p>
                </td>
              </tr>

              </tr>
        </tbody>
      </table>
    </Center>


    <div style="padding-left: 150px; ">
      *Lama Observasi untuk : <BR>
      Skor Nyeri 1-3, observasi 1x/shift atau 3x dalam 24 jam <BR>
      Skor Nyeri 4-5, observasi 2x/shift atau setiap 3-4 jam <BR>
      Skor Nyeri 7-10, observasi setiap 1-2 jam <BR>
    </div>
<?php  }
          }  ?>




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
<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input CHECK LIST KESIAPAN ANESTESI </title>
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css">
  <script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
  <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
  <link rel="icon" href="../favicon.png">

  <script src="../js/jquery-3.5.1.slim.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <script src="../js/bootstrap.min.js"></script>

  <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />


  <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />


</head>

<body>

  <div style="background-color: #EAF0F0 ; width: 1000px;  margin: auto;">

    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
      <tbody>
        <tr>
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM INPUT CHECK LIST KESIAPAN ANESTESI</td>
          <td width="35" class="tblatas">
            <a href="http://localhost:7777/simrs-pelindo/billing/">
              <img alt="close" src="http://localhost:7777/simrs-pelindo/billing/icon/x.png" style="cursor: pointer" border="0" width="32">
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    </fieldset>
    <div class="content-wrapper">
      <section class="content-header">
        <!-- judul teks h1 disini -->
        <hr>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-sm-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <!-- judul teks h1 disini -->
                <div class="box-tools pull-left" style="float: right; margin-right: 25px;">





                </div>
              </div>
            </div>
            <div class="box-body">
              <div class='container-fluid'>


                <form action='func.php?<?= $idKunj ?>&idPel=<?= $idPel ?>&idPasien=<?= $idPasien ?>&idUser=<?= $idUser ?>' method='POST'>


                  <div class="row">
                    <div class="col">

                      <label for="ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="ruangan" name='ruangan' required>
                    </div>



                    <div class="col">

                      <label for="diagnosis"> diagnosis:</label>
                      <input type="text" class="form-control" id="diagnosis" name='diagnosis' required>
                    </div>



                  </div>

                  <div class="row">

                    <div class="col">

                      <label for="jenis_operasi"> jenis operasi:</label>
                      <input type="text" class="form-control" id="jenis_operasi" name='jenis_operasi' required>
                    </div>

                    <div class="col">

                      <label for="teknik_anesthesi"> teknik anesthesi:</label>
                      <input type="text" class="form-control" id="teknik_anesthesi" name='teknik_anesthesi' required>
                    </div>




                  </div>

                  <br>
                  <div class="col-sm-11">

                    <label for="listrik"> listrik:</label>

                    <select class="form-control" name="listrik" required multiple>

                      <option> Mesin anastesia terhubung dengan sumber listrik, indikator (+) menyala.</option>
                      <option>Layar pemantauan terhubung dengan sumber listrik, indikator (+)</option>
                      <option>Syringe pump terhubung dengan sumber listrik, indikator (+)</option>
                      <option>Defibrilator terhubung dengan sumber listrik, indikator (+)</option>

                    </select>
                  </div>



                  <div class="col-sm-11">

                    <label for="gas_medis"> gas medis:</label>

                    <select class="form-control" name="gas_medis" required multiple>

                      <option> Selang oksigen terhubung antara sumber gas dengan mesin anestesia.</option>
                      <option> Flow meter O di mesin anestesia berfungsi, aliran gas keluar dari mesin dapat dirasakan.</option>
                      <option> Compressed air terhubung antara sumber gas dengan mesin anestesia.</option>
                      <option> Flow meter ‘Air’ di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</option>
                      <option> N O terhubung antara sumber gas dengan mesin anestesia.</option>
                      <option> Flow meter N O di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</option>

                    </select>
                  </div>



                  <div class="col-sm-11">

                    <label for="mesin_anestesia"> mesin anestesia:</label>

                    <select class="form-control" name="mesin_anestesia" required multiple>

                      <option>Power ON</option>
                      <option>Self collibration : DOME</option>
                      <option>Tidak ada kebocoran sirkuit jalan nafas</option>
                      <option>Zat volatil terisi</option>
                      <option>Absorber CO dalam kondisi baik</option>

                    </select>
                  </div>



                  <div class="col-sm-11">

                    <label for="manajemen_jalan_nafas"> manajemen_jalan_nafas:</label>

                    <select class="form-control" name="manajemen jalan_nafas" required multiple>

                      <option>Sungkup muka dalam ukuran yang benar.</option>
                      <option> Oropharygeal air way (Guedel) dalam ukuran yang benar.</option>
                      <option>Batang laringoskop berisi baterai.</option>
                      <option>Bilah laringoskop dalam ukuran yang benar.</option>
                      <option>Gagang dan bilah laringoskop berfungsi baik.</option>
                      <option>ETT atau LMA dalam ukuran yang benar, tidak bocor.</option>
                      <option> Stilent (introduser)</option>
                      <option>Semprit untuk mengembangkan cuff.</option>
                      <option>Forceps Magili</option>

                    </select>
                  </div>





                  <div class="col-sm-11">

                    <label for="pemantauan"> pemantauan:</label>

                    <select class="form-control" name="pemantauan" required multiple>

                      <option>Kabel EKG terhubung dengan layarpemantau.</option>
                      <option> Elektroda EKG dalam jumlah dan ukuran sesuai.</option>
                      <option> NIBP terhubung dengan layar pantau, ukuran manset sesuai.</option>
                      <option>SpO terhubung dengan layar pantau, berfungsi baik.</option>
                      <option> Kapnografi terhubung dengan layar pantau, berfungsi baik.</option>
                      <option> Pemantau suhu terhubung dengan layar pantau</option>

                    </select>
                  </div>




                  <div class="col-sm-11">

                    <label for="obat_obat"> obat obat:</label>

                    <select class="form-control" name="obat_obat" required multiple>

                      <option>Epinefrin</option>
                      <option>Atropin</option>
                      <option>Sedatif (midazolam / propofal / etomidat / ketamin / tiopental)</option>
                      <option>Opiat / opioid</option>
                      <option>Pelumpuh otot</option>
                      <option>Antibiotika</option>
                      <option>Lain-lain </option>

                    </select>
                  </div>



                  <div class="col-sm-11">

                    <label for="lain_lain"> lain-lain:</label>

                    <select class="form-control" name="lain_lain" required multiple>
                      <option>Stetoskop tersedia.</option>
                      <option>Suction berfungsi baik.</option>
                      <option> Selang suction terhubung, kateter suction dalam ukuran yang benar.</option>
                      <option>Plester untuk fiksasi.</option>
                      <option>Blanket roll / hemotherm / radiant heater terhubung sumber listrik, berfungsi baik.</option>
                      <option>Blanket roll dilapisi alas.</option>
                      <option>Lidocaine spray / jelly.</option>
                      <option>Defibrillator jelly.</option>


                    </select>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">

                      <label for="tgl_tindakan"> tanggal tindakan:</label>
                      <input type="text" class="form-control" id="tgl_tindakan" name='tgl_tindakan' required>
                    </div>
                    <div class="col">

                      <label for="penata_anesthesi"> penata anesthesi:</label>
                      <input type="text" class="form-control" id="penata_anesthesi" name='penata_anesthesi' required>
                    </div>



                    <div class="col">

                      <label for="dr_ahli_anesthesi"> dr ahli anesthesi:</label>
                      <input type="text" class="form-control" id="dr_ahli_anesthesi" name='dr_ahli_anesthesi' required>
                    </div>

                  </div>

                  <div class="col">


                    <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj ?>" required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel ?>" required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>
                  </div>



                  <div class="col">

                    <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?= $idUser ?>" required>
                  </div>

                  <br>
                  <div class='btn-group' style='float:right;'>

                    <a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle">Kembali</a>
                    &nbsp;
                    <input type='reset' value='Batal' class='btn btn-danger'>
                    &nbsp;
                    <input type='submit' name='insert' value='Save' class='btn btn-success'>
                    &nbsp; &nbsp;
                  </div>
                </form>
              </div>
            </div>
            <Br>
            <Br>
          </div>

        </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
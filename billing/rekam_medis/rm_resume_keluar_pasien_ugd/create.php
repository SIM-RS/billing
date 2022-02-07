<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input resume keluar pasien ugd </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input resume keluar pasien ugd</td>
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

                      <label for="tanggal_masuk"> tanggal masuk:</label>
                      <input type="date" class="form-control" id="tanggal_masuk" name='tanggal_masuk' required>
                    </div>



                    <div class="col">

                      <label for="tanggal_keluar"> tanggal keluar:</label>
                      <input type="date" class="form-control" id="tanggal_keluar" name='tanggal_keluar' required>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col">

                      <label for="keluhan_saat_masuk"> keluhan saat masuk:</label>

                      <textarea class="form-control" id="keluhan_saat_masuk" name='keluhan_saat_masuk' required></textarea>
                    </div>



                    <div class="col">

                      <label for="riwayat_alergi"> riwayat alergi:</label>

                      <textarea class="form-control" id="riwayat_alergi" name='riwayat_alergi' required></textarea>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">

                      <label for="pemeriksaan_fisik"> pemeriksaan fisik:</label>

                      <textarea class="form-control" id="pemeriksaan_fisik" name='pemeriksaan_fisik' required></textarea>
                    </div>




                    <div class="col">

                      <label for="pemeriksaan_fisik_bermakna"> pemeriksaan fisik bermakna:</label>

                      <textarea class="form-control" id="pemeriksaan_fisik_bermakna" name='pemeriksaan_fisik_bermakna' required></textarea>
                    </div>

                  </div>
                  <br>
                  <div class="row">
                    <label>Tanda vital :</label>
                    <div class="col">

                      <label for="bp"> Bp:</label>
                      <input type="text" class="form-control" id="bp" name='bp' placeholder="mmHg" required>
                    </div>



                    <div class="col">

                      <label for="nadi">Nadi:</label>
                      <input type="text" class="form-control" id="nadi" name='nadi' placeholder="x/mnt  " required>
                    </div>



                    <div class="col">

                      <label for="rr"> RR:</label>
                      <input type="text" class="form-control" id="rr" name='rr' placeholder="x/mnt" required>
                    </div>



                    <div class="col">

                      <label for="suhu"> Suhu:</label>
                      <input type="text" class="form-control" id="suhu" name='suhu' placeholder="C" required>
                    </div>


                    <label for="gcs_e"> GCS:</label>
                    <div class="col">

                      <label for="gcs_e"> E:</label>
                      <input type="text" class="form-control" id="gcs_e" name='gcs_e' required>
                    </div>



                    <div class="col">

                      <label for="gcs_v"> V:</label>
                      <input type="text" class="form-control" id="gcs_v" name='gcs_v' required>
                    </div>



                    <div class="col">

                      <label for="gcs_m"> M:</label>
                      <input type="text" class="form-control" id="gcs_m" name='gcs_m' required>
                    </div>

                  </div>
                  <br>
                  <div class="row">

                    <div class="col">

                      <label for="pemeriksaan_penunjang"> pemeriksaan penunjang:</label>
                      <textarea class="form-control" id="pemeriksaan_penunjang" name='pemeriksaan_penunjang' required></textarea>

                    </div>



                    <div class="col">

                      <label for="diagnosis"> diagnosis:</label>
                      <textarea class="form-control" id="diagnosis" name='diagnosis' required></textarea>

                    </div>

                  </div>

                  <div class="row">
                    <div class="col">

                      <label for="perkembangan_penyakit"> perkembangan penyakit:</label>
                      <select class="form-control" id="perkembangan_penyakit" name='perkembangan_penyakit' required multiple>
                        <option>Membaik</option>
                        <option>Stabil</option>
                        <option>Memburuk </option>
                        <option>Komplikasi</option>
                      </select>
                    </div>



                    <div class="col">

                      <label for="kondisi_pasien"> kondisi pasien:</label>
                      <select class="form-control" id="kondisi_pasien" name='kondisi_pasien' required multiple>
                        <option>Sembuh </option>
                        <option>Membaik </option>
                        <option>Tidak Sembuh </option>
                        <option>Meninggal < 48 jam </option> <option>Meninggal > 48 jam </option>
                      </select>
                    </div>

                  </div>

                  <div class="row">


                    <div class="col">

                      <label for="masalah"> masalah:</label>
                      <select class="form-control" id="masalah" name='masalah' required multiple>
                        <option>Fisik</option>
                        <option>Mental</option>
                      </select>
                    </div>



                    <div class="col">

                      <label for="cara_pulang"> cara pulang:</label>
                      <select class="form-control" id="cara_pulang" name='cara_pulang' required multiple>
                        <option>diperbolehkan pulang </option>
                        <option>Pulang Atas permintaan Sendiri (PAPS) </option>
                        <option>Obat dirumah </option>
                        <option>Kontrol ke poliklinik</option>
                        <option>Dirujuk</option>
                      </select>
                    </div>

                  </div>
                  <div class="col">

                    <label for="penyebab_langsung_kematian"> penyebab langsung kematian:</label>

                    <textarea class="form-control" id="penyebab_langsung_kematian" name='penyebab_langsung_kematian' required></textarea>
                  </div>

                  <div class="col">

                    <label for="nama_obat"> nama obat:</label>
                    <input type="text" class="form-control" id="nama_obat" name='nama_obat' required>
                  </div>



                  <div class="col">

                    <label for="dosis"> dosis:</label>
                    <input type="text" class="form-control" id="dosis" name='dosis' required>
                  </div>



                  <div class="col">

                    <label for="frekuensi"> frekuensi:</label>
                    <input type="text" class="form-control" id="frekuensi" name='frekuensi' required>
                  </div>



                  <div class="col">

                    <label for="nama_dokter"> nama dokter:</label>
                    <input type="text" class="form-control" id="nama dokter" name='nama_dokter' value="<?= $_SESSION['pegawai_nama'] ?>" required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj ?>" required>

                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel ?>" required>

                    <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>

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
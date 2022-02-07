<?php
require_once 'func.php';

$id = $_REQUEST['id'];
$one = GetOne($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Edit resume keluar pasien ugd </title>
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

  <div style="background-color: #EAF0F0 ; width: 1000px; margin: auto;">

    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
      <tbody>
        <tr>
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit resume keluar pasien ugd</td>
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

                  <input type='hidden' name='id' value="<?php echo $_POST['id']; ?>">
                  <?php
                  foreach ($one as $data) { ?>

                    <div class="row">
                      <div class="col">

                        <label for="tanggal_masuk"> tanggal masuk:</label>
                        <input type="text" class="form-control" id="tanggal_masuk" name='tanggal_masuk' value="<?php echo $data['tanggal_masuk']; ?>">
                      </div>



                      <div class="col">

                        <label for="tanggal_keluar"> tanggal keluar:</label>
                        <input type="text" class="form-control" id="tanggal_keluar" name='tanggal_keluar' value="<?php echo $data['tanggal_keluar']; ?>">
                      </div>
                    </div>

                    <div class="row">

                      <div class="col">

                        <label for="keluhan_saat_masuk"> keluhan saat masuk:</label>
                        <input type="text" class="form-control" id="keluhan_saat_masuk" name='keluhan_saat_masuk' value="<?php echo $data['keluhan_saat_masuk']; ?>">
                      </div>



                      <div class="col">

                        <label for="riwayat_alergi"> riwayat alergi:</label>
                        <input type="text" class="form-control" id="riwayat_alergi" name='riwayat_alergi' value="<?php echo $data['riwayat_alergi']; ?>">
                      </div>

                    </div>
                    <div class="row">
                      <div class="col">

                        <label for="pemeriksaan_fisik"> pemeriksaan fisik:</label>
                        <input type="text" class="form-control" id="pemeriksaan_fisik" name='pemeriksaan_fisik' value="<?php echo $data['pemeriksaan_fisik']; ?>">
                      </div>

                      <div class="col">

                        <label for="pemeriksaan_fisik_bermakna"> pemeriksaan fisik bermakna:</label>
                        <input type="text" class="form-control" id="pemeriksaan_fisik_bermakna" name='pemeriksaan_fisik_bermakna' value="<?php echo $data['pemeriksaan_fisik_bermakna']; ?>">
                      </div>

                    </div>
                    <br>

                    <div class="row">
                      <label>Tanda Vital:</label>
                      <div class="col">

                        <label for="bp"> bp:</label>
                        <input type="text" class="form-control" id="bp" name='bp' value="<?php echo $data['bp']; ?>">
                      </div>



                      <div class="col">

                        <label for="nadi"> nadi:</label>
                        <input type="text" class="form-control" id="nadi" name='nadi' value="<?php echo $data['nadi']; ?>">
                      </div>



                      <div class="col">

                        <label for="rr"> rr:</label>
                        <input type="text" class="form-control" id="rr" name='rr' value="<?php echo $data['rr']; ?>">
                      </div>



                      <div class="col">

                        <label for="suhu"> suhu:</label>
                        <input type="text" class="form-control" id="suhu" name='suhu' value="<?php echo $data['suhu']; ?>">
                      </div>

                      <label>GCS :</label>

                      <div class="col">

                        <label for="gcs_e"> E:</label>
                        <input type="text" class="form-control" id="gcs_e" name='gcs_e' value="<?php echo $data['gcs_e']; ?>">
                      </div>



                      <div class="col">

                        <label for="gcs_v"> V:</label>
                        <input type="text" class="form-control" id="gcs_v" name='gcs_v' value="<?php echo $data['gcs_v']; ?>">
                      </div>



                      <div class="col">

                        <label for="gcs_m"> M:</label>
                        <input type="text" class="form-control" id="gcs_m" name='gcs_m' value="<?php echo $data['gcs_m']; ?>">
                      </div>




                    </div>
                    <br>
                    <div class="row">

                      <div class="col">

                        <label for="pemeriksaan_penunjang"> pemeriksaan penunjang:</label>
                        <input type="text" class="form-control" id="pemeriksaan_penunjang" name='pemeriksaan_penunjang' value="<?php echo $data['pemeriksaan_penunjang']; ?>">
                      </div>



                      <div class="col">

                        <label for="diagnosis"> diagnosis:</label>
                        <input type="text" class="form-control" id="diagnosis" name='diagnosis' value="<?php echo $data['diagnosis']; ?>">
                      </div>

                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="perkembangan_penyakit"> perkembangan penyakit:</label>
                        <input type="text" class="form-control" id="perkembangan_penyakit" name='perkembangan_penyakit' value="<?php echo $data['perkembangan_penyakit']; ?>">
                      </div>



                      <div class="col">

                        <label for="kondisi_pasien"> kondisi pasien:</label>
                        <input type="text" class="form-control" id="kondisi_pasien" name='kondisi_pasien' value="<?php echo $data['kondisi_pasien']; ?>">
                      </div>






                      <div class="col">

                        <label for="masalah"> masalah:</label>
                        <input type="text" class="form-control" id="masalah" name='masalah' value="<?php echo $data['masalah']; ?>">
                      </div>



                      <div class="col">

                        <label for="cara_pulang"> cara pulang:</label>
                        <input type="text" class="form-control" id="cara_pulang" name='cara_pulang' value="<?php echo $data['cara_pulang']; ?>">
                      </div>
                    </div>

                    <div class="col">

                      <label for="penyebab_langsung_kematian"> penyebab langsung kematian:</label>
                      <input type="text" class="form-control" id="penyebab_langsung_kematian" name='penyebab_langsung_kematian' value="<?php echo $data['penyebab_langsung_kematian']; ?>">
                    </div>


                    <div class="col">

                      <label for="nama_obat"> nama obat:</label>
                      <input type="text" class="form-control" id="nama_obat" name='nama_obat' value="<?php echo $data['nama_obat']; ?>">
                    </div>



                    <div class="col">

                      <label for="dosis"> dosis:</label>
                      <input type="text" class="form-control" id="dosis" name='dosis' value="<?php echo $data['dosis']; ?>">
                    </div>



                    <div class="col">

                      <label for="frekuensi"> frekuensi:</label>
                      <input type="text" class="form-control" id="frekuensi" name='frekuensi' value="<?php echo $data['frekuensi']; ?>">
                    </div>



                    <div class="col">

                      <label for="nama_dokter"> nama dokter:</label>
                      <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' value="<?php echo $data['nama_dokter']; ?>">
                    </div>



                    <div class="col">


                      <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">

                      <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">

                      <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">

                      <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?php echo $data['id_user']; ?>">
                    </div>


                  <?php } ?>

                  <br>
                  <div class='btn-group' style='float:right;'>

                    <a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle">Kembali</a>
                    &nbsp;
                    <input type='reset' value='Batal' class='btn btn-danger'>
                    &nbsp;
                    <input type='submit' name='update' value='Edit' class='btn btn-warning'>
                    &nbsp; &nbsp;
                  </div>
                </form>
              </div>
            </div>
            <br> <br>
          </div>

        </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
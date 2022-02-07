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
  <title> Form Edit pemantauan anestesi lokal </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit pemantauan anestesi lokal</td>
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
                    <h5>Pra Bedah</h5>
                    <div class="row">
                      <div class="col">

                        <label for="tanggal_tindakan"> tanggal_tindakan:</label>
                        <input type="text" class="form-control" id="tanggal_tindakan" name='tanggal_tindakan' value="<?php echo $data['tanggal_tindakan']; ?>">
                      </div>



                      <div class="col">

                        <label for="diagnosa"> diagnosa:</label>
                        <input type="text" class="form-control" id="diagnosa" name='diagnosa' value="<?php echo $data['diagnosa']; ?>">
                      </div>


                      <div class="col">

                        <label for="pembuat_laporan"> pembuat_laporan:</label>
                        <input type="text" class="form-control" id="pembuat_laporan" name='pembuat_laporan' value="<?php echo $data['pembuat_laporan']; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">

                        <label for="nama_tindakan"> nama_tindakan:</label>
                        <input type="text" class="form-control" id="nama_tindakan" name='nama_tindakan' value="<?php echo $data['nama_tindakan']; ?>">
                      </div>



                      <div class="col">

                        <label for="pembedah"> pembedah:</label>
                        <input type="text" class="form-control" id="pembedah" name='pembedah' value="<?php echo $data['pembedah']; ?>">
                      </div>



                      <div class="col">

                        <label for="ruang_poli"> ruang_poli:</label>
                        <input type="text" class="form-control" id="ruang_poli" name='ruang_poli' value="<?php echo $data['ruang_poli']; ?>">
                      </div>
                    </div>
                    <hr>
                    <div class="row">

                      <div class="col">

                        <label for="riwayat_penyakit"> riwayat_penyakit:</label>
                        <input type="text" class="form-control" id="riwayat_penyakit" name='riwayat_penyakit' value="<?php echo $data['riwayat_penyakit']; ?>">
                      </div>



                      <div class="col">

                        <label for="riwayat_alergi"> riwayat_alergi:</label>
                        <input type="text" class="form-control" id="riwayat_alergi" name='riwayat_alergi' value="<?php echo $data['riwayat_alergi']; ?>">
                      </div>
                    </div>
                    <hr>
                    <h5>PEMANTAUAN STATUS FISIOLOGIS</h5>
                    <div class="row">
                      <div class="col">

                        <label for="tanggal"> tanggal:</label>
                        <input type="text" class="form-control" id="tanggal" name='tanggal' value="<?php echo $data['tanggal']; ?>">
                      </div>



                      <div class="col">

                        <label for="jam"> jam:</label>
                        <input type="text" class="form-control" id="jam" name='jam' value="<?php echo $data['jam']; ?>">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">

                        <label for="kesadaran"> kesadaran:</label>
                        <input type="text" class="form-control" id="kesadaran" name='kesadaran' value="<?php echo $data['kesadaran']; ?>">
                      </div>



                      <div class="col">

                        <label for="td"> td:</label>
                        <input type="text" class="form-control" id="td" name='td' value="<?php echo $data['td']; ?>">
                      </div>



                      <div class="col">

                        <label for="nadi"> nadi:</label>
                        <input type="text" class="form-control" id="nadi" name='nadi' value="<?php echo $data['nadi']; ?>">
                      </div>

                      <div class="col">

                        <label for="respirasi"> respirasi:</label>
                        <input type="text" class="form-control" id="respirasi" name='respirasi' value="<?php echo $data['respirasi']; ?>" required>
                      </div>


                      <div class="col">

                        <label for="suhu"> suhu:</label>
                        <input type="text" class="form-control" id="suhu" name='suhu' value="<?php echo $data['suhu']; ?>">
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="obat_obatan"> obat_obatan:</label>
                        <input type="text" class="form-control" id="obat_obatan" name='obat_obatan' value="<?php echo $data['obat_obatan']; ?>">
                      </div>



                      <div class="col">

                        <label for="cairan"> cairan:</label>
                        <input type="text" class="form-control" id="cairan" name='cairan' value="<?php echo $data['cairan']; ?>">
                      </div>



                      <div class="col">

                        <label for="keterangan"> keterangan:</label>
                        <input type="text" class="form-control" id="keterangan" name='keterangan' value="<?php echo $data['keterangan']; ?>">
                      </div>
                    </div>
                    <hr>
                    <h5>PASKA BEDAH</h5>
                    <div class="row">

                      <div class="col">

                        <label for="paska_bedah_kesadaran"> paska_bedah_kesadaran:</label>
                        <input type="text" class="form-control" id="paska_bedah_kesadaran" name='paska_bedah_kesadaran' value="<?php echo $data['paska_bedah_kesadaran']; ?>">
                      </div>



                      <div class="col">

                        <label for="paska_bedah_tekanan_darah"> paska_bedah_tekanan_darah:</label>
                        <input type="text" class="form-control" id="paska_bedah_tekanan_darah" name='paska_bedah_tekanan_darah' value="<?php echo $data['paska_bedah_tekanan_darah']; ?>">
                      </div>



                      <div class="col">

                        <label for="paska_bedah_nadi"> paska_bedah_nadi:</label>
                        <input type="text" class="form-control" id="paska_bedah_nadi" name='paska_bedah_nadi' value="<?php echo $data['paska_bedah_nadi']; ?>">
                      </div>



                      <div class="col">

                        <label for="paska_bedah_respirasi"> paska_bedah_respirasi:</label>
                        <input type="text" class="form-control" id="paska_bedah_respirasi" name='paska_bedah_respirasi' value="<?php echo $data['paska_bedah_respirasi']; ?>">
                      </div>



                      <div class="col">

                        <label for="paska_bedah_suhu"> paska_bedah_suhu:</label>
                        <input type="text" class="form-control" id="paska_bedah_suhu" name='paska_bedah_suhu' value="<?php echo $data['paska_bedah_suhu']; ?>">
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="paska_bedah_reaksi_alergi"> paska_bedah_reaksi_alergi:</label>
                        <input type="text" class="form-control" id="paska_bedah_reaksi_alergi" name='paska_bedah_reaksi_alergi' value="<?php echo $data['paska_bedah_reaksi_alergi']; ?>">
                      </div>



                      <div class="col">

                        <label for="komplikasi_lain"> komplikasi_lain:</label>
                        <input type="text" class="form-control" id="komplikasi_lain" name='komplikasi_lain' value="<?php echo $data['komplikasi_lain']; ?>">
                      </div>
                    </div>



                    <hr>

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
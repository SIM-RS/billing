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
  <title> Form Edit Checklist Rencana Pulang</title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM EDIT Checklist Rencana Pulang</td>
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
                        <label for="aktifitas"> aktifitas:</label>
                        <input type="text" class="form-control" id="aktifitas" name='aktifitas' value="<?php echo $data['aktifitas']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_aktifitas"><?php echo $data['catatan_aktifitas']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="pemberian_obat_dirumah"> pemberian obat dirumah:</label>
                        <input type="text" class="form-control" id="pemberian_obat_dirumah" name='pemberian_obat_dirumah' value="<?php echo $data['pemberian_obat_dirumah']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_pemberian_obat_dirumah"><?php echo $data['catatan_pemberian_obat_dirumah']; ?></textarea>
                      </div>
                    </div><br>
                    <div class="row">

                      <div class="col">
                        <label for="fasilitas_kesehatan"> fasilitas kesehatan:</label>
                        <input type="text" class="form-control" id="fasilitas_kesehatan" name='fasilitas_kesehatan' value="<?php echo $data['fasilitas_kesehatan']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_fasilitas_kesehatan"><?php echo $data['catatan_fasilitas_kesehatan']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="hasil_pemeriksaan_penunjang"> hasil pemeriksaan penunjang:</label>
                        <input type="text" class="form-control" id="hasil_pemeriksaan_penunjang" name='hasil_pemeriksaan_penunjang' value="<?php echo $data['hasil_pemeriksaan_penunjang']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_hasil_pemeriksaan_penunjang"><?php echo $data['catatan_hasil_pemeriksaan_penunjang']; ?></textarea>
                      </div>

                    </div><br>
                    <div class="row">

                      <div class="col">
                        <label for="kontrol_selanjutnya"> kontrol selanjutnya:</label>
                        <input type="text" class="form-control" id="kontrol_selanjutnya" name='kontrol_selanjutnya' value="<?php echo $data['kontrol_selanjutnya']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_kontrol_selanjutnya"><?php echo $data['catatan_kontrol_selanjutnya']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="diet"> diet:</label>
                        <input type="text" class="form-control" id="diet" name='diet' value="<?php echo $data['diet']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_diet"><?php echo $data['diet']; ?></textarea>
                      </div>

                    </div>
                    <br>
                    <div class="row">

                      <div class="col">
                        <label for="edukasi_dan_latihan"> edukasi dan latihan:</label>
                        <input type="text" class="form-control" id="edukasi_dan_latihan" name='edukasi_dan_latihan' value="<?php echo $data['edukasi_dan_latihan']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_edukasi_dan_latihan"><?php echo $data['catatan_edukasi_dan_latihan']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="rincian_pemulangan"> rincian pemulangan:</label>
                        <input type="text" class="form-control" id="rincian_pemulangan" name='rincian_pemulangan' value="<?php echo $data['rincian_pemulangan']; ?>">
                        <br>
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan_rincian_pemulangan"><?php echo $data['catatan_rincian_pemulangan']; ?></textarea>
                      </div>
                    </div>

                    <div class="form-group">

                      <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">


                      <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">

                      <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">
                    </div>

                  <?php } ?>

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
    </div>
    </section><!-- /.content -->
  </div>
</body>

</html>
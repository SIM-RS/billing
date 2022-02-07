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
  <title> FORM EDIT PENOLAKAN TINDAKAN KEDOKTERAN / OPERASI </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM EDIT PENOLAKAN TINDAKAN KEDOKTERAN / OPERASI</td>
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
                        <label for="dokter_pelaksana_tindakan"> dokter pelaksana tindakan:</label>
                        <input type="text" class="form-control" id="dokter_pelaksana_tindakan" name='dokter_pelaksana_tindakan' value="<?php echo $data['dokter_pelaksana_tindakan']; ?>">
                      </div>


                      <div class="col">
                        <label for="pemberi_informasi"> pemberi informasi:</label>
                        <input type="text" class="form-control" id="pemberi_informasi" name='pemberi_informasi' value="<?php echo $data['pemberi_informasi']; ?>">
                      </div>


                      <div class="col">
                        <label for="penerima_informasi"> penerima informasi:</label>
                        <input type="text" class="form-control" id="penerima_informasi" name='penerima_informasi' value="<?php echo $data['penerima_informasi']; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="diagnosis_wd_dan_dd"> diagnosis wd dan dd:</label>


                        <textarea class="form-control" id="diagnosis_wd_dan_dd" name='diagnosis_wd_dan_dd'><?php echo $data['diagnosis_wd_dan_dd']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="dasar_diagnosis"> dasar diagnosis:</label>

                        <textarea class="form-control" id="dasar_diagnosis" name='dasar_diagnosis'><?php echo $data['dasar_diagnosis']; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="tindakan_kedokteran"> tindakan kedokteran:</label>

                        <textarea class="form-control" id="tindakan_kedokteran" name='tindakan_kedokteran'><?php echo $data['tindakan_kedokteran']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="indikasi_tindakan"> indikasi tindakan:</label>

                        <textarea class="form-control" id="indikasi_tindakan" name='indikasi_tindakan'><?php echo $data['indikasi_tindakan']; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="tata_cara"> tata cara:</label>

                        <textarea class="form-control" id="tata_cara" name='tata_cara'><?php echo $data['tata_cara']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="tujuan"> tujuan:</label>

                        <textarea class="form-control" id="tujuan" name='tujuan'><?php echo $data['tujuan']; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="risiko"> risiko:</label>

                        <textarea class="form-control" id="risiko" name='risiko'><?php echo $data['risiko']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="komplikasi"> komplikasi:</label>

                        <textarea class="form-control" id="komplikasi" name='komplikasi'><?php echo $data['komplikasi']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="prognosis"> prognosis:</label>

                        <textarea class="form-control" id="prognosis" name='prognosis'><?php echo $data['prognosis']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="alternatif_risiko"> alternatif risiko:</label>

                        <textarea class="form-control" id="alternatif_risiko" name='alternatif_risiko'><?php echo $data['alternatif_risiko']; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="lain_lain"> lain lain:</label>

                        <TEXTAREA class="form-control" id="lain_lain" name='lain_lain' required><?php echo $data['lain_lain']; ?></TEXTAREA>
                      </div>
                    </div>
              </div>

              <div class="form-group">

                <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">

                <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">

                <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">




                <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?php echo $data['id_user']; ?>">
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
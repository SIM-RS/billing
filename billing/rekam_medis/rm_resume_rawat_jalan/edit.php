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
  <title> Form Edit Resume Rawat Jalan </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit Resume Rawat Jalan</td>
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
                        <label for="tgl_resume"> Tanggal Resume:</label>
                        <input type="text" class="form-control" id="tgl_resume" name='tgl_resume' value="<?php echo $data['tgl_resume']; ?>">
                      </div>


                      <div class="col">
                        <label for="resume"> Tindakan :</label>
                        <input type="text" class="form-control" id="resume" name='resume' value="<?php echo $data['resume']; ?>">
                      </div>


                      <div class="col">
                        <label for="alergi_resume"> Alergi:</label>
                        <input type="text" class="form-control" id="alergi_resume" name='alergi_resume' value="<?php echo $data['alergi_resume']; ?>">
                      </div>

                    </div>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col">
                        <label for="tgl_kunjungan"> Tanggal Kunjugan:</label>
                        <input type="text" class="form-control" id="tgl_kunjungan" name='tgl_kunjungan' value="<?php echo $data['tgl_kunjungan']; ?>">
                      </div>

                      <div class="col">
                        <label for="diagnosis_kunjungan"> Klinik / Nama Dokter:</label>
                        <input type="text" class="form-control" id="klinik_dokter" name='klinik_dokter' placeholder='klinik_dokter' value="<?php echo $data['klinik_dokter']; ?>" required>
                      </div>


                      <div class="col">
                        <label for="diagnosis_kunjungan"> Diagnosis:</label>
                        <input type="text" class="form-control" id="diagnosis_kunjungan" name='diagnosis_kunjungan' value="<?php echo $data['diagnosis_kunjungan']; ?>">
                      </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                      <div class="col">
                        <label for="terapi_kunjungan">Terapi:</label>
                        <input type="text" class="form-control" id="terapi_kunjungan" name='terapi_kunjungan' value="<?php echo $data['terapi_kunjungan']; ?>">
                      </div>


                      <div class="col">
                        <label for="ttd_nama_perawat">Nama Perawat:</label>
                        <input type="text" class="form-control" id="ttd_nama_perawat" name='ttd_nama_perawat' value="<?php echo $data['ttd_nama_perawat']; ?>">
                      </div>


                      <div class="col">
                        <label for="verifikasi_ttd_dpjp"> Verifikasi DPJP:</label>
                        <input type="text" class="form-control" id="verifikasi_ttd_dpjp" name='verifikasi_ttd_dpjp' value="<?php echo $data['verifikasi_ttd_dpjp']; ?>">
                      </div>
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
              <br> <br>
            </div>
          </div>
        </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
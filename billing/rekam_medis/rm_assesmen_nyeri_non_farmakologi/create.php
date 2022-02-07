<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Assesmen Nyeri Farmakologi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input Assesmen Nyeri Farmakologi</td>
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
                  <div class="col">
                    <div class="row">
                      <div class="col">
                        <label for="ruangan"> ruangan:</label>
                        <input type="text" class="form-control" id="ruangan" name='ruangan' placeholder='ruangan' required>
                      </div>


                      <div class="col">
                        <label for="regio"> regio sebutkan tempatnya:</label>
                        <input type="text" class="form-control" id="regio" name='regio' placeholder='regio sebutkan tempatnya' required>
                      </div>

                      <div class="col">
                        <label for="severity"> severity:</label>
                        <input type="number" class="form-control" id="severity" name='severity' placeholder='severity' max="10" maxlength="10" required>
                      </div>



                    </div>
                    <br><br>
                    <div class="row">
                      <div class="col">
                        <label for="provokatif"> provokatif:</label>

                        <select class="form-control" id="provokatif" name='provokatif' placeholder='provokatif' required>
                          <option value="">Provokatif</option>
                          <option value='1'>Luka</option>
                          <option value='2'>Trauma</option>
                          <option value='3'>Lainnya sebutkan</option>

                        </select>
                      </div>
                      <div class="col">
                        <label for="quality"> quality:</label>

                        <select class="form-control" id="quality" name='quality' placeholder='quality' required>
                          <option value="">Quality</option>
                          <option value="1">Terbakar</option>
                          <option value="2">Tertusuk</option>
                          <option value="3">Tertekan</option>
                          <option value="4">Kram</option>
                          <option value="5">Berat</option>
                          <option value="6">Lainnya sebutkan</option>

                        </select>
                      </div>
                      <div class="col">
                        <label for="tempo"> tempo:</label>

                        <select class="form-control" id="tempo" name='tempo' placeholder='tempo' required>
                          <option value="">Tempo</option>
                          <option value="1">Jarang</option>
                          <option value="2">Hilang timbul</option>
                          <option value="3">Terus menerus</option>

                        </select>
                      </div>

                      <div class="col">
                        <label for="tindakan_lanjut"> tindakan lanjut:</label>

                        <select class="form-control" id="tindakan_lanjut" name='tindakan_lanjut' placeholder='tindakan_lanjut' required>
                          <option value="">Tindakan Lanjut</option>
                          <option value="1">Distraksi</option>
                          <option value="2">Relaksasi</option>
                          <option value="3">Terapi Musik</option>
                          <option value="4">Massage/Pijatan</option>
                          <option value="5">Guided Imaginary</option>

                        </select>
                      </div>

                    </div>

                    <div class="form-group">

                      <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' placeholder='id_kunjungan' value="<?= $idKunj ?>" required>

                      <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' placeholder='id_pelayanan' value="<?= $idPel ?>" required>

                      <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' placeholder='id_pasien' value="<?= $idPasien ?>" required>
                    </div>
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
    </div>
    </section><!-- /.content -->
  </div>
</body>

</html>
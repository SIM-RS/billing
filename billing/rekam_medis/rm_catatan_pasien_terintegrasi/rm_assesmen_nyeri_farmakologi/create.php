<?php
require_once 'func.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Assesmen Farmakologi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input Assesmen Farmakologi</td>
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

                  <div class='row'>
                    <div class="col">
                      <label for="ruangan"> Ruangan:</label>
                      <input type="text" class="form-control" id="ruangan" name='ruangan' required>
                    </div>
                    <div class="col">
                      <label for="intervensi_yang_diberikan"> intervensi yang diberikan:</label>
                      <input type="text" class="form-control" id="intervensi_yang_diberikan" name='intervensi_yang_diberikan' required>
                    </div>
                  </div>

                  <br><br>

                  <div class='row'>
                    <div class="col">
                      <label for="skala_nyeri_pertama"> skala nyeri pertama:</label>

                      <select required="" class="custom-select" name='skala_nyeri_pertama' multiple>

                        <option value="0">Tidak Sakit</option>
                        <option value="2">Sedikit Sakit</option>
                        <option value="4">Agak Menggangu </option>
                        <option value="6">Menggangu Aktivitas</option>
                        <option value="8">Sangat Menggangu</option>
                        <option value="10">Tidak Tertahankan</option>
                      </select>
                    </div>





                    <div class="col">
                      <label for="skala_nyeri_kedua"> skala nyeri kedua:</label>
                      <select required="" class="custom-select" name='skala_nyeri_kedua' multiple>

                        <option value="0">Tidak Sakit</option>
                        <option value="2">Sedikit Sakit</option>
                        <option value="4">Agak Menggangu </option>
                        <option value="6">Menggangu Aktivitas</option>
                        <option value="8">Sangat Menggangu</option>
                        <option value="10">Tidak Tertahankan</option>
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
              <Br>
              <Br>
            </div>
          </div>
        </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
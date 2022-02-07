<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input General Consent </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input General Consent</td>
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


                  <h5> WALI HUKUM HARUS MENGISI INFORMASI BERIKUT :
                  </h5>
                  <div class="col">

                    <label for="nama"> Nama:</label>
                    <input type="text" class="form-control" id="nama" name='nama' required>
                  </div>



                  <div class="col">

                    <label for="alamat"> Alamat:</label>
                    <input type="text" class="form-control" id="alamat" name='alamat' required>
                  </div>



                  <div class="col">

                    <label for="hubungan_pasien"> Hubungan pasien:</label>
                    <input type="text" class="form-control" id="hubungan_pasien" name='hubungan_pasien' required>
                  </div>



                  <div class="col">

                    <label for="no_telp"> No Telpon:</label>
                    <input type="text" class="form-control" id="no_telp" name='no_telp' required>
                  </div>



                  <div class="col">

                    <label for="no_identitas"> No identitas:</label>
                    <input type="text" class="form-control" id="no_identitas" name='no_identitas' required>
                  </div>



                  <div class="col">

                    <label for="hasil_diagnosis"> Hasil diagnosis:</label>

                    <textarea class="form-control" id="hasil_diagnosis" name='hasil_diagnosis' required></textarea>
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
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
  <title> Form Edit lokasi penandaan operasi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit lokasi penandaan operasi </td>
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


                    <div class="form-group">
                      <label for="prosedur"> prosedur:</label>
                      <input type="text" class="form-control" id="prosedur" name='prosedur' value="<?php echo $data['prosedur']; ?>">
                    </div>


                    <div class="form-group">
                      <label for="tanggal_prosedur"> tanggal prosedur:</label>
                      <input type="text" class="form-control" id="tanggal_prosedur" name='tanggal_prosedur' value="<?php echo $data['tanggal_prosedur']; ?>">
                    </div>


                    <div class="form-group">
                      <label for="nama_pasien"> Nama Pasien:</label>
                      <input type="text" class="form-control" id="nama_pasien" name='nama_pasien' value="<?php echo $data['nama_pasien']; ?>">
                    </div>


                    <div class="form-group">
                      <label for="nama_dokter"> Nama Dokter:</label>
                      <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' value="<?php echo $data['nama_dokter']; ?>">
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
                    <input type='submit' value='Batal' class='btn btn-danger'> &nbsp;
                    <input type='submit' name='update' value='Edit' class='btn btn-warning'>
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
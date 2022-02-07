<?php
require_once 'func.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Checklist Rencana Pulang </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM Checklist Rencana Pulang</td>
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


                  <div class="btn-group">

                    <a href='create.php?idKunj=<?= $idKunj ?>&idPel=<?= $idPel ?>&idPasien=<?= $idPasien ?>&idUser=<?= $idUser ?>' class='btn btn-primary' style="color: white;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/edit_add.png" width="20" align="absmiddle">Tambah</a>

                  </div>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class='container-fluid'>


                <?php
                if (!empty($_SESSION['message'])) { ?>
                  <div class="row">
                    <div class="col">
                      <div class="alert alert-<?php echo $_SESSION['mType']; ?> alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Notif !</strong> <?php echo $_SESSION['message']; ?>
                      </div>
                    </div>
                  </div>
                  <?php unset($_SESSION['message']);
                  unset($_SESSION['mType']); ?>
                <?php } ?>

                <br>
                <div class='table-responsive'>
                  <table class='table table-hover table-bordered table-striped' style='background-color: white;'>
                    <thead>
                      <tr align="center">
                        <th>No</th>
                        <th>aktifitas</th>
                        <th>pemberian obat</th>
                        <th>fasilitas kesehatan</th>
                        <th>pemeriksaan penunjang</th>
                        <th>kontrol selanjutnya</th>



                        <th colspan='2'>Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $getall = GetAll($idKunj, $idPasien);
                      $no = 1;
                      if (isset($getall)) {
                        foreach ($getall as $data) {
                          echo "<tr align='center'>";
                          echo "<td>" . $no++ . "</td>";
                          echo "<td>" . $data['aktifitas'] . "</td>";
                          echo "<td>" . $data['pemberian_obat_dirumah'] . "</td>";
                          echo "<td>" . $data['fasilitas_kesehatan'] . "</td>";
                          echo "<td>" . $data['hasil_pemeriksaan_penunjang'] . "</td>";
                          echo "<td>" . $data['kontrol_selanjutnya'] . "</td>";



                          echo "<td>
                <div class='btn-group'>
                <form method='POST' action='edit.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser'>
                <input type='hidden' name='id' value='" . $data['id'] . "'>
                <input type='submit' name='edit' Value='Edit' class='btn btn-warning'>
                </form>
                &nbsp;
                <form method='POST' action='func.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser'>
                <input type='hidden' name='id' value='" . $data['id'] . "'>
                <input type='submit' name='delete' Value='Delete' class='btn btn-danger' onclick=\"return confirm('Kamu Yakin akan menghapus data ini ?')\">

                     </form>
                     &nbsp;
                <form method='POST' action='print.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser'>
                <input type='hidden' name='id' value='" . $data['id'] . "'>
                <input type='submit' name='print' Value='Print' class='btn btn-info '>
                     </form>

              
              
                </form>
                  </div>
              </td>";
                        }
                      }
                      ?>


                    </tbody>
                  </table>

                </div>

              </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
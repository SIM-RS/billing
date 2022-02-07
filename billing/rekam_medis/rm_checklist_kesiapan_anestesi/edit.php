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
  <title> Form Edit CHECK LIST KESIAPAN ANESTESI </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM EDIT CHECK LIST KESIAPAN ANESTESI</td>
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

                        <label for="ruangan"> ruangan:</label>
                        <input type="text" class="form-control" id="ruangan" name='ruangan' value="<?php echo $data['ruangan']; ?>">
                      </div>



                      <div class="col">

                        <label for="diagnosis"> diagnosis:</label>
                        <input type="text" class="form-control" id="diagnosis" name='diagnosis' value="<?php echo $data['diagnosis']; ?>">
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="jenis_operasi"> jenis operasi:</label>
                        <input type="text" class="form-control" id="jenis_operasi" name='jenis_operasi' value="<?php echo $data['jenis_operasi']; ?>">
                      </div>



                      <div class="col">

                        <label for="teknik_anesthesi"> teknik anesthesi:</label>
                        <input type="text" class="form-control" id="teknik_anesthesi" name='teknik_anesthesi' value="<?php echo $data['teknik_anesthesi']; ?>">
                      </div>

                    </div>


                    <br>

                    <div class="col">

                      <label for="listrik"> listrik:</label>
                      <input type="text" class="form-control" id="listrik" name='listrik' value="<?php echo $data['listrik']; ?>">
                    </div>



                    <div class="col">

                      <label for="gas_medis"> gas medis:</label>
                      <input type="text" class="form-control" id="gas_medis" name='gas_medis' value="<?php echo $data['gas_medis']; ?>">
                    </div>



                    <div class="col">

                      <label for="mesin_anestesia"> mesin anestesia:</label>
                      <input type="text" class="form-control" id="mesin_anestesia" name='mesin_anestesia' value="<?php echo $data['mesin_anestesia']; ?>">
                    </div>



                    <div class="col">

                      <label for="manajemen_jalan_nafas"> manajemen jalan nafas:</label>
                      <input type="text" class="form-control" id="manajemen_jalan_nafas" name='manajemen_jalan_nafas' value="<?php echo $data['manajemen_jalan_nafas']; ?>">
                    </div>



                    <div class="col">

                      <label for="pemantauan"> pemantauan:</label>
                      <input type="text" class="form-control" id="pemantauan" name='pemantauan' value="<?php echo $data['pemantauan']; ?>">
                    </div>



                    <div class="col">

                      <label for="lain_lain"> lain-lain:</label>
                      <input type="text" class="form-control" id="lain_lain" name='lain_lain' value="<?php echo $data['lain_lain']; ?>">
                    </div>



                    <div class="col">

                      <label for="obat_obat"> obat obat:</label>
                      <input type="text" class="form-control" id="obat_obat" name='obat_obat' value="<?php echo $data['obat_obat']; ?>">
                    </div>
                    <br>
                    <div class="row">
                      <div class="col">

                        <label for="tgl_tindakan"> tgl tindakan:</label>
                        <input type="text" class="form-control" id="tgl_tindakan" name='tgl_tindakan' value="<?php echo $data['tgl_tindakan']; ?>">
                      </div>

                      <div class="col">

                        <label for="penata_anesthesi"> penata anesthesi:</label>
                        <input type="text" class="form-control" id="penata_anesthesi" name='penata_anesthesi' value="<?php echo $data['penata_anesthesi']; ?>">
                      </div>



                      <div class="col">

                        <label for="dr_ahli_anesthesi"> dr ahlianesthesi:</label>
                        <input type="text" class="form-control" id="dr_ahli_anesthesi" name='dr_ahli_anesthesi' value="<?php echo $data['dr_ahli_anesthesi']; ?>">
                      </div>

                    </div>

                    <div class="col">


                      <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">
                    </div>



                    <div class="col">


                      <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">
                    </div>



                    <div class="col">


                      <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">
                    </div>



                    <div class="col">


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
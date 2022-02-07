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
  <title> Form Edit permintaan laboratorium </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit permintaan laboratorium</td>
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

                        <label for="klinis">klinis:</label>
                        <input type="text" class="form-control" id="klinis" name='klinis' value="<?php echo $data['klinis']; ?>">
                      </div>

                      <div class="col">

                        <label for="diagnosis"> diagnosis:</label>
                        <input type="text" class="form-control" id="diagnosis" name='diagnosis' value="<?php echo $data['diagnosis']; ?>">
                      </div>

                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="darah_rutin"> darah rutin:</label>
                        <input type="text" class="form-control" id="darah_rutin" name='darah_rutin' value="<?php echo $data['darah_rutin']; ?>">
                      </div>
                      <div class="col">

                        <label for="anemia_profile"> anemia profile:</label>
                        <input type="text" class="form-control" id="anemia_profile" name='anemia_profile' value="<?php echo $data['anemia_profile']; ?>">
                      </div>
                    </div>
                    <div class="row">


                      <div class="col">

                        <label for="haemorrhagic_test"> haemorrhagic test:</label>
                        <input type="text" class="form-control" id="haemorrhagic_test" name='haemorrhagic_test' value="<?php echo $data['haemorrhagic_test']; ?>">
                      </div>



                      <div class="col">

                        <label for="faal_hati"> faal hati:</label>
                        <input type="text" class="form-control" id="faal_hati" name='faal_hati' value="<?php echo $data['faal_hati']; ?>">
                      </div>

                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="faal_ginjal"> faal ginjal:</label>
                        <input type="text" class="form-control" id="faal_ginjal" name='faal_ginjal' value="<?php echo $data['faal_ginjal']; ?>">
                      </div>



                      <div class="col">

                        <label for="metabolisme_karbohidra"> metabolisme karbohidra:</label>
                        <input type="text" class="form-control" id="metabolisme_karbohidra" name='metabolisme_karbohidra' value="<?php echo $data['metabolisme_karbohidra']; ?>">
                      </div>
                    </div>
                    <div class="row">


                      <div class="col">

                        <label for="urine"> urine:</label>
                        <input type="text" class="form-control" id="urine" name='urine' value="<?php echo $data['urine']; ?>">
                      </div>



                      <div class="col">

                        <label for="thyroid"> thyroid:</label>
                        <input type="text" class="form-control" id="thyroid" name='thyroid' value="<?php echo $data['thyroid']; ?>">
                      </div>

                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="lipid_profile"> lipid profile:</label>
                        <input type="text" class="form-control" id="lipid_profile" name='lipid_profile' value="<?php echo $data['lipid_profile']; ?>">
                      </div>


                      <div class="col">

                        <label for="arthritis_profile"> arthritis profile:</label>
                        <input type="text" class="form-control" id="arthritis_profile" name='arthritis_profile' value="<?php echo $data['arthritis_profile']; ?>" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">

                        <label for="elektrolit"> elektrolit:</label>
                        <input type="text" class="form-control" id="elektrolit" name='elektrolit' value="<?php echo $data['elektrolit']; ?>">
                      </div>



                      <div class="col">

                        <label for="feces"> feces:</label>
                        <input type="text" class="form-control" id="feces" name='feces' value="<?php echo $data['feces']; ?>">
                      </div>
                    </div>
                    <div class="row">


                      <div class="col">

                        <label for="pancreas"> pancreas:</label>
                        <input type="text" class="form-control" id="pancreas" name='pancreas' value="<?php echo $data['pancreas']; ?>">
                      </div>



                      <div class="col">

                        <label for="myocard_infarct"> myocard infarct:</label>
                        <input type="text" class="form-control" id="myocard_infarct" name='myocard_infarct' value="<?php echo $data['myocard_infarct']; ?>">
                      </div>

                    </div>
                    <div class="row">

                      <div class="col">

                        <label for="vd_profile"> vd profile:</label>
                        <input type="text" class="form-control" id="vd_profile" name='vd_profile' value="<?php echo $data['vd_profile']; ?>">
                      </div>



                      <div class="col">

                        <label for="lain_lain"> lain lain:</label>
                        <input type="text" class="form-control" id="lain_lain" name='lain_lain' value="<?php echo $data['lain_lain']; ?>">
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
            </div>
            <br> <br>
          </div>

        </div>
      </section><!-- /.content -->
    </div>
</body>

</html>
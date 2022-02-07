<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Permintaan Laboratorium </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input permintaan laboratorium</td>
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

                  <div class="row">
                    <div class="col">

                      <label for="klinis">klinis:</label>
                      <input type="text" class="form-control" id="klinis" name='klinis' required>
                    </div>

                    <div class="col">

                      <label for="diagnosis"> diagnosis:</label>
                      <input type="text" class="form-control" id="diagnosis" name='diagnosis' required>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col">

                      <label for="darah_rutin"> darah rutin:</label>

                      <select class="form-control" name='darah_rutin' required multiple>

                        <option>Hb</option>
                        <option>LED</option>
                        <option>Hitung jenis</option>
                        <option>Leuko</option>
                        <option>Ery</option>
                        <option>Morfologi</option>
                        <option> Trombosit</option>

                      </select>
                    </div>
                    <div class="col">

                      <label for="anemia_profile"> anemia profile:</label>

                      <select class="form-control" name='anemia_profile' required multiple>

                        <option>HaematokritOsmotic fragility
                        <option>Retikulosit </option>
                        <option>Serum Ion & TIBC </option>
                        <option>Hb Electroforese (thalasemia) </option>
                        <option>Sumsum tulang </option>
                        <option>Coomb’s test</option>
                        <option>Rhesus faktor</option>
                        <option>Golongan darah ABO</option>
                        <option> LE. cel</option>
                      </select>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col">

                      <label for="haemorrhagic_test"> haemorrhagic test:</label>

                      <select class="form-control" id="haemorrhagic_test" name='haemorrhagic_test' required multiple>

                        <option>Blecing time </option>
                        <option>Thrombin time </option>
                        <option>Proth rombin time </option>
                        <option>PTTK </option>
                        <option>Fibrinogen plasma</option>
                        <option>Screning F XIII</option>
                        <option> Retraksi bekuan</option>
                        <option> Apusan Darah Tepi</option>
                      </select>
                    </div>



                    <div class="col">

                      <label for="faal_hati"> faal hati:</label>

                      <select class="form-control" id="faal_hati" name='faal_hati' required multiple>

                        <option>Bilirubin </option>
                        <option>SGPT </option>
                        <option>Alk. Phosphatase </option>
                        <option>Serum protein elektroforese </option>
                        <option> HBs Ag</option>
                        <option> Alphafeto protein</option>
                        <option> Total protein</option>
                        <option> SGOT</option>
                      </select>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col">

                      <label for="faal_ginjal"> faal ginjal:</label>

                      <select class="form-control" id="faal_ginjal" name='faal_ginjal' required multiple>

                        <option> Ureum </option>
                        <option>Creatinine Clearance </option>
                        <option>Rheumatoid Factor (RF)</option>
                        <option> Creatinin </option>
                        <option> Uric Acid</option>
                      </select>
                    </div>



                    <div class="col">

                      <label for="metabolisme_karbohidra"> metabolisme karbohidra:</label>

                      <select class="form-control" id="metabolisme_karbohidra" name='metabolisme_karbohidra' required multiple>

                        <option> Gula darah Puasa </option>
                        <option>Gula Darah Sewaktu </option>
                        <option> Gula Darah 2 jam PP </option>
                        <option>Aseton darah</option>

                      </select>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col">

                      <label for="urine"> urine:</label>

                      <select class="form-control" id="urine" name='urine' required multiple>

                        <option> Urine </option>
                        <option>rutin </option>
                        <option>Tirtrasi 1x</option>
                        <option>Planotest standard</option>

                      </select>
                    </div>



                    <div class="col">

                      <label for="thyroid"> thyroid:</label>

                      <select class="form-control" id="thyroid" name='thyroid' required multiple>
                        <option>T3</option>
                        <option>TSH</option>
                        <option>T4</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">


                    <div class="col">

                      <label for="lipid_profile"> lipid profile:</label>

                      <select class="form-control" id="lipid_profile" name='lipid_profile' required multiple>

                        <option> Cholesterol </option>
                        <option>Total lipid</option>
                        <option>Triglycerida </option>
                        <option>HDL </option>
                        <option>LDL</option>

                      </select>
                    </div>


                    <div class="col">

                      <label for="arthritis_profile"> arthritis profile:</label>

                      <select class="form-control" id="arthritis_profile" name='arthritis_profile' required multiple>

                        <option> Cholesterol </option>
                        <option>ASTO</option>
                        <option>LEE.Tsst</option>
                        <option>Uric acid</option>
                        <option>Rheumatoid factor</option>

                      </select>
                    </div>
                  </div>
                  <div class="row">

                    <div class="col">

                      <label for="elektrolit"> elektrolit:</label>

                      <select class="form-control" id="elektrolit" name='elektrolit' required multiple>

                        <option> Natrium </option>
                        <option>Kalium </option>
                        <option>Chlorida </option>
                        <option>Chlorida</option>
                        <option>AGDA</option>

                      </select>
                    </div>



                    <div class="col">

                      <label for="feces"> feces:</label>

                      <select class="form-control" id="feces" name='feces' required multiple>

                        <option> Faces rutin </option>
                        <option>Benzidine test </option>


                      </select>
                    </div>
                  </div>
                  <div class="row">



                    <div class="col">

                      <label for="pancreas"> pancreas:</label>

                      <select class="form-control" id="pancreas" name='pancreas' required multiple>

                        <option> Serum amylase </option>
                        <option>Urine amylase</option>


                      </select>
                    </div>



                    <div class="col">

                      <label for="myocard_infarct"> myocard infarct:</label>

                      <select class="form-control" id="myocard_infarct" name='myocard_infarct' required multiple>

                        <option> SGOT </option>
                        <option>CPK </option>
                        <option>LDH </option>
                        <option> HBDH </option>

                      </select>
                    </div>
                  </div>
                  <div class="row">


                    <div class="col">

                      <label for="vd_profile"> vd profile:</label>

                      <select class="form-control" id="vd_profile" name='vd_profile' required multiple>

                        <option> VDRL </option>
                        <option>TPHA</option>


                      </select>
                    </div>



                    <div class="col">

                      <label for="lain_lain"> lain lain:</label>

                      <select class="form-control" id="lain_lain" name='lain_lain' required multiple>

                        <option> Widal / Tubex </option>
                        <option>Analise sperma </option>
                        <option>Analisa batu</option>
                        <option> HbA1c </option>

                      </select>
                    </div>

                  </div>

                  <div class="col">


                    <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value='<?= $idKunj ?>' required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value='<?= $idPel ?>' required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value='<?= $idPasien ?>' required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_user" name='id_user' value='<?= $idUser ?>' required>
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
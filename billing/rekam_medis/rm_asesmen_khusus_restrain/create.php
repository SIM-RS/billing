<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input asesmen khusus restrain </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input asesmen khusus restrain</td>
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
                  <h5> PENGKAJIAN FISIK DAN MENTAL </h5>
                  <h6>Kesadaran : </h6>
                  <br>
                  <div class="row">


                    <h6>GCS :</h6>


                    <div class="col">

                      <input type="text" class="form-control" id="gcs_e" name='gcs_e' placeholder="E" required>
                    </div>



                    <div class="col">


                      <input type="text" class="form-control" id="gcs_v" name='gcs_v' placeholder="V" required>
                    </div>



                    <div class="col">

                      <input type="text" class="form-control" id="gcs_m" name='gcs_m' placeholder="M" required>
                    </div>
                  </div>

                  <br>
                  <h6>Reflek Cahaya:</h6>
                  <div class="row">

                    <div class="col">

                      <input type="text" placeholder="Ka" class="form-control" id="reflek_cahaya_ka" name='reflek_cahaya_ka' required>
                    </div>



                    <div class="col">


                      <input type="text" placeholder="Ki" class="form-control" id="reflek_cahaya_ki" name='reflek_cahaya_ki' required>
                    </div>
                  </div>
                  <br>
                  <h6>Ukuran Pupil:</h6>
                  <div class="row">
                    <div class="col">

                      <input type="text" placeholder="Ka_______ mm" class="form-control" id="ukuran_pupil_ka" name='ukuran_pupil_ka' required>
                    </div>



                    <div class="col">


                      <input type="text" placeholder="Ki_______ mm" class="form-control" id="ukuran_pupil_ki" name='ukuran_pupil_ki' required>
                    </div>
                  </div>
                  <br>
                  <h6>TTV: </h6>

                  <div class="row">
                    <div class="col">


                      <input type="text" placeholder="TD _______ mmHg" class="form-control" id="ttv_td" name='ttv_td' required>
                    </div>



                    <div class="col">


                      <input type="text" placeholder="Pernafasan_______ x/ mnt" class="form-control" id="ttv_pernafasan" name='ttv_pernafasan' required>
                    </div>



                    <div class="col">

                      <input type="text" placeholder="Suhu: ____ ◦C " class="form-control" id="ttv_suhu" name='ttv_suhu' required>
                    </div>



                    <div class="col">


                      <input type="text" placeholder="Nadi______ x/ mnt " class="form-control" id="ttv_nadi" name='ttv_nadi' required>
                    </div>
                  </div>
                  <br>
                  <div class="col">

                    <label for="hasil_observasi"><b>Hasil observasi : </b></label>
            
                  <select class="form-control" id="hasil_observasi" name='hasil_observasi' required multiple>
                    <option>Pasien gaduh gelisah atau delirium dan brontak</option>
                    <option>Ketidakmampuan dalam mengikuti perintah untuk tidak meninggalkan tempat tidur </option>
                    <option>Pasien tidak kooperatif</option>
                  </select>
                  </div>



                  <div class="col">

                    <label for="pertimbangan_klinis"> <b>Pertimbangan klinis : <b></label>
               
                    <select class="form-control" id="pertimbangan_klinis" name='pertimbangan_klinis' required multiple>
                      <option>Membahayakan diri sendiri                              </option>
                      <option>Membahayakan orang lain</option>
                      <option>Gagal meminimalkan penggunaan Restrain   </option>
                      <option>Lain-lain </option>
                    </select>
                  </div>
<br>
<h5>
PENILAIAN DAN INSTRUKSI DOKTER 
</h5>

                  <div class="col">

                    <label for="restrain_non_farmakologi"><b> Restrain non farmakologi : </b></label>
               
                 <select  class="form-control" id="restrain_non_farmakologi" name='restrain_non_farmakologi' required multiple>
                   <option>Restrain pergelangan tangan kanan/ kiri         </option>
                   <option>Restrain pergelangan kaki kanan/ kiri</option>
                   <option>Restrain badan                                                      </option>
                   <option>Lain-lain </option>
                 </select>
                  </div>



                  <div class="col">

                    <label for="restrain_farmakologi"><b> Restrain farmakologi : </b></label>
                    
                 <textarea  class="form-control" id="restrain_farmakologi" name='restrain_farmakologi' required></textarea>
                  </div>
<br>
<h6><b>Rencana pengkajian lanjutan</b></h6>

                  <div class="col">

                    <label for="lanjutan_restrain_non_farmakologi"> <b> Restrain non farmakologi : </b></label>
                  
                  <select class="form-control" id="lanjutan_restrain_non_farmakologi" name='lanjutan_restrain_non_farmakologi' required multiple>
                    <option>Observasi satu jam pertama      </option>
                    <option>Observasi dua jam pertama </option>
                    <option>Selanjutnya tiap 4 jam/ shif</option>
                  </select>
                  </div>

                  <div class="col">

<label for="lanjutan_restrain_farmakologi"> <b> Restrain  farmakologi : </b></label>

<select class="form-control" id="lanjutan_restrain_farmakologi" name='lanjutan_restrain_farmakologi' required multiple>
<option>Observasi TTV  tiga puluh menit/ satu jam setelah pemakaian restrain selanjutnya sesuai kondisi      </option>
<option>Observasi lanjutan sesuai kondisi/ asuhan </option>

</select>
</div>




                  <div class="col">

                    <label for="pendidikan_restrain_keluarga"> <b>Pendidikan restrain keluarga: </b></label>

                  <select class="form-control" name="pendidikan_restrain_keluarga" required  multiple>
                    <option>Menjelaskan alasan penggunaan restrain sebagai prosedur emergensi </option>
                    <option>Menjelaskan kriteria hasil observasi atau ketentuan penghentian restrain </option>
                    <option>Memberikan informati atau edukasi kepada pasien dan keluarga </option>
                  </select>
                  </div>



                  <div class="col">

                    <label for="tanggal"> tanggal:</label>
                    <input type="date" class="form-control" id="tanggal" name='tanggal' required>
                  </div>



                  <div class="col">

                    <label for="pukul"> pukul:</label>
                    <input type="time" class="form-control" id="pukul" name='pukul' required>
                  </div>



                  <div class="col">


                    <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj ?>" required>



                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel ?>" required>





                    <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>





                    <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?= $idUser ?>" required>
                  </div>


                  <br>
                  <div class='btn-group' style='float:right;'>

                    <a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
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
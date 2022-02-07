<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Dugaan Reaksi Transfusi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp; Form Input Dugaan Reaksi Transfusi</td>
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
                      <label for="diagnosa"> diagnosa:</label>

                      <textarea class="form-control" id="diagnosa" name='diagnosa' required></textarea>
                    </div>

                    <div class="col">
                      <label for="bagian"> bagian:</label>

                      <textarea class="form-control" id="bagian" name='bagian' required></textarea>

                    </div>

                  </div>
                  <br>
                  <div class="row">

                    <div class="col">
                      <label for="ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="ruangan" name='ruangan' required>
                    </div>

                    <div class="col">
                      <label for="kelas"> kelas:</label>
                      <input type="text" class="form-control" id="kelas" name='kelas' required>
                    </div>

                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label for="hari_tanggal_jam_transfusi"> hari,tanggal & jam transfusi:</label>
                      <input type="date" class="form-control" id="hari_tanggal_jam_transfusi" name='hari_tanggal_jam_transfusi' required>
                    </div>

                    <div class="col">
                      <label for="jam_reaksi"> jam terjadinya reaksi:</label>
                      <input type="time" class="form-control" id="jam_reaksi" name='jam_reaksi' required>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label for="jenis_komponen_darah"> jenis komponen darah:</label>
                      <input type="text" class="form-control" id="jenis_komponen_darah" name='jenis_komponen_darah' required>
                    </div>

                    <div class="col">
                      <label for="golongan_darah"> Gol. Darah-Rhesus /No. Kantong darah :</label>
                      <input type="text" class="form-control" id="golongan_darah" name='golongan_darah' required>
                    </div>

                    <div class="col">
                      <label for="perkiraan_vol_transfusi"> Perkiraan vol yang sudah ditransfusikan :</label>
                      <input type="text" class="form-control" id="perkiraan_vol_transfusi" name='perkiraan_vol_transfusi' required>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label for="pratransfusi_kesadaran"> kesadaran:</label>
                      <input type="text" class="form-control" id="pratransfusi_kesadaran" name='pratransfusi_kesadaran' required>
                    </div>

                    <div class="col">
                      <label for="pratransfusi_tekanan_darah"> tekanan_darah:</label>
                      <input type="text" class="form-control" id="pratransfusi_tekanan_darah" name='pratransfusi_tekanan_darah' required>
                    </div>

                    <div class="col">
                      <label for="pratransfusi_frekunensi_nadi"> frekuensi_nadi:</label>
                      <input type="text" class="form-control" id="pratransfusi_frekunensi_nadi" name='pratransfusi_frekunensi_nadi' required>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label for="pratransfusi_suhu">suhu:</label>
                      <input type="text" class="form-control" id="pratransfusi_suhu" name='pratransfusi_suhu' required>
                    </div>

                    <div class="col">
                      <label for="pascatransfusi_kesadaran"> kesadaran:</label>
                      <input type="text" class="form-control" id="pascatransfusi_kesadaran" name='pascatransfusi_kesadaran' required>
                    </div>

                    <div class="col">
                      <label for="pascatransfusi_tekanan_darah">tekanan_darah:</label>
                      <input type="text" class="form-control" id="pascatransfusi_tekanan_darah" name='pascatransfusi_tekanan_darah' required>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label for="pascaatransfusi_frekunensi_nadi"> frekuensi nadi:</label>
                      <input type="text" class="form-control" id="pascaatransfusi_frekunensi_nadi" name='pascaatransfusi_frekunensi_nadi' required>
                    </div>

                    <div class="col">
                      <label for="pascatransfusi_suhu"> suhu:</label>
                      <input type="text" class="form-control" id="pascatransfusi_suhu" name='pascatransfusi_suhu' required>
                    </div>

                    <div class="col">
                      <label for="gejala_tanda_klinis"> gejala dan tanda klinis:</label>
                      <textarea class="form-control" id="gejala_tanda_klinis" name='gejala_tanda_klinis' required></textarea>

                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-8">
                      <label for="nama_dokter"> nama dokter:</label>
                      <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' value="<?= $_SESSION['pegawai_nama'] ?>" required>
                    </div>
                  </div>

                  <div class="form-group">

                    <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj ?>" required>




                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel ?>" required>




                    <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>
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
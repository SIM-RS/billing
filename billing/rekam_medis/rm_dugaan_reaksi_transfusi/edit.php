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
  <title> Form Edit Dugaan Reaksi Transfusi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp; Form Edit Dugaan Reaksi Transfusi</td>
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
                        <label for="diagnosa"> diagnosa:</label>

                        <textarea class="form-control" id="diagnosa" name='diagnosa'><?php echo $data['diagnosa']; ?></textarea>
                      </div>


                      <div class="col">
                        <label for="bagian"> bagian:</label>

                        <textarea class="form-control" id="bagian" name='bagian'><?php echo $data['bagian']; ?></textarea>
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">
                        <label for="ruangan"> ruangan:</label>
                        <input type="text" class="form-control" id="ruangan" name='ruangan' value="<?php echo $data['ruangan']; ?>">
                      </div>


                      <div class="col">
                        <label for="kelas"> kelas:</label>
                        <input type="text" class="form-control" id="kelas" name='kelas' value="<?php echo $data['kelas']; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="hari_tanggal_jam_transfusi"> hari,tanggal & jam transfusi:</label>
                        <input type="text" class="form-control" id="hari_tanggal_jam_transfusi" name='hari_tanggal_jam_transfusi' value="<?php echo $data['hari_tanggal_jam_transfusi']; ?>">
                      </div>


                      <div class="col">
                        <label for="jam_reaksi"> jam terjadinya reaksi:</label>
                        <input type="text" class="form-control" id="jam_reaksi" name='jam_reaksi' value="<?php echo $data['jam_reaksi']; ?>">
                      </div>

                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="jenis_komponen_darah"> jenis komponen darah:</label>
                        <input type="text" class="form-control" id="jenis_komponen_darah" name='jenis_komponen_darah' value="<?php echo $data['jenis_komponen_darah']; ?>">
                      </div>


                      <div class="col">
                        <label for="golongan_darah"> golongan darah:</label>
                        <input type="text" class="form-control" id="golongan_darah" name='golongan_darah' value="<?php echo $data['golongan_darah']; ?>">
                      </div>

                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="perkiraan_vol_transfusi"> perkiraan vol yang sudah ditransfusi:</label>
                        <input type="text" class="form-control" id="perkiraan_vol_transfusi" name='perkiraan_vol_transfusi' value="<?php echo $data['perkiraan_vol_transfusi']; ?>">
                      </div>


                      <div class="col">
                        <label for="pratransfusi_kesadaran"> kesadaran:</label>
                        <input type="text" class="form-control" id="pratransfusi_kesadaran" name='pratransfusi_kesadaran' value="<?php echo $data['pratransfusi_kesadaran']; ?>">
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">
                        <label for="pratransfusi_tekanan_darah"> tekanan_darah:</label>
                        <input type="text" class="form-control" id="pratransfusi_tekanan_darah" name='pratransfusi_tekanan_darah' value="<?php echo $data['pratransfusi_tekanan_darah']; ?>">
                      </div>


                      <div class="col">
                        <label for="pratransfusi_frekunensi_nadi"> frekuensi nadi:</label>
                        <input type="text" class="form-control" id="pratransfusi_frekunensi_nadi" name='pratransfusi_frekunensi_nadi' value="<?php echo $data['pratransfusi_frekunensi_nadi']; ?>">
                      </div>


                      <div class="col">
                        <label for="pratransfusi_suhu"> suhu:</label>
                        <input type="text" class="form-control" id="pratransfusi_suhu" name='pratransfusi_suhu' value="<?php echo $data['pratransfusi_suhu']; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="pascatransfusi_kesadaran"> kesadaran:</label>
                        <input type="text" class="form-control" id="pascatransfusi_kesadaran" name='pascatransfusi_kesadaran' value="<?php echo $data['pascatransfusi_kesadaran']; ?>">
                      </div>


                      <div class="col">
                        <label for="pascatransfusi_tekanan_darah"> tekanan darah:</label>
                        <input type="text" class="form-control" id="pascatransfusi_tekanan_darah" name='pascatransfusi_tekanan_darah' value="<?php echo $data['pascatransfusi_tekanan_darah']; ?>">
                      </div>


                      <div class="col">
                        <label for="pascaatransfusi_frekunensi_nadi"> frekuensi nadi:</label>
                        <input type="text" class="form-control" id="pascaatransfusi_frekunensi_nadi" name='pascaatransfusi_frekunensi_nadi' value="<?php echo $data['pascaatransfusi_frekunensi_nadi']; ?>">
                      </div>
                    </div>
                    <div class="row">

                      <div class="col">
                        <label for="pascatransfusi_suhu"> pascatransfusi suhu:</label>
                        <input type="text" class="form-control" id="pascatransfusi_suhu" name='pascatransfusi_suhu' value="<?php echo $data['pascatransfusi_suhu']; ?>">
                      </div>


                      <div class="col">
                        <label for="gejala_tanda_klinis"> gejala dan tanda klinis:</label>

                        <textarea class="form-control" id="gejala_tanda_klinis" name='gejala_tanda_klinis'><?php echo $data['gejala_tanda_klinis']; ?></textarea>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-8">
                        <label for="nama_dokter"> nama dokter:</label>
                        <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' value="<?php echo $data['nama_dokter']; ?>">
                      </div>
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
    </div>
    </section><!-- /.content -->
  </div>
</body>

</html>
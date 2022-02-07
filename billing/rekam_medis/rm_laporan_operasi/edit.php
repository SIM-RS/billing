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
  <title> Form Edit laporan operasi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit laporan operasi</td>
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
              <div class='container-fluid' style="padding: 10px;">
                <form action='func.php?<?= $idKunj ?>&idPel=<?= $idPel ?>&idPasien=<?= $idPasien ?>&idUser=<?= $idUser ?>' method='POST'>

                  <input type='hidden' name='id' value="<?php echo $_POST['id']; ?>">
                  <?php
                  foreach ($one as $data) { ?>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="ruang_operasi"> ruang operasi:</label>
                        <input type="text" class="form-control" id="ruang_operasi" name='ruang_operasi' value="<?php echo $data['ruang_operasi']; ?>">
                      </div>



                      <div class="col">

                        <label for="kamar"> kamar:</label>
                        <input type="text" class="form-control" id="kamar" name='kamar' value="<?php echo $data['kamar']; ?>">
                      </div>
                    </div>


                    <div class="row" style="padding: 10px;">
                      <div class="col">

                        <label for="akut_terencana"> akut terencana:</label>
                        <input type="text" class="form-control" id="akut_terencana" name='akut_terencana' value="<?php echo $data['akut_terencana']; ?>">
                      </div>



                      <div class="col">

                        <label for="tanggal"> tanggal:</label>
                        <input type="text" class="form-control" id="tanggal" name='tanggal' value="<?php echo $data['tanggal']; ?>">
                      </div>



                      <div class="col">

                        <label for="pukul"> pukul:</label>
                        <input type="text" class="form-control" id="pukul" name='pukul' value="<?php echo $data['pukul']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="pembedah"> pembedah:</label>
                        <input type="text" class="form-control" id="pembedah" name='pembedah' value="<?php echo $data['pembedah']; ?>">
                      </div>



                      <div class="col">

                        <label for="ahli_anestesi"> ahli anestesi:</label>
                        <input type="text" class="form-control" id="ahli_anestesi" name='ahli_anestesi' value="<?php echo $data['ahli_anestesi']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">



                      <div class="col">

                        <label for="asisten_1"> asisten 1:</label>
                        <input type="text" class="form-control" id="asisten_1" name='asisten_1' value="<?php echo $data['asisten_1']; ?>">
                      </div>



                      <div class="col">

                        <label for="asisten_2"> asisten 2:</label>
                        <input type="text" class="form-control" id="asisten_2" name='asisten_2' value="<?php echo $data['asisten_2']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="perawat_instrument"> perawat instrument:</label>
                        <input type="text" class="form-control" id="perawat_instrument" name='perawat_instrument' value="<?php echo $data['perawat_instrument']; ?>">
                      </div>



                      <div class="col">

                        <label for="jenis_anestesi"> jenis anestesi:</label>
                        <input type="text" class="form-control" id="jenis_anestesi" name='jenis_anestesi' value="<?php echo $data['jenis_anestesi']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">


                      <div class="col">

                        <label for="diagnosa_pra_bedah"> diagnosa pra bedah:</label>
                        <input type="text" class="form-control" id="diagnosa_pra_bedah" name='diagnosa_pra_bedah' value="<?php echo $data['diagnosa_pra_bedah']; ?>">
                      </div>



                      <div class="col">

                        <label for="indikasi_operasi"> indikasi operasi:</label>
                        <input type="text" class="form-control" id="indikasi_operasi" name='indikasi_operasi' value="<?php echo $data['indikasi_operasi']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="diagnosa_pasca_bedah"> diagnosa pasca bedah:</label>
                        <input type="text" class="form-control" id="diagnosa_pasca_bedah" name='diagnosa_pasca_bedah' value="<?php echo $data['diagnosa_pasca_bedah']; ?>">
                      </div>



                      <div class="col">

                        <label for="nama_operasi"> nama operasi:</label>
                        <input type="text" class="form-control" id="nama_operasi" name='nama_operasi' value="<?php echo $data['nama_operasi']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">



                      <div class="col">

                        <label for="desinfeksi_kulit_dengan"> desinfeksi kulit dengan:</label>
                        <input type="text" class="form-control" id="desinfeksi_kulit_dengan" name='desinfeksi_kulit_dengan' value="<?php echo $data['desinfeksi_kulit_dengan']; ?>">
                      </div>



                      <div class="col">

                        <label for="jaringan_dieksisi"> jaringan dieksisi:</label>
                        <input type="text" class="form-control" id="jaringan_dieksisi" name='jaringan_dieksisi' value="<?php echo $data['jaringan_dieksisi']; ?>">
                      </div>



                      <div class="col">

                        <label for="dikirim_patologi_anatomi"> dikirim patologi anatomi:</label>
                        <input type="text" class="form-control" id="dikirim_patologi_anatomi" name='dikirim_patologi_anatomi' value="<?php echo $data['dikirim_patologi_anatomi']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">



                      <div class="col">

                        <label for="jam_operasi_dimulai"> jam operasi dimulai:</label>
                        <input type="text" class="form-control" id="jam_operasi_dimulai" name='jam_operasi_dimulai' value="<?php echo $data['jam_operasi_dimulai']; ?>">
                      </div>



                      <div class="col">

                        <label for="jam_operasi_selesai"> jam operasi selesai:</label>
                        <input type="text" class="form-control" id="jam_operasi_selesai" name='jam_operasi_selesai' value="<?php echo $data['jam_operasi_selesai']; ?>">
                      </div>
                    </div>
                    <div class="row">


                      <div class="col">

                        <label for="lama_operasi_langsung"> lama operasi langsung:</label>
                        <input type="text" class="form-control" id="lama_operasi_langsung" name='lama_operasi_langsung' value="<?php echo $data['lama_operasi_langsung']; ?>">
                      </div>



                      <div class="col">

                        <label for="jenis_bahan"> jenis bahan:</label>
                        <input type="text" class="form-control" id="jenis_bahan" name='jenis_bahan' value="<?php echo $data['jenis_bahan']; ?>">
                      </div>



                      <div class="col">

                        <label for="pemeriksaan_laboratorium"> pemeriksaan laboratorium:</label>
                        <input type="text" class="form-control" id="pemeriksaan_laboratorium" name='pemeriksaan_laboratorium' value="<?php echo $data['pemeriksaan_laboratorium']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">


                      <div class="col">

                        <label for="macam_sayatan"> macam sayatan:</label>
                        <input type="text" class="form-control" id="macam_sayatan" name='macam_sayatan' value="<?php echo $data['macam_sayatan']; ?>">
                      </div>



                      <div class="col">

                        <label for="posisi_penderita"> posisi penderita:</label>
                        <input type="text" class="form-control" id="posisi_penderita" name='posisi_penderita' value="<?php echo $data['posisi_penderita']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="teknik_operasi"> teknik_operasi:</label>
                        <input type="text" class="form-control" id="teknik_operasi" name='teknik_operasi' value="<?php echo $data['teknik_operasi']; ?>">
                      </div>



                      <div class="col">

                        <label for="temuan_intra_operasi"> temuan intra operasi:</label>
                        <input type="text" class="form-control" id="temuan_intra_operasi" name='temuan_intra_operasi' value="<?php echo $data['temuan_intra_operasi']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="penggunaan_amhp_khusus"> penggunaan amhp khusus:</label>
                        <input type="text" class="form-control" id="penggunaan_amhp_khusus" name='penggunaan_amhp_khusus' value="<?php echo $data['penggunaan_amhp_khusus']; ?>">
                      </div>



                      <div class="col">

                        <label for="jenis_amhp_khusus"> jenis amhp khusus:</label>
                        <input type="text" class="form-control" id="jenis_amhp_khusus" name='jenis_amhp_khusus' value="<?php echo $data['jenis_amhp_khusus']; ?>">
                      </div>



                      <div class="col">

                        <label for="jumlah_amhp_khusus"> jumlah amhp khusus:</label>
                        <input type="text" class="form-control" id="jumlah_amhp_khusus" name='jumlah_amhp_khusus' value="<?php echo $data['jumlah_amhp_khusus']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="komplikasi_intra_operasi"> komplikasi intra operasi:</label>
                        <input type="text" class="form-control" id="komplikasi_intra_operasi" name='komplikasi_intra_operasi' value="<?php echo $data['komplikasi_intra_operasi']; ?>">
                      </div>



                      <div class="col">

                        <label for="perdarahan"> perdarahan:</label>
                        <input type="text" class="form-control" id="perdarahan" name='perdarahan' value="<?php echo $data['perdarahan']; ?>">
                      </div>



                      <div class="col">

                        <label for="penjabaran_komplikasi_intra_operasi"> penjabaran komplikasi intra operasi:</label>
                        <input type="text" class="form-control" id="penjabaran_komplikasi_intra_operasi" name='penjabaran_komplikasi_intra_operasi' value="<?php echo $data['penjabaran_komplikasi_intra_operasi']; ?>">
                      </div>

                    </div>
                    <div class="row" style="padding: 10px;">

                      <div class="col">

                        <label for="kontrol_nadi"> kontrol nadi:</label>
                        <input type="text" class="form-control" id="kontrol_nadi" name='kontrol_nadi' value="<?php echo $data['kontrol_nadi']; ?>">
                      </div>



                      <div class="col">

                        <label for="kontrol_tensi"> kontrol tensi:</label>
                        <input type="text" class="form-control" id="kontrol_tensi" name='kontrol_tensi' value="<?php echo $data['kontrol_tensi']; ?>">
                      </div>



                      <div class="col">

                        <label for="kontrol_pernafasan"> kontrol pernafasan:</label>
                        <input type="text" class="form-control" id="kontrol_pernafasan" name='kontrol_pernafasan' value="<?php echo $data['kontrol_pernafasan']; ?>">
                      </div>



                      <div class="col">

                        <label for="kontrol_suhu"> kontrol suhu:</label>
                        <input type="text" class="form-control" id="kontrol_suhu" name='kontrol_suhu' value="<?php echo $data['kontrol_suhu']; ?>">
                      </div>
                    </div>
                    <div class="row" style="padding: 10px;">


                      <div class="col">

                        <label for="puasa"> puasa:</label>
                        <input type="text" class="form-control" id="puasa" name='puasa' value="<?php echo $data['puasa']; ?>">
                      </div>



                      <div class="col">

                        <label for="drain"> drain:</label>
                        <input type="text" class="form-control" id="drain" name='drain' value="<?php echo $data['drain']; ?>">
                      </div>



                      <div class="col">

                        <label for="infus"> infus:</label>
                        <input type="text" class="form-control" id="infus" name='infus' value="<?php echo $data['infus']; ?>">
                      </div>
                    </div>


                    <div class="row" style="padding: 10px;">
                      <div class="col">

                        <label for="obat_obatan"> obat obatan:</label>
                        <input type="text" class="form-control" id="obat_obatan" name='obat_obatan' value="<?php echo $data['obat_obatan']; ?>">
                      </div>



                      <div class="col">

                        <label for="ganti_balut"> ganti balut:</label>
                        <input type="text" class="form-control" id="ganti_balut" name='ganti_balut' value="<?php echo $data['ganti_balut']; ?>">
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
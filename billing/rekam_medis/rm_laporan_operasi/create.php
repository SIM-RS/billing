<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input laporan operasi </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input laporan operasi</td>
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


                  <div class="row" style="padding: 10px;">
                    <div class="col">

                      <label for="ruang_operasi"> ruang operasi:</label>
                      <input type="text" class="form-control" id="ruang_operasi" name='ruang_operasi' required>
                    </div>



                    <div class="col">

                      <label for="kamar"> kamar:</label>
                      <input type="text" class="form-control" id="kamar" name='kamar' required>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="akut_terencana"> akut terencana:</label>
                      <input type="text" class="form-control" id="akut_terencana" name='akut_terencana' required>
                    </div>



                    <div class="col">

                      <label for="tanggal"> tanggal:</label>
                      <input type="date" class="form-control" id="tanggal" name='tanggal' required>
                    </div>



                    <div class="col">

                      <label for="pukul"> pukul:</label>
                      <input type="time" class="form-control" id="pukul" name='pukul' required>
                    </div>
                  </div>

                  <div class="row" style="padding: 10px;">
                    <div class="col">

                      <label for="pembedah"> pembedah:</label>
                      <input type="text" class="form-control" id="pembedah" name='pembedah' required>
                    </div>



                    <div class="col">

                      <label for="ahli_anestesi"> ahli anestesi:</label>
                      <input type="text" class="form-control" id="ahli_anestesi" name='ahli_anestesi' required>
                    </div>
                  </div>

                  <div class="row" style="padding: 10px;">
                    <div class="col">

                      <label for="asisten_1"> asisten 1:</label>
                      <input type="text" class="form-control" id="asisten_1" name='asisten_1' required>
                    </div>



                    <div class="col">

                      <label for="asisten_2"> asisten 2:</label>
                      <input type="text" class="form-control" id="asisten_2" name='asisten_2' required>
                    </div>


                  </div>
                  <div class="row" style="padding: 10px;">
                    <div class="col">

                      <label for="perawat_instrument"> perawat instrument:</label>
                      <input type="text" class="form-control" id="perawat_instrument" name='perawat_instrument' required>
                    </div>



                    <div class="col">

                      <label for="jenis_anestesi"> jenis anestesi:</label>

                      <select class="form-control" id="jenis_anestesi" name='jenis_anestesi' required multiple>
                        <option>Umum </option>
                        <option>Spinal </option>
                        <option>Epidural</option>
                        <option>BSP*</option>
                        <option>CSP*</option>
                        <option>Lokal</option>
                      </select>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="diagnosa_pra_bedah"> diagnosa pra_bedah:</label>

                      <textarea class="form-control" id="diagnosa_pra_bedah" name='diagnosa_pra_bedah' required></textarea>
                    </div>



                    <div class="col">

                      <label for="indikasi_operasi"> indikasi operasi:</label>

                      <textarea class="form-control" id="indikasi_operasi" name='indikasi_operasi' required></textarea>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="diagnosa_pasca_bedah"> diagnosa pasca bedah:</label>

                      <textarea class="form-control" id="diagnosa_pasca_bedah" name='diagnosa_pasca_bedah' required></textarea>
                    </div>



                    <div class="col">

                      <label for="nama_operasi"> nama operasi:</label>
                      <input type="text" class="form-control" id="nama_operasi" name='nama_operasi' required>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="desinfeksi_kulit_dengan"> desinfeksi kulit dengan:</label>
                      <input type="text" class="form-control" id="desinfeksi_kulit_dengan" name='desinfeksi_kulit_dengan' required>
                    </div>



                    <div class="col">

                      <label for="jaringan_dieksisi"> jaringan dieksisi:</label>
                      <input type="text" class="form-control" id="jaringan_dieksisi" name='jaringan_dieksisi' required>
                    </div>



                    <div class="col">

                      <label for="dikirim_patologi_anatomi"> dikirim patologi anatomi:</label>
                      <br>
                      <label> <input type="radio" id="dikirim_patologi_anatomi" name='dikirim_patologi_anatomi' value="Ya"> Ya </label>
                      &nbsp;
                      <label> <input type="radio" id="dikirim_patologi_anatomi" name='dikirim_patologi_anatomi' value="Tidak"> Tidak </label>

                    </div>
                  </div>
                  <div class="row" style="padding: 10px;">


                    <div class="col">

                      <label for="jam_operasi_dimulai"> jam operasi dimulai:</label>
                      <input type="time" class="form-control" id="jam_operasi_dimulai" name='jam_operasi_dimulai' required>
                    </div>



                    <div class="col">

                      <label for="jam_operasi_selesai"> jam operasi selesai:</label>
                      <input type="time" class="form-control" id="jam_operasi_selesai" name='jam_operasi_selesai' required>
                    </div>
                  </div>


                  <div class="row" style="padding: 10px;">
                    <div class="col">

                      <label for="lama_operasi_langsung"> lama operasi langsung:</label>
                      <input type="text" class="form-control" id="lama_operasi_langsung" name='lama_operasi_langsung' required>
                    </div>



                    <div class="col">

                      <label for="jenis_bahan"> jenis bahan:</label>
                      <input type="text" class="form-control" id="jenis_bahan" name='jenis_bahan' required>
                    </div>



                    <div class="col">

                      <label for="pemeriksaan_laboratorium"> pemeriksaan laboratorium:</label>
                      <input type="text" class="form-control" id="pemeriksaan_laboratorium" name='pemeriksaan_laboratorium' required>
                    </div>
                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="macam_sayatan"> macam sayatan:</label>
                      <input type="text" class="form-control" id="macam_sayatan" name='macam_sayatan' required>
                    </div>



                    <div class="col">

                      <label for="posisi_penderita"> posisi penderita:</label>
                      <input type="text" class="form-control" id="posisi_penderita" name='posisi_penderita' required>
                    </div>
                  </div>
                  <div class="row" style="padding: 10px;">



                    <div class="col">

                      <label for="teknik_operasi"> teknik operasi:</label>

                      <textarea class="form-control" id="teknik_operasi" name='teknik_operasi' required></textarea>
                    </div>



                    <div class="col">

                      <label for="temuan_intra_operasi"> temuan intra operasi:</label>
                      <textarea class="form-control" id="temuan_intra_operasi" name='temuan_intra_operasi' required></textarea>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="penggunaan_amhp_khusus"> penggunaan amhp khusus:</label>
                      <br>
                      <label> <input type="radio" id="penggunaan_amhp_khusus" name='penggunaan_amhp_khusus' value="Ya"> Ya </label>
                      &nbsp;
                      <label> <input type="radio" id="penggunaan_amhp_khusus" name='penggunaan_amhp_khusus' value="Tidak"> Tidak </label>
                    </div>



                    <div class="col">

                      <label for="jenis_amhp_khusus"> jenis amhp khusus:</label>
                      <input type="text" class="form-control" id="jenis_amhp_khusus" name='jenis_amhp_khusus' required>
                    </div>



                    <div class="col">

                      <label for="jumlah_amhp_khusus"> jumlah amhp khusus:</label>
                      <input type="text" class="form-control" id="jumlah_amhp_khusus" name='jumlah_amhp_khusus' required>
                    </div>
                  </div>
                  <div class="row" style="padding: 10px;">


                    <div class="col">

                      <label for="komplikasi_intra_operasi"> komplikasi intra operasi:</label>
                      <br>
                      <label> <input type="radio" id="komplikasi_intra_operasi" name='komplikasi_intra_operasi' value="Ya"> Ya </label>
                      &nbsp;
                      <label> <input type="radio" id="komplikasi_intra_operasi" name='komplikasi_intra_operasi' value="Tidak"> Tidak </label>
                    </div>



                    <div class="col">

                      <label for="perdarahan"> perdarahan:</label>
                      <input type="text" class="form-control" id="perdarahan" name='perdarahan' required>
                    </div>



                    <div class="col">

                      <label for="penjabaran_komplikasi_intra_operasi"> penjabaran komplikasi intra operasi:</label>

                      <textarea class="form-control" id="penjabaran_komplikasi_intra_operasi" name='penjabaran_komplikasi_intra_operasi' required></textarea>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="kontrol_nadi"> kontrol nadi:</label>
                      <input type="text" class="form-control" id="kontrol_nadi" name='kontrol_nadi' required>
                    </div>



                    <div class="col">

                      <label for="kontrol_tensi"> kontrol tensi:</label>
                      <input type="text" class="form-control" id="kontrol_tensi" name='kontrol_tensi' required>
                    </div>



                    <div class="col">

                      <label for="kontrol_pernafasan"> kontrol pernafasan:</label>
                      <input type="text" class="form-control" id="kontrol_pernafasan" name='kontrol_pernafasan' required>
                    </div>



                    <div class="col">

                      <label for="kontrol_suhu"> kontrol suhu:</label>
                      <input type="text" class="form-control" id="kontrol_suhu" name='kontrol_suhu' required>
                    </div>
                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="puasa"> puasa:</label>
                      <input type="text" class="form-control" id="puasa" name='puasa' required>
                    </div>



                    <div class="col">

                      <label for="drain"> drain:</label>
                      <input type="text" class="form-control" id="drain" name='drain' required>
                    </div>



                    <div class="col">

                      <label for="infus"> infus:</label>
                      <input type="text" class="form-control" id="infus" name='infus' required>
                    </div>

                  </div>
                  <div class="row" style="padding: 10px;">

                    <div class="col">

                      <label for="obat_obatan"> obat obatan:</label>
                      <input type="text" class="form-control" id="obat_obatan" name='obat_obatan' required>
                    </div>



                    <div class="col">

                      <label for="ganti_balut"> ganti balut:</label>
                      <input type="text" class="form-control" id="ganti_balut" name='ganti_balut' required>
                    </div>



                    <div class="col">

                      <label for="lain_lain"> lain lain:</label>
                      <input type="text" class="form-control" id="lain_lain" name='lain_lain' required>
                    </div>

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
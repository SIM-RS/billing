<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Checklist Rencana Pulang </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM INPUT Checklist Rencana Pulang</td>
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
                  <div class='col'>


                    <div class="form-group">
                      <label for="aktifitas">aktifitas:</label>

                      <select class="form-control" id="aktifitas" name='aktifitas' required multiple>
                        <option> Jenis aktifitas yang boleh dilakukan</option>
                        <option> Alat bantu yang bisa digunakan</option>
                        <option>Latihan melakukan aktifitas dan menggunakan alat Bantu</option>
                        <option>Informasi lain yang diperlukan untuk aktifitas</option>

                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_aktifitas"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="pemberian_obat_dirumah"> pemberian obat dirumah:</label>

                      <select class="form-control" id="pemberian_obat_dirumah" name='pemberian_obat_dirumah' required multiple>
                        <option> Nama dan kegunaan obat</option>
                        <option> Efek samping obat</option>
                        <option> Dosis dan waktu pemberian obat</option>
                        <option> Cara pemberian obat</option>
                        <option> Cara memperoleh obat</option>
                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_pemberian_obat_dirumah"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="fasilitas_kesehatan"> Fasilitas kesehatan yang bisa dihubungi jika terjadi kedaruratan:</label>

                      <select class="form-control" id="fasilitas_kesehatan" name='fasilitas_kesehatan' required multiple="">
                        <option> Petugas kesehatan dilingkungan sekitar tempat tinggal pasien</option>
                        <option>Puskesmas, klinik, praktek dokter dilingkungan sekitar tempat tinggal pasien</option>
                        <option>Rumah sakit yang mudah diakses</option>
                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_fasilitas_kesehatan"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="hasil_pemeriksaan_penunjang"> hasil pemeriksaan penunjang:</label>
                      <br>
                      Berikan edukasi tentang :

                      <select class="form-control" id="hasil_pemeriksaan_penunjang" name='hasil_pemeriksaan_penunjang' required multiple="">
                        <option>Hasil hasil pemeriksaaan penunjang dalam batas nilai normal dan nilai kritis</option>
                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_hasil_pemeriksaan_penunjang"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="kontrol_selanjutnya"> kontrol selanjutnya:</label>

                      <select class="form-control" id="kontrol_selanjutnya" name='kontrol_selanjutnya' required multiple="">
                        <option> Kontrol Puskesmas</option>
                        <option>Kontrol Dokter Praktek</option>
                        <option>Kontrol RS Prima Husada Cipta Medan</option>
                        <option>Kontrol ke Poliklinik Pratama Krakatau</option>

                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_kontrol_selanjutnya"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="diet"> diet:</label>

                      <select class="form-control" id="diet" name='diet' required multiple="">
                        <option> Anjuran pola makan</option>
                        <option> Makanan Yang Perlu Dihindari</option>
                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_diet"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="edukasi_dan_latihan"> edukasi dan latihan:</label>

                      <select class="form-control" id="edukasi_dan_latihan" name='edukasi_dan_latihan' required multiple="">
                        <option>Hygiene (mandi, bab, bak, dll) *</option>
                        <option>Cara perawatan luka *</option>
                        <option>Cara perawatan NGT, Catheater, Trakhestmy, dll *</option>
                        <option>Cara pencegahan dan kontrol adanya infeksi</option>
                        <option>Kenali tanda dan gejala yang perlu dilaporkan</option>
                        <option>Pengobatan yang dapat dilakukan di rumah sebelum ke rumah sakit</option>
                        <option>Lain lain</option>

                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_edukasi_dan_latihan"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="rincian_pemulangan"> rincian pemulangan:</label>

                      <select class="form-control" id="rincian_pemulangan" name='rincian_pemulangan' required multiple="">
                        <option> Tanggal pemulangan </option>
                        <option>Pendamping</option>
                        <option>Transportasi yang digunakan</option>
                        <option> Keadaan umum saat pemulangan</option>
                        <option>Tempat perawatan selanjutnya setelah pulang</option>
                        <option>Format ringkasan pulang/ resume medis yang sudah terisi</option>
                        <option>Kelengkapan Administrasi</option>
                        <option>Lain – lain</option>

                      </select>
                      <label>Catatan</label>
                      <textarea class="form-control" name="catatan_rincian_pemulangan"></textarea>
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
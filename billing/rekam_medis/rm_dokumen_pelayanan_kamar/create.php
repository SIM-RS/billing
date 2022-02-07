<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input dokumen pelayanan kamar </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input dokumen pelayanan kamar</td>
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

                  <br>
                  <h6>Buku Status :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="buku_status_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="buku_status_ruang_pemulihan" name='buku_status_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="buku_status_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="buku_status_ruangan" name='buku_status_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="buku_status_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="buku_status_keterangan" name='buku_status_keterangan' required>
                    </div>
                  </div>
                  <br>
                  <h6>Laporan Operasi :</h6>
                  <div class="row">
                    <div class="col">

                      <label for="laporan_operasi_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="laporan_operasi_ruang_pemulihan" name='laporan_operasi_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="laporan_operasi_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="laporan_operasi_ruangan" name='laporan_operasi_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="laporan_operasi_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="laporan_operasi_keterangan" name='laporan_operasi_keterangan' required>
                    </div>

                  </div>
                  <br>
                  <h6>Laporan Anestesi :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="laporan_anestesi_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="laporan_anestesi_ruang_pemulihan" name='laporan_anestesi_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="laporan_anestesi_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="laporan_anestesi_ruangan" name='laporan_anestesi_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="laporan_anestesi_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="laporan_anestesi_keterangan" name='laporan_anestesi_keterangan' required>
                    </div>

                  </div>
                  <br>
                  <h6>Kim :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="kim_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="kim_ruang_pemulihan" name='kim_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="kim_ruangan">ruangan:</label>
                      <input type="text" class="form-control" id="kim_ruangan" name='kim_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="kim_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="kim_keterangan" name='kim_keterangan' required>
                    </div>
                  </div>
                  <br>
                  <h6>Instruksi Obat :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="instruksi_obat_ruang_pemulihan">ruang pemulihan:</label>
                      <input type="text" class="form-control" id="instruksi_obat_ruang_pemulihan" name='instruksi_obat_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_obat_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="instruksi_obat_ruangan" name='instruksi_obat_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_obat_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="instruksi_obat_keterangan" name='instruksi_obat_keterangan' required>
                    </div>
                  </div>
                  <br>
                  <h6>Instruksi Khusus :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="instruksi_khusus_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="instruksi_khusus_ruang_pemulihan" name='instruksi_khusus_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_khusus_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="instruksi_khusus_ruangan" name='instruksi_khusus_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_khusus_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="instruksi_khusus_keterangan" name='instruksi_khusus_keterangan' required>
                    </div>
                  </div>
                  <br>
                  <h6>Instruksi Transfusi:</h6>
                  <div class="row">



                    <div class="col">

                      <label for="instruksi_transfusi_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="instruksi_transfusi_ruang_pemulihan" name='instruksi_transfusi_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_transfusi_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="instruksi_transfusi_ruangan" name='instruksi_transfusi_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="instruksi_transfusi_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="instruksi_transfusi_keterangan" name='instruksi_transfusi_keterangan' required>
                    </div>

                  </div>
                  <br>
                  <h6>X Ray Photo:</h6>
                  <div class="row">

                    <div class="col">

                      <label for="x_ray_photo_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="x_ray_photo_ruang_pemulihan" name='x_ray_photo_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="x_ray_photo_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="x_ray_photo_ruangan" name='x_ray_photo_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="x_ray_photo_ruang_jumlah"> jumlah:</label>
                      <input type="text" class="form-control" id="x_ray_photo_ruang_jumlah" name='x_ray_photo_ruang_jumlah' required>
                    </div>
                  </div>
                  <br>
                  <h6>EEG :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="eeg_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="eeg_ruang_pemulihan" name='eeg_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="eeg_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="eeg_ruangan" name='eeg_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="eeg_jumlah"> jumlah:</label>
                      <input type="text" class="form-control" id="eeg_jumlah" name='eeg_jumlah' required>
                    </div>
                  </div>
                  <br>
                  <h6>ECG :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="ecg_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="ecg_ruang_pemulihan" name='ecg_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="ecg_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="ecg_ruangan" name='ecg_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="ecg_jumlah"> jumlah:</label>
                      <input type="text" class="form-control" id="ecg_jumlah" name='ecg_jumlah' required>
                    </div>
                  </div>
                  <br>
                  <h6>USG :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="usg_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="usg_ruang_pemulihan" name='usg_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="usg_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="usg_ruangan" name='usg_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="usg_jumlah"> jumlah:</label>
                      <input type="text" class="form-control" id="usg_jumlah" name='usg_jumlah' required>
                    </div>
                  </div>
                  <br>
                  <h6>CT Scan :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="ct_scan_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="ct_scan_ruang_pemulihan" name='ct_scan_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="ct_scan_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="ct_scan_ruangan" name='ct_scan_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="ct_scan_jumlah"> jumlah:</label>
                      <input type="text" class="form-control" id="ct_scan_jumlah" name='ct_scan_jumlah' required>
                    </div>


                  </div>
                  <br>
                  <h6>NGTS :</h6>
                  <div class="row">
                    <div class="col">

                      <label for="ngt_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="ngt_ruang_pemulihan" name='ngt_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="ngt_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="ngt_ruangan" name='ngt_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="ngt_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="ngt_keterangan" name='ngt_keterangan' required>
                    </div>
                  </div>
                  <br>
                  <h6>Kateter Urin :</h6>
                  <div class="row">



                    <div class="col">

                      <label for="kateter_urin_ruang_pemulihan">ruang pemulihan:</label>
                      <input type="text" class="form-control" id="kateter_urin_ruang_pemulihan" name='kateter_urin_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="kateter_urin_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="kateter_urin_ruangan" name='kateter_urin_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="kateter_urin_keterangan"> keterangan:</label>
                      <input type="text" class="form-control" id="kateter_urin_keterangan" name='kateter_urin_keterangan' required>
                    </div>

                  </div>
                  <br>
                  <h6>Infus :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="infus_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="infus_ruang_pemulihan" name='infus_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="infus_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="infus_ruangan" name='infus_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="infus_area"> area:</label>
                      <input type="text" class="form-control" id="infus_area" name='infus_area' required>
                    </div>
                  </div>
                  <br>
                  <h6>Drains :</h6>
                  <div class="row">


                    <div class="col">

                      <label for="drain_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="drain_ruang_pemulihan" name='drain_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="drain_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="drain_ruangan" name='drain_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="drain_area"> area:</label>
                      <input type="text" class="form-control" id="drain_area" name='drain_area' required>
                    </div>

                  </div>
                  <br>
                  <h6>Traksi :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="traksi_ruang_pemulihan"> ruang pemulihan:</label>
                      <input type="text" class="form-control" id="traksi_ruang_pemulihan" name='traksi_ruang_pemulihan' required>
                    </div>



                    <div class="col">

                      <label for="traksi_ruangan"> ruangan:</label>
                      <input type="text" class="form-control" id="traksi_ruangan" name='traksi_ruangan' required>
                    </div>



                    <div class="col">

                      <label for="traksi_area"> area:</label>
                      <input type="text" class="form-control" id="traksi_area" name='traksi_area' required>
                    </div>

                  </div>
                  <br>
                  <h6>Protesa :</h6>
                  <div class="row">

                    <div class="col">

                      <label for="protesa_lain"> protesa lain:</label>
                      <input type="text" class="form-control" id="protesa_lain" name='protesa_lain' required>
                    </div>



                    <div class="col">

                      <label for="protesa_area"> protesa area:</label>
                      <input type="text" class="form-control" id="protesa_area" name='protesa_area' required>
                    </div>
                  </div>
                  <br>
                  <div class="row">


                    <div class="col">

                      <label for="petugas_yang_menyerahkan"> petugas yang menyerahkan:</label>
                      <input type="text" class="form-control" id="petugas_yang_menyerahkan" name='petugas_yang_menyerahkan' required>
                    </div>



                    <div class="col">

                      <label for="petugas_yang_menerima"> petugas yang menerima:</label>
                      <input type="text" class="form-control" id="petugas_yang_menerima" name='petugas_yang_menerima' required>
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
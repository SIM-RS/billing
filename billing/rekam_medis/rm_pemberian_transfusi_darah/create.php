<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Form Input Pemberian Transfusi Darah </title>
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
          <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input Pemberian Transfusi Darah</td>
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
                  <div class='col-'>
                    <div class="col">
                      <div class="col">

                        <div class="form-group">
                          <label for="dokter_pelaksana_tindakan"> dokter pelaksana tindakan:</label>
                          <input type="text" class="form-control" id="dokter_pelaksana_tindakan" name='dokter_pelaksana_tindakan' required>
                        </div>

                        <div class="form-group">
                          <label for="pemberi_informasi"> pemberi informasi:</label>
                          <input type="text" class="form-control" id="pemberi_informasi" name='pemberi_informasi' required>
                        </div>

                        <div class="form-group">
                          <label for="penerima_informasi"> penerima informasi:</label>
                          <input type="text" class="form-control" id="penerima_informasi" name='penerima_informasi' required>
                        </div>
                        <div class="form-group">
                          <label for="dasar_diagnosis"> dasar diagnosis:</label>

                          <select class="form-control" id="dasar_diagnosis" name='dasar_diagnosis' required multiple>
                            <option>Pemeriksaan laboratorium / penunjang </option>
                            <option>lain-lain</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="indikasi_tindakan"> indikasi tindakan:</label>

                          <select class="form-control" id="indikasi_tindakan" name='indikasi_tindakan' required multiple>
                            <option>Anemia berat </option>
                            <option>shock hemoragik </option>
                            <option>Talasemia</option>
                            <option>Gangguan ginjal kronis </option>
                            <option>DHF dengan perdarahan / tanda – tanda perdarahan </option>
                            <option>lain – lain </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="biaya_pengelolaan"> biaya pengelolaan:</label>
                          <input type="text" class="form-control" id="rupiah" name='biaya_pengelolaan' required>

                        </div>
                        <div class="form-group">
                          <label for="nama_dokter"> nama dokter:</label>
                          <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' required>
                        </div>


                        <div class="form-group">

                          <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj ?>" required>



                          <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel ?>" required>



                          <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>

                          <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?= $idUser ?>" required>
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

  <script type="text/javascript">
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e) {
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
      rupiah.value = formatRupiah(this.value);
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>
</body>

</html>
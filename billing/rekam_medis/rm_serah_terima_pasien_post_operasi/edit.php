
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
    <title> Form Edit serah terima pasien post operasi </title>
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css" >
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
  
        <div  style="background-color: #EAF0F0 ; width: 1000px; margin: auto;">
            
          <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tbody><tr>
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit serah terima pasien post operasi</td>
                    <td width="35" class="tblatas">
                        <a href="http://localhost:7777/simrs-pelindo/billing/">
                            <img alt="close" src="http://localhost:7777/simrs-pelindo/billing/icon/x.png" style="cursor: pointer" border="0" width="32">
                        </a>
                    </td>
                </tr>
            </tbody></table>
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
            <form action='func.php?<?=$idKunj?>&idPel=<?=$idPel?>&idPasien=<?=$idPasien?>&idUser=<?=$idUser?>' method='POST'>
          
            <input type='hidden' name='id' value="<?php echo $_POST['id']; ?>">
            <?php
            foreach($one as $data){?>
               
                <div class="row">
                <div class="col">
                  
                  <label for="diagnosa"> diagnosa:</label>
                  <input type="text" class="form-control" id="diagnosa" name='diagnosa' value="<?php echo $data['diagnosa']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ruangan"> ruangan:</label>
                  <input type="text" class="form-control" id="ruangan" name='ruangan' value="<?php echo $data['ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tgl_op"> tgl_op:</label>
                  <input type="text" class="form-control" id="tgl_op" name='tgl_op' value="<?php echo $data['tgl_op']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tindakan"> tindakan:</label>
                  <input type="text" class="form-control" id="tindakan" name='tindakan' value="<?php echo $data['tindakan']; ?>">
                </div>
              </div>

            <br>
            <h5>Blagko</h5>
            <h6>Laporan operasi</h6>
<div class="row">
                <div class="col">
                  
                  <label for="blagko_laporan_operasi_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_recoveryroom" name='blagko_laporan_operasi_perawat_recoveryroom' value="<?php echo $data['blagko_laporan_operasi_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_laporan_operasi_perawat_ruangan"> Perawat ruangan:</label>
                  <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_ruangan" name='blagko_laporan_operasi_perawat_ruangan' value="<?php echo $data['blagko_laporan_operasi_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_laporan_operasi_perawat_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_keterangan" name='blagko_laporan_operasi_perawat_keterangan' value="<?php echo $data['blagko_laporan_operasi_perawat_keterangan']; ?>">
                </div>
              
            </div>
                <br>
                <h6>Catatan Anestesi :</h6> 
                <div class="row"> 
                <div class="col">
                  
                  <label for="blagko_catatan_anestesi_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="blagko_catatan_anestesi_perawat_recoveryroom" name='blagko_catatan_anestesi_perawat_recoveryroom' value="<?php echo $data['blagko_catatan_anestesi_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_catatan_anestesi_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="blagko_catatan_anestesi_perawat_ruangan" name='blagko_catatan_anestesi_perawat_ruangan' value="<?php echo $data['blagko_catatan_anestesi_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_catatan_anestesi_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="blagko_catatan_anestesi_keterangan" name='blagko_catatan_anestesi_keterangan' value="<?php echo $data['blagko_catatan_anestesi_keterangan']; ?>">
                </div>
              </div>
            
                 <br>
                 <h6>Pemakaian Alat :</h6> 
                 <div class="row">
                <div class="col">
                  
                  <label for="blagko_pemakaian_alat_perawat_recoveryroom">perawat recovery room:</label>
                  <input type="text" class="form-control" id="blagko_pemakaian_alat_perawat_recoveryroom" name='blagko_pemakaian_alat_perawat_recoveryroom' value="<?php echo $data['blagko_pemakaian_alat_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_pemakaian_alat_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="blagko_pemakaian_alat_perawat_ruangan" name='blagko_pemakaian_alat_perawat_ruangan' value="<?php echo $data['blagko_pemakaian_alat_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blagko_pemakaian_alat_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="blagko_pemakaian_alat_keterangan" name='blagko_pemakaian_alat_keterangan' value="<?php echo $data['blagko_pemakaian_alat_keterangan']; ?>">
                </div>
              </div>
            
                <br>
                <h6>Blangko :</h6>
                <div class="row">
                <div class="col">
                  
                  <label for="blangko_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="blangko_perawat_recoveryroom" name='blangko_perawat_recoveryroom' value="<?php echo $data['blangko_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blangko_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="blangko_perawat_ruangan" name='blangko_perawat_ruangan' value="<?php echo $data['blangko_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="blangko_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="blangko_keterangan" name='blangko_keterangan' value="<?php echo $data['blangko_keterangan']; ?>">
                </div>
              </div>
            
                  <br>
                  <h5>RontGen</h5>
                  <div class="row"> 
                <div class="col">
                  
                  <label for="rontgen_thorax_perawat_recoveryroom">thorax perawat recovery room:</label>
                  <input type="text" class="form-control" id="rontgen_thorax_perawat_recoveryroom" name='rontgen_thorax_perawat_recoveryroom' value="<?php echo $data['rontgen_thorax_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_thorax_perawat_ruangan"> thorax perawat ruangan:</label>
                  <input type="text" class="form-control" id="rontgen_thorax_perawat_ruangan" name='rontgen_thorax_perawat_ruangan' value="<?php echo $data['rontgen_thorax_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_thorax_keterangan"> thorax keterangan:</label>
                  <input type="text" class="form-control" id="rontgen_thorax_keterangan" name='rontgen_thorax_keterangan' value="<?php echo $data['rontgen_thorax_keterangan']; ?>">
                </div>
              
            </div>
                  <br>
                  <div class="row">
                <div class="col">
                  
                  <label for="rontgen_ctscan_perawat_recoveryroom"> ct scan perawat recovery room:</label>
                  <input type="text" class="form-control" id="rontgen_ctscan_perawat_recoveryroom" name='rontgen_ctscan_perawat_recoveryroom' value="<?php echo $data['rontgen_ctscan_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_ctscan_perawat_ruangan"> ct scan perawat ruangan:</label>
                  <input type="text" class="form-control" id="rontgen_ctscan_perawat_ruangan" name='rontgen_ctscan_perawat_ruangan' value="<?php echo $data['rontgen_ctscan_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_ctscan_keterangan"> ct scan keterangan:</label>
                  <input type="text" class="form-control" id="rontgen_ctscan_keterangan" name='rontgen_ctscan_keterangan' value="<?php echo $data['rontgen_ctscan_keterangan']; ?>">
                </div>
              </div>
            
              <br>
              <div class="row">
                <div class="col">
                  
                  <label for="rontgen_usg_perawat_recoveryroom"> usg perawat recovery room:</label>
                  <input type="text" class="form-control" id="rontgen_usg_perawat_recoveryroom" name='rontgen_usg_perawat_recoveryroom' value="<?php echo $data['rontgen_usg_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_usg_perawat_ruangan"> usg perawat ruangan:</label>
                  <input type="text" class="form-control" id="rontgen_usg_perawat_ruangan" name='rontgen_usg_perawat_ruangan' value="<?php echo $data['rontgen_usg_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_usg_keterangan"> usg keterangan:</label>
                  <input type="text" class="form-control" id="rontgen_usg_keterangan" name='rontgen_usg_keterangan' value="<?php echo $data['rontgen_usg_keterangan']; ?>">
                </div>
              
            </div>
                  <br>
                  <div class="row">
                <div class="col">
                  
                  <label for="rontgen_fotolain_perawat_recoveryroom"> fotolain perawat recovery room:</label>
                  <input type="text" class="form-control" id="rontgen_fotolain_perawat_recoveryroom" name='rontgen_fotolain_perawat_recoveryroom' value="<?php echo $data['rontgen_fotolain_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_fotolain_perawat_ruangan"> foto lain perawat ruangan:</label>
                  <input type="text" class="form-control" id="rontgen_fotolain_perawat_ruangan" name='rontgen_fotolain_perawat_ruangan' value="<?php echo $data['rontgen_fotolain_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="rontgen_fotolain_keterangan"> foto lain keterangan:</label>
                  <input type="text" class="form-control" id="rontgen_fotolain_keterangan" name='rontgen_fotolain_keterangan' value="<?php echo $data['rontgen_fotolain_keterangan']; ?>">
                </div>
              </div>
                <br>
                <h6>Barang Milik Pasien </h6>
                <div class="row">
                <div class="col">
                  
                  <label for="barang_milik_pasien_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="barang_milik_pasien_perawat_recoveryroom" name='barang_milik_pasien_perawat_recoveryroom' value="<?php echo $data['barang_milik_pasien_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="barang_milik_pasien_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="barang_milik_pasien_perawat_ruangan" name='barang_milik_pasien_perawat_ruangan' value="<?php echo $data['barang_milik_pasien_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="barang_milik_pasien_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="barang_milik_pasien_keterangan" name='barang_milik_pasien_keterangan' value="<?php echo $data['barang_milik_pasien_keterangan']; ?>">
                </div>
              </div>
            
              <br>
              <h6>Vital sign  :</h6>
              <div class="row">
                <div class="col">
                  
                  <label for="vital_sign_cek_terakhir_jam"> jam cek akhir:</label>
                  <input type="text" class="form-control" id="vital_sign_cek_terakhir_jam" name='vital_sign_cek_terakhir_jam' value="<?php echo $data['vital_sign_cek_terakhir_jam']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_nadi"> nadi:</label>
                  <input type="text" class="form-control" id="vital_sign_nadi" name='vital_sign_nadi' value="<?php echo $data['vital_sign_nadi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_suhu"> suhu:</label>
                  <input type="text" class="form-control" id="vital_sign_suhu" name='vital_sign_suhu' value="<?php echo $data['vital_sign_suhu']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_tensi_darah"> tensi darah:</label>
                  <input type="text" class="form-control" id="vital_sign_tensi_darah" name='vital_sign_tensi_darah' value="<?php echo $data['vital_sign_tensi_darah']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_respirasi"> respirasi:</label>
                  <input type="text" class="form-control" id="vital_sign_respirasi" name='vital_sign_respirasi' value="<?php echo $data['vital_sign_respirasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_skala_nyeri">skala nyeri:</label>
                  <input type="text" class="form-control" id="vital_sign_skala_nyeri" name='vital_sign_skala_nyeri' value="<?php echo $data['vital_sign_skala_nyeri']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_berat_badan"> berat badan:</label>
                  <input type="text" class="form-control" id="vital_sign_berat_badan" name='vital_sign_berat_badan' value="<?php echo $data['vital_sign_berat_badan']; ?>">
                </div>
              
            </div>
                <br>
                <div class="row">
                <div class="col">
                  
                  <label for="vital_sign_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="vital_sign_perawat_recoveryroom" name='vital_sign_perawat_recoveryroom' value="<?php echo $data['vital_sign_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="vital_sign_perawat_ruangan" name='vital_sign_perawat_ruangan' value="<?php echo $data['vital_sign_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="vital_sign_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="vital_sign_keterangan" name='vital_sign_keterangan' value="<?php echo $data['vital_sign_keterangan']; ?>">
                </div>
              </div>
            
           <br>
           <h6>Drain :</h6>
           <div class="row">
                <div class="col">
                  
                  <label for="drain_opsi"> drain opsi:</label>
                  <input type="text" class="form-control" id="drain_opsi" name='drain_opsi' value="<?php echo $data['drain_opsi']; ?>">
                </div>
              
            
                   
                <div class="col">
                  
                  <label for="drain_perawat_recoveryroom"> perawat recoveryroom:</label>
                  <input type="text" class="form-control" id="drain_perawat_recoveryroom" name='drain_perawat_recoveryroom' value="<?php echo $data['drain_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="drain_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="drain_perawat_ruangan" name='drain_perawat_ruangan' value="<?php echo $data['drain_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="drain_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="drain_keterangan" name='drain_keterangan' value="<?php echo $data['drain_keterangan']; ?>">
                </div>
              
            </div>
                   <br>
                   <h6>Luka :</h6>
                   <div class="row">
                <div class="col">
                  
                  <label for="luka_opsi"> luka opsi:</label>
                  <input type="text" class="form-control" id="luka_opsi" name='luka_opsi' value="<?php echo $data['luka_opsi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="luka_perawat_recoveryroom" name='luka_perawat_recoveryroom' value="<?php echo $data['luka_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="luka_perawat_ruangan" name='luka_perawat_ruangan' value="<?php echo $data['luka_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="luka_keterangan" name='luka_keterangan' value="<?php echo $data['luka_keterangan']; ?>">
                </div>
              </div>
            <br>
              <div class="row">
                <div class="col">
                  
                  <label for="luka_operasi_ukuran"> ukuran luka operasi:</label>
                  <input type="text" class="form-control" id="luka_operasi_ukuran" name='luka_operasi_ukuran' value="<?php echo $data['luka_operasi_ukuran']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_operasi_lokasi"> lokasi luka operasi:</label>
                  <input type="text" class="form-control" id="luka_operasi_lokasi" name='luka_operasi_lokasi' value="<?php echo $data['luka_operasi_lokasi']; ?>">
                </div>
              </div>
            <br>
              <div class="row">
                <div class="col">
                  
                  <label for="luka_bakar_ukuran">ukuran luka bakar:</label>
                  <input type="text" class="form-control" id="luka_bakar_ukuran" name='luka_bakar_ukuran' value="<?php echo $data['luka_bakar_ukuran']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_bakar_lokasi"> lokasi luka bakar:</label>
                  <input type="text" class="form-control" id="luka_bakar_lokasi" name='luka_bakar_lokasi' value="<?php echo $data['luka_bakar_lokasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="luka_bakar_kondisi"> kondisi luka bakar:</label>
                  <input type="text" class="form-control" id="luka_bakar_kondisi" name='luka_bakar_kondisi' value="<?php echo $data['luka_bakar_kondisi']; ?>">
                </div>
              </div>
                <br>
                 <div class="row">
                <div class="col">
                  
                  <label for="kulit_memerah_ukuruan"> kulit_memerah_ukuruan:</label>
                  <input type="text" class="form-control" id="kulit_memerah_ukuruan" name='kulit_memerah_ukuruan' value="<?php echo $data['kulit_memerah_ukuruan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kulit_memerah_lokasi"> kulit_memerah_lokasi:</label>
                  <input type="text" class="form-control" id="kulit_memerah_lokasi" name='kulit_memerah_lokasi' value="<?php echo $data['kulit_memerah_lokasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kulit_memerah_kondisi"> kulit_memerah_kondisi:</label>
                  <input type="text" class="form-control" id="kulit_memerah_kondisi" name='kulit_memerah_kondisi' value="<?php echo $data['kulit_memerah_kondisi']; ?>">
                </div>
              </div>
            <br>
            <h6>Invasif : </h6>
                  <div class="row">
                <div class="col">
                  
                  <label for="invasif_opsi"> invasif_opsi:</label>
                  <input type="text" class="form-control" id="invasif_opsi" name='invasif_opsi' value="<?php echo $data['invasif_opsi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="invasif_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="invasif_perawat_recoveryroom" name='invasif_perawat_recoveryroom' value="<?php echo $data['invasif_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="invasif_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="invasif_perawat_ruangan" name='invasif_perawat_ruangan' value="<?php echo $data['invasif_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="invasif_keterangan">keterangan:</label>
                  <input type="text" class="form-control" id="invasif_keterangan" name='invasif_keterangan' value="<?php echo $data['invasif_keterangan']; ?>">
                </div>
              </div>
            
                <div class="row">          
                <div class="col">
                  
                  <label for="IV_line_tanggal"> IV line tanggal:</label>
                  <input type="text" class="form-control" id="IV_line_tanggal" name='IV_line_tanggal' value="<?php echo $data['IV_line_tanggal']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="IV_line_posisi"> IV line posisi:</label>
                  <input type="text" class="form-control" id="IV_line_posisi" name='IV_line_posisi' value="<?php echo $data['IV_line_posisi']; ?>">
                </div>
              </div>
            
                 <div class="row">
                <div class="col">
                  
                  <label for="cvp_pic_tanggal"> cvp pic tanggal:</label>
                  <input type="text" class="form-control" id="cvp_pic_tanggal" name='cvp_pic_tanggal' value="<?php echo $data['cvp_pic_tanggal']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="cvp_pic_posisi"> cvp pic posisi:</label>
                  <input type="text" class="form-control" id="cvp_pic_posisi" name='cvp_pic_posisi' value="<?php echo $data['cvp_pic_posisi']; ?>">
                </div>
              </div>
            <br>
            <h6>Pemasangan Kateter urine :</h6>
                <div class="row">
                <div class="col">
                  
                  <label for="pemasangan_kateter_urine_nomor"> nomor :</label>
                  <input type="text" class="form-control" id="pemasangan_kateter_urine_nomor" name='pemasangan_kateter_urine_nomor' value="<?php echo $data['pemasangan_kateter_urine_nomor']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pemasangan_kateter_urine_tanggal"> tanggal :</label>
                  <input type="text" class="form-control" id="pemasangan_kateter_urine_tanggal" name='pemasangan_kateter_urine_tanggal' value="<?php echo $data['pemasangan_kateter_urine_tanggal']; ?>">
                </div>
              </div>
            
                  <div class="row">
                <div class="col">
                  
                  <label for="kateter_urine_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="kateter_urine_perawat_recoveryroom" name='kateter_urine_perawat_recoveryroom' value="<?php echo $data['kateter_urine_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kateter_urine_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="kateter_urine_perawat_ruangan" name='kateter_urine_perawat_ruangan' value="<?php echo $data['kateter_urine_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kateter_urine_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="kateter_urine_keterangan" name='kateter_urine_keterangan' value="<?php echo $data['kateter_urine_keterangan']; ?>">
                </div>
              
            </div>
                <br>
                <h6>Pemasangan irigasi :</h6>
                <div class="row">
                <div class="col">
                  
                  <label for="pemasangan_irigasi_tanggal"> Tanggal :</label>
                  <input type="text" class="form-control" id="pemasangan_irigasi_tanggal" name='pemasangan_irigasi_tanggal' value="<?php echo $data['pemasangan_irigasi_tanggal']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="irigasi_perawat_recoveryroom"> perawat recovery room:</label>
                  <input type="text" class="form-control" id="irigasi_perawat_recoveryroom" name='irigasi_perawat_recoveryroom' value="<?php echo $data['irigasi_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="irigasi_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="irigasi_perawat_ruangan" name='irigasi_perawat_ruangan' value="<?php echo $data['irigasi_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="irigasi_keterangan"> keterangan:</label>
                  <input type="text" class="form-control" id="irigasi_keterangan" name='irigasi_keterangan' value="<?php echo $data['irigasi_keterangan']; ?>">
                </div>
              </div>
            
                <br>
                <h6>Masalah kamar operasi :</h6>
                <div class="row">
                <div class="col">
                  
                  <label for="masalah_kamar_operasi_perawat_recoveryroom">perawat recovery room:</label>
                  <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_recoveryroom" name='masalah_kamar_operasi_perawat_recoveryroom' value="<?php echo $data['masalah_kamar_operasi_perawat_recoveryroom']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="masalah_kamar_operasi_perawat_ruangan"> perawat ruangan:</label>
                  <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_ruangan" name='masalah_kamar_operasi_perawat_ruangan' value="<?php echo $data['masalah_kamar_operasi_perawat_ruangan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="masalah_kamar_operasi_perawat_keterangan"> perawat keterangan:</label>
                  <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_keterangan" name='masalah_kamar_operasi_perawat_keterangan' value="<?php echo $data['masalah_kamar_operasi_perawat_keterangan']; ?>">
                </div>
              </div>
            <br>
                  <div class="row">
                <div class="col">
                  
                  <label for="petugas_recovery_yang_menyerahkan"> petugas recovery yang menyerahkan:</label>
                  <input type="text" class="form-control" id="petugas_recovery_yang_menyerahkan" name='petugas_recovery_yang_menyerahkan' value="<?php echo $data['petugas_recovery_yang_menyerahkan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="petugas_ruangan_yang_menerimah"> petugas ruangan yang menerimah:</label>
                  <input type="text" class="form-control" id="petugas_ruangan_yang_menerimah" name='petugas_ruangan_yang_menerimah' value="<?php echo $data['petugas_ruangan_yang_menerimah']; ?>">
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
                             
<a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle" >Kembali</a>
                      &nbsp;
                   <input type='reset' value='Batal' class='btn btn-danger'>
            &nbsp;
              <input type='submit' name='update' value='Edit' class='btn btn-warning'>
                   &nbsp;     &nbsp;
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

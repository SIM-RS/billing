
<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Form Input serah terima pasien post operasi </title>
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

      <div  style="background-color: #EAF0F0 ; width: 1000px;  margin: auto;">
            
          <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tbody><tr>
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input serah terima post operasi</td>
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
       
     <div class="row">     
            
              <div class="col">
                
                <label for="diagnosa"> diagnosa:</label>
                <input type="text" class="form-control" id="diagnosa" name='diagnosa'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="ruangan"> ruangan:</label>
                <input type="text" class="form-control" id="ruangan" name='ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="tgl_op"> tanggal op:</label>
                <input type="date" class="form-control" id="tgl_op" name='tgl_op'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="tindakan"> tindakan:</label>
                <input type="text" class="form-control" id="tindakan" name='tindakan'  required>
              </div>
             
              
     </div>
     <br>
     <h5>Blagko</h5>
     <h6>Laporan Operasi :</h6>
     <div class="row">
     
              <div class="col">
                
                <label for="blagko_laporan_operasi_perawat_recoveryroom">  perawat recovery room:</label>
                <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_recoveryroom" name='blagko_laporan_operasi_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_laporan_operasi_perawat_ruangan">  perawat ruangan:</label>
                <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_ruangan" name='blagko_laporan_operasi_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_laporan_operasi_keterangan"> perawat keterangan:</label>
                <input type="text" class="form-control" id="blagko_laporan_operasi_perawat_keterangan" name='blagko_laporan_operasi_perawat_keterangan'  required>
              </div>
             
     </div>
     <br>
     <h6>Catatan Anestesi :</h6>
     <div class="row"> 
              <div class="col">
                
                <label for="blagko_catatan_anestesi_perawat_recoveryroom"> perawat recoveryroom:</label>
                <input type="text" class="form-control" id="blagko_catatan_anestesi_perawat_recoveryroom" name='blagko_catatan_anestesi_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_catatan_anestesi_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="blagko_catatan_anestesi_perawat_ruangan" name='blagko_catatan_anestesi_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_catatan_anestesi_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="blagko_catatan_anestesi_keterangan" name='blagko_catatan_anestesi_keterangan'  required>
              </div>
             
     </div>
     
           <br>
           <h6>Pemakaian Alat : </h6> 
           <div class="row">
              <div class="col">
                
                <label for="blagko_pemakaian_alat_perawat_recoveryroom"> perawat recoveryroom:</label>
                <input type="text" class="form-control" id="blagko_pemakaian_alat_perawat_recoveryroom" name='blagko_pemakaian_alat_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_pemakaian_alat_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="blagko_pemakaian_alat_perawat_ruangan" name='blagko_pemakaian_alat_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blagko_pemakaian_alat_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="blagko_pemakaian_alat_keterangan" name='blagko_pemakaian_alat_keterangan'  required>
              </div>
     </div>  
              
            <br>
            <h6>Blangko :</h6>
            <div class="row">
              <div class="col">
                
                <label for="blangko_perawat_recoveryroom"> perawat recoveryroom:</label>
                <input type="text" class="form-control" id="blangko_perawat_recoveryroom" name='blangko_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blangko_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="blangko_perawat_ruangan" name='blangko_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="blangko_keterangan"> perawat keterangan:</label>
                <input type="text" class="form-control" id="blangko_keterangan" name='blangko_keterangan'  required>
              </div>
            </div>
              
            <br>
            <h5>RontGen :</h5>
            <div class="row">
              <div class="col">
                
                <label for="rontgen_thorax_perawat_recoveryroom"> thorax perawat recovery room:</label>
                <input type="text" class="form-control" id="rontgen_thorax_perawat_recoveryroom" name='rontgen_thorax_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_thorax_perawat_ruangan"> thorax perawat ruangan:</label>
                <input type="text" class="form-control" id="rontgen_thorax_perawat_ruangan" name='rontgen_thorax_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_thorax_keterangan"> thorax keterangan:</label>
                <input type="text" class="form-control" id="rontgen_thorax_keterangan" name='rontgen_thorax_keterangan'  required>
              </div>
            </div>
            <br>
            <div class="row">
              
            
              <div class="col">
                
                <label for="rontgen_ctscan_perawat_recoveryroom"> ct scan perawat recovery room:</label>
                <input type="text" class="form-control" id="rontgen_ctscan_perawat_recoveryroom" name='rontgen_ctscan_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_ctscan_perawat_ruangan"> ct scan perawat ruangan:</label>
                <input type="text" class="form-control" id="rontgen_ctscan_perawat_ruangan" name='rontgen_ctscan_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_ctscan_keterangan"> ct scan keterangan:</label>
                <input type="text" class="form-control" id="rontgen_ctscan_keterangan" name='rontgen_ctscan_keterangan'  required>
              </div>
             
            </div>
            <br>
            <div class="row">
            
              <div class="col">
                
                <label for="rontgen_usg_perawat_recoveryroom"> usg perawat recovery room:</label>
                <input type="text" class="form-control" id="rontgen_usg_perawat_recoveryroom" name='rontgen_usg_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_usg_perawat_ruangan"> usg perawat ruangan:</label>
                <input type="text" class="form-control" id="rontgen_usg_perawat_ruangan" name='rontgen_usg_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_usg_keterangan"> usg keterangan:</label>
                <input type="text" class="form-control" id="rontgen_usg_keterangan" name='rontgen_usg_keterangan'  required>
              </div>
            </div>
            <br>
            <div class="row">  
            
              <div class="col">
                
                <label for="rontgen_fotolain_perawat_recoveryroom"> fotolain perawat recovery room:</label>
                <input type="text" class="form-control" id="rontgen_fotolain_perawat_recoveryroom" name='rontgen_fotolain_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_fotolain_perawat_ruangan"> fotolain perawat ruangan:</label>
                <input type="text" class="form-control" id="rontgen_fotolain_perawat_ruangan" name='rontgen_fotolain_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="rontgen_fotolain_keterangan"> fotolain keterangan:</label>
                <input type="text" class="form-control" id="rontgen_fotolain_keterangan" name='rontgen_fotolain_keterangan'  required>
              </div>
            
            </div>
            <br>
            <h6>Barang Milik pasien :</h6>
            <div class="row">
              <div class="col">
                
                <label for="barang_milik_pasien_perawat_recoveryroom"> perawat recovery room:</label>
                <input type="text" class="form-control" id="barang_milik_pasien_perawat_recoveryroom" name='barang_milik_pasien_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="barang_milik_pasien_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="barang_milik_pasien_perawat_ruangan" name='barang_milik_pasien_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="barang_milik_pasien_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="barang_milik_pasien_keterangan" name='barang_milik_pasien_keterangan'  required>
              </div>
            </div>
              
            <br>
            <h6>Vital sign :</h6>
            <div class="row">
              <div class="col">
                
                <label for="vital_sign_cek_terakhir_jam"> cek akhir jam:</label>
                <input type="text" class="form-control" id="vital_sign_cek_terakhir_jam" name='vital_sign_cek_terakhir_jam'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_nadi"> nadi:</label>
                <input type="text" class="form-control" id="vital_sign_nadi" name='vital_sign_nadi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_suhu"> suhu:</label>
                <input type="text" class="form-control" id="vital_sign_suhu" name='vital_sign_suhu'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_tensi_darah"> darah:</label>
                <input type="text" class="form-control" id="vital_sign_tensi_darah" name='vital_sign_tensi_darah'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_respirasi"> respirasi:</label>
                <input type="text" class="form-control" id="vital_sign_respirasi" name='vital_sign_respirasi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_skala_nyeri"> nyeri:</label>
                <input type="text" class="form-control" id="vital_sign_skala_nyeri" name='vital_sign_skala_nyeri'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_berat_badan"> berat badan:</label>
                <input type="text" class="form-control" id="vital_sign_berat_badan" name='vital_sign_berat_badan'  required>
              </div>
            </div> 
              
            <br>
            <div class="row">
              <div class="col">
                
                <label for="vital_sign_perawat_recoveryroom"> perawat recovery room:</label>
                <input type="text" class="form-control" id="vital_sign_perawat_recoveryroom" name='vital_sign_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="vital_sign_perawat_ruangan" name='vital_sign_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="vital_sign_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="vital_sign_keterangan" name='vital_sign_keterangan'  required>
              </div>
            </div>
              
            <br>
            <h6>Drain :</h6>
            <div class="row">
              <div class="col">
                
                <label for="drain_opsi"> drain opsi:</label>
                <select class="form-control"   id="drain_opsi" name='drain_opsi' required multiple>
                  <option>Drainase WSD</option>
                  <option>Drain Luka</option>
                  <option>Rectal Tube</option>
                </select>
              
              </div>
             
              
            
              <div class="col">
                
                <label for="drain_perawat_recoveryroom">  perawat recovery room:</label>
                <input type="text" class="form-control" id="drain_perawat_recoveryroom" name='drain_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="drain_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="drain_perawat_ruangan" name='drain_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="drain_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="drain_keterangan" name='drain_keterangan'  required>
              </div>
             </div>
              <br>
              <h6>luka</h6>
              <div class="row">
              <div class="col">
                
                <label for="luka_opsi"> luka opsi:</label>
                <select class="form-control" id="luka_opsi" name='luka_opsi'  required multiple>
                  <option>Integrasi Kulit/Luka</option>
                  <option>Tidak Ada Luka</option>
                </select>
              
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_perawat_recoveryroom"> perawat recovery room:</label>
                <input type="text" class="form-control" id="luka_perawat_recoveryroom" name='luka_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="luka_perawat_ruangan" name='luka_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="luka_keterangan" name='luka_keterangan'  required>
              </div>
              </div>
              <br>
            <div class="row">
              <div class="col">
                
                <label for="luka_operasi_ukuran"> ukuran luka operasi:</label>
                <input type="text" class="form-control" id="luka_operasi_ukuran" name='luka_operasi_ukuran'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_operasi_lokasi"> lokasi luka operasi:</label>
                <input type="text" class="form-control" id="luka_operasi_lokasi" name='luka_operasi_lokasi'  required>
              </div>
            </div>
              <br>
            <div class="row">
              <div class="col">
                
                <label for="luka_bakar_ukuran"> ukuran luka bakar:</label>
                <input type="text" class="form-control" id="luka_bakar_ukuran" name='luka_bakar_ukuran'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_bakar_lokasi"> lokasi luka bakar:</label>
                <input type="text" class="form-control" id="luka_bakar_lokasi" name='luka_bakar_lokasi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="luka_bakar_kondisi"> kondisi luka bakar:</label>
                <input type="text" class="form-control" id="luka_bakar_kondisi" name='luka_bakar_kondisi'  required>
              </div>
             
            </div>
            <br>
            <div class="row">
              <div class="col">
                
                <label for="kulit_memerah_ukuruan"> ukuran kulit memerah:</label>
                <input type="text" class="form-control" id="kulit_memerah_ukuruan" name='kulit_memerah_ukuruan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="kulit_memerah_lokasi"> lokasi kulit memerah:</label>
                <input type="text" class="form-control" id="kulit_memerah_lokasi" name='kulit_memerah_lokasi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="kulit_memerah_kondisi"> kondisi kulit memerah:</label>
                <input type="text" class="form-control" id="kulit_memerah_kondisi" name='kulit_memerah_kondisi'  required>
              </div>
            </div>
              
            <br>
            <h6>Invasif :</h6>
            <div class="row">
              <div class="col">
                
                <label for="invasif_opsi"> invasif :</label>
                <select class="form-control" id="invasif_opsi" name='invasif_opsi'  required multiple>
                  <option>Line Invasif</option>
                   <option>Tidak Ada Line Invasif</option>
                </select>
               
              </div>
             
              
            
              <div class="col">
                
                <label for="invasif_perawat_recoveryroom"> perawat recovery room:</label>
                <input type="text" class="form-control" id="invasif_perawat_recoveryroom" name='invasif_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="invasif_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="invasif_perawat_ruangan" name='invasif_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="invasif_keterangan">keterangan:</label>
                <input type="text" class="form-control" id="invasif_keterangan" name='invasif_keterangan'  required>
              </div>
             
          </div>
          <div class="row">
            
              <div class="col">
                
                <label for="IV_line_tanggal"> IV line tanggal:</label>
                <input type="text" class="form-control" id="IV_line_tanggal" name='IV_line_tanggal'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="IV_line_posisi"> IV line posisi:</label>
                <input type="text" class="form-control" id="IV_line_posisi" name='IV_line_posisi'  required>
              </div>
          </div>
              
          <div class="row">
              <div class="col">
                
                <label for="cvp_pic_tanggal"> cvp pic tanggal:</label>
                <input type="text" class="form-control" id="cvp_pic_tanggal" name='cvp_pic_tanggal'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="cvp_pic_posisi"> cvp pic posisi:</label>
                <input type="text" class="form-control" id="cvp_pic_posisi" name='cvp_pic_posisi'  required>
              </div>
          </div>
              
            <br>
            <h6>Pemasangan kateter urine</h6>
            <div class="row">
              <div class="col">
                
                <label for="pemasangan_kateter_urine_nomor"> nomor :</label>
                <input type="text" class="form-control" id="pemasangan_kateter_urine_nomor" name='pemasangan_kateter_urine_nomor'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pemasangan_kateter_urine_tanggal">tanggal :</label>
                <input type="text" class="form-control" id="pemasangan_kateter_urine_tanggal" name='pemasangan_kateter_urine_tanggal'  required>
              </div>
            </div>
              
            <div class="row">
              <div class="col">
                
                <label for="kateter_urine_perawat_recoveryroom"> urine perawat recovery room:</label>
                <input type="text" class="form-control" id="kateter_urine_perawat_recoveryroom" name='kateter_urine_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="kateter_urine_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="kateter_urine_perawat_ruangan" name='kateter_urine_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="kateter_urine_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="kateter_urine_keterangan" name='kateter_urine_keterangan'  required>
              </div>
            </div>
              
            <br>
            <h6>Pemasangan irigasi</h6>
            <div class="row">
              <div class="col">
                
                <label for="pemasangan_irigasi_tanggal"> tanggal:</label>
                <input type="text" class="form-control" id="pemasangan_irigasi_tanggal" name='pemasangan_irigasi_tanggal'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="irigasi_perawat_recoveryroom"> perawat recoveryroom:</label>
                <input type="text" class="form-control" id="irigasi_perawat_recoveryroom" name='irigasi_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="irigasi_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="irigasi_perawat_ruangan" name='irigasi_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="irigasi_keterangan"> keterangan:</label>
                <input type="text" class="form-control" id="irigasi_keterangan" name='irigasi_keterangan'  required>
              </div>
             
            </div>
            <br>
            <h6>Masalah Kamar Operasi :</h6>
            <div class="row">
              <div class="col">
                
                <label for="masalah_kamar_operasi_perawat_recoveryroom"> perawat recovery room:</label>
                <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_recoveryroom" name='masalah_kamar_operasi_perawat_recoveryroom'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="masalah_kamar_operasi_perawat_ruangan"> perawat ruangan:</label>
                <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_ruangan" name='masalah_kamar_operasi_perawat_ruangan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="masalah_kamar_operasi_perawat_keterangan"> perawat keterangan:</label>
                <input type="text" class="form-control" id="masalah_kamar_operasi_perawat_keterangan" name='masalah_kamar_operasi_perawat_keterangan'  required>
              </div>
             
            </div>
            <br>
            <div class="row">
              <div class="col">
                
                <label for="petugas_recovery_yang_menyerahkan"> petugas recovery yang menyerahkan:</label>
                <input type="text" class="form-control" id="petugas_recovery_yang_menyerahkan" name='petugas_recovery_yang_menyerahkan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="petugas_ruangan_yang_menerimah"> petugas ruangan yang menerimah:</label>
                <input type="text" class="form-control" id="petugas_ruangan_yang_menerimah" name='petugas_ruangan_yang_menerimah'  required>
              </div>
            </div>
             
              
            
              <div class="col">
                
        
                <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj?>" required>
  
                <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel?>" required>
         
                <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien ?>" required>
           
                <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?= $idUser?>"  required>
              </div>
             
              
          <br>
          <div class='btn-group' style='float:right;'>
                      
<a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;"><img src="http://localhost:7777/simrs-pelindo/billing/icon/back.png" width="20" align="absmiddle" >Kembali</a>
                &nbsp;
           <input type='reset' value='Batal' class='btn btn-danger'>
          &nbsp;
            <input type='submit' name='insert' value='Save' class='btn btn-success'>
             &nbsp;    &nbsp;
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


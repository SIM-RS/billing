
<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Form Input rm transfer external </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input transfer external</td>
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
                
                <label for="ruang"> ruang:</label>
                <input type="text" class="form-control" id="ruang" name='ruang'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="kelas"> kelas:</label>
                <input type="text" class="form-control" id="kelas" name='kelas'  required>
              </div>
          </div>
          <div class="row">
              
            
              <div class="col">
                
                <label for="dpjp"> dpjp:</label>
                <input type="text" class="form-control" id="dpjp" name='dpjp'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="ppjp"> ppjp:</label>
                <input type="text" class="form-control" id="ppjp" name='ppjp'  required>
              </div>
          </div>
          <hr>
          <h6>Rumah sakit yang di hubungi :</h6> 
              <div class="row">
         
              <div class="col">
                
                <label for="rs_tujuan"> rs tujuan:</label>
                <input type="text" class="form-control" id="rs_tujuan" name='rs_tujuan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="nama_petugas_dihubungi"> nama petugas yang dihubungi:</label>
                <input type="text" class="form-control" id="nama_petugas_dihubungi" name='nama_petugas_dihubungi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="tanggal_menghubungi"> tanggal menghubungi:</label>
                <input type="date" class="form-control" id="tanggal_menghubungi" name='tanggal_menghubungi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="jam_menghubungi"> jam menghubungi:</label>
                <input type="time" class="form-control" id="jam_menghubungi" name='jam_menghubungi'  required>
              </div>
              </div>
              <hr>
              <h6>Transfer :</h6>
              <div class="row">
              <div class="col">
                
                <label for="alasan_transfer"> alasan transfer:</label>

              <select class="form-control" id="alasan_transfer" name='alasan_transfer'  required multiple>
                <option>Ketiadaan fasilitas dan sarana   </option>
                <option>Pemeriksaan Penunjang  </option>
                <option>Ketiadaan SDM</option>
                <option>Permintaan Pasien/Keluarga</option>
              </select>
              </div>
             
              
            
              <div class="col">
                
                <label for="tanggal_transfer"> tanggal transfer:</label>
                <input type="date" class="form-control" id="tanggal_transfer" name='tanggal_transfer'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="jam_transfer"> jam transfer:</label>
                <input type="time" class="form-control" id="jam_transfer" name='jam_transfer'  required>
              </div>
              </div>
           <br>
              <div class="row">
              <div class="col">
                
                <label for="kategori_pasien_transfer"> kategori pasien transfer:</label>

              <select class="form-control" id="kategori_pasien_transfer" name='kategori_pasien_transfer'  required multiple>
                <option>Level 0    </option>
                <option>Level 1    </option>
                <option>Level 2    </option>
                <option>Level 3    </option>
              </select>
              </div>
             
              
            
              <div class="col">
                
                <label for="jenis_ambulans"> jenis ambulans:</label>
             
              <select class="form-control" id="jenis_ambulans" name='jenis_ambulans'  required multiple>
                <option>Transportasi	</option>
                <option>Gawat Darurat</option>
              </select>
              </div>
             
              
            
              <div class="col">
                
                <label for="diagnosis"> diagnosis:</label>
            
                <textarea class="form-control" id="diagnosis" name='diagnosis'  required></textarea>
              </div>
             
              </div>
              <hr>
              <h6>Temuan Penting saat pasien dirawat :</h6>
            <div class="row">
              <div class="col">
                
                <label for="temuan_penting_pasien"> temuan penting pasien:</label>
     
              <textarea  class="form-control" id="temuan_penting_pasien" name='temuan_penting_pasien'  required></textarea>
              </div>
             
              
            
              <div class="col">
                
                <label for="prosedur"> prosedur:</label>

                <textarea class="form-control" id="prosedur" name='prosedur'  required></textarea>
              </div>
             
              
            
              <div class="col">
                
                <label for="alat_pemasangan"> alat yang dipasang:</label>
          
             <textarea class="form-control" id="alat_pemasangan" name='alat_pemasangan'  required ></textarea>
              </div>
             
              
            
              <div class="col">
                
                <label for="tanggal_pemasangan"> tanggal pemasangan:</label>
                <input type="date" class="form-control" id="tanggal_pemasangan" name='tanggal_pemasangan'  required>
              </div>
             
            </div>
          
             
              
            
            
            <hr>
            <h6>Obat/cairan yang dibawa pada saat transfer :</h6>
            <div class="row">
              <div class="col">
                
                <label for="obat_saat_transfer"> obat saat transfer:</label>
                <input type="text" class="form-control" id="obat_saat_transfer" name='obat_saat_transfer'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="jumlah_obat_transfer"> jumlah obat transfer:</label>
                <input type="text" class="form-control" id="jumlah_obat_transfer" name='jumlah_obat_transfer'  required>
              </div>
             
              </div>
              <hr>
              <h6>Status Awal Pasien Saat Akan Ditransfer :</h6>
              <div class="row">
            
              <div class="col">
                
                <label for="pasien_akan_transfer_kesadaran"> kesadaran:</label>
                <input type="text" class="form-control" id="pasien_akan_transfer_kesadaran" name='pasien_akan_transfer_kesadaran'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_akan_transfer_td"> TD:</label>
                <input type="text" class="form-control" placeholder="mmHg" id="pasien_akan_transfer_td" name='pasien_akan_transfer_td'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_akan_transfer_hr"> HR:</label>
                <input type="text" class="form-control" placeholder="x/mnt" id="pasien_akan_transfer_hr" name='pasien_akan_transfer_hr'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_akan_transfer_rr">RR:</label>
                <input type="text" class="form-control" placeholder="x/mnt" id="pasien_akan_transfer_rr" name='pasien_akan_transfer_rr'  required>
              </div>
             
              </div>
              <hr>
              <h6>Status Pasien Selama Transfer :</h6>
              <div class="row">
            
              <div class="col">
                
                <label for="pasien_selama_transfer_kesadaran"> kesadaran:</label>
                <input type="text" class="form-control" id="pasien_selama_transfer_kesadaran" name='pasien_selama_transfer_kesadaran'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_selama_transfer_td">TD:</label>
                <input type="text" class="form-control" placeholder="mmHg" id="pasien_selama_transfer_td" name='pasien_selama_transfer_td'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_selama_transfer_hr"> HR:</label>
                <input type="text" class="form-control" placeholder="x/mnt" id="pasien_selama_transfer_hr" name='pasien_selama_transfer_hr'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="pasien_selama_transfer_rr"> RR:</label>
                <input type="text" class="form-control" placeholder="x/mnt" id="pasien_selama_transfer_rr" name='pasien_selama_transfer_rr'  required>
              </div>
             
              </div>
              <hr>

              <div class="col">
                
                <label for="obat_pasien_saat_ini"> obat pasien saat ini:</label>
          
             <textarea class="form-control" id="obat_pasien_saat_ini" name='obat_pasien_saat_ini'  required ></textarea>
              </div>
              <div class="col">
                
                <label for="kejadian_selama_transfer"> kejadian selama transfer:</label>
          
             <textarea class="form-control" id="kejadian_selama_transfer" name='kejadian_selama_transfer'  required ></textarea>
              </div>
              <hr>
              <div class="row">
                
            
              <div class="col">
                
                <label for="petugas_yang_menyerahkan"> petugas yang menyerahkan:</label>
                <input type="text" class="form-control" id="petugas_yang_menyerahkan" name='petugas_yang_menyerahkan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="petugas_yang_menerima"> petugas yang menerima:</label>
                <input type="text" class="form-control" id="petugas_yang_menerima" name='petugas_yang_menerima'  required>
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


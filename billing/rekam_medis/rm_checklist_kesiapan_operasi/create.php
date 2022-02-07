
<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Form Input checklist kesiapan operasi </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Input checklist kesiapan operasi</td>
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
       
          
            <div style="border: 2px solid black; padding: 5px ; max-width: 240px; border-radius: 10px;">
          <h6>SIGN IN</h6>
          </div>
  
              <div class="col">
                
                <label for="signin_opsi_pertama">Apakah pasien sudah dikonfirmasi identitas, lokasi, prosedur dan informent consent?</label>
                <br>
                <label><input type="checkbox" id="signin_opsi_pertama" name='signin_opsi_pertama'  required> Ya </label>
              
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_kedua">Apakah tempat operasi sudah ditandai?</label>
                <br>
                <label><input type="checkbox"  id="signin_opsi_kedua" name='signin_opsi_kedua'> Ya </label>
                <label><input type="checkbox"  id="signin_opsi_kedua" name='signin_opsi_kedua'  > Tidak Di Perlukan </label>
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_ketiga"> Apakah mesin anastesi dan pramedikasi sudah diperiksa dan lengkap?</label>
                <br>
                <label> <input type="checkbox" id="signin_opsi_ketiga" name='signin_opsi_ketiga'  required> Ya </label>
            
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_keempat"> Apakah pulse oksi metri sudah terpasang pada pasien dan berfungsi dengan baik?</label>
                <br>
                <label><input type="checkbox"  id="signin_opsi_keempat" name='signin_opsi_keempat'  required> Ya </label>
            
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_kelima"> Apakah pasien memiliki riwayat alergi ?</label>
                <br>
                <label><input type="checkbox"  id="signin_opsi_kelima" name='signin_opsi_kelima'  > Ya </label>
                <label><input type="checkbox"  id="signin_opsi_kelima" name='signin_opsi_kelima' > Tidak </label>
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_keenam">Apakah pasien memiliki kesulitan jalan nafas ataun resiko aspirasi?</label>
                <br>
                <label><input type="checkbox"  id="signin_opsi_keenam" name='signin_opsi_keenam' > Tidak </label>
                <label><input type="checkbox"  id="signin_opsi_keenam" name='signin_opsi_keenam' >  	Ya, dan tersedia perlatan dan bantuan </label>
              </div>
             
              
            
              <div class="col">
                
                <label for="signin_opsi_ketujuh">Apakah pasien memiliki risiko hilangnya darah>50 ml (7 ml/kg pada anak-anak)?</label>
                <br>
                <label><input type="checkbox"  id="signin_opsi_ketujuh" name='signin_opsi_ketujuh'  > Tidak </label>
                <label><input type="checkbox"  id="signin_opsi_ketujuh" name='signin_opsi_ketujuh'  >	Ya,sudah tersedia dua akses intrafena /sentral cairan</label>
              </div>
             
              
            
              <div class="col-md-7">
                
                <label for="signin_anastesi"> Anastesi:</label>
                <input type="text" class="form-control" id="signin_anastesi" name='signin_anastesi'  required>
              </div>
        
            &nbsp; &nbsp; &nbsp;<div style="border: 2px solid black; padding: 5px ; max-width: 240px; border-radius: 10px;">
          <h6>TIME OUT</h6>
          </div>
  
              <div class="col-md-7">
                <label><input type="checkbox"  required> 	Konfirmasi semua anggota tim sudah memperkenalkan nama dan peran </label>
              </div>
            
              <div class="col-md-7">
                
                <label for="timeout_operator"> operator:</label>
                <input type="text" class="form-control" id="timeout_operator" name='timeout_operator'  required>
              </div>
             
              
            
              <div class="col-md-7">
                
                <label for="timeout_asisten"> asisten:</label>
                <input type="text" class="form-control" id="timeout_asisten" name='timeout_asisten'  required>
              </div>
             
              
            
              <div class="col-md-7">
                
                <label for="timeout_instrument"> instrument:</label>
                <input type="text" class="form-control" id="timeout_instrument" name='timeout_instrument'  required>
              </div>
             
              
              <div class="col-md-7">
                
                <label for="timeout_sirkuler"> sirkuler:</label>
                <input type="text" class="form-control" id="timeout_sirkuler" name='timeout_sirkuler'  required>
              </div>
             
              <br>
              <div class="col-md-7">
                <label><input type="checkbox"  required>  	Konfirmasi nama pasien prosedur dan dimana insisi akan dilakukan </label>
              </div>
            
          
              <div class="col-md-7">
                
                <label for="timeout_prosedur"> prosedur:</label>
                <input type="text" class="form-control" id="timeout_prosedur" name='timeout_prosedur'  required>
              </div>
             
              
            
           
              <div class="col-md-7">
                
                <label for="timeout_lokasi_inisiasi"> lokasi inisiasi:</label>
                <input type="text" class="form-control" id="timeout_lokasi_inisiasi" name='timeout_lokasi_inisiasi'  required>
              </div>
             
              
            <br>
              <div class="col">
                
                <label for="timeout_opsi_pertama"> Apakah antibiotik profilikasis sudah diberikan dalam 60 menit terakhir?</label>
                <br>
               <label><input type="checkbox" id="timeout_opsi_pertama" name='timeout_opsi_pertama'  >Ya</label>
               <label><input type="checkbox" id="timeout_opsi_pertama" name='timeout_opsi_pertama' >Tidak</label>
              </div>
             
              
       
              <div class="col">
                <b>Antisipasi keadaan kritis </b>
                <br>
                <label for="timeout_opsi_kedua">Untuk Dokter Bedah </label>
                <br>
                <label><input type="checkbox" id="timeout_opsi_kedua" name='timeout_opsi_kedua' > 	Apakah terdapat keadaan kritis atau langkah yang tidak rutin?</label>
                <br>
                <label><input type="checkbox" id="timeout_opsi_kedua" name='timeout_opsi_kedua' >  	Beberapa lama keadaan tersebut akan berlangsung ?</label>
                <br>
                <label><input type="checkbox" id="timeout_opsi_kedua" name='timeout_opsi_kedua' >  	 	Apakah yang di antisipasi terhadap kehilangan darah</label>
              </div>
              <br>
              
            
              <div class="col">
                <b>Untuk Anatesi</b>
                <br>
              <label><input type="checkbox"  id="timeout_opsi_ketiga" name='timeout_opsi_ketiga'  required> Apakah ada sesuatu yang pas terhadap pasien </label>
              </div>
             
              
            
              <div class="col">
                <b>Untuk Tim Perawat</b>
                <br>
       
               <label> <input type="checkbox"  id="timeout_opsi_keempat" name='timeout_opsi_keempat'  required>Apakah sterilitas telah dikonfirmasi (berdasarakanb indicator alat sterilisasi )?</label>
               <label> <input type="checkbox"  id="timeout_opsi_keempat" name='timeout_opsi_keempat'  required>Apakah terhadap permasalahan alat atau perhatian lainnya?</label>
              </div>
             
              
            
              <div class="col">
                
                <label for="timeout_opsi_kelima"><b>Apakah foto telah di tampilkan ?</b></label>
                <br>
               <label><input type="checkbox"  id="timeout_opsi_kelima" name='timeout_opsi_kelima'  required>Ya</label>
               <label><input type="checkbox"  id="timeout_opsi_kelima" name='timeout_opsi_kelima'  required>Tidak Diperlukan</label>
              </div>
             
              
            
              <div class="col">
                
                <label for="timeout_opsi_keenam">Apakah imaging yang di perlukan sudah terpasang?</label>
                <br>
               <label><input type="checkbox"  id="timeout_opsi_keenam" name='timeout_opsi_keenam'  >Ya</label>
               <label><input type="checkbox" id="timeout_opsi_keenam" name='timeout_opsi_keenam'  >Tidak Di Perlukan</label>
              </div>
             
              
            
              <div class="col-md-7">
                
                <label for="timeout_perawat_sirkuaer">perawat sirkuaer:</label>
                <input type="text" class="form-control" id="timeout_perawat_sirkuaer" name='timeout_perawat_sirkuaer'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="signout_opsi_pertama"> signout_opsi_pertama:</label>
                <input type="text" class="form-control" id="signout_opsi_pertama" name='signout_opsi_pertama'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="signout_opsi_kedua"> signout_opsi_kedua:</label>
                <input type="text" class="form-control" id="signout_opsi_kedua" name='signout_opsi_kedua'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="id_kunjungan"> id_kunjungan:</label>
                <input type="text" class="form-control" id="id_kunjungan" name='id_kunjungan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="id_pelayanan"> id_pelayanan:</label>
                <input type="text" class="form-control" id="id_pelayanan" name='id_pelayanan'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="id_pasien"> id_pasien:</label>
                <input type="text" class="form-control" id="id_pasien" name='id_pasien'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="id_user"> id_user:</label>
                <input type="text" class="form-control" id="id_user" name='id_user'  required>
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



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
    <title> Form Edit rm_checklist_kesiapan_operasi </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit rm_checklist_kesiapan_operasi</td>
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
               

                <div class="col">
                  
                  <label for="signin_opsi_pertama"> signin_opsi_pertama:</label>
                  <input type="text" class="form-control" id="signin_opsi_pertama" name='signin_opsi_pertama' value="<?php echo $data['signin_opsi_pertama']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_kedua"> signin_opsi_kedua:</label>
                  <input type="text" class="form-control" id="signin_opsi_kedua" name='signin_opsi_kedua' value="<?php echo $data['signin_opsi_kedua']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_ketiga"> signin_opsi_ketiga:</label>
                  <input type="text" class="form-control" id="signin_opsi_ketiga" name='signin_opsi_ketiga' value="<?php echo $data['signin_opsi_ketiga']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_keempat"> signin_opsi_keempat:</label>
                  <input type="text" class="form-control" id="signin_opsi_keempat" name='signin_opsi_keempat' value="<?php echo $data['signin_opsi_keempat']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_kelima"> signin_opsi_kelima:</label>
                  <input type="text" class="form-control" id="signin_opsi_kelima" name='signin_opsi_kelima' value="<?php echo $data['signin_opsi_kelima']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_keenam"> signin_opsi_keenam:</label>
                  <input type="text" class="form-control" id="signin_opsi_keenam" name='signin_opsi_keenam' value="<?php echo $data['signin_opsi_keenam']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_opsi_ketujuh"> signin_opsi_ketujuh:</label>
                  <input type="text" class="form-control" id="signin_opsi_ketujuh" name='signin_opsi_ketujuh' value="<?php echo $data['signin_opsi_ketujuh']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signin_anastesi"> signin_anastesi:</label>
                  <input type="text" class="form-control" id="signin_anastesi" name='signin_anastesi' value="<?php echo $data['signin_anastesi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_operator"> timeout_operator:</label>
                  <input type="text" class="form-control" id="timeout_operator" name='timeout_operator' value="<?php echo $data['timeout_operator']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_asisten"> timeout_asisten:</label>
                  <input type="text" class="form-control" id="timeout_asisten" name='timeout_asisten' value="<?php echo $data['timeout_asisten']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_instrument"> timeout_instrument:</label>
                  <input type="text" class="form-control" id="timeout_instrument" name='timeout_instrument' value="<?php echo $data['timeout_instrument']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_sirkuler"> timeout_sirkuler:</label>
                  <input type="text" class="form-control" id="timeout_sirkuler" name='timeout_sirkuler' value="<?php echo $data['timeout_sirkuler']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_prosedur"> timeout_prosedur:</label>
                  <input type="text" class="form-control" id="timeout_prosedur" name='timeout_prosedur' value="<?php echo $data['timeout_prosedur']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_lokasi_inisiasi"> timeout_lokasi_inisiasi:</label>
                  <input type="text" class="form-control" id="timeout_lokasi_inisiasi" name='timeout_lokasi_inisiasi' value="<?php echo $data['timeout_lokasi_inisiasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_pertama"> timeout_opsi_pertama:</label>
                  <input type="text" class="form-control" id="timeout_opsi_pertama" name='timeout_opsi_pertama' value="<?php echo $data['timeout_opsi_pertama']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_kedua"> timeout_opsi_kedua:</label>
                  <input type="text" class="form-control" id="timeout_opsi_kedua" name='timeout_opsi_kedua' value="<?php echo $data['timeout_opsi_kedua']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_ketiga"> timeout_opsi_ketiga:</label>
                  <input type="text" class="form-control" id="timeout_opsi_ketiga" name='timeout_opsi_ketiga' value="<?php echo $data['timeout_opsi_ketiga']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_keempat"> timeout_opsi_keempat:</label>
                  <input type="text" class="form-control" id="timeout_opsi_keempat" name='timeout_opsi_keempat' value="<?php echo $data['timeout_opsi_keempat']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_kelima"> timeout_opsi_kelima:</label>
                  <input type="text" class="form-control" id="timeout_opsi_kelima" name='timeout_opsi_kelima' value="<?php echo $data['timeout_opsi_kelima']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_opsi_keenam"> timeout_opsi_keenam:</label>
                  <input type="text" class="form-control" id="timeout_opsi_keenam" name='timeout_opsi_keenam' value="<?php echo $data['timeout_opsi_keenam']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="timeout_perawat_sirkuaer"> timeout_perawat_sirkuaer:</label>
                  <input type="text" class="form-control" id="timeout_perawat_sirkuaer" name='timeout_perawat_sirkuaer' value="<?php echo $data['timeout_perawat_sirkuaer']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signout_opsi_pertama"> signout_opsi_pertama:</label>
                  <input type="text" class="form-control" id="signout_opsi_pertama" name='signout_opsi_pertama' value="<?php echo $data['signout_opsi_pertama']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="signout_opsi_kedua"> signout_opsi_kedua:</label>
                  <input type="text" class="form-control" id="signout_opsi_kedua" name='signout_opsi_kedua' value="<?php echo $data['signout_opsi_kedua']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="id_kunjungan"> id_kunjungan:</label>
                  <input type="text" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="id_pelayanan"> id_pelayanan:</label>
                  <input type="text" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="id_pasien"> id_pasien:</label>
                  <input type="text" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="id_user"> id_user:</label>
                  <input type="text" class="form-control" id="id_user" name='id_user' value="<?php echo $data['id_user']; ?>">
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

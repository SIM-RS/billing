
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
    <title> Form Edit asesmen khusus restrain </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit asesmen khusus restrain</td>
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
                 <h5> PENGKAJIAN FISIK DAN MENTAL </h5>
                 <br>
                 <h6>  Kesadaran   </h6>
                  <h6>  GCS  : </h6>
                
<div class="row">

                <div class="col">
                  
                  <label for="gcs_e"> E:</label>
                  <input type="text" class="form-control" id="gcs_e" name='gcs_e' value="<?php echo $data['gcs_e']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="gcs_v"> v:</label>
                  <input type="text" class="form-control" id="gcs_v" name='gcs_v' value="<?php echo $data['gcs_v']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="gcs_m"> M:</label>
                  <input type="text" class="form-control" id="gcs_m" name='gcs_m' value="<?php echo $data['gcs_m']; ?>">
                </div>
              
</div>
<br>
<h6>Reflek Cahaya</h6>
<div class="row">

                <div class="col">
                  
                  <label for="reflek_cahaya_ka">Ka:</label>
                  <input type="text" class="form-control" id="reflek_cahaya_ka" name='reflek_cahaya_ka' value="<?php echo $data['reflek_cahaya_ka']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="reflek_cahaya_ki">Ki:</label>
                  <input type="text" class="form-control" id="reflek_cahaya_ki" name='reflek_cahaya_ki' value="<?php echo $data['reflek_cahaya_ki']; ?>">
                </div>
              
</div>
<br>
<h6>Ukuran Pupil</h6>
<div class="row">

                <div class="col">
                  
                  <label for="ukuran_pupil_ka"> Ka:</label>
                  <input type="text" class="form-control" id="ukuran_pupil_ka" name='ukuran_pupil_ka' value="<?php echo $data['ukuran_pupil_ka']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ukuran_pupil_ki"> Ki:</label>
                  <input type="text" class="form-control" id="ukuran_pupil_ki" name='ukuran_pupil_ki' value="<?php echo $data['ukuran_pupil_ki']; ?>">
                </div>
</div>
<br>
<h6>TTV</h6>
<div class="row">
            

                <div class="col">
                  
                  <label for="ttv_td"> TD:</label>
                  <input type="text" class="form-control" id="ttv_td" name='ttv_td' value="<?php echo $data['ttv_td']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ttv_pernafasan">Pernafasan:</label>
                  <input type="text" class="form-control" id="ttv_pernafasan" name='ttv_pernafasan' value="<?php echo $data['ttv_pernafasan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ttv_suhu">Suhu:</label>
                  <input type="text" class="form-control" id="ttv_suhu" name='ttv_suhu' value="<?php echo $data['ttv_suhu']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ttv_nadi"> Nadi:</label>
                  <input type="text" class="form-control" id="ttv_nadi" name='ttv_nadi' value="<?php echo $data['ttv_nadi']; ?>">
                </div>
              
</div>
<br>
                <div class="col">
                  
                  <label for="hasil_observasi"><b>hasil observasi: </b></label>
                  <input type="text" class="form-control" id="hasil_observasi" name='hasil_observasi' value="<?php echo $data['hasil_observasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pertimbangan_klinis"> <b>pertimbangan klinis:</b></label>
                  <input type="text" class="form-control" id="pertimbangan_klinis" name='pertimbangan_klinis' value="<?php echo $data['pertimbangan_klinis']; ?>">
                </div>
              
                <br>
<h5>
PENILAIAN DAN INSTRUKSI DOKTER 
</h5>


                <div class="col">
                  
                  <label for="restrain_non_farmakologi"> <b>restrain non farmakologi:</b></label>
                  <input type="text" class="form-control" id="restrain_non_farmakologi" name='restrain_non_farmakologi' value="<?php echo $data['restrain_non_farmakologi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="restrain_farmakologi"> <b>restrain farmakologi:</b></label>
                  <input type="text" class="form-control" id="restrain_farmakologi" name='restrain_farmakologi' value="<?php echo $data['restrain_farmakologi']; ?>">
                </div>
              <br>
                <h6><b>Rencana pengkajian lanjutan</b></h6>

                <div class="col">
                  
                  <label for="lanjutan_restrain_non_farmakologi"> <b> restrain non farmakologi:</b></label>
                  <input type="text" class="form-control" id="lanjutan_restrain_non_farmakologi" name='lanjutan_restrain_non_farmakologi' value="<?php echo $data['lanjutan_restrain_non_farmakologi']; ?>">
                </div>
                
                <div class="col">
                  
                  <label for="lanjutan_restrain_farmakologi"> <b> restrain farmakologi:</b></label>
                  <input type="text" class="form-control" id="lanjutan_restrain_farmakologi" name='lanjutan_restrain_farmakologi' value="<?php echo $data['lanjutan_restrain_farmakologi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pendidikan_restrain_keluarga"> <b>pendidikan restrain keluarga:</b></label>
                  <input type="text" class="form-control" id="pendidikan_restrain_keluarga" name='pendidikan_restrain_keluarga' value="<?php echo $data['pendidikan_restrain_keluarga']; ?>">
                </div>
              
            

                <div class="col">
                  
               
                  <input type="hidden" class="form-control" id="tanggal" name='tanggal' value="<?php echo $data['tanggal']; ?>">
                
          
                  <input type="hidden" class="form-control" id="pukul" name='pukul' value="<?php echo $data['pukul']; ?>">
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
                             
<a href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
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

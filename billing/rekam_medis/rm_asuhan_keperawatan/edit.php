
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
    <title> Form Edit Asuhan Keperawatan </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM EDIT Asuhan Keperawatan</td>
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
                  
                  <label for="diagnosa_kerja"> diagnosa kerja:</label>
                  <input type="text" class="form-control" id="diagnosa_kerja" name='diagnosa_kerja' value="<?php echo $data['diagnosa_kerja']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kebutuhan"> kebutuhan:</label>
                  <input type="text" class="form-control" id="kebutuhan" name='kebutuhan' value="<?php echo $data['kebutuhan']; ?>">
                </div>
              </div>
            

              
             <div class="row">


                <div class="col">
                  
                  <label for="dpjp"> dpjp:</label>
                  <input type="text" class="form-control" id="dpjp" name='dpjp' value="<?php echo $data['dpjp']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tim"> tim:</label>
                  <input type="text" class="form-control" id="tim" name='tim' value="<?php echo $data['tim']; ?>">
                </div>
              </div>
            <br>

                
              
            
<div class="row">
                <div class="col">
                  
                  <label for="tindakan"> tindakan:</label>
                  <input type="text" class="form-control" id="tindakan" name='tindakan' value="<?php echo $data['tindakan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="diet"> diet:</label>
                  <input type="text" class="form-control" id="diet" name='diet' value="<?php echo $data['diet']; ?>">
                </div>
              </div>
              <br>
            
                <div class="col">
                  
                  <label for="kewaspadaan"> kewaspadaan:</label>
                  <input type="text" class="form-control" id="kewaspadaan" name='kewaspadaan' value="<?php echo $data['kewaspadaan']; ?>">
                </div>
                <div class="col">
                  
                  <label for="pemeriksaan"> pemeriksaan:</label>
                  <input type="text" class="form-control" id="pemeriksaan" name='pemeriksaan' value="<?php echo $data['pemeriksaan']; ?>">
                </div>

                <div class="col">
                  
                  <label for="batasan_cairan"> batasan cairan:</label>
                  <input type="text" class="form-control" id="batasan_cairan" name='batasan_cairan' value="<?php echo $data['batasan_cairan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="aktivitas"> aktivitas:</label>
                  <input type="text" class="form-control" id="aktivitas" name='aktivitas' value="<?php echo $data['aktivitas']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pengobatan"> pengobatan:</label>
                  <input type="text" class="form-control" id="pengobatan" name='pengobatan' value="<?php echo $data['pengobatan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="keperawatan"> keperawatan:</label>
                  <input type="text" class="form-control" id="keperawatan" name='keperawatan' value="<?php echo $data['keperawatan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tindakan_rehabilitas_medik"> tindakan rehabilitas medik:</label>
                  <input type="text" class="form-control" id="tindakan_rehabilitas_medik" name='tindakan_rehabilitas_medik' value="<?php echo $data['tindakan_rehabilitas_medik']; ?>">
                </div>
              
            
 <div class="row">

                <div class="col">
                  
                  <label for="konsultasi"> konsultasi:</label>
                  <input type="text" class="form-control" id="konsultasi" name='konsultasi' value="<?php echo $data['konsultasi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="sasaran"> sasaran:</label>
                  <input type="text" class="form-control" id="sasaran" name='sasaran' value="<?php echo $data['sasaran']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="nama_dokter"> nama dokter:</label>
                  <input type="text" class="form-control" id="nama_dokter" name='nama_dokter' value="<?php echo $data['nama_dokter']; ?>">
                </div>
              
            </div>

                <div class="col">
                  
                
                  <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?php echo $data['id_kunjungan']; ?>">
                </div>
              
            

                <div class="col">
                  
                                    <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?php echo $data['id_pelayanan']; ?>">
                </div>
              
            

                <div class="col">
                  
                
                  <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?php echo $data['id_pasien']; ?>">
                </div>
              
            

                <div class="col">
                  
                
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


<?php
require_once 'func.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Form Input Asuhan Keperawatan</title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;FORM INPUT Asuhan Keperawatan</td>
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
                
                <label for="diagnosa_kerja"> diagnosa kerja:</label>
           
                <textarea class="form-control" id="diagnosa_kerja" name='diagnosa_kerja'  required></textarea>
              </div>
             
              
            
              <div class="col">
                
                <label for="kebutuhan"> kebutuhan:</label>
                
                <textarea class="form-control"  name='kebutuhan'required ></textarea>
              </div>
             
              </div>
             
               <div class="row">
            
              <div class="col">
                
                <label for="dpjp"> dpjp:</label>
                <input type="text" class="form-control" id="dpjp" name='dpjp'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="tim"> tim:</label>
                <input type="text" class="form-control" id="tim" name='tim'  required>
              </div>
             </div>
              
            <br>
             
              
            <div class="row">
              <div class="col">
                
                <label for="tindakan"> tindakan:</label>
                <input type="text" class="form-control" id="tindakan" name='tindakan'  required>

              </div>
               <div class="col">
                
                <label for="diet"> diet:</label>
                <input type="text" class="form-control" id="diet" name='diet'  required>
              </div>
            </div>
           <div class="row">
              <div class="col">
                
                <label for="kewaspadaan"> kewaspadaan:</label>
               <div class="form-check">
  <input class="form-check-input" type="radio" name="kewaspadaan" id="kewaspadaan" value="Standart" >
  <label class="form-check-label" for="kewaspadaan">
   Standart
  </label>
</div>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="kewaspadaan" id="kewaspadaan" value="Kontak" >
  <label class="form-check-label" for="kewaspadaan">
   Kontak
  </label>
</div>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="kewaspadaan" id="kewaspadaan" value="AirBone" >
  <label class="form-check-label" for="kewaspadaan">
    AirBone
  </label>
</div>
   <div class="form-check">
  <input class="form-check-input" type="radio" name="kewaspadaan" id="kewaspadaan" value="Droplet" >
  <label class="form-check-label" for="kewaspadaan">
    Droplet
  </label>
</div>

              </div>


              <div class="col">
                
                <label for="pemeriksaan"> pemeriksaan:</label>
           
                   <div class="form-check">
  <input class="form-check-input" type="radio" id="pemeriksaan" name='pemeriksaan'  required value="Laboratorium" >
  <label class="form-check-label" for="pemeriksaan">
Laboratorium
  </label>
</div>

                   <div class="form-check">
  <input class="form-check-input" type="radio" id="pemeriksaan" name='pemeriksaan'  required value=" Radiologi" >
  <label class="form-check-label" for="pemeriksaan">
     Radiologi
  </label>
</div>
              </div>
             
            
              <br>
              
             
             
             
              <div class="col">
                
                <label for="pengobatan"> pengobatan:</label>
             
                     <div class="form-check">
  <input class="form-check-input" type="radio" id="pengobatan" name='pengobatan'  required value="Sesuai IMR" >
  <label class="form-check-label" for="pengobatan">
  Sesuai IMR
  </label>
</div>
    <div class="form-check">
  <input class="form-check-input" type="radio" id="pengobatan" name='pengobatan'  required value="Revisi Pengobatan" >
  <label class="form-check-label" for="pengobatan">
Revisi Pengobatan  </label>
</div>


              </div>
            
               <div class="col">
                
                <label for="aktivitas"> aktivitas:</label>
              


               <div class="form-check">
  <input class="form-check-input" type="radio" id="aktivitas" name='aktivitas'  required value=" Tirah baring total" >
  <label class="form-check-label" for="batasan_cairan">
 Tirah baring total
  </label>
</div>

               <div class="form-check">
  <input class="form-check-input" type="radio" id="aktivitas" name='aktivitas'  required value="Tirah baring parsial" >
  <label class="form-check-label" for="batasan_cairan">
 Tirah baring parsial
  </label>
</div>

               <div class="form-check">
  <input class="form-check-input" type="radio" id="aktivitas" name='aktivitas'  required value=" Mandiri" >
  <label class="form-check-label" for="batasan_cairan">
 Mandiri
  </label>
</div>
              </div>
           </div>
               <br>
           
               <div class="row">
             
              <div class="col">
                
                <label for="batasan_cairan"> batasan cairan:</label>
             
                           <div class="form-check">
  <input class="form-check-input" type="radio" id="batasan_cairan" name='batasan_cairan'  required value="Tidak" >
  <label class="form-check-label" for="batasan_cairan">
Tidak
  </label>
</div>
               <div class="form-check">
  <input class="form-check-input" type="radio" id="batasan_cairan" name='batasan_cairan'  required value="Tidak" >
  <label class="form-check-label" for="batasan_cairan">
Ya
  </label>
</div>

              </div>
              
            
              
               <div class="col">
                
                <label for="tindakan_rehabilitas_medik"> tindakan rehabilitas medik:</label>
                

                 <div class="form-check">
  <input class="form-check-input" type="radio"  id="tindakan_rehabilitas_medik" name='tindakan_rehabilitas_medik' value="Ya" required>
  <label class="form-check-label" for="tindakan_rehabilitas_medik">Ya</label>
</div>
     <div class="form-check">
  <input class="form-check-input" type="radio"  id="tindakan_rehabilitas_medik" name='tindakan_rehabilitas_medik' value="Tidak" required>
  <label class="form-check-label" for="tindakan_rehabilitas_medik">Tidak</label>
</div>
              </div>
            </div>

             <br>
               <div class="row">
            
              <div class="col">
                
                <label for="keperawatan"> keperawatan:</label>
                    <select  class="form-control" id="keperawatan" name='keperawatan'  required multiple>

                     <option>Observasi Asuhan Keperawatan</option>
   <option>Pendidikan Kesehatan</option>
   <option>Prosedur Keperawatan</option>
   <option>Kolaborasi dengan medis</option>

                </select>
              </div>
             
              
            
             
             </div>
               <br>
             <div class="row">
              <div class="col">
                
                <label for="konsultasi"> konsultasi:</label>
                <input type="text" class="form-control" id="konsultasi" name='konsultasi'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="sasaran"> sasaran:</label>
                <input type="text" class="form-control" id="sasaran" name='sasaran'  required>
              </div>
             
              
            
              <div class="col">
                
                <label for="nama_dokter"> nama dokter:</label>
                <input type="text" class="form-control" id="nama_dokter" name='nama_dokter'  required>
              </div>
             </div>
              
            
              <div class="col">
                
                
                <input type="hidden" class="form-control" id="id_kunjungan" name='id_kunjungan' value="<?= $idKunj?>"  required>
              </div>
             
              
            
              <div class="col">
                
           
                <input type="hidden" class="form-control" id="id_pelayanan" name='id_pelayanan' value="<?= $idPel?>"  required>
              </div>
             
              
            
              <div class="col">
                
               
                <input type="hidden" class="form-control" id="id_pasien" name='id_pasien' value="<?= $idPasien?>"  required>
              </div>
             
              
            
              <div class="col">
                
              
                <input type="hidden" class="form-control" id="id_user" name='id_user' value="<?= $id_user?>" required>
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



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
    <title> Form Edit transfer external </title>
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
                    <td height="30" class="tblatas" style="text-align: left;">&nbsp;Form Edit transfer external</td>
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
                  
                  <label for="ruang"> ruang:</label>
                  <input type="text" class="form-control" id="ruang" name='ruang' value="<?php echo $data['ruang']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="kelas"> kelas:</label>
                  <input type="text" class="form-control" id="kelas" name='kelas' value="<?php echo $data['kelas']; ?>">
                </div>
              
   </div>
   <div class="row">

                <div class="col">
                  
                  <label for="dpjp"> dpjp:</label>
                  <input type="text" class="form-control" id="dpjp" name='dpjp' value="<?php echo $data['dpjp']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="ppjp"> ppjp:</label>
                  <input type="text" class="form-control" id="ppjp" name='ppjp' value="<?php echo $data['ppjp']; ?>">
                </div>
              
   </div>
   <hr>
   <h6>Rumah sakit yang di hubungi :</h6>
   <div class="row">

                <div class="col">
                  
                  <label for="rs_tujuan"> rs tujuan:</label>
                  <input type="text" class="form-control" id="rs_tujuan" name='rs_tujuan' value="<?php echo $data['rs_tujuan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="nama_petugas_dihubungi"> nama petugas yang  dihubungi:</label>
                  <input type="text" class="form-control" id="nama_petugas_dihubungi" name='nama_petugas_dihubungi' value="<?php echo $data['nama_petugas_dihubungi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tanggal_menghubungi"> tanggal menghubungi:</label>
                  <input type="text" class="form-control" id="tanggal_menghubungi" name='tanggal_menghubungi' value="<?php echo $data['tanggal_menghubungi']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="jam_menghubungi"> jam menghubungi:</label>
                  <input type="text" class="form-control" id="jam_menghubungi" name='jam_menghubungi' value="<?php echo $data['jam_menghubungi']; ?>">
                </div>
              
   </div>
   <hr>
   <h6>Transfer :</h6>
    <div class="row">

                <div class="col">
                  
                  <label for="alasan_transfer"> alasan transfer:</label>
                  <input type="text" class="form-control" id="alasan_transfer" name='alasan_transfer' value="<?php echo $data['alasan_transfer']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="tanggal_transfer"> tanggal transfer:</label>
                  <input type="text" class="form-control" id="tanggal_transfer" name='tanggal_transfer' value="<?php echo $data['tanggal_transfer']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="jam_transfer"> jam transfer:</label>
                  <input type="text" class="form-control" id="jam_transfer" name='jam_transfer' value="<?php echo $data['jam_transfer']; ?>">
                </div>
    </div>
    <br>
    <div class="row">
            

                <div class="col">
                  
                  <label for="kategori_pasien_transfer"> kategori pasien transfer:</label>
                  <input type="text" class="form-control" id="kategori_pasien_transfer" name='kategori_pasien_transfer' value="<?php echo $data['kategori_pasien_transfer']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="jenis_ambulans"> jenis ambulans:</label>
                  <input type="text" class="form-control" id="jenis_ambulans" name='jenis_ambulans' value="<?php echo $data['jenis_ambulans']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="diagnosis"> diagnosis:</label>
  
               <textarea class="form-control" id="diagnosis" name='diagnosis'><?php echo $data['diagnosis']; ?></textarea>
                </div>
    </div>
    <hr>
    <h6>Temuan Penting saat pasien dirawat :</h6>
    <div class="row">
            

                <div class="col">
                  
                  <label for="temuan_penting_pasien"> temuan penting pasien:</label>
                
                <textarea class="form-control" id="temuan_penting_pasien" name='temuan_penting_pasien'><?php echo $data['temuan_penting_pasien']; ?></textarea>
                </div>
              
            

                <div class="col">
                  
                  <label for="prosedur"> prosedur:</label>
             
                <textarea class="form-control" id="prosedur" name='prosedur'><?php echo $data['prosedur']; ?> </textarea>
                </div>
              
            

                <div class="col">
                  
                  <label for="alat_pemasangan"> alat pemasangan:</label>

                <textarea class="form-control" id="alat_pemasangan" name='alat_pemasangan' ><?php echo $data['alat_pemasangan']; ?></textarea>
                </div>
              
            

                <div class="col">
                  
                  <label for="tanggal_pemasangan"> tanggal pemasangan:</label>
                  <input type="text" class="form-control" id="tanggal_pemasangan" name='tanggal_pemasangan' value="<?php echo $data['tanggal_pemasangan']; ?>">
                </div>
    </div>
             
    <hr>
    <h6>Obat/cairan yang dibawa pada saat transfer :</h6>
    <div class="row">
            

                <div class="col">
                  
                  <label for="obat_saat_transfer"> obat saat transfer:</label>
                  <input type="text" class="form-control" id="obat_saat_transfer" name='obat_saat_transfer' value="<?php echo $data['obat_saat_transfer']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="jumlah_obat_transfer"> jumlah obat transfer:</label>
                  <input type="text" class="form-control" id="jumlah_obat_transfer" name='jumlah_obat_transfer' value="<?php echo $data['jumlah_obat_transfer']; ?>">
                </div>
    </div>
    <hr>
    <h6>Status Awal Pasien Saat Akan Ditransfer :</h6>
    <div class="row">
            

                <div class="col">
                  
                  <label for="pasien_akan_transfer_kesadaran">  kesadaran:</label>
                  <input type="text" class="form-control" id="pasien_akan_transfer_kesadaran" name='pasien_akan_transfer_kesadaran' value="<?php echo $data['pasien_akan_transfer_kesadaran']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_akan_transfer_td"> TD:</label>
                  <input type="text" class="form-control" id="pasien_akan_transfer_td" name='pasien_akan_transfer_td' value="<?php echo $data['pasien_akan_transfer_td']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_akan_transfer_hr"> HR:</label>
                  <input type="text" class="form-control" id="pasien_akan_transfer_hr" name='pasien_akan_transfer_hr' value="<?php echo $data['pasien_akan_transfer_hr']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_akan_transfer_rr"> RR:</label>
                  <input type="text" class="form-control" id="pasien_akan_transfer_rr" name='pasien_akan_transfer_rr' value="<?php echo $data['pasien_akan_transfer_rr']; ?>">
                </div>
    </div>
    <hr>
  <h6>Status Pasien Selama Transfer :</h6>
    <div class="row">    
            

                <div class="col">
                  
                  <label for="pasien_selama_transfer_kesadaran"> kesadaran:</label>
                  <input type="text" class="form-control" id="pasien_selama_transfer_kesadaran" name='pasien_selama_transfer_kesadaran' value="<?php echo $data['pasien_selama_transfer_kesadaran']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_selama_transfer_td">TD:</label>
                  <input type="text" class="form-control" id="pasien_selama_transfer_td" name='pasien_selama_transfer_td' value="<?php echo $data['pasien_selama_transfer_td']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_selama_transfer_hr"> HR:</label>
                  <input type="text" class="form-control" id="pasien_selama_transfer_hr" name='pasien_selama_transfer_hr' value="<?php echo $data['pasien_selama_transfer_hr']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="pasien_selama_transfer_rr"> RR:</label>
                  <input type="text" class="form-control" id="pasien_selama_transfer_rr" name='pasien_selama_transfer_rr' value="<?php echo $data['pasien_selama_transfer_rr']; ?>">
                </div>
    </div>
    <hr>
    <div class="row">
    <div class="col">
                
                <label for="obat_pasien_saat_ini"> obat pasien saat ini:</label>
          
             <textarea class="form-control" id="obat_pasien_saat_ini" name='obat_pasien_saat_ini'  required ><?php echo $data['obat_pasien_saat_ini']; ?></textarea>
              </div>

              <div class="col">
                
                <label for="kejadian_selama_transfer"> kejadian selama transfer:</label>
          
             <textarea class="form-control" id="kejadian_selama_transfer" name='kejadian_selama_transfer'  required ><?php echo $data['kejadian_selama_transfer']; ?></textarea>
              </div>
    </div>
              <hr>
            <div class="row">

                <div class="col">
                  
                  <label for="petugas_yang_menyerahkan"> petugas yang menyerahkan:</label>
                  <input type="text" class="form-control" id="petugas_yang_menyerahkan" name='petugas_yang_menyerahkan' value="<?php echo $data['petugas_yang_menyerahkan']; ?>">
                </div>
              
            

                <div class="col">
                  
                  <label for="petugas_yang_menerima"> petugas yang menerima:</label>
                  <input type="text" class="form-control" id="petugas_yang_menerima" name='petugas_yang_menerima' value="<?php echo $data['petugas_yang_menerima']; ?>">
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


<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> CHECK LIST SERAH TERIMA PASIEN POST OPERASI </title>
    <link rel="icon" href="../favicon.png">
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css" >
   <script src="../js/jquery-3.5.1.slim.js"></script>
          <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> 
        <script src="../js/bootstrap.min.js"></script>
        <link rel="icon" href="../favicon.png">
    <script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
    <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
   <style type="text/css">
      @media print{
  #print{
    display: none;
  }
      }
    </style>
    <script src="../html2pdf/ppdf.js"></script>
  </head>


<body>
  <div id="pdf-area"  style=" width: 1000px;  margin: auto;">


<?php

$qPasien="select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='".$idPasien."' ";
$rsPasien=mysql_query($qPasien);
$rwPasien=mysql_fetch_array($rsPasien);
?>
<img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


<div class="box-pasien" style="float: right; padding-right: 0px;">
    <p align='right' style="margin: 0px;">RM21.17/PHCM</p>
    <table style=" border: 1px solid black;  width: 7,07 cm; height:1,99 cm;" cellpadding="2">

        <tr>
            <td class="noline" style="font:12 sans-serif bolder;">
                <b> NAMA &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $rwPasien['nama']; ?></b>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
        </tr>
        <tr>
            <td class="noline" style="font:12 sans-serif bolder;">
                <b>Tgl.Lahir &nbsp;: <?php echo $rwPasien['tgl_lahir']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $rwPasien['sex']; ?> </b>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
        </tr>
        <tr>
            <td class="noline" style="font:12 sans-serif bolder;">
                <b> No.RM &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $rwPasien['no_rm']; ?></b>
            </td>
            <td class="noline"></td>
            <td class="noline">&nbsp;</td>
            <td class="noline">&nbsp;</td>
        </tr>

    </table>
</div>
<br>

<hr style=" margin:0px; padding:0px; margin-top:17px;">
<hr style="border: 1px solid black; margin:0px; padding:0px; margin-top:2px;">
  <center>
   <br>
  <center><h5>CHECK LIST SERAH TERIMA PASIEN POST OPERASI</h5></center>
   
  <div class='container'>
  


  
 
<table border="1" cellspacing="0" cellpadding="0" width="698">
    <tbody>
        <tr>
            <td width="698" colspan="7" valign="top">
                <p>
                    Diagnosa : <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['diagnosa']; 
      
  }
}
      ?>

     Ruangan : <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['ruangan']; 
      
  }
}
      ?>
    

     Tgl. OP : <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['tgl_op']; 
      
  }
}
      ?>
    
                </p>
                <p>
                    Tindakan : <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['tindakan']; 
      
  }
}
      ?>
    
                </p>
            </td>
        </tr>
        <tr>
            <td width="698" colspan="7" valign="top">
                <p align="center">
                    Post Operasi
                </p>
            </td>
        </tr>
        <tr>
            <td width="40">
                <p align="center">
                    No
                </p>
            </td>
            <td width="272" colspan="3">
                <p align="center">
                    Beri tanda : ya tidak
                </p>
            </td>
            <td width="131">
                <p align="center">
                    Perawat
                </p>
                <p align="center">
                    <em>Recovery Room</em>
                </p>
            </td>
            <td width="142">
                <p align="center">
                    Perawat
                </p>
                <p align="center">
                    Ruangan
                </p>
            </td>
            <td width="113">
                <p align="center">
                    Keterangan
                </p>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    1.
                </p>
            </td>
            <td width="115" valign="top">
                <p>
                    Blagko
                </p>
            </td>
            <td width="158" colspan="2" valign="top">
                <p>
                    Laporan Operasi
                </p>
            </td>
            <td width="131" valign="top">
                <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['blagko_laporan_operasi_perawat_recoveryroom']; 
      
  }
}
      ?>
    
            </td>
            <td width="142" valign="top">
            <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['blagko_laporan_operasi_perawat_ruangan']; 
      
  }
}
      ?>
            </td>
            <td width="113" valign="top">
            <?php
    
 $getone = GetOne($_REQUEST['id']);

      if(isset($getone)){
      foreach($getone as $data){
       
echo $data['blagko_laporan_operasi_keterangan']; 
      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
            </td>
            <td width="115" valign="top">
            </td>
            <td width="158" colspan="2" valign="top">
                <p>
                    Catatan Anestesi
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_catatan_anestesi_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_catatan_anestesi_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_catatan_anestesi_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
         
            </td>
            <td width="115" valign="top">
            </td>
            <td width="158" colspan="2" valign="top">
                <p>
                    Pemakaian Alat (Implant)
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_pemakaian_alat_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_pemakaian_alat_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blagko_pemakaian_alat_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    2
                </p>
            </td>
            <td width="272" colspan="3" valign="top">
                <p>
                    Blangko
                </p>
            </td>
            <td width="131" valign="top">
            
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blangko_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blangko_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['blangko_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" rowspan="4" valign="top">
                <p>
                    3
                </p>
            </td>
            <td width="117" colspan="2" rowspan="4" valign="top">
                <p>
                    Rontgen
                </p>
            </td>
            <td width="155" valign="top">
                <p>
                    Thorax
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_thorax_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_thorax_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_thorax_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="155" valign="top">
                <p>
                    CT-Scan
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_ctscan_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_ctscan_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_ctscan_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="155" valign="top">
                <p>
                    USG
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_usg_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_usg_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_usg_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="155" valign="top">
                <p>
                    Foto Lain…………
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_fotolain_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_fotolain_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['rontgen_fotolain_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    4
                </p>
            </td>
            <td width="272" colspan="3" valign="top">
                <p>
                    Barang-barang Milik Pasien
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['barang_milik_pasien_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['barang_milik_pasien_perawat_ruangan']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['barang_milik_pasien_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    5
                </p>
            </td>
            <td width="272" colspan="3" valign="top">
                <p>
                    Vital Sign
                </p>
                <p>
                    a. Cek Terakhir Jam :         <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_cek_terakhir_jam']; 
         
     }
   }
         ?>
                </p>
                <p>
                    b. Nadi :    <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_nadi']; 
         
     }
   }
         ?> x/m
                </p>
                <p>
                    c. Suhu :    <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_suhu']; 
         
     }
   }
         ?> °C
                </p>
                <p>
                    d. Tensi Darah :    <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_tensi_darah']; 
         
     }
   }
         ?> mmHg
                </p>
                <p>
                    e. Respirasi :    <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_respirasi']; 
         
     }
   }
         ?> x/m
                </p>
                <p>
                    f. Skala Nyeri :12345678910
                </p>
                <p>
                    g. Berat Badan :    <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_berat_badan']; 
         
     }
   }
         ?> Kg
                </p>
            </td>
            <td width="131" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_perawat_ruangan']; 
         
     }
   }
         ?>
    
            </td>
            <td width="113" valign="top">
            <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['vital_sign_keterangan']; 
         
     }
   }
         ?>
    
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    6
                </p>
            </td>
            <td width="272" colspan="3" valign="top">
                <p>
                <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['drain_opsi']; 
         
     }
   }
         ?>
    
                </p>
                
                <p>
                    Lain lain………..
                </p>
            </td>
            <td width="131" valign="top">
                   <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['drain_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
                   <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['drain_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="113" valign="top">
                   <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['drain_keterangan']; 
         
     }
   }
         ?>
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    7
                </p>
            </td>
            <td width="272" colspan="3" valign="top">
                <p>
               <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_opsi']; 
         
     }
   }
         ?>
                </p>
             
                <p>
                    Luka Operasi : 
                    Ukuran  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_operasi_ukuran']; 
         
     }
   }
         ?>
                    
                    Lokasi <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_operasi_lokasi']; 
         
     }
   }
         ?>
                    Kondisi Luka Bakar :
                    Ukuran  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_bakar_ukuran']; 
         
     }
   }
         ?>
         Lokasi  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_bakar_lokasi']; 
         
     }
   }
         ?> 
         Kondisi
                </p>
                <p>
                    Kulit Memerah : 
                    Ukuran  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['kulit_memerah_ukuran']; 
         
     }
   }
         ?>
                    Lokasi <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['kulit_memerah_lokasi']; 
         
     }
   }
         ?> Kondisi
                </p>
            </td>
            <td width="131" valign="top">
<?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_perawat_recoveryroom']; 
         
     }
   }
         ?>
            </td>
            <td width="142" valign="top">
                <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_perawat_ruangan']; 
         
     }
   }
         ?>

            </td>
            <td width="113" valign="top">
                <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['luka_keterangan']; 
         
     }
   }
         ?>

            </td>
        </tr>
        <tr height="0">
            <td width="40">
            </td>
            <td width="115">
            </td>
            <td width="3">
            </td>
            <td width="155">
            </td>
            <td width="131">
            </td>
            <td width="142">
            </td>
            <td width="113">
            </td>
        </tr>
    </tbody>
</table>
<table border="1" cellspacing="0" cellpadding="0" width="698">
    <tbody>
        <tr>
            <td width="40" valign="top">
                <p>
                    8
                </p>
            </td>
            <td width="272" valign="top">
                <p>
                <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['invasif_opsi']; 
         
     }
   }
         ?>

                </p>
              
                <p>
                    IV Line/ Tanggal      <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['IV_line_tanggal']; 
         
     }
   }
         ?>
                </p>
                <p>
                    Posisi      <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['IV_line_posisi']; 
         
     }
   }
         ?>
                </p>
                <p>
                    CVP/PIC/Tanggal      <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['cvp_pic_tanggal']; 
         
     }
   }
         ?>
                </p>
                <p>
                    Posisi      <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['cvp_pic_posisi']; 
         
     }
   }
         ?>
                </p>
                <p>
                    Lain-lain……..Tanggal……………..…
                </p>
                <p>
                    Posisi…………………………………..
                </p>
            </td>
            <td width="131" colspan="2" valign="top">
                 <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['invasif_perawat_recoveryroom']; 
         
     }
   }
         ?>

            </td>
            <td width="142" valign="top">
                 <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['invasif_perawat_ruangan']; 
         
     }
   }
         ?>

            </td>
            <td width="113" valign="top">
                 <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['invasif_keterangan']; 
         
     }
   }
         ?>

            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    9
                </p>
            </td>
            <td width="272" valign="top">
                <p>
                    Pemasangan Kateter Urine No      <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['pemasangan_kateter_urine_nomor']; 
         
     }
   }
         ?>
                </p>
                <p>
                    Tanggal  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['pemasangan_kateter_urine_tanggal']; 
         
     }
   }
         ?>
              
                </p>
            </td>
            <td width="131" colspan="2" valign="top">
                 <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['kateter_urine_perawat_recoveryroom']; 
         
     }
   }
         ?>
              
            </td>
            <td width="142" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['kateter_urine_perawat_ruangan']; 
         
     }
   }
         ?>
   
            </td>
            <td width="113" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['kateter_urine_keterangan']; 
         
     }
   }
         ?>
   
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    10
                </p>
            </td>
            <td width="272" valign="top">
                <p>
                    Pemasangan Irigasi Tanggal               <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['pemasangan_irigasi_tanggal']; 
         
     }
   }
         ?>
   
                </p>
            </td>
            <td width="131" colspan="2" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['irigasi_perawat_recoveryroom']; 
         
     }
   }
         ?>
   
            </td>
            <td width="142" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['irigasi_perawat_ruangan']; 
         
     }
   }
         ?>
   
            </td>
            <td width="113" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['irigasi_keterangan']; 
         
     }
   }
         ?>
   
            </td>
        </tr>
        <tr>
            <td width="40" valign="top">
                <p>
                    11
                </p>
            </td>
            <td width="272" valign="top">
                <p>
                    Masalah-masalah yang terjadi di kamar operasi
                </p>
            </td>
            <td width="131" colspan="2" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['masalah_kamar_operasi_perawat_recoveryroom']; 
         
     }
   }
         ?>
   
            </td>
            <td width="142" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['masalah_kamar_operasi_perawat_ruangan']; 
         
     }
   }
         ?>
   
            </td>
            <td width="113" valign="top">
                              <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['masalah_kamar_operasi_perawat_keterangan']; 
         
     }
   }
         ?>
   
            </td>
        </tr>
        <tr>
            <td width="698" colspan="6" valign="top">
            </td>
        </tr>
        <tr>
            <td width="339" colspan="3" valign="top">
                <p align="center">
                    Petugas <em>Recovery Room</em> Yang Menyerahkan
                </p>
                <p align="center">
                                  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['petugas_recovery_yang_menyerahkan']; 
         
     }
   }
         ?>
   
                </p>
            </td>
            <td width="360" colspan="3" valign="top">
                <p align="center">
                    Petugas Ruangan Yang Menerima
                </p>
                <p align="center">
                                  <?php
    
    $getone = GetOne($_REQUEST['id']);
   
         if(isset($getone)){
         foreach($getone as $data){
          
   echo $data['petugas_ruangan_yang_menerimah']; 
         
     }
   }
         ?>
   
                </p>
            </td>
        </tr>
        <tr>
            <td width="339" colspan="3" valign="top">
                <p>
                    Tanggal : <?= date('d/m/yy') ?>
                </p>
            </td>
            <td width="360" colspan="3" valign="top">
                <p>
                    Jam : <?= date('h:i:s') ?>
                </p>
            </td>
        </tr>
        <tr height="0">
            <td width="40">
            </td>
            <td width="272">
            </td>
            <td width="27">
            </td>
            <td width="104">
            </td>
            <td width="142">
            </td>
            <td width="113">
            </td>
        </tr>
    </tbody>
</table>
  </div>
  </div>

      <BR>
    <center>
  <div class='btn-group'>
    <button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
    <button id='print' class='btn btn-info' onclick='window.print()'>Cetak</button>
       <a id='print' href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
  </div>
</center>
  </div>

 <script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 21.17 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
  </body>
</html>




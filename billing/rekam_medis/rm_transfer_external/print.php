
<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> LEMBAR TRANSFER PASIEN EKSTERNAL </title>
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

$qPasien="select p.no_rm,p.nama,p.tgl_lahir,p.tgl_act,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
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
    <p align='right' style="margin: 0px;">RM7.1/PHCM</p>
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
  <center><h5>LEMBAR TRANSFER PASIEN EKSTERNAL</h5></center>
   <br>
  <div class='container'>
  
   
      



    <table  cellspacing="0" cellpadding="0" width="860" style="border: 1px solid black;">
    <tbody>
        <tr>
            <td width="325">
                <p>
                    Ruang : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['ruang']; 

  }
}
      ?>
                </p>
                <p>
                    Tgl Masuk : <?php echo $rwPasien['tgl_act']; ?>
                </p>
                <p>
                    Kelas : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['kelas']; 

  }
}
      ?>
        
                   
                </p>
               <p> No.Register: <?php echo $rwPasien['no_rm']; ?></p>
                <p>     DPJP : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['dpjp']; 

  }
}
      ?>
        
                  
                </p>
                <p>
                    PPJP : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['ppjp']; 

  }
}
      ?>
        
                </p>
            </td>
            <td width="365" valign="top">
            </td>
        </tr>
    </tbody>
</table>
<table border="1" cellspacing="0" cellpadding="0" width="860">
    <tbody>
        <tr>
            <td width="161" colspan="3" valign="top">
                <p>
                    RS. Tujuan :<?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['rs_tujuan']; 

  }
}
      ?>
        
                </p>
            </td>
            <td width="255" colspan="5" valign="top">
                <p>
                    Nama petugas RS tujuan yang dihubungi :<?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['nama_petugas_dihubungi']; 

  }
}
      ?>
                </p>
            </td>
            <td width="276" colspan="4" valign="top">
                <p>
                    Waktu menghubungi :
                </p>
                <p>
                    Tanggal : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['tanggal_menghubungi']; 

  }
}
      ?> Jam : <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['jam_menghubungi']; 
     
       }
     }
           ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="416" colspan="8" valign="top">
                <p>
                    Alasan Transfer :
                </p>
                <p>
                  <input type="checkbox" required checked>
                <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['alasan_transfer']; 

  }
}
      ?>
                </p>
              
            </td>
            <td width="276" colspan="4" valign="top">
                <p>
                    Waktu Transfer :
                </p>
                <p>
                    Tanggal :   <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['tanggal_transfer']; 

  }
}
      ?>
                </p>
                <p>
                    Jam : <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['jam_transfer']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="340" colspan="6" valign="top">
                <p>
                    Kategori Pasien Transfer:
                </p>
                <p>
                  <input type="checkbox" required checked>
                <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['kategori_pasien_transfer']; 

  }
}
      ?>
                </p>
            </td>
            <td width="351" colspan="6" valign="top">
                <p>
                    Jenis Ambulans :
                </p>
                <p>
                <input type="checkbox" required checked>
                <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['jenis_ambulans']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11">
                <p align="center">
                    <strong>RINGKASAN KONDISI PASIEN</strong>
                    <strong></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="340" colspan="5" valign="top">
                <p>
                    Tanggal Masuk RS Prima Husada Cipta Medan<strong> </strong>
                    :<?php echo $rwPasien['tgl_act']; ?>
                </p>
            </td>
            <td width="351" colspan="6" valign="top">
                <p>
                    Diagnosis :
                    <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['diagnosis']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11" valign="top">
                <p>
                    Temuan penting (pemeriksaan fisik dan penunjang) selama
                    pasiendirawat di RS Prima Husada Cipta Medan:
                </p>
                <p> <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['temuan_penting_pasien']; 

  }
}
      ?></p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11" valign="top">
                <p>
                    <strong>Prosedur / Operasi yang sudah dilakukan :</strong>
                </p>
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['prosedur']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11" valign="top">
                <p>
                    <strong>Alat-alat yang terpasang :</strong>
                    <br>
                  <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['alat_pemasangan']; 

  }
}
      ?>
                   <br>
                    <strong>dan tanggal pemasangan:</strong>
                    <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['tanggal_pemasangan']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11" valign="top">
                <p>
                    <strong>
                        Obat-obatan yang diterima pasien saat ini :
                    </strong>
                    <strong></strong>
                    <br>
                    <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['obat_pasien_saat_ini']; 

  }
}
      ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="691" colspan="11" valign="top">
                <p>
                    Obat/cairan yang dibawa pada saat transfer :
                </p>
            </td>
        </tr>
        <tr>
            <td width="1">
            </td>
            <td width="400" colspan="5" valign="top">
              <br>
                <p>
                    a.
                    <?php
 $getone = GetOne($_REQUEST['id']);
      if(isset($getone)){
      foreach($getone as $data){

echo $data['obat_saat_transfer']; 

  }
}
      ?> &nbsp;&nbsp; jumlah  <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['jumlah_obat_transfer']; 
     
       }
     }
           ?>
                </p>
                <br>
                <p>
                    b...............................................jumlah...........................
                </p>
                <br>
                <p>
                    c.
                    .............................................jumlah...........................
                </p>
            </td>
            <td width="400" colspan="5" valign="top">
            <br>
                <p>
                    d.........................................jumlah.....................................
                </p>
                <br>
                <p>
                    f.
                    ........................................jumlah..................................
                </p>
                <br>
                <p>e..........................................jumlah....................................</p>
            </td>
        </tr>
        <tr>
            <td width="691" colspan="12" valign="top">
                <p align="center">
                    Status Awal Pasien Saat Akan Ditransfer
                </p>
            </td>
        </tr>
        <tr>
            <td width="94" colspan="2" valign="top">
                <p>
                    Jam : <?= date('h:i:s'); ?>
                </p>
            </td>
            <td width="151" colspan="2" valign="top">
                <p>
                    Kesadaran :  <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_akan_transfer_kesadaran']; 
     
       }
     }
           ?>
                </p>
            </td>
            <td width="161" colspan="3" valign="top">
                <p>
                    TD :  <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_akan_transfer_td']; 
     
       }
     }
           ?> mmHg
                </p>
            </td>
            <td width="161" colspan="3" valign="top">
                <p>
                    HR :  <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_akan_transfer_hr']; 
     
       }
     }
           ?> x/mnt
                </p>
            </td>
            <td width="123" valign="top">
                <p>
                    RR:  <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_akan_transfer_rr']; 
     
       }
     }
           ?> x/mnt
                </p>
            </td>
            <td width="1">
            </td>
        </tr>
        <tr align="center">
            <td width="691" colspan="12" valign="top">
                <p align="center">
                    Status Pasien Selama Transfer
                </p>
            </td>
        </tr>
        <tr>
            <td width="94" colspan="2" valign="top">
                <p align="center">
                    Tanggal/Jam
                </p>
            </td>
            <td width="151" colspan="2" valign="top">
                <p align="center">
                    Kesadaran
                </p>
            </td>
            <td width="161" colspan="3" valign="top">
                <p align="center">
                    TD (mmHg)
                </p>
            </td>
            <td width="161" colspan="3" valign="top">
                <p align="center">
                    HR (x/mnt)
                </p>
            </td>
            <td width="124" colspan="2" valign="top">
                <p align="center">
                    RR (x/mnt)
                </p>
            </td>
        </tr>
        <tr align="center">
            <td width="94" colspan="2" valign="top">
              <?= date('d/m/yy'); ?>
              <br>
              <?= date('h:i:s'); ?>
            </td>
            <td width="151" colspan="2" valign="top">
            <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_selama_transfer_kesadaran']; 
     
       }
     }
           ?>
            </td>
            <td width="161" colspan="3" valign="top">
            <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_selama_transfer_td']; 
     
       }
     }
           ?>
            </td>
            <td width="161" colspan="3" valign="top">
            <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_selama_transfer_hr']; 
     
       }
     }
           ?>
            </td>
            <td width="124" colspan="2" valign="top">
            <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['pasien_selama_transfer_rr']; 
     
       }
     }
           ?>
            </td>
        </tr>
        
        <tr>
            <td width="691" colspan="12" valign="top">
                <p align="center">
                    Kejadian dan Tindakan Yang Dilakukan Selama Transfer
                </p>
                <p align="center">
                <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['kejadian_selama_transfer']; 
     
       }
     }
           ?>

                </p>
                

            </td>
        </tr>
        <tr>
            <td width="691" colspan="12" valign="top">
                <p align="center">
                    Serah Terima Pasien
                </p>
            </td>
        </tr>
        <tr>
            <td width="300" colspan="5" valign="top">
                <p>
                    Waktu Serah Terima : 
                </p>
                <p>
                    Tanggal : <?= date('d/m/yy'); ?>
                </p>
                <p>
                    Jam : <?= date('h:i:s'); ?>
                </p>
            </td>
            <td width="200" colspan="2" valign="top">
                <p align="center">
                Ttd. DPJP
                </p>
                <br>
                <br>
                <p align="center">
                    ..............................................
                </p>
            </td>
            <td width="200" colspan="2" valign="top">
              
                <p align="center">
                    Petugas yang ,menyerahkan
                </p>
                <br>
                <br>
                <p align="center">
                <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['petugas_yang_menyerahkan']; 
     
       }
     }
           ?>
                </p>
            </td>
            
            <td width="200" colspan="2" valign="top">
                <p align="center">
                    Petugas yang menerima
                </p>
                <br>
           
                <p align="center">
                <?php
      $getone = GetOne($_REQUEST['id']);
           if(isset($getone)){
           foreach($getone as $data){
     
     echo $data['petugas_yang_menerima']; 
     
       }
     }
           ?>
                </p>
               
            </td>
        </tr>
      
    </tbody>
</table>
<p>
    Catatan : Lembar ini dibuat rangkap dua. Lembar kesatu untuk RS tujuan,
    Lembar kedua untuk RS Prima Husada Cipta Medan.
</p>

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
            filename: "RM 7.1 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
  </body>
</html>




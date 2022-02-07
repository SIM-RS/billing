
<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> ASESMEN KHUSUS RESTRAIN</title>
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
    <p align='right' style="margin: 0px;">RM 30/PHCM</p>
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

   <br>
  <center><h5>ASESMEN KHUSUS RESTRAIN</h5></center>
 
  <div class='container' style="padding-left: 8%;">


    <p>
    Petunjuk : Beri tanda ( √) pada kolom yang dianggap sesuai
</p>
<p>
    Tanggal : <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['tanggal']; 
      }
      ?> Pukul : <?php 
      $getone = GetOne($_REQUEST['id']);
      foreach($getone as $data){  
       echo $data['pukul']; 
        }
        ?>
</p>
<p>
    <strong></strong>
</p>
<p>
    <strong>PENGKAJIAN FISIK DAN MENTAL </strong>
</p>
<p>
    Kesadaran : GCS : 
    E <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['gcs_e']; 
      }
      ?>

       V <?php 
      $getone = GetOne($_REQUEST['id']);
      foreach($getone as $data){  
       echo $data['gcs_v']; 
        }
        ?>

         M <?php 
        $getone = GetOne($_REQUEST['id']);
        foreach($getone as $data){  
         echo $data['gcs_m']; 
          }

          ?> 
          Reflek Cahaya : 
          Ka <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['reflek_cahaya_ka']; 
      }
      ?>

    Ki <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['reflek_cahaya_ki']; 
      }
      ?>
</p>
<p>
    Ukuran Pupil :
     Ka <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ukuran_pupil_ka']; 
      }
      ?> mm/
     
     Ki <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ukuran_pupil_ki']; 
      }
      ?> mm
</p>
<p>
    TTV : 
    TD <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ttv_td']; 
      }
      ?> mmHg,

     Pernafasan :<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ttv_pernafasan']; 
      }
      ?> x/ mnt, 
     
     Suhu: <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ttv_suhu']; 
      }
      ?> ◦C ,
     
      Nadi <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['ttv_nadi']; 
      }
      ?> x/ mnt
</p>
<p>
    <strong>Hasil Observasi: </strong>
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['hasil_observasi']; 
      }
      ?>
</p>

<p>
    <strong>PERTIMBANGAN KLINIS </strong>
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['pertimbangan_klinis']; 
      }
      ?>
</p>

<p>
    <strong></strong>
</p>
<p>
    <strong>PENILAIAN DAN INSTRUKSI DOKTER </strong>
</p>
<p>
    <strong>Restrain Non Farmakologi </strong>
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['restrain_non_farmakologi']; 
      }
      ?>
</p>

<p>
    <strong>Restrain Farmakologi </strong>
</p>
<p>
<?php 
    
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['restrain_farmakologi']; 
      }
      ?>
</p>


<p>
    <strong>Rencana pengkajian lanjutan </strong>
</p>
<p>
    Restrain non farmakologi
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['lanjutan_restrain_non_farmakologi']; 
      }
      ?>
</p>
<p>
    Restrain farmakologi
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['lanjutan_restrain_farmakologi']; 
      }
      ?>
</p>

<p>
    <strong>PENDIDIKAN RESTRAIN PADA KELUARGA : </strong>
</p>
<p>
<?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo "<input type='checkbox' required checked >".$data['pendidikan_restrain_keluarga']; 
      }
      ?>
</p>


<table border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td width="245" valign="top">
                <p align="center">
                    <strong>Perawat/Bidan</strong>
                    <strong> Yang Melakukan </strong>
                    <strong>Pengkajian</strong>
                </p>
            </td>
            <td width="189">
                <p align="center">
                    <strong>Keluarga Yang Menyetujui</strong>
                </p>
                <p align="center">
                    <strong></strong>
                </p>
            </td>
            <td width="233">
                <p align="center">
                    <strong>Verifikasi DPJP</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="245" valign="top">
                <p>
                    Tanggal : <?php 
    $getone = GetOne($_REQUEST['id']);
    foreach($getone as $data){  
     echo $data['tanggal']; 
      }
      ?> Pkl: <?php 
      $getone = GetOne($_REQUEST['id']);
      foreach($getone as $data){  
       echo $data['pukul']; 
        }
        ?> Selesai<strong></strong>
                </p>
            </td>
            <td width="189" rowspan="2" valign="top">
                <p>
                    <strong></strong>
                </p>
            </td>
            <td width="233" valign="top">
                <p align="center">
                    Tanggal : ____________ Pkl: _____ <strong></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="245" valign="top">
            </td>
            <td width="233" valign="top">
            </td>
        </tr>
        <tr>
            <td width="245" valign="top">
                <p align="center">
                    Tanda Tangan &amp; Nama Jelas
                </p>
            </td>
            <td width="189" valign="top">
                <p align="center">
                    Tanda Tangan &amp; Nama Jelas
                </p>
            </td>
            <td width="233" valign="top">
                <p align="center">
                    Tanda Tangan &amp; Nama Jelas
                </p>
            </td>
        </tr>
    </tbody>
</table>
<p>
    Januari, 2017
</p>
<p>
    <strong><u></u></strong>
</p>
</div>
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
    
    <script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 30 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
  </body>
</html>




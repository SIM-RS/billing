
<?php
require_once 'func.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> RESUME KELUAR PASIEN UGD</title>
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
    <p align='right' style="margin: 0px;">RM16.1/PHCM</p>
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
  <center><h5>RESUME KELUAR PASIEN UGD</h5></center>
   
  <div class='container'>
    
    <div align="center">
    <table border="1" cellspacing="0" cellpadding="4">
        <tbody>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Tanggal Masuk : <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['tanggal_masuk']; 
      
  }
}
      ?>
                    </p>
                </td>
                <td width="354" valign="top">
                    <p>
                        Tanggal Keluar :
                        <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['tanggal_keluar']; 
      
  }
}
      ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="707" colspan="2" valign="top">
                    <p>
                        Keluhan Utama Saat Masuk : <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['keluhan_saat_masuk']; 
      
  }
}
      ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Riwayat Alergi
                    </p>
                </td>
                <td width="354" valign="top">
                <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['riwayat_alergi']; 
      
  }
}
      ?>
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Pemeriksaan fisik :
                    </p>
                    <p> <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['pemeriksaan_fisik']; 
      
  }
}
      ?></p>
                </td>
                <td width="354" valign="top">
                    <p>
                        Kesan Umum :
                    </p>
                    <p>
                        Tanda vital : 
                        Bp  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['bp']; 
      
  }
}
      ?> mmHg,
                        <br>
                         Nadi :  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['nadi']; 
      
  }
}
      ?> x/mnt 
      RR:  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['rr']; 
      
  }
}
      ?> x/mnt,
      <br>
                          Suhu  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['suhu']; 
      
  }
}
      ?> C,
                          <br>
                        GCS :
                         E  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['gcs_e']; 
      
  }
}
      ?>
                        V 
                        <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['gcs_v']; 
      
  }
}
      ?>
                        M :
                        <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['gcs_m']; 
      
  }
}
      ?>
                    </p>
                    <p>
                        Pemeriksaan Fisik yang bermakna :
                    </p>
                    <p> <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['pemeriksaan_fisik_bermakna']; 
      
  }
}
      ?></p>
                </td>
            </tr>
            <tr>
                <td width="707" colspan="2" valign="top">
                    <p>
                        Pemeriksaan Penunjang (  <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['pemeriksaan_penunjang']; 
      
  }
}
      ?> )
                    </p>
                </td>
            </tr>
            <tr>
                <td width="707" colspan="2" valign="top">
                    <p>
                        Diagnosis :
                    </p>
                    <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
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
                <td width="353" valign="top">
                    <p>
                        Perkembangan Penyakit
                    </p>
                </td>
                <td width="354" valign="top">
                    <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo "<input type='checkbox' required checked> ".$data['perkembangan_penyakit']; 
      
  }
}
      ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Kondisi pasien saat dipulangkan
                    </p>
                </td>
                <td width="354" valign="top">
                    <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo "<input type='checkbox' required checked> ".$data['kondisi_pasien']; 
      
  }
}
      ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Penyebab langsung kematian
                    </p>
                </td>
                <td width="354" valign="top">
                <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['penyebab_langsung_kematian']; 
      
  }
}
      ?>
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Masalah yang masih ada
                    </p>
                </td>
                <td width="354" valign="top">
                    <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo "<input type='checkbox' required checked> ".$data['masalah']; 
      
  }
}
      ?>
                    </p>
                    
                </td>
            </tr>
            <tr>
                <td width="353" valign="top">
                    <p>
                        Cara Pulang
                    </p>
                </td>
                <td width="354" valign="top">
                    <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo "<input type='checkbox' required checked> ".$data['cara_pulang']; 
      
  }
}
      ?>
                    </p>
                    <p>
                        Tgl : <?= date('d/m/yy'); ?>
                    </p>
                   
                </td>
            </tr>
            <tr>
                <td width="707" colspan="2" valign="top">
                <p>
                        Obat dirumah
                    </p>
                    <table
                        border="1"
                        cellspacing="0"
                        cellpadding="0"
                        align="left"
                    >
                        <tbody>
                            <tr>
                                <td width="47" valign="top">
                                    <p align="center">
                                        No
                                    </p>
                                </td>
                                <td width="295" valign="top">
                                    <p align="center">
                                        Nama Obat
                                    </p>
                                </td>
                                <td width="149" valign="top">
                                    <p align="center">
                                        Dosis
                                    </p>
                                </td>
                                <td width="198" valign="top">
                                    <p align="center">
                                        Frekuensi
                                    </p>
                                </td>
                            </tr>
                            <tr align="center">
                                <td width="47" valign="top">
                                <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $no++;
      
  }
}
      ?>
                                </td>
                                <td width="295" valign="top">
                                <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['nama_obat']; 
      
  }
}
      ?>
                                </td>
                                <td width="149" valign="top">
                                <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['dosis']; 
      
  }
}
      ?>
                                </td>
                                <td width="198" valign="top">
                                <p>
                    <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['frekuensi']; 
      
  }
}
      ?>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                   
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div style="float: right; margin-right: 25%;">
<p>
    Belawan,
</p>
<p>
    Dokter :
</p>
<br><br>
<p>
    (        <?php
      $no = 1;
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){

echo $data['nama_dokter']; 
      
  }
}
      ?>
              )
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
  </div>


<script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 16.1 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
  </body>
</html>





<?php
require_once 'func.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> REASSESMEN / PENGKAJIAN ULANG NYERI NON FARMAKOLOGI</title>
    <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css" >
 <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/bootstrap.min.css" >
   <script src="../js/jquery-3.5.1.slim.js"></script>
          <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> 
        <script src="../js/bootstrap.min.js"></script>
      <script src="../html2pdf/ppdf.js"></script>
    <script src="../bootstrap-4.5.2-dist/js/jquery.min.js"></script>
    <script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
   <style type="text/css">
      @media print{
  #print{
    display: none;
  }
      }
    </style>
  </head>


<body>
  <div id="pdf-area"  style=" width: 1000px;  margin: auto;">

<?php

$qPasien="select p.no_rm,p.nama,p.tgl_lahir,p.sex,p.alamat,p.rt,p.rw,w.nama as desa,i.nama as kec,l.nama as kab,a.nama as prop
from b_ms_pasien p
left join b_ms_wilayah w on w.id=p.desa_id
left join b_ms_wilayah i on i.id=p.kec_id
left join b_ms_wilayah l on l.id=p.kab_id
left join b_ms_wilayah a on a.id=p.prop_id where p.id='".$idPasien."'";
$rsPasien=mysql_query($qPasien);
$rwPasien=mysql_fetch_array($rsPasien);
?>
 <img src="../logors1.png" style="width: 4,91 cm; height:1,97 cm; ">


<div class="box-pasien" style="float: right; padding-right: 0px;">
    <p align='right' style="margin: 0px;;">RM22.1/PHCM</p>
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
  <center><h5>ASUHAN KEPERAWATAN (PLAN OF CARE)</h5></center>
   <br>
 <Center>
<div class="container" style="margin-left: 10%; margin-right: 10%;">

      <table border="1" cellspacing="0" cellpadding="0" align="left" width="800">
    <tbody>
        <tr>
            <td width="174" valign="top">
                <p>
                    Tanggal/Jam
                </p>
            </td>
            <td width="226" valign="top">
                <p align="left">
                    Hari : <?= hari_ini().','.date('d-m-yy').'<br>'.date('h:i'); ?>
                </p>
            </td>
            <td width="247" valign="top">
                <p align="left">
                    Hari : <?= hari_ini().','.date('d-m-yy').'<br>'.date('h:i'); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    <strong>Diagnosa Kerja</strong>
                </p>
            </td>
            <td width="226" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['diagnosa_kerja']; 


      
  }
}
      ?>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['diagnosa_kerja']; 


      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Masalah/Kebutuhan (Prioritaskan)
                </p>
            </td>
            <td width="226" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['kebutuhan']; 


      
  }
}
      ?>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['kebutuhan']; 


      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Kewaspadaan
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "&nbsp;<input type='radio' checked>".$data['kewaspadaan']; 


      
  }
}
      ?>
                </p>
              
            </td>
            <td width="247" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "&nbsp;<input type='radio' checked>".$data['kewaspadaan']; 


      
  }
}
      ?>
                </p>
               
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Tim Dokter
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                    DPJP : <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['dpjp']; 


      
  }
}
      ?>
                </p>
                <p>
                    Tim :
                </p>
                <ul>
                    <li>
                    <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['tim']; 


      
  }
}
      ?>
                    </li>
                    
                </ul>
            </td>
            <td width="247" valign="top">
                <p>
                    DPJP : <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['dpjp']; 


      
  }
}
      ?>
                </p>
                <p>
                    Tim :
                </p>
                <ul>
                    <li>
                    <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['tim']; 


      
  }
}
      ?>
                    </li>
                  
                </ul>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Pemeriksaan
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                 <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['pemeriksaan']; 


      
  }
}
      ?>
                </p>
              
            </td>
            <td width="247" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['pemeriksaan']; 


      
  }
}
      ?>
                </p>
            
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Prosedur/Tindakan
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['tindakan']; 


      
  }
}
      ?>
                </p>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['tindakan']; 


      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Nutrisi
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                    Diet : <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['diet']; 


      
  }
}
      ?>
                </p>
                <p>
                    Batasan Cairan :
                </p>
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['batasan_cairan']; 


      
  }
}
      ?>
                </p>
                
            </td>
            <td width="247" valign="top">
                <p>
                    Diet  : <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['diet']; 


      
  }
}
      ?>
                </p>
                <p>
                    Batasan Cairan : 
                    
                </p>
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['batasan_cairan']; 


      
  }
}
      ?>
                </p>
               
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Aktivitas
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['aktivitas']; 


      
  }
}
      ?>
                </p>
              
            </td>
            <td width="247" valign="top">
                <p>
                  <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['aktivitas']; 


      
  }
}
      ?>
                </p>
               
               
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Pengobatan
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['pengobatan']; 


      
  }
}
      ?>
                </p>
            
              
            </td>
            <td width="247" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['pengobatan']; 


      
  }
}
      ?>
                </p>
               
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Keperawatan
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['keperawatan']; 


      
  }
}
      ?>
                </p>
             
            </td>
            <td width="247" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['keperawatan']; 


      
  }
}
      ?>
                </p>
              
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Tindakan Rehabilitasi Medik
                </p>
            </td>
            <td width="226" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['tindakan_rehabilitas_medik']; 


      
  }
}
      ?>
                </p>
              
            </td>
            <td width="247" valign="top">
                <p>
                <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo "<input type='radio' checked>".$data['tindakan_rehabilitas_medik']; 


      
  }
}
      ?>
                </p>
              
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Konsultasi
                </p>
            </td>
            <td width="226" valign="top">
              <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['konsultasi']; 


      
  }
}
      ?>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['konsultasi']; 


      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    Sasaran
                </p>
            </td>
            <td width="226" valign="top">
              <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['sasaran']; 


      
  }
}
      ?>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['sasaran']; 


      
  }
}
      ?>
            </td>
        </tr>
        <tr>
            <td width="174" valign="top">
                <p>
                    <strong>Nama &amp; Paraf Dokter</strong>
                </p>
                <p>
                    <strong></strong>
                </p>
            </td>
            <td width="226" valign="top">
              <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['nama_dokter']; 


      
  }
}
      ?>
            </td>
            <td width="247" valign="top">
            <?php
 $getone = GetOne($_REQUEST['id']);
      $no = 1;
      if(isset($getone)){
      foreach($getone as $data){  
      
      
echo $data['nama_dokter']; 


      
  }
}
      ?>
            </td>
        </tr>
      
    </tbody>

</table>
</div>   
</div>   
</div>   

      </Center>
   <div class='btn-group' style="margin-left: 40%;">
    <button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
    <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
    <a id="print" href="javascript:history.back()" class="btn btn-primary " >Kembali</a>
  </div>
   </div>
  <center>
    <br>
 
</center>
</div>   
   
 

  
    <script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 22.1 <?=$rwPasien['nama']?>.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
  </body>
</html>




<html>
    <head>
    
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
      
        <title>CATATAN ASESMEN PRA OPERASI</title>
    
    </head>
<body onload="window.print()">
  <div  style=" width: 1000px;  margin: auto;">

<H4><img src="../logors1.png" width="400" height="120"><BR>
&nbsp;&nbsp;&nbsp;JL. STASIUN NO. 92 MEDAN<BR>
&nbsp;&nbsp;&nbsp;Telepon (061) 6941927 - 6940120</H4>
<div class="box-pasien" style="float: right; padding-right: 0px;">
<b>RM 21.16/PHCM</b>
  </div>
  <br>
<div class="box-pasien" style="float: right; padding-right: 220px;">
<b>Nama : </b>
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b>Tgl.lahir :</b> 
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b>Jenis Kelamin :</b> 
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b>No.RM :</b> 
  </div>
  <br>
  <hr>
  <center><h3>CATATAN ASESMEN PRA OPERASI</h3></center>
  <div class="box-pasien" style="float: left; padding-left: 200px;">
<b>Halaman Ke :</b> 
  </div>
  <div class="box-pasien" style="float: right; padding-right: 200px;">
<b>Ruangan :</b> 
  </div>
  <center>
            <?php
                  $id = $_REQUEST['id'];
  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $tgl_serah = date('m/d/yy');
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);



              $queryview = mysql_query("SELECT * FROM rm_asesmen_pra_operasi WHERE id='$id' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
   <table border="1"    width="1000"  style="font-size: 11px; margin: auto;">
          
                <tr>
             
                  <th>Ruangan  : <?= $row['ruangan'] ?></th>
                
                  <th>Tanggal & jam :<?= $row['tanggal'] ?></th>
                
                    
                
                </tr>
                 <tr>
                  <td>Diagnosis Pra Operatif : <?= $row['diagnosis'] ?></td>
              
                  <td>Timming Tindakan   :  <?= $row['timming_tindakan'] ?></td>
                  </tr>
              </table>

                 <table style="border: 1px solid black;" width="1000" cellpadding="5" cellspacing="10" style="font-size: 11px; margin: auto;">
               
                  <tr >
                    <td>Indikasi Tindakan  :<?php echo $row['indikasi_tindakan'];?>
                    <hr>
                    </td>
                  </tr>

                   <tr>
                    <td>Rencana Tindakan : <?php echo $row['rencana_tindakan'];?>
                        <hr>
                    </td>  

                  </tr>
                  <tr>
                    <td>Prosedur Tindakan  :<?php echo $row['prosedur_tindakan'];?>
                        <hr>
                    </td>
                  </tr>
                  <tr>
                    <td>Alternatif Lain  :<?php echo $row['alternatif_lain'];?>
                        <hr>
                    </td>
                  </tr>
                  <tr>
                    <td>Resiko / Kompilasi & Kemungkinan perdarahan intra operasi :<?php echo $row['kompilasi'];?>  <hr>
                    </td>
                  </tr>
                  <tr>
                    <td>Pemantauan khusus pasca tindakan :<?php echo $row['pemantauan_tindakan'];?>
                        <hr>
                    </td>
                  </tr>
     
              
     
                  
                </table>
                <?php } ?>
                <Br>
  <Br>
                <div class="box-pasien" style="float: right; padding-right: 100px;">
<b>Dokter Penanggung jawab</b>
  </div>
  <Br>
  <Br>
   <Br>
  <Br>
                  <div class="box-pasien" style="float: right; padding-right: 70px;">
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
  </div>
  

   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" href="../favicon.png">
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      
        <title>FORMULIR PASIEN KOMPLAIN</title>
         <style type="text/css">
    @media print {
      #print {
        display: none;
      }
    }
  </style>
    <script src="../html2pdf/ppdf.js"></script>
    
    </head>
<body>
<center>
        <BR>
        <div class='btn-group'>
          <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
          <a id="print" href="javascript:history.back()" class="btn btn-primary " style="text-decoration: none; color: white;">Kembali</a>
        </div>
      </center>
  <div id="pdf-area" style=" width: 1000px;  margin: auto;">

<H4><img src="../logors1.png" width="400" height="120"><BR>
&nbsp;&nbsp;&nbsp;JL. STASIUN NO. 92 MEDAN<BR>
&nbsp;&nbsp;&nbsp;Telepon (061) 6941927 - 6940120</H4>
<div class="box-pasien" style="float: right; padding-right: 0px;">
<b>RM 25/PHCM</b>
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
<b>No.RM :</b> 
  </div>
  <br>
  <hr>
  <center><h3>FORMULIR PASIEN KOMPLAIN</h3></center>
   
              
                  <?php
                  $id = $_REQUEST['id'];
  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $tgl_serah = date('m/d/yy');
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);
$result = mysql_query("SELECT * FROM rm_barang_pasien");


              $queryview = mysql_query("SELECT * FROM rm_pasien_komplain WHERE id='$id'",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
             
<p style="padding-left: 155px; text-align: left;">                                                                                             
Yang bertanda tangan di bawah ini :
<br>
<br>
N a m a     : 
<br>
Jenis Kelamin     : 
<br>
Pekerjaan     : 
<br>
No. Telp / HP     : 
<br>
<br>
Bersama ini disampaikan saran / keluhan kami mengenai pelayanan RS PRIMA HUSADA CIPTA MEDAN, tentang hal-hal yang dialami oleh kami sendiri/ keluarga dari pasien :
<br>
<br>
N a m a           : <?= $row['nama']; ?>
<br>
Dirawat / berobat di Unit Rawat Jalan   :  <?= $row['unit_rawat']; ?> 
<br>
Mengenai / Hal        : <?= $row['hal']; ?>
<br>
Kronologis keluhan        : 
<br>    
<?= $row['keluhan']; ?>      
<br>     
<br>
Pertanyaan          :  
<br>    
<?= $row['pertanyaan']; ?>
<br>
<br>
Solusi          :  
<br>    

<br>
<br>
</p>



<div class="box-pasien" style="float: right; padding-right: 50px;">
Belawan, <?= date('d-m-yy') ?>
<br>
Hormat Kami,
<br>
<br>
<br>
<br>
<br>
( ........................................... )

  </div>

<ul style="padding-left: 170px; text-align: left;">
  <li>Rahasia Jabatan Di pegang penuh</li>
</ul>
       <?php }?>          

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 25.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
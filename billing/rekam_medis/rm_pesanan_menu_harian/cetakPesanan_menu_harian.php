   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
      
        <title>FORMULIR PESANAN MENU HARIAN </title>
    <script src="../html2pdf/ppdf.js"></script>
<style type="text/css">
    @media print {
      #print {
        display: none;
      }
    }
  </style>      
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
<b>RM 15.3/PHCM</b>
  </div>
  <br>
<div class="box-pasien" style="float: right; padding-right: 220px;">
<b>Nama : </b>
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b><TABLE></TABLE>Tgl.lahir :</b> 
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b><TABLE></TABLE>Jenis Kelamin :</b> 
  </div>
  <br>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<b>No.RM :</b> 
  </div>
  <br>
  <hr>
  <center><h3>FORMULIR PESANAN MENU HARIAN</h3>

    <?php 
    $id = $_GET['id'];
$konek = mysql_connect("localhost","root","");
mysql_select_db("rspelindo_billing",$konek);
                $query= mysql_query("SELECT * FROM rm_pesanan_menu_harian WHERE id='$id' ",$konek);
    ?>
    <?php while($data = mysql_fetch_assoc($query)){ ?>
   <table  border="1" cellpadding="10" width="800" >
          
      <tr>
        <td>
         Tanggal
        </td>
 
        <td>
<?= $data['tanggal']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Nama Pasien
        </td>

        <td>
          <?= $data['nama_pasien']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Tanggal Lahir
        </td>

        <td>
<?= $data['tgl_lahir']; ?>          
        </td>
     </tr>

     <tr>
        <td>
         Medical Record
        </td>

        <td>
          <?= $data['medical_record']; ?>
        </td>
     </tr>


     <tr>
        <td>
         No Kamar/Kelas
        </td>

        <td>
          <?= $data['no_kamar']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Jenis Diet
        </td>

        <td>
          <?= $data['jenis_diet']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Keterangan Diet
        </td>

        <td>
          <?= $data['tanggal']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Waktu Makan
        </td>

        <td>
          <?= $data['waktu_makan']; ?>
        </td>
     </tr>
     <tr>
        <td>
         Menu
        </td>

        <td>
          <?= $data['menu']; ?>
        </td>
     </tr>

     <tr>
        <td>
         Buah
        </td>

        <td>
          <?= $data['buah']; ?>
        </td>
     </tr>

     <tr>
        <td>
         AccNutrisionis
        </td>

        <td>
          <?= $data['accnutrisionis']; ?>
        </td>

        <tr>
        <td>
         Keterangan
        </td>

        <td>
          <?= $data['keterangan']; ?>
        </td>
     </tr>
<?php } ?>
     
     
     
     
              </table>
    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 15.3 <?=$data['nama_pasien'];?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="icon" href="../favicon.png">
        <title>FORMULIR PELAYANAN KEGIATAN ROHANI</title>
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
<b>RM 29/PHCM</b>
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
  <center><h3>FORMULIR PERMINTAAN PELAYANAN KEGIATAN ROHANI</h3></center>
   
              
                  <?php
                  $id = $_REQUEST['id'];
  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $tgl_serah = date('m/d/yy');
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);



              $queryview = mysql_query("SELECT * FROM rm_pelayanan_kegiatan_rohani WHERE id='$id'",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
             
<p style="padding-left: 155px; text-align: left;">
Nama   : <?= $row['nama']?>
<br>
<br>
Jenis kelamin : <?= $row['jenis_kelamin']?>
<br>
<br>
Umur    : <?= $row['umur']?>
<br>
<br>
Ruangan : <?= $row['ruangan']?>
<br>
<br>
  Saya yang bernama tersebut diatas sangat membutuhkan Perawatan Spiritual untuk mendorong, memfasilitasi dan wewenang kemitraan perawatan antara penyedia layanan kesehatan saya dan komunitas iman/ penyedia layanan spiritual saya dan dalam rangka untuk menerima perawatan rohani yang sesuai dan tepat waktu.
  <br>
<br>
  Saya Secara <b>Sukarela</b> meminta dan memberikan kewenangan, penasihat spiritual pribadi saya :
  <br>
<br>
Nama    : <?= $row['nama_penasihat_spiritual']?>
<br>
<br>
Nama Organisasi Pelayanan Kerohanian : <?= $row['nama_organisasi_rohani']?>
<br>
<br>

  Dengan ini menyatakan bahwa saya telah memberikan Wewenang Penuh kepada pelayanan kesehatan tersebut diatas untuk memberikan pelayanan perawat dan spiritual yang tepat bagi saya, jika saya : (tandai yang sesuai)
  <br>
<br>
o Dirawat di Rumah Sakit
<br>
o Dipindahkan kefasilitas perawatan kesehatan lain
<br>
o Saya atau keluarga saya telah diberitahu tentang perubahan yang signifikan terhadap kesehatan mental atau fisik saya
<br>
o Saya atau keluarga telah diberitahu tampaknya saya akan meninggal
<br>
<br>
Demikian pernyataan ini saya sampaikan agar dapat dipergunakan dengan sebaik- baiknya.
<br>
<br>

Medan, tanggal <?= date('d-m-yy');?>.pukul <?=  date('i.s');?> 
</p>

<center>
                <table cellpadding="20" cellspacing="20">
                  <tr>
                    <td>Yang Menyatakan</td>
                    <td>Saksi,</td>
                    <td>Pemberi pelayanan kerohanian,</td>
                  </tr>
                  <tr>
                    <td>..............................</td>
                    <td>..............................</td>
                    <td>..............................</td>
                  </tr>
                </table>
                        <div class="box-pasien" style="float: right; padding-right: 50px;">

  </div>
       <?php }?>          

           <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 29.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
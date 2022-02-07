<html>
    <head>
    
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="icon" href="../favicon.png">
        <title>FORMULIR DO NOT RESUSCITATE</title>
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
<b>RM 26/PHCM</b>
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
  <center>
  <h3>FORMULIR DO NOT RESUSCITATE<br>
(JANGAN DILAKUKAN RESUSITASI)
</h3></center>
<?php
$konek = mysql_connect("localhost","root","");
mysql_select_db("rspelindo_billing");
$query = mysql_query("SELECT * FROM rm_resusitasi WHERE id='$id' ")
 ?>
  <p>
      Hanya diisi oleh Dokter
Formulir ini adalah perintah dokter penanggung jawab pelayanan kepada seluruh staf klinis rumah sakit, agar tidak dilakukan resusitasi pada pasien ini bila terjadi henti jantung (bila tak ada denyut nadi) dan henti nafas (tak ada pernafasan spontan).
<br>
<br>
Formulir ini juga memberikan perintah kepada staf medis untuk tetap melakukan intervensi atau pengobatan, atau tata laksana lainnya  sebelum terjadinya henti jantung atau henti nafas.
<br>
<br>
<?php while($data = mysql_fetch_array($query)){  ?>
- Nama pasien     : <?= $data['nama_pasien'] ?>
<br>
<br>
- Tanggal lahir / Umur  : <?= $data['tgl_lahir'] ?>
<br>
<br>
- No. Rekam Medis : <?= $data['no_rm'] ?>
<?php } ?>
<br>
<br>

Perintah / Pernyataan dokter penanggung jawab pelayanan
<br>
<br>
Saya dokter yang bertanda tangan dibawah ini menginstruksikan kepada seluruh staf medis dan staf klinis lainnya untuk melakukan hal-hal tertulis dibawah ini :
<br>
<br>
- Usaha komprehensif untuk mencegah henti jantung atau henti nafas tanpa melakukan intubasi. DO NOT RESUSCITATE  TIDAK DILAKUKAN RESUSITASI JANTUNG PARU (RJP)
<br>
<br>
- Usaha suportif sebelum terjadi  henti nafas atau henti jantung yang meliputi pembukaan jalan nafas non invasive, mengontrol perdarahan, memposisikan pasien dengan nyaman, pemberian obat-obatan anti nyeri. TIDAK MELAKUKAN RJP (RESUSITASI JANTUNG PARU) bila henti nafas atau henti jantung terjadi.
<br>
<br>
Saya dokter yang bertanda tangan dibawah ini menyatakan bahwa keputusan DNR diatas diambil setelah pasien diberikan penjelasan dan informed consent diperoleh dari salah satu :
<br>
<br>
- Pasien
<br>
- Tenaga kesehatan yang ditunjuk pasien
<br>
- Wali yang sah atas pasien (termasuk yang ditunjuk oleh pengadilan)
<br>
- Anggota keluarga pasien
Jika yang diatas tidak dimungkinkan maka dokter yang bertanda tangan dibawah ini memberikan perintah DNR berdasarkan pada :
<br>
- Instruksi pasien sebelumnya atau 
<br>
- Keputusan dua orang dokter yang menyatakan bahwa Resusitasi Jantung Paru (RJP)  akan mendatangkan hasil yang tidak efektif
<br>

  </p>
                        <div class="box-pasien" style="float: right; padding-right: 50px;">
Belawan, ....................................
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter
<br>
<br>
<br>
<br>
<br>
(................................................)
  </div>

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 26.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>

<html>
<head>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CHECK LIST KESIAPAN BEDAH</title>
<style>
  @media print {
    #print {
      display:none;
    }
  }
</style>
    <script src="../html2pdf/ppdf.js"></script>
</head>
<body style="padding:0px; margin: 0px;">
<center>
  <button id='print' class='btn btn-info' onclick='javascript:pdf()'>Cetak PDF</button>
  <button id='print' onclick="window.print()">Cetak</button>
</center>

  <div id="pdf-area" style=" width: 1000px;  margin: auto;">

<H4><img src="logors1.png" width="400" height="120"><BR>
&nbsp;&nbsp;&nbsp;JL. STASIUN NO. 92 MEDAN<BR>
&nbsp;&nbsp;&nbsp;Telepon (061) 6941927 - 6940120</H4>
<div class="box-pasien" style="float: right; padding-right: 0px;">
<b>RM 21.15/PHCM</b>
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
<h4>CHECK LIST KESIAPAN BEDAH
<br>


</h4>
<table border="1" width="640">
  <tr>
    <td>Ruangan :</td>
    <td>
      Tanggal :
      <br>
      Jam:
    </td>
  </tr>
   <tr>
    <td>Diagnosis :</td>
    <td>Jenis Operasi :</td>
  </tr>
   <tr>
    <td>Teknik Anesthesi : :</td>
    <td>Tgl. Tindakan  :</td>
  </tr>
</table>
<table border="1" width="640">
   <tr>
     <td>
      <br>
<b>Listrik</b>
<br>
<input type="checkbox" name=""> Mesin diatermi terhubung dengan sumber listrik,indikator(+)
<br>
<input type="checkbox" name=""> Mesin suction pump terhubung dengan aliran listrik (+)
<br>
<input type="checkbox" name=""> Mesin heater cooler terhubung dengan sumber listrik, indikator (+)
<br>
<input type="checkbox" name=""> Mesin gergaji/Bor terhubung dengan sumber listrik, indikator (+)
<br>
<input type="checkbox" name=""> film viewver terhubung dengan sumber listrik,indikator (+)
<br>
<input type="checkbox" name=""> Lampu operasi sudah di test dan menyala dengan terang
<br>
<input type="checkbox" name=""> Lampu kamar operasi menyala
<br>
<input type="checkbox" name=""> AC berfungsi dengan baik

<br><br>


<b>Alat</b>
<br>
<input type="checkbox" name="">Tersedia tabung ,selang dan konektor suction pump
<br>
<input type="checkbox" name=""> Patient plate sudah tersedia
<br>
<input type="checkbox" name=""> Instrument steril sesuai kebutuhan sudah tersedia
<br>
<input type="checkbox" name=""> Handle lamp steril sudah tersedia
<br>
<input type="checkbox" name=""> Kom steril sudah tersedia
<br><br>

<b>Linen Steril</b>
<br>
<input type="checkbox" name=""> Jas steril
<br>
<input type="checkbox" name=""> Duk steril
<br>
<input type="checkbox" name=""> Sarung meja mayo
<br>
<input type="checkbox" name=""> Sarung kaki
<br>
<input type="checkbox" name=""> Sarung suction
<br><br>
<b>AKHP</b>
<br>
<input type="checkbox" name=""> Tersedia AKHP sesuai kebutuhan

<br>
<p>
  <Br>
Pemeriksa   : ..…………………………………………Tanda tangan………………………….  <Br>
Perawat kamar bedah 
  <Br>  <Br>

Kepala ruangan : …………………………………………..Tanda tangan………………………….  <Br>
</p>

     </td>
   </tr>
</table>
</div>
    

<script>
    function pdf() {
        const pdf = document.getElementById("pdf-area");
        var opt = {
            margin: 0,
            filename: "RM 21.15.pdf",
            image: { type: "JPEG", quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
        };
        html2pdf().from(pdf).set(opt).save();
    }
    </script>
</body>
</html>
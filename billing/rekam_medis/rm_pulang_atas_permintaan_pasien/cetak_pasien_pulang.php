   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="icon" href="../favicon.png">
        <title>PULANG ATAS PERMINTAAN PASIEN</title>
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
<b>RM 20/PHCM</b>
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
     <center> <h4>PULANG ATAS PERMINTAAN PASIEN</h4></center>
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


              $queryview = mysql_query("SELECT * FROM rm_pasien_pulang WHERE id='$id' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
          
<p style="margin:auto;"> 
Yang bertanda tangan dibawah ini : 
<br><br>
Nama   : _________________________________, Tanggal Lahir : __________________________
<br><br>
Hubungan dengan pasien : pasien sendiri / suami / istri / anak / ayah / ibu,*lain-lain__________
<br><br>
Alamat : _______________________________________________________________________
<br><br>
Dengan ini menyatakan Pulang Atas Permintaan Pasien  :
<br><br>
Nama Pasien : <?= $row['nama'] ?>      Tgl Lahir : <?= $row['tgl_lahir'] ?>  No RM : <?= $row['no_rm'] ?> 
<br><br>
Ruang / Kelas Perawatan :    <?= $row['ruang'] ?> 
<br><br>
Dengan ini menyatakan permintaan untuk menghentikan <b>perawatan / pengobatan</b> ( keduanya atau coret salah satu) dan pulang atas permintaan sendiri.
<br><br>
Saya telah mendapat penjelasan dari dokter terkait hak saya untuk menolak dan tidak melanjutkan perawatan / pengobatan, tentang: 
<br><br>
1.  Konsekwensi dari keputusan saya 
<br>
2.  Tanggung jawab saya dengan keputusan tersebut 
<br>
3.  Tersedianya alternatif pelayanan dan pengobatan di __________________________________
<br><br>
Maka saya tidak akan menuntut pihak Rumah Sakit atau siapapun juga akibat dari keputusan saya pulang atas permintaan sendiri.</p>
  <div class="box-pasien" style="float: right; padding-right: 220px;">
<br><b>____________ , ________________________</b>
</div>

                <table cellpadding="20" cellspacing="20">
                  <tr>
                    <td>Dokter yang menerangkan</td>
                    <td>Saksi</td>
                    <td>Yang Membuat pernyataan</td>
                  </tr>
                  <tr>
                    <td>..............................</td>
                    <td>..............................</td>
                    <td>..............................</td>
                  </tr>
                </table>
                        <div class="box-pasien" style="float: right; padding-right: 50px;">
 
  </div>
              </center>
          
</p>
<? } ?>

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 20 <?=$rwPasien['nama']?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
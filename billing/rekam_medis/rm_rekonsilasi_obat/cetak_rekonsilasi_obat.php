   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
      
        <title>REKONSILASI OBAT</title>
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
<b>RM 14/PHCM</b>
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

  <center><h3>REKONSILASI OBAT</h3>
    <div class="box-pasien" style="float: left; padding-right: 0px; border: 1px dashed black;">
<b>Alergi Obat : Ya/Tidak</b>
<Br>
<b>JikaYa : ..........................</b>
  <br>
   <br>
    <br>
     <br>

</div>

 <br><br><br><br><br><br>
    <table border="1">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>Nama Obat</th>
                   <th>Jumlah</th>
                  <th>Dosis</th>
                  <th>Rute</th>
                     <th>Nama Pengguna</th>
                     <th>Tindak Lanjut</th>
                     <th>Perubahan Aturan Pakai</th>
         
                </tr>
              </thead>
              <tbody>
                  <?php
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);

                   $id = $_REQUEST['id'];
                   $idPasien = $_REQUEST['idPasien'];
                   
              $queryview = mysql_query("SELECT * FROM rm_rekonsilasi_obat WHERE id='$id' AND id_pasien='$idPasien' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
                  <tr class="trdata">
                    <td><?php echo $no++;?></td>
                  <td><?php echo $row['tanggal'];?></td>
                    <td><?php echo $row['nama_obat'];?></td>
                    <td><?php echo $row['jumlah'];?></td>
                    <td><?php echo $row['dosis'];?></td>                    
                    <td><?php echo $row['rute'];?></td>
                    <td><?php echo $row['nama_pengguna'];?></td>
                    <td><?php echo $row['tindak_lanjut']; ?></td>
                    <td><?php echo $row['perubahan_aturan_pakai']; ?></td>
                    </tr>
                  </tbody>
                </table>
              <? } ?>
                <table cellpadding="20" cellspacing="20">
                  <tr>
                    <td>Dokter</td>
                    <td>Pasien/Keluarga Pasien</td>
                    <td>Apoteker</td>
                  </tr>
                  <tr>
                    <td>..............................</td>
                    <td>..............................</td>
                    <td>..............................</td>
                  </tr>
                </table>
                        <div class="box-pasien" style="float: right; padding-right: 50px;">
<br><br> 
  </div>

              </center>
<div class="alamat" style="float: right;">              
Jalan stasiun No 92 Kel. Belawan Bahagia<br>
Kec. Medan Belawan 20413<br>
Kota Medan – Sumatera Utara<br>
rspelabuhan@pelindo1.co.id<br></div>     

    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 14.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
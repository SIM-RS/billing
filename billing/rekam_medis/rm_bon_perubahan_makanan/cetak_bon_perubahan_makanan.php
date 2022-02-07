<html>
    <head>
    
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
      
        <title>BON PERUBAHAN MAKANAN</title>
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
<b>RM 15.4/PHCM</b>
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
  <center><h3>Bon Perubahan Makanan</h3>
   <table border="1"    width="1000"  style="font-size: 11px; margin: auto;">
          
                <tr>
             
                  <th>No.</th>
                  <th>Nama Pasien </th>
                  <th>NO.RM</th>
                  <th>Ruang / Kelas</th>
                   <th>Jenis diet</th>
                   <th>Diagnosa</th>
                   <th>DPJP</th>
                    
                
                </tr>
              
                  <?php
                  $id = $_REQUEST['id'];
  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $tgl_serah = date('m/d/yy');
                    $no = 1;
                           $konek=mysql_connect("localhost","root","");
                          mysql_select_db("rspelindo_billing",$konek);



              $queryview = mysql_query("SELECT * FROM rm_bon_perubahan_makanan WHERE id='$id' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
                  <tr class="trdata">
                     <td><?php echo $no++;?></td>
                    <td><?php echo $row['nama_pasien'];?></td>
                    <td><?php echo $row['no_rm'];?></td>
                    <td><?php echo $row['ruang'];?></td>
                    <td><?php echo $row['jenis_diet']; ?></td>
                       <td><?php echo $row['diagnosa']; ?></td>
                       <td><?php echo $row['dpjp']; ?></td>
                    </tr>
                  
                </table>
                <?php } ?>

                        <div class="box-pasien" style="float: right; padding-right: 50px;">
                          <Br>
                          <Br>
                          <Br>
<b>Belawan, ....................................</b> 
  </div>
  <br>
  <br>
                <table cellpadding="20" cellspacing="20" style="margin-left: 250px;">
                  <tr>
                    <td>Penerima</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>Pemesan,</td>
                  </tr>
                  <tr>
                    <td>(..............................)</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>(..............................)</td>
                  </tr>
                </table>

              </center>
              <p>Lembar putih   : Jasa Boga<Br>
Lembar Merah  : Instalasi Gizi
 
             
</p>
      <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 15.4.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>

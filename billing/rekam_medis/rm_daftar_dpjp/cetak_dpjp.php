<html>
    <head>
    
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
      <link rel="icon" href="../favicon.png">
        <title>Daftar DPJP</title>
    <script src="../html2pdf/ppdf.js"></script>
    <style>
      @media print {
        #print {
          display:none;
        }
      }
    </style>    
    </head>
<body>
<center>
<button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
          <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
</center>
  <div id="pdf-area" style=" width: 1000px;  margin: auto;">

<H4><img src="../logors1.png" width="400" height="120"><BR>
&nbsp;&nbsp;&nbsp;JL. STASIUN NO. 92 MEDAN<BR>
&nbsp;&nbsp;&nbsp;Telepon (061) 6941927 - 6940120</H4>
<div class="box-pasien" style="float: right; padding-right: 0px;">
<b>RM 11/PHCM</b>
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
  <center><h3>Daftar DPJP</h3>
   <table border="1"     width="1000"  style="font-size: 11px; margin: auto;">
          
                <tr>
             
                  <th>Diagnosa</th>
                  <th>Nama Dokter</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Akhir</th>
                   <th>Keterangan</th>
                    
                
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



              $queryview = mysql_query("SELECT * FROM rm_dpjp WHERE id='$id' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
                  <tr class="trdata">
                 
                    <td><?php echo $row['diagnosa'];?></td>
                    <td><?php echo $row['nama_dokter'];?></td>
                    <td><?php echo $row['tgl_mulai'];?></td>
                    <td><?php echo $row['tgl_akhir']; ?></td>
                       <td><?php echo $row['keterangan']; ?></td>
                    </tr>
                  
                </table>
                <?php } ?>

                 <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 11.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
  

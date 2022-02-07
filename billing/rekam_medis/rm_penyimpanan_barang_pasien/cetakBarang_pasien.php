   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
      
        <title>FORMULIR PENYIMPANAN BARANG BERHARGA MILIK PASIEN</title>
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
<b>RM 31/PHCM</b>
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
  <center><h3>FORMULIR PENYIMPANAN BARANG BERHARGA MILIK PASIEN</h3>
   <table border="1"    width="1000"  style="font-size: 11px; margin: auto;">
          
                <tr>
                  <th>No.</th>
                  <th>Jenis Barang / Benda</th>
                  <th>Jumlah</th>
                  <th>Kondisi Barang</th>
                  <th>Tanggal dititipkan</th>
                    
                
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
$result = mysql_query("SELECT * FROM rm_barang_pasien");


              $queryview = mysql_query("SELECT * FROM rm_barang_pasien WHERE id='$id' ",$konek);
                    while ($row = mysql_fetch_assoc($queryview)) {
                  ?>
                  <tr class="trdata">
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['barang'];?></td>
                    <td><?php echo $row['jumlah'];?></td>
                    <td><?php echo $row['kondisi_barang'];?></td>
                  
                
                    <td><?php echo $row['tgl_titip']; ?></td>
                    </tr>
                  
                </table>
                <?php } ?>
  

                <table cellpadding="20" cellspacing="20">
                  <tr>
                    <td>Petugas</td>
                    <td>Saksi Rumah Sakit</td>
                    <td>Saksi,</td>
                  </tr>
                  <tr>
                    <td>..............................</td>
                    <td>..............................</td>
                    <td>..............................</td>
                  </tr>
                </table>
                        <div class="box-pasien" style="float: right; padding-right: 50px;">
<b>Medan, ....................................</b> 
  </div>
              </center>
              <p>Catatan : dalam keadaan khusu pasien tidak sadar, saksi minimal dua orang dari pihak 
              <br>    
                pengantar dan dari Rumah Sakit
</p>
    <script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 31.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>
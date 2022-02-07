<?
include("../sesi.php");
include("../koneksi/konek.php");
$idunit=$_GET["sunit"];
//echo $idunit;
$no_penjualan=$_GET['no_penjualan'];
//echo $no_penjualan;
?>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</script>
<style type="text/css">
<!--
.style1 {
font-family: "Courier New", Courier, monospace;
font-size:14px;}
-->
</style>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>

<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:block;">
	<?php
	if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	$qrySingle="SELECT a_penjualan.*,a_kepemilikan.NAMA,a_user.username,UNIT_NAME from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user WHERE a_penjualan.NO_PENJUALAN=$no_penjualan and a_penjualan.UNIT_ID=$idunit  and NO_RETUR<>'0' and NO_RETUR<>''";
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	$retur=$showSingle['NO_RETUR'];
	$qty_retur=$showSingle['QTY_RETUR'];
	system("/usr/bin/lpr penjualan.php")
	
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <table width="421" border="0" class="style1">
      <tr>
        <td width="429">
		<table width="413" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
         <tr class="style1">
            <td height="45" colspan="3" class="style1" style="font-size:16px"><b><?=$namaRS;?><br>
            <?=$alamatRS;?></b><hr size="1" color="#000000"></td>
          </tr>
		   <tr>
            <td colspan="3"><? $u="select UNIT_NAME from a_unit where UNIT_ID='$idunit'";
								//echo $u;
								$rsu=mysqli_query($konek,$u);
								$row=mysqli_fetch_array($rsu);
								echo $row['UNIT_NAME'];
								?>&nbsp;</td>
            </tr>
          <tr>
            <td>No. Kwitansi </td>
            <td width="84">: <?php echo $showSingle['NO_PENJUALAN']; ?></td>
            <td width="156"><? echo $retur; ?></td>
          </tr>
            <tr><td width="174">Tanggal</td>
            <td colspan="2">: <?php echo date("d/m/y H:i:s",strtotime($showSingle['TGL_ACT'])); ?></td>
          </tr>
          <tr>
            <td>No. Kunjungan</td>
            <td colspan="2">: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
          </tr>
          <tr >
            <td>No Rekam Medis</td>
            <td colspan="2">: <?php echo $showSingle['NO_PASIEN']; ?></td>
          </tr>
          <tr>
            <td >Nama Pasien </td>
            <td colspan="2" >: <?php echo $showSingle['NAMA_PASIEN']; ?>&nbsp;</td>
          </tr>
          <tr>
            <td >Jenis Pasien</td>
            <td colspan="2" >: <?php echo $showSingle['NAMA']; ?></td>
          </tr><tr>
            <td >Dokter</td>
            <td colspan="2" >: <?php echo $showSingle['DOKTER']; ?></td>
          </tr><tr>
            <td >Poli</td>
            <td colspan="2" >: <?php echo $showSingle['UNIT_NAME']; ?></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="2" >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" ><table width="414" border="0" cellpadding="0" cellspacing="0" align="left">
            <?php 
				  $sqlPrint="SELECT a_penjualan.ID,NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,a_penjualan.QTY,a_penjualan.QTY_JUAL,a_penjualan.QTY_RETUR from a_penjualan Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID where a_penjualan.NO_PENJUALAN='$no_penjualan' and UNIT_ID=$idunit group by NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ";
				  //echo $sqlPrint;
				  $exePrint=mysqli_query($konek,$sqlPrint);
				  $i=1;
				  while($showPrint=mysqli_fetch_array($exePrint)){
				  ?>
            
			<? if($qty_retur=="" or $qty_retur=="0"){ ?> 
			<tr>
              <td width="42" align="center" class="style1"><?php echo $i++ ?></td>
              <td width="328" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?></td>
              <td width="44" class="style1"><?php echo $showPrint['QTY']; ?></td>
            </tr>
           <? }else{ ?>
		   <tr>
              <td width="42" align="center" class="style1"><?php echo $i++ ?></td>
              <td width="328" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?></td>
              <td width="44" class="style1"><?php echo $showPrint['QTY_JUAL']; ?></td>
              <td width="44" class="style1">-<?php echo $showPrint['QTY_RETUR']; ?></td>
              <td width="44" class="style1">=<?php echo $showPrint['QTY']; ?></td>
            </tr>
		   
		    <? } } ?>
           
            <tr>
              <td colspan="5" align="right" class="style1">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="style1">Harga Total : Rp. <?php echo number_format($showSingle['HARGA_TOTAL'],2,",","."); ?></td>
            </tr>
            <tr>
				<?php
      function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = kekata($x - 10). " belas";
          } else if ($x <100) {
              $temp = kekata($x/10)." puluh". kekata($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . kekata($x - 100);
          } else if ($x <1000) {
              $temp = kekata($x/100) . " ratus" . kekata($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . kekata($x - 1000);
          } else if ($x <1000000) {
              $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
          } else if ($x <1000000000) {
              $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
          }      
              return $temp;
      }
      function terbilang($x, $style=4) {
          if($x<0) {
              $hasil = "minus ". trim(kekata($x));
          } else {
              $hasil = trim(kekata($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }
	  $bilangan= $showSingle['HARGA_TOTAL'];
	  $bilangan=terbilang($bilangan,3);
	  
	  //=====Bilangan setelah koma=====
	  $sakKomane=explode(".",$showSingle['HARGA_TOTAL']);
	  $koma=$sakKomane[1];
	  $koma=terbilang($koma,3);
	  if($sakKomane[1]<>"") $koma= "Koma ".$koma."&nbsp;";
      ?>
                  <td colspan="5" align="right" class="style1"><?php echo $bilangan."&nbsp;".$koma."Rupiah";?></td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="style1" style="padding-right:5px;;text-align:left">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" align="right" class="style1" style="padding-right:5px;;text-align:left">Kasir : <?php echo $showSingle['username']; ?></td>
            </tr>
<tr>
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
              <td colspan="5" align="right" style="padding-right:5px;font-size:18px"><div align="left"><span style="font-size:14px; "><em>Bukti pembayaran ini juga berlaku sebagai kwitansi</em></span></div></td>
          </tr>
          </table></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="2" ></td>
          </tr>
        </table>
		
	  
        </td>
      </tr>
	  <tr>
	  <td align="left">
	  <!--a href="#" value="Print kwitansi penjualan ini" onClick="window.print()" class="navText"-->
		<BUTTON type="button" value="Print kwitansi penjualan ini" onClick="window.print()"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'"></BUTTON>
		<!--/a-->
	  </td></tr>
  </table>
</div>
</body>
</html>

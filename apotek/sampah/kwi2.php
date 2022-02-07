<?
include("../sesi.php");
include("../koneksi/konek.php");
$idunit=2;
$no_penjualan='000019';
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>


<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:block;">
	<?php
	if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	$qrySingle="SELECT a_penjualan.*,a_kepemilikan.NAMA,a_user.username from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_user on a_penjualan.USER_ID=a_user.kode_user WHERE a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	system("/usr/bin/lpr penjualan.php")
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <table width="356" border="0">
      <tr>
        <td width="350">
		<table width="342" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="txtinput">
         <tr>
            <td height="45" colspan="2" style="font-size:14px"><?=$namaRS;?><br>
            <?=$alamatRS;?> <hr size="1" color="#000000"></td>
          </tr>
          <tr >
            <td>No. Kwitansi </td>
            <td><span style="font-size:14px">: <?php echo $showSingle['NO_PENJUALAN']; ?></span></td>
          </tr>
          <tr style="font-size:18px">
            <td width="130"><span class="style1">Tanggal&nbsp; </span></td>
            <td width="345">: <?php echo date("d/m/Y",strtotime($showSingle['TGL'])); ?></td>
          </tr>
          <tr ">
            <td>No. Kunjungan</td>
            <td>: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
          </tr>
          <tr >
            <td>No Rekam Medis</td>
            <td>: <?php echo $showSingle['NO_PASIEN']; ?></td>
          </tr>
          <tr>
            <td >Nama Pasien </td>
            <td >: <?php echo $showSingle['NAMA_PASIEN']; ?>&nbsp;</td>
          </tr>
          <tr>
            <td >Jenis Pasien</td>
            <td ><?php echo $showSingle['NAMA']; ?></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" ><table width="342" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size:18px;">
            <?php 
				  $sqlPrint="SELECT a_penjualan.*, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL
				  FROM a_penjualan
				  Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID
				  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
				  where a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
				  $exePrint=mysqli_query($konek,$sqlPrint);
				  $i=1;
				  while($showPrint=mysqli_fetch_array($exePrint)){
				  ?>
            <tr>
              <td width="29" align="center" ><?php echo $i++ ?></td>
              <td width="228" >
			  <?php echo $showPrint['OBAT_NAMA']; ?></td>
              <!--td class="tdisi" align="center" >
			  <?php echo $showPrint['OBAT_SATUAN_KECIL']; ?></td-->
              <td width="85" align="right" >
			  <?php echo $showPrint['QTY']; ?></td>
              <!--td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['HARGA_SATUAN']; ?></td>
              <td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['SUB_TOTAL']; ?></td>
              <td class="tdisi"><?php echo $showPrint['EMBALAGE']; ?></td>
				<td class="tdisi"><?php echo $showPrint['JASA_RESEP']; ?></td>
				<td class="tdisi"><?php echo $showPrint['HARGA_TOTAL']; ?></td-->
            </tr>
            <? } ?>
           
            <tr>
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
              <td colspan="3" align="right" ><span class="style1">Harga Total</span>: <?php echo $showSingle['HARGA_TOTAL']; ?> </span></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:18px"><div align="left"><span style="font-size:14px">Kasir : <?php echo $showSingle['username']; ?></span></div></td>
            </tr>
<tr>
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
              <td colspan="3" align="right" style="padding-right:5px;font-size:18px"><div align="left"><span style="font-size:14px; "><em>Bukti pembayaran ini juga berlaku sebagai kwitansi</em></span></div></td>
          </tr>
          </table></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >: </td>
          </tr>
        </table>
		
	  
        </td>
      </tr>
	  
  </table>
</div>


<?php
include("../sesi.php");

$iduser = $_SESSION["iduser"];

include("../koneksi/konek.php");
$idunit=$_GET["sunit"];

$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
$rsu=mysqli_query($konek,$u);
$row=mysqli_fetch_array($rsu);
$apname=$row['UNIT_NAME'];
?>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</script>
<style type="text/css">
<!--
body{
margin-left:0;
}
.style1 {
font-family: "Courier New", Courier, monospace;
font-size:12px;}
.style2 {
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
  <table width="550" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
    <tr class="style1"> 
      <td height="45" colspan="3" class="style1" style="font-size:16px"><b><?=$namaRS;?><br>
        <?=$alamatRS;?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $apname; ?></b> 
        <hr size="1" color="#000000"></td>
    </tr>
    <tr> 
      <td width="168">No. Kwitansi </td>
      <td width="382" colspan="2">: <?php echo $_REQUEST['no_kwitansi']; ?></td>
    </tr>
    <tr> 
      <td width="168">Tanggal</td>
      <td colspan="2">: <?php echo $_REQUEST['tgltrans']; ?></td>
    </tr>
    <tr> 
      <td>No. Resep</td>
      <td colspan="2">: <?php echo $_REQUEST['no_resep']; ?></td>
    </tr>
    <tr > 
      <td>No Rekam Medis</td>
      <td colspan="2">: <?php echo $_REQUEST['no_rm']; ?></td>
    </tr>
    <tr> 
      <td >Nama Pasien </td>
      <td colspan="2" >: <?php echo $_REQUEST['nama_pasien']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td >Alamat</td>
      <td colspan="2" >: <?php echo $_REQUEST['alamat']; ?>&nbsp;</td>
    </tr>
    <tr> 
      <td >Jenis Pasien</td>
      <?php
	  $sKep="select NAMA from a_kepemilikan where ID=".$_REQUEST['jenis_pasien'];
	  $qKep=mysqli_query($konek,$sKep);
	  $rwKep=mysqli_fetch_array($qKep);
	  
	  $sKso="select NAMA from a_mitra where IDMITRA=".$_REQUEST['kso'];
	  $qKso=mysqli_query($konek,$sKso);
	  $rwKso=mysqli_fetch_array($qKso);
	  ?>
      <td colspan="2" >: <?php echo $rwKep['NAMA']." / ".$rwKso['NAMA']; ?></td>
    </tr>
    <tr> 
      <td >Dokter</td>
      <td colspan="2" >: <?php echo $_REQUEST['dokter']; ?></td>
    </tr>
    <tr> 
      <td >Poli</td>
      <?php
	  $sPoli="select UNIT_NAME from a_unit where UNIT_ID=".$_REQUEST['poli'];
	  $qPoli=mysqli_query($konek,$sPoli);
	  $rwPoli=mysqli_fetch_array($qPoli);
	  ?>
      <td colspan="2" >: <?php echo $rwPoli['UNIT_NAME']; ?></td>
    </tr>
    <tr> 
      <td >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" ><table width="550" border="0" cellpadding="0" cellspacing="0" align="left">
          <?php 
		    $fdata=$_REQUEST['fdata'];
			$ftemp=explode(chr(5),$fdata);
			
			$htot=0;
			for($i=0;$i<count($ftemp);$i++){
				$arData=explode(chr(3),$ftemp[$i]);
				if($arData[0]==''){
					$id_obat=0;
					$kep=0;	
				}
				else{
					$id_obat=$arData[0];
					$kep=$arData[1];
				}
				$qty=$arData[2];
				
				$sql="SELECT 
  ao.OBAT_NAMA,
  ah.HARGA_BELI_SATUAN,
  ah.HARGA_JUAL_SATUAN 
FROM
  a_obat ao 
  INNER JOIN a_harga ah 
    ON ao.OBAT_ID = ah.OBAT_ID 
WHERE ah.OBAT_ID = $id_obat 
  AND ah.KEPEMILIKAN_ID = $kep";
  				$queri=mysqli_query($konek,$sql);
				$row=mysqli_fetch_array($queri);
			?>
          <tr> 
            <td width="36" align="center" class="style1"><?php echo ($i+1); ?></td>
            <td width="382" class="style1"><?php echo $row['OBAT_NAMA']; ?></td>
            <td width="35" align="center" class="style1"><?php echo $qty; ?></td>
            <!--td width="50" align="right" class="style1"><?php echo number_format($row['HARGA_JUAL_SATUAN'],0,',','.'); ?></td-->
            <td align="right" class="style1" <?php if ($i>$k){?>style="border-bottom:1px dashed #999999"<?php }?>><?php echo number_format(floor($row['HARGA_JUAL_SATUAN'])*$qty,0,',','.'); ?>&nbsp;&nbsp;</td>
            <?php
			$htot=$htot+floor($row['HARGA_JUAL_SATUAN'])*$qty;
			?>
          </tr>
          <? } ?>
          <tr align="right"> 
            <td colspan="3" class="style2" style="padding-right:5px;">Nilai Total :</td>
            <td class="style2" style="padding-right:10px;"><?php echo number_format($htot,0,",","."); ?></td>
          </tr>
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
	  $bilangan= $htot;
	  $bilangan=terbilang($bilangan,3);
	  
	  //=====Bilangan setelah koma=====
	  $sakKomane=explode(".",$htot);
	  $koma=$sakKomane[1];
	  $koma=terbilang($koma,3);
	  if($sakKomane[1]<>"") $koma= "Koma ".$koma."&nbsp;";
      ?>
      <?php
	  	if ($ada_retur>0){
			if ($iduser_jual!=""){
				$sql_ret= "SELECT SUM(FLOOR(QTY_RETUR*HARGA_SATUAN*(100-BIAYA_RETUR)/100)) as nretur from a_penjualan where NO_PENJUALAN='$no_penjualan' and UNIT_ID=$idunit and NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual";
			}else{
				$sql_ret= "SELECT SUM(FLOOR(QTY_RETUR*HARGA_SATUAN*(100-BIAYA_RETUR)/100)) as nretur from a_penjualan where NO_PENJUALAN='$no_penjualan' and UNIT_ID=$idunit and NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl'";
			}
			//echo $sql_ret;
			$rs_ret=mysqli_query($konek,$sql_ret);
			$rows_ret=mysqli_fetch_array($rs_ret);
			$nretur=$rows_ret['nretur'];
			$stot=$htot-$nretur;		
       ?>
          <?php
			  //$bilangan2= $rows_ret['SUM(QTY_RETUR*HARGA_SATUAN)'];
			  $bilangan2=terbilang($stot,3);
			  
			  //=====Bilangan setelah koma=====
			  $sakKomane2=explode(".",$stot);
			  $koma2=$sakKomane2[1];
			  $koma2=terbilang($koma2,3);
			  if($sakKomane2[1]<>"") $koma2= "Koma ".$koma2."&nbsp;";
		  }else{
		  		$bilangan2=$bilangan;
				$koma2=$koma;
		  }
		  ?>
          <tr> 
            <td colspan="4" align="left" class="style1">&nbsp;</td>
          </tr>
          <tr align="left"> 
            <td colspan="4" class="style1" style="padding-right:5px; border-bottom:1px dashed #999999"><?php echo $bilangan2." Rupiah";?></td>
          </tr>
          <tr> 
            <td colspan="4" align="right" class="style1" style="padding-right:5px;text-align:left">Kasir 
              : <?php echo $showSingle['username']; ?></td>
          </tr>
          <tr> 
            <td colspan="4" align="left" style="padding-right:5px;font-size:18px"><div align="left"><span style="font-size:14px; "><em>Bukti 
                pembayaran ini juga berlaku sebagai kwitansi</em></span></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
<div id="btn">
<br>
<table width="550" align="left">
<tr>
	<td width="50%" align="left">
		<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();window.close();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak Kwitansi</BUTTON>
	</td>
	<td width="50%" align="right">
		<BUTTON type="button" style="display:<?php if ($viewdel=="true") echo "block"; else echo "none";?>" onClick="if (confirm('Yakin Ingin Menghapus Data Penjualan ?')){this.disabled=true;location='../transaksi/hapus_penjualan.php?no_jual=<?php echo $njual; ?>&no_pasien=<?php echo $no_pasien; ?>&idunit=<?php echo $idunit; ?>&tgl=<?php echo $tgl; ?>&iduser=<?php echo $iduser; ?>&iduser_jual=<?php echo $iduser_jual; ?>';}"><IMG SRC="../icon/hapus.gif" border="0" width="16" height="16" ALIGN="absmiddle">Delete</BUTTON>
	</td>
</tr>
</table>
</div>
</body>
</html>

<?php
include("../sesi.php");

$iduser = $_SESSION["iduser"];
$iduser_jual = $_REQUEST["iduser_jual"];

include("../koneksi/konek.php");
$idunit=$_GET["sunit"];
//echo $idunit;
$no_penjualan=$_GET['no_penjualan'];
//echo $no_penjualan;
$no_pasien=$_GET['no_pasien'];
$viewdel=$_GET['viewdel'];
//echo "zxczczcz=".$iduser;
if ($iduser!=133 && $iduser!=225 && $iduser!=226) $viewdel="false";
//if ($iduser!=7) $viewdel="false";
$tgl=$_GET['tgl'];
$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
//echo $u;
$rsu=mysqli_query($konek,$u);
$row=mysqli_fetch_array($rsu);
$apname=$row['UNIT_NAME'];
if ($iduser_jual!=""){
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$iduser_jual";
}else{
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$ada_retur=mysqli_num_rows($rs);
$retur='';
if ($rows=mysqli_fetch_array($rs)){
	$retur=$rows['NO_RETUR'];
	$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
}
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
	<?php
	//if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	if ($iduser_jual!=""){
		$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual";
	}else{
		$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl'";
	}
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	//$retur=$showSingle['NO_RETUR'];
	$qty_retur=$showSingle['QTY_RETUR'];
	$htot=(int)$showSingle['HARGA_TOTAL'];
	$njual=$showSingle['NO_PENJUALAN'];
	//system("/usr/bin/lpr penjualan.php")
	
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <!--table width="421" border="0" class="style1">
      <tr>
        <td width="429"-->
		
  <table width="550" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
    <tr class="style1"> 
      <td height="45" colspan="3" class="style1" style="font-size:16px"><b><?=$namaRS;?><br>
        <?=$alamatRS;?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $apname; ?></b> 
        <hr size="1" color="#000000"></td>
    </tr>
    <tr> 
      <td width="168">No. Kwitansi </td>
      <td width="382" colspan="2">: <?php echo $showSingle['NO_PENJUALAN']; ?><?php if ($ada_retur>0){?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<? echo $retur; ?><?php }?></td>
    </tr>
    <tr> 
      <td width="168">Tanggal</td>
      <td colspan="2">: <?php echo date("d/m/Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT'])); if ($ada_retur>0){echo "  -  ".$tglretur;} ?></td>
    </tr>
    <tr> 
      <td>No. Resep</td>
      <td colspan="2">: <?php echo $showSingle['NO_RESEP']; ?></td>
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
      <td >Alamat</td>
      <td colspan="2" >: <?php echo $showSingle['ALAMAT']; ?>&nbsp;</td>
    </tr>
    <tr> 
      <td >Jenis Pasien</td>
      <td colspan="2" >: <?php echo $showSingle['NAMA']." / ".$showSingle['kso_nama']; ?></td>
    </tr>
    <tr> 
      <td >Dokter</td>
      <td colspan="2" >: <?php echo $showSingle['DOKTER']; ?></td>
    </tr>
    <tr> 
      <td >Poli</td>
      <td colspan="2" >: <?php echo $showSingle['UNIT_NAME']; ?></td>
    </tr>
    <tr> 
      <td >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" ><table width="550" border="0" cellpadding="0" cellspacing="0" align="left">
          <?php 
		  	if ($iduser_jual!=""){
				$sqlPrint="SELECT NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,SUM(SUB_TOTAL) SUB_TOTAL,SUM(a_penjualan.QTY) AS QTY,SUM(a_penjualan.QTY_JUAL) AS QTY_JUAL,SUM(a_penjualan.QTY_RETUR) AS QTY_RETUR FROM a_penjualan INNER JOIN a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID INNER JOIN a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' AND a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual GROUP BY NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ORDER BY a_penjualan.ID";
			}else{
				$sqlPrint="SELECT NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,SUM(SUB_TOTAL) SUB_TOTAL,SUM(a_penjualan.QTY) AS QTY,SUM(a_penjualan.QTY_JUAL) AS QTY_JUAL,SUM(a_penjualan.QTY_RETUR) AS QTY_RETUR FROM a_penjualan INNER JOIN a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID INNER JOIN a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' AND UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' GROUP BY NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ORDER BY a_penjualan.ID";
			}
			//echo $sqlPrint;
			$exePrint=mysqli_query($konek,$sqlPrint);
			$k=mysqli_num_rows($exePrint);
			$i=1;
			while($showPrint=mysqli_fetch_array($exePrint))
			{
			?>
			<?php if ($ada_retur>0){?>
          <tr> 
            <td width="36" align="center" class="style1"><?php echo $i++; ?></td>
            <td width="300" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?></td>
            <td width="90" align="left" class="style1" <?php if ($i>$k){?>style="border-bottom:0px dashed #999999"<?php }?>><?php echo $showPrint['QTY_JUAL']; ?>&nbsp;-&nbsp;<?php echo $showPrint['QTY_RETUR']; ?>&nbsp;= <?php echo $showPrint['QTY']; ?></td>
            <!--td align="right" class="style1"><?php echo number_format($showPrint['HARGA_SATUAN'],0,',','.'); ?></td-->
            <?php
			$jTot = floor($showPrint['QTY_JUAL'] * $showPrint['HARGA_SATUAN']);
			?>
            <td align="right" class="style1" <?php if ($i>$k){?>style="border-bottom:1px dashed #999999"<?php }?>><?php echo number_format($jTot,0,',','.'); ?>&nbsp;&nbsp;</td>
          </tr>
		  <?php }else{?>
          <tr> 
            <td width="36" align="center" class="style1"><?php echo $i++ ?></td>
            <td width="382" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?></td>
            <td width="35" align="center" class="style1"><?php echo $showPrint['QTY_JUAL']; ?></td>
            <!--td width="50" align="right" class="style1"><?php echo number_format($showPrint['HARGA_SATUAN'],0,',','.'); ?></td-->
            <td align="right" class="style1" <?php if ($i>$k){?>style="border-bottom:1px dashed #999999"<?php }?>><?php echo number_format(floor($showPrint['SUB_TOTAL']),0,',','.'); ?>&nbsp;&nbsp;</td>
          </tr>
		  <?php }?>
          <? } ?>
          <tr align="right"> 
            <td colspan="3" class="style2" style="padding-right:5px;"><?php if ($ada_retur>0){?>Nilai Awal :<?php }else{?>Nilai Total :<?php }?></td>
            <td class="style2" style="padding-right:10px;"><?php echo number_format($htot,0,",","."); ?></td>
          </tr>
          <tr align="right"> 
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
            <td colspan="3" class="style2" style="padding-right:5px;">Nilai Retur :</td>
            <td class="style2" style="padding-right:10px;"><?php echo number_format($nretur,0,",","."); ?></td>
          </tr>
          <tr align="right"> 
            <td colspan="3" class="style2" style="padding-right:5px;">Sub Total :</td>
            <td class="style2" style="padding-right:10px;"><?php echo number_format($stot,0,",","."); ?></td>
          </tr>
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
            <td colspan="4" class="style1" style="padding-right:5px; border-bottom:1px dashed #999999"><?php echo $bilangan2."&nbsp;".$koma2."Rupiah";?></td>
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

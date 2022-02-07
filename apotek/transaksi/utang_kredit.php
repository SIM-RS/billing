<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));

$th=explode("-",$tglSkrg);
$tgl5=$th[2]."-".$th[1]."-".$th[0];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_penjualan=$_REQUEST['no_penjualan'];
$no_pasien=$_REQUEST['no_pasien'];
$sunit=$_REQUEST['sunit'];
$iuser=$_REQUEST['iuser'];
$ishift=$_REQUEST['ishift'];
$bayar=str_replace(".","",$_REQUEST['bayar']);
$tgl=$_REQUEST['tgl'];
$sql="SELECT DISTINCT NAMA_PASIEN,UTANG,HARGA_TOTAL FROM a_penjualan WHERE UNIT_ID=$sunit AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$sisa_utang=0;
if ($rows=mysqli_fetch_array($rs)){
	$nama_pasien=$rows['NAMA_PASIEN'];
	$sisa_utang=$rows['UTANG'];
	$tbiaya=$rows['HARGA_TOTAL'];
}
//====================================================================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

switch ($act){
	case "save":
		$tsisa_utang=str_replace(".","",$_REQUEST['sisa']);
		$sisa_akhir=(int)$tsisa_utang - (int)$bayar;
		$sql="insert into a_kredit_utang (UNIT_ID, USER_ID, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG) values ($sunit,$iuser,'$tgl_act','$no_penjualan', $bayar)";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		if ($sisa_akhir<=0){
			$sql="UPDATE a_penjualan SET TGL='$tgl5',CARA_BAYAR=1,SHIFT=$ishift, UTANG=0 WHERE UNIT_ID=$sunit AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
		}else{
			$sql="UPDATE a_penjualan SET UTANG=UTANG-$bayar WHERE UNIT_ID=$sunit AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
		}
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html> 
<head>
<title>Angsuran Pembayaran Resep</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<style type="text/css">
.style1 { font-family: "Courier New", Courier, monospace; font-size:14px; }
</style>
	<?php if($act=="save"){?>
	
<p align="center"> <b>Data Angsuran Pembayaran Resep Dengan No Penjualan <?php echo $no_penjualan; ?> 
  Sudah DiSimpan</b><br>
  <br>
<BUTTON type="button" onClick="window.close();"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tutup&nbsp;</BUTTON>
</p>
<?php 
//==Jika Dalam keadaan Disimpan berakhir===	
}else{
?>
<div align="center"> 
  <div id="input" style="display:block">
      
    <p class="jdltable">Angsuran Pembayaran Resep</p>
	  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="sunit" id="sunit" type="hidden" value="<?php echo $sunit; ?>">
	<input name="tgl" id="tgl" type="hidden" value="<?php echo $tgl; ?>">
	<input name="iuser" id="iuser" type="hidden" value="<?php echo $iuser; ?>">
      <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="151">Nama Pasien</td>
          <td width="12">:</td>
          <td><input name="nama_pasien" size="50" id="nama_pasien" value="<?php echo $nama_pasien; ?>" class="txtinput" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">No. Rekam Medis </td>
          <td>:</td>
          <td > <input name="no_pasien" type="text" class="txtinput" id="no_pasien" value="<?php echo $no_pasien; ?>" size="10" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">No Penjualan </td>
          <td>:</td>
          <td ><input name="no_penjualan" id="no_penjualan" value="<?php echo $no_penjualan; ?>" class="txtinput" size="10" type="text" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">Total Biaya </td>
          <td>:</td>
          <td ><input name="tbiaya" id="tbiaya" value="<?php echo number_format($tbiaya,0,",","."); ?>" class="txtright" size="10" type="text" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">Total Dibayar</td>
          <td>:</td>
          <td ><input name="tbayar" id="tbayar" value="<?php echo number_format(($tbiaya-$sisa_utang),0,",","."); ?>" class="txtright" size="10" type="text" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">Sisa Tagihan </td>
          <td>:</td>
          <td ><input name="sisa" id="sisa" value="<?php echo number_format($sisa_utang,0,",","."); ?>" class="txtright" size="10" type="text" readonly="true"></td>
        </tr>
        <tr> 
          <td height="25">Bayar Tagihan </td>
          <td>:</td>
          <td ><input name="bayar" id="bayar" value="<?php echo $sisa_utang; ?>" class="txtright" size="10" type="text"></td>
        </tr>
      </table>
	  <p align="center"> <span class="jdltable">Data Pembayaran Resep</span> 
      <table id="tblRetur" width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="headtable"> 
          <td width="40" class="tblheaderkiri" id="TGL" onClick="ifPop.CallFr(this);">No</td>
          <td width="120" height="25" class="tblheader" id="TGL" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td class="tblheader" id="NO_PENJUALAN" onClick="ifPop.CallFr(this);">No. 
            Penjualan </td>
          <td width="100" class="tblheader" id="QTY_JUAL" onClick="ifPop.CallFr(this);">Jml 
            Dibayar</td>
        </tr>
        <?php
		   $sql="SELECT * FROM a_kredit_utang WHERE UNIT_ID=$sunit AND FK_NO_PENJUALAN='$no_penjualan' ORDER BY ID"; 
		   //echo $sql;
		   $exe=mysqli_query($konek,$sql);
		   $i=0;$htgtot=0;
		   while ($show=mysqli_fetch_array($exe)){
		   	$i++;
           ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo date("d/m/Y H:i",strtotime($show['TGL_BAYAR'])); ?></td>
          <td class="tdisi"><?php echo $no_penjualan; ?></td>
          <td class="tdisi" align="right" style="padding-right:5px;">&nbsp;<?php echo number_format($show['BAYAR_UTANG'],0,",","."); ?></td>
        </tr>
        <? 
			$htgtot=$htgtot+($show['BAYAR_UTANG']);
			//echo "<br>".$hartot."<br>";
			}
			?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" colspan="3" align="right" style="padding-right:5px;"> 
            <b>Total Dibayar</b> 
          </td>
		  <td class="tdisi" align="right" style="padding-right:5px;">&nbsp;<?php echo number_format($htgtot,0,",","."); ?></td>
        </tr>
      </table>
	  </p>
      <p align="center">
        <BUTTON type="button" onClick="if(ValidateForm('bayar','ind')){document.form1.submit();}"<?php if ($sisa_utang<=0) echo " disabled";?>><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan&nbsp;</BUTTON>
         <BUTTON type="reset" onClick="window.close();"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
    </form>
  </div>
</div>
<?php } ?>
</body>
</html>
<?php 
mysqli_close($konek);
?>
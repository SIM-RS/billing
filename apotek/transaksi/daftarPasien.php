<?php 
include("../sesi.php");
include("../koneksi/konekMssql.php");

//==========Request============
$NoRM=$_REQUEST['NoRM']; if($NoRM=="") $NoRM=XXX;
/*====antisipasi jika tidak memasukkan No. Reka medik maka tampilkan semuanya===
if($NoRM<>""){
$NoRM1="where NoRM='$NoRM'";
$NoRM2="where KodePasien='$NoRM'";
}
*/
$defaultsort="TglMulai desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

//=======Request Selesai=============
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
$par=$_REQUEST['par'];
$par=explode("*",$par);

//$qryTMPasien="SELECT * FROM TMPasien $NoRM1";
$qryTMPasien="SELECT * FROM TMPasien where NoRM='$NoRM'";
//echo $qryTMPasien;
$rsTMPasien=mssql_query($qryTMPasien);
$rowsTMPasien=mssql_fetch_array($rsTMPasien);
$vnama=$rowsTMPasien['Nama'];
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
	<form name="form1" method="post" action="">
		<input name="act" id="act" type="hidden">
		<input name="page" id="page" type="hidden" value="">
    	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
   		<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	</form>
<table width="610" border="0" align="center">
  <tr>
    <td align="center"><b>Daftar Kunjungan dengan No.Rekam Medik <?php echo $NoRM;?></b></td>
  </tr>
  <tr>
    <td align="center"><b>Nama Pasien: <i>"<?php if($vnama=="") echo '<b>Tidak Terdata</b>';else echo $vnama;?>"</i></b></td>
  </tr>
</table>

<table width="913" border="0" align="center" cellpadding="1" cellspacing="0">
  <tr class="headtable"> 
  	<td width="26" class="tblheaderkiri">No.</td>
	<td width="162" id="KodeKunjungan" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kunj </td>
    <td width="179" class="tblheader">Tgl Mulai </td>
    <td width="143" class="tblheader">Tgl Selesai </td>
    <td width="80" class="tblheader">Biaya </td>
    <td width="165" id="KodeTempatLayanan" class="tblheader" onClick="ifPop.CallFr(this);">Kode Tempat Layanan </td>
    <td width="176" id="KodeTindakan" class="tblheader" onClick="ifPop.CallFr(this);">Kode Tindakan </td>
    <td width="50" id="KodeTindakan" class="tblheader" onClick="ifPop.CallFr(this);">Proses </td>
  </tr>
  <?php
  	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		//$sqlKunj="SELECT * FROM TransKunjungan ".$NoRM2.$filter." ORDER BY ".$sorting;
		$sqlKunj="SELECT * FROM TransKunjungan where KodePasien='$NoRM'".$filter." ORDER BY ".$sorting;
		//echo $sqlKunj;
		$rsKunj=mssql_query($sqlKunj);
		while($rowsKunj=mssql_fetch_array($rsKunj)){
		$i++;
		$arfvalue="javascript:fSetValue(window.opener,'".$par[0]."*-*".$vnama."*|*".$par[1]."*-*".$rowsKunj['KodeKunjungan']."');window.close();";
	?>
   <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" style="cursor:pointer" onClick="<?php echo $arfvalue; ?>">
  	<td class="tdisikiri">&nbsp;<?php echo $i;?></td>
    <td class="tdisi">&nbsp;<?php echo $rowsKunj['KodeKunjungan'];?></td>
    <td class="tdisi">&nbsp;<?php echo date("d/m/Y->H:i",strtotime($rowsKunj['TglMulai'])); ?></td>
    <td class="tdisi">&nbsp;<?php echo date("d/m/Y->H:i",strtotime($rowsKunj['TglSelesai'])); ?></td>
    <td class="tdisi">&nbsp;<?php echo $rowsKunj['Biaya'];?></td>
    <td class="tdisi">&nbsp;<?php echo $rowsKunj['KodeTempatLayanan'];?></td>
    <td class="tdisi" >&nbsp;<?php echo $rowsKunj['KodeTindakan'];?></td>
    <td class="tdisi"><img src="../icon/find.png" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Memilih" onClick="<?php echo $arfvalue; ?>"></td>
  </tr>
  <?php }?>
</table>
<?php if($vnama=="") {?>
<table width="200" border="0" align="center">
  <tr>
    <td align="center"><BUTTON type="button" onClick="javascript:window.close();"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tutup&nbsp;</BUTTON></td>
  </tr>
</table>
<?php } ?>
</body>
</html>

<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kdGolongan=$_REQUEST["kdGolongan"];
$nmGolongan=$_REQUEST["nmGolongan"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="golongan desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi

convert_var($kdGolongan,$nmGolongan,$page,$sorting,$filter);
convert_var($act);
//echo $act;

switch ($act){
	case "save":
		$sql="insert into a_obat_golongan(kode,golongan) values('$kdGolongan','$nmGolongan')";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
		$sql="update a_obat_golongan set golongan='$nmGolongan', kode='$kdGolongan' where kode='$kdGolongan'";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_obat_golongan where kode='$kdGolongan'";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
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
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Golongan </p>
    <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
      <td>Kode </td>
      	<td>:</td>
        <td ><input name="kdGolongan" type="text" id="kdGolongan" class="txtinput" size="25" ></td>
    </tr>
    <tr>
      <td>Nama Golongan </td>
      	<td>:</td>
        <td ><input name="nmGolongan" type="text" id="nmGolongan" class="txtinput" size="25" ></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('nmGolongan','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR GOLONGAN </span>
  <table width="71%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*nmGolongan*-**|*kdGolongan*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>		  </td>
	    </tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td width="64" class="tblheaderkiri">No</td>
        <td id="kode" width="64" class="tblheader" onClick="ifPop.CallFr(this);">Kode </td>
        <td id="golongan" width="428" class="tblheader" onClick="ifPop.CallFr(this);">Nama Golongan </td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * from a_obat_golongan".$filter." ORDER BY ".$sorting;
	 //echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){		
	  	$i++;		
		$arfvalue="act*-*edit*|*nmGolongan*-*".$rows['golongan']."*|*kdGolongan*-*".$rows['kode'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*kdGolongan*-*".$rows['kode']."*|*nmGolongan*-*".$rows['golongan'];

	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisikiri"><?php echo $rows['kode']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['golongan']; ?></td>
        <td width="100" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="100" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="2" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();"></td>
		<td width="0"></td>
      </tr>
    </table>
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
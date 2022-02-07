<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$pabrik_id=$_REQUEST['pabrik_id'];
$pabrik_id=mysqli_real_escape_string($konek,$_REQUEST['pabrik_id']);
//$kode_pabrik=$_REQUEST['kode_pabrik'];
$kode_pabrik=mysqli_real_escape_string($konek,$_REQUEST['kode_pabrik']);
//$pabrik=$_REQUEST['pabrik'];
$pabrik=mysqli_real_escape_string($konek,$_REQUEST['pabrik']);
//$isaktif=$_REQUEST['isaktif'];
$isaktif=mysqli_real_escape_string($konek,$_REQUEST['isaktif']);
//====================================================================

//Set Status Aktif atau Tidak====
//$status=$_REQUEST['status'];
$status=mysqli_real_escape_string($konek,$_REQUEST['status']);
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$defaultsort="PABRIK_ID desc";
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST['act']);
//echo $act;

switch ($act){
	case "save":
			$sql="insert into a_pabrik(PABRIK_ID,KODE_PABRIK,PABRIK,ISAKTIF) values('','$kode_pabrik','$pabrik',$isaktif)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			$sql="update a_pabrik set KODE_PABRIK='$kode_pabrik',PABRIK='$pabrik',ISAKTIF=$isaktif where PABRIK_ID=$pabrik_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_pabrik where PABRIK_ID=$pabrik_id";
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
  <input name="pabrik_id" id="pabrik_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Principle</p>
    <table width="75%" border="0" cellpadding="1" cellspacing="1" class="txtinput">
    <tr>
      <td>Kode Principle</td>
      	<td>:</td>
        <td ><input name="kode_pabrik" type="text" id="kode_pabrik" class="txtinput" size="25" ></td>
    </tr>
	<tr>
      <td>Nama Principle</td>
      	<td>:</td>
        <td ><input name="pabrik" type="text" id="pabrik" class="txtinput" size="25" ></td>
    </tr>
	<tr>  
      <td>Status</td>
      <td>:</td>
          <td><select name="isaktif" id="isaktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_pabrik,pabrik','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR PRINCIPLE </span>
  <table width="67%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="262" style="font:bold 12px tahoma;">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/pabrik&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
		  </td>
          <td width="485" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block';fSetValue(window,'act*-*save*|*kode_pabrik*-**|*pabrik*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td id="PABRIK_ID" width="62" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="KODE_PABRIK" width="155" class="tblheader" onClick="ifPop.CallFr(this);">Kode Principle</td>
        <td id="PABRIK" width="355" class="tblheader" onClick="ifPop.CallFr(this);">Nama Principle</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * FROM a_pabrik where isaktif=$status".$filter." ORDER BY ".$sorting;
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
		$arfvalue="act*-*edit*|*pabrik_id*-*".$rows['PABRIK_ID']."*|*kode_pabrik*-*".$rows['KODE_PABRIK']."*|*pabrik*-*".$rows['PABRIK'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*pabrik_id*-*".$rows['PABRIK_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['KODE_PABRIK']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['PABRIK']; ?></td>
        <td width="27" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="38" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
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
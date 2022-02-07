<?php 
// Koneksi =================================
include("../sesi.php");
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$unit_id=mysqli_real_escape_string($konek,$_REQUEST['unit_id']);
$unit_name=mysqli_real_escape_string($konek,$_REQUEST['unit_name']);
$unit_tipe=mysqli_real_escape_string($konek,$_REQUEST['unit_tipe']);
$unit_so=mysqli_real_escape_string($konek,$_REQUEST['unit_so']);
$unit_isaktif=mysqli_real_escape_string($konek,$_REQUEST['unit_isaktif']);
//====================================================================

//Set Status Aktif atau Tidak====
$status=mysqli_real_escape_string($konek,$_REQUEST['status']);
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=mysqli_real_escape_string($konek,$_REQUEST["page"]);
$defaultsort="UNIT_ID ASC";
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=mysqli_real_escape_string($konek,$_REQUEST['act']); // Jenis Aksi
//echo $act;

switch ($act){
	#kdunitfar
	case "save":
			$sql="insert into a_unit(UNIT_ID,UNIT_NAME,UNIT_TIPE,UNIT_ISAKTIF,unit_so) values('','$unit_name',$unit_tipe,$unit_isaktif,$unit_so)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			// $sql="update a_unit set UNIT_NAME='$unit_name',UNIT_TIPE='$unit_tipe',UNIT_ISAKTIF=$unit_isaktif,unit_so=$unit_so where UNIT_ID=$unit_id";
			$sql = "update $dbbilling.b_ms_unit set unit_so = '{$unit_so}' where id = '{$unit_id}'";
			// echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_unit where UNIT_ID=$unit_id";
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
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none" align="center">
      <p class="jdltable">Input Data Unit</p>
    <table width="40%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
      <td width="150">Nama Unit</td>
      	<td>:</td>
        <td ><input name="unit_name" type="text" id="unit_name" class="txtinput" size="25" readonly ></td>
    </tr>
     <tr>
      <td>Tipe Unit</td>
      <td>:</td>
		  <td>
		  <select name="unit_tipe" id="unit_tipe" class="txtinput" onChange="showON()" disabled >
		  <?
		  $qry="Select * from a_tipe";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
		  <option value="<?=$show[TIPE_ID];?>" class="txtinput"><?=$show[TIPE];?></option>
		  <? }?>
		  </select>
		  </td>
	</tr>
	<tr id="stokopname">  
      <td>Boleh Stok Opname</td>
      <td>:</td>
          <td><select name="unit_so" id="unit_so" class="txtinput">
              <option value="1">Boleh</option>
              <option value="0">Tidak</option>
            </select></td>
    </tr>
	<tr>  
      <td>Status</td>
      <td>:</td>
          <td><select name="unit_isaktif" id="unit_isaktif" class="txtinput" disabled >
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('unit_name','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR UNIT</span>
  <table width="67%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="364" align="left">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/unit&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
		  </td>
          <td width="353" align="right">
		  <!--BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*unit_name*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->
		  </td>
	    </tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td id="UNIT_ID" width="62" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="UNIT_NAME" width="455" class="tblheader" onClick="ifPop.CallFr(this);">Nama Unit </td>
        <td id="TIPE" width="145" class="tblheader" onClick="ifPop.CallFr(this);">Tipe</td>
        <td class="tblheader" colspan="1">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT a_unit.*,a_tipe.TIPE FROM a_unit Inner Join a_tipe ON a_unit.UNIT_TIPE = a_tipe.TIPE_ID where unit_isaktif=$status".$filter."  ORDER BY ".$sorting;
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
		$arfvalue="act*-*edit*|*unit_id*-*".$rows['UNIT_ID']."*|*unit_name*-*".$rows['UNIT_NAME']."*|*unit_tipe*-*".$rows['UNIT_TIPE']."*|*unit_so*-*".$rows['unit_so'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*unit_id*-*".$rows['UNIT_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['UNIT_NAME']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['TIPE']; ?></td>
        <td width="27" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');showON()"></td>
        <!--td width="38" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td-->
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
<script type="text/javascript">
	function showON(){
		if(unit_tipe.value == 1 || unit_tipe.value == 2 || unit_tipe.value == 5 || unit_tipe.value == 6){
			document.getElementById('stokopname').style.display = "table-row";
		} else {
			document.getElementById('stokopname').style.display = "none";
		}
		//alert(unit_tipe.value);
	}
	showON();
</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
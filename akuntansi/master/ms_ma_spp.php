<?php 
include("../koneksi/konek.php");
//echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";echo $_SERVER['QUERY_STRING'];
$qstr_ma="par=parent*kode_ma2*mainduk*parent_lvl";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$idma=$_REQUEST['idma'];
$jenis=$_REQUEST['jenis'];
$kode_ma=$_REQUEST['kode_ma'];
$ma=$_REQUEST['ma'];
$aktif=$_REQUEST['aktif'];
if ($aktif=="") $aktif=1;
$kode_ma2=$_REQUEST['kode_ma2'];
if ($kode_ma2==""){
	$parent=0;
	$parent_lvl=0;
}else{
	$parent=$_REQUEST['parent'];
	if ($parent=="") $parent=0;
	$parent_lvl=$_REQUEST['parent_lvl'];
	if ($parent_lvl=="") $parent_lvl=0;
	$kode_ma=$kode_ma2.$kode_ma;
}

$lvl=$parent_lvl+1;

$page=$_REQUEST["page"];
$defaultsort="MA_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from ma where MA_KODE='$kode_ma' and MA_AKTIF=1";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			
			echo "<script>alert('Kode Mata Anggaran Sudah Ada');</script>";
		}else{
			$sql="insert into ma(MA_KODE,MA_NAMA,MA_LEVEL,MA_PARENT,MA_PARENT_KODE,MA_JENIS,MA_AKTIF) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$jenis,$aktif)";
			//echo $sql;
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update ma set MA_ISLAST=0 where MA_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update ma set MA_KODE='$kode_ma',MA_NAMA='$ma',MA_LEVEL=$lvl,MA_PARENT=$parent,MA_PARENT_KODE='$kode_ma2',MA_JENIS=$jenis,MA_AKTIF=$aktif where MA_ID=$idma";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="select * from ma where ma_parent=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Mata Anggaran Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="delete from ma where MA_ID=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>Master Data Mata Anggaran</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
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
  <input name="idma" id="idma" type="hidden" value="">
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <input name="mainduk" id="mainduk" type="hidden" value="<?php echo $mainduk; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p>Input Data Mata Anggaran</p>
    <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
          <td width="50%">Jenis Mata Anggaran (MA)</td>
      	  <td width="2%">:</td>
          <td><select name="jenis" id="jenis">
              <option value="1">MAP</option>
              <option value="2" <?php if ($jenis=="2") echo "selected";?>>MAK</option>
            </select></td>
    </tr>
      <tr>
          <td>Kode Mata Anggaran (MA)</td>
      <td>:</td>
          <td><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="<?php echo $kode_ma2; ?>" readonly="true"> 
            <input type="button" name="Button222" value="..." title="Pilih Mata Anggaran Induk" onClick="OpenWnd('../master/tree_ma_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)">
            <input name="kode_ma" type="text" id="kode_ma" size="5" maxlength="6" style="text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*kode_ma*-**|*ma*-*')"></td>
    </tr>
    <tr>
      <td>Nama Mata Anggaran (MA)</td>
      <td>:</td>
      <td><textarea name="ma" cols="50" id="ma"></textarea></td>
    </tr>
    <tr>
      <td>Status</td>
      <td>:</td>
          <td><select name="aktif" id="select2">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_ma,ma','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <div id="listma" style="display:block">
  <p class="jdltable">Daftar Mata Anggaran
  	<table width="98%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="300">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td width="300" align="right"><BUTTON type="button" onClick="location='?f=../master/tree_ms_ma.php'"><IMG SRC="../images/tree_expand.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tree View</BUTTON>&nbsp;<BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
		</tr>
	</table>
    <table width="98%" border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td width="7%" class="tblheaderkiri">No</td>
        <td id="MA_KODE" width="17%" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
        <td id="MA_JENIS" width="17%" class="tblheader" onClick="ifPop.CallFr(this);">Jenis MA</td>
        <td id="MA_NAMA" width="70%" class="tblheader" onClick="ifPop.CallFr(this);">Nama Mata Anggaran </td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select row_number() over(order by ".$sorting.") as rownum, * from MA where MA_AKTIF=1".$filter;
	  $rs=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page="1";
  	$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$jmldata=mysql_num_rows($rs);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$pkode=$rows['MA_PARENT_KODE'];
		$mkode=$rows['MA_KODE'];
		if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		$arfvalue="act*-*edit*|*kode_ma2*-*".$pkode."*|*idma*-*".$rows['MA_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['MA_NAMA']."*|*parent_lvl*-*".($rows['MA_LEVEL']-1)."*|*parent*-*".$rows['MA_PARENT'];
	  	$arfhapus="act*-*delete*|*idma*-*".$rows['MA_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['MA_KODE']; ?></td>
        <td class="tdisi" align="center"><?php if ($rows['MA_JENIS']==1) echo "MAP"; else echo "MAK"; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['MA_NAMA']; ?></td>
        <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
    </table>
    </p>
	</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
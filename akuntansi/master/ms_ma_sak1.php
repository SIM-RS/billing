<?php 
include("../koneksi/konek.php");
//echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";echo $_SERVER['QUERY_STRING'];
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_INFO"]=$PATH_INFO;
$qstr_ma="par=kode_ma2*mainduk";
$qstr_ma_sak="par=parent*kode_ma_sak*mainduk2*parent_lvl";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$idma=$_REQUEST['idma'];
//$jenis=$_REQUEST['jenis'];
$jenis= '3';
$kode_ma=trim($_REQUEST['kode_ma']);
$ma=str_replace("\'","''",$_REQUEST['ma']);
$ma=str_replace('\"','"',$ma);
$ma=str_replace(chr(92).chr(92),chr(92),$ma);
//$fkunit=$_REQUEST['fkunit'];
$fkunit='0';
//$type=$_REQUEST['type'];
$type='0';
$fk_ma=$_REQUEST['kode_ma2'];
$aktif=$_REQUEST['aktif'];
if ($aktif=="") $aktif=1;
$status=$_REQUEST['status'];
if ($status=="") $status=1;
$kode_ma2=trim($_REQUEST['kode_ma_sak']);
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
//		$sql="select * from ma where MA_KODE='$kode_ma' and MA_MKODE='$kode_blu' and MA_TYPE=$type and MA_JENIS=$jenis and MA_UNIT=$fkunit and MA_AKTIF=$aktif";
		$sql="select * from ma_sak where MA_KODE='$kode_ma' and MA_TYPE=$type and MA_JENIS=$jenis and MA_UNIT=$fkunit and MA_AKTIF=$aktif";

		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Rekening Sudah Ada');</script>";
		}else{
			$sql="insert into ma_sak(MA_KODE,MA_NAMA,MA_LEVEL,MA_PARENT,MA_PARENT_KODE,MA_JENIS,MA_TYPE,MA_UNIT,MA_AKTIF,FK_MA) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$jenis,$type,$fkunit,$aktif,$fk_ma)";
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
		$sql="select * from ma_sak where MA_KODE='$kode_ma' and MA_TYPE=$type and MA_JENIS=$jenis and MA_NAMA='$ma' and MA_UNIT=$fkunit and MA_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Rekening Tersebut Sudah Ada');</script>";
		}else{
				$sql="update ma_sak set MA_KODE='$kode_ma',MA_NAMA='$ma',MA_JENIS=$jenis,MA_TYPE=$type,MA_UNIT=$fkunit,MA_AKTIF=$aktif, FK_MA=$fk_ma where MA_ID=$idma";
			//echo $sql;
			$rs=mysql_query($sql);
		}
		break;
	case "delete":
		$sql="select * from ma_sak where ma_parent=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Rekening Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="select * from jurnal where fk_sak=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)>0){
				echo "<script>alert('Kode Rekening Ini Sudah Pernah Digunakan Untuk Transaksi Jurnal, Jadi Tidak Boleh Dihapus');</script>";
			}else{
				$sql="delete from ma_sak where MA_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="select * from ma_sak where MA_PARENT=".$parent;
				$rs2=mysql_query($sql);
				if (mysql_num_rows($rs2)<=0){
					$sql="update ma_sak set MA_ISLAST=1 where MA_ID=".$parent;
					$rs2=mysql_query($sql);
				}
			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>Master Data Rekening</title>
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
  	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none" >
      <p class="jdltable">Input Data Rekening SAK</p>
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr>
          <td>Kode ID Master Rekening SAP</td>
          <td>:</td>
          <td valign="middle"><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view2.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*mainduk*-**|*kode_ma*-**|*ma*-**|*parent*-**')"></td>
        </tr>
        <tr> 
          <td>Nama Master Rekening SAP</td>
          <td>: </td>
          <td ><textarea name="mainduk" cols="50" rows="3" readonly class="txtinput" id="mainduk"><? echo $_POST[mainduk];?></textarea></td>
        </tr>

        <tr>
          <td>Kode Rekening Induk</td>
          <td>:</td>
          <td valign="middle"><input name="kode_ma_sak" type="text" id="kode_ma_sak" size="20" maxlength="20" style="text-align:center" value="<?=$kode_ma2; ?>" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view_sak.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma_sak*-**|*mainduk2*-**|*kode_ma*-**|*ma*-**|*parent*-**')"></td>
        </tr>
        <tr> 
          <td>Nama Rekening Induk</td>
          <td>: </td>
          <td ><textarea name="mainduk2" cols="50" rows="3" readonly class="txtinput" id="mainduk2"><? echo $_POST[mainduk2];?></textarea></td>
        </tr>
        <tr> 
          <td>Kode Rekening</td>
          <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="5" maxlength="6" class="txtinput" style="text-align:center"></td>
        </tr>
        <tr> 
          <td>Nama Rekening</td>
          <td>:</td>
          <td ><textarea name="ma" cols="50" rows="3" class="txtinput" id="ma"></textarea></td>
        </tr>
        <tr> 
          <td>Status</td>
          <td>:</td>
          <td>
		  	<select name="aktif" id="aktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
        </tr>
      </table>
      <p><BUTTON type="button" onClick="if (ValidateForm('kode_ma,ma','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR REKENING SAK </span>
  	<table width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="465">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/ms_ma_sak&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
			</td>
          <td width="460" align="right">
            <BUTTON type="button" onClick="location='?f=../master/tree_ms_ma_sak.php'"><IMG SRC="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tree View</BUTTON> <BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
	    </tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td width="76" class="tblheaderkiri">No</td>
        <td id="MA_KODE" width="162" class="tblheader" onClick="ifPop.CallFr(this);">Kode Rekening </td>
        <td id="MA_NAMA" width="584" class="tblheader" onClick="ifPop.CallFr(this);">Nama Rekening </td>
        <td class="tblheader" colspan="2" width="180">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, * from MA where MA_AKTIF=1".$filter;
	  $sql="SELECT * FROM ma_sak where ma_aktif=$status".$filter." ORDER BY ".$sorting;
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		
	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$pkode=trim($rows['MA_PARENT_KODE']);
		$mkode=trim($rows['MA_KODE']);

		if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 $sql="select * from ma where ma_id=".$rows['MA_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["MA_NAMA"]; else $c_mainduk="";
		 $arfvalue="act*-*edit*|*kode_ma_sak*-*".$pkode."*|*idma*-*".$rows['MA_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['MA_NAMA']."*|*parent_lvl*-*".($rows['MA_LEVEL']-1)."*|*parent*-*".$rows['MA_PARENT']."*|*mainduk2*-*".$c_mainduk."*|*aktif*-*".$rows['MA_AKTIF']."*|*kode_ma2*-*".$rows['FK_MA'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	$arfhapus="act*-*delete*|*idma*-*".$rows['MA_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['MA_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['MA_NAMA']; ?></td>
        <td width="90" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="90" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="1" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtinput" size="1">
		  <button type="button" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></td>
		<td colspan="2" align="center">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
    </table>
    </p><br>
    <BUTTON type="button" onClick="BukaWndExcell();"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
	</div>
</form>
</div>
</body>
<script language="javascript">
function BukaWndExcell(){
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../master/ma_sak_excell.php?tipe=1',600,450,'childwnd',true);
}
</script>
</html>
<?php 
mysql_close($konek);
?>
<?php 
include("../koneksi/konek.php");
//echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";echo $_SERVER['QUERY_STRING'];
$qstr_ma="par=parent*kode_ma2*mainduk*parent_lvl";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$idma=$_REQUEST['idma'];
$tipe=$_REQUEST['tipe'];
//$jenis=$_REQUEST['jenis'];
$jenis= '3';
$kode_ma=trim($_REQUEST['kode_ma']);
$ma=str_replace("\'","''",$_REQUEST['ma']);
$ma=str_replace('\"','"',$ma);
$ma=str_replace(chr(92).chr(92),chr(92),$ma);

$aktif=$_REQUEST['aktif'];
if ($aktif=="") $aktif=1;
$status=$_REQUEST['status'];
if ($status=="") $status=1;
$kode_ma2=trim($_REQUEST['kode_ma2']);
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
$defaultsort="JTRANS_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from jenis_transaksi where JTRANS_KODE='$kode_ma' and JTRANS_AKTIF=$aktif";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Jenis Transaksi Sudah Ada');</script>";
		}else{
			$sql="insert into jenis_transaksi(JTRANS_KODE,JTRANS_NAMA,JTRANS_LEVEL,JTRANS_PARENT,JTRANS_PARENT_KODE,JTRANS_AKTIF,TIPE) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$aktif,'$tipe')";
			//echo $sql;
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update jenis_transaksi set JTRANS_ISLAST=0 where JTRANS_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="select * from jenis_transaksi where JTRANS_KODE='$kode_ma' and JTRANS_NAMA='$ma' and JTRANS_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			$rw1=mysql_fetch_array($rs1);
			//echo $rw1["JTRANS_ID"]." - ".$idma."<br>";
			if ($rw1["JTRANS_ID"]==$idma){
				$sql="update jenis_transaksi set JTRANS_KODE='$kode_ma',JTRANS_NAMA='$ma',JTRANS_LEVEL=$lvl,JTRANS_PARENT=$parent,JTRANS_PARENT_KODE='$kode_ma2',JTRANS_AKTIF=$aktif,TIPE='$tipe' where JTRANS_ID=$idma";
				$rs=mysql_query($sql);
			}else{
				echo "<script>alert('Jenis Transaksi Tersebut Sudah Ada');</script>";
			}
		}else{
			$sql="update jenis_transaksi set JTRANS_KODE='$kode_ma',JTRANS_NAMA='$ma',JTRANS_LEVEL=$lvl,JTRANS_PARENT=$parent,JTRANS_PARENT_KODE='$kode_ma2',JTRANS_AKTIF=$aktif,TIPE='$tipe' where JTRANS_ID=$idma";
			$rs=mysql_query($sql);
		}
		break;
	case "delete":
		$sql="select * from jenis_transaksi where JTRANS_parent=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Jenis Transaksi Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
				$sql="delete from jenis_transaksi where JTRANS_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="select * from jenis_transaksi where JTRANS_PARENT=".$parent;
				$rs2=mysql_query($sql);
				if (mysql_num_rows($rs2)<=0){
					$sql="update jenis_transaksi set JTRANS_ISLAST=1 where JTRANS_ID=".$parent;
					$rs2=mysql_query($sql);

			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>INPUT JENIS TRANSAKSI</title>
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
  <div id="input" style="display:none">
      <p class="jdltable">Input Jenis Transaksi</p>
    <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
          <td>Kode Jenis Transaksi Induk</td>
      <td>:</td>
          <td><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="<?php echo $kode_ma2; ?>" readonly="true" class="txtinput"> 
            <input type="button" name="Button222" value="..." class="txtcenter" title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_jtrans_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*mainduk*-**|*kode_ma*-**|*ma*-*')"></td>
    </tr>
    <tr>
      <td>Jenis Transaksi Induk</td>
      <td>:</td>
          <td ><textarea name="mainduk" cols="50" id="mainduk" class="txtinput" readonly><?=$_POST[mainduk];?></textarea></td>
    </tr>
      <tr>
          <td>Kode Jenis Transaksi</td>
      <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="6" maxlength="6" style="text-align:center"></td>
    </tr>
    <tr>
      <td>Nama Jenis Transaksi</td>
      <td>:</td>
          <td ><textarea name="ma" cols="50" id="ma" class="txtinput"></textarea></td>
    </tr>
    <tr>
      <td>Tipe Jurnal</td>
      <td>:</td>
          <td ><select name="tipe" id="tipe">
		  		<? $qry=mysql_query("select * from m_tipe_jurnal order by id_tipe");
					while($hs=mysql_fetch_array($qry)){?>
				<option value="<?=$hs[id_tipe]?>"><?=$hs[nama_tipe]?></option><? }?></select></td>
    </tr>
    <tr>
      <td>Status</td>
      <td>:</td>
          <td><select name="aktif" id="aktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_ma,ma','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR MASTER TRANSAKSI</span>
  <table width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="465">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/ms_trans_khusus&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
		  </td>
          <td width="460" align="right">
           <BUTTON type="button" onClick="location='?f=../master/tree_trans_khusus.php'"><IMG SRC="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tree View</BUTTON> <BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
	    </tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td width="62" class="tblheaderkiri">No</td>
        <td id="JTRANS_KODE" width="155" class="tblheader" onClick="ifPop.CallFr(this);">Kode Transaksi </td>
        <td id="JTRANS_NAMA" width="645" class="tblheader" onClick="ifPop.CallFr(this);">Nama Transaksi </td>
        <td class="tblheader" colspan="2" width="190">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * from jenis_transaksi where JTRANS_aktif=$status".$filter." ORDER BY ".$sorting;
	  //echo $sql."<br>";
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
		$pkode=trim($rows['JTRANS_PARENT_KODE']);
		$mkode=trim($rows['JTRANS_KODE']);
		if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 $sql="select * from jenis_transaksi where JTRANS_id=".$rows['JTRANS_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["JTRANS_NAMA"]; else $c_mainduk="";
		$arfvalue="act*-*edit*|*kode_ma2*-*".$pkode."*|*idma*-*".$rows['JTRANS_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['JTRANS_NAMA']."*|*parent_lvl*-*".($rows['JTRANS_LEVEL']-1)."*|*parent*-*".$rows['JTRANS_PARENT']."*|*mainduk*-*".$c_mainduk."*|*tipe*-*".$rows['TIPE']."*|*aktif*-*".$rows['JTRANS_AKTIF'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	$arfhapus="act*-*delete*|*idma*-*".$rows['JTRANS_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['JTRANS_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['JTRANS_NAMA']; ?></td>
        <td width="95" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="95" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
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
		<td colspan="2" align="right">
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
	OpenWnd('../master/ms_jurnal_excell.php',600,450,'childwnd',true);
}
</script>
</html>
<?php 
mysql_close($konek);
?>
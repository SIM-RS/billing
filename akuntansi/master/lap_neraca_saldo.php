<?php 
// Koneksi =================================
include "../sesi.php";
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kode=$_REQUEST['kode'];
$kode_ma_sak=$_REQUEST['kode_ma_sak'];
$nama=$_REQUEST['nama'];
$d_k=$_REQUEST['d_k'];
$op=$_REQUEST['op'];
$id = $_REQUEST['id'];
$qstr_ma_sak="par=id_ma*kode_ma_sak*xxx*yyy";
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode asc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
			$sql="Select kode from lap_neraca_saldo where kode='$kode'";
			$exe=mysql_query($sql);
			$rs=mysql_num_rows($exe);
			if ($rs > 0){
			echo "<script>alert('Maaf, Kode sudah ada, silahkan masukkan kode lain!')</script>";
			}else{
			$sql2="insert into lap_neraca_saldo(kode,kode_ma_sak,nama,d_k,op) values('$kode','$kode_ma_sak','$nama','$d_k','$op')";
			//echo $sql2;
			$rs2=mysql_query($sql2);
			}
		break;
	case "edit":
			$sql="update lap_neraca_saldo set kode='$kode',kode_ma_sak='$kode_ma_sak',nama='$nama',d_k='$d_k',op='$op' where id='$id'";
			//echo $sql;
			$rs=mysql_query($sql);
			
		break;
	case "delete":
		$sql="delete from lap_neraca_saldo where id='$id'";
		$rs=mysql_query($sql);
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
	<input type="hidden" name="id" id="id">
	<input type="hidden" name="id_ma" id="id_ma">
    <input name="xxx" id="xxx" type="hidden" value="">
	<input name="yyy" id="yyy" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <table width="446" border="0" cellpadding="0" cellspacing="2" class="txtinput" align="center">
        <tr>
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><span class="jdltable">INPUT DATA NERACA SALDO </span></td>
        </tr>
        <tr>
          <td width="98">&nbsp;</td>
          <td width="8">&nbsp;</td>
          <td width="332" >&nbsp;</td>
        </tr>
        <tr>
          <td>Kode</td>
          <td>:</td>
          <td ><input name="kode" type="text" id="kode" class="txtinput" size="25" ></td>
        </tr>
        <tr>
          <td>Kode Ma Sak </td>
          <td>:</td>
          <td ><input name="kode_ma_sak" type="text" id="kode_ma_sak"  class="txtinput" size="25" > <!--<input type="button" name="Button222" value="..." class="txtcenter" title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view_sak.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">--> </td>
        </tr>
        
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td ><input name="nama" type="text" id="nama" class="txtinput" size="50" ></td>
        </tr>
        <tr>
          <td>Debet/Kredit</td>
          <td>:</td>
          <td><select name="d_k" id="d_k" class="txtinput">
              <option value="D">Debet (D)</option>
              <option value="K">Kredit (K)</option>
            </select>          </td>
        </tr>
        <tr>
          <td>Jenis</td>
          <td>:</td>
          <td><select name="op" id="op" class="txtinput">
              <option value="1">Operasional</option>
              <option value="0">Non Operasional</option>
            </select></td>
        </tr>
      </table>
      <p><BUTTON type="button" onClick="if (ValidateForm('kode,kode_ma_sak,nama','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
 <p><span class="jdltable">LAPORAN NERACA SALDO</span>
  <table width="830" cellpadding="0" cellspacing="0" border="0" class="txtinput">
		<tr>
          <td width="330">&nbsp;</td>
          <td width="339" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kode*-**|*kode_ma_sak*-**|*nama*-**|*d_k*-*D*|*op*-*1')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table width="830" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="40" height="25" class="tblheaderkiri" id="kode_user" onClick="ifPop.CallFr(this);">No</td>
        <td id="kode" width="56" class="tblheader" onClick="ifPop.CallFr(this);">Kode</td>
        <td id="kode_ma_sak" width="88" class="tblheader" onClick="ifPop.CallFr(this);">Kode Ma Sak </td>
		<td id="nama" width="345" class="tblheader" onClick="ifPop.CallFr(this);">Nama</td>
		<td id="op" width="127" class="tblheader" onClick="ifPop.CallFr(this);">Jenis</td>
		<td id="d_k" width="89" class="tblheader" onClick="ifPop.CallFr(this);">Debet/Kredit</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * from lap_neraca_saldo ".$filter." ORDER BY ".$sorting;//where ." ORDER BY ".$sorting;
	  //echo $sql;
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
		$arfvalue="act*-*edit*|*kode*-*".$rows['kode']."*|*kode_ma_sak*-*".$rows['kode_ma_sak']."*|*nama*-*".$rows['nama']."*|*d_k*-*".$rows['d_k']."*|*id*-*".$rows['id']."*|*op*-*".$rows['op'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);

		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*id*-*".$rows['id'];
	 ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['kode']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['kode_ma_sak']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['nama']; ?></td>
		<td align="left" class="tdisi">&nbsp;
		<?
		if($rows['op']=='1'){$jenis='Operasional';}else{$jenis='Non Operasional';}echo "$jenis";
		?>
		</td>
		<td align="center" class="tdisi">&nbsp;
		<?
		if($rows['d_k']=='D'){$tipe='Debet';}else{$tipe='Kredit';}echo "$tipe";
		?>
		</td>
        <td width="27" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="42" class="tdisi">
		<? if($_SESSION['akun_iduser']==$rows['kode_user']){?><img src="../icon/del2.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="alert('Anda tidak diijinkan menghapus user sendiri, karena sedang digunakan')">
		<? }else{?>
		<img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}">
		<? }?>		</td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="5" align="right">
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
mysql_close($konek);
?>
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//===========================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$kode_user=$_REQUEST['kode_user'];
$kode_user=mysqli_real_escape_string($konek,$_REQUEST['kode_user']);
//nama_user=$_REQUEST['nama_user'];
$nama_user=mysqli_real_escape_string($konek,$_REQUEST['nama_user']);
$pegawai_id=0;
//$kata_kunci=$_REQUEST['kata_kunci'];
$kata_kunci=mysqli_real_escape_string($konek,$_REQUEST['kata_kunci']);
//$unit=$_REQUEST['unit'];
$unit=mysqli_real_escape_string($konek,$_REQUEST['unit']);
//$kategori_user=$_REQUEST['kategori_user'];
$kategori_user=mysqli_real_escape_string($konek,$_REQUEST['kategori_user']);
//$isaktif=$_REQUEST['isaktif'];
$isaktif=mysqli_real_escape_string($konek,$_REQUEST['isaktif']);
//====================================================================

//Set Status Aktif atau Tidak====
//$status=$_REQUEST['status'];
$status=mysqli_real_escape_string($konek,$_REQUEST['status']);
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$defaultsort="kode_user desc";
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
			$sql="Select username from a_user where username='$nama_user'";
			$exe=mysqli_query($konek,$sql);
			$rs=mysqli_num_rows($exe);
			if ($rs > 0){
			echo "<script>alert('Maaf, Username telah digunakan, Silahkan masukkan username lain!')</script>";
			}else{
			$sql2="insert into a_user(kode_user,pegawai_id,username,password,unit,kategori,isaktif) values('','$pegawai_id','$nama_user',password('$kata_kunci'),$unit,$kategori_user,$isaktif)";
			//echo $sql2;
			$rs2=mysqli_query($konek,$sql2);
			}
		break;
	case "edit":
			if ($kata_kunci==""){
				$sql="update a_user set username='$nama_user',unit='$unit',kategori='$kategori_user',isaktif='$isaktif' where kode_user=$kode_user";
			}else{
				$sql="update a_user set username='$nama_user',password=password('$kata_kunci'),unit='$unit',kategori='$kategori_user',isaktif='$isaktif' where kode_user=$kode_user";
			}
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_user where kode_user=$kode_user";
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
    <input name="kode_user" id="kode_user" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none" align="center">
      <table width="36%" border="0" cellpadding="1" cellspacing="1" class="txtinput" align="center">
        <tr>
          <td colspan="3" align="center"><span class="jdltable">INPUT DATA  USER </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td ><input name="nama_user" type="text" id="nama_user" class="txtinput" size="35" ></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td ><input name="kata_kunci" type="password" id="kata_kunci" class="txtinput" size="35" value="" ></td>
        </tr>
        <tr>
          <td>Unit</td>
          <td>:</td>
          <td ><select name="unit" id="unit">
              <?
	  $qry = "select * from a_unit where UNIT_ISAKTIF=1";
	  $exe = mysqli_query($konek,$qry);
	  while($show= mysqli_fetch_array($exe)){
	  ?>
              <option value="<?=$show['UNIT_ID'];?>">
                <?=$show['UNIT_NAME'];?>
              </option>
              <? }?>
            </select>          </td>
        </tr>
        <tr>
          <td>Kategori</td>
          <td>:</td>
          <td ><select name="kategori_user" id="kategori_user">
              <?
	  $qry = "select * from a_user_kategori";
	  $exe = mysqli_query($konek,$qry);
	  while($show= mysqli_fetch_array($exe)){
	  ?>
             	<option value="<?=$show['id_kategori'];?>">
                <?=$show['nama_kategori'];?>
              </option>
              <? }?>
            </select>          </td>
        </tr>
        <tr>
          <td>Status</td>
          <td>:</td>
          <td><select name="isaktif" id="isaktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>          </td>
        </tr>
      </table>
      <p><BUTTON type="button" onClick="if (ValidateForm('nama_user,unit,kategori_user','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
 <p><span class="jdltable">DAFTAR USER </span>
  <table width="64%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="330" style="font:bold 12px tahoma;">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/user&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
		  </td>
          <td width="339" align="right">
		  <!--BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kode_user*-**|*nama_user*-**|*kata_kunci*-**|*unit*-**|*kategori_user*-**|*isaktif*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->
		  </td>
	    </tr>
	</table>
    <table width="631" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="kode_user" width="60" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="username" width="133" class="tblheader" onClick="ifPop.CallFr(this);">Username </td>
		<td id="unit" width="125" class="tblheader" onClick="ifPop.CallFr(this);">Unit</td>
        <td id="nama_kategori" width="125" class="tblheader" onClick="ifPop.CallFr(this);">Kategori</td>
        <!--td class="tblheader" colspan="2">Proses</td-->
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT a_user.*, a_user_kategori.nama_kategori, a_unit.UNIT_NAME 
	  FROM a_user left Join a_user_kategori ON a_user.kategori = a_user_kategori.id_kategori
	  left Join a_unit ON a_user.unit = a_unit.UNIT_ID where isaktif=$status".$filter." ORDER BY ".$sorting;
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
		$arfvalue="act*-*edit*|*kode_user*-*".$rows['kode_user']."*|*nama_user*-*".$rows['username']."*|*kata_kunci"."*-*"."*|*unit*-*".$rows['unit']."*|*kategori_user*-*".$rows['kategori']."*|*isaktif*-*".$rows['isaktif'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*kode_user*-*".$rows['kode_user'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['username']; ?></td>
		<td align="left" class="tdisi"><?php echo $rows['UNIT_NAME']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['nama_kategori']; ?></td>
        <!--td width="45" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="43" class="tdisi">
		<? if($_SESSION['iduser']==$rows['kode_user']){?><img src="../icon/del2.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="alert('Anda tidak diijinkan menghapus user sendiri, karena sedang digunakan')">
		<? }else{?>
		<img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}">
		<? }?>
		</td-->
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
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
<?php 
// Koneksi =================================
include "../sesi.php";
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kode=trim($_REQUEST['kode']);
$nama=$_REQUEST['nama'];
$alamat=$_REQUEST['alamat'];
$telp=$_REQUEST['telp'];
$fax=$_REQUEST['fax'];
$contact=$_REQUEST['contact'];
$email=$_REQUEST['email'];
$kategori=$_REQUEST['kategori'];
$idsuplier=$_REQUEST['idsuplier'];
$isaktif=$_REQUEST['isaktif'];
$tipe=$_REQUEST['tipe'];
if ($tipe=="") $tipe="1";
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
if ($tipe=="1"){
	$defaultsort="t1.kode";
	$style_kat_tipe="collapse";
	$jdltbl="DAFTAR SUPLIER OBAT";
	$inptbl="INPUT DATA SUPLIER OBAT";
}else{
	$defaultsort="t1.kode";
	$style_kat_tipe="visible";
	$jdltbl="DAFTAR SUPLIER UMUM";
	$inptbl="INPUT DATA SUPLIER UMUM";
}
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		if ($tipe=="1"){
			$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_KODE_AK='$kode'";
			$exe=mysql_query($sql);
			$rs=mysql_num_rows($exe);
			if ($rs > 0){
				echo "<script>alert('Maaf, Kode Tersebut Sudah Ada !')</script>";
			}else{
				$sql2="INSERT INTO $dbapotek.a_pbf(PBF_KODE,PBF_KODE_AK,PBF_NAMA,PBF_ALAMAT,PBF_TELP,PBF_FAX,PBF_KONTAK,PBF_ISAKTIF) VALUES('$kode','$kode','$nama','$alamat','$telp','$fax','$kontak','$isaktif')";
				//echo $sql2;
				$rs2=mysql_query($sql2);
			}
		}else{
			$sql="SELECT * FROM $dbapotek.a_pbf WHERE PBF_KODE_AK='$kode'";
			$exe=mysql_query($sql);
			$rs=mysql_num_rows($exe);
			if ($rs > 0){
				echo "<script>alert('Maaf, Kode Tersebut Sudah Ada !')</script>";
			}else{
				$sql2="INSERT INTO $dbaset.as_ms_rekanan(koderekanan,namarekanan,alamat,telp,fax,contactperson,STATUS,idtipesupplier) VALUES('$kode','$nama','$alamat','$telp','$fax','$kontak','$isaktif','$kategori')";
				//echo $sql2;
				$rs2=mysql_query($sql2);
			}
		}
		break;
	case "edit":
		if ($tipe=="1"){
			$sql="UPDATE $dbapotek.a_pbf SET PBF_KODE='$kode',PBF_KODE_AK='$kode',PBF_NAMA='$nama',PBF_ALAMAT='$alamat',PBF_TELP='$telp',PBF_FAX='$fax',PBF_KONTAK='$kontak',PBF_ISAKTIF='$isaktif' WHERE PBF_ID='$idsuplier'";
		}else{
			$sql="UPDATE $dbaset.as_ms_rekanan SET koderekanan='$kode',namarekanan='$nama',alamat='$alamat',telp='$telp',fax='$fax',contactperson='$kontak',STATUS='$isaktif',idtipesupplier='$kategori' WHERE idrekanan='$idsuplier'";
		}
		//echo $sql;
		$rs=mysql_query($sql);
		break;
	case "delete":
		/*$sql="delete from user_master where kode_user=$kode_user";
		$rs=mysql_query($sql);*/
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
    <input name="tipe" id="tipe" type="hidden" value="<?php echo $tipe; ?>">
    <input name="idsuplier" id="idsuplier" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput" align="center">
        <tr>
          <td colspan="3" align="center"><span class="jdltable"><?php echo $inptbl; ?></span></td>
        </tr>
        <tr>
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td>Nama Suplier</td>
          <td>:</td>
          <td ><input name="nama" type="text" id="nama" class="txtinput" size="45" ></td>
        </tr>
        <tr>
          <td>Kode Suplier</td>
          <td>:</td>
          <td ><input name="kode" type="text" id="kode" class="txtinput" size="10" ></td>
        </tr>
        
        <tr>
          <td>Alamat</td>
          <td>:</td>
          <td ><label>
            <textarea name="alamat" id="alamat" class="txtinput" cols="45" rows="1"></textarea>
          </label></td>
        </tr>
        <tr>
          <td>Telp</td>
          <td>:</td>
          <td ><input name="telp" type="text" id="telp" class="txtinput" size="15" ></td>
        </tr>
        <tr>
          <td>Fax</td>
          <td>:</td>
          <td ><input name="fax" type="text" id="fax" class="txtinput" size="15" ></td>
        </tr>
        <tr>
          <td>Contact Person</td>
          <td>:</td>
          <td ><input name="contact" type="text" id="contact" class="txtinput" size="35" ></td>
        </tr>
        
        <tr id="kat_tipe" style="visibility:<?php echo $style_kat_tipe; ?>">
          <td>Kategori</td>
          <td>:</td>
          <td ><select name="kategori" id="kategori">
              <?php
			  $qry = "SELECT * FROM $dbaset.as_tiperekanan";
			  $exe = mysql_query($qry);
			  while($show= mysql_fetch_array ($exe)){
			  ?>
             	<option value="<?=$show['idtipesupplier'];?>">
                <?=$show['keterangan'];?>
              </option>
              <? }?>
            </select></td>
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
      <p><BUTTON type="button" onClick="if (ValidateForm('nama,kode','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
 <p><span class="jdltable"><?php echo $jdltbl; ?></span>
  <table width="1000" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="300" class="txtinput">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" class="txtinput" onChange="location='?f=../master/suplier&status='+this.value+'&tipe='+tipe.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select>
		  </td>
          <td width="339" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kode_user*-**|*nama_user*-**|*kata_kunci*-**|*unit*-**|*kategori_user*-**|*isaktif*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table width="1000" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="30" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode </td>
		<td id="nama" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Nama Suplier</td>
        <td id="alamat" class="tblheader" onClick="ifPop.CallFr(this);">Alamat</td>
        <td id="telp" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Telp</td>
        <td id="fax" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Fax</td>
        <td id="kontak" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Contact Person</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($tipe=="1"){
	  		$sql="SELECT * FROM (SELECT PBF_ID idsuplier,PBF_KODE_AK kode,PBF_NAMA nama,PBF_ALAMAT alamat,PBF_TELP telp,PBF_FAX fax,PBF_KONTAK kontak 
FROM $dbapotek.a_pbf WHERE PBF_ISAKTIF='$status') AS t1 ".$filter." ORDER BY ".$sorting;
	  }else{
	  		$sql="SELECT * FROM (SELECT idrekanan idsuplier,koderekanan kode,namarekanan nama,alamat,telp,fax,contactperson kontak,idtipesupplier 
FROM $dbaset.as_ms_rekanan WHERE STATUS='$status') AS t1 ".$filter." ORDER BY ".$sorting;
	  }
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
		$arfvalue="act*-*edit*|*idsuplier*-*".$rows['idsuplier']."*|*kode*-*".$rows['kode']."*|*nama*-*".$rows['nama']."*|*alamat*-*".$rows['alamat']."*|*telp*-*".$rows['telp']."*|*fax*-*".$rows['fax']."*|*contact*-*".$rows['kontak']."*|*kategori*-*".$rows['idtipesupplier']."*|*isaktif*-*".$isaktif;
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);

		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(13).chr(10),"",$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*kode_user*-*".$rows['kode_user'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['kode']; ?></td>
		<td align="left" class="tdisi"><?php echo $rows['nama']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['alamat']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['telp']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['fax']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['kontak']; ?></td>
        <td width="18" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="18" class="tdisi">
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
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
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
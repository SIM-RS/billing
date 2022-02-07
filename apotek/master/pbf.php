<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$pbf_id=$_REQUEST['pbf_id'];
$pbf_id=mysqli_real_escape_string($konek,$_REQUEST['pbf_id']);
//$pbf_nama=$_REQUEST['pbf_nama'];
$pbf_nama=mysqli_real_escape_string($konek,$_REQUEST['pbf_nama']);
//$pbf_alamat=$_REQUEST['pbf_alamat'];
$pbf_alamat=mysqli_real_escape_string($konek,$_REQUEST['pbf_alamat']);
//$pbf_telp=$_REQUEST['pbf_telp'];
$pbf_telp=mysqli_real_escape_string($konek,$_REQUEST['pbf_telp']);
//$pbf_fax=$_REQUEST['pbf_fax'];
$pbf_fax=mysqli_real_escape_string($konek,$_REQUEST['pbf_fax']);
//$pbf_kontak=$_REQUEST['pbf_kontak'];
$pbf_kontak=mysqli_real_escape_string($konek,$_REQUEST['pbf_kontak']);
//$pbf_isaktif=$_REQUEST['pbf_isaktif'];
$pbf_isaktif=mysqli_real_escape_string($konek,$_REQUEST['pbf_isaktif']);
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$defaultsort="PBF_ID desc";
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
			$sql="insert into a_pbf(PBF_ID,PBF_NAMA,PBF_ALAMAT,PBF_TELP,PBF_FAX,PBF_KONTAK,PBF_ISAKTIF) values('','$pbf_nama','$pbf_alamat','$pbf_telp','$pbf_fax','$pbf_kontak',$pbf_isaktif)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			$sql="update a_pbf set PBF_NAMA='$pbf_nama',PBF_ALAMAT='$pbf_alamat',PBF_TELP='$pbf_telp',PBF_FAX='$pbf_fax',PBF_KONTAK='$pbf_kontak',PBF_ISAKTIF=$pbf_isaktif where PBF_ID=$pbf_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_pbf where PBF_ID=$pbf_id";
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
  <input name="pbf_id" id="pbf_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data PBF</p>
    <table width="75%" border="0" cellpadding="1" cellspacing="1" class="txtinput">
      <tr>
      <td>Nama PBF</td>
      	<td>:</td>
        <td ><input name="pbf_nama" type="text" id="pbf_nama" class="txtinput" size="50" ></td>
    </tr>
     <tr>
        <td>Alamat PBF </td>
		<td>:</td>
    	<td><textarea name="pbf_alamat" cols="65" rows="3" id="pbf_alamat" class="txtinput"></textarea></td>
     </tr>
     <tr>
       <td>Telephon</td>
       <td>:</td>
       <td ><input name="pbf_telp" type="text" id="pbf_telp" class="txtinput" size="35" ></td>
     </tr>
	 <tr>
       <td>Fax</td>
	   <td>:</td>
	   <td ><input name="pbf_fax" type="text" id="pbf_fax" class="txtinput" size="35" ></td>
	   </tr>
	 <tr>
       <td>Kontak</td>
	   <td>:</td>
	   <td ><input name="pbf_kontak" type="text" id="pbf_kontak" class="txtinput" size="35" ></td>
	   </tr>
	 <tr>  
      <td>Status</td>
      <td>:</td>
          <td><select name="pbf_isaktif" id="pbf_isaktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('pbf_nama,pbf_alamat,pbf_telp,pbf_fax,pbf_kontak','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR PBF</span>
  <table width="91%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="358" style="font:bold 12px tahoma;">&nbsp;Status&nbsp;:&nbsp;
          <select name="status" id="status" onChange="location='?f=../master/pbf&status='+this.value">
            <option value="1">Aktif</option>
            <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          </select>
      </td>
      <td width="621" align="right"><button type="button" onClick="document.getElementById('input').style.display='block';fSetValue(window,'act*-*save*|*pbf_nama*-**|*pbf_alamat*-**|*pbf_telp*-**|*pbf_fax*-**|*pbf_kontak*-*')"><img src="../icon/add.gif" border="0" width="16" height="16" align="absmiddle">&nbsp;Tambah</button></td>
    </tr>
  </table>
  <table width="900" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="PBF_ID" width="60" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="PBF_NAMA" width="133" class="tblheader" onClick="ifPop.CallFr(this);">Nama PBF </td>
        <td id="PBF_ALAMAT" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alamat</td>
		<td id="PBF_TELP" width="125" class="tblheader" onClick="ifPop.CallFr(this);">Telp</td>
		<td id="PBF_FAX" width="117" class="tblheader" onClick="ifPop.CallFr(this);">Fax</td>
		<td id="PBF_KONTAK" width="116" class="tblheader" onClick="ifPop.CallFr(this);">Kontak</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * FROM a_pbf where PBF_ISAKTIF=$status".$filter." ORDER BY ".$sorting;
	 // echo $sql;
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
		$arfvalue="act*-*edit*|*pbf_id*-*".$rows['PBF_ID']."*|*pbf_nama*-*".$rows['PBF_NAMA']."*|*pbf_alamat*-*".$rows['PBF_ALAMAT']."*|*pbf_telp*-*".$rows['PBF_TELP']."*|*pbf_fax*-*".$rows['PBF_FAX']."*|*pbf_kontak*-*".$rows['PBF_KONTAK'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*pbf_id*-*".$rows['PBF_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['PBF_ALAMAT']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['PBF_TELP']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['PBF_FAX']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['PBF_KONTAK']; ?></td>
        <td width="45" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="49" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtinput" size="1">
		  <button type="button" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></td>
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
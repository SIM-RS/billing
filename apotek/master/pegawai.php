<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$pegawai_id=$_REQUEST['pegawai_id'];
$pegawai_id=mysqli_real_escape_string($konek,$_REQUEST['pegawai_id']);
//$nip=$_REQUEST['nip'];
$nip=mysqli_real_escape_string($konek,$_REQUEST['nip']);
//$nama=$_REQUEST['nama'];
$nama=mysqli_real_escape_string($konek,$_REQUEST['nama']);
//$kategori_id=$_REQUEST['kategori_id'];
$kategori_id=mysqli_real_escape_string($konek,$_REQUEST['kategori_id']);
//$alamat=$_REQUEST['alamat'];
$alamat=mysqli_real_escape_string($konek,$_REQUEST['alamat']);
//$telp=$_REQUEST['telp'];
$telp=mysqli_real_escape_string($konek,$_REQUEST['telp']);
//$hp=$_REQUEST['hp'];
$hp=mysqli_real_escape_string($konek,$_REQUEST['hp']);
//$isaktif=$_REQUEST['isaktif'];
$isaktif=mysqli_real_escape_string($konek,$_REQUEST['isaktif']);
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$defaultsort="PEGAWAI_ID desc";
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
			$sql="insert into a_pegawai(PEGAWAI_ID,NIP,NAMA,KATEGORI,ALAMAT,TELP,HP,ISAKTIF) values('','$nip','$nama',$kategori_id,'$alamat','$telp','$hp',$isaktif)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			$sql="update a_pegawai set NIP='$nip', NAMA='$nama', KATEGORI=$kategori_id, ALAMAT='$alamat', TELP='$telp', HP='$hp', ISAKTIF=$isaktif where PEGAWAI_ID=$pegawai_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_pegawai where PEGAWAI_ID=$pegawai_id";
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
  <input name="pegawai_id" id="pegawai_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Daftar Pegawai</p>
    <table width="75%" border="0" cellpadding="1" cellspacing="1" class="txtinput">
      <tr>
      <td>N.I.P</td>
      	<td>:</td>
        <td ><input name="nip" type="text" id="nip" class="txtinput" size="25" ></td>
    </tr>
      <tr>
        <td>Nama Pegawai</td>
        <td>:</td>
        <td ><input name="nama" type="text" id="nama" class="txtinput" size="50" ></td>
      </tr>
      <tr>
        <td>Kategori</td>
        <td>:</td>
        <td >
		<select name="kategori_id" id="kategori_id" class="txtinput">
			<?php
			$qry = "select * from a_pegawai_kategori";
			$exe = mysqli_query($konek,$qry);
			while($show= mysqli_fetch_array($exe)){
			?>
            <option value="<?php echo $show['KATEGORI_ID'];?>"><?php echo $show['KAT_NAMA'];?></option>
            <? }?>
		</select>
		</td>
      </tr>
      <tr>
        <td>Alamat</td>
		<td>:</td>
    	<td><textarea name="alamat" cols="65" rows="3" id="alamat" class="txtinput"></textarea></td>
     </tr>
     <tr>
       <td>Telephon</td>
       <td>:</td>
       <td ><input name="telp" type="text" id="telp" class="txtinput" size="35" ></td>
     </tr>
	 <tr>
       <td>Handphone</td>
	   <td>:</td>
	   <td ><input name="hp" type="text" id="hp" class="txtinput" size="35" ></td>
	   </tr>  
      <td>Status</td>
      <td>:</td>
          <td><select name="isaktif" id="isaktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('nip,nama','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR PEGAWAI</span>
  <table width="91%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="358" style="font:bold 12px tahoma;">&nbsp;Status&nbsp;:&nbsp;
          <select name="status" id="status" onChange="location='?f=../master/pegawai&status='+this.value">
            <option value="1">Aktif</option>
            <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          </select>
      </td>
      <td width="621" align="right"><button type="button" onClick="document.getElementById('input').style.display='block';fSetValue(window,'act*-*save*|*nip*-**|*nama*-**|*kategori_id*-*1*|*alamat*-**|*telp*-**|*hp*-*')"><img src="../icon/add.gif" border="0" width="16" height="16" align="absmiddle">&nbsp;Tambah</button></td>
    </tr>
  </table>
  <table width="909" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="PEGAWAI_ID" width="27" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="NIP" width="126" class="tblheader" onClick="ifPop.CallFr(this);">N.I.P</td>
		<td id="NAMA" width="147" class="tblheader" onClick="ifPop.CallFr(this);">Nama Pegawai </td>
        <td id="KAT_NAMA" width="142" class="tblheader" onClick="ifPop.CallFr(this);">Kategori</td>
		<td id="ALAMAT" width="230" class="tblheader" onClick="ifPop.CallFr(this);">Alamat</td>
		<td id="TELP" width="101" class="tblheader" onClick="ifPop.CallFr(this);">Telp.</td>
		<td id="HP" width="103" class="tblheader" onClick="ifPop.CallFr(this);">Handphone</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="Select a_pegawai.*, a_pegawai_kategori.KAT_NAMA From a_pegawai Inner Join a_pegawai_kategori ON a_pegawai.KATEGORI = a_pegawai_kategori.KATEGORI_ID where ISAKTIF=$status".$filter." ORDER BY ".$sorting;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql;

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$arfvalue="act*-*edit*|*pegawai_id*-*".$rows['PEGAWAI_ID']."*|*nip*-*".$rows['NIP']."*|*nama*-*".$rows['NAMA']."*|*kategori_id*-*".$rows['KATEGORI']."*|*alamat*-*".$rows['ALAMAT']."*|*telp*-*".$rows['TELP']."*|*hp*-*".$rows['HP']."*|*isaktif*-*".$rows['ISAKTIF'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*pegawai_id*-*".$rows['PEGAWAI_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="center" class="tdisi">&nbsp;<?php echo $rows['NIP']; ?></td>
        <td align="left" class="tdisi">&nbsp;<?php echo $rows['NAMA']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['KAT_NAMA']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['ALAMAT']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['TELP']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['HP']; ?></td>
        <td width="17" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="17" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
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
mysqli_close($konek);
?>
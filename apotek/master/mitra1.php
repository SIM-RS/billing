<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idmitra=$_REQUEST['idmitra'];
$kode_mitra=$_REQUEST['kode_mitra'];
$nama=$_REQUEST['nama'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$kel_pasien=$_REQUEST['kel_pasien'];
$discount=$_REQUEST['discount'];
$aktif=$_REQUEST['aktif'];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="IDMITRA desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$sql="insert into a_mitra(IDMITRA,KODE_MITRA,NAMA,KEPEMILIKAN_ID,KELOMPOK_ID,DISCOUNT,AKTIF) values('','$kode_mitra','$nama',$kepemilikan_id,$kel_pasien,$discount,$aktif)";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
		$sql="update a_mitra set KODE_MITRA='$kode_mitra',NAMA='$nama',KEPEMILIKAN_ID=$kepemilikan_id,KELOMPOK_ID=$kel_pasien,DISCOUNT='$discount',AKTIF=$aktif where IDMITRA=$idmitra";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_mitra where IDMITRA=$idmitra";
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
  <input name="idmitra" id="idmitra" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data KSO</p>
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="20%">Kode KSO</td>
          <td width="0%">:</td>
          <td width="85%" ><input name="kode_mitra" type="text" id="kode_mitra" class="txtinput" size="50" ></td>
        </tr>
        <tr> 
          <td>Nama KSO</td>
          <td>:</td>
          <td><textarea name="nama" cols="65" rows="3" id="nama" class="txtinput"></textarea></td>
        </tr>
        <td>Kepemilikan</td>
        <td>:</td>
        <td><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
            <?php
			$qry="select ID,NAMA from a_kepemilikan where AKTIF=1";
			$exe=mysqli_query($konek,$qry);
			while($show=mysqli_fetch_array($exe)){
			?>
            <option value="<?php echo $show['ID']; ?>"><?php echo $show['NAMA']; ?></option>
            <? }?>
          </select></td>
        </tr>
		<tr>
          <td>Kelompok Pasien</td>
        <td>:</td>
        <td><select name="kel_pasien" id="kel_pasien" class="txtinput">
            <?php
			$qry="select * from a_kelompok_pasien";
			$exe=mysqli_query($konek,$qry);
			while($show=mysqli_fetch_array($exe)){
			?>
            <option value="<?php echo $show['a_kpid']; ?>"><?php echo $show['kp_nama']; ?></option>
            <? }?>
          </select></td>
        </tr>
        <tr> 
          <td>Discount</td>
          <td>:</td>
          <td ><input name="discount" type="text" id="discount" class="txtinput" size="5" ></td>
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
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_mitra,nama,discount','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
    <p><span class="jdltable">DAFTAR KSO</span>
    <table width="75%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="314">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" id="status" onChange="location='?f=../master/mitra&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
            </select>
        </td>
        <td width="423" align="right"><button type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kode_mitra*-**|*nama*-**|*kepemilikan_id*-**|*discount*-*')"><img src="../icon/add.gif" border="0" width="16" height="16" align="absmiddle">&nbsp;Tambah</button></td>
      </tr>
    </table>
      <table width="908" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="IDMITRA" width="30" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
          <td id="KODE_MITRA" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            KSO </td>
          <td id="a_mitra.NAMA" width="297" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            KSO </td>
          <td id="a_kepemilikan.NAMA" width="114" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="DISCOUNT" width="114" class="tblheader" onClick="ifPop.CallFr(this);">Kelompok 
            Pasien </td>
          <td id="DISCOUNT" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Discount</td>
          <td class="tblheader" colspan="2">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT a_mitra.*, a_kepemilikan.NAMA as NAMA_KEPEMILIKAN,b.kp_nama FROM a_mitra Inner Join a_kepemilikan ON a_mitra.KEPEMILIKAN_ID = a_kepemilikan.ID inner join a_kelompok_pasien b on a_mitra.KELOMPOK_ID=b.a_kpid where a_mitra.AKTIF=$status ".$filter." ORDER BY ".$sorting;
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
		$arfvalue="act*-*edit*|*idmitra*-*".$rows['IDMITRA']."*|*kode_mitra*-*".$rows['KODE_MITRA']."*|*nama*-*".$rows['NAMA']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*kel_pasien*-*".$rows['KELOMPOK_ID']."*|*discount*-*".$rows['DISCOUNT']."*|*aktif*-*".$rows['AKTIF'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*idmitra*-*".$rows['IDMITRA'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['KODE_MITRA']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA_KEPEMILIKAN']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['kp_nama']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['DISCOUNT']." %";?></td>
          <td width="29" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
          <td width="34" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
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
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$obat_id=$_REQUEST['obat_id'];
$obat_kode=$_REQUEST['obat_kode'];
$obat_nama=$_REQUEST['obat_nama'];
$pabrik_id=$_REQUEST['pabrik_id'];
$obat_dosis=$_REQUEST['obat_dosis'];
$obat_satuan_besar=$_REQUEST['obat_satuan_besar'];
$obat_satuan_kecil=$_REQUEST['obat_satuan_kecil'];
$isi_satuan_kecil=$_REQUEST['isi_satuan_kecil'];
$obat_bentuk=$_REQUEST['obat_bentuk'];
$kls_id=$_REQUEST['kls_id'];
$obat_kategori=$_REQUEST['obat_kategori'];
$obat_golongan=$_REQUEST['obat_golongan'];
$habis_pakai=$_REQUEST['habis_pakai'];
$jenis_obat=$_REQUEST['jenis_obat'];
$obat_isaktif=$_REQUEST['obat_isaktif'];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_KODE desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi ==================================
//echo $act;
switch ($act){
	case "save":
			$sql="insert into a_obat (OBAT_ID,OBAT_KODE,OBAT_NAMA,PABRIK_ID,OBAT_DOSIS,OBAT_SATUAN_BESAR,OBAT_SATUAN_KECIL,ISI_SATUAN_KECIL,OBAT_BENTUK,KLS_ID,OBAT_KATEGORI,OBAT_KELOMPOK,OBAT_GOLONGAN,HABIS_PAKAI,OBAT_ISAKTIF)
			values('','$obat_kode','$obat_nama','$pabrik_id','$obat_dosis','$obat_satuan_besar','$obat_satuan_kecil','$isi_satuan_kecil','$obat_bentuk',$kls_id,$obat_kategori,$jenis_obat,'$obat_golongan',$habis_pakai,$obat_isaktif)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			$sql="update a_obat set OBAT_KODE='$obat_kode',OBAT_NAMA='$obat_nama',PABRIK_ID='$pabrik_id',OBAT_DOSIS='$obat_dosis',OBAT_SATUAN_BESAR='$obat_satuan_besar',OBAT_SATUAN_KECIL='$obat_satuan_kecil',ISI_SATUAN_KECIL='$isi_satuan_kecil',OBAT_BENTUK='$obat_bentuk',KLS_ID=$kls_id,OBAT_KATEGORI=$obat_kategori,OBAT_KELOMPOK=$jenis_obat, OBAT_GOLONGAN='$obat_golongan',HABIS_PAKAI=$habis_pakai,OBAT_ISAKTIF=$obat_isaktif where OBAT_ID=$obat_id";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_obat where OBAT_ID=$obat_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
//Aksi Save, Edit, Delete Berakhir =====================================
$sql="SELECT MAX(OBAT_KODE)+1 AS maxkode FROM a_obat";
$rs=mysqli_query($konek,$sql);
$cmkode=1;
if ($rows=mysqli_fetch_array($rs)){
	$cmkode=$rows["maxkode"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++){
	$mkode="0".$mkode;
}
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
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="obat_id" id="obat_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Obat / Alat Kesehatan </p>
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td>Kode Obat / Alkes </td>
          <td>:</td>
          <td ><input name="obat_kode" type="text" id="obat_kode" class="txtinput" size="10"></td>
        </tr>
        <tr> 
          <td>Nama Obat / Alkes </td>
          <td>:</td>
          <td ><input name="obat_nama" type="text" id="obat_nama" class="txtinput" size="38" ></td>
        </tr>
        <tr> 
          <td>Dosis</td>
          <td>:</td>
          <td ><textarea name="obat_dosis" cols="50" id="obat_dosis" class="txtinput"></textarea></td>
        </tr>
        <tr> 
          <td>Satuan Kecil </td>
          <td>:</td>
          <td> <select name="obat_satuan_kecil" id="obat_satuan_kecil">
              <?php
			$qry = "select * from a_satuan";
			$exe = mysqli_query($konek,$qry);
			while($show= mysqli_fetch_array($exe)){
			?>
              <option value="<?=$show['SATUAN'];?>"><?php echo $show['SATUAN'];?></option>
              <? }?>
            </select> </td>
        </tr>
        <!--tr>
        <td>Isi Per-Kemasan Besar </td>
        <td>:</td>
        <td ><input name="isi_satuan_kecil" type="text" id="isi_satuan_kecil" class="txtinput" size="10" ></td>
      </tr-->
        <tr> 
          <td>Bentuk</td>
          <td>:</td>
          <td> <select name="obat_bentuk" id="obat_bentuk">
              <?
	  	$qry = "select * from a_bentuk";
	  	$exe = mysqli_query($konek,$qry);
	  	while($show= mysqli_fetch_array($exe)){
	  	?>
              <option value="<?=$show['BENTUK'];?>"> 
              <?=$show['BENTUK'];?>
              </option>
              <? }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Kelas Terapi</td>
          <td>:</td>
          <td > <input type="hidden" name="kls_id" id="kls_id" value="<?=$_POST[kls_id];?>"> 
            <input type="text" name="kls_nama" id="kls_nama" class="txtinput" value="<?=$_POST[kode_kls_induk];?>"readonly> 
            <input type="button" name="Button" value="..." class="txtcenter" title="Pilih Kelas" onClick="OpenWnd('../master/tree_kls_diobat.php?par=kls_id*kls_nama',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kls_id*-**|*kls_nama*-*')"> 
          </td>
        </tr>
        <tr> 
          <td>Kategori Obat / Alkes </td>
          <td>:</td>
          <td> <select name="obat_kategori" id="obat_kategori">
		  <?php 
		  $sql="SELECT * FROM a_obat_kategori";
		  $rs=mysqli_query($konek,$sql);
		  while ($rows=mysqli_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['id']; ?>"><?php echo $rows['kategori']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Golongan</td>
          <td>:</td>
          <td> <select name="obat_golongan" id="obat_golongan">
		  <?php 
		  $sql="SELECT * FROM a_obat_golongan";
		  $rs=mysqli_query($konek,$sql);
		  while ($rows=mysqli_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['kode']; ?>"><?php echo $rows['golongan']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Tipe Obat/Alkes </td>
          <td>:</td>
          <td><select name="habis_pakai" id="habis_pakai">
              <option value="1">Habis Pakai</option>
              <option value="0">Tidak Habis Pakai</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Jenis Obat</td>
          <td>:</td>
          <td><select name="jenis_obat" id="jenis_obat">
		  <?php 
		  $sql="SELECT * FROM a_obat_jenis";
		  $rs=mysqli_query($konek,$sql);
		  while ($rows=mysqli_fetch_array($rs)){
		  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>"><?php echo $rows['obat_jenis']; ?></option>
		  <?php }?>
            </select> </td>
        </tr>
        <tr> 
          <td>Status Obat</td>
          <td>:</td>
          <td> <select name="obat_isaktif" id="obat_isaktif">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select> </td>
        </tr>
      </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('obat_kode,obat_nama,obat_satuan_kecil,obat_bentuk,kls_id','ind')){document.form1.submit();}">
  <img src="../icon/save.gif" border="0" width="16" height="16" align="absmiddle">
    &nbsp;Simpan</BUTTON>
   <BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR OBAT</span>
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="right">&nbsp;</td>
	    </tr>
		<tr>
          <td width="340">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" class="txtinput" id="status" onChange="location='?f=../master/obat&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
       	  </select>		  </td>
          <td width="340">&nbsp;</td>
          <td width="137" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block';fSetValue(window,'act*-*save*|*obat_kode*-*<?php echo $mkode; ?>*|*obat_nama*-**|*obat_dosis*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>		  </td>
	    </tr>
	</table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="OBAT_ID" width="34" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
          <td width="70" class="tblheader" id="OBAT_KODE" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <!--td id="PABRIK" width="122" class="tblheader" onClick="ifPop.CallFr(this);">Pabrik </td-->
          <!--td id="OBAT_SATUAN_BESAR" width="51" class="tblheader" onClick="ifPop.CallFr(this);">Satuan Besar</td-->
          <td id="OBAT_SATUAN_KECIL" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Satuan 
            Kecil</td>
          <!--td id="ISI_SATUAN_KECIL" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Isi Satuan</td-->
          <td id="OBAT_BENTUK" width="64" class="tblheader" onClick="ifPop.CallFr(this);">Bentuk</td>
          <td id="KLS_NAMA" width="150" class="tblheader" onClick="ifPop.CallFr(this);">Kelas</td>
          <td id="aok.kategori" width="84" class="tblheader" onClick="ifPop.CallFr(this);">Kategori</td>
          <td id="aoj.obat_jenis" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Jenis</td>
          <td id="aog.golongan" width="67" class="tblheader" onClick="ifPop.CallFr(this);">Gol</td>
          <td width="42" class="tblheader">Habis Pakai</td>
          <td class="tblheader" colspan="2">Proses</td>
        </tr>
        <?php 
/*	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }*/
	  if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT a_obat.*, a_pabrik.PABRIK, a_kelas.KLS_NAMA, aoj.obat_jenis,aog.golongan,aok.kategori 
	  From a_obat LEFT JOIN a_pabrik ON a_obat.PABRIK_ID = a_pabrik.PABRIK_ID
	  LEFT JOIN a_kelas ON a_obat.KLS_ID = a_kelas.KLS_ID LEFT JOIN a_obat_kategori aok ON a_obat.OBAT_KATEGORI=aok.id 
		LEFT JOIN a_obat_golongan aog ON a_obat.OBAT_GOLONGAN=aog.kode LEFT JOIN a_obat_jenis aoj ON a_obat.OBAT_KELOMPOK=aoj.obat_jenis_id 
	  where OBAT_ISAKTIF=$status".$filter." ORDER BY ".$sorting;
	  //echo $sql."<br>";
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
		$arfvalue="act*-*edit*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_kode*-*".$rows['OBAT_KODE']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*obat_dosis*-*".$rows['OBAT_DOSIS']."*|*obat_satuan_kecil*-*".$rows['OBAT_SATUAN_KECIL']."*|*obat_bentuk*-*".$rows['OBAT_BENTUK']."*|*kls_id*-*".$rows['KLS_ID']."*|*kls_nama*-*".$rows['KLS_NAMA']."*|*obat_kategori*-*".$rows['OBAT_KATEGORI']."*|*jenis_obat*-*".$rows['OBAT_KELOMPOK']."*|*obat_golongan*-*".$rows['OBAT_GOLONGAN']."*|*obat_isaktif*-*".$rows['OBAT_ISAKTIF'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <!--td class="tdisi" align="left">&nbsp;<?php echo $rows['PABRIK']; ?></td-->
          <!--td align="cener" class="tdisi">&nbsp;<?php echo $rows['OBAT_SATUAN_BESAR']; ?></td-->
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <!--td align="center" class="tdisi">&nbsp;<?php echo $rows['ISI_SATUAN_KECIL']; ?></td-->
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_BENTUK']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['KLS_NAMA']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['kategori']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['obat_jenis'];?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['golongan'];?></td>
          <td align="center" class="tdisi">&nbsp; 
            <?php if($rows['HABIS_PAKAI']==1){echo "Ya";}else{echo "Tidak";} ?>
          </td>
          <td width="22" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
          <td width="23" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" class="textpaging">Ke Halaman: 
            <input type="text" name="keHalaman" id="keHalaman" class="txtinput" size="1"> 
            <button type="button" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
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
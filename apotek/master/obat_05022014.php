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
$kode_paten=$_REQUEST['kode_paten'];
$id_paten=$_REQUEST['id_paten'];if ($id_paten=="") $id_paten="0";
$obat_isaktif=$_REQUEST['obat_isaktif'];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
if ($kls_id=="") $kls_id=0;
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
			$sql="insert into a_obat (OBAT_ID,OBAT_KODE,OBAT_NAMA,PABRIK_ID,OBAT_DOSIS,OBAT_SATUAN_BESAR,OBAT_SATUAN_KECIL,ISI_SATUAN_KECIL,OBAT_BENTUK,KLS_ID,OBAT_KATEGORI,OBAT_KELOMPOK,OBAT_GOLONGAN,HABIS_PAKAI,ID_PATEN,KODE_PATEN,OBAT_ISAKTIF) values('','$obat_kode','$obat_nama','$pabrik_id','$obat_dosis','$obat_satuan_besar','$obat_satuan_kecil','$isi_satuan_kecil','$obat_bentuk',$kls_id,$obat_kategori,$jenis_obat,'$obat_golongan',$habis_pakai,'$id_paten','$kode_paten',$obat_isaktif)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		break;
	case "edit":
			$sql="update a_obat set OBAT_KODE='$obat_kode',OBAT_NAMA='$obat_nama',PABRIK_ID='$pabrik_id',OBAT_DOSIS='$obat_dosis',OBAT_SATUAN_BESAR='$obat_satuan_besar',OBAT_SATUAN_KECIL='$obat_satuan_kecil',ISI_SATUAN_KECIL='$isi_satuan_kecil',OBAT_BENTUK='$obat_bentuk',KLS_ID=$kls_id,OBAT_KATEGORI=$obat_kategori,OBAT_KELOMPOK=$jenis_obat, OBAT_GOLONGAN='$obat_golongan',HABIS_PAKAI=$habis_pakai,ID_PATEN='$id_paten',KODE_PATEN='$kode_paten',OBAT_ISAKTIF=$obat_isaktif where OBAT_ID=$obat_id";
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
<SCRIPT language="JavaScript" src="../theme/js/tip.js"></SCRIPT>
<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>

<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
<script type="text/javascript" src="../theme/li/prototype.js"></script>
<script type="text/javascript" src="../theme/li/effects.js"></script>
<script type="text/javascript" src="../theme/li/popup.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="popGrPet" style="display:none; width:800px;height:auto" class="popup">
<table width="750" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="2" align="right"><img alt="close" src="../icon/x.png" width="32" style="float:right; cursor: pointer" class="popup_closebox" /></td>
    </tr>
    <tr>
        <td colspan="2" class="font" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" class="font" align="center" style="font:Verdana, Geneva, sans-serif"><b>FORM MASTER KELAS TERAPI</b></td>
    </tr>
    <tr>
        <td colspan="2" class="font" align="center">&nbsp;</td>
    </tr>
        <tr id="trObat">
            <td width="150" style="font:Verdana, Geneva, sans-serif;">Induk</td>
            <td>:&nbsp;<input id="nm_induk" name="nm_induk" type="text" size="60" class="txtinput" value="">
            <input class="txtcenter" type="button" onClick="OpenWnd('../master/tree_kls_diobat1.php?par=nm_induk*kd_induk*id_induk*level',800,500,'msma',true)" title="Pilih Kelas" value="..." name="Button">
            </td>
        </tr>
        <tr id="trObat">
            <td width="150" style="font:Verdana, Geneva, sans-serif;">Kode Induk</td>
            <td>:&nbsp;<input id="kd_induk" name="kd_induk" type="text" size="11" class="txtinput" value="">
            <input type="hidden" id="id_induk" name="id_induk">
            </td>
        </tr>
        <tr id="trObat">
            <td width="150" style="font:Verdana, Geneva, sans-serif;">Nama Anak</td>
            <td>:&nbsp;<input id="nm_anak" name="nm_anak" type="text" size="60" class="txtinput" value="">
            <input type="hidden" id="level" name="level">
            <input type="hidden" id="id_kls_Terapi" name="id_kls_Terapi">
            </td>
        </tr>
        <tr id="trObat">
            <td width="150" style="font:Verdana, Geneva, sans-serif;">Kode Anak</td>
            <td>:&nbsp;<input id="kd_anak" name="kd_anak" type="text" size="11" class="txtinput" value="">
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">&nbsp;</td>
       </tr>
        <tr>
        	<td colspan="2" align="center">
            <div id="gridboxtab1" style="width:750px; height:200px; background-color:white; overflow:hidden;"></div>
			<div id="pagingtab1" style="width:750px;"></div>
            </td>
        </tr>
    <tr>
        <td colspan="2" align="center" height="50" valign="bottom">
        <button id="sim" name="sim" value="Tambah" type="button" style="cursor:pointer" onClick="TglPOSimpan(this.value)"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button> 
        <button type="button" id="btnHapus1" name="btnHapus1" style="cursor:pointer" onClick="hapus1();" disabled><img src="../icon/cancel.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>  
        <button type="button" id="batal" name="batal" style="cursor:pointer" onClick="bersih1();"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
    </tr>
</table>
</div>
<DIV id="TipLayer" style="visibility:hidden;position:absolute; z-index:1000; top:-100;"></DIV>
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
      <p class="jdltable">Input Data Obat / Alat Kesehatan / Reagensia </p>
      <table width="75%" border="0" cellpadding="1" cellspacing="1" class="txtinput">
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
          <td><span onClick="tampil1();" style="color:#00F; cursor:pointer;"><u>Kelas Terapi</u></span></td>
          <td>:</td>
          <td > <input type="hidden" name="kls_id" id="kls_id" value="<?=$_POST[kls_id];?>"> 
            <input type="text" name="kls_nama" id="kls_nama" class="txtinput" value="<?=$_POST[kode_kls_induk];?>"readonly> 
            <input type="button" name="Button" value="..." class="txtcenter" title="Pilih Kelas" onClick="OpenWnd('../master/tree_kls_diobat.php?par=kls_id*kls_nama',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kls_id*-**|*kls_nama*-*')">          </td>
        </tr>
        <tr> 
          <td>Kategori Obat / Alkes </td>
          <td>:</td>
          <td> <select name="obat_kategori" id="obat_kategori" onChange="if (this.value==1 || this.value==2 ||this.value==4){document.forms[0].btnPaten.disabled='';}else{document.forms[0].id_paten.value='0';document.forms[0].kode_paten.value='';document.forms[0].btnPaten.disabled='disabled';}">
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
          <option value="0">-</option>
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
        <tr style="display:none;">
          <td>Generik/Paten Sejenis </td>
          <td>:</td>
          <td ><input type="hidden" name="id_paten" id="id_paten" value="0"><input name="kode_paten" type="text" id="kode_paten" class="txtinput" size="38" readonly />
          <input type="button" name="btnPaten" value="..." class="txtcenter" title="Pilih Obat Paten-nya" onClick="OpenWnd('../master/ms_obat_paten.php?par=id_paten*kode_paten&id_paten='+document.forms[0].id_paten.value,750,350,'mspaten',true)"></td>
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
  <p><BUTTON type="button" onClick="if (ValidateForm('obat_kode,obat_nama,obat_satuan_kecil,obat_bentuk','ind')){document.form1.submit();}">
  <img src="../icon/save.gif" border="0" width="16" height="16" align="absmiddle">
    &nbsp;Simpan</BUTTON>
   <BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">DAFTAR OBAT / ALAT KESEHATAN / REAGENSIA</span>
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="right">&nbsp;</td>
	    </tr>
		<tr>
          <td width="340" style="font:bold 12px tahoma;">&nbsp;Status&nbsp;:&nbsp;
            <select name="status" class="txtinput" id="status" onChange="location='?f=../master/obat&status='+this.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
       	  </select>		  </td>
          <td width="340">&nbsp;</td>
          <td width="137" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block';fSetValue(window,'act*-*save*|*obat_kode*-*<?php echo $mkode; ?>*|*obat_nama*-**|*obat_dosis*-**|*id_paten*-*0*|*kode_paten*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
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
		$arfvalue="act*-*edit*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_kode*-*".$rows['OBAT_KODE']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*obat_dosis*-*".$rows['OBAT_DOSIS']."*|*obat_satuan_kecil*-*".$rows['OBAT_SATUAN_KECIL']."*|*obat_bentuk*-*".$rows['OBAT_BENTUK']."*|*kls_id*-*".$rows['KLS_ID']."*|*kls_nama*-*".$rows['KLS_NAMA']."*|*obat_kategori*-*".$rows['OBAT_KATEGORI']."*|*jenis_obat*-*".$rows['OBAT_KELOMPOK']."*|*obat_golongan*-*".$rows['OBAT_GOLONGAN']."*|*obat_isaktif*-*".$rows['OBAT_ISAKTIF']."*|*id_paten*-*".$rows['ID_PATEN']."*|*kode_paten*-*".$rows['KODE_PATEN'];
		
		 $id_paten=$rows["ID_PATEN"];
		 $obat_kat=$rows["OBAT_KATEGORI"];
		 $txtpaten="";
		 if ($obat_kat==1 or $obat_kat==2 or $obat_kat==4){
		 	$sql="SELECT * FROM a_obat WHERE OBAT_ID IN ($id_paten)";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
			while ($rows1=mysqli_fetch_array($rs1)){
				$txtpaten .=$rows1["OBAT_KODE"]." - ".$rows1["OBAT_NAMA"]."<br>";
			}
			mysqli_free_result($rs1);
		 }
		 
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*obat_id*-*".$rows['OBAT_ID'];
	  ?>
					  	  <script>
							Text[<?php echo $i; ?>]=["Obat Patennya","<?php echo $txtpaten; ?>"];
							Style=["white","black","#000099","#E8E8FF","","","","","","","","","","",400,"",2,2,10,10,51,0.5,75,"simple","gray"];			
							applyCssFilter()
						  </script>
        <input type="hidden" id="arf<?php echo $i; ?>" value="<?php echo $arfvalue; ?>" />
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['OBAT_BENTUK']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['KLS_NAMA']; ?></td>
          <td align="center" class="tdisi">&nbsp;<?php if ($obat_kat==1 or $obat_kat==2 or $obat_kat==4) echo '<a href="#" onMouseOver="stm(Text['.$i.'],Style)" onMouseOut="htm()">'.$rows['kategori'].'</a>'; else echo $rows['kategori']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['obat_jenis'];?></td>
          <td align="center" class="tdisi">&nbsp;<?php echo $rows['golongan'];?></td>
          <td align="center" class="tdisi">&nbsp; 
            <?php if($rows['HABIS_PAKAI']==1){echo "Ya";}else{echo "Tidak";} ?>
          </td>
          <td width="22" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetVariabel('arf<?php echo $i; ?>');if (obat_kategori.value==1 || obat_kategori.value==2 ||obat_kategori.value==4){document.forms[0].btnPaten.disabled='';}else{document.forms[0].id_paten.value='0';document.forms[0].kode_paten.value='';document.forms[0].btnPaten.disabled='disabled';}"></td>
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
<script>
	var indukLama;
	
	function fSetVariabel(p){
		fSetValue(window,document.getElementById(p).value);
	}
	function tampil1()
	{
		bersih1();
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
	}
	
	function ambilData()
	{
		
	}
	
	function TglPOSimpan(action)
	{
		var nama = document.getElementById("nm_anak").value;
		var kd_anak = document.getElementById("kd_anak").value;
		var level = document.getElementById("level").value;
		var id_induk = document.getElementById("id_induk").value;
		var id_kls_terapi = document.getElementById("id_kls_Terapi").value;
		level = Number(level) + 1;
		//alert(level);
		
		if(action == "Tambah")
		{
			r.loadURL("../master/klsterapi_utils.php?grd=true&grdDet=true&act="+action+"&nama="+nama+"&kd_anak="+kd_anak+"&level="+level+"&id_induk="+id_induk,"","GET");	
		}else if(action == "Simpan"){
			r.loadURL("../master/klsterapi_utils.php?grd=true&grdDet=true&act="+action+"&nama="+nama+"&kd_anak="+kd_anak+"&level="+level+"&id_induk="+id_induk+"&id_terapi="+id_kls_terapi+"&id_inLama="+indukLama,"","GET");	
		}
		
		bersih1();
	}
	
	function bersih1()
	{
		document.getElementById("nm_induk").value = "";
		document.getElementById("kd_induk").value = "";
		document.getElementById("nm_anak").value = "";
		document.getElementById("kd_anak").value = "";
		document.getElementById("id_induk").value = "";
		document.getElementById("level").value = "";
		document.getElementById("id_kls_Terapi").value = "";
		document.getElementById("sim").value = "Tambah";
		document.getElementById("btnHapus1").disabled = true;
	}
	
	function ambilData()
	{
		var sisip = r.getRowId(r.getSelRow()).split('|');
		document.getElementById("nm_induk").value = sisip[3];
		document.getElementById("kd_induk").value = sisip[5];
		document.getElementById("nm_anak").value = sisip[2];
		document.getElementById("kd_anak").value = sisip[1];
		document.getElementById("id_induk").value = sisip[4];
		indukLama = sisip[4];
		document.getElementById("level").value = sisip[6];
		document.getElementById("id_kls_Terapi").value = sisip[0];
		document.getElementById("sim").value = "Simpan";
		document.getElementById("btnHapus1").disabled = false;
		//alert(indukLama);
	}
	
	function hapus1()
	{
		var nama = document.getElementById("nm_anak").value;
		var kd_anak = document.getElementById("kd_anak").value;
		var level = document.getElementById("level").value;
		var id_induk = document.getElementById("id_induk").value;
		var id_kls_terapi = document.getElementById("id_kls_Terapi").value;
		
		r.loadURL("../master/klsterapi_utils.php?grd=true&grdDet=true&act=hapus&nama="+nama+"&kd_anak="+kd_anak+"&level="+level+"&id_induk="+indukLama+"&id_terapi="+id_kls_terapi,"","GET");
		bersih1()		
	}
	function ambilData1()
	{
		
	}
	
	function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridboxtab1"){
                r.loadURL("../master/klsterapi_utils.php?grd=true&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage(),"","GET");
            }
    }
	
	var r=new DSGridObject("gridboxtab1");
	r.setHeader("DATA KELAS TERAPI");
	r.setColHeader("NO,KODE,NAMA,INDUK");
	r.setIDColHeader(",a.kls_kode,a.KLS_NAMA,");
	r.setColWidth("30,80,200,150");
	r.setCellAlign("center,center,left,center");
	r.setCellType("txt,txt,txt,txt");
	r.setCellHeight(20);
	r.setImgPath("../icon");
	r.setIDPaging("pagingtab1");
	r.attachEvent("onRowClick","ambilData");
	//r.attachEvent("onRowDblClick","pelayananResep");
	r.onLoaded(ambilData1);
	r.baseURL("../master/klsterapi_utils.php?grd=true");
	r.Init();
</script>
</html>
<?php 
mysqli_close($konek);
?>
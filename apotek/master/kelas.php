<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================

//Mengambil induk dan merujuk pada tree ====
$qstr_ma="par=kls_induk*kode_kls_induk*nm_kls_induk*kls_level";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
//==========================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$kls_id=$_REQUEST['kls_id'];
$kls_id=mysqli_real_escape_string($konek,$_REQUEST['kls_id']);
//$kls_nmr=$_REQUEST['kls_nmr'];
$kls_nmr=mysqli_real_escape_string($konek,$_REQUEST['kls_nmr']);

//$kls_kode=$_REQUEST['kls_kode'];
$kls_kode=mysqli_real_escape_string($konek,$_REQUEST['kls_kode']);
	//$kls_kode_update=$_REQUEST['kode_kls_induk'].$kls_kode;
	$kls_kode_update=mysqli_real_escape_string($konek,$_REQUEST['page']).$kls_kode;
//$kls_nama=$_REQUEST['kls_nama'];
$kls_nama=mysqli_real_escape_string($konek,$_REQUEST['kls_nama']);
$k_in = mysqli_real_escape_string($konek,$_REQUEST['kls_induk']);
if($k_in=="") {$kls_induk=0;}else{ $kls_induk=$k_in;}
$kls_islast=1;
$kls_level=$_REQUEST['kls_level'];
$kls_level=mysqli_real_escape_string($konek,$_REQUEST['kls_levelkls_level']);
	$kls_lvl_update=$kls_level+1;
//====================================================================

//Paging,Sorting dan Filter======
$defaultsort="KLS_ID asc";
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
	//==Cek apakah kode atau nama sudah terpakai/sudah ada pada tabel?jika sudah ada, cegat!!==
		$sql="select * from a_kelas where KLS_KODE='$kls_kode' and KLS_NAMA='$kls_nama'";
		//echo $sql;
		$rs1=mysqli_query($konek,$sql);
		if (mysqli_num_rows($rs1)>0){
			echo "<script>alert('Kode atau Nama Sudah Ada, Silahkan Masukkan Kode/Nama Lain');</script>";
	//======Cek kode atau nama di tabel berakhir ===========
	//==============Input Data=========================
		}else{
		$sql2="insert into a_kelas(KLS_ID,KLS_NMR,KLS_KODE,KLS_NAMA,KLS_LEVEL,KLS_INDUK,KLS_ISLAST) values('','$kls_nmr','$kls_kode_update','$kls_nama',$kls_lvl_update,$kls_induk,$kls_islast)";
			//echo $sql2;
		$rs2=mysqli_query($konek,$sql2);
	//===========Input Data Berakhir ==================
	//====Jika Mempunyai Induk, Update ISLAST induk dari 1 menjadi 0 =====
		if ($kls_induk>0)
			{
			$sql="update a_kelas set KLS_ISLAST=0 where KLS_ID=$kls_induk";
			//echo $sql;
		$rs=mysqli_query($konek,$sql);
			}
	//============update islast berakhir =================================
		}
		mysqli_free_result($rs1);
		break;
	case "edit":
	//==Cek apakah kode atau nama sudah terpakai/sudah ada pada tabel?jika sudah ada, cegat!!==
		$sql="select * from a_kelas where KLS_NMR='$kls_nmr' and KLS_KODE='$kls_kode' and KLS_NAMA='$kls_nama' and KLS_INDUK='$kls_induk'";
		//echo $sql;
		$rs1=mysqli_query($konek,$sql);
		if (mysqli_num_rows($rs1)>0){
			echo "<script>alert('Kode atau Nama Sudah Ada, Silahkan Masukkan Kode/Nama Lain');</script>";
	//======Cek kode atau nama di tabel berakhir ===========
	//==============Update Data=========================
		}else{
			$sql2="update a_kelas set KLS_NMR='$kls_nmr',KLS_KODE='$kls_kode_update',KLS_NAMA='$kls_nama',KLS_INDUK='$kls_induk',KLS_ISLAST='$kls_islast' where KLS_ID=$kls_id";
			//echo $sql2;
			$rs2=mysqli_query($konek,$sql2);
	//====Jika Mempunyai Induk, Update ISLAST induk dari 1 menjadi 0 =====
			if ($kls_induk>0)
				{
				$sql="update a_kelas set KLS_ISLAST=0 where KLS_ID=$kls_induk";
				//echo $sql;
				$rs=mysqli_query($konek,$sql);
				}
	//============update islast berakhir =================================
		}
		mysqli_free_result($rs1);
		break;
	case "delete":
		$sql="delete from a_kelas where KLS_ID=$kls_id";
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
  	<input name="kls_id" id="kls_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Jenis Obat </p>
      <table width="75%" border="0" cellpadding="1" cellspacing="1" class="txtinput">
	<tr>
       <td>Kode Jenis Obat Induk </td>
	   <td>:</td>
	   	<!-- FORM LEVEL KELAS INDUK DAN KODE KELAS INDUK DI HIDDEN-->
	   	<input type="hidden" name="kls_induk" id="kls_induk" value="<?=$_POST[kls_induk];?>">
	   	<input type="hidden" name="kls_level" id="kls_level" value="<?=$_POST[kls_level];?>">
	   	<!-- HIDDEN BERAKHIR -->
	   <td >
	   	   <input type="text" name="kode_kls_induk" id="kode_kls_induk" class="txtinput" value="<?=$_POST[kode_kls_induk];?>"readonly>
            <input type="button" name="Button" value="..." class="txtcenter" title="Pilih Kelas Induk" onClick="OpenWnd('../master/tree_kls.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kls_induk*-**|*kode_kls_induk*-**|*nm_kls_induk*-**|*kls_level*-*')">
		</td>
	</tr>
    <tr>
      <td>Nama Jenis Obat Induk </td>
      <td>:</td>
          <td ><textarea name="nm_kls_induk" cols="50" rows="1" id="nm_kls_induk" class="txtinput" readonly><?=$_POST[nm_kls_induk];?></textarea></td>
    </tr>
	<tr>
      <tr>
      <td>Nomor Jenis Obat </td>
      	<td>:</td>
        <td ><input name="kls_nmr" type="text" id="kls_nmr" class="txtinput" size="10" ></td>
    </tr>
      <tr>
        <td>Kode Jenis Obat </td>
        <td>:</td>
        <td ><input name="kls_kode" type="text" id="kls_kode" class="txtinput" size="10" ></td>
      </tr>
      <tr>
        <td>Nama Jenis Obat </td>
        <td>:</td>
        <td ><textarea name="kls_nama" id="kls_nama" class="txtinput" cols="50"></textarea></td>
      </tr>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kls_nmr,kls_kode,kls_nama','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">JENIS OBAT  </span>
  <table width="59%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="657" align="right">
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*kls_induk*-**|*kls_level*-**|*kode_kls_induk*-**|*nm_kls_induk*-**|*kls_nmr*-**|*kls_kode*-**|*kls_nama*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table width="601" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="KLS_ID" width="33" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <!--td id="KLS_NMR" width="121" class="tblheader" onClick="ifPop.CallFr(this);">No. Gol </td-->
		<td id="KLS_KODE" width="131" class="tblheader" onClick="ifPop.CallFr(this);">Kode Jenis Obat </td>
		<td id="KLS_NAMA" width="368" class="tblheader" onClick="ifPop.CallFr(this);">Nama Jenis Obat </td>
		<!--td id="KLS_INDUK" width="116" class="tblheader" onClick="ifPop.CallFr(this);">Kelas Induk</td>
		<td id="KLS_ISLAST" width="116" class="tblheader" onClick="ifPop.CallFr(this);">Kelas Islast</td-->
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * FROM a_kelas".$filter." ORDER BY ".$sorting;
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
		$arfvalue="act*-*edit*|*kls_id*-*".$rows['KLS_ID']."*|*kls_nmr*-*".$rows['KLS_NMR']."*|*kls_kode*-*".$rows['KLS_KODE']."*|*kls_nama*-*".$rows['KLS_NAMA']."*|*kls_induk*-*".$rows['KLS_INDUK']."*|*kls_islast*-*".$rows['KLS_ISLAST'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*kls_id*-*".$rows['KLS_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <!--td class="tdisi" align="left"><?php echo $rows['KLS_NMR']; ?></td-->
        <td align="center" class="tdisi"><?php echo $rows['KLS_KODE']; ?></td>
		<td align="left" class="tdisi"><?php echo $rows['KLS_NAMA']; ?></td>
		<!--td align="left" class="tdisi"><?php echo $rows['KLS_INDUK']; ?></td> 
		<td align="left" class="tdisi"><?php echo $rows['KLS_ISLAST']; ?></td-->
        <td width="25" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
        <td width="34" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
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
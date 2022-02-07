<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$exp=$_REQUEST["exp"];
$exp=mysqli_real_escape_string($konek,$_REQUEST['exp']);
//====================================================================

//Paging,Sorting dan Filter======
$defaultsort="BENTUK desc";
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
		$sql="UPDATE a_expired_limit SET batas=$exp";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="SELECT * FROM a_expired_limit";
//echo $sql;
$rs=mysqli_query($konek,$sql);

if ($rows=mysqli_fetch_array($rs)){
	$bts=$rows['batas'];
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
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:block">
      <p class="jdltable">BATAS TOLERANSI OBAT EXPIRED</p>
    <table width="30%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
      <td>Toleransi Obat Expired </td>
      	<td>:</td>
        <td ><select id="exp" name="exp">
        	<?php 
				for ($i=1;$i<12;$i++){
			?>
        	<option value="<?php echo $i; ?>"<?php if ($i==$bts) echo " selected";?>><?php echo $i." Bulan"; ?></option>
            <?php }?>
        </select></td>
      </tr>
  </table>
  <p><BUTTON type="button" onClick="document.form1.submit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p>
  <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td width="200" class="tblheaderkiri" id="BENTUK" onClick="ifPop.CallFr(this);">Toleransi Expired </td>
        </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" align="center"><?php echo $bts." Bulan"; ?></td>
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
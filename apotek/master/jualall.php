<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$unit_id=$_REQUEST['unit_id'];
$unit_name=$_REQUEST['unit_name'];
$unit_tipe=$_REQUEST['unit_tipe'];
$unit_isaktif=$_REQUEST['unit_isaktif'];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="obat_id asc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
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
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
  <p><span class="jdltable">STOK SELURUH UNIT</span>
  <table border="0" cellspacing="0" cellpadding="1">
      <tr class="headtable">
        <td id="obat" width="34" class="tblheaderkiri" onClick="ifPop.CallFr(this);">&nbsp;</td>
        <td id="kepemilikan" width="249" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="unit1" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*01</td>
        <td id="unit2" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*02</td>
		<td id="unit3" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*03</td>
		<td id="unit4" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*04</td>
		<td id="unit5" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*05</td>
		<td id="unit6" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*06</td>
		<td id="unit7" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*07</td>
		<td id="unit8" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*08</td>
		<td id="unit9" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*09</td>
		<td id="unit10" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*10</td>
		<td id="unit11" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*11</td>
		<td id="unit12" width="32" class="tblheader" onClick="ifPop.CallFr(this);">*12</td>
		<td id="total" width="44" class="tblheader" onClick="ifPop.CallFr(this);">total</td>
			 
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select * from vjuallall";
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
		
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">&nbsp;</td>
        <td class="tdisi" align="left"><?php echo $rows['kepemilikan']; ?></td>
        <td align="right" class="tdisi">
		<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=1" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit1']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=2" onClick="NewWindow(this.href,'name','800','400','yes');return false">
				<?php echo $rows['unit2']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=3" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit3']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=4" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit4']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=5" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit5']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=6" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit6']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=7" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit7']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=8" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit8']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=9" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit9']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=10" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit10']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=11" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit11']; ?></a></td>
		<td align="right" class="tdisi">
				<a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=12" onClick="NewWindow(this.href,'name','800','400','yes');return false">
		<?php echo $rows['unit12']; ?></a></td>
		<td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="10" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
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
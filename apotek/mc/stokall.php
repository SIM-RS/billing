<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	header("Location: ../../index.php");
	exit();
}
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="obat_id asc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
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
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
<!-- Script Pop Up Window Berakhir -->
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 150px; visibility: hidden">
</iframe>
</head>
<body>
<div align="center">  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <?php include("header.php");?>
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="listma" style="display:block">
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center">
  <p><span class="jdltable">STOK SELURUH UNIT</span></p>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit1" width="36" class="tblheader" onClick="ifPop.CallFr(this);">GD</td>
          <td id="unit2" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP1</td>
          <td id="unit3" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP2</td>
          <td id="unit4" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP3</td>
          <td id="unit5" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP4</td>
          <td id="unit6" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP5</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP8</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP10</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP11</td>
          <td id="unit10" width="36" class="tblheader" onClick="ifPop.CallFr(this);">PR</td>
          <td id="unit11" width="36" class="tblheader" onClick="ifPop.CallFr(this);">FS</td>
          <td id="total" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ntotal" width="51" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select o.OBAT_NAMA as obat,m.NAMA as kepemilikan,v.*,unit1+unit2+unit3+unit4+unit5+unit6+unit9+unit11+unit12+unit17+unit20 as total,ntotal
from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter." ORDER BY ".$sorting;
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
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['obat']; ?></td>
          <td class="tdisi"><?php echo $rows['kepemilikan']; ?></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=1" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit1']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=2" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit2']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=3" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit3']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=4" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit4']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=5" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit5']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=6" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit6']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=9" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit9']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=11" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit11']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=12" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit12']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=17" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit17']; ?></a></td>
          <td align="right" class="tdisi"> <a href="../master/kartu_stok.php?obat_id=<?php echo $rows['obat_id'];?>&kepemilikan_id=<?php echo $rows['KEPEMILIKAN_ID'];?>&unit_id=20" onClick="NewWindow(this.href,'name','700','400','yes');return false"> 
            <?php echo $rows['unit20']; ?></a></td>
          <td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['ntotal'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  $sql="select sum(ntotal) as jml_tot from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter;
	  $rs=mysqli_query($konek,$sql);
	  $show=mysqli_fetch_array($rs);
	  $show['jml_tot'];
	  ?>
        <tr> 
          <td colspan="9"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td>
          <td colspan="5" align="right"><span class="style1"><strong>Nilai Total :&nbsp;&nbsp;</strong></span></td>
          <td colspan="2" align="right"><span class="style1"><strong><?php echo number_format($show['jml_tot'],0,",","."); ?></strong></span></td>
        </tr>
        <tr> 
          <td colspan="9" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="7" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  </div>
</form>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
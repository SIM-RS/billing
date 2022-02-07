<?php 
include("../koneksi/konek.php");
$idkg=$_REQUEST['idkg'];
$ta=$_REQUEST['ta'];//echo $ta;
//$lvlpilih=$_REQUEST['lvlpilih'];//echo $lvlpilih;
$kodekg=$_REQUEST['kodekg'];
$kg=$_REQUEST['kg'];
$lvl=$_REQUEST['lvl'];

$page=$_REQUEST["page"];
$defaultsort="KG_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<html>
<head>
<title>Data Master Kegiatan</title>
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
    <input name="idkegiatan" id="idkegiatan" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input name="filter" id="filter" type="hidden" value="<?php echo $filter; ?>">
    <p class="jdltable">Daftar Rencana Strategis 
    <table width="85%" border="0" cellspacing="0" cellpadding="4">
      <tr class="headtable"> 
        <td width="5%" class="tblheaderkiri">No</td>
        <td id="KG_KODE" width="17%" class="tblheader" onClick="ifPop.CallFr(this);">Kode Renstra</td>
        <td id="KG_KET" width="78%" class="tblheader" onClick="ifPop.CallFr(this);">Nama Renstra</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, * from KEGIATAN where KG_TAHUN='$ta' and KG_ISLAST=1".$filter;
	  $sql="select kg_id from KEGIATAN where KG_TYPE=1 and KG_TAHUN<=$ta and KG_TAHUN1>=$ta and KG_ISLAST=1".$filter;
	  //echo $sql."<br>";
	  $rskg=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page="1";
  	//$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$perpage=20;$tpage=($page-1)*$perpage;
  	$jmldata=mysql_num_rows($rskg);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
  	$sql="select top $perpage * from KEGIATAN where KG_TYPE=1 and KG_TAHUN<=$ta and KG_TAHUN1>=$ta and KG_ISLAST=1 and kg_id not in (select top $tpage kg_id from KEGIATAN where KG_TYPE=1 and KG_TAHUN<=$ta and KG_TAHUN1>=$ta and KG_ISLAST=1".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rskg=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  while ($rowskg=mysql_fetch_array($rskg)){
	  	$i++;
	  	$arfvalue=$idkg."*-*".$rowskg['KG_ID']."*|*".$kodekg."*-*".$rowskg['KG_KODE']."*|*".$kg."*-*".$rowskg['KG_KET']."*|*".$lvl."*-*".$rowskg['KG_LEVEL'];
	  ?>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Kegiatan" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'<?php echo $arfvalue; ?>');window.close();"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi"><?php echo $rowskg['KG_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $rowskg['KG_KET']; ?></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rskg);
	  ?>
      <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
    </table>
  </p>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
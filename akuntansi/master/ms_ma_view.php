<?php 
include("../koneksi/konek.php");
$par=$_REQUEST['par'];
$par=explode("*",$par);
$idma=$_REQUEST['idma'];
$kodema=$_REQUEST['kodema'];
$ma=$_REQUEST['ma'];
$lvl=$_REQUEST['lvl'];

$page=$_REQUEST["page"];
$defaultsort="MA_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<html>
<head>
<title>Master Data Mata Anggaran</title>
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
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input name="filter" id="filter" type="hidden" value="<?php echo $filter; ?>">
<p><br>
      <span class="jdltable"> Daftar Mata Anggaran</span> 
    <table width="90%" border="0" cellspacing="0" cellpadding="4">
      <tr class="headtable"> 
        <td width="5%" class="tblheaderkiri">No</td>
        <td id="MA_KODE" width="17%" class="tblheader" onClick="ifPop.CallFr(this);">Kode Mata Anggaran</td>
        <td id="MA_JENIS" width="7%" class="tblheader" onClick="ifPop.CallFr(this);">Jenis MA</td>
        <td id="MA_NAMA" width="88%" class="tblheader" onClick="ifPop.CallFr(this);">Nama Mata Anggaran </td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, * from MA where MA_AKTIF=1".$filter;
	  $sql="select ma_id from MA where MA_AKTIF=1 and MA_ISLAST=1".$filter;
	  $rsma=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page="1";
  	//$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$perpage=20;$tpage=($page-1)*$perpage;
  	$jmldata=mysql_num_rows($rsma);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	$sql="select top $perpage ma.*,jm.nama from MA inner join jenis_ma jm on ma.ma_jenis=jm.jenis_id where MA_AKTIF=1 and MA_ISLAST=1 and ma_id not in (select top $tpage ma_id from MA where MA_AKTIF=1 and MA_ISLAST=1".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rsma=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  while ($rowsma=mysql_fetch_array($rsma)){
	  	$i++;
	  ?>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'<?php echo $par[0]; ?>*-*<?php echo $rowsma['MA_ID']; ?>*|*<?php echo $par[1]; ?>*-*<?php echo $rowsma['MA_KODE']; ?>*|*<?php echo $par[2]; ?>*-*<?php echo $rowsma['MA_NAMA']; ?>*|*<?php echo $par[3]; ?>*-*<?php echo $rowsma['MA_LEVEL']; ?>');window.close();">
      <!--tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'<?php //echo $idma; ?>*-*<?php //echo $rowsma['MA_ID']; ?>*|*<?php //echo $kodema; ?>*-*<?php //echo $rowsma['MA_KODE']; ?>*|*<?php //echo $ma; ?>*-*<?php //echo $rowsma['MA_NAMA']; ?>*|*<?php //echo $lvl; ?>*-*<?php //echo $rowsma['MA_LEVEL']; ?>');window.close();"-->
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="left"><?php echo $rowsma['MA_KODE']; ?></td>
        <td class="tdisi" align="center"><?php echo $rowsma['nama']; ?></td>
        <td align="left" class="tdisi"><?php echo $rowsma['MA_NAMA']; ?></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rsma);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
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

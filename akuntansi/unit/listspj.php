<?php 
include("../koneksi/konek.php");

$idunit=1;
$page=$_REQUEST["page"];
$defaultsort = "spj_tahun,spj_bulan desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<html>
<head>
<title>Pengajuan Uang Muka</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
  	<input name="act" id="act" type="hidden" value="">
    <input name="viewby" id="viewby" type="hidden" value="<?php echo viewby; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <P>
	<table width="95%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td colspan="7" class="jdltable">Daftar SPJ Yang Dibuat </td>
      </tr>
      <tr class="headtable"> 
        <td width="25" class="tblheaderkiri">No</td>
        <td width="100" class="tblheader">Bulan/Tahun SPJ</td>
        <td id="ma_kode" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
		<td id="NO_SPJ" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No SPJ</td>
        <td id="TOTAL" width="140" class="tblheader" onClick="ifPop.CallFr(this);">Nilai SPJ<br>(Rp)</td>
        <td width="200" class="tblheader">Unit BAUK</td>
		<td width="100" class="tblheader">Status</td>
        <td width="30" class="tblheader">Detil</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum,spj.*,ma_kode from spj inner join ma on fk_idma=ma_id where fk_idunit=$idunit".$filter;
	  $sql="select spj.spj_id from spj inner join ma on fk_idma=ma_id where fk_idunit=$idunit".$filter;
	  //echo $sql;
	  $rs=mysql_query($sql);

	if ($page=="" || $page=="0") $page="1";
  	//$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$perpage=20;$tpage=($page-1)*$perpage;
  	$jmldata=mysql_num_rows($rs);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	$sql="select top $perpage spj.*,ma_kode,isnull(unit_nama,'-') unit from spj left join unit on spj.fk_unit_bauk=unit.unit_id inner join ma on fk_idma=ma_id where fk_idunit=$idunit and spj.spj_id not in (select top $tpage spj.spj_id from spj inner join ma on fk_idma=ma_id where fk_idunit=$idunit".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$idspj=$rows["SPJ_ID"];
		$status=$rows["STATUS"];
		switch($status){
			case 0:
				$status="Dibuat";
				$curl="?f=BuatSPJ&idspj=".$idspj."&ta=".$rows['SPJ_TAHUN']."&bulan=".$rows['SPJ_BULAN']."&fromfile=listspj";
				break;
			case 1:
				$status="Diajukan";
				$curl="?f=BuatSPJ&idspj=".$idspj."&view=viewspj";
				break;
			case 2:
				$status="Diterima";
				$curl="?f=BuatSPJ&idspj=".$idspj."&view=viewspj";
				break;
			case 3:
				$status="Direvisi";
				$curl="?f=BuatSPJ&idspj=".$idspj."&ta=".$rows['SPJ_TAHUN']."&bulan=".$rows['SPJ_BULAN']."&fromfile=listspj";
				break;
		}
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi"><?php echo $rows['SPJ_BULAN']."/".$rows['SPJ_TAHUN']; ?></td>
        <td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
        <td class="tdisi">&nbsp;<?php echo $rows['NO_SPJ']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['TOTAL'],0,",","."); ?></td>
		<td class="tdisi">&nbsp;<?php echo $rows['unit']; ?></td>
		<td class="tdisi">&nbsp;<?php echo $status; ?></td>
        <td class="tdisi"><a href="<?php echo $curl; ?>"><IMG SRC="../icon/lihat.gif" border="0" width="22" height="22" ALIGN="absmiddle" class="proses" title="Klik Untuk Melihat Data Detail SPJ Yg Diajukan"></a></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td align="right">&nbsp;</td>
		<td colspan="3" align="right">
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
<?php 
include("../koneksi/konek.php");

$idunit=$_SESSION['akun_ses_idunit'];

$page=$_REQUEST["page"];
$defaultsort="umk_id desc";
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
    <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <P>
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td colspan="7" class="jdltable">Daftar Pengajuan Uang Muka</td>
      </tr>
      <tr class="headtable"> 
        <td width="4%" class="tblheaderkiri">No</td>
        <td id="UMK_PERIODE" width="9%" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Pengajuan</td>
        <td id="UMK_NO" width="25%" class="tblheader" onClick="ifPop.CallFr(this);">No UMK</td>
        <!--td width="58%" class="tblheader">Unit Yg Mengajukan</td-->
        <td id="UMK_TOTAL" width="130" class="tblheader" onClick="ifPop.CallFr(this);">Nilai UMK<br>
          (Rp)</td>
        <td width="100" class="tblheader">Status</td>
		<td width="100" class="tblheader">Unit BAUK</td>
        <td class="tblheader" width="50">Detil</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="SELECT row_number() over(order by ".$sorting.") as rownum, *, convert(varchar, umk_periode, 101) as tgl from umk where umk_unitid=$idunit".$filter;
	  $sql="SELECT umk_id from umk where umk_unitid=$idunit".$filter;
	  //echo $sql."<br>";
	  $rs=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page="1";
  	//$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$perpage=15;$tpage=($page-1)*$perpage;
  	$jmldata=mysql_num_rows($rs);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	$sql="SELECT top $perpage *, convert(varchar, umk_periode, 101) as tgl,isnull(unit_nama,'-') unit from umk left join unit on umk.umk_unit_bauk=unit.unit_id where umk_unitid=$idunit and umk_id not in (SELECT top $tpage umk_id from umk where umk_unitid=$idunit".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$ctgl=$rows['tgl'];
		$ctgl=explode("/",$ctgl);
		$tgl=$ctgl[1]."-".$ctgl[0]."-".$ctgl[2];
		$status=$rows["UMK_STATUS"];
		$idumk=$rows["UMK_ID"];
		switch ($status){
			case 0:
				$status="Sedang Dibuat";
				$lnk="?f=inputumk&idumk=".$idumk."&ta=".$ctgl[2]."&fromfile=listumk";
				break;
			case 1:
				$status="Sudah Diajukan";
				$lnk="?f=inputumkview&idumk=".$idumk."&fromfile=listumk";
				break;
			case 2:
				$status="Direvisi";
				$lnk="?f=inputumk&idumk=".$idumk."&ta=".$ctgl[2]."&fromfile=listumk";
				break;
			case 3:
				$status="Disetujui";
				$lnk="?f=inputumkview&idumk=".$idumk."&fromfile=listumk";
				break;
		}
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi">&nbsp;<?php echo $tgl; ?></td>
        <td class="tdisi">&nbsp;<?php echo $rows['UMK_NO']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['UMK_TOTAL'],0,",","."); ?></td>
        <td class="tdisi"><?php echo $status; ?></td>
		<td class="tdisi"><?php echo $rows['unit']; ?></td>
        <td class="tdisi" align="center"><a href="<?php echo $lnk; ?>"><IMG SRC="../icon/lihat.gif" border="0" width="22" height="22" ALIGN="absmiddle" class="proses" title="Klik Untuk Melihat Data Detail Uang Muka Kegiatan Yg Diajukan"></a></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="4" align="right">
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
<?php 
include("../koneksi/konek.php");

$idunit=$_SESSION['akun_ses_idunit'];
$idumk=$_REQUEST['idumk'];if ($idumk=="") $idumk="0";
$fromfile=$_REQUEST['fromfile'];

$page=$_REQUEST["page"];
$defaultsort="kg_kode,ma_kode";
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
<form name="form1" method="post">
	<input type="hidden" id="fromfile" name="fromfile" value="<?php echo $fromfile; ?>" />
    <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <p><!--span class="jdltable">Kode-Nama Unit :01110-Graha ITS</span-->
  <table width="99%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
  <tr>
  	<td align="left">
	  <?php 
	  	$sql="select *,convert(varchar, UMK_PERIODE, 103) as tgl,unit.unit_nama from umk inner join unit on umk.umk_unit_bauk=unit.unit_id where umk_id=$idumk";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			$tgl=$rows["tgl"];
			$ctgl=explode("/",$tgl);
			$noumk=$rows["UMK_NO"];
			$unit_bauk=$rows["unit_nama"];
		}
		mysql_free_result($rs);
	  ?>
	  <div id="listumk" style="display:block">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td colspan="3" class="jdltable">Data Uang Muka</td>
              </tr>
              <tr> 
                <td width="15%">Tgl Pengajuan</td>
                <td width="2%">:</td>
                <td width="77%"><input name="tgl" type="text" id="tgl" size="11" maxlength="10" class="txtcenter" value="<?php echo $tgl; ?>" readonly="true"> 
                </td>
              </tr>
              <tr> 
                <td>Tahun Anggaran</td>
                <td width="2%">:</td>
                <td width="77%"><input name="thnanggaran" type="text" id="thnanggaran" size="4" maxlength="4" class="txtcenter" value="<?php echo $ctgl[2]; ?>" readonly="true"></td>
              </tr>
              <!--tr> 
        <td>Unit Pengguna</td>
          <td>:</td>
        <td><input name="unit" type="text" id="unit" value="Pengurus Graha ITS" size="50" maxlength="50" readonly="true"> 
        </td>
      </tr-->
              <tr> 
                <td>No UMK</td>
                <td>:</td>
                <td><input name="noumk" type="text" id="noumk" readonly="true" size="25" maxlength="25" class="txtinput" value="<?php echo $noumk; ?>"> 
                </td>
              </tr>
              <tr> 
                <td>Unit Layanan BAUK</td>
                <td>:</td>
                <td><input name="unit_bauk" type="text" id="unit_bauk" readonly="true" size="50" class="txtinput" value="<?php echo $unit_bauk; ?>"> 
                </td>
              </tr>
            </table>
            <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <!--tr> 
		<td colspan="7" class="jdltable">Daftar Detail Uang Muka Yang Diajukan</td>
	  </tr-->
      <tr class="headtable"> 
        <td width="4%" class="tblheaderkiri">No</td>
        <td id="kg_kode" width="7%" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td>
		<td id="ma_kode" width="7%" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
        <td id="RINCI_URAIAN" width="58%" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
        <td width="5%" class="tblheader">Qty</td>
        <td width="130" class="tblheader">Satuan<br>
          (Rp)</td>
        <td id="RINCI_SUBTOTAL" width="130" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah<br>
          (Rp)</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, u.*,kg_kode,ma_kode from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter;
	  $sql="select u.rinci_rbaid from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter;
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
	$sql="select top $perpage u.*,kg_kode,ma_kode from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk and u.rinci_rbaid not in (select top $tpage u.rinci_rbaid from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";$stot=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$tot=$rows['RINCI_SUBTOTAL'];
		$stot=$stot+$tot;
		$arfvalue="act*-*edit*|*kode_kg*-*".$rows['kg_kode']."*|*idrba1*-*".$rows['RINCI_RBAID']."*|*idrba*-*".$rows['RINCI_RBAID']."*|*uraian*-*".$rows['RINCI_URAIAN']."*|*qty*-*".$rows['RINCI_QTY']."*|*nilai*-*".$rows['RINCI_NILAI'];
	  	$arfhapus="act*-*delete*|*idrba*-*".$rows['RINCI_RBAID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi"><?php echo $rows['kg_kode']; ?></td>
		<td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['RINCI_URAIAN']; ?></td>
        <td class="tdisi"><?php echo $rows['RINCI_QTY']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['RINCI_NILAI'],0,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format($tot,0,",","."); ?></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr class="itemtable"> 
        <td colspan="6" align="right" class="tdisikiri">Total</td>
        <td align="right" class="tdisi"><?php echo number_format($stot,0,",","."); ?></td>
      </tr>
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
	</div>
	</td>
   </tr>
  </table>
  </p>
  <p><BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak UMK</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON><BUTTON type="button" onClick="location='?f=<?php echo $fromfile.".php"; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Kembali</strong></BUTTON></p>
  </form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
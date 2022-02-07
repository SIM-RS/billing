<?php 
include("../koneksi/konek.php");

$fromfile=$_REQUEST['fromfile'];
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$thspj=$_REQUEST['thspj'];if ($thspj=="") $thspj=$ta;
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$blnspj=$_REQUEST['blnspj'];if ($blnspj=="") $blnspj=$bulan;
$idspj=$_REQUEST['idspj'];if ($idspj=="") $idspj=-1;
$idtr=$_REQUEST['idtr'];
$idma=$_REQUEST['idma'];
if ($idtr!=""){
	$idtr1=explode(",",$idtr);
	$idtr="";
	for ($i=0;$i<count($idtr1);$i++){
		$tmp=explode("-",$idtr1[$i]);
		$idtr=$idtr.$tmp[0].",";
	}
	if ($idtr!="") $idtr=substr($idtr,0,strlen($idtr)-1);
}
$view=$_REQUEST['view'];
$nospj=$_REQUEST['nospj'];

$page=$_REQUEST["page"];
$page1=$_REQUEST["page1"];
$defaultsort="tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		if ($idspj==-1){
			$sql="select sum(debit) as jml from jurnal where tr_id in ($idtr)";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)) $jml=$rows["jml"]; else $jml=0;
			$sql="insert into spj(no_spj,spj_bulan,spj_tahun,fk_idma,fk_idunit,total,tgl_act,fk_iduser) values('$nospj',$blnspj,$thspj,$idma,$idunit,$jml,getdate(),$iduser)";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$sql="select max(spj_id) as idspj from spj where fk_idunit=$idunit and fk_iduser=$iduser";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)) $idspj=$rows["idspj"];
		}
		$sql="update jurnal set fk_idspj=$idspj,status=1 where tr_id in ($idtr)";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
	case "editspj":
		$sql="update spj set no_spj='$nospj',spj_bulan=$blnspj,spj_tahun=$thspj,tgl_act=getdate(),fk_iduser=$iduser where spj_id=$idspj";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		break;
	case "delete":
		$sql="update jurnal set fk_idspj=0,status=0 where tr_id=$idtr";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Pembuatan SPJ</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
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
	<input type="hidden" id="act" name="act" value="save" />
	<input type="hidden" id="idspj" name="idspj" value="<?php echo $idspj; ?>" />
	<input type="hidden" id="idtr" name="idtr" value="" />
	<input type="hidden" id="idma" name="idma" value="" />
	<input name="view" id="view" type="hidden" value="<?php echo $view; ?>">
	<input name="fromfile" id="fromfile" type="hidden" value="<?php echo $fromfile; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input name="page1" id="page1" type="hidden" value="<?php echo $page1; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<?php 
if ($view=="viewspj"){
	$sql="select spj.*,ma_kode,ma_nama from spj inner join ma on fk_idma=ma_id where spj_id=$idspj";
	$rs=mysql_query($sql);
	$nospj="";
	$kdmaspj="";
	$nmmaspj="";
	if ($rows=mysql_fetch_array($rs)){
		$blnspj=$rows["SPJ_BULAN"];
		$thspj=$rows["SPJ_TAHUN"];
		$nospj=$rows["NO_SPJ"];
		$kdmaspj=$rows["ma_kode"];
		$nmmaspj=$rows["ma_nama"];
		$idma=$rows["FK_IDMA"];
	}
	mysql_free_result($rs);
?>
      
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="txtinput">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td width="130">Unit</td>
        <td width="10">:</td>
        <td width="170"><?php echo $iunit; ?> </td>
        <td>&nbsp;</td>
        <td width="160">&nbsp;</td>
      </tr>
      <tr> 
        <td>No SPJ</td>
        <td>:</td>
        <td><?php echo $nospj; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>Bulan/Tahun SPJ</td>
        <td>:</td>
        <td><select name="blnspj" id="blnspj" disabled>
            <option value="1">Januari</option>
            <option value="2" <?php if ($blnspj==2) echo "selected";?>>Pebruari</option>
            <option value="3" <?php if ($blnspj==3) echo "selected";?>>Maret</option>
            <option value="4" <?php if ($blnspj==4) echo "selected";?>>April</option>
            <option value="5" <?php if ($blnspj==5) echo "selected";?>>Mei</option>
            <option value="6" <?php if ($blnspj==6) echo "selected";?>>Juni</option>
            <option value="7" <?php if ($blnspj==7) echo "selected";?>>Juli</option>
            <option value="8" <?php if ($blnspj==8) echo "selected";?>>Agustus</option>
            <option value="9" <?php if ($blnspj==9) echo "selected";?>>September</option>
            <option value="10" <?php if ($blnspj==10) echo "selected";?>>Oktober</option>
            <option value="11" <?php if ($blnspj==11) echo "selected";?>>Nopember</option>
            <option value="12" <?php if ($blnspj==12) echo "selected";?>>Desember</option>
          </select> <select name="thspj" id="thspj" disabled>
            <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
            <option value="<?php echo $i; ?>" <?php if ($i==$thspj) echo "selected"; ?>><?php echo $i; ?></option>
            <?php }?>
          </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td>Kode MA</td>
        <td>:</td>
        <td colspan="2"><?php echo $kdmaspj." - ".$nmmaspj; ?></td>
        <td width="160" align="right">&nbsp;</td>
      </tr>
	   <tr> 
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td width="160" align="right">&nbsp;</td>
      </tr>
    </table>
<table width="98%" border="0" cellpadding="2" cellspacing="0">
  <tr class="headtable"> 
    <td width="30" class="tblheaderkiri">No</td>
    <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
    <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
	<td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td>
	    <td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Nomor 
          Bukti </td>
    <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
    <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah<br>(Rp)</td>
  </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter;
	  $sql="select j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter;
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
	$sql="select top $perpage j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj and j.tr_id not in (select top $tpage j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  //$arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		//$arfhapus="act*-*delete*|*idtr*-*".$rows['TR_ID']."-".$rows['FK_IDMA'];
	  ?>
  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
    <td class="tdisikiri"><?php echo $i; ?></td>
    <td class="tdisi"><?php echo $rows['tgl1']; ?></td>
    <td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['kg_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['NO_KW']; ?></td>
    <td class="tdisi" align="left"><?php echo $rows['URAIAN']; ?></td>
    <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],0,",","."); ?></td>      
  </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
</table>
<p> 
  <BUTTON type="button" onClick=""<?php if ($i==0) echo " disabled";?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak SPJ</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  <BUTTON type="button" onClick="location='?f=listspj.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali</BUTTON>
</p>
<?php
}else{
?>
<div id="input" style="display:<?php echo (($view=="trans")?"block":"none");?>"><br>
<table width="98%" border="0" cellpadding="2" cellspacing="0">
  <tr> 
    <td colspan="2">&nbsp;</td>
    <td colspan="4" align="center" class="jdltable">View Transaksi Journal <?php //echo $iunit; ?> 
  <select name="bulan" id="bulan" class="txtinput" onchange="location='?f=BuatSPJ.php&idspj=<?php echo $idspj; ?>&view=trans&ta='+ta.value+'&bulan='+bulan.value">
    <option value="1">Januari</option>
    <option value="2" <?php if ($bulan==2) echo "selected";?>>Pebruari</option>
    <option value="3" <?php if ($bulan==3) echo "selected";?>>Maret</option>
    <option value="4" <?php if ($bulan==4) echo "selected";?>>April</option>
    <option value="5" <?php if ($bulan==5) echo "selected";?>>Mei</option>
    <option value="6" <?php if ($bulan==6) echo "selected";?>>Juni</option>
    <option value="7" <?php if ($bulan==7) echo "selected";?>>Juli</option>
    <option value="8" <?php if ($bulan==8) echo "selected";?>>Agustus</option>
    <option value="9" <?php if ($bulan==9) echo "selected";?>>September</option>
    <option value="10" <?php if ($bulan==10) echo "selected";?>>Oktober</option>
    <option value="11" <?php if ($bulan==11) echo "selected";?>>Nopember</option>
    <option value="12" <?php if ($bulan==12) echo "selected";?>>Desember</option>
  </select>
          <select name="ta" id="ta" class="txtinput" onchange="location='?f=BuatSPJ.php&idspj=<?php echo $idspj; ?>&view=trans&ta='+this.value+'&bulan='+bulan.value">
            <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
            <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
            <?php }?>
          </select> </td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr class="headtable"> 
    <td width="30" class="tblheaderkiri">No</td>
    <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
    <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
	<td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td>
	<td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kuitansi</td>
    <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
    <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah<br>(Rp)</td>
	<td width="30" class="tblheader"><input type="checkbox" name="chkAll" id="chkAll" value="checkbox" onclick="fCheckAll(chkAll,chktr)" /></td>
  </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($idma!=""){
	  	//$sql="select row_number() over(order by ".$sorting.") as rownum, j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0 and (fk_idma=$idma or fk_idma1=$idma)".$filter;
	  	$sql="select j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0 and (fk_idma=$idma or fk_idma1=$idma)".$filter;
	  }else{
	  	//$sql="select row_number() over(order by ".$sorting.") as rownum, j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0".$filter;
	  	$sql="select j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0".$filter;
	  }
	  //echo $sql;
	  $rs=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page1="1";
  	//$perpage=20;$tpage=($page1-1)*$perpage+1;$ypage=$page1*$perpage;
  	$perpage=20;$tpage=($page1-1)*$perpage;
  	$jmldata=mysql_num_rows($rs);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page1>1) $bpage=$page1-1; else $bpage=1;
  	if ($page1<$totpage) $npage=$page1+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	if ($idma!=""){
	  	$sql="select top $perpage j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0 and (fk_idma=$idma or fk_idma1=$idma) and j.tr_id not in (select top $tpage j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0 and (fk_idma=$idma or fk_idma1=$idma)".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	}else{
	  	$sql="select top $perpage j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0 and j.tr_id not in (select top $tpage j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and month(j.tgl)=$bulan and year(j.tgl)=$ta and d_k='D' and status=0".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	}
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page1-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
	  ?>
  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
    <td class="tdisikiri"><?php echo $i; ?></td>
    <td class="tdisi"><?php echo $rows['tgl1']; ?></td>
    <td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['kg_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['NO_KW']; ?></td>
    <td class="tdisi" align="left"><?php echo $rows['URAIAN']; ?></td>
    <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],0,",","."); ?></td>
	<td class="tdisi"><input type="checkbox" name="chktr" id="chktr" value="<?php echo $rows['TR_ID']."-".$rows['FK_IDMA']; ?>" /></td>
  </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page1.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page1.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page1.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page1.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
</table>
<p>
        <BUTTON type="button" onClick="var z=outputSelectedCheck1(document.forms[0].chktr);if (z){document.forms[0].idtr.value=z;if (document.forms[0].idtr.value==''){alert('Pilih Transaksi Jurnal Terlebih Dahulu!');}else{document.getElementById('view').value='';document.form1.submit();}}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Tambahkan</strong></BUTTON>
        &nbsp;<BUTTON type="reset" onClick="fSetValue(window,'act*-*save');document.getElementById('view').value='';document.getElementById('input').style.display='none';document.getElementById('spj').style.display='block'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Batal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
</div>
<div id="spj" style="display:<?php echo (($view=="trans")?"none":"block");?>">
<?php 
$sql="select spj.*,ma_kode,ma_nama from spj inner join ma on fk_idma=ma_id where spj_id=$idspj";
$rs=mysql_query($sql);
$nospj="";
$kdmaspj="";
$nmmaspj="";
if ($rows=mysql_fetch_array($rs)){
	$blnspj=$rows["SPJ_BULAN"];
	$thspj=$rows["SPJ_TAHUN"];
	$nospj=$rows["NO_SPJ"];
	$kdmaspj=$rows["ma_kode"];
	$nmmaspj=$rows["ma_nama"];
	$idma=$rows["FK_IDMA"];
}
mysql_free_result($rs);
?>
<script>
document.getElementById('idma').value="<?php echo $idma; ?>";
</script>
<div align="center"><span class="jdltable">Detail Item SPJ</span><br></div>
<table width="98%" border="0" cellpadding="2" cellspacing="0">
  <tr> 
    <td colspan="8" align="right"><BUTTON type="button" onClick="document.getElementById('view').value='trans';document.getElementById('input').style.display='block';document.getElementById('spj').style.display='none'"><IMG SRC="../icon/find.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Pilih 
            Transaksi</strong></BUTTON></td>
  </tr>
  <tr class="headtable"> 
    <td width="30" class="tblheaderkiri">No</td>
    <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
    <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
	<td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td>
	<td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kuitansi</td>
    <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
    <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah<br>(Rp)</td>
	<td width="30" class="tblheader">Proses</td>
  </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum, j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter;
	  $sql="select j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter;
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
	$sql="select top $perpage j.*,convert(varchar, tgl, 103) as tgl1,kg_kode,ma_kode from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj and j.tr_id not in (select top $tpage j.tr_id from jurnal j inner join ma on fk_idma=ma_id inner join rba on fk_idrba=rba_id inner join kegiatan on rba_kgid=kg_id where fk_idunit=$idunit and fk_idspj=$idspj".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$arfhapus="act*-*delete*|*idtr*-*".$rows['TR_ID']."-".$rows['FK_IDMA'];
	  ?>
  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
    <td class="tdisikiri"><?php echo $i; ?></td>
    <td class="tdisi"><?php echo $rows['tgl1']; ?></td>
    <td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['kg_kode']; ?></td>
	<td class="tdisi"><?php echo $rows['NO_KW']; ?></td>
    <td class="tdisi" align="left"><?php echo $rows['URAIAN']; ?></td>
    <td class="tdisi" align="right"><?php echo number_format($rows['DEBIT'],0,",","."); ?></td>      
    <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus Data SPJ" onclick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}" /></td>
  </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr> 
        <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
</table>
<p>
      <table width="90%" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center">
        <tr> 
          <td width="130">Unit</td>
          <td width="10">:</td>
          <td><?php echo $iunit; ?> </td>
        </tr>
        <tr> 
          <td>No SPJ</td>
          <td>:</td>
          <td><input name="nospj" type="text" id="nospj" size="25" maxlength="25" class="txtinput" value="<?php echo $nospj; ?>" /></td>
        </tr>
        <tr> 
          <td>Bulan/Tahun SPJ</td>
          <td>:</td>
          <td><select name="blnspj" id="blnspj" class="txtinput">
              <option value="1">Januari</option>
              <option value="2" <?php if ($blnspj==2) echo "selected";?>>Pebruari</option>
              <option value="3" <?php if ($blnspj==3) echo "selected";?>>Maret</option>
              <option value="4" <?php if ($blnspj==4) echo "selected";?>>April</option>
              <option value="5" <?php if ($blnspj==5) echo "selected";?>>Mei</option>
              <option value="6" <?php if ($blnspj==6) echo "selected";?>>Juni</option>
              <option value="7" <?php if ($blnspj==7) echo "selected";?>>Juli</option>
              <option value="8" <?php if ($blnspj==8) echo "selected";?>>Agustus</option>
              <option value="9" <?php if ($blnspj==9) echo "selected";?>>September</option>
              <option value="10" <?php if ($blnspj==10) echo "selected";?>>Oktober</option>
              <option value="11" <?php if ($blnspj==11) echo "selected";?>>Nopember</option>
              <option value="12" <?php if ($blnspj==12) echo "selected";?>>Desember</option>
            </select> <select name="thspj" id="thspj" class="txtinput">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$thspj) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td>Kode MA</td>
          <td>:</td>
          <td><?php echo ($kdmaspj=="")?"-":$kdmaspj; ?></td>
        </tr>
        <tr> 
          <td>Nama MA</td>
          <td>:</td>
          <td><?php echo ($nmmaspj=="")?"-":$nmmaspj; ?></td>
        </tr>
        <tr> 
          <td>Pilih Unit Layanan</td>
          <td>:</td>
          <td colspan="2"><select name="unit_bauk" id="unit_bauk" class="txtinput">
              <?php 
				  $sql="select * from unit where jenis=4 and aktif=1";
				  $rs=mysql_query($sql);
				  while ($rows=mysql_fetch_array($rs)){
				  ?>
              <option value="<?php echo $rows["UNIT_ID"]; ?>"><?php echo $rows["UNIT_NAMA"]; ?></option>
              <?php 
				  }
				  mysql_free_result($rs);
				  ?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="3" height="40" valign="bottom">
			  <BUTTON type="button" onClick="document.getElementById('act').value='editspj';document.form1.submit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Update</strong></BUTTON> 
			   <BUTTON type="button" onClick="if (confirm('Yakin Data Sudah Benar ?')){location='?f=Ajukanspj.php&id=<?php echo $idspj; ?>&unit_bauk='+unit_bauk.value}" ><IMG SRC="../icon/ajukan.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Ajukan SPJ</strong></BUTTON> 
			  <BUTTON type="button" onClick="" ><IMG SRC="../icon/Printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak</strong></BUTTON> 
			  
			<?php if ($fromfile!=""){?>
			<BUTTON type="button" onClick="location='?f=<?php echo $fromfile.".php"; ?>'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Kembali</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
			<?php }?>
		  </td>
        </tr>
      </table>
</p>
</div>
<?php 
}
?>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>
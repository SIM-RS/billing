<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t2.OBAT_NAMA,t2.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'";
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if ($kelas=="") $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}

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
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
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
      <p><span class="jdltable">LAPORAN PEMAKAIAN OBAT</span></p>
	  <table>
        <tr> 
          <td class="txtcenter">UNIT </td>
          <td class="txtinput">: ALL</td>
        </tr>
        <tr> 
          <td class="txtcenter">Kelas </td>
          <td class="txtinput">: 
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../master/jualall_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput"<?php if ($kelas=="") echo " selected";?>>SEMUA</option>
              <?
			  $k1="SEMUA";
		  $qry="SELECT * FROM a_kelas ORDER BY KLS_KODE";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  	$lvl=$show["KLS_LEVEL"];
			$tmp="";
			for ($i=1;$i<$lvl;$i++) $tmp .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$tmp .=$show['KLS_NAMA'];
		  ?>
              <option value="<?=$show['KLS_KODE'];?>" class="txtinput"<?php if ($kelas==$show['KLS_KODE']){echo " selected";$k1=$show['KLS_NAMA'];}?>><?php echo $tmp;?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td class="txtcenter">Golongan </td>
          <td class="txtinput">: 
            <select name="golongan" id="golongan" class="txtinput" onChange="location='?f=../master/jualall_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput"<?php if ($golongan==""){echo " selected";$g1="SEMUA";}?>>SEMUA</option>
              <option value="N" class="txtinput"<?php if ($golongan=="N"){echo " selected";$g1="Narkotika";}?>>Narkotika</option>
              <option value="P" class="txtinput"<?php if ($golongan=="P"){echo " selected";$g1="Pethidine";}?>>Pethidine</option>
              <option value="M" class="txtinput"<?php if ($golongan=="M"){echo " selected";$g1="Morphine";}?>>Morphine</option>
              <option value="Psi" class="txtinput"<?php if ($golongan=="Psi"){echo " selected";$g1="Psikotropika";}?>>Psikotropika</option>
              <option value="B" class="txtinput"<?php if ($golongan=="B"){echo " selected";$g1="Obat Bebas";}?>>Obat 
              Bebas</option>
              <option value="BT" class="txtinput"<?php if ($golongan=="BT"){echo " selected";$g1="Bebas Terbatas";}?>>Bebas 
              Terbatas</option>
              <option value="K" class="txtinput"<?php if ($golongan=="K"){echo " selected";$g1="Obat Keras";}?>>Obat 
              Keras</option>
              <option value="AK" class="txtinput"<?php if ($golongan=="AK"){echo " selected";$g1="Alkes";}?>>Alkes</option>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtcenter">Jenis</td>
          <td align="center" class="txtinput">: 
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../master/jualall_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput">SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_jenis";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>" class="txtinput"<?php if ($jenis==$rows['obat_jenis_id']){echo " selected";$j1=$rows['obat_jenis'];}?>><?php echo $rows['obat_jenis']; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="2" class="txtcenter"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../master/jualall_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="90" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="AP1" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP1</td>
          <td id="AP2" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP2</td>
          <td id="AP3" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP3</td>
          <td id="AP4" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP4</td>
          <td id="AP5" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP5</td>
          <td id="AP6" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP6</td>
          <td id="AP7" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP7</td>
          <td id="AP8" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP8</td>
          <td id="AP10" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP10</td>
          <td id="AP11" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP11</td>
          <td id="FS" width="44" class="tblheader" onClick="ifPop.CallFr(this);">FS</td>
          <td id="QTY_TOTAL" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="TOTAL" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * FROM 
(SELECT ao.OBAT_NAMA,ak.NAMA,t1.*,t1.AP1+t1.AP2+t1.AP3+t1.AP4+t1.AP5+t1.AP6+t1.AP7+t1.AP8+t1.AP10+t1.AP11+t1.FS AS QTY_TOTAL FROM a_obat ao INNER JOIN 
			(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 2),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP1`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 3),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP2`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 4),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP3`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 5),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP4`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 6),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP5`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 100),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP6`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 101),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP7`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 97),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP8`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 11),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP10`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 12),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP11`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 20),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `FS`,
			SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
			FROM (`a_penerimaan` INNER JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
			WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)) 
			GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
			LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
			INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$fkelas.$fgolongan.$fjenis.") AS t2".$filter." ORDER BY ".$sorting;
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
	//echo $sql;
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP1']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP2']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP3']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP4']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP5']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP6']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP7']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP8']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP10']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP11']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['FS']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['QTY_TOTAL']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['TOTAL'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  $sql2="select sum(t2.TOTAL) as TOTAL from (".$sql.") as t2";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$total=0;
		if ($rows=mysqli_fetch_array($rs)) $total=$rows['TOTAL'];
	  	mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="12"><span class="style1">Ket: AP=Apotik; FS=Floor Stock</span></td>
          <td colspan="3" align="right"><span class="style1">Total :</span></td>
          <td align="right"><span class="style1"><?php echo number_format($total,0,",","."); ?></span></td>
        </tr>
        <tr> 
          <td colspan="8" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="8" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
	  <p><BUTTON type="button" <?php  if($i==0) echo "disabled='disabled'"; ?> onClick="PrintArea('cetak');"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Pemakaian Obat</BUTTON>
	  <BUTTON type="button" <?php  if($i==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../master/jualall_qty_excell.php?tgl_d1=<?php echo $tgl_d1; ?>&tgl_s1=<?php echo $tgl_s1; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&k1=<?php echo $k1; ?>&g1=<?php echo $g1; ?>&j1=<?php echo $j1; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></p>
    </div>
	 <div id="cetak" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">LAPORAN PEMAKAIAN OBAT</span></p>
	  <table align="center">
        <tr> 
          <td class="txtinput">UNIT </td>
          <td class="txtinput">: ALL</td>
        </tr>
        <tr> 
          <td class="txtinput">KELAS </td>
          <td class="txtinput">: <?php echo $k1; ?></td>
        </tr>
        <tr> 
          <td class="txtinput">GOLONGAN </td>
          <td class="txtinput">: <?php echo $g1; ?></td>
        </tr>
        <tr> 
          <td class="txtinput">JENIS</td>
          <td class="txtinput">: <?php echo $j1; ?></td>
        </tr>
        <tr> 
          <td colspan="2" align="center" class="txtcenter">( <?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?> 
            ) </td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="90" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit2" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP1</td>
          <td id="unit3" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP2</td>
          <td id="unit4" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP3</td>
          <td id="unit5" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP4</td>
          <td id="unit6" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP5</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP6</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP7</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP8</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP10</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP11</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">FS</td>
          <td id="total" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ntotal" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td align="left" class="tdisi" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP1']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP2']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP3']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP4']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP5']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP6']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP7']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP8']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP10']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['AP11']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['FS']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['QTY_TOTAL']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($rows['TOTAL'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="12"><span class="style1">Ket: AP=Apotik; FS=Floor Stock</span></td>
          <td colspan="3" align="right"><span class="style1">Total :</span></td>
          <td align="right"><span class="style1"><?php echo number_format($total,0,",","."); ?></span></td>
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
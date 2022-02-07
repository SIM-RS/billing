<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tipe=$_REQUEST["tipe"];
convert_var($tipe);

if ($tipe=="1"){
	$jdl="LAPORAN OBAT FAST MOVING";
	$kriteria="Penjualan Terbanyak";
	$sorting="QTY_TOTAL DESC";
}elseif ($tipe=="2"){
	$jdl="LAPORAN OBAT SLOW MOVING";
	$kriteria="Penjualan Terkecil";
	$sorting="QTY_TOTAL";
}
$cunit=$_REQUEST["cunit"];
convert_var($cunit);
if ($cunit=="" || $cunit==0){
	$funit="ap.UNIT_ID_TERIMA IN (SELECT UNIT_ID FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1) AND ";
	/*$sqlf="";
	$rsf=mysqli_query($konek,$sqlf);
	while ($rwf=mysqli_fetch_array($rsf)){
		$funit.="ap.UNIT_ID_TERIMA<>".$rwf['UNIT_ID']." AND ";
	}*/
	$funitJual="UNIT_ID<>20 AND ";
}else{
	$funit="ap.UNIT_ID_TERIMA=$cunit AND ";
	$funitJual="UNIT_ID=$cunit AND ";
}
$jenis=$_REQUEST["jenis"];
if ($jenis=="" || $jenis==0){
	$fjenis="";
}else{
	$fjenis=" WHERE ao.OBAT_KELOMPOK=".$jenis;
}

$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tgl_d,$tgl_s);
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
convert_var($tgl_d1,$tgl_s1);
//====================================================================

//Set Status Aktif atau Tidak====
$flimit=$_REQUEST['flimit'];
$status=$_REQUEST['status'];

convert_var($flimit,$status);

if ($flimit=='') $flimit="10";

if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t2.OBAT_NAMA,t2.NAMA";
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; 
convert_var($page,$filter,$act);

// Jenis Aksi
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
      <p><span class="jdltable"><?php echo $jdl; ?></span></p>
	  <table>
        <tr>
          <td class="txtcenter"><label>
            <input type="text" name="flimit" id="flimit" size="4" value="<?php echo $flimit; ?>" class="txtcenter">
          </label>
          <?php echo $kriteria; ?> </td>
        </tr>
        <tr>
          <td class="txtcenter">Unit : 
          <select id="cunit" name="cunit" onChange="location='?f=../master/fast_moving.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&flimit='+flimit.value+'&cunit='+cunit.value+'&jenis='+jenis.value+'&tipe=<?php echo $tipe; ?>'">
          	<!-- <option value="0" class="txtinput">Semua</option> -->
            <?php 
			$sqlUnit="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
			$rsUnit=mysqli_query($konek,$sqlUnit);
			while ($rwUnit=mysqli_fetch_array($rsUnit)){
			?>
            <option value="<?php echo $rwUnit['UNIT_ID']; ?>" <?php if ($cunit==$rwUnit['UNIT_ID']) echo "selected"; ?> class="txtinput"><?php echo $rwUnit['UNIT_NAME']; ?></option>
            <?php 
			}
			?>
          </select>          </td>
        </tr>
        <tr>
          <td class="txtcenter">Jenis : 
            <select id="jenis" name="jenis" onChange="location='?f=../master/fast_moving.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&flimit='+flimit.value+'&cunit='+cunit.value+'&jenis='+jenis.value+'&tipe=<?php echo $tipe; ?>'">
              <option value="0" class="txtinput">Semua</option>
              <?php 
			$sqlUnit="SELECT * FROM a_obat_jenis";
			$rsUnit=mysqli_query($konek,$sqlUnit);
			while ($rwUnit=mysqli_fetch_array($rsUnit)){
			?>
              <option value="<?php echo $rwUnit['obat_jenis_id']; ?>" <?php if ($jenis==$rwUnit['obat_jenis_id']) echo "selected"; ?> class="txtinput"><?php echo $rwUnit['obat_jenis']; ?></option>
              <?php 
			}
			?>
            </select></td>
        </tr>
        <tr> 
          <td class="txtcenter"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../master/fast_moving.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&flimit='+flimit.value+'&cunit='+cunit.value+'&jenis='+jenis.value+'&tipe=<?php echo $tipe; ?>'"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri" align="center">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="90" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_TOTAL" width="70" class="tblheader">Stok</td>
          <td id="QTY_TOTAL" width="70" class="tblheader">Qty Jual</td>
          <td id="TOTAL" width="100" class="tblheader">Nilai Jual</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		if ($tipe=="1"){
			if ($fjenis==""){
				$sql="SELECT ao.OBAT_NAMA,ak.NAMA,t2.* FROM (SELECT * FROM (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,SUM(t1.QTY_JUAL) AS QTY_JUAL,SUM(t1.NILAI) AS NILAI FROM  
(SELECT PENERIMAAN_ID,UNIT_ID,QTY_JUAL-QTY_RETUR AS QTY_JUAL,(QTY_JUAL-QTY_RETUR) * HARGA_SATUAN AS NILAI FROM a_penjualan 
WHERE $funitJual TGL BETWEEN '$tgl_d1' AND '$tgl_s1') t1 INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID
GROUP BY ap.OBAT_ID,ap.KEPEMILIKAN_ID) t2 ORDER BY QTY_JUAL DESC LIMIT $flimit) AS t2 INNER JOIN a_obat ao ON t2.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON t2.KEPEMILIKAN_ID=ak.ID";
			}else{
				$sql="SELECT ak.NAMA,t2.* FROM (SELECT t2.*,ao.OBAT_NAMA FROM (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,SUM(t1.QTY_JUAL) AS QTY_JUAL,SUM(t1.NILAI) AS NILAI FROM  
(SELECT PENERIMAAN_ID,UNIT_ID,QTY_JUAL-QTY_RETUR AS QTY_JUAL,(QTY_JUAL-QTY_RETUR) * HARGA_SATUAN AS NILAI FROM a_penjualan 
WHERE $funitJual TGL BETWEEN '$tgl_d1' AND '$tgl_s1') t1 INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID
GROUP BY ap.OBAT_ID,ap.KEPEMILIKAN_ID) t2 INNER JOIN a_obat ao ON t2.OBAT_ID=ao.OBAT_ID $fjenis ORDER BY QTY_JUAL DESC LIMIT $flimit) AS t2 
INNER JOIN a_kepemilikan ak ON t2.KEPEMILIKAN_ID=ak.ID";
			}
		}elseif ($tipe=="2"){
			$sql="SELECT ak.NAMA,t4.* FROM (SELECT * FROM (SELECT ah.OBAT_ID,ah.KEPEMILIKAN_ID,ao.OBAT_NAMA,IFNULL(t2.QTY_JUAL,0) AS QTY_JUAL,IFNULL(t2.NILAI,0) AS NILAI FROM a_harga ah 
LEFT JOIN (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,SUM(t1.QTY_JUAL) AS QTY_JUAL,SUM(t1.NILAI) AS NILAI FROM  
(SELECT PENERIMAAN_ID,UNIT_ID,QTY_JUAL-QTY_RETUR AS QTY_JUAL,(QTY_JUAL-QTY_RETUR) * HARGA_SATUAN AS NILAI FROM a_penjualan 
WHERE $funitJual TGL BETWEEN '$tgl_d1' AND '$tgl_s1') t1 INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID
GROUP BY ap.OBAT_ID,ap.KEPEMILIKAN_ID) AS t2 ON (ah.OBAT_ID=t2.OBAT_ID AND ah.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID) INNER JOIN a_obat ao ON ah.OBAT_ID=ao.OBAT_ID $fjenis) AS t3 
ORDER BY QTY_JUAL,OBAT_NAMA LIMIT $flimit) AS t4 INNER JOIN a_kepemilikan ak ON t4.KEPEMILIKAN_ID=ak.ID ORDER BY QTY_JUAL,OBAT_NAMA,KEPEMILIKAN_ID";
		}
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
/*		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
	//echo $sql;//ijw
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;*/
	  $arfvalue="";
	  $i=0;
	  $tot_stok=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		$sqlStok="SELECT IFNULL(SUM(ap.QTY_STOK),0) AS qty_stok FROM a_penerimaan ap 
WHERE $funit ap.OBAT_ID=".$rows['OBAT_ID']." 
AND ap.KEPEMILIKAN_ID=".$rows['KEPEMILIKAN_ID']." AND ap.QTY_STOK>0 AND ap.STATUS=1";
		$rsStok=mysqli_query($konek,$sqlStok);
		$rwStok=mysqli_fetch_array($rsStok);
		$tot_stok+=$rwStok['qty_stok'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rwStok['qty_stok'],0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['QTY_JUAL'],0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['NILAI'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  $sql2="select sum(t2.QTY_JUAL) as TOT_JUAL,sum(t2.NILAI) as TOTAL from (".$sql.") as t2";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$tot_qty=0;
		$total=0;
		if ($rows=mysqli_fetch_array($rs)){
			$total=$rows['TOTAL'];
			$tot_qty=$rows['TOT_JUAL'];
		}
	  	mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="2"><span class="style1">&nbsp;</span></td>
          <td align="right"><span class="style1">Total :</span></td>
          <td align="right"><span class="style1"><?php echo number_format($tot_stok,0,",","."); ?></span></td>
          <td align="right"><span class="style1"><?php echo number_format($tot_qty,0,",","."); ?></span></td>
          <td align="right"><span class="style1"><?php echo number_format($total,0,",","."); ?></span></td>
        </tr>
        <!--tr> 
          <td colspan="8" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
          <td colspan="8" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr-->
      </table>
	  <p><!--BUTTON type="button" <?php // if($i==0) echo "disabled='disabled'"; ?> onClick="PrintArea('cetak');"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Pemakaian Obat</BUTTON-->
	  <BUTTON type="button" <?php  if($i==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../master/fast_moving_excell.php?tgl_d1=<?php echo $tgl_d1; ?>&tgl_s1=<?php echo $tgl_s1; ?>&flimit=<?php echo $flimit; ?>&tipe=<?php echo $tipe; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></p>
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
		/* $rs=mysqli_query($konek,$sql);//by ijw 
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
	  mysqli_free_result($rs);*/ //by ijw end
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
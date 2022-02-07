<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$idunit=$_SESSION["ses_idunit"];
$iunit=$_REQUEST['iunit'];
$ta=$_REQUEST['ta'];
$no_retur=$_REQUEST['no_retur'];
$tgl_retur=$_REQUEST['tgl_retur'];

convert_var($tglctk,$idunit,$iunit,$no_retur,$tgl_retur);

if ($ta=="") $ta=$th[2];
$bln_th=explode("/",$tgl_retur);
	$bulan=$bln_th[1];
	$ta=$bln_th[2];
	
convert_var($ta,$bulan);

//====================================================================

$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
$kpid=$_REQUEST['kpid'];
$unitid=$_REQUEST['idunit'];
convert_var($tgl_d,$tgl_s,$kpid,$unitid);
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID_RETUR";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($page,$sorting,$filter);
//===============================
$sql="SELECT DISTINCT NOTERIMA,DATE_FORMAT(TGL_TERIMA,'%d/%m/%Y') AS tgl1 FROM a_penerimaan WHERE NOKIRIM='$no_retur'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$tgl_terima=$rows['tgl1'];
	$no_terima=$rows['NOTERIMA'];
}

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(printDiv,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printDiv).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:75px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
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
<!-- Printout -->
	<div id="printDiv" align="center" style="display:none">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">RETURN OBAT DARI UNIT <?php echo strtoupper($iunit); ?> 
        </span></p>
	  <table width="50%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
    	<tr>
        	<td width="120">Unit</td>
            <td width="487">:
              <?
			  $qry="select * from a_unit where UNIT_ID=".$_REQUEST['idunit'];
			  $exe=mysqli_query($konek,$qry);
			  $show=mysqli_fetch_array($exe);
			  echo $show['UNIT_NAME'];
		     ?>
            </td>
        </tr>
        <tr> 
          <td width="120">Kepemilikan</td>
          <td width="487">:
           <?
		   if($_REQUEST['kpid']=='0'){
		   	  echo "SEMUA";
		   }
		   else{
			  $qry2="select * from a_kepemilikan where ID=".$_REQUEST['kpid'];
			  $exe2=mysqli_query($konek,$qry2);
			  $show2=mysqli_fetch_array($exe2);
			  echo $show2['NAMA'];
			}
		     ?>
          </td>
        </tr>
        <tr> 
          <td width="120">Tgl Return</td>
          <td>:&nbsp;<?php echo $_REQUEST['tgl_d']." s/d ".$_REQUEST['tgl_s']; ?></td>
        </tr>
      </table>
      
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="38" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Return</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">No Return</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Terima</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">No Terima</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_KODE" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Unit</td>
          <td width="200" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Return </td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td id="qty_terima" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
        </tr>
        <?php 
 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; 
	  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.NO_RETUR='$no_retur'".$filter." order by ".$sorting;
	  
	  if($_REQUEST['kpid']=='0' || $_REQUEST['kpid']==''){
	  	$fkpid = '';
	  }
	  else{
	  	$fkpid = ' AND a_retur_togudang.KEPEMILIKAN_ID='.$_REQUEST['kpid'];
	  }
	  
	  if($_REQUEST['idunit']==''){
	  	$funit = ' AND a_retur_togudang.UNIT_ID=2';
	  }
	  else{
	  	$funit = ' AND a_retur_togudang.UNIT_ID='.$_REQUEST['idunit'];
	  }
	  
	  if($_REQUEST['tgl_d']=='' || $_REQUEST['tgl_s']==''){
			$tgl_d2 = date('d-m-Y');
			$tgl_s2 = date('d-m-Y');
		}
		else{
			$tgl_d2 = $_REQUEST['tgl_d'];
			$tgl_s2 = $_REQUEST['tgl_s'];
		}
	  
	  $sql="SELECT 
		  a_retur_togudang.*,
		  a_unit.UNIT_NAME,
		  a_obat.OBAT_KODE,
		  a_obat.OBAT_NAMA,
		  a_obat.OBAT_SATUAN_KECIL,
		  k.NAMA
		FROM
		  a_retur_togudang 
		  INNER JOIN a_unit 
			ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID 
		  INNER JOIN a_obat 
			ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID 
		  INNER JOIN a_kepemilikan k 
			ON a_retur_togudang.KEPEMILIKAN_ID = k.ID
		WHERE a_retur_togudang.TGL_RETUR BETWEEN '".tglSQL($tgl_d2)."' 
		  AND '".tglSQL($tgl_s2)."' $fkpid $funit
		ORDER BY ID_RETUR";
	   
	    //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  $rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cidretur=$rows['ID_RETUR'];
		$no_retur=$rows['NO_RETUR'];
		$sql="SELECT  NOTERIMA,TGL_TERIMA,if (SUM(QTY_SATUAN) is null,0,SUM(QTY_SATUAN)) AS QTY_SATUAN FROM a_penerimaan WHERE FK_MINTA_ID=$cidretur AND NOKIRIM='$no_retur'";
		$rs1=mysqli_query($konek,$sql);
		$qty_terima=0;
		if ($rows1=mysqli_fetch_array($rs1)) $qty_terima=$rows1['QTY_SATUAN'];
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo tglSQL($rows['TGL_RETUR']); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_RETUR']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo tglSQL($rows1['TGL_TERIMA']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows1['NOTERIMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY']; ?></td>
          <td class="tdisi" align="center"><?php echo $qty_terima; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALASAN']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      </table>
	</div>
<!-- print out selesai -->

	  <div id="listma" style="display:block">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">RETURN OBAT DARI UNIT 
        </span></p>
    <table width="50%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
    	<tr>
        	<td width="120">Unit</td>
            <td width="487">:
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../gudang/retur_unit.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&idunit='+idunit.value">
              <?
		  $qry="select * from a_unit where (UNIT_TIPE=2 or UNIT_TIPE=5 or UNIT_TIPE=6) and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($unitid==$show['UNIT_ID']) {echo "selected";$nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select>
            </td>
        </tr>
        <tr> 
          <td width="120">Kepemilikan</td>
          <td width="487">:            
          <select name="kpid" id="kpid" class="txtinput" onChange="location='?f=../gudang/retur_unit.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&idunit='+idunit.value">
              <option value="0" class="txtinput"<?php if ($kpid=="") echo " selected";?>>SEMUA</option>
          <?
		  $qry="SELECT * FROM a_kepemilikan ORDER BY ID";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kpid==$show['ID']) echo " selected";?>><?php echo $show["NAMA"];?></option>
              <? }?>
          </select></td>
        </tr>
        <?php
		if($_REQUEST['tgl_d']=='' || $_REQUEST['tgl_s']==''){
			$tgl_d2 = date('d-m-Y');
			$tgl_s2 = date('d-m-Y');
		}
		else{
			$tgl_d2 = $_REQUEST['tgl_d'];
			$tgl_s2 = $_REQUEST['tgl_s'];
		}
		?>
        <tr> 
          <td width="120">Tgl Return</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_d2; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" /> 
            s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_s2; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
            <button type="button" onClick="location='?f=../gudang/retur_unit.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&idunit='+idunit.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
          Lihat</button></td>
        </tr>
      </table>
      
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="38" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Return</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">No Return</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Terima</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">No Terima</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_KODE" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Unit</td>
          <td width="200" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Return </td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td id="qty_terima" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
        </tr>
        <?php 
 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; 
	  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.NO_RETUR='$no_retur'".$filter." order by ".$sorting;
	  
	  if($_REQUEST['kpid']=='0' || $_REQUEST['kpid']==''){
	  	$fkpid = '';
	  }
	  else{
	  	$fkpid = ' AND a_retur_togudang.KEPEMILIKAN_ID='.$_REQUEST['kpid'];
	  }
	  
	  if($_REQUEST['idunit']==''){
	  	$funit = ' AND a_retur_togudang.UNIT_ID=2';
	  }
	  else{
	  	$funit = ' AND a_retur_togudang.UNIT_ID='.$_REQUEST['idunit'];
	  }
	  
	  $sql="SELECT 
		  a_retur_togudang.*,
		  a_unit.UNIT_NAME,
		  a_obat.OBAT_KODE,
		  a_obat.OBAT_NAMA,
		  a_obat.OBAT_SATUAN_KECIL,
		  k.NAMA 
		FROM
		  a_retur_togudang 
		  INNER JOIN a_unit 
			ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID 
		  INNER JOIN a_obat 
			ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID 
		  INNER JOIN a_kepemilikan k 
			ON a_retur_togudang.KEPEMILIKAN_ID = k.ID
		WHERE a_retur_togudang.TGL_RETUR BETWEEN '".tglSQL($tgl_d2)."' 
		  AND '".tglSQL($tgl_s2)."' $fkpid $funit
		ORDER BY ID_RETUR";
	   
	    //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$no_retur=$rows['NO_RETUR'];
		$cidretur=$rows['ID_RETUR'];
		$sql="SELECT NOTERIMA,TGL_TERIMA,if (SUM(QTY_SATUAN) is null,0,SUM(QTY_SATUAN)) AS QTY_SATUAN FROM a_penerimaan WHERE FK_MINTA_ID=$cidretur AND NOKIRIM='$no_retur'";
		$rs1=mysqli_query($konek,$sql);
		$qty_terima=0;
		if ($rows1=mysqli_fetch_array($rs1)) $qty_terima=$rows1['QTY_SATUAN'];
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo tglSQL($rows['TGL_RETUR']); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_RETUR']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo tglSQL($rows1['TGL_TERIMA']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows1['NOTERIMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY']; ?></td>
          <td class="tdisi" align="center"><?php echo $qty_terima; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALASAN']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td align="left" colspan="8"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="4"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
        </tr>
      </table>
	</div>
		<p align="center">
      <BUTTON type="button" onClick="PrintArea('printDiv','#')" <?php if($jmldata==0) echo 'disabled'; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
      Return Obat&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="exportExcel()" <?php if($jmldata==0) echo 'disabled'; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export Ke Excel&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
        </p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<script>
function exportExcel(){
	OpenWnd('return_dr_unit_Excell.php?tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&idunit='+idunit.value,600,450,'childwnd',true);
}
</script>
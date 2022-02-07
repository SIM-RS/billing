<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//$idunit=$_SESSION["ses_idunit"];
$idunit=mysqli_real_escape_string($konek,$_SESSION["ses_idunit"]);
//$iunit=$_REQUEST['iunit'];
$iunit=mysqli_real_escape_string($konek,$_REQUEST["iunit"]);
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST["ta"]);
if ($ta=="") $ta=$th[2];
//$no_retur=$_REQUEST['no_retur'];
$no_retur=mysqli_real_escape_string($konek,$_REQUEST["no_retur"]);
//$tgl_retur=$_REQUEST['tgl_retur'];
$tgl_retur=mysqli_real_escape_string($konek,$_REQUEST["tgl_retur"]);
$bln_th=explode("/",$tgl_retur);
	$bulan=$bln_th[1];
	$ta=$bln_th[2];
//====================================================================
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST["page"]);
$defaultsort="ID_RETUR";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//===============================
$sql="SELECT DISTINCT NOTERIMA,DATE_FORMAT(TGL_TERIMA,'%d/%m/%Y') AS tgl1 FROM a_penerimaan WHERE NOKIRIM='$no_retur'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$tgl_terima=$rows['tgl1'];
	$no_terima=$rows['NOTERIMA'];
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
<script>
	function PrintArea(printDiv,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printDiv).innerHTML);
	//winpopup.document.write("<p class='txtinput'  style='padding-right:75px; text-align:right;'>");
	//winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	//winpopup.document.write("</p>");
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
      <!--<p align="center"><span class="jdltable">RETURN OBAT DARI UNIT <?php echo strtoupper($iunit); ?> 
        </span></p>-->
	  
      <table width="89%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
      	<tr>
                <td colspan="2" style="font-size:12px">
                    <b><?=$pemkabRS?><br />
					<?=$namaRS?><br />
					<?=$alamatRS?><br />
					Telepon <?=$tlpRS?><br/></b>&nbsp;
               </td>
               <td colspan="2" style="font-size:12px">
                    <b>Tanggal cetak : <? echo date("d-m-Y H:i:s");?> <br /> User by : <? echo $_SESSION["username"];?></b><br />
               </td>
        </tr>
        <tr>
                    <td height="5" colspan="4" style="border-bottom:#000000 double 2px; border-top:#000000 solid 2px">&nbsp;</td>
        </tr>
        <tr>
                    <td height="30" colspan="4" align="center" style="font-weight:bold;font-size:12px">
                        <u>BUKTI DAFTAR OBAT YANG SUDAH DIRETUR DARI UNIT <? echo strtoupper($iunit);?></u>
       </td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td>Tgl Terima</td>
          <td>: <?php echo $tgl_terima; ?></td>
          <td><!--Tgl Return --></td>
          <td width="187"><!--: <?php echo $tgl_retur; ?>--></td>
        </tr>
        <tr>
          <td width="85">No Terima</td>
          <td width="543">: <?php echo $no_terima; ?></td>
          <td width="77"><!--No Return--></td>
          <td colspan="3"><!--: <?php echo $no_retur; ?>--></td>
        </tr>
      </table>
      
      <table width="89%" border="0" cellpadding="1" cellspacing="0" align="center">
        <tr class="headtable"> 
          <td width="38" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Retur</td>
          <td id="OBAT_KODE" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No Retur</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td width="305" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Harga Satuan Kecil</td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ALASAN" width="350" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA, ah.HARGA_JUAL_SATUAN From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID INNER JOIN a_harga ah ON ah.OBAT_ID = a_retur_togudang.OBAT_ID AND ah.KEPEMILIKAN_ID = a_retur_togudang.KEPEMILIKAN_ID where a_retur_togudang.NO_RETUR='$no_retur'".$filter." order by ".$sorting;
	 //echo $sql."<br>";
	  $i=0;
	  $rs=mysqli_query($konek,$sql);
	  $btot=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cidretur=$rows['ID_RETUR'];
		$sql="SELECT if (SUM(QTY_SATUAN) is null,0,SUM(QTY_SATUAN)) AS QTY_SATUAN FROM a_penerimaan WHERE FK_MINTA_ID=$cidretur AND NOKIRIM='$no_retur'";
		$rs1=mysqli_query($konek,$sql);
		$qty_terima=0;
		if ($rows1=mysqli_fetch_array($rs1)) $qty_terima=$rows1['QTY_SATUAN'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $tgl_retur; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $no_retur; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $qty_terima; ?></td>
          <td class="tdisi" align="center"><?php echo number_format($rows['HARGA_JUAL_SATUAN'],0,",","."); ?></td>
          <td class="tdisi" align="center"><?php echo number_format($rows['HARGA_JUAL_SATUAN']*$qty_terima,0,",","."); $btot+=$rows['HARGA_JUAL_SATUAN']*$qty_terima; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALASAN']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr>
      	<td colspan="9" class="tdisikiri" align="right">Grand Total</td>
        <td colspan="2" class="tdisi" align="right"><? echo number_format($btot,0,",",".");?></td>
      </tr>
      </table>
      
      <br />
  <br />
  <table width="85%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
  <tr>
  	<td align="center">Pengirim Oleh :</td>
    <td align="center">Penerima Oleh :</td>
  </tr>
  </table>
	</div>
<!-- print out selesai -->

	  <div id="listma" style="display:block">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">RETURN OBAT DARI UNIT <?php echo strtoupper($iunit); ?> 
        </span></p>
	  
      <table width="89%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="83">Tgl Terima</td>
          <td width="543">: <?php echo $tgl_terima; ?></td>
          <td width="75">Tgl Return</td>
          <td width="191">: <?php echo $tgl_retur; ?></td>
        </tr>
        <tr>
          <td>No Terima</td>
          <td>: <?php echo $no_terima; ?></td>
          <td width="75">No Return</td>
          <td width="191">: <?php echo $no_retur; ?></td>
        </tr>
      </table>
      
      <table width="89%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="38" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td width="305" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Return </td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td id="qty_terima" width="350" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
        </tr>
        <?php 
/* 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; */
	  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.NO_RETUR='$no_retur'".$filter." order by ".$sorting;
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
		$cidretur=$rows['ID_RETUR'];
		$sql="SELECT if (SUM(QTY_SATUAN) is null,0,SUM(QTY_SATUAN)) AS QTY_SATUAN FROM a_penerimaan WHERE FK_MINTA_ID=$cidretur AND NOKIRIM='$no_retur'";
		$rs1=mysqli_query($konek,$sql);
		$qty_terima=0;
		if ($rows1=mysqli_fetch_array($rs1)) $qty_terima=$rows1['QTY_SATUAN'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
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
          <td align="left" colspan="3"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="4"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
          </td>
        </tr>
      </table>
	</div>
		<p align="center">
      <BUTTON type="button" onClick="PrintArea('printDiv','#')" <?php if($jmldata==0) echo 'disabled'; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
      Return Obat&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="location='?f=../gudang/retur_dr_unit.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
        </p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
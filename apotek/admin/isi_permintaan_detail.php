<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$idunit=$_SESSION["ses_idunit"];
$iunit=$_REQUEST['iunit'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$no_minta=$_REQUEST['no_minta'];
$tgl_minta=$_REQUEST['tgl_minta'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="am.tgl,am.permintaan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
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
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
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
<!-- Printout -->
	<div id="printDiv" style="display:none">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
    <p align="center"><span class="jdltable">DETAIL PERMINTAAN OBAT DARI UNIT 
      <?php echo strtoupper($iunit); ?> </span></p>
	  
    <table width="33%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
    
      <tr> 
        <td>Tgl Permintaan</td>
        <td width="206">: <?php echo $tgl_minta; ?></td> 
	  </tr>
		<tr>
        <td width="124">No Permintaan</td>
        <td colspan="3">: <?php echo $no_minta; ?></td>
      </tr>
    </table>
      
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="32" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
          Obat</td>
        <td width="585" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td id="OBAT_SATUAN_KECIL" width="54" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
        <td id="NAMA" width="86" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="qty" width="73" class="tblheader" onClick="ifPop.CallFr(this);">Qty Minta</td>
        <td id="qty_terima" width="76" class="tblheader" onClick="ifPop.CallFr(this);">Qty Terima</td>
      </tr>
      <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,am.permintaan_id,am.unit_id,am.kepemilikan_id,am.qty,am.qty_terima,am.qty-am.qty_terima as qty_kirim from a_minta_obat am inner join a_obat ao on am.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on am.KEPEMILIKAN_ID=ak.ID where am.no_bukti='$no_minta' ".$filter." ORDER BY ".$sorting;
	  //echo $sql."<br>";
	  $i=0;
	  $rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        
      <td align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_terima']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
	</div>
<!-- print out selesai -->
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
	<input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta; ?>">
	<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
	<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

	  <div id="listma" style="display:block">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
    <p align="center"><span class="jdltable">DETAIL PERMINTAAN OBAT DARI UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  
    <table width="43%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
       <tr> 
		<td width="132">Tgl Permintaan</td>
        <td width="157">: <?php echo $tgl_minta; ?></td>
        </tr>
	  <tr> 
        <td width="132">No Permintaan</td>
        <td width="157">: <?php echo $no_minta; ?></td>
      </tr>
    </table>
      
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="32" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
          Obat</td>
        <td width="565" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td id="OBAT_SATUAN_KECIL" width="67" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
        <td id="NAMA" width="93" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="qty" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Qty Minta</td>
        <td id="qty_terima" width="79" class="tblheader" onClick="ifPop.CallFr(this);">Qty Terima</td>
      </tr>
      <?php 
/* 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; */
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,am.permintaan_id,am.unit_id,am.kepemilikan_id,am.qty,am.qty_terima,am.qty-am.qty_terima as qty_kirim from a_minta_obat am inner join a_obat ao on am.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on am.KEPEMILIKAN_ID=ak.ID where am.no_bukti='$no_minta' ".$filter." ORDER BY ".$sorting;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
/*		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;*/
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['qty_terima']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	        <!--tr> 
        <td align="left" colspan="3"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
        <td align="right" colspan="4"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
        </td>
      </tr-->
    </table>
	</div>
		<p align="center">
            
      <BUTTON type="button" onClick="PrintArea('printDiv','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
      Permintaan&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="location='?f=../gudang/list_permintaan&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
        </p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
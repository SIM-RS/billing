<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$idunit=$_SESSION["ses_idunit"];
$iunit=$_REQUEST['iunit'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$no_bukti=$_REQUEST['no_bukti'];
$tgl_pinjam=$_REQUEST['tgl_pinjam'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t1.TANGGAL,t1.FK_MINTA_ID";
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
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
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
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
	<input name="no_bukti" id="no_bukti" type="hidden" value="<?php echo $no_bukti; ?>">
	<input name="tgl_pinjam" id="tgl_pinjam" type="hidden" value="<?php echo $tgl_pinjam; ?>">
	<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
	<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">DETAIL OBAT YANG SUDAH DIKIRIMKAN 
        KE UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="126">No Peminjaman</td>
          <td width="838">: <?php echo $no_bukti; ?></td>
        </tr>
        <tr> 
          <td>Tgl Peminjaman</td>
          <td>: <?php echo $tgl_pinjam; ?></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="OBAT_KODE" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim </td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Kirim</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select t1.OBAT_ID,t1.NOKIRIM,t1.TANGGAL,t1.tgl1,sum(t1.qty_kirim) as qty_kirim,ap1.KEPEMILIKAN_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from a_penerimaan ap1 inner join (select ap.OBAT_ID,ap.ID_LAMA,ap.NOKIRIM,ap.TANGGAL,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,sum(ap.QTY_SATUAN) as qty_kirim from a_penerimaan ap inner join a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id where ap.TIPE_TRANS=2 and apo.no_bukti='$no_bukti' group by ap.OBAT_ID,ap.ID_LAMA,ap.NOKIRIM) as t1 on ap1.ID=t1.ID_LAMA inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap1.KEPEMILIKAN_ID=ak.ID group by t1.OBAT_ID,t1.NOKIRIM,ap1.KEPEMILIKAN_ID";
	  $sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.FK_MINTA_ID,ap.KEPEMILIKAN_ID,ap.NOKIRIM,ap.TANGGAL,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,sum(ap.QTY_SATUAN) as qty_kirim from a_penerimaan ap inner join a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id where ap.TIPE_TRANS=2 and apo.no_bukti='$no_bukti' group by ap.OBAT_ID,ap.FK_MINTA_ID,ap.NOKIRIM) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID".$filter." group by t1.OBAT_ID,t1.NOKIRIM,t1.KEPEMILIKAN_ID order by ".$sorting;
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
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        
      </table>
    </div>
	<table width="95%"><tr> 
          <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr></table>
		<p align="center">
			<!--a class="navText" href='#' onclick='PrintArea("listma","#")'>
            <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;&nbsp;</BUTTON>
			</a-->
            <BUTTON type="button" onClick="PrintArea('cetak','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;&nbsp;</BUTTON>&nbsp;<BUTTON type="button" onClick="location='?f=list_dipinjam.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
</form>
</div>
<div id="cetak" style="display:none">
	  <link rel="stylesheet" href="../theme/print.css" type="text/css" /> 
      <p align="center"><span class="jdltable">DETAIL OBAT YANG SUDAH DIKIRIMKAN 
        KE UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="126">No Peminjaman</td>
          <td width="838">: <?php echo $no_bukti; ?></td>
        </tr>
        <tr> 
          <td>Tgl Peminjaman</td>
          <td>: <?php echo $tgl_pinjam; ?></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="OBAT_KODE" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim </td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Kirim</td>
        </tr>
        <?php 
		  $sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.FK_MINTA_ID,ap.KEPEMILIKAN_ID,ap.NOKIRIM,ap.TANGGAL,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,sum(ap.QTY_SATUAN) as qty_kirim from a_penerimaan ap inner join a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id where ap.TIPE_TRANS=2 and apo.no_bukti='$no_bukti' group by ap.OBAT_ID,ap.FK_MINTA_ID,ap.NOKIRIM) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID".$filter." group by t1.OBAT_ID,t1.NOKIRIM,t1.KEPEMILIKAN_ID order by ".$sorting;
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_kirim']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        
      </table>
    </div>
	
</body>
</html>
<?php 
mysqli_close($konek);
?>
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="idproduksi";
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
var arrRange=depRange=[];
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
	frameborder="0"
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
<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<div align="center" style="display:block">
      <table width="80%" border="0" cellpadding="1" cellspacing="0">
        <tr> ` 
          <td align="center" class=""><span class="jdltable">LAPORAN HASIL PRODUKSI 
            OBAT</span></td>
        </tr>
        <tr> 
          <td class="txtcenter">Tgl Produksi&nbsp; 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
            &nbsp;s/d&nbsp; 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" > 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
            &nbsp;&nbsp;<button type="button" onClick="location='?f=../produksi/hasil_produksi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"><img src="../icon/lihat.gif" height="16" width="16" border="0" align="absmiddle" /></button>&nbsp; 
            Lihat</td>
        </tr>
      </table>
			  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td width="80" class="tblheader" id="TANGGAL" onClick="ifPop.CallFr(this);">Tgl 
            Produksi</td>
          <td width="120" class="tblheader" id="NOKIRIM" onClick="ifPop.CallFr(this);">No 
            Produksi</td>
          <td width="80" class="tblheader" id="OBAT_KODE" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Hasil 
            Produksi</td>
          <td width="80" class="tblheader" id="OBAT_SATUAN_KECIL" onClick="ifPop.CallFr(this);">Satuan</td>
          <td width="90" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="80" class="tblheader" id="HARGA_BELI_SATUAN" onClick="ifPop.CallFr(this);">Harga 
            Satuan</td>
          <td width="90" class="tblheader">Subtotal</td>
        </tr>
        <?php
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
/* 	$sql="SELECT DATE_FORMAT(p.tgl,'%d/%m/%Y') AS tgl1,p.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,k.NAMA,
		FLOOR(ap.HARGA_BELI_SATUAN) as HARGA_BELI_SATUAN,FLOOR(ap.HARGA_BELI_SATUAN)*p.qty_lama as stotal 
		FROM a_produksi p INNER JOIN a_penerimaan ap ON p.id_lama=ap.ID INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
		INNER JOIN a_kepemilikan k ON ap.KEPEMILIKAN_ID=k.ID WHERE p.tgl BETWEEN '$tgl_d1' AND '$tgl_s1'".$filter." ORDER BY ".$sorting; */
	$sql="SELECT DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1,ap.NOKIRIM,ap.TANGGAL,ap.QTY_SATUAN,FLOOR(ap.HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN,
		FLOOR(ap.HARGA_BELI_SATUAN)*ap.QTY_SATUAN AS stotal,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,k.NAMA
		FROM a_penerimaan ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
		INNER JOIN a_kepemilikan k ON ap.KEPEMILIKAN_ID=k.ID WHERE ap.TANGGAL BETWEEN '$tgl_d1' AND '$tgl_s1' AND ap.TIPE_TRANS=4";
	//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql2);
	  $p=($page-1)*$perpage;
	while($show=mysqli_fetch_array($rs)){
	$p++;
	?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><? echo $p?></td>
          <td class="tdisi"><?php echo $show['tgl1']; ?></td>
          <td class="tdisi"><?php echo $show['NOKIRIM']; ?></td>
          <td class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
          <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi"><?php echo $show['NAMA']; ?></td>
          <td class="tdisi"><?php echo $show['QTY_SATUAN']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($show['stotal'],0,",","."); ?></td>
        </tr>
        <? 
		} 
		$sql2="select if (sum(t1.stotal) is null,0,sum(t1.stotal)) as ntot from (".$sql.") as t1";
		$rs=mysqli_query($konek,$sql2);
		if ($rows=mysqli_fetch_array($rs)) $ntot=$rows['ntot'];
		?>
        <tr> 
          <td colspan="9" class="txtright">Total : </td>
          <td class="txtright"><?php echo number_format($ntot,0,",","."); ?></td>
        </tr>
        <tr> 
          <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();"></td>
        </tr>
      </table>
  <br>
    </div>
	<p align="center">
		<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Produksi&nbsp;</BUTTON>&nbsp;
		<BUTTON type="button" onClick="<?php if ($fasal=="rpt"){?>location='?f=list_produksi.php'<?php }else{?>location='?f=list_produksi_obat.php'<?php }?>"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	  </p>
</form>
</div>
<div align="center" id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <table width="80%" border="0" cellpadding="1" cellspacing="0" align="center">
        <tr> ` 
          
      <td align="center" class=""><span class="jdltable">LAPORAN HASIL PRODUKSI 
        OBAT</span></td>
        </tr>
        <tr> 
          <td class="txtcenter">(&nbsp;<?php echo $tgl_d;?>&nbsp;s/d&nbsp;<?php echo $tgl_s;?>&nbsp;)</td>
        </tr>
      </table>
			  
      
  <table width="98%" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td width="80" class="tblheader">Tgl 
            Produksi</td>
          <td width="120" class="tblheader">No 
            Produksi</td>
          <td width="80" class="tblheader">Kode 
            Obat</td>
          
      <td class="tblheader">Hasil Produksi</td>
          <td width="80" class="tblheader">Satuan</td>
          <td width="90" class="tblheader">Kepemilikan</td>
          <td width="40" class="tblheader">Qty</td>
          <td width="80" class="tblheader">Harga 
            Satuan</td>
          <td width="90" class="tblheader">Subtotal</td>
        </tr>
        <?php
	  $rs=mysqli_query($konek,$sql);
	  $p=0;
	while($show=mysqli_fetch_array($rs)){
	$p++;
	?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          
      <td align="center" class="tdisikiri"><? echo $p?></td>
          
      <td align="center" class="tdisi"><?php echo $show['tgl1']; ?></td>
          
      <td align="center" class="tdisi"><?php echo $show['NOKIRIM']; ?></td>
          
      <td align="center" class="tdisi"><?php echo $show['OBAT_KODE']; ?></td>
          <td align="left" class="tdisi"><?php echo $show['OBAT_NAMA']; ?></td>
          
      <td align="center" class="tdisi"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
          
      <td align="center" class="tdisi"><?php echo $show['NAMA']; ?></td>
          
      <td align="center" class="tdisi"><?php echo $show['QTY_SATUAN']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($show['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($show['stotal'],0,",","."); ?></td>
        </tr>
        <? } ?>
        <tr> 
          <td colspan="9" class="txtright">Total : </td>
          <td class="txtright"><?php echo number_format($ntot,0,",","."); ?></td>
        </tr>
      </table>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
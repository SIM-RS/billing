<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$item=$_REQUEST['item']; if($item=="" OR $item=="0") $itm=""; else $itm="and a_penerimaan.OBAT_ID=$item";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="TANGGAL_ACT desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>
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
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<form name="form1" method="post" action="">
<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<input type="hidden" name="filter1" id="filter1" value="<?php echo $filter1; ?>">
	<div id="idArea" style="display:block">
	<p><span class="jdltable">
	  DAFTAR PENERIMAAN</span>
	<table width="60%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
<tr>
<td width="131">Tanggal Periode</td>
          <td width="202">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" onchange="location='?f=../floorstock/list_pembelian.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;</td>
	  <td width="31">s/d</td>
			<td width="179">: 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onchange="location='?f=../floorstock/list_pembelian.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />&nbsp;</td>
		    <td width="98" colspan="">&nbsp;</td>
</tr>
<tr>
<td colspan="">Nama Obat</td>
<td colspan="3">
  <select name="item" id="item" onchange="location='?f=../gudang/list_penerimaan_prod.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&item='+this.value">
    <option value="0">All Item</option>
    <?
	  			$qry = "select OBAT_ID,OBAT_NAMA from a_obat order by OBAT_ID";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
				//$id=$show['UNIT_ID']
	  			?>
    <option value="<?php echo $show['OBAT_ID'];?>" class="txtinput" <?php if ($item==$show['OBAT_ID']) echo " selected"; ?>>
    <?=$show['OBAT_NAMA'];?>
    </option>
    <? }?>
  </select>
</td>
<td colspan="" align="left">
			  <button type="button" onclick="location='?f=../gudang/list_penerimaan_prod.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&item='+item.value">
		  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>	  </td>
    </tr>
	</table>
<table width="89%" align="center" cellpadding="1" cellspacing="0" border="0">
<tr class="headtable">
          <td width="32" height="25" class="tblheaderkiri">No</td>
		  <td id="OBAT_NAMA" width="146" class="tblheader" onclick="ifPop.CallFr(this);">Item </td>
          <td id="TANGGAL" width="40" class="tblheader" onclick="ifPop.CallFr(this);">Tgl Act</td>
		  <td align="center" id="a_penerimaan.NOTERIMA" width="100" class="tblheader" onclick="ifPop.CallFr(this);">No Penerimaan</td>
		  <td align="center" id="a_penerimaan.NOBUKTI" width="64" class="tblheader" onclick="ifPop.CallFr(this);">No Fatur</td>
          <td align="center" id="NAMA" width="86" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td align="center" id="UNIT_NAME" width="71" class="tblheader" onclick="ifPop.CallFr(this);">Unit</td>
          <td width="34" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_SATUAN" width="59" class="tblheader" onclick="ifPop.CallFr(this);">Harga</td>
          <td id="HARGA_BELI_TOTAL" width="63" class="tblheader" onclick="ifPop.CallFr(this);">Jumlah </td>
          <td id="DISKON" width="59" class="tblheader" onclick="ifPop.CallFr(this);">Diskon </td>
          <td id="" width="72" class="tblheader" onclick=";">Jml+Disk </td>
          <td id="NILAI_PAJAK" width="55" class="tblheader" onclick="ifPop.CallFr(this);">Pajak </td>
          <td id="" width="57" class="tblheader" onclick="">Total </td>
          <!--td class="tblheader" width="30">Proses</td-->
    </tr>

        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
	  //$sql="select distinct date_format(TANGGAL,'%d/%m/%Y') as tgl1,no_po,PBF_NAMA from a_po inner join a_pbf on a_po.pbf_id=a_pbf.pbf_id where month(TANGGAL)=$bulan and year(TANGGAL)=$ta".$filter." order by ".$sorting;
	  //$sql="select distinct date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.NOTERIMA,ap.NOBUKTI,PBF_NAMA from a_penerimaan ap inner join a_pbf on ap.PBF_ID=a_pbf.PBF_ID where ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=0 and month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$ta".$filter." ORDER BY ".$sorting;
	  
	  $sql="Select
a_penerimaan.TANGGAL_ACT,a_penerimaan.TANGGAL,a_penerimaan.QTY_SATUAN,a_penerimaan.HARGA_BELI_TOTAL,a_obat.OBAT_NAMA,a_penerimaan.HARGA_BELI_SATUAN,a_kepemilikan.NAMA,a_unit.UNIT_NAME,a_penerimaan.NOTERIMA,a_penerimaan.NOBUKTI,DISKON,NILAI_PAJAK From a_penerimaan Left Join a_unit ON a_unit.UNIT_ID = a_penerimaan.UNIT_ID_TERIMA Left Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID Left Join a_kepemilikan ON a_kepemilikan.ID = a_penerimaan.KEPEMILIKAN_ID where a_penerimaan.UNIT_ID_KIRIM=17 and a_penerimaan.UNIT_ID_TERIMA=1 and TANGGAL between '$tgl_1' and '$tgl_2'" .$itm.$filter." order by " .$sorting; 
	
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
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TANGGAL_ACT'])); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
		  <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($rows['DISKON']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']-$rows['DISKON']); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($pajak=($rows['HARGA_BELI_TOTAL']-$rows['DISKON'])/10); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']-$rows['DISKON']+$pajak); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  
	  ?>
</table>
</div>
<div id="cetak" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<table width="49%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
<tr>
  <td colspan="4" align="center">DAFTAR PENERIMAAN</td> 
<tr>
<td width="118">Tanggal Periode</td>
          <td width="157">: <?php echo $_GET['tgl_d'];?></td>
			<td width="37">s/d</td>
	    <td width="175" colspan="">:<?php echo $_GET['tgl_s'];?> </td>
</tr>
<tr>
<td colspan="4">Nama Obat : 
<?php
$qry="select OBAT_ID,OBAT_NAMA from a_obat where OBAT_ID=$item";
$sm=mysqli_query($konek,$qry);
$show=mysqli_fetch_array($sm);
//echo $qry;
echo $show['OBAT_NAMA'];
if ($show['OBAT_NAMA']=="") echo "ALL ITEM";
?></td>
</tr>
</table>
<table width="80%" align="center" border="0" cellpadding="1" cellspacing="0">
<tr class="headtable">
          <td width="32" height="25" class="tblheaderkiri">No</td>
		  <td id="OBAT_NAMA" width="146" class="tblheader" onclick="">Item </td>
          <td id="TANGGAL" width="40" class="tblheader" onclick="">Tgl Act</td>
		  <td align="center" id="a_penerimaan.NOTERIMA" width="100" class="tblheader" onclick="">No Penerimaan</td>
		  <td align="center" id="a_penerimaan.NOBUKTI" width="64" class="tblheader" onclick="">No Fatur</td>
          <td align="center" id="NAMA" width="86" class="tblheader" onclick="">Kepemilikan</td>
		  <td align="center" id="UNIT_NAME" width="71" class="tblheader" onclick="">Unit</td>
          <td width="34" class="tblheader" id="QTY_SATUAN" onclick="">QTY</td>
          <td id="HARGA_BELI_SATUAN" width="59" class="tblheader" onclick="">Harga</td>
          <td id="HARGA_BELI_TOTAL" width="63" class="tblheader" onclick="">Jumlah </td>
          <td id="DISKON" width="59" class="tblheader" onclick="">Diskon </td>
          <td id="" width="72" class="tblheader" onclick=";">Jml+Disk </td>
          <td id="NILAI_PAJAK" width="55" class="tblheader" onclick="">Pajak </td>
          <td id="" width="57" class="tblheader" onclick="">Total </td>
          <!--td class="tblheader" width="30">Proses</td-->
    </tr>
        <?php
		 $sql="Select
a_penerimaan.TANGGAL_ACT,a_penerimaan.TANGGAL,a_penerimaan.QTY_SATUAN,a_penerimaan.HARGA_BELI_TOTAL,a_obat.OBAT_NAMA,a_penerimaan.HARGA_BELI_SATUAN,a_kepemilikan.NAMA,a_unit.UNIT_NAME,a_penerimaan.NOTERIMA,a_penerimaan.NOBUKTI,DISKON,NILAI_PAJAK From a_penerimaan Left Join a_unit ON a_unit.UNIT_ID = a_penerimaan.UNIT_ID_TERIMA Left Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID Left Join a_kepemilikan ON a_kepemilikan.ID = a_penerimaan.KEPEMILIKAN_ID where a_penerimaan.UNIT_ID_KIRIM=17 and a_penerimaan.UNIT_ID_TERIMA=1 and TANGGAL between '$tgl_1' and '$tgl_2'" .$itm.$filter." order by " .$sorting; 
		$rs=mysqli_query($konek,$sql); 
	  while ($rows=mysqli_fetch_array($rs)){
		$p++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
         <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TANGGAL_ACT'])); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN']); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($rows['DISKON']); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']-$rows['DISKON']); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($pajak=($rows['HARGA_BELI_TOTAL']-$rows['DISKON'])/10); ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_BELI_TOTAL']-$rows['DISKON']+$pajak); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
</table>
	</div>

<table width="80%" align="center" border="0" cellpadding="1" cellspacing="0">
	<tr>
	 <tr>
          <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
	 <td align="center" colspan="2">&nbsp;
		<BUTTON type="button" onclick="PrintArea('cetak','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onclick="document.getElementById('cetak').style.display='block'">&nbsp;Cetak Penerimaan</BUTTON>
	</td>
		</tr>
	</table>

</form>
</div>
</body>
</html>

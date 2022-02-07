<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_gdg=$_REQUEST['no_gdg'];
$no_faktur=$_REQUEST['no_faktur'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_po.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
/*
switch ($act){
 	case "save":
		$fdata=$_REQUEST['fdata'];
		$arfdata=explode("**",$fdata);
		$sql="SELECT DATE_ADD('$tgl2', INTERVAL $h_j_tempo DAY) as tgl";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)) $tgl_j_tempo=$rows['tgl'];
	  	$sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po' order by a_po.ID";
		$rs=mysqli_query($konek,$sql);
		$i=0;
		while ($rows=mysqli_fetch_array($rs)){
			$arfvalue=explode("|",$arfdata[$i]);
			$FK_MINTA_ID=$rows['ID'];
			$OBAT_ID=$rows['OBAT_ID'];
			$PBF_ID=$rows['PBF_ID'];
			$KEPEMILIKAN_ID=$rows['KEPEMILIKAN_ID'];
			$QTY_KEMASAN=$arfvalue[1];
			$KEMASAN=$rows['KEMASAN'];
			$HARGA_KEMASAN=$rows['HARGA_KEMASAN'];
			$QTY_PER_KEMASAN=$rows['QTY_PER_KEMASAN'];
			$QTY_SATUAN=$rows['QTY_SATUAN'];
			$SATUAN=$rows['SATUAN'];
			$HARGA_BELI_TOTAL=$rows['HARGA_BELI_TOTAL'];
			$HARGA_BELI_SATUAN=$rows['HARGA_BELI_SATUAN'];
			$DISKON=$rows['DISKON'];
			$DISKON_TOTAL=$rows['DISKON_TOTAL'];
			$NILAI_PAJAK=$rows['NILAI_PAJAK'];
			$UPDT_H_NETTO=$rows['UPDT_H_NETTO'];
			$JENIS=$rows['JENIS'];
			$i++;
			$tgl_exp=explode('-',$arfvalue[0]);
			$tgl_exp=$tgl_exp[2].'-'.$tgl_exp[1].'-'.$tgl_exp[0];
			$sql="insert into a_penerimaan(OBAT_ID,FK_MINTA_ID,PBF_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_TERIMA,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,HARGA_KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,NILAI_PAJAK,UPDT_H_NETTO,JENIS,TIPE_TRANS,STATUS) values($OBAT_ID,$FK_MINTA_ID,$PBF_ID,$idunit,$KEPEMILIKAN_ID,$iduser,'$no_gdg','$no_faktur','$tgl_act','$tgl2','$tgl_j_tempo',$h_j_tempo,'','$tgl_exp',$QTY_KEMASAN,'$KEMASAN',$HARGA_KEMASAN,$QTY_PER_KEMASAN,$QTY_SATUAN,'$SATUAN',$QTY_SATUAN,$HARGA_BELI_TOTAL,$HARGA_BELI_SATUAN,$DISKON,$DISKON_TOTAL,$NILAI_PAJAK,$UPDT_H_NETTO,$JENIS,0,1)";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
			$sql="update a_po set QTY_KEMASAN_TERIMA=$QTY_KEMASAN,QTY_SATUAN_TERIMA=QTY_PER_KEMASAN*$QTY_KEMASAN,status=1 where ID=$FK_MINTA_ID";
			$rs1=mysqli_query($konek,$sql);
			//echo $sql."<br>";
		}
		break;
}

//Aksi Save, Edit, Delete Berakhir ============================================
if ($act!="save"){
	$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_gdg=$rows["NOTERIMA"];
		$arno_gdg=explode("/",$no_gdg);
		$tmp=$arno_gdg[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
	}else{
		$no_gdg="$kodeunit/RCV/$th[2]-$th[1]/0001";
	}
}
*/
//$sql="select distinct NO_PO,date_format(TANGGAL,'%d/%m/%Y') as tgl1,HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL,NILAI_PAJAK,UPDT_H_NETTO,a_pbf.PBF_ID,PBF_NAMA,no_spph from a_po inner join a_spph on a_po.FK_SPPH_ID=a_spph.spph_id inner join a_pbf on a_po.PBF_ID=a_pbf.PBF_ID where a_po.no_po='$no_po'";
$sql="select distinct NOTERIMA,ap.NOBUKTI,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.HARGA_BELI_TOTAL,ap.DISKON_TOTAL,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL) as H_DISKON,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL)+ap.NILAI_PAJAK as TOTAL,ap.NILAI_PAJAK,ap.UPDT_H_NETTO,ap.HARI_J_TEMPO,a_pbf.PBF_ID,PBF_NAMA,no_po from a_penerimaan ap inner join a_po on ap.FK_MINTA_ID=a_po.ID inner join a_pbf on ap.PBF_ID=a_pbf.PBF_ID where ap.NOTERIMA='$no_gdg' and ap.NOBUKTI='$no_faktur'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$no_po=$rows["no_po"];
	$no_faktur=$rows["NOBUKTI"];
	$tgl_gdg=$rows["tgl1"];
	$h_tot=$rows["HARGA_BELI_TOTAL"];
	$diskon_tot=$rows["DISKON_TOTAL"];
	$h_diskon=$rows["H_DISKON"];
	$total=$rows["TOTAL"];
	$ppn=$rows["NILAI_PAJAK"];
	$pbf=$rows["PBF_NAMA"];
	$pbf_id=$rows["PBF_ID"];
	$updt_h_netto=$rows["UPDT_H_NETTO"];
	$j_tempo=$rows["HARI_J_TEMPO"];
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
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
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="97%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="118">No Penerimaan</td>
          <td width="266">: 
          <input name="no_gdg" type="text" id="no_gdg" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_gdg; ?>"></td>
          <td width="155">Harga Total</td>
          <td width="170">: 
          <input name="h_tot" type="text" class="txtright" id="h_tot" value="<?php echo number_format($h_tot,0,",","."); ?>" size="11" readonly="true"></td>
          <td width="115">PPN (10%)</td>
          <td width="223">: 
          <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo number_format($ppn,0,",","."); ?>" size="11" readonly="true"></td>
        </tr>
        <tr> 
          <td width="118">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_gdg" type="text" id="tgl_gdg" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_gdg; ?>">
          </td>
          <td>Diskon Total</td>
          <td>: 
            <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo number_format($diskon_tot,0,",","."); ?>" size="11" readonly="true"></td>
          <td>T O T A L</td>
          <td>: 
            <input name="total" type="text" class="txtright" id="total" value="<?php echo number_format($total,0,",","."); ?>" size="11" readonly="true"></td>
        </tr>
        <tr> 
          <td>No PO</td>
          <td>: <?php echo $no_po; ?></td>
          <td>Harga Setelah Diskon</td>
          <td>: 
            <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo number_format($h_diskon,0,",","."); ?>" size="11" readonly="true"></td>
          <td>Jatuh Tempo</td>
          <td>: 
            <input name="h_j_tempo" type="text" class="txtcenter" id="h_j_tempo" value="<?php echo $j_tempo; ?>" size="3" maxlength="2" readonly="true">
            hari </td>
        </tr>
        <tr> 
          <td>No Faktur</td>
          <td>: 
            <input name="no_faktur" type="text" id="no_faktur" size="25" maxlength="30" class="txtinput" value="<?php echo $no_faktur; ?>" readonly="true"></td>
          <td>PBF</td>
          <td>: <?php echo $pbf; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
	  <table id="tblpenerimaan" width="97%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="32" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="61" class="tblheader">Kode Obat</td>
          <td width="227" class="tblheader" id="OBAT_NAMA">Nama Obat</td>
          <td id="NAMA" width="104" class="tblheader"> <p>Kepemilikan</p></td>
          <td id="qty_kemasan" width="55" class="tblheader">Expired Date</td>
          <td id="qty_kemasan" width="48" class="tblheader"> <p>Qty Ke masan </p></td>
          <td id="kemasan" width="61" class="tblheader">Kemasan</td>
          <td width="65" class="tblheader">Harga Kemasan </td>
          <td width="44" class="tblheader">Isi / Ke masan</td>
          <td width="51" class="tblheader">Qty Satuan </td>
          <td width="61" class="tblheader">Satuan</td>
          <td width="51" class="tblheader">Harga Satuan </td>
          <td width="61" class="tblheader">Sub Total </td>
          <td width="34" class="tblheader">Disk (%) </td>
          <td width="51" class="tblheader">Diskon (Rp) </td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  // $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po'".$filter." order by ".$sorting;
	  $sql="select a_p.*,date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID where a_p.NOBUKTI='$no_faktur' order by a_p.ID";
	  // echo $sql."<br>";
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
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
/*		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		
		$arfhapus="act*-*delete*|*minta_id*-*".$rows['permintaan_id'];
*/
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>">
            <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>">
            <?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['tgl2']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $qty_kemasan; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['KEMASAN']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['HARGA_KEMASAN'],0,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['SATUAN']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['subtotal'],0,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['DISKON']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      </table>
	</div>
	<table width="984" border="0">
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td width="327" colspan="12" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
        </tr>
	</table>

			<p align="center">
			<a class="navText" href='#' onclick='PrintArea("listma","penerimaan_detail_report.php")'>
              <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
              Penerimaan&nbsp;&nbsp;</BUTTON></a>
            &nbsp;<BUTTON type="button" onClick="location='?f=penerimaan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          	</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
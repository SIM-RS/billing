<?php 
include("../../sesi.php");
// Koneksi =================================
include("../../koneksi/konek.php");
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
//Convert tgl di URL menjadi YYYY-mm-dd ==============================
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//===========================================================
$kepemilikan=$_REQUEST['kepemilikan']; if($kepemilikan=="") $kepemilikan="0";
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

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
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=800,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../../theme/sort.php" scrolling="no"
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
	<link rel="stylesheet" href="../../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
<table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
          <td width="127">Tanggal Periode</td>
          <td width="177">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input>
        <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>&nbsp;&nbsp;&nbsp;</input>
		</td>
			<td width="43" align="center">s/d</td>
		    <td colspan="" width="179">: 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" ></input> 
        <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>
		</td>
	  </tr>
			<tr>
			<td width="127">Jenis Kepemilikan </td>
            <td colspan="2">: 
			<select name="kepemilikan" id="kepemilikan" class="txtinput" onChange="location='penerimaan_detail_report.php?tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kepemilikan='+kepemilikan.value">
                <option value="0" class="txtinput">Pilih Jns Kepemilikan</option>
                <?
				$qry="Select distinct a_penerimaan.KEPEMILIKAN_ID, a_kepemilikan.NAMA From a_penerimaan
				left join a_kepemilikan ON a_penerimaan.KEPEMILIKAN_ID = a_kepemilikan.ID where a_kepemilikan.AKTIF=1 order by a_kepemilikan.ID";
				$exe=mysqli_query($konek,$qry);
				while($show=mysqli_fetch_array($exe)){ 
				?>
                <option value="<?php echo $show['KEPEMILIKAN_ID']; ?>" class="txtinput"<?php if ($kepemilikan==$show['KEPEMILIKAN_ID']) echo "selected";?>><?php echo $show['NAMA']; ?></option>
                <? }?>
              </select>
			  </td>
			  <td >
			  <button type="button" onClick="location='penerimaan_detail_report.php?tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kepemilikan='+kepemilikan.value">
			  <img src="../../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
	    </tr>		
	</table>
	  <table id="tblpenerimaan" width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
		  <!-- tambahan sementara -->
          <td id="tgl1" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOTERIMA" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Gudang</td>
          <td id="NOBUKTI" width="100" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Faktur </td>
          <td id="PBF_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">PBF</td>
		  <!-- Selesai-->
          <td id="OBAT_KODE" width="60" class="tblheader">Kode Obat</td>
          <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
          <td id="NAMA" width="60" class="tblheader"> <p>Kepemilikan</p></td>
          <td id="qty_kemasan" width="30" class="tblheader">Expired Date</td>
          <td id="qty_kemasan" width="30" class="tblheader"> <p>Qty Ke masan </p></td>
          <td id="kemasan" width="60" class="tblheader">Kemasan</td>
          <td width="40" class="tblheader">Harga Kemasan </td>
          <td width="40" class="tblheader">Isi / Ke masan</td>
          <td width="40" class="tblheader">Qty Satuan </td>
          <td width="60" class="tblheader">Satuan</td>
          <td width="50" class="tblheader">Harga Satuan </td>
          <td width="60" class="tblheader">Sub Total </td>
          <td width="30" class="tblheader">Disk (%) </td>
          <td width="50" class="tblheader">Diskon (Rp) </td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
		  $sql="select a_p.*,date_format(a_p.TANGGAL,'%d/%m/%Y') as tgl1,date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,a_p.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA, PBF_NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID inner join a_pbf on a_p.PBF_ID=a_pbf.PBF_ID where a_p.KEPEMILIKAN_ID=$kepemilikan and a_p.TANGGAL between '$tgl_1' and '$tgl_2' order by a_p.ID"; /* where a_p.NOBUKTI='$no_faktur' "; */
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
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
		  <td class="tdisi" align="center">&nbsp;<?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>

          <td class="tdisi" align="center"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>">
            <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>">&nbsp;
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
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="12" align="right"> <img src="../../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
	</div>
			<p align="center">
			<a class="navText" href='#' onclick='PrintArea("listma","#")'>
              <BUTTON type="button" onClick=""><IMG SRC="../../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Penerimaan&nbsp;&nbsp;</BUTTON></a>
            &nbsp;<BUTTON type="button" onClick="javascript:window.close();"><IMG SRC="../../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tutup&nbsp;</BUTTON>
          	</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
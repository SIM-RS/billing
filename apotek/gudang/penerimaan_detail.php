<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_gdg=$_REQUEST['no_gdg'];
$no_faktur=$_REQUEST['no_faktur'];
$tipe=$_REQUEST['tipe'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_p.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
$sql="select distinct NOTERIMA,ap.NOBUKTI,ap.USER_ID_TERIMA,ap.TANGGAL,date_format(ap.TANGGAL,'%m-%Y') tglg,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.HARGA_BELI_TOTAL,ap.DISKON_TOTAL,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL) as H_DISKON,(ap.HARGA_BELI_TOTAL-ap.DISKON_TOTAL)+ap.NILAI_PAJAK as TOTAL,ap.NILAI_PAJAK,ap.MATERAI,ap.UPDT_H_NETTO,ap.HARI_J_TEMPO,ap.JENIS,a_pbf.PBF_ID,if (ap.PBF_ID=0,ap.KET,a_pbf.PBF_NAMA) as PBF_NAMA,no_po,k.NAMA from a_penerimaan ap left join a_po on ap.FK_MINTA_ID=a_po.ID left join a_pbf on ap.PBF_ID=a_pbf.PBF_ID inner join a_kepemilikan k on ap.KEPEMILIKAN_ID=k.ID where ap.NOTERIMA='$no_gdg' and ap.NOBUKTI='$no_faktur'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$no_po=$rows["no_po"];
	$no_faktur=$rows["NOBUKTI"];
	$user_entry=$rows["USER_ID_TERIMA"];
	$tgl2=$rows["TANGGAL"];
	$tgl_gdg=$rows["tgl1"];
	$tglg=$rows["tglg"];
	$h_tot=$rows["HARGA_BELI_TOTAL"];
	$diskon_tot=$rows["DISKON_TOTAL"];
	$h_diskon=$rows["H_DISKON"];
	$total=$rows["TOTAL"];
	$ppn=$rows["NILAI_PAJAK"];
	$materai=$rows["MATERAI"];
	$g_total=$total+$materai;
	$pbf=$rows["PBF_NAMA"];
	$pbf_id=$rows["PBF_ID"];
	$kp_nama=$rows["NAMA"];
	$updt_h_netto=$rows["UPDT_H_NETTO"];
	$jenis=$rows["JENIS"];
	$j_tempo=$rows["HARI_J_TEMPO"];
	if ($jenis==1) $j_tempo="Konsinyasi";
	elseif ($jenis==2) $j_tempo="Hibah/Bantuan";
	elseif ($jenis==3) $j_tempo="Return PBF";
	
	$sql="SELECT p.* FROM a_penerimaan_pemeriksa pp INNER JOIN a_pemeriksa p ON pp.pemeriksa_id=p.id 
			WHERE pp.no_gudang='$no_gdg' AND pp.tgl='$tgl2' AND pp.user_act='$user_entry'";
	$rsP=mysqli_query($konek,$sql);
	$rwP=mysqli_fetch_array($rsP);
	$nama_pemeriksa="";
	while ($rwP=mysqli_fetch_array($rsP)){
		$nama_pemeriksa .=$rwP["pemeriksa"].", ";
	}
	if ($nama_pemeriksa!="") $nama_pemeriksa=substr($nama_pemeriksa,0,strlen($nama_pemeriksa)-2);
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
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1200,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	/*winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");*/
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
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="updt_harga" id="updt_harga" type="hidden" value="0">
	<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">PENERIMAAN GUDANG</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="110">No Penerimaan</td>
          <td width="195">: 
            <input name="no_gdg" type="text" id="no_gdg" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_gdg; ?>"></td>
          <td width="102">Harga Total</td>
          <td width="233">: 
            <input name="h_tot" type="text" class="txtright" id="h_tot" value="<?php echo number_format($h_tot,2,",","."); ?>" size="15" readonly="true"></td>
          <td width="106">PPN (10%)</td>
          <td width="170">: 
            <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo number_format($ppn,2,",","."); ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td>Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_gdg" type="text" id="tgl_gdg" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_gdg; ?>">          </td>
          <td>Diskon Total</td>
          <td>: 
            <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo number_format($diskon_tot,2,",","."); ?>" size="15" readonly="true"></td>
          <td>T O T A L</td>
          <td>: 
            <input name="total" type="text" class="txtright" id="total" value="<?php echo number_format($total,2,",","."); ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td>No PO</td>
          <td>: 
            <input name="no_po" type="text" id="no_po" size="25" maxlength="30" class="txtinput" value="<?php echo $no_po; ?>" readonly="true">          </td>
          <td>Harga Diskon</td>
          <td>: 
            <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo number_format($h_diskon,2,",","."); ?>" size="15" readonly="true"></td>
          <td>Materai</td>
          <td>: 
            <input name="materai" type="text" class="txtright" id="materai" value="<?php echo number_format($materai,2,",","."); ?>" size="15" readonly="true"></td>
        </tr>
        <tr> 
          <td>No Faktur/No Bukti</td>
          <td>: 
            <input name="no_faktur" type="text" id="no_faktur" size="25" maxlength="30" class="txtinput" value="<?php echo $no_faktur; ?>" readonly="true"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Grand Total</td>
          <td>: 
            <input name="g_total" type="text" class="txtright" id="g_total" value="<?php echo number_format($g_total,2,",","."); ?>" size="15" readonly="true"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php if ($tipe=="2") echo "Asal Perolehan"; else echo "PBF";?></td>
          <td>: <?php echo $pbf; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Pemeriksa</td>
          <td>: <?php echo $nama_pemeriksa; ?></td>
          <td>Kepemilikan</td>
          <td>: <?php echo $kp_nama; ?></td>
          <td><?php if ($tipe=="2") echo "Cara Perolehan"; else echo "Jatuh Tempo"; ?></td>
          <td>: 
            <?php if ($jenis==0){?><input name="h_j_tempo" type="text" class="txtcenter" id="h_j_tempo" value="<?php echo $j_tempo; ?>" size="3" maxlength="2" readonly="true">
            hari<?php }else{echo $j_tempo;}?></td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
      <table id="tblpenerimaan" width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="32" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="61" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td width="227" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="qty_kemasan" width="55" class="tblheader">Expired Date</td>
          <td id="qty_kemasan" width="48" class="tblheader" onClick="ifPop.CallFr(this);"> 
            <p>Qty Ke masan </p></td>
          <td id="kemasan" width="61" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan</td>
          <td width="65" class="tblheader">Harga Kemasan </td>
          <td width="44" class="tblheader">Isi / Ke masan</td>
          <td width="51" class="tblheader">Qty Satuan </td>
          <td width="61" class="tblheader">Satuan</td>
          <td width="51" class="tblheader">Harga Satuan </td>
          <td width="61" class="tblheader">Sub Total </td>
          <td width="34" class="tblheader">Disk (%) </td>
          <td width="51" class="tblheader">Diskon (Rp) </td>
          <td width="61" class="tblheader">DPP</td>
          <td width="61" class="tblheader">DPP+PPN</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select a_p.*, a_p.HARGA_KEMASAN * (1 - (a_p.`DISKON` / 100)) as HARGA_BELI_SATUAN1,  date_format(a_p.EXPIRED,'%d/%m/%Y') as tgl2,(a_p.HARGA_KEMASAN*QTY_KEMASAN)* (1 - (a_p.`DISKON` / 100)) as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_penerimaan a_p inner join a_obat o on a_p.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_p.KEPEMILIKAN_ID=k.ID where a_p.NOTERIMA='$no_gdg' AND a_p.NOBUKTI='$no_faktur' AND a_p.UNIT_ID_TERIMA=$idunit AND a_p.UNIT_ID_KIRIM=0".$filter." order by ".$sorting;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
//	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$kemasan=$rows['kemasan'];
		$satuan=$rows['satuan'];
		$qty_kemasan=$rows['QTY_KEMASAN'];
		$spph_id=$rows['spph_id'];
		$obat_id=$rows['obat_id'];
		$dpp=$rows['subtotal'];
		if ($ppn>0){
			
			$dpp_ppn=$dpp+($dpp/10);
		}else{
			$dpp_ppn=$rows['subtotal'];
			//$dpp=$dpp_ppn*100/110;
		}
	  ?>
        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
          <td class="tdisikiri" align="center"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>"> 
            <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>"> 
            <?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['tgl2']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $qty_kemasan; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['KEMASAN']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['SATUAN']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format(($rows['HARGA_KEMASAN']*$rows['QTY_KEMASAN']),2,",","."); ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['DISKON']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format((($rows['HARGA_KEMASAN']*$rows['QTY_KEMASAN'])*($rows['DISKON'])/100),2,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($dpp,2,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($dpp_ppn,2,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      </table>
	</div>
	
	
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	 
	  <table width="99%" border="0" cellpadding="1" cellspacing="0"  style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
        <tr>
          <td colspan="4"><b>PT. PRIMA HUSADA CIPTA MEDAN</b></td>
          <td width="460">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" style="text-decoration:underline">RS. PRIMA HUSADA CIPTA MEDAN</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4">Bukti Penerimaan Barang Gudang</td>
          <td align="right">Belawan, <?php echo $tgl;?></td>
        </tr>
        <tr>
          <td width="168">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="25">No. Pesanan</td>
          <td colspan="3">: &nbsp;<?php echo $no_po; ?></td>
          <td>Dikirim Oleh : </td>
        </tr>
        <tr>
          <td height="25">No. Penerimaan </td>
          <td colspan="3">: &nbsp;<?php echo $no_gdg; ?></td>
          <td><?php echo $pbf; ?></td>
        </tr>
        <tr>
          <td height="21">Perihal</td>
          <td colspan="3">: &nbsp;<b>Pnerimaan Barang Gudang</b></td>
          <td>di Medan</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;&nbsp;&nbsp;RS. PRIMA HUSADA CIPTA MEDAN</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="232">&nbsp;</td>
          <td width="124">&nbsp;</td>
          <td width="112">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><b>BAHAN OBAT</b></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
	  <table width="100%" border="1" cellpadding="3" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse">
        <tr style="text-align:center; font-weight:bold;">
          <td height="25" colspan="5" >&nbsp;</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;"> 
          <td width="32" height="25" >NO</td>
          <td width="227">NAMA BARANG </td>
          <td width="51" >JUMLAH</td>
          <td width="51" >HARGA KEMASAN </td>
          <td width="61" >JUMLAH HARGA </td>
        </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
		$p=0;
		while ($rows=mysqli_fetch_array($rs)){
			$p++;
			$kemasan=$rows['kemasan'];
			$satuan=$rows['satuan'];
			$qty_kemasan=$rows['QTY_KEMASAN'];
			$spph_id=$rows['spph_id'];
			$obat_id=$rows['obat_id'];
			if ($ppn>0){
				$dpp=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
				$dpp_ppn=$dpp+($dpp/10);
			}else{
				$dpp_ppn=$rows['subtotal'];
				$dpp=$dpp_ppn*100/110;
			}
	  ?>
        <tr >
          <td align="center"><?php echo $p; ?></td>
          <td align="left" >&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" >&nbsp;<?php echo $rows['QTY_KEMASAN']; ?> &nbsp;<?php echo $rows['KEMASAN']; ?></td>
          <td align="right" ><?php echo number_format($rows['HARGA_BELI_SATUAN1'],2,",","."); ?></td>
          <td  align="right" ><?php echo number_format($rows['subtotal'],2,",","."); ?></td>
        </tr>
	<?php 
 $harga_satuan_total  +=$rows['HARGA_BELI_SATUAN1'];
	   $jumlah_harga_total += $rows['subtotal'];
	  }
	  	
	  mysqli_free_result($rs);
	 
	  ?>
        <tr>
          <td colspan="4" align="right" ><b>SUB TOTAL : </b>&nbsp;</td>
          <td align="right"><b><?php echo number_format($jumlah_harga_total,2,",","."); ?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="right"><b>PPN 10 % : </b>&nbsp;</td>
          <td align="right"><b><?php echo number_format($ppn,2,",","."); ?></b></td>
        </tr>
        <tr> 
          <td colspan="4" align="right"><b>TOTAL : &nbsp;</b></td>
          <td align="right" ><b><?php echo number_format($jumlah_harga_total+$ppn,2,",","."); ?></b></td>
        </tr>
      </table>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
        <tr>
          <td width="547">&nbsp;</td>
          <td width="550">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-decoration:underline">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">Mengetahui, </td>
          <td align="center">RS. PRIMA HUSADA CIPTA MEDAN</td>
        </tr>
        <tr>
          <td align="center">ASMEN PENUNJANG MEDIK </td>
          <td align="center">PENANGGUNG JAWAB INST. FARMASI </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><b>Dr. MUHAMMAD RIZQI NASUTION</b></td>
          <td align="center" style="text-decoration:underline"><b>FUJI ASTUTI, S.Si, Apt </b></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center"><b>SIPA. 445/28257/VII/2016</b></td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
	</div>
	
	<div id="idArea2" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse;" >
        <tr class="" >
          <td colspan="4" align="center">
		  <table width="99%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
              <td colspan="4"><b>PT. PRIMA HUSADA CIPTA MEDAN</b></td>
              <td width="453">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" style="text-decoration:underline">RS. PRIMA HUSADA CIPTA MEDAN</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" align="center" style="text-decoration:underline;font-size:12px;"><b>SURAT PENERIMAAN BARANG</b></td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">Lampiran Surat Penerimaan Barang </td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td width="195">&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="25">Nomor </td>
              <td colspan="3">: &nbsp;</td>
              <td>Kepada yth. </td>
            </tr>
            <tr>
              <td height="25">Tanggal</td>
              <td colspan="3">: &nbsp;<?php echo $tgl; ?></td>
              <td><?php echo $pbf; ?></td>
            </tr>
            <tr>
              <td height="21">Perihal</td>
              <td colspan="3">: &nbsp;</td>
              <td>di Medan</td>
            </tr>
            
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">Harap Nomor Surat Penerimaan diatas dicantumkan </td>
              <td>Kirim dengan segera kealamatnya</td>
            </tr>
            <tr>
              <td colspan="4">pada Surat Pengantar Barang </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td width="269">&nbsp;</td>
              <td width="144">&nbsp;</td>
              <td width="212">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
          </table></td>
        </tr>
        <tr style="text-align:center; font-weight:bold;"> 
          <td width="432" height="25" class="" id="OBAT_NAMA">NAMA BARANG YANG DIPESAN </td>
          <td width="132" class="">MASA PEMASUKAN DALAM HARI </td>
          <td width="235" class="">TEMPAT PENYERAHAN</td>
          <td width="279" class="">TANDA TERIMA, KETERANGAN, DLL  </td>
        </tr>

        <tr class="" >
          <td  align="center" >1</td>
          <td  align="center" >2</td>
          <td  align="center">3</td>
          <td  align="center" >4</td>
        </tr>
		
		
		        <?php
      function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = kekata($x - 10). " belas";
          } else if ($x <100) {
              $temp = kekata($x/10)." puluh". kekata($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . kekata($x - 100);
          } else if ($x <1000) {
              $temp = kekata($x/100) . " ratus" . kekata($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . kekata($x - 1000);
          } else if ($x <1000000) {
              $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
          } else if ($x <1000000000) {
              $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
          }      
              return $temp;
      }
      function terbilang($x, $style=4) {
          if($x<0) {
              $hasil = "minus ". trim(kekata($x));
          } else {
              $hasil = trim(kekata($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }
	  
	  
	  $bilangan= $h_diskon;
	  $bilangan=terbilang($bilangan,3);
	  
	  //=====Bilangan setelah koma=====
	  $sakKomane=explode(".",$h_diskon);
	  $koma=$sakKomane[1];
	  $koma=terbilang($koma,3);
	  
	  ?>

        <tr  >
          <td  align="left">Penerimaan bahan medis RS. Prima Husada Cipata Medan untuk bulan <b><? echo $tglg?> </b> <br>
            sesuai permintaan <b><br>Nomor : <?php echo $no_po;?></b><br>sebesar &nbsp;  <b>Rp. &nbsp;<?php echo number_format($h_diskon,2,",","."); ?></b><br><br>
		  Terbilang :		<b><i><?php echo $bilangan."&nbsp;".$koma."Rupiah";?> </i></b> </td>
          <td  align="left"> 12 hari almanak </td>
          <td align="left" >Gudang Persediaan Rumah Sakit Prima Husada Cipta Medan</td>
          <td align="left" >Penyeiaan Dana Trw. III <br>Mata Anggaran : <br><br><span style="text-decoration:underline"><b>02.07.000.04</b> </span><br>
		  <b>No.  &nbsp;&nbsp;  /  &nbsp; &nbsp; /</b>		  </td>
        </tr>
		
	 <tr  >
	  <td colspan="4"  align="center">
	  
	  <table width="99%" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
        
     
        <tr>
          <td colspan="2" align="left">&nbsp;</td>
          <td width="404" align="center">&nbsp;</td>
          <td colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="left">Permohonan dari : </td>
          <td align="center">RS. PRIMA HUSADA CIPTA MEDAN</td>
          <td colspan="2" align="left">Keterangan : </td>
        </tr>
        <tr>
          <td colspan="2" align="left">Bag. sdr, Kasubbag. Instalasi Farmasi </td>
          <td align="center">SVP OPERASIONAL</td>
          <td width="15" align="left">-</td>
          <td width="435" align="left"> Harap asli Surat Penerimaan dilampirkan pada saat penagihan </td>
        </tr>
        <tr>
          <td width="63">Nomor</td>
          <td width="137"> : <b><?php echo $no_po; ?></b></td>
          <td align="right">&nbsp;</td>
          <td align="left">-</td>
          <td align="left">Harap cantumkan nomor NPWP RS pelabuhan Medan dangan nama PT. Pelabuhan Indonesia I (Persero). jl. Krakatau Ujung No. 100 Medan NPWP : 01.061.009.5-093.000 </td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td> : <b><?php echo $tgl; ?></b></td>
          <td align="center"><b> <p style="font-size:10px"> Dr. AUSVIN GENIUSMAN KOMAINI, M.H.Kes <p></b></td>
          <td align="left">-</td>
          <td align="left">Harap Melampirkan SSP jika tagihan di atas Rp. 10.000.000,- dengan kode Faktur Pajak <b>030</b> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="left">-</td>
          <td align="left">Jika tagihan di bawah Rp. 10.000.000,- cantumkan kode Faktur Pajak <b>010</b> </td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table></td>
	  </tr>
      </table>
    </div>
	<table width="99%" border="0">
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
			<BUTTON type="button" onClick="PrintArea('idArea','penerimaan_detail_report.php')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
              Penerimaan&nbsp;&nbsp;</BUTTON>
			  <BUTTON type="button" onClick="PrintArea('idArea2','penerimaan_detail_report.php')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
              Penerimaan&nbsp;&nbsp;</BUTTON>
			  
            &nbsp;<BUTTON type="button" onClick="location='?f=penerimaan.php&tipe=<?php echo $tipe; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          	</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
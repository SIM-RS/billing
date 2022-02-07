<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

//Menangkap filter data untuk diperkenalkan kepada Query utama===
$tipe=$_REQUEST['tipe'];
$par=$_REQUEST['par'];
$par1=explode("|",$par);
if($tipe=="0") $par1="and month(a_penerimaan.TANGGAL)=$par1[0] and year(a_penerimaan.TANGGAL)=$par1[1]";
else $par1="and a_penerimaan.TANGGAL='$par'";
//==============================================
$id=$_REQUEST['id'];
// =============================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Delete =========================================
$act=$_REQUEST['act'];
//echo $act;
if($act=="delete")
{
	$sql="delete from a_penerimaan where ID=$id";
	$rs=mysqli_query($konek,$sql);
	//echo $sql;
}
//Aksi Delete Berakhir ============================================
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
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="id" id="id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <!-- TAMPILAN TABEL DAFTAR ISI PENERIMAAN -->
  <div id="listma" style="display:block">
    <table width="800" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="ID" width="20" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
        <td id="NOBUKTI" width="75" class="tblheader" onClick="ifPop.CallFr(this);">No. Faktur</td>
		<td id="TANGGAL" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
        <td id="NOTERIMA" width="51" class="tblheader" onClick="ifPop.CallFr(this);">No.Gd</td>
		<td id="OBAT_NAMA" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
		<td id="OBAT_BENTUK" width="75" class="tblheader" onClick="ifPop.CallFr(this);">Bentuk</td>
		<td id="QTY_KEMASAN" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Jml</td>
		<td id="QTY_PER_KEMASAN" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Isi</td>
		<td id="HARGA_BELI_SATUAN" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Harga</td>
		<td id="DISKON" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Disk</td>
		<td id="EXTRA_DISKON" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Extra Disk</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;

	  $sql="Select a_penerimaan.*, a_obat.OBAT_NAMA, a_obat.OBAT_BENTUK, a_pbf.PBF_NAMA, a_pegawai.NAMA, a_kepemilikan.NAMA
	  From a_penerimaan
	  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
	  Inner Join a_pbf ON a_penerimaan.PBF_ID = a_pbf.PBF_ID
	  Inner Join a_pegawai ON a_pegawai.PEGAWAI_ID = a_penerimaan.USER_ID_TERIMA
	  Inner Join a_kepemilikan ON a_kepemilikan.ID = a_penerimaan.KEPEMILIKAN_ID
	  Where UNIT_ID_KIRIM=0 and USER_ID_KIRIM=0 AND STATUS=1 $par1".$filter." ORDER BY ".$sorting;
	  //echo $sql;
/* 		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
 */
	  $rs=mysqli_query($konek,$sql);
	  $i=0;//($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$arfvalue="act*-*edit*|*id*-*".$rows['ID']."*|*obat_id*-*".$rows['OBAT_ID']."*|*pbf_id*-*".$rows['PBF_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*noterima*-*".$rows['NOTERIMA']."*|*nobukti*-*".$rows['NOBUKTI']."*|*tglinput*-*".date("d-m-Y",strtotime($rows['TANGGAL']))."*|*batch*-*".$rows['BATCH']."*|*expired*-*".date("d-m-Y",strtotime($rows['EXPIRED']))."*|*qty_kemasan*-*".$rows['QTY_KEMASAN']."*|*kemasan*-*".$rows['KEMASAN']."*|*qty_per_kemasan*-*".$rows['QTY_PER_KEMASAN']."*|*harga_beli_total*-*".$rows['HARGA_BELI_TOTAL']."*|*harga_beli_satuan*-*".$rows['HARGA_BELI_SATUAN']."*|*diskon*-*".$rows['DISKON']."*|*extra_diskon*-*".$rows['EXTRA_DISKON']."*|*harga_jual*-*".$rows['HARGA_JUAL']."*|*ket*-*".$rows['KET']."*|*nilai_pajak*-*".$rows['NILAI_PAJAK']."*|*jenis*-*".$rows['JENIS']."*|*status*-*".$rows['STATUS'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		
		$arfhapus="act*-*delete*|*id*-*".$rows['ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
		<td class="tdisi" align="center">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TANGGAL'])); ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['NOTERIMA']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_BENTUK']; ?></td>
		<td class="tdisi" align="right">&nbsp;<?php echo $rows['QTY_KEMASAN']; ?></td>
		<td class="tdisi" align="right">&nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?></td>
		<td class="tdisi" align="right">&nbsp;<?php echo $rows['HARGA_BELI_SATUAN']; ?></td>
		<td class="tdisi" align="right">&nbsp;<?php echo $rows['DISKON']; ?></td>
		<td class="tdisi" align="right">&nbsp;<?php echo $rows['EXTRA_DISKON']; ?></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="fSetValue(parent,'<?php echo $arfvalue; ?>');parent.document.getElementById('input').style.display='block'; parent.document.getElementById('listOneFaktur').style.display='none';"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data No. <?=$i;?>?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
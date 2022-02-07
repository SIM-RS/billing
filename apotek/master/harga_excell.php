<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=Harga_Obat.xls');
//==========================================
$isview=$_REQUEST['isview'];

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="HARGA_ID DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<style type="text/css">
	.headtable td{
		text-align:center;
	}
	table{
		border-collapse:collapse;
	}
	table td{
		border: 1px solid #000;
		padding-left:10px;
		padding-right:10px;
	}
	.noborder{
		border:0px;
	}
</style>
</head>
<body>
	<input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
	<div id="listma" style="display:block">
		<table width="98%" border="0" cellpadding="1" cellspacing="0">
			<tr><th colspan="7">DAFTAR HARGA OBAT</th></tr>
			<tr><td colspan="7" class="noborder">&nbsp;</td></tr>
			<tr class="headtable"> 
				<td width="30" class="tblheaderkiri">No</td>
				<td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode Obat </td>
				<td id="OBAT_NAMA" width="500" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat </td>
                <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
				<td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
				<td id="HARGA_BELI_SATUAN" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Harga Netto </td>
				<td id="PROFIT" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Profit (%)</td>
				<td id="harga_j" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Harga Jual </td>
			</tr>
			<?php 
			if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			}
			if ($sorting=="") $sorting=$defaultsort;
				$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ah.*,ah.HARGA_BELI_SATUAN+(ah.HARGA_BELI_SATUAN*ah.PROFIT/100) as harga_j,ak.NAMA,ao.obat_satuan_kecil from a_obat ao inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID inner join a_kepemilikan ak on ah.KEPEMILIKAN_ID=ak.ID where OBAT_ISAKTIF=1".$filter." order by ".$sorting;
				//echo $sql;
				$rs=mysqli_query($konek,$sql);
				$jmldata=mysqli_num_rows($rs);
				if ($page=="") $page="1";
				$perpage=50;$tpage=($page-1)*$perpage;
				if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
				if ($page>1) $bpage=$page-1; else $bpage=1;
				if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
				//$sql=$sql." limit $tpage,$perpage";

				$rs=mysqli_query($konek,$sql);
				$i=($page-1)*$perpage;
				$arfvalue="";
			while ($rows=mysqli_fetch_array($rs)){
				$i++;
				$charga_lock=$rows['lock_harga'];		
				$arfvalue="act*-*edit*|*harga_id*-*".$rows['HARGA_ID']."*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*harga_netto*-*".$rows['HARGA_BELI_SATUAN']."*|*untung*-*".$rows['PROFIT']."*|*harga_jual*-*".$rows['harga_j']."*|*lock*-*".$charga_lock;

				$arfvalue=str_replace('"',chr(3),$arfvalue);
				$arfvalue=str_replace("'",chr(5),$arfvalue);
				$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);

				$arfhapus="act*-*delete*|*harga_id*-*".$rows['HARGA_ID'];
			?>
			<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
				<td class="tdisikiri" align="center"><?php echo $i; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
				<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
                <td class="tdisi" align="center"><?php echo $rows['obat_satuan_kecil']; ?></td>
				<td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
				<td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN'],0,".",""); ?></td>
				<td class="tdisi" align="center"><?php echo $rows['PROFIT']; ?></td>
				<td class="tdisi" align="right"><?php echo number_format($rows['harga_j'],0,".","");?></td>
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
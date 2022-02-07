<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
//$th=explode("-",$tglSkrg);
$th=explode("-",mysqli_real_escape_string($konek,$tglSkrg));
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);
if ($ta=="") $ta=$th[2];
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$ano_retur=$_REQUEST['ano_retur'];
$ano_retur=mysqli_real_escape_string($konek,$_REQUEST['ano_retur']);
//$ano_penjualan=$_REQUEST['ano_penjualan'];
$ano_penjualan=mysqli_real_escape_string($konek,$_REQUEST['ano_penjualan']);
//$aobat_id=$_REQUEST['aobat_id'];
$aobat_id=mysqli_real_escape_string($konek,$_REQUEST['aobat_id']);
//====================================================================

//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="TGL_RETUR DESC";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST['act']);
//echo $act."<br>";

switch ($act){
	case "delete":
		$sql="SELECT SQL_NO_CACHE ar.*,ap.PENERIMAAN_ID FROM a_return_penjualan ar INNER JOIN a_penjualan ap ON ar.idpenjualan=ap.ID INNER JOIN a_penerimaan a 
			ON ap.PENERIMAAN_ID=a.ID 
			WHERE ar.no_retur='$ano_retur' AND ap.NO_PENJUALAN='$ano_penjualan' AND a.OBAT_ID=$aobat_id AND ap.UNIT_ID=$idunit";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($jmldata>0){
			while ($rows=mysqli_fetch_array($rs)){
				$cidr=$rows["idretur"];
				$cqtyr=$rows["qty_retur"];
				$cidp=$rows["idpenjualan"];
				$cidpn=$rows["PENERIMAAN_ID"];
				$sql="DELETE FROM a_return_penjualan WHERE idretur=$cidr";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK-$cqtyr WHERE ID=$cidpn";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_penjualan SET QTY_RETUR=QTY_RETUR-$cqtyr,QTY=QTY+$cqtyr WHERE ID=$cidp";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
			}
		}else{
			$sql="SELECT SQL_NO_CACHE a.* FROM a_penjualan a INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID=ap.ID WHERE a.NO_RETUR='$ano_retur' AND a.NO_PENJUALAN='$ano_penjualan' AND ap.OBAT_ID=$aobat_id AND a.UNIT_ID=$idunit";
			$rs1=mysqli_query($konek,$sql);
			while ($rows1=mysqli_fetch_array($rs1)){
				$cqtyr=$rows["QTY_RETUR"];
				$cidp=$rows["ID"];
				$cidpn=$rows["PENERIMAAN_ID"];
				$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK-$cqtyr WHERE ID=$cidpn";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_penjualan SET QTY_RETUR=QTY_RETUR-$cqtyr,QTY=QTY+$cqtyr WHERE ID=$cidp";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
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
        <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="ano_retur" id="ano_retur" type="hidden" value="">
  <input name="ano_penjualan" id="ano_penjualan" type="hidden" value="">
  <input name="aobat_id" id="aobat_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

  <div id="listma" style="display:block">
    <p align="center"><span class="jdltable">RETURN PENJUALAN</span> 
    <p align="center">
  
    <table width="99%" cellpadding="0" cellspacing="0" border="0">
      <tr>
       	  <td width="642">&nbsp;<span class="txtinput">Bulan :</span>
              <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/retur_penjualan.php&ta='+ta.value+'&bulan='+bulan.value">
                <option value="1|Januari"<?php if ($bulan[0]=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan[0]=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan[0]=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan[0]=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan[0]=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan[0]=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan[0]=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan[0]=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan[0]=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan[0]=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan[0]=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan[0]=="12") echo " selected";?>>Desember</option>
              </select>
  &nbsp;<span class="txtinput">Tahun :</span>
  <select name="ta" id="ta" class="txtinput" onChange="location='?f=../transaksi/retur_penjualan.php&ta='+ta.value+'&bulan='+bulan.value">
    <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
    <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
    <?php }?>
  </select>          </td>
          
	<?php
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
		}
		if ($sorting=="") $sorting=$defaultsort;

	  /* $sql="SELECT * FROM (SELECT IF (ar.tgl_retur IS NULL,t1.TGL_RETUR,ar.tgl_retur) AS TGL_RETUR,t1.OBAT_ID,
IF (ar.no_retur IS NULL,t1.NO_RETUR,ar.no_retur) AS NO_RETUR,t1.NO_PENJUALAN,t1.NO_PASIEN,t1.NAMA_PASIEN,t1.OBAT_NAMA,k.NAMA,
IF (SUM(ar.qty_retur) IS NULL,SUM(t1.QTY_RETUR),SUM(ar.qty_retur)) AS QTY_RETUR,
IF (SUM(ar.nilai) IS NULL,FLOOR(SUM(t1.nilai)),SUM(ar.nilai)) AS nilai 
FROM (SELECT t.*,ap.OBAT_ID,ao.OBAT_NAMA,ap.KEPEMILIKAN_ID,
((100-t.BIAYA_RETUR)/100)*t.QTY_RETUR*t.HARGA_SATUAN AS nilai 
FROM (SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND MONTH(TGL_RETUR)=$bulan[0] AND YEAR(TGL_RETUR)=$ta) AS t 
INNER JOIN a_penerimaan ap ON t.PENERIMAAN_ID = ap.ID INNER JOIN a_obat ao ON ap.OBAT_ID = ao.OBAT_ID) AS t1 INNER JOIN a_kepemilikan k 
ON t1.KEPEMILIKAN_ID=k.ID LEFT JOIN (SELECT * FROM a_return_penjualan WHERE MONTH(tgl_retur)=$bulan[0] AND YEAR(tgl_retur)=$ta) AS ar ON t1.ID=ar.idpenjualan 
GROUP BY t1.PENERIMAAN_ID,t1.NO_PENJUALAN,t1.NO_RETUR,ar.no_retur) AS t2 ".$filter." 
ORDER BY ".$sorting; */
		$sql = "SELECT t1.*
				FROM (
					SELECT 
						rp.tgl_retur AS TGL_RETUR, ap.OBAT_ID, rp.no_retur AS NO_RETUR, p.NO_PENJUALAN, p.NO_PASIEN,
						p.NAMA_PASIEN, o.OBAT_NAMA, k.NAMA, SUM(rp.qty_retur) QTY_RETUR, ap.KEPEMILIKAN_ID,
						IFNULL(SUM(rp.nilai), SUM(((100- p.BIAYA_RETUR) / 100) * p.QTY_RETUR * p.HARGA_SATUAN)) AS nilai
					FROM a_return_penjualan rp
					INNER JOIN a_penjualan p ON p.ID = rp.idpenjualan
					INNER JOIN a_penerimaan ap ON ap.ID = p.PENERIMAAN_ID
					INNER JOIN a_kepemilikan k ON k.ID = ap.KEPEMILIKAN_ID
					INNER JOIN a_obat o ON o.OBAT_ID = ap.OBAT_ID
					WHERE rp.unit_id_return = {$idunit}
					  AND MONTH(rp.tgl_retur) = $bulan[0] 
					  AND YEAR(rp.tgl_retur) = {$ta}
					GROUP BY p.PENERIMAAN_ID, p.NO_PENJUALAN, rp.no_retur) t1
				".$filter."
				ORDER BY ".$sorting;
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		
?>		  <td width="308" align="right">
		  <BUTTON type="button" onClick="location='?f=../transaksi/detil_retur_penjualan.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
	    </tr>
	</table>
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri" id="ID" onClick="ifPop.CallFr(this);">No</td>
        <td id="TGL_RETUR" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Return </td>
        <td id="NO_RETUR" width="60" class="tblheader" onClick="ifPop.CallFr(this);">No. Return</td>
        <td id="NO_PENJUALAN" width="70" class="tblheader" onClick="ifPop.CallFr(this);">No. Penjualan</td>
        <td id="NO_PASIEN" width="70" class="tblheader" onClick="ifPop.CallFr(this);">No. Pasien</td>
        <td id="NAMA_PASIEN" width="170" class="tblheader" onClick="ifPop.CallFr(this);">Nama Pasien </td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
        <td width="85" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="QTY_RETUR" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty Return </td>
        <td id="nilai" width="75" class="tblheader" onClick="ifPop.CallFr(this);">Nilai Return </td>
        <td width="40" class="tblheader">Act</td>
        <!--td class="tblheader">Proses</td-->
      </tr>
      <?php 
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  	$rs=mysqli_query($konek,$sql);
	  	$i=($page-1)*$perpage;
	  	while ($rows=mysqli_fetch_array($rs)){
	  		$i++;
			$arfhapus="act*-*delete*|*ano_retur*-*".$rows['NO_RETUR']."*|*ano_penjualan*-*".$rows['NO_PENJUALAN']."*|*aobat_id*-*".$rows['OBAT_ID'];
			//$cnilai=floor(((100-$rows['BIAYA_RETUR'])/100)*$rows['QTY_RETUR']*$rows['HARGA_SATUAN']);		
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NO_PENJUALAN']; ?></td>
        <td align="center" class="tdisi">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NAMA_PASIEN']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY_RETUR']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['nilai'],0,",","."); ?></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
        </td>
      </tr>
    </table>
</div>
</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$username=$_REQUEST['user'];
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//====================================================================

//Set Status Aktif atau Tidak====
$status=$_REQUEST['status'];
if ($status=="") $status=1;
// ==============================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<!-- Script Pop Up Window Berakhir -->
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<body onLoad="window.print();window.close();">
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
      <p><span class="jdltable">LAPORAN PEMAKAIAN OBAT<br>UNIT : ALL</span></p>
	  <table width="348">
	  <tr><td>Tgl : <? echo $tglctk;?></td><td>User : <? echo $username;?></td></tr>
	  	<tr>
			<td colspan="2" align="center"><?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?></td>
		</tr>
	  </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="80" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit2" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP1</td>
          <td id="unit3" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP2</td>
          <td id="unit4" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP3</td>
          <td id="unit5" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP4</td>
          <td id="unit6" width="36" class="tblheader" onClick="ifPop.CallFr(this);">AP5</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP8</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP10</td>
          <td id="unit9" width="44" class="tblheader" onClick="ifPop.CallFr(this);">AP11</td>
          <td id="total" width="41" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
          <td id="ntotal" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT ao.OBAT_NAMA,ak.NAMA,t1.*,t1.AP1+t1.AP2+t1.AP3+t1.AP4+t1.AP5+t1.AP8+t1.AP10+t1.AP11 AS QTY_TOTAL FROM a_obat ao INNER JOIN 
			(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 2),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP1`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 3),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP2`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 4),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP3`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 5),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP4`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 6),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP5`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 9),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP8`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 11),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP10`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 12),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP11`,
			SUM(((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
			FROM (`a_penerimaan` JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
			WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)) 
			GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
			INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID ORDER BY ao.OBAT_NAMA,ak.NAMA";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
/*		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
	//echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
*/
		$i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP1']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP2']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP3']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP4']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP5']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP8']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP10']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP11']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['QTY_TOTAL']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['TOTAL'],2,",","."); ?></td>
        </tr>
        <?php 
	  }
	  //$sql="SELECT SUM(((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL`FROM `a_penjualan` WHERE (`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)";
			  $sql="select sum(t2.TOTAL) as TOTAL from (SELECT ao.OBAT_NAMA,ak.NAMA,t1.*,t1.AP1+t1.AP2+t1.AP3+t1.AP4+t1.AP5+t1.AP8+t1.AP10+t1.AP11 AS QTY_TOTAL FROM a_obat ao INNER JOIN 
			(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 2),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP1`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 3),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP2`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 4),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP3`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 5),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP4`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 6),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP5`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 9),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP8`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 11),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP10`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 12),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP11`,
			SUM(((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
			FROM (`a_penerimaan` JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
			WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)) 
			GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
			INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$filter." ORDER BY ".$sorting.") as t2";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$total=0;
		if ($rows=mysqli_fetch_array($rs)) $total=$rows['TOTAL'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="10"><span class="style1">Ket: AP=Apotik;</span></td>
          <td colspan="2" align="center"><span class="style1">Total</span></td>
          <td align="right"><span class="style1"><?php echo number_format($total,2,",","."); ?></span></td>
        </tr>
      </table>
	  
    </div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
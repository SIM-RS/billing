<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$pbfid=$_REQUEST['pbfid'];
$pbfnama="SEMUA";
if ($pbfid=="0" || $pbfid==""){
	$pbf="";
}else{
	$pbf=" AND apb.PBF_ID=$pbfid ";
	$sql="SELECT * FROM a_pbf WHERE PBF_ID=$pbfid";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)) $pbfnama=$rows["PBF_NAMA"];
}

$kpid=$_REQUEST['kpid'];
$kpnama="SEMUA";
if ($kpid=="0" || $kpid==""){
	$kp="";
}else{
	$kp=" AND ak.ID=$kpid ";
	$sql="SELECT * FROM a_kepemilikan WHERE ID=$kpid";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)) $kpnama=$rows["NAMA"];
}
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tglSkrg;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tglSkrg;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="apb.PBF_NAMA,a.NO_PO,a.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";
header("Content-Type: application/excell");
header('Content-disposition: inline; filename="realisasi_po.xls"');
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<style>
body{
margin:0;
font-family:Verdana, Arial, Helvetica, sans-serif;
}
.tblheaderkiri {
	border: 1px solid #003520;
	padding:3px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.tblheader {
	border-top: 1px solid #003520;
	border-right: 1px solid #003520;
	border-bottom: 1px solid #003520;
	border-left: none;
	font-size: 12px;
}
.tdisi {
	border-top: none;
	padding:3px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	border-right: 1px solid #203C42;
	border-bottom: 1px solid #203C42;
	border-left: none;
	font-size: 12px;
	/*text-align: left;*/
}
.tdisikiri {
	border-top: none;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-right: 1px solid #203C42;
	border-bottom: 1px solid #203C42;
	border-left: 1px solid #203C42;
}
.headtable {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	background-color:#CCCCCC;
	text-align: center;
}
.txtkop {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	text-align: center;
	vertical-align: middle;
}
.txtcenter {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	vertical-align: middle;
}
.txtright {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: right;
	vertical-align: middle;
}
.txtinput {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: left;
	vertical-align: middle;
}
.textpaging {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #000066;
	text-decoration: none;
}
.jdltable {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	text-transform: capitalize;
	border: none;
	text-align:center;
	vertical-align: bottom;
	padding-bottom: 10px;
}
.navText {
	color: #CCFF99;
	line-height:16px;
	letter-spacing:normal;
	text-decoration: none;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
</style>
</head>
<body>
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="retur_id" id="retur_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

  <div id="cetak" style="display:block">
  <!--link rel="stylesheet" href="../theme/print.css" type="text/css" /-->
    <p align="center"><span class="jdltable">LAPORAN REALISASI PENGADAAN</span>
    <!--p align="center"-->
  <table border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr> 
          <td width="80">Kepemilikan</td>
          <td>: <?php echo $kpnama; ?></td>
        </tr>
        <tr> 
          <td>Tgl PO</td>
          <td>: <?php echo $tgl_d." s/d ".$tgl_s; ?></td>
        </tr>
      </table>         
<?
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,apb.PBF_NAMA,(a.HARGA_BELI_SATUAN*(1-(a.DISKON/100)))*(1+0.1) AS aharga,a.* FROM a_po a INNER JOIN a_obat ao ON a.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON a.KEPEMILIKAN_ID=ak.ID INNER JOIN a_pbf apb ON a.PBF_ID=apb.PBF_ID 
WHERE a.TANGGAL BETWEEN '$tgl_d1' AND '$tgl_s1'".$pbf.$kp.$filter." ORDER BY ".$sorting;
	  	//echo $sql;
		$gtot=0;
		$gtotTerima=0;
		$sql2="SELECT IF (SUM(t1.QTY_SATUAN*t1.aharga) IS NULL,0,SUM(FLOOR(t1.QTY_SATUAN*t1.aharga))) AS gtot FROM (".$sql.") AS t1";
		$rs=mysqli_query($konek,$sql2);
		if ($rows=mysqli_fetch_array($rs)) $gtot=$rows["gtot"];
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		
?>		
    <table width="1000" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="75" rowspan="2" class="tblheader" onClick="ifPop.CallFr(this);">Tgl PO</td>
        <td width="100" rowspan="2" class="tblheader" id="NO_RETUR2" onClick="ifPop.CallFr(this);">No. 
        PO</td>
        <td width="75" rowspan="2" class="tblheader" onClick="ifPop.CallFr(this);">Milik</td>
        <td rowspan="2" class="tblheader" id="OBAT_NAMA2" onClick="ifPop.CallFr(this);">Obat</td>
        <td width="80" rowspan="2" class="tblheader" id="QTY2" onClick="ifPop.CallFr(this);">Satuan</td>
        <td height="25" colspan="3" class="tblheader" id="QTY2" onClick="ifPop.CallFr(this);">Jumlah</td>
        <td width="60" rowspan="2" class="tblheader" id="QTY2" onClick="ifPop.CallFr(this);">Harga PO</td>
        <td width="70" rowspan="2" class="tblheader" id="QTY2" onClick="ifPop.CallFr(this);">Sub Total PO</td>
        <td width="75" rowspan="2" class="tblheader" id="QTY2" onClick="ifPop.CallFr(this);">Sub Total Terima</td>
      </tr>
      <tr class="headtable"> 
        <td width="35" height="25" class="tblheader" id="QTY" onClick="ifPop.CallFr(this);">PO</td>
        <td id="QTY" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Terima</td>
        <td id="QTY" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Sisa</td>
      </tr>
      <?php 
		$cpbf_id=0;
		$cno_po="";
		$stotTerima=0;
	  	while ($rows=mysqli_fetch_array($rs)){
	  		$i++;
			$cid=$rows["ID"];
			$ctotTerima=0;
			if ($rows['QTY_SATUAN_TERIMA']>0){
				/*$sql2="SELECT DISTINCT DATE_FORMAT(TANGGAL,'%d/%m/%Y') AS TANGGAL,HARGA_BELI_SATUAN,(HARGA_BELI_SATUAN*(1-(DISKON/100)))*(1+0.1) AS aharga,DATE_FORMAT(EXPIRED,'%d/%m/%Y') AS EXPIRED,NOBUKTI FROM a_penerimaan WHERE TIPE_TRANS=0 AND FK_MINTA_ID=$cid";*/
				$sql2="SELECT IFNULL(SUM(t1.QTY_SATUAN*t1.aharga),0) AS totTerima FROM (SELECT QTY_SATUAN,IF(NILAI_PAJAK>0,(HARGA_BELI_SATUAN*(1-(DISKON/100)))*(1+0.1),(HARGA_BELI_SATUAN*(1-(DISKON/100)))) AS aharga 
FROM a_penerimaan WHERE TIPE_TRANS=0 AND FK_MINTA_ID='$cid') AS t1";
				$rs1=mysqli_query($konek,$sql2);
				$rows1=mysqli_fetch_array($rs1);
				$ctotTerima=$rows1["totTerima"];
			}
			if ($cno_po!=$rows['NO_PO']){
				$cno_po=$rows['NO_PO'];
				$cpo=$rows['NO_PO'];
				$ckpid=$rows['NAMA'];
				$ctgl=date("d/m/Y",strtotime($rows['TANGGAL']));
			}else{
				$cpo="&nbsp;";
				$ckpid="&nbsp;";
				$ctgl="&nbsp;";
			}
			if ($cpbf_id!=$rows['PBF_ID']){
				$cpbf_id=$rows['PBF_ID'];
				if ($i>1){
        ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,2,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format($stotTerima,2,",","."); ?></td>
          </tr>
        <?php
					$gtotTerima+=$stotTerima;
					$stotTerima=0;
                }
				$ctot=0;
		?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="11" class="tdisikiri" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td align="center" class="tdisikiri"><?php echo $ctgl; ?></td>
            <td align="center" class="tdisi"><?php echo $cpo; ?></td>
            <td align="center" class="tdisi"><?php echo $ckpid; ?></td>
            <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['SATUAN']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN_TERIMA']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN']-$rows['QTY_SATUAN_TERIMA']; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],2,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format($rows['QTY_SATUAN'] * $rows['aharga'],2,",","."); ?>            </td>
            <td align="right" class="tdisi"><?php echo number_format($ctotTerima,2,",","."); ?></td>
          </tr>
		<?php
				$ctot +=$rows['QTY_SATUAN'] * $rows['aharga'];
				$stotTerima+=$ctotTerima;
				$cpbfnama=$rows['PBF_NAMA'];
			}else{
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td align="center" class="tdisikiri"><?php echo $ctgl; ?></td>
        <td align="center" class="tdisi"><?php echo $cpo; ?></td>
        <td align="center" class="tdisi"><?php echo $ckpid; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['SATUAN']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN_TERIMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY_SATUAN']-$rows['QTY_SATUAN_TERIMA']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],2,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['QTY_SATUAN'] * $rows['aharga'],2,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format($ctotTerima,2,",","."); ?></td>
      </tr>
      <?php 
	  			$ctot +=$rows['QTY_SATUAN'] * $rows['aharga'];
				$stotTerima+=$ctotTerima;
	  		}
	  }
	  if ($i>0){
	  	$gtotTerima+=$stotTerima;
      ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,2,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format($stotTerima,2,",","."); ?></td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Grand Total : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($gtot,2,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format($gtotTerima,2,",","."); ?></td>
          </tr>
      <?php
      }
	  mysqli_free_result($rs);
	  ?>
    </table>
</div>
</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
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
$kpid=$_REQUEST['kpid'];
$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tglctk,$pbfid,$kpid,$tgl_d,$tgl_s);


$pbfnama="SEMUA";
if ($pbfid=="0" || $pbfid==""){
	$pbf="";
}else{
	$pbf=" AND apb.PBF_ID=$pbfid ";
	$sql="SELECT * FROM a_pbf WHERE PBF_ID=$pbfid";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)) $pbfnama=$rows["PBF_NAMA"];
}


$kpnama="SEMUA";
if ($kpid=="0" || $kpid==""){
	$kp="";
}else{
	$kp=" AND ak.ID=$kpid ";
	$sql="SELECT * FROM a_kepemilikan WHERE ID=$kpid";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)) $kpnama=$rows["NAMA"];
}


if ($tgl_d=="")	$tgl_d=$tglSkrg;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];

if ($tgl_s=="")	$tgl_s=$tglSkrg;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//====================================================================
convert_var($tgl_d1,$tgl_s1);
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="apb.PBF_NAMA,a.NO_PO,a.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

convert_var($page,$sorting,$filter,$act);

?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=800,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
</head>
<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
        <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="retur_id" id="retur_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

  <div id="cetak" style="display:none">
  <link rel="stylesheet" href="../theme/print.css" type="text/css" />
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
<div id="listma" style="display:block">
    <p align="center"><span class="jdltable">LAPORAN REALISASI PENGADAAN</span> 
  <table border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
  <tr>
    <td>PBF</td>
    <td>:
      <select name="pbfid" id="pbfid" class="txtinput" onChange="location='?f=../report/realisasi_po.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&pbfid='+pbfid.value">
          <option value="0" class="txtinput"<?php if ($kpid=="") echo " selected";?>>SEMUA</option>
          <?
		  $qry="SELECT * FROM a_pbf WHERE PBF_ISAKTIF=1 ORDER BY PBF_NAMA";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
          <option value="<?php echo $show['PBF_ID'];?>" class="txtinput"<?php if ($pbfid==$show['PBF_ID']) echo " selected";?>><?php echo $show["PBF_NAMA"];?></option>
          <? }?>
      </select></td>
  </tr>
  <tr> 
          <td width="90">Kepemilikan</td>
        <td>:            
        <select name="kpid" id="kpid" class="txtinput" onChange="location='?f=../report/realisasi_po.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&pbfid='+pbfid.value">
              <option value="0" class="txtinput"<?php if ($kpid=="") echo " selected";?>>SEMUA</option>
          <?
		  $qry="SELECT * FROM a_kepemilikan ORDER BY ID";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?php echo $show['ID'];?>" class="txtinput"<?php if ($kpid==$show['ID']) echo " selected";?>><?php echo $show["NAMA"];?></option>
              <? }?>
            </select></td>
      </tr>
        <tr> 
          <td>Tgl PO</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_d; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" /> 
            s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_s; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
            <button type="button" onClick="location='?f=../report/realisasi_po.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&pbfid='+pbfid.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>
    <p align="center">
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
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";

	  	$rs=mysqli_query($konek,$sql2);
	  	$i=($page-1)*$perpage;
		$cpbf_id=0;
		$cno_po="";
		$stotTerima=0;
	  	while ($rows=mysqli_fetch_array($rs)){
	  		$i++;
			$cid=$rows["ID"];
			$ctotTerima=0;
			if ($rows['QTY_SATUAN_TERIMA']>0){
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
            <td align="right" class="tdisi"><?php echo number_format($rows['QTY_SATUAN'] * $rows['aharga'],2,",","."); ?></td>
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
  <table align="center" width="99%" border="0">
    <tr> 
        <td height="36" colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td width="521" colspan="4" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
</table>
<p align="center">
  <BUTTON type="button" onClick="PrintArea('cetak','#')" <?php if($i==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
  Realisasi PO&nbsp;&nbsp;</BUTTON>
  <BUTTON type="button" onClick="OpenWnd('../report/realisasi_po_rpt.php?tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&kpid=<?php echo $kpid; ?>&pbfid=<?php echo $pbfid; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
 
</p>
</div>
</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
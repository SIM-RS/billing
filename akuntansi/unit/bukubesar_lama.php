<?php 
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);

$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$idma=$_GET['idma'];if ($idma=="") $idma="0";
$ccrvpbfumum=$_REQUEST['ccrvpbfumum'];if ($ccrvpbfumum=="") $ccrvpbfumum="0";
$idccrvpbfumum=$_REQUEST['idccrvpbfumum'];if ($idccrvpbfumum=="") $idccrvpbfumum="0";
$cc_islast=$_REQUEST['cc_islast'];if ($cc_islast=="") $cc_islast="0";
$rptccrvpbfumum=$ccrvpbfumum;
$rptidccrvpbfumum=$idccrvpbfumum;
$rptcc_islast=$cc_islast;
$kode_ma=$_REQUEST['kode_ma'];
$detail=$_REQUEST['detail'];
$islast=$_REQUEST['islast'];if ($islast=="") $islast="1";
$all_unit=$_REQUEST['all_unit'];if ($all_unit=="") $all_unit="0";
$ma=$_REQUEST['ma'];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$qstr_ma="par=idma*kode_ma*ma*parent_lvl&bulan=$bulan&ta=$ta";

$page=$_REQUEST["page"];
$defaultsort="tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$sql="select * from ma_sak where ma_id=$idma";
$rs1=mysql_query($sql);
if ($rows=mysql_fetch_array($rs1)){
	$kode_ma=$rows["MA_KODE"];
	$ma=trim($rows["MA_NAMA"]);
	$ckso_type=$rows["MA_TYPE"];
}

$saldoawal=0;
if ($idccrvpbfumum!="0"){
	switch ($ccrvpbfumum){
		case 1:
			$sql="SELECT * FROM ak_ms_unit WHERE id='$idccrvpbfumum'";
			//echo $sql."<br>";
	
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN ak_ms_unit mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.id WHERE s.bulan=$bulan AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.kode LIKE '$kode_cc%'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 2:
			$sql="SELECT kode_ak kode,nama FROM $dbbilling.b_ms_kso WHERE id='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbbilling.b_ms_kso mu ON s.CC_RV_ID=mu.id WHERE s.bulan=$bulan AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.id='$idccrvpbfumum'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 3:
			$sql="SELECT PBF_KODE_AK kode,PBF_NAMA nama FROM $dbapotek.a_pbf WHERE PBF_ID='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbapotek.a_pbf mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.PBF_ID WHERE s.bulan=$bulan AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.PBF_ID='$idccrvpbfumum'";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
		case 4:
			$sql="SELECT koderekanan kode,namarekanan nama FROM $dbaset.as_ms_rekanan WHERE idrekanan='$idccrvpbfumum'";
			//echo $sql."<br>";
			$rscc=mysql_query($sql);
			if ($rows=mysql_fetch_array($rscc)){
				$kode_cc=$rows["kode"];
				$kode_ma.=$kode_cc;
				$ma=trim($rows["nama"]);
				$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ma ON s.FK_MAID=ma.MA_ID INNER JOIN $dbaset.as_ms_rekanan mu ON s.CC_RV_KSO_PBF_UMUM_ID=mu.idrekanan WHERE s.bulan=$bulan AND s.tahun=$ta AND s.FK_MAID=$idma AND mu.idrekanan='$idccrvpbfumum'";
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$saldoawal=$rows1['SALDO_AWAL'];
				}
			}
			break;
	}
}else{
	$sql="SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo INNER JOIN ma_sak ON FK_MAID=MA_ID WHERE bulan=$bulan AND tahun=$ta AND MA_KODE LIKE '$kode_ma%'";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	if ($rows=mysql_fetch_array($rs)){
		$saldoawal=$rows['SALDO_AWAL'];
	}
}
$tot=0;
$stotd=0;
$stotk=0;
$totd=0;
$totk=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Buku Besar</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<form name="form1" method="post">
	<input name="act" id="act" type="hidden" value="">
  	<input name="idma" id="idma" type="hidden" value="<?php echo $idma; ?>">
  	<input name="idccrvpbfumum" id="idccrvpbfumum" type="hidden" value="<?php echo $idccrvpbfumum; ?>">
  	<!--input name="kode_ma" id="kode_ma" type="hidden" value="<?php //echo $kode_ma; ?>"-->
  	<input name="islast" id="islast" type="hidden" value="<?php echo $islast; ?>">
  	<input name="parent_lvl" id="parent_lvl" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<div id="listjurnal" style="display:block">
<span class="jdltable">Buku Besar </span><br>
  <table width="99%" border="0" cellpadding="2" cellspacing="0" class="txtinput">
  	<tr>
		<td width="150">User</td>
		<td width="10">:</td>
		<td><?php echo $iunit; ?></td>
	</tr>
  	<tr>
		<td>Buku Besar</td>
		<td>:</td>
		<td><select name="bulan" id="bulan" class="txtinput" onchange="location='?f=bukubesar.php&idma='+idma.value+'&kode_ma=<?php echo $kode_ma; ?>&ccrvpbfumum=<?php echo $ccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&islast=<?php echo $islast; ?>&ta='+ta.value+'&bulan='+bulan.value+'&detail=<?php echo $detail; ?>&cc_islast=<?php echo $cc_islast; ?>'">
              <option value="1" label="Januari">Januari</option>
              <option value="2" label="Pebruari" <?php if ($bulan==2) echo "selected";?>>Pebruari</option>
              <option value="3" label="Maret" <?php if ($bulan==3) echo "selected";?>>Maret</option>
              <option value="4" label="April" <?php if ($bulan==4) echo "selected";?>>April</option>
              <option value="5" label="Mei" <?php if ($bulan==5) echo "selected";?>>Mei</option>
              <option value="6" label="Juni" <?php if ($bulan==6) echo "selected";?>>Juni</option>
              <option value="7" label="Juli" <?php if ($bulan==7) echo "selected";?>>Juli</option>
              <option value="8" label="Agustus" <?php if ($bulan==8) echo "selected";?>>Agustus</option>
              <option value="9" label="September" <?php if ($bulan==9) echo "selected";?>>September</option>
              <option value="10" label="Oktober" <?php if ($bulan==10) echo "selected";?>>Oktober</option>
              <option value="11" label="Nopember" <?php if ($bulan==11) echo "selected";?>>Nopember</option>
              <option value="12" label="Desember" <?php if ($bulan==12) echo "selected";?>>Desember</option>
            </select>
            <select name="ta" id="ta" class="txtinput" onchange="location='?f=bukubesar.php&idma='+idma.value+'&kode_ma=<?php echo $kode_ma; ?>&ccrvpbfumum=<?php echo $ccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&islast=<?php echo $islast; ?>&ta='+ta.value+'&bulan='+bulan.value+'&detail=<?php echo $detail; ?>&cc_islast=<?php echo $cc_islast; ?>'">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
            </select>
		 </td>
	</tr>
  	<tr>
		<td>Kode Rekening</td>
		<td>:</td>
		  <td> <input name="kode_ma" type="text" id="kode_ma" class="txtinput" size="20" maxlength="20" readonly="true" value="<?php echo $kode_ma; ?>" /> 
            <input type="button" name="Button" value="..." class="txtcenter" onclick="OpenWnd('tree_ma_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)" /><br>
            <textarea name="ma" cols="75" rows="2" readonly="true" class="txtinput" id="ma"><?php echo $ma; ?></textarea> </td>
	</tr>
  	<tr>
		<td>Saldo Awal</td>
		<td>:</td>
		  <td><input name="textfield" type="text" class="txtright" value="<?php if ($saldoawal>=0) echo number_format($saldoawal,0,",","."); else echo "(".number_format(-$saldoawal,0,",",".").")"; ?>" size="15" readonly="true" />&nbsp;</td>
	</tr>
  </table>
<?php 
if (($islast=="1" && $ccrvpbfumum=="0") || ($cc_islast=="1" && $ccrvpbfumum!="0")){
?>
  <table width="99%" border="0" cellpadding="2" cellspacing="0">
    <tr class="headtable"> 
      <td width="30" class="tblheaderkiri">No</td>
      <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl</td>
      <!--td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td-->
	  <td id="NO_KW" width="80" class="tblheader" onClick="ifPop.CallFr(this);">No Bukti</td>
      <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode SAK</td>
      <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
      <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Debet</td>
      <td id="KREDIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Kredit</td>
    </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($kode_ma=="") $kode_ma=chr(9);
	  	if ($ccrvpbfumum=="0"){
	   		$sql="Select ma_sak.MA_ID, ma_sak.MA_KODE, ma_sak.MA_NAMA,ma_sak.MA_PARENT,1 as MA_ISLAST,date_format(TGL,'%d/%m/%Y') as tgl1,j.TR_ID,j.NO_TRANS,j.TGL,j.NO_KW,j.URAIAN,j.DEBIT,j.KREDIT,j.D_K From jurnal j Inner Join ma_sak ON j.FK_SAK = ma_sak.MA_ID where MA_ID = $idma and month(tgl)=$bulan and year(tgl)=".$_GET[ta]." order by TGL,TR_ID";
		}elseif ($ccrvpbfumum=="1"){
	   		$sql="Select ma_sak.MA_ID, ma_sak.MA_KODE, ma_sak.MA_NAMA,ma_sak.MA_PARENT,1 as MA_ISLAST,date_format(TGL,'%d/%m/%Y') as tgl1,j.TR_ID,j.NO_TRANS,j.TGL,j.NO_KW,j.URAIAN,j.DEBIT,j.KREDIT,j.D_K From jurnal j Inner Join ma_sak ON j.FK_SAK = ma_sak.MA_ID where MA_ID = $idma AND j.CC_RV_ID='$idccrvpbfumum' and month(tgl)=$bulan and year(tgl)=".$_GET[ta]." order by TGL,TR_ID";
		}else{
	   		$sql="Select ma_sak.MA_ID, ma_sak.MA_KODE, ma_sak.MA_NAMA,ma_sak.MA_PARENT,1 as MA_ISLAST,date_format(TGL,'%d/%m/%Y') as tgl1,j.TR_ID,j.NO_TRANS,j.TGL,j.NO_KW,j.URAIAN,j.DEBIT,j.KREDIT,j.D_K From jurnal j Inner Join ma_sak ON j.FK_SAK = ma_sak.MA_ID where MA_ID = $idma AND j.CC_RV_KSO_PBF_UMUM_ID='$idccrvpbfumum' and month(tgl)=$bulan and year(tgl)=".$_GET[ta]." order by TGL,TR_ID";
		}
	   //echo $sql;
	  	$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";

	  $rs=mysql_query($sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$cdebit=$rows['DEBIT'];
		$ckredit=$rows['KREDIT'];
		$uraian=$rows['URAIAN'];
		$cparent=$rows['MA_PARENT'];
	  ?>
		<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
		  <td class="tdisikiri"><?php echo $i; ?></td>
		  <td class="tdisi">&nbsp;<?php echo $rows['tgl1']; ?></td>
		  <td class="tdisi">&nbsp;<?php echo $rows['NO_KW']; ?></td>
		  <td align="left" class="tdisi"><?php echo $rows['MA_KODE']; ?></td>
		  <td align="left" class="tdisi"><?php echo $uraian; ?></td>
		  <td class="tdisi" align="right"><?php echo number_format($cdebit,2,",","."); ?></td>
		  <td class="tdisi" align="right"><?php echo number_format($ckredit,2,",","."); ?></td>
		</tr>		
	  <? 
	  }
	  $sql2="SELECT IFNULL(SUM(t1.DEBIT),0) AS subTotD,IFNULL(SUM(t1.KREDIT),0) AS subTotK FROM 
(".$sql.") AS t1";
	  $rs=mysql_query($sql2);
	  $rwsTot=mysql_fetch_array($rs);
		$stotd=$rwsTot["subTotD"];
		$stotk=$rwsTot["subTotK"];
	  
	  mysql_free_result($rs);
		$tot=$saldoawal+$stotd-$stotk;
		if ($tot>0){
			$totd=$tot;
		}else{
			$totk=$tot * (-1);
		}
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td colspan="5" class="tdisikiri" align="right">Subtotal&nbsp;&nbsp;</td>
      <td class="tdisi" align="right"><?php echo number_format($stotd,2,",","."); ?></td>
      <td class="tdisi" align="right"><?php echo number_format($stotk,2,",","."); ?></td>
    </tr>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td colspan="5" class="tdisikiri" align="right">Saldo Akhir&nbsp;&nbsp;</td>
      <td class="tdisi" align="right"><?php echo (($totd>0)?number_format($totd,2,",","."):"&nbsp;"); ?></td>
      <td class="tdisi" align="right"><?php echo (($totk>0)?number_format($totk,2,",","."):"&nbsp;"); ?></td>
    </tr>
	  <?php //}?>
      <tr> 
        <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td colspan="3" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
  </table>
<?php 
}else{
?>
      <table width="99%" border="0" cellpadding="2" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <!--td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td-->
          <td id="ma_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            SAK</td>
          <td id="URAIAN" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            MA SAK </td>
          <td id="DEBIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Debet</td>
          <td id="KREDIT" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Kredit</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($kode_ma=="") $kode_ma=chr(9);
		$stotd=0;
		$stotk=0;
		if ($ccrvpbfumum=="0"){
			$sql="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal inner join ma_sak on FK_SAK=MA_ID where MA_KODE like '$kode_ma%' and month(TGL)=$bulan and year(TGL)=$ta";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$rwsTot=mysql_fetch_array($rs);
			$stotd=$rwsTot["subTotD"];
			$stotk=$rwsTot["subTotK"];
	   		$sql="select * from ma_sak where MA_PARENT=$idma order by MA_KODE";
	   	}else{
	   		switch($ccrvpbfumum){
				case 1:
					if (substr($kode_ma,0,1)=="4"){
						$sql5="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID INNER JOIN ak_ms_unit mu ON j.CC_RV_ID=mu.id where MA_ID='$idma' AND mu.kode LIKE '$kode_cc%' AND LEFT(mu.kode,2)<>'08' and month(j.TGL)=$bulan and year(j.TGL)=$ta";
						
						$sql="SELECT * FROM ak_ms_unit WHERE parent_id='$idccrvpbfumum' AND LEFT(kode,2)<>'08' ORDER BY kode";
					}else{
						$sql5="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID INNER JOIN ak_ms_unit mu ON j.CC_RV_ID=mu.id where MA_ID='$idma' AND mu.kode LIKE '$kode_cc%' and month(j.TGL)=$bulan and year(j.TGL)=$ta";

						$sql="SELECT * FROM ak_ms_unit WHERE parent_id='$idccrvpbfumum' ORDER BY kode";
					}
					//echo $sql5."<br>";
					$rs=mysql_query($sql5);
					$rwsTot=mysql_fetch_array($rs);
					$stotd=$rwsTot["subTotD"];
					$stotk=$rwsTot["subTotK"];
					break;
				case 2:
					$sql5="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID INNER JOIN $dbbilling.b_ms_kso kso ON j.CC_RV_KSO_PBF_UMUM_ID=kso.id where MA_ID='$idma' AND kso.kode_ak LIKE '$kode_cc%' and month(j.TGL)=$bulan and year(j.TGL)=$ta";
					$rs=mysql_query($sql5);
					$rwsTot=mysql_fetch_array($rs);
					$stotd=$rwsTot["subTotD"];
					$stotk=$rwsTot["subTotK"];
					
					$ckso_filter=" AND type=0";
					if ($ckso_type==1){
						$ckso_filter=" AND type=1";
					}
					$sql="SELECT * FROM $dbbilling.b_ms_kso WHERE id>1".$ckso_filter." ORDER BY kode_ak";
					break;
				case 3:
					if ($idccrvpbfumum==0){
						$sql="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal inner join ma_sak on FK_SAK=MA_ID where MA_ID='$idma' and month(TGL)=$bulan and year(TGL)=$ta";
					}else{
						$sql="SELECT IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK 
FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID INNER JOIN $dbapotek.a_pbf pbf ON j.CC_RV_KSO_PBF_UMUM_ID=pbf.PBF_ID
WHERE ma.MA_ID='$idma' AND pbf.PBF_KODE_AK LIKE '$kode_cc%' AND MONTH(j.TGL)=$bulan AND YEAR(j.TGL)=$ta";
					}
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					$rwsTot=mysql_fetch_array($rs);
					$stotd=$rwsTot["subTotD"];
					$stotk=$rwsTot["subTotK"];

					$sql="SELECT * FROM $dbapotek.a_pbf ORDER BY PBF_KODE_AK";
					break;
				case 4:
					$sql5="select IFNULL(SUM(DEBIT),0) AS subTotD,IFNULL(SUM(KREDIT),0) AS subTotK from jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID INNER JOIN $dbaset.as_ms_rekanan rek ON j.CC_RV_KSO_PBF_UMUM_ID=rek.idrekanan where MA_ID='$idma' AND rek.koderekanan LIKE '$kode_cc%' and month(j.TGL)=$bulan and year(j.TGL)=$ta";
					$rs=mysql_query($sql5);
					$rwsTot=mysql_fetch_array($rs);
					$stotd=$rwsTot["subTotD"];
					$stotk=$rwsTot["subTotK"];

					$sql="SELECT * FROM $dbaset.as_ms_rekanan ORDER BY koderekanan";
					break;
			}
	   }
	   //echo $sql;
	  	$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  	
		$tccrvpbfumum=$ccrvpbfumum;
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$cdebit=0;
			$ckredit=0;
			
			if ($ccrvpbfumum=="0"){
				$ckode=$rows['MA_KODE'];
				$cid=$rows['MA_ID'];
				$cislast=$rows['MA_ISLAST'];
				$tccrvpbfumum=$rows['CC_RV_KSO_PBF_UMUM'];
				$dkode=$ckode;
				$dma=$rows['MA_NAMA'];
				$cc_islast=0;
				$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT from jurnal inner join ma_sak on FK_SAK=MA_ID where MA_KODE like '$ckode%' and month(TGL)=$bulan and year(TGL)=$ta";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$cdebit=$rows1['DEBIT'];
					$ckredit=$rows1['KREDIT'];
				}
			}else{				
				$ckode=$kode_ma;
				$cid=$idma;
				$cislast=1;
				switch($ccrvpbfumum){
					case 1:
						$idccrvpbfumum=$rows['id'];
						$dkode=$kode_ma.$rows['kode'];
						$dma=$rows['nama'];
						$cc_islast=$rows['islast'];
						$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID INNER JOIN ak_ms_unit mu ON j.CC_RV_ID=mu.id where MA_ID='$idma' AND mu.kode LIKE '".$rows['kode']."%' and month(TGL)=$bulan and year(TGL)=$ta";
						break;
					case 2:
						$idccrvpbfumum=$rows['id'];
						$dkode=$kode_ma.$rows['kode_ak'];
						$dma=$rows['nama'];
						$cc_islast=1;
						$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan and year(TGL)=$ta";
						break;
					case 3:
						$idccrvpbfumum=$rows['PBF_ID'];
						$dkode=$kode_ma.$rows['PBF_KODE_AK'];
						$dma=$rows['PBF_NAMA'];
						$cc_islast=1;
						$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan and year(TGL)=$ta";
						break;
					case 4:
						$idccrvpbfumum=$rows['idrekanan'];
						$dkode=$kode_ma.$rows['koderekanan'];
						$dma=$rows['namarekanan'];
						$cc_islast=1;
						$sql="select if (sum(DEBIT) is null,0,sum(DEBIT)) as DEBIT,if (sum(KREDIT) is null,0,sum(KREDIT)) as KREDIT FROM jurnal j INNER JOIN ma_sak ON FK_SAK=MA_ID where MA_ID='$idma' AND j.CC_RV_KSO_PBF_UMUM_ID='".$idccrvpbfumum."' and month(TGL)=$bulan and year(TGL)=$ta";
						break;
				}
				//echo $sql."<br>";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$cdebit=$rows1['DEBIT'];
					$ckredit=$rows1['KREDIT'];
				}
			}
			/*$stotd+=$cdebit;
			$stotk+=$ckredit;*/
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><a href="?f=bukubesar&idma=<?php echo $cid; ?>&ccrvpbfumum=<?php echo $tccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&cc_islast=<?php echo $cc_islast; ?>&kode_ma=<?php echo $ckode; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&islast=<?php echo $cislast; ?>&detail=true"><?php echo $dkode; ?></a></td>
          <td align="left" class="tdisi"><a href="?f=bukubesar&idma=<?php echo $cid; ?>&ccrvpbfumum=<?php echo $tccrvpbfumum; ?>&idccrvpbfumum=<?php echo $idccrvpbfumum; ?>&cc_islast=<?php echo $cc_islast; ?>&kode_ma=<?php echo $ckode; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&islast=<?php echo $cislast; ?>&detail=true"><?php echo $dma; ?></a></td>
          <td class="tdisi" align="right"><?php echo number_format($cdebit,2,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($ckredit,2,",","."); ?></td>
        </tr>
        <? 
	  }
	  mysql_free_result($rs);
		$tot=$saldoawal+$stotd-$stotk;
		if ($tot>0){
			$totd=$tot;
		}else{
			$totk=$tot * (-1);
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td colspan="3" class="tdisikiri" align="right">Subtotal&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($stotd,2,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($stotk,2,",","."); ?></td>
        </tr>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td colspan="3" class="tdisikiri" align="right">Saldo Akhir&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo (($totd>0)?number_format($totd,2,",","."):"&nbsp;"); ?></td>
          <td class="tdisi" align="right"><?php echo (($totk>0)?number_format($totk,2,",","."):"&nbsp;"); ?></td>
        </tr>
        <?php //}?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
<?php
}
?><br>
    <BUTTON type="button" onClick="BukaWndExcell();" <?php if ($i==0) echo 'disabled="disabled"';?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
    <?php if ($detail=="true"){?>
    <BUTTON type="button" onClick="history.back();"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Kembali</strong></BUTTON>
    <?php }?>
  </div>
</form>
</div>
</body>
<script language="javascript">
function BukaWndExcell(){
	//alert(bulan.options[bulan.options.selectedIndex].label);
	OpenWnd('../report/bukubesar_print.php?idma='+idma.value+'&kode_ma='+kode_ma.value+'&ma='+ma.value+'&bulan='+bulan.value+'|'+bulan.options[bulan.options.selectedIndex].label+'&ta='+ta.value+'&cislast='+islast.value+'&ccrvpbfumum=<?php echo $rptccrvpbfumum; ?>&idccrvpbfumum=<?php echo $rptidccrvpbfumum; ?>&cc_islast=<?php echo $rptcc_islast; ?>',600,450,'childwnd',true);
}
</script>
</html>
<?php 
mysql_close($konek);
?>
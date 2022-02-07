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
$kpid=$_REQUEST['kpid'];
$kpnama="SEMUA";
if ($kpid=="0" || $kpid==""){
	$kp="";
}else{
	$kp=" AND k.ID=$kpid ";
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
$defaultsort="PBF_NAMA,RETUR_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act."<br>";

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
    <p align="center"><span class="jdltable">RETURN OBAT KE PBF</span> 
    <p align="center">
    <table width="27%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr> 
          <td width="80">Kepemilikan</td>
          <td>: <?php echo $kpnama; ?></td>
        </tr>
        <tr> 
          <td>Tgl Return</td>
          <td>: <?php echo $tgl_d." s/d ".$tgl_s; ?></td>
        </tr>
      </table>         
<?
	  if ($filter!=""){
		$filter2=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //if ($_GET['pbf']<>"") $pbf=$_GET['pbf']; else $pbf=0; 
		$sql="SELECT ar.*,DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tglfaktur,FLOOR(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI 
FROM a_penerimaan_retur ar INNER JOIN a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
INNER JOIN a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
INNER JOIN a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN a_kepemilikan k 
ON ar.KEPEMILIKAN_ID = k.ID 
WHERE ar.TGL BETWEEN '$tgl_d1' AND '$tgl_s1'".$kp.$filter." ORDER BY ".$sorting;
	  	//echo $sql;
		$gtot=0;
		$sql2="SELECT IF (SUM(FLOOR(t1.QTY*t1.aharga)) IS NULL,0,SUM(FLOOR(t1.QTY*t1.aharga))) AS gtot FROM (".$sql.") AS t1";
		$rs=mysqli_query($konek,$sql2);
		if ($rows=mysqli_fetch_array($rs)) $gtot=$rows["gtot"];
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		
?>		
    <table width="99%" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri" id="RETUR_ID" onClick="ifPop.CallFr(this);">No</td>
        <td width="75" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Return</td>
        <td id="NO_RETUR" width="145" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Return</td>
        <td width="75" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Faktur</td>
        <td id="NO_FAKTUR" width="90" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Faktur </td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Obat</td>
        <td width="70" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Milik</td>
        <td id="QTY" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="QTY" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Harga</td>
        <td id="QTY" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
        <td id="KET" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Keterangan</td>
      </tr>
      <?php 
	  	$i=0;
		$cpbf_id=0;
	  	while ($rows=mysqli_fetch_array($rs)){
	  		$i++;
			if ($cpbf_id!=$rows['PBF_ID']){
				$cpbf_id=$rows['PBF_ID'];
				if ($i>1){
        ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
          </tr>
        <?php
                }
				$ctot=0;
		?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="11" class="tdisikiri" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td align="center" class="tdisikiri"><?php echo $i; ?></td>
            <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
            <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['tglfaktur']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['NOBUKTI']; ?></td>
            <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['QTY']; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],0,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."); ?>
            </td>
            <td align="left" class="tdisi"><?php echo $rows['KET']; ?></td>
          </tr>
		<?php
				$ctot +=floor($rows['QTY'] * $rows['aharga']);
				$cpbfnama=$rows['PBF_NAMA'];
			}else{
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td align="center" class="tdisikiri"><?php echo $i; ?></td>
        <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['tglfaktur']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NOBUKTI']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],0,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."); ?></td>
        <td align="left" class="tdisi"><?php echo $rows['KET']; ?></td>
      </tr>
      <?php 
	  			$ctot +=floor($rows['QTY'] * $rows['aharga']);
	  		}
	  }
	  if ($i>0){
      ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Grand Total : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($gtot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
          </tr>
      <?php
      }
	  mysqli_free_result($rs);
	  ?>
    </table>
</div>
<div id="listma" style="display:block">
    <p align="center"><span class="jdltable">RETURN OBAT KE PBF</span> 
    <table width="50%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr> 
          <td width="120">Kepemilikan</td>
          <td width="487">:            
          <select name="kpid" id="kpid" class="txtinput" onChange="location='?f=../gudang/obat_kepbf.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value">
              <option value="" class="txtinput"<?php if ($kpid=="") echo " selected";?>>SEMUA</option>
          <?
		  $qry="SELECT * FROM a_kepemilikan ORDER BY ID";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kpid==$show['ID']) echo " selected";?>><?php echo $show["NAMA"];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td width="120">Tgl Return</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_d; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" /> 
            s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl_s; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
            <button type="button" onClick="location='?f=../gudang/obat_kepbf.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>
    <p align="center">
    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri" id="RETUR_ID" onClick="ifPop.CallFr(this);">No</td>
        <td width="75" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Return</td>
        <td id="NO_RETUR" width="145" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Return</td>
        <td width="75" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Faktur</td>
        <td id="NO_FAKTUR" width="90" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Faktur </td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Obat</td>
        <td width="70" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Milik</td>
        <td id="QTY" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="QTY" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Harga</td>
        <td id="QTY" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
        <td id="KET" width="120" class="tblheader" onClick="ifPop.CallFr(this);">Keterangan</td>
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
	  	while ($rows=mysqli_fetch_array($rs)){
	  		$i++;
			//$j++;
			if ($cpbf_id!=$rows['PBF_ID']){
				$cpbf_id=$rows['PBF_ID'];
				if ($i>1){
        ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
          </tr>
        <?php
                }
				$ctot=0;
		?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="11" class="tdisikiri" align="left">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td class="tdisikiri"><?php echo $i; ?></td>
            <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
            <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['tglfaktur']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['NOBUKTI']; ?></td>
            <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
            <td align="center" class="tdisi"><?php echo $rows['QTY']; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],0,",","."); ?></td>
            <td align="right" class="tdisi"><?php echo number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."); ?>
            </td>
            <td align="left" class="tdisi"><?php echo $rows['KET']; ?></td>
          </tr>
		<?php
				$ctot +=floor($rows['QTY'] * $rows['aharga']);
				$cpbfnama=$rows['PBF_NAMA'];
			}else{
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['tglfaktur']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NOBUKTI']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['aharga'],0,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."); ?></td>
        <td align="left" class="tdisi"><?php echo $rows['KET']; ?></td>
      </tr>
      <?php 
	  			$ctot +=floor($rows['QTY'] * $rows['aharga']);
	  		}
	  }
	  if ($i>0){
      ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Total ".$cpbfnama." : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($ctot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
          </tr>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td colspan="9" class="tdisikiri" align="right"><?php echo "Grand Total : "; ?></td>
            <td align="right" class="tdisi"><?php echo number_format($gtot,0,",","."); ?>
            <td align="left" class="tdisi">&nbsp;</td>
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
  Return Obat &nbsp;&nbsp;</BUTTON>
&nbsp;
<BUTTON type="button" onClick="exportExcel()" <?php if($jmldata==0) echo 'disabled'; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export Ke Excel&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
</p>
</div>
</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<script>
function exportExcel(){
	OpenWnd('retur_ke_pbf_Excell.php?tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&kpid='+kpid.value+'&kp=<?php echo $kp; ?>&filter=<?php echo $filter2; ?>&sorting=<?php echo $sorting; ?>',600,450,'childwnd',true);
}
</script>
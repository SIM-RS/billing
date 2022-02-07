<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//==========================================
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$unit_tujuan=$_REQUEST['unit_tujuan']; if(($unit_tujuan=="0")||($unit_tujuan=="")) $unit_tj=""; else $unit_tj="and ap.UNIT_ID_TERIMA=$unit_tujuan";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="ap.NOKIRIM desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<form name="form1" method="post" action="">
<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<input type="hidden" name="filter1" id="filter1" value="<?php echo $filter1; ?>">
	<div id="idArea" style="display:block">
	  <p><span class="jdltable">LAPORAN PENGELUARAN OBAT<br>UNIT : <?php echo $namaunit; ?></span></p>
      <table width="49%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
<tr>
<td width="120">Tanggal Periode</td>
          <td width="157">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;</td>
			<td width="54">s/d</td>
		    <td colspan="">: 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />          </td>
</tr>
<tr>
<td width="120">Unit Tujuan </td>
            <td colspan="2">:
              <select name="unit_tujuan" id="unit_tujuan" onchange="location='?f=../gudang/list_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value">
                <option value="0">All Unit</option>
                <?
	  			$qry = "select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>1 and UNIT_TIPE<>4 and UNIT_ISAKTIF=1";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
				//$id=$show['UNIT_ID']
	  			?>
                <option value="<?php echo $show['UNIT_ID'];?>" class="txtinput" <?php if ($unit_tujuan==$show['UNIT_ID']) echo " selected"; ?>>
                <?=$show['UNIT_NAME'];?>
                </option>
                <? }?>
              </select></td>
			  <td width="193">
			  <button type="button" onclick="location='?f=../gudang/list_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
    </tr>
	</table>
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="75" class="tblheader" onclick="ifPop.CallFr(this);">Tgl</td>
          <td align="center" id="ap.NOKIRIM" width="150" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Kirim</td>
          <td align="center" id="UNIT_NAME" width="130" class="tblheader" onclick="ifPop.CallFr(this);">Unit</td>
          <td align="center" id="OBAT_KODE" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Kode</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
		$sql="Select date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.NOKIRIM,sum(ap.QTY_SATUAN) as QTY_SATUAN,sum(FLOOR(ap.QTY_SATUAN*ap.HARGA_BELI_SATUAN)) as HARGA_BELI_TOTAL,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,au.UNIT_NAME From a_penerimaan ap inner Join a_unit au ON au.UNIT_ID = ap.UNIT_ID_TERIMA inner Join a_obat ao ON ap.OBAT_ID = ao.OBAT_ID inner Join a_kepemilikan ak ON ak.ID = ap.KEPEMILIKAN_ID where ap.UNIT_ID_KIRIM=$idunit AND ap.TIPE_TRANS=1 and ap.QTY_SATUAN>0 and ap.TANGGAL between '$tgl_1' and '$tgl_2'".$unit_tj.$filter." group by ap.NOKIRIM,ao.OBAT_NAMA,ak.NAMA order by ".$sorting;
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
	  $tglkrm="";
	  $no_krm="";
	  $unit_t="";
	  while ($rows=mysqli_fetch_array($rs)){
		$no_krm1=($no_krm==$rows['NOKIRIM'])?"&nbsp;":$rows['NOKIRIM'];
		if ($no_krm1!="&nbsp;"){
			$i++;
			$i1=$i;
			$tglx=$rows['tgl1'];
			$unit_t1=$rows['UNIT_NAME'];
		}else{
			$i1="&nbsp;";
			$tglx="&nbsp;";
			$unit_t1="&nbsp;";
		}
		
		$tglkrm=$rows['tgl1'];
		$no_krm=$rows['NOKIRIM'];
		$unit_t=$rows['UNIT_NAME'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i1; ?></td>
          <td class="tdisi" align="center" ><?php echo $tglx; ?></td>
          <td class="tdisi" align="center"><?php echo $no_krm1; ?></td>
          <td class="tdisi" align="center"><?php echo $unit_t1; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_TOTAL'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
		$sql2="select if(sum(t1.HARGA_BELI_TOTAL) is null,0,sum(t1.HARGA_BELI_TOTAL)) as SUB_TOTAL from (".$sql.") as t1";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$subtotal=0;
		if ($rows=mysqli_fetch_array($rs)) $subtotal=$rows['SUB_TOTAL'];
	  	mysqli_free_result($rs);	  
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="8" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($subtotal,0,",","."); ?></td>
        </tr>
      </table>
    <table width="90%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
	 <tr>
          <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
        </tr>
	 <td align="center" colspan="2">&nbsp;
		    <BUTTON type="button" onclick="PrintArea('cetak','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Pengeluaran Obat</BUTTON>
	 </td>
		</tr>
		</table>
</div>
<div id="cetak" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <table width="30%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="2" align="center" class="jdltable"><p>LAPORAN PENGELUARAN 
              OBAT<br>
              UNIT : <?php echo $namaunit; ?></p></td>
        </tr>
        <tr> 
          <td colspan="2" align="center">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> 
            ) </td>
        </tr>
        <tr> 
          <td colspan="2" align="center">Unit Tujuan : 
            <?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
			?>
          </td>
        </tr>
      </table>
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="75" class="tblheader" onclick="ifPop.CallFr(this);">Tgl</td>
          <td align="center" id="a_penerimaan.ID" width="150" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Kirim</td>
          <td align="center" id="UNIT_NAME" width="130" class="tblheader" onclick="ifPop.CallFr(this);">Unit</td>
          <td align="center" id="OBAT_KODE" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Kode</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  $tglkrm="";
	  $no_krm="";
	  $unit_t="";
	  while ($rows=mysqli_fetch_array($rs)){
		$no_krm1=($no_krm==$rows['NOKIRIM'])?"&nbsp;":$rows['NOKIRIM'];
		if ($no_krm1!="&nbsp;"){
			$i++;
			$i1=$i;
			$tglx=$rows['tgl1'];
			$unit_t1=$rows['UNIT_NAME'];
		}else{
			$i1="&nbsp;";
			$tglx="&nbsp;";
			$unit_t1="&nbsp;";
		}
		
		$tglkrm=$rows['tgl1'];
		$no_krm=$rows['NOKIRIM'];
		$unit_t=$rows['UNIT_NAME'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $tglx; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $no_krm1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $unit_t1; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_BELI_TOTAL'],0,",","."); ?></td>
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	    <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="8" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($subtotal,0,",","."); ?></td>
        </tr>
      </table>
	</div>
</form>
</div>
</body>
</html>

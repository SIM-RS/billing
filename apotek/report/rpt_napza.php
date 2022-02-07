<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//==========================================
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
convert_var($tgl2,$tglctk);
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$id_gudang=$_SESSION["ses_id_gudang"];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$minta_id=$_REQUEST['minta_id'];
convert_var($idunit,$id_gudang,$bulan,$ta,$minta_id);

if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];

$unit_tujuan=$_REQUEST['unit_tujuan']; 
$kategori=$_REQUEST['kategori']; 
$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($unit_tujuan,$kategori,$tgl_d,$tgl_s);

if ($unit_tujuan=="" || $unit_tujuan=="0") $unit_tujuan=$idunit;
if ($unit_tujuan=="0" || $unit_tujuan==$id_gudang) $unit_tj=""; else $unit_tj="UNIT_ID=$unit_tujuan AND ";
if ($kategori=="" || $kategori=="0") $kat="ao.OBAT_GOLONGAN IN ('N','Psi')"; else $kat="ao.OBAT_GOLONGAN IN ('$kategori')";

if ($tgl_d=="") $tgl_d=$tgl;
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
if ($tgl_s=="") $tgl_s=$tgl;
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";

convert_var($unit_tj,$kat,$tgl_de,$tgl_se);
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($page,$sorting,$filter);
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
	  <p><span class="jdltable">LAPORAN PEMAKAIANN NAPZA</span></p>
      <table width="48%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr>
          <td>Unit</td>
          <td>:<span class="jdltable">
            <select name="unit_tujuan" id="unit_tujuan" onchange="location='?f=../report/rpt_napza.php&amp;tgl_d='+tgl_d.value+'&amp;tgl_s='+tgl_s.value+'&amp;unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
              <?
	  			$qry = "select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
				//$id=$show['UNIT_ID']
	  			?>
              <option value="<?php echo $show['UNIT_ID'];?>" class="txtinput" <?php if ($unit_tujuan==$show['UNIT_ID']) echo " selected"; ?>>
              <?=$show['UNIT_NAME'];?>
              </option>
              <? }?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td>Kategori</td>
          <td>:<span class="jdltable">
          <?php $ckat="ALL";?>
            <select name="kategori" id="kategori" onchange="location='?f=../report/rpt_napza.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
              <option value="0">All</option>
              <option value="N"<?php if ($kategori=="N") {echo "selected";$ckat="Narkotika";}?>>Narkotika</option>
              <option value="Psi"<?php if ($kategori=="Psi") {echo "selected";$ckat="Psikotropika";}?>>Psikotropika</option>
            </select>
          </span></td>
        </tr>
        <tr>
        <td width="100">Tgl Periode</td>
        <td>: 
      <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
      &nbsp;&nbsp;s/d&nbsp;&nbsp;
      <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/rpt_napza.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>         </td>
		</tr>
	  </table>
      <br />
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="225" class="tblheader" onclick="ifPop.CallFr(this);">Nama Pasien</td>
          <td align="center" id="NAMA" width="225" class="tblheader" onclick="ifPop.CallFr(this);">Alamat</td>
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
		$sql="SELECT ao.OBAT_NAMA,DATE_FORMAT(t1.TGL,'%d/%m/%Y') AS tgl1,t1.*,ak.NAMA,SUM(t1.QTY) AS QTY1,SUM(t1.QTY*t1.HARGA_SATUAN) AS NILAI FROM 
(SELECT PENERIMAAN_ID,TGL,NO_PENJUALAN,NO_PASIEN,NO_RESEP,SHIFT,QTY_RETUR,QTY,QTY_JUAL,HARGA_NETTO,HARGA_SATUAN,DOKTER,
RUANGAN,NAMA_PASIEN,ALAMAT FROM a_penjualan a WHERE ".$unit_tj."TGL BETWEEN '$tgl_de' AND '$tgl_se') AS t1 
INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID WHERE ".$kat." 
GROUP BY ao.OBAT_ID,ak.ID,t1.NAMA_PASIEN,t1.ALAMAT ORDER BY ".$sorting;
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALAMAT']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY1']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['NILAI'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
		$sql2="select if(sum(t2.NILAI) is null,0,sum(t2.NILAI)) as SUB_TOTAL from (".$sql.") as t2";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$subtotal=0;
		if ($rows=mysqli_fetch_array($rs)) $subtotal=$rows['SUB_TOTAL'];
	  	mysqli_free_result($rs);	  
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="6" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
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
		    <BUTTON type="button" onclick="PrintArea('cetak','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Lap. NAPZA</BUTTON>
	 </td>
		</tr>
		</table>
</div>
<div id="cetak" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <table width="30%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="2" align="center" class="jdltable"><p>LAPORAN PEMAKAIAN NAPZA<br>
              UNIT : 
            <?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
			?>
              </p></td>
        </tr>
        <tr> 
          <td colspan="2" align="center">Kategori : <?php echo $ckat;?></td>
        </tr>
        <tr> 
          <td colspan="2" align="center">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> 
            ) </td>
        </tr>
      </table>
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="225" class="tblheader" onclick="ifPop.CallFr(this);">Nama Pasien</td>
          <td align="center" id="NAMA" width="225" class="tblheader" onclick="ifPop.CallFr(this);">Alamat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['ALAMAT']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY1']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['NILAI'],0,",","."); ?></td>
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	    <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="6" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($subtotal,0,",","."); ?></td>
        </tr>
      </table>
	</div>
</form>
</div>
</body>
</html>

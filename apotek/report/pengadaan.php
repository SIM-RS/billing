<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$username = $_SESSION["username"];
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//================================================
$cid=$_REQUEST['obat_id'];
$ckpid=$_REQUEST['kepemilikan_id'];
$cunit_id=$_REQUEST['unit_id'];
$tgl_d=$_REQUEST["tgl_d"];
$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_d=="") $tgl_d=gmdate('01-m-Y',mktime(date('H')+7));
$tgl_d1=explode("-",$tgl_d);$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
if ($tgl_s=="") $tgl_s=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_s1=explode("-",$tgl_s);$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
/*
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="TGL_TRANS DESC,ID DESC";
$sorting=$_REQUEST["sorting"];
//===============================
   //Ambil Nama Obat----
  $qryObat=mysqli_query($konek,"select OBAT_NAMA from a_obat where OBAT_ID=".$_GET['obat_id']);
  $rowsObat=mysqli_fetch_array($qryObat);
  //------------
  //Ambil nama Unit
  $qryUnit=mysqli_query($konek,"select UNIT_NAME from a_unit where UNIT_ID=".$_GET['unit_id']);
  $rowsUnit=mysqli_fetch_array($qryUnit);
  $qryKep=mysqli_query($konek,"select NAMA from a_kepemilikan where ID=".$_GET['kepemilikan_id']);
  $rowsKep=mysqli_fetch_array($qryKep);
*/
?>
<html>
<head>
<title>Kartu Stok</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=900,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<body>
<script>
var arrRange=depRange=[];
</script>
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
<div align="center">
  <form name="form1" method="post" action="">
    <input name="act" id="act" type="hidden" value="save">
  <input name="unit_id" id="unit_id" type="hidden" value="<?php echo $cunit_id; ?>">
  <input name="obatid" id="obatid" type="hidden" value="<?php echo $cid; ?>">
  <input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="<?php echo $ckpid; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">Pengadaan Barang Habis Pakai</span></p>
	  <table>
        <tr> 
          <td width="115">Tanggal</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <!--button type="button" onClick="location='?f=../master/kartu_stok.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_id='+unit_id.value+'&obat_id='+obat_id.value+'&kepemilikan_id='+kepemilikan_id.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button-->
          </td>
        </tr>
      </table>
      <!--table width="90%" border="0" cellpadding="1" cellspacing="0" align="center">
        <tr class="headtable"> 
          <td width="80" class="tblheaderkiri">Tgl Act </td>
          <td class="tblheader">Keterangan</td>
          <td width="80" class="tblheader">Debet</td>
          <td width="80" class="tblheader">Kredit</td>
          <td width="80" class="tblheader">Sisa</td>
        </tr>
        <?php 
/*		if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT * FROM a_kartustok where OBAT_ID=".$cid." AND KEPEMILIKAN_ID=".$ckpid." AND UNIT_ID=".$cunit_id." AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY ".$sorting;
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql2;
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $rs=mysqli_query($konek,$sql2);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo date("d/m/Y",strtotime($rows['TGL_ACT'])); ?></td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['KET']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['DEBET'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['KREDIT'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['STOK_AFTER'];?></td>
        </tr>
        <?php 
	  }
	  $sql2="select if (sum(t2.DEBET) is null,0,sum(t2.DEBET)) as totDebit,if (sum(t2.KREDIT) is null,0,sum(t2.KREDIT)) as totKredit from (".$sql.") as t2";
	  $rs=mysqli_query($konek,$sql2);
	  $totDebit=0;
	  $totKredit=0;
	  if ($rows=mysqli_fetch_array($rs)){
		  $totDebit=$rows["totDebit"];
		  $totKredit=$rows["totKredit"];
	  }
	  mysqli_free_result($rs);
*/	  ?>
        <tr class="itemtable"> 
          <td colspan="2" align="right" class="tdisikiri" style="font-size:12px;">Total&nbsp;</td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php //echo $totDebit;?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php //echo $totKredit;?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;</td>
        </tr>
      </table>
	  <table width="90%" align="center">
        <tr> 
        <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
		<td width="111" colspan="3" align="right">
		
		<button title="Halaman Pertama" onclick="act.value='paging';page.value='1';document.form1.submit();"><<</button>
		<button title="Halaman Sebelumnya" onclick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"><</button>
		<button title="Halaman Berikutnya" onclick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();">></button>
		<button title="Halaman Terakhir" onclick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">>></button>
		</td>
      </tr>
	</table-->
	<p>
        <!--BUTTON type="button" <?php  //if($i==0) echo "disabled='disabled'"; ?> onClick="PrintArea('printOut','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
        Kartu Barang</BUTTON-->
	  <BUTTON type="button" onClick="OpenWnd('../report/pengadaan_excell.php?unitid=<?php echo $idunit; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value,600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
	</p>
    </div>
	<?php /*?>
	 <!--div id="printOut" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
  <p align="center"><span class="jdltable">Kartu Stok Obat/Alkes: <?php echo $rowsObat['OBAT_NAMA'];?> - Unit: <?php echo $rowsUnit['UNIT_NAME'];?> - Kepemilikan : <?php echo $rowsKep['NAMA']; ?></span></p>
	  <table width="348" align="center">
	   	<tr>
			
          <td colspan="2" align="center" class="txtcenter">( <?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?> 
            ) </td>
		</tr>
	  </table>
      <table width="90%" border="0" cellpadding="1" cellspacing="0" align="center">
        <tr class="headtable">
          <td id="TGL_ACT" width="80" class="tblheaderkiri">Tgl Act </td>
          <td id="KET" class="tblheader">Keterangan</td>
          <td id="DEBET" width="80" class="tblheader">Debet</td>
		  <td id="KREDIT" width="80" class="tblheader">Kredit</td>
          <td id="STOK_AFTER" width="80" class="tblheader">Sisa</td>
      </tr>
	  <?php 
	  $rs=mysqli_query($konek,$sql);
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
		<td class="tdisikiri" align="center" style="font-size:12px;"><?php echo date("d/m/Y",strtotime($rows['TGL_ACT'])); ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['KET']; ?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['DEBET'];?></td>
        <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['KREDIT'];?></td>
		<td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $rows['STOK_AFTER'];?></td>
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr class="itemtable"> 
          <td colspan="2" align="right" class="tdisikiri" style="font-size:12px;">Total&nbsp;</td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $totDebit;?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo $totKredit;?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;</td>
        </tr>
    </table>
    </div-->
	<?php */?>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	//header("Location: ../../index.php");
	//exit();
}
//======================================= 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$minta_id=$_REQUEST['minta_id'];
$vendor=$_REQUEST['vendor'];if($vendor=="") $vendor=0; if($vendor=="" OR $vendor=="0") $jns_p=""; else $jns_p="and a_spph.PBF_ID=$vendor";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="tgl desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td width="1000" height="470" align="center">
		<script>
		var arrRange=depRange=[];
		</script>
		<iframe height="193" width="168" name="gToday:normal:agenda.js"
			id="gToday:normal:agenda.js"
			src="../theme/popcjs.php" scrolling="no"
			frameborder="0"
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
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<!-- PRINT OUT -->
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">DAFTAR SPPH PER PBF</span> 
	<table width="50%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
        <td width="148">Tanggal Periode </td>
        <td>: <?php echo $_GET['tgl_d'];?> s/d: <?php echo $_GET['tgl_s'];?></td>
		</tr>
		<tr>
			<td align="left">Vendor </td>
	        <td align="left">:                 
				<?
					//if($act=="save"){ 
					$qry="select PBF_ID,PBF_NAMA from a_pbf where PBF_ID=$vendor";
					//echo $qry;
					  $exe=mysqli_query($konek,$qry);
					  $show=mysqli_fetch_array($exe);
					  // echo $qrs;
					  echo $show['PBF_NAMA'];
					  if ($show['PBF_NAMA']=="" OR $show['PBF_NAMA']=="0") echo "ALL Vendor";
					//}else{
					//echo $vendor;
					//}
					?></td>
		</tr>		
	</table>
    <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="30" height="25" class="tblheaderkiri" onClick="">No</td>
        <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
        <td id="PBF_NAMA" width="250" class="tblheader" onClick="ifPop.CallFr(this);">Vendor</td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Item</td>
		<td id="NAMA" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		<td id="kemasan" width="96" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan</td>
		<td id="qty_kemasan" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Qty Kemasan</td>
        <!--td class="tblheader" width="30">Proses</td-->
      </tr>
      <?php 
 	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se; 

	$sql="Select a_spph.tgl,a_spph.qty_kemasan,a_spph.kemasan,a_pbf.PBF_NAMA,a_kepemilikan.NAMA,a_obat.OBAT_NAMA From a_spph Left Join a_pbf ON a_spph.pbf_id = a_pbf.PBF_ID Left Join a_obat ON a_spph.obat_id = a_obat.OBAT_ID Left Join a_kepemilikan ON a_spph.kepemilikan_id = a_kepemilikan.ID where a_spph.status=1 and a_spph.tgl between '$tgl_1' and '$tgl_2'" .$jns_p.$filter." order by " .$sorting;
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo date("d/m/Y",strtotime($rows['tgl'])); ?></td>
        <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA']; ?></td>
		<td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['kemasan']; ?></td>
		<td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['qty_kemasan']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
  </div>
	<!-- PRINT OUT BERAKHIR -->
	<div id="view" style="display:block">
	<p><span class="jdltable">DAFTAR SPPH PER PBF</span> 
	<table width="60%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
          <td width="127">Tanggal Periode</td>
          <td colspan="2">: 
        <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input>
        <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>&nbsp;&nbsp;</input>s/d&nbsp;&nbsp;
        <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" >
        </input> 
        <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />        </input></td>
			</tr>
			<tr>
			<td>PBF</td>
            <td>: 
			<select name="vendor" id="vendor" class="txtinput" onChange="location='?f=../mc/list_spph.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&vendor='+vendor.value">
                <option value="0" class="txtinput">All PBF</option>
                <?
					  $qry="select PBF_ID,PBF_NAMA from a_pbf group by PBF_NAMA order by PBF_NAMA";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                <option value="<?php echo $show['PBF_ID']; ?>" class="txtinput"<?php if ($vendor==$show['PBF_ID']) echo "selected";?>><?php echo $show['PBF_NAMA']; ?></option>
                <? }?>
              </select></td>
			  <td>
			  <button type="button" onClick="location='?f=../mc/list_spph.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&vendor='+vendor.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
	    </tr>		
	</table>
    <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="30" height="25" class="tblheaderkiri" onClick="">No</td>
        <td id="tgl" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
        <td id="PBF_NAMA" width="250" class="tblheader" onClick="ifPop.CallFr(this);">PBF</td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Item</td>
		<td id="NAMA" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		<td id="kemasan" width="96" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan</td>
		<td id="qty_kemasan" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Qty Kemasan</td>
        <!--td class="tblheader" width="30">Proses</td-->
      </tr>
      <?php 
/*  	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se; 
 */
	$sql="Select a_spph.tgl,a_spph.qty_kemasan,a_spph.kemasan,a_pbf.PBF_NAMA,a_kepemilikan.NAMA,a_obat.OBAT_NAMA From a_spph Left Join a_pbf ON a_spph.pbf_id = a_pbf.PBF_ID Left Join a_obat ON a_spph.obat_id = a_obat.OBAT_ID Left Join a_kepemilikan ON a_spph.kepemilikan_id = a_kepemilikan.ID where a_spph.status=1 and a_spph.tgl between '$tgl_1' and '$tgl_2'" .$jns_p.$filter." order by " .$sorting;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo date("d/m/Y",strtotime($rows['tgl'])); ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
        <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA']; ?></td>
		<td class="tdisi" align="center">&nbsp;<?php echo $rows['kemasan']; ?></td>
		<td class="tdisi" align="center">&nbsp;<?php echo $rows['qty_kemasan']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
  </div>
<table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
   <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <td align="center" colspan="2">
		<BUTTON type="button" onClick="PrintArea('idArea','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak Daftar SPPH </BUTTON>
	 </td>
	</tr>
</table>
</form>
</div>
	<td>
	</tr>
</table>
</body>
</html>
<?php 
mysqli_close($konek);
?>
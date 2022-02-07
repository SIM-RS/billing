<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=date('d-m-Y');
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan emperkenalkan untuk melakukan ACT===
/*$idunit1=$_REQUEST['idunit'];//echo "idunit=".$idunit."-".$id_gudang."<br>";
if (($idunit1=="") && ($idunit!=$id_gudang)) $idunit1=$idunit;
if ($idunit1=="" OR $idunit1=="0") $f_unit=""; else $f_unit="a.UNIT_ID=$idunit1 AND ";
$poli=$_REQUEST['poli'];
if ($poli=="" OR $poli=="0") $f_poli=""; else $f_poli="au.status_inap=$poli AND ";
$kel_pasien=$_REQUEST['kel_pasien'];
if ($kel_pasien=="" OR $kel_pasien=="0"){$kel_pasien="0";$f_kel_pasien="";} else $f_kel_pasien="am.KELOMPOK_ID=$kel_pasien AND ";
$kel_item=$_REQUEST['kel_item'];
if ($kel_item=="" OR $kel_item=="0"){$kel_item="0";$f_kel_item="";} else {$f_kel_item="a.KSO_ID=$kel_item AND ";$f_kel_pasien="";}
*/
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t.TANGGAL_ACT,t.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
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
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=600,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
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
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">LAPORAN PINDAH KEPEMILIKAN</span></p>
		
      <table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr> 
          <td width="40%" align="right"><span class="txtinput">Unit&nbsp;</span> 
          </td>
          <td align="left" class="txtinput">: <?php echo $namaunit; ?></td>
        </tr>
        <tr> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../transaksi/rpt_pindah_kepemilikan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>	  
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td width="80" class="tblheader" id="t.TANGGAL" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td width="120" class="tblheader" id="t.NOKIRIM" onClick="ifPop.CallFr(this);">No 
            Bukti </td>
          <td class="tblheader" id="t.OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td width="80" height="25" class="tblheader" id="t.SATUAN" onClick="ifPop.CallFr(this);">Satuan</td>
          <td width="40" class="tblheader" id="t.QTY_SATUAN" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="70" class="tblheader" id="t.HARGA" onClick="ifPop.CallFr(this);">Harga</td>
          <td width="80" class="tblheader" id="t.subtotal" onClick="ifPop.CallFr(this);">SubTotal</td>
          <td width="90" class="tblheader" id="ak.NAMA" onClick="ifPop.CallFr(this);">Kepemilikan 
            Asal </td>
          <td width="90" class="tblheader" id="t.NAMA" onClick="ifPop.CallFr(this);">Pindah 
            Kepemilikan </td>
        </tr>
        <?php 
/*	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }*/
	  if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			if ($k==0)
				$filter .=" WHERE ".$ifilter[0]." like '%".$ifilter[1]."%'";
			else
				$filter .=" AND ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
	  if ($sorting=="") $sorting=$defaultsort;
//	  $sql="SELECT DISTINCT ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID WHERE ak.UNIT_ID=$idunit1".$filter." ORDER BY ".$sorting;
	  	$sql="SELECT t.*,ak.NAMA AS KP_ASAL FROM (SELECT a.ID,a.ID_LAMA,a.TANGGAL_ACT,DATE_FORMAT(a.TANGGAL,'%d/%m/%Y') AS TANGGAL,a.NOKIRIM,
			o.OBAT_NAMA,o.OBAT_SATUAN_KECIL as SATUAN,k.NAMA,a.QTY_SATUAN,a.HARGA_BELI_SATUAN as HARGA,a.QTY_SATUAN*a.HARGA_BELI_SATUAN AS subtotal 
			FROM a_penerimaan a INNER JOIN a_obat o ON a.OBAT_ID=o.OBAT_ID INNER JOIN a_kepemilikan k ON a.KEPEMILIKAN_ID=k.ID 
			WHERE a.UNIT_ID_KIRIM=$idunit AND a.UNIT_ID_TERIMA=$idunit AND a.TANGGAL BETWEEN '$tgl_d1' AND '$tgl_s1' AND a.STATUS=1) AS t 
			INNER JOIN a_penerimaan ap ON t.ID_LAMA=ap.ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID".$filter." 
			ORDER BY ".$sorting;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['TANGGAL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['SATUAN']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['QTY_SATUAN'];?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['HARGA'],0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['subtotal'],0,",","."); ?></td>
          <td align="center" class="tdisi"><?php echo $rows['KP_ASAL']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['NAMA']; ?></td>
        </tr>
        <?php 
	  }
		$tot_QTY=0;
		$tot_Harga=0;
		$t_subtot=0;
	  $sql2="SELECT if (SUM(p.QTY_SATUAN) IS NULL,0,SUM(p.QTY_SATUAN)) AS tot_QTY,if (SUM(p.HARGA) IS NULL,0,SUM(p.HARGA)) AS tot_Harga,if (SUM(p.subtotal) IS NULL,0,SUM(p.subtotal)) AS t_subtot FROM (".$sql.") as p";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  if ($rows=mysqli_fetch_array($rs)){
	  		$tot_QTY=$rows["tot_QTY"];
			$tot_Harga=$rows["tot_Harga"];
			$t_subtot=$rows["t_subtot"];
	  }
	  	?>
        <tr class="txtinput"> 
          <td colspan="5" align="right" class="tdisikiri">Sub Total&nbsp;</td>
          <td align="right" class="tdisi"><?php echo $tot_QTY;?></td>
          <td align="right" class="tdisi"><?php echo number_format($tot_Harga,0,",","."); ?></td>
          <td align="right" class="tdisi"><?php echo number_format($t_subtot,0,",","."); ?></td>
          <td colspan="2" align="right" class="tdisi">&nbsp;</td>
        </tr>
        <tr> 
          <td align="left" colspan="5"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="10" align="center"> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick='PrintArea("idArea","#");'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Pindah Kepemilikan</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">LAPORAN PINDAH KEPEMILIKAN</span> 
      <table border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="40%" align="right"><span class="txtinput">Unit</span>&nbsp; </td>
          <td align="left"><span class="txtinput">: <?php echo $namaunit; ?></span></td>
        </tr>
        <tr> 
          <td colspan="2" align="center"><span class="txtcenter"><?php echo "( ".$tgl_d." s/d ".$tgl_s." )"; ?></span></td>
        </tr>
      </table>	  
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td width="80" class="tblheader" id="t.TANGGAL" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td width="120" class="tblheader" id="t.NOKIRIM" onClick="ifPop.CallFr(this);">No 
            Bukti </td>
          <td class="tblheader" id="t.OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td width="80" height="25" class="tblheader" id="t.SATUAN" onClick="ifPop.CallFr(this);">Satuan</td>
          <td width="40" class="tblheader" id="t.QTY_SATUAN" onClick="ifPop.CallFr(this);">Qty</td>
          <td width="70" class="tblheader" id="t.HARGA" onClick="ifPop.CallFr(this);">Harga</td>
          <td width="80" class="tblheader" id="t.subtotal" onClick="ifPop.CallFr(this);">SubTotal</td>
          <td width="90" class="tblheader" id="ak.NAMA" onClick="ifPop.CallFr(this);">Kepemilikan 
            Asal </td>
          <td width="90" class="tblheader" id="t.NAMA" onClick="ifPop.CallFr(this);">Pindah 
            Kepemilikan </td>
        </tr>
        <?php 
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['TANGGAL']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['SATUAN']; ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $rows['QTY_SATUAN'];?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($rows['HARGA'],0,",","."); ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($rows['subtotal'],0,",","."); ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['KP_ASAL']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        </tr>
        <?php 
	  }
	  	?>
        <tr class="txtinput"> 
          <td colspan="5" align="right" class="tdisikiri" style="font-size:12px;">Sub Total&nbsp;</td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo $tot_QTY;?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($tot_Harga,0,",","."); ?></td>
          <td align="right" class="tdisi" style="font-size:12px;"><?php echo number_format($t_subtot,0,",","."); ?></td>
          <td colspan="2" align="right" class="tdisi" style="font-size:12px;">&nbsp;</td>
        </tr>
      </table>
	  </div>
</form>
</div>
</body>
<script>
var req;

GetId = function(id){
   if (document.getElementById)
      return document.getElementById(id);
   else if (document.all)
      return document.all[id];
}

function UpdtList(obj,vMethod,vUrl){
	req = new newRequest(1);

  if (req.xmlhttp) {
    req.available = 0;
    req.xmlhttp.open(vMethod , vUrl, true);
	req.xmlhttp.onreadystatechange = function() {
	  if (typeof(req) != 'undefined' && 
		req.available == 0 && 
		req.xmlhttp.readyState == 4) {
		  if (req.xmlhttp.status == 200 || req.xmlhttp.status == 304) {
		  		//alert(req.xmlhttp.responseText);
				GetId(obj).innerHTML = req.xmlhttp.responseText;
		  } else {
				req.xmlhttp.abort();
		  }
		  req.available = 1;
	  }
	}
	
	if (window.XMLHttpRequest) {
	  req.xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  req.xmlhttp.send();
	}
  }
  return false;
}

function newRequest(available) {
	this.available = available;
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}	
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
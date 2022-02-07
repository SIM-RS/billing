<?php 
include("../sesi.php"); 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_SESSION["ses_idunit"];
$cunit=$_REQUEST['idunit'];
convert_var($tgl2,$idunit1,$cunit);
if ($cunit=="" || $cunit==0){
	$funit="p.UNIT_ID<>20 AND";
}else{
	$funit="p.UNIT_ID=$cunit AND";
}
/*$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
$rs=mysqli_query($konek,$sql);
$u=mysqli_fetch_array($rs);
$unit=$u['UNIT_NAME'];*/

$tgl_awal=$_REQUEST['tgl_awal'];
$tgl_akhir=$_REQUEST['tgl_akhir'];
convert_var($tgl_awal,$tgl_akhir);

if ($tgl_awal=="") $tgl_awal=$tgl;
$d=explode("-",$tgl_awal);
$tgl_awal1=$d[2]."-".$d[1]."-".$d[0];

if ($tgl_akhir=="") $tgl_akhir=$tgl;
$d=explode("-",$tgl_akhir);
$tgl_akhir1=$d[2]."-".$d[1]."-".$d[0];
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="a_penjualan.NO_PENJUALAN DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($tgl_awal1,$tgl_akhir1,$page,$sorting,$filter);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik RSUD Jombang</title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
function PrintArea(idArea,fileTarget){
var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars');
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
function PrintArea1(idArea,fileTarget){
//var g;
var winpopup=window.open(fileTarget,'winpopup','height=5,width=10,resizable,scrollbars');
/*	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	g=winpopup.document.getElementById("idprint").innerHTML;*/
	//setTimeout("alert(document.getElementById('mdata').value);document.getElementById('mdata').value='';alert(document.getElementById('mdata').value);",5000);
	//winpopup.print();
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
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
  	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="mdata" id="mdata" type="hidden" value="">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="view" style="display:block"> 
      <p><span class="jdltable">DATA PENJUALAN OBAT BERDASARKAN KELOMPOK HARGA
        </span> 
      <table width="50%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr>
          <td>Unit</td>
          <td>:
            <select id="idunit" name="idunit" onchange="location='?f=../apotik/penjualan_perKelHarga.php&idunit='+idunit.value+'&tgl_awal='+tgl_awal.value+'&tgl_akhir='+tgl_akhir.value">
              <!-- <option value="0" class="txtinput">Semua</option> -->
              <?php 
			$sqlUnit="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ID NOT IN(8,9)";
			$rsUnit=mysqli_query($konek,$sqlUnit);
			while ($rwUnit=mysqli_fetch_array($rsUnit)){
			?>
              <option value="<?php echo $rwUnit['UNIT_ID']; ?>" <?php if ($cunit==$rwUnit['UNIT_ID']) echo "selected"; ?> class="txtinput"><?php echo $rwUnit['UNIT_NAME']; ?></option>
              <?php 
			}
			?>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="100">Tgl Penjualan</td>
          <td>:            
          <input name="tgl_awal" type="text" id="tgl_awal" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_awal; ?>" />
          <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_awal,depRange);"/>&nbsp;&nbsp;s/d&nbsp;&nbsp;<input name="tgl_akhir" type="text" id="tgl_akhir" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_akhir; ?>" />
          <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onclick="gfPop.fPopCalendar(this.form.tgl_akhir,depRange);"/>&nbsp;&nbsp;&nbsp;<button type="button" onclick="location='?f=../apotik/penjualan_perKelHarga.php&idunit='+idunit.value+'&tgl_awal='+tgl_awal.value+'&tgl_akhir='+tgl_akhir.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
          Lihat</button></td>
        </tr>
      </table>
      <table width="50%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri">No</td>
          <td id="" class="tblheader">Kelompok Harga<br>( Rp. )</td>
          <td width="90" class="tblheader" id="NAMA_PASIEN" onclick="ifPop.CallFr(this);">Qty</td>
          <td id="SUM_SUB_TOTAL" width="120" class="tblheader" onclick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		$sql="SELECT * FROM a_kelompok_harga ORDER BY harga_bawah";
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
		if ($rows['harga_atas']>0){
			$sqlJual="SELECT IFNULL(SUM(p.QTY_JUAL-p.QTY_RETUR),0) AS jml,IFNULL(SUM((p.QTY_JUAL-p.QTY_RETUR)*p.HARGA_SATUAN),0) AS nilai FROM a_penjualan p WHERE $funit (p.TGL BETWEEN '$tgl_awal1' AND '$tgl_akhir1') AND (p.HARGA_SATUAN BETWEEN ".$rows['harga_bawah']." AND ".$rows['harga_atas'].")";
		}else{
			$sqlJual="SELECT IFNULL(SUM(p.QTY_JUAL-p.QTY_RETUR),0) AS jml,IFNULL(SUM((p.QTY_JUAL-p.QTY_RETUR)*p.HARGA_SATUAN),0) AS nilai FROM a_penjualan p WHERE $funit (p.TGL BETWEEN '$tgl_awal1' AND '$tgl_akhir1') AND (p.HARGA_SATUAN >= ".$rows['harga_bawah'].")";
		}
		$rsJual=mysqli_query($konek,$sqlJual);
		$rwJual=mysqli_fetch_array($rsJual);
		$qtyJual=$rwJual["jml"];
		$nJual=$rwJual["nilai"];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i ?></td>
          <td class="tdisi" align="center"><?php echo number_format($rows['harga_bawah'],0,",",".")." - ".(($rows['harga_atas']>0)?number_format($rows['harga_atas'],0,",","."):"~"); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($qtyJual,0,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($nJual,0,",","."); ?></td>
        </tr>
        <?php
	  }
	  ?>
      </table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">DAFTAR OBAT EXPIRED <? echo strtoupper($unit) ?></span>  
	  <table width="30%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        
        <tr> 
          <td width="177" class="txtcenter">Batas Tgl Expired : 
            <? echo $tgl_exp; ?></td>
        </tr>
      </table>
      <table width="100%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="TGL_ACT" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Tgl 
            Expired</td>
          <td id="NO_PASIEN" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Kode Obat</td>
          <td id="NAMA_PASIEN" class="tblheader" onclick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td width="90" class="tblheader" id="NAMA_PASIEN" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="SUM_SUB_TOTAL" width="60" class="tblheader" onclick="ifPop.CallFr(this);">Qty</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		//$jRetur=$rows['jRetur'];
		//$tCaraBayar=$rows['CARA_BAYAR'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center"><?php echo $i ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo number_format($rows['qty'],0,",","."); ?></td>
        </tr>
        <?php
	  }
	  ?>
      </table>
	</div>
    <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
     <tr>
	 <td align="center" colspan="2"><!--a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Obat Expired</BUTTON>
	 </a-->&nbsp;<!--BUTTON type="button" onClick="BukaWndExcell();" <?php //if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON--></td>
	  </tr>
	  </table>
  	</form>
  </div>
</body>
<script>
var req;

function PrintSvc(vMethod,vUrl){
	req = new newRequest(1);
  if (req.xmlhttp) {
	//alert('start');
    req.available = 0;
    //req.xmlhttp.open(vMethod , vUrl, false);
	req.xmlhttp.open('GET' , '../transaksi/updtelement1.php?kid=3', true);
	req.xmlhttp.onreadystatechange = function() {
	 // if (typeof(req) != 'undefined' && 
	//	req.available == 0 && 
	  if (req.xmlhttp.readyState == 4) {
		  if (req.xmlhttp.status == 200 || req.xmlhttp.status == 304) {
		  		alert(req.xmlhttp.responseText);
				//GetId(obj).innerHTML = req.xmlhttp.responseText;
				//cdata=req.xmlhttp.responseText;
				//if (cdata!="OK"){
				//	alert('reply salah');
					//PrintArea("idArea","#");
				//}
		  } else {
				req.xmlhttp.abort();
				alert('tdk ada servis');
				//PrintArea("idArea","#");*/
		  }
		  req.available = 1;
	  //}else{
	  //	alert('tdk ada servis');
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

function BukaWndExcell(){
var tgld=tgl_d.value;
var tgls=tgl_s.value;
var idunit1=idunit.value;
var jpasien=jns_pasien.value;
var spasien=statuspasien.value;
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../apotik/list_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien+'&statuspasien='+spasien+'&jp=<?php echo $jp; ?>&sp=<?php echo $sp; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>',600,450,'childwnd',true);
}

</script>
</html>
<?php 
mysqli_close($konek);
?>
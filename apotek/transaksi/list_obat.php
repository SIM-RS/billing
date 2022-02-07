<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$f=$_REQUEST['filter'];
$isi=$_REQUEST['isi'];
//echo "filter=".$f."&isi=".$isi;
?>
<html>
<head>
<title>Pilih Obat</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script>
var gfSelf=parent.document.getElementById(self.name);
parent.ifPop=parent.frames[self.name];

function ReloadFr(pc){
	if (gfSelf.style.visibility=="hidden"){
		CallFr(pc);
	}
	gfSelf.src='list_obat.php?filter='+pc.name+'&isi='+pc.value;
}

function fGetXY(aTag){
  var p=[0,0];
  while(aTag!=null){
  	p[0]+=aTag.offsetLeft;
  	p[1]+=aTag.offsetTop;
  	aTag=aTag.offsetParent;
  }
  return p;
}

function CallFr(pc){
	if (gfSelf.style.visibility=="visible"){
		fHideFr();
		return;
	}else{
		fShowFr(pc);
	}
}

function fShowFr(pc){
  var p=fGetXY(pc);
  with (gfSelf.style) {
  	left=p[0]-1;
	top =p[1]+pc.offsetHeight+1;
	visibility="visible";
  }
}

function fHideFr() {
  with (gfSelf.style) {
	visibility="hidden";
	top=parseInt(top)-10; // for nn6 bug
  }
}

function SetObat(p){
var p1=p.replace(String.fromCharCode(3),"'");
var tp=p1.split('||');
	//alert(p);
	//alert(tp[0]+"-"+tp[1]+"-"+tp[2]);
	parent.document.getElementById('obat_id').value=tp[0];
	parent.document.getElementById('obat_nama').value=tp[1];
	parent.document.getElementById('obat_kode').value=tp[2];
}
</script>
</head>
<body>
<table width="388" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="2" style="font:12px Arial, Helvetica, sans-serif">&nbsp;Pencarian :&nbsp; 
    <select id="kat" name="kat">
	<option value="obat_nama" selected>Nama Obat</option>
	<option value="obat_kode" <?php if ($f=="obat_kode") echo "selected"; ?>>Kode Obat</option>
	</select>&nbsp;&nbsp;<input id="txtCari" name="txtCari" type="text" size="15" value="<?php echo $isi; ?>">
	<input type="button" name="cari2" value="  Cari  " onClick="location='list_obat.php?filter='+document.getElementById('kat').value+'&isi='+document.getElementById('txtCari').value">
	<input style="margin-left:5px;" type="button" name="close" value="X" onClick="fHideFr()"></td>
  </tr>
<tr class="headtable">
	<td align="center" width="245" class="tblheaderkiri">Nama Obat </td>
	<td align="center" width="143" class="tblheader">Kode Obat </td>
  </tr>
<?php 
if ($f!=""){
	$sql="select * from a_obat where $f like '%$isi%' and OBAT_ISAKTIF=1 order by OBAT_ID";
	$iurl="?filter=$f&isi=$isi";
}else{
	$sql="select * from a_obat where OBAT_ISAKTIF=1 order by OBAT_ID";
	$iurl="?";
}
//echo $sql;
$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);
if (strlen($_GET['page'])>0 && $_GET['page']!='0') $page=$_REQUEST['page']; else $page="1";
$perpage=10;$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);

//	echo $jmldata." - ".$totpage;
$no=($page-1)*$perpage;
$rs=mysqli_query($konek,$sql);
$tval="";
while ($rows=mysqli_fetch_array($rs)){
	$no++;
	$tval=$rows['OBAT_ID']."||".$rows['OBAT_NAMA']."||".$rows['OBAT_KODE'];
	//echo $tval;
	$tval=str_replace('"','\"',$tval);
	$tval=str_replace("'",chr(3),$tval);
?>
<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick='SetObat("<?php echo $tval; ?>");fHideFr();'>
	<td align="center" class="tdisikiri"><?php echo $rows['OBAT_NAMA']; ?></td>
	<td align="center" class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
  </tr>
<?php 
}
mysqli_free_result($rs);
?>
<tr>
	<td height="51" align="left" class="bodyText">&nbsp;&nbsp;&nbsp;Halaman&nbsp;:&nbsp;<?php echo $page; ?> dari <?php echo $totpage; ?></td>
	<td colspan="1" align="right"><a href="<?php echo $iurl."&page=1"; ?>" class="tbl" title="Halaman Pertama"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama"></a>&nbsp;<a href="<?php echo $iurl."&page=$bpage"; ?>" class="tbl" title="Halaman Sebelumnya"><img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya"></a>&nbsp;<a href="<?php echo $iurl."&page=$npage"; ?>" class="tbl" title="Halaman Berikutnya"><img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya"></a>&nbsp;<a href="<?php echo $iurl."&page=$totpage"; ?>" class="tbl" title="Halaman Terakhir"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir"></a>&nbsp;</td>
</tr>
</table>
</body>
</html>
<?php mysqli_close($konek);?>
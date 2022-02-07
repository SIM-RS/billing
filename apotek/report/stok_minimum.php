<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_idunit"];
if ($idunit=="") $idunit=$idunit1;
convert_var($tgl2,$idunit,$idunit1);
/*$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$idminmax=$_REQUEST['idminmax'];
$smin=$_REQUEST['smin'];
$smax=$_REQUEST['smax'];
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
*/
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
convert_var($page,$sorting,$filter,$act);
//echo $act;
//Aksi Save, Edit, Delete Berakhir ============================================
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
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
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
<p><span class="jdltable">DAFTAR STOK OBAT YANG KURANG DARI STOK MINIMUM</span><table>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../report/stok_minimum.php&idunit='+idunit.value">
              <?
		  $qry="select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>4 and UNIT_TIPE<>7 and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){
		  	$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) {echo "selected"; $nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_STOK" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td width="65" class="tblheader">Min 
            Stok </td>
          <td width="65" class="tblheader">Max 
            Stok </td>
        </tr>
        <?php 
	 //$jfilter="";
	  if ($filter!=""){
	  	//$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  
	  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ak.NAMA,t3.* FROM (SELECT t1.*,IFNULL(t2.QTY_STOK,0) AS QTY_STOK FROM 
(SELECT * FROM a_min_max_stok WHERE unit_id=$idunit) AS t1 LEFT JOIN
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t2 ON (t1.obat_id=t2.OBAT_ID AND t1.kepemilikan_id=t2.KEPEMILIKAN_ID)) AS t3 
INNER JOIN a_obat ao ON t3.obat_id=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t3.kepemilikan_id=ak.ID
WHERE t3.QTY_STOK < t3.min_stok $filter ORDER BY ".$sorting;
	//echo $sql;
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
		$cid=$rows['obat_id'];
		$ckpid=$rows['kepemilikan_id'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><a href="../master/kartu_stok.php?obat_id=<?php echo $cid;?>&kepemilikan_id=<?php echo $ckpid;?>&unit_id=<?php echo $idunit; ?>" onClick="NewWindow(this.href,'name','900','500','yes');return false"><?php echo $rows['QTY_STOK'];?></a></td>
          <td class="tdisi"><?php echo $rows['min_stok'];?></td>
          <td class="tdisi"><?php echo $rows['max_stok'];?></td>
        </tr>
        <?php 
	  }
	  ?>
        
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="2" align="center"><!--div align="center" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
		  <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></div--></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
        </tr>
        <tr> 
          <td colspan="7" align="center"> <BUTTON type="button" onClick='PrintArea("idArea","#")' <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak 
            Stok Obat &lt; Stok Min</BUTTON>
             <!--BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../transaksi/stok_view_Excell.php?filter=<-?php echo $jfilter; ?>&sorting=<-?php echo $sorting; ?>&idunit=<-?php echo $idunit; ?>&nunit1=<-?php echo $nunit1; ?>&kelas=<-?php echo $kelas; ?>&golongan=<-?php echo $golongan; ?>&jenis=<-?php echo $jenis; ?>&k1=<-?php echo $k1; ?>&g1=<-?php echo $g1; ?>&j1=<-?php echo $j1; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON--></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<p align="center"><span class="jdltable">DAFTAR STOK OBAT YANG KURANG DARI STOK MINIMUM</span> 
		
      <table>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: <?php echo $nunit1; ?></td>
        </tr>
      </table>
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_STOK" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td width="65" class="tblheader">Min 
            Stok </td>
          <td width="65" class="tblheader">Max 
            Stok </td>
        </tr>
        <?php 
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" align="center" class="tdisikiri"><?php echo $i; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['QTY_STOK'];?></td>
          <td align="center" class="tdisi"><?php echo $rows['min_stok'];?></td>
          <td align="center" class="tdisi"><?php echo $rows['max_stok'];?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  </table>
	  </div>
</form>
</div>
</body>
<script>
function HProsen(a,b,c,d){
var e;
	//alert(b.value+'|'+c.value+'|'+d.value);
	if (a==1){
		e=b.value*c.value/100;
		d.value=(b.value)*1+e;
	}else if (a==2){
		e=((d.value)*1-(b.value)*1)*100/b.value;
		c.value=e;
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
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
$idunit1=$_REQUEST['idunit'];
$kpid=$_REQUEST['kpid'];


//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}

function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}
//Aksi Save, Edit Atau Delete =========================================
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
var arrRange=depRange=[];
</script>
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
      <p><span class="jdltable">LAPORAN PERMINTAAN OBAT TAK TERLAYANI DARI UNIT</span></p>
		
      <table>
        <tr> 
          <td align="center" class="txtinput">Unit Tujuan </td>
          <td align="center" class="txtinput">: <?php echo $namaunit; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Dari Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../apotik/permintaan_tak_terlayani.php&idunit='+idunit.value+'&kpid='+kepemilikan.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value">
            	<option value="" class="txtinput"<?php if ($idunit1=="") {echo "selected"; $nunit1="SEMUA";}?>>SEMUA</option>
              <?
		  $qry="SELECT * FROM a_unit WHERE (UNIT_TIPE=2 OR UNIT_TIPE=5) AND UNIT_ID<>".$idunit." AND UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']) {echo "selected";$nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Kepemilikan </td>
          <td align="center" class="txtinput">: 
            <select name="kepemilikan" id="kepemilikan" class="txtinput" onChange="location='?f=../apotik/permintaan_tak_terlayani.php&idunit='+idunit.value+'&kpid='+kepemilikan.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value">
              <option value="" class="txtinput"<?php if ($kpid=="") echo " selected";?>>SEMUA</option>
              <?
			  $k1="SEMUA";
		  $qry="SELECT * FROM a_kepemilikan ORDER BY ID";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kpid==$show['ID']){echo " selected";$k1=$show['ID'];}?>><?php echo $show['NAMA']; ?></option>
          <? }?>
          </select></td>
        </tr>
        <tr> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../apotik/permintaan_tak_terlayani.php&idunit='+idunit.value+'&kpid='+kepemilikan.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="no_bukti" class="tblheader" onClick="ifPop.CallFr(this);">No Permintaan</td>
          <td id="UNIT_NAME" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nama Unit</td>
          <td id="OBAT_KODE" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Kode Obat</td>
          <td id="OBAT_NAMA" width="170" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty Minta</td>
          <td id="qty_terima" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty Terima</td>
          <td id="qty_sisa" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty Sisa</td>
          <td id="status" width="100" class="tblheader" onClick="">Status</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		 
	  $fwaktu = " AND am.tgl BETWEEN '".tglSQL($tgl_d)."' AND '".tglSQL($tgl_s)."' ";
	  
	  if($idunit1=='')
	  {
		$funit = "";  
	  }
	  else{
	  	$funit = " AND am.unit_id = ".$idunit1;
	  }
	  
	  if($kpid==''){
	  	$fkpid = "";
	  }
	  else{
	  	$fkpid = " AND am.kepemilikan_id = ".$kpid;
	  }
		
	  $sql="SELECT * FROM (SELECT 
		  DATE_FORMAT(am.tgl,'%d/%m/%Y') AS tgl,
		  am.no_bukti,
		  au.UNIT_NAME,
		  ao.OBAT_ID,
		  ao.OBAT_KODE,
		  ao.OBAT_NAMA,
		  ao.OBAT_SATUAN_KECIL,
		  ak.ID,
		  ak.NAMA,
		  am.permintaan_id,
		  am.unit_id,
		  am.kepemilikan_id,
		  am.qty,
		  am.qty_terima,
		  am.qty - am.qty_terima AS qty_sisa,
		  am.status 
		FROM
		  a_minta_obat am 
		  INNER JOIN a_obat ao 
			ON am.OBAT_ID = ao.OBAT_ID 
		  INNER JOIN a_kepemilikan ak 
			ON am.KEPEMILIKAN_ID = ak.ID 
		  INNER JOIN a_unit au 
			ON au.UNIT_ID = am.unit_id 
		WHERE  (am.qty - am.qty_terima) > 0  AND am.unit_tujuan=".$idunit." $fwaktu $funit $fkpid AND au.UNIT_ID NOT IN(8,9)
		ORDER BY am.tgl,
		  am.permintaan_id) AS tbl $filter ORDER BY $sorting";
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
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['no_bukti']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE'];?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA'];?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA'];?></td>
          <td class="tdisi"><?php echo $rows['qty'];?></td>
          <td class="tdisi"><?php echo $rows['qty_terima'];?></td>
          <td class="tdisi"><?php echo $rows['qty_sisa'];?></td>
          <?php
		  if($rows['status']=='0'){
		  	$status = "Belum Dikirim";
		  }
		  else if($rows['status']=='1'){
		  	$status = "Dikirim";
		  }
		  else if($rows['status']=='2'){
		  	$status = "Diterima (-)";
		  }
		  ?>
          <td class="tdisi"><?php echo $status; ?></td>
        </tr>
        <?php 
	  }
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="8" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="11" align="center"> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick='PrintArea("idArea","#");'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Laporan</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">LAPORAN PERMINTAAN OBAT TAK TERLAYANI DARI UNIT</span></p> 
		
      <table width="431" align="center">
        <tr> 
          <td align="center" colspan="2">Unit : 
            <?
		if($idunit1==''){
		  echo "SEMUA";
		}
		else{
		  $qry="select * from a_unit where UNIT_ID=$idunit1";
		  $exe=mysqli_query($konek,$qry);
		  $show=mysqli_fetch_array($exe); 
		  echo $show['UNIT_NAME'];
		}
		  ?>
          </td>
        </tr>
        <tr> 
          <td align="center" colspan="2">Kepemilikan : 
          <?
		  if($_REQUEST['kpid']==''){
		  echo "SEMUA";
		  }
		  else{
		  $qry2="select * from a_kepemilikan where ID=".$_REQUEST['kpid'];
		  $exe2=mysqli_query($konek,$qry2);
		  $show2=mysqli_fetch_array($exe2); 
		  echo $show2['NAMA'];
		  }
		  ?>
          </td>
        </tr>
        <tr> 
          <td colspan="2" align="center">(<?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?>)</td>
        </tr>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">No Permintaan</td>
          <td id="NAMA" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nama Unit</td>
          <td id="QTY" width="50" class="tblheader" onClick="">Kode Obat</td>
          <td id="nilai" width="170" class="tblheader" onClick="">Nama Obat</td>
          <td id="nilai" width="80" class="tblheader" onClick="">Kepemilikan</td>
          <td id="nilai" width="50" class="tblheader" onClick="">Qty Minta</td>
          <td id="nilai" width="50" class="tblheader" onClick="">Qty Terima</td>
          <td id="nilai" width="50" class="tblheader" onClick="">Qty Sisa</td>
          <td id="nilai" width="100" class="tblheader" onClick="">Status</td>
        </tr>
        <?php 
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td style="font-size:12px" class="tdisikiri"><?php echo $i; ?></td>
          <td style="font-size:12px" class="tdisi" align="center"><?php echo $rows['tgl']; ?></td>
          <td style="font-size:12px" class="tdisi" align="center"><?php echo $rows['no_bukti']; ?></td>
          <td style="font-size:12px" class="tdisi" align="left"><?php echo $rows['UNIT_NAME']; ?></td>
          <td style="font-size:12px" class="tdisi" align="center"><?php echo $rows['OBAT_KODE'];?></td>
          <td style="font-size:12px" class="tdisi" align="left"><?php echo $rows['OBAT_NAMA'];?></td>
          <td style="font-size:12px" class="tdisi" align="center"><?php echo $rows['NAMA'];?></td>
          <td style="font-size:12px" class="tdisi"><?php echo $rows['qty'];?></td>
          <td style="font-size:12px" class="tdisi"><?php echo $rows['qty_terima'];?></td>
          <td style="font-size:12px" class="tdisi"><?php echo $rows['qty_sisa'];?></td>
          <?php
		  if($rows['status']=='0'){
		  	$status = "Belum Dikirim";
		  }
		  else if($rows['status']=='1'){
		  	$status = "Dikirim";
		  }
		  else if($rows['status']=='2'){
		  	$status = "Diterima (-)";
		  }
		  ?>
          <td class="tdisi"><?php echo $status; ?></td>
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
</html>
<?php 
mysqli_close($konek);
?>
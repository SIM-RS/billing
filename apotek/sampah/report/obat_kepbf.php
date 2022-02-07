<?php 
include("../../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$pbf=$_REQUEST['pbf'];
$retur_id=$_REQUEST['retur_id'];
$qty_satuan=$_REQUEST['qty_satuan'];
$status=$_REQUEST['status'];
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="RETUR_ID desc";
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
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=800,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
</head>
<body>
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

  <div id="listma" style="display:block">
  <link rel="stylesheet" href="../theme/print.css" type="text/css" />
  <p align="center"><span class="jdltable">RETUR KE  PBF</span>
  <p align="center">
  
  <table width="950" cellpadding="0" cellspacing="0" border="0">
		<tr>
          	<td width="377">Nama PBF
		  	<select name="pbf" id="pbf" onChange="location='obat_kepbf.php?pbf='+pbf.value+'&ta='+ta.value+'&amp;bulan='+bulan.value">
			<option value="0">Silahkan Pilih</option>
		  	<?
			$sql="select distinct a_penerimaan.PBF_ID,PBF_NAMA from a_penerimaan,a_pbf where QTY_STOK>0 and 	UNIT_ID_KIRIM=0 and a_pbf.PBF_ID=a_penerimaan.PBF_ID order by PBF_NAMA asc";
			$exe=mysqli_query($konek,$sql);
			$i=0;
			while($rows=mysqli_fetch_array($exe)){
		  	$i++;
			if (($pbf=="")&&($i==1)) $pbf=0;
			?>
			<option value="<?=$rows['PBF_ID'];?>" class="txtinput"<?php if ($pbf==$rows['PBF_ID']) echo "selected";?>><?=$rows['PBF_NAMA'];?></option>
			<? }?>
			</select>
	  	  </td>
          <td width="216">&nbsp;Status&nbsp;:&nbsp;
              <select name="bulan" id="bulan" class="txtinput" onChange="location='obat_kepbf.php?pbf='+pbf.value+'&ta='+ta.value+'&amp;bulan='+bulan.value">
                <option value="1|Januari"<?php if ($bulan[0]=="1") echo " selected";?>>Januari</option>
                <option value="2|Pebruari"<?php if ($bulan[0]=="2") echo " selected";?>>Pebruari</option>
                <option value="3|Maret"<?php if ($bulan[0]=="3") echo " selected";?>>Maret</option>
                <option value="4|April"<?php if ($bulan[0]=="4") echo " selected";?>>April</option>
                <option value="5|Mei"<?php if ($bulan[0]=="5") echo " selected";?>>Mei</option>
                <option value="6|Juni"<?php if ($bulan[0]=="6") echo " selected";?>>Juni</option>
                <option value="7|Juli"<?php if ($bulan[0]=="7") echo " selected";?>>Juli</option>
                <option value="8|Agustus"<?php if ($bulan[0]=="8") echo " selected";?>>Agustus</option>
                <option value="9|September"<?php if ($bulan[0]=="9") echo " selected";?>>September</option>
                <option value="10|Oktober"<?php if ($bulan[0]=="10") echo " selected";?>>Oktober</option>
                <option value="11|Nopember"<?php if ($bulan[0]=="11") echo " selected";?>>Nopember</option>
                <option value="12|Desember"<?php if ($bulan[0]=="12") echo " selected";?>>Desember</option>
              </select>
&nbsp;          </td>
          
<?
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($_GET['pbf']<>"") $pbf=$_GET['pbf']; else $pbf=0; 
	  $sql="SELECT a_penerimaan_retur.*, a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL, a_penerimaan.NOBUKTI
		FROM a_penerimaan_retur
			left Join a_penerimaan ON a_penerimaan_retur.PENERIMAAN_ID = a_penerimaan.ID
			left Join a_pbf ON a_penerimaan_retur.PBF_ID = a_pbf.PBF_ID
			left Join a_obat ON a_penerimaan_retur.OBAT_ID = a_obat.OBAT_ID
			left Join a_unit ON a_penerimaan_retur.UNIT_ID = a_unit.UNIT_ID
			left Join a_user ON a_penerimaan_retur.USER_ID = a_user.kode_user 
		WHERE month(a_penerimaan_retur.TGL)=$bulan[0] and year(a_penerimaan_retur.TGL)=$ta
		and a_penerimaan_retur.STATUS=1 and a_penerimaan_retur.PBF_ID=$pbf".$filter." ORDER BY ".$sorting;
	  	//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		
?>		<td width="357" align="left">Tahun
  <select name="ta" id="ta" class="txtinput" onChange="location='obat_kepbf.php?pbf='+pbf.value+'&ta='+ta.value+'&amp;bulan='+bulan.value">
    <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
    <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
    <?php }?>
  </select>
		</td>
	    </tr>
	</table>
    <table width="950" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="RETUR_ID" width="37" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
		<td id="NO_RETUR" width="55" class="tblheader" onClick="ifPop.CallFr(this);">No. Retur</td>
        <td id="NO_FAKTUR" width="55" class="tblheader" onClick="ifPop.CallFr(this);">No. Faktur </td>
        <td id="TGL" width="72" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
		<td id="PBF_NAMA" width="98" class="tblheader" onClick="ifPop.CallFr(this);">Supplier</td>
		<td id="OBAT_NAMA" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Obat</td>
		<td id="OBAT_SATUAN_KECIL" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
		<td id="QTY" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Quantity</td>
		<td id="KET" width="109" class="tblheader" onClick="ifPop.CallFr(this);">Keterangan</td>
      </tr>
	  <?php 
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  	$rs=mysqli_query($konek,$sql);
	  	$i=($page-1)*$perpage;
	  	$arfvalue="";
	  	while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*retur_id*-*".$rows['RETUR_ID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
		<td align="center" class="tdisi">&nbsp;<?php echo $rows['NO_RETUR']; ?></td>
		<td align="center" class="tdisi">&nbsp;<?php echo $rows['NOBUKTI']; ?></td>
		<td align="center" class="tdisi">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
		<td align="center" class="tdisi">&nbsp;<?php echo $rows['PBF_NAMA']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
		<td align="center" class="tdisi">&nbsp;<?php echo $rows['QTY']; ?></td>
		<td align="left" class="tdisi">&nbsp;<?php echo $rows['KET']; ?></td>

        <!--td width="32" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td-->
      </tr>
	  <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
</div>
<table align="center" width="937" border="0">
      <tr> 
        <td height="36" colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		<td width="521" colspan="4" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
      </tr>
</table>
</form>
<p align="center">
<a class="navText" href='#' onclick='PrintArea("listma","#")'>
<BUTTON type="button" <?php if($i==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Penerimaan&nbsp;&nbsp;</BUTTON></a>&nbsp;
<BUTTON type="button" onClick="javascript:window.close();"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tutup&nbsp;</BUTTON>
</p>
</body>
</html>
<?php 
mysqli_close($konek);
?>
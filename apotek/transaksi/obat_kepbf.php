<?php 
include("../sesi.php");
// Koneksi ===================================
include("../koneksi/konek.php");
//============================================
//===============TANGGALAN===================
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
//$ta=$_REQUEST['ta'];
$ta=mysqli_real_escape_string($konek,$_REQUEST['ta']);
if ($ta=="") $ta=$th[2];
//$bulan=$_REQUEST['bulan'];
$bulan=mysqli_real_escape_string($konek,$_REQUEST['bulan']);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//$pbf=$_REQUEST['pbf'];

$pbf=mysqli_real_escape_string($konek,$_REQUEST['pbf']);
//$retur_id=$_REQUEST['retur_id'];
$retur_id=mysqli_real_escape_string($konek,$_REQUEST['retur_id']);
//$qty_satuan=$_REQUEST['qty_satuan'];
$qty_satuan=mysqli_real_escape_string($konek,$_REQUEST['qty_satuan']);
//$status=$_REQUEST['status'];
$status=mysqli_real_escape_string($konek,$_REQUEST['status']);
//====================================================================

//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST['page']);
$defaultsort="RETUR_ID desc";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST['sorting']);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST['filter']);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST['act']);
//echo $act."<br>";

switch ($act){
	case "delete":
		$sql="select PENERIMAAN_ID, QTY from a_penerimaan_retur where retur_id=$retur_id";
		$exe=mysqli_query($konek,$sql);
		$show=mysqli_fetch_array($exe);
		
		$sql2="update a_penerimaan SET QTY_STOK=QTY_STOK+".$show['QTY']." WHERE ID=".$show['PENERIMAAN_ID'];
		//echo $sql2;
		$rs2=mysqli_query($konek,$sql2);

		$sql3="delete from a_penerimaan_retur where retur_id=$retur_id";
		$rs3=mysqli_query($konek,$sql3);
		break;
}
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
    <p align="center"><span class="jdltable">RETURN OBAT KE PBF</span> 
    <p align="center">
  
    <table width="99%" cellpadding="0" cellspacing="0" border="0">
      <tr>
          	<!--td width="406">Nama PBF
		  	<select name="pbf" id="pbf" onChange="location='?f=../transaksi/obat_kepbf.php&pbf='+pbf.value+'&ta='+ta.value+'&amp;bulan='+bulan.value">
			<option value="0">Silahkan Pilih</option>
		  	<?php /*
			$sql="select distinct a_penerimaan.PBF_ID,PBF_NAMA from a_penerimaan,a_pbf where QTY_STOK>0 and UNIT_ID_KIRIM=0 and a_pbf.PBF_ID=a_penerimaan.PBF_ID order by PBF_NAMA asc";
			$exe=mysqli_query($konek,$sql);
			$i=0;
			while($rows=mysqli_fetch_array($exe)){
		  	$i++;
			if (($pbf=="")&&($i==1)) $pbf=0;
			?>
			<option value="<?=$rows['PBF_ID'];?>" class="txtinput"<?php if ($pbf==$rows['PBF_ID']) echo "selected";?>><?=$rows['PBF_NAMA'];?></option>
			<? } */?>
			</select>
	  	  </td-->
          <td width="366"><span class="txtinput">Bulan&nbsp;:</span>
              <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/obat_kepbf.php&ta='+ta.value+'&amp;bulan='+bulan.value">
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
  &nbsp;<span class="txtinput">Tahun</span>
  <select name="ta" id="ta" class="txtinput" onChange="location='?f=../transaksi/obat_kepbf.php&ta='+ta.value+'&amp;bulan='+bulan.value">
    <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
    <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
    <?php }?>
  </select>
          </td>
          
<?
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //if ($_GET['pbf']<>"") $pbf=$_GET['pbf']; else $pbf=0; 
	  $sql="SELECT a_penerimaan_retur.*, a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, a_penerimaan.NOBUKTI
		FROM a_penerimaan_retur
			inner Join a_penerimaan ON a_penerimaan_retur.PENERIMAAN_ID = a_penerimaan.ID
			inner Join a_pbf ON a_penerimaan_retur.PBF_ID = a_pbf.PBF_ID
			inner Join a_obat ON a_penerimaan_retur.OBAT_ID = a_obat.OBAT_ID
			inner Join a_unit ON a_penerimaan_retur.UNIT_ID = a_unit.UNIT_ID
			inner Join a_kepemilikan k ON a_penerimaan_retur.KEPEMILIKAN_ID = k.ID 
		WHERE month(a_penerimaan_retur.TGL)=$bulan[0] and year(a_penerimaan_retur.TGL)=$ta".$filter." ORDER BY ".$sorting;
	  	//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		
?>		<td width="178" align="right">
		  <BUTTON type="button" <? //if($_GET['pbf']==0) {echo "disabled='disabled'";}?> onClick="location='?f=../transaksi/detil_retur.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>		  </td>
	    </tr>
	</table>
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri" id="RETUR_ID" onClick="ifPop.CallFr(this);">No</td>
        <td id="NO_RETUR" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Return</td>
        <td id="NO_FAKTUR" width="100" class="tblheader" onClick="ifPop.CallFr(this);">No. 
          Faktur </td>
        <td id="TGL" width="70" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
        <td id="PBF_NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Supplier</td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Obat</td>
        <td width="80" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="QTY" width="35" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
        <td id="KET" width="150" class="tblheader" onClick="ifPop.CallFr(this);">Keterangan</td>
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
        <td align="center" class="tdisi"><?php echo $rows['NO_RETUR']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['NOBUKTI']; ?></td>
        <td align="center" class="tdisi"><?php echo date("d/m/Y",strtotime($rows['TGL'])); ?></td>
        <td align="center" class="tdisi"><?php echo $rows['PBF_NAMA']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['QTY']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['KET']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr> 
        <td colspan="7" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
        </td>
      </tr>
    </table>
</div>
</form>
</body>
</html>
<?php 
mysqli_close($konek);
?>
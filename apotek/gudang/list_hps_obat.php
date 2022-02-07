<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
convert_var($tgl);
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
convert_var($bulan,$ta);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID_HAPUS desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
convert_var($page,$sorting,$filter,$act);
//echo $act;
/* 
switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
} */
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(PrintArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(PrintArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<!--	PRINT OUT DAFTAR PENGHAPUSAN OBAT	-->
	<div id="PrintArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center" class="jdltable"><b>DAFTAR PENGHAPUSAN OBAT </b></p> 
	  <table width="96%" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
		  <td colspan="6"><span class="txtinput" style="margin-right:15px;"><b>Bulan :</b>
		  <?php 
		  if ($bulan=="1") echo "Januari";
		  elseif ($bulan=="2") echo "Pebruari";
		  elseif ($bulan=="3") echo "Maret";
		  elseif ($bulan=="4") echo "April";
		  elseif ($bulan=="5") echo "Mei";
		  elseif ($bulan=="6") echo "Juni";
		  elseif ($bulan=="7") echo "Juli";
		  elseif ($bulan=="8") echo "Agustus";
		  elseif ($bulan=="9") echo "September";
		  elseif ($bulan=="10") echo "Oktober";
		  elseif ($bulan=="11") echo "Nopember";
		  elseif ($bulan=="12") echo "Desember";
		   ?></span><span class="txtinput"><b>Tahun : </b><?php echo $ta;?></span>
		  </td>
		</tr>
	  </table>
	  <table width="96%" border="0" cellpadding="1" cellspacing="0" align="center">
		<tr class="headtable"> 
		  <td width="31" height="25" class="tblheaderkiri">No</td>
		  <td id="TGL_HAPUS" width="84" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Hapus </td>
		  <td id="NO_HAPUS" width="160" class="tblheader" onClick="ifPop.CallFr(this);">No. 
			Hapus </td>
		  <td id="OBAT_NAMA" class="tblheader"  onClick="ifPop.CallFr(this);">Nama 
			Obat</td>
		  <td id="NAMA" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td id="QTY" width="47" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
		  <td width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
		  <td id="ALASAN" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
		</tr>
		<?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  
	  $ta1=$ta;
	  if ($ta<"2011"){
	  	$ta1="2000";
	  }elseif($bulan<"6"){
	  	$ta1="2000";
	  }
	  
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT a_obat_hapus.TGL_HAPUS,a_obat_hapus.NO_HAPUS,a_unit.UNIT_NAME,a_obat.OBAT_NAMA,a_kepemilikan.NAMA,SUM(a_obat_hapus.QTY) AS QTY,SUM(a_obat_hapus.QTY*p.HARGA_BELI_SATUAN * (1-(p.DISKON/100) * 1.1)) AS nilai,a_obat_hapus.ALASAN
			FROM a_obat INNER JOIN a_obat_hapus ON (a_obat.OBAT_ID = a_obat_hapus.OBAT_ID) INNER JOIN a_kepemilikan 
			ON (a_kepemilikan.ID = a_obat_hapus.KEPEMILIKAN_ID) INNER JOIN a_unit ON (a_unit.UNIT_ID = a_obat_hapus.UNIT_ID) INNER JOIN a_penerimaan p ON p.ID=a_obat_hapus.PENERIMAAN_ID
			WHERE (MONTH(a_obat_hapus.TGL_HAPUS)=$bulan AND YEAR(a_obat_hapus.TGL_HAPUS)=$ta1)
			GROUP BY a_obat_hapus.NO_HAPUS, a_unit.UNIT_NAME, a_obat.OBAT_NAMA, a_kepemilikan.NAMA";
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  $totnilai=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$totnilai+=$rows['nilai'];
	  ?>
		<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
		  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo date("d/m/Y",strtotime($rows['TGL_HAPUS'])); ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_HAPUS']; ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY']; ?></td>
		  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['nilai'],0,",","."); ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['ALASAN']; ?></td>
		</tr>
		<?php 
	  }
	  mysqli_free_result($rs);
	  ?>
		<tr>
		  <td colspan="6" align="right" style="font-size:12px;">Total&nbsp;</td>
		  <td align="right" style="font-size:12px;"><?php echo number_format($totnilai,0,",","."); ?></td>
		  <td align="left" style="font-size:12px;">&nbsp;</td>
	    </tr>
	  </table>
	  <p class="txtinput"  style="padding-right:10px; text-align:right">
	  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tgl_ctk." <b>- User:</b> ".$username; ?>&nbsp;&nbsp;&nbsp;&nbsp;
	  </p>
	  </div>
	<!-- PRINTOUT PENGHAPUSAN BERAKHIR -->
	
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center" class="jdltable"><b>DAFTAR USULAN PENGHAPUSAN OBAT </b></p> 
	  <table width="96%" cellpadding="0" cellspacing="0" border="0">
		<tr>
		  <td colspan="6"><span class="txtinput">Bulan : </span>
			  <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=list_hps_obat.php&bulan='+bulan.value+'&ta='+ta.value">
				<option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
				<option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
				<option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
				<option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
				<option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
				<option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
				<option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
				<option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
				<option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
				<option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
				<option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
				<option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
			  </select>
			  <span class="txtinput">Tahun : </span>
			  <select name="ta" id="ta" class="txtinput" onChange="location='?f=list_hps_obat.php&bulan='+bulan.value+'&ta='+ta.value">
				<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
				<option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
				<? }?>
			</select></td>
		  <td width="530" align="right" colspan="6"><BUTTON type="button" onClick="location='?f=hapus_obat.php'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah Penghapusan Obat </BUTTON></td>
		</tr>
	  </table>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable"> 
		  <td width="32" height="25" class="tblheaderkiri">No</td>
		  <td id="TGL_HAPUS" width="81" class="tblheader" onClick="ifPop.CallFr(this);">Tgl Hapus </td>
		  <td id="NO_HAPUS" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No. 
			Hapus </td>
		  <td id="OBAT_NAMA" class="tblheader"  onClick="ifPop.CallFr(this);">Nama 
			Obat</td>
		  <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td id="QTY" width="30" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
		  <td width="90" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
		  <td id="ALASAN" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
		  <!--td class="tblheader" width="30">Proses</td-->
		</tr>
		<?php 
	  //echo $sql."<br>";
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
		  <td class="tdisi" align="center"><?php echo date("d/m/Y",strtotime($rows['TGL_HAPUS'])); ?></td>
		  <td class="tdisi" align="center"><?php echo $rows['NO_HAPUS']; ?></td>
		  <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		  <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center"><?php echo $rows['QTY']; ?></td>
		  <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",","."); ?></td>
		  <td align="left" class="tdisi">&nbsp;<?php echo $rows['ALASAN']; ?></td>
		  <!--td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php //echo $arfvalue; ?>');"></td-->
		  <!--td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="<?php //if ($istatus<>0){?>alert('Data Tidak Boleh Dihapus');<?php //}else{?>if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php //echo $arfhapus; ?>');document.form1.submit();}<?php //}?>"></td-->
		</tr>
		<?php 
	  }
	  mysqli_free_result($rs);
	  ?>
		<tr>
		  <td colspan="6" align="right" style="font-size:12px;">Total&nbsp;</td>
		  <td align="right" style="font-size:12px;"><?php echo number_format($totnilai,0,",","."); ?></td>
		  <td align="left" style="font-size:12px;">&nbsp;</td>
	    </tr>
	  </table>
	</div>
	<table width="99%" border="0">
  <tr> 
		  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
			  <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
		  <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
			<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
			<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
			<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
		  </td>
		</tr>
	</table>
	<p align="center">
	  <BUTTON type="button" onClick="PrintArea('PrintArea','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Daftar Penghapusan </BUTTON>
      &nbsp;<BUTTON type="button" onClick="exportExcel()" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export Ke Excel&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
<script>
function exportExcel(){
	OpenWnd('hapus_obat_Excell.php?bulan='+bulan.value+'&tahun='+ta.value,600,450,'childwnd',true);
}
</script>
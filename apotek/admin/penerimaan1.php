<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$tipe=$_REQUEST['tipe'];if ($tipe=="") $tipe=1;
if ($tipe==2 || $tipe==4){
	$lnk="penerimaan_baru_non_pbf";
	$cjdl="DAFTAR PENERIMAAN GUDANG (Konsinyasi/Hibah/Return)";
	if ($tipe==4){
		$cjdl="KOREKSI PENERIMAAN GUDANG (Konsinyasi/Hibah/Return)";
	}
}else{
	$lnk="penerimaan_baru";
	$cjdl="DAFTAR PENERIMAAN GUDANG (Pembelian ke PBF)";
	if ($tipe==3){
		$cjdl="KOREKSI PENERIMAAN GUDANG (Pembelian ke PBF)";
	}
}
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.NOTERIMA desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<!-- Script Pop Up Window -->
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
<!-- Script Pop Up Window Berakhir -->
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
<div align="center">
  <form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="listma" style="display:block">
	  <p><span class="jdltable"><?php echo $cjdl; ?></span> 
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
        <tr>
		  <td colspan="5"><span class="txtinput">Bulan : </span> 
			<select name="bulan" id="bulan" class="txtinput" onChange="location='?f=penerimaan.php&tipe=<?php echo $tipe; ?>&bulan='+bulan.value+'&ta='+ta.value">
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
			<select name="ta" id="ta" class="txtinput" onChange="location='?f=penerimaan.php&tipe=<?php echo $tipe; ?>&bulan='+bulan.value+'&ta='+ta.value">
			<?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
			  <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
			<? }?>
			</select></td>
		  <td width="426" align="right" colspan="4">
		  <?php 
		  		if ($tipe==3 || $tipe==4){
					$lnkedit="penerimaan_edit_koreksi";
		  ?>
          <span class="txtinput">Jenis Penerimaan : </span><select name="cmbTipe" id="cmbTipe" class="txtinput" onChange="location='?f=penerimaan.php&tipe='+cmbTipe.value+'&bulan='+bulan.value+'&ta='+ta.value"><option value="3" class="txtinput"<?php if ($tipe==3) echo "selected";?>>Pembelian ke PBF</option><option value="4" class="txtinput"<?php if ($tipe==4) echo "selected";?>>Konsinyasi/Hibah/Return</option></select>
          <?php 
		  		}else{
					$lnkedit="penerimaan_edit";
		  ?>
		  <BUTTON type="button" onClick="location='?f=<?php echo $lnk; ?>'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle"> 
            Penerimaan Baru</BUTTON>&nbsp;<!--BUTTON type="button" onClick="location='?f=penerimaan_baru_non_pbf'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle"> 
            Penerimaan Baru (Non PBF)</BUTTON-->
            <?php }?>
		  </td>
		</tr>
	</table>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="tgl1" width="75" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td id="NOTERIMA" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Gudang</td>
          <td id="NO_PO" width="140" class="tblheader" onClick="ifPop.CallFr(this);">No. 
            PO </td>
          <td width="160" class="tblheader" id="NOBUKTI" onClick="ifPop.CallFr(this);">No 
            Faktur/No Bukti</td>
          <td class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);"><?php if ($tipe==1) echo "PBF"; else echo "Asal Perolehan";?></td>
          <td width="90" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td colspan="2" class="tblheader" id="status" onClick="ifPop.CallFr(this);">Proses</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if ($tipe==1 || $tipe==3){
	  	$sql="select distinct date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.NOTERIMA,ap.NOBUKTI,PBF_NAMA,a_po.NO_PO,k.NAMA from a_penerimaan ap inner join a_pbf on ap.PBF_ID=a_pbf.PBF_ID inner Join a_po ON ap.FK_MINTA_ID = a_po.ID inner join a_kepemilikan k on ap.KEPEMILIKAN_ID=k.ID where ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=0 and month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$ta".$filter." ORDER BY ".$sorting;
	  }else{
		$sql="SELECT DISTINCT DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1,ap.NOTERIMA,ap.NOBUKTI,IF(ap.PBF_ID=0,ap.KET,a_pbf.PBF_NAMA) AS PBF_NAMA,'-' AS NO_PO,k.NAMA 
FROM a_penerimaan ap left join a_pbf on ap.PBF_ID=a_pbf.PBF_ID INNER JOIN a_kepemilikan k ON ap.KEPEMILIKAN_ID=k.ID 
WHERE ap.UNIT_ID_TERIMA=$idunit AND ap.TIPE_TRANS=0 AND ap.JENIS<>0 AND MONTH(ap.TANGGAL)=$bulan AND YEAR(ap.TANGGAL)=$ta".
$filter." ORDER BY ".$sorting;;
	  }
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
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOTERIMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_PO']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOBUKTI']; ?></td>
          <td class="tdisi"><?php echo $rows['PBF_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td width="30" class="tdisi"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail Penerimaan" onClick="location='?f=penerimaan_detail&no_gdg=<?php echo $rows['NOTERIMA']; ?>&no_faktur=<?php echo $rows['NOBUKTI']; ?>&tipe=<?php echo $tipe; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
          <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah Data Penerimaan PBF" onClick="location='?f=<?php echo $lnkedit; ?>&no_gdg=<?php echo $rows['NOTERIMA']; ?>&no_faktur=<?php echo $rows['NOBUKTI']; ?>&tipe=<?php echo $tipe; ?>&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="4"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
          </td>
        </tr>
      </table>
	</div>
</form>
</div>

</body>
</html>
<?php 
mysqli_close($konek);
?>

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
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID_RETUR desc";
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
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="refresh" content="5000" >
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
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">DAFTAR RETURN DARI UNIT</span></p>
      <table width="66%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="6"><span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../gudang/retur_dr_unit.php&bulan='+bulan.value+'&ta='+ta.value">
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
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../gudang/retur_dr_unit.php&bulan='+bulan.value+'&ta='+ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
        </tr>
	</table>
      <table width="66%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="32" height="25" class="tblheaderkiri">No</td>
          <td id="tgl" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Tanggal</td>
          <td width="160" class="tblheader" id="NO_RETUR" onClick="ifPop.CallFr(this);">No 
            Return </td>
          <td id="UNIT_NAME" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Unit</td>
          <td width="110" class="tblheader" id="UNIT_NAME" onClick="ifPop.CallFr(this);">Status</td>
          <!--td width="115" class="tblheader" onClick="ifPop.CallFr(this);">Status</td-->
          <td class="tblheader">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="Select a_retur_togudang.*, a_unit.UNIT_NAME, a_obat.OBAT_NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID  where month(a_retur_togudang.TGL_RETUR)=$bulan and year(a_retur_togudang.TGL_RETUR)=$ta".$filter." group by NO_RETUR order by ".$sorting;
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
	  //$arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		if($rows['STATUS']==0) $cstatus="Belum Diterima"; else $cstatus="Diterima";
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_RETUR']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstatus; ?></td>
		  <?php if ($rows['STATUS']==1){?>
          <td width="26" class="tdisi"><img src="../icon/lihat.gif" border="0" width="18" height="18" align="absmiddle" class="proses" title="Klik Untuk Melihat Return Obat Dari Unit" onClick="location='?f=../gudang/retur_drunit_detail&no_retur=<?php echo $rows['NO_RETUR']; ?>&tgl_retur=<?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>'"></td>
          <?php }else{?>
		  <td width="29" class="tdisi"><img src="../icon/published.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menerima Return Obat Dari Unit" onClick="location='?f=../gudang/proses_retur_unit&no_retur=<?php echo $rows['NO_RETUR']; ?>&tgl_retur=<?php echo date("d/m/Y",strtotime($rows['TGL_RETUR'])); ?>&iunit=<?php echo $rows['UNIT_NAME']; ?>&idunit_krm=<?php echo $rows['UNIT_ID']; ?>'"></td>
          <?php }?>
		</tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
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

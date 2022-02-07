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
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="") $jns_pasien="0";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
$status=$_REQUEST['status']; if($status=="") $status="1";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="TGL_ACT desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
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
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<p><span class="jdltable"> DAFTAR RETUR PENJUALAN </span> 
	<table width="57%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
          <td width="99">Tanggal Periode</td>
          <td width="148">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input>
        <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>&nbsp;&nbsp;&nbsp;</input>
		</td>
			<td width="37" align="center">s/d</td>
		    <td colspan="3">: 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onchange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" ></input> 
        <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" /></input>		</td>
	  </tr>
			<tr>
			<td width="99">Jenis Pasien </td>
            <td colspan="2">:
              <select name="jns_pasien" id="jns_pasien" class="txtinput" onchange="location='?f=../apotik/list_retur_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&status='+status.value">
                <option value="0" class="txtinput">Pilih Jenis Pasien</option>
                <?
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 order by ID";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($jns_pasien==$show['ID']) echo "selected";?>><?php echo $show['NAMA']; ?></option>
                <? }?>
              </select></td>
			  <td width="90">Status</td>
			  <td colspan="2">:
			  <select name="status" id="status" onChange="location='?f=../apotik/list_retur_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&status='+status.value">
              <option value="1">Aktif</option>
              <option value="0"<?php if ($status=="0") echo " selected";?>>Tdk Aktif&nbsp;</option>
          	</select></td>
			<td width="87" align="center">
			  <button type="button" onclick="location='?f=../apotik/list_retur_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&status='+status.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
	    </tr>		
	</table>
	<div id="idArea" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
    <table width="80%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td id="" width="55" height="25" class="tblheaderkiri" onclick="">No</td>
        <td id="TGL_ACT" width="91" class="tblheader" onclick="ifPop.CallFr(this);">Tgl Act</td>
        <td id="NO_RETUR" width="94" class="tblheader" onclick="ifPop.CallFr(this);">No Retur</td>
        <td id="OBAT_NAMA" width="144" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
        <td id="QTY" width="110" class="tblheader" onclick="ifPop.CallFr(this);">QTY </td>
        <td width="139" class="tblheader" id="username" onclick="ifPop.CallFr(this);">Nama User</td>
        <td id="UNIT_NAME" width="109" class="tblheader" onclick="ifPop.CallFr(this);">Nama Unit</td>
        <!--td class="tblheader" width="30">Proses</td-->
      </tr>
      <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
		$sql="Select a_penjualan_retur.NO_RETUR,a_penjualan_retur.TGL,a_penjualan_retur.TGL_ACT,a_penjualan_retur.QTY,a_penjualan_retur.`STATUS`,a_obat.OBAT_NAMA,
a_user.username,a_unit.UNIT_NAME From a_penjualan_retur Left Join a_obat ON a_penjualan_retur.OBAT_ID = a_obat.OBAT_ID Left Join a_user ON a_penjualan_retur.USER_ID = a_user.kode_user Left Join a_penjualan ON a_penjualan_retur.PENJUALAN_ID = a_penjualan.ID Left Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID Left Join a_kepemilikan ON a_penerimaan.KEPEMILIKAN_ID = a_kepemilikan.ID Left Join a_unit ON a_penjualan_retur.UNIT_ID = a_unit.UNIT_ID where a_penjualan_retur.STATUS=$status and a_kepemilikan.ID=$jns_pasien and a_penjualan.UNIT_ID=$idunit and a_penjualan.TGL between '$tgl_1' and '$tgl_2'".$filter." order by " .$sorting;
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
	  $isi=mysqli_num_rows($rs);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		
	  ?>
      <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo date("d/m/Y",strtotime($rows['TGL_ACT'])); ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['NO_RETUR']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['username']; ?></td>
        <td class="tdisi" align="center">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  
      <tr>
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="3" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
    </table>
	<table width="80%" align="center" border="0" cellpadding="1" cellspacing="0">
	<tr>
	 <td align="center" colspan="3"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($isi==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON></a></td>
		</tr>
		</table>
</form>
</div>
</body>
</html>

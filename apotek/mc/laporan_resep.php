<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	//header("Location: ../../index.php");
	//exit();
}
//======================================= 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$minta_id=$_REQUEST['minta_id'];
$vendor=$_REQUEST['vendor'];if($vendor=="") $vendor=0; if($vendor=="" OR $vendor=="0") $jns_p=""; else $jns_p="and a.PBF_ID=$vendor";

$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tgl_d,$tgl_s);

$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="NO_PO desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td width="1000" height="470" align="center">
		<script>
		var arrRange=depRange=[];
		</script>
		<iframe height="193" width="168" name="gToday:normal:agenda.js"
			id="gToday:normal:agenda.js"
			src="../theme/popcjs.php" scrolling="no"
			frameborder="0"
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
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<!-- PRINT OUT -->
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">REKAP RESEP DAN OBAT</span> 
	<table width="50%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
        <td colspan="2" align="center">Tanggal Periode : <?php echo $_GET['tgl_d'];?> s/d: <?php echo $_GET['tgl_s'];?></td>
        </tr>
		<tr style="display:none">
			<td width="148" align="left">PBF </td>
	        <td align="left">:                 
				<?
					//if($act=="save"){ 
					$qry="select PBF_ID,PBF_NAMA from a_pbf where PBF_ID=$vendor";
					//echo $qry;
					  $exe=mysqli_query($konek,$qry);
					  $show=mysqli_fetch_array($exe);
					  // echo $qrs;
					  echo $show['PBF_NAMA'];
					  if ($show['PBF_NAMA']=="" OR $show['PBF_NAMA']=="0") echo "ALL Vendor";
					//}else{
					//echo $vendor;
					//}
					?></td>
		</tr>		
	</table>
    <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
           <tr class="headtable">
        <td width="227" rowspan="2" class="tblheader" id="tgl" onClick="ifPop.CallFr(this);">KSO</td>
        <td height="25" colspan="2" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Rumah Sakit </td>
        <td colspan="2" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Krakatau</td>
        <td colspan="2" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">BICT</td>
		<!--td class="tblheader" width="30">Proses</td-->
      </tr>
      <tr class="headtable">
        <td width="118" height="25" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Jumlah Resep </td>
        <td width="127" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Jumlah Obat </td>
        <td width="135" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Jumlah Resep</td>
        <td width="135" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Jumlah Obat</td>
        <td width="132" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Jumlah Resep</td>
        <td width="101" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Jumlah Obat</td>
        </tr>
      <?php 
 	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se; 
		
	$sql="SELECT t.KSO,
			SUM(t.TOT_RESEP_RS) TOT_RESEP_RS,
			SUM(t.TOT_OBAT_RS) TOT_OBAT_RS,
			SUM(t.TOT_RESEP_KRAKATAU) TOT_RESEP_KRAKATAU, 
			SUM(t.TOT_OBAT_KRAKATAU) TOT_OBAT_KRAKATAU,
			SUM(t.TOT_RESEP_BICT) TOT_RESEP_BICT, 
			SUM(t.TOT_OBAT_BICT) TOT_OBAT_BICT
			
			 FROM (SELECT a.nama KSO,
			COUNT(b.NO_PENJUALAN)TOT_RESEP_RS,
			SUM(b.TOT_OBAT) TOT_OBAT_RS,
			'' TOT_RESEP_KRAKATAU, 
			'' TOT_OBAT_KRAKATAU,
			'' TOT_RESEP_BICT, 
			'' TOT_OBAT_BICT
			
			FROM a_mitra a
			LEFT JOIN 
			(SELECT t1.NO_PENJUALAN, COUNT(t1.TOT_OBAT) TOT_OBAT,t1.KSO_ID
				FROM (SELECT 
					 a.NO_PENJUALAN,
					 a.KSO_ID,
					 b.OBAT_ID TOT_OBAT
				  FROM
					a_penjualan a 
					INNER JOIN a_penerimaan b 
					  ON a.`PENERIMAAN_ID` = b.`ID` 
				  WHERE a.`TGL` BETWEEN '$tgl_1' 
					AND '$tgl_2' 
					AND a.UNIT_ID = 7 
				   GROUP BY b.OBAT_ID,NO_PENJUALAN) t1
				   GROUP BY t1.NO_PENJUALAN
			) b 
			ON a.`IDMITRA` = b.`KSO_ID` 
			WHERE a.`AKTIF`=1
			GROUP BY a.`IDMITRA`
			
			UNION 
			
			SELECT a.nama KSO,
			'' TOT_RESEP_RS,
			'' TOT_OBAT_RS ,
			COUNT(c.NO_PENJUALAN)TOT_RESEP_KRAKATAU,
			SUM(c.TOT_OBAT) TOT_OBAT_KRAKATAU,
			'' TOT_RESEP_BICT, 
			'' TOT_OBAT_BICT
			FROM a_mitra a
			LEFT JOIN 
			(SELECT t1.NO_PENJUALAN, COUNT(t1.TOT_OBAT) TOT_OBAT,t1.KSO_ID
				FROM (SELECT 
					 a.NO_PENJUALAN,
					 a.KSO_ID,
					 b.OBAT_ID TOT_OBAT
				  FROM
					a_penjualan a 
					INNER JOIN a_penerimaan b 
					  ON a.`PENERIMAAN_ID` = b.`ID` 
				  WHERE a.`TGL` BETWEEN '$tgl_1' 
					AND '$tgl_2' 
					AND a.UNIT_ID = 8 
				   GROUP BY b.OBAT_ID,NO_PENJUALAN) t1
				   GROUP BY t1.NO_PENJUALAN
			) c 
			ON a.`IDMITRA` = c.`KSO_ID` 
			WHERE a.`AKTIF`=1
			GROUP BY a.`IDMITRA`
			
			UNION 
			
			SELECT a.nama KSO,
			'' TOT_RESEP_RS,
			'' TOT_OBAT_RS ,
			'' TOT_RESEP_KRAKATAU, 
			'' TOT_OBAT_KRAKATAU,
			COUNT(d.NO_PENJUALAN)TOT_RESEP_BICT,
			SUM(d.TOT_OBAT) TOT_OBAT_BICT
			
			FROM a_mitra a
			LEFT JOIN 
			(
			SELECT t1.NO_PENJUALAN, COUNT(t1.TOT_OBAT) TOT_OBAT,t1.KSO_ID
				FROM (SELECT 
					 a.NO_PENJUALAN,
					 a.KSO_ID,
					 b.OBAT_ID TOT_OBAT
				  FROM
					a_penjualan a 
					INNER JOIN a_penerimaan b 
					  ON a.`PENERIMAAN_ID` = b.`ID` 
				  WHERE a.`TGL` BETWEEN '$tgl_1' 
					AND '$tgl_2' 
					AND a.UNIT_ID = 9 
				   GROUP BY b.OBAT_ID,NO_PENJUALAN) t1
				   GROUP BY t1.NO_PENJUALAN
			) d 
			ON a.`IDMITRA` = d.`KSO_ID` 
			WHERE a.`AKTIF`=1
			GROUP BY a.`IDMITRA` ) t
			
			GROUP BY t.KSO";
	
	//echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;

	
	  while ($rows=mysqli_fetch_array($rs)){
		
	  ?>
   
     
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" align="left">&nbsp;<?php echo $rows['KSO']; ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_RS'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_RS'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_KRAKATAU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_KRAKATAU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_BICT'],0,",","."); ?></td>
		<td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_BICT'],0,",","."); ?></td>
        </tr>
      <?php 
	  $tot_resep_rs +=$rows['TOT_RESEP_RS'];
	  $tot_resep_krakatau +=$rows['TOT_RESEP_KRAKATAU'];
	  $tot_resep_bict +=$rows['TOT_RESEP_BICT'];
	  
	  $tot_obat_rs +=$rows['TOT_OBAT_RS'];
	  $tot_obat_krakatau +=$rows['TOT_OBAT_KRAKATAU'];
	  $tot_obat_bict +=$rows['TOT_OBAT_BICT'];
	  
	  
	  }
	  ?>
	  
	   <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" style="font-weight:bold">
        <td class="tdisikiri" align="right"> Jumlah / Farmasi :  &nbsp;</td>
        <td align="center" class="tdisi"><?php echo number_format($tot_resep_rs,0,",",".") ; ?></td>
        <td align="center" class="tdisi"><?php echo number_format($tot_obat_rs,0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($tot_resep_krakatau,0,",",".") ?></td>
        <td align="center" class="tdisi"><?php echo number_format($tot_obat_krakatau,0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($tot_resep_bict,0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($tot_resep_bict,0,",",".") ?></td>
        </tr>
    </table>
  </div>
	<!-- PRINT OUT BERAKHIR -->
	<div id="view" style="display:block">
	<p><span class="jdltable">REKAP RESEP DAN OBAT</span>
	<table width="60%" height="63" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
	  <tr> 
          <td width="127">Tanggal Penjualan</td>
          <td colspan="2">: 
        <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" /></input>
        <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>&nbsp;&nbsp;</input>s/d&nbsp;&nbsp;
        <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" onChange="location='?f=../apotik/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" >
        </input> 
        <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />        </input> &nbsp;
		  <button type="button" onClick="location='?f=../mc/laporan_resep.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&vendor='+vendor.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>
		</td>
			</tr>
			<tr style="display:none">
			<td>PBF</td>
            <td>: 
			<select name="vendor" id="vendor" class="txtinput" onChange="location='?f=../mc/laporan_resep.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&vendor='+vendor.value">
                <option value="0" class="txtinput">All PBF</option>
                <?
					  $qry="select PBF_ID,PBF_NAMA from a_pbf group by PBF_NAMA order by PBF_NAMA";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                <option value="<?php echo $show['PBF_ID']; ?>" class="txtinput"<?php if ($vendor==$show['PBF_ID']) echo "selected";?>><?php echo $show['PBF_NAMA']; ?></option>
                <? }?>
              </select></td>
			  <td>
			</td>
	    </tr>		
	</table>
    <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable">
        <td width="230" rowspan="2" class="tblheader" id="tgl" onClick="ifPop.CallFr(this);">KSO</td>
        <td height="25" colspan="2" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Rumah Sakit </td>
        <td colspan="2" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Krakatau</td>
        <td colspan="2" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">BICT</td>
		<!--td class="tblheader" width="30">Proses</td-->
      </tr>
      <tr class="headtable">
        <td width="121" height="25" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Jumlah Resep </td>
        <td width="114" class="tblheader" id="NO_PO" onClick="ifPop.CallFr(this);">Jumlah Obat </td>
        <td width="138" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Jumlah Resep</td>
        <td width="134" class="tblheader" id="PBF_NAMA" onClick="ifPop.CallFr(this);">Jumlah Obat</td>
        <td width="114" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Jumlah Resep</td>
        <td width="124" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Jumlah Obat</td>
        </tr>
     <?php
	$rs=mysqli_query($konek,$sql);
	 while ($rows=mysqli_fetch_array($rs)){
		$i++;
	  ?>
      
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" align="left">&nbsp;<?php echo $rows['KSO']; ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_RS'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_RS'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_KRAKATAU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_KRAKATAU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php echo number_format($rows['TOT_RESEP_BICT'],0,",","."); ?></td>
		<td align="center" class="tdisi"><?php echo number_format($rows['TOT_OBAT_BICT'],0,",","."); ?></td>
        </tr>
      <?php 
	
	  
	  
	  }
	  ?>
	  
	    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" style="font-weight:bold">
          <td class="tdisikiri" align="right">Total / Farmasi : &nbsp;</td>
          <td align="center" class="tdisi"><?php echo number_format($tot_resep_rs,0,",",".") ; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($tot_obat_rs,0,",","."); ?></td>
          <td align="center" class="tdisi"><?php echo number_format($tot_resep_krakatau,0,",",".") ?></td>
          <td align="center" class="tdisi"><?php echo number_format($tot_obat_krakatau,0,",","."); ?></td>
          <td align="center" class="tdisi"><?php echo number_format($tot_resep_bict,0,",","."); ?></td>
          <td align="center" class="tdisi"><?php echo number_format($tot_resep_bict,0,",",".") ?></td>
          </tr>
    </table>
  </div>
<table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
   <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <td align="center" colspan="2">
		<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak Laporan </BUTTON>
	 </td>
	</tr>
</table>
</form>
</div>
	<td>
	</tr>
</table>
</body>
</html>
<?php 
mysqli_close($konek);
?>
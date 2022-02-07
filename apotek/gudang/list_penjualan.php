<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
convert_var($tgl2,$idunit);

$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
$rs=mysqli_query($konek,$sql);
$u=mysqli_fetch_array($rs);

$unit=$u['UNIT_NAME'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
convert_var($bulan,$ta);
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];


$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];
convert_var($minta_id,$jns_pasien);

if($jns_pasien=="" OR $jns_pasien=="0"){
	$jns_pasien="0";
	$jns_p="";
}else{
	$jns_p=" and a_kepemilikan.ID=$jns_pasien";
}
$kso_id=$_REQUEST['kso_id'];
$status_inap=$_REQUEST['status_inap'];
convert_var($kso_id,$status_inap);
if($kso_id=="" OR $kso_id=="0") $kso=""; else $kso=" and am.IDMITRA=$kso_id";
if($status_inap=="" OR $status_inap=="0") $status_i=""; else $status_i=" and a_unit.status_inap=$status_inap";

$ninap='All Pasien';
$nkso='All KSO';
$tgl_d=$_REQUEST['tgl_d'];
convert_var($kso,$status_i,$ninap,$nkso,$tgl_d);
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tgl_s);

if ($tgl_d=="") $tgl_d=$tgl;
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";

if ($tgl_s=="") $tgl_s=$tgl;
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";

//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="a_penjualan.TGL_ACT DESC,a_penjualan.NO_PENJUALAN DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($tgl_se,$tgl_de,$page,$sorting,$filter);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
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
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
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
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
  	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="view" style="display:block">
	  <p><span class="jdltable">LAPORAN PENJUALAN APOTEK</span> 
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="127">Tanggal Periode</td>
          <td colspan="2">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
            s/d
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" >
            </input> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />            </input>          </td>
        </tr>
        <tr> 
          <td width="127">Kepemilikan</td>
          <td width="177">: 
            <select name="jns_pasien" id="jns_pasien" class="txtinput" onchange="location='?f=../gudang/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kso_id='+kso_id.value+'&status_inap='+status_inap.value">
              <option value="0" class="txtinput">All Kepemilikan</option>
              <?
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 order by ID";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
              <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($jns_pasien==$show['ID']) echo "selected";?>><?php echo $show['NAMA']; ?></option>
              <? }?>
            </select> </td>
          <td width="179" > <button type="button" onclick="location='?f=../gudang/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kso_id='+kso_id.value+'&status_inap='+status_inap.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr> 
          <td>Jenis Pasien</td>
          <td colspan="2">: 
            <select name="status_inap" id="status_inap" class="txtinput" onchange="location='?f=../gudang/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kso_id='+kso_id.value+'&status_inap='+status_inap.value">
              <option value="0" class="txtinput">All Pasien</option>
              <option value="1" class="txtinput"<?php if ($status_inap=="1") {echo 'selected';$ninap='Rawat Inap';}?>>Rawat Inap</option>
              <option value="2" class="txtinput"<?php if ($status_inap=="2") {echo 'selected';$ninap='Rawat Jalan';}?>>Rawat Jalan</option>
            </select> </td>
        </tr>
        <tr> 
          <td>KSO</td>
          <td colspan="2">: 
            <select name="kso_id" id="kso_id" class="txtinput" onchange="location='?f=../gudang/list_penjualan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&kso_id='+kso_id.value+'&status_inap='+status_inap.value">
              <option value="0" class="txtinput">All KSO</option>
              <?
					  $qry="SELECT * FROM a_mitra order by NAMA";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){
					?>
              <option value="<?php echo $show['IDMITRA']; ?>" class="txtinput"<?php if ($kso_id==$show['IDMITRA']) {echo "selected";$nkso=$show['NAMA'];}?>><?php echo $show['NAMA']; ?></option>
              <? }?>
            </select> </td>
        </tr>
      </table>
      <table width="100%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TGL" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Tgl 
            Act</td>
          <td id="NO_PENJUALAN" width="70" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Penjualan</td>
          <td id="USER" width="53" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Resep </td>
          <td id="NO_PASIEN" width="60" class="tblheader" onclick="ifPop.CallFr(this);">No 
            RM</td>
          <td id="NAMA_PASIEN" class="tblheader" onclick="ifPop.CallFr(this);">Nama 
            Pasien</td>
          <td id="ac.NAMA" width="82" class="tblheader" onclick="ifPop.CallFr(this);">Cara 
            Bayar </td>
          <td id="au.UNIT_NAME" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Unit</td>
          <td id="a_unit.UNIT_NAME" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Ruangan<br>(Poli)</td>
          <td width="120" class="tblheader" id="DOKTER" onclick="ifPop.CallFr(this);">Dokter</td>
          <td width="32" class="tblheader" id="SHIFT" onclick="ifPop.CallFr(this);">Shift</td>
          <td id="SUM_SUB_TOTAL" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Total 
          </td>
          <td width="30" class="tblheader" onclick="ifPop.CallFr(this);">Detil</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }

	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se;
	/*$sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, 
		a_kepemilikan.NAMA, a_unit.UNIT_NAME, au.UNIT_NAME AS UNIT_NAME1, a_penjualan.DOKTER, a_penjualan.SHIFT,ac.nama AS cara_bayar, 
		(SUM(FLOOR(a_penjualan.QTY_JUAL*a_penjualan.HARGA_SATUAN))-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL
		FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
		INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
		INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
		INNER JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
		WHERE (a_penjualan.TGL BETWEEN '$tgl_1' AND '$tgl_2') AND (au.UNIT_TIPE<>5)".$jns_p.$status_i.$kso.$filter." 
		GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN ORDER BY ".$sorting;*/
		
	$sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, 
		a_kepemilikan.NAMA, a_unit.UNIT_NAME, au.UNIT_NAME AS UNIT_NAME1, a_penjualan.DOKTER, a_penjualan.SHIFT,ac.nama AS cara_bayar, 
		(a_penjualan.HARGA_TOTAL-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL2,
		SUM((a_penjualan.QTY_JUAL - a_penjualan.QTY_RETUR) * a_penjualan.HARGA_SATUAN) AS HARGA_TOTAL
		FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
		INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
		INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
		INNER JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
		WHERE (a_penjualan.TGL BETWEEN '$tgl_1' AND '$tgl_2') AND (au.UNIT_TIPE<>5)".$jns_p.$status_i.$kso.$filter." AND a_penjualan.UNIT_ID NOT IN(8,9) 
		GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN ORDER BY ".$sorting;
	//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i ?></td>
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NO_RESEP']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['cara_bayar']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['UNIT_NAME1']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['DOKTER']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['SHIFT']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_TOTAL'],0,",","."); ?></td>
          <td class="tdisi" align="center"><a href="../report/kwi_retur.php?no_penjualan=<?php echo $rows['NO_PENJUALAN'];?>&sunit=<?php echo $rows['UNIT_ID']; ?>&no_pasien=<?php echo $rows['NO_PASIEN']; ?>&tgl=<?php echo $rows['TGL']; ?>" onclick="NewWindow(this.href,'name','560','500','yes');return false"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Melihat Detail Penjualan"></a></td>
        </tr>
        <?php
	  }
	  mysqli_free_result($rs);
	  $sql2="select sum(t1.HARGA_TOTAL) as HARTOT from (".$sql.")as t1";
	  $hs=mysqli_query($konek,$sql2);
	  $hartot=0;
	  $show=mysqli_fetch_array($hs);
	  $hartot=$show['HARTOT'];
	  $sql2="SELECT COUNT(t2.NO_RESEP) AS jml_resep FROM (SELECT DISTINCT t1.NO_RESEP FROM (".$sql.") AS t1) AS t2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $totresep=0;
	  if ($rows=mysqli_fetch_array($rs))	$totresep=$rows['jml_resep'];  
	  ?>
        <tr class="itemtable"> 
          <td class="tdisikiri" align="right" colspan="3">Resep Total &nbsp; </td>
          <td class="tdisi" align="right"><?php echo number_format($totresep,0,",","."); ?></td>
          <td class="tdisi" align="right" colspan="7">Jumlah Total &nbsp; </td>
          <td class="tdisi" align="right">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
          <td width="2" class="tdisi">&nbsp;</td>
        </tr>
      </table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <p align="center"><span class="jdltable">LAPORAN PENJUALAN APOTEK</span> 
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="177" class="txtcenter">( <?php echo $tgl_d;?> s/d 
            <?php echo $tgl_s;?> ) </td>
        </tr>
        <tr> 
          <td width="127" class="txtcenter">Kepemilikan : 
            <?php
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 and ID=$jns_pasien order by ID";
					  //echo $qry;
					  $exe=mysqli_query($konek,$qry);
					  if ($show=mysqli_fetch_array($exe)){
					  		echo $show['NAMA'];
							$k1=$show['NAMA'];
					  }else{
					  		echo "All Kepemilikan";
							$k1="All Kepemilikan";
					  }
					?>
          </td>
        </tr>
        <tr>
          <td class="txtcenter">Jenis Pasien : <?php echo $ninap; ?></td>
        </tr>
        <tr> 
          <td class="txtcenter">KSO : <?php echo $nkso; ?> </td>
        </tr>
      </table>
      <table width="100%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="31" height="25" class="tblheaderkiri">No</td>
          <td width="70" class="tblheader">Tgl Act</td>
          <td width="70" class="tblheader">No Penjualan</td>
          <td width="53" class="tblheader">No Resep</td>
          <td width="60" class="tblheader">No RM</td>
          <td class="tblheader">Nama Pasien</td>
          <td width="82" class="tblheader">Cara Bayar</td>
          <td width="80" class="tblheader">Unit</td>
          <td width="90" class="tblheader">Ruangan<br>(Poli)</td>
          <td width="120" class="tblheader">Dokter</td>
          <td width="33" class="tblheader">Shift</td>
          <td width="80" class="tblheader">Total </td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  $rs=mysqli_query($konek,$sql);
	  $p=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$p++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_RESEP']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['cara_bayar']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['UNIT_NAME1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['DOKTER']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['SHIFT']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($rows['HARGA_TOTAL'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3"  align="right" class="txtright">Resep Total &nbsp; </td>
          <td align="right" class="txtright"><?php echo number_format($totresep,0,",","."); ?></td>
          <td colspan="7" align="right" class="txtright">Jumlah Total &nbsp; </td>
          <td align="right" class="txtright">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
        </tr>
      </table>
	</div>
    <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <td align="center" colspan="2"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onclick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak Penjualan</BUTTON></a>
        <BUTTON type="button" onClick="OpenWnd('../gudang/list_penjualan_Excell.php?tgld=<?php echo $tgl_1; ?>&tgls=<?php echo $tgl_2; ?>&kpid=<?php echo $jns_pasien; ?>&status_inap=<?php echo $status_inap; ?>&kso_id=<?php echo $kso_id; ?>&k1=<?php echo $k1; ?>&g1=<?php echo $ninap; ?>&j1=<?php echo $nkso; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>',600,450,'childwnd',true);;"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON>
        </td>
	  </tr>
	  </table>
  	</form>
  </div>
</body>
</html>

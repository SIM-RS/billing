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
$idunit1=$_REQUEST['idunit1'];
if ($idunit1=="") $idunit1=$idunit;
if ($idunit1=="0" || $idunit1=="1"){
	$idunit1="0";
	$kunit="";
	$unit="ALL UNIT";
}else{
	$kunit=" UNIT_ID=$idunit1 AND ";
	$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit1";
	$rs=mysqli_query($konek,$sql);
	$u=mysqli_fetch_array($rs);
	$unit=$u['UNIT_NAME'];
}
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p="and a_kepemilikan.ID=$jns_pasien";
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
//$defaultsort="TGL_ACT desc";
$defaultsort="t2.TGL DESC,t2.SHIFT";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
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
	winpopup.document.write("<p class='txtinput'  style='padding-right:105px; text-align:right;'>");
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
	<p><span class="jdltable">LAPORAN SUMMARY PENDAPATAN 
            <select name="idunit1" id="idunit1" class="txtinput" onchange="location='?f=../apotik/sum_pendapatan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit1='+idunit1.value">
              <option value="0" class="txtinput">All Unit</option>
              <?
					  $qry="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ISAKTIF=1";
					  $exe=mysqli_query($konek,$qry);
					  $i=0;
					  while($show=mysqli_fetch_array($exe)){
					  	$i++;
						if ($idunit1==1 && $i==1) $idunit1=$show['UNIT_ID'];
					?>
              <option value="<?php echo $show['UNIT_ID']; ?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']) echo "selected";?>><?php echo $show['UNIT_NAME']; ?></option>
              <? }?>
            </select></span>
	
	  <table border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td>Tgl Periode</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" />
        <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
            &nbsp;s/d&nbsp;
<input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" > 
        <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
		&nbsp;<button type="button" onclick="location='?f=../apotik/sum_pendapatan.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit1='+idunit1.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>
		</td>
		</tr>
	</table>
      <table width="90%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="t2.TGL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Tanggal</td>
          <td id="t2.SHIFT" width="40" class="tblheader" onclick="ifPop.CallFr(this);">Shift</td>
          <td id="t2.NAMA" class="tblheader" onclick="ifPop.CallFr(this);">KSO</td>
          <td width="90" class="tblheader" id="t2.KPNAMA" onclick="ifPop.CallFr(this);">Jenis 
            Pasien </td>
          <td id="t2.cara_bayar" width="115" class="tblheader" onclick="ifPop.CallFr(this);">Cara 
            Bayar</td>
          <td id="t2.tot_jual" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Total Jual</td>
          <td id="t2.tot_retur" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Total Retur</td>
          <td width="80" class="tblheader">Setoran</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
		//echo $filter."<br>";
	  if ($filter!=""){
	  	//$jfilter=$filter;
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
		$filter=" WHERE ".substr($filter,5,strlen($filter)-5);
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=$tgl2; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=$tgl2; else $tgl_2=$tgl_se;
		$sql="SELECT DATE_FORMAT(t2.TGL,'%d/%m/%Y') AS TGL,t2.SHIFT,t2.NAMA,t2.KSO_ID,t2.KPID,t2.KPNAMA,t2.CARABAYAR_ID,t2.cara_bayar,SUM(t2.tot_jual) AS tot_jual,
			SUM(t2.tot_retur) AS tot_retur 
			FROM (SELECT t1.TGL,t1.SHIFT,t1.NAMA,t1.KSO_ID,t1.KPID,t1.KPNAMA,t1.CARABAYAR_ID,t1.cara_bayar,
			SUM(t1.tot_jual) AS tot_jual,tot_retur FROM 
			(SELECT TGL,TGL_ACT,NO_PENJUALAN,SHIFT,ap.KSO_ID,am.NAMA,ak.ID AS KPID,ak.NAMA AS KPNAMA,
			ac.id AS CARABAYAR_ID,ac.nama AS cara_bayar,FLOOR(HARGA_TOTAL) tot_jual,0 AS tot_retur 
			FROM a_penjualan ap INNER JOIN a_mitra am ON ap.KSO_ID=am.IDMITRA INNER JOIN a_cara_bayar ac ON ap.CARA_BAYAR=ac.id 
			INNER JOIN a_kepemilikan ak ON ap.JENIS_PASIEN_ID=ak.ID 
			WHERE ".$kunit."ap.TGL BETWEEN '$tgl_1' AND '$tgl_2' 
			GROUP BY SHIFT,NO_PENJUALAN,TGL,ap.KSO_ID,ap.UNIT_ID,ap.JENIS_PASIEN_ID,ap.CARA_BAYAR,ap.NO_PASIEN ORDER BY TGL_ACT DESC) AS t1 
			GROUP BY t1.TGL,t1.SHIFT,t1.NAMA,t1.KPNAMA,t1.cara_bayar
			UNION
			SELECT DATE(ar.tgl_retur) AS TGL,ar.shift_retur AS SHIFT,am1.NAMA,ap.KSO_ID,ap.JENIS_PASIEN_ID AS KPID,
			ak1.NAMA AS KPNAMA,ap.CARA_BAYAR AS CARABAYAR_ID,ac1.nama AS cara_bayar,0 AS tot_jual,SUM(ar.nilai) AS tot_retur 
			FROM a_return_penjualan ar INNER JOIN a_penjualan ap ON ar.idpenjualan=ap.ID INNER JOIN a_mitra am1 ON ap.KSO_ID=am1.IDMITRA 
			INNER JOIN a_kepemilikan ak1 ON ap.JENIS_PASIEN_ID=ak1.ID INNER JOIN a_cara_bayar ac1 ON ap.CARA_BAYAR=ac1.id 
			WHERE ".$kunit." DATE(ar.tgl_retur) BETWEEN '$tgl_1' AND '$tgl_2'
			GROUP BY DATE(ar.tgl_retur),ar.shift_retur,ap.KSO_ID,ap.JENIS_PASIEN_ID,ap.UNIT_ID,ap.CARA_BAYAR,ap.NO_PASIEN) AS t2".$filter."
			GROUP BY t2.TGL,t2.SHIFT,t2.KSO_ID,t2.KPID,t2.CARABAYAR_ID ORDER BY ".$sorting;
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
	  $tot_ret=0;
	  $setoran=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$ttot_jual=$rows["tot_jual"];
		$t_ret=$rows["tot_retur"];
		$tsetoran=$ttot_jual-$t_ret;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['TGL']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['SHIFT']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['KPNAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['cara_bayar']; ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($ttot_jual,0,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($t_ret,0,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<?php echo number_format($tsetoran,0,",","."); ?></td>
        </tr>
        <?php
	  }
	  mysqli_free_result($rs);
	  $sql2="select sum(t4.tot_jual) as tot_jual,sum(t4.tot_retur) as tot_retur from (".$sql.") as t4";
	   $hs=mysqli_query($konek,$sql2);
	 $tot_jual=0;
	 $tot_retur=0;
	 //$tot_ret=0;
	 //$setoran=0;
	 if ($show=mysqli_fetch_array($hs)){
		 $tot_jual=$show['tot_jual'];
		 $tot_retur=$show['tot_retur'];
		 //$tot_ret=$show['tot_ret'];
		 $setoran=$tot_jual-$tot_retur;
	 }
	 
/*	$sql2="select UNIT_NAME from a_unit where UNIT_ID=$idunit1";
	$rs=mysqli_query($konek,$sql2);
	$u=mysqli_fetch_array($rs);
	$unit=$u['UNIT_NAME'];*/
	  ?>
        <tr class="itemtable"> 
          <td class="tdisikiri" align="right" colspan="6">Jumlah Total &nbsp; 
          </td>
          <td class="tdisi" align="right">&nbsp;<? echo number_format($tot_jual,0,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<? echo number_format($tot_retur,0,",","."); ?></td>
          <td class="tdisi" align="right">&nbsp;<? echo number_format($setoran,0,",","."); ?></td>
        </tr>
      </table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">LAPORAN SUMMARY PENDAPATAN <? echo strtoupper($unit) ?></span>  
	  <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td align="center">( 
            <?php if ($_GET['tgl_d']!="") echo $_GET['tgl_d']; else echo $tgl;?>
            s/d
            <?php if ($_GET['tgl_s']!="") echo $_GET['tgl_s']; else echo $tgl;?>
            ) </td>
        </tr>
      </table>
      <table width="90%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td width="90" class="tblheader">Tanggal</td>
          <td width="40" class="tblheader">Shift</td>
          <td class="tblheader">KSO</td>
          <td width="90" class="tblheader">Jenis 
            Pasien </td>
          <td width="115" class="tblheader">Cara 
            Bayar </td>
          <td width="80" class="tblheader">Total Jual</td>
          <td width="80" class="tblheader">Total Retur</td>
          <td width="80" class="tblheader">Setoran</td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  $rs=mysqli_query($konek,$sql);
	  $tot_ret=0;
	  while ($rows=mysqli_fetch_array($rs)){
		$ttot_jual=$rows["tot_jual"];
		$t_ret=$rows["tot_retur"];
		$tsetoran=$ttot_jual-$t_ret;
		$p++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['TGL']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['SHIFT']; ?></td>
          <td align="left" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['KPNAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['cara_bayar']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($ttot_jual,0,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($t_ret,0,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<?php echo number_format($tsetoran,0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr class="itemtable"> 
          <td class="tdisikiri" align="right" colspan="6" style="font-size:12px;">Jumlah 
            Total &nbsp; </td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<? echo number_format($tot_jual,0,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<? echo number_format($tot_retur,0,",","."); ?></td>
          <td class="tdisi" align="right" style="font-size:12px;">&nbsp;<? echo number_format($setoran,0,",","."); ?></td>
        </tr>
      </table>
	</div>
    <table width="90%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr>
	 <td align="center" colspan="2"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onclick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak Pendapatan </BUTTON></a>
        <BUTTON type="button" onClick="OpenWnd('../apotik/sum_pendapatan_excell.php?tgl_d=<?php echo $tgl_1; ?>&tgl_s=<?php echo $tgl_2; ?>&idunit1=<?php echo $idunit1; ?>&filter='+filter.value+'&sorting=<?php echo $sorting; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON>
	 </td>
	  </tr>
	  </table>
  	</form>
  </div>
</body>
</html>

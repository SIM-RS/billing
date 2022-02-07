<?php 
include("../sesi.php");
include("../koneksi/konek.php");
/*$konek=mysql_connect('192.168.0.3',"root","rsudsda");
mysql_select_db("dbapotek",$konek);*/
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_SESSION["ses_idunit"];
$idunit=$_REQUEST['idunit'];if ($idunit=="") $idunit=0;
$sql="select UNIT_NAME from a_unit where UNIT_ID='$idunit'";
$rs=mysql_query($sql);
$u=mysql_fetch_array($rs);
$unit=$u['UNIT_NAME'];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$jns_pasien=$_REQUEST['jns_pasien'];if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p=" and a_kepemilikan.ID=$jns_pasien";
$statuspasien=$_REQUEST['statuspasien'];if($statuspasien=="" OR $statuspasien=="0") $statusp=""; else $statusp=" and (a_unit.status_inap=$statuspasien)";

$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="a_penjualan.NO_PENJUALAN DESC";
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
var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars');
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
function PrintArea1(idArea,fileTarget){
//var g;
var winpopup=window.open(fileTarget,'winpopup','height=5,width=10,resizable,scrollbars');
/*	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:20px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	g=winpopup.document.getElementById("idprint").innerHTML;*/
	//setTimeout("alert(document.getElementById('mdata').value);document.getElementById('mdata').value='';alert(document.getElementById('mdata').value);",5000);
	//winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
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
	<input name="mdata" id="mdata" type="hidden" value="">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div id="view" style="display:block"> 
      <p><span class="jdltable">DAFTAR PENJUALAN 
        <select name="idunit" id="idunit" class="txtinput" onchange="location='?idunit='+this.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value">
          <option value="0" class="txtinput"<?php if ($idunit=="0") echo "selected";?>>ALL UNIT</option>
		  <?
		  $qry="select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
		  $exe=mysql_query($qry);
		  $i=0;
		  while($show=mysql_fetch_array($exe)){ 
		  	$i++;
			//if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
          <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) echo "selected";?>> 
          <?php echo $show['UNIT_NAME'];?></option>
          <? }?>
        </select>
        </span> 
      <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="127">Tanggal Periode</td>
          <td colspan="2">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d']; else echo $tgl;?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
            </input>&nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s']; else echo $tgl;?>" >
            </input> 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />            </input>          </td>
        </tr>
        <tr> 
          <td width="127">Kepemilikan</td>
          <td width="177">: 
            <select name="jns_pasien" id="jns_pasien" class="txtinput" onchange="location='?idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value">
              <option value="0" class="txtinput">All Pasien</option>
              <?
			  	$jp="ALL PASIEN";
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 order by ID";
					  $exe=mysql_query($qry);
					  while($show=mysql_fetch_array($exe)){ 
					?>
              <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($jns_pasien==$show['ID']) {echo "selected";$jp=$show['NAMA'];}?>><?php echo $show['NAMA']; ?></option>
              <? }?>
            </select> </td>
          <td width="179" > <button type="button" onclick="location='?idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
        <tr>
          <td>Jenis Pasien</td>
          <td>:
            <select name="statuspasien" id="statuspasien" class="txtinput" onchange="location='?idunit='+idunit.value+'&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&jns_pasien='+jns_pasien.value+'&statuspasien='+statuspasien.value">
            <?php 
			$sp="ALL PASIEN";
			?>
              <option value="0" class="txtinput">All Pasien</option>
              <option value="1" class="txtinput"<?php if ($statuspasien=="1") {echo "selected";$sp="RAWAT INAP";}?>>Rawat Inap</option>
              <option value="2" class="txtinput"<?php if ($statuspasien=="2") {echo "selected";$sp="RAWAT JALAN";}?>>Rawat Jalan</option>
              <option value="3" class="txtinput"<?php if ($statuspasien=="3") {echo "selected";$sp="IGD";}?>>Inst. Gawat Darurat</option>
            </select></td>
          <td >&nbsp;</td>
        </tr>
      </table>
      <br />
      <table width="900" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="30" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="am.NAMA" width="120" class="tblheader" onclick="ifPop.CallFr(this);">KSO</td>
          <td width="50" class="tblheader" id="ac.nama" onclick="ifPop.CallFr(this);">Cara 
            Bayar </td>
          <td id="a_unit.UNIT_NAME" width="135" class="tblheader" onclick="ifPop.CallFr(this);">Ruangan<br>
            (Poli)</td>
          <td width="30" class="tblheader" id="SHIFT" onclick="ifPop.CallFr(this);">Shift</td>
          <td width="60" class="tblheader" id="SHIFT" onclick="ifPop.CallFr(this);">Netto</td>
          <td id="SUM_SUB_TOTAL" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
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
		
	 if ($idunit=="0"){
	 	$tmpunit="";
	 }else{
	 	$tmpunit="(a_penjualan.UNIT_ID ='$idunit') AND ";
	 }
	
	/*$sql="SELECT date_format(a_penjualan.TGL,'%d/%m/%Y') as tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN,am.NAMA AS KSO, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, a_penjualan.USER_ID, 
		a_kepemilikan.NAMA, a_unit.UNIT_NAME, a_penjualan.DOKTER, a_penjualan.SHIFT, a_penjualan.CARA_BAYAR,ac.nama as cbayar, a_penjualan.UTANG,SUM(a_penjualan.QTY_JUAL*a_penjualan.HARGA_NETTO) AS HARGA_NETTO, HARGA_TOTAL, 
		SUM(a_penjualan.QTY_RETUR) as jRetur 
		FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
		INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) INNER JOIN a_cara_bayar ac
		ON a_penjualan.CARA_BAYAR=ac.id LEFT JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
		WHERE $tmpunit(a_penjualan.TGL BETWEEN '$tgl_1' AND '$tgl_2')".$jns_p.$statusp.$filter." 
		GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.JENIS_PASIEN_ID,a_penjualan.NO_PASIEN ORDER BY ".$sorting;*/
		
	$sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN,am.NAMA AS KSO, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, a_penjualan.USER_ID, 
		a_kepemilikan.NAMA, a_unit.UNIT_NAME, a_penjualan.DOKTER, a_penjualan.SHIFT, a_penjualan.CARA_BAYAR,ac.nama AS cbayar, 
		a_penjualan.UTANG,SUM(FLOOR((a_penjualan.QTY_JUAL-a_penjualan.QTY_RETUR)*a_penjualan.HARGA_NETTO)) AS HARGA_NETTO,(a_penjualan.HARGA_TOTAL-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL,SUM(a_penjualan.QTY_RETUR) as jRetur
		FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
		INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
		INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
		LEFT JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
		WHERE $tmpunit(a_penjualan.TGL BETWEEN '$tgl_1' AND '$tgl_2')".$jns_p.$statusp.$kso.$filter." 
		GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN,a_penjualan.USER_ID ORDER BY ".$sorting;
		
		$sql="SELECT 
			  KSO,
			  cbayar,
			  UNIT_NAME,
			  SHIFT,
			  SUM(HARGA_TOTAL) AS HARGA_TOTAL,
			  SUM(HARGA_NETTO) AS HARGA_NETTO 
			FROM
			  (SELECT 
				DATE_FORMAT(a_penjualan.TGL, '%d/%m/%Y') AS tgl1,
				a_penjualan.TGL,
				a_penjualan.UNIT_ID,
				a_penjualan.NO_PENJUALAN,
				am.NAMA AS KSO,
				a_penjualan.NO_RESEP,
				a_penjualan.NO_PASIEN,
				a_penjualan.NAMA_PASIEN,
				a_penjualan.USER_ID,
				a_kepemilikan.NAMA,
				a_unit.UNIT_NAME,
				a_penjualan.DOKTER,
				a_penjualan.SHIFT,
				a_penjualan.CARA_BAYAR,
				ac.nama AS cbayar,
				a_penjualan.UTANG,
				SUM(
				  FLOOR(
					a_penjualan.QTY_JUAL * a_penjualan.HARGA_NETTO
				  )
				) AS HARGA_NETTO,
				SUM(
				  FLOOR(
					(
					  a_penjualan.QTY_JUAL - a_penjualan.QTY_RETUR
					) * a_penjualan.HARGA_NETTO
				  )
				) AS HARGA_NETTO_RTR,
				(a_penjualan.HARGA_TOTAL) AS HARGA_TOTAL,
				(
				  a_penjualan.HARGA_TOTAL - SUM(
					FLOOR(
					  a_penjualan.QTY_RETUR * a_penjualan.HARGA_SATUAN * (
						(100- a_penjualan.BIAYA_RETUR) / 100
					  )
					)
				  )
				) AS HARGA_TOTAL_RTR,
				SUM(a_penjualan.QTY_RETUR) AS jRetur 
			  FROM
				a_penjualan 
				LEFT JOIN a_unit 
				  ON (
					a_penjualan.RUANGAN = a_unit.UNIT_ID
				  ) 
				INNER JOIN a_kepemilikan 
				  ON (
					a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID
				  ) 
				INNER JOIN a_unit au 
				  ON a_penjualan.UNIT_ID = au.UNIT_ID 
				INNER JOIN a_cara_bayar ac 
				  ON a_penjualan.CARA_BAYAR = ac.id 
				LEFT JOIN a_mitra am 
				  ON a_penjualan.KSO_ID = am.IDMITRA 
			  WHERE $tmpunit 
				 (
				  a_penjualan.TGL BETWEEN '$tgl_1' AND '$tgl_2'
				) ".$jns_p.$statusp.$kso.$filter."
			  GROUP BY a_penjualan.NO_PENJUALAN,
				a_penjualan.UNIT_ID,
				a_penjualan.NAMA_PASIEN,
				a_penjualan.USER_ID 
			  ORDER BY a_penjualan.NO_PENJUALAN DESC) AS gab 
			GROUP BY KSO,
			  cbayar,
			  UNIT_NAME,
			  SHIFT 
			ORDER BY KSO,
			  cbayar,
			  UNIT_NAME,
			  SHIFT";
	    //echo $sql."<br>";
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysql_query($sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysql_fetch_array($rs)){
		$i++;
		$jRetur=$rows['jRetur'];
		$tCaraBayar=$rows['CARA_BAYAR'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center"><?php echo $i ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['KSO']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['cbayar']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['SHIFT']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_NETTO'],0,",","."); ?>&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_TOTAL'],0,",","."); ?>&nbsp;</td>
        </tr>
        <?php
	 //$hartot=$hartot+$rows['HARGA_TOTAL'];
	  }
	  mysql_free_result($rs);
	  $sql2="select sum(t1.HARGA_NETTO) as HARNET,sum(t1.HARGA_TOTAL) as HARTOT from (".$sql.")as t1";
	  $hs=mysql_query($sql2);
	  $hartot=0;
	  $harnet=0;
	  $show=mysql_fetch_array($hs);
	  $hartot=$show['HARTOT'];
	  $harnet=$show['HARNET'];
	  $sql2="SELECT COUNT(t2.NO_RESEP) AS jml_resep FROM (SELECT DISTINCT t1.NO_RESEP FROM (".$sql.") AS t1) AS t2";
	  //$rs=mysql_query($sql2);
	  $totresep=0;
	  //if ($rows=mysql_fetch_array($rs))	$totresep=$rows['jml_resep'];  
	  ?>
        <tr class="itemtable"> 
          <td class="tdisikiri" align="center" colspan="5" style="font-weight:bold">Jumlah Total &nbsp; </td>
          <td class="tdisi" align="right" style="font-weight:bold">&nbsp;<? echo number_format($harnet,0,",","."); ?>&nbsp;</td>
          <td class="tdisi" align="right" style="font-weight:bold">&nbsp;<? echo number_format($hartot,0,",","."); ?>&nbsp;</td>
        </tr>
      </table>
	</div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">DAFTAR PENJUALAN <? echo strtoupper($unit) ?></span>  
	  <table width="48%" border="0" align="center" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="177" class="txtcenter">( 
            <?php if ($_GET['tgl_d']!="") echo $_GET['tgl_d']; else echo $tgl;?>
            s/d 
            <?php if ($_GET['tgl_s']!="") echo $_GET['tgl_s']; else echo $tgl;?>
            ) </td>
        </tr>
        <tr> 
          <td width="127" class="txtcenter">Kepemilikan : 
            <?
					if ($jns_pasien==""){
						echo "ALL PASIEN";
					}else{
					  $qry="select ID,NAMA from a_kepemilikan where AKTIF=1 and ID=$jns_pasien order by ID";
					  $exe=mysql_query($qry);
					  $show=mysql_fetch_array($exe);
					  //echo $qry."<br>";
					  if ($show['NAMA']=="") echo "ALL PASIEN"; else echo $show['NAMA'];
					}
					?>
          </td>
        </tr>
        <tr>
          <td class="txtcenter">Jenis Pasien : 
            <? 
				if (($statuspasien=="")||($statuspasien=="0")){
					echo "ALL PASIEN";
				}elseif ($statuspasien=="1"){
					echo "Rawat Inap";
				}elseif ($statuspasien=="2"){
					echo "Rawat Jalan";
				}elseif ($statuspasien=="3"){
					echo "Inst. Gawat Darurat";
				}
			?>
          </td>
        </tr>
      </table>
      <table width="100%" align="center" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td id="" width="31" height="25" class="tblheaderkiri" onclick="">No</td>
          <td id="TGL_ACT" width="70" class="tblheader" onclick="">Tgl Act</td>
          <td id="NO_KUNJUNGAN" width="70" class="tblheader">No Penjualan</td>
          <td id="NO_KUNJUNGAN" width="53" class="tblheader">No Resep</td>
          <td id="NO_PASIEN" width="60" class="tblheader">No RM</td>
          <td id="NAMA_PASIEN" class="tblheader">Nama Pasien</td>
          <td width="80" class="tblheader" id="NAMA_PASIEN">Cara Bayar</td>
          <td id="am.NAMA" width="140" class="tblheader">KSO</td>
          <td id="UNIT_NAME" width="130" class="tblheader">Ruangan<br>
            (Poli)</td>
          <td width="33" class="tblheader" id="DOKTER">Shift</td>
          <td id="SUM_SUB_TOTAL" width="80" class="tblheader">Total </td>
          <!--td class="tblheader" width="30">Proses</td-->
        </tr>
        <?php 
	  $rs=mysql_query($sql);
	  $p=0;
	  while ($rows=mysql_fetch_array($rs)){
		$p++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NO_PENJUALAN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_RESEP']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['NAMA_PASIEN']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['cbayar']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['KSO']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;">&nbsp;<?php echo $rows['UNIT_NAME']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['SHIFT']; ?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_TOTAL'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysql_free_result($rs);
	  ?>
        <!--tr class="">
	  <td colspan="8"></td>
	  <td class="tdisikiri itemtable" align="center" colspan="2">Jumlah Total</td>
	  <td class="tdisi itemtable" align="right" style="font-size:12px;">&nbsp;<? echo number_format($show['HARTOT'],0,",","."); ?></td>
	  <td width="2" class=""></td>
	  </tr-->
        <tr> 
          <td colspan="3"  align="right" class="txtright">Resep Total &nbsp; </td>
          <td align="right" class="txtright"><?php echo number_format($totresep,0,",","."); ?></td>
          <td colspan="6" align="right" class="txtright">Jumlah Total &nbsp; </td>
          <td align="right" class="txtright">&nbsp;<? echo number_format($hartot,0,",","."); ?></td>
          <!--td width="2" class="tdisi">&nbsp;</td-->
        </tr>
      </table>
	</div>
    <table width="900" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="" align="right"><img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onclick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();" /> <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();" /> <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();" /> <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onclick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();" />&nbsp;&nbsp; </td>
      </tr>
	<tr style="display:none">
	 <!--td align="center" colspan="2"><BUTTON type="button" onclick="PrintArea1('idArea','http://localhost:10000/rsud-sda.prn?rpt=kw|004255|4|1267582|2009-10-30|ULFA');" <?php //if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON></td-->
	 <td align="center" colspan="2"><a class="navText" href='#' onclick='PrintArea("idArea","#")'>&nbsp;
		<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON></a>&nbsp;<BUTTON type="button" onClick="BukaWndExcell();" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export 
            ke File Excell</BUTTON></td>
	  </tr>
	  </table>
      <br />
  	</form>
  </div>
</body>
<script>
var req;

function PrintSvc(vMethod,vUrl){
	req = new newRequest(1);
  if (req.xmlhttp) {
	//alert('start');
    req.available = 0;
    //req.xmlhttp.open(vMethod , vUrl, false);
	req.xmlhttp.open('GET' , '../transaksi/updtelement1.php?kid=3', true);
	req.xmlhttp.onreadystatechange = function() {
	 // if (typeof(req) != 'undefined' && 
	//	req.available == 0 && 
	  if (req.xmlhttp.readyState == 4) {
		  if (req.xmlhttp.status == 200 || req.xmlhttp.status == 304) {
		  		alert(req.xmlhttp.responseText);
				//GetId(obj).innerHTML = req.xmlhttp.responseText;
				//cdata=req.xmlhttp.responseText;
				//if (cdata!="OK"){
				//	alert('reply salah');
					//PrintArea("idArea","#");
				//}
		  } else {
				req.xmlhttp.abort();
				alert('tdk ada servis');
				//PrintArea("idArea","#");*/
		  }
		  req.available = 1;
	  //}else{
	  //	alert('tdk ada servis');
	  }
	}
	
	if (window.XMLHttpRequest) {
	  req.xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  req.xmlhttp.send();
	}
  }
  return false;
}

function newRequest(available) {
	this.available = available;
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}
}

function BukaWndExcell(){
var tgld=tgl_d.value;
var tgls=tgl_s.value;
var idunit1=idunit.value;
var jpasien=jns_pasien.value;
var spasien=statuspasien.value;
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../apotik/list_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien+'&statuspasien='+spasien+'&jp=<?php echo $jp; ?>&sp=<?php echo $sp; ?>&filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>',600,450,'childwnd',true);
}

</script>
</html>
<?php 
mysql_close($konek);
?>
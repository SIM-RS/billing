<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=date('d-m-Y');
$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];

convert_var($tglctk,$tgl,$tgl_d,$tgl_s);

if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan emperkenalkan untuk melakukan ACT===
$idunit1=$_REQUEST['idunit'];
$poli=$_REQUEST['poli'];
$kel_pasien=$_REQUEST['kel_pasien'];
$kel_item=$_REQUEST['kel_item'];
convert_var($idunit1,$poli,$kel_pasien,$kel_item);

//echo "idunit=".$idunit."-".$id_gudang."<br>";
if (($idunit1=="") && ($idunit!=$id_gudang)) $idunit1=$idunit;
if ($idunit1=="" OR $idunit1=="0") $f_unit=""; else $f_unit="a.UNIT_ID=$idunit1 AND ";
if ($poli=="" OR $poli=="0") $f_poli=""; else $f_poli="au.status_inap=$poli AND ";
if ($kel_pasien=="" OR $kel_pasien=="0"){$kel_pasien="0";$f_kel_pasien="";} else $f_kel_pasien="am.KELOMPOK_ID=$kel_pasien AND ";
if ($kel_item=="" OR $kel_item=="0"){$kel_item="0";$f_kel_item="";} else {$f_kel_item="a.KSO_ID=$kel_item AND ";$f_kel_pasien="";}
//convert_var($idunit1,$f_unit,$f_poli,$f_kel_pasien,$f_kel_item);
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t2.DOKTER";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act'];
convert_var($page,$sorting,$filter,$act);
 // Jenis Aksi
//echo $act;
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
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=600,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
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
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
      <p><span class="jdltable">LAPORAN PEMANTAUAN RESEP TERLAYANI</span></p>
		
      <table border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td align="center"><span class="txtinput">Apotek</span> </td>
          <td align="left">:&nbsp; <select name="idunit" id="idunit" class="txtinput">
              <!-- <option value="0" class="txtinput"<?php if ($idunit1=="0") echo "selected";?>>ALL 
              UNIT</option> -->
              <?
		  $qry="select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			//if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']){echo "selected";$nmapotek=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Unit Rawat</span> </td>
          <td align="left">:&nbsp; <select name="poli" id="poli" class="txtinput">
              <option value="0" class="txtinput"<?php if ($poli=="0") echo "selected";?>>SEMUA</option>
              <option value="1" class="txtinput"<?php if ($poli=="1"){echo "selected";$nmapoli="RAWAT INAP";}?>>RAWAT INAP</option>
              <option value="2" class="txtinput"<?php if ($poli=="2"){echo "selected";$nmapoli="RAWAT JALAN";}?>>RAWAT JALAN</option>
              <option value="3" class="txtinput"<?php if ($poli=="3"){echo "selected";$nmapoli="INST. GAWAT DARURAT";}?>>INST. GAWAT DARURAT</option>
            </select></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Kel. Pasien</span> </td>
          <td align="left">:&nbsp; <select name="kel_pasien" id="kel_pasien" class="txtinput" onChange="UpdtList('kel_item','GET','../transaksi/updtelement.php?kid='+this.value);">
              <option value="0" class="txtinput"<?php if ($kel_pasien=="0") echo "selected";?>>SEMUA</option>
              <?
		  $qry="select * from a_kelompok_pasien";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?=$show['a_kpid'];?>" class="txtinput"<?php if ($kel_pasien==$show['a_kpid']){echo "selected";$nm_kel=$show['kp_nama'];}?>> 
              <?php echo $show['kp_nama'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">KSO</span> </td>
          <td align="left">:&nbsp; <select name="kel_item" id="kel_item" class="txtinput">
              <option value="0" class="txtinput"<?php if ($kel_pasien=="0" OR $kel_item=="0"){echo "selected";$nm_kel_item="";}?>>SEMUA</option>
              <?
			  $qry="SELECT * FROM a_mitra WHERE KELOMPOK_ID=$kel_pasien";
			  $exe=mysqli_query($konek,$qry);
			  $i=0;
			  while($show=mysqli_fetch_array($exe)){ 
			  ?>
              <option value="<?=$show['IDMITRA'];?>" class="txtinput"<?php if ($kel_item==$show['IDMITRA']){echo "selected";$nm_kel_item=" - ".$show['NAMA'];}?>> 
              <?php echo $show['NAMA'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../transaksi/rpt_obat_terlayani.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&poli='+poli.value+'&kel_pasien='+kel_pasien.value+'&kel_item='+kel_item.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>	  
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td class="tblheader" id="t2.DOKTER" onClick="ifPop.CallFr(this);">Nama 
            Dokter</td>
          <td width="70" class="tblheader" id="t2.JML_RESEP" onClick="ifPop.CallFr(this);">Jml 
            Resep </td>
          <td width="70" height="25" class="tblheader" id="t2.JML_R" onClick="ifPop.CallFr(this);">Jml R</td>
          <td width="70" class="tblheader" id="t2.GENERIK" onClick="ifPop.CallFr(this);">R/Generik</td>
          <td width="40" class="tblheader"> % </td>
          <td width="70" class="tblheader" id="t2.FORMULARIUM" onClick="ifPop.CallFr(this);">R/Form</td>
          <td width="40" class="tblheader">%</td>
          <td width="70" class="tblheader" id="t2.NONFORM" onClick="ifPop.CallFr(this);">R/Non Form</td>
          <td width="40" class="tblheader"> % </td>
          <td width="40" class="tblheader" id="t2.ALKES" onClick="ifPop.CallFr(this);">R/Alkes</td>
          <td width="40" class="tblheader">%</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
//	  $sql="SELECT DISTINCT ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID WHERE ak.UNIT_ID=$idunit1".$filter." ORDER BY ".$sorting;
	  	$sql="SELECT t2.*,t2.GENERIK*100/t2.JML_R AS PR_GEN,t2.FORMULARIUM*100/t2.JML_R AS PR_FORM,
			t2.NONFORM*100/t2.JML_R AS PR_NONFORM,t2.ALKES*100/t2.JML_R AS PR_ALKES
			FROM (SELECT t1.DOKTER,COUNT(t1.NO_PENJUALAN) AS JML_RESEP,SUM(t1.GENERIK+t1.FORMULARIUM+t1.NONFORM+t1.ALKES) AS JML_R,
			SUM(t1.GENERIK) AS GENERIK,SUM(t1.FORMULARIUM) AS FORMULARIUM,SUM(t1.NONFORM) AS NONFORM,SUM(t1.ALKES) AS ALKES
			FROM (SELECT a.DOKTER,a.NO_PENJUALAN,SUM(IF (d.OBAT_KATEGORI=1,1,0)) AS GENERIK, 
			SUM(IF (d.OBAT_KATEGORI=2,1,0)) AS FORMULARIUM,SUM(IF (d.OBAT_KATEGORI=3,1,0)) AS NONFORM,
			SUM(IF (d.OBAT_KATEGORI=4,1,0)) AS ALKES
			FROM a_penjualan a INNER JOIN a_penerimaan b ON a.PENERIMAAN_ID=b.ID 
			INNER JOIN a_obat d ON b.OBAT_ID=d.OBAT_ID LEFT JOIN a_mitra am ON a.KSO_ID=am.IDMITRA 
			LEFT JOIN a_unit au ON a.RUANGAN=au.UNIT_ID 
			WHERE ".$f_unit.$f_poli.$f_kel_pasien.$f_kel_item."a.TGL BETWEEN '$tgl_d1' AND '$tgl_s1'
			GROUP BY a.DOKTER,a.UNIT_ID,a.NO_PENJUALAN) AS t1
			GROUP BY t1.DOKTER) AS t2".	$filter." ORDER BY ".$sorting;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $tsaldo_awal=0;
	  $tsaldo_akhir=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['DOKTER']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['JML_RESEP']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['JML_R']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['GENERIK'];?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_GEN'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['FORMULARIUM']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_FORM'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['NONFORM']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_NONFORM'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['ALKES']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_ALKES'],2,",",".");?></td>
        </tr>
        <?php 
	  }
		$Tot_JML_RESEP=0;
		$Tot_JML_R=0;
		$Tot_GENERIK=0;
		$Tot_PR_GEN=0;
		$Tot_FORMULARIUM=0;
		$Tot_PR_FORM=0;
		$Tot_NONFORM=0;
		$Tot_PR_NONFORM=0;
		$Tot_ALKES=0;
		$Tot_PR_ALKES=0;
	  $sql2="SELECT if (SUM(t3.JML_RESEP) IS NULL,0,SUM(t3.JML_RESEP)) AS Tot_JML_RESEP,if (SUM(t3.JML_R) IS NULL,0,SUM(t3.JML_R)) AS Tot_JML_R,if (SUM(t3.GENERIK) IS NULL,0,SUM(t3.GENERIK)) AS Tot_GENERIK,
			if (SUM(t3.FORMULARIUM) IS NULL,0,SUM(t3.FORMULARIUM)) AS Tot_FORMULARIUM,if (SUM(t3.NONFORM) IS NULL,0,SUM(t3.NONFORM)) AS Tot_NONFORM,IF (SUM(t3.ALKES) IS NULL,0,SUM(t3.ALKES)) AS Tot_ALKES
			FROM (".$sql.") as t3";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  if ($rows=mysqli_fetch_array($rs)){
	  		$Tot_JML_RESEP=$rows["Tot_JML_RESEP"];
			$Tot_JML_R=$rows["Tot_JML_R"];
			$Tot_GENERIK=$rows["Tot_GENERIK"];
			if ($Tot_JML_R==0) $Tot_PR_GEN=0; else $Tot_PR_GEN=$Tot_GENERIK*100/$Tot_JML_R;
			$Tot_FORMULARIUM=$rows["Tot_FORMULARIUM"];
			if ($Tot_JML_R==0) $Tot_PR_FORM=0; else $Tot_PR_FORM=$Tot_FORMULARIUM*100/$Tot_JML_R;
			$Tot_NONFORM=$rows["Tot_NONFORM"];
			if ($Tot_JML_R==0) $Tot_PR_NONFORM=0; else $Tot_PR_NONFORM=$Tot_NONFORM*100/$Tot_JML_R;
			$Tot_ALKES=$rows["Tot_ALKES"];
			if ($Tot_JML_R==0) $Tot_PR_ALKES=0; else $Tot_PR_ALKES=$Tot_ALKES*100/$Tot_JML_R;
	  }
	  	?>
        <tr class="txtinput"> 
          <td colspan="2" align="right" class="tdisikiri">Sub Total&nbsp;</td>
		  <td align="right" class="tdisi"><?php echo $Tot_JML_RESEP;?></td>
		  <td align="right" class="tdisi"><?php echo $Tot_JML_R;?></td>
          <td align="right" class="tdisi"><?php echo $Tot_GENERIK;?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_GEN,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_FORMULARIUM; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_FORM,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_NONFORM; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_NONFORM,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_ALKES; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_ALKES,2,",",".");?></td>
        </tr>
        <tr> 
          <td align="left" colspan="4"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="8" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="12" align="center"> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick='PrintArea("idArea","#");'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Pemantauan Resep</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">LAPORAN PEMANTAUAN RESEP TERLAYANI</span> 
      <table border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td align="center"><span class="txtinput">Apotek</span> </td>
          <td align="left"><span class="txtinput">:&nbsp; 
            <?php if ($idunit1=="0" OR $idunit1=="") echo "ALL UNIT"; else echo $nmapotek; ?>
            </span></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Unit Rawat</span> </td>
          <td align="left"><span class="txtinput">:&nbsp; 
            <?php if ($poli=="0" OR $poli=="") echo "SEMUA"; else echo $nmapoli; ?>
            </span></td>
        </tr>
        <tr> 
          <td align="center"><span class="txtinput">Kelompok</span></td>
          <td align="left"><span class="txtinput">:&nbsp; 
            <?php if ($kel_pasien=="0" OR $kel_pasien=="") echo "SEMUA"; else echo $nm_kel.$nm_kel_item; ?>
            </span></td>
        </tr>
        <tr> 
          <td colspan="2" align="center"><span class="txtcenter"><?php echo "( ".$tgl_d." s/d ".$tgl_s." )"; ?></span></td>
        </tr>
      </table>	  
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" class="tblheaderkiri">No</td>
          <td class="tblheader" id="t2.DOKTER" onClick="ifPop.CallFr(this);">Nama 
            Dokter</td>
          <td width="70" class="tblheader">Jml Resep </td>
          <td width="70" height="25" class="tblheader">Jml R</td>
          <td width="70" class="tblheader">R/Generik</td>
          <td width="40" class="tblheader"> % </td>
          <td width="70" class="tblheader">R/Form</td>
          <td width="40" class="tblheader">%</td>
          <td width="70" class="tblheader">R/Non Form</td>
          <td width="40" class="tblheader"> % </td>
          <td width="40" class="tblheader">R/Alkes</td>
          <td width="40" class="tblheader">%</td>
        </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['DOKTER']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['JML_RESEP']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['JML_R']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['GENERIK'];?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_GEN'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['FORMULARIUM']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_FORM'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['NONFORM']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_NONFORM'],2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $rows['ALKES']; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PR_ALKES'],2,",",".");?></td>
        </tr>
        <?php 
	  	}
	  	?>
        <tr class="txtinput"> 
          <td colspan="2" align="right" class="tdisikiri">Sub Total&nbsp;</td>
          <td align="right" class="tdisi"><?php echo $Tot_JML_RESEP;?></td>
          <td align="right" class="tdisi"><?php echo $Tot_JML_R;?></td>
          <td align="right" class="tdisi"><?php echo $Tot_GENERIK;?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_GEN,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_FORMULARIUM; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_FORM,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_NONFORM; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_NONFORM,2,",",".");?></td>
          <td align="right" class="tdisi"><?php echo $Tot_ALKES; ?></td>
          <td align="center" class="tdisi"><?php echo number_format($Tot_PR_ALKES,2,",",".");?></td>
        </tr>
      </table>
	  </div>
</form>
</div>
</body>
<script>
var req;

GetId = function(id){
   if (document.getElementById)
      return document.getElementById(id);
   else if (document.all)
      return document.all[id];
}

function UpdtList(obj,vMethod,vUrl){
	req = new newRequest(1);

  if (req.xmlhttp) {
    req.available = 0;
    req.xmlhttp.open(vMethod , vUrl, true);
	req.xmlhttp.onreadystatechange = function() {
	  if (typeof(req) != 'undefined' && 
		req.available == 0 && 
		req.xmlhttp.readyState == 4) {
		  if (req.xmlhttp.status == 200 || req.xmlhttp.status == 304) {
		  		//alert(req.xmlhttp.responseText);
				GetId(obj).innerHTML = req.xmlhttp.responseText;
		  } else {
				req.xmlhttp.abort();
		  }
		  req.available = 1;
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
</script>
</html>
<?php 
mysqli_close($konek);
?>
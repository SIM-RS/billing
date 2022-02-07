<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=date('d-m-Y');
$tgl_d=$_REQUEST['tgl_d'];
if ($tgl_d=="")	$tgl_d=$tgl;
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
if ($tgl_s=="")	$tgl_s=$tgl;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan emperkenalkan untuk melakukan ACT===
$idunit1=$_REQUEST['idunit'];
if ($idunit1=="") $idunit1=$idunit;
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ake.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
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
function PrintArea(fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
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
      <p><span class="jdltable">LAPORAN MUTASI OBAT</span></p>
		<table>
		<tr>
			
          <td align="center"><span class="txtinput">Unit : </span> 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/rpt_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+this.value">
              <?
		  $qry="select * from a_unit where (UNIT_TIPE<>3 AND UNIT_TIPE<>4) and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']) echo "selected";?>> <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select>
          </td>
		</tr>
	  	<tr>
			<td>
				<input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input>
        		<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/>
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input>
        		<input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/>
			<button type="button" onClick="location='?f=../transaksi/rpt_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>
			</td>
		</tr>
	  </table>	  
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" rowspan="2" class="tblheaderkiri">No</td>
          <td rowspan="2" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td width="80" rowspan="2" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td height="25" colspan="2" class="tblheader">Saldo 
            Awal </td>
          <td colspan="4" class="tblheader">Masuk 
          </td>
          <td colspan="5" class="tblheader">Keluar</td>
          <td width="40" rowspan="2" class="tblheader">Adj</td>
          <td colspan="2" class="tblheader">Saldo 
            Akhir </td>
        </tr>
        <tr class="headtable"> 
          <td width="40" height="25" class="tblheader">Qty</td>
          <td width="80" class="tblheader">Nilai</td>
          <td width="40" class="tblheader"><?php if ($idunit1==17) echo "Prod"; else echo "Pbf";?></td>
          <td width="40" class="tblheader">Unit</td>
          <td width="40" class="tblheader">Milik</td>
          <td width="40" class="tblheader">Ret</td>
          <td width="40" class="tblheader"><?php if ($idunit1==17) echo "Prod"; else echo "Rsp";?></td>
          <td width="40" class="tblheader">Unit</td>
          <td width="40" class="tblheader">Ret</td>
          <td width="40" class="tblheader">Milik</td>
          <td width="40" class="tblheader">Hapus</td>
          <td width="40" class="tblheader">Qty</td>
          <td width="80" class="tblheader">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
//	  $sql="SELECT DISTINCT ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID WHERE ak.UNIT_ID=$idunit1 AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'".$filter." ORDER BY ".$sorting;
	  $sql="SELECT DISTINCT ak.OBAT_ID,ak.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA FROM a_kartustok ak INNER JOIN a_obat ao ON ak.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ake ON ak.KEPEMILIKAN_ID=ake.ID WHERE ak.UNIT_ID=$idunit1".$filter." ORDER BY ".$sorting;
/*	  $sql="SELECT DISTINCT ao.OBAT_ID,ap.KEPEMILIKAN_ID,ao.OBAT_NAMA,ake.NAMA 
			FROM a_penerimaan ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID 
			INNER JOIN a_kepemilikan ake ON ap.KEPEMILIKAN_ID=ake.ID
			WHERE ap.UNIT_ID_TERIMA=4 AND ap.QTY_STOK>0 AND ap.STATUS=1
			ORDER BY ao.OBAT_NAMA,ap.KEPEMILIKAN_ID";
*/
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $tsaldo_awal=0;
	  $tsaldo_akhir=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cidobat=$rows['OBAT_ID'];		
		$cidkp=$rows['KEPEMILIKAN_ID'];
		$qty_awal=0;
		$saldo_awal=0;
		$pbf=0;
		$unit_in=0;
		$milik_in=0;
		$rt_rsp=0;
		$rsp=0;
		$unit_out=0;
		$rt=0;
		$milik_out=0;
		$hapus=0;
		$adj=0;
		$qty_akhir=0;
		$saldo_akhir=0;
		$sql="SELECT ID,STOK_AFTER FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND TGL_TRANS<'$tgl_d1' order by ID desc limit 1";
		$rs1=mysqli_query($konek,$sql);
		$cidks=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$cidks=$rows1['ID'];
			//$qty_awal=$rows1['STOK_AFTER'];
		}	
		$sql="SELECT IF (SUM(qty_stok) IS NULL,0,SUM(qty_stok)) AS qty_awal,IF (SUM(qty_stok*harga_beli) IS NULL,0,SUM(FLOOR(qty_stok*harga_beli))) AS saldo_awal FROM a_kartustok_detail WHERE fk_kartu_stok=$cidks";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)){
			$saldo_awal=$rows1['saldo_awal'];
			$qty_awal=$rows1['qty_awal'];
		}
/*		if ($idunit1==17)
			$sql="SELECT IF (SUM(DEBET) IS NULL,0,SUM(DEBET)) AS pbf FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=4 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		else
			$sql="SELECT IF (SUM(DEBET) IS NULL,0,SUM(DEBET)) AS pbf FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=0 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $pbf=$rows1['pbf'];	
		$sql="SELECT IF (SUM(ak.DEBET) IS NULL,0,SUM(ak.DEBET)) AS unit_in 
			FROM a_kartustok ak INNER JOIN a_penerimaan ap ON ak.fkid=ap.ID
			WHERE ak.UNIT_ID=$idunit1 AND ak.OBAT_ID=$cidobat AND ak.KEPEMILIKAN_ID=$cidkp AND (ak.tipetrans=1 OR ak.tipetrans=2 OR ak.tipetrans=3) 
			AND ak.DEBET>0 AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' AND ap.UNIT_ID_KIRIM<>$idunit1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $unit_in=$rows1['unit_in'];	
		$sql="SELECT IF (SUM(ak.DEBET) IS NULL,0,SUM(ak.DEBET)) AS milik_in 
			FROM a_kartustok ak INNER JOIN a_penerimaan ap ON ak.fkid=ap.ID
			WHERE ak.UNIT_ID=$idunit1 AND ak.OBAT_ID=$cidobat AND ak.KEPEMILIKAN_ID=$cidkp AND (ak.tipetrans=2 OR ak.tipetrans=3) 
			AND ak.DEBET>0 AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' AND ap.UNIT_ID_KIRIM=$idunit1 AND ap.UNIT_ID_TERIMA=$idunit1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $milik_in=$rows1['milik_in'];
		$sql="SELECT IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT * -1)) AS rt_rsp FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND (tipetrans=6 OR tipetrans=7) AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $rt_rsp=$rows1['rt_rsp'];
		if ($idunit1==17)
			$sql="SELECT IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)) AS rsp FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=4 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		else	
			$sql="SELECT IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)) AS rsp FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=8 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $rsp=$rows1['rsp'];	
		$sql="SELECT IF (SUM(ak.KREDIT) IS NULL,0,SUM(ak.KREDIT)) AS unit_out 
			FROM a_kartustok ak INNER JOIN a_penerimaan ap ON ak.fkid=ap.ID
			WHERE ak.UNIT_ID=$idunit1 AND ak.OBAT_ID=$cidobat AND ak.KEPEMILIKAN_ID=$cidkp AND (ak.tipetrans=1 OR ak.tipetrans=2 OR ak.tipetrans=3) 
			AND ak.KREDIT>0 AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' AND ap.UNIT_ID_KIRIM=$idunit1 AND ap.UNIT_ID_TERIMA<>$idunit1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $unit_out=$rows1['unit_out'];	
		$sql="SELECT IF (SUM(DEBET) IS NULL,0,SUM(DEBET * -1)) AS rt FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=9 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $rt=$rows1['rt'];	
		$sql="SELECT IF (SUM(ak.KREDIT) IS NULL,0,SUM(ak.KREDIT)) AS milik_out 
			FROM a_kartustok ak INNER JOIN a_penerimaan ap ON ak.fkid=ap.ID
			WHERE ak.UNIT_ID=$idunit1 AND ak.OBAT_ID=$cidobat AND ak.KEPEMILIKAN_ID=$cidkp AND (ak.tipetrans=2 OR ak.tipetrans=3) 
			AND ak.KREDIT>0 AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' AND ap.UNIT_ID_KIRIM=$idunit1 AND ap.UNIT_ID_TERIMA=$idunit1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $milik_out=$rows1['milik_out'];	
		$sql="SELECT IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)) AS hapus FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=10 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $hapus=$rows1['hapus'];
		$sql="SELECT (t1.DEBET-t1.KREDIT) AS adj FROM (SELECT IF (SUM(DEBET) IS NULL,0,SUM(DEBET)) AS DEBET,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)) AS KREDIT FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND tipetrans=5 AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1') AS t1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $adj=$rows1['adj'];

		$sql="SELECT IF (UNIT_ID=17,IF (tipetrans=4,IF (SUM(DEBET) IS NULL,0,SUM(DEBET)),0),IF (tipetrans=0,IF (SUM(DEBET) IS NULL,0,SUM(DEBET)),0)) AS pbf, 
			IF (tipetrans=1,IF (SUM(DEBET) IS NULL,0,SUM(DEBET)),0) AS unit_in, 
			IF (tipetrans=2,IF (SUM(DEBET) IS NULL,0,SUM(DEBET)),0) AS milik_in,
			IF (tipetrans=6,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT * -1)),0) AS rt_rsp,
			IF (UNIT_ID=17,IF (tipetrans=4,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)),0),IF (tipetrans=8,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)),0)) AS rsp,
			IF (tipetrans=1,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)),0) AS unit_out,
			IF (tipetrans=9,IF (SUM(DEBET) IS NULL,0,SUM(DEBET * -1)),0) AS rt,
			IF (tipetrans=2,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)),0) AS milik_out,
			IF (tipetrans=10,IF (SUM(KREDIT) IS NULL,0,SUM(KREDIT)),0) AS hapus,
			IF (tipetrans=5,IF (SUM(DEBET-KREDIT) IS NULL,0,SUM(DEBET-KREDIT)),0) AS adj
			FROM a_kartustok 
			WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp 
			AND TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1'";
*/
		$sql="SELECT SUM(IF (ak.UNIT_ID=17,IF (ak.tipetrans=4,IF (ak.DEBET IS NULL,0,ak.DEBET),0),IF (ak.tipetrans=0,IF (ak.DEBET IS NULL,0,ak.DEBET),0))) AS pbf, 
			SUM(IF (((ak.tipetrans=1 OR ak.tipetrans=2) AND (ap.UNIT_ID_KIRIM<>$idunit1)),IF (ak.DEBET IS NULL,0,ak.DEBET),0)) AS unit_in, 
			SUM(IF ((ak.tipetrans=2 AND ap.UNIT_ID_KIRIM=$idunit1),IF (ak.DEBET IS NULL,0,ak.DEBET),0)) AS milik_in,
			SUM(IF (ak.tipetrans=6,IF (ak.KREDIT IS NULL,0,ak.KREDIT * -1),0)) AS rt_rsp,
			SUM(IF (ak.UNIT_ID=17,IF (ak.tipetrans=4,IF (ak.KREDIT IS NULL,0,ak.KREDIT),0),IF (ak.tipetrans=8,IF (ak.KREDIT IS NULL,0,ak.KREDIT),0))) AS rsp,
			SUM(IF (ak.tipetrans=1,IF (ak.KREDIT IS NULL,0,ak.KREDIT),0)) AS unit_out,
			SUM(IF (ak.tipetrans=9,IF (ak.DEBET IS NULL,0,ak.DEBET * -1),0)) AS rt,
			SUM(IF (ak.tipetrans=2,IF (ak.KREDIT IS NULL,0,ak.KREDIT),0)) AS milik_out,
			SUM(IF (ak.tipetrans=10,IF (ak.KREDIT IS NULL,0,ak.KREDIT),0)) AS hapus,
			SUM(IF (ak.tipetrans=5,IF (ak.DEBET-ak.KREDIT IS NULL,0,ak.DEBET-ak.KREDIT),0)) AS adj
			FROM a_kartustok ak INNER JOIN a_penerimaan ap ON ak.fkid=ap.ID 
			WHERE ak.UNIT_ID=$idunit1 AND ak.OBAT_ID=$cidobat AND ak.KEPEMILIKAN_ID=$cidkp 
			AND ak.TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' 
			GROUP BY ak.OBAT_ID,ak.KEPEMILIKAN_ID";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)){
			$pbf=$rows1['pbf'];
			$unit_in=$rows1['unit_in'];
			$milik_in=$rows1['milik_in'];
			$rt_rsp=$rows1['rt_rsp'];
			$rsp=$rows1['rsp'];
			$unit_out=$rows1['unit_out'];
			$rt=$rows1['rt'];
			$milik_out=$rows1['milik_out'];
			$hapus=$rows1['hapus'];
			$adj=$rows1['adj'];
		}	
		//$qty_akhir=$qty_awal+$pbf+$unit_in+$milik_in+$rt_rsp-$rsp-$unit_out-$rt-$milik_out-$hapus+$adj;
		$sql="SELECT ID FROM a_kartustok WHERE UNIT_ID=$idunit1 AND OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND TGL_TRANS<='$tgl_s1' order by ID desc limit 1";
		$rs1=mysqli_query($konek,$sql);
		$cidks=0;
		if ($rows1=mysqli_fetch_array($rs1)){
			$cidks=$rows1['ID'];
		}	
		$sql="SELECT IF (SUM(qty_stok) IS NULL,0,SUM(qty_stok)) AS qty_akhir,IF (SUM(qty_stok*harga_beli) IS NULL,0,SUM(qty_stok*harga_beli)) AS saldo_akhir FROM a_kartustok_detail WHERE fk_kartu_stok=$cidks";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)){
			$qty_akhir=$rows1['qty_akhir'];
			$saldo_akhir=$rows1['saldo_akhir'];
		}
		$tsaldo_awal=$tsaldo_awal+$saldo_awal;
		$tsaldo_akhir=$tsaldo_akhir+$saldo_akhir;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $qty_awal; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($saldo_awal,0,",",".");?></td>
          <td class="tdisi"><?php echo $pbf; ?></td>
          <td class="tdisi"><?php echo $unit_in; ?></td>
          <td class="tdisi"><?php echo $milik_in; ?></td>
          <td class="tdisi"><?php echo $rt_rsp; ?></td>
          <td class="tdisi"><?php echo $rsp; ?></td>
          <td class="tdisi"><?php echo $unit_out; ?></td>
          <td class="tdisi"><?php echo $rt; ?></td>
          <td class="tdisi"><?php echo $milik_out; ?></td>
          <td class="tdisi"><?php echo $hapus; ?></td>
          <td class="tdisi"><?php echo $adj;?></td>
          <td class="tdisi"><?php echo $qty_akhir; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($saldo_akhir,0,",",".");?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  	<tr class="txtinput">
          <td colspan="4" align="right">Total Saldo Awal&nbsp;</td>
          <td align="right"><?php echo number_format($tsaldo_awal,0,",",".");?></td>
		  <td colspan="11" align="right">Total Saldo Akhir&nbsp;</td>
		  <td align="right"><?php echo number_format($tsaldo_akhir,0,",",".");?></td>
		</tr>
        <tr> 
          <td align="left" colspan="13"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="17" align="center"> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick='PrintArea("../transaksi/rpt_mutasi_print.php?idunit=<?php echo $idunit1; ?>&username=<?php echo $username; ?>&tgl_d=<?php echo $tgl_d; ?>&tgl_s=<?php echo $tgl_s; ?>&sorting=<?php echo $sorting; ?>&filter=<?php echo $filter; ?>");'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Mutasi Obat</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
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
<?php 
mysqli_close($konek);
?>
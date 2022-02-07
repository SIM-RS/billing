<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
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
if (($unit_tipe==2)||($unit_tipe==5)){
	if ($idunit1=="") $idunit1=$_SESSION["ses_idunit"];
}
convert_var($tgl_d1,$tgl_s1,$tgl2,$idunit1);
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$stok=$_REQUEST['stok'];
$stok1=$_REQUEST['stok1'];
$ket=$_REQUEST['ket'];
convert_var($$obat_id,$kepemilikan_id,$stok,$stok1,$ket);
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
convert_var($kelas,$golongan,$jenis);
if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
convert_var($fkelas,$fgolongan,$fjenis);

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
convert_var($page,$sorting,$filter,$act);
switch ($act){
	case "save":
		$sql="select OBAT_ID from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id limit 1";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			echo "<script>alert('Obat Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
			$rs=mysqli_query($konek,$sql);
			$hargab=0;
			$hargaj==0;
			if ($rows1=mysqli_fetch_array($rs)){
				$hargab=$rows1["HARGA_BELI_SATUAN"];
				$hargaj=$rows1["HARGA_JUAL_SATUAN"];
			}
			$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,HARGA_JUAL,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,now(),'$tgl2',$stok,$stok,$hargab,$hargaj,5,1)";
			//echo $sql;
			$rs=mysqli_query($konek,$sql);
		}
		break;
	case "edit":
		if ($stok1>$stok){
			$selisih=$stok1-$stok;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$ok="false";
			while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
				$qty=$rows["QTY_STOK"];
				$cid=$rows["ID"];
				if ($qty>$selisih){
					$ok=="true";
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);					
				}else{
					$selisih=$selisih-$qty;
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);										
				}
			}
		}else{
			$selisih=$stok-$stok1;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID desc limit 1";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$cid=$rows["ID"];
				$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);					
			}
		}
		break;
/* 	case "delete":
		$sql="delete from a_harga where HARGA_ID=$harga_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break; */
}
//Aksi Save, Edit, Delete Berakhir ============================================
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
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
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
      <p><span class="jdltable">LAPORAN PEMAKAIAN OBAT / ALKES</span></p>
		
      <table>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/jual_view_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <?
		  $qry="select * from a_unit where (UNIT_TIPE=2 or UNIT_TIPE=5) and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit1=="")&&($i==1)) $idunit1=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit1==$show['UNIT_ID']) {echo "selected";$nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Kelas </td>
          <td align="center" class="txtinput">: 
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../transaksi/jual_view_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput"<?php if ($kelas=="") echo " selected";?>>SEMUA</option>
              <?
			  $k1="SEMUA";
		  $qry="SELECT * FROM a_kelas ORDER BY KLS_KODE";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  	$lvl=$show["KLS_LEVEL"];
			$tmp="";
			for ($i=1;$i<$lvl;$i++) $tmp .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$tmp .=$show['KLS_NAMA'];
		  ?>
              <option value="<?=$show['KLS_KODE'];?>" class="txtinput"<?php if ($kelas==$show['KLS_KODE']){echo " selected";$k1=$show['KLS_NAMA'];}?>><?php echo $tmp;?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: 
            <select name="golongan" id="golongan" class="txtinput" onChange="location='?f=../transaksi/jual_view_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput"<?php if ($golongan==""){echo " selected";$g1="SEMUA";}?>>SEMUA</option>
              <option value="N" class="txtinput"<?php if ($golongan=="N"){echo " selected";$g1="Narkotika";}?>>Narkotika</option>
              <option value="P" class="txtinput"<?php if ($golongan=="P"){echo " selected";$g1="Pethidine";}?>>Pethidine</option>
              <option value="M" class="txtinput"<?php if ($golongan=="M"){echo " selected";$g1="Morphine";}?>>Morphine</option>
              <option value="Psi" class="txtinput"<?php if ($golongan=="Psi"){echo " selected";$g1="Psikotropika";}?>>Psikotropika</option>
              <option value="B" class="txtinput"<?php if ($golongan=="B"){echo " selected";$g1="Obat Bebas";}?>>Obat 
              Bebas</option>
              <option value="BT" class="txtinput"<?php if ($golongan=="BT"){echo " selected";$g1="Bebas Terbatas";}?>>Bebas 
              Terbatas</option>
              <option value="K" class="txtinput"<?php if ($golongan=="K"){echo " selected";$g1="Obat Keras";}?>>Obat 
              Keras</option>
              <option value="AK" class="txtinput"<?php if ($golongan=="AK"){echo " selected";$g1="Alkes";}?>>Alkes</option>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Jenis</td>
          <td align="center" class="txtinput">: 
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../transaksi/jual_view_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value">
              <option value="" class="txtinput">SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_jenis";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['obat_jenis_id']; ?>" class="txtinput"<?php if ($jenis==$rows['obat_jenis_id']){echo " selected";$j1=$rows['obat_jenis'];}?>><?php echo $rows['obat_jenis']; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td colspan="2"> <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);"/> 
            &nbsp;s/d 
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s; ?>" /></input> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);"/> 
            <button type="button" onClick="location='?f=../transaksi/jual_view_qty.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value"> 
            <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; 
            Lihat</button></td>
        </tr>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="32" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="101" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td width="570" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="91" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY" width="51" class="tblheader" onClick="">Qty</td>
          <td id="QTY" width="57" class="tblheader" onClick="">Harga Satuan</td>
          <td id="nilai" width="95" class="tblheader" onClick="">Nilai</td>
		  <td id="sisa_stok" width="61" class="tblheader" onClick="">Sisa Stok</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,t1.*,
	   (SELECT STOK_AFTER FROM a_kartustok WHERE `TGL_TRANS` BETWEEN'$tgl_d1' AND '$tgl_s1' AND UNIT_ID = $idunit1 AND OBAT_ID=t1.OBAT_ID ORDER BY ID DESC LIMIT 1 ) stok_sisa
	   FROM a_obat ao INNER JOIN 
		(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
		SUM(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) AS `QTY`,
		SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL`, a_penjualan.HARGA_SATUAN 
		FROM (`a_penerimaan` INNER JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
		WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`) AND (a_penjualan.UNIT_ID=$idunit1)) 
		GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
		INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$filter.$fkelas.$fgolongan.$fjenis." ORDER BY ".$sorting;
	// echo $sql;
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['QTY'];?></td>
          <td class="tdisi"><?php echo number_format($rows['HARGA_SATUAN'],0,",",".");?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['TOTAL'],0,",",".");?></td>
		  <td class="tdisi" align="center"><?php echo number_format($rows['stok_sisa'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  $ntotal=0;
/*	  $sql2="SELECT IF(SUM(t1.TOTAL) IS NULL,0,SUM(t1.TOTAL)) AS total FROM a_obat ao INNER JOIN 
		(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
		SUM(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) AS `QTY`,
		SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
		FROM (`a_penerimaan` JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
		WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`) AND (a_penjualan.UNIT_ID=$idunit1)) 
		GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
		INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$filter;*/
	  $sql2="SELECT IF (SUM(p2.TOTAL) IS NULL,0,SUM(p2.TOTAL)) AS total FROM (".$sql.") as p2";
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['total'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="6" align="right" class="txtright">Nilai Total : </td>
          <td align="right" class="txtright"><?php echo number_format($ntotal,0,",","."); ?></td>
        </tr>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="7" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="7" align="center"> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick='PrintArea("idArea","#");'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
            Pemakaian Obat</BUTTON>&nbsp;<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../transaksi/jual_view_qty_Excell.php?tgl_d1=<?php echo $tgl_d1; ?>&tgl_s1=<?php echo $tgl_s1; ?>&filter='+filter.value+'&sorting=<?php echo $sorting; ?>&idunit1=<?php echo $idunit1; ?>&nunit1=<?php echo $nunit1; ?>&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&k1=<?php echo $k1; ?>&g1=<?php echo $g1; ?>&j1=<?php echo $j1; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">LAPORAN PEMAKAIAN OBAT / ALKES</span></p> 
		
      <table width="431" align="center">
        <tr> 
          <td align="center" colspan="2">Unit : 
            <?
		  $qry="select * from a_unit where UNIT_ID=$idunit1";
		  $exe=mysqli_query($konek,$qry);
		  $show=mysqli_fetch_array($exe); 
		 echo $show['UNIT_NAME'];
		  ?>
          </td>
        </tr>
        <tr> 
          <td align="center" colspan="2">Kelas : <?php echo $k1; ?></td>
        </tr>
        <tr> 
          <td align="center" colspan="2">Glongan : <?php echo $g1; ?></td>
        </tr>
        <tr>
          <td align="center" colspan="2">Jenis : <?php echo $j1; ?></td>
        </tr>
        <tr> 
          <td colspan="2" align="center">(<?php echo $tgl_d; ?>&nbsp;s/d&nbsp;<?php echo $tgl_s; ?>)</td>
        </tr>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_STOK" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['QTY'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['TOTAL'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	  <tr>
	  	<td colspan="5" align="right" class="txtright">Nilai Total : </td>
	  	<td align="right" class="txtright"><?php echo number_format($ntotal,0,",","."); ?></td>
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
<?php
session_start();
include("../sesi.php");
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include '../koneksi/konek.php';
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$unit_tujuan=$_REQUEST['unit_tujuan'];
$no_kirim=$_REQUEST['no_kirim'];
$i_kirim=$_REQUEST['i_kirim'];if ($i_kirim=="") $i_kirim=$no_kirim;
$tgl_kirim=$_REQUEST['tgl_kirim'];
$tgl_kirim1=$tgl_kirim;
if ($tgl_kirim1!=""){
	$tgl_kirim1=explode("-",$tgl_kirim1);
	$tgl_kirim1=$tgl_kirim1[2]."-".$tgl_kirim1[1]."-".$tgl_kirim1[0];
}
$isview=$_REQUEST['isview'];
$kodeunit = $_REQUEST['kodeunit'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.NOKIRIM desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		$fdata=$_REQUEST['fdata'];
		$arfvalue=explode("**",$fdata);
		for ($j=0;$j<count($arfvalue);$j++){
			$arfdata=explode("|",$arfvalue[$j]);
			//$sql="update a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1 where NOKIRIM='$no_gdg' and FK_MINTA_ID=$arfdata[2] and UNIT_ID_TERIMA=$idunit";
			$sql="call $dbapotek.gd_mutasi($idunit,$unit_tujuan,0,'$no_kirim',$arfdata[0],$arfdata[1],$arfdata[2],$arfdata[5],3,$iduser,0,'$tgl_kirim1','$tgl_act')";
			$rs=mysql_query($sql);
			$sql="call $dbapotek.pinjam_kembali($idunit,$unit_tujuan,$arfdata[0],$arfdata[1],$arfdata[2],$arfdata[5])";
			$rs=mysql_query($sql);
		}
	break;
 	case "delete":
		$sql="delete from $dbapotek.a_minta_obat where peminjaman_id=$minta_id";
		$rs=mysql_query($sql);
		//echo $sql;
	break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($isview==""){
	$sql="select NOKIRIM from $dbapotek.a_penerimaan where UNIT_ID_KIRIM=$idunit and NOKIRIM like '$kodeunit/PK/$th[2]-$th[1]/%' order by right(NOKIRIM,4) desc limit 1";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	if ($rows=mysql_fetch_array($rs)){
		$no_kirim2=$rows["NOKIRIM"];
		$arno_kirim=explode("/",$no_kirim2);
		$tmp=$arno_kirim[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_kirim2="$kodeunit/PK/$th[2]-$th[1]/$ctmp";
	}else{
		$no_kirim2="$kodeunit/PK/$th[2]-$th[1]/0001";
	}
}
$sql="select distinct au.UNIT_NAME,ap.NOKIRIM,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1 from $dbapotek.a_penerimaan ap inner join $dbapotek.a_unit au on ap.UNIT_ID_TERIMA=au.UNIT_ID where ap.NOKIRIM='$i_kirim'";
$rs=mysql_query($sql);
if ($rows=mysql_fetch_array($rs)){
	$iunit=$rows['UNIT_NAME'];
	$no_kirim=$rows['NOKIRIM'];
	$tgl_kirim=$rows['tgl1'];
}
?>
<html>
<head>
<title><?=ucwords(strtolower('MENGEMBALIKAN OBAT YANG DIPINJAM'))?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript">var arrRange=depRange=[];</script>
</head>
<body>
<? include("../header1.php"); ?>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30" style="padding-left:5px;">MENGEMBALIKAN OBAT YANG DIPINJAM</td>
	</tr>
</table>	
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">
	<tr>
		<td>
			&nbsp;
			<form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="fdata" id="fdata" type="hidden" value="">
			<input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
			<input name="i_kirim" id="i_kirim" type="hidden" value="<?php echo $i_kirim; ?>">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<? if ($isview==""){ ?>
			<div id="listma" style="display:block">
				<table class="tabel" style="padding-left:25px; padding-bottom:10px;">
					<tr>
						<td>
							<span>No Kirim : </span>
							<input name="no_kirim" type="text" id="no_kirim" size="25" maxlength="30" class="txtcenter" value="<?php echo $no_kirim2; ?>" readonly="true" />
							<span>Tgl Kirim : </span> 
							<input name="tgl_kirim" type="text" id="tgl_kirim" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>" /> 
							<input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_kirim'),depRange);" /> 
							<span>Unit Tujuan : </span> 
							<select class="txtinput" name="unit_tujuan" id="unit_tujuan" onChange="">
								<?
									$qry = "select * from $dbapotek.a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
									$exe = mysql_query($qry);
									$i=0;
									while($show= mysql_fetch_array ($exe)){
										$i++;
										if (($i==1)&&($unit_tujuan=="")) $unit_tujuan=$show['UNIT_ID'];			
									?>
									<option value="<?=$show['UNIT_ID'];?>"<?php if ($unit_tujuan==$show['UNIT_ID']) echo " selected";?>><?=$show['UNIT_NAME'];?></option>
								<? }?>
							</select>
						</td>
					</tr>
				</table>
				<table width="99%" border="0" cellpadding="1" cellspacing="0">					
					<tr class="headtable" style="font-weight:bold;"> 
						<td width="30" height="25" class="tblheaderkiri">No</td>
						<td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Obat</td>
						<td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
						<td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
						<td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
						<td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan Asal </td>
						<td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
						<td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>Blm Kembali</td>
						<td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty Dipinjam</td>
						<td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty Kembali</td>
						<td class="tblheader" width="30">
							<input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"<?php if ($isview=="true") echo " disabled"; ?>>
						</td>
					</tr>
					<?php 
						if ($filter!=""){
							$filter=explode("|",$filter);
							$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
						}
						if ($sorting==""){
							$sql = "select t1.*, ao.OBAT_KODE, ao.OBAT_NAMA, ao.OBAT_SATUAN_KECIL, ak.NAMA, ake.NAMA as NAMA1 
										from (select obat_id, kepemilikan_id, kepemilikan_id_asal, sum(qty_terima-qty_kembali) as qty 
												from $dbapotek.a_pinjam_obat 
												where unit_id=$idunit and unit_tujuan=$unit_tujuan and (qty_kembali < qty_terima) and status=2 
												group by obat_id,kepemilikan_id,kepemilikan_id_asal) as t1 
										inner join $dbapotek.a_obat ao on t1.obat_id=ao.OBAT_ID 
										inner join $dbapotek.a_kepemilikan ak on t1.kepemilikan_id=ak.ID 
										inner join $dbapotek.a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID".$filter;
						}else{
							$sql = "select t1.*, ao.OBAT_KODE, ao.OBAT_NAMA, ao.OBAT_SATUAN_KECIL, ak.NAMA, ake.NAMA as NAMA1 
										from (select obat_id, kepemilikan_id, kepemilikan_id_asal, sum(qty_terima-qty_kembali) as qty 
												from $dbapotek.a_pinjam_obat 
												where unit_id=$idunit and unit_tujuan=$unit_tujuan and (qty_kembali < qty_terima) and status=2 
												group by obat_id,kepemilikan_id,kepemilikan_id_asal) as t1 
									inner join $dbapotek.a_obat ao on t1.obat_id=ao.OBAT_ID 
									inner join $dbapotek.a_kepemilikan ak on t1.kepemilikan_id=ak.ID 
									inner join $dbapotek.a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID".$filter." order by ".$sorting;
						}
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$jmldata=mysql_num_rows($rs);
						if ($page=="" || $page=="0") $page="1";
						$perpage=30;$tpage=($page-1)*$perpage;
						if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
						if ($page>1) $bpage=$page-1; else $bpage=1;
						if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
						$sql=$sql." limit $tpage,$perpage";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$i=($page-1)*$perpage;
						while ($rows=mysql_fetch_array($rs)){
							$i++;
							$cobat_id=$rows['obat_id'];
							$ckp_id=$rows['kepemilikan_id'];
							$ckp_id_asal=$rows['kepemilikan_id_asal'];
							$qty=$rows['qty'];
							$qty_dipinjam=0;
							$qty_stok=0;
							$pm="0";
							$sql = "select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok 
										from $dbapotek.a_penerimaan ap 
									where OBAT_ID=$cobat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$ckp_id and STATUS=1";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							if ($rows1=mysql_fetch_array($rs1)) $qty_stok=$rows1['cstok'];
							$sql = "select sum(qty_terima-qty_kembali) as qty 
										from $dbapotek.a_pinjam_obat 
									where unit_id=$unit_tujuan and unit_tujuan=$idunit and 
										obat_id=$cobat_id and kepemilikan_id=$ckp_id_asal and 
										kepemilikan_id_asal=$ckp_id and 
										(qty_kembali < qty_terima) and status=2 
									group by obat_id,kepemilikan_id,kepemilikan_id_asal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							if ($rows1=mysql_fetch_array($rs1)) $qty_dipinjam=$rows1['qty'];
							if ($qty>$qty_dipinjam){
								$qty_selisih=$qty-$qty_dipinjam;
							}else if ($qty<$qty_dipinjam){
								$qty_selisih="(".($qty_dipinjam-$qty).")";
								$pm="1";
							}else{
								$qty_selisih=$qty-$qty_dipinjam;
								$pm="2";
							}
						?>
						<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
							<td class="tdisikiri"><?php echo $i; ?></td>
							<td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
							<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
							<td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
							<td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
							<td class="tdisi" align="center"><?php echo $rows['NAMA1']; ?></td>
							<td class="tdisi" align="center"><?php echo $qty_stok; ?></td>
							<td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
							<td class="tdisi" align="center"><?php echo $qty_dipinjam; ?></td>
							<td class="tdisi" align="center"><input name="qty_kembali" type="text" class="txtcenter" id="qty_kembali" value="<?php echo $qty_selisih; ?>" size="5" maxlength="5"<?php if (($pm=="1")||($pm=="2")) echo " disabled";?>></td>
							<td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox" value="<?php echo $rows['obat_id'].'|'.$ckp_id.'|'.$ckp_id_asal.'|'.$qty_selisih.'|'.$qty_stok; ?>" style="cursor:pointer"<?php if (($pm=="1")||($pm=="2")) echo " disabled";?>></td>
						</tr>
						<?php 
						}
						mysql_free_result($rs);
					?>
					<tr> 
						<td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
						<?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
						<td colspan="8" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
							<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
							<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
							<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
						</td>
					</tr>
				</table>
				<p align="center">
					<BUTTON type="button" onClick="if (ValidateForm('no_kirim','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Kirim&nbsp;&nbsp;</BUTTON>
					&nbsp;
					<BUTTON type="reset" onClick="location='list_kembali.php';gantiGrid();"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
				</p>
			</div>
			<? }else{ ?>
			<div id="listma" style="display:block">
				<p align="center"><span class="jdltable">DETAIL PENGEMBALIAN OBAT</span></p>
				<table class="tabel" style="padding-left:25px; padding-bottom:10px;">
					<tr>
						<td>No Kirim : <?=$no_kirim?></td>
					</tr>
					<tr>
						<td>Tgl Kirim : <?=$tgl?></td>
					</tr>
					<tr>
						<td>
							Unit Tujuan : <?=$iunit?>
						</td>
					</tr>
				</table>
				<table width="99%" border="0" align="center" cellpadding="1" cellspacing="0">
					<tr class="headtable"> 
						<td width="30" height="25" class="tblheaderkiri">No</td>
						<td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Obat</td>
						<td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
						<td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
						<td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
						<td id="NAMA1" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan Tujuan </td>
						<td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty Kirim</td>
					</tr>
					<?php 
						if ($filter!=""){
							$filter=explode("|",$filter);
							$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
						}
						if ($sorting=="") $sorting=$defaultsort;
							$sql = "SELECT ao.OBAT_KODE, ao.OBAT_NAMA, ao.OBAT_SATUAN_KECIL, t1.NOKIRIM, 
										   t1.OBAT_ID, SUM(t1.QTY_SATUAN) AS qty_kirim, ak.NAMA,ake.NAMA AS NAMA1 
										FROM (SELECT NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN,KEPEMILIKAN_ID,STATUS 
											FROM $dbapotek.a_penerimaan 
											WHERE NOKIRIM='$no_kirim' 
											GROUP BY NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID,STATUS) AS t1 
									INNER JOIN $dbapotek.a_penerimaan ap ON t1.ID_LAMA=ap.ID 
									INNER JOIN $dbapotek.a_obat ao ON t1.OBAT_ID=ao.OBAT_ID 
									INNER JOIN $dbapotek.a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID 
									INNER JOIN $dbapotek.a_kepemilikan ake ON ap.KEPEMILIKAN_ID=ake.ID".$filter." 
									GROUP BY OBAT_ID,ak.NAMA,ake.NAMA
									ORDER BY ".$sorting;
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$jmldata=mysql_num_rows($rs);
						if ($page=="" || $page=="0") $page="1";
						$perpage=50;$tpage=($page-1)*$perpage;
						if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
						if ($page>1) $bpage=$page-1; else $bpage=1;
						if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
						$sql=$sql." limit $tpage,$perpage";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$i=($page-1)*$perpage;
						while ($rows=mysql_fetch_array($rs)){
							$i++;
						?>
					<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
						<td class="tdisikiri"><?php echo $i; ?></td>
						<td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
						<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
						<td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
						<td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
						<td class="tdisi" align="center"><?php echo $rows['NAMA1']; ?></td>
						<td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
					</tr>
					<?php 
						}
						mysql_free_result($rs);
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
				<p align="center">
					<a class="navText" href='#' onclick='PrintArea("listma","#")'>
					
					<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
					Pengembalian&nbsp;&nbsp;</BUTTON>
					</a>
					&nbsp;<BUTTON type="button" onClick="location='list_kembali.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
				</p>
			<? } ?>
			</form>
		</td>
	</tr>
	<tr>
		<td height="100">&nbsp;</td>
	</tr>
</table>
</div>
</body>
</htmlcode>
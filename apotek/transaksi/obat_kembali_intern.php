<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$unit_tujuan=$idunit;
$no_kirim=$_REQUEST['no_kirim'];
$i_kirim=$_REQUEST['i_kirim'];if ($i_kirim=="") $i_kirim=$no_kirim;
$tgl_kirim=$_REQUEST['tgl_kirim'];
$tgl_kirim1=$tgl_kirim;
if ($tgl_kirim1!=""){
	$tgl_kirim1=explode("-",$tgl_kirim1);
	$tgl_kirim1=$tgl_kirim1[2]."-".$tgl_kirim1[1]."-".$tgl_kirim1[0];
}
$isview=$_REQUEST['isview'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="NOKIRIM";
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
			$sql="call gd_mutasi($idunit,$unit_tujuan,0,'$no_kirim',$arfdata[0],$arfdata[1],$arfdata[2],$arfdata[5],3,$iduser,0,'$tgl_kirim1','$tgl_act')";
			$rs=mysqli_query($konek,$sql);
			$sql="call pinjam_kembali($idunit,$unit_tujuan,$arfdata[0],$arfdata[1],$arfdata[2],$arfdata[5])";
			$rs=mysqli_query($konek,$sql);
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($isview==""){
	$sql="select NOKIRIM from a_penerimaan where UNIT_ID_KIRIM=$idunit and NOKIRIM like '$kodeunit/PK/$th[2]-$th[1]/%' order by right(NOKIRIM,4) desc limit 1";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
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

$sql="select distinct au.UNIT_NAME,ap.NOKIRIM,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1 from a_penerimaan ap inner join a_unit au on ap.UNIT_ID_TERIMA=au.UNIT_ID where ap.NOKIRIM='$i_kirim'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$iunit=$rows['UNIT_NAME'];
	$no_kirim=$rows['NOKIRIM'];
	$tgl_kirim=$rows['tgl1'];
}
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
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<?php if ($act=="save"){?>
<div align="center">
    <div id="listma" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
    <p align="center"><span class="jdltable">MENGEMBALIKAN OBAT YANG DIPINJAM</span></p>
	  
    <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr> 
        <td width="97">No Kirim</td>
        <td width="868">: <?php echo $no_kirim; ?></td>
      </tr>
      <tr> 
        <td width="97">Tgl Kirim</td>
        <td>: <?php echo $tgl_kirim; ?></td>
      </tr>
      <tr> 
        <td>Unit Tujuan</td>
        <td>: <?php echo $iunit; ?></td>
      </tr>
    </table>
      
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="80" class="tblheader">Kode 
          Obat</td>
        <td id="OBAT_NAMA" class="tblheader">Nama 
          Obat</td>
        <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader">Satuan</td>
        <td id="NAMA" width="80" class="tblheader">Kepemilikan</td>
        <td id="NAMA" width="80" class="tblheader">Kepemilikan 
          Tujuan </td>
        <td id="qty_terima" width="40" class="tblheader"> 
          Qty Kirim</td>
      </tr>
      <?php 
	  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.*,ak.NAMA,ake.NAMA as NAMA1 from (select ID_LAMA,OBAT_ID,sum(QTY_SATUAN) as qty_kirim,KEPEMILIKAN_ID,STATUS from a_penerimaan where NOKIRIM='$no_kirim' group by ID_LAMA,OBAT_ID,KEPEMILIKAN_ID,STATUS) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on ap.KEPEMILIKAN_ID=ake.ID";
	  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.NOKIRIM,t1.OBAT_ID,SUM(t1.QTY_SATUAN) AS qty_kirim,ak.NAMA,ake.NAMA AS NAMA1 
			FROM (SELECT NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN,KEPEMILIKAN_ID,STATUS 
			FROM a_penerimaan WHERE NOKIRIM='$no_kirim' GROUP BY NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID,STATUS) AS t1 
			INNER JOIN a_penerimaan ap ON t1.ID_LAMA=ap.ID INNER JOIN a_obat ao ON t1.OBAT_ID=ao.OBAT_ID 
			INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID INNER JOIN a_kepemilikan ake ON ap.KEPEMILIKAN_ID=ake.ID".$filter." GROUP BY OBAT_ID,ak.NAMA,ake.NAMA";
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
/*
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
*/
		$i=0;
	  while ($rows=mysqli_fetch_array($rs)){
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
	  mysqli_free_result($rs);
	  ?>
    </table>
    </div>
  <p align="center">Pengembalian Obat Ke Unit : <?php echo $iunit; ?> Sudah Dikirim</p>
	<p align="center">
	<a class="navText" href='#' onclick='PrintArea("listma","#")'>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Pengembalian&nbsp;&nbsp;</BUTTON>
	</a>&nbsp;<BUTTON type="button" onClick="location='?f=../transaksi/list_kembali_intern.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar Pengembalian&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</p>
</div>
<?php }else{?>
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
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
	<input name="i_kirim" id="i_kirim" type="hidden" value="<?php echo $i_kirim; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<?php if ($isview==""){?>
    <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">MENGEMBALIKAN OBAT YANG DIPINJAM</span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="90">No Kirim</td>
          <td width="875">: 
            <input name="no_kirim" type="text" id="no_kirim" size="25" maxlength="30" class="txtcenter" value="<?php echo $no_kirim2; ?>" readonly="true"></td>
        </tr>
        <tr> 
          <td width="90">Tgl Kirim</td>
          <td>: 
            <input name="tgl_kirim" type="text" id="tgl_kirim" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_kirim,depRange);" /> 
          </td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan 
            Asal </td>
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Blm Kembali</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);"> 
            Qty Dipinjam</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Kembali</td>
          <td class="tblheader" width="30"><input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"<?php if ($isview=="true") echo " disabled"; ?>></td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="")
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,ake.NAMA as NAMA1 from (select obat_id,kepemilikan_id,kepemilikan_id_asal,sum(qty_terima-qty_kembali) as qty from a_pinjam_obat where unit_id=$idunit and unit_tujuan=$idunit and qty_kembali<qty_terima and status=2 group by obat_id,kepemilikan_id,kepemilikan_id_asal) as t1 inner join a_obat ao on t1.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on t1.kepemilikan_id=ak.ID inner join a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID".$filter;
	  else
	  	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,ake.NAMA as NAMA1 from (select obat_id,kepemilikan_id,kepemilikan_id_asal,sum(qty_terima-qty_kembali) as qty from a_pinjam_obat where unit_id=$idunit and unit_tujuan=$idunit and qty_kembali<qty_terima and status=2 group by obat_id,kepemilikan_id,kepemilikan_id_asal) as t1 inner join a_obat ao on t1.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on t1.kepemilikan_id=ak.ID inner join a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID".$filter." order by ".$sorting;
	  	
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$cobat_id=$rows['obat_id'];
		$ckp_id=$rows['kepemilikan_id'];
		$ckp_id_asal=$rows['kepemilikan_id_asal'];
		$qty=$rows['qty'];
		$qty_dipinjam=0;
		$qty_stok=0;
		$pm="0";
		$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok from a_penerimaan ap where OBAT_ID=$cobat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$ckp_id and STATUS=1";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $qty_stok=$rows1['cstok'];
		$sql="select sum(qty_terima-qty_kembali) as qty from a_pinjam_obat where unit_id=$idunit and unit_tujuan=$idunit and obat_id=$cobat_id and kepemilikan_id=$ckp_id_asal and kepemilikan_id_asal=$ckp_id and (qty_kembali < qty_terima) and status=2 group by obat_id,kepemilikan_id,kepemilikan_id_asal";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $qty_dipinjam=$rows1['qty'];
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
          <td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox" value="<?php echo $rows['obat_id'].'|'.$ckp_id.'|'.$ckp_id_asal.'|'.$qty_selisih.'|'.$qty_stok; ?>" style="cursor:pointer"<?php if (($pm=="1")||($pm=="2")||($qty_stok==0)) echo " disabled";?>></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
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
    </div>
		<p align="center">
            
      <BUTTON type="button" onClick="if (ValidateForm('no_kirim','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Kirim&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=../transaksi/list_kembali_intern.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </p>
		<?php }else{?>
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  
      <p align="center"><span class="jdltable">DETAIL PENGEMBALIAN OBAT</span></p>
		  
      <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      
        <tr> 
		 <td width="106">No Kirim</td>
          <td width="183">: <?php echo $no_kirim; ?></td>
          <td width="65">Tgl Kirim</td>
          <td width="639">: <?php echo $tgl_kirim; ?></td>
        </tr>
        <tr>
          <td>Unit Tujuan</td>
          <td>: <?php echo $iunit; ?></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="NAMA1" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan 
            Tujuan </td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);"> 
            Qty Kirim</td>
        </tr>
        <?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.*,ak.NAMA,ake.NAMA as NAMA1 from (select NOKIRIM,ID_LAMA,OBAT_ID,sum(QTY_SATUAN) as qty_kirim,KEPEMILIKAN_ID,STATUS from a_penerimaan where NOKIRIM='$no_kirim' group by NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID,STATUS) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on ap.KEPEMILIKAN_ID=ake.ID".$filter." order by ".$sorting;
		  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.NOKIRIM,t1.OBAT_ID,SUM(t1.QTY_SATUAN) AS qty_kirim,ak.NAMA,ake.NAMA AS NAMA1 
				FROM (SELECT NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN,KEPEMILIKAN_ID,STATUS 
				FROM a_penerimaan WHERE NOKIRIM='$no_kirim' GROUP BY NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID,STATUS) AS t1 
				INNER JOIN a_penerimaan ap ON t1.ID_LAMA=ap.ID INNER JOIN a_obat ao ON t1.OBAT_ID=ao.OBAT_ID 
				INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID INNER JOIN a_kepemilikan ake ON ap.KEPEMILIKAN_ID=ake.ID".$filter." GROUP BY OBAT_ID,ak.NAMA,ake.NAMA
				ORDER BY ".$sorting;
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
		  while ($rows=mysqli_fetch_array($rs)){
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
		  mysqli_free_result($rs);
		  ?>
      </table>
</div>
	  <table width="99%"> 
	    <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
    </tr></table>
		<p align="center">
			<a class="navText" href='#' onclick='PrintArea("listma","#")'>
            
      <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
      Pengembalian&nbsp;&nbsp;</BUTTON>
			</a>
            &nbsp;<BUTTON type="button" onClick="location='?f=../transaksi/list_kembali_intern.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </p>
		<?php }?>
</form>
</div>
<?php 
}
?>
</body>
<script>
function fSubmit(){
var cdata='';
var x;
	if (document.form1.chkitem.length){
		for (var i=0;i<document.form1.chkitem.length;i++){
			if (document.form1.chkitem[i].checked==true){
				x=document.form1.chkitem[i].value.split('|');
				if ((x[3]*1)<(document.form1.qty_kembali[i].value*1)){
					document.form1.qty_kembali[i].focus();
					alert("Qty Kembali Tidak Boleh Lebih Dari Qty Selisih Pinjam !");
					return false;
				}
				if ((x[4]*1)<(document.form1.qty_kembali[i].value*1)){
					document.form1.qty_kembali[i].focus();
					alert("Stok Tidak Cukup Untuk Pengembalian Obat / Alkes !");
					return false;
				}
				cdata +=document.form1.chkitem[i].value+'|'+document.form1.qty_kembali[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.chkitem.checked==false){
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
		x=document.form1.chkitem.value.split('|');
		if ((x[3]*1)<(document.form1.qty_kembali.value*1)){
			document.form1.qty_kembali.focus();
			alert("Qty Kembali Tidak Boleh Lebih Dari Qty Selisih Pinjam !");
			return false;
		}
		if ((x[4]*1)<(document.form1.qty_kembali.value*1)){
			document.form1.qty_kembali.focus();
			alert("Stok Tidak Cukup Untuk Pengembalian Obat / Alkes !");
			return false;
		}
		cdata=document.form1.chkitem.value+'|'+document.form1.qty_kembali.value;
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.form1.submit();
}
</script>
</html>
<?php 
mysqli_close($konek);
?>
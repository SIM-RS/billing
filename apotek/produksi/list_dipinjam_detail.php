<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$iunit=$_REQUEST['iunit'];
$minta_id=$_REQUEST['minta_id'];
$no_bukti=$_REQUEST['no_bukti'];
$tgl_pinjam=$_REQUEST['tgl_pinjam'];
$no_kirim=$_REQUEST['no_kirim'];
$tgl_kirim=$_REQUEST['tgl_kirim'];
if ($tgl_kirim!=""){
	$tgl_kirim=explode("-",$tgl_kirim);
	$tgl_kirim=$tgl_kirim[2]."-".$tgl_kirim[1]."-".$tgl_kirim[0];
}
$isview=$_REQUEST['isview'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="am.tgl,am.permintaan_id";
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
			$sql="call gd_mutasi($idunit, $arfdata[3], $arfdata[1], '$no_kirim', $arfdata[0], 0, $arfdata[2], $arfdata[4], 2, $iduser, 0, '$tgl_kirim', '$tgl2')";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
		$sql="update a_pinjam_obat api inner join (select distinct FK_MINTA_ID from a_penerimaan where NOKIRIM='$no_kirim') as t1 on api.peminjaman_id=t1.FK_MINTA_ID set api.status=1";
		$rs=mysqli_query($konek,$sql);
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
//if ($isview==""){
	$sql="select NOKIRIM from a_penerimaan where UNIT_ID_KIRIM=$idunit and NOKIRIM like '$kodeunit/KI/$th[2]-$th[1]/%' order by NOKIRIM desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_terima=$rows["NOKIRIM"];
		$arno_terima=explode("/",$no_terima);
		$tmp=$arno_terima[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_kirim="$kodeunit/KI/$th[2]-$th[1]/$ctmp";
	}else{
		$no_kirim="$kodeunit/KI/$th[2]-$th[1]/0001";
	}
//}
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
  <p align="center">Peminjaman Obat Dari <?php echo $iunit; ?> Sudah Dikirim Dgn 
    No Pengiriman : <?php echo $no_kirim; ?></p>
	<!--p align="center">
	<a class="navText" href='#' onclick=''>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Peminjaman&nbsp;&nbsp;</BUTTON>
	</a>
	</p-->
</div>
<?php 
}else{
	if ($isview!="true"){
?>
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
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
	<input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta; ?>">
	<input name="no_gdg" id="no_gdg" type="hidden" value="<?php echo $no_gdg; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block"> 
      <p align="center"><span class="jdltable">DETAIL PEMINJAMAN OBAT DARI UNIT 
        <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="120">No Pengiriman</td>
          <td width="290">: 
            <input name="no_kirim" type="text" id="no_kirim" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_kirim; ?>"></td>
          <td width="112">No Peminjaman</td>
          <td width="215">: <?php echo $no_bukti; ?></td>
        </tr>
        <tr> 
          <td width="120">Tgl Pengiriman</td>
          <td>: 
            <input name="tgl_kirim" type="text" id="tgl_kirim" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_kirim,depRange);" /> 
          </td>
          <td>Tgl Peminjaman</td>
          <td>: <?php echo $tgl_pinjam; ?></td>
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
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Minta</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Sdh Terima</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Sdh Kirim</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Stok </td>
          <td width="40" class="tblheader">Qty Kirim</td>
          <td class="tblheader" width="30"><input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"<?php if ($isview=="true") echo " disabled"; ?>></td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,ap.qty-ap.qty_terima as qty_kirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where ap.no_bukti='$no_bukti'";
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_sdhkirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID left join (select ape.* from a_penerimaan ape inner join a_pinjam_obat apo on ape.FK_MINTA_ID=apo.peminjaman_id where ape.TIPE_TRANS=2 and ape.UNIT_ID_KIRIM=$idunit and apo.no_bukti='$no_bukti') as t1 on ap.peminjaman_id=t1.FK_MINTA_ID where ap.no_bukti='$no_bukti' group by ap.peminjaman_id";
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
		$cidobat=$rows['OBAT_ID'];
		$ckp=$rows['kepemilikan_id'];
		$pid=$rows['peminjaman_id'];
		$qty_maukirim=$rows['qty']-$rows['qty_sdhkirim'];
		//$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok from a_penerimaan where OBAT_ID=$cidobat and QTY_STOK>0 and KEPEMILIKAN_ID=$ckp and UNIT_ID_TERIMA=$idunit";
		$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok from a_penerimaan where OBAT_ID=$cidobat and QTY_STOK>0 and UNIT_ID_TERIMA=$idunit and status=1";
	  	//echo $sql;	
		$rs1=mysqli_query($konek,$sql);
		$cstok=0;
		if ($rows1=mysqli_fetch_array($rs1)) $cstok=$rows1['cstok'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_terima']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_sdhkirim']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstok; ?></td>
          <td class="tdisi" align="center"><input name="qty_kirim" type="text" size="4" maxlength="4" class="txtcenter" value="<?php echo $qty_maukirim; ?>"></td>
          <td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox"<?php if ($cstok==0) echo " disabled";?> value="<?php echo $rows['OBAT_ID'].'|'.$rows['peminjaman_id'].'|'.$rows['kepemilikan_id'].'|'.$rows['unit_id']; ?>" style="cursor:pointer"></td>
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
            &nbsp;<BUTTON type="reset" onClick="location='?f=list_dipinjam.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
</form>
</div>
<?php 
	}else{
?>
	<div align="center">
	  <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">DETAIL PEMINJAMAN OBAT DARI UNIT 
        <?php echo strtoupper($iunit); ?> </span></p>
	  
    <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr> 
        <td width="132">No Peminjaman</td>
        <td width="832">: <?php echo $no_bukti; ?></td>
      </tr>
      <tr> 
        <td>Tgl Peminjaman</td>
        <td>: <?php echo $tgl_pinjam; ?></td>
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
        <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
          Minta</td>
        <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
          Terima</td>
      </tr>
      <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,ap.qty-ap.qty_terima as qty_kirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where ap.no_bukti='$no_bukti'";
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
		$cidobat=$rows['OBAT_ID'];
		$ckp=$rows['kepemilikan_id'];
		$pid=$rows['peminjaman_id'];
		$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as cstok from a_penerimaan where OBAT_ID=$cidobat and QTY_STOK>0 and KEPEMILIKAN_ID=$ckp and UNIT_ID_TERIMA=$idunit";
	  	//echo $sql;	
		$rs1=mysqli_query($konek,$sql);
		$cstok=0;
		if ($rows1=mysqli_fetch_array($rs1)) $cstok=$rows1['cstok'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center"><?php echo $rows['qty_terima']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
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

		<p align="center">
			<!--a class="navText" href='#' onclick='PrintArea("listma","#")'>
            <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;&nbsp;</BUTTON>
			</a-->
            &nbsp;<BUTTON type="button" onClick="location='?f=list_dipinjam.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
	   </div>
	</div>
<?php
	}
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
				cdata +=document.form1.chkitem[i].value+'|'+document.form1.qty_kirim[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Dikirim Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.chkitem.checked==false){
			alert("Pilih Item Obat Yg Mau Dikirim Terlebih Dahulu !");
			return false;
		}
		cdata +=document.form1.chkitem.value+'|'+document.form1.qty_kirim.value;
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
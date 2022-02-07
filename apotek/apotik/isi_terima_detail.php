<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$iunit=$_REQUEST['iunit'];
$no_terima=$_REQUEST['no_terima'];
$tgl_terima=$_REQUEST['tgl_terima'];
$no_terima2=$no_terima;
$tgl_terima2=$tgl_terima;
$no_terima1=$_GET['no_terima1'];
$tgl_terima1=$_GET['tgl_terima1'];
$no_minta=$_REQUEST['no_minta'];
$no_kirim=$_REQUEST['no_kirim'];
$tgl_kirim=$_REQUEST['tgl_kirim'];
if ($tgl_terima!=""){
	$tgl_terima=explode("-",$tgl_terima);
	$tgl_terima1=$tgl_terima[2]."-".$tgl_terima[1]."-".$tgl_terima[0];
}
$isview=$_REQUEST['isview'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="apo.peminjaman_id";
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
			//echo $arfdata[1]."-".$arfdata[2]."<br>";
			if ($arfdata[1]==$arfdata[2]){
				$sql="update a_penerimaan set USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',STATUS=1,TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act' where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0]";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);				
			}else{
				$selisih=$arfdata[1]-$arfdata[2];
				$sql="select * from a_penerimaan where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0] order by ID desc";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$ok="false";
				$selisih1=0;
				while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
					$cid=$rows['ID'];
					$cid_lama=$rows['ID_LAMA'];
					$cid_pinjam=$rows['FK_MINTA_ID'];
					$cstok=$rows['QTY_SATUAN'];
					if ($cstok>=$selisih){
						$ok=="true";
						if ($cstok>$selisih){
							$sql="update a_penerimaan set QTY_SATUAN=QTY_SATUAN-$selisih , QTY_STOK=QTY_STOK-$selisih where ID=$cid";
						}else{
							$sql="delete from a_penerimaan where ID=$cid";
						}
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid_lama";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_pinjam_obat set qty_kirim=qty_kirim-$selisih where peminjaman_id=$cid_pinjam";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}else{
						$selisih=$selisih-$cstok;
						$sql="delete from a_penerimaan where ID=$cid";
						//echo $sql."<br>";						
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid_lama";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);					
						$sql="update a_pinjam_obat set qty_kirim=qty_kirim-$cstok where peminjaman_id=$cid_pinjam";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}
				}			
				$sql="update a_penerimaan set USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',STATUS=1,TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act' where NOKIRIM='$no_kirim' and OBAT_ID=$arfdata[0]";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);				
			}
		}
		$sql="update a_pinjam_obat api inner join (select distinct FK_MINTA_ID,sum(QTY_STOK) as jml from a_penerimaan where NOKIRIM='$no_kirim' group by FK_MINTA_ID) as t1 on api.peminjaman_id=t1.FK_MINTA_ID set api.qty_terima=qty_terima+t1.jml";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$sql="update a_pinjam_obat api inner join (select distinct FK_MINTA_ID from a_penerimaan where NOKIRIM='$no_kirim') as t1 on api.peminjaman_id=t1.FK_MINTA_ID set api.status=2 where api.qty_terima>=api.qty";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
//if ($isview==""){
	$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/PT/$th[2]-$th[1]/%' order by right(NOTERIMA,4) desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_terima=$rows["NOTERIMA"];
		$arno_terima=explode("/",$no_terima);
		$tmp=$arno_terima[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_terima="$kodeunit/PT/$th[2]-$th[1]/$ctmp";
	}else{
		$no_terima="$kodeunit/PT/$th[2]-$th[1]/0001";
	}
//}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<style type="text/css">
<!--
.style4 {font-size: 10px}
.style5 {font-size: 14px}
-->
</style>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<?php if ($act=="save"){?>
<div align="center">
<p align="center"><b>Peminjaman Obat Dari <?php echo strtoupper($iunit); ?> Sudah Diterima Dgn 
  No Penerimaan : <?php echo $no_terima2; ?></b></p>
  <p align="center"><a class="navText" href='#' onclick='PrintArea("cetak","#")'>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;</BUTTON>
	</a> &nbsp;<BUTTON type="button" onClick="location='?f=list_pinjam_terima.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>
  
	<!--p align="center">
	<a class="navText" href='#' onclick=''>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Peminjaman&nbsp;&nbsp;</BUTTON>
	</a>
	</p-->
	<div id="cetak" style="display:none">
	  <link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">PENERIMAAN PENGIRIMAN PINJAMAN OBAT</span></p>
	  
      <table width="87%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr>
          <td width="150" class="">Unit Penerima</td>
          <td width="213" class="">: <?php $u="select UNIT_NAME from a_unit where UNIT_ID='$idunit'";
							$hsu=mysqli_query($konek,$u);
							$ros=mysqli_fetch_array($hsu);
							echo $ros['UNIT_NAME']; ?></td>
          <td width="162" class="">Unit Pengirim</td>
          <td width="216" class="">: <?php echo $iunit; ?></td>
        </tr>
		<tr>
          <td width="150" class="">No Penerimaan</td>
          <td width="213" class="">: <?php echo $no_terima2; ?></td>
          <td width="162" class="">No Pengiriman</td>
          <td width="216" class="">: <?php echo $no_kirim; ?></td>
        </tr>
        <tr>
          <td class="">Tgl Penerimaan</td>
          <td class="">: <?php echo $tgl_terima2; ?></td>
          <td class="">Tgl Pengiriman</td>
          <td class="">: <?php echo $tgl_kirim; ?></td>
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
        <td width="40" class="tblheader" id="qty_terima" onClick="ifPop.CallFr(this);">Qty 
          Terima</td>
      </tr>
      <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,ap.qty-ap.qty_terima as qty_kirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where ap.no_bukti='$no_minta'";
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
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_terima']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
	</div>
</div>
<?php 
}else{
?>

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
	<input name="no_kirim" id="no_minta" type="hidden" value="<?php echo $no_kirim; ?>">
	<input name="no_terima1" id="no_terima1" type="hidden" value="<?php echo $no_terima1; ?>">
	<input name="tgl_terima1" id="tgl_terima1" type="hidden" value="<?php echo $tgl_terima1; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<div align="center">
<?php 
	if ($isview!="true"){
?>
    <div id="view" style="display:block"> 
      <p align="center"><span class="jdltable">DETAIL PEMINJAMAN OBAT DARI UNIT 
        <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="120">No Penerimaan</td>
          <td width="290">: 
            <input name="no_terima" type="text" id="no_terima" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_terima; ?>"></td>
          <td width="112">No Pengiriman</td>
          <td width="215">: <?php echo $no_kirim; ?></td>
        </tr>
        <tr> 
          <td width="120">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_terima" type="text" id="tgl_terima" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_terima,depRange);" /> 
          </td>
          <td>Tgl Pengiriman</td>
          <td>: <?php echo $tgl_kirim; ?></td>
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
          <td id="qty" width="40" class="tblheader">Qty<br>
            Minta</td>
          <td width="40" class="tblheader">Qty Kirim</td>
          <td width="40" class="tblheader">Qty Terima</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select sum(ap.QTY_SATUAN) as qty_kirim,apo.qty,apo.qty_terima,ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,ake.NAMA as NAMA1 from a_penerimaan ap inner join a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on apo.kepemilikan_id_asal=ake.ID where month(ap.TANGGAL)=$bulan and year(ap.TANGGAL)=$ta and ap.TIPE_TRANS=2 and ap.UNIT_ID_TERIMA=$idunit and ap.NOKIRIM='$no_kirim'".$filter." group by ap.OBAT_ID order by ".$sorting;
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
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
          <td class="tdisi" align="center"><input name="qty_kirim" type="hidden" size="4" maxlength="4" class="txtcenter" value="<?php echo $rows['OBAT_ID'].'|'.$rows['qty_kirim']; ?>"> 
            <input name="qty_terima" type="text" size="4" maxlength="4" class="txtcenter" value="<?php echo $rows['qty_kirim']; ?>"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
    </div>
	
		<p align="center">
      <BUTTON type="button" onClick="if (ValidateForm('no_terima','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Terima&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=list_pinjam_terima'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
<?php 
	}else{
?>
	<div align="center">
	  <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">DETAIL PEMINJAMAN OBAT DARI UNIT 
        <?php echo strtoupper($iunit); ?> </span></p>
	  
    <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr>
        <td width="150">No Penerimaan</td>
            <td width="392">: <?php echo $no_terima1; ?></td>
        <td width="134">No Pengiriman</td>
        <td width="284">: <?php echo $no_kirim; ?></td>
      </tr>
      <tr>
        <td>Tgl Penerimaan</td>
            <td>: <?php echo $tgl_terima1; ?></td>
        <td>Tgl Pengiriman</td>
        <td>: <?php echo $tgl_kirim; ?></td>
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
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,ap.qty-ap.qty_terima as qty_kirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where ap.no_bukti='$no_minta'";
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
        <td class="tdisikiri" align="center"><?php echo $i; ?></td>
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
    </table>
      </div>
	  <div id="listma1" style="display:none">
	  <link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">DETAIL PEMINJAMAN OBAT DARI UNIT 
        <?php echo strtoupper($iunit); ?> </span></p>
	  
    <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr>
        <td width="150">No Penerimaan</td>
            <td width="392">: <?php echo $no_terima1; ?></td>
        <td width="134">No Pengiriman</td>
        <td width="284">: <?php echo $no_kirim; ?></td>
      </tr>
      <tr>
        <td>Tgl Penerimaan</td>
            <td>: <?php echo $tgl_terima1; ?></td>
        <td>Tgl Pengiriman</td>
        <td>: <?php echo $tgl_kirim; ?></td>
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
	 /* if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; */
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,ap.qty-ap.qty_terima as qty_kirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where ap.no_bukti='$no_minta'";
	  //echo $sql."<br>";
		/*$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";*/
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  //$i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$p++;
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
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $p; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_terima']; ?></td>
      </tr>
      <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
    </table>
      </div>
	  <table width="976">
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
            <BUTTON type="button" onClick="PrintArea('listma1','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;&nbsp;</BUTTON>&nbsp;<BUTTON type="button" onClick="location='?f=list_pinjam_terima.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</div>
<?php
	}
?>

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
	if (document.form1.qty_terima.length){
		for (var i=0;i<document.form1.qty_terima.length;i++){
			cdata +=document.form1.qty_kirim[i].value+'|'+document.form1.qty_terima[i].value+'**';
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Isikan Jml Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.qty_terima.value==""){
			alert("Isikan Jml Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
		cdata +=document.form1.qty_kirim.value+'|'+document.form1.qty_terima.value;
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
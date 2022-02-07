<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglSkrg=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$iunit=$_REQUEST["iunit"];
$nunit=$_REQUEST["nunit"];
//$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$no_kirim=$_REQUEST['no_kirim'];
$no_minta=$_REQUEST['no_minta'];
$tgl_kirim=$_REQUEST['tgl_kirim'];
$tgl_minta=$_REQUEST['tgl_minta'];
if ($tgl_kirim!=""){
	$tgl_kirim=explode("-",$tgl_kirim);
	$tgl_kirim=$tgl_kirim[2]."-".$tgl_kirim[1]."-".$tgl_kirim[0];
}
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.FK_MINTA_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
//echo "------------------------";
switch ($act){
 	case "save":
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++){
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="update a_minta_obat set status=1 where permintaan_id=$arfvalue[0] and status=0";
			//echo $sql.'<br>';
			$rs=mysqli_query($konek,$sql);
			$sql="call gd_mutasi($idunit,$iunit,$arfvalue[0],'$no_kirim',$arfvalue[2],$arfvalue[3],$arfvalue[3],$arfvalue[1],1,$iduser,0,'$tgl_kirim','$tglSkrg')";
			$rs=mysqli_query($konek,$sql);
/*			$sql="select * from a_penerimaan where OBAT_ID=$arfvalue[2] and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$arfvalue[3] and QTY_STOK>0 and STATUS=1 order by TANGGAL,ID";
			//echo $sql.'<br>';
			$rs=mysqli_query($konek,$sql);
			$done=0;
			$jml=$arfvalue[1];
			while (($rows=mysqli_fetch_array($rs))&&($done==0)){
				$cstok=$rows["QTY_STOK"];
				$cid=$rows["ID"];
				$pbf_id=$rows["PBF_ID"];
				$batch=$rows["BATCH"];
				$expired=$rows["EXPIRED"];
				$KEMASAN=$rows["KEMASAN"];
				$QTY_PER_KEMASAN=$rows["QTY_PER_KEMASAN"];
				$HARGA_BELI_SATUAN=$rows["HARGA_BELI_SATUAN"];
				$DISKON=$rows["DISKON"];
				$EXTRA_DISKON=$rows["EXTRA_DISKON"];
				$DISKON_TOTAL=$rows["DISKON_TOTAL"];
				$NILAI_PAJAK=$rows["NILAI_PAJAK"];
				$JENIS=$rows["JENIS"];
				if ($cstok>=$jml){
					$done=1;
					$sql="insert into a_penerimaan(OBAT_ID,ID_LAMA,FK_MINTA_ID,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,NOKIRIM,TANGGAL_ACT,TANGGAL,BATCH,EXPIRED,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,EXTRA_DISKON,DISKON_TOTAL,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS) values($arfvalue[2],$cid,$arfvalue[0],$pbf_id,$idunit,$iunit,$arfvalue[3],$iduser,'$no_gdg','$tglSkrg','$tgl_kirim','$batch','$expired','$KEMASAN',$QTY_PER_KEMASAN,$jml,$jml,$jml*$HARGA_BELI_SATUAN,$HARGA_BELI_SATUAN,$DISKON,$EXTRA_DISKON,$DISKON_TOTAL,$NILAI_PAJAK,$JENIS,1,0)";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}else{
					$jml=$jml-cstokcstok;
					$sql="insert into a_penerimaan(OBAT_ID,ID_LAMA,FK_MINTA_ID,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,NOKIRIM,TANGGAL_ACT,TANGGAL,BATCH,EXPIRED,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_STOK,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,EXTRA_DISKON,DISKON_TOTAL,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS) values($arfvalue[2],$cid,$arfvalue[0],$pbf_id,$idunit,$iunit,$arfvalue[3],$iduser,'$no_gdg','$tglSkrg','$tgl_kirim','$batch','$expired','$KEMASAN',$QTY_PER_KEMASAN,cstok,cstok,cstok*$HARGA_BELI_SATUAN,$HARGA_BELI_SATUAN,$DISKON,$EXTRA_DISKON,$DISKON_TOTAL,$NILAI_PAJAK,$JENIS,1,0)";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}	
			}
*/
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select * from a_penerimaan where UNIT_ID_KIRIM=$idunit and month(TANGGAL)=$bulan and year(TANGGAL)=$th[2] and TIPE_TRANS=1 order by NOKIRIM desc limit 1";
//echo $sql."<br>";
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$no_gdg=$rows1["NOKIRIM"];
	$ctmp=explode("/",$no_gdg);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_gdg="$kodeunit/MU/$th[2]-$th[1]/$ctmp";
}else{
	$no_gdg="$kodeunit/MU/$th[2]-$th[1]/0001";
}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
</head>
<body>
<?php if ($act=="save"){?>
    <div id="printArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">DETAIL PERMINTAAN OBAT</span> 
      
  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
    <tr> 
      <td width="120">No Kirim Gudang</td>
      <td width="493">: <?php echo $no_kirim; ?></td>
      <td width="122">No Permintaan</td>
      <td width="221">: <?php echo $no_minta; ?></td>
    </tr>
    <tr> 
      <td width="120">Tgl Kirim Gudang</td>
      <td>: <?php echo $tgl_kirim; ?></td>
      <td>Tgl Permintaan</td>
      <td>: <?php echo $tgl_minta; ?></td>
    </tr>
    <tr> 
      <td>Unit</td>
      <td>: <?php echo $nunit; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
      <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
        Minta</td>
      <td width="30" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
        Kirim</td>
    </tr>
    <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,(am.qty-am.qty_terima) as qty_kirim,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id=$iunit and am.no_bukti='$no_kirim'".$filter." order by ".$sorting;
	  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.qty,NAMA,sum(ap.QTY_SATUAN) as qty_kirim from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID inner join a_penerimaan ap on am.permintaan_id=ap.FK_MINTA_ID where am.unit_id=$iunit and ap.NOKIRIM='$no_kirim'".$filter." group by ap.FK_MINTA_ID order by ".$sorting;
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
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri"><?php echo $i; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
      <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
      <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
    </tr>
    <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
  </table>
    </div>

<div align="center">
  <p align="center">Pengiriman Gudang Dgn No Kirim : <?php echo $no_kirim; ?> 
    Sudah Disimpan</p>
	<p align="center">
	<a class="navText" href='#' onclick='PrintArea("printArea","#")'>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Pengiriman&nbsp;&nbsp;</BUTTON></a>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=list_permintaan.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Permintaan Unit&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p><span class="jdltable">DETAIL PERMINTAAN OBAT</span> 
      <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="120">No Kirim Gudang</td>
          <td width="487">: 
            <input name="no_kirim" type="text" id="no_kirim" size="25" maxlength="30" class="txtinput" value="<?php echo $no_gdg;?>"></td>
          <td width="113">No Permintaan</td>
          <td width="236">: <?php echo $no_minta; ?></td>
        </tr>
        <tr> 
          <td width="120">Tgl Kirim Gudang</td>
          <td>: 
            <input name="tgl_kirim" type="text" id="tgl_kirim" size="11" maxlength="10" class="txtcenter" readonly="true" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_kirim,depRange);" />
          </td>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
        </tr>
        <tr> 
          <td>Unit</td>
          <td>: <?php echo $nunit; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Minta</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Sdh Kirim</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td width="30" class="tblheader" onClick="ifPop.CallFr(this);">Stok 
            Gudang </td>
          <td width="30" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Kirim</td>
          <td class="tblheader" width="30"><input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"></td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,if (sum(ap.QTY_SATUAN) is null,0,sum(ap.QTY_SATUAN)) as qty_kirim,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID left join a_penerimaan ap on am.permintaan_id=ap.FK_MINTA_ID where am.unit_id=$iunit and am.no_bukti='$no_minta'".$filter." group by am.permintaan_id order by ".$sorting;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		$idkp=$rows['kepemilikan_id'];
		$idobat=$rows['obat_id'];
		$sql="select if (sum(ap.QTY_STOK) is null,0,sum(ap.QTY_STOK)) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.OBAT_ID=$idobat and ap.QTY_STOK>0 and ap.KEPEMILIKAN_ID=$idkp and ap.STATUS=1";
		$rs1=mysqli_query($konek,$sql);
		if ($rows1=mysqli_fetch_array($rs1)) $cstok=$rows1['stok'];
		$istatus=$rows['status'];
		switch ($istatus){
			case 0:
				$cstatus="Menunggu";
				break;
			case 1:
				$cstatus="Dikirim";
				break;
			case 2:
				$cstatus="Diterima(-)";
				break;
			case 3:
				$cstatus="Diterima";
				break;
		}
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_terima']; ?></td>
          <td class="tdisi" align="center"><?php echo $cstok; ?></td>
          <td class="tdisi" align="center"><?php if (($rows['qty_kirim'])>=($rows['qty'])){?><img src="../icon/save.ico" border="0" width="16" height="16" align="absmiddle" class="proses" title="Obat Yg Diminta Sudah Terkirim Semua"><?php }else{?><input name="qty_kirim" id="qty_kirim" type="text" size="4" class="txtcenter" value="<?php echo ($rows['qty']-$rows['qty_kirim']); ?>"><?php }?></td>
          <!--td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php //echo $arfvalue; ?>');"></td-->
          <td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox" value="<?php echo $rows['permintaan_id'].'-'.$cstok.'-'.$idobat.'-'.$idkp; ?>"<?php if ($cstok==0) echo " disabled";?> style="cursor:pointer"></td>
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
            &nbsp;<BUTTON type="reset" onClick="location='?f=list_permintaan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
</form>
</div>
<?php } ?>
</body>
<script>
function fSubmit(){
var cdata='';
var x;
	if (document.form1.chkitem.length){
		for (var i=0;i<document.form1.chkitem.length;i++){
			if (document.form1.chkitem[i].checked==true){
				x=document.form1.chkitem[i].value.split('-');
				if ((x[1]*1)<(document.form1.qty_kirim[i].value*1)){
					alert("Stok Obat Yg Mau Dikirim Tidak Cukup !");
					document.form1.qty_kirim[i].focus();
					return false;
				}
				cdata +=x[0]+'|'+document.form1.qty_kirim[i].value+'|'+x[2]+'|'+x[3]+'**';
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
		x=document.form1.chkitem.value.split('-');
		if ((x[1]*1)<(document.form1.qty_kirim.value*1)){
			alert("Stok Obat Yg Mau Dikirim Tidak Cukup !");
			document.form1.qty_kirim.focus();
			return false;
		}
		cdata +=x[0]+'|'+document.form1.qty_kirim.value+'|'+x[2]+'|'+x[3];
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
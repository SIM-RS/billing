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
$iunit=$_REQUEST['iunit'];
$no_bukti=$_REQUEST['no_bukti'];
$tgl_pinjam=$_REQUEST['tgl_pinjam'];
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
			$sql="call gd_mutasi($idunit, $arfdata[3], $arfdata[1], '$no_kirim', $arfdata[0], $arfdata[2], $arfdata[2], $arfdata[4], 2, $iduser, 0, '$tgl_kirim', '$tgl2')";
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
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
	<input name="no_bukti" id="no_bukti" type="hidden" value="<?php echo $no_bukti; ?>">
	<input name="tgl_pinjam" id="tgl_pinjam" type="hidden" value="<?php echo $tgl_pinjam; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block"> 
      <p align="center"><span class="jdltable">DETAIL OBAT YANG SUDAH DIKIRIMKAN 
        KE UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="126">No Peminjaman</td>
          <td width="838">: <?php echo $no_bukti; ?></td>
        </tr>
        <tr> 
          <td>Tgl Peminjaman</td>
          <td>: <?php echo $tgl_pinjam; ?></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="OBAT_KODE" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim </td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Kirim</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,ap.peminjaman_id,ap.unit_id,ap.kepemilikan_id,ap.qty,ap.qty_terima,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_sdhkirim from a_pinjam_obat ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID left join (select ape.* from a_penerimaan ape inner join a_pinjam_obat apo on ape.FK_MINTA_ID=apo.peminjaman_id where ape.TIPE_TRANS=2 and ape.UNIT_ID_KIRIM=$idunit and apo.no_bukti='$no_bukti') as t1 on ap.peminjaman_id=t1.FK_MINTA_ID where ap.no_bukti='$no_bukti' group by ap.peminjaman_id";
	  $sql="select t1.OBAT_ID,t1.NOKIRIM,t1.TANGGAL,t1.tgl1,sum(t1.qty_kirim) as qty_kirim,ap1.KEPEMILIKAN_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from a_penerimaan ap1 inner join (select ap.OBAT_ID,ap.ID_LAMA,ap.NOKIRIM,ap.TANGGAL,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,sum(ap.QTY_SATUAN) as qty_kirim from a_penerimaan ap inner join a_pinjam_obat apo on ap.FK_MINTA_ID=apo.peminjaman_id where ap.TIPE_TRANS=2 and apo.no_bukti='$no_bukti' group by ap.OBAT_ID,ap.ID_LAMA,ap.NOKIRIM) as t1 on ap1.ID=t1.ID_LAMA inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap1.KEPEMILIKAN_ID=ak.ID group by t1.OBAT_ID,t1.NOKIRIM,ap1.KEPEMILIKAN_ID";
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
          <td class="tdisi" align="center"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
    </div>
		<p align="center">
			<!--a class="navText" href='#' onclick='PrintArea("listma","#")'>
            <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Peminjaman&nbsp;&nbsp;</BUTTON>
			</a-->
            &nbsp;<BUTTON type="button" onClick="location='?f=list_dipinjam.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
</form>
</div>
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
<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$idunit=$_SESSION["ses_idunit"];
$iunit=$_REQUEST['iunit'];
$no_minta=$_REQUEST['no_minta'];
$tgl_minta=$_REQUEST['tgl_minta'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="NOKIRIM desc";
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
	function PrintArea(printDiv,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printDiv).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
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
	<input name="no_minta" id="no_bukti" type="hidden" value="<?php echo $no_minta; ?>">
	<input name="tgl_minta" id="tgl_minta" type="hidden" value="<?php echo $tgl_minta; ?>">
	<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
	<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	
	<!--PRINT OUT -->
	    <div id="printDiv" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" /> 
      <p align="center"><span class="jdltable">DAFTAR OBAT YANG SUDAH DIKIRIMKAN 
        KE UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="30%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
     	<tr>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
	    </tr>
		  <tr>
          <td width="137">No Permintaan</td>
          <td width="172">: <?php echo $no_minta; ?></td>
    
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="NOKIRIM" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim </td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Kirim</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Harga Satuan</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;

		$sql="SELECT t1.*,ak.NAMA FROM (SELECT ap.OBAT_ID,a_obat.OBAT_KODE,a_obat.OBAT_NAMA,a_obat.OBAT_SATUAN_KECIL,
		(AP.HARGA_BELI_SATUAN * (1 - (`DISKON` / 100))) HARGA_BELI_SATUAN,
ap.FK_MINTA_ID,ap.KEPEMILIKAN_ID,ap.NOKIRIM,ap.TANGGAL,DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1,@a1 := SUM(ap.QTY_SATUAN) AS qty_kirim, ah.harga_jual_satuan, @a1 * ah.harga_jual_satuan AS total
FROM (SELECT * FROM a_minta_obat WHERE no_bukti='$no_minta') AS am INNER JOIN a_penerimaan ap ON am.permintaan_id=ap.FK_MINTA_ID 
INNER JOIN a_obat ON ap.OBAT_ID = a_obat.OBAT_ID LEFT JOIN a_harga ah ON ap.obat_id = ah.obat_id AND ap.kepemilikan_id = ah.kepemilikan_id WHERE ap.TIPE_TRANS=1 GROUP BY ap.OBAT_ID,ap.FK_MINTA_ID,ap.NOKIRIM) AS t1 
INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$filter." GROUP BY t1.OBAT_ID,t1.NOKIRIM,t1.KEPEMILIKAN_ID ORDER BY ".$sorting;
	// echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$i=0;
		$sTot=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['tgl1']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NOKIRIM']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_kirim']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN']*$rows['qty_kirim'],0,",","."); 
		  $sTot+=$rows['HARGA_BELI_SATUAN']*$rows['qty_kirim']; ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
	      <td class="tdisikiri" align="right" style="font-size:12px;" colspan="9">Grand Total</td>
          <td class="tdisi" align="right"><?php echo number_format($sTot,0,",","."); ?></td>
      </tr>
    </table>
	</div>
	<!--PRINTOUT BERAKHIR -->
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" /> 
      <p align="center"><span class="jdltable">DAFTAR OBAT YANG SUDAH DIKIRIMKAN 
        KE UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  <table width="32%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr>  
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
		</tr>
        <tr>
          <td width="125">No Permintaan</td>
          <td width="195">: <?php echo $no_minta; ?></td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Tgl 
            Kirim </td>
          <td id="NOKIRIM" width="150" class="tblheader" onClick="ifPop.CallFr(this);">No 
            Kirim </td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty Kirim</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Harga Satuan</td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
/* 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; */
		//$sql="select t1.OBAT_ID,t1.NOKIRIM,t1.TANGGAL,t1.tgl1,t1.qty_kirim,t1.KEPEMILIKAN_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,a_obat.OBAT_KODE,a_obat.OBAT_NAMA,ap.FK_MINTA_ID,ap.KEPEMILIKAN_ID,ap.NOKIRIM,ap.TANGGAL,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,sum(ap.QTY_SATUAN) as qty_kirim from a_penerimaan ap inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id inner join a_obat ON ap.OBAT_ID = a_obat.OBAT_ID where ap.TIPE_TRANS=1 and am.no_bukti='$no_minta' ".$filter." group by ap.OBAT_ID,ap.FK_MINTA_ID,ap.NOKIRIM) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID group by t1.OBAT_ID,t1.NOKIRIM,t1.KEPEMILIKAN_ID ORDER BY ".$sorting;
/*		$sql="SELECT t1.*,ak.NAMA FROM (SELECT ap.OBAT_ID,a_obat.OBAT_KODE,a_obat.OBAT_NAMA,a_obat.OBAT_SATUAN_KECIL,
ap.FK_MINTA_ID,ap.KEPEMILIKAN_ID,ap.NOKIRIM,ap.TANGGAL,DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tgl1,SUM(ap.QTY_SATUAN) AS qty_kirim 
FROM (SELECT * FROM a_minta_obat WHERE no_bukti='$no_minta') AS am INNER JOIN a_penerimaan ap ON am.permintaan_id=ap.FK_MINTA_ID 
INNER JOIN a_obat ON ap.OBAT_ID = a_obat.OBAT_ID WHERE ap.TIPE_TRANS=1 GROUP BY ap.OBAT_ID,ap.FK_MINTA_ID,ap.NOKIRIM) AS t1 
INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$filter." GROUP BY t1.OBAT_ID,t1.NOKIRIM,t1.KEPEMILIKAN_ID ORDER BY ".$sorting;*/
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
/*		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;*/
	  $i=0;
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
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN']*$rows['qty_kirim'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	   <!--tr> 
        <td align="left" colspan="5"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
        <td align="right" colspan="3"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
        </td>
      </tr-->
    </table>
	</div>
	  <p align="center">
            
      <BUTTON type="button" onClick="PrintArea('printDiv','#')" <?php if($i==0) echo 'disabled' ;?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
      Pengiriman&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="location='?f=../gudang/list_permintaan&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
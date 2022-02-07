<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tglctk=date('d/m/Y H:i');
$idunit=$_SESSION["ses_idunit"];
$iunit=$_REQUEST['iunit'];
$idunit_krm=$_REQUEST['idunit_krm'];
$no_retur=$_REQUEST['no_retur'];
$tgl_retur=$_REQUEST['tgl_retur'];
$terima=$_REQUEST['terima'];
$no_terima=$_REQUEST['no_terima'];
$tgl_terima=$_REQUEST['tgl_terima'];
$tgl_terima1=explode("-",$tgl_terima);
$tgl_terima=$tgl_terima1[2]."-".$tgl_terima1[1]."-".$tgl_terima1[0];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID_RETUR";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "terima":
		$cidminta="";
		for ($i = 0; $i < count($terima); $i++)
		{
			$cidminta .=$terima[$i].",";
			$sql="UPDATE a_retur_togudang SET STATUS=1 where ID_RETUR=$terima[$i]";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			
			$sql="SELECT SQL_NO_CACHE *,UUID() from a_penerimaan WHERE FK_MINTA_ID=$terima[$i] and NOKIRIM='$no_retur' ORDER BY ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			while ($rows=mysqli_fetch_array($rs)){
				$qty=$rows['QTY_SATUAN'];
				$cid=$rows['ID'];
				$cobatid=$rows['OBAT_ID'];
				$ckpid=$rows['KEPEMILIKAN_ID'];
				$sql="UPDATE a_penerimaan SET USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act',STATUS=1 WHERE ID=$cid";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				
				/*$sql="SELECT SQL_NO_CACHE IFNULL(SUM(QTY_STOK),0) AS stok_after,IFNULL(SUM(QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1";*/
				$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
				$rs1=mysqli_query($konek,$sql);
				$cstok=0;
				$cnilai=0;
				if ($rows1=mysqli_fetch_array($rs1)){
					$cstok=$rows1['stok_after'];
					$cnilai=$rows1['ntot'];
				}
				//Kartu Stok Penerima
				$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,NILAI_TOTAL) VALUES ($cobatid,$ckpid,$idunit,'$tgl_terima',NOW(),'$no_terima',$cstok-$qty,0,-1 * $qty,$cstok,'Return $no_retur - $no_terima',$iduser,$cid,7,$cnilai)";
				$rs1=mysqli_query($konek,$sql);
				//$cstok=$cstok+$qty;
			}
		}
		if ($cidminta!=""){
			$cidminta=substr($cidminta,0,strlen($cidminta)-1);
			$sql="select SQL_NO_CACHE *,UUID() from a_penerimaan where FK_MINTA_ID not in ($cidminta) and NOKIRIM='$no_retur'";
			$rs=mysqli_query($konek,$sql);
			while ($rows=mysqli_fetch_array($rs)){
				$cid=$rows['ID'];
				$cidlama=$rows['ID_LAMA'];
				$cfkminta=$rows['FK_MINTA_ID'];
				$cqty=$rows['QTY_SATUAN'];
				$cobatid=$rows['OBAT_ID'];
				$ckpid=$rows['KEPEMILIKAN_ID'];

				$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cqty where ID=$cidlama";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_penerimaan SET USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',TGL_TERIMA='$tgl_terima',TGL_TERIMA_ACT='$tgl_act',QTY_SATUAN=0,QTY_STOK=0,STATUS=1 where ID=$cid";
				$rs1=mysqli_query($konek,$sql);
				$sql="UPDATE a_retur_togudang SET STATUS=1 where ID_RETUR=$cfkminta";
				$rs1=mysqli_query($konek,$sql);

				/*$sql="SELECT SQL_NO_CACHE IFNULL(SUM(QTY_STOK),0) AS stok_after,IFNULL(SUM(QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit_krm AND QTY_STOK>0 AND STATUS=1";*/
				$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit_krm AND QTY_STOK>0 AND STATUS=1) AS t1";
				$rs1=mysqli_query($konek,$sql);
				$cstok_lama=0;
				$cnilai_lama=0;
				if ($rows1=mysqli_fetch_array($rs1)){
					$cstok_lama=$rows1['stok_after'];
					$cnilai_lama=$rows1['ntot'];
				}
				//Kartu Stok Pengirim
				$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,NILAI_TOTAL) VALUES ($cobatid,$ckpid,$idunit_krm,'$tgl_terima',NOW(),'$no_terima',$cstok_lama-$cqty,0,-1 * $cqty,$cstok_lama,'Return(-) $no_retur - $no_terima',$iduser,$cidlama,7,$cnilai_lama)";
				$rs1=mysqli_query($konek,$sql);
			}
			/* $sql="delete from a_penerimaan where FK_MINTA_ID not in ($cidminta) and NOKIRIM='$no_retur'";
			$rs=mysqli_query($konek,$sql);
			$sql="delete from a_retur_togudang where ID_RETUR not in ($cidminta) and NO_RETUR='$no_retur'";
			$rs=mysqli_query($konek,$sql); */
		}
		echo "<script>location='?f=../gudang/retur_dr_unit.php'</script>";
		exit();
		break;
}

//echo $act;
$sql="SELECT NOTERIMA FROM a_penerimaan WHERE UNIT_ID_TERIMA=1 AND NOTERIMA LIKE '$kodeunit/RTR-RCV/$th[2]-$th[1]/%' ORDER BY NOTERIMA DESC LIMIT 1";
$rs=mysqli_query($konek,$sql);
$no_terima2="$kodeunit/RTR-RCV/$th[2]-$th[1]/0001";
if ($rows=mysqli_fetch_array($rs)){
	$no_terima2=$rows["NOTERIMA"];
	$arno_terima=explode("/",$no_terima2);
	$tmp=$arno_terima[3]+1;
	$ctmp=$tmp;
	for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
	$no_terima2="$kodeunit/RTR-RCV/$th[2]-$th[1]/$ctmp";	
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
  	<input name="act" id="act" type="hidden" value="terima">
  	<input name="no_retur" id="no_retur" type="hidden" value="<?php echo $no_retur; ?>">
	<input name="iunit" id="iunit" type="hidden" value="<?php echo $iunit; ?>">
    <input name="idunit_krm" id="idunit_krm" type="hidden" value="<?php echo $idunit_krm; ?>">
	<input name="tgl_retur" id="tgl_retur" type="hidden" value="<?php echo $tgl_retur; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">

	  <div id="listma" style="display:block">
      <link rel="stylesheet" href="../theme/print.css" type="text/css" />
    <p align="center"><span class="jdltable">PROSES RETUR OBAT DARI UNIT <?php echo strtoupper($iunit); ?> </span></p>
	  
      <table width="89%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr>
          <td width="83">Tgl Terima</td>
          <td width="568">: 
            <input name="tgl_terima" type="text" id="tgl_terima" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_terima,depRange);" /></td>
          <td width="73">Tgl Retur </td>
          <td width="186">: <?php echo $tgl_retur; ?></td>
        </tr>
        <tr>
          <td width="83">No Terima</td>
          <td width="568">: 
            <input name="no_terima" type="text" id="no_terima" size="27" maxlength="30" class="txtcenter" value="<?php echo $no_terima2; ?>" readonly="true"></td>
          <td width="73">No Retur</td>
          <td width="186">: <?php echo $no_retur; ?></td>
        </tr>
      </table>
      
      <table width="89%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="38" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="82" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="98" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="98" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
          <td id="qty_terima" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Alasan</td>
          <td id="qty" width="25" class="tblheader">Terima</td>
        </tr>
        <?php 
 	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; 
	  $sql="Select a_retur_togudang.*,a_unit.UNIT_NAME, a_obat.OBAT_KODE, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,k.NAMA From a_retur_togudang Inner Join a_unit ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID Inner Join a_obat ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID inner join a_kepemilikan k on a_retur_togudang.KEPEMILIKAN_ID=k.ID where a_retur_togudang.NO_RETUR='$no_retur'".$filter." order by ".$sorting;
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
          <td class="tdisikiri" align="center">&nbsp;<?php echo $i; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left">&nbsp;<?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center">&nbsp;<?php echo $rows['QTY']; ?></td>
          <td align="left" class="tdisi">&nbsp;<?php echo $rows['ALASAN']; ?></td>
          <td class="tdisi" align="center"><input type="checkbox" name="terima[]" id="terima[]" value="<?php echo $rows['ID_RETUR']; ?>"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td align="left" colspan="3"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td align="right" colspan="5"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
          </td>
        </tr>
      </table>
	</div>
		<p align="center">
      <BUTTON type="button" onClick="document.form1.submit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Terima&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="location='?f=../gudang/retur_dr_unit.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;</BUTTON>
        </p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>
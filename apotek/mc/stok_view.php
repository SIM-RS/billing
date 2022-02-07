<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	header("Location: ../../index.php");
	exit();
}
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_id_gudang"];
if ($idunit=="") $idunit=$idunit1;
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$stok=$_REQUEST['stok'];
$stok1=$_REQUEST['stok1'];
$ket=$_REQUEST['ket'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

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
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
</head>
<body>
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
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">  
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <?php include("header.php");?>
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="listma" style="display:block">
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" width="1000" height="470">
<div align="center">
    <div id="listma" style="display:block">
<p><span class="jdltable">DAFTAR STOK OBAT / ALKES</span> 
      <table width="98%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="242"><span class="txtinput">Unit : </span>
            <select name="idunit" id="idunit" class="txtinput" onChange="location='stok_view.php?idunit='+this.value">
              <?
		  $qry="select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>4 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) echo "selected";?>> <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
          <td width="677" align="right">
		  <!--BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*stok*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->		  </td>
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
          <td id="QTY_STOK" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.*,ak.NAMA,sum(ap.QTY_STOK) as QTY_STOK,sum(floor(ap.QTY_STOK*ap.HARGA_BELI_SATUAN)) as nilai from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter." group by ao.OBAT_ID,ak.ID order by ".$sorting;
	  //echo $sql;
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['QTY_STOK'];?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  $ntotal=0;
	  //$sql="select sum(ap.QTY_STOK*ap.HARGA_BELI_SATUAN) as ntotal from a_penerimaan ap where UNIT_ID_TERIMA=$idunit and STATUS=1 and QTY_STOK>0".$filter;
	  $sql="select sum(floor(ap.QTY_STOK*ap.HARGA_BELI_SATUAN)) as ntotal from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter;
	  //echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['ntotal'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="6" align="center">
            <BUTTON type="button" onClick='PrintArea("idArea","#")' <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak 
            Stok </BUTTON>
          </td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<p align="center"><span class="jdltable">DAFTAR STOK OBAT / ALKES</span> 
      <table width="98%" cellpadding="0" cellspacing="0" border="0">
     		<tr>
          <td width="47">Unit </td>
			  <td>: <?
		  $qry="select * from a_unit where UNIT_ID=$idunit";
		  $exe=mysqli_query($konek,$qry);
		  $show=mysqli_fetch_array($exe); 
		 echo $show['UNIT_NAME'];
		  ?></td>
          <td width="47" align="right">
		  <!--BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*stok*-*')"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON-->		  </td>
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
          <td id="QTY_STOK" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	 /* if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort; */
	  $sql="select ao.*,ak.NAMA,sum(ap.QTY_STOK) as QTY_STOK,sum(floor(ap.QTY_STOK*ap.HARGA_BELI_SATUAN)) as nilai from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter." group by ao.OBAT_ID,ak.ID order by ".$sorting;
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
		/*$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage; */
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['QTY_STOK'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  $ntotal=0;
	   $sql="select sum(floor(ap.QTY_STOK*ap.HARGA_BELI_SATUAN)) as ntotal from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter;
	  //echo $sql;
	  $rs=mysqli_query($konek,$sql);
	  if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['ntotal'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>
	  </table>
	  </div>
</div>
      </td>
    </tr>
  </table>
  </div>
</form>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
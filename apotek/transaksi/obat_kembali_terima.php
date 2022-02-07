<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$no_kirim=$_REQUEST['no_kirim'];
$no_terima=$_REQUEST['no_terima'];
$tgl_terima=$_REQUEST['tgl_terima'];
$tgl_terima1=$tgl_terima;
if ($tgl_terima1!=""){
	$tgl_terima1=explode("-",$tgl_terima1);
	$tgl_terima1=$tgl_terima1[2]."-".$tgl_terima1[1]."-".$tgl_terima1[0];
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
			if ($arfdata[3]==$arfdata[4]){
				$sql="select t1.* from (select * from a_penerimaan where NOKIRIM='$no_kirim' and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$arfdata[1] and TIPE_TRANS=3) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID where t1.OBAT_ID=$arfdata[0] and ap.KEPEMILIKAN_ID=$arfdata[2]";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				while ($rows=mysqli_fetch_array($rs)){
					$cid=$rows['ID'];
					$sql="update a_penerimaan set USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima1',STATUS=1 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}
			}else{
				$selisih=$arfdata[3]-$arfdata[4];
				$sql="select t1.* from (select * from a_penerimaan where NOKIRIM='$no_kirim' and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$arfdata[1] and TIPE_TRANS=3) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID where t1.OBAT_ID=$arfdata[0] and ap.KEPEMILIKAN_ID=$arfdata[2] order by t1.ID desc";
				echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$ok="false";
				while (($rows=mysqli_fetch_array($rs))&&($ok=="false")){
					$cid=$rows['ID'];
					$cid_lama=$rows['ID_LAMA'];
					$cqty=$rows['QTY_STOK'];
					if ($cqty>=$selisih){
						$ok="true";
						$sql="update a_penerimaan set USER_ID_TERIMA=$iduser,NOTERIMA='$no_terima',TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima1',QTY_SATUAN=QTY_SATUAN-$selisih,QTY_STOK=QTY_STOK-$selisih,STATUS=1 where ID=$cid";
						echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid_lama";
						echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}else{
						$selisih=$selisih-$cqty;
						$sql="delete from a_penerimaan where ID=$cid";
						echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cqty where ID=$cid_lama";
						echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}
				}
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($isview==""){
	$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/PKT/$th[2]-$th[1]/%' order by right(NOTERIMA,4) desc limit 1";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_terima2=$rows["NOTERIMA"];
		$arno_terima=explode("/",$no_terima2);
		$tmp=$arno_terima[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_terima2="$kodeunit/PKT/$th[2]-$th[1]/$ctmp";
	}else{
		$no_terima2="$kodeunit/PKT/$th[2]-$th[1]/0001";
	}
}

$sql="select distinct au.UNIT_NAME,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl1,ap.NOTERIMA,date_format(ap.TGL_TERIMA,'%d/%m/%Y') as tgl2 from a_penerimaan ap inner join a_unit au on ap.UNIT_ID_KIRIM=au.UNIT_ID where ap.NOKIRIM='$no_kirim'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$iunit=$rows['UNIT_NAME'];
	$tgl_kirim=$rows['tgl1'];
	$no_terima=$rows['NOTERIMA'];
	$tgl_terima=$rows['tgl2'];
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
    <p align="center"><span class="jdltable">MENERIMA PENGEMBALIAN OBAT YANG DIPINJAM</span></p>
	  
    <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr> 
        <td width="104">No Terima</td>
        <td width="589">: <?php echo $no_terima; ?></td>
        <td width="87">No Kirim</td>
        <td width="181">: <?php echo $no_kirim; ?></td>
      </tr>
      <tr> 
        <td width="104">Tgl Terima</td>
        <td>: <?php echo $tgl_terima; ?></td>
        <td>Tgl Kirim</td>
        <td>: <?php echo $tgl_kirim; ?></td>
      </tr>
      <tr> 
        <td>Unit Pengirim</td>
        <td>: <?php echo $iunit; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td id="NAMA1" width="80" class="tblheader">Kepemilikan Asal</td>
        <td id="qty_terima" width="40" class="tblheader"> Qty Terima</td>
      </tr>
      <?php 
		$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.NOKIRIM,t1.OBAT_ID,sum(t1.qty_kirim) as qty_kirim,t1.KEPEMILIKAN_ID,ak.NAMA,ake.NAMA as NAMA1 from (select NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN as qty_kirim,KEPEMILIKAN_ID from a_penerimaan where NOKIRIM='$no_kirim' group by NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on ap.KEPEMILIKAN_ID=ake.ID group by OBAT_ID,t1.KEPEMILIKAN_ID,ap.KEPEMILIKAN_ID";
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
  <p align="center"><b>Pengembalian Obat Dari Unit : <?php echo $iunit; ?> Sudah 
    Diterima Dengan No Terima : <?php echo $no_terima; ?></b></p>
	<p align="center">
	<a class="navText" href='#' onclick='PrintArea("listma","#")'>
	<BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Pengembalian&nbsp;&nbsp;</BUTTON>
	</a>&nbsp;<BUTTON type="button" onClick="location='?f=../transaksi/list_kembali_terima.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar Pengembalian&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
	<input name="no_kirim" id="no_kirim" type="hidden" value="<?php echo $no_kirim; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<?php if ($isview==""){?>
    <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">MENERIMA PENGEMBALIAN OBAT YANG 
        DIPINJAM </span></p>
	  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="115">No Terima</td>
          <td width="577">: 
            <input name="no_terima" type="text" id="no_terima" size="25" maxlength="30" class="txtcenter" value="<?php echo $no_terima2; ?>" readonly="true"></td>
          <td width="89">No Kirim</td>
          <td width="180">: <?php echo $no_kirim; ?></td>
        </tr>
        <tr> 
          <td width="115">Tgl Terima</td>
          <td>: 
            <input name="tgl_terima" type="text" id="tgl_terima" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_terima,depRange);" /> 
          </td>
          <td>Tgl Kirim</td>
          <td>: <?php echo $tgl_kirim; ?></td>
        </tr>
        <tr> 
          <td>Unit Pengirim</td>
          <td>: <?php echo $iunit; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
          <td id="NAMA1" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan 
            Asal </td>
          <td id="qty_kirim" width="40" class="tblheader" onClick="ifPop.CallFr(this);"> 
            Qty Kirim</td>
          <td width="40" class="tblheader">Qty 
            Terima </td>
          <td class="tblheader" width="30"><input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"<?php if ($isview=="true") echo " disabled"; ?>></td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,ake.NAMA as NAMA1 from (select obat_id,kepemilikan_id,kepemilikan_id_asal,sum(qty_terima-qty_kembali) as qty from a_pinjam_obat where unit_id=$idunit and unit_tujuan=$unit_tujuan and qty_kembali < qty_terima and status=2 group by obat_id,kepemilikan_id,kepemilikan_id_asal) as t1 inner join a_obat ao on t1.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on t1.kepemilikan_id=ak.ID inner join a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID".$filter." order by ".$sorting;
	  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.NOKIRIM,t1.OBAT_ID,sum(t1.qty_kirim) as qty_kirim,t1.KEPEMILIKAN_ID,ap.KEPEMILIKAN_ID as KEPEMILIKAN_ID1,ak.NAMA,ake.NAMA as NAMA1 from (select NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN as qty_kirim,KEPEMILIKAN_ID from a_penerimaan where NOKIRIM='$no_kirim' group by NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on ap.KEPEMILIKAN_ID=ake.ID".$filter." group by OBAT_ID,t1.KEPEMILIKAN_ID,ap.KEPEMILIKAN_ID order by ".$sorting;
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
          <td width="40" align="center" class="tdisi"> 
            <input name="qty_terima" type="text" class="txtcenter" id="qty_terima" value="<?php echo $rows['qty_kirim']; ?>" size="5" maxlength="5"<?php if (($pm=="1")||($pm=="2")) echo " disabled";?>></td>
          <td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox" value="<?php echo $rows['OBAT_ID'].'|'.$rows['KEPEMILIKAN_ID'].'|'.$rows['KEPEMILIKAN_ID1'].'|'.$rows['qty_kirim']; ?>" style="cursor:pointer"></td>
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
            &nbsp;<BUTTON type="reset" onClick="location='?f=../transaksi/list_kembali_terima.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
		<?php }else{?>
	<div id="listma" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  
      <p align="center"><span class="jdltable">DETAIL PENGEMBALIAN OBAT</span></p>
		  
      <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="115">No Terima</td>
          <td width="574">: <?php echo $no_terima; ?></td>
          <td width="89">No Kirim</td>
          <td width="183">: <?php echo $no_kirim; ?></td>
        </tr>
        <tr> 
          <td width="115">Tgl Terima</td>
          <td>: <?php echo $tgl_terima; ?></td>
          <td>Tgl Kirim</td>
          <td>: <?php echo $tgl_kirim; ?></td>
        </tr>
        <tr> 
          <td>Unit Pengirim</td>
          <td>: <?php echo $iunit; ?></td>
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
          <td id="NAMA1" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan 
            Asal </td>
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
		  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,t1.NOKIRIM,t1.OBAT_ID,sum(t1.qty_kirim) as qty_kirim,t1.KEPEMILIKAN_ID,ak.NAMA,ake.NAMA as NAMA1 from (select NOKIRIM,ID_LAMA,OBAT_ID,QTY_SATUAN as qty_kirim,KEPEMILIKAN_ID from a_penerimaan where NOKIRIM='$no_kirim' group by NOKIRIM,ID_LAMA,OBAT_ID,KEPEMILIKAN_ID) as t1 inner join a_penerimaan ap on t1.ID_LAMA=ap.ID inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID inner join a_kepemilikan ake on ap.KEPEMILIKAN_ID=ake.ID".$filter." group by OBAT_ID,t1.KEPEMILIKAN_ID,ap.KEPEMILIKAN_ID order by ".$sorting;
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
            &nbsp;<BUTTON type="button" onClick="location='?f=../transaksi/list_kembali_terima.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
				if ((x[3]*1)<(document.form1.qty_terima[i].value*1)){
					document.form1.qty_terima[i].focus();
					alert("Qty Terima Tidak Boleh Lebih Dari Qty Kirim, Kelebihan Obat Harus Dikembalikan !");
					return false;
				}
				cdata +=document.form1.chkitem[i].value+'|'+document.form1.qty_terima[i].value+'**';
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
		if ((x[3]*1)<(document.form1.qty_terima.value*1)){
			document.form1.qty_terima.focus();
			alert("Qty Terima Tidak Boleh Lebih Dari Qty Kirim, Kelebihan Obat Harus Dikembalikan !");
			return false;
		}
		cdata=document.form1.chkitem.value+'|'+document.form1.qty_terima.value;
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
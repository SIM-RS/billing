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
	//header("Location: ../../index.php");
	//exit();
}
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$no_spph=$_REQUEST['no_spph'];
$tgl_spph=$_REQUEST['tgl_spph'];
$pbf=$_REQUEST['pbf'];
$kp_nama=$_REQUEST['kp_nama'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="spph_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "delete":
		$sql="delete from a_minta_obat where permintaan_id=$minta_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break;
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars');
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php //include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="470">
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="no_spph" id="no_spph" type="hidden" value="<?php echo $no_spph; ?>">
			<input name="tgl_spph" id="tgl_spph" type="hidden" value="<?php echo $tgl_spph; ?>">
			<input name="pbf" id="pbf" type="hidden" value="<?php echo $pbf; ?>">
			<input name="kp_nama" id="kp_nama" type="hidden" value="<?php echo $kp_nama; ?>">
			<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
			<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<!--PRINT OUT -->
			<div id="printOut" style="display:none">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" align="center">
              <tr> 
                <td><b><?=$pemkabRS;?></b></td>
              </tr>
              <tr> 
                <td><b><?=$namaRS;?></b></td>
              </tr>
              <tr> 
                <td class="txtcenter">Alamat : <?=$alamatRS;?>, Kode Pos : <?=$kode_posRS;?>, Telp : <?=$tlpRS;?>, Fax : <?=$faxRS;?>, email : <?=$emailRS;?></td>
              </tr>
              <tr> 
                <td><hr></td>
              </tr>
            </table>
              <p align="center"><span class="jdltable"><b>SURAT PERMINTAAN PENAWARAN 
                HARGA</b></span></p> 
			  <table border="0" cellpadding="1" cellspacing="0" align="center" class="txtinput">
                <tr> 
                  <td width="97">Tgl SPPH</td>
                  <td>: <?php echo $tgl_spph; ?></td>
                </tr>
				<tr> 
                  <td width="97">No SPPH</td>
                  <td>: <?php echo $no_spph; ?></td>
				  </tr>
                <tr>
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?></td>
                </tr>
				  <tr>
				   <td width="97">PBF</td>
                  <td>: <?php echo $pbf; ?></td>
                </tr>
              </table>
              <table width="99%" border="0" cellpadding="1" cellspacing="0" align="center">
                <tr class="headtable"> 
                  <td width="40" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
                    Obat</td>
                  <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
                    Obat</td>
                  <td id="OBAT_SATUAN_KECIL" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan 
                    Besar </td>
                  <td id="qty" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
                  <!--td class="tblheader" width="30">Proses</td-->
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,k.NAMA from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID inner join a_kepemilikan k on s.kepemilikan_id=k.ID where no_spph='$no_spph'".$filter." order by ".$sorting;
			  //echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$i=0;
			  	while ($rows=mysqli_fetch_array($rs)){
				$i++;
			  ?>
                <tr class="itemtable"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
                  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['kemasan']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_kemasan']; ?></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
              </table>
			  <p class="txtinput"  style="padding-right:10px; text-align:right">
			  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tgl_ctk." <b>- User:</b> ".$username; ?>
			  </p><br><br><br><br><br>
              <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>
			  </p>
			 </div>
			<div id="printOut1" style="display:none">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" align="center">
              <tr> 
                <td><b><?=$pemkabRS;?></b></td>
              </tr>
              <tr> 
                <td><b><?=$namaRS;?></b></td>
              </tr>
              <tr> 
                <td class="txtcenter">Alamat : <?=$alamatRS;?>, Kode Pos : <?=$kode_posRS;?>, Telp : <?=$tlpRS;?>, Fax : <?=$faxRS;?>, email : <?=$emailRS;?></td>
              </tr>
              <tr> 
                <td><hr></td>
              </tr>
            </table>
              <p align="center"><span class="jdltable"><b>PERENCANAAN PENGADAAN 
                OBAT</b></span></p> 
			  <table border="0" cellpadding="1" cellspacing="0" align="center" class="txtinput">
                <tr> 
                  <td width="100">Tgl SPPH</td>
                  <td>: <?php echo $tgl_spph; ?></td>
                </tr>
				<tr> 
                  <td width="100">No SPPH</td>
                  <td>: <?php echo $no_spph; ?></td>
				  </tr>
                <tr>
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?></td>
                </tr>
				  <tr>
				   <td width="100">PBF</td>
                  <td>: <?php echo $pbf; ?></td>
                </tr>
              </table>
              <table width="99%" border="0" cellpadding="1" cellspacing="0" align="center">
                <tr class="headtable"> 
                  <td width="40" height="25" class="tblheaderkiri">No</td>
                  <td width="80" class="tblheader">Kode Obat</td>
                  <td class="tblheader">Nama Obat</td>
                  <td width="200" class="tblheader">Keterangan</td>
                  <td width="80" class="tblheader">Kemasan Besar</td>
                  <td width="50" class="tblheader">Qty</td>
                  <td width="90" class="tblheader">Pagu</td>
                  <td width="100" class="tblheader">Sub Total</td>
                </tr>
                <?php 
			  $sql="select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,s.ket,s.status,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$no_spph'".$filter." order by ".$sorting;
			  //echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$i=0;
			  	while ($rows=mysqli_fetch_array($rs)){
				$i++;
			  ?>
                <tr class="itemtable"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
                  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="left" style="font-size:12px;">&nbsp;<?php echo $rows['ket']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['kemasan']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty_kemasan']; ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['pagu'],0,",","."); ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['stotal'],0,",","."); ?></td>
                </tr>
                <?php 
			  }
			  $sql="select sum(t1.stotal) as total from (select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$no_spph'".$filter.") as t1";
			  $rs=mysqli_query($konek,$sql);
			  $total=0;
			  if ($rows=mysqli_fetch_array($rs)) $total=$rows['total'];
			  mysqli_free_result($rs);
			  ?>
                <tr> 
                  <td colspan="7" align="right" class="txtright">Total&nbsp;:</td>
                  <td class="txtright"><?php echo number_format($total,0,",","."); ?></td>
                </tr>
              </table>
			  <p class="txtinput"  style="padding-right:10px; text-align:right">
			  <?php echo "<b>&raquo; Tgl Cetak:</b> ".$tgl_ctk." <b>- User:</b> ".$username; ?>
			  </p><br><br><br><br><br>
              <p class="txtinput"  style="padding-right:50px; text-align:right">
			  <b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>
			  </p>
			 </div>
			<!-- PRINT OUT BERAKHIR -->
			<div id="listma" style="display:block">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  <p align="center"><span class="jdltable"><b>SURAT PERMINTAAN PENAWARAN 
                HARGA</b></span></p> 
			  <table border="0" cellpadding="1" cellspacing="0" class="txtinput">
                <tr> 
                  <td width="99">Tgl SPPH</td>
                  <td>: <?php echo $tgl_spph; ?></td>
                </tr>
                <tr> 
                  <td width="99">No SPPH</td>
                  <td>: <?php echo $no_spph; ?></td>
                </tr>
                <tr>
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?></td>
                </tr>
                <tr> 
                  <td width="99">PBF</td>
                  <td>: <?php echo $pbf; ?></td>
                </tr>
              </table>
			  <table width="99%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="34" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
                    Obat</td>
                  <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
                    Obat</td>
                  <td width="200" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Keterangan</td>
                  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kemasan 
                    Besar </td>
                  <td id="qty_kemasan" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Qty</td>
                  <td id="pagu" width="90" class="tblheader" onClick="ifPop.CallFr(this);">Pagu</td>
                  <td id="stotal" width="100" class="tblheader">Sub Total </td>
                  <!--td class="tblheader" width="30">Proses</td-->
                </tr>
                <?php 
			  $sql="select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,s.ket,s.status,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$no_spph'".$filter." order by ".$sorting;
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
                  <td class="tdisikiri" align="center"><?php echo $i; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
                  <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="left">&nbsp;<?php echo $rows['ket']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['kemasan']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['qty_kemasan']; ?></td>
                  <td class="tdisi" align="right"><?php echo number_format($rows['pagu'],0,",","."); ?></td>
                  <td class="tdisi" align="right"><?php echo number_format($rows['stotal'],0,",","."); ?></td>
                </tr>
                <?php 
			  }
			  //$sql="SELECT SUM(qty_kemasan*pagu) AS total FROM a_spph WHERE no_spph='$no_spph'".$filter;
			  $sql="select sum(t1.stotal) as total from (select o.OBAT_KODE,o.OBAT_NAMA,s.kemasan,s.qty_kemasan,s.pagu,(s.qty_kemasan * s.pagu) as stotal from a_spph s inner join a_obat o on s.obat_id=o.OBAT_ID where s.no_spph='$no_spph'".$filter.") as t1";
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $total=0;
			  if ($rows=mysqli_fetch_array($rs)) $total=$rows['total'];
			  mysqli_free_result($rs);
			  ?>
                <tr> 
                  <td colspan="7" class="txtright">Total&nbsp;:</td>
                  <td class="txtright"><?php echo number_format($total,0,",","."); ?></td>
                </tr>
              </table>
			</div>
			<table width="989" border="0">
			    <tr> 
                  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;                  </td>
                </tr>
			</table>
			<p align="center">
              <BUTTON type="button" onClick="PrintArea('printOut','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak SPPH&nbsp;&nbsp;</BUTTON>
              <BUTTON type="button" onClick="PrintArea('printOut1','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Perencanaan&nbsp;&nbsp;</BUTTON>
            <BUTTON type="button" onClick="location='?f=../mc/spph.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          	</p>
		</form>
		</div>	</td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>
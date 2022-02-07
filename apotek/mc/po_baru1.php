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
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_spph=$_REQUEST['no_spph'];
$no_po=$_REQUEST['no_po'];
$cmbPemeriksa=$_REQUEST['cmbPemeriksa'];
if ($cmbPemeriksa==2) $Pemeriksa="Pejabat"; else $Pemeriksa="Panitia";
$tgl_po=$_REQUEST['tgl_po'];
if ($tgl_po=="") $tgl_po=$tgl;
$th=explode("-",$tgl_po);
$tgl2="$th[2]-$th[1]-$th[0]";
$isview=$_REQUEST['isview'];
$h_tot=$_REQUEST['h_tot'];
$disk_tot=$_REQUEST['disk_tot'];
$h_diskon=$_REQUEST['h_diskon'];
$ppn=$_REQUEST['ppn'];
$total=$_REQUEST['total'];
$pbf_id=$_REQUEST['pbf_id'];
$updt_harga=$_REQUEST['updt_harga'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
if (($_REQUEST['chk_ppn']=="") || ($_REQUEST['chk_ppn']=="0")) $chk_ppn=0; else $chk_ppn=1;
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_spph.spph_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
 	case "save":
		$fdata=$_REQUEST['fdata'];
		$sql="select * from a_po where NO_PO='$no_po'";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$tmpuser=0;
		if ($rows=mysqli_fetch_array($rs)){
			$tmpuser=$rows["USER_ID"];
			if ($tmpuser!=$iduser){
				$sql="select NO_PO from a_po where NO_PO like '$kodeunit/PO/$th[2]-$th[1]/%' order by NO_PO desc limit 1";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
				if ($rows1=mysqli_fetch_array($rs1)){
					$no_po=$rows1["NO_PO"];
					$arno_po=explode("/",$no_po);
					$tmp=$arno_po[3]+1;
					$ctmp=$tmp;
					for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
					$no_po="$kodeunit/PO/$th[2]-$th[1]/$ctmp";
				}else{
					$no_po="$kodeunit/PO/$th[2]-$th[1]/0001";
				}
			}
		}
		
		if ($tmpuser!=$iduser){
			$arfvalue=explode("**",$fdata);
			for ($j=0;$j<count($arfvalue);$j++){
				$arfdata=explode("|",$arfvalue[$j]);
				$sql="insert into a_po(OBAT_ID,FK_SPPH_ID,PBF_ID,KEPEMILIKAN_ID,USER_ID,NO_PO,TANGGAL_ACT,TANGGAL,QTY_KEMASAN,KEMASAN,HARGA_KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_PAKAI,SATUAN,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,NILAI_PAJAK,UPDT_H_NETTO,JENIS,TERMASUK_PPN,STATUS) values($arfdata[1],$arfdata[0],$pbf_id,$arfdata[2],$iduser,'$no_po','$tgl_act','$tgl2',$arfdata[3],'$arfdata[4]',$arfdata[5],$arfdata[6],$arfdata[7],$arfdata[3],'$arfdata[8]',$h_tot,$arfdata[9],$arfdata[11],$disk_tot,$ppn,$updt_harga,0,$chk_ppn,0)";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
			}
			$sql="update a_spph set status=1 where no_spph='$no_spph'";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$sql="INSERT INTO a_po_pemeriksa(pemeriksa_tipe,no_po,tgl,user_act) 
				VALUES('$cmbPemeriksa','$no_po','$tgl2','$iduser')";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
if ($act!="save"){
	$sql="select NO_PO from a_po where NO_PO like '$kodeunit/PO/$th[2]-$th[1]/%' order by NO_PO desc limit 1";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$no_po=$rows["NO_PO"];
		$arno_po=explode("/",$no_po);
		$tmp=$arno_po[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_po="$kodeunit/PO/$th[2]-$th[1]/$ctmp";
	}else{
		$no_po="$kodeunit/PO/$th[2]-$th[1]/0001";
	}
}

$sql="SELECT DISTINCT p.PBF_ID,p.PBF_NAMA,k.ID,k.NAMA FROM a_spph s INNER JOIN a_pbf p ON s.pbf_id=p.PBF_ID INNER JOIN a_kepemilikan k ON s.kepemilikan_id=k.ID WHERE s.no_spph='$no_spph'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$pbf=$rows['PBF_NAMA'];
	$pbf_id=$rows['PBF_ID'];
	$kp_id=$rows['ID'];
	$kp_nama=$rows['NAMA'];
}

$sql1="select distinct HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,NILAI_PAJAK,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL from a_po where NO_PO='$no_po'";
//echo $sql1;
$rs1=mysqli_query($konek,$sql1);
if ($rows=mysqli_fetch_array($rs1)){
	$h_tot=$rows['HARGA_BELI_TOTAL'];
	$diskon_tot=$rows['DISKON_TOTAL'];
	$h_diskon=$rows['H_DISKON'];
	$ppn=$rows['NILAI_PAJAK'];
	$total=$rows['TOTAL'];
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
	function PrintArea(printArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
  <?php //include("header.php");?>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="470">
	<?php if ($act=="save"){?>
	<div align="center">
	<div id="printArea" style="display:none">
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
			  <p align="center"><span class="jdltable"><b>SURAT PEMESANAN</b></span></p>
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
              <tr> 
                <td width="90">Tgl PO</td>
                <td width="168">: <?php echo $tgl_po; ?></td>
                <td width="171">Harga Total</td>
                <td width="140">: <?php echo number_format($h_tot,2,",","."); ?></td>
                <td width="96">PPN (10%)</td>
                <td width="126">: <?php echo number_format($ppn,2,",","."); ?></td>
              </tr>
              <tr> 
                <td width="90">No PO</td>
                <td>: <?php echo $no_po; ?></td>
                <td>Diskon Total</td>
                <td>: <?php echo number_format($diskon_tot,2,",","."); ?></td>
                <td>T O T A L</td>
                <td>: <?php echo number_format($total,2,",","."); ?></td>
              </tr>
              <tr> 
                <td>No SPPH</td>
                <td>: <?php echo $no_spph; ?></td>
                <td>Harga Setelah Diskon</td>
                <td>: <?php echo number_format($h_diskon,2,",","."); ?></td>
                <td colspan="2"><?php if ($chk_ppn==1) echo "Harga Sudah Termasuk PPN (10%)"; else echo "&nbsp;"; ?></td>
              </tr>
              <tr> 
                <td>PBF</td>
                <td>: <?php echo $pbf; ?></td>
                <td>Kepemilikan</td>
                <td>: <?php echo $kp_nama; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Pemeriksa</td>
                <td>: <?php echo $Pemeriksa; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
	      <table width="100%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="30" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_KODE" width="60" class="tblheader">Kode 
                    Obat</td>
                  <td id="OBAT_NAMA" class="tblheader">Nama 
                    Obat</td>
                  <td id="NAMA" width="60" class="tblheader"> 
                    <p>Kepemilikan</p></td>
                  <td id="qty_kemasan" width="30" class="tblheader"> 
                    <p>Qty Ke masan </p></td>
                  <td id="kemasan" width="60" class="tblheader">Kemasan</td>
                  <td width="40" class="tblheader">Harga 
                    Kemasan </td>
                  <td width="40" class="tblheader">Isi 
                    / Ke masan</td>
                  <td width="40" class="tblheader">Qty 
                    Satuan </td>
                  <td width="60" class="tblheader">Satuan</td>
                  <td width="50" class="tblheader">Harga 
                    Satuan </td>
                  <td width="60" class="tblheader">Sub 
                    Total </td>
                  <td width="30" class="tblheader">Disk 
                    (%) </td>
                  <td width="50" class="tblheader">Diskon 
                    (Rp) </td>
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po' AND PBF_ID=$pbf_id order by a_po.ID";
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $i=0;
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
				$kemasan=$rows['kemasan'];
				$satuan=$rows['satuan'];
				$qty_kemasan=$rows['qty_kemasan'];
				$spph_id=$rows['spph_id'];
				$obat_id=$rows['obat_id'];
			  ?>
                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
                  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_KEMASAN']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['KEMASAN']; ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_PER_KEMASAN']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_SATUAN']; ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['SATUAN']; ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['subtotal'],2,",","."); ?></td>
                  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['DISKON']; ?></td>
                  <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?></td>
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
          <p align="center">Surat Pesanan Dgn No PO : <?php echo $no_po; ?> 
            Sudah Disimpan</p>
			<p align="center">
            <BUTTON type="button" onClick="PrintArea('printArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak PO&nbsp;&nbsp;</BUTTON>
			&nbsp;<BUTTON type="button" onClick="location='?f=../mc/po.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar PO&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
			style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">		</iframe>
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="fdata" id="fdata" type="hidden" value="">
			<input name="updt_harga" id="updt_harga" type="hidden" value="0">
			<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
			<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
			<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<div id="listma" style="display:block">
			  <p align="center"><span class="jdltable"><b>SURAT PEMESANAN</b></span></p>
			  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
                <tr> 
                  <td width="90">No PO</td>
                  <td width="270">: 
                    <input name="no_po" type="text" id="no_po" size="25" maxlength="30" class="txtcenter" readonly="true" value="<?php echo $no_po; ?>"></td>
                  <td width="146">Harga Total</td>
                  <td width="160">: 
                    <input name="h_tot" type="text" class="txtright" id="h_tot" value="0" size="15" readonly="true"></td>
                  <td width="109">PPN (10%)</td>
                  <td width="203">: 
                    <input name="ppn" type="text" class="txtright" id="ppn2" value="0" size="15" readonly="true"></td>
                </tr>
                <tr> 
                  <td width="90">Tgl PO</td>
                  <td>: 
                    <input name="tgl_po" type="text" id="tgl_po" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_po; ?>"> 
                    <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_po,depRange);" />                  </td>
                  <td>Diskon Total</td>
                  <td>: 
                    <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="0" size="15" readonly="true"></td>
                  <td>T O T A L</td>
                  <td>: 
                    <input name="total" type="text" class="txtright" id="total" value="0" size="15" readonly="true"></td>
                </tr>
                <tr> 
                  <td>No SPPH</td>
                  <td>: 
                    <select name="no_spph" id="no_spph" class="txtinput" onChange="location='?f=../mc/po_baru.php&no_spph='+no_spph.value">
                      <option value="" class="txtinput">Pilih SPPH</option>
                      	<?php
						  $qry="select distinct no_spph from a_spph where status=0 and bisa=1 order by no_spph";
						  $exe=mysqli_query($konek,$qry);
						  while($show=mysqli_fetch_array($exe)){ 
						?>
                      <option value="<?php echo $show['no_spph']; ?>" class="txtinput"<?php if ($no_spph==$show['no_spph']) echo " selected";?>><?php echo $show['no_spph']; ?></option>
                      <?php }?>
                    </select></td>
                  <td>Harga Setelah Diskon</td>
                  <td>: 
                    <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="0" size="15" readonly="true"></td>
                  <td colspan="2"><input name="chk_ppn" type="checkbox" id="chk_ppn" value="0" onClick="HitunghTot();if (this.checked){this.value='1'}else{this.value='0'};">
                    Harga Sudah Termasuk PPN (10%)</td>
                </tr>
                <tr> 
                  <td>PBF</td>
                  <td>: <?php echo $pbf; ?> <input name="pbf_id" id="pbf_id" value="<?php echo $pbf_id; ?>" type="hidden"></td>
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?> <input name="kepemilikan_id" id="kepemilikan_id" value="<?php echo $kp_id; ?>" type="hidden"></td>
                  <td colspan="2"><input name="chk_updt" type="checkbox" id="chk_updt" value="">
                    Update Harga Pokok</td>
                </tr>
                <tr>
                  <td>Pemeriksa</td>
                  <td>: 
                    <select name="cmbPemeriksa" id="cmbPemeriksa" class="txtinput">
                      <option value="1" class="txtinput">Panitia</option>
                      <option value="2" class="txtinput">Pejabat</option>
                    </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
			  <table width="100%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="30" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
                  <td id="qty_kemasan" width="40" class="tblheader"> 
                    <p>Qty Ke masan </p></td>
                  <td id="kemasan" width="60" class="tblheader">Kemasan</td>
                  <td width="40" class="tblheader">Harga Kemasan </td>
                  <td width="40" class="tblheader">Isi / Ke masan</td>
                  <td width="40" class="tblheader">Qty Satuan </td>
                  <td width="60" class="tblheader">Satuan</td>
                  <td width="50" class="tblheader">Harga Satuan </td>
                  <td width="60" class="tblheader">Sub Total </td>
                  <td width="30" class="tblheader">Disk (%) </td>
                  <td width="50" class="tblheader">Diskon (Rp) </td>
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select a_spph.*,o.OBAT_KODE,o.OBAT_NAMA,o.OBAT_SATUAN_KECIL,k.NAMA from a_spph inner join a_obat o on a_spph.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_spph.KEPEMILIKAN_ID=k.ID where a_spph.no_spph='$no_spph' and a_spph.bisa=1".$filter." order by ".$sorting;
			  //echo $sql."<br>";
/*				$rs=mysqli_query($konek,$sql);
				$jmldata=mysqli_num_rows($rs);
				if ($page=="" || $page=="0") $page="1";
				$perpage=50;$tpage=($page-1)*$perpage;
				if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
				if ($page>1) $bpage=$page-1; else $bpage=1;
				if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
				$sql=$sql." limit $tpage,$perpage";*/
				//echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $i=0;
			  //$i=($page-1)*$perpage;
		//	  $arfvalue="";
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
				$kemasan=$rows['kemasan'];
				$satuan=$rows['satuan'];
				$qty_kemasan=$rows['qty_kemasan'];
				$spph_id=$rows['spph_id'];
				$obat_id=$rows['obat_id'];
			  ?>
                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="left"><input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>">
                    <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>">
                    <?php echo $rows['OBAT_NAMA']; ?></td>
                  <td width="40" align="center" class="tdisi"> 
                    <input name="qty_kemasan" type="text" id="qty_kemasan" class="txtcenter" size="4" value="<?php echo $qty_kemasan; ?>" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);" autocomplete="off">
                  </td>
                  <td width="60" align="center" class="tdisi"> 
                    <input name="kemasan" id="kemasan" size="7" value="<?php echo $rows['kemasan'] ;?>"></td>
                  <td width="40" align="center" class="tdisi">
<input name="h_kemasan" type="text" class="txtright" id="h_kemasan2" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="" size="8" autocomplete="off">
                  </td>
                  <td width="40" align="center" class="tdisi">
<input name="qty_per_kemasan" type="text" class="txtcenter" id="qty_per_kemasan" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="" size="4" autocomplete="off">
                  </td>
                  <td width="40" align="center" class="tdisi">
<input name="qty_satuan" type="text" class="txtcenter" id="qty_satuan" onKeyUp="" value="0" size="5" autocomplete="off" readonly="true">
                  </td>
                  <td width="60" align="center" class="tdisi"> 
                    <input name="satuan" id="satuan" value="<?php echo $rows['OBAT_SATUAN_KECIL'];?>" type="text" size="7">
                  </td>
                  <td width="50" align="center" class="tdisi">
<input name="h_satuan" type="text" class="txtright" id="h_satuan" onKeyUp="" value="0" size="8" autocomplete="off" readonly="true">
                  </td>
                  <td width="60" align="center" class="tdisi">
<input name="sub_tot" type="text" class="txtright" id="sub_tot" onKeyUp="" value="0" size="8" readonly="true">
                  </td>
                  <td width="30" align="center" class="tdisi"> 
                    <input name="diskon" type="text" class="txtcenter" id="diskon" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,1);" value="0" size="3" autocomplete="off"></td>
                  <td width="50" align="center" class="tdisi"> 
                    <input name="diskon_rp" type="text" class="txtright" id="diskon_rp" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,2);" value="0" size="7" autocomplete="off"></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
                <!--tr> 
                  <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
                  <td colspan="10" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
                  </td>
                </tr-->
              </table>
			</div>
				<p align="center">
              		<BUTTON type="button" onClick="if (ValidateForm('no_po','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</BUTTON>
					<BUTTON type="reset" onClick="location='?f=../mc/po.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
		    </p>
		</form>
		</div>
		<?php 
		}
		?>	</td>
</tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</body>
<script>
function HitungQtySatuan(i){
	if (document.form1.obat_id.length){
		if ((document.form1.qty_kemasan[i].value=="")||(document.form1.qty_kemasan[i].value=="0")||(document.form1.qty_per_kemasan[i].value=="")||(document.form1.qty_per_kemasan[i].value=="0")){
			document.form1.qty_satuan[i].value="0";
		}else{
			document.form1.qty_satuan[i].value=(document.form1.qty_kemasan[i].value*1)*(document.form1.qty_per_kemasan[i].value*1);
		}
	}else{
		if ((document.form1.qty_kemasan.value=="")||(document.form1.qty_kemasan.value=="0")||(document.form1.qty_per_kemasan.value=="")||(document.form1.qty_per_kemasan.value=="0")){
			document.form1.qty_satuan.value="0";
		}else{
			document.form1.qty_satuan.value=(document.form1.qty_kemasan.value*1)*(document.form1.qty_per_kemasan.value*1);
		}
	}
}

function HitungSubTotal(i){
	if (document.form1.obat_id.length){
		document.form1.sub_tot[i].value=(document.form1.qty_kemasan[i].value*1)*(document.form1.h_kemasan[i].value*1);
	}else{
		document.form1.sub_tot.value=(document.form1.qty_kemasan.value*1)*(document.form1.h_kemasan.value*1);
	}
	HitunghTot();
}

function HitungHargaSatuan(i){
var tmp;
	if (document.form1.obat_id.length){
		if ((document.form1.h_kemasan[i].value=="")||(document.form1.h_kemasan[i].value=="0")||(document.form1.qty_per_kemasan[i].value=="")||(document.form1.qty_per_kemasan[i].value=="0")){
			document.form1.h_satuan[i].value="0";
		}else{
			tmp=(document.form1.h_kemasan[i].value*1)/(document.form1.qty_per_kemasan[i].value*1);
			document.form1.h_satuan[i].value=tmp.toFixed(2)*1;
		}
	}else{
		if ((document.form1.h_kemasan.value=="")||(document.form1.h_kemasan.value=="0")||(document.form1.qty_per_kemasan.value=="")||(document.form1.qty_per_kemasan.value=="0")){
			document.form1.h_satuan.value="0";
		}else{
			tmp=(document.form1.h_kemasan.value*1)/(document.form1.qty_per_kemasan.value*1);
			document.form1.h_satuan.value=tmp.toFixed(2)*1;
		}
	}
}

function HitunghTot(){
var tmp=0;
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			tmp +=(document.form1.sub_tot[i].value*1);
		}
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.sub_tot.value*1);
		document.form1.h_tot.value=tmp.toFixed(2)*1;
	}
	tmp=tmp-(document.form1.disk_tot.value*1);
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.chk_ppn.checked==true){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitunghDiskonTot(){
var tmp=0;
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			tmp +=(document.form1.diskon_rp[i].value*1);
		}
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.diskon_rp.value*1);
		document.form1.disk_tot.value=tmp.toFixed(2)*1;
	}
	tmp=(document.form1.h_tot.value*1)-tmp;
	document.form1.h_diskon.value=tmp.toFixed(2)*1;
	if (document.form1.chk_ppn.checked==true){
		tmp=0;
	}else{
		tmp=tmp*10/100;
	}
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitungDiskon(i,j){
var tmp;
	if (document.form1.obat_id.length){
		if (j==1){
			if ((document.form1.sub_tot[i].value=="")||(document.form1.sub_tot[i].value=="0")||(document.form1.diskon[i].value=="")||(document.form1.diskon[i].value=="0")){
				document.form1.diskon_rp[i].value="0";
			}else{
				tmp=((document.form1.sub_tot[i].value*1)*(document.form1.diskon[i].value*1))/100;
				document.form1.diskon_rp[i].value=tmp.toFixed(1)*1;
			}
		}else{
			if ((document.form1.diskon_rp[i].value=="")||(document.form1.diskon_rp[i].value=="0")||(document.form1.sub_tot[i].value=="")||(document.form1.sub_tot[i].value=="0")){
				document.form1.diskon[i].value="0";
			}else{
				tmp=((document.form1.diskon_rp[i].value*1)*100/(document.form1.sub_tot[i].value*1));
				document.form1.diskon[i].value=tmp.toFixed(2)*1;
			}
		}
	}else{
		if (j==1){
			if ((document.form1.diskon.value=="")||(document.form1.diskon.value=="0")||(document.form1.sub_tot.value=="")||(document.form1.sub_tot.value=="0")){
				document.form1.diskon_rp[i].value="0";
			}else{
				tmp=((document.form1.sub_tot.value*1)*(document.form1.diskon.value*1))/100;
				document.form1.diskon_rp.value=tmp.toFixed(2)*1;
			}
		}else{
			if ((document.form1.diskon_rp.value=="")||(document.form1.diskon_rp.value=="0")||(document.form1.sub_tot.value=="")||(document.form1.sub_tot.value=="0")){
				document.form1.diskon.value="0";
			}else{
				tmp=((document.form1.diskon_rp.value*1)*100/(document.form1.sub_tot.value*1));
				document.form1.diskon.value=tmp.toFixed(2)*1;
			}
		}
	}
	HitunghDiskonTot();
}

function fSubmit(){
var cdata='';
var x;
	if (document.form1.chk_updt.checked==true){
		document.form1.updt_harga.value=1;
	}else{
		document.form1.updt_harga.value=0;
	}
	//alert(document.form1.updt_harga.value);	
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			cdata +=document.form1.spph_id[i].value+'|'+document.form1.obat_id[i].value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'**';
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Isi Item Obat Yg Mau Dibuat PO Terlebih Dahulu !");
			return false;
		}
	}else{
		if ((document.form1.qty_kemasan.value=='')||(document.form1.h_kemasan.value=='')||(document.form1.qty_per_kemasan.value=='')||(document.form1.qty_satuan.value=='')||(document.form1.h_satuan.value=='')||(document.form1.sub_tot.value=='')||(document.form1.diskon.value=='')||(document.form1.diskon_rp.value=='')){
			alert("Pengisian Form Belum Lengkap !");
			return false;
		}
		
		cdata +=document.form1.spph_id.value+'|'+document.form1.obat_id.value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.qty_kemasan.value+'|'+document.form1.kemasan.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.qty_per_kemasan.value+'|'+document.form1.qty_satuan.value+'|'+document.form1.satuan.value+'|'+document.form1.h_satuan.value+'|'+document.form1.sub_tot.value+'|'+document.form1.diskon.value+'|'+document.form1.diskon_rp.value;
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
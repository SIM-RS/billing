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
$arrCBayar =  array(1 => 'Tunai', 2 => 'Kredit', 3 => 'Uang Muka');
$arrTObat =  array(0 => 'Reguler', 1 => 'BPJS');



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
$tgl_ctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_po=$_REQUEST['no_po'];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];

$sql = "select u.nama,u.no_sipa from a_user u inner join a_po p on u.kode_user=p.user_id where p.no_po = '$no_po'";
$sql1=mysqli_query($konek,$sql);
$sql2=mysqli_fetch_array($sql1);
$apoteker=$sql2['nama'];
$no_sipa=$sql2['no_sipa'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="a_po.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
/*
switch ($act){
 	case "save":
		$fdata=$_REQUEST['fdata'];
		$arfvalue=explode("**",$fdata);
		for ($j=0;$j<count($arfvalue);$j++){
			$arfdata=explode("|",$arfvalue[$j]);
			$sql="insert into a_po(OBAT_ID,FK_SPPH_ID,PBF_ID,KEPEMILIKAN_ID,USER_ID,NO_PO,TANGGAL_ACT,TANGGAL,QTY_KEMASAN,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,SATUAN,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,NILAI_PAJAK,JENIS,STATUS) values($arfdata[1],$arfdata[0],$pbf_id,$arfdata[2],$iduser,'$no_po','$tgl_act','$tgl2',$arfdata[3],'$arfdata[4]',$arfdata[6],$arfdata[7],'$arfdata[8]',$h_tot,$arfdata[9],$arfdata[11],$disk_tot,$ppn,0,0)";
			echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
		$sql="update a_spph set status=1 where no_spph='$no_spph'";
		$rs=mysqli_query($konek,$sql);

		break;
}
*/
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select distinct NO_PO,date_format(TANGGAL,'%d-%m-%Y') as tgl1,HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL,NILAI_PAJAK,PBF_NAMA,PBF_ALAMAT,PBF_TELP,no_spph,k.NAMA, cara_bayar_po, uang_muka 
from a_po left join a_spph on a_po.FK_SPPH_ID=a_spph.spph_id
 inner join a_pbf on a_po.PBF_ID=a_pbf.PBF_ID
 inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.no_po='$no_po'";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$no_spph=$rows["no_spph"];
	$tgl_po=$rows["tgl1"];
	$h_tot=$rows["HARGA_BELI_TOTAL"];
	$diskon_tot=$rows["DISKON_TOTAL"];
	$h_diskon=$rows["H_DISKON"];
	$total=$rows["TOTAL"];
	$ppn=$rows["NILAI_PAJAK"];
	$pbf=$rows["PBF_NAMA"];
	$pbf_alamat=$rows["PBF_ALAMAT"];
	$pbf_telp=$rows["PBF_TELP"];
	$kp_nama=$rows["NAMA"];
	$cara_bayar_po = $rows['cara_bayar_po'];
	$uangMuka = $rows['uang_muka'];
	
	$sql="SELECT * FROM a_po_pemeriksa WHERE no_po='$no_po'";
	$rs1=mysqli_query($konek,$sql);
	$rw1=mysqli_fetch_array($rs1);
	$pemeriksa=$rw1["pemeriksa_tipe"];
	if ($pemeriksa==2) $pemeriksa="Pejabat"; else $pemeriksa="Panitia";
}
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script>
	function PrintArea(printOut,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(printOut).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<style>
.txtcenterpo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	vertical-align: middle;
}
</style>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<div align="center">
<?php //include("header.php");?>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="450">
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
			<input name="updt_harga" id="updt_harga" type="hidden" value="0">
			<input name="pbf_id" id="pbf_id" type="hidden" value="<?php echo $pbf_id; ?>">
			<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
			<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<!--PRINT OUT-->
			<div id="printOut" align="center" style="display:none">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse;" >
              <tr>
                <td colspan="4" align="center">&nbsp;&nbsp;<img src="../images/logo.png" width="39" style="vertical-align:middle;" height="33"><b>
                 &nbsp; <?=$namaRS;?>
                </b></td>
                </tr>
              <tr align="left">
                <td width="29%">&nbsp;</td>
                <td width="16%">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td width="52%" align="left">&nbsp;</td>
                </tr>
              <tr align="left">
                <td>&nbsp;</td> 
                <td>Nama Sarana</td>
                <td width="3%" align="left">:</td>
                <td align="left">Instalasi Farmasi
                  <?=$namaRS;?>                </td>
                </tr>
              <tr align="left">
                <td>&nbsp;</td>
                <td>No. SIPA </td>
                <td align="left">:</td>
                <td align="left"><?=$no_sipa;?>                </td>
                </tr>
              <tr align="left">
                <td>&nbsp;</td>
                <td>Alamat/Telp</td>
                <td align="">:</td>
                <td align="left"> <?=$alamatRS;?> &nbsp;Belawan                </td>
                </tr>
              <tr align="left">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td  align="left">Telp :
                    &nbsp;<?=$tlpRS;?>
, Fax :
<?=$faxRS;?>                </td>
                </tr>
              <tr align="left">
                <td>&nbsp;</td>
                <td>Nama Apoteker</td>
                <td>:</td>
                <td><b><? echo $apoteker; ?></b></td>
                </tr>
              
              
              <tr> 
                <td colspan="4"><hr></td>
              </tr>
            </table>
			  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                  <td width="481">&nbsp;</td>
                  <td width="143">&nbsp;</td>
                  <td width="7">&nbsp;</td>
                  <td width="85" class="txtright">&nbsp;</td>
                </tr>
                <tr>
                  <td><b>Kepada Yth : </b></td>
                  <td colspan="3" align="right"><b>Belawan, <?php echo $tgl_po; ?></b></td>
                </tr>
                <tr>
                  <td><b><?php echo $pbf; ?></b></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="txtright">&nbsp;</td>
                </tr>
                <tr>
                  <td><?php echo $pbf_alamat; ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="txtright">&nbsp;</td>
                </tr>
                <tr>
                  <td>Telp/Fax : <?php echo $pbf_telp; ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="txtright">&nbsp;</td>
                </tr>

                <?php if($cara_bayar_po == 3){ ?>

                <?php } ?>
                <!--tr>
					<td>Unit</td>
					<td>: <?php //echo $nunit; ?></td>
				</tr-->
              </table>
			  <p align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; "><b><u>SURAT PEMESANAN</u></b></br>
			 No :  <?php echo $no_po; ?></p> 
			  <table width="99%" border="1" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse;">
                <tr  style="text-align:center; font-weight:bold;"> 
                  <td width="32" height="25" >No</td>
                  <td width="369"  id="OBAT_NAMA">Nama Obat</td>
                  <td id="qty_kemasan" width="73" >Jenis</td>
                  <td id="kemasan" width="147" >Jumlah Pesanan </td>
                  <td width="79" >Harga Kemasan </td>
                  <td width="59" >Sub Total </td>
                  <td width="102" >Disk (%) </td>
                  <td width="49" >Total </td>
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po'".$filter." order by ".$sorting;
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
                <tr > 
                  <td align="center"><?php echo $i; ?></td>
                  <td align="left" >
					<?php echo $rows['OBAT_NAMA']; ?>				  </td>
                  <td align="center" ><?php if($rows['OBAT_TYPE']==1){echo "BPJS";}else{echo "REGULER";} ?></span></td>
                  <td  align="center"><?php echo $rows['QTY_KEMASAN']; ?>&nbsp;<?php echo $rows['KEMASAN']; ?>&nbsp;@ &nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?>&nbsp;<?php echo $rows['SATUAN']; ?></td>
                  <td align="right" ><?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
                  <td align="right" ><?php echo number_format($rows['subtotal'],2,",","."); ?></td>
                  <td align="right" ><?php echo $rows['DISKON']; ?>%&nbsp;(<?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?>)</td>
                  <td align="right" >
                    <?php 
				  
				  echo number_format(
				  
				  (
				  	$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100)
				)
				  
				  ,2,",","."); ?>                 </td>
                </tr>
                <?php 
				$t_subtotal +=$rows['subtotal'];
				$t_diskon +=(($rows['subtotal']*$rows['DISKON'])/100);
				$t_total +=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
			     }
			        mysqli_free_result($rs);
			  
			  	?>
						  
			 <tr>
                  <td colspan="5" align="right">Total : </td>
                  <td  align="right"><?php echo number_format($t_subtotal,2,",","."); ?></td>
                  <td align="right" ><?php echo number_format($t_diskon,2,",","."); ?></td>
                  <td align="right" >
                  <?php 
				  
				  echo number_format($t_total,2,",","."); ?>                 </td>
                </tr>
              </table>
			   <table width="99%" border="0" cellpadding="3" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                 <tr>
                   <td colspan="3">&nbsp;</td>
                   <td width="119">&nbsp;</td>
                   <td width="6">&nbsp;</td>
                   <td width="64" >&nbsp;</td>
                 </tr>

                 <tr>
                   <td width="35">&nbsp;</td>
                   <td width="32">&nbsp;</td>
                   <td width="722">&nbsp;</td>
                   <td><b>PPN (10%</b>)</td>
                   <td><b>:</b></td>
                   <td align="right"> <b> <?php echo number_format($ppn,2,",","."); ?> <b></td>
                 </tr>
                
                 <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td> <b> T O T A L <b></td>
                   <td><b>:</b></td>
                   <td align="right"><b> <?php echo number_format($total,2,",","."); ?> <b></td>
                 </tr>
				  <tr>
				    <td colspan="3"><b>Ket : </b></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td><b>* &nbsp;</b></td>
				    <td colspan="2"><b>HARAP DIKIRIM SEGERA HARI SENIN S/D JUMAT PKL 09.00 S/D 16.00 WIB </b> </td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td><b>** &nbsp; </b></td>
				    <td colspan="2"><b>HARAP COPY FAX INI DIBAWA PADA SAAT PENGIRIMAN BARANG</b> </td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td><b>***</b></td>
				    <td colspan="2"><b> MASA PEMASUKAN BARANG SELAMA 12 HARI ALMANAK </b></td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td colspan="3" align="center"><b><?php echo "Belawan,  ".$tgl_ctk?></b></td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td colspan="3" align="center">Hormat Kami, </td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td class="txtright">&nbsp;</td>
			     </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td colspan="3" align="center"><b><? echo $apoteker; ?></b></td>
			     </tr>
				  <tr>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td colspan="3" align="center">No SIPA :<? echo $no_sipa; ?></td>
                 </tr>

                 <?php if($cara_bayar_po == 3){ ?>

                 <?php } ?>
                 <!--tr>
					<td>Unit</td>
					<td>: <?php //echo $nunit; ?></td>
				</tr-->
               </table>
			   <p>&nbsp;</p>
		    </div>
			<!--PRINT OUT BERAKHIR-->
			<div id="listma" style="display:block">
			<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  <p align="center"><span class="jdltable"><b>SURAT PEMESANAN</b></span></p>
			  <table width="97%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
                <tr> 
                  <td width="132">Tgl PO</td>
                  <td width="350">: <?php echo $tgl_po; ?></td>
                  <td width="143">Harga Total</td>
                  <td width="7">:</td>
                  <td width="85" class="txtright"><?php echo number_format($h_tot,2,",","."); ?></td>
                </tr>
                <tr> 
                  <td width="132">No PO</td>
                  <td>: <?php echo $no_po; ?></td>
                  <td>Diskon Total</td>
                  <td>:</td>
                  <td class="txtright"><?php echo number_format($diskon_tot,2,",","."); ?></td>
                </tr>
                <tr> 
                  <td>No SPPH</td>
                  <td>: <?php echo $no_spph; ?></td>
                  <td>Harga Setelah Diskon</td>
                  <td>:</td>
                  <td class="txtright"><?php echo number_format($h_diskon,2,",","."); ?></td>
                </tr>
                <tr> 
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?></td>
                  <td>PPN (10%)</td>
                  <td>:</td>
                  <td class="txtright"><?php echo number_format($ppn,2,",","."); ?></td>
                </tr>
                <tr> 
                  <td>PBF</td>
                  <td>: <?php echo $pbf; ?></td>
                  <td>T O T A L</td>
                  <td>:</td>
                  <td class="txtright"><?php echo number_format($total,2,",","."); ?></td>
                </tr>
                <tr>
                  <td>Pemeriksa</td>
                  <td>: <?php echo $pemeriksa; ?></td>
                  <td>Cara Bayar</td>
                  <td>:</td>
                  <td><?php echo $arrCBayar[$cara_bayar_po]; ?></td>
                </tr>
				<?php if($cara_bayar_po == 3){ ?>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>Uang Muka</td>
                  <td>:</td>
                  <td><?=number_format($uangMuka,2,",",".")?></td>
                </tr>
				<?php } ?>
                <!--tr>
					<td>Unit</td>
					<td>: <?php //echo $nunit; ?></td>
				</tr-->
              </table>
			  <table width="100%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="30" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_KODE" width="60" class="tblheader">Kode Obat</td>
                  <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
                  <td id="qty_kemasan" width="45" class="tblheader"> 
                    <p>Qty Ke masan </p></td>
                  <td id="kemasan" width="60" class="tblheader">Kemasan</td>
                  <td width="60" class="tblheader">Harga Kemasan </td>
                  <td width="45" class="tblheader">Isi / Ke masan</td>
                  <td width="40" class="tblheader">Qty Satuan </td>
                  <td width="60" class="tblheader">Satuan</td>
                  <td width="60" class="tblheader">Harga Satuan </td>
                  <td width="70" class="tblheader">Sub Total </td>
                  <td width="30" class="tblheader">Disk (%) </td>
                  <td width="60" class="tblheader">Diskon (Rp) </td>
                </tr>
                <?php 
/* 			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
 */			  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po'".$filter." order by ".$sorting;
			  //echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
/*				$jmldata=mysqli_num_rows($rs);
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
		//	  $arfvalue="";
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
				$kemasan=$rows['kemasan'];
				$satuan=$rows['satuan'];
				$qty_kemasan=$rows['qty_kemasan'];
				$spph_id=$rows['spph_id'];
				$obat_id=$rows['obat_id'];
		/*		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
				
				 $arfvalue=str_replace('"',chr(3),$arfvalue);
				 $arfvalue=str_replace("'",chr(5),$arfvalue);
				 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
				
				$arfhapus="act*-*delete*|*minta_id*-*".$rows['permintaan_id'];
		*/
			  ?>
                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
                  <td class="tdisi" align="left">
					<?php echo $rows['OBAT_NAMA'].($rows['OBAT_TYPE'] != '0' ? " (". $arrTObat[$rows['OBAT_TYPE']] .") " : ''); ?>
				  </td>
                  <td class="tdisi" align="center"><?php echo $rows['QTY_KEMASAN']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['KEMASAN']; ?></td>
                  <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['QTY_PER_KEMASAN']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['SATUAN']; ?></td>
                  <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
                  <td class="tdisi" align="right"><?php echo number_format($rows['subtotal'],2,",","."); ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['DISKON']; ?></td>
                  <td class="tdisi" align="right"><?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
              </table>
			</div>
			<!--table width="1000" border="0">
                <tr> 
                  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
                  <td width="301" colspan="11" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;                  </td>
                </tr>
		</table-->

			<p align="center">
            <BUTTON type="button" onClick="PrintArea('printOut','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak PO&nbsp;&nbsp;</BUTTON>
			&nbsp;<BUTTON type="button" onClick="location='?f=../mc/po.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>&page=<?php echo $page; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar PO&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
		</form>
		</div>
	</td>
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
		document.form1.qty_satuan[i].value=(document.form1.qty_kemasan[i].value*1)*(document.form1.qty_per_kemasan[i].value*1);
	}else{
		document.form1.qty_satuan.value=(document.form1.qty_kemasan.value*1)*(document.form1.qty_per_kemasan.value*1);
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
		tmp=(document.form1.h_kemasan[i].value*1)/(document.form1.qty_per_kemasan[i].value*1);
		document.form1.h_satuan[i].value=tmp.toFixed(2)*1;
	}else{
		tmp=(document.form1.h_kemasan.value*1)/(document.form1.qty_per_kemasan.value*1);
		document.form1.h_satuan.value=tmp.toFixed(2)*1;
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
	tmp=tmp*10/100;
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
	tmp=tmp*10/100;
	document.form1.ppn.value=tmp.toFixed(2)*1;
	document.form1.total.value=(document.form1.h_diskon.value*1)+tmp;
}

function HitungDiskon(i,j){
var tmp;
	if (document.form1.obat_id.length){
		if (j==1){
			tmp=((document.form1.sub_tot[i].value*1)*(document.form1.diskon[i].value*1))/100;
			document.form1.diskon_rp[i].value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp[i].value*1)*100/(document.form1.sub_tot[i].value*1));
			document.form1.diskon[i].value=tmp.toFixed(1)*1;
		}
	}else{
		if (j==1){
			tmp=((document.form1.sub_tot.value*1)*(document.form1.diskon.value*1))/100;
			document.form1.diskon_rp.value=tmp.toFixed(2)*1;
		}else{
			tmp=((document.form1.diskon_rp.value*1)*100/(document.form1.sub_tot.value*1));
			document.form1.diskon.value=tmp.toFixed(1)*1;
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
			cdata +=document.form1.spph_id[i].value+'|'+document.form1.obat_id[i].value+'|'+document.form1.kepemilikan_id[i].value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'**';
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
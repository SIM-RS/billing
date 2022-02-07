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
$tgl_ctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$no_spph=$_REQUEST['no_spph'];
$no_po=$_REQUEST['no_po'];
$sql = "select u.nama,u.no_sipa from a_user u inner join a_po p on u.kode_user=p.user_id where p.no_po = '$no_po'";
$sql1=mysqli_query($konek,$sql);
$sql2=mysqli_fetch_array($sql1);
$apoteker=$sql2['nama'];
$no_sipa=$sql2['no_sipa'];
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
$sql = "select PBF_ALAMAT,PBF_TELP from a_pbf  where pbf_id = '$pbf_id'";
$sql1=mysqli_query($konek,$sql);
$sql2=mysqli_fetch_array($sql1);
$pbf_alamat=$sql2["PBF_ALAMAT"];
$pbf_telp=$sql2["PBF_TELP"];

$pbf=$_REQUEST['pbf'];
$kp_id=$_REQUEST['kp_id'];
$kp_nama=$_REQUEST['kp_nama'];
$updt_harga=$_REQUEST['updt_harga'];
$bulan=$_REQUEST['bulan'];

$caraBayar = ($_REQUEST['caraBayar'] > 0) ? $_REQUEST['caraBayar'] : 2 ;
$uangMuka = ($caraBayar == 3) ? $_REQUEST['uangMuka'] : 0;
$arrCBayar =  array(1 => 'Tunai', 2 => 'Kredit', 3 => 'Uang Muka');
$arrTObat =  array(0 => 'Reguler', 1 => 'BPJS');

$ta=$_REQUEST['ta'];
if ($_REQUEST['chk_ppn1']!="1") $chk_ppn=0; else $chk_ppn=1;
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
		$sqlCek = "select COUNT(ID) jml from a_po where NO_PO = '$no_po' AND (`STATUS` = 1 OR (QTY_KEMASAN_TERIMA > 0 AND QTY_KEMASAN_TERIMA < QTY_KEMASAN))";
		$qCek = mysqli_query($konek,$sqlCek);
		$dCek = mysqli_fetch_array($qCek);
		// echo $dCek['jml'];
		if($dCek['jml'] > 0){
			echo "<script type='text/javascript'>
						alert('Maaf PO Tidak Dapat Di Edit Karena Sudah Di Terima!');
						window.location = '?f=../mc/po.php';
					</script>";
		} else {
			$fdata=$_REQUEST['fdata'];
			$arfvalue=explode("**",$fdata);
			// print_r($arfvalue);
			for ($j=0;$j<count($arfvalue);$j++){
				$arfdata=explode("|",$arfvalue[$j]);
				if ($arfdata[13]!="0"){
					$sql="select * from a_po where ID=$arfdata[13]";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$qty_kemasan=$arfdata[3];
					if ($rows1=mysqli_fetch_array($rs1)) $qty_kemasan=$rows1["QTY_KEMASAN"];
					$qty_kemasan=$qty_kemasan-$arfdata[3];
					$sql="update a_po set OBAT_ID=$arfdata[1],QTY_KEMASAN=$arfdata[3],QTY_PAKAI=QTY_PAKAI - $qty_kemasan,HARGA_KEMASAN=$arfdata[5],QTY_PER_KEMASAN=$arfdata[6],QTY_SATUAN=$arfdata[7],HARGA_BELI_TOTAL=$h_tot,HARGA_BELI_SATUAN=$arfdata[9],DISKON=$arfdata[11],DISKON_TOTAL=$disk_tot,NILAI_PAJAK=$ppn,UPDT_H_NETTO=$updt_harga,TERMASUK_PPN=$chk_ppn,OBAT_TYPE=$arfdata[14] where ID=$arfdata[13]";
					//echo $sql."<br>";
				}else{
					// $sql="insert into a_po(OBAT_ID,FK_SPPH_ID,PBF_ID,KEPEMILIKAN_ID,USER_ID,NO_PO,TANGGAL_ACT,TANGGAL,QTY_KEMASAN,KEMASAN,HARGA_KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_PAKAI,SATUAN,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_TOTAL,NILAI_PAJAK,UPDT_H_NETTO,JENIS,TERMASUK_PPN,STATUS, cara_bayar_po) values($arfdata[1],$arfdata[0],$pbf_id,$arfdata[2],$iduser,'$no_po','$tgl_act','$tgl2',$arfdata[3],'$arfdata[4]',$arfdata[5],$arfdata[6],$arfdata[7],$arfdata[3],'$arfdata[8]',$h_tot,$arfdata[9],$arfdata[11],$disk_tot,$ppn,$updt_harga,0,$chk_ppn,0,{$caraBayar})";
					
					$sql="insert into a_po(OBAT_ID, FK_SPPH_ID, PBF_ID, KEPEMILIKAN_ID, USER_ID, NO_PO, TANGGAL_ACT, TANGGAL, QTY_KEMASAN, KEMASAN, HARGA_KEMASAN, QTY_PER_KEMASAN, QTY_SATUAN, QTY_PAKAI, SATUAN, HARGA_BELI_TOTAL, HARGA_BELI_SATUAN, DISKON, DISKON_RP, DISKON_TYPE, DISKON_TOTAL, NILAI_PAJAK, UPDT_H_NETTO, JENIS, TERMASUK_PPN, STATUS, cara_bayar_po, uang_muka, OBAT_TYPE) 
					values($arfdata[1],$arfdata[0],$pbf_id,$arfdata[2],$iduser,'$no_po','$tgl_act','$tgl2',$arfdata[3],'$arfdata[4]',$arfdata[5],$arfdata[6],$arfdata[7],$arfdata[3],'$arfdata[8]',$h_tot,$arfdata[9],$arfdata[11],'$arfdata[12]','$arfdata[13]',$disk_tot,$ppn,$updt_harga,0,$chk_ppn,0, {$caraBayar}, {$uangMuka}, $arfdata[14])";
					// echo $sql."<br>";
				}
				// echo $sql."<br>";
				$rs=mysqli_query($konek,$sql) or die(mysqli_error($konek));
			}
			
			$sql="update a_spph set status=1 where no_spph='$no_spph'";
			$rs=mysqli_query($konek,$sql);
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
/*
$sql="SELECT DISTINCT p.PBF_ID,p.PBF_NAMA,k.ID,k.NAMA FROM a_spph s INNER JOIN a_pbf p ON s.pbf_id=p.PBF_ID INNER JOIN a_kepemilikan k ON s.kepemilikan_id=k.ID WHERE s.no_spph='$no_spph'";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	$pbf=$rows['PBF_NAMA'];
	$pbf_id=$rows['PBF_ID'];
	$kp_id=$rows['ID'];
	$kp_nama=$rows['NAMA'];
}
*/
$sql1="select distinct HARGA_BELI_TOTAL,DISKON_TOTAL,(HARGA_BELI_TOTAL-DISKON_TOTAL) as H_DISKON,NILAI_PAJAK,(HARGA_BELI_TOTAL-DISKON_TOTAL)+NILAI_PAJAK as TOTAL,TERMASUK_PPN, cara_bayar_po, uang_muka from a_po where NO_PO='$no_po'";
//echo $sql1;
$rs1=mysqli_query($konek,$sql1);
$cara_bayar_po = 2;
if ($rows=mysqli_fetch_array($rs1)){
	$h_tot=$rows['HARGA_BELI_TOTAL'];
	$diskon_tot=$rows['DISKON_TOTAL'];
	$h_diskon=$rows['H_DISKON'];
	$ppn=$rows['NILAI_PAJAK'];
	$total=$rows['TOTAL'];
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
<script language="JavaScript" src="../theme/js/ajax.js"></script>
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
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
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
	<table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtkop" >
      <tr>
        <td colspan="2" align="right"><img src="../images/logo.png" width="39" height="33"></td>
        <td width="24%" align="left">&nbsp;&nbsp;<b>
          <?=$namaRS;?>
        </b></td>
        <td width="31%" align="left">&nbsp;</td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr align="left">
        <td width="31%">&nbsp;</td>
        <td width="14%" align="left"><span class="txtcenter"><b>Nama Sarana</b></span> </td>
        <td colspan="2"><span class="txtcenter"><b>: Instalsi
          <?=$namaRS;?>
        </b></span></td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td align="left"><span class="txtcenter"><b>No. SIPA </b></span></td>
        <td colspan="2"><span class="txtcenter"><b>:
          <?=$no_sipa;?>
        </b></span></td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td align=""><span class="txtcenter"><b>Alamat/Telp</b></span></td>
        <td colspan="2"><span class="txtcenter"><b>:
          <?=$alamatRS;?>
        </b> </span></td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="txtcenter"><b>Telp :
          &nbsp;
          <?=$tlpRS;?>
          , Fax :
          <?=$faxRS;?>
        </b></span></td>
      </tr>
      <tr align="left">
        <td>&nbsp;</td>
        <td><span class="txtcenter"><b>Nama Apoteker </b></span></td>
        <td colspan="2"><span class="txtcenter"><b>:
          <?=$apoteker;?>
        </b></span></td>
      </tr>
      <tr>
        <td colspan="4"><hr></td>
      </tr>
    </table>
	<table width="97%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
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
	<p align="center"><span class="jdltable" ><b>SURAT PEMESANAN</b></span></br>
      <span class="txtcenter"> No : <?php echo $no_po; ?></span></p>			  
            <table width="100%" border="0" cellpadding="1" cellspacing="0">
              <tr class="headtable">
                <td width="32" height="25" class="tblheaderkiri">No</td>
                <td width="369" class="tblheader" id="OBAT_NAMA">Nama Obat</td>
                <td id="qty_kemasan" width="73" class="tblheader">Jenis</td>
                <td id="kemasan" width="147" class="tblheader">Kemasan</td>
                <td width="72" class="tblheader">Jumla Pesanan </td>
                <td width="79" class="tblheader">Harga Kemasan </td>
                <td width="59" class="tblheader">Sub Total </td>
                <td width="102" class="tblheader">Disk (%) </td>
                <td width="49" class="tblheader">Total </td>
              </tr>
              <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po' order by a_po.ID";
			  
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
                <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?> </td>
                <td class="tdisi" align="center" style="font-size:12px;"><?php if($rows['OBAT_TYPE']==1){echo "BPJS";}else{echo "REGULER";} ?>
                    </span></td>
                <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['KEMASAN']; ?>&nbsp;@ &nbsp;<?php echo $rows['QTY_PER_KEMASAN']; ?>&nbsp;<?php echo $rows['SATUAN']; ?></td>
                <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_KEMASAN']; ?>&nbsp;<?php echo $rows['KEMASAN']; ?></td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['HARGA_KEMASAN'],2,",","."); ?></td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['subtotal'],2,",","."); ?></td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php echo $rows['DISKON']; ?>%&nbsp;(<?php echo number_format((($rows['subtotal']*$rows['DISKON'])/100),2,",","."); ?>)</td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php 
				  
				  echo number_format(
				  
				  (
				  	$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100)
				)
				  
				  ,2,",","."); ?>
                </td>
              </tr>
              <?php 
				$t_subtotal +=$rows['subtotal'];
				$t_diskon +=(($rows['subtotal']*$rows['DISKON'])/100);
				$t_total +=$rows['subtotal']-(($rows['subtotal']*$rows['DISKON'])/100);
			     }
			        mysqli_free_result($rs);
			  
			  	?>
              <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                <td colspan="6" align="right" class="tdisikiri" style="font-size:12px;">Total : </td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($t_subtotal,2,",","."); ?></td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($t_diskon,2,",","."); ?></td>
                <td class="tdisi" align="right" style="font-size:12px;"><?php 
				  
				  echo number_format($t_total,2,",","."); ?>
                </td>
              </tr>
            </table>
            <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
              <tr>
                <td colspan="2">&nbsp;</td>
                <td width="184">&nbsp;</td>
                <td width="7">&nbsp;</td>
                <td width="100" class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td width="43">&nbsp;</td>
                <td width="646">&nbsp;</td>
                <td><b>PPN (10%</b>)</td>
                <td><b>:</b></td>
                <td class="txtright"><b><?php echo number_format($ppn,2,",","."); ?><b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><b>T O T A L<b></td>
                <td><b>:</b></td>
                <td class="txtright"><b><?php echo number_format($total,2,",","."); ?><b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td><b>Ket : </b></td>
                <td><b>* &nbsp; &nbsp;&nbsp;HARAP DIKIRIM SEGERA HARI SENIN S/D JUMAT PKL 09.00 S/D 16.00 WIB </b> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><b>** &nbsp; HARAP COPY FAX INI DIBAWA PADA SAAT PENGIRIMAN BARANG</b> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><b>*** MASA PEMASUKAN BARANG SELAMA 12 HARI ALMANAK </b></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
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
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center"><b><?php echo "Belawan,  ".$tgl_ctk?></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center">Hormat Kami, </td>
              </tr>
              <tr>
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
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="txtright">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3" align="center"><b><? echo $apoteker; ?></b></td>
              </tr>
              <tr>
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
            <p class="txtinput"  style="padding-right:10px; text-align:right">&nbsp;</p>
	</div>
          <p align="center">Purchase Order Dgn No PO : <?php echo $no_po; ?> 
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
			<input name="chk_ppn1" id="chk_ppn1" type="hidden" value="<?php echo $chk_ppn; ?>">
			<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
			<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
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
                    <input name="h_tot" type="text" class="txtright" id="h_tot" value="<?php echo $h_tot; ?>" size="15" readonly="true"></td>
                  <td width="109">PPN (10%)</td>
                  <td width="203">: 
                    <input name="ppn" type="text" class="txtright" id="ppn2" value="<?php echo $ppn; ?>" size="15" readonly="true"></td>
                </tr>
                <tr> 
                  <td width="90">Tgl PO</td>
                  <td>: 
                    <input name="tgl_po" type="text" id="tgl_po" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_po; ?>">                  </td>
                  <td>Diskon Total</td>
                  <td>: 
                    <input name="disk_tot" type="text" class="txtright" id="disk_tot" value="<?php echo $diskon_tot; ?>" size="15" readonly="true"></td>
                  <td>T O T A L</td>
                  <td>: 
                    <input name="total" type="text" class="txtright" id="total" value="<?php echo $total; ?>" size="15" readonly="true"></td>
                </tr>
                <tr> 
                  <td>No SPPH</td>
                  <td>: <?php echo $no_spph; ?></td>
                  <td>Harga Setelah Diskon</td>
                  <td>: 
                    <input name="h_diskon" type="text" class="txtright" id="h_diskon" value="<?php echo $h_diskon; ?>" size="15" readonly="true"></td>
                  <td colspan="2"><input name="chk_ppn" type="checkbox" id="chk_ppn" value="<?php echo $chk_ppn; ?>"<?php if ($chk_ppn==1) echo " checked";?> onClick="HitunghTot();if (this.checked){chk_ppn1.value='1'}else{chk_ppn1.value='0'};">
                    Harga Sudah Termasuk PPN (10%)</td>
                </tr>
                <tr> 
                  <td>PBF</td>
                  <td>: <?php echo $pbf; ?> <input name="pbf_id" id="pbf_id" value="<?php echo $pbf_id; ?>" type="hidden"></td>
                  <td>Kepemilikan</td>
                  <td>: <?php echo $kp_nama; ?> <input name="kepemilikan_id" id="kepemilikan_id" value="<?php echo $kp_id; ?>" type="hidden"></td>
                  <td colspan="2"><!--input name="chk_updt" type="checkbox" id="chk_updt"<?php if ($updt_harga=="1") echo " checked";?> value="<?php echo $updt_harga; ?>">
                    Update Harga Pokok --></td>
                </tr>
                <tr>
                  <td>Pemeriksa</td>
                  <td>: <?php echo $pemeriksa; ?></td>
                  <td>Cara Bayar</td>
                  <td>: <?php echo $arrCBayar[$cara_bayar_po]; ?>
					<input type="hidden" id="caraBayar" name="caraBayar" value="<?php echo $cara_bayar_po; ?>" />
				  </td>
                  <td><?=($cara_bayar_po == 3) ? 'Uang Muka' : '&nbsp'?></td>
				  <td>
					<?=($cara_bayar_po == 3) ? ': '.number_format($uangMuka,2,",",".") : '&nbsp;'?>
					<input type="hidden" name="uangMuka" id="uangMuka" value="<?=($cara_bayar_po == 3) ? $uangMuka : 0?>" />
				  </td>
                </tr>
				<tr>
					<td colspan="6" align="right"><button type="button" name="tambahRow" id="tambahRow" onClick="addRowToTable();">&nbsp;+&nbsp;</button></td>
				</tr>
              </table>
			  <table width="100%" border="0" id="tblJual" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="30" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_NAMA" class="tblheader">Nama Obat</td>
                  <td id="OBAT_TYPE" width="60" class="tblheader">Jenis Obat</td>
                  <td id="qty_kemasan" width="40" class="tblheader"><p>Qty Ke masan </p></td>
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
			  //$sql="select a_spph.*,o.OBAT_KODE,o.OBAT_NAMA,k.NAMA from a_spph inner join a_obat o on a_spph.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_spph.KEPEMILIKAN_ID=k.ID where a_spph.no_spph='$no_spph' and a_spph.bisa=1".$filter." order by ".$sorting;
			  $sql="select a_po.*,a_po.HARGA_KEMASAN*QTY_KEMASAN as subtotal,o.OBAT_KODE,o.OBAT_NAMA,o.OBAT_SATUAN_KECIL,k.NAMA from a_po inner join a_obat o on a_po.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_po.KEPEMILIKAN_ID=k.ID where a_po.NO_PO='$no_po' order by a_po.ID";
			  //echo $sql."<br>";
				//$rs=mysqli_query($konek,$sql);
/*				$jmldata=mysqli_num_rows($rs);
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
				$kemasan=$rows['KEMASAN'];
				$satuan=$rows['OBAT_SATUAN_KECIL'];
				$qty_kemasan=$rows['QTY_KEMASAN'];
				$h_kemasan=$rows['HARGA_KEMASAN'];
				$spph_id=$rows['FK_SPPH_ID'];
				$obat_id=$rows['OBAT_ID'];
			  ?>
                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="left">
					<input name="spph_id" type="hidden" value="<?php echo $spph_id; ?>">
                    <input name="obat_id" type="hidden" value="<?php echo $obat_id; ?>">
					<input name="itembaru" type="hidden" value="<?php echo $rows['ID']; ?>">
                     <input value="<? echo $rows['OBAT_NAMA']; ?>" type="text" name="txtObat" class="txtinput" size="45" onKeyUp="suggest(event,this);" autocomplete="off" /> 
				  </td>
				  <td class="tdisi" align="left">
					<select name="obat_tipe" id="obat_tipe" class="txtinput" style="width:69px" >
						<option value="0" <?php echo($rows["OBAT_TYPE"] == "0" ? "selected" : ""); ?> >Reguler</option>
						<option value="1" <?php echo($rows["OBAT_TYPE"] == "1" ? "selected" : ""); ?> >BPJS</option>
					</select>
				  </td>
                  <td width="40" align="center" class="tdisi"> 
                    <input name="qty_kemasan" type="text" id="qty_kemasan" class="txtcenter" size="4" value="<?php echo $qty_kemasan; ?>" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);" autocomplete="off">
                  </td>
                  <td width="60" align="center" class="tdisi"> 
                    <input name="kemasan" id="kemasan" size="7" value="<?php echo $kemasan;?>" readonly="true"></td>
                  <td width="40" align="center" class="tdisi">
<input name="h_kemasan" type="text" class="txtright" id="h_kemasan" onKeyUp="HitungSubTotal(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="<?php echo $h_kemasan; ?>" size="8" autocomplete="off">
                  </td>
                  <td width="40" align="center" class="tdisi">
<input name="qty_per_kemasan" type="text" class="txtcenter" id="qty_per_kemasan" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungHargaSatuan(<?php echo ($i-1); ?>);" value="<?php echo $rows['QTY_PER_KEMASAN']; ?>" size="4" autocomplete="off">
                  </td>
                  <td width="40" align="center" class="tdisi">
<input name="qty_satuan" type="text" class="txtcenter" id="qty_satuan" onKeyUp="" value="<?php echo $rows['QTY_SATUAN']; ?>" size="5" autocomplete="off" readonly="true">
                  </td>
                  <td width="60" align="center" class="tdisi"> 
                    <input name="satuan" id="satuan" value="<?php echo $satuan;?>" type="text" readonly="true" size="7">
                  </td>
                  <td width="50" align="center" class="tdisi">
<input name="h_satuan" type="text" class="txtright" id="h_satuan" onKeyUp="" value="<?php echo $rows['HARGA_BELI_SATUAN']; ?>" size="8" autocomplete="off" readonly="true">
                  </td>
                  <td width="60" align="center" class="tdisi">
<input name="sub_tot" type="text" class="txtright" id="sub_tot" onKeyUp="" value="<?php echo $rows['subtotal']; ?>" size="8" readonly="true">
                  </td>
                  <td width="30" align="center" class="tdisi"> 
                    <input name="diskon" type="text" class="txtcenter" id="diskon" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,1);" value="<?php echo $rows['DISKON']; ?>" size="3" autocomplete="off"></td>
                  <td width="50" align="center" class="tdisi"> 
                    <input name="diskon_rp" type="text" class="txtright" id="diskon_rp" onKeyUp="HitungDiskon(<?php echo ($i-1); ?>,2);" value="<?php echo (($rows['subtotal']*$rows['DISKON'])/100); ?>" size="7" autocomplete="off">
				  </td>
                </tr>
                <?php 
			  }
			  $sql="select a_spph.*,o.OBAT_KODE,o.OBAT_NAMA,o.OBAT_SATUAN_KECIL,k.NAMA from a_spph inner join a_obat o on a_spph.OBAT_ID=o.OBAT_ID inner join a_kepemilikan k on a_spph.KEPEMILIKAN_ID=k.ID where a_spph.no_spph='$no_spph' and a_spph.bisa=1 and a_spph.status=0 order by spph_id";
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $jmld=mysqli_num_rows($rs);
			  if ($jmld>0){
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
					<input name="itembaru" type="hidden" value="0">
                      <input value="<? echo $rows['OBAT_NAMA']; ?>" type="text" name="txtObat" class="txtinput" size="45" onKeyUp="suggest(event,this);" autocomplete="off" /> 
                  <td width="40" align="center" class="tdisi"> 
                    <input name="qty_kemasan" type="text" id="qty_kemasan" class="txtcenter" size="4" value="<?php echo $qty_kemasan; ?>" onKeyUp="HitungQtySatuan(<?php echo ($i-1); ?>);HitungSubTotal(<?php echo ($i-1); ?>);" autocomplete="off">
                  </td>
                  <td width="60" align="center" class="tdisi"> 
                    <input name="kemasan" id="kemasan" size="7" value="<?php echo $rows['kemasan'] ;?>" readonly="true"></td>
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
                    <input name="satuan" id="satuan" value="<?php echo $rows['OBAT_SATUAN_KECIL'];?>" type="text" readonly="true" size="7">
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
			  }
			  mysqli_free_result($rs);
			  ?>
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
var foc = 0;
var RowIdx;
var fKeyEnt;
function addRowToTable()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  // alert(iteration);
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  // right cell
  var cellRight = row.insertCell(1);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'spph_id';
  }else{
  	el = document.createElement('<input name="spph_id"/>');
  }
  el.type = 'hidden';
  el.value = '0';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obat_id';
  }else{
  	el = document.createElement('<input name="obat_id"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'itembaru';
  }else{
  	el = document.createElement('<input name="itembaru"/>');
  }
  el.type = 'hidden';
  el.value = '0';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 46;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // tambahan obat type
  cellRight = row.insertCell(2);
  if(!isIE){
  	el = document.createElement('select');
  	el.name = 'obat_tipe';
  	el.id = 'obat_tipe';
	
	var opt1 = document.createElement("option");
	var opt2 = document.createElement("option");
	opt1.value = "0";
	opt1.text = "Reguler";

	opt2.value = "1";
	opt2.text = "BPJS";

	el.add(opt1, null);
	el.add(opt2, null);
	
  }else{
  	el = document.createElement('<select name="obat_tipe" id="obat_tipe" ><option value="0">Reguler</option><option value="1">BPJS</option></select>');
  }
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(3);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_kemasan';
	el.setAttribute('OnKeyUp', "AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="qty_kemasan" onkeyup="AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 4;
  el.value = '';
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kemasan';
  }else{
  	el = document.createElement('<input name="kemasan" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 7;
  el.value = '';
  //el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'h_kemasan';
	el.setAttribute('OnKeyUp', "AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="h_kemasan" onkeyup="AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 8;
  el.value = '';
  el.className = 'txtright';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_per_kemasan';
	el.setAttribute('OnKeyUp', "AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="qty_per_kemasan" onkeyup="AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 4;
  el.value = '';
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'qty_satuan';
	el.setAttribute('readOnly', "true");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="qty_satuan" autocomplete="off" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 5;
  el.value = '0';
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'satuan';
  }else{
  	el = document.createElement('<input name="satuan" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 7;
  el.value = '';
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(9);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'h_satuan';
	el.setAttribute('readOnly', "true");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="h_satuan" autocomplete="off" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 8;
  el.value = '0';
  el.className = 'txtright';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(10);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'sub_tot';
	el.setAttribute('readOnly', "true");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="sub_tot" autocomplete="off" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 8;
  el.value = '0';
  el.className = 'txtright';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(11);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'diskon_type';
  }else{
  	el = document.createElement('<input name="diskon_type" />');
  }
  el.type = 'hidden';
  el.value = '0';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  //cellRight = row.insertCell(10);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'diskon';
	el.setAttribute('OnKeyUp', "AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="diskon" onkeyup="AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 3;
  el.value = '0';
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(12);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'diskon_rp';
	el.setAttribute('OnKeyUp', "AddRow(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="diskon_rp" onkeyup="AddRow(event,this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 7;
  el.value = '0';
  el.className = 'txtright';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(13);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  if(foc > 0){
	document.form1.txtObat[foc].focus();
  } else {
	document.form1.txtObat.focus();
  }
  foc++;

/*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sel; ?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

function removeRowFromTable(cRow)
{
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 2){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=1;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i;
	  }
	  //HitungTot();
  }
}

function AddRow(e,par){
var key;
var i=par.parentNode.parentNode.rowIndex;
	//alert(i);
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable();
	}else{
		switch (par.name){
			case "qty_kemasan":
				HitungQtySatuan(i-1);
				HitungSubTotal(i-1);
				break;
			case "h_kemasan":
				HitungSubTotal(i-1);
				HitungHargaSatuan(i-1);
				break;
			case "qty_per_kemasan":
				HitungQtySatuan(i-1);
				HitungHargaSatuan(i-1);
				break;
			case "diskon":
				HitungDiskon(i-1,1);
				break;
			case "diskon_rp":
				HitungDiskon(i-1,2);
				break;
		}
	}
}

function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;//alert(jmlRow);
  var i;
  if (jmlRow > 2){
  	i=par.parentNode.parentNode.rowIndex-1;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			//Request('../transaksi/obatlist.php?aKepemilikan=0&idunit=<?php echo $idgudang; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			Request('obatlist_po_nospph.php?aKepemilikan=0&idunit=<?php echo $idgudang; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//(cdata[0]*1)	
	//alert(tbl.rows.length-1);
	if ((tbl.rows.length-1)==1){
		document.form1.obat_id.value=cdata[1];
		document.form1.txtObat.value=cdata[2];
		document.form1.satuan.value=cdata[3];
		//document.form1.kemasan.value=cdata[9];
		//tds = tbl.rows[3].getElementsByTagName('td');
		//document.form1.txtHarga.value=cdata[4];
		document.form1.qty_kemasan.focus();
	}else{
		var w;
		for (var x=0;x<document.form1.obat_id.length-1;x++){
			w=document.form1.obat_id[x].value;
			//alert(cdata[1]+'-'+w[0]);
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		if( (tbl.rows.length-1) > 1 /* document.form1.txtObat.length */){
			document.form1.obat_id[(cdata[0]*1)].value = cdata[1];
			if(document.form1.txtObat.length){
				var now = ((cdata[0]*1));
				document.form1.txtObat[now].value = cdata[2];
			} else {
				document.form1.txtObat.value = cdata[2];	
			}
			document.form1.satuan[(cdata[0]*1)].value = cdata[3];
			//document.form1.kemasan[(cdata[0]*1)].value=cdata[9];
			//tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
			//document.form1.txtHarga[(cdata[0]*1)-1].value=cdata[4];
			document.form1.qty_kemasan[(cdata[0]*1)].focus();
		} else {
			document.form1.obat_id.value=cdata[1];
			document.form1.txtObat.value=cdata[2];
			document.form1.satuan.value=cdata[3];
			//document.form1.kemasan[(cdata[0]*1)].value=cdata[9];
			//tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
			//document.form1.txtHarga[(cdata[0]*1)-1].value=cdata[4];
			document.form1.qty_kemasan.focus();
		}
	}
	//tds[1].innerHTML=cdata[6];
	//tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}

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
				document.form1.diskon_rp[i].value=tmp.toFixed(2)*1;
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
	// if (document.form1.chk_updt.checked==true){
		document.form1.updt_harga.value=1;
	/* }else{
		document.form1.updt_harga.value=0;
	} */
	//alert(document.form1.updt_harga.value);	
	if (document.form1.obat_id.length){
		for (var i=0;i<document.form1.obat_id.length;i++){
			cdata +=document.form1.spph_id[i].value+'|'+document.form1.obat_id[i].value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.qty_kemasan[i].value+'|'+document.form1.kemasan[i].value+'|'+document.form1.h_kemasan[i].value+'|'+document.form1.qty_per_kemasan[i].value+'|'+document.form1.qty_satuan[i].value+'|'+document.form1.satuan[i].value+'|'+document.form1.h_satuan[i].value+'|'+document.form1.sub_tot[i].value+'|'+document.form1.diskon[i].value+'|'+document.form1.diskon_rp[i].value+'|'+document.form1.itembaru[i].value+'|'+document.form1.obat_tipe[i].value+'**';
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
		
		cdata +=document.form1.spph_id.value+'|'+document.form1.obat_id.value+'|'+document.form1.kepemilikan_id.value+'|'+document.form1.qty_kemasan.value+'|'+document.form1.kemasan.value+'|'+document.form1.h_kemasan.value+'|'+document.form1.qty_per_kemasan.value+'|'+document.form1.qty_satuan.value+'|'+document.form1.satuan.value+'|'+document.form1.h_satuan.value+'|'+document.form1.sub_tot.value+'|'+document.form1.diskon.value+'|'+document.form1.diskon_rp.value+'|'+document.form1.itembaru.value+'|'+document.form1.obat_tipe.value;
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
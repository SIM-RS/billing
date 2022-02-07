<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$tgltrans1=$_REQUEST["tgltrans"];
$tgltrans=explode("-",$tgltrans1);
$tgltrans=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];

if ($_REQUEST['no_penjualan']<>"") $no_penjualan=$_REQUEST['no_penjualan']; else $no_penjualan=0;

//======================Tanggalan==========================
$kepemilikan_id=$_REQUEST["kepemilikan_id"];
if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
</head>
<body onLoad="document.form1.no_pasien.focus()">
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=550,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>

<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:none;">
	<?php
	if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	$qrySingle="SELECT a_penjualan.*,a_kepemilikan.NAMA,a_user.username from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_user on a_penjualan.USER_ID=a_user.kode_user WHERE a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	system("/usr/bin/lpr penjualan.php")
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <table width="431" border="0">
      <tr>
        <td width="921">
		<table width="418" height="113" border="0" cellpadding="0" cellspacing="0" class="txtinput">
         <tr>
		 <td height="45" colspan="2" style="font-size:18px"><?=$namaRS;?><br>
            <?=$alamatRS;?> <hr size="1" color="#000000"></td>
          </tr>
          <tr style="font-size:16px">
            <td>No. Kwitansi </td>
            <td><span style="font-size:16px">: <?php echo $showSingle['NO_PENJUALAN']; ?></span></td>
          </tr>
          <tr style="font-size:16px">
            <td width="171">Tanggal&nbsp; </td>
            <td width="314">: <?php echo date("d/m/Y",strtotime($showSingle['TGL'])); ?></td>
          </tr>
          <tr style="font-size:16px">
            <td>No. Kunjungan</td>
            <td>: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
          </tr>
          <tr style="font-size:16px">
            <td>No Rekam Medis</td>
            <td>: <?php echo $showSingle['NO_PASIEN']; ?></td>
          </tr>
          <tr>
            <td style="font-size:16px">Nama Pasien </td>
            <td style="font-size:16px">: <?php echo $showSingle['NAMA_PASIEN']; ?>&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size:16px">Jenis Pasien</td>
            <td style="font-size:16px">: <?php echo $showSingle['NAMA']; ?></td>
          </tr>
          <tr>
            <td style="font-size:16px">Dokter</td>
            <td style="font-size:16px">: <?php echo $showSingle['DOKTER']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size:18px">R/</td>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="425" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size:16px;">
            <?php 
				  $sqlPrint="SELECT a_penjualan.*, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL
				  FROM a_penjualan
				  Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID
				  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
				  where a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
				  $exePrint=mysqli_query($konek,$sqlPrint);
				  $i=1;
				  while($showPrint=mysqli_fetch_array($exePrint)){
				  ?>
            <tr>
              <td width="29" align="center" style="font-size:16px;"><?php echo $i++ ?></td>
              <td width="255" style="font-size:16px;">
			  <?php echo $showPrint['OBAT_NAMA']; ?></td>
              <!--td class="tdisi" align="center" style="border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['OBAT_SATUAN_KECIL']; ?></td-->
              <td width="141" align="right" style="font-size:16px">
			  <?php echo $showPrint['QTY']; ?></td>
              <!--td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['HARGA_SATUAN']; ?></td>
              <td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['SUB_TOTAL']; ?></td>
              <td class="tdisi"><?php echo $showPrint['EMBALAGE']; ?></td>
				<td class="tdisi"><?php echo $showPrint['JASA_RESEP']; ?></td>
				<td class="tdisi"><?php echo $showPrint['HARGA_TOTAL']; ?></td-->
            </tr>
            <? } ?>
            <tr>
              <td colspan="3" align="right" style="padding:5px;">&nbsp;</td>
            </tr>
            <tr>
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
              <td colspan="3" align="right" style="padding-right:5px;font-size:16px"><b>Harga Total: Rp. <?php echo number_format($showSingle['HARGA_TOTAL'],0,",","."); ?></b> </td>
            </tr>
            <tr>
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
	<?php
      function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = kekata($x - 10). " belas";
          } else if ($x <100) {
              $temp = kekata($x/10)." puluh". kekata($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . kekata($x - 100);
          } else if ($x <1000) {
              $temp = kekata($x/100) . " ratus" . kekata($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . kekata($x - 1000);
          } else if ($x <1000000) {
              $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
          } else if ($x <1000000000) {
              $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
          }      
              return $temp;
      }
      function terbilang($x, $style=4) {
          if($x<0) {
              $hasil = "minus ". trim(kekata($x));
          } else {
              $hasil = trim(kekata($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }
	  $bilangan= $showSingle['HARGA_TOTAL'];
      ?>
              <td colspan="3" align="right" style="padding-right:5px;font-size:16px">Terbilang: <?php echo terbilang($bilangan,3);?> Rupiah</td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:14px; border-top:1px dashed;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:16px"><b>Kasir : <?php echo $showSingle['username']; ?></b></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:16px"><i>Bukti pembayaran ini juga berlaku sebagai kwitansi</i></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:12px"></td>
            </tr>
          </table>
 </td>
</tr>
</table>
</div>
    <!-- PRINT OUT BERAKHIR -->
	
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="450">
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="save">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<div id="listma" style="display:block">
			  <p align="center"><span class="jdltable"><b>DETAIL PENJUALAN</b></span>
			  <p align="center">
		      
			  <table width="99%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
                <tr>
                  <td width="179">Tanggal</td>
                  <td width="311">: <?php echo date("d/m/Y",strtotime($showSingle['TGL'])); ?></td>
                  <td width="184">Nama Pasien </td>
                  <td width="308">: <?php echo $showSingle['NAMA_PASIEN']; ?></td>
                </tr>
                <tr>
                  <td width="179">No. Kunjungan </td>
                  <td>: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
                  <td width="184">Jenis Pasien  </td>
                  <td>: <?php echo $showSingle['NAMA']; ?></td>
                </tr>
                <tr>
                  <td width="179">No. Rekam Medis </td>
                  <td>: <?php echo $showSingle['NO_PASIEN']; ?></td>
                  <td width="184">User</td>
                  <td>: <?php echo $showSingle['username']; ?></td>
                </tr>
              </table>
              <table width="99%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="30" height="25" class="tblheaderkiri">No</td>
                  <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
                    Obat</td>
                  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
                  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah</td>
                  <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Harga Satuan </td>
                  <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Subtotal</td>
                  <!--td class="tblheader" width="30">Proses</td-->
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;

			  $sql="SELECT a_penjualan.*, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL
				  FROM a_penjualan
				  Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID
				  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
				  where a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit".$filter." order by ".$sorting;
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
                  <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['QTY']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['HARGA_SATUAN']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['SUB_TOTAL']; ?></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
              </table>
			</div>
			<table width="989" border="0">
			    <tr> 
                  <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
                  </td>
                </tr>
			</table>
			<p align="center">
			<a class="navText" href='#' onclick='PrintArea("idArea","#")'>
              <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
              Penjualan&nbsp;&nbsp;</BUTTON>
			  </a>
            &nbsp;<BUTTON type="button" onClick="location='?f=../apotik/list_penjualan.php&tgl_d=<?php echo $_GET['tgl_d'];?>&tgl_s=<?php echo $_GET['tgl_s'];?>&jns_pasien=<?php echo $_GET['jns_pasien'];?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          	</p>
		</form>
		</div>
	</td>
</tr>
</table>
</div>
</html>
<?php 
mysqli_close($konek);
?>
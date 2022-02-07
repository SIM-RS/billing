<?php 
include("../sesi.php");
include("../koneksi/konek.php");
//==========================================
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
convert_var($tgl2,$tglctk);

//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];
$ta=$_REQUEST['ta'];
$kategori=$_REQUEST['kategori'];
convert_var($idunit,$bulan,$ta);


if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_BENTUK='$kategori'";

if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
if ($ta=="") $ta=$th[2];

$minta_id=$_REQUEST['minta_id'];
$unit_tujuan=$_REQUEST['unit_tujuan']; 
convert_var($minta_id,$unit_tujuan);

if(($unit_tujuan=="0")||($unit_tujuan=="")) $unit_tj=""; else $unit_tj="and ap.UNIT_ID_TERIMA=$unit_tujuan";

$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($unit_tj,$tgl_d,$tgl_s);

$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";


//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="ap.NOKIRIM desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($tgl_de,$tgl_se,$page,$sorting,$filter);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(cetak,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(cetak).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	//winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
	

	
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<form name="form1" method="post" action="">
<input name="act" id="act" type="hidden" value="save">
	<input name="minta_id" id="minta_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<input type="hidden" name="filter1" id="filter1" value="<?php echo $filter1; ?>">
	<div id="idArea" style="display:block">
	  <p><span class="jdltable">LAPORAN PENGELUARAN OBAT<br>UNIT : <?php echo $namaunit; ?></span></p>
      <table width="64%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
<tr>
<td width="175">Tanggal Periode</td>
          <td width="544">: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_d']<>'') echo $_GET['tgl_d'];?>" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />&nbsp;&nbsp;&nbsp;s/d:
      <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php if ($_GET['tgl_s']<>'') echo $_GET['tgl_s'];?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />          </td>
		</tr>
<tr>
  <td>Bentuk Obat </td>
  <td>: 
    <select name="kategori" id="kategori" class="txtinput" onchange="location='?f=../gudang/list_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value" >
      <option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
      <?php 
				  $j1="SEMUA";
				  $sql="select * from a_bentuk";
				  $rs=mysqli_query($konek,$sql);
				  while ($rows=mysqli_fetch_array($rs)){
				  ?>
      <option value="<?php echo $rows['BENTUK']; ?>" class="txtinput"<?php if ($kategori==$rows['BENTUK']){echo " selected";$f1=$rows['BENTUK'];}?>><?php echo $rows['BENTUK']; ?></option>
      <?php }?>
    </select></td>
</tr>
<tr>
<td width="175">Unit Tujuan </td>
            <td>:
              <select name="unit_tujuan" id="unit_tujuan" onchange="location='?f=../gudang/list_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
                <option value="0">All Unit</option>
                <?
	  			$qry = "select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>1 and UNIT_TIPE<>4 and UNIT_ISAKTIF=1 and UNIT_ID NOT IN(8,9)";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
				//$id=$show['UNIT_ID']
	  			?>
                <option value="<?php echo $show['UNIT_ID'];?>" class="txtinput" <?php if ($unit_tujuan==$show['UNIT_ID']) echo " selected"; ?>>
                <?=$show['UNIT_NAME'];?>
                </option>
                <? }?>
              </select>
			  <button type="button" onclick="location='?f=../gudang/list_mutasi.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
	    </tr>
	</table>
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="TANGGAL" width="75" class="tblheader" onclick="ifPop.CallFr(this);">Tgl</td>
          <td align="center" id="ap.NOKIRIM" width="150" class="tblheader" onclick="ifPop.CallFr(this);">No Minta </td>
          <td align="center" id="ap.NOKIRIM" width="150" class="tblheader" onclick="ifPop.CallFr(this);">No 
            Kirim</td>
          <td align="center" id="UNIT_NAME" width="130" class="tblheader" onclick="ifPop.CallFr(this);">Unit</td>
          <td align="center" id="OBAT_KODE" width="70" class="tblheader" onclick="ifPop.CallFr(this);">Kode</td>
          <td id="OBAT_NAMA" class="tblheader" onclick="ifPop.CallFr(this);">Obat</td>
          <td align="center" id="NAMA" width="80" class="tblheader" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">HARGA SATUAN </td>
          <td width="40" class="tblheader" id="QTY_SATUAN" onclick="ifPop.CallFr(this);">QTY</td>
          <td id="HARGA_BELI_TOTAL" width="90" class="tblheader" onclick="ifPop.CallFr(this);">Total</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	  	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
		
		
		$sql="SELECT 
			  DATE_FORMAT(ap.TANGGAL, '%d-%m-%Y') AS tgl1,
			  ap.NOKIRIM,
			  SUM(ap.QTY_SATUAN) AS QTY_SATUAN,
			  /*ap.HARGA_BELI_SATUAN* (1 - (`DISKON` / 100))*/
			  ks.HARGA_SATUAN AS HARGA_BELI_SATUAN,
			  SUM(
				
				  ap.QTY_SATUAN * (ks.HARGA_SATUAN)
				
			  ) AS HARGA_BELI_TOTAL,
			  aus.nama NAMA_PEGAWAI,
			  mo.NO_BUKTI NO_PERMINTAAN,
			  ao.OBAT_KODE,
			  ao.OBAT_NAMA,
			  ao.OBAT_SATUAN_KECIL,
			  ak.NAMA,
			  au.UNIT_NAME 
			FROM
			  a_penerimaan ap 
			  INNER JOIN a_unit au 
				ON au.UNIT_ID = ap.UNIT_ID_TERIMA 
			  INNER JOIN a_obat ao 
				ON ap.OBAT_ID = ao.OBAT_ID 
			  INNER JOIN a_kepemilikan ak 
				ON ak.ID = ap.KEPEMILIKAN_ID 
			  INNER JOIN a_minta_obat mo 
				ON ap.FK_MINTA_ID = mo.permintaan_id
			  INNER JOIN a_kartustok ks ON ap.`ID` = ks.fkid 
			  LEFT JOIN a_user aus 
				ON ap.USER_ID_TERIMA = aus.pegawai_id 
WHERE ks.UNIT_ID = $idunit AND ap.TIPE_TRANS=1 and ap.QTY_SATUAN>0 and ap.TANGGAL between '$tgl_1' and '$tgl_2'".$unit_tj.$fkategori.$filter." AND au.UNIT_ID NOT IN(8,9)
		
		group by ap.NOKIRIM,ao.OBAT_NAMA,ak.NAMA,ap.HARGA_BELI_SATUAN order by ".$sorting;
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $tglkrm="";
	  $no_krm="";
	  $no_minta="";
	  $unit_t="";
	  
	  while ($rows=mysqli_fetch_array($rs)){
		$no_krm1=($no_krm==$rows['NOKIRIM'])?"&nbsp;":$rows['NOKIRIM'];
		$no_minta1=($no_minta==$rows['NO_PERMINTAAN'])?"&nbsp;":$rows['NO_PERMINTAAN'];
		if ($no_krm1!="&nbsp;"){
			$i++;
			$i1=$i;
			$tglx=$rows['tgl1'];
			$unit_t1=$rows['UNIT_NAME'];
		}else{
			$i1="&nbsp;";
			$tglx="&nbsp;";
			$unit_t1="&nbsp;";
			
		}
		
		$tglkrm=$rows['tgl1'];
		$no_krm=$rows['NOKIRIM'];
		$no_minta=$rows['NO_PERMINTAAN'];
		$unit_t=$rows['UNIT_NAME'];
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i1; ?></td>
          <td class="tdisi" align="center" ><?php echo $tglx; ?></td>
          <td class="tdisi" align="center"><?php echo $no_minta1; ?></td>
          <td class="tdisi" align="center"><?php echo $no_krm1; ?></td>
          <td class="tdisi" align="center"><?php echo $unit_t1; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_SATUAN'],2,",","."); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['HARGA_BELI_TOTAL'],2,",","."); ?></td>
        </tr>
        <?php 
	  }
		$sql2="select if(sum(t1.HARGA_BELI_TOTAL) is null,0,sum(t1.HARGA_BELI_TOTAL)) as SUB_TOTAL from (".$sql.") as t1";
	//	echo $sql2."<br>";
		$rs=mysqli_query($konek,$sql2);
		$subtotal=0;
		if ($rows=mysqli_fetch_array($rs)) $subtotal=$rows['SUB_TOTAL'];
	  	mysqli_free_result($rs);	  
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td colspan="10" align="right" class="tdisikiri">Sub Total&nbsp;&nbsp;</td>
          <td class="tdisi" align="right"><?php echo number_format($subtotal,0,",","."); ?></td>
        </tr>
      </table>
    <table width="90%" align="center" border="0" cellpadding="1" cellspacing="0">
      <tr>
	 <tr>
          <td colspan="" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="" align="right">
		<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="document.form1.act.value='paging';document.form1.page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="document.form1.act.value='paging';document.form1.page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;		</td>
        </tr>
	 <td align="center" colspan="2">
	 
	 <BUTTON type="button" onclick="PrintArea('cetak','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Pengeluaran Obat</BUTTON>
	  
	 <BUTTON type="button" onclick="PrintArea('cetak1','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Lampiran</BUTTON>
			
			
	 </td>
		</tr>
	  </table>
</div>


<div id="cetak" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  
      <table width="98%" align="center" border="1" cellpadding="1" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-collapse:collapse;">
	  	<tr>
	  	  <td colspan="6"><table width="98%" align="center" border="0" cellpadding="3" cellspacing="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
            <tr>
              <td colspan="4" align="left"><b>PT. PRIMA HUSADA CIPTA MEDAN</b></td>
            </tr>
            <tr>
              <td colspan="4" align="left"><b>
                <?=$namaRS;?>
              </b></td>
            </tr>
            <tr>
              <td colspan="4" align="left"><u>
                <?=$alamatRS;?>
                , Telp : &nbsp;
                <?=$tlpRS;?>
                , Fax :
                <?=$faxRS;?>
                &nbsp;Belawan </u></td>
            </tr>
            <tr>
              <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="center"><b><u>BUKTI PEMBUKUAN PENGELUARAN BARANG PERSEDIAAN </u> </b></td>
            </tr>
            <tr>
              <td colspan="4" align="center">No : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr style="vertical-align:top">
              <td width="30" align="left">1</td>
              <td colspan="3" align="left">Penanggung Jawab Gudang Persediaan harap mengeluarkan / menyerahkan barang persediaan sesuai Bon Barang terlampir </td>
            </tr>
            <tr style="vertical-align:top">
              <td align="left">2</td>
              <td colspan="2" width="15%" align="left" >Nomor Bon </td>
              <td width="" align="left" style="border-bottom:1px dashed">:</td>
            </tr>
            <tr style="vertical-align:top">
              <td align="left">3</td>
              <td colspan="2" align="left">Nilai Barang </td>
              <td align="left" style="border-bottom:1px dashed">: Rp. <?php echo number_format($subtotal,0,",","."); ?></td>
            </tr>
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
				  
				  
				  $bilangan= $subtotal;
				  $bilangan=terbilang($bilangan,3);
				  
				  //=====Bilangan setelah koma=====
				  $sakKomane=explode(".",$subtotal);
				  $koma=$sakKomane[1];
				  $koma=terbilang($koma,3);
				  
				  ?>
            <tr style="vertical-align:top">
              <td align="left">4</td>
              <td colspan="2" align="left">Terbilang</td>
              <td align="left" style="border-bottom:1px dashed">: <i><?php echo $bilangan."&nbsp;".$koma."Rupiah";?> </i></td>
            </tr>
            <tr style="vertical-align:top">
              <td align="left">5</td>
              <td colspan="2" align="left">Kepada</td>
              <td align="left" style="border-bottom:1px dashed">: Dr. Wahyudi Harahap, Sp.A </td>
            </tr>
            <tr style="vertical-align:top">
              <td align="left">6</td>
              <td colspan="2" align="left">Unit Kerja </td>
              <td align="left" style="border-bottom:1px dashed">: Bagian Instalasi Farmasi </td>
            </tr>
            <tr style="vertical-align:top">
              <td align="left">&nbsp;</td>
              <td colspan="3" align="left">&nbsp;</td>
            </tr>
          </table></td>
  	    </tr>
	  	
	  	<tr>
			<td colspan="6">
				<table width="100%" align="center" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
					<tr>
					  <td colspan="6" align="center"><b><u>KODE DAN NAMA REKENING</b></b></td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					  <td width="18%">&nbsp;</td>
					  <td width="23%">&nbsp;</td>
					  <td width="7%">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;Debet Buku Jurnal : </td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr >
					  <td align="right" style="border-bottom:1px ridge; border-right:1px ridge; border-top:1px groove;">810</td>
					  <td align="right" style="border-bottom:1px ridge;">&nbsp;</td>
					  <td width="38%" align="center" style="border-bottom:1px ridge;">B. RSPM </td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;" align="center"><?php echo number_format($subtotal,0,",","."); ?></td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
				  
				  <tr>
					  <td colspan="3">&nbsp;Debet Buku Bantu : </td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr >
					  <td colspan="2" align="right" style="border-bottom:1px ridge; border-right:1px ridge; border-top:1px groove;">810.02.07.02.04</td>
					  <td width="38%" align="center" style="border-bottom:1px ridge;">B.OBAT </td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;" align="center"><?php echo number_format($subtotal,0,",","."); ?></td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="2"  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="2"  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="3">&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
				  <tr>
					  <td colspan="3">&nbsp;Kredit Buku Bantu : </td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr >
					  <td width="6%" style="border-bottom:1px ridge; border-right:1px ridge; border-top:1px groove;" align="right">108</td>
					  <td width="8%" style="border-bottom:1px ridge; border-right:1px ridge; border-top:1px groove;" align="right">03</td>
					  <td width="38%" align="center" style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;" align="center"><?php echo number_format($subtotal,0,",","."); ?></td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="2"  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
					  <td colspan="2"  style="border-bottom:1px ridge; border-right:1px ridge;">&nbsp;</td>
					  <td  style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">Rp. &nbsp;</td>
					  <td style="border-bottom:1px ridge;">&nbsp;</td>
					  <td align="right">&nbsp;</td>
				  </tr>
					<tr>
						<td colspan="3">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>			</td>
		</tr>
		<tr align="center">
			<td colspan="3">BUKTI PROSES KEUANGAN </td>
		    <td width="24%">Telah Dibukukan </td>
		    <td width="22%">Buku Jurnal </td>
		    <td width="24%">Buku Bantu / Kartu </td>
		</tr>
		<tr align="center">
			<td width="11%">Tahapan Pembuatan </td>
		    <td width="9%">Masuk</td>
		    <td width="10%">Keluar</td>
		    <td>Tanggal Paraf Petugas </td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		  <td>DI</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="3" rowspan="4" align="center"><p>Belawan, <?php echo $tgl2; ?> </p>
	        <p>RS. PRIMA HUSADA CIPTA MEDAN </p>
	        <p>KEPALA</p>
          <p>&nbsp; </p>
		  <br><br><br>
		  Dr. AUSVIN GENIUSMAN KOMAINI, M.H.Kes</td>
	    </tr>
		<tr>
		  <td>DII</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
			<td>Verifikasi</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	    </tr>
		<tr>
			<td colspan="3" style="vertical-align:bottom"><br>
			  <br>
			<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
			<br>
		  Bentuk BP - JPB </td>
	    </tr>
	  </table>
	</div>


<div id="cetak1" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
          <tr>
          <td colspan="4" align="left"><b>PT. PRIMA HUSADA CIPTA MEDAN</b></td>
        </tr>
        <tr>
          <td colspan="4" align="left"><b><?=$namaRS;?></b></td>
        </tr>
        <tr>
          <td colspan="4" align="left"><u><?=$alamatRS;?>, Telp : &nbsp;<?=$tlpRS;?>, Fax :<?=$faxRS;?> &nbsp;Belawan </u></td>
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
		<tr>
          <td colspan="4" align="center"><b>BUKTI PENGELUARAN BARANG - BARANG PERSEDIAAN GUDANG FARMASI 
          </b></td> 
        </tr>
        <tr>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        
        <tr>
          <td width="16%" align="center"><div align="left">Periode</div></td> 
          <td width="2%" align="center">:</td>
          <td width="82%" colspan="2" align="center"><div align="left"><?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?></div></td>
        </tr>
        <tr>
          <td align="center"><div align="left">Unit Tujuan </div></td>
          <td align="center">:</td>
          <td colspan="2" align="center"><div align="left"><?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
			?>
          </div></td>
        </tr>
        <tr>
          <td align="center"><div align="left">Bentuk Obat </div></td>
          <td align="center">:</td>
          <td colspan="2" align="center"><div align="left"><?php if($kategori==""){echo 'Semua Bentuk Obat';}else{echo $kategori;}?>
          </div></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td> 
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center"><div align="left"></div></td>
        </tr>
      </table>
      <table width="98%" align="center" cellpadding="3" cellspacing="0" border="1" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;border-collapse:collapse; ">
        <tr style="text-align:center; font-weight:bold;">
          <td width="38" height="25">No</td>
          <td id="TANGGAL" width="92" >Tgl</td>
          <td align="center" id="a_penerimaan.ID" width="170" >No Minta </td>
          <td align="center" id="a_penerimaan.ID" width="170" >No Kirim</td>
          <td align="center" id="UNIT_NAME" width="248">Unit</td>
          <td width="431" id="OBAT_NAMA">Obat</td>
		  <td width="49" id="QTY_SATUAN">QTY</td>
          <td width="96" id="QTY_SATUAN">Harga Satuan </td>
          
          <td id="HARGA_BELI_TOTAL" width="104">Total</td>
        </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  $tglkrm="";
	  $no_krm="";
	  $no_minta="";
	  $unit_t="";
	  while ($rows=mysqli_fetch_array($rs)){
		$no_krm1=($no_krm==$rows['NOKIRIM'])?"&nbsp;":$rows['NOKIRIM'];
		$no_minta1=($no_minta==$rows['NO_PERMINTAAN'])?"&nbsp;":$rows['NO_PERMINTAAN'];
		if ($no_krm1!="&nbsp;"){
			$i++;
			$i1=$i;
			$tglx=$rows['tgl1'];
			$unit_t1=$rows['UNIT_NAME'];
		}else{
			$i1="&nbsp;";
			$tglx="&nbsp;";
			$unit_t1="&nbsp;";
		}
		
		$tglkrm=$rows['tgl1'];
		$no_krm=$rows['NOKIRIM'];
		$no_minta=$rows['NO_PERMINTAAN'];
		$unit_t=$rows['UNIT_NAME'];
		$nama=$rows['NAMA_PEGAWAI'];
	  ?>
        <tr> 
          <td  align="center" ><?php echo $i1; ?></td>
          <td  align="center" ><?php echo $tglx; ?></td>
          <td  align="center" ><?php echo $no_minta1; ?></td>
          <td  align="center" ><?php echo $no_krm1; ?></td>
          <td  align="center" ><?php echo $unit_t1; ?></td>
          <td align="left" ><?php echo $rows['OBAT_NAMA']; ?></td>
		  <td align="center" ><?php echo $rows['QTY_SATUAN']; ?></td>
          <td align="right" ><?php echo number_format($rows['HARGA_BELI_SATUAN'],0,",","."); ?></td>
          
          <td align="right" ><?php echo number_format($rows['HARGA_BELI_TOTAL'],0,",","."); ?></td>
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
	    <tr > 
          <td colspan="8" align="right">Sub Total&nbsp;&nbsp;</td>
          <td  align="right"><?php echo number_format($subtotal,0,",","."); ?></td>
        </tr>
      </table>
	  <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
  	    </tr>
	  	<tr>
			<td width="38%">Mengetahui : </td>
		    <td width="37%">Mengetahui : </td>
		    <td width="25%">Belawan, <? echo $tgl2; ?></td>
	  	</tr>
		<tr>
			<td>Kepala Bagian Penunjang Medik </td>
		    <td>Kepala Sub Bagian Farmasi </td>
		    <td>&nbsp;</td>
	  	</tr>
		<tr>
			<td></td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	  	</tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
			<td>(Dr. Wahyudi Harahap, Sp.A) </td>
		    <td>(Dr. Muhammad Rizqi Nasution)</td>
		    <td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) </td>
	  	</tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>Dikeluarkan Tanggal : </td>
		  <td>&nbsp;</td>
		  <td>Diterima Tanggal : </td>
	    </tr>
		<tr>
		  <td>Oleh : </td>
		  <td>&nbsp;</td>
		  <td>Oleh : </td>
	    </tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>Penanggung Jawah Gudang </td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		  <td>&nbsp;</td>
		  <td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ) </td>
	    </tr>
	  </table>
	  
</div>
</form>
</div>
</body>
</html>

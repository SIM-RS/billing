<?php 
include("../sesi.php");
include("../koneksi/konek.php");
if(!function_exists('tgl_ina')){
	function tgl_ina($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan   = getBulan(substr($tgl,5,2));
		$tahun   = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}
if(!function_exists('getBulan')){
	function getBulan($bln){
		switch ($bln){
		  case 1: 
		  return "Januari";
		  break;
		  case 2:
		  return "Februari";
		  break;
		  case 3:
		  return "Maret";
		  break;
		  case 4:
		  return "April";
		  break;
		  case 5:
		  return "Mei";
		  break;
		  case 6:
		  return "Juni";
		  break;
		  case 7:
		  return "Juli";
		  break;
		  case 8:
		  return "Agustus";
		  break;
		  case 9:
		  return "September";
		  break;
		  case 10:
		  return "Oktober";
		  break;
		  case 11:
		  return "November";
		  break;
		  case 12:
		  return "Desember";
		  break;
		}
	} 
}
//==========================================
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$id_gudang=$_SESSION["ses_id_gudang"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$unit_tujuan=$_REQUEST['unit_tujuan']; if ($unit_tujuan=="" || $unit_tujuan=="0") $unit_tujuan=$idunit;
if ($unit_tujuan=="0" || $unit_tujuan==$id_gudang) $unit_tj=""; else $unit_tj="ape.UNIT_ID=$unit_tujuan AND ";
$kategori=$_REQUEST['kategori']; if ($kategori=="" || $kategori=="0") $kat="ao.OBAT_GOLONGAN IN ('N','Psi')"; else $kat="ao.OBAT_GOLONGAN IN ('$kategori')";
$tgl_d=$_REQUEST['tgl_d'];if ($tgl_d=="") $tgl_d=$tgl;
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];if ($tgl_s=="") $tgl_s=$tgl;
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
$bln_se=getBulan($s[1]);
$thn_se=$s[2];
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
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
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	//winpopup.print();
	//winpopup.close();
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
	  <p><span class="jdltable">LAPORAN KHUSUS PENGGUNAAN MORPHIN DAN PETHIDIN<br/>INSTALASI FARMASI</span></p>
      <table width="48%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr>
          <td>Unit</td>
          <td>:<span class="jdltable">
            <select name="unit_tujuan" id="unit_tujuan" onchange="location='?f=../report/lap_penggunaan_MorfinPethidine.php&amp;tgl_d='+tgl_d.value+'&amp;tgl_s='+tgl_s.value+'&amp;unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
              <option value="0">All Unit</option>
              <?
	  			$qry = "select * from a_unit where UNIT_TIPE=2 and UNIT_ISAKTIF=1";
				$exe = mysqli_query($konek,$qry);
	  			while($show= mysqli_fetch_array($exe)){
				//$id=$show['UNIT_ID']
	  			?>
              <option value="<?php echo $show['UNIT_ID'];?>" class="txtinput" <?php if ($unit_tujuan==$show['UNIT_ID']) echo " selected"; ?>>
              <?=$show['UNIT_NAME'];?>
              </option>
              <? }?>
            </select>
          </span></td>
        </tr>
        <tr style="display:none">
          <td>Kategori</td>
          <td>:<span class="jdltable">
          <?php $ckat="ALL";?>
            <select name="kategori" id="kategori" onchange="location='?f=../report/lap_penggunaan_MorfinPethidine.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
              <option value="0">All</option>
              <option value="N"<?php if ($kategori=="N") {echo "selected";$ckat="Narkotika";}?>>Narkotika</option>
              <option value="Psi"<?php if ($kategori=="Psi") {echo "selected";$ckat="Psikotropika";}?>>Psikotropika</option>
            </select>
          </span></td>
        </tr>
        <tr>
        <td width="100">Bulan</td>
        <td>: 
      <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
      &nbsp;&nbsp;s/d&nbsp;&nbsp;
      <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lap_penggunaan_MorfinPethidine.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>         </td>
		</tr>
	  </table>
      <br />
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
      <tr class="headtable"> 
          <td width="25" height="25" rowspan="2" class="tblheaderkiri">NO</td>
          <td width="154" rowspan="2" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA SEDIAAN </td>
          <td width="70" rowspan="2" align="center" class="tblheader" id="NAMA">SATUAN</td>
          <td width="92" rowspan="2" align="center" class="tblheader" id="NAMA">PERSEDIAAN AWAL </td>
          <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden">RESEP</td>
          <td colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PASIEN</td>
          <td colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Dokter</td>
          <td width="82" rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PERSEDIAAN AKHIR</td>
          <td width="91" rowspan="2" class="tblheader" id="HARGA_BELI_TOTAL">KETERANGAN</td>
        </tr>
      <tr class="headtable"> 
      	<td width="75" align="center" class="tblheader" id="NAMA"><p>NOMOR/ TANGGAL</p>          </td>
        <td width="97" align="center" class="tblheader" id="NAMA">TGL PENYERAHAN </td>
        <td width="63" align="center" class="tblheader" id="NAMA">Jumlah</td>
        <td width="58" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Nama</td>
        <td width="75" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Alamat</td>
        <td width="95" align="center" class="tblheader" id="NAMA">NAMA</td>
        <td width="103" align="center" class="tblheader" id="NAMA">ALAMAT</td>
        </tr>
      <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
      	<td class="tdisikiri" align="center" style="font-size:12px;">1</td>
        <td class="tdisi" align="center">2</td>
        <td class="tdisi" align="center">3</td>
        <td class="tdisi" align="center">3</td>
        <td class="tdisi" align="center">4</td>
        <td align="center" class="tdisi">5</td>
        <td align="center" class="tdisi">6</td>
        <td align="center" class="tdisi">7</td>
        <td align="center" class="tdisi">8</td>
        <td class="tdisi" align="center">9</td>
        <td class="tdisi" align="center">10</td>
        <td class="tdisi" align="center">11</td>
        <td class="tdisi" align="center">12</td>
      </tr>
     
		<?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		/*$sql="SELECT ao.OBAT_NAMA,DATE_FORMAT(t1.TGL,'%d/%m/%Y') AS tgl1,t1.*,ak.NAMA,SUM(t1.QTY) AS QTY1,SUM(t1.QTY*t1.HARGA_SATUAN) AS NILAI FROM 
(SELECT PENERIMAAN_ID,TGL,NO_PENJUALAN,NO_PASIEN,NO_RESEP,SHIFT,QTY_RETUR,QTY,QTY_JUAL,HARGA_NETTO,HARGA_SATUAN,DOKTER,
RUANGAN,NAMA_PASIEN,ALAMAT FROM a_penjualan a WHERE ".$unit_tj."TGL BETWEEN '$tgl_de' AND '$tgl_se') AS t1 
INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID WHERE ".$kat." 
GROUP BY ao.OBAT_ID,ak.ID,t1.NAMA_PASIEN,t1.ALAMAT ORDER BY ".$sorting;*/
		$sql="select * from (SELECT 
  ao2.OBAT_NAMA,
  ao2.OBAT_SATUAN_KECIL,
  br.no_resep,
  DATE_FORMAT(br.tgl, '%d-%m-%Y') tglresep,
  DATE_FORMAT(ape.TGL_BAYAR, '%d-%m-%Y') tglserah,
  ape.QTY AS jumlah,
  bmp.nama,
  bmp.alamat,
  CONCAT(
    (
      CONCAT(
        (
          CONCAT(
            (CONCAT(bmp.alamat, ' RT.', bmp.rt)),
            ' RW.',
            bmp.rw
          )
        ),
        ', Desa ',
        w.nama
      )
    ),
    ', Kecamatan ',
    wi.nama
  ) alamat_,
  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(bmp.tgl_lahir, '%Y') - (
    DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(bmp.tgl_lahir, '00-%m-%d')
  ) AS umur,
  br.dokter_nama namadokter,
  bpe.nama namadokter2,
  bmr.nama spesialis,
  '-' AS ket 
FROM
  {$dbbilling}.b_resep br 
  INNER JOIN {$dbbilling}.b_ms_pegawai bpe 
    ON bpe.id = br.dokter_id 
  INNER JOIN {$dbbilling}.b_ms_reference bmr 
    ON bmr.id = bpe.spesialisasi_id 
  INNER JOIN {$dbbilling}.b_pelayanan bp 
    ON bp.id = br.id_pelayanan 
  INNER JOIN {$dbbilling}.b_ms_pasien bmp 
    ON bmp.id = bp.pasien_id 
  LEFT JOIN {$dbbilling}.b_ms_wilayah w 
    ON bmp.desa_id = w.id 
  LEFT JOIN {$dbbilling}.b_ms_wilayah wi 
    ON bmp.kec_id = wi.id 
  INNER JOIN rspelindo_apotek.a_obat ao 
    ON ao.OBAT_ID = br.obat_id 
  INNER JOIN rspelindo_apotek.a_penjualan ape 
    ON ape.ID = br.penjualan_id 
  INNER JOIN rspelindo_apotek.a_penerimaan ap 
    ON ap.ID = ape.PENERIMAAN_ID 
  INNER JOIN rspelindo_apotek.a_obat ao2 
    ON ao2.OBAT_ID = ap.OBAT_ID
WHERE
	".$unit_tj."
	(ao.OBAT_GOLONGAN = 'M' OR ao.OBAT_GOLONGAN = 'P') AND
	ape.TGL BETWEEN '$tgl_de' AND '$tgl_se' ORDER BY br.tgl) as t1".$filter.""; //ORDER BY OBAT_NAMA 
	
	
	$sql = "  SELECT 
  b.`OBAT_NAMA` NAMA,
  b.`OBAT_SATUAN_KECIL` SATUAN,
  a.`STOK_BEFOR` PERSEDIAAN_AWAL,
  a.`NO_BUKTI` NO_PENJUALAN,
  DATE_FORMAT(  a.`TGL_TRANS`, '%d-%m-%Y')  TGL,
  a.`KREDIT` JUMLAH,
  c.`NAMA_PASIEN`,
  c.`ALAMAT`,
  c.`DOKTER`,
  d.`alamat` ALAMAT_DONTER,
  a.`STOK_AFTER` PERSEDIAAN_AKHIR
  FROM a_kartustok a 
  INNER JOIN `a_obat` b ON a.`OBAT_ID` = b.`OBAT_ID`
  INNER JOIN a_penjualan c ON a.`NO_BUKTI` = c.`NO_PENJUALAN`
  INNER JOIN `rspelindo_billing`.`b_ms_pegawai` d ON c.DOKTER=d.`nama` WHERE a.TGL_TRANS BETWEEN '$tgl_de' AND '$tgl_se' AND b.`OBAT_GOLONGAN` IN ('M','P')
  GROUP BY a.`ID`
  ORDER BY a.OBAT_ID, a.ID DESC";
	 
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
	  $tmpObat='';
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?>&nbsp;</td>
		<?php
		if($tmpObat != $rows['NAMA']){
		?>
          <td class="tdisi" align="left"><?php echo $rows['NAMA']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows['SATUAN']; ?></td>
		<?php
		} else {
		?>
		
		  <td class="tdisi" align="left">&nbsp;</td>
          <td class="tdisi" align="center">&nbsp;</td>
		  
		  <?php } $tmpObat = $rows['NAMA'];?>
		  
          <td class="tdisi" align="center"><?php echo number_format($rows['PERSEDIAAN_AWAL'],0,",","."); ?></td>
          <td align="center" class="tdisi"><?php echo $rows['NO_PENJUALAN']." / ".$rows['TGL']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['TGL']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['JUMLAH']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['NAMA_PASIEN']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['ALAMAT']; ?></td>
          <td align="center" class="tdisi"><?php echo $rows['DOKTER']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['ALAMAT_DOKTER']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo number_format($rows['PERSEDIAAN_AKHIR'],0,",","."); ?></td>
          <td class="tdisi" align="center"><?php echo $rows['ket']; ?>&nbsp;</td>
		 
        </tr>
        <?php 
	  }
		
	  ?>
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
	 <td align="center" colspan="2">&nbsp;
		    <BUTTON type="button" onclick="PrintArea('cetak','#')" <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Lap. NAPZA</BUTTON>
	 </td>
		</tr>
	  </table>
</div>
<div id="cetak" style="display:none">
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
	  <table width="98%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="2" align="center" class="jdltable"><p><u>LAPORAN PENGGUNAAN MORFIN DAN PETHIDINE</u>
              </p></td>
        </tr>
        <tr style="display:none"> 
          <td colspan="2" align="center">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> 
            ) </td>
        </tr>
      </table>
      <?
	  	$query = "SELECT * FROM a_unit WHERE unit_id = '$unit_tujuan'";
		$dUnit =mysqli_fetch_array(mysqli_query($konek,$query));
      ?>
      <table width="84%" align="center" cellpadding="1" cellspacing="0" border="0">
      	<tr>
         <td width="12%" align="left" style="font-size:12px;">NAMA SARANA </td>
         <td colspan="5" align="left" style="font-size:12px;">: RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN</td>
         <td width="16%" colspan="-1" align="left" style="font-size:12px;">&nbsp;</td>
         <td width="13%" colspan="-1" align="left" style="font-size:12px;">FORM - N 19 </td>
         <td width="16%" align="left" style="font-size:12px;">&nbsp;</td>
      	</tr>
        <tr>
         <td align="left" style="font-size:12px;">NO. SIPA </td>
         <td colspan="5" align="left" style="font-size:12px;">: 445 / 28257 / VII / 2016</td>
         <td colspan="-1" align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="-1" align="left" style="font-size:12px;">BULAN</td>
         <td align="left" style="font-size:12px;">: <?php echo $bln_se?></td>
        </tr>
        <tr>
         <td align="left" style="font-size:12px;">ALAMAT/TELP</td>
         <td colspan="5" align="left" style="font-size:12px;">: JL. STASIUN  NO. 92 BELAWAN/TELP. 061 - 6940120<br/>          </td>
         <td colspan="-1" align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="-1" align="left" style="font-size:12px;">TAHUN</td>
         <td align="left" style="font-size:12px;">: <?php echo $thn_se?></td>
        </tr>
        <tr>
         <td align="left" style="font-size:12px;">KAB/KOTA </td>
         <td colspan="3" align="left" style="font-size:12px;">: MEDAN </td>
         <td width="3%" colspan="-1" align="left">&nbsp;</td>
         <td width="12%" colspan="-1" align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="-1" align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="2" align="left" style="font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr>
         <td colspan="13" align="center" style="font-size:12px;"><table width="99%" align="center" cellpadding="1" cellspacing="0" border="0">
           <tr class="headtable">
             <td width="25" height="25" rowspan="2" class="tblheaderkiri">NO</td>
             <td width="154" rowspan="2" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA SEDIAAN </td>
             <td width="70" rowspan="2" align="center" class="tblheader" id="NAMA">SATUAN</td>
             <td width="92" rowspan="2" align="center" class="tblheader" id="NAMA">PERSEDIAAN AWAL </td>
             <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden">RESEP</td>
             <td colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PASIEN</td>
             <td colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Dokter</td>
             <td width="82" rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PERSEDIAAN AKHIR</td>
             <td width="91" rowspan="2" class="tblheader" id="HARGA_BELI_TOTAL">KETERANGAN</td>
           </tr>
           <tr class="headtable">
             <td width="75" align="center" class="tblheader" id="NAMA"><p>NOMOR/ TANGGAL</p></td>
             <td width="97" align="center" class="tblheader" id="NAMA">TGL PENYERAHAN </td>
             <td width="63" align="center" class="tblheader" id="NAMA">Jumlah</td>
             <td width="58" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Nama</td>
             <td width="75" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Alamat</td>
             <td width="95" align="center" class="tblheader" id="NAMA">NAMA</td>
             <td width="103" align="center" class="tblheader" id="NAMA">ALAMAT</td>
           </tr>
           <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
             <td class="tdisikiri" align="center" style="font-size:12px;">1</td>
             <td class="tdisi" align="center">2</td>
             <td class="tdisi" align="center">3</td>
             <td class="tdisi" align="center">3</td>
             <td class="tdisi" align="center">4</td>
             <td align="center" class="tdisi">5</td>
             <td align="center" class="tdisi">6</td>
             <td align="center" class="tdisi">7</td>
             <td align="center" class="tdisi">8</td>
             <td class="tdisi" align="center">9</td>
             <td class="tdisi" align="center">10</td>
             <td class="tdisi" align="center">11</td>
             <td class="tdisi" align="center">12</td>
           </tr>
           <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
		/*$sql="SELECT ao.OBAT_NAMA,DATE_FORMAT(t1.TGL,'%d/%m/%Y') AS tgl1,t1.*,ak.NAMA,SUM(t1.QTY) AS QTY1,SUM(t1.QTY*t1.HARGA_SATUAN) AS NILAI FROM 
(SELECT PENERIMAAN_ID,TGL,NO_PENJUALAN,NO_PASIEN,NO_RESEP,SHIFT,QTY_RETUR,QTY,QTY_JUAL,HARGA_NETTO,HARGA_SATUAN,DOKTER,
RUANGAN,NAMA_PASIEN,ALAMAT FROM a_penjualan a WHERE ".$unit_tj."TGL BETWEEN '$tgl_de' AND '$tgl_se') AS t1 
INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID WHERE ".$kat." 
GROUP BY ao.OBAT_ID,ak.ID,t1.NAMA_PASIEN,t1.ALAMAT ORDER BY ".$sorting;*/
		$sql="select * from (SELECT 
  ao2.OBAT_NAMA,
  ao2.OBAT_SATUAN_KECIL,
  br.no_resep,
  DATE_FORMAT(br.tgl, '%d-%m-%Y') tglresep,
  DATE_FORMAT(ape.TGL_BAYAR, '%d-%m-%Y') tglserah,
  ape.QTY AS jumlah,
  bmp.nama,
  bmp.alamat,
  CONCAT(
    (
      CONCAT(
        (
          CONCAT(
            (CONCAT(bmp.alamat, ' RT.', bmp.rt)),
            ' RW.',
            bmp.rw
          )
        ),
        ', Desa ',
        w.nama
      )
    ),
    ', Kecamatan ',
    wi.nama
  ) alamat_,
  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(bmp.tgl_lahir, '%Y') - (
    DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(bmp.tgl_lahir, '00-%m-%d')
  ) AS umur,
  br.dokter_nama namadokter,
  bpe.nama namadokter2,
  bmr.nama spesialis,
  '-' AS ket 
FROM
  {$dbbilling}.b_resep br 
  INNER JOIN {$dbbilling}.b_ms_pegawai bpe 
    ON bpe.id = br.dokter_id 
  INNER JOIN {$dbbilling}.b_ms_reference bmr 
    ON bmr.id = bpe.spesialisasi_id 
  INNER JOIN {$dbbilling}.b_pelayanan bp 
    ON bp.id = br.id_pelayanan 
  INNER JOIN {$dbbilling}.b_ms_pasien bmp 
    ON bmp.id = bp.pasien_id 
  LEFT JOIN {$dbbilling}.b_ms_wilayah w 
    ON bmp.desa_id = w.id 
  LEFT JOIN {$dbbilling}.b_ms_wilayah wi 
    ON bmp.kec_id = wi.id 
  INNER JOIN rspelindo_apotek.a_obat ao 
    ON ao.OBAT_ID = br.obat_id 
  INNER JOIN rspelindo_apotek.a_penjualan ape 
    ON ape.ID = br.penjualan_id 
  INNER JOIN rspelindo_apotek.a_penerimaan ap 
    ON ap.ID = ape.PENERIMAAN_ID 
  INNER JOIN rspelindo_apotek.a_obat ao2 
    ON ao2.OBAT_ID = ap.OBAT_ID
WHERE
	".$unit_tj."
	(ao.OBAT_GOLONGAN = 'M' OR ao.OBAT_GOLONGAN = 'P') AND
	ape.TGL BETWEEN '$tgl_de' AND '$tgl_se' ORDER BY br.tgl) as t1".$filter.""; //ORDER BY OBAT_NAMA 
	
	
	$sql = "  SELECT 
  b.`OBAT_NAMA` NAMA,
  b.`OBAT_SATUAN_KECIL` SATUAN,
  a.`STOK_BEFOR` PERSEDIAAN_AWAL,
  a.`NO_BUKTI` NO_PENJUALAN,
  DATE_FORMAT(  a.`TGL_TRANS`, '%d-%m-%Y')  TGL,
  a.`KREDIT` JUMLAH,
  c.`NAMA_PASIEN`,
  c.`ALAMAT`,
  c.`DOKTER`,
  d.`alamat` ALAMAT_DONTER,
  a.`STOK_AFTER` PERSEDIAAN_AKHIR
  FROM a_kartustok a 
  INNER JOIN `a_obat` b ON a.`OBAT_ID` = b.`OBAT_ID`
  INNER JOIN a_penjualan c ON a.`NO_BUKTI` = c.`NO_PENJUALAN`
  INNER JOIN `rspelindo_billing`.`b_ms_pegawai` d ON c.DOKTER=d.`nama` WHERE a.TGL_TRANS BETWEEN '$tgl_de' AND '$tgl_se' AND b.`OBAT_GOLONGAN` IN ('M','P')
  GROUP BY a.`ID`
  ORDER BY a.OBAT_ID, a.ID DESC";
	 
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
	  $tmpObat = '';
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
           <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
             <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?>&nbsp;</td>
			<?php
			if($tmpObat != $rows['NAMA']){
			?>
			<td class="tdisi" align="left"><?php echo $rows['NAMA']; ?>&nbsp;</td>
			<td class="tdisi" align="center"><?php echo $rows['SATUAN']; ?></td>
			<?php
			} else {
			
			?>
			
			<td class="tdisi" align="left"></td>
			<td class="tdisi" align="center"></td>
			
		  <?php } $tmpObat = $rows['NAMA']; ?>
             
             <td class="tdisi" align="center"><?php echo number_format($rows['PERSEDIAAN_AWAL'],0,",","."); ?></td>
             <td align="center" class="tdisi"><?php echo $rows['NO_PENJUALAN']." / ".$rows['TGL']; ?>&nbsp;</td>
             <td align="center" class="tdisi"><?php echo $rows['TGL']; ?></td>
             <td align="center" class="tdisi"><?php echo $rows['JUMLAH']; ?></td>
             <td align="center" class="tdisi"><?php echo $rows['NAMA_PASIEN']; ?></td>
             <td align="center" class="tdisi"><?php echo $rows['ALAMAT']; ?></td>
             <td align="center" class="tdisi"><?php echo $rows['DOKTER']; ?>&nbsp;</td>
             <td align="center" class="tdisi"><?php echo $rows['ALAMAT_DOKTER']; ?>&nbsp;</td>
             <td align="center" class="tdisi"><?php echo number_format($rows['PERSEDIAAN_AKHIR'],0,",","."); ?></td>
             <td class="tdisi" align="center"><?php echo $rows['ket']; ?>&nbsp;</td>
           </tr>
           <?php 
	  }
		
	  ?>
         </table></td>
        </tr>
   
  
      <tr>
         <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="3" align="center" style="font-size:12px;">Mengetahu,</td>
         <td width="11%" align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center" style="font-size:12px;">Belawan, <?php echo tgl_ina(date('Y-m-d')); ?></td>
      </tr>
      <tr>
         <td colspan="3" align="center" style="font-size:12px;">Asmen Penunjang Medik</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center" style="font-size:12px;">PENANGGUNG JAWAB</td>
      </tr>
      <tr>
         <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center" style="font-size:12px;">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="7" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="3" align="center" style="font-size:12px;"><b>dr. M. RIZQI NASUTION</b></td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td width="6%" align="center" style="font-size:12px;">&nbsp;</td>
         <td width="11%" align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="4" align="center" style="font-size:12px;"><u><b>FUJI ASTUTI, S.Si, Apt</b></u></td>
      </tr>
      <tr>
         <td colspan="7" align="center">&nbsp;</td>
         <td colspan="4" align="center" style="font-size:12px;">NO. SIPA : 445 / 28257 / VII / 2016</td>
      </tr>
      </table>
	</div>
</form>
</div>
</body>
</html>

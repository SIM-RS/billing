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
            <select name="unit_tujuan" id="unit_tujuan" onchange="location='?f=../report/lap_sediaan_napza_MP.php&amp;tgl_d='+tgl_d.value+'&amp;tgl_s='+tgl_s.value+'&amp;unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
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
            <select name="kategori" id="kategori" onchange="location='?f=../report/lap_sediaan_napza_MP.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
              <option value="0">All</option>
              <option value="N"<?php if ($kategori=="N") {echo "selected";$ckat="Narkotika";}?>>Narkotika</option>
              <option value="Psi"<?php if ($kategori=="Psi") {echo "selected";$ckat="Psikotropika";}?>>Psikotropika</option>
            </select>
          </span></td>
        </tr>
        <tr>
        <td width="100">Tgl Periode</td>
        <td>: 
      <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /> 
      <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
      &nbsp;&nbsp;s/d&nbsp;&nbsp;
      <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" > 
      <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />&nbsp;&nbsp;<button type="button" onclick="location='?f=../report/lap_sediaan_napza_MP.php&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&unit_tujuan='+unit_tujuan.value+'&kategori='+kategori.value">
			  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button>         </td>
		</tr>
	  </table>
      <br />
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
      <tr class="headtable"> 
          <td width="23" height="25" rowspan="2" class="tblheaderkiri">NO</td>
          <td width="153" rowspan="2" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA NARKOTIKA </td>
          <td width="69" rowspan="2" align="center" class="tblheader" id="NAMA">SATUAN</td>
          <td colspan="2" align="center" class="tblheader" style="border-bottom:hidden">RESEP</td>
          <td rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">JUMLAH</td>
          <td width="255" colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PASIEN</td>
          <td width="255" colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">DOKTER</td>
          <td width="60" rowspan="2" class="tblheader" id="HARGA_BELI_TOTAL">KETERANGAN</td>
        </tr>
      <tr class="headtable"> 
      	<td width="65" align="center" class="tblheader" id="NAMA"><p>NOMOR/ TANGGAL</p>          </td>
        <td width="97" align="center" class="tblheader" id="NAMA">TGL PENYERAHAN </td>
        <td width="81" align="center" class="tblheader" id="NAMA">NAMA</td>
        <td width="104" align="center" class="tblheader" id="NAMA">ALAMAT</td>
        <td width="81" align="center" class="tblheader" id="NAMA">NAMA</td>
        <td width="104" align="center" class="tblheader" id="NAMA">SPESIALIS</td>
      </tr>
      <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
      	<td class="tdisikiri" align="center" style="font-size:12px;">1</td>
        <td class="tdisi" align="center">2</td>
        <td class="tdisi" align="center">3</td>
        <td class="tdisi" align="center">4</td>
        <td class="tdisi" align="center">5</td>
        <td class="tdisi" align="center">6</td>
        <td class="tdisi" align="center">7</td>
        <td class="tdisi" align="center">8</td>
        <td class="tdisi" align="center">9</td>
        <td class="tdisi" align="center">10</td>
        <td class="tdisi" align="center">11</td>
      </tr>
        <!--<tr class="headtable"> 
          <td width="23" height="25" rowspan="3" class="tblheaderkiri">NO</td>
          <td width="153" rowspan="3" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA SEDIAAN </td>
          <td width="69" rowspan="3" align="center" class="tblheader" id="NAMA">SATUAN</td>
          <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden">RESEP</td>
          <td colspan="5" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PASIEN</td>
          <td colspan="2" rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">Kepemilikan</td>
          <td width="60" rowspan="3" class="tblheader" id="HARGA_BELI_TOTAL">KET</td>
        </tr>
        <tr class="headtable">
          <td width="65" rowspan="2" align="center" class="tblheader" id="NAMA"><p>NOMOR/ TANGGAL</p>          </td>
          <td width="97" rowspan="2" align="center" class="tblheader" id="NAMA">TGL PENYERAHAN </td>
          <td width="56" rowspan="2" align="center" class="tblheader" id="NAMA">JUMLAH</td>
          <td width="81" rowspan="2" align="center" class="tblheader" id="NAMA">NAMA</td>
          <td width="104" rowspan="2" align="center" class="tblheader" id="NAMA">ALAMAT</td>
          <td colspan="3" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">KELOMPOK UMUR </td>
        </tr>
        <tr class="headtable">
          <td width="54" align="center" class="tblheader" id="NAMA">0-12 BLN </td>
          <td width="55" align="center" class="tblheader" id="NAMA">1-9 THN </td>
          <td width="60" align="center" class="tblheader" id="NAMA">DEWASA</td>
          <td width="103" align="center" class="tblheader" id="NAMA">NAMA DOKTER </td>
          <td width="98" align="center" class="tblheader" id="NAMA">SPESIALISASI</td>
        </tr>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;">&nbsp;</td>
          <td class="tdisi" align="left">&nbsp;</td>
          <td class="tdisi" align="left">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td class="tdisi" align="right">&nbsp;</td>
        </tr>
		<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;">1</td>
          <td class="tdisi" align="center">2</td>
          <td class="tdisi" align="center">3</td>
          <td align="center" class="tdisi">4</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">5</td>
          <td align="center" class="tdisi">6</td>
          <td align="center" class="tdisi">7</td>
          <td align="center" class="tdisi">8</td>
          <td align="center" class="tdisi">9</td>
          <td align="center" class="tdisi">10</td>
          <td align="center" class="tdisi">11</td>
          <td align="center" class="tdisi">12</td>
          <td class="tdisi" align="center">13</td>
        </tr>-->
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
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?>&nbsp;</td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['no_resep']."/ ".$rows['tglresep']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['tglserah']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['jumlah']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['nama']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['alamat_']; ?>&nbsp;</td>
          <!--<td align="center" class="tdisi"><?php if($rows['umur']<=1){ ?>&radic;<?php }?>&nbsp;</td>
          <td align="center" class="tdisi"><?php if($rows['umur']>=1 && $rows['umur']<=9){ ?>&radic;<?php }?>&nbsp;</td>-->
          <!--<td align="center" class="tdisi"><?php if($rows['umur']>9){ ?>&radic;<?php }?>&nbsp;</td>-->
          <td align="center" class="tdisi"><?php echo $rows['namadokter']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['spesialis']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows['ket']; ?>&nbsp;</td>
        </tr>
        <?php 
	  }
		/*$sql2="select if(sum(t2.NILAI) is null,0,sum(t2.NILAI)) as SUB_TOTAL from (".$sql.") as t2";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql2);
		$subtotal=0;
		if ($rows=mysqli_fetch_array($rs)) $subtotal=$rows['SUB_TOTAL'];
	  	mysqli_free_result($rs);*/	  
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
          <td colspan="2" align="center" class="jdltable"><p>LAPORAN KHUSUS PENGGUNAAN MORPHIN DAN PETHIDIN<!--<br/>INSTALASI FARMASI<br>
              UNIT : -->
            <?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				
				//edit by bagus
				//echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
			?>
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
      <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
      	<tr>
         <td colspan="3" align="left" style="font-size:12px;">Nama RS</td>
         <td colspan="5" align="left" style="font-size:12px;">: <?=$dUnit['UNIT_NAME']."&nbsp;";?>Rumah Sakit Umum Daerah Kota Tangerang</td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">Bulan</td>
         <td colspan="3" align="left" style="font-size:12px;">: <?php echo $bln_se?></td>
        </tr>
        <tr>
         <td colspan="3" align="left" style="font-size:12px;">SIA</td>
         <td colspan="5" align="left" style="font-size:12px;">: </td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">Tahun</td>
         <td colspan="3" align="left" style="font-size:12px;">: <?php echo $thn_se?></td>
        </tr>
        <tr>
         <td colspan="3" align="left" style="font-size:12px;">Alamat & Tlp</td>
         <td colspan="5" align="left" style="font-size:12px;">: JL. Jenderal Sudirman, Kel.Kelapa Indah, Kec.Tangerang<br/>&nbsp;&nbsp;Kota Tangerang</td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="3" align="left" style="font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
         <td colspan="3" align="left" style="font-size:12px;">Telpon</td>
         <td colspan="5" align="left" style="font-size:12px;">: (021) 29720201-03</td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="3" align="left" style="font-size:12px;">&nbsp;</td>
        </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
       <!-- <tr class="headtable"> 
          <td width="23" height="25" rowspan="3" class="tblheaderkiri">NO</td>
          <td width="153" rowspan="3" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA SEDIAAN </td>
          <td width="69" rowspan="3" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">SATUAN</td>
          <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden" onclick="ifPop.CallFr(this);">RESEP</td>
          <td colspan="5" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden" onclick="ifPop.CallFr(this);">PASIEN</td>
          <td colspan="2" rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden" onclick="ifPop.CallFr(this);">Kepemilikan</td>
          <td width="60" rowspan="3" class="tblheader" id="HARGA_BELI_TOTAL" onclick="ifPop.CallFr(this);">KET</td>
        </tr>
        <tr class="headtable">
          <td width="65" rowspan="2" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);"><p>NOMOR/ TANGGAL</p>          </td>
          <td width="97" rowspan="2" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">TGL PENYERAHAN </td>
          <td width="56" rowspan="2" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">JUMLAH</td>
          <td width="81" rowspan="2" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">NAMA</td>
          <td width="104" rowspan="2" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">ALAMAT</td>
          <td colspan="3" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden" onclick="ifPop.CallFr(this);">KELOMPOK UMUR </td>
        </tr>
        <tr class="headtable">
          <td width="54" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">0-12 BLN </td>
          <td width="55" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">1-9 THN </td>
          <td width="60" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">DEWASA</td>
          <td width="103" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">NAMA DOKTER </td>
          <td width="98" align="center" class="tblheader" id="NAMA" onclick="ifPop.CallFr(this);">SPESIALISASI</td>
        </tr>
		<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;">&nbsp;</td>
          <td class="tdisi" align="left">&nbsp;</td>
          <td class="tdisi" align="left">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="left" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td class="tdisi" align="right">&nbsp;</td>
        </tr>
		<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;">1</td>
          <td class="tdisi" align="center">2</td>
          <td class="tdisi" align="center">3</td>
          <td align="center" class="tdisi">4</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <td align="center" class="tdisi">5</td>
          <td align="center" class="tdisi">6</td>
          <td align="center" class="tdisi">7</td>
          <td align="center" class="tdisi">8</td>
          <td align="center" class="tdisi">9</td>
          <td align="center" class="tdisi">10</td>
          <td align="center" class="tdisi">11</td>
          <td align="center" class="tdisi">12</td>
          <td class="tdisi" align="center">13</td>
        </tr>-->
        <tr class="headtable"> 
          <td width="23" height="25" rowspan="2" class="tblheaderkiri">NO</td>
          <td width="153" rowspan="2" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA NARKOTIKA </td>
          <td width="69" rowspan="2" align="center" class="tblheader" id="NAMA">SATUAN</td>
          <td colspan="2" align="center" class="tblheader" style="border-bottom:hidden">RESEP</td>
          <td rowspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">JUMLAH</td>
          <td width="255" colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">PASIEN</td>
          <td width="255" colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">DOKTER</td>
          <td width="60" rowspan="2" class="tblheader" id="HARGA_BELI_TOTAL">KETERANGAN</td>
        </tr>
      <tr class="headtable"> 
      	<td width="65" align="center" class="tblheader" id="NAMA"><p>NOMOR/ TANGGAL</p>          </td>
        <td width="97" align="center" class="tblheader" id="NAMA">TGL PENYERAHAN </td>
        <td width="81" align="center" class="tblheader" id="NAMA">NAMA</td>
        <td width="104" align="center" class="tblheader" id="NAMA">ALAMAT</td>
        <td width="81" align="center" class="tblheader" id="NAMA">NAMA</td>
        <td width="104" align="center" class="tblheader" id="NAMA">SPESIALIS</td>
      </tr>
      <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
      	<td class="tdisikiri" align="center" style="font-size:12px;">1</td>
        <td class="tdisi" align="center">2</td>
        <td class="tdisi" align="center">3</td>
        <td class="tdisi" align="center">4</td>
        <td class="tdisi" align="center">5</td>
        <td class="tdisi" align="center">6</td>
        <td class="tdisi" align="center">7</td>
        <td class="tdisi" align="center">8</td>
        <td class="tdisi" align="center">9</td>
        <td class="tdisi" align="center">10</td>
        <td class="tdisi" align="center">11</td>
      </tr>
        <?php 
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?>&nbsp;</td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['no_resep']."/ ".$rows['tglresep']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['tglserah']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['jumlah']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['nama']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['alamat_']; ?>&nbsp;</td>
          <!--<td align="center" class="tdisi"><?php if($rows['umur']<=1){ ?>&radic;<?php }?>&nbsp;</td>
          <td align="center" class="tdisi"><?php if($rows['umur']>=1 && $rows['umur']<=9){ ?>&radic;<?php }?>&nbsp;</td>-->
          <!--<td align="center" class="tdisi"><?php if($rows['umur']>9){ ?>&radic;<?php }?>&nbsp;</td>-->
          <td align="center" class="tdisi"><?php echo $rows['namadokter']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows['spesialis']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows['ket']; ?>&nbsp;</td>
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center" style="font-size:12px;">Tangerang, <?php echo tgl_ina(date('Y-m-d')); ?></td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center" style="font-size:12px;">Penanggung Jawab Instalasi Farmasi</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center" style="font-size:12px;">Rumah Sakit Umum Daerah Kota Tangerang</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center" style="font-size:12px;"><u>Laila Shafarina, S.Farm, Apt</u></td>
      </tr>
      <tr>
         <td colspan="9" align="center">&nbsp;</td>
         <td colspan="5" align="center" style="font-size:12px;">SIPA NO</td>
      </tr>
      </table>
	</div>
</form>
</div>
</body>
</html>

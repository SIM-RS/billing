<?
include "../sesi.php";
include("../koneksi/konek.php");
$bln=$_REQUEST['bulan'];
$thn=$_REQUEST['tahun'];

if ($bln==""){
	  $bln=date('m');
	  $thn=date('Y');
	  }


switch ($bln){
	case '1': $namabulan = 'Januari'; break;
	case '2': $namabulan = 'Pebruari'; break;
	case '3': $namabulan = 'Maret'; break;
	case '4': $namabulan = 'April'; break;
	case '5': $namabulan = 'Mei'; break;
	case '6': $namabulan = 'Juni'; break;
	case '7': $namabulan = 'Juli'; break;
	case '8': $namabulan = 'Agustus'; break;
	case '9': $namabulan = 'September'; break;
	case '10': $namabulan = 'Oktober'; break;
	case '11': $namabulan = 'Nopember'; break;
	case '12': $namabulan = 'Desember'; break;      
   }	
  
$month=$bln+1;
$year=$thn;
if ($month==13){
	$month=1;
	$year=$thn+1;
	}else{
	  $year=$thn;	  
	}
$kueri="SELECT DAY((SELECT LAST_DAY('$thn-$bln-01')))";
$sdl=mysql_query($kueri);
$datad=mysql_fetch_array($sdl);
//echo $kueri;
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {font-family: Calibri;
		font-size: 14px}

-->
</style>
</head>

<body>
<table width="980" border="0" align="center">
  <tr class="style1" align="center">
    <td colspan="2"></select>
	  
	  Bulan&nbsp;&nbsp; 
		<select name="bulan" id="bulan">
		<option value="1"<?php if ($bln=="1") echo " selected";?>>Januari</option>
		<option value="2"<?php if ($bln=="2") echo " selected";?>>Pebruari</option>
		<option value="3"<?php if ($bln=="3") echo " selected";?>>Maret</option>
		<option value="4"<?php if ($bln=="4") echo " selected";?>>April</option>
		<option value="5"<?php if ($bln=="5") echo " selected";?>>Mei</option>
		<option value="6"<?php if ($bln=="6") echo " selected";?>>Juni</option>
		<option value="7"<?php if ($bln=="7") echo " selected";?>>Juli</option>
		<option value="8"<?php if ($bln=="8") echo " selected";?>>Agustus</option>
		<option value="9"<?php if ($bln=="9") echo " selected";?>>September</option>
		<option value="10"<?php if ($bln=="10") echo " selected";?>>Oktober</option>
		<option value="11"<?php if ($bln=="11") echo " selected";?>>Nopember</option>
		<option value="12"<?php if ($bln=="12") echo " selected";?>>Desember</option>
        </select>
&nbsp;&nbsp;Tahun&nbsp;&nbsp;
<select name="tahun" id="tahun">
        <?php 
		$tahun=date('Y');
		for ($i=$tahun-4;$i<$tahun+4;$i++) {?>
        <option value="<?php echo $i; ?>" <?php if ($i==$thn) echo "selected"; ?>><?php echo $i; ?></option>
    	<?php }?>
  </select>
&nbsp;
  <button type="button" onclick="location='?f=../report/lap_neraca_saldo.php&bulan='+bulan.value+'&tahun='+tahun.value">
  <img src="../icon/lihat.gif" height="16" width="16" border="0" />&nbsp; Lihat</button></td>
  </tr>
  <tr  class="bodyText12" >
    <td><?=strtoupper($namaRS);?><br />
KERTAS KERJA LAPORAN KEUANGAN<br />
UNTUK TAHUN YANG BERAKHIR TANGGAL <?php echo "$datad[0] $namabulan $thn" ;?><br />
(Dalam Rupiah)</td>
     <td valign="bottom" align="right">
       <!--p><BUTTON type="button" onClick="print()"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Export ke File Excell</strong></BUTTON></p--></td>
	   <script language="javascript" type="text/javascript">
	   function print(){
	   var answer = confirm ("Apakah Ingin Mencetak Halaman ini?")
		if (answer)
		window.open("../report/neraca_xls.php?bulan="+document.getElementById('bulan').value+"&tahun="+document.getElementById('tahun').value,"","GET");
		}
	   </script>
  </tr>
  <tr headtable>
    <td colspan="2"><table width="980" cellspacing="0" cellpadding="0" class="bodyText12" border="1" style="border-collapse:collapse">
      <tr align="center" class="headtable">
        <td width="25" rowspan="2">No</td>
      <td width="54" rowspan="2">Nomor Akun</td>
      <td width="225" rowspan="2">Nama Akun</td>
      <td colspan="2" align="center">Neraca Saldo</td>
	  <td colspan="2" align="center">Penyesuaian</td>
      <td colspan="2" align="center">NS Setl Penyesuaian</td>
	  <td colspan="2" align="center">Lap. Operasional</td>
	  <td colspan="2" align="center">Neraca</td>
	  </tr>
      <tr align="center" class="headtable">
        <td width="65">Debet</td>
      <td width="65">Kredit</td>
	  <td width="65">Debet</td>
      <td width="64">Kredit</td>
	  <td width="64">Debet</td>
      <td width="65">Kredit</td>
	  <td width="65">Debet</td>
      <td width="65">Kredit</td>
	  <td width="65">Debet</td>
      <td width="65">Kredit</td>
    </tr>
      <?php 
	$sql="SELECT COUNT(op) FROM lap_neraca_saldo WHERE op=1";
	$sql=mysql_query($sql);
	$qop=mysql_fetch_array($sql);
	
  $sql=mysql_query("SELECT * FROM lap_neraca_saldo");
    $totdo=0;
	$totko=0;
	$i=0;
  $n=1;
  $tampilSubTotal='tidak';
  while($data=mysql_fetch_array($sql)){ 
    //==========Saldo Awal / Neraca Saldo
	  $kode=$data['kode_ma_sak'];
	  $d=0;
	  $k=0;
	  if ($kode!=''){
		  $skl=mysql_query("SELECT IFNULL(SUM(SALDO_AWAL),0) AS SALDO_AWAL FROM saldo s INNER JOIN ma_sak ms ON s.FK_MAID=ms.MA_ID 
							WHERE ms.MA_KODE LIKE '$kode%' and s.BULAN='$month' AND s.TAHUN='$year'");	
				$saldo_awal=mysql_fetch_array($skl);
	
		  if($data['d_k']=='D'){
			$d=$saldo_awal[0];
			if ($d<0){
				$k=-$d;
				$d=0;
			}
		  }else{
			$k=$saldo_awal[0];
			if ($k>0){
				$d=-$k;
				$k=0;
			}
		  }
	  }
	//========Penyesuain==========
	$pd=0;
	$pk=0;
	/*if ($kode!=''){
		$skl2="SELECT ma.MA_NAMA, SUM(j.DEBIT) AS debit, SUM(j.KREDIT) AS kredit
				 FROM jurnal j
				 INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID
				  WHERE ma.MA_kode LIKE '$kode%' AND MONTH(tgl)=$month AND YEAR(tgl)=$year";
				 //echo $skl2;
		$skl2=mysql_query($skl2);
		$penyesuain=mysql_fetch_array($skl2);
		$pd=0;
		$pk=0;
	}*/
	//========Perhitungan Setelah Penyesuaian
	$pspd=$d+$pd-$pk;
	$pspk=$k+$pd-$pk;
	//=====Oprasinal==========
	$do=0;
	$ko=0;
	$sts=0;
	
	if($data['op']==1){
		$do=$pspd;
		$ko=$pspk;
		$totdo=$totdo+$do;
		$totko=$totko+$ko;
	}
	
	/*if($data['op']==1){
		  if($data['d_k']=='D'){
			$do=$saldo_awal[0];
			$totdo=$totdo+$do;
		  }else{
			$ko=$saldo_awal[0];
			$totko=$totko+$ko;
		  }
		$i++;
	 $tampilSubTotal='ditampungdulu';
	}	
	else if($data['op']==0 && $tampilSubTotal=='ditampungdulu'){
		$tampilSubTotal='ya';
	} 
	
	if ($i==$qop[0]){
		$tampilSubTotal='ya';
	} */
	?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td  align="center"><? echo $n; ?></td>
      <td><?php echo $data['kode'];?></td>
      <td align="left"><?php echo $data['nama'];?></td>
	  
	  <td align="right"><?php echo number_format($d,0,",",".");?>  </td>
      <td align="right"><?php echo number_format($k,0,",",".");?></td>
	  <td  align="right"><?php echo number_format($pd,0,",",".");?></td>
      <td  align="right"><?php echo number_format($pk,0,",",".");?></td>
	  <td  align="right"><?php echo number_format($pspd,0,",",".");?></td>
      <td  align="right"><?php echo number_format($pspk,0,",",".");?></td>
	  <td  align="right"><?php echo number_format($do,0,",",".");?></td>
      <td  align="right"><?php echo number_format($ko,0,",",".");?></td>
	  <td align="right"><?php echo number_format($d,0,",",".");?>  </td>
      <td align="right"><?php echo number_format($k,0,",",".");?></td>
    </tr>
	  <?
	$totnd=$totnd+$d;
	$totnk=$totnk+$k;
	$totpd=$totpd+$pd;
	$totpk=$totpk+$pk;
	$totpspd=$totpspd+$pspd;
	$totpspk=$totpspk+$pspk;
	$totdo1=$totdo1+$do;
	$totko2=$totko2+$do;	
	$n++;
   } ?>
	  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
      <td colspan="9"  align="center">Subtotal Oprasional </td>
      <td  align="right"><?php echo number_format($totdo,0,",",".");?></td>
      <td  align="right"><?php echo number_format($totko,0,",",".");?></td>
	  <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
	  </tr>
      
     <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
      <td  align="center"><? $n++; echo $n; ?></td>
      <td>3199</td>
      <td align="left">Suplus / Defisit Periode Ini</td>	  
	  <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
	  <td  align="right">&nbsp;</td>
      <td  align="right">&nbsp;</td>
	  <td  align="right">&nbsp;</td>
      <td  align="right">&nbsp;</td>
	  <td  align="right"><?php $suplus=$totko-$totdo;
	  					echo number_format($suplus,0,",",".");?></td>
      <td  align="right">&nbsp;</td>
	  <td align="right">&nbsp;  </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td colspan="3"  align="center">Total</td>
        <td align="right"><?php echo number_format($totnd,0,",",".");?></td>
        <td align="right"><?php echo number_format($totnk,0,",","."); ?></td>
        <td  align="right"><?php echo number_format($totpd,0,",",".");?></td>
        <td  align="right"><?php echo number_format($totpk,0,",","."); ?></ td>
        <td  align="right"><?php echo number_format($totpspd,0,",","."); ?></td>
        <td  align="right"><?php echo number_format($totpspk,0,",",".");?></td>
        <td  align="right"><?php echo number_format($totdo1,0,",","."); ?></td>
        <td  align="right"><?php echo number_format($totko2,0,",","."); ?></td>
        <td align="right"><?php echo number_format($totnd,0,",",".");?></td>
        <td align="right"><?php echo number_format($totnk,0,",","."); ?></td>
  
    </table></td>
  </tr>
</table>

</body>
</html>

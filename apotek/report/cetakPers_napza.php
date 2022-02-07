<?
include("../sesi.php");
include("../koneksi/konek.php");
$tgl_de=$_REQUEST['tgl_de'];
$tgl_se=$_REQUEST['tgl_se'];
$unit_tujuan=$_REQUEST['unit_tujuan'];
$bln_se=$_REQUEST['bln_se'];
$thn_se=$_REQUEST['thn_se'];

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" href="../theme/print.css" type="text/css" />

<body onload="window.print();">
<table width="40%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="2" align="center" class="jdltable"><p>LAPORAN PENGGUNAAN SEDIAAN JADI NARKOTIKA<br/>INSTALASI FARMASI<br>
              UNIT : 
            <?
	  			$qry = "select UNIT_NAME from a_unit where UNIT_ID=$unit_tujuan";
				$exe = mysqli_query($konek,$qry);
				$show= mysqli_fetch_array($exe);
				//echo $qry;
				echo $show['UNIT_NAME'];
				if ($show['UNIT_NAME']=="") echo "ALL UNIT";
				
				$query = "SELECT * FROM a_unit WHERE unit_id = '$unit_tujuan'";
				$dUnit =mysqli_fetch_array(mysqli_query($konek,$query));
			?>
              </p></td>
        </tr>
        <tr style="display:none"> 
          <td colspan="2" align="center">( <?php echo $_GET['tgl_d'];?> s/d <?php echo $_GET['tgl_s'];?> 
            ) </td>
        </tr>
</table>
 <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
      	<tr>
         <td colspan="3" align="left" style="font-size:12px;">Nama Apotek</td>
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
         <td colspan="3" align="left" style="font-size:12px;">Alamat</td>
         <td colspan="6" align="left" style="font-size:12px;">: JL. Jenderal Sudirman, Kel.Kelapa Indah, Kec.Tangerang<br/>&nbsp;&nbsp;Kota Tangerang</td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="2" align="left" style="font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
         <td colspan="3" align="left" style="font-size:12px;">Telpon</td>
         <td colspan="6" align="left" style="font-size:12px;">: (021) 29720201-03</td>
         <td align="left">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td align="left" style="font-size:12px;">&nbsp;</td>
         <td colspan="2" align="left" style="font-size:12px;">&nbsp;</td>
        </tr>
      <tr>
         <td colspan="9" align="center" style="font-size:12px;">&nbsp;</td>
         <td colspan="5" align="center">&nbsp;</td>
      </tr>
        <!--<tr class="headtable"> 
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
          <td width="23" height="25" rowspan="3" class="tblheaderkiri">NO</td>
          <td width="153" rowspan="3" class="tblheader" id="OBAT_NAMA" onclick="ifPop.CallFr(this);">NAMA SEDIAAN </td>
          <td width="69" rowspan="3" align="center" class="tblheader" id="NAMA">SATUAN</td>
          <td width="69" rowspan="3" align="center" class="tblheader" id="NAMA">PERSEDIAAN AWAL BULAN</td>
          <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden">PEMASUKAN</td>
          <td width="30" rowspan="3" align="center" class="tblheader" id="NAMA">JUMLAH KESELURUHAN</td>
          <td colspan="3" align="center" class="tblheader" style="border-bottom:hidden">PENGELUARAN</td>
          <td width="69" rowspan="3" align="center" class="tblheader" id="NAMA">PERSEDIAAN AKHIR BULAN</td>
          <td width="60" rowspan="3" class="tblheader" id="HARGA_BELI_TOTAL">KET</td>
        </tr>
        <tr class="headtable">
          <td width="65" rowspan="2" align="center" class="tblheader" id="NAMA">TANGGAL</td>
          <td width="300" rowspan="2" align="center" class="tblheader" id="NAMA">DARI</td>
          <td width="56" rowspan="2" align="center" class="tblheader" id="NAMA">JUMLAH</td>
          <td colspan="2" align="center" class="tblheader" id="NAMA" style="border-bottom:hidden">UNTUK </td>
          <td width="81" rowspan="2" align="center" class="tblheader" id="NAMA">JUMLAH</td>
        </tr>
        <tr class="headtable">
          <td width="54" align="center" class="tblheader" id="NAMA">PEL RESEP</td>
          <td width="55" align="center" class="tblheader" id="NAMA">LAIN LAIN </td>
        </tr>
        <!--<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
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
-->		<tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'">
          <td class="tdisikiri" align="center" style="font-size:12px;">1</td>
          <td class="tdisi" align="center">2</td>
          <td class="tdisi" align="center">3</td>
          <td align="center" class="tdisi">4</td>
          <td align="center" class="tdisi">5</td>
          <td align="center" class="tdisi">6</td>
          <td align="center" class="tdisi">7</td>
          <td align="center" class="tdisi">8</td>
          <td align="center" class="tdisi">9</td>
          <td align="center" class="tdisi">10</td>
          <td align="center" class="tdisi">11</td>
          <td align="center" class="tdisi">12</td>
          <td class="tdisi" align="center">13</td>
        </tr>
        <?php 
		//echo $sql."<br>";
		$sql11="SELECT ao.OBAT_NAMA, ao.OBAT_SATUAN_KECIL, ak1.STOK_BEFOR, ak1.STOK_BEFOR as tes11, SUM(debet) AS debet, SUM(kredit) AS kredit,
(SELECT stok_after FROM a_kartustok WHERE obat_id = ak1.OBAT_ID AND unit_id = $unit_tujuan AND tgl_act BETWEEN '$tgl_de' AND '$tgl_se' ORDER BY id DESC LIMIT 1) AS tot_akhir,
(SELECT stok_befor FROM a_kartustok WHERE obat_id = ak1.OBAT_ID AND unit_id = 3 AND tgl_act BETWEEN '$tgl_de' AND '$tgl_se' ORDER BY id LIMIT 1) AS tot_awal,
GROUP_CONCAT(ak1.ID SEPARATOR ',') AS id_kartu
FROM a_kartustok ak1
INNER JOIN a_obat ao ON ak1.OBAT_ID = ao.OBAT_ID
 WHERE unit_id = $unit_tujuan AND tgl_act BETWEEN '$tgl_de' AND '$tgl_se'
 AND (ao.OBAT_GOLONGAN = 'M' OR ao.OBAT_GOLONGAN = 'N' OR ao.OBAT_GOLONGAN = 'Psi')
GROUP BY ao.OBAT_ID, ao.OBAT_SATUAN_KECIL";
		//echo $sql11."<br>";
		$rs11=mysqli_query($konek,$sql11);
	  $i=0;
	  //$rows12=mysqli_fetch_array($rs11);
	  //echo $rows12['tot_awal'];
	  
	  while ($rows1=mysqli_fetch_array($rs11)){
		  //echo $rows1['STOK_BEFOR'].">>".$rows1['tes11']."<br>";
	  	$i++;
	  $qKB="SELECT SUM(IF(tipetrans=8,kredit,0)) AS tot_resep, SUM(IF(tipetrans<>8,kredit,0)) AS tot_non_resep FROM a_kartustok 
WHERE id IN ($rows1[id_kartu]) AND kredit <> 0";
	  $exQkb=mysqli_query($konek,$qKB);
	  $dQkb=mysqli_fetch_array($exQkb);
	  $qDB="SELECT DATE_FORMAT(tgl_act,'%d-%m-%Y') AS tgl, IFNULL(au.UNIT_NAME,ket) AS ket2, t1.debet FROM (SELECT IF(tipetrans=7,'Return GD',ket) AS ket, IF(LEFT(ket,3)='IN ' AND tipetrans= 1,IF(RIGHT(SUBSTR(ket,4,3),1)='/',SUBSTR(ket,4,2),IF(SUBSTR(ket,4,3)='DPO','DPOK',SUBSTR(ket,4,3))),'OUT') AS coba, debet, tgl_act FROM a_kartustok WHERE id IN ($rows1[id_kartu]) AND debet <> 0) AS t1 LEFT JOIN a_unit au ON t1.coba = au.UNIT_KODE";
	  
	  //echo $qDB."<br>";
	  $exQdb=mysqli_query($konek,$qDB);
	  ?>
        <tr class="itemtable" onmouseover="this.className='itemtableMOver'" onmouseout="this.className='itemtable'"> 
          <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?>&nbsp;</td>
          <td class="tdisi" align="left"><?php echo $rows1['OBAT_NAMA']; ?>&nbsp;</td>
          <td class="tdisi" align="center"><?php echo $rows1['OBAT_SATUAN_KECIL']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows1['tot_awal']; ?>&nbsp;</td>
          <td align="center" class="tdisi">
          	<table align="center" cellpadding="1" cellspacing="0" border="0">
            <?
				//$ket[]="";
				//$debt[]="";
				$id1 = 0;
				while($dQdb=mysqli_fetch_array($exQdb))
				{
					$ket[$id1] = $dQdb['ket2'];
					$deb[$id1] = $dQdb['debet'];
					$id1++;
			?>
              <tr class="itemtable">
              	<td><? echo $dQdb['tgl'];?>&nbsp;</td>                
              </tr>
            <?
				}
			?>
             </table>
          </td>
          <td align="center" class="tdisi">
          <table align="center" cellpadding="1" cellspacing="0" border="0">
          		<?
				//echo count($ket);
				for($xx=0;$xx<=$id1-1;$xx++)
				{
				?>
				  <tr class="itemtable">
					<td><? echo $ket[$xx];?>&nbsp;</td>                
				  </tr>
				<?
				}
				?>
             </table>
          </td>
          <td align="center" class="tdisi">
          <table align="center" cellpadding="1" cellspacing="0" border="0">
          	<?
				for($xx=0;$xx<=$id1-1;$xx++)
				{
				?>
				  <tr class="itemtable">
					<td><? echo $deb[$xx];?>&nbsp;</td>                
				  </tr>
				<?
					//unset($ket);
					//unset($debt);
				}
				?>
           </table>
          </td>
          <td align="center" class="tdisi"><?php echo $rows1['debet']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $dQkb['tot_resep']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $dQkb['tot_non_resep']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows1['kredit']; ?>&nbsp;</td>
          <td align="center" class="tdisi"><?php echo $rows1['tot_akhir']; ?>&nbsp;</td>
          <td align="center" class="tdisi">&nbsp;</td>
          <!--<td class="tdisi" align="center"><?php echo $rows['ket']; ?>&nbsp;</td>-->
        </tr>
		
        <?php 
	  }
	  mysqli_free_result($rs11);
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
</body>
</html>
<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");

$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " WHERE TGL = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " where month(TGL) = '$bln' and year(TGL) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " where TGL between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<center>
<table width="1098" style="border-collapse:collapse;border:1px solid #000">
  <tr>
    <th width="27" scope="col">&nbsp;</th>
    <th width="43" scope="col">&nbsp;</th>
    <th width="154" scope="col">&nbsp;</th>
    <th width="30" scope="col">&nbsp;</th>
    <th width="150" scope="col">&nbsp;</th>
    <th width="135" scope="col">&nbsp;</th>
    <th width="177" scope="col">&nbsp;</th>
    <th width="97" scope="col">&nbsp;</th>
    <th width="183" scope="col">&nbsp;</th>
    <th width="58" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" rowspan="2"><div align="center"><strong>PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP</strong></div></td>
    <td colspan="3" rowspan="2" style="border:#000 1px solid;border-collapse:collapse;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" style="border-top:1px solid #000">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Kode RS</strong></td>
    <td><strong>:</strong></td>
    <td colspan="3">&nbsp;<?php echo $kodeRS; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Nama RS</strong></td>
    <td><strong>:</strong></td>
    <td colspan="3">&nbsp;<?php echo $namaRS; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Periode</strong></td>
    <td><strong>:</strong></td>
    <td colspan="3">&nbsp;<?php echo $Periode; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>3.13</strong></td>
    <td colspan="4"><strong>Pengadaan Obat, Penulisan dan Pelayanan Resep</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>A.</strong></td>
    <td colspan="3"><strong>Pengadaan Obat</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  $sql = "select";
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8" rowspan="10"><table width="949" border="1" style="border-collapse:collapse;">
      <tr>
        <th width="65" scope="col">NO</th>
        <th width="314" scope="col">GOLONGAN OBAT</th>
        <th width="116" scope="col">JUMLAH ITEM OBAT</th>
        <th width="188" scope="col">JUMLAH OBAT YANG TERSEDIA DI RUMAH SAKIT</th>
        <th width="232" scope="col">JUMLAH ITEM OBAT FORMULATORIUM TERSEDIA DI RUMAH SAKIT</th>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">1</div></td>
        <td bgcolor="#CCCCCC"><div align="center">2</div></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <?php
	   $sql="SELECT 
aok.id,
aok.kategori,
COUNT(DISTINCT ao.OBAT_ID) AS jml,
SUM(ast.qty_stok) AS stok
FROM $dbapotek.a_obat ao
INNER JOIN $dbapotek.a_obat_kategori aok ON aok.id=ao.OBAT_KATEGORI
INNER JOIN $dbapotek.a_stok ast ON ast.obat_id=ao.OBAT_ID
GROUP BY aok.id";
	   $queri=mysql_query($sql);
	   $nmr=0;
	   while($rw=mysql_fetch_array($queri)){
	   $nmr++;
	   ?> 
      <tr>
        <td><div align="center"><?php echo $nmr; ?></div></td>
        <td align="left">&nbsp;<?php echo $rw['kategori']; ?></td>
        <td align="center"><?php echo $rw['jml']; ?></td>
        <td align="center"><?php echo $rw['stok']; ?></td>
        <td align="center">&nbsp;</td>
        </tr>
        <?php
	   }
		?>
      <tr>
        <td><div align="center">&nbsp;</div></td>
        <td>TOTAL</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>A.</strong></td>
    <td colspan="3"><strong>Penulisan dan Pelayanan Resep</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8" rowspan="8"><table width="949" border="1" style="border-collapse:collapse;">
      <tr>
        <th width="65" scope="col">NO</th>
        <th width="314" scope="col">GOLONGAN OBAT</th>
        <th width="116" scope="col">RAWAT JALAN</th>
        <th width="188" scope="col">IGD</th>
        <th width="232" scope="col">RAWAT INAP</th>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">1</div></td>
        <td bgcolor="#CCCCCC"><div align="center">2</div></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <?php
	  $sql="SELECT
			aok.id,
			aok.kategori,
			SUM(IF(au.status_inap=1,ap.QTY,0)) AS inap,
			SUM(IF(au.status_inap=2,ap.QTY,0)) AS jalan,
			SUM(IF(au.status_inap=3,ap.QTY,0)) AS darurat
			FROM (SELECT * FROM $dbapotek.a_penjualan $waktu) ap
			INNER JOIN $dbapotek.a_penerimaan pn ON pn.ID=ap.PENERIMAAN_ID
			INNER JOIN $dbapotek.a_obat ao ON ao.OBAT_ID=pn.OBAT_ID
			INNER JOIN $dbapotek.a_obat_kategori aok ON aok.id=ao.OBAT_KATEGORI
			INNER JOIN $dbapotek.a_unit au ON au.UNIT_ID=ap.RUANGAN
			GROUP BY aok.id";
	  $kueri=mysql_query($sql);
	  $no=0;
	  while($rows=mysql_fetch_array($kueri)){
	  $no++;
	  ?>
      <tr>
        <td><div align="center"><?php echo $no; ?></div></td>
        <td align="left">&nbsp;<?php echo $rows['kategori']; ?></td>
        <td align="center"><?php echo $rows['jalan']; ?></td>
        <td align="center"><?php echo $rows['darurat']; ?></td>
        <td align="center"><?php echo $rows['inap']; ?></td>
      </tr>
      <?php
	  }
	  ?>
      <tr>
        <td><div align="center">&nbsp;</div></td>
        <td>TOTAL</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</center>
</body>
</html>
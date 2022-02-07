<!--b_ms_keluarga_berencana-->
<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$sql = "SELECT * FROM b_profil";
$profil = mysql_fetch_array(mysql_query($sql));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<center>
<table width="943" style="border-collapse:collapse;border:1px solid #000">
  <tr>
    <th width="1" scope="col">&nbsp;</th>
    <th width="35" scope="col">&nbsp;</th>
    <th width="135" scope="col">&nbsp;</th>
    <th width="24" scope="col">&nbsp;</th>
    <th width="135" scope="col">&nbsp;</th>
    <th width="15" scope="col">&nbsp;</th>
    <th width="75" scope="col">&nbsp;</th>
    <th width="159" scope="col">&nbsp;</th>
    <th width="135" scope="col">&nbsp;</th>
    <th width="74" scope="col">&nbsp;</th>
    <th width="74" scope="col">&nbsp;</th>
    <th width="74" scope="col">&nbsp;</th>
    <th width="74" scope="col">&nbsp;</th>
    <th width="74" scope="col">&nbsp;</th>
    <th width="80" scope="col">&nbsp;</th>
    <th width="1" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7" rowspan="2"><div align="center"><strong>KEGIATAN KELUARGA BERENCANA</strong></div></td>
    <td colspan="7" rowspan="2" style="border:#000 1px solid;border-collapse:collapse;">&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="16" style="border-top:1px solid #000">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Kode RS</strong></td>
    <td><strong>:</strong></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Nama RS</strong></td>
    <td><strong>:</strong></td>
    <td><?=$profil['nama'];?></td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Tahun</strong></td>
    <td><strong>:</strong></td>
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
    <td colspan="5">&nbsp;</td>
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
    <td colspan="14" rowspan="12"><table width="1215" border="1" style="border-collapse:collapse;">
      <tr>
        <th width="30" rowspan="2" scope="col">NO</th>
        <th width="120" rowspan="2" scope="col">JENIS KEGIATAN</th>
        <th colspan="2" scope="col">KONSELING</th>
        <th colspan="4" scope="col">KB BARU DENGAN CARA MASUK</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th width="107" rowspan="2" scope="col">KUNJUNGAN<br />
          ULANG</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
      </tr>
      <tr>
        <th width="43" scope="col">ANC</th>
        <th width="102" scope="col">PASCA<br />
          PERSALINAN</th>
        <th width="77" scope="col">BUKAN<br />
          RUJUKAN</th>
        <th width="77" scope="col">RUJUKAN<br />
          R. INAP</th>
        <th width="80" scope="col">RUJUKAN<br />
          R. JALAN</th>
        <th width="58" scope="col">TOTAL</th>
        <th width="107" scope="col">PASCA PERSALINAN<br />
          NIFAS</th>
        <th width="77" scope="col">ABORTUS</th>
        <th width="78" scope="col">LAINYA</th>
        <th width="77" scope="col">JUMLAH</th>
        <th width="94" scope="col">DIRUJUK</th>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center">1</div></td>
        <td bgcolor="#CCCCCC"><div align="center">2</div></td>
        <td bgcolor="#CCCCCC"><div align="center">3</div></td>
        <td bgcolor="#CCCCCC"><div align="center">4</div></td>
        <td bgcolor="#CCCCCC"><div align="center">5</div></td>
        <td bgcolor="#CCCCCC"><div align="center">6</div></td>
        <td bgcolor="#CCCCCC"><div align="center">7</div></td>
        <td bgcolor="#CCCCCC"><div align="center">8</div></td>
        <td bgcolor="#CCCCCC"><div align="center">9</div></td>
        <td bgcolor="#CCCCCC"><div align="center">10</div></td>
        <td bgcolor="#CCCCCC"><div align="center">11</div></td>
        <td bgcolor="#CCCCCC"><div align="center">12</div></td>
        <td bgcolor="#CCCCCC"><div align="center">13</div></td>
        <td bgcolor="#CCCCCC"><div align="center">14</div></td>
      </tr>
      <?
	  $sql="select * from b_ms_keluarga_berencana";
	  $query=mysql_query($sql);
	  while($row=mysql_fetch_object($query)){
		$no=$no+1; ?>
          <tr>
            <td><div align="center"><?=$no;?></div></td>
            <td><?=$row->jenis_kegiatan;?></td>
            <td><?=$row->anc;?></td>
            <td><?=$row->pasca_persalinan;?></td>
            <td><?=$row->bukan_rujukan;?></td>
            <td><?=$row->rujukan_rawat_inap;?></td>
            <td><?=$row->rujukan_rawat_jalan;?></td>
            <td bgcolor="#999999">&nbsp;</td>
            <td><?=$row->nifas;?></td>
            <td><?=$row->abortus;?></td>
            <td><?=$row->lainya;?></td>
            <td><?=$row->kunjungan_ulang;?></td>
            <td><?=$row->jumlah;?></td>
            <td><?=$row->dirujuk;?></td>
          </tr>
      <? 
	  }
	  ?>
  
      <tr>
        <td><div align="center"></div></td>
        <td>TOTAL</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
        <td bgcolor="#999999">&nbsp;</td>
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
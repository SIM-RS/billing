<!--b_ms_keluarga_berencana-->
<?php
//session_start();
//include("../../sesi.php");
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
    <td colspan="6"><?=$profil['nama'];?></td>
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
    <td><?=date('Y')?></td>
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
        <th colspan="3" scope="col">KB BARU DENGAN KONSIDI</th>
        <th width="107" rowspan="2" scope="col">KUNJUNGAN<br />
          ULANG</th>
        <th colspan="2" scope="col">KELUHAN EFEK SAMPING</th>
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
          <tr>
            <td align="center">1</td>
            <td align="left">I U D</td>
            <td align="center"><input type="text" name="isi_txt[0]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[1]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[2]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[3]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[4]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[5]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[6]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[7]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[8]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[9]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[10]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[11]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td align="left">P i l</td>
            <td align="center"><input type="text" name="isi_txt[12]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[13]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[14]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[15]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[16]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[17]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[18]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[19]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[20]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[21]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[22]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[23]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">3</td>
            <td align="left">Kondom</td>
            <td align="center"><input type="text" name="isi_txt[24]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[25]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[26]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[27]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[28]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[29]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[30]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[31]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[32]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[33]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[34]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[35]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">4</td>
            <td align="left">Obat Vaginal</td>
            <td align="center"><input type="text" name="isi_txt[36]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[37]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[38]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[39]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[40]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[41]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[42]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[43]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[44]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[45]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[46]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[47]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td align="left">MO Pria</td>
            <td align="center"><input type="text" name="isi_txt[48]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[49]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[50]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[51]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[52]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[53]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[54]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[55]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[56]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[57]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[58]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[59]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">6</td>
            <td align="left">MO Wanita</td>
            <td align="center"><input type="text" name="isi_txt[60]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[61]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[62]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[63]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[64]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[65]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[66]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[67]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[68]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[69]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[70]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[71]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">7</td>
            <td align="left">Suntikan</td>
            <td align="center"><input type="text" name="isi_txt[72]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[73]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[74]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[75]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[76]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[77]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[78]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[79]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[80]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[81]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[82]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[83]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <tr>
            <td align="center">8</td>
            <td align="left">Implant</td>
            <td align="center"><input type="text" name="isi_txt[84]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[85]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[86]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[87]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[88]" id="isi_txt[]" value="" size="5px"/></td>
            <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[89]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[90]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[91]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[92]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[93]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[94]" id="isi_txt[]" value="" size="5px"/></td>
            <td align="center"><input type="text" name="isi_txt[95]" id="isi_txt[]" value="" size="5px"/></td>
          </tr>
          <?
	  /*$sql="select * from b_ms_keluarga_berencana";
	  $query=mysql_query($sql);
	  while($row=mysql_fetch_object($query)){
		$no=$no+1;*/ ?>
          <tr style="display:none">
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
	  //}
	  ?>
  
      <tr>
        <td><div align="center"></div></td>
        <td>TOTAL</td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[96]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[97]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[98]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[99]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[100]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[101]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[102]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[103]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[104]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[105]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[106]" id="isi_txt[]" value="" size="5px"/></td>
        <td bgcolor="#999999" align="center"><input type="text" name="isi_txt[107]" id="isi_txt[]" value="" size="5px"/></td>
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
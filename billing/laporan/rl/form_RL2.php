<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RL 2</title>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.style4 {color: #FFFFFF}
-->
</style>
</head>

<body>
<?php
include ("../../koneksi/konek.php");
//====================================


	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

?>
<table width="900" border="0" style="border-collapse:collapse; font:12px arial; border:1px solid #000000">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000;"><center><img src="logo-bakti-husada.jpg" width="55" height="60" /></center></td>
        <td width="50%" height="31"><span class="style1">Formulir RL 2 </span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><center><img src="pojok.png" /></center></td>
      </tr>
      <tr>
        <td height="50%" style="border-bottom:2px solid #000000"><strong>KETENAGAAN</strong></td>
        </tr>
		<?php 
		$sql="select * from b_form_rl2"; //echo $sql;
		$hasil = mysql_query($sql);
		$data = mysql_fetch_array($hasil);
		
		$isi = explode(",",$data['isi']);
		$jumData = count($isi); 
		?>            
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><strong>Kode RS </strong></td>
        <td width="2%"><strong>:</strong></td>
        <td width="87%"><strong><?=$kodeRS?></strong></td>
      </tr>
      <tr>
        <td><strong>Nama RS </strong></td>
        <td><strong>:</strong></td>
        <td><strong><?=$namaRS?></strong></td>
      </tr>
      
      <tr>
        <td><strong>Tahun</strong></td>
        <td><strong>:</strong></td>
        <td><strong><?=$data['tahun'];?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td rowspan="2" width="10%"><div align="center"><strong>NO</strong></div></td>
        <td rowspan="2" width="30%"><div align="center"><strong>JENIS PELAYANAN </strong></div></td>
        <td colspan="2" width="20%"><strong><center>KEADAAN</center></strong></td>
        <td colspan="2" width="20%"><strong><center>KEBUTUHAN</center></strong></td>
        <td colspan="2" width="20%"><strong><center>KEKURANGAN</center></strong></td>
        </tr>
      <tr>
        <td width="10%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
        <td width="10%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
        <td width="10%"><center><strong>LAKI - LAKI</strong></center></td>
        <td width="10%"><center><strong>PEREMPUAN</strong></center></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1</strong></div></td>
        <td colspan="7" ><strong>TENAGA MEDIS </strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1 1</strong></div></td>
        <td><strong>Dokter Umum</strong></td>
        <td><?=$isi[0];?></td>
        <td><?=$isi[1];?></td>
        <td><?=$isi[2];?></td>
        <td><?=$isi[3];?></td>
        <td><?=$isi[4];?></td>
        <td><?=$isi[5];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 2</strong></div></td>
        <td><strong>Dokter PPDS *)</strong></td>
        <td><?=$isi[6];?></td>
        <td><?=$isi[7];?></td>
        <td><?=$isi[8];?></td>
        <td><?=$isi[9];?></td>
        <td><?=$isi[10];?></td>
        <td><?=$isi[11];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 3</strong></div></td>
        <td><strong>Dokter Spes Bedah</strong></td>
        <td><?=$isi[12];?></td>
        <td><?=$isi[13];?></td>
        <td><?=$isi[14];?></td>
        <td><?=$isi[15];?></td>
        <td><?=$isi[16];?></td>
        <td><?=$isi[17];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 4</strong></div></td>
        <td><strong>Dokter Spes Penyakit Dalam</strong></td>
        <td><?=$isi[18];?></td>
        <td><?=$isi[19];?></td>
        <td><?=$isi[20];?></td>
        <td><?=$isi[21];?></td>
        <td><?=$isi[22];?></td>
        <td><?=$isi[23];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 5</strong></div></td>
        <td><strong>Dokter Spes Kes. Anak</strong></td>
        <td><?=$isi[24];?></td>
        <td><?=$isi[25];?></td>
        <td><?=$isi[26];?></td>
        <td><?=$isi[27];?></td>
        <td><?=$isi[28];?></td>
        <td><?=$isi[29];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 6</strong></div></td>
        <td><strong>Dokter Spes Obgin</strong></td>
        <td><?=$isi[30];?></td>
        <td><?=$isi[31];?></td>
        <td><?=$isi[32];?></td>
        <td><?=$isi[33];?></td>
        <td><?=$isi[34];?></td>
        <td><?=$isi[35];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 7</strong></div></td>
        <td><strong>Dokter Spes Radiologi</strong></td>
        <td><?=$isi[36];?></td>
        <td><?=$isi[37];?></td>
        <td><?=$isi[38];?></td>
        <td><?=$isi[39];?></td>
        <td><?=$isi[40];?></td>
        <td><?=$isi[41];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 8</strong></div></td>
        <td><strong>Dokter Spes Onkologi Radiasi</strong></td>
        <td><?=$isi[42];?></td>
        <td><?=$isi[43];?></td>
        <td><?=$isi[44];?></td>
        <td><?=$isi[45];?></td>
        <td><?=$isi[46];?></td>
        <td><?=$isi[47];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 9</strong></div></td>
        <td><strong>Dokter Spes Kedokteran Nuklir</strong></td>
        <td><?=$isi[48];?></td>
        <td><?=$isi[49];?></td>
        <td><?=$isi[50];?></td>
        <td><?=$isi[51];?></td>
        <td><?=$isi[52];?></td>
        <td><?=$isi[53];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 10</strong></div></td>
        <td><strong>Dokter Spes Anesthesi</strong></td>
        <td><?=$isi[54];?></td>
        <td><?=$isi[55];?></td>
        <td><?=$isi[56];?></td>
        <td><?=$isi[57];?></td>
        <td><?=$isi[58];?></td>
        <td><?=$isi[59];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 11</strong></div></td>
        <td><strong>Dokter Spes Patologi Klinik</strong></td>
        <td><?=$isi[60];?></td>
        <td><?=$isi[61];?></td>
        <td><?=$isi[62];?></td>
        <td><?=$isi[63];?></td>
        <td><?=$isi[64];?></td>
        <td><?=$isi[65];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 12</strong></div></td>
        <td><strong>Dokter Spes Jiwa</strong></td>
        <td><?=$isi[66];?></td>
        <td><?=$isi[67];?></td>
        <td><?=$isi[68];?></td>
        <td><?=$isi[69];?></td>
        <td><?=$isi[70];?></td>
        <td><?=$isi[71];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 13</strong></div></td>
        <td><strong>Dokter Spes Mata</strong></td>
        <td><?=$isi[72];?></td>
        <td><?=$isi[73];?></td>
        <td><?=$isi[74];?></td>
        <td><?=$isi[75];?></td>
        <td><?=$isi[76];?></td>
        <td><?=$isi[77];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 14</strong></div></td>
        <td><strong>Dokter Spes THT</strong></td>
        <td><?=$isi[78];?></td>
        <td><?=$isi[79];?></td>
        <td><?=$isi[80];?></td>
        <td><?=$isi[81];?></td>
        <td><?=$isi[82];?></td>
        <td><?=$isi[83];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 15</strong></div></td>
        <td><strong>Dokter Spes Kulit &amp; Kelamin</strong></td>
        <td><?=$isi[84];?></td>
        <td><?=$isi[85];?></td>
        <td><?=$isi[86];?></td>
        <td><?=$isi[87];?></td>
        <td><?=$isi[88];?></td>
        <td><?=$isi[89];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 16</strong></div></td>
        <td><strong>Dokter Spes Kardiologi</strong></td>
        <td><?=$isi[90];?></td>
        <td><?=$isi[91];?></td>
        <td><?=$isi[92];?></td>
        <td><?=$isi[93];?></td>
        <td><?=$isi[94];?></td>
        <td><?=$isi[95];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 17</strong></div></td>
        <td><strong>Dokter Spes Paru</strong></td>
        <td><?=$isi[96];?></td>
        <td><?=$isi[97];?></td>
        <td><?=$isi[98];?></td>
        <td><?=$isi[99];?></td>
        <td><?=$isi[100];?></td>
        <td><?=$isi[101];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 18</strong></div></td>
        <td><strong>Dokter Spes Saraf</strong></td>
        <td><?=$isi[102];?></td>
        <td><?=$isi[103];?></td>
        <td><?=$isi[104];?></td>
        <td><?=$isi[105];?></td>
        <td><?=$isi[106];?></td>
        <td><?=$isi[107];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 19</strong></div></td>
        <td><strong>Dokter Spes Bedah Saraf</strong></td>
        <td><?=$isi[108];?></td>
        <td><?=$isi[109];?></td>
        <td><?=$isi[110];?></td>
        <td><?=$isi[111];?></td>
        <td><?=$isi[112];?></td>
        <td><?=$isi[113];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 20</strong></div></td>
        <td><strong>Dokter Spes Bedah Orthopedi</strong></td>
        <td><?=$isi[114];?></td>
        <td><?=$isi[115];?></td>
        <td><?=$isi[116];?></td>
        <td><?=$isi[117];?></td>
        <td><?=$isi[118];?></td>
        <td><?=$isi[119];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 21</strong></div></td>
        <td><strong>Dokter Spes Urologi</strong></td>
        <td><?=$isi[120];?></td>
        <td><?=$isi[121];?></td>
        <td><?=$isi[122];?></td>
        <td><?=$isi[123];?></td>
        <td><?=$isi[124];?></td>
        <td><?=$isi[125];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 22</strong></div></td>
        <td><strong>Dokter Spes Patologi Anatomi</strong></td>
        <td><?=$isi[126];?></td>
        <td><?=$isi[127];?></td>
        <td><?=$isi[128];?></td>
        <td><?=$isi[129];?></td>
        <td><?=$isi[130];?></td>
        <td><?=$isi[131];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 23</strong></div></td>
        <td><strong>Dokter Spes Patologi Forensik</strong></td>
        <td><?=$isi[132];?></td>
        <td><?=$isi[133];?></td>
        <td><?=$isi[134];?></td>
        <td><?=$isi[135];?></td>
        <td><?=$isi[136];?></td>
        <td><?=$isi[137];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 24</strong></div></td>
        <td><strong>Dokter Spes Rehabilitasi Medik</strong></td>
        <td><?=$isi[138];?></td>
        <td><?=$isi[139];?></td>
        <td><?=$isi[140];?></td>
        <td><?=$isi[141];?></td>
        <td><?=$isi[142];?></td>
        <td><?=$isi[143];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 25</strong></div></td>
        <td><strong>Dokter Spes Bedah Plastik</strong></td>
        <td><?=$isi[144];?></td>
        <td><?=$isi[145];?></td>
        <td><?=$isi[146];?></td>
        <td><?=$isi[147];?></td>
        <td><?=$isi[148];?></td>
        <td><?=$isi[149];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 26</strong></div></td>
        <td><strong>Dokter Spes Ked. Olah Raga</strong></td>
        <td><?=$isi[150];?></td>
        <td><?=$isi[151];?></td>
        <td><?=$isi[152];?></td>
        <td><?=$isi[153];?></td>
        <td><?=$isi[154];?></td>
        <td><?=$isi[155];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 27</strong></div></td>
        <td><strong>Dokter Spes Mikrobiologi Klinik</strong></td>
        <td><?=$isi[156];?></td>
        <td><?=$isi[157];?></td>
        <td><?=$isi[158];?></td>
        <td><?=$isi[159];?></td>
        <td><?=$isi[160];?></td>
        <td><?=$isi[161];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 28</strong></div></td>
        <td><strong>Dokter Spes Parasitologi Klinik</strong></td>
        <td><?=$isi[162];?></td>
        <td><?=$isi[163];?></td>
        <td><?=$isi[164];?></td>
        <td><?=$isi[165];?></td>
        <td><?=$isi[166];?></td>
        <td><?=$isi[167];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 29</strong></div></td>
        <td><strong>Dokter Spes Gizi Medik</strong></td>
        <td><?=$isi[168];?></td>
        <td><?=$isi[169];?></td>
        <td><?=$isi[170];?></td>
        <td><?=$isi[171];?></td>
        <td><?=$isi[172];?></td>
        <td><?=$isi[173];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 30</strong></div></td>
        <td><strong>Dokter Spes Farma Klinik</strong></td>
        <td><?=$isi[174];?></td>
        <td><?=$isi[175];?></td>
        <td><?=$isi[176];?></td>
        <td><?=$isi[177];?></td>
        <td><?=$isi[178];?></td>
        <td><?=$isi[179];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 31</strong></div></td>
        <td><strong>Dokter Spes Lainnya</strong></td>
        <td><?=$isi[180];?></td>
        <td><?=$isi[181];?></td>
        <td><?=$isi[182];?></td>
        <td><?=$isi[183];?></td>
        <td><?=$isi[184];?></td>
        <td><?=$isi[185];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 32</strong></div></td>
        <td><strong>Dokter Sub Spesialis Lainnya</strong></td>
        <td><?=$isi[186];?></td>
        <td><?=$isi[187];?></td>
        <td><?=$isi[188];?></td>
        <td><?=$isi[189];?></td>
        <td><?=$isi[190];?></td>
        <td><?=$isi[191];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 33</strong></div></td>
        <td><strong>Dokter Gigi</strong></td>
        <td><?=$isi[192];?></td>
        <td><?=$isi[193];?></td>
        <td><?=$isi[194];?></td>
        <td><?=$isi[195];?></td>
        <td><?=$isi[196];?></td>
        <td><?=$isi[197];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 34</strong></div></td>
        <td><strong>Dokter Gigi Spesialis</strong></td>
        <td><?=$isi[198];?></td>
        <td><?=$isi[199];?></td>
        <td><?=$isi[200];?></td>
        <td><?=$isi[201];?></td>
        <td><?=$isi[202];?></td>
        <td><?=$isi[203];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 99</strong></div></td>
        <td ><strong>Total (1.00-1.34)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 66</strong></div></td>
        <td><strong>Dokter/Dokter Gigi MHA/MARS **)</strong></td>
        <td><?=$isi[204];?></td>
        <td><?=$isi[205];?></td>
        <td><?=$isi[206];?></td>
        <td><?=$isi[207];?></td>
        <td><?=$isi[208];?></td>
        <td><?=$isi[209];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 77</strong></div></td>
        <td><strong>Dokter Gigi S2/S3 Kes Masy **)</strong></td>
        <td><?=$isi[210];?></td>
        <td><?=$isi[211];?></td>
        <td><?=$isi[212];?></td>
        <td><?=$isi[213];?></td>
        <td><?=$isi[214];?></td>
        <td><?=$isi[215];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>1 88</strong></div></td>
        <td><strong>S3 (Dokter Konsultan) ***)</strong></td>
        <td><?=$isi[216];?></td>
        <td><?=$isi[217];?></td>
        <td><?=$isi[218];?></td>
        <td><?=$isi[219];?></td>
        <td><?=$isi[220];?></td>
        <td><?=$isi[221];?></td>
      </tr>
      <tr>
        <td ><div align="center"><strong>2</strong></div></td>
        <td colspan="7"><strong>TENAGA KEPERAWATAN</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>2 1</strong></div></td>
        <td><strong>S3 Keperawatan</strong></td>
        <td><?=$isi[222];?></td>
        <td><?=$isi[223];?></td>
        <td><?=$isi[224];?></td>
        <td><?=$isi[225];?></td>
        <td><?=$isi[226];?></td>
        <td><?=$isi[227];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 2</strong></div></td>
        <td><strong>S2 Keperawatan</strong></td>
        <td><?=$isi[228];?></td>
        <td><?=$isi[229];?></td>
        <td><?=$isi[230];?></td>
        <td><?=$isi[231];?></td>
        <td><?=$isi[232];?></td>
        <td><?=$isi[233];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 3</strong></div></td>
        <td><strong>S1 Keperawatan</strong></td>
        <td><?=$isi[234];?></td>
        <td><?=$isi[235];?></td>
        <td><?=$isi[236];?></td>
        <td><?=$isi[237];?></td>
        <td><?=$isi[238];?></td>
        <td><?=$isi[239];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 4</strong></div></td>
        <td><strong>D4 Keperawatan</strong></td>
        <td><?=$isi[240];?></td>
        <td><?=$isi[241];?></td>
        <td><?=$isi[242];?></td>
        <td><?=$isi[243];?></td>
        <td><?=$isi[244];?></td>
        <td><?=$isi[245];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 5</strong></div></td>
        <td><strong>Perawat Vokasional</strong></td>
        <td><?=$isi[246];?></td>
        <td><?=$isi[247];?></td>
        <td><?=$isi[248];?></td>
        <td><?=$isi[249];?></td>
        <td><?=$isi[250];?></td>
        <td><?=$isi[251];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 6</strong></div></td>
        <td><strong>Perawat Spesialis</strong></td>
        <td><?=$isi[252];?></td>
        <td><?=$isi[253];?></td>
        <td><?=$isi[254];?></td>
        <td><?=$isi[255];?></td>
        <td><?=$isi[256];?></td>
        <td><?=$isi[257];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 7</strong></div></td>
        <td><strong>Pembantu Keperawatan</strong></td>
        <td><?=$isi[258];?></td>
        <td><?=$isi[259];?></td>
        <td><?=$isi[260];?></td>
        <td><?=$isi[261];?></td>
        <td><?=$isi[262];?></td>
        <td><?=$isi[263];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 8</strong></div></td>
        <td><strong>S3 Kebidanan</strong></td>
        <td><?=$isi[264];?></td>
        <td><?=$isi[265];?></td>
        <td><?=$isi[266];?></td>
        <td><?=$isi[267];?></td>
        <td><?=$isi[268];?></td>
        <td><?=$isi[269];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 9</strong></div></td>
        <td><strong>S2 Kebidanan</strong></td>
        <td><?=$isi[270];?></td>
        <td><?=$isi[271];?></td>
        <td><?=$isi[272];?></td>
        <td><?=$isi[273];?></td>
        <td><?=$isi[274];?></td>
        <td><?=$isi[275];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 10</strong></div></td>
        <td><strong>S1 Kebidanan</strong></td>
        <td><?=$isi[276];?></td>
        <td><?=$isi[277];?></td>
        <td><?=$isi[278];?></td>
        <td><?=$isi[279];?></td>
        <td><?=$isi[280];?></td>
        <td><?=$isi[281];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 11</strong></div></td>
        <td><strong>D3 Kebidanan</strong></td>
        <td><?=$isi[282];?></td>
        <td><?=$isi[283];?></td>
        <td><?=$isi[284];?></td>
        <td><?=$isi[285];?></td>
        <td><?=$isi[285];?></td>
        <td><?=$isi[286];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 88</strong></div></td>
        <td><strong>Tenaga Keperawatan Lainnya</strong></td>
        <td><?=$isi[287];?></td>
        <td><?=$isi[288];?></td>
        <td><?=$isi[289];?></td>
        <td><?=$isi[290];?></td>
        <td><?=$isi[291];?></td>
        <td><?=$isi[292];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>2 99</strong></div></td>
        <td ><strong>Total (2.00-2.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td ><div align="center"><strong>3</strong></div></td>
        <td colspan="7"><strong>KEFARMASIAN</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>3 1</strong></div></td>
        <td><strong>S3 Farmasi / Apoteker</strong></td>
        <td><?=$isi[293];?></td>
        <td><?=$isi[294];?></td>
        <td><?=$isi[295];?></td>
        <td><?=$isi[296];?></td>
        <td><?=$isi[297];?></td>
        <td><?=$isi[298];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 2</strong></div></td>
        <td><strong>S2 Farmasi / Apoteker</strong></td>
        <td><?=$isi[299];?></td>
        <td><?=$isi[300];?></td>
        <td><?=$isi[301];?></td>
        <td><?=$isi[302];?></td>
        <td><?=$isi[303];?></td>
        <td><?=$isi[304];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 3</strong></div></td>
        <td><strong>Apoteker</strong></td>
        <td><?=$isi[305];?></td>
        <td><?=$isi[306];?></td>
        <td><?=$isi[307];?></td>
        <td><?=$isi[308];?></td>
        <td><?=$isi[309];?></td>
        <td><?=$isi[310];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 4</strong></div></td>
        <td><strong>S1 Farmasi / Farmakologi Kimia</strong></td>
        <td><?=$isi[311];?></td>
        <td><?=$isi[312];?></td>
        <td><?=$isi[313];?></td>
        <td><?=$isi[314];?></td>
        <td><?=$isi[315];?></td>
        <td><?=$isi[316];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 5</strong></div></td>
        <td><strong>AKAFARMA *)</strong></td>
        <td><?=$isi[317];?></td>
        <td><?=$isi[318];?></td>
        <td><?=$isi[319];?></td>
        <td><?=$isi[320];?></td>
        <td><?=$isi[321];?></td>
        <td><?=$isi[322];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 6</strong></div></td>
        <td><strong>AKFAR **)</strong></td>
        <td><?=$isi[323];?></td>
        <td><?=$isi[324];?></td>
        <td><?=$isi[325];?></td>
        <td><?=$isi[326];?></td>
        <td><?=$isi[327];?></td>
        <td><?=$isi[328];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 7</strong></div></td>
        <td><strong>Analis Farmasi</strong></td>
        <td><?=$isi[329];?></td>
        <td><?=$isi[330];?></td>
        <td><?=$isi[331];?></td>
        <td><?=$isi[332];?></td>
        <td><?=$isi[333];?></td>
        <td><?=$isi[334];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 8</strong></div></td>
        <td><strong>Asisten Apoteker / SMF</strong></td>
        <td><?=$isi[335];?></td>
        <td><?=$isi[336];?></td>
        <td><?=$isi[337];?></td>
        <td><?=$isi[338];?></td>
        <td><?=$isi[339];?></td>
        <td><?=$isi[340];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 9</strong></div></td>
        <td><strong>ST Lab Kimia Farmasi</strong></td>
        <td><?=$isi[341];?></td>
        <td><?=$isi[342];?></td>
        <td><?=$isi[343];?></td>
        <td><?=$isi[344];?></td>
        <td><?=$isi[345];?></td>
        <td><?=$isi[346];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3 88</strong></div></td>
        <td><strong>Tenaga Kefarmasian Lainnya</strong></td>
        <td><?=$isi[347];?></td>
        <td><?=$isi[348];?></td>
        <td><?=$isi[349];?></td>
        <td><?=$isi[350];?></td>
        <td><?=$isi[351];?></td>
        <td><?=$isi[352];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>3 99</strong></div></td>
        <td><strong>Total (3.00-3.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>4</strong></div></td>
        <td colspan="7"><strong>KESEHATAN MASYARAKAT</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>4 1</strong></div></td>
        <td><strong>S3 - Kesehatan Masyarakat</strong></td>
        <td><?=$isi[353];?></td>
        <td><?=$isi[354];?></td>
        <td><?=$isi[355];?></td>
        <td><?=$isi[356];?></td>
        <td><?=$isi[357];?></td>
        <td><?=$isi[358];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 2</strong></div></td>
        <td><strong>S3 - Epidemiologi</strong></td>
        <td><?=$isi[359];?></td>
        <td><?=$isi[360];?></td>
        <td><?=$isi[361];?></td>
        <td><?=$isi[362];?></td>
        <td><?=$isi[363];?></td>
        <td><?=$isi[364];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 3</strong></div></td>
        <td><strong>S3 - Psikologi</strong></td>
        <td><?=$isi[365];?></td>
        <td><?=$isi[366];?></td>
        <td><?=$isi[367];?></td>
        <td><?=$isi[368];?></td>
        <td><?=$isi[369];?></td>
        <td><?=$isi[370];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 4</strong></div></td>
        <td><strong>S2 - Kesehatan Masyarakat</strong></td>
        <td><?=$isi[371];?></td>
        <td><?=$isi[372];?></td>
        <td><?=$isi[373];?></td>
        <td><?=$isi[374];?></td>
        <td><?=$isi[375];?></td>
        <td><?=$isi[376];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 5</strong></div></td>
        <td><strong>S2 - Epidemiologi</strong></td>
        <td><?=$isi[377];?></td>
        <td><?=$isi[378];?></td>
        <td><?=$isi[379];?></td>
        <td><?=$isi[380];?></td>
        <td><?=$isi[381];?></td>
        <td><?=$isi[382];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 6</strong></div></td>
        <td><strong>S2 - Biomedik</strong></td>
        <td><?=$isi[383];?></td>
        <td><?=$isi[384];?></td>
        <td><?=$isi[385];?></td>
        <td><?=$isi[386];?></td>
        <td><?=$isi[387];?></td>
        <td><?=$isi[388];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 7</strong></div></td>
        <td><strong>S2 - Psikologi</strong></td>
        <td><?=$isi[389];?></td>
        <td><?=$isi[390];?></td>
        <td><?=$isi[391];?></td>
        <td><?=$isi[392];?></td>
        <td><?=$isi[393];?></td>
        <td><?=$isi[394];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 8</strong></div></td>
        <td><strong>S1 - Kesehatan Masyarakat</strong></td>
        <td><?=$isi[395];?></td>
        <td><?=$isi[396];?></td>
        <td><?=$isi[397];?></td>
        <td><?=$isi[398];?></td>
        <td><?=$isi[399];?></td>
        <td><?=$isi[400];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 9</strong></div></td>
        <td><strong>S1 - Psikologi</strong></td>
        <td><?=$isi[401];?></td>
        <td><?=$isi[402];?></td>
        <td><?=$isi[403];?></td>
        <td><?=$isi[404];?></td>
        <td><?=$isi[405];?></td>
        <td><?=$isi[406];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 10</strong></div></td>
        <td><strong>D3 - Kesehatan Masyarakat</strong></td>
        <td><?=$isi[407];?></td>
        <td><?=$isi[408];?></td>
        <td><?=$isi[409];?></td>
        <td><?=$isi[410];?></td>
        <td><?=$isi[411];?></td>
        <td><?=$isi[412];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 11</strong></div></td>
        <td><strong>D3 - Sanitarian</strong></td>
        <td><?=$isi[413];?></td>
        <td><?=$isi[414];?></td>
        <td><?=$isi[415];?></td>
        <td><?=$isi[416];?></td>
        <td><?=$isi[417];?></td>
        <td><?=$isi[418];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 12</strong></div></td>
        <td><strong>D1 - Sanitarian</strong></td>
        <td><?=$isi[419];?></td>
        <td><?=$isi[420];?></td>
        <td><?=$isi[421];?></td>
        <td><?=$isi[422];?></td>
        <td><?=$isi[423];?></td>
        <td><?=$isi[424];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4 88</strong></div></td>
        <td><strong>Tenaga Kesehatan Masy. Lainnya</strong></td>
        <td><?=$isi[425];?></td>
        <td><?=$isi[426];?></td>
        <td><?=$isi[427];?></td>
        <td><?=$isi[428];?></td>
        <td><?=$isi[429];?></td>
        <td><?=$isi[430];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>4 99</strong></div></td>
        <td><strong>Total (4.00-4.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>5</strong></div></td>
        <td colspan="7"><strong>Gizi</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>5 1</strong></div></td>
        <td><strong>S3 - Gizi / Dietisien</strong></td>
        <td><?=$isi[431];?></td>
        <td><?=$isi[432];?></td>
        <td><?=$isi[433];?></td>
        <td><?=$isi[434];?></td>
        <td><?=$isi[435];?></td>
        <td><?=$isi[436];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 2</strong></div></td>
        <td><strong>S2 - Gizi / Dietisien</strong></td>
        <td><?=$isi[437];?></td>
        <td><?=$isi[438];?></td>
        <td><?=$isi[439];?></td>
        <td><?=$isi[440];?></td>
        <td><?=$isi[441];?></td>
        <td><?=$isi[442];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 3</strong></div></td>
        <td><strong>S1 - Gizi / Dietisien</strong></td>
        <td><?=$isi[443];?></td>
        <td><?=$isi[444];?></td>
        <td><?=$isi[445];?></td>
        <td><?=$isi[445];?></td>
        <td><?=$isi[446];?></td>
        <td><?=$isi[447];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 4</strong></div></td>
        <td><strong>D4 - Gizi / Dietisien</strong></td>
        <td><?=$isi[448];?></td>
        <td><?=$isi[449];?></td>
        <td><?=$isi[450];?></td>
        <td><?=$isi[451];?></td>
        <td><?=$isi[452];?></td>
        <td><?=$isi[453];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 5</strong></div></td>
        <td><strong>Akademi / D3 - Gizi / Dietisien</strong></td>
        <td><?=$isi[454];?></td>
        <td><?=$isi[455];?></td>
        <td><?=$isi[456];?></td>
        <td><?=$isi[457];?></td>
        <td><?=$isi[458];?></td>
        <td><?=$isi[459];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 6</strong></div></td>
        <td><strong>D1 - Gizi / Dietisien</strong></td>
        <td><?=$isi[460];?></td>
        <td><?=$isi[461];?></td>
        <td><?=$isi[462];?></td>
        <td><?=$isi[463];?></td>
        <td><?=$isi[464];?></td>
        <td><?=$isi[465];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5 88</strong></div></td>
        <td><strong>Tenaga Gizi Lainnya</strong></td>
        <td><?=$isi[466];?></td>
        <td><?=$isi[467];?></td>
        <td><?=$isi[468];?></td>
        <td><?=$isi[469];?></td>
        <td><?=$isi[470];?></td>
        <td><?=$isi[471];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>5 99</strong></div></td>
        <td><strong>Total (5.00-5.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>6</strong></div></td>
        <td colspan="7"><strong>KETERAPIAN FISIK</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>6 1</strong></div></td>
        <td><strong>S1 Fisio Terapis</strong></td>
        <td><?=$isi[472];?></td>
        <td><?=$isi[473];?></td>
        <td><?=$isi[474];?></td>
        <td><?=$isi[475];?></td>
        <td><?=$isi[476];?></td>
        <td><?=$isi[477];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 2</strong></div></td>
        <td><strong>D3 Fisio Terapis</strong></td>
        <td><?=$isi[478];?></td>
        <td><?=$isi[479];?></td>
        <td><?=$isi[480];?></td>
        <td><?=$isi[481];?></td>
        <td><?=$isi[482];?></td>
        <td><?=$isi[483];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 3</strong></div></td>
        <td><strong>D3 Okupasi Terapis</strong></td>
        <td><?=$isi[484];?></td>
        <td><?=$isi[485];?></td>
        <td><?=$isi[486];?></td>
        <td><?=$isi[487];?></td>
        <td><?=$isi[488];?></td>
        <td><?=$isi[489];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 4</strong></div></td>
        <td><strong>D3 Terapi wicara</strong></td>
        <td><?=$isi[490];?></td>
        <td><?=$isi[491];?></td>
        <td><?=$isi[492];?></td>
        <td><?=$isi[493];?></td>
        <td><?=$isi[494];?></td>
        <td><?=$isi[495];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 5</strong></div></td>
        <td><strong>D3 Orthopedi</strong></td>
        <td><?=$isi[496];?></td>
        <td><?=$isi[497];?></td>
        <td><?=$isi[498];?></td>
        <td><?=$isi[499];?></td>
        <td><?=$isi[500];?></td>
        <td><?=$isi[501];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 6</strong></div></td>
        <td><strong>D3 Akupuntur</strong></td>
        <td><?=$isi[502];?></td>
        <td><?=$isi[503];?></td>
        <td><?=$isi[504];?></td>
        <td><?=$isi[505];?></td>
        <td><?=$isi[506];?></td>
        <td><?=$isi[507];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6 88</strong></div></td>
        <td><strong>Tenaga Keterapian Fisik Lainnya</strong></td>
        <td><?=$isi[508];?></td>
        <td><?=$isi[509];?></td>
        <td><?=$isi[510];?></td>
        <td><?=$isi[511];?></td>
        <td><?=$isi[512];?></td>
        <td><?=$isi[513];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>6 99</strong></div></td>
        <td><strong>Total (6.00-6.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>7</strong></div></td>
        <td colspan="7"><strong>KETEKNISIAN MEDIS</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>7 1</strong></div></td>
        <td><strong>S3 Opto Elektronika &amp; Apl Laser</strong></td>
        <td><?=$isi[513];?></td>
        <td><?=$isi[514];?></td>
        <td><?=$isi[515];?></td>
        <td><?=$isi[516];?></td>
        <td><?=$isi[517];?></td>
        <td><?=$isi[518];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 2</strong></div></td>
        <td><strong>S2 Opto Elektronika &amp; Apl Laser</strong></td>
        <td><?=$isi[519];?></td>
        <td><?=$isi[520];?></td>
        <td><?=$isi[521];?></td>
        <td><?=$isi[522];?></td>
        <td><?=$isi[523];?></td>
        <td><?=$isi[524];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 3</strong></div></td>
        <td><strong>Radiografer</strong></td>
        <td><?=$isi[525];?></td>
        <td><?=$isi[526];?></td>
        <td><?=$isi[527];?></td>
        <td><?=$isi[528];?></td>
        <td><?=$isi[529];?></td>
        <td><?=$isi[530];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 4</strong></div></td>
        <td><strong>Radioterapis (Non Dokter)</strong></td>
        <td><?=$isi[531];?></td>
        <td><?=$isi[532];?></td>
        <td><?=$isi[533];?></td>
        <td><?=$isi[534];?></td>
        <td><?=$isi[535];?></td>
        <td><?=$isi[536];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 5</strong></div></td>
        <td><strong>D4 Fisika Medik</strong></td>
        <td><?=$isi[537];?></td>
        <td><?=$isi[538];?></td>
        <td><?=$isi[539];?></td>
        <td><?=$isi[540];?></td>
        <td><?=$isi[541];?></td>
        <td><?=$isi[542];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 6</strong></div></td>
        <td><strong>D3 Teknik Gigi</strong></td>
        <td><?=$isi[543];?></td>
        <td><?=$isi[544];?></td>
        <td><?=$isi[545];?></td>
        <td><?=$isi[546];?></td>
        <td><?=$isi[547];?></td>
        <td><?=$isi[548];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 7</strong></div></td>
        <td><strong>D3 Teknik Radiologi &amp; Radioterapi</strong></td>
        <td><?=$isi[549];?></td>
        <td><?=$isi[550];?></td>
        <td><?=$isi[551];?></td>
        <td><?=$isi[552];?></td>
        <td><?=$isi[553];?></td>
        <td><?=$isi[554];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 8</strong></div></td>
        <td><strong>D3 Refraksionis Optisien</strong></td>
        <td><?=$isi[555];?></td>
        <td><?=$isi[556];?></td>
        <td><?=$isi[557];?></td>
        <td><?=$isi[558];?></td>
        <td><?=$isi[559];?></td>
        <td><?=$isi[560];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 9</strong></div></td>
        <td><strong>D3 Perekam Medis</strong></td>
        <td><?=$isi[561];?></td>
        <td><?=$isi[562];?></td>
        <td><?=$isi[563];?></td>
        <td><?=$isi[564];?></td>
        <td><?=$isi[565];?></td>
        <td><?=$isi[566];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 10</strong></div></td>
        <td><strong>D3 Teknik Elektromedik</strong></td>
        <td><?=$isi[567];?></td>
        <td><?=$isi[568];?></td>
        <td><?=$isi[569];?></td>
        <td><?=$isi[570];?></td>
        <td><?=$isi[571];?></td>
        <td><?=$isi[572];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 11</strong></div></td>
        <td><strong>D3 Analis Kesehatan</strong></td>
        <td><?=$isi[573];?></td>
        <td><?=$isi[574];?></td>
        <td><?=$isi[575];?></td>
        <td><?=$isi[576];?></td>
        <td><?=$isi[577];?></td>
        <td><?=$isi[578];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 12</strong></div></td>
        <td><strong>D3 Informasi Kesehatan</strong></td>
        <td><?=$isi[579];?></td>
        <td><?=$isi[580];?></td>
        <td><?=$isi[581];?></td>
        <td><?=$isi[582];?></td>
        <td><?=$isi[583];?></td>
        <td><?=$isi[584];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 13</strong></div></td>
        <td><strong>D3 Kardiovaskular</strong></td>
        <td><?=$isi[585];?></td>
        <td><?=$isi[586];?></td>
        <td><?=$isi[587];?></td>
        <td><?=$isi[588];?></td>
        <td><?=$isi[589];?></td>
        <td><?=$isi[590];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 14</strong></div></td>
        <td><strong>D3 Orthotik Prostetik</strong></td>
        <td><?=$isi[591];?></td>
        <td><?=$isi[592];?></td>
        <td><?=$isi[593];?></td>
        <td><?=$isi[594];?></td>
        <td><?=$isi[595];?></td>
        <td><?=$isi[596];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 15</strong></div></td>
        <td><strong>D1 Teknik Tranfusi</strong></td>
        <td><?=$isi[597];?></td>
        <td><?=$isi[598];?></td>
        <td><?=$isi[599];?></td>
        <td><?=$isi[600];?></td>
        <td><?=$isi[601];?></td>
        <td><?=$isi[602];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 16</strong></div></td>
        <td><strong>Teknisi Gigi</strong></td>
        <td><?=$isi[603];?></td>
        <td><?=$isi[604];?></td>
        <td><?=$isi[605];?></td>
        <td><?=$isi[606];?></td>
        <td><?=$isi[607];?></td>
        <td><?=$isi[608];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 17</strong></div></td>
        <td><strong>Tenaga IT dengan Teknologi Nano</strong></td>
        <td><?=$isi[609];?></td>
        <td><?=$isi[610];?></td>
        <td><?=$isi[611];?></td>
        <td><?=$isi[612];?></td>
        <td><?=$isi[613];?></td>
        <td><?=$isi[614];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 18</strong></div></td>
        <td><strong>Teknisi Patologi Anatomi</strong></td>
        <td><?=$isi[615];?></td>
        <td><?=$isi[616];?></td>
        <td><?=$isi[617];?></td>
        <td><?=$isi[618];?></td>
        <td><?=$isi[619];?></td>
        <td><?=$isi[620];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 19</strong></div></td>
        <td><strong>Teknisi Kardiovaskuler</strong></td>
        <td><?=$isi[621];?></td>
        <td><?=$isi[622];?></td>
        <td><?=$isi[623];?></td>
        <td><?=$isi[624];?></td>
        <td><?=$isi[625];?></td>
        <td><?=$isi[626];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 20</strong></div></td>
        <td><strong>Teknisi Elektromedis</strong></td>
        <td><?=$isi[627];?></td>
        <td><?=$isi[628];?></td>
        <td><?=$isi[629];?></td>
        <td><?=$isi[630];?></td>
        <td><?=$isi[631];?></td>
        <td><?=$isi[632];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 21</strong></div></td>
        <td><strong>Akupuntur Terapi</strong></td>
        <td><?=$isi[633];?></td>
        <td><?=$isi[634];?></td>
        <td><?=$isi[635];?></td>
        <td><?=$isi[636];?></td>
        <td><?=$isi[637];?></td>
        <td><?=$isi[638];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 22</strong></div></td>
        <td><strong>Analis Kesehatan</strong></td>
        <td><?=$isi[639];?></td>
        <td><?=$isi[640];?></td>
        <td><?=$isi[641];?></td>
        <td><?=$isi[642];?></td>
        <td><?=$isi[643];?></td>
        <td><?=$isi[644];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7 88</strong></div></td>
        <td><strong>Tenaga Keterapian fisik Lainnya</strong></td>
        <td><?=$isi[645];?></td>
        <td><?=$isi[646];?></td>
        <td><?=$isi[647];?></td>
        <td><?=$isi[648];?></td>
        <td><?=$isi[649];?></td>
        <td><?=$isi[650];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>7 99</strong></div></td>
        <td><strong>Total (7.00-7.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>II</strong></div></td>
        <td colspan="7"><strong>TENAGA NON KESEHATAN</strong></td>
        </tr>
      <tr>
        <td  ><div align="center"><strong>8</strong></div></td>
        <td colspan="7"><strong>DOKTORAL</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>8 1</strong></div></td>
        <td><strong>S3 Biologi</strong></td>
        <td><?=$isi[651];?></td>
        <td><?=$isi[652];?></td>
        <td><?=$isi[653];?></td>
        <td><?=$isi[654];?></td>
        <td><?=$isi[655];?></td>
        <td><?=$isi[656];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 2</strong></div></td>
        <td><strong>S3 Kimia</strong></td>
        <td><?=$isi[657];?></td>
        <td><?=$isi[658];?></td>
        <td><?=$isi[659];?></td>
        <td><?=$isi[660];?></td>
        <td><?=$isi[661];?></td>
        <td><?=$isi[662];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 3</strong></div></td>
        <td><strong>S3 Ekonomi / Akuntansi</strong></td>
        <td><?=$isi[663];?></td>
        <td><?=$isi[664];?></td>
        <td><?=$isi[665];?></td>
        <td><?=$isi[666];?></td>
        <td><?=$isi[667];?></td>
        <td><?=$isi[668];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 4</strong></div></td>
        <td><strong>S3 Administrasi</strong></td>
        <td><?=$isi[669];?></td>
        <td><?=$isi[670];?></td>
        <td><?=$isi[671];?></td>
        <td><?=$isi[672];?></td>
        <td><?=$isi[673];?></td>
        <td><?=$isi[674];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 5</strong></div></td>
        <td><strong>S3 Hukum</strong></td>
        <td><?=$isi[675];?></td>
        <td><?=$isi[676];?></td>
        <td><?=$isi[677];?></td>
        <td><?=$isi[678];?></td>
        <td><?=$isi[679];?></td>
        <td><?=$isi[680];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 6</strong></div></td>
        <td><strong>S3 Tehnik</strong></td>
        <td><?=$isi[681];?></td>
        <td><?=$isi[682];?></td>
        <td><?=$isi[683];?></td>
        <td><?=$isi[684];?></td>
        <td><?=$isi[685];?></td>
        <td><?=$isi[686];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 7</strong></div></td>
        <td><strong>S3 Kes. Sosial</strong></td>
        <td><?=$isi[687];?></td>
        <td><?=$isi[688];?></td>
        <td><?=$isi[689];?></td>
        <td><?=$isi[690];?></td>
        <td><?=$isi[691];?></td>
        <td><?=$isi[692];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 8</strong></div></td>
        <td><strong>S3 Fisika</strong></td>
        <td><?=$isi[693];?></td>
        <td><?=$isi[694];?></td>
        <td><?=$isi[695];?></td>
        <td><?=$isi[696];?></td>
        <td><?=$isi[697];?></td>
        <td><?=$isi[698];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 9</strong></div></td>
        <td><strong>S3 Komputer</strong></td>
        <td><?=$isi[699];?></td>
        <td><?=$isi[700];?></td>
        <td><?=$isi[701];?></td>
        <td><?=$isi[702];?></td>
        <td><?=$isi[703];?></td>
        <td><?=$isi[704];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 10</strong></div></td>
        <td><strong>S3 Statistik</strong></td>
        <td><?=$isi[705];?></td>
        <td><?=$isi[706];?></td>
        <td><?=$isi[707];?></td>
        <td><?=$isi[708];?></td>
        <td><?=$isi[709];?></td>
        <td><?=$isi[710];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8 88</strong></div></td>
        <td><strong>Doktoral Lainnya (S3)</strong></td>
        <td><?=$isi[711];?></td>
        <td><?=$isi[712];?></td>
        <td><?=$isi[713];?></td>
        <td><?=$isi[714];?></td>
        <td><?=$isi[715];?></td>
        <td><?=$isi[716];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>8 99</strong></div></td>
        <td><strong>Total (8.00 - 8.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>9</strong></div></td>
        <td colspan="7"><strong>PASCA SARJANA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>9 1</strong></div></td>
        <td><strong>S2 Biologi</strong></td>
        <td><?=$isi[717];?></td>
        <td><?=$isi[718];?></td>
        <td><?=$isi[719];?></td>
        <td><?=$isi[720];?></td>
        <td><?=$isi[721];?></td>
        <td><?=$isi[722];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 2</strong></div></td>
        <td><strong>S2 Kimia</strong></td>
        <td><?=$isi[723];?></td>
        <td><?=$isi[724];?></td>
        <td><?=$isi[725];?></td>
        <td><?=$isi[726];?></td>
        <td><?=$isi[727];?></td>
        <td><?=$isi[728];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 3</strong></div></td>
        <td><strong>S2 Ekonomi / Akuntansi</strong></td>
        <td><?=$isi[729];?></td>
        <td><?=$isi[730];?></td>
        <td><?=$isi[731];?></td>
        <td><?=$isi[732];?></td>
        <td><?=$isi[733];?></td>
        <td><?=$isi[734];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 4</strong></div></td>
        <td><strong>S2 Administrasi</strong></td>
        <td><?=$isi[735];?></td>
        <td><?=$isi[736];?></td>
        <td><?=$isi[737];?></td>
        <td><?=$isi[738];?></td>
        <td><?=$isi[739];?></td>
        <td><?=$isi[740];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 5</strong></div></td>
        <td><strong>S2 Hukum</strong></td>
        <td><?=$isi[741];?></td>
        <td><?=$isi[742];?></td>
        <td><?=$isi[743];?></td>
        <td><?=$isi[744];?></td>
        <td><?=$isi[745];?></td>
        <td><?=$isi[746];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 6</strong></div></td>
        <td><strong>S2 Tehnik</strong></td>
        <td><?=$isi[747];?></td>
        <td><?=$isi[748];?></td>
        <td><?=$isi[749];?></td>
        <td><?=$isi[750];?></td>
        <td><?=$isi[751];?></td>
        <td><?=$isi[752];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 7</strong></div></td>
        <td><strong>S2 Kesejahteraan Sosial</strong></td>
        <td><?=$isi[753];?></td>
        <td><?=$isi[754];?></td>
        <td><?=$isi[755];?></td>
        <td><?=$isi[756];?></td>
        <td><?=$isi[757];?></td>
        <td><?=$isi[758];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 8</strong></div></td>
        <td><strong>S2 Fisika</strong></td>
        <td><?=$isi[759];?></td>
        <td><?=$isi[760];?></td>
        <td><?=$isi[761];?></td>
        <td><?=$isi[762];?></td>
        <td><?=$isi[763];?></td>
        <td><?=$isi[764];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 9</strong></div></td>
        <td><strong>S2 Komputer</strong></td>
        <td><?=$isi[765];?></td>
        <td><?=$isi[766];?></td>
        <td><?=$isi[767];?></td>
        <td><?=$isi[768];?></td>
        <td><?=$isi[769];?></td>
        <td><?=$isi[770];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 10</strong></div></td>
        <td><strong>S2 Statistik</strong></td>
        <td><?=$isi[771];?></td>
        <td><?=$isi[772];?></td>
        <td><?=$isi[773];?></td>
        <td><?=$isi[774];?></td>
        <td><?=$isi[775];?></td>
        <td><?=$isi[776];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 11</strong></div></td>
        <td><strong>S2 Administrasi Kes. Masy</strong></td>
        <td><?=$isi[777];?></td>
        <td><?=$isi[778];?></td>
        <td><?=$isi[779];?></td>
        <td><?=$isi[780];?></td>
        <td><?=$isi[781];?></td>
        <td><?=$isi[782];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9 88</strong></div></td>
        <td><strong>Pasca Sarjana Lainnya (S2)</strong></td>
        <td><?=$isi[783];?></td>
        <td><?=$isi[784];?></td>
        <td><?=$isi[785];?></td>
        <td><?=$isi[786];?></td>
        <td><?=$isi[787];?></td>
        <td><?=$isi[788];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>9 99</strong></div></td>
        <td><strong>Total (9.00 - 9.99)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>10</strong></div></td>
        <td colspan="7"><strong>SARJANA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>10 1</strong></div></td>
        <td><strong>Sarjana Biologi</strong></td>
        <td><?=$isi[789];?></td>
        <td><?=$isi[790];?></td>
        <td><?=$isi[791];?></td>
        <td><?=$isi[792];?></td>
        <td><?=$isi[793];?></td>
        <td><?=$isi[794];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 2</strong></div></td>
        <td><strong>Sarjana Kimia</strong></td>
        <td><?=$isi[795];?></td>
        <td><?=$isi[796];?></td>
        <td><?=$isi[797];?></td>
        <td><?=$isi[798];?></td>
        <td><?=$isi[799];?></td>
        <td><?=$isi[800];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 3</strong></div></td>
        <td><strong>Sarjana Ekonomi / Akuntansi</strong></td>
        <td><?=$isi[801];?></td>
        <td><?=$isi[802];?></td>
        <td><?=$isi[803];?></td>
        <td><?=$isi[804];?></td>
        <td><?=$isi[805];?></td>
        <td><?=$isi[806];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 4</strong></div></td>
        <td><strong>Sarjana Administrasi</strong></td>
        <td><?=$isi[807];?></td>
        <td><?=$isi[808];?></td>
        <td><?=$isi[809];?></td>
        <td><?=$isi[810];?></td>
        <td><?=$isi[811];?></td>
        <td><?=$isi[812];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 5</strong></div></td>
        <td><strong>Sarjana Hukum</strong></td>
        <td><?=$isi[813];?></td>
        <td><?=$isi[814];?></td>
        <td><?=$isi[815];?></td>
        <td><?=$isi[816];?></td>
        <td><?=$isi[817];?></td>
        <td><?=$isi[818];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 6</strong></div></td>
        <td><strong>Sarjana Tehnik</strong></td>
        <td><?=$isi[819];?></td>
        <td><?=$isi[820];?></td>
        <td><?=$isi[821];?></td>
        <td><?=$isi[822];?></td>
        <td><?=$isi[823];?></td>
        <td><?=$isi[824];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 7</strong></div></td>
        <td><strong>Sarjana Kes. Sosial</strong></td>
        <td><?=$isi[825];?></td>
        <td><?=$isi[826];?></td>
        <td><?=$isi[827];?></td>
        <td><?=$isi[828];?></td>
        <td><?=$isi[829];?></td>
        <td><?=$isi[830];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 8</strong></div></td>
        <td><strong>Sarjana Fisika</strong></td>
        <td><?=$isi[831];?></td>
        <td><?=$isi[832];?></td>
        <td><?=$isi[833];?></td>
        <td><?=$isi[834];?></td>
        <td><?=$isi[835];?></td>
        <td><?=$isi[836];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 9</strong></div></td>
        <td><strong>Sarjana Komputer</strong></td>
        <td><?=$isi[837];?></td>
        <td><?=$isi[838];?></td>
        <td><?=$isi[839];?></td>
        <td><?=$isi[840];?></td>
        <td><?=$isi[841];?></td>
        <td><?=$isi[842];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 10</strong></div></td>
        <td><strong>Sarjana Statistik</strong></td>
        <td><?=$isi[843];?></td>
        <td><?=$isi[844];?></td>
        <td><?=$isi[845];?></td>
        <td><?=$isi[846];?></td>
        <td><?=$isi[847];?></td>
        <td><?=$isi[848];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10 88</strong></div></td>
        <td><strong>Sarjana Lainnya (S1)</strong></td>
        <td><?=$isi[849];?></td>
        <td><?=$isi[850];?></td>
        <td><?=$isi[851];?></td>
        <td><?=$isi[852];?></td>
        <td><?=$isi[853];?></td>
        <td><?=$isi[854];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>10 99</strong></div></td>
        <td><strong>Total (10.00-10.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>11</strong></div></td>
        <td colspan="7"><strong>SARJANA MUDA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>11 1</strong></div></td>
        <td><strong>Sarjana Muda Biologi</strong></td>
        <td><?=$isi[855];?></td>
        <td><?=$isi[856];?></td>
        <td><?=$isi[857];?></td>
        <td><?=$isi[858];?></td>
        <td><?=$isi[859];?></td>
        <td><?=$isi[860];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 2</strong></div></td>
        <td><strong>ApotekSarjana Muda Kimia</strong></td>
        <td><?=$isi[861];?></td>
        <td><?=$isi[862];?></td>
        <td><?=$isi[863];?></td>
        <td><?=$isi[864];?></td>
        <td><?=$isi[865];?></td>
        <td><?=$isi[866];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 3</strong></div></td>
        <td><strong>Sarjana Muda Ekonomi / Akuntansi</strong></td>
        <td><?=$isi[867];?></td>
        <td><?=$isi[868];?></td>
        <td><?=$isi[869];?></td>
        <td><?=$isi[870];?></td>
        <td><?=$isi[871];?></td>
        <td><?=$isi[872];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 4</strong></div></td>
        <td><strong>Sarjana Muda Administrasi</strong></td>
        <td><?=$isi[873];?></td>
        <td><?=$isi[874];?></td>
        <td><?=$isi[875];?></td>
        <td><?=$isi[876];?></td>
        <td><?=$isi[877];?></td>
        <td><?=$isi[878];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 5</strong></div></td>
        <td><strong>Sarjana Muda Hukum</strong></td>
        <td><?=$isi[879];?></td>
        <td><?=$isi[880];?></td>
        <td><?=$isi[881];?></td>
        <td><?=$isi[882];?></td>
        <td><?=$isi[883];?></td>
        <td><?=$isi[884];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 6</strong></div></td>
        <td><strong>Sarjana Muda Tehnik</strong></td>
        <td><?=$isi[885];?></td>
        <td><?=$isi[886];?></td>
        <td><?=$isi[887];?></td>
        <td><?=$isi[888];?></td>
        <td><?=$isi[889];?></td>
        <td><?=$isi[890];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 7</strong></div></td>
        <td><strong>Sarjana Muda Kes. Sosial</strong></td>
        <td><?=$isi[891];?></td>
        <td><?=$isi[892];?></td>
        <td><?=$isi[893];?></td>
        <td><?=$isi[894];?></td>
        <td><?=$isi[895];?></td>
        <td><?=$isi[896];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 8</strong></div></td>
        <td><strong>Sarjana Muda Statistik</strong></td>
        <td><?=$isi[897];?></td>
        <td><?=$isi[898];?></td>
        <td><?=$isi[899];?></td>
        <td><?=$isi[900];?></td>
        <td><?=$isi[901];?></td>
        <td><?=$isi[902];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 9</strong></div></td>
        <td><strong>Sarjana Muda Komputer</strong></td>
        <td><?=$isi[903];?></td>
        <td><?=$isi[904];?></td>
        <td><?=$isi[905];?></td>
        <td><?=$isi[906];?></td>
        <td><?=$isi[907];?></td>
        <td><?=$isi[908];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 10</strong></div></td>
        <td><strong>Sarjana Muda Sekretaris</strong></td>
        <td><?=$isi[909];?></td>
        <td><?=$isi[910];?></td>
        <td><?=$isi[911];?></td>
        <td><?=$isi[912];?></td>
        <td><?=$isi[913];?></td>
        <td><?=$isi[914];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11 88</strong></div></td>
        <td><strong>Sarjana Muda / D3 Lainnya</strong></td>
        <td><?=$isi[915];?></td>
        <td><?=$isi[916];?></td>
        <td><?=$isi[917];?></td>
        <td><?=$isi[918];?></td>
        <td><?=$isi[919];?></td>
        <td><?=$isi[920];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>11 99</strong></div></td>
        <td><strong>Total (11.00-11.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>12</strong></div></td>
        <td colspan="7"><strong>SMU SEDERAJAT DAN DIBAWAHNYA</strong></td>
        </tr>
      <tr>
        <td><div align="center"><strong>12 1</strong></div></td>
        <td><strong>SMA / SMU</strong></td>
        <td><?=$isi[921];?></td>
        <td><?=$isi[922];?></td>
        <td><?=$isi[923];?></td>
        <td><?=$isi[924];?></td>
        <td><?=$isi[925];?></td>
        <td><?=$isi[926];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 2</strong></div></td>
        <td><strong>SMEA</strong></td>
        <td><?=$isi[927];?></td>
        <td><?=$isi[928];?></td>
        <td><?=$isi[929];?></td>
        <td><?=$isi[930];?></td>
        <td><?=$isi[931];?></td>
        <td><?=$isi[932];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 3</strong></div></td>
        <td><strong>STM</strong></td>
        <td><?=$isi[933];?></td>
        <td><?=$isi[934];?></td>
        <td><?=$isi[935];?></td>
        <td><?=$isi[936];?></td>
        <td><?=$isi[937];?></td>
        <td><?=$isi[938];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 4</strong></div></td>
        <td><strong>SMKK</strong></td>
        <td><?=$isi[939];?></td>
        <td><?=$isi[940];?></td>
        <td><?=$isi[941];?></td>
        <td><?=$isi[942];?></td>
        <td><?=$isi[943];?></td>
        <td><?=$isi[944];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 5</strong></div></td>
        <td><strong>SPSA</strong></td>
        <td><?=$isi[945];?></td>
        <td><?=$isi[946];?></td>
        <td><?=$isi[947];?></td>
        <td><?=$isi[948];?></td>
        <td><?=$isi[949];?></td>
        <td><?=$isi[950];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 6</strong></div></td>
        <td><strong>SMTP</strong></td>
        <td><?=$isi[951];?></td>
        <td><?=$isi[952];?></td>
        <td><?=$isi[953];?></td>
        <td><?=$isi[954];?></td>
        <td><?=$isi[955];?></td>
        <td><?=$isi[956];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 7</strong></div></td>
        <td><strong>SD kebawah</strong></td>
        <td><?=$isi[957];?></td>
        <td><?=$isi[958];?></td>
        <td><?=$isi[959];?></td>
        <td><?=$isi[960];?></td>
        <td><?=$isi[961];?></td>
        <td><?=$isi[962];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12 88</strong></div></td>
        <td><strong>SMTA Lainnya</strong></td>
        <td><?=$isi[963];?></td>
        <td><?=$isi[964];?></td>
        <td><?=$isi[965];?></td>
        <td><?=$isi[966];?></td>
        <td><?=$isi[967];?></td>
        <td><?=$isi[968];?></td>
      </tr>
      <tr>
        <td  ><div align="center"><strong>12 99</strong></div></td>
        <td><strong>Total (12.00-12.88)</strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
    <tr id="trTombol">
                <td class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
    </tr>  
   
</table>
</body>
        <script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';           
           
            if(tombol.style.visibility=='collapse'){
               
                /*try{
			mulaiPrint();
		}
		catch(e){*/
			window.print();
			//window.close();
		//}
                    
            }
        }
        </script>
</html>

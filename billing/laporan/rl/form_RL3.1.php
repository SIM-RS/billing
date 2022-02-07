<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RL 3.1</title>
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
<table width="1200" border="0" style="border-collapse:collapse; font:12px arial">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000;"><center><img src="logo-bakti-husada.jpg" width="55" height="60" /></center></td>
        <td width="50%" height="31"><span class="style1">Formulir RL 3.1</span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><center><img src="pojok.png" /></center></td>
      </tr>
      <tr>
        <td height="50%" style="border-bottom:2px solid #000000"><span class="style1">KEGIATAN PELAYANAN RAWAT INAP  </span></td>
        </tr>
		<?php
		$sql="select * from b_form_rl31 where tahun=123";
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
        <td><?=$data['tahun'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td rowspan="2" width="3%"><div align="center"><strong>NO</strong></div></td>
        <td rowspan="2" width="20%"><div align="center"><strong>JENIS PELAYANAN </strong></div></td>
        <td rowspan="2" width="5,5%"><strong><center>PASIEN AWAL TAHUN </center></strong></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN MASUK </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN KELUAR HIDUP </strong></div></td>
        <td colspan="2" width="11%"><div align="center"><strong>PASIEN KELUAR MATI </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>JUMLAH LAMA DIRAWAT </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>PASIEN AKHIR TAHUN </strong></div></td>
        <td rowspan="2" width="5,5%"><div align="center"><strong>JUMLAH HARI PERAWATAN </strong></div></td>
        <td colspan="6"><div align="center"><strong>RINCIAN HARI PERAWATAN PER KELAS </strong></div></td>
      </tr>
      <tr>
        <td  width="5,5%"><div align="center"><strong>< 48 JAM </strong></div></td>
        <td  width="5,5%"><div align="center"><strong>>= 48 JAM </strong></div></td>
        <td  width="5,5%"><div align="center"><strong>VVIP</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>VIP</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>I</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>II</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>III</strong></div></td>
        <td  width="5,5%"><div align="center"><strong>KELAS KHUSUS </strong></div></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1</strong></div></td>
        <td><strong>Penyakit Dalam</strong></td>
        <td><?=$isi[0];?></td>
        <td><?=$isi[1];?></td>
        <td><?=$isi[2];?></td>
        <td><?=$isi[3];?></td>
        <td><?=$isi[4];?></td>
        <td><?=$isi[5];?></td>
        <td><?=$isi[6];?></td>
        <td><?=$isi[7];?></td>
        <td><?=$isi[8];?></td>
        <td><?=$isi[9];?></td>
        <td><?=$isi[10];?></td>
        <td><?=$isi[11];?></td>
        <td><?=$isi[12];?></td>
        <td><?=$isi[13];?></td>
        </tr>
      <tr>
        <td><div align="center"><strong>2</strong></div></td>
        <td><strong>Kesehatan Anak</strong></td>
        <td><?=$isi[14];?></td>
        <td><?=$isi[15];?></td>
        <td><?=$isi[16];?></td>
        <td><?=$isi[17];?></td>
        <td><?=$isi[18];?></td>
        <td><?=$isi[19];?></td>
        <td><?=$isi[20];?></td>
        <td><?=$isi[21];?></td>
        <td><?=$isi[22];?></td>
        <td><?=$isi[23];?></td>
        <td><?=$isi[24];?></td>
        <td><?=$isi[25];?></td>
        <td><?=$isi[26];?></td>
        <td><?=$isi[27];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>3</strong></div></td>
        <td><strong>Obstetri</strong></td>
        <td><?=$isi[28];?></td>
        <td><?=$isi[29];?></td>
        <td><?=$isi[30];?></td>
        <td><?=$isi[31];?></td>
        <td><?=$isi[32];?></td>
        <td><?=$isi[33];?></td>
        <td><?=$isi[34];?></td>
        <td><?=$isi[35];?></td>
        <td><?=$isi[36];?></td>
        <td><?=$isi[37];?></td>
        <td><?=$isi[38];?></td>
        <td><?=$isi[39];?></td>
        <td><?=$isi[40];?></td>
        <td><?=$isi[41];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>4</strong></div></td>
        <td><strong>Ginekologi</strong></td>
        <td><?=$isi[42];?></td>
        <td><?=$isi[43];?></td>
        <td><?=$isi[44];?></td>
        <td><?=$isi[45];?></td>
        <td><?=$isi[46];?></td>
        <td><?=$isi[47];?></td>
        <td><?=$isi[48];?></td>
        <td><?=$isi[49];?></td>
        <td><?=$isi[50];?></td>
        <td><?=$isi[51];?></td>
        <td><?=$isi[52];?></td>
        <td><?=$isi[53];?></td>
        <td><?=$isi[54];?></td>
        <td><?=$isi[55];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>5</strong></div></td>
        <td><strong>Bedah</strong></td>
        <td><?=$isi[56];?></td>
        <td><?=$isi[57];?></td>
        <td><?=$isi[58];?></td>
        <td><?=$isi[59];?></td>
        <td><?=$isi[60];?></td>
        <td><?=$isi[61];?></td>
        <td><?=$isi[62];?></td>
        <td><?=$isi[63];?></td>
        <td><?=$isi[64];?></td>
        <td><?=$isi[65];?></td>
        <td><?=$isi[66];?></td>
        <td><?=$isi[67];?></td>
        <td><?=$isi[68];?></td>
        <td><?=$isi[69];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>6</strong></div></td>
        <td><strong>Bedah Orthopedi</strong></td>
        <td><?=$isi[70];?></td>
        <td><?=$isi[71];?></td>
        <td><?=$isi[72];?></td>
        <td><?=$isi[73];?></td>
        <td><?=$isi[74];?></td>
        <td><?=$isi[75];?></td>
        <td><?=$isi[76];?></td>
        <td><?=$isi[77];?></td>
        <td><?=$isi[78];?></td>
        <td><?=$isi[79];?></td>
        <td><?=$isi[80];?></td>
        <td><?=$isi[81];?></td>
        <td><?=$isi[82];?></td>
        <td><?=$isi[83];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>7</strong></div></td>
        <td><strong>Bedah Saraf</strong></td>
        <td><?=$isi[84];?></td>
        <td><?=$isi[85];?></td>
        <td><?=$isi[86];?></td>
        <td><?=$isi[87];?></td>
        <td><?=$isi[88];?></td>
        <td><?=$isi[89];?></td>
        <td><?=$isi[90];?></td>
        <td><?=$isi[91];?></td>
        <td><?=$isi[92];?></td>
        <td><?=$isi[93];?></td>
        <td><?=$isi[94];?></td>
        <td><?=$isi[95];?></td>
        <td><?=$isi[96];?></td>
        <td><?=$isi[97];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>8</strong></div></td>
        <td><strong>Luka Bakar</strong></td>
        <td><?=$isi[98];?></td>
        <td><?=$isi[99];?></td>
        <td><?=$isi[100];?></td>
        <td><?=$isi[101];?></td>
        <td><?=$isi[102];?></td>
        <td><?=$isi[103];?></td>
        <td><?=$isi[104];?></td>
        <td><?=$isi[105];?></td>
        <td><?=$isi[106];?></td>
        <td><?=$isi[107];?></td>
        <td><?=$isi[108];?></td>
        <td><?=$isi[109];?></td>
        <td><?=$isi[110];?></td>
        <td><?=$isi[111];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>9</strong></div></td>
        <td><strong>Saraf</strong></td>
        <td><?=$isi[112];?></td>
        <td><?=$isi[113];?></td>
        <td><?=$isi[114];?></td>
        <td><?=$isi[115];?></td>
        <td><?=$isi[116];?></td>
        <td><?=$isi[117];?></td>
        <td><?=$isi[118];?></td>
        <td><?=$isi[119];?></td>
        <td><?=$isi[120];?></td>
        <td><?=$isi[121];?></td>
        <td><?=$isi[122];?></td>
        <td><?=$isi[123];?></td>
        <td><?=$isi[124];?></td>
        <td><?=$isi[125];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>10</strong></div></td>
        <td><strong>Jiwa</strong></td>
        <td><?=$isi[126];?></td>
        <td><?=$isi[127];?></td>
        <td><?=$isi[128];?></td>
        <td><?=$isi[129];?></td>
        <td><?=$isi[130];?></td>
        <td><?=$isi[131];?></td>
        <td><?=$isi[132];?></td>
        <td><?=$isi[133];?></td>
        <td><?=$isi[134];?></td>
        <td><?=$isi[135];?></td>
        <td><?=$isi[136];?></td>
        <td><?=$isi[137];?></td>
        <td><?=$isi[138];?></td>
        <td><?=$isi[139];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>11</strong></div></td>
        <td><strong>Psikologi</strong></td>
        <td><?=$isi[140];?></td>
        <td><?=$isi[141];?></td>
        <td><?=$isi[142];?></td>
        <td><?=$isi[143];?></td>
        <td><?=$isi[144];?></td>
        <td><?=$isi[145];?></td>
        <td><?=$isi[146];?></td>
        <td><?=$isi[147];?></td>
        <td><?=$isi[148];?></td>
        <td><?=$isi[149];?></td>
        <td><?=$isi[150];?></td>
        <td><?=$isi[151];?></td>
        <td><?=$isi[152];?></td>
        <td><?=$isi[153];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>12</strong></div></td>
        <td><strong>Penatalaksana Pnyguna. NAPZA</strong></td>
        <td><?=$isi[154];?></td>
        <td><?=$isi[155];?></td>
        <td><?=$isi[156];?></td>
        <td><?=$isi[157];?></td>
        <td><?=$isi[158];?></td>
        <td><?=$isi[159];?></td>
        <td><?=$isi[160];?></td>
        <td><?=$isi[161];?></td>
        <td><?=$isi[162];?></td>
        <td><?=$isi[163];?></td>
        <td><?=$isi[164];?></td>
        <td><?=$isi[165];?></td>
        <td><?=$isi[166];?></td>
        <td><?=$isi[167];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>13</strong></div></td>
        <td><strong>THT</strong></td>
        <td><?=$isi[168];?></td>
        <td><?=$isi[169];?></td>
        <td><?=$isi[170];?></td>
        <td><?=$isi[171];?></td>
        <td><?=$isi[172];?></td>
        <td><?=$isi[173];?></td>
        <td><?=$isi[174];?></td>
        <td><?=$isi[175];?></td>
        <td><?=$isi[176];?></td>
        <td><?=$isi[177];?></td>
        <td><?=$isi[178];?></td>
        <td><?=$isi[179];?></td>
        <td><?=$isi[180];?></td>
        <td><?=$isi[181];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>14</strong></div></td>
        <td><strong>Mata</strong></td>
        <td><?=$isi[182];?></td>
        <td><?=$isi[183];?></td>
        <td><?=$isi[184];?></td>
        <td><?=$isi[185];?></td>
        <td><?=$isi[186];?></td>
        <td><?=$isi[187];?></td>
        <td><?=$isi[188];?></td>
        <td><?=$isi[189];?></td>
        <td><?=$isi[190];?></td>
        <td><?=$isi[191];?></td>
        <td><?=$isi[192];?></td>
        <td><?=$isi[193];?></td>
        <td><?=$isi[194];?></td>
        <td><?=$isi[195];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>15</strong></div></td>
        <td><strong>Kulit &amp; Kelamin</strong></td>
        <td><?=$isi[196];?></td>
        <td><?=$isi[197];?></td>
        <td><?=$isi[198];?></td>
        <td><?=$isi[199];?></td>
        <td><?=$isi[200];?></td>
        <td><?=$isi[201];?></td>
        <td><?=$isi[202];?></td>
        <td><?=$isi[203];?></td>
        <td><?=$isi[204];?></td>
        <td><?=$isi[205];?></td>
        <td><?=$isi[206];?></td>
        <td><?=$isi[207];?></td>
        <td><?=$isi[208];?></td>
        <td><?=$isi[209];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>16</strong></div></td>
        <td><strong>Kardiologi</strong></td>
        <td><?=$isi[210];?></td>
        <td><?=$isi[211];?></td>
        <td><?=$isi[212];?></td>
        <td><?=$isi[213];?></td>
        <td><?=$isi[214];?></td>
        <td><?=$isi[215];?></td>
        <td><?=$isi[216];?></td>
        <td><?=$isi[217];?></td>
        <td><?=$isi[218];?></td>
        <td><?=$isi[219];?></td>
        <td><?=$isi[210];?></td>
        <td><?=$isi[221];?></td>
        <td><?=$isi[222];?></td>
        <td><?=$isi[223];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>17</strong></div></td>
        <td><strong>Paru-paru</strong></td>
        <td><?=$isi[224];?></td>
        <td><?=$isi[225];?></td>
        <td><?=$isi[226];?></td>
        <td><?=$isi[227];?></td>
        <td><?=$isi[228];?></td>
        <td><?=$isi[229];?></td>
        <td><?=$isi[230];?></td>
        <td><?=$isi[231];?></td>
        <td><?=$isi[232];?></td>
        <td><?=$isi[233];?></td>
        <td><?=$isi[234];?></td>
        <td><?=$isi[235];?></td>
        <td><?=$isi[236];?></td>
        <td><?=$isi[237];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>18</strong></div></td>
        <td><strong>Geriatri</strong></td>
        <td><?=$isi[238];?></td>
        <td><?=$isi[239];?></td>
        <td><?=$isi[240];?></td>
        <td><?=$isi[241];?></td>
        <td><?=$isi[242];?></td>
        <td><?=$isi[243];?></td>
        <td><?=$isi[244];?></td>
        <td><?=$isi[245];?></td>
        <td><?=$isi[246];?></td>
        <td><?=$isi[247];?></td>
        <td><?=$isi[248];?></td>
        <td><?=$isi[249];?></td>
        <td><?=$isi[250];?></td>
        <td><?=$isi[251];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>19</strong></div></td>
        <td><strong>Radioterapi</strong></td>
        <td><?=$isi[252];?></td>
        <td><?=$isi[253];?></td>
        <td><?=$isi[254];?></td>
        <td><?=$isi[255];?></td>
        <td><?=$isi[256];?></td>
        <td><?=$isi[257];?></td>
        <td><?=$isi[258];?></td>
        <td><?=$isi[259];?></td>
        <td><?=$isi[260];?></td>
        <td><?=$isi[261];?></td>
        <td><?=$isi[262];?></td>
        <td><?=$isi[263];?></td>
        <td><?=$isi[264];?></td>
        <td><?=$isi[265];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>20</strong></div></td>
        <td><strong>Kedokteran Nuklir</strong></td>
        <td><?=$isi[266];?></td>
        <td><?=$isi[267];?></td>
        <td><?=$isi[268];?></td>
        <td><?=$isi[269];?></td>
        <td><?=$isi[270];?></td>
        <td><?=$isi[271];?></td>
        <td><?=$isi[272];?></td>
        <td><?=$isi[273];?></td>
        <td><?=$isi[274];?></td>
        <td><?=$isi[275];?></td>
        <td><?=$isi[276];?></td>
        <td><?=$isi[277];?></td>
        <td><?=$isi[278];?></td>
        <td><?=$isi[279];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>21</strong></div></td>
        <td><strong>K u s t a</strong></td>
        <td><?=$isi[280];?></td>
        <td><?=$isi[281];?></td>
        <td><?=$isi[282];?></td>
        <td><?=$isi[283];?></td>
        <td><?=$isi[284];?></td>
        <td><?=$isi[285];?></td>
        <td><?=$isi[286];?></td>
        <td><?=$isi[287];?></td>
        <td><?=$isi[288];?></td>
        <td><?=$isi[289];?></td>
        <td><?=$isi[290];?></td>
        <td><?=$isi[291];?></td>
        <td><?=$isi[292];?></td>
        <td><?=$isi[293];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>22</strong></div></td>
        <td><strong>Rehabilitasi Medik</strong></td>
        <td><?=$isi[294];?></td>
        <td><?=$isi[295];?></td>
        <td><?=$isi[296];?></td>
        <td><?=$isi[297];?></td>
        <td><?=$isi[298];?></td>
        <td><?=$isi[299];?></td>
        <td><?=$isi[300];?></td>
        <td><?=$isi[301];?></td>
        <td><?=$isi[302];?></td>
        <td><?=$isi[303];?></td>
        <td><?=$isi[304];?></td>
        <td><?=$isi[305];?></td>
        <td><?=$isi[306];?></td>
        <td><?=$isi[307];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>23</strong></div></td>
        <td><strong>Isolasi</strong></td>
        <td><?=$isi[308];?></td>
        <td><?=$isi[309];?></td>
        <td><?=$isi[310];?></td>
        <td><?=$isi[311];?></td>
        <td><?=$isi[312];?></td>
        <td><?=$isi[313];?></td>
        <td><?=$isi[314];?></td>
        <td><?=$isi[315];?></td>
        <td><?=$isi[316];?></td>
        <td><?=$isi[317];?></td>
        <td><?=$isi[318];?></td>
        <td><?=$isi[319];?></td>
        <td><?=$isi[320];?></td>
        <td><?=$isi[321];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>24</strong></div></td>
        <td><strong>I C U</strong></td>
        <td><?=$isi[322];?></td>
        <td><?=$isi[323];?></td>
        <td><?=$isi[324];?></td>
        <td><?=$isi[325];?></td>
        <td><?=$isi[326];?></td>
        <td><?=$isi[327];?></td>
        <td><?=$isi[328];?></td>
        <td><?=$isi[329];?></td>
        <td><?=$isi[330];?></td>
        <td><?=$isi[331];?></td>
        <td><?=$isi[332];?></td>
        <td><?=$isi[333];?></td>
        <td><?=$isi[334];?></td>
        <td><?=$isi[335];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>25</strong></div></td>
        <td><strong>I C C U</strong></td>
        <td><?=$isi[336];?></td>
        <td><?=$isi[337];?></td>
        <td><?=$isi[338];?></td>
        <td><?=$isi[339];?></td>
        <td><?=$isi[340];?></td>
        <td><?=$isi[341];?></td>
        <td><?=$isi[342];?></td>
        <td><?=$isi[343];?></td>
        <td><?=$isi[344];?></td>
        <td><?=$isi[345];?></td>
        <td><?=$isi[346];?></td>
        <td><?=$isi[347];?></td>
        <td><?=$isi[348];?></td>
        <td><?=$isi[349];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>26</strong></div></td>
        <td><strong>NICU / PICU</strong></td>
        <td><?=$isi[350];?></td>
        <td><?=$isi[351];?></td>
        <td><?=$isi[352];?></td>
        <td><?=$isi[353];?></td>
        <td><?=$isi[354];?></td>
        <td><?=$isi[355];?></td>
        <td><?=$isi[356];?></td>
        <td><?=$isi[357];?></td>
        <td><?=$isi[358];?></td>
        <td><?=$isi[359];?></td>
        <td><?=$isi[360];?></td>
        <td><?=$isi[361];?></td>
        <td><?=$isi[362];?></td>
        <td><?=$isi[363];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>27</strong></div></td>
        <td><strong>Umum</strong></td>
        <td><?=$isi[364];?></td>
        <td><?=$isi[365];?></td>
        <td><?=$isi[366];?></td>
        <td><?=$isi[367];?></td>
        <td><?=$isi[368];?></td>
        <td><?=$isi[369];?></td>
        <td><?=$isi[370];?></td>
        <td><?=$isi[371];?></td>
        <td><?=$isi[372];?></td>
        <td><?=$isi[373];?></td>
        <td><?=$isi[374];?></td>
        <td><?=$isi[375];?></td>
        <td><?=$isi[376];?></td>
        <td><?=$isi[377];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>28</strong></div></td>
        <td><strong>Gigi &amp; Mulut</strong></td>
        <td><?=$isi[378];?></td>
        <td><?=$isi[379];?></td>
        <td><?=$isi[380];?></td>
        <td><?=$isi[381];?></td>
        <td><?=$isi[382];?></td>
        <td><?=$isi[383];?></td>
        <td><?=$isi[384];?></td>
        <td><?=$isi[385];?></td>
        <td><?=$isi[386];?></td>
        <td><?=$isi[387];?></td>
        <td><?=$isi[388];?></td>
        <td><?=$isi[389];?></td>
        <td><?=$isi[390];?></td>
        <td><?=$isi[391];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>29</strong></div></td>
        <td><strong>Pelayanan Rawat Darurat</strong></td>
        <td><?=$isi[392];?></td>
        <td><?=$isi[393];?></td>
        <td><?=$isi[394];?></td>
        <td><?=$isi[395];?></td>
        <td><?=$isi[396];?></td>
        <td><?=$isi[397];?></td>
        <td><?=$isi[398];?></td>
        <td><?=$isi[399];?></td>
        <td><?=$isi[400];?></td>
        <td><?=$isi[401];?></td>
        <td><?=$isi[402];?></td>
        <td><?=$isi[403];?></td>
        <td><?=$isi[404];?></td>
        <td><?=$isi[405];?></td>
      </tr>
	  <?php
	  $sub1 = $isi[0] + $isi[14] + $isi[28] + $isi[42] + $isi[56] + $isi[70] + $isi[84]; //bln selesai
	  $sub2 = $isi[1] + $isi[15] + $isi[29] + $isi[43] + $isi[57] + $isi[71] + $isi[85]; //bln selesai
	  $sub3 = $isi[2] + $isi[16] + $isi[30] + $isi[44] + $isi[58] + $isi[72] + $isi[86]; //bln selesai
	  $sub4 = $isi[3] + $isi[17] + $isi[31] + $isi[45] + $isi[59] + $isi[73] + $isi[87]; //bln selesai
	  $sub5 = $isi[4] + $isi[18] + $isi[32] + $isi[46] + $isi[60] + $isi[74] + $isi[88]; //bln selesai
	  $sub6 = $isi[5] + $isi[19] + $isi[33] + $isi[47] + $isi[61] + $isi[75] + $isi[89]; //bln selesai
	  $sub7 = $isi[6] + $isi[20] + $isi[34] + $isi[48] + $isi[62] + $isi[76] + $isi[90]; //bln selesai
	  $sub8 = $isi[7] + $isi[21] + $isi[35] + $isi[49] + $isi[63] + $isi[77] + $isi[91]; //bln selesai
	  $sub9 = $isi[8] + $isi[22] + $isi[36] + $isi[50] + $isi[64] + $isi[78] + $isi[92]; //bln selesai
	  $sub10 = $isi[9] + $isi[23] + $isi[37] + $isi[51] + $isi[65] + $isi[79] + $isi[93]; //bln selesai
	  $sub11 = $isi[10] + $isi[24] + $isi[38] + $isi[52] + $isi[66] + $isi[80] + $isi[94]; //bln selesai
	  $sub12 = $isi[11] + $isi[25] + $isi[39] + $isi[53] + $isi[67] + $isi[81] + $isi[95]; //bln selesai
	  $sub13 = $isi[12] + $isi[26] + $isi[40] + $isi[54] + $isi[68] + $isi[82] + $isi[96]; //bln selesai
	  $sub14 = $isi[13] + $isi[27] + $isi[41] + $isi[55] + $isi[69] + $isi[83] + $isi[97]; //bln selesai
	  ?>
      <tr>
        <td><div align="center"><strong>77</strong></div></td>
        <td><strong>SUB TOTAL</strong></td>
        <td bgcolor="#CCCCCC"><?=$isi[406];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[407];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[408];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[409];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[410];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[411];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[412];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[413];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[414];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[415];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[416];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[417];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[418];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[419];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>88</strong></div></td>
        <td><strong>Perinatologi</strong></td>
        <td><?=$isi[420];?></td>
        <td><?=$isi[421];?></td>
        <td><?=$isi[422];?></td>
        <td><?=$isi[423];?></td>
        <td><?=$isi[424];?></td>
        <td><?=$isi[425];?></td>
        <td><?=$isi[426];?></td>
        <td><?=$isi[427];?></td>
        <td><?=$isi[428];?></td>
        <td><?=$isi[429];?></td>
        <td><?=$isi[430];?></td>
        <td><?=$isi[431];?></td>
        <td><?=$isi[432];?></td>
        <td><?=$isi[433];?></td>
      </tr>
      <tr>
        <td><div align="center"><strong>99</strong></div></td>
        <td><strong>T O T A L</strong></td>
        <td bgcolor="#CCCCCC"><?=$isi[434];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[435];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[436];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[437];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[438];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[439];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[440];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[441];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[442];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[443];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[444];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[445];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[446];?></td>
        <td bgcolor="#CCCCCC"><?=$isi[447];?></td>
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

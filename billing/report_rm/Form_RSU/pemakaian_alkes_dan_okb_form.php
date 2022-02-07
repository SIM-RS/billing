<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT pl.tgl as tgl2, mt.nama as nama_tindakan,  p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls, p.gol_darah as gol_darah2, u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_tindakan t ON t.pelayanan_id=pl.id
LEFT JOIN b_ms_tindakan mt ON mt.id=t.id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id

WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />

        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>PEMAKAIAN ALKES DAN OBAT KAMAR BEDAH</title>
</head>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}

.tblkembali{
	background-image:url(../../icon/back16.png);
	background-repeat:no-repeat;
	background-position:left;
	background-color:#CDD3D3;
	border:2px outset #000000;
	padding-left:15px;
}

        </style>
<title>resume kep</title>
<?
//include "setting2.php";
?>

<body>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div id="tampil_input" align="center" style="display:none">
<form id="form1" name="form1" action="pemakaian_alkes_dan_okb_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="950" height="868" border="0" style="font:12px tahoma;">
  <tr>
    <td colspan="5" style="font:bold 16px tahoma;"><div align="right">PEMAKAIAN ALKES DAN OBAT KAMAR BEDAH </div></td>
  </tr>
  <tr>
    <td colspan="5" style="font: 12px tahoma;"><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000">
      <tr>
        <td width="124">TANGGAL</td>
        <td width="173">: <?=tglSQL($dP['tgl2']);?></td>
        <td>Nama Pasien</td>
        <td>:
          <?=$dP['nama'];?></td>
      </tr>
      <tr>
        <td>TINDAKAN</td>
        <td>: <?=$dP['nama_tindakan'];?></td>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?>        </td>
      </tr>
      <tr>
        <td>DR. OPERATOR </td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>DR. ANASTESI </td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="5" style="font:bold 16px tahoma;">&nbsp;</td>
  </tr>
  <tr>
    <td width="303" valign="top" style="font:12px tahoma;"><table width="312" border="1" style="border-collapse:collapse;">
        <tr>
          <td width="26"><div align="center"><strong>NO.</strong></div></td>
          <td width="175"><div align="center"><strong>NAMA ALKES </strong></div></td>
          <td width="68"><div align="center"><strong>JUMLAH</strong></div></td>
        </tr>
        <tr>
          <td><div align="center">1</div></td>
          <td> GAMMEX 6/6,5/7/7,5/8 </td>
          <td><input name="gammex" type="text" id="gammex" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">2</div></td>
          <td>PROFEEL ORTHO 6/6,5/7/7,5/8 </td>
          <td><input name="proffel_or" type="text" id="proffel_or" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">3</div></td>
          <td>PROFEEL LP 6,5/7 </td>
          <td><input name="proffel_lp" type="text" id="proffel_lp" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">4</div></td>
          <td>TRANSOFIK</td>
          <td><input name="transofix" type="text" id="transofix" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">5</div></td>
          <td>BETHADINE
            <label>
            <input name="be" type="text" id="be" size="7" />
            cc</label></td>
          <td><input name="bhetadine" type="text" id="bhetadine" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">6</div></td>
          <td>ALKOHOL 
            <input name="al" type="text" id="al" size="7" /> 
            cc </td>
          <td><input name="alkohol" type="text" id="alkohol" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">7</div></td>
          <td>NEEDLE NO 
            <input name="ne" type="text" id="ne" size="7" /></td>
          <td><input name="needle" type="text" id="needle" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">8</div></td>
          <td>NETRAL PLATE </td>
          <td><input name="netral" type="text" id="netral" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">9</div></td>
          <td>BACTIGRAS/SUPRATULE/DARYATULE</td>
          <td><input name="bactigras" type="text" id="bactigras" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">10</div></td>
          <td>MERSILK</td>
          <td><input name="mersilk" type="text" id="mersilk" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">11</div></td>
          <td>POLISORB 
            <input name="po" type="text" id="po" size="7" /></td>
          <td><input name="polisorb" type="text" id="polisorb" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">12</div></td>
          <td>ULTRASOLB</td>
          <td><input name="ultra" type="text" id="ultra" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">13</div></td>
          <td>SUPRASOB C </td>
          <td><input name="supra" type="text" id="supra" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">14</div></td>
          <td>BISTURI NO 
            <input name="bi" type="text" id="bi" size="7" /></td>
          <td><input name="bisturi" type="text" id="bisturi" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">15</div></td>
          <td>CHROMIC</td>
          <td><input name="chromic" type="text" id="chromic" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">16</div></td>
          <td>MONOSYN</td>
          <td><input name="monosyn" type="text" id="monosyn" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">17</div></td>
          <td>VICRYL 
            <input name="vi" type="text" id="vi" size="7" /></td>
          <td><input name="vircly" type="text" id="vircly" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">18</div></td>
          <td>PLAIN CUT GED </td>
          <td><input name="plain" type="text" id="plain" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">19</div></td>
          <td>SILKAM 
            <input name="si" type="text" id="si" size="7" /></td>
          <td><input name="silkam" type="text" id="silkam" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">20</div></td>
          <td>PREMILINE/PROLAINE/SURGIPRO</td>
          <td><input name="premil" type="text" id="premil" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">21</div></td>
          <td>MONOCRYL 
            <input name="mo" type="text" id="mo" size="7" /></td>
          <td><input name="monocryl" type="text" id="monocryl" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">22</div></td>
          <td>PDS 2 
            <input name="pd" type="text" id="pd" size="7" /></td>
          <td><input name="pds" type="text" id="pds" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">23</div></td>
          <td>SECUREG 
            <input name="se" type="text" id="se" size="7" /></td>
          <td><input name="secureg" type="text" id="secureg" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">24</div></td>
          <td>KASSA 7,5 X 7,5 </td>
          <td><input name="kassa7" type="text" id="kassa7" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">25</div></td>
          <td>KASSA X RAY 10 X 10 </td>
          <td><input name="kassax" type="text" id="kassax" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">26</div></td>
          <td>KASSA 6 X 6 </td>
          <td><input name="kassa6" type="text" id="kassa6" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">27</div></td>
          <td>KASSA LAPARATOMY </td>
          <td><input name="kassal" type="text" id="kassal" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">28</div></td>
          <td>UNDER PAD </td>
          <td><input name="under" type="text" id="under" size="7" /></td>
        </tr>
      </table></td>
    <td width="1" valign="top" style="font:bold 16px tahoma;">&nbsp;</td>
    <td width="309" valign="top" style="font: 12px tahoma;"><table width="309" border="1"  style="border-collapse:collapse;">
        <tr>
          <td><div align="center"><strong>NO.</strong></div></td>
          <td><div align="center"><strong>NAMA ALKES </strong></div></td>
          <td><div align="center"><strong>JUMLAH</strong></div></td>
        </tr>
        <tr>
          <td width="27"><div align="center">29</div></td>
          <td width="198">PEMBALUT WANITA 
            <input name="pe" type="text" id="pe" size="7" /></td>
          <td width="62"><input name="pembalut" type="text" id="pembalut" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">30</div></td>
          <td>MASKER GOOGLE</td>
          <td><input name="masker" type="text" id="masker" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">31</div></td>
          <td>TEGADERM 
            <input name="te" type="text" id="te" size="7" /></td>
          <td><input name="tega" type="text" id="tega" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">32</div></td>
          <td>PAPER GREEN </td>
          <td><input name="paper" type="text" id="paper" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">33</div></td>
          <td>FORMALIN</td>
          <td><input name="formalin" type="text" id="formalin" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">34</div></td>
          <td>AQUABIDEST 1000cc </td>
          <td><input name="aqua" type="text" id="aqua" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">35</div></td>
          <td>ALKAZYM</td>
          <td><input name="alkaz" type="text" id="alkaz" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">36</div></td>
          <td>HYPAFIX</td>
          <td><input name="hypafix" type="text" id="hypafix" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">37</div></td>
          <td>BAROVAC PS/PP </td>
          <td><input name="barovac" type="text" id="barovac" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">38</div></td>
          <td>URINE BAG </td>
          <td><input name="urine" type="text" id="urine" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">39</div></td>
          <td>FOLEY CATHETER </td>
          <td><input name="foley" type="text" id="foley" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">40</div></td>
          <td>NGT</td>
          <td><input name="ngt" type="text" id="ngt" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">41</div></td>
          <td>SYRINGE 
            <input name="sy" type="text" id="sy" size="7" /></td>
          <td><input name="syringe" type="text" id="syringe" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">42</div></td>
          <td>CATHETER TIP </td>
          <td><input name="cat" type="text" id="cat" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">43</div></td>
          <td>GUARDIX SOL </td>
          <td><input name="gua" type="text" id="gua" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">44</div></td>
          <td>GELITA SPON </td>
          <td><input name="gel" type="text" id="gel" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">45</div></td>
          <td>WI</td>
          <td><input name="wi" type="text" id="wi" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">46</div></td>
          <td>NaCL</td>
          <td><input name="na" type="text" id="na" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">47</div></td>
          <td>POLIGYP</td>
          <td><input name="poli" type="text" id="poli" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">48</div></td>
          <td>POLIYBAN</td>
          <td><input name="poliy" type="text" id="poliy" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">49</div></td>
          <td>TENSOCREPE/MEDICREPE</td>
          <td><input name="tenso" type="text" id="tenso" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">50</div></td>
          <td>CONFORMING</td>
          <td><input name="confo" type="text" id="confo" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">51</div></td>
          <td>MICROSHIELD</td>
          <td><input name="micro" type="text" id="micro" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">52</div></td>
          <td>BETADINE</td>
          <td><input name="beta" type="text" id="beta" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">53</div></td>
          <td>FROMALINE</td>
          <td><input name="formal" type="text" id="formal" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">54</div></td>
          <td>CIDEX</td>
          <td><input name="cidex" type="text" id="cidex" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">55</div></td>
          <td>PRASEPT</td>
          <td><input name="pra" type="text" id="pra" size="7" /></td>
        </tr>
        <tr>
          <td height="18"><div align="center">56</div></td>
          <td>SUCTION CATHETER </td>
          <td><input name="suction" type="text" id="suction" size="7" /></td>
        </tr>
      </table></td>
    <td width="2" style="font:bold 16px tahoma;">&nbsp;</td>
    <td width="288" valign="top" style="font:12px tahoma;"><table width="288" border="1" style="border-collapse:collapse;">
        <tr>
          <td><div align="center"><strong>NO.</strong></div></td>
          <td><div align="center"><strong>NAMA ALKES </strong></div></td>
          <td><div align="center"><strong>JUMLAH</strong></div></td>
        </tr>
        <tr>
          <td width="27"><div align="center">57</div></td>
          <td width="177">HOGI GOWN </td>
          <td width="62"><input name="hogi" type="text" id="hogi" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">58</div></td>
          <td>T-SCRUB</td>
          <td><input name="tsc" type="text" id="tsc" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">59</div></td>
          <td>FACE MASK </td>
          <td><input name="face" type="text" id="face" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">60</div></td>
          <td>MASKER KACA </td>
          <td><input name="maskerk" type="text" id="maskerk" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">61</div></td>
          <td>SURGICAL HAT </td>
          <td><input name="surgical" type="text" id="surgical" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">62</div></td>
          <td>SENSI GLOVE </td>
          <td><input name="sensi" type="text" id="sensi" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">63</div></td>
          <td>XYLOCAINE GEL / INSTILLAGEL </td>
          <td><input name="xylo" type="text" id="xylo" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">64</div></td>
          <td>UROGRAD</td>
          <td><input name="urog" type="text" id="urog" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">65</div></td>
          <td>DISK DVD-ROOM </td>
          <td><input name="disk" type="text" id="disk" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">66</div></td>
          <td>H2O2</td>
          <td><input name="h2o2" type="text" id="h2o2" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">67</div></td>
          <td>BOCAL PA </td>
          <td><input name="bocal" type="text" id="bocal" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">68</div></td>
          <td>RL</td>
          <td><input name="rl" type="text" id="rl" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">69</div></td>
          <td>SURGIWEAR PATTIES </td>
          <td><input name="surgi" type="text" id="surgi" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">70</div></td>
          <td>BONE WAX </td>
          <td><input name="bone" type="text" id="bone" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">71</div></td>
          <td>MICROSCOP DRAPE </td>
          <td><input name="micros" type="text" id="micros" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">72</div></td>
          <td>SURGICEL</td>
          <td><input name="surgicel" type="text" id="surgicel" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">73</div></td>
          <td>LINA PEN </td>
          <td><input name="lina" type="text" id="lina" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">74</div></td>
          <td>EXTERNAL DRAIN </td>
          <td><input name="exter" type="text" id="exter" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">75</div></td>
          <td>SUCTION CONECTING TUBE </td>
          <td><input name="suct" type="text" id="suct" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">76</div></td>
          <td>BAG SUCTION DISPOSIBLE </td>
          <td><input name="bag" type="text" id="bag" size="7" /></td>
        </tr>
        <tr>
          <td><div align="center">77</div></td>
          <td>WHITE APRON </td>
          <td><input name="white" type="text" id="white" size="7" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5" style="border:1px solid #000000;"><table width="800" border="0" align="center">
      <tr>
        <td width="790"></td>
      </tr>
      <tr>
        <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
          &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
      </tr>
      </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
					  <input type="button" id="btnkembali" name="btnkembali" value="Kembali" onclick="kembali();" class="tblkembali"/>
                    </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>
</div>
</body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('nama')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
            //var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('diagnosa1').val(a.cellsGetValue(a.getSelRow(),3));
			//$('#id').val(sisip[0]);
			//$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			//$('#act').val('edit');
			
					
            var sisip = a.getRowId(a.getSelRow()).split('|');
			$('#id').val(sisip[0]);
			$('#gammex').val(sisip[1]);
			$('#proffel_or').val(sisip[2]);
			$('#proffel_lp').val(sisip[3]);
			$('#transofix').val(sisip[4]);
			$('#bhetadine').val(sisip[5]);
			$('#alkohol').val(sisip[6]);
			$('#needle').val(sisip[7]);
			$('#netral').val(sisip[8]);
			$('#bactigras').val(sisip[9]);
			$('#mersilk').val(sisip[10]);
			$('#polisorb').val(sisip[11]);
			$('#ultra').val(sisip[12]);
			$('#supra').val(sisip[13]);
			$('#bisturi').val(sisip[14]);
			$('#chromic').val(sisip[15]);
			$('#monosyn').val(sisip[16]);
			$('#vircly').val(sisip[17]);
			$('#plain').val(sisip[18]);
			$('#silkam').val(sisip[19]);
			$('#premil').val(sisip[20]);
			$('#monocryl').val(sisip[21]);
			$('#pds').val(sisip[22]);
			$('#secureg').val(sisip[23]);
			$('#kassa7').val(sisip[24]);
			$('#kassax').val(sisip[25]);
			$('#kassa6').val(sisip[26]);
			$('#kassal').val(sisip[27]);
			$('#under').val(sisip[28]);
			$('#pembalut').val(sisip[29]);
			$('#masker').val(sisip[30]);
			$('#tega').val(sisip[31]);
			$('#paper').val(sisip[32]);
			$('#formalin').val(sisip[33]);
			$('#aqua').val(sisip[34]);
			$('#alkaz').val(sisip[35]);
			$('#hypafix').val(sisip[36]);
			$('#barovac').val(sisip[37]);
			$('#urine').val(sisip[38]);
			$('#foley').val(sisip[39]);
			$('#ngt').val(sisip[40]);
			$('#syringe').val(sisip[41]);
			$('#cat').val(sisip[42]);
			$('#gua').val(sisip[43]);
			$('#gel').val(sisip[44]);
			$('#wi').val(sisip[45]);
			$('#na').val(sisip[46]);
			$('#poli').val(sisip[47]);
			$('#poliy').val(sisip[48]);
			$('#tenso').val(sisip[49]);
			$('#confo').val(sisip[50]);
			$('#micro').val(sisip[51]);
			$('#beta').val(sisip[52]);
			$('#formal').val(sisip[53]);
			$('#cidex').val(sisip[54]);
			$('#pra').val(sisip[55]);
			$('#suction').val(sisip[56]);
			$('#hogi').val(sisip[57]);
			$('#tsc').val(sisip[58]);
			$('#face').val(sisip[59]);
			$('#maskerk').val(sisip[60]);
			$('#surgical').val(sisip[61]);
			$('#sensi').val(sisip[62]);
			$('#xylo').val(sisip[63]);
			$('#urog').val(sisip[64]);
			$('#disk').val(sisip[65]);
			$('#h2o2').val(sisip[66]);
			$('#bocal').val(sisip[67]);
			$('#rl').val(sisip[68]);
			$('#surgi').val(sisip[69]);
			$('#bone').val(sisip[70]);
			$('#micros').val(sisip[71]);
			$('#surgicel').val(sisip[72]);
			$('#lina').val(sisip[73]);
			$('#exter').val(sisip[74]);
			$('#suct').val(sisip[75]);
			$('#bag').val(sisip[76]);
			$('#white').val(sisip[77]);
			$('#be').val(sisip[78]);
			$('#al').val(sisip[79]);
			$('#ne').val(sisip[80]);
			$('#po').val(sisip[81]);
			$('#bi').val(sisip[82]);
			$('#vi').val(sisip[83]);
			$('#si').val(sisip[84]);
			$('#mo').val(sisip[85]);
			$('#pd').val(sisip[86]);
			$('#se').val(sisip[87]);
			$('#pe').val(sisip[88]);
			$('#te').val(sisip[89]);
			$('#sy').val(sisip[90]);

			 $('#act').val('edit');
			 
			 
			 //$('#kronologis').val(sisip[2]);
			 //$('#tindakan').val(sisip[13]);
			 
            fSetValue(window,p);
			
        }

        function hapus(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
				}

        }

        function batal(){
			//resetF();
			$('#tampil_input').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("pemakaian_alkes_dan_okb_form.php");
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pemakaian_alkes_dan_okb_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pamakaian Alkes dan Obat Kamar Bedah");
        a.setColHeader("NO,NAMA PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,,,");
        a.setColWidth("20,300,150,120");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pemakaian_alkes_dan_okb_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
			
			}
		
		
		/*function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			
			else
			{	
				window.open("14.checklisttrasfusi.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			}
			
		}*/
		
		
		function cetak(){
		 var id = document.getElementById("id").value;
		 if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("pemakaian_alkes_dan_okb.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		
		function kembali(){
		window.close();                                                // Closes the new window                                           

		}
		
		
/*function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		var list4 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		var list4 = document.form1.elements['radio[1]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}
	
	function centang3(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[2]'];
		var list2 = document.form1.elements['radio[2]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang4(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[3]'];
		var list2 = document.form1.elements['radio[3]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang5(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[4]'];
		var list2 = document.form1.elements['radio[4]'];
		var list3 = document.form1.elements['radio[4]'];
		var list4 = document.form1.elements['radio[4]'];
		var list5 = document.form1.elements['radio[4]'];
		var list6 = document.form1.elements['radio[4]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
		if ( list5.length > 4 )
		{
		 for (i = 4; i < list5.length; i++)
			{
			  if (list5[i].value==list[4])
			  {
			   list5[i].checked = true;
			  }
		  }
		}
		if ( list6.length > 5 )
		{
		 for (i = 5; i < list6.length; i++)
			{
			  if (list6[i].value==list[5])
			  {
			   list6[i].checked = true;
			  }
		  }
		}
	}
	
	function centang6(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[5]'];
		var list2 = document.form1.elements['radio[5]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang7(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[6]'];
		var list2 = document.form1.elements['radio[6]'];
		var list3 = document.form1.elements['radio[6]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
	
	function centang8(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[7]'];
		var list2 = document.form1.elements['radio[7]'];
		var list3 = document.form1.elements['radio[7]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
	
	function centang9(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[8]'];
		var list2 = document.form1.elements['radio[8]'];
		var list3 = document.form1.elements['radio[8]'];
		var list4 = document.form1.elements['radio[8]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}*/
	
	function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}

/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
	
	
	
 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
				jam();
            }
            el.type = 'text';
            el.className = 'jam';
			el.size = 10;
            el.value = '<?=date('H:i:s')?>';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'td[]';
                el.id = 'td[]';
            }else{
                el = document.createElement('<input name="td[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'nadi_t1[]';
                el.id = 'nadi_t1[]';
            }else{
                el = document.createElement('<input name="nadi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'respirasi_t1[]';
                el.id = 'respirasi_t1[]';
            }else{
                el = document.createElement('<input name="respirasi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'suhu_t1[]';
                el.id = 'suhu_t1[]';
            }else{
                el = document.createElement('<input name="suhu_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'heparin[]';
                el.id = 'heparin[]';
            }else{
                el = document.createElement('<input name="heparin[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tmp[]';
                el.id = 'tmp[]';
            }else{
                el = document.createElement('<input name="tmp[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ap[]';
                el.id = 'ap[]';
            }else{
                el = document.createElement('<input name="ap[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'qb[]';
                el.id = 'qb[]';
            }else{
                el = document.createElement('<input name="qb[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufr[]';
                el.id = 'ufr[]';
            }else{
                el = document.createElement('<input name="ufr[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufg[]';
                el.id = 'ufg[]';
            }else{
                el = document.createElement('<input name="ufg[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan[]';
                el.id = 'keterangan[]';
            }else{
                el = document.createElement('<input name="keterangan[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }

function addRowToTable2()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tgl');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tgl[]';
                el.id = 'tgl[]';
				
            }else{
                el = document.createElement('<input name="tgl[]"/>');
            }
            el.type = 'text';
            el.className = 'tgl';
            el.value = '';
			el.size = '15';
			//el.onclick = 'gfPop.fPopCalendar(document.getElementById("tgl2"),depRange)';
			

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
			//var td3=x.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'hari[]';
                el.id = 'hari[]';
            }else{
                //el = document.createElement('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
				el = document.createElement('<input name="hari[]"/>');
            }
            el.type = 'select';
            el.value = '';
			el.size = 15;
			el.select('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
			
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 15;

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'dokter[]';
                el.id = 'dokter[]';
            }else{
                el = document.createElement('<input name="dokter[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 30;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            

// right cell
            

// right cell
            
			
// right cell
            
			
// right cell
            

// right cell
            
			
// right cell
            

// right cell
            
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
   tanggalan();
    }
function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tgl');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 3)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                //tds[0].innerHTML=i-2;
            }
        }
    }

/*tampil = function(cek) 
{
  if (cek.checked) 
  {
    $('#status').slideDown(600);
  } 
  else 
  {
    $('#status').slideUp(600);
  }
}*/
/*var appended = $('<div />').text("You're appendin'!");
appended.id = 'appended';*/
$('input:radio[name="radio[0]"]').change(
    function tampil(){
        if ($(this).val() == 3) {
            $('#status').slideDown(600);
        }
        else {
            $('#status').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('_diet').value="";
        }
		
    });
	
$('input:radio[name="radio[0]"]').change(
    function tampil2(){
        if ($(this).val() == 4) {
            $('#status2').slideDown(600);
        }
        else {
            $('#status2').slideUp(600);
			document.getElementById('_batas').value="";
        }
    });
	
$('input:radio[name="radio[2]"]').change(
    function tampil3(){
        if ($(this).val() == '2') {
            $('#status3').slideDown(600);
        }
        else {
            $('#status3').slideUp(600);
        }
    });
	
$('input:radio[name="radio[6]"]').change(
    function tampil4(){
        if ($(this).val() == '3') {
            $('#status4').slideDown(600);
        }
        else {
            $('#status4').slideUp(600);
        }
    });
	
$('input:radio[name="radio[8]"]').change(
    function tampil5(){
        if ($(this).val() == '4') {
            $('#status5').slideDown(600);
        }
        else {
            $('#status5').slideUp(600);
        }
    });

/*function kejadian()
		{
			var nutrisi = document.getElementById('nutrisi').value;
			if(nutrisi=="Diet Khusus")
			{
				$('#status').slideDown(600);
				
			}
			else
			{
				$('#status').slideUp(600);
				$('#status').checked(false);
				document.getElementById('nutrisi').value="";
			}
			//document.getElementById('act').value = "edit";
			
		}
*/

    </script>
    <script>
var idrow = 3;

function tambahrow(){
    var x=document.getElementById('datatable').insertRow(idrow);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	var td6=x.insertCell(5);
	var td7=x.insertCell(6);
	var td8=x.insertCell(7);
	var td9=x.insertCell(8);
	var td10=x.insertCell(9);
	var td11=x.insertCell(10);
	var td12=x.insertCell(11);
	
	
    td1.innerHTML="<input type='text' class='jam' size='10' name='jam[]' id='jam"+idx+"'>";jam();
	td2.innerHTML="<input type='text' id='td[]' name='td[]' size ='5'>";
    td3.innerHTML="<input type='text' id='nadi_t1[]' name='nadi_t1[]'  size='5'>";
    td4.innerHTML="<input type='text' id='respirasi_t1[]' name='respirasi_t1[]'  size='5'>";	
	td5.innerHTML="<input type='text' id='suhu_t1[]' name='suhu_t1[]'  size='5'>";
	td6.innerHTML="<input type='text' id='heparin[]' name='heparin[]'  size='5'>";
	td7.innerHTML="<input type='text' id='tmp[]' name='tmp[]'  size='5'>";
	td8.innerHTML="<input type='text' id='ap[]' name='ap[]'  size='5'>";
	td9.innerHTML="<input type='text' id='qb[]' name='qb[]'  size='5'>";
	td10.innerHTML="<input type='text' id='ufr[]' name='ufr[]'  size='5'>";
	td11.innerHTML="<input type='text' id='ufg[]' name='ufg[]'  size='5'>";
	td12.innerHTML="<input type='text' id='keterangan[]' name='keterangan[]'  size='10'>";
    idrow++;
}

function del(){
    if(idrow>3){
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script>
var idrow2 = 3;

function tambahrow2(){
    var x=document.getElementById('datatable2').insertRow(idrow2);
	var idx2 = $('.jam2 tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
	var td3=x.insertCell(2);
 
    td1.innerHTML="<input type='text' class='jam2' size='10' name='jam2[]' id='jam2"+idx+"'>";jam2();
	td2.innerHTML="<textarea id='saran[]' name='saran[]' rows ='3' cols='70'>";
	td3.innerHTML="";
    idrow2++;
}

function del(){
    if(idrow>3){
        var y=document.getElementById('datatable2').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script type="text/javascript">
function text0() {
document.getElementById("td_tidur2").value = "" + "" + document.getElementById("td_tidur").value + "\n" }
function text1() {
document.getElementById("duduk2").value = "" + "" + document.getElementById("duduk").value + "\n" }
function text2() {
document.getElementById("nadi2").value = "" + "" + document.getElementById("nadi").value + "\n" }
function text3() {
document.getElementById("respirasi2").value = "" + "" + document.getElementById("respirasi").value + "\n" }
function text4() {
document.getElementById("suhu2").value = "" + "" + document.getElementById("suhu").value + "\n" }
function text5() {
document.getElementById("keluhan2").value = "" + "" + document.getElementById("keluhan").value + "\n" }
function text6() {
document.getElementById("perawat11").value = "" + "" + document.getElementById("perawat1").value + "\n" }
function text7() {
document.getElementById("perawat22").value = "" + "" + document.getElementById("perawat2").value + "\n" }
</script>

<script>
$(document).ready(function(){
    var inpA = "input[rel=Ajumlah]";
    var inpB = "input[rel=Bjumlah]";
    
    $(inpA).bind('keyup',function() {
        var avalA=0;
        var bVal = parseInt($('#jumlah2').val(),10);
        $(inpA).each(function() {
            if(this.value !='') avalA += parseInt(this.value,10);
        });
        $('#jumlah').val(avalA);
        $('#total').val(avalA - bVal);
        console.log('Value avalA: ' + avalA);
    });
    
    $(inpB).bind('keyup',function() {
        var avalB=0;
        var aVal = parseInt($('#jumlah').val(),10);
        $(inpB).each(function() {
            if(this.value !='') avalB += parseInt(this.value,10);
        });
        $('#jumlah2').val(avalB);
        $('#total').val(aVal - avalB);
        console.log('Value avalB: ' + avalB);
    });
});

function enable_text(status)
{
status=!status;
document.form1.istirahat.disabled = status;
document.form1.tgl_mulai.disabled = status;
document.form1.tgl_akhir.disabled = status;
}
function enable_text2(status)
{
status=!status;
document.form1.inap.disabled = status;
document.form1.tgl_mulai2.disabled = status;
document.form1.tgl_akhir2.disabled = status;
}
function enable_text3(status)
{
status=!status;
document.form1.tgl_per.disabled = status;
}

</script>
</html>

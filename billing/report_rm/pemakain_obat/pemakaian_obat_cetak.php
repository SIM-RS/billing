<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php
$dG=mysql_fetch_array(mysql_query("select a.*,b.nama as nama2 
									from b_ms_pemakain_obat a 
									LEFT JOIN b_ms_pegawai b ON b.id=a.dokter  
									where a.id='$_REQUEST[id]'"));
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
<title>PEMAKAIAN OBAT</title>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
</head>
<?
//include "setting.php";
?>
<style>

.gb{
	border-bottom:1px solid #000000;
}
</style>
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
<div id="form_in" style="display:block;">
<form name="form1" id="form1" action="pemakaian_obat_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="932" height="226" border="0" style="font:12px tahoma;">
  <tr>
    <td colspan="5" valign="middle"><img src="lambang.png" width="278" height="30" /></td>
    <td colspan="5" rowspan="2"><table width="350" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>No. MR</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" valign="middle"><span style="font:bold 15px tahoma;">PEMAKAIAN OBAT/ALKES ANASTESI</span></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="102" >Tanggal</td>
    <td >:</td>
    <td colspan="3" ><label for="textfield"></label>
      <?=tglSQL($dG['tgl']);?></td>
    <td colspan="5" >&nbsp;</td>
  </tr>
  <tr>
    <td >Dokter</td>
    <td >:</td>
    <td colspan="6" ><?=$dG['nama2'];?></td>
    <td width="90" >&nbsp;</td>
    <td width="2" >&nbsp;</td>
  </tr>
  <tr>
    <td >Jenis Operasi</td>
    <td >:</td>
    <td colspan="5" ><label for="textfield"></label>
      <?=$dG['jenis_operasi'];?></td>
    <td width="90" >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="7" >&nbsp;</td>
    <td width="229" >&nbsp;</td>
    <td width="143" >&nbsp;</td>
    <td width="133" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="10">
  <form>
    <table width="919" height="202" align="center" cellspacing="0" >
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="37" />
      <tr height="20">
        <td width="423" height="20"><table width="500" border="1" style=" border-collapse:collapse">
          <tr>
            <td width="40" align="center"><strong>NO</strong></td>
            <td width="300" align="center"><strong>MEDICINE</strong></td>
            <td width="138" align="center"><strong>PEMAKAIAN</strong></td>
          </tr>
          <tr>
            <td align="center">1</td>
            <td>(SC) Methergin/Syntocinon</td>
            <td><label for="textfield2"></label>
              <?=$dG['a'];?></td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td>(Sp) Mafcain Heavy/Buvanest</td>
            <td><label for="textfield5"></label>
              <?=$dG['b'];?></td>
          </tr>
          <tr>
            <td align="center">3</td>
            <td>Adona 50 Mg/Dicynon/Transamin</td>
            <td><label for="textfield6"></label>
              <?=$dG['c'];?></td>
          </tr>
          <tr>
            <td align="center">4</td>
            <td>Atropin Sulfat/Prostigmin/Efedrin</td>
            <td><label for="textfield7"></label>
              <?=$dG['d'];?></td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td>Oradexon/Kalmetasan</td>
            <td><label for="textfield8"></label>
              <?=$dG['e'];?></td>
          </tr>
          <tr>
            <td align="center">6</td>
            <td>Dormicum/Midazolam</td>
            <td><label for="textfield9"></label>
              <?=$dG['f'];?></td>
          </tr>
          <tr>
            <td align="center">7</td>
            <td>Fentanyl/Sufenta/Pethidine/Morphin</td>
            <td><label for="textfield10"></label>
              <?=$dG['g'];?></td>
          </tr>
          <tr>
            <td align="center">8</td>
            <td>Fima Haes/Haemacel</td>
            <td><label for="textfield11"></label>
              <?=$dG['h'];?></td>
          </tr>
          <tr>
            <td align="center">9</td>
            <td>Ketalar</td>
            <td><label for="textfield12"></label>
              <?=$dG['i'];?></td>
          </tr>
          <tr>
            <td align="center">10</td>
            <td>Lidocain/Catapres</td>
            <td><label for="textfield13"></label>
              <?=$dG['j'];?></td>
          </tr>
          <tr>
            <td align="center">11</td>
            <td>Nad 25 Ml/100 Ml/250 Ml/500 Ml</td>
            <td><label for="textfield14"></label>
              <?=$dG['k'];?></td>
          </tr>
          <tr>
            <td align="center">12</td>
            <td>Narfoz 4 Mg/Narfoz 8 Mg/ Primperan</td>
            <td><label for="textfield15"></label>
              <?=$dG['l'];?></td>
          </tr>
          <tr>
            <td align="center">13</td>
            <td>Novalgin/Remopain/Tramal</td>
            <td><label for="textfield16"></label>
              <?=$dG['m'];?></td>
          </tr>
          <tr>
            <td align="center">14</td>
            <td>Rantin/Ranitidine</td>
            <td><label for="textfield17"></label>
              <?=$dG['n'];?></td>
          </tr>
          <tr>
            <td align="center">15</td>
            <td>Recofol/Pentothal</td>
            <td><label for="textfield18"></label>
              <?=$dG['o'];?></td>
          </tr>
          <tr>
            <td align="center">16</td>
            <td>Rl/Asering/Dex 5%/rd</td>
            <td><label for="textfield19"></label>
              <?=$dG['p'];?></td>
          </tr>
          <tr>
            <td align="center">17</td>
            <td>Xylocain Inj/Adrenalin</td>
            <td><label for="textfield20"></label>
              <?=$dG['q'];?></td>
          </tr>
          <tr>
            <td align="center">18</td>
            <td>Stesolid 5 Mg/10 Mg/Dumin 125 Mg/250 Rectal</td>
            <td><label for="textfield21"></label>
              <?=$dG['r'];?></td>
          </tr>
          <tr>
            <td align="center">19</td>
            <td>Tracrium/Esmeron/Roculax</td>
            <td><label for="textfield22"></label>
              <?=$dG['s'];?></td>
          </tr>
          <tr>
            <td align="center">20</td>
            <td>Vit. C/Vit. K</td>
            <td><label for="textfield23"></label>
              <?=$dG['t'];?></td>
          </tr>
          <tr>
            <td align="center">21</td>
            <td>Voltaren Supp/Pronalges Supp/Felden Supp</td>
            <td><label for="textfield24"></label>
              <?=$dG['u'];?></td>
          </tr>
        </table></td>
        <td width="13">&nbsp;</td>
        <td width="475" colspan="7" valign="top"><table width="500" border="1" align="right" style=" border-collapse:collapse">
          <tr>
            <td width="40" align="center"><strong>NO</strong></td>
            <td width="300" align="center"><strong>MEDICINE</strong></td>
            <td width="138" align="center"><strong>PEMAKAIAN</strong></td>
          </tr>
          <tr>
            <td align="center">1</td>
            <td>Spuit 1/3/5/10/20/50</td>
            <td><label for="textfield3"></label>
              <?=$dG['v'];?></td>
          </tr>
          <tr>
            <td align="center">2</td>
            <td>Ett 6,5/7/7,5</td>
            <td><label for="textfield25"></label>
              <?=$dG['w'];?></td>
          </tr>
          <tr>
            <td align="center">3</td>
            <td>Ett Nkk 6,5/7/7,5</td>
            <td><label for="textfield26"></label>
              <?=$dG['x'];?></td>
          </tr>
          <tr>
            <td align="center">4</td>
            <td>Ext. Tube/Discofic</td>
            <td><label for="textfield27"></label>
              <?=$dG['y'];?></td>
          </tr>
          <tr>
            <td align="center">5</td>
            <td>Intrafix/Tegaderm 1627/Swab Alkohol</td>
            <td><label for="textfield28"></label>
              <?=$dG['z'];?></td>
          </tr>
          <tr>
            <td align="center">6</td>
            <td>Vasofix 16/18/20</td>
            <td><label for="textfield29"></label>
              <?=$dG['aa'];?></td>
          </tr>
          <tr>
            <td align="center">7</td>
            <td>Slang O2 Adult/Suction 12</td>
            <td><label for="textfield30"></label>
              <?=$dG['bb'];?></td>
          </tr>
          <tr>
            <td align="center">8</td>
            <td>Elek Blue Sensor</td>
            <td><label for="textfield31"></label>
              <?=$dG['cc'];?></td>
          </tr>
          <tr>
            <td align="center">9</td>
            <td>Gluve Steril No.7/7,5</td>
            <td><label for="textfield32"></label>
              <?=$dG['dd'];?></td>
          </tr>
          <tr>
            <td align="center">10</td>
            <td>Ngt 14,16,18/Urine Bag</td>
            <td><label for="textfield33"></label>
              <?=$dG['ee'];?></td>
          </tr>
          <tr>
            <td align="center">11</td>
            <td>Spinal 26 (Bb)</td>
            <td><label for="textfield34"></label>
              <?=$dG['ff'];?></td>
          </tr>
          <tr>
            <td align="center">12</td>
            <td>Sevorene/Isoflurance</td>
            <td><label for="textfield35"></label>
              <?=$dG['gg'];?></td>
          </tr>
          <tr>
            <td align="center">13</td>
            <td>Oxygen/N2O</td>
            <td><label for="textfield36"></label>
              <?=$dG['hh'];?></td>
          </tr>
          <tr>
            <td align="center">14</td>
            <td>Rebreathing Slang</td>
            <td><label for="textfield37"></label>
              <?=$dG['ii'];?></td>
          </tr>
          <tr>
            <td align="center">15</td>
            <td>Laringeal Mask (Lm)</td>
            <td><label for="textfield4"></label>
              <?=$dG['jj'];?></td>
          </tr>
        </table></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" valign="top">Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" align="center" valign="top">Perawat Ruangan</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="3" align="center" valign="top">(<strong><?=$dP['dr_rujuk'];?></strong>)</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
    </table>
    </form>
      <br>
      <div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div>
      </td>
  </tr>
</table>
</form>
</div>

<div id="tampil_data" align="center"></div>
</body>
<script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';
            if(tombol.style.visibility=='collapse'){
                if(confirm('Anda Yakin Mau Mencetak ?')){
                    setTimeout('window.print()','1000');
                    setTimeout('window.close()','2000');
                }
                else{
                    tombol.style.visibility='visible';
                }

            }
        }
    </script>
<?php 
mysql_close($konek);
?>
</html>

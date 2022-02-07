<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_, ku.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_kunjungan ku
    ON ku.id=pl.kunjungan_id
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
		<script type="text/javascript" src="../js/jquery.timeentry.js"></script>
        <script type="text/JavaScript">
		$(function () 
{
	//$('#texjam').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_terima').timeEntry({show24Hours: true, showSeconds: true});
	//$('#txtJamSelesai').timeEntry({show24Hours: true, showSeconds: true});
});
            var arrRange = depRange = [];
        </script>
<title>Form Persetujuan Pemberian Darah</title>
<style type="text/css">
<!--
.style10 {color: #FFFFFF}
.style11 {font-size: 16px}
-->
</style>
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
.style8 {font-size: 18px}
.style9 {font-size: 18}
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
<form id="form1" name="form1" action="permintaan_pemeriksaan_lab_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td width="336" height="151"><strong>PERMINTAAN PEMERIKSAAN LABOLATORIUM </strong></td>
    <td width="515" rowspan="2"><table width="491" height="181" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="98">Nama Pasien</td>
        <td width="121">:
          <?=$dP['nama'];?>        </td>
        <td width="90">&nbsp;</td>
        <td width="114">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?>        </td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?>        </td>
        <td>No Registrasi </td>
        <td>: <?=$dP['no_reg2'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?>        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="2">:
          <?=$dP['alamat_'];?>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>No. Formulir :
      <input type="text" name="txt_noForm" id="txt_noForm" /></td>
  </tr>
  <tr>
    <td colspan="2" style="font:bold 16px tahoma;"><table width="100%" border="1" style="border-collapse:collapse">
      <tr>
        <td><table width="100%" border="0" style="font:10px tahoma;border-collapse:collapse">
            <tr>
              <td width="50%" rowspan="3" style="border-right:1px solid #000000"><strong>Diagnosis / Keterangan Klinis : <?php echo $diag;?></strong></td>
              <td width="11%"><div align="right"><strong>Diterima Tanggal </strong></div></td>
              <td width="39%"> :
                <label for="tgl_terima"></label>
                  <!--				<input type="text" name="tgl_terima" id="tgl_terima" onclick="gfPop.fPopCalendar(document.getElementById('tgl_terima'),depRange);" value="<?=date('d-m-Y')?>" /> -->
                  <input class="textbox" type="text" id="tgl_terima" name="tgl_terima" onclick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_terima);return false;" value="<?=date('d-m-Y')?>"/>              </td>
            </tr>
            <tr>
              <td><div align="right"><strong>Jam</strong></div></td>
              <td>:
                <input name="jam_terima" type="text" class="input150" id="jam_terima" value="<?=date('H:i:s')?>" />              </td>
            </tr>
            <tr>
              <td><div align="right"><strong>Petugas</strong></div></td>
              <td><strong>: <?php echo $dokter;?> </strong></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" style="font:10px tahoma">
            <tr>
              <td colspan="6">Pemeriksaan yang diminta harap diberi tanda (<img src="../centang.jpg" width="16" height="16" />)</td>
              <td><input type="checkbox" name="checkbox[0]" value="1" id="checkbox[]" />
                Biasa</td>
              <td colspan="8"><input type="checkbox" name="checkbox[1]" value="2" id="checkbox[]" />
                Cito</td>
            </tr>
            <tr>
              <td height="21" colspan="15" bgcolor="#CCCCCC"><strong>I. HEMATOLOGI</strong> </td>
            </tr>
            <tr>
              <td height="18" colspan="3" bgcolor="#CCCCCC"><strong>I.1 UMUM </strong></td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>I.2 HEMOSTATIS </strong></td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>I.3 KHUSUS </strong></td>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="1%">1.</td>
              <td width="1%"><input type="checkbox" name="checkbox[2]" value="3" id="checkbox[]" /></td>
              <td width="21%">Darah Rutin <em>(Full Blood Count) </em></td>
              <td width="1%">&nbsp;</td>
              <td width="1%">1.</td>
              <td width="2%"><input type="checkbox" name="checkbox[3]" value="4" id="checkbox[]" /></td>
              <td width="21%">Rumple Leede <em></em></td>
              <td width="1%">&nbsp;</td>
              <td width="1%">1.</td>
              <td width="2%"><input type="checkbox" name="checkbox[4]" value="5" id="checkbox[]" /></td>
              <td width="21%">Sel LE </td>
              <td width="1%">&nbsp;</td>
              <td width="1%">15.</td>
              <td width="2%"><input type="checkbox" name="checkbox[5]" value="6" id="checkbox[]" /></td>
              <td width="21%">Golongan Darah A, B, O &amp; Rh </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>(Hb, Leko, Diff, Ht, E, Trombo)</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[6]" value="7" id="checkbox[]" /></td>
              <td>Masa Pendarahan (BT) <em></em></td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[7]" value="8" id="checkbox[]" /></td>
              <td>Malaria Mikroskopis </td>
              <td>&nbsp;</td>
              <td>16.</td>
              <td><input type="checkbox" name="checkbox[8]" value="9" id="checkbox[]" /></td>
              <td>Tranferin</td>
            </tr>
            <tr>
              <td><p>2. </p></td>
              <td><input type="checkbox" name="checkbox[9]" value="10" id="checkbox[]" /></td>
              <td>Darah Lengkap <em>(Complete Blood Count) </em></td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[10]" value="11" id="checkbox[]" /></td>
              <td>Masa Pembekuan (CT) <em></em></td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[11]" value="12" id="checkbox[]" /></td>
              <td>Mikrofilaria</td>
              <td>&nbsp;</td>
              <td>17.</td>
              <td><input type="checkbox" name="checkbox[12]" value="13" id="checkbox[]" /></td>
              <td>IT Ratio </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>(DR, Eri, Ht, MCV, MCH, MCHC, LED)</td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[13]" value="14" id="checkbox[]" /></td>
              <td>Masa Protombin (PT) &amp; INR <em></em></td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[14]" value="15" id="checkbox[]" /></td>
              <td>Gambaran Sumsum Tulang </td>
              <td>&nbsp;</td>
              <td>18.</td>
              <td><input type="checkbox" name="checkbox[15]" value="16" id="checkbox[]" /></td>
              <td>Crossmatch Mayor/Minor </td>
            </tr>
            <tr>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[16]" value="17" id="checkbox[]" /></td>
              <td>Hemoglobin<em></em></td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[17]" value="18" id="checkbox[]" /></td>
              <td>APTT<em></em></td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[18]" value="19" id="checkbox[]" /></td>
              <td>Serum Iron (SI) </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[19]" value="20" id="checkbox[]" /></td>
              <td>Hematokrit<em></em></td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[20]" value="21" id="checkbox[]" /></td>
              <td>Masa Trombin (TT) <em></em></td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[21]" value="22" id="checkbox[]" /></td>
              <td>TIBC </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[22]" value="23" id="checkbox[]" /></td>
              <td>Eritrosit<em></em></td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[23]" value="24" id="checkbox[]" /></td>
              <td>Fibrinogen<em></em></td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[24]" value="25" id="checkbox[]" /></td>
              <td>Ferritin </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[25]" value="26" id="checkbox[]" /></td>
              <td>Lekosit<em></em></td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[26]" value="27" id="checkbox[]" /></td>
              <td>D-Dimer<em></em></td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[27]" value="28" id="checkbox[]" /></td>
              <td>Vitamin B 12 </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[28]" value="29" id="checkbox[]" /></td>
              <td>Hitung Jenis (Diff Count) <em></em></td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[29]" value="30" id="checkbox[]" /></td>
              <td>Agregasi Trombosit* <em></em></td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[30]" value="31" id="checkbox[]" /></td>
              <td>Asam Folat  * </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[31]" value="32" id="checkbox[]" /></td>
              <td>Trombosit<em></em></td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[32]" value="33" id="checkbox[]" /></td>
              <td>Viskositas Darah &amp; Plasma <em></em></td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[33]" value="34" id="checkbox[]" /></td>
              <td>G6 PD Neonatus </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[34]" value="35" id="checkbox[]" /></td>
              <td>LED (ESR) <em></em></td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[35]" value="36" id="checkbox[]" /></td>
              <td>Protein C <em></em></td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[36]" value="37" id="checkbox[]" /></td>
              <td>G6 PD Eritrosit </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[37]" value="38" id="checkbox[]" /></td>
              <td>MCV, MCH, MCHC <em></em></td>
              <td>&nbsp;</td>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[38]" value="39" id="checkbox[]" /></td>
              <td>Protein S <em></em></td>
              <td>&nbsp;</td>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[39]" value="40" id="checkbox[]" /></td>
              <td>Coomb's Tes </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[40]" value="41" id="checkbox[]" /></td>
              <td>Gambaran Darah Tepi <em></em></td>
              <td>&nbsp;</td>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[41]" value="42" id="checkbox[]" /></td>
              <td>Anti Trombin III (AT III) <em></em></td>
              <td>&nbsp;</td>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[42]" value="43" id="checkbox[]" /></td>
              <td>Analisa Hb (HPLC) </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>(Peripheral Blood Film)<em></em></td>
              <td>&nbsp;</td>
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[43]" value="44" id="checkbox[]" /></td>
              <td>Throbotest/ INR <em></em></td>
              <td>&nbsp;</td>
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[44]" value="45" id="checkbox[]" /></td>
              <td>Antibodi Trombosit </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[45]" value="46" id="checkbox[]" /></td>
              <td>Retikolusit<em></em></td>
              <td>&nbsp;</td>
              <td>15.</td>
              <td><input type="checkbox" name="checkbox[46]" value="47" id="checkbox[]" /></td>
              <td>Lupus Antikoagulan <em></em></td>
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
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[47]" value="48" id="checkbox[]" /></td>
              <td>Eosinofil<em></em></td>
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
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[48]" value="49" id="checkbox[]" /></td>
              <td>H2TL (Hb, Ht, T, L) <em></em></td>
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
            </tr>
            <tr>
              <td height="19" colspan="15" bgcolor="#CCCCCC"><strong>II. KIMIA DARAH </strong></td>
            </tr>
            <tr>
              <td height="19" colspan="3" bgcolor="#CCCCCC"><strong>II.1 HATI </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>II.4 GINJAL </strong></td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>II.6 ELEKTROLIT &amp; GAS DARAH </strong></td>
            </tr>
            <tr>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[49]" value="50" id="checkbox[]" /></td>
              <td>SGOT/AST<em></em></td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[50]" value="51" id="checkbox[]" /></td>
              <td>CK-MD</td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[51]" value="52" id="checkbox[]" /></td>
              <td>Ureum</td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[52]" value="53" id="checkbox[]" /></td>
              <td>Elektrolit (Na,K,Cl) </td>
            </tr>
            <tr>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[53]" value="54" id="checkbox[]" /></td>
              <td>SGPT/ALT</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[54]" value="55" id="checkbox[]" /></td>
              <td>LDH</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[55]" value="56" id="checkbox[]" /></td>
              <td>Kreatin</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[56]" value="57" id="checkbox[]" /></td>
              <td>Kalsium Total </td>
            </tr>
            <tr>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[57]" value="58" id="checkbox[]" /></td>
              <td>Gamma GT (GGT) </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[58]" value="59" id="checkbox[]" /></td>
              <td>HBDH</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[59]" value="60" id="checkbox[]" /></td>
              <td>Asam Urat </td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[60]" value="61" id="checkbox[]" /></td>
              <td>Kalsium Ion </td>
            </tr>
            <tr>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[61]" value="62" id="checkbox[]" /></td>
              <td>Fosfatase Alkali </td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[62]" value="63" id="checkbox[]" /></td>
              <td>Troponin T </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[63]" value="64" id="checkbox[]" /></td>
              <td>Urea Clearance </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[64]" value="65" id="checkbox[]" /></td>
              <td>Fostor Anorganik </td>
            </tr>
            <tr>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[65]" value="66" id="checkbox[]" /></td>
              <td>Total Protein - Albumin - Globumin </td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[66]" value="67" id="checkbox[]" /></td>
              <td>hs-CRP</td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[67]" value="68" id="checkbox[]" /></td>
              <td>Creatinin Clearance** </td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[68]" value="70" id="checkbox[]" /></td>
              <td>Magnesium</td>
            </tr>
            <tr>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[70]" value="69" id="checkbox[]" /></td>
              <td>Bilirubin Total - Direk - Indirek </td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[69]" value="71" id="checkbox[]" /></td>
              <td>Homosistein</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[71]" value="72" id="checkbox[]" /></td>
              <td>Analisa Gas Darah </td>
            </tr>
            <tr>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[72]" value="73" id="checkbox[]" /></td>
              <td>Bilirubin Neonatus </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[73]" value="74" id="checkbox[]" /></td>
              <td>NT-Pro BNP </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>II. DIABETES </strong></td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[74]" value="75" id="checkbox[]" /></td>
              <td>CO2 Total </td>
            </tr>
            <tr>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[75]" value="76" id="checkbox[]" /></td>
              <td>Protein Elektroforesta </td>
              <td>&nbsp;</td>
              <td colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[76]" value="77" id="checkbox[]" /></td>
              <td>Glukosa Sewaktu </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[77]" value="78" id="checkbox[]" /></td>
              <td>Osmolaritas Darah </td>
            </tr>
            <tr>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[78]" value="79" id="checkbox[]" /></td>
              <td>Albumin</td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>II.3 LEMAK </strong></td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[79]" value="80" id="checkbox[]" /></td>
              <td>Glukosa Puasa* </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[80]" value="81" id="checkbox[]" /></td>
              <td>Cholinesterase (CHE) </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[81]" value="82" id="checkbox[]" /></td>
              <td>Kolesterol Total </td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[82]" value="83" id="checkbox[]" /></td>
              <td>Glukosa 2 Jam PP </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>II.7 PANKREAS </strong></td>
            </tr>
            <tr>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[83]" value="84" id="checkbox[]" /></td>
              <td>Asam Empedu (Bile Acid) * </td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[84]" value="85" id="checkbox[]" /></td>
              <td>HDL Kolesterol Direk </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[85]" value="86" id="checkbox[]" /></td>
              <td>Glukosa Kurva Harian* </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[86]" value="87" id="checkbox[]" /></td>
              <td>Amilase</td>
            </tr>
            <tr>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[87]" value="88" id="checkbox[]" /></td>
              <td>GLDH</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[88]" value="89" id="checkbox[]" /></td>
              <td>LDL Kolesterol Direk </td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[89]" value="90" id="checkbox[]" /></td>
              <td>Gliko Hb/HbA1C </td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[90]" value="91" id="checkbox[]" /></td>
              <td>Lipase</td>
            </tr>
            <tr>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[91]" value="92" id="checkbox[]" /></td>
              <td>Amonia</td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[92]" value="93" id="checkbox[]" /></td>
              <td>Trigliserid*</td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[93]" value="94" id="checkbox[]" /></td>
              <td>Keton Darah </td>
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
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[94]" value="95" id="checkbox[]" /></td>
              <td>Apo-A1*</td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[95]" value="96" id="checkbox[]" /></td>
              <td>Insulin*</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="21" colspan="3">&nbsp;</td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[96]" value="97" id="checkbox[]" /></td>
              <td>Apo B* </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[97]" value="98" id="checkbox[]" /></td>
              <td>C-Peptide*</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="21" colspan="3" bgcolor="#CCCCCC"><strong>II.2 JANTUNG</strong></td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[98]" value="99" id="checkbox[]" /></td>
              <td>Small-Dense LDL* </td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[99]" value="100" id="checkbox[]" /></td>
              <td>GTT/TTGO</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="21">1.</td>
              <td><input type="checkbox" name="checkbox[100]" value="101" id="checkbox[]" /></td>
              <td>CK/CPK</td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[101]" value="102" id="checkbox[]" /></td>
              <td>Lp(a)</td>
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
            </tr>
            <tr>
              <td height="19" colspan="15" bgcolor="#CCCCCC"><strong>III. IMUNOSEROLOGI</strong></td>
            </tr>
            <tr>
              <td height="20" colspan="3" bgcolor="#CCCCCC"><strong>III.1 SEROLOGI </strong></td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.2 IMUNOLOGI </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.5 TORCH </strong></td>
            </tr>
            <tr>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[102]" value="103" id="checkbox[]" /></td>
              <td>ASTO</td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[103]" value="104" id="checkbox[]" /></td>
              <td>lg-A</td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[104]" value="105" id="checkbox[]" /></td>
              <td>Anti HBeAg </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[105]" value="106" id="checkbox[]" /></td>
              <td>Anti Toksoplasma lgG </td>
            </tr>
            <tr>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[106]" value="107" id="checkbox[]" /></td>
              <td>RF</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[107]" value="108" id="checkbox[]" /></td>
              <td>lg-G</td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[108]" value="109" id="checkbox[]" /></td>
              <td>Anti HBe </td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[109]" value="110" id="checkbox[]" /></td>
              <td>Anti Toksoplasma lgM </td>
            </tr>
            <tr>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[110]" value="111" id="checkbox[]" /></td>
              <td>CRP</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[111]" value="112" id="checkbox[]" /></td>
              <td>lg-M</td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[112]" value="113" id="checkbox[]" /></td>
              <td>Anti HCV Total </td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[113]" value="114" id="checkbox[]" /></td>
              <td>Anti Rubella lgG </td>
            </tr>
            <tr>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[114]" value="115" id="checkbox[]" /></td>
              <td>Ns 1 Ag Dengue </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[115]" value="116" id="checkbox[]" /></td>
              <td>Komplemen C3 </td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[116]" value="117" id="checkbox[]" /></td>
              <td>Anti HCV lgM </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[117]" value="118" id="checkbox[]" /></td>
              <td>Anti Rubella lgM </td>
            </tr>
            <tr>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[118]" value="119" id="checkbox[]" /></td>
              <td>Widal</td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[119]" value="120" id="checkbox[]" /></td>
              <td>Komplemen C4 </td>
              <td>&nbsp;</td>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[120]" value="121" id="checkbox[]" /></td>
              <td>HBV DNA Kualitatif </td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[121]" value="122" id="checkbox[]" /></td>
              <td>Anti CVM lgG </td>
            </tr>
            <tr>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[122]" value="123" id="checkbox[]" /></td>
              <td>Anti S.Typhi lgM </td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[123]" value="124" id="checkbox[]" /></td>
              <td>T Helper (CD4) </td>
              <td>&nbsp;</td>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[124]" value="125" id="checkbox[]" /></td>
              <td>HBV DNA (Real Time PCR)</td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[125]" value="126" id="checkbox[]" /></td>
              <td>Anti CVM lgM </td>
            </tr>
            <tr>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[126]" value="127" id="checkbox[]" /></td>
              <td>Anti Dengue lgG &amp; lgM </td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[127]" value="128" id="checkbox[]" /></td>
              <td>T Soppressor (CD8) </td>
              <td>&nbsp;</td>
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[128]" value="129" id="checkbox[]" /></td>
              <td>HCV RNA Kualitatif </td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[129]" value="130" id="checkbox[]" /></td>
              <td>Anti HSV1 lgG </td>
            </tr>
            <tr>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[130]" value="131" id="checkbox[]" /></td>
              <td>Anti H.Pylori lgG </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[131]" value="132" id="checkbox[]" /></td>
              <td>ANA</td>
              <td>&nbsp;</td>
              <td>15.</td>
              <td><input type="checkbox" name="checkbox[132]" value="133" id="checkbox[]" /></td>
              <td>HCV RNA (Real Time PCR) </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[133]" value="134" id="checkbox[]" /></td>
              <td>Anti HSV2 lgM </td>
            </tr>
            <tr>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[134]" value="135" id="checkbox[]" /></td>
              <td>Anti H.Pylori lgM </td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[135]" value="136" id="checkbox[]" /></td>
              <td>Anti ds-DNA </td>
              <td>&nbsp;</td>
              <td>16.</td>
              <td><input type="checkbox" name="checkbox[136]" value="137" id="checkbox[]" /></td>
              <td>HCV RNA Genotip </td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[137]" value="138" id="checkbox[]" /></td>
              <td>Anti HSV2 lgG </td>
            </tr>
            <tr>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[138]" value="139" id="checkbox[]" /></td>
              <td>Anti Amoeba (seramoeba) </td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[139]" value="140" id="checkbox[]" /></td>
              <td>AMA</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[140]" value="141" id="checkbox[]" /></td>
              <td>Anti HSV2 lgM </td>
            </tr>
            <tr>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[141]" value="142" id="checkbox[]" /></td>
              <td>Chikungunya </td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[142]" value="143" id="checkbox[]" /></td>
              <td>ACA lgG </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.4 PETANDA TUMOR </strong></td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[143]" value="144" id="checkbox[]" /></td>
              <td>Aviditas Anti Toksoplasma lgG </td>
            </tr>
            <tr>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[144]" value="145" id="checkbox[]" /></td>
              <td>Anti Chlamydia lgG </td>
              <td>&nbsp;</td>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[145]" value="146" id="checkbox[]" /></td>
              <td>ACA lgM </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[146]" value="147" id="checkbox[]" /></td>
              <td>AFP (Lever) </td>
              <td>&nbsp;</td>
              <td>12.</td>
              <td><input type="checkbox" name="checkbox[147]" value="148" id="checkbox[]" /></td>
              <td>Aviditas Anti CMV lgG </td>
            </tr>
            <tr>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[148]" value="149" id="checkbox[]" /></td>
              <td>Anti Chlamydia IgM </td>
              <td>&nbsp;</td>
              <td>13.</td>
              <td><input type="checkbox" name="checkbox[149]" value="150" id="checkbox[]" /></td>
              <td>SMA</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[150]" value="151" id="checkbox[]" /></td>
              <td>CEA (Colon) </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[151]" value="152" id="checkbox[]" /></td>
              <td>Anti Tuberkulosis lgG </td>
              <td>&nbsp;</td>
              <td>14.</td>
              <td><input type="checkbox" name="checkbox[152]" value="153" id="checkbox[]" /></td>
              <td>ANCA</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[153]" value="154" id="checkbox[]" /></td>
              <td>CA 15-3 (Breast) </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.6 ALERGI </strong></td>
            </tr>
            <tr>
              <td>15.</td>
              <td><input type="checkbox" name="checkbox[154]" value="155" id="checkbox[]" /></td>
              <td>VDRL/RPR</td>
              <td>&nbsp;</td>
              <td>15.</td>
              <td><input type="checkbox" name="checkbox[155]" value="156" id="checkbox[]" /></td>
              <td>Procalcitonin (PCI) </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[156]" value="157" id="checkbox[]" /></td>
              <td>CA 19-9 (Pankreas) </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[157]" value="158" id="checkbox[]" /></td>
              <td>lg-Total</td>
            </tr>
            <tr>
              <td>16.</td>
              <td><input type="checkbox" name="checkbox[158]" value="159" id="checkbox[]" /></td>
              <td>TPHA</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[159]" value="160" id="checkbox[]" /></td>
              <td>CA 125 (Ovarium) </td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[160]" value="161" id="checkbox[]" /></td>
              <td>lg-E Atopy </td>
            </tr>
            <tr>
              <td>17.</td>
              <td><input type="checkbox" name="checkbox[161]" value="162" id="checkbox[]" /></td>
              <td>Anti CCP lgG </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.3 PETANDA HEPATITIS </strong></td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[162]" value="163" id="checkbox[]" /></td>
              <td>CA 72-4 (Gaster) </td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[163]" value="164" id="checkbox[]" /></td>
              <td>lg-E Inhalasi </td>
            </tr>
            <tr>
              <td>18.</td>
              <td><input type="checkbox" name="checkbox[164]" value="165" id="checkbox[]" /></td>
              <td>Malaria Rapid </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[165]" value="166" id="checkbox[]" /></td>
              <td>Anti HAV lgG </td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[166]" value="167" id="checkbox[]" /></td>
              <td>CYFRA 21-1 (Lung) </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[167]" value="168" id="checkbox[]" /></td>
              <td>lg-E Pediatri </td>
            </tr>
            <tr>
              <td>19.</td>
              <td><input type="checkbox" name="checkbox[168]" value="169" id="checkbox[]" /></td>
              <td>Anti Dengue lgA </td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[169]" value="170" id="checkbox[]" /></td>
              <td>Anti HAV lgM </td>
              <td>&nbsp;</td>
              <td>8.</td>
              <td><input type="checkbox" name="checkbox[170]" value="171" id="checkbox[]" /></td>
              <td>NSE (Neuroblastoma, Lung) </td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[171]" value="172" id="checkbox[]" /></td>
              <td>lg-E South East Asian Food </td>
            </tr>
            <tr>
              <td>20.</td>
              <td><input type="checkbox" name="checkbox[172]" value="173" id="checkbox[]" /></td>
              <td>Anti HIV Penyaring </td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[173]" value="174" id="checkbox[]" /></td>
              <td>HBsAg</td>
              <td>&nbsp;</td>
              <td>9.</td>
              <td><input type="checkbox" name="checkbox[174]" value="175" id="checkbox[]" /></td>
              <td>SCC (Lung, Serviks) </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>21.</td>
              <td><input type="checkbox" name="checkbox[175]" value="176" id="checkbox[]" /></td>
              <td>Konfirmasi HIV (Western Blot) </td>
              <td>&nbsp;</td>
              <td>4.</td>
              <td><input type="checkbox" name="checkbox[176]" value="177" id="checkbox[]" /></td>
              <td>HBsAg Kuantitatif </td>
              <td>&nbsp;</td>
              <td>10.</td>
              <td><input type="checkbox" name="checkbox[177]" value="178" id="checkbox[]" /></td>
              <td>PSA Total (Prostat) </td>
              <td>&nbsp;</td>
              <td colspan="3" bgcolor="#CCCCCC"><strong>III.7 OSTEOPOROSIS </strong></td>
            </tr>
            <tr>
              <td>22.</td>
              <td><input type="checkbox" name="checkbox[178]" value="179" id="checkbox[]" /></td>
              <td>Tubex</td>
              <td>&nbsp;</td>
              <td>5.</td>
              <td><input type="checkbox" name="checkbox[179]" value="180" id="checkbox[]" /></td>
              <td>HBsAg Konfirmasi </td>
              <td>&nbsp;</td>
              <td>11.</td>
              <td><input type="checkbox" name="checkbox[180]" value="181" id="checkbox[]" /></td>
              <td>Free PSA (Prostat) </td>
              <td>&nbsp;</td>
              <td>1.</td>
              <td><input type="checkbox" name="checkbox[181]" value="182" id="checkbox[]" /></td>
              <td>N-MID Osteocalcin </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>6.</td>
              <td><input type="checkbox" name="checkbox[182]" value="183" id="checkbox[]" /></td>
              <td>Anti HBs </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>2.</td>
              <td><input type="checkbox" name="checkbox[183]" value="184" id="checkbox[]" /></td>
              <td>C-Telopeptide (CTx)</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>7.</td>
              <td><input type="checkbox" name="checkbox[184]" value="185" id="checkbox[]" /></td>
              <td>Anti HBs total </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>3.</td>
              <td><input type="checkbox" name="checkbox[185]" value="186" id="checkbox[]" /></td>
              <td>Isoenzim ALP </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="800" border="0" align="center">
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
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                   <?php }?> </td>
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
			 

			//$('#id').val(sisip[0]);
			$('#txtId').val(sisip[0]);
			$('#txt_noForm').val(sisip[1]);
			$('#tgl_terima').val(sisip[2]);
			$('#jam_terima').val(sisip[3]);
			checkbox(sisip[4]);
			
			
			//var p="id*-*"+sisip[0]+"*|*identitas*-*"+sisip[1]+"";
			 //$('#note').val(sisip[10]);
			 //cek(sisip[2]);
			 /*centang(sisip[5]);
			 centang2(sisip[8]);
			 centang3(sisip[9]);
			 centang4(sisip[11]);
			 centang5(sisip[13]);
			 centang6(sisip[14]);
			 centang7(sisip[17]);
			 centang8(sisip[19]);
			 centang9(sisip[20]);
			 cek(sisip[22]);*/
			 
			 /*$('#inObat').load("14.form_terapi_pulang.php?type=ESO&id="+sisip[0]);
			 $('#inObat2').load("14.form_kembali_kontrol.php?type=ESO&id="+sisip[0]);*/
			 $('#act').val('edit');
			 
			 
			 //$('#kronologis').val(sisip[2]);
			 //$('#tindakan').val(sisip[13]);
			 
            fSetValue(window,p);
			
        }

        function hapus(){
            var id = document.getElementById("txtId").value;
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
            var id = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#tampil_input').slideDown(1000,function(){
		toggle();
		});
				}

        }

        function batal(){
			//resetF();
			$('#tampil_input').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("14.form_terapi_pulang.php");
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
            a.loadURL("permintaan_pemeriksaan_lab_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Persetujuan Pemberian Darah");
        a.setColHeader("NO,NAMA PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,,,");
        a.setColWidth("20,300,150,120");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("permintaan_pemeriksaan_lab_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		toggle();
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
		 var id = document.getElementById("txtId").value;
		 if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("permintaan_pemeriksaan_lab.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		
		function radiobutton(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radiobutton'];
		var list2 = document.form1.elements['radiobutton'];
				
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
		}}
		
		
		
	//		var tes2x =tes2.split(',');
//		if ( checkbox2.length > 0 )
//		{
//		 for (i = 0; i < checkbox2.length; i++)
//			{
//			  if (checkbox2[i].value==tes2x[i])
//			  {
//			   checkbox2[i].checked = true;
//			  }
//		  }
//		}
//		
		
		
		function checkbox(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['checkbox[]'];
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

function gantiUmur(){
            var val=document.getElementById('textgl_lahir').value;
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');

            var tgl = val.split("-");
            var tahun = tgl[2];
            var bulan = tgl[1];
            var tanggal = tgl[0];
            //alert(tahun+", "+bulan+", "+tanggal);
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            //alert(Y+", "+M+", "+D);
            Y = Y - tahun;
            M = M - bulan;
            D = D - tanggal;
            //M = pad(M+1,2,'0',1);
            //D = pad(D,2,'0',1);
            //alert(Y+", "+M+", "+D);
            if(D < 0){
                M -= 1;
                D = 30+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            document.getElementById("texumur").value = Y;
            document.getElementById("Bln").value = M;
            document.getElementById("hari").value = D;
            //$("txtHari").value = D;
        }


function gantiTgl()
        {
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');
            var thn=(document.getElementById("texumur").value=='')?0:parseInt(document.getElementById("texumur").value);
            var bln=(document.getElementById("Bln").value=='')?0:parseInt(document.getElementById("Bln").value);
			var hari=(document.getElementById("hari").value=='')?0:parseInt(document.getElementById("hari").value);
			
			if(bln>11){
                var tmp = parseInt(bln/12);
                if(thn == ''){
                    thn = tmp;
                }
                else{
                    thn = thn+tmp;
                }
                document.getElementById('texumur').value = thn;
                tmp = bln%12;
                bln = tmp;
                document.getElementById('Bln').value = bln;
            }
            if(bln == ''){
                document.getElementById('Bln').value = 0;
            }
			
			if(hari == ''){
				document.getElementById('hari').value = 0;
			}

            var Y = dDate.getFullYear()-thn;
            var M = dDate.getMonth()-bln+1;
            var D = dDate.getDate()-hari;
            //alert(D+"-"+M+"-"+Y);
            
			
			var bulan = '';
			if((D-hari)>0){
				bulan = M;
			}
			else{
				bulan = M-1;	
			}
			
			var jD = '';
			if(bulan==1 || bulan==3 || bulan==5 || bulan==7 || bulan==8 || bulan==10 || bulan==12){
				jD = 31;
			}else if(bulan==2){
				if((thn%4==0) && (thn%100!=0)){
					jD = 29;
				}else{
					jD = 28;
				}
			}else{
				jD = 30;
			}
			
			if(D < 0){
                M -= 1;
                D = jD+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
			
            var nDate = new Date(M+"/"+D+"/"+Y);
            Y = nDate.getFullYear();
            M = nDate.getMonth()+1;
            D = nDate.getDate();
			
		
			if(hari>(jD-1)){
				var tmp = parseInt(hari/jD);
				if(bln == 0){
                    M = tmp;
                }
                else{
                    M = M+tmp;
                }
                document.getElementById('Bln').value = M;
                tmp = hari%jD;
                hari = tmp;
                document.getElementById('hari').value = hari;
			}
			
            nDate = D + "-" + M + "-" + Y;
			if (D<10){
				document.getElementById("textgl_lahir").value = "0" + D + "-" + M + "-" + Y;
			}else{
            	document.getElementById("textgl_lahir").value = nDate;
			}
        }


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

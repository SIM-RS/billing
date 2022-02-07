<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));

include"setting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <script type="text/javascript" src="js/jquery.timeentry.js"></script>
        <script type="text/javascript">
$(function () 
{
	$('#jam_tiba').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_kaji').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam_terima').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <title>PERMINTAAN PEMERIKSAAN LAB</title>
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
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<iframe width=174 height=189 name="gToday:normal:js/calender/agenda.js" id="gToday:normal:js/calender/agenda.js" src="js/calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
	</iframe>          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" bordercolor="#FF0000" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="permintaan_pemeriksaan_lab_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
<table width="1000" border="0" bordercolor="#000000" style="border-collapse:collapse; font:tahoma">
  <tr>
    <td><div align="right" class="style2"><strong>PELAYANAN 24 JAM </strong></div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" style="font:12px tahoma">
      <tr>
        <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="61%" height="69"><span class="style2">RS PELINDO I </span></td>
        <td width="39%" rowspan="2"><table width="100%" border="0" style="border:1px solid #000000; font:10px tahoma">
          <tr>
            <td width="26%">Nama Pasien </td>
            <td width="2%">:</td>
            <td colspan="2"> <?=$nama;?> (<?=$sex;?>)</td>
            </tr>
          <tr>
            <td>Tanggal Lahir </td>
            <td>:</td>
            <td width="34%"><?=$tgl;?> </td>
            <td>Usia : 
              <?=$umur;?> 
              th </td>
            </tr>
          <tr>
            <td>No. RM </td>
            <td>:</td>
            <td><?=$noRM;?></td>
            <td>No. registrasi: </td>
            </tr>
          <tr>
            <td>Ruang Rawat / Kelas </td>
            <td>:</td>
            <td colspan="2"><?=$kamar;?> / <?=$kelas;?></td>
            </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="2"><?=$alamat;?></td>
            </tr>
          <tr>
            <td height="28" colspan="4"><div align="center"><strong>(Tempelkan Stiker Identitas Pasien) </strong></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN LABOLATORIUM </span></td>
      </tr>
    </table></td>
      </tr>
      <tr>
        <td>No. Formulir : <input type="text" name="txt_noForm" id="txt_noForm" /> </td>
      </tr>
      <tr>
        <td><table width="100%" border="1" style="border-collapse:collapse">
          <tr>
            <td><table width="100%" border="0" style="font:10px tahoma;border-collapse:collapse">
              <tr>
                <td width="50%" rowspan="3" style="border-right:1px solid #000000"><strong>Diagnosis / Keterangan Klinis : <?php echo $diag;?></strong></td>
                <td width="11%"><div align="right"><strong>Diterima Tanggal  </strong></div></td>				
				<td width="39%"> : 
				<label for="tgl_terima"></label>
<!--				<input type="text" name="tgl_terima" id="tgl_terima" onclick="gfPop.fPopCalendar(document.getElementById('tgl_terima'),depRange);" value="<?=date('d-m-Y')?>" /> -->
				<input class="textbox" type="text" id="tgl_terima" name="tgl_terima" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.tgl_terima);return false;" value="<?=date('d-m-Y')?>"/>
				</td>
              </tr>
              <tr>
                <td><div align="right"><strong>Jam</strong></div></td>
				<td>: <input name="jam_terima" type="text" class="input150" id="jam_terima" value="<?=date('H:i:s')?>" />
				</td>
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
                <td colspan="6">Pemeriksaan yang diminta harap diberi tanda (<img src="centang.jpg" width="16" height="16" />)</td>
                <td><input type="checkbox" name="isi_chk[0]" value="1" id="isi_chk[]" />
Biasa</td>
                <td colspan="8"><input type="checkbox" name="isi_chk[1]" value="2" id="isi_chk[]" />
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

                <td width="1%"><input type="checkbox" name="isi_chk[2]" value="3" id="isi_chk[]" /></td>
                <td width="21%">Darah Rutin <em>(Full Blood Count) </em></td>
                <td width="1%">&nbsp;</td>
                <td width="1%">1.</td>
                <td width="2%"><input type="checkbox" name="isi_chk[3]" value="4" id="isi_chk[]" /></td>
                <td width="21%">Rumple Leede <em></em></td>
                <td width="1%">&nbsp;</td>
                <td width="1%">1.</td>
                <td width="2%"><input type="checkbox" name="isi_chk[4]" value="5" id="isi_chk[]" /></td>
                <td width="21%">Sel LE </td>
                <td width="1%">&nbsp;</td>
                <td width="1%">15.</td>
                <td width="2%"><input type="checkbox" name="isi_chk[5]" value="6" id="isi_chk[]" /></td>
                <td width="21%">Golongan Darah A, B, O &amp; Rh </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>(Hb, Leko, Diff, Ht, E, Trombo)</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[6]" value="7" id="isi_chk[]" /></td>
                <td>Masa Pendarahan (BT) <em></em></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[7]" value="8" id="isi_chk[]" /></td>
                <td>Malaria Mikroskopis </td>
                <td>&nbsp;</td>
                <td>16.</td>
                <td><input type="checkbox" name="isi_chk[8]" value="9" id="isi_chk[]" /></td>
                <td>Tranferin</td>
              </tr>
              <tr>
                <td><p>2. </p></td>
                <td><input type="checkbox" name="isi_chk[9]" value="10" id="isi_chk[]" /></td>
                <td>Darah Lengkap <em>(Complete Blood Count) </em></td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[10]" value="11" id="isi_chk[]" /></td>
                <td>Masa Pembekuan (CT) <em></em></td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[11]" value="12" id="isi_chk[]" /></td>
                <td>Mikrofilaria</td>
                <td>&nbsp;</td>
                <td>17.</td>
                <td><input type="checkbox" name="isi_chk[12]" value="13" id="isi_chk[]" /></td>
                <td>IT Ratio </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>(DR, Eri, Ht, MCV, MCH, MCHC, LED)</td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[13]" value="14" id="isi_chk[]" /></td>
                <td>Masa Protombin (PT) &amp; INR <em></em></td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[14]" value="15" id="isi_chk[]" /></td>
                <td>Gambaran Sumsum Tulang </td>
                <td>&nbsp;</td>
                <td>18.</td>
                <td><input type="checkbox" name="isi_chk[15]" value="16" id="isi_chk[]" /></td>
                <td>Crossmatch Mayor/Minor </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[16]" value="17" id="isi_chk[]" /></td>
                <td>Hemoglobin<em></em></td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[17]" value="18" id="isi_chk[]" /></td>
                <td>APTT<em></em></td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[18]" value="19" id="isi_chk[]" /></td>
                <td>Serum Iron (SI)  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[19]" value="20" id="isi_chk[]" /></td>
                <td>Hematokrit<em></em></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[20]" value="21" id="isi_chk[]" /></td>
                <td>Masa Trombin (TT) <em></em></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[21]" value="22" id="isi_chk[]" /></td>
                <td>TIBC </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[22]" value="23" id="isi_chk[]" /></td>
                <td>Eritrosit<em></em></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[23]" value="24" id="isi_chk[]" /></td>
                <td>Fibrinogen<em></em></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[24]" value="25" id="isi_chk[]" /></td>
                <td>Ferritin </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[25]" value="26" id="isi_chk[]" /></td>
                <td>Lekosit<em></em></td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[26]" value="27" id="isi_chk[]" /></td>
                <td>D-Dimer<em></em></td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[27]" value="28" id="isi_chk[]" /></td>
                <td>Vitamin B 12  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[28]" value="29" id="isi_chk[]" /></td>
                <td>Hitung Jenis (Diff Count) <em></em></td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[29]" value="30" id="isi_chk[]" /></td>
                <td>Agregasi Trombosit* <em></em></td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[30]" value="31" id="isi_chk[]" /></td>
                <td>Asam Folat  * </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[31]" value="32" id="isi_chk[]" /></td>
                <td>Trombosit<em></em></td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[32]" value="33" id="isi_chk[]" /></td>
                <td>Viskositas Darah &amp; Plasma <em></em></td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[33]" value="34" id="isi_chk[]" /></td>
                <td>G6 PD Neonatus  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[34]" value="35" id="isi_chk[]" /></td>
                <td>LED (ESR) <em></em></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[35]" value="36" id="isi_chk[]" /></td>
                <td>Protein C <em></em></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[36]" value="37" id="isi_chk[]" /></td>
                <td>G6 PD Eritrosit  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[37]" value="38" id="isi_chk[]" /></td>
                <td>MCV, MCH, MCHC <em></em></td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[38]" value="39" id="isi_chk[]" /></td>
                <td>Protein S <em></em></td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[39]" value="40" id="isi_chk[]" /></td>
                <td>Coomb's Tes  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[40]" value="41" id="isi_chk[]" /></td>
                <td>Gambaran Darah Tepi <em></em></td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[41]" value="42" id="isi_chk[]" /></td>
                <td>Anti Trombin III (AT III) <em></em></td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[42]" value="43" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[43]" value="44" id="isi_chk[]" /></td>
                <td>Throbotest/ INR <em></em></td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input type="checkbox" name="isi_chk[44]" value="45" id="isi_chk[]" /></td>
                <td>Antibodi Trombosit </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[45]" value="46" id="isi_chk[]" /></td>
                <td>Retikolusit<em></em></td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input type="checkbox" name="isi_chk[46]" value="47" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[47]" value="48" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[48]" value="49" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[49]" value="50" id="isi_chk[]" /></td>
                <td>SGOT/AST<em></em></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[50]" value="51" id="isi_chk[]" /></td>
                <td>CK-MD</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[51]" value="52" id="isi_chk[]" /></td>
                <td>Ureum</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[52]" value="53" id="isi_chk[]" /></td>
                <td>Elektrolit (Na,K,Cl) </td>
              </tr>
              <tr>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[53]" value="54" id="isi_chk[]" /></td>
                <td>SGPT/ALT</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[54]" value="55" id="isi_chk[]" /></td>
                <td>LDH</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[55]" value="56" id="isi_chk[]" /></td>
                <td>Kreatin</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[56]" value="57" id="isi_chk[]" /></td>
                <td>Kalsium Total </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[57]" value="58" id="isi_chk[]" /></td>
                <td>Gamma GT (GGT) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[58]" value="59" id="isi_chk[]" /></td>
                <td>HBDH</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[59]" value="60" id="isi_chk[]" /></td>
                <td>Asam Urat </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[60]" value="61" id="isi_chk[]" /></td>
                <td>Kalsium Ion </td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[61]" value="62" id="isi_chk[]" /></td>
                <td>Fosfatase Alkali </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[62]" value="63" id="isi_chk[]" /></td>
                <td>Troponin T </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[63]" value="64" id="isi_chk[]" /></td>
                <td>Urea Clearance </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[64]" value="65" id="isi_chk[]" /></td>
                <td>Fostor Anorganik </td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[65]" value="66" id="isi_chk[]" /></td>
                <td>Total Protein - Albumin - Globumin </td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[66]" value="67" id="isi_chk[]" /></td>
                <td>hs-CRP</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[67]" value="68" id="isi_chk[]" /></td>
                <td>Creatinin Clearance** </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[68]" value="70" id="isi_chk[]" /></td>
                <td>Magnesium</td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[70]" value="69" id="isi_chk[]" /></td>
                <td>Bilirubin Total - Direk - Indirek </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[69]" value="71" id="isi_chk[]" /></td>
                <td>Homosistein</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[71]" value="72" id="isi_chk[]" /></td>
                <td>Analisa Gas Darah </td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[72]" value="73" id="isi_chk[]" /></td>
                <td>Bilirubin Neonatus </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[73]" value="74" id="isi_chk[]" /></td>
                <td>NT-Pro BNP </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II. DIABETES </strong></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[74]" value="75" id="isi_chk[]" /></td>
                <td>CO2 Total </td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[75]" value="76" id="isi_chk[]" /></td>
                <td>Protein Elektroforesta </td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[76]" value="77" id="isi_chk[]" /></td>
                <td>Glukosa Sewaktu </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[77]" value="78" id="isi_chk[]" /></td>
                <td>Osmolaritas Darah </td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[78]" value="79" id="isi_chk[]" /></td>
                <td>Albumin</td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II.3 LEMAK </strong></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[79]" value="80" id="isi_chk[]" /></td>
                <td>Glukosa Puasa* </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[80]" value="81" id="isi_chk[]" /></td>
                <td>Cholinesterase (CHE) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[81]" value="82" id="isi_chk[]" /></td>
                <td>Kolesterol Total </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[82]" value="83" id="isi_chk[]" /></td>
                <td>Glukosa 2 Jam PP </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II.7 PANKREAS </strong></td>
                </tr>
              <tr>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[83]" value="84" id="isi_chk[]" /></td>
                <td>Asam Empedu (Bile Acid) * </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[84]" value="85" id="isi_chk[]" /></td>
                <td>HDL Kolesterol Direk </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[85]" value="86" id="isi_chk[]" /></td>
                <td>Glukosa Kurva Harian* </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[86]" value="87" id="isi_chk[]" /></td>
                <td>Amilase</td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[87]" value="88" id="isi_chk[]" /></td>
                <td>GLDH</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[88]" value="89" id="isi_chk[]" /></td>
                <td>LDL Kolesterol Direk </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[89]" value="90" id="isi_chk[]" /></td>
                <td>Gliko Hb/HbA1C </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[90]" value="91" id="isi_chk[]" /></td>
                <td>Lipase</td>
              </tr>
              <tr>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[91]" value="92" id="isi_chk[]" /></td>
                <td>Amonia</td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[92]" value="93" id="isi_chk[]" /></td>
                <td>Trigliserid*</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[93]" value="94" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[94]" value="95" id="isi_chk[]" /></td>
                <td>Apo-A1*</td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[95]" value="96" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[96]" value="97" id="isi_chk[]" /></td>
                <td>Apo B* </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[97]" value="98" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[98]" value="99" id="isi_chk[]" /></td>
                <td>Small-Dense LDL* </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[99]" value="100" id="isi_chk[]" /></td>
                <td>GTT/TTGO</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="21">1.</td>
                <td><input type="checkbox" name="isi_chk[100]" value="101" id="isi_chk[]" /></td>
                <td>CK/CPK</td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[101]" value="102" id="isi_chk[]" /></td>
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
                <td><input type="checkbox" name="isi_chk[102]" value="103" id="isi_chk[]" /></td>
                <td>ASTO</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[103]" value="104" id="isi_chk[]" /></td>
                <td>lg-A</td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[104]" value="105" id="isi_chk[]" /></td>
                <td>Anti HBeAg </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[105]" value="106" id="isi_chk[]" /></td>
                <td>Anti Toksoplasma lgG </td>
              </tr>
              <tr>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[106]" value="107" id="isi_chk[]" /></td>
                <td>RF</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[107]" value="108" id="isi_chk[]" /></td>
                <td>lg-G</td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[108]" value="109" id="isi_chk[]" /></td>
                <td>Anti HBe </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[109]" value="110" id="isi_chk[]" /></td>
                <td>Anti Toksoplasma lgM </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[110]" value="111" id="isi_chk[]" /></td>
                <td>CRP</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[111]" value="112" id="isi_chk[]" /></td>
                <td>lg-M</td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[112]" value="113" id="isi_chk[]" /></td>
                <td>Anti HCV Total </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[113]" value="114" id="isi_chk[]" /></td>
                <td>Anti Rubella lgG </td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[114]" value="115" id="isi_chk[]" /></td>
                <td>Ns 1 Ag Dengue </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[115]" value="116" id="isi_chk[]" /></td>
                <td>Komplemen C3 </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[116]" value="117" id="isi_chk[]" /></td>
                <td>Anti HCV lgM </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[117]" value="118" id="isi_chk[]" /></td>
                <td>Anti Rubella lgM </td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[118]" value="119" id="isi_chk[]" /></td>
                <td>Widal</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[119]" value="120" id="isi_chk[]" /></td>
                <td>Komplemen C4 </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[120]" value="121" id="isi_chk[]" /></td>
                <td>HBV DNA Kualitatif </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[121]" value="122" id="isi_chk[]" /></td>
                <td>Anti CVM lgG </td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[122]" value="123" id="isi_chk[]" /></td>
                <td>Anti S.Typhi lgM </td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[123]" value="124" id="isi_chk[]" /></td>
                <td>T Helper (CD4) </td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[124]" value="125" id="isi_chk[]" /></td>
                <td>HBV DNA (Real Time PCR)</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[125]" value="126" id="isi_chk[]" /></td>
                <td>Anti CVM lgM </td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[126]" value="127" id="isi_chk[]" /></td>
                <td>Anti Dengue lgG &amp; lgM </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[127]" value="128" id="isi_chk[]" /></td>
                <td>T Soppressor (CD8) </td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input type="checkbox" name="isi_chk[128]" value="129" id="isi_chk[]" /></td>
                <td>HCV RNA Kualitatif </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[129]" value="130" id="isi_chk[]" /></td>
                <td>Anti HSV1 lgG </td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[130]" value="131" id="isi_chk[]" /></td>
                <td>Anti H.Pylori lgG </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[131]" value="132" id="isi_chk[]" /></td>
                <td>ANA</td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input type="checkbox" name="isi_chk[132]" value="133" id="isi_chk[]" /></td>
                <td>HCV RNA (Real Time PCR) </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[133]" value="134" id="isi_chk[]" /></td>
                <td>Anti HSV2 lgM </td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[134]" value="135" id="isi_chk[]" /></td>
                <td>Anti H.Pylori lgM </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[135]" value="136" id="isi_chk[]" /></td>
                <td>Anti ds-DNA </td>
                <td>&nbsp;</td>
                <td>16.</td>
                <td><input type="checkbox" name="isi_chk[136]" value="137" id="isi_chk[]" /></td>
                <td>HCV RNA Genotip </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[137]" value="138" id="isi_chk[]" /></td>
                <td>Anti HSV2 lgG </td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[138]" value="139" id="isi_chk[]" /></td>
                <td>Anti Amoeba (seramoeba) </td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[139]" value="140" id="isi_chk[]" /></td>
                <td>AMA</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[140]" value="141" id="isi_chk[]" /></td>
                <td>Anti HSV2 lgM </td>
              </tr>
              <tr>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[141]" value="142" id="isi_chk[]" /></td>
                <td>Chikungunya </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[142]" value="143" id="isi_chk[]" /></td>
                <td>ACA lgG </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.4 PETANDA TUMOR </strong></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[143]" value="144" id="isi_chk[]" /></td>
                <td>Aviditas Anti Toksoplasma lgG </td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[144]" value="145" id="isi_chk[]" /></td>
                <td>Anti Chlamydia lgG </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[145]" value="146" id="isi_chk[]" /></td>
                <td>ACA lgM </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[146]" value="147" id="isi_chk[]" /></td>
                <td>AFP (Lever) </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input type="checkbox" name="isi_chk[147]" value="148" id="isi_chk[]" /></td>
                <td>Aviditas Anti CMV lgG </td>
              </tr>
              <tr>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[148]" value="149" id="isi_chk[]" /></td>
                <td>Anti Chlamydia IgM </td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input type="checkbox" name="isi_chk[149]" value="150" id="isi_chk[]" /></td>
                <td>SMA</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[150]" value="151" id="isi_chk[]" /></td>
                <td>CEA (Colon) </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>14.</td>
                <td><input type="checkbox" name="isi_chk[151]" value="152" id="isi_chk[]" /></td>
                <td>Anti Tuberkulosis lgG </td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input type="checkbox" name="isi_chk[152]" value="153" id="isi_chk[]" /></td>
                <td>ANCA</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[153]" value="154" id="isi_chk[]" /></td>
                <td>CA 15-3 (Breast) </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.6 ALERGI </strong></td>
                </tr>
              <tr>
                <td>15.</td>
                <td><input type="checkbox" name="isi_chk[154]" value="155" id="isi_chk[]" /></td>
                <td>VDRL/RPR</td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input type="checkbox" name="isi_chk[155]" value="156" id="isi_chk[]" /></td>
                <td>Procalcitonin (PCI) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[156]" value="157" id="isi_chk[]" /></td>
                <td>CA 19-9 (Pankreas) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[157]" value="158" id="isi_chk[]" /></td>
                <td>lg-Total</td>
              </tr>
              <tr>
                <td>16.</td>
                <td><input type="checkbox" name="isi_chk[158]" value="159" id="isi_chk[]" /></td>
                <td>TPHA</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[159]" value="160" id="isi_chk[]" /></td>
                <td>CA 125 (Ovarium) </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[160]" value="161" id="isi_chk[]" /></td>
                <td>lg-E Atopy </td>
              </tr>
              <tr>
                <td>17.</td>
                <td><input type="checkbox" name="isi_chk[161]" value="162" id="isi_chk[]" /></td>
                <td>Anti CCP lgG </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.3 PETANDA HEPATITIS </strong></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[162]" value="163" id="isi_chk[]" /></td>
                <td>CA 72-4 (Gaster) </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[163]" value="164" id="isi_chk[]" /></td>
                <td>lg-E Inhalasi </td>
              </tr>
              <tr>
                <td>18.</td>
                <td><input type="checkbox" name="isi_chk[164]" value="165" id="isi_chk[]" /></td>
                <td>Malaria Rapid </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[165]" value="166" id="isi_chk[]" /></td>
                <td>Anti HAV lgG </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[166]" value="167" id="isi_chk[]" /></td>
                <td>CYFRA 21-1 (Lung) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[167]" value="168" id="isi_chk[]" /></td>
                <td>lg-E Pediatri </td>
              </tr>
              <tr>
                <td>19.</td>
                <td><input type="checkbox" name="isi_chk[168]" value="169" id="isi_chk[]" /></td>
                <td>Anti Dengue lgA </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[169]" value="170" id="isi_chk[]" /></td>
                <td>Anti HAV lgM </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input type="checkbox" name="isi_chk[170]" value="171" id="isi_chk[]" /></td>
                <td>NSE (Neuroblastoma, Lung) </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[171]" value="172" id="isi_chk[]" /></td>
                <td>lg-E South East Asian Food </td>
              </tr>
              <tr>
                <td>20.</td>
                <td><input type="checkbox" name="isi_chk[172]" value="173" id="isi_chk[]" /></td>
                <td>Anti HIV Penyaring </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[173]" value="174" id="isi_chk[]" /></td>
                <td>HBsAg</td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input type="checkbox" name="isi_chk[174]" value="175" id="isi_chk[]" /></td>
                <td>SCC (Lung, Serviks) </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>21.</td>
                <td><input type="checkbox" name="isi_chk[175]" value="176" id="isi_chk[]" /></td>
                <td>Konfirmasi HIV (Western Blot) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input type="checkbox" name="isi_chk[176]" value="177" id="isi_chk[]" /></td>
                <td>HBsAg Kuantitatif </td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input type="checkbox" name="isi_chk[177]" value="178" id="isi_chk[]" /></td>
                <td>PSA Total (Prostat) </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.7 OSTEOPOROSIS </strong></td>
                </tr>
              <tr>
                <td>22.</td>
                <td><input type="checkbox" name="isi_chk[178]" value="179" id="isi_chk[]" /></td>
                <td>Tubex</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input type="checkbox" name="isi_chk[179]" value="180" id="isi_chk[]" /></td>
                <td>HBsAg Konfirmasi </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input type="checkbox" name="isi_chk[180]" value="181" id="isi_chk[]" /></td>
                <td>Free PSA (Prostat) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input type="checkbox" name="isi_chk[181]" value="182" id="isi_chk[]" /></td>
                <td>N-MID Osteocalcin </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input type="checkbox" name="isi_chk[182]" value="183" id="isi_chk[]" /></td>
                <td>Anti HBs </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input type="checkbox" name="isi_chk[183]" value="184" id="isi_chk[]" /></td>
                <td>C-Telopeptide (CTx)</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input type="checkbox" name="isi_chk[184]" value="185" id="isi_chk[]" /></td>
                <td>Anti HBs total </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input type="checkbox" name="isi_chk[185]" value="186" id="isi_chk[]" /></td>
                <td>Isoenzim ALP </td>
              </tr>
              
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right" class="style3">FORM-LAB-01-00</div></td>
  </tr>
</table> 
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  </td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center" colspan="3">
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_noForm','ind')){
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
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
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
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txt_noForm').val(sisip[1]);
			$('#act').val('edit');
			centang(sisip[2]);
			alert(tes);

        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
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
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#form_in').slideDown(1000,function(){
	toggle();
		});
				}

        }

        function batal(){
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#txtId').val('');
			document.form1.reset();
           
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
        a.setHeader("Data Permintaan Pemeriksaan Laboratorium");
        a.setColHeader("NO,NO RM,NO FORMULIR,TGL TERIMA,JAM TERIMA,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("100,150,100,100,100,150,100");
        a.setCellAlign("center,center,center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("permintaan_pemeriksaan_lab_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("permintaan_pemeriksaan_lab.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes)
{
		//var list=tes.split('*=*');
//		var list1 = document.form1.elements['radio[]'];
		var list2 = document.form1.elements['isi_chk[]'];
				 
/*		if ( list1.length > 0 )
		{
		 for (i = 0; i < 41; i++)
			{
			var val=list[0].split(',');	
			var listx = document.form1.elements['radio['+i+']'];
					//alert('radio['+i+']');
			for (j = 0; j < listx.length; j++)
				{
				if (listx[j].value==val[i])
			  		{
			   			listx[j].checked = true;
			  		}
				else
					{
						listx[j].checked = false;
					}	
				}
		  }
		}*/
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			var val=tes.split(',');
			  if (list2[i].value==val[i])
			  {
			   list2[i].checked = true;
			  }else{
					list2[i].checked = false;
					}
		  }
		}
	}
    </script>
    
</html>

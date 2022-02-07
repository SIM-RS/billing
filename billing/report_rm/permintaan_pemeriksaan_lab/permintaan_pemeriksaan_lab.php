<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PERMINTAAN PEMERIKSAAN LAB</title>
<style type="text/css">
<!--
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style3 {font-size: 10px}
-->
</style>
</head>
<?php
include "setting.php";

$sql="select * from b_form_pemeriksaan_lab where id = '$_GET[id]'"; //echo $sql;
$hasil=mysql_query($sql);
$data=mysql_fetch_array($hasil);

$isi_chk=explode(",",$data['isi']);			 
$jumData = count($isi_chk);
//echo $jumData;
//$isi_chk=explode(",",$isi[1]);
?>


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
<body>
<table width="1000" border="0" align="center" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000; font:tahoma">
  <tr>
    <td><div align="right" class="style2">PELAYANAN 24 JAM </div></td>
  </tr>
  <tr>
    <td><table width="96%" border="0" align="center" style="font:12px tahoma">
      <tr>
        <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="61%" height="69"><span class="style2">RS PELINDO I </span></td>
        <td width="39%" rowspan="2"><table width="491" height="181" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
          <tr>
            <td width="98">Nama Pasien</td>
            <td width="121">:
              <?=$dP['nama'];?>            </td>
            <td width="90">&nbsp;</td>
            <td width="114">&nbsp;</td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:
              <?=tglSQL($dP['tgl_lahir']);?>            </td>
            <td>Usia</td>
            <td>:
              <?=$dP['usia'];?>
              Thn</td>
          </tr>
          <tr>
            <td>No. RM</td>
            <td>:
              <?=$dP['no_rm'];?>            </td>
            <td>No Registrasi </td>
            <td>:
              <?=$dP['no_reg2'];?></td>
          </tr>
          <tr>
            <td>Ruang Rawat/Kelas</td>
            <td>:
              <?=$dP['nm_unit'];?>
              /
              <?=$dP['nm_kls'];?>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td colspan="2">:
              <?=$dP['alamat_'];?>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN LABOLATORIUM </span></td>
      </tr>
    </table></td>
      </tr>
      <tr>
        <td>No. Formulir : <?php echo $data['no_formulir'];?> </td>
      </tr>
      <tr>
        <td height="1664"><table width="100%" border="1" style="border-collapse:collapse">
          <tr>
            <td><table width="100%" border="0" style="font:10px tahoma;border-collapse:collapse">
              <tr>
                <td width="50%" rowspan="3" style="border-right:1px solid #000000"><strong>Diagnosis / Keterangan Klinis : <?php echo $diag;?></strong></td>
                <td width="11%"><div align="right"><strong>Diterima Tanggal  </strong></div></td>
				<td width="39%"><strong>: <?php echo $data['tgl_terima']?></strong></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Jam</strong></div></td>
				<td><strong>: <?php echo $data['jam_terima']?></strong></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox2" value="checkbox" <? if($isi_chk[0]=='1') { echo "checked='checked'";}?> />
Biasa</td>
                <td colspan="8"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[1]=='2') { echo "checked='checked'";}?> />
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
                <td width="1%"><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[2]=='3') { echo "checked='checked'";}?> /></td>
                <td width="21%">Darah Rutin <em>(Full Blood Count) </em></td>
                <td width="1%">&nbsp;</td>
                <td width="1%">1.</td>
                <td width="2%"><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[3]=='4') { echo "checked='checked'";}?> /></td>
                <td width="21%">Rumple Leede <em></em></td>
                <td width="1%">&nbsp;</td>
                <td width="1%">1.</td>
                <td width="2%"><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[4]=='5') { echo "checked='checked'";}?> /></td>
                <td width="21%">Sel LE </td>
                <td width="1%">&nbsp;</td>
                <td width="1%">15.</td>
                <td width="2%"><input disabled="disabled" type="checkbox" name="checkbox3222" value="checkbox" <? if($isi_chk[5]=='6') { echo "checked='checked'";}?> /></td>
                <td width="21%">Golongan Darah A, B, O &amp; Rh </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>(Hb, Leko, Diff, Ht, E, Trombo)</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[6]=='7') { echo "checked='checked'";}?> /></td>
                <td>Masa Pendarahan (BT) <em></em></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[7]=='8') { echo "checked='checked'";}?> /></td>
                <td>Malaria Mikroskopis </td>
                <td>&nbsp;</td>
                <td>16.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32222" value="checkbox" <? if($isi_chk[8]=='9') { echo "checked='checked'";}?> /></td>
                <td>Tranferin</td>
              </tr>
              <tr>
                <td><p>2. </p></td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[9]=='10') { echo "checked='checked'";}?> /></td>
                <td>Darah Lengkap <em>(Complete Blood Count) </em></td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[10]=='11') { echo "checked='checked'";}?> /></td>
                <td>Masa Pembekuan (CT) <em></em></td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[11]=='12') { echo "checked='checked'";}?> /></td>
                <td>Mikrofilaria</td>
                <td>&nbsp;</td>
                <td>17.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32223" value="checkbox" <? if($isi_chk[12]=='13') { echo "checked='checked'";}?> /></td>
                <td>IT Ratio </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>(DR, Eri, Ht, MCV, MCH, MCHC, LED)</td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[13]=='14') { echo "checked='checked'";}?> /></td>
                <td>Masa Protombin (PT) &amp; INR <em></em></td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[14]=='15') { echo "checked='checked'";}?> /></td>
                <td>Gambaran Sumsum Tulang </td>
                <td>&nbsp;</td>
                <td>18.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32224" value="checkbox" <? if($isi_chk[15]=='16') { echo "checked='checked'";}?> /></td>
                <td>Crossmatch Mayor/Minor </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[16]=='17') { echo "checked='checked'";}?> /></td>
                <td>Hemoglobin<em></em></td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[17]=='18') { echo "checked='checked'";}?> /></td>
                <td>APTT<em></em></td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[18]=='19') { echo "checked='checked'";}?> /></td>
                <td>Serum Iron (SI)  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[19]=='20') { echo "checked='checked'";}?> /></td>
                <td>Hematokrit<em></em></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[20]=='21') { echo "checked='checked'";}?> /></td>
                <td>Masa Trombin (TT) <em></em></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[21]=='22') { echo "checked='checked'";}?> /></td>
                <td>TIBC </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[22]=='23') { echo "checked='checked'";}?> /></td>
                <td>Eritrosit<em></em></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[23]=='24') { echo "checked='checked'";}?> /></td>
                <td>Fibrinogen<em></em></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[24]=='25') { echo "checked='checked'";}?> /></td>
                <td>Ferritin </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[25]=='26') { echo "checked='checked'";}?> /></td>
                <td>Lekosit<em></em></td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[26]=='27') { echo "checked='checked'";}?> /></td>
                <td>D-Dimer<em></em></td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[27]=='28') { echo "checked='checked'";}?> /></td>
                <td>Vitamin B 12  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[28]=='29') { echo "checked='checked'";}?> /></td>
                <td>Hitung Jenis (Diff Count) <em></em></td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[29]=='30') { echo "checked='checked'";}?> /></td>
                <td>Agregasi Trombosit* <em></em></td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[30]=='31') { echo "checked='checked'";}?> /></td>
                <td>Asam Folat  * </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[31]=='32') { echo "checked='checked'";}?> /></td>
                <td>Trombosit<em></em></td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[32]=='33') { echo "checked='checked'";}?> /></td>
                <td>Viskositas Darah &amp; Plasma <em></em></td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[33]=='34') { echo "checked='checked'";}?> /></td>
                <td>G6 PD Neonatus  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[34]=='35') { echo "checked='checked'";}?> /></td>
                <td>LED (ESR) <em></em></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[35]=='36') { echo "checked='checked'";}?> /></td>
                <td>Protein C <em></em></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[36]=='37') { echo "checked='checked'";}?> /></td>
                <td>G6 PD Eritrosit  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[37]=='38') { echo "checked='checked'";}?> /></td>
                <td>MCV, MCH, MCHC <em></em></td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[38]=='39') { echo "checked='checked'";}?> /></td>
                <td>Protein S <em></em></td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[39]=='40') { echo "checked='checked'";}?> /></td>
                <td>Coomb's Tes  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[40]=='41') { echo "checked='checked'";}?> /></td>
                <td>Gambaran Darah Tepi <em></em></td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[41]=='42') { echo "checked='checked'";}?> /></td>
                <td>Anti Trombin III (AT III) <em></em></td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[42]=='43') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[43]=='44') { echo "checked='checked'";}?> /></td>
                <td>Throbotest/ INR <em></em></td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[44]=='45') { echo "checked='checked'";}?> /></td>
                <td>Antibodi Trombosit </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[45]=='46') { echo "checked='checked'";}?> /></td>
                <td>Retikolusit<em></em></td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32" value="checkbox" <? if($isi_chk[46]=='47') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[47]=='48') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[48]=='49') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[49]=='50') { echo "checked='checked'";}?> /></td>
                <td>SGOT/AST<em></em></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[50]=='51') { echo "checked='checked'";}?> /></td>
                <td>CK-MD</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[51]=='52') { echo "checked='checked'";}?> /></td>
                <td>Ureum</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[52]=='53') { echo "checked='checked'";}?> /></td>
                <td>Elektrolit (Na,K,Cl) </td>
              </tr>
              <tr>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[53]=='54') { echo "checked='checked'";}?> /></td>
                <td>SGPT/ALT</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[54]=='55') { echo "checked='checked'";}?> /></td>
                <td>LDH</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[55]=='56') { echo "checked='checked'";}?> /></td>
                <td>Kreatin</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[56]=='57') { echo "checked='checked'";}?> /></td>
                <td>Kalsium Total </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[57]=='58') { echo "checked='checked'";}?> /></td>
                <td>Gamma GT (GGT) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[58]=='59') { echo "checked='checked'";}?> /></td>
                <td>HBDH</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[59]=='60') { echo "checked='checked'";}?> /></td>
                <td>Asam Urat </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[60]=='61') { echo "checked='checked'";}?> /></td>
                <td>Kalsium Ion </td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[61]=='62') { echo "checked='checked'";}?> /></td>
                <td>Fosfatase Alkali </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[62]=='63') { echo "checked='checked'";}?> /></td>
                <td>Troponin T </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[63]=='64') { echo "checked='checked'";}?> /></td>
                <td>Urea Clearance </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[64]=='65') { echo "checked='checked'";}?> /></td>
                <td>Fostor Anorganik </td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[65]=='66') { echo "checked='checked'";}?> /></td>
                <td>Total Protein - Albumin - Globumin </td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[66]=='67') { echo "checked='checked'";}?> /></td>
                <td>hs-CRP</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[67]=='68') { echo "checked='checked'";}?> /></td>
                <td>Creatinin Clearance** </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[68]=='69') { echo "checked='checked'";}?> /></td>
                <td>Magnesium</td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[69]=='70') { echo "checked='checked'";}?> /></td>
                <td>Bilirubin Total - Direk - Indirek </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[70]=='71') { echo "checked='checked'";}?> /></td>
                <td>Homosistein</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[71]=='72') { echo "checked='checked'";}?> /></td>
                <td>Analisa Gas Darah </td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[72]=='73') { echo "checked='checked'";}?> /></td>
                <td>Bilirubin Neonatus </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[73]=='74') { echo "checked='checked'";}?> /></td>
                <td>NT-Pro BNP </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II. DIABETES </strong></td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[74]=='75') { echo "checked='checked'";}?> /></td>
                <td>CO2 Total </td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[75]=='76') { echo "checked='checked'";}?> /></td>
                <td>Protein Elektroforesta </td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[76]=='77') { echo "checked='checked'";}?> /></td>
                <td>Glukosa Sewaktu </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[77]=='78') { echo "checked='checked'";}?> /></td>
                <td>Osmolaritas Darah </td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[78]=='79') { echo "checked='checked'";}?> /></td>
                <td>Albumin</td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II.3 LEMAK </strong></td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[79]=='80') { echo "checked='checked'";}?> /></td>
                <td>Glukosa Puasa* </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[80]=='81') { echo "checked='checked'";}?> /></td>
                <td>Cholinesterase (CHE) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[81]=='82') { echo "checked='checked'";}?> /></td>
                <td>Kolesterol Total </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[82]=='83') { echo "checked='checked'";}?> /></td>
                <td>Glukosa 2 Jam PP </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>II.7 PANKREAS </strong></td>
                </tr>
              <tr>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[83]=='84') { echo "checked='checked'";}?> /></td>
                <td>Asam Empedu (Bile Acid) * </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[84]=='85') { echo "checked='checked'";}?> /></td>
                <td>HDL Kolesterol Direk </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[85]=='86') { echo "checked='checked'";}?> /></td>
                <td>Glukosa Kurva Harian* </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[86]=='87') { echo "checked='checked'";}?> /></td>
                <td>Amilase</td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[87]=='88') { echo "checked='checked'";}?> /></td>
                <td>GLDH</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[88]=='89') { echo "checked='checked'";}?> /></td>
                <td>LDL Kolesterol Direk </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[89]=='90') { echo "checked='checked'";}?> /></td>
                <td>Gliko Hb/HbA1C </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3223" value="checkbox" <? if($isi_chk[90]=='91') { echo "checked='checked'";}?> /></td>
                <td>Lipase</td>
              </tr>
              <tr>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[91]=='92') { echo "checked='checked'";}?> /></td>
                <td>Amonia</td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[92]=='93') { echo "checked='checked'";}?> /></td>
                <td>Trigliserid*</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[93]=='94') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[94]=='95') { echo "checked='checked'";}?> /></td>
                <td>Apo-A1*</td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[95]=='96') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[96]=='97') { echo "checked='checked'";}?> /></td>
                <td>Apo B* </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[97]=='98') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[98]=='99') { echo "checked='checked'";}?> /></td>
                <td>Small-Dense LDL* </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322" value="checkbox" <? if($isi_chk[99]=='100') { echo "checked='checked'";}?> /></td>
                <td>GTT/TTGO</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="21">1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[100]=='101') { echo "checked='checked'";}?> /></td>
                <td>CK/CPK</td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[101]=='102') { echo "checked='checked'";}?> /></td>
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
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[102]=='103') { echo "checked='checked'";}?> /></td>
                <td>ASTO</td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[103]=='104') { echo "checked='checked'";}?> /></td>
                <td>lg-A</td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3224" value="checkbox" <? if($isi_chk[104]=='105') { echo "checked='checked'";}?> /></td>
                <td>Anti HBeAg </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221529" value="checkbox" <? if($isi_chk[105]=='106') { echo "checked='checked'";}?> /></td>
                <td>Anti Toksoplasma lgG </td>
              </tr>
              <tr>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[106]=='107') { echo "checked='checked'";}?> /></td>
                <td>RF</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[107]=='108') { echo "checked='checked'";}?> /></td>
                <td>lg-G</td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3225" value="checkbox" <? if($isi_chk[108]=='109') { echo "checked='checked'";}?> /></td>
                <td>Anti HBe </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221528" value="checkbox" <? if($isi_chk[109]=='110') { echo "checked='checked'";}?> /></td>
                <td>Anti Toksoplasma lgM </td>
              </tr>
              <tr>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[110]=='111') { echo "checked='checked'";}?> /></td>
                <td>CRP</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[111]=='112') { echo "checked='checked'";}?> /></td>
                <td>lg-M</td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3226" value="checkbox" <? if($isi_chk[112]=='113') { echo "checked='checked'";}?> /></td>
                <td>Anti HCV Total </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221527" value="checkbox" <? if($isi_chk[113]=='114') { echo "checked='checked'";}?> /></td>
                <td>Anti Rubella lgG </td>
              </tr>
              <tr>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[114]=='115') { echo "checked='checked'";}?> /></td>
                <td>Ns 1 Ag Dengue </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[115]=='116') { echo "checked='checked'";}?> /></td>
                <td>Komplemen C3 </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3227" value="checkbox" <? if($isi_chk[116]=='117') { echo "checked='checked'";}?> /></td>
                <td>Anti HCV lgM </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221526" value="checkbox" <? if($isi_chk[117]=='118') { echo "checked='checked'";}?> /></td>
                <td>Anti Rubella lgM </td>
              </tr>
              <tr>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[118]=='119') { echo "checked='checked'";}?> /></td>
                <td>Widal</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[119]=='120') { echo "checked='checked'";}?> /></td>
                <td>Komplemen C4 </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3228" value="checkbox" <? if($isi_chk[120]=='121') { echo "checked='checked'";}?> /></td>
                <td>HBV DNA Kualitatif </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221525" value="checkbox" <? if($isi_chk[121]=='122') { echo "checked='checked'";}?> /></td>
                <td>Anti CVM lgG </td>
              </tr>
              <tr>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[122]=='123') { echo "checked='checked'";}?> /></td>
                <td>Anti S.Typhi lgM </td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[123]=='124') { echo "checked='checked'";}?> /></td>
                <td>T Helper (CD4) </td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3229" value="checkbox" <? if($isi_chk[124]=='125') { echo "checked='checked'";}?> /></td>
                <td>HBV DNA (Real Time PCR)</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221524" value="checkbox" <? if($isi_chk[125]=='126') { echo "checked='checked'";}?> /></td>
                <td>Anti CVM lgM </td>
              </tr>
              <tr>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[126]=='127') { echo "checked='checked'";}?> /></td>
                <td>Anti Dengue lgG &amp; lgM </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[127]=='128') { echo "checked='checked'";}?> /></td>
                <td>T Soppressor (CD8) </td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32210" value="checkbox" <? if($isi_chk[128]=='129') { echo "checked='checked'";}?> /></td>
                <td>HCV RNA Kualitatif </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221523" value="checkbox" <? if($isi_chk[129]=='130') { echo "checked='checked'";}?> /></td>
                <td>Anti HSV1 lgG </td>
              </tr>
              <tr>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[130]=='131') { echo "checked='checked'";}?> /></td>
                <td>Anti H.Pylori lgG </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[131]=='132') { echo "checked='checked'";}?> /></td>
                <td>ANA</td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32211" value="checkbox" <? if($isi_chk[132]=='133') { echo "checked='checked'";}?> /></td>
                <td>HCV RNA (Real Time PCR) </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221522" value="checkbox" <? if($isi_chk[133]=='134') { echo "checked='checked'";}?> /></td>
                <td>Anti HSV2 lgM </td>
              </tr>
              <tr>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[134]=='135') { echo "checked='checked'";}?> /></td>
                <td>Anti H.Pylori lgM </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[135]=='136') { echo "checked='checked'";}?> /></td>
                <td>Anti ds-DNA </td>
                <td>&nbsp;</td>
                <td>16.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32212" value="checkbox" <? if($isi_chk[136]=='137') { echo "checked='checked'";}?> /></td>
                <td>HCV RNA Genotip </td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221521" value="checkbox" <? if($isi_chk[137]=='138') { echo "checked='checked'";}?> /></td>
                <td>Anti HSV2 lgG </td>
              </tr>
              <tr>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[138]=='139') { echo "checked='checked'";}?> /></td>
                <td>Anti Amoeba (seramoeba) </td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[139]=='140') { echo "checked='checked'";}?> /></td>
                <td>AMA</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221520" value="checkbox" <? if($isi_chk[140]=='141') { echo "checked='checked'";}?> /></td>
                <td>Anti HSV2 lgM </td>
              </tr>
              <tr>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[141]=='142') { echo "checked='checked'";}?> /></td>
                <td>Chikungunya </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[142]=='143') { echo "checked='checked'";}?> /></td>
                <td>ACA lgG </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.4 PETANDA TUMOR </strong></td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221519" value="checkbox" <? if($isi_chk[143]=='144') { echo "checked='checked'";}?> /></td>
                <td>Aviditas Anti Toksoplasma lgG </td>
              </tr>
              <tr>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[144]=='145') { echo "checked='checked'";}?> /></td>
                <td>Anti Chlamydia lgG </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[145]=='146') { echo "checked='checked'";}?> /></td>
                <td>ACA lgM </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32213" value="checkbox" <? if($isi_chk[146]=='147') { echo "checked='checked'";}?> /></td>
                <td>AFP (Lever) </td>
                <td>&nbsp;</td>
                <td>12.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221518" value="checkbox" <? if($isi_chk[147]=='148') { echo "checked='checked'";}?> /></td>
                <td>Aviditas Anti CMV lgG </td>
              </tr>
              <tr>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[148]=='149') { echo "checked='checked'";}?> /></td>
                <td>Anti Chlamydia IgM </td>
                <td>&nbsp;</td>
                <td>13.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[149]=='150') { echo "checked='checked'";}?> /></td>
                <td>SMA</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32214" value="checkbox" <? if($isi_chk[150]=='151') { echo "checked='checked'";}?> /></td>
                <td>CEA (Colon) </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>14.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[151]=='152') { echo "checked='checked'";}?> /></td>
                <td>Anti Tuberkulosis lgG </td>
                <td>&nbsp;</td>
                <td>14.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[152]=='153') { echo "checked='checked'";}?> /></td>
                <td>ANCA</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox32215" value="checkbox" <? if($isi_chk[153]=='154') { echo "checked='checked'";}?> /></td>
                <td>CA 15-3 (Breast) </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.6 ALERGI </strong></td>
                </tr>
              <tr>
                <td>15.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[154]=='155') { echo "checked='checked'";}?> /></td>
                <td>VDRL/RPR</td>
                <td>&nbsp;</td>
                <td>15.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[155]=='156') { echo "checked='checked'";}?> /></td>
                <td>Procalcitonin (PCI) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322152" value="checkbox" <? if($isi_chk[156]=='157') { echo "checked='checked'";}?> /></td>
                <td>CA 19-9 (Pankreas) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221517" value="checkbox" <? if($isi_chk[157]=='158') { echo "checked='checked'";}?> /></td>
                <td>lg-Total</td>
              </tr>
              <tr>
                <td>16.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[158]=='159') { echo "checked='checked'";}?> /></td>
                <td>TPHA</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322153" value="checkbox" <? if($isi_chk[159]=='160') { echo "checked='checked'";}?> /></td>
                <td>CA 125 (Ovarium) </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221516" value="checkbox" <? if($isi_chk[160]=='161') { echo "checked='checked'";}?> /></td>
                <td>lg-E Atopy </td>
              </tr>
              <tr>
                <td>17.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[161]=='162') { echo "checked='checked'";}?> /></td>
                <td>Anti CCP lgG </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.3 PETANDA HEPATITIS </strong></td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322154" value="checkbox" <? if($isi_chk[162]=='163') { echo "checked='checked'";}?> /></td>
                <td>CA 72-4 (Gaster) </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221515" value="checkbox" <? if($isi_chk[163]=='164') { echo "checked='checked'";}?> /></td>
                <td>lg-E Inhalasi </td>
              </tr>
              <tr>
                <td>18.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[164]=='165') { echo "checked='checked'";}?> /></td>
                <td>Malaria Rapid </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[165]=='166') { echo "checked='checked'";}?> /></td>
                <td>Anti HAV lgG </td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322155" value="checkbox" <? if($isi_chk[166]=='167') { echo "checked='checked'";}?> /></td>
                <td>CYFRA 21-1 (Lung) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221514" value="checkbox" <? if($isi_chk[167]=='168') { echo "checked='checked'";}?> /></td>
                <td>lg-E Pediatri </td>
              </tr>
              <tr>
                <td>19.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[168]=='169') { echo "checked='checked'";}?> /></td>
                <td>Anti Dengue lgA </td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[169]=='170') { echo "checked='checked'";}?> /></td>
                <td>Anti HAV lgM </td>
                <td>&nbsp;</td>
                <td>8.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322156" value="checkbox" <? if($isi_chk[170]=='171') { echo "checked='checked'";}?> /></td>
                <td>NSE (Neuroblastoma, Lung) </td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221513" value="checkbox" <? if($isi_chk[171]=='172') { echo "checked='checked'";}?> /></td>
                <td>lg-E South East Asian Food </td>
              </tr>
              <tr>
                <td>20.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[172]=='173') { echo "checked='checked'";}?> /></td>
                <td>Anti HIV Penyaring </td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[173]=='174') { echo "checked='checked'";}?> /></td>
                <td>HBsAg</td>
                <td>&nbsp;</td>
                <td>9.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322157" value="checkbox" <? if($isi_chk[174]=='175') { echo "checked='checked'";}?> /></td>
                <td>SCC (Lung, Serviks) </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>21.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[175]=='176') { echo "checked='checked'";}?> /></td>
                <td>Konfirmasi HIV (Western Blot) </td>
                <td>&nbsp;</td>
                <td>4.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[176]=='177') { echo "checked='checked'";}?> /></td>
                <td>HBsAg Kuantitatif </td>
                <td>&nbsp;</td>
                <td>10.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322158" value="checkbox" <? if($isi_chk[177]=='178') { echo "checked='checked'";}?> /></td>
                <td>PSA Total (Prostat) </td>
                <td>&nbsp;</td>
                <td colspan="3" bgcolor="#CCCCCC"><strong>III.7 OSTEOPOROSIS </strong></td>
                </tr>
              <tr>
                <td>22.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[178]=='179') { echo "checked='checked'";}?> /></td>
                <td>Tubex</td>
                <td>&nbsp;</td>
                <td>5.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[179]=='180') { echo "checked='checked'";}?> /></td>
                <td>HBsAg Konfirmasi </td>
                <td>&nbsp;</td>
                <td>11.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox322159" value="checkbox" <? if($isi_chk[180]=='181') { echo "checked='checked'";}?> /></td>
                <td>Free PSA (Prostat) </td>
                <td>&nbsp;</td>
                <td>1.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221510" value="checkbox" <? if($isi_chk[181]=='182') { echo "checked='checked'";}?> /></td>
                <td>N-MID Osteocalcin </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>6.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[182]=='183') { echo "checked='checked'";}?> /></td>
                <td>Anti HBs </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>2.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221511" value="checkbox" <? if($isi_chk[183]=='184') { echo "checked='checked'";}?> /></td>
                <td>C-Telopeptide (CTx)</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>7.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox33" value="checkbox" <? if($isi_chk[184]=='185') { echo "checked='checked'";}?> /></td>
                <td>Anti HBs total </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>3.</td>
                <td><input disabled="disabled" type="checkbox" name="checkbox3221512" value="checkbox" <? if($isi_chk[185]=='186') { echo "checked='checked'";}?> /></td>
                <td>Isoenzim ALP </td>
              </tr>
              
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
    <td><div align="center"><span class="noline">
      <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print/Cetak" />
      <input name="button" type="button" id="btnTutup" onclick="tutup();" value="Tutup"/>
    </span></div></td>
  </tr>
  <tr>
    <td><div align="right" class="style3">FORM-LAB-01-00</div></td>
  </tr>
</table>
</body>

<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Cetak permintaan Pemeriksaan Lab  ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>

</html>

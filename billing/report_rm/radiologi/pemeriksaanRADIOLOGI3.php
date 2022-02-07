<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pemeriksaan Radiologi 3</title>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
.style2 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<?
include "setting.php";

$sql="select * from b_form_radiologi_3 where id = '$_GET[id]'"; //echo $sql;
$hasil=mysql_query($sql);
$data=mysql_fetch_array($hasil);

$sql21="SELECT b.id, b.nama FROM b_pelayanan a
INNER JOIN b_ms_pegawai b ON a.dokter_id = b.id
WHERE a.pasien_id = $id_pasien AND unit_id = 61 
ORDER BY id DESC
LIMIT 1"; //echo $sql;
$hasil21=mysql_query($sql21);
$data21=mysql_fetch_array($hasil21);

$isi_chk=explode(",",$data['isi']);			 
$jumData = count($isi_chk);
//echo $jumData;
//$isi_chk=explode(",",$isi[1]);
?>
<body><table width="847" border="0" style="border-collapse:collapse; font:12px tahoma ">
  <tr>
    <td width="841" height="134"><table width="99%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="53%" height="69"><span class="style1">RS PELINDO I </span></td>
        <td width="47%" rowspan="2"><table width="100%" border="0" style="border:1px solid #000000; font:12px tahoma">
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
            <td>No. registrasi: &nbsp;<? echo $noreg1;?></td>
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
            <td height="40" colspan="4"><div align="center">(Tempelkan Stiker Identitas Pasien) </div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN RADIOLOGI 3 </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="99%" border="0" style="border:1px solid #000000; font:12px tahoma">
      <tr>
        <td><table width="99%" border="0">
          <tr>
            <td height="30">Nama Dokter Pengirim </td>
            <td>: <?php echo $data21['nama'];?></td>
            <td style="border:1px solid #000000">No. Formulir : <?php echo $data['no_formulir']?></td>
          </tr>
          <tr>
            <td>Permohonan yang diminta harap dicentang</td>
            <td colspan="2">: 
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[0]=='1') { echo "checked='checked'";}?> />
              Biasa&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[1]=='2') { echo "checked='checked'";}?> />
              Cito&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[2]=='3') { echo "checked='checked'";}?> />
			  Hasil Diserahkan Ke Dokter&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[3]=='4') { echo "checked='checked'";}?> />
			  Hasil Diserahkan ke Pasien</td>
            </tr>
          
          <tr>
            <td>Diagnosa / Keterangan Klinik </td>
            <td>: <?php echo $diag?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><em><strong>M R I (MAGNETIC RESONANCE IMAGING) </strong></em></td>
          </tr>
          <tr>
            <td>
              <div align="center">
                <input disabled="disabled" type="checkbox" name="checkbox2" value="checkbox" <? if($isi_chk[4]=='5') { echo "checked='checked'";}?> />
                <strong>CONTRAS</strong></div></td>
            <td colspan="2">
              <div align="center">
                <input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[5]=='6') { echo "checked='checked'";}?> />
                <strong>NON CONTRAS </strong></div></td>
            </tr>
          <tr>
            <td width="33%"><strong>CRANIUM</strong></td>
            <td width="34%"></td>
            <td width="33%"></td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[6]=='7') { echo "checked='checked'";}?> />
              MRI Brain/Neurocranium </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[7]=='8') { echo "checked='checked'";}?> /> 
              MRI Temporallobe (Epilepsi) </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[8]=='9') { echo "checked='checked'";}?> /> 
              MRI Spetriscopy </td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[9]=='10') { echo "checked='checked'";}?> /> 
              MRI Hipofise           </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[10]=='11') { echo "checked='checked'";}?> /> 
              MRI Cochlea/IAC           </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[11]=='12') { echo "checked='checked'";}?> /> 
              MRI Perfusion </td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[12]=='13') { echo "checked='checked'";}?> /> 
              MRI Dynamic Hipofise </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[13]=='14') { echo "checked='checked'";}?> /> 
              MRI Brain Mapping/Functional          </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[14]=='15') { echo "checked='checked'";}?> /> 
              MRI Orbita </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[15]=='16') { echo "checked='checked'";}?> /> 
              MRI Tractography/DTI </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>NECK</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[16]=='17') { echo "checked='checked'";}?> />
MRI Sinus Paranasal </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[17]=='18') { echo "checked='checked'";}?> />
              MRI TMJ </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[18]=='19') { echo "checked='checked'";}?> />
              MRI Parotis </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[19]=='20') { echo "checked='checked'";}?> /> 
              MRI Nasopharynx </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[20]=='21') { echo "checked='checked'";}?> />
              MRI Larynx </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[21]=='22') { echo "checked='checked'";}?> />
              MRI Larynx </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[22]=='23') { echo "checked='checked'";}?> />
              MRI Salvilary Gland </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[23]=='24') { echo "checked='checked'";}?> />
              MRI Thyroid </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[24]=='25') { echo "checked='checked'";}?> />
              MRI Thyroid </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>THORAX</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[25]=='26') { echo "checked='checked'";}?> />
              MRI Mediastium </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[26]=='27') { echo "checked='checked'";}?> />
              MRI Breast </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[27]=='28') { echo "checked='checked'";}?> />
              MRI Dynamic Breast </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>SPINE</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[28]=='29') { echo "checked='checked'";}?> /> 
              MRI Cervinal </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[29]=='30') { echo "checked='checked'";}?> /> 
              MRI Lumbosacral </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[30]=='31') { echo "checked='checked'";}?> />
              MRI Whole Spine Sagital T2 </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[31]=='32') { echo "checked='checked'";}?> /> 
              MRI Thoracal </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[32]=='33') { echo "checked='checked'";}?> />
              MRI Sacral/Coccygeus </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[33]=='34') { echo "checked='checked'";}?> />
              MRI Whole Spine </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>ABDOMEN + PELVIS </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[34]=='35') { echo "checked='checked'";}?> /> 
              MRI Upper Abdomen </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[35]=='36') { echo "checked='checked'";}?> />
              MRI Whole Abdomen </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[36]=='37') { echo "checked='checked'";}?> />
              MRI Whole Body Diffusion </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[37]=='38') { echo "checked='checked'";}?> /> 
              MRI Lower Abdomen (Pelvis) </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[38]=='39') { echo "checked='checked'";}?> />
              MRCP (Cholangiopancreaticogram) </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[39]=='40') { echo "checked='checked'";}?> />
              MRI Dynamic Hepar </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>MUSCULOSKELETAL</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[40]=='41') { echo "checked='checked'";}?> /> 
              MRI Shoulder Dextra/Sinistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[41]=='42') { echo "checked='checked'";}?> />
              MRI Wrist Dwxtra/Smistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[42]=='43') { echo "checked='checked'";}?> />
              MRI Cruris Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[43]=='44') { echo "checked='checked'";}?> /> 
              MRI Humerus Dextra/Sinistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[44]=='45') { echo "checked='checked'";}?> />
              MRI Manus Dextra/Sinistra</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[45]=='46') { echo "checked='checked'";}?> />
              MRI Ankle Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[46]=='47') { echo "checked='checked'";}?> /> 
              MRI Elbow Dextra/Sinistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[47]=='48') { echo "checked='checked'";}?> />
              MRI Hip Dextra/Sinistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[48]=='49') { echo "checked='checked'";}?> />
              MRI Pedis Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[49]=='50') { echo "checked='checked'";}?> /> 
              MRI Antebrachi Dextra/Sinistra </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[50]=='51') { echo "checked='checked'";}?> />
              MRI Femur Dextra/Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>ANGIOGRAPHY</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[51]=='52') { echo "checked='checked'";}?> /> 
              MRA Brain/Neurocranium
</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[52]=='53') { echo "checked='checked'";}?> />
              MRI + MRA Spectroscopy Brain </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[53]=='54') { echo "checked='checked'";}?> />
              MRA Upper Extremitas </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[54]=='55') { echo "checked='checked'";}?> /> 
              MRV Brain/Neurocranium
</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[55]=='56') { echo "checked='checked'";}?> />
              MRI + MRA + MRV Brain </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox4" value="checkbox" <? if($isi_chk[56]=='57') { echo "checked='checked'";}?> />
MRA Lower Extremitas </td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[57]=='58') { echo "checked='checked'";}?> />
              MRA Carotis </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[58]=='59') { echo "checked='checked'";}?> />
              MRA Abdominal </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[59]=='60') { echo "checked='checked'";}?> />
              MRI + MRA Brain </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[60]=='61') { echo "checked='checked'";}?> />
              MRA Renal </td>
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
        <td height="171"><table width="99%" border="0">
          <tr>
            <td width="30%" rowspan="5"><table width="99%" border="0">
              <tr>
                <td height="74"><table width="85%" border="0" style=" border:1px solid #000000; font:10px tahoma">
                    <tr>
                      <td><div align="center">TIDAK HAMIL </div></td>
                    </tr>
                    <tr>
                      <td height="33"><div align="center"></div></td>
                    </tr>
                    <tr>
                      <td height="14"><div align="center">(&nbsp;<? echo $nama;?>&nbsp;)</div></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="83"><table width="85%" border="0" style="border:1px solid #000000; font:10px tahoma" >
                  <tr>
                    <td width="48%">Administrasi</td>
                    <td width="52%">:</td>
                  </tr>
                  <tr>
                    <td>Radiologi</td>
                    <td>:</td>
                  </tr>
                  <tr>
                    <td>KV</td>
                    <td>:</td>
                  </tr>
                  <tr>
                    <td>mAs</td>
                    <td>:</td>
                  </tr>
                  <tr>
                    <td>Dr. Radiologi </td>
                    <td>:</td>
                  </tr>
                  <tr>
                    <td height="14">Hasil Radiologi </td>
                    <td>:</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="37%" rowspan="5">&nbsp;</td>
            <td width="33%">Medan, <?=tgl_ina(date('Y-m-d'));?> </td>
          </tr>
          <tr>
            <td>Pukul : <?=date('h:i:s');?></td>
          </tr>
          <tr>
            <td height="16"><div align="center">Dokter Pengirim, </div></td>
          </tr>
          <tr>
            <td height="62">&nbsp;</td>
          </tr>
          <tr>
            <td height="35"><div align="center">(
              <?php echo $data21['nama'];?>
              )</div></td>
          </tr>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right">FORM-RAD-03-00</div></td>
  </tr>
  <tr>
    <td align="center"><input type="button" name="cetak" id="cetak" value="Cetak" onclick="window.print() " /></td>
  </tr>
</table>

</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pemeriksaan Radiologi 1</title>
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

$sql="select * from b_form_radiologi_1 where id = '$_GET[id]'"; //echo $sql;
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
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN RADIOLOGI 1 </span></td>
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
            <td width="33%"><strong>FLUOROSKOPI</strong></td>
            <td width="34%"></td>
            <td width="33%"></td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[4]=='5') { echo "checked='checked'";}?> />
              Oesophagography</td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[5]=='6') { echo "checked='checked'";}?> /> 
              BNO IVP </span></td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[6]=='7') { echo "checked='checked'";}?> /> 
              Philebography Dex/Sin</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[7]=='8') { echo "checked='checked'";}?> /> 
              OMD            </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[8]=='9') { echo "checked='checked'";}?> /> 
              Cystography            </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[9]=='10') { echo "checked='checked'";}?> /> 
              Myelography</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[10]=='11') { echo "checked='checked'";}?> /> 
              Follow through            </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[11]=='12') { echo "checked='checked'";}?> /> 
              Uretrography            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[12]=='13') { echo "checked='checked'";}?> /> 
              Colon in loop            </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[13]=='14') { echo "checked='checked'";}?> /> 
              HSG            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[14]=='15') { echo "checked='checked'";}?> /> 
              Appendicogram            </td>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[15]=='16') { echo "checked='checked'";}?> /> 
              Fistulography            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>KONVENTIONAL</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[16]=='17') { echo "checked='checked'";}?> />
Thorax AP/PA </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[17]=='18') { echo "checked='checked'";}?> />
              Cervinal AP / Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[18]=='19') { echo "checked='checked'";}?> />
              Wrist Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[19]=='20') { echo "checked='checked'";}?> /> 
              Thorax Lateral</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[20]=='21') { echo "checked='checked'";}?> />
              Carvinal AP / Lat / Oblu </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[21]=='22') { echo "checked='checked'";}?> />
              Manus Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[22]=='23') { echo "checked='checked'";}?> />
              Thorax AP/Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[23]=='24') { echo "checked='checked'";}?> />
              Odontoid</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[24]=='25') { echo "checked='checked'";}?> />
              Digiti Manus.............Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[25]=='26') { echo "checked='checked'";}?> />
              Thorax Top Lordotik</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[26]=='27') { echo "checked='checked'";}?> />
              Cervicothoracal AP / Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[27]=='28') { echo "checked='checked'";}?> />
              Hip Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[28]=='29') { echo "checked='checked'";}?> /> 
              Sternum</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[29]=='30') { echo "checked='checked'";}?> /> 
              Thoracal AP / Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[30]=='31') { echo "checked='checked'";}?> />
              Hip Joint Frog </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[31]=='32') { echo "checked='checked'";}?> /> 
              Costae</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[32]=='33') { echo "checked='checked'";}?> />
              Thoracal AP / Lat / Obl </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[33]=='34') { echo "checked='checked'";}?> />
              Femur Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[34]=='35') { echo "checked='checked'";}?> /> 
              BNO</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[35]=='36') { echo "checked='checked'";}?> />
              Thoracolumbal AP / Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[36]=='37') { echo "checked='checked'";}?> />
              Genu Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[37]=='38') { echo "checked='checked'";}?> /> 
              BNO Lateral</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[38]=='39') { echo "checked='checked'";}?> />
              Lumbosacral AP/ Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[39]=='40') { echo "checked='checked'";}?> />
              Patella</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[40]=='41') { echo "checked='checked'";}?> /> 
              Abdomen 2 Posisi              </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[41]=='42') { echo "checked='checked'";}?> />
              Lumbosacral AP / LAt / Obt </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[42]=='43') { echo "checked='checked'";}?> />
              Crusis Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[43]=='44') { echo "checked='checked'";}?> /> 
              Abdomen 3 Posisi</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[44]=='45') { echo "checked='checked'";}?> />
              Sacral cocygeus AP / Lat </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[45]=='46') { echo "checked='checked'";}?> />
              Ankle Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[46]=='47') { echo "checked='checked'";}?> /> 
              Pelvis AP</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[47]=='48') { echo "checked='checked'";}?> />
              Program Scoliosis 2 Posisi  </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[48]=='49') { echo "checked='checked'";}?> />
              Calcaneus Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[49]=='50') { echo "checked='checked'";}?> /> 
              Pelvis AP/Lat</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[50]=='51') { echo "checked='checked'";}?> />
              Program Scoliosis 5 Posisi </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[51]=='52') { echo "checked='checked'";}?> />
              Pedis Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[52]=='53') { echo "checked='checked'";}?> />
Cranium </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[53]=='54') { echo "checked='checked'";}?> />
              Vertebra Flexi </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[54]=='55') { echo "checked='checked'";}?> />
              Digiti Pedis................. Dextra / Sinistra </td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[55]=='56') { echo "checked='checked'";}?> />
Os Nasal </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[56]=='57') { echo "checked='checked'";}?> />
              Vertebra Extensi </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[57]=='58') { echo "checked='checked'";}?> />
              Sinus Paranasal              </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[58]=='59') { echo "checked='checked'";}?> />
              Clavicula Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[59]=='60') { echo "checked='checked'";}?> />
              Orbita</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[60]=='61') { echo "checked='checked'";}?> />
              Skapula Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[61]=='62') { echo "checked='checked'";}?> />
              TMj</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[62]=='63') { echo "checked='checked'";}?> />
              Shoulder Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[63]=='64') { echo "checked='checked'";}?> />
              Mandibula</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[64]=='65') { echo "checked='checked'";}?> />
              Homerus Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[65]=='66') { echo "checked='checked'";}?> />
              Os zygomaticum </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[66]=='67') { echo "checked='checked'";}?> />
              Elbow Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[67]=='68') { echo "checked='checked'";}?> />
              Mastoid</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[68]=='69') { echo "checked='checked'";}?> />
              Antebrachi Dextra / Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>MOBILE X-RAY </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[69]=='70') { echo "checked='checked'";}?> />
              Thorax AP (Mobile) </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[70]=='71') { echo "checked='checked'";}?> />
              Abdomen baby 2 Posisi (Mobile) </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>C-ARM</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[71]=='72') { echo "checked='checked'";}?> />
              C-Arm</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[72]=='73') { echo "checked='checked'";}?> />
              Contrast C-Arm </td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[73]=='74') { echo "checked='checked'";}?> />
              Film C-Arm </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>PANORAMIC &amp; DENTAL X-RAY </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[74]=='75') { echo "checked='checked'";}?> />
              Panoramic</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[75]=='76') { echo "checked='checked'";}?> />
              Cephalometric</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[76]=='77') { echo "checked='checked'";}?> />
              Dental</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>MAMMOGRAPHY</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[77]=='78') { echo "checked='checked'";}?> />
              Mammography</td>
            <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[78]=='79') { echo "checked='checked'";}?> />
              Ductulography</td>
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
    <td><div align="right">FORM-RAD-01-00</div></td>
  </tr>
  <tr>
    <td align="center"><input type="button" name="cetak" id="cetak" value="Cetak" onclick="window.print() " /></td>
  </tr>
</table>

</body>
</html>

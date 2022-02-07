<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pemeriksaan Radiologi 2</title>
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

$sql="select * from b_form_radiologi_2 where id = '$_GET[id]'"; //echo $sql;
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
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN RADIOLOGI 2</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="99%" border="0" style="border:1px solid #000000; font:12px tahoma">
      <tr>
        <td><table width="99%" border="0">
          <tr>
            <td height="30">Nama Dokter Pengirim : <?php echo $data21['nama'];?></td>
            <td>&nbsp;</td>
            <td style="border:1px solid #000000">No. Formulir : <?php echo $data['no_formulir']?></td>
          </tr>
          <tr>
            <td colspan="3">Permohonan yang diminta harap dicentang 
              :
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[0]=='1') { echo "checked='checked'";}?> />
              Cito&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[1]=='2') { echo "checked='checked'";}?> />
              Biasa&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[2]=='3') { echo "checked='checked'";}?> />
              Hasil Diserahkan Ke Dokter&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[3]=='4') { echo "checked='checked'";}?> />
			  Hasil Diserahkan ke Pasien</td>
            </tr>
          
          <tr>
            <td>Diagnosa / Keterangan Klinik : <?php echo $diag?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>MSCT SCAN </strong></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td width="49%"><strong>GENERAL</strong></td>
            <td width="18%"></td>
            <td width="33%"></td>
          </tr>
          <tr>
            <td><input disabled="disabled" type="checkbox" name="checkbox2" value="checkbox" <? if($isi_chk[4]=='5') { echo "checked='checked'";}?> />
              <strong>CONTRAS</strong></td>
            <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if($isi_chk[5]=='6') { echo "checked='checked'";}?> />
              <strong>NON CONTRAS</strong> </td>
            </tr>
          <tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[6]=='6') { echo "checked='checked'";}?> />
              Brain/Neorocranium</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[7]=='8') { echo "checked='checked'";}?> /> 
              Thorax</span></td>
            </tr>
            <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[8]=='9') { echo "checked='checked'";}?> />
              Brain/Neorocranium Trauma </td>
              <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[9]=='10') { echo "checked='checked'";}?> /> 
              Upper Abdomen </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[10]=='11') { echo "checked='checked'";}?> />
              Nasoparynx</td>
                          
			<td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[11]=='12') { echo "checked='checked'";}?> /> 
              Lower Abdoment (Pelvic) </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[12]=='13') { echo "checked='checked'";}?> />
              Sinus</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[13]=='14') { echo "checked='checked'";}?> /> 
              Whole Abdomen </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[14]=='15') { echo "checked='checked'";}?> />
              Masteroid</td>
             <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[15]=='16') { echo "checked='checked'";}?> /> 
              Whole Body (Thorax-Abd) </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[16]=='17') { echo "checked='checked'";}?> />
              Orbita</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[17]=='18') { echo "checked='checked'";}?> /> 
              Upper Extrimitas </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[18]=='19') { echo "checked='checked'";}?> />
              IAC/Cochlea/Temporal</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[19]=='20') { echo "checked='checked'";}?> /> 
              Lower Extrimitas </span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[20]=='21') { echo "checked='checked'";}?> />
              Mandibula</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[21]=='22') { echo "checked='checked'";}?> /> 
              Cervical</span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[22]=='23') { echo "checked='checked'";}?> />
              Maxila</td>
            
			<td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[23]=='24') { echo "checked='checked'";}?> /> 
              Thoracal</span></td>
            </tr>           
			 <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[24]=='25') { echo "checked='checked'";}?> />
              Larynx</td>
           <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[25]=='26') { echo "checked='checked'";}?> /> 
              Lumbosacral</span></td>
            </tr>           
			 <td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[26]=='27') { echo "checked='checked'";}?> />
              Tyroid</td>
            <td colspan="2">
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[27]=='28') { echo "checked='checked'";}?> /> 
              Cocygys</span></td>
            </tr>            
			<td>
              <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi_chk[28]=='29') { echo "checked='checked'";}?> />
              Parotis</td>
           <td colspan="2">&nbsp;</td>
            </tr>            
			<tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox4" value="checkbox" <? if($isi_chk[29]=='30') { echo "checked='checked'";}?> />
Neck</td>
			  <td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td colspan="2">&nbsp;</td>
		      </tr>
			  <tr>
			  <td><strong>VASECULAR (Contrast)</strong> </td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			    <td><input disabled="disabled" type="checkbox" name="checkbox42" value="checkbox" <? if($isi_chk[30]=='31') { echo "checked='checked'";}?> />
		        CTA Brain/Neurocranium </td>
			    <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox422" value="checkbox" <? if($isi_chk[31]=='32') { echo "checked='checked'";}?> />
		        CTA Femoral </td>
		      </tr>
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox423" value="checkbox" <? if($isi_chk[32]=='33') { echo "checked='checked'";}?> />
CTA Carotis </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox429" value="checkbox" <? if($isi_chk[33]=='34') { echo "checked='checked'";}?> />
CTA Lower Extrimitas.................</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox424" value="checkbox" <? if($isi_chk[34]=='35') { echo "checked='checked'";}?> />
CTA Pulmonary </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4210" value="checkbox" <? if($isi_chk[35]=='36') { echo "checked='checked'";}?> />
CTA Lower Extrimitas.................</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox425" value="checkbox" <? if($isi_chk[36]=='37') { echo "checked='checked'";}?> />
CTA Thoracic </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4211" value="checkbox" <? if($isi_chk[37]=='38') { echo "checked='checked'";}?> />
CTA Venogravi Uper extremitas </td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[38]=='39') { echo "checked='checked'";}?> />
CTA Abdominal </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4212" value="checkbox" <? if($isi_chk[39]=='40') { echo "checked='checked'";}?> />
CTA Venografi Lower Extremitas </td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox427" value="checkbox" <? if($isi_chk[40]=='41') { echo "checked='checked'";}?> />
CTA Renal </td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox428" value="checkbox" <? if($isi_chk[41]=='42') { echo "checked='checked'";}?> />
CTA Iliaca </td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			  <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			  <td><strong>SPECIFIC</strong></td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[42]=='43') { echo "checked='checked'";}?> /> 
			  CT Brain Perfusion</td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4212" value="checkbox" <? if($isi_chk[43]=='44') { echo "checked='checked'";}?> /> 
              Urography non contrast</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[44]=='45') { echo "checked='checked'";}?> />
CT Calsium Score </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4212" value="checkbox" <? if($isi_chk[45]=='46') { echo "checked='checked'";}?> /> 
              Urography contrast</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[46]=='47') { echo "checked='checked'";}?> />
CT Cardiac </td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4212" value="checkbox" <? if($isi_chk[47]=='48') { echo "checked='checked'";}?> /> 
              Broncography</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[48]=='49') { echo "checked='checked'";}?> /> 
			  Colonography</td>
              <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox4212" value="checkbox" <? if($isi_chk[49]=='50') { echo "checked='checked'";}?> /> 
              TTB Guiding (biopsy)</td>
              </tr>            
			  <tr>
			  <td><input disabled="disabled" type="checkbox" name="checkbox426" value="checkbox" <? if($isi_chk[50]=='51') { echo "checked='checked'";}?> />
CT Agioscopy </td>
              <td colspan="2">&nbsp;</td>
              </tr>            
			  <tr>
			  <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
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

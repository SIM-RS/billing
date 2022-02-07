<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ceklist_endoskop_and_bronchoskopi where id='$_REQUEST[id]'"));
?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
</style>
<body>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td><div align="left">
      <table width="911" height="313" border="0" align="center">
        <tr>
          <td height="68" colspan="2"><table width="919" height="43" cellpadding="0" cellspacing="0">
              <col width="92" />
              <col width="78" />
              <col width="92" />
              <col width="109" />
              <col width="164" />
              <col width="11" />
              <col width="140" />
              <col width="105" />
              <tr height="20">
                <td width="791" height="20" colspan="8" class="style1"><div align="center"><strong>LEMBARAN    TRACKING ENDOSKOPI DAN BRONCHOSKOPI</strong></div></td>
              </tr>
              <tr height="20">
                <td height="20" colspan="8" class="style1"><div align="center"><strong>ENDOSCOPY AND    BRONCHOSCOPY TRACKING CHART</strong></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td width="397"><table width="491" height="181" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
              <tr>
                <td width="98">Nama Pasien</td>
                <td width="121">:
                  <?=$dP['nama'];?></td>
                <td width="90">&nbsp;</td>
                <td width="114">&nbsp;</td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>:
                  <?=tglSQL($dP['tgl_lahir']);?></td>
                <td>Usia</td>
                <td>:
                  <?=$dP['usia'];?>
                  Thn</td>
              </tr>
              <tr>
                <td>No. RM</td>
                <td>:
                  <?=$dP['no_rm'];?>                </td>
                <td>No Registrasi </td>
                <td>:____________</td>
              </tr>
              <tr>
                <td>Ruang Rawat/Kelas</td>
                <td>:
                  <?=$dP['nm_unit'];?>
                  /
                  <?=$dP['nm_kls'];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:
                  <?=$dP['alamat'];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="25" colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
              </tr>
          </table></td>
          <td width="398"><table width="476" height="177" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
              <col width="164" />
              <col width="11" />
              <col width="140" />
              <col width="105" />
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" colspan="3" class="style1"><div align="center"><strong>IDENTITAS SCOPE</strong></div></td>
                <td height="20" class="style1">&nbsp;</td>
              </tr>
              <tr height="9">
                <td height="9" colspan="2" class="style1">&nbsp;</td>
                <td width="10" class="style1"></td>
                <td width="200" class="style1"></td>
                <td width="36" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td width="4" height="20" class="style1">&nbsp;</td>
                <td width="146" class="style2">NAMA SCOPE</td>
                <td class="style2">:</td>
                <td class="style1"><strong>
                  <label></label>
                  NO SERI </strong> </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Gastrocope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dG['gastroskope'];?>
                  </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Colonoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dG['colonoscope'];?>
                  </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Duadenoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dG['duadenoscope'];?>
                  </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Bronchoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dG['brochoscope'];?>
                  </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1">&nbsp;</td>
                <td class="style1">&nbsp;</td>
                <td class="style1">&nbsp;</td>
              </tr>
            </table>
              <div align="left"></div></td>
        </tr>
        <tr>
          <td><table width="492" height="378" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
              <col width="164" />
              <col width="11" />
              <col width="140" />
              <col width="105" />
              <tr height="20">
                <td width="4" height="20" class="style1">&nbsp;</td>
                <td colspan="7" class="style1">Proses Pemakaian Sekarang / Pasien Berikutnya :</td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td width="4" class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td width="241" height="20" class="style1">Tanggal - Date</td>
                <td class="style1"></td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_date'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tes Kebocoran - Leak    Test</td>
                <td height="20" class="style1">&nbsp;</td>
                <td width="58" class="style1"><label> </label>
                  <label>
                  <input type="checkbox" name="checkbox" value="checkbox" <? if ($dG['s_teskebocoran']=='1') { echo "checked='checked'";}?>>
Baik</label>
                  <label></label></td>
                <td colspan="4" class="style1"><label>
                  <input type="checkbox" name="checkbox2" value="checkbox"  <? if ($dG['s_teskebocoran']=='2') { echo "checked='checked'";}?>>
Gagal</label>
<label> </label>
                  <label></label></td>
                </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanda-tanda    Kebocoran</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_tandakebocoran'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Skope dicuci oleh</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_skope'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="19" class="style1">&nbsp;</td>
                <td height="19" class="style1">No. Bath cidex</td>
                <td height="19" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_nobath'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Mulai Perendam Jam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_mulaiperendaman'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Selesai Perendam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_selesaiperendaman'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['s_penanggungjawab'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan air bersih</td>
                <td class="style1"></td>
                <td class="style1"><label> </label>
                  <form name="form1" method="post" action="">
                    <label>
                      <input type="checkbox" name="checkbox3" value="checkbox" <? if ($dG['s_spoel_airbersih']=='1') { echo "checked='checked'";}?>>
                      </label>
                  Ya
                  </form>
                  <label></label></td>
                <td colspan="2" class="style1"><form name="form2" method="post" action="">
                  <label>
                    <input type="checkbox" name="checkbox4" value="checkbox" <? if ($dG['s_spoel_airbersih']=='2') { echo "checked='checked'";}?>>
                    </label>
                </form>                  <label></label>                </td>
                <td width="4" class="style1">&nbsp;</td>
                <td width="140" class="style1">Tidak </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan Alkohol    70%</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label> </label>
                  <form name="form4" method="post" action="">
                    <label>
                    <input type="checkbox" name="checkbox5" value="checkbox" <? if ($dG['s_spoel_alkohol']=='1') { echo "checked='checked'";}?>>
                    </label>
                                    Ya
                  </form>
                  <label></label></td>
                <td colspan="2" class="style1"><form name="form5" method="post" action="">
                  <label>
                    <input type="checkbox" name="checkbox6" value="checkbox" <? if ($dG['s_spoel_alkohol']=='2') { echo "checked='checked'";}?>>
                  </label>
                </form>                  <label></label>                </td>
                <td class="style1">&nbsp;</td>
                <td class="style1"><label> </label>
Tidak </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><?=$dG['s_penanggungjawab2'];?></td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label></label>                </td>
              </tr>
          </table></td>
          <td><table width="474" height="371" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
              <col width="164" />
              <col width="11" />
              <col width="140" />
              <col width="105" />
              <tr height="20">
                <td width="4" height="20" class="style1">&nbsp;</td>
                <td width="246" class="style1">Daftar    Proses Akhir</td>
                <td width="9" class="style1">:</td>
                <td colspan="2" class="style1">&nbsp;</td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanggal - Date</td>
                <td class="style1"></td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_date'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tes Kebocoran - Leak    Test</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label> </label>
                  <form name="form3" method="post" action="">
                    <label>
                      <input type="checkbox" name="checkbox7" value="checkbox" <? if ($dG['a_teskebocoran']=='1') { echo "checked='checked'";}?> >
                      </label>
                  Baik
                  </form>
                  <label></label></td>
                <td class="style1">&nbsp;</td>
                <td colspan="3" class="style1"><label></label>                <form name="form6" method="post" action="">
                  <label>
                    <input type="checkbox" name="checkbox8" value="checkbox"  <? if ($dG['a_teskebocoran']=='2') { echo "checked='checked'";}?> >
                    </label>
                Gagal
                </form>                </td>
                </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanda-tanda    Kebocoran</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_tandakebocoran'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Skope dicuci oleh</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_skope'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="19" class="style1">&nbsp;</td>
                <td height="19" class="style1">No. Bath cidex</td>
                <td height="19" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_nobath'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Mulai Perendam Jam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_mulaiperendaman'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Selesai Perendam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_selesaiperendaman'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label>
                  <?=$dG['a_penanggungjawab'];?>
                  </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="3" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan air bersih</td>
                <td class="style1"></td>
                <td width="49" class="style1"><label> </label>
                  <form name="form7" method="post" action="">
                    <label>
                      <input type="checkbox" name="checkbox9" value="checkbox"  <? if ($dG['a_teskebocoran']=='1') { echo "checked='checked'";}?> >
                      </label>
                  Ya
                  </form>
                  <label></label></td>
                <td width="14" class="style1">&nbsp;</td>
                <td width="33" class="style1"><label></label>                <form name="form8" method="post" action="">
                  <label>
                    <input type="checkbox" name="checkbox10" value="checkbox"  <? if ($dG['a_teskebocoran']=='2') { echo "checked='checked'";}?> >
                  </label>
                </form>                </td>
                <td width="109" class="style1"><label>Tidak </label></td>
                <td width="8" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan Alkohol    70%</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label> </label>
                  <form name="form9" method="post" action="">
                    <label>
                      <input type="checkbox" name="checkbox11" value="checkbox"  <? if ($dG['a_spoel_alkohol']=='1') { echo "checked='checked'";}?> >
                      </label>
                  Ya
                  </form>
                  <label></label></td>
                <td class="style1">&nbsp;</td>
                <td class="style1"><label></label>                <form name="form10" method="post" action="">
                  <label>
                    <input type="checkbox" name="checkbox12" value="checkbox"  <? if ($dG['a_spoel_alkohol']=='2') { echo "checked='checked'";}?> >
                  </label>
                </form>                </td>
                <td class="style1"><label>Tidak </label></td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><?=$dP['a_penanggungjawab2'];?></td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="5" class="style1"><label></label>                </td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style1">&nbsp;</span>
            <table width="767" height="985" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
              <col width="64" span="2" />
              <col width="86" />
              <col width="63" />
              <col width="86" />
              <col width="18" />
              <col width="106" />
              <col width="81" />
              <col width="64" span="2" />
              <tr height="20">
                <td height="20" width="3"></td>
                <td width="52"></td>
                <td colspan="10">Diagnosa Keperawatan    Yang Muncul :</td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="8">1. Gangguan rasa aman : 
                  <label>
                  cemas b</label>/
                  <label>
                  d rencana tindakan ENDOSKOPI</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="35"></td>
                <td></td>
                <td colspan="8">2. Gangguan rasa nyaman : 
                  <label>
                  nyeri uluhati b</label>/
                  <label>
                  d peningkatan asam lambung</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="8">3.
                  <label>
                    Perubahan pola makan (Puasa) b</label>/
                    <label>
                  d persiapan tindakan ENDOSKOPI</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td width="145"></td>
                <td width="4"></td>
                <td width="107"></td>
                <td width="5"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td width="49"></td>
                <td width="74"></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="2">SELAMA TINDAKAN</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="3">a. Posisi pasien miring ke kiri</td>
                <td></td>
                <td>:</td>
                <td width="64"><label>
                  <input name="radiobutton[3]" type="radio" value="1" <? if ($dG['posisi_pasien']=='1') { echo "checked='checked'";}?>/>
                  YA</label></td>
                <td width="82"><label>
                  <input name="radiobutton[3]" type="radio" value="2" <? if ($dG['posisi_pasien']=='2') { echo "checked='checked'";}?>/>
                  TIDAK</label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="3">b Obat yang diberikan</td>
                <td></td>
                <td>:</td>
                <td colspan="2">1. Anesfar</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['anesfar'];?>
                  </span>                  mg/iv</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">2. pethidine</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['pethidine'];?>
                  </span>                  mg/iv</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">3. Andrenaline</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['adrenaline'];?>
                  </span>                  mg</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">4. Recopol</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['recopol'];?>
                  </span>                  mg</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">5. SA</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['sa'];?>
                  </span>                  mg</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">6. Buscopan</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['buscopan'];?>
                  </span>                  mg</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">7. Aetoxysclerol</td>
                <td colspan="2"><label>
                  <span class="style1">
                  <?=$dG['aetoxysclerol'];?>
                  </span>                  mg</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">8. Factu Supp</td>
                <td colspan="2"><label><span class="style1">
                <?=$dG['fatu_supp'];?>
                </span></label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">9 Xylocain Spray</td>
                <td colspan="2"><label><span class="style1">
                <?=$dG['xylocain_Spray'];?>
                </span></label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">c. Monitoring keadaan umum pasien&nbsp;</td>
                <td>:</td>
                <td colspan="2">Nadi :
                  <?=$dP['nadi2'];?></td>
                <td width="65">TD :
                  <label></label></td>
                <td width="115"><span class="style1">
                  <?=$dG['td'];?>
                </span>
                  mmHg</td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">SPO2 :
                  <label><span class="style1">
                  <?=$dG['spo2'];?>
                  </span></label></td>
                <td colspan="2">R :
                  <label>
                    <span class="style1">
                    <?=$dG['r'];?>
                  </span>                    x/m</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="3">d. Monitoring perdarahan</td>
                <td></td>
                <td></td>
                <td><label>
                  <input name="radiobutton[4]" type="radio" value="1" <? if ($dG['monitoring_perdarahan']=='1') { echo "checked='checked'";}?>/>
                  Ada
                  </label></td>
                <td><input name="radiobutton[4]" type="radio" value="2" <? if ($dG['monitoring_perdarahan']=='2') { echo "checked='checked'";}?>/>
Tidak</td>
                <td colspan="2">Bila ada:<span class="style1">
                  <?=$dG['monitoring_perdarahan_bilaada'];?>
                </span>cc </td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="2">e. Monitoring alat</td>
                <td></td>
                <td></td>
                <td>:</td>
                <td><label>
                  <input name="radiobutton[5]" type="radio" value="1" <? if ($dG['monitoring_alat']=='1') { echo "checked='checked'";}?>/>
                  Baik
                  
                  </label></td>
                <td><input name="radiobutton[5]" type="radio" value="2"  <? if ($dG['monitoring_alat']=='2') { echo "checked='checked'";}?>/>
Kurang</td>
                <td><input name="radiobutton[5]" type="radio" value="3"  <? if ($dG['monitoring_alat']=='3') { echo "checked='checked'";}?>/>
Rusak</td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">f. Diagnosa keperawatan yang muncul</td>
                <td>:</td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="8">1. Gangguan rasa nyaman:
                  <label>
                  Nyeri b</label>
                  <label>/</label> d proses tindakan ENDOSKOPY</td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="8">2. Potensial perdarahan saluran cerna atas / bawah
                  <label><span class="style1">
                  <?=$dG['potensial_perdarahan'];?>
                  </span></label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="3">3. Resti Infeksi nosokomial</td>
                <td></td>
                <td colspan="2"><label><span class="style1">
                <?=$dG['resti_infeksi'];?>
                </span></label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">4. Resti aspirasi</td>
                <td></td>
                <td></td>
                <td colspan="2"><label><span class="style1">
                <?=$dG['resti_aspirasi'];?>
                </span></label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">5. Resti Syok</td>
                <td></td>
                <td></td>
                <td colspan="2"><label><span class="style1">
                <?=$dG['resti_syok'];?>
                </span></label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="2">PASCA TINDAKAN</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">a. Selesai tindakan</td>
                <td>:</td>
                <td colspan="2">Jam
                  <label>
                    <span class="style1">
                    <?=$dG['selesai_tindakan'];?>
                  </span>                    WIB</label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">b. Posisi Pasien</td>
                <td>:</td>
                <td colspan="4"><label>
                  <input name="radiobutton[7]" type="radio" value="1" <? if ($dG['posisi_pasien']=='1') { echo "checked='checked'";}?>/>
                  Miring Kiri
                  <input name="radiobutton[7]" type="radio" value="2" <? if ($dG['posisi_pasien']=='2') { echo "checked='checked'";}?>/>
                  Kanan
                  <input name="radiobutton[7]" type="radio" value="3" <? if ($dG['posisi_pasien']=='3') { echo "checked='checked'";}?>/>
                  Terlentang</label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">c. Keadaan umum pasien</td>
                <td>:</td>
                <td colspan="4"><label>
                  <input name="radiobutton[8]" type="radio" value="1" <? if ($dG['keadaan_umum_pas']=='1') { echo "checked='checked'";}?>/>
                  Baik
                  <input name="radiobutton[8]" type="radio" value="2" <? if ($dG['keadaan_umum_pas']=='2') { echo "checked='checked'";}?>/>
                  Sedang
                  <input name="radiobutton[8]" type="radio" value="3" <? if ($dG['keadaan_umum_pas']=='3') { echo "checked='checked'";}?>/>
                  Buruk (CM/Delir/Coma) </label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">d. Lama Observasi</td>
                <td>:</td>
                <td colspan="2"><label>
                  <input name="radiobutton[9]" type="radio" value="1" <? if ($dG['lama_observasi']=='1') { echo "checked='checked'";}?>/>
                  1/2
                  <input name="radiobutton[9]" type="radio" value="2" <? if ($dG['lama_observasi']=='2') { echo "checked='checked'";}?>/>
                  1
                  <input name="radiobutton[9]" type="radio" value="3" <? if ($dG['lama_observasi']=='3') { echo "checked='checked'";}?>/>
                  2 Jam </label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">e. Bahan medis yang di pakai</td>
                <td>:</td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>a. Spuit 5cc</td>
                <td></td>
                <td>:
                  <label><span class="style1">
                  <?=$dG['spuit_5cc'];?>
                  </span></label></td>
                <td></td>
                <td colspan="2">i. Tegaderm</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['tegaderm'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>b. Spuit 3cc</td>
                <td></td>
                <td>:
                  <span class="style1">
                  <?=$dG['spuit_3cc'];?>
                  </span></td>
                <td></td>
                <td colspan="2">j. Aquabidest</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['aquabidest'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>c. Spuit 10cc</td>
                <td></td>
                <td>:
                  <span class="style1">
                  <?=$dG['spuit_10cc'];?>
                  </span></td>
                <td></td>
                <td colspan="2">k. Xylocain Jelly</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['xylocain'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>d. Spuit 20cc</td>
                <td></td>
                <td>:
                  <span class="style1">
                  <?=$dG['spuit_20cc'];?>
                  </span></td>
                <td></td>
                <td colspan="2">l. Selang O2</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['selang_O2'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">e. Infus set / Blood Set</td>
                <td>:
                  <span class="style1">
                  <?=$dG['infus_set'];?>
                  </span></td>
                <td></td>
                <td colspan="2">m. Alkohol Swab</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['alkohol_swab'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">f. Cidex opa / eidezime</td>
                <td>:
                  <span class="style1">
                  <?=$dG['cidex_opa'];?>
                  </span></td>
                <td></td>
                <td colspan="2">n. Nacl 0,9%</td>
                <td colspan="2">:
                  <span class="style1">
                  <?=$dG['nacl'];?>
                  </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">g. Vasofik No. 20.22.24</td>
                <td>:
                  <span class="style1">
                  <?=$dG['vasofik'];?>
                  </span></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">h. Neddle No. 23</td>
                <td>:
                  <span class="style1">
                  <?=$dG['neddle'];?>
                  </span></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
            </table></td>
          </tr>
      </table>
      <p class="style3">&nbsp;</p>
    </div></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>    </td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Lembaran Tracking Endoskopi dan Bronchoskopi ?')){
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

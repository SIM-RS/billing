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

$dG=mysql_fetch_array(mysql_query("select *,DATE_FORMAT(tanggal,'%d %M %Y') AS tgl_ttd from b_form_persetujuan_pemberian_darah where id='$_REQUEST[id]'"));
$pemahaman=explode(',',$dG['pemahaman']);
?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
.style15 {font-size: 12px}
.style10 {color: #FFFFFF}
.style11 {font-size: 16px}
.style8 {font-size: 18px}
.style9 {font-size: 18}
</style>
<body>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="243">&nbsp;</td>
    <td width="547"><table width="310" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
      <col width="64" />
      <col width="92" />
      <col width="9" />
      <col width="64" span="3" />
      <tr height="20">
        <td height="9" width="13"></td>
        <td width="143"></td>
        <td width="9"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>NRM</td>
        <td>:</td>
        <td><?=$dP['no_rm'];?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Nama</td>
        <td>:</td>
        <td><?=$dP['nama'];?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><span class="style15" <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span><span class="style15"> / P</span></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?=tglSQL($dP['tgl_lahir']);?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="5">(Mohon diisi atau tempelkan stiker jika ada)</td>
      </tr>
      <tr height="20">
        <td height="7"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table cellspacing="0" cellpadding="0" style="border:1px solid #000000; font:12px tahoma;">
      <col width="64" />
      <col width="85" />
      <col width="64" span="5" />
      <col width="82" />
      <col width="64" span="3" />
      <tr height="20">
        <td height="20" width="1"></td>
        <td width="114"></td>
        <td width="59"></td>
        <td colspan="3"></td>
        <td width="46"></td>
        <td colspan="3"></td>
        <td width="59"></td>
        <td width="10"></td>
        <td colspan="2"></td>
        <td width="9"></td>
        <td width="14"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="14"><div align="center" class="style4 style11"><strong>FORMULIR PERSETUJUAN PEMBERIAN DARAH DAN PRODUK    DARAH</strong></div></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;&nbsp;&nbsp;Nama Pasien</td>
        <td colspan="4">:
          <?=$dP['nama'];?></td>
        <td></td>
        <td colspan="3">No. Rekam Medik : </td>
        <td><?=$dP['no_rm'];?></td>
        <td></td>
        <td colspan="2">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;&nbsp;&nbsp;Tanggal lahir</td>
        <td colspan="4">:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td></td>
        <td colspan="3">Jenis Kelamin</td>
        <td><span class="style15" <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span><span class="style15"> / P</span>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;&nbsp;&nbsp;Diagnosa</td>
        <td colspan="4">:
		          <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){

?>
          
          <?=$dD['nama']?>
		  <?php }?>
		  </td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="9">&nbsp;&nbsp;&nbsp;Saya yang bertanda tangan di bawah ini,</td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="30"></td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;Nama</td>
        <td width="21">:
          <label></label></td>
        <td colspan="2"><?=$dG['name'];?></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="33"></td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;Tanggal lahir / Umur</td>
        <td>:
          <label></label></td>
        <td width="115"><?=$dG['taggal_lahir'];?>          &nbsp;    &nbsp; &nbsp;</td>
        <td width="12"><span class="style11">/</span></td>
        <td><label></label>
          <?=$dG['umur'];?></td>
        <td width="67"> tahun,</td>
        <td width="122">&nbsp;</td>
        <td colspan="3"> Jenis Kelamin</td>
        <td width="54">:
          <label>
            <input name="radiobutton" type="radio" value="1" <? if ($dG['jenis_kelamin']=='1') { echo "checked='checked'";}?> disabled/>
          L</label></td>
        <td width="88"><label>
          <input name="radiobutton" type="radio" value="2" <? if ($dG['jenis_kelamin']=='2') { echo "checked='checked'";}?> disabled/>
          P</label></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="2"><span class="style10">&nbsp;&nbsp;&nbsp;</span>Alamat</td>
        <td>:
          <label></label></td>
        <td colspan="3"><label>
        <?=$dG['alamat'];?>
        </label></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;No Telp</td>
        <td>:
          <label></label></td>
        <td colspan="2"><?=$dG['no_telp'];?></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">No. KTP/SIM</td>
        <td colspan="2">:
          <label>
          <?=$dG['no_ktp_sim'];?>
          </label></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="9">&nbsp;&nbsp;&nbsp;Hubungan dengan pihak yang diwakili :
          <label>
          &nbsp; &nbsp;<?=$dG['hubungan'];?>
          </label></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="14">&nbsp;&nbsp;&nbsp;telah membaca atau dibacakan keterangan pada    formedukasi transfusi darah dan telah dijelaskan hal-hal terkait mengenai prosedur transfusi darah yang akan dilakukan terhadap diri saya sendiri /    pihak yang saya wakili *),</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;Sehingga saya,</td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="14"><label>
          <input name="checkbox[0]" type="checkbox" id="checkbox[0]" value="0" <? if($pemahaman[0]=='0') { echo "checked='checked'";}?> disabled/>

          </label>
          Memahami alasan saya / pihak yang saya wakili    memerlukan darah dan produk darah</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="14"><label>
          <input name="checkbox[1]" type="checkbox" id="checkbox[1]" value="1"<? if($pemahaman[1]=='1') { echo "checked='checked'";}?> disabled/>

		  
          </label>
          memahami resiko yang mungkin terjadi saat atau    sesudah pelaksanaan pemberian darah dan produk darah</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="10"><label>
          <input name="checkbox[2]" type="checkbox" id="checkbox[2]" value="2" <? if($pemahaman[2]=='2') { echo "checked='checked'";}?> disabled/>
          </label>
          memahami alternatif pemberian darah    dan produk darah</td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="5" bgcolor="#FFFFFF"><span class="style10">_</span>dan saya menyatakan untuk</td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td><div align="center"><strong>SETUJU</strong></div></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="14"><span class="style10">_</span>atas pemberian darah dan produk    darah terhadap diri saya sendiri / pihak yang saya wakili.</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td> &nbsp; Medan,</td>
        <td style="display:none">tanggal</td>
        <td colspan="3"><label>
          <?=tgl_ina($dG['tanggal']);?>
        </label></td>
        <td>jam</td>
        <td colspan="4"><label>
          <?=$dG['jam'];?>
        </label></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="2"><div align="center">Yang menyatakan</div></td>
        <td colspan="3"><div align="center">Dokter</div></td>
        <td></td>
        <td colspan="3"><div align="center">Saksi 1 </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">saksi&nbsp; 2</div></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="2"><div align="center"><span class="style9"><span class="style8">(</span></span>&nbsp;
          <?=$dG['name'];?>
          <span class="style8">)</span></div></td>
        <td colspan="3"><div align="center"><span class="style9"><span class="style8">(&nbsp;</span>&nbsp;</span>
              <?=$dP['dr_rujuk'];?>
          &nbsp;&nbsp;<span class="style8">)</span></div></td>
        <td></td>
        <td colspan="3"><label></label>
          <div align="center"><span class="style8">( </span> &nbsp;&nbsp;
              <?=$dG['saksi1'];?>&nbsp;&nbsp;
            <span class="style8"> )</span></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><div align="center">
            <label>
            <span class="style8">(</span>&nbsp;&nbsp;
            <?=$dG['saksi2'];?>&nbsp;&nbsp;
            </label>
            <span class="style8">)</span></div></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="3"></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td colspan="2" align="center" class="noline">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>    </td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Fromulir Permintaan Darah ?')){
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

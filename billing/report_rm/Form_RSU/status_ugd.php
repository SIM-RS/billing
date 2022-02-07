<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
$sqlP="SELECT pl.tgl as tgl2, mt.nama as nama_tindakan,p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,p.gol_darah as gol_darah2,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
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
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_status_ugd where id='$_REQUEST[id]'"));
$triage=explode(',',$dG['triage']);
$nilai_nyeri=explode(',',$dG['nilai_nyeri']);
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
.style18 {font-size: 10}
.style1 {	font-size: 18px;
	font-weight: bold;
}
.style19 {color: #FEFBF9}
.style20 {color: #33FF99}
</style>
<body>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="403"><p class="style1">&nbsp;</p>
    <p class="style1">&nbsp;</p>
    <p class="style1">&nbsp;</p>
    <p class="style1">STATUS UNIT GAWAT DARURAT </p>
    </td>
    <td width="497"><table width="493" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="121" class="style15">Nama Pasien</td>
        <td width="166" class="style15">:
          <?=$dP['nama'];?></td>
        <td width="74" class="style15">&nbsp;</td>
        <td width="88" class="style15">&nbsp;</td>
      </tr>
      <tr>
        <td class="style15">Tanggal Lahir</td>
        <td class="style15">:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td class="style15">Usia</td>
        <td class="style15">:
          <?=$dP['usia'];?>
          Thn</td>
      </tr>
      <tr>
        <td class="style15">No. RM</td>
        <td class="style15">:
          <?=$dP['no_rm'];?>        </td>
        <td class="style15">No Registrasi </td>
        <td class="style15">:____________</td>
      </tr>
      <tr>
        <td class="style15">Ruang Rawat/Kelas</td>
        <td class="style15">:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?></td>
        <td class="style15">&nbsp;</td>
        <td class="style15">&nbsp;</td>
      </tr>
      <tr>
        <td class="style15">Alamat</td>
        <td class="style15">:
          <?=$dP['alamat'];?></td>
        <td class="style15">&nbsp;</td>
        <td class="style15">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="style15">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="904" height="831" border="1" class="style15"  style="border-collapse:collapse;">
      <tr>
        <td colspan="4"><table width="892" height="82" border="0">
            <tr>
              <td width="156" class="style15"><strong> &nbsp;1. TRIAGE </strong></td>
              <td width="113" class="style15">:
                <label>
                  <input name="cek_triage[0]" type="checkbox" id="cek_triage[0]" value="0" <? if($triage[0]=='0') { echo "checked='checked'";}?>disabled/>
                T1</label></td>
              <td width="115" class="style15"><label>
                <input name="cek_triage[1]" type="checkbox" id="cek_triage[1]" value="1" <? if($triage[1]=='1') { echo "checked='checked'";}?> disabled/>
                T2</label></td>
              <td width="105" class="style15"><label>
                <input name="cek_triage[2]" type="checkbox" id="cek_triage[2]" value="2" <? if($triage[2]=='2') { echo "checked='checked'";}?>disabled/>
                T3</label></td>
              <td width="78" class="style15"><label>
                <input name="cek_triage[3]" type="checkbox" id="cek_triage[3]" value="3"<? if($triage[3]=='3') { echo "checked='checked'";}?> disabled/>
                T4</label></td>
              <td width="78" class="style15">Tanggal</td>
              <td width="217" class="style15">:
                <label>
                <?=$dG['tanggal'];?>
                </label></td>
            </tr>
            <tr>
              <td class="style15">&nbsp;</td>
              <td class="style15">:
                <label>
                  <input name="cek_triage[4]" type="checkbox" id="cek_triage[4]" value="4" <? if ($dG['trauma']=='0') { echo "checked='checked'";}?>disabled/>
                Trauma</label></td>
              <td class="style15"><label>
                <input name="cek_triage[5]" type="checkbox" id="cek_triage[5]" value="5" <? if ($dG['trauma']=='1') { echo "checked='checked'";}?>disabled/>
                Non Trauma</label></td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
              <td class="style15">Jam</td>
              <td class="style15">:
                <label>
                <?=$dG['jam'];?>
                </label></td>
            </tr>
            <tr>
              <td class="style15">&nbsp;Cara Pasien Datang </td>
              <td class="style15">:
                <label>
                  <input name="cek_datang[0]" type="checkbox" id="cek_datang[0]" value="0" <? if ($dG['pasien_datang']=='0') { echo "checked='checked'";}?>disabled/>
                Sendiri</label></td>
              <td class="style15"><label>
                <input name="cek_datang[1]" type="checkbox" id="cek_datang[1]" value="1" <? if ($dG['pasien_datang']=='1') { echo "checked='checked'";}?>disabled/>
                Diantar</label></td>
              <td class="style15"><label>
                <?=$dG['ket_pasien_datang'];?>
              </label></td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
            </tr>
            <tr>
              <td class="style15">&nbsp;Kasus Polisi </td>
              <td class="style15">:
                <label>
                  <input name="cek_kasus[0]" type="checkbox" id="cek_kasus[0]" value="0" <? if ($dG['kasus']=='1') { echo "checked='checked'";}?>disabled/>
                Ya</label></td>
              <td class="style15"><label>
                <input name="cek_kasus[1]" type="checkbox" id="cek_kasus[1]" value="1"<? if ($dG['kasus']=='0') { echo "checked='checked'";}?> disabled/>
                Tidak</label></td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
              <td class="style15">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" class="style15">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="595" height="42" border="0">
            <tr>
              <td width="155" class="style15">&nbsp;Riwayat Alergi </td>
              <td width="112" class="style15">:
                <label>
                  <input name="cek_riwayat[0]" type="checkbox" id="cek_riwayat[0]" value="0"<? if ($dG['riwayat_alergi']=='1') { echo "checked='checked'";}?> disabled/>
                Ya</label></td>
              <td width="306" class="style15"><label>
                <input name="cek_riwayat[0]" type="checkbox" id="cek_riwayat[0]" value="1"<? if ($dG['riwayat_alergi']=='0') { echo "checked='checked'";}?> disabled/>
                Tidak</label></td>
            </tr>
            <tr>
              <td class="style15">&nbsp;</td>
              <td class="style15">Bila Ya Sebutkan :
                <label></label></td>
              <td class="style15"><?=$dG['ket_riwayat_alergi'];?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><table width="890" height="102" border="0">
            <tr>
              <td colspan="2" class="style15">&nbsp;<strong>2. ANAMNESE &amp; PEMERIKSAAN FISIK : </strong></td>
              <td width="74" class="style15"><label>
                <input name="cek_pemeriksaan[0]" type="checkbox" id="cek_pemeriksaan[0]" value="0" <? if ($dG['pemeriksaan_fisik']=='0') { echo "checked='checked'";}?>disabled/>
                Auto</label></td>
              <td width="63" class="style15"><label>
                <input name="cek_pemeriksaan[1]" type="checkbox" id="cek_pemeriksaan[1]" value="1" <? if ($dG['pemeriksaan_fisik']=='1') { echo "checked='checked'";}?>disabled/>
                Allo :</label></td>
              <td width="485" class="style15"><label>
                <?=$dG['ket_pemeriksaan_fisik'];?>
              </label></td>
            </tr>
            <tr>
              <td width="195" class="style15"><span class="style18">&nbsp;Keluhan Utama </span></td>
              <td width="39" class="style15">:</td>
              <td colspan="3" class="style15"><label>
                <?=$dG['keluhan_utama'];?>
              </label></td>
            </tr>
            <tr>
              <td class="style15"><span class="style18">&nbsp;Keluhan Tambahan </span></td>
              <td class="style15">:</td>
              <td colspan="3" class="style15"><label>
                <?=$dG['keluhan_tambahan'];?>
              </label></td>
            </tr>
            <tr>
              <td class="style15"><span class="style18">&nbsp;Riwayat Penyakit Sekarang </span></td>
              <td class="style15">:</td>
              <td colspan="3" class="style15"><?=$dG['penyakit_sekarang'];?></td>
            </tr>
            <tr>
              <td class="style15"><span class="style18">&nbsp;Riwayat Penyakit Dahulu </span></td>
              <td class="style15">:</td>
              <td colspan="3" class="style15"><?=$dG['penyakit_dahulu'];?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="682" border="0">
            <tr>
              <td width="198" class="style15">&nbsp;Keadaan Umum </td>
              <td width="87" class="style15"><label> :
                <input name="cek_keadaan[0]" type="checkbox" id="cek_keadaan[0]" value="0" <? if ($dG['keadaan_umum']=='0') { echo "checked='checked'";}?>disabled/>
                Baik</label></td>
              <td width="114" class="style15"><label>
                <input name="cek_keadaan[1]" type="checkbox" id="cek_keadaan[1]" value="1" <? if ($dG['keadaan_umum']=='1') { echo "checked='checked'";}?>disabled/>
                Sedang</label></td>
              <td width="426" class="style15"><label>
                <input name="cek_keadaan[2]" type="checkbox" id="cek_keadaan[2]" value="2" <? if ($dG['keadaan_umum']=='2') { echo "checked='checked'";}?>disabled/>
                Buruk</label></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="209">&nbsp;Tekanan Darah :
          <label>
            <?=$dP['tensi2'];?>
            mmHg</label></td>
        <td colspan="2">&nbsp;&nbsp;Nadi :
          <label>
            <?=$dP['nadi2'];?>
            x/mnt</label></td>
        <td width="382">&nbsp;&nbsp;Berat Badan :
          <label>
            <?=$dP['bb2'];?>
            </label>
          Kg</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pernapasan :
          <label>
            <?=$dP['rps2'];?>
            </label>
          x/mnt</td>
        <td colspan="2">&nbsp;&nbsp;Suhu :
          <?=$dP['suhu2'];?>
          &deg;C </td>
        <td>&nbsp;&nbsp;Tinggi Badan :
          <?=$dP['tb2'];?>
          Cm </td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Status Neurologis </td>
        <td width="159">&nbsp;&nbsp;E :
          <label>
          <?=$dG['e'];?>
          </label></td>
        <td width="126">&nbsp;&nbsp;M :          
          <?=$dG['m'];?></td>
        <td>&nbsp;&nbsp;V:          
          <?=$dG['v'];?></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;kepala</td>
        <td colspan="3"><label>&nbsp;
           &nbsp;<?=$dG['kepala'];?>
        </label></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Leher</td>
        <td colspan="3">&nbsp;&nbsp;
          <?=$dG['leher'];?></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Dada</td>
        <td colspan="3">&nbsp;&nbsp;
          <?=$dG['dada'];?></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Perut</td>
        <td colspan="3">&nbsp;&nbsp;
          <?=$dG['perut'];?></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Kulit dan Kelamin </td>
        <td colspan="3">&nbsp;&nbsp;
          <?=$dG['kulit'];?></td>
      </tr>
      <tr>
        <td height="20">&nbsp;&nbsp;Alat Gerak </td>
        <td height="20" colspan="3">&nbsp;&nbsp;
          <?=$dG['alat'];?></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><div align="left">
            <p>&nbsp;&nbsp;Nilai Nyeri / Pain Score : (Tidak ada nyeri / no pain - nyeri sangat berat / pain full )&nbsp; </p>
        </div>
            <div align="center"><img src="gmb.jpg" width="700" height="180" /></div></td>
      </tr>
      <tr>
        <td colspan="4"><table width="893" border="0">
            <tr>
              <td width="90" class="style15">&nbsp;</td>
              <td width="80" class="style15">&nbsp;</td>
              <td width="44" class="style15"><label>
                <input name="cek_n[0]" type="checkbox" id="cek_n[0]" value="0"  <? if($nilai_nyeri[0]=='0') { echo "checked='checked'";}?>disabled/>
                0</label></td>
              <td width="42" class="style15"><label>
                <input name="cek_n[1]" type="checkbox" id="cek_n[1]" value="1" <? if($nilai_nyeri[1]=='1') { echo "checked='checked'";}?>disabled/>
                1</label></td>
              <td width="47" class="style15"><label>
                <input name="cek_n[2]" type="checkbox" id="cek_n[2]" value="2" <? if($nilai_nyeri[2]=='2') { echo "checked='checked'";}?>disabled/>
                2</label></td>
              <td width="36" class="style15"><label>
                <input name="cek_n[3]" type="checkbox" id="cek_n[3]" value="3" <? if($nilai_nyeri[3]=='3') { echo "checked='checked'";}?>disabled/>
                3</label></td>
              <td width="40" class="style15"><label>
                <input name="cek_n[4]" type="checkbox" id="cek_n[4]" value="4" <? if($nilai_nyeri[4]=='4') { echo "checked='checked'";}?> disabled/>
                4</label></td>
              <td width="40" class="style15"><label>
                <input name="cek_n[5]" type="checkbox" id="cek_n[5]" value="5" <? if($nilai_nyeri[5]=='5') { echo "checked='checked'";}?>disabled/>
                5</label></td>
              <td width="48" class="style15"><label>
                <input name="cek_n[6]" type="checkbox" id="cek_n[6]" value="6" <? if($nilai_nyeri[6]=='6') { echo "checked='checked'";}?>disabled/>
                6</label></td>
              <td width="39" class="style15"><label>
                <input name="cek_n[7]" type="checkbox" id="cek_n[7]" value="7" <? if($nilai_nyeri[7]=='7') { echo "checked='checked'";}?>disabled/>
                7</label></td>
              <td width="44" class="style15"><label>
                <input name="cek_n[8]" type="checkbox" id="cek_n[8]" value="8" <? if($nilai_nyeri[8]=='8') { echo "checked='checked'";}?>disabled/>
                8</label></td>
              <td width="43" class="style15"><label>
                <input name="cek_n[9]" type="checkbox" id="cek_n[9]" value="9" <? if($nilai_nyeri[9]=='9') { echo "checked='checked'";}?>disabled/>
                9</label></td>
              <td width="127" class="style15"><label>
                <input name="cek_n[10]" type="checkbox" id="cek_n[10]" value="10" <? if($nilai_nyeri[10]=='10') { echo "checked='checked'";}?>disabled/>
                10</label></td>
              <td width="62" class="style15">&nbsp;</td>
              <td width="49" class="style15">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><p align="center">DAFTAR INFUS OBAT</p>
          <p align="left"> &nbsp;&nbsp;INFUS YANG DIBERIKAN</p>
          <table width="939" height="82" border="1" align="center" cellpadding="2" id="tblkegiatan" style="border-collapse:collapse;">
            <tr style="background:#33CC66">
              <td colspan="5" align="right" class="style15"><span class="style20"></span><span class="style19"></span></td>
            </tr>
            <tr style="background:#33FF99">
              <td width="228" align="center" class="style15"><strong>TANGGAL</strong></td>
              <td width="163" align="center" class="style15"><strong>JAM</strong></td>
              <td align="center" class="style15"><strong>JENIS INFUS / TRANSFUSI </strong></td>
              <td align="center" class="style15"><strong>NAMA DOKTER </strong></td>
              </tr>
            <?
					$sql2="select * from b_ms_status_ugd_infus where ugd_id ='$id'";	
					$query=mysql_query($sql2);
					while($coba=mysql_fetch_object($query)){
						?>
            <tr>
              <td width="228" align="center" class="style15"><?=$coba->tanggal;?></td>
              <td align="center" class="style15"><?=$coba->jam;?></td>
              <td align="center" class="style15"><?=$coba->infus;?></td>
              <td align="center" class="style15"><?=$coba->paraf_nama;?></td>
              </tr>
            <?
					}
					?>
          </table>          
          <p align="left">&nbsp;</p></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;
          <p>&nbsp;&nbsp;OBAT - OBATAN YANG DIBERIKAN </p>
          <table width="967" height="77" border="1" align="center" cellpadding="2" id="tblkegiatan" style="border-collapse:collapse;">
            <tr style="background:#CCCC00">
              <td colspan="7" align="right" class="style15">&nbsp;</td>
            </tr>
            <tr style="background:#CCFF00">
              <td width="138" align="center" class="style15"><strong>TANGGAL</strong></td>
              <td width="139" align="center" class="style15"><strong>JAM</strong></td>
              <td width="210" align="center" class="style15"><strong>NAMA OBAT </strong></td>
              <td width="119" align="center" class="style15"><strong>DOSIS</strong></td>
              <td width="160" align="center" class="style15"><strong>CARA PEMBERIAN </strong></td>
              <td width="241" align="center" class="style15"><strong>NAMA DOKTER </strong></td>
              </tr>
            <?
					$sql3="select * from b_ms_status_ugd_obat where ugd_id ='$id'";	
					$query=mysql_query($sql3);
					while($data3=mysql_fetch_object($query)){
						?>
            <tr>
              <td width="138" align="center" class="style15"><?=$data3->tanggal;?></td>
              <td align="center" class="style15"><?=$data3->jam;?></td>
              <td align="center" class="style15"><?=$data3->obat;?></td>
              <td align="center" class="style15"><?=$data3->dosis;?></td>
              <td align="center" class="style15"><?=$data3->pemberian;?></td>
              <td align="center" class="style15"><?=$data3->paraf_nama;?></td>
              </tr>
            <?
					}
					?>
          </table>          
          <p>&nbsp;</p></td>
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
                    if(confirm('Cetak Status UGD ?')){
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

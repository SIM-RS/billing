<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,p.gol_darah as gol_darah2,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
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

$dG=mysql_fetch_array(mysql_query("select * from b_ms_ksr where id='$_REQUEST[id]'"));
?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
.style17 {font-size: 12px}
</style>
<body>
<table width="800" border="0" align="center" style="font:8px tahoma;">
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
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
        <td height="20" colspan="14" align="center">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="14" align="center"><span style="font:bold 15px tahoma;"><u>SURAT PERNYATAAN</u></span></td>
      </tr>
      <tr height="">
        <td width="1">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
        <td width="25"></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12"><span class="style17">Yang bertanda tangan di bawah ini:</span></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><span class="style17">Nama</span></td>
        <td colspan="9"><span class="style17">:
            <label for="name"></label>
            <?=$dP['dr_rujuk'];?>        
          </span></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><span class="style17">Rumah Sakit</span></td>
        <td colspan="10"><span class="style17">: Rumah Sakit Pelindo I Kota Medan</span></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td width="54">&nbsp;</td>
        <td width="51">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12"><span class="style17">Menyatakan dengan sesungguhnya bahwa,</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12"><span class="style17">1. Saya telah menerima penjelasan mengenai pemeriksaan uji silang serasi (crossmatching) dengan hasil<br />
&nbsp;&nbsp;&nbsp;&nbsp;<strong>TIDAK COCOK/INCOMPATIBLE </strong>terhadap sampel darah.</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td width="52">&nbsp;</td>
        <td colspan="2"><span class="style17">- OS</span></td>
        <td colspan="6"><span class="style17">:
            <label>
            <?=$dG['os'];?>
            </label>
        </span></td>
        <td width="45">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="style17">- No. Reg/Med. Rec</span></td>
        <td colspan="10"><span class="style17">:
            <label for="name"></label>
            <?=$dP['no_rm'];?>
        </span></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="style17">- Gol. Darah/Rhesus</span></td>
        <td colspan="10"><span class="style17">:
            <?=$dP['gol_darah'];?>
        </span></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="style17">- Bagian/Ruangan</span></td>
        <td colspan="10"><span class="style17">:
            <?=$kamar;?>
            <label for="name"></label>
          /
          <?=$dP['nm_unit'];?>
        </span></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="style17">- Rumah Sakit</span></td>
        <td colspan="10"><span class="style17">: Rumah Sakit Pelindo I Kota Medan</span></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12"><span class="style17">2. Saya menyatakan tetap akan menggunakan darah dengan hasil <strong>TIDAK COCOK/INCOMPATIBLE</strong> tersebut untuk <br />
&nbsp;&nbsp;&nbsp;&nbsp;kebutuhan transfusi OS di atas.</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td width="134">&nbsp;</td>
        <td width="16">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td align="justify" colspan="12"><span class="style17">3. Saya bersedia bertanggung jawab atas penggunaan darah dengan hasil <strong>TIDAK COCOK/INCOMPATIBLE</strong> tersebut, dan <br />
&nbsp;&nbsp;&nbsp;&nbsp;tidak akan menuntut pihak unit Donor Darah PMI Kota Medan jika terjadi hal-hal yang tidak diinginkan.</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12"><span class="style17">Demikian pernyataan ini saya buat untuk dipergunakan sebagaimana mestinya.</span></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4"><span class="style17">Medan, <?php echo date("j F Y")?></span></td>
        <td width="60"></td>
        <td width="47"></td>
        <td width="96">&nbsp;</td>
        <td width="9">&nbsp;</td>
        <td colspan="4" >&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3"><span class="style17">Yang menyatakan:</span></td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td width="24"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="88"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3"><span class="style17">( <strong>
          <?=$dP['dr_rujuk'];?>
        </strong>)</span></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
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
                    if(confirm('Anda Yakin Mau Mencetak Formulir ini ?')){
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

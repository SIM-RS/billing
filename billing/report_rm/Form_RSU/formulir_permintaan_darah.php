<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$cito=$_REQUEST['cito'];
$no_minta=$_REQUEST['no_minta'];
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

if(!isset($_REQUEST[id]))
{
	$dG=mysql_fetch_array(mysql_query("select *,if(rhesus='0',' ',rhesus) as rhesus1 from b_ms_formulir_permintaan_darah where no_minta='$no_minta'"));
}else{
	$dG=mysql_fetch_array(mysql_query("select *,if(rhesus='0',' ',rhesus) as rhesus1 from b_ms_formulir_permintaan_darah where id='$_REQUEST[id]'"));	
}

?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
.style14 {
	font-size: 12;
	font-weight: bold;
}
.style15 {font-size: 12px}
</style>
<body>
<table width="800" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td><table cellspacing="0" cellpadding="0" style="border-collapse:collapse; border:1px solid #000000;">
      <col width="64" span="5" />
      <col width="12" />
      <col width="64" span="8" />
      <tr height="25">
        <td height="25" width="14"></td>
        <td colspan="11"><div align="center"><span class="style14">FORMULIR PERMINTAAN    DARAH</span></div></td>
        <td width="14"></td>
        <td width="97"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td width="93"></td>
        <td width="49"></td>
        <td width="137"></td>
        <td width="5"></td>
        <td width="14"></td>
        <td width="100"></td>
        <td width="22"></td>
        <td width="1"></td>
        <td width="93"></td>
        <td width="93"></td>
        <td width="93"></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25"></td>
        <td colspan="11"><div align="center"><span class="style14">
        <?
		if($cito==2)
		{
        	echo "CITO";
		}
		?>
        </span></div></td>
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
        <td height="20"></td>
        <td colspan="2"><span class="style15">Kepada Yth,</span></td>
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
        <td height="20"></td>
        <td colspan="4"><span class="style15">Bank Darah RS PELINDO I</span></td>
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
        <td height="20"></td>
        <td colspan="2"><span class="style15">Di Tempat</span></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
        <td colspan="2"><span class="style15">Bersama Ini saya,</span></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="5"><span class="style15">Nama (Dokter) :&nbsp;
              <?=$dP['dr_rujuk'];?>
        </span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td height="20"></td>
        <td colspan="11"><span class="style15">Mohon untuk segera diberikan kantong / labu darah    tranfusi tanpa pemeriksaaan Croosmatch terlebih dahulu Untuk Penderita :</span></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="2"><span class="style15">Nama</span></td>
        <td><span class="style15">:</span></td>
        <td colspan="4"><span class="style15">
            <?=$dP['nama'];?>
            <span class="style15"> <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="2"><span class="style15">No. RM</span></td>
        <td><span class="style15">:</span></td>
        <td colspan="4"><span class="style15">
            <?=$dP['no_rm'];?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="2"><span class="style15">Ruangan</span></td>
        <td><span class="style15">:</span></td>
        <td colspan="4"><span class="style15">
            <?=$dP['nm_unit'];?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="2"><span class="style15">Alasan Tranfusi</span></td>
        <td><span class="style15">:</span></td>
        <td colspan="4"><span class="style15"><label>
        <?=$dG['alasan_transfusi'];?>
        </label></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td></td>
        <td colspan="2"><span class="style15">Golongan darah / Rh</span></td>
        <td><span class="style15">:</span></td>
        <td colspan="4"><span class="style15">
            <?=$dP['gol_darah2'];?> /
            <span class="style15"><?=$dG['rhesus1'];?></span></td>
        <td></td>
        <td></td>
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
        <td height="20"></td>
        <td colspan="11"><span class="style15">Saya akan bertanggung jawab apabila terjadi reaksi    transfusi pada pasien tersebut di atas.</span></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="11"><span class="style15">Atas perhatian dan kerjasamanya saya ucapkan    terimakasih.</span></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
        <td colspan="3"><span class="style15">Mengetahui :</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><span class="style15">Medan :<span class="style5">
          <?=$dG['tgl'];?>
        </span> </span></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="3"><span class="style15">Petugas BDRS</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><span class="style15">Dokter yang meminta</span></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
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
        <td height="20"></td>
        <td colspan="3"><span class="style15">&nbsp;&nbsp;(
          <label>
          <?=$dG['petugas'];?>
          </label>
          )</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><span class="style15">&nbsp;&nbsp;(
          <?=$dP['dr_rujuk'];?>
          )</span></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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

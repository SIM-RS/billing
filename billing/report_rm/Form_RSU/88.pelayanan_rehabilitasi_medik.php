<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUsr'];
$sqlP="SELECT DISTINCT pl.tgl as tgl2, bk.no_reg, mt.nama as nama_tindakan, p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama),'-') AS almt_lengkap
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_tindakan t ON t.pelayanan_id=pl.id
LEFT JOIN b_ms_tindakan_kelas bmtk ON bmtk.id = t.ms_tindakan_kelas_id 
LEFT JOIN b_ms_tindakan mt ON mt.id = bmtk.ms_tindakan_id 
WHERE pl.id='$idPel';";
$Exdp = mysql_query($sqlP);
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_formulir_permintaan_darah where id='$_REQUEST[id]'"));
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
.style16 {
	font-size: 16px;
	font-weight: bold;
}
.style17 {	font-size: 14px;
	font-weight: bold;
}
</style>
<body>
<table width="883" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="298"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p class="style16">PELAYANAN REHABILITASI MEDIK </p></td>
    <td width="575"><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124"><span class="style15">Nama Pasien</span></td>
        <td colspan="3"><span class="style15">:
          <?=$dP['nama'];?> &nbsp; &nbsp; &nbsp;
        <span class="style15" <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span><span class="style15"> / P</span></span><span class="style15"></span><span class="style15"></span></td>
        </tr>
      <tr>
        <td><span class="style15">Tanggal Lahir</span></td>
        <td width="173"><span class="style15">:        
          <?=tglSQL($dP['tgl_lahir']);?>
        </span></td>
        <td width="75"><span class="style15">Usia</span></td>
        <td width="102"><span class="style15">:
          <?=$dP['usia'];?>
          Thn</span></td>
      </tr>
      <tr>
        <td><span class="style15">No. RM</span></td>
        <td><span class="style15">:
          <?=$dP['no_rm'];?>
        </span></td>
        <td><span class="style15">No Registrasi </span></td>
        <td><span class="style15">:
          <?=$dP['no_reg'];?></span></td>
      </tr>
      <tr>
        <td><span class="style15">Ruang Rawat/Kelas</span></td>
        <td><span class="style15">:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?>
        </span></td>
        <td><span class="style15"></span></td>
        <td><span class="style15"></span></td>
      </tr>
      <tr>
        <td><span class="style15">Alamat</span></td>
        <td><span class="style15">:
          <?=$dP['almt_lengkap'];?>
        </span></td>
        <td><span class="style15"></span></td>
        <td><span class="style15"></span></td>
      </tr>
      <tr>
        <td colspan="4"><span class="style15">(Tempelkan Sticker Identitas Pasien)</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="867" height="158" border="1" align="center" cellpadding="0" cellspacing="0"style="border-collapse:collapse; border:1px solid #000000;">
      <tr height="70">
        <td height="41" width="162"><div align="center" class="style17">TANGGAL</div></td>
        <td width="501"><div align="center" class="style17">PEMERIKSAAN</div></td>
        <td width="196"><div align="center" class="style17">PARAF</div></td>
      </tr>
<?
	while($dP=mysql_fetch_array($Exdp))
	{
?>
      <tr height="70">
        <td height="115"><div align="center"><span class="style15">
          &nbsp;<?=tglSQL($dP['tgl2']);?>
        </span></div></td>
        <td align="center"><span class="style15">
           <?=$dP['nama_tindakan'];?>
        </span></td>
        <td align="center"><label for="checkbox"></label></td>
      </tr>
<?
	}
?>
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
                    if(confirm('Anda yakin mau mencetak PELAYANAN REHABILITASI MEDIK  ?')){
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

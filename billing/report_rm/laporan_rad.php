<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PERMINTAAN PEMERIKSAAN RADIOLOGI</title>
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

//$sql="select * from b_ms_pemeriksaan_lab where id = '$_GET[id]'"; //echo $sql;
$sql="SELECT 
pel.pasien_id, 
pas.nama, 
IF(pel.cito=0,'biasa','cito') as status, 
tindrad.tindakan_lab_id,
kel.nama parent,
GROUP_CONCAT(tind.nama) anak
FROM b_pelayanan pel
INNER JOIN b_ms_pasien pas ON pas.id=pel.pasien_id
INNER JOIN b_kunjungan kun ON pel.kunjungan_id=kun.id
INNER JOIN b_tindakan_rad tindrad ON tindrad.pelayanan_id = pel.id
INNER JOIN b_ms_tindakan tind ON tind.id=tindrad.pemeriksaan_id
INNER JOIN b_ms_klasifikasi klas ON klas.id=tind.klasifikasi_id
INNER JOIN b_ms_kelompok_tindakan kel ON kel.id=tind.kel_tindakan_id
WHERE pel.id='$idPel' AND kun.id='$idKunj' and tindrad.status=0
GROUP BY kel.nama;"; //echo $sql;
$hasil=mysql_query($sql);
$hasil2=mysql_query($sql);
$data=mysql_fetch_array($hasil);

$sqlCito = "SELECT * FROM b_pelayanan WHERE id = $idPel";
$execCito = mysql_query($sqlCito);
$dCito = mysql_fetch_array($execCito);

?>
<body>
<table width="1000" border="0" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000; font:tahoma">
  <tr>
    <td colspan="3"><div align="right" class="style2">PELAYANAN 24 JAM </div></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" align="center" style="font:12px tahoma">
      <tr>
        <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="61%" height="69"><span class="style2">RS PELINDO I </span></td>
        <td width="39%" rowspan="2"><table width="100%" border="0" style="border:1px solid #000000; font:10px tahoma">
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
            <td>No. registrasi: </td>
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
            <td height="28" colspan="4"><div align="center"><strong>(Tempelkan Stiker Identitas Pasien) </strong></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN RADIOLOGI</span></td>
      </tr>
    </table></td>
      </tr>
      <tr>
        <td>No. Formulir :  <?=$no_formulir?></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" style="border-collapse:collapse">
          <tr>
            <td><table width="100%" border="0" style="font:10px tahoma;border-collapse:collapse">
              <tr>
                <td width="50%" rowspan="3" style="border-right:1px solid #000000"><strong>Diagnosis / Keterangan Klinis : <?php echo $diag;?></strong></td>
                <td width="11%"><div align="right"><strong>Diterima Tanggal  </strong></div></td>
				<td width="39%"><strong>: </strong></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Jam</strong></div></td>
				<td><strong>: </strong></td>
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
                <td width="21%"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dCito['cito']=='0') { echo "checked='checked'";}?> />
Biasa</td>
                <td colspan="8"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dCito['cito']=='1') { echo "checked='checked'";}?> />
Cito</td>
                </tr>
					<?php
					$kt = 'dummy';
					
					while ($data2=mysql_fetch_array($hasil2))
					{
					$isi_chk=explode(",",$data2['anak']);			 
					if($kt != $data2['parent'])
					 //print_r($isi_chk);
					{
					?>
              <tr>
                <td colspan="15" bgcolor="#CCCCCC"><strong><?php echo $data2['parent'] ?></strong> </td>
              </tr>
			  <?php
			  } 
			  $kt=$data2['parent'];
			  
			  for($i=0;$i<=(count($isi_chk)-1);$i++)
			  {				
			  ?>
				<tr>
				<td colspan="15">
				<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" checked="checked"?> <?=$isi_chk[$i]?>				</td>
				</tr>
				<?php
				}
				}
				?>				
              <tr> 
                <td width="1%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td>&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
              </tr>
              
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
    <td width="20%"></td>
                <td class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();" />                </td>
    <td width="20%"><div align="right"><span class="style3">FORM-RAD-01-00</span></div></td>
  </tr>
</table>
</body>
        <script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';           
           
            if(tombol.style.visibility=='collapse'){
               
                /*try{
			mulaiPrint();
		}
		catch(e){*/
			window.print();
			//window.close();
		//}
                    
            }
        }
        </script></html>

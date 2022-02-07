<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Travelling Patient Information</title>
</head>

<link rel="stylesheet" type="text/css" href="setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<?php
	include "setting.php";
	$query="select b.* FROM
  lap_travelling b where b.id='".$_REQUEST['id']."'";
	$is=mysql_fetch_array(mysql_query($query));
?>
<body id="body">

<form id="from_travelling" method="post" action="1.traveling_patient_informasi_act.php">
<table width="832" border="0" align="center" cellpadding="2" cellspacing="2" style="font:12px tahoma;border:1px solid #999999; padding:5px; ">
  <tr>
    <td height="32" colspan="8" style="font:bold 16px tahoma; text-align:center;">TRAVELLING PATIENT INFORMATION</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Name /    Nama</td>
    <td colspan="3">:
      <input type="hidden" name="id" id="id" />
      <input type="hidden" name="act" id="act" />
      <input type="hidden" name="nama" id="nama" /><?=$nama?></td>
  </tr>
  <tr>
    <td colspan="3">Date of Birth / Tgl Lahir</td>
    <td colspan="3">: 
      <input type="hidden" name="kunjungan_id" id="kunjungan_id" value="<?php echo $_REQUEST['idKunj']; ?>" />
      <input type="hidden" name="pelayanan_id" id="pelayanan_id" value="<?php echo $_REQUEST['idPel']; ?>" />
      <input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['idUsr']; ?>" />
      <input type="hidden" name="tgl_lahir" id="tgl_lahir" /><?=$lahir?></td>
  </tr>
  <tr>
    <td colspan="3">Home Address / Alamat </td>
    <td colspan="3">: 
      <input type="hidden" name="alamat" id="alamat" size="50" /><?=$alamat?></td>
  </tr>
  <tr>
    <td colspan="3">Diagnosis / Diagnosa</td>
    <td colspan="3">: 
      <input type="hidden" name="diagnosa" id="diagnosa" value="<?=$diag?>" /><?=$diag?></td>
  </tr>
  <tr>
    <td colspan="3">Dyalisis Treatment per week / Tindakan HD per Minggu </td>
    <td colspan="3">: 
      <?=$is['tindakan_perminggu']?></td>
  </tr>
  <tr>
    <td colspan="3">Duration Of Dyalisis / Lamanya HD</td>
    <td colspan="3">: 
      <?=$is['lama_hd']?></td>
  </tr>
  <tr>
    <td colspan="3">Dialisat Concentrate / Cairan Konsentrat</td>
    <td colspan="3">: 
      <?=$is['cairan_konsentrat']?></td>
  </tr>
  <tr>
    <td colspan="3">Dry Weight / BB Kering</td>
    <td colspan="3">: 
      <?=$is['bb_kering']?></td>
  </tr>
  <tr>
    <td colspan="3">Acces Vascular / Sarana Hubungan Sirkulasi</td>
    <td colspan="3">: 
      <?=$is['sarana_hubungan']?></td>
  </tr>
  <tr>
    <td colspan="3">Average weight Gain Between Treatment / Kenaikan </td>
    <td colspan="3">: 
      <?=$is['kenaikan']?></td>
  </tr>
  <tr>
    <td colspan="3">Average Blood Pressure / Tekanan Darah Rata-Rata </td>
    <td colspan="3">: Pre/Sebelum : 
      <?=$is['tkn_drh_sblm']?>
      &nbsp;&nbsp;&nbsp;post/sesudah :
      <?=$is['tkn_drh_ssdh']?></td>
  </tr>
  <tr>
    <td colspan="3">Dyaliser Type / Jenis Dialiser</td>
    <td colspan="3">: 
      <?=$is['jns_dialiser']?></td>
  </tr>
  <tr>
    <td colspan="3">Bood flow Pressure / Kecepatan Aliran Darah</td>
    <td colspan="3">: 
      <?=$is['kec_aliran']?></td>
  </tr>
  <tr>
    <td colspan="3">Heparinitation / Heparinisasi</td>
    <td colspan="3">: 
      <?=$is['heparinasi']?></td>
  </tr>
  <tr>
    <td colspan="3">Loadind dose / Dosis Awal</td>
    <td colspan="3">: 
      <?=$is['dosis_awal']?></td>
  </tr>
  <tr>
    <td colspan="3">Blood Group / Gol.Darah/ Rhesusu</td>
    <td colspan="3">: 
      <?=$is['rhesusu']?></td>
  </tr>
  <tr>
    <td colspan="3">Blood Tranfusion Result /Tranfusi darah terakhir </td>
    <td colspan="3">:    
      <?=$is['trans_darah_trkhr']?></td>
  </tr>
  <tr>
    <td colspan="3">Date of Laboratorium Result / Tgl. Hasil Laboratorium Terakhir </td>
    <td colspan="3">: 
      <?=tglSQL($is['tgl_hasil_lab'])?></td>
  </tr>
  <tr>
    <td>HB : <?=$is['hb']?></td>
    <td>&nbsp;</td>
    <td width="193">Ureum pre/post :
      <?=$is['ureum']?></td>
    <td>&nbsp;</td>
    <td colspan="3">Creatinin pre/post :
      <?=$is['creatinin']?></td>
    <td width="170">Kalium :
      <?=$is['kalium']?></td>
    </tr>
  <tr>
    <td width="110">Phospor : 
    <?=$is['phospor']?></td>
    <td width="73">&nbsp;</td>
    <td>HbsAg :
      <?=$is['hbsag']?></td>
    <td>&nbsp;</td>
    <td colspan="3">Anti HCV :
      <?=$is['anti_hcv']?></td>
    <td>Anti HIV :
      <?=$is['anti_hiv']?></td>
    </tr>
  <tr>
    <td colspan="3">Medication / Terapi Obat-obatan </td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">1. 
      <?=$is['terapi1']?></td>
    </tr>
  <tr>
    <td colspan="8">2. 
      <?=$is['terapi2']?></td>
    </tr>
  <tr>
    <td colspan="8">3. 
      <?=$is['terapi3']?></td>
    </tr>
  <tr>
    <td colspan="8">4. 
      <?=$is['terapi4']?></td>
    </tr>
  <tr>
    <td colspan="8">5. 
      <?=$is['terapi5']?></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Problem During Dyalisis / Permasalahan selama HD</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">Medan, <?=tgl_ina(date('Y-m-d'));?></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">Your Sincerly</td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td width="29">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="79">&nbsp;</td>
    <td colspan="2" align="center">Nephrologist Consultan</td>
    </tr>
  <tr id="trTombol">
    <td colspan="8" align="center">
	<button type="button" onclick="cetak(document.getElementById('trTombol'));">Cetak</button>
	<button type="button" onclick="window.close()">Tutup</button></td>
    </tr>
</table>
</form>



</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>
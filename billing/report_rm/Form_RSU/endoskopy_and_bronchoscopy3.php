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
<?
$sql="SELECT *FROM  b_ceklist_endoskop_and_bronchoskopi
WHERE id='$id';";
$d=mysql_fetch_array(mysql_query($sql));
{

?>
<?
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />

        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
<title>Check List Endoskopi Saluran Cerna</title>
<style type="text/css">
<!--
.style3 {font-size: 18px}
-->
</style>
</head>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}


.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}

        </style>
<title>resume kep</title>
<?
//include "setting2.php";
?>

<body>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div id="tampil_input" align="center" style="display:block">
<form id="form1" name="form1" action="endoskopy_and_bronchoscopy_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUser" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" style="font:12px tahoma;">
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
                <?=$dP['no_rm'];?>              </td>
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
                  <?=$dP['gastroskope'];?>
                </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Colonoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dP['colonoscope'];?>
                </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Duadenoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dP['duadenoscope'];?>
                </label>                </td>
                <td class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Bronchoscope</td>
                <td class="style1">:</td>
                <td class="style1"><label>
                  <?=$dP['brochoscope'];?>
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
                <td colspan="6" class="style1">Proses Pemakaian Sekarang / Pasien Berikutnya :</td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td width="4" class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td width="241" height="20" class="style1">Tanggal - Date</td>
                <td class="style1"></td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_date'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tes Kebocoran - Leak    Test</td>
                <td height="20" class="style1">&nbsp;</td>
                <td width="34" class="style1"><label>
</label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["s_teskebocoran"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?></div>
                  <label></label></td>
                <td width="36" class="style1">Baik</td>
                <td width="29" class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td width="142" class="style1">Gagal</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanda-tanda    Kebocoran</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_tandakebocoran'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Skope dicuci oleh</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_skope'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="19" class="style1">&nbsp;</td>
                <td height="19" class="style1">No. Bath cidex</td>
                <td height="19" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_nobath'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Mulai Perendam Jam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_mulaiperendaman'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Selesai Perendam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_selesaiperendaman'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['s_penanggungjawab'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan air bersih</td>
                <td class="style1"></td>
                <td class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["s_spoel_airbersih"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td class="style1">Ya</td>
                <td class="style1"><label><span class="kotak">
                  <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                </span></label>                </td>
                <td class="style1">Tidak</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan Alkohol    70%</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["s_spoel_alkohol"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td class="style1">Ya</td>
                <td class="style1"><label>
                  <span class="kotak">
                  <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                  </span></label>                </td>
                <td class="style1">Tidak</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><?=$dP['s_penanggungjawab2'];?></td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label></label>                </td>
              </tr>
          </table></td>
          <td><table width="474" height="374" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
              <col width="164" />
              <col width="11" />
              <col width="140" />
              <col width="105" />
              <tr height="20">
                <td width="4" height="20" class="style1">&nbsp;</td>
                <td width="246" class="style1">Daftar    Proses Akhir</td>
                <td width="9" class="style1">:</td>
                <td colspan="2" class="style1">&nbsp;</td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanggal - Date</td>
                <td class="style1"></td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_date'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tes Kebocoran - Leak    Test</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["a_teskebocoran"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td class="style1">Baik</td>
                <td class="style1"><label>
                  <span class="kotak">
                  <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                  </span></label>                </td>
                <td class="style1">Gagal</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Tanda-tanda    Kebocoran</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_tandakebocoran'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Skope dicuci oleh</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_skope'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="19" class="style1">&nbsp;</td>
                <td height="19" class="style1">No. Bath cidex</td>
                <td height="19" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_nobath'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Mulai Perendam Jam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_mulaiperendaman'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Selesai Perendam</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_selesaiperendaman'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label>
                  <?=$dP['a_penanggungjawab'];?>
                </label>                </td>
              </tr>
              <tr height="20">
                <td height="20" colspan="2" class="style1">&nbsp;</td>
                <td class="style1"></td>
                <td colspan="2" class="style1"></td>
                <td colspan="2" class="style1">&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan air bersih</td>
                <td class="style1"></td>
                <td width="35" class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["a_spoel_airbersih"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td width="26" class="style1">Ya</td>
                <td width="26" class="style1"><label>
                  <span class="kotak">
                  <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                  </span></label>                </td>
                <td width="126" class="style1">Tidak</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Spoel dengan Alkohol    70%</td>
                <td height="20" class="style1">&nbsp;</td>
                <td class="style1"><label>
                  </label>
                  <div class="kotak">
                    <? $t1=explode(",",$isi["a_spoel_alkohol"]);?>
                    <? if($t1[0]=="1"){echo "&radic;";}else{echo "&times;";}?>
                  </div>
                  <label></label></td>
                <td class="style1">Ya</td>
                <td class="style1"><label>
                  <span class="kotak">
                  <? if($t1[1]=="2"){echo "&radic;";}else{echo "&times;";}?>
                  </span></label>                </td>
                <td class="style1">Tidak</td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">Penanggung Jawab</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><?=$dP['a_penanggungjawab2'];?></td>
              </tr>
              <tr height="20">
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td height="20" class="style1">&nbsp;</td>
                <td colspan="4" class="style1"><label></label>                </td>
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
                <td>1. Gangguan rasa aman : </td>
                <td>&nbsp;</td>
                <td><label>
                  <input name="radiobutton[0]" type="radio" value="1" />
                  cemas b</label></td>
                <td>&nbsp;</td>
                <td colspan="4"><label>
                  <input name="radiobutton[0]" type="radio" value="2" />
                  d rencana tindakan ENDOSKOPI</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="35"></td>
                <td></td>
                <td>2. Gangguan rasa nyaman : </td>
                <td>&nbsp;</td>
                <td><label>
                  <input name="radiobutton[1]" type="radio" value="1" />
                  nyeri uluhati b</label></td>
                <td>&nbsp;</td>
                <td colspan="4"><label>
                  <input name="radiobutton[1]" type="radio" value="2" />
                  d peningkatan asam lambung</label></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="3">3.
                  <label>
                    <input name="radiobutton[2]" type="radio" value="1" />
                    Perubahan pola makan (Puasa) b</label></td>
                <td>&nbsp;</td>
                <td colspan="4"><label>
                  <input name="radiobutton[2]" type="radio" value="2" />
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
                  <input name="radiobutton[3]" type="radio" value="1" />
                  YA</label></td>
                <td width="82"><label>
                  <input name="radiobutton[3]" type="radio" value="2" />
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['anesfar'];?>
                </span> mg/iv</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['pethidine'];?>
                </span> mg/iv</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['adrenaline'];?>
                </span> mg</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['recopol'];?>
                </span> mg</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['sa'];?>
                </span> mg</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['buscopan'];?>
                </span> mg</label></td>
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
                <td colspan="2"><label> <span class="style1">
                  <?=$dP['aetoxysclerol'];?>
                </span> mg</label></td>
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
                  <?=$dP['fatu_supp'];?>
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
                  <?=$dP['xylocain_Spray'];?>
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
                <td width="34">TD :
                  <label></label></td>
                <td width="146"><span class="style1">
                  <?=$dP['td'];?>
                </span> mmHg</td>
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
                    <?=$dP['spo2'];?>
                  </span></label></td>
                <td colspan="2">R :
                  <label> <span class="style1">
                    <?=$dP['r'];?>
                  </span> x/m</label></td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="3">d. Monitoring perdarahan</td>
                <td></td>
                <td></td>
                <td colspan="2"><label>
                  <input name="radiobutton[4]" type="radio" value="1" />
                  Ada
                  <input name="radiobutton[4]" type="radio" value="2" />
                  Tidak</label></td>
                <td colspan="2">Bila ada: _____________cc </td>
                <td>&nbsp;</td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="2">e. Monitoring alat</td>
                <td></td>
                <td></td>
                <td>:</td>
                <td colspan="4"><label>
                  <input name="radiobutton[5]" type="radio" value="1" />
                  Baik
                  <input name="radiobutton[5]" type="radio" value="2" />
                  Kurang
                  <input name="radiobutton[5]" type="radio" value="3" />
                  Rusak</label></td>
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
                <td colspan="3">1. Gangguan rasa nyaman</td>
                <td>:</td>
                <td colspan="5"><label>
                  <input name="radiobutton[6]" type="radio" value="1" />
                  Nyeri b</label>
                    <label>
                    <input name="radiobutton[6]" type="radio" value="2" />
                      d proses tindakan ENDOSKOPY</label></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="8">2. Potensial perdarahan saluran cerna atas / bawah
                  <label><span class="style1">
                    <?=$dP['potensial_perdarahan'];?>
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
                  <?=$dP['resti_infeksi'];?>
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
                  <?=$dP['resti_aspirasi'];?>
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
                  <?=$dP['resti_syok'];?>
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
                  <label> <span class="style1">
                    <?=$dP['selesai_tindakan'];?>
                  </span> WIB</label></td>
                <td colspan="2"></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">b. Posisi Pasien</td>
                <td>:</td>
                <td colspan="4"><label>
                  <input name="radiobutton[7]" type="radio" value="1" />
                  Miring Kiri
                  <input name="radiobutton[7]" type="radio" value="2" />
                  Kanan
                  <input name="radiobutton[7]" type="radio" value="3" />
                  Terlentang</label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">c. Keadaan umum pasien</td>
                <td>:</td>
                <td colspan="4"><label>
                  <input name="radiobutton[8]" type="radio" value="1" />
                  Baik
                  <input name="radiobutton[8]" type="radio" value="2" />
                  Sedang
                  <input name="radiobutton[8]" type="radio" value="3" />
                  Buruk (CM/Delir/Coma) </label></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td colspan="4">d. Lama Observasi</td>
                <td>:</td>
                <td colspan="2"><label>
                  <input name="radiobutton[9]" type="radio" value="1" />
                  1/2
                  <input name="radiobutton[9]" type="radio" value="2" />
                  1
                  <input name="radiobutton[9]" type="radio" value="3" />
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
                    <?=$dP['spuit_5cc'];?>
                  </span></label></td>
                <td></td>
                <td colspan="2">i. Tegaderm</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['tegaderm'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>b. Spuit 3cc</td>
                <td></td>
                <td>: <span class="style1">
                  <?=$dP['spuit_3cc'];?>
                </span></td>
                <td></td>
                <td colspan="2">j. Aquabidest</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['aquabidest'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>c. Spuit 10cc</td>
                <td></td>
                <td>: <span class="style1">
                  <?=$dP['spuit_10cc'];?>
                </span></td>
                <td></td>
                <td colspan="2">k. Xylocain Jelly</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['xylocain_jelly'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td>d. Spuit 20cc</td>
                <td></td>
                <td>: <span class="style1">
                  <?=$dP['spuit_20cc'];?>
                </span></td>
                <td></td>
                <td colspan="2">l. Selang O2</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['selang_O2'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">e. Infus set / Blood Set</td>
                <td>: <span class="style1">
                  <?=$dP['infus_set'];?>
                </span></td>
                <td></td>
                <td colspan="2">m. Alkohol Swab</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['alkohol_swab'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">f. Cidex opa / eidezime</td>
                <td>: <span class="style1">
                  <?=$dP['cidex_opa'];?>
                </span></td>
                <td></td>
                <td colspan="2">n. Nacl 0,9%</td>
                <td colspan="2">: <span class="style1">
                  <?=$dP['nacl'];?>
                </span></td>
                <td></td>
                <td></td>
              </tr>
              <tr height="20">
                <td height="20"></td>
                <td></td>
                <td colspan="2">g. Vasofik No. 20.22.24</td>
                <td>: <span class="style1">
                  <?=$dP['vasofik'];?>
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
                <td>: <span class="style1">
                  <?=$dP['neddle'];?>
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
  <tr>
    <td style="font:bold 16px tahoma;">&nbsp;</td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2">
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    </td>
                    <td width="20%" align="right"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
</table>
</div>
</body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('nama')){
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }

        function ambilData(){		
            //var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('diagnosa1').val(a.cellsGetValue(a.getSelRow(),3));
			//$('#id').val(sisip[0]);
			//$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			//$('#act').val('edit');
			
					
            var sisip = a.getRowId(a.getSelRow()).split('|');
			 

			$('#id').val(sisip[0]);
			$('#gastroskope').val(sisip[1]);
			$('#colonoskope').val(sisip[2]);
			$('#duadenoskope').val(sisip[3]);
			$('#bronkoskope').val(sisip[4]);
			
			$('#s_tgl').val(sisip[5]);
			$('#s_teskebocoran').val(sisip[6]);
			$('#s_txtSafari').val(sisip[7]);
			$('#s_tanda').val(sisip[8]);
			$('#s_skope').val(sisip[9]);
			$('#s_nobat').val(sisip[10]);
			$('#s_nomulai').val(sisip[11]);
			$('#s_selesai').val(sisip[12]);
			$('#s_pj1').val(sisip[13]);
			$('#s_cekair').val(sisip[14]);
			$('#s_cekalkohol').val(sisip[15]);
			$('#s_pj2').val(sisip[16]);
			
			$('#a_tgl').val(sisip[17]);
			$('#a_teskebocoran').val(sisip[18]);
			$('#a_tanda').val(sisip[19]);
			$('#a_skope').val(sisip[20]);
			$('#a_nobath').val(sisip[21]);
			$('#a_nomulai').val(sisip[22]);
			
			$('#a_selesai').val(sisip[23]);
			$('#a_pj1').val(sisip[24]);
			$('#a_cekair').val(sisip[25]);
			$('#a_cekalkohol').val(sisip[26]);
			$('#a_pj2').val(sisip[27]);

			//var p="id*-*"+sisip[0]+"*|*identitas*-*"+sisip[1]+"";
			 //$('#note').val(sisip[10]);
			 //cek(sisip[2]);
			 /*centang(sisip[5]);
			 centang2(sisip[8]);
			 centang3(sisip[9]);
			 centang4(sisip[11]);
			 centang5(sisip[13]);
			 centang6(sisip[14]);
			 centang7(sisip[17]);
			 centang8(sisip[19]);
			 centang9(sisip[20]);
			 cek(sisip[22]);*/
			 
			 /*$('#inObat').load("14.form_terapi_pulang.php?type=ESO&id="+sisip[0]);
			 $('#inObat2').load("14.form_kembali_kontrol.php?type=ESO&id="+sisip[0]);*/
			 $('#act').val('edit');
			 
			 
			 //$('#kronologis').val(sisip[2]);
			 //$('#tindakan').val(sisip[13]);
			 
            fSetValue(window,p);
			
        }

        function hapus(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
				}

        }

        function batal(){
			//resetF();
			$('#tampil_input').slideUp(1000,function(){
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("14.form_terapi_pulang.php");
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("endoskopy_and_bronchoscopy_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Checklist Endoskopi Saluran Cerna");
        a.setColHeader("NO,NAMA PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,,,");
        a.setColWidth("20,300,150,120");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("endoskopy_and_bronchoscopy_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#tampil_input').slideDown(1000,function(){
		//toggle();
		});
			
			}
		
		
		/*function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			
			else
			{	
				window.open("14.checklisttrasfusi.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			}
			
		}*/
		function cetak(){
		 var id = document.getElementById("id").value;
		 if(id==""){
				var idx =a.getRowId(a.getSelRow()).split('|');
				id=idx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("endoskopy_and_bronchoscopy.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		
/*function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[0]'];
		var list2 = document.form1.elements['radio[0]'];
		var list3 = document.form1.elements['radio[0]'];
		var list4 = document.form1.elements['radio[0]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}

function centang2(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[1]'];
		var list2 = document.form1.elements['radio[1]'];
		var list3 = document.form1.elements['radio[1]'];
		var list4 = document.form1.elements['radio[1]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}
	
	function centang3(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[2]'];
		var list2 = document.form1.elements['radio[2]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang4(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[3]'];
		var list2 = document.form1.elements['radio[3]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang5(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[4]'];
		var list2 = document.form1.elements['radio[4]'];
		var list3 = document.form1.elements['radio[4]'];
		var list4 = document.form1.elements['radio[4]'];
		var list5 = document.form1.elements['radio[4]'];
		var list6 = document.form1.elements['radio[4]'];
		
		
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
		if ( list5.length > 4 )
		{
		 for (i = 4; i < list5.length; i++)
			{
			  if (list5[i].value==list[4])
			  {
			   list5[i].checked = true;
			  }
		  }
		}
		if ( list6.length > 5 )
		{
		 for (i = 5; i < list6.length; i++)
			{
			  if (list6[i].value==list[5])
			  {
			   list6[i].checked = true;
			  }
		  }
		}
	}
	
	function centang6(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[5]'];
		var list2 = document.form1.elements['radio[5]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
	}
	
	function centang7(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[6]'];
		var list2 = document.form1.elements['radio[6]'];
		var list3 = document.form1.elements['radio[6]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
	
	function centang8(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[7]'];
		var list2 = document.form1.elements['radio[7]'];
		var list3 = document.form1.elements['radio[7]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
	}
	
	function centang9(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['radio[8]'];
		var list2 = document.form1.elements['radio[8]'];
		var list3 = document.form1.elements['radio[8]'];
		var list4 = document.form1.elements['radio[8]'];
	
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			  if (list1[i].value==list[0])
			  {
			   list1[i].checked = true;
			  }
		  }
		}
		if ( list2.length > 1 )
		{
		 for (i = 1; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 2 )
		{
		 for (i = 2; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 3 )
		{
		 for (i = 3; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
	}*/
	
	function cek(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['c_chk[]'];
		if ( list1.length > 0 )
		{
		 for (i = 0; i < list1.length; i++)
			{
			var val=list[0].split(',');
			  if (list1[i].value==val[i])
			  {
			   list1[i].checked = true;
			  }else{
					list1[i].checked = false;
					}
		  }
		}
		}

/*function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}*/
	
	
	
 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
				jam();
            }
            el.type = 'text';
            el.className = 'jam';
			el.size = 10;
            el.value = '<?=date('H:i:s')?>';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'td[]';
                el.id = 'td[]';
            }else{
                el = document.createElement('<input name="td[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'nadi_t1[]';
                el.id = 'nadi_t1[]';
            }else{
                el = document.createElement('<input name="nadi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'respirasi_t1[]';
                el.id = 'respirasi_t1[]';
            }else{
                el = document.createElement('<input name="respirasi_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'suhu_t1[]';
                el.id = 'suhu_t1[]';
            }else{
                el = document.createElement('<input name="suhu_t1[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'heparin[]';
                el.id = 'heparin[]';
            }else{
                el = document.createElement('<input name="heparin[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tmp[]';
                el.id = 'tmp[]';
            }else{
                el = document.createElement('<input name="tmp[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ap[]';
                el.id = 'ap[]';
            }else{
                el = document.createElement('<input name="ap[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'qb[]';
                el.id = 'qb[]';
            }else{
                el = document.createElement('<input name="qb[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufr[]';
                el.id = 'ufr[]';
            }else{
                el = document.createElement('<input name="ufr[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'ufg[]';
                el.id = 'ufg[]';
            }else{
                el = document.createElement('<input name="ufg[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'keterangan[]';
                el.id = 'keterangan[]';
            }else{
                el = document.createElement('<input name="keterangan[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }

function addRowToTable2()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tgl');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tgl[]';
                el.id = 'tgl[]';
				
            }else{
                el = document.createElement('<input name="tgl[]"/>');
            }
            el.type = 'text';
            el.className = 'tgl';
            el.value = '';
			el.size = '15';
			//el.onclick = 'gfPop.fPopCalendar(document.getElementById("tgl2"),depRange)';
			

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
			//var td3=x.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'hari[]';
                el.id = 'hari[]';
            }else{
                //el = document.createElement('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
				el = document.createElement('<input name="hari[]"/>');
            }
            el.type = 'select';
            el.value = '';
			el.size = 15;
			el.select('<select name="hari[]"> <option>Laki-laki</option><option>Perempuan</option></select>');
			
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 15;

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'dokter[]';
                el.id = 'dokter[]';
            }else{
                el = document.createElement('<input name="dokter[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 30;
            

            cellRight.className = 'tdisi2';
            cellRight.appendChild(el);
			
// right cell
            

// right cell
            

// right cell
            
			
// right cell
            
			
// right cell
            

// right cell
            
			
// right cell
            

// right cell
            
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = '../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi2';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
   tanggalan();
    }
function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tgl');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 3)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                //tds[0].innerHTML=i-2;
            }
        }
    }

/*tampil = function(cek) 
{
  if (cek.checked) 
  {
    $('#status').slideDown(600);
  } 
  else 
  {
    $('#status').slideUp(600);
  }
}*/
/*var appended = $('<div />').text("You're appendin'!");
appended.id = 'appended';*/
$('input:radio[name="radio[0]"]').change(
    function tampil(){
        if ($(this).val() == 3) {
            $('#status').slideDown(600);
        }
        else {
            $('#status').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('_diet').value="";
        }
		
    });
	
$('input:radio[name="radio[0]"]').change(
    function tampil2(){
        if ($(this).val() == 4) {
            $('#status2').slideDown(600);
        }
        else {
            $('#status2').slideUp(600);
			document.getElementById('_batas').value="";
        }
    });
	
$('input:radio[name="radio[2]"]').change(
    function tampil3(){
        if ($(this).val() == '2') {
            $('#status3').slideDown(600);
        }
        else {
            $('#status3').slideUp(600);
        }
    });
	
$('input:radio[name="radio[6]"]').change(
    function tampil4(){
        if ($(this).val() == '3') {
            $('#status4').slideDown(600);
        }
        else {
            $('#status4').slideUp(600);
        }
    });
	
$('input:radio[name="radio[8]"]').change(
    function tampil5(){
        if ($(this).val() == '4') {
            $('#status5').slideDown(600);
        }
        else {
            $('#status5').slideUp(600);
        }
    });

/*function kejadian()
		{
			var nutrisi = document.getElementById('nutrisi').value;
			if(nutrisi=="Diet Khusus")
			{
				$('#status').slideDown(600);
				
			}
			else
			{
				$('#status').slideUp(600);
				$('#status').checked(false);
				document.getElementById('nutrisi').value="";
			}
			//document.getElementById('act').value = "edit";
			
		}
*/

    </script>
    <script>
var idrow = 3;

function tambahrow(){
    var x=document.getElementById('datatable').insertRow(idrow);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	var td6=x.insertCell(5);
	var td7=x.insertCell(6);
	var td8=x.insertCell(7);
	var td9=x.insertCell(8);
	var td10=x.insertCell(9);
	var td11=x.insertCell(10);
	var td12=x.insertCell(11);
	
	
    td1.innerHTML="<input type='text' class='jam' size='10' name='jam[]' id='jam"+idx+"'>";jam();
	td2.innerHTML="<input type='text' id='td[]' name='td[]' size ='5'>";
    td3.innerHTML="<input type='text' id='nadi_t1[]' name='nadi_t1[]'  size='5'>";
    td4.innerHTML="<input type='text' id='respirasi_t1[]' name='respirasi_t1[]'  size='5'>";	
	td5.innerHTML="<input type='text' id='suhu_t1[]' name='suhu_t1[]'  size='5'>";
	td6.innerHTML="<input type='text' id='heparin[]' name='heparin[]'  size='5'>";
	td7.innerHTML="<input type='text' id='tmp[]' name='tmp[]'  size='5'>";
	td8.innerHTML="<input type='text' id='ap[]' name='ap[]'  size='5'>";
	td9.innerHTML="<input type='text' id='qb[]' name='qb[]'  size='5'>";
	td10.innerHTML="<input type='text' id='ufr[]' name='ufr[]'  size='5'>";
	td11.innerHTML="<input type='text' id='ufg[]' name='ufg[]'  size='5'>";
	td12.innerHTML="<input type='text' id='keterangan[]' name='keterangan[]'  size='10'>";
    idrow++;
}

function del(){
    if(idrow>3){
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script>
var idrow2 = 3;

function tambahrow2(){
    var x=document.getElementById('datatable2').insertRow(idrow2);
	var idx2 = $('.jam2 tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
	var td3=x.insertCell(2);
 
    td1.innerHTML="<input type='text' class='jam2' size='10' name='jam2[]' id='jam2"+idx+"'>";jam2();
	td2.innerHTML="<textarea id='saran[]' name='saran[]' rows ='3' cols='70'>";
	td3.innerHTML="";
    idrow2++;
}

function del(){
    if(idrow>3){
        var y=document.getElementById('datatable2').deleteRow(idrow-1);
        idrow--;
    }
}

/*$('.tanggal').on('click', '.hapus',function(){
		if(confirm('Apakah anda yakin?')){
			var id = $(this).parents('tr.item').find('td:eq(0) input:eq(0)').val();
			var elm = $(this).parents('tr.item');
			$.ajax({
				type: 'post',
				data: 'type=delete&id='+id,
				url: '14.resume_kep_act.php',
				success: function(){
					elm.remove();
				}
			});
		}
	});*/
</script>
<script type="text/javascript">
function text0() {
document.getElementById("td_tidur2").value = "" + "" + document.getElementById("td_tidur").value + "\n" }
function text1() {
document.getElementById("duduk2").value = "" + "" + document.getElementById("duduk").value + "\n" }
function text2() {
document.getElementById("nadi2").value = "" + "" + document.getElementById("nadi").value + "\n" }
function text3() {
document.getElementById("respirasi2").value = "" + "" + document.getElementById("respirasi").value + "\n" }
function text4() {
document.getElementById("suhu2").value = "" + "" + document.getElementById("suhu").value + "\n" }
function text5() {
document.getElementById("keluhan2").value = "" + "" + document.getElementById("keluhan").value + "\n" }
function text6() {
document.getElementById("perawat11").value = "" + "" + document.getElementById("perawat1").value + "\n" }
function text7() {
document.getElementById("perawat22").value = "" + "" + document.getElementById("perawat2").value + "\n" }
</script>

<script>
$(document).ready(function(){
    var inpA = "input[rel=Ajumlah]";
    var inpB = "input[rel=Bjumlah]";
    
    $(inpA).bind('keyup',function() {
        var avalA=0;
        var bVal = parseInt($('#jumlah2').val(),10);
        $(inpA).each(function() {
            if(this.value !='') avalA += parseInt(this.value,10);
        });
        $('#jumlah').val(avalA);
        $('#total').val(avalA - bVal);
        console.log('Value avalA: ' + avalA);
    });
    
    $(inpB).bind('keyup',function() {
        var avalB=0;
        var aVal = parseInt($('#jumlah').val(),10);
        $(inpB).each(function() {
            if(this.value !='') avalB += parseInt(this.value,10);
        });
        $('#jumlah2').val(avalB);
        $('#total').val(aVal - avalB);
        console.log('Value avalB: ' + avalB);
    });
});

function enable_text(status)
{
status=!status;
document.form1.istirahat.disabled = status;
document.form1.tgl_mulai.disabled = status;
document.form1.tgl_akhir.disabled = status;
}
function enable_text2(status)
{
status=!status;
document.form1.inap.disabled = status;
document.form1.tgl_mulai2.disabled = status;
document.form1.tgl_akhir2.disabled = status;
}
function enable_text3(status)
{
status=!status;
document.form1.tgl_per.disabled = status;
}

</script>
</html>

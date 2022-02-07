<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->
    
        <title>.: PERSETUJUAN TINDAKAN BIUS :.</title>
        <style>
        body{background:#FFF;}
        </style>
    </head>
<?php
	include "setting.php";
?>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
        </div>

        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        
        <!-- div tindakan-->
        <div align="center" id="div_tindakan">
        <!--    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">SURAT KETERANGAN PEMERIKSAAN MATA</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" >
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="center"><div id="metu" style="display:none;">
    <form id="form1" name="form1" action="25.persetujuantindakanbiusutils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
                    <table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=$tgl;?></td>
        <td>Usia</td>
        <td>:
          <?=$umur;?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$noRM;?>        </td>
        <td>No Registrasi </td>
        <td>: <?=$no_reg;?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$kamar;?>
            <?=$kelas;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$alamat;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font:bold 14px tahoma;">PERSETUJUAN TINDAKAN PEMBIUSAN</td>
  </tr>
  <tr>
    <td style="border:1px solid #000000;"><table cellspacing="2" cellpadding="2">
      <col width="18" />
      <col width="20" />
      <col width="29" />
      <col width="138" />
      <col width="70" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="47" />
      <tr height="25">
        <td width="11" height="25">&nbsp;</td>
        <td width="16">I.</td>
        <td colspan="2">Consent</td>
        <td width="68"></td>
        <td width="56"></td>
        <td width="41"></td>
        <td width="79"></td>
        <td width="3"></td>
        <td width="91"></td>
        <td width="44"></td>
        <td width="52"></td>
        <td width="48"></td>
        <td width="50"></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="4">Bersama ini saya : <u><?=$dokter?></u></td>
        <td colspan="8">(Dr. Yang Melakukan Pre    op) meminta consent dan wewenang untuk</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="12">melakukan pembiusan umum    / spinal / epidural / lokal untuk procedur pembedahan  / pengobatan</td>
        </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="2">I, <u><?=$dokter?></u></td>
        <td colspan="10">here by request consent to authorize the administration of general/spinal/local anesthesia during</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="3">the pending procedure/operation/treatment</td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="6">Adapun alternatif untuk pembiusan ini adalah : <input type="text" name="alterI1" id="alterI1" /></td>
        <td colspan="2">Alternatif lain :</td>
        <td colspan="4"><input type="text" name="alterI2" id="alterI2" /></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="6">Other alternative for anaesthesia is <input type="text" name="alterE1" id="alterE1" /></td>
        <td colspan="6">Other    Alternative : <input type="text" name="alterE2" id="alterE2" /></td>
        </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td>II.</td>
        <td colspan="2">Risiko</td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td width="35">Risk</td>
        <td width="166"></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">1</td>
        <td colspan="11">Saya menyadari bahwa    pelayanan di Rumah Sakit ini merupakan suatu team approach (termasuk dokter    dan perawat</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">anestasi) dan    bahwasannya anestesi untuk tindakan operasi ini akan dilakukan atau dibawah    pengawasan:</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that a team    approach to anesthesia care (including physician dan nurse anesthesia    assistance) is used at this hospital</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">and that anesthesia for    my operation will be provided by / or under the supervision of</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2"><u><?=$dokter?></u></td>
        <td>Sp An</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">Dokter yang melaksanakan    anestesi / Anesthesiologist</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">2</td>
        <td colspan="11">Saya menyadari dan    mengerti sepenuhnya penjelasan dokter spesialis anestesi bahwa jenis    pembiusan apapun yang&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dilakukan selalu    mengandung konsekwensi dan resiko. Resiko potensial yang mungkin terjadi    termasuk perubahan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">tekanan darah, reaksi    obat (alergi), henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf    bahkan kematian.&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="8">Saya menyadari hal ini    dan resiko serta komplikasi lain yang juga mungkin dapat terjadi.</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that,    regardless of the type of anesthesia used, there are a number of risk and    consequences that may occur. The risks</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="9">include but are not    limited to changes in blood pressure, drug reactions, cardiac arrest, brain    damage, paralysis, nerve</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">damage and death. I    understand that these or other risks or complications may occur.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">3</td>
        <td colspan="11">Saya menyadari dan    mengerti bahwa dalam praktek ilmu kedokteran, bukan merupakan ilmu    pengetahuan yang pasti</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">(exact science) dan saya    menyadari tidak seorangpun dapat menjanjikan atau menjamin sesuatu yang    berhubungan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="4">dengan tindakan medis    termasuk pembiusan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">I am aware that the    practice of anaesthesiologi, medicine and surgery is not an exact science and    acknowledge that no one has</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="9">given to me any promises    or guarantees regarding the effectiveness or risk relating to the    administration of anesthesia</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">4</td>
        <td colspan="11">Saya menyadari dan    mengerti bahwa obat-obatan yang saya dapatkan sebelum prosedur pembedahan dan    pembiusan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dapat saja menimbulkan    komplikasi bagi pembiusan dan pembedahan. Oleh karena itu sudah kewajiban dan    tanggung</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">jawab saya untuk    memberikan informasi kepada dokter semua obat-obatan yang saya minum,    termasuk aspirin,</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">kontrasepsi, obat-obatan    flu, narkotik, marijuana, kokain dan lain-lain.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that any in    my medication I am taking may cause complications with anesthesia and    surgery, I acknowledge that it is my</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">responsibility and in my    best interest, to inform my physicians of any medications I am taking    including but not limited to aspirin,</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">contraceptives, cold    remedies, narcotics, marijuana and cocaine.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">5</td>
        <td colspan="11">Saya sudah membaca    formulir ini secara teliti, mengerti dan menyetujui penjelasan tentang    tindakan yang akan&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dilakukan termasuk    kemungkinan komplikasi-komplikasi yang mungkin terjadi. Oleh sebab itu saya    menyatakan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">mengerti isinya dan    menerima persyaratan yang tercantum.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I have read this form    carefully and / or it has been fully explained to me and I certify that I    understand its contents and I accept its</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">term. My    anaesthesiologist has discussed with me and my family the anesthesia plan and    applicable alternatives. All my</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">questions have been    answered to my satisfaction.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <table cellspacing="2" cellpadding="0">
      <col width="17" />
      <col width="23" />
      <col width="33" />
      <col width="191" />
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
        <td width="17" height="20">&nbsp;</td>
        <td width="23">III.</td>
        <td colspan="6">KOMPLIKASI, KONDISI YANG    TIDAK TERDUGA DAN HASIL YANG DIPEROLEH</td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td width="37"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="5" style="font:10px tahoma;">COMPLICATIONS, UNFORESEEN    CONDITIONS, RESULT</td>
        <td width="99"></td>
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
        <td colspan="11">Saya menyadari    sepenuhnya bahwa pada tindakan medis, berbagai resiko dan komplikasi yang    tidak didiskusikan</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="11">sebelumnya mungkin dapat    timbul. Saya juga menyadari bahwa selama berlangsungnya tindakan tersebut,    ada</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="12">kemungkinan timbulnya    kondisi-kondisi yang tidak terduga dimana hal tersebut memerlukan tindakan -    tindakan perluasan&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="11">operasi yang berhubungan    dengan operasi yang sedang dilakukan; untuk itu saya menyetujui dilakukannya    tindakan</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="12">tersebut apabila    diperlukan. Selanjutnya, saya menyadari bahwa tidak ada jaminan atau    janji-jani yang diberikan kepada</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6">saya berhubungan dengan    hasil dari segala tindakan dan atau perawatan.</td>
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
        <td colspan="11" style="font:10px tahoma;">I am aware that in the    practice of medicine, other unexpected risks or complications not discussed    may occur. I also</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="12" style="font:10px tahoma;">understand that during    the course of the proposed procedure (s) unforeseen conditions may be    revealed requiring the</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="11" style="font:10px tahoma;">performance of    procedures specifically related to the consented surgery, and I authorize    such procedures to be the&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="11" style="font:10px tahoma;">performed. I further    acknowledge that no guarantee or promises have been given to me concerning    the result af any</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="2" style="font:10px tahoma;">procedure.</td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
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
        <td width="33"></td>
        <td width="191"></td>
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
        <td colspan="4">Disetujui oleh pasien /    Consent by patient</td>
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
        <td colspan="2" style="font:10px tahoma;">Tempat / Place, Tanggal / Date</td>
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
        <td colspan="4" align="center" style="border-bottom:1px solid #000;"><?=$nama?></td>
        <td></td>

        <td></td>
        <td></td>
        <td colspan="5" style="border-bottom:1px solid #000;"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="4">Tanda tangan dan nama    jelas (huruf balok)</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Tanda tangan saksi    keluarga dan nama jelas</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="3" style="font:10px tahoma;">Signature and Full Name    (block letters)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="font:10px tahoma;">Signature of family    witness and full name</td>
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
        <td colspan="4" align="center" style="border-bottom:1px solid #000;"><?=$dokter?></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="border-bottom:1px solid #000;"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="5">Tanda tangan dokter dan    nama jelas (huruf balok)</td>
        <td></td>
        <td></td>
        <td colspan="5">Tanda tangan saksi pihak    RSUD dan nama jelas</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="4" style="font:10px tahoma;">Signature of doctor and    Full Name(block letters)</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="font:10px tahoma;">Signature of hospital    witness and full name</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td style="border:1px solid #000000;"><table cellspacing="2" cellpadding="0">
      <col width="17" />
      <col width="23" />
      <col width="33" />
      <col width="191" />
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
        <td width="17" height="20">&nbsp;</td>
        <td colspan="12">Bila pasien&nbsp; berusia dibawah 21 tahun atau tidak dapat    memberikan persetujuan karena suatu alasan (*) tidak dapat</td>
        <td width="37"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="13">menandatangani surat    diatas, pihak Rumah Sakit dapat mengambil kebijaksanaan dengan memperoleh    tanda tangan dari&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="7">orang tua, pasangan,    anggota keluarga terdekat atau wali pasien.</td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td colspan="12">Where the patient is    below 21 years old or invalid or for some other reason, unable to sign the    above, the hospital reserves the discretion</td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td colspan="7">to obtain the signature    of parent, spouse, next of kin or guardian of the patient</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="23"></td>
        <td width="33"></td>
        <td width="191"></td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
        <td width="99"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12">* Jelaskan alasan <input type="text" name="alasan1" id="alasan1" style="width:350px;"/></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td colspan="3">&nbsp;&nbsp; Specify such other reason</td>
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
        <td colspan="12">Saya <input name="saya" id="saya" type="radio" value="1" <?php if($_POST['saya']=='1'){echo 'checked="checked"';}?>/>orang tua / <input name="saya" id="saya" type="radio" value="2" <?php if($_POST['saya']=='2'){echo 'checked="checked"';}?>/>pasangan / <input name="saya" id="saya" type="radio" value="3" <?php if($_POST['saya']=='3'){echo 'checked="checked"';}?>/>keluarga dekat / <input name="saya" id="saya" type="radio" value="4" <?php if($_POST['saya']=='4'){echo 'checked="checked"';}?>/>wali (coret yang tidak perlu) dari pasien : <u><?=$nama?></u></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td colspan="7">I the parent /spouse /    next of kin guardian (delete where applicable) of the patient</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="9">Membenarkan bahwa saya    memiliki hak untuk menerima segala kondisi lanjutan atas nama pasien</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td></td>
        <td colspan="6">Confirm that I have    authority to sign the consent form on behalf of the patient</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="8">Telah membaca, memahami    dan menerima semua informasi pada form persetujuan ini.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td></td>
        <td colspan="6">Have read and understand    accept all information on this consent&nbsp;    form</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="10">Memastikan bahwa saya    telah diberi penjelasan dan mengerti dengan baik tentang tindakan tersebut</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td></td>
        <td colspan="8">Confirm that I have    explained and fully understand about the treatment/procedure to be performed</td>
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
        <td colspan="4">Disetujui oleh pasien /    Consent by patient</td>
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
        <td colspan="2">Tempat / Place, Tanggal / Date</td>
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
        <td colspan="4" align="center" style="border-bottom:1px solid #000;"><?=$nama?></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="border-bottom:1px solid #000;"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="2">Tanda tangan dan nama    jelas</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Tanda tangan saksi 1    keluarga dan nama jelas</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="2">Signature and Full Name</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Signature of family    witness and full name</td>
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
        <td colspan="4" align="center" style="border-bottom:1px solid #000;"><?=$dokter?></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5" style="border-bottom:1px solid #000;"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="3">Tanda tangan dokter dan    nama jelas</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Tanda tangan saksi 2    keluarga dan nama jelas</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="2">Signature of doctor and    Full Name</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5">Signature of family    witness and full name</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td colspan="10" class="noline" align="center">
                    <input name="simpen" id="simpen" type="button" value="Simpan" onclick="simpan(this.value);" class="tblTambah"/>
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="liaten" type="button" value="View" onClick="return liat()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                </td>
        </tr>
</table>
</form>
                    </div><br/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td height="30"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnTambah" name="btnTambah" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                        <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" class="tblHapus"/>
                    <?php }?>    
                  </td>
                    <td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="window.open('25.persetujuantindakanbiusdepan.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUsr=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+document.getElementById('txtId').value)" class="tblViewTree">Cetak</button></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <!--Tindakan Unit:&nbsp;
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('25.persetujuantindakanbiusutils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
		<option value="">-ALL UNIT-</option>
                        <?php
                        /*	$rs = mysql_query("SELECT * FROM b_ms_unit unit WHERE unit.islast=1");
            	while($rows=mysql_fetch_array($rs)):
		?>
			<option value="<?=$rows["id"]?>" <?php if($rows["id"]==$unit_id) echo "selected";?>><?=$rows["nama"]?></option>
            <?	endwhile;
                        */
                        ?>
		</select>
                        -->
                    </td>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="3">
                        <div id="gridbox" style="width:925px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:925px;"></div>	</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            
<!--            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
<tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>-->
        </div>
        <!-- end div tindakan-->

       
    </body>
    <script type="text/JavaScript" language="JavaScript">
        function tambah(){
			/*$('#act').val('tambah');*/
			awal();
			$('#metu').slideDown(1000,function(){
		toggle();
		});
			}
        ///////////////////////////////////////////////////////////////////

        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            if(ValidateForm('alterI1,alterI2,alterE1,alterE2,alasan1','ind'))
            {
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("25.persetujuantindakanbiusutils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
						//goFilterAndSort();
            }
        }

		function edit(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#metu').slideDown(1000,function(){
		toggle();
		});
				}

        }
		
        function ambilData()
        {
            var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtId*-*"+sisip[0]+"*|*alterI1*-*"+sisip[1]+"*|*alterI2*-*"+sisip[2]+"*|*alterE1*-*"+sisip[3]+"*|*alterE2*-*"+sisip[4]+"*|*alasan1*-*"+sisip[5]+"";
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            centang(sisip[6]);
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus data ini ?"))
            {
                $('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					awal();
						goFilterAndSort();
            }
        }

        function batal(){
            awal();
			$('#metu').slideUp(1000,function(){
		toggle();
		});
        }

		function awal(){
			$('#act').val('tambah');
			var p="txtId*-**|*alterI1*-**|*alterI2*-**|*alterE1*-**|*alterE2*-**|*alasan1*-*";
			fSetValue(window,p);
			centang(1);
			
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("25.persetujuantindakanbiusutils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader(".: PERSETUJUAN TINDAKAN BIUS :.");
        a.setColHeader("NO,DOKTER,ALTERNATIF,ALTERNATIF LAIN,ALTERNATIVE,OTHER ALTERNATIVE,ALASAN,PENGGUNA");
        a.setIDColHeader(",,,,,,,");
        a.setColWidth("30,80,200,200,200,200,200,200");
        a.setCellAlign("center,left,left,left,left,left,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("25.persetujuantindakanbiusutils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
	
	function centang(tes){
		 var checkbox = document.form1.elements['saya'];
		 
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
		
	}	
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

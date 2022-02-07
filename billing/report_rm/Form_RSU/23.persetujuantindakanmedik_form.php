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
        <!-- end untuk ajax-->
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<title>Persetujuan Tindakan Medik</title>
</head>
<?
//include "setting.php";
?>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,
IF(
    p.alamat <> '',
    CONCAT(
      p.alamat,
      ' RT. ',
      p.rt,
      ' RW. ',
      p.rw,
      ' Desa ',
      bw.nama,',',
      ' Kecamatan ',
      wi.nama, ',',' ', wil.nama
    ),
    '-'
  ) AS almt_lengkap,
kk.no_reg as no_reg2,l.saksi as saksi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
LEFT JOIN b_ms_wilayah bw ON p.desa_id = bw.id 
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id 
LEFT JOIN b_ms_wilayah wil ON wil.id = p.kab_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:40px;
	}
.textArea{ width:100%;}
body{background:#FFF;}
        .style1 {font-size: 18px}
</style>
<body>
<div id="form_input" style="display:none">
<form id="form1" action="23.persetujuantindakanmedik_act.php">
<table width="800" border="0" align="center" style="font:12px tahoma;">
<tr>
  <td align="center"><span class="style1">FORM PERSETUJUAN TINDAK MEDIK</span></td>
</tr>
<tr>
<td align="center">&nbsp;</td>
</tr>
  <tr>
    <td><table width="512" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
        <td width="88">&nbsp;</td>
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
          <?=$dP['no_rm'];?></td>
        <td>No Registrasi </td>
        <td>: <?=$dP['no_reg2'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          / <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="3">:
          <?=$dP['almt_lengkap'];?></td>
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
    <td style="font:bold 14px tahoma;">PERSETUJUAN TINDAKAN MEDIK/BEDAH</td>
  </tr>
  <tr>
    <td style="font:bold 14px tahoma;"><em>COSENT TO MEDICAL/SURGICAL TREATMENT</em></td>
  </tr>
  <tr>
    <td><table width="809" border="0" style="border:1px solid #000000;">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table cellspacing="2" cellpadding="2">
          <col width="27" />
          <col width="43" />
          <col width="33" />
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
            <td height="20" width="27">&nbsp;</td>
            <td width="43"></td>
            <td width="33"></td>
            <td width="138"></td>
            <td width="20"></td>
            <td width="64"></td>
            <td width="51"></td>
            <td width="99"></td>
            <td width="13"></td>
            <td width="92"></td>
            <td width="49"></td>
            <td width="58"></td>
            <td width="54"></td>
            <td width="37"></td>
          </tr>
          <tr height="20">
            <td height="20" align="right">1.1</td>
            <td colspan="11">Yang bertanda tangan dibawah ini    menyetujui untuk dilaksanakan pada diri saya operasi/tindakan</td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="7" style="font:10px tahoma;"><em>The undersigned consent    to undergo the operation/procedure of:</em></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="9"><label>
            <input type="hidden" size="2" name="act" id="act" value="tambah" />
            <input type="hidden" name="id" id="id" value="" />
            <input type="hidden" name="idPel" id="idPel" value="<?php echo $idPel; ?>" />
              <select name="id_tindakan1" id="id_tindakan1">
              <option value="">--Pilih Tindakan--</option>
              <?php
          $sql="select * from b_ms_tindakan";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
          <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
          <?php
    	  }
	      ?>
              </select>
            </label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="13">Yang dilaksanakan oleh dokter:
              <?=$dP['dr_rujuk'];?></td>
            </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="3" style="font:10px tahoma;"><em>Which will be conducted    by doctor:</em></td>
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
            <td colspan="13">Cara kerja tujuan dan komplikasi    serta resiko yang mungkin terjadi dari tindakan tersebut telah dijelaskan    pada saya</td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="3">oleh dokter tersebut diatas</td>
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
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="11" style="font:10px tahoma;"><em>The nature, purpose dan    potential complications of which has been explained to me by the above    mentined doctor</em></td>
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
            <td colspan="9">Saya juga sudah dijelaskan mengenai    pilihan tindakan alternatif seperti di bawah ini:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="7" style="font:10px tahoma;"><em>I have also been    explained clearly regarding alternative procedures as follows:</em></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="9"><label>
              <select name="id_tindakan2" id="id_tindakan2">
              <option value="">--Pilih Tindakan--</option>
              <?php
          $sql2="select * from b_ms_tindakan";
          $query2 = mysql_query ($sql2);
          while($data2 = mysql_fetch_array($query2)){
		  ?>
          <option value="<?php echo $data2['id'];?>" ><?php echo $data2['nama']?></option>
          <?php
    	  }
	      ?>
              </select>
            </label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20" align="right">1.2</td>
            <td colspan="7">Yang bertanda tangan dibawah ini    juga menyatakan setuju terhadap:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="3"><em>The undersigned who    consent to:</em></td>
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
            <td>1.2.1</td>
            <td colspan="8">Transfusi darah dan produk-produk    lain dari darah, bila dirasa perlu oleh dokter</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="9" style="font:10px tahoma;"><em>The transfusion of blood    and other blood derived products as the surgeon or physician feels necessary</em></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td>1.2.2</td>
            <td colspan="11">Ahli bedah yang bertugas mencari    konsultasi atau mendapat bantuan dari dokter lain yang berkaitan jika&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="8">dirasakan perlu, selama pelaksanaan    tindakan atau operasi berlangsung</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="10" style="font:10px tahoma;"><em>The attending    physician/surgeon seeking consultation or assistance form other relevant    specialist when it is</em></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="5" style="font:10px tahoma;"><em>needed during the course    of this operation/prosedure</em></td>
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
            <td>1.2.3</td>
            <td colspan="11">Pasien dapat dirawat diruang    intensif setelah operasi sesuai kondisi pasien. Untuk pelaksanaan perawatan</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="8">intensive dan tindakan medis    lazimnya dilakukan di perawatan&nbsp;    Intensif.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="10" style="font:10px tahoma;"><em>Patient may be admitted    to the Intensive&nbsp; Care Unit based on    patient's condition-For any medical care and&nbsp;</em></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="6" style="font:10px tahoma;"><em>treatment that is    normally conducted in the Intensive Care</em></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td>1.2.4</td>
            <td colspan="11">Bila staf kamar bedah mengalami    luka tusuk/ terciprat cairan tubuh pasien, pasien setuju diperiksa darahnya</td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="9" style="font:10px tahoma;"><em>In the event of staff    receiving a needlestick/splash injury, agree to laboratory testing of my    blood</em></td>
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
            <td height="20" align="right">1.3</td>
            <td colspan="5">Risiko/Manfaat dari tindakan yang    ditawarkan</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="3" style="font:10px tahoma;"><em>Risk/Benefits of proposed    procedure (s)</em></td>
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
            <td>1.3.1</td>
            <td colspan="11">Selain dari keuntungan yang mungkin    didapat dari tindakan yang ditawarkan, saya menyadari bahwa segala&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="8">tindakan medis dan operasi    mengandung risiko seperti di bawah ini:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td rowspan="2"></td>
            <td colspan="10" style="font:10px tahoma;"><em>Just as there may be    benefits to the procedure(s) proposed, I also understand that medical and    surgical procedure</em></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="2"><em>involve risk such as:</em></td>
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
            <td colspan="11"><label>
              <textarea name="resiko" cols="60" rows="3" id="resiko"></textarea>
            </label></td>
            <td></td>
          </tr>
          
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="11"></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="12">Resiko tersebut termasuk reaksi    alergi, perdarahan, pembekuan darah, infeksi, efek sampingan dari penggunaan</td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td rowspan="2"></td>
            <td colspan="8">obat-obat, atau bahkan hilangnya    sebagian dari fungsi tubuh dan kematian</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="11"><em>The risk include    allergic reaction, bleeding, blood clots, infections, side effects of drugs    and even loss of body function or life</em></td>
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
            <td>1.3.2</td>
            <td colspan="12">Saya juga menyadari risiko-risiko    yang telah tercantum dalam lampiran tersebut berhubungan dengan prosedur&nbsp;</td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td></td>
            <td colspan="3">yang ditawarkan kepada saya</td>
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
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="11" style="font:10px tahoma;"><em>I also acknowledge that    the particular risk enumerated in the attachment are associated with the    procedure (s) proposed</em></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td></td>
            <td colspan="2"><em>for me</em></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="6"></td>
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
            <td colspan="6"></td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20" align="right">1.4</td>
            <td colspan="7">Komplikasi, kondisi yang tak terduga    &amp; hasil yang diperoleh</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="5" style="font:10px tahoma;"><em>Complications, Unforeseen    Conditions, Results</em></td>
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
            <td colspan="12">Saya menyadari sepenuhnya bahwa    pada tindakan medis, berbagai resiko dan komplikasi yang tidak didiskusikan</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="12">sebelum mungkin dapat timbul. Saya    juga menyadari bahwa selama berlangsungnya tindakan tersebut, ada&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="12">kemungkinan timubulnya    kondisi-kondisi yang tidak terduga dimana hal tersebut memerlukan    tindakan-tindakan&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="12">perluasan operasi yang berhubungan    dengan operasi yang dilakukan ; untuk itu saya menyetujui dilakukannya&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="12">tidakan tersebut, apabila    diperlukan. Selanjutnya, saya menyadari bahwa tidak ada jaminan atau    janji-janji yang&nbsp;</td>
            <td></td>
          </tr>
          <tr height="20">
            <td height="20">&nbsp;</td>
            <td colspan="10">diberikan kepada saya berhubungan    dengan hasil dari segala tindakan dan atau perawatan</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="12" style="font:10px tahoma;"><em>I am aware that in the    practice of medicine, other unexpected risk or complications not discussed my    occur. I also understand that</em></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="12" style="font:10px tahoma;"><em>during the course of the    proposed prosedure (s) unforeseen conditions may be revealed requiring the    performance of prosedures</em></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="11" style="font:10px tahoma;"><em>specifically related to    the consented surgery and I authorize such procedures to be performed. I    futher acknowledge that no</em></td>
            <td></td>
            <td></td>
          </tr>
          <tr height="17">
            <td height="17">&nbsp;</td>
            <td colspan="8" style="font:10px tahoma;"><em>guarantee or promises    have been given to me concerning the result of any procedure</em></td>
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
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" style="font:12px tahoma;">
      <tr>
        <td><table width="809" border="0" style="border:1px solid #000000;">
            <tr>
              <td><table cellspacing="0" cellpadding="0">
                  <col width="27" />
                  <col width="43" />
                  <col width="33" />
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
                    <td height="20" width="27">&nbsp;</td>
                    <td width="43"></td>
                    <td width="33"></td>
                    <td width="138"></td>
                    <td width="20"></td>
                    <td width="64"></td>
                    <td width="51"></td>
                    <td width="99"></td>
                    <td width="13"></td>
                    <td width="92"></td>
                    <td width="49"></td>
                    <td width="58"></td>
                    <td width="54"></td>
                    <td width="37"></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="3">PERSETUJUAN:</td>
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
                    <td colspan="5">Disetujui oleh pasien /    <em>Consent by patient</em></td>
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
                    <td colspan="6">Medan, <?php echo date("j F Y")?></td>
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
                    <td colspan="2">&nbsp;</td>
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
                    <td colspan="5"><strong><u><?=$dP['nama'];?></u></strong></td>
                    <td></td>
                    <td></td>
                    <td colspan="5">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="3">Tanda tangan dan nama    jelas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5">Tanda tangan saksi    keluarga dan nama jelas</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="2"><em>Signature and Full Name</em></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><em>Signature of family    witness and full name</em></td>
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
                    <td colspan="5"><strong><u><?=$dP['dr_rujuk'];?></u></strong></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><label>
                      <input name="saksirs" type="text" id="saksirs" size="40" />
                    </label></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="4">Tanda tangan dokter dan    nama jelas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5">Tanda tangan saksi pihak    RSUD dan nama jelas</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="4"><em>Signature of doctor and    Full Name</em></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><em>Signature of hospital    witness and full name</em></td>
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
        </table></td>
      </tr>
      <tr>
        <td><table width="809" border="0" style="border:1px solid #000000;">
            <tr>
              <td><table cellspacing="0" cellpadding="0">
                  <col width="27" />
                  <col width="43" />
                  <col width="33" />
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
                    <td height="20" width="27">&nbsp;</td>
                    <td width="43"></td>
                    <td width="33"></td>
                    <td width="138"></td>
                    <td width="20"></td>
                    <td width="64"></td>
                    <td width="51"></td>
                    <td width="99"></td>
                    <td width="13"></td>
                    <td width="92"></td>
                    <td width="49"></td>
                    <td width="58"></td>
                    <td width="54"></td>
                    <td width="37"></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="12">Bila pasien&nbsp; berusia dibawah 21 tahun atau tidak dapat    memberikan persetujuan karena suatu alasan (*) tidak dapat</td>
                    <td></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="13">menandatangani surat    diatas, pihak Rumah Sakit dapat mengambil kebijaksanaan dengan memperoleh    tanda tangan dari&nbsp;</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="7">orang tua, pasangan,    anggota keluarga terdekat atau wali pasien.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td colspan="13"><em>Where the patient is    below 21 years old or invalid or for some other reason, unable to sign the    above, the hospital reserves the discretion</em></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td colspan="7"><em>to obtain the signature    of parent, spouse, next of kin or guardian of the patient</em></td>
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
                    <td colspan="13">* Jelaskan alasan</td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td colspan="3">* <em>Specify such other reason</em></td>
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
                    <td colspan="13"><label>
                      <textarea name="alasan" cols="60" rows="3" id="alasan"></textarea>
                    </label></td>
                    </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="13">&nbsp;</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td colspan="13">Saya orang tua /    pasangan / keluarga dekat / wali (coret yang tidak perlu) dari    pasien: 
                      <?=$dP['nama'];?></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td colspan="7"><em>I the parent /spouse /    next of kin guardian (delete where applicable) of the patient</em></td>
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
                    <td>-</td>
                    <td colspan="11">Membenarkan bahwa saya    memiliki hak untuk menandatangani Surat Persetujuan atas nama pasien</td>
                    <td></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td></td>
                    <td colspan="8"><em>Confirm that I have    authority to sign the consent form on behalf of the patient</em></td>
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
                    <td>-</td>
                    <td colspan="9">Telah membaca, memahami    dan menerima semua informasi pada Surat Persetujuan ini</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td></td>
                    <td colspan="6"><em>Have read and understand    and accept all information on this consent form</em></td>
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
                    <td>-</td>
                    <td colspan="11">Memastikan bahwa saya    telah diberikan penjelasan dan mengerti dengan baik tentang tidakan tersebut</td>
                    <td></td>
                  </tr>
                  <tr height="17">
                    <td height="17">&nbsp;</td>
                    <td></td>
                    <td colspan="10"><em>Confirm that I have been    explained and fully understand about the treatment/procedure to be performed</em></td>
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
                    <td colspan="5">Disetujui oleh pasien /    <em>Consent by patient</em></td>
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
                    <td colspan="6">Medan, <?php echo date("j F Y")?></td>
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
                    <td colspan="2">&nbsp;</td>
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
                    <td colspan="5"><strong><u><?=$dP['nama'];?></u></strong></td>
                    <td></td>
                    <td><?php list($saksi1, $saksi22) = explode('*|*', $dP['saksi2']); ?></td>
                    <td colspan="5"><label><?=$saksi1?>
                        <input name="saksi1" type="hidden" id="saksi1" size="40"  disabled="disabled"/>
                    </label></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="3">Tanda tangan dan nama    jelas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5">Tanda tangan saksi 1    keluarga dan nama jelas</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="2"><em>Signature and Full Name</em></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><em>Signature of family    witness and full name</em></td>
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
                    <td colspan="5"><strong><u><?=$dP['dr_rujuk'];?></u></strong></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><label><?=$saksi22?>
                        <input name="saksi2" type="hidden" id="saksi2" size="40" disabled="disabled"/>
                    </label></td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="4">Tanda tangan dokter dan    nama jelas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5">Tanda tangan saksi 2    keluarga dan nama jelas</td>
                  </tr>
                  <tr height="20">
                    <td height="20">&nbsp;</td>
                    <td></td>
                    <td colspan="4"><em>Signature of doctor and    Full Name</em></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5"><em>Signature of family    witness and full name</em></td>
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
                    <td height="20" colspan="14" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
                    </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</div>

<div id="tampil_data">
<table width="1188" border="0" align="center" cellpadding="2" cellspacing="0">
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
  <tr>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php
                    if($_REQUEST['report']!=1){
					?><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/><?php }?></td>
    <td width="24%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
    <td width="2%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" align="center"><div id="gridbox" style="width:700px; height:300px; background-color:white; overflow:hidden;"></div>      
      <div id="paging" style="width:700px;"></div></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="54%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script type="text/javascript">
        function simpan(action){
            if(ValidateForm('id_tindakan1,id_tindakan2,resiko,saksirs,alasan')){
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
        
        /*function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }*/

        //isiCombo('cakupan','','','cakupan','');

        /*function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }*/

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			 var p="id*-*"+sisip[0]+"*|*id_tindakan1*-*"+sisip[1]+"*|*id_tindakan2*-*"+sisip[2]+"*|*resiko*-*"+sisip[3]+"*|*alasan*-*"+sisip[4]+"*|*saksi1*-*"+sisip[5]+"*|*saksi2*-*"+sisip[6]+"*|*saksirs*-*"+sisip[7]+"";
			 
			 $('#resiko').val(sisip[3]);
			 $('#alasan').val(sisip[4]);
			 
            fSetValue(window,p);
        }

        
		function tambah()
		{
			document.getElementById('form1').reset();
			$('#form_input').slideDown(1000,function(){
		//toggle();
		});
			$('#tampil_data').slideUp(1000);
			$('#act').val('tambah');
		}
		
		function edit()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk di update");
				}
				else
				{
					$('#act').val('edit');
					$('#form_input').slideDown(1000,function()
					{
						//toggle();
					});
					
				}
        }
		
		function hapus()
		{
            var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(id=='')
				{
					alert("Pilih data terlebih dahulu untuk dihapus");
				}
				else if(confirm("Anda yakin menghapus data ini ?"))
				{
					$('#act').val('hapus');
					$("#form1").ajaxSubmit(
							{
					  success:function(msg)
							{
						alert(msg);
						goFilterAndSort();
						
					  		},
						});
				}
				else
				{
					document.getElementById('id').value="";
				}
        }

        function batal()
		{
			$('#form_input').slideUp(1000,function(){
		//toggle();
		});
			$('#tampil_data').slideDown(1000);
			document.getElementById('id').value="";
			//$('#gridbox').reset();
        }
		
		/*function resetF(){
			$('#act').val('tambah');
            var p="txtId*-**|*j_spher*-**|*j_cyl*-**|*j_axis*-**|*j_prism*-**|*j_base*-**|*j_spher2*-**|*j_cyl2*-**|*j_axis2*-**|*j_prism2*-**|*j_base2*-**|*j_pupil*-**|*d_spher*-**|*d_cyl*-**|*d_axis*-**|*d_prism*-**|*d_base*-**|*d_spher2*-**|*d_cyl2*-**|*d_axis2*-**|*d_prism2*-**|*d_base2*-**|*d_pupil*-*";
            fSetValue(window,p);
	
			}*/


        /*function konfirmasi(key,val)
		{
            //alert(val);
            var tangkap=val.split("*|*");
            
            if(key=='Error')
			{
                if(proses=='hapus')
				{				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else
			{
                if(proses=='tambah')
				{
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan')
				{
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus')
				{
                    alert('Hapus Berhasil');
                }
            }

        }*/

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("23.persetujuantindakanmedik_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Persetujuan Tindak Medik");
        a.setColHeader("NO,TINDAKAN,TINDAKAN ALTENATIF,RESIKO,ALASAN,SAKSI 1,SAKSI 2,SAKSI RSUD");
        a.setIDColHeader(",,,,,,,,,,,,,");
        a.setColWidth("20,150,150,150,150,80,80,80");
        a.setCellAlign("center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("23.persetujuantindakanmedik_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
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
				window.open("23.persetujuantindakanmedik.php?id="+id+"&idPel=<?=$idPel?>&idUser=<?=$idUser?>","_blank");
				document.getElementById('id').value="";
			}
			
		}*/
		function cetak(){
		 var rowid = document.getElementById("id").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		//window.open("4.srt_kenal_lahir.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
		window.open("23.persetujuantindakanmedik.php?id="+rowid+"&idPel=<?=$idPel?>&idUser=<?=$idUsr?>","_blank");
				//}
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
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

<?php
//session_start();
include("../../sesi.php");
?>
<?php
session_start();
include("../../koneksi/konek.php");
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$idPasien=$_REQUEST['idPasien'];
$id=$_REQUEST['id'];

if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}
$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser'"));
$sqlPas="SELECT mp.nama nmPas,
  no_rm,
  no_reg,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  mp.sex,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'Perempuan' 
    ELSE 'Laki - Laki' 
  END AS sex2,
  mk.nama kelas,
  md.nama AS diag,
  peg.nama AS dokter,
  kso.nama nmKso,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  un.nama nmUnit,
  p.no_lab,
  mp.tgl_lahir,
  DATE_FORMAT(mp.tgl_lahir, '%d %M %Y') tgllahir,
  peg1.nama AS dok_rujuk,
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  bpek.nama AS kerjaan,
  DATE_FORMAT(p.tgl_act, '%d %M %Y') tglawal,
  DATE_FORMAT(p.tgl_act, '%H:%i') jamawal,
  DATE_FORMAT(bkel.tgl_act, '%d %M %Y') tglmati,
  DATE_FORMAT(bkel.tgl_act, '%H:%i') jammati,
  peg3.nama dktrmati,
  bagm.agama,
  bmk.nama kelas,
  mp.no_ktp,
  mp.telp,
  
  bmata.tajamlihat,
  bmata.mata_kanan,
  bmata.mata_kiri,
  bmata.anterior_kanan,
  bmata.anterior_kiri,
  bmata.posterior_kanan,
  bmata.posterior_kiri,
  bmata.wrn_test,
  bmata.catatan
FROM
  b_kunjungan k
  INNER JOIN b_pelayanan p
    ON p.kunjungan_id = k.id 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id  
  INNER JOIN b_srt_ket_priksa_mata bmata
    ON bmata.pelayanan_id = p.id
  INNER JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  INNER JOIN b_ms_agama bagm 
    ON bagm.id = mp.agama
  INNER JOIN b_ms_unit un 
    ON un.id = p.unit_id
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
  INNER JOIN b_ms_kelas mk
    ON mk.id=p.kelas_id
  LEFT JOIN b_pasien_keluar bkel 
    ON bkel.pelayanan_id = p.id 
  LEFT JOIN b_ms_pegawai peg3 
    ON peg3.id = bkel.dokter_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id
  LEFT JOIN b_ms_kelas bmk
    ON bmk.id = p.kelas_id
WHERE k.id='$idKunj' AND p.id='$idPel' AND bmata.periksa_id='$id'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Surat Keterangan Periksa Mata :.</title>
</head>
<style>

.bwh{
	border-bottom:1px solid #000000;
}

</style>
<body>
<form id="form1" name="form1" action="" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
<table width="500">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="23" />
      <col width="24" />
      <col width="189" />
      <col width="17" />
      <col width="64" />
      <col width="33" />
      <col width="64" />
      <col width="77" />
      <col width="64" />
      <col width="68" />
      <tr>
        <td colspan="11" align="center" valign="top"><img src="surat_ket_periksa_mata_clip_image004.png" alt="" width="393" height="62" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              </tr>
          </table></td>
        </tr>
      <tr>
        <td width="11"></td>
        <td width="11"></td>
        <td width="99"></td>
        <td width="8"></td>
        <td width="33"></td>
        <td width="17"></td>
        <td width="33"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="11" align="center"><b>SURAT KETERANGAN</b></td>
        </tr>
      <tr>
        <td colspan="11" align="center" valign="top"><b>PEMERIKSAAN MATA</b></td>
        </tr>
      <tr>
        <td colspan="9" align="right" valign="top"></td>
        <td width="30">&nbsp;</td>
        <td width="358" valign="bottom" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><?php echo $isi['nmPas'];?>&nbsp;/&nbsp;<?php echo $isi['sex'];?></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo $isi['tgllahir'];?>&nbsp;/ Usia: <?php echo $isi['umur_thn'];?>&nbsp;Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><?php echo $isi['no_rm'];?>&nbsp;No.Registrasi: <?php echo $isi['no_reg'];?></td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><?php echo $isi['nmUnit'];?>&nbsp;/ <?php echo $isi['kelas'];?></td>
          </tr>
          <tr>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td><?php echo $isi['alamat'];?>&nbsp;RT <?php echo $isi['rt'];?> / RW <?php echo $isi['rw'];?>, Desa <?php echo $isi['nmDesa'];?>, Kecamatan <?php echo $isi['nmKec'];?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    
    <table cellspacing="0" cellpadding="0" style="font:12px tahoma; border:1px solid #000;">
      <col width="23" />
      <col width="24" />
      <col width="189" />
      <col width="17" />
      <col width="64" />
      <col width="33" />
      <col width="64" />
      <col width="77" />
      <col width="64" />
      <col width="68" />
      <tr>
        <td colspan="7">Yang bertanda tangan di bawah ini, menerangkan bahwa :</td>
        <td width="131"></td>
        <td width="8"></td>
        <td width="41"></td>
      </tr>
      <tr>
        <td width="12"></td>
        <td width="1"></td>
        <td width="114"></td>
        <td width="9"></td>
        <td width="68"></td>
        <td width="89"></td>
        <td width="4"></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Nama</td>
        <td>:</td>
        <td colspan="3" class="bwh"><?php echo $isi['nmPas'];?></td>
        <td colspan="3" align="left" valign="top">&nbsp;<span style="padding:1px; border:1px #000 solid;"><?php if($isi['sex']=='L'){echo "&radic;";}else{echo "&times;";}?></span> Laki-laki&nbsp;&nbsp;&nbsp;<span style="padding:1px; border:1px #000 solid;"><?php if($isi['sex']=='L'){echo "&times;";}else{echo "&radic;";}?></span> Perempuan
        </td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td>No. RM</td>
        <td>:</td>
        <td colspan="3" align="left" valign="top" class="bwh">
              <?php echo $isi['no_rm'];?></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Usia</td>
        <td>:</td>
        <td colspan="3" class="bwh"><?php echo $isi['umur_thn'];?>&nbsp;tahun</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>No. KTP/Bukti diri</td>
        <td>:</td>
        <td colspan="6" class="bwh"><?php echo $isi['no_ktp'];?></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="6" class="bwh"><?php echo $isi['alamat'];?>&nbsp;RT <?php echo $isi['rt'];?> / RW <?php echo $isi['rw'];?>, Desa <?php echo $isi['nmDesa'];?>, Kecamatan <?php echo $isi['nmKec'];?></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Telepon</td>
        <td>:</td>
        <td colspan="6" class="bwh"><?php echo $isi['telp'];?></td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td colspan="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="8">Telah    dilakukan pemeriksaan pada matanya dengan hasil :</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>1.</td>
        <td colspan="2">Tajam penglihatan</td>
        <td>:</td>
        <td colspan="3" class="bwh"><label for="textfield" ></label>
          <?=$isi['tajamlihat'];?></td>
		<!--<td><label for="textfield"></label>
          <input type="text" name="tajamlihat" id="tajamlihat" size="5" value="<?=$isi['tajamlihat']?>"/></td>-->
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">Mata Kanan</td>
        <td>:</td>
        <td class="bwh"><?=$isi['mata_kanan'];?></td>
        <td colspan="5">&nbsp;<span <?php if($isi['kanan_kcmt']==2){echo 'style="text-decoration:line-through"';}?>>dengan</span> / <span <?php if($isi['kanan_kcmt']==1){echo 'style="text-decoration:line-through"';}?>>tanpa kacamata</span></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="2">Mata Kiri</td>
        <td>:</td>
        <td class="bwh"><?=$isi['mata_kiri'];?></td>
        <td colspan="3">&nbsp;<span <?php if($isi['kiri_kcmt']==2){echo 'style="text-decoration:line-through"';}?>>dengan</span> / <span <?php if($isi['kiri_kcmt']==1){echo 'style="text-decoration:line-through"';}?>>tanpa kacamata</span></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>2.</td>
        <td colspan="2">Segment. Anterior</td>
        <td>:</td>
        <td colspan="2"><label for="anterior1"></label>
          - Mata Kanan</td>
        <td colspan="4" class="bwh"><?=$isi['anterior_kanan'];?></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"><label for="anterior1"></label>
          - Mata Kiri</td>
        <td colspan="4" class="bwh"><?=$isi['anterior_kiri'];?></td>
        </tr>
      <tr>
        <td>3.</td>
        <td colspan="2">Segment. Posterior</td>
        <td>:</td>
        <td colspan="2"><label for="anterior1"></label>
          - Mata Kanan</td>
        <td colspan="4" class="bwh"><?=$isi['posterior_kanan'];?></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"><label for="anterior1"></label>
          - Mata Kiri</td>
        <td colspan="4" class="bwh"><?=$isi['posterior_kiri'];?></td>
        </tr>
      <tr>
        <td valign="top">4.</td>
        <td colspan="2">Penglihatan warna (Test Ishihara)</td>
        <td>:</td>
        <td colspan="6" class="bwh"><?=$isi['wrn_test'];?></td>
        </tr>
      <tr>
        <td>5.</td>
        <td colspan="2">Catatan</td>
        <td>:</td>
        <td colspan="6" rowspan="5" class="bwh"><label for="catatan"></label><?=$isi['catatan'];?></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">Pasien,</td>
        <td></td>
        <td></td>
        <td colspan="3">Dokter yang memeriksa,</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">(<strong><u><?php echo $isi['nmPas'];?></u></strong>)</td>
        <td></td>
        <td></td>
        <td colspan="3">(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3">Nama &amp; Tanda Tangan</td>
        <td></td>
        <td></td>
        <td colspan="3">Nama &amp; Tanda Tangan</td>
      </tr>
      <tr>
        <td colspan="10" class="noline" align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
                </td>
        </tr>
</table></form>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Surat Keterangan Periksa Mata ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function liat(){
		window.open("surat_ket_periksa_mata_view.php?id=<?=$idx?>&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>","_blank");
	}
function tutup(){
	window.close();
	}
        </script>
</html>
